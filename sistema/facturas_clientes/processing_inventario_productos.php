<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

/* Array of database columns which should be read and sent back to DataTables */
$aColumns = array('p.id_producto', 'p.codigo', 'p.nombre', 'p.stock', 'p.pvp', 'p.costo', 'p.iva', 'p.transformacion','p.pvp2','p.pvp3','p.pvp4');
$aColumns_aux = array('id_producto', 'codigo','nombre', 'stock', 'pvp', 'costo', 'iva', 'transformacion','pvp2','pvp3','pvp4', 'codigo_barra');
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
if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
    $sLimit = "LIMIT " . mysql_real_escape_string($_GET['iDisplayStart']) . ", " .
        mysql_real_escape_string($_GET['iDisplayLength']);
}


/*
 * Ordering
 */
if (isset($_GET['iSortCol_0'])) {
    $sOrder = "ORDER BY  ";
    for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
        $sOrder .= $aColumns_aux[intval($_GET['iSortCol_' . $i])] . "
			 	" . mysql_real_escape_string($_GET['sSortDir_' . $i]) . ", ";
    }
    $sOrder = substr_replace($sOrder, "", -2);
}


/*
 * Filtering
 * NOTE this does not match the built-in DataTables filtering which does it
 * word by word on any field. It's possible to do here, but concerned about efficiency
 * on very large tables, and MySQL's regex functionality is very limited
 */
$sWhere = "";
if ($_GET['sSearch'] != "") {
    $sWhere = "WHERE( ";
    for ($i = 0; $i < count($aColumns_aux); $i++) {
        $sWhere .= $aColumns_aux[$i] . " LIKE '%" . mysql_real_escape_string($_GET['sSearch']) . "%' OR ";
    }

    $sWhere = substr_replace($sWhere, ")", -3);
}


//get datos SESSION
session_start();
$id_bodega = $_SESSION['id_bodega'];
$tipo = $_SESSION['tipo'];


/*
 * SQL queries
 * Get data to display
 */


if ($tipo == "administrador") {
    /*$sQuery = "
    SELECT SQL_CALC_FOUND_ROWS ".implode(", ", $aColumns)."
    FROM   producto  p WHERE (p.borrado = 0)
            $sWhere
    $sOrder
    $sLimit
";*/

    $sQuery = "
		SELECT SQL_CALC_FOUND_ROWS id_producto, codigo, nombre, stock, pvp, costo, iva, transformacion,pvp2,pvp3,pvp4, codigo_barra
        FROM  (
        SELECT p.id_producto as id_producto , p.codigo as codigo, p.nombre as nombre, p.stock as stock, p.pvp as pvp, p.costo as costo, p.iva as iva, p.transformacion as transformacion,p.pvp2 as pvp2,p.pvp3 as pvp3,p.pvp4 as pvp4, GROUP_CONCAT( c.codigo ) AS codigo_barra
                FROM   producto p 
                INNER JOIN productobodega pb ON p.id_producto = pb.id_producto 
                LEFT JOIN producto_barracodigo c ON p.id_producto = c.id_producto  
                WHERE (p.borrado = 0)AND(pb.id_bodega = '$id_bodega') 
                GROUP BY p.id_producto
        ) r
        $sWhere
		$sOrder
		$sLimit
		";
} else {

    $sQuery = "
		SELECT SQL_CALC_FOUND_ROWS id_producto, codigo, nombre, stock, pvp, costo, iva, transformacion,pvp2,pvp3,pvp4, codigo_barra
        FROM  (
        SELECT p.id_producto as id_producto , p.codigo as codigo, p.nombre as nombre, p.stock as stock, p.pvp as pvp, p.costo as costo, p.iva as iva, p.transformacion as transformacion,p.pvp2 as pvp2,p.pvp3 as pvp3,p.pvp4 as pvp4, GROUP_CONCAT( c.codigo ) AS codigo_barra
                FROM   producto p 
                INNER JOIN productobodega pb ON p.id_producto = pb.id_producto 
                LEFT JOIN producto_barracodigo c ON p.id_producto = c.id_producto  
                WHERE (p.borrado = 0)AND(pb.id_bodega = '$id_bodega') 
                GROUP BY p.id_producto
        ) r
        $sWhere
		$sOrder
		$sLimit
		";

}


//$rResult = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
$rResult = mysql_query($sQuery, $conn) or die(mysql_error());
/* Data set length after filtering */
$sQuery = "
		SELECT FOUND_ROWS()
	";
//$rResultFilterTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
$rResultFilterTotal = mysql_query($sQuery, $conn) or die(mysql_error());
$aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
$iFilteredTotal = $aResultFilterTotal[0];

/* Total data set length */
$sQuery = "
		SELECT COUNT(" . $sIndexColumn . ")
		FROM   producto
                WHERE borrado = 0
	";
//$rResultTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
$rResultTotal = mysql_query($sQuery, $conn) or die(mysql_error());
$aResultTotal = mysql_fetch_array($rResultTotal);
$iTotal = $aResultTotal[0];


/*
 * Output
 */
$sOutput = '{';
$sOutput .= '"sEcho": ' . intval($_GET['sEcho']) . ', ';
$sOutput .= '"iTotalRecords": ' . $iTotal . ', ';
$sOutput .= '"iTotalDisplayRecords": ' . $iFilteredTotal . ', ';
$sOutput .= '"aaData": [ ';
while ($aRow = mysql_fetch_array($rResult)) {
    $sOutput .= "[";


    /*
     * Optional Configuration:
     * If you need to add any extra columns (add/edit/delete etc) to the table, that aren't in the
     * database - you can do it here
     */

    $id_aux = $aRow["id_producto"];
    $codigo_aux = $aRow["codigo"];
    $nombre_aux = $aRow["nombre"];
    $pvp_aux = $aRow["pvp"];
    $pvp2 = $aRow["pvp2"];
    $pvp3 = $aRow["pvp3"];
    $pvp4 = $aRow["pvp4"];
    $costo_aux = $aRow["costo"];

    if ($tipo == "administrador") {
        //$query = "SELECT SUM(stock) as stock FROM productobodega WHERE id_producto ='" . $id_aux . "'";
        $query = "SELECT stock FROM productobodega WHERE (id_producto ='$id_aux')AND(id_bodega = '$id_bodega')";
    } else {
        $query = "SELECT stock FROM productobodega WHERE (id_producto ='$id_aux')AND(id_bodega = '$id_bodega')";
    }

    $result = mysql_query($query, $conn);
    $stock_aux = mysql_result($result, 0, "stock");


    $iva_aux = $aRow["iva"];


    $transformacion_aux = $aRow["transformacion"];
    if (($transformacion_aux == 2) && ($iva_aux == 1)) {
        $query_tmp = "SELECT SUM(p.pvp)as importeiva
                                FROM producto_transformacion pt INNER JOIN producto p ON pt.id_producto = p.id_producto
                                WHERE pt.id_transformacion = $id_aux AND p.iva=1";
        $rs_tmp = mysql_query($query_tmp, $conn);

        $importe_iva = mysql_result($rs_tmp, 0, "importeiva");
    } else {
        $importe_iva = 0;
    }


    //$indiceb = 0;
    //$nombreb=0;
    //BODEGAS


    $series = array();
    $querys = "SELECT s.id as id, s.serie as serie
              FROM productobodega p 
              INNER JOIN productoserie s ON p.id_productobodega = s.id_productobodega
              WHERE s.estado ='0' AND s.borrado = '0' AND p.id_producto ='$id_aux' AND p.id_bodega = '$id_bodega'";
    $results = mysql_query($querys, $conn);
    while( $rows = mysql_fetch_assoc($results) ) {
        $series[$rows['id']] = $rows['serie'];
    }
    $series_pass = json_encode($series);


    $sOutput .= '"' . str_replace('"', '\"', "<a href='#' style='font-size: 11px; text-decoration: none' onClick='pon_prefijo(&#39;$codigo_aux&#39;,&#39;$nombre_aux&#39;,&#39;$pvp_aux&#39;,&#39;$id_aux&#39;,&#39;$costo_aux&#39;,&#39;$stock_aux&#39;,&#39;$iva_aux&#39;,&#39;$transformacion_aux&#39;,&#39;$importe_iva&#39;,$series_pass,&#39;$pvp2&#39;,&#39;$pvp3&#39;,&#39;$pvp4&#39;)'>" . $aRow["codigo_barra"] . "</a>") . '",';
    $sOutput .= '"' . str_replace('"', '\"', "<a href='#' style='font-size: 11px; text-decoration: none' onClick='pon_prefijo(&#39;$codigo_aux&#39;,&#39;$nombre_aux&#39;,&#39;$pvp_aux&#39;,&#39;$id_aux&#39;,&#39;$costo_aux&#39;,&#39;$stock_aux&#39;,&#39;$iva_aux&#39;,&#39;$transformacion_aux&#39;,&#39;$importe_iva&#39;,$series_pass,&#39;$pvp2&#39;,&#39;$pvp3&#39;,&#39;$pvp4&#39;)'>" . $aRow["nombre"] . "</a>") . '",';
    $sOutput .= '"' . str_replace('"', '\"', "<a href='#' style='font-size: 11px; text-decoration: none' onClick='pon_prefijo(&#39;$codigo_aux&#39;,&#39;$nombre_aux&#39;,&#39;$pvp_aux&#39;,&#39;$id_aux&#39;,&#39;$costo_aux&#39;,&#39;$stock_aux&#39;,&#39;$iva_aux&#39;,&#39;$transformacion_aux&#39;,&#39;$importe_iva&#39;,$series_pass,&#39;$pvp2&#39;,&#39;$pvp3&#39;,&#39;$pvp4&#39;)'>" . $aRow["stock"] . "</a>") . '",';
    $sOutput .= '"' . str_replace('"', '\"', "<a href='#' style='font-size: 11px; text-decoration: none' onClick='pon_prefijo(&#39;$codigo_aux&#39;,&#39;$nombre_aux&#39;,&#39;$pvp_aux&#39;,&#39;$id_aux&#39;,&#39;$costo_aux&#39;,&#39;$stock_aux&#39;,&#39;$iva_aux&#39;,&#39;$transformacion_aux&#39;,&#39;$importe_iva&#39;,$series_pass,&#39;$pvp2&#39;,&#39;$pvp3&#39;,&#39;$pvp4&#39;)'>" . $aRow["pvp"] . "</a>") . '",';




    if($iFilteredTotal == 1){
        $sOutput .= '"' . str_replace('"', '\"', "<script>pon_prefijo('$codigo_aux','$nombre_aux','$pvp_aux','$id_aux','$costo_aux','$stock_aux','$iva_aux','$transformacion_aux','$importe_iva',$series_pass,'$pvp2','$pvp3','$pvp4')</script>") . '",';
    }else{
        $sOutput .= '"' . str_replace('"', '\"', "<a href='#'><img src='../img/seleccionar.gif' border='0' width='16' height='16' border='1' title='Modificar' onClick='pon_prefijo(&#39;$codigo_aux&#39;,&#39;$nombre_aux&#39;,&#39;$pvp_aux&#39;,&#39;$id_aux&#39;,&#39;$costo_aux&#39;,&#39;$stock_aux&#39;,&#39;$iva_aux&#39;,&#39;$transformacion_aux&#39;,&#39;$importe_iva&#39;,$series_pass,&#39;$pvp2&#39;,&#39;$pvp3&#39;,&#39;$pvp4&#39;)' onMouseOver='style.cursor=cursor'></a>") . '",';
    }



    $sOutput = substr_replace($sOutput, "", -1);
    $sOutput .= "],";
}
$sOutput = substr_replace($sOutput, "", -1);
$sOutput .= '] }';
echo $sOutput;

?>