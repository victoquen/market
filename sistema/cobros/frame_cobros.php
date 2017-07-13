<?php 

include ("../js/fechas.php");
$hoy=date("d/m/Y");
error_reporting(0);
include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();


if ($_POST["accion"]=="") 
    { $accion=$_GET["accion"];

    }
else
{ 
    $accion=$_POST["accion"];
}


if ($accion=="ver") {
	$idfactura=$_GET["idfactura"];
        if($_GET["importe"]!="")
        {
            $importe=$_GET["importe"];
      
            ?>
            <script>

                var valor1=<?php  echo $importe;?>;
                parent.document.getElementById("pendiente").value=valor1;

            </script>
            <?php 
        }       
}
if ($accion=="eliminado") {
	$idfactura=$_GET["idfactura"];
        if($_REQUEST["importe"]!="")
        {
            $importe=$_REQUEST["importe"];

            ?>
            <script>

                
                parent.document.getElementById("pendiente").value=<?php  echo $importe;?>;
                
                <?php  
                $act_factura="UPDATE facturas SET estado='0' WHERE id_factura='$idfactura'";
                $rs_act=mysql_query($act_factura,$conn);
                ?>
                parent.document.getElementById("cboEstados").value=0;

            </script>
            <?php 
        }
}

if ($accion=="insertar") {
	$importe=$_POST["Rimporte"];
        $retiva = $_POST["retiva"];
        $retfuente = $_POST["retfuente"];
        
	$idcliente=$_POST["idcliente"];
	$idfactura=$_POST["idfactura"];
	$formapago=$_POST["AcboFP"];

	$observaciones=$_POST["observaciones"];
	//$estado=$_POST["cboEstados"];
	$fechacobro=$_POST["fechacobro"];
	if($formapago == 1){
		$idbanco = 1;
	}else{
		$idbanco=$_POST["acbobanco"];
	}

	if ($fechacobro<>"") { $fechacobro=explota($fechacobro); }


	$sel_insertar="INSERT INTO cobros (id_cobro,id_factura,id_cliente,importe,id_formapago,id_banco,fechacobro,observaciones) VALUES
                                         (null,'$idfactura','$idcliente','$importe','$formapago','$idbanco','$fechacobro','$observaciones')";

	$rs_insertar=mysql_query($sel_insertar, $conn);
        $idmov_cobro=mysql_insert_id();
	
	//1 compra
	//2 venta
	
	$sel_libro="INSERT INTO librodiario (id_librodiario,id_mov,fecha,tipodocumento,id_factura,id_cliente,id_formapago,id_banco,total) VALUES
                                            (null,'$idmov_cobro','$fechacobro','2','$idfactura','$idcliente','$formapago','$idbanco','$importe')";
	$rs_libro=mysql_query($sel_libro, $conn);
	
	?>
	<script>
	parent.document.getElementById("observaciones").value="";
	parent.document.getElementById("Rimporte").value="";
	parent.document.getElementById("acbobanco").value="0";
	parent.document.getElementById("AcboFP").value="0";
	parent.document.getElementById("fechacobro").value="<?php  echo $hoy?>";
	var importe=<?php  echo $importe?>;
	var total=parent.document.getElementById("pendiente").value - parseFloat(importe);
	var original=parseFloat(total);
	var result=Math.round(original*100)/100 ;
	parent.document.getElementById("pendiente").value=result;
        
            <?php  
                $select_facturas="SELECT totalfactura, ret_iva, ret_fuente FROM facturas  WHERE facturas.id_factura=$idfactura";
                $rs_facturas=mysql_query($select_facturas,$conn);
                $totalfactura=mysql_result($rs_facturas,0,"totalfactura");
                $retiva= mysql_result($rs_facturas,0,"ret_iva");
                $retfuente = mysql_result($rs_facturas,0,"ret_fuente");

                $sel_cobros="SELECT sum(importe) as aportaciones FROM cobros WHERE id_factura=$idfactura";
                $rs_cobros=mysql_query($sel_cobros,$conn);
                if($rs_cobros)
                    $aportaciones=mysql_result($rs_cobros,0,"aportaciones");
                else
                    $aportaciones=0;

                $pendiente=$totalfactura-$aportaciones - $retiva - $retfuente;
                
                
                
                if(($pendiente > -1) &&($pendiente <=0)){
                    $act_factura1="UPDATE facturas SET estado='1' WHERE id_factura='$idfactura'";
                    $rs_act1=mysql_query($act_factura1,$conn);
                }
            ?>
                                  
	</script><?php 
}

$query_busqueda="SELECT count(*) as filas FROM cobros,cliente WHERE cobros.id_cliente=cliente.id_cliente AND cobros.id_factura='$idfactura' order BY id_cobro DESC";
$rs_busqueda=mysql_query($query_busqueda,$conn);
$filas=mysql_result($rs_busqueda,0,"filas");

?>
<html>
	<head>
		<title>Clientes</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
		<script language="javascript">

		function abreVentana(observaciones){
			miPopup = window.open("ver_observaciones.php?observaciones="+observaciones,"miwin","width=380,height=240,scrollbars=yes");
			miPopup.focus();
		}
		
		function eliminar(idfactura,idmov,fechacobro,importe){
			miPopup = window.open("eliminar.php?idfactura="+idfactura+"&idmov="+idmov+"&fechacobro="+fechacobro+"&importe="+importe,"frame_datos","width=380,height=240,scrollbars=yes");
                        miPopup.focus();
            }
		
		function ver_cobros(idfactura) {
			parent.location.href="ver_cobros.php?idfactura=" + idfactura + "&cadena_busqueda=<?php  echo $cadena_busqueda?>";
		}
		
		</script>
	</head>
	<body>	
			<div id="zonaContenido">
			<div align="center">
			<table class="fuente8" width="99%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
                            

			<form name="form1" id="form1">		
				<?php 	if ($filas > 0) { ?>
						<?php  $sel_resultado="SELECT cobros.id_cobro, cobros.id_factura, cobros.fechacobro, cobros.importe, formapago.nombre as nombrefp, cobros.id_banco, cobros.observaciones FROM facturas,cobros,cliente,formapago WHERE cobros.id_factura='$idfactura' AND cobros.id_factura=facturas.id_factura AND cobros.id_cliente=cliente.id_cliente AND cobros.id_formapago=formapago.id_formapago ORDER BY cobros.id_cobro DESC";
						   $res_resultado=mysql_query($sel_resultado, $conn);
						   $contador=0;				   
						   while ($contador < mysql_num_rows($res_resultado)) { 
								if ($contador % 2) { $fondolinea="itemParTabla"; } else { $fondolinea="itemImparTabla"; }?>
						<tr class="<?php  echo $fondolinea?>">
							<td class="aCentro" width="5%"><?php  echo $contador+1;?></td>
							<td width="13%"><div align="center"><?php  echo implota(mysql_result($res_resultado,$contador,"fechacobro"))?></div></td>
							<td width="13%"><div align="center"><?php  echo number_format(mysql_result($res_resultado,$contador,"importe"),2,",",".")?></div></td>
							<td width="20%"><div align="center"><?php  echo mysql_result($res_resultado,$contador,"nombrefp")?></div></td>
							<td class="aDerecha" width="19%">
                                                            <div align="center">
                                                                <?php 
                                                                    if(mysql_result($res_resultado,$contador,"id_banco")==0)
                                                                        echo "---";
                                                                    else {
                                                                        $bancos_resultado="SELECT nombre FROM banco WHERE id_banco='".mysql_result($res_resultado,$contador,"id_banco")."'";
                                                                        $res_bancos=mysql_query($bancos_resultado, $conn);
                                                                        echo mysql_result($res_bancos,0,"nombre");
                                                                    }
                                                                ?>
                                                            </div>
                                                        </td>
							
							<td width="5%"><div align="center"><a href="#"><img src="../img/observaciones.png" width="16" height="16" border="0" onClick="abreVentana('<?php  echo mysql_result($res_resultado,$contador,"observaciones")?>')" title="Ver Observaciones"></a></div></td>
							<td width="5%"><div align="center"><a href="#"><img src="../img/eliminar.png" width="16" height="16" border="0" onClick="eliminar('<?php  echo mysql_result($res_resultado,$contador,"id_factura")?>','<?php  echo mysql_result($res_resultado,$contador,"id_cobro")?>','<?php  echo mysql_result($res_resultado,$contador,"fechacobro")?>','<?php  echo mysql_result($res_resultado,$contador,"importe")?>')" title="Eliminar"></a></div></td>
						</tr>
						<?php  $contador++;
							}
						?>			
					</table>
					<?php  } else { ?>
					<table class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0>
						<tr>
							<td width="100%" class="mensaje"><?php  echo "Todav&iacute;a no se ha producido ning&uacute;n cobro de esta factura.";?></td>
					    </tr>
					</table>					
					<?php  } ?>
					</form>
                           
				</div>
				<iframe id="frame_datos" name="frame_datos" width="0" height="0" frameborder="0">
					<ilayer width="0" height="0" id="frame_datos" name="frame_datos"></ilayer>
					</iframe>
				</div>
		  			
	</body>
</html>
