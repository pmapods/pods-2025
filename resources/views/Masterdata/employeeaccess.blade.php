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
    </div>
</div>
<div class="content-body px-4">
    <div class="table-responsive">
        <table id="employeeaccessDT" class="table table-bordered table-striped dataTable" role="grid">
            <thead>
                <tr role="row">
                    <th width="5%">
                        #
                    </th>
                    <th width="10%">
                        Kode
                    </th>
                    <th>
                        Nama
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $key=>$employee)
                    <tr data-employee="{{$employee}}">
                        <td>{{$key+1}}</td>
                        <td>{{$employee->code}}</td>
                        <td>{{$employee->name}}</td>
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
