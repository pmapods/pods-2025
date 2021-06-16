<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    {{-- <link rel="stylesheet" href="{{public_path('css/pdfstyles.css')}}"> --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <style>
        .small {
            font-size: 10px;
        }
        .title{
            font-size: 20px !important;
        }
        .address{
            font-weight: bold;
            border-bottom: 1px solid;
            width: 200px;
        }
        .purchase_order{
            border: 1px solid black;
            font-size: 13px !important;
        }
        .purchase_order .title{
            font-size: 20px !important;
            font-weight: bold;
            color: white;
            background-color: black;
            padding: 0.2em;
        }
        .purchase_order .body{
            padding: 1em;
        }
        .vendor_address{
            height: 120px;
            font-size: 12px !important;
        }
        .kami_memesan_text{
            border-bottom: 1px solid black;
            width: 220 px;
        }
        .item_table{
            width: 100%;
            border: 1px solid black;
            padding-bottom: 2em;
        }
        .item_table thead{
            background-color:#DFD9DB;
        }
        .item_table thead th{
            padding: 1px 0px;
        }
        .item_table tbody td{
            padding: 15px 0;
        }
        .vcenter {
            vertical-align: top;
            float: none;
        }
        footer{     
            font-size: 12px;
            margin-top: 50px;
        }
        .sign_box{
            border: 1px solid black;
        }
        .sign_box .header{
            border-bottom: 1px solid black;
        }
        .sign_space {
            height: 100px !important
        }
        #watermark {
            position: absolute;
            left: 25%;
            top: 35%;
            z-index: -1000;

            font-size: 100px;
            font-weight: bold;
            transform: rotate(-30deg);
            letter-spacing: 20px;
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
    <div id="watermark">
        <span style="color: rgba(65, 65, 65, 0.329)">ASLI</span>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <img src="{{public_path('assets/logo.png')}}" width="40px">
            <span class="title">PT. Pinus Merah Abadi</span><br>
            <div class="address small">Jl. Soekarno Hatta 112<br>Babakan Ciparay, Babakan Ciparay<br>Bandung 40233 - Jawa Barat</div>
            <div class="vendor_address">
                <b>Kepada Yth / To :</b><br>
                {{$po->ticket_vendor->name}}<br>
                {{$po->vendor_address}}
            </div>
            <div class="kami_memesan_text small">Kami memesan barang / produk sebagai berikut</div>
            <div class="small"><i>We would like to confirm our order as follows</i></div>
        </div>
        <div class="col-xs-5">
            <div class="purchase_order">
                <div class="title">Purchase Order</div>
                <div class="body">
                    <table>
                        <tbody>
                            <tr>
                                <td>No Purchase Order</td>
                                <td>&nbsp;:{{$po->no_po_sap}}</td>
                            </tr>
                            <tr>
                                <td>Tanggal / Date</td>
                                <td>&nbsp;:{{$po->created_at->format('d.m.Y')}}</td>
                            </tr>
                            <tr>
                                <td>Ref. PR No.</td>
                                <td>&nbsp;:{{$po->no_pr_sap}}</td>
                            </tr>
                            <tr>
                                <td>Pembayaran / Payment</td>
                                <td>&nbsp;:{{$po->payment_days}} Hari / Days</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="small" style="margin-top: 1em">Alamat kirim / Delivery Address</div>
            <div>
                {{$po->ticket_vendor->name}}<br>
                {{$po->send_address}}
                @if($po->ticket_vendor->vendor() != null)
                <br>
                ({{$po->ticket_vendor->vendor()->regency->name}})
                @endif
            </div>
        </div>
    </div>
    
    <table class="item_table" style="margin-top: 2em">
        <thead>
            <tr>
                <th rowspan="2">&nbsp; No.</td>
                <th>Deskripsi Barang</td>
                <th>Jumlah</td>
                <th>Harga/ Unit</td>
                <th class="text-right">Jumlah</td>
                <th class="text-center">Tgl kirim</td>
            </tr>
            <tr>
                <th><i>Description of Goods</i></td>
                <th><i>Quantity</i></td>
                <th><i>Unit Price</i></td>
                <th class="text-right"><i>Amount</i></td>
                <th class="text-center"><i>Delivery Date</i></td>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach ($po->ticket_vendor->selected_items() as $key => $item)
                <tr>
                    <td>&nbsp; {{$key+1}}</td>
                    <td>{{$item->ticket_item->name}}</td>
                    <td>{{$item->qty}} {{($item->ticket_item->budget_pricing->uom ?? '')}}</td>
                    <td class="rupiah_text">{{setRupiah($item->price)}}</td>
                    <td class="rupiah_text text-right">{{setRupiah($item->qty*$item->price)}}</td>
                    <td class="text-center">-</td>
                    @php $total += $item->qty*$item->price; @endphp
                </tr>
                @if($item->ongkir > 0)
                    <tr>
                        <td></td>
                        <td>Ongkos kirim {{$item->ticket_item->name}}</td>
                        <td>1</td>
                        <td class="rupiah_text">{{setRupiah($item->ongkir)}}</td>
                        <td class="rupiah_text text-right">{{setRupiah($item->ongkir)}}</td>
                        <td class="text-center">-</td>
                        @php $total += $item->ongkir; @endphp
                    </tr>
                @endif
                @if($item->ongpas > 0)
                    <tr>
                        <td></td>
                        <td>Ongkos Pasang {{$item->ticket_item->name}}</td>
                        <td>1</td>
                        <td class="rupiah_text">{{setRupiah($item->ongpas)}}</td>
                        <td class="rupiah_text text-right">{{setRupiah($item->ongpas)}}</td>
                        <td class="text-center">-</td>
                        @php $total += $item->ongpas; @endphp
                    </tr>
                @endif
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3"></td>
                <td>Subtotal</td>
                <td class="text-right">{{setRupiah($total)}}</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td style="border-bottom: 1px solid #000"><b>Jumlah Total</b></td>
                <td class="text-right"><b>{{setRupiah($total)}}</b></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td><i>Total Amount</i></td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
    </table>
    <div class="row">
        <div class="col-xs-11 footer_notes">
            <b>PASTIKAN UNTUK SELALU MEMINTA LPD PADA SAAT MELAKUKAN PENGIRIMAN/SELESAI MELAKUKAN JASA.</b><br>
            <u>Mohon PO ini diemailkan kembali setelah konfirmasi</u><br>
            <i>Please return this PO by email after signing</i><br>
            <u>Catatan</u><br>
            <i>{{$po->notes}}</i>
        </div>
    </div>
    <footer class="row">
        @php
            $names = ["Dibuat Oleh","Diperiksa dan disetujui oleh","Konfirmasi Supplier"];
            $enames = ["Created by","Checked and Approval by","Supplier Confirmation"];
            $po_authorizations = $po->po_authorization;
            $authorizations =[];
            foreach ($po_authorizations as $po_authorization){
                $auth = new \stdClass();
                $auth->employee_name = $po_authorization->employee_name;
                $auth->employee_position = $po_authorization->employee_position;
                array_push($authorizations,$auth);
            }
            $auth = new \stdClass();
            $auth->employee_name = $po->supplier_pic_name;
            $auth->employee_position = $po->supplier_pic_position;
            array_push($authorizations,$auth);
        @endphp
        @foreach($authorizations as $key=>$authorization)
            <div class="col-xs-3 @if($key != 0) col-xs-offset-1 @endif" style="padding: 1em 0em;">
                <div class="sign_box">
                    <div class="text-center header">
                        {{$names[$key]}}<br>
                        <i>{{$enames[$key]}}</i>
                    </div>
                    <div class="sign_space"></div>
                    <div class="text-center text-uppercase small">{{$authorization->employee_name}}</div>
                    <div class="text-center">{{$authorization->employee_position}}</div>
                </div>
            </div>
        @endforeach
    </footer>
</body>
</html>
