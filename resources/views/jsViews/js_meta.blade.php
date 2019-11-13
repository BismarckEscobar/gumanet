<script type="text/javascript">
	$(document).ready(function() {
    //AGREGO LA RUTA AL NAVEGADOR
    $("#item-nav-01").after(`<li class="breadcrumb-item active">Metas</li>`);

    $('#tblExcelImportMeta,#tblVerMetasAgregadas').DataTable({
    	
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

    $("#tblExcelImportMeta_length").hide();
    $("#tblExcelImportMeta_filter").hide();

    $("#tblVerMetasAgregadas_length").hide();
    $("#tblVerMetasAgregadas_filter").hide();

    $("#verMetasAgregadasXMes").hide();

    $("#alertMetas").hide();


    if($("#radioMeta1").is(':checked')){

	    	$("#btnShowModalExl").text("Agregar");
	    }else{
	    	$("#btnShowModalExl").text("Visualizar");
	    }
    
    
});

	$("#btnShowModalExl").on('click', function(){
		if (validarCamposMeta()) {
				$("#alertMetas").hide();
			if($("#radioMeta1").is(':checked')){
				$('#modalShowModalExl').modal('show');
				exportarDatosExlAModalMetas(("#selectMesMeta").text(), ("#selectAnnoMeta").text());
		    }else{
		    	$('#tblVerMetasAgregadas').DataTable();
		    	$('#verMetasAgregadasXMes').show();
	    	}
		}else{

			$("#alertMetas").css({"color":"red","font-weight":"bold"});

			if($("#radioMeta1").is(':checked')){

				$("#alertMetas").text("*Seleccione el mes, el año y un archivo de excel valido*");

			}else{

				$("#alertMetas").text("*Seleccione el mes y el año*");

			}
			
			$("#alertMetas").show();
			

		}
		
	});


	$("#radioMeta1").on('click', function(){
		$("#btnShowModalExl").text("Agregar");
		//$("#addExlFileMetas").prop('disabled', false);
	    $("#contInputExlFileMetas").show();
	    $("#verMetasAgregadasXMes").hide();
	    $('#tblVerMetasAgregadas').DataTable();
	    $("#alertMetas").hide();
	});


	$("#radioMeta2").on('click', function(){
		$("#btnShowModalExl").text("Visualizar");
		//$("#addExlFileMetas").prop('disabled', true);
	    $("#contInputExlFileMetas").hide();
	    $("#verMetasAgregadasXMes").hide();
	    $('#tblVerMetasAgregadas').DataTable();
	    $("#alertMetas").hide();
	});

	function validarCamposMeta(){
		if($("#radioMeta1").is(':checked')){
			if($("#selectMesMeta").val() != "00" && $("#selectAnnoMeta").val() != "00" && $("#addExlFileMetas").val().length != 0){
				return true;
			}else{
				return false;
			}
	    }else{

	    	if($("#selectMesMeta").val() != "00" && $("#selectAnnoMeta").val() != "00"){
				return true;
			}else{
				return false;
			}
	    	
    	}
		
	}

	function exportarDatosExlAModalMetas(mes, anno){
		var exldata = $("#addExlFileMetas").val();
		$.ajax({
			"url":"meta_exp",
			"method":"POST",
			"data": new FormData(exldata),
			"contentType": false,
			"processdata": false,
			success: function(data){
				$("#").html(data);
			}

		});
	}


</script>