<?php 
include_once '../conexion/conexion.php';
include_once 'class/producto.php';
 error_reporting(0);
$idproducto=$_REQUEST["idproducto"];

$usuario = new ServidorBaseDatos();
$conn= $usuario->getConexion();

$producto= new Producto();
$row = $producto->get_producto_id($conn, $idproducto);

?>

<html>
	<head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Principal</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
		<script language="javascript">
		
		function aceptar() {
			location.href="index.php";
		}
		
		var cursor;
		if (document.all) {
		// Está utilizando EXPLORER
		cursor='hand';
		} else {
		// Está utilizando MOZILLA/NETSCAPE
		cursor='pointer';
		}

                function modificar_producto(idproducto) {
			location.href="modificar_producto.php?idproducto=" + idproducto;
		}

		function eliminar_producto(idproducto) {
                    if (confirm("Atencion va a proceder a la baja de un producto. Desea continuar?")) {
			location.href="eliminar_producto.php?idproducto=" + idproducto;
                    }
		}


		</script>
	</head>
	<body>
		<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header">VER PRODUCTO </div>
				<div id="frmBusqueda">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
                                            <tr>
                                                <td width="15%"><strong>C&oacute;digo</strong></td>
                                                <td width="85%" colspan="2"><?php  echo $row['codigo']?></td>
					    </tr>
                                            <tr>
                                                <td width="15%"><strong>Nombre</strong></td>
                                                <td width="85%" colspan="2"><?php  echo $row['nombre']?></td>
					    </tr>
                                            <tr>
                                                <td>GRAVA IVA</td>
                                                <?php if ($row["iva"]==0){?>
                                                    <td>No</td>
                                                <?php }else{?>
                                                    <td>Si</td>
                                                <?php }?>
                                            </tr>
                                            <tr>
                                                <td width="15%"><strong>Stock</strong></td>
                                                <td width="85%" colspan="2"><?php  echo $row['stock']?></td>
					    </tr>
                                             <tr>
                                                <td width="15%"><strong>Stock Consig.</strong></td>
                                                <td width="85%" colspan="2"><?php  echo $row['stock_consignacion']?></td>
					    </tr>
                                            <tr>
                                                <td width="15%"><strong>Costo</strong></td>
                                                <td width="85%" colspan="2"><?php  echo $row['costo']?></td>
					    </tr>
                                            <tr>
                                                <td width="15%"><strong>PVP</strong></td>
                                                <td width="85%" colspan="2"><?php  echo $row['pvp']?></td>
					    </tr>
						
						<tr>
                                                <td width="15%"><strong>Utilidad</strong></td>
                                                <td width="85%" colspan="2"><?php  echo $row['utilidad']?>%</td>
					    </tr>
                                            
                                            <tr>
                                                <td width="15%"><strong>Composici&oacute;n</strong></td>
                                                <td width="85%" colspan="2"><?php  echo $row['composicion']?></td>
					    </tr>
                                            <tr>
                                                <td width="15%"><strong>Aplicaci&oacute;n</strong></td>
                                                <td width="85%" colspan="2"><?php  echo $row['aplicacion']?></td>
					    </tr>

                                             <?php 
                                                $proveedor=$row['proveedor'];
                                                $quer="SELECT empresa FROM proveedor WHERE id_proveedor=$proveedor";
                                                $res=mysql_query($quer,$conn);
                                            ?>
                                            <tr>
                                                <td width="15%"><strong>Proveedor</strong></td>
                                                <td width="85%" colspan="2"><?php  echo mysql_result($res,0,"empresa")?></td>
					    </tr>

                                            <?php 
                                                $grupo=$row['grupo'];
                                                $quer="SELECT nombre FROM grupo WHERE id_grupo=$grupo";
                                                $res=mysql_query($quer,$conn);
                                            ?>
                                            <tr>
                                                <td width="15%"><strong>Grupo</strong></td>
                                                <td width="85%" colspan="2"><?php  echo mysql_result($res,0,"nombre")?></td>
					    </tr>

                                            <?php 
                                                $subgrupo=$row['subgrupo'];
                                                $quer="SELECT nombre FROM subgrupo WHERE id_subgrupo=$subgrupo";
                                                $res=mysql_query($quer,$conn);
                                            ?>
                                            <tr>
                                                <td width="15%"><strong>Subgrupo</strong></td>
                                                <td width="85%" colspan="2"><?php  echo mysql_result($res,0,"nombre")?></td>
					    </tr>

											
					</table>
                                </div>
				<div id="botonBusqueda">
                                        <img src='../img/botonmodificar.jpg' border='1' width='85' height='22' border='1' title='Modificar' onClick='modificar_producto(<?php echo $idproducto?>)' onMouseOver='style.cursor=cursor'>
<!--					<img src='../img/botoneliminar.jpg' border='1' width='85' height='22' border='1' title='Eliminar' onClick='eliminar_producto(<?php echo $idproducto?>)' onMouseOver='style.cursor=cursor'>-->
                                        <img src="../img/botonaceptar.jpg" width="85" height="22" onClick="aceptar()" border="1" onMouseOver="style.cursor=cursor">

			  </div>
			 </div>
		  </div>
		</div>
	</body>
</html>
