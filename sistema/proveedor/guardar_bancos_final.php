<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache'); 

include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$idproveedor=$_POST["idproveedor"];
$idbanco=$_POST["idbanco"];
$banco=$_POST["banco"];
$titular=strtoupper($_POST["titular"]);
$numerocuenta=$_POST["numero_cuenta"];
$tipo=$_POST["tipo"];

$consulta = "UPDATE proveedorbanco
            SET banco ='".$banco."', titular ='".$titular."', numero_cuenta ='".$numerocuenta."', tipo_cuenta ='".$tipo."'
            WHERE id_proveedor ='".$idproveedor."' AND id_banco='".$idbanco."'";
$rs_consulta = mysql_query($consulta, $conn);


?>