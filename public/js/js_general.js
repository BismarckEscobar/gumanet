var pgurl = window.location.href.substr(window.location.href.lastIndexOf("/")+1);
$("ul li a").each(function(){
    if($(this).attr("href") == pgurl || $(this).attr("href") == '' ){
        $(this).addClass("active");
    }
});

//METODO QUE PERMITE ENVIAR POR POST AJAX
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function mensaje(mensaje, tipo) {
    /*
    Tipos:
    success, error, warning, info, question
    +*/
    const toast = swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

    toast({
      type: tipo,
      title: mensaje
    })
}

$(".active-menu").click( function() {
    $("#sidebar").toggleClass('active');
});

feather.replace();

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