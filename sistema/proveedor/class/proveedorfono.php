<?php

class Proveedorfono
{
    private $id_telefono;
    private $id_proveedor;
    private $numero;
    private $descripcion;
    private $operadora;
    private $borrado;

    public function __construct()
    {
        $this->id_telefono=null;
        $this->id_proveedor=null;
        $this->numero=null;
        $this->descripcion=null;
        $this->operadora=null;
        $this->borrado=null;
    }

    public function save_telefono($conn, $id_proveedor, $numero, $descripcion, $operadora)
    {        

        $query="INSERT INTO proveedorfono VALUES (null,'$id_proveedor','$numero','$descripcion','$operadora')";
        $result= mysql_query($query, $conn);
        return $result;
    }

    public function delete_telefono($conn, $idtelefono)
    {
        $query = "DELETE FROM proveedorfono WHERE id_telefono='$idtelefono'";
        $result = mysql_query($query, $conn);
        return $result;
    }

    public function update_telefono($conn, $idtelefono, $id_proveedor, $numero, $descripcion, $operadora)
    {
        $this->nombre=strtoupper($nombre);
        $query = "UPDATE proveedorfono SET id_proveedor='$id_proveedor', numero = '$numero',descripcion = '$descripcion',
                                     operadora='$operadora'
                  WHERE id_telefono = '$idtelefono'";

        $result = mysql_query($query, $conn);

        return $result;

    }

    public function get_telefono_id($conn, $id)
    {
        $rows;
        $query="SELECT  id_proveedor, numero, descripcion, operadora
                FROM proveedorfono
                WHERE id_telefono ='$id'";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }


    public function get_nombreoperadora($id, $conn)
    {
        $query = "SELECT  nombre FROM operadora WHERE id_operadora='$id'";
        $result= mysql_query($query, $conn);
        $operadora=mysql_result($result,0,'nombre');
        return $operadora;
    }


    public function listado_operadoras($conn)
    {
        $rows=array ();
        $query = "SELECT id_operadora, nombre FROM operadora WHERE borrado = 0";
        $result= mysql_query($query, $conn);
        while ($row=mysql_fetch_assoc($result))
        {
            $rows[]=$row;
        }
        return $rows;
    }

}
?>