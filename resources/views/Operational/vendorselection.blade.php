@extends('Layout.app')
@section('local-css')
@endsection

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Form Seleksi Vendor</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Operasional</li>
                    <li class="breadcrumb-item">Bidding</li>
                    <li class="breadcrumb-item">{{$ticket->code}}</li>
                    <li class="breadcrumb-item active">{{$ticket_item->name}}</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="content-body px-4">
    <div class="row">
        <div class="col-md-2 mt-3">Jenis Produk</div>
        <div class="col-md-4 mt-3">
            <input type="text" class="form-control" value="{{$ticket_item->name}}" readonly>
        </div>

        <div class="col-md-2 mt-3">Area / Salespoint</div>
        <div class="col-md-4 mt-3">
            <input type="text" class="form-control" value="{{$ticket->salespoint->name}}" readonly>
        </div>

        <div class="col-md-2 mt-3">Tanggal Seleksi</div>
        <div class="col-md-4 mt-3">
            <input type="text" class="form-control" value="{{now()->format('d F Y')}}" readonly>
        </div>

        <div class="col-md-2 mt-3">Kelompok</div>
        <div class="col-md-4 mt-3">
            <div class="form-group">
              <select class="form-control">
                <option>Asset</option>
                <option>Inventaris</option>
                <option>Lain-Lain</option>
              </select>
              <input type="text" class="form-control" placeholder="isi nama Kelompok Lain">
            </div>
            <div class="form-group">
            </div>
        </div>
    </div>
    <table class="table table-bordered table-success">
        <thead>
            <tr>
                <th rowspan="5" class="align-middle text-center">No</th>
                <th rowspan="5" class="align-middle text-center">Penilaian</th>
                <th rowspan="5" class="align-middle text-center">Bobot</th>
                @foreach($ticket->ticket_vendor as $vendor)
                    <th colspan="3" class="text-center">{{$vendor->name}}</th>
                @endforeach
                <th rowspan="5" class="align-middle text-center">Keterangan</th>
            </tr>
            <tr>
                @foreach($ticket->ticket_vendor as $vendor)
                    <th>Alamat</th>
                    <th colspan="2">{{$vendor->vendor()->address}}</th>
                @endforeach
            </tr>
            <tr>
                @foreach($ticket->ticket_vendor as $vendor)
                    <th>PIC</th>
                    <th colspan="2">{{$vendor->salesperson}}</th>
                @endforeach
            </tr>
            <tr>
                @foreach($ticket->ticket_vendor as $vendor)
                    <th>Telp/HP</th>
                    <th colspan="2">{{$vendor->vendor()->phone}}</th>
                @endforeach
            </tr>
            <tr>
                <th>Proposal Awal</th>
                <th>Proposal Akhir</th>
                <th>Nilai</th>
                <th>Proposal Awal</th>
                <th>Proposal Akhir</th>
                <th>Nilai</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

@endsection
@section('local-js')
<script>
</script>
@endsection
