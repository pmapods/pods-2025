@extends('Layout.app')
@section('local-css')
<style>
    .box {
        box-shadow: 0px 1px 2px rgba(0, 0, 0,0.25);
        border : 1px solid;
        border-color: gainsboro;
        border-radius: 0.5em;
    }
    .tdbreak{
        /* word-break : break-all; */
    }
</style>
@endsection

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Pengadaan Barang Jasa</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Operasional</li>
                    <li class="breadcrumb-item">Pengadaan</li>
                    <li class="breadcrumb-item active">{{$ticket->code}}</li>
                </ol>
            </div>
        </div>
        <div class="d-flex justify-content-end">
        </div>
    </div>
</div>
<div class="content-body">
    <div class="row d-flex justify-content-end">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary mr-4" data-toggle="modal" data-target="#statusModal">
          Cek Status Pengadaan
        </button>
    </div>

    <div class="row">
        <div class="col-md-4">
            <table class="table table-borderless table-sm">
                <tbody>
                    <tr>
                        <td><b>Tanggal Pengajuan</b></td>
                        <td>{{$ticket->updated_at->translatedFormat('d F Y (H:i)')}}</td>
                    </tr>
                    <tr>
                        <td><b>Tanggal Pengadaan</b></td>
                        <td>{{\Carbon\Carbon::parse($ticket->requirement_date)->translatedFormat('d F Y')}}</td>
                    </tr>
                    <tr>
                        <td><b>Salespoint</b></td>
                        <td>{{$ticket->salespoint->name}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-4">
            <table class="table table-borderless table-sm">
                <tbody>
                    <tr>
                        <td><b>Jenis Item</b></td>
                        <td>{{$ticket->item_type()}}</td>
                    </tr>
                    <tr>
                        <td><b>Jenis Pengadaan</b></td>
                        <td>{{$ticket->request_type()}}</td>
                    </tr>
                    <tr>
                        <td><b>Jenis Budget</b></td>
                        <td>{{$ticket->budget_type()}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-12 box p-3 mt-3">
            <h5 class="font-weight-bold ">Daftar Barang</h5>
            <table class="table table-bordered table_item">
                <thead>
                    <tr>
                        <th width="10%">Nama Item</th>
                        <th width="10%">Merk</th>
                        <th width="10%">Type</th>
                        <th width="10%">Harga Satuan</th>
                        <th>Jumlah</th>
                        <th width="10%">Total</th>
                        <th>Attachment</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ticket->ticket_item as $item)
                        <tr class="@if($item->isCancelled) table-danger @endif">
                            <td>{{$item->name}}</td>
                            <td>{{$item->brand}}</td>
                            <td>{{$item->type}}</td>
                            <td class="rupiah_text">{{$item->price}}</td>
                            <td>{{$item->count}}  {{$item->budget_pricing->uom ?? ''}}</td>
                            <td class="rupiah_text">{{$item->price * $item->count}}</td>
                            <td>
                                @if($item->ticket_item_attachment->count() == 0 && $item->ticket_item_file_requirement->count() == 0)
                                -
                                @endif
                                @if ($item->ticket_item_attachment->count() > 0)
                                    <table class="table table-borderless table-sm">
                                        <tbody>
                                            @foreach ($item->ticket_item_attachment as $attachment)
                                                <tr>
                                                    @php
                                                        $naming = "";
                                                        $filename = explode('.',$attachment->name)[0];
                                                        switch ($filename) {
                                                            case 'ba_file':
                                                                $naming = "berita acara merk/tipe lain";
                                                                break;
                                                            
                                                            case 'old_item':
                                                                $naming = "foto barang lama untuk replace";
                                                                break;
                                                            
                                                            default:
                                                                $naming = $filename;
                                                                break;
                                                        }
                                                    @endphp
                                                    <td width="40%">{{$naming}}</td>
                                                    <td width="60%" class="tdbreak"><a href="/storage{{$attachment->path}}" download="{{$attachment->name}}">tampilkan attachment</a></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                                @if ($item->ticket_item_file_requirement->count() > 0)
                                    <table class="table table-borderless table-sm">
                                        <tbody>
                                            @foreach ($item->ticket_item_file_requirement as $requirement)
                                                <tr>
                                                    <td width="40%">{{$requirement->file_completement->name}}</td>
                                                    <td width="60%" class="tdbreak"><a href="/storage{{$requirement->path}}" download="{{$requirement->name}}">tampilkan attachment</a></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </td>
                            <td>
                                @if($item->isCancelled)
                                Item telah dihapus oleh <b>{{$item->cancelled_by_employee()->name}}</b><br>
                                Alasan : {{$item->cancel_reason}}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <h5 class="font-weight-bold">Validasi Kelengkapan Berkas</h5>
            <div class="row px-2">
                @php
                    $count_file = 0;
                    foreach($ticket->ticket_item as $item){
                        foreach($item->ticket_item_file_requirement as $requirement){
                            $count_file++;
                        }
                    }
                @endphp
                @if ($count_file == 0)
                    Tidak ada berkas kelengkapan
                @else
                    @foreach($ticket->ticket_item as $item)
                    <div class="col-md-6">
                        <h5>{{$item->name}}</h5><br>
                        <table class="table table-sm">
                            <tbody>
                            @foreach($item->ticket_item_attachment as $attachment)
                            @php
                                $naming = "";
                                $filename = explode('.',$attachment->name)[0];
                                switch ($filename) {
                                    case 'ba_file':
                                        $naming = "berita acara merk/tipe lain";
                                        break;
                                    
                                    case 'old_item':
                                        $naming = "foto barang lama untuk replace";
                                        break;
                                    
                                    default:
                                        $naming = $filename;
                                        break;
                                }
                            @endphp
                            <tr>
                                <td width="20%">{{$naming}}</td>
                                <td width="30%" class="tdbreak"><a href="/storage/{{$attachment->path}}" download="{{$attachment->name}}">tampilkan attachment</a></td>
                                @if($attachment->status == 0)
                                <td colspan="2">
                                    <span class="text-warning">
                                        Menunggu Proses Validasi Data
                                    </span><br>
                                    @if ($attachment->revised_by != null)
                                        Revised by : <b>{{$attachment->revised_by_employee()->name}}</b>
                                    @endif
                                </td>
                                @endif
                                @if($attachment->status == 1)
                                <td colspan="2">
                                    <b class="text-success">Confirmed</b><br>
                                    {{$attachment->updated_at->translatedFormat('d F Y (H:i)')}}<br>
                                    Confirmed by <b>{{$attachment->confirmed_by_employee()->name}}</b>
                                </td>
                                @endif
                                @if($attachment->status == -1)
                                <td>
                                    <b class="text-danger">Rejected</b><br>
                                    {{$attachment->updated_at->translatedFormat('d F Y (H:i)')}}<br>
                                    by <b>{{$attachment->rejected_by_employee()->name}}</b><br>
                                    Alasan : {{$attachment->reject_notes}}
                                </td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm mt-2" onclick="selectfile(this)">Pilih File Perbaikan</button>
                                    <input class="inputFile" type="file" style="display:none;">
                                    <div class="display_field mt-1"></div>
                                    <button type="button" class="btn btn-primary btn-sm mt-2" onclick="uploadfile({{$attachment->id}},'attachment',this)">Upload File Perbaikan</button>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                            @foreach($item->ticket_item_file_requirement as $requirement)
                            <tr>
                                <td width="20%">{{$requirement->file_completement->name}}</td>
                                <td width="30%" class="tdbreak"><a href="/storage/{{$requirement->path}}" download="{{$requirement->name}}">tampilkan attachment</a></td>
                                @if($requirement->status == 0)
                                <td colspan="2">
                                    <span class="text-warning">
                                        Menunggu Proses Validasi Data
                                    </span><br>
                                    @if ($requirement->revised_by != null)
                                        Revised by : <b>{{$requirement->revised_by_employee()->name}}</b>
                                    @endif
                                </td>
                                @endif
                                @if($requirement->status == 1)
                                <td colspan="2">
                                    <b class="text-success">Confirmed</b><br>
                                    {{$requirement->updated_at->translatedFormat('d F Y (H:i)')}}<br>
                                    Confirmed by <b>{{$requirement->confirmed_by_employee()->name}}</b>
                                </td>
                                @endif
                                @if($requirement->status == -1)
                                <td>
                                    <b class="text-danger">Rejected</b><br>
                                    {{$requirement->updated_at->translatedFormat('d F Y (H:i)')}}<br>
                                    by <b>{{$requirement->rejected_by_employee()->name}}</b><br>
                                    Alasan : {{$requirement->reject_notes}}
                                </td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm mt-2" onclick="selectfile(this)">Pilih File Perbaikan</button>
                                    <input class="inputFile" type="file" style="display:none;">
                                    <div class="display_field mt-1"></div>
                                    <button type="button" class="btn btn-primary btn-sm mt-2" onclick="uploadfile({{$requirement->id}},'file',this)">Upload File Perbaikan</button>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="col-md-12 box p-3 mt-3">
            <h5 class="font-weight-bold">Daftar Vendor</h5>
            <table class="table table-bordered table_vendor">
                <thead>
                    <tr>
                        <th>Kode Vendor</th>
                        <th>Nama Vendor</th>
                        <th>Sales Person</th>
                        <th>Telfon</th>
                        <th>Tipe</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ticket->ticket_vendor as $vendor)   
                    <tr>
                        <td>
                            @if($vendor->vendor() != null)
                            {{$vendor->vendor()->code}}
                            @else
                            -
                            @endif
                        </td>
                        <td>{{$vendor->name}}</td>
                        <td>{{$vendor->salesperson}}</td>
                        <td>{{$vendor->phone}}</td>
                        <td>{{$vendor->type()}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @if($ticket->ba_vendor_filename != null && $ticket->ba_vendor_filepath != null)
                <b> Berita Acara </b><br>
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-sm">
                            <tbody>
                                <tr>
                                    <td width="20%">Berita acara untuk pengajuan dengan satu vendor</td>
                                    <td width="30%" class="tdbreak"><a href="/storage/{{$ticket->ba_vendor_filepath}}" download="{{$ticket->ba_vendor_filename}}">tampilkan attachment</a></td>
                                    @if($ticket->ba_status == 0)
                                    <td colspan="2">
                                        <span class="text-warning">
                                            Menunggu Proses Validasi Data
                                        </span><br>
                                        @if ($ticket->ba_revised_by != null)
                                            Revised by : <b>{{$ticket->ba_revised_by_employee()->name}}</b>
                                        @endif
                                    </td>
                                    @endif
                                    @if($ticket->ba_status == 1)
                                    <td colspan="2">
                                        <b class="text-success">Confirmed</b><br>
                                        {{$ticket->updated_at->translatedFormat('d F Y (H:i)')}}<br>
                                        Confirmed by <b>{{$ticket->ba_confirmed_by_employee()->name}}</b>
                                    </td>
                                    @endif
                                    @if($ticket->ba_status == -1)
                                    <td>
                                        <b class="text-danger">Rejected</b><br>
                                        {{$ticket->updated_at->translatedFormat('d F Y (H:i)')}}<br>
                                        by <b>{{$ticket->ba_rejected_by_employee()->name}}</b><br>
                                        Alasan : {{$ticket->ba_reject_notes}}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm mt-2" onclick="selectfile(this)">Pilih File Perbaikan</button>
                                        <input class="inputFile" type="file" style="display:none;">
                                        <div class="display_field mt-1"></div>
                                        <button type="button" class="btn btn-primary btn-sm mt-2" onclick="uploadfile({{$ticket->id}},'vendor',this)">Upload File Perbaikan</button>
                                    </td>
                                    @endif
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
        @if ($ticket->ticket_additional_attachment->count() > 0)
            <div class="col-md-12">
                <h5>Attachment Tambahan</h5>
                @foreach ($ticket->ticket_additional_attachment as $attachment)
                    <a href="/storage/{{$attachment->path}}" download="{{$attachment->name}}">{{$attachment->name}}</a><br>
                @endforeach
            </div>
        @endif
        <div class="col-md-12 box p-3 my-3">
            <div class="font-weight-bold h5">Urutan Otorisasi</div>
            <div class="authorization_list_field row row-cols-md-3 row-cols-2 p-3">
                @foreach ($ticket->ticket_authorization as $author)
                    <div class="mb-3"><span class="font-weight-bold">{{$author->employee->name}} -- {{$author->employee->employee_position->name}}</span><br><span>{{$author->as}}</span></div>
                @endforeach
            </div>
        </div>
    </div>
    

    <div class="d-flex justify-content-center mt-3 bottom_action">
        @if ($ticket->status == 1)
            @if (Auth::user()->id == $ticket->current_authorization()->employee->id)
            <button type="button" class="btn btn-danger mr-2" onclick="reject()" id="rejectbutton">Reject</button>
            <button type="button" class="btn btn-success" onclick="approve()" id="approvebutton">Approve</button>
            @endif
        @endif
    </div>
</div>
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Status pengadaan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <h5>Status saat ini :</h5>
                @if ($ticket->status == 1)
                    Menunggu Otorisasi {{$ticket->current_authorization()->employee_name}} <b>({{$ticket->current_authorization()->as}})</b>
                @endif
                @if ($ticket->status == 2)
                    Menunggu Proses Bidding
                @endif
                <table class="table table-borderless">
                    <thead>
                        <tr class="font-weight-bold">
                            <td>Nama</td>
                            <td>Posisi</td>
                            <td>Tanggal Approval</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ticket->ticket_authorization as $auth)
                            <tr>
                                <td>
                                    <b>{{$auth->employee_name}}</b><br>
                                    {{$auth->employee_position}}
                                </td>
                                <td>
                                    {{$auth->as}}
                                </td>
                                <td>
                                    @if($auth->status == 1)
                                        {{$auth->updated_at->translatedFormat('d F Y (H:i)')}}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<form action="/uploadticketfilerevision" method="post" enctype="multipart/form" id="uploadrevisionform">
    @method('patch')
    @csrf
    <div class="input_field"></div>
</form>
<form action="/approveticket" method="post" id="approveform">
    @method('patch')
    @csrf
    <input type="hidden" name="id" value="{{$ticket->id}}">    
    <input type="hidden" name="updated_at" value="{{$ticket->updated_at}}">
</form>
<form action="/rejectticket" method="post" id="rejectform">
    @method('patch')
    @csrf
    <input type="hidden" name="id" value="{{$ticket->id}}">    
    <input type="hidden" name="updated_at" value="{{$ticket->updated_at}}">
</form>

@endsection
@section('local-js')
<script>
    function approve() {
        $('#approveform').submit();
    }

    function reject() {
        var reason = prompt("Harap memasukan alasan penolakan");
        if (reason != null) {
            if(reason.trim() == ''){
                alert("Alasan Harus diisi");
                return;
            }
            $('#rejectform').append('<input type="hidden" name="reason" value="' + reason + '">');
            $('#rejectform').submit();
        }
    }

    function selectfile(el){
        $(el).closest('td').find('.inputFile').click();
    }

    function uploadfile(id,type,el){
        let linkfile = $(el).closest('td').find('.revision_file');
        if(linkfile.length == 0){
            alert('Silahkan pilih file revisi untuk di upload terlebih dahulu');
        }else{
            let inputfield = $('#uploadrevisionform').find('.input_field');
            let file = linkfile.prop('href');
            let filename = linkfile.text().trim();
            inputfield.empty();
            inputfield.append('<input type="hidden" name="id" value="' + id + '">');
            inputfield.append('<input type="hidden" name="type" value="' + type + '">');
            inputfield.append('<input type="hidden" name="file" value="'+file+'">');
            inputfield.append('<input type="hidden" name="filename" value="'+filename+'">');
            $('#uploadrevisionform').submit();
        }
    }
    $(document).ready(function(){
        $(this).on('change','.inputFile', function(event){
            var reader = new FileReader();
            let value = $(this).val();
            let display_field = $(this).closest('td').find('.display_field');
            if(validatefilesize(event)){
                reader.onload = function(e) {
                    display_field.empty();
                    let name = value.split('\\').pop().toLowerCase();
                    display_field.append('<a class="revision_file" href="'+e.target.result+'" download="'+name+'">'+name+'</a>');
                }
                reader.readAsDataURL(event.target.files[0]);
            }else{
                $(this).val('');
            }
        });
    });
</script>
@endsection
