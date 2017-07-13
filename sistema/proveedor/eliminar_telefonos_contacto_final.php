<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache'); 

include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$idproveedor=$_GET["idproveedor"];
$idcontacto=$_GET["idcontacto"];
$idtelefono=$_GET["idtelefono"];

$consulta = "DELETE FROM proveedorcontactofono WHERE id_proveedor ='".$idproveedor."' AND id_contacto = '".$idcontacto."'AND id_telefono='".$idtelefono."'";
$rs_consulta = mysql_query($consulta, $conn);
echo "<script>parent.location.href='frame_telefonos_contacto_final.php?idproveedor=".$idproveedor."&idcontacto=".$idcontacto."';</script>";

?>