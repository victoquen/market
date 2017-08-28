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
    private $pvp2;
    private $pvp3;
    private $pvp4;
    private $fecha_caducidad;
    private $observacion;
    private $proveedor;
    private $total;
    private $utilidad;
    

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
        $this->utilidad=null;
    }

    public function save_producto($conn, $codigo, $nombre, $stock, $costo, $pvp, $iva,  $composicion,$aplicacion, $proveedor,$grupo, $subgrupo,$stock_consignacion,$gasto,$utilidad,$idbodega, $moto, $pvp2, $pvp3, $pvp4, $unidad, $uxpaca, $lector)
    {
        //$this->codigo=strtoupper($codigo);
        //$this->nombre=strtoupper($nombre);

        $ccdaux = strtoupper($codigo);
        $nnaux = strtoupper($nombre);
        $compo=strtoupper($composicion);
        $apli=strtoupper($aplicacion);

        $query="INSERT INTO producto VALUES (null,'$ccdaux','$nnaux','$stock','$costo','$pvp','$iva','$compo','$apli','$proveedor','$grupo','$subgrupo','$stock_consignacion','0','0','$gasto','$utilidad','$moto','$pvp2','$pvp3','$pvp4','$unidad','$uxpaca')";
        $result= mysql_query($query, $conn);
        $id_producto=mysql_insert_id();
		
		$query_bp="INSERT INTO productobodega VALUES (null,'$id_producto','$idbodega','$stock')";
        $result_bp= mysql_query($query_bp, $conn);
        $id_producto_bodega=mysql_insert_id();


        $query_l = "SELECT COUNT(id_producto) as total FROM producto_barracodigo WHERE codigo = '$lector'";
        $result_l = mysql_query($query_l,$conn);
        $tot = mysql_result($result_l,0,"total");
        if(($tot==0)&&($lector!="")){
            $q_lector = "INSERT INTO producto_barracodigo VALUES (null, '$id_producto', '$lector','0')";
            $res_l =mysql_query($q_lector, $conn);

        }else{
            echo "<script>";
            echo "alert('CODIGO DE BARRAS YA EXISTE');";
            echo "</script>";
        }

        return $id_producto;
    }

    public function delete_producto($conn, $idproducto)
    {
        $query = "UPDATE producto SET borrado = 1 WHERE id_producto='$idproducto'";
        $result = mysql_query($query, $conn);
        return $result;
    }

    public function update_producto($conn, $idproducto, $codigo, $nombre, $stock, $costo, $pvp,$iva,$composicion,$aplicacion, $proveedor,$grupo, $subgrupo,$stock_consignacion,$gasto,$utilidad,$moto, $pvp2, $pvp3, $pvp4, $unidad, $uxpaca,$lector)
    {
        $this->codigo=strtoupper($codigo);
        $this->nombre=strtoupper($nombre);
        $compo=strtoupper($composicion);
        $apli=strtoupper($aplicacion);
        $query = "UPDATE producto SET codigo = '$this->codigo', nombre = '$this->nombre', stock = '$stock',
                                      costo = '$costo', pvp = '$pvp',iva='$iva',composicion = '$compo',aplicacion ='$apli',
                                      proveedor = '$proveedor',grupo='$grupo',subgrupo='$subgrupo', stock_consignacion='$stock_consignacion',
                                      gasto='$gasto',utilidad='$utilidad',moto='$moto',
                                      pvp2 = '$pvp2', pvp3 = '$pvp3', pvp4 = '$pvp4', unidad = '$unidad', uxpaca = '$uxpaca'
                  WHERE id_producto = '$idproducto'";
        $result = mysql_query($query, $conn);

        $query_l = "SELECT COUNT(id_producto) as total FROM producto_barracodigo WHERE codigo = '$lector'";
        $result_l = mysql_query($query_l,$conn);
        $tot = mysql_result($result_l,0,"total");
        if(($tot==0)&&($lector!="")){
            $q_lector = "INSERT INTO producto_barracodigo VALUES (null, '$idproducto', '$lector','0')";
            $res_l =mysql_query($q_lector, $conn);

        }else{
            echo "<script>";
            echo "alert('CODIGO DE BARRAS YA EXISTE');";
            echo "</script>";
        }

        return $result;

    }

    public function get_producto_id($conn, $id)
    {
        $query="SELECT p.codigo, p.nombre, SUM(b.stock) as stock, p.costo, p.pvp, p.iva,  p.composicion, p.aplicacion, 
                      p.proveedor, p.grupo, p.subgrupo, p.stock_consignacion, p.gasto, p.utilidad, p.moto, 
                      p.pvp2, p.pvp3, p.pvp4, p.unidad, p.uxpaca  
                FROM producto p 
                INNER JOIN productobodega b ON p.id_producto=b.id_producto 
                WHERE p.id_producto ='$id' AND p.borrado = 0";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

    public function get_producto_borrado_id($conn, $id)
    {
        $query="SELECT codigo, nombre, stock, costo, pvp, iva,  composicion, aplicacion, proveedor, grupo, subgrupo, 
                        stock_consignacion, gasto, utilidad, moto, pvp2, pvp3, pvp4, unidad, uxpaca  
                FROM producto 
                WHERE id_producto ='$id' AND borrado = 1";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }
	
	
	public function get_stock($conn, $id){
		$res = 0;
		
		$query="SELECT SUM(stock) as stock FROM productobodega WHERE id_producto ='$id'";
        $result = mysql_query($query, $conn);
        $res = mysql_result($result,0,"stock");
		
		return $res;
		
	}


	
}
?>