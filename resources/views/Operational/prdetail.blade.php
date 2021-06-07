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
                    <td class="font-weight-bold" width="15%">Nama Barang</td>
                    <td class="font-weight-bold" width='10%'>Satuan</td>
                    <td class="font-weight-bold" width="8%">Qty</td>
                    <td class="font-weight-bold">Harga Satuan (Rp)</td>
                    <td class="font-weight-bold" width="10%">Total Harga</td>
                    <td class="font-weight-bold">Tgl Set Up</td>
                    <td class="font-weight-bold">Keterangan</td>
                </tr>
            </thead>
            <tbody class="text-center">
                @php $grandtotal=0; @endphp
                @foreach ($ticket->ticket_item as $key=>$item)
                <tr>
                    <td rowspan="3">{{$key+1}}</td>
                    <td>
                        {{$item->name}}
                    </td>
                    <td rowspan="3">{{$item->budget_pricing->uom}}</td>
                    <td rowspan="3">
                        <input type="number" class="form-control nilai qty item{{$key}}" min="0" max="{{$item->count}}" 
                        value="{{$item->count}}"
                        onchange="refreshItemTotal(this)">
                    </td>
                    @php
                        $total = 0;
                        $total += $item->bidding->selected_vendor()->end_harga * $item->count;
                        $total += $item->bidding->selected_vendor()->end_ongkir_price;
                        $total += $item->bidding->selected_vendor()->end_pasang_price;
                    @endphp
                    <td>
                        <input type="text" class="form-control rupiah item{{$key}}" 
                        data-max="{{$item->bidding->selected_vendor()->end_harga}}" 
                        value="{{$item->bidding->selected_vendor()->end_harga}}"
                        onchange="refreshItemTotal(this)">
                    </td>
                    <td rowspan="3" class="rupiah_text item{{$key}} total" data-total="{{$total}}">
                        {{$total}}
                    </td>
                    <td rowspan="3">
                        <input class="form-control" type="date">
                    </td>
                    <td rowspan="3">notes bidding harga : {{$item->bidding->price_notes}}</td>
                </tr>
                <tr>
                    <td>Ongkos Kirim</td>
                    <td>
                        <input type="text" class="form-control rupiah item{{$key}}" 
                        data-max="{{$item->bidding->selected_vendor()->end_ongkir_price}}" 
                        value="{{$item->bidding->selected_vendor()->end_ongkir_price}}"
                        onchange="refreshItemTotal(this)">
                    </td>
                </tr>
                <tr>
                    <td>Ongkos Pasang</td>
                    <td>
                        <input type="text" class="form-control rupiah item{{$key}}" 
                        data-max="{{$item->bidding->selected_vendor()->end_pasang_price}}" 
                        value="{{$item->bidding->selected_vendor()->end_pasang_price}}"
                        onchange="refreshItemTotal(this)">
                    </td>
                </tr>
                @php
                    $grandtotal += $total;
                @endphp
                @endforeach
                <tr>
                    <td colspan="5"><b>Total</b></td>
                    <td class="rupiah_text grandtotal" data-grandtotal="{{$grandtotal}}">{{$grandtotal}}</td>
                    <td colspan="2"></td>
                </tr>
            </tbody>
        </table>
        <div class="form-group">
            <label for="">Pilih Otorisasi</label>
            <select class="form-control select2">
                    <option value="">Pilih Otorisasi</option>
                    <option>Kevin -> Fahmi -> Yohan -> Wiwik Wijaya -> James Arthur -> Wiwik Wijaya -> CM</option>
                    <option>Kevin -> Fahmi -> Yohan -> Wiwik Wijaya -> James Arthur -> Wiwik Wijaya</option>
            </select>
        </div>
        <center><h4>Otorisasi</h4><center>
            @php
                $default_as = ['Dibuat Oleh', 'Diperiksa Oleh'];
                $collection = $ticket->ticket_authorization->slice(1)->all();
                $values = collect($collection)->values();
            @endphp
        <div class="d-flex align-items-center justify-content-center">
            @foreach ($values->all() as $key =>$author)
                <div class="mr-3">
                    <span class="font-weight-bold">{{$author->employee->name}} -- {{$author->employee->employee_position->name}}</span><br>
                    <span>{{$default_as[$key]}}</span>
                </div>
                @if($key < $values->count()-1)
                <i class="fa fa-chevron-right mr-3" aria-hidden="true"></i>
                @endif
            @endforeach
        </div>
        <center class="mt-3">
            <button type="button" class="btn btn-primary">Mulai Otorisasi Form Bidding</button>
            <button type="button" class="btn btn-primary">Cetak PR</button>
        </center>
    
</div>

@endsection
@section('local-js')
<script>
    $(document).ready(function(){
        $('input[type="number"]').change(function(){
            autonumber($(this));
        });
        $('.rupiah').each(function(){
            let index = $('.rupiah').index($(this));
            let max = $(this).data('max');
            let rupiahElement  = autoNumeric_field[index];
            rupiahElement.update({"maximumValue" : max});
        });
    });

    function refreshItemTotal(this_el){
        let classes = $(this_el).prop('class').split(' ');
        classes = classes.filter(function(item){
            if(item.includes('item')){
                return true;
            }else{
                return false;
            }
        });
        let itemindex = classes[0].replace('item','');
        let qty = $('.item'+itemindex+':eq(0)').val();
        let price = autoNumeric_field[$('.rupiah').index($('.item'+itemindex+':eq(1)'))].get();
        let ongkir = autoNumeric_field[$('.rupiah').index($('.item'+itemindex+':eq(3)'))].get();
        let ongpas = autoNumeric_field[$('.rupiah').index($('.item'+itemindex+':eq(4)'))].get();
        let total = (qty * parseFloat(price)) + parseFloat(ongkir) + parseFloat(ongpas);
        $('.item'+itemindex+':eq(2)').text(setRupiah(total));
        $('.item'+itemindex+':eq(2)').data('total',total);
        refreshGrandTotal();
    }

    function refreshGrandTotal() {
        let grandtotal = 0;
        $('.total').each(function(){
            grandtotal += parseFloat($(this).data('total'));
        });
        $('.grandtotal').text(setRupiah(grandtotal));
        $('.grandtotal').data('grandtotal',grandtotal);
    }
</script>
@endsection
