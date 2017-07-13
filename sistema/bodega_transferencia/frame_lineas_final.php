<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
    </head>

<script>
function eliminar_linea(idfactura,id_factulineap,subtotal,iva,descuento, idbodega)
{
	if (confirm(" Desea eliminar esta linea ? "))
            {

                parent.document.formulario_lineas.baseimponible.value=parseFloat(parent.document.formulario_lineas.baseimponible.value) - parseFloat(subtotal) - parseFloat(descuento);
		var original=parseFloat(parent.document.formulario_lineas.baseimponible.value);
		var result=Math.round(original*100)/100 ;
		parent.document.formulario_lineas.baseimponible.value=result;
                parent.document.formulario.baseimponible2.value=result; 

                parent.document.formulario_lineas.descuentototal.value=parseFloat(parent.document.formulario_lineas.descuentototal.value) - parseFloat(descuento);
		var originaldesc=parseFloat(parent.document.formulario_lineas.descuentototal.value);
		var resultdesc=Math.round(originaldesc*100)/100 ;
		parent.document.formulario_lineas.descuentototal.value=resultdesc;
                parent.document.formulario.descuentototal2.value=resultdesc;
                                                
		parent.document.formulario_lineas.importeiva.value=parseFloat(parent.document.formulario_lineas.importeiva.value) - parseFloat(iva);
		var original1=parseFloat(parent.document.formulario_lineas.importeiva.value);
		var result1=Math.round(original1*100)/100 ;
		parent.document.formulario_lineas.importeiva.value=result1;
                parent.document.formulario.importeiva2.value=result1;                            
                
                
                var resultiva0=0;
                var resultiva12=0;
                 
                if(iva==0)
                {
                    parent.document.formulario_lineas.iva0.value=parseFloat(parent.document.formulario_lineas.iva0.value) - parseFloat(subtotal);
                    
                }
                else
                {
                    parent.document.formulario_lineas.iva12.value=parseFloat(parent.document.formulario_lineas.iva12.value) - parseFloat(subtotal);
                    
                }
                var originaliva0=parseFloat(parent.document.formulario_lineas.iva0.value);
                resultiva0=Math.round(originaliva0*100)/100 ;
                parent.document.formulario_lineas.iva0.value=resultiva0;
                parent.document.formulario.iva0final.value=resultiva0;
                
                var originaliva12=parseFloat(parent.document.formulario_lineas.iva12.value);
                resultiva12=Math.round(originaliva12*100)/100 ;
                parent.document.formulario_lineas.iva12.value=resultiva12;
                parent.document.formulario.iva12final.value=resultiva12;


                var originalflete=parseFloat(parent.document.formulario_lineas.flete.value);
                var resultflete=Math.round(originalflete*100)/100 ;
                parent.document.formulario.flete2.value=resultflete;

                var original5=parseFloat(result) + parseFloat(result1) - parseFloat(resultdesc)+ parseFloat(resultflete);
		var result5=Math.round(original5*100)/100 ;
		parent.document.formulario_lineas.preciototal.value=result5;
                parent.document.formulario.preciototal2.value=result5;
                
                
                var importeiva = result1;
                var totalfactura=result5;
                
                var descuentototal = resultdesc;
                var iva0=resultiva0;
                var iva12= resultiva12;

                document.getElementById("frame_datos").src="eliminar_linea_final.php?idfactura="+idfactura+"&id_factulineap=" + id_factulineap+"&totalfactura="+totalfactura+"&importeiva="+importeiva+"&descuento="+descuentototal+"&iva0="+iva0+"&iva12="+iva12+"&idbodega="+idbodega;
                //var original3=parseFloat(result2)


            }
}
function modificar_linea(idfactura, id_factulineap, subtotal, iva, descuento,utilidad, idbodega)
{
    
    miPopup = window.open("modificar_linea_final.php?idfactura="+idfactura+"&id_factulineap=" + id_factulineap+"&subtotal="+subtotal+"&iva="+iva+"&descuento="+descuento+"&utilidad="+utilidad+"&idbodega="+idbodega,"miwin","width=600,height=400,scrollbars=yes");
    miPopup.focus();
}

function actualizar(subtotal,iva,idfactura,descuento)
//function actualizar(subtotal,iva,idfactura)
{
    parent.document.formulario_lineas.baseimponible.value=parseFloat(parent.document.formulario_lineas.baseimponible.value) + parseFloat(subtotal);
    var original=parseFloat(parent.document.formulario_lineas.baseimponible.value);
    var result=Math.round(original*10000)/10000 ;
    parent.document.formulario_lineas.baseimponible.value=result;
    parent.document.formulario.baseimponible2.value=result; 
    
    parent.document.formulario_lineas.descuentototal.value=parseFloat(parent.document.formulario_lineas.descuentototal.value) + parseFloat(descuento);
    var originaldesc=parseFloat(parent.document.formulario_lineas.descuentototal.value);
    var resultdesc=Math.round(originaldesc*100)/100 ;
    parent.document.formulario_lineas.descuentototal.value=resultdesc;
    parent.document.formulario.descuentototal2.value=resultdesc;
    

    parent.document.formulario_lineas.importeiva.value=parseFloat(parent.document.formulario_lineas.importeiva.value) + parseFloat(iva);
    var original1=parseFloat(parent.document.formulario_lineas.importeiva.value);
    var result1=Math.round(original1*10000)/10000 ;
    parent.document.formulario_lineas.importeiva.value=result1;
    parent.document.formulario.importeiva2.value=result1;

    
    
    if(iva==0)
    {
        parent.document.formulario_lineas.iva0.value=parseFloat(parent.document.formulario_lineas.iva0.value) + (parseFloat(subtotal) - parseFloat(descuento));
        
    }
    else
    {
        parent.document.formulario_lineas.iva12.value=parseFloat(parent.document.formulario_lineas.iva12.value) + (parseFloat(subtotal) - parseFloat(descuento));
        
    }
    
    var originaliva0=parseFloat(parent.document.formulario_lineas.iva0.value);
    resultiva0=Math.round(originaliva0*100)/100 ;
    var resultiva0=parseFloat(parent.document.formulario_lineas.iva0.value);
    parent.document.formulario_lineas.iva0.value=resultiva0;
    parent.document.formulario.iva0final.value=resultiva0;
    
    var originaliva12=parseFloat(parent.document.formulario_lineas.iva12.value);
    resultiva12=Math.round(originaliva12*100)/100 ;
    var resultiva12=parseFloat(parent.document.formulario_lineas.iva12.value);
    parent.document.formulario_lineas.iva12.value=resultiva12;
    parent.document.formulario.iva12final.value=resultiva12;



    var originalflete=parseFloat(parent.document.formulario_lineas.flete.value);
    var resultflete=Math.round(originalflete*100)/100 ;
    parent.document.formulario.flete2.value=resultflete;

    var original5=parseFloat(result) + parseFloat(result1)- parseFloat(resultdesc) + parseFloat(resultflete);
    var result5=Math.round(original5*10000)/10000 ;
    parent.document.formulario_lineas.preciototal.value=result5;
    parent.document.formulario.preciototal2.value=result5;

    var importeiva = result1;
    var totalfactura=result5;
  
    document.getElementById("frame_datos").src="guardar_datosfact_final.php?idfactura="+idfactura+"&totalfactura="+totalfactura+"&importeiva="+importeiva+"&iva0="+resultiva0+"&iva12="+resultiva12;
}
</script>
<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
<body>
<?php  
include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

error_reporting(0);
$idfactura=$_POST["idfactura"];
$modif=$_POST["modif"];
$retorno=0;
if ($modif<>1) {
		if (!isset($idfactura)) {
			$idfactura=$_GET["idfactura"];
			$retorno=1;   
                        }
		if ($retorno==0) {	
				//$codfamilia=$_POST["codfamilia"];
				$idarticulo=$_POST["idarticulo"];
				$cantidad=$_POST["cantidad"];
				$precio=$_POST["precio"];
				$subtotal=$_POST["importe"];
				$descuento=$_POST["descuento"];
                                $iva=$_POST["iva"];
                                $pvp=$_POST["pvp"];
                                $utilidad=$_POST["utilidad"];
				$bodega = $_POST["cbobodega"];

                                $importeiva=$_POST["importeiva"];
				$preciototal=$_POST["preciototal"];

				$sel_insert="INSERT INTO factulineap (id_factulineap,id_facturap, id_producto,cantidad,costo,dcto,subtotal,iva,utilidad, id_bodega) VALUES ('','$idfactura','$idarticulo','$cantidad','$precio','$descuento','$subtotal','$iva','$utilidad','$bodega')";
				$rs_insert=mysql_query($sel_insert, $conn);
				
				$quer="SELECT id_productobodega as id FROM productobodega WHERE id_producto='$idarticulo' AND id_bodega = '$bodega'";
				$res= mysql_query($quer,$conn);
				if(mysql_result($res,0,"id")==null){
					$queryi = "INSERT INTO productobodega VALUES (null, '$idarticulo', '$bodega', 0)";
					$resi = mysql_query($queryi,$conn);
				}


				
							$query_bodega = "SELECT id_productobodega, stock FROM productobodega WHERE id_producto = '$idarticulo' AND id_bodega = '$bodega'";
							$rs_bodega = mysql_query($query_bodega, $conn);
							$stock_bodega = mysql_result($rs_bodega, 0,"stock");
							$id_productobodega = mysql_result($rs_bodega, 0, "id_productobodega");
							
							
							$query_upbod = "UPDATE productobodega SET stock = (stock + '$cantidad') WHERE id_productobodega = '$id_productobodega'";
							$rs_updbod = mysql_query($query_upbod, $conn);
							
							$query_totstock = "SELECT SUM(stock) as total FROM productobodega WHERE id_producto = '$idarticulo'";
							$rs_totstock = mysql_query($query_totstock, $conn);
							$totstock = mysql_result($rs_totstock, 0,"total");
							
							$sel_articulos="UPDATE producto SET stock='$totstock', pvp='$pvp', utilidad = '$utilidad' WHERE id_producto='$idarticulo'";
							$rs_articulos=mysql_query($sel_articulos, $conn);
				
                               // $update_stock="UPDATE producto SET stock = stock + $cantidad, pvp='$pvp', utilidad = '$utilidad' WHERE id_producto = $idarticulo";
                                //$rs_updatestock=mysql_query($update_stock, $conn);


							$pt=$preciototal*1;
							$update_factura="UPDATE facturasp SET iva12=$importeiva,iva=$importeiva,totalfactura=$preciototal WHERE id_facturap=$idfactura";
							$rs_updatefactura=mysql_query($update_factura, $conn);
		}

}
?>
<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
<?php 
$sel_lineas="SELECT b.codigo as codigo, b.nombre as nombre, a.id_factulineap as id_factulineap, a.cantidad as cantidad, a.costo as costo,
                    a.subtotal as subtotal, a.dcto as dcto, a.iva as iva, a.utilidad as utilidad, a.id_bodega as idbodega
                    FROM factulineap a INNER JOIN producto b ON a.id_producto=b.id_producto
                    WHERE a.id_facturap = $idfactura ORDER BY a.id_factulineap ASC";
$rs_lineas=mysql_query($sel_lineas, $conn);
for ($i = 0; $i < mysql_num_rows($rs_lineas); $i++) {
	$id_factulineap=mysql_result($rs_lineas,$i,"id_factulineap");
	//$codfamilia=mysql_result($rs_lineas,$i,"codfamilia");
	
	$codarticulo=mysql_result($rs_lineas,$i,"codigo");
	$descripcion=mysql_result($rs_lineas,$i,"nombre");
	$cantidad=mysql_result($rs_lineas,$i,"cantidad");
	$precio=mysql_result($rs_lineas,$i,"costo");
	$subtotal=mysql_result($rs_lineas,$i,"subtotal");
	$descuento=mysql_result($rs_lineas,$i,"dcto");
        $iva=mysql_result($rs_lineas, $i, "iva");
        $utilidad=mysql_result($rs_lineas, $i, "utilidad");
		
	$idbodega = mysql_result($rs_lineas, $i, "idbodega");	
	
	$queryb = "SELECT nombre FROM bodega WHERE id_bodega = '$idbodega'";
	$resb = mysql_query($queryb, $conn);
	$nombod = mysql_result($resb, 0, "nombre");
		
		
	if ($i % 2) { $fondolinea="itemParTabla"; } else { $fondolinea="itemImparTabla"; } ?>
			<tr class="<?php  echo $fondolinea?>">
				
				<td width="10%"><?php  echo $codarticulo."-".$vv?></td>
				<td width="41%" align="center"><?php  echo $descripcion?></td>
				<td width="8%"><?php  echo $nombod?></td>
				<td width="5%"><?php  echo $cantidad?></td>
				<td width="9%" class="aCentro"><?php  echo $precio?></td>
				<td width="8%" class="aCentro"><?php  echo $descuento?></td>
				<td width="8%" class="aCentro"><?php  echo $subtotal?></td>
				<td width="8%" class="aCentro"><?php  echo $iva?></td>
				<td width="3%"><a href="javascript:eliminar_linea(<?php  echo $idfactura?>,<?php  echo $id_factulineap?>,<?php  echo $subtotal ?>,<?php  echo $iva?>,<?php  echo $descuento?>, <?php echo $idbodega?>)"><img src="../img/eliminar.png" border="0"></a></td>
                                <td width="3%"><a href="javascript:modificar_linea(<?php  echo $idfactura;?>,<?php  echo $id_factulineap;?>,<?php  echo $subtotal; ?>,<?php  echo $iva;?>,<?php  echo $descuento;?>, <?php  echo $utilidad;?>, <?php echo $idbodega;?>)"><img src="../img/modificar.png" border="0"></a></td>
			</tr>
<?php  } ?>
</table>
<iframe id="frame_datos" name="frame_datos" width="0%" height="0" frameborder="0">
	<ilayer width="0" height="0" id="frame_datos" name="frame_datos"></ilayer>
</iframe>
</body>
</html>