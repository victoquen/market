<?php

class remision
{




    private $id_remision;
    private $id_factura;
    private $serie1;
    private $serie2;
    private $codigo_remision;
    private $autorizacion;
    private $fecha_fin;
    private $motivo;
    private $punto_partida;
    private $nombre_trans;
    private $ci_trans;
    





    public function __construct()
    {
        $this->id_remision=null;
        $this->id_factura=null;

        $this->serie1=null;
        $this->serie2=null;
        $this->codigo_remision;
        $this->autorizacion=null;
        $this->fecha_fin=null;
        $this->motivo=null;
        $this->punto_partida=null;
        $this->nombre_trans=null;
        $this->ci_trans=null;
    }

    public function save_remision($conn, $idfactura, $serie1,$serie2,$codremision,$autorizacion,$fecha_fin,$motivo,$punto_partida,$nombre_trans,$ci_trans)
    {
        $query="INSERT INTO remision VALUES (null,'$idfactura','$serie1','$serie2','$codremision','$autorizacion','$fecha_fin','$motivo','$punto_partida','$nombre_trans','$ci_trans')";
        $result= mysql_query($query, $conn);
        $codremision=mysql_insert_id();
        return $codremision;
    }



    public function update_remision($conn, $idremision, $fecha_fin,$motivo,$punto_partida,$nombre_trans,$ci_trans)
    {

        $query = "UPDATE remision SET fecha_fin = '$fecha_fin', motivo = '$motivo', punto_partida='$punto_partida', nombre_trans='$nombre_trans', ci_trans='$ci_trans'
                  WHERE id_remision = '$idremision'";

        $result = mysql_query($query, $conn);

        return $result;

    }

    public function get_remision_id($conn, $id)
    {
  
        $query="SELECT id_factura,codigo_remision,serie1,serie2, autorizacion,fecha_fin,motivo,punto_partida,nombre_trans,ci_trans
                FROM remision
                WHERE id_remision ='$id'";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

}
?>