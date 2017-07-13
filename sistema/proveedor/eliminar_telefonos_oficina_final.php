<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache'); 

include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$idproveedor=$_GET["idproveedor"];
$idtelefono=$_GET["idtelefono"];

$consulta = "DELETE FROM proveedorfono WHERE id_proveedor ='".$idproveedor."' AND id_telefono='".$idtelefono."'";
$rs_consulta = mysql_query($consulta, $conn);
echo "<script>parent.location.href='frame_telefonos_oficina_final.php?idproveedor=".$idproveedor."';</script>";

?>