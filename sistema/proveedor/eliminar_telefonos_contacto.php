<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache'); 

include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$codproveedor=$_GET["codproveedortmp"];
$numcontacto=$_GET["numcontacto"];
$numfono=$_GET["numfono"];

$consulta = "DELETE FROM proveedorcontactofonotmp WHERE idproveedor ='".$codproveedor."' AND numcontacto = '".$numcontacto."'AND numfono='".$numfono."'";
$rs_consulta = mysql_query($consulta, $conn);
echo "<script>parent.location.href='frame_telefonos_contacto.php?codproveedortmp=".$codproveedor."&numcontacto=".$numcontacto."';</script>";

?>