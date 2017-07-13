<?php

class Proveedorcontacto
{
    private $id_contacto;
    private $id_proveedor;
    private $cargo;
    private $nombre;
    private $linea;
    private $email;
    private $borrado;

    public function __construct()
    {
        $this->id_contacto=null;
        $this->id_proveedor=null;
        $this->cargo=null;
        $this->nombre=null;
        $this->linea=null;
        $this->email=null;
        $this->borrado=null;
    }

    public function save_contacto($conn, $id_proveedor, $cargo, $nombre, $linea,$email)
    {        

        $query="INSERT INTO proveedorcontacto VALUES (null,'$id_proveedor','$cargo','$nombre','$linea','$email',0)";
        $result= mysql_query($query, $conn);
        $idcontacto=mysql_insert_id();
        return $idcontacto;
    }

    public function delete_contacto($conn, $idcontacto)
    {
        $query = "UPDATE proveedorcontacto SET borrado=1 WHERE id_contacto='$idcontacto'";
        $result = mysql_query($query, $conn);
        return $result;
    }

    public function update_contacto($conn, $idcontacto, $id_proveedor, $cargo, $nombre, $linea)
    {
        $this->nombre=strtoupper($nombre);
        $query = "UPDATE proveedorcontacto SET id_proveedor='$id_proveedor', cargo = '$cargo',nombre = '$nombre',
                                     linea='$linea'
                  WHERE id_contacto = '$idcontacto'";

        $result = mysql_query($query, $conn);

        return $result;

    }

    public function get_contacto_id($conn, $id)
    {
        $rows;
        $query="SELECT  id_proveedor, cargo, nombre, linea, email
                FROM proveedorcontacto
                WHERE borrado = 0 AND id_contacto ='$id'";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }
    

}
?>