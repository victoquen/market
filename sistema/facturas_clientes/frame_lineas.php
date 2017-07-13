<html>
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8"/>
</head>

<script>
    function eliminar_linea(codfacturatmp, numlinea, importe, descuento, iva) {
        if (confirm(" Desea eliminar esta linea ? ")) {
            parent.document.formulario_lineas.baseimponible.value = parseFloat(parent.document.formulario_lineas.baseimponible.value) - parseFloat(importe);
            var original = parseFloat(parent.document.formulario_lineas.baseimponible.value);
            var result = Math.round(original * 100) / 100;
            parent.document.formulario_lineas.baseimponible.value = result;

            parent.document.formulario_lineas.importeiva.value = parseFloat(parent.document.formulario_lineas.importeiva.value) - parseFloat(iva);
            var original1 = parseFloat(parent.document.formulario_lineas.importeiva.value);
            var result1 = Math.round(original1 * 100) / 100;
            parent.document.formulario_lineas.importeiva.value = result1;
            parent.document.formulario_lineas.iva12.value = result1;


            parent.document.formulario_lineas.descuentototal.value = parseFloat(parent.document.formulario_lineas.descuentototal.value) - parseFloat(descuento);
            var original2 = parseFloat(parent.document.formulario_lineas.descuentototal.value);
            var result2 = Math.round(original2 * 100) / 100;
            parent.document.formulario_lineas.descuentototal.value = result2;


            var original5 = parseFloat(result) + parseFloat(result1) - parseFloat(result2);
            var result5 = Math.round(original5 * 100) / 100;
            parent.document.formulario_lineas.preciototal.value = result5;

            //var original3=parseFloat(result2)

            document.getElementById("frame_datos").src = "eliminar_linea.php?codfacturatmp=" + codfacturatmp + "&numlinea=" + numlinea;
        }
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
    $costo = $_POST["costo"];

    

   

    $sel_insert = "INSERT INTO factulineatmp (codfactura,numlinea,id_articulo,cantidad,costo,precio,importe,dcto,iva)
                                            VALUES ('$codfacturatmp','','$idarticulo','$cantidad','$costo','$precio','$importe','$descuento','$iva')";
    $rs_insert = mysql_query($sel_insert, $conn);

}

//}
?>

<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=1 ID="Table1">
    <?php 
    $sel_lineas = "SELECT b.codigo as codigo, b.nombre as nombre, a.numlinea as numlinea, a.cantidad as cantidad, a.precio as precio, a.importe as importe, a.dcto as dcto, a.iva as iva
                        FROM factulineatmp a INNER JOIN producto b ON a.id_articulo=b.id_producto
                        WHERE a.codfactura = $codfacturatmp ORDER BY a.numlinea ASC";
    $rs_lineas = mysql_query($sel_lineas, $conn);
    for ($i = 0; $i < mysql_num_rows($rs_lineas); $i++) {
        $numlinea = mysql_result($rs_lineas, $i, "numlinea");
        //$codfamilia=mysql_result($rs_lineas,$i,"codfamilia");

        $codarticulo = mysql_result($rs_lineas, $i, "codigo");
        $descripcion = mysql_result($rs_lineas, $i, "nombre");
        $cantidad = mysql_result($rs_lineas, $i, "cantidad");
        $precio = mysql_result($rs_lineas, $i, "precio");
        $importe = mysql_result($rs_lineas, $i, "importe");
        $descuento = mysql_result($rs_lineas, $i, "dcto");
        $iva = mysql_result($rs_lineas, $i, "iva");
        if ($i % 2) {
            $fondolinea = "itemParTabla";
        } else {
            $fondolinea = "itemImparTabla";
        } ?>
        <tr class="<?php  echo $fondolinea ?>">

            <td width="18%"><?php  echo $codarticulo ?></td>
            <td width="41%"><?php  echo $descripcion ?></td>
            <td width="5%"><?php  echo $cantidad ?></td>
            <td width="8%" class="aCentro"><?php  echo $precio ?></td>
            <td width="7%" class="aCentro"><?php  echo $importe ?></td>
            <td width="8%" class="aCentro"><?php  echo $descuento ?></td>
            <td width="8%" class="aCentro"><?php  echo $iva ?></td>
            <td width="3%"><a
                    href="javascript:eliminar_linea(<?php  echo $codfacturatmp ?>,<?php  echo $numlinea ?>,<?php  echo $importe ?>,<?php  echo $descuento ?>,<?php  echo $iva ?>)"><img
                        src="../img/eliminar.png" border="0"></a></td>
        </tr>
    <?php  } ?>
</table>

<iframe id="frame_datos" name="frame_datos" width="0%" height="0" frameborder="0">
    <ilayer width="0" height="0" id="frame_datos" name="frame_datos"></ilayer>
</iframe>
</body>
</html>