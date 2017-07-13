<?php 

include ("../js/fechas.php");
include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

error_reporting(0);

$accion=$_POST["accion"];
if (!isset($accion)) { $accion=$_GET["accion"]; }
if($accion!="baja")
{



    $idfactura=$_POST["idfactura"];
    $codremision=$_POST["codremision"];
    $serie1=$_POST["serie1"];
    $serie2=$_POST["serie2"];
    $autorizacion=$_POST["autorizacion"];
    $fecha_fin=explota($_POST["fecha_fin"]);
    $motivo=strtoupper($_POST["motivo"]);
    $punto_partida=$_POST["punto_partida"];
    $nombre_trans=$_POST["nombre_trans"];
    $ci_trans=$_POST["ci_trans"];


    $id_factura=$idfactura;

    $query_clie="SELECT f.id_cliente as id_cliente, c.nombre as nombre, c.ci_ruc as ci_ruc, c.direccion as direccion, c.lugar as lugar,
                    f.serie1 as serie1, f.serie2 as serie2, f.codigo_factura as codigo_factura, f.fecha as fecha
             FROM cliente c INNER JOIN facturas f ON c.id_cliente = f.id_cliente
             WHERE f.id_factura=$idfactura";
    $res_clie=mysql_query($query_clie,$conn);
      
}
$minimo=0;
//INSERT REGISTRO DE remision Y RETENLINEA
if ($accion=="alta") {


        include("class/remision.php");
        $remision = new remision();
        $idremision=$remision->save_remision($conn, $idfactura, $serie1,$serie2,$codremision,$autorizacion,$fecha_fin,$motivo,$punto_partida,$nombre_trans,$ci_trans);

	if ($idremision)
        {
           
            $mensaje="La remision ha sido dada de alta correctamente";
            $validacion=0;           
        }
         
        else
        {
            $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'> ERROR al ingresar la remision</span>";
            $validacion=1;
        }
             
	$cabecera1="Inicio >> remision ";
	$cabecera2="INSERTAR remision ";
}


//UPDATE REGISTRO DE remision Y RETENLINEA
if ($accion=="modificar") {

        $idremision=$_POST["idremision"];
        include("class/remision.php");
        $remision = new remision();
        $result=$remision->update_remision($conn, $idremision, $fecha_fin,$motivo,$punto_partida,$nombre_trans,$ci_trans);


	if ($result)
        {
           
            $mensaje="La remision ha sido modificada correctamente";
            $validacion=0;
              
        }
         
        else
        {
            $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'> ERROR al modificar la remision</span>";
            $validacion=1;
        }
             
	$cabecera1="Inicio >> remision ";
	$cabecera2="INSERTAR remision ";
}



//DELETE REGISTRO DE remision Y RETENLINEA
//if ($accion=="baja") {
//
//
//	$idremision=$_GET["idremision"];
//        include("class/remision.php");
//        $remision= new remision();
//
//        $result=$remision->delete_remision($conn,$idremision);
//
//        $query="DELETE FROM cobros WHERE id_remision=$idremision";
//        $rs_del=mysql_query($query,$conn);
//
//        $query="DELETE FROM librodiario WHERE id_remision=$idremision AND tipodocumento=2";
//        $rs_del=mysql_query($query,$conn);
//
//	$query="SELECT * FROM retenlinea WHERE id_remision='$idremision'";
//	$rs_tmp=mysql_query($query,$conn);
//	$contador=0;
//	$baseimponible=0;
//	while ($contador < mysql_num_rows($rs_tmp)) {
//
//		$idproducto=mysql_result($rs_tmp,$contador,"id_producto");
//		$cantidad=mysql_result($rs_tmp,$contador,"cantidad");
//		$sel_articulos="UPDATE producto SET stock=(stock+'$cantidad') WHERE id_producto='$idproducto'";
//		$rs_articulos=mysql_query($sel_articulos);
//		$contador++;
//	}
//	if ($result) { $mensaje="La remision ha sido anulada correctamente"; }
//	$cabecera1="Inicio >> Ventas &gt;&gt; Anular remision";
//	$cabecera2="ANULAR remision remision";
//	$query_mostrar="SELECT * FROM remisions WHERE id_remision='$idremision'";
//	$rs_mostrar=mysql_query($query_mostrar);
//
//        $codremision=mysql_result($rs_mostrar,0,"codigo_remision");
//        $serie1=mysql_result($rs_mostrar,0,"serie1");
//        $serie2=mysql_result($rs_mostrar,0,"serie2");
//        $autorizacion=mysql_result($rs_mostrar,0,"autorizacion");
//        $idcliente=mysql_result($rs_mostrar,0,"id_cliente");
//        $fecha=mysql_result($rs_mostrar,0,"fecha");
//
//
//
//        $validacion=0;
//}

?>




<html>
	<head>
		<title>Principal</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
		<script language="javascript">
		var cursor;
		if (document.all) {
		// Está utilizando EXPLORER
		cursor='hand';
		} else {
		// Está utilizando MOZILLA/NETSCAPE
		cursor='pointer';
		}
		
		function aceptar(validacion) {
			if(validacion==0)
                        {                           
                                location.href="index.php";
                        }
                        else
                            history.back();
		}
		
		function imprimir(idremision) {
			window.open("../imprimir/imprimir_remision.php?idremision="+idremision);
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
							<td width="85%" colspan="5" class="mensaje"><?php  echo $mensaje;?></td>
					    </tr>
						 <tr>
                                                    <td width="10%">No. remision</td>
                                                    <td>
                                                        <?php echo $serie1?> - <?php echo $serie2?> # <?php echo $codremision?>

                                                    </td>
                                                    <td width="5%">Autorizaci&oacute;n</td>
                                                    <td colspan="2">
                                                        <?php echo $autorizacion?>
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
                                                    <td><?php echo implota($fecha_fin)?> </td>
                                                </tr>

                                                <tr>
                                                    <td>Motivo del Traslado:</td>
                                                    <td><?php echo $motivo?></td>
                                                </tr>

						<tr>
                                                    <td width="10%">Fecha Emision</td>
                                                    <td><?php echo implota(mysql_result($res_clie,0,"fecha"))?></td>
						</tr>
                                                <tr>
                                                    <td width="10%">Punto Partida</td>
						    <td width="27%"><?php echo $punto_partida?></td>
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
                                                    <td width="27%"><?php echo $nombre_trans?></td>
                                                </tr>
                                                <tr>
                                                    <td>CI/RUC</td>
                                                    <td width="27%"><?php echo $ci_trans?></td>
                                                </tr>
					</table>

                                    <?php  $query_productos="SELECT f.cantidad as cantidad, p.nombre as nombre
                                                         FROM factulinea as f INNER JOIN producto as p ON f.id_producto = p.id_producto
                                                         WHERE f.id_factura = $idfactura";

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
                                            
                                            <img src="../img/botonaceptar.jpg" width="85" height="22" onClick="aceptar(<?php echo $validacion?>)" border="1" onMouseOver="style.cursor=cursor">
                                            
					   <img src="../img/botonimprimir.jpg" width="79" height="22" border="1" onClick="imprimir(<?php  echo $idremision?>)" onMouseOver="style.cursor=cursor">
				        </div>
					</div>
			  </div>
		  </div>
		</div>
	</body>
</html>
