@extends('Layout.app')
@section('local-css')
<style>
    .box {
        box-shadow: 0px 1px 2px rgba(0, 0, 0,0.25);
        border : 1px solid;
        border-color: gainsboro;
        border-radius: 0.5em;
    }
    .brand_list{
        font-size: 15px !important;
        padding-top: 0.4em !important;
        padding-bottom: 0.4em !important;
        margin-right: 0.4em !important;
        margin-bottom: 0.4em !important;
    }
    .brand_list .brand_remove{
        cursor: pointer;
        margin-left: 10px;
    }
    .type_list{
        font-size: 15px !important;
        padding-top: 0.4em !important;
        padding-bottom: 0.4em !important;
        margin-right: 0.4em !important;
        margin-bottom: 0.4em !important;
    }
    .type_list .type_remove{
        cursor: pointer;
        margin-left: 10px;
    }
</style>
@endsection

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Budget Pricing</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Masterdata</li>
                    <li class="breadcrumb-item active">Budget Pricing</li>
                </ol>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-2">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addBudgetModal">
                Tambah Budget Pricing
            </button>
        </div>
    </div>
</div>
<div class="content-body px-4">
    <div class="table-responsive">
        <table id="budgetDT" class="table table-bordered table-striped dataTable" role="grid">
            <thead>
                <tr>
                    <th rowspan="2">
                        #
                    </th>
                    <th rowspan="2">
                        Kode
                    </th>
                    <th rowspan="2">
                        Nama
                    </th>
                    <th rowspan="2">
                        Kategori
                    </th>
                    <th rowspan="2">
                        Brand / Merk
                    </th>
                    <th rowspan="2">
                        Tipe
                    </th>
                    <th colspan="2">
                        Range Jawa Sumatra
                    </th>
                    <th colspan="2">
                        Range Luar Jawa Sumatra
                    </th>
                </tr>
                <tr>
                    <th>Min</th>
                    <th>Max</th>
                    <th>Min</th>
                    <th>Max</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($budgets as $key => $budget)
                    <tr data-budget="{{$budget}}"
                        data-brand="{{$budget->budget_brand->pluck('name')}}"
                        data-type="{{$budget->budget_type->pluck('name')}}">
                        <td>{{$key+1}}</td>
                        <td>{{$budget->code}}</td>
                        <td>{{$budget->name}}</td>
                        <td>{{$budget->budget_pricing_category->name}}</td>
                        <td>
                            {{$budget->brand_list_text()}}
                        </td>
                        <td>
                            {{$budget->type_list_text()}}
                        </td>
                        @if ($budget->injs_min_price !=null)<td class="rupiah_text">{{$budget->injs_min_price}}</td> @else <td>-</td> @endif
                        @if ($budget->injs_max_price !=null)<td class="rupiah_text">{{$budget->injs_max_price}}</td> @else <td>-</td> @endif
                        @if ($budget->outjs_min_price !=null)<td class="rupiah_text">{{$budget->outjs_min_price}}</td> @else <td>-</td> @endif
                        @if ($budget->outjs_max_price !=null)<td class="rupiah_text">{{$budget->outjs_max_price}}</td> @else <td>-</td> @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addBudgetModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Budget Pricing</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="required_field">Kategori</label>
                            <select class="form-control pricing_category" name="category" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($budget_categories as $category)
                                    <option value="{{ $category->id }}" data-code="{{ $category->code }}">{{ $category->name }} -- {{ $category->code }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="required_field">Nama</label>
                            <input type="text" class="form-control" name="name" placeholder="Masukkan nama budget" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="optional_field">Merk</label>
                        <div class="d-flex flex-row flex-wrap brand_list_container">
                        </div>
                        <div class="form-inline">
                            <div class="form-group">
                                <input type="text" class="form-control brand_input">
                            </div>
                            <button type="button" class="btn btn-primary ml-3 add_brand">Tambah</button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="optional_field">Tipe</label>
                        <div class="d-flex flex-row flex-wrap type_list_container">
                        </div>
                        <div class="form-inline">
                            <div class="form-group">
                                <input type="text" class="form-control type_input">
                            </div>
                            <button type="button" class="btn btn-primary ml-3 add_type">Tambah</button>
                        </div>
                    </div>
                    <div class="col-md-12 box p-3 mt-3">
                        <h5>Dalam Jawa Sumatra</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="optional_field">Harga Minimum</label>
                                    <input type="text" class="form-control rupiah" id="add_injs_min_price" name="injs_min_price" placeholder="Masukan Harga Minimum" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required_field">Harga Maksimum</label>
                                    <input type="text" class="form-control rupiah" id="add_injs_max_price" name="injs_max_price" placeholder="Masukan Harga Maksimum" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 box p-3 mt-3">
                        <h5>Luar Jawa Sumatra</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="optional_field">Harga Minimum</label>
                                    <input type="text" class="form-control rupiah" id="add_outjs_min_price" name="outjs_min_price" placeholder="Masukan Harga Minimum" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required_field">Harga Maksimum</label>
                                    <input type="text" class="form-control rupiah" id="add_outjs_max_price" name="outjs_max_price" placeholder="Masukan Harga Maksimum" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="addBudget(this)">Tambah Budget</button>
            </div>
        </div>
        <form action="/addbudget" method="post" id="addform">
        @csrf
        <div class="input_field">

        </div>
        </form>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="detailBudgetModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Budget Pricing</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="required_field">Kategori</label>
                            <select class="form-control" name="category" disabled>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($budget_categories as $category)
                                    <option value="{{ $category->id }}" data-code="{{ $category->code }}">{{ $category->name }} -- {{ $category->code }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="required_field">Nama</label>
                            <input type="text" class="form-control" name="name" placeholder="Masukkan nama budget" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="optional_field">Merk</label>
                        <div class="d-flex flex-row flex-wrap brand_list_container">
                        </div>
                        <div class="form-inline">
                            <div class="form-group">
                                <input type="text" class="form-control brand_input">
                            </div>
                            <button type="button" class="btn btn-primary ml-3 add_brand">Tambah</button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="optional_field">Tipe</label>
                        <div class="d-flex flex-row flex-wrap type_list_container">
                        </div>
                        <div class="form-inline">
                            <div class="form-group">
                                <input type="text" class="form-control type_input">
                            </div>
                            <button type="button" class="btn btn-primary ml-3 add_type">Tambah</button>
                        </div>
                    </div>
                    <div class="col-md-12 box p-3 mt-3">
                        <h5>Dalam Jawa Sumatra</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="optional_field">Harga Minimum</label>
                                    <input type="text" class="form-control rupiah" name="injs_min_price" placeholder="Masukan Harga Minimum">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required_field">Harga Maksimum</label>
                                    <input type="text" class="form-control rupiah" name="injs_max_price" placeholder="Masukan Harga Maksimum">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 box p-3 mt-3">
                        <h5>Luar Jawa Sumatra</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="optional_field">Harga Minimum</label>
                                    <input type="text" class="form-control rupiah" name="outjs_min_price" placeholder="Masukan Harga Minimum">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required_field">Harga Maksimum</label>
                                    <input type="text" class="form-control rupiah" name="outjs_max_price" placeholder="Masukan Harga Maksimum">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-danger" onclick="deleteBudget(this)">Hapus Budget</button>
                <button type="button" class="btn btn-primary" onclick="updateBudget(this)">Perbarui Budget</button>
            </div>
        </div>
        <form action="/updatebudget" method="post" id="updateform">
            @csrf
            @method('patch')
            <input type="hidden" name="id">
            <div class="input_field">

            </div>
        </form>
        <form action="/deletebudget" method="post" id="deleteform">
            @csrf
            @method('delete')
            <input type="hidden" name="id">
        </form>
    </div>
</div>

@endsection
@section('local-js')
<script>
    $(document).ready(function(){
        var table = $('#budgetDT').DataTable(datatable_settings);
        $('#budgetDT tbody').on('click', 'tr', function () {
            let modal = $('#detailBudgetModal');
            let data =  $(this).data('budget');
            let brands =  $(this).data('brand');
            let types =  $(this).data('type');
            let id = modal.find('input[name="id"]');
            let category = modal.find('select[name="category"]');
            let name = modal.find('input[name="name"]');
            let brand_list_container = modal.find('.brand_list_container');
            let type_list_container = modal.find('.type_list_container');
            let injs_min = modal.find('input[name="injs_min_price"]');
            let injs_max = modal.find('input[name="injs_max_price"]');
            let outjs_min = modal.find('input[name="outjs_min_price"]');
            let outjs_max = modal.find('input[name="outjs_max_price"]');
            let injs_min_field = autoNumeric_field[$('.rupiah').index(injs_min)];
            let injs_max_field = autoNumeric_field[$('.rupiah').index(injs_max)];
            let outjs_min_field = autoNumeric_field[$('.rupiah').index(outjs_min)];
            let outjs_max_field = autoNumeric_field[$('.rupiah').index(outjs_max)];
            id.val(data['id']);
            name.val(data['name']);
            category.val(data['budget_pricing_category_id']);
            let category_code =  modal.find('select[name="category"]').find('option:selected').data('code');
            // if jasa change harga maksimum to optional
            if(category_code == "JS"){
                injs_max.closest('.form-group').find('label').removeClass('required_field').addClass('optional_field');
                outjs_max.closest('.form-group').find('label').removeClass('required_field').addClass('optional_field');
            }else{
                injs_max.closest('.form-group').find('label').removeClass('optional_field').addClass('required_field');
                outjs_max.closest('.form-group').find('label').removeClass('optional_field').addClass('required_field');
            }
            injs_min_field.set(data['injs_min_price']);
            injs_max_field.set(data['injs_max_price']);
            outjs_min_field.set(data['outjs_min_price']);
            outjs_max_field.set(data['outjs_max_price']);

            brand_list_container.empty();
            brands.forEach(function(brand){
                brand_list_container.append('<span class="badge badge-pill badge-primary brand_list"><span class="brand_text">'+brand+'</span><span class="brand_remove">x</span></span>');
            });
            
            type_list_container.empty();
            types.forEach(function(type){
                type_list_container.append('<span class="badge badge-pill badge-info type_list"><span class="type_text">'+type+'</span><span class="type_remove">x</span></span>')
            })
            modal.modal('show');
        });
        $('.modal').find('.pricing_category').change(function(){
            let closestmodal = $(this).closest('.modal');
            let in_min_js = closestmodal.find('input[name="injs_min_price"]');
            let in_max_js = closestmodal.find('input[name="injs_max_price"]');
            let out_min_js = closestmodal.find('input[name="outjs_min_price"]');
            let out_max_js = closestmodal.find('input[name="outjs_max_price"]');
            let in_min_js_rupiah = AutoNumeric.getAutoNumericElement('#addBudgetModal input[name="injs_min_price"]');
            let in_max_js_rupiah = AutoNumeric.getAutoNumericElement('#addBudgetModal input[name="injs_max_price"]');
            let out_min_js_rupiah = AutoNumeric.getAutoNumericElement('#addBudgetModal input[name="outjs_min_price"]');
            let out_max_js_rupiah = AutoNumeric.getAutoNumericElement('#addBudgetModal input[name="outjs_max_price"]');
            in_min_js_rupiah.set(0);
            in_max_js_rupiah.set(0);
            out_min_js_rupiah.set(0);
            out_max_js_rupiah.set(0);
            
            let category_code = $(this).find('option:selected').data('code');
            in_min_js.prop('disabled',false);
            in_max_js.prop('disabled',false);
            out_min_js.prop('disabled',false);
            out_max_js.prop('disabled',false);
            if(category_code === undefined){
                in_min_js.prop('disabled',true);
                in_max_js.prop('disabled',true);
                out_min_js.prop('disabled',true);
                out_max_js.prop('disabled',true);
            }
            // if jasa change harga maksimum to optional
            if(category_code == "JS"){
                in_max_js.closest('.form-group').find('label').removeClass('required_field').addClass('optional_field');
                out_max_js.closest('.form-group').find('label').removeClass('required_field').addClass('optional_field');
            }else{
                in_max_js.closest('.form-group').find('label').removeClass('optional_field').addClass('required_field');
                out_max_js.closest('.form-group').find('label').removeClass('optional_field').addClass('required_field');
            }
        });
    });
    // BRAND CONTROL
    $(document).on('click','.brand_remove',function(){
        $(this).closest('.brand_list').remove();
    });
    $(document).on('click','.add_brand',function(){
        let modal = $(this).closest('.modal');
        let input = modal.find('.brand_input');
        let container = modal.find('.brand_list_container');
        if(input.val().trim() != ""){
            container.append('<span class="badge badge-pill badge-primary brand_list"><span class="brand_text">'+input.val()+'</span><span class="brand_remove">x</span></span>');
            input.val("");
        }
    });
    // TYPE CONTROL
    $(document).on('click','.type_remove',function(){
        $(this).closest('.type_list').remove();
    });
    $(document).on('click','.add_type',function(){
        let modal = $(this).closest('.modal');
        let input = modal.find('.type_input');
        let container = modal.find('.type_list_container');
        if(input.val().trim() != ""){
            container.append('<span class="badge badge-pill badge-info type_list"><span class="type_text">'+input.val()+'</span><span class="type_remove">x</span></span>');
            input.val("");
        }
    });
    function addBudget(el){
        let closestmodal = $(el).closest('.modal');
        let category = closestmodal.find('select[name="category"]');
        let name = closestmodal.find('input[name="name"]');
        let injs_min = closestmodal.find('input[name="injs_min_price"]');
        let injs_max = closestmodal.find('input[name="injs_max_price"]');
        let outjs_min = closestmodal.find('input[name="outjs_min_price"]');
        let outjs_max = closestmodal.find('input[name="outjs_max_price"]');
        let injs_min_field = autoNumeric_field[$('.rupiah').index(injs_min)];
        let injs_max_field = autoNumeric_field[$('.rupiah').index(injs_max)];
        let outjs_min_field = autoNumeric_field[$('.rupiah').index(outjs_min)];
        let outjs_max_field = autoNumeric_field[$('.rupiah').index(outjs_max)];
        
        if(category.val()==""){
            alert('Kategori harus diisi');
            return;
        }
        if(name.val()==""){
            alert('Nama harus diisi');
            return;
        }
        if(category.find('option:selected').data('code') != "JS"){
            if(injs_max_field.get() == 0){
                alert('Harga maksimum Dalam Jawa Sumatra Harus diisi');
                return;
            }
            if(outjs_max_field.get() == 0){
                alert('Harga maksimum Luar Jawa Sumatra Harus diisi');
                return;
            }
        }
        closestmodal.find('.input_field').empty();
        closestmodal.find('.input_field').append('<input type="hidden" name="budget_pricing_category_id" value="'+category.val()+'">');
        closestmodal.find('.input_field').append('<input type="hidden" name="name" value="'+name.val()+'">');
        closestmodal.find('.brand_list').each((index,el)=>{
            closestmodal.find('.input_field').append('<input type="hidden" name="brand[]" value="'+$(el).find('.brand_text').text().trim()+'">');
        });
        closestmodal.find('.type_list').each((index,el)=>{
            closestmodal.find('.input_field').append('<input type="hidden" name="type[]" value="'+$(el).find('.type_text').text().trim()+'">');
        });
        closestmodal.find('.input_field').append('<input type="hidden" name="injs_min_price" value="'+injs_min_field.get()+'">');
        closestmodal.find('.input_field').append('<input type="hidden" name="injs_max_price" value="'+injs_max_field.get()+'">');
        closestmodal.find('.input_field').append('<input type="hidden" name="outjs_min_price" value="'+outjs_min_field.get()+'">');
        closestmodal.find('.input_field').append('<input type="hidden" name="outjs_max_price" value="'+outjs_max_field.get()+'">');
        $('#addform').submit();
    }
    function updateBudget(el){
        let closestmodal = $(el).closest('.modal');
        let category = closestmodal.find('select[name="category"]');
        let name = closestmodal.find('input[name="name"]');
        let brand = closestmodal.find('textarea[name="brand"]');
        let type = closestmodal.find('textarea[name="type"]');
        let injs_min = closestmodal.find('input[name="injs_min_price"]');
        let injs_max = closestmodal.find('input[name="injs_max_price"]');
        let outjs_min = closestmodal.find('input[name="outjs_min_price"]');
        let outjs_max = closestmodal.find('input[name="outjs_max_price"]');
        let injs_min_field = autoNumeric_field[$('.rupiah').index(injs_min)];
        let injs_max_field = autoNumeric_field[$('.rupiah').index(injs_max)];
        let outjs_min_field = autoNumeric_field[$('.rupiah').index(outjs_min)];
        let outjs_max_field = autoNumeric_field[$('.rupiah').index(outjs_max)];
        
        if(category.val()==""){
            alert('Kategori harus diisi');
            return;
        }
        if(name.val()==""){
            alert('Nama harus diisi');
            return;
        }
        if(category.find('option:selected').data('code') != "JS"){
            if(injs_max_field.get() == 0){
                alert('Harga maksimum Dalam Jawa Sumatra Harus diisi');
                return;
            }
            if(outjs_max_field.get() == 0){
                alert('Harga maksimum Luar Jawa Sumatra Harus diisi');
                return;
            }
        }
        closestmodal.find('.input_field').empty();
        closestmodal.find('.input_field').append('<input type="hidden" name="budget_pricing_category_id" value="'+category.val()+'">');
        closestmodal.find('.input_field').append('<input type="hidden" name="name" value="'+name.val()+'">');
        closestmodal.find('.brand_list').each((index,el)=>{
            closestmodal.find('.input_field').append('<input type="hidden" name="brand[]" value="'+$(el).find('.brand_text').text().trim()+'">');
        });
        closestmodal.find('.type_list').each((index,el)=>{
            closestmodal.find('.input_field').append('<input type="hidden" name="type[]" value="'+$(el).find('.type_text').text().trim()+'">');
        });
        closestmodal.find('.input_field').append('<input type="hidden" name="injs_min_price" value="'+injs_min_field.get()+'">');
        closestmodal.find('.input_field').append('<input type="hidden" name="injs_max_price" value="'+injs_max_field.get()+'">');
        closestmodal.find('.input_field').append('<input type="hidden" name="outjs_min_price" value="'+outjs_min_field.get()+'">');
        closestmodal.find('.input_field').append('<input type="hidden" name="outjs_max_price" value="'+outjs_max_field.get()+'">');
        $('#updateform').submit();
    }
    function deleteBudget(){
        if (confirm('Budget yang dihapus tidak dapat dikembalikan lagi. Lanjutkan?')) {
            $('#deleteform').submit();
        }
    }
    
</script>
@endsection
