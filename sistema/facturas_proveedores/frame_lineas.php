<html>
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8"/>
</head>

<script>
    function eliminar_linea(codfacturatmp, numlinea, importe, iva, descuento) {
        if (confirm(" Desea eliminar esta linea ? ")) {
            parent.document.formulario_lineas.baseimponible.value = parseFloat(parent.document.formulario_lineas.baseimponible.value) - parseFloat(importe) - parseFloat(descuento);
            var original = parseFloat(parent.document.formulario_lineas.baseimponible.value);
            var result = Math.round(original * 100) / 100;
            parent.document.formulario_lineas.baseimponible.value = result;
            parent.document.formulario.baseimponible2.value = result;

            parent.document.formulario_lineas.descuentototal.value = parseFloat(parent.document.formulario_lineas.descuentototal.value) - parseFloat(descuento);
            var originaldesc = parseFloat(parent.document.formulario_lineas.descuentototal.value);
            var resultdesc = Math.round(originaldesc * 100) / 100;
            parent.document.formulario_lineas.descuentototal.value = resultdesc;
            parent.document.formulario.descuentototal2.value = resultdesc;

            parent.document.formulario_lineas.importeiva.value = parseFloat(parent.document.formulario_lineas.importeiva.value) - parseFloat(iva);
            var original1 = parseFloat(parent.document.formulario_lineas.importeiva.value);
            var result1 = Math.round(original1 * 100) / 100;
            parent.document.formulario_lineas.importeiva.value = result1;
            parent.document.formulario.importeiva2.value = result1;


            if (iva == 0) {
                parent.document.formulario_lineas.iva0.value = parseFloat(parent.document.formulario_lineas.iva0.value) - parseFloat(importe);
                var originaliva0 = parseFloat(parent.document.formulario_lineas.iva0.value);
                var resultiva0 = Math.round(originaliva0 * 100) / 100;
                parent.document.formulario_lineas.iva0.value = resultiva0;
                parent.document.formulario.iva0final.value = resultiva0;
            }
            else {
                parent.document.formulario_lineas.iva12.value = parseFloat(parent.document.formulario_lineas.iva12.value) - parseFloat(importe);
                var originaliva12 = parseFloat(parent.document.formulario_lineas.iva12.value);
                var resultiva12 = Math.round(originaliva12 * 100) / 100;
                parent.document.formulario_lineas.iva12.value = resultiva12;
                parent.document.formulario.iva12final.value = resultiva12;
            }


            //var original3=parseFloat(result2)
            var originalflete = parseFloat(parent.document.formulario_lineas.flete.value);
            var resultflete = Math.round(originalflete * 100) / 100;
            parent.document.formulario.flete2.value = resultflete;

            var original5 = parseFloat(result) + parseFloat(result1) - parseFloat(resultdesc) + parseFloat(resultflete);
            var result5 = Math.round(original5 * 100) / 100;
            parent.document.formulario_lineas.preciototal.value = result5;
            parent.document.formulario.preciototal2.value = result5;

            document.getElementById("frame_datos").src = "eliminar_linea.php?codfacturatmp=" + codfacturatmp + "&numlinea=" + numlinea;
        }
    }
    function modificar_linea(codfacturatmp, numlinea, importe, iva, descuento, utilidad, idbodega,series) {

        miPopup = window.open("modificar_linea.php?codfacturatmp=" + codfacturatmp + "&numlinea=" + numlinea + "&importe=" + importe + "&iva=" + iva + "&descuento=" + descuento + "&utilidad=" + utilidad + "&idbodega=" + idbodega + "&series=" + series, "miwin", "width=600,height=600,scrollbars=yes");
        miPopup.focus();
    }

    //function actualizar(importe,iva,descuento,iva0,iva12)
    function actualizar(importe, iva, descuento) {

        parent.document.formulario_lineas.descuentototal.value = parseFloat(parent.document.formulario_lineas.descuentototal.value) + parseFloat(descuento);
        var originaldesc = parseFloat(parent.document.formulario_lineas.descuentototal.value);
        var resultdesc = Math.round(originaldesc * 100) / 100;
        parent.document.formulario_lineas.descuentototal.value = resultdesc;
        parent.document.formulario.descuentototal2.value = resultdesc;

        parent.document.formulario_lineas.baseimponible.value = parseFloat(parent.document.formulario_lineas.baseimponible.value) + parseFloat(importe);
        var original = parseFloat(parent.document.formulario_lineas.baseimponible.value);
        var result = Math.round(original * 100) / 100;
        parent.document.formulario_lineas.baseimponible.value = result;
        parent.document.formulario.baseimponible2.value = result;

        parent.document.formulario_lineas.importeiva.value = parseFloat(parent.document.formulario_lineas.importeiva.value) + parseFloat(iva);
        var original1 = parseFloat(parent.document.formulario_lineas.importeiva.value);
        var result1 = Math.round(original1 * 100) / 100;
        parent.document.formulario_lineas.importeiva.value = result1;
        parent.document.formulario.importeiva2.value = result1;

        if (iva == 0) {
            parent.document.formulario_lineas.iva0.value = parseFloat(parent.document.formulario_lineas.iva0.value) + (parseFloat(importe) - parseFloat(descuento));
            var originaliva0 = parseFloat(parent.document.formulario_lineas.iva0.value);
            var resultiva0 = Math.round(originaliva0 * 100) / 100;
            parent.document.formulario_lineas.iva0.value = resultiva0;
            parent.document.formulario.iva0final.value = resultiva0;
        }
        else {
            parent.document.formulario_lineas.iva12.value = parseFloat(parent.document.formulario_lineas.iva12.value) + (parseFloat(importe) - parseFloat(descuento));
            var originaliva12 = parseFloat(parent.document.formulario_lineas.iva12.value);
            var resultiva12 = Math.round(originaliva12 * 100) / 100;
            parent.document.formulario_lineas.iva12.value = resultiva12;
            parent.document.formulario.iva12final.value = resultiva12;
        }


        var originalflete = parseFloat(parent.document.formulario_lineas.flete.value);
        var resultflete = Math.round(originalflete * 100) / 100;
        parent.document.formulario.flete2.value = resultflete;

        var original5 = parseFloat(result) + parseFloat(result1) - parseFloat(resultdesc) + parseFloat(resultflete);
        var result5 = Math.round(original5 * 100) / 100;
        parent.document.formulario_lineas.preciototal.value = result5;
        parent.document.formulario.preciototal2.value = result5;

    }
</script>
<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
<body>
<?php 
include("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

error_reporting(0);
$codfacturatmp = $_POST["codfacturatmp"];
$retorno = 0;
//if ($modif<>1) {
if (!isset($codfacturatmp)) {
    $codfacturatmp = $_GET["codfacturatmp"];
    $retorno = 1;
}
if ($retorno == 0) {
    //$codfamilia=$_POST["codfamilia"];
    $idarticulo = $_POST["idarticulo"];
    $cantidad = $_POST["cantidad"];
    $precio = $_POST["precio"];
    $importe = $_POST["importe"];
    $descuento = $_POST["descuento"];
    $iva = $_POST["iva"];
    $pvp = $_POST["pvp"];
    $utilidad = $_POST["utilidad"];
    $bodega = $_POST["cbobodega"];

    // MANEJO DE SERIES ***********************************************************************************
    $series = $_POST["series"];
    $series_string = "";
    $num_series = sizeof($series);
    $cont =0;
    while($cont < $num_series){
        if($cont == ($num_series -1)){
            $series_string = $series_string . utf8_encode($series[$cont]);
        }else{
            $series_string = $series_string . utf8_encode($series[$cont]) . "----";
        }
        $cont++;
    }
    //*******************************************************************************************************

    /*foreach ($series as $s) {
        $series_string = $series_string . $s . "----";
    }*/


    $sel_insert = "INSERT INTO factulineaptmp (codfactura,numlinea,id_articulo,cantidad,costo,importe,dcto,iva,pvp,utilidad,id_bodega, series) 
                    VALUES ('$codfacturatmp',null,'$idarticulo','$cantidad','$precio','$importe','$descuento','$iva','$pvp','$utilidad','$bodega','$series_string')";
    $rs_insert = mysql_query($sel_insert, $conn);


}

//}
?>
<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
    <?php 
    $sel_lineas = "SELECT b.codigo as codigo, b.nombre as nombre, a.numlinea as numlinea, a.cantidad as cantidad, a.costo as costo, 
					a.importe as importe, a.dcto as dcto, a.iva as iva, a.utilidad as utilidad, a.id_bodega as idbodega, a.series as series 
			FROM factulineaptmp a INNER JOIN producto b ON a.id_articulo=b.id_producto 
			WHERE a.codfactura = $codfacturatmp ORDER BY a.numlinea ASC";
    $rs_lineas = mysql_query($sel_lineas, $conn);
    for ($i = 0; $i < mysql_num_rows($rs_lineas); $i++) {
        $numlinea = mysql_result($rs_lineas, $i, "numlinea");
        //$codfamilia=mysql_result($rs_lineas,$i,"codfamilia");

        $codarticulo = mysql_result($rs_lineas, $i, "codigo");
        $descripcion = mysql_result($rs_lineas, $i, "nombre");
        $cantidad = mysql_result($rs_lineas, $i, "cantidad");
        $precio = mysql_result($rs_lineas, $i, "costo");
        $importe = mysql_result($rs_lineas, $i, "importe");
        $descuento = mysql_result($rs_lineas, $i, "dcto");
        $iva = mysql_result($rs_lineas, $i, "iva");
        $utilidad = mysql_result($rs_lineas, $i, "utilidad");
        $idbodega = mysql_result($rs_lineas, $i, "idbodega");
        $seriestemp = (mysql_result($rs_lineas, $i, "series"));

        $queryb = "SELECT nombre FROM bodega WHERE id_bodega = '$idbodega'";
        $resb = mysql_query($queryb, $conn);
        $nombod = mysql_result($resb, 0, "nombre");


        if ($i % 2) {
            $fondolinea = "itemParTabla";
        } else {
            $fondolinea = "itemImparTabla";
        } ?>
        <tr class="<?php  echo $fondolinea ?>">

            <td width="5%"><?php  echo $seriestemp ?></td>
            <td width="41%" align="center"><?php  echo $descripcion ?></td>
            <td width="8%"><?php  echo $nombod ?></td>
            <td width="5%" align="center"><?php  echo $cantidad ?></td>
            <td width="8%" align="center"><?php  echo $precio ?></td>
            <td width="8%" align="center"><?php  echo $descuento ?></td>
            <td width="8%" align="center"><?php  echo $importe ?></td>
            <td width="8%" align="center"><?php  echo $iva ?></td>
            <td width="3%"><a
                    href="javascript:eliminar_linea(<?php  echo $codfacturatmp ?>,<?php  echo $numlinea ?>,<?php  echo $importe ?>,<?php  echo $iva ?>,<?php  echo $descuento ?>)"><img
                        src="../img/eliminar.png" border="0"></a></td>
            <td width="3%"><a
                    href="javascript:modificar_linea(<?php  echo $codfacturatmp ?>,<?php  echo $numlinea ?>,<?php  echo $importe ?>,<?php  echo $iva ?>,<?php  echo $descuento ?>, <?php  echo $utilidad ?>, <?php  echo $idbodega ?>, '<?php  echo $seriestemp ?>')"><img
                        src="../img/modificar.png" border="0"></a></td>
        </tr>
    <?php  } ?>
</table>
<iframe id="frame_datos" name="frame_datos" width="0%" height="0" frameborder="0">
    <ilayer width="0" height="0" id="frame_datos" name="frame_datos"></ilayer>
</iframe>
</body>
</html>