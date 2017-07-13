<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache'); 

include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$codfactura=$_GET["codfacturatmp"];
$numlinea=$_GET["numlinea"];

$consulta = "DELETE FROM factulineaptmp WHERE codfactura ='".$codfactura."' AND numlinea='".$numlinea."'";
$rs_consulta = mysql_query($consulta, $conn);
echo "<script>parent.location.href='frame_lineas.php?codfacturatmp=".$codfactura."';</script>";

?>