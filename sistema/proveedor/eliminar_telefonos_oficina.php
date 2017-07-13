<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache'); 

include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$codproveedor=$_GET["codproveedortmp"];
$numfono=$_GET["numfono"];

$consulta = "DELETE FROM proveedorfonotmp WHERE idproveedor ='".$codproveedor."' AND numfono='".$numfono."'";
$rs_consulta = mysql_query($consulta, $conn);
echo "<script>parent.location.href='frame_telefonos_oficina.php?codproveedortmp=".$codproveedor."';</script>";

?>