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
                <h1 class="m-0 text-dark">PR Manual ({{$armadaticket->code}})</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Operasional</li>
                    <li class="breadcrumb-item">Purchase Requisition</li>
                    <li class="breadcrumb-item active">PR Manual ({{$armadaticket->code}})</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@php
    $isReadonly ='readonly';
    if($armadaticket->status == 3){
        if(($armadaticket->pr->current_authorization()->employee_id ?? -1) == Auth::user()->id){
            $isReadonly ='';
        }
    }else{
        $isReadonly ='';
    }
@endphp
<form action="">
    @csrf
    <input type="hidden" name="updated_at" value="{{$armadaticket->updated_at}}">
    <input type="hidden" name="armada_ticket_id" value="{{$armadaticket->id}}">
    <input type="hidden" name="pr_id" value="{{$armadaticket->pr->id ?? -1}}">
    <input type="hidden" name="_method">
    <div class="content-body border border-dark p-2">
        <div class="d-flex flex-column">
            <span>PT. PINUS MERAH ABADI</span>
            <span>CABANG / DEPO : {{$armadaticket->salespoint->name}}</span>
            <h4 class="align-self-center font-weight-bold">PURCHASE REQUISITION (PR) - MANUAL</h4>
            <div class="align-self-end">
                <i class="fal fa-check-square mr-1" aria-hidden="true"></i>Budget
                <i class="fal fa-square ml-5 mr-1" aria-hidden="true"></i>Non Budget
            </div>
            <span>Tanggal : {{($armadaticket->pr) ? $armadaticket->pr->created_at->format('Y-m-d') : now()->translatedFormat('Y-m-d')}}</span>
            <table class="table table-bordered">
                <thead class="text-center">
                    <tr>
                        <td class="font-weight-bold">No</td>
                        <td class="font-weight-bold" width="15%">Nama Barang</td>
                        <td class="font-weight-bold required_field" width='10%'>Satuan</td>
                        <td class="font-weight-bold required_field" width="8%">Qty</td>
                        <td class="font-weight-bold required_field">Harga Satuan (Rp)</td>
                        <td class="font-weight-bold" width="10%">Total Harga</td>
                        <td class="font-weight-bold optional_field">Tgl Set Up</td>
                        <td class="font-weight-bold">Keterangan</td>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @php
                        $grandtotal=0;
                    @endphp
                    @foreach ($armadaticket->pr->pr_detail as $detail)
                        <input type="hidden" name="pr_detail_id" value="{{$detail->id}}">
                        <tr>
                            <td>1</td>
                            <td>{{ $detail->name }}</td>
                            <td>{{ $detail->uom }}</td>
                            <td>{{ $detail->qty }}</td>
                            <td>{{ $detail->price ?? '-' }}</td>
                            <td>
                                @if ($detail->price != null)
                                    {{ $detail->qty * $detail->price }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                {{ $detail->setup_date ?? '-'}}
                            </td>
                            <td width="20%" class="text-justify">
                                <div class="d-flex flex-column">
                                    <label class="optional_field">Keterangan</label>
                                    <span>{{ $detail->notes }}</span>
                                    <div class="form-group">
                                        <label class="required_field">Nomor Asset</label>
                                        <input type="text" class="form-control" 
                                        placeholder="Masukkan nomor asset" 
                                        name="asset_number"
                                        required>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    @empty ($armadaticket->pr->pr_detail)    
                    <tr>
                        <td>1</td>
                        <td>{{$armadaticket->armada_type()->name}}</td>
                        <td>Unit</td>
                        <td>1</td>
                        <td>-</td>
                        <td>-</td>
                        <td>
                            <input class="form-control" type="date" 
                            name="setup_date" {{$isReadonly}}>
                        </td>
                        <td class="text-justify">
                            <div class="d-flex flex-column">
                                <label class="optional_field">Keterangan</label>
                                <textarea class="form-control" rows="3" 
                                placeholder="keterangan tambahan" 
                                name="notes"
                                {{$isReadonly}}></textarea>
                            </div>
                        </td>
                    </tr>
                    @endempty
                    <tr>
                        <td colspan="5"><b>Total</b></td>
                        <td class="grandtotal">-</td>
                        <td colspan="2"></td>
                    </tr>
                </tbody>
            </table>
            @if ($armadaticket->status < 3)
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
            @endif
            <center><h4>Otorisasi</h4><center>
            @php
                $default_as = ['Dibuat Oleh', 'Diperiksa Oleh'];
                $collection = $armadaticket->authorizations->slice(1)->all();
                $values = collect($collection)->values();
            @endphp
            <div class="d-flex justify-content-center">
                @if ($armadaticket->status < 3)
                <div class="d-flex align-items-center justify-content-center">
                    @foreach ($values->all() as $key =>$author)
                        <div class="mr-3">
                            <span class="font-weight-bold">{{$author->employee_name}} -- {{$author->employee_position}}</span><br>
                            <span>{{$default_as[$key]}}</span>
                        </div>
                        @if($key < $values->count()-1)
                        <i class="fa fa-chevron-right mr-3" aria-hidden="true"></i>
                        @endif
                    @endforeach
                </div>
                @endif
                <div class="d-flex align-items-center justify-content-center" id="authorization_field">
                    @if($armadaticket->status > 2)
                        @if ($armadaticket->status < 3)<i class="fa fa-chevron-right mr-3" aria-hidden="true"></i>@endif
                        @foreach($armadaticket->pr->pr_authorizations as $key =>$author)
                            <div class="mr-3">
                                <span class="font-weight-bold">{{$author->employee->name}} -- {{$author->employee_position}}</span><br>
                                @if ($author->status == 1)
                                    <span class="text-success">Approved</span><br>
                                    <span class="text-success">{{$author->updated_at->translatedFormat('d F Y (H:i)')}}</span><br>
                                @endif
                                @if(($armadaticket->pr->current_authorization()->employee_id ?? -1) == $author->employee_id)
                                    <span class="text-warning">Menunggu Otorisasi</span><br>
                                @endif
                                <span>{{$author->as}}</span>
                            </div>
                            @if($key != $armadaticket->pr->pr_authorizations->count()-1)
                                <i class="fa fa-chevron-right mr-3" aria-hidden="true"></i>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="d-flex justify-content-center mt-3">
                <button type="submit" class="d-none">hidden_submit_button</button>
                @if ($armadaticket->status == 2)
                    <button type="button" class="btn btn-primary" onclick="startAuthorization()">Mulai Otorisasi Form PR</button>
                @else
                    @if(($armadaticket->pr->current_authorization()->employee_id ?? -1) == Auth::user()->id)
                        <button type="button" class="btn btn-success" onclick="approve()">Approve</button>
                        <button type="button" class="btn btn-danger ml-2" onclick="reject()">Reject</button>
                    @endif
                @endif
            </div>
            @if ($armadaticket->status == 4)
                <div class="d-flex justify-content-center mt-3">
                    <button onclick="window.open('/printPR/{{$armadaticket->code}}')" class="btn btn-info">Cetak</button>
                    @if($armadaticket->status <6)
                        <button type="button" class="btn btn-primary ml-3" id="submitassetnumber_button">Submit Nomor Asset</button>
                        <button type="submit" class="d-none"></button>
                        <button type="button" class="btn btn-warning ml-3" onclick="window.open('/requestassetnumber/{{ $armadaticket->id }}/{{ $armadaticket->pr->id }}')">Kirim Ulang Request</button>
                    @endif
                </div>
            @endif
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
        $('#submitassetnumber_button').on('click',function(e){
            $('form').prop('action','/submitassetnumber');
            $('form').prop('method','POST');
            $('form button[type="submit"]').trigger('click')
        });
    });

    function startAuthorization(){
        $('form').prop('action','/addnewpr');
        $('form').prop('method','POST');
        $('form input[name="_method"]').val('POST');
        $('button[type="submit"]').trigger('click');
    }

    function approve(){
        $('form').prop('action','/approvepr');
        $('form').prop('method','POST');
        $('form input[name="_method"]').val('PATCH');
        $('.rupiah').each(function(){
            let index = $('.rupiah').index($(this));
            let rupiahElement  = autoNumeric_field[index];
            rupiahElement.update({"aSign": '', "aDec": '.', "aSep": ''});
        });
        $('form').submit();
    }

    function reject(){
        var reason = prompt("Harap memasukan alasan penolakan");
        if (reason != null) {
            if(reason.trim() == ''){
                alert("Alasan Harus diisi");
                return;
            }
            $('form').append('<input type="hidden" name="reason" value="' + reason + '">');
            $('form').prop('action','/rejectpr');
            $('form').prop('method','POST');
            $('form input[name="_method"]').val('PATCH');
            $('.rupiah').each(function(){
                let index = $('.rupiah').index($(this));
                let rupiahElement  = autoNumeric_field[index];
                rupiahElement.update({"aSign": '', "aDec": '.', "aSep": ''});
            });
            $('form').submit();
        }
    }

</script>
@endsection
