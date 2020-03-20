<script>
	$(document).ready(function() {
        

		 $("#item-nav-01").after(`<li class="breadcrumb-item active">Recuperacion</li>`);// mostrar mapa de ubicación actual
         fillDtIntroRecup();
	});
    $('#btnCargardtIntroRecup').on('click', function(){
        fillDtIntroRecup();
    });

    function fillDtIntroRecup(){
         var mes = $('#selectMesIntroRecup option:selected').val();
        var anio = $('#selectAnnoIntroRecup option:selected').val();
      
        //Mostrar datos de recuperación en data table
        $('#dtIntroRecup').DataTable({
            'responsive': true,
            'autoWidth':false,
            'ajax':{
                'url':"getMoneyRecuRowsByRoutes/"+mes+"/"+anio,
                'dataSrc': '',
            },        
                "destroy" : true,
                "info":    false,
                "lengthMenu": [[30], [30]],
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
                    { "title": "Ruta",      "data": "RECU_RUTA" },
                    { "title": "Vendedor", "data": "RECU_VENDE" },
                    { "title": "Meta",      "data": "RECU_META" },
                    { "title": "Recu. Crédito",      "data": "RECU_CREDITO" },
                    { "title": "Recu. Contado","data": "RECU_CONTADO" },
                    { "title": "Recu. Total",      "data": "RECU_TOTAL" },
                    { "title": "% Cumplimiento",      "data": "RECU_CUMPLIMIENTO" },
                    //{ "title": 'Opciones',"data": "RECU_OPCIONES" },
                ],
                "columnDefs": [
                    {"className": "dt-center", "targets": [ 0, 1 , 2, 3, 4, 5, 6,]},
                    {"width":"5%","targets":[0,6]},
                    {"width":"40%","targets":[1]},
                    {"width":"10%","targets":[2,3,4,5,6]}
                ],
                
            });
        $('#dtIntroRecup_length').hide();//Ocultar select que muestra cantidad de registros por pagina
        $('#dtIntroRecup_filter').hide();//Esconde input de filtro de tabla por texto escrito
    }

	$('#InputDtSearchIntroRecup').on('keyup', function() {
        var table = $('#dtIntroRecup').DataTable();
        table.search(this.value).draw();
    });

    $( "#InputDtShowColumnsIntroRecupa").change(function() {
        var table = $('#dtIntroRecup').DataTable();
        table.page.len(this.value).draw();
    });

    function getAttr(inputAtt){
        var valCredito = 0.00;
        var valContado = 0.00;
        var valRutaCredito = "";
        var valRutaContado = "";
        var id = "";
        var totalRecu = 0.00;
        var meta;
        var table = $('#dtIntroRecup').DataTable();
        id = "#"+inputAtt.id;
        ruta = id.substr(-3,3);

        $("#recu_credito_"+ruta).keyup(function (){
            this.value = (this.value + '').replace(/[^0-9.]/g, '');
        });
        $("#recu_contado_"+ruta).keyup(function (){
            this.value = (this.value + '').replace(/[^0-9.]/g, '');
        });


        valCredito = $("#recu_credito_"+ruta).val();
        valContado = $("#recu_contado_"+ruta).val();
        
        meta = $("#recu_meta_"+ruta).text().replace(/[C$,]/gi,"");
        console.log(meta);
        totalRecu = Number(valCredito) + Number(valContado);
        $('#recu_total_'+ruta).text("C$" + totalRecu);
        $('#recu_cumplimiento_'+ruta).text(numeral((totalRecu/meta)*100).format('0,0.00')+'%');
        
    }

    
    //Accion al hacer clic sobre el boton de "guardar"
    $('#btnSaveIntroRecup').on('click', function(){
        var data = new Array();
        var  idCredito;
        var idContado;
        var table = $('#dtIntroRecup').DataTable();
        var info = table.page.info();
        var rowsshown = info.recordsDisplay;
        var j=0;
        

        for (var i = 0; i < table.data().count(); i++) {
            idCredito = '#recu_credito_'+table.cell( i, 0 ).data();
            idContado = '#recu_contado_'+table.cell( i, 0 ).data();

            if ($(idCredito).val() != null) {

                 data[j] = {ruta: table.cell( i, 0 ).data(), Recu_credito: $(idCredito).val(), Recu_contado: $(idContado).val(), fecha: $('#selectMesIntroRecup').val() +'-'+$('#selectAnnoIntroRecup').val() +'-01'};
                j++;
               
            }
            
        }

        console.log(table.data().count());
        console.log("cueta filtered: "+rowsshown);
        console.log(data);

        $.ajax({
            url:"agregatMetaRecup",
            method:"POST",
            data:{data},
            success: function(res){
       
                if (res = 1) {
                     $('#dtIntroRecup').DataTable().clear().draw();//elimina los registros de la tabla
                    fillDtIntroRecup();//Dibuja nuevamente los registros de la tabla con los cambios realizados
                    //location.reload();//ercarga pagina
               
                }
            }
        });

    
    });


       
	
</script>