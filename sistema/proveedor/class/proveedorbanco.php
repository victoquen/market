<?php

class Proveedorbanco
{
    private $id_banco;
    private $id_proveedor;
    private $banco;
    private $titular;
    private $numero_cuenta;
    private $tipo_cuenta;

    public function __construct()
    {
        $this->id_banco=null;
        $this->id_proveedor=null;
        $this->banco=null;
        $this->titular=null;
        $this->numero_cuenta=null;
        $this->tipo_cuenta=null;
    }

    public function save_banco($conn, $id_proveedor, $banco, $titular, $numero_cuenta, $tipo_cuenta)
    {        

        $query="INSERT INTO proveedorbanco VALUES (null,'$id_proveedor','$banco','$titular','$numero_cuenta','$tipo_cuenta')";
        $result= mysql_query($query, $conn);
        return $result;
    }

    public function delete_banco($conn, $idbanco)
    {
        $query = "DELETE FROM proveedorbanco WHERE id_banco='$idbanco'";
        $result = mysql_query($query, $conn);
        return $result;
    }

    public function update_banco($conn, $idbanco, $id_proveedor, $banco, $titular, $numero_cuenta, $tipo_cuenta)
    {
        $this->nombre=strtoupper($nombre);
        $query = "UPDATE proveedorbanco SET id_proveedor='$id_proveedor', banco = '$banco',titular = '$titular',
                                     numero_cuenta='$numero_cuenta', tipo_cuenta='$tipo_cuenta'
                  WHERE id_banco = '$idbanco'";

        $result = mysql_query($query, $conn);

        return $result;

    }

    public function get_banco_id($conn, $id)
    {
        $rows;
        $query="SELECT  id_proveedor, banco, titular, numero_cuenta, tipo_cuenta
                FROM proveedorbanco
                WHERE id_banco ='$id'";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }


   

}
?>