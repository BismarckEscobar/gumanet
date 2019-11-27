<script>
	$(document).ready(function() {
	    //AGREGO LA RUTA AL NAVEGADOR
	    $("#item-nav-01").after(`<li class="breadcrumb-item active">Metas</li>`);
	    $('#disabledLoaderBtn').hide();
	    $("#disabledLoaderBtnProcess").hide();

	    $("#verMetasAgregadasXMes").hide();

	    $("#alertMetas").hide();


	    if($("#radioMeta1").is(':checked')){

	    	$("#btnShowModalExl").text("Agregar");
	    }else{
	    	$("#btnShowModalExl").text("Visualizar");
	    }
    
	});

	$('.custom-file-input').on('change',function(){
    	
    	if ($(this).val()=='') {
			$('#fileLabelMeta').text('Seleccione un archivo Ecxel');
    	}else{
    		$('#fileLabelMeta').text($(this).val());
    	}
	});




	$("#btnShowModalExl").on('click', function(){

		if (validarCamposMeta()) {

			$("#alertMetas").hide();

			if($("#radioMeta1").is(':checked')){

				if(!existeFechaMeta()){

					$('#btnShowModalExl').hide();
					$('#disabledLoaderBtn').show();
					truncate_tmp_exl_tbl();//Borrar registro de tabla temporal en phpMyAdmin
					exportarDatosExlAModalMetas();//Funcion para exportar datos de excel a la tabla temporal

				}else{
					$("#alertMetas").show();
					$("#alertMetas").css({"color":"red","font-weight":"bold"});
					$("#alertMetas").text("Ya existe meta con la fecha seleccioanda");
				}

		    }else{
		    	
		    	$('#tblVerMetasAgregadas').DataTable().destroy();
		    	getHistorialMeta();

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

	$('#procesarModalMetaExl').on('click', function(){
		
		$("#procesarModalMetaExl").hide();
		$("#cancelModalMetaBtn").hide();
		$("#disabledLoaderBtnProcess").show();
		addDatatableDatosMeta();

	});


	$("#radioMeta1").on('click', function(){
		$("#btnShowModalExl").text("Agregar");
	    $("#contInputExlFileMetas").show();
	    $("#verMetasAgregadasXMes").hide();
	    $("#alertMetas").hide();
	});


	$("#radioMeta2").on('click', function(){
		$("#btnShowModalExl").text("Visualizar");
	    $("#contInputExlFileMetas").hide();
	    $("#verMetasAgregadasXMes").hide();
	    $("#alertMetas").hide();
	});


	function getHistorialMeta(){
		inicialDataTablesMetas('#tblVerMetasAgregadas','get_historial_meta');		
	}

	function get_tmp_exl_data(){
		inicialDataTablesMetas('#tblExcelImportMeta','get_tmp_exl_data');
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
			url:"export_meta_from_exl",
			method:"POST",
			data:formData,
			contentType:false,
            processData: false,
            success: function(){

            	$('#mesModalExl').text($("#selectMesMeta option:selected").text());
	            $('#annoModalExl').text(anno);
				$('#tblExcelImportMeta').DataTable().destroy();
            	get_tmp_exl_data();
            	$('#disabledLoaderBtn').hide();
		        $('#modalShowModalExl').modal({backdrop: 'static', keyboard: false});
		    	$('#modalShowModalExl').modal('show');
		    	$('#btnShowModalExl').show();
            	
            	
            }
		});


	}
	function addDatatableDatosMeta(){
    	
		$.ajax({
		url:"add_data_meta",
		success: function(data){
			
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

	


	function inicialDataTablesMetas(dtName,dataUrl){
		$(dtName).DataTable().clear().draw();
		$(dtName).dataTable().fnDestroy();
		mes = $("#selectMesMeta option:selected").val();
		anno = $("#selectAnnoMeta option:selected").val();

		$(dtName).DataTable({
			"processing": true,
	        "serverSide": true,
	    	ajax:{
	    		url:dataUrl,
	    		type: 'POST',
               data: {
               	mes : mes,
               	anno: anno,
               	success: function(res){
               		if (res == 0) {

               		}

               	}
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
    	"columnDefs": [
            { "width": "3%", "targets": [ 0 ] },
            { "width": "3%", "targets": [ 1 ] },
            { "width": "24%", "targets": [ 2 ] },
            { "width": "10%", "targets": [ 3 ] },
            { "width": "40%", "targets": [ 4 ] },
            { "width": "10%", "targets": [ 5 ] },
            { "width": "10%", "targets": [ 6 ] }
        ],
	    	"columns":[
		    	{data:'ruta', name:'ruta'},
		        {data:'codigo', name:'codigo'},
		        {data:'cliente', name:'cliente'},
		        {data:'articulo', name:'articulo'},
		        {data:'descripcion', name:'descripcion'},
		        {data:'valor', name: 'valor'},
			    {data:'unidad', name:'unidad'}
		    ]
		});

		$(dtName+'_length').hide();
    	$(dtName+'_filter').hide();
		$('#mesHistorialMeta').text($('#selectMesMeta option:selected').text());
        $('#annoHistorialMeta').text($('#selectAnnoMeta option:selected').text());

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

	function existeFechaMeta(){

		var mes = $("#selectMesMeta option:selected").val();
		var anno = $("#selectAnnoMeta option:selected").val();
		var resultado;

		$.ajax({
			url:'existe_Fecha_Meta',
    		type: 'POST',
    		async:false,
            data: {
           		mes : mes,
           		anno: anno
            },
            success: function(res){
            	
            	if (res == true){
            		resultado = true;
            	}else{
            		resultado = false;
            	}
            }
		});

		return resultado;
	}
	

</script>