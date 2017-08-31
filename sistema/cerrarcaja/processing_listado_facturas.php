<?php

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

/* Array of database columns which should be read and sent back to DataTables */
$aColumns = array('id_factura', 'leyendafacturero','codigo_factura', 'nombre', 'fecha', 'estado', 'totalfactura', 'retiva', 'retfuente');
$aColumnsAux = array('id_factura','leyendafacturero', 'codigo_factura', 'nombre', 'fecha', 'estado', 'totalfactura', 'retiva', 'retfuente');
//$aColumnsAux = array('a.id_factura','a.codigo_factura', 'b.nombre', 'a.fecha', 'a.estado', 'a.totalfactura', 'a.ret_iva', 'a.ret_fuente');
/* Indexed column (used for fast and accurate table cardinality) */
$sIndexColumn = "id_factura";

/* Database connection */
include_once '../conexion/conexion.php';
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$id_facturero = $_REQUEST["id_facturero"];
$fechainicio = $_REQUEST["fecha_inicio"];
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
    $sWhere = "WHERE( ";
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
		SELECT SQL_CALC_FOUND_ROWS id_factura, leyendafacturero, codigo_factura, nombre, fecha, estado, totalfactura, retiva, retfuente
		FROM(
            SELECT a.id_factura as id_factura, a.codigo_factura as codigo_factura, b.nombre as nombre, a.totalfactura as totalfactura, 
            a.fecha as fecha, a.estado as estado, a.ret_iva as retiva, a.ret_fuente as retfuente, CONCAT( f.serie1,  '-', f.serie2 ) AS leyendafacturero
            FROM   facturas a INNER JOIN cliente b ON a.id_cliente=b.id_cliente 
            INNER JOIN facturero f ON a.id_facturero = f.id_facturero
            WHERE (a.anulado = 0)AND(a.id_facturero = '$id_facturero') AND (a.fecha = '$fechainicio')
		) R
		
                $sWhere
		$sOrder
		$sLimit
	";
/*
$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS a.id_factura as id_factura, a.codigo_factura as codigo_factura, b.nombre as nombre,
		a.totalfactura as totalfactura, a.fecha as fecha, a.estado as estado, a.ret_iva as retiva, a.ret_fuente as retfuente,
		CONCAT( f.serie1,  '-', f.serie2 ) AS leyendafacturero
		FROM   facturas a INNER JOIN cliente b ON a.id_cliente=b.id_cliente
		INNER JOIN facturero f ON a.id_facturero = f.id_facturero
		WHERE (a.anulado = 0)

                $sWhere
		$sOrder
		$sLimit
	";
*/
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
		FROM   facturas
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
        if ($aColumns[$i] == "id_factura") {
            $code_aux = $aRow[$aColumns[$i]];
            $sOutput .= '"' . str_replace('"', '\"', $aRow[$aColumns[$i]]) . '",';
            /* Special output formatting for 'version' */
            //$sOutput .= ($aRow[ $aColumns[$i] ]=="id_facturaventa") ?
            //'"-",' :
            //'"'.str_replace('"', '\"', $aRow[ $aColumns[$i] ]).'",';
        } else {
            if ($aColumns[$i] == "estado") {
                if ($aRow[$aColumns[$i]] == 0) {
                    $sOutput .= '"' . str_replace('"', '\"', "<img src='../img/negacion.png' border='0' width='12' height='12'></a> por Cobrar") . '",';
                } else {
                    $sOutput .= '"' . str_replace('"', '\"', "<img src='../img/aceptacion.png' border='0' width='16' height='16'></a> Cobrada") . '",';
                }
            } else {

                if ($aColumns[$i] == "totalfactura") {
                    $total_aux = $aRow[$aColumns[$i]];
                    $sOutput .= '"' . str_replace('"', '\"', $aRow[$aColumns[$i]]) . '",';

                    $sel_cobros = "SELECT sum(importe) as aportaciones FROM cobros WHERE id_factura=$code_aux";
                    $rs_cobros = mysql_query($sel_cobros, $conn);

                    if ($rs_cobros) {
                        $aportaciones = mysql_result($rs_cobros, 0, "aportaciones");
                    } else {
                        $aportaciones = 0;
                    }
                } else {
                    if ($aColumns[$i] == "retiva") {

                        $retiva_aux = $aRow[$aColumns[$i]];
                        $sOutput .= '"' . str_replace('"', '\"', $aRow[$aColumns[$i]]) . '",';
                    } else {

                        if ($aColumns[$i] == "retfuente") {

                            $retfuente_aux = $aRow[$aColumns[$i]];
                            $sOutput .= '"' . str_replace('"', '\"', $aRow[$aColumns[$i]]) . '",';

                            $pendiente = $total_aux - $aportaciones - $retiva_aux - $retfuente_aux;
                            if(($pendiente > -1) &&($pendiente <0)){
                                $pendiente = $pendiente *(-1);
                            }
                            $pendiente = round($pendiente, 2);
                            
                            $sOutput .= '"' . str_replace('"', '\"', $pendiente) . '",';
                            
                        } else {
                            /* General output */
                            $sOutput .= '"' . str_replace('"', '\"', $aRow[$aColumns[$i]]) . '",';
                        }
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


    $sOutput = substr_replace($sOutput, "", -1);
    $sOutput .= "],";
}
$sOutput = substr_replace($sOutput, "", -1);
$sOutput .= '] }';

echo $sOutput;
?>