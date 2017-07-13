<?php

include ("../js/fechas.php");


error_reporting(0);

$fechainicio = $_REQUEST["fecha_inicio"];
$fechafin = $_REQUEST["fecha_fin"];
$tipoCliente = $_REQUEST["tipoCliente"];




/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

/* Array of database columns which should be read and sent back to DataTables */
$aColumns = array('id_cliente', 'nombre', 'numero_factura', 'totalfactura', 'retiva', 'retfuente');
$aColumnsOrd = array( 'nombre', 'numero_factura', 'totalfactura', 'retiva', 'retfuente');
$aColumnsAux = array( 'cl.nombre');

/* Indexed column (used for fast and accurate table cardinality) */
$sIndexColumn = "id_cliente";

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
        $sOrder .= $aColumnsOrd[intval($_GET['iSortCol_' . $i])] . "
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
		SELECT SQL_CALC_FOUND_ROWS  f.id_cliente as id_cliente, cl.nombre as nombre, COUNT(f.codigo_factura) as numero_factura,  SUM(f.totalfactura) as totalfactura, SUM(f.ret_iva) as retiva, SUM(f.ret_fuente) as retfuente
		FROM   facturas f INNER JOIN cliente cl ON f.id_cliente=cl.id_cliente
                WHERE (f.anulado = 0) AND (f.fecha BETWEEN '$fechainicio' AND '$fechafin') AND (cl.codigo_tipocliente='$tipoCliente') 
                
                $sWhere  
                    
                GROUP BY (f.id_cliente)
                
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
		SELECT COUNT(f.id_cliente)
		FROM   facturas f 
                WHERE (f.anulado = 0) 
                
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
        if ($aColumns[$i] == "id_cliente") {
            $code_aux = $aRow[$aColumns[$i]];
        } else {
            
                $sOutput .= '"' . str_replace('"', '\"', $aRow[$aColumns[$i]]) . '",';
                   
        }
    }

    /*
     * Optional Configuration:
     * If you need to add any extra columns (add/edit/delete etc) to the table, that aren't in the
     * database - you can do it here
     */    

    $sOutput = substr_replace($sOutput, "", -1);
    $sOutput .= "],";
}
$sOutput = substr_replace($sOutput, "", -1);
$sOutput .= '] }';

echo $sOutput;
?>