<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
    </head>

<script>
function eliminar_linea(idproducto,idarticulo,costo,pvp)
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


		document.getElementById("frame_datos").src="eliminar_linea_final.php?idproducto="+idproducto+"&idarticulo=" + idarticulo;
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
$idproducto=$_POST["idproducto"];
$modif=$_POST["modif"];
$retorno=0;
if ($modif<>1) {
		if (!isset($idproducto)) {
			$idproducto=$_GET["idproducto"];
			$retorno=1;   
                        }
		if ($retorno==0) {	
				
				$idarticulo=$_POST["idarticulo"];
				$sel_insert="INSERT INTO producto_transformacion values ($idproducto,$idarticulo)";
				$rs_insert=mysql_query($sel_insert, $conn);
                                if($rs_insert)
                                {
                                    $prueba_control="si entra al insert";
                                }
                                else {
                                    $prueba_control="no entro al insert";
                                }
		}

}
?>
<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
<?php
$sel_lineas="SELECT b.codigo as codigo, b.nombre as nombre,a.id_producto as idarticulo, b.costo as costo, b.pvp as pvp, b.iva as iva
            FROM producto_transformacion a INNER JOIN producto b ON a.id_producto=b.id_producto
            WHERE a.id_transformacion = $idproducto ORDER BY b.nombre ASC";
$rs_lineas=mysql_query($sel_lineas, $conn);
for ($i = 0; $i < mysql_num_rows($rs_lineas); $i++) {

        $idarticulo=mysql_result($rs_lineas,$i,"idarticulo");

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

	if ($i % 2) { $fondolinea="itemParTabla"; } else { $fondolinea="itemImparTabla"; }

?>
			<tr class="<?php echo $fondolinea?>">
				
				<td width="10%"><?php echo $codarticulo?></td>
                                <td width="35%" align="center"><?php echo $descripcion?></td>
				<td width="8%" class="aCentro"><?php echo $costo?></td>
				<td width="8%" class="aCentro"><?php echo $pvp?></td>
				<td width="8%" class="aCentro"><?php echo $iva?></td>

				<td width="3%"><a href="javascript:eliminar_linea(<?php echo $idproducto?>,<?php echo $idarticulo?>,<?php echo $costo?>,<?php echo $pvp?>)"><img src="../img/eliminar.png" border="0"></a></td>
			</tr>
<?php } ?>
</table>
<iframe id="frame_datos" name="frame_datos" width="0%" height="0" frameborder="0">
	<ilayer width="0" height="0" id="frame_datos" name="frame_datos"></ilayer>
</iframe>
</body>
</html>