<?php  
include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$transferenciatmp=$_GET["transferenciatmp"];
$numlinea=$_GET["numlinea"];

$query_l="SELECT l.id_producto as idarticulo, l.cantidad as cantidad, l.id_bodegaorigen as bodegaorigen,  l.id_bodegadestino as bodegadestino, p.nombre as nombre 
		  FROM transferencialineatmp l INNER JOIN producto p
          ON l.id_producto = p.id_producto
          WHERE l.id_transferencia = ".$transferenciatmp." AND l.numlinea = ".$numlinea;

		  
	  
$rs_l=mysql_query($query_l, $conn);

$idarticulo = mysql_result($rs_l, 0,"idarticulo");	
$idbodegaorigen = mysql_result($rs_l, 0,"bodegaorigen");
$idbodegadestino 	= mysql_result($rs_l, 0,"bodegadestino");
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






function guardar_articulo()
{
    var mensaje="";
            if(document.getElementById("cantidad").value=="")
            {
                mensaje+="   - Ingrese la cantidad.\n";
            }

            if(document.getElementById("cbobodegaorigen").value == document.getElementById("cbobodegadestino").value)
            {
                mensaje+="   -Bodega origen no puede ser igual a bodega destino.\n"
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

function carga(idarticulo,idbodega){
	activar_subgrupo('bodegasmodificar.php?idproducto='+idarticulo ,'cbobodegaorigen',idbodega);
}



// creando objeto XMLHttpRequest de Ajax
        var obXHR;
        try {
                obXHR=new XMLHttpRequest();
        } catch(err) {
                try {
                        obXHR=new ActiveXObject("Msxml2.XMLHTTP");
                } catch(err) {
                        try {
                                obXHR=new ActiveXObject("Microsoft.XMLHTTP");
                        } catch(err) {
                                obXHR=false;
                        }
                }
        }
			
		function activar_subgrupo(url,obId,idbodega)
        {
            document.getElementById(obId).disabled=false;
            
            var obCon = document.getElementById(obId);
            obXHR.open("GET", url);
            obXHR.onreadystatechange = function() {
                    if (obXHR.readyState == 4 && obXHR.status == 200) {
                            obXML = obXHR.responseXML;
                            obCod = obXML.getElementsByTagName("id");
                            obDes = obXML.getElementsByTagName("nombre");
                            obCon.length=obCod.length;
                            for (var i=0; i<obCod.length;i++) {
								
								if(obCod[i].firstChild.nodeValue == idbodega){
									obCon.options[i].value=obCod[i].firstChild.nodeValue;
									obCon.options[i].text=obDes[i].firstChild.nodeValue;
									obCon.options[i].selected=true;
								}else{
									obCon.options[i].value=obCod[i].firstChild.nodeValue;
									obCon.options[i].text=obDes[i].firstChild.nodeValue;
								}
                                   
                            }
                    }
            }
            obXHR.send(null);
            
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

<body onload="carga(<?php  echo $idarticulo;?>,<?php  echo $idbodegaorigen?>)">
    <div id="pagina">
	<div id="zonaContenido">
		<div align="center">
			<div id="tituloForm" class="header">Articulo</div>
			<div id="frmBusqueda">



        <form name="form1" id="form1" method="get" action="guardar_linea.php"  >
          <table class="fuente8" width="95%" id="tabla_resultado" name="tabla_resultado" align="center">
                <tr>
                  <td>Producto:</td>
                  <td><strong><?php   echo mysql_result($rs_l,0,'nombre')?></strong></td>
                </tr>
				
				<td>Bodega Origen</td>
					<td>
												
							<select name="cbobodegaorigen" id="cbobodegaorigen" class="comboMedio" ></select>
					
					</td>
				
				<tr>
					<td>Bodega Destino</td>
					<td>
					<?php  
						$idproducto = mysql_result($rs_l,0,'idarticulo');
						$queryb = "SELECT b.id_bodega as idbodega, b.nombre as nombre FROM bodega b";
							   $resb = mysql_query($queryb, $conn);?>
					
						<select name="cbobodegadestino" id="cbobodegadestino" class="comboMedio" >
						
						<?php 
						
								$contador=0;
								while ($contador < mysql_num_rows($resb))
								{
									if(mysql_result($resb,$contador,"idbodega")==$idbodegadestino)
									{?>
										<option selected value="<?php  echo mysql_result($resb,$contador,"idbodega")?>"><?php  echo mysql_result($resb,$contador,"nombre");?></option>
									   


									 <?php  } else {?>
										<option  value="<?php  echo mysql_result($resb,$contador,"idbodega")?>"><?php  echo mysql_result($resb,$contador,"nombre");?></option>
								<?php  }$contador++;
								} ?>
						
						
						
						</select>	
					</td>
				</tr>
                <tr>
                    <td width="5%">Cantidad:</td>
                    <td width="40%"><input NAME="cantidad" type="text" class="cajaPequena" id="cantidad" value="<?php  echo mysql_result($rs_l,0,'cantidad');?>" maxlength="13" onChange="actualizar_importe()"></td>
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
        <iframe id="frame_datos" name="frame_datos" width="0%" height="0" frameborder="0">
                <ilayer width="0" height="0" id="frame_datos" name="frame_datos"></ilayer>
        </iframe>
           
       <input id="transferenciatmp" name="transferenciatmp" value="<?php   echo $transferenciatmp?>" type="hidden">
       <input id="numlinea" name="numlinea" value="<?php   echo $numlinea?>" type="hidden">

        </form>


</div>
</div>



</body>
</html>
