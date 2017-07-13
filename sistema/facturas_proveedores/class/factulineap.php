<?php

class Factulineap
{
    private $id_factulinea;
    private $id_factura;
    private $id_producto;
    private $cantidad;
    private $precio;
    private $dcto;
    private $subtotal;
    private $iva;
    private $utilidad;

    public function __construct()
    {
        $this->id_factulinea=null;
        $this->id_factura=null;
        $this->id_producto=null;
        $this->cantidad=null;
        $this->precio=null;
        $this->dcto=null;
        $this->subtotal=null;
        $this->iva = null;
        $this->utilidad = null;
    }

    public function save_factulinea($conn,$id_factura, $id_producto, $cantidad, $costo, $dcto, $subtotal,$iva,$utilidad,$idbodega)
    {
        $query="INSERT INTO factulineap VALUES (null,'$id_factura','$id_producto','$cantidad','$costo','$dcto','$subtotal','$iva','$utilidad','$idbodega')";
        $result= mysql_query($query, $conn);
        $id=mysql_insert_id();

		
		$quer="SELECT id_productobodega as id FROM productobodega WHERE id_producto='$id_producto' AND id_bodega = '$idbodega'";
		$res= mysql_query($quer,$conn);
		if(mysql_result($res,0,"id")==null){
			$queryi = "INSERT INTO productobodega VALUES (null, '$id_producto', '$idbodega', 0)";
			$resi = mysql_query($queryi,$conn);
		}
		
		
        return $id;
    }

    /*public function delete_factulinea($conn, $idfactulinea)
    {
        $query = "delete from factulinea  WHERE id_factulinea='$idfactulinea'";
        $result = mysql_query($query, $conn);
        return $result;
    }

    public function update_factulinea($conn, $idfactulinea, $id_factura, $id_producto, $cantidad, $precio, $dcto, $subtotal)
    {

        $query = "UPDATE factulinea SET id_factura = '$id_factura', id_producto = '$id_producto', cantidad = '$cantidad',
                                      precio = '$precio', dcto = '$dcto',subtotal = '$subtotal'
                  WHERE id_factulinea = '$idfactulinea'";

        $result = mysql_query($query, $conn);

        return $result;

    }*/

    public function get_factulinea_id($conn, $id)
    {
        $rows;
        $query="SELECT idfactura_venta, id_producto, cantidad, precio, dcto, subtotal FROM factulineap WHERE id_factulinea ='$id' AND borrado = 0";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }


}
?>