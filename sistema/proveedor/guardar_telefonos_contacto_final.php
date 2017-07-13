<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache'); 

include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$idproveedor=$_POST["idproveedor"];
$idtelefono=$_POST["idtelefono"];
$idcontacto=$_POST["idcontacto"];
$numero=$_POST["numero"];
$operadora=$_POST["operadora"];
$descripcion=strtoupper($_POST["descripcion"]);


$consulta = "UPDATE proveedorcontactofono
            SET numero ='".$numero."', operadora ='".$operadora."', descripcion ='".$descripcion."'
            WHERE id_proveedor ='".$idproveedor."' AND id_telefono='".$idtelefono."' AND id_contacto='".$idcontacto."'";
$rs_consulta = mysql_query($consulta, $conn);
//echo "<script> parent.location.href='frame_telefonos_final.php?idproveedor=".$idproveedor."';</script>";
//echo "<script>windows.close()</script>";
//echo "<script>parent.location.href='frame_telefonos_contacto_final.php?idproveedor=".$idproveedor."&idcontacto=".$idcontacto."';</script>";
echo "<script>parent.location.href='telefonos_contacto_final.php?idproveedor=".$idproveedor."&idcontacto=".$idcontacto."';</script>";
?>