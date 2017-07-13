<?php

class cuenta
{
    private $id_cuenta;
    private $nombre;
    private $gasto;
    private $borrado;

    public function __construct()
    {
        $this->id_cuenta=null;
        $this->nombre=null;
        $this->gasto=null;
        $this->borrado=null;
    }

    public function save_cuenta($conn, $nombre, $gasto)
    {
        $this->nombre=strtoupper($nombre);
        $query="INSERT INTO cuenta VALUES (null,'$this->nombre','$gasto','0')";
        $result= mysql_query($query, $conn);
        return $result;
    }

    public function delete_cuenta($conn, $idcuenta)
    {
        $query = "UPDATE cuenta SET borrado = 1 WHERE id_cuenta='$idcuenta'";
        $result = mysql_query($query, $conn);
        return $result;
    }

    public function update_cuenta($conn, $idcuenta, $nombre, $gasto)
    {

        $this->nombre=strtoupper($nombre);
        $query = "UPDATE cuenta SET  nombre = '$this->nombre', gasto='$gasto'
                  WHERE id_cuenta = '$idcuenta'";

        $result = mysql_query($query, $conn);

        return $result;

    }

    public function get_cuenta_id($conn, $id)
    {
        $rows;
        $query="SELECT  nombre, gasto FROM cuenta WHERE id_cuenta ='$id' AND borrado = 0";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }
     public function get_cuenta_borrado_id($conn, $id)
    {
        $rows;
        $query="SELECT  nombre, gasto FROM cuenta WHERE id_cuenta ='$id' AND borrado = 1";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

}
?>