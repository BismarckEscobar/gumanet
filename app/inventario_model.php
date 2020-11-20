<?php
namespace App;
use App\User;
use App\Company;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Style_Alignment;
use PHPExcel_Style;
use PHPExcel_Style_Border;
use Illuminate\Database\Eloquent\Model;

class inventario_model extends Model {
    
    public static function getArticulos() {        
        $sql_server = new \sql_server();        
        $request = Request();
        $sql_exec = '';
        $company_user = Company::where('id',$request->session()->get('company_id'))->first()->id;
        
        switch ($company_user) {
            case '1':
                $sql_exec = "SELECT * FROM iweb_articulos";
                break;
            case '2':
                $sql_exec = "SELECT * FROM gp_iweb_articulos";
                break;
            case '3':
                return false;
                break;
            case '4':
                $sql_exec = "SELECT * FROM inn_iweb_articulos";
                break; 
            default:                
                dd("Ups... al parecer sucedio un error al tratar de encontrar articulos para esta empresa. ". $company->id);
                break;
        }

        $query = array();
        $i=0;

        $query1 = $sql_server->fetchArray( $sql_exec ,SQLSRV_FETCH_ASSOC);
        foreach ($query1 as $key) {
            $desc_art = str_replace("'", " ", $key['DESCRIPCION']);

	    	$query[$i]['ARTICULO'] 			= '<a href="#!" onclick="getDetalleArticulo('."'".$key['ARTICULO']."'".', '."'".$desc_art."'".')" >'.$key['ARTICULO'].'</a>';
            $query[$i]['ARTICULO_']         = $key['ARTICULO'];
	    	$query[$i]['CLASE_TERAPEUTICA'] = $key['CLASE_TERAPEUTICA'];
	    	$query[$i]['DESCRIPCION'] 		= $key['DESCRIPCION'];
	    	$query[$i]['total'] 			= number_format($key['total'], 2);            
	    	$query[$i]['LABORATORIO'] 		= $key['LABORATORIO'];
	    	$query[$i]['UNIDAD_ALMACEN'] 	= $key['UNIDAD_ALMACEN'];
	    	$query[$i]['006'] 				= $key['006'];
	    	$query[$i]['005'] 				= $key['005'];
	    	$query[$i]['PUNTOS'] 			= $key['PUNTOS'];
	    	$query[$i]['PRECIO_FARMACIA'] 	= $key['PRECIO_FARMACIA'];
	    	$i++;
        }
        $sql_server->close();        

        return $query;
    }

    public static function getInventarioTotalizado() {
        $sql_server = new \sql_server();        
        $request = Request();
        $sql_exec = '';
        $company_user = Company::where('id',$request->session()->get('company_id'))->first()->id;
        
        switch ($company_user) {
            case '1':
                $sql_exec = "SELECT * FROM TOTAL_INVENTARIO";
                break;
            case '2':
                return false;
                break;
            case '3':
                return false;
                break;
            case '4':
                return false;
                break; 
            default:                
                dd("Ups... al parecer sucedio un error al tratar de encontrar articulos para esta empresa. ". $company->id);
                break;
        }

        $query = array();
        $i=0;

        $query1 = $sql_server->fetchArray( $sql_exec ,SQLSRV_FETCH_ASSOC);
        foreach ($query1 as $key) {
            $query[$i]['ARTICULO']        = $key['ARTICULO'];            
            $query[$i]['DESCRIPCION']     = $key['DESCRIPCION'];
            $query[$i]['LABORATORIO']     = $key['LABORATORIO'];
            $query[$i]['UNIDAD_MEDIDA']   = $key['UNIDAD_MEDIDA'];
            $query[$i]['B_UMK']           = number_format($key['Bodega_Unimark'], 2);
            $query[$i]['B_INV']           = number_format($key['Bodega_Innova'], 2);
            $i++;
        }
        $sql_server->close();        

        return $query;
    }

    public static function descargarInventario($tipo, $valor) {
        $objPHPExcel = new PHPExcel();
        $tituloReporte = "";
        $titulosColumnas = array();

        $estiloTituloReporte = array(
            'font' => array(
            'name'      => 'Tahoma',
            'bold'      => true,
            'italic'    => false,
            'strike'    => false,
            'size'      => 14,
            'color'     => array(
                            'rgb' => '212121')
            ),
            'alignment' =>  array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation'   => 0,
                            'wrap'       => TRUE,
                            )
        );

        $estiloTituloColumnas = array(
            'font' => array(
                        'name'  => 'Arial',
                        'bold'  => true
            ),
            'alignment' =>  array(
                                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                'wrap'          => TRUE
                            ),
            'borders' => array(
                            'top' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                        ),
            'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN,
                            )
            )
        );
                
        $estiloInformacion = new PHPExcel_Style();
        $estiloInformacion->applyFromArray(
            array(
                'borders' => array(
                'top' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                        ),
                'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN,
                                ),
                )
            )
        );

        $right = array(
            'alignment' =>  array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'wrap' => TRUE
            )
        );

        $left = array(
            'alignment' =>  array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'wrap' => TRUE
            )
        );

        switch ($tipo) {
            case 'inventario':
                $temp = inventario_model::getArticulos();
                
                $tituloReporte = "INVENTARIO DE ARTICULOS ACTUALIZADOS HASTA ".date('d/m/Y');
                $titulosColumnas = array('ARTICULO', 'DESCRIPCION', 'EXISTENCIA', 'LABORATORIO', 'UNIDAD', 'PUNTOS');

                $objPHPExcel->setActiveSheetIndex(0)
                        ->mergeCells('A1:F1');

                $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1',$tituloReporte)
                ->setCellValue('A3',  $titulosColumnas[0])
                ->setCellValue('B3',  $titulosColumnas[1])
                ->setCellValue('C3',  $titulosColumnas[2])
                ->setCellValue('D3',  $titulosColumnas[3])
                ->setCellValue('E3',  $titulosColumnas[4])
                ->setCellValue('F3',  $titulosColumnas[5]);
                
                $i=4;

                foreach ($temp as $key) {
                    $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$i,  $key['ARTICULO_'])
                    ->setCellValue('B'.$i,  $key['DESCRIPCION'])
                    ->setCellValue('C'.$i,  $key['total'])
                    ->setCellValue('D'.$i,  $key['LABORATORIO'])
                    ->setCellValue('E'.$i,  $key['UNIDAD_ALMACEN'])
                    ->setCellValue('F'.$i,  $key['PUNTOS']);
                    $i++;
                }

                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(70);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);

                
                $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->applyFromArray($estiloTituloReporte);
                $objPHPExcel->getActiveSheet()->getStyle('A3:F3')->applyFromArray($estiloTituloColumnas);      
                $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:F".($i-1));
                $objPHPExcel->getActiveSheet()->getStyle("C4:F".($i-1))->applyFromArray($right);


                break;
            case 'vencimiento':
                $temp = inventario_model::dataLiquidacionMeses($valor);

                $tituloReporte = ($valor==6)?("VENCIMIENTO A 6 MESES HASTA ".date('d/m/Y')):("VENCIMIENTO A 12 MESES HASTA ".date('d/m/Y'));

                $titulosColumnas = array('ARTICULO', 'DESCRIPCION', 'DIAS', 'DISPONIBLE', 'VENCE', 'LOTE');

                $objPHPExcel->setActiveSheetIndex(0)
                        ->mergeCells('A1:F1');

                $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1',$tituloReporte)
                ->setCellValue('A3',  $titulosColumnas[0])
                ->setCellValue('B3',  $titulosColumnas[1])
                ->setCellValue('C3',  $titulosColumnas[2])
                ->setCellValue('D3',  $titulosColumnas[3])
                ->setCellValue('E3',  $titulosColumnas[4])
                ->setCellValue('F3',  $titulosColumnas[5]);
                
                $i=4;

                foreach ($temp as $key) {
                    $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$i,  $key['ARTICULO'])
                    ->setCellValue('B'.$i,  $key['DESCRIPCION'])
                    ->setCellValue('C'.$i,  $key['DIAS_VENCIMIENTO'])
                    ->setCellValue('D'.$i,  $key['CANT_DISPONIBLE'])
                    ->setCellValue('E'.$i,  $key['F_VENCIMIENTO'])
                    ->setCellValue('F'.$i,  $key['LOTE']);
                    $i++;
                }

                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(70);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);

                $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->applyFromArray($estiloTituloReporte);
                $objPHPExcel->getActiveSheet()->getStyle('A3:F3')->applyFromArray($estiloTituloColumnas);
                $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:F".($i-1));
                $objPHPExcel->getActiveSheet()->getStyle("C4:F".($i-1))->applyFromArray($right);

            break;
            default:
                dd("Ups... al parecer sucedio un error al tratar de encontrar articulos para esta empresa. ". $company->id);
            break;
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Inventario actualizado hasta '.date('d/m/Y').'.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }

    public static function dataLiquidacionMeses($valor) {
        $sql_server = new \sql_server();
        
        $request = Request();
        $sql_exec = '';
        $company_user = Company::where('id',$request->session()->get('company_id'))->first()->id;
        
        switch ($company_user) {
            case '1':
                $sql_exec = "EXECUTE FCHA_VENCIMIENTO_LOTE ".$valor;
                break;
            case '2':
                return false;
                break;
            case '3':
                return false;
                break;
            case '4':
                return false;
                break; 
            default:                
                dd("Ups... al parecer sucedio un error al tratar de encontrar articulos para esta empresa. ". $company->id);
                break;
        }

        $query = array();
        $i=0;

        $query1 = $sql_server->fetchArray( $sql_exec ,SQLSRV_FETCH_ASSOC);
        foreach ($query1 as $key) {
            $query[$i]['ARTICULO']          = $key['ARTICULO'];
            $query[$i]['DESCRIPCION']       = $key['DESCRIPCION'];
            $query[$i]['DIAS_VENCIMIENTO']  = $key['DIAS_VENCIMIENTO'];
            $query[$i]['CANT_DISPONIBLE']   = number_format($key['CANT_DISPONIBLE'],2).' - [ '.$key['UNIDAD_VENTA'].' ]';
            $query[$i]['F_VENCIMIENTO']     = date('d/m/Y', strtotime($key['FECHA_VENCIMIENTO']) );
            $query[$i]['LOTE']              = $key['LOTE'];
            $i++;
        }
        $sql_server->close();

        return $query;
    }

    public static function getBodegaInventario($articulo) {
        
        $sql_server     = new \sql_server();
        
        $sql_exec       = '';
        $request        = Request();
        $company_user   = Company::where('id',$request->session()->get('company_id'))->first()->id;

        switch ($company_user) {
            case '1':
                $sql_exec = 'SELECT * FROM iweb_bodegas WHERE ARTICULO = '."'".$articulo."'".'';
                break;
            case '2':
                $sql_exec = 'SELECT * FROM gp_iweb_bodegas WHERE ARTICULO = '."'".$articulo."'".'';
                break;
            case '3':
                return false;
                break;
            case '4':
                $sql_exec = 'SELECT * FROM INN_iweb_bodegas WHERE ARTICULO = '."'".$articulo."'".'';
                break;
            default:                
                dd("Ups... al parecer sucedio un error al tratar de encontrar articulos para esta empresa. ". $company->id);
                break;
        }
        $query = $sql_server->fetchArray($sql_exec, SQLSRV_FETCH_ASSOC);

        $i = 0;
        $json = array();
        foreach ($query as $fila) {
            $json[$i]["id"]                 = $i;
            $json[$i]["DETALLE"]            = '<a id="exp_more" class="exp_more" href="#!"><i class="material-icons expan_more">expand_more</i></a>';
            $json[$i]["BODEGA"]             = $fila["BODEGA"];
            $json[$i]["NOMBRE"]             = $fila["NOMBRE"];
            $json[$i]["CANT_DISPONIBLE"]    = number_format($fila["CANT_DISPONIBLE"],2);
            $i++;
        }
        $sql_server->close();
        return $json;
    }

    public static function getPreciosArticulos($articulo) {
        
        $sql_server     = new \sql_server();
        $sql_exec       = '';
        $request        = Request();
        $company_user   = Company::where('id',$request->session()->get('company_id'))->first()->id;
        switch ($company_user) {
            case '1':
                $sql_exec = 'EXEC sp_iweb_precios '."'".$articulo."'".' ';
                break;
            case '2':
                $sql_exec = 'EXEC sp_gp_iweb_precios '."'".$articulo."'".' ';
                break;
            case '3':
                return false;
                break;
            case '4':
                $sql_exec = 'EXEC sp_inn_iweb_precios '."'".$articulo."'".' ';
                break;   
            default:                
                dd("Ups... al parecer sucedio un error al tratar de encontrar articulos para esta empresa. ". $company->id);
                break;
        }        

        $i = 0;
        $json = array();
        $query = $sql_server->fetchArray($sql_exec, SQLSRV_FETCH_ASSOC);

        foreach ($query as $fila) {
            $json[$i]["NIVEL_PRECIO"] = $fila["NIVEL_PRECIO"];
            $json[$i]["PRECIO"] = ($fila["PRECIO"]=="") ? "N/D" : number_format($fila["PRECIO"],2);
            $i++;
        }

        $sql_server->close();
        return $json;
    }

    public static function getArtBonificados($articulo) {
        
        $sql_server = new \sql_server();
        
        $sql_exec = '';
        $request = Request();
        $company_user = Company::where('id',$request->session()->get('company_id'))->first()->id;
        
        switch ($company_user) {
            case '1':
                $sql_exec = 'SELECT REGLAS FROM GMV_mstr_articulos WHERE ARTICULO = '."'".$articulo."'".' ';
                break;
            case '2':
                $sql_exec = 'SELECT REGLAS FROM GP_GMV_mstr_articulos WHERE ARTICULO = '."'".$articulo."'".' ';
                break;
            case '3':
                return false;
                break;
            case '4':
                $sql_exec = 'SELECT REGLAS FROM INN_GMV_mstr_articulos WHERE ARTICULO = '."'".$articulo."'".' ';
                break;
            default:                
                dd("Ups... al parecer sucedio un error al tratar de encontrar articulos para esta empresa. ". $company->id);
                break;
        }

        $query = $sql_server->fetchArray($sql_exec, SQLSRV_FETCH_ASSOC);
        $i = 0;
        $json = array();       
        foreach ($query as $fila) {
            $porciones = explode(",", $fila["REGLAS"]);
            for($n=0;$n<count($porciones);$n++){
                $Position_elementos = substr($porciones[$n], 0, strpos ($porciones[$n] , "+" ));
                $json[$i]["ORDEN"] = $Position_elementos;
                $json[$i]["REGLAS"] = $porciones[$n];
                $i++;
            }           
        }
        $sql_server->close();
        return $json;
    }

    public static function transaccionesDetalle($f1, $f2, $art, $tp) {
        $sql_server = new \sql_server();
        
        $f1_ = date('Y-m-d', strtotime($f1));
        $f2_ = date('Y-m-d', strtotime($f2));

        $sql_exec = '';
        $request = Request();
        $company_user = Company::where('id',$request->session()->get('company_id'))->first()->id;

        switch ($company_user) {
            case '1':
                $sql_exec = 'SELECT * FROM iweb_transacciones WHERE ARTICULO = '."'".$art."'".' AND DESCRTIPO = '."'".$tp."'".' AND FECHA  BETWEEN '."'".$f1."'".' AND '."'".$f2."'".'  ORDER BY ARTICULO ASC';
                break;
            case '2':
                $sql_exec = 'SELECT * FROM GP_iweb_transacciones WHERE ARTICULO = '."'".$art."'".' AND DESCRTIPO = '."'".$tp."'".' AND FECHA  BETWEEN '."'".$f1."'".' AND '."'".$f2."'".'  ORDER BY ARTICULO ASC';
                break;
            case '3':
                return false;
                break;
            case '4':
                $sql_exec = 'SELECT * FROM inn_iweb_transacciones WHERE ARTICULO = '."'".$art."'".' AND DESCRTIPO = '."'".$tp."'".' AND FECHA  BETWEEN '."'".$f1."'".' AND '."'".$f2."'".'  ORDER BY ARTICULO ASC';
                break;
            default:                
                dd("Ups... al parecer sucedio un error al tratar de encontrar articulos para esta empresa. ". $company->id);
                break;
        }

        $query = $sql_server->fetchArray($sql_exec, SQLSRV_FETCH_ASSOC);
        $i=0;
        $json = array();
        foreach($query as $fila){
            $json[$i]["FECHA"] = date_format($fila["FECHA"],"d/m/Y");
            $json[$i]["LOTE"] = $fila["LOTE"];
            $json[$i]["DESCRTIPO"] = $fila["DESCRTIPO"];
            $json[$i]["CANTIDAD"] = number_format($fila["CANTIDAD"],2);
            $json[$i]["REFERENCIA"] = $fila["REFERENCIA"];
            $i++;
        }

        $sql_server->close();
        return $json;
    }

    public static function getLotesArticulo($bodega, $articulo) {
        
        $sql_server = new \sql_server();
        
        $sql_exec = '';
        $request = Request();
        $company_user = Company::where('id',$request->session()->get('company_id'))->first()->id;

        switch ($company_user) {
            case '1':
                $sql_exec = 'SELECT * FROM iweb_lotes WHERE BODEGA = '."'".$bodega."'".' AND ARTICULO = '."'".$articulo."'".' ';
                break;
            case '2':
                $sql_exec = 'SELECT * FROM gp_iweb_lotes WHERE BODEGA = '."'".$bodega."'".' AND ARTICULO = '."'".$articulo."'".' ';
                break;
            case '3':
                return false;
                break;
            case '4':
                $sql_exec = 'SELECT * FROM inn_iweb_lotes WHERE BODEGA = '."'".$bodega."'".' AND ARTICULO = '."'".$articulo."'".' ';
                break;
            default:                
                dd("Ups... al parecer sucedio un error al tratar de encontrar articulos para esta empresa. ". $company->id);
                break;
        }

        $query = $sql_server->fetchArray($sql_exec, SQLSRV_FETCH_ASSOC);
        $i = 0;
        $json = array();
        foreach ($query as $fila) {
            $json[$i]["ARTICULO"] = $fila["ARTICULO"];
            $json[$i]["BODEGA"] = $fila["BODEGA"];
            $json[$i]["CANT_DISPONIBLE"] = number_format($fila["CANT_DISPONIBLE"], 2);
            $json[$i]["LOTE"] = $fila["LOTE"];
            $json[$i]["FECHA_INGRESO"] = date('d/m/Y',strtotime($fila["FECHA_ENTR"]));
            $json[$i]["CANTIDAD_INGRESADA"] = number_format($fila["CANTIDAD_INGRESADA"], 2);
            $json[$i]["FECHA_ENTRADA"] = date('d/m/Y',strtotime($fila["FECHA_ENTRADA"]));
            $json[$i]["FECHA_VENCIMIENTO"] = date('d/m/Y',strtotime($fila["FECHA_VENCIMIENTO"]));
            $i++;
        }
        $sql_server->close();
        return $json;
    }
}