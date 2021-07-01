@extends('Layout.app')
@section('local-css')
<style>
    .box {
        box-shadow: 0px 1px 2px rgba(0, 0, 0,0.25);
        border : 1px solid;
        border-color: gainsboro;
        border-radius: 0.5em;
    }
</style>
@endsection

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Operasional</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Operasional</li>
                    <li class="breadcrumb-item active">Bidding Detail</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="content-body px-4">
    <h3>{{$ticket->code}}</h3>
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
                <thead class="table-secondary">
                    <tr>
                        <th width="15%">Nama Item</th>
                        <th>Merk</th>
                        <th width="10%">Type</th>
                        <th width="15%">Harga Satuan</th>
                        <th>Jumlah</th>
                        <th width="15%">Total</th>
                        <th width="15%">Attachment</th>
                        <th width="10%">Status</th>
                        <th width="8%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ticket->ticket_item as $item)
                        <tr class="@if($item->isCancelled) table-danger @endif">
                            <td>{{$item->name}}</td>
                            <td>{{$item->brand}}</td>
                            <td>{{$item->type}}</td>
                            <td class="rupiah_text">{{$item->price}}</td>
                            <td>{{$item->count}} {{$item->budget_pricing->uom ?? ''}}</td>
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
                                                    <td width="60%" class="tdbreak"><a href="/storage/{{$attachment->path}}" download="{{$attachment->name}}">tampilkan attachment</a></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                                @if ($item->ticket_item_file_requirement->count() > 0)
                                    <table class="table table-borderless table-sm small">
                                        <tbody>
                                            @foreach ($item->ticket_item_file_requirement as $requirement)
                                                <tr>
                                                    <td width="40%">{{$requirement->file_completement->name}}</td>
                                                    <td width="60%" class="tdbreak"><a class="text-primary" onclick='window.open("/storage/{{$requirement->path}}")'>tampilkan attachment</a></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </td>
                            <td>
                                @if(!$item->isCancelled)
                                    @if($item->bidding)
                                        @if($item->bidding->status == 0 || $item->bidding->status ==1)
                                            <b>Status Otorisasi</b><br>
                                            @if($item->bidding->status==0)
                                                Menunggu Otorisasi oleh <b>{{$item->bidding->current_authorization()->employee->name}}</b>
                                            @endif
                                            @if($item->bidding->status==1)
                                                Otorisasi selesai -- {{$item->bidding->updated_at->translatedFormat('d F Y (H:i)')}}
                                            @endif
                                        @endif

                                        @if($item->bidding->status == -1)
                                            Otorisasi ditolak oleh <b>{{$item->bidding->rejected_by_employee()->name}}</b><br>
                                            Alasan : {{$item->bidding->reject_notes}}
                                        @endif
                                    @endif
                                @else
                                    Dibatalkan oleh <b>{{$item->cancelled_by_employee()->name}}</b><br>
                                    Alasan : {{$item->cancel_reason}}
                                @endif
                            </td>
                            <td>
                                <div class="d-flex flex-wrap">
                                    @if(!$item->isCancelled)
                                        @if($item->bidding)
                                            @if($item->bidding->status == 0 || $item->bidding->status ==1)
                                                <button type="button" class="btn btn-primary btn-sm mr-auto" onclick="openselectionvendor({{$item->id}})">Tampilkan form seleksi</button>
                                            @endif
        
                                            @if($item->bidding->status == -1)
                                                <button type="button" class="btn btn-primary btn-sm mr-auto" onclick="openselectionvendor({{$item->id}})">Revisi form seleksi</button><br>
                                            @endif
                                        @else
                                            <button type="button" class="btn btn-primary mr-auto btn-sm" onclick="openselectionvendor({{$item->id}})"
                                            @if(!$item->isFilesChecked()) disabled @endif>Seleksi Vendor</button>
                                        @endif
                                        @if(($item->bidding->status ?? 0) != 1)
                                        <button type="button" class="btn btn-danger btn-sm mr-auto mt-1" onclick="removeitem({{$item->id}})">Hapus Item</button>
                                        @endif
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <h5 class="font-weight-bold">Validasi Kelengkapan Berkas</h5>
            <div class="row px-2">
                @php
                    $count_file = 0;
                    foreach($ticket->ticket_item as $titem){
                        $count_file += $titem->ticket_item_attachment->count();
                        $count_file += $titem->ticket_item_file_requirement->count();
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
                                <td>{{$naming}}</td>
                                <td><a href="/storage/{{$attachment->path}}" download="{{$attachment->name}}">tampilkan attachment</a></td>
                                @if($attachment->status == 0)
                                <td class="align-middle d-flex">
                                    <button type="button" class="btn btn-success btn-sm mr-2" onclick="confirm({{$attachment->id}},'attachment')">Confirm</button>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="reject({{$attachment->id}},'attachment')">Reject</button>
                                </td>
                                @endif
                                @if($attachment->status == 1)
                                <td colspan="2">
                                    <b class="text-success">Confirmed</b><br>
                                    {{$attachment->updated_at->translatedFormat('d F Y (H:i)')}}
                                    confirmed by <b>{{$attachment->confirmed_by_employee()->name}}</b>
                                </td>
                                @endif 
                                @if($attachment->status == -1)
                                <td colspan="2">
                                    <b class="text-danger">Rejected</b><br>
                                    {{$attachment->updated_at->translatedFormat('d F Y (H:i)')}}<br>
                                    by <b>{{$attachment->rejected_by_employee()->name}}</b><br>
                                    Alasan : {{$attachment->reject_notes}}
                                </td>
                                @endif
                            </tr>
                            @endforeach
                            @foreach($item->ticket_item_file_requirement as $requirement)
                            <tr>
                                <td>{{$requirement->file_completement->name}}</td>
                                <td><a href="/storage/{{$requirement->path}}" download="{{$requirement->name}}">tampilkan attachment</a></td>
                                @if($requirement->status == 0)
                                <td class="align-middle d-flex">
                                    <button type="button" class="btn btn-success btn-sm mr-2" onclick="confirm({{$requirement->id}},'file')">Confirm</button>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="reject({{$requirement->id}},'file')">Reject</button>
                                </td>
                                @endif
                                @if($requirement->status == 1)
                                <td colspan="2">
                                    <b class="text-success">Confirmed</b><br>
                                    {{$requirement->updated_at->translatedFormat('d F Y (H:i)')}}<br>
                                    confirmed by <b>{{$requirement->confirmed_by_employee()->name}}</b>
                                </td>
                                @endif 
                                @if($requirement->status == -1)
                                <td colspan="2">
                                    <b class="text-danger">Rejected</b><br>
                                    {{$requirement->updated_at->translatedFormat('d F Y (H:i)')}}<br>
                                    by <b>{{$attachment->rejected_by_employee()->name}}</b><br>
                                    Alasan : {{$requirement->reject_notes}}
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
                <a href="#" onclick='window.open("/storage/{{$ticket->ba_vendor_filepath}}")'>tampilkan berita acara</a><br>
                @if($ticket->ba_status == 0)
                    <div class="d-flex">
                        <button type="button" class="btn btn-success btn-sm mr-2" onclick="confirm({{$ticket->id}},'vendor')">Confirm</button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="reject({{$ticket->id}},'vendor')">Reject</button>
                    </div>
                @endif
                @if($ticket->ba_status == 1)
                <div>
                    <b class="text-success">Confirmed</b><br>
                    {{$ticket->updated_at->translatedFormat('d F Y (H:i)')}}
                    confirmed by <b>{{$ticket->ba_confirmed_by_employee()->name}}</b>
                </div>
                @endif 
                @if($ticket->ba_status == -1)
                <div>
                    <b class="text-danger">Rejected</b><br>
                    {{$ticket->updated_at->translatedFormat('d F Y (H:i)')}}<br>
                    rejected by <b>{{$ticket->ba_rejected_by_employee()->name}}</b><br>
                    Alasan : {{$ticket->ba_reject_notes}}
                </div>
                @endif
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
    </div>
    <center>
        @if($ticket->status == 2)
        <button type="button" class="btn btn-danger mt-3" onclick="terminateticket()">Batalkan Pengadaan</button>
        @endif
    </center>
</div>
<form action="/confirmticketfilerequirement" method="post" id="confirmform">
    @csrf
    @method('patch')
    <div class="input_list">
    </div>
</form>
<form action="/rejectticketfilerequirement" method="post" id="rejectform">
    @csrf
    @method('patch')
    <div class="input_list">
    </div>
</form>
<form action="/removeticketitem" method="post" id="removeitemform">
    @csrf
    @method('delete')
    <div class="input_list"></div>
</form>
<form action="/terminateticket" method="post" id="terminateform">
    @csrf
    @method('patch')
    <input type="hidden" name="ticket_id" value="{{$ticket->id}}">
</form>
@endsection
@section('local-js')
<script>
    function openselectionvendor(item_id) {
        window.location.href = window.location.href+'/'+item_id;
    }
    function confirm(id,type) {
        $('#confirmform .input_list').empty();
        $('#confirmform .input_list').append('<input type="hidden" name="id" value="'+id+'">');
        $('#confirmform .input_list').append('<input type="hidden" name="type" value="'+type+'">');
        $('#confirmform').submit();
    }

    function reject(id,type) {
        var reason = prompt("Harap memasukan alasan penolakan");
        $('#rejectform .input_list').empty();
        if (reason != null) {
            if(reason.trim() == ''){
                alert("Alasan Harus diisi");
                return
            }
            $('#rejectform .input_list').append('<input type="hidden" name="id" value="' + id + '">');
            $('#rejectform .input_list').append('<input type="hidden" name="type" value="' + type + '">');
            $('#rejectform .input_list').append('<input type="hidden" name="reason" value="' + reason + '">');
            $('#rejectform').submit();
        }
    }

    function removeitem(id){
        var reason = prompt("Harap memasukan alasan penghapusan item");
        $('#removeitemform .input_list').empty();
        if (reason != null) {
            if(reason.trim() == ''){
                alert("Alasan Harus diisi");
                return
            }
            $('#removeitemform .input_list').append('<input type="hidden" name="ticket_item_id" value="' + id + '">');
            $('#removeitemform .input_list').append('<input type="hidden" name="reason" value="' + reason + '">');
            $('#removeitemform').submit();
        }
    }

    function terminateticket(){
        var reason = prompt("PERHATIAN ! Dengan membatalkan pengadaan. Area tidak dapat melakukan revisi terhadap pengadaan ini. Masukkan alasan pembatalan pengadaan");
        if (reason != null) {
            if(reason.trim() == ''){
                alert("Alasan Harus diisi");
                return
            }
            $('#terminateform').append('<input type="hidden" name="reason" value="' + reason + '">');
            $('#terminateform').submit();
        }
    }
</script>
@endsection
