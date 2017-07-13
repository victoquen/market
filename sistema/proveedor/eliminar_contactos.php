<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache'); 

include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$codproveedor=$_GET["codproveedortmp"];
$numcontacto=$_GET["numcontacto"];

$consulta = "DELETE FROM proveedorcontactotmp WHERE idproveedor ='".$codproveedor."' AND numcontacto='".$numcontacto."'";
$rs_consulta = mysql_query($consulta, $conn);
echo "<script>parent.location.href='frame_contactos.php?codproveedortmp=".$codproveedor."';</script>";

?>