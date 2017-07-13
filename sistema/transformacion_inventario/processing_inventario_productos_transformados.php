<?php
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */

	/* Array of database columns which should be read and sent back to DataTables */
	$aColumns = array('id_producto', 'codigo', 'nombre', 'stock','consignacion', 'costo', 'pvp',  'proveedor','grupo','subgrupo','composicion','aplicacion' );
        $aColumns_Aux=array('a.codigo', 'a.nombre', 'a.stock','a.stock_consignacion', 'a.costo', 'a.pvp', 'a.proveedor','g.nombre','s.nombre','a.composicion','a.aplicacion');



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
			$sOrder .= $aColumns_Aux[ intval( $_GET['iSortCol_'.$i] ) ]."
			 	".mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", ";
		}
		$sOrder = substr_replace( $sOrder, "", -2 );

                if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "";
		}
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
		for ( $i=0 ; $i<count($aColumns_Aux) ; $i++ )
		{
			$sWhere .= $aColumns_Aux[$i]." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
		}

		$sWhere = substr_replace( $sWhere, ")", -3 );
	}


         /* Individual column filtering */
	for ( $i=0 ; $i<count($aColumns_Aux) ; $i++ )
	{
		if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
		{
			if ( $sWhere == "" )
			{
				$sWhere = " AND ";
			}
			else
			{
				$sWhere .= " AND ";
			}
			$sWhere .= $aColumns_Aux[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
		}
	}


	/*
	 * SQL queries
	 * Get data to display
	 */        
	$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS a.id_producto as id_producto, a.codigo as codigo, a.nombre as nombre, a.stock as stock,
                                           a.stock_consignacion as consignacion,
                                           a.costo as costo, a.pvp as pvp, a.proveedor as proveedor, g.nombre as grupo, s.nombre as subgrupo,
                                           a.composicion as composicion, a.aplicacion as aplicacion
		FROM   producto a INNER JOIN grupo g ON a.grupo=g.id_grupo INNER JOIN subgrupo s ON a.subgrupo=s.id_subgrupo
                WHERE (a.borrado = 0) AND (transformacion=1) 
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
                WHERE (borrado = 0) AND (transformacion=1)
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
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] == "id_producto" )
			{
                           $code_aux= $aRow[ $aColumns[$i] ];
                           //$sOutput .= '"'.str_replace('"', '\"', "<a href='#' style='text-decoration: none; font-size: 9px' onClick='ver_producto(".$code_aux.")'>".$aRow[ $aColumns[$i]]."</a>").'",';
				/* Special output formatting for 'version' */
				//$sOutput .= ($aRow[ $aColumns[$i] ]=="id_producto") ?
					//'"-",' :
					//'"'.str_replace('"', '\"', $aRow[ $aColumns[$i] ]).'",';
			}
			else
			{
				
				if($aColumns[$i]=="stock"){
							
					$idp = $aRow["id_producto"];
					
					
					$query="SELECT SUM(stock) as stock FROM productobodega WHERE id_producto ='".$idp."'";
					$result = mysql_query($query, $conn);
					$res = mysql_result($result,0,"stock");

					$sOutput .= '"'.str_replace('"', '\"', $res).'",';
					
					
				}else{
                                
					/* General output */
					$sOutput .= '"'.str_replace('"', '\"', "<a href='#' style='text-decoration: none; font-size: 9px' onClick='ver_producto(".$code_aux.")'>".$aRow[ $aColumns[$i]]."</a>").'",';
				}
			}
		}

		/*
		 * Optional Configuration:
		 * If you need to add any extra columns (add/edit/delete etc) to the table, that aren't in the
		 * database - you can do it here
		 */
 
//                $sOutput .= '"'.str_replace('"', '\"', "<a href='#'><img src='../img/modificar.png' border='0' width='16' height='16' border='1' title='Modificar' onClick='modificar_producto(".$code_aux.")' onMouseOver='style.cursor=cursor'></a>").'",';
//                $sOutput .= '"'.str_replace('"', '\"', "<a href='#'><img src='../img/ver.png' border='0' width='16' height='16' border='1' title='ver' onClick='ver_producto(".$code_aux.")' onMouseOver='style.cursor=cursor'></a>").'",';
//                $sOutput .= '"'.str_replace('"', '\"', "<a href='#'><img src='../img/eliminar.png' border='0' width='16' height='16' border='1' title='Eliminar' onClick='eliminar_producto(".$code_aux.")' onMouseOver='style.cursor=cursor'></a>").'",';

                
		$sOutput = substr_replace( $sOutput, "", -1 );
		$sOutput .= "],";
	}
	$sOutput = substr_replace( $sOutput, "", -1 );
	$sOutput .= '] }';

	echo $sOutput;
?>