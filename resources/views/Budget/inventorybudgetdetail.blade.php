@extends('Layout.app')
@section('local-css')

@endsection

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ $budget->code }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Budget</li>
                    <li class="breadcrumb-item">Inventory Budget</li>
                    <li class="breadcrumb-item active">{{ $budget->code }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="content-body px-4">
    <div class="row">
        <div class="col-6">
            <table class="table table-borderless table-sm">
                <tbody>
                    <tr>
                        <td class="font-weight-bold">Salespoint</td>
                        <td>: {{ $budget->salespoint->name }}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Waktu Pengajuan</td>
                        <td>: {{ $budget->created_at->translatedFormat('d F Y (H:i)')}}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Jenis Pengajuan</td>
                        <td>: {{ $budget->type }}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Nama Pengaju</td>
                        <td>: {{ $budget->created_by_employee->name }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Kode Budget</th>
                        <th>Keterangan</th>
                        <th>Qty</th>
                        <th>Value</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($budget->inventory_budgets as $b)
                        <tr>
                            <td>{{ $b->code }}</td>
                            <td>{{ $b->keterangan }}</td>
                            <td>{{ $b->qty }}</td>
                            <td class="rupiah_text">{{ $b->value }}</td>
                            <td class="rupiah_text">{{ $b->amount }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @if ($budget->status == -1)
    <div><h3>Upload Revisi</h3></div>
    <div class="text-danger"><b>Alasan penolakan :&nbsp;</b>{{ $budget->reject_notes }}</div>
        <div class="row">
            <div class="col-6 d-flex align-items-center">
                <div class="form-group mr-2">
                  <label class="required_field">Pilih File Template</label>
                  <input type="file" class="form-control-file" 
                    placeholder="Pilih File Template Inventory" id="file_template"
                    accept=".xls, .xlsx"/>
                </div>
                <div>
                    <button type="button" class="btn btn-primary mr-2" onclick="listToTable()">Refresh Data</button>
                </div>
                <div>
                    <a class="btn btn-info mr-2" href="/template/inventory_budget_template.xlsx">Download Template</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table" id="template_table">
                    <thead>
                        <tr>
                            <th>Kode Budget</th>
                            <th>Keterangan</th>
                            <th>Qty</th>
                            <th>Value</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    @endif
    <div class="row mt-3">
        <div class="col-md-12 d-flex flex-row justify-content-center align-items-center">
            @foreach ($budget->authorizations as $authorization)
                <div class="d-flex text-center flex-column mr-3">
                    <div class="font-weight-bold">{{ $authorization->as }}</div>
                    @if (($budget->current_authorization()->employee_id ?? -1) == $authorization->employee_id)
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
    @if ($budget->status == 0 && ($budget->current_authorization()->employee_id ?? -1) == Auth::user()->id)
    <div class="text-center mt-3 d-flex flex-row justify-content-center">
        <button type="button" class="btn btn-success mr-2" onclick="approveAuthorization('{{ $budget->id }}')">Approve</button>
        <button type="button" class="btn btn-danger mr-2" onclick="popupRejectModal()">Reject</button>
    </div> 
    @endif
    @if ($budget->status == -1)
    <div class="text-center mt-3 d-flex flex-row justify-content-center">
        <button type="button" class="btn btn-primary mr-2" onclick="reviseBudgetUpload('{{ $budget->id }}')">Revise</button>
        <button type="button" class="btn btn-danger mr-2" onclick="popupTerminateModal()">Batalkan Pengajuan</button>
    </div> 
    @endif
</div>

<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="rejectModalForm">
                <input type="hidden" name="upload_budget_id" value="{{ $budget->id }}">
                <div class="modal-header">
                    <h5 class="modal-title">Reject Pengajuan Budget</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                      <label class='required_field'>Masukan alasan pembatalan</label>
                      <textarea class="form-control" name="reason" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-danger">Reject Pengajuan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="terminateModal" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="terminateModalForm">
                <input type="hidden" name="upload_budget_id" value="{{ $budget->id }}">
                <div class="modal-header">
                    <h5 class="modal-title">Terminate Pengajuan Budget</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                      <label class='required_field'>Masukan alasan pembatalan</label>
                      <textarea class="form-control" name="reason" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-danger">Terminate Pengajuan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<form action="" id="submitform">
    @csrf
    <div></div>
</form>

@endsection
@section('local-js')
    <script lang="javascript" src="/js/xlsx.full.min.js"></script>
    <script>
        var fileobject;
        $(document).ready(function(){
            $('#rejectModalForm').submit(function(event){
                event.preventDefault();
                const data = Object.fromEntries(new FormData(event.target).entries());
                rejectAuthorization(data.upload_budget_id,data.reason);
            });
            $('#terminateModalForm').submit(function(event){
                event.preventDefault();
                const data = Object.fromEntries(new FormData(event.target).entries());
                terminateBudgetUpload(data.upload_budget_id,data.reason);
            });
            
            $('#file_template').change(function(evt) {
                var selectedFile = evt.target.files[0];
                var reader = new FileReader();
                reader.onload = function(event) {
                    var data = event.target.result;
                    var workbook = XLSX.read(data,{
                        type: 'binary'
                    });
                    workbook.SheetNames.forEach(function(sheetName){
                        fileobject = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
                        $('#refreshbutton').prop('disabled',true);  
                    });
                }
                reader.onerror = function(event) {
                    alert('Gagal membaca file');
                    $('#refreshbutton').prop('disabled',true);
                }

                reader.readAsBinaryString(selectedFile);
            });
        });
        
        function listToTable() {
            $('#template_table tbody').empty();
            let filtered_data = fileobject.filter(function(object){
                if(object["KODE BUDGET"] != null && object["KETERANGAN"] != null && object["QTY"] != null && object["VALUE"] != null && object["AMOUNT"] !=null){
                    return true;
                }else{
                    return false;
                }
            });
            filtered_data.forEach(function(data){
                $append_row = '<tr>';
                $append_row += '<td>'+data["KODE BUDGET"]+'</td>';
                $append_row += '<td>'+data["KETERANGAN"]+'</td>';
                $append_row += '<td>'+data["QTY"]+'</td>';
                $append_row += '<td>'+data["VALUE"]+'</td>';
                $append_row += '<td>'+data["AMOUNT"]+'</td>';
                $append_row += '</tr>';
                $('#template_table tbody').append($append_row);
            });
        }

        function reviseBudgetUpload(upload_budget_id){
            let append_input_text = "";
            append_input_text += "<input type='hidden' name='upload_budget_id' value='"+upload_budget_id+"'>"
            let count = 0;
            $('#template_table tbody tr').each(function(index){
                count++;
                let code = $(this).find('td:eq(0)').text().trim();
                let keterangan = $(this).find('td:eq(1)').text().trim();
                let qty = $(this).find('td:eq(2)').text().trim();
                let value = $(this).find('td:eq(3)').text().trim();
                let amount = $(this).find('td:eq(4)').text().trim();
                append_input_text += "<input type='hidden' name='item["+index+"][code]' value='"+code+"'>";
                append_input_text += "<input type='hidden' name='item["+index+"][keterangan]' value='"+keterangan+"'>";
                append_input_text += "<input type='hidden' name='item["+index+"][qty]' value='"+qty+"'>";
                append_input_text += "<input type='hidden' name='item["+index+"][value]' value='"+value+"'>";
                append_input_text += "<input type='hidden' name='item["+index+"][amount]' value='"+amount+"'>";
            });
            if(count == 0){
                alert('Minimal 1 data');
                return;
            }
            $('#submitform div').empty();
            $('#submitform div').append(append_input_text);
            $('#submitform').prop('action', '/reviseBudget');
            $('#submitform').prop('method', 'POST');
            $('#submitform').submit()
        }

        function approveAuthorization(upload_budget_id){
            $('#submitform').prop('action', '/approvebudgetauthorization');
            $('#submitform').find('div').empty();
            $('#submitform').find('div').append('<input type="hidden" name="budget_upload_id" value="'+upload_budget_id+'">');
            $('#submitform').prop('method', 'POST');
            $('#submitform').submit();
        }

        function popupRejectModal(){
            $('#rejectModal textarea').val('');
            $('#rejectModal').modal('show');
        }

        function popupTerminateModal(){
            $('#terminateModal textarea').val('');
            $('#terminateModal').modal('show');
        }

        function rejectAuthorization(upload_budget_id,reason){
            $('#submitform').prop('action', '/rejectbudgetauthorization');
            $('#submitform').find('div').append('<input type="hidden" name="budget_upload_id" value="'+upload_budget_id+'">');
            $('#submitform').find('div').append('<input type="hidden" name="reason" value="'+reason+'">');
            $('#submitform').prop('method', 'POST');
            $('#submitform').submit();
        }

        function terminateBudgetUpload(upload_budget_id,reason){
            $('#submitform').prop('action', '/terminateBudget');
            $('#submitform').find('div').append('<input type="hidden" name="budget_upload_id" value="'+upload_budget_id+'">');
            $('#submitform').find('div').append('<input type="hidden" name="reason" value="'+reason+'">');
            $('#submitform').prop('method', 'POST');
            $('#submitform').submit();
        }
    </script>
@endsection
