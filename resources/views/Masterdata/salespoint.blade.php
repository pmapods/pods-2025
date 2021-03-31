@extends('Layout.app')
@section('local-css')

@endsection

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Sales Point</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Data Master</li>
                    <li class="breadcrumb-item active">Sales Point</li>
                </ol>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-4">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addSalesPoint">
                Tambah Point
            </button>
        </div>
    </div>
</div>
<div class="content-body px-4">
    <div class="table-responsive">
        <table id="employeeDatatable" class="table table-bordered table-striped dataTable" role="grid">
            <thead>
                <tr role="row">
                    <th>
                        #
                    </th>
                    <th>
                        {{__('Nama')}}
                    </th>
                    <th>
                        {{__('Email')}}
                    </th>
                    <th>
                        {{__('Jabatan')}}
                    </th>
                    <th>
                        {{__('Status')}}
                    </th>
                </tr>
            </thead>
            <tbody>
            </tbody>
                <tr>
                    <td>1</td>
                    <td>Fahmi</td>
                    <td>fahmi@pinusmerahabadi.co.id</td>
                    <td>Manager</td>
                    <td>Aktif</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Kevin</td>
                    <td>kevin@pinusmerahabadi.co.id</td>
                    <td>Manager</td>
                    <td>Non Aktif</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
@section('local-js')

@endsection
