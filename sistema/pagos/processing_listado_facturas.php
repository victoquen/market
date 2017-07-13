<?php

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

/* Array of database columns which should be read and sent back to DataTables */
$aColumns = array('id_facturap', 'fecha', 'codigo_factura', 'empresa', 'estado', 'totalfactura', 'retencion');
$aColumnsAux = array('a.fecha', 'a.codigo_factura', 'b.empresa', 'a.estado', 'a.totalfactura');
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
		SELECT SQL_CALC_FOUND_ROWS a.id_facturap as id_facturap, a.codigo_factura as codigo_factura, b.empresa as empresa, a.totalfactura as totalfactura, a.fecha as fecha, a.estado as estado, a.retencion as retencion
		FROM   facturasp a INNER JOIN proveedor b ON a.id_proveedor=b.id_proveedor WHERE (a.anulado = 0)
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
		FROM   facturasp
                WHERE anulado = 0
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
    for ($i = 0; $i < count($aColumns); $i++) {
        if ($aColumns[$i] == "id_facturap") {
            $code_aux = $aRow[$aColumns[$i]];
            /* Special output formatting for 'version' */
            //$sOutput .= ($aRow[ $aColumns[$i] ]=="id_facturaventa") ?
            //'"-",' :
            //'"'.str_replace('"', '\"', $aRow[ $aColumns[$i] ]).'",';
        } else {
            if ($aColumns[$i] == "estado") {
                if ($aRow[$aColumns[$i]] == 0) {
                    $sOutput .= '"' . str_replace('"', '\"', "<img src='../img/negacion.png' border='0' width='12' height='12'></a> por Pagar") . '",';
                } else {
                    $sOutput .= '"' . str_replace('"', '\"', "<img src='../img/aceptacion.png' border='0' width='16' height='16'></a> Pagada") . '",';
                }
            } else {

                if ($aColumns[$i] == "totalfactura") {
                    $total_aux = $aRow[$aColumns[$i]];
                    $sOutput .= '"' . str_replace('"', '\"', $aRow[$aColumns[$i]]) . '",';

                    $sel_pagos = "SELECT sum(importe) as aportaciones FROM pagos WHERE id_factura=$code_aux";
                    $rs_pagos = mysql_query($sel_pagos, $conn);

                    if ($rs_pagos)
                        $aportaciones = mysql_result($rs_pagos, 0, "aportaciones");
                    else
                        $aportaciones = 0;



                    $query_ret = "SELECT SUM(totalretencion) as totalretencion FROM retencion where (anulado = 0) AND id_factura=$code_aux";
                    $result_ret = mysql_query($query_ret, $conn);
                    $totalretencion = mysql_result($result_ret, 0, "totalretencion");
                   

                    $pendiente = $total_aux - $aportaciones - $totalretencion;
                    $pendiente = round($pendiente *100)/100;
                    if($pendiente == -0){
                        $pendiente =0;
                    }
                    
                    $sOutput .= '"' . str_replace('"', '\"', number_format($pendiente, 2, ".", "")) . '",';
                }
                else {


                    if ($aColumns[$i] == "retencion") {

                        $retencion_aux = $aRow[$aColumns[$i]];
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

    //$sOutput .= '"'.str_replace('"', '\"', "<a href='#'><img src='../img/modificar.png' border='0' width='16' height='16' border='1' title='Modificar' onClick='modificar_facturas(".$code_aux.")' onMouseOver='style.cursor=cursor'></a>").'",';

    if ($retencion_aux == 1) {
        $query_ret = "SELECT COUNT(id_retencion) as contador FROM retencion where (anulado = 0) AND id_factura=$code_aux";
        $result_ret = mysql_query($query_ret, $conn);
        $contador = mysql_result($result_ret, 0, "contador");

        if ($contador == 0) {
            $sOutput .= '"' . str_replace('"', '\"', "<a href='#'><img src='../img/botonretencion.gif' border='0' width='16' height='16' border='1' title='ver' onClick='retencion(" . $code_aux . ")' onMouseOver='style.cursor=cursor'></a>") . '",';
        } else {



            $sOutput .= '"' . str_replace('"', '\"', "($".$totalretencion.")" . "<a href='#'><img src='../img/botonretencion_existente.gif' border='0' width='16' height='16' border='1' title='ver' onClick='retencion(" . $code_aux . ")' onMouseOver='style.cursor=cursor'></a>") . '",';
        }
    } else {
        $sOutput .= '"' . str_replace('"', '\"', "---") . '",';
    }

    //$sOutput .= '"'.str_replace('"', '\"', "<a href='#'><img src='../img/botonretencion.gif' border='0' width='16' height='16' border='1' title='ver' onClick='retencion(".$code_aux.")' onMouseOver='style.cursor=cursor'></a>").'",';
    $sOutput .= '"' . str_replace('"', '\"', "<a href='#'><img src='../img/ver.png' border='0' width='16' height='16' border='1' title='ver' onClick='ver_factura(" . $code_aux . ")' onMouseOver='style.cursor=cursor'></a>") . '",';
    $sOutput .= '"' . str_replace('"', '\"', "<a href='#'><img src='../img/dinero.jpg' border='0' width='16' height='16' border='1' title='Cobrar' onClick='ver_pagos(" . $code_aux . ")' onMouseOver='style.cursor=cursor'></a>") . '",';


    $sOutput = substr_replace($sOutput, "", -1);
    $sOutput .= "],";
}
$sOutput = substr_replace($sOutput, "", -1);
$sOutput .= '] }';

echo $sOutput;
?>