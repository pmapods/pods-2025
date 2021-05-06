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
                    <li class="breadcrumb-item active">Pengadaan Barang Jasa</li>
                </ol>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-4">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#selectTicketModal">
                Tambah Pengadaan Baru
            </button>
        </div>
    </div>
</div>
<div class="content-body px-4">
    <div class="table-responsive">
        <table id="ticketDT" class="table table-bordered table-striped dataTable" role="grid">
            <thead>
                <tr role="row">
                    <th>#</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Nama Pembuat Form</th>
                    <th>Nama Pengaju</th>
                    <th>Area</th>
                    <th>Keterangan</th>
                    <th>Tanggal Pengadaan</th>
                    <th>Status</th>
                    <th>Status Otorisasi</th>
                </tr>
            </thead>
            <tbody>
                @php $count = 0 @endphp
                @foreach ($tickets as $ticket)
                    <tr data-ticket="{{ $ticket->row_data() }}"
                        data-ticket_authorization = "{{ $ticket->ticket_authorization }}"
                        data-current_authorization="{{$ticket->current_authorization()}}"
                        data-current_user_id="{{Auth::user()->id}}">
                        <td>{{$count+=1}}</td>
                        <td>{{$ticket->created_at->format('d F Y (H:i)')}}</td>
                        <td>{{$ticket->created_by_employee->name}}</td>
                        <td>{{$ticket->ticket_authorization->sortBy('level')->first()->employee_name }}</td>
                        <td>{{$ticket->salespoint->name}}</td>
                        <td>
                            Jenis Item : <b>{{$ticket->item_type()}}</b><br>
                            Jenis Permintaan : <b>{{$ticket->request_type()}}</b><br>
                            Jenis Budget : <b>{{$ticket->budget_type()}}</b>
                        </td>
                        <td>{{$ticket->requirement_date}}</td>
                        <td>{{$ticket->status()}}</td>
                        <td>
                            @if ($ticket->current_authorization() != null)
                            Menunggu otorisasi : <br><b>{{$ticket->current_authorization()->employee_name}}</b>
                            @else
                            -
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="selectTicketModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Jenis</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <form method="get" action="/addnewticket">
                @csrf
                <div class="modal-body">
                    <div class="form-check">
                        <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="ticketing_type" value="0" checked>
                        Pengadaan Barang Jasa
                      </label>
                    </div>
                    
                    <div class="form-check">
                        <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="ticketing_type" value="1">
                        Pengadaan 1
                      </label>
                    </div>
                    
                    <div class="form-check">
                        <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="ticketing_type" value="2">
                        Pengadaan 2
                      </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Buat Pengadaan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('Operational.ticketing_modal')

@endsection
@section('local-js')
<script>
    $(document).ready(function() {
        var table = $('#ticketDT').DataTable(datatable_settings);
        $('#ticketDT tbody').on('click', 'tr', function () {
            let modal = $('#detailTicket');
            let data_ticket = $(this).data('ticket');
            let data_ticket_authorization = $(this).data('ticket_authorization');
            let current_authorization = $(this).data('current_authorization');
            let current_user_id = $(this).data('current_user_id');

            modal.find('input[name="ticket_id"]').val(data_ticket.id);
            modal.find('input[name="updated_at"]').val(data_ticket.updated_at);

            modal.find('.created_date').val(data_ticket.created_at);
            modal.find('.created_by').val(data_ticket.created_by);
            modal.find('.requirement_date').val(data_ticket.requirement_date);
            modal.find('.salespoint').val(data_ticket.salespoint);
            modal.find('.authorization_list_field').empty();
            data_ticket.authorization_list.forEach((authorization)=>{
                modal.find('.authorization_list_field').append('<div class="col"><b>'+authorization.employee_name+' -- '+authorization.employee_position+'</b><br>'+authorization.as+'</div>');
            });
            modal.find('.item_type').val(data_ticket.item_type);
            modal.find('.request_type').val(data_ticket.request_type);
            modal.find('.budget_type').val(data_ticket.budget_type);

            modal.find('.table_item tbody').empty();
            data_ticket.items.forEach((item)=>{
                let name      = item.name;
                let brand     = item.brand;
                let min_price = (item.min_price) ? setRupiah(item.min_price) : '-';
                let max_price = (item.max_price) ? setRupiah(item.max_price) : '-';
                let price     = setRupiah(item.price);
                let count     = item.count;
                let total     = setRupiah(item.price*item.count);
                modal.find('.table_item tbody').append('<tr class="item_list" data-price="'+price+'" data-count="'+count+'"><td>' + name + '</td><td>' + brand + '</td><td>' + min_price + '</td><td>' + max_price + '</td><td>' + price + '</td><td>'+count+'</td><td>' + total + '</td></tr>');
            });
            modal.find('.reason').val(data_ticket.reason);
            
            modal.find('.table_vendor tbody').empty();
            data_ticket.vendors.forEach((vendor)=>{
                let name         = vendor.name;
                let salesperson  = vendor.salesperson;
                let phone        = vendor.phone;
                let type         = (vendor.type == 0) ? 'terdaftar' : 'one time';
                modal.find('.table_vendor tbody').append('<tr class="vendor_item_list"><td>'+name+'</td><td>'+salesperson+'</td><td>'+phone+'</td><td>'+type+'</td></tr>');
            });

            let status_table = modal.find('.status_table tbody');
            status_table.empty();
            
            data_ticket_authorization.forEach((item)=>{
                let status = '';
                let updated_at = moment(item.updated_at).format('YYYY-MM-DD h:mm a');
                updated_at = updated_at.toLocaleString();
                switch (item.status) {
                    case 0:
                        status = 'Menunggu Konfirmasi';
                        updated_at = '-';
                        break;
                    case 1:
                        status = 'Approve';
                        break;
                    case 2:
                        status = 'Reject';
                        break;
                    default:
                        break;
                }
                status_table.append('<tr><td>'+item.employee_name+' -- '+item.employee_position+'</td><td>'+status+'</td><td>'+updated_at+'</td></tr>');
            });
            // jika ada pembatalan
            console.log(data_ticket);
            if(data_ticket.status == 3){
                modal.find('.termination_reason').show();
                modal.find('.termination_reason').empty();
                modal.find('.termination_reason').append('<b>Alasan Pembatalan</b><br>'+data_ticket.termination_reason +'<b> ( pembatalan oleh '+data_ticket.terminated_by+') </b>');
            }else{
                modal.find('.termination_reason').hide();
            }

            // button control
            if(data_ticket.status == 0){
                modal.find('.startauthorization').show();
                modal.find('.cancelticket').show();
            }else{
                modal.find('.startauthorization').hide();
                modal.find('.cancelticket').hide();
            }
            
            if(data_ticket.status == 1){
                if(current_authorization.employee_id == current_user_id){
                    modal.find('.approve').show();
                    modal.find('.reject').show();
                }else{
                    modal.find('.approve').hide();
                    modal.find('.reject').hide();
                }
            }else{
                modal.find('.approve').hide();
                modal.find('.reject').hide();
            }
            modal.modal('show');
        });
    });
    function startauthorization(){
        let modal = $('#detailTicket');
        let form = modal.find('#startauthorizationform');
        if(confirm('Pastikan data yang di input sudah benar. Lanjutkan ?')){
            form.submit();
        }
    }
    function reject(){
        let modal = $('#detailTicket');
        let form = modal.find('#rejectform');
        let reason = prompt("Masukkan alasan penolakan");
        if(reason){
            reason.trim();
        }
        if (reason == null || reason == "") {
            alert('Alasan tidak boleh kosong');
        } else {
            form.find('.input_field').empty();
            form.find('.input_field').append('<input type="hidden" name="reason" value="'+reason+'">');
            form.submit();
        }
    }
    function approve(){
        let modal = $('#detailTicket');
        let form = modal.find('#approveform');
        if(confirm('Approve tidak dapat di revisi dan sistem akan meneruskan approval. Lanjutkan ?')){
            form.submit();
        }else{
            alert('Approve dibatalkan');
        }
    }
</script>

<script src="js/ticketing.js"></script>
@endsection
