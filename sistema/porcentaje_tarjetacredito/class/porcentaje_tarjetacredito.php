<?php

/**
 * Created by PhpStorm.
 * User: VICTOR OQUENDO
 * Date: 7/14/2017
 * Time: 3:18 PM
 */
class Porcentaje_tarjetacredito
{
    private $id;
    private $porcentaje;
    private $borrado;


    public function __construct()
    {
        $this->id = null;
        $this->porcentaje = null;
        $this->borrado = null;
        
    }

    public function save($conn, $porcentaje)
    {
        $query="INSERT INTO porcentaje_tarjetacredito VALUES (null, '$porcentaje','0')";
        $result= mysql_query($query, $conn);
        return $result;
    }


    public function update($conn, $id, $porcentaje)
    {
        $query = "UPDATE porcentaje_tarjetacredito SET  porcentaje = '$porcentaje'
                  WHERE id = '$id'";
        $result = mysql_query($query, $conn);
        return $result;

    }

    public function delete($conn, $id)
    {
        $query = "UPDATE porcentaje_tarjetacredito SET borrado = 1 WHERE id='$id'";
        $result = mysql_query($query, $conn);
        return $result;
    }

    public function get_id($conn, $id)
    {
        $query="SELECT  porcentaje FROM porcentaje_tarjetacredito    WHERE id ='$id'";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

    public function get_borrado_id($conn, $id)
    {
        $query="SELECT  porcentaje FROM porcentaje_tarjetacredito WHERE id ='$id' AND borrado = 1";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }
}

?>