<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    {{-- <link rel="stylesheet" href="{{public_path('css/pdfstyles.css')}}"> --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <link rel="stylesheet" href="/fontawesome/css/all.min.css">
    <style>
        .item_table{
            width: 100%;
        }
        .check_box{
            width: 100px;
            height: 100px;
            border: 2px solid black;
            font-size: 20px;
        }
        .check_box_text{
            padding-right: 50px !important;
        }
        .sign_space{
            height: 85px !important
        }
    </style>
</head>
@php
    function setRupiah($amount) {
        $isNegative = false;
        if(floatval($amount) < 0) {
            $isNegative = true;
            $amount *= -1;
        }
        $reversed = str_split(strrev(strval(intval($amount))));
        $ctr = 0;
        $addedDots = "";
        foreach($reversed as $i=>$r) {
            $addedDots = $addedDots.$r;

            if(($i+1)%3==0 && $i < count($reversed)-1) {
                $addedDots = $addedDots.'.';
            }
        }
        $addedDots = strrev($addedDots);
        $floatAmount = round($amount-intval($amount), 2);
        $finalString = "";
        if($isNegative) {
            $finalString = $finalString."- ";
        }
        if($floatAmount == 0) {
            $finalString = $finalString . "Rp " . $addedDots . ",00";
        }
        else {
            $float_part = str_split(number_format($floatAmount, 2));
            $finalString = $finalString . "Rp " . $addedDots . ",".$float_part[2].$float_part[3];
        }
        return $finalString;
    }
@endphp
<body>
    <div>PT. PINUS MERAH ABADI</div>
    @isset ($ticket)
    <div>Cabang / Depo : {{$ticket->salespoint->name}}</div>
    @endisset
    @isset ($armadaticket)
    <div>Cabang / Depo : {{$armadaticket->salespoint->name}}</div>
    @endisset
    <center>
        <div style="font-weight: bold; font-size: 20px">PURCHASE REQUISITION (PR) - MANUAL</div>
    </center>
    <div style="float:right">
        @isset ($ticket)
        <input type="checkbox" style="margin-top:5px" @if($ticket->budget_type==0) checked="checked" @endif> Budget
        <input type="checkbox" style="margin-left: 15px; margin-top:5px" @if($ticket->budget_type==1) checked="checked" @endif> Non Budget
        @endisset
        @isset ($armadaticket)
        <input type="checkbox" style="margin-top:5px" checked="checked"> Budget
        <input type="checkbox" style="margin-left: 15px; margin-top:5px"> Non Budget
        @endisset
    </div>
    
    <table class="table table-bordered item_table" style="margin-top: 3em !important">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Barang</th>
                <th>Satuan</th>
                <th>Qty</th>
                <th>Harga Satuan (Rp)</th>
                <th>Total Harga</th>
                <th>Tgl. Set Up</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pr->pr_detail as $key => $pr_detail)
            @isset ($ticket)   
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$pr_detail->ticket_item->name}}</td>
                <td>{{$pr_detail->uom}}</td>
                <td>{{$pr_detail->qty}}</td>
                <td>{{setRupiah($pr_detail->price)}}</td>
                <td>{{setRupiah($pr_detail->price * $pr_detail->qty)}}</td>
                <td>{{$pr_detail->setup_date ?? '-'}}</td>
                <td>
                    @if($pr_detail->ticket_item->bidding->price_notes && $pr_detail->ticket_item->bidding->price_notes != '-')
                    <b>notes bidding harga</b><br>
                    <span>{{$pr_detail->ticket_item->bidding->price_notes}}</span><br>
                    @endif
                    @if($pr_detail->ticket_item->bidding->ketersediaan_barang_notes && $pr_detail->ticket_item->bidding->ketersediaan_barang_notes != '-')
                    <b>notes keterangan barang</b><br>
                    <span>{{$pr_detail->ticket_item->bidding->ketersediaan_barang_notes}}</span><br>
                    @endif
                    @if($pr_detail->notes && $pr_detail->notes != '-')
                    <b>Keterangan</b><br>
                    <span>{{$pr_detail->notes ?? '-'}}</span><br>
                    @endif
                    @isset($pr_detail->asset_number)
                        <b>Nomor Asset</b><br>
                        <span>{{$pr_detail->asset_number}}</span>
                    @endisset
                </td>
            </tr>
            @endisset
            @isset ($armadaticket)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$pr_detail->name}}</td>
                <td>{{$pr_detail->uom}}</td>
                <td>{{$pr_detail->qty}}</td>
                <td>-</td>
                <td>-</td>
                <td>{{$pr_detail->setup_date ?? '-'}}</td>
                <td width="20%" class="d-flex flex-column">
                    <span>{{ $pr_detail->notes }}</span>
                </td>
            </tr>   
            @endisset
            @endforeach
        </tbody>
    </table>

    <table style="width: 100%">
        <tbody>
            <tr>
                <td style="width:20%; font-size: 10px">
                    <b>* Matrix Otorisasi (Disetujui) oleh:</b><br>
                    <span>1. Budget : NFAM, Head of Ops</span><br>
                    <span>12. Non Budget : NFAM, Head of Ops, CM</span>
                </td>
                <td>
                    <table class="table table-bordered text-center  " style="font-size: 10px; font-weight: bold">
                        <tr>
                            <td>Dibuat oleh,</td>
                            <td colspan="2">Diperiksa oleh,</td>
                            <td colspan="3">Disetujui oleh,</td>
                        </tr>
                        <tr>
                            @foreach ($authorizations as $authorization)
                                <td style="width: 16.5%" class="sign_space text-center">
                                    <b class="text-success">Approved</b><br>
                                    {{$authorization->date}}<br>
                                    <span class="font-weight-bold">{{$authorization->name}}</span>
                                </td>
                            @endforeach
                            @for ($i = 0; $i < 6-count($authorizations); $i++)
                                <td style="width: 16.5%" class="sign_space"></td>
                            @endfor
                        </tr>
                        <tr>
                            <td>User (Min Gol 5A)</td>
                            <td>Atasan berikutnya / RBM</td>
                            <td>NOM</td>
                            <td>NFAM</td>
                            <td>Head Of Ops</td>
                            <td>CM</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <span>FRM-PCD-011 REV 01</span>
</body>
</html>
