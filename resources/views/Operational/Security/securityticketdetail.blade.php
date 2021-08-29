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
            <div class="col-sm-6 d-flex flex-column">
                <h1 class="m-0 text-dark">Pengadaan Security ({{ $securityticket->code }})</h1>
                <h5><b>Status : </b>{{ $securityticket->status() }}</h5>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Operasional</li>
                    <li class="breadcrumb-item">Pengadaan</li>
                    <li class="breadcrumb-item active">Pengadaan Security ({{ $securityticket->code }})</li>
                </ol>
            </div>
        </div>
        <div class="d-flex justify-content-end">
        </div>
    </div>
</div>
<div class="content-body">
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label>Tanggal Pengajuan</label>
                <input type="date" class="form-control created_date" value="{{$securityticket->created_at->format('Y-m-d')}}" readonly>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label>Tanggal Setup</label>
                <input type="date" class="form-control requirement_date" name="requirement_date" value="{{ $securityticket->requirement_date }}" readonly>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label>SalesPoint</label>
                <input type="text" class="form-control" value="{{ $securityticket->salespoint->name }}" readonly>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <div class="form-group">
                <label>Tipe Pengadaan Security</label>
                <input class="form-control" type="text" value="{{ $securityticket->type() }}" readonly>
            </div>
        </div>
        <div class="col-4" id="po_field">
            @if ($securityticket->po_reference_number)
                <div class="form-group">
                    <label>Pilihan PO Sebelumnya</label>
                    <input type="text" class="form-control" value="{{ $securityticket->po_reference_number }}" readonly>
                </div>
            @endif
        </div>
    </div>
    <div class="row mt-3">
        @php
            $isRequirementFinished = true;
            switch ($securityticket->ticketing_type) {
                case 0:
                    $securityevaluationform = false;
                    $uploadendkontrak = false;
                    break;
                case 1:
                    $securityevaluationform = true;
                    $uploadendkontrak = false;
                    break;
                case 2:
                    $securityevaluationform = true;
                    $uploadendkontrak = false;
                    break;
                case 3:
                    $securityevaluationform = true;
                    $uploadendkontrak = true;
                    break;
                default:
                    break;
            }
        @endphp
        @if ($securityevaluationform)
            @php
                if(($securityticket->evaluasi_form->status ?? -1) != 1){
                    $isRequirementFinished = false;
                }
            @endphp
            <div class="col-12">
                @include('Operational.Security.formevaluasi')
            </div>
        @endif
        @if (in_array($securityticket->type(),["Pengadaan Baru","Perpanjangan","Replace"]))
            @if ($securityticket->status == 5)    
                <div class="col-6 d-flex flex-column">
                    <form action="/uploadsecuritylpb" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="security_ticket_id" value="{{ $securityticket->id }}">
                        <h5>Upload Berkas Penerimaan Security</h5>
                        <div>
                            <b>PO {{ $securityticket->po->no_po_sap }} </b> <a class="font-weight-bold" href="#" onclick="window.open('/storage/{{  $securityticket->po->external_signed_filepath }}')">Tampilkan PO</a>
                        </div>
                        <div class="form-group">
                            <label class="required_field">Pilih File LPB lengkap dengan ttd</label>
                            <input type="file" class="form-control-file validatefilesize" name="lpb_file" accept="image/*,application/pdf" required>
                            <small class="text-danger">*jpg, jpeg, pdf (MAX 5MB)</small>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">Upload LPB</button>
                        </div>
                    </form>
                </div>
            @endif
                
            @if ($securityticket->status == 6)  
                <div class="col-6 d-flex flex-column">
                    <h5>Dokumen penerimaan</h5>
                    <div>
                        <b>Dokumen penerimaan LPB </b> <a href="#" class="font-weight-bold" onclick="window.open('/storage/{{ $securityticket->lpb_path }}')">Tampilkan</a>
                    </div>
                    <div>
                        <b>PO {{ $securityticket->po->no_po_sap }}</b> <a class="font-weight-bold" href="#" onclick="window.open('/storage/{{  $securityticket->po->external_signed_filepath }}')">Tampilkan</a>
                    </div>
                </div>
            @endif
        @endif

        @if (in_array($securityticket->type(),["End Sewa"]))
            @if ($securityticket->status == 5)    
                <div class="col-6 d-flex flex-column">
                    <form action="/uploadsecurityendkontrak" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="security_ticket_id" value="{{ $securityticket->id }}">
                        <h5>Surat Pemutusan Kerjasama</h5>
                        <div>
                            <b>PO sebelumnya {{ $securityticket->po_reference->no_po_sap }} </b><a class="font-weight-bold" href="#" onclick="window.open('/storage/{{  $securityticket->po_reference->external_signed_filepath }}')">Tampilkan PO</a>
                        </div>
                        <div class="form-group">
                            <label class="required_field">Pilih File End Kontrak lengkap dengan ttd</label>
                            <input type="file" class="form-control-file validatefilesize" name="endkontrak_file" accept="image/*,application/pdf" required>
                            <small class="text-danger">*jpg, jpeg, pdf (MAX 5MB)</small>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">Upload Surat Pemutusan Kerjasama</button>
                        </div>
                    </form>
                </div>
            @endif
                
            @if ($securityticket->status == 6)  
                <div class="col-6 d-flex flex-column">
                    <h5>Dokumen Upload</h5>
                    <div>
                        <b>Surat Pemutusan Kerjasama </b> <a href="#" class="font-weight-bold" onclick="window.open('/storage/{{ $securityticket->endkontrak_path }}')">Tampilkan</a>
                    </div>
                </div>
            @endif
        @endif
    </div>
    <div class="row mt-3">
        <div class="col-12 d-flex flex-row justify-content-center align-items-center" id="authorization_field">
            @foreach ($securityticket->authorizations as $authorization)
                <div class="d-flex text-center flex-column mr-3">
                    <div class="font-weight-bold">{{ $authorization->as }}</div>
                    @if (($securityticket->current_authorization()->employee_id ?? -1) == $authorization->employee_id)
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

    @if ($securityticket->status == 0)
        <div class="text-center mt-3 d-flex flex-row justify-content-center">
            <button type="button" class="btn btn-primary mr-2" 
            @if (!$isRequirementFinished)
                disabled 
            @else 
                onclick="startAuthorization('{{ $securityticket->id }}', '{{ $securityticket->updated_at }}')"
            @endif>Mulai Otorisasi</button>
            <button type="button" class="btn btn-danger mr-2" onclick="terminateTicketing('{{ $securityticket->id }}', '{{ $securityticket->updated_at }}')">Batalkan Pengadaan</button>
        </div>
        <div class="text-danger small text-center mt-1">*otorisasi dapat dimulai setelah melengkapi kelengkapan</div>
    @endif

    @if ($securityticket->status == 1 && ($securityticket->current_authorization()->employee_id ?? -1) == Auth::user()->id)
    <div class="text-center mt-3 d-flex flex-row justify-content-center">
        <button type="button" class="btn btn-success mr-2" onclick="approveAuthorization('{{ $securityticket->id }}')">Approve</button>
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
        $(document).ready(function () {
        });

        function startAuthorization(security_ticket_id,updated_at){
            $('#submitform').prop('action', '/startsecurityauthorization');
            $('#submitform').prop('method', 'POST');
            $('#submitform').find('div').append('<input type="hidden" name="security_ticket_id" value="'+security_ticket_id+'">');
            $('#submitform').find('div').append('<input type="hidden" name="updated_at" value="'+updated_at+'">');
            $('#submitform').submit();
        }

        function approveAuthorization(security_ticket_id){
            $('#submitform').prop('action', '/approvesecurityauthorization');
            $('#submitform').find('div').append('<input type="hidden" name="security_ticket_id" value="'+security_ticket_id+'">');
            $('#submitform').prop('method', 'POST');
            $('#submitform').submit();
        }

        function terminateTicketing(security_ticket_id,updated_at){
            var reason = prompt("Pengadaan yang dibatalkan tidak dapat diajukan kembali. Masukkan alasan pembatalan");
            $('#submitform').find('div').empty();
            if (reason != null) {
                if(reason.trim() == ''){
                    alert("Alasan Harus diisi");
                    return
                }
                $('#submitform').prop('action', '/terminatesecurityticketing');
                $('#submitform').prop('method', 'POST');
                $('#submitform').find('div').append('<input type="hidden" name="security_ticket_id" value="'+security_ticket_id+'">');
                $('#submitform').find('div').append('<input type="hidden" name="updated_at" value="'+updated_at+'">');
                $('#submitform').find('div').append('<input type="hidden" name="reason" value="'+reason+'">');
                $('#submitform').submit();
            }
        }
    </script>
    
    @yield('evaluasi-js')
@endsection

