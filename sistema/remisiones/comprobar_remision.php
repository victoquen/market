<?php
include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$idfactura=$_GET["idfactura"];

$query="SELECT id_remision FROM remision WHERE id_factura = $idfactura";
$result=mysql_query($query,$conn);

$cont=mysql_num_rows($result);
if($cont>0)
{
    $modificar=1;
    $idremision=mysql_result($result,0,"id_remision");
    
    echo "<script>location.href='ver_remision.php?idremision=".$idremision."';</script>";
}
 else {
    $modificar=0;   
    echo "<script>location.href='new_remision.php?idfactura=".$idfactura."';</script>";
}


?>
