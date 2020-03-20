<script>
$(document).ready(function() {
    var date    = new Date();
    var anio    = parseInt(date.getFullYear())
    var mes     = parseInt(date.getMonth()+1);
    var list_chk = {
                    'container-vm' : 'Ventas del mes',
                    'container-rm' : 'Recuperacion del mes',
                    'container-vb' : 'Valorización de Bodegas',
                    'container-cv' : 'Reporte YTD Montos C$',
                    'container-cc' : 'Reporte YTD (Total de Items)',
                    'container-tc' : 'Top 10 de Clientes',
                    'container-tp' : 'Top 10 de Productos',
                    'container-vms': 'Comportamiento de ventas',
                    'container-cat': 'Ventas por categorias' };

    var list_dash = '';

    //GUARDO VARIABLES EN COOKIES
    $(".content-graf .graf div").each(function() {
        name_class = $(this).attr('class');
        ( $.cookie( name_class )=='not_visible' || name_class=='container-vb' )?($('div.'+name_class).parent().hide()):($('div.'+name_class).parent().show());

        visibility = ( $.cookie( name_class )=='not_visible' )?'':'checked';

        if (name_class!='container-vb') {
            list_dash +=
            `<li class="">
              <div class="form-check">
                <input class="dash-opc form-check-input" type="checkbox" `+visibility+` value="`+name_class+`" id="`+name_class+`">
                <label class="form-check-label" for="`+name_class+`">
                  `+ ( list_chk[name_class] ) +`
                </label>
              </div>
            </li>`
        }
    });

    //AGREGO LA RUTA AL NAVEGADOR
    $("#item-nav-01").after(`<li class="breadcrumb-item active">Home</li>`);

    $("#content-dash").append(`
      <p class="font-weight-bold ml-2">Ver en Dashboard</p>
      <ul class="list-group list-group-flush mt-3">
        `+list_dash+`
      </ul>`);

    reordenandoPantalla();
    actualizandoGraficasDashboard(mes, anio);
    grafVentasMensuales();
    
    Highcharts.setOptions({
        lang: {
            numericSymbols: [ 'k' , 'M' , 'B' , 'T' , 'P' , 'E'],
            decimalPoint: '.',
            thousandsSep: ','
        },
        colors: ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4']
    });

    //GRAFICA VENTAS MENSUALES
    ventasMensuales = {
        chart: {
           type: 'spline',
            renderTo: 'grafVtsMes'
        },
        title: {
            text: `<p class="font-weight-bolder">Comportamiento de ventas</p>`
        },
        xAxis: {
            categories: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic']
        },
        yAxis: {
            title: {
                text: ''
            }                
        },
        plotOptions: {
            series: {
                allowPointSelect: false,
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                  formatter: function() {
                    return FormatPretty(this.y);
                  }
                },
                events: {
                    legendItemClick: function() {
                      return false;
                    }
                }
            },
        },
        tooltip: {
            pointFormat: '<span style="color:black"><b>C$ {point.y:,.2f}</b></span>'
        },
        legend: {
            align: 'center',
            verticalAlign: 'top',
            borderWidth: 0
        },
        series: [],
        responsive: {
            rules: [{
                condition: {
                maxWidth: 500
                },
                chartOptions: {
                    legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                    }
                }
            }]
        }
    };

    //GRAFICA VENTAS POR CATEGORIAS
    ventasXCateg = {
        chart: {
            type: 'pie',
            renderTo: 'grafVtsXCateg',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'Ventas por categorias'
        },
        subtitle: {},
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        tooltip: {
            pointFormat: "<p class='font-weight-bold' style='font-size:14px'>C${point.y:,.2f}<br><span class='font-weight-bold' style='color:green; font-size:14px'>({point.porc}%)</span></p>"
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 45,
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            },
            series: {
                allowPointSelect: false,
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    formatter: function( ) {
                    return this.point.name+' '+ FormatPretty(this.y);
                  }
                }
            },
        },
        series: [{
            data: [],
        }],
    };

    //GRAFICA VENTAS
    ventas = {
        chart: {
            type: 'column',
            renderTo: 'grafVentas'
        },
        title: {
            text: 'Ventas del mes'
        },
        subtitle: {},
        xAxis: {
            type: 'category',
            visible: false
        },
        yAxis: {
            title: {
                text: ''
            },
            stackLabels: {
            enabled: true,
            formatter: function() {
                return FormatPretty(this.total);
                
              }
            }
        },
        tooltip: {
            formatter: function() {
                return this.series.tooltipOptions.customTooltipPerSeries.call(this);
            }
        },
        legend: {
            enabled: true
        },
        plotOptions: {
            series: {
                allowPointSelect: false,
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                  formatter: function() {
                    return FormatPretty(this.y);
                  }
                }
            },
        },
        series: [],
    };

    //GRAFICA RECUPERACION DEL MES
    recuperacionMes = {
       chart: {
            type: 'column',
            renderTo: 'grafRecupera'
        },
        title: {
            text: 'Recuperación del mes'
        },
        xAxis: {
            type: 'category',
            visible: false
        },
        yAxis: {
            title: {
                text: ''
            }

        },
        legend: {
            enabled: true
        },
        plotOptions: {
            series: {
                allowPointSelect: false,
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                  formatter: function() {
                    return FormatPretty(this.y);
                  }
                }
            },
        },
        tooltip: {
        formatter: function() {
            return this.series.tooltipOptions.customTooltipPerSeries.call(this);
            }
        },
        series:[{
            colorByPoint: true,
            data: [],
            showInLegend: false
        }]  
    };

    //GRAFICA COMPARACION VENTAS
    comparacionMesesVentas = {
       chart: {
            type: 'column',
            renderTo: 'grafCompMontos'
        },
        title: {
            text: 'Reporte YTD Montos C$'
        },
        xAxis: {
            type: 'category',
            visible: false
        },
        yAxis: {
            title: {
                text: ''
            }

        },
        legend: {
            enabled: true
        },
        plotOptions: {
            series: {
                allowPointSelect: false,
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                  formatter: function() {
                    return FormatPretty(this.y);
                  }
                }
            },
        },
        tooltip: {
        formatter: function() {
            return this.series.tooltipOptions.customTooltipPerSeries.call(this);
            }
        },
        series:[{
            colorByPoint: true,
            data: [],
            showInLegend: false
        }]  
    };

    //GRAFICA COMPARACION ITEMS
    comparacionMesesItems = {
       chart: {
            type: 'column',
            renderTo: 'grafCompCantid'
        },
        title: {
            text: 'Reporte YTD (Total de Items)'
        },
        xAxis: {
            type: 'category',
            visible: false
        },
        yAxis: {
            title: {
                text: ''
            }

        },
        legend: {
            enabled: true
        },
        plotOptions: {
            series: {
                allowPointSelect: false,
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                  formatter: function() {
                    return FormatPretty(this.y);
                  }
                }
            },
        },
        tooltip: {
        formatter: function() {
            return this.series.tooltipOptions.customTooltipPerSeries.call(this);
            }
        },
        series:[{
            colorByPoint: true,
            data: [],
            showInLegend: false
        }]  
    };

    //GRAFICA: VALORIZACION DE INVENTARIO
    val_bodega = {
        chart: {
            type: 'column',
            renderTo: 'grafBodega'
        },
        title: {
            text: 'Valorización de Bodegas'
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
                allowPointSelect: false,
                
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
            pointFormat: '<span style="color:black"><b>C$ {point.y}</b></span>'
        },
        series:[{
            colorByPoint: true,
            data: [],
            showInLegend: false
        }]    
    };

    //GRAFICA: TOP 10 CLIENTES
    clientes = {
        chart: {
            type: 'column',
            renderTo: 'grafClientes'
        },
        title: {
            text: 'Top 10 Clientes'
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
                allowPointSelect: false,                
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
            pointFormat: '<span style="color:{point.color}"><b>C${point.y:,.2f}</b>',
        },
        series:[{
            colorByPoint: true,
            data: [],
            showInLegend: false,
            cursor: 'pointer',
            point: {
                events: {
                    click: function(e) {
                        detalleVentasMes('clien', `[`+this.category+`] - `+this.name, this.category, 'ND');
                    }
                }
            }
        }]        
    }

    //GRAFICA: TOP 10 PRODUCTOS
    productos = {
        chart: {
            type: 'column',
            renderTo: 'grafProductos'
        },
        title: {
            text: 'Top 10 Productos mas vendidos'
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
                allowPointSelect: false,
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
            pointFormat: '<span style="color:black"><b>C$ {point.y}</b></span>'
        },
        series:[{
            colorByPoint: true,
            data: [],
            showInLegend: false,
            cursor: 'pointer',
            point: {
                events: {
                    click: function(e) {
                        detalleVentasMes('artic', `[`+this.category+`] - `+this.name, 'ND', this.category);
                    }
                }
            },
        }]        
    }

    var st = $('#sidebar-menu-left').hasClass('active');
    if (st) {
        $('#page-details').css('width','100%')
    }

    fullScreen();
});

var colors = ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'];

$("#filterM_A").click( function(e) {
    var mes = $('#opcMes option:selected').val();
    var anio = $('#opcAnio option:selected').val();
    actualizandoGraficasDashboard(mes,anio)
})

var val_bodega                  = {};
var clientes                    = {};
var ventas                      = {};
var recuperacionMes             = {};
var comparacionMesesVentas      = {};
var comparacionMesesItems       = {};
var ventasXCateg                = {};
var montoMetaVenta              = 0;
var montoMetaRecup              = 0;
function actualizandoGraficasDashboard(mes, anio) {
    $("#grafClientes, #grafProductos, #grafVentas, #grafBodega, #grafRecupera, #grafCompMontos, #grafCompCantid, #grafVtsXCateg")
    .empty()
    .append(`<div style="height:400px; background:#ffff; padding:20px">
                <div class="d-flex align-items-center">
                  <strong>Cargando...</strong>
                  <div class="spinner-border ml-auto text-primary" role="status" aria-hidden="true"></div>
                </div>
            </div>`);

    $.getJSON("dataGraf/"+mes+"/"+anio, function(json) {
        var dta = [];
        var title = [];

        $.each(json, function (i, item) {
            switch (item['tipo']) {
                case 'dtaBodega':
                    dta = [];
                    title = [];
                    $.each(item['data'], function(i, x) {
                        dta.push({
                            name  : x['bodega'],
                            y     : x['data']
                        })

                        title.push(x['name'])
                    });                    
                    val_bodega.xAxis.categories = title;
                    val_bodega.series[0].data = dta;
                    val_bodega.subtitle = 'Datos hasta la fecha';
                    chart = new Highcharts.Chart(val_bodega);

                break;
                case 'dtaCliente':
                    dta = [];
                    title = [];
                    $.each(item['data'], function(i, x) {
                        dta.push({
                            name  : x['cliente'],
                            y     : x['data']
                        })

                        title.push(x['name'])
                    });                    
                    clientes.xAxis.categories = title;
                    clientes.series[0].data = dta;
                    chart = new Highcharts.Chart(clientes);

                break;
                case 'dtaProductos':
                    dta = [];
                    title = [];
                    $.each(item['data'], function(i, x) {
                        dta.push({
                            name  : x['articulo'],
                            y     : x['data']
                        })

                        title.push(x['name'])
                    });                    
                    productos.xAxis.categories = title;
                    productos.series[0].data = dta;
                    chart = new Highcharts.Chart(productos);
                break;
                case 'dtaVentasXCateg':
                    dta = [];
                    cate = '<option>TODAS LAS CATEGORIAS</option>';
                    
                    objVenta = item['data'].map(function (obj) {return obj.data;});
                    mTotal = objVenta.reduce(function (m, n) {return m + n;}, 0);

                    $.each(item['data'], function(i, x) {
                        dta.push({
                            name  : x['name'],
                            y     : x['data'],
                            porc  : numeral((parseFloat(x['data'])/parseFloat(mTotal))*100).format('0.00')
                        })
                        cate += `<option>`+x['name']+`</option>` 
                    });
                    $("#select-cate")
                    .append(cate)
                    .selectpicker('refresh');

                    ventasXCateg.subtitle = {text: 'Todas las  categorias'};
                    ventasXCateg.series[0].data = dta;
                    chart = new Highcharts.Chart(ventasXCateg);
                    $('.highcharts-title').append('<p>Vamos venga</p>')
                break;
                case 'dtaVentasMes':
                    dta = [];
                    title = [];
                    items = 0;
                    ventas.series = [];
                    if (item['data'].length>0) {
                        $.each(item['data'], function(i, x) {
                            if (x['name']=='items') {
                                items = parseFloat(x['data']);
                            } else {
                                dta.push({
                                    name  : x['name'],
                                    y     : x['data'],
                                })
                                title.push(x['name']);
                            }
                        });

                        var real_ = dta[0]['y'];
                        var meta_ = json[3].data[1].data;
                        var remanente = 0;

                        var porcentaje = (meta_!=0)? (real_/meta_) * 100 :0;

                        if ( real_>meta_ && meta_>0 ) {
                            remanente = real_- meta_
                        } else {
                            remanente = 0;
                        }
                        porcentaje = `<p class="font-weight-bolder" style="font-size:14px">`+numeral(porcentaje).format('0,0.00')+`% de 100%</p>`;
                        ventas.series[0]= {
                            name: 'Real',
                            type: 'column',
                            data: [real_],
                            tooltip: {
                              customTooltipPerSeries: function() {
                                return '<b>C$ '+numeral(real_).format('0,0.00')+'<br>N° de items '+items+'</b>';
                              }
                            },
                            cursor: 'pointer',
                            point: {
                                events: {
                                    click: function(e) {
                                        detalleVentasMes('vent', 'Ventas del Mes', 'data');
                                    }
                                }
                            },
                            color: colors[0]
                        }

                        ventas.series[1]= {
                            name: 'Meta',
                            type: 'column',
                            data: [meta_],
                            tooltip: {
                              customTooltipPerSeries: function() {
                                return '<b>C$ '+numeral(meta_).format('0,0.00')+'</b>';
                              }
                            },
                            cursor: 'pointer',
                            point: {
                                events: {
                                    click: function(e) {
                                        detalleVentasMes('vent', 'Ventas del Mes', 'data');
                                    }
                                }
                            },
                            color: colors[1],
                            allowPointSelect: false,                
                            borderWidth: 0,
                        }
                        
                        ventas.subtitle = {text: porcentaje};
                        montoMetaVenta = numeral(json[3].data[1].data).format('0,0.00');
                    }

                    chart = new Highcharts.Chart(ventas);
                break;
                case 'dtaCompMesesVentas':
                    dtaVentasMes = item['data'];
                    title = [];
                    $.each(item['data'], function(i, x) {
                        comparacionMesesVentas.series[i]= {
                            name: x['name'],
                            type: 'column',
                            data: [x['data']],
                            tooltip: {
                              customTooltipPerSeries: function() {
                                return x['name']+'<br><b>C$ '+numeral(x['data']).format('0,0.00')+'</b>';
                              }
                            },
                            cursor: 'pointer',
                            point: {
                                events: {
                                    click: function(e) {
                                        detalleComparacionVentas(dtaVentasMes, 'vts')
                                    }
                                }
                            },
                            color: colors[i],
                            allowPointSelect: false,                
                            borderWidth: 0,
                        }
                        title.push(x['name'])
                    });
                    chart = new Highcharts.Chart(comparacionMesesVentas);
                break;

                case 'dtaCompMesesItems':
                    dtaItems = item['data'];
                    title = [];
                    $.each(item['data'], function(i, x) {
                        comparacionMesesItems.series[i]= {
                            name: x['name'],
                            type: 'column',
                            data: [x['data']],
                            tooltip: {
                              customTooltipPerSeries: function() {
                                return x['name']+'<br><b>'+numeral(x['data']).format('0')+'</b>';
                              }
                            },
                            cursor: 'pointer',
                            point: {
                                events: {
                                    click: function(e) {
                                        detalleComparacionVentas(dtaItems, 'its')
                                    }
                                }
                            },
                            color: colors[i],
                            allowPointSelect: false,                
                            borderWidth: 0,
                        }
                        title.push(x['name'])
                    });
                    chart = new Highcharts.Chart(comparacionMesesItems);                    
                break;
                case 'dtaRecupera':
                    dta = item['data'];
                    title = [];
                    recuperacionMes.series = [];

                    if (item['data'].length>0) {
                        $.each(item['data'], function(i, x) {
                            recuperacionMes.series[i]= {
                                name: x['name'],
                                type: 'column',
                                data: [x['data']],
                                tooltip: {
                                  customTooltipPerSeries: function() {
                                    return x['name']+'<br><b>C$ '+numeral(x['data']).format('0,0.00')+'</b>';
                                  }
                                },
                                cursor: 'pointer',
                                point: {
                                    events: {
                                        click: function(e) {
                                            detalleVentasMes('recu', 'Recuperacion del Mes', 'ND', 'ND');
                                        }
                                    }
                                },
                                color: colors[i],
                                allowPointSelect: false,                
                                borderWidth: 0,
                            }

                            title.push(x['name'])
                        });

                        var real_ = dta[0]['data'];
                        var meta_ = dta[1]['data'];
                        var remanente = 0;

                        var porcentaje = (meta_!=0)? (real_/meta_) * 100 :0;
                        remanente = (real_>meta_)? real_- meta_ :0;
                        porcentaje = `<p class="font-weight-bolder" style="font-size:13px">`+numeral(porcentaje).format('0,0.00')+`% de 100%</p>`;
                        
                        recuperacionMes.subtitle = {text: porcentaje};
                        montoMetaRecup = numeral(meta_).format('0,0.00');
                    }

                    chart = new Highcharts.Chart(recuperacionMes);                    
                break;
                default:
                alert('Ups... parece que ocurrio un error :(');
            }
        });
    });
}

$("#select-cate").change(function() {
    cate = this.value;
    $.ajax({
        url: 'dataCate',
        type: 'post',
        data: {
            mes : $('#opcMes option:selected').val(),
            anio: $('#opcAnio option:selected').val(),
            cate: this.value
        },
        async: true,
        success: function(response) {
            dta = [];
            
            objVenta = response.map(function (obj) {return obj.data;});
            mTotal = objVenta.reduce(function (m, n) {return m + n;}, 0);
            
            $.each(response, function(i, x) {
                dta.push({
                    name  : x['name'],
                    y     : x['data'],
                    porc  : numeral((parseFloat(x['data'])/parseFloat(mTotal))*100).format('0.00')
                })
            });            
            ventasXCateg.subtitle = {text: cate};
            ventasXCateg.series[0].data = dta;
            chart = new Highcharts.Chart(ventasXCateg);
        }
    })
})

var ventasMensuales = {};
function grafVentasMensuales() {
    $("#grafVtsMes")
    .empty()
    .append(`<div style="height:400px; background:#ffff; padding:20px">
                <div class="d-flex align-items-center">
                  <strong>Cargando comportamiento de ventas...</strong>
                  <div class="spinner-border ml-auto text-primary" role="status" aria-hidden="true"></div>
                </div>
            </div>`);
    ventasMensuales.series = [];
    $.getJSON("dataVentasMens", function(json) {
        var newseries;

        $.each(json, function (i, item) {
            newseries = {};
            newseries.data = item['venta'];
            newseries.name = item['name'];
            ventasMensuales.series.push(newseries);
        })

        var chart = new Highcharts.Chart(ventasMensuales);
    })
}

var tableActive='';
function detalleVentasMes(tipo, title, cliente, articulo) {
    $('#title-page-tem')
    .addClass('text-uppercase')
    .text(title);
    $("#page-details").toggleClass('active');
    mes         = $("#opcMes option:selected").val();
    mesNombre   = $("#opcMes option:selected").text();
    anio        = $("#opcAnio option:selected").val();    

    FechaFiltrada = `Mostrando registros de `+mesNombre+` de `+anio;
    $("#fechaFiltrada").text(FechaFiltrada);
    $('#filterDtTemp').val('');

    switch(tipo) {
        case 'vent':
            $('#MontoReal').text('Cargando...');
            $('#cumplMeta').text('Cargando...');
            $('#cumplMetaContent').show();
            $("#montoMetaContent").show();
            $("#cjVentas").show();
            $("#cjRecuperacion").hide();
            $("#cjCliente").hide();
            $("#cjArticulo").hide();
            $("#cjRutVentas").show();
            tableActive = `#dtTotalXRutaVent`;
            $("#MontoMeta").text('C$ '+montoMetaVenta);
            $("#cantRowsDtTemp selected").val("5");
            $.ajax({// calcula el total real neto
                    url: "detalles/"+tipo+"/"+mes+"/"+anio+"/ND/ND/ND",
                    type: "GET",
                    async: true,
                    success: function(res) {
                        tmp = parseFloat($('#MontoMeta').text().replace(/[\ U,C$]/g, ''))
                        $('#MontoReal').empty()
                                        .text('C$ '+ numeral(res[0]['MONTO']).format('0,0.00'));

                        cump = (tmp>0)?(( parseFloat(res[0]['MONTO']) / tmp ) * 100):0;
                        $('#cumplMeta').text(numeral(cump).format('0.00')+'%');
                    }
                });

            //Tabla Ventas de Unidades de productos por productos por Mes por Ruta
            $(tableActive).dataTable({
                responsive: true,
                "autoWidth":false,
                "ajax":{
                    "url": "unidadxProd/"+mes+"/"+anio,
                    'dataSrc': '',
                },
                "destroy" : true,
                "info":    false,
                "lengthMenu": [[5,10,20,50,-1], [5,30,50,100,"Todo"]],
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
                    { "title": "Ruta",              "data": "RUTA" },
                    { "title": "Nombre",            "data": "VENDE" },
                    { "title": "Meta Units.",       "data": "METAU" },
                    { "title": "Real Units.",       "data": "REALU" },
                    { "title": "% Cumpl. Units.",   "data": "DIFU" },
                    { "title": "Meta Vtas.",        "data": "METAE" },
                    { "title": "Real Vtas.",        "data": "REALE" },
                    { "title": "% Cumpl. Vtas.",    "data": "DIFE" },
                ],
                "columnDefs": [
                    {"className": "dt-left", "targets": [ 1 ]},
                    //{"className": "dt-right", "targets": [ 2, 3, 4, 5, 6, 7 ]},
                    {"className": "dt-back-unit", "targets": [ 2, 3, 4 ]},
                    {"className": "dt-back-vtas", "targets": [ 5, 6, 7 ]},
                    {"className": "dt-center", "targets": [ 0 ]}
                ],
                
            });
            $('#txtMontoReal').text('Total real ventas');
            $('#txtMontoMeta').text('Total meta venta');
            break;
        case 'recu':
            $("#cjRecuperacion").show();
            $('#cumplMetaContent').show();
            $("#cjVentas").hide();
            $("#cjRutVentas").hide();
            $("#cjCliente").hide();
            $("#cjArticulo").hide();
            $("#montoMetaContent").show();
            $("#MontoMeta").text('C$ '+montoMetaRecup);
            $("#cantRowsDtTemp selected").val("5");
            tableActive = `#dtRecuperacion`;

            $(tableActive).dataTable({
                responsive: true,
                "autoWidth":false,
                "ajax":{
                    "url": "detalles/"+tipo+"/"+mes+"/"+anio+"/ND/ND/ND",
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
                ],
                "columnDefs": [
                    {"className": "dt-right", "targets": [ 2, 3 ]},
                    {"className": "dt-center", "targets": [ 0, 4 ]}
                ],
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                        i : 0;
                    };
                    total = api
                    .column( 2 )
                    .data()
                    .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                    }, 0 );
                    tmp = parseFloat($('#MontoMeta').text().replace(/[\ U,C$]/g, ''));
                    cump = (tmp>0)?(( parseFloat(total) / tmp ) * 100):0;
                    $('#cumplMeta').text(numeral(cump).format('0.00')+'%');
                    $('#MontoReal').text('C$'+ numeral(total).format('0,0.00'));
                }
            })

            $('#txtMontoReal').text('Total real recuperado');
            $('#txtMontoMeta').text('Total meta recuperacion');
        break;
        case 'clien':
            $("#cjRecuperacion").hide();
            $("#cjVentas").hide();
            $('#cumplMetaContent').hide();
            $("#cjRutVentas").hide();
            $("#cjArticulo").hide();
            $("#montoMetaContent").hide()
            $("#cjCliente").show();
            tableActive = `#dtCliente`;
            
            $(tableActive).dataTable({
                responsive: true,
                "autoWidth":false,
                "ajax":{
                    "url": "detalles/"+tipo+"/"+mes+"/"+anio+"/"+cliente+"/ND/ND",
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
                    { "title": "Cantidad",      "data": "CANTIDAD" },
                    { "title": "Total",         "data": "TOTAL" }
                ],
                "columnDefs": [
                    {"className": "dt-right", "targets": [ 2, 3 ]},
                    {"className": "dt-center", "targets": [ 0 ]}
                ],
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
                    total = api
                        .column( 3 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    $('#MontoReal').text('C$'+ numeral(total).format('0,0.00'));
                    $('#txtMontoReal').text('Total facturado');


                    $('#MontoMeta').text('');
                    $('#txtMontoMeta').text('');
                }
            });
        break;
        case 'artic':
            $("#cjRecuperacion").hide();
            $('#cumplMetaContent').hide();
            $("#cjVentas").hide();
            $("#cjRutVentas").hide();
            $("#cjCliente").hide();
            $("#montoMetaContent").hide()
            $("#cjArticulo").show();
            tableActive = `#dtArticulo`;
            
            $(tableActive).dataTable({
                responsive: true,
                "autoWidth":false,
                "ajax":{
                    "url": "detalles/"+tipo+"/"+mes+"/"+anio+"/ND/"+articulo+"/ND",
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
                    { "title": "Cliente",      "data": "CLIENTE" },
                    { "title": "Nombre",       "data": "NOMBRE" },
                    { "title": "Cantidad",     "data": "CANTIDAD" },
                    { "title": "Total",        "data": "TOTAL" }
                ],
                "columnDefs": [
                    {"className": "dt-right", "targets": [ 2, 3 ]},
                    {"className": "dt-center", "targets": [ 0 ]},
                ],
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
                    total = api
                        .column( 3 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    $('#MontoReal').text('C$'+ numeral(total).format('0,0.00'));
                    $('#txtMontoReal').text('Total facturado');

                    $('#MontoMeta').text('');
                    $('#txtMontoMeta').text('');
                }
            });
        break;
      default:
        mensaje("Ups... algo ha salido mal")
    }
    $("#dtVentas_length, #dtRecuperacion_length, #dtCliente_length, #dtTotalXRutaVent_length, #dtArticulo_length").hide();
    $("#dtVentas_filter, #dtRecuperacion_filter, #dtCliente_filter, #dtTotalXRutaVent_filter, #dtArticulo_filter").hide();
}

function getDetalleVenta(mes, anio, metau, realu, metae, reale, ruta, nombre) {
    $('#dtVentas').dataTable({
        responsive: true,
        "autoWidth":false,
        "ajax":{
            "url": "detallesVentasRuta/"+mes+"/"+anio+"/"+ruta,
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
            { "title"   : "Articulo",       "data"  : "ARTICULO" },
            { "title"   : "Descripción",    "data"  : "DESCRIPCION" },
            { "title"   : "Meta Units.",     "data"  : "METAU" },
            { "title"   : "Real Units.",     "data"  : "REALU" },
            { "title"   : "% Cumpl. Units.",  "data"  : "DIFU" },
            { "title"   : "Meta Vtas.",      "data"  : "METAE" },
            { "title"   : "Real Vtas.",      "data"  : "REALE" },
            { "title"   : "% Cumpl. Vtas.",   "data"  : "DIFE" }
        ],
        "columnDefs": [
            {"className": "dt-center", "targets": [ 0 ]},
            {"className": "dt-back-unit", "targets": [ 2, 3, 4 ]},
            {"className": "dt-back-vtas", "targets": [ 5, 6, 7 ]},
            {"width": "20%", "targets": [ 1]},
        ],
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\ U,C$]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
            totalRealU = api
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
             totalMetaU = api
                .column( 2 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
            }, 0 );
            totalDifU = (totalMetaU==0) ? "0.00%" : ((parseFloat(realu.replace(/[\ U,C$]/g, ''))/parseFloat(metau.replace(/[\ U,C$]/g, '')))*100);


             totalRealE = api
                .column( 6 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
            }, 0 );
             totalMetaE = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
            }, 0 );
            totalDifE = (totalMetaE==0) ? "0.00%" : ((parseFloat(reale.replace(/[\ U,C$]/g, ''))/parseFloat(metae.replace(/[\ U,C$]/g, '')))*100);

            $('#vendedorNombre').text(nombre);
            $('#total_Real_Unidad').text(numeral(realu.replace(/[\ U,C$]/g, '')).format('0,0.00')+" U");
            $('#total_Meta_Unidad').text(numeral(metau.replace(/[\ U,C$]/g, '')).format('0,0.00')+" U");
            $('#total_Dif_Unidad').text(numeral(totalDifU).format('0,0.00')+'%');
            $('#total_Real_Efectivo').text('C$'+numeral(reale.replace(/[\ U,C$]/g, '')).format('0,0.00'));
            $('#total_Meta_Efectivo').text('C$'+numeral(metae.replace(/[\ U,C$]/g, '')).format('0,0.00'));
            $('#total_Dif_Efectivo').text(numeral(totalDifE).format('0,0.00')+'%');
        }
    });
    $("#dtVentas_length").hide();
    $("#dtVentas_filter").hide();
    $('#mdDetailsVentas').modal('show');
}

function detalleComparacionVentas(obj, tp) {
    var dif         = 0;
    var porcen01    = 0;
    var porcen02    = 0;
    switch(tp) {
        case 'vts':
            title = `Reporte YTD Montos C$`;
            mes_actual      = obj[0]['name'];
            anio_pasado     = obj[1]['name'];
            mes_pasado      = obj[2]['name'];

            m_actual        = parseFloat(obj[0]['data']);
            m_anio_pasado   = parseFloat(obj[1]['data']);
            m_mes_pasado    = parseFloat(obj[2]['data']);            

            if (m_anio_pasado>0) {
                dif = (m_actual-m_anio_pasado);
                porcen01 = (dif/m_anio_pasado)*100;
            }

            if (m_mes_pasado>0) {
                dif = (m_actual-m_mes_pasado);
                porcen02 = (dif/m_mes_pasado)*100;
            }

            st_1 = (porcen01<0)?` <i class="material-icons text-danger font-weight-bold" style="font-size:15px">arrow_downward</i>`:` <i class="material-icons text-success font-weight-bold" style="font-size:15px">arrow_upward</i>`;

            cls_1 = (porcen01<0)?`text-danger font-weight-bolder`:`text-success font-weight-bolder`;
            cls_2 = (porcen02<0)?`text-danger font-weight-bolder`:`text-success font-weight-bolder`;

            text_monto_actual       = 'C$'+numeral(obj[0]['data']).format('0,0.00')+st_1;            
            text_monto_anio_pasado  = 'C$'+numeral(obj[1]['data']).format('0,0.00');
            text_monto_mes_pasado   = 'C$'+numeral(obj[2]['data']).format('0,0.00');
        break;
        case 'its':
            title = `Reporte YTD (Total de Items)`;
            mes_actual      = obj[0]['name'];
            anio_pasado     = obj[1]['name'];
            mes_pasado      = obj[2]['name'];


            m_actual        = parseFloat(obj[0]['data']);
            m_anio_pasado   = parseFloat(obj[1]['data']);
            m_mes_pasado    = parseFloat(obj[2]['data']);            

            if (m_anio_pasado>0) {
                dif = (m_actual-m_anio_pasado);
                porcen01 = (dif/m_anio_pasado)*100;
            }

            if (m_mes_pasado>0) {
                dif = (m_actual-m_mes_pasado);
                porcen02 = (dif/m_mes_pasado)*100;
            }

           st_1 = (porcen01<0)?` <i class="material-icons text-danger font-weight-bold" style="font-size:15px">arrow_downward</i>`:` <i class="material-icons text-success font-weight-bold" style="font-size:15px">arrow_upward</i>`;

            cls_1 = (porcen01<0)?`text-danger font-weight-bolder`:`text-success font-weight-bolder`;
            cls_2 = (porcen02<0)?`text-danger font-weight-bolder`:`text-success font-weight-bolder`;

            text_monto_actual       = numeral(obj[0]['data']).format('0')+st_1;            
            text_monto_anio_pasado  = numeral(obj[1]['data']).format('0');
            text_monto_mes_pasado   = numeral(obj[2]['data']).format('0');
        break;
        default:
        alert('Ups... parece que ocurrio un error :(');
    }
    $('#text-mes-actual').text(mes_actual);
    $('#val-mes-actual').html(text_monto_actual);

    $('#text-anio-pasado').text(anio_pasado);
    $('#val-anio-pasado').text(text_monto_anio_pasado);

    $('#text-mes-pasado').text(mes_pasado);
    $('#val-mes-pasado').text(text_monto_mes_pasado);

    $('#dif-porcen-vts')
    .attr('class', cls_1)
    .text(numeral(porcen01).format('0.0')+'%');
    $('#dif-porcen-its')
    .attr('class', cls_2)
    .text(numeral(porcen02).format('0.0')+'%');

    $('#titleModal-01').text(title)
    $('#mdDetails').modal('show')
}

$('#filterDtTemp').on( 'keyup', function () {
    var table = $(tableActive).DataTable();
    table.search(this.value).draw();
});

$( "#cantRowsDtTemp").change(function() {
    var table = $(tableActive).DataTable();
    table.page.len(this.value).draw();
});
$('#filterDtDetalle').on( 'keyup', function () {
    var table = $('#dtVentas').DataTable();
    table.search(this.value).draw();
});

$( "#cantRowsDtDetalle").change(function() {
    var table = $('#dtVentas').DataTable();
    table.page.len(this.value).draw();
});

$(".active-page-details").click( function() {
    $("#cantRowsDtTemp").val("5");
    $("#page-details").toggleClass('active');    
});

/*OCULTANDO GRAFICAS DASHBOARD*/
$(document).on('change', '.dash-opc', function(e) {
    val01 = $(this).val();

    if( $(this).prop('checked') ) {
        $.cookie( $(this).val() , 'yes_visible');
        $('div.'+val01).parent().show();
        $.removeCookie($(this).val());
    }else {
        $.cookie( $(this).val() , 'not_visible');
        $('div.'+val01).parent().hide();
    }
    location.reload();
});

function reordenandoPantalla() {
    var x = 0;
    $(".content-graf div.row").each(function(e) {
        var div01 = $(this).attr('id');
        $("#" + div01 + " div.graf").each(function() {
            ($(this).is(":visible"))?x++:x=x;            
        })
        cont = 12 / x;
        $( "#" + div01 + " div.graf" ).removeClass( "col-sm-*" ).addClass( "col-sm-"+cont );
        x=0;
    });
} 

function FormatPretty(number) {
    var numberString;
    var scale = '';
    if( isNaN( number ) || !isFinite( number ) ) {
        numberString = 'N/A';
    } else {
        var negative = number < 0;
        number = negative? -number : number;

        if( number < 1000 ) {
            scale = '';
        } else if( number < 1000000 ) {
            scale = 'K';
            number = number/1000;
        } else if( number < 1000000000 ) {
            scale = 'M';
            number = number/1000000;
        } else if( number < 1000000000000 ) {
            scale = 'B';
            number = number/1000000000;
        } else if( number < 1000000000000000 ) {
            scale = 'T';
            number = number/1000000000000;
        }
        var maxDecimals = 0;
        if( number < 10 && scale != '' ) {
            maxDecimals = 1;
        }
        number = negative ? -number : number;
        numberString = number.toFixed( maxDecimals );
        numberString += scale
    }
    return numberString;
}

</script>