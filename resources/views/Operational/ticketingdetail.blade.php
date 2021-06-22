@extends('Layout.app')
@section('local-css')
<style>
    .bottom_action button{
        margin-right: 1em;
    }
    .box {
        background: #FFF;
        box-shadow: 0px 1px 2px rgba(0, 0, 0,0.25);
        border : 1px solid;
        border-color: gainsboro;
        border-radius: 0.5em;
    }
    .select2-results__option--disabled {
        display: none;
    }
    .remove_attachment{
        margin-left: 2em;
        font-weight: bold;
        cursor: pointer;
        color: red;
    }
    .tdbreak{
        /* word-break : break-all; */
    }
    .other_attachments tr td:first-of-type{
        overflow-wrap: anywhere;
        max-width: 300px;
    }
</style>
@endsection

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Pengadaan Barang Jasa @isset($ticket) ({{$ticket->code}}) @else Baru @endisset</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Operasional</li>
                    <li class="breadcrumb-item">Pengadaan</li>
                    <li class="breadcrumb-item active">Pengadaan Barang Jasa @isset($ticket) ({{$ticket->code}}) @else Baru @endisset</li>
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
            <div class="form-group">
                <label class="required_field">Tanggal Pengajuan</label>
                <input type="date" class="form-control created_date" value="{{now()->translatedFormat('Y-m-d')}}" disabled>
                <small class="text-danger">* tanggal pengajuan yang tercatat adalah tanggal sistem saat otorisasi dimulai</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="required_field">Tanggal Pengadaan</label>
                <input type="date" class="form-control requirement_date">
                <small class="text-danger">*Tanggal pengadaan minimal 14 hari dari tanggal pengajuan</small>
            </div>
        </div>
        <div class="col-md-4">
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="required_field">Pembuat Form</label>
                <input type="text" class="form-control form_creator" value="{{Auth::user()->name}}" disabled>
                <small class="text-danger">* Pembuat form yang tercatat di sistem sesuai dengan identitas login saat memulai otorisasi</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="required_field">Pilihan Area / Salespoint</label>
                <select class="form-control select2 salespoint_select2">
                    <option value="" data-isjawasumatra="-1">-- Pilih Salespoint --</option>
                    @foreach ($available_salespoints as $region)
                    <optgroup label="{{$region->first()->region_name()}}">
                        @foreach ($region as $salespoint)
                        <option value="{{$salespoint->id}}"
                            data-isjawasumatra="{{$salespoint->isJawaSumatra}}">{{$salespoint->name}} --
                            {{$salespoint->jawasumatra()}} Jawa Sumatra</option>
                        @endforeach
                    </optgroup>
                    @endforeach
                </select>
                <small class="text-danger">* Salespoint yang muncul berdasarkan hak akses tiap akun</small>
            </div>
            <span class="spinner-border text-danger loading_salespoint_select2" role="status"
                style="display:none">
                <span class="sr-only">Loading...</span>
            </span>
        </div>
        <div class="col-md-4 form-group">
            <label class="required_field">Pilih Otorisasi</label>
            <select class="form-control select2 authorization_select2" disabled>
                <option value="">-- Pilih Otorisasi --</option>
            </select>
            <small class="text-danger">* Pilihan otorisasi yang muncul berdasarkan salespoint yang dipilih.
                Untuk membuat sistem otorisasi dapat melakukan request ke super admin</small>
        </div>
        <div class="col-md-12 box p-3 mb-3">
            <div class="font-weight-bold h5">Urutan Otorisasi</div>
            <div class="authorization_list_field row row-cols-md-3 row-cols-2 p-3">
                <div>Belum memilih otorisasi</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="required_field">Jenis Item</label>
                <select class="form-control item_type">
                    <option value="">-- Pilih Jenis Item --</option>
                    <option value="0">Barang</option>
                    <option value="1">Jasa</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="required_field">Jenis Pengadaan</label>
                <select class="form-control request_type" disabled>
                    <option value="">-- Pilih Jenis Pengadaan --</option>
                    <option value="0">Baru</option>
                    <option value="1">Replace Existing</option>
                    <option value="2">Repeat Order</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="required_field">Jenis Budget</label>
                <select class="form-control budget_type" disabled>
                    <option value="">-- Pilih Jenis Budget --</option>
                    <option value="0">Budget</option>
                    <option value="1">Non Budget</option>
                </select>
            </div>
        </div>
        <div class="col-md-12 box p-3 mt-3">
            <h5 class="font-weight-bold required_field">Daftar Barang</h5>
            <table class="table table-bordered table_item">
                <thead>
                    <tr>
                        <th>Nama Item</th>
                        <th>Merk</th>
                        <th>Tipe</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th>Attachment</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="empty_row text-center">
                        <td colspan="8">Item belum dipilih</td>
                    </tr>
                </tbody>
            </table>
    
            <div class="d-none row justify-content-between budget_item_adder">
                <div class="row col-md-3">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="required_field">Pilih Item</label>
                            <select class="form-control select2 select_budget_item">
                                <option value="">-- Pilih Item Budget --</option>
                                @foreach ($budget_category_items as $item)
                                <optgroup label="{{$item->name}}">
                                    @foreach ($item->budget_pricing as $pricing)
                                    <option value="{{$pricing->id}}" 
                                        data-brand="{{$pricing->budget_brand}}"
                                        data-type="{{$pricing->budget_type}}"
                                        data-categorycode="{{$item->code}}"
                                        data-minjs="{{$pricing->injs_min_price}}"
                                        data-maxjs="{{$pricing->injs_max_price}}"
                                        data-minoutjs="{{$pricing->outjs_min_price}}"
                                        data-maxoutjs="{{$pricing->outjs_max_price}}">{{$pricing->name}}</option>
                                    @endforeach
                                </optgroup>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 budget_expired_field form-group" style="display: none">
                        <label class="optional_field">Expired Date</label>
                        <input type="date" class="form-control form-control-file budget_expired_date">
                        <small class="text-danger">* Hanya untuk pengadaan APAR</small>
                    </div>
                    <div class="col-12 budget_olditem_field" style="display: none">
                        <label class="required_field">Foto Item Lama</label>
                        <input type="file" class="form-control-file budget_olditem_file" accept="image/*,application/pdf">
                        <small class="text-danger">*jpg, jpeg, pdf (MAX 5MB)</small>
                    </div>
                </div>
                <div class="col-md-4 pl-1 row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="required_field">Pilih Merk</label>
                            <select class="form-control select_budget_brand" disabled>
                            </select>
                        </div>
                        <div class="form-group input_budget_brand_field" style="display: none">
                            <label class="required_field">Nama Merk Lain</label>
                            <input class="form-control input_budget_brand">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="required_field">Pilih Tipe</label>
                            <select class="form-control select_budget_type" disabled>
                            </select>
                        </div>
                        <div class="form-group input_budget_type_field" style="display: none">
                            <label class="required_field">Nama Tipe Lain</label>
                            <textarea class="form-control input_budget_type" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="col-12 budget_ba_field" style="display: none">
                        <label class="required_field">Berita Acara</label>
                        <input type="file" class="form-control-file budget_ba_file" accept="application/pdf,application/vnd.ms-excel">
                        <small class="text-danger">*pdf, xls (MAX 5MB)</small>
                    </div>
                </div>
                <div class="form-group col-md-3 pl-1">
                    <label class="required_field">Harga Item</label>
                    <input class="form-control rupiah price_budget_item">
                    <small>
                        Area : <span class="font-weight-bold area_status">-</span><br>
                        Harga Minimum : <span class="font-weight-bold item_min_price">-</span><br>
                        Harga Maksimum : <span class="font-weight-bold item_max_price">-</span><br>
                    </small>
                </div>
                <div class="form-group col-md-1 pl-1">
                    <label class="required_field">Jumlah</label>
                    <input type="number" class="form-control count_budget_item">
                </div>
                <div class="form-group col-md-1 pl-1">
                    <label>&nbsp</label>
                    <button type="button" class="btn btn-primary form-control"
                        onclick="addBudgetItem(this)">Tambah</button>
                </div>
            </div>
    
            <div class="d-none row justify-content-between nonbudget_item_adder">
                <div class="row col-md-3">
                    <div class="col-12">
                        <div class="form-group">
                          <label class="required_field">Nama Item</label>
                          <input type="text" class="form-control input_nonbudget_name">
                        </div>
                    </div>
                    <div class="col-12 nonbudget_olditem_field" style="display: none">
                        <label class="required_field">Foto Item Lama</label>
                        <input type="file" class="form-control-file nonbudget_olditem_file" accept="image/*,application/pdf">
                        <small class="text-danger">*jpg, jpeg, pdf (MAX 5MB)</small>
                    </div>
                </div>
                <div class="col-md-4 pl-1 row">
                    <div class="col-6">
                        <div class="form-group">
                          <label class="required_field">Merk</label>
                          <input type="text" class="form-control input_nonbudget_brand">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                          <label class="required_field">Tipe</label>
                          <textarea class="form-control input_nonbudget_type" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-3 pl-1">
                    <label class="required_field">Harga Item</label>
                    <input class="form-control rupiah price_nonbudget_item">
                </div>
                <div class="form-group col-md-1 pl-1">
                    <label class="required_field">Jumlah</label>
                    <input type="number" class="form-control count_nonbudget_item">
                </div>
                <div class="form-group col-md-1 pl-1">
                    <label>&nbsp</label>
                    <button type="button" class="btn btn-primary form-control"
                        onclick="addNonBudgetItem()">Tambah</button>
                </div>
            </div>
        </div>
    
        <div class="col-md-12 mt-3">
            <div class="form-group">
                <label class="required_field">Alasan Pengadaan Barang atau Jasa</label>
                <textarea class="form-control reason" rows="3"></textarea>
            </div>
        </div>
    
        <div class="col-md-12 box p-3 mt-3">
            <h5 class="font-weight-bold required_field">Daftar Vendor</h5>
            <table class="table table-bordered table_vendor">
                <thead>
                    <tr>
                        <th>Kode Vendor</th>
                        <th>Nama Vendor</th>
                        <th>Sales Person</th>
                        <th>Telfon</th>
                        <th>Tipe</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <div class="row">
                <div class="col-md-4">
                    <h5>Vendor Terdaftar</h5>
                    <div class="form-group">
                        <label class="required_field">Pilih Vendor</label>
                        <select class="form-control select2 select_vendor">
                            <option value="">-- Pilih Vendor --</option>
                            @foreach ($vendors as $vendor)
                            <option value="{{$vendor->id}}" 
                                data-id="{{$vendor->id}}"
                                data-code="{{$vendor->code}}"
                                data-name="{{$vendor->name}}"
                                data-salesperson="{{$vendor->salesperson}}"
                                >{{$vendor->name}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="addVendor(this)">Tambah Vendor
                        Terdaftar</button>
                </div>
                <div class="col-md-8">
                    <h5>One Time Vendor</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="required_field">Nama Vendor</label>
                                <input type="text" class="form-control ot_vendor_name"
                                    placeholder="Masukan nama vendor">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="required_field">Sales Person</label>
                                <input type="text" class="form-control ot_vendor_sales"
                                    placeholder="Masukkan nama sales">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="required_field">Telfon</label>
                                <input type="text" class="form-control ot_vendor_phone"
                                    placeholder="Masukkan nomor telfon">
                            </div>
                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-primary" onclick="addOTVendor(this)">Tambah
                                One Time Vendor</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group vendor_ba_field">
                      <label class="required_field">Berita Acara</label>
                      <input type="file" class="form-control-file vendor_ba_file" accept="application/pdf,application/vnd.ms-excel">
                      <small class="text-danger">* Wajib menyertakan berita acara untuk pemilihan satu vendor (.pdf/xls MAX 5MB)</small><br>
                      <a href="" download="" id="vendor_ba_preview">tampilkan berita acara</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center mt-3 bottom_action">
        <button type="button" class="btn btn-info" onclick="addRequest(0)" id="draftbutton">Simpan Sebagai Draft</button>
        <button type="button" class="btn btn-primary" onclick="addRequest(1)" id="startauthorizationbutton">Mulai Otorisasi</button>
        @isset ($ticket->code)
        <button type="button" class="btn btn-danger" onclick="deleteTicket()" id="deleteticketbutton">Hapus Form</button>
        @endisset
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
<form action="/deleteticket" method="post" enctype="multipart/form-data" id="deleteform">
    @method('delete')
    @csrf
    <input type="hidden" name="code" class="ticket_code">
</form>

<!-- Modal -->
<div class="modal fade" id="filesmodal" tabindex="-1" role="dialog" aria-hidden="true">
    <input type="hidden" class="itempos">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kelengkapan Berkas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <small class="text-danger">* file max 5MB</small>
                @foreach ($filecategories as $filecategory)
                    <h5>{{$filecategory->name}}<br></h5>
                    <table class="table table-striped tablefiles">
                        <thead>
                            <tr>
                                <th>Pilih</th>
                                <th>Nama Kelengkapan</th>
                                <th colspan="2">File terpilih</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($filecategory->file_completements as $file_completement)
                            <tr data-file_completement_id="{{$file_completement->id}}" data-name="{{$file_completement->name}}">
                                <td class="align-middle">
                                    <input type="checkbox" class="file_check">
                                </td>
                                <td class="align-middle" width="350">{{$file_completement->name}}</td>
                                <td class="align-middle">
                                    <button class="btn btn-info file_button_upload" disabled>upload</button>
                                    <input class="inputFile" type="file" style="display:none;">
                                </td>
                                <td class="align-middle tdbreak">
                                    <a class="file_url">-</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary button_save_files">Save</button>
            </div>
        </div>
    </div>
</div>

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

        $('.ticket_id').val(ticket["id"]);
        $('.ticket_code').val(ticket["code"]);
        $('.updated_at').val(ticket["updated_at"]);
        if(ticket["requirement_date"]){
            $('.requirement_date').val(ticket["requirement_date"]);
        }
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
            $('.table_item tbody:eq(0)').empty();
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
            });
            let files_data = [];
            let other_attachment ="<table class='other_attachments small table table-sm table-borderless'><tbody>";
            item.files.forEach(function(file,i){
                let data;
                data = {
                    id: file.id,
                    file_completement_id: file.file_completement_id,
                    file: '/storage/'+file.path,
                    filename: file.name,
                    name: file.name
                };
                other_attachment += "<tr><td>"+data.filename+"</td>"
                other_attachment += "<td><a href='"+data.file+"' download='"+data.name+"'>tampilkan</a></td></tr>";
                files_data.push(data);
            });
            other_attachment += "</tbody></table>";
            attachments_link += other_attachment;

            $('.table_item tbody:eq(0)').append('<tr class="item_list" data-id="' + item.id + '" data-budget_pricing_id="'+ item.budget_pricing_id+'" data-name="' + item.name + '" data-price="' + item.price + '" data-count="' + item.count + '" data-brand="' + item.brand + '" data-type="' + item.type + '" data-expired="'+item.expired_date+'"><td>'+naming+'</td><td>' + item.brand + '</td><td>' + item.type + '</td><td>' + setRupiah(item.price) + '</td><td>' + item.count + '</td><td>' + setRupiah(item.count * item.price) + '</td><td>' + attachments_link + '</td><td><i class="fa fa-trash text-danger remove_list mr-3" onclick="removeList(this)" aria-hidden="true"></i><button type="button" class="btn btn-primary btn-sm filesbutton">kelengkapan berkas</button></td></tr>');

            $('.table_item tbody:eq(0) .item_list').last().data('files',files_data);
        });
        $('.reason').val(ticket.reason);
        if(ticket_vendors.length > 0){
            $('.table_vendor').find('tbody').empty();
        }
        ticket_vendors.forEach(function(vendor,index){
            let type = (vendor.type == 0) ? 'Terdaftar' : 'One Time Vendor';
            let code = (vendor.code == null) ? '-' : vendor.code;
            $('.table_vendor').find('tbody').append('<tr class="vendor_item_list" data-vendor_id="'+vendor.vendor_id+'" data-id="'+vendor.id+'"><td>'+code+'</td><td>'+vendor.name+'</td><td>'+vendor.salesperson+'</td><td>'+vendor.phone+'</td><td>'+type+'</td><td><i class="fa fa-trash text-danger" onclick="removeVendor(this)" aria-hidden="true"></i></td></tr>');
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
            $('#attachment_list').append('<div><a class="opt_attachment" href="/storage'+attachment.path+'" download="'+attachment.name+'">tampilkan attachment</a><span class="remove_attachment">X</span></div>')
        });
    });
    function deleteTicket(){
        $('#deleteform').submit();
    }
</script>
@endif
@endsection
