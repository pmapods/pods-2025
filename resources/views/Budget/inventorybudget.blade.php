@extends('Layout.app')
@section('local-css')

@endsection

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Inventory Budget</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Budget</li>
                    <li class="breadcrumb-item active">Inventory Budget</li>
                </ol>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-4">
            <a href="/addinventorybudget" class="btn btn-primary">Tambah Budget Baru</a>
        </div>
    </div>
</div>
<div class="content-body px-4">
    <div class="table-responsive">
        <table id="budgetDT" class="table table-bordered table-striped dataTable" role="grid">
            <thead>
                <tr role="row">
                    <th>#</th>
                    <th>Kode Upload</th>
                    <th>Nama Salespoint</th>
                    <th>Tipe Budgeting</th>
                    <th>Tanggal Permintaan</th>
                    <th>Nama Pengaju</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

@endsection
@section('local-js')
    <script>
        $(document).ready(function(){
            var table = $('#budgetDT').DataTable(datatable_settings);
            $('#budgetDT tbody').on('click', 'tr', function () {
                let code = $(this).find('td').eq(1).text().trim();
                window.location.href="/bidding/"+code;
            });
        })
    </script>
@endsection
