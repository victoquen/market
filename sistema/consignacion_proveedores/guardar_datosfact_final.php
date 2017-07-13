<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache'); 

include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$idfactura=$_GET["idfactura"];

$totalfactura=$_GET["totalfactura"];
$importeiva=$_GET["importeiva"];


$update_factura="UPDATE facturasp_consig SET iva12=$importeiva,iva=$importeiva,totalfactura=$totalfactura WHERE id_facturap=$idfactura";
$rs_updatefactura=mysql_query($update_factura, $conn);

echo "<script>parent.location.href='frame_lineas_final.php?idfactura=".$idfactura."';</script>";

?>