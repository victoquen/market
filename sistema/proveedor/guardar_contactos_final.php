<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache'); 

include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$idproveedor=$_POST["idproveedor"];
$idcontacto=$_POST["idcontacto"];
$cargo=strtoupper($_POST["cargo"]);
$nombre_contacto=strtoupper( $_POST["nombre_contacto"]);
$linea_contacto=strtoupper($_POST["linea_contacto"]);
$email_contacto=$_POST["email_contacto"];

$consulta = "UPDATE proveedorcontacto
            SET cargo ='".$cargo."', nombre ='".$nombre_contacto."', linea ='".$linea_contacto."', email ='".$email_contacto."'
            WHERE id_proveedor ='".$idproveedor."' AND id_contacto='".$idcontacto."'";
$rs_consulta = mysql_query($consulta, $conn);


?>