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
                <h1 class="m-0 text-dark">Pengadaan Armada @isset($ticket) ({{$ticket->code}}) @endisset</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Operasional</li>
                    <li class="breadcrumb-item">Pengadaan</li>
                    <li class="breadcrumb-item active">Pengadaan Armada @isset($ticket) ({{$ticket->code}}) @endisset</li>
                </ol>
            </div>
        </div>
        <div class="d-flex justify-content-end">
        </div>
    </div>
</div>
<div class="content-body">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Tanggal Pengajuan</label>
                <input type="date" class="form-control" value="{{ $armadaticket->created_at->format('Y-m-d') }}" readonly>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Tanggal Setup</label>
                <input type="date" class="form-control" value="{{ $armadaticket->created_at->format('Y-m-d') }}" readonly>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
              <label>SalesPoint</label>
              <input type="text" class="form-control" value="{{ $armadaticket->salespoint->name }}" readonly>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Jenis Armada</label>
                <input type="text" class="form-control" value="{{($armadaticket->isNiaga) ? 'Niaga' : 'Non Niaga'}}" readonly>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Jenis Pengadaan</label>
                <input type="text" class="form-control" value="{{$armadaticket->type()}}" readonly>
            </div>
        </div>
        @if ($armadaticket->ticketing_type == 0)
        <div class="col-md-4">
            <div class="form-group">
                <label>Jenis Kendaraan</label>
                <input type="text" class="form-control" value="{{$armadaticket->armada_type()->name}} {{ $armadaticket->armada_type()->brand_name}}" readonly>
            </div>
        </div>
        @endif
        
        @if (in_array($armadaticket->ticketing_type,[1,2,3]))
        <div class="col-md-4">
            <div class="form-group">
                <label>Pilihan Armada</label>
                <input type="text" class="form-control" value="{{ $armadaticket->armada()->plate }} -- {{ $armadaticket->armada()->armada_type->brand_name }} {{ $armadaticket->armada()->armada_type->name }}" readonly>
            </div>
        </div>
        @endif
    </div>
    <div class="row">
        @php
            $isRequirementFinished = true;
        @endphp
        @if ($armadaticket->isNiaga == false && $armadaticket->ticketing_type == 0)
            <div class="col-md-6">
                @php 
                    if(($armadaticket->facility_form->status ?? -1) != 1){
                        $isRequirementFinished = false;
                    }
                @endphp
                @include('Operational.Armada.formfasilitas')
            </div>
        @endif
        @if ($armadaticket->ticketing_type == 1)
            <div class="col-md-6">
                @include('Operational.Armada.formperpanjanganperhentian')
            </div>
        @endif
        @if ($armadaticket->ticketing_type == 2)
            <div class="col-md-6">
                @include('Operational.Armada.formmutasi')
            </div>
        @endif
        @if ($armadaticket->status == 5)
            <div class="col-md-12 pt-3">
                <h5>Upload Dokumen Penerimaan</h5>
                <div class="row">
                    <div class="col-1">
                        <b>Status PO</b>
                    </div>
                    <div class="col-11">
                        :
                        @if ($armadaticket->po->count()>0)
                            @php
                                $po = $armadaticket->po->first();
                            @endphp
                            @switch($po->status)
                                @case(0)
                                    PO sudah diterbitkan
                                    @break
                                @case(1)
                                    Purchasing PMA sudah upload dokumen dengan ttd basah
                                    @break
                                @case(2)
                                    Supplier sudah upload tanda tangan basah
                                    @break
                                @case(3)
                                    Selesai / Tanda Tangan sudah lengkap 
                                    <a class="text-primary font-weight-bold" 
                                    style="cursor: pointer;" 
                                    onclick='window.open("/storage/{{$po->external_signed_filepath}}")'>
                                        Tampilkan PO
                                    </a>
                                    @break
                                @default
                            @endswitch
                        @else
                            Menunggu Setup PO
                        @endif
                    </div>
                </div>
                @if (($armadaticket->po->first()->status ?? -1)== 3)    
                <form action="/uploadbastk" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="arnada_ticket_id" value="{{ $armadaticket->id }}">
                    <div class="form-group">
                        <label class="required_field">Pilih File BASTK lengkap dengan ttd</label>
                        <input type="file" class="form-control-file validatefilesize" name="bastk_file" accept="image/*,application/pdf" required>
                        <small class="text-danger">*jpg, jpeg, pdf (MAX 5MB)</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit BASTK</button>
                </form>
                @endif
            </div>
        @endif
        @if ($armadaticket->status == 6)
            <div class="col-md-12 pt-3">
                <h5>Dokumen Penerimaan</h5>
                <div class="row">
                    <div class="col-1">
                        <b>PO</b>
                    </div>
                    <div class="col-11">
                        @php
                            $po = $armadaticket->po->first();
                        @endphp
                        : Selesai / Tanda Tangan sudah lengkap 
                        <a class="text-primary font-weight-bold" 
                        style="cursor: pointer;" 
                        onclick='window.open("/storage/{{$po->external_signed_filepath}}")'>
                            Tampilkan PO
                        </a>
                    </div>
                    
                    <div class="col-1">
                        <b>BASTK</b>
                    </div>
                    <div class="col-11">
                        : BASTK berhasil di upload
                        <a class="text-primary font-weight-bold" 
                        style="cursor: pointer;" 
                        onclick='window.open("/storage/{{$armadaticket->bastk_path}}")'>
                            Tampilkan BASTK
                        </a>
                    </div>
                </div>
                @if (($armadaticket->po->first()->status ?? -1)== 3 && $armadaticket->status == 5)    
                <form action="/uploadbastk" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="arnada_ticket_id" value="{{ $armadaticket->id }}">
                    <div class="form-group">
                        <label class="required_field">Pilih File BASTK lengkap dengan ttd</label>
                        <input type="file" class="form-control-file validatefilesize" name="bastk_file" accept="image/*,application/pdf" required>
                        <small class="text-danger">*jpg, jpeg, pdf (MAX 5MB)</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit BASTK</button>
                </form>
                @endif
            </div>
        @endif
    </div>
    <div class="row mt-3">
        <div class="col-md-12 d-flex flex-row justify-content-center align-items-center">
            @foreach ($armadaticket->authorizations as $authorization)
                <div class="d-flex text-center flex-column mr-3">
                    <div class="font-weight-bold">{{ $authorization->as }}</div>
                    @if (($armadaticket->current_authorization()->employee_id ?? -1) == $authorization->employee_id)
                    <div class="text-warning">Pending</div>
                    @endif
                    
                    @if ($authorization->status == 1)
                    <div class="text-success">Approved {{ $authorization->updated_at->format('Y-m-d (H:i)') }}</div>
                    @endif
                    <div>{{ $authorization->employee_name }} ({{ $authorization->employee_position }})</div>
                </div>
                @if (!$loop->last)
                <div class="mr-3">
                    <i class="fa fa-chevron-right" aria-hidden="true"></i>
                </div>
                @endif
            @endforeach
        </div>
    </div>
    @if ($armadaticket->status == 0)
    <div class="text-center mt-3 d-flex flex-row justify-content-center">
        <button type="button" class="btn btn-primary mr-2" 
        @if (!$isRequirementFinished)
            disabled 
        @else 
            onclick="startAuthorization('{{ $armadaticket->id }}', '{{ $armadaticket->updated_at }}')"
        @endif>Mulai Otorisasi</button>
        <button type="button" class="btn btn-danger mr-2">Batalkan Pengadaan</button>
    </div>
    <div class="text-danger small text-center mt-1">*otorisasi dapat dimulai setelah melengkapi kelengkapan</div>
    @endif
    @if ($armadaticket->status == 1 && ($armadaticket->current_authorization()->employee_id ?? -1) == Auth::user()->id)
    <div class="text-center mt-3 d-flex flex-row justify-content-center">
        <button type="button" class="btn btn-success mr-2" onclick="approveAuthorization('{{ $armadaticket->id }}')">Approve</button>
        <button type="button" class="btn btn-danger mr-2" onclick="">Reject</button>
    </div> 
    @endif
</div>
<form id="submitform">
    @csrf
    <div></div>
</form>
@endsection
@section('local-js')
<script>
    $(document).ready(function() {
        $('.validatefilesize').change(function(event){
            if(!validatefilesize(event)){
                $(this).val('');
            }
        });
    });
    function startAuthorization(armada_ticket_id,updated_at){
        $('#submitform').prop('action', '/startarmadaauthorization');
        $('#submitform').prop('method', 'POST');
        $('#submitform').find('div').append('<input type="hidden" name="armada_ticket_id" value="'+armada_ticket_id+'">');
        $('#submitform').find('div').append('<input type="hidden" name="updated_at" value="'+updated_at+'">');
        $('#submitform').submit();
    }

    function approveAuthorization(armada_ticket_id){
        $('#submitform').prop('action', '/approvearmadaauthorization');
        $('#submitform').find('div').append('<input type="hidden" name="armada_ticket_id" value="'+armada_ticket_id+'">');
        $('#submitform').prop('method', 'POST');
        $('#submitform').submit();
    }
</script>
{{-- form perpanjangan perhentian --}}
<script>
    let formperpanjangan = $('#formperpanjangan');
    $(document).ready(function () {
        formperpanjangan.find('.vendor').change(function(){
            formperpanjangan.find('.localvendor').val('');
            if($(this).val() == 'lokal'){
                formperpanjangan.find('.localvendor').prop('disabled',false);
            }else{
                formperpanjangan.find('.localvendor').prop('disabled',true);
            }
        });

        formperpanjangan.find('.authorization').change(function(){
            let list = $(this).find('option:selected').data('list');
            if(list == null){
                formperpanjangan.find('.authorization_table').hide();
                return;
            }
            formperpanjangan.find('.authorization_table').show();
            let table_string = '<tr>';
            let temp = '';
            let col_count = 1;
            // authorization header
            list.forEach((item,index)=>{
                if(index > 0){
                    if(temp == item.sign_as){
                        col_count++;
                    }else{
                        table_string += '<td class="small" colspan="'+col_count+'">'+temp+'</td>';
                        temp = item.sign_as;
                        col_count =1;
                    }
                }else{  
                    temp = item.sign_as;
                }
                if(index == list.length-1){
                    table_string += '<td class="small" colspan="'+col_count+'">'+temp+'</td>';
                }
            });
            table_string += '</tr><tr>';
            list.forEach((item,index)=>{
                table_string += '<td width="20%" class="align-bottom small" style="height: 80px"><b>'+item.employee.name+'</b><br>'+item.employee_position.name+'</td>';
            });
            table_string += '</tr>';

            formperpanjangan.find('.authorization_table tbody').empty();
            formperpanjangan.find('.authorization_table tbody').append(table_string);
        });
    });
</script>

{{-- form fasilitas --}}
<script>
    let formfasilitas = $('#formfasilitas');
    $(document).ready(function () {
        formfasilitas.find('.vendor').change(function(){
            formfasilitas.find('.localvendor').val('');
            if($(this).val() == 'lokal'){
                formfasilitas.find('.localvendor').prop('disabled',false);
            }else{
                formfasilitas.find('.localvendor').prop('disabled',true);
            }
        });

        formfasilitas.find('.authorization').change(function(){
            let list = $(this).find('option:selected').data('list');
            if(list == null){
                formfasilitas.find('.authorization_table').hide();
                return;
            }
            formfasilitas.find('.authorization_table').show();
            let table_string = '<tr>';
            let temp = '';
            let col_count = 1;
            // authorization header
            list.forEach((item,index)=>{
                if(index > 0){
                    if(temp == item.sign_as){
                        col_count++;
                    }else{
                        table_string += '<td class="align-middle small table-secondary" colspan="'+col_count+'">'+temp+'</td>';
                        temp = item.sign_as;
                        col_count =1;
                    }
                }else{  
                    temp = item.sign_as;
                }
                if(index == list.length-1){
                    table_string += '<td class="align-middle small table-secondary" colspan="'+col_count+'">'+temp+'</td>';
                }
            });
            table_string += '</tr><tr>';
            // authorization body
            list.forEach((item,index)=>{
                table_string += '<td width="50%" class="align-bottom small" style="height: 120px"><b>'+item.employee.name+'</b><br>'+item.employee_position.name+'</td>';
            });
            table_string += '</tr>';

            formfasilitas.find('.authorization_table tbody').empty();
            formfasilitas.find('.authorization_table tbody').append(table_string);
        });
    });
    function facilityapprove(facility_form_id){
        $('#submitform').prop('action', '/approvefacilityform');
        $('#submitform').prop('method', 'POST');
        $('#submitform').find('div').append('<input type="hidden" name="facility_form_id" value="'+facility_form_id+'">');
        $('#submitform').submit();
    }
</script>
@endsection
