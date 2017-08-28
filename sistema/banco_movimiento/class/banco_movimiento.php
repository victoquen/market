<?php

/**
 * Created by PhpStorm.
 * User: VICTOR OQUENDO
 * Date: 7/14/2017
 * Time: 3:18 PM
 */
class Banco_movimiento
{
    private $id;
    private $id_banco;
    private $operacion; //  1:ingreso, 2:egreso
    private $transaccion;
    private $descripcion;
    private $monto;
    private $fecha;
    private $borrado;


    public function __construct()
    {
        $this->id = null;
        $this->id_banco = null;
        $this->operacion = null;
        $this->transaccion = null;
        $this->descripcion = null;
        $this->monto = null;
        $this->fecha = null;
        $this->borrado = null;
    }

    public function save($conn, $id_banco, $operacion, $transaccion, $descripcion,$monto,$fecha)
    {
        $query="INSERT INTO banco_movimiento VALUES (null, '$id_banco','$operacion','$transaccion','$descripcion','$monto','$fecha','0')";
        $result= mysql_query($query, $conn);
        return $result;
    }


    public function update($conn, $id,  $id_banco, $operacion, $transaccion, $descripcion,$monto,$fecha)
    {


        $query = "UPDATE banco_movimiento SET  id_banco = '$id_banco', operacion = '$operacion', transaccion = '$transaccion', descripcion = '$descripcion', monto = '$monto', fecha = '$fecha'
                  WHERE id = '$id'";

        $result = mysql_query($query, $conn);

        return $result;

    }

    public function delete($conn, $id)
    {
        $query = "UPDATE banco_movimiento SET borrado = 1 WHERE id='$id'";
        $result = mysql_query($query, $conn);
        return $result;
    }

    public function get_id($conn, $id)
    {

        $query="SELECT a.id_banco, a.operacion, a.transaccion, a.descripcion, a.monto, a.fecha, b.nombre  FROM banco_movimiento a INNER JOIN banco b ON a.id_banco = b.id_banco WHERE id ='$id'";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

    public function get_borrado_id($conn, $id)
    {
        $query="SELECT a.id_banco, a.operacion, a.transaccion, a.descripcion, a.monto, a.fecha, b.nombre  FROM banco_movimiento a INNER JOIN banco b ON a.id_banco = b.id_banco WHERE a.id ='$id' AND a.borrado = 1";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }
}

?>