<?php

class Contrato
{
    private $id;
    private $nombre;
    private $borrado;



    public function __construct()
    {
        $this->id = null;
        $this->nombre = null;

    }

    public function save($conn, $nombre)
    {
        $this->nombre=strtoupper($nombre);

        $query="INSERT INTO contrato VALUES (null, '$this->nombre','0')";
        $result= mysql_query($query, $conn);
        return $result;
    }

    public function delete($conn, $id)
    {
        $query = "UPDATE contrato SET borrado = 1 WHERE id_contrato='$id'";
        $result = mysql_query($query, $conn);
        return $result;
    }

    public function update($conn, $id, $nombre)
    {
        $this->nombre=strtoupper($nombre);
        
        $query = "UPDATE contrato SET  nombre = '$this->nombre'
                  WHERE id = '$id'";

        $result = mysql_query($query, $conn);

        return $result;

    }

    public function get_id($conn, $id)
    {

        $query="SELECT  nombre FROM contrato  WHERE id ='$id' AND borrado = 0";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

    public function get_borrado_id($conn, $id)
    {
        $query="SELECT  nombre FROM contrato WHERE id ='$id' AND borrado = 1";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }


}
?>