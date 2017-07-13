<?php

class Transferencialinea
{
    private $id_transferencialinea;
    private $id_transferencia;
    private $id_bodegaorigen;
    private $id_bodegadestino;
    private $id_producto;
    private $cantidad;
    

    public function __construct()
    {
        $this->id_transferencialinea=null;
        $this->id_transferencia=null;
        $this->id_bodegaorigen=null;
        $this->id_bodegadestino=null;
        $this->id_producto=null;
        $this->cantidad=null;
        
    }

    public function save($conn,$id_transferencia, $id_bodegaorigen, $id_bodegadestino, $id_producto, $cantidad)
    {
        $query="INSERT INTO transferencialinea VALUES (null,'$id_transferencia','$id_bodegaorigen','$id_bodegadestino','$id_producto','$cantidad')";
        $result= mysql_query($query, $conn);
		
		$quer="SELECT id_productobodega as id FROM productobodega WHERE id_producto='$id_producto' AND id_bodega = '$id_bodegadestino'";
		$res= mysql_query($quer,$conn);
		if(mysql_result($res,0,"id")==null){
			$queryi = "INSERT INTO productobodega VALUES (null, '$id_producto', '$id_bodegadestino', 0)";
			$resi = mysql_query($queryi,$conn);
		}
		
		
        return $result;
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

    public function get_id($conn, $id)
    {

        $query="SELECT id_transferencia, id_bodegaorigen, id_bodegadestino, id_producto, cantidad FROM transferencialinea WHERE id_transferencialinea ='$id'";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }


}
?>