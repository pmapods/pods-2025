@extends('Layout.app')
@section('local-css')
<style>
    .remove_list{
        cursor: pointer;
    }
    .select2-results__option--disabled {
        color: brown;
        font-weight: bold;
    }
</style>
@endsection

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Matriks Otorisasi</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Masterdata</li>
                    <li class="breadcrumb-item active">Matriks Otorisasi</li>
                </ol>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-2">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addAuthorModal">
                Tambah Otorisasi Baru
            </button>
        </div>
    </div>
</div>
<div class="content-body px-4">
    <div class="table-responsive">
        <table id="authorDT" class="table table-bordered table-striped dataTable" role="grid">
            <thead>
                <tr>
                    <td>Salespoint</td>
                    <td>Region</td>
                    <td>Orang Pertama</td>
                    <td>Jenis Form</td>
                    <td>Tanggal Dibuat</td>
                    <td>Tingkat</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($authorizations as $authorization)
                <tr data-authorization="{{$authorization}}" data-list="{{$authorization->list()}}">
                    <td>{{ $authorization->salespoint->name }}</td>
                    <td>{{ $authorization->salespoint->region_name() }}</td>
                    <td>{{ $authorization->authorization_detail->first()->employee->name }}</td>
                    <td>{{ $authorization->form_type_name() }}</td>
                    <td>{{ $authorization->created_at->format('d F Y') }}</td>
                    <td>{{ $authorization->authorization_detail->count() }} Tingkat</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addAuthorModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Otorisasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                          <label for="">SalesPoint</label>
                          <select class="form-control select2 salespoint_select2" name="salespoint">
                            <option value="">-- Pilih SalesPoint --</option>
                            @foreach ($regions as $region)
                                <optgroup label="{{$region->first()->region_name()}}">
                                    @foreach ($region as $salespoint)
                                        <option value="{{$salespoint->id}}">{{$salespoint->name}}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                          </select>
                        </div>
                    </div>
                    <div class="col-md-1 d-flex align-items-center pt-3">
                        <span class="spinner-border text-danger loading_salespoint_select2" role="status" style="display:none">
                            <span class="sr-only">Loading...</span>
                        </span>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Jenis Form</label>
                          <select class="form-control" name="form_type" required>
                            <option value="">-- Pilih Jenis Form --</option>
                            <option value="0">Form Pengadaan</option>
                          </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-bordered table_level">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>Sebagai</th>
                                    <th>Level</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="empty_row text-center"><td colspan="5">Otorasi belum dipilih</td></tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                          <label for="">Pilih Karyawan</label>
                          <select class="form-control select2 employee_select2" name="employee_id" disabled>
                              <option value="" class="initial-select">--Pilih Karyawan --</option>
                          </select>
                          <small class="text-danger">* Daftar karyawan yang muncul sesuai matriks otorisasi area yang didaftarkan</small>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                          <label for="">Sebagai</label>
                          <input type="text" class="form-control as_text" placeholder="ex. Pengaju / Atasan Pengaju">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                          <label for="">&nbsp</label>
                          <button type="button" class="btn btn-info form-control add_new_level">Tambah</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="addAuthorization()">Tambah Otorisasi</button>
            </div>
        </div>
    </div>
    <form action="/addauthorization" method="post" id="#addform">
        @csrf
        <div class="inputfield">
        </div>
    </form>
</div>
<div class="modal fade" id="detailAuthorModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Otorisasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                          <label for="">SalesPoint</label>
                          <select class="form-control select2 salespoint_select2" name="salespoint" disabled>
                            <option value="">-- Pilih SalesPoint --</option>
                            @foreach ($regions as $region)
                                <optgroup label="{{$region->first()->region_name()}}">
                                    @foreach ($region as $salespoint)
                                        <option value="{{$salespoint->id}}">{{$salespoint->name}}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                          </select>
                        </div>
                    </div>
                    <div class="col-md-1 d-flex align-items-center pt-3">
                        <span class="spinner-border text-danger loading_salespoint_select2" role="status" style="display:none">
                            <span class="sr-only">Loading...</span>
                        </span>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Jenis Form</label>
                          <select class="form-control" name="form_type" required>
                            <option value="">-- Pilih Jenis Form --</option>
                            <option value="0">Form Pengadaan</option>
                          </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-bordered table_level">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>Sebagai</th>
                                    <th>Level</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                          <label for="">Pilih Karyawan</label>
                          <select class="form-control select2 employee_select2" name="employee_id" disabled>
                              <option value="" class="initial-select">--Pilih Karyawan --</option>
                          </select>
                          <small class="text-danger">* Daftar karyawan yang muncul sesuai matriks otorisasi area yang didaftarkan</small>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                          <label for="">Sebagai</label>
                          <input type="text" class="form-control as_text" placeholder="ex. Pengaju / Atasan Pengaju">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                          <label for="">&nbsp</label>
                          <button type="button" class="btn btn-info form-control add_new_level">Tambah</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-danger" onclick="deleteAuthorization()">Hapus</button>
                <button type="button" class="btn btn-primary" onclick="updateAuthorization()">Update Otorisasi</button>
            </div>
        </div>
    </div>
    <form action="/updateauthorization" method="post" id="updateform">
        @csrf
        @method('patch')
        <input type="hidden" name="authorization_id">
        <div class="inputfield">
        </div>
    </form>
    
    <form action="/deleteauthorization" method="post" id="deleteform">
        @csrf
        @method('delete')
        <input type="hidden" name="authorization_id">
    </form>
    
</div>

@endsection
@section('local-js')
<script>
    $(document).ready(function () {
        var table = $('#authorDT').DataTable(datatable_settings);
        $('#authorDT tbody').on('click', 'tr', function () {
            let modal = $('#detailAuthorModal');
            let data = $(this).data('authorization');
            let list = $(this).data('list');
            let salespoint = modal.find('.salespoint_select2');
            let employee_select = modal.find('.employee_select2');
            let form_type = modal.find('select[name="form_type"]');
            let table_level = modal.find('.table_level');
            modal.find('input[name="authorization_id"]').val(data.id);

            salespoint.val(data['salespoint_id']);
            salespoint.trigger('change');
            form_type.val(data['form_type']);

            table_level.find('tbody').empty();
            list.forEach((item,index)=>{
                table_level.find('tbody').append('<tr data-id="' + item.id + '" data-as="' + item.as_text + '"><td>' + item.name + '</td><td>' + item.position + '</td><td>' + item.as_text + '</td><td class="level"></td><td><i class="fa fa-trash text-danger remove_list" onclick="removeList(this)" aria-hidden="true"></i></td></tr>');
            })
            tableRefreshed(table_level);
            modal.modal('show');
            
        });
        $('.salespoint_select2').on('change', function () {
            let closestmodal = $(this).closest('.modal');
            let salespoint_id = $(this).find('option:selected').val();
            let employee_select = closestmodal.find('.employee_select2');
            let table_level = closestmodal.find('.table_level');
            let loading = closestmodal.find('.loading_salespoint_select2');

            // initial state
            employee_select.prop('disabled', true);
            employee_select.find('option').remove();
            var empty = new Option('-- Pilih Karyawan --', "", false, true);
            employee_select.append(empty);
            employee_select.trigger('change');

            if (salespoint_id == "") {
                return;
            }
            loading.show();
            $.ajax({
                type: "get",
                url: "/getauthorizedemployeebysalesPoint/" + salespoint_id,
                success: function (response) {
                    let selected_id = []
                    table_level.find('tbody tr').not('.empty_row').each((index,el)=>{
                        let id = $(el).data('id');
                        selected_id.push(id);
                    });
                    let data = response.data;
                    employee_select.prop('disabled', false);
                    data.forEach(single_data => {
                        let option_text = single_data.name + ' -- ' + single_data.position;
                        var newOption = new Option(option_text, single_data.id, false, true);
                        employee_select.append(newOption);
                        if(selected_id.includes(single_data.id)){
                            employee_select.find('option:selected').prop('disabled', true);
                        }
                    })
                    employee_select.val("");
                    employee_select.trigger('change');
                    loading.hide();
                    
                },
                error: function (response) {
                    alert("error");
                    loading.hide();
                }
            });
        })
        $('.add_new_level').on('click', function () {
            let closestmodal = $(this).closest('.modal');
            let employee_select = closestmodal.find('.employee_select2');
            let as_text = closestmodal.find('.as_text');
            let table_level = closestmodal.find('.table_level');


            // check if all required field were selected
            if (employee_select.val() == "" || as_text.val() == "") {
                alert('Karyawan harus dipilih dan input sebagai harus diisi');
            } else {
                let id = employee_select.val();
                let name = employee_select.find('option:selected').text().split('--')[0].trim();
                let position = employee_select.find('option:selected').text().split('--')[1].trim();

                table_level.find('tbody').append('<tr data-id="' + id + '" data-as="' + as_text.val() + '"><td>' + name + '</td><td>' + position + '</td><td>' + as_text.val() + '</td><td class="level"></td><td><i class="fa fa-trash text-danger remove_list" onclick="removeList(this)" aria-hidden="true"></i></td></tr>');

                employee_select.find('option:selected').prop('disabled', true);
                employee_select.val('');
                as_text.val('');
                employee_select.trigger('change');
                tableRefreshed($(this));
            }
        });
    });
    // remove button
    function removeList(el) {
        let closestmodal = $(el).closest('.modal');
        let table = closestmodal.find('table');
        let employee_select = closestmodal.find('.employee_select2');
        let tr = $(el).closest('tr');
        let employee_id = tr.data('id');
        employee_select.val(employee_id);
        employee_select.find('option:selected').prop('disabled', false);
        employee_select.val("");
        employee_select.trigger('change');
        tr.remove();
        tableRefreshed(table);
    }
    // table on refresh
    function tableRefreshed(current_element) {
        let closestmodal = $(current_element).closest('.modal');
        let table_level = closestmodal.find('.table_level');
        let salespoint_select = closestmodal.find('.salespoint_select2');
        // check table level if table has data / tr or not
        let row_count = 0;
        table_level.find('tbody tr').not('.empty_row').each(function () {
            row_count++;
        });
        if (row_count > 0) {
            salespoint_select.prop('disabled', true);
            table_level.find('.empty_row').remove();
            table_level.find('.level').each(function (index, el) {
                $(el).text(index + 1);
            });
        } else {
            salespoint_select.prop('disabled', false);
            table_level.append('<tr class="empty_row text-center"><td colspan="5">Otorasi belum dipilih</td></tr>');
        }
    }

    function addAuthorization() {
        let modal = $('#addAuthorModal');
        let salespoint = modal.find('select[name="salespoint"]').val();
        let form_type = modal.find('select[name="form_type"]').val();
        let table_level = modal.find('.table_level');
        let authorizationlist = [];
        let list_count = 0;
        if(salespoint==""){
            alert('Harap memilih salespoint');
            return;
        }
        if(form_type==""){
            alert('Harap memilih jenis form');
            return;
        }
        table_level.find('tbody tr').not('.empty_row').each(function (index,el){
            list_count++;
            let id = $(el).data('id');
            let as = $(el).data('as');
            let level = parseInt($(el).find('.level').text().trim());
            authorizationlist.push({
                "id":id,
                "as":as,
                "level":level
            })
        });
        if(list_count<1){
            alert('Minimal 1 otorisasi dipilih');
            return;
        }
        // form filling
        let form =  $('#addAuthorModal').find('form');
        let inputfield = form.find('.inputfield');
        inputfield.empty();
        inputfield.append('<input type="hidden" name="salespoint" value="'+salespoint+'">');
        inputfield.append('<input type="hidden" name="form_type" value="'+form_type+'">');
        authorizationlist.forEach((item,index) => {
            inputfield.append('<input type="hidden" name="authorization['+index+'][id]" value="'+item.id+'">')
            inputfield.append('<input type="hidden" name="authorization['+index+'][as]" value="'+item.as+'">')
            inputfield.append('<input type="hidden" name="authorization['+index+'][level]" value="'+item.level+'">')
        });
        form.submit();
    }

    function updateAuthorization() {
        let modal = $('#detailAuthorModal');
        let salespoint = modal.find('select[name="salespoint"]').val();
        let form_type = modal.find('select[name="form_type"]').val();
        let table_level = modal.find('.table_level');
        let authorizationlist = [];
        let list_count = 0;
        if(salespoint==""){
            alert('Harap memilih salespoint');
            return;
        }
        if(form_type==""){
            alert('Harap memilih jenis form');
            return;
        }
        table_level.find('tbody tr').not('.empty_row').each(function (index,el){
            list_count++;
            let id = $(el).data('id');
            let as = $(el).data('as');
            let level = parseInt($(el).find('.level').text().trim());
            authorizationlist.push({
                "id":id,
                "as":as,
                "level":level
            })
        });
        if(list_count<1){
            alert('Minimal 1 otorisasi dipilih');
            return;
        }
        // form filling
        let form =  $('#updateform');
        let inputfield = form.find('.inputfield');
        inputfield.empty();
        inputfield.append('<input type="hidden" name="salespoint" value="'+salespoint+'">');
        inputfield.append('<input type="hidden" name="form_type" value="'+form_type+'">');
        authorizationlist.forEach((item,index) => {
            inputfield.append('<input type="hidden" name="authorization['+index+'][id]" value="'+item.id+'">')
            inputfield.append('<input type="hidden" name="authorization['+index+'][as]" value="'+item.as+'">')
            inputfield.append('<input type="hidden" name="authorization['+index+'][level]" value="'+item.level+'">')
        });
        form.submit();
    }

    function deleteAuthorization(){
        if (confirm('Otorisasi akan dihapus dan tidak dapat dikembalikan. Lanjutkan?')) {
            $('#deleteform').submit();
        } else {

        }
    }
</script>
@endsection
