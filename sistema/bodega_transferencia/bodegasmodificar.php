<?php
    include_once '../conexion/conexion.php';
    
    $usuario = new ServidorBaseDatos();
    $conn= $usuario->getConexion();


    $idproducto=$_GET["idproducto"];


    $query = "SELECT b.id_bodega as idbodega, b.nombre as nombre FROM bodega b INNER JOIN productobodega p ON b.id_bodega = p.id_bodega WHERE p.id_producto ='".$idproducto."'";
	$result = mysql_query($query, $conn);
    header('Content-Type: text/xml');
    echo "<?xml version='1.0' encoding='ISO-8859-1' standalone='yes'?>\n";
    echo "<subgrupos>\n";

		
	
	
    $contador=0;
    while ($contador<mysql_num_rows($result))
    {
       
        echo "<subgrupo>";
        echo "<id>".mysql_result($result,$contador,"idbodega")."</id>";
        echo "<nombre>".mysql_result($result,$contador,"nombre")."</nombre>";
        echo "</subgrupo>\n";
        $contador++;
    }
    echo "</subgrupos>";
?>