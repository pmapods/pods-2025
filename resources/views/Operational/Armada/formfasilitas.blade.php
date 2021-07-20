<style>
    .formfasilitas .table-bordered td{
        border : 1px solid #000 !important;
    }
</style>
<form id="formfasilitas">
    <h5>Formulir Fasilitas</h5>
    <div class="row border border-dark bg-light p-2">
        <div class="col-9">
            <table class="table table-bordered table-sm text-center h-100">
                <tbody>
                    <tr>
                        <td rowspan="2" class="align-middle">
                            <img src="/assets/logo.png" width="80px">
                        </td>
                        <td class="align-middle h5 table-secondary">FORMULIR</td>
                        <td class="align-middle table-secondary">Hal</td>
                    </tr>
                    <tr>
                        <td class="align-middle h5">FASILITAS KARYAWAN & PERLENGKAPAN KERJA KARYAWAN BARU</td>
                        <td class="align-middle">1/1</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-3">
            <table class="table table-bordered table-sm text-center h-100 small">
                <tr><td class="table-secondary">
                    <label class="required_field">
                        Tanggal
                    </label>
                </td></tr>
                <tr><td>
                    <input type="date" class="form-control form-control-sm" name="date" value="{{now()->format('Y-m-d') }}">
                </td></tr>
                <tr><td class="table-secondary">
                    <label class="required_field">
                        Nomor
                    </label>
                </td></tr>
                <tr><td>
                    <input type="text" class="form-control form-control-sm" name="number">
                </td></tr>
            </table>
        </div>
        <div class="col-12">
            <table class="table table-bordered table-sm align-middle">
                <tr>
                    <td width="20%" class="table-secondary">
                        <label class="required_field small" >Nama</label>
                    </td>
                    <td colspan="3">
                        <input type="text" class="form-control form-control-sm" placeholder="Masukkan Nama" required>
                    </td>
                </tr>
                <tr>
                    <td width="20%" class="table-secondary">
                        <label class="required_field small">Divisi/Dept/Bag</label>
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm" placeholder="Masukkan Divisi" required>
                    </td>
                    <td width="20%" class="table-secondary">
                        <label class="required_field small">Telephone</label>
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm" placeholder="Masukkan Telefon" required>
                    </td>
                </tr>
                <tr>
                    <td width="20%" class="table-secondary">
                        <label class="required_field small">Jabatan</label>
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm" placeholder="Masukkan Jabatan" required>
                    </td>
                    <td width="20%" class="table-secondary">
                        <label class="required_field small">Tanggal Masuk Kerja</label>
                    </td>
                    <td>
                        <input type="date" class="form-control form-control-sm">
                    </td>
                </tr>
                <tr>
                    <td width="20%" class="table-secondary">
                        <label class="required_field small">HO/Cabang/Depo</label>
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm" placeholder="Masukkan Nama Salespoint" required>
                    </td>
                    <td width="20%" class="table-secondary">
                        <label class="required_field small">Golongan</label>
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm" placeholder="Masukkan Golongan" required>
                    </td>
                </tr>
                <tr>
                    <td width="20%" class="table-secondary">
                        <label class="small">Status Karyawan</label>
                    </td>
                    <td colspan="3">
                        <input type="checkbox"> Percobaan
                    </td>
                </tr>
                
                <tr>
                    <td width="20%" class="table-secondary">
                        <label class="small">Fasilitas & Perlengkapan Kerja</label>
                    </td>
                    <td colspan="3">
                        <div class="row">
                            <div class="col-6"> <input type="checkbox"> Ruangan, lokasi</div>
                            <div class="col-6"> <input type="checkbox"> Pesawat telepon</div>
                            <div class="col-6"> <input type="checkbox"> Meja & Kursi</div>
                            <div class="col-6"> <input type="checkbox"> Line & Telepon</div>
                            <div class="col-6"> <input type="checkbox"> PC / LOP</div>
                            <div class="col-6"> <input type="checkbox"> Kartu Nama</div>
                            <div class="col-6"> <input type="checkbox"> Mobil Dinas</div>
                            <div class="col-6"> <input type="checkbox"> ATK & perlengkapan kerja</div>
                            <div class="col-6"> <input type="checkbox"> Rumah Dinas</div>
                            <div class="col-6"> <input type="checkbox"> Lemari Arsip / Filling Kabinet / Whiteboard</div>
                            <div class="col-6"> <input type="checkbox"> Akses Internet</div>
                            <div class="col-6"> <input type="checkbox"> ID Card</div>
                            <div class="col-6"> <input type="checkbox"> Akses email Pinus Merah Abadi</div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="20%" class="table-secondary">
                        <label class="small">Catatan</label>
                    </td>
                    <td colspan="3">
                        <textarea class="form-control" rows="3" style="resize:none" placeholder="Tambahkan catatan (optional)"></textarea>
                    </td>
                </tr>
            </table>
            <div class="col-12">
                <small>* Jenis Fasilitas yang disiapkan adalah standar yang berdasarkan Surat keputusan Direksi mengenai Standar Kompetensi dan Benefit</small>
            </div>
            <div class="form-group">
              <label class="required_field">Pilih Otorisasi</label>
              <select class="form-control" name="" id="">
                <option></option>
                <option></option>
                <option></option>
              </select>
            </div>
            <div class="offset-6 col-6">
                <table class="table table-sm table-bordered text-center">
                    <tbody>
                        {{-- <tr>
                            <td class="align-middle small table-secondary">Menyetujui,</td>
                            <td class="align-middle small table-secondary">Pemohon,</td>
                        </tr>
                        <tr>
                            <td width="50%" class="align-bottom small" style="height: 80px">
                                _________________<br>
                                Atasan dan atasan ybs
                            </td>
                            <td width="50%" class="align-bottom small" style="height: 80px">
                                ___________<br>
                                Atasan ybs
                            </td>
                        </tr> --}}
                    </tbody>
                </table>
            </div>
        </div>
        <span>FRM-HCD-114 REV 00</span>
    </div>
</form>
{{-- @section('local-js')
<script>
$(document).ready(function () {
    console.log('this is form fasilitas');
});
</script>
@endsection --}}