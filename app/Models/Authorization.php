<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Authorization extends Model
{
    protected $table = 'authorization';
    protected $primaryKey = 'id';

    public function salespoint(){
        return $this->belongsTo(SalesPoint::class);
    }

    public function authorization_detail(){
        return $this->hasMany(AuthorizationDetail::class);
    }

    public function form_type_name(){
        switch ($this->form_type) {
            case 0:
                return 'Form Pengadaan Barang Jasa';
                break;
            case 1:
                return 'Form Bidding';
                break;
            case 2:
                return 'Form PR';
                break;
            case 3:
                return 'Form PO';
                break;
            case 4:
                return 'Form Fasilitas';
                break;
            case 5:
                return 'Form Mutasi';
                break;
            case 6:
                return 'Form Perpanjangan / Perhentian';
                break;
            case 7:
                return 'Form Pengadaan Armada';
                break;
            case 8:
                return 'Form Pengadaan Security';
                break;
            default:
                return 'form_type_undefined';
                break;
        }
    }

    public function list(){
        // id
        // as_text
        // name
        $data = [];
        foreach ($this->authorization_detail as $list){
            $authorlist = [
                "id" => $list->employee->id,
                "as_text" => $list->sign_as,
                "position_id" => $list->employee_position_id,
                "position" => $list->employee_position->name,
                "name" => $list->employee->name,
            ];
            array_push($data,$authorlist);
        }
        return json_encode($data);
    }
}
