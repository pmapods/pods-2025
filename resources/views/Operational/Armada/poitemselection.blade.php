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
                <h1 class="m-0 text-dark">Setting PO</h1>
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
        $item_name = $armadaticket->armada_type()->brand_name.' '.$armadaticket->armada_type()->name;
        
        $namabiaya = ($armadaticket->ticketing_type == 2) ? 'Mutasi' : 'Sewa';
    @endphp
    <input type="hidden" name="armada_ticket_id" value="{{$armadaticket->id}}">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
              <label class="required_field">Nama Vendor</label>
              <input type="text" class="form-control" name="vendor_name" placeholder="Masukan nama vendor" required>
            </div>
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
                        <input type="hidden" name="sewa_name" value="{{ $namabiaya }} Armada {{ $item_name }}">
                        {{ $namabiaya }} Armada {{ $item_name }}
                        <div class="form-group">
                          <textarea class="form-control" 
                          rows="3" 
                          style="resize: none" 
                          placeholder="notes"
                          name="sewa_notes"></textarea>
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
                <option value="prorate">Prorate Sewa {{ $item_name }}</option>
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
@endsection
@section('local-js')
<script>
    $(document).ready(function(){
        $('.autonumber').change(function(){
            autonumber($(this));
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
                append_text += '<textarea class="form-control" rows="3" name="prorate_notes" style="resize: none" placeholder="notes"></textarea>';
                append_text += '</div></td>';
                append_text += '<td><input class="form-control autonumber count" onchange="sumRow(this)" name="prorate_count" type="number" value="1" min="1"></td>';
                append_text += '<td><input type="text" name="prorate_value" onchange="sumRow(this)" class="form-control rupiah value" data-a-sign="Rp " data-a-dec="," data-a-sep="." value="0"></td>';
                append_text += '<td class="rupiah_text total">Rp 0,00</td>';
                append_text += '<td class="text-center removelist"><i class="fa fa-times text-danger fa-2x" aria-hidden="true"></i></td></tr>';
                break;

            case 'ekspedisi':
                append_text += '<tr class="ekspedisi"><td>'+text;
                append_text += '<div class="form-group">';
                append_text += '<textarea class="form-control" rows="3" name="ekspedisi_notes" style="resize: none" placeholder="notes"></textarea>';
                append_text += '</div></td>';
                append_text += '<td>1<input type="hidden" class="count" value="1" name="ekspedisi_count"></td>';
                append_text += '<td><input type="text" class="form-control rupiah value" onchange="sumRow(this)" name="ekspedisi_value" data-a-sign="Rp " data-a-dec="," data-a-sep="." value="0"></td>';
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
