@extends('Layout.app')
@section('local-css')

@endsection

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Tambah Assumption Budget</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Budget</li>
                    <li class="breadcrumb-item">Assumption Budget</li>
                    <li class="breadcrumb-item active">Tambah Assumption Budget</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="content-body px-4">
    <div class="row">
        <div class="col-3">
            <div class="form-group">
                <label class="required_field">Pilihan Area / SalesPoint</label>
                <select class="form-control select2" name="salespoint_id" id="salespoint_select">
                    <option value="" data-isjawasumatra="-1">-- Pilih SalesPoint --</option>
                    @foreach ($available_salespoints as $region)
                    <optgroup label="{{$region->first()->region_name()}}">
                        @foreach ($region as $salespoint)
                        <option value="{{$salespoint->id}}"
                            data-isjawasumatra="{{$salespoint->isJawaSumatra}}">{{$salespoint->name}} --
                            {{$salespoint->jawasumatra()}} Jawa Sumatra</option>
                        @endforeach
                    </optgroup>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-6 d-flex align-items-center">
            <div class="form-group mr-2">
              <label class="required_field">Pilih File Template</label>
              <input type="file" class="form-control-file" 
                placeholder="Pilih File Template Assumption" id="file_template"
                accept=".xls, .xlsx"/>
            </div>
            <div>
                <button type="button" class="btn btn-primary mr-2" onclick="listToTable()">Refresh Data</button>
            </div>
            <div>
                <a class="btn btn-info mr-2" href="/template/assumption_budget_template.xlsx">Download Template</a>
            </div>
        </div>
        <div class="col-3 d-flex align-items-center justify-content-end">
            <button type="button" class="btn btn-warning" id="oldbudget_button" data-toggle="modal" data-target="#oldbudget_modal" style="display: none">
                Tampilkan Budget Lama
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table" id="template_table">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Group</th>
                        <th>Name</th>
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
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label class="required_field">Pilih Otorisasi</label>
                <select class="form-control" id="authorization" name="authorization_id" disabled required>
                  <option value="">-- Pilih Otorisasi --</option>
                </select>
                <small class="text-danger">*otorisasi yang muncul berdasarkan pilihan salespoint</small>
              </div>
        </div>
    </div>
    <div class="d-flex justify-content-center text-center mt-1">
        <button type="button" class="btn btn-primary" onclick="submitBudget()">Buat Pengajuan Budget</button>
    </div>
</div>
<form action="/createBudgetRequest" method="post" id="submitform">
    @csrf
    <div></div>
</form>

<!-- Modal -->
<div class="modal fade" id="oldbudget_modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-4">
                        <table class="table table-borderless table-sm">
                            <tbody>
                                <tr>
                                    <td class="font-weight-bold">Status</td>
                                    <td class="status"></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Periode</td>
                                    <td class="period"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-12">
                        <table class="table table-bordered list_table table-sm">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Group</th>
                                    <th>Name</th>
                                    <th>Qty</th>
                                    <th>Value</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-12 text-danger">
                        * Status budget lama akan menjadi non aktif saat melakukan pengajuan budget baru di salespoint yang sama
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('local-js')
    <script lang="javascript" src="/js/xlsx.full.min.js"></script>
    <script>
        var fileobject;
        $(document).ready(function() {
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
                        console.log(fileobject);
                        $('#refreshbutton').prop('disabled',true);  
                    });
                }
                reader.onerror = function(event) {
                    alert('Gagal membaca file');
                    $('#refreshbutton').prop('disabled',true);
                }

                reader.readAsBinaryString(selectedFile);
            });
            $('#salespoint_select').change(function() {
                let salespoint_id = $(this).val();
                loadAuthorizationbySalespoint(salespoint_id);
                checkifBudgetExist(salespoint_id);
            });
        });

        function listToTable() {
            $('#template_table tbody').empty();
            let filtered_data = fileobject.filter(function(object){
                if(object["CODE"] != null && object["GROUP"] != null && object["NAME"] != null && object["QTY"] != null && object["VALUE"] != null && object["AMOUNT"] != null){
                    return true;
                }else{
                    return false;
                }
            });
            filtered_data.forEach(function(data){
                $append_row = '<tr>';
                $append_row += '<td>'+data["CODE"]+'</td>';
                $append_row += '<td>'+data["GROUP"]+'</td>';
                $append_row += '<td>'+data["NAME"]+'</td>';
                $append_row += '<td>'+data["QTY"]+'</td>';
                $append_row += '<td>'+parseInt(data["VALUE"])+'</td>';
                $append_row += '<td>'+parseInt(data["AMOUNT"])+'</td>';
                $append_row += '</tr>';
                $('#template_table tbody').append($append_row);
            });
        }

        function loadAuthorizationbySalespoint(salespoint_id){
            $('#authorization').find('option[value!=""]').remove();
            $('#authorization').prop('disabled', true);
            if(salespoint_id == ""){
                return;
            }
            $.ajax({
                type: "get",
                url: '/getBudgetAuthorizationbySalespoint/'+salespoint_id,
                success: function (response) {
                    let data = response.data;
                    if(data.length == 0){
                        alert('Otorisasi Upload Budget tidak tersedia untuk salespoint yang dipilih, silahkan mengajukan otorisasi ke admin');
                        return;
                    }
                    data.forEach(item => {
                        let namelist = item.list.map(a => a.employee_name);
                        let option_text = '<option value="'+item.id+'">'+namelist.join(" -> ")+'</option>';
                        $('#authorization').append(option_text);
                    });
                    $('#authorization').val("");
                    $('#authorization').trigger('change');
                    $('#authorization').prop('disabled', false);
                },
                error: function (response) {
                    alert('load data failed. Please refresh browser or contact admin');
                    $('#authorization').find('option[value!=""]').remove();
                    $('#authorization').prop('disabled', true);
                },
                complete: function () {
                    $('#authorization').val("");
                    $('#authorization').trigger('change');
                    $('#authorization').prop('disabled', false);
                }
            });
        }

        function submitBudget(){
            // validate
            let salespoint_id = $('#salespoint_select').val();
            let authorization_id = $('#authorization').val();
            let append_input_text = "";
            if(salespoint_id == ""){
                alert('Salespoint belum dipilih');
                return;
            }
            append_input_text += "<input type='hidden' name='salespoint_id' value='"+salespoint_id+"'>";
            if(authorization_id == ""){
                alert('Otorisasi belum dipilih');
                return;
            }
            append_input_text += "<input type='hidden' name='authorization_id' value='"+authorization_id+"'>";
            let count =0;
            $('#template_table tbody tr').each(function(index){
                count++;
                let code = $(this).find('td:eq(0)').text().trim();
                let group = $(this).find('td:eq(1)').text().trim();
                let name = $(this).find('td:eq(2)').text().trim();
                let qty = $(this).find('td:eq(3)').text().trim();
                let value = $(this).find('td:eq(4)').text().trim();
                let amount = $(this).find('td:eq(5)').text().trim();
                append_input_text += "<input type='hidden' name='item["+index+"][code]' value='"+code+"'>";
                append_input_text += "<input type='hidden' name='item["+index+"][group]' value='"+group+"'>";
                append_input_text += "<input type='hidden' name='item["+index+"][name]' value='"+name+"'>";
                append_input_text += "<input type='hidden' name='item["+index+"][qty]' value='"+qty+"'>";
                append_input_text += "<input type='hidden' name='item["+index+"][value]' value='"+value+"'>";
                append_input_text += "<input type='hidden' name='item["+index+"][amount]' value='"+amount+"'>";
            });
            if(count == 0){
                alert('minimal 1 data');
                return;
            }
            $('#submitform div').empty();
            $('#submitform div').append(append_input_text);
            $('#submitform').submit()
        }

        function checkifBudgetExist(salespoint_id){
            $('#oldbudget_button').hide();
            $('#oldbudget_modal .list_table tbody').empty();

            if(salespoint_id == ""){
                return;
            }else{
                let requestdata = {
                    salespoint_id: salespoint_id,
                    type: "assumption"
                };
                $.ajax({
                    type: "GET",
                    url: "/getActiveSalespointBudget",
                    data: requestdata,
                    success: function (response) {
                        let data = response.data;
                        if(data.budget != null){
                            $('#oldbudget_button').show();
                            $('#oldbudget_modal .modal_title').text(data.budget.code);
                            $('#oldbudget_modal .status').text(':'+data.budget.status);
                            $('#oldbudget_modal .period').text(':'+data.budget.period);
                            data.lists.forEach(function(item,index){
                                let append_row_text = '<tr>';
                                append_row_text += '<td>'+item.code+'</td>';
                                append_row_text += '<td>'+item.group+'</td>';
                                append_row_text += '<td>'+item.name+'</td>';
                                append_row_text += '<td>'+item.qty+'</td>';
                                append_row_text += '<td>'+setRupiah(item.value)+'</td>';
                                append_row_text += '<td>'+setRupiah(item.amount)+'</td>';
                                append_row_text += '<td>'+item.pending_quota+'</td>';
                                append_row_text += '<td>'+item.used_quota+'</td>';
                                append_row_text += '</tr>';
                                $('#oldbudget_modal .list_table tbody').append(append_row_text);
                            });
                        }

                    },
                    error: function (response){
                    }
                });
            }
        }
    </script>
@endsection
