<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache'); 

include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();


$importe_pasar=$_GET["importe_pasar"];
$iva_pasar=$_GET["iva_pasar"];
$descuento_pasar=$_GET["descuento_pasar"];

$codfactura=$_GET["codfactura"];
$numlinea=$_GET["numlinea"];
$cantidad=$_GET["cantidad"];
$precio=$_GET["precio"];
$importe=$_GET["importe"];
$iva=$_GET["iva"];
$descuento=$_GET["descuento"];
$utilidad=$_GET["utilidad"];
$idbodega = $_GET["cbobodega"];

// MANEJO DE SERIES ***********************************************************************************
$series = $_GET["series"];
$series_string = "";
$num_series = sizeof($series);
$cont =0;
while($cont < $num_series){
    if($cont == ($num_series -1)){
        $series_string = $series_string . utf8_encode($series[$cont]);
    }else{
        $series_string = $series_string . utf8_encode($series[$cont]) . "----";
    }
    $cont++;
}
//*******************************************************************************************************



$importe_total=$importe - $importe_pasar;
$iva_total=$iva - $iva_pasar;
$descuento_total=$descuento-$descuento_pasar;



$importe_total = $importe_total + $descuento_total;





$consulta = "UPDATE factulineaptmp 
            SET cantidad = '".$cantidad."', costo = '".$precio."', importe = '".$importe."', iva = '".$iva."', dcto = '".$descuento."', utilidad = '".$utilidad."', id_bodega = '".$idbodega."', series = '".$series_string."'
            WHERE codfactura ='".$codfactura."' AND numlinea='".$numlinea."'";
$rs_consulta = mysql_query($consulta, $conn);
//echo "<script>
//        parent.location.href='frame_lineas.php?codfacturatmp=".$codfactura."';
//        window.close();
//    </script>";

echo "<script>
         







parent.opener.document.location.href='frame_lineas.php?codfacturatmp=".$codfactura."';

parent.opener.actualizar(".$importe_total.",".$iva_total.",".$descuento_total.");
parent.window.close();


    </script>";

?>