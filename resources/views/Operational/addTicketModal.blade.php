
<!-- Modal -->
<div class="modal fade" id="addNewTicket" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pengadaan Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Tanggal Pengajuan</label>
                          <input type="date" class="form-control" value="{{now()->format('Y-m-d')}}" disabled>
                        </div>
                    </div>
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                        <label for="">Nama Pengaju</label>
                        <select class="form-control" name="name">
                            <option value="">-- Pilih Nama Pengaju</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Pilihan Area</label>
                            <select class="form-control" name="area" disabled>
                            <option value="">-- Pilih Area --</option>
                            </select>
                            <small class="text-danger">Area yang muncul berdasarkan tempat pengaju dipilih</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Jenis Item</label>
                          <select class="form-control" name="item_type" required>
                            <option value="">-- Pilih Jenis Item --</option>
                            <option value="0">Barang</option>
                            <option value="1">Jasa</option>
                          </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Jenis Pengadaan</label>
                          <select class="form-control" name="request_type" id="">
                                <option value="">-- Pilih Jenis Pengadaan --</option>
                                <option>Replace</option>
                                <option>Existing</option>
                          </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Jenis Budget</label>
                          <select class="form-control" name="budget_type" required>
                            <option value="">-- Pilih Jenis Budget --</option>
                            <option value="0">Budget</option>
                            <option value="1">Non Budget</option>
                          </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama Item</th>
                                    <th>Jumlah</th>
                                    <th>Harga Satuan</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Item 1</td>
                                    <td>Rp 1.500.000</td>
                                    <td>1</td>
                                    <td><i class="fa fa-trash text-danger" aria-hidden="true"></i></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="d-flex flex-row justify-content-between" id="budget_item_adder">
                            <div class="form-group flex-grow-1">
                              <label for="">Pilih Item</label>
                              <select class="form-control select2" name="" id="select_budget_item">
                                <option value="">-- Pilih Item --</option>
                              </select>
                            </div>
                            <div class="form-group flex-grow-2 ml-2">
                                <label for="">Harga Item</label>
                                <input class="form-control autonum" name="" id="price_budget_item">
                                <small>
                                    Area : <b>Luar Jawa Sumatra</b><br>
                                    Harga Minimum : <b>-</b><br>
                                    Harga Maksimum : <b>Rp 2.000.000,-</b><br>
                                </small>
                            </div>
                            <div class="form-group ml-2">
                                <label for="">&nbsp</label>
                                <button type="button" class="btn btn-primary form-control">Tambah Item</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                          <label for="">Notes</label>
                          <textarea class="form-control" name="notes"rows="3"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12 form-group" id="matriks_otorisasi">
                        <label for="">Pilih Otorisasi</label>
                          <label for=""></label>
                          <select class="form-control select2" name="" id="">
                            <option></option>
                            <option></option>
                            <option></option>
                          </select>
                        <small class="text-danger">* Otorisasi dibuat berdasarkan nama pengaju. Untuk membuat sistem otorisasi dapat melakukan request ke super admin</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>