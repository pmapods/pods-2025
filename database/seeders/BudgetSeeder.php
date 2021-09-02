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
            $budget_brands = array(
            array('id' => '1','budget_pricing_id' => '1','name' => 'Samsung Galaxy M10','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '2','budget_pricing_id' => '2','name' => 'Panasonic','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '3','budget_pricing_id' => '2','name' => 'Daikin','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '4','budget_pricing_id' => '2','name' => 'Sharp','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '5','budget_pricing_id' => '2','name' => 'LG','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '6','budget_pricing_id' => '2','name' => 'Samsung','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '7','budget_pricing_id' => '3','name' => 'Panasonic','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '8','budget_pricing_id' => '3','name' => 'Daikin','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '9','budget_pricing_id' => '3','name' => 'Sharp','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '10','budget_pricing_id' => '3','name' => 'LG','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '11','budget_pricing_id' => '3','name' => 'Samsung','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '12','budget_pricing_id' => '4','name' => 'Panasonic','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '13','budget_pricing_id' => '4','name' => 'Daikin','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '14','budget_pricing_id' => '4','name' => 'Sharp','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '15','budget_pricing_id' => '4','name' => 'LG','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '16','budget_pricing_id' => '4','name' => 'Samsung','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '17','budget_pricing_id' => '5','name' => 'Panasonic','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '18','budget_pricing_id' => '5','name' => 'Daikin','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '19','budget_pricing_id' => '5','name' => 'Sharp','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '20','budget_pricing_id' => '5','name' => 'LG','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '21','budget_pricing_id' => '5','name' => 'Samsung','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '22','budget_pricing_id' => '6','name' => 'Panasonic','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '23','budget_pricing_id' => '6','name' => 'Daikin','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '24','budget_pricing_id' => '6','name' => 'Sharp','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '25','budget_pricing_id' => '6','name' => 'LG','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '26','budget_pricing_id' => '6','name' => 'Samsung','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '27','budget_pricing_id' => '8','name' => 'Ichiban','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '28','budget_pricing_id' => '8','name' => 'ISafe','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '29','budget_pricing_id' => '8','name' => 'Okida','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '30','budget_pricing_id' => '8','name' => 'Dragon','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '31','budget_pricing_id' => '8','name' => 'Ichiko','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '32','budget_pricing_id' => '8','name' => 'Progresif','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '33','budget_pricing_id' => '8','name' => 'Chubbsafes','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '34','budget_pricing_id' => '8','name' => 'Krisbow','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '35','budget_pricing_id' => '9','name' => 'Ichiban','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '36','budget_pricing_id' => '9','name' => 'ISafe','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '37','budget_pricing_id' => '9','name' => 'Okida','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '38','budget_pricing_id' => '9','name' => 'Dragon','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '39','budget_pricing_id' => '9','name' => 'Ichiko','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '40','budget_pricing_id' => '9','name' => 'Progresif','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '41','budget_pricing_id' => '9','name' => 'Chubbsafes','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '42','budget_pricing_id' => '9','name' => 'Krisbow','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '43','budget_pricing_id' => '10','name' => 'Indachi','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '44','budget_pricing_id' => '11','name' => 'Indachi','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '45','budget_pricing_id' => '12','name' => 'Amano','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '46','budget_pricing_id' => '12','name' => 'Time Recorder','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '47','budget_pricing_id' => '12','name' => 'Secure','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '48','budget_pricing_id' => '13','name' => 'Krisbow','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '49','budget_pricing_id' => '13','name' => 'Morgan','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '50','budget_pricing_id' => '13','name' => 'Dynamic','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '51','budget_pricing_id' => '13','name' => 'Secure','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '52','budget_pricing_id' => '17','name' => 'Daito','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '53','budget_pricing_id' => '17','name' => 'Firman','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '54','budget_pricing_id' => '17','name' => 'Tiger','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '55','budget_pricing_id' => '17','name' => 'Ryu','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '56','budget_pricing_id' => '17','name' => 'General','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '57','budget_pricing_id' => '17','name' => 'Power One','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '58','budget_pricing_id' => '18','name' => 'Infocus','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '59','budget_pricing_id' => '18','name' => 'Micro Vision','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '60','budget_pricing_id' => '22','name' => 'Krischef','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '61','budget_pricing_id' => '23','name' => 'Lokal','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '62','budget_pricing_id' => '24','name' => 'Cosmos','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '63','budget_pricing_id' => '24','name' => 'Maspion','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '64','budget_pricing_id' => '24','name' => 'GMC','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '65','budget_pricing_id' => '25','name' => 'Samsung','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '66','budget_pricing_id' => '25','name' => 'Panasonic','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '67','budget_pricing_id' => '26','name' => 'Expo','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '68','budget_pricing_id' => '26','name' => 'VIP','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '69','budget_pricing_id' => '26','name' => 'Idola','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '70','budget_pricing_id' => '26','name' => 'Active','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '71','budget_pricing_id' => '26','name' => 'Uno','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '72','budget_pricing_id' => '27','name' => 'Expo','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '73','budget_pricing_id' => '27','name' => 'VIP','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '74','budget_pricing_id' => '27','name' => 'Idola','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '75','budget_pricing_id' => '27','name' => 'Active','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '76','budget_pricing_id' => '27','name' => 'Uno','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '77','budget_pricing_id' => '28','name' => 'Chitose','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '78','budget_pricing_id' => '28','name' => 'Futura','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '79','budget_pricing_id' => '28','name' => 'Wellness','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '80','budget_pricing_id' => '28','name' => 'Star','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '81','budget_pricing_id' => '29','name' => 'Lion Star','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '82','budget_pricing_id' => '30','name' => 'Brother','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '83','budget_pricing_id' => '30','name' => 'VIP','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '84','budget_pricing_id' => '30','name' => 'Frontline','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '85','budget_pricing_id' => '31','name' => 'Lokal','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '86','budget_pricing_id' => '32','name' => 'Expo','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '87','budget_pricing_id' => '32','name' => 'VIP','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '88','budget_pricing_id' => '32','name' => 'Idola','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '89','budget_pricing_id' => '32','name' => 'Active','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '90','budget_pricing_id' => '32','name' => 'Uno','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '91','budget_pricing_id' => '33','name' => 'Expo','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '92','budget_pricing_id' => '33','name' => 'VIP','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '93','budget_pricing_id' => '33','name' => 'Idola','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '94','budget_pricing_id' => '33','name' => 'Active','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '95','budget_pricing_id' => '33','name' => 'Uno','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '96','budget_pricing_id' => '34','name' => 'Lokal','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '97','budget_pricing_id' => '35','name' => 'Lokal','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '98','budget_pricing_id' => '36','name' => 'Lokal','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '99','budget_pricing_id' => '37','name' => 'Krisbow','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '100','budget_pricing_id' => '37','name' => 'Newlead','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '101','budget_pricing_id' => '37','name' => 'Maxiton','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '102','budget_pricing_id' => '38','name' => 'Lokal','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '103','budget_pricing_id' => '39','name' => 'Lokal','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '104','budget_pricing_id' => '40','name' => 'Lokal','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '105','budget_pricing_id' => '41','name' => 'Lokal','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '106','budget_pricing_id' => '42','name' => 'Lokal','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '107','budget_pricing_id' => '43','name' => 'Lokal','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '108','budget_pricing_id' => '44','name' => 'Sucher','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '109','budget_pricing_id' => '45','name' => 'Sucher','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '110','budget_pricing_id' => '46','name' => 'Lokal','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '111','budget_pricing_id' => '47','name' => 'Lokal','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '112','budget_pricing_id' => '48','name' => 'Lokal','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '113','budget_pricing_id' => '49','name' => 'Lokal','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '114','budget_pricing_id' => '50','name' => 'Lenovo','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '115','budget_pricing_id' => '50','name' => 'HP','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '116','budget_pricing_id' => '50','name' => 'Dell','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '117','budget_pricing_id' => '51','name' => 'Epson','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '118','budget_pricing_id' => '51','name' => 'Fujitsu','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '119','budget_pricing_id' => '51','name' => 'Canon','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '120','budget_pricing_id' => '51','name' => 'Hp','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '121','budget_pricing_id' => '52','name' => 'Epson','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '122','budget_pricing_id' => '52','name' => 'Canon','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '123','budget_pricing_id' => '52','name' => 'Hp','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '124','budget_pricing_id' => '53','name' => 'Epson','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '125','budget_pricing_id' => '53','name' => 'Canon','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '126','budget_pricing_id' => '53','name' => 'Hp','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '127','budget_pricing_id' => '54','name' => 'Epson','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '128','budget_pricing_id' => '54','name' => 'Canon','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '129','budget_pricing_id' => '54','name' => 'Hp','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '130','budget_pricing_id' => '55','name' => 'Lenovo','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '131','budget_pricing_id' => '55','name' => 'HP','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '132','budget_pricing_id' => '55','name' => 'Dell','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '133','budget_pricing_id' => '56','name' => 'LG','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '134','budget_pricing_id' => '56','name' => 'HP','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '135','budget_pricing_id' => '56','name' => 'Acer','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '136','budget_pricing_id' => '57','name' => 'Pratesis','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '137','budget_pricing_id' => '58','name' => 'ICA','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '138','budget_pricing_id' => '58','name' => 'Prolink','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '139','budget_pricing_id' => '59','name' => 'Dlink','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '140','budget_pricing_id' => '59','name' => 'Tplink','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '141','budget_pricing_id' => '60','name' => 'Solution','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '142','budget_pricing_id' => '61','name' => 'Belden','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '143','budget_pricing_id' => '61','name' => 'Prolink','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '144','budget_pricing_id' => '62','name' => 'Lokal','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05')
        );
        
            $budget_pricings = array(
            array('id' => '1','budget_pricing_category_id' => '1','code' => 'OE-01','name' => 'Handheld','uom' => 'Unit','injs_min_price' => '0','injs_max_price' => '1705000','outjs_min_price' => '0','outjs_max_price' => '1705000','isAsset' => '1','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '2','budget_pricing_category_id' => '1','code' => 'OE-02','name' => 'AC (1/2 PK)','uom' => 'Unit','injs_min_price' => '0','injs_max_price' => '3800000','outjs_min_price' => '0','outjs_max_price' => '4000000','isAsset' => '1','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '3','budget_pricing_category_id' => '1','code' => 'OE-03','name' => 'AC (3/4 PK)','uom' => 'Unit','injs_min_price' => '0','injs_max_price' => '3900000','outjs_min_price' => '0','outjs_max_price' => '4500000','isAsset' => '1','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '4','budget_pricing_category_id' => '1','code' => 'OE-04','name' => 'AC (1 PK)','uom' => 'Unit','injs_min_price' => '0','injs_max_price' => '4600000','outjs_min_price' => '0','outjs_max_price' => '5250000','isAsset' => '1','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '5','budget_pricing_category_id' => '1','code' => 'OE-05','name' => 'AC (1,5 PK)','uom' => 'Unit','injs_min_price' => '0','injs_max_price' => '5500000','outjs_min_price' => '0','outjs_max_price' => '6300000','isAsset' => '1','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '6','budget_pricing_category_id' => '1','code' => 'OE-06','name' => 'AC (2 PK)','uom' => 'Unit','injs_min_price' => '0','injs_max_price' => '7100000','outjs_min_price' => '0','outjs_max_price' => '7350000','isAsset' => '1','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '7','budget_pricing_category_id' => '1','code' => 'OE-07','name' => 'Penambahan pipa & selang (per meter & per unit)','uom' => 'Meter','injs_min_price' => '0','injs_max_price' => '100000','outjs_min_price' => '0','outjs_max_price' => '100000','isAsset' => '0','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '8','budget_pricing_category_id' => '1','code' => 'OE-08','name' => 'Brankas Kecil  uk. 730x460x510 - Depo / CP ','uom' => 'Unit','injs_min_price' => '0','injs_max_price' => '9450000','outjs_min_price' => '0','outjs_max_price' => '9450000','isAsset' => '1','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '9','budget_pricing_category_id' => '1','code' => 'OE-09','name' => 'Brankas Besar uk. 1020x650x600 - Cabang ','uom' => 'Unit','injs_min_price' => '0','injs_max_price' => '13000000','outjs_min_price' => '0','outjs_max_price' => '15000000','isAsset' => '1','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '10','budget_pricing_category_id' => '1','code' => 'OE-10','name' => 'Brankas faktur 3 laci - MT  Only','uom' => 'Unit','injs_min_price' => '0','injs_max_price' => '20000000','outjs_min_price' => '0','outjs_max_price' => '22000000','isAsset' => '1','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '11','budget_pricing_category_id' => '1','code' => 'OE-11','name' => 'Brankas faktur 4 laci - MT Only','uom' => 'Unit','injs_min_price' => '0','injs_max_price' => '25000000','outjs_min_price' => '0','outjs_max_price' => '27000000','isAsset' => '1','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '12','budget_pricing_category_id' => '1','code' => 'OE-12','name' => 'Mesin Absensi Manual + Card Rack','uom' => 'Unit','injs_min_price' => '0','injs_max_price' => '3500000','outjs_min_price' => '0','outjs_max_price' => '3675000','isAsset' => '1','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '13','budget_pricing_category_id' => '1','code' => 'OE-13','name' => 'Money Counter','uom' => 'Unit','injs_min_price' => '0','injs_max_price' => '3675000','outjs_min_price' => '0','outjs_max_price' => '4200000','isAsset' => '1','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '14','budget_pricing_category_id' => '1','code' => 'OE-14','name' => 'Lampu UV Money detector','uom' => 'Unit','injs_min_price' => '0','injs_max_price' => '450000','outjs_min_price' => '0','outjs_max_price' => '450000','isAsset' => '0','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '15','budget_pricing_category_id' => '1','code' => 'OE-15','name' => 'Emergency Light','uom' => 'Unit','injs_min_price' => '0','injs_max_price' => '500000','outjs_min_price' => '0','outjs_max_price' => '500000','isAsset' => '0','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '16','budget_pricing_category_id' => '1','code' => 'OE-16','name' => 'Cash Box u/ Kasir','uom' => 'Box','injs_min_price' => '0','injs_max_price' => '500000','outjs_min_price' => '0','outjs_max_price' => '500000','isAsset' => '0','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '17','budget_pricing_category_id' => '1','code' => 'OE-17','name' => 'Genset 5500 - 6600 Watt','uom' => 'Unit','injs_min_price' => '0','injs_max_price' => '10395000','outjs_min_price' => '0','outjs_max_price' => '11550000','isAsset' => '1','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '18','budget_pricing_category_id' => '1','code' => 'OE-18','name' => 'LCD Proyektor','uom' => 'Unit','injs_min_price' => '0','injs_max_price' => '5500000','outjs_min_price' => '0','outjs_max_price' => '5500000','isAsset' => '1','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '19','budget_pricing_category_id' => '1','code' => 'OE-19','name' => 'Dispenser','uom' => 'Unit','injs_min_price' => '0','injs_max_price' => '600000','outjs_min_price' => '0','outjs_max_price' => '600000','isAsset' => '0','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '20','budget_pricing_category_id' => '1','code' => 'OE-20','name' => 'Kotak Peluru','uom' => 'Box','injs_min_price' => '0','injs_max_price' => '300000','outjs_min_price' => '0','outjs_max_price' => '400000','isAsset' => '0','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '21','budget_pricing_category_id' => '1','code' => 'OE-21','name' => 'Apar','uom' => 'Tabung','injs_min_price' => '0','injs_max_price' => '1250000','outjs_min_price' => '0','outjs_max_price' => '1250000','isAsset' => '0','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '22','budget_pricing_category_id' => '1','code' => 'OE-22','name' => 'Timbangan Uang Coin','uom' => 'Unit','injs_min_price' => '0','injs_max_price' => '350000','outjs_min_price' => '0','outjs_max_price' => '400000','isAsset' => '0','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '23','budget_pricing_category_id' => '1','code' => 'OE-23','name' => 'Handphone','uom' => 'Unit','injs_min_price' => '0','injs_max_price' => '300000','outjs_min_price' => '0','outjs_max_price' => '300000','isAsset' => '0','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '24','budget_pricing_category_id' => '1','code' => 'OE-24','name' => 'Kipas Angin ','uom' => 'Unit','injs_min_price' => '0','injs_max_price' => '400000','outjs_min_price' => '0','outjs_max_price' => '400000','isAsset' => '0','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '25','budget_pricing_category_id' => '1','code' => 'OE-25','name' => 'Smart TV','uom' => 'Unit','injs_min_price' => '0','injs_max_price' => '7000000','outjs_min_price' => '0','outjs_max_price' => '7000000','isAsset' => '1','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '26','budget_pricing_category_id' => '2','code' => 'FF-01','name' => 'Meja 1/2 Biro + laci','uom' => 'Unit','injs_min_price' => '0','injs_max_price' => '787500','outjs_min_price' => '0','outjs_max_price' => '997500','isAsset' => '0','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '27','budget_pricing_category_id' => '2','code' => 'FF-02','name' => 'Meja 1/2 biro utk ruang meeting','uom' => 'Unit','injs_min_price' => '0','injs_max_price' => '787500','outjs_min_price' => '0','outjs_max_price' => '997500','isAsset' => '0','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '28','budget_pricing_category_id' => '2','code' => 'FF-03','name' => 'Kursi susun ','uom' => 'Unit','injs_min_price' => '0','injs_max_price' => '420000','outjs_min_price' => '0','outjs_max_price' => '525000','isAsset' => '0','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '29','budget_pricing_category_id' => '2','code' => 'FF-04','name' => 'Kursi plastik','uom' => 'Unit','injs_min_price' => '0','injs_max_price' => '78750','outjs_min_price' => '0','outjs_max_price' => '78750','isAsset' => '0','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '30','budget_pricing_category_id' => '2','code' => 'FF-05','name' => 'Lemari file 3 laci ','uom' => 'Unit','injs_min_price' => '0','injs_max_price' => '1785000','outjs_min_price' => '0','outjs_max_price' => '2100000','isAsset' => '1','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '31','budget_pricing_category_id' => '2','code' => 'FF-06','name' => 'Lemari Arsip 3 laci untuk Gudang (plastik)','uom' => 'Unit','injs_min_price' => '0','injs_max_price' => '700000','outjs_min_price' => '0','outjs_max_price' => '700000','isAsset' => '0','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '32','budget_pricing_category_id' => '2','code' => 'FF-07','name' => 'Meja 1 biro utk ruang meeting','uom' => 'Unit','injs_min_price' => '0','injs_max_price' => '1250000','outjs_min_price' => '0','outjs_max_price' => '1350000','isAsset' => '1','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '33','budget_pricing_category_id' => '2','code' => 'FF-08','name' => ' Meja 1 biro tanpa laci utk salesman','uom' => 'Unit','injs_min_price' => '0','injs_max_price' => '1312500','outjs_min_price' => '0','outjs_max_price' => '1417500','isAsset' => '1','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '34','budget_pricing_category_id' => '2','code' => 'FF-09','name' => 'Rak arsip ','uom' => 'Unit','injs_min_price' => '0','injs_max_price' => '1250000','outjs_min_price' => '0','outjs_max_price' => '1250000','isAsset' => '1','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '35','budget_pricing_category_id' => '2','code' => 'FF-10','name' => 'Locker Uang (4 Pintu)','uom' => 'Unit','injs_min_price' => '0','injs_max_price' => '1200000','outjs_min_price' => '0','outjs_max_price' => '1500000','isAsset' => '1','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '36','budget_pricing_category_id' => '2','code' => 'FF-11','name' => 'Locker Uang (6 Pintu)','uom' => 'Unit','injs_min_price' => '0','injs_max_price' => '1500000','outjs_min_price' => '0','outjs_max_price' => '1800000','isAsset' => '1','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '37','budget_pricing_category_id' => '3','code' => 'WE-01','name' => 'Hand Pallet 2 ton (BIG)-bahan karet','uom' => 'Unit','injs_min_price' => '0','injs_max_price' => '4200000','outjs_min_price' => '0','outjs_max_price' => '4800000','isAsset' => '1','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '38','budget_pricing_category_id' => '3','code' => 'WE-02','name' => 'Pallet Kayu','uom' => 'Pcs','injs_min_price' => '0','injs_max_price' => '115000','outjs_min_price' => '0','outjs_max_price' => '157500','isAsset' => '0','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '39','budget_pricing_category_id' => '3','code' => 'WE-03','name' => 'Trolly 150 kg','uom' => 'Unit','injs_min_price' => '0','injs_max_price' => '500000','outjs_min_price' => '0','outjs_max_price' => '650000','isAsset' => '0','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '40','budget_pricing_category_id' => '3','code' => 'WE-04','name' => 'Trolly 300 kg ','uom' => 'Unit','injs_min_price' => '0','injs_max_price' => '750000','outjs_min_price' => '0','outjs_max_price' => '750000','isAsset' => '0','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '41','budget_pricing_category_id' => '3','code' => 'WE-05','name' => 'Trolly Roda 4','uom' => 'Unit','injs_min_price' => '0','injs_max_price' => '1400000','outjs_min_price' => '0','outjs_max_price' => '1400000','isAsset' => '1','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '42','budget_pricing_category_id' => '3','code' => 'WE-06','name' => 'Tangga Lipat 2M','uom' => 'Unit','injs_min_price' => '0','injs_max_price' => '1000000','outjs_min_price' => '0','outjs_max_price' => '1000000','isAsset' => '1','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '43','budget_pricing_category_id' => '5','code' => 'OT-01','name' => 'Racking Gudang  (per meter)','uom' => 'M2','injs_min_price' => '0','injs_max_price' => '600000','outjs_min_price' => '0','outjs_max_price' => '700000','isAsset' => '1','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '44','budget_pricing_category_id' => '5','code' => 'OT-02','name' => 'CCTV 4 kamera','uom' => 'Set','injs_min_price' => '0','injs_max_price' => '8000000','outjs_min_price' => '0','outjs_max_price' => '8000000','isAsset' => '1','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '45','budget_pricing_category_id' => '5','code' => 'OT-03','name' => 'CCTV 8 kamera','uom' => 'Set','injs_min_price' => '0','injs_max_price' => '10500000','outjs_min_price' => '0','outjs_max_price' => '11500000','isAsset' => '1','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '46','budget_pricing_category_id' => '5','code' => 'OT-04','name' => 'Monitoring Board tanpa kaki ','uom' => 'Unit','injs_min_price' => '0','injs_max_price' => '900000','outjs_min_price' => '0','outjs_max_price' => '1400000','isAsset' => '0','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '47','budget_pricing_category_id' => '5','code' => 'OT-05','name' => 'Monitoring Board pakai kaki ','uom' => 'Unit','injs_min_price' => '0','injs_max_price' => '1600000','outjs_min_price' => '0','outjs_max_price' => '2000000','isAsset' => '1','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '48','budget_pricing_category_id' => '5','code' => 'OT-06','name' => 'Stavol 5000 Watt','uom' => 'Unit','injs_min_price' => '0','injs_max_price' => '3850000','outjs_min_price' => '0','outjs_max_price' => '4400000','isAsset' => '1','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '49','budget_pricing_category_id' => '5','code' => 'OT-07','name' => 'Tandon Air ','uom' => 'Unit','injs_min_price' => '0','injs_max_price' => '2500000','outjs_min_price' => '0','outjs_max_price' => '2500000','isAsset' => '0','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '50','budget_pricing_category_id' => '6','code' => 'TC-01','name' => 'PC Client','uom' => 'Unit','injs_min_price' => '8500000','injs_max_price' => '10450000','outjs_min_price' => '9000000','outjs_max_price' => '10450000','isAsset' => '1','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '51','budget_pricing_category_id' => '6','code' => 'TC-02','name' => 'Printer Dot Matrix ','uom' => 'Unit','injs_min_price' => '8925000','injs_max_price' => '9975000','outjs_min_price' => '8925000','outjs_max_price' => '9975000','isAsset' => '1','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '52','budget_pricing_category_id' => '6','code' => 'TC-03','name' => 'Printer Multifungsi ','uom' => 'Unit','injs_min_price' => '3150000','injs_max_price' => '4200000','outjs_min_price' => '3150000','outjs_max_price' => '4200000','isAsset' => '1','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '53','budget_pricing_category_id' => '6','code' => 'TC-04','name' => 'Printer Laserjet ','uom' => 'Unit','injs_min_price' => '1575000','injs_max_price' => '2100000','outjs_min_price' => '1575000','outjs_max_price' => '2100000','isAsset' => '1','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '54','budget_pricing_category_id' => '6','code' => 'TC-05','name' => 'Scanner','uom' => 'Unit','injs_min_price' => '1312500','injs_max_price' => '1575000','outjs_min_price' => '1312500','outjs_max_price' => '1575000','isAsset' => '1','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '55','budget_pricing_category_id' => '6','code' => 'TC-06','name' => 'Server ','uom' => 'Unit','injs_min_price' => '19425000','injs_max_price' => '21000000','outjs_min_price' => '19425000','outjs_max_price' => '21000000','isAsset' => '1','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '56','budget_pricing_category_id' => '6','code' => 'TC-07','name' => 'Monitor Server','uom' => 'Unit','injs_min_price' => '1312500','injs_max_price' => '1575000','outjs_min_price' => '1312500','outjs_max_price' => '1575000','isAsset' => '1','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '57','budget_pricing_category_id' => '6','code' => 'TC-08','name' => 'License SCYLLA','uom' => 'Unit','injs_min_price' => '14175000','injs_max_price' => '15750000','outjs_min_price' => '14175000','outjs_max_price' => '15750000','isAsset' => '1','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '58','budget_pricing_category_id' => '6','code' => 'TC-09','name' => 'UPS 1200va','uom' => 'Unit','injs_min_price' => '1050000','injs_max_price' => '1575000','outjs_min_price' => '1050000','outjs_max_price' => '1575000','isAsset' => '1','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '59','budget_pricing_category_id' => '6','code' => 'TC-10','name' => 'Switch 16 port','uom' => 'Unit','injs_min_price' => '735000','injs_max_price' => '945000','outjs_min_price' => '735000','outjs_max_price' => '945000','isAsset' => '0','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '60','budget_pricing_category_id' => '6','code' => 'TC-11','name' => 'Finger Scan','uom' => 'Unit','injs_min_price' => '2100000','injs_max_price' => '2835000','outjs_min_price' => '2100000','outjs_max_price' => '2835000','isAsset' => '1','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '61','budget_pricing_category_id' => '6','code' => 'TC-12','name' => 'Kabel Jaringan LAN','uom' => 'Meter','injs_min_price' => '1365000','injs_max_price' => '1890000','outjs_min_price' => '1365000','outjs_max_price' => '1890000','isAsset' => '0','deleted_at' => null,'created_at' => null,'updated_at' => null),
            array('id' => '62','budget_pricing_category_id' => '6','code' => 'TC-13','name' => 'Connector RJ45 ( per pax) ','uom' => 'Pcs','injs_min_price' => '105000','injs_max_price' => '157500','outjs_min_price' => '105000','outjs_max_price' => '157500','isAsset' => '0','deleted_at' => null,'created_at' => null,'updated_at' => null)
        );
        
            $budget_types = array(
            array('id' => '1','budget_pricing_id' => '22','name' => 'EK9350H','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '2','budget_pricing_id' => '25','name' => '50','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '3','budget_pricing_id' => '25','name' => '55','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '4','budget_pricing_id' => '26','name' => 'MT-3001','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '5','budget_pricing_id' => '26','name' => 'MV 501','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '6','budget_pricing_id' => '30','name' => '3 LACI','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '7','budget_pricing_id' => '31','name' => 'Lokal','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '8','budget_pricing_id' => '32','name' => '160x75x75','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '9','budget_pricing_id' => '33','name' => '160x75x75','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '10','budget_pricing_id' => '34','name' => 'Lokal','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '11','budget_pricing_id' => '35','name' => 'Lokal','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '12','budget_pricing_id' => '36','name' => 'Lokal','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '13','budget_pricing_id' => '37','name' => '685x1220MM W PU wheel ; karet','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '14','budget_pricing_id' => '38','name' => '100 x 120 x 15 cm','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '15','budget_pricing_id' => '44','name' => 'Sucher','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '16','budget_pricing_id' => '45','name' => 'Sucher','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '17','budget_pricing_id' => '49','name' => 'Minimal 2200L','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05'),
            array('id' => '18','budget_pricing_id' => '62','name' => 'RJ 45','created_at' => '2021-09-02 17:05:05','updated_at' => '2021-09-02 17:05:05')
        );

        foreach($budget_types as $budget_type){
            $newBudgetType                     = new BudgetType;
            $newBudgetType->id                 = $budget_type['id'];
            $newBudgetType->budget_pricing_id  = $budget_type['budget_pricing_id'];
            $newBudgetType->name               = $budget_type['name'];
        }
        foreach($budget_pricings as $budget_pricing){
            $newBudget = new BudgetPricing;
            $newBudget->id = $budget_pricing['id'];
            $newBudget->budget_pricing_category_id = $budget_pricing['budget_pricing_category_id'];
            $newBudget->code = $budget_pricing['code'];
            $newBudget->name = $budget_pricing['name'];
            $newBudget->uom = $budget_pricing['uom'];
            $newBudget->injs_min_price = $budget_pricing['injs_min_price'];
            $newBudget->injs_max_price = $budget_pricing['injs_max_price'];
            $newBudget->outjs_min_price = $budget_pricing['outjs_min_price'];
            $newBudget->outjs_max_price = $budget_pricing['outjs_max_price'];
            $newBudget->isAsset = $budget_pricing['isAsset'];
            $newBudget->save();
        }
        foreach($budget_brands as $budget_brand){
            $newBudgetbrand = new BudgetBrand;
            $newBudgetbrand->id = $budget_brand['id'];
            $newBudgetbrand->budget_pricing_id = $budget_brand['budget_pricing_id'];
            $newBudgetbrand->name = $budget_brand['name'];
            $newBudgetbrand->save();
        }
    }
}
