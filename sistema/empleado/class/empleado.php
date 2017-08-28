<?php

class Empleado
{
    private $id;
    private $nombre;
    private $cedula;
    private $borrado;



    public function __construct()
    {
        $this->id = null;
        $this->nombre = null;
        $this->cedula = null;


    }

    public function save($conn, $nombre, $cedula)
    {
        $this->nombre=strtoupper($nombre);

        $query="INSERT INTO empleado VALUES (null, '$this->nombre','$cedula','0')";
        $result= mysql_query($query, $conn);
        return $result;
    }

    public function delete($conn, $id)
    {
        $query = "UPDATE empleado SET borrado = 1 WHERE id='$id'";
        $result = mysql_query($query, $conn);
        return $result;
    }

    public function update($conn, $id, $nombre, $cedula)
    {
        $this->nombre=strtoupper($nombre);
        
        $query = "UPDATE empleado SET  nombre = '$this->nombre', cedula = '$cedula'
                  WHERE id = '$id'";

        $result = mysql_query($query, $conn);

        return $result;

    }

    public function get_id($conn, $id)
    {

        $query="SELECT  nombre, cedula FROM empleado    WHERE id ='$id' AND borrado = 0";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

    public function get_borrado_id($conn, $id)
    {
        $query="SELECT  nombre, cedula FROM empleado WHERE id ='$id' AND borrado = 1";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }


}
?>