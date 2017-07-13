<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache'); 

include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$idproveedor=$_GET["idproveedor"];
$idbanco=$_GET["idbanco"];

$consulta = "DELETE FROM proveedorbanco WHERE id_proveedor ='".$idproveedor."' AND id_banco='".$idbanco."'";
$rs_consulta = mysql_query($consulta, $conn);
echo "<script>parent.location.href='frame_bancos_final.php?idproveedor=".$idproveedor."';</script>";

?>