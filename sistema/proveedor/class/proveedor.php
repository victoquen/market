<?php

class Proveedor
{
    private $id_proveedor;
    private $ci_ruc;
    private $empresa;
    private $representante; 
    private $email;
    private $web;
    private $direccion;
    private $autorizacion;
    private $fecha_caducidad;
    

    public function __construct()
    {
        $this->id_proveedor=null;
        $this->id_proveedor=null;
        $this->ci_ruc=null;
        $this->empresa=null;
        $this->representante=null;        
        $this->email=null;
        $this->web=null;
        $this->direccion=null;
        $this->autorizacion=null;
        $this->fecha_caducidad=null;
    }

    public function save_proveedor($conn, $ci_ruc,$empresa, $representante,$email,$web,$direccion,$lugar, $autorizacion, $fecha_caducidad)
    {        
        
        $query="INSERT INTO proveedor VALUES (null,'$ci_ruc','$empresa','$representante','$email','$web','$direccion','$lugar','0',$autorizacion, $fecha_caducidad)";
        $result= mysql_query($query, $conn);
        $idproveedor=mysql_insert_id();
        return $idproveedor;
    }

    public function delete_proveedor($conn, $idproveedor)
    {
        $query = "UPDATE proveedor SET borrado = 1 WHERE id_proveedor='$idproveedor'";
        $result = mysql_query($query, $conn);
        return $result;
    }

    public function update_proveedor($conn, $idproveedor, $ci_ruc,$empresa, $representante,$email,$web,$direccion, $lugar, $autorizacion, $fecha_caducidad)
    {

        $query = "UPDATE proveedor SET ci_ruc = '$ci_ruc',empresa='$empresa', representante='$representante',email='$email',web='$web',
                                        direccion='$direccion', lugar='$lugar', autorizacion = '$autorizacion', fecha_caducidad = '$fecha_caducidad' 
                  WHERE id_proveedor = '$idproveedor'";

        $result = mysql_query($query, $conn);

        return $result;

    }

    public function get_proveedor_id($conn, $id)
    {

        $query="SELECT  ci_ruc ,empresa, representante,email,web,direccion, lugar, autorizacion, fecha_caducidad
                FROM proveedor
                WHERE id_proveedor ='$id' AND borrado = 0";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }
     public function get_proveedor_borrado_id($conn, $id)
    {

        $query="SELECT ci_ruc ,empresa, representante,email,web,direccion, lugar, autorizacion, fecha_caducidad
                FROM proveedor 
                WHERE id_proveedor ='$id' AND borrado = 1";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

}
?>