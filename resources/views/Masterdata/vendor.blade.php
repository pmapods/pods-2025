@extends('Layout.app')
@section('local-css')
<style>
    #pills-tab .nav-link{
        background-color: #a01e2b48;
        color: black !important;
    }
    #pills-tab .nav-link.active{
        background-color: #A01E2A;
        color: white !important;
    }
</style>
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
            <button type="button" class="btn btn-primary" data-toggle="modal" 
            data-target="#addVendorModal" id="addbuttonbarangjasa">
                Tambah Vendor
            </button>
            
            <button type="button" class="btn btn-primary" data-toggle="modal" 
            data-target="#addArmadaVendorModal" id="addbuttonarmada"
            style="display: none">
                Tambah Vendor Armada
            </button>
        </div>
    </div>
</div>
<div class="content-body px-4">
    <ul class="nav nav-pills flex-column flex-sm-row mb-3" id="pills-tab" role="tablist">
        <li class="flex-sm-fill text-sm-center nav-item mr-1" role="presentation">
          <a class="nav-link active" id="pills-barangjasa-tab" data-toggle="pill" href="#pills-barangjasa" role="tab" aria-controls="pills-barangjasa" aria-selected="true">Barang Jasa</a>
        </li>
        <li class="flex-sm-fill text-sm-center nav-item ml-1" role="presentation">
          <a class="nav-link" id="pills-armada-tab" data-toggle="pill" href="#pills-armada" role="tab" aria-controls="pills-armada" aria-selected="false">Armada</a>
        </li>
    </ul>
    
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-barangjasa" role="tabpanel" aria-labelledby="pills-barangjasa-tab">
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
                                Email
                            </th>
                    </thead>
                    <tbody>
                        @foreach ($vendors as $key=>$vendor)
                            <tr data-vendor="{{$vendor}}">
                                <td>{{$key+1}}</td>
                                <td>{{$vendor->code}}</td>
                                <td>{{$vendor->name}}</td>
                                <td>{{$vendor->address}}</td>
                                <td>{{$vendor->regency->name}}</td>
                                <td>{{$vendor->salesperson}}</td>
                                <td>{{$vendor->phone}}</td>
                                <td>{{$vendor->email}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-armada" role="tabpanel" aria-labelledby="pills-armada-tab">
            <table id="vendorArmadaDT" class="table table-bordered table-striped dataTable" role="grid">
                <thead>
                    <tr role="row">
                        <th width="5%">
                            #
                        </th>
                        <th>
                            Nama Vendor
                        </th>
                        <th width="5%">Action</th>
                </thead>
                <tbody>
                    @foreach ($armada_vendors as $key=>$vendor)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$vendor->name}}</td>
                            <td>
                               <i class="fa fa-trash text-danger" 
                               aria-hidden="true"
                               style="cursor: pointer;"
                               onclick="removeArmadaVendor({{ $vendor->id }})"></i> 
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<form id="submitform">
    @csrf
    <div></div>
</form>

<div class="modal fade" id="addVendorModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="/addvendor" method="post">
        @csrf
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
                            <label class="required_field">Kode</label>
                            <input type="text" class="form-control" name="code" placeholder="Masukkan Kode Vendor"
                                required>
                            <small class="form-text text-danger">Kode vendor bersifat unik / tidak boleh sama dengan
                                kode vendor lainnya</small>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="required_field">Nama</label>
                            <input type="text" class="form-control" name="name" placeholder="Masukkan Nama Vendor"
                                required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="required_field">Alamat</label>
                            <input type="text" class="form-control" name="address" placeholder="Masukkan Alamat Vendor"
                                required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="required_field">Kota Lokasi Vendor</label>
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
                            <label class="optional_field">Sales Person</label>
                            <input type="text" class="form-control" name="salesperson"
                                placeholder="Masukkan nama sales vendor">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="optional_field">Telfon</label>
                            <input type="text" class="form-control" name="phone"
                                placeholder="Masukkan no telfon vendor">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="optional_field">Email</label>
                            <input type="email" class="form-control" name="email"
                                placeholder="Masukkan email vendor">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Tambah Vendor</button>
            </div>
        </div>
        </form>
    </div>
</div>

<div class="modal fade" id="updateVendorModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="/updatevendor" method="post">
        @csrf
        @method('patch')
        <input type="hidden" name="id">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Vendor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="required_field">Kode</label>
                            <input type="text" class="form-control" name="code" placeholder="Masukkan Kode Vendor"
                                readonly>
                            <small class="form-text text-danger">Kode vendor bersifat unik / tidak boleh sama dengan
                                kode vendor lainnya</small>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="required_field">Nama</label>
                            <input type="text" class="form-control" name="name" placeholder="Masukkan Nama Vendor"
                                readonly>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="required_field">Alamat</label>
                            <input type="text" class="form-control" name="address" placeholder="Masukkan Alamat Vendor"
                                required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="required_field">Kota Lokasi Vendor</label>
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
                            <label class="optional_field">Sales Person</label>
                            <input type="text" class="form-control" name="salesperson" placeholder="Masukkan nama sales vendor">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="optional_field">Telfon</label>
                            <input type="text" class="form-control" name="phone" placeholder="Masukkan no telfon vendor">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="optional_field">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Masukkan email vendor">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-danger" onclick="deleteVendor(this)">Hapus Vendor</button>
                {{-- <button type="submit" class="btn btn-primary active_button" onclick="activeVendor(this)">Aktifkan Vendor</button>
                <button type="submit" class="btn btn-danger" onclick="nonactiveVendor(this)">Non Aktifkan Vendor</button> --}}
                <button type="submit" class="btn btn-primary">Perbarui Vendor</button>
            </div>
        </div>
        </form>
        <form action="/deletevendor" method="post" id="deleteform">
            @csrf
            @method('delete')
            <input type="hidden" name="id">
        </form>
    </div>
</div>

<div class="modal fade" id="addArmadaVendorModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="/addarmadavendor" method="post">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Vendor Armada</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                  <label for="armada_vendor_name">Nama Vendor Armada</label>
                  <input type="text" class="form-control" name="armada_vendor_name" id="armada_vendor_name" placeholder="Masukan Nama Vendor" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Tambah Vendor</button>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection
@section('local-js')
<script>
    $(document).ready(function(){
        var table = $('#vendorDT').DataTable(datatable_settings);
        var armadatable = $('#vendorArmadaDT').DataTable(datatable_settings);
        $('#vendorDT tbody').on('click', 'tr', function () {
            let modal = $('#updateVendorModal');
            let data = $(this).data('vendor');
            modal.find('input[name="id"]').val(data['id']);
            modal.find('input[name="code"]').val(data['code']);
            modal.find('input[name="name"]').val(data['name']);
            modal.find('input[name="address"]').val(data['address']);
            modal.find('select[name="city_id"]').val(data['city_id']);
            modal.find('select[name="city_id"]').trigger('change');
            modal.find('input[name="salesperson"]').val(data['salesperson']);
            modal.find('input[name="phone"]').val(data['phone']);
            modal.find('input[name="email"]').val(data['email']);
            modal.modal('show');
        });
        $('a[data-toggle="pill"]').on('shown.bs.tab', function (event) {
            var target = $(event.target).attr("href").split('-')[1];

            $('#addbuttonbarangjasa').hide();
            $('#addbuttonarmada').hide();
            switch (target) {
                case 'barangjasa':
                    $('#addbuttonbarangjasa').show();
                    break;
                case 'armada':
                    $('#addbuttonarmada').show();
                    break;
            }
        });
    })
    function deleteVendor(el){
        if (confirm('Vendor akan dihapus dan tidak dapat dikembalikan. Lanjutkan?')) {
            $('#deleteform').submit();
        }
    }
    function removeArmadaVendor(armada_vendor_id){
        $('#submitform').find('div').empty();
        $('#submitform').prop('action', "/deletearmadavendor");
        $('#submitform').prop('method', "POST");
        $('#submitform').find('div').append('<input type="hidden" name="armada_vendor_id" value="'+armada_vendor_id+'">');
        $('#submitform').submit();
    }
</script>
@endsection
