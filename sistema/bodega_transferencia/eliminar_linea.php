<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache'); 

include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$transferenciatmp=$_GET["transferenciatmp"];
$numlinea=$_GET["numlinea"];

$consulta = "DELETE FROM transferencialineatmp WHERE id_transferencia ='".$transferenciatmp."' AND numlinea='".$numlinea."'";
$rs_consulta = mysql_query($consulta, $conn);
echo "<script>parent.location.href='frame_lineas.php?transferenciatmp=".$transferenciatmp."';</script>";

?>