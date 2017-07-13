<?php

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */



/* Array of database columns which should be read and sent back to DataTables */
$aColumns = array('id', 'id_empleado', 'id_contrato', 'fecha_inicio', 'fecha_fin', 'codigo', 'sueldo', 'activo');

/* Indexed column (used for fast and accurate table cardinality) */
$sIndexColumn = "id";

/* Database connection */
include_once '../conexion/conexion.php';
$db = new ServidorBaseDatos();
$conn = $db->getConexion();

include_once 'class/Relacion_empleado_contrato.php';
$relacion_empleado_contrato =  new Relacion_empleado_contrato();

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
		FROM   relacion_empleado_contrato WHERE (0 = 0)
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
		FROM   relacion_empleado_contrato
               
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
            $code_aux = $aRow[$aColumns[$i]];
            $sOutput .= '"'.str_replace('"', '\"', $aRow[ $aColumns[$i] ]).'",';
            /* Special output formatting for 'version' */
            //$sOutput .= ($aRow[ $aColumns[$i] ]=="id_relacion_empleado_contrato") ?
            //'"-",' :
            //'"'.str_replace('"', '\"', $aRow[ $aColumns[$i] ]).'",';
        } else {

            if ($aColumns[$i] == "id_empleado") {

                $id_empleado = $aRow[$aColumns[$i]];
                $rowempleado = $relacion_empleado_contrato->get_leyenda_empleado($conn,$id_empleado);
                $leyendaempleado = $rowempleado['leyendaempleado'];
                
                $sOutput .= '"' . str_replace('"', '\"', $leyendaempleado) . '",';
            } else {

                if ($aColumns[$i] == "id_contrato") {

                    $id_contrato = $aRow[$aColumns[$i]];
                    $rowcontrato = $relacion_empleado_contrato->get_leyenda_contrato($conn,$id_contrato);
                    $leyendacontrato = $rowcontrato['leyendacontrato'];

                    $sOutput .= '"' . str_replace('"', '\"', $leyendacontrato) . '",';
                } else {


                    if ($aColumns[$i] == "activo") {

                        $activo = $aRow[$aColumns[$i]];

                        if($activo ==0){
                            $leyendaactivo = "NO";
                        }else{
                            $leyendaactivo = "SI";
                        }

                        $sOutput .= '"' . str_replace('"', '\"', $leyendaactivo) . '",';
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

    $sOutput .= '"' . str_replace('"', '\"', "<a href='#'><img src='../img/modificar.png' border='0' width='16' height='16' border='1' title='Modificar' onClick='modificar(" . $code_aux . ")' onMouseOver='style.cursor=cursor'></a>") . '",';
    $sOutput .= '"' . str_replace('"', '\"', "<a href='#'><img src='../img/ver.png' border='0' width='16' height='16' border='1' title='ver' onClick='ver(" . $code_aux . ")' onMouseOver='style.cursor=cursor'></a>") . '",';
   // $sOutput .= '"' . str_replace('"', '\"', "<a href='#'><img src='../img/eliminar.png' border='0' width='16' height='16' border='1' title='Eliminar' onClick='eliminar(" . $code_aux . ")' onMouseOver='style.cursor=cursor'></a>") . '",';


    $sOutput = substr_replace($sOutput, "", -1);
    $sOutput .= "],";
}
$sOutput = substr_replace($sOutput, "", -1);
$sOutput .= '] }';

echo $sOutput;
?>