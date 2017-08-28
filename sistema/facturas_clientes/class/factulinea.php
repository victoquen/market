<?php

class Factulinea
{
    private $id_factulinea;
    private $id_factura;
    private $id_producto;
    private $cantidad;
    private $precio;
    private $dcto;
    private $subtotal;
	private $id_bodega;
	
	

    public function __construct()
    {
        $this->id_factulinea=null;
        $this->id_factura=null;
        $this->id_producto=null;
        $this->cantidad=null;
        $this->precio=null;
        $this->dcto=null;
        $this->subtotal=null;
		$this->id_bodega = null;
    }

    /*public function save_factulinea($conn,$id_factura, $id_producto, $cantidad, $costo, $precio, $dcto, $subtotal,$iva)
    {
        $query="INSERT INTO factulinea VALUES (null,'$id_factura','$id_producto','$cantidad','$costo','$precio','$dcto','$subtotal','$iva')";
        $result= mysql_query($query, $conn);
        return $result;
    }*/

	public function save_factulinea($conn,$id_factura, $id_producto, $cantidad, $costo, $precio, $dcto, $subtotal,$iva, $idbodega)
    {
        $query="INSERT INTO factulinea VALUES (null,'$id_factura','$id_producto','$cantidad','$costo','$precio','$dcto','$subtotal','$iva', '$idbodega')";
        $result= mysql_query($query, $conn);
        $id=mysql_insert_id();
        return $id;

    }
	
	
    public function delete_factulinea($conn, $idfactulinea)
    {
        $query = "delete from factulinea  WHERE id_factulinea='$idfactulinea'";
        $result = mysql_query($query, $conn);
        return $result;
    }

    public function update_factulinea($conn, $idfactulinea, $id_producto, $cantidad, $costo, $precio, $dcto, $subtotal, $iva, $idbodega)
    {

        $query = "UPDATE factulinea SET  id_producto = '$id_producto', cantidad = '$cantidad',
                                      costo='$costo', precio = '$precio', dcto = '$dcto',subtotal = '$subtotal', iva = '$iva', id_bodega = '$idbodega'
                  WHERE id_factulinea = '$idfactulinea'";

        $result = mysql_query($query, $conn);

        return $result;

    }

    public function get_factulinea_id($conn, $id)
    {
      
        $query="SELECT idfactura_venta, id_producto, cantidad, precio, dcto, subtotal, id_bodega FROM factulinea WHERE id_factulinea ='$id' AND borrado = 0";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }


}
?>