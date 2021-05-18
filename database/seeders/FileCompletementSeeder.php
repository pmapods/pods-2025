<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FileCategory;
use App\Models\FileCompletement;

class FileCompletementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category_names = [
            "Perbaikan Area Gudang",
            "Pallet Kayu",
            "Refill APAR",
            "Printer",
            "AC",
            "CCTV",
            "Barang IT / Non IT (Kelengkapan Kantor)",
            "Armada Asset",
            "Renovasi Kantor (Sekat, Teralis dsb)",
            "ATK",
            "ART",
            "Asset IT",
            "Non IT",
            "Ban Kendaraan",
            "Disposal",
        ];
        $category_item_count = [5,4,2,5,4,4,4,5,4,2,2,7,6,4,3];
        $items = [
            "Penawaran resmi dari 2 vendor (dilengkapi KTP dan NPWP)",
            "Foto Dokumentasi kerusakan",
            "BA Kerusakan Gudang",
            "Akta Sewa Gudang",
            "Layout Gudang",
            "Penawaran resmi dari 2 vendor (dilengkapi KTP dan NPWP)",
            "Jumlah As is dan To be",
            "Layout Gudang",
            "Perhitungan luas gudang",
            "Penawaran 2 vendor (KOP/KTP, NPWP)",
            "Dokumentasi APAR (tgl expired, Quantity)",
            "Penawaran resmi dari 2 vendor (dilengkapi KTP dan NPWP)",
            "BA Kerusakan dari Area",
            "Surat Keterangan Kerusakan/hasil pemerikasaan dari vendor",
            "Dokumentasi printer (mencantumkan nomor asset)",
            "Contoh Hasil Print out",
            "Penawaran resmi dari 2 vendor (dilengkapi KTP dan NPWP)",
            "BA Kerusakan dari Area ",
            "Surat Keterangan Kerusakan/hasil pemerikasaan dari vendor",
            "Dokumentasi AC (mencantumkan nomor asset)",
            "Penawaran resmi dari 2 vendor (dilengkapi KTP dan NPWP)",
            "BA Kerusakan dari Area (Foto Kerusakan)",
            "Surat Keterangan Kerusakan/hasil pemerikasaan dari vendor",
            "Dokumentasi CCTV (mencantumkan nomor asset)",
            "Penawaran resmi dari 2 vendor (dilengkapi KTP dan NPWP)",
            "BA Kerusakan dari Area",
            "Surat Keterangan Kerusakan/hasil pemerikasaan dari vendor",
            "Dokumentasi Kerusakan",
            "Penawaran resmi dari 2 vendor (dilengkapi KTP dan NPWP)",
            "BA Kerusakan dari Area / history perbaikan",
            "Surat Keterangan Kerusakan/hasil pemerikasaan dari vendor",
            "Dokumentasi Kerusakan",
            "Dokumentasi kendaraan (plat nopol, no asset, tampak depan, kanan, kiri, belakang)",
            "Penawaran resmi dari 2 vendor (dilengkapi KTP dan NPWP)",
            "Dokumentasi Area kantor",
            "Layout Kantor",
            "Akta Sewa Gudang",
            "Penawaran resmi dari 2 vendor (dilengkapi KTP dan NPWP)",
            "Buffer Stok ATK",
            "Penawaran resmi dari 2 vendor (dilengkapi KTP dan NPWP)",
            "Buffer Stok ART",
            "Vendor Nasional / 2 vendor lokal",
            "Form IO",
            "Form FRI",
            "BA Kerusakan dari Area (Foto Kerusakan)",
            "Surat Keterangan Kerusakan/hasil pemerikasaan dari vendor",
            "Dokumentasi Kerusakan (Jika menganti barang IT yang rusak)",
            "Form Disposal Asset/Slip Setoran Penjualan Disposal",
            "Penawaran resmi dari 2 vendor (dilengkapi KTP dan NPWP)",
            "Dokumentasi Asset/ Inventaris (jika asset/inventaris rusak)",
            "Form Disposal Asset/Slip Setoran Penjualan Disposal",
            "BA Kerusakan dari Area",
            "Surat Keterangan Kerusakan/hasil pemerikasaan dari vendor",
            "Form IO",
            "Penawaran resmi dari 2 vendor (dilengkapi KTP dan NPWP)",
            "Dokumentasi kendaraan (plat nopol, no asset, tampak depan, kanan, kiri, belakang)",
            "Dokumentasi Ban Rusak",
            "BA Kerusakan dari Area / history perbaikan",
            "Penawaran resmi dari 2 vendor (dilengkapi KTP dan NPWP)",
            "Dokumentasi asset/inventaris yang akan di disposal",
            "Surat Keterangan Kerusakan/hasil pemerikasaan dari vendor menyatakan tidak bisa diperbaiki",
        ];
        $count = 0;
        foreach($category_names as $key=>$category_item){
            $category = new FileCategory;
            $category->name = $category_item;
            $category->save();
            for($i = 0; $i <$category_item_count[$key]; $i++){
                $file = new FileCompletement;
                $file->file_category_id = $category->id;
                $file->name = $items[$count];
                $file->save();
                $count++;
            }
        }
    }
}
