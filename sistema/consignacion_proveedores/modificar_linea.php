<?php 
include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$codfactura=$_GET["codfacturatmp"];
$numlinea=$_GET["numlinea"];
$importe=$_GET["importe"];
$iva=$_GET["iva"];
$importe_pasar=$_GET["importe"];
$iva_pasar=$_GET["iva"];

if($iva >0 )
{
    $iva_porc=12;
}
 else {
    $iva_porc=0;
}
$query_l="SELECT l.cantidad as cantidad, l.costo as costo, p.nombre as nombre FROM factulineaptmp_consig l INNER JOIN producto p
          ON l.id_articulo = p.id_producto
          WHERE l.codfactura = ".$codfactura." AND l.numlinea = ".$numlinea;

$rs_l=mysql_query($query_l, $conn);
?>
<html>
<head>
    <title>Modificar Art&iacute;culo</title>
<script>
var cursor;
		if (document.all) {
		// Está utilizando EXPLORER
		cursor='hand';
		} else {
		// Está utilizando MOZILLA/NETSCAPE
		cursor='pointer';
		}



function actualizar_importe()
{
        var precio=document.getElementById("precio").value;
        var cantidad=document.getElementById("cantidad").value;



        total=precio*cantidad;

        var original=parseFloat(total);
        var result=Math.round(original*10000)/10000 ;
        document.getElementById("importe").value=result;
        suma_iva();
}


function suma_iva()
{
        var original=parseFloat(document.getElementById("importe").value);
        var result=Math.round(original*10000)/10000 ;
        document.getElementById("importe").value=result;

        document.getElementById("iva").value=parseFloat(result * parseFloat(document.getElementById("ivaporc").value / 100));
        var original1=parseFloat(document.getElementById("iva").value);
        var result1=Math.round(original1*10000)/10000 ;
        document.getElementById("iva").value=result1;
 
}




function guardar_articulo(importe, iva)
{
    var mensaje="";
            if(document.getElementById("cantidad").value=="")
            {
                mensaje+="   - Ingrese la cantidad.\n";
            }

            if(document.getElementById("precio").value=="0")
            {
                mensaje+="   - Ingrese el precio.\n"
            }
            if(mensaje!="")
            {
                alert("Atencion:\n"+mensaje);
            }
            else
            {



//                parent.opener.document.formulario_lineas.baseimponible.value=parseFloat(parent.document.formulario_lineas.baseimponible.value) - parseFloat(importe);
//		var original=parseFloat(parent.opener.document.formulario_lineas.baseimponible.value);
//		var result=Math.round(original*100)/100 ;
//		parent.opener.document.formulario_lineas.baseimponible.value=result;
//
//		parent.opener.document.formulario_lineas.importeiva.value=parseFloat(parent.opener.document.formulario_lineas.importeiva.value) - parseFloat(iva);
//		var original1=parseFloat(parent.opener.document.formulario_lineas.importeiva.value);
//		var result1=Math.round(original1*100)/100 ;
//		parentopener..document.formulario_lineas.importeiva.value=result1;
//                parent.opener.document.formulario_lineas.iva12.value=result1;
//
//
//                var original5=parseFloat(result) + parseFloat(result1);
//		var result5=Math.round(original5*100)/100 ;
//		parent.opener.document.formulario_lineas.preciototal.value=result5;


                
                document.getElementById("form1").submit();

                

            }
}
</script>
<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>

<body>
    <div id="pagina">
	<div id="zonaContenido">
		<div align="center">
			<div id="tituloForm" class="header">Articulo</div>
			<div id="frmBusqueda">



        <form name="form1" id="form1" method="get" action="guardar_linea.php" >
          <table class="fuente8" width="95%" id="tabla_resultado" name="tabla_resultado" align="center">
                <tr>
                  <td>Producto:<?php echo $codfactura."--".$numlinea?></td>
                  <td><strong><?php  echo mysql_result($rs_l,0,'nombre')?></strong></td>
                </tr>
                <tr>
                    <td width="5%">Cantidad:</td>
                    <td width="40%"><input NAME="cantidad" type="text" class="cajaPequena" id="cantidad" value="<?php echo mysql_result($rs_l,0,'cantidad');?>" maxlength="13" onChange="actualizar_importe()"></td>
                </tr>
                <tr>
                    <td width="5%">Precio:</td>
                    <td width="40%"><input NAME="precio" type="text" class="cajaMedia" id="precio" value="<?php echo mysql_result($rs_l,0,"costo");?>" size="45" maxlength="45" onChange="actualizar_importe()"></td>
                </tr>
                <tr>
                    <td width="5%">Subtotal:</td>
                    <td width="40%"><input NAME="importe" type="text" class="cajaPequena" id="importe" value="<?php echo $importe;?>" maxlength="13"></td>
                </tr>               
                <tr>
                    <td width="5%">Iva:</td>
                    <td width="40%">
                        <input NAME="ivaporc" type="text" class="cajaMinima" id="ivaporc" size="10" maxlength="10" onChange="suma_iva()" readonly value="<?php echo $iva_porc?>">%
                        <input NAME="iva" type="text" class="cajaMedia" id="iva" value="<?php echo $iva;?>" size="45" maxlength="45">&#36;
                    </td>
                </tr>

        </table>


        </div>
</div>

        <table width="100%" border="0">
          <tr>
            <td><div align="center">
              <img src="../img/botonaceptar.jpg"  onClick="guardar_articulo(<?php echo $importe_pasar?>,<?php echo $iva_pasar?>)" border="1" onMouseOver="style.cursor=cursor">
              <img src="../img/botoncerrar.jpg" width="70" height="22" onClick="window.close()" border="1" onMouseOver="style.cursor=cursor">

            </div></td>
          </tr>
        </table>
        <iframe id="frame_datos" name="frame_datos" width="0%" height="0" frameborder="0">
                <ilayer width="0" height="0" id="frame_datos" name="frame_datos"></ilayer>
        </iframe>
            <input id="importe_pasar" name="importe_pasar" value="<?php echo $importe_pasar?>" type="hidden">
            <input id="iva_pasar" name="iva_pasar" value="<?php echo $iva_pasar?>" type="hidden">
       <input id="idproveedor" name="codfactura" value="<?php  echo $codfactura?>" type="hidden">
       <input id="idtelefono" name="numlinea" value="<?php  echo $numlinea?>" type="hidden">

        </form>


</div>
</div>



</body>
</html>
