<script>
$(document).ready(function() {
	dataProyecciones(false);
});

function detailsProyeccion() {
	$("#page-details").toggleClass('active');
}

$(".active-page-details").click( function() {
	$("#page-details").toggleClass('active');    
});

$("#btnVerPro").click(function(e) {
	dataProyecciones(false);
});
function dataProyecciones(json) {
	$('#dtProyecciones').DataTable ( {
        'ajax':{
            'url':'dataProyeccion',
            type: 'POST',
            'async' : true,
            'dataSrc': '',
        },        
        "destroy" : true,
		"info":    false,
		"lengthMenu": [[5,10,-1], [5,10,"Todo"]],
		"language": {
			"zeroRecords": "Cargando...",
			"paginate": {
				"first":      "Primera",
				"last":       "Última ",
				"next":       "Siguiente",
				"previous":   "Anterior"
			},
			"lengthMenu": "MOSTRAR _MENU_",
			"emptyTable": "Aún no ha realizado ninguna busqueda",
			"search":     "BUSCAR"
		},
		

		'columns': [
			{ "data": "ARTICULO" },
			{ "data": "DESCRIPCION" },
			{ "data": "CLASE_ABC" },
			{ "data": "ORDEN_MINIMA" },
			{ "data": "FACTOR_EMPAQUE" },
			{ "data": "OPC" }
		],

		"columnDefs": [
			/*{"className": "text-right", "targets": [ 5 ]},
			{"className": "text-center", "targets": [ 0, 2, 3, 4 ]},*/
			{ "width": "10%", "targets": [ 5 ] },
			
		],

		"fnInitComplete": function () {
			$("#dtProyecciones_length").hide();
			$("#dtProyecciones_filter").hide();
		}
	});
}





</script>