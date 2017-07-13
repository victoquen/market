<?php

class Proveedorcontactofono
{
    private $id_telefono;
    private $id_proveedor;
    private $id_contacto;
    private $numero;
    private $descripcion;
    private $operadora;


    public function __construct()
    {
        $this->id_telefono=null;
        $this->id_proveedor=null;
        $this->id_contacto=null;
        $this->numero=null;
        $this->descripcion=null;
        $this->operadora=null;
        
    }

    public function save_telefono($conn, $id_proveedor,$id_contacto, $numero, $descripcion, $operadora)
    {        

        $query="INSERT INTO proveedorcontactofono VALUES (null,'$id_proveedor','$id_contacto','$numero','$descripcion','$operadora')";
        $result= mysql_query($query, $conn);
        return $result;
    }

    public function delete_telefono($conn, $idtelefono)
    {
        $query = "DELETE FROM proveedorcontactofono WHERE id_telefono='$idtelefono'";
        $result = mysql_query($query, $conn);
        return $result;
    }

    public function update_telefono($conn, $idtelefono, $numero, $descripcion, $operadora)
    {
        $this->nombre=strtoupper($nombre);
        $query = "UPDATE proveedorcontactofono SET numero = '$numero',descripcion = '$descripcion',
                                     operadora='$operadora'
                  WHERE id_telefono = '$idtelefono'";

        $result = mysql_query($query, $conn);

        return $result;

    }

    public function get_telefono_id($conn, $id)
    {
        $rows;
        $query="SELECT  id_proveedor, id_contacto, numero, descripcion, operadora
                FROM proveedorcontactofono
                WHERE id_telefono ='$id'";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }


   

}
?>