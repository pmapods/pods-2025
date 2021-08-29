@extends('Layout.app')
@section('local-css')
<style>
    .table td,
    .table th {
        vertical-align: middle !important;
    }
</style>
@endsection

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Setting PO ({{ $securityticket->type() }} Security)</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Operasional</li>
                    <li class="breadcrumb-item">Purchase Requisition</li>
                    <li class="breadcrumb-item active">Setting PO ({{$securityticket->code}})</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="content-body">
    <form action="/setupPO" method="post" id="setupForm">
        @csrf
        @php
            $item_name = "Sewa Jasa Security";
        @endphp
        <input type="hidden" name="security_ticket_id" value="{{$securityticket->id}}">
        <div class="row mb-3">
            <div class="col-9 row">
                @php
                    $sewa_notes = '';
                    switch ($securityticket->type()) {
                        case 'Pengadaan Baru':
                            $edit_vendor = true;
                            $show_old_vendor = false;
                            $sewa_notes .= $securityticket->type().' untuk '.$securityticket->salespoint->name."\r\n";
                            break;

                        case 'Perpanjangan':
                            $edit_vendor = false;
                            $show_old_vendor = true;
                            $sewa_notes .= $securityticket->type().' untuk PO '.$securityticket->po_reference->no_po_sap."\r\n";
                            break;

                        case 'Replace':
                            $edit_vendor = true;
                            $show_old_vendor = true;
                            $sewa_notes .= $securityticket->type().' untuk PO '.$securityticket->po_reference->no_po_sap."\r\n";
                            break;

                        case 'End Kontrak':
                            break;
                    }
                @endphp
                @if ($show_old_vendor)
                    <div class="col">
                        <div class="form-group">
                          <label>Vendor Lama</label>
                          <input type="text" class="form-control" 
                          value="{{ $securityticket->po_reference->security_ticket->vendor_name }}"
                          name="old_vendor" readonly>
                        </div>
                    </div>
                @endif
                @if ($edit_vendor)
                    <div class="col">
                        <div class="form-group">
                          <label class="required_field">Vendor Baru / Pilihan</label>
                          <input type="text" class="form-control" 
                          name="new_vendor" required>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-3 d-flex flex-column align-items-end justify-content-center">
                @if (in_array($securityticket->type(),['Perpanjangan','Replace']))
                    <a href="modalInfo" class="font-weight-bold text-primary" data-toggle="modal" data-target="#modalInfo">
                        Tampilkan Form Evaluasi
                    </a>
                @endif
                @if ($securityticket->po_reference != null)
                <a class="font-weight-bold text-info"
                    onclick="window.open('/storage/{{ $securityticket->po_reference->external_signed_filepath }}')">
                    Tampilkan PO Sebelumnya ({{ $securityticket->po_reference->no_po_sap }})</a>
                @endif
            </div>
        </div>
        <div class="row">
            <table class="table table-bordered" id="table_list">
                <thead>
                    <tr class="thead-dark">
                        <th>Nama Barang</th>
                        <th width="8%">Qty</th>
                        <th width="30%">Harga Satuan (Rp)</th>
                        <th width="30%">Total Harga</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <input type="hidden" id="unit_name_input" name="sewa_name"
                                value="{{ $item_name }}">
                            {{ $item_name }}
                            <div class="form-group mt-1">
                                <textarea class="form-control form-control-sm" rows="2" style="resize: none"
                                    placeholder="notes" name="sewa_notes">{{ $sewa_notes }}</textarea>
                            </div>
                        </td>
                        <td>
                            <input class="form-control autonumber count" onchange="sumRow(this)" type="number"
                                name="sewa_count" value="1" min="1">
                        </td>
                        <td>
                            <input type="text" class="form-control rupiah value" name="sewa_value" onchange="sumRow(this)">
                        </td>
                        <td class="rupiah_text total">0</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <center>
            <button type="button" class="btn btn-primary" onclick="doSubmit()">Submit</button>
            <button type="submit" class="btn btn-primary d-none">Submit</button>
        </center>
    </form>
</div>

<div class="modal fade" id="modalInfo" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-body">
                @switch($securityticket->type())
                    @case('Pengadaan Baru')
                        @break
                    @case('Perpanjangan')
                        @include('Operational.Security.formevaluasi')
                        @break
                    @case('Replace')
                        @include('Operational.Security.formevaluasi')
                        @break
                    @case('End Sewa')
                        @include('Operational.Security.formevaluasi')
                        @break
                    @default
                        @break
                @endswitch
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection
<form action="" id="submitform">
    @csrf
    <div></div>
</form>
@section('local-js')
<script>
    $(document).ready(function () {
        $('.autonumber').change(function () {
            autonumber($(this));
        });
        $('#unit_selection').change(function () {
            $('#unit_name_span').text($(this).find('option:selected').text());
            $('#unit_name_input').val($(this).find('option:selected').text());
        });
    });
    $(document).on('click', '.removelist', function () {
        let tr = $(this).closest('tr');
        let className = tr.prop('class');
        $('#additional_cost_select').find('option[value="' + className + '"]').prop('disabled', false);

        tr.remove();
    });

    function doSubmit() {
        if (confirm('Pastikan semua nilai telah terinput dengan benar !. Lanjutkan?')) {
            $('#setupForm').find('button[type="submit"]').trigger('click');
        }
    }

    function addAdditionalCost() {
        let selection = $('#additional_cost_select').val();
        let text = $('#additional_cost_select').find('option:selected').text();
        let append_text = "";
        if (selection == "") {
            alert('Tambahan biaya belum dipilih');
            return;
        }
        $('#additional_cost_select option:selected').prop('disabled', true);
        $('#additional_cost_select').val("");
        $('#additional_cost_select').trigger('change');
        switch (selection) {
            case 'prorate':
                append_text += '<tr class="prorate"><td>' + text;
                append_text += '<div class="form-group">';
                append_text +=
                    '<textarea class="form-control form-control-sm" rows="2" name="prorate_notes" style="resize: none" placeholder="notes"></textarea>';
                append_text += '</div></td>';
                append_text +=
                    '<td><input class="form-control autonumber count" onchange="sumRow(this)" name="prorate_count" type="number" value="1" min="1"></td>';
                append_text +=
                    '<td><input type="text" name="prorate_value" onchange="sumRow(this)" class="form-control rupiah value" data-a-sign="Rp " data-a-dec="," data-a-sep="." value="0"></td>';
                append_text += '<td class="rupiah_text total">Rp 0,00</td>';
                append_text +=
                    '<td class="text-center removelist"><i class="fa fa-times text-danger fa-2x" aria-hidden="true"></i></td></tr>';
                break;

            case 'ekspedisi':
                append_text += '<tr class="ekspedisi"><td>' + text;
                append_text += '<div class="form-group">';
                append_text +=
                    '<textarea class="form-control form-control-sm" rows="2" name="ekspedisi_notes" style="resize: none" placeholder="notes"></textarea>';
                append_text += '</div></td>';
                append_text += '<td>1<input type="hidden" class="count" value="1" name="ekspedisi_count"></td>';
                append_text +=
                    '<td><input type="text" class="form-control rupiah value" onchange="sumRow(this)" name="ekspedisi_value" data-a-sign="Rp " data-a-dec="," data-a-sep="." value="0">';
                append_text +=
                    '<small class="text-danger">Total Biaya Ekspedisi akan dibagi berdasarkan jumlah (Qty) biaya sewa</small></td>';
                append_text += '<td class="rupiah_text total">Rp 0,00</td>';
                append_text +=
                    '<td class="text-center removelist"><i class="fa fa-times text-danger fa-2x" aria-hidden="true"></i></td></tr>';
                break;

            default:
                break;
        }
        $('#table_list tbody').append(append_text);
        let tr = $('#table_list tbody tr').last();
        tr.find('.autonumber').change(function () {
            autonumber($(this));
        });
        new AutoNumeric("#table_list tbody tr:last-child .rupiah", autonum_setting);
    }

    function sumRow(el) {
        let tr = $(el).closest('tr');
        let value = tr.find('.value').val();
        let count = tr.find('.count').val();
        value = AutoNumeric.unformat(value, autonum_setting);
        let total = count * value;

        tr.find('.total').text(setRupiah(total));
    }
</script>
@endsection