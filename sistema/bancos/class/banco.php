<?php

class Banco
{
    private $id_banco;
    private $nombre;
    private $borrado;

    public function __construct()
    {
        $this->id_banco=null;
        $this->nombre=null;
        $this->borrado=null;
    }

    public function save_banco($conn, $nombre)
    {
        $this->nombre=strtoupper($nombre);
        $query="INSERT INTO banco VALUES (null,'$this->nombre','0')";
        $result= mysql_query($query, $conn);
        return $result;
    }

    public function delete_banco($conn, $idbanco)
    {
        $query = "UPDATE banco SET borrado = 1 WHERE id_banco='$idbanco'";
        $result = mysql_query($query, $conn);
        return $result;
    }

    public function update_banco($conn, $idbanco, $nombre)
    {

        $this->nombre=strtoupper($nombre);
        $query = "UPDATE banco SET  nombre = '$this->nombre'
                  WHERE id_banco = '$idbanco'";

        $result = mysql_query($query, $conn);

        return $result;

    }

    public function get_banco_id($conn, $id)
    {

        $query="SELECT  nombre FROM banco WHERE id_banco ='$id' AND borrado = 0";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }
     public function get_banco_borrado_id($conn, $id)
    {
        
        $query="SELECT  nombre FROM banco WHERE id_banco ='$id' AND borrado = 1";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

}
?>