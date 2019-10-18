<script>
$(document).ready(function() {
    //AGREGO LA RUTA AL NAVEGADOR
    $("#item-nav-01").after(`<li class="breadcrumb-item active">Usuario</li>`);

    $('#dtUsuarios').DataTable({
    	
    	"info":    false,
    	"lengthMenu": [[10,30,50,100,-1], [20,30,50,100,"Todo"]],
    	"language": {
    	    "zeroRecords": "Cargando...",
    	    "paginate": {
    	        "first":      "Primera",
    	        "last":       "Última ",
    	        "next":       "Siguiente",
    	        "previous":   "Anterior"
    	    },
    	    "lengthMenu": "MOSTRAR _MENU_",
    	    "emptyTable": "NO HAY DATOS DISPONIBLES",
    	    "search":     "BUSCAR"
    	},
    	
        "columnDefs": [
            { "width": "17%", "targets": [ 0 ] },
            { "width": "10%", "targets": [ 1 ] },
            { "width": "10%", "targets": [ 2 ] },
            { "width": "25%", "targets": [ 3 ] },
            { "width": "15%", "targets": [ 4 ] },
            { "width": "10%", "targets": [ 5 ] },
            { "width": "13%", "targets": [ 6 ] }
        ],
    });

    $("#dtUsuarios_length").hide();
    $("#dtUsuarios_filter").hide();
    //inicializaControlFecha();
});

$('#InputDtShowSearchFilterUser').on( 'keyup', function () {
	var table = $('#dtUsuarios').DataTable();
	table.search(this.value).draw();
});

$( "#InputDtShowColumnsUser").change(function() {
	var table = $('#dtUsuarios').DataTable();
	table.page.len(this.value).draw();
});


</script>