@extends('Layout.app')
@section('local-css')
    <style>
        table tr, table td {
            border: 1px solid #000 !important;
        }
    </style>
@endsection

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Pembuatan PO ({{$ticket->code}})</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Operasional</li>
                    <li class="breadcrumb-item">Purchase Requisition</li>
                    <li class="breadcrumb-item active">PO ({{$ticket->code}})</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="content-body">
    <div class="border border-dark p-2">
        <h5>PR Manual Terkait</h5>
        <div class="d-flex flex-column">
            <span>PT. PINUS MERAH ABADI</span>
            <span>CABANG / DEPO : {{$ticket->salespoint->name}}</span>
            <h4 class="align-self-center font-weight-bold">PURCHASE REQUISITION (PR) -- Manual</h4>
            <div class="align-self-end">
                <i class="fal @if($ticket->budget_type==0) fa-check-square @else fa-square @endif mr-1" aria-hidden="true"></i>Budget
                <i class="fal @if($ticket->budget_type==1) fa-check-square @else fa-square @endif ml-5 mr-1" aria-hidden="true"></i>Non Budget
            </div>
            <span>Tanggal : {{now()->translatedFormat('Y-m-d')}}</span>
            <table class="table table-bordered">
                <thead class="text-center">
                    <tr>
                        <td class="font-weight-bold">No</td>
                        <td class="font-weight-bold">Nama Barang</td>
                        <td class="font-weight-bold" width='10%'>Satuan</td>
                        <td class="font-weight-bold">Qty</td>
                        <td class="font-weight-bold">Harga Satuan (Rp)</td>
                        <td class="font-weight-bold">Total Harga</td>
                        <td class="font-weight-bold">Tgl Set Up</td>
                        <td class="font-weight-bold">Keterangan</td>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($ticket->ticket_item as $key=>$item)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$item->name}}</td>
                        <td>Pcs</td>
                        <td>{{$item->count}}</td>
                        <td class="rupiah_text">{{$item->bidding->selected_vendor()->start_harga}}</td>
                        <td class="rupiah_text">{{$item->count * $item->bidding->selected_vendor()->start_harga}}</td>
                        <td>-</td>
                        <td>{{$item->bidding->price_notes}}</td>
                    </tr>
                    @php
                        $total = $item->count * $item->bidding->selected_vendor()->start_harga;
                    @endphp
                    @endforeach
                    <tr>
                        <td colspan="5"><b>Total</b></td>
                        <td class="rupiah_text">{{$total}}</td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <label for="">Otorisasi</label>
                @php
                    $authnames = ['Dibuat Oleh', 'Diperiksa Oleh', 'Diperiksa Oleh', 'Disetujui Oleh', 'Disetujui Oleh', 'Disetujui Oleh'];
                @endphp
                <div class="d-flex align-items-center justify-content-center">
                    @for ($i=0; $i<6 ;$i++)
                        <div class="mr-3">
                            <span class="font-weight-bold">Admin -- Superadmin</span><br>
                            <span>{{$authnames[$i]}}</span>
                        </div>
                        @if($i != 5)
                        <i class="fa fa-chevron-right mr-3" aria-hidden="true"></i>
                        @endif
                    @endfor
                </div>
            </div>
        </div>
    </div>
    <h4 class="mt-3">Harap Melengkapi data PO</h4>
    <div class="row">
        <div class="col-6">
            <div class="form-group">
              <label class="required_field">Nomor PR SAP</label>
              <input type="text" class="form-control" name="" id="" aria-describedby="helpId" placeholder="">
              <small id="helpId" class="form-text text-muted">Masukkan Nomor PR yang dibuat oleh SAP</small>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
              <label class="required_field">Nomor PO SAP</label>
              <input type="text" class="form-control" name="" id="" aria-describedby="helpId" placeholder="">
              <small id="helpId" class="form-text text-muted">Masukkan Nomor PO yang dibuat oleh SAP</small>
            </div>
        </div>
    </div>
    <center>
        <button type="button" class="btn btn-primary">Lengkapi Data</button>
    </center>
</div>

@endsection
@section('local-js')
<script>
</script>
@endsection
