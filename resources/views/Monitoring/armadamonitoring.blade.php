@extends('Layout.app')
@section('local-css')

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
        <table id="monitoringDT" class="table table-bordered dataTable" role="grid">
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

<script>
    $('#exampleModal').on('show.bs.modal', event => {
        var button = $(event.relatedTarget);
        var modal = $(this);
        // Use above variables to manipulate the DOM
        
    });
</script>
@endsection
@section('local-js')
<script>
    $(document).ready(function(){
        var table = $('#monitoringDT').DataTable(datatable_settings);
        $('#monitoringDT tbody').on('click', 'tr', function () {
            let po_number = $(this).find('td:eq(0)').text().trim();
            $('#monitoringmodal').modal('show');
            $('#modal_po_number').text(po_number);
            $('#armada_monitoring_table tbody').empty();
            $.ajax({
                type: "get",
                url: "/armadamonitoringlogs/" + po_number,
                success: function (response) {
                    let data = response.data;
                    console.log(data);
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
    });
</script>
@endsection
