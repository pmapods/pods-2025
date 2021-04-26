$(document).ready(function () {
    $('.salespoint_select2').on('change', function () {
        let closestmodal = $(this).closest('.modal');
        let salespoint_select = closestmodal.find('.salespoint_select2');
        let area_status = closestmodal.find('.area_status');
        let authorization_select = closestmodal.find('.authorization_select2');
        let loading = closestmodal.find('.loading_salespoint_select2');

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
    })

    $('.authorization_select2').on('change', function () {
        let closestmodal = $(this).closest('.modal');
        let field = closestmodal.find('.authorization_list_field');
        let item_type = closestmodal.find('.item_type');
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
        let closestmodal = $(this).closest('.modal');
        let request_select = closestmodal.find('.request_type');
        let budget_item = closestmodal.find('.select_budget_item');
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
        let closestmodal = $(this).closest('.modal');
        let budget_type = closestmodal.find('.budget_type');
        if($(this).val()==""){
            budget_type.val('');
            budget_type.prop('disabled',true);
        }else{
            budget_type.prop('disabled',false);
        }
        budget_type.trigger('change');
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
    })

    $('.select_budget_item').on('change', function () {
        let closestmodal = $(this).closest('.modal');
        let salespoint_select = closestmodal.find('.salespoint_select2');
        let isjawasumatra = salespoint_select.find('option:selected').data('isjawasumatra');
        let item_min_price = closestmodal.find('.item_min_price');
        let item_max_price = closestmodal.find('.item_max_price');
        let brand_field = closestmodal.find('.brand_field');
        let price = closestmodal.find('.price_budget_item');
        let price_field = autoNumeric_field[$('.rupiah').index(price)];
        price_field.set(0);
        if ($(this).val() == "") {
            brand_field.text('-');
            return;
        }

        let minjs = $(this).find('option:selected').data('minjs');
        let maxjs = $(this).find('option:selected').data('maxjs');
        let minoutjs = $(this).find('option:selected').data('minoutjs');
        let maxoutjs = $(this).find('option:selected').data('maxoutjs');
        let brand = $(this).find('option:selected').data('brand');
        brand_field.text(brand);

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
    })
});
// add budget
function addBudgetItem(el) {
    let closestmodal = $(el).closest('.modal');
    let select_item = closestmodal.find('.select_budget_item');
    let price_item = closestmodal.find('.price_budget_item');
    let input_budget_brand = closestmodal.find('.input_budget_brand');
    let price_field = autoNumeric_field[$('.rupiah').index(price_item)];
    let item_min_price = closestmodal.find('.item_min_price');
    let item_max_price = closestmodal.find('.item_max_price');
    let count_item = closestmodal.find('.count_budget_item');
    let table_item = closestmodal.find('.table_item');

    let id = select_item.find('option:selected').val();
    let name = select_item.find('option:selected').text().trim();
    let brand = input_budget_brand.val().trim();
    let price = price_field.get();
    let price_text = price_item.val();
    let min_text = item_min_price.text().trim();
    let max_text = item_max_price.text().trim();
    let count = count_item.val();

    if (id == "") {
        alert("Item harus dipilih");
        return;
    } else if (brand == "") {
        alert("Pilihan Brand harus diisi");
        return;
    } else if (price < 1000) {
        alert("Harga harus lebih besar dari Rp 1.000");
        return;
    } else if (count < 1) {
        alert("Jumlah Item minimal 1");
        return;
    } else {
        table_item.find('tbody').append('<tr class="item_list" data-id="' + id + '" data-price="' + price + '" data-count="' + count + '" data-brand="' + brand + '"><td>' + name + '</td><td>' + brand + '</td><td>' + min_text + '</td><td>' + max_text + '</td><td>' + price_text + '</td><td>' + count + '</td><td>' + setRupiah(count * price) + '</td><td><i class="fa fa-trash text-danger remove_list" onclick="removeList(this)" aria-hidden="true"></i></td></tr>');
  
        select_item.val("");
        select_item.trigger('change');
        price_field.set(0);
        count_item.val("");
        tableRefreshed(el);
    }
}

// add non budget
function addNonBudgetItem(el){
    let closestmodal = $(el).closest('.modal');
    let input_name = closestmodal.find('.nonbudget_item_name');
    let item_brand = closestmodal.find('.nonbudget_item_brand');
    let price_item = closestmodal.find('.nonbudget_item_price');
    let price_field = autoNumeric_field[$('.rupiah').index(price_item)];
    let count_item = closestmodal.find('.nonbudget_item_count');
    let table_item = closestmodal.find('.table_item');

    let name = input_name.val().trim();
    let brand = item_brand.val().trim();
    let price = price_field.get();
    let price_text = price_item.val();
    let count = count_item.val();

    if (name == "") {
        alert("Nama item harus diisi");
        return;
    } else if (price < 1000) {
        alert("Harga harus lebih besar dari Rp 1.000");
        return;
    } else if (count < 1) {
        alert("Jumlah Item minimal 1");
        return;
    } else {
        table_item.find('tbody').append('<tr class="item_list" data-id="-1" data-name="' + name + '" data-price="' + price + '" data-count="' + count + '" data-brand="' + brand + '"><td>' + name + '</td><td>' + brand + '</td><td>-</td><td>-</td><td>' + price_text + '</td><td>' + count + '</td><td>' + setRupiah(count * price) + '</td><td><i class="fa fa-trash text-danger remove_list" onclick="removeList(this)" aria-hidden="true"></i></td></tr>');
  
        input_name.val('');
        price_field.set(0);
        count_item.val('');
        tableRefreshed(el);
    }
}
// remove button
function removeList(el) {
    let closestmodal = $(el).closest('.modal');
    let tr = $(el).closest('tr');
    tr.remove();
    tableRefreshed(closestmodal);
}

// table on refresh
function tableRefreshed(current_element) {
    let closestmodal = $(current_element).closest('.modal');
    let table_item = closestmodal.find('.table_item');
    let salespoint_select = closestmodal.find('.salespoint_select2');
    let authorization_select = closestmodal.find('.authorization_select2');
    let item_select = closestmodal.find('.item_type');
    let request_select = closestmodal.find('.request_type');
    let budget_select = closestmodal.find('.budget_type');
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
    let closestmodal = $(el).closest('.modal');
    let select_vendor = closestmodal.find('.select_vendor');
    let table_vendor = closestmodal.find('.table_vendor');
    let data = select_vendor.find('option:selected').data('vendor');
    if(select_vendor.val()==""){
        alert('Harap pilih vendor terlebih dulu');
        return;
    }
    table_vendor.find('tbody').append('<tr class="vendor_item_list" data-id="'+data.id+'"><td>'+data.code+'</td><td>'+data.name+'</td><td>'+data.salesperson+'</td><td>'+data.phone+'</td><td>Terdaftar</td><td><i class="fa fa-trash text-danger" onclick="removeVendor(this)" aria-hidden="true"></i></td></tr>'
    );
    select_vendor.val('');
    select_vendor.trigger('change');
    tableVendorRefreshed(select_vendor);
}

function addOTVendor(el){
    let closestmodal = $(el).closest('.modal');
    let vendor_name = closestmodal.find('.ot_vendor_name');
    let vendor_sales = closestmodal.find('.ot_vendor_sales');
    let vendor_phone = closestmodal.find('.ot_vendor_phone');
    let table_vendor = closestmodal.find('.table_vendor');
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
    let closestmodal = $(el).closest('.modal');
    let tr = $(el).closest('tr');
    tr.remove();
    tableVendorRefreshed(closestmodal);
}

// table on refresh
function tableVendorRefreshed(current_element) {
    let closestmodal = $(current_element).closest('.modal');
    let table_vendor = closestmodal.find('.table_vendor');

    let row_count = 0;
    table_vendor.find('tbody tr').not('.empty_row').each(function () {
        row_count++;
    });
    if (row_count > 0) {
        table_vendor.find('.empty_row').remove();
    } else {
        table_vendor.find('tbody').append('<tr class="empty_row text-center"><td colspan="6">Vendor belum dipilih</td></tr>');
    }
}

function addRequest(el,type){
    let modal = $(el).closest('.modal');
    let requirement_date = modal.find('.requirement_date');
    let salespoint_select2 = modal.find('.salespoint_select2');
    let authorization_select2 = modal.find('.authorization_select2');
    let item_type = modal.find('.item_type');
    let request_type = modal.find('.request_type');
    let budget_type = modal.find('.budget_type');
    let reason = modal.find('.reason');
    let item_list = modal.find('.item_list');
    let vendor_item_list = modal.find('.vendor_item_list');

    // VALIDATION
    if(requirement_date.val()==""){
        alert('Tanggal Pengadaan harus diisi');
        return;
    }
    if(salespoint_select2.val()==""){
        alert('Sales point harus dipilih');
        return;
    }
    if(authorization_select2.val()==""){
        alert('Otorisasi harus dipilih');
        return;
    }
    if(item_type.val()==""){
        alert('Jenis barang harus dipilih');
        return;
    }
    if(request_type.val()==""){
        alert('Jenis Pengadaan harus dipilih');
        return;
    }
    if(budget_type.val()==""){
        alert('Jenis Budget harus dipilih');
        return;
    }
    if(item_list.length < 1){
        alert('Daftar barang minimal 1 barang');
        return;
    }
    if(reason.val()==""){
        alert('Alasan Pengadaan harus diisi');
        return;
    }
    if(vendor_item_list.length < 2){
        alert('Minimal 2 pilihan vendor');
        return;
    }
    let input_field = modal.find('.input_field');
    input_field.append('<input type="hidden" name="type" value="'+type+'">')

    input_field.append('<input type="hidden" name="requirement_date" value="'+requirement_date.val()+'">');
    input_field.append('<input type="hidden" name="salespoint_select2" value="'+salespoint_select2.val()+'">');
    input_field.append('<input type="hidden" name="authorization_select2" value="'+authorization_select2.val()+'">');
    input_field.append('<input type="hidden" name="item_type" value="'+item_type.val()+'">');
    input_field.append('<input type="hidden" name="request_type" value="'+request_type.val()+'">');
    input_field.append('<input type="hidden" name="budget_type" value="'+budget_type.val()+'">');
    input_field.append('<input type="hidden" name="reason" value="'+reason.val()+'">');

    item_list.each(function(index,el){
        input_field.append('<input type="hidden" name="item['+index+'][id]" value="'+$(el).data('id')+'">');
        input_field.append('<input type="hidden" name="item['+index+'][name]" value="'+$(el).data('name')+'">');
        input_field.append('<input type="hidden" name="item['+index+'][price]" value="'+$(el).data('price')+'">');
        input_field.append('<input type="hidden" name="item['+index+'][count]" value="'+$(el).data('count')+'">');
        input_field.append('<input type="hidden" name="item['+index+'][brand]" value="'+$(el).data('brand')+'">');
    });
    vendor_item_list.each(function(index, el) {
        input_field.append('<input type="hidden" name="vendor['+index+'][id]" value="'+$(el).data('id')+'">');
        input_field.append('<input type="hidden" name="vendor['+index+'][name]" value="'+$(el).data('name')+'">');
        input_field.append('<input type="hidden" name="vendor['+index+'][sales]" value="'+$(el).data('sales')+'">');
        input_field.append('<input type="hidden" name="vendor['+index+'][phone]" value="'+$(el).data('phone')+'">');
    });

    $('#addform').submit();

    // data-item
    // id
    // price
    // count
    // brand

    // data-vendor
    // id
    // name
    // sales
    // phone
}

