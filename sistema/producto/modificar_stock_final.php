<?php 
include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$idproducto=$_GET["idproducto"];
$idbodega=$_GET["idbodega"];


$query="SELECT o.nombre as nombre,  b.stock as stock FROM bodega o INNER JOIN productobodega b ON o.id_bodega=b.id_bodega  WHERE (b.id_producto =$idproducto) AND (b.id_bodega= $idbodega)";
$result = mysql_query($query, $conn);
$stock = mysql_result($result,0,"stock");
$bodega = mysql_result($result,0,"nombre");

$query="SELECT nombre FROM producto  WHERE id_producto = $idproducto";
$result = mysql_query($query, $conn);
$producto = mysql_result($result,0,"nombre");



?>
<html>
<head>
    <title>Modificar STOCK</title>
<script>
var cursor;
		if (document.all) {
		// Está utilizando EXPLORER
		cursor='hand';
		} else {
		// Está utilizando MOZILLA/NETSCAPE
		cursor='pointer';
		}







function guardar_articulo(importe, iva)
{
    var mensaje="";
            if(document.getElementById("astock").value=="")
            {
                mensaje+="   - Ingrese la cantidad.\n";
            }

           
            if(mensaje!="")
            {
                alert("Atencion:\n"+mensaje);
            }
            else
            {
               
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
			<div id="tituloForm" class="header">STOCK <?php echo $idproducto . "-" .$idbodega?></div>
			<div id="frmBusqueda">



        <form name="form1" id="form1" method="get" action="guardar_stock_final.php" >
          <table class="fuente8" width="95%" id="tabla_resultado" name="tabla_resultado" align="center">
                <tr>
                  <td>Producto:</td>
                  <td><strong><?php  echo $producto ?></strong></td>
                </tr>
                <tr>
                    <td width="5%">Bodega:</td>
                    <td width="40%"><?php  echo $bodega?></td>
                </tr>
                <tr>
                    <td width="5%">STOCK:</td>
                    <td width="40%"><input NAME="astock" type="text" class="cajaPequena" id="astock" value="<?php  echo $stock?>"></td>
                    
                </tr>               

        </table>


        </div>
</div>

        <table width="100%" border="0">
          <tr>
            <td><div align="center">
              <img src="../img/botonaceptar.jpg"  onClick="guardar_articulo()" border="1" onMouseOver="style.cursor=cursor">
              <img src="../img/botoncerrar.jpg" width="70" height="22" onClick="window.close()" border="1" onMouseOver="style.cursor=cursor">

            </div></td>
          </tr>
        </table>

            <input id="idbodega" name="idbodega" value="<?php  echo $idbodega?>" type="hidden">
            <input id="idproducto" name="idproducto" value="<?php  echo $idproducto?>" type="hidden">
           
            

        </form>


</div>
</div>



</body>
</html>
