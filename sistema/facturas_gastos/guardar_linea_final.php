<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache'); 

include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();


$importe_pasar=$_GET["importe_pasar"];
$iva_pasar=$_GET["iva_pasar"];
$cantidad_pasar=$_GET["cantidad_pasar"];
$descuento_pasar=$_GET["descuento_pasar"];

$idfactura=$_GET["idfactura"];
$id_factulineap=$_GET["id_factulineap"];
$cantidad=$_GET["cantidad"];
$precio=$_GET["precio"];
$importe=$_GET["importe"];
$iva=$_GET["iva"];
$descuento=$_GET["descuento"];



$importe_total=$importe - $importe_pasar;
$iva_total=$iva - $iva_pasar;
$descuento_total=$descuento-$descuento_pasar;

$importe_total = $importe_total + $descuento_total;




$consulta = "UPDATE factulineap 
            SET cantidad = '".$cantidad."', costo = '".$precio."', subtotal = '".$importe."', iva = '".$iva."', dcto = '".$descuento."'
            WHERE id_facturap ='".$idfactura."' AND id_factulineap='".$id_factulineap."'";
$rs_consulta = mysql_query($consulta, $conn);


$cant=$cantidad_pasar - $cantidad;

$datos_linea="SELECT id_producto, cantidad FROM factulineap WHERE id_facturap ='".$idfactura."' AND id_factulineap='".$id_factulineap."'";
$rs_datoslinea= mysql_query($datos_linea, $conn);

$idproducto=mysql_result($rs_datoslinea,0,"id_producto");



if($cant>0)
{
    $update_stock="UPDATE producto SET stock = stock - $cant WHERE id_producto = $idproducto";
    $rs_updatestock=mysql_query($update_stock, $conn);
}

if ($cant<0)
{
    $cant_posit=$cantidad - $cantidad_pasar;
    $update_stock="UPDATE producto SET stock = stock + $cant_posit WHERE id_producto = $idproducto";
    $rs_updatestock=mysql_query($update_stock, $conn);
}

echo "<script>        
//parent.opener.document.location.href='frame_lineas_final.php?idfactura=".$idfactura."&modif=1';
parent.opener.actualizar(".$importe_total.",".$iva_total.",".$idfactura.",".$descuento_total.");
parent.window.close();
    </script>";

?>