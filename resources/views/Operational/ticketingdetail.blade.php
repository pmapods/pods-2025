@extends('Layout.app')
@section('local-css')
<style>
    .bottom_action button{
        margin-right: 1em;
    }
    
    .box {
        box-shadow: 0px 1px 2px rgba(0, 0, 0,0.25);
        border : 1px solid;
        border-color: gainsboro;
        border-radius: 0.5em;
    }
    .select2-results__option--disabled {
        display: none;
    }
</style>
@endsection

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Pengadaan Barang Jasa Baru</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Operasional</li>
                    <li class="breadcrumb-item">Pengadaan</li>
                    <li class="breadcrumb-item active">Pengadaan Barang Jasa Baru</li>
                </ol>
            </div>
        </div>
        <div class="d-flex justify-content-end">
        </div>
    </div>
</div>
<div class="content-body">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label class="required_field">Tanggal Pengajuan</label>
                <input type="date" class="form-control created_date" value="{{now()->format('Y-m-d')}}" disabled>
                <small class="text-danger">* tanggal pengajuan yang tercatat adalah tanggal sistem saat otorisasi dimulai</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="required_field">Tanggal Pengadaan</label>
                <input type="date" class="form-control requirement_date">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="required_field">Expired Date</label>
                <input type="date" class="form-control expired_date" disabled>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="required_field">Pembuat Form</label>
                <input type="text" class="form-control form_creator" value="{{Auth::user()->name}}" disabled>
                <small class="text-danger">* Pembuat form yang tercatat di sistem sesuai dengan identitas login saat memulai otorisasi</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="required_field">Pilihan Area / Salespoint</label>
                <select class="form-control select2 salespoint_select2">
                    <option value="" data-isjawasumatra="-1">-- Pilih Salespoint --</option>
                    @foreach ($available_salespoints as $region)
                    <optgroup label="{{$region->first()->region_name()}}">
                        @foreach ($region as $salespoint)
                        <option value="{{$salespoint->id}}"
                            data-isjawasumatra="{{$salespoint->isJawaSumatra}}">{{$salespoint->name}} --
                            {{$salespoint->jawasumatra()}} Jawa Sumatra</option>
                        @endforeach
                    </optgroup>
                    @endforeach
                </select>
                <small class="text-danger">* Salespoint yang muncul berdasarkan hak akses tiap akun</small>
            </div>
            <span class="spinner-border text-danger loading_salespoint_select2" role="status"
                style="display:none">
                <span class="sr-only">Loading...</span>
            </span>
        </div>
        <div class="col-md-4 form-group">
            <label class="required_field">Pilih Otorisasi</label>
            <select class="form-control select2 authorization_select2" disabled>
                <option value="">-- Pilih Otorisasi --</option>
            </select>
            <small class="text-danger">* Pilihan otorisasi yang muncul berdasarkan salespoint yang dipilih.
                Untuk membuat sistem otorisasi dapat melakukan request ke super admin</small>
        </div>
        <div class="col-md-12 box p-3 mb-3">
            <div class="font-weight-bold h5">Urutan Otorisasi</div>
            <div class="authorization_list_field row row-cols-md-3 row-cols-2 p-3">
                <div>Belum memilih otorisasi</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="required_field">Jenis Item</label>
                <select class="form-control item_type" disabled>
                    <option value="">-- Pilih Jenis Item --</option>
                    <option value="0">Barang</option>
                    <option value="1">Jasa</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="required_field">Jenis Pengadaan</label>
                <select class="form-control request_type" disabled>
                    <option value="">-- Pilih Jenis Pengadaan --</option>
                    <option value="0">Baru</option>
                    <option value="1">Replace / Existing</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="required_field">Jenis Budget</label>
                <select class="form-control budget_type" disabled>
                    <option value="">-- Pilih Jenis Budget --</option>
                    <option value="0">Budget</option>
                    <option value="1">Non Budget</option>
                </select>
            </div>
        </div>
        <div class="col-md-12 box p-3 mt-3">
            <h5 class="font-weight-bold required_field">Daftar Barang</h5>
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
                    <tr class="empty_row text-center">
                        <td colspan="8">Item belum dipilih</td>
                    </tr>
                </tbody>
            </table>
    
            <div class="d-none row justify-content-between budget_item_adder">
                <div class="form-group col-md-3">
                    <label class="required_field">Pilih Item</label>
                    <select class="form-control select2 select_budget_item">
                        <option value="" data-brand="">-- Pilih Item Budget --</option>
                        @foreach ($budget_category_items as $item)
                        <optgroup label="{{$item->name}}">
                            @foreach ($item->budget_pricing as $pricing)
                            <option value="{{$pricing->id}}" 
                                data-brand="{{$pricing->budget_brand}}"
                                data-type="{{$pricing->budget_type}}"
                                data-categorycode="{{$item->code}}"
                                data-minjs="{{$pricing->injs_min_price}}"
                                data-maxjs="{{$pricing->injs_max_price}}"
                                data-minoutjs="{{$pricing->outjs_min_price}}"
                                data-maxoutjs="{{$pricing->outjs_max_price}}">{{$pricing->name}}</option>
                            @endforeach
                        </optgroup>
                        @endforeach
                    </select>
                    <small>
                        <b>Pilihan Merk :</b><br>
                        <span class="brand_field">-</span><br>
                        <b>Pilihan Tipe :</b><br>
                        <span class="type_field">-</span>
                    </small>
                </div>
                <div class="col-md-4 pl-1 row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="required_field">Pilih Merk</label>
                            <select class="form-control select_budget_brand" disabled>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="required_field">Pilih Tipe</label>
                            <select class="form-control select_budget_type" disabled>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group input_budget_brand_field" style="display: none">
                            <label class="required_field">Nama Merk Lain</label>
                            <input class="form-control input_budget_brand">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group input_budget_type_field" style="display: none">
                            <label class="required_field">Nama Tipe Lain</label>
                            <input class="form-control input_budget_type">
                        </div>
                    </div>
                    <div class="col-12 budget_ba_field" style="display: none">
                        <label class="required_field">Berita Acara</label>
                        <input type="file" class="form-control-file budget_ba_file" accept="application/pdf,application/vnd.ms-excel">
                        <small class="text-danger">*pdf, xls</small>
                    </div>
                </div>
                <div class="form-group col-md-3 pl-1">
                    <label class="required_field">Harga Item</label>
                    <input class="form-control rupiah price_budget_item">
                    <small>
                        Area : <span class="font-weight-bold area_status">-</span><br>
                        Harga Minimum : <span class="font-weight-bold item_min_price">-</span><br>
                        Harga Maksimum : <span class="font-weight-bold item_max_price">-</span><br>
                    </small>
                </div>
                <div class="form-group col-md-1 pl-1">
                    <label class="required_field">Jumlah</label>
                    <input type="number" class="form-control count_budget_item">
                </div>
                <div class="form-group col-md-1 pl-1">
                    <label>&nbsp</label>
                    <button type="button" class="btn btn-primary form-control"
                        onclick="addBudgetItem(this)">Tambah</button>
                </div>
            </div>
    
            <div class="d-none row justify-content-between nonbudget_item_adder">
                <div class="form-group col-md-3">
                    <label class="required_field">Nama Item</label>
                    <input class="form-control nonbudget_item_name">
                </div>
                <div class="form-group col-md-4 pl-2">
                    <label class="optional_field">Merk</label>
                    <input class="form-control nonbudget_item_brand">
                </div>
                <div class="form-group col-md-3 pl-2">
                    <label class="required_field">Harga Item</label>
                    <input class="form-control rupiah nonbudget_item_price">
                </div>
                <div class="form-group col-md-1 pl-2">
                    <label class="required_field">Jumlah</label>
                    <input type="number" class="form-control nonbudget_item_count">
                </div>
                <div class="form-group col-md-1 pl-2">
                    <label>&nbsp</label>
                    <button type="button" class="btn btn-primary form-control"
                        onclick="addNonBudgetItem(this)">Tambah</button>
                </div>
            </div>
        </div>
    
        <div class="col-md-12 mt-3">
            <div class="form-group">
                <label class="required_field">Alasan Pengadaan Barang atau Jasa</label>
                <textarea class="form-control reason" rows="3"></textarea>
            </div>
        </div>
    
        <div class="col-md-12 box p-3 mt-3">
            <h5 class="font-weight-bold required_field">Daftar Vendor</h5>
            <table class="table table-bordered table_vendor">
                <thead>
                    <tr>
                        <th>Kode Vendor</th>
                        <th>Nama Vendor</th>
                        <th>Sales Person</th>
                        <th>Telfon</th>
                        <th>Tipe</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="empty_row text-center">
                        <td colspan="6">Vendor belum dipilih</td>
                    </tr>
                </tbody>
            </table>
            <div class="row">
                <div class="col-md-4">
                    <h5>Vendor Terdaftar</h5>
                    <div class="form-group">
                        <label class="required_field">Pilih Vendor</label>
                        <select class="form-control select2 select_vendor">
                            <option value="">-- Pilih Vendor --</option>
                            @foreach ($vendors as $vendor)
                            <option value="{{$vendor->id}}" data-vendor="{{$vendor}}">{{$vendor->name}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="addVendor(this)">Tambah Vendor
                        Terdaftar</button>
                </div>
                <div class="col-md-8">
                    <h5>One Time Vendor</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="required_field">Nama Vendor</label>
                                <input type="text" class="form-control ot_vendor_name"
                                    placeholder="Masukan nama vendor">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="required_field">Sales Person</label>
                                <input type="text" class="form-control ot_vendor_sales"
                                    placeholder="Masukkan nama sales">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="required_field">Telfon</label>
                                <input type="text" class="form-control ot_vendor_phone"
                                    placeholder="Masukkan nomor telfon">
                            </div>
                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-primary" onclick="addOTVendor(this)">Tambah
                                One Time Vendor</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center mt-3 bottom_action">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-info" onclick="addRequest(this,0)">Simpan Sebagai Draft</button>
        <button type="button" class="btn btn-primary" onclick="addRequest(this,1)">Langsung Mulai Otorisasi</button>
    </div>
</div>

@endsection
@section('local-js')
<script src="/js/ticketingdetail.js"></script>
@endsection
