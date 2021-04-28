@extends('Layout.app')
@section('local-css')

@endsection

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Operasional</h1>
                <h5 class="m-0">Menunggu Proses Bidding</h5>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Operasional</li>
                    <li class="breadcrumb-item active">Bidding</li>
                </ol>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-4">
            {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addEmployeeModal">
                Tambah PR Baru
            </button> --}}
        </div>
    </div>
</div>
<div class="content-body px-4">
    <div class="table-responsive">
        <table id="biddingDT" class="table table-bordered table-striped dataTable" role="grid">
            <thead>
                <tr role="row">
                    <th>
                        #
                    </th>
                    <th>
                        Kode Form Pengadaan
                    </th>
                    <th>
                        Nama Pengaju
                    </th>
                    <th>
                        Area
                    </th>
                    <th>
                        Tanggal Permintaan
                    </th>
                    <th>
                        Tanggal Pengajuan
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>PCD-210425-0001</td>
                    <td>Kevin Farel</td>
                    <td>DAAN MOGOT MT</td>
                    <td>26 April 2021</td>
                    <td>5 Mei 2021</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
@section('local-js')
<script>
    $(document).ready(function(){
        var table = $('#biddingDT').DataTable(datatable_settings);
        $('#biddingDT tbody').on('click', 'tr', function () {
            window.location.href="/bidding/form_code";
        });
    })
</script>
@endsection
