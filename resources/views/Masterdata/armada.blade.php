@extends('Layout.app')
@section('local-css')

@endsection

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Armada</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Masterdata</li>
                    <li class="breadcrumb-item active">Armada</li>
                </ol>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-2">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addArmadaModal">
                Tambah Armada
            </button>
        </div>
    </div>
</div>
<div class="content-body px-4">
    <div class="table-responsive">
        <table id="armadaDT" class="table table-bordered table-striped dataTable" role="grid">
            <thead>
                <tr role="row">
                    <th>
                        #
                    </th>
                    <th>
                        Salespoint
                    </th>
                    <th>
                        Jenis Kendaraan
                    </th>
                    <th>
                        Nomor Kendaaraan
                    </th>
                    <th>
                        Tipe Niaga
                    </th>
                    <th>
                        Status
                    </th>
                    <th>
                        Di Booking Oleh
                    </th>
            </thead>
            <tbody>
                @foreach ($armadas as $key=>$armada)
                    <tr data-armada="{{$armada}}">
                        <td>{{$key+1}}</td>
                        <td>{{$armada->salespoint->name}}</td>
                        <td>{{$armada->name}}</td>
                        <td class="text-uppercase">{{$armada->plate}}</td>
                        <td>{{($armada->isNiaga)?'Niaga' : 'Non Niaga'}}</td>
                        <td>{{$armada->status()}}</td>
                        <td>{{($armada->status == 1) ? $armada->booked_by : '-'}}</td>
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
        var table = $('#armadaDT').DataTable(datatable_settings);
    })
</script>
@endsection
