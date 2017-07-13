<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
    </head>

<script>
function eliminar_linea(codproductotmp,numlinea,costo,pvp)
{
	if (confirm(" Desea eliminar esta linea ? "))
            {
             
                parent.document.formulario.costo.value= parseFloat(parent.document.formulario.costo.value) - costo;
                var original= parseFloat(parent.document.formulario.costo.value);
                var result=Math.round(original*100)/100 ;
                parent.document.formulario.costo.value=result;


                parent.document.formulario.pvp.value= parseFloat(parent.document.formulario.pvp.value) - pvp;
                var original= parseFloat(parent.document.formulario.pvp.value);
                var result=Math.round(original*100)/100 ;
                parent.document.formulario.pvp.value=result;


		document.getElementById("frame_datos").src="eliminar_linea.php?codproductotmp="+codproductotmp+"&numlinea=" + numlinea;
            }
}
</script>
<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
<body>
<?php 
include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

error_reporting(0);
$codproductotmp=$_POST["codproductotmp"];
$retorno=0;
//if ($modif<>1) {
		if (!isset($codproductotmp)) {
			$codproductotmp=$_GET["codproductotmp"];
			$retorno=1;   
                        }
		if ($retorno==0) {	
				//$codfamilia=$_POST["codfamilia"];
				$idarticulo=$_POST["idarticulo"];								
				$sel_insert="INSERT INTO productolineatmp (codproductotmp,numlinea,id_articulo) VALUES ('$codproductotmp','','$idarticulo')";
				$rs_insert=mysql_query($sel_insert, $conn);

		}

//}
?>
<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
<?php
$sel_lineas="SELECT b.codigo as codigo, b.nombre as nombre, a.numlinea as numlinea, b.costo as costo, b.pvp as pvp, b.iva as iva
            FROM productolineatmp a INNER JOIN producto b ON a.id_articulo=b.id_producto
            WHERE a.codproductotmp = $codproductotmp ORDER BY a.numlinea ASC";
$rs_lineas=mysql_query($sel_lineas, $conn);
for ($i = 0; $i < mysql_num_rows($rs_lineas); $i++) {
	$numlinea=mysql_result($rs_lineas,$i,"numlinea");
	//$codfamilia=mysql_result($rs_lineas,$i,"codfamilia");
	
	$codarticulo=mysql_result($rs_lineas,$i,"codigo");
	$descripcion=mysql_result($rs_lineas,$i,"nombre");	
	$costo=mysql_result($rs_lineas,$i,"costo");
        $pvp=mysql_result($rs_lineas,$i,"pvp");
	if(mysql_result($rs_lineas, $i, "iva")==0)
        {
            $iva="NO";
        }
        else
        {
            $iva="SI";
        }
        
	if ($i % 2) { $fondolinea="itemParTabla"; } else { $fondolinea="itemImparTabla"; } ?>
			<tr class="<?php echo $fondolinea?>">
				
				<td width="10%"><?php echo $codarticulo?></td>
                                <td width="35%" align="center"><?php echo $descripcion?></td>
				<td width="8%" class="aCentro"><?php echo $costo?></td>
				<td width="8%" class="aCentro"><?php echo $pvp?></td>
				<td width="8%" class="aCentro"><?php echo $iva?></td>
				<td width="3%"><a href="javascript:eliminar_linea(<?php echo $codproductotmp?>,<?php echo $numlinea?>,<?php echo $costo?>,<?php echo $pvp?>)"><img src="../img/eliminar.png" border="0"></a></td>
			</tr>
<?php } ?>
</table>
<iframe id="frame_datos" name="frame_datos" width="0%" height="0" frameborder="0">
	<ilayer width="0" height="0" id="frame_datos" name="frame_datos"></ilayer>
</iframe>
</body>
</html>