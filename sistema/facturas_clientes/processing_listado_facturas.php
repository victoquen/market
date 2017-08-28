<?php
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */

	/* Array of database columns which should be read and sent back to DataTables */
	$aColumns = array('id_factura', 'fecha','id_facturero','codigo_factura', 'nombre', 't_cliente', 'totalfactura', 'credito', 'plazo', 'estado', 'remision'  );
	$aColumnsAux=array( 'a.id_factura','a.fecha','a.id_facturero', 'a.codigo_factura', 'b.nombre', 'c.nombre', 'a.totalfactura', 'a.credito', 'a.plazo','a.estado');

	//$aColumns = array('id_factura', 'fecha','codigo_factura', 'nombre', 't_cliente', 'totalfactura', 'credito', 'plazo', 'estado', 'remision' );
	//$aColumnsAux=array( 'id_factura','a.fecha', 'a.codigo_factura', 'b.nombre', 'c.nombre', 'a.totalfactura', 'a.credito', 'a.plazo','a.estado');
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "id_factura";

	/* Database connection */
        include_once '../conexion/conexion.php';
        $db = new ServidorBaseDatos();
        $conn = $db->getConexion();

		include_once '../usuario/class/usuario.php';
		$usuario = new usuario();
        


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
			$sOrder .= $aColumnsAux[ intval( $_GET['iSortCol_'.$i] ) ]."
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
		for ( $i=0 ; $i<count($aColumnsAux) ; $i++ )
		{
			$sWhere .= $aColumnsAux[$i]." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
		}

		$sWhere = substr_replace( $sWhere, ")", -3 );
	}


	/*
	 * SQL queries
	 * Get data to display
	 */

	session_start();
	//id facturero segun el usuario de la sesion
	$id_facturero=$_SESSION['id_facturero'];
	$tipo=$_SESSION['tipo'];

/*$sQuery = "
			SELECT SQL_CALC_FOUND_ROWS a.id_factura as id_factura, a.codigo_factura as codigo_factura,
							 b.nombre as nombre, c.nombre as t_cliente,  a.totalfactura as totalfactura, a.fecha as fecha, (if(a.credito=0,'NO','SI'))as credito,
							 (a.plazo*30) as plazo,a.estado as estado, a.remision as remision
			FROM   facturas a INNER JOIN cliente b ON a.id_cliente=b.id_cliente INNER JOIN tipo_cliente c ON b.codigo_tipocliente = c.codigo_tipocliente WHERE (anulado = 0)
					$sWhere
			$sOrder
			$sLimit
		";*/


	if($id_facturero == -1){
		$sQuery = "
			SELECT SQL_CALC_FOUND_ROWS a.id_factura as id_factura, a.codigo_factura as codigo_factura,
							 b.nombre as nombre, c.nombre as t_cliente,  a.totalfactura as totalfactura, a.fecha as fecha, (if(a.credito=0,'NO','SI'))as credito,
							 (a.plazo*30) as plazo,a.estado as estado, a.remision as remision, a.id_facturero as id_facturero
			FROM   facturas a INNER JOIN cliente b ON a.id_cliente=b.id_cliente INNER JOIN tipo_cliente c ON b.codigo_tipocliente = c.codigo_tipocliente WHERE (anulado = 0)
					$sWhere
			$sOrder
			$sLimit
		";
	}else{
		$sQuery = "
			SELECT SQL_CALC_FOUND_ROWS a.id_factura as id_factura, a.codigo_factura as codigo_factura,
							 b.nombre as nombre, c.nombre as t_cliente,  a.totalfactura as totalfactura, a.fecha as fecha, (if(a.credito=0,'NO','SI'))as credito,
							 (a.plazo*30) as plazo,a.estado as estado, a.remision as remision, a.id_facturero as id_facturero
			FROM   facturas a INNER JOIN cliente b ON a.id_cliente=b.id_cliente INNER JOIN tipo_cliente c ON b.codigo_tipocliente = c.codigo_tipocliente WHERE (anulado = 0)AND(a.id_facturero = $id_facturero)
					$sWhere
			$sOrder
			$sLimit
		";
	}


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
		FROM   facturas
                WHERE anulado = 0
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
			if ( $aColumns[$i] == "id_factura" )
			{
                           $code_aux= $aRow[ $aColumns[$i] ]; 
                           $sOutput .= '"'.str_replace('"', '\"', $aRow[ $aColumns[$i] ]).'",';
				/* Special output formatting for 'version' */
				//$sOutput .= ($aRow[ $aColumns[$i] ]=="id_facturaventa") ?
					//'"-",' :
					//'"'.str_replace('"', '\"', $aRow[ $aColumns[$i] ]).'",';
			}
			else
			{
                            if($aColumns[$i] == "estado")
                            {
                                if($aRow[$aColumns[$i]]==0)
                                {
                                    $sOutput .= '"'.str_replace('"', '\"', "<img src='../img/negacion.png' border='0' width='12' height='12'></a> por Cobrar").'",';
                                }
                                else
                                {
                                    $sOutput .= '"'.str_replace('"', '\"', "<img src='../img/aceptacion.png' border='0' width='16' height='16'></a> Cobrada").'",';
                                }
                            }
                            else
                            {

                                if ( $aColumns[$i] == "remision" )
                                {

                                   $remision_aux= $aRow[ $aColumns[$i] ];
                                        /* Special output formatting for 'version' */
                                        //$sOutput .= ($aRow[ $aColumns[$i] ]=="id_facturapventa") ?
                                                //'"-",' :
                                                //'"'.str_replace('"', '\"', $aRow[ $aColumns[$i] ]).'",';
                                }
                                else
                                {

									if ($aColumns[$i] == "id_facturero") {

										$id_factureroaux = $aRow[$aColumns[$i]];


											$rowfacturero = $usuario->get_leyenda_facturero($conn, $id_factureroaux);
											$leyendafacturero = $rowfacturero['leyendafacturero'];


										$sOutput .= '"' . str_replace('"', '\"', $leyendafacturero) . '",';
									} else {
										/* General output */
										$sOutput .= '"' . str_replace('"', '\"', $aRow[$aColumns[$i]]) . '",';
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


                if($remision_aux==1)
                {
                    $query_rem="SELECT COUNT(id_remision) as contador FROM remision where id_factura=$code_aux";
                    $result_rem=mysql_query($query_rem,$conn);
                    $contador=mysql_result($result_rem,0,"contador");
                    if($contador==0)
                    {
                        $sOutput .= '"'.str_replace('"', '\"', "<a href='#'><img src='../img/remision_no.png' border='0' width='30' height='20' border='1' title='ver' onClick='remision(".$code_aux.")' onMouseOver='style.cursor=cursor'></a>").'",';
                    }
                    else
                    {
                        $sOutput .= '"'.str_replace('"', '\"', "<a href='#'><img src='../img/remision_si.png' border='0' width='30' height='20' border='1' title='ver' onClick='remision(".$code_aux.")' onMouseOver='style.cursor=cursor'></a>").'",';
                    }
                }
                else {
                    
                     $sOutput .= '"'.str_replace('"', '\"', "---").'",';
                }


                
                $sOutput .= '"'.str_replace('"', '\"', "<a href='#'><img src='../img/ver.png' border='0' width='16' height='16' border='1' title='ver' onClick='ver_factura(".$code_aux.")' onMouseOver='style.cursor=cursor'></a>").'",';

				if($tipo == "administrador"){
					$sOutput .= '"'.str_replace('"', '\"', "<a href='#'><img src='../img/modificar.png' border='0' width='16' height='16' border='1' title='Modificar' onClick='modificar_factura(".$code_aux.")' onMouseOver='style.cursor=cursor'></a>").'",';
					$sOutput .= '"'.str_replace('"', '\"', "<a href='#'><img src='../img/eliminar.png' border='0' width='16' height='16' border='1' title='Eliminar' onClick='eliminar_factura(".$code_aux.")' onMouseOver='style.cursor=cursor'></a>").'",';
				}else{
					$sOutput .= '"'.str_replace('"', '\"', "").'",';
					$sOutput .= '"'.str_replace('"', '\"', "").'",';
				}



                
		$sOutput = substr_replace( $sOutput, "", -1 );
		$sOutput .= "],";
	}
	$sOutput = substr_replace( $sOutput, "", -1 );
	$sOutput .= '] }';

	echo $sOutput;
?>