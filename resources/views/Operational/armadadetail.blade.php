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
    <form id="optionform">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label class="required_field">Tanggal Pengajuan</label>
                <input type="date" class="form-control created_date" value="{{now()->translatedFormat('Y-m-d')}}" disabled>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="required_field">Tanggal Pengadaan</label>
                <input type="date" class="form-control requirement_date" required>
                <small class="text-danger">*Tanggal pengadaan minimal 14 hari dari tanggal pengajuan</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="required_field">Pilihan Area / Salespoint</label>
                <select class="form-control select2 salespoint_select2" required>
                    <option value="" data-isjawasumatra="-1">-- Pilih Salespoint --</option>
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
                <small class="text-danger">* Salespoint yang muncul berdasarkan hak akses tiap akun</small>
            </div>
            {{-- <span class="spinner-border text-danger loading_salespoint_select2" role="status"
                style="display:none">
                <span class="sr-only">Loading...</span>
            </span> --}}
        </div>
        <div class="col-md-5">
            <div class="form-group">
              <label class="required_field">Jenis Armada</label>
                <select class="form-control" name="armada_type" required>
                  <option value="">Pilih Jenis Armada</option>
                  <option value="niaga">Niaga</option>
                  <option value="non_niaga">Non Niaga</option>
                </select>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
              <label class="required_field">Jenis Pengadaan</label>
                <select class="form-control" name="pengadaan_type" required>
                  <option value="">Pilih Jenis Pengadaan</option>
                  <option value="">Pengadaan Baru</option>
                  <option value="">Perpanjangan</option>
                  <option value="">Replace</option>
                  <option value="">Renewal</option>
                  <option value="">Stop Sewa</option>
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
              <label>&nbsp;</label>
              <button type="submit" class="btn btn-primary form-control">Pilih Setup</button>
            </div>
        </div>
    </div>
    </form>
    <hr>
    <h4>Kebutuhan Data</h4>
    <div class="row">
        <div class="col-6">
            @include('Operational.Armada.formfasilitas')
        </div>
        <div class="col-6">
            @include('Operational.Armada.formperpanjanganperhentian')
        </div>
        <div></div>
    </div>
</div>

@endsection
@section('local-js')
<script>
$(document).ready(function () {
    // set minimal tanggal pengadaan 14 setelah tanggal pengajuan
    $('.requirement_date').val(moment().add(14,'days').format('YYYY-MM-DD'));
    $('.requirement_date').prop('min',moment().add(14,'days').format('YYYY-MM-DD'));
    $('.requirement_date').trigger('change');

    $('#optionform').on('submit', function(event){
        event.preventDefault();
        console.log(event);
    });
});
</script>
@endsection
