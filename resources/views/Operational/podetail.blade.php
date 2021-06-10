@extends('Layout.app')
@section('local-css')
    <style>
        .box {
            box-shadow: 0px 1px 2px rgba(0, 0, 0,0.25);
            border : 1px solid;
            border-color: #dcdcdc;
            background-color: #FFF;
            border-radius: 0.5em;
        }
        hr {
            border: 1px solid rgb(0, 0, 0) !important;
            margin: 0 !important;
        }
        .sign_space {
            height: 100px !important
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
    <div class="row">
        @foreach ($ticket->ticket_vendor as $vendor)
        <div class="col-md-6 col-12 p-2">
            <form action="/submitPO" method="post">
                @csrf
                <input type="hidden" name="ticket_vendor_id" value="{{$vendor->id}}">
                <div class="box d-flex flex-column p-3">
                    <h4>{{$vendor->name}}</h4>
                    <div class="row">
                        <div class="col-6 d-flex flex-column">
                            <label class="required_field">Alamat Vendor</label>
                            @if($vendor->po)
                                <span>{{$vendor->po->vendor_address}}</span>
                            @else
                                @if($vendor->type == 0)
                                <textarea class="form-control" rows="3" placeholder="Masukkan Alamat vendor" name="vendor_address" required>{{$vendor->vendor()->address}}</textarea>
                                @endif
                                @if($vendor->type == 1)
                                <textarea class="form-control" rows="3" placeholder="Masukkan Alamat vendor" name="vendor_address" required>{{$vendor->ticket->ticket_item->first()->bidding->bidding_detail->where('ticket_vendor_id',$vendor->id)->first()->address}}</textarea>
                                @endif
                            @endif
                        </div>
                        <div class="col-6 d-flex flex-column text-right">
                            <label class="required_field">Alamat Kirim / Salespoint</label>
                            @if($vendor->po)
                                <span>{{$vendor->po->send_address}}</span>
                            @else
                                <textarea class="form-control" rows="3" name="send_address" placeholder="Masukkan Alamat Kirim" required></textarea>
                            @endif
                        </div>
                    </div>
                    <table class="table mt-2">
                        <thead>
                            <tr>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Harga/Unit</th>
                                <th class="text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @foreach ($vendor->selected_items() as $item)
                                <tr>
                                    <td>{{$item->ticket_item->name}}</td>
                                    <td>{{$item->qty}} {{($item->ticket_item->budget_pricing->uom ?? '')}}</td>
                                    <td class="rupiah">{{$item->price}}</td>
                                    <td class="rupiah text-right">{{$item->qty*$item->price}}</td>
                                    @php $total += $item->qty*$item->price; @endphp
                                </tr>
                                @if($item->ongkir > 0)
                                    <tr>
                                        <td>Ongkir {{$item->ticket_item->name}}</td>
                                        <td>1</td>
                                        <td class="rupiah">{{$item->ongkir}}</td>
                                        <td class="rupiah text-right">{{$item->ongkir}}</td>
                                        @php $total += $item->ongkir; @endphp
                                    </tr>
                                @endif
                                @if($item->ongpas > 0)
                                    <tr>
                                        <td>Ongpas {{$item->ticket_item->name}}</td>
                                        <td>1</td>
                                        <td class="rupiah">{{$item->ongpas}}</td>
                                        <td class="rupiah text-right">{{$item->ongpas}}</td>
                                        @php $total += $item->ongpas; @endphp
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td>Total</td>
                                <td class="font-weight-bold rupiah text-right">{{$total}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <h5>Kelengkapan data PO</h5>
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                              <label class="required_field">Tanggal Buat PO SAP</label>
                              <input type="date" class="form-control" name="date_po_sap" value="{{($vendor->po) ? $vendor->po->created_at->format('Y-m-d') : now()->format('Y-m-d')}}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <label class="required_field">Pembayaran / Payment</label>
                            <div class="input-group">
                                <input type="number" class="form-control" placeholder="Hari" name="payment_days" min="1" value="{{($vendor->po) ? $vendor->po->payment_days : 1}}" @if($vendor->po) readonly @else required @endif>
                                <div class="input-group-append">
                                    <div class="input-group-text">Hari / Days</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                              <label class="required_field">No PR SAP</label>
                              <input type="text" class="form-control" name="no_pr_sap" value="{{($vendor->po) ? $vendor->po->no_pr_sap : ''}}" @if($vendor->po) readonly @else required @endif>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                              <label class="required_field">No PO SAP</label>
                              <input type="text" class="form-control" name="no_po_sap" value="{{($vendor->po) ? $vendor->po->no_po_sap : ''}}" @if($vendor->po) readonly @else required @endif>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="optional_field">Notes</label>
                                <textarea class="form-control" placeholder="notes" name="notes" rows="3" @if($vendor->po) readonly @else required @endif>{{($vendor->po) ? $vendor->po->notes : ''}}</textarea>
                              </div>
                        </div>
                    </div>
                    <div class="row">
                        @php
                            $names = ["Dibuat Oleh","Diperiksa dan disetujui oleh","Konfirmasi Supplier"];
                            $enames = ["Created by","Checked and Approval by","Supplier Confirmation"];
                            $authorizations = array();
                            array_push($authorizations,$vendor->ticket->ticket_item->first()->bidding->bidding_authorization->first());
                            array_push($authorizations,$vendor->ticket->ticket_item->first()->bidding->bidding_authorization->last());
                        @endphp
                        @for($i=0;$i<count($names);$i++)
                            <div class="col-md-4 px-1">
                                <div class="border border-dark d-flex flex-column">
                                    <div class="text-center small">
                                        {{$names[$i]}}<br>
                                        <i>{{$enames[$i]}}</i>
                                        <hr>
                                    </div>
                                    <div class="sign_space"></div>
                                    @if($i<2)
                                        <span class="align-self-center text-uppercase">{{$authorizations[$i]->employee_name}}</span>
                                        <span class="align-self-center">{{$authorizations[$i]->employee_position}}</span>
                                    @else
                                        <span class="align-self-center text-uppercase">{{$vendor->salesperson}}</span>
                                        <span class="align-self-center">Supplier PIC</span>
                                    @endif
                                </div>
                            </div>
                        @endfor
                    </div>
                    @if(($vendor->po->status ?? -1) == 0)
                    <small class="text-danger">*harap melakukan upload dokumen yang sudah ditanda tangan basah oleh tim internal</small>
                    @endif
                    
                    @if(($vendor->po->status ?? -1) == 1)
                    <small class="text-info">*Menunggu supplier untuk melakukan upload file po yang sudah dilengkapi tanda tangan basah dari supplier bersangkutan</small>
                    @endif

                    @if(($vendor->po->status ?? -1) == 3)
                    <small class="text-info">*Menunggu penerimaan barang oleh salespoint/area bersangkutan</small>
                    @endif
                    
                    <div class="display_field my-1 d-flex flex-column">
                        @if(($vendor->po->status ?? -1) > 0)
                            @php
                                $filename = explode('/',$vendor->po->internal_signed_filepath);
                                $filename = $filename[count($filename)-1];
                            @endphp
                            <a class="uploaded_file" href="/storage{{$vendor->po->internal_signed_filepath}}" download="{{$filename}}">Tampilkan dokumen Internal Signed</a>
                        @endif
                        
                        @if(($vendor->po->status ?? -1) > 1)
                            @php
                                $filename = explode('/',$vendor->po->external_signed_filepath);
                                $filename = $filename[count($filename)-1];
                            @endphp
                            <a class="uploaded_file" href="/storage{{$vendor->po->external_signed_filepath}}" download="{{$filename}}">Tampilkan dokumen Supplier Signed</a>
                        @endif
                    </div>
                    <div class="align-self-center mt-3 button_field">
                        @if($vendor->po)
                            @if($vendor->po->status == 0)
                                <button type="button" class="btn btn-info" onclick="print({{$vendor->po->id}})">Cetak PO</button>
                                <button type="button" class="btn btn-primary select_file_button" onclick="selectfile()">Pilih Dokumen</button>
                                <button type="button" class="btn btn-success upload_button" onclick="uploadfile({{$vendor->po->id}})" style="display:none">Upload File Perbaikan</button>
                                <input class="inputFile" type="file" style="display:none;">
                            @endif
                            
                            @if($vendor->po->status == 1)
                                <button type="button" class="btn btn-warning">Kirim Ulang Email</button>
                            @endif

                            @if($vendor->po->status == 2)
                                <button type="button" class="btn btn-danger" onclick="">Reject</button>
                                <button type="button" class="btn btn-success" onclick="confirm({{$vendor->po->id}})">Confirm</button>
                            @endif
                        @else
                            <button type="submit" class="btn btn-primary">Terbitkan PO</button>
                        @endif
                        {{-- FORMS --}}
                    </div>
                </div>
            </form>
        </div>
        @endforeach
    </div>
</div>

<form action="/printPO" method="post" id="printform">
    @csrf
    <input type="hidden" name="po_id">
</form>

<form action="/uploadinternalsignedfile" method="post" enctype="multipart/form" id="uploadsignedform">
    @method('patch')
    @csrf
    <div class="input_field"></div>
</form>

<form action="/confirmposigned" method="post" enctype="multipart/form" id="confirmsignedform">
    @method('patch')
    @csrf
    <input type="hidden" name="po_id">
</form>
@endsection
@section('local-js')
<script>

    $(document).ready(function() {
        $(this).on('change','.inputFile', function(event){
            var reader = new FileReader();
            let value = $(this).val();
            let display_field = $('.display_field');
            if(validatefilesize(event)){
                reader.onload = function(e) {
                    display_field.empty();
                    let name = value.split('\\').pop().toLowerCase();
                    display_field.append('<a class="uploaded_file" href="'+e.target.result+'" download="'+name+'" data-filename="'+name+'">Tampilkan dokumen</a>');

                    $(".select_file_button").text('Pilih Dokumen Ulang')
                    $(".upload_button").show();
                }
                reader.readAsDataURL(event.target.files[0]);
            }else{
                $(this).val('');
            }
        });
    })
    function print(po_id){
        $('#printform').find('input[name="po_id"]').val(po_id);
        $('#printform').submit();
        $('button').prop('disabled',false);
        $('#printform fa-spinner-third').remove();
    }
    function selectfile(){
        $('.inputFile').click();
    }
    function uploadfile(id){
        let linkfile = $('.uploaded_file');
        if(linkfile.length == 0){
            alert('Silahkan pilih file dokument po yang sudah ditandatangan terlebih dahulu');
        }else{
            let inputfield = $('#uploadsignedform').find('.input_field');
            let file = linkfile.prop('href');
            let filename = linkfile.data('filename');
            inputfield.empty();
            inputfield.append('<input type="hidden" name="po_id" value="' + id + '">');
            inputfield.append('<input type="hidden" name="file" value="'+file+'">');
            inputfield.append('<input type="hidden" name="filename" value="'+filename+'">');
            $('#uploadsignedform').submit();
        }
    }

    function confirm(po_id){
        $('#confirmsignedform').find('input[name="po_id"]').val(po_id);
        $('#confirmsignedform').submit();
    }
</script>
@endsection
