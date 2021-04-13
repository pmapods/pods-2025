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
            {{-- <button type="button" class="btn btn-info" data-toggle="modal" data-target="#switchEmployeeModal">
                Pindah Karyawan
            </button> --}}
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
                        Username
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
                @foreach ($employees as $key => $employee)
                    <tr data-employee="{{$employee}}">
                        <td>{{$key+1}}</td>
                        <td>{{$employee->code}}</td>
                        <td>{{$employee->name}}</td>
                        <td>{{$employee->username}}</td>
                        <td>{{$employee->email}}</td>
                        <td>{{$employee->employee_position->name}}</td>
                        <td>{{$employee->statusName()}}</td>
                    </tr> 
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addEmployeeModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="/addEmployee" method="post" id="addemployeeform">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Karyawan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                              <label for="">Nama Karyawan</label>
                              <input type="text" class="form-control" name="name" placeholder="Masukkan nama karyawan" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                              <label for="">Pilih Jabatan</label>
                              <select class="form-control select2" name="position" required>
                                <option value="">-- Pilih Jabatan --</option>
                                @foreach ($positions as $position)
                                    <option value="{{ $position->id }}">{{$position->name }}</option>
                                @endforeach
                              </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                            <label for="">Nomor Telfon (optional)</label>
                            <input type="text" class="form-control" name="phone" placeholder="ex 08xxxxxxxxxx">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                              <label for="">Email Karyawan</label>
                              <input type="email" class="form-control" name="email" placeholder="Masukkan nama karyawan" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                              <label for="">username</label>
                              <input type="text" class="form-control" name="username" placeholder="Masukkan username (ex: userhobandung1)" required>
                              <small class="text-info">username dan email bersifat unik dan dapat digunakan untuk melakukan login. <b>Usename dan Email tidak dapat diubah setelah dibuat !</b></small>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                              <label for="">Kata Sandi</label>
                              <input type="password" class="form-control" oninput="validatepassword()" value="12345678" name="password" placeholder="Masukkan kata sandi" id="password" required>
                              <small class="text-danger">* karyawan akan melakukan pergantian password saat pertama kali melakukan login. Kata sandi ini merupakan kata sandi untuk pertama kali / sementara</small>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                              <label for="">Konfirmasi Kata Sandi</label>
                              <input type="password" class="form-control" oninput="validatepassword()" value="12345678" id="confirmpassword" name="conf_password" placeholder="Konfirmasi Kata sandi" required>
                              <small class="text-danger d-none" id="confpassworderror">konfirmasi kata sandi tidak sesuai</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Tambah Karyawan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editEmployeeModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="/updateEmployee" method="post" id="updateemployeeform">
            @csrf
            @method('patch')
            <input type="hidden" name="employee_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Karyawan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                              <label for="">Nama Karyawan</label>
                              <input type="text" class="form-control" name="name" placeholder="Masukkan nama karyawan" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                              <label for="">Pilih Jabatan</label>
                              <select class="form-control select2" name="position" required>
                                <option value="">-- Pilih Jabatan --</option>
                                @foreach ($positions as $position)
                                    <option value="{{ $position->id }}">{{$position->name }}</option>
                                @endforeach
                              </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                            <label for="">Nomor Telfon (optional)</label>
                            <input type="text" class="form-control" name="phone" placeholder="ex 08xxxxxxxxxx">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                              <label for="">Email Karyawan</label>
                              <input type="email" class="form-control" name="email" placeholder="Masukkan nama karyawan" readonly>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                              <label for="">username</label>
                              <input type="text" class="form-control" name="username" placeholder="Masukkan username (ex: userhobandung1)" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    {{-- <button type="submit" class="btn btn-danger" onclick="nonactive()">Delete</button> --}}
                    <button type="submit" class="btn btn-danger nonactive-button" onclick="nonactive()">Non Aktifkan</button>
                    <button type="submit" class="btn btn-success active-button" onclick="active()">Aktifkan</button>
                    <button type="submit" class="btn btn-info">Update Karyawan</button>
                </div>
            </div>
        </form>
        <form action="/nonactiveemployee" method="post" id="nonactiveform">
            @csrf
            @method('patch')
            <input type="hidden" name="employee_id">
        </form>
        <form action="/activeemployee" method="post" id="activeform">
            @csrf
            @method('patch')
            <input type="hidden" name="employee_id">
        </form>
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
            let modal = $("#editEmployeeModal");
            let data = $(this).data('employee');
            modal.find('input[name="employee_id"]').val(data['id']);
            modal.find('input[name="name"]').val(data['name']);
            modal.find('select[name="position"]').val(data['employee_position_id']);
            modal.find('select[name="position"]').trigger('change');
            modal.find('input[name="phone"]').val(data['phone']);
            modal.find('input[name="email"]').val(data['email']);
            modal.find('input[name="username"]').val(data['username']);
            if(data['status'] == 0){
                modal.find('.active-button').hide();
                modal.find('.nonactive-button').show();
            }else{
                modal.find('.active-button').show();
                modal.find('.nonactive-button').hide();
            }
            modal.modal('show');
        });
    })
    function validatepassword(){
        let password = $('#password').val();
        let confirmpassword = $('#confirmpassword').val();
        let message = $('#confpassworderror')
        if(password != confirmpassword){
            message.removeClass('d-none');
            console.log('not same')
        }else{
            message.addClass('d-none');
            console.log('same')
        }
    }
    
    function nonactive(){
        if (confirm('Karyawan yang di non aktifkan tidak dapat login. Lanjutkan?')) {
            $('#nonactiveform').submit();
        }
    }
    function active(){
        if (confirm('Karyawan akan diaktifkan kembali. Lanjutkan?')) {
            $('#activeform').submit();
        }
    }
</script>
@endsection
