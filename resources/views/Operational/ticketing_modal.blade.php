
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
                                        <option value="{{$salespoint->id}}" data-isjawasumatra="{{$salespoint->isJawaSumatra}}">{{$salespoint->name}} -- {{$salespoint->jawasumatra()}} Jawa Sumatra</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                            </select>
                            <small class="text-danger">* Salespoint yang muncul berdasarkan hak akses tiap akun</small>
                        </div>
                    </div>
                    <div class="col-md-1 d-flex align-items-center">
                        <span class="spinner-border text-danger loading_salespoint_select2" role="status" style="display:none">
                            <span class="sr-only">Loading...</span>
                        </span>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="required_field">Pilih Otorisasi</label>
                          <select class="form-control select2 authorization_select2" disabled>
                            <option value="">-- Pilih Otorisasi --</option>
                          </select>
                        <small class="text-danger">* Pilihan otorisasi yang muncul berdasarkan salespoint yang dipilih. Untuk membuat sistem otorisasi dapat melakukan request ke super admin</small>
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
                          <select class="form-control" name="item_type" required>
                            <option value="">-- Pilih Jenis Item --</option>
                            <option value="0">Barang</option>
                            <option value="1">Jasa</option>
                          </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label class="required_field">Jenis Pengadaan</label>
                          <select class="form-control" name="request_type" id="">
                                <option value="">-- Pilih Jenis Pengadaan --</option>
                                <option>Replace</option>
                                <option>Existing</option>
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
                                    <th>Min Harga Satuan</th>
                                    <th>Max harga Satuan</th>
                                    <th>Harga Satuan</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="empty_row text-center"><td colspan="7">Item belum dipilih</td></tr>
                            </tbody>
                        </table>

                        <div class="d-none flex-row justify-content-between budget_item_adder">
                            <div class="form-group flex-grow-1">
                              <label for="">Pilih Item</label>
                              <select class="form-control select2 select_budget_item">
                                  <option value="">-- Pilih Item Budget --</option>
                                  @foreach ($budget_category_items as $item)
                                    <optgroup label="{{$item->name}}">
                                        @foreach ($item->budget_pricing as $pricing)
                                            <option value="{{$pricing->id}}" 
                                                data-minjs="{{$pricing->injs_min_price}}"
                                                data-maxjs="{{$pricing->injs_max_price}}"
                                                data-minoutjs="{{$pricing->outjs_min_price}}"
                                                data-maxoutjs="{{$pricing->outjs_max_price}}">{{$pricing->name}}</option>
                                        @endforeach
                                    </optgroup>
                                  @endforeach
                              </select>
                            </div>
                            <div class="form-group flex-grow-1 ml-2">
                                <label for="">Harga Item</label>
                                <input class="form-control rupiah price_budget_item">
                                <small>
                                    Area : <span class="font-weight-bold area_status">-</span><br>
                                    Harga Minimum : <span class="font-weight-bold item_min_price">-</span><br>
                                    Harga Maksimum : <span class="font-weight-bold item_max_price">-</span><br>
                                </small>
                            </div>
                            <div class="form-group flex-grow-2 ml-2">
                                <label for="">Jumlah Item</label>
                                <input type="number" class="form-control count_budget_item">
                            </div>
                            <div class="form-group ml-2">
                                <label for="">&nbsp</label>
                                <button type="button" class="btn btn-primary form-control" onclick="addBudgetItem(this)">Tambah Item</button>
                            </div>
                        </div>
                        
                        <div class="d-none flex-row justify-content-between nonbudget_item_adder">
                            <div class="form-group flex-grow-1">
                              <label for="">Nama Item</label>
                              <input class="form-control nonbudget_item_name">
                            </div>
                            <div class="form-group flex-grow-1 ml-2">
                                <label for="">Harga Item</label>
                                <input class="form-control rupiah nonbudget_item_price">
                            </div>
                            <div class="form-group flex-grow-2 ml-2">
                                <label for="">Jumlah Item</label>
                                <input type="number" class="form-control nonbudget_item_count">
                            </div>
                            <div class="form-group ml-2">
                                <label for="">&nbsp</label>
                                <button type="button" class="btn btn-primary form-control" onclick="addNonBudgetItem(this)">Tambah Item</button>
                            </div>
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
                                <tr class="empty_row text-center"><td colspan="6">Vendor belum dipilih</td></tr>
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
                                          <option value="{{$vendor->id}}" data-vendor="{{$vendor}}">{{$vendor->name}}</option>
                                      @endforeach
                                  </select>
                                </div>
                                <button type="button" class="btn btn-primary" onclick="addVendor(this)">Tambah Vendor Terdaftar</button>
                            </div>
                            <div class="col-md-8">
                                <h5>One Time Vendor</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                          <label class="required_field">Nama Vendor</label>
                                          <input type="text" class="form-control ot_vendor_name" placeholder="Masukan nama vendor">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                          <label class="required_field">Sales Person</label>
                                          <input type="text" class="form-control ot_vendor_sales" placeholder="Masukkan nama sales">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                          <label class="required_field">Telfon</label>
                                          <input type="text" class="form-control ot_vendor_phone" placeholder="Masukkan nomor telfon">
                                        </div>
                                    </div>
                                    <div class="col-md-6"></div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-primary" onclick="addOTVendor(this)">Tambah One Time Vendor</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12 mt-3">
                        <div class="form-group">
                          <label class="optional_field">Notes</label>
                          <textarea class="form-control" name="notes" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>