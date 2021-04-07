@extends('Layout.app')
@section('local-css')

@endsection

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Jabatan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Masterdata</li>
                    <li class="breadcrumb-item active">Jabatan</li>
                </ol>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-4">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addEmployeeModal">
                Tambah Jabatan
            </button>
        </div>
    </div>
</div>
<div class="content-body px-4">
    <div class="table-responsive">
        <table id="employeeposDT" class="table table-bordered table-striped dataTable" role="grid">
            <thead>
                <tr role="row">
                    <th>
                        #
                    </th>
                    <th>
                        {{__('Nama Jabatan')}}
                    </th>
                    <th>
                        {{__('Jumlah Karyawan terkait jabatan')}}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>General Area Manage</td>
                    <td>5 karyawan</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>General Area Manage</td>
                    <td>5 karyawan</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>General Area Manage</td>
                    <td>5 karyawan</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
@section('local-js')
<script>
    $(document).ready(function(){
        var table = $('#employeeposDT').DataTable(datatable_settings);
        $('#employeeposDT tbody').on('click', 'tr', function () {

        });
    })
</script>
@endsection
