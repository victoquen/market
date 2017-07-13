<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache'); 

include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$idfactura=$_REQUEST["idfactura"];

$totalfactura=$_REQUEST["totalfactura"];
$importeiva=$_REQUEST["importeiva"];
$iva0=$_REQUEST["iva0"];
$iva12=$_REQUEST["iva12"];


$update_factura="UPDATE facturasp SET iva12=$importeiva,iva=$importeiva,totalfactura=$totalfactura, iva0=$iva0, iva12=$iva12 WHERE id_facturap=$idfactura";
$rs_updatefactura=mysql_query($update_factura, $conn);

echo "<script>parent.location.href='frame_lineas_final.php?idfactura=".$idfactura."';</script>";

?>