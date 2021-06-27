@extends('Layout.app')
@section('local-css')

@endsection

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Bidding</h1>
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
                @foreach ($biddings as $key => $bid)
                <tr>    
                    <td>{{$key+1}}</td>
                    <td>{{$bid->code}}</td>
                    <td>{{$bid->created_by_employee->name}}</td>
                    <td>{{$bid->salespoint->name}}</td>
                    <td>{{$bid->updated_at->translatedFormat('d F Y (H:i)')}}</td>
                    <td>{{\Carbon\Carbon::parse($bid->requirement_date)->translatedFormat('d F Y')}}</td>
                </tr>
                @endforeach
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
            let code = $(this).find('td').eq(1).text().trim();
            window.location.href="/bidding/"+code;
        });
    })
</script>
@endsection
