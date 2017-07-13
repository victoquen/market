<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache'); 

include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$idcliente=$_POST["idcliente"];
$idtelefono=$_POST["idtelefono"];
$numero=$_POST["numero"];
$operadora=$_POST["operadora"];
$descripcion=$_POST["descripcion"];


$consulta = "UPDATE clientefono
            SET numero ='".$numero."', operadora ='".$operadora."', descripcion ='".$descripcion."'
            WHERE id_cliente ='".$idcliente."' AND id_telefono='".$idtelefono."'";
$rs_consulta = mysql_query($consulta, $conn);
//echo "<script> parent.location.href='frame_telefonos_final.php?idcliente=".$idcliente."';</script>";


?>