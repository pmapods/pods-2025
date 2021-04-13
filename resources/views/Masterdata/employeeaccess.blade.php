@extends('Layout.app')
@section('local-css')

@endsection

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Akses Karyawan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Masterdata</li>
                    <li class="breadcrumb-item active">Akses Karyawan</li>
                </ol>
            </div>
        </div>
        <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <strong>Pilih karyawan untuk memberikan hak akses area</strong>
        </div>
    </div>
</div>
<div class="content-body px-4">
    <div class="table-responsive">
        <table id="employeeaccessDT" class="table table-bordered table-striped dataTable" role="grid">
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
                        Jabatan
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $key=>$employee)
                    <tr data-employee="{{$employee}}">
                        <td>{{$key+1}}</td>
                        <td>{{$employee->code}}</td>
                        <td>{{$employee->name}}</td>
                        <td>{{$employee->employee_position->name}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
@section('local-js')
<script>
    $(document).ready(function(){
        var table = $('#employeeaccessDT').DataTable(datatable_settings);
        $('#employeeaccessDT tbody').on('click', 'tr', function () {
            let data = $(this).data('employee');
            window.location.href ='/employeeaccess/'+data['code']+'/';
        });
    })
</script>
@endsection
