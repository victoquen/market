<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache'); 

include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$idcliente=$_GET["idcliente"];
$idtelefono=$_GET["idtelefono"];

$consulta = "DELETE FROM clientefono WHERE id_cliente ='".$idcliente."' AND id_telefono='".$idtelefono."'";
$rs_consulta = mysql_query($consulta, $conn);
echo "<script>parent.location.href='frame_telefonos_final.php?idcliente=".$idcliente."';</script>";

?>