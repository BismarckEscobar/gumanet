
/**
 * Created by maryan.espinoza on 25/09/2019.
 */

var pgurl = window.location.href.substr(window.location.href.lastIndexOf("/")+1);
$("ul li a").each(function(){
    if($(this).attr("href") == pgurl || $(this).attr("href") == '' ){
        $(this).addClass("active");
    }
});


function inicializaControlFecha() {
    $('input[class="input-fecha"]').daterangepicker({
        "locale": {
            "format": "DD-MM-YYYY",
            "separator": " - ",
            "applyLabel": "Apply",
            "cancelLabel": "Cancel",
            "fromLabel": "From",
            "toLabel": "To",
            "customRangeLabel": "Custom",
            "daysOfWeek": [
                "D",
                "L",
                "M",
                "M",
                "J",
                "V",
                "S"
            ],
            "monthNames": [
                "Enero",
                "Febrero",
                "Marzo",
                "Abril",
                "Mayo",
                "Junio",
                "Julio",
                "Agosto",
                "Septiembre",
                "Octubre",
                "Noviembre",
                "Diciembre"
            ],
            "firstDay": 0
        },
        singleDatePicker: true,
        showDropdowns: true
    });
}

$(document).ready(function(){
    $('#tablaEjemplo').DataTable();
});