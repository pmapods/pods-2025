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
              <label>Salespoint</label>
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
        @if ($armadaticket->isNiaga == false && $armadaticket->ticketing_type == 0)
        <div class="col-md-6">
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
    </div>
    <div class="d-flex justify-content-center mt-3">
        <button type="submit" class="btn btn-danger">Batalkan Pengadaan Armada</button>
    </div>
</div>

@endsection
@section('local-js')
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
@endsection
