<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

/* Array of database columns which should be read and sent back to DataTables */
$aColumns = array('id_producto', 'codigo', 'nombre', 'stock', 'stock_consignacion', 'costo', 'iva', 'pvp','pvp2','pvp3','pvp4');
$aColumns_aux = array('nombre', 'stock', 'costo','codigo_barra');
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


/*
 * SQL queries
 * Get data to display
 */
$sQuery = "
		SELECT id_producto, codigo, nombre, stock, stock_consignacion, costo, iva, pvp, codigo_barra, pvp2,pvp3,pvp4
        FROM (
                SELECT a.id_producto AS id_producto, a.codigo AS codigo, a.nombre AS nombre, a.stock AS stock, a.stock_consignacion AS stock_consignacion, a.costo AS costo, a.iva AS iva, a.pvp AS pvp, a.pvp2 AS pvp2, a.pvp3 AS pvp3, a.pvp4 AS pvp4, GROUP_CONCAT( b.codigo ) AS codigo_barra
                FROM producto a
                LEFT JOIN producto_barracodigo b ON a.id_producto = b.id_producto
                WHERE (
                a.borrado =0
                )
                AND (
                a.gasto =0
                )
                GROUP BY a.id_producto
        )r
		
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
		FROM   producto
                WHERE (borrado = 0) AND (gasto=0) 
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

    $query = "SELECT SUM(stock) as stock FROM productobodega WHERE id_producto ='" . $id_aux . "'";
    $result = mysql_query($query, $conn);
    $stock_aux = mysql_result($result, 0, "stock");

    $consignacion = $aRow["stock_consignacion"];

    $costo_aux = $aRow["costo"];
    $iva_aux = $aRow["iva"];
    $pvp_aux = $aRow["pvp"];
    $pvp2 = $aRow["pvp2"];
    $pvp3 = $aRow["pvp3"];
    $pvp4 = $aRow["pvp4"];

    $codigo_barras = $aRow["codigo_barra"];

    $sOutput .= '"' . str_replace('"', '\"', "<a href='#' style='font-size: 11px; text-decoration: none' onClick='pon_prefijo(&#39;$codigo_aux&#39;,&#39;$nombre_aux&#39;,$id_aux,&#39;$iva_aux&#39;,&#39;$pvp_aux&#39;,&#39;$pvp2&#39;,&#39;$pvp3&#39;,&#39;$pvp4&#39;,&#39;$costo_aux&#39;)'>" . $aRow["codigo_barra"] . "</a>") . '",';
    $sOutput .= '"' . str_replace('"', '\"', "<a href='#' style='font-size: 11px; text-decoration: none' onClick='pon_prefijo(&#39;$codigo_aux&#39;,&#39;$nombre_aux&#39;,$id_aux,&#39;$iva_aux&#39;,&#39;$pvp_aux&#39;,&#39;$pvp2&#39;,&#39;$pvp3&#39;,&#39;$pvp4&#39;,&#39;$costo_aux&#39;)'>" . $aRow["nombre"] . "</a>") . '",';
    $sOutput .= '"' . str_replace('"', '\"', "<a href='#' style='font-size: 11px; text-decoration: none' onClick='pon_prefijo(&#39;$codigo_aux&#39;,&#39;$nombre_aux&#39;,$id_aux,&#39;$iva_aux&#39;,&#39;$pvp_aux&#39;,&#39;$pvp2&#39;,&#39;$pvp3&#39;,&#39;$pvp4&#39;,&#39;$costo_aux&#39;)'>" . $stock_aux . "</a>") . '",';

    $sOutput .= '"' . str_replace('"', '\"', "<a href='#' style='font-size: 11px; text-decoration: none' onClick='pon_prefijo(&#39;$codigo_aux&#39;,&#39;$nombre_aux&#39;,$id_aux,&#39;$iva_aux&#39;,&#39;$pvp_aux&#39;,&#39;$pvp2&#39;,&#39;$pvp3&#39;,&#39;$pvp4&#39;,&#39;$costo_aux&#39;)'>" . $aRow["costo"] . "</a>") . '",';


    $sOutput .= '"' . str_replace('"', '\"', "<a href='#'><img src='../img/seleccionar.gif' border='0' width='16' height='16' border='1' title='Modificar' onClick='pon_prefijo(&#39;$codigo_aux&#39;,&#39;$nombre_aux&#39;,$id_aux,&#39;$iva_aux&#39;,&#39;$pvp_aux&#39;,&#39;$pvp2&#39;,&#39;$pvp3&#39;,&#39;$pvp4&#39;,&#39;$costo_aux&#39;)' onMouseOver='style.cursor=cursor'></a>") . '",';


    $sOutput = substr_replace($sOutput, "", -1);
    $sOutput .= "],";
}
$sOutput = substr_replace($sOutput, "", -1);
$sOutput .= '] }';

echo $sOutput;
?>