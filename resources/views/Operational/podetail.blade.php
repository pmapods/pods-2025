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
        .textarea_text {
            white-space: pre-line;
        }
    </style>
@endsection

@section('content')

<div class="content-header">
    @php
        if(!empty($ticket)) {
            $code = $ticket->code;
        }
        if(!empty($armadaticket)) {
            $code = $armadaticket->code;
        }
        if(!empty($securityticket)) {
            $code = $securityticket->code;
        }
    @endphp
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Pembuatan PO ({{$code}})</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Operasional</li>
                    <li class="breadcrumb-item">Purchase Requisition</li>
                    <li class="breadcrumb-item active">PO ({{$code}})</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="content-body">
    <div class="row">
        @isset($ticket)
            @foreach ($ticket->po as $po)
                <div class="col-md-6 col-12 p-2">
                    <form action="/submitPO" method="post" enctype="multipart/form-data">
                        @method('post')
                        @csrf
                        <input type="hidden" name="po_id" value="{{$po->id}}">
                        <input type="hidden" name="updated_at" value="{{$po->updated_at}}">
                        <div class="box d-flex flex-column p-3">
                            <h4>{{$po->ticket_vendor->name}}</h4>
                            <div class="row">
                                <div class="col-6 d-flex flex-column">
                                    <label class="required_field">Alamat Pengirim</label>
                                    @if($po->status != -1)
                                        <span>{{$po->sender_address}}</span>
                                    @else
                                        @if($po->ticket_vendor->type == 0)
                                        <textarea class="form-control" rows="2" placeholder="Masukkan Alamat pengirim" name="sender_address" required>{{$po->ticket_vendor->vendor()->address}}</textarea>
                                        @endif
                                        @if($po->ticket_vendor->type == 1)
                                        <textarea class="form-control" rows="2" placeholder="Masukkan Alamat pengirim" name="sender_address" required>{{$po->ticket->ticket_item->first()->bidding->bidding_detail->where('ticket_vendor_id',$po->ticket_vendor->id)->first()->address}}</textarea>
                                        @endif
                                    @endif
                                </div>
                                <div class="col-6 d-flex flex-column text-right">
                                    <label class="required_field">Alamat Kirim / SalesPoint</label>
                                    @if($po->status != -1)
                                        <span>{{$po->send_address}}</span>
                                    @else
                                        <textarea class="form-control" rows="3" name="send_address" placeholder="Masukkan Alamat Kirim" required>{{$po->ticket->salespoint->address}}</textarea>
                                    @endif
                                </div>
                            </div>
                            <div class="table-responsive mt-2">
                                <table class="table" style>
                                    <thead>
                                        <tr>
                                            <th width="25%">Nama Barang</th>
                                            <th width="10%">Jumlah</th>
                                            <th width="20%">Harga/Unit</th>
                                            <th width="20%" class="text-right">Total</th>
                                            <th width="25%">Tanggal Kirim</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $total = 0; 
                                            $subtotal = 0; 
                                            $ppn = 0; 
                                        @endphp
                                        @foreach ($po->po_detail as $key=>$po_detail)
                                        <input type="hidden" name="po_detail[{{$key}}][id]" value="{{$po_detail->id}}"/>
                                            <tr>
                                                <td>
                                                    {{$po_detail->item_name}}<br>
                                                    <span class="small text-secondary">
                                                        {!! nl2br(e($po_detail->item_description)) !!}
                                                    </span>
                                                </td>
                                                <td>{{$po_detail->qty}} AU</td>
                                                <td class="rupiah_text">{{$po_detail->item_price}}</td>
                                                <td class="rupiah_text text-right">{{$po_detail->qty*$po_detail->item_price}}</td>
                                                <td>
                                                    @if ($po->status != -1)
                                                        {!! nl2br(e($po_detail->delivery_notes)) !!}
                                                    @else
                                                        <textarea class="form-control" name="po_detail[{{$key}}][delivery_notes]" placeholder="Notes (Optional)" rows="3"></textarea>
                                                    @endif
                                                </td>
                                                @php $subtotal += $po_detail->qty*$po_detail->item_price; @endphp
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <table class="table table-borderless table-sm">
                                <tbody>
                                    <tr>
                                        <td>Subtotal</td>
                                        <td class="rupiah_text text-right">{{$subtotal}}</td>
                                    </tr>
                                    @if($po->has_ppn)
                                    @php
                                        $ppn = $subtotal * $po->ppn_percentage / 100;
                                    @endphp
                                    <tr>
                                        <td>PPN ({{$po->ppn_percentage}}%)</td>
                                        <td class="rupiah_text text-right">{{$ppn}}</td>
                                    </tr>
                                    @endif
                                    @php
                                        $total = $subtotal + $ppn;
                                    @endphp
                                    <tr>
                                        <td>Total</td>
                                        <td class="font-weight-bold rupiah_text text-right">{{$total}}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <h5>Kelengkapan data PO</h5>
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                    <label class="required_field">Tanggal Buat</label>
                                    <input type="date" class="form-control" name="date_po_sap" value="{{($po->status != -1) ? $po->created_at->format('Y-m-d') : now()->format('Y-m-d')}}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <label class="required_field">Pembayaran / Payment</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" placeholder="Hari" name="payment_days" min="0" value="{{($po->status != -1) ? $po->payment_days : 0}}" @if($po->status != -1) readonly @else required @endif>
                                        <div class="input-group-append">
                                            <div class="input-group-text">Hari / Days</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                    <label class="required_field">No PR SAP</label>
                                    <input type="text" class="form-control" name="no_pr_sap" 
                                    value="{{($po->status != -1) ? $po->no_pr_sap : ''}}" 
                                    @if($po->status != -1) readonly @else required @endif>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                    <label class="required_field">No PO SAP</label>
                                    <input type="text" class="form-control" name="no_po_sap" 
                                    value="{{($po->status != -1) ? $po->no_po_sap : ''}}" 
                                    @if($po->status != -1) readonly @else required @endif>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="optional_field">Notes</label>
                                        <textarea class="form-control" placeholder="notes" name="notes" rows="3" 
                                        @if($po->status != -1) readonly @endif>{{($po->status != -1) ? $po->notes : ''}}</textarea>
                                    </div>
                                </div>
                            </div>
                            @if($po->status == -1)
                            <div class="form-group">
                            <label class="required_field">Pilih Otorisasi</label>
                            <select class="form-control authorization_select2" name="authorization_id" required>
                                <option value="">Pilih Otorisasi</option>
                                @foreach ($authorization_list as $auth_select)
                                    @php
                                        $list = $auth_select->authorization_detail;
                                        $string = "";
                                        foreach ($list as $key=>$author){
                                            $string = $string.$author->employee->name;
                                            $open = $author->employee_position;
                                            if(count($list)-1 != $key){
                                                $string = $string.' -> ';
                                            }
                                        }
                                    @endphp
                                    <option value="{{ $auth_select->id}}" data-list="{{ $auth_select->list()}}">{{$string}}</option>
                                @endforeach
                            </select>
                            </div>
                            <div class="authorization_select_field row">
                                <div class="col-md-4 px-1">
                                    <div class="border border-dark d-flex flex-column">
                                        <div class="text-center small">
                                            Dibuat Oleh<br>
                                            Created by</i>
                                            <hr>
                                        </div>
                                        <div class="sign_space"></div>
                                        <span class="align-self-center text-uppercase name1">&nbsp</span>
                                        <span class="align-self-center position1">&nbsp</span>
                                    </div>
                                </div>
                                <div class="col-md-4 px-1">
                                    <div class="border border-dark d-flex flex-column">
                                        <div class="text-center small">
                                            Diperiksa dan disetujui oleh<br>
                                            Checked and Approval by</i>
                                            <hr>
                                        </div>
                                        <div class="sign_space"></div>
                                        <span class="align-self-center text-uppercase name2">&nbsp</span>
                                        <span class="align-self-center position2">&nbsp</span>
                                    </div>
                                </div>
                                <div class="col-md-4 px-1">
                                    <div class="border border-dark d-flex flex-column">
                                        <div class="text-center small">
                                            Konfirmasi Supplier<br>
                                            Supplier Confirmation</i>
                                            <hr>
                                        </div>
                                        <div class="sign_space"></div>
                                        <input type="text" class="form-control form-control-sm text-center" 
                                            name="supplier_pic_name" 
                                            placeholder="Masukkan nama PIC (optional)">
                                        <input type="text" class="form-control form-control-sm text-center" 
                                            name="supplier_pic_position" 
                                            placeholder="Masukkan posisi PIC (optional)">
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="row">
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
                                    <div class="col-md-4 px-1">
                                        <div class="border border-dark d-flex flex-column">
                                            <div class="text-center small">
                                                {{$names[$key]}}<br>
                                                <i>{{$enames[$key]}}</i>
                                                <hr>
                                            </div>
                                            <div class="sign_space"></div>
                                            <span class="align-self-center text-uppercase">
                                                {{$authorization->employee_name}}
                                                @if ($authorization->employee_name=="")
                                                {!! "&nbsp;" !!}
                                                @endif
                                            </span>
                                            <span class="align-self-center">
                                                {{$authorization->employee_position}}
                                                @if ($authorization->employee_position=="")
                                                {!! "&nbsp;" !!}
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @endif
                            @if($po->status == 0)
                            <small class="text-danger">*harap melakukan upload dokumen yang sudah ditanda tangan basah oleh tim internal</small>
                            @endif
                            
                            @if($po->status == 1)
                            <small class="text-info">*Menunggu supplier untuk melakukan upload file po yang sudah dilengkapi tanda tangan basah dari supplier bersangkutan</small>
                            @endif

                            @if($po->status == 3)
                            <small class="text-info">*Menunggu penerimaan barang oleh salespoint/area bersangkutan</small>
                            @endif
                            
                            <div class="display_field my-1 d-flex flex-column">
                                @if($po->status == 1)
                                    @php
                                        $filename = explode('/',$po->internal_signed_filepath);
                                        $filename = $filename[count($filename)-1];
                                    @endphp
                                    <a class="uploaded_file text-primary" style="cursor:pointer" onclick='window.open("/storage/{{$po->internal_signed_filepath}}")'>Tampilkan dokumen Internal Signed</a>
                                    <span>status : {{($po->po_upload_request->isOpened == false) ? 'Link Upload File belum dibuka' : 'Link Upload File sudah dibuka'}}</span>
                                @endif
                                @if($po->status == 2)
                                    <a class="uploaded_file text-primary font-weight-bold" 
                                    style="cursor: pointer;" 
                                    onclick='window.open("/storage/{{$po->po_upload_request->filepath}}")'>
                                        -> Cek dokumen dengan tanda tangan supplier
                                    </a>
                                @endif
                                @if($po->status == 3)
                                    <a class="uploaded_file text-primary font-weight-bold" 
                                    style="cursor: pointer;" 
                                    onclick='window.open("/storage/{{$po->external_signed_filepath}}")'
                                    >Dokumen PO dengan Tanda Tangan Lengkap
                                    </a>
                                @endif
                            </div>
                            
                            @php
                                $toEmail = ($po->ticket_vendor->vendor()->email ?? '');
                            @endphp
                            @if($po->status == 0)
                                <div class="form-group">
                                <label class="required_field">Masukkan Email Tujuan</label>
                                <input type="text" class="form-control" value="{{$toEmail}}" placeholder="supplieremail@example.com" name="email" required>
                                </div>
                                <div class="form-group">
                                <label class="required_field">Pilih File PO yang sudah di Tanda tangan Internal</label>
                                <input type="file" class="form-control-file validatefilesize" name="internal_signed_file" accept="image/*,application/pdf" required>
                                <small class="text-danger">*jpg, jpeg, pdf (MAX 5MB)</small>
                                </div>
                            @endif
                            <div class="align-self-center mt-3 button_field">
                                @if($po->status != -1)
                                    @if($po->status == 0)
                                        <button type="button" class="btn btn-info" onclick="window.open('/printPO?code={{$po->no_po_sap}}')">Cetak PO</button>
                                        <button type="button" class="btn btn-success" onclick="uploadfile(this)">Upload File</button>
                                    @endif
                                    
                                    @if($po->status == 1)
                                        <button type="button" class="btn btn-warning" onclick="send_email({{$po->id}},'{{$po->ticket_vendor->name}}','{{$po->no_po_sap}}')">Kirim Ulang Email</button>
                                    @endif

                                    @if($po->status == 2)
                                        <button type="button" class="btn btn-danger" onclick="reject({{$po->id}},'{{$toEmail}}','{{$po->no_po_sap}}','{{$po->po_upload_request->id}}')">Reject</button>
                                        <button type="button" class="btn btn-success" onclick="confirm({{$po->id}})">Confirm</button>
                                    @endif
                                    <button type="submit" class="d-none"></button>
                                @else
                                    <button type="submit" class="btn btn-primary">Terbitkan PO</button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            @endforeach
        @endisset

        @isset($armadaticket)
            @foreach ($armadaticket->po as $po)
                <div class="col-md-6 col-12 p-2">
                    <form action="/submitPO" method="post" enctype="multipart/form-data">
                        @method('post')
                        @csrf
                        <input type="hidden" name="po_id" value="{{$po->id}}">
                        <input type="hidden" name="updated_at" value="{{$po->updated_at}}">
                        <div class="box d-flex flex-column p-3">
                            <div class="row">
                                <div class="col-md-3">Nama Vendor</div>
                                <div class="col-md-9 font-weight-bold">{{$po->sender_name}}</div>
                                <div class="col-md-3">Salespoint Terkait</div>
                                <div class="col-md-9 font-weight-bold">{{$po->send_name}}</div>
                            </div>
                            <div class="row">
                                <div class="col-6 d-flex flex-column">
                                    <label class="required_field">Alamat Pengirim</label>
                                    @if($po->status != -1)
                                        <span>{{$po->sender_address}}</span>
                                    @else
                                        <textarea class="form-control" name="sender_address" rows="3"></textarea>
                                    @endif
                                </div>
                                <div class="col-6 d-flex flex-column text-right">
                                    <label class="required_field">Alamat Kirim / SalesPoint</label>
                                    @if($po->status != -1)
                                        <span>{{$po->send_address}}</span>
                                    @else
                                        @php 
                                            if($po->armada_ticket->type() == 'Mutasi'){
                                                $temp_address = $po->armada_ticket->po_reference->armada_ticket->salespoint->address;
                                            }else{
                                                $temp_address = $po->armada_ticket->salespoint->address;
                                            }
                                        @endphp
                                        <textarea class="form-control" rows="3" name="send_address" placeholder="Masukkan Alamat Kirim" required>{{$temp_address}}</textarea>
                                    @endif
                                </div>
                            </div>
                            <div class="table-responsive mt-2">
                                <table class="table small">
                                    <thead>
                                        <tr>
                                            <th width="25%">Nama Barang</th>
                                            <th width="10%">Jumlah</th>
                                            <th width="20%">Harga/Unit</th>
                                            <th width="20%" class="text-right">Total</th>
                                            <th width="25%">Tanggal Kirim</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $total = 0; 
                                            $subtotal = 0; 
                                            $ppn = 0; 
                                        @endphp
                                        @foreach ($po->po_detail as $key=>$po_detail)
                                        <input type="hidden" name="po_detail[{{$key}}][id]" value="{{$po_detail->id}}"/>
                                            <tr>
                                                <td>
                                                    {{$po_detail->item_name}}<br>
                                                    <span class="text-secondary">{!! nl2br(e($po_detail->item_description)) !!}</span>
                                                </td>
                                                <td>{{$po_detail->qty}} AU</td>
                                                <td class="rupiah_text">{{$po_detail->item_price}}</td>
                                                <td class="rupiah_text text-right">{{$po_detail->qty*$po_detail->item_price}}</td>
                                                <td>
                                                    @if ($po->status != -1)
                                                        {!! nl2br(e($po_detail->delivery_notes)) !!}
                                                    @else
                                                        <textarea class="form-control" name="po_detail[{{$key}}][delivery_notes]" placeholder="Notes (Optional)" rows="3"></textarea>
                                                    @endif
                                                </td>
                                                @php $subtotal += $po_detail->qty*$po_detail->item_price; @endphp
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <table class="table table-borderless table-sm">
                                <tbody>
                                    <tr>
                                        <td>Subtotal</td>
                                        <td class="rupiah_text text-right">{{$subtotal}}</td>
                                    </tr>
                                    @if($po->has_ppn)
                                    @php
                                        $ppn = $subtotal * $po->ppn_percentage / 100;
                                    @endphp
                                    <tr>
                                        <td>PPN ({{$po->ppn_percentage}}%)</td>
                                        <td class="rupiah_text text-right">{{$ppn}}</td>
                                    </tr>
                                    @endif
                                    @php
                                        $total = $subtotal + $ppn;
                                    @endphp
                                    <tr>
                                        <td>Total</td>
                                        <td class="font-weight-bold rupiah_text text-right">{{$total}}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <h5>Kelengkapan data PO</h5>
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                    <label class="required_field">Tanggal Buat</label>
                                    <input type="date" class="form-control" name="date_po_sap" value="{{($po->status != -1) ? $po->created_at->format('Y-m-d') : now()->format('Y-m-d')}}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <label class="required_field">Pembayaran / Payment</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" placeholder="Hari" name="payment_days" min="0" value="{{($po->status != -1) ? $po->payment_days : 0}}" @if($po->status != -1) readonly @else required @endif>
                                        <div class="input-group-append">
                                            <div class="input-group-text">Hari / Days</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                    <label class="required_field">No PR SAP</label>
                                    <input type="text" class="form-control" name="no_pr_sap" 
                                    value="{{($po->status != -1) ? $po->no_pr_sap : ''}}" 
                                    @if($po->status != -1) readonly @else required @endif>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                    <label class="required_field">No PO SAP</label>
                                    <input type="text" class="form-control" name="no_po_sap" 
                                    value="{{($po->status != -1) ? $po->no_po_sap : ''}}" 
                                    @if($po->status != -1) readonly @else required @endif>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="optional_field">Notes</label>
                                        <textarea class="form-control" placeholder="notes" name="notes" rows="3" 
                                        @if($po->status != -1) readonly @endif>{{($po->status != -1) ? $po->notes : ''}}</textarea>
                                    </div>
                                </div>
                            </div>
                            @if($po->status == -1)
                            <div class="form-group">
                            <label class="required_field">Pilih Otorisasi</label>
                            <select class="form-control authorization_select2" name="authorization_id" required>
                                    <option value="">Pilih Otorisasi</option>
                                    @foreach ($authorization_list as $auth_select)
                                        @php
                                            $list = $auth_select->authorization_detail;
                                            $string = "";
                                            foreach ($list as $key=>$author){
                                                $string = $string.$author->employee->name;
                                                $open = $author->employee_position;
                                                if(count($list)-1 != $key){
                                                    $string = $string.' -> ';
                                                }
                                            }
                                        @endphp
                                        <option value="{{ $auth_select->id}}" data-list="{{ $auth_select->list()}}">{{$string}}</option>
                                    @endforeach
                            </select>
                            </div>
                            <div class="authorization_select_field row">
                                <div class="col-md-4 px-1">
                                    <div class="border border-dark d-flex flex-column">
                                        <div class="text-center small">
                                            Dibuat Oleh<br>
                                            Created by</i>
                                            <hr>
                                        </div>
                                        <div class="sign_space"></div>
                                        <span class="align-self-center text-uppercase name1">&nbsp</span>
                                        <span class="align-self-center position1">&nbsp</span>
                                    </div>
                                </div>
                                <div class="col-md-4 px-1">
                                    <div class="border border-dark d-flex flex-column">
                                        <div class="text-center small">
                                            Diperiksa dan disetujui oleh<br>
                                            Checked and Approval by</i>
                                            <hr>
                                        </div>
                                        <div class="sign_space"></div>
                                        <span class="align-self-center text-uppercase name2">&nbsp</span>
                                        <span class="align-self-center position2">&nbsp</span>
                                    </div>
                                </div>
                                <div class="col-md-4 px-1">
                                    <div class="border border-dark d-flex flex-column">
                                        <div class="text-center small">
                                            Konfirmasi Supplier<br>
                                            Supplier Confirmation</i>
                                            <hr>
                                        </div>
                                        <div class="sign_space"></div>
                                        <input type="text" class="form-control form-control-sm text-center" 
                                            name="supplier_pic_name" 
                                            placeholder="Masukkan nama PIC (optional)">
                                        <input type="text" class="form-control form-control-sm text-center" 
                                            name="supplier_pic_position" 
                                            placeholder="Masukkan posisi PIC (optional)">
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="row">
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
                                    <div class="col-md-4 px-1">
                                        <div class="border border-dark d-flex flex-column">
                                            <div class="text-center small">
                                                {{$names[$key]}}<br>
                                                <i>{{$enames[$key]}}</i>
                                                <hr>
                                            </div>
                                            <div class="sign_space"></div>
                                            <span class="align-self-center text-uppercase">
                                                {{$authorization->employee_name}}
                                                @if ($authorization->employee_name=="")
                                                {!! "&nbsp;" !!}
                                                @endif
                                            </span>
                                            <span class="align-self-center">
                                                {{$authorization->employee_position}}
                                                @if ($authorization->employee_position=="")
                                                {!! "&nbsp;" !!}
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @endif
                            @if($po->status == 0)
                            <small class="text-danger">*harap melakukan upload dokumen yang sudah ditanda tangan basah oleh tim internal</small>
                            @endif
                            
                            @if($po->status == 1)
                            <small class="text-info">*Menunggu supplier untuk melakukan upload file po yang sudah dilengkapi tanda tangan basah dari supplier bersangkutan</small>
                            @endif

                            @if($po->status == 3)
                            <small class="text-info">*Menunggu penerimaan barang oleh salespoint/area bersangkutan</small>
                            @endif
                            
                            <div class="display_field my-1 d-flex flex-column">
                                @if($po->status == 1)
                                    @php
                                        $filename = explode('/',$po->internal_signed_filepath);
                                        $filename = $filename[count($filename)-1];
                                    @endphp
                                    <a class="uploaded_file text-primary" style="cursor:pointer" onclick='window.open("/storage/{{$po->internal_signed_filepath}}")'>Tampilkan dokumen Internal Signed</a>
                                    <span>status : {{($po->po_upload_request->isOpened == false) ? 'Link Upload File belum dibuka' : 'Link Upload File sudah dibuka'}}</span>
                                @endif
                                @if($po->status == 2)
                                    <a class="uploaded_file text-primary font-weight-bold" 
                                    style="cursor: pointer;" 
                                    onclick='window.open("/storage/{{$po->po_upload_request->filepath}}")'>
                                        -> Cek dokumen dengan tanda tangan supplier
                                    </a>
                                @endif
                                @if($po->status == 3)
                                    <a class="uploaded_file text-primary font-weight-bold" 
                                        style="cursor: pointer;" 
                                        onclick='window.open("/storage/{{$po->external_signed_filepath}}")'
                                        >Dokumen PO dengan Tanda Tangan Lengkap
                                    </a>
                                @endif
                            </div>
                            
                            @php
                                if(!empty($ticket)) {
                                    $toEmail = ($po->ticket_vendor->vendor()->email ?? '');
                                }
                                if(!empty($armadaticket)){
                                    $toEmail = "";
                                }
                            @endphp
                            @if($po->status == 0)
                                <div class="form-group">
                                    <label class="required_field">Masukkan Email Tujuan</label>
                                    <input type="text" class="form-control" 
                                    id="supplier_email"
                                    value="{{$toEmail}}" 
                                    placeholder="supplieremail@example.com" name="email" 
                                    required>
                                </div>
                                <div class="form-group">
                                    <label class="required_field">Pilih File PO yang sudah di Tanda tangan Internal</label>
                                    <input type="file" 
                                        class="form-control-file validatefilesize" 
                                        name="internal_signed_file" 
                                        accept="image/*,application/pdf" required>
                                    <small class="text-danger">*jpg, jpeg, pdf (MAX 5MB)</small>
                                </div>
                            @endif
                            <div class="align-self-center mt-3 button_field">
                                @if($po->status != -1)
                                    @if($po->status == 0)
                                        <button type="button" class="btn btn-info" onclick="window.open('/printPO?code={{$po->no_po_sap}}')">Cetak PO</button>
                                        <button type="button" class="btn btn-success" onclick="uploadfile(this)">Upload File</button>
                                    @endif
                                    
                                    @if($po->status == 1)
                                        <button type="button" class="btn btn-warning" onclick="send_email({{$po->id}},'{{$po->sender_name}}','{{$po->no_po_sap}}')">Kirim Ulang Email</button>
                                    @endif

                                    @if($po->status == 2)
                                        <button type="button" class="btn btn-danger" onclick="reject({{$po->id}},'{{$toEmail}}','{{$po->no_po_sap}}','{{$po->po_upload_request->id}}')">Reject</button>
                                        <button type="button" class="btn btn-success" onclick="confirm({{$po->id}})">Confirm</button>
                                    @endif
                                    <button type="submit" class="d-none"></button>
                                @else
                                    <button type="submit" class="btn btn-primary">Terbitkan PO</button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            @endforeach
        @endisset

        @isset($securityticket)
            @foreach ($securityticket->po as $po)
            <div class="col-md-6 col-12 p-2">
                <form action="/submitPO" method="post" enctype="multipart/form-data">
                    @method('post')
                    @csrf
                    <input type="hidden" name="po_id" value="{{$po->id}}">
                    <input type="hidden" name="updated_at" value="{{$po->updated_at}}">
                    <div class="box d-flex flex-column p-3">
                        <div class="row">
                            <div class="col-md-3">Nama Vendor</div>
                            <div class="col-md-9 font-weight-bold">{{$po->sender_name}}</div>
                            <div class="col-md-3">Salespoint Terkait</div>
                            <div class="col-md-9 font-weight-bold">{{$po->send_name}}</div>
                        </div>
                        <div class="row">
                            <div class="col-6 d-flex flex-column">
                                <label class="required_field">Alamat Pengirim</label>
                                @if($po->status != -1)
                                    <span>{{$po->sender_address}}</span>
                                @else
                                    <textarea class="form-control" name="sender_address" rows="3"></textarea>
                                @endif
                            </div>
                            <div class="col-6 d-flex flex-column text-right">
                                <label class="required_field">Alamat Kirim / SalesPoint</label>
                                @if($po->status != -1)
                                    <span>{{$po->send_address}}</span>
                                @else
                                    @php 
                                        $temp_address = $po->security_ticket->salespoint->address;
                                    @endphp
                                    <textarea class="form-control" rows="3" name="send_address" placeholder="Masukkan Alamat Kirim" required>{{$temp_address}}</textarea>
                                @endif
                            </div>
                        </div>
                        <div class="table-responsive mt-2">
                            <table class="table small">
                                <thead>
                                    <tr>
                                        <th width="25%">Nama Barang</th>
                                        <th width="10%">Jumlah</th>
                                        <th width="20%">Harga/Unit</th>
                                        <th width="20%" class="text-right">Total</th>
                                        <th width="25%">Tanggal Kirim</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $total = 0; 
                                        $subtotal = 0; 
                                        $ppn = 0; 
                                    @endphp
                                    @foreach ($po->po_detail as $key=>$po_detail)
                                    <input type="hidden" name="po_detail[{{$key}}][id]" value="{{$po_detail->id}}"/>
                                        <tr>
                                            <td>
                                                {{$po_detail->item_name}}<br>
                                                <span class="text-secondary">{!! nl2br(e($po_detail->item_description)) !!}</span>
                                            </td>
                                            <td>{{$po_detail->qty}} AU</td>
                                            <td class="rupiah_text">{{$po_detail->item_price}}</td>
                                            <td class="rupiah_text text-right">{{$po_detail->qty*$po_detail->item_price}}</td>
                                            <td>
                                                @if ($po->status != -1)
                                                    {!! nl2br(e($po_detail->delivery_notes)) !!}
                                                @else
                                                    <textarea class="form-control" name="po_detail[{{$key}}][delivery_notes]" placeholder="Notes (Optional)" rows="3"></textarea>
                                                @endif
                                            </td>
                                            @php $subtotal += $po_detail->qty*$po_detail->item_price; @endphp
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <table class="table table-borderless table-sm">
                            <tbody>
                                <tr>
                                    <td>Subtotal</td>
                                    <td class="rupiah_text text-right">{{$subtotal}}</td>
                                </tr>
                                @if($po->has_ppn)
                                @php
                                    $ppn = $subtotal * $po->ppn_percentage / 100;
                                @endphp
                                <tr>
                                    <td>PPN ({{$po->ppn_percentage}}%)</td>
                                    <td class="rupiah_text text-right">{{$ppn}}</td>
                                </tr>
                                @endif
                                @php
                                    $total = $subtotal + $ppn;
                                @endphp
                                <tr>
                                    <td>Total</td>
                                    <td class="font-weight-bold rupiah_text text-right">{{$total}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <h5>Kelengkapan data PO</h5>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                <label class="required_field">Tanggal Buat</label>
                                <input type="date" class="form-control" name="date_po_sap" value="{{($po->status != -1) ? $po->created_at->format('Y-m-d') : now()->format('Y-m-d')}}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="required_field">Pembayaran / Payment</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" placeholder="Hari" name="payment_days" min="0" value="{{($po->status != -1) ? $po->payment_days : 0}}" @if($po->status != -1) readonly @else required @endif>
                                    <div class="input-group-append">
                                        <div class="input-group-text">Hari / Days</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                <label class="required_field">No PR SAP</label>
                                <input type="text" class="form-control" name="no_pr_sap" 
                                value="{{($po->status != -1) ? $po->no_pr_sap : ''}}" 
                                @if($po->status != -1) readonly @else required @endif>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                <label class="required_field">No PO SAP</label>
                                <input type="text" class="form-control" name="no_po_sap" 
                                value="{{($po->status != -1) ? $po->no_po_sap : ''}}" 
                                @if($po->status != -1) readonly @else required @endif>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="optional_field">Notes</label>
                                    <textarea class="form-control" placeholder="notes" name="notes" rows="3" 
                                    @if($po->status != -1) readonly @endif>{{($po->status != -1) ? $po->notes : ''}}</textarea>
                                </div>
                            </div>
                        </div>
                        @if($po->status == -1)
                        <div class="form-group">
                        <label class="required_field">Pilih Otorisasi</label>
                        <select class="form-control authorization_select2" name="authorization_id" required>
                                <option value="">Pilih Otorisasi</option>
                                @foreach ($authorization_list as $auth_select)
                                    @php
                                        $list = $auth_select->authorization_detail;
                                        $string = "";
                                        foreach ($list as $key=>$author){
                                            $string = $string.$author->employee->name;
                                            $open = $author->employee_position;
                                            if(count($list)-1 != $key){
                                                $string = $string.' -> ';
                                            }
                                        }
                                    @endphp
                                    <option value="{{ $auth_select->id}}" data-list="{{ $auth_select->list()}}">{{$string}}</option>
                                @endforeach
                        </select>
                        </div>
                        <div class="authorization_select_field row">
                            <div class="col-md-4 px-1">
                                <div class="border border-dark d-flex flex-column">
                                    <div class="text-center small">
                                        Dibuat Oleh<br>
                                        Created by</i>
                                        <hr>
                                    </div>
                                    <div class="sign_space"></div>
                                    <span class="align-self-center text-uppercase name1">&nbsp</span>
                                    <span class="align-self-center position1">&nbsp</span>
                                </div>
                            </div>
                            <div class="col-md-4 px-1">
                                <div class="border border-dark d-flex flex-column">
                                    <div class="text-center small">
                                        Diperiksa dan disetujui oleh<br>
                                        Checked and Approval by</i>
                                        <hr>
                                    </div>
                                    <div class="sign_space"></div>
                                    <span class="align-self-center text-uppercase name2">&nbsp</span>
                                    <span class="align-self-center position2">&nbsp</span>
                                </div>
                            </div>
                            <div class="col-md-4 px-1">
                                <div class="border border-dark d-flex flex-column">
                                    <div class="text-center small">
                                        Konfirmasi Supplier<br>
                                        Supplier Confirmation</i>
                                        <hr>
                                    </div>
                                    <div class="sign_space"></div>
                                    <input type="text" class="form-control form-control-sm text-center" 
                                        name="supplier_pic_name" 
                                        placeholder="Masukkan nama PIC (optional)">
                                    <input type="text" class="form-control form-control-sm text-center" 
                                        name="supplier_pic_position" 
                                        placeholder="Masukkan posisi PIC (optional)">
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="row">
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
                                <div class="col-md-4 px-1">
                                    <div class="border border-dark d-flex flex-column">
                                        <div class="text-center small">
                                            {{$names[$key]}}<br>
                                            <i>{{$enames[$key]}}</i>
                                            <hr>
                                        </div>
                                        <div class="sign_space"></div>
                                        <span class="align-self-center text-uppercase">
                                            {{$authorization->employee_name}}
                                            @if ($authorization->employee_name=="")
                                            {!! "&nbsp;" !!}
                                            @endif
                                        </span>
                                        <span class="align-self-center">
                                            {{$authorization->employee_position}}
                                            @if ($authorization->employee_position=="")
                                            {!! "&nbsp;" !!}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @endif
                        @if($po->status == 0)
                        <small class="text-danger">*harap melakukan upload dokumen yang sudah ditanda tangan basah oleh tim internal</small>
                        @endif
                        
                        @if($po->status == 1)
                        <small class="text-info">*Menunggu supplier untuk melakukan upload file po yang sudah dilengkapi tanda tangan basah dari supplier bersangkutan</small>
                        @endif

                        @if($po->status == 3)
                        <small class="text-info">*Menunggu penerimaan barang oleh salespoint/area bersangkutan</small>
                        @endif
                        
                        <div class="display_field my-1 d-flex flex-column">
                            @if($po->status == 1)
                                @php
                                    $filename = explode('/',$po->internal_signed_filepath);
                                    $filename = $filename[count($filename)-1];
                                @endphp
                                <a class="uploaded_file text-primary" style="cursor:pointer" onclick='window.open("/storage/{{$po->internal_signed_filepath}}")'>Tampilkan dokumen Internal Signed</a>
                                <span>status : {{($po->po_upload_request->isOpened == false) ? 'Link Upload File belum dibuka' : 'Link Upload File sudah dibuka'}}</span>
                            @endif
                            @if($po->status == 2)
                                <a class="uploaded_file text-primary font-weight-bold" 
                                style="cursor: pointer;" 
                                onclick='window.open("/storage/{{$po->po_upload_request->filepath}}")'>
                                    -> Cek dokumen dengan tanda tangan supplier
                                </a>
                            @endif
                            @if($po->status == 3)
                                <a class="uploaded_file text-primary font-weight-bold" 
                                    style="cursor: pointer;" 
                                    onclick='window.open("/storage/{{$po->external_signed_filepath}}")'
                                    >Dokumen PO dengan Tanda Tangan Lengkap
                                </a>
                            @endif
                        </div>
                        
                        @php
                            if(!empty($ticket)) {
                                $toEmail = ($po->ticket_vendor->vendor()->email ?? '');
                            }
                            if(!empty($armadaticket) || !empty($securityticket)){
                                $toEmail = "";
                            }
                        @endphp
                        @if($po->status == 0)
                            <div class="form-group">
                                <label class="required_field">Masukkan Email Tujuan</label>
                                <input type="text" class="form-control" 
                                id="supplier_email"
                                value="{{$toEmail}}" 
                                placeholder="supplieremail@example.com" name="email" 
                                required>
                            </div>
                            <div class="form-group">
                                <label class="required_field">Pilih File PO yang sudah di Tanda tangan Internal</label>
                                <input type="file" 
                                    class="form-control-file validatefilesize" 
                                    name="internal_signed_file" 
                                    accept="image/*,application/pdf" required>
                                <small class="text-danger">*jpg, jpeg, pdf (MAX 5MB)</small>
                            </div>
                        @endif
                        <div class="align-self-center mt-3 button_field">
                            @if($po->status != -1)
                                @if($po->status == 0)
                                    <button type="button" class="btn btn-info" onclick="window.open('/printPO?code={{$po->no_po_sap}}')">Cetak PO</button>
                                    <button type="button" class="btn btn-success" onclick="uploadfile(this)">Upload File</button>
                                @endif
                                
                                @if($po->status == 1)
                                    <button type="button" class="btn btn-warning" onclick="send_email({{$po->id}},'{{$po->sender_name}}','{{$po->no_po_sap}}')">Kirim Ulang Email</button>
                                @endif

                                @if($po->status == 2)
                                    <button type="button" class="btn btn-danger" onclick="reject({{$po->id}},'{{$toEmail}}','{{$po->no_po_sap}}','{{$po->po_upload_request->id}}')">Reject</button>
                                    <button type="button" class="btn btn-success" onclick="confirm({{$po->id}})">Confirm</button>
                                @endif
                                <button type="submit" class="d-none"></button>
                            @else
                                <button type="submit" class="btn btn-primary">Terbitkan PO</button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
            @endforeach
        @endisset
    </div>
    <div class="row d-flex justify-content-center">
        @isset($armadaticket)
            @if (in_array($armadaticket->status,[4,5]))
                {{-- 4 Dalam Proses PO --}}
                {{-- 5 Menunggu Upload Berkas Penerimaan --}}
                <button type="button" class="btn btn-danger" onclick="doTerminateTicketing({{ $armadaticket->id }})">Batalkan Pengadaan</button>
            @endif
        @endisset
        @isset($securityticket)
            @if (in_array($securityticket->status,[4,5]))
                {{-- 4 Dalam Proses PO --}}
                {{-- 5 Menunggu Upload Berkas Penerimaan --}}
                <button type="button" class="btn btn-danger" onclick="doTerminateTicketing({{ $securityticket->id }})">Batalkan Pengadaan</button>
            @endif
        @endisset
    </div>
</div>

<form action="/uploadinternalsignedfile" method="post" enctype="multipart/form-data" id="uploadsignedform">
    @method('patch')
    @csrf
    <div class="input_field"></div>
</form>

<form action="/confirmposigned" method="post" enctype="multipart/form-data" id="confirmsignedform">
    @method('patch')
    @csrf
    <input type="hidden" name="po_id">
</form>

<div class="modal fade" id="sendEmailModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="/sendemail" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="po_id">
                <div class="modal-header table-info">
                    <h5 class="modal-title vendor_name">vendor_name</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5>NOMOR PO SAP : <span class="no_sap">no_sap</span></h5>
                    <div class="form-group">
                      <label class="required_field">Tujuan Email</label>
                      <input type="email" class="form-control" name="email" placeholder="Masukkan Email Tujuan" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info">Kirim Email</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="rejectsignedpo" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header table-danger">
                <h5 class="modal-title">Reject PO (<span class="no_po_sap"></span>) External Signed</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <form action="/rejectposigned" method="post">
                @csrf
                @method('patch')
                <div class="modal-body">
                    <div class="form-group">
                        <label class="required_field">Alasan penolakan</label>
                        <textarea class="form-control" name="reason" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label class="required_field">Email yang dituju</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="text-danger font-weight-bold">* Link baru untuk perbaikan data akan dikirimkan ke email yang di input beserta dengan alasan</div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="po_id">
                    <input type="hidden" name="po_upload_request_id">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Reject</button>
                </div>
            </form>
        </div>
    </div>
</div>

@isset($armadaticket)    
    <div class="modal fade" id="terminateTicketingModal" data-static="backdrop" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title">Batalkan Pengadaan Armada</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <form action="/terminateArmadaTicket" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="armada_ticket_id" value="{{ $armadaticket->id }}">
                    <div class="modal-body">
                        <div class="form-group">
                        <label class="required_field">Alasan Pembatalan</label>
                        <textarea class="form-control" name="cancel_notes" style="resize: none" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                        <label class="optional_field">Email Vendor</label>
                        <input type="email" class="form-control" name="email_vendor" placeholder="Email Vendor">
                        <small class="form-text text-warning">* Masukan email vendor untuk memberikan notifikasi pembatalan</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Batalkan Pengadaan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endisset

@isset($securityticket)    
    <div class="modal fade" id="terminateTicketingModal" data-static="backdrop" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title">Batalkan Pengadaan Security</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <form action="/terminateSecurityTicket" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="security_ticket_id" value="{{ $securityticket->id }}">
                    <div class="modal-body">
                        <div class="form-group">
                        <label class="required_field">Alasan Pembatalan</label>
                        <textarea class="form-control" name="cancel_notes" style="resize: none" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                        <label class="optional_field">Email Vendor</label>
                        <input type="email" class="form-control" name="email_vendor" placeholder="Email Vendor">
                        <small class="form-text text-warning">* Masukan email vendor untuk memberikan notifikasi pembatalan</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Batalkan Pengadaan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endisset

@endsection
@section('local-js')
<script>
    $(document).ready(function() {
        $('.authorization_select2').change(function() {
            let field = $(this).closest('.box').find('.authorization_select_field');
            let selected_option = $(this).find('option:selected').data('list');
            if(selected_option == undefined){
                field.find('.name1').text('\xa0');
                field.find('.position1').text('\xa0');
                field.find('.name2').text('\xa0');
                field.find('.position2').text('\xa0');
            }else{
                for(let i = 0; i < selected_option.length; i++){
                    field.find('.name'+(i+1)).text(selected_option[i].name);
                    field.find('.position'+(i+1)).text(selected_option[i].position);
                }
            }
        });
        $('.validatefilesize').change(function(event){
            if(!validatefilesize(event)){
                $(this).val('');
            }
        });
    });
    function uploadfile(el){
        $(el).closest('form').prop('action','/uploadinternalsignedfile');
        $(el).closest('form').prop('method','POST');
        $(el).closest('form').find('input[name="_method"]').val('PATCH');
        $(el).closest('form').find('button[type="submit"]').trigger('click');
    }
    function confirm(po_id){
        $('#confirmsignedform').find('input[name="po_id"]').val(po_id);
        $('#confirmsignedform').submit();
    }
    function reject(po_id,email,no_po_sap,po_upload_request_id){
        $('#rejectsignedpo textarea[name="reason"]').val('');
        $('#rejectsignedpo input[name="reason"]').val('');
        $('#rejectsignedpo input[name="email"]').val('');
        $('#rejectsignedpo .no_po_sap').text(no_po_sap);
        $('#rejectsignedpo input[name="email"]').val(email);
        $('#rejectsignedpo input[name="po_id"]').val(po_id);
        $('#rejectsignedpo input[name="po_upload_request_id"]').val(po_upload_request_id);
        $('#rejectsignedpo').modal('show');
    }
    function send_email(po_id,vendor_name,no_sap){
        $('#sendEmailModal input[name="po_id"]').val(po_id);
        $('#sendEmailModal .vendor_name').text(vendor_name);
        $('#sendEmailModal .no_sap').text(no_sap);
        $('#sendEmailModal').modal('show');
    }
    
    function doTerminateTicketing(){
        $('#terminateTicketingModal').modal('show');
    }
</script>
@endsection
