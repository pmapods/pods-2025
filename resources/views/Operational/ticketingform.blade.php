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
                                @foreach ($item->ticket_item_attachment as $attachment)
                                    <a href="/storage{{$attachment->path}}" download="{{$attachment->name}}">{{$attachment->name}}</a><br>
                                @endforeach
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary" onclick="openselectionvendor({{$item->id}})">Seleksi Vendor</button>
                                {{-- <button type="button" class="btn btn-info" >Detail</button> --}}
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
        <button type="button" class="btn btn-info" onclick="addRequest(0)" id="draftbutton">Simpan Sebagai Draft</button>
        <button type="button" class="btn btn-primary" onclick="startauthorization()" id="startauthorizationbutton">Mulai Otorisasi</button>
        <button type="button" class="btn btn-danger" onclick="reject()" id="rejectbutton" style="display:none">Reject</button>
        <button type="button" class="btn btn-success" onclick="approve()" id="approvebutton" style="display:none">Approve</button>
    </div>
</div>
<form action="/addticket" method="post" enctype="multipart/form-data" id="addform">
    @csrf
    <input type="hidden" name="id" class="ticket_id">    
    <input type="hidden" name="updated_at" class="updated_at">
    <div id="input_field">

    </div>
</form>
<form action="/startauthorization" method="post" id="startauthorizationform">
    @method('patch')
    @csrf
    <input type="hidden" name="id" class="ticket_id">    
    <input type="hidden" name="updated_at" class="updated_at">
</form>
<form action="/approveticket" method="post" id="approveform">
    @method('patch')
    @csrf
    <input type="hidden" name="id" class="ticket_id">    
    <input type="hidden" name="updated_at" class="updated_at">
</form>
<form action="/rejectticket" method="post" id="refectform">
    @method('patch')
    @csrf
    <input type="hidden" name="id" class="ticket_id">    
    <input type="hidden" name="updated_at" class="updated_at">
</form>

@endsection
@section('local-js')
<script>
</script>
<script src="/js/ticketingdetail.js"></script>
@if (Request::is('ticketing/*'))
<script>
    $(document).ready(function() {
        let user = @json(Auth::user());
        let current_auth = @json($ticket->current_authorization());
        let ticket = @json($ticket);
        let ticket_items = @json($ticket->ticket_items_with_attachments());
        let ticket_vendors = @json($ticket->ticket_vendors_with_additional_data());
        let ticket_additional_attachments = @json($ticket->ticket_additional_attachment);
        // console.log(ticket_vendors);
        $('.ticket_id').val(ticket["id"]);
        $('.updated_at').val(ticket["updated_at"]);
        if(ticket['salespoint_id']){
            $('.salespoint_select2').val(ticket['salespoint_id']);
            $('.salespoint_select2').trigger('change');
        }
        setTimeout(function(){ 
            if(ticket['authorization_id'] != null){
                $('.authorization_select2').val(ticket['authorization_id']); 
                $('.authorization_select2').trigger('change'); 
            }
            if(ticket['item_type'] != null){
                $('.item_type').val(ticket['item_type']);
                $('.item_type').trigger('change');
            }
            if(ticket['request_type'] != null){
                $('.request_type').val(ticket['request_type']);
                $('.request_type').trigger('change');
            }
            if(ticket['budget_type'] != null){
                $('.budget_type').val(ticket['budget_type']);
                $('.budget_type').trigger('change');
            }
            if(ticket_items.length > 0){
                $('.salespoint_select2').prop('disabled',true);
                $('.authorization_select2').prop('disabled',true);
                $('.request_type').prop('disabled',true);
                $('.item_type').prop('disabled',true);
                $('.budget_type').prop('disabled',true);
            }
        },1500);
        if(ticket_items.length > 0){
            $('.table_item tbody').empty();

        }
        ticket_items.forEach(function(item,index){
            let naming = item.name;
            if(item.expired_date != null){
                naming = item.name+'<br>(expired : '+item.expired_date+')';
            }
            let attachments_link = '-';
            item.attachments.forEach(function(attachment,i){
                if(i==0) attachments_link = "";
                attachments_link  += '<a class="attachment" href="/storage'+attachment.path+'" download="'+attachment.name+'">'+attachment.name+'</a><br>';
            })
            $('.table_item tbody').append('<tr class="item_list" data-id="' + item.id + '" data-name="' + item.name + '" data-price="' + item.price + '" data-count="' + item.count + '" data-brand="' + item.brand + '" data-type="' + item.type + '" data-expired="'+item.expired_date+'"><td>'+naming+'</td><td>' + item.brand + '</td><td>' + item.type + '</td><td>' + setRupiah(item.price) + '</td><td>' + item.count + '</td><td>' + setRupiah(item.count * item.price) + '</td><td>' + attachments_link + '</td><td><i class="fa fa-trash text-danger remove_list" onclick="removeList(this)" aria-hidden="true"></i></td></tr>');
        });
        $('.reason').val(ticket.reason);
        if(ticket_vendors.length > 0){
            $('.table_vendor').find('tbody').empty();
        }
        ticket_vendors.forEach(function(vendor,index){
            let type = (vendor.type == 0) ? 'Terdaftar' : 'One Time Vendor';
            let code = (vendor.code == null) ? '-' : vendor.code;
            $('.table_vendor').find('tbody').append('<tr class="vendor_item_list" data-id="'+vendor.id+'"><td>'+code+'</td><td>'+vendor.name+'</td><td>'+vendor.salesperson+'</td><td>'+vendor.phone+'</td><td>'+type+'</td><td><i class="fa fa-trash text-danger" onclick="removeVendor(this)" aria-hidden="true"></i></td></tr>');
        });
        if(ticket_vendors.length < 2){
            // need ba
            $('.vendor_ba_field').show();
            $('#vendor_ba_preview').prop('href','/storage'+ticket.ba_vendor_filepath);
            $('#vendor_ba_preview').prop('download',ticket.ba_vendor_filename);
        }else{
            // no need ba
            $('.vendor_ba_field').hide();
            $('.vendor_ba_file').val('');
        }
        $('#attachment_list').empty();
        ticket_additional_attachments.forEach(function(attachment,index){
            $('#attachment_list').append('<div><a class="opt_attachment" href="/storage'+attachment.path+'" download="'+attachment.name+'">'+attachment.name+'</a><span class="remove_attachment">X</span></div>')
        });
        // draftbutton
        // startauthorizationbutton
        // rejectbutton
        // approvebutton
        if(ticket['status'] == 1){
            $('#draftbutton').hide();
            $('#startauthorizationbutton').hide();
        }
        if(user['id'] == current_auth['employee_id']){
            $('#rejectbutton').show();
            $('#approvebutton').show();
        }
    })
</script>
@endif
@endsection
