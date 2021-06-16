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
        @if (count($vendor->selected_items()) < 1)
            @continue
        @endif
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
                                <textarea class="form-control" rows="3" name="send_address" placeholder="Masukkan Alamat Kirim" required>{{$vendor->ticket->salespoint->address}}</textarea>
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
                                    <td class="rupiah_text">{{$item->price}}</td>
                                    <td class="rupia_text text-right">{{$item->qty*$item->price}}</td>
                                    @php $total += $item->qty*$item->price; @endphp
                                </tr>
                                @if($item->ongkir > 0)
                                    <tr>
                                        <td>Ongkir {{$item->ticket_item->name}}</td>
                                        <td>1</td>
                                        <td class="rupiah_text">{{$item->ongkir}}</td>
                                        <td class="rupiah_text text-right">{{$item->ongkir}}</td>
                                        @php $total += $item->ongkir; @endphp
                                    </tr>
                                @endif
                                @if($item->ongpas > 0)
                                    <tr>
                                        <td>Ongpas {{$item->ticket_item->name}}</td>
                                        <td>1</td>
                                        <td class="rupiah_text">{{$item->ongpas}}</td>
                                        <td class="rupiah_text text-right">{{$item->ongpas}}</td>
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
                                <td class="font-weight-bold rupiah_text text-right">{{$total}}</td>
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
                                <input type="number" class="form-control" placeholder="Hari" name="payment_days" min="0" value="{{($vendor->po) ? $vendor->po->payment_days : 0}}" @if($vendor->po) readonly @else required @endif>
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
                                <textarea class="form-control" placeholder="notes" name="notes" rows="3" @if($vendor->po) readonly @endif>{{($vendor->po) ? $vendor->po->notes : ''}}</textarea>
                              </div>
                        </div>
                    </div>
                    @if(!isset($vendor->po))
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
                                <input type="text" class="form-control form-control-sm text-center" name="supplier_pic_name" placeholder="Masukkan nama PIC" required>
                                <input type="text" class="form-control form-control-sm text-center" name="supplier_pic_position" placeholder="Masukkan posisi PIC (optional)" value="Supplier PIC" required>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="row">
                        @php
                            $names = ["Dibuat Oleh","Diperiksa dan disetujui oleh","Konfirmasi Supplier"];
                            $enames = ["Created by","Checked and Approval by","Supplier Confirmation"];
                            $po_authorizations = $vendor->po->po_authorization;
                            $authorizations =[];
                            foreach ($po_authorizations as $po_authorization){
                                $auth = new \stdClass();
                                $auth->employee_name = $po_authorization->employee_name;
                                $auth->employee_position = $po_authorization->employee_position;
                                array_push($authorizations,$auth);
                            }
                            $auth = new \stdClass();
                            $auth->employee_name = $vendor->po->supplier_pic_name;
                            $auth->employee_position = $vendor->po->supplier_pic_position;
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
                                    <span class="align-self-center text-uppercase">{{$authorization->employee_name}}</span>
                                    <span class="align-self-center">{{$authorization->employee_position}}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @endif
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
                        @if(($vendor->po->status ?? -1) == 1)
                            <span>status : {{($vendor->po->po_upload_request()->isOpened == false) ? 'Link Upload File belum dibuka' : 'Link Upload File sudah dibuka'}}</span>
                        @endif
                        @if(($vendor->po->status ?? -1) > 1)
                            @php
                                $filename = pathinfo($vendor->po->po_upload_request()->filepath)['basename'];
                            @endphp
                            <a class="uploaded_file" href="/storage/{{$vendor->po->po_upload_request()->filepath}}" download="{{$filename}}">Tampilkan dokumen Supplier Signed</a>
                        @endif
                    </div>
                    
                    @php
                        $toEmail = ($vendor->vendor()->email ?? '');
                    @endphp
                    @if($vendor->po->status == 0)
                        <div class="form-group">
                          <label class="required_field">Masukkan Email Tujuan</label>
                          <input type="text" class="form-control" id="sendMail" value="{{$toEmail}}" placeholder="supplieremail@example.com">
                        </div>
                    @endif
                    <div class="align-self-center mt-3 button_field">
                        @if($vendor->po)
                            @if($vendor->po->status == 0)
                                <button type="button" class="btn btn-info" onclick="window.open('/printPO?code={{$vendor->po->no_po_sap}}')">Cetak PO</button>
                                <button type="button" class="btn btn-primary select_file_button" onclick="selectfile()">Pilih Dokumen</button>
                                <button type="button" class="btn btn-success upload_button" onclick="uploadfile({{$vendor->po->id}})" style="display:none">Upload File</button>
                                <input class="inputFile" type="file" style="display:none;">
                            @endif
                            
                            @if($vendor->po->status == 1)
                                <button type="button" class="btn btn-warning" onclick="send_email({{$vendor->po->id}},'{{$vendor->name}}','{{$vendor->po->no_po_sap}}')">Kirim Ulang Email</button>
                            @endif

                            @if($vendor->po->status == 2)
                                <button type="button" class="btn btn-danger" onclick="reject({{$vendor->po->id}},'{{$toEmail}}','{{$vendor->po->no_po_sap}}','{{$vendor->po->po_upload_request()->id}}')">Reject</button>
                                <button type="button" class="btn btn-success" onclick="confirm({{$vendor->po->id}})">Confirm</button>
                            @endif
                        @else
                            <button type="submit" class="btn btn-primary">Terbitkan PO</button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
        @endforeach
    </div>
</div>

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

<div class="modal fade" id="sendEmailModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="/sendemail" method="post" enctype="multipart/form">
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
        })
    });
    function selectfile(){
        $('.inputFile').click();
    }
    function uploadfile(id){
        let linkfile = $('.uploaded_file');
        let email = $('#sendMail').val();
        if(linkfile.length == 0){
            alert('Silahkan pilih file dokument po yang sudah ditandatangan terlebih dahulu');
        }else if(email == "" || !isEmail(email)){
            alert('Email tidak valid');
        }else{
            let inputfield = $('#uploadsignedform').find('.input_field');
            let file = linkfile.prop('href');
            let filename = linkfile.data('filename');
            inputfield.empty();
            inputfield.append('<input type="hidden" name="po_id" value="' + id + '">');
            inputfield.append('<input type="hidden" name="file" value="'+file+'">');
            inputfield.append('<input type="hidden" name="filename" value="'+filename+'">');
            inputfield.append('<input type="hidden" name="email" value="'+email+'">');
            $('#uploadsignedform').submit();
        }
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
</script>
@endsection
