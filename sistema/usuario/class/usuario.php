<?php

class usuario
{
    private $id_usuario;
    private $id_facturero;
    private $nombre;
    private $password;
    private $tipo;
    private $borrado;
    private $id_bodega;

    private $leyenda_facturero;

    public function __construct()
    {
        $this->id_usuario = null;
        $this->id_facturero = null;
        $this->nombre = null;
        $this->password = null;
        $this->tipo = null;
        $this->borrado = null;
        $this->leyenda_facturero = null;
        $this->id_bodega = null;

    }

    public function save($conn, $id_facturero, $nombre, $password, $tipo, $id_bodega)
    {

        $query="INSERT INTO usuario VALUES (null, '$id_facturero','$nombre','$password', '$tipo','0',$id_bodega)";
        $result= mysql_query($query, $conn);
        return $result;
    }

    public function delete($conn, $id)
    {
        $query = "UPDATE usuario SET borrado = 1 WHERE id_usuario='$id'";
        $result = mysql_query($query, $conn);
        return $result;
    }

    public function update($conn, $id, $id_facturero, $nombre, $password, $tipo, $id_bodega)
    {

        
        $query = "UPDATE usuario SET  id_facturero = '$id_facturero', nombre = '$nombre', password = '$password', tipo = '$tipo', id_bodega = '$id_bodega'
                  WHERE id_usuario = '$id'";

        $result = mysql_query($query, $conn);

        return $result;

    }

    public function get_id($conn, $id)
    {

        $query="SELECT  u.nombre, u.password, u.tipo , u.id_facturero, u.id_bodega FROM usuario u   WHERE u.id_usuario ='$id' AND u.borrado = 0";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

    public function get_borrado_id($conn, $id)
    {
        $query="SELECT  nombre FROM usuario WHERE id_usuario ='$id' AND borrado = 1";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

    public function get_leyenda_facturero($conn, $id){
        $query="SELECT CONCAT( serie1,  '-', serie2 ) AS leyendafacturero  FROM facturero   WHERE id_facturero ='$id' ";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;

    }

    public function get_leyenda_bodega($conn, $id){
        $query="SELECT nombre  FROM bodega WHERE id_bodega ='$id' ";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }
}
?>