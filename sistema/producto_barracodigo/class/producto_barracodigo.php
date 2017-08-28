<?php

/**
 * Created by PhpStorm.
 * User: VICTOR OQUENDO
 * Date: 7/15/2017
 * Time: 9:31 AM
 */
class Producto_barracodigo
{
    private $id;
    private $id_producto;
    private $codigo;
    private $borrado;

    public function __construct()
    {
        $this->id = null;
        $this->nombre = null;
        $this->cedula = null;


    }

    public function save($conn, $id_producto, $codigo)
    {


        $query="INSERT INTO producto_barracodigo VALUES (null, '$id_producto','$codigo','0')";
        $result= mysql_query($query, $conn);
        return $result;
    }

    public function delete($conn, $id)
    {
        $query = "UPDATE producto_barracodigo SET borrado = 1 WHERE id='$id'";
        $result = mysql_query($query, $conn);
        return $result;
    }

    public function update($conn, $id, $id_producto, $codigo)
    {

        $query = "UPDATE producto_barracodigo SET  id_producto = '$id_producto', codigo = '$codigo'
                  WHERE id = '$id'";

        $result = mysql_query($query, $conn);

        return $result;

    }

    public function get_id($conn, $id)
    {

        $query="SELECT  a.id_producto as id_producto, a.codigo as codigo, b.nombre as nombre 
                FROM producto_barracodigo a 
                INNER JOIN producto b ON a.id_producto = b.id_producto
                WHERE a.id ='$id' AND a.borrado = 0";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

    public function get_codigo($conn, $codigo)
    {

        $query="SELECT  a.id_producto as id_producto, a.codigo as codigo, b.nombre as nombre 
                FROM producto_barracodigo a 
                INNER JOIN producto b ON a.id_producto = b.id_producto
                WHERE a.codigo ='$codigo' AND a.borrado = 0";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }


    public function get_borrado_id($conn, $id)
    {
        $query="SELECT  a.id_producto as id_producto, a.codigo as codigo, b.nombre as nombre 
                FROM producto_barracodigo a 
                INNER JOIN producto b ON a.id_producto = b.id_producto
                WHERE a.id ='$id' AND a.borrado = 1";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }


    public function get_all_byproducto($conn, $id_producto)
    {
        $rows=array ();
        $query="SELECT  a.codigo as codigo, b.nombre as nombre 
                FROM producto_barracodigo a 
                INNER JOIN producto b ON a.id_producto = b.id_producto
                WHERE a.id_producto  ='$id_producto' AND a.borrado = 0";
        $result = mysql_query($query, $conn);

        while ($row=mysql_fetch_assoc($result))
        {
            $rows[]=$row;
        }
        return $rows;
    }
}