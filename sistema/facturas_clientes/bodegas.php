<?php
include_once '../conexion/conexion.php';

$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();


$idproducto = $_GET["idproducto"];


//get datos SESSION
session_start();
$id_bodega = $_SESSION['id_bodega'];
$tipo = $_SESSION['tipo'];

//$query = "SELECT b.id_bodega as idbodega, b.nombre as nombre FROM bodega b INNER JOIN productobodega p ON b.id_bodega = p.id_bodega WHERE p.id_producto ='".$idproducto."'";
$query = "SELECT b.id_bodega as idbodega, b.nombre as nombre FROM bodega b  WHERE b.id_bodega ='$id_bodega'";

$result = mysql_query($query, $conn);
header('Content-Type: text/xml');
echo "<?xml version='1.0' encoding='ISO-8859-1' standalone='yes'?>\n";
echo "<subgrupos>\n";

/*echo "<subgrupo>";
echo "<id>0</id>";
echo "<nombre>Escoger</nombre>";
echo "</subgrupo>\n";*/


$contador = 0;
while ($contador < mysql_num_rows($result)) {

    echo "<subgrupo>";
    echo "<id>" . mysql_result($result, $contador, "idbodega") . "</id>";
    echo "<nombre>" . mysql_result($result, $contador, "nombre") . "</nombre>";
    echo "</subgrupo>\n";
    $contador++;
}
echo "</subgrupos>";
?>