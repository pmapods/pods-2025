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
                <h1 class="m-0 text-dark">Pengadaan Security Baru</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Operasional</li>
                    <li class="breadcrumb-item">Pengadaan</li>
                    <li class="breadcrumb-item active">Pengadaan Security Baru</li>
                </ol>
            </div>
        </div>
        <div class="d-flex justify-content-end">
        </div>
    </div>
</div>
<div class="content-body">
    <form action="/createsecurityticket" id="securityform" method="post">
        @csrf
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="required_field">Tanggal Pengajuan</label>
                    <input type="date" class="form-control created_date" value="{{now()->translatedFormat('Y-m-d')}}" disabled>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label class="required_field">Tanggal Setup</label>
                    <input type="date" class="form-control requirement_date" name="requirement_date" required>
                    <small class="text-danger">*Tanggal pengadaan minimal 14 hari dari tanggal pengajuan</small>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label class="required_field">Pilihan Area / SalesPoint</label>
                    <select class="form-control select2 salespoint_select2" name="salespoint_id" required>
                        <option value="" data-isjawasumatra="-1">-- Pilih SalesPoint --</option>
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
                    <small class="text-danger">* SalesPoint yang muncul berdasarkan hak akses tiap akun</small>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <div class="form-group">
                  <label class="required_field">Tipe Pengadaan Security</label>
                  <select class="form-control" name="ticketing_type" id="ticketing_type" required disabled>
                    <option value="">-- Pilih Tipe --</option>
                    <option value="0">Pengadaan</option>
                    <option value="1">Perpanjangan</option>
                    <option value="2">Replace</option>
                    <option value="3">End Sewa</option>
                  </select>
                </div>
            </div>
            <div class="col-4" id="po_field">
                <div class="form-group">
                  <label>Pilih PO</label>
                  <select class="form-control" name="po_number" id="po_select" disabled>
                    <option value="">-- Pilih PO Lama --</option>
                  </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                  <label class="required_field">Pilih Otorisasi</label>
                  <select class="form-control" id="authorization" name="authorization_id" disabled required>
                    <option value="">-- Pilih Otorisasi --</option>
                  </select>
                  <small class="text-danger">*otorisasi yang muncul berdasarkan pilihan salespoint</small>
                </div>
            </div>
            <div class="col-12 d-flex flex-row justify-content-center align-items-center" id="authorization_field">
            </div>
        </div>
        </div>
        <div class="d-flex justify-content-center mt-3">
            <button type="submit" class="btn btn-primary">Buat Ticket Security</button>
        </div>
    </form>
</div>

@endsection
@section('local-js')
<script>
$(document).ready(function () {
    // set minimal tanggal pengadaan 14 setelah tanggal pengajuan
    $('.requirement_date').val(moment().add(14,'days').format('YYYY-MM-DD'));
    $('.requirement_date').prop('min',moment().add(14,'days').format('YYYY-MM-DD'));
    $('.requirement_date').trigger('change');

    $('.salespoint_select2').change(function() {
        let salespoint_id = $(this).val();
        $('#ticketing_type').prop('disabled',true);
        $('#ticketing_type').val("");
        loadAuthorizationbySalespoint(salespoint_id);
        if(salespoint_id != ""){
            $('#ticketing_type').prop('disabled',false);
        }
        $('#ticketing_type').trigger('change');
    });

    $('#ticketing_type').change(function(){
        $('#po_select').val("");
        $('#po_select').trigger('change');
        $('#po_select').find('option[value!=""]').remove();
        $('#po_select').prop('disabled',true);
        switch ($(this).val()) {
            case '0':
                // Pengadaan
                break;
                
            case '1':
                // Perpanjangan
                $('#po_select').prop('disabled',false);
                break;
                
            case '2':
                // Replace
                $('#po_select').prop('disabled',false);
                break;
                
            case '3':
                // End Sewa
                $('#po_select').prop('disabled',false);
                break;
        
            default:
                break;
        }
    });

    $('#authorization').change(function() {
        let list = $(this).find('option:selected').data('list');
        $('#authorization_field').empty();
        if(list !== undefined){
            list.forEach(function(item,index){
                $('#authorization_field').append('<div class="d-flex text-center flex-column mr-3"><div class="font-weight-bold">'+item.sign_as+'</div><div>'+item.employee.name+'</div><div class="text-secondary">('+item.employee_position.name+')</div></div>');
                if(index != list.length -1){
                    $('#authorization_field').append('<div class="mr-3"><i class="fa fa-chevron-right" aria-hidden="true"></i></div>');
                }
            });
        }
    });
});


function loadAuthorizationbySalespoint(salespoint_id){
    $('#authorization').find('option[value!=""]').remove();
    $('#authorization').prop('disabled', true);
    if(salespoint_id == ""){
        return;
    }
    $.ajax({
        type: "get",
        url: '/getSecurityAuthorizationbySalespoint/'+salespoint_id,
        success: function (response) {
            let data = response.data;
            if(data.length == 0){
                alert('Otorisasi Pengadaan Security tidak tersedia untuk salespoint yang dipilih, silahkan mengajukan otorisasi ke admin');
                return;
            }
            data.forEach(item => {
                let namelist = item.list.map(a => a.employee_name);
                let option_text = '<option value="'+item.id+'">'+namelist.join(" -> ")+'</option>';
                $('#authorization').append(option_text);
            });
            $('#authorization').val("");
            $('#authorization').trigger('change');
            $('#authorization').prop('disabled', false);
        },
        error: function (response) {
            alert('load data failed. Please refresh browser or contact admin');
            $('#authorization').find('option[value!=""]').remove();
            $('#authorization').prop('disabled', true);
        },
        complete: function () {
            $('#authorization').val("");
            $('#authorization').trigger('change');
            $('#authorization').prop('disabled', false);
        }
    });
}

</script>
@endsection
