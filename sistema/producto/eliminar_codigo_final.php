<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache'); 

include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();


$id = $_REQUEST["id"];
$idproducto = $_REQUEST["idproducto"];


$consulta = "DELETE FROM producto_barracodigo WHERE id ='$id'";
$rs_consulta = mysql_query($consulta, $conn);
echo "<script>        

parent.opener.cargar(".$idproducto.");
parent.window.close();
    </script>";

?>