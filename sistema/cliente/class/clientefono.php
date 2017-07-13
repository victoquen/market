<?php

class Clientefono
{
    private $id_telefono;
    private $id_cliente;
    private $numero;
    private $descripcion;
    private $operadora;
    private $borrado;

    public function __construct()
    {
        $this->id_telefono=null;
        $this->id_cliente=null;
        $this->numero=null;
        $this->descripcion=null;
        $this->operadora=null;
        $this->borrado=null;
    }

    public function save_telefono($conn, $id_cliente, $numero, $descripcion, $operadora)
    {        

        $query="INSERT INTO clientefono VALUES (null,'$id_cliente','$numero','$descripcion','$operadora')";
        $result= mysql_query($query, $conn);
        return $result;
    }

    public function delete_telefono($conn, $idtelefono)
    {
        $query = "DELETE FROM clientefono WHERE id_telefono='$idtelefono'";
        $result = mysql_query($query, $conn);
        return $result;
    }

    public function update_telefono($conn, $idtelefono, $id_cliente, $numero, $descripcion, $operadora)
    {

        $query = "UPDATE clientefono SET id_cliente='$id_cliente', numero = '$numero',descripcion = '$descripcion',
                                     operadora='$operadora'
                  WHERE id_telefono = '$idtelefono'";

        $result = mysql_query($query, $conn);

        return $result;

    }

    public function get_telefono_id($conn, $id)
    {
   
        $query="SELECT  id_cliente, numero, descripcion, operadora
                FROM clientefono
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