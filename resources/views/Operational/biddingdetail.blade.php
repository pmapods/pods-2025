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
        <div class="col-md-6">
            <div class="form-group">
                <label>Tanggal Pengajuan</label>
                <input type="text" class="form-control created_date" disabled>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Pembuat Form</label>
                <input type="text" class="form-control created_by"  disabled>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Tanggal Pengadaan</label>
                <input type="date" class="form-control requirement_date" disabled>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Pilihan Area / Salespoint</label>
                <input type="text" class="form-control salespoint" disabled>
            </div>
        </div>
        <div class="col-md-7">
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Jenis Item</label>
                <select class="form-control item_type" disabled>
                    <option value="0">Barang</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="">Jenis Pengadaan</label>
                <select class="form-control request_type" disabled>
                    <option value="0">Baru</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="">Jenis Budget</label>
                <select class="form-control budget_type" disabled>
                    <option value="0">Budget</option>
                </select>
            </div>
        </div>
        <div class="col-md-12 box p-3 mt-3">
            <h5 class="font-weight-bold ">Daftar Barang</h5>
            <table class="table table-bordered table_item">
                <thead>
                    <tr>
                        <th>Nama Item</th>
                        <th>Pilihan Merk</th>
                        <th>Min Harga Satuan</th>
                        <th>Max harga Satuan</th>
                        <th>Harga Satuan</th>
                        <th width="100px">Jumlah</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-12">
            <h5 class="font-weight-bold mt-3">Daftar Vendor</h5>
        </div>
        <div class="col-md-6 box p-3">
            <div class="d-flex flex-row justify-content-between h5 font-weight-bold">
                <span>nama_vendor</span>
                <span>Vendor 1</span>
            </div>
            <table class="table table-borderless">
                <tr>
                    <td>Alamat</td>
                    <td>Occaecat fugiat minim excepteur cupidatat labore enim tempor ullamco id fugiat. Sit ad </td>
                </tr>
                <tr>
                    <td>Salesperson</td>
                    <td>Budi</td>
                </tr>
                <tr>
                    <td>Salesperson</td>
                    <td>123-123-123</td>
                </tr>
            </table>
        </div>
    </div>
</div>

@endsection
@section('local-js')
<script>
</script>
@endsection
