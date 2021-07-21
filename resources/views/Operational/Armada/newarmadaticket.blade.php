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
                <h1 class="m-0 text-dark">Pengadaan Armada @isset($ticket) ({{$ticket->code}}) @else Baru @endisset</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Operasional</li>
                    <li class="breadcrumb-item">Pengadaan</li>
                    <li class="breadcrumb-item active">Pengadaan Armada @isset($ticket) ({{$ticket->code}}) @else Baru @endisset</li>
                </ol>
            </div>
        </div>
        <div class="d-flex justify-content-end">
        </div>
    </div>
</div>
<div class="content-body">
    <form action="/createarmadaticket" id="armadaform" method="post">
        @csrf
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="required_field">Tanggal Pengajuan</label>
                    <input type="date" class="form-control created_date" value="{{now()->translatedFormat('Y-m-d')}}" disabled>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="required_field">Tanggal Setup</label>
                    <input type="date" class="form-control requirement_date" name="requirement_date" required>
                    <small class="text-danger">*Tanggal pengadaan minimal 14 hari dari tanggal pengajuan</small>
                </div>
            </div>
            <div class="col-md-4">
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
            <div class="col-md-4">
                <div class="form-group">
                <label class="required_field">Jenis Armada</label>
                    <select class="form-control isNiaga" name="isNiaga" required disabled>
                        <option value="">Pilih Jenis Armada</option>
                        <option value="0">Non Niaga</option>
                        <option value="1">Niaga</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                <label class="required_field">Jenis Pengadaan</label>
                    <select class="form-control pengadaan_type" name="pengadaan_type" required disabled>
                    <option value="">Pilih Jenis Pengadaan</option>
                    </select>
                </div>
            </div>
            {{-- untuk pengadaan baru --}}
            <div class="col-md-4 armada_type_field" style="display:none">
                <div class="form-group">
                  <label class="required_field">Jenis Kendaraan</label>
                  <select class="form-control armada_type" name="armada_type_id">
                    <option>-- Pilih Jenis Kendaraan --</option>
                  </select>
                </div>
            </div>
            {{-- untuk replace/mutasi/stop --}}
            <div class="col-md-4 armada_field" style="display:none">
                <div class="form-group">
                  <label class="required_field">Pilih Kendaraan</label>
                  <select class="form-control armada" name="armada_id">
                  </select>
                </div>
            </div>
            {{-- <div class="col-md-3">
                <div class="form-group">
                  <label class="required_field">Tanggal Setup</label>
                  <input type="date" class="form-control setup_date" name="setup_date" required disabled>
                </div>
            </div> --}}
        </div>
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-primary">Buat Ticket Armada</button>
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
        $('.isNiaga').prop('disabled',true);
        $('.isNiaga').val("");
        if(salespoint_id != ""){
            $('.isNiaga').prop('disabled',false);
        }
        $('.isNiaga').trigger('change');
    });

    $('.isNiaga').change(function(event){
        $('.pengadaan_type').empty();
        $('.pengadaan_type').prop('disabled',true);
        $('.pengadaan_type').append('<option value="">Pilih Jenis Pengadaan</option>');                
        if($(this).val() != ""){
            $('.pengadaan_type').append('<option value="0">Pengadaan Baru</option>');                
            $('.pengadaan_type').append('<option value="1">Perpanjangan/Replace/Renewal/Stop Sewa</option>');
            $('.pengadaan_type').append('<option value="2">Mutasi</option>');
            if($(this).val() == 0){
                $('.pengadaan_type').append('<option value="3">COP</option>');               
            }
            $('.pengadaan_type').prop('disabled',false);
        }
        $('.pengadaan_type').trigger('change');
    });
    $('.isNiaga').trigger('change');

    $('.pengadaan_type').change(function(){
        let isNiaga = $('#armadaform').find('.isNiaga').val();
        let salespoint_id = $('#armadaform').find('.salespoint_select2').val();
        let armada_type_select = $('#armadaform').find('.armada_type');
        armada_type_select.prop('disabled', true);
        armada_type_select.empty();
        let option_text = '<option value="">-- Pilih Jenis Kendaraan --</option>';
        armada_type_select.append(option_text);
        $('.armada_field').hide();
        $('.armada').val("").prop('disabled', true).prop('required',false);
        $('.armada_type_field').hide();
        $('.armada_type').val("").prop('disabled', true).prop('required',false);
        if($(this).val() == ''){
            return;
        }
        if($(this).val() == '0'){
            $('.armada_type_field').show();
            $('.armada_type').prop('disabled', false).prop('required',true);
            $.ajax({
                type: "get",
                url: '/getarmadatypebyniaga/'+isNiaga,
                success: function (response) {
                    let data = response.data;
                    
                    data.forEach(item => {
                        let option_text = '<option value="'+item.id+'">'+item.name+' -- '+item.brand_name+'</option>';
                        armada_type_select.append(option_text);
                    });
                    armada_type_select.val("");
                    armada_type_select.trigger('change');
                    armada_type_select.prop('disabled', false);
                },
                error: function (response) {
                    alert('load data failed. Please refresh browser or contact admin');
                },
                complete: function () {
                    armada_type_select.trigger('change');
                }
            });
        }
        
        if($(this).val() == '1'){
            $('.armada_field').show();
            $('.armada').prop('disabled', false).prop('required',true);
            $.ajax({
                type: "get",
                url: '/getarmada?isNiaga='+isNiaga+'&salespoint_id='+salespoint_id,
                success: function (response) {
                    let data = response.data;
                    console.log(data);
                    data.forEach(item => {
                        let option_text = '<option value="'+item.id+'">'+item.plate+' -- '+item.armada_type.brand_name+' '+item.armada_type.name+'</option>';
                        $('.armada').append(option_text);
                    });
                    $('.armada').val("");
                    $('.armada').trigger('change');
                    $('.armada').prop('disabled', false);
                },
                error: function (response) {
                    alert('load data failed. Please refresh browser or contact admin');
                },
                complete: function () {
                    $('.armada').trigger('change');
                }
            });
        }
    });

    // $('.armada_type').change(function() {
    //     let armada_type_id = $(this).val();
    //     $('.setup_date').prop('disabled',true);
    //     $('.setup_date').val("");
    //     if(armada_type_id != ""){
    //         $('.setup_date').prop('disabled',false);
    //     }
    //     $('.setup_date').trigger('change');
    // });
});
</script>
@endsection
