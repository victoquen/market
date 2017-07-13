<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache'); 

include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$idproveedor=$_GET["idproveedor"];
$idcontacto=$_GET["idcontacto"];

$consulta = "DELETE FROM proveedorcontacto WHERE id_proveedor ='".$idproveedor."' AND id_contacto='".$idcontacto."'";
$rs_consulta = mysql_query($consulta, $conn);
echo "<script>parent.location.href='frame_contactos_final.php?idproveedor=".$idproveedor."';</script>";

?>