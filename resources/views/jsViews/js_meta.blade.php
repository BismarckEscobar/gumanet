<script>
	$(document).ready(function() {
	    //AGREGO LA RUTA AL NAVEGADOR
	    $("#item-nav-01").after(`<li class="breadcrumb-item active">Metas</li>`);
	    $('#disabledLoaderBtn').hide();
	    $("#disabledLoaderBtnProcess").hide();

	    $("#verMetasAgregadasXMes").hide();

	    $("#alertMetas").hide();


	    if($("#radioMeta1").is(':checked')){//cambiar texto del boton

	    	$("#btnShowModalExl").text("Agregar");
	    }else{
	    	$("#btnShowModalExl").text("Visualizar");
	    }
    
	});

	$('.custom-file-input').on('change',function(){//Mostrar nombrede archivo al seleccionarlo
    	
    	if ($(this).val()=='') {
			$('#fileLabelMeta').text('Seleccione un archivo Ecxel');
    	}else{
    		$('#fileLabelMeta').text($(this).val());
    	}
	});



	//Boton muestra modal de datos de metas a agregar o muestra datos de metas segun la fecha en de pendencia de que ratio Button este selecionado
	$("#btnShowModalExl").on('click', function(){

		if (validarCamposMeta()) {//Validar mes y año que no esten vacios

			$("#alertMetas").hide();

			if($("#radioMeta1").is(':checked')){

				if(!existeFechaMeta()){// si no existe mes y año seleciionados en datos de metas muestra el modal

					$('#btnShowModalExl').hide();
					$('#disabledLoaderBtn').show();
					truncate_tmp_exl_tbl();//Borrar registro de tabla temporal en phpMyAdmin
					exportarDatosExlAModalMetas();//Funcion para exportar datos de excel a la tabla temporal

				}else{// existe mes y a{ño uestra un alerta de bootstrap 
					$("#alertMetas").show();
					$("#alertMetas").css({"color":"red","font-weight":"bold"});
					$("#alertMetas").text("Ya existe meta con la fecha seleccioanda");
				}

		    }else{
		    	
		    	
		    	getHistorialMeta();//funcion para visualizar datos de metas por fecha agregados anteriormente 

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

		var columnDefs = new Array();
		var columns= new Array();

		columnDefs=[//tamaños de cplumans del datatable
				{ "width": "3%", "targets": [ 0 ] },
	            { "width": "3%", "targets": [ 1 ] },
	            { "width": "24%", "targets": [ 2 ] },
	            { "width": "10%", "targets": [ 3 ] },
	            { "width": "10%", "targets": [ 4 ] }
	            ];
		   
	    columns=[//variables para recibir datos de columnas del datatable
	    		{data:'CodVendedor', name:'CodVendedor'},
	    		{data:'CodProducto', name:'CodProducto'},
		        {data:'NombreProducto', name:'NombreProducto'},
		        {data:'Meta', name:'Meta'},
		        {data:'val', name:'val'}
		        ];

		inicialDataTablesMetas('#tblVerMetasAgregadas','get_historial_meta', columns);	// funcion que recibe el id del datatable a mostrar el url de la ruta y las vasriables para los datos de las columnas
	}

	function get_tmp_exl_data(){

		var columnDefs = new Array();
		var columns= new Array();

		columnDefs=[//tamaños de cplumans del datatable
				{ "width": "3%", "targets": [ 0 ] },
	            { "width": "3%", "targets": [ 1 ] },
	            { "width": "24%", "targets": [ 2 ] },
	            { "width": "10%", "targets": [ 3 ] },
	            { "width": "40%", "targets": [ 4 ] },
	            { "width": "10%", "targets": [ 5 ] },
	            { "width": "10%", "targets": [ 6 ] }
	            ];
		   
	    columns=[//variables para recibir datos de columnas del datatable
	    		{data:'ruta', name:'ruta'},
		        {data:'codigo', name:'codigo'},
		        {data:'cliente', name:'cliente'},
		        {data:'articulo', name:'articulo'},
		        {data:'descripcion', name:'descripcion'},
		        {data:'valor', name: 'valor'},
			    {data:'unidad', name:'unidad'}
		        ];

		inicialDataTablesMetas('#tblExcelImportMeta','get_tmp_exl_data',columns);// funcion que recibe el id del datatable a mostrar el url de la ruta y las vasriables para los datos de las columnas
	}
	
	function truncate_tmp_exl_tbl(){// funcion que trunca la tabla temporal que esta en phpMyadmin mysql antes de agregarle datos
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
            	//esconder, cambiar texto, y mostrar modal
            	$('#mesModalExl').text($("#selectMesMeta option:selected").text());
	            $('#annoModalExl').text(anno);
            	get_tmp_exl_data();
            	$('#disabledLoaderBtn').hide();
		        $('#modalShowModalExl').modal({backdrop: 'static', keyboard: false}); //modal no desaparecera si se le hace clik fuera de el
		    	$('#modalShowModalExl').modal('show');
		    	$('#btnShowModalExl').show();
            	
            	
            }
		});


	}
	function addDatatableDatosMeta(){
    	
		$.ajax({
		url:"add_data_meta",
		success: function(data){
			if(data!=0){
				$('#tituloToastMeta').text("Datos Procesados");
				$('#tituloToastMeta').css('color','black');
				$('#toastProcesoMetaText').text("Los datos han sido procesado exitosamente!");
				$('#modalShowModalExl').modal('hide');
				$("#procesarModalMetaExl").show();
				$("#cancelModalMetaBtn").show();
				$("#disabledLoaderBtnProcess").hide();
				$('#toast1').toast('show');//mostrar toast despues de procesar datos calculados (suma) hacia el servidor
			}else{
				$('#tituloToastMeta').text("Erro de plantilla");
				$('#toastProcesoMetaText').text("Documento excel no coinside con la plantilla configurada");
				$('#tituloToastMeta').css('color','red');
				$('#modalShowModalExl').modal('hide');
				$("#procesarModalMetaExl").show();
				$("#cancelModalMetaBtn").show();
				$("#disabledLoaderBtnProcess").hide();
				$('#toast1').toast('show');//mostrar toast despues de procesar datos calculados (suma) hacia el servidor
			}
			
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

	


	function inicialDataTablesMetas(dtName,dataUrl, columns){
		//$(dtName).DataTable().clear().draw();
		
		$(dtName).dataTable().fnDestroy();//destruir dataatble e inicializarlo nuevamente para eliminar datos solicitados anteriormente
		mes = $("#selectMesMeta option:selected").val();
		anno = $("#selectAnnoMeta option:selected").val();

		$(dtName).DataTable({
			'processing': true,
	        'serverSide': true,//proceso desde el servidor
	    	'ajax':{
	    		'url':dataUrl,
	    		'type': 'POST',
                'data': {
               	'mes': mes,
               	'anno': anno
               	},
            },
	    	'pageLength' : 10,
	    	'info':    false,
    	'lengthMenu': [[10,30,50,100,-1], [20,30,50,100,'Todo']],
    	'language': {
    		'sProcessing': 'Procesando...',
    	    'zeroRecords': 'Cargando...',
    	    'paginate': {
    	        'first':      'Primera',
    	        'last':       'Última ',
    	        'next':       'Siguiente',
    	        'previous':   'Anterior'
    	    },
    	    'lengthMenu': 'MOSTRAR _MENU_',
    	    'emptyTable': 'NO HAY DATOS DISPONIBLES',
    	    'infoEmpty': 'NO HAY DATOS DISPONIBLES',
    	    'search':     'BUSCAR'
    	}, 
	    	'columns': columns
		    
		});

		$(dtName+'_length').hide();//esconder select que muestra cantidad de registros por pagina
    	$(dtName+'_filter').hide();//Esconde input de filtro de tabla por texto escrito
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