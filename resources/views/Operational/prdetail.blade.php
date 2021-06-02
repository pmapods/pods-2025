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
                <h1 class="m-0 text-dark">PR Manual ({{$ticket->code}})</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Operasional</li>
                    <li class="breadcrumb-item">Purchase Requisition</li>
                    <li class="breadcrumb-item active">PR Manual ({{$ticket->code}})</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="content-body border border-dark p-2">
    <div class="d-flex flex-column">
        <span>PT. PINUS MERAH ABADI</span>
        <span>CABANG / DEPO : {{$ticket->salespoint->name}}</span>
        <h4 class="align-self-center font-weight-bold">PURCHASE REQUISITION (PR) - MANUAL</h4>
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
                    <td>
                        {{$item->name}}<br>
                        <div class="text-info">
                            Ongkos Kirim<br>
                            Ongkos Pasang
                        </div>
                    </td>
                    <td><input type="text" class="form-control"></td>
                    <td>{{$item->count}}</td>
                    @php
                        $total =0;
                        $total += $item->bidding->selected_vendor()->end_harga;
                        $total += $item->bidding->selected_vendor()->end_ppn;
                        $total += $item->bidding->selected_vendor()->end_ongkir_price;
                        $total += $item->bidding->selected_vendor()->end_pasang_price;
                    @endphp
                    <td>
                        <input type="text" class="form-control rupiah" name="" id="" aria-describedby="helpId" placeholder="" value="{{$item->bidding->selected_vendor()->end_harga}}"><br>
                        <span class="rupiah_text text-info">{{$item->bidding->selected_vendor()->end_ongkir_price}}</span><br>
                        <span class="rupiah_text text-info">{{$item->bidding->selected_vendor()->end_pasang_price}}</span>
                    </td>
                    <td class="rupiah_text">
                        {{$total}}
                    </td>
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
            <label for="">Pilih Otorisasi</label>
            <select class="form-control">
                    <option value="">Pilih Otorisasi</option>
                    <option>Kevin -> Fahmi -> Yohan -> Wiwik Wijaya -> James Arthur -> Wiwik Wijaya -> CM</option>
                    <option>Kevin -> Fahmi -> Yohan -> Wiwik Wijaya -> James Arthur -> Wiwik Wijaya</option>
            </select>
        </div>
        <center>
            <button type="button" class="btn btn-primary">Mulai Otorisasi Form Bidding</button>
            <button type="button" class="btn btn-primary">Cetak PR</button>
        </center>
    
</div>

@endsection
@section('local-js')
<script>
</script>
@endsection
