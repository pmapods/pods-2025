@extends('Layout.app')
@section('local-css')

@endsection

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Armada Budget</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Budget</li>
                    <li class="breadcrumb-item active">Armada Budget</li>
                </ol>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-4">
            <a href="/armadabudget/create" class="btn btn-primary">Tambah Budget Baru</a>
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
                    <th>Tanggal Permintaan</th>
                    <th>Nama Pengaju</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($budgets as $key=>$budget)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $budget->code }}</td>
                        <td>{{ $budget->salespoint->name }}</td>
                        <td>{{ $budget->created_at->format('Y-m-d') }}</td>
                        <td>{{ $budget->created_by_employee->name }}</td>
                        <td>{{ $budget->status() }}</td>
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
            var table = $('#budgetDT').DataTable(datatable_settings);
            $('#budgetDT tbody').on('click', 'tr', function () {
                let code = $(this).find('td').eq(1).text().trim();
                window.location.href="/armadabudget/"+code;
            });
        })
    </script>
@endsection
