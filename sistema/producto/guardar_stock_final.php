<?php

header('Cache-Control: no-cache');
header('Pragma: no-cache');

include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();


$idbodega = $_GET["idbodega"];
$idproducto = $_GET["idproducto"];
$stock = $_GET["astock"];







$consulta = "UPDATE productobodega 
            SET stock = '" . $stock . "'
            WHERE id_bodega ='" . $idbodega . "' AND id_producto='" . $idproducto . "'";
$rs_consulta = mysql_query($consulta, $conn);



$query="SELECT SUM(stock) as stock FROM productobodega WHERE id_producto ='".$idproducto."'";
        $result = mysql_query($query, $conn);
        $res = mysql_result($result,0,"stock");

$consulta = "UPDATE producto
            SET stock = '" . $res . "'
            WHERE id_producto='" . $idproducto . "'";
$rs_consulta = mysql_query($consulta, $conn);


echo "<script>        
//parent.opener.document.location.href='frame_lineas_final.php?idfactura=" . $idfactura . "&modif=1';
parent.opener.cargar(".$idproducto.");
parent.window.close();
    </script>";
?>