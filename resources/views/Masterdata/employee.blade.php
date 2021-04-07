@extends('Layout.app')
@section('local-css')

@endsection

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Karyawan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Masterdata</li>
                    <li class="breadcrumb-item active">Karyawan</li>
                </ol>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-4">
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#switchEmployeeModal">
                Pindah Karyawan
            </button>
            <button type="button" class="btn btn-primary ml-2" data-toggle="modal" data-target="#addEmployeeModal">
                Tambah Karyawan
            </button>
        </div>
    </div>
</div>
<div class="content-body px-4">
    <div class="table-responsive">
        <table id="employeeDT" class="table table-bordered table-striped dataTable" role="grid">
            <thead>
                <tr role="row">
                    <th>
                        #
                    </th>
                    <th>
                        Kode
                    </th>
                    <th>
                        Nama
                    </th>
                    <th>
                        Email
                    </th>
                    <th>
                        Jabatan
                    </th>
                    <th>
                        Status
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>EMP-00001</td>
                    <td>Fahmi</td>
                    <td>fahmi@pinusmerahabadi.co.id</td>
                    <td>Manager</td>
                    <td>Aktif</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>EMP-00001</td>
                    <td>Fahmi</td>
                    <td>fahmi@pinusmerahabadi.co.id</td>
                    <td>Manager</td>
                    <td>Aktif</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Karyawan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                          <label for="">Nama Karyawan</label>
                          <input type="text" class="form-control" name="name" aria-describedby="helpId" placeholder="Masukkan nama karyawan" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                          <label for="">Pilih Jabatan</label>
                          <select class="form-control select2" name="position">
                            <option value="">-- Pilih Jabatan --</option>
                            @for ($i = 0; $i < 5; $i++)
                                <option value="{{$i}}">Jabatan - {{$i}}</option>
                            @endfor
                          </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                          <label for="">Email Karyawan</label>
                          <input type="email" class="form-control" name="email" aria-describedby="helpId" placeholder="Masukkan nama karyawan" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                          <label for="">Kata Sandi</label>
                          <input type="password" class="form-control" value="12345678" name="password" aria-describedby="helpId" placeholder="Masukkan nama karyawan" required>
                          <small class="helpId text-danger">* karyawan akan melakukan pergantian password saat pertama kali melakukan login. Kata sandi ini merupakan kata sandi untuk pertama kali / sementara</small>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                          <label for="">Konfirmasi Kata Sandi</label>
                          <input type="password" class="form-control" value="12345678" name="password" aria-describedby="helpId" placeholder="Masukkan nama karyawan" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Tambah Karyawan</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Perbarui Karyawan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                          <label for="">Nama Karyawan</label>
                          <input type="text" class="form-control" value="Kevin" name="name" aria-describedby="helpId" placeholder="Masukkan nama karyawan" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                          <label for="">Pilih Jabatan</label>
                          <select class="form-control select2" name="position">
                            <option value="">-- Pilih Jabatan --</option>
                            @for ($i = 0; $i < 5; $i++)
                                <option value="{{$i}}" @if($i == 0) selected @endif>Jabatan - {{$i}}</option>
                            @endfor
                          </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                          <label for="">Email Karyawan</label>
                          <input type="email" class="form-control" name="email" aria-describedby="helpId" placeholder="Masukkan nama karyawan" disabled>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-danger">Non Aktifkan</button>
                <button type="button" class="btn btn-success">Aktifkan</button>
                <button type="submit" class="btn btn-info">Perbarui</button>
            </div>
        </div>
    </div>
</div>

{{-- new Employee Assign --}}
<div class="modal fade" id="switchEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pindah Karyawan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <div class="form-group">
                            <label for="">Pilih Email Karyawan Lama</label>
                            <select class="form-control select2" name="old_employee" required>
                                <option value="">-- Pilih karyawan --</option>
                                @for ($i = 0; $i < 10; $i++)
                                    <option value="{{$i}}">Karyawan{{$i}}@gmail.com - Jabatan {{$i}}</option>
                                @endfor
                            </select>
                            <small class="text-danger">*PERHATIAN -- email karyawan lama yang dipilih tidak akan mendapatkan akses ke PMA Purchasing. Semua tugas akan dipindah ke akun baru.</small>
                          </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                          <label for="">Nama Karyawan</label>
                          <input type="text" class="form-control" name="name" aria-describedby="helpId" placeholder="Masukkan nama karyawan" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                          <label for="">Email Karyawan</label>
                          <input type="email" class="form-control" name="email" aria-describedby="helpId" placeholder="Masukkan email karyawan" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                          <label for="">Kata Sandi</label>
                          <input type="password" class="form-control" value="12345678" name="password" aria-describedby="helpId" placeholder="Masukkan nama karyawan" required>
                          <small class="helpId text-danger">* karyawan akan melakukan pergantian password saat pertama kali melakukan login. Kata sandi ini merupakan kata sandi untuk pertama kali / sementara</small>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                          <label for="">Konfirmasi Kata Sandi</label>
                          <input type="password" class="form-control" value="12345678" name="password" aria-describedby="helpId" placeholder="Masukkan nama karyawan" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Pindah Karyawan</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('local-js')
<script>
    $(document).ready(function(){
        var table = $('#employeeDT').DataTable(datatable_settings);
        $('#employeeDT tbody').on('click', 'tr', function () {

        });
    })
</script>
@endsection
