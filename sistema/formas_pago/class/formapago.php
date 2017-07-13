<?php

class formapago
{
    private $id_formapago;
    private $nombre;
    private $borrado;

    public function __construct()
    {
        $this->id_formapago=null;
        $this->nombre=null;
        $this->borrado=null;
    }

    public function save_formapago($conn, $nombre)
    {
        $this->nombre=strtoupper($nombre);
        $query="INSERT INTO formapago VALUES (null,'$this->nombre','0')";
        $result= mysql_query($query, $conn);
        return $result;
    }

    public function delete_formapago($conn, $idformapago)
    {
        $query = "UPDATE formapago SET borrado = 1 WHERE id_formapago='$idformapago'";
        $result = mysql_query($query, $conn);
        return $result;
    }

    public function update_formapago($conn, $idformapago, $nombre)
    {

        $this->nombre=strtoupper($nombre);
        $query = "UPDATE formapago SET  nombre = '$this->nombre'
                  WHERE id_formapago = '$idformapago'";

        $result = mysql_query($query, $conn);

        return $result;

    }

    public function get_formapago_id($conn, $id)
    {
        $rows;
        $query="SELECT  nombre FROM formapago WHERE id_formapago ='$id' AND borrado = 0";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }
     public function get_formapago_borrado_id($conn, $id)
    {
        $rows;
        $query="SELECT  nombre FROM formapago WHERE id_formapago ='$id' AND borrado = 1";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

}
?>