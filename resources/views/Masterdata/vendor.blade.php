@extends('Layout.app')
@section('local-css')

@endsection

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Vendor</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Masterdata</li>
                    <li class="breadcrumb-item active">Vendor</li>
                </ol>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-2">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addVendorModal">
                Tambah Vendor
            </button>
        </div>
    </div>
</div>
<div class="content-body px-4">
    <div class="table-responsive">
        <table id="vendorDT" class="table table-bordered table-striped dataTable" role="grid">
            <thead>
                <tr role="row">
                    <th>
                        #
                    </th>
                    <th>
                        Kode Vendor
                    </th>
                    <th>
                        Nama Vendor
                    </th>
                    <th>
                        Alamat
                    </th>
                    <th>
                        Kota
                    </th>
                    <th>
                        Sales Person
                    </th>
                    <th>
                        Telfon
                    </th>
                    <th>
                        Status
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vendors as $key=>$vendor)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$vendor->code}}</td>
                        <td>{{$vendor->name}}</td>
                        <td>{{$vendor->address}}</td>
                        <td>{{$vendor->regency->name}}</td>
                        <td>{{$vendor->salesperson}}</td>
                        <td>{{$vendor->phone}}</td>
                        <td>{{$vendor->status_name()}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addVendorModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Vendor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                          <label for="">Kode</label>
                          <input type="text" class="form-control" name="code" placeholder="Masukkan Kode Vendor" required>
                          <small id="helpId" class="form-text text-danger">Kode vendor bersifat unik / tidak boleh sama dengan kode vendor lainnya</small>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                          <label for="">Nama</label>
                          <input type="text" class="form-control" name="name" placeholder="Masukkan Nama Vendor" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                          <label for="">Alamat</label>
                          <input type="text" class="form-control" name="address" placeholder="Masukkan Alamat Vendor" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                          <label for="">Kota Lokasi Vendor</label>
                            <select class="form-control select2" name="city_id">
                                <option value="">-- Pilih Kota --</option>
                                @foreach ($provinces as $province)
                                    <optgroup label="{{$province->name}}">
                                        @foreach ($province->regencies as $regency)
                                            <option value="{{$regency->id}}">{{$regency->name}}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                          <label for="">Sales Person</label>
                          <input type="text" class="form-control" name="salesperson" placeholder="Masukkan nama sales vendor">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                          <label for="">Telfon</label>
                          <input type="text" class="form-control" name="phone" placeholder="Masukkan no telfon vendor" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary">Tambah Vendor</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('local-js')
<script>
    $(document).ready(function(){
        var table = $('#vendorDT').DataTable(datatable_settings);
        $('#vendorDT tbody').on('click', 'tr', function () {

        });
    })
</script>
@endsection
