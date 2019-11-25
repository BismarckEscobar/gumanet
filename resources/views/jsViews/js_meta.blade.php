<script>
	$(document).ready(function() {
    //AGREGO LA RUTA AL NAVEGADOR
    $("#item-nav-01").after(`<li class="breadcrumb-item active">Metas</li>`);
    $('#disabledLoaderBtn').hide();
    $("#disabledLoaderBtnProcess").hide();


	


    $("#tblExcelImportMeta").DataTable({
    	
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
            { "width": "3%", "targets": [ 0 ] },
            { "width": "3%", "targets": [ 1 ] },
            { "width": "24%", "targets": [ 2 ] },
            { "width": "10%", "targets": [ 3 ] },
            { "width": "40%", "targets": [ 4 ] },
            { "width": "10%", "targets": [ 5 ] },
            { "width": "10%", "targets": [ 6 ] }
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

				$('#btnShowModalExl').hide();
				$('#disabledLoaderBtn').show();
				truncate_tmp_exl_tbl();
				exportarDatosExlAModalMetas();
		    }else{
		    	getHistorialMeta();

		    	//$('#tblVerMetasAgregadas').DataTable();
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
	    //$('#tblVerMetasAgregadas').DataTable();
	    $("#alertMetas").hide();
	});


	$("#radioMeta2").on('click', function(){
		$("#btnShowModalExl").text("Visualizar");
		//$("#addExlFileMetas").prop('disabled', true);
	    $("#contInputExlFileMetas").hide();
	    $("#verMetasAgregadasXMes").hide();
	    //$('#tblVerMetasAgregadas').DataTable();
	    $("#alertMetas").hide();
	});


	function getHistorialMeta(){
		$("#tblVerMetasAgregadas").DataTable().clear().draw();
		$("#tblVerMetasAgregadas").dataTable().fnDestroy();
		$mes = $("#selectMesMeta option:selected").val();
		$anno = $("#selectAnnoMeta option:selected").val();

		$("#tblVerMetasAgregadas").DataTable({
			"processing": true,
	        "serverSide": true,
	    	ajax:{
	    		url: "get_historial_meta",
	    		type: 'POST',
               data: {
               	mes : $mes,
               	anno: $anno
               }
	    	},
	    	"pageLength" : 10,
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
	    	"columns":[
		    	{"data":'ruta'},
		        {"data":'codigo'},
		        {"data":'cliente'},                      
		        {"data":'articulo'},
		        {"data":'descripcion'},    
		        {"data":'valor'},
			    {"data":'unidad'}
		    ]
		});

		$("#tblVerMetasAgregadas_length").hide();
    	$("#tblVerMetasAgregadas_filter").hide();
		$('#mesHistorialMeta').text($("#selectMesMeta option:selected").text());
        $('#annoHistorialMeta').text($("#selectAnnoMeta option:selected").text());
			
	}

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


	function truncate_tmp_exl_tbl(){
		$.ajax({
			url:"truncate_tmp_exl_tbl"
		});
	}



	function exportarDatosExlAModalMetas(){
		var formData = new FormData($("#export_excel")[0]);
		var mes = $("#selectMesMeta option:selected").val();
		var anno = $("#selectAnnoMeta option:selected").val();

		formData.append("mes", mes);
		formData.append("anno", anno);
		$.ajax({
			url:"meta_exp",
			method:"POST",
			data:formData,
			contentType:false,
            processData: false,
            success: function(){
            	$('#mesModalExl').text($("#selectMesMeta option:selected").text());
	            $('#annoModalExl').text(anno);
				
            	get_tmp_exl_data();
            	
            	
            }
		});


	}


	function get_tmp_exl_data(){
		
		$.ajax({
			url:"get_tmp_exl_data",
			success: function(data){

				var e =JSON.parse(data); 
				var ObjTable = $("#tblExcelImportMeta").DataTable();
				$("#tblExcelImportMeta").DataTable().clear().draw();
				
				if(e[0]== null){

	            }else{


	                for (f=0;f<e.length;f++){

	                    ObjTable.row.add( [
	                        e[f].ruta,
	                        e[f].codigo,
	                        e[f].cliente,                      
	                        e[f].articulo,
	                        e[f].descripcion,    
	                        e[f].valor,
	                        e[f].unidad
	                    ] ).draw( false )
	                }
	            }

	            
	            $('#disabledLoaderBtn').hide();
	            $('#modalShowModalExl').modal({backdrop: 'static', keyboard: false});
            	$('#modalShowModalExl').modal('show');
            	$('#btnShowModalExl').show();
			}

		});


	}

	$('#procesarModalMetaExl').on('click', function(){
		
		$("#procesarModalMetaExl").hide();
		$("#cancelModalMetaBtn").hide();
		$("#disabledLoaderBtnProcess").show();
		addDatatableDatosMeta();

	});


    function addDatatableDatosMeta(){
    	
    	/*var myTable = $('#tblExcelImportMeta').DataTable();

    	var data = myTable.rows().data().toArray();
    	console.log(data);
    	

    	$.ajax({
			url:"add_data_meta",
			type: 'POST',
       		dataType: 'json',
			data: {data:data},
			success: function(data){
				//calcMetaAddMetaUnidad();
			}

		});*/
			$.ajax({
			url:"add_data_meta",
			success: function(data){
				//calcMetaAddMetaUnidad();
				$('#modalShowModalExl').modal('hide');
				$("#procesarModalMetaExl").show();
				$("#cancelModalMetaBtn").show();
				$("#disabledLoaderBtnProcess").hide();
				$('#toast1').toast('show');
			}
           });
    }

	function calcMetaAddMetaUnidad(){
		var mes = $("#selectMesMeta option:selected").val();
		var anno = $("#selectAnnoMeta option:selected").val();
		
		/*$.ajax({
			url:"calc_and_add_unidad_meta",
			success: function(data){
				
			}

		});*/


	}



</script>