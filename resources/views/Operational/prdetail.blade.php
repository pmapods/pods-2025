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
<form action="">
    @csrf
    <input type="hidden" name="updated_at" value="{{$ticket->updated_at}}">
    <input type="hidden" name="ticket_id" value="{{$ticket->id}}">
    <input type="hidden" name="_method">
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
                        <td class="font-weight-bold required_field" width="8%">Qty</td>
                        <td class="font-weight-bold required_field">Harga Satuan (Rp)</td>
                        <td class="font-weight-bold" width="10%">Total Harga</td>
                        <td class="font-weight-bold optional_field">Tgl Set Up</td>
                        <td class="font-weight-bold">Keterangan</td>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @php $grandtotal=0; @endphp
                    @foreach ($ticket->ticket_item->where('isCancelled','!=',true) as $key=>$item)
                    <tr>
                        <td rowspan="3">{{$key+1}}</td>
                        <td>
                            {{$item->name}}
                        </td>
                        <td rowspan="3">{{$item->budget_pricing->uom}}</td>
                        <td rowspan="3">
                            <input type="number" class="form-control nilai qty item{{$key}}" min="0" max="{{$item->count}}" 
                            value="{{$item->count}}"
                            onchange="refreshItemTotal(this)"
                            name="item[{{$key}}][qty]">
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
                            onchange="refreshItemTotal(this)"
                            name="item[{{$key}}][price]">
                        </td>
                        <td rowspan="3" class="rupiah_text item{{$key}} total" data-total="{{$total}}">
                            {{$total}}
                        </td>
                        <td rowspan="3">
                            <input class="form-control" type="date" name="item[{{$key}}][setup_date]">
                        </td>
                        <td rowspan="3" class="text-justify">
                            <div class="d-flex flex-column">
                                <b>notes bidding harga</b>
                                <span>{{$item->bidding->price_notes}}</span>
                                <b>Keterangan</b>
                                <textarea class="form-control" rows="3" placeholder="keterangan tambahan" name="item[{{$key}}][notes]"></textarea>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Ongkos Kirim</td>
                        <td>
                            <input type="text" class="form-control rupiah item{{$key}}" 
                            data-max="{{$item->bidding->selected_vendor()->end_ongkir_price}}" 
                            value="{{$item->bidding->selected_vendor()->end_ongkir_price}}"
                            onchange="refreshItemTotal(this)"
                            name="item[{{$key}}][ongkir]">
                        </td>
                    </tr>
                    <tr>
                        <td>Ongkos Pasang</td>
                        <td>
                            <input type="text" class="form-control rupiah item{{$key}}" 
                            data-max="{{$item->bidding->selected_vendor()->end_pasang_price}}" 
                            value="{{$item->bidding->selected_vendor()->end_pasang_price}}"
                            onchange="refreshItemTotal(this)"
                            name="item[{{$key}}][ongpas]">
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
                <select class="form-control select2 authorization_select2" required name="pr_authorization_id">
                    <option value="">Pilih Otorisasi</option>
                    @foreach ($authorizations as $authorization)
                        @php
                            $list= $authorization->authorization_detail;
                            $string = "";
                            foreach ($list as $key=>$author){
                                $string = $string.$author->employee->name;
                                $open = $author->employee_position;
                                if(count($list)-1 != $key){
                                    $string = $string.' -> ';
                                }
                            }
                        @endphp
                        <option value="{{ $authorization->id }}" data-list="{{ $list }}">{{$string}}</option>
                    @endforeach
                </select>
            </div>
            <center><h4>Otorisasi</h4><center>
            @php
                $default_as = ['Dibuat Oleh', 'Diperiksa Oleh'];
                $collection = $ticket->ticket_authorization->slice(1)->all();
                $values = collect($collection)->values();
            @endphp
            <div class="d-flex justify-content-center">
                <div class="d-flex align-items-center justify-content-center">
                    @foreach ($values->all() as $key =>$author)
                        <div class="mr-3">
                            <span class="font-weight-bold">{{$author->employee->name}} -- {{$author->employee_position}}</span><br>
                            <span class="font-weight-bold text-success">Approved</span><br>
                            <span>{{$default_as[$key]}}</span>
                        </div>
                        @if($key < $values->count()-1)
                        <i class="fa fa-chevron-right mr-3" aria-hidden="true"></i>
                        @endif
                    @endforeach
                </div>
                <div class="d-flex align-items-center justify-content-center" id="authorization_field">
    
                </div>
            </div>
            <center class="mt-3">
                <button type="button" class="btn btn-primary" onclick="startAuthorization()">Mulai Otorisasi Form PR</button>
            </center>
    </div>
</form>
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
        $('.authorization_select2').change(function(){
            let list = $(this).find('option:selected').data('list');
            $('#authorization_field').empty();
            if(list !== undefined){
                $('#authorization_field').append('<i class="fa fa-chevron-right mr-3" aria-hidden="true"></i>')
                list.forEach(function(item,index){
                    $('#authorization_field').append('<div class="mr-3"><span class="font-weight-bold">'+item.employee.name+' -- '+item.employee_position.name+'</span><br><span>'+item.sign_as+'</span></div>');
                    if(index != list.length -1){
                        $('#authorization_field').append('<i class="fa fa-chevron-right mr-3" aria-hidden="true"></i>');
                    }
                });
            }
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

        if(qty < 1){
            total = 0;
            $('.item'+itemindex+':eq(1)').prop('disabled', true);
            $('.item'+itemindex+':eq(3)').prop('disabled', true);
            $('.item'+itemindex+':eq(4)').prop('disabled', true);
        }else{
            $('.item'+itemindex+':eq(1)').prop('disabled', false);
            $('.item'+itemindex+':eq(3)').prop('disabled', false);
            $('.item'+itemindex+':eq(4)').prop('disabled', false);
        }

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

    function startAuthorization(){
        $('form').prop('action','/addnewpr');
        $('form').prop('method','POST');
        $('form input[name="_method"]').val('POST');
        $('form').submit();
    }
</script>
@endsection
