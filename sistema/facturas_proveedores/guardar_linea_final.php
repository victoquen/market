<?php

header('Cache-Control: no-cache');
header('Pragma: no-cache');

include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();





$importe_pasar = $_GET["importe_pasar"];
$iva_pasar = $_GET["iva_pasar"];
$cantidad_pasar = $_GET["cantidad_pasar"];
$descuento_pasar = $_GET["descuento_pasar"];
$bodega_pasar = $_GET["bodega_pasar"];

$idfactura = $_GET["idfactura"];
$id_factulineap = $_GET["id_factulineap"];
$cantidad = $_GET["cantidad"];
$precio = $_GET["precio"];
$pvp = $_GET["pvp"];

$importe = $_GET["importe"];
$iva = $_GET["iva"];
$descuento = $_GET["descuento"];
$utilidad = $_GET["utilidad"];
$idbodega = $_GET["cbobodega"];


// MANEJO DE SERIES ***********************************************************************************
$series = $_GET["series"];
$series_string = "";
$num_series = sizeof($series);
$cont =0;
while($cont < $num_series){
	if($cont == ($num_series -1)){
		$series_string = $series_string . $series[$cont];
	}else{
		$series_string = $series_string . $series[$cont] . "----";
	}
	$cont++;
}
//*******************************************************************************************************


$importe_total = $importe - $importe_pasar;
$iva_total = $iva - $iva_pasar;
$descuento_total = $descuento - $descuento_pasar;

$importe_total = $importe_total + $descuento_total;




$consulta = "UPDATE factulineap 
            SET cantidad = '" . $cantidad . "', costo = '" . $precio . "', subtotal = '" . $importe . "', iva = '" . $iva . "', dcto = '" . $descuento . "', utilidad = '" . $utilidad . "', id_bodega = '".$idbodega."'
            WHERE id_facturap ='" . $idfactura . "' AND id_factulineap='" . $id_factulineap . "'";
$rs_consulta = mysql_query($consulta, $conn);


$cant = $cantidad_pasar - $cantidad;

$datos_linea = "SELECT id_producto, cantidad FROM factulineap WHERE id_facturap ='" . $idfactura . "' AND id_factulineap='" . $id_factulineap . "'";
$rs_datoslinea = mysql_query($datos_linea, $conn);

$idproducto = mysql_result($rs_datoslinea, 0, "id_producto");




$upbodega = "UPDATE productobodega SET stock = stock - $cantidad_pasar WHERE id_producto = '$idproducto' AND id_bodega = '$bodega_pasar'";
$rs_bod = mysql_query($upbodega, $conn);

$quer="SELECT id_productobodega as id FROM productobodega WHERE id_producto='$idproducto' AND id_bodega = '$idbodega'";
$res= mysql_query($quer,$conn);
if(mysql_result($res,0,"id")==null){
	$queryi = "INSERT INTO productobodega VALUES (null, '$idproducto', '$idbodega', '$cantidad')";
	$resi = mysql_query($queryi,$conn);
}else{
	$upbodega = "UPDATE productobodega SET stock = stock + $cantidad WHERE id_producto = '$idproducto' AND id_bodega = '$idbodega'";
	$rs_bod = mysql_query($upbodega, $conn);
}

$query_totstock = "SELECT SUM(stock) as total FROM productobodega WHERE id_producto = '$idproducto'";
$rs_totstock = mysql_query($query_totstock, $conn);
$totstock = mysql_result($rs_totstock, 0,"total");

$sel_articulos="UPDATE producto SET stock='$totstock', costo='$precio', pvp='$pvp', utilidad ='$utilidad' WHERE id_producto='$idproducto'";
$rs_articulos=mysql_query($sel_articulos, $conn);

//$sel_articulos = "UPDATE producto SET  costo='$precio', pvp='$pvp', utilidad ='$utilidad' WHERE id_producto='$idproducto'";
//$rs_articulos = mysql_query($sel_articulos, $conn);
/*if ($cant > 0) {
    $update_stock = "UPDATE producto SET stock = stock - $cant WHERE id_producto = $idproducto";
    $rs_updatestock = mysql_query($update_stock, $conn);
}

if ($cant < 0) {
    $cant_posit = $cantidad - $cantidad_pasar;
    $update_stock = "UPDATE producto SET stock = stock + $cant_posit WHERE id_producto = $idproducto";
    $rs_updatestock = mysql_query($update_stock, $conn);
}*/

echo "<script>        
//parent.opener.document.location.href='frame_lineas_final.php?idfactura=" . $idfactura . "&modif=1';
parent.opener.actualizar(" . $importe_total . "," . $iva_total . "," . $idfactura . "," . $descuento_total . ");
parent.window.close();
    </script>";
?>