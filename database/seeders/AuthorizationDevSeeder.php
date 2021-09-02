<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Authorization;
use App\Models\AuthorizationDetail;

class AuthorizationDevSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $authorizations = array(
            array('id' => '4','salespoint_id' => '100','form_type' => '0','created_at' => '2021-06-15 08:16:39','updated_at' => '2021-06-15 08:16:39'),
            array('id' => '5','salespoint_id' => '1','form_type' => '0','created_at' => '2021-06-29 09:00:11','updated_at' => '2021-06-29 09:00:11'),
            array('id' => '6','salespoint_id' => '1','form_type' => '1','created_at' => '2021-06-29 09:13:57','updated_at' => '2021-06-29 09:13:57'),
            array('id' => '7','salespoint_id' => '1','form_type' => '2','created_at' => '2021-07-06 07:56:21','updated_at' => '2021-07-06 07:56:21'),
            array('id' => '8','salespoint_id' => '230','form_type' => '0','created_at' => '2021-08-06 13:21:12','updated_at' => '2021-08-06 13:21:12'),
            array('id' => '9','salespoint_id' => '230','form_type' => '2','created_at' => '2021-08-06 14:11:00','updated_at' => '2021-08-06 14:11:00'),
            array('id' => '10','salespoint_id' => '125','form_type' => '0','created_at' => '2021-08-10 12:11:43','updated_at' => '2021-08-10 12:11:43'),
            array('id' => '11','salespoint_id' => '125','form_type' => '1','created_at' => '2021-08-10 12:12:45','updated_at' => '2021-08-10 12:12:45'),
            array('id' => '12','salespoint_id' => '125','form_type' => '2','created_at' => '2021-08-10 12:14:00','updated_at' => '2021-08-10 12:14:00'),
            array('id' => '13','salespoint_id' => '125','form_type' => '3','created_at' => '2021-08-10 12:15:16','updated_at' => '2021-08-10 12:15:16')
        );
        
        $authorization_details = array(
            array('id' => '11','authorization_id' => '4','employee_id' => '9','employee_position_id' => '12','sign_as' => 'Pengaju','level' => '1','created_at' => '2021-06-15 08:32:26','updated_at' => '2021-06-15 08:32:26'),
            array('id' => '12','authorization_id' => '4','employee_id' => '10','employee_position_id' => '13','sign_as' => 'Atasan Langsung','level' => '2','created_at' => '2021-06-15 08:32:26','updated_at' => '2021-06-15 08:32:26'),
            array('id' => '13','authorization_id' => '4','employee_id' => '16','employee_position_id' => '19','sign_as' => 'Atasan Tidak Langsung','level' => '3','created_at' => '2021-06-15 08:32:26','updated_at' => '2021-06-15 08:32:26'),
            array('id' => '14','authorization_id' => '5','employee_id' => '2','employee_position_id' => '12','sign_as' => 'Pengaju','level' => '1','created_at' => '2021-06-29 09:00:11','updated_at' => '2021-06-29 09:00:11'),
            array('id' => '15','authorization_id' => '5','employee_id' => '3','employee_position_id' => '10','sign_as' => 'Atasan Langsung','level' => '2','created_at' => '2021-06-29 09:00:11','updated_at' => '2021-06-29 09:00:11'),
            array('id' => '16','authorization_id' => '5','employee_id' => '13','employee_position_id' => '11','sign_as' => 'Atasan Tidak Langsung','level' => '3','created_at' => '2021-06-29 09:00:11','updated_at' => '2021-06-29 09:00:11'),
            array('id' => '17','authorization_id' => '6','employee_id' => '2','employee_position_id' => '12','sign_as' => 'Diajukan Oleh','level' => '1','created_at' => '2021-06-29 09:13:57','updated_at' => '2021-06-29 09:13:57'),
            array('id' => '18','authorization_id' => '6','employee_id' => '3','employee_position_id' => '10','sign_as' => 'Diperiksa Oleh','level' => '2','created_at' => '2021-06-29 09:13:57','updated_at' => '2021-06-29 09:13:57'),
            array('id' => '19','authorization_id' => '6','employee_id' => '13','employee_position_id' => '11','sign_as' => 'Disetujui Oleh','level' => '3','created_at' => '2021-06-29 09:13:57','updated_at' => '2021-06-29 09:13:57'),
            array('id' => '20','authorization_id' => '7','employee_id' => '2','employee_position_id' => '15','sign_as' => 'Dibuat Oleh','level' => '1','created_at' => '2021-07-06 07:56:21','updated_at' => '2021-07-06 07:56:21'),
            array('id' => '21','authorization_id' => '7','employee_id' => '3','employee_position_id' => '17','sign_as' => 'Diperiksa Oleh','level' => '2','created_at' => '2021-07-06 07:56:21','updated_at' => '2021-07-06 07:56:21'),
            array('id' => '22','authorization_id' => '7','employee_id' => '13','employee_position_id' => '16','sign_as' => 'Disetujui Oleh','level' => '3','created_at' => '2021-07-06 07:56:21','updated_at' => '2021-07-06 07:56:21'),
            array('id' => '23','authorization_id' => '8','employee_id' => '25','employee_position_id' => '12','sign_as' => 'Pengaju','level' => '1','created_at' => '2021-08-06 13:21:12','updated_at' => '2021-08-06 13:21:12'),
            array('id' => '24','authorization_id' => '8','employee_id' => '26','employee_position_id' => '13','sign_as' => 'Atasan Langsung','level' => '2','created_at' => '2021-08-06 13:21:12','updated_at' => '2021-08-06 13:21:12'),
            array('id' => '25','authorization_id' => '8','employee_id' => '27','employee_position_id' => '14','sign_as' => 'Atasan Tidak Langsung','level' => '3','created_at' => '2021-08-06 13:21:12','updated_at' => '2021-08-06 13:21:12'),
            array('id' => '26','authorization_id' => '9','employee_id' => '26','employee_position_id' => '13','sign_as' => 'Dibuat Oleh','level' => '1','created_at' => '2021-08-06 14:11:00','updated_at' => '2021-08-06 14:11:00'),
            array('id' => '27','authorization_id' => '9','employee_id' => '27','employee_position_id' => '14','sign_as' => 'Diperiksa Oleh','level' => '2','created_at' => '2021-08-06 14:11:00','updated_at' => '2021-08-06 14:11:00'),
            array('id' => '28','authorization_id' => '9','employee_id' => '28','employee_position_id' => '15','sign_as' => 'Disetujui Oleh','level' => '3','created_at' => '2021-08-06 14:11:00','updated_at' => '2021-08-06 14:11:00'),
            array('id' => '29','authorization_id' => '9','employee_id' => '29','employee_position_id' => '17','sign_as' => 'Disetujui Oleh','level' => '4','created_at' => '2021-08-06 14:11:00','updated_at' => '2021-08-06 14:11:00'),
            array('id' => '30','authorization_id' => '9','employee_id' => '30','employee_position_id' => '16','sign_as' => 'Disetujui Oleh','level' => '5','created_at' => '2021-08-06 14:11:00','updated_at' => '2021-08-06 14:11:00'),
            array('id' => '31','authorization_id' => '10','employee_id' => '23','employee_position_id' => '20','sign_as' => 'Pengaju','level' => '1','created_at' => '2021-08-10 12:11:43','updated_at' => '2021-08-10 12:11:43'),
            array('id' => '32','authorization_id' => '10','employee_id' => '7','employee_position_id' => '7','sign_as' => 'Atasan Langsung','level' => '2','created_at' => '2021-08-10 12:11:43','updated_at' => '2021-08-10 12:11:43'),
            array('id' => '33','authorization_id' => '10','employee_id' => '13','employee_position_id' => '11','sign_as' => 'Atasan Tidak Langsung','level' => '3','created_at' => '2021-08-10 12:11:43','updated_at' => '2021-08-10 12:11:43'),
            array('id' => '34','authorization_id' => '11','employee_id' => '23','employee_position_id' => '20','sign_as' => 'Diajukan Oleh','level' => '1','created_at' => '2021-08-10 12:12:45','updated_at' => '2021-08-10 12:12:45'),
            array('id' => '35','authorization_id' => '11','employee_id' => '7','employee_position_id' => '7','sign_as' => 'Diperiksa Oleh','level' => '2','created_at' => '2021-08-10 12:12:45','updated_at' => '2021-08-10 12:12:45'),
            array('id' => '36','authorization_id' => '11','employee_id' => '13','employee_position_id' => '11','sign_as' => 'Disetujui Oleh','level' => '3','created_at' => '2021-08-10 12:12:45','updated_at' => '2021-08-10 12:12:45'),
            array('id' => '37','authorization_id' => '12','employee_id' => '23','employee_position_id' => '20','sign_as' => 'Dibuat Oleh','level' => '1','created_at' => '2021-08-10 12:14:00','updated_at' => '2021-08-10 12:14:00'),
            array('id' => '38','authorization_id' => '12','employee_id' => '7','employee_position_id' => '7','sign_as' => 'Diperiksa Oleh','level' => '2','created_at' => '2021-08-10 12:14:00','updated_at' => '2021-08-10 12:14:00'),
            array('id' => '39','authorization_id' => '12','employee_id' => '13','employee_position_id' => '11','sign_as' => 'Disetujui Oleh','level' => '3','created_at' => '2021-08-10 12:14:00','updated_at' => '2021-08-10 12:14:00'),
            array('id' => '40','authorization_id' => '13','employee_id' => '23','employee_position_id' => '20','sign_as' => 'Dibuat Oleh','level' => '1','created_at' => '2021-08-10 12:15:16','updated_at' => '2021-08-10 12:15:16'),
            array('id' => '41','authorization_id' => '13','employee_id' => '13','employee_position_id' => '11','sign_as' => 'Diperiksa dan disetujui oleh','level' => '2','created_at' => '2021-08-10 12:15:16','updated_at' => '2021-08-10 12:15:16')
        );

        foreach($authorizations as $authorization){
            $newAuthorization = new Authorization;
            $newAuthorization->id = $authorization['id'];
            $newAuthorization->salespoint_id = $authorization['salespoint_id'];
            $newAuthorization->form_type = $authorization['form_type'];
            $newAuthorization->save();
        }

        foreach($authorization_details as $detail){
            $newAuthorization                         = new AuthorizationDetail;
            $newAuthorization->id                     = $detail['id'];
            $newAuthorization->authorization_id       = $detail['authorization_id'];
            $newAuthorization->employee_id            = $detail['employee_id'];
            $newAuthorization->employee_position_id   = $detail['employee_position_id'];
            $newAuthorization->sign_as                = $detail['sign_as'];
            $newAuthorization->level                  = $detail['level'];
            $newAuthorization->save();
        }
    }
}
