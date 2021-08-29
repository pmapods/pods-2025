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
use App\Models\SecurityTicket;
use App\Models\ArmadaTicketMonitoring;
use App\Models\FacilityForm;
use App\Models\FacilityFormAuthorization;
use App\Models\PerpanjanganForm;
use App\Models\PerpanjanganFormAuthorization;
use App\Models\MutasiForm;
use App\Models\MutasiFormAuthorization;
use App\Models\Authorization;
use App\Models\ArmadaTicketAuthorization;
use App\Models\EmployeePosition;
use App\Models\EmployeeLocationAccess;
use App\Models\SalesPoint;
use App\Models\Po;

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
            
            $security_ticket_count = SecurityTicket::whereBetween('created_at', [
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

            

            $total_count = $armada_ticket_count + $security_ticket_count + $barang_ticket_count;
            do {
                $code = "PCD-".now()->translatedFormat('ymd').'-'.str_repeat("0", 4-strlen($total_count+1)).($total_count+1);
                $total_count++;
                $checkbarang = Ticket::where('code',$code)->first();
                $checkarmada = ArmadaTicket::where('code',$code)->first();
                $checksecurity = SecurityTicket::where('code',$code)->first();
                ($checkbarang != null || $checkarmada != null || $checksecurity != null) ? $flag = false : $flag = true;
            } while (!$flag);

            $newTicket                   = new ArmadaTicket;
            $newTicket->code             = $code;
            $newTicket->requirement_date = $request->requirement_date;
            $newTicket->salespoint_id    = $request->salespoint_id;
            $newTicket->isNiaga          = $request->isNiaga;
            $newTicket->ticketing_type   = $request->pengadaan_type;
            $newTicket->vendor_recommendation_name   = $request->vendor_recommendation_name;
            if($newTicket->ticketing_type == 0){
                $newTicket->armada_type_id   = $request->armada_type_id;
            }
            if(in_array($newTicket->ticketing_type,[1,2,3])){
                $po = Po::where('no_po_sap',$request->po_id)->first();
                $newTicket->armada_type_id      = $po->armada_ticket->armada_type_id;
                $newTicket->armada_id           = $po->armada_ticket->armada_id;
                $newTicket->po_reference_number = $po->no_po_sap;
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
            return redirect('/ticketing?menu=Armada')->with('success','Berhasil membuat ticketing armada');
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
        $formmutasi_authorizations = Authorization::where('salespoint_id',$armadaticket->salespoint_id)->where('form_type',5)->get();
        $po = Po::where('no_po_sap',$armadaticket->po_reference_number)->first();
        $salespoints = SalesPoint::all();

        $available_armadas = Armada::where('salespoint_id',$armadaticket->salespoint_id)
                                ->where('armada_type_id',$armadaticket->armada_type_id)
                                ->where('status',0)
                                ->get();
        try { 
            if(!$armadaticket){
                throw new \Exception('Ticket armada dengan kode '.$code.'tidak ditemukan');
            }
            return view('Operational.Armada.armadaticketdetail',compact('armadaticket','employee_positions','available_salespoints','formperpanjangan_authorizations','formfasilitas_authorizations','available_armadas','formmutasi_authorizations','salespoints','po'));
        } catch (\Exception $ex) {
            return redirect('/ticketing?menu=Armada')->with('error','Gagal membukan detail ticket armada '.$ex->getMessage());
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
        }catch(\Exception $ex){
            DB::rollback();
            return back()->with('error', 'Gagal membuat form fasilitas');
        }
    }

    public function addPerpanjanganForm(Request $request){
        try{
            DB::beginTransaction();

            $form                   = new PerpanjanganForm;
            $form->armada_ticket_id = $request->armada_ticket_id;
            $form->salespoint_id    = $request->salespoint_id;
            $form->armada_id        = $request->armada_id;
            $form->nama             = $request->name;
            $form->nik              = $request->nik;
            $form->jabatan          = $request->jabatan;
            $form->nama_salespoint  = $request->salespoint_name;
            $form->tipe_armada      = $request->armada_type;
            $form->jenis_kendaraan  = $request->jenis_kendaraan;
            $form->nopol            = $request->nopol;
            $form->unit             = $request->unit;
            $form->is_vendor_lokal  = ($request->lokal_vendor_name != null) ? true : false;
            $form->nama_vendor      = ($form->is_vendor_lokal) ? $request->lokal_vendor_name : $request->vendor_name;
            $form->form_type        = $request->form_type;
            if($form->form_type == "perpanjangan"){
                $form->perpanjangan_length = $request->perpanjangan_length;
            }
            if($form->form_type == "stopsewa"){
                $form->stopsewa_date = $request->stopsewa_date;
                $form->stopsewa_reason = $request->alasan;
            }
            $form->created_by       = Auth::user()->id;
            $form->save();

            $authorization = Authorization::find($request->authorization_id);
            foreach($authorization->authorization_detail as $detail){
                $newAuthorization                           = new PerpanjanganFormAuthorization;
                $newAuthorization->perpanjangan_form_id     = $form->id;
                $newAuthorization->employee_id              = $detail->employee_id;
                $newAuthorization->employee_name            = $detail->employee->name;
                $newAuthorization->as                       = $detail->sign_as;
                $newAuthorization->employee_position        = $detail->employee_position->name;
                $newAuthorization->level                    = $detail->level;
                $newAuthorization->save();
            }
            DB::commit();
            return back()->with('success', 'Berhasil membuat form perpanjangan perhentian. Menunggu Otorisasi oleh '.$authorization->authorization_detail->first()->employee->name);
        }catch(\Exception $ex){
            DB::rollback();
            dd($ex);
            return back()->with('error', 'Gagal membuat form fasilitas');
        }
    }

    public function addMutasiForm(Request $request){
        try{
            DB::beginTransaction();
            $armadaticket = ArmadaTicket::find($request->armada_ticket_id);
            $salespoint_initial = $armadaticket->salespoint->initial;
            $currentmonth = date('m');
            $currentyear = date('Y');

            $count = MutasiForm::join('armada_ticket','mutasi_form.armada_ticket_id','armada_ticket.id')
                ->where('armada_ticket.salespoint_id',$armadaticket->salespoint->id)
                ->whereYear('mutasi_form.created_at', Carbon::now()->year)
                ->whereMonth('mutasi_form.created_at', Carbon::now()->month)
                ->withTrashed()
                ->count();
                
            do{
                $flag = true;
                $code = $salespoint_initial.'/'.$count.'/MA/'.numberToRoman(intval($currentmonth)).'/'.$currentyear;
                $count++;
                $checkMutasiForm = MutasiForm::where('code', $code)->first();
                if($checkMutasiForm != null){
                    $flag = false;
                }
            }while(!$flag);
            $form                           = new MutasiForm;
            $form->armada_ticket_id         = $request->armada_ticket_id;
            $form->salespoint_id            = $request->salespoint_id;
            $form->receiver_salespoint_id   = $request->receive_salespoint_id;
            $form->armada_id                = $request->armada_id;
            $form->code                     = $code;
            $form->sender_salespoint_name   = $request->sender_salespoint_name;
            $receiver_salespoint_name = SalesPoint::find($request->receive_salespoint_id)->name;
            $form->receiver_salespoint_name = $receiver_salespoint_name;
            $form->mutation_date            = $request->mutation_date;
            $form->received_date            = $request->received_date;
            $form->nopol                    = $request->nopol;
            $form->vendor_name              = $request->vendor_name;
            $form->brand_name               = $request->merk;
            $form->jenis_kendaraan          = $request->jenis_kendaraan;
            $form->nomor_rangka             = $request->nomor_rangka;
            $form->nomor_mesin              = $request->nomor_mesin;
            $form->tahun_pembuatan          = $request->tahun_pembuatan;
            $form->stnk_date                = $request->stnk_date;
            $form->p3k                      = $request->p3k;
            $form->segitiga                 = $request->segitiga;
            $form->dongkrak                 = $request->dongkrak;
            $form->toolkit                  = $request->toolkit;
            $form->ban                      = $request->ban;
            $form->gembok                   = $request->gembok;
            $form->bongkar                  = $request->bongkar;
            $form->buku                     = $request->buku;
            $form->nama_tempat              = $request->nama_tempat;
            $form->created_by               = Auth::user()->id;
            $form->save();

            $authorization = Authorization::find($request->authorization_id);
            foreach($authorization->authorization_detail as $detail){
                $newAuthorization                           = new MutasiFormAuthorization;
                $newAuthorization->mutasi_form_id           = $form->id;
                $newAuthorization->employee_id              = $detail->employee_id;
                $newAuthorization->employee_name            = $detail->employee->name;
                $newAuthorization->as                       = $detail->sign_as;
                $newAuthorization->employee_position        = $detail->employee_position->name;
                $newAuthorization->level                    = $detail->level;
                $newAuthorization->save();
            }
            DB::commit();
            return back()->with('success', 'Berhasil membuat form mutasi. Menunggu Otorisasi oleh '.$authorization->authorization_detail->first()->employee->name);
        }catch(\Exception $ex){
            DB::rollback();
            dd($ex);
            return back()->with('error', 'Gagal membuat form mutasi');
        }
    }

    public function completeArmadaBookedBy(Request $request){
        try {
            DB::beginTransaction();
            foreach($request->armada as $armada){
                $available_armada               = Armada::find($armada['armada_id']);
                $available_armada->booked_by    = $armada['booked_by'];
                $available_armada->status       = 1;
                $available_armada->save();
            }
            DB::commit();
            return back()->with('success', 'Berhasil Melengkapi data available armada');
        } catch (\Exception $ex) {
            DB::rollback();
            dd($ex);
            return back()->with('error', 'Gagal Melengkapi data armada');
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

    public function rejectFacilityForm(Request $request){
        try {
            DB::beginTransaction();
            $facility_form = FacilityForm::findOrFail($request->facility_form_id);
            if($facility_form->current_authorization()->employee_id != Auth::user()->id){
                return back()->with('error','Login tidak sesuai dengan otorisasi');
            }
            
            $authorization = $facility_form->current_authorization();
            $authorization->status = -1;
            $authorization->save();

            $facility_form->status              = -1;
            $facility_form->terminated_by       = Auth::user()->id;
            $facility_form->termination_reason  = $request->reason;
            $facility_form->save();
            $facility_form->delete();

            DB::commit();
            if($authorization == null){
                return back()->with('success','Formulir fasilitas berhasil dibatalkan. Silahkan membuat formulir fasilitas baru');
            }else{
                return back()->with('success','Gagal membatalkan formulir fasilitas');
            }
        } catch (\Exception $ex) {
            DB::rollback();
            dd($ex);
            return back()->with('error', 'Gagal melakukan otorisasi form fasilitas');
        }
    }

    public function approvePerpanjanganForm(Request $request){
        try {
            DB::beginTransaction();
            $perpanjangan_form = PerpanjanganForm::findOrFail($request->perpanjangan_form_id);
            if($perpanjangan_form->current_authorization()->employee_id != Auth::user()->id){
                return back()->with('error','Login tidak sesuai dengan otorisasi');
            }
            $authorization = $perpanjangan_form->current_authorization();
            $authorization->status = 1;
            $authorization->save();

            // recall the new one
            $authorization = $perpanjangan_form->current_authorization();
            if($authorization == null){
                $perpanjangan_form->status = 1;
                $perpanjangan_form->save();
            }
            DB::commit();
            if($authorization == null){
                return back()->with('success','Seluruh Otorisasi Form Perpanjangan telah selesai');
            }else{
                return back()->with('success','Berhasil melakukan otorisasi formulit perpanjangan, Otorisasi selanjutnya oleh '.$authorization->employee_name);
            }
        } catch (Exception $ex) {
            DB::rollback();
            dd($ex);
            return back()->with('error', 'Gagal melakukan otorisasi form fasilitas');
        }
    }

    public function rejectPerpanjanganForm(Request $request){
        try {
            DB::beginTransaction();
            $perpanjangan_form = PerpanjanganForm::findOrFail($request->perpanjangan_form_id);
            if($perpanjangan_form->current_authorization()->employee_id != Auth::user()->id){
                return back()->with('error','Login tidak sesuai dengan otorisasi');
            }
            
            $authorization = $perpanjangan_form->current_authorization();
            $authorization->status = -1;
            $authorization->save();

            $perpanjangan_form->status              = -1;
            $perpanjangan_form->terminated_by       = Auth::user()->id;
            $perpanjangan_form->termination_reason  = $request->reason;
            $perpanjangan_form->save();
            $perpanjangan_form->delete();

            DB::commit();
            if($authorization == null){
                return back()->with('success','Formulir perpanjangan berhasil dibatalkan. Silahkan membuat formulir perpanjangan baru');
            }else{
                return back()->with('success','Gagal membatalkan formulir perpanjangan');
            }
        } catch (\Exception $ex) {
            DB::rollback();
            dd($ex);
            return back()->with('error', 'Gagal melakukan otorisasi form fasilitas');
        }
    }

    public function approveMutasiForm(Request $request){
        try {
            DB::beginTransaction();
            $mutasi_form = MutasiForm::findOrFail($request->mutasi_form_id);
            if($mutasi_form->current_authorization()->employee_id != Auth::user()->id){
                return back()->with('error','Login tidak sesuai dengan otorisasi');
            }
            $authorization = $mutasi_form->current_authorization();
            $authorization->status = 1;
            $authorization->save();

            // recall the new one
            $authorization = $mutasi_form->current_authorization();
            if($authorization == null){
                $mutasi_form->status = 1;
                $mutasi_form->save();
            }
            DB::commit();
            if($authorization == null){
                return back()->with('success','Seluruh Otorisasi Form Mutasi telah selesai');
            }else{
                return back()->with('success','Berhasil melakukan otorisasi formulit mutasi, Otorisasi selanjutnya oleh '.$authorization->employee_name);
            }
        } catch (\Exception $ex) {
            DB::rollback();
            dd($ex);
            return back()->with('error', 'Gagal melakukan otorisasi form fasilitas');
        }
    }

    public function rejectMutasiForm(Request $request){
        try {
            DB::beginTransaction();
            $mutasi_form = MutasiForm::findOrFail($request->mutasi_form_id);
            if($mutasi_form->current_authorization()->employee_id != Auth::user()->id){
                return back()->with('error','Login tidak sesuai dengan otorisasi');
            }
            
            $authorization = $mutasi_form->current_authorization();
            $authorization->status = -1;
            $authorization->save();

            $mutasi_form->status              = -1;
            $mutasi_form->terminated_by       = Auth::user()->id;
            $mutasi_form->termination_reason  = $request->reason;
            $mutasi_form->save();
            $mutasi_form->delete();

            DB::commit();
            if($authorization == null){
                return back()->with('success','Formulir mutasi berhasil dibatalkan. Silahkan membuat formulir mutasi baru');
            }else{
                return back()->with('success','Gagal membatalkan formulir mutasi');
            }
        } catch (\Exception $ex) {
            DB::rollback();
            dd($ex);
            return back()->with('error', 'Gagal melakukan otorisasi form fasilitas');
        }
    }

    public function uploadBASTK(Request $request){
        try{
            DB::beginTransaction();
            $armadaticket = ArmadaTicket::findOrFail($request->armada_ticket_id);

            if (in_array($armadaticket->type(),["Pengadaan","Replace","Renewal"])){
                $salespointname = str_replace(' ','_',$armadaticket->salespoint->name);
                $ext = pathinfo($request->file('bastk_file')->getClientOriginalName(), PATHINFO_EXTENSION);
                $name = "BASTK_".strtoupper($request->type)."_".$salespointname.'.'.$ext;
                $path = "/attachments/ticketing/armada/".$armadaticket->code.'/'.$name;
                $file = pathinfo($path);
                $path = $request->file('bastk_file')->storeAs($file['dirname'],$file['basename'],'public');
                $armadaticket->bastk_path = $path;
            }
            if(in_array($armadaticket->type(),['Replace','Renewal','End Kontrak'])){
                // hapus armada lama 
                $oldarmada = Armada::where('plate', $armadaticket->po_reference->armada_ticket->armada->plate)->first();
                if($oldarmada != null){
                    $oldarmada->status = 0;
                    $oldarmada->save();
                    $oldarmada->delete();
                }
            }
            if (in_array($armadaticket->type(), ['Perpanjangan','Replace','Renewal','Mutasi','End Kontrak'])) {
                // ubah status po lama ke closed(4)
                $old_po = $armadaticket->po_reference;
                $old_po->status = 4;
                $old_po->save();
            }

            $armadaticket->finished_date = date('Y-m-d');
            $armadaticket->status = 6;
            $armadaticket->save();

            if (in_array($armadaticket->type(), ['Pengadaan','Replace','Renewal'])) {
                // tambahkan armada ke master armada
                $armada_by_plate = Armada::where('plate', str_replace(' ', '', strtoupper($request->plate)))->first();
                if ($armada_by_plate) {
                    $newArmada                  = $armada_by_plate;
                } else {
                    $newArmada                  = new Armada;
                }

                if($request->plate == "" || $request->plate == null) {
                    throw new \Exception('Nomor Plat tidak boleh kosong.');
                }
                $newArmada->salespoint_id   = $armadaticket->salespoint_id;
                $newArmada->armada_type_id  = $armadaticket->armada_type_id;
                $newArmada->plate           = str_replace(' ', '', strtoupper($request->plate));
                $newArmada->status          = ($request->booked_by == null) ? 0 : 1;
                $newArmada->booked_by       = $request->booked_by ?? null;
                $newArmada->save();
                $armadaticket->armada_id = $newArmada->id;
                if($request->type == 'gs'){
                    $armadaticket->gs_plate = str_replace(' ', '', strtoupper($newArmada->plate));
                    $armadaticket->gs_received_date = date('Y-m-d');
                }
                if($request->type == 'gt'){
                    $armadaticket->gt_plate = str_replace(' ', '', strtoupper($newArmada->plate));
                    $armadaticket->gt_received_date = date('Y-m-d');
                }
                $armadaticket->save();
            }

            if($armadaticket->type() == "Mutasi"){
                // ubah salespoint armada
                $armada = $armadaticket->armada;
                $armada->salespoint_id = $armadaticket->mutasi_form->receiver_salespoint_id;
                $armada->save();
            }
            DB::commit();
            return back()->with('success','Berhasil melakukan upload dokumen kelengkapan, armada dengan nomor pelat '.str_replace(' ', '', strtoupper($request->plate)).' telah diupdate di master armada');
        }catch(\Exception $ex){
            DB::rollback();
            dd($ex);
            return back()->with('error','Gagal melakukan upload dokumen kelengkapan '.$ex->getMessage());
        }
    }

    public function uploadBASTKGT(Request $request){
        try {
            DB::beginTransaction();
            $armadaticket = ArmadaTicket::findOrFail($request->armada_ticket_id);
            $armada = $armadaticket->armada;
            $armada->plate = $request->gt_plate;
            $armada->save();

            $salespointname = str_replace(' ','_',$armadaticket->salespoint->name);
            $ext = pathinfo($request->file('bastk_file')->getClientOriginalName(), PATHINFO_EXTENSION);
            $name = "BASTK_GT_".$salespointname.'.'.$ext;
            $path = "/attachments/ticketing/armada/".$armadaticket->code.'/'.$name;
            $file = pathinfo($path);
            $path = $request->file('bastk_file')->storeAs($file['dirname'],$file['basename'],'public');

            $armadaticket->bastk_path = $path;
            $armadaticket->gt_plate = str_replace(' ', '', strtoupper($request->gt_plate));
            $armadaticket->gt_received_date = date('Y-m-d');
            $armadaticket->save();
            DB::commit();
            return back()->with('success','Berhasil update armada dan upload bastk');
        } catch (\Exception $ex) {
            DB::rollback();
            return back()->with('error','Gagal update armada dan upload bastk '.$ex->getMessage());
        }
    }

    public function verifyPO(Request $request){
        try{
            DB::beginTransaction();
            $armadaticket = ArmadaTicket::findOrFail($request->armada_ticket_id);
            $old_po = $armadaticket->po_reference;
            $old_po->status = 4;
            $old_po->save();

            $armadaticket->finished_date = date('Y-m-d');
            $armadaticket->status = 6;
            $armadaticket->save();

            DB::commit();
            return back()->with('success','Berhasil melakukan verifikasi PO.');
        }catch(\Exception $ex){
            DB::rollback();
            return back()->with('error','Gagal melakukan verifikasi PO.');
        }
    }

    public function terminateArmadaTicketing(Request $request){
        try {
            DB::beginTransaction();
            $armadaticketing = ArmadaTicket::findOrFail($request->armada_ticket_id);
            if($armadaticketing->updated_at->format('Y-m-d H:i:s') != $request->updated_at){
                throw new \Exception('Ticket armada sudah di update sebelumnya, silahkan coba kembali.');
            }
            $armadaticketing->status = -1;
            $armadaticketing->termination_reason = $request->reason;
            $armadaticketing->save();
            DB::commit();
            return redirect('/ticketing?menu=Armada')->with('success', 'Berhasil melakukan pembatalan ticketing');
        } catch (\Exception $ex) {
            DB::rollback();
            dd($ex);
            return back()->with('error','Gagal membatalkan ticketing armada ('.$ex->getMessage().')');
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
                switch($armadaticket->type()){
                    case 'Pengadaan':
                        $armadaticket->status = 2;
                        $message = "Silahkan melanjutkan ke Menu PR.";
                        break;
                    case 'Perpanjangan':
                        $armadaticket->status = 4;
                        $message = "Silahkan melanjutkan ke Menu PO.";
                        break;
                    case 'Replace':
                        $armadaticket->status = 4;
                        $message = "Silahkan melanjutkan ke Menu PO.";
                        break;
                    case 'Renewal':
                        $armadaticket->status = 4;
                        $message = "Silahkan melanjutkan ke Menu PO.";
                        break;
                    case 'End Kontrak':
                        $armadaticket->status = 5;
                        $message = "Silahkan melanjutkan upload BASTK.";
                        break;
                    case 'Mutasi':
                        $armadaticket->status = 4;
                        $message = "Silahkan melanjutkan ke Menu PO.";
                        break;
                }
                $armadaticket->save();
                DB::commit();
                return back()->with('success','Otorisasi pengadaan armada '.$armadaticket->code.' telah selesai. '.$message);
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

    public function terminateArmadaTicket(Request $request){
        try {
            DB::beginTransaction();
            $armadaticket = ArmadaTicket::findOrFail($request->armada_ticket_id);
            if($armadaticket->status == 6){
                throw new \Exception('Status Armada yang sudah selesai tidak dapat dibatalkan.');
            }
            $armadaticket->terminated_by = Auth::user()->id;
            $armadaticket->termination_reason = $request->cancel_notes;
            $armadaticket->status = -1;
            $armadaticket->save();

            if($request->email_vendor != null){
                // kirim email notifikasi ke vendor
            }

            $monitor                        = new ArmadaTicketMonitoring;
            $monitor->armada_ticket_id      = $armadaticket->id;
            $monitor->employee_id           = Auth::user()->id;
            $monitor->employee_name         = Auth::user()->name;
            $monitor->message               = 'Membatalkan Pengadaan Armada';
            $monitor->save();
            DB::commit();
            return redirect('/ticketing?menu=Armada')->with('success','Berhasil Membatalkan Pengadaan');
        } catch (\Exception $ex) {
            DB::rollback();
            dd($ex);
            return redirect('/ticketing?menu=Armada')->with('error','Gagal Membatalkan Pengadaan "'.$ex->getMessage().'"');
        }
    }
}
