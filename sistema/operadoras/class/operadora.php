<?php

class operadora
{
    private $id_operadora;
    private $nombre;
    private $borrado;

    public function __construct()
    {
        $this->id_operadora=null;
        $this->nombre=null;
        $this->borrado=null;
    }

    public function save_operadora($conn, $nombre)
    {
        $this->nombre=strtoupper($nombre);
        $query="INSERT INTO operadora VALUES (null,'$this->nombre','0')";
        $result= mysql_query($query, $conn);
        return $result;
    }

    public function delete_operadora($conn, $idoperadora)
    {
        $query = "UPDATE operadora SET borrado = 1 WHERE id_operadora='$idoperadora'";
        $result = mysql_query($query, $conn);
        return $result;
    }

    public function update_operadora($conn, $idoperadora, $nombre)
    {

        $this->nombre=strtoupper($nombre);
        $query = "UPDATE operadora SET  nombre = '$this->nombre'
                  WHERE id_operadora = '$idoperadora'";

        $result = mysql_query($query, $conn);

        return $result;

    }

    public function get_operadora_id($conn, $id)
    {
        $rows;
        $query="SELECT  nombre FROM operadora WHERE id_operadora ='$id' AND borrado = 0";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }
     public function get_operadora_borrado_id($conn, $id)
    {
        $rows;
        $query="SELECT  nombre FROM operadora WHERE id_operadora ='$id' AND borrado = 1";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

}
?>