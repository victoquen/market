<?php
    include_once '../conexion/conexion.php';
    
    $usuario = new ServidorBaseDatos();
    $conn= $usuario->getConexion();


    $id=$_GET["idproductobodega"];

$query = "SELECT stock FROM productobodega WHERE id_productobodega ='1'";
    //$query = "SELECT stock FROM productobodega WHERE id_productobodega ='".$id."'";
	$result = mysql_query($query, $conn);
	
	
   
	
	
	
	header('Content-Type: text/xml');
    echo "<?xml version='1.0' encoding='ISO-8859-1' standalone='yes'?>\n";
    echo "<subgrupos>\n";
		echo "<subgrupo>";
        echo "<id>".mysql_result($result, 0,'stock')."</id>";
        echo "</subgrupo>\n";
    echo "</subgrupos>";
?>