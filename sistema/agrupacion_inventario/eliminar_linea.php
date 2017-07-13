<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache'); 

include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$codproductotmp=$_GET["codproductotmp"];
$numlinea=$_GET["numlinea"];

$consulta = "DELETE FROM productolineatmp WHERE codproductotmp ='".$codproductotmp."' AND numlinea='".$numlinea."'";
$rs_consulta = mysql_query($consulta, $conn);
echo "<script>parent.location.href='frame_lineas.php?codproductotmp=".$codproductotmp."';</script>";

?>