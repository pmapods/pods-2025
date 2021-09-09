<?php

namespace App\Http\Controllers\Operational;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\ArmadaTicket;
use App\Models\SecurityTicket;
use App\Models\Ticket;
use App\Models\Authorization;
use App\Models\SecurityTicketAuthorization;
use App\Models\EmployeePosition;
use App\Models\EmployeeLocationAccess;
use App\Models\SalesPoint;
use App\Models\EvaluasiForm;
use App\Models\EvaluasiFormAuthorization;
use App\Models\Po;

use DB;
use Carbon\Carbon;
use Auth;

class SecurityTicketingController extends Controller
{
    public function createSecurityTicket(Request $request){
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

            $total_count = $armada_ticket_count + $barang_ticket_count + $security_ticket_count;
            do {
                $code = "PCD-".now()->translatedFormat('ymd').'-'.str_repeat("0", 4-strlen($total_count+1)).($total_count+1);
                $total_count++;
                $checkbarang = Ticket::where('code',$code)->first();
                $checkarmada = ArmadaTicket::where('code',$code)->first();
                $checksecurity = SecurityTicket::where('code',$code)->first();
                ($checkbarang != null || $checkarmada != null || $checksecurity != null) ? $flag = false : $flag = true;
            } while (!$flag);

            $newTicket                               = new SecurityTicket;
            $newTicket->code                         = $code;
            $newTicket->salespoint_id                = $request->salespoint_id;
            $newTicket->ticketing_type               = $request->ticketing_type;
            if(in_array($request->ticketing_type,[1,2,3])){
                $newTicket->po_reference_number      = $request->po_number;
            }
            $newTicket->requirement_date             = $request->requirement_date;
            $newTicket->created_by                   = Auth::user()->id;
            $newTicket->save();

            $authorization = Authorization::findOrFail($request->authorization_id);
            foreach ($authorization->authorization_detail as $key => $authorization) {
                $newAuthorization                    = new SecurityTicketAuthorization;
                $newAuthorization->security_ticket_id  = $newTicket->id;
                $newAuthorization->employee_id       = $authorization->employee_id;
                $newAuthorization->employee_name     = $authorization->employee->name;
                $newAuthorization->as                = $authorization->sign_as;
                $newAuthorization->employee_position = $authorization->employee_position->name;
                $newAuthorization->level             = $key+1;
                $newAuthorization->save();
            }
            DB::commit();
            return redirect('/ticketing?menu=Security')->with('success','Berhasil membuat ticketing security');
        } catch (\Exception $ex) {
            DB::rollback();
            dd($ex);
            return back()->with('error','Gagal membuat ticketing security ('.$ex->getMessage().')');
        }
    }
   
    public function securityTicketDetail(Request $request, $code){
        $securityticket = SecurityTicket::where('code',$code)->first();

        $employee_positions = EmployeePosition::all();

        $user_location_access  = EmployeeLocationAccess::where('employee_id',Auth::user()->id)->get()->pluck('salespoint_id');
        $available_salespoints = SalesPoint::whereIn('id',$user_location_access)->get();
        $available_salespoints = $available_salespoints->groupBy('region');

        $evaluasiform_authorizations = Authorization::where('salespoint_id',$securityticket->salespoint_id)->where('form_type',9)->get();

        $salespoints = SalesPoint::all();
        try { 
            if(!$securityticket){
                throw new \Exception('Ticket security dengan kode '.$code.'tidak ditemukan');
            }
            return view('Operational.Security.securityticketdetail',compact('securityticket','employee_positions','salespoints','evaluasiform_authorizations'));
        } catch (\Exception $ex) {
            return redirect('/ticketing?menu=Security')->with('error','Gagal membukan detail ticket security '.$ex->getMessage());
        }
    }

    public function startSecurityAuthorization(Request $request) {
        try {
            $securityticket = SecurityTicket::findOrFail($request->security_ticket_id);
            if($securityticket->updated_at != $request->updated_at){
                return back()->with('error','Data terbaru sudah diupdate. Silahkan coba kembali');
            }else{
                $securityticket->status += 1;
                $securityticket->save();
            }
            return back()->with('success','Berhasil memulai otorisasi pengadaan security '.$securityticket->code.'. Otorisasi selanjutnya oleh '.$securityticket->current_authorization()->employee_name);
        } catch (\Exception $ex) {
            dd($ex);
            return back()->with('error','Gagal memulai otorisasi '.$ex->getMessage());
        }
    }

    public function approveSecurityAuthorization(Request $request){
        try {
            DB::beginTransaction();
            $securityticket = SecurityTicket::findOrFail($request->security_ticket_id);
            $current_authorization = $securityticket->current_authorization();
            if($current_authorization->employee_id != Auth::user()->id){
                return back()->with('error','Otorisasi saat ini tidak sesuai dengan akun login.');
            }else{
                $current_authorization->status += 1;
                $current_authorization->save();
            }

            $current_authorization = $securityticket->current_authorization();
            if($current_authorization == null){
                switch($securityticket->type()){
                    case 'Pengadaan Baru':
                        $securityticket->status = 2;
                        $message = "Silahkan melanjutkan ke Menu PR.";
                        break;
                    case 'Perpanjangan':
                        $securityticket->status = 4;
                        $message = "Silahkan melanjutkan ke Menu PO.";
                        break;
                    case 'Replace':
                        $securityticket->status = 4;
                        $message = "Silahkan melanjutkan ke Menu PO.";
                        break;
                    case 'End Sewa':
                        $securityticket->status = 5;
                        $message = "Silahkan melanjutkan upload surat Pemutusan kontrak.";
                        break;
                    case 'Pengadaan Lembur':
                        $securityticket->status = 2;
                        $message = "Silahkan melanjutkan ke Menu PR untuk Upload BA";
                        break;
                }
                $securityticket->save();
                DB::commit();
                return back()->with('success','Otorisasi pengadaan security '.$securityticket->code.' telah selesai. '.$message);
            }else{
                DB::commit();
                return back()->with('success','Berhasil melakukan approval otorisasi pengadaan security '.$securityticket->code.'. Otorisasi selanjutnya oleh '.$securityticket->current_authorization()->employee_name);
            }
        } catch (\Exception $ex) {
            DB::rollback();
            dd($ex);
            return back()->with('error','Gagal memulai otorisasi '.$ex->getMessage());
        }
    }

    public function terminateSecurityTicket(Request $request){
        try {
            DB::beginTransaction();
            $securityticket = SecurityTicket::findOrFail($request->security_ticket_id);
            if($securityticket->status == 6){
                throw new \Exception('Status Security yang sudah selesai tidak dapat dibatalkan.');
            }
            $securityticket->terminated_by = Auth::user()->id;
            $securityticket->termination_reason = $request->cancel_notes;
            $securityticket->status = -1;
            $securityticket->save();

            if($request->email_vendor != null){
                // kirim email notifikasi ke vendor
            }

            $monitor                        = new SecurityTicketMonitoring;
            $monitor->security_ticket_id      = $securityticket->id;
            $monitor->employee_id           = Auth::user()->id;
            $monitor->employee_name         = Auth::user()->name;
            $monitor->message               = 'Membatalkan Pengadaan Security';
            $monitor->save();
            DB::commit();
            return redirect('/ticketing?menu=Security')->with('success','Berhasil Membatalkan Pengadaan');
        } catch (\Exception $ex) {
            DB::rollback();
            dd($ex);
            return redirect('/ticketing?menu=Security')->with('error','Gagal Membatalkan Pengadaan "'.$ex->getMessage().'"');
        }
    }

    public function uploadSecurityBA(Request $request){
        
        try{
            DB::beginTransaction();
            $securityticket = SecurityTicket::findOrFail($request->security_ticket_id);

            $salespointname = str_replace(' ','_',$securityticket->salespoint->name);
            $ext = pathinfo($request->file('ba_file')->getClientOriginalName(), PATHINFO_EXTENSION);
            $name = "BA_".$salespointname.'.'.$ext;
            $path = "/attachments/ticketing/security/".$securityticket->code.'/'.$name;
            $file = pathinfo($path);
            $path = $request->file('ba_file')->storeAs($file['dirname'],$file['basename'],'public');
            $securityticket->ba_path = $path;
            
            $securityticket->status = 4;
            $securityticket->save();

            DB::commit();
            return redirect('/pr')->with('success','Berhasil melakukan upload berkas BA. Silahkan melanjutkan ke proses PO.');
        }catch(\Exception $ex){
            DB::rollback();
            dd($ex);
            return back()->with('error','Gagal melakukan upload berkas LPB '.$ex->getMessage());
        }
    }

    public function uploadSecurityLPB(Request $request){
        try{
            DB::beginTransaction();
            $securityticket = SecurityTicket::findOrFail($request->security_ticket_id);
            if (in_array($securityticket->type(),["Pengadaan Baru","Perpanjangan","Replace"])){
                $salespointname = str_replace(' ','_',$securityticket->salespoint->name);
                $ext = pathinfo($request->file('lpb_file')->getClientOriginalName(), PATHINFO_EXTENSION);
                $name = "LPB_".$salespointname.'.'.$ext;
                $path = "/attachments/ticketing/security/".$securityticket->code.'/'.$name;
                $file = pathinfo($path);
                $path = $request->file('lpb_file')->storeAs($file['dirname'],$file['basename'],'public');
                $securityticket->lpb_path = $path;
            }

            if (in_array($securityticket->type(), ["Perpanjangan","Replace","End Sewa"])) {
                $old_po = $securityticket->po_reference;
                $old_po->status = 4;
                $old_po->save();
            }

            $securityticket->finished_date = date('Y-m-d');
            $securityticket->status = 6;
            $securityticket->save();

            DB::commit();
            return back()->with('success','Berhasil melakukan upload berkas LPB. Pengadaan Selesai.');
        }catch(\Exception $ex){
            DB::rollback();
            dd($ex);
            return back()->with('error','Gagal melakukan upload berkas LPB '.$ex->getMessage());
        }
    }
    
    public function uploadSecurityEndKontrak(Request $request){
        try{
            DB::beginTransaction();
            $securityticket = SecurityTicket::findOrFail($request->security_ticket_id);

            $salespointname = str_replace(' ','_',$securityticket->salespoint->name);
            $ext = pathinfo($request->file('endkontrak_file')->getClientOriginalName(), PATHINFO_EXTENSION);
            $name = "EndSewa_".$salespointname.'.'.$ext;
            $path = "/attachments/ticketing/security/".$securityticket->code.'/'.$name;
            $file = pathinfo($path);
            $path = $request->file('endkontrak_file')->storeAs($file['dirname'],$file['basename'],'public');
            $securityticket->endkontrak_path = $path;

            $old_po = $securityticket->po_reference;
            $old_po->status = 4;
            $old_po->save();

            $securityticket->finished_date = date('Y-m-d');
            $securityticket->status = 6;
            $securityticket->save();

            DB::commit();
            return back()->with('success','Berhasil melakukan upload berkas End Sewa Security. Pengadaan Selesai.');
        }catch(\Exception $ex){
            DB::rollback();
            dd($ex);
            return back()->with('error','Gagal melakukan upload berkas End Sewa Security '.$ex->getMessage());
        }
    }

    public function addEvaluasiForm(Request $request){
        try{
            DB::beginTransaction();
            $securityticket = SecurityTicket::findOrFail($request->security_ticket_id);

            $form                       = new EvaluasiForm;
            $form->security_ticket_id   = $securityticket->id;
            $form->salespoint_id        = $securityticket->salespoint_id;
            $form->vendor_name          = $securityticket->po_reference->security_ticket->vendor_name;
            $form->period               = date('Y-m-d');
            $form->salespoint_name      = $securityticket->po_reference->security_ticket->salespoint->name;
            $form->personil             = json_encode($request->personil);
            $form->lembaga              = json_encode($request->lembaga);
            $form->kesimpulan           = $request->kesimpulan;
            $form->created_by           = Auth::user()->id;
            $form->save();
            
            $authorization = Authorization::find($request->authorization_id);
            foreach($authorization->authorization_detail as $detail){
                $newAuthorization                     = new EvaluasiFormAuthorization;
                $newAuthorization->evaluasi_form_id   = $form->id;
                $newAuthorization->employee_id        = $detail->employee_id;
                $newAuthorization->employee_name      = $detail->employee->name;
                $newAuthorization->as                 = $detail->sign_as;
                $newAuthorization->employee_position  = $detail->employee_position->name;
                $newAuthorization->level              = $detail->level;
                $newAuthorization->save();
            }
            DB::commit();
            return back()->with('success', 'Berhasil membuat form evaluasi. Menunggu Otorisasi oleh '.$authorization->authorization_detail->first()->employee->name);
        }catch(\Exception $ex){
            DB::rollback();
            dd($ex);
            return back()->with('error', 'Gagal membuat form evaluasi');
        }
    }

    public function approveEvaluasiForm(Request $request){
        try {
            DB::beginTransaction();
            $evaluasi_form = EvaluasiForm::findOrFail($request->evaluasi_form_id);
            if($evaluasi_form->current_authorization()->employee_id != Auth::user()->id){
                return back()->with('error','Login tidak sesuai dengan otorisasi');
            }
            $authorization = $evaluasi_form->current_authorization();
            $authorization->status = 1;
            $authorization->save();

            // recall the new one
            $authorization = $evaluasi_form->current_authorization();
            if($authorization == null){
                $evaluasi_form->status = 1;
                $evaluasi_form->save();
            }
            DB::commit();
            if($authorization == null){
                return back()->with('success','Seluruh Otorisasi Form evaluasi telah selesai');
            }else{
                return back()->with('success','Berhasil melakukan otorisasi form evaluasi, Otorisasi selanjutnya oleh '.$authorization->employee_name);
            }
        } catch (Exception $ex) {
            DB::rollback();
            dd($ex);
            return back()->with('error', 'Gagal melakukan otorisasi form evaluasi');
        }
    }

    public function rejectEvaluasiForm(Request $request){
        try {
            DB::beginTransaction();
            $evaluasi_form = EvaluasiForm::findOrFail($request->evaluasi_form_id);
            if($evaluasi_form->current_authorization()->employee_id != Auth::user()->id){
                return back()->with('error','Login tidak sesuai dengan otorisasi');
            }
            
            $authorization = $evaluasi_form->current_authorization();
            $authorization->status = -1;
            $authorization->save();

            $evaluasi_form->status              = -1;
            $evaluasi_form->terminated_by       = Auth::user()->id;
            $evaluasi_form->termination_reason  = $request->reason;
            $evaluasi_form->save();
            $evaluasi_form->delete();
            DB::commit();

            $authorization = $evaluasi_form->current_authorization();
            if($authorization == null){
                return back()->with('success','Formulir evaluasi berhasil dibatalkan. Silahkan membuat formulir evaluasi baru');
            }else{
                return back()->with('success','Gagal membatalkan formulir evaluasi');
            }
        } catch (\Exception $ex) {
            DB::rollback();
            dd($ex);
            return back()->with('error', 'Gagal melakukan otorisasi form evaluasi');
        }
    }
}
