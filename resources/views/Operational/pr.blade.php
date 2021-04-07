@extends('Layout.app')
@section('local-css')

@endsection

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Operasional</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Operasional</li>
                    <li class="breadcrumb-item active">Purchase Requisition</li>
                </ol>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-4">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addEmployeeModal">
                Tambah PR Baru
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
