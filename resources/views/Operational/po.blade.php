@extends('Layout.app')
@section('local-css')

@endsection

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Purchase Order</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Operasional</li>
                    <li class="breadcrumb-item active">Purchase Order</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="content-body px-4">
    <div class="table-responsive">
        <table id="poDT" class="table table-bordered table-striped dataTable" role="grid">
            <thead>
                <tr role="row">
                    <th>
                        #
                    </th>
                    <th>
                        Kode Tiket
                    </th>
                    <th>
                        Salespoint
                    </th>
                    <th>
                        Tanggal Permintaan
                    </th>
                    <th>
                        Tanggal Selesai Otorisasi
                    </th>
                    <th>
                        Status
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tickets as $key => $ticket)
                    <td>{{$key+1}}</td>
                    <td>{{$ticket->code}}</td>
                    <td>{{$ticket->salespoint->name}}</td>
                    <td>{{$ticket->created_at->translatedFormat('d F Y (H:i)')}}</td>
                    <td>{{$ticket->pr->last_authorization()->updated_at->translatedFormat('d F Y (H:i)')}}</td>
                    <td>{{$ticket->status()}}</td>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
@section('local-js')
<script>
    $(document).ready(function(){
        var table = $('#poDT').DataTable(datatable_settings);
        $('#poDT tbody').on('click', 'tr', function () {
            window.location.href = '/po/'+$(this).find('td:eq(1)').text().trim();
        });
    })
</script>
@endsection
