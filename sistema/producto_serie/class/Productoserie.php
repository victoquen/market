<?php

/**
 * Created by PhpStorm.
 * User: VICTOR OQUENDO
 * Date: 5/16/2017
 * Time: 9:15 PM
 */
class Productoserie
{

    private $id;
    private $id_productobodega;
    private $serie;
    private $estado; //0 disponible -- 1 vendido
    private $borrado; //0 No -- 1 Si

    private $id_producto;
    private $id_bodega;
    private $leyenda_producto;
    private $leyenda_bodega;



    /**
     * Productoserie constructor.
     */
    public function __construct()
    {
        $this->serie = "";
        $this->estado = 0;  //0 disponible -- 1 vendido
        $this->borrado = 0; //0 No -- 1 Si

    }

    public function save($conn, $id_productobodega, $serie, $linea){

        $query="INSERT INTO productoserie VALUES (null,'$id_productobodega','$serie','0','0','0',$linea)";
        $result= mysql_query($query, $conn);
        $id=mysql_insert_id();

        return $id;
    }

    public function delete($conn, $id)
    {
        $query = "UPDATE productoserie SET borrado = 1 WHERE id='$id'";
        $result = mysql_query($query, $conn);
        return $result;
    }

    public function update($conn, $id, $id_productobodega, $serie)
    {
        $query = "UPDATE productoserie SET id_productobodega = '$id_productobodega', serie = '$serie'
                  WHERE id = '$id'";
        $result = mysql_query($query, $conn);

        return $result;
    }

    public function vendido($conn, $id, $linea)
    {
        $query = "UPDATE productoserie SET estado = 1, id_factulinea = '$linea' WHERE id='$id'";
        //$query = "UPDATE productoserie SET estado = 1, id_factulinea = '$linea' WHERE serie='$id'";
        $result = mysql_query($query, $conn);
        return $result;
    }

    public function transferencia($conn, $id_productobodega, $id)
    {
        $query = "UPDATE productoserie 
                  SET id_productobodega = '$id_productobodega'
                  WHERE id ='$id'";
        $result = mysql_query($query, $conn);
        return $result;
    }

    public function get_id($conn, $id)
    {

        $query="SELECT s.serie as serie, b.nombre as leyendabodega, p.nombre as leyendaproducto, pb.id_bodega as idbodega, pb.id_producto as idproducto 
                FROM productoserie s 
                INNER JOIN productobodega pb ON s.id_productobodega = pb.id_productobodega 
                INNER JOIN bodega b ON pb.id_bodega = b.id_bodega 
                INNER JOIN producto p ON pb.id_producto = p.id_producto 
                WHERE s.id ='$id' AND s.borrado = 0";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

    public function get_all_productobodega($conn, $id_productobodega)
    {
        $rows=array ();
        $query="SELECT s.serie as serie, b.nombre as leyendabodega, p.nombre as leyendaproducto, pb.id_bodega as idbodega, pb.id_producto as idproducto 
                FROM productoserie s 
                INNER JOIN productobodega pb ON s.id_productobodega = pb.id_productobodega 
                INNER JOIN bodega b ON pb.id_bodega = b.id_bodega 
                INNER JOIN producto p ON pb.id_producto = p.id_producto 
                WHERE s.id_productobodega  ='$id_productobodega' AND s.borrado = 0";
        $result = mysql_query($query, $conn);

        while ($row=mysql_fetch_assoc($result))
        {
            $rows[]=$row;
        }
        return $rows;
    }

}