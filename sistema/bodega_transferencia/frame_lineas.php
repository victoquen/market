<html>
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8"/>
</head>

<script>
    function eliminar_linea(transferenciatmp, numlinea) {
        if (confirm(" Desea eliminar esta linea ? ")) {
            document.getElementById("frame_datos").src = "eliminar_linea.php?transferenciatmp=" + transferenciatmp + "&numlinea=" + numlinea;
        }
    }
    function modificar_linea(transferenciatmp, numlinea) {

        miPopup = window.open("modificar_linea.php?transferenciatmp=" + transferenciatmp + "&numlinea=" + numlinea, "miwin", "width=600,height=300,scrollbars=yes");
        miPopup.focus();
    }

    //function actualizar(importe,iva,descuento,iva0,iva12)

</script>
<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
<body>
<?php
include("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

error_reporting(0);
$transferenciatmp = $_POST["transferenciatmp"];
$retorno = 0;
//if ($modif<>1) {
if (!isset($transferenciatmp)) {
    $transferenciatmp = $_GET["transferenciatmp"];
    $retorno = 1;
}
if ($retorno == 0) {
    //$codfamilia=$_POST["codfamilia"];
    $idarticulo = $_POST["idarticulo"];
    $cantidad = $_POST["cantidad"];
    $bodegaorigen = $_POST["cbobodegaorigen"];
    $bodegadestino = $_POST["cbobodegadestino"];

    // MANEJO DE SERIES ***********************************************************************************
    $series = $_POST["series"];
    $series_string = "";
    $num_series = sizeof($series);
    $cont = 0;
    while ($cont < $num_series) {
        if ($cont == ($num_series - 1)) {
            $series_string = $series_string . $series[$cont];
        } else {
            $series_string = $series_string . $series[$cont] . "----";
        }
        $cont++;
    }
    //*******************************************************************************************************

    $sel_insert = "INSERT INTO transferencialineatmp (id_transferencia,numlinea,id_bodegaorigen,id_bodegadestino,id_producto,cantidad, series) 
                    VALUES ('$transferenciatmp','','$bodegaorigen','$bodegadestino','$idarticulo','$cantidad','$series_string')";
    $rs_insert = mysql_query($sel_insert, $conn);


}

//}
?>
<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
    <?php
    $sel_lineas = "SELECT b.codigo as codigo, b.nombre as nombre, a.numlinea as numlinea, a.cantidad as cantidad, a.id_bodegaorigen as idbodegaorigen, 
					a.id_bodegadestino as idbodegadestino   
			FROM producto b INNER JOIN  transferencialineatmp a ON b.id_producto = a.id_producto 
			WHERE a.id_transferencia = $transferenciatmp ORDER BY a.numlinea ASC";
    $rs_lineas = mysql_query($sel_lineas, $conn);
    for ($i = 0; $i < mysql_num_rows($rs_lineas); $i++) {
        $numlinea = mysql_result($rs_lineas, $i, "numlinea");
        //$codfamilia=mysql_result($rs_lineas,$i,"codfamilia");

        $codarticulo = mysql_result($rs_lineas, $i, "codigo");
        $descripcion = mysql_result($rs_lineas, $i, "nombre");
        $cantidad = mysql_result($rs_lineas, $i, "cantidad");
        $idbodegaorigen = mysql_result($rs_lineas, $i, "idbodegaorigen");
        $idbodegadestino = mysql_result($rs_lineas, $i, "idbodegadestino");


        $queryb = "SELECT nombre FROM bodega WHERE id_bodega = '$idbodegaorigen'";
        $resb = mysql_query($queryb, $conn);
        $nombodegaorigen = mysql_result($resb, 0, "nombre");

        $queryb = "SELECT nombre FROM bodega WHERE id_bodega = '$idbodegadestino'";
        $resb = mysql_query($queryb, $conn);
        $nombodegadestino = mysql_result($resb, 0, "nombre");


        if ($i % 2) {
            $fondolinea = "itemParTabla";
        } else {
            $fondolinea = "itemImparTabla";
        } ?>
        <tr class="<?php echo $fondolinea ?>">

            <td width="5%"><?php echo $codarticulo ?></td>
            <td width="41%" align="center"><?php echo $descripcion ?></td>
            <td width="5%"><?php echo $cantidad ?></td>
            <td width="22%" align="center"><?php echo $nombodegaorigen ?></td>
            <td width="22%" align="center"><?php echo $nombodegadestino ?></td>
            <td width="3%"><a href="javascript:eliminar_linea(<?php echo $transferenciatmp ?>,<?php echo $numlinea ?>)"><img
                        src="../img/eliminar.png" border="0"></a></td>
            <td width="3%"><a
                    href="javascript:modificar_linea(<?php echo $transferenciatmp ?>,<?php echo $numlinea ?>)"><img
                        src="../img/modificar.png" border="0"></a></td>
        </tr>
    <?php } ?>
</table>
<iframe id="frame_datos" name="frame_datos" width="0%" height="0" frameborder="0">
    <ilayer width="0" height="0" id="frame_datos" name="frame_datos"></ilayer>
</iframe>
</body>
</html>