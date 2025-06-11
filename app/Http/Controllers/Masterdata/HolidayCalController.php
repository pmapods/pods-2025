<?php

namespace App\Http\Controllers\Masterdata;

use DB;
use Auth;
use Hash;
use Mail;
use Crypt;
use Redirect;
use Validator;
use Carbon\Carbon;
use App\Mail\GlobalMail;
use App\Models\Employee;

use Illuminate\Http\Request;
use App\Models\HolidayCalendar;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\StreamedResponse;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class HolidayCalController extends Controller
{
    // HOLIDAY CALENDAR
    public function holidayCalView()
    {
        $hol_cal = HolidayCalendar::whereNull('deleted_at')
            ->where('notes', '!=', 'example')
            ->get()
            ->sortBy('holiday_date');
        return view('Masterdata.holidaycalendar', compact('hol_cal'));
    }
    public function addHolidayCal(Request $request)
    {   
        $hol_cal_check          = HolidayCalendar::where('holiday_date', $request->holiday_date)->where('notes', '!=', 'example')->first();
        if ($hol_cal_check) {
            return back()->with('error','Holiday Date sudah terdaftar '.$hol_cal_check->holiday_date.' -- '.$hol_cal_check->notes);
        } else {
            $newHoliday                     = new HolidayCalendar;
            $newHoliday->holiday_date       = $request->holiday_date;
            $newHoliday->notes              = $request->keterangan;
            $newHoliday->save();
        }
        return back()->with('success', 'Berhasil menambahkan Holiday ' . $request->name);
    }
    public function updateHolidayCal(Request $request)
    {
        try {
            $hol_cal                    = HolidayCalendar::where('id', $request->holiday_id)->first();
            $hol_cal->holiday_date      = $request->holiday_date;
            $hol_cal->notes             = $request->keterangan;
            $hol_cal->save();
            return back()->with('success', 'Berhasil menguban master holiday menjadi ' . $hol_cal->holiday_date . ' || ' . $hol_cal->notes);
        } catch (\Exception $ex) {
            return back()->with('error', 'Gagal mengubah master holiday, silahkan coba kembali atau hubungi developer "' . $ex->getMessage() . '"');
        }
    }
    public function deleteHolidayCal(Request $request)
    {
        try {
            $hol_cal           = HolidayCalendar::where('holiday_date', $request->holiday_date)->first();
            $hol_cal->delete();
            return back()->with('success', 'Berhasil menghapus holiday ' . $hol_cal->holiday_date . ' -- ' . $hol_cal->notes);
        } catch (\Exception $ex) {
            return back()->with('error', 'Gagal menghapus holiday, silahkan coba kembali atau hubungi developer "' . $ex->getMessage() . '"');
        }
    }
    public function getHolidayCalTemp()
    {
        $spreadsheet = new Spreadsheet();
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("template/holiday_calendar_template.xlsx");

        // TEMPLATE HOLIDAY
        $holdCalSheet = $spreadsheet->getSheetByName('TEMPLATE HOLIDAY');
        $hold_cal = HolidayCalendar::where('notes', 'example')->get()->sortBy('holiday_date');
        $count_row = 2;
        foreach ($hold_cal as $hold_cal) {
            $dateValue = Date::PHPToExcel($hold_cal->holiday_date);
            $holdCalSheet->setCellValue('A' . $count_row, Carbon::parse($hold_cal->holiday_date)->translatedFormat('d/m/Y'));
            $holdCalSheet->getStyle('A1')
                ->getNumberFormat()
                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);
            $holdCalSheet->setCellValue('C' . $count_row, $hold_cal->notes);
            $count_row++;   
        }
        $start_holiday_row = 2;
        $end_holiday_row = $count_row;

        $writer = new Xlsx($spreadsheet);
        $response =  new StreamedResponse(
            function () use ($writer) {
                $writer->save('php://output');
            }
        );
        ob_end_clean();
        $response->headers->set('Content-Type', 'application/vnd.ms-excel');
        $response->headers->set('Content-Disposition', 'attachment;filename="Holiday Calendar Template.xlsx"');
        $response->headers->set('Cache-Control', 'max-age=0');
        return $response;
    }

    public function readHolidayCalTemp(Request $request)
    {
        try {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $spreadsheet = $reader->load($request->file('file')->getPathName());

            $sheetData = $spreadsheet->getActiveSheet()->toArray();

            $list = [];
            $errorlist = [];
            $count_id = 0;
            foreach ($sheetData as $t) {
                try {
                    $holiday_date = $t[0];
                    $holiday_date_before = $t[1];
                    $keterangan = $t[2];
                    
                    if ($holiday_date == '' || $keterangan == '') {
                        throw new \Throwable;
                        continue;
                    }

                    $data = new \stdClass();
                    $data->holiday_date             = $holiday_date;
                    $data->holiday_date_before      = $holiday_date_before;
                    $data->notes                    = $keterangan;
                    array_push($list, $data);
                    $count_id++;
                } catch (\Throwable $th) {
                    $error = [
                        "holiday_date" => $t[0] ?? "",
                        "holidholiday_date_beforeay_date" => $t[1] ?? "",
                        "keterangan" => $t[2] ?? ""
                    ];
                    // pastiin error bukan karna qty dan valuenya null / memang tidak diisi
                    if ($error['holiday_date'] != null || $error['notes'] != null) {
                        array_push($errorlist, $error);
                    }
                    continue;
                }
            }

            return response()->json([
                'error' => false,
                'data' => $list,
                'errordata' => $errorlist
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'error' => true,
                'message' => $ex->getMessage(),
                'line' => $ex->getLine(),
                'exception' => $ex
            ]);
        }
    }

    public function uploadHolidayCal(Request $request)
    {
        try {
            $datalist = json_decode($request->holiday_list);
            $current_time = now();

            foreach ($datalist as $key => $datalist) {
                // Tanggal Update/Baru
                $time = strtotime($datalist->holiday_date);
                $holiday_date = date('Y-m-d', $time);

                if ($datalist->holiday_date_before) {
                    // Tanggal Sebelum
                    $timeBfr = strtotime($datalist->holiday_date_before);
                    $holiday_date_before = date('Y-m-d', $timeBfr);

                    $checkBfr = HolidayCalendar::where('holiday_date', $holiday_date_before)
                    ->where('notes', '!=', 'example')
                    ->whereNull('deleted_at')
                    ->first();

                    if ($checkBfr) {
                        $checkAgain = HolidayCalendar::where('holiday_date', $holiday_date)
                        ->where('notes', '!=', 'example')
                        ->whereNull('deleted_at')
                        ->first();

                        if ($checkAgain) {
                            return back()->with('error','Holiday Date sudah terdaftar '.$checkAgain->holiday_date.' -- '.$checkAgain->notes);
                        } else {
                            $checkBfr->delete();

                            $newHoliday                   = new HolidayCalendar;
                            $newHoliday->holiday_date     = $holiday_date;
                            $newHoliday->notes            = $datalist->notes;
                            $newHoliday->save();
                        }
                    }
                } else {
                    $check = HolidayCalendar::where('holiday_date', $holiday_date)
                    ->where('notes', '!=', 'example')
                    ->whereNull('deleted_at')
                    ->first();

                    if ($check) {
                        $check->holiday_date     = $holiday_date;
                        $check->notes            = $datalist->notes;
                        $check->updated_at       = $current_time;
                        $check->save();
                    } else {
                        $newHoliday                   = new HolidayCalendar;
                        $newHoliday->holiday_date     = $holiday_date;
                        $newHoliday->notes            = $datalist->notes;
                        $newHoliday->save();
                    }
                }
            }

            return back()->with('success', 'Berhasil melakukan upload master holiday');
        } catch (\Exception $ex) {
            return back()->with('error', 'Gagal melakukan upload master holiday  "' . $ex->getMessage() . '"');
        }
    }
}
