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

     $codproductotmp=$_POST["codproductotmp"];

    $codigo=strtoupper($_POST["Acodigo"]);
    $nombre=strtoupper($_POST["Anombre"]);
    $stock=$_POST["Nstock"];
    $costo=$_POST["qcosto"];
    $pvp=$_POST["Qpvp"];
    
	$utilidad = $_POST["qutilidad"];
   
    $composicion=strtoupper($_POST["acomposicion"]);
    $aplicacion=strtoupper($_POST["aplicacion"]);
    $proveedor=$_POST["Aproveedor"];
    $grupo=$_POST["Agrupo"];
    $subgrupo=$_POST["Asubgrupo"];

    

    
    

}
 else {
    $origen="ninguno";
}

if ($accion=="alta") {

        $stock_consignacion=0;

        $producto = new Producto();

        //calculo iva
        $query_iva="SELECT  count(b.iva) as iva
                    FROM productolineatmp a INNER JOIN producto b ON a.id_articulo=b.id_producto
                    WHERE a.codproductotmp = $codproductotmp AND b.iva=1" ;
        $result_iva=mysql_query($query_iva, $conn);
        if(mysql_result($result_iva,0,"iva")>0)
        {
            $iva=1;
        }
        else
        {
            $iva=0;
        }

        $idproducto = $producto->save_producto($conn, $codigo, $nombre, $stock, $costo, $pvp,$iva, $composicion,$aplicacion, $proveedor,$grupo,$subgrupo,$stock_consignacion,$utilidad);

	if ($idproducto)
        {
            $query_tmp="SELECT * FROM productolineatmp WHERE codproductotmp='$codproductotmp' ORDER BY numlinea ASC";
            $rs_tmp=mysql_query($query_tmp, $conn);

            $contador=0;
            $num_rows=mysql_num_rows($rs_tmp);
            while ($contador < $num_rows)
            {
                $idarticulo=mysql_result($rs_tmp,$contador,"id_articulo");
                
                $query_lineatmp="SELECT stock, stock_consignacion FROM producto WHERE id_producto = $idarticulo";
                $rs_lineatmp=mysql_query($query_lineatmp,$conn);

                $stock_producto=mysql_result($rs_lineatmp,$contador,"stock");
                $stockconsignacion_producto=mysql_result($rs_lineatmp,$contador,"stock_consignacion");

                $query_insercion_linea="INSERT INTO producto_transformacion values ($idproducto,$idarticulo)";
                $rs_insercion=mysql_query($query_insercion_linea,$conn);
                
                if(($stock_producto<=0)&&($stockconsignacion_producto>0))
                {
                    $query_update="UPDATE producto SET stock_consignacion=stock_consignacion - $stock WHERE id_producto=$idarticulo";
                }
                else
                {
                    $query_update="UPDATE producto SET stock=stock - $stock WHERE id_producto=$idarticulo";
                }

                $rs_query=mysql_query($query_update,$conn);
                
                $contador++;
            }
            $mensaje="El producto ha sido dado de alta correctamente";
            $validacion=0;

            $query="DELETE FROM productolineatmp WHERE codproductotmp='$codproductotmp'";
            $rs=mysql_query($query, $conn);
            $query="DELETE FROM productotmp WHERE codproducto='$codproductotmp'";
            $rs=mysql_query($query, $conn);
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


        //calculo iva
        $query_iva="SELECT  count(b.iva) as iva
                    FROM producto_transformacion a INNER JOIN producto b ON a.id_producto=b.id_producto
                    WHERE a.id_transformacion = $idproducto AND b.iva=1" ;
        $result_iva=mysql_query($query_iva, $conn);
        if(mysql_result($result_iva,0,"iva")>0)
        {
            $iva=1;
        }
        else
        {
            $iva=0;
        }


        $producto = new Producto();
        $result = $producto->update_producto($conn, $idproducto,  $stock, $costo, $pvp, $iva,$utilidad);
	
        if ($result)
        {
           $query_tmp="SELECT * FROM producto_transformacion WHERE id_transformacion='$idproducto' ORDER BY id_producto ASC";
            $rs_tmp=mysql_query($query_tmp, $conn);

            $contador=0;
            $num_rows=mysql_num_rows($rs_tmp);
            while ($contador < $num_rows)
            {
                $idarticulo=mysql_result($rs_tmp,$contador,"id_producto");

                $query_lineatmp="SELECT stock, stock_consignacion FROM producto WHERE id_producto = $idarticulo";
                $rs_lineatmp=mysql_query($query_lineatmp,$conn);

                $stock_producto=mysql_result($rs_lineatmp,$contador,"stock");
                $stockconsignacion_producto=mysql_result($rs_lineatmp,$contador,"stock_consignacion");               

                if(($stock_producto<=0)&&($stockconsignacion_producto>0))
                {
                    $query_update="UPDATE producto SET stock_consignacion=stock_consignacion - $stock WHERE id_producto=$idarticulo";
                }
                else
                {
                    $query_update="UPDATE producto SET stock=stock - $stock WHERE id_producto=$idarticulo";
                }

                $rs_query=mysql_query($query_update,$conn);

                $contador++;
            }
            
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






function ingreso_factura_compra(validacion,codarticulo,nombre,idarticulo,iva)
{
      
}
		</script>
	</head>
	<body>
		<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header"><?php echo $cabecera2?></div>
				<div id="frmBusqueda">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
                                            <tr>
							<td width="15%"></td>
							<td width="85%" colspan="2" class="mensaje"><?php echo $mensaje;?></td>
                                            </tr>
					    <tr>
							<td width="15%">C&oacute;digo</td>
							<td width="85%" colspan="2"><?php echo $codigo?></td>
					    </tr>
					    <tr>
							<td width="15%">Nombre</td>
						    <td width="85%" colspan="2"><?php echo $nombre?></td>
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
                                                  <td>Stock Agregado</td>
                                                  <td colspan="2"><?php echo $stock?></td>
                                            </tr>
                                            <tr>
                                                  <td>Stock Consignacion</td>
                                                  <td colspan="2"><?php echo $stock_consignacion?></td>
                                            </tr>
                                            <tr>
						  <td>COSTO</td>
						  <td colspan="2"><?php echo $costo?></td>
					  </tr>
						<tr>
						  <td>PVP</td>
						  <td colspan="2"><?php echo $pvp?></td>
					  </tr>
					  
					  <tr>
						  <td>Utilidad</td>
						  <td colspan="2"><?php echo $utilidad?>%</td>
					  </tr>
						
                                          <tr>
                                                <td>Composici&oacute;n</td>
						  <td colspan="2"><?php echo $composicion?></td>
					  </tr>
                                           <tr>
                                                <td>Aplicaci&oacute;n</td>
						  <td colspan="2"><?php echo $aplicacion?></td>
					  </tr>
                                          <?php
                                            $quer="SELECT empresa FROM proveedor WHERE id_proveedor=$proveedor";
                                            $res=mysql_query($quer,$conn);
                                          ?>

                                          <tr>
						  <td>Proveedor</td>
						  <td colspan="2"><?php echo mysql_result($res,0,"empresa")?></td>
					  </tr>

                                          <?php
                                            $quer="SELECT nombre FROM grupo WHERE id_grupo=$grupo";
                                            $res=mysql_query($quer,$conn);
                                          ?>

                                          <tr>
                                              <td>Grupo</td>
                                              <td><?php echo  mysql_result($res,0,"nombre")?></td>
                                          </tr>

                                           <?php
                                            $quer="SELECT nombre FROM subgrupo WHERE id_subgrupo=$subgrupo";
                                            $res=mysql_query($quer,$conn);
                                          ?>


                                           <tr>
                                              <td>Subgrupo</td>
                                              <td><?php echo  mysql_result($res,0,"nombre")?></td>
                                          </tr>
					</table>

                                        <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
						<tr class="cabeceraTabla">
							<td width="5%">CODIGO</td>
							<td width="40%">DESCRIPCION</td>
							<td width="8%">COSTO</td>
                                                        <td width="8%">PVP</td>
                                                        <td width="8%">IVA</td>	
						</tr>
					</table>
                                        <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0 ID="Table1">

					  <?php //$sel_lineas="SELECT factulinea.*,articulos.*,familias.nombre as nombrefamilia FROM factulinea,articulos,familias WHERE factulinea.codfactura='$codfactura' AND factulinea.codigo=articulos.codarticulo AND factulinea.codfamilia=articulos.codfamilia AND articulos.codfamilia=familias.codfamilia ORDER BY factulinea.numlinea ASC";
                                                $sel_lineas="SELECT b.codigo as codigo, b.nombre as nombre, b.costo as costo, b.pvp as pvp, b.iva as iva
                                                                FROM producto_transformacion a INNER JOIN producto b ON a.id_producto=b.id_producto
                                                                WHERE a.id_transformacion = $idproducto ORDER BY b.nombre ASC";

                                                $rs_lineas=mysql_query($sel_lineas, $conn);
                                                for ($i = 0; $i < mysql_num_rows($rs_lineas); $i++)
                                                {
                                                        $numlinea=mysql_result($rs_lineas,$i,"numlinea");
                                                        //$codfamilia=mysql_result($rs_lineas,$i,"codfamilia");

                                                        $codarticulo_linea=mysql_result($rs_lineas,$i,"codigo");
                                                        $descripcion_linea=mysql_result($rs_lineas,$i,"nombre");
                                                        $costo_linea=mysql_result($rs_lineas,$i,"costo");
                                                        $pvp_linea=mysql_result($rs_lineas,$i,"pvp");
                                                        if(mysql_result($rs_lineas, $i, "iva")==0)
                                                        {
                                                            $iva_linea="NO";
                                                        }
                                                        else
                                                        {
                                                            $iva_linea="SI";
                                                        }
							if ($i % 2) { $fondolinea="itemParTabla"; } else { $fondolinea="itemImparTabla"; } ?>
									<tr class="<?php echo $fondolinea?>">

                                                                                <td width="10%"><?php echo $codarticulo_linea?></td>
                                                                                <td width="35%" align="center"><?php echo $descripcion_linea?></td>
                                                                                <td width="8%" class="aCentro"><?php echo $costo_linea?></td>
                                                                                <td width="8%" class="aCentro"><?php echo $pvp_linea?></td>
                                                                                <td width="8%" class="aCentro"><?php echo $iva_linea?></td>
									</tr>
					<?php } ?>
					</table>

			  </div>
				<div id="botonBusqueda">
                                     <?php if ($origen=="factura"){?>
                                        <img src="../img/botonaceptar.jpg" width="85" height="22" onClick="ingreso_factura_venta(<?php echo $validacion?>,'<?php echo  $codigo?>','<?php echo  $nombre?>','<?php echo  $pvp?>','<?php echo  $idproducto?>','<?php echo  $costo?>','<?php echo  $stock?>','<?php echo  $iva?>',<?php echo  $op?>)" border="1" onMouseOver="style.cursor=cursor">
                                    <?php }else{
                                            if ($origen=="facturacompra"){ ?>
                                                 <img src="../img/botonaceptar.jpg" width="85" height="22" onClick="ingreso_factura_compra(<?php echo $validacion?>,'<?php echo  $codigo?>','<?php echo  $nombre?>','<?php echo  $idproducto?>','<?php echo  $iva?>')" border="1" onMouseOver="style.cursor=cursor">
                                            <?php }else{?>
                                                <img src="../img/botonaceptar.jpg" width="85" height="22" onClick="aceptar(<?php echo $validacion?>)" border="1" onMouseOver="style.cursor=cursor">
                                    <?php }}?>
                                </div>
			 </div>
		  </div>
		</div>
	</body>
</html>