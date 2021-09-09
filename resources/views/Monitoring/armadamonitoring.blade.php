@extends('Layout.app')
@section('local-css')

<style>
    #pills-tab .nav-link{
        background-color: #a01e2b48;
        color: black !important;
    }
    #pills-tab .nav-link.active{
        background-color: #A01E2A;
        color: white !important;
    }
</style>
@endsection

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Monitoring Armada</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Monitoring</li>
                    <li class="breadcrumb-item active">Monitoring Armada</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="content-body px-4">
    <ul class="nav nav-pills flex-column flex-sm-row mb-3" id="pills-tab" role="tablist">
        <li class="flex-sm-fill text-sm-center nav-item mr-1" role="presentation">
          <a class="nav-link active" id="pills-po-tab" data-toggle="pill" href="#pills-po" role="tab" aria-controls="pills-po" aria-selected="true">Monitoring PO</a>
        </li>
        <li class="flex-sm-fill text-sm-center nav-item ml-1" role="presentation">
          <a class="nav-link" id="pills-status-tab" data-toggle="pill" href="#pills-status" role="tab" aria-controls="pills-status" aria-selected="false">Monitoring Status</a>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-po" role="tabpanel" aria-labelledby="pills-po-tab">
            <table id="monitoringPO" class="table table-bordered dataTable" role="grid">
                <thead>
                    <tr>
                        <td>Nomor PO</td>
                        <td>Jenis Pengadaan PO terkait</td>
                        <td>Tanggal PO</td>
                        <td>Vendor</td>
                        <td>Salespoint</td>
                        <td>Nopol Armada</td>
                        <td>Jenis Armada</td>
                    </tr>
                </thead>
                <tbody>
    
                    @foreach ($pos as $po)
                        <tr>
                            <td>{{ $po->no_po_sap }}</td>
                            <td>{{ $po->armada_ticket->type() }}</td>
                            <td>{{ $po->updated_at->translatedFormat('d F Y')}}</td>
                            <td>{{ $po->armada_ticket->vendor_name }}</td>
                            <td>{{ $po->armada_ticket->salespoint->name }}</td>
                            <td>{{ $po->armada_ticket->armada->plate }}</td>
                            <td>{{ $po->armada_ticket->armada_type->brand_name }} {{ $po->armada_ticket->armada_type->name }}</td>
                        </tr>
                    @endforeach
                    @foreach ($end_kontrak_tickets as $ticket)
                        @php
                            $po = $ticket->po_reference;
                        @endphp
                        <tr class="table-danger">
                            <td>{{ $po->no_po_sap }}</td>
                            <td>End Kontrak</td>
                            <td>{{ $po->updated_at->translatedFormat('d F Y')}}</td>
                            <td>{{ $po->armada_ticket->vendor_name }}</td>
                            <td>{{ $po->armada_ticket->salespoint->name }}</td>
                            <td>{{ $po->armada_ticket->armada->plate }}</td>
                            <td>{{ $po->armada_ticket->armada_type->brand_name }} {{ $po->armada_ticket->armada_type->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="pills-status" role="tabpanel" aria-labelledby="pills-status-tab">
            <table id="monitoringStatus" class="table table-bordered table-striped dataTable" role="grid">
                <thead>
                    <tr role="row">
                        <th>
                            #
                        </th>
                        <th>
                            Kode Pengadaan
                        </th>
                        <th>
                            SalesPoint
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
</div>

<div class="modal fade" id="monitoringmodal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Monitoring PO (<span id="modal_po_number"></span>)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <table class="table table-borderless" id="armada_monitoring_table">
                        <thead>
                            <tr>
                                <th>PO Number</th>
                                <th>Tanggal</th>
                                <th>Jenis Pengadaan</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

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
        var table = $('#monitoringPO').DataTable(datatable_settings);
        var table_status = $('#monitoringStatus').DataTable(datatable_settings);
        $('#monitoringPO tbody').on('click', 'tr', function () {
            let po_number = $(this).find('td:eq(0)').text().trim();
            $('#monitoringmodal').modal('show');
            $('#modal_po_number').text(po_number);
            $('#armada_monitoring_table tbody').empty();
            $.ajax({
                type: "get",
                url: "/armadamonitoringpologs/" + po_number,
                success: function (response) {
                    let data = response.data;
                    data.forEach(log => {
                        let row_element = '<tr>';
                        row_element += '<td>'+log.po_number+'</td>';
                        row_element += '<td>'+log.date+'</td>';
                        row_element += '<td>'+log.type+'</td>';
                        row_element += '</tr>';
                        $('#armada_monitoring_table tbody').append(row_element);
                    });
                },
                error: function (response) {
                    alert("error");
                }
            });
        });
        $('#monitoringStatus tbody').on('click', 'tr', function () {
            let code = $(this).find('td:eq(1)').text().trim();
            let armada_ticket_id = $(this).data('ticket_id');
            let status_column_el = $(this).find('td:eq(5)');
            $.ajax({
                type: "get",
                url: "/armadamonitoringticketlogs/" + code,
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
