<?php 
include_once 'class/producto.php';
include_once '../conexion/conexion.php';
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();


error_reporting(0);

$accion=$_REQUEST["accion"];
if (!isset($accion))
{
    $accion=$_GET["accion"];
    if(!isset($accion))
    {
        $accion=$_REQUEST["accion"];
    }
}

if($accion!="baja")
{
    
     $origen=$_POST["origen"];
     $op=$_POST["op"];
    

    $codigo=strtoupper($_POST["Acodigo"]);
    $nombre=strtoupper($_POST["Anombre"]);
	$bodega = $_POST["Acbobodega"];
	
    $stock=$_POST["Astock"];
    $costo=$_POST["qcosto"];
    $pvp=$_POST["Qpvp"];
    $iva=$_POST["iva"];
   
    $composicion=strtoupper($_POST["acomposicion"]);
    $aplicacion=strtoupper($_POST["aplicacion"]);
    $proveedor=$_POST["Aproveedor"];
    $grupo=$_POST["Agrupo"];
    $subgrupo=$_POST["Asubgrupo"];

    $stock_consignacion=$_POST["astock_consignacion"];

	$utilidad = $_POST["qutilidad"];

    $id_producto=$_POST["id_producto"];
    $stock_producto=$_POST["stock_producto"];
    $stockconsignacion_producto=$_POST["stockconsignacion_producto"];
    $cantidad_producto=$_POST["Acantidad_convertir"];
	
	
	$query_bodega = "SELECT id_productobodega, stock FROM productobodega WHERE id_producto = '$id_producto' AND id_bodega = '$bodega'";
	$rs_bodega = mysql_query($query_bodega, $conn);
	$stock_bodega = mysql_result($rs_bodega, 0,"stock");
	$id_productobodega = mysql_result($rs_bodega, 0, "id_productobodega");
	

}
 else {
    $origen="ninguno";
}

if ($accion=="alta") {
        $producto = new Producto();
        $idproducto = $producto->save_producto($conn, $codigo, $nombre, $stock, $costo, $pvp,$iva, $composicion,$aplicacion, $proveedor,$grupo,$subgrupo,$stock_consignacion,$utilidad,$bodega);
		
		

	if ($idproducto)
        {

            $query_transf="INSERT INTO producto_transformacion values ($idproducto,$id_producto)";
            $rs_transf=mysql_query($query_transf,$conn);

            if(($stock_producto<=0)&&($stockconsignacion_producto>0))
            {
                $query_update="UPDATE producto SET stock_consignacion=stock_consignacion - $cantidad_producto WHERE id_producto=$idproducto";
				
				
				
            }
            else
            {
				
				
                //$query_update="UPDATE producto SET stock=stock - $cantidad_producto WHERE id_producto=$id_producto";
				
				
				$query_upbod = "UPDATE productobodega SET stock = (stock - '$cantidad_producto') WHERE id_productobodega = '$id_productobodega'";
				$rs_updbod = mysql_query($query_upbod, $conn);
				
				$query_totstock = "SELECT SUM(stock) as total FROM productobodega WHERE id_producto = '$id_producto'";
				$rs_totstock = mysql_query($query_totstock, $conn);
				$totstock = mysql_result($rs_totstock, 0,"total");
				
				$sel_articulos="UPDATE producto SET stock='$totstock' WHERE id_producto='$id_producto'";
				$rs_articulos=mysql_query($sel_articulos, $conn);
            }

            $rs_query=mysql_query($query_update,$conn);

            $mensaje="El producto ha sido dado de alta correctamente";
            $validacion=0;
        }
        else
        {
            $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   El CODIGO ya existe, ERROR al ingresar el PRODUCTO</span>";
            $validacion=1;
        }
	$cabecera1="Inicio >> Productos &gt;&gt; Nuevo Producto ";
	$cabecera2="INSERTAR PRODUCTO ";
}

if ($accion=="modificar") {
	$idproducto=$_POST["idproducto"];
        $producto = new Producto();
        $result = $producto->update_producto($conn, $idproducto,$codigo, $nombre, $stock, $costo, $pvp, $iva,$utilidad,$bodega);
	
        if ($result)
        {


            $query_update_transf="UPDATE producto_transformacion set id_producto = $id_producto WHERE id_transformacion = $idproducto";
            $rs_update_transf=mysql_query($query_update_transf,$conn);

            if(($stock_producto<=0)&&($stockconsignacion_producto>0))
            {
                $query_update="UPDATE producto SET stock_consignacion=stock_consignacion - $cantidad_producto WHERE id_producto=$id_producto";
            }
            else
            {
                //$query_update="UPDATE producto SET stock=stock - $cantidad_producto WHERE id_producto=$id_producto";
				
				$query_upbod = "UPDATE productobodega SET stock = (stock - '$cantidad_producto') WHERE id_productobodega = '$id_productobodega'";
				$rs_updbod = mysql_query($query_upbod, $conn);
				
				$query_totstock = "SELECT SUM(stock) as total FROM productobodega WHERE id_producto = '$id_producto'";
				$rs_totstock = mysql_query($query_totstock, $conn);
				$totstock = mysql_result($rs_totstock, 0,"total");
				$stock = $totstock;
				$sel_articulos="UPDATE producto SET stock='$totstock' WHERE id_producto='$id_producto'";
				$rs_articulos=mysql_query($sel_articulos, $conn);
            }

            $rs_query=mysql_query($query_update,$conn);
            
            $mensaje="La transformacion del producto ha sido realizado correctamente";
            $validacion=0;
        }
        else
        {
            $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   El CODIGO ya existe, ERROR al ingresar el PRODUCTO</span>";
            $validacion=1;
        }
	$cabecera1="Inicio >> Productos &gt;&gt; Modificar Producto ";
	$cabecera2="MODIFICAR PRODUCTO ";
}

if ($accion=="baja") {
	$idproducto=$_REQUEST["idproducto"];
        $producto = new Producto();
        $result = $producto->delete_producto($conn,$idproducto);

	if ($result)
        {
            $mensaje="El producto ha sido dado de baja correctamente";
             $validacion=0;
        }
        else
        {
            $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'> ERROR al dar de baja el producto</span>";
            $validacion=1;
        }
	$cabecera1="Inicio >> Producto &gt;&gt; Eliminar Producto ";
	$cabecera2="ELIMINAR PRODUCTO ";
	
        $result= $producto->get_producto_borrado_id($conn, $idproducto);
        $codigo=$result['codigo'];
        $nombre=$result['nombre'];
        $stock=$result['stock'];
        $costo=$result['costo'];
        $pvp=$result['pvp'];
        $iva=$result['iva'];
		$utilidad=$result['utilidad'];
  
        $composicion=$result['composicion'];
        $aplicacion=$result['aplicacion'];
        $proveedor=$result['proveedor'];
        $grupo=$result['grupo'];
        $subgrupo=$result['subgrupo'];

        $stock_consignacion=$result['stock_consignacion'];
}
?>


<html>
	<head>
		<title>Principal</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
		<script language="javascript">

		function aceptar(validacion) {
			if(validacion==0)
                            location.href="index.php";
                        else
                            history.back();
		}

		var cursor;
		if (document.all) {
		// Está utilizando EXPLORER
		cursor='hand';
		} else {
		// Está utilizando MOZILLA/NETSCAPE
		cursor='pointer';
		}



function ingreso_factura_venta(validacion,codarticulo,nombre,precio,idarticulo, costo,stock,stock_consignacion,iva,op)
{
    
                      
}


function ingreso_factura_compra(validacion,codarticulo,nombre,idarticulo,iva)
{
       
}
		</script>
	</head>
	<body>
		<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header"><?php  echo $cabecera2?></div>
				<div id="frmBusqueda">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
                                            <tr>
							<td width="15%"></td>
							<td width="85%" colspan="2" class="mensaje"><?php  echo $mensaje;?></td>
                                            </tr>
					    <tr>
							<td width="15%">C&oacute;digo<?php  echo $id_productobodega?></td>
							<td width="85%" colspan="2"><?php  echo $codigo?></td>
					    </tr>
					    <tr>
							<td width="15%">Nombre</td>
						    <td width="85%" colspan="2"><?php  echo $nombre?></td>
					    </tr>
                                            <tr>
                                                    <td width="15%">GRAVA IVA:</td>
                                                    <?php if ($iva==0){?>
                                                        <td width="85%" colspan="2">NO</td>
                                                    <?php }  else {?>
                                                        <td width="85%" colspan="2">SI</td>
                                                    <?php }?>
					    </tr>

											
                                            <tr>
                                                  <td>Stock</td>
                                                  <td colspan="2"><?php  echo $stock?></td>
                                            </tr>
                                            <tr>
                                                  <td>Stock Consignacion</td>
                                                  <td colspan="2"><?php  echo $stock_consignacion?></td>
                                            </tr>
						<tr>
						  <td>PVP</td>
						  <td colspan="2"><?php  echo $pvp?></td>
					  </tr>
					  <tr>
						  <td>Utilidad</td>
						  <td colspan="2"><?php  echo $utilidad?>%</td>
					  </tr>
						
                                          <tr>
                                                <td>Composici&oacute;n</td>
						  <td colspan="2"><?php  echo $composicion?></td>
					  </tr>
                                           <tr>
                                                <td>Aplicaci&oacute;n</td>
						  <td colspan="2"><?php  echo $aplicacion?></td>
					  </tr>
                                          <?php 
                                            $quer="SELECT empresa FROM proveedor WHERE id_proveedor=$proveedor";
                                            $res=mysql_query($quer,$conn);
                                          ?>

                                          <tr>
						  <td>Proveedor</td>
						  <td colspan="2"><?php  echo mysql_result($res,0,"empresa")?></td>
					  </tr>

                                          <?php 
                                            $quer="SELECT nombre FROM grupo WHERE id_grupo=$grupo";
                                            $res=mysql_query($quer,$conn);
                                          ?>

                                          <tr>
                                              <td>Grupo</td>
                                              <td><?php echo mysql_result($res,0,"nombre")?></td>
                                          </tr>

                                           <?php 
                                            $quer="SELECT nombre FROM subgrupo WHERE id_subgrupo=$subgrupo";
                                            $res=mysql_query($quer,$conn);
                                          ?>


                                           <tr>
                                              <td>Subgrupo</td>
                                              <td><?php echo mysql_result($res,0,"nombre")?></td>
                                          </tr>
					</table>
			  </div>
				<div id="botonBusqueda">
                                     <?php if ($origen=="factura"){?>
                                        <img src="../img/botonaceptar.jpg" width="85" height="22" onClick="ingreso_factura_venta(<?php  echo $validacion?>,'<?php echo $codigo?>','<?php echo $nombre?>','<?php echo $pvp?>','<?php echo $idproducto?>','<?php echo $costo?>','<?php echo $stock?>','<?php echo $iva?>',<?php echo $op?>)" border="1" onMouseOver="style.cursor=cursor">
                                    <?php }else{
                                            if ($origen=="facturacompra"){ ?>
                                                 <img src="../img/botonaceptar.jpg" width="85" height="22" onClick="ingreso_factura_compra(<?php  echo $validacion?>,'<?php echo $codigo?>','<?php echo $nombre?>','<?php echo $idproducto?>','<?php echo $iva?>')" border="1" onMouseOver="style.cursor=cursor">
                                            <?php }else{?>
                                                <img src="../img/botonaceptar.jpg" width="85" height="22" onClick="aceptar(<?php  echo $validacion?>)" border="1" onMouseOver="style.cursor=cursor">
                                    <?php }}?>
                                </div>
			 </div>
		  </div>
		</div>
	</body>
</html>