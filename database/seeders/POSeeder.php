<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PoManual;
use DB;
use Carbon\Carbon;

class POSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::beginTransaction();
        $data = array(

            // ASSUMPTION
            array("po_number" => 3011029053, "po_reference_number" => 3011029053, "salespoint_name" => "JEMBER", "salespoint_id"=> 171, "category_name" => "Security", "item_name"=> "Security personil", "item_code" => null, "vendor_name" => "GARDA BHAKTI NUSANTARA PT","vendor_code"=>"V100601362", "gs_plate"=>null, "gt_plate"=> null, "isNiaga"=>null, "armada_name"=> null , "armada_type_id"=>null ,"armada_brand_name"=>null ,"qty"=> 1 ,"start_date"=> "2023-07-20", "end_date"=> "2024-07-31", "jenis_item"=>"Jasa", "jenis_pengadaan"=>"Repeat Order" , "jenis_it"=>"non_it", "harga"=>3504222, "type_budget"=>"Assumption", "budget_or_non_budget"=>"Budget", "keterangan"=>null),
            array("po_number" => 3011029059, "po_reference_number" => 3011029059, "salespoint_name" => "TANGGUL", "salespoint_id"=> 372, "category_name" => "Security", "item_name"=> "Security personil", "item_code" => null, "vendor_name" => "GARDA BHAKTI NUSANTARA PT","vendor_code"=>"V100601362", "gs_plate"=>null, "gt_plate"=> null, "isNiaga"=>null, "armada_name"=> null , "armada_type_id"=>null ,"armada_brand_name"=>null ,"qty"=> 1 ,"start_date"=> "2023-07-20", "end_date"=> "2024-07-31", "jenis_item"=>"Jasa", "jenis_pengadaan"=>"Repeat Order" , "jenis_it"=>"non_it", "harga"=>3504222, "type_budget"=>"Assumption", "budget_or_non_budget"=>"Budget", "keterangan"=>null),
            array("po_number" => 3011029054, "po_reference_number" => 3011029054, "salespoint_name" => "JEMBER", "salespoint_id"=> 171, "category_name" => "Security", "item_name"=> "Security personil", "item_code" => null, "vendor_name" => "-","vendor_code"=> "-", "gs_plate"=>null, "gt_plate"=> null, "isNiaga"=>null, "armada_name"=> null , "armada_type_id"=>null ,"armada_brand_name"=>null ,"qty"=> 0 ,"start_date"=>"", "end_date"=>"", "jenis_item"=>"Jasa", "jenis_pengadaan"=>"Repeat Order" , "jenis_it"=>"non_it", "harga"=>247816, "type_budget"=>"Assumption", "budget_or_non_budget"=>"Budget", "keterangan"=>null),
            array("po_number" => 3011029055, "po_reference_number" => 3011029055, "salespoint_name" => "JEMBER", "salespoint_id"=> 171, "category_name" => "Security", "item_name"=> "Security personil", "item_code" => null, "vendor_name" => "-","vendor_code"=> "-", "gs_plate"=>null, "gt_plate"=> null, "isNiaga"=>null, "armada_name"=> null , "armada_type_id"=>null ,"armada_brand_name"=>null ,"qty"=> 1 ,"start_date"=>"", "end_date"=>"", "jenis_item"=>"Jasa", "jenis_pengadaan"=>"Repeat Order" , "jenis_it"=>"non_it", "harga"=>1820111, "type_budget"=>"Assumption", "budget_or_non_budget"=>"Budget", "keterangan"=>null),
            array("po_number" => 3011029056, "po_reference_number" => 3011029056, "salespoint_name" => "JEMBER", "salespoint_id"=> 171, "category_name" => "Security", "item_name"=> "Security personil", "item_code" => null, "vendor_name" => "-","vendor_code"=> "-", "gs_plate"=>null, "gt_plate"=> null, "isNiaga"=>null, "armada_name"=> null , "armada_type_id"=>null ,"armada_brand_name"=>null ,"qty"=> 0 ,"start_date"=>"", "end_date"=>"", "jenis_item"=>"Jasa", "jenis_pengadaan"=>"Repeat Order" , "jenis_it"=>"non_it", "harga"=>127408, "type_budget"=>"Assumption", "budget_or_non_budget"=>"Budget", "keterangan"=>null),
            array("po_number" => 3011029060, "po_reference_number" => 3011029060, "salespoint_name" => "TANGGUL", "salespoint_id"=> 372, "category_name" => "Security", "item_name"=> "Security personil", "item_code" => null, "vendor_name" => "-","vendor_code"=> "-", "gs_plate"=>null, "gt_plate"=> null, "isNiaga"=>null, "armada_name"=> null , "armada_type_id"=>null ,"armada_brand_name"=>null ,"qty"=> 0 ,"start_date"=>"", "end_date"=>"", "jenis_item"=>"Jasa", "jenis_pengadaan"=>"Repeat Order" , "jenis_it"=>"non_it", "harga"=>247816, "type_budget"=>"Assumption", "budget_or_non_budget"=>"Budget", "keterangan"=>null),
            array("po_number" => 3011029057, "po_reference_number" => 3011029057, "salespoint_name" => "TANGGUL", "salespoint_id"=> 372, "category_name" => "Security", "item_name"=> "Security personil", "item_code" => null, "vendor_name" => "-","vendor_code"=> "-", "gs_plate"=>null, "gt_plate"=> null, "isNiaga"=>null, "armada_name"=> null , "armada_type_id"=>null ,"armada_brand_name"=>null ,"qty"=> 1 ,"start_date"=>"", "end_date"=>"", "jenis_item"=>"Jasa", "jenis_pengadaan"=>"Repeat Order" , "jenis_it"=>"non_it", "harga"=>1820111, "type_budget"=>"Assumption", "budget_or_non_budget"=>"Budget", "keterangan"=>null),
            array("po_number" => 3011029058, "po_reference_number" => 3011029058, "salespoint_name" => "TANGGUL", "salespoint_id"=> 372, "category_name" => "Security", "item_name"=> "Security personil", "item_code" => null, "vendor_name" => "-","vendor_code"=> "-", "gs_plate"=>null, "gt_plate"=> null, "isNiaga"=>null, "armada_name"=> null , "armada_type_id"=>null ,"armada_brand_name"=>null ,"qty"=> 0 ,"start_date"=>"", "end_date"=>"", "jenis_item"=>"Jasa", "jenis_pengadaan"=>"Repeat Order" , "jenis_it"=>"non_it", "harga"=>127408, "type_budget"=>"Assumption", "budget_or_non_budget"=>"Budget", "keterangan"=>null),

            
            // HO BUDGET
            
            // INVENTORY
            
            // ARMADA
          
        );

        foreach ($data as $pomanual) {
            $newpomanual = new PoManual;
            $newpomanual->po_number            = $pomanual['po_number'];
            $newpomanual->po_reference_number  = $pomanual['po_reference_number'];
            $newpomanual->salespoint_name      = $pomanual['salespoint_name'];
            $newpomanual->category_name        = $pomanual['category_name'];
            $newpomanual->item_name            = $pomanual['item_name'];
            $newpomanual->vendor_name          = $pomanual['vendor_name'];
            $newpomanual->gs_plate             = $pomanual['gs_plate'];
            $newpomanual->gt_plate             = $pomanual['gt_plate'];

            if ($pomanual['isNiaga'] != null) {
                $newpomanual->isNiaga             = ($pomanual['isNiaga'] == "NIAGA") ? 1 : 0;
            } else {
                $newpomanual->isNiaga             = null;
            }
            $newpomanual->armada_name          = $pomanual['armada_name'];
            $newpomanual->armada_brand_name    = $pomanual['armada_brand_name'];
            $newpomanual->qty                  = intval($pomanual['qty']);

            if (str_contains($pomanual['start_date'], "-")) {
                $newpomanual->start_date = Carbon::createFromFormat('Y-m-d', $pomanual['start_date'])->format('Y-m-d');
            } else {
                $newpomanual->start_date = null;
            }
            if (str_contains($pomanual['end_date'], "-")) {
                $newpomanual->end_date = Carbon::createFromFormat('Y-m-d', $pomanual['end_date'])->format('Y-m-d');
            } else {
                $newpomanual->end_date = null;
            }
            $newpomanual->jenis_item           = $pomanual['jenis_item'];
            $newpomanual->jenis_pengadaan      = $pomanual['jenis_pengadaan'] == "Baru" ? 1 : 0;
            $newpomanual->jenis_it             = ($pomanual['jenis_it'] == "IT") ? 1 : 0;
            $newpomanual->harga                = intval($pomanual['harga']);
            $newpomanual->type_budget          = $pomanual['type_budget'];
            $newpomanual->budget_or_non_budget = ($pomanual['budget_or_non_budget'] == "Budget") ? 1 : 0;
            $newpomanual->keterangan           = $pomanual['keterangan'] ?? null;
            $newpomanual->status               = 3;
            $newpomanual->created_at           = now()->format('Y-m-d H:i:s');

            $newpomanual->salespoint_id        = $pomanual['salespoint_id'];
            $newpomanual->vendor_code          = $pomanual['vendor_code'];
            $newpomanual->armada_type_id       = $pomanual['armada_type_id'];
            $newpomanual->item_code            = $pomanual['item_code'];

            $newpomanual->barang_jasa_form_bidding_filepath                         = null;
            $newpomanual->barang_jasa_pr_manual_filepath                            = null;
            $newpomanual->barang_jasa_po_filepath                                   = null;
            $newpomanual->barang_jasa_lpb_filepath                                  = null;
            $newpomanual->barang_jasa_invoice_filepath                              = null;
            $newpomanual->armada_pr_manual_filepath                                 = null;
            $newpomanual->armada_po_filepath                                        = null;
            $newpomanual->armada_bastk_filepath                                     = null;
            $newpomanual->security_cit_pestcontrol_merchandiser_pr_manual_filepath  = null;
            $newpomanual->security_cit_pestcontrol_merchandiser_po_filepath         = null;
            $newpomanual->security_lpb_filepath                                     = null;
            $newpomanual->cit_lpb_filepath                                          = null;
            $newpomanual->pestcontrol_lpb_filepath                                  = null;
            $newpomanual->merchandiser_lpb_filepath                                 = null;

            $newpomanual->save();
            DB::commit();
        }
    }
}
