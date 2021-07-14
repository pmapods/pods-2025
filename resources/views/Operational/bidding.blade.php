@extends('Layout.app')
@section('local-css')

@endsection

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Bidding @if(request()->get('status') == -1) (History) @endif</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Operasional</li>
                    <li class="breadcrumb-item active">Bidding @if(request()->get('status') == -1) (History) @endif</li>
                </ol>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-4">
            @if(request()->get('status') == -1)
                <a href="/bidding" class="btn btn-primary ml-2">Bidding Aktif</a>
            @else
                <a href="/bidding?status=-1" class="btn btn-info ml-2">History</a>
            @endif
        </div>
    </div>
</div>
<div class="content-body px-4">
    <div class="table-responsive">
        <table id="biddingDT" class="table table-bordered table-striped dataTable" role="grid">
            <thead>
                <tr role="row">
                    <th>
                        #
                    </th>
                    <th>
                        Kode Form Pengadaan
                    </th>
                    <th>
                        Nama Pengaju
                    </th>
                    <th>
                        Area
                    </th>
                    <th>
                        Tanggal Permintaan
                    </th>
                    <th>
                        Tanggal Pengajuan
                    </th>
                    <th>Status Bidding</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tickets as $key => $ticket)
                <tr>    
                    <td>{{$key+1}}</td>
                    <td>{{$ticket->code}}</td>
                    <td>{{$ticket->created_by_employee->name}}</td>
                    <td>{{$ticket->salespoint->name}}</td>
                    <td>{{$ticket->updated_at->translatedFormat('d F Y (H:i)')}}</td>
                    <td>{{\Carbon\Carbon::parse($ticket->requirement_date)->translatedFormat('d F Y')}}</td>
                    <td>
                        @php
                            $current_waiting_authorizations = [];
                            foreach($ticket->ticket_item as $ticket_item){
                                if($ticket_item->bidding->current_authorization() != null){
                                    array_push($current_waiting_authorizations,$ticket_item->bidding->current_authorization()->employee_name);
                                }
                            }
                        @endphp
                        @if (count($current_waiting_authorizations) > 0)   
                            Menunggu otorisasi dari {{ implode(', ', array_unique($current_waiting_authorizations))}}
                        @else
                            @if ($ticket->status == 3)
                                Otorisasi Selesai
                            @else
                                Menunggu proses pembuatan form bidding
                            @endif
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
@section('local-js')
<script>
    $(document).ready(function(){
        var table = $('#biddingDT').DataTable(datatable_settings);
        $('#biddingDT tbody').on('click', 'tr', function () {
            let code = $(this).find('td').eq(1).text().trim();
            window.location.href="/bidding/"+code;
        });
    })
</script>
@endsection
