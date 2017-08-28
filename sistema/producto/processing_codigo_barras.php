<?php


error_reporting(0);

$id = $_REQUEST["idproducto"];

//get datos SESSION
session_start();
$tipo = $_SESSION['tipo'];


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

/* Array of database columns which should be read and sent back to DataTables */
$aColumns = array('id', 'codigo');
$aColumns_Aux = array('id', 'codigo');
//$aColumns_Aux=array('b.id_bodega','o.nombre','b.stock');


/* Indexed column (used for fast and accurate table cardinality) */
$sIndexColumn = "id";

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
        $sOrder .= $aColumns_Aux[intval($_GET['iSortCol_' . $i])] . "
			 	" . mysql_real_escape_string($_GET['sSortDir_' . $i]) . ", ";
    }
    $sOrder = substr_replace($sOrder, "", -2);

    if ($sOrder == "ORDER BY") {
        $sOrder = "";
    }
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
    for ($i = 0; $i < count($aColumns_Aux); $i++) {
        $sWhere .= $aColumns_Aux[$i] . " LIKE '%" . mysql_real_escape_string($_GET['sSearch']) . "%' OR ";
    }

    $sWhere = substr_replace($sWhere, ")", -3);
}


/* Individual column filtering */
for ($i = 0; $i < count($aColumns_Aux); $i++) {
    if (isset($_GET['bSearchable_' . $i]) && $_GET['bSearchable_' . $i] == "true" && $_GET['sSearch_' . $i] != '') {
        if ($sWhere == "") {
            $sWhere = " AND ";
        } else {
            $sWhere .= " AND ";
        }
        $sWhere .= $aColumns_Aux[$i] . " LIKE '%" . mysql_real_escape_string($_GET['sSearch_' . $i]) . "%' ";
    }
}


/*
 * SQL queries
 * Get data to display
 */
$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS id, codigo
		FROM producto_barracodigo 
        WHERE (id_producto = $id)AND(borrado = 0)
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
		FROM producto_barracodigo 
        WHERE (id_producto = $id)AND(borrado = 0)
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
        if ($aColumns[$i] == "id") {
            $sOutput .= '"'.str_replace('"', '\"', $aRow[ $aColumns[$i] ]).'",';
            $id_aux = $aRow[$aColumns[$i]];
        } else {

            $sOutput .= '"' . str_replace('"', '\"', $aRow[$aColumns[$i]]) . '",';

        }


    }

    /*
 * Optional Configuration:
 * If you need to add any extra columns (add/edit/delete etc) to the table, that aren't in the
 * database - you can do it here
 */


    if ($tipo == "administrador") {
        $sOutput .= '"' . str_replace('"', '\"', "<a href='#'><img src='../img/modificar.png' border='0' width='16' height='16' border='1' title='Modificar' onClick='modificar_codigo(" . $id_aux . ")' onMouseOver='style.cursor=cursor'></a>") . '",';
        $sOutput .= '"' . str_replace('"', '\"', "<a href='#'><img src='../img/eliminar.png' border='0' width='16' height='16' border='1' title='Modificar' onClick='eliminar_codigo(" . $id_aux . ")' onMouseOver='style.cursor=cursor'></a>") . '",';
    } else {
        $sOutput .= '"' . str_replace('"', '\"', " ") . '",';
        $sOutput .= '"' . str_replace('"', '\"', " ") . '",';
    }


    $sOutput = substr_replace($sOutput, "", -1);
    $sOutput .= "],";
}
$sOutput = substr_replace($sOutput, "", -1);
$sOutput .= '] }';

echo $sOutput;
?>