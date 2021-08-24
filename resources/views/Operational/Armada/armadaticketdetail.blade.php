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
                <h1 class="m-0 text-dark">
                    Pengadaan Armada @isset($armadaticket) ({{$armadaticket->code}}) @endisset
                </h1>
                @if ($armadaticket->status == -1)
                    <h5 class="text-danger">( Alasan Pembatalan : {{ $armadaticket->termination_reason }})</h5>
                @endif
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Operasional</li>
                    <li class="breadcrumb-item">Pengadaan</li>
                    <li class="breadcrumb-item active">Pengadaan Armada @isset($armadaticket) ({{$armadaticket->code}}) @endisset</li>
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
                <input type="date" class="form-control" value="{{ $armadaticket->requirement_date }}" readonly>
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
                <input type="text" class="form-control" value="{{$armadaticket->armada_type->name}} {{ $armadaticket->armada_type->brand_name}}" readonly>
            </div>
        </div>
        @endif
        
        @if (in_array($armadaticket->ticketing_type,[1,2,3]))
        <div class="col-md-4">
            <div class="form-group">
                <label>Pilihan PO</label>
                <input type="text" class="form-control" value="{{ $armadaticket->po_reference_number }}" readonly>
            </div>
        </div>
        @endif
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
              <label for="vendor_recommendation_name">Rekomendasi Vendor</label>
              <input type="text" id="vendor_recommendation_name" class="form-control" readonly value="{{ $armadaticket->vendor_recommendation_name }}">
            </div>
        </div>
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
            @php
                if(($armadaticket->perpanjangan_form->status ?? -1) != 1){
                    $isRequirementFinished = false;
                }
            @endphp
            <div class="col-md-6">
                @include('Operational.Armada.formperpanjanganperhentian')
            </div>
        @endif
        @if ($armadaticket->ticketing_type == 2)
            @php
                if(($armadaticket->mutasi_form->status ?? -1) != 1){
                    $isRequirementFinished = false;
                }
            @endphp
            <div class="col-md-6">
                @include('Operational.Armada.formmutasi')
            </div>
        @endif 
        @if ($available_armadas->count() > 0 && $armadaticket->ticketing_type == 0 && in_array($armadaticket->status,[-1,7]))
            @php
                $isRequirementFinished = false;
            @endphp
            <div class="col-md-6">
                @include('Operational.Armada.availablearmadas')
            </div>
        @endif
        @if ($armadaticket->status == 4 || $armadaticket->status == 5)
            <div class="col-md-6 pl-3">
                @if (in_array($armadaticket->type(),['Pengadaan','Replace','Renewal','Mutasi']))
                    <h5>Upload Dokumen Penerimaan</h5>
                @elseif($armadaticket->type() == "Perpanjangan")
                    <h5>Verifikasi PO</h5>
                @else
                    <h5>Upload Dokumen Penyerahan</h5>
                @endif
                <div class="row">
                    <div class="col-1">
                        <b>Status</b>
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
                                    <a class="uploaded_file text-primary font-weight-bold" 
                                    style="cursor: pointer;" 
                                    @if ($po->external_signed_filepath != null)
                                    onclick='window.open("/storage/{{$po->external_signed_filepath}}")'
                                    @else
                                    onclick='window.open("/storage/{{$po->internal_signed_filepath}}")'
                                    @endif
                                    >Tampikan PO
                                    </a>
                                    @break
                                @default
                            @endswitch
                        @else
                            {{ $armadaticket->status() }}
                        @endif
                    </div>
                </div>
                @if (($armadaticket->po->first()->status ?? -1)== 3 || $armadaticket->status == 5)
                    @php
                        if($armadaticket->type() == 'Perpanjangan'){
                            $action = '/verifyPO';
                        }else{
                            $action = '/uploadbastk';
                        }
                    @endphp
                    <form action="{{ $action }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="armada_ticket_id" value="{{ $armadaticket->id }}">
                        @if (in_array($armadaticket->type(),["Pengadaan","Replace","Renewal","Mutasi","End Kontrak"]))
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="required_field">Pilih File BASTK lengkap dengan ttd</label>
                                        <input type="file" class="form-control-file validatefilesize" name="bastk_file" accept="image/*,application/pdf" required>
                                        <small class="text-danger">*jpg, jpeg, pdf (MAX 5MB)</small>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if (in_array($armadaticket->type(),["Replace","Renewal"]))
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>Armada Lama</label>
                                        <input type="text" class="form-control" 
                                        value="{{ $armadaticket->po_reference->armada_ticket->armada_type->brand_name }} {{ $armadaticket->po_reference->armada_ticket->armada_type->name }}" 
                                        readonly>
                                        <small class="text-danger">*Armada lama akan terhapus dari sistem secara otomatis</small>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Nomor Pelat Lama</label>
                                        <input type="text" class="form-control"
                                        value="{{ $armadaticket->po_reference->armada_ticket->armada->plate }}"
                                        readonly>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (in_array($armadaticket->type(),["Pengadaan","Renewal","Replace"]))
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                    <label>Tipe Armada</label>
                                    <input type="text" class="form-control" 
                                    value="{{ $armadaticket->armada_type->brand_name }} {{ $armadaticket->armada_type->name }}" 
                                    readonly>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label class="required_field" for="nomor_pelat">Nomor Pelat</label>
                                        <input type="text" class="form-control" name="plate" id="nomor_pelat" placeholder="Masukan Nomor Pelat"
                                        @if ($armadaticket->type() == "Perpanjangan")
                                            readonly
                                            value="{{ $armadaticket->perpanjangan_form->nopol }}"
                                        @else
                                            required
                                        @endif>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                    <label class="required_field">Unit</label>
                                    <select class="form-control" name="type" required>
                                        <option value="">-- Pilih Unit --</option>
                                        <option value="gs">GS</option>
                                        <option value="gt">GT</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label class="optional_field" for="booked_by">Di Booking Oleh</label>
                                        <input type="text" class="form-control" name="booked_by" id="booked_by" placeholder="Masukan Nama"
                                        @if ($armadaticket->type() == "Perpanjangan")
                                            value="{{ $armadaticket->po_reference->armada_ticket->armada->booked_by }}"
                                        @endif>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($armadaticket->type() == "Mutasi")
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                    <label>Tipe Unit</label>
                                    <input type="text" class="form-control" 
                                    value="{{ $armadaticket->armada_type->brand_name }} {{ $armadaticket->armada_type->name }}" 
                                    readonly>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label class="required_field" for="nomor_pelat">Nomor Pelat</label>
                                        <input type="text" class="form-control" name="plate" id="nomor_pelat" placeholder="Masukan Nomor Pelat" readonly value="{{ $armadaticket->mutasi_form->nopol }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label class="required_field" for="nomor_pelat">Salespoint Awal</label>
                                        <input type="text" class="form-control" name="plate" id="nomor_pelat" placeholder="Masukan Nomor Pelat" readonly value="{{ $armadaticket->mutasi_form->sender_salespoint_name }}">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label class="required_field" for="nomor_pelat">Salespoint Tujuan</label>
                                        <input type="text" class="form-control" name="plate" id="nomor_pelat" placeholder="Masukan Nomor Pelat" readonly value="{{ $armadaticket->mutasi_form->receiver_salespoint_name }}">
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($armadaticket->type() == "Perpanjangan")
                            <button type="submit" class="btn btn-primary mt-3">Verifikasi PO</button>   
                        @else
                            <button type="submit" class="btn btn-primary mt-3">Submit Dokumen Penerimaan</button>   
                        @endif
                    </form>
                @endif
            </div>
        @endif
        @if ($armadaticket->status == 6)
            <div class="col-md-6 pl-3">
                <h5>Dokumen Penerimaan <span class="text-success">(Selesai)</span></h5>
                <div class="row">
                    @if($armadaticket->po->count()>0)    
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
                    @endif
                    @if ($armadaticket->type() != "Perpanjangan")
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
                    @endif
                </div>
                
                @if (in_array($armadaticket->type(),['Pengadaan','Replace','Renewal']))
                    @if ($armadaticket->gt_plate == null)
                    <form action="/uploadbastkgt" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="armada_ticket_id" value="{{ $armadaticket->id }}">
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required_field">Pilih File BASTK GT lengkap dengan ttd</label>
                                    <input type="file" class="form-control-file validatefilesize" name="bastk_file" accept="image/*,application/pdf" required>
                                    <small class="text-danger">*jpg, jpeg, pdf (MAX 5MB)</small>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-6">
                                <div class="form-group">
                                <label>Nomor Kendaraan GS</label>
                                <input type="text" class="form-control" value="{{ $armadaticket->gs_plate }}" readonly>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                <label>Nomor Kendaraan GT</label>
                                <input type="text" class="form-control" placeholder="Masukkan Nomor Kendaraan GT" name="gt_plate" required>
                                </div>
                            </div>
                            <div class="col-3">
                                <button type="submit" class="btn btn-primary">Submit GT</button>
                            </div>
                        </div>
                    </form>
                    @else
                    <div class="row mt-3">
                        <div class="col-6">
                            <div class="form-group">
                            <label>Nomor Kendaraan GT</label>
                            <input type="text" class="form-control" value="{{ $armadaticket->gt_plate }}" readonly>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                            <label>Booked By</label>
                            <input type="text" class="form-control" value="{{ \App\Models\Armada::where('plate',$armadaticket->gt_plate)->first()->booked_by }}" readonly>
                            </div>
                        </div>
                    </div>
                    @endif
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
        <button type="button" class="btn btn-danger mr-2" onclick="terminateTicketing('{{ $armadaticket->id }}', '{{ $armadaticket->updated_at }}')">Batalkan Pengadaan</button>
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
        $('.autonumber').change(function(event){
            autonumber($(this));
        });
    });

    function startAuthorization(armada_ticket_id,updated_at){
        $('#submitform').prop('action', '/startarmadaauthorization');
        $('#submitform').prop('method', 'POST');
        $('#submitform').find('div').append('<input type="hidden" name="armada_ticket_id" value="'+armada_ticket_id+'">');
        $('#submitform').find('div').append('<input type="hidden" name="updated_at" value="'+updated_at+'">');
        $('#submitform').submit();
    }

    function terminateTicketing(armada_ticket_id,updated_at){
        var reason = prompt("Pengadaan yang dibatalkan tidak dapat diajukan kembali. Masukkan alasan pembatalan");
        $('#submitform').find('div').empty();
        if (reason != null) {
            if(reason.trim() == ''){
                alert("Alasan Harus diisi");
                return
            }
            $('#submitform').prop('action', '/terminatearmadaticketing');
            $('#submitform').prop('method', 'POST');
            $('#submitform').find('div').append('<input type="hidden" name="armada_ticket_id" value="'+armada_ticket_id+'">');
            $('#submitform').find('div').append('<input type="hidden" name="updated_at" value="'+updated_at+'">');
            $('#submitform').find('div').append('<input type="hidden" name="reason" value="'+reason+'">');
            $('#submitform').submit();
        }
    }

    function approveAuthorization(armada_ticket_id){
        $('#submitform').prop('action', '/approvearmadaauthorization');
        $('#submitform').find('div').append('<input type="hidden" name="armada_ticket_id" value="'+armada_ticket_id+'">');
        $('#submitform').prop('method', 'POST');
        $('#submitform').submit();
    }
</script>
@yield('mutasi-js')
@yield('perpanjangan-js')
@yield('fasilitas-js')
@endsection
