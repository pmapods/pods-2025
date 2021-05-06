
var temp_ba_file = null;
var temp_ba_extension = null;

var temp_nonbudget_olditem_file = null;
var temp_nonbudget_olditem_extension = null;

var temp_olditem_file = null;
var temp_olditem_extension = null;
$(document).ready(function () {
    // set minimal tanggal pengadaan 14 setelah tanggal pengajuan
    tableVendorRefreshed();
    $('.requirement_date').val(moment().add(14,'days').format('YYYY-MM-DD'));
    $('.requirement_date').prop('min',moment().add(14,'days').format('YYYY-MM-DD'));
    $('.requirement_date').trigger('change');

    $('.salespoint_select2').on('change', function () {
        let salespoint_select = $('.salespoint_select2');
        let area_status = $('.area_status');
        let authorization_select = $('.authorization_select2');
        let loading = $('.loading_salespoint_select2');

        let isjawasumatra = salespoint_select.find('option:selected').data('isjawasumatra');

        // initial state
        if (isjawasumatra == 1) {
            area_status.text('Dalam Jawa Sumatra');
        } else if (isjawasumatra == 0) {
            area_status.text('Luar Jawa Sumatra');
        } else {
            area_status.text('-');
        }
        authorization_select.prop('disabled', true);
        authorization_select.find('option').remove();
        var empty = new Option('-- Pilih Otorisasi --', "", false, true);
        authorization_select.append(empty);
        authorization_select.trigger('change');

        if (salespoint_select.val() == "") {
            return;
        }

        loading.show();
        $.ajax({
            type: "get",
            url: "/getsalespointauthorization/" + salespoint_select.val(),
            success: function (response) {
                let data = response.data;
                data.forEach(item => {
                    let option_text = item.detail[0].name + ' -- ' + item.detail[0].position + ' ( ' + item.detail[0].as + ' )';
                    var newOption = new Option(option_text, item.id, false, true);
                    authorization_select.append(newOption);
                    authorization_select.find('option:selected').data('item', item);
                });
                authorization_select.val("");
                authorization_select.trigger('change');
                authorization_select.prop('disabled', false);
            },
            error: function (response) {
                alert('load data failed. Please refresh browser or contact admin')
            },
            complete: function () {
                loading.hide();
            }
        });
    });

    $('input[type="file"]').change(function(){
        if(this.files[0].size > 5242880){
            alert("File melebihi kapasitas maksimum");
            this.value('');
        };
    });

    $('.authorization_select2').on('change', function () {
        let field = $('.authorization_list_field');
        let item_type = $('.item_type');
        // initial state
        field.empty();
        let selected_data = $(this).find('option:selected').data('item');
        if (selected_data) {
            selected_data.detail.forEach(item => {
                field.append('<div class="mb-3"><span class="font-weight-bold">' + item.name + ' -- ' + item.position + '</span><br><span>' + item.as + '</span></div>');
            });
            item_type.prop('disabled',false);
        } else {
            field.append('<div>Belum memilih otorisasi</div>');
            item_type.val("");
            item_type.prop('disabled',true);
        }
        item_type.trigger('change');
    });

    $('.item_type').on('change', function () {
        let request_select = $('.request_type');
        let budget_item = $('.select_budget_item');
        let type = $(this).val();
        // 0 barang
        // 1 jasa
        request_select.prop('disabled',false);
        // filter di budget item
        let options = budget_item.find('option');
        switch (type) {
            case "0":
                // barang (hide option jasa)
                options.each((index,el)=>{
                    if($(el).data('categorycode')=="JS"){
                        $(el).prop('disabled',true);
                    }else{
                        $(el).prop('disabled',false);
                    }
                });
                break;
            case "1":
                // jasa (hide selain jasa)
                options.each((index,el)=>{
                    if($(el).data('categorycode')=="JS"){
                        $(el).prop('disabled',false);
                    }else{
                        $(el).prop('disabled',true);
                    }
                });
                break;
            default:
                // not selected
                request_select.prop('disabled',true);
                request_select.val("");
                break;
        }
        request_select.trigger('change');

    });

    $('.request_type').on('change', function () {
        let budget_type = $('.budget_type');
        budget_type.prop('disabled',true);
        if($(this).val()!=""){
            budget_type.val('');
            budget_type.prop('disabled',false);
        }
        budget_type.trigger('change');
        if($(this).val()==1){
            $('.budget_olditem_field').show();
            $('.budget_expired_field').show();
            $('.nonbudget_olditem_field').show();
            $('.nonbudget_expired_field').show();
        }else{
            $('.budget_olditem_field').hide();
            $('.budget_expired_field').hide();
            $('.nonbudget_olditem_field').hide();
            $('.nonbudget_expired_field').hide();
        }
    });

    $('.budget_type').on('change', function () {
        let type = $(this).val();

        $('.budget_item_adder').addClass('d-none');
        $('.nonbudget_item_adder').addClass('d-none');
        if (type === '0') {
            // budget
            $('.budget_item_adder').removeClass('d-none');

        } else if (type === '1') {
            // non budget
            $('.nonbudget_item_adder').removeClass('d-none');
        }
    });

    $('.select_budget_item').on('change', function () {
        let salespoint_select = $('.salespoint_select2');
        let isjawasumatra = salespoint_select.find('option:selected').data('isjawasumatra');
        let item_min_price = $('.item_min_price');
        let item_max_price = $('.item_max_price');
        let price = $('.price_budget_item');
        let price_field = autoNumeric_field[$('.rupiah').index(price)];
        price_field.set(0);

        let minjs = $(this).find('option:selected').data('minjs');
        let maxjs = $(this).find('option:selected').data('maxjs');
        let minoutjs = $(this).find('option:selected').data('minoutjs');
        let maxoutjs = $(this).find('option:selected').data('maxoutjs');
        let brands = $(this).find('option:selected').data('brand');
        let types = $(this).find('option:selected').data('type');

        price_field.options.minimumValue(0);
        if (isjawasumatra == 1) {
            item_min_price.text((Number.isInteger(minjs)) ? setRupiah(minjs) : '-');
            item_max_price.text((Number.isInteger(maxjs)) ? setRupiah(maxjs) : '-');
            // price_field.options.maximumValue(maxjs);
            price.prop('disabled', false)
        } else if (isjawasumatra == 0) {
            item_min_price.text((Number.isInteger(minoutjs)) ? setRupiah(minoutjs) : '-');
            item_max_price.text((Number.isInteger(maxoutjs)) ? setRupiah(maxoutjs) : '-');
            // price_field.options.maximumValue(maxoutjs);
            price.prop('disabled', false)
        } else {
            item_min_price.text('-');
            item_max_price.text('-');
            // price_field.options.maximumValue(0);
            price.prop('disabled', true)
        }

        // set pilih merk selection
        $('.select_budget_brand').empty();
        $('.select_budget_brand').prop('disabled',true);
        if(brands != null){
            if(brands.length > 0) {
                brands.forEach((brand) => {
                    $('.select_budget_brand').append('<option value="'+brand.name+'">'+brand.name+'</option>');
                });
            }
            $('.select_budget_brand').append('<option value="-1">Merk Lain</option>');
            $('.select_budget_brand').prop('disabled',false);
        }
        $('.select_budget_brand').trigger('change');

        // set pilih tipe selection
        $('.select_budget_type').empty();
        $('.select_budget_type').prop('disabled',true);
        if(types !=null){
            if(types.length > 0) {
                types.forEach((type) => {
                    $('.select_budget_type').append('<option value="'+type.name+'">'+type.name+'</option>');
                });
            }
            $('.select_budget_type').append('<option value="-1">Tipe Lain</option>');
            $('.select_budget_type').prop('disabled',false);
        }
        $('.select_budget_type').trigger('change');
    });

    $('.select_budget_brand').on('change',()=>{
        let value_brand = $('.select_budget_brand').val();

        $('.budget_ba_field').hide();
        $('.input_budget_brand_field').hide();
        if(value_brand == -1){
            $('.input_budget_brand_field').show();
        }
        checkNeedBA();
    });

    $('.select_budget_type').on('change',()=>{
        let value_type = $('.select_budget_type').val();
        $('.budget_ba_field').hide();
        $('.input_budget_type_field').hide();
        if(value_type == -1){
            $('.input_budget_type_field').show();
        }
        checkNeedBA();
    });

    function checkNeedBA(){
        let value_brand = $('.select_budget_brand').val();
        let value_type = $('.select_budget_type').val();
        let brands = $('.select_budget_item').find('option:selected').data('brand');
        let types = $('.select_budget_item').find('option:selected').data('type');
        // check apakah butuh BA
        let is_ba_required = false;
        if(brands != null){
            if(brands.length>0 && value_brand == -1){
                is_ba_required = true;
            }
        }
        if(types != null){
            if(types.length>0 && value_type == -1){
                is_ba_required = true;
            }
        }
        if(is_ba_required){
            $('.budget_ba_field').show();
        }else{
            $('.budget_ba_field').hide();
        }
    }

    $('.budget_ba_file').on('change', function (event) {
        var reader = new FileReader();
        let value = $(this).val()
        reader.onload = function(e) {
            temp_ba_file = e.target.result;
            temp_ba_extension = value.split('.').pop().toLowerCase();
        }
        reader.readAsDataURL(event.target.files[0]);
    });

    $('.budget_olditem_file').on('change', function (event) {
        var reader = new FileReader();
        let value = $(this).val()
        reader.onload = function(e) {
            temp_olditem_file = e.target.result;
            temp_olditem_extension = value.split('.').pop().toLowerCase();
        }
        reader.readAsDataURL(event.target.files[0]);
    });
    
    $('.nonbudget_olditem_file').on('change', function (event) {
        var reader = new FileReader();
        let value = $(this).val()
        reader.onload = function(e) {
            temp_nonbudget_olditem_file = e.target.result;
            temp_nonbudget_olditem_extension = value.split('.').pop().toLowerCase();
        }
        reader.readAsDataURL(event.target.files[0]);
    });

    $(this).on('click','.remove_attachment', function (event) {
        console.log($(this));
        $(this).closest('div').remove();
    })
});
// add budget
function addBudgetItem(el) {
    let select_item = $('.select_budget_item');
    let select_budget_brand = $('.select_budget_brand');
    let select_budget_type = $('.select_budget_type');
    let input_budget_brand = $('.input_budget_brand');
    let input_budget_type = $('.input_budget_type');
    let price_item = AutoNumeric.getAutoNumericElement('.price_budget_item');
    let budget_ba_field = $('.budget_ba_field');
    let budget_olditem_field = $('.budget_olditem_field');
    let budget_expired_date = $('.budget_expired_date');
    let count_item = $('.count_budget_item');
    let table_item = $('.table_item');
    
    let id = select_item.find('option:selected').val();
    let name = select_item.find('option:selected').text().trim();
    let price = price_item.get();
    let price_text = price_item.domElement.value;
    let count = count_item.val();

    let brand = select_budget_brand.val();
    let type = select_budget_type.val();
    if(brand == -1){
        brand = input_budget_brand.val().trim();
    }else{
        brand = brand;
    }
    if(type == -1){
        type = input_budget_type.val().trim();
    }else{
        type = type;
    }

    if (id == "") {
        alert("Item harus dipilih");
        return;
    }
    if(budget_olditem_field.is(':visible') && temp_olditem_file == null){
        alert("File Foto Item Lama harus diupload");
        return;
    }
    if (brand == "") {
        alert("Pilihan Merk harus dipilih / diisi");
        return;
    }
    if (type == "") {
        alert("Pilihan Tipe harus dipilih / diisi");
        return;
    }
    if(budget_ba_field.is(':visible') && temp_ba_file == null){
        alert("File Berita Acara Harus diupload");
        return;
    }
    if (price < 1000) {
        alert("Harga harus lebih besar dari Rp 1.000");
        return;
    }
    if (count < 1) {
        alert("Jumlah Item minimal 1");
        return;
    }
    let attachments_link = "";
    if(budget_ba_field.is(':visible')){
        attachments_link  += '<a class="attachment" href="'+temp_ba_file+'" download="ba_file.'+temp_ba_extension+'">ba_file.'+temp_ba_extension+'</a><br>';
    }
    if(budget_olditem_field.is(':visible')){
        attachments_link  += '<a class="attachment" href="'+temp_olditem_file+'" download="old_item.'+temp_olditem_extension+'">old_item.'+temp_olditem_extension+'</a><br>';
    }
    if(!budget_ba_field.is(':visible') && !budget_olditem_field.is(':visible')){
        attachments_link = '-';
    }
    let naming = name;
    if(budget_expired_date.val()!=""){
        naming = name+'<br>(expired : '+budget_expired_date.val()+')';
    }
    table_item.find('tbody').append('<tr class="item_list" data-id="' + id + '" data-name="' + name + '" data-price="' + price + '" data-count="' + count + '" data-brand="' + brand + '" data-expired="'+budget_expired_date.val()+'"><td>'+naming+'</td><td>' + brand + '</td><td>' + type + '</td><td>' + price_text + '</td><td>' + count + '</td><td>' + setRupiah(count * price) + '</td><td>' + attachments_link + '</td><td><i class="fa fa-trash text-danger remove_list" onclick="removeList(this)" aria-hidden="true"></i></td></tr>');

    select_item.val("");
    select_item.trigger('change');
    price_item.set(0);
    count_item.val("");
    input_budget_brand.val("");
    input_budget_type.val("");
    $('.budget_ba_file').val('');
    $('.budget_olditem_file').val('');
    budget_expired_date.val('');
    temp_ba_file = null;
    temp_ba_extension = null;
    temp_olditem_file = null;
    temp_olditem_extension = null;
    tableRefreshed(el);
}

function addAttachment() {
    if($('#attachment_file_input').val() == null || $('#attachment_file_input').val() == '') {
        alert('File attachment belum dipilih');
        return;
    }
    let filename = $('#attachment_file_input')[0].files[0].name;
    let file = null;
    var reader = new FileReader();
    reader.onload = function(e) {
        file = e.target.result;
        $('#attachment_list').append('<div><a href="'+file+'" download="'+filename+'">'+filename+'</a><span class="remove_attachment">X</span></div>');
        $('#attachment_file_input').val('');
    }
    reader.readAsDataURL($('#attachment_file_input')[0].files[0]);
}

// add non budget
function addNonBudgetItem(){

    let name = $('.input_nonbudget_name').val().trim();
    let brand = $('.input_nonbudget_brand').val().trim();
    let type = $('.input_nonbudget_type').val().trim();
    let expired_date = $('.nonbudget_expired_date').val();
    let price = AutoNumeric.getAutoNumericElement('.price_nonbudget_item');
    let price_text = price.domElement.value;
    let count = $('.count_nonbudget_item').val();

    if (name == "") {
        alert("Nama item harus diisi");
        return;
    } else if($('.nonbudget_olditem_field').is(':visible') && temp_nonbudget_olditem_file == null){
        alert("File Foto Item Lama harus diupload");
        return;
    } else if (brand == "") {
        alert("Merk harus diisi");
        return;
    } else if (type == "") {
        alert("Tipe harus diisi");
        return;
    } else if (price < 1000) {
        alert("Harga harus lebih besar dari Rp 1.000");
        return;
    } else if (count < 1) {
        alert("Jumlah Item minimal 1");
        return;
    } else {
         
    let attachments_link = "";
    if($('.nonbudget_olditem_field').is(':visible')){
        attachments_link  += '<a href="'+temp_nonbudget_olditem_file+'" download="old_item.'+temp_nonbudget_olditem_extension+'">old_item.'+temp_nonbudget_olditem_extension+'</a><br>';
    }
    if(!$('.nonbudget_olditem_field').is(':visible')){
        attachments_link = '-';
    }
    let naming = name;
    if(expired_date!=""){
        naming = name+'<br>(expired : '+expired_date+')';
    }
    $('.table_item').find('tbody').append('<tr class="item_list" data-id="-1" data-name="' + naming + '" data-brand="' + brand + '" data-type="' + type + '" data-price="' + price.get() + '" data-expired="'+expired_date+'"data-count="' + count + '"><td>' + name + '</td><td>' + brand + '</td><td>' + type + '</td><td>' + price_text + '</td><td>' + count + '</td><td>' + setRupiah(count * price.get()) + '</td><td>' + attachments_link + '</td><td><i class="fa fa-trash text-danger remove_list" onclick="removeList(this)" aria-hidden="true"></i></td></tr>');
  
    $('.input_nonbudget_name').val('');
    $('.input_nonbudget_brand').val('');
    $('.input_nonbudget_type').val('');
    $('.nonbudget_expired_date').val('');
    $('.count_nonbudget_item').val('');
    price.set(0);
    temp_nonbudget_olditem_file = null;
    temp_nonbudget_olditem_extension = null;

    tableRefreshed();
    }
}
// remove button
function removeList(el) {
    let tr = $(el).closest('tr');
    tr.remove();
    tableRefreshed();
}

// table on refresh
function tableRefreshed() {
    let table_item = $('.table_item');
    let salespoint_select = $('.salespoint_select2');
    let authorization_select = $('.authorization_select2');
    let item_select = $('.item_type');
    let request_select = $('.request_type');
    let budget_select = $('.budget_type');
    // check table level if table has data / tr or not
    let row_count = 0;
    table_item.find('tbody tr').not('.empty_row').each(function () {
        row_count++;
    });
    if (row_count > 0) {
        salespoint_select.prop('disabled',true);
        authorization_select.prop('disabled',true);
        item_select.prop('disabled',true);
        request_select.prop('disabled',true);
        budget_select.prop('disabled',true);
        table_item.find('.empty_row').remove();
    } else {
        salespoint_select.prop('disabled',false);
        authorization_select.prop('disabled',false);
        item_select.prop('disabled',false);
        request_select.prop('disabled',false);
        budget_select.prop('disabled',false);
        table_item.find('tbody').append('<tr class="empty_row text-center"><td colspan="8">Item belum dipilih</td></tr>');
    }
}

// add vendor
function addVendor(el){
    let select_vendor = $('.select_vendor');
    let table_vendor = $('.table_vendor');
    let id = select_vendor.find('option:selected').data('id');
    let name = select_vendor.find('option:selected').data('name');
    let code = select_vendor.find('option:selected').data('code');
    let salesperson = select_vendor.find('option:selected').data('salesperson');
    if(select_vendor.val()==""){
        alert('Harap pilih vendor terlebih dulu');
        return;
    }
    table_vendor.find('tbody').append('<tr class="vendor_item_list" data-id="'+id+'"><td>'+code+'</td><td>'+name+'</td><td>'+salesperson+'</td><td>-</td><td>Terdaftar</td><td><i class="fa fa-trash text-danger" onclick="removeVendor(this)" aria-hidden="true"></i></td></tr>'
    );
    select_vendor.val('');
    select_vendor.trigger('change');
    tableVendorRefreshed(select_vendor);
}

function addOTVendor(el){
    let vendor_name = $('.ot_vendor_name');
    let vendor_sales = $('.ot_vendor_sales');
    let vendor_phone = $('.ot_vendor_phone');
    let table_vendor = $('.table_vendor');
    if(vendor_name.val()==""){
        alert('Nama Vendor tidak boleh kosong');
        return;
    }
    if(vendor_sales.val()==""){
        alert('Sales Vendor tidak boleh kosong');
        return;
    }
    if(vendor_phone.val()==""){
        alert('Telfon Vendor tidak boleh kosong');
        return;
    }
    table_vendor.find('tbody').append('<tr class="vendor_item_list" data-id="" data-name="'+vendor_name.val()+'" data-sales="'+vendor_sales.val()+'" data-phone="'+vendor_phone.val()+'"><td>-</td><td>'+vendor_name.val()+'</td><td>'+vendor_sales.val()+'</td><td>'+vendor_phone.val()+'</td><td>One Time</td><td><i class="fa fa-trash text-danger" onclick="removeVendor(this)" aria-hidden="true"></i></td></tr>'
    );
    vendor_name.val('');
    vendor_sales.val('');
    vendor_phone.val('');
    tableVendorRefreshed(vendor_name);
}

// remove vendor
function removeVendor(el) {
    let tr = $(el).closest('tr');
    tr.remove();
    tableVendorRefreshed();
}

// table on refresh
function tableVendorRefreshed(current_element) {
    let table_vendor = $('.table_vendor');

    let row_count = 0;
    table_vendor.find('tbody tr').not('.empty_row').each(function () {
        row_count++;
    });
    if (row_count > 0) {
        table_vendor.find('.empty_row').remove();
    } else {
        table_vendor.find('tbody').append('<tr class="empty_row text-center"><td colspan="6">Vendor belum dipilih</td></tr>');
    }
    if($('.vendor_item_list').length<2){
        $('.vendor_ba_field').show();
    }else{
        $('.vendor_ba_field').hide();
    }
}

function addRequest(type){
    let item_list = $('.item_list');
    let vendor_item_list = $('.vendor_item_list');

    let input_field = $('#input_field');
    input_field.empty();

    input_field.append('<input type="hidden" name="type" value="'+type+'">')
    input_field.append('<input type="hidden" name="requirement_date" value="'+$('.requirement_date').val()+'">');
    input_field.append('<input type="hidden" name="salespoint" value="'+$('.salespoint_select2').val()+'">');
    input_field.append('<input type="hidden" name="authorization" value="'+$('.authorization_select2').val()+'">');
    input_field.append('<input type="hidden" name="item_type" value="'+$('.item_type').val()+'">');
    input_field.append('<input type="hidden" name="request_type" value="'+$('.request_type').val()+'">');
    input_field.append('<input type="hidden" name="budget_type" value="'+$('.budget_type').val()+'">');
    input_field.append('<input type="hidden" name="reason" value="'+$('.reason').val()+'">');

    item_list.each(function(index,el){
        input_field.append('<input type="hidden" name="item['+index+'][id]" value="'+$(el).data('id')+'">');
        input_field.append('<input type="hidden" name="item['+index+'][name]" value="'+$(el).data('name')+'">');
        input_field.append('<input type="hidden" name="item['+index+'][price]" value="'+$(el).data('price')+'">');
        input_field.append('<input type="hidden" name="item['+index+'][count]" value="'+$(el).data('count')+'">');
        input_field.append('<input type="hidden" name="item['+index+'][brand]" value="'+$(el).data('brand')+'">');
        input_field.append('<input type="hidden" name="item['+index+'][type]" value="'+$(el).data('type')+'">');
        input_field.append('<input type="hidden" name="item['+index+'][expired_date]" value="'+$(el).data('expired')+'">');
        $(el).find('.attachment').each(function(att_index,att_el){
            let filename = $(att_el).prop('download');
            let file = $(att_el).prop('href');
            input_field.append('<input type="hidden" name="item['+index+'][attachments]['+att_index+'][filename]" value="'+filename+'">');
            // base 64 data
            input_field.append('<input type="hidden" name="item['+index+'][attachments]['+att_index+'][file]" value="'+file+'">');
        });
    });
    vendor_item_list.each(function(index, el) {
        input_field.append('<input type="hidden" name="vendor['+index+'][id]" value="'+$(el).data('id')+'">');
        input_field.append('<input type="hidden" name="vendor['+index+'][name]" value="'+$(el).data('name')+'">');
        input_field.append('<input type="hidden" name="vendor['+index+'][sales]" value="'+$(el).data('sales')+'">');
        input_field.append('<input type="hidden" name="vendor['+index+'][phone]" value="'+$(el).data('phone')+'">');
    });

    $('#addform').submit();
}

