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
    
    //campos retenciones en venta
    private $ret_iva;
    private $ret_fuente;
    
    //facturero
    private $idfacturero;
     


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
        $this->ret_iva=null;
        $this->ret_fuente=null;
        $this->idfacturero = null;
    }

    public function save_factura($conn, $id_cliente, $codigo_factura,$serie1,$serie2,$autorizacion, $fecha, $descuento,$iva0, $iva12,$iva,$flete,$totalfactura, $credito, $plazo,$remision, $codigo_retencion, $ret_iva, $ret_fuente, $idfacturero)
    {
        $query="INSERT INTO facturas VALUES (null,'$id_cliente','$codigo_factura','$serie1','$serie2','$autorizacion','$fecha','$descuento','$iva0','$iva12',
                                             '$iva','$flete','$totalfactura','$credito','$plazo',0,0,'$remision','$codigo_retencion','$ret_iva','$ret_fuente', '$idfacturero')";

       
        $result= mysql_query($query, $conn);
        $codfactura=mysql_insert_id();
        return $codfactura;
    }

    public function delete_factura($conn, $idfactura)
    {
        $query = "UPDATE facturas SET anulado = 1 WHERE id_factura='$idfactura'";
        $result = mysql_query($query, $conn);
        return $result;
    }

    public function update_factura($conn, $idfactura, $id_cliente, $codigo_factura,$serie1,$serie2,$autorizacion, $fecha, $descuento,$iva0, $iva12,$iva,$flete,$totalfactura, $remision, $codigo_retencion, $ret_iva, $ret_fuente, $idfacturero)
    {

        $query = "UPDATE facturas SET id_cliente = '$id_cliente', codigo_factura = '$codigo_factura',serie1='$serie1', serie2='$serie2', 
                                      autorizacion='$autorizacion', fecha = '$fecha', descuento='$descuento', iva0='$iva0', iva12='$iva12', 
                                      iva = '$iva', flete='$flete', totalfactura = '$totalfactura',remision='$remision', codigo_retencion ='$codigo_retencion', ret_iva = '$ret_iva', ret_fuente='$ret_fuente', id_facturero='$idfacturero'
                  WHERE id_factura = '$idfactura'";

        $result = mysql_query($query, $conn);

        return $result;

    }

    public function update_factura_bucle($conn, $idfactura, $descuento,$iva0, $iva12,$iva,$flete,$totalfactura,  $ret_iva, $ret_fuente, $estado)
    {

        $query = "UPDATE facturas SET  descuento='$descuento', iva0='$iva0', iva12='$iva12', 
                                      iva = '$iva', flete='$flete', totalfactura = '$totalfactura', ret_iva = '$ret_iva', ret_fuente='$ret_fuente', estado ='$estado'
                  WHERE id_factura = '$idfactura'";

        $result = mysql_query($query, $conn);

        return $result;

    }


    public function get_factura_id($conn, $id)
    {

        $query="SELECT id_cliente,codigo_factura,serie1,serie2,autorizacion,fecha,descuento,iva0,iva12,iva,flete,totalfactura,credito,plazo
                FROM facturas
                WHERE id_factura ='$id' AND anulado = 0";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

    public function get_factura_borrado_id($conn, $id)
    {

        $query="SELECT id_cliente,codigo_factura,serie1,serie2,autorizacion,fecha,descuento,iva0,iva12,iva,flete,totalfactura,credito,plazo
                FROM facturas
                WHERE id_factura ='$id' AND anulado = 1";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }
}
?>