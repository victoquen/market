<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache'); 

include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$idfactura=$_GET["idfactura"];
$id_factulineap=$_GET["id_factulineap"];

$totalfactura=$_GET["totalfactura"];
$importeiva=$_GET["importeiva"];
$descuento=$_GET["descuento"];
$iva0=$_GET["iva0"];
$iva12=$_GET["iva12"];

$idbodega = $_GET["idbodega"];

$datos_linea="SELECT id_producto, cantidad FROM factulineap WHERE id_facturap ='".$idfactura."' AND id_factulineap='".$id_factulineap."'";
$rs_datoslinea= mysql_query($datos_linea, $conn);

$cant=mysql_result($rs_datoslinea,0,"cantidad");
$idproducto=mysql_result($rs_datoslinea,0,"id_producto");

$consulta = "DELETE FROM factulineap WHERE id_facturap ='".$idfactura."' AND id_factulineap='".$id_factulineap."'";
$rs_consulta = mysql_query($consulta, $conn);


$upbodega = "UPDATE productobodega SET stock = stock - $cant WHERE id_producto = '$idproducto' AND id_bodega = '$idbodega'";
$rs_bod = mysql_query($upbodega, $conn);


$query_totstock = "SELECT SUM(stock) as total FROM productobodega WHERE id_producto = '$idproducto'";
$rs_totstock = mysql_query($query_totstock, $conn);
$totstock = mysql_result($rs_totstock, 0,"total");

$sel_articulos="UPDATE producto SET stock='$totstock' WHERE id_producto='$idproducto'";
$rs_articulos=mysql_query($sel_articulos, $conn);

//$update_stock="UPDATE producto SET stock = stock - $cant WHERE id_producto = $idproducto";
//$rs_updatestock=mysql_query($update_stock, $conn);

$update_factura="UPDATE facturasp SET iva=$importeiva,totalfactura=$totalfactura,descuento=$descuento,iva0=$iva0,iva12=$iva12 
                 WHERE id_facturap=$idfactura";
$rs_updatefactura=mysql_query($update_factura, $conn);

echo "<script>parent.location.href='frame_lineas_final.php?idfactura=".$idfactura."';</script>";

?>