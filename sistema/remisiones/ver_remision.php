<?php 
include ("../js/fechas.php");
include_once '../conexion/conexion.php';

error_reporting(0);
$idremision=$_GET["idremision"];

$usuario = new ServidorBaseDatos();
$conn= $usuario->getConexion();

//datos remision
$query="SELECT id_factura,codigo_remision,serie1,serie2, autorizacion,fecha_fin,motivo,punto_partida,nombre_trans,ci_trans
                FROM remision
                WHERE id_remision ='$idremision'";
$res_rem = mysql_query($query, $conn);
$id_factura=mysql_result($res_rem,0,"id_factura");

//datos cliente
$query_clie="SELECT f.id_cliente as id_cliente, c.nombre as nombre, c.ci_ruc as ci_ruc, c.direccion as direccion, c.lugar as lugar,
                    f.serie1 as serie1, f.serie2 as serie2, f.codigo_factura as codigo_factura, f.fecha as fecha
             FROM cliente c INNER JOIN facturas f ON c.id_cliente = f.id_cliente
             WHERE f.id_factura= $id_factura";
$res_clie=mysql_query($query_clie,$conn);



?>

<html>
	<head>
                <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
		<title>Principal</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
		<script language="javascript">
		
		function aceptar() {
			location.href="../facturas_clientes/index.php";
		}

                function imprimir(idremision) {
			window.open("../imprimir/imprimir_remision.php?idremision="+idremision);
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
				<div id="tituloForm" class="header">VER CLIENTE </div>
				<div id="frmBusqueda">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
                                            <tr>
							<td width="15%"></td>
							<td width="85%" colspan="5" class="mensaje"><?php  echo $mensaje;?></td>
					    </tr>
						 <tr>
                                                    <td width="10%">No. remision</td>
                                                    <td>
                                                        <?php echo mysql_result($res_rem,0,"serie1")?> - <?php echo mysql_result($res_rem,0,"serie2")?> # <?php echo mysql_result($res_rem,0,"codigo_remision")?>

                                                    </td>
                                                    <td width="5%">Autorizaci&oacute;n</td>
                                                    <td colspan="2">
                                                        <?php echo mysql_result($res_rem,0,"autorizacion")?>
                                                    </td>

                                                </tr>

                                                <tr><td colspan="4"><hr/></td></tr>

                                                <tr>
                                                    <td width="12%">No. Comprobante</td>
                                                    <td><?php echo mysql_result($res_clie,0,"serie1")." - ".mysql_result($res_clie,0,"serie2")."  # ".mysql_result($res_clie,0,"codigo_factura")?></td>
                                                <tr/>
                                                <tr>
                                                    <td width="12%">Fecha de Emisi&oacute;n</td>
                                                    <td><?php echo implota(mysql_result($res_clie,0,"fecha"))?></td>
                                                </tr>

                                                <tr><td colspan="4"><hr/></td></tr>

                                                <tr>
                                                    <td width="12%">Fecha Inicio Traslado</td>
                                                    <td><?php echo implota(mysql_result($res_clie,0,"fecha"))?></td>
                                                </tr>


                                                <tr>
                                                    <td width="12%">Fecha Fin Traslado</td>
                                                    <td><?php echo implota(mysql_result($res_rem,0,"fecha_fin"))?> </td>
                                                </tr>

                                                <tr>
                                                    <td>Motivo del Traslado:</td>
                                                    <td><?php echo mysql_result($res_rem,0,"motivo")?></td>
                                                </tr>

						<tr>
                                                    <td width="10%">Fecha Emision</td>
                                                    <td><?php echo implota(mysql_result($res_clie,0,"fecha"))?></td>
						</tr>
                                                <tr>
                                                    <td width="10%">Punto Partida</td>
						    <td width="27%"><?php echo mysql_result($res_rem,0,"punto_partida")?></td>
						</tr>
                                                <tr><td><b>DESTINATARIO</b></td></tr>

                                                <tr>
                                                    <td width="10%">NOMBRE</td>
						    <td width="27%"><?php echo mysql_result($res_clie,0,"nombre")?></td>
						</tr>

                                                <tr>
                                                    <td>CI/RUC</td>
                                                    <td width="27%"><?php echo mysql_result($res_clie,0,"ci_ruc")?></td>
                                                </tr>

						<tr>
                                                    <td width="10%">Punto LLegada</td>
						    <td width="27%"><?php  echo mysql_result($res_clie,0,"lugar")." -- ". mysql_result($res_clie,0,"direccion") ?></td>
                                                </tr>

                                                <tr><td colspan="4"><hr/></td></tr>
                                                <tr><td colspan="2"><b>IDENTIFICACION PERSONA ENCARGADA TRANSPORTE</b></td></tr>
                                                <tr>
                                                    <td>NOMBRE</td>
                                                    <td width="27%"><?php echo mysql_result($res_rem,0,"nombre_trans")?></td>
                                                </tr>
                                                <tr>
                                                    <td>CI/RUC</td>
                                                    <td width="27%"><?php echo mysql_result($res_rem,0,"ci_trans")?></td>
                                                </tr>
					</table>

                                    <?php  $query_productos="SELECT f.cantidad as cantidad, p.nombre as nombre
                                                         FROM factulinea as f INNER JOIN producto as p ON f.id_producto = p.id_producto
                                                         WHERE f.id_factura = $id_factura";

                                       $res_prod=mysql_query($query_productos, $conn);
                                    ?>


                                    <p style="text-align: center"><b>BIENES TRANSPORTADOS</b></p>
                                    <table class="fuente8" width="60%" cellspacing=0 cellpadding=3 border=1>
                                        <tr>
                                            <th width="10%">CANTIDADES</th>
                                            <th width="90%">DESCRIPCION</th>
                                        </tr>
                                        <?php 
                                        while ( $aRow = mysql_fetch_array( $res_prod ) )
                                        {
                                        ?>
                                            <tr>
                                                <td align="center">
                                                    <?php  echo $aRow["cantidad"]?>
                                                </td>
                                                <td align="center">
                                                    <?php  echo $aRow["nombre"]?>
                                                </td>
                                            </tr>
                                        <?php 
                                        }
                                        ?>
                                    </table>
			  </div>

					
				<div id="botonBusqueda">
					<div align="center">

                                            <img src="../img/botonaceptar.jpg" width="85" height="22" onClick="aceptar()" border="1" onMouseOver="style.cursor=cursor">

                                            <img src="../img/botonimprimir.jpg" width="79" height="22" border="1" onClick="imprimir(<?php  echo $idremision?>)" onMouseOver="style.cursor=cursor">
				        </div>
					</div>
			  </div>
			 </div>
		  </div>
		</div>
	</body>
</html>
