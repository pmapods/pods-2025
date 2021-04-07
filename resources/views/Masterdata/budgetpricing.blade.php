@extends('Layout.app')
@section('local-css')

@endsection

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Budget Pricing</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Masterdata</li>
                    <li class="breadcrumb-item active">Budget Pricing</li>
                </ol>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-2">
            {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addBudgetModal">
                Lihat Kategori Budget
            </button> --}}
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addBudgetModal">
                Tambah Budget Pricing
            </button>
        </div>
    </div>
</div>
<div class="content-body px-4">
    <div class="table-responsive">
        <table id="budgetDT" class="table table-bordered table-striped dataTable" role="grid">
            <thead>
                <tr>
                    <th rowspan="2">
                        #
                    </th>
                    <th rowspan="2">
                        Kode
                    </th>
                    <th rowspan="2">
                        Nama
                    </th>
                    <th rowspan="2">
                        Kategori
                    </th>
                    <th rowspan="2">
                        Brand / Merk
                    </th>
                    <th rowspan="2">
                        Tipe
                    </th>
                    <th colspan="2">
                        Range Jawa Sumatra
                    </th>
                    <th colspan="2">
                        Range Luar Jawa Sumatra
                    </th>
                </tr>
                <tr>
                    <th>Min</th>
                    <th>Max</th>
                    <th>Min</th>
                    <th>Max</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($budgets as $key => $budget)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$budget->code}}</td>
                        <td>{{$budget->name}}</td>
                        <td>{{$budget->budget_pricing_category->name}}</td>
                        <td>{{$budget->brand}}</td>
                        <td>{{$budget->type}}</td>
                        @if ($budget->injs_min_price !=null)
                            <td class="rupiah">{{$budget->injs_min_price}}</td>
                        @else
                            <td>-</td>
                        @endif
                        <td class="rupiah">{{$budget->injs_max_price}}</td>
                        @if ($budget->outjs_min_price !=null)
                            <td class="rupiah">{{$budget->outjs_min_price}}</td>
                        @else
                            <td>-</td>
                        @endif
                        <td class="rupiah">{{$budget->outjs_max_price}}</td>
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

        });
    })
</script>
@endsection
