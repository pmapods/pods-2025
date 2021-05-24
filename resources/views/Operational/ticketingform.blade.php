@extends('Layout.app')
@section('local-css')
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
                        <th width="10%">Nama Item</th>
                        <th width="10%">Merk</th>
                        <th width="10%">Type</th>
                        <th width="10%">Harga Satuan</th>
                        <th>Jumlah</th>
                        <th width="10%">Total</th>
                        <th>Attachment</th>
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
                                                <td width="60%"><a href="/storage{{$requirement->path}}" download="{{$requirement->name}}">{{$requirement->name}}</a></td>
                                            </tr>
                                        @endforeach
                                    </table>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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

    <div class="d-flex justify-content-center mt-3 bottom_action">
        @if (Auth::user()->id == $ticket->current_authorization()->employee->id)
        <button type="button" class="btn btn-danger mr-2" onclick="reject()" id="rejectbutton">Reject</button>
        <button type="button" class="btn btn-success" onclick="approve()" id="approvebutton">Approve</button>
        @endif
    </div>
</div>
<form action="/approveticket" method="post" id="approveform">
    @method('patch')
    @csrf
    <input type="hidden" name="id" value="{{$ticket->id}}">    
    <input type="hidden" name="updated_at" value="{{$ticket->updated_at}}">
</form>
<form action="/rejectticket" method="post" id="refectform">
    @method('patch')
    @csrf
    <input type="hidden" name="id" value="{{$ticket->id}}">    
    <input type="hidden" name="updated_at" value="{{$ticket->updated_at}}">
</form>

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
                Menunggu Otorisasi {{$ticket->current_authorization()->employee_name}} <b>({{$ticket->current_authorization()->as}})</b>
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
                                        {{$auth->updated_at->format('d F Y (H:i)')}}
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
@endsection
@section('local-js')
<script>
    function approve() {
        $('#approveform').submit();
    }

    function reject() {
        var reason = prompt("Harap memasukan alasan penolakan");
        if (reason != null || reason != "") {
            $('#rejectform').append('<input type="hidden" name="reason" value="' + reason + '">');
            $('#rejectform').submit();
        } else {
            alert("Alasan harus diisi")
        }
    }
</script>
@endsection
