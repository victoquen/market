<?php

class Producto
{
    private $id_producto;
    private $codigo;
    private $nombre;
    private $iva;
    private $stock;
    private $costo;
    private $pvp;
    private $fecha_caducidad;
    private $observacion;
    private $proveedor;
    private $total;

    public function __construct()
    {
        $this->id_producto=null;
        $this->codigo=null;
        $this->nombre=null;
        $this->iva=null;
        $this->stock=null;
        $this->costo=null;
        $this->pvp=null;
        $this->fecha_caducidad=null;
        $this->observacion=null;
        $this->proveedor=null;
        $this->total=null;
    }

    public function save_producto($conn, $codigo, $nombre, $stock, $costo, $pvp, $iva,  $composicion,$aplicacion, $proveedor,$grupo, $subgrupo,$stock_consignacion,$utilidad)
    {
        $this->codigo=strtoupper($codigo);
        $this->nombre=strtoupper($nombre);
        $compo=strtoupper($composicion);
        $apli=strtoupper($aplicacion);

        $query="INSERT INTO producto VALUES (null,'$this->codigo','$this->nombre','$stock','$costo','$pvp','$iva','$compo','$apli','$proveedor','$grupo','$subgrupo','$stock_consignacion','0','2','0','$utilidad')";
        $result= mysql_query($query, $conn);
        $id_producto=mysql_insert_id();
        return $id_producto;
    }

    public function delete_producto($conn, $idproducto)
    {
        $query = "UPDATE producto SET borrado = 1 WHERE id_producto='$idproducto'";
        $result = mysql_query($query, $conn);
        return $result;
    }

    public function update_producto($conn, $idproducto, $stock, $costo, $pvp,$iva,$utilidad)
    {
        
        
        $query = "UPDATE producto SET  stock = stock + '$stock',
                                      costo = '$costo', pvp = '$pvp',iva='$iva',utilidad='$utilidad'
                  WHERE id_producto = '$idproducto'";

        $result = mysql_query($query, $conn);

        return $result;
    }

//     public function update_producto($conn, $idproducto, $codigo, $nombre, $stock, $costo, $pvp,$iva,$composicion,$aplicacion, $proveedor,$grupo, $subgrupo,$stock_consignacion)
//    {
//        $this->codigo=strtoupper($codigo);
//        $this->nombre=strtoupper($nombre);
//        $compo=strtoupper($composicion);
//        $apli=strtoupper($aplicacion);
//        $query = "UPDATE producto SET codigo = '$this->codigo', nombre = '$this->nombre', stock = stock + '$stock',
//                                      costo = '$costo', pvp = '$pvp',iva='$iva',composicion = '$compo',aplicacion ='$apli',
//                                      proveedor = '$proveedor',grupo='$grupo',subgrupo='$subgrupo', stock_consignacion='$stock_consignacion'
//                  WHERE id_producto = '$idproducto'";
//
//        $result = mysql_query($query, $conn);
//
//        return $result;
//
//    }

    public function get_producto_id($conn, $id)
    {

        $query="SELECT codigo, nombre, stock, costo, pvp, iva,  composicion, aplicacion, proveedor, grupo, subgrupo, stock_consignacion, utilidad FROM producto WHERE id_producto ='$id' AND borrado = 0";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

    public function get_producto_borrado_id($conn, $id)
    {
        
        $query="SELECT codigo, nombre, stock, costo, pvp, iva,  composicion, aplicacion, proveedor, grupo, subgrupo, stock_consignacion, utilidad FROM producto WHERE id_producto ='$id' AND borrado = 1";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }
}
?>