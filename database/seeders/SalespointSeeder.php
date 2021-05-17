<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class SalespointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::unprepared("/* INSERT QUERY NO: 1 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'DAAN MOGOT', 1001000, 1, 0, 1, 0
        );
        
        /* INSERT QUERY NO: 2 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'JABODETABEK', 1000913, 1, 0, 1, 0
        );
        
        /* INSERT QUERY NO: 3 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'KARAWANG', 1000720, 1, 0, 1, 0
        );
        
        /* INSERT QUERY NO: 4 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'BOGOR', 1000681, 1, 0, 1, 0
        );
        
        /* INSERT QUERY NO: 5 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'MEDAN BARAT', 1000697, 1, 1, 1, 1
        );
        
        /* INSERT QUERY NO: 6 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'BINJAI', 1000810, 0, 1, 1, 1
        );
        
        /* INSERT QUERY NO: 7 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'PANGKALAN BRANDAN', 1001050, 2, 1, 1, 1
        );
        
        /* INSERT QUERY NO: 8 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'MEDAN TIMUR', 1000570, 1, 1, 1, 1
        );
        
        /* INSERT QUERY NO: 9 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'MEDAN UTARA', 1000894, 0, 1, 1, 1
        );
        
        /* INSERT QUERY NO: 10 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'RANTAU PRAPAT', 1000888, 1, 1, 1, 1
        );
        
        /* INSERT QUERY NO: 11 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'MEDAN SELATAN', 1000770, 0, 1, 1, 1
        );
        
        /* INSERT QUERY NO: 12 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'KISARAN', 1000889, 0, 1, 1, 1
        );
        
        /* INSERT QUERY NO: 13 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'PADANG SIDEMPUAN', 1000814, 1, 1, 1, 1
        );
        
        /* INSERT QUERY NO: 14 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'PANYABUNGAN', 1000962, 2, 1, 1, 1
        );
        
        /* INSERT QUERY NO: 15 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'SIBORONG-BORONG', 1001013, 0, 1, 1, 1
        );
        
        /* INSERT QUERY NO: 16 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'SIBOLGA', 1000956, 2, 1, 1, 1
        );
        
        /* INSERT QUERY NO: 17 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'MEDAN', 1000689, 1, 0, 1, 1
        );
        
        /* INSERT QUERY NO: 18 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'PADANG UTARA', 1000946, 1, 1, 1, 2
        );
        
        /* INSERT QUERY NO: 19 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'PADANG SELATAN', 1000749, 2, 1, 1, 2
        );
        
        /* INSERT QUERY NO: 20 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'PADANG PARIAMAN', 1000943, 2, 1, 1, 2
        );
        
        /* INSERT QUERY NO: 21 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'PASAMAN BARAT', 1000916, 0, 1, 1, 2
        );
        
        /* INSERT QUERY NO: 22 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'SOLOK', 1000787, 1, 1, 1, 2
        );
        
        /* INSERT QUERY NO: 23 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'MUARA BUNGO', 1000886, 0, 1, 1, 2
        );
        
        /* INSERT QUERY NO: 24 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'SOLOK SELATAN', 1001026, 2, 1, 1, 2
        );
        
        /* INSERT QUERY NO: 25 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'BUKIT TINGGI', 1000751, 1, 1, 1, 2
        );
        
        /* INSERT QUERY NO: 26 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'PAYAKUMBUH', 1000862, 0, 1, 1, 2
        );
        
        /* INSERT QUERY NO: 27 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'BATUSANGKAR', 1001035, 2, 1, 1, 2
        );
        
        /* INSERT QUERY NO: 28 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'JAMBI', 1000599, 1, 1, 1, 2
        );
        
        /* INSERT QUERY NO: 29 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'BANGKO', 1000887, 0, 1, 1, 2
        );
        
        /* INSERT QUERY NO: 30 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'JAMBI BARAT', 1001006, 0, 1, 1, 2
        );
        
        /* INSERT QUERY NO: 31 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'BENGKULU', 1000669, 1, 1, 1, 2
        );
        
        /* INSERT QUERY NO: 32 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'MUKO-MUKO', 1000982, 2, 1, 1, 2
        );
        
        /* INSERT QUERY NO: 33 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'MANNA', 1000983, 2, 1, 1, 2
        );
        
        /* INSERT QUERY NO: 34 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'LUBUK LINGGAU', 1000758, 0, 1, 1, 2
        );
        
        /* INSERT QUERY NO: 35 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'LAHAT', 1000818, 0, 1, 1, 2
        );
        
        /* INSERT QUERY NO: 36 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'JAMBI', 1000621, 1, 0, 1, 2
        );
        
        /* INSERT QUERY NO: 37 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'BUKIT TINGGI', 1000890, 1, 0, 1, 2
        );
        
        /* INSERT QUERY NO: 38 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'PALEMBANG ILIR', 1000640, 1, 1, 1, 3
        );
        
        /* INSERT QUERY NO: 39 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'PALEMBANG ULU', 1000821, 0, 1, 1, 3
        );
        
        /* INSERT QUERY NO: 40 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'BELITUNG', 1000902, 2, 1, 1, 3
        );
        
        /* INSERT QUERY NO: 41 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'SEKAYU', 1000959, 2, 1, 1, 3
        );
        
        /* INSERT QUERY NO: 42 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'PRABUMULIH', 1000782, 1, 1, 1, 3
        );
        
        /* INSERT QUERY NO: 43 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'BATURAJA', 1000816, 2, 1, 1, 3
        );
        
        /* INSERT QUERY NO: 44 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'KAYUAGUNG', 1000941, 0, 1, 1, 3
        );
        
        /* INSERT QUERY NO: 45 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'MARTAPURA', 1000981, 0, 1, 1, 3
        );
        
        /* INSERT QUERY NO: 46 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'PRINGSEWU', 1000854, 0, 1, 1, 3
        );
        
        /* INSERT QUERY NO: 47 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'KALIANDA', 1000997, 2, 1, 1, 3
        );
        
        /* INSERT QUERY NO: 48 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'KOTABUMI', 1000835, 1, 1, 1, 3
        );
        
        /* INSERT QUERY NO: 49 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'METRO', 1000743, 0, 1, 1, 3
        );
        
        /* INSERT QUERY NO: 50 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'TULANG BAWANG', 1000863, 0, 1, 1, 3
        );
        
        /* INSERT QUERY NO: 51 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'LIWA', 1000877, 2, 1, 1, 3
        );
        
        /* INSERT QUERY NO: 52 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'LAMPUNG', 1000685, 1, 0, 1, 3
        );
        
        /* INSERT QUERY NO: 53 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'PALEMBANG', 1000686, 1, 0, 1, 3
        );
        
        /* INSERT QUERY NO: 54 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'TIGARAKSA', 1000677, 0, 1, 1, 5
        );
        
        /* INSERT QUERY NO: 55 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'CURUG SERPONG', 1000904, 0, 1, 1, 5
        );
        
        /* INSERT QUERY NO: 56 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'RANGKAS BITUNG', 1000851, 0, 1, 1, 5
        );
        
        /* INSERT QUERY NO: 57 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'MALINGPING', 1000799, 2, 1, 1, 5
        );
        
        /* INSERT QUERY NO: 58 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'CILEGON', 1000846, 0, 1, 1, 5
        );
        
        /* INSERT QUERY NO: 59 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'PANDEGLANG', 1000705, 0, 1, 1, 5
        );
        
        /* INSERT QUERY NO: 60 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'PANIMBANG', 1000991, 2, 1, 1, 5
        );
        
        /* INSERT QUERY NO: 61 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'TANGERANG KOTA', 1000589, 0, 1, 1, 5
        );
        
        /* INSERT QUERY NO: 62 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'KRONJO', 1001015, 0, 1, 1, 5
        );
        
        /* INSERT QUERY NO: 63 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'TELUK NAGA', 1000938, 2, 1, 1, 5
        );
        
        /* INSERT QUERY NO: 64 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'JAKARTA BARAT', 1000454, 1, 1, 1, 5
        );
        
        /* INSERT QUERY NO: 65 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'CIPONDOH', 1000733, 0, 1, 1, 5
        );
        
        /* INSERT QUERY NO: 66 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'JOGLO', 1000719, 0, 1, 1, 5
        );
        
        /* INSERT QUERY NO: 67 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'SERANG', 1000791, 1, 0, 1, 5
        );
        
        /* INSERT QUERY NO: 68 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'JAKUTPUS', 1000457, 1, 1, 1, 6
        );
        
        /* INSERT QUERY NO: 69 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'KLENDER', 1000800, 0, 1, 1, 6
        );
        
        /* INSERT QUERY NO: 70 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'PADEMANGAN', 1000935, 2, 1, 1, 6
        );
        
        /* INSERT QUERY NO: 71 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'CILANDAK', 1000876, 0, 1, 1, 6
        );
        
        /* INSERT QUERY NO: 72 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'JAKARTA TIMUR', 1000453, 0, 1, 1, 6
        );
        
        /* INSERT QUERY NO: 73 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'KRANJI', 1000804, 1, 1, 1, 6
        );
        
        /* INSERT QUERY NO: 74 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'PONDOK GEDE', 1000969, 0, 1, 1, 6
        );
        
        /* INSERT QUERY NO: 75 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'CIKARANG UTARA', 1000692, 0, 1, 1, 6
        );
        
        /* INSERT QUERY NO: 76 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'BEKASI', 1000588, 0, 1, 1, 6
        );
        
        /* INSERT QUERY NO: 77 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'CIBITUNG', 1001017, 0, 1, 1, 6
        );
        
        /* INSERT QUERY NO: 78 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'KARAWANG', 1000581, 1, 1, 1, 6
        );
        
        /* INSERT QUERY NO: 79 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'RENGASDENGKLOK', 1000805, 0, 1, 1, 6
        );
        
        /* INSERT QUERY NO: 80 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'CIKAMPEK', 1000885, 0, 1, 1, 6
        );
        
        /* INSERT QUERY NO: 81 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'BOGOR TIMUR', 1000595, 1, 1, 1, 7
        );
        
        /* INSERT QUERY NO: 82 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'CIBINONG', 1000912, 0, 1, 1, 7
        );
        
        /* INSERT QUERY NO: 83 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'LEUWILIANG', 1000682, 0, 1, 1, 7
        );
        
        /* INSERT QUERY NO: 84 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'BOGOR BARAT', 1001011, 0, 1, 1, 7
        );
        
        /* INSERT QUERY NO: 85 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'DEPOK', 1000671, 0, 1, 1, 7
        );
        
        /* INSERT QUERY NO: 86 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'PARUNG', 1000829, 0, 1, 1, 7
        );
        
        /* INSERT QUERY NO: 87 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'TANGERANG SELATAN', 1000657, 0, 1, 1, 7
        );
        
        /* INSERT QUERY NO: 88 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'SUKABUMI', 1000597, 1, 1, 1, 7
        );
        
        /* INSERT QUERY NO: 89 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'CIBADAK', 1000813, 0, 1, 1, 7
        );
        
        /* INSERT QUERY NO: 90 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'CIAWI', 1000860, 0, 1, 1, 7
        );
        
        /* INSERT QUERY NO: 91 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'CIANJUR', 1000596, 0, 1, 1, 7
        );
        
        /* INSERT QUERY NO: 92 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'CILEUNGSI', 1000711, 0, 1, 1, 7
        );
        
        /* INSERT QUERY NO: 93 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'CIPANAS', 1000998, 2, 1, 1, 7
        );
        
        /* INSERT QUERY NO: 94 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'PURWAKARTA', 1000534, 0, 1, 1, 8
        );
        
        /* INSERT QUERY NO: 95 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'BANDUNG UTARA', 1001022, 0, 1, 1, 8
        );
        
        /* INSERT QUERY NO: 96 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'PAMANUKAN', 1000903, 0, 1, 1, 8
        );
        
        /* INSERT QUERY NO: 97 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'BANDUNG BARAT', 1000528, 0, 1, 1, 8
        );
        
        /* INSERT QUERY NO: 98 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'PADALARANG', 1000961, 0, 1, 1, 8
        );
        
        /* INSERT QUERY NO: 99 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'KATAPANG BDG', 1001049, 0, 1, 1, 8
        );
        
        /* INSERT QUERY NO: 100 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'CIMINDI', 1000694, 0, 1, 1, 8
        );
        
        /* INSERT QUERY NO: 101 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'BANJARAN', 1000668, 0, 1, 1, 8
        );
        
        /* INSERT QUERY NO: 102 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'CIPARAY', 1000786, 0, 1, 1, 8
        );
        
        /* INSERT QUERY NO: 103 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'GARUT', 1000535, 0, 1, 1, 8
        );
        
        /* INSERT QUERY NO: 104 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'MALANGBONG', 1001036, 2, 1, 1, 8
        );
        
        /* INSERT QUERY NO: 105 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'BANDUNG SELATAN', 1000527, 1, 1, 1, 8
        );
        
        /* INSERT QUERY NO: 106 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'SUMEDANG', 1000773, 0, 1, 1, 8
        );
        
        /* INSERT QUERY NO: 107 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'SUBANG', 1000533, 0, 1, 1, 8
        );
        
        /* INSERT QUERY NO: 108 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'UJUNGBERUNG', 1000921, 0, 1, 1, 8
        );
        
        /* INSERT QUERY NO: 109 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'PLUMBON', 1000838, 1, 1, 1, 9
        );
        
        /* INSERT QUERY NO: 110 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'CIREBON KOTA', 1000713, 0, 1, 1, 9
        );
        
        /* INSERT QUERY NO: 111 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'LOSARI', 1001004, 0, 1, 1, 9
        );
        
        /* INSERT QUERY NO: 112 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'MAJALENGKA', 1000745, 0, 1, 1, 9
        );
        
        /* INSERT QUERY NO: 113 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'KUNINGAN', 1000769, 0, 1, 1, 9
        );
        
        /* INSERT QUERY NO: 114 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'TALAGA', 1000972, 2, 1, 1, 9
        );
        
        /* INSERT QUERY NO: 115 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'JATIBARANG', 1000537, 0, 1, 1, 9
        );
        
        /* INSERT QUERY NO: 116 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'BANJAR', 1000695, 0, 1, 1, 9
        );
        
        /* INSERT QUERY NO: 117 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'CIAMIS', 1000865, 0, 1, 1, 9
        );
        
        /* INSERT QUERY NO: 118 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'MAJENANG', 1000866, 2, 1, 1, 9
        );
        
        /* INSERT QUERY NO: 119 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'TASIKMALAYA UTARA', 1000536, 1, 1, 1, 9
        );
        
        /* INSERT QUERY NO: 120 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'TASIKMALAYA SELATAN', 1001052, 0, 1, 1, 9
        );
        
        /* INSERT QUERY NO: 121 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'PURWOKERTO', 1000602, 1, 1, 1, 9
        );
        
        /* INSERT QUERY NO: 122 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'PURBALINGGA', 1000960, 0, 1, 1, 9
        );
        
        /* INSERT QUERY NO: 123 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'WANGON', 1000706, 0, 1, 1, 9
        );
        
        /* INSERT QUERY NO: 124 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'PURWOKERTO', 1000615, 1, 0, 1, 9
        );
        
        /* INSERT QUERY NO: 125 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'SEMARANG BARAT', 1000586, 1, 1, 1, 10
        );
        
        /* INSERT QUERY NO: 126 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'WELERI', 1000847, 0, 1, 1, 10
        );
        
        /* INSERT QUERY NO: 127 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'UNGARAN', 1001029, 2, 1, 1, 10
        );
        
        /* INSERT QUERY NO: 128 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'SEMARANG TIMUR', 1000823, 0, 1, 1, 10
        );
        
        /* INSERT QUERY NO: 129 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'JEPARA', 1000896, 0, 1, 1, 10
        );
        
        /* INSERT QUERY NO: 130 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'DEMAK', 1000992, 2, 1, 1, 10
        );
        
        /* INSERT QUERY NO: 131 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'PURWODADI', 1000833, 2, 1, 1, 10
        );
        
        /* INSERT QUERY NO: 132 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'KUDUS', 1000646, 1, 1, 1, 10
        );
        
        /* INSERT QUERY NO: 133 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'JUWANA', 1000834, 0, 1, 1, 10
        );
        
        /* INSERT QUERY NO: 134 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'BLORA', 1000753, 0, 1, 1, 10
        );
        
        /* INSERT QUERY NO: 135 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'LASEM', 1000965, 2, 1, 1, 10
        );
        
        /* INSERT QUERY NO: 136 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'PEKALONGAN', 1000736, 0, 1, 1, 10
        );
        
        /* INSERT QUERY NO: 137 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'PEMALANG', 1000881, 0, 1, 1, 10
        );
        
        /* INSERT QUERY NO: 138 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'BATANG TULIS', 1001030, 2, 1, 1, 10
        );
        
        /* INSERT QUERY NO: 139 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'TEGAL', 1000734, 1, 1, 1, 10
        );
        
        /* INSERT QUERY NO: 140 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'BREBES', 1000798, 0, 1, 1, 10
        );
        
        /* INSERT QUERY NO: 141 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'SLAWI', 1001059, 0, 1, 1, 10
        );
        
        /* INSERT QUERY NO: 142 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'BUMIAYU', 1000945, 2, 1, 1, 10
        );
        
        /* INSERT QUERY NO: 143 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'KUDUS', 1000647, 1, 0, 1, 10
        );
        
        /* INSERT QUERY NO: 144 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'TEGAL', 1000735, 1, 0, 1, 10
        );
        
        /* INSERT QUERY NO: 145 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'YOGYA BANTUL', 1000658, 1, 1, 1, 11
        );
        
        /* INSERT QUERY NO: 146 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'YOGYA SLEMAN', 1000867, 0, 1, 1, 11
        );
        
        /* INSERT QUERY NO: 147 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'WONOGIRI', 1000771, 2, 1, 1, 11
        );
        
        /* INSERT QUERY NO: 148 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'YOGYA GN KIDUL', 1000990, 2, 1, 1, 11
        );
        
        /* INSERT QUERY NO: 149 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'SOLO', 1000660, 1, 1, 1, 11
        );
        
        /* INSERT QUERY NO: 150 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'KARANGANYAR', 1000884, 0, 1, 1, 11
        );
        
        /* INSERT QUERY NO: 151 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'BOYOLALI', 1000964, 2, 1, 1, 11
        );
        
        /* INSERT QUERY NO: 152 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'SRAGEN', 1000914, 2, 1, 1, 11
        );
        
        /* INSERT QUERY NO: 153 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'MAGELANG', 1000698, 0, 1, 1, 11
        );
        
        /* INSERT QUERY NO: 154 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'SALATIGA', 1000824, 2, 1, 1, 11
        );
        
        /* INSERT QUERY NO: 155 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'TEMANGGUNG', 1000942, 0, 1, 1, 11
        );
        
        /* INSERT QUERY NO: 156 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'KLATEN', 1000825, 0, 1, 1, 11
        );
        
        /* INSERT QUERY NO: 157 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'KEBUMEN', 1000699, 0, 1, 1, 11
        );
        
        /* INSERT QUERY NO: 158 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'BANJARNEGARA', 1000752, 0, 1, 1, 11
        );
        
        /* INSERT QUERY NO: 159 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'PURWOREJO', 1000883, 2, 1, 1, 11
        );
        
        /* INSERT QUERY NO: 160 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'KROYA', 1000989, 2, 1, 1, 11
        );
        
        /* INSERT QUERY NO: 161 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'SOLO', 1000661, 1, 0, 1, 11
        );
        
        /* INSERT QUERY NO: 162 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'SURABAYA UTARA', 1000708, 1, 1, 1, 12
        );
        
        /* INSERT QUERY NO: 163 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'SURABAYA PUSEL', 1000932, 0, 1, 1, 12
        );
        
        /* INSERT QUERY NO: 164 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'SURABAYA BARAT', 1000583, 0, 1, 1, 12
        );
        
        /* INSERT QUERY NO: 165 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'PAMEKASAN', 1000832, 0, 1, 1, 12
        );
        
        /* INSERT QUERY NO: 166 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'SUMENEP', 1000952, 0, 1, 1, 12
        );
        
        /* INSERT QUERY NO: 167 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'SAMPANG', 1001037, 2, 1, 1, 12
        );
        
        /* INSERT QUERY NO: 168 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'BANGKALAN', 1000841, 0, 1, 1, 12
        );
        
        /* INSERT QUERY NO: 169 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'PROBOLINGGO', 1000653, 0, 1, 1, 12
        );
        
        /* INSERT QUERY NO: 170 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'LUMAJANG', 1000861, 0, 1, 1, 12
        );
        
        /* INSERT QUERY NO: 171 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'JEMBER', 1000650, 1, 1, 1, 12
        );
        
        /* INSERT QUERY NO: 172 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'BONDOWOSO', 1000973, 0, 1, 1, 12
        );
        
        /* INSERT QUERY NO: 173 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'GEDANGAN', 1001010, 1, 1, 1, 12
        );
        
        /* INSERT QUERY NO: 174 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'PASURUAN', 1000849, 0, 1, 1, 12
        );
        
        /* INSERT QUERY NO: 175 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'PANDAAN', 1001005, 2, 1, 1, 12
        );
        
        /* INSERT QUERY NO: 176 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'KEDIRI', 1000664, 1, 1, 1, 13
        );
        
        /* INSERT QUERY NO: 177 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'TULUNG AGUNG', 1000757, 0, 1, 1, 13
        );
        
        /* INSERT QUERY NO: 178 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'BLITAR', 1000871, 0, 1, 1, 13
        );
        
        /* INSERT QUERY NO: 179 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'GRESIK', 1000755, 0, 1, 1, 13
        );
        
        /* INSERT QUERY NO: 180 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'LAMONGAN', 1001018, 2, 1, 1, 13
        );
        
        /* INSERT QUERY NO: 181 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'BOJONEGORO', 1000728, 2, 1, 1, 13
        );
        
        /* INSERT QUERY NO: 182 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'TUBAN', 1000858, 2, 1, 1, 13
        );
        
        /* INSERT QUERY NO: 183 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'BABAT', 1000987, 2, 1, 1, 13
        );
        
        /* INSERT QUERY NO: 184 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'MADIUN', 1000737, 0, 1, 1, 13
        );
        
        /* INSERT QUERY NO: 185 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'MAWI', 1000905, 0, 1, 1, 13
        );
        
        /* INSERT QUERY NO: 186 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'PONOROGO', 1000954, 0, 1, 1, 13
        );
        
        /* INSERT QUERY NO: 187 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'TRENGGALEK', 1001043, 2, 1, 1, 13
        );
        
        /* INSERT QUERY NO: 188 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'MALANG UTARA', 1000580, 1, 1, 1, 13
        );
        
        /* INSERT QUERY NO: 189 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'MALANG BARAT', 1000918, 0, 1, 1, 13
        );
        
        /* INSERT QUERY NO: 190 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'MALANG SELATAN', 1000802, 0, 1, 1, 13
        );
        
        /* INSERT QUERY NO: 191 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'DAMPIT', 1001051, 2, 1, 1, 13
        );
        
        /* INSERT QUERY NO: 192 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'MOJOKERTO', 1000850, 0, 1, 1, 13
        );
        
        /* INSERT QUERY NO: 193 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'JOMBANG', 1000648, 0, 1, 1, 13
        );
        
        /* INSERT QUERY NO: 194 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'NGANJUK', 1000949, 0, 1, 1, 13
        );
        
        /* INSERT QUERY NO: 195 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'DENPASAR', 1000637, 1, 1, 0, 14
        );
        
        /* INSERT QUERY NO: 196 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'KLUNGKUNG', 1000693, 2, 1, 0, 14
        );
        
        /* INSERT QUERY NO: 197 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'SINGARAJA', 1000732, 0, 1, 0, 14
        );
        
        /* INSERT QUERY NO: 198 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'TABANAN', 1000830, 2, 1, 0, 14
        );
        
        /* INSERT QUERY NO: 199 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'BANYUWANGI', 1000652, 0, 1, 0, 14
        );
        
        /* INSERT QUERY NO: 200 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'SITUBONDO', 1000911, 0, 1, 0, 14
        );
        
        /* INSERT QUERY NO: 201 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'GENTENG', 1001040, 0, 1, 0, 14
        );
        
        /* INSERT QUERY NO: 202 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'MATARAM', 1000788, 0, 1, 0, 14
        );
        
        /* INSERT QUERY NO: 203 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'SELONG', 1000790, 0, 1, 0, 14
        );
        
        /* INSERT QUERY NO: 204 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'PRAYA', 1000957, 0, 1, 0, 14
        );
        
        /* INSERT QUERY NO: 205 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'KUPANG', 1000908, 1, 1, 0, 14
        );
        
        /* INSERT QUERY NO: 206 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'ATAMBUA', 1000996, 2, 1, 0, 14
        );
        
        /* INSERT QUERY NO: 207 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'PONTIANAK TIMUR', 1000774, 1, 1, 0, 15
        );
        
        /* INSERT QUERY NO: 208 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'SINTANG', 1000937, 0, 1, 0, 15
        );
        
        /* INSERT QUERY NO: 209 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'SANGGAU', 1000936, 2, 1, 0, 15
        );
        
        /* INSERT QUERY NO: 210 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'PONTIANAK BARAT', 1000974, 1, 1, 0, 15
        );
        
        /* INSERT QUERY NO: 211 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'KETAPANG', 1000995, 2, 1, 0, 15
        );
        
        /* INSERT QUERY NO: 212 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'SINGKAWANG', 1000857, 2, 1, 0, 15
        );
        
        /* INSERT QUERY NO: 213 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'SAMBAS', 1001038, 2, 1, 0, 15
        );
        
        /* INSERT QUERY NO: 214 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'SAMARINDA SELATAN', 1000808, 1, 1, 0, 15
        );
        
        /* INSERT QUERY NO: 215 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'TENGGARONG', 1000967, 2, 1, 0, 15
        );
        
        /* INSERT QUERY NO: 216 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'SAMARINDA UTARA', 1000975, 2, 1, 0, 15
        );
        
        /* INSERT QUERY NO: 217 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'BONTANG', 1000926, 2, 1, 0, 15
        );
        
        /* INSERT QUERY NO: 218 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'BALIKPAPAN', 1000811, 0, 1, 0, 15
        );
        
        /* INSERT QUERY NO: 219 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'TANAH GROGOT', 1001002, 2, 1, 0, 15
        );
        
        /* INSERT QUERY NO: 220 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'SAMPIT', 1001023, 1, 1, 0, 15
        );
        
        /* INSERT QUERY NO: 221 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'PALANGKARAYA', 1000840, 2, 1, 0, 15
        );
        
        /* INSERT QUERY NO: 222 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'PANGKALANBUN', 1001024, 2, 1, 0, 15
        );
        
        /* INSERT QUERY NO: 223 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'BANJARMASIN SELATAN', 1000826, 1, 1, 0, 15
        );
        
        /* INSERT QUERY NO: 224 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'BANJARMASIN KOTA', 1001014, 0, 1, 0, 15
        );
        
        /* INSERT QUERY NO: 225 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'BANJARBARU', 1000919, 1, 1, 0, 15
        );
        
        /* INSERT QUERY NO: 226 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'BATULICIN', 1000842, 2, 1, 0, 15
        );
        
        /* INSERT QUERY NO: 227 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'KOTABARU', 1000893, 2, 1, 0, 15
        );
        
        /* INSERT QUERY NO: 228 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'BARABAI', 1000984, 0, 1, 0, 15
        );
        
        /* INSERT QUERY NO: 229 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'TANJUNG TABALONG', 1000985, 2, 1, 0, 15
        );
        
        /* INSERT QUERY NO: 230 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'MAKASSAR UTARA', 1000559, 1, 1, 0, 16
        );
        
        /* INSERT QUERY NO: 231 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'MAROS', 1000950, 2, 1, 0, 16
        );
        
        /* INSERT QUERY NO: 232 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'MAKASSAR SELATAN', 1000929, 0, 1, 0, 16
        );
        
        /* INSERT QUERY NO: 233 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'SUNGGUMINASA', 1000690, 1, 1, 0, 16
        );
        
        /* INSERT QUERY NO: 234 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'SENGKANG', 1001020, 2, 1, 0, 16
        );
        
        /* INSERT QUERY NO: 235 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'BULUKUMBA', 1001021, 0, 1, 0, 16
        );
        
        /* INSERT QUERY NO: 236 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'TAKALAR', 1001003, 2, 1, 0, 16
        );
        
        /* INSERT QUERY NO: 237 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'BONE', 1001019, 2, 1, 0, 16
        );
        
        /* INSERT QUERY NO: 238 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'PARE-PARE', 1000796, 1, 1, 0, 16
        );
        
        /* INSERT QUERY NO: 239 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'WONOMULYO', 1000906, 0, 1, 0, 16
        );
        
        /* INSERT QUERY NO: 240 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'MAMUJU', 1001044, 2, 1, 0, 16
        );
        
        /* INSERT QUERY NO: 241 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'SIDRAP', 1001025, 2, 1, 0, 16
        );
        
        /* INSERT QUERY NO: 242 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'PALOPO', 1001016, 1, 1, 0, 16
        );
        
        /* INSERT QUERY NO: 243 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'RANTEPAO', 1000986, 2, 1, 0, 16
        );
        
        /* INSERT QUERY NO: 244 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'MANGKUTANA', 1001067, 2, 1, 0, 16
        );
        
        /* INSERT QUERY NO: 245 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'PALU', 1000795, 1, 1, 0, 16
        );
        
        /* INSERT QUERY NO: 246 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'AMBON', 1000898, 0, 1, 0, 16
        );
        
        /* INSERT QUERY NO: 247 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'PARIGI PALU', 1000940, 2, 1, 0, 16
        );
        
        /* INSERT QUERY NO: 248 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'KENDARI', 1000843, 1, 1, 0, 16
        );
        
        /* INSERT QUERY NO: 249 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'KOLAKA', 1000920, 2, 1, 0, 16
        );
        
        /* INSERT QUERY NO: 250 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'BAU-BAU', 1000994, 2, 1, 0, 16
        );
        
        /* INSERT QUERY NO: 251 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'MANADO', 1000729, 1, 1, 0, 16
        );
        
        /* INSERT QUERY NO: 252 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'MANADO BARAT', 1000933, 2, 1, 0, 16
        );
        
        /* INSERT QUERY NO: 253 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'GORONTALO', 1000731, 0, 1, 0, 16
        );
        
        /* INSERT QUERY NO: 254 */
        INSERT INTO salespoint(name, code, status, trade_type, isJawaSumatra, region)
        VALUES
        (
        'MARISA', 1000852, 2, 1, 0, 16
        );
        
        ");
    }
}
