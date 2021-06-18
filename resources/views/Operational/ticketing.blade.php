@extends('Layout.app')
@section('local-css')
@endsection

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Pengadaan Barang Jasa @if(request()->get('status') == -1) (History) @endif</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Operasional</li>
                    <li class="breadcrumb-item active">Pengadaan Barang Jasa @if(request()->get('status') == -1) (History) @endif</li>
                </ol>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-4">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#selectTicketModal">
                Tambah Pengadaan Baru
            </button>
            @if(request()->get('status') == -1)
                <a href="/ticketing" class="btn btn-primary ml-2">Pengadaan Aktif</a>
            @else
                <a href="/ticketing?status=-1" class="btn btn-info ml-2">History</a>
            @endif
        </div>
    </div>
</div>
<div class="content-body px-4">
    <div class="table-responsive">
        <table id="ticketDT" class="table table-bordered table-striped dataTable" role="grid">
            <thead>
                <tr role="row">
                    <th>#</th>
                    <th>Kode</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Nama Pembuat Form</th>
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
                    <tr data-id="{{$ticket->id}}">
                        <td>{{$count+=1}}</td>
                        <td>{{$ticket->code}}</td>
                        <td>{{$ticket->created_at->translatedFormat('d F Y (H:i)')}}</td>
                        <td>
                            @if (isset($ticket->created_by))
                                {{$ticket->created_by_employee->name}}
                            @endif
                        </td>
                        <td>
                            {{$ticket->salespoint->name}}
                        </td>
                        <td>
                            Jenis Item : <b>
                                @if (isset($ticket->item_type))
                                    {{$ticket->item_type()}}
                                @endif
                            </b><br>
                            Jenis Permintaan : <b>
                                @if (isset($ticket->request_type))
                                    {{$ticket->request_type()}}
                                @endif
                            </b><br>
                            Jenis Budget : <b>
                                @if (isset($ticket->budget_type))
                                    {{$ticket->budget_type()}}
                                @endif
                            </b>
                        </td>
                        <td>
                            @if (isset($ticket->requirement_date))
                                {{\Carbon\Carbon::parse($ticket->requirement_date)->translatedFormat('d F Y')}}
                            @endif
                        </td>
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
                        Pengadaan Security
                      </label>
                    </div>
                    
                    <div class="form-check">
                        <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="ticketing_type" value="2">
                        Pengadaan Armada
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
@endsection
@section('local-js')
<script>
    $(document).ready(function() {
        var table = $('#ticketDT').DataTable(datatable_settings);
        $('#ticketDT tbody').on('click', 'tr', function () {
            let id = $(this).data('id');
            let code = $(this).find('td:eq(1)').text().trim();
            if(code != ""){
                window.location.href = '/ticketing/'+code;
            }else{
                window.location.href = '/ticketing/'+id;
            }
        });
    });
</script>

@endsection
