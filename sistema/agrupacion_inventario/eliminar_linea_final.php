<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache'); 

include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$idproducto=$_GET["idproducto"];
$idarticulo=$_GET["idarticulo"];

$consulta = "DELETE FROM producto_transformacion WHERE id_transformacion ='".$idproducto."' AND id_producto='".$idarticulo."'";
$rs_consulta = mysql_query($consulta, $conn);
echo "<script>parent.location.href='frame_lineas_final.php?idproducto=".$idproducto."';</script>";

?>