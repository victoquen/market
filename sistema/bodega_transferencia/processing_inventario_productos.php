<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

/* Array of database columns which should be read and sent back to DataTables */
/*$aColumns = array('id_producto', 'codigo', 'nombre', 'stock','stock_consignacion','costo','iva','pvp' );
    $aColumns_aux= array( 'nombre', 'stock','stock_consignacion', 'costo' );*/
$aColumns = array('id_producto', 'codigo', 'nombre', 'stock', 'pvp', 'costo', 'iva', 'transformacion');
$aColumns_aux = array('p.id_producto', 'p.codigo', 'p.nombre', 'p.stock', 'p.pvp', 'p.costo', 'p.iva', 'p.transformacion');
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
    $sWhere = "AND( ";
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
   /* $sQuery = "
		SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $aColumns_aux) . "
		FROM   producto p  WHERE (p.borrado = 0)AND(p.gasto=0)
                $sWhere
		$sOrder
		$sLimit
	";*/
    $sQuery = "
		SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $aColumns_aux) . "
		FROM   producto p INNER JOIN productobodega pb ON p.id_producto = pb.id_producto   
		WHERE (p.borrado = 0)AND(p.gasto=0)AND(pb.id_bodega = '$id_bodega') 
                $sWhere
		$sOrder
		$sLimit
		";

} else {

    $sQuery = "
		SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $aColumns_aux) . "
		FROM   producto p INNER JOIN productobodega pb ON p.id_producto = pb.id_producto   
		WHERE (p.borrado = 0)AND(p.gasto=0)AND(pb.id_bodega = '$id_bodega') 
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


    $id_aux = $aRow["id_producto"];
    $codigo_aux = $aRow["codigo"];
    $nombre_aux = $aRow["nombre"];

    if ($tipo == "administrador") {
        $query = "SELECT SUM(stock) as stock FROM productobodega WHERE id_producto ='" . $id_aux . "'";
    } else {
        $query = "SELECT stock FROM productobodega WHERE (id_producto ='$id_aux')AND(id_bodega = '$id_bodega')";
    }
    $result = mysql_query($query, $conn);
    $stock_aux = mysql_result($result, 0, "stock");


    $costo_aux = $aRow["costo"];
    $iva_aux = $aRow["iva"];
    $pvp_aux = $aRow["pvp"];


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

    //$sOutput .= '"'.str_replace('"', '\"', "<a href='#' style='font-size: 9px; text-decoration: none' onClick='pon_prefijo(&#39;$codigo_aux&#39;,&#39;$nombre_aux&#39;,&#39;$pvp_aux&#39;,&#39;$id_aux&#39;,&#39;$costo_aux&#39;,&#39;$stock_aux&#39,&#39;$iva_aux&#39;)'>". $aRow["codigo"]."</a>" ).'",';
    $sOutput .= '"' . str_replace('"', '\"', "<a href='#' style='font-size: 11px; text-decoration: none' onClick='pon_prefijo(&#39;$codigo_aux&#39;,&#39;$nombre_aux&#39;,$id_aux,&#39;$iva_aux&#39;,&#39;$pvp_aux&#39;,$series_pass)'>" . $aRow["nombre"] . "</a>") . '",';
    $sOutput .= '"' . str_replace('"', '\"', "<a href='#' style='font-size: 11px; text-decoration: none' onClick='pon_prefijo(&#39;$codigo_aux&#39;,&#39;$nombre_aux&#39;,$id_aux,&#39;$iva_aux&#39;,&#39;$pvp_aux&#39;,$series_pass)'>" . $stock_aux . "</a>") . '",';
    $sOutput .= '"' . str_replace('"', '\"', "<a href='#' style='font-size: 11px; text-decoration: none' onClick='pon_prefijo(&#39;$codigo_aux&#39;,&#39;$nombre_aux&#39;,$id_aux,&#39;$iva_aux&#39;,&#39;$pvp_aux&#39;,$series_pass)'>" . $aRow["costo"] . "</a>") . '",';
    //$sOutput .= '"'.str_replace('"', '\"', "<a href='#' style='font-size: 9px; text-decoration: none' onClick='pon_prefijo(&#39;$codigo_aux&#39;,&#39;$nombre_aux&#39;,&#39;$pvp_aux&#39;,&#39;$id_aux&#39;,&#39;$costo_aux&#39;,&#39;$stock_aux&#39,&#39;$iva_aux&#39;)'>".$aRow["fecha_caducidad"]."</a>").'",';


    $sOutput .= '"' . str_replace('"', '\"', "<a href='#'><img src='../img/seleccionar.gif' border='0' width='16' height='16' border='1' title='Modificar' onClick='pon_prefijo(&#39;$codigo_aux&#39;,&#39;$nombre_aux&#39;,$id_aux,&#39;$iva_aux&#39;,&#39;$pvp_aux&#39;,$series_pass)' onMouseOver='style.cursor=cursor'></a>") . '",';


    $sOutput = substr_replace($sOutput, "", -1);
    $sOutput .= "],";
}
$sOutput = substr_replace($sOutput, "", -1);
$sOutput .= '] }';

echo $sOutput;
?>