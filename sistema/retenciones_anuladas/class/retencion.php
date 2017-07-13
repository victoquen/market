<?php

class Retencion
{




    private $id_retencion;
    private $id_factura;
    private $serie1;
    private $serie2;
    private $codigo_retencion;
    private $autorizacion;
    private $concepto;
    private $totalretencion;
    private $fecha;
    private $anulado;






    public function __construct()
    {
        $this->id_retencion=null;
        $this->id_factura=null;

        $this->serie1=null;
        $this->serie2=null;
        $this->codigo_retencion;
        $this->autorizacion=null;
        $this->concepto=null;
        $this->totalretencion=null;
        $this->fecha=null;
        $this->anulado = null;
    }

    public function save_retencion($conn, $id_retencion, $serie1,$serie2,$codigo_retencion,$autorizacion,$concepto,$totalretencion,$fecha)
    {
        $query="INSERT INTO retencion VALUES (null,'$id_retencion','$serie1','$serie2','$codigo_retencion','$autorizacion','$concepto','$totalretencion','$fecha',0)";
        $result= mysql_query($query, $conn);
        $codretencion=mysql_insert_id();
        return $codretencion;
    }



    public function update_retencion($conn, $idretencion, $concepto, $totalretencion)
    {

        $query = "UPDATE retencion SET concepto = '$concepto', totalretencion = '$totalretencion'
                  WHERE id_retencion = '$idretencion'";

        $result = mysql_query($query, $conn);

        return $result;

    }

    public function get_retencion_id($conn, $id)
    {
        $rows;
        $query="SELECT id_factura,codigo_retencion,serie1,serie2, autorizacion,concepto,totalretencion,fecha
                FROM retencion
                WHERE id_retencion ='$id'";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }
    
    public function anular_retencion($conn, $idretencion)
    {

        $query = "UPDATE retencion SET anulado = 1
                  WHERE id_retencion = '$idretencion'";

        $result = mysql_query($query, $conn);

        return $result;

    }

}
?>