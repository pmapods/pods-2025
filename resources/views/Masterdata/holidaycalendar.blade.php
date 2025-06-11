@extends('Layout.app')
@section('local-css')

@endsection

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Holiday Calendar</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Masterdata</li>
                    <li class="breadcrumb-item active">Holiday Calendar</li>
                </ol>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-4">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addHolidayModal">
                Tambah Holiday Calendar
            </button>
            <a class="btn btn-warning ml-2" href='/holdcal/create/template'>Download Template</a>
            <button type="button" class="btn btn-info ml-2" data-toggle="modal" data-target="#uploadHolidayModal"
                id="uploadholidaybutton">
                    Upload Holiday Calendar
            </button>
        </div>
    </div>
</div>
<div class="content-body px-4">
    <div class="table-responsive">
        <table id="holidayDT" class="table table-bordered table-striped dataTable" role="grid">
            <thead>
                <tr role="row">
                    <th width="5%">#</th>
                    <th>Tanggal Libur</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @php $count = 1; @endphp
                @foreach ($hol_cal as $key => $hol_cal)
                    <tr data-hol_cal="{{$hol_cal}}">
                        <td>{{$count++}}</td>
                        <td>{{$hol_cal->holiday_date}}</td>
                        <td>{{$hol_cal->notes}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Tambah Holiday Modal -->
<div class="modal fade" id="addHolidayModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="/addholidaycal" method="post">
        {{csrf_field()}}
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Holiday Calendar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                          <label class="required_field">Holiday Date</label>
                          <input type="date" class="form-control holiday_date" name="holiday_date" required>
                                <small class="text-danger">*Tanggal Hari Libur (Termasuk Hari Minggu)</small>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="required_field">Keterangan</label>
                            <textarea class="form-control keterangan" name="keterangan" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
        </form>
    </div>
</div>

<div class="modal fade" id="uploadHolidayModal" data-backdrop="static" tabindex="-1" role="dialog"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Upload Holiday Calendar</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <input type="hidden" class="store_id" name="store_id">
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-6 d-flex align-items-center">
                                    <div class="form-group mr-2">
                                        <label class="required_field">Pilih File Template Master Holiday</label>
                                        <input type="file" class="form-control-file" name="file" onclick="this.value=null;"
                                            placeholder="Pilih File Holiday Calendar Template" id="file_template"
                                            required
                                            accept=".xls, .xlsx"/>
                                        <small class="text-danger">*Hanya dapat upload file .xlsx sesuai dengan template yang tersedia</small>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <table class="table template_table dataTable" role="grid" id="template_table">
                                        <thead>
                                            <tr>
                                                <th>Holiday Date</th>
                                                <th>Holiday Date Before</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    
                                    <span class="spinner-border text-danger" id="table_loading" role="status" style="display: none">
                                        <span class="sr-only">Loading...</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="button" class="btn btn-primary" onclick="uploadHoliday()">Upload Holiday Master</button>
                        </div>
                    </div>
        </div>
        <form action="/uploadholidaycal" method="post" id="uploadform">
            @csrf
            <div class="inputfield">
            </div>
        </form>
</div>

{{-- Detail Holiday Modal --}}
<div class="modal fade" id="detailHolidayModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="/updateholidaycal" method="post">
            @csrf
            @method('PATCH')
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Holiday Date</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                <input type="hidden" class="holiday_id" id="holiday_id">
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                          <label class="required_field">Holiday Date</label>
                          <input type="date" class="form-control holiday_date" name="holiday_date" required>
                                <small class="text-danger">*Tanggal Hari Libur (Termasuk Hari Minggu)</small>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="required_field">Keterangan</label>
                            <textarea class="form-control keterangan" name="keterangan" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-danger delete_button" onclick="deleteHoliday()">Hapus</button>
                <button type="submit" class="btn btn-info">Update</button>
            </div>
        </div>
        </form>
        <form action="/deletePosition" method="post" id="deleteform">
            @csrf
            @method('DELETE')
            <div class="inputfield">
            </div>
        </form>
    </div>
</div>
@endsection
@section('local-js')
<script>
    var csrf = "{{ csrf_token() }}";
    $(document).ready(function(){
        var table = $('#holidayDT').DataTable(datatable_settings);
        $('#holidayDT tbody').on('click', 'tr', function () {
            let updatemodal = $('#detailHolidayModal');
            let data = $(this).data('hol_cal');
            
            updatemodal.find('.holiday_id').val(data['id']);
            updatemodal.find('input[name="holiday_date"]').val(data['holiday_date']);
            updatemodal.find('.keterangan').val(data['notes']);
            $('#detailHolidayModal').modal('show');
        });

        $('#file_template').change(function(evt) {
                $('#table_loading').show();
                var selectedFile = evt.target.files[0];
                var fd = new FormData();
                var files = $('#file_template')[0].files;
                $('#template_table tbody').empty();
                // Check file selected or not
                if (files.length > 0) {
                    fd.append('file', files[0]);
                    fd.append('_token', csrf);

                    $.ajax({
                        url: '/holdcal/create/readtemplate',
                        type: 'POST',
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response != 0) {
                                let array = response.data;
                                let error = response.error;
                            
                                let data = array.splice(0, 2);                    
                                
                                if (!error) {
                                    array.forEach(item => {
                                        let today = new Date(item.holiday_date);
                                        let formattedDate = formatDate(today);
                                        let formattedDateBfr = '';

                                        if (item.holiday_date_before) {
                                            let todayBfr = new Date(item.holiday_date_before);
                                            formattedDateBfr = formatDate(todayBfr);
                                        }

                                        let append_text = "<tr data-holiday_date='" + formattedDate +
                                                "' data-holiday_date_before='" + formattedDateBfr +
                                                "' data-notes='" + item.notes +
                                            "'>";
                                        append_text += '<td>' + formattedDate +
                                            '</td>';
                                        append_text += '<td>' + formattedDateBfr +
                                            '</td>';
                                        append_text += '<td>' + item.notes +
                                            '</td>';
                                        append_text += "</tr>";

                                        $('#template_table tbody').append(append_text);
                                    });
                                } else {
                                    alert(response.message);
                                }

                            } else {
                                alert('file not uploaded');
                            }
                        },
                        complete: function() {
                            $('#table_loading').hide();
                        }
                    });
                } else {
                    alert("Harap memilih file");
                }
        });
    })
    function formatDate(date) {       
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are 0-indexed
        const day = String(date.getDate()).padStart(2, '0');

        return `${month}/${day}/${year}`;
    }

    function uploadHoliday() {
            let modal = $('#uploadHolidayModal');
                      
            let table_level = modal.find('.template_table');
            let holiday_list = [];
            let list_count = 0;

            table_level.find('tbody tr').each(function(index, el) {
                list_count++

                let holiday_date = $(el).data('holiday_date');
                let holiday_date_before = $(el).data('holiday_date_before');
                let notes = $(el).data('notes');

                holiday_list.push({
                    "holiday_date": holiday_date,
                    "holiday_date_before": holiday_date_before,
                    "notes": notes
                })
            });            
            
            // form filling
            let form = modal.find('form');
            let inputfield = form.find('.inputfield');
            
            inputfield.empty();
            inputfield.append("<input type='hidden' name='holiday_list' value='" + JSON.stringify(holiday_list) + "'>");
            form.submit();       
        }

    function deleteHoliday(){
        let updatemodal = $('#detailHolidayModal');
            
        let holiday_date = updatemodal.find('input[name="holiday_date"]').val();

         // form filling
        let form = modal.find('form');
        let inputfield = form.find('.inputfield');

        inputfield.empty();
        inputfield.append("<input type='hidden' name='holiday_date' value='" + holiday_date + "'>");
        
        if (confirm('Holiday akan dihapus dan tidak dapat dikembalikan. Lanjutkan?')) {
            $('#deleteform').submit();
        } else {
        }
    }
</script>
@endsection
