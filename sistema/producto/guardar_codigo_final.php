<?php

header('Cache-Control: no-cache');
header('Pragma: no-cache');

include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();


$id = $_GET["id"];
$idproducto = $_GET["idproducto"];
$codigo = $_GET["acodigo"];


$consulta = "UPDATE producto_barracodigo 
            SET codigo = '$codigo'            
            WHERE  id='$id'";
$rs_consulta = mysql_query($consulta, $conn);


echo "<script>        

parent.opener.cargar(".$idproducto.");
parent.window.close();
    </script>";
?>