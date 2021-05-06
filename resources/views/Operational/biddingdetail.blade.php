@extends('Layout.app')
@section('local-css')
<style>
    .box {
        box-shadow: 0px 1px 2px rgba(0, 0, 0,0.25);
        border : 1px solid;
        border-color: gainsboro;
        border-radius: 0.5em;
    }
</style>
@endsection

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Operasional</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Operasional</li>
                    <li class="breadcrumb-item active">Bidding Detail</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="content-body px-4">
    <h3>PCD-210425-0001</h3>
    <div class="row">
        <div class="col-md-4">
            <table class="table table-borderless table-sm">
                <tbody>
                    <tr>
                        <td><b>Tanggal Pengajuan</b></td>
                        <td>26 April 2021</td>
                    </tr>
                    <tr>
                        <td><b>Tanggal Pengadaan</b></td>
                        <td>5 Mei 2021</td>
                    </tr>
                    <tr>
                        <td><b>Tanggal Expired</b></td>
                        <td>7 Mei 2021</td>
                    </tr>
                    <tr>
                        <td><b>Salespoint</b></td>
                        <td>DAAN MOGOT MT</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-4">
            <table class="table table-borderless table-sm">
                <tbody>
                    <tr>
                        <td><b>Jenis Item</b></td>
                        <td>Barang</td>
                    </tr>
                    <tr>
                        <td><b>Jenis Pengadaan</b></td>
                        <td>Baru</td>
                    </tr>
                    <tr>
                        <td><b>Jenis Budget</b></td>
                        <td>Budget</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-12 box p-3 mt-3">
            <h5 class="font-weight-bold ">Daftar Barang</h5>
            <table class="table table-bordered table_item">
                <thead>
                    <tr>
                        <th>Nama Item</th>
                        <th>Merk</th>
                        <th>Type</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th>Attachment</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Laptop</td>
                        <td>Dell</td>
                        <td>13 Inch</td>
                        <td>Rp 5.000.000</td>
                        <td>5</td>
                        <td>Rp 25.000.000</td>
                        <td>
                            <a href="http://www.africau.edu/images/default/sample.pdf" download="ba_file.pdf">ba_file.pdf</a><br>
                            <a href="https://cdn.pocket-lint.com/r/s/1200x/assets/images/155087-laptops-review-microsoft-surface-laptop-go-review-image1-6ezitk9ymj.jpg" download="old_item.jpg">old_item.jpg</a><br>
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary">Seleksi Vendor</button>
                            <button type="button" class="btn btn-info">Detail</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-12 box p-3 mt-3">
            <h5 class="font-weight-bold">Daftar Vendor</h5>
            <table class="table table-bordered table_vendor">
                <thead>
                    <tr>
                        <th>Kode Vendor</th>
                        <th>Nama Vendor</th>
                        <th>Sales Person</th>
                        <th>Telfon</th>
                        <th>Tipe</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>V-1</td>
                        <td>PT Tamba</td>
                        <td>Vivi</td>
                        <td>(+62) 27 3830 117</td>
                        <td>Terdaftar</td>
                    </tr>
                    <tr>
                        <td>V-3</td>
                        <td>CV Megantara</td>
                        <td>Laila</td>
                        <td>0556 1486 795</td>
                        <td>Terdaftar</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
@section('local-js')
<script>
</script>
@endsection
