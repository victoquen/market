<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache'); 

include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$codcliente=$_GET["codclientetmp"];
$numfono=$_GET["numfono"];

$consulta = "DELETE FROM clientefonotmp WHERE idcliente ='".$codcliente."' AND numfono='".$numfono."'";
$rs_consulta = mysql_query($consulta, $conn);
echo "<script>parent.location.href='frame_telefonos.php?codclientetmp=".$codcliente."';</script>";

?>