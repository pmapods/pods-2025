@extends('Layout.app')
@section('local-css')

@endsection

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Matriks Otorisasi</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Masterdata</li>
                    <li class="breadcrumb-item active">Matriks Otorisasi</li>
                </ol>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-2">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addAuthorModal">
                Tambah Otorisasi Baru
            </button>
        </div>
    </div>
</div>
<div class="content-body px-4">
    <div class="table-responsive">
        <table id="authorDT" class="table table-bordered table-striped dataTable" role="grid">
            <thead>
                <tr>
                    <td>Kode</td>
                    <td>Area</td>
                    <td>Orang Pertama</td>
                    <td>Jenis Form</td>
                    <td>Tanggal Dibuat</td>
                    <td>Tingkat</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Auth-0001</td>
                    <td>Palangkaraya (HO)</td>
                    <td>Kevin - Staff</td>
                    <td>Form Pengadaan</td>
                    <td>20 Februari 2020</td>
                    <td>3 Tingkat</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addAuthorModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Otorisasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="">SalesPoint</label>
                          <select class="form-control" name="salespoint_code" required>
                            <option value="">-- Pilih SalesPoint --</option>
                          </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Jenis Form</label>
                          <select class="form-control" name="form_type" required>
                            <option value="">-- Pilih Jenis Form --</option>
                            <option value="0">Form Pengadaan</option>
                          </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>Sebagai</th>
                                    <th>Level</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center" colspan="5">Tingkat belum dipilih</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                          <label for="">Pilih Karyawan</label>
                          <select class="form-control select2">
                          </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                          <label for="">Sebagai</label>
                          <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                          <label for="">&nbsp</label>
                          <button type="button" class="btn btn-primary form-control">Tambah</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary">Tambah</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('local-js')
<script>
    $(document).ready(function(){
        var table = $('#authorDT').DataTable(datatable_settings);
        $('#authorDT tbody').on('click', 'tr', function () {
            
        });

    })
</script>
@endsection
