<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
    </head>

<script>
function eliminar_linea(codfacturatmp,numlinea,importe,iva)
{
	if (confirm(" Desea eliminar esta linea ? "))
            {
		parent.document.formulario_lineas.baseimponible.value=parseFloat(parent.document.formulario_lineas.baseimponible.value) - parseFloat(importe);
		var original=parseFloat(parent.document.formulario_lineas.baseimponible.value);
		var result=Math.round(original*100)/100 ;
		parent.document.formulario_lineas.baseimponible.value=result;

		parent.document.formulario_lineas.importeiva.value=parseFloat(parent.document.formulario_lineas.importeiva.value) - parseFloat(iva);
		var original1=parseFloat(parent.document.formulario_lineas.importeiva.value);
		var result1=Math.round(original1*100)/100 ;
		parent.document.formulario_lineas.importeiva.value=result1;
                parent.document.formulario_lineas.iva12.value=result1;


               


                var original5=parseFloat(result) + parseFloat(result1);
		var result5=Math.round(original5*100)/100 ;
		parent.document.formulario_lineas.preciototal.value=result5;

                //var original3=parseFloat(result2)

		document.getElementById("frame_datos").src="eliminar_linea.php?codfacturatmp="+codfacturatmp+"&numlinea=" + numlinea;
            }
}
function modificar_linea(codfacturatmp, numlinea, importe, iva)
{
    
    miPopup = window.open("modificar_linea.php?codfacturatmp="+codfacturatmp+"&numlinea=" + numlinea+"&importe="+importe+"&iva="+iva,"miwin","width=600,height=300,scrollbars=yes");
    miPopup.focus();
}


function actualizar(importe,iva)
{
    parent.document.formulario_lineas.baseimponible.value=parseFloat(parent.document.formulario_lineas.baseimponible.value) + parseFloat(importe);
    var original=parseFloat(parent.document.formulario_lineas.baseimponible.value);
    var result=Math.round(original*100)/100 ;
    parent.document.formulario_lineas.baseimponible.value=result;

    parent.document.formulario_lineas.importeiva.value=parseFloat(parent.document.formulario_lineas.importeiva.value) + parseFloat(iva);
    var original1=parseFloat(parent.document.formulario_lineas.importeiva.value);
    var result1=Math.round(original1*100)/100 ;
    parent.document.formulario_lineas.importeiva.value=result1;
    parent.document.formulario_lineas.iva12.value=result1;





    var original5=parseFloat(result) + parseFloat(result1);
    var result5=Math.round(original5*100)/100 ;
    parent.document.formulario_lineas.preciototal.value=result5;
}
</script>
<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
<body>
<?php  
include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

error_reporting(0);
$codfacturatmp=$_POST["codfacturatmp"];
$retorno=0;
//if ($modif<>1) {
		if (!isset($codfacturatmp)) { 
			$codfacturatmp=$_GET["codfacturatmp"];
			$retorno=1;   
                        }
		if ($retorno==0) {	
				//$codfamilia=$_POST["codfamilia"];
				$idarticulo=$_POST["idarticulo"];
				$cantidad=$_POST["cantidad"];
				$precio=$_POST["precio"];
				$importe=$_POST["importe"];
				$descuento=$_POST["descuento"];
                                $iva=$_POST["iva"];
				

				$sel_insert="INSERT INTO factulineaptmp_consig (codfactura,numlinea,id_articulo,cantidad,costo,importe,dcto,iva) VALUES ('$codfacturatmp','','$idarticulo','$cantidad','$precio','$importe','$descuento','$iva')";
				$rs_insert=mysql_query($sel_insert, $conn);

		}

//}
?>
<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
<?php 
$sel_lineas="SELECT b.codigo as codigo, b.nombre as nombre, a.numlinea as numlinea, a.cantidad as cantidad, a.costo as costo, a.importe as importe, a.dcto as dcto, a.iva as iva FROM factulineaptmp_consig a INNER JOIN producto b ON a.id_articulo=b.id_producto WHERE a.codfactura = $codfacturatmp ORDER BY a.numlinea ASC";
$rs_lineas=mysql_query($sel_lineas, $conn);
for ($i = 0; $i < mysql_num_rows($rs_lineas); $i++) {
	$numlinea=mysql_result($rs_lineas,$i,"numlinea");
	//$codfamilia=mysql_result($rs_lineas,$i,"codfamilia");
	
	$codarticulo=mysql_result($rs_lineas,$i,"codigo");
	$descripcion=mysql_result($rs_lineas,$i,"nombre");
	$cantidad=mysql_result($rs_lineas,$i,"cantidad");
	$precio=mysql_result($rs_lineas,$i,"costo");
	$importe=mysql_result($rs_lineas,$i,"importe");
	$descuento=mysql_result($rs_lineas,$i,"dcto");
        $iva=mysql_result($rs_lineas, $i, "iva");
	if ($i % 2) { $fondolinea="itemParTabla"; } else { $fondolinea="itemImparTabla"; } ?>
			<tr class="<?php  echo $fondolinea?>">
				
				<td width="10%"><?php  echo $codarticulo?></td>
                                <td width="41%" align="center"><?php  echo $descripcion?></td>
                                <td width="5%"><?php  echo $cantidad?></td>
				<td width="9%" class="aCentro"><?php  echo $precio?></td>
				<!--<td width="8%" class="aCentro"><?php  echo $descuento?></td>-->
				<td width="8%" class="aCentro"><?php  echo $importe?></td>
				<td width="8%" class="aCentro"><?php  echo $iva?></td>
				<td width="3%"><a href="javascript:eliminar_linea(<?php  echo $codfacturatmp?>,<?php  echo $numlinea?>,<?php  echo $importe ?>,<?php  echo $iva?>)"><img src="../img/eliminar.png" border="0"></a></td>
                                <td width="3%"><a href="javascript:modificar_linea(<?php  echo $codfacturatmp?>,<?php  echo $numlinea?>,<?php  echo $importe ?>,<?php  echo $iva?>)"><img src="../img/modificar.png" border="0"></a></td>
			</tr>
<?php  } ?>
</table>
<iframe id="frame_datos" name="frame_datos" width="0%" height="0" frameborder="0">
	<ilayer width="0" height="0" id="frame_datos" name="frame_datos"></ilayer>
</iframe>
</body>
</html>