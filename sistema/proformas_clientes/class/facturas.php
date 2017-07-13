<?php

class Factura
{

    private $id_factura;
    private $id_cliente;
    private $codigo_factura;
    private $serie1;
    private $serie2;
    private $autorizacion;
    private $fecha;
    private $descuentototal;
    private $iva0;
    private $iva12;
    private $importeiva;
    private $flete;
    private $preciototal;
    private $credito;
    private $plazo;
     


    public function __construct()
    {
        $this->id_factura=null;
        $this->id_cliente=null;
        $this->codigo_factura=null;
        $this->serie1=null;
        $this->serie2=null;
        $this->autorizacion=null;
        $this->fecha=null;
        $this->descuentototal=null;
        $this->iva0=null;
        $this->iva12=null;
        $this->importeiva=null;
        $this->flete=null;
        $this->preciototal=null;
        $this->credito=null;
        $this->plazo=null;
    }

    public function save_factura($conn, $id_cliente, $codigo_factura,$serie1,$serie2,$autorizacion, $fecha, $descuento,$iva0, $iva12,$iva,$flete,$totalfactura, $credito, $plazo,$remision)
    {
        $query="INSERT INTO proformas VALUES (null,'$id_cliente','$codigo_factura','$serie1','$serie2','$autorizacion','$fecha','$descuento','$iva0','$iva12',
                                             '$iva','$flete','$totalfactura','$credito','$plazo',0,0,'$remision')";
        $result= mysql_query($query, $conn);
        $codfactura=mysql_insert_id();
        return $codfactura;
    }

    public function delete_factura($conn, $idfactura)
    {
        $query = "UPDATE proformas SET anulado = 1 WHERE id_factura='$idfactura'";
        $result = mysql_query($query, $conn);
        return $result;
    }

    public function update_factura($conn, $idfactura, $id_cliente, $codigo_factura,$serie1,$serie2,$autorizacion, $fecha, $descuento,$iva0, $iva12,$iva,$flete,$totalfactura, $remision)
    {

        $query = "UPDATE proformas SET id_cliente = '$id_cliente', codigo_factura = '$codigo_factura',serie1='$serie1', serie2='$serie2', 
                                      autorizacion='$autorizacion', fecha = '$fecha', descuento='$descuento', iva0='$iva0', iva12='$iva12', 
                                      iva = '$iva', flete='$flete', totalfactura = '$totalfactura',remision='$remision'
                  WHERE id_factura = '$idfactura'";

        $result = mysql_query($query, $conn);

        return $result;

    }

    public function get_factura_id($conn, $id)
    {
        $rows;
        $query="SELECT id_cliente,codigo_factura,serie1,serie2,autorizacion,fecha,descuento,iva0,iva12,iva,flete,totalfactura,credito,plazo
                FROM proformas
                WHERE id_factura ='$id' AND anulado = 0";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

    public function get_factura_borrado_id($conn, $id)
    {
        $rows;
        $query="SELECT id_cliente,codigo_factura,serie1,serie2,autorizacion,fecha,descuento,iva0,iva12,iva,flete,totalfactura,credito,plazo
                FROM proformas
                WHERE id_factura ='$id' AND anulado = 1";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }
}
?>