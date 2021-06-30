@extends('Layout.app')
@section('local-css')

@endsection

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Monitoring Pengadaan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Monitoring</li>
                    <li class="breadcrumb-item active">Monitoring Pengadaan</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="content-body px-4">
    <div class="table-responsive">
        <table id="monitoringDT" class="table table-bordered table-striped dataTable" role="grid">
            <thead>
                <tr role="row">
                    <th>
                        #
                    </th>
                    <th>
                        Kode Pengadaan
                    </th>
                    <th>
                        Salespoint
                    </th>
                    <th>
                        Tanggal Mulai Pengadaan
                    </th>
                    <th>
                        Lama Pengadaan (hari)
                    </th>
                    <th>
                        Status saat ini
                    </th>
            </thead>
            <tbody>
                @foreach ($tickets as $key=>$ticket)
                    <tr data-status="{{$ticket->status()}}" data-ticket_id="{{$ticket->id}}">
                        <td>{{$key+1}}</td>
                        <td>{{$ticket->code}}</td>
                        <td>{{$ticket->salespoint->name}}</td>
                        <td>{{$ticket->created_at->translatedFormat('d F Y')}}</td>
                        <td>{{$ticket->created_at->diffForHumans(now())}}</td>
                        <td>{{$ticket->status()}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="monitormodal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Monitoring (<span class="code"></span>)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <table class="table table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th>Aktivitas</th>
                            <th>Oleh</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div>status saat ini : <b class="status">Dalam Proses Bidding oleh tim Purchasing</b></div>
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
    $(document).ready(function(){
        var table = $('#monitoringDT').DataTable(datatable_settings);
        $('#monitoringDT tbody').on('click', 'tr', function () {
            let code = $(this).find('td:eq(1)').text().trim();
            let ticket_id = $(this).data('ticket_id');
            let status_column_el = $(this).find('td:eq(5)');
            $.ajax({
                type: "get",
                url: "/ticketmonitoringlogs/" + ticket_id,
                success: function (response) {
                    let logs = []
                    $('#monitormodal').find('table tbody tr').remove();
                    let data = response.data;
                    let status = response.status;
                    data.forEach(log => {
                        let row_element = '<tr>';
                        row_element += '<td style="width:60%; overflow-wrap: anywhere">'+log.message+'</td>';
                        row_element += '<td>'+log.employee_name+'</td>';
                        row_element += '<td>'+log.date+'</td>';
                        row_element += '</tr>';
                        $('#monitormodal').find('table tbody').append(row_element);
                    });
                    $('#monitormodal').find('.status').text(status);
                    console.log(status_column_el.text());
                    status_column_el.text(status);
                },
                error: function (response) {
                    alert("error");
                }
            });
            $('#monitormodal').find('.code').text(code);
            $('#monitormodal').modal('show');
        });
    });
</script>
@endsection
