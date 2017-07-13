<?php
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */

	/* Array of database columns which should be read and sent back to DataTables */
	$aColumns = array('id_producto', 'codigo', 'nombre', 'stock', 'pvp', 'costo','iva', 'stock_consignacion','transformacion' );
        $aColumns_aux= array( 'nombre', 'stock', 'pvp' );
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "id_producto";

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
			$sOrder .= $aColumns_aux[ intval( $_GET['iSortCol_'.$i] ) ]."
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
		for ( $i=0 ; $i<count($aColumns_aux) ; $i++ )
		{
			$sWhere .= $aColumns_aux[$i]." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
		}

		$sWhere = substr_replace( $sWhere, ")", -3 );
	}


	/*
	 * SQL queries
	 * Get data to display
	 */        
	$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS ".implode(", ", $aColumns)."
		FROM   producto WHERE (borrado = 0)
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
		FROM   producto
                WHERE borrado = 0
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
		$sOutput .= "[";


		/*
		 * Optional Configuration:
		 * If you need to add any extra columns (add/edit/delete etc) to the table, that aren't in the
		 * database - you can do it here
		 */

                 $id_aux= $aRow["id_producto"];
                 $codigo_aux = $aRow["codigo"];
                 $nombre_aux = $aRow["nombre"];
                 $pvp_aux = $aRow["pvp"];
                 $costo_aux = $aRow["costo"];
                 $stock_aux = $aRow["stock"];
                 $iva_aux = $aRow["iva"];
                 $stockconsignacion_aux=$aRow["stock_consignacion"];

                 $transformacion_aux=$aRow["transformacion"];
                 if(($transformacion_aux ==2)&&($iva_aux==1))
                 {
                    $query_tmp="SELECT SUM(p.pvp)as importeiva
                                FROM producto_transformacion pt INNER JOIN producto p ON pt.id_producto = p.id_producto
                                WHERE pt.id_transformacion = $id_aux AND p.iva=1" ;
                    $rs_tmp=mysql_query($query_tmp, $conn);

                    $importe_iva=mysql_result($rs_tmp,0,"importeiva");
                 }
                 else
                 {
                     $importe_iva=0;
                 }

                 

                 //$sOutput .= '"'.str_replace('"', '\"', "<a href='#' style='font-size: 9px; text-decoration: none' onClick='pon_prefijo(&#39;$codigo_aux&#39;,&#39;$nombre_aux&#39;,&#39;$pvp_aux&#39;,&#39;$id_aux&#39;,&#39;$costo_aux&#39;,&#39;$stock_aux&#39,&#39;$iva_aux&#39;)'>". $aRow["codigo"]."</a>" ).'",';
                 $sOutput .= '"'.str_replace('"', '\"', "<a href='#' style='font-size: 11px; text-decoration: none' onClick='pon_prefijo(&#39;$codigo_aux&#39;,&#39;$nombre_aux&#39;,&#39;$pvp_aux&#39;,&#39;$id_aux&#39;,&#39;$costo_aux&#39;,&#39;$stock_aux&#39,&#39;$stockconsignacion_aux&#39,&#39;$iva_aux&#39;,&#39;$transformacion_aux&#39;,&#39;$importe_iva&#39;)'>".$aRow["nombre"]."</a>").'",';
                 $sOutput .= '"'.str_replace('"', '\"', "<a href='#' style='font-size: 11px; text-decoration: none' onClick='pon_prefijo(&#39;$codigo_aux&#39;,&#39;$nombre_aux&#39;,&#39;$pvp_aux&#39;,&#39;$id_aux&#39;,&#39;$costo_aux&#39;,&#39;$stock_aux&#39,&#39;$stockconsignacion_aux&#39,&#39;$iva_aux&#39;,&#39;$transformacion_aux&#39;,&#39;$importe_iva&#39;)'>".$aRow["stock"]."</a>").'",';
                 $sOutput .= '"'.str_replace('"', '\"', "<a href='#' style='font-size: 11px; text-decoration: none' onClick='pon_prefijo(&#39;$codigo_aux&#39;,&#39;$nombre_aux&#39;,&#39;$pvp_aux&#39;,&#39;$id_aux&#39;,&#39;$costo_aux&#39;,&#39;$stock_aux&#39,&#39;$stockconsignacion_aux&#39,&#39;$iva_aux&#39;,&#39;$transformacion_aux&#39;,&#39;$importe_iva&#39;)'>".$aRow["stock_consignacion"]."</a>").'",';
                 $sOutput .= '"'.str_replace('"', '\"', "<a href='#' style='font-size: 11px; text-decoration: none' onClick='pon_prefijo(&#39;$codigo_aux&#39;,&#39;$nombre_aux&#39;,&#39;$pvp_aux&#39;,&#39;$id_aux&#39;,&#39;$costo_aux&#39;,&#39;$stock_aux&#39,&#39;$stockconsignacion_aux&#39,&#39;$iva_aux&#39;,&#39;$transformacion_aux&#39;,&#39;$importe_iva&#39;)'>".$aRow["pvp"]."</a>").'",';
                 //$sOutput .= '"'.str_replace('"', '\"', "<a href='#' style='font-size: 9px; text-decoration: none' onClick='pon_prefijo(&#39;$codigo_aux&#39;,&#39;$nombre_aux&#39;,&#39;$pvp_aux&#39;,&#39;$id_aux&#39;,&#39;$costo_aux&#39;,&#39;$stock_aux&#39,&#39;$iva_aux&#39;)'>".$aRow["fecha_caducidad"]."</a>").'",';

                $sOutput .= '"'.str_replace('"', '\"', "<a href='#'><img src='../img/seleccionar.gif' border='0' width='16' height='16' border='1' title='Modificar' onClick='pon_prefijo(&#39;$codigo_aux&#39;,&#39;$nombre_aux&#39;,&#39;$pvp_aux&#39;,&#39;$id_aux&#39;,&#39;$costo_aux&#39;,&#39;$stock_aux&#39,&#39;$stockconsignacion_aux&#39,&#39;$iva_aux&#39;,&#39;$transformacion_aux&#39;,&#39;$importe_iva&#39;)' onMouseOver='style.cursor=cursor'></a>").'",';

                
		$sOutput = substr_replace( $sOutput, "", -1 );
		$sOutput .= "],";
	}
	$sOutput = substr_replace( $sOutput, "", -1 );
	$sOutput .= '] }';

	echo $sOutput;
?>