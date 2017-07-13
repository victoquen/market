<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache'); 

include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();


$importe_pasar=$_GET["importe_pasar"];
$iva_pasar=$_GET["iva_pasar"];

$codfactura=$_GET["codfactura"];
$numlinea=$_GET["numlinea"];
$cantidad=$_GET["cantidad"];
$precio=$_GET["precio"];
$importe=$_GET["importe"];
$iva=$_GET["iva"];

$importe_total=$importe - $importe_pasar;
$iva_total=$iva - $iva_pasar;

$consulta = "UPDATE factulineaptmp_consig
            SET cantidad = '".$cantidad."', costo = '".$precio."', importe = '".$importe."', iva = '".$iva."'
            WHERE codfactura ='".$codfactura."' AND numlinea='".$numlinea."'";
$rs_consulta = mysql_query($consulta, $conn);
//echo "<script>
//        parent.location.href='frame_lineas.php?codfacturatmp=".$codfactura."';
//        window.close();
//    </script>";

echo "<script>
         







parent.opener.document.location.href='frame_lineas.php?codfacturatmp=".$codfactura."';
parent.opener.actualizar(".$importe_total.",".$iva_total.");
parent.window.close();


    </script>";

?>