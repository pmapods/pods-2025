<?php

namespace Database\Seeders;
use Faker\Factory as Faker;

use Illuminate\Database\Seeder;
use App\Models\BudgetPricingCategory;
use App\Models\BudgetPricing;
use App\Models\BudgetBrand;
use App\Models\BudgetType;
use DB;

class BudgetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::unprepared("
        INSERT INTO budget_pricing(code,budget_pricing_category_id,name,injs_min_price,injs_max_price,outjs_min_price,outjs_max_price,uom,isAsset) VALUES
        ('OE-01',1,'Handheld',0,1705000,0,1705000,'Unit',1),
        ('OE-02',1,'AC (1/2 PK)',0,3800000,0,4000000,'Unit',1),
        ('OE-03',1,'AC (3/4 PK)',0,3900000,0,4500000,'Unit',1),
        ('OE-04',1,'AC (1 PK)',0,4600000,0,5250000,'Unit',1),
        ('OE-05',1,'AC (1,5 PK)',0,5500000,0,6300000,'Unit',1),
        ('OE-06',1,'AC (2 PK)',0,7100000,0,7350000,'Unit',1),
        ('OE-07',1,'Penambahan pipa & selang (per meter & per unit)',0,100000,0,100000,'Meter',0),
        ('OE-08',1,'Brankas Kecil  uk. 730x460x510 - Depo / CP ',0,9450000,0,9450000,'Unit',1),
        ('OE-09',1,'Brankas Besar uk. 1020x650x600 - Cabang ',0,13000000,0,15000000,'Unit',1),
        ('OE-10',1,'Brankas faktur 3 laci - MT  Only',0,20000000,0,22000000,'Unit',1),
        ('OE-11',1,'Brankas faktur 4 laci - MT Only',0,25000000,0,27000000,'Unit',1),
        ('OE-12',1,'Mesin Absensi Manual + Card Rack',0,3500000,0,3675000,'Unit',1),
        ('OE-13',1,'Money Counter',0,3675000,0,4200000,'Unit',1),
        ('OE-14',1,'Lampu UV Money detector',0,450000,0,450000,'Unit',0),
        ('OE-15',1,'Emergency Light',0,500000,0,500000,'Unit',0),
        ('OE-16',1,'Cash Box u/ Kasir',0,500000,0,500000,'Box',0),
        ('OE-17',1,'Genset 5500 - 6600 Watt',0,10395000,0,11550000,'Unit',1),
        ('OE-18',1,'LCD Proyektor',0,5500000,0,5500000,'Unit',1),
        ('OE-19',1,'Dispenser',0,600000,0,600000,'Unit',0),
        ('OE-20',1,'Kotak Peluru',0,300000,0,400000,'Box',0),
        ('OE-21',1,'Apar',0,1250000,0,1250000,'Tabung',0),
        ('OE-22',1,'Timbangan Uang Coin',0,350000,0,400000,'Unit',0),
        ('OE-23',1,'Handphone',0,300000,0,300000,'Unit',0),
        ('OE-24',1,'Kipas Angin ',0,400000,0,400000,'Unit',0),
        ('OE-25',1,'Smart TV',0,7000000,0,7000000,'Unit',1),
        ('FF-01',2,'Meja 1/2 Biro + laci',0,787500,0,997500,'Unit',0),
        ('FF-02',2,'Meja 1/2 biro utk ruang meeting',0,787500,0,997500,'Unit',0),
        ('FF-03',2,'Kursi susun ',0,420000,0,525000,'Unit',0),
        ('FF-04',2,'Kursi plastik',0,78750,0,78750,'Unit',0),
        ('FF-05',2,'Lemari file 3 laci ',0,1785000,0,2100000,'Unit',1),
        ('FF-06',2,'Lemari Arsip 3 laci untuk Gudang (plastik)',0,700000,0,700000,'Unit',0),
        ('FF-07',2,'Meja 1 biro utk ruang meeting',0,1250000,0,1350000,'Unit',1),
        ('FF-08',2,' Meja 1 biro tanpa laci utk salesman',0,1312500,0,1417500,'Unit',1),
        ('FF-09',2,'Rak arsip ',0,1250000,0,1250000,'Unit',1),
        ('FF-10',2,'Locker Uang (4 Pintu)',0,1200000,0,1500000,'Unit',1),
        ('FF-11',2,'Locker Uang (6 Pintu)',0,1500000,0,1800000,'Unit',1),
        ('WE-01',3,'Hand Pallet 2 ton (BIG)-bahan karet',0,4200000,0,4800000,'Unit',1),
        ('WE-02',3,'Pallet Kayu',0,115000,0,157500,'Pcs',0),
        ('WE-03',3,'Trolly 150 kg',0,500000,0,650000,'Unit',0),
        ('WE-04',3,'Trolly 300 kg ',0,750000,0,750000,'Unit',0),
        ('WE-05',3,'Trolly Roda 4',0,1400000,0,1400000,'Unit',1),
        ('WE-06',3,'Tangga Lipat 2M',0,1000000,0,1000000,'Unit',1),
        ('OT-01',5,'Racking Gudang  (per meter)',0,600000,0,700000,'M2',1),
        ('OT-02',5,'CCTV 4 kamera',0,8000000,0,8000000,'Set',1),
        ('OT-03',5,'CCTV 8 kamera',0,10500000,0,11500000,'Set',1),
        ('OT-04',5,'Monitoring Board tanpa kaki ',0,900000,0,1400000,'Unit',0),
        ('OT-05',5,'Monitoring Board pakai kaki ',0,1600000,0,2000000,'Unit',1),
        ('OT-06',5,'Stavol 5000 Watt',0,3850000,0,4400000,'Unit',1),
        ('OT-07',5,'Tandon Air ',0,2500000,0,2500000,'Unit',0),
        ('TC-01',6,'PC Client',8500000,10450000,9000000,10450000,'Unit',1),
        ('TC-02',6,'Printer Dot Matrix ',8925000,9975000,8925000,9975000,'Unit',1),
        ('TC-03',6,'Printer Multifungsi ',3150000,4200000,3150000,4200000,'Unit',1),
        ('TC-04',6,'Printer Laserjet ',1575000,2100000,1575000,2100000,'Unit',1),
        ('TC-05',6,'Scanner',1312500,1575000,1312500,1575000,'Unit',1),
        ('TC-06',6,'Server ',19425000,21000000,19425000,21000000,'Unit',1),
        ('TC-07',6,'Monitor Server',1312500,1575000,1312500,1575000,'Unit',1),
        ('TC-08',6,'License SCYLLA',14175000,15750000,14175000,15750000,'Unit',1),
        ('TC-09',6,'UPS 1200va',1050000,1575000,1050000,1575000,'Unit',1),
        ('TC-10',6,'Switch 16 port',735000,945000,735000,945000,'Unit',0),
        ('TC-11',6,'Finger Scan',2100000,2835000,2100000,2835000,'Unit',1),
        ('TC-12',6,'Kabel Jaringan LAN',1365000,1890000,1365000,1890000,'Meter',0),
        ('TC-13',6,'Connector RJ45 ( per pax) ',105000,157500,105000,157500,'Pcs',0); 
        ");

        $brandlist = [
            "Samsung Galaxy M10",
            "Panasonic / Daikin/Sharp/LG/Samsung",
            "Panasonic / Daikin/Sharp/LG/Samsung",
            "Panasonic / Daikin/Sharp/LG/Samsung",
            "Panasonic / Daikin/Sharp/LG/Samsung",
            "Panasonic / Daikin/Sharp/LG/Samsung",
            "-",
            "Ichiban/ISafe/Okida/Dragon/Ichiko/Progresif/Chubbsafes/Krisbow",
            "Ichiban/ISafe/Okida/Dragon/Ichiko/Progresif/Chubbsafes/Krisbow",
            "Indachi",
            "Indachi",
            "Amano/Time Recorder/Secure",
            "Krisbow / Morgan/Dynamic/Secure",
            "-",
            "-",
            "-",
            "Daito/ Firman/ Tiger / Ryu / General / Power One",
            "Infocus / Micro Vision",
            "-",
            "-",
            "-",
            "Krischef",
            "Lokal ",
            "Cosmos/Maspion /GMC",
            "Samsung/Panasonic",
            "Expo / VIP / Idola / Active / Uno",
            "Expo / VIP / Idola / Active / Uno",
            "Chitose / Futura / Wellness / Star",
            "Lion Star",
            "Brother / VIP / Frontline",
            "Lokal",
            "Expo / VIP / Idola / Active / Uno",
            "Expo / VIP / Idola / Active / Uno",
            "Lokal",
            "Lokal",
            "Lokal",
            "Krisbow / Newlead / Maxiton",
            "Lokal",
            "Lokal",
            "Lokal",
            "Lokal",
            "Lokal",
            "Lokal",
            "Sucher",
            "Sucher",
            "Lokal",
            "Lokal",
            "Lokal",
            "Lokal",
            "Lenovo/HP/Dell ",
            "Epson/Fujitsu/Canon/Hp ",
            "Epson/Canon/Hp ",
            "Epson/Canon/Hp ",
            "Epson/Canon/Hp ",
            "Lenovo/HP/Dell ",
            "LG/HP/Acer ",
            "Pratesis",
            "ICA/Prolink ",
            "Dlink/Tplink ",
            "Solution ",
            "Belden/Prolink ",
            "Lokal ",
        ];
        foreach(BudgetPricing::all() as $key => $budgetpricing){

            if($brandlist[$key]!="-"){
                $list_brand = explode('/',$brandlist[$key]);
            }else{
                $list_brand = [];
            }
            $id = $key + 1;
            foreach($list_brand as $brand){
                $newBudgetBrand = new BudgetBrand;
                $newBudgetBrand->budget_pricing_id = $id;
                $newBudgetBrand->name = trim($brand);
                $newBudgetBrand->save();
            }
        }
        $typelist = [
            "-",
            "-",
            "-",
            "-",
            "-",
            "-",
            "-",
            "-",
            "-",
            "-",
            "-",
            "-",
            "-",
            "-",
            "-",
            "-",
            "-",
            "-",
            "-",
            "-",
            "-",
            "EK9350H",
            "-",
            "-",
            "50 / 55",
            "MT-3001 / MV 501",
            "-",
            "-",
            "-",
            "3 LACI",
            "Lokal",
            "160x75x75",
            "160x75x75",
            "Lokal",
            "Lokal",
            "Lokal",
            "685x1220MM W PU wheel ; karet",
            "100 x 120 x 15 cm",
            "-",
            "-",
            "-",
            "-",
            "-",
            "Sucher",
            "Sucher",
            "-",
            "-",
            "-",
            "Minimal 2200L",
            "-",
            "-",
            "-",
            "-",
            "-",
            "-",
            "-",
            "-",
            "-",
            "-",
            "-",
            "-",
            "RJ 45",
        ];
        foreach(BudgetPricing::all() as $key => $budgetpricing){

            if($typelist[$key]!="-"){
                $list_type = explode('/',$typelist[$key]);
            }else{
                $list_type = [];
            }
            $id = $key + 1;
            foreach($list_type as $type){
                $newBudgetType = new BudgetType;
                $newBudgetType->budget_pricing_id = $id;
                $newBudgetType->name = trim($type);
                $newBudgetType->save();
            }
        }

    }
}
