<?php

class Facturap
{




    private $id_facturap;
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
    private $tipocomprobante;
    private $retencion;



    public function __construct()
    {
        $this->id_facturap=null;
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
        $this->tipocomprobante=null;
        $this->retencion=null;
    }

//    public function save_factura($conn, $id_proveedor, $codigo_factura,$serie1,$serie2,$autorizacion, $fecha, $descuento,$iva0, $iva12,$iva,$flete,$totalfactura, $credito, $plazo, $tipocomprobante,$retencion)
//    {
//        $query="INSERT INTO facturasp_consig VALUES ('','$id_proveedor','$codigo_factura','$serie1','$serie2','$autorizacion','$fecha','$descuento','$iva0','$iva12',
//                                             '$iva','$flete','$totalfactura','$credito','$plazo','$tipocomprobante',0,0,'$retencion')";
//        $result= mysql_query($query, $conn);
//        $codfactura=mysql_insert_id();
//        return $codfactura;
//    }

    public function save_factura($conn, $id_proveedor, $codigo_factura,$serie1,$serie2,$autorizacion, $fecha, $descuento,$iva0, $iva12,$iva,$flete,$totalfactura, $credito, $plazo, $tipocomprobante,$retencion)
    {
        $query="INSERT INTO facturasp_consig VALUES (null,'$id_proveedor','$codigo_factura','$serie1','$serie2','$autorizacion','$fecha','$descuento','$iva0','$iva12',
                                             '$iva','$flete','$totalfactura',0,0)";
        $result= mysql_query($query, $conn);
        $codfactura=mysql_insert_id();
        return $codfactura;
    }


    public function delete_factura($conn, $idfacturap)
    {
        $query = "UPDATE facturasp_consig SET anulado = 1 WHERE id_facturap='$idfacturap'";
        $result = mysql_query($query, $conn);
        return $result;
    }

    /*public function update_factura($conn, $idfactura, $id_cliente, $codigo_factura, $fecha, $iva, $totalfactura, $retencion, $totalretencion)
    {

        $query = "UPDATE facturas SET id_cliente = '$id_cliente', codigo_factura = '$codigo_factura', fecha = '$fecha',
                                      iva = '$iva', totalfactura = '$totalfactura',retencion = '$retencion',totalretencion = '$totalretencion',
                  WHERE id_factura = '$idfactura'";

        $result = mysql_query($query, $conn);

        return $result;

    }*/

//    public function get_factura_id($conn, $id)
//    {
//        $rows;
//        $query="SELECT id_cliente,codigo_factura,serie1,serie2,autorizacion,fecha,descuento,iva0,iva12,iva,flete,totalfactura,credito,plazo,tipocomprobante,retencion
//                FROM facturasp_consig
//                WHERE id_facturap ='$id' AND anulado = 0";
//        $result = mysql_query($query, $conn);
//        $row = mysql_fetch_assoc($result);
//        return $row;
//    }


    public function get_factura_id($conn, $id)
    {
        $rows;
        $query="SELECT id_cliente,codigo_factura,serie1,serie2,autorizacion,fecha,descuento,iva0,iva12,iva,flete,totalfactura
                FROM facturasp_consig
                WHERE id_facturap ='$id' AND anulado = 0";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

//    public function get_factura_borrado_id($conn, $id)
//    {
//        $rows;
//        $query="SELECT id_cliente,codigo_factura,serie1,serie2,autorizacion,fecha,descuento,iva0,iva12,iva,flete,totalfactura,credito,plazo,tipocomprobante,retencion
//                FROM facturasp_consig
//                WHERE id_facturap ='$id' AND anulado = 1";
//        $result = mysql_query($query, $conn);
//        $row = mysql_fetch_assoc($result);
//        return $row;
//    }

    public function get_factura_borrado_id($conn, $id)
    {
        $rows;
        $query="SELECT id_cliente,codigo_factura,serie1,serie2,autorizacion,fecha,descuento,iva0,iva12,iva,flete,totalfactura
                FROM facturasp_consig
                WHERE id_facturap ='$id' AND anulado = 1";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }
}
?>