<section class="formperpanjangan">
    <h5>Form Perpanjangan Perhentian</h5>
    <div class="row border border-dark">
        <div class="col-12">
            <center class="h4 text-uppercase"><u>form perpanjangan/penghentian sewa armada</u></center>
        </div>
        
        <div class="col-12 d-flex flex-column mt-5">
            <span>Kami yang bertanda tangan di bawah ini :</span>
            <div class="form-group row mt-2">
                <label class="col-3 col-form-label">Nama</label>
                <div class="col-1">:</div>
                <div class="col-8">
                  <input type="text" class="form-control form-control-sm" placeholder="Masukkan Nama">
                </div>
            </div>
            <div class="form-group row mt-2">
                <label class="col-3 col-form-label">NIK</label>
                <div class="col-1">:</div>
                <div class="col-8">
                  <input type="text" class="form-control form-control-sm" placeholder="Masukkan NIK">
                </div>
            </div>
            <div class="form-group row mt-2">
                <label class="col-3 col-form-label">Jabatan</label>
                <div class="col-1">:</div>
                <div class="col-8">
                  <input type="text" class="form-control form-control-sm" placeholder="Masukkan Jabatan">
                </div>
            </div>
            <div class="form-group row mt-2">
                <label class="col-3 col-form-label">Cabang/Depo/CP</label>
                <div class="col-1">:</div>
                <div class="col-8">
                  <input type="text" class="form-control form-control-sm" placeholder="Masukkan Nama">
                </div>
            </div>
            <span>Dengan ini mengajukan perpanjangan/penghentian* sewa armada sebagai berikut :</span>
            <div class="form-group row mt-2">
                <div class="offset-1 col-1">1.</div>
                <div class="col-2">Armada</div>
                <div class="col-1">:</div>
                <div class="col-7">
                  <input type="text" class="form-control form-control-sm" value="Niaga" readonly>
                </div>
            </div>
            
            <div class="form-group row mt-2">
                <div class="offset-1 col-1">2.</div>
                <div class="col-2">Jenis Kendaraan</div>
                <div class="col-1">:</div>
                <div class="col-7">
                      <select class="form-control select2">
                        <option value="">Xenia - B 1170 CFJ</option>
                        <option value="">Xenia - B 1170 CFJ</option>
                        <option value="">Xenia - B 1170 CFJ</option>
                        <option value="">Xenia - B 1170 CFJ</option>
                        <option value="">Xenia - B 1170 CFJ</option>
                        <option value="">Xenia - B 1170 CFJ</option>
                        <option value="">Xenia - B 1170 CFJ</option>
                      </select>
                </div>
            </div>
            
            <div class="form-group row mt-2">
                <div class="offset-1 col-1">3.</div>
                <div class="col-2">Nopol</div>
                <div class="col-1">:</div>
                <div class="col-7">
                  <input type="text" class="form-control form-control-sm" value="B1170 CFJ" readonly>
                </div>
            </div>
            
            <div class="form-group row mt-2">
                <div class="offset-1 col-1">4.</div>
                <div class="col-2">Unit</div>
                <div class="col-1">:</div>
                <div class="col-7">
                  <input type="text" class="form-control form-control-sm" placeholder="Masukkan Nama">
                </div>
            </div>
            
            <div class="form-group row mt-2">
                <div class="offset-1 col-1">5.</div>
                <div class="col-2">Vendor</div>
                <div class="col-1">:</div>
                <div class="col-7">
                  <input type="text" class="form-control form-control-sm" placeholder="Masukkan Nama">
                </div>
            </div>
            
            <div class="row mt-2">
                <div class="offset-1 col-1">6.</div>
                <div class="col-10">Status</div>
            </div>

            <div class="form-group row mt-2">
                <div class="offset-2 col-2">* Perpanjangan</div>
                <div class="col-1">:</div>
                <div class="col-2">
                    <div class="input-group input-group-sm">
                        <input type="number" class="form-control" min="1" value="1" required>
                        <div class="input-group-append">
                            <span class="input-group-text">bulan</span>
                        </div>
                    </div>
                </div>
                <div class="col-5">(diisi berapa bulan akan diperpanjang)</div>
            </div>
            <div class="form-group row mt-2">
                <div class="offset-2 col-2">* Stop Sewa</div>
                <div class="col-1">:</div>
                <div class="col-5">
                    <input type="date" class="form-control form-control-sm">
                </div>
            </div>
        </div>
        <div class="col-12 text-center">
            Alasan : <span>Replace</span>
        </div>
        <div class="col-12">
            Pernyataan ini dibuat dengan sebenar-benarnya, jika ada perubahan kerugian akan dibebankan kepada masing-masing personal.
        </div>
        <div class="col-12">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td class="small">Yang mengajukan,</td>
                        <td class="small" colspan="3">Diketahui oleh,</td>
                        <td class="small">Disetujui,</td>
                    </tr>
                    <tr>
                        <td width="20%" class="align-bottom small" style="height: 80px">AOS/GA Spv</td>
                        <td width="20%" class="align-bottom small" style="height: 80px">Atasan Langsung</td>
                        <td width="20%" class="align-bottom small" style="height: 80px">OM</td>
                        <td width="20%" class="align-bottom small" style="height: 80px">LOM</td>
                        <td width="20%" class="align-bottom small" style="height: 80px">NOM</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
{{-- @section('local-js')
<script>
$(document).ready(function () {
    console.log('this is form perpanjangan perhentian');
});
</script>
@endsection --}}