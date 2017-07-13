<?php

class Cliente
{
    private $id_cliente;
    private $id_tipocliente;
    private $nombre;
    private $empresa;
    private $ci_ruc;
    private $email;
    private $direccion;
    private $lugar;
    private $credito;
    private $borrado;
    private $image;

    public function __construct()
    {
        $this->id_cliente=null;
        $this->id_tipocliente=null;
        $this->nombre=null;
        $this->empresa=null;
        $this->ci_ruc=null;        
        $this->email=null;
        $this->direccion=null;
        $this->lugar=null;
        $this->credito=null;
        $this->borrado=null;
        $this->image=null;
    }

    public function save_cliente($conn, $id_tipocliente, $nombre, $empresa, $ci_ruc, $email, $direccion,$lugar, $credito, $image)
    {        
        $this->nombre=strtoupper($nombre);
        $this->empresa=strtoupper($empresa);
        $query="INSERT INTO cliente VALUES (null,'$id_tipocliente','$this->nombre','$this->empresa', '$ci_ruc','$email','$direccion','0','$lugar','$credito','$image')";
        $result= mysql_query($query, $conn);
        $idcliente=mysql_insert_id();
        return $idcliente;
    }

    public function delete_cliente($conn, $idcliente)
    {
        $query = "UPDATE cliente SET borrado = 1 WHERE id_cliente='$idcliente'";
        $result = mysql_query($query, $conn);
        return $result;
    }

    public function update_cliente($conn, $id_tipocliente, $idcliente, $nombre, $empresa, $ci_ruc, $email, $direccion, $lugar, $credito,$image)
    {
        $this->nombre=strtoupper($nombre);
        $this->empresa=strtoupper($empresa);
        $query = "UPDATE cliente SET codigo_tipocliente='$id_tipocliente', nombre = '$this->nombre',empresa='$this->empresa',ci_ruc = '$ci_ruc',
                                     email='$email',direccion='$direccion',lugar='$lugar',credito='$credito', image='$image'
                  WHERE id_cliente = '$idcliente'";

        $result = mysql_query($query, $conn);

        return $result;

    }

    public function get_cliente_id($conn, $id)
    {
    
        $query="SELECT  codigo_tipocliente, nombre, empresa, ci_ruc, email, direccion, lugar,(if(credito=0,'NO','SI'))as credito, image
                FROM cliente 
                WHERE id_cliente ='$id' AND borrado = 0";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }
     public function get_cliente_borrado_id($conn, $id)
    {

        $query="SELECT  b.nombre as tipocliente, a.nombre as nombre, a.empresa as empresa, a.ci_ruc as ci_ruc,a.email as email, a.direccion as direccion, a.lugar, (if(a.credito=0,'NO','SI'))as credito, a.image as image
                FROM cliente a INNER JOIN tipo_cliente b ON a.codigo_tipocliente = b.codigo_tipocliente
                WHERE a.id_cliente ='$id' AND a.borrado = 1";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

    public function get_nombretipo($cod, $conn)
    {
        $query = "SELECT codigo_tipocliente, nombre FROM tipo_cliente WHERE codigo_tipocliente='$cod' AND borrado = 0";
        $result= mysql_query($query, $conn);
        $row=mysql_fetch_assoc($result);
        return $row;
    }


    public function listado_tipocliente($conn)
    {
        $rows=array ();
        $query = "SELECT codigo_tipocliente, nombre FROM tipo_cliente WHERE borrado = 0";
        $result= mysql_query($query, $conn);
        while ($row=mysql_fetch_assoc($result))
        {
            $rows[]=$row;
        }
        return $rows;
    }

}
?>