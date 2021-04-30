<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Authorization;
use App\Models\AuthorizationDetail;

class AuthorizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $newAuthorization                 = new Authorization;
        $newAuthorization->salespoint_id  = 1;
        $newAuthorization->form_type      = 0;
        $newAuthorization->save();
        $employee_ids = [4,5,2];
        $as = ['Pengaju','Atasan Langsung','Atasan Tidak Langsung'];
        foreach ($employee_ids as $key=>$id){
            $detail                    = new AuthorizationDetail;
            $detail->authorization_id  = $newAuthorization->id;
            $detail->employee_id       = $id;
            $detail->sign_as           = $as[$key];
            $detail->level             = $key+1;
            $detail->save();
        }
    }
}
