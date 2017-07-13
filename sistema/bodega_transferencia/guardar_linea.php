<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache'); 

include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();




$transferenciatmp=$_GET["transferenciatmp"];
$numlinea=$_GET["numlinea"];
$cantidad=$_GET["cantidad"];

$idbodegaorigen = $_GET["cbobodegaorigen"];
$idbodegadestino = $_GET["cbobodegadestino"];


$consulta = "UPDATE transferencialineatmp 
            SET cantidad = '".$cantidad."', id_bodegaorigen = '".$idbodegaorigen."', id_bodegadestino = '".$idbodegadestino."' 
            WHERE id_transferencia ='".$transferenciatmp."' AND numlinea='".$numlinea."'";
$rs_consulta = mysql_query($consulta, $conn);
//echo "<script>
//        parent.location.href='frame_lineas.php?codfacturatmp=".$codfactura."';
//        window.close();
//    </script>";

echo "<script>
         







parent.opener.document.location.href='frame_lineas.php?transferenciatmp=".$transferenciatmp."';


parent.window.close();


    </script>";

?>