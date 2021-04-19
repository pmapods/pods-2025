$(document).ready(function () {
    var table = $('#ticketDT').DataTable(datatable_settings);
    $('#ticketDT tbody').on('click', 'tr', function () {

    });

    $('.salespoint_select2').on('change', function () {
        let closestmodal = $(this).closest('.modal');
        let salespoint_select = closestmodal.find('.salespoint_select2');
        let budget_type = closestmodal.find('.budget_type');
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
        budget_type.prop('disabled', true);
        budget_type.val("");
        budget_type.trigger('change');


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
                budget_type.prop('disabled', false);
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
        // initial state
        field.empty();
        let selected_data = $(this).find('option:selected').data('item');
        if (selected_data) {
            selected_data.detail.forEach(item => {
                field.append('<div class="mb-3"><span class="font-weight-bold">' + item.name + ' -- ' + item.position + '</span><br><span>' + item.as + '</span></div>');
            });
        } else {
            field.append('<div>Belum memilih otorisasi</div>');
        }
    });

    $('.budget_type').on('change', function () {
        let type = $(this).val();

        $('.budget_item_adder').addClass('d-none');
        $('.nonbudget_item_adder').addClass('d-none');
        $('.budget_item_adder').removeClass('d-flex');
        $('.nonbudget_item_adder').removeClass('d-flex');
        if (type === '0') {
            // budget
            $('.budget_item_adder').addClass('d-flex');
            $('.budget_item_adder').removeClass('d-none');

        } else if (type === '1') {
            // non budget
            $('.nonbudget_item_adder').addClass('d-flex');
            $('.nonbudget_item_adder').removeClass('d-none');
        }
    })

    $('.select_budget_item').on('change', function () {
        let closestmodal = $(this).closest('.modal');
        let salespoint_select = closestmodal.find('.salespoint_select2');
        let isjawasumatra = salespoint_select.find('option:selected').data('isjawasumatra');
        let item_min_price = closestmodal.find('.item_min_price');
        let item_max_price = closestmodal.find('.item_max_price');
        let price = closestmodal.find('.price_budget_item');
        let price_field = autoNumeric_field[$('.rupiah').index(price)];
        price_field.set(0);
        if ($(this).val() == "") {
            return;
        }

        let minjs = $(this).find('option:selected').data('minjs');
        let maxjs = $(this).find('option:selected').data('maxjs');
        let minoutjs = $(this).find('option:selected').data('minoutjs');
        let maxoutjs = $(this).find('option:selected').data('maxoutjs');

        price_field.options.minimumValue(0);
        if (isjawasumatra == 1) {
            item_min_price.text((Number.isInteger(minjs)) ? setRupiah(minjs) : '-');
            item_max_price.text((Number.isInteger(maxjs)) ? setRupiah(maxjs) : '-');
            price_field.options.maximumValue(maxjs);
            price.prop('disabled', false)
        } else if (isjawasumatra == 0) {
            item_min_price.text((Number.isInteger(minoutjs)) ? setRupiah(minoutjs) : '-');
            item_max_price.text((Number.isInteger(maxoutjs)) ? setRupiah(maxoutjs) : '-');
            price_field.options.maximumValue(maxoutjs);
            price.prop('disabled', false)
        } else {
            item_min_price.text('-');
            item_max_price.text('-');
            price_field.options.maximumValue(0);
            price.prop('disabled', true)
        }
    })
});
// add budget
function addBudgetItem(el) {
    let closestmodal = $(el).closest('.modal');
    let select_item = closestmodal.find('.select_budget_item');
    let price_item = closestmodal.find('.price_budget_item');
    let price_field = autoNumeric_field[$('.rupiah').index(price_item)];
    let item_min_price = closestmodal.find('.item_min_price');
    let item_max_price = closestmodal.find('.item_max_price');
    let count_item = closestmodal.find('.count_budget_item');
    let table_item = closestmodal.find('.table_item');

    let name = select_item.find('option:selected').text().trim();
    let id = select_item.find('option:selected').val();
    let price = price_field.get();
    let price_text = price_item.val();
    let min_text = item_min_price.text().trim();
    let max_text = item_max_price.text().trim();
    let count = count_item.val();

    // console.log(name, id, price, min_text, max_text, min_text, count);
    if (id == "") {
        alert("Item harus dipilih");
        return;
    } else if (price < 1000) {
        alert("Harga harus lebih besar dari Rp 1.000");
        return;
    } else if (count < 1) {
        alert("Jumlah Item minimal 1");
        return;
    } else {
        table_item.find('tbody').append('<tr data-id="' + id + '" data-price="' + price + '" data-count="' + count + '"><td>' + name + '</td><td>' + min_text + '</td><td>' + max_text + '</td><td>' + price_text + '</td><td>' + count + '</td><td>' + setRupiah(count * price) + '</td><td><i class="fa fa-trash text-danger remove_list" onclick="removeList(this)" aria-hidden="true"></i></td></tr>');
  
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
    let price_item = closestmodal.find('.nonbudget_item_price');
    let price_field = autoNumeric_field[$('.rupiah').index(price_item)];
    let count_item = closestmodal.find('.nonbudget_item_count');
    let table_item = closestmodal.find('.table_item');

    let name = input_name.val();
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
        table_item.find('tbody').append('<tr data-id="-1" data-price="' + price + '" data-count="' + count + '"><td>' + name + '</td><td>-</td><td>-</td><td>' + price_text + '</td><td>' + count + '</td><td>' + setRupiah(count * price) + '</td><td><i class="fa fa-trash text-danger remove_list" onclick="removeList(this)" aria-hidden="true"></i></td></tr>');
  
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

// refresh table
// table on refresh
function tableRefreshed(current_element) {
    let closestmodal = $(current_element).closest('.modal');
    let table_item = closestmodal.find('.table_item');
    let salespoint_select = closestmodal.find('.salespoint_select2');
    let budget_select = closestmodal.find('.budget_type');
    // check table level if table has data / tr or not
    let row_count = 0;
    table_item.find('tbody tr').not('.empty_row').each(function () {
        row_count++;
    });
    if (row_count > 0) {
        salespoint_select.prop('disabled', true);
        budget_select.prop('disabled', true);
        table_item.find('.empty_row').remove();
    } else {
        salespoint_select.prop('disabled', false);
        budget_select.prop('disabled', false);
        table_item.find('tbody').append('<tr class="empty_row text-center"><td colspan="7">Item belum dipilih</td></tr>');
    }
}
