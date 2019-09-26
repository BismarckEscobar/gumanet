
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
    $('#dtInventarioArticulos').DataTable({
            //"paging":         false,
            "info":    false,            
            "lengthMenu": [[20,30,50,100,-1], [20,30,50,100,"Todo"]],
            "language": {
                "zeroRecords": "NO HAY RESULTADOS",
                "paginate": {
                    "first":      "Primera",
                    "last":       "Última ",
                    "next":       "Siguiente",
                    "previous":   "Anterior"                    
                },
                "lengthMenu": "MOSTRAR _MENU_",
                "emptyTable": "NO HAY DATOS DISPONIBLES",
                "search":     "BUSCAR"
            }
    });
    $("#dtInventarioArticulos_length").hide();// esconde el input de mostrar numero de registros por carga
    $("#dtInventarioArticulos_filter").hide();//esconde input de usqueda o filtrado
    
    $('#InputDtShowSearchFilterArt').on( 'keyup', function () {// muestra un input personalizado para hacer busqueda o filtrar datos por cadena de texto ingresada
        var table = $('#dtInventarioArticulos').DataTable();
        table.search(this.value).draw();
    });
    $( "#InputDtShowColumnsArtic").change(function() {
        var table = $('#dtInventarioArticulos').DataTable();
        table.page.len(this.value).draw();
    });
});