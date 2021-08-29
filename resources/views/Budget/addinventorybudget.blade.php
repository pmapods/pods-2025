@extends('Layout.app')
@section('local-css')

@endsection

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Tambah Inventory Budget</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Budget</li>
                    <li class="breadcrumb-item">Inventory Budget</li>
                    <li class="breadcrumb-item active">Tambah Inventory Budget</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="content-body px-4">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label class="required_field">Pilihan Area / SalesPoint</label>
                <select class="form-control select2" name="salespoint_id">
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
        <div class="col-md-4">
            <div class="form-group">
              <label class="required_field">Pilih File Template</label>
              <input type="file" class="form-control-file" 
                placeholder="Pilih File Template Inventory" id="file_template"
                accept=".xls, .xlsx"/>
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
</div>

@endsection
@section('local-js')
    <script lang="javascript" src="js/xlsx.full.min.js"></script>
    <script>
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
                        var XL_row_object = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
                        listToTable(XL_row_object);
                    });
                }
                reader.onerror = function(event) {
                    console.error('File could not be read! Code '+event.target.error.code)
                }

                reader.readAsBinaryString(selectedFile);
            });
        });

        function listToTable(objects) {
            $('#template_table tbody').empty();
            let filtered_data = objects.filter(function(object){
                console.log(object);
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
    </script>
@endsection
