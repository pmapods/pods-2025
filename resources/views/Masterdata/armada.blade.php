@extends('Layout.app')
@section('local-css')

@endsection

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Armada</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Masterdata</li>
                    <li class="breadcrumb-item active">Armada</li>
                </ol>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-2">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addArmadaModal">
                Tambah Armada
            </button>
        </div>
    </div>
</div>
<div class="content-body px-4">
    <div class="table-responsive">
        <table id="armadaDT" class="table table-bordered table-striped dataTable" role="grid">
            <thead>
                <tr role="row">
                    <th>
                        #
                    </th>
                    <th>
                        Salespoint
                    </th>
                    <th>
                        Jenis Kendaraan
                    </th>
                    <th>
                        Nomor Kendaaraan
                    </th>
                    <th>
                        Tipe Niaga
                    </th>
                    <th>
                        Status
                    </th>
                    <th>
                        Di Booking Oleh
                    </th>
            </thead>
            <tbody>
                @foreach ($armadas as $key=>$armada)
                    <tr data-armada="{{$armada}}">
                        <td>{{$key+1}}</td>
                        <td>{{$armada->salespoint->name}}</td>
                        <td>{{$armada->name}}</td>
                        <td class="text-uppercase">{{$armada->plate}}</td>
                        <td>{{($armada->isNiaga)?'Niaga' : 'Non Niaga'}}</td>
                        <td>{{$armada->status()}}</td>
                        <td>{{($armada->status == 1) ? $armada->booked_by : '-'}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="addArmadaModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Armada</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/addarmada" method="post" enctype="multipart/form-data">
            @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                            <label class="required_field">Salespoint</label>
                            <select class="form-control select2 salespoint" name="salespoint_id" required>
                                <option value="">-- Pilih Salespoint --</option>
                                @foreach ($salespoints as $salespoint)
                                    <option value="{{ $salespoint->id }}">{{ $salespoint->name }}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                            <label class="required_field">Jenis Kendaraan</label>
                            <input type="text" class="form-control" name="name" placeholder="Masukkan Nama Jenis Kendaraan" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="required_field">Nomor Pelat Kendaraan</label>
                                <input type="text" class="form-control" name="plate" placeholder="Masukkan Nomor Pelat Kendaraan" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="required_field">Tipe Niaga</label>
                                <select class="form-control" name="isNiaga" required>
                                    <option value="">-- Pilih Salespoint --</option>
                                        <option value="0">Non Niaga</option>
                                        <option value="1">Niaga</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="required_field">Status</label>
                                <select class="form-control status" name="status" required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="0">Available</option>
                                    <option value="1">Booked</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 booked_by_field">
                            <div class="form-group">
                                <label class="required_field">Di Booked Oleh</label>
                                <input type="text" class="form-control booked_by" name="booked_by" placeholder="Masukan Nama yang melakukan Booking">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Tambah Armada Baru</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="detailArmadaModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detil Armada</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/updatearmada" method="post" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <input type="hidden" name="armada_id" class="armada_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                            <label class="required_field">Salespoint</label>
                            <select class="form-control select2 salespoint" name="salespoint_id" required>
                                <option value="">-- Pilih Salespoint --</option>
                                @foreach ($salespoints as $salespoint)
                                    <option value="{{ $salespoint->id }}">{{ $salespoint->name }}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                            <label class="required_field">Jenis Kendaraan</label>
                            <input type="text" class="form-control" name="name" placeholder="Masukkan Nama Jenis Kendaraan" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="required_field">Nomor Pelat Kendaraan</label>
                                <input type="text" class="form-control" name="plate" placeholder="Masukkan Nomor Pelat Kendaraan" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="required_field">Tipe Niaga</label>
                                <select class="form-control" name="isNiaga" required>
                                    <option value="">-- Pilih Salespoint --</option>
                                        <option value="0">Non Niaga</option>
                                        <option value="1">Niaga</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="required_field">Status</label>
                                <select class="form-control status" name="status" required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="0">Available</option>
                                    <option value="1">Booked</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 booked_by_field">
                            <div class="form-group">
                                <label class="required_field">Di Booked Oleh</label>
                                <input type="text" class="form-control booked_by" name="booked_by" placeholder="Masukan Nama yang melakukan Booking">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-info">Update Armada</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section('local-js')
<script>
    $(document).ready(function(){
        var table = $('#armadaDT').DataTable(datatable_settings);
        $('#armadaDT tbody').on('click', 'tr', function () {
            let modal = $('#detailArmadaModal');
            let data = $(this).data('armada');
            modal.find('input[name="armada_id"]').val(data['id']);
            modal.find('select[name="salespoint_id"]').val(data['salespoint_id']);
            modal.find('select[name="salespoint_id"]').trigger('change');
            modal.find('input[name="name"]').val(data['name']);
            modal.find('input[name="plate"]').val(data['plate']);
            modal.find('select[name="isNiaga"]').val(data['isNiaga']);
            modal.find('select[name="status"]').val(data['status']);
            modal.find('select[name="status"]').trigger('change');
            modal.find('input[name="booked_by"]').val(data['booked_by']);
            modal.modal('show');
        });
        $('.status').on('change',function(){
            let modal = $(this).closest('.modal');
            let status = $(this).val();
            if(status == 1){
                modal.find('.booked_by_field').show();
                modal.find('.booked_by').prop('required',true);      
            }else{
                modal.find('.booked_by_field').hide();
                modal.find('.booked_by').prop('required',false);      
            }
        });
        $('#addArmadaModal').on('show.bs.modal',function(){
            $('#addArmadaModal form').trigger('reset');
            $('#addArmadaModal .salespoint').trigger('change');
            $('#addArmadaModal .status').trigger('change');
        });
    })
</script>
@endsection
