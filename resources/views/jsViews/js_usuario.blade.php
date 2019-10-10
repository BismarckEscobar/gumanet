<script>
$(document).ready(function() {
    //AGREGO LA RUTA AL NAVEGADOR
    $("#item-nav-01").after(`<li class="breadcrumb-item active">Usuario</li>`);

    $('#dtUsuarios').DataTable({
    	"ajax":{
    		"url": "usuarios",
    		'dataSrc': '',
    	},
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
    	'columns': [
    	    { "title": "NOMBRE", "data": "name" },
    	    { "title": "USUARIO", "data": "email" },
    	    { "title": "ROL", "data": "role" },
    	    { "title": "COMPAÑIA", "data": "company" },
    	    { "title": "DESCRIPCIÓN", "data": "description" },
    	    { "title": "FECHA INGRESO", "data": "created_at" },
            { "title": "ESTADO", "data": "estado" },
            { "title": "OPCIONES", "defaultContent": "<div><a href='#'><span data-feather='edit'></span>Edit</a></div><div><a href='#'><span data-feather='delete'></span>elim</a></div>" }
    	],
        "columnDefs": [
            { "width": "15%", "targets": [ 0 ] },
            { "width": "10%", "targets": [ 1 ] },
            { "width": "10%", "targets": [ 2 ] },
            { "width": "10%", "targets": [ 3 ] },
            { "width": "20%", "targets": [ 4 ] },
            { "width": "15%", "targets": [ 5 ] },
            { "width": "10%", "targets": [ 6 ] },
            { "width": "10%", "targets": [ 7 ] }
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