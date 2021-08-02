<?php

namespace App\Http\Controllers\Operational;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use DB;

use App\Models\Ticket;
use App\Models\Armada;
use App\Models\ArmadaTicket;
use App\Models\FacilityForm;
use App\Models\FacilityFormAuthorization;
use App\Models\Authorization;
use App\Models\ArmadaTicketAuthorization;
use App\Models\EmployeePosition;
use App\Models\EmployeeLocationAccess;
use App\Models\SalesPoint;

    class ArmadaTicketingController extends Controller
{
    public function createArmadaticket(Request $request){
        try {
            DB::beginTransaction();
            $armada_ticket_count = ArmadaTicket::whereBetween('created_at', [
                Carbon::now()->startOfYear(),
                Carbon::now()->endOfYear(),
            ])
            ->withTrashed()
            ->count();

            $barang_ticket_count = Ticket::whereBetween('created_at', [
                Carbon::now()->startOfYear(),
                Carbon::now()->endOfYear(),
            ])
            ->where('status','>',0)
            ->withTrashed()
            ->count();

            $total_count = $armada_ticket_count + $barang_ticket_count;
            do {
                $code = "PCD-".now()->translatedFormat('ymd').'-'.str_repeat("0", 4-strlen($total_count+1)).($total_count+1);
                $total_count++;
                $checkbarang = Ticket::where('code',$code)->first();
                $checkarmada = ArmadaTicket::where('code',$code)->first();
                ($checkbarang != null || $checkarmada != null) ? $flag = false : $flag = true;
            } while (!$flag);

            $newTicket                   = new ArmadaTicket;
            $newTicket->code             = $code;
            $newTicket->requirement_date = $request->requirement_date;
            $newTicket->salespoint_id    = $request->salespoint_id;
            $newTicket->isNiaga          = $request->isNiaga;
            $newTicket->ticketing_type   = $request->pengadaan_type;
            if($newTicket->ticketing_type == 0){
                $newTicket->armada_type_id   = $request->armada_type_id;
            }
            if(in_array($newTicket->ticketing_type,[1,2,3])){
                $newTicket->armada_type_id   = Armada::find($request->armada_id)->armada_type->id;
                $newTicket->armada_id        = $request->armada_id;
            }
            $newTicket->created_by       = Auth::user()->id;
            $newTicket->save();

            $authorization = Authorization::findOrFail($request->authorization_id);
            foreach ($authorization->authorization_detail as $key => $authorization) {
                $newAuthorization                    = new ArmadaTicketAuthorization;
                $newAuthorization->armada_ticket_id  = $newTicket->id;
                $newAuthorization->employee_id       = $authorization->employee_id;
                $newAuthorization->employee_name     = $authorization->employee->name;
                $newAuthorization->as                = $authorization->sign_as;
                $newAuthorization->employee_position = $authorization->employee_position->name;
                $newAuthorization->level             = $key+1;
                $newAuthorization->save();
            }
            DB::commit();
            return redirect('/ticketing')->with('success','Berhasil membuat ticketing armada');
        } catch (\Exception $ex) {
            DB::rollback();
            dd($ex);
            return back()->with('error','Gagal membuat ticketing armada ('.$ex->getMessage().')');
        }
    }

    public function armadaTicketDetail(Request $request, $code){
        $armadaticket = ArmadaTicket::where('code',$code)->first();

        $employee_positions = EmployeePosition::all();

        $user_location_access  = EmployeeLocationAccess::where('employee_id',Auth::user()->id)->get()->pluck('salespoint_id');
        $available_salespoints = SalesPoint::whereIn('id',$user_location_access)->get();
        $available_salespoints = $available_salespoints->groupBy('region');

        $formperpanjangan_authorizations = Authorization::where('salespoint_id',$armadaticket->salespoint_id)->where('form_type',6)->get();
        $formfasilitas_authorizations = Authorization::where('salespoint_id',$armadaticket->salespoint_id)->where('form_type',4)->get();
        try { 
            if(!$armadaticket){
                throw new \Exception('Ticket armada dengan kode '.$code.'tidak ditemukan');
            }
            return view('Operational.Armada.armadaticketdetail',compact('armadaticket','employee_positions','available_salespoints','formperpanjangan_authorizations','formfasilitas_authorizations'));
        } catch (\Exception $ex) {
            return redirect('/ticketing')->with('error','Gagal membukan detail ticket armada '.$ex->getMessage());
        }
    }

    public function addFacilityForm(Request $request){
        try{
            DB::beginTransaction();
            $armadaticket = ArmadaTicket::find($request->armada_ticket_id);

            $salespoint_initial = $armadaticket->salespoint->initial;
            $currentmonth = date('m');
            $currentyear = date('Y');
            $count = FacilityForm::join('armada_ticket','facility_form.armada_ticket_id','armada_ticket.id')
            ->where('armada_ticket.salespoint_id',$armadaticket->salespoint->id)
                ->whereYear('facility_form.created_at', Carbon::now()->year)
                ->whereMonth('facility_form.created_at', Carbon::now()->month)
                ->withTrashed()
                ->count();
                
            do{
                $flag = true;
                $code = $salespoint_initial.'/'.$count.'/FF/'.numberToRoman(intval($currentmonth)).'/'.$currentyear;
                $count++;
                $checkFacilityForm = FacilityForm::where('code', $code)->first();
                if($checkFacilityForm != null){
                    $flag = false;
                }
            }while(!$flag);

            $form                       = new FacilityForm;
            $form->armada_ticket_id     = $request->armada_ticket_id;
            $form->salespoint_id        = $request->salespoint_id;
            $form->code                 = $code;
            $form->nama                 = $request->nama;
            $form->divisi               = $request->divisi;
            $form->phone                = $request->phone;
            $form->jabatan              = $request->jabatan;
            $form->tanggal_mulai_kerja  = $request->tanggal_mulai_kerja;
            $form->golongan             = $request->golongan;
            $form->status_karyawan      = $request->status_karyawan;
            $form->facilitylist         = json_encode($request->fasilitasdanperlengkapan);
            $form->notes                = $request->notes;
            $form->created_by           = Auth::user()->id;
            $form->save();

            $authorization = Authorization::find($request->authorization_id);
            foreach($authorization->authorization_detail as $detail){
                $newAuthorization                     = new FacilityFormAuthorization;
                $newAuthorization->facility_form_id   = $form->id;
                $newAuthorization->employee_id        = $detail->employee_id;
                $newAuthorization->employee_name      = $detail->employee->name;
                $newAuthorization->as                 = $detail->sign_as;
                $newAuthorization->employee_position  = $detail->employee_position->name;
                $newAuthorization->level              = $detail->level;
                $newAuthorization->save();
            }
            DB::commit();
            return back()->with('success', 'Berhasil membuat form fasilitas. Menunggu Otorisasi oleh '.$authorization->authorization_detail->first()->employee->name);
        }catch(Exception $ex){
            DB::rollback();
            dd($ex);
            return back()->with('error', 'Gagal membuat form fasilitas');
        }
    }

    public function approveFacilityForm(Request $request){
        try {
            DB::beginTransaction();
            $facility_form = FacilityForm::findOrFail($request->facility_form_id);
            if($facility_form->current_authorization()->employee_id != Auth::user()->id){
                return back()->with('error','Login tidak sesuai dengan otorisasi');
            }
            $authorization = $facility_form->current_authorization();
            $authorization->status = 1;
            $authorization->save();

            // recall the new one
            $authorization = $facility_form->current_authorization();
            if($authorization == null){
                $facility_form->status = 1;
                $facility_form->save();
            }
            DB::commit();
            if($authorization == null){
                return back()->with('success','Seluruh Otorisasi Form fasilitas telah selesai');
            }else{
                return back()->with('success','Berhasil melakukan otorisasi, Otorisasi selanjutnya oleh '.$authorization->employee_name);
            }
        } catch (Exception $ex) {
            DB::rollback();
            dd($ex);
            return back()->with('error', 'Gagal melakukan otorisasi form fasilitas');
        }
    }

    public function uploadBASTK(Request $request){
        try{
            DB::beginTransaction();
            $armadaticket = ArmadaTicket::findOrFail($request->arnada_ticket_id);

            $salespointname = str_replace(' ','_',$armadaticket->salespoint->name);
            $ext = pathinfo($request->file('bastk_file')->getClientOriginalName(), PATHINFO_EXTENSION);
            $name = "BASTK_".$salespointname.'.'.$ext;
            $path = "/attachments/ticketing/barangjasa/".$armadaticket->code.'/'.$name;
            $file = pathinfo($path);
            $path = $request->file('bastk_file')->storeAs($file['dirname'],$file['basename'],'public');
            $armadaticket->bastk_path = $path;
            $armadaticket->finished_date = date('Y-m-d');
            $armadaticket->status = 6;
            $armadaticket->save();

            DB::commit();
            return back()->with('success','Berhasil melakukan upload file BASTK');
        }catch(\Exception $ex){
            dd($ex);
            DB::rollback();
            return back()->with('error','Berhasil melakukan upload file BASTK');
        }
    }

    public function startArmadaAuthorization(Request $request) {
        try {
            $armadaticket = ArmadaTicket::findOrFail($request->armada_ticket_id);
            if($armadaticket->updated_at != $request->updated_at){
                return back()->with('error','Data terbaru sudah diupdate. Silahkan coba kembali');
            }else{
                $armadaticket->status += 1;
                $armadaticket->save();
            }
            return back()->with('success','Berhasil memulai otorisasi pengadaan armada '.$armadaticket->code.'. Otorisasi selanjutnya oleh '.$armadaticket->current_authorization()->employee_name);
        } catch (\Exception $ex) {
            dd($ex);
            return back()->with('error','Gagal memulai otorisasi '.$ex->getMessage());
        }
    }

    public function approveArmadaAuthorization(Request $request){
        try {
            DB::beginTransaction();
            $armadaticket = ArmadaTicket::findOrFail($request->armada_ticket_id);
            $current_authorization = $armadaticket->current_authorization();
            if($current_authorization->employee_id != Auth::user()->id){
                return back()->with('error','Otorisasi saat ini tidak sesuai dengan akun login.');
            }else{
                $current_authorization->status += 1;
                $current_authorization->save();
            }

            $current_authorization = $armadaticket->current_authorization();
            if($current_authorization == null){
                $armadaticket->status += 1;
                $armadaticket->save();
                DB::commit();
                return back()->with('success','Otorisasi pengadaan armada '.$armadaticket->code.' telah selesai.');
            }else{
                DB::commit();
                return back()->with('success','Berhasil melakukan approval otorisasi pengadaan armada '.$armadaticket->code.'. Otorisasi selanjutnya oleh '.$armadaticket->current_authorization()->employee_name);
            }
        } catch (\Exception $ex) {
            DB::rollback();
            dd($ex);
            return back()->with('error','Gagal memulai otorisasi '.$ex->getMessage());
        }
    }
}
