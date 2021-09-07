<?php

namespace App\Http\Controllers\Operational;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Armada;
use App\Models\ArmadaType;
use App\Models\ArmadaTicket;
use App\Models\SecurityTicket;
use App\Models\SecurityTicketMonitoring;
use App\Models\Ticket;
use App\Models\TicketVendor;
use App\Models\ArmadaVendor;
use App\Models\Po;
use App\Models\PoDetail;
use App\Models\POUploadRequest; 
use App\Models\PoAuthorization;
use App\Models\Authorization; 
use App\Models\PrDetail; 
use App\Models\EmployeeLocationAccess;
use App\Models\Employee;
use App\Models\TicketMonitoring;
use App\Models\ArmadaTicketMonitoring;
use PDF;
use DB;
use Storage;
use Mail;
use Form;
use App\Mail\POMail;
use Illuminate\Support\Str;


class POController extends Controller
{
    public function poView(){
        $salespoint_ids = Auth::user()->location_access->pluck('salespoint_id');
        $barangjasatickets = Ticket::where('status','>',5)
        ->whereIn('salespoint_id',$salespoint_ids)
        ->get();

        $armadatickets = ArmadaTicket::whereIn('status',[4])
        ->whereIn('salespoint_id',$salespoint_ids)->get();
        
        $securitytickets = SecurityTicket::whereIn('status',[4])
        ->whereIn('salespoint_id',$salespoint_ids)->get();

        $tickets = array();
        foreach($barangjasatickets as $ticket){
            $ticket->type = "Barang Jasa";
            array_push($tickets,$ticket);
        }

        foreach($armadatickets as $ticket){
            $ticket->type = $ticket->type()." Armada";
            array_push($tickets,$ticket);
        }

        foreach($securitytickets as $ticket){
            $ticket->type = $ticket->type()." Security";
            array_push($tickets,$ticket);
        }
        return view('Operational.po', compact('tickets'));
    }

    public function podetailView($ticket_code){
        try {
            $ticket = Ticket::where('code',$ticket_code)->first();
            $armadaticket = ArmadaTicket::where('code',$ticket_code)->first();
            $securityticket = SecurityTicket::where('code',$ticket_code)->first();
            if($ticket ==  null && $armadaticket == null && $securityticket == null){
                throw new \Exception("Ticket tidak ditemukan");
            }
            if($ticket != null){
                if($ticket->po->count() > 0){
                    $authorization_list = Authorization::where('form_type',3)->get();
                    return view('Operational.podetail',compact('ticket','authorization_list'));
                }else{
                    return view('Operational.poitemselection',compact('ticket'));
                }
            }
            if($armadaticket != null){
                if($armadaticket->po->count() > 0){
                    $authorization_list = Authorization::where('form_type',3)->get();
                    return view('Operational.podetail',compact('armadaticket','authorization_list'));
                }else{
                    $armada_vendors = ArmadaVendor::all();
                    // ambil armada sesuai niaga yang terdaftar
                    $armada_types = [];
                    if($armadaticket->po_reference != null){
                        $armada_types = ArmadaType::where('isNiaga',$armadaticket->po_reference->armada_ticket->armada_type->isNiaga)
                        ->get();
                    }
                    return view('Operational.Armada.poitemselection',compact('armadaticket','armada_vendors','armada_types'));
                }
            }
            
            if($securityticket != null){
                if($securityticket->po != null){
                    $authorization_list = Authorization::where('form_type',3)->get();
                    return view('Operational.podetail',compact('securityticket','authorization_list'));
                }else{
                    return view('Operational.Security.poitemselection',compact('securityticket'));
                }
            }
        } catch (\Exception $ex) {
            return back()->with('error',$ex->getMessage());
        }
    }

    public function setupPO(Request $request){
        try {
            DB::beginTransaction();
            $ticket = Ticket::find($request->ticket_id);
            $armadaticket = ArmadaTicket::find($request->armada_ticket_id);
            $securityticket = SecurityTicket::find($request->security_ticket_id);
            if($ticket != null){
                // sudah di setup po sebelumnnya
                if($ticket->po->count() > 0){
                    return back()->with('error','PO sudah di setup sebelumnya');
                }
                $group_item_by_selected_vendor = collect($request->item)->groupBy('ticket_vendor_id');
                foreach($group_item_by_selected_vendor as $vendor_items){
                    $ticket_vendor = TicketVendor::find($vendor_items[0]["ticket_vendor_id"]);
                    $ppn_items = [];
                    $non_ppn_items = [];
                    foreach($vendor_items as $item){
                        $prdetail = PrDetail::findOrFail($item['pr_detail_id']);
                        $newDetail = new \stdClass(); 
                        $newDetail->item_name         = $prdetail->ticket_item->name;
                        $newDetail->item_description  = $prdetail->ticket_item->bidding->ketersediaan_barang_notes;
                        $newDetail->ticket_item_id    = $prdetail->ticket_item->id;
                        $newDetail->qty               = $prdetail->qty;
                        $newDetail->item_price        = $prdetail->price;
                        if($item['ppn_percentage'] == null){
                            array_push($non_ppn_items,$newDetail);
                        }else{
                            $newDetail->ppn_percentage    = $item['ppn_percentage'];
                            array_push($ppn_items, $newDetail);
                        }
                        
                        if($prdetail->ongkir > 0){
                            $newDetail = new \stdClass(); 
                            $newDetail->item_name         = 'Ongkir '.$prdetail->ticket_item->name;
                            $newDetail->item_description  = '';
                            $newDetail->ticket_item_id    = $prdetail->ticket_item->id;
                            $newDetail->qty               = 1;
                            $newDetail->item_price        = $prdetail->ongkir;
                            array_push($non_ppn_items,$newDetail);
                        }
                        
                        if($prdetail->ongpas > 0){
                            $newDetail = new \stdClass(); 
                            $newDetail->item_name         = 'Ongpas '.$prdetail->ticket_item->name;
                            $newDetail->item_description  = '';
                            $newDetail->ticket_item_id    = $prdetail->ticket_item->id;
                            $newDetail->qty               = 1;
                            $newDetail->item_price        = $prdetail->ongpas;
                            array_push($non_ppn_items,$newDetail);
                        }
                    }
                    
                    if(count($ppn_items)>0){
                        // PPN ITEMS
                        $groupby_ppn_percentage = collect($ppn_items)->groupBy('ppn_percentage');
                        foreach($groupby_ppn_percentage as $lists){
                            $newPO = new Po;
                            $newPO->ticket_id        = $ticket->id;
                            $newPO->ticket_vendor_id = $item['ticket_vendor_id'];
                            $newPO->has_ppn          = true;
                            $newPO->ppn_percentage   = $lists[0]->ppn_percentage;
                            $newPO->sender_name      = $ticket_vendor->name;
                            $newPO->send_name        = $ticket->salespoint->name;
                            $newPO->save();
                            foreach($lists as $list){
                                $podetail = new PoDetail;
                                $podetail->po_id             = $newPO->id;
                                $podetail->item_name         = $list->item_name;
                                $podetail->item_description  = $list->item_description;
                                $podetail->ticket_item_id    = $list->ticket_item_id;
                                $podetail->qty               = $list->qty;
                                $podetail->item_price        = $list->item_price;
                                $podetail->save();
                            }
                        }
                    }
    
                    // NON PPN ITEM
                    if(count($non_ppn_items)>0){
                        $newPO = new Po;
                        $newPO->ticket_id        = $ticket->id;
                        $newPO->ticket_vendor_id = $item['ticket_vendor_id'];
                        $newPO->has_ppn          = false;
                        $newPO->sender_name      = $ticket_vendor->name;
                        $newPO->send_name        = $ticket->salespoint->name;
                        $newPO->save();
        
                        foreach($non_ppn_items as $list){
                            $podetail = new PoDetail;
                            $podetail->po_id             = $newPO->id;
                            $podetail->item_name         = $list->item_name;
                            $podetail->item_description  = $list->item_description;
                            $podetail->ticket_item_id    = $list->ticket_item_id;
                            $podetail->qty               = $list->qty;
                            $podetail->item_price        = $list->item_price;
                            $podetail->save();
                        }
                    }
                }
                
                $monitor = new TicketMonitoring;
                $monitor->ticket_id      = $ticket->id;
                $monitor->employee_id    = Auth::user()->id;
                $monitor->employee_name  = Auth::user()->name;
                $monitor->message        = 'Melakukan Setup PO';
                $monitor->save();
            }

            if($armadaticket != null){
                // sudah di setup po sebelumnnya
                if($armadaticket->po->count() > 0){
                    return back()->with('error','PO sudah di setup sebelumnya');
                }
                switch ($armadaticket->type()) {
                    case 'Pengadaan':
                        $armadaticket->vendor_name = $request->selected_vendor;
                        break;
                        
                    case 'Perpanjangan':
                        $armadaticket->vendor_name = $request->selected_vendor;
                        break;
                        
                    case 'Replace':
                        $armadaticket->vendor_name = $request->selected_vendor;
                        $armadaticket->armada_type_id = $request->armada_type_id;
                        break;
                        
                    case 'Renewal':
                        $armadaticket->vendor_name = $request->selected_vendor;
                        $armadaticket->armada_type_id = $request->armada_type_id;
                        break;

                    case 'Mutasi':
                        // copy semua dari ticket armada lama
                        $old_armada_ticket              = $armadaticket->po_reference->armada_ticket;
                        $armadaticket->vendor_name      = $old_armada_ticket->vendor_name;
                        $armadaticket->armada_type_id   = $old_armada_ticket->armada_type_id;
                        $armadaticket->armada_id        = $old_armada_ticket->armada_id;
                        break;
                }
                $armadaticket->save();

                $newPo                   = new Po;
                $newPo->armada_ticket_id = $armadaticket->id;
                if($armadaticket->type() == "Mutasi"){
                    // untuk mutasi sender dari salespoint lama dan penerima salespoint tujuan
                    $newPo->sender_name      = $armadaticket->po_reference->armada_ticket->vendor_name;
                    $newPo->send_name        = $armadaticket->mutasi_form->receiver_salespoint_name;
                }else{
                    $newPo->sender_name      = $request->selected_vendor;
                    $newPo->send_name        = $armadaticket->salespoint->name;
                }
                $newPo->has_ppn          = true;
                $newPo->ppn_percentage   = 10;
                $newPo->save();

                // sewa
                if($request->sewa_value < 10000){
                    return back()->with('error','Minimal biaya sewa Rp 10.000,-');
                }
                $notes = $request->sewa_notes;
                $value = $request->sewa_value;
                // jika ada biaya ekspedisi gabungkan dengan biaya sewa 
                
                if($request->ekspedisi_count != null){
                    $value += $request->ekspedisi_value/$request->sewa_count;
                    $single_expedition_value = $request->ekspedisi_value/$request->sewa_count;

                    $notes = $notes ."\r\n".'Biaya Ekspedisi';
                    $notes = $notes ."\r\n".$request->ekspedisi_value.'/'.$request->sewa_count.'='.$single_expedition_value;
                    $notes = $notes ."\r\n".$request->ekspedisi_notes;
                }

                // biaya sewa
                $newPoDetail = new PoDetail;
                $newPoDetail->po_id            = $newPo->id;
                $newPoDetail->item_name        = $request->sewa_name;
                $newPoDetail->item_description = $notes;
                $newPoDetail->uom              = 'AU';
                $newPoDetail->qty              = $request->sewa_count;
                $newPoDetail->item_price       = $value;
                $newPoDetail->save();

                // jika ada prorate tambahkan biaya
                if($request->prorate_value != null){
                    if($request->prorate_value < 10000){
                        return back()->with('error','Minimal biaya prorate Rp 10.000,-');
                    }
                    $newPoDetail = new PoDetail;
                    $newPoDetail->po_id            = $newPo->id;
                    $newPoDetail->item_name        = 'Prorate Armada';
                    $newPoDetail->item_description = $request->prorate_notes;
                    $newPoDetail->uom              = 'AU';
                    $newPoDetail->qty              = $request->prorate_count;
                    $newPoDetail->item_price       = $request->prorate_value;
                    $newPoDetail->save();
                }
                
                $monitor                        = new ArmadaTicketMonitoring;
                $monitor->armada_ticket_id      = $armadaticket->id;
                $monitor->employee_id           = Auth::user()->id;
                $monitor->employee_name         = Auth::user()->name;
                $monitor->message               = 'Melakukan Setup PO';
                $monitor->save();
            }
            
            if($securityticket != null){
                // sudah di setup po sebelumnnya
                if($securityticket->po != null){
                    throw new \Exception('PO sudah di setup sebelumnya');
                }
                switch ($securityticket->type()) {
                    case 'Pengadaan Baru':
                        $securityticket->vendor_name = $request->new_vendor;
                        $selected_vendor             = $request->new_vendor;
                        break;

                    case 'Pengadaan Lembur':
                        $securityticket->vendor_name = $request->new_vendor;
                        $selected_vendor             = $request->new_vendor;
                        break;
                        
                    case 'Perpanjangan':
                        $securityticket->vendor_name = $request->old_vendor;
                        $selected_vendor             = $request->old_vendor;
                        break;
                        
                    case 'Replace':
                        $securityticket->vendor_name = $request->new_vendor;
                        $selected_vendor             = $request->new_vendor;
                        break;
                        
                }
                $securityticket->save();

                // untuk item ppn
                if(isset($request->item_ppn)){
                    $newPo                     = new Po;
                    $newPo->security_ticket_id = $securityticket->id;
                    $newPo->sender_name        = $selected_vendor;
                    $newPo->send_name          = $securityticket->salespoint->name;
                    $newPo->has_ppn            = true;
                    $newPo->ppn_percentage     = 10;
                    $newPo->save();
    
                    foreach($request->item_ppn as $item){
                        $newPoDetail = new PoDetail;
                        $newPoDetail->po_id            = $newPo->id;
                        $newPoDetail->item_name        = $item['name'];
                        $newPoDetail->item_description = $item['notes'];
                        $newPoDetail->uom              = 'AU';
                        $newPoDetail->qty              = $item['count'];
                        $newPoDetail->item_price       = $item['value'];
                        $newPoDetail->save();
                    }
                }

                // untuk item non ppn
                if(isset($request->item_nonppn)){
                    $newPo                     = new Po;
                    $newPo->security_ticket_id = $securityticket->id;
                    $newPo->sender_name        = $selected_vendor;
                    $newPo->send_name          = $securityticket->salespoint->name;
                    $newPo->has_ppn            = false;
                    $newPo->save();
    
                    foreach($request->item_ppn as $item){
                        $newPoDetail = new PoDetail;
                        $newPoDetail->po_id            = $newPo->id;
                        $newPoDetail->item_name        = $item['name'];
                        $newPoDetail->item_description = $item['notes'];
                        $newPoDetail->uom              = 'AU';
                        $newPoDetail->qty              = $item['count'];
                        $newPoDetail->item_price       = $item['value'];
                        $newPoDetail->save();
                    }
                }
                $monitor                        = new SecurityTicketMonitoring;
                $monitor->security_ticket_id    = $securityticket->id;
                $monitor->employee_id           = Auth::user()->id;
                $monitor->employee_name         = Auth::user()->name;
                $monitor->message               = 'Melakukan Setup PO';
                $monitor->save();
            }

            DB::commit();
            return back()->with('success', 'Berhasil melakukan setting PO. Silahkan melanjutkan penerbitan PO');
        } catch (\Exception $ex) {
            DB::rollback();
            dd($ex);
            return back()->with('error','Gagal melakukan setting PO. Silahkan hubungi developer atau coba kembali');
        }
    }

    public function submitPO(Request $request){
        try {
            DB::beginTransaction();
            $po = Po::findOrFail($request->po_id);
            if($po->status != -1){
                throw new \Exception("PO sudah di proses sebelumnya oleh ". $po->created_by_employee()->name. 'pada '. $po->created_at->translatedFormat('d F Y (H:i)'));
            }else{
                $existing_po = Po::where('no_po_sap',$request->no_po_sap)->first();
                $existing_pr = Po::where('no_pr_sap',$request->no_pr_sap)->first();

                if($existing_pr){
                    throw new \Exception('Nomor PR SAP '.$request->no_pr_sap.'telah sebelumnya di input di kode pengadaan '.$existing_pr->ticket->code);
                }

                if($existing_po){
                    throw new \Exception('Nomor PO SAP '.$request->no_po_sap.'telah sebelumnya di input di kode pengadaan '.$existing_po->ticket->code);
                }

                $po->sender_address         = $request->sender_address;
                $po->send_address           = $request->send_address;
                $po->payment_days           = $request->payment_days;
                $po->no_pr_sap              = $request->no_pr_sap;
                $po->no_po_sap              = $request->no_po_sap;
                $po->supplier_pic_name      = $request->supplier_pic_name;
                $po->supplier_pic_position  = $request->supplier_pic_position;
                $po->notes                  = $request->notes;
                $po->created_by             = Auth::user()->id;
                $po->status                 = 0;
                $po->save();

                foreach($request->po_detail as $po_detail){
                    $detail = PoDetail::findOrFail($po_detail['id']);
                    $detail->delivery_notes = $po_detail['delivery_notes'];
                    $detail->save();
                }

                foreach($po->po_authorization as $author){
                    $author->delete();
                }
                $authorization = Authorization::findOrFail($request->authorization_id);
                foreach($authorization->authorization_detail as $authorization){
                    $po_authorization                       = new PoAuthorization;
                    $po_authorization->po_id                = $po->id;
                    $po_authorization->employee_id          = $authorization->employee_id;
                    $po_authorization->employee_name        = $authorization->employee->name;
                    $po_authorization->as                   = $authorization->sign_as;
                    $po_authorization->employee_position    = $authorization->employee_position->name;
                    $po_authorization->level                = $authorization->level;
                    $po_authorization->save();
                }
            }
            
            if($po->ticket_id != null){
                $monitor = new TicketMonitoring;
                $monitor->ticket_id      = $po->ticket->id;
                $monitor->employee_id    = Auth::user()->id;
                $monitor->employee_name  = Auth::user()->name;
                $monitor->message        = 'Menerbitkan PO '.$po->no_po_sap;
                $monitor->save();
            }
            if($po->armada_ticket_id != null){
                $monitor = new ArmadaTicketMonitoring;
                $monitor->armada_ticket_id      = $po->armada_ticket->id;
                $monitor->employee_id    = Auth::user()->id;
                $monitor->employee_name  = Auth::user()->name;
                $monitor->message        = 'Menerbitkan PO '.$po->no_po_sap;
                $monitor->save();
            }
            if($po->security_ticket_id != null){
                $monitor = new SecurityTicketMonitoring;
                $monitor->security_ticket_id      = $po->security_ticket->id;
                $monitor->employee_id    = Auth::user()->id;
                $monitor->employee_name  = Auth::user()->name;
                $monitor->message        = 'Menerbitkan PO '.$po->no_po_sap;
                $monitor->save();
            }
            DB::commit();
            return back()->with('success','Berhasil Menerbitkan PO');
        } catch (\Exception $ex) {
            DB::rollback();
            return back()->with('error','Gagal Menerbitkan PO '.$ex->getMessage());
        }
    }

    public function printPO(Request $request){
        try {
            $po = Po::where('no_po_sap',$request->input('code'))->first();
            if(!$po){
                throw new \Exception('PO tidak ditemukan');
            }
            $pdf = PDF::loadView('pdf.popdf', compact('po'));
            return $pdf->stream('PO ('.$po->no_po_sap.').pdf');
            // return $pdf->download('invoice.pdf');
        } catch (\Exception $ex) {
            return back()->with('error','Gagal Mencetak PO '.$ex->getMessage());
        }
    }

    public function uploadInternalSignedFile(Request $request){
        try {
            DB::beginTransaction();
            $po = Po::findOrFail($request->po_id);
            if($po->ticket_id != null){
                $ticket = $po->ticket;
                $type = 'barangjasa';
            }
            if($po->armada_ticket_id != null){
                $ticket = $po->armada_ticket;
                $type = 'armada';
            }
            if($po->security_ticket_id != null){
                $ticket = $po->security_ticket;
                $type = 'security';
            }
            $salespointname = str_replace(' ','_',$ticket->salespoint->name);
            $ext = pathinfo($request->file('internal_signed_file')->getClientOriginalName(), PATHINFO_EXTENSION);
            $name = $po->no_po_sap."_INTERNAL_SIGNED_".$salespointname.'.'.$ext;
            $path = "/attachments/ticketing/".$type."/".$ticket->code.'/po/'.$name;
            $file = pathinfo($path);
            $path = $request->file('internal_signed_file')->storeAs($file['dirname'],$file['basename'],'public');
            $po->internal_signed_filepath = $path;

            $po_upload_request               = new POUploadRequest;
            $po_upload_request->id           = (string) Str::uuid();
            $po_upload_request->po_id        = $po->id;
            $po_upload_request->vendor_name  = $po->sender_name;
            if($po->ticket_id != null){
                $po_upload_request->vendor_pic   = $po->ticket_vendor->salesperson;
            }
            if($po->armada_ticket_id != null || $po->security_ticket_id != null){
                $po_upload_request->vendor_pic   = $po->sender_name;
            }
            $po_upload_request->save();

            $po->po_upload_request_id = $po_upload_request->id;
            $po->save();

            $mail = $request->email;
            $data = array(
                'po' => $po,
                'mail' => $mail,
                'po_upload_request' => $po_upload_request,
                'url' => url('/signpo/'.$po_upload_request->id)
            );
            Mail::to($mail)->send(new POMail($data, 'posignedrequest'));
            
            $po->status = 1;
            $po->last_mail_send_to = $request->email;
            $po->save();
            
            if($po->ticket_id != null){
                $monitor = new TicketMonitoring;
                $monitor->ticket_id      = $po->ticket->id;
                $monitor->employee_id    = Auth::user()->id;
                $monitor->employee_name  = Auth::user()->name;
                $monitor->message        = 'Upload Internal Signed PO '.$po->no_po_sap;
                $monitor->save();
            }
            if($po->armada_ticket_id != null){
                $monitor = new ArmadaTicketMonitoring;
                $monitor->armada_ticket_id      = $po->armada_ticket->id;
                $monitor->employee_id           = Auth::user()->id;
                $monitor->employee_name         = Auth::user()->name;
                $monitor->message               = 'Upload Internal Signed PO '.$po->no_po_sap;
                $monitor->save();
            }
            if($po->security_ticket_id != null){
                $monitor = new SecurityTicketMonitoring;
                $monitor->security_ticket_id      = $po->security_ticket->id;
                $monitor->employee_id             = Auth::user()->id;
                $monitor->employee_name           = Auth::user()->name;
                $monitor->message                 = 'Upload Internal Signed PO '.$po->no_po_sap;
                $monitor->save();
            }
            DB::commit();
            if($po->status == 1){
                return back()->with('success','Berhasil Upload File Intenal Signed untuk PO '.$po->no_po_sap.' File sudah dikirimkan ke email supplier ('.$mail.') untuk ditandatangan');
            }
            if($po->status == 3){
                return back()->with('success','Berhasil Upload File Intenal Signed untuk PO '.$po->no_po_sap.' Dilanjutkan dengan penerimaan di area');
            }
        } catch (\Exception $ex) {
            DB::rollback();
            dd($ex);
            return back()->with('error','Gagal Upload File '. $ex->getMessage()); 
        }
    }

    public function confirmPosigned(Request $request){
        try {
            DB::beginTransaction();
            $po = Po::findOrFail($request->po_id);
            $po->status = 3;
            
            $po_upload_request = $po->po_upload_request;
            $po_upload_request->status = 2;
            $po_upload_request->save();
            
            $po->external_signed_filepath = $po_upload_request->filepath;
            $po->save();

            // send email back to supplier and salespoint
            if($po->ticket_id != null){
                $salespoint_id = $po->ticket->salespoint_id;
            }
            if($po->armada_ticket_id != null){
                $salespoint_id = $po->armada_ticket->salespoint_id;
            }
            if($po->security_ticket_id != null){
                $salespoint_id = $po->security_ticket->salespoint_id;
            }
            $access = EmployeeLocationAccess::where('salespoint_id',$salespoint_id)->get();
            $employee_salespoint_ids = $access->pluck('employee_id')->unique();
            $employee_emails = [];
            foreach ($employee_salespoint_ids as $id){
                $email = Employee::find($id)->email;
                array_push($employee_emails,$email);
            }
            
            $mail = $po->last_mail_send_to;
            $data = array(
                'po' => $po,
                'mail' => $mail,
                'external_signed_filepath' =>  $po_upload_request->filepath
            );
            Mail::to($mail)
            ->cc($employee_emails)
            ->send(new POMail($data, 'poconfirmed'));
            
            if ($po->ticket_id != null) {
                $monitor = new TicketMonitoring;
                $monitor->ticket_id      = $po->ticket->id;
                $monitor->employee_id    = Auth::user()->id;
                $monitor->employee_name  = Auth::user()->name;
                $monitor->message        = 'Konfirmasi tanda tangan supplier PO '.$po->no_po_sap;
                $monitor->save();
            }
            if ($po->armada_ticket_id != null) {
                $armada_ticket              = $po->armada_ticket;
                $armada_ticket->po_number   = $po->no_po_sap;
                $armada_ticket->save();
                
                $monitor = new ArmadaTicketMonitoring;
                $monitor->armada_ticket_id      = $po->armada_ticket->id;
                $monitor->employee_id    = Auth::user()->id;
                $monitor->employee_name  = Auth::user()->name;
                $monitor->message        = 'Konfirmasi tanda tangan supplier PO '.$po->no_po_sap;
                $monitor->save();
            }
            if ($po->security_ticket_id != null) {
                $security_ticket              = $po->security_ticket;
                $security_ticket->po_number   = $po->no_po_sap;
                // cek status seluruh po apakah sudah selesai
                if ($security_ticket->po->where('status', '!=', 3)->count()==0) {
                    $security_ticket->status      = 5;
                    $security_ticket->save();
                }
                
                $monitor                          = new SecurityTicketMonitoring;
                $monitor->security_ticket_id      = $po->security_ticket->id;
                $monitor->employee_id             = Auth::user()->id;
                $monitor->employee_name           = Auth::user()->name;
                $monitor->message                 = 'Konfirmasi tanda tangan supplier PO '.$po->no_po_sap;
                $monitor->save();

                DB::commit();
                if($security_ticket->po->where('status','!=',3)->count()>0){
                    return back()->with('success','Berhasil melakukan konfirmasi tanda tangan Supplier untuk PO '.$po->no_po_sap);
                }else{
                    return back()->with('success','Berhasil melakukan konfirmasi tanda tangan Supplier untuk PO '.$po->no_po_sap.' dilanjutkan dengan penerimaan di salespoint/area bersangkutan');
                }
            }

            DB::commit();
            return back()->with('success','Berhasil melakukan konfirmasi tanda tangan Supplier untuk PO '.$po->no_po_sap.' dilanjutkan dengan penerimaan di salespoint/area bersangkutan');
        } catch (\Exception $ex) {
            DB::rollback();
            return back()->with('error','Gagal Confirm Signed PO '.$ex->getMessage().' - line '.$ex->getLine());
        }
    }

    public function rejectPosigned(Request $request){
        try {
            DB::beginTransaction();
            $po = Po::findOrFail($request->po_id);
            $po->status = 1;
            $po->save();

            $porequest = POUploadRequest::findOrFail($request->po_upload_request_id);
            $porequest->notes = $request->reason;
            $porequest->isExpired = true;
            $porequest->status = -1;
            $porequest->save();

            $po_upload_request               = new POUploadRequest;
            $po_upload_request->id           = (string) Str::uuid();
            $po_upload_request->po_id        = $po->id;
            $po_upload_request->vendor_name  = $po->ticket_vendor->name;
            $po_upload_request->vendor_pic   = $po->ticket_vendor->salesperson;
            $po_upload_request->save();

            $po->po_upload_request_id = $po_upload_request->id;
            $po->save();

            $mail = $request->email;
            $data = array(
                'reject_notes' => $request->reason,
                'po' => $po,
                'mail' => $mail,
                'po_upload_request' => $po_upload_request,
                'new_url' => url('/signpo/'.$po_upload_request->id)
            );
            Mail::to($mail)->send(new POMail($data, 'posignedreject'));
            
            if ($po->ticket_id != null) {
                $monitor = new TicketMonitoring;
                $monitor->ticket_id      = $po->ticket->id;
                $monitor->employee_id    = Auth::user()->id;
                $monitor->employee_name  = Auth::user()->name;
                $monitor->message        = 'Menolak tanda tangan Supplier PO '.$po->no_po_sap;
                $monitor->save();
            }
            if ($po->armada_ticket_id != null) {
                $monitor                 = new ArmadaTicketMonitoring;
                $monitor->ticket_id      = $po->armada_ticket->id;
                $monitor->employee_id    = Auth::user()->id;
                $monitor->employee_name  = Auth::user()->name;
                $monitor->message        = 'Menolak tanda tangan Supplier PO '.$po->no_po_sap;
                $monitor->save();
            }
            if ($po->security_ticket_id != null) {
                $monitor                    = new SecurityTicketMonitoring;
                $monitor->ticket_id         = $po->security_ticket->id;
                $monitor->employee_id       = Auth::user()->id;
                $monitor->employee_name     = Auth::user()->name;
                $monitor->message           = 'Menolak tanda tangan Supplier PO '.$po->no_po_sap;
                $monitor->save();
            }
    
            DB::commit();
            return back()->with('success','Berhasil melakukan penolakan tanda tangan PO '.$po->no_po_sap.' link baru telah dikirim ke email '.$mail);
        } catch (\Exception $ex) {
            DB::rollback();
            return back()->with('error','Gagal Confirm Signed PO '.$ex->getMessage());
        }
    }

    public function sendEmail(Request $request){
        try {
            DB::beginTransaction();
            $po = Po::findOrFail($request->po_id);

            $old_po_upload_request = $po->po_upload_request;

            if($old_po_upload_request){
                $old_po_upload_request->isExpired = true;
                $old_po_upload_request->save();
                $old_po_upload_request->delete();
            }

            $po_upload_request = new POUploadRequest;
            $po_upload_request->id = (string) Str::uuid();
            $po_upload_request->po_id        = $po->id;
            $po_upload_request->vendor_name  = $po->ticket_vendor->name;
            $po_upload_request->vendor_pic   = $po->ticket_vendor->salesperson;
            $po_upload_request->notes        = $po->id;
            $po_upload_request->save();

            $po->po_upload_request_id = $po_upload_request->id;
            $po->save();
            $mail = $request->email;
            $data = array(
                'po' => $po,
                'mail' => $mail,
                'po_upload_request' => $po_upload_request,
                'url' => url('/signpo/'.$po_upload_request->id)
            );
            Mail::to($mail)->send(new POMail($data, 'posignedrequest'));
            DB::commit();
            
            $monitor = new TicketMonitoring;
            $monitor->ticket_id      = $po->ticket->id;
            $monitor->employee_id    = Auth::user()->id;
            $monitor->employee_name  = Auth::user()->name;
            $monitor->message        = 'Mengirim ulang email untuk PO '.$po->no_po_sap;
            $monitor->save();
            return back()->with('success', 'berhasil mengirim ulang email untuk po '.$po->no_po_sap.' ke email '.$mail);
        } catch (\Exception $ex) {
            DB::rollback();
            return back()->with('error','Gagal Mengirimkan email');
        }
    }

    public function poUploadRequestView($po_upload_request_id){
        try{
            $poupload = POUploadRequest::where('id',$po_upload_request_id)->where('isExpired',false)->first();
            if(!$poupload){
                throw new \Exception('Document expired or not found');
            }
            $active_po = Po::find($poupload->po_id);
            if($active_po->po_upload_request_id != $poupload->id){
                throw new \Exception('Link invalid');
            }
            $poupload->isOpened = true;
            $poupload->save();
            return view('Operational.poupload',compact('poupload'));
        }catch(\Exception $ex){
            return $ex->getMessage();
        }
    }

    public function poUploadRequest(Request $request){
        try{
            DB::beginTransaction();
            $pouploadrequest = POUploadRequest::findOrFail($request->po_upload_request_id);
            if($request->file()){
                $internal_signed_filepath = $pouploadrequest->po->internal_signed_filepath;
                $filepath = str_replace('INTERNAL_SIGNED','EXTERNAL_SIGNED',$internal_signed_filepath);
                $newext = pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_EXTENSION);
                $filepath = $this->replace_extension($filepath,$newext);
                $file =pathinfo($filepath);
                $path = $request->file('file')->storeAs($file['dirname'],$file['basename'],'public');
                $pouploadrequest->filepath = $path;
                $pouploadrequest->status = 1;
                $pouploadrequest->save();

                $po = $pouploadrequest->po;
                $po->status = 2;
                $po->save();
                
                if($po->ticket_id != null){
                    $monitor = new TicketMonitoring;
                    $monitor->ticket_id      = $po->ticket->id;
                    $monitor->employee_id    = -1;
                    $monitor->employee_name  = $po->ticket_vendor->name;
                    $monitor->message        = 'Supplier '.$po->ticket_vendor->name.' Melakukan Upload tanda tangan PO '.$po->no_po_sap;
                    $monitor->save();
                }

                if($po->armada_ticket_id != null){
                    $monitor = new ArmadaTicketMonitoring;
                    $monitor->armada_ticket_id      = $po->armada_ticket->id;
                    $monitor->employee_id           = -1;
                    $monitor->employee_name         = $po->sender_name;
                    $monitor->message                = 'Supplier '.$po->vendor_name.' Melakukan Upload tanda tangan PO '.$po->no_po_sap;
                    $monitor->save();
                }
                DB::commit();
                return back()->with('success','Berhasil upload file');
            }else{
                DB::rollback();
                throw new \Exception("File tidak ditemukan");
            }
        }catch (\Exception $ex){
            DB::rollback();
            return back()->with('error',$ex->getMessage());
        }
    }

    public function replace_extension($filename, $new_extension) {
        $info = pathinfo($filename);
        return $info['dirname'].'/'.$info['filename'] . '.' . $new_extension;
    }
    
    public function getActivePO(Request $request){
        $pos = Po::join('armada_ticket','Po.armada_ticket_id','=','armada_ticket.id')
                 ->join('armada','armada_ticket.armada_id','=','armada.id')
                 ->where('Po.status',3)
                 ->where('armada_ticket.salespoint_id',$request->salespoint_id)
                 ->where('armada_ticket.isNiaga',$request->isNiaga)
                 ->select('Po.no_po_sap AS po_number','armada.plate AS plate')
                 ->get();
        return response()->json([
            "data" => $pos,
        ]);
    }
}
