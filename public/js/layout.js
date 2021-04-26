let autoNumeric_field;
$(document).ready(function(){
    $('.sidebar .active').removeClass('active');

    var a = location.pathname.split("/");
    $('.sidebar a[href$="/'+a[1]+'"]').addClass('active');
    if($('.sidebar a[href$="/'+a[1]+'"]').parents('li').hasClass('has-treeview')==true){
        $('.sidebar a[href$="/'+a[1]+'"]').parents('ul').prev().addClass('active')
        $('.sidebar a[href$="/'+a[1]+'"]').parents('ul').css('display','block');
        $('.sidebar a[href$="/'+a[1]+'"]').parents('li').addClass('menu-open');
    }

    // rupiah formatter
    autoNumeric_field = new AutoNumeric.multiple('.rupiah', {
        currencySymbol: "Rp ",
        decimalCharacter: ",",
        digitGroupSeparator: ".",
        emptyInputBehavior: "zero",
        unformatOnSubmit: true,
    });

    // rupiahtext formatter
    new AutoNumeric.multiple('.rupiah_text', {
        currencySymbol: "Rp ",
        decimalCharacter: ",",
        digitGroupSeparator: ".",
    });

    // Selection search with select2
    $('.select2').select2({
        theme: 'bootstrap4',
    });
    $(window).resize(function () {
        $('.select2').css('width', "100%");
    });

    $("form[method='post']").on('submit', function(){
        $('button').prop('disabled',true);
        $(this).find('button[type = "submit"]').append('<i class="fad ml-2 fa-spinner-third fa-spin"></i>');
    });

});

function setRupiah(amount) {
    amount = amount.toFixed(2);
    var isNegative = false;
    if(Number(amount) < 0) {
        isNegative = true;
        amount *= -1;
    }
    var truncated = Math.trunc(amount);
    var reversed = truncated.toString().split("").reverse().join("");
    var ctr = 0;
    var addedDots = "";
    for(var i=0; i<reversed.length; i++){
        addedDots += reversed.charAt(i);
        ctr++;
        if(ctr == 3 && i != reversed.length - 1){
            addedDots += "."
            ctr = 0;
        }
    }
    var corrected = addedDots.split("").reverse().join("");


    var floatAmount =  Number((amount-truncated).toFixed(3));
    var finalString = "";
    if(isNegative == true) {
        finalString += "- ";
    }
    if(floatAmount == 0) {
        finalString += "Rp " + corrected + ",00";
    }
    else {
        var float_part = amount.toString().split(".");
        if(float_part[1].length == 1) {
            finalString +=  "Rp " + corrected + "," + float_part[1].charAt(0) + "0";

        }
        else {

            finalString +=  "Rp " + corrected + "," + float_part[1].charAt(0) + float_part[1].charAt(1);
        }
    }
    return finalString;
}

function autonumber(el) {
    var max = parseInt($(el).prop('max'));
    var min = parseInt($(el).prop('min'));
    if ($(el).val() > max) {
        $(el).val(max);
    } else if ($(el).val() < min) {
        $(el).val(min);
    } else if($(el).val() == ""){
        $(el).val(0);
    }
}

// Datatable Settings
var datatable_settings = {
    "language": language_setting,
    "aria": {
        "sortAscending": ": aktifkan untuk mengurutkan keatas",
        "sortDescending": ": aktifkan untuk mengurutkan kebawah"
    },
    "ordering": false
};
var language_setting = {
    "decimal": "",
    "emptyTable": "Tidak ada data",
    "info": "Menunjukan _START_ sampai _END_ dari _TOTAL_ data lainnya",
    "infoEmpty": "Tidak terdapat data",
    "infoFiltered": "(dipilih dari _MAX_ total data)",
    "infoPostFix": "",
    "thousands": ",",
    "lengthMenu": "Menunjukkan _MENU_ data",
    "loadingRecords": "Mengunduh data...",
    "processing": "Memproses data...",
    "search": "Cari:",
    "zeroRecords": "Tidak ditemukan data yang sesuai",
    "paginate": {
        "first": "Awal",
        "last": "Akhir",
        "next": "Selanjutnya",
        "previous": "Sebelumnya"
    }
};
