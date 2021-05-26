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
                        <td>{{$ticket->updated_at->format('d F Y (H:i)')}}</td>
                    </tr>
                    <tr>
                        <td><b>Tanggal Pengadaan</b></td>
                        <td>{{\Carbon\Carbon::parse($ticket->requirement_date)->format('d F Y')}}</td>
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
                        <th>Nama Item</th>
                        <th>Merk</th>
                        <th>Type</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th>Attachment</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ticket->ticket_item as $item)
                        <tr>
                            <td>{{$item->name}}</td>
                            <td>{{$item->brand}}</td>
                            <td>{{$item->type}}</td>
                            <td class="rupiah_text">{{$item->price}}</td>
                            <td>{{$item->count}}</td>
                            <td class="rupiah_text">{{$item->price * $item->count}}</td>
                            <td>
                                @if ($item->ticket_item_attachment->count() > 0)
                                    @foreach ($item->ticket_item_attachment as $attachment)
                                        <a href="/storage{{$attachment->path}}" download="{{$attachment->name}}">{{$attachment->name}}</a><br>
                                    @endforeach
                                @else
                                    -
                                @endif
                                @if ($item->ticket_item_file_requirement->count() > 0)
                                    <br>
                                    <b>Kelengkapan Berkas</b><br>
                                    <table class="table table-borderless table-sm">
                                        @foreach ($item->ticket_item_file_requirement as $requirement)
                                            <tr>
                                                <td width="40%">{{$requirement->file_completement->name}}</td>
                                                <td width="60%"><a href="/storage{{$requirement->path}}" download="{{$requirement->name}}">tampilkan attachment</a></td>
                                            </tr>
                                        @endforeach
                                    </table>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary" onclick="openselectionvendor({{$item->id}})">Seleksi Vendor</button>
                                {{-- <button type="button" class="btn btn-info" >Detail</button> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <h5 class="font-weight-bold">Validasi Kelengkapan Berkas</h5>
            <div class="row">
                @foreach($ticket->ticket_item as $item)
                <div class="col-md-6">
                    <h5>{{$item->name}}</h5><br>
                    <table class="table table-sm">
                        <tbody>
                        @foreach($item->ticket_item_file_requirement as $requirement)
                        <tr>
                            <td>{{$requirement->file_completement->name}}</td>
                            <td><a href="/storage/{{$requirement->path}}" download="{{$requirement->name}}">tampilkan attachment</a></td>
                            @if($requirement->status == 0)
                            <td class="align-middle">
                                <button type="button" class="btn btn-success btn-sm" onclick="confirm({{$requirement->id}})">Confirm</button>
                            </td>
                            <td class="align-middle">
                                <button type="button" class="btn btn-danger btn-sm" onclick="reject({{$requirement->id}})">Reject</button>
                            </td>
                            @endif
                            @if($requirement->status == 1)
                            <td colspan="2">
                                <b class="text-success">Confirmed</b><br>{{$requirement->updated_at->format('d F Y (H:i)')}}
                            </td>
                            @endif 
                            @if($requirement->status == -1)
                            <td colspan="2">
                                <b class="text-danger">Rejected</b><br>
                                {{$requirement->updated_at->format('d F Y (H:i)')}}<br>
                                Alasan : {{$requirement->reject_notes}}
                            </td>
                            @endif
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @endforeach
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
                <a href="/storage/{{$ticket->ba_vendor_filepath}}" download="{{$ticket->ba_vendor_filename}}">{{$ticket->ba_vendor_filename}}</a>

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
@endsection
@section('local-js')
<script>
    function openselectionvendor(item_id) {
        window.location.href = window.location.href+'/'+item_id;
    }
    function confirm($requirement_id) {
        $('#confirmform .input_list').empty();
        $('#confirmform .input_list').append('<input type="hidden" name="ticket_file_requirement_id" value="'+$requirement_id+'">');
        $('#confirmform').submit();
    }

    function reject(requirement_id) {
        var reason = prompt("Harap memasukan alasan penolakan");
        $('#rejectform .input_list').empty();
        if (reason != null || reason != "") {
            $('#rejectform .input_list').append('<input type="hidden" name="ticket_file_requirement_id" value="' + requirement_id + '">');
            $('#rejectform .input_list').append('<input type="hidden" name="reason" value="' + reason + '">');
            $('#rejectform').submit();
        } else {
            alert("Alasan harus diisi")
        }
    }
</script>
@endsection
