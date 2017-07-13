<?php

include ("../js/fechas.php");


error_reporting(0);

$id_cliente = $_REQUEST["id_cliente"];





/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

/* Array of database columns which should be read and sent back to DataTables */
$aColumns = array('id_factura', 'fecha', 'lugar', 'nombre', 'codigo_factura', 'fecha_vencimiento', 'totalfactura', 'retiva', 'retfuente');
$aColumnsAux = array('f.fecha', 'cl.lugar', 'cl.nombre', 'f.codigo_factura', 'DATE_ADD(f.fecha,INTERVAL (f.plazo*30) DAY)', 'f.totalfactura', 'f.ret_iva', 'f.ret_fuente');

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
		SELECT SQL_CALC_FOUND_ROWS f.id_factura as id_factura, f.fecha as fecha, cl.lugar as lugar, cl.nombre as nombre, f.codigo_factura as codigo_factura, DATE_ADD(f.fecha,INTERVAL (f.plazo*30) DAY) as fecha_vencimiento, f.totalfactura as totalfactura, f.ret_iva as retiva, f.ret_fuente as retfuente
		FROM   facturas f INNER JOIN cliente cl ON f.id_cliente=cl.id_cliente
                WHERE (f.anulado = 0) AND  (f.id_cliente=$id_cliente) AND (f.estado=0)
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
		FROM facturas
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

                $sel_cobros = "SELECT sum(importe) as aportaciones FROM cobros WHERE id_factura=$code_aux";
                $rs_cobros = mysql_query($sel_cobros, $conn);

                if ($rs_cobros)
                    $aportaciones = mysql_result($rs_cobros, 0, "aportaciones");
                else
                    $aportaciones = 0;

                
            }
            else {

                if ($aColumns[$i] == "retiva") {

                    $retiva_aux = $aRow[$aColumns[$i]];
                    $sOutput .= '"' . str_replace('"', '\"', $aRow[$aColumns[$i]]) . '",';
                } else {

                    if ($aColumns[$i] == "retfuente") {

                        $retfuente_aux = $aRow[$aColumns[$i]];
                        $sOutput .= '"' . str_replace('"', '\"', $aRow[$aColumns[$i]]) . '",';

                        $pendiente = $total_aux - $aportaciones - $retiva_aux - $retfuente_aux;
                        $sOutput .= '"' . str_replace('"', '\"', $pendiente) . '",';
                    } else {
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

    $sOutput .= '"' . str_replace('"', '\"', "<a href='#'><img src='../img/dinero.jpg' border='0' width='16' height='16' border='1' title='Cobrar' onClick='ver_cobros(" . $code_aux . ")' onMouseOver='style.cursor=cursor'></a>") . '",';

    $sOutput = substr_replace($sOutput, "", -1);
    $sOutput .= "],";
}
$sOutput = substr_replace($sOutput, "", -1);
$sOutput .= '] }';

echo $sOutput;
?>