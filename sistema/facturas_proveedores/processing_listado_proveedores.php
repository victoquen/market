<?php

include("../js/fechas.php");
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

/* Array of database columns which should be read and sent back to DataTables */
$aColumns = array('id_proveedor', 'empresa', 'ci_ruc', 'autorizacion', 'fecha_caducidad');

/* Indexed column (used for fast and accurate table cardinality) */
$sIndexColumn = "id_proveedor";

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
        $sOrder .= $aColumns[intval($_GET['iSortCol_' . $i])] . "
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
    for ($i = 0; $i < count($aColumns); $i++) {
        $sWhere .= $aColumns[$i] . " LIKE '%" . mysql_real_escape_string($_GET['sSearch']) . "%' OR ";
    }

    $sWhere = substr_replace($sWhere, ")", -3);
}


/*
 * SQL queries
 * Get data to display
 */
$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $aColumns) . "
		FROM   proveedor WHERE (borrado = 0)
                $sWhere
		$sOrder
		$sLimit
	";
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
		FROM   proveedor
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

    $code_aux = $aRow["id_proveedor"];
    $nombre_aux = $aRow["empresa"];
    $ciruc_aux = $aRow["ci_ruc"];
    $autorizacion_aux = $aRow["autorizacion"];
    $fecha_caducidad = implota($aRow["fecha_caducidad"]);

    $sOutput .= '"' . str_replace('"', '\"', "<a href='#' style='font-size: 9px; text-decoration: none' onClick='pon_prefijo($code_aux,&#39;$nombre_aux&#39;,&#39;$ciruc_aux&#39;,&#39;$autorizacion_aux&#39;,&#39;$fecha_caducidad&#39;)'>" . $aRow["empresa"] . "</a>") . '",';
    $sOutput .= '"' . str_replace('"', '\"', "<a href='#' style='font-size: 9px; text-decoration: none' onClick='pon_prefijo($code_aux,&#39;$nombre_aux&#39;,&#39;$ciruc_aux&#39;,&#39;$autorizacion_aux&#39;,&#39;$fecha_caducidad&#39;)'>" . $aRow["ci_ruc"] . "</a>") . '",';


    /*
     * Optional Configuration:
     * If you need to add any extra columns (add/edit/delete etc) to the table, that aren't in the
     * database - you can do it here
     */


    $sOutput .= '"' . str_replace('"', '\"', "<a href='#'><img src='../img/seleccionar.gif' border='0' width='16' height='16' border='1' title='Seleccionar' onClick='pon_prefijo($code_aux,&#39;$nombre_aux&#39;,&#39;$ciruc_aux&#39;,&#39;$autorizacion_aux&#39;,&#39;$fecha_caducidad&#39;)' onMouseOver='style.cursor=cursor'></a>") . '",';


    $sOutput = substr_replace($sOutput, "", -1);
    $sOutput .= "],";
}
$sOutput = substr_replace($sOutput, "", -1);
$sOutput .= '] }';

echo $sOutput;
?>