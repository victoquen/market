<?php 

$idproducto=$_REQUEST["idproducto"];

include_once '../conexion/conexion.php';
include_once 'class/producto.php';

$usuario = new ServidorBaseDatos();
$conn= $usuario->getConexion();

$producto= new Producto();
$row = $producto->get_producto_id($conn, $idproducto);
?>

<html>
	<head>
		<title>Principal</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
		<script language="javascript">
		
		function aceptar(idproducto) {
			location.href="save_producto.php?idproducto=" + idproducto + "&accion=baja";
		}
		
		function cancelar() {
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
		
		</script>
	</head>
	<body>
		<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header">ELIMINAR PRODUCTO </div>
				<div id="frmBusqueda">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
                                            <tr>
                                                <td width="15%">Producto Gasto: </td>                                                    
                                                <td width="43%">                                                    
                                                    <?php  if($row['gasto']==0) {?>
                                                    No
                                                    <?php  } else {?>
                                                    Si
                                                    <?php  }?>                                                                                    
                                                </td>
                                            </tr>
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
                                                <td width="15%"><strong>Stock Consignacion</strong></td>
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
                                                <td width="15%"><strong>Composici&oacute;n</strong></td>
                                                <td width="85%" colspan="2"><?php  echo $row['composicion']?></td>
					    </tr>
                                            
					</table>
			  </div>
				<div id="botonBusqueda">
					<img src="../img/botonaceptar.jpg" width="85" height="22" onClick="aceptar(<?php  echo $idproducto?>)" border="1" onMouseOver="style.cursor=cursor">
					<img src="../img/botoncancelar.jpg" width="85" height="22" onClick="cancelar()" border="1" onMouseOver="style.cursor=cursor">
			  </div>
			  </div>
		  </div>
		</div>
	</body>
</html>
