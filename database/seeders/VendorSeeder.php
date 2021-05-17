<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vendor;
use App\Models\Regency;
use Faker\Factory as Faker;
use DB;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $faker = Faker::create('id_ID');
        // for($i=0; $i<100; $i++){
        //     $newVendor                = new Vendor;
        //     $newVendor->code          = 'V-'.$i;
        //     $newVendor->name          = $faker->company();
        //     $newVendor->address       = $faker->address();
        //     $newVendor->city_id       = Regency::inRandomOrder()->first()->id;
        //     $newVendor->salesperson   = $faker->firstName();
        //     $newVendor->phone         = $faker->phoneNumber();
        //     $newVendor->email         = $faker->freeEmail();
        //     $newVendor->save();
        // }
        DB::unprepared("
        /* INSERT QUERY NO: 1 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100100305', 'NUTRIBEV NABATI INDONESIA  PT', 'Jl Soekarno Hatta No 112  Kecamata', 3273, 'Niki', '0815-8509-1484', ''
        );
        
        /* INSERT QUERY NO: 2 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100100307', 'LOTTE INDONESIA  PT', 'E-3 KAWASAN INDUSTRI MM2100 BLOK E-', 3216, 'Fujita Ryo', '021 22766700 Ext', ''
        );
        
        /* INSERT QUERY NO: 3 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100100308', 'NISSIN FOODS INDONESIA  PT', 'JL JABABEKA RAYA BLOK N-1 KAWASAN', 3216, 'MOCH HERU HARISA', '0811-8000049', ''
        );
        
        /* INSERT QUERY NO: 4 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100100309', 'MEIJI FOOD INDONESIA  PT', 'J-2B JL MALIGI III LOT-2B KAWASAN', 3215, 'Mesra', '+62 811-899-226', ''
        );
        
        /* INSERT QUERY NO: 5 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100100310', 'ATRI DISTRIBUSINDO  PT', 'GEDUNG ALFA TOWER LT 23 JL JALUR', 3603, 'Ardiyanto ', '+62 812-1434-0107', ''
        );
        
        /* INSERT QUERY NO: 6 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100100311', 'MAKMUR ARTHA SEJAHTERA  PT', '25 RUKO TOHO BLOK B NO 25 PANTAI I', 3173, 'Budi ', '+62 812-1866-1418', ''
        );
        
        /* INSERT QUERY NO: 7 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100100312', 'ELLEAIR INTERNATIONAL TRADING INDON', 'WISMA BNI 46 KOTA BNI LT15 JL JEN', 3173, 'Beryl ', '+62 811-8751-591', ''
        );
        
        /* INSERT QUERY NO: 8 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100100313', 'STANLI TRIJAYA MANDIRI  PT', '115 Jl Terusan Kopo Km11 5 Kawasa', 3273, 'Nita', '+62 896-9968-7752', ''
        );
        
        /* INSERT QUERY NO: 9 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100100501', 'MAKMUR MANDIRI PRATAMA  PT', 'JL KEBON KANGKUNG NO 181 - 182', 3273, 'Meindra Pratama', '0895-1729-6343', ''
        );
        
        /* INSERT QUERY NO: 10 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100100503', 'SAYAP MAS UTAMA  PT', 'JL L TIPAR CAKUNG KAV F 5-7  C', 3173, 'Ellya Maron Sandi', '0857-0100-0305', ''
        );
        
        /* INSERT QUERY NO: 11 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100100505', 'TRIYANTO SUKSES MANDIRI  PT', 'Jl AH NASUTION KM 10 NO 6 - 8', 3273, 'Marimin', '0813-2049-519', ''
        );
        
        /* INSERT QUERY NO: 12 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100100506', 'ULTRAJAYA  PT', 'JL MAHAR MARTANEGARA NO 133', 3277, 'Abdul Hakim', '0813-2244-2908', ''
        );
        
        /* INSERT QUERY NO: 13 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100100507', 'PUTRI DAYA USAHATAMA  PT', 'JL RUMAH SAKIT NO 133 PANYILEUKAN', 3273, 'Rahmat Supriatna', '0811-2293-759', ''
        );
        
        /* INSERT QUERY NO: 14 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100100508', 'ROSEBRAND', 'JL SOEKARNO HATTA NO 160', 3273, 'Daniel Julisman', '0818-0206-0500', ''
        );
        
        /* INSERT QUERY NO: 15 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100100509', 'JUJUR CITRA SENTOSA  CV', 'JL SATRIA RAYA 1 NO 5 MARGAHAYU U', 3273, 'Budi Satoto', '0813-1282-8428', ''
        );
        
        /* INSERT QUERY NO: 16 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100100510', 'FASTRATA BUANA  PT', 'JL SOEKARNO HATTA NO 767', 3273, 'Farida Efiana', '0816-628-027', ''
        );
        
        /* INSERT QUERY NO: 17 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100100511', 'UNIVESUS  PT', 'JL Giri Asih Permai KM 5 5 Batujaja', 3273, 'Yudha Chandra Permana', '0813-2249-6716', ''
        );
        
        /* INSERT QUERY NO: 18 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100100513', 'SURYA GLOBALINDO GEMILANG  PT', 'KOMPLEK BIZPARK G NOMOR 12 CIRANGRA', 3273, 'Yuni Sugiarti', '0812-4085-6299', ''
        );
        
        /* INSERT QUERY NO: 19 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100100515', 'SUMBER CIPTA MULTINIAGA  PT', 'JL SOEKARNO HATTA NO 785', 3273, 'Yayan Sopyan Sauri', '0853-1764-3998', ''
        );
        
        /* INSERT QUERY NO: 20 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100100516', 'MAHAMERU MEKAR DJAYA  PT', 'JL SOEKARNO HATTA NO736', 3273, 'RYAN RIZKI NUGRAHA', '0812-14360939', ''
        );
        
        /* INSERT QUERY NO: 21 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100100517', 'NUTRIBEV SINERGY INDONESIA', 'JL SOEKARNO HATTA NO112', 3273, 'Niki ', '0815-8509-1484', ''
        );
        
        /* INSERT QUERY NO: 22 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100300592', 'PRATESIS  PT', '1 JL MAMPANG PRAPATAN RAYA', 3173, 'HANJONO', '085273535030', ''
        );
        
        /* INSERT QUERY NO: 23 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100300713', 'Electronic Smart Solution', '7 JL PINANGSIA RAYA PLAZA PINANGSI', 3173, 'TITIN', '08174899985', ''
        );
        
        /* INSERT QUERY NO: 24 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100300720', 'KAWAN BARU COMPUTER  CV', '47 JL IBRAHIM ADJIE', 3273, 'RILLA', '082130266465', ''
        );
        
        /* INSERT QUERY NO: 25 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100300916', 'METRINDO SUPRA SINATRIA  PT', '1 JL SURYOPRANOTO BLOK A4 7', 3173, 'AGUSTINA', '087878591833', ''
        );
        
        /* INSERT QUERY NO: 26 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100301143', 'LINUXINDO  PT', '28 JL LETJEND SPARMAN KAV28', 3173, 'HERAWATI', '0818179199', ''
        );
        
        /* INSERT QUERY NO: 27 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100301482', 'PIONEER KREASI  PT', '33 JL TOMANG RAYA jakarta pusat BARAT', 3173, 'HENDRA', '085811835253', ''
        );
        
        /* INSERT QUERY NO: 28 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100301528', 'ALTROS TEKNOLOGI  PT', '43 JL BANDENGAN SELATAN', 3173, 'MARIA', '085782821992', ''
        );
        
        /* INSERT QUERY NO: 29 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100301564', 'ADDROO SOFTWARE TRANSFORMA  PT', '23 PERKANTORAN PREMIER VILLAGE M', 3671, 'RANGGA', '08111807890', ''
        );
        
        /* INSERT QUERY NO: 30 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100301595', 'INOV PERDANATEKNOLOGI  PT', '6 JLTEUKU NYAK ARIEF BLOK CC CC NO', 3171, 'AYU TRIASTUTI', '81315036591', ''
        );
        
        /* INSERT QUERY NO: 31 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100301609', 'GTI  TK', '8 JLGALAXY RAYA RUKO PORIS CEN', 3603, 'META', '087878786978', ''
        );
        
        /* INSERT QUERY NO: 32 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100301641', 'ASIA NUSANTARA GLOBAL', '7 BUDIONO WIJAYA ISTANA REGENCY SUD', 3273, 'SUCI PERTIWI', '08978041726', ''
        );
        
        /* INSERT QUERY NO: 33 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100301690', 'SATU ANUGRAH SOLUSINDO  PT', '53 JL KRAMAT SENTIONG', 3173, 'DINI', '088210579327', ''
        );
        
        /* INSERT QUERY NO: 34 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100301691', 'BHINNEKA MENTARIDIMENSI  PT', '73C/5-6 JL GUNUNG SAHARI RAYA', 3173, 'AZIZAH KINANTI', '085710615796', ''
        );
        
        /* INSERT QUERY NO: 35 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100301692', 'ANUGRAH BERKAT SOLUSI UTAMA  PT', '7-8 GD PLAZA PINANGSIA LT 1', 3173, 'TITIN', '089642569182', ''
        );
        
        /* INSERT QUERY NO: 36 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100301693', 'PILAR GLOBAL SOLUSI  PT', '10B-C JL WAHID HASHIM', 3173, 'RETNO DYAH PUSPA RATIH', '0815-1333-8869', ''
        );
        
        /* INSERT QUERY NO: 37 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100301694', 'SUMBER UTAMA GLOBAL  CV', '19 JL DEWI SARTIKA', 3215, 'HERYANTO KURNIAWAN', '0812-8452-2555', ''
        );
        
        /* INSERT QUERY NO: 38 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100301695', 'GLOBAL MILENIA TEKNOLOGI  PT', '17 JL S PARMAN TANJUNG DUREN SELATA', 3173, 'MERY', '021-21257738', ''
        );
        
        /* INSERT QUERY NO: 39 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100302018', 'THE NIELSEN COMPANY INDONESIA  PT', '28 MAYAPADA TOWER 1 LT 15 JL JENDR', 3173, 'ANGGI', '021-293983000', ''
        );
        
        /* INSERT QUERY NO: 40 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100400245', 'KALIBESAR RAYA UTAMA  PT', '18 JL FACHRUD WISMA SINAR MAS DIPT', 3273, 'JANE', '088802128888', ''
        );
        
        /* INSERT QUERY NO: 41 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100400313', 'MULTINIAGA INTERMEDIA PROTEKSI  PT', '15 KOMPLEK GOLDEN PLAZA BLOK G 10', 3173, 'DAVID SETIADI', '021-7658533', ''
        );
        
        /* INSERT QUERY NO: 42 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100400348', 'MAHA GIRI SENTOSA  PT', '30 TAMAN INDAH REGENCY BLOK CC', 3515, 'Bekti', '082230031777', ''
        );
        
        /* INSERT QUERY NO: 43 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100408124', 'MARGO JOYO', 'lll/17 KEDINDING TENGAH JAYA', 3578, 'Tony', '022-87799644', ''
        );
        
        /* INSERT QUERY NO: 44 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100600013', 'SERASI AUTO RAYA  PT', '811 JL SOEKARNO HATTA', 3273, 'Estu', '081314837097', ''
        );
        
        /* INSERT QUERY NO: 45 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100600042', 'INDOCARE PACIFIC  PT', '22-24 JL S Parman Kav 22-24 Slip', 3173, 'RIZKY', '81283826584', ''
        );
        
        /* INSERT QUERY NO: 46 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100600166', 'ADI SARANA ARMADA TBK  PT', '478 JL SOEKARNO HATTA', 3273, 'CLAUDIUS', '081290399983', ''
        );
        
        /* INSERT QUERY NO: 47 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100600245', 'KALIBESAR RAYA UTAMA  PT', 'WISMA SINAR MAS DIPTA  JLN FACHRUD', 3173, 'Yani', '021-3902141', ''
        );
        
        /* INSERT QUERY NO: 48 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100600536', 'JALUR NUGRAHA EKAKURIR  PT', '11 JL TOMANG RAYA', 3173, 'Arini ', '+085643906260', ''
        );
        
        /* INSERT QUERY NO: 49 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100600594', 'AGRA DIPA RAHARJA  PT', '17 JL OTO ISKANDARDINATA', 3273, 'Fakhira Nazma', '0851-0888-7788', ''
        );
        
        /* INSERT QUERY NO: 50 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100600602', 'ANGKASA PUTRA  PT', '77 JL CIHAMPELAS', 3273, 'HARRY', '085104549446', ''
        );
        
        /* INSERT QUERY NO: 51 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100600603', 'CEMARA MULTI KREATIF  PT', '67 JL CEMARA', 3273, 'GILAR', '0812-2998-847', ''
        );
        
        /* INSERT QUERY NO: 52 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100600604', 'MITRASATRYA PERKASAUTAMA  PT', 'JL RAYA PASAR KEMIS', 3603, 'YULI', '0815-1980-858', ''
        );
        
        /* INSERT QUERY NO: 53 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100600605', 'CITRA INTI GARDA SENTOSA  PT', 'PERUMAHAN ANTASARI PERMAI BLOK NO', 3273, 'DIANA UTAMI', '0812-8284-4808', ''
        );
        
        /* INSERT QUERY NO: 54 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100600606', 'UNITED PRODUCT INTERNATIONAL INDONE', '12 JL DANAU SUNTER UTARA KAV60', 3173, 'SOFIANA KUSUMA DEWI', '085817208074', ''
        );
        
        /* INSERT QUERY NO: 55 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100600607', 'BALAI LELANG SERASI  PT', 'I/3 JL BINTARO MULIA', 3173, 'INDAH SEPRIANTI', '0818-824880', ''
        );
        
        /* INSERT QUERY NO: 56 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100600608', 'DELI GROUP INDONESIA  PT', '12 RUKAN PLAZA SUNTER TERRACE JL D', 3173, 'SOFIANA KUSUMA DEWI', '085817208074', ''
        );
        
        /* INSERT QUERY NO: 57 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100600609', 'MITRASATRYA PERKASAUTAMA  PT', 'JL RAYA PASAR KEMIS', 3603, 'YULI', '0815-1980-858', ''
        );
        
        /* INSERT QUERY NO: 58 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100600673', 'CAKRA SATYA INTERNUSA  PT', '20-21 BUSINESS PARK KALIDERES  CITY', 3173, 'ANNAN', '087777807654', ''
        );
        
        /* INSERT QUERY NO: 59 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100600680', 'INDONESIA COMNETS PLUS  PT', '58 JL SUPRATMAN', 3273, 'IRAWATI', '081322806209', ''
        );
        
        /* INSERT QUERY NO: 60 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100600695', 'MITRA PINASTHIKA MUSTIKA RENT  PT', '10 JL KPT SOEBIJANTO DJOJOHADIKUSU', 3603, 'EMILIA', '081281088902', ''
        );
        
        /* INSERT QUERY NO: 61 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100600700', 'TARANTULA MULTIDAYA SERVIS  PT', '163 JL PENGAIRAN', 3273, 'RINO', '081220864672', ''
        );
        
        /* INSERT QUERY NO: 62 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100600804', 'RUMAH KARTU', '30 JL KRAN II Gg SPOR 4 RT 3 RW', 3173, 'JEERY SETIAWAN', '0812-8116-9116', ''
        );
        
        /* INSERT QUERY NO: 63 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100600845', 'CANDRA PERKASA MANDIRI  PT', '9 JL CEMARA PONDOK RANJI BINTARO', 3173, 'TITIS', '087888215685', ''
        );
        
        /* INSERT QUERY NO: 64 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100600971', 'MULIAFORM GRAFIDO  PT', '20 KWS IND CANDI BLOK 20 A', 3322, 'NITA', '082116754208', ''
        );
        
        /* INSERT QUERY NO: 65 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601008', 'MULTIGRAFIKA GLOBAL  PT', '88 JL SULTAN ISKANDAR MUDA', 3173, 'Lukas Suteja ', '021-72789482', ''
        );
        
        /* INSERT QUERY NO: 66 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601063', 'ADIDAYA PRATAMA INDONESIA  PT', '41 BELTWAY OFFICE PARK TOWER B LT5', 3173, 'RANGGA', '08111807890', ''
        );
        
        /* INSERT QUERY NO: 67 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601168', 'BUDI MAKMUR  TK', '220 PASAR INDUK CARINGIN JL SOEKAR', 3273, 'MARYAM', '089517048626', ''
        );
        
        /* INSERT QUERY NO: 68 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601169', 'MITRA SENTOSA ABADI  CV', '88 RUKO MATAHRAI SQUARE BALEENDAH', 3273, 'Edi', '0877-2211-9022', ''
        );
        
        /* INSERT QUERY NO: 69 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601170', 'HARRY TRIDARMA  PT', '354 JL SALAK HO IV RANAHCUBADAK', 1220, 'Dian', '0813-7473-3039', ''
        );
        
        /* INSERT QUERY NO: 70 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601236', 'SUPRA PRIMATAMA NUSANTARA  PT', '10 JL JENDRAL SUDIRMAN', 3173, 'Aditya Wijil Timur', '021-577998888', ''
        );
        
        /* INSERT QUERY NO: 71 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601254', 'ALL ID INDONESIA  PT', '30 JL BOULEVARD ARTHA GADING', 3173, 'LIA', '08179957783', ''
        );
        
        /* INSERT QUERY NO: 72 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601296', 'ZONE PRODUCTION  TK', '221 JL PAGARSIH', 3273, 'DESY', '08112199956', ''
        );
        
        /* INSERT QUERY NO: 73 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601322', 'MARDIKA DAYA TRIBUANA  PT', '194 JL MELAWAI RAYA BLOK III', 3173, 'AULIA', '081285960493', ''
        );
        
        /* INSERT QUERY NO: 74 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601344', 'GIANNE KONVEKSI  CV', '9 PERUM kota bandung INTEN INDAH BLOK B9', 3273, 'ANDYANA', '08112253007', ''
        );
        
        /* INSERT QUERY NO: 75 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601350', 'WICAKSANA SETIA MANDIRI  PT', '9 JL SISINGAMANGARAJA MEDAN', 1275, 'ELLA', '081261349777', ''
        );
        
        /* INSERT QUERY NO: 76 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601351', 'CANNONEX INDONESIA  PT', '2 JL CONDET RAYA RT 5 RW 3', 3173, 'SISKA SULIS', '081281281290', ''
        );
        
        /* INSERT QUERY NO: 77 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601359', 'AMG', '4 JL MARGAKENCANA', 3273, 'ANDYANA', '081221193849', ''
        );
        
        /* INSERT QUERY NO: 78 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601360', 'AGRA DIPA KENCANA  PT', '69 JL NYI MAS GANDASARI', 3209, 'GITO LAKSMANA', '02318800089', ''
        );
        
        /* INSERT QUERY NO: 79 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601361', 'GAJAH MADA INDONESIA  PT', '60 JL HAYAM WURUK', 1275, 'Novi', '+081262901704', ''
        );
        
        /* INSERT QUERY NO: 80 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601377', 'BATAVIA PROSPERINDO TRANS  PT', '19 RUKO GOLDEN BOULEVARD BLOK P', 3603, 'ERICH', '089626518974', ''
        );
        
        /* INSERT QUERY NO: 81 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601420', 'GLOBAL MAJU BERSAMA  PT', '15 RUKO BIDEX BLOK C BSD TANGSEL', 3603, 'MICHAEL', '08111207418', ''
        );
        
        /* INSERT QUERY NO: 82 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601441', 'PT SIGMA AKTUARINDO', 'Jl Raya Merua Ilir jakarta pusat Barat', 3173, 'Iwan', '+87885365949', ''
        );
        
        /* INSERT QUERY NO: 83 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601479', 'WIN TEKNIK  CV', '5 JL BITUNG RAYA', 7172, 'VANNA', '081295558626', ''
        );
        
        /* INSERT QUERY NO: 84 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601563', 'ADDROO HURES TRANSFORMA  PT', '23 PERKANTORAN PREMIER VILLAGE BLOK', 3603, 'RANGGA', '08111807890', ''
        );
        
        /* INSERT QUERY NO: 85 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601565', 'BISTEM JAYA MANDIRI', '36 JL H TAIMAN RAYA', 3173, 'RETNO DAMAYANTI', '081234355612', ''
        );
        
        /* INSERT QUERY NO: 86 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601566', 'PT PROGRESS CITRA SEMPURNA', '2/001 99 BUILDING  JL MAMPANG PRAP', 3173, 'ANGGA', '08111703518', ''
        );
        
        /* INSERT QUERY NO: 87 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601567', 'AGUNG SOLUSI TRANS  PT', '14 JL CUT MUTIAH', 3173, 'DENNY HARDLAN', '0812-1970-5555', ''
        );
        
        /* INSERT QUERY NO: 88 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601580', 'BUREAU VERITAS INDONESIA  PT', '1 JLHR RASUNA SAID KAV B1 WISMA BA', 3173, 'JOLANDA', '081385841231', ''
        );
        
        /* INSERT QUERY NO: 89 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601581', 'PREMYSIS  PT', '51 JLMEGA KUNINGAN LOT', 3173, 'FERDINAN', '08119003094', ''
        );
        
        /* INSERT QUERY NO: 90 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601610', 'AZZURA JAYA MANDIRI  PT', '18 JL KEMBANG SETAMAN KAVLING A UN', 3173, 'SOLIHIN', '08111919745', ''
        );
        
        /* INSERT QUERY NO: 91 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601640', 'RENTOKIL INDONESIA  PT', '8 JL RA KARTINI KAV', 3173, 'Novi', '0813-8467-0455', ''
        );
        
        /* INSERT QUERY NO: 92 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601667', 'AUTO 2000 kota bandung  PT', '145 JL SOEKARNO HATTA', 3273, 'HENDRA', '081312432000', ''
        );
        
        /* INSERT QUERY NO: 93 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601670', 'SEJAHTERA BUANA TRADA  PT', '17 JL RAYA SULTAN AGUNG', 3216, 'Ainun', '0813-1835-2785', ''
        );
        
        /* INSERT QUERY NO: 94 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601677', 'ARMADA AUTO TARA  PT', '9 JL MH THAMRIN CIKOKOL', 3603, 'FITRIANI', '081287316299', ''
        );
        
        /* INSERT QUERY NO: 95 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601679', 'SRIKANDI DIAMOND MOTORS  PT', '33 JL BHARATA RAYA PERUMNAS', 3215, 'SUSAN', '081298741919', ''
        );
        
        /* INSERT QUERY NO: 96 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601680', 'PAJA RAYA MOTOR  PT', '36 JL DAAN MOGOT TANGERANG', 3603, 'APRIL', '0818847162', ''
        );
        
        /* INSERT QUERY NO: 97 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601682', 'AUTO 2000 ASIA AFRIKA  PT', '125 JL ASIA AFRIKA', 3273, 'PUSPA', '081224601411', ''
        );
        
        /* INSERT QUERY NO: 98 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601685', 'WICAKSANA BERLIAN MOTOR  PT', '225 JL JEND A YANI', 3273, 'MELANI', '081220202096', ''
        );
        
        /* INSERT QUERY NO: 99 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601686', 'ISTANA kota bandung RAYA MOTOR  PT', '18 JL CICENDO', 3273, 'FARIS', '08998919443', ''
        );
        
        /* INSERT QUERY NO: 100 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601689', 'AMIDIS TIRTA MULIA  PT', '273 JL RAYA CIMAREME NGAMPRAH', 3273, 'Ujang', '0813-1835-2785', ''
        );
        
        /* INSERT QUERY NO: 101 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601696', 'SUN STAR MOTOR  PT', '183 JL RAYA PANGLIMA SUDIRMAN', 3327, 'OBY', '081217361837', ''
        );
        
        /* INSERT QUERY NO: 102 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601698', 'AUTO 2000 BEKASI  PT', '1 JL SILIWANGI  RAWALUMBU', 3216, 'ARFI', '085280022776', ''
        );
        
        /* INSERT QUERY NO: 103 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601699', 'TAKARI KOKOH SEJAHTERA  PT', '131 JL ARJUNA UTARA TANJUNG DUREN', 3174, 'ANDREAN', '08111221485', ''
        );
        
        /* INSERT QUERY NO: 104 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601702', 'NASMOCO GOMBEL  PT', '22 JL SETIABUDI', 3322, 'Guntur', '0813-2529-2288', ''
        );
        
        /* INSERT QUERY NO: 105 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601703', 'BINTANG AUTO SEMESTA  PT', '25 JL GATOTSUBROTO CIMONE', 3603, 'Wendi', '0852-8469-5758', ''
        );
        
        /* INSERT QUERY NO: 106 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601704', 'TUNAS MOBILINDO PERKASA  PT', '275 JL SOEKARNO HATTA', 3273, 'Yoga', '0821-2194-937', ''
        );
        
        /* INSERT QUERY NO: 107 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601705', 'NASMOCO SOLO BARU  PT', '1 JL RAYA SOLO PERMAI BLOK JA', 3372, 'Yuli Romdoni', '0878-3677-5118', ''
        );
        
        /* INSERT QUERY NO: 108 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601830', 'MARSH INDONESIA  PT', 'JL JEND SUDIRMAN KAV 2 (16 - 17 GED WTC LT  16 - 17)', 3175, 'Basuki', '0812-9048-5230', ''
        );
        
        /* INSERT QUERY NO: 109 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601991', 'NUSANTARA BERLIAN MOTOR  PT', '77-78 JL SURYOPRANOTO NO 77-78', 3173, 'HARTONO', '81293607568', ''
        );
        
        /* INSERT QUERY NO: 110 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601992', 'AUTO 2000 BASUKI RAHMAT', '115-117 JL JEND BASUKI RAHMAT', 3578, 'DIAZ', '81231201444', ''
        );
        
        /* INSERT QUERY NO: 111 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601993', 'IMPERIAL PUTRA PERDANA  PT', '352 JL JEND A YANI', 3273, 'DITO', '81224488511', ''
        );
        
        /* INSERT QUERY NO: 112 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601995', 'SEJAHTERA BUANA TRADA  PT', '405 JL RAYA SERPONG SEKTOR VIII BL', 3603, 'CHEPPY', '82111145693', ''
        );
        
        /* INSERT QUERY NO: 113 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100602018', 'KKB BCA', '10 JL METRO PONDOK INDAH', 3173, 'HILMAN', '82318274160', ''
        );
        
        /* INSERT QUERY NO: 114 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608032', 'Astra Daihatsu Serpong  PT', 'Perum BCD Blok 405/2A Sektor 8 Serp', 3603, 'Marcello', '81958660193', ''
        );
        
        /* INSERT QUERY NO: 115 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608035', 'Honda Permata Serpong', 'Jl Boulevard gading serpong CBD Lo', 3603, 'Ellen', '81298908555', ''
        );
        
        /* INSERT QUERY NO: 116 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608036', 'Auto 2000 Cirebon', '14 Jl Bridgen Darsono', 3209, 'Edwin', '81220378251', ''
        );
        
        /* INSERT QUERY NO: 117 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608037', 'KAS NEGARA', '1 INDONESIA', 3173, '-', '-', ''
        );
        
        /* INSERT QUERY NO: 118 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608040', 'TUGU MOTOR  PT', '157 JL HOS COKROAMINOTO - TEGAL RE', 3471, 'HESTA', '-', ''
        );
        
        /* INSERT QUERY NO: 119 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608043', 'AUTO 2000 SAMANHUDIN', '7 JL KH SAMANHUDIN PASAR BARU SAWA', 3173, 'SASONGKO', '0812-9828-849', ''
        );
        
        /* INSERT QUERY NO: 120 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608044', 'CIPTA PRIMA AUTO RAYA  PT', '1 JL BUKIT GADING MEDITERANIA KELA', 3175, 'HANSEN', '85881206356', ''
        );
        
        /* INSERT QUERY NO: 121 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608045', 'TUNAS REDEAN Tbk  PT', '80 JL RAYA MERDEKA CIMONE', 3603, 'FELICIA', '0812-1311-3189', ''
        );
        
        /* INSERT QUERY NO: 122 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608046', 'TUNAS MOBILINDO PERKASA  PT', '88 JL RAYA DAAN MOGOT KM 23', 3603, 'Hermawan', '0812-9358-4594', ''
        );
        
        /* INSERT QUERY NO: 123 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608047', 'AKITA PRIMA MOBILINDO  PT', '1 JL IMAM BONJOL', 3603, 'ALFHINCIO', '081290766033', ''
        );
        
        /* INSERT QUERY NO: 124 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608048', 'KELOLA JASA ARTHA  PT', '28 JL IR H JUANDA NO 28 jakarta pusat', 3173, 'DEDY ARDIASNYAH', '0811-9485-72', ''
        );
        
        /* INSERT QUERY NO: 125 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608088', 'HONDA MEGATAMA MANDIRI  PT', '8 JL LINGKAR LUAR BARAT NO 8 CENG', 3173, 'DEBBY', '0818-0738-7277', ''
        );
        
        /* INSERT QUERY NO: 126 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608091', 'ANUGRAH TERPERCAYA KERJA  PT', '20 JL RAJAWALI NO 20 KREMBANGAN S', 3578, 'OCKTABRIANI', '0817-0131-013', ''
        );
        
        /* INSERT QUERY NO: 127 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608092', 'SURYAPUTRA SARANA  PT', '4 JL DR ABDULRACHMAN SALEH NO 4', 3273, 'FITRIYANI', '0812-2029-8830', ''
        );
        
        /* INSERT QUERY NO: 128 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608093', 'PUTRA PERDANA INDONIAGA  PT', '1 JL RAYA SRUNI', 3515, 'SAMIHARTO', '0813-8102-3088', ''
        );
        
        /* INSERT QUERY NO: 129 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608094', 'LAUTAN BERLIAN UTAMA MOTOR  PT', 'JL SOEKARNO HATTA', 1671, 'CHANDRA', '0852-6623-5600', ''
        );
        
        /* INSERT QUERY NO: 130 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608095', 'DWIPERKASA MOBILTAMA  PT', '8 JL KH SOLEH ISKANDAR', 3201, 'TIRTA HADI', '0812-9697-110', ''
        );
        
        /* INSERT QUERY NO: 131 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608096', 'BUMEN REDJA ABADI  PT', 'JL RE MARTADINATA F1', 3322, 'NURYADIN', '0812-2820-7117', ''
        );
        
        /* INSERT QUERY NO: 132 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608097', 'MITRAUSAHA GENTANIAGA  PT', 'JL LINGKAR LUAR BARAT PURI KEMBANGA', 3174, 'ARDIN', '0822-1398-4361', ''
        );
        
        /* INSERT QUERY NO: 133 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608098', 'MAYANGSARI BERLIAN MOTOR  PT', '224A JL GAJAH MADA', 3509, 'ZAKIQ', '0852-5838-3353', ''
        );
        
        /* INSERT QUERY NO: 134 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608099', 'CAPELLA MEDAN  PT', '8 JL JEND GATOT SUBROTO NO 71 BCD', 1275, 'PENDI', '0812-6727-6474', ''
        );
        
        /* INSERT QUERY NO: 135 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608100', 'WIJAYA TOYOTA DAGO', '131 JL IR H JUANDA DAGO kota bandung', 3273, 'ESIH SUKAESIH', '0823-1611-1547', ''
        );
        
        /* INSERT QUERY NO: 136 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608101', 'BINTANG ARTHA GUNA  PT', '19-22 JL S SUPRIYADI', 3327, 'ADITYA TRIKUSWARA', '0853-3062-6633', ''
        );
        
        /* INSERT QUERY NO: 137 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608102', 'ASTRA INTERNATIONAL  PT', '1 RUKO PALM SPRING BLOK D2/01', 2171, 'Sudirman', '0853-7454-3122', ''
        );
        
        /* INSERT QUERY NO: 138 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608103', 'ASTRA INTERNATIONAL  PT', '220 JL GATOT SUBROTO', 1275, 'ANDY SUSANTO', '085270398806', ''
        );
        
        /* INSERT QUERY NO: 139 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608104', 'ASTRA INTERNATIONAL  PT', '111 - 117 JL MAJAPAHIT', 3322, 'Januar', '081226265171', ''
        );
        
        /* INSERT QUERY NO: 140 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608110', 'ISTANA KEMAKMURAN MOTOR  PT', '22 JL HOS COKROAMINOTO', 3603, 'Lucky', '081383403402', ''
        );
        
        /* INSERT QUERY NO: 141 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608111', 'PLAZA AUTO PRIMA  PT', '103-105 JL PELAJAR PEJUANG 45', 3273, 'PUSPA', '081224601411', ''
        );
        
        /* INSERT QUERY NO: 142 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608112', 'TOPIK TJANDRA ABADI  PT', '756 JL SOEKARNO HATTA', 3273, 'Gilang', '0813-2112-3240', ''
        );
        
        /* INSERT QUERY NO: 143 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608113', 'AUTOMOBIL JAYA MANDIRI', '299 JL JENDRAL SUDIRMAN', 3322, 'David', '0813-2914-4266', ''
        );
        
        /* INSERT QUERY NO: 144 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608114', 'NASMOCO  PT', '56 JL GERILYA TIMUR', 3302, 'Andhika', '0822-4342-3144', ''
        );
        
        /* INSERT QUERY NO: 145 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608115', 'IMORA MOTOR  PT', '56 JL PANGERAN JAYAKARTA', 3173, 'Sheila', '0812-7777-0801', ''
        );
        
        /* INSERT QUERY NO: 146 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608116', 'ASRI MITRA JAYA  PT', '147 JL RAYA TAMAN', 3515, 'Agustinus', '0821-3996-4845', ''
        );
        
        /* INSERT QUERY NO: 147 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608117', 'MAHLIGAI PUTERI BERLIAN  PT', '70 JL GARDUJATI', 3273, 'Eka Triana', '0877-2120-2939', ''
        );
        
        /* INSERT QUERY NO: 148 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608118', 'BERKAT LANGGENG SUKSES SEJATI  PT', '86 JL BASUKI RAHMAT', 3578, 'DEVI', '0813-3130-2262', ''
        );
        
        /* INSERT QUERY NO: 149 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608119', 'GADING PRIMA AUTOLAND  PT', '52 JL RAYA RE MARTADINATA', 3674, 'ARINDA', '0818-0606-0288', ''
        );
        
        /* INSERT QUERY NO: 150 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608120', 'CITRARAYA MANDIRI MOTOR  PT', '6 EMERALD MANSION CITRARAYA BLOK TX', 3578, 'ARIYANTO', '0812-3240-0032', ''
        );
        
        /* INSERT QUERY NO: 151 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608121', 'ARISTA AUTO LESTARI  PT', '1 JL SM RAYA', 1275, 'DEDI AFRIANDI', '0821-6006-2803', ''
        );
        
        /* INSERT QUERY NO: 152 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608122', 'INDOSAL PASTEUR  PT', '168B JL DR DJUNDJUNAN', 3273, 'WAID', '0812-2166-9336', ''
        );
        
        /* INSERT QUERY NO: 153 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608123', 'ALLID TEKNOLOGI INDONESIA RAYA  PT', '11 JL RAYA KELAPA HIBRIDA  RUKO HIB', 3173, 'EKO PRASETYO', '0857-7249-2977', ''
        );
        
        /* INSERT QUERY NO: 154 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608124', 'SEJAHTERA BUANA TRADA  PT', '50 JL JAKSA AGUNG SUPRAPTO', 3524, 'ARDIAN', '0858-5164-0001', ''
        );
        
        /* INSERT QUERY NO: 155 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608125', 'DIPO INTERNASIONAL PAHALA OTOMOTIF ', '36 JL DAAN MOGOT', 3603, 'APRIL', '0818-847-162', ''
        );
        
        /* INSERT QUERY NO: 156 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608126', 'TITIAN BUANA ILMU  PT', '157 JL IR JUANDA', 3273, 'IRMA LAILA', '6208-7886442910', ''
        );
        
        /* INSERT QUERY NO: 157 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608127', 'ARISTA JAYA LESTARI  PT', '1 JL KELAPA GADING BOULEVARD BLOK D', 3173, 'MARADEN', '0813-8136-0691', ''
        );
        
        /* INSERT QUERY NO: 158 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608128', 'ASTRA INTERNATIONAL TBK  PT', '5 - 6 GEDUNG MENARA ASTRA JL JENDRA', 3173, 'AMAN', '021-7291011', ''
        );
        
        /* INSERT QUERY NO: 159 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608129', 'ARISTA JAYA LESTARI  PT', '74 JL GARUDA  KEMAYORAN', 3173, 'HERY OCTA', '0838-7951-3681', ''
        );
        
        /* INSERT QUERY NO: 160 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608130', 'INDOSENTOSA TRADA  PT', '382 JL SOEKARNO HATTA', 3273, 'ERYE PRATANNA WILIZA', '0811-3999-925', ''
        );
        
        /* INSERT QUERY NO: 161 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608131', 'JAYAMANDIRI GEMASEJATI  PT', '5 JL BKR No 5 Lingkar Selatan', 3273, 'jaya sucipta', '081333332428', ''
        );
        
        /* INSERT QUERY NO: 162 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608132', 'AUTO 2000 KARAWANG', '80 JL SUROTOKUNTO', 3215, 'ZULFIAN', '0813-1092-9628', ''
        );
        
        /* INSERT QUERY NO: 163 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608133', 'NUSANTARA BERLIAN MOTOR  PT', '18 JL CINERE RAYA', 3276, 'TIA', '0812-9623-9889', ''
        );
        
        /* INSERT QUERY NO: 164 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608134', 'BUMEN REDJA ABADI  PT', '3A JL PAHLAWAN SERIBU SEKTOR VI BLO', 3674, 'DEDY', '0852-1889-4962', ''
        );
        
        /* INSERT QUERY NO: 165 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100608135', 'SRIKANDI DIAMOND MOTOR  PT', '197 JL KH HASYIM ASHARI', 3603, 'ELVIN', '0811-1576-688', ''
        );
        
        /* INSERT QUERY NO: 166 */
        INSERT INTO vendor(code, name, address, city_id, salesperson, phone, email)
        VALUES
        (
        'V100601362', 'GARDA BHAKTI NUSANTARA  PT', '', 3603, 'ROMLIS', '0823-6766-5290', ''
        );
        
        ");
    }
}
