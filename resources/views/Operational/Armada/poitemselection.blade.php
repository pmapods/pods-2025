@extends('Layout.app')
@section('local-css')
    <style>
        .table td, .table th{
            vertical-align: middle !important;
        }
    </style>
@endsection

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Setting PO ({{ $armadaticket->type() }} Armada)</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Operasional</li>
                    <li class="breadcrumb-item">Purchase Requisition</li>
                    <li class="breadcrumb-item active">Setting PO ({{$armadaticket->code}})</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="content-body">
    <form action="/setupPO" method="post" id="setupForm">
    @csrf
    @php
        $item_name = "";
        if(in_array($armadaticket->type(),['Pengadaan','Mutasi'])){
            $item_name = $armadaticket->armada_type->brand_name.' '.$armadaticket->armada_type->name;
        }
    @endphp
    <input type="hidden" name="armada_ticket_id" value="{{$armadaticket->id}}">
    <div class="row mb-3">
        <div class="col-md-9 row">
            @php
                $sewa_notes = '';

                $old_armada_type = "";
                switch ($armadaticket->type()) {
                    case 'Perpanjangan':
                        $show_old_unit = false;
                        $show_old_vendor = false;
                        $edit_vendor = false;
                        $edit_unit = false;
                        $sewa_notes .= $armadaticket->type().' untuk PO '.$armadaticket->po_reference_number."\r\n";
                        $sewa_notes .= 'NOPOL : '.$armadaticket->po_reference->armada_ticket->armada->plate;
                        break;
                        
                    case 'Replace':
                        $show_old_unit = true;
                        $show_old_vendor = true;
                        $edit_vendor = true;
                        $edit_unit = true;
                        $sewa_notes .= $armadaticket->type().' untuk PO '.$armadaticket->po_reference_number."\r\n";
                        break;
                        
                    case 'Renewal':
                        $show_old_unit = true;
                        $show_old_vendor = false;
                        $edit_vendor = false;
                        $edit_unit = true;
                        $sewa_notes .= $armadaticket->type().' untuk PO '.$armadaticket->po_reference_number."\r\n";
                        break;
                        
                    case 'End Kontrak':
                        $show_old_unit = false;
                        $show_old_vendor = false;
                        $edit_vendor = false;
                        $edit_unit = false;
                        break;

                    case 'Mutasi':
                        $sewa_notes .= $armadaticket->type().' Armada NOPOL '.$armadaticket->mutasi_form->nopol."\r\n";
                        $sewa_notes .= 'Dari '.$armadaticket->salespoint->name.' untuk PO '.$armadaticket->po_reference_number."\r\n";
                        break;
                }
            @endphp
            @if ($armadaticket->ticketing_type == 0)
                {{-- pengadaan naru --}}
                <div class="col">
                    <div class="form-group">
                    <label>Rekomendasi Vendor</label>
                    <input type="text" class="form-control"
                    value="{{ $armadaticket->vendor_recommendation_name }}" readonly>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label class="required_field">Vendor Pilihan</label>
                        <select class="form-control" name="selected_vendor" id="selected_vendor" required>
                            @foreach ($armada_vendors as $armada_vendor)
                                <option value="{{ $armada_vendor->name }}">{{ $armada_vendor->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif
            @if ($armadaticket->ticketing_type == 1)
                {{-- perpanjangan replace renewal --}}
                @switch($show_old_vendor)
                    @case(true)
                    @php
                        $old_armada_type = $armadaticket->po_reference->armada_ticket->armada;
                    @endphp
                    <div class="col">
                        <div class="form-group">
                            <label>Unit Vendor Lama</label>
                            <input type="text" class="form-control" 
                            value="{{$armadaticket->po_reference->armada_ticket->vendor_name}}"
                            readonly>
                        </div>
                    </div>
                    @break
                @endswitch
                
                @switch($edit_vendor)
                    @case(true)
                        <div class="col">
                            <div class="form-group">
                                <label>Pilih Vendor</label>
                                <select class="form-control" name="selected_vendor" id="selected_vendor" required>
                                    <option value="">Pilih Vendor</option>
                                    @foreach ($armada_vendors as $armada_vendor)
                                        <option value="{{ $armada_vendor->name }}">{{ $armada_vendor->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @break
                    
                    @case(false)
                        <div class="col">
                            <div class="form-group">
                                <label>Vendor</label>
                                <input type="text" class="form-control" 
                                    name="selected_vendor" id="selected_vendor"
                                    value="{{ $armadaticket->vendor_recommendation_name }}"
                                    readonly>
                            </div>
                        </div>
                    @break
                @endswitch
                
                @switch($show_old_unit)
                    @case(true)
                    @php
                        $old_armada_type = $armadaticket->po_reference->armada_ticket->armada;
                    @endphp
                        <div class="col">
                            <div class="form-group">
                                <label>Unit Lama</label>
                                <input type="text" class="form-control" 
                                value="{{$old_armada_type->plate}} ({{ $old_armada_type->armada_type->brand_name}} {{ $old_armada_type->armada_type->name }})"
                                readonly>
                            </div>
                        </div>
                    @break
                @endswitch
                
                @switch($edit_unit)
                    @case(true)
                        <div class="col">
                            <div class="form-group">
                                <label class="required_field">Pilih Tipe Unit</label>
                                <select class="form-control select2" name="armada_type_id" id="unit_selection" required>
                                    <option value="">Pilih Tipe Unit</option>
                                    @foreach ($armada_types as $type)
                                        <option value="{{ $type->id }}">
                                            {{ $type->brand_name }} {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @break
                    @case(false)
                        <div class="col">
                            <div class="form-group">
                                <label>Unit</label>
                                <input type="text" class="form-control" 
                                    name="selected_unit" id="selected_unit"
                                    value="{{ $armadaticket->po_reference->armada_ticket->armada->plate }}"
                                    readonly>
                                @break
                            </div>
                        </div>
                    @break  
                @endswitch
            @endif
            @if ($armadaticket->ticketing_type == 2)
                {{-- Mutasi --}}
                {{-- sender_salespoint_name --}}
                {{-- receiver_salespoint_name --}}
                <div class="col">
                    <div class="form-group">
                    <label>Asal Salespoint</label>
                    <input type="text" class="form-control"
                    value="{{ $armadaticket->mutasi_form->sender_salespoint_name }}" readonly>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                    <label>Tujuan Salespoint</label>
                    <input type="text" class="form-control"
                    value="{{ $armadaticket->mutasi_form->receiver_salespoint_name }}" readonly>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-md-3 d-flex flex-column align-items-end justify-content-center">
            <a href="modalInfo" class="font-weight-bold text-primary" data-toggle="modal" data-target="#modalInfo">
                Tampilkan Form {{ $armadaticket->type() }}
            </a>
            @if ($armadaticket->po_reference != null)
                <a class="font-weight-bold text-info" 
                onclick="window.open('/storage/{{ $armadaticket->po_reference->external_signed_filepath }}')">
                Tampilkan PO Sebelumnya ({{ $armadaticket->po_reference->no_po_sap }})</a>
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
                        <input type="hidden" id="unit_name_input" name="sewa_name" value="Sewa Armada {{ $item_name }}">
                        Sewa Armada <span id="unit_name_span">{{ $item_name }}</span>
                        <div class="form-group mt-1">
                          <textarea class="form-control form-control-sm" 
                          rows="2" 
                          style="resize: none" 
                          placeholder="notes"
                          name="sewa_notes">{{ $sewa_notes }}</textarea>
                        </div>
                    </td>
                    <td>
                        <input class="form-control autonumber count" 
                            onchange="sumRow(this)" 
                            type="number" 
                            name="sewa_count"
                            value="1" 
                            min="1">
                    </td>
                    <td><input type="text" 
                        class="form-control rupiah value" 
                        name="sewa_value"
                        onchange="sumRow(this)"></td>
                    <td class="rupiah_text total">0</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <div class="d-flex flex-row align-items-center">
            <div class="form-group">
              <label for="">Tambahan Biaya</label>
              <select class="form-control" id="additional_cost_select">
                <option value="">Pilih Tambahan Biaya</option>
                <option value="prorate">Prorate Sewa</option>
                <option value="ekspedisi">Biaya Expedisi</option>
              </select>
            </div>
            <i class="fa fa-2x fa-plus-square pt-3 pl-3" aria-hidden="true" onclick="addAdditionalCost()"></i>
        </div>
    </div>
    <center>
        <button type="button" class="btn btn-primary" onclick="doSubmit('barangjasa')">Submit</button>
        <button type="submit" class="btn btn-primary d-none">Submit</button>
    </center>
    </form>
</div>

<div class="modal fade" id="modalInfo" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                @switch($armadaticket->ticketing_type)
                    @case(0)
                        @include('Operational.Armada.formfasilitas')
                        @break
                    @case(1)
                        @include('Operational.Armada.formperpanjanganperhentian')
                        @break
                    @case(2)                
                        @include('Operational.Armada.formmutasi')
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
@section('local-js')
<script>
    $(document).ready(function(){
        $('.autonumber').change(function(){
            autonumber($(this));
        });
        $('#unit_selection').change(function(){
            $('#unit_name_span').text($(this).find('option:selected').text());
            $('#unit_name_input').val($(this).find('option:selected').text());
        });
    });
    $(document).on('click','.removelist',function(){
        let tr = $(this).closest('tr');
        let className = tr.prop('class');
        $('#additional_cost_select').find('option[value="'+className+'"]').prop('disabled',false);

        tr.remove();
    });
    function doSubmit(type){
        if(confirm('Pastikan semua nilai telah terinput dengan benar !. Lanjutkan?')){
            $('#setupForm').find('button[type="submit"]').trigger('click');
        }
    }   
    function addAdditionalCost(){
        let selection = $('#additional_cost_select').val();
        let text = $('#additional_cost_select').find('option:selected').text();
        let append_text = "";
        if(selection == ""){
            alert('Tambahan biaya belum dipilih');
            return;
        }
        $('#additional_cost_select option:selected').prop('disabled',true);
        $('#additional_cost_select').val("");
        $('#additional_cost_select').trigger('change');
        switch (selection) {
            case 'prorate':
                append_text += '<tr class="prorate"><td>'+text;
                append_text += '<div class="form-group">';
                append_text += '<textarea class="form-control form-control-sm" rows="2" name="prorate_notes" style="resize: none" placeholder="notes"></textarea>';
                append_text += '</div></td>';
                append_text += '<td><input class="form-control autonumber count" onchange="sumRow(this)" name="prorate_count" type="number" value="1" min="1"></td>';
                append_text += '<td><input type="text" name="prorate_value" onchange="sumRow(this)" class="form-control rupiah value" data-a-sign="Rp " data-a-dec="," data-a-sep="." value="0"></td>';
                append_text += '<td class="rupiah_text total">Rp 0,00</td>';
                append_text += '<td class="text-center removelist"><i class="fa fa-times text-danger fa-2x" aria-hidden="true"></i></td></tr>';
                break;

            case 'ekspedisi':
                append_text += '<tr class="ekspedisi"><td>'+text;
                append_text += '<div class="form-group">';
                append_text += '<textarea class="form-control form-control-sm" rows="2" name="ekspedisi_notes" style="resize: none" placeholder="notes"></textarea>';
                append_text += '</div></td>';
                append_text += '<td>1<input type="hidden" class="count" value="1" name="ekspedisi_count"></td>';
                append_text += '<td><input type="text" class="form-control rupiah value" onchange="sumRow(this)" name="ekspedisi_value" data-a-sign="Rp " data-a-dec="," data-a-sep="." value="0">';
                append_text += '<small class="text-danger">Total Biaya Ekspedisi akan dibagi berdasarkan jumlah (Qty) biaya sewa</small></td>';
                append_text += '<td class="rupiah_text total">Rp 0,00</td>';
                append_text += '<td class="text-center removelist"><i class="fa fa-times text-danger fa-2x" aria-hidden="true"></i></td></tr>';
                break;

            default:
                break;
        }
        $('#table_list tbody').append(append_text);
        let tr = $('#table_list tbody tr').last();
        tr.find('.autonumber').change(function() {
            autonumber($(this));  
        });
        new AutoNumeric("#table_list tbody tr:last-child .rupiah",autonum_setting);
    }
    function sumRow(el){
        let tr = $(el).closest('tr');
        let value  = tr.find('.value').val();
        let count  = tr.find('.count').val();
        value = AutoNumeric.unformat(value,autonum_setting);
        let total = count * value;

        tr.find('.total').text(setRupiah(total));
    }
</script>
@endsection
