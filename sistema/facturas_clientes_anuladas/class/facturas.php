<?php

class Factura
{
    private $id_factura;
    private $id_cliente;
    private $codigo_factura;
    private $fecha;
    private $iva;
    private $totalfactura;
    private $retencion;
    private $totalretencion;
    private $anulado;

    public function __construct()
    {
        $this->id_factura=null;
        $this->id_cliente=null;
        $this->codigo_factura=null;
        $this->fecha=null;
        $this->iva=null;
        $this->totalfactura=null;
        $this->retencion=null;
        $this->totalretencion=null;
        $this->anulado=null;
    }

    public function save_factura($conn, $id_cliente, $codigo_factura, $fecha, $iva, $totalfactura, $retencion, $totalretencion)
    {
        $query="INSERT INTO facturas VALUES (null,'$id_cliente','$codigo_factura','$fecha','$iva','$totalfactura','$retencion','$totalretencion',0)";
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

    /*public function update_factura($conn, $idfactura, $id_cliente, $codigo_factura, $fecha, $iva, $totalfactura, $retencion, $totalretencion)
    {

        $query = "UPDATE facturas SET id_cliente = '$id_cliente', codigo_factura = '$codigo_factura', fecha = '$fecha',
                                      iva = '$iva', totalfactura = '$totalfactura',retencion = '$retencion',totalretencion = '$totalretencion',
                  WHERE id_factura = '$idfactura'";

        $result = mysql_query($query, $conn);

        return $result;

    }*/

    public function get_factura_id($conn, $id)
    {
        $rows;
        $query="SELECT id_cliente, codigo_factura, fecha, iva, totalfactura, retencion, totalretencion FROM facturas WHERE id_factura ='$id' AND anulado = 0";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

    public function get_factura_borrado_id($conn, $id)
    {
        $rows;
        $query="SELECT id_cliente, codigo_factura, fecha, iva, totalfactura, retencion, totalretencion FROM facturas WHERE id_factura ='$id' AND anulado = 1";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }
}
?>