<?php

include ("../js/fechas.php");


error_reporting(0);

$fechainicio = $_REQUEST["fecha_inicio"];
$fechafin = $_REQUEST["fecha_fin"];



/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

/* Array of database columns which should be read and sent back to DataTables */
$aColumns = array('id_factura', 'fecha', 'lugar', 'empresa', 'codigo_factura', 'fecha_vencimiento', 'totalfactura');
$aColumnsAux = array('f.fecha', 'p.lugar', 'p.empresa', 'f.codigo_factura', 'DATE_ADD(f.fecha,INTERVAL (f.plazo*30) DAY)', 'f.totalfactura');

/* Indexed column (used for fast and accurate table cardinality) */
$sIndexColumn = "id_facturap";

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
        $sOrder .= $aColumnsAux[intval($_GET['iSortCol_' . $i])] . "
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
    for ($i = 0; $i < count($aColumnsAux); $i++) {
        $sWhere .= $aColumnsAux[$i] . " LIKE '%" . mysql_real_escape_string($_GET['sSearch']) . "%' OR ";
    }

    $sWhere = substr_replace($sWhere, ")", -3);
}


/*
 * SQL queries
 * Get data to display                                                   
 */
$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS f.id_facturap as id_factura, f.fecha as fecha, p.lugar as lugar, p.empresa as empresa, f.codigo_factura as codigo_factura, DATE_ADD(f.fecha,INTERVAL (f.plazo*30) DAY) as fecha_vencimiento, f.totalfactura as totalfactura
		FROM   facturasp f INNER JOIN proveedor p ON f.id_proveedor=p.id_proveedor
                WHERE (f.anulado = 0) AND (f.fecha BETWEEN '$fechainicio' AND '$fechafin')  AND (f.estado=0)
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
		FROM facturasp
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
    //$tipocv=$aRow["tipodocumento"];

    $sOutput .= "[";
    for ($i = 0; $i < count($aColumns); $i++) {
        if ($aColumns[$i] == "id_factura") {
            $code_aux = $aRow[$aColumns[$i]];
        } else {
            if ($aColumns[$i] == "totalfactura") {
                $total_aux = $aRow[$aColumns[$i]];
                $sOutput .= '"' . str_replace('"', '\"', $aRow[$aColumns[$i]]) . '",';

                $sel_cobros = "SELECT sum(importe) as aportaciones FROM pagos WHERE id_factura=$code_aux";
                $rs_cobros = mysql_query($sel_cobros, $conn);

                if ($rs_cobros){
                    $aportaciones = mysql_result($rs_cobros, 0, "aportaciones");
                } else {
                    $aportaciones = 0;
                }
                
                $query_ret = "SELECT SUM(totalretencion) as totalretencion FROM retencion where (anulado = 0) AND id_factura=$code_aux";
                $result_ret = mysql_query($query_ret, $conn);                
                $totalretencion = mysql_result($result_ret, 0, "totalretencion");
                
                 if($totalretencion == null){                                    
                    $totalretencion = 0;
                }
               

                $pendiente = $total_aux - $aportaciones - $totalretencion;
                
                $sOutput .= '"' . str_replace('"', '\"', $totalretencion) . '",';
                $sOutput .= '"' . str_replace('"', '\"', $pendiente) . '",';
            }
            else {
                $sOutput .= '"' . str_replace('"', '\"', $aRow[$aColumns[$i]]) . '",';
            }
        }
    }

    /*
     * Optional Configuration:
     * If you need to add any extra columns (add/edit/delete etc) to the table, that aren't in the
     * database - you can do it here
     */

    //$sOutput .= '"' . str_replace('"', '\"', "<a href='#'><img src='../img/dinero.jpg' border='0' width='16' height='16' border='1' title='Cobrar' onClick='ver_pagos(" . $code_aux . ")' onMouseOver='style.cursor=cursor'></a>") . '",';

    $sOutput = substr_replace($sOutput, "", -1);
    $sOutput .= "],";
}
$sOutput = substr_replace($sOutput, "", -1);
$sOutput .= '] }';

echo $sOutput;
?>