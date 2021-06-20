<?php

namespace App\Http\Controllers\Operational;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Carbon\Carbon;

use App\Models\Ticket;
use App\Models\Authorization;
use App\Models\Pr;
use App\Models\PrAuthorization;
use App\Models\PrDetail;
class PRController extends Controller
{
    public function prView(Request $request){
        $salespoint_ids = Auth::user()->location_access->pluck('salespoint_id');
        if($request->input('status') == -1){
            $tickets = Ticket::where('status','>',5)
            ->whereIn('salespoint_id',$salespoint_ids)
            ->get();
        }else{
            $tickets = Ticket::whereIn('status',[3,4,5])
            ->whereIn('salespoint_id',$salespoint_ids)
            ->get();
        }
        return view('Operational.pr', compact('tickets'));
    }

    public function prDetailView($ticket_code){
        try{
            $ticket = Ticket::where('code',$ticket_code)->first();
            if(!$ticket){
                return back()->with('error',"Ticket tidak ditemukan");
            }
            $authorizations = Authorization::where('form_type',2)->get();
            if($ticket->status < 5){
                return view('Operational.prdetail',compact('ticket','authorizations'));
            }else{
                return view('Operational.prdetailform',compact('ticket','authorizations'));
            }
        }catch(\Exception $ex){
            return back()->with('error','gagal membuka detil PR '.$ex->getMessage());
        }
    }

    public function addNewPR(Request $request){
        $messages = [
            'pr_authorization_id.required'  => 'Otorisasi PR wajib dipilih',
            'updated_at.required' =>'Updated at data not received, Please contact admin'
        ];
        $validated = $request->validate([
            'ticket_id' => 'required',
            'pr_authorization_id' => 'required',
            'updated_at' => 'required'
        ],$messages);
        try{
            DB::beginTransaction();
            $ticket = Ticket::findOrFail($request->ticket_id);
            if(new Carbon($ticket->updated_at) != new Carbon($request->updated_at)){
                return back()->with('error','Terdapat update data pada ticket. Silahkan coba lagi');
            }
            $ticket->status = 4;
            $ticket->save();

            if($request->pr_id != -1){
                $pr = Pr::findOrFail($request->pr_id);
                $pr->rejected_by = null;
                $pr->reject_reason = null;
                $pr->status = 0;
                $pr->created_at = now()->format('Y-m-d H:i:s');
            }else{
                $pr = new Pr;
            }
            $pr->ticket_id    = $ticket->id;
            $pr->created_by   = Auth::user()->id;   
            $pr->save(); 

            $authorization = Authorization::find($request->pr_authorization_id);

            foreach($authorization->authorization_detail as $author){
                $authorization                     = new PrAuthorization;
                $authorization->pr_id              = $pr->id;         
                $authorization->employee_id        = $author->employee_id;             
                $authorization->employee_name      = $author->employee->name;                 
                $authorization->as                 = $author->sign_as;     
                $authorization->employee_position  = $author->employee_position->name;                     
                $authorization->level              = $author->level;
                $authorization->save();
            }

            foreach($request->item as $key => $item){
                $detail                 = new PrDetail;
                $detail->pr_id          = $pr->id;
                $detail->ticket_item_id = $item["ticket_item_id"];
                $detail->qty            = $item["qty"];
                $detail->uom            = $item["uom"];
                $detail->price          = $item["price"] ?? 0;
                $detail->ongkir         = $item["ongkir"] ?? 0;
                $detail->ongpas         = $item["ongpas"] ?? 0;
                $detail->setup_date     = $item["setup_date"];
                $detail->notes          = $item["notes"];
                $detail->save();
            }

            DB::commit();
            return back()->with('success','Berhasil menambakan PR, Silahkan melakukan proses otorisasi');
        }catch(\Exception $ex){
            dd($ex);
            DB::rollback();
            return back()->with('error','Gagal Menambah PR '.$ex->getMessage());
        }
    }

    public function approvePR(Request $request){
        try {
            DB::beginTransaction();
            $pr = Pr::findOrFail($request->pr_id);
            foreach ($request->item as $key => $item) {
                $prdetail               = PrDetail::findOrFail($item["pr_detail_id"]);
                $prdetail->qty          = $item["qty"];
                $prdetail->price        = $item["price"] ?? 0;
                $prdetail->ongkir       = $item["ongkir"] ?? 0;
                $prdetail->ongpas       = $item["ongpas"] ?? 0;
                $prdetail->setup_date   = $item["setup_date"];
                $prdetail->notes        = $item["notes"];
                $prdetail->save();
            }

            // check authorization
            if($pr->current_authorization()->employee->id == Auth::user()->id){
                $authorization = $pr->current_authorization();
                $authorization->status = 1;
                $authorization->save();

                if($pr->current_authorization() == null){
                    $pr->status = 1;
                    $pr->save();
    
                    $ticket = $pr->ticket;
                    $ticket->status = 5;
                    $ticket->save();
                }
                DB::commit();
                if ($pr->current_authorization() == null) {
                    return back()->with('success','Berhasil Melakukan Approve PR, Proses otorisasi selesai, Silahkan mengajukan nomor asset dan mengupdate nomor asset');
                }else{
                    return back()->with('success','Berhasil Melakukan Approve PR, Proses otorisasi dilanjutkan');
                }
            }else{
                throw new \Exception("Otorisasi saat ini dan akun login tidak sesuai");
            }
        } catch (\Exception $ex) {
            DB::rollback();
            dd($ex);
            return back()->with('error','Gagal approved PR '.$ex->getMessage());
        }
    }

    public function rejectPR(Request $request){
        try {
            DB::beginTransaction();
            $pr = Pr::findOrFail($request->pr_id);
            $pr->rejected_by = Auth::user()->id;
            $pr->reject_reason = $request->reason;
            $pr->status = -1;
            
            // check authorization
            if($pr->current_authorization()->employee->id == Auth::user()->id){
                $pr->save();
                foreach($pr->pr_detail as $detail){
                    $detail->forceDelete();
                }
                foreach($pr->pr_authorizations as $authorization){
                    $authorization->forceDelete();
                }
                $ticket = Ticket::findOrFail($request->ticket_id);
                $ticket->status = 3;
                $ticket->save();
            }else{
                throw new \Exception("Otorisasi saat ini dan akun login tidak sesuai");
            }
            DB::commit();
            return redirect('/pr')->with('success','Berhasil Melakukan Reject PR. Silahkan membuat form PR baru');
        } catch (\Exception $ex) {
            DB::rollback();
            dd($ex);
            return back()->with('error','Gagal approved PR '.$ex->getMessage());
        }
    }

    public function submitAssetNumber(Request $request){
        try{
            DB::beginTransaction();
            $ticket = Ticket::findOrFail($request->ticket_id);
            $pr = Pr::findOrFail($request->pr_id);
            if($ticket->status > 5){
                throw new \Exception("Ticket sudah di update sebelumnya.");
            }else{
                foreach($request->item as $key => $item){
                    $pr_detail = PrDetail::findOrFail($item['pr_detail_id']);
                    $pr_detail->isAsset = ($item['asset_number']) ? true : false;
                    $pr_detail->asset_number = $item['asset_number'] ?? null;
                    $pr_detail->save();
                }
                $pr->status = 2;
                $pr->save();
                $ticket->status = 6;
                $ticket->save();

                DB::commit();
                return redirect('/pr')->with('success','Sukses submit nomor asset. Silahkan melanjutkan ke proses PO');
            }
        }catch(\Exception $ex){
            DB::rollback();
            dd($ex);
            return back()->with('error','Gagal approved PR '.$ex->getMessage());
        }
    }
}
