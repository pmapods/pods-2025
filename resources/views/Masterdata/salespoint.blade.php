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
                    <li class="breadcrumb-item">Masterdata</li>
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
        <table id="salespointDT" class="table table-bordered table-striped dataTable" role="grid">
            <thead>
                <tr role="row">
                    <th>
                        #
                    </th>
                    <th>
                        {{__('Kode Sales Point')}}
                    </th>
                    <th>
                        {{__('Nama Area')}}
                    </th>
                    <th>
                        {{__('Region')}}
                    </th>
                    <th>
                        {{__('Status')}}
                    </th>
                    <th>
                        {{__('GROM')}}
                    </th>
                    <th>
                        Jawa Sumatra
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($salespoints as $key => $salespoint)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$salespoint->code}}</td>
                        <td>{{$salespoint->name}}</td>
                        <td>{{$salespoint->region_name()}}</td>
                        <td>{{$salespoint->status_name()}}</td>
                        <td>{{$salespoint->grom}}</td>
                        <td>{{$salespoint->jawasumatra()}}</td>
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
        var table = $('#salespointDT').DataTable(datatable_settings);
        $('#salespointDT tbody').on('click', 'tr', function () {

        });
    })

</script>
@endsection
