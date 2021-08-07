<form id="formperpanjangan">
    <h5>Form Perpanjangan Perhentian</h5>
    <div class="row border border-dark bg-light p-4">
        <div class="col-12">
            <center class="h4 text-uppercase"><u>form perpanjangan/penghentian sewa armada</u></center>
        </div>
        
        <div class="col-12 d-flex flex-column mt-5">
            <span>Kami yang bertanda tangan di bawah ini :</span>
            <div class="form-group row mt-2">
                <label class="col-3 col-form-label">Nama</label>
                <div class="col-1">:</div>
                <div class="col-8">
                  <input type="text" class="form-control form-control-sm" placeholder="Masukkan Nama" 
                  value="{{ Auth::user()->name }}">
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
                  <select class="form-control form-control-sm">
                    <option value="">-- Pilih Jabatan --</option>
                    @foreach ($employee_positions as $position)
                        <option value="{{$position->name}}">{{$position->name }}</option>
                    @endforeach
                  </select>
                </div>
            </div>
            <div class="form-group row mt-2">
                <label class="col-3 col-form-label">Cabang/Depo/CP</label>
                <div class="col-1">:</div>
                <div class="col-8">
                    <input type="text" class="form-control form-control-sm"
                    value="{{ $armadaticket->salespoint->name }}" readonly>
                </div>
            </div>
            <span>Dengan ini mengajukan perpanjangan / penghentian sewa armada sebagai berikut :</span>
            <div class="form-group row mt-2">
                <div class="col-1">1.</div>
                <div class="col-2 small">Armada</div>
                <div class="col-1 small">:</div>
                <div class="col-7">
                  <input type="text" class="form-control form-control-sm" value="{{ ($armadaticket->isNiaga)?'Niaga':'Non Niaga' }}" readonly>
                </div>
            </div>
            
            <div class="form-group row mt-2">
                <div class="col-1">2.</div>
                <div class="col-2 small">Jenis Kendaraan</div>
                <div class="col-1 small">:</div>
                <div class="col-7">
                    <input type="text" class="form-control form-control-sm" value="{{ $armadaticket->armada_type()->name }}" readonly>
                </div>
            </div>
            
            <div class="form-group row mt-2">
                <div class="col-1">3.</div>
                <div class="col-2 small">Nopol</div>
                <div class="col-1 small">:</div>
                <div class="col-7">
                    <input type="text" class="form-control form-control-sm" value="{{ $armadaticket->armada()->plate }}" readonly>
                </div>
            </div>
            
            <div class="form-group row mt-2">
                <div class="col-1">4.</div>
                <div class="col-2 small">Unit</div>
                <div class="col-1 small">:</div>
                <div class="col-7">
                    <select class="form-control form-control-sm" >
                        <option value="">-- Pilih Unit --</option>
                        <option value="gs">GS</option>
                        <option value="gt">GT</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group row mt-2">
                <div class="col-1">5.</div>
                <div class="col-2 small">Vendor</div>
                <div class="col-1 small">:</div>
                <div class="col-7">
                    <select class="form-control form-control-sm vendor">
                        <option value="">-- Pilih Unit --</option>
                        <option value="assa">ASSA</option>
                        <option value="batavia">Batavia</option>
                        <option value="trac">TRAC</option>
                        <option value="mardika">Mardika</option>
                        <option value="mpm">MPM</option>
                        <option value="lokal">Lokal</option>
                    </select>
                    <input type="text" class="form-control form-control-sm mt-1 localvendor"
                    placeholder="Masukkan Nama Vendor Lokal"
                    disabled>
                </div>
            </div>
            
            <div class="row mt-2">
                <div class="col-1 small">6.</div>
                <div class="col-10 small">Status</div>
            </div>

            <div class="form-group row mt-2">
                <div class="offset-1 col-2 small">* Perpanjangan</div>
                <div class="col-1 small">:</div>
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
                <div class="offset-1 col-2 small">* Stop Sewa</div>
                <div class="col-1">:</div>
                <div class="col-5">
                    <input type="date" class="form-control form-control-sm">
                </div>
            </div>
        </div>
        <div class="col-12 text-center">
            <span class="required_field">Alasan  </span>

            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="alasan" value="replace">Replace
                </label>
            </div>
            
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="alasan" value="renewal">Renewal
                </label>
            </div>
            
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="alasan" value="end kontrak">End Kontrak
                </label>
            </div>
        </div>
        <div class="col-12 pt-3">
            Pernyataan ini dibuat dengan sebenar-benarnya, jika ada perubahan kerugian akan dibebankan kepada masing-masing personal.
        </div>
        <div class="col-12 pt-2">
            <div class="form-group">
              <label class="required_field">Pilih Otorisasi</label>
              <select class="form-control authorization">
                  <option value="">-- Pilih Otorisasi --</option>
                  @foreach ($formperpanjangan_authorizations as $authorization)
                    @php
                    $list= $authorization->authorization_detail;
                    $string = "";
                    foreach ($list as $key=>$author){
                        $author->employee_position->name;
                        $string = $string.$author->employee->name;
                        if(count($list)-1 != $key){
                            $string = $string.' -> ';
                        }
                    }
                    @endphp
                    <option value="{{ $authorization->id }}"
                        data-list = "{{ $list }}">
                        {{$string}}</option>
                  @endforeach
              </select>
            </div>
        </div>
        <div class="col-12 pt-2">
            <table class="table table-bordered authorization_table">
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>