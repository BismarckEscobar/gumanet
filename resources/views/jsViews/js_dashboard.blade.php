<script>
$(document).ready(function() {

    var list_chk = {
                    'container-vm' : 'Ventas del mes',
                    'container-rm' : 'Recuperacion del mes',
                    'container-vb' : 'Valorización de Bodegas',
                    'container-tc' : 'Top 10 de Clientes',
                    'container-tp' : 'Top 10 de Productos' };

    var list_dash = '';

    //GUARDO VARIABLES EN COOKIES
    $(".content-graf .graf div").each(function(){
        name_class = $(this).attr('class');
        ( $.cookie( name_class )=='not_visible' )?($(this).hide()):($(this).show());

        visibility = ( $.cookie( name_class )=='not_visible' )?'':'checked';

        list_dash +=
        `<li class="">
          <div class="form-check">
            <input class="dash-opc form-check-input" type="checkbox" `+visibility+` value="`+name_class+`" id="`+name_class+`">
            <label class="form-check-label" for="`+name_class+`">
              `+ ( list_chk[name_class] ) +`
            </label>
          </div>
        </li>`
    });

    //AGREGO LA RUTA AL NAVEGADOR
    $("#item-nav-01").after(`<li class="breadcrumb-item active">Home</li>`);

    $("#content-dash").append(`
      <p class="font-weight-bold ml-2">Ver en Dashboard</p>
      <ul class="list-group list-group-flush mt-3">
        `+list_dash+`
      </ul>`);

	
	/*Highcharts.chart('chart02', {
	    chart: {
	        plotBackgroundColor: null,
	        plotBorderWidth: null,
	        plotShadow: false,
	        type: 'pie'
	    },
	    title: {
	        text: 'Recuperación del mes'
	    },
	    tooltip: {
	        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
	    },
	    plotOptions: {
	        pie: {
	            allowPointSelect: true,
	            cursor: 'pointer',
	            dataLabels: {
	                enabled: false
	            },
	            showInLegend: true
	        }
	    },
	    series: [{
            cursor: 'pointer',
            point: {
                events: {
                    click: function() {
                        detalleVentasMes('recu', 'Recuperacion del Mes');
                    }
                }
            },
	        name: 'Brands',
	        colorByPoint: true,
	        data: [{
	            name: 'Real',
	            y: 75.3,
	            sliced: true,
	            selected: true
	        }, {
	            name: 'Meta',
	            y: 24.7
	        }]
	    }]
	});*/


Highcharts.setOptions({

    lang: {
        numericSymbols: [ 'k' , 'M' , 'B' , 'T' , 'P' , 'E'],
      decimalPoint: '.',
      thousandsSep: ','
    }
});


    Highcharts.chart('chart01', {

        chart: {
            type: 'column',
              
        },
        title: {
            text: 'Ventas del mes'
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: ''
            }

        },

        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                allowPointSelect: true,
                cursor: 'pointer',
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                  formatter: function() {
                    if (this.y > 1000) {
                      return Highcharts.numberFormat(this.y / 1000, 1) + "K";
                    } else {
                      return this.y
                    }
                  }
                }
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>C${point.y:,.2f}</b>',
             shared: true,
            useHTML: true
        },
        series: [{

            states: {
                select: {
                    color: null
                }
            },
            cursor: 'pointer',
            point: {
                events: {

                    click: function(event) {

                                                    
                         
                        detalleVentasMes('vent', 'Ventas del Mes');
                    }
                }
            },
                name: "Ventas",
                colorByPoint: true,
                data: [
                    {
                        name: "Real",
                        y: 2262432.74,
                        drilldown: "Real"
                    },
                    {
                        name: "Meta",
                        y: 315321.57,
                        drilldown: "Meta"
                    },
                    
                ]
            }
        ]
        
    });



    Highcharts.chart('chart02', {

        chart: {
            type: 'column'
        },
        title: {
            text: 'Recuperacion del Mes'
        },
         xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: ''
            }

        },

        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                allowPointSelect: true,
                cursor: 'pointer',
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                  formatter: function() {
                    if (this.y > 1000) {
                      return Highcharts.numberFormat(this.y / 1000, 1) + "K";
                    } else {
                      return this.y
                    }
                  }
                }
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>C${point.y:,.2f}</b>',
             shared: true,
            useHTML: true
        },
        series: [{
            states: {
                select: {
                    color: null
                }
            },
            cursor: 'pointer',
            point: {
                events: {
                    click: function() {
                        detalleVentasMes('recu', 'Recuperacion del Mes');
                    }
                }
            },
                name: "Recuperación",
                colorByPoint: true,
                data: [
                    {
                        name: "Real",
                        y: 11222.74,
                        drilldown: "Real"
                    },
                    {
                        name: "Meta",
                        y: 8929.43,
                        drilldown: "Meta"
                    },
                    
                ]
            }
        ]
        
    });




    // Create the chart
    Highcharts.chart('chart03', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Valorización'
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: ''
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                allowPointSelect: true,
                cursor: 'pointer',
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                  formatter: function() {
                    if (this.y > 1000) {
                      return Highcharts.numberFormat(this.y / 1000, 1) + "K";
                    } else {
                      return this.y
                    }
                  }
                }
            }
        },
       tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>C${point.y:,.2f}</b>',
             shared: true,
            useHTML: true
        },
        series: [
            {
                states: {
                select: {
                    color: null
                }
            },
                name: "Bodegas",
                colorByPoint: true,
                data: [
                    {
                        name: "BC01",
                        y: 6443.74,
                        drilldown: "BC01"
                    },
                    {
                        name: "BC02",
                        y: 10345.57,
                        drilldown: "BC02"
                    },
                    {
                        name: "BC03",
                        y: 799.23,
                        drilldown: "BC03"
                    },
                    {
                        name: "BC04",
                        y: 5434.58,
                        drilldown: "BC04"
                    },
                    {
                        name: "BC05",
                        y: 4432.02,
                        drilldown: "BC05"
                    }
                ]
            }
        ]
    });

    // Create the chart
    Highcharts.chart('chart04', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Top 10 de clientes'
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: ''
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                allowPointSelect: true,
                cursor: 'pointer',
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                  formatter: function() {
                    if (this.y > 1000) {
                      return Highcharts.numberFormat(this.y / 1000, 1) + "K";
                    } else {
                      return this.y
                    }
                  }
                }
            }
        },
         tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>C${point.y:,.2f}</b>',
             shared: true,
            useHTML: true
        },
        series: [
            {
                states: {
                select: {
                    color: null
                }
            },
                name: "Clientes",
                colorByPoint: true,
                data: [
                    {
                        name: "C1",
                        y: 6243.74,
                        drilldown: "C1"
                    },
                    {
                        name: "C2",
                        y: 10231.57,
                        drilldown: "C2"
                    },
                    {
                        name: "C3",
                        y: 7212.23,
                        drilldown: "C3"
                    },
                    {
                        name: "C4",
                        y: 5232.58,
                        drilldown: "C4"
                    },
                    {
                        name: "C5",
                        y: 4321.02,
                        drilldown: "C5"
                    }
                ]
            }
        ]
    });

    // Create the chart
    Highcharts.chart('chart05', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Top 10 de Prod. mas vendidos'
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: ''
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                allowPointSelect: true,
                cursor: 'pointer',
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                  formatter: function() {
                    /*if (this.y > 1000000) {
                      return Highcharts.numberFormat(this.y / 1000000, 2) + "M"
                    } else */if (this.y > 1000) {
                      return Highcharts.numberFormat(this.y / 1000, 1) + "K";
                    } else {
                      return this.y
                    }
                  }
                }
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>C${point.y:,.2f}</b>',
             shared: true,
            useHTML: true
        },
        series: [
            {
                states: {
                select: {
                    color: null
                }
            },
                name: "Productos",
                colorByPoint: true,
                data: [
                    {
                        name: "P1",
                        y: 962.74,
                        drilldown: "P1"
                    },
                    {
                        name: "P2",
                        y: 10323.57,
                        drilldown: "P2"
                    },
                    {
                        name: "P3",
                        y: 7543.23,
                        drilldown: "P3"
                    },
                    {
                        name: "P4",
                        y: 5432.58,
                        drilldown: "P4"
                    },
                    {
                        name: "P5",
                        y: 4654.02,
                        drilldown: "P5"
                    }
                ]
            }
        ]
    });

});

function detalleVentasMes(tipo, title) {
    $('#title-page-tem').text(title);
    $("#page-details").toggleClass('active');

    switch(tipo) {
        case 'vent':
            $("#dtTemporal").dataTable({
                responsive: true,
                "autoWidth":false,
                "ajax":{
                    "url": "detalles/"+tipo,
                    'dataSrc': '',
                },
                "destroy" : true,
                "info":    false,
                "lengthMenu": [[5,10,20,50,-1], [20,30,50,100,"Todo"]],
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
                    { "title": "Articulo",      "data": "ARTICULO" },
                    { "title": "Descripcion",   "data": "DESCRIPCION" },
                    { "title": "U/M",      "data": "U_MEDIDA" },
                    { "title": "Cantidad",      "data": "CANTIDAD" },
                    { "title": "Monto",         "data": "MONTO" }
                ]
            });
            $('#MontoReal').text('C$ 5,000.00');
            $('#txtMontoReal').text('Total real venta');

            $('#MontoMeta').text('C$ 10,000.00')
            $('#txtMontoMeta').text('Total meta');
        break;
      case 'recu':
        $("#dtTemporal").dataTable({
            responsive: true,
            "autoWidth":false,
            "ajax":{
                "url": "detalles/"+tipo,
                'dataSrc': '',
            },
            "info":    false,
            "destroy" : true,
            "lengthMenu": [[5,10,20,50,-1], [20,30,50,100,"Todo"]],
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
                { "title": "Ruta",          "data": "RUTA" },
                { "title": "Nombre",        "data": "NOMBRE" },
                { "title": "Monto",         "data": "MONTO" },
                { "title": "Meta",          "data": "META" },
                { "title": "Efectividad",   "data": "EFEC" }
            ]
        });
        $('#MontoReal').text('C$ 5,000.00');
        $('#txtMontoReal').text('Total real recuperado');

        $('#MontoMeta').text('C$ 10,000.00')
        $('#txtMontoMeta').text('Total meta');
        break;
      default:
        mensaje("Ups... algo ha salido mal")
    }
    $("#dtTemporal_length").hide();
    $("#dtTemporal_filter").hide();
}

$('#filterDtTemp').on( 'keyup', function () {
    var table = $('#dtTemporal').DataTable();
    table.search(this.value).draw();
});

$( "#cantRowsDtTemp").change(function() {
    var table = $('#dtTemporal').DataTable();
    table.page.len(this.value).draw();
});

$(".active-page-details").click( function() {
    $("#page-details").toggleClass('active');
});

/*OCULTANDO GRAFICAS DASHBOARD*/
$(document).on('change', '.dash-opc', function(e) {
    if( $(this).prop('checked') ) {

        $.cookie( $(this).val() , 'yes_visible');
        $("."+( $(this).val() )).show();
        $.removeCookie($(this).val());
    }else {
        $.cookie( $(this).val() , 'not_visible');
        $("."+( $(this).val() )).hide();
    }
});

</script>