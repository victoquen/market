<?php

include ("../js/fechas.php");


error_reporting(0);

$fechainicio=$_REQUEST["fecha_inicio"];
$fechafin=$_REQUEST["fecha_fin"];

$idproducto = $_REQUEST["idproducto"];





/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */

	/* Array of database columns which should be read and sent back to DataTables */
	$aColumns = array('fecha', 'tipo', 'movimiento', 'cantidad', 'valor', 'subtotal');
        //$aColumnsAux=array('a.codigo_factura', 'b.nombre', 'a.totalfactura', 'a.fecha','a.estado');
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "fecha";

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
		SELECT t.fecha,t.tipo, t.movimiento, t.cantidad, t.valor, t.subtotal
                FROM(
                        SELECT a.fecha as fecha,'venta' as tipo, CONCAT(a.serie1,'-',a.serie2,'-',a.codigo_factura) as movimiento, b.cantidad as cantidad, b.precio as valor, b.subtotal as subtotal
                        FROM facturas a INNER JOIN factulinea b ON a.id_factura=b.id_factura  
                        WHERE (a.anulado = 0) AND (a.fecha BETWEEN '$fechainicio' AND '$fechafin') AND (b.id_producto = '$idproducto')

                        UNION 

                        SELECT a.fecha as fecha, 'compra' as tipo, CONCAT(a.serie1,'-',a.serie2,'-',a.codigo_factura) as movimiento, b.cantidad as cantidad, b.costo as valor, b.subtotal as subtotal
                        FROM facturasp a INNER JOIN factulineap b ON a.id_facturap=b.id_facturap  
                        WHERE (a.anulado = 0) AND (a.fecha BETWEEN '$fechainicio' AND '$fechafin') AND (b.id_producto = '$idproducto')) t
                ORDER BY t.fecha 
                
            $sLimit
	";
	//$rResult = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
        $rResult = mysql_query( $sQuery, $conn ) or die(mysql_error());
        
        $rResultaux = mysql_query( $sQuery, $conn ) or die(mysql_error());
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
		SELECT COUNT(t.fecha)
                FROM(
                        SELECT a.fecha as fecha,'venta' as tipo, CONCAT(a.serie1,'-',a.serie2,'-',a.codigo_factura) as movimiento, b.cantidad as cantidad, b.precio as valor, b.subtotal as subtotal
                        FROM facturas a INNER JOIN factulinea b ON a.id_factura=b.id_factura  
                        WHERE (a.anulado = 0) AND (a.fecha BETWEEN '$fechainicio' AND '$fechafin') AND (b.id_producto = '$idproducto')

                        UNION 

                        SELECT a.fecha as fecha, 'compra' as tipo, CONCAT(a.serie1,'-',a.serie2,'-',a.codigo_factura) as movimiento, b.cantidad as cantidad, b.costo as valor, b.subtotal as subtotal
                        FROM facturasp a INNER JOIN factulineap b ON a.id_facturap=b.id_facturap  
                        WHERE (a.anulado = 0) AND (a.fecha BETWEEN '$fechainicio' AND '$fechafin') AND (b.id_producto = '$idproducto')) t
                ORDER BY t.fecha
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
        
        $cant=0;
        $total=0;
        $band = 0;
        while ( $aRowaux = mysql_fetch_array( $rResultaux ) )
        {
            if($aRowaux["tipo"] == "compra"){
                $cant = $cant + $aRowaux["cantidad"];                
                
            }  else {
                 $cant = $cant - $aRowaux["cantidad"];                 
                 if($band == 0){
                    $val_ini = $aRowaux["valor"];
                    $band =1;
                }
            }                                        
        }
        
        $query_stock = "SELECT stock FROM producto WHERE id_producto = $idproducto";
        $res_st = mysql_query($query_stock);
        $stock = mysql_result($res_st,0,"stock");

        $cant_ini = 0;
        $total_ini = 0;
        if($stock > $cant){
            $cant_ini = $stock - $cant;
            $total_ini = $cant_ini * $val_ini;
            
            
            $sOutput .= "[";
            
            
            $sOutput .= '"'.str_replace('"', '\"', "---").'",';
            $sOutput .= '"'.str_replace('"', '\"', "Stock Inicial").'",';
            
            $sOutput .= '"'.str_replace('"', '\"', $cant_ini).'",';
            $sOutput .= '"'.str_replace('"', '\"', $val_ini).'",';
            $sOutput .= '"'.str_replace('"', '\"', number_format((float)round($total_ini,2), 2, '.', '')).'",';
            
            $sOutput .= '"'.str_replace('"', '\"', "---").'",';
            $sOutput .= '"'.str_replace('"', '\"', "---").'",';
            $sOutput .= '"'.str_replace('"', '\"', "---").'",';
            
            $sOutput .= '"'.str_replace('"', '\"', $cant_ini).'",';
            $sOutput .= '"'.str_replace('"', '\"', $val_ini).'",';
            $sOutput .= '"'.str_replace('"', '\"', number_format((float)round($total_ini,2), 2, '.', '')).'",';
            
            $sOutput = substr_replace( $sOutput, "", -1 );
            $sOutput .= "],";
        }
        
        
        $cant=$cant_ini;
        $total=$total_ini;
        
	while ( $aRow = mysql_fetch_array( $rResult ) )
	{
                //$tipocv=$aRow["tipodocumento"];
                
		$sOutput .= "[";
                
                $sOutput .= '"'.str_replace('"', '\"', $aRow["fecha"]).'",';
                $sOutput .= '"'.str_replace('"', '\"', $aRow["tipo" ]."Fact No: ". $aRow["movimiento" ]).'",';
                
                if($aRow["tipo"] == "compra"){
                
                    $sOutput .= '"'.str_replace('"', '\"', $aRow["cantidad"]).'",';
                    $sOutput .= '"'.str_replace('"', '\"', $aRow["valor"]).'",';
                    $sOutput .= '"'.str_replace('"', '\"', $aRow["subtotal"]).'",';

                    $sOutput .= '"'.str_replace('"', '\"', "---").'",';
                    $sOutput .= '"'.str_replace('"', '\"', "---").'",';
                    $sOutput .= '"'.str_replace('"', '\"', "---").'",';
                    
                    $cant = $cant + $aRow["cantidad"];
                    $total = $total + $aRow["subtotal"];
                    $prom = $total/$cant;
                    
                }  else {
                    $sOutput .= '"'.str_replace('"', '\"', "---").'",';
                    $sOutput .= '"'.str_replace('"', '\"', "---").'",';
                    $sOutput .= '"'.str_replace('"', '\"', "---").'",';
                    
                    $sOutput .= '"'.str_replace('"', '\"', $aRow["cantidad"]).'",';
                    $sOutput .= '"'.str_replace('"', '\"', $aRow["valor"]).'",';
                    $sOutput .= '"'.str_replace('"', '\"', $aRow["subtotal"]).'",';
                    
                    $cant = $cant - $aRow["cantidad"];
                    $total = $total - $aRow["subtotal"];
                    $prom = $total/$cant;
                }
                
                $sOutput .= '"'.str_replace('"', '\"', $cant).'",';
                $sOutput .= '"'.str_replace('"', '\"', $total).'",';
                $sOutput .= '"'.str_replace('"', '\"', number_format((float)round($prom,2), 2, '.', '')).'",';
                
		

		/*
		 * Optional Configuration:
		 * If you need to add any extra columns (add/edit/delete etc) to the table, that aren't in the
		 * database - you can do it here
		 */
                


		$sOutput = substr_replace( $sOutput, "", -1 );
		$sOutput .= "],";
	}
	$sOutput = substr_replace( $sOutput, "", -1 );
	$sOutput .= '] }';

	echo $sOutput;
?>