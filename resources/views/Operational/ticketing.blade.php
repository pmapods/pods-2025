@extends('Layout.app')
@section('local-css')

@endsection

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Operasional</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Operasional</li>
                    <li class="breadcrumb-item active">Pengadaan Barang Jasa</li>
                </ol>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-4">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addNewTicket">
                Tambah Pengadaan Baru
            </button>
        </div>
    </div>
</div>
<div class="content-body px-4">
    <div class="table-responsive">
        <table id="ticketDT" class="table table-bordered table-striped dataTable" role="grid">
            <thead>
                <tr role="row">
                    <th>
                        #
                    </th>
                    <th>
                        Tanggal Pengajuan
                    </th>
                    <th>
                        Nama Pengaju
                    </th>
                    <th>
                        Area
                        {{-- HO [nama area] --}}
                    </th>
                    <th>
                        Jenis
                        {{-- barang / jasa --}}
                    </th>
                    <th>
                        Jenis Budget
                        {{-- budget / non budget --}}
                    </th>
                    <th>
                        Tanggal Pengadaan
                    </th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
@include('Operational.addTicketModal')

@endsection
@section('local-js')
<script>
    $(document).ready(function(){
        var table = $('#ticketDT').DataTable(datatable_settings);
        $('#ticketDT tbody').on('click', 'tr', function () {

        });
    })
</script>
<script src="js/addticket.js"></script>
@endsection
