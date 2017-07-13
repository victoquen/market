<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache'); 

include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$codproveedor=$_GET["codproveedortmp"];
$numbanco=$_GET["numbanco"];

$consulta = "DELETE FROM proveedorbancotmp WHERE idproveedor ='".$codproveedor."' AND numbanco='".$numbanco."'";
$rs_consulta = mysql_query($consulta, $conn);
echo "<script>parent.location.href='frame_bancos.php?codproveedortmp=".$codproveedor."';</script>";

?>