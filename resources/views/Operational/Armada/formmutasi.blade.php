<form id="formmutasi">
    <h5>Formulir Mutasi</h5>
    <div class="border p-2 border-dark">
        <h5 class="text-center">BERITA ACARA MUTASI INTERNAL ARMADA NIAGA/NON NIAGA</h5>
        <table class="table table-bordered table-sm">
            <tbody>
                <tr>
                    <td width="25%" class="required_field">No. BA Mutasi</td>
                    <td width="75%" colspan="3">
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control form-control-sm" required>
                            <div class="input-group-append">
                                <span class="input-group-text">/01/MA/I/2019</span>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="25%">PMA Pengirim</td>
                    <td width="25%">
                        <select class="form-control form-control-sm" name="sender_salespoint_id">
                            <option></option>
                            <option></option>
                            <option></option>
                        </select>
                    </td>
                    <td width="25%">PMA Penerima</td>
                    <td width="25%">
                        <select class="form-control form-control-sm" name="receiver_salespoint_id">
                            <option></option>
                            <option></option>
                            <option></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="25%">Tgl Mutasi</td>
                    <td width="25%">
                        <input type="date" class="form-control form-control-sm" name="mutation_date">
                    </td>
                    <td width="25%">Tgl Terima</td>
                    <td width="25%">
                        <input type="date" class="form-control form-control-sm" name="received_date">
                    </td>
                </tr>
            </tbody>
        </table>
        <span class="align-self-start small">* No. BA Mutasi hanya berlaku untuk satu dokumen</span>
        <p class="small">Sehubungan denagn adanya perubahan Cabang/Depo/CP, maka dilakukan mutasi armada dengan rincian data armada sebagai berikut:</p>
        <div class="row">
            <div class="col-4 small py-2"><i class="fa fa-circle fa-xs mr-1" style="font-size : 0.5rem" aria-hidden="true"></i>No. Polisi</div>
            <div class="col-8">
                <select class="form-control form-control-sm">
                    <option value=""></option>
                    <option value=""></option>
                </select>
            </div>
            <div class="col-4 small py-2"><i class="fa fa-circle fa-xs mr-1" style="font-size : 0.5rem" aria-hidden="true"></i>Nama Pemilik (Vendor)</div>
            <div class="col-8">
                <input type="text" class="form-control form-control-sm">
            </div>
            <div class="col-4 small py-2"><i class="fa fa-circle fa-xs mr-1" style="font-size : 0.5rem" aria-hidden="true"></i>Merk Kendaraan</div>
            <div class="col-8">
                <input type="text" class="form-control form-control-sm">
            </div>
            <div class="col-4 small py-2"><i class="fa fa-circle fa-xs mr-1" style="font-size : 0.5rem" aria-hidden="true"></i>Tipe/Jenis Kendaraan</div>
            <div class="col-8">
                <input type="text" class="form-control form-control-sm">
            </div>
            <div class="col-4 small py-2"><i class="fa fa-circle fa-xs mr-1" style="font-size : 0.5rem" aria-hidden="true"></i>No. Rangka</div>
            <div class="col-8">
                <input type="text" class="form-control form-control-sm">
            </div>
            <div class="col-4 small py-2"><i class="fa fa-circle fa-xs mr-1" style="font-size : 0.5rem" aria-hidden="true"></i>No. Mesin</div>
            <div class="col-8">
                <input type="text" class="form-control form-control-sm">
            </div>
            <div class="col-4 small py-2"><i class="fa fa-circle fa-xs mr-1" style="font-size : 0.5rem" aria-hidden="true"></i>Tahun Pembuatan</div>
            <div class="col-8">
                <input type="text" class="form-control form-control-sm">
            </div>
            <div class="col-4 small py-2"><i class="fa fa-circle fa-xs mr-1" style="font-size : 0.5rem" aria-hidden="true"></i>Masa Berlaku STNK</div>
            <div class="col-8">
                <input type="date" class="form-control form-control-sm">
            </div>
        </div>
        <p class="small">Kelengkapan kendaraan: </p>
        <div class="row">
            <div class="col-4 small py-2"><i class="fa fa-circle fa-xs mr-1" style="font-size : 0.5rem" aria-hidden="true"></i>Kotak P3k</div>
            <div class="col-8 py-2">
                <div class="form-check form-check-inline small">
                    <label class="form-check-label mr-2">
                        <input class="form-check-input" type="radio" name=""> Ada
                    </label>
                    <label class="form-check-label mr-2">
                        <input class="form-check-input" type="radio" name=""> Tidak
                    </label>
                </div>
            </div>
            <div class="col-4 small py-2"><i class="fa fa-circle fa-xs mr-1" style="font-size : 0.5rem" aria-hidden="true"></i>Segitiga Darurat</div>
            <div class="col-8 py-2">
                <div class="form-check form-check-inline small">
                    <label class="form-check-label mr-2">
                        <input class="form-check-input" type="radio" name=""> Ada
                    </label>
                    <label class="form-check-label mr-2">
                        <input class="form-check-input" type="radio" name=""> Tidak
                    </label>
                </div>
            </div>
            <div class="col-4 small py-2"><i class="fa fa-circle fa-xs mr-1" style="font-size : 0.5rem" aria-hidden="true"></i>Dongkrak</div>
            <div class="col-8 py-2">
                <div class="form-check form-check-inline small">
                    <label class="form-check-label mr-2">
                        <input class="form-check-input" type="radio" name=""> Ada
                    </label>
                    <label class="form-check-label mr-2">
                        <input class="form-check-input" type="radio" name=""> Tidak
                    </label>
                </div>
            </div>
            <div class="col-4 small py-2"><i class="fa fa-circle fa-xs mr-1" style="font-size : 0.5rem" aria-hidden="true"></i>Tool Kit Standar</div>
            <div class="col-8 py-2">
                <div class="form-check form-check-inline small">
                    <label class="form-check-label mr-2">
                        <input class="form-check-input" type="radio" name=""> Ada
                    </label>
                    <label class="form-check-label mr-2">
                        <input class="form-check-input" type="radio" name=""> Tidak
                    </label>
                </div>
            </div>
            <div class="col-4 small py-2"><i class="fa fa-circle fa-xs mr-1" style="font-size : 0.5rem" aria-hidden="true"></i>Ban Serep</div>
            <div class="col-8 py-2">
                <div class="form-check form-check-inline small">
                    <label class="form-check-label mr-2">
                        <input class="form-check-input" type="radio" name=""> Ada
                    </label>
                    <label class="form-check-label mr-2">
                        <input class="form-check-input" type="radio" name=""> Tidak
                    </label>
                </div>
            </div>
            <div class="col-4 small py-2"><i class="fa fa-circle fa-xs mr-1" style="font-size : 0.5rem" aria-hidden="true"></i>Kunci Gembok</div>
            <div class="col-8 py-2">
                <div class="form-check form-check-inline small">
                    <label class="form-check-label mr-2">
                        <input class="form-check-input" type="radio" name=""> Ada
                    </label>
                    <label class="form-check-label mr-2">
                        <input class="form-check-input" type="radio" name=""> Tidak
                    </label>
                </div>
            </div>
            <div class="col-4 small py-2"><i class="fa fa-circle fa-xs mr-1" style="font-size : 0.5rem" aria-hidden="true"></i>Ijin Bongkar</div>
            <div class="col-8 py-2">
                <div class="form-check form-check-inline small">
                    <label class="form-check-label mr-2">
                        <input class="form-check-input" type="radio" name=""> Ada
                    </label>
                    <label class="form-check-label mr-2">
                        <input class="form-check-input" type="radio" name=""> Tidak
                    </label>
                </div>
            </div>
            <div class="col-4 small py-2"><i class="fa fa-circle fa-xs mr-1" style="font-size : 0.5rem" aria-hidden="true"></i>Buku Keur</div>
            <div class="col-8 py-2">
                <div class="form-check form-check-inline small">
                    <label class="form-check-label mr-2">
                        <input class="form-check-input" type="radio" name=""> Ada
                    </label>
                    <label class="form-check-label mr-2">
                        <input class="form-check-input" type="radio" name=""> Tidak
                    </label>
                </div>
            </div>
        </div>
        <p class="small">Semikian berita acara mutasi armada ini kamu buat untuk dapat digunakan sebagaimana mestinya. Terimakasih atas perhatian dan kerjasamanya.</p>
        <div class="row">
            <div class="col-3">
                <input type="text" class="form-control form-control-sm" name="" placeholder="isi nama tempat">
            </div>
            <div class="col-3">
                <span class="align-middle">,{{now()->translatedFormat('d F Y')}}</span>
            </div>
        </div>
        <style>
            .sign_space{
                height: 125px;
            }
        </style>
        <div class="form-group mt-3">
          <label class="required_field">Pilih Otorisasi</label>
          <select class="form-control" required>
            <option></option>
            <option></option>
            <option></option>
          </select>
        </div>
        <table class="table table-borderless table-sm mt-3">
            <tr>
                <td width="20%">Dibuat Oleh,</td>
                <td width="80%" colspan="4" class="text-center">Diperiksa Oleh,</td>
            </tr>
            <tr>
                @for ($i = 0; $i < 5; $i++)
                <td width="20%" class="sign_space align-bottom text-center small">
                    asd
                </td>
                @endfor
            </tr>
        </table>
        
        <table class="table table-borderless table-sm mt-3">
            <tr>
                <td width="40%" colspan="2">Disetujui Oleh,</td>
                <td width="60%"></td>
            </tr>
            <tr>
                @for ($i = 0; $i < 2; $i++)
                <td width="20%" class="sign_space align-bottom text-center small">
                    asd
                </td>
                @endfor
            </tr>
        </table>
        <span class="small">FRM-HCD-107 REV 04</span>
    </div>
</form>