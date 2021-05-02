<!-- Modal -->
<div class="modal fade" id="addNewTicket" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pengadaan Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="required_field">Tanggal Pengajuan</label>
                            <input type="date" class="form-control" value="{{now()->format('Y-m-d')}}" disabled>
                        </div>
                    </div>
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="required_field">Tanggal Pengadaan</label>
                            <input type="date" class="form-control requirement_date">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="required_field">Pembuat Form</label>
                            <input type="text" class="form-control" value="{{Auth::user()->name}}" disabled>
                        </div>
                    </div>
                    <div class="col-md-5">
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
                    </div>
                    <div class="col-md-1 d-flex align-items-center">
                        <span class="spinner-border text-danger loading_salespoint_select2" role="status"
                            style="display:none">
                            <span class="sr-only">Loading...</span>
                        </span>
                    </div>
                    <div class="col-md-6 form-group">
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
                                    <th>Pilihan Merk</th>
                                    <th>Min Harga Satuan</th>
                                    <th>Max harga Satuan</th>
                                    <th>Harga Satuan</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
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
                                    <option value="" data-brand="-">-- Pilih Item Budget --</option>
                                    @foreach ($budget_category_items as $item)
                                    <optgroup label="{{$item->name}}">
                                        @foreach ($item->budget_pricing as $pricing)
                                        <option value="{{$pricing->id}}" data-brand="{{$pricing->brand}}"
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
                                    <b>Pilihan Brand :</b><br>
                                    <span class="brand_field">-</span>
                                </small>
                            </div>
                            <div class="form-group col-md-3 pl-1">
                                <label class="required_field">Pilih Merk</label>
                                <input type="text" class="form-control input_budget_brand">
                                <small class="text-danger">* harap menyertakan alasan di field alasan dan pengajuan jika merk yang dipilih bukan dari daftar pilihan</small>
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
                            <div class="form-group col-md-2 pl-1">
                                <label class="required_field">Jumlah Item</label>
                                <input type="number" class="form-control count_budget_item">
                            </div>
                            <div class="form-group col-md-1 pl-1">
                                <label>&nbsp</label>
                                <button type="button" class="btn btn-primary form-control"
                                    onclick="addBudgetItem(this)">Tambah Item</button>
                            </div>
                        </div>

                        <div class="d-none row justify-content-between nonbudget_item_adder">
                            <div class="form-group col-md-3">
                                <label class="required_field">Nama Item</label>
                                <input class="form-control nonbudget_item_name">
                            </div>
                            <div class="form-group col-md-3 pl-2">
                                <label class="optional_field">Brand</label>
                                <input class="form-control nonbudget_item_brand">
                            </div>
                            <div class="form-group col-md-3 pl-2">
                                <label class="required_field">Harga Item</label>
                                <input class="form-control rupiah nonbudget_item_price">
                            </div>
                            <div class="form-group col-md-2 pl-2">
                                <label class="required_field">Jumlah Item</label>
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-info" onclick="addRequest(this,0)">Simpan Sebagai Draft</button>
                <button type="button" class="btn btn-primary" onclick="addRequest(this,1)">Langsung Mulai Otorisasi</button>
            </div>
        </div>
        <form action="/addticket" method="post" id="addform">
        @csrf
        <div class="input_field"></div>
        </form>
    </div>
</div>

<div class="modal fade" id="detailTicket" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Pengadaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="col-md-8 box mb-3 p-3">
                    <span class="mb-2 h4">Status Otorisasi</span><br>
                    <table class="table table-sm table-borderless status_table">
                        <tbody>
                        </tbody>
                    </table>
                    <span class="termination_reason">
                        <b>Alasan Pembatalan</b><br>
                    </span>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="required_field">Tanggal Pengajuan</label>
                            <input type="text" class="form-control created_date" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="required_field">Pembuat Form</label>
                            <input type="text" class="form-control created_by"  disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="required_field">Tanggal Pengadaan</label>
                            <input type="date" class="form-control requirement_date" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="required_field">Pilihan Area / Salespoint</label>
                            <input type="text" class="form-control salespoint" disabled>
                        </div>
                    </div>
                    <div class="col-md-7">
                    </div>
                    <div class="col-md-12 box p-3 mb-3">
                        <div class="font-weight-bold h5">Urutan Otorisasi</div>
                        <div class="authorization_list_field row row-cols-md-3 row-cols-2 p-3">
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
                                    <th>Pilihan Merk</th>
                                    <th>Min Harga Satuan</th>
                                    <th>Max harga Satuan</th>
                                    <th>Harga Satuan</th>
                                    <th width="100px">Jumlah</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-12 mt-3">
                        <div class="form-group">
                            <label class="required_field">Alasan Pengadaan Barang atau Jasa</label>
                            <textarea class="form-control reason" rows="3" readonly></textarea>
                        </div>
                    </div>

                    <div class="col-md-12 box p-3 mt-3">
                        <h5 class="font-weight-bold required_field">Daftar Vendor</h5>
                        <table class="table table-bordered table_vendor">
                            <thead>
                                <tr>
                                    <th>Nama Vendor</th>
                                    <th>Sales Person</th>
                                    <th>Telfon</th>
                                    <th>Tipe</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-danger cancelticket" onclick="reject(this)">Batalkan Pengajuan</button>
                <button type="button" class="btn btn-primary startauthorization" onclick="startauthorization(this)">Mulai Pengajuan</button>
                <button type="button" class="btn btn-danger reject" onclick="reject(this)">Tolak pengajuan</button>
                <button type="button" class="btn btn-success approve" onclick="approve(this)">Approve pengajuan</button>
            </div>
        </div>
        <form action="/startauthorization" method="post" id="startauthorizationform">
            @csrf
            @method('patch')
            <input type="hidden" name="ticket_id">
            <input type="hidden" name="updated_at">
        </form>
        
        <form action="/approveticket" method="post" id="approveform">
            @csrf
            @method('patch')
            <input type="hidden" name="ticket_id">
            <input type="hidden" name="updated_at">
            <div class="input_field"></div>
        </form>
        
        <form action="/rejectticket" method="post" id="rejectform">
            @csrf
            @method('patch')
            <input type="hidden" name="ticket_id">
            <input type="hidden" name="updated_at">
            <div class="input_field"></div>
        </form>
    </div>
</div>