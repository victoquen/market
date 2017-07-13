<?php
    include_once '../conexion/conexion.php';
    
    $usuario = new ServidorBaseDatos();
    $conn= $usuario->getConexion();


    $idgrupo=$_GET["grupo"];


    $query_subgrupo="SELECT id_subgrupo, nombre FROM subgrupo WHERE id_grupo=$idgrupo";
    $result_subgrupo=mysql_query($query_subgrupo,$conn);
    header('Content-Type: text/xml');
    echo "<?xml version='1.0' encoding='ISO-8859-1' standalone='yes'?>\n";
    echo "<subgrupos>\n";


    $contador=0;
    while ($contador<mysql_num_rows($result_subgrupo))
    {
       
        echo "<subgrupo>";
        echo "<id>".mysql_result($result_subgrupo,$contador,"id_subgrupo")."</id>";
        echo "<nombre>".mysql_result($result_subgrupo,$contador,"nombre")."</nombre>";
        echo "</subgrupo>\n";
        $contador++;
    }
    echo "</subgrupos>";
?>