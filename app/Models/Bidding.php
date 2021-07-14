<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

use App\Models\Employee;

class Bidding extends Model
{
    use SoftDeletes;
    protected $table = 'bidding';
    protected $primaryKey = 'id';
    
    public function bidding_detail(){
        return $this->hasMany(BiddingDetail::class);
    }

    public function bidding_authorization(){
        return $this->hasMany(BiddingAuthorization::class);
    }

    public function ticket(){
        return $this->belongsTo(Ticket::class);
    }

    public function ticket_item(){
        return $this->belongsTo(TicketItem::class);
    }

    
    public function current_authorization(){
        if($this->status != 0){
            // if not pending return null
            return null;
        }
        $queue = $this->bidding_authorization->where('status',0)->sortBy('level');
        if($queue->count() > 0){
            $current = $queue->first();
            return $current;
        }else{
            return null;
        }
    }

    public function last_authorization(){
        $queue = $this->bidding_authorization->where('status',1)->sortByDesc('level');
        if($last){
            $last = $queue->first();
        }
        if($this->status != 1){
            return null;
        }else{
            return $last;
        }
    }

    // return bidding detail
    public function selected_vendor(){
        if(count($this->bidding_detail)<1){
            return null;
        }
        $selected_vendor = null;
        $selected_total = 0;
        foreach($this->bidding_detail as $detail){
            $sum =0;
            $sum += $detail->price_score * 5;
            $sum += $detail->ketersediaan_barang_score * 3;
            $sum += $detail->ketentuan_bayar_score * 2;
            $sum += $detail->others_score * 2;
            if($sum > $selected_total || $selected_vendor == null){
                $selected_vendor = $detail;
                $selected_total = $sum;
            }
        }
        return $selected_vendor;
    }

    public function rejected_by_employee(){
        if($this->rejected_by != null){
            return Employee::find($this->rejected_by);
        }else{
            return null;
        }
    }
}
