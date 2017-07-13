<?php

include ("../js/fechas.php");


error_reporting(0);

$fechainicio=$_REQUEST["fecha_inicio"];
$fechafin=$_REQUEST["fecha_fin"];

$sel_resultado="SELECT librodiario.*,formapago.nombrefp FROM librodiario LEFT JOIN formapago ON librodiario.codformapago=formapago.codformapago WHERE ".$where;						  
$sel_proveedor="SELECT empresa as nombre FROM proveedores WHERE codproveedor='$codproveedor'";
$sel_proveedor="SELECT nombre FROM clientes WHERE codcliente='$codcliente'";



/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */

	/* Array of database columns which should be read and sent back to DataTables */
	$aColumns = array('fecha', 'tipodocumento','id_factura', 'id_cliente',    'nombre','id_banco', 'total' );
        //$aColumnsAux=array('a.codigo_factura', 'b.nombre', 'a.totalfactura', 'a.fecha','a.estado');
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "id_factura";

	/* Database connection */
        include_once '../conexion/conexion.php';
        $usuario = new ServidorBaseDatos();
        $conn = $usuario->getConexion();





	/*
	 * Paging
	 */
	$sLimit = "";
	if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".mysql_real_escape_string( $_GET['iDisplayStart'] ).", ".
			mysql_real_escape_string( $_GET['iDisplayLength'] );
	}


	/*
	 * Ordering
	 */
	if ( isset( $_GET['iSortCol_0'] ) )
	{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
		{
			$sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
			 	".mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", ";
		}
		$sOrder = substr_replace( $sOrder, "", -2 );
	}


	/*
	 * Filtering
	 * NOTE this does not match the built-in DataTables filtering which does it
	 * word by word on any field. It's possible to do here, but concerned about efficiency
	 * on very large tables, and MySQL's regex functionality is very limited
	 */
	$sWhere = "";
	if ( $_GET['sSearch'] != "" )
	{
		$sWhere = "AND( ";
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
		}

		$sWhere = substr_replace( $sWhere, ")", -3 );
	}


	/*
	 * SQL queries
	 * Get data to display
	 */
	$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS a.id_factura as id_factura, a.id_cliente as id_cliente, a.tipodocumento as tipodocumento, a.fecha as fecha,b.nombre as nombre,  a.id_banco as id_banco, a.total as total
                FROM librodiario a LEFT JOIN formapago b ON a.id_formapago=b.id_formapago
                WHERE (a.fecha BETWEEN '$fechainicio' AND '$fechafin')
                $sWhere
		$sOrder
		$sLimit
	";
	//$rResult = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
        $rResult = mysql_query( $sQuery, $conn ) or die(mysql_error());
	/* Data set length after filtering */
	$sQuery = "
		SELECT FOUND_ROWS()
	";
	//$rResultFilterTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
        $rResultFilterTotal = mysql_query( $sQuery, $conn ) or die(mysql_error());
	$aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
	$iFilteredTotal = $aResultFilterTotal[0];

	/* Total data set length */
	$sQuery = "
		SELECT COUNT(".$sIndexColumn.")
		FROM librodiario a LEFT JOIN formapago b ON a.id_formapago=b.id_formapago
                WHERE (a.fecha BETWEEN '$fechainicio' AND '$fechafin')
	";
	//$rResultTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
        $rResultTotal = mysql_query( $sQuery, $conn ) or die(mysql_error());
	$aResultTotal = mysql_fetch_array($rResultTotal);
	$iTotal = $aResultTotal[0];


	/*
	 * Output
	 */
	$sOutput = '{';
	$sOutput .= '"sEcho": '.intval($_GET['sEcho']).', ';
	$sOutput .= '"iTotalRecords": '.$iTotal.', ';
	$sOutput .= '"iTotalDisplayRecords": '.$iFilteredTotal.', ';
	$sOutput .= '"aaData": [ ';
	while ( $aRow = mysql_fetch_array( $rResult ) )
	{
                $tipocv=$aRow["tipodocumento"];
                
		$sOutput .= "[";
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
                        

                        if ( $aColumns[$i] == "id_factura" )
			{
                            $cuenta="----";
                             $aux=$aRow[$aColumns[$i]];
                            if($tipocv==2)
                            {
                                $sQuery_venta="SELECT codigo_factura FROM facturas WHERE id_factura=$aux";
                                $rResultcod=(mysql_query($sQuery_venta, $conn));
                                $codigofact=mysql_result($rResultcod,0,"codigo_factura");
                                
                                
                            }
                            else
                            {
                                
                                $sQuery_venta="SELECT codigo_factura FROM facturasp WHERE id_facturap=$aux";
                                $rResultcod=(mysql_query($sQuery_venta, $conn));
                                $codigofact=mysql_result($rResultcod,0,"codigo_factura");
                                
                                
                               $sQuery_cuenta="SELECT c.gasto as gasto FROM cuenta c INNER JOIN facturasp fp ON c.id_cuenta = fp.cuenta WHERE fp.id_facturap=$aux";
                               $rResult_cuenta=mysql_query($sQuery_cuenta,$conn);
                               $gasto=mysql_result($rResult_cuenta,0,'gasto');
                               
                               if($gasto=="1")
                               {
                                   $cuenta="GASTO";
                               }
                            }

                             $sOutput .= '"'.str_replace('"', '\"', $codigofact).'",';
                           

			}
			else
                        {
                            if ( $aColumns[$i] == "id_cliente" )
                            {
                                 $aux=$aRow[$aColumns[$i]];
                                if($tipocv==2)
                                {
                                    $sQuery_venta="SELECT nombre FROM cliente WHERE id_cliente=$aux";
                                    $rResultcod=(mysql_query($sQuery_venta, $conn));
                                    $nombreaux=mysql_result($rResultcod,0,"nombre");

                                }
                                else
                                {

                                    $sQuery_venta="SELECT empresa FROM proveedor WHERE id_proveedor=$aux";
                                    $rResultcod=(mysql_query($sQuery_venta, $conn));
                                    $nombreaux=mysql_result($rResultcod,0,"empresa");
                                }

                                 $sOutput .= '"'.str_replace('"', '\"', $nombreaux).'",';


                            }
                            else
                            {
                                if ( $aColumns[$i] == "tipodocumento" )
                                {
                                     $aux=$aRow[$aColumns[$i]];
                                    if($tipocv==2)
                                    {                                       
                                        $nombreaux="Venta";
                                    }
                                    else
                                    {
                                        $nombreaux="Compra";
                                    }

                                     $sOutput .= '"'.str_replace('"', '\"', $nombreaux).'",';


                                }
                                else
                                {
                                    if ( $aColumns[$i] == "id_banco" )
                                    {
                                         $aux=$aRow[$aColumns[$i]];
                                        if($aux!=0)
                                        {
                                            $sQuery_venta="SELECT nombre FROM banco WHERE id_banco=$aux";
                                            $rResultcod=(mysql_query($sQuery_venta, $conn));
                                            $nombreaux=mysql_result($rResultcod,0,"nombre");

                                        }
                                        else
                                        {
                                            $nombreaux="---";
                                        }

                                         $sOutput .= '"'.str_replace('"', '\"', $nombreaux).'",';


                                    }
                                    else
                                    {
                                        /* General output */
                                            $sOutput .= '"'.str_replace('"', '\"', $aRow[ $aColumns[$i] ]).'",';
                                    }

                                }

                            }      
                        }
                    }

		/*
		 * Optional Configuration:
		 * If you need to add any extra columns (add/edit/delete etc) to the table, that aren't in the
		 * database - you can do it here
		 */

                //$sOutput .= '"'.str_replace('"', '\"', "<a href='#'><img src='../img/modificar.png' border='0' width='16' height='16' border='1' title='Modificar' onClick='modificar_facturas(".$code_aux.")' onMouseOver='style.cursor=cursor'></a>").'",';
                $sOutput .= '"'.str_replace('"', '\"', $cuenta).'",';


		$sOutput = substr_replace( $sOutput, "", -1 );
		$sOutput .= "],";
	}
	$sOutput = substr_replace( $sOutput, "", -1 );
	$sOutput .= '] }';

	echo $sOutput;
?>