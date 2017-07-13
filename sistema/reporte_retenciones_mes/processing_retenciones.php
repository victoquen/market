<?php

include ("../js/fechas.php");


error_reporting(0);

$fechainicio=$_REQUEST["fecha_inicio"];
$fechafin=$_REQUEST["fecha_fin"];





/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */

	/* Array of database columns which should be read and sent back to DataTables */
	$aColumns = array('fecha','ruc','proveedor','facturap','codigo_retencion','codigo_impuesto', 'base_imponible', 'porcentaje_retencion', 'valor_retenido');
        //$aColumnsAux=array('a.codigo_factura', 'b.nombre', 'a.totalfactura', 'a.fecha','a.estado');
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "id_retenlinea";

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
	 * Get data to display                                                   'fecha','ruc','proveedor','facturap','codigo_retencion','codigo_impuesto', 'base_imponible', 'porcentaje_retencion', 'valor_retenido'
	 */
	$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS r.fecha as fecha, p.ci_ruc as ruc, p.empresa as proveedor, f.codigo_factura as facturap, r.codigo_retencion as codigo_retencion,rt.codigo_impuesto as codigo_impuesto, rt.base_imponible as base_imponible, rt.porcentaje_retencion as porcentaje_retencion, rt.valor_retenido as valor_retenido   
		FROM   retenlinea rt INNER JOIN retencion r ON rt.id_retencion=r.id_retencion INNER JOIN facturasp f ON r.id_factura=f.id_facturap INNER JOIN proveedor p ON f.id_proveedor=p.id_proveedor
                WHERE (f.anulado = 0) AND (r.fecha BETWEEN '$fechainicio' AND '$fechafin') 
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
		FROM retenlinea
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
                //$tipocv=$aRow["tipodocumento"];
                
		$sOutput .= "[";
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{                                                                          
                         $sOutput .= '"'.str_replace('"', '\"', $aRow[ $aColumns[$i] ]).'",'; 
                }

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