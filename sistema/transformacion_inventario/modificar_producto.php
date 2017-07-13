<?php   

$idproducto=$_GET["idproducto"];

include_once '../conexion/conexion.php';
include_once 'class/producto.php';

$usuario = new ServidorBaseDatos();
$conn= $usuario->getConexion();

$producto= new Producto();
$row = $producto->get_producto_id($conn, $idproducto);

$query_produc_derivado="SELECT id_producto FROM producto_transformacion WHERE id_transformacion=$idproducto";
$rs_produc_derivado=mysql_query($query_produc_derivado, $conn);
$idarticulo= mysql_result($rs_produc_derivado,0,"id_producto");

$query_articulo="SELECT nombre, costo, pvp, stock, stock_consignacion FROM producto WHERE id_producto=$idarticulo";
$rs_articulo=mysql_query($query_articulo,$conn);

$nombre_articulo= mysql_result($rs_articulo,0,"nombre");
$costo_articulo=mysql_result($rs_articulo,0,"costo");
$pvp_articulo=mysql_result($rs_articulo,0,"pvp");
$stock_articulo=mysql_result($rs_articulo,0,"stock");
$stockconsignacion_articulo=mysql_result($rs_articulo,0,"stock_consignacion");

?>
<html>
	<head>
		<title>Principal</title>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">

                <link href="../calendario/calendar-blue.css" rel="stylesheet" type="text/css">
                <script type="text/JavaScript" language="javascript" src="../calendario/calendar.js"></script>
                <script type="text/JavaScript" language="javascript" src="../calendario/lang/calendar-sp.js"></script>
                <script type="text/JavaScript" language="javascript" src="../calendario/calendar-setup.js"></script>


		<script type="text/javascript" src="../js/validar.js"></script>
		<script language="javascript">
		
		function cancelar() {
			location.href="index.php";
		}
		
		var cursor;
		if (document.all) {
		// Está utilizando EXPLORER
		cursor='hand';
		} else {
		// Está utilizando MOZILLA/NETSCAPE
		cursor='pointer';
		}
		
		function limpiar() {
			document.getElementById("formulario").reset();
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


        function activar_subgrupo(url,obId)
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
                                    obCon.options[i].value=obCod[i].firstChild.nodeValue;
                  obCon.options[i].text=obDes[i].firstChild.nodeValue;
                            }
                    }
            }
            obXHR.send(null);

        }

        function cargainicio(idgrupo)
        {
            url="subgrupo.php?grupo="+idgrupo;
            obId="subgrupo";
            activar_subgrupo(url,obId);
        }



        function ventanaArticulos()
        {

            miPopup = window.open("ver_articulos.php","miwin","width=700,height=580,scrollbars=yes");
            miPopup.focus();

        }


        function convertir()
        {

            var costo=parseFloat(document.getElementById("costo_aux").value);


            var convers=parseFloat(document.getElementById("conversion").value);

            var cantidad=parseFloat(document.getElementById("cantidad_convertir").value);

            var producto=costo/convers;
            var result2=Math.round(producto*10000)/10000;

            document.getElementById("stock").value=Math.round((cantidad*convers)*100)/100;
            document.getElementById("costo").value=result2;
        }

		</script>
	</head>
        <body onload="activar_subgrupo('bodegas.php?idproducto='+<?php  echo $idarticulo;?> ,'Acbobodega')">
		<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header">MODIFICAR PRODUCTO</div>
				<div id="frmBusqueda">
				<form id="formulario" name="formulario" method="post" action="save_producto.php">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
						<tr>
							<td>ID</td>
							<td><?php  echo $idproducto?></td>
						    <td width="42%" rowspan="14" align="left" valign="top"><ul id="lista-errores"></ul></td>
						</tr>
                                                <tr>
                                                    <td width="15%">Codigo</td>
                                                    <td width="43%"><input  NAME="Acodigo" type="text" class="cajaGrande" id="cogigo" value="<?php  echo $row['codigo']?>" size="45" maxlength="45"></td>
                                                </tr>

						<tr>
                                                    <td width="15%">Nombre</td>
                                                    <td width="43%"><input  NAME="Anombre" type="text" class="cajaGrande" id="nombre" value="<?php  echo $row['nombre']?>" size="45" maxlength="45"></td>
                                                </tr>

                                                 <tr style="background: lightblue">
                                                    <td>Producto Derivado</td>
                                                    <td>
                                                        <input NAME="Anombrearticulo" type="text" class="cajaGrande" id="nombrearticulo" value="<?php echo $nombre_articulo?>" size="15" maxlength="15" onClick="ventanaArticulos()" readonly>
                                                        <img src="../img/ver.png" width="16" height="16" onClick="ventanaArticulos()" onMouseOver="style.cursor=cursor" title="Buscar articulos">
														<br/>Bodega:<select name="Acbobodega" id="Acbobodega" class="comboMedio"  ></select>
                                                        <br/>Costo:<input name="costo_aux" id="costo_aux" type="text" value="<?php echo $costo_articulo?>" class="cajaPequena" readonly onchange="convertir()" value="0"> Pvp:<input name="pvp_aux" id="pvp_aux" value="<?php echo $pvp_articulo?>" type="text" class="cajaPequena" readonly>
                                                    </td>
                                                </tr>

                                                <tr style="background: lightblue">
                                                        <td>Factor de Conversion</td>
                                                        <td>
                                                            1 a <input NAME="Aconversion" type="text" class="cajaPequena" id="conversion" size="15" maxlength="15" onchange="convertir()" value="1">
                                                        </td>
                                                </tr>
                                                <tr style="background: lightblue">
                                                        <td><b>Cantidad a Convertir</b></td>
                                                        <td>
                                                            <input NAME="Acantidad_convertir" type="text" class="cajaMedia" id="cantidad_convertir" size="15" maxlength="15" onchange="convertir()" value="0">
                                                        </td>
                                                </tr>



                                                <tr>
                                                    <td width="15%">GRAVA IVA</td>                                                   
                                                    <td width="43%"><input name="iva_show" type="text" class="cajaPequena" id="iva_show" value="<?php echo $row['iva']?>" readonly></td>
                                                </tr>
                                                <tr>
                                                    <td width="15%">Stock</td>
                                                    <td width="43%"><?php echo $row['stock']?> + <input NAME="Astock" type="text" class="cajaPequena" id="stock" value="0" size="15" maxlength="45" readonly></td>
                                                </tr>
                                                <tr>
                                                    <td width="15%">Stock Consignacion</td>
                                                    <td width="43%"><input NAME="astock_consignacion" type="text" class="cajaPequena" id="stock_consignacion" value="<?php  echo $row['stock_consignacion']?>" size="15" maxlength="45"></td>
                                                </tr>
                                                <tr>
                                                    <td width="15%">Costo</td>
                                                    <td width="43%"><input NAME="qcosto" type="text" class="cajaPequena" id="costo" value="<?php  echo $row['costo']?>" size="15" maxlength="45" value="0"></td>
                                                </tr>
                                                <tr>
                                                    <td width="15%">PVP</td>
                                                    <td width="43%"><input NAME="Qpvp" type="text" class="cajaPequena" id="pvp" value="<?php  echo $row['pvp']?>" size="15" maxlength="45"></td>
                                                </tr>
												
												<tr>
                                                    <td width="15%">Utilidad</td>
                                                    <td width="43%"><input NAME="qutilidad" type="text" class="cajaPequena" id="utilidad" size="15" maxlength="45" value="<?php  echo $row['utilidad']?>">%</td>
                                                </tr>
                                                
                                                <tr>
                                                    <td width="17%">Composici&oacute;n</td>
                                                    <td><textarea readonly name="acomposicion" cols="41" rows="2" id="composicion" class="areaTexto"><?php  echo $row['composicion']?></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td width="17%">Aplicaci&oacute;n</td>
                                                    <td><textarea readonly name="aplicacion" cols="41" rows="2" id="aplicacion" class="areaTexto"><?php  echo $row['aplicacion']?></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td width="15%">Proveedor</td>                                                    
                                                       <?php 
                                                        $query_prov="SELECT id_proveedor, empresa FROM proveedor";
                                                        $result_prov=mysql_query($query_prov,$conn);
                                                    ?>
                                                    <td width="43%">
                                                        <select disabled name="Aproveedor" id="proveedor" class="comboGrande">
                                                            <option value="0">Seleccionar Proveedor</option>
                                                        <?php 
                                                            $contador=0;
                                                            while ($contador<mysql_num_rows($result_prov))
                                                            {
                                                                if($row['proveedor']== mysql_result($result_prov,$contador,"id_proveedor"))
                                                                {
                                                        ?>
                                                                <option selected value="<?php echo mysql_result($result_prov,$contador,"id_proveedor")?>"><?php echo mysql_result($result_prov,$contador,"empresa")?></option>
                                                        <?php 
                                                                }
                                                                else
                                                                {
                                                        ?>
                                                                <option value="<?php echo mysql_result($result_prov,$contador,"id_proveedor")?>"><?php echo mysql_result($result_prov,$contador,"empresa")?></option>
                                                         <?php 
                                                                }
                                                            $contador++;
                                                            }
                                                        ?>
                                                        </select>

                                                    </td>
                                                    
                                                </tr>


                                                 <tr>
                                                    <td>Grupo</td>
                                                    <?php 
                                                        $query_grupo="SELECT id_grupo, nombre FROM grupo";
                                                        $result_grupo=mysql_query($query_grupo,$conn);
                                                    ?>
                                                    <td>
                                                        <select disabled name="Agrupo" id="grupo" class="comboGrande" onchange="activar_subgrupo('subgrupo.php?grupo='+this.value,'subgrupo')">
                                                            <option value="0">Seleccionar Grupo</option>
                                                        <?php 
                                                            $contador1=0;
                                                            while ($contador1<mysql_num_rows($result_grupo))
                                                            {
                                                                if($row['grupo']==mysql_result($result_grupo,$contador1,"id_grupo"))
                                                                {

                                                        ?>
                                                            <option selected value="<?php echo mysql_result($result_grupo,$contador1,"id_grupo")?>"><?php echo mysql_result($result_grupo,$contador1,"nombre")?></option>
                                                        <?php 
                                                                }
                                                                else
                                                                {
                                                        ?>
                                                            <option value="<?php echo mysql_result($result_grupo,$contador1,"id_grupo")?>"><?php echo mysql_result($result_grupo,$contador1,"nombre")?></option>
                                                         <?php 
                                                                }
                                                            $contador1++;
                                                            }
                                                        ?>
                                                        </select>
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <td>Subgrupo</td>
                                                    <td>
                                                        <?php 
                                                            $query_subgrupo="SELECT id_subgrupo, nombre FROM subgrupo WHERE id_grupo=".$row['grupo'];
                                                            $result_subgrupo=mysql_query($query_subgrupo,$conn);
                                                        ?>
                                                        <select disabled name="Asubgrupo" id="subgrupo" class="comboGrande" >

                                                         <?php 
                                                            $contador2=0;
                                                            while ($contador2<mysql_num_rows($result_subgrupo))
                                                            {
                                                                if($row['subgrupo']==mysql_result($result_subgrupo,$contador2,"id_subgrupo"))
                                                                {

                                                        ?>
                                                            <option selected value="<?php echo mysql_result($result_subgrupo,$contador2,"id_subgrupo")?>"><?php echo mysql_result($result_subgrupo,$contador2,"nombre")?></option>
                                                        <?php 
                                                                }
                                                                else
                                                                {
                                                        ?>
                                                            <option value="<?php echo mysql_result($result_subgrupo,$contador2,"id_grupo")?>"><?php echo mysql_result($result_subgrupo,$contador2,"nombre")?></option>
                                                         <?php 
                                                                }
                                                            $contador2++;
                                                            }
                                                        ?>
                                                        </select>
                                                    </td>
                                                </tr>


					</table>
			  </div>
				<div id="botonBusqueda">
					<img src="../img/botonaceptar.jpg" width="85" height="22" onClick="validar(formulario,true)" border="1" onMouseOver="style.cursor=cursor">
					<img src="../img/botonlimpiar.jpg" width="69" height="22" onClick="limpiar()" border="1" onMouseOver="style.cursor=cursor">
					<img src="../img/botoncancelar.jpg" width="85" height="22" onClick="cancelar()" border="1" onMouseOver="style.cursor=cursor">


                                        <input name="stock_producto" id="stock_producto" value="<?php echo $stock_articulo?>" type="hidden">
                                        <input name="stockconsignacion_producto" id="stockconsignacion_producto" value="<?php echo $stockconsignacion_articulo?>" type="hidden">
                                        <input name="id_producto" id="id_producto" value="<?php echo $idarticulo?>" type="hidden">
                                        <input name="iva" type="hidden" id="iva" value="<?php echo $row['iva']?>">



                                        <input id="accion" name="accion" value="modificar" type="hidden">
					<input id="id" name="id" value="" type="hidden">
					<input id="idproducto" name="idproducto" value="<?php  echo $idproducto?>" type="hidden">
			  </div>
			  </form>
		  </div>
		  </div>
		</div>
	</body>
</html>
