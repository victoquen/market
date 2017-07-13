<?php   
include ("../conexion/conexion.php");
error_reporting(0);
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$fechahoy=date("Y-m-d");
/*$sel_fact="INSERT INTO facturastmp (codfactura,fecha) VALUE ('','$fechahoy')";
$rs_fact=mysql_query($sel_fact, $conn);
$codfacturatmp=mysql_insert_id();*/


//numero factura
$sel_facturero="select serie1, serie2, autorizacion, inicio, fin, fecha_caducidad FROM proformero where id_proformero=1";
$rs_facturero=mysql_query($sel_facturero, $conn);
$serie1=mysql_result($rs_facturero,0,"serie1");
$serie2=mysql_result($rs_facturero,0,"serie2");
$autorizacion=mysql_result($rs_facturero,0,"autorizacion");
$inicio=mysql_result($rs_facturero,0,"inicio");
$fin=mysql_result($rs_facturero,0,"fin");
$fecha_caducidad=mysql_result($rs_facturero,0,"fecha_caducidad");

//numero de factura maximo
$sel_max="SELECT max(codigo_factura)as maximo FROM proformas";
$rs_max=mysql_query($sel_max,$conn);
$maximo=mysql_result($rs_max,0,"maximo");
if(($maximo==0)||($maximo<$inicio)){

     $maximo=$inicio;
}
else {
       $maximo=$maximo+1;
     
}

$fechah=strtotime($fechahoy,0);
$fechac=strtotime($fecha_caducidad,0);

if(($maximo>=$inicio)&&($maximo<=$fin)){
    $aceptacion=1;
    $mensaje_aceptacion="todo valido";
}
else{
    $aceptacion=0;
    $mensaje_aceptacion="Numeracion de Facturero Caducado, no se podra facturar. Por Favor Actualizar datos de la Proforma.";
}


?>




<html>
	<head>
		<title>Principal</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
		<link href="../calendario/calendar-blue.css" rel="stylesheet" type="text/css">
		<script type="text/JavaScript" language="javascript" src="../calendario/calendar.js"></script>
		<script type="text/JavaScript" language="javascript" src="../calendario/lang/calendar-sp.js"></script>
		<script type="text/JavaScript" language="javascript" src="../calendario/calendar-setup.js"></script>
		<script type="text/JavaScript" language="javascript" src="js/articulos_factura.js"></script>
		<script language="javascript">
		var cursor;
		if (document.all) {
		// Está utilizando EXPLORER
		cursor='hand';
		} else {
		// Está utilizando MOZILLA/NETSCAPE
		cursor='pointer';
		}
		
               function inicio(aceptacion, mensaje)
               {
                   if(aceptacion==0){
                       alert(mensaje);
                       location.href="index.php";
                   }
               }
               


		</script>
	</head>
        <body onload="inicio('<?php   echo $aceptacion?>','<?php   echo $mensaje_aceptacion?>')" >
		<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header">INSERTAR PROFORMA VENTA</div>
				<div id="frmBusqueda">
				<form id="formulario" name="formulario" method="post" action="guardar_factura.php">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
<!--                                                <tr>
                                                    <td width="6%">No. Factura</td>
                                                    <td width="35%">                                                       
                                                        <input NAME="codfactura" type="text" class="cajaPequena" id="codfactura" value="<?php  echo $maximo?>" readonly>
                                                    </td>                                                    
                                                </tr>-->
                                                <tr>
                                                        <td width="6%">Nombre</td>
                                                        <td width="35%"><input NAME="nombre" type="text" class="cajaGrande" id="nombre" size="45" maxlength="45" onClick="abreVentana()" readonly>
                                                             <img src="../img/ver.png" width="16" height="16" onClick="abreVentana()" title="Buscar cliente" onMouseOver="style.cursor=cursor">
                                                        </td>
							<td width="10%">C&oacute;digo Cliente</td>
                                                        <td width="25%"><input NAME="codcliente" type="text" class="cajaPequena" id="codcliente" size="6" maxlength="5" onClick="limpiarcaja()" readonly>
                                                       </td>

                                                       <td width="35%" rowspan="3" align="center">PROFORMA<br/><br/>
                                                       <input  NAME="codfactura" type="text" class="cajaMinimaFactura" id="codfactura" value="<?php   echo $maximo?>" >
                                                       </td>
<!--                                                        <td width="8%">Tipo Cliente</td>
                                                        <td><input name="tipocliente" id="tipocliente" class="cajaMedia" type="text" readonly></td>-->
						</tr>
						<tr>
                                                    
                                                    <td >CI/RUC</td>
                                                    <td  colspan="4"><input NAME="ci_ruc" type="text" class="cajaMedia" id="ci_ruc" size="20" maxlength="15" readonly></td>
                                                    
						</tr>
                                                <tr>
                                                    <td >Tipo Cliente</td>
                                                    <td  colspan="4">
                                                        <input NAME="tipo_cliente" type="text" class="cajaPequena" id="tipo_cliente" size="20" maxlength="15" readonly>
                                                         Guia Remision:
                                                         <select name="cboremision" id="cboremision" class="comboPequeno">
                                                                <option value="0">No</option>
                                                                <option value="1">Si</option>
                                                         </select>
                                                    </td>
                                                </tr>

						<?php   $hoy=date("d/m/Y"); ?>
						<tr>
                                                    <td >Fecha</td>
						    <td ><input NAME="fecha" type="text" class="cajaPequena" id="fecha" size="10" maxlength="10" value="<?php   echo $hoy?>" readonly> <img src="../img/calendario.png" name="Image1" id="Image1" width="16" height="16" border="0" id="Image1" onMouseOver="this.style.cursor='pointer'">
                                                        <script type="text/javascript">
                                                                                Calendar.setup(
                                                                                  {
                                                                                inputField : "fecha",
                                                                                ifFormat   : "%d/%m/%Y",
                                                                                button     : "Image1"
                                                                                  }
                                                                                );
                                                        </script></td>
                                                    

                                                        <td >CREDITO</td>
                                                        <td>
                                                            <select name="cbocredito" id="cbocredito" class="comboPequeno" onchange="activar_plazo(this.selectedIndex)">
                                                                <option value="0">No</option>
                                                                <option value="1">Si</option>
                                                                <option value="2" selected></option>
                                                            </select>

                                                            <select name="cboplazo" id="cboplazo" class="comboPequeno" disabled="true">
                                                                <option value="0">0 d&iacute;as</option>
                                                                <option value="1">30 d&iacute;as</option>
                                                                <option value="2">60 d&iacute;as</option>
                                                                <option value="3">90 d&iacute;as</option>
                                                                <option value="4">120 d&iacute;as</option>
                                                                <option value="5">150 d&iacute;as</option>
                                                                <option value="6">180 d&iacute;as</option>
                                                                <option value="7">210 d&iacute;as</option>
                                                                <option value="8">240 d&iacute;as</option>
                                                                <option value="9">270 d&iacute;as</option>
                                                                <option value="10">300 d&iacute;as</option>
                                                                <option value="11">330 d&iacute;as</option>
                                                                <option value="12">360 d&iacute;as</option>
                                                            </select>

                                                        </td>
                                                        
                                                        
                                                </tr>
					</table>										
			  </div>

                                <input NAME="serie1" type="hidden"  id="serie1" value="<?php  echo $serie1?>" >
                                <input NAME="serie2" type="hidden"  id="serie2" value="<?php  echo $serie2?>">
                                <input NAME="autorizacion" type="hidden"  id="autorizacion" value="<?php  echo $autorizacion?>" >

                          <!--
                         
			  <input id="accion" name="accion" value="alta" type="hidden">-->
			 <!-- </form>-->


                                    <br>
			  <div id="frmBusqueda">
			<!--	<form id="formulario_lineas" name="formulario_lineas" method="post" action="frame_lineas.php" target="frame_lineas">-->
				<div id="tituloForm" class="header">PRODUCTOS</div>
                                    <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=1>
                                        <tr class="cabeceraTabla">
                                            <td width="8%">COD</td>
                                            <td width="40%">DESCRIPCION</td>
                                            <td width="5%">CANT</td>
                                            <td width="8%">PRECIO &#36;</td>
                                           
                                            <td width="12%">DCTO</td>
                                            
                                            <td width="8%">SUBT. &#36;</td>
					    <td width="4%">&nbsp;</td>
                                        </tr>
                                        <!--************************************************************************************************ -->
                                        <!--INICIO ITEM No. 1 de la Factura----------------------------------------------------------------- -->

                                        <tr class="itemImparTabla">
                                            <td ><input NAME="codarticulo1" id="codarticulo1" type="text" class="cajaPequena"  size="15" maxlength="15" readonly></td>
                                            <td >
                                                <img src="../img/ver.png" width="16" height="16" onClick="ventanaArticulos(1)" onMouseOver="style.cursor=cursor" title="Buscar articulos">
                                                <input NAME="descripcion1" id="descripcion1" type="text" class="cajaExtraGrande"  onClick="ventanaArticulos(1)" readonly>
						<input style="display: none" name="grabaiva1" id="grabaiva1" class="cajaExtraMinima" readonly>
                                            </td>
                                            <td align="center"><input NAME="cantidad1" id="cantidad1" type="text" class="cajaMinima" size="10" maxlength="10" value="1" onChange="actualizar_importe(1)"></td>
                                            <td align="center"><input NAME="precio1" id="precio1" type="text" class="cajaPequena2" size="10" maxlength="10" onChange="actualizar_importe(1)"></td>
                                            
                                            <td align="center">
                                                <input NAME="descuentoporc1" id="descuentoporc1" type="text" class="cajaMinima" size="10" maxlength="10" onChange="actualizar_descuento(1)" value="0">%
                                                <input NAME="descuento1" id="descuento1" type="text" class="cajaPequena2" size="10" maxlength="10" value="0" readonly>&#36;
                                            </td>
                                            
                                            <td align="center"><input NAME="subt1" id="subt1" type="text" class="cajaPequena2" value="0"  readonly></td>
                                            <td align="center"><img src="../img/eliminar.png" width="16" height="16" onClick="limpiar_articulo(1)" onMouseOver="style.cursor=cursor" title="Eliminar"> </td>                                           
                                        </tr>

                                        <input NAME="importe1" id="importe1" type="hidden" value="0">
                                        <input NAME="ivaporc1" id="ivaporc1" type="hidden" onChange="suma_iva(1)">
                                        <input NAME="iva1" id="iva1" type="hidden" value="0">

                                        <input name="idarticulo1" id="idarticulo1"  type="hidden" >
                                        <input name="costo1" id="costo1"  type="hidden" >
                                        <input name="stock1" id="stock1" type="hidden">

                                        <input name="transformacion1" id="transformacion1" type="hidden">
                                        <input name="precio_con_iva1" id="precio_con_iva1" type="hidden">
                                        <input name="importe_con_iva1" id="importe_con_iva1" type="hidden">
                                        <!--FIN ITEM No. 1 de la Factura-------------------------------------------------------------------- -->
                                        <!--************************************************************************************************ -->

                                        <!--************************************************************************************************ -->
                                        <!--INICIO ITEM No. 2 de la Factura----------------------------------------------------------------- -->

                                        <tr class="itemParTabla">
                                            <td ><input NAME="codarticulo2" id="codarticulo2" type="text" class="cajaPequena"  size="15" maxlength="15" readonly></td>
                                            <td >
                                                <img src="../img/ver.png" width="16" height="16" onClick="ventanaArticulos(2)" onMouseOver="style.cursor=cursor" title="Buscar articulos">
                                                <input NAME="descripcion2" id="descripcion2" type="text" class="cajaExtraGrande" size="30" maxlength="30" onClick="ventanaArticulos(2)" readonly>
                                            	<input style="display: none" name="grabaiva2" id="grabaiva2" class="cajaExtraMinima" readonly>
					    </td>
                                            <td align="center"><input NAME="cantidad2" id="cantidad2" type="text" class="cajaMinima" size="10" maxlength="10" value="1" onChange="actualizar_importe(2)"></td>
                                            <td align="center"><input NAME="precio2" id="precio2" type="text" class="cajaPequena2" size="10" maxlength="10" onChange="actualizar_importe(2)"></td>
                                            
                                            <td align="center">
                                                <input NAME="descuentoporc2" id="descuentoporc2" type="text" class="cajaMinima" size="10" maxlength="10" onChange="actualizar_descuento(2)" value="0">%
                                                <input NAME="descuento2" id="descuento2" type="text" class="cajaPequena2" size="10" maxlength="10" value="0" readonly>&#36;
                                            </td>
                                            
                                            <td align="center"><input NAME="subt2" id="subt2" type="text" class="cajaPequena2" value="0" onchange="actualizar_totales(2)" readonly></td>
                                            <td align="center"><img src="../img/eliminar.png" width="16" height="16" onClick="limpiar_articulo(2)" onMouseOver="style.cursor=cursor" title="Eliminar"> </td>
                                        </tr>

                                        <input NAME="importe2" id="importe2" type="hidden" value="0">
                                        <input NAME="ivaporc2" id="ivaporc2" type="hidden" onChange="suma_iva(2)">
                                        <input NAME="iva2" id="iva2" type="hidden" value="0">

                                        <input name="idarticulo2" id="idarticulo2"  type="hidden" >
                                        <input name="costo2" id="costo2"  type="hidden" >
                                        <input name="stock2" id="stock2" type="hidden">

                                        <input name="transformacion2" id="transformacion2" type="hidden">
                                        <input name="precio_con_iva2" id="precio_con_iva2" type="hidden">
                                        <input name="importe_con_iva2" id="importe_con_iva2" type="hidden">
                                        <!--FIN ITEM No. 2 de la Factura-------------------------------------------------------------------- -->
                                        <!--************************************************************************************************ -->

                                        <!--************************************************************************************************ -->
                                        <!--INICIO ITEM No. 3 de la Factura----------------------------------------------------------------- -->

                                        <tr class="itemImparTabla">
                                            <td ><input NAME="codarticulo3" id="codarticulo3" type="text" class="cajaPequena"  size="15" maxlength="15" readonly></td>
                                            <td >
                                                <img src="../img/ver.png" width="16" height="16" onClick="ventanaArticulos(3)" onMouseOver="style.cursor=cursor" title="Buscar articulos">
                                                <input NAME="descripcion3" id="descripcion3" type="text" class="cajaExtraGrande" size="30" maxlength="30" onClick="ventanaArticulos(3)" readonly>
						<input style="display: none" name="grabaiva3" id="grabaiva3" class="cajaExtraMinima" readonly>
                                            </td>
                                            <td align="center"><input NAME="cantidad3" id="cantidad3" type="text" class="cajaMinima" size="10" maxlength="10" value="1" onChange="actualizar_importe(3)"></td>
                                            <td align="center"><input NAME="precio3" id="precio3" type="text" class="cajaPequena2" size="10" maxlength="10" onChange="actualizar_importe(3)"></td>
                                            
                                            <td align="center">
                                                <input NAME="descuentoporc3" id="descuentoporc3" type="text" class="cajaMinima" size="10" maxlength="10" onChange="actualizar_descuento(3)" value="0">%
                                                <input NAME="descuento3" id="descuento3" type="text" class="cajaPequena2" size="10" maxlength="10" value="0" readonly>&#36;
                                            </td>                                            
                                            <td align="center"><input NAME="subt3" id="subt3" type="text" class="cajaPequena2" value="0" onchange="actualizar_totales(3)" readonly></td>
                                            <td align="center"><img src="../img/eliminar.png" width="16" height="16" onClick="limpiar_articulo(3)" onMouseOver="style.cursor=cursor" title="Eliminar"> </td>                                        
					</tr>


                                        <input NAME="importe3" id="importe3" type="hidden" value="0">
                                        <input NAME="ivaporc3" id="ivaporc3" type="hidden" onChange="suma_iva(3)">
                                        <input NAME="iva3" id="iva3" type="hidden" value="0">

                                        <input name="idarticulo3" id="idarticulo3" value="<?php   echo $idarticulo?>" type="hidden" >
                                        <input name="costo3" id="costo3" value="<?php   echo $costo?>" type="hidden" >
                                        <input name="stock3" id="stock3" type="hidden">

                                        <input name="transformacion3" id="transformacion3" type="hidden">
                                        <input name="precio_con_iva3" id="precio_con_iva3" type="hidden">
                                        <input name="importe_con_iva3" id="importe_con_iva3" type="hidden">
                                        <!--FIN ITEM No. 3 de la Factura-------------------------------------------------------------------- -->
                                        <!--************************************************************************************************ -->
                                        
                                        
                                        <!--************************************************************************************************ -->
                                        <!--INICIO ITEM No. 4 de la Factura----------------------------------------------------------------- -->

                                        <tr class="itemParTabla">
                                            <td ><input NAME="codarticulo4" id="codarticulo4" type="text" class="cajaPequena"  size="15" maxlength="15" readonly></td>
                                            <td >
                                                <img src="../img/ver.png" width="16" height="16" onClick="ventanaArticulos(4)" onMouseOver="style.cursor=cursor" title="Buscar articulos">
                                                <input NAME="descripcion4" id="descripcion4" type="text" class="cajaExtraGrande" size="30" maxlength="30" onClick="ventanaArticulos(4)" readonly>
						<input style="display: none" name="grabaiva4" id="grabaiva4" class="cajaExtraMinima" readonly>
                                            </td>
                                            <td align="center"><input NAME="cantidad4" id="cantidad4" type="text" class="cajaMinima" size="10" maxlength="10" value="1" onChange="actualizar_importe(4)"></td>
                                            <td align="center"><input NAME="precio4" id="precio4" type="text" class="cajaPequena2" size="10" maxlength="10" onChange="actualizar_importe(4)" ></td>
                                            
                                            <td align="center">
                                                <input NAME="descuentoporc4" id="descuentoporc4" type="text" class="cajaMinima" size="10" maxlength="10" onChange="actualizar_descuento(4)" value="0">%
                                                <input NAME="descuento4" id="descuento4" type="text" class="cajaPequena2" size="10" maxlength="10" value="0" readonly>&#36;
                                            </td>
                                            
                                            <td align="center"><input NAME="subt4" id="subt4" type="text" class="cajaPequena2" value="0" onchange="actualizar_totales(4)" readonly></td>
                                            <td align="center"><img src="../img/eliminar.png" width="16" height="16" onClick="limpiar_articulo(4)" onMouseOver="style.cursor=cursor" title="Eliminar"> </td>                                        
					</tr>

                                        <input NAME="importe4" id="importe4" type="hidden" value="0">
                                        <input NAME="ivaporc4" id="ivaporc4" type="hidden" onChange="suma_iva(4)">
                                        <input NAME="iva4" id="iva4" type="hidden" value="0">

                                        <input name="idarticulo4" id="idarticulo4" value="<?php   echo $idarticulo?>" type="hidden" >
                                        <input name="costo4" id="costo4" value="<?php   echo $costo?>" type="hidden" >
                                        <input name="stock4" id="stock4" type="hidden">

                                        <input name="transformacion4" id="transformacion4" type="hidden">
                                        <input name="precio_con_iva4" id="precio_con_iva4" type="hidden">
                                        <input name="importe_con_iva4" id="importe_con_iva4" type="hidden">
                                        <!--FIN ITEM No. 4 de la Factura-------------------------------------------------------------------- -->
                                        <!--************************************************************************************************ -->


                                        <!--************************************************************************************************ -->
                                        <!--INICIO ITEM No. 5 de la Factura----------------------------------------------------------------- -->

                                        <tr class="itemImparTabla">
                                            <td ><input NAME="codarticulo5" id="codarticulo5" type="text" class="cajaPequena"  size="15" maxlength="15" readonly></td>
                                            <td >
                                                <img src="../img/ver.png" width="16" height="16" onClick="ventanaArticulos(5)" onMouseOver="style.cursor=cursor" title="Buscar articulos">
                                                <input NAME="descripcion5" id="descripcion5" type="text" class="cajaExtraGrande" size="30" maxlength="30" onClick="ventanaArticulos(5)" readonly>
						<input style="display: none" name="grabaiva5" id="grabaiva5" class="cajaExtraMinima" readonly>
                                            </td>
                                            <td align="center"><input NAME="cantidad5" id="cantidad5" type="text" class="cajaMinima" size="10" maxlength="10" value="1" onChange="actualizar_importe(5)"></td>
                                            <td align="center"><input NAME="precio5" id="precio5" type="text" class="cajaPequena2" size="10" maxlength="10" onChange="actualizar_importe(5)"></td>
                                            
                                            <td align="center">
                                                <input NAME="descuentoporc5" id="descuentoporc5" type="text" class="cajaMinima" size="10" maxlength="10" onChange="actualizar_descuento(5)" value="0">%
                                                <input NAME="descuento5" id="descuento5" type="text" class="cajaPequena2" size="10" maxlength="10" value="0" readonly>&#36;
                                            </td>
                                            
                                            <td align="center"><input NAME="subt5" id="subt5" type="text" class="cajaPequena2" value="0" onchange="actualizar_totales(5)" readonly></td>
                                            <td align="center"><img src="../img/eliminar.png" width="16" height="16" onClick="limpiar_articulo(5)" onMouseOver="style.cursor=cursor" title="Eliminar"> </td>                                        
					</tr>

                                        <input NAME="importe5" id="importe5" type="hidden" value="0">
                                        <input NAME="ivaporc5" id="ivaporc5" type="hidden" onChange="suma_iva(5)">
                                        <input NAME="iva5" id="iva5" type="hidden" value="0">

                                        <input name="idarticulo5" id="idarticulo5" value="<?php   echo $idarticulo?>" type="hidden" >
                                        <input name="costo5" id="costo5" value="<?php   echo $costo?>" type="hidden" >
                                        <input name="stock5" id="stock5" type="hidden">

                                        <input name="transformacion5" id="transformacion5" type="hidden">
                                        <input name="precio_con_iva5" id="precio_con_iva5" type="hidden">
                                        <input name="importe_con_iva5" id="importe_con_iva5" type="hidden">
                                        <!--FIN ITEM No. 5 de la Factura-------------------------------------------------------------------- -->
                                        <!--************************************************************************************************ -->


                                        <!--************************************************************************************************ -->
                                        <!--INICIO ITEM No. 6 de la Factura----------------------------------------------------------------- -->

                                        <tr class="itemParTabla">
                                            <td ><input NAME="codarticulo6" id="codarticulo6" type="text" class="cajaPequena"  size="15" maxlength="15" readonly></td>
                                            <td >
                                                <img src="../img/ver.png" width="16" height="16" onClick="ventanaArticulos(6)" onMouseOver="style.cursor=cursor" title="Buscar articulos">
                                                <input NAME="descripcion6" id="descripcion6" type="text" class="cajaExtraGrande" size="30" maxlength="30" onClick="ventanaArticulos(6)"  readonly>
						<input style="display: none" name="grabaiva6" id="grabaiva6" class="cajaExtraMinima" readonly>
                                            </td>
                                            <td align="center"><input NAME="cantidad6" id="cantidad6" type="text" class="cajaMinima" size="10" maxlength="10" value="1" onChange="actualizar_importe(6)"></td>
                                            <td align="center"><input NAME="precio6" id="precio6" type="text" class="cajaPequena2" size="10" maxlength="10" onChange="actualizar_importe(6)"></td>
                                            
                                            <td align="center">
                                                <input NAME="descuentoporc6" id="descuentoporc6" type="text" class="cajaMinima" size="10" maxlength="10" onChange="actualizar_descuento(6)" value="0">%
                                                <input NAME="descuento6" id="descuento6" type="text" class="cajaPequena2" size="10" maxlength="10" value="0" readonly>&#36;
                                            </td>
                                            
                                            <td align="center"><input NAME="subt6" id="subt6" type="text" class="cajaPequena2" value="0" onchange="actualizar_totales(6)" readonly></td>
                                            <td align="center"><img src="../img/eliminar.png" width="16" height="16" onClick="limpiar_articulo(6)" onMouseOver="style.cursor=cursor" title="Eliminar"> </td>                                        
					</tr>

                                        <input NAME="importe6" id="importe6" type="hidden" value="0">
                                        <input NAME="ivaporc6" id="ivaporc6" type="hidden" onChange="suma_iva(6)">
                                        <input NAME="iva6" id="iva6" type="hidden" value="0">

                                        <input name="idarticulo6" id="idarticulo6" value="<?php   echo $idarticulo?>" type="hidden" >
                                        <input name="costo6" id="costo6" value="<?php   echo $costo?>" type="hidden" >
                                        <input name="stock6" id="stock6" type="hidden">

                                        <input name="transformacion6" id="transformacion6" type="hidden">
                                        <input name="precio_con_iva6" id="precio_con_iva6" type="hidden">
                                        <input name="importe_con_iva6" id="importe_con_iva6" type="hidden">
                                        <!--FIN ITEM No. 6 de la Factura-------------------------------------------------------------------- -->
                                        <!--************************************************************************************************ -->


                                        <!--************************************************************************************************ -->
                                        <!--INICIO ITEM No. 7 de la Factura----------------------------------------------------------------- -->

                                        <tr class="itemImparTabla">
                                            <td ><input NAME="codarticulo7" id="codarticulo7" type="text" class="cajaPequena"  size="15" maxlength="15" readonly></td>
                                            <td >
                                                <img src="../img/ver.png" width="16" height="16" onClick="ventanaArticulos(7)" onMouseOver="style.cursor=cursor" title="Buscar articulos">
                                                <input NAME="descripcion7" id="descripcion7" type="text" class="cajaExtraGrande" size="30" maxlength="30" onClick="ventanaArticulos(7)" readonly>
						<input style="display: none" name="grabaiva7" id="grabaiva7" class="cajaExtraMinima" readonly>
                                            </td>
                                            <td align="center"><input NAME="cantidad7" id="cantidad7" type="text" class="cajaMinima" size="10" maxlength="10" value="1" onChange="actualizar_importe(7)"></td>
                                            <td align="center"><input NAME="precio7" id="precio7" type="text" class="cajaPequena2" size="10" maxlength="10" onChange="actualizar_importe(7)"></td>
                                            
                                            <td align="center">
                                                <input NAME="descuentoporc7" id="descuentoporc7" type="text" class="cajaMinima" size="10" maxlength="10" onChange="actualizar_descuento(7)" value="0">%
                                                <input NAME="descuento7" id="descuento7" type="text" class="cajaPequena2" size="10" maxlength="10" value="0" readonly>&#36;
                                            </td>
                                            
                                            <td align="center"><input NAME="subt7" id="subt7" type="text" class="cajaPequena2" value="0" onchange="actualizar_totales(7)" readonly></td>
                                            <td align="center"><img src="../img/eliminar.png" width="16" height="16" onClick="limpiar_articulo(7)" onMouseOver="style.cursor=cursor" title="Eliminar"> </td>                                        
					</tr>

                                        <input NAME="importe7" id="importe7" type="hidden" value="0">
                                        <input NAME="ivaporc7" id="ivaporc7" type="hidden" onChange="suma_iva(7)">
                                        <input NAME="iva7" id="iva7" type="hidden" value="0">

                                        <input name="idarticulo7" id="idarticulo7" value="<?php   echo $idarticulo?>" type="hidden" >
                                        <input name="costo7" id="costo7" value="<?php   echo $costo?>" type="hidden" >
                                        <input name="stock7" id="stock7" type="hidden">

                                        <input name="transformacion7" id="transformacion7" type="hidden">
                                        <input name="precio_con_iva7" id="precio_con_iva7" type="hidden">
                                        <input name="importe_con_iva7" id="importe_con_iva7" type="hidden">
                                        <!--FIN ITEM No. 7 de la Factura-------------------------------------------------------------------- -->
                                        <!--************************************************************************************************ -->

                                        <!--************************************************************************************************ -->
                                        <!--INICIO ITEM No. 8 de la Factura----------------------------------------------------------------- -->

                                        <tr class="itemParTabla">
                                            <td ><input NAME="codarticulo8" id="codarticulo8" type="text" class="cajaPequena"  size="15" maxlength="15" readonly></td>
                                            <td >
                                                <img src="../img/ver.png" width="16" height="16" onClick="ventanaArticulos(8)" onMouseOver="style.cursor=cursor" title="Buscar articulos">
                                                <input NAME="descripcion8" id="descripcion8" type="text" class="cajaExtraGrande" size="30" maxlength="30" onClick="ventanaArticulos(8)" readonly>
						<input style="display: none" name="grabaiva8" id="grabaiva8" class="cajaExtraMinima" readonly>
                                            </td>
                                            <td align="center"><input NAME="cantidad8" id="cantidad8" type="text" class="cajaMinima" size="10" maxlength="10" value="1" onChange="actualizar_importe(8)"></td>
                                            <td align="center"><input NAME="precio8" id="precio8" type="text" class="cajaPequena2" size="10" maxlength="10" onChange="actualizar_importe(8)"></td>
                                           
                                            <td align="center">
                                                <input NAME="descuentoporc8" id="descuentoporc8" type="text" class="cajaMinima" size="10" maxlength="10" onChange="actualizar_descuento(8)" value="0">%
                                                <input NAME="descuento8" id="descuento8" type="text" class="cajaPequena2" size="10" maxlength="10" value="0" readonly>&#36;
                                            </td>
                                           
                                            <td align="center"><input NAME="subt8" id="subt8" type="text" class="cajaPequena2" value="0" onchange="actualizar_totales(8)" readonly></td>
                                            <td width="4%" align="center"><img src="../img/eliminar.png" width="16" height="16" onClick="limpiar_articulo(8)" onMouseOver="style.cursor=cursor" title="Eliminar"> </td>                                        
					</tr>


                                        <input NAME="importe8" id="importe8" type="hidden" value="0">
                                        <input NAME="ivaporc8" id="ivaporc8" type="hidden" onChange="suma_iva(8)">
                                        <input NAME="iva8" id="iva8" type="hidden" value="0">

                                        <input name="idarticulo8" id="idarticulo8" value="<?php   echo $idarticulo?>" type="hidden" >
                                        <input name="costo8" id="costo8" value="<?php   echo $costo?>" type="hidden" >
                                        <input name="stock8" id="stock8" type="hidden">

                                        <input name="transformacion8" id="transformacion8" type="hidden">
                                        <input name="precio_con_iva8" id="precio_con_iva8" type="hidden">
                                        <input name="importe_con_iva8" id="importe_con_iva8" type="hidden">
                                        <!--FIN ITEM No. 8 de la Factura-------------------------------------------------------------------- -->
                                        <!--************************************************************************************************ -->


                                        <!--************************************************************************************************ -->
                                        <!--INICIO ITEM No. 9 de la Factura----------------------------------------------------------------- -->

                                        <tr class="itemImparTabla">
                                            <td ><input NAME="codarticulo9" id="codarticulo9" type="text" class="cajaPequena"  size="15" maxlength="15" readonly></td>
                                            <td >
                                                <img src="../img/ver.png" width="16" height="16" onClick="ventanaArticulos(9)" onMouseOver="style.cursor=cursor" title="Buscar articulos">
                                                <input NAME="descripcion9" id="descripcion9" type="text" class="cajaExtraGrande" size="30" maxlength="30" onClick="ventanaArticulos(9)" readonly>
						<input style="display: none" name="grabaiva9" id="grabaiva9" class="cajaExtraMinima" readonly>
                                            </td>
                                            <td align="center"><input NAME="cantidad9" id="cantidad9" type="text" class="cajaMinima" size="10" maxlength="10" value="1" onChange="actualizar_importe(9)"></td>
                                            <td align="center"><input NAME="precio9" id="precio9" type="text" class="cajaPequena2" size="10" maxlength="10" onChange="actualizar_importe(9)" ></td>
                                           
                                            <td align="center">
                                                <input NAME="descuentoporc9" id="descuentoporc9" type="text" class="cajaMinima" size="10" maxlength="10" onChange="actualizar_descuento(9)" value="0">%
                                                <input NAME="descuento9" id="descuento9" type="text" class="cajaPequena2" size="10" maxlength="10" value="0" readonly>&#36;
                                            </td>
                                           
                                            <td align="center"><input NAME="subt9" id="subt9" type="text" class="cajaPequena2" value="0" onchange="actualizar_totales(9)" readonly></td>
                                            <td align="center"><img src="../img/eliminar.png" width="16" height="16" onClick="limpiar_articulo(9)" onMouseOver="style.cursor=cursor" title="Eliminar"> </td>                                        
					</tr>

                                        <input NAME="importe9" id="importe9" type="hidden" value="0">
                                        <input NAME="ivaporc9" id="ivaporc9" type="hidden" onChange="suma_iva(9)">
                                        <input NAME="iva9" id="iva9" type="hidden" value="0">

                                        <input name="idarticulo9" id="idarticulo9" value="<?php   echo $idarticulo?>" type="hidden" >
                                        <input name="costo9" id="costo9" value="<?php   echo $costo?>" type="hidden" >
                                        <input name="stock9" id="stock9" type="hidden">

                                        <input name="transformacion9" id="transformacion9" type="hidden">
                                        <input name="precio_con_iva9" id="precio_con_iva9" type="hidden">
                                        <input name="importe_con_iva9" id="importe_con_iva9" type="hidden">
                                        <!--FIN ITEM No. 9 de la Factura-------------------------------------------------------------------- -->
                                        <!--************************************************************************************************ -->

                                        <!--************************************************************************************************ -->
                                        <!--INICIO ITEM No. 10 de la Factura----------------------------------------------------------------- -->

                                        <tr class="itemParTabla">
                                            <td ><input NAME="codarticulo10" id="codarticulo10" type="text" class="cajaPequena"  size="15" maxlength="15" readonly></td>
                                            <td >
                                                <img src="../img/ver.png" width="16" height="16" onClick="ventanaArticulos(10)" onMouseOver="style.cursor=cursor" title="Buscar articulos">
                                                <input NAME="descripcion10" id="descripcion10" type="text" class="cajaExtraGrande" size="30" maxlength="30" onClick="ventanaArticulos(10)" readonly>
						<input style="display: none" name="grabaiva10" id="grabaiva10" class="cajaExtraMinima" readonly>
                                            </td>
                                            <td align="center"><input NAME="cantidad10" id="cantidad10" type="text" class="cajaMinima" size="10" maxlength="10" value="1" onChange="actualizar_importe(10)"></td>
                                            <td align="center"><input NAME="precio10" id="precio10" type="text" class="cajaPequena2" size="10" maxlength="10" onChange="actualizar_importe(10)"></td>
                                            
                                            <td align="center">
                                                <input NAME="descuentoporc10" id="descuentoporc10" type="text" class="cajaMinima" size="10" maxlength="10" onChange="actualizar_descuento(10)" value="0">%
                                                <input NAME="descuento10" id="descuento10" type="text" class="cajaPequena2" size="10" maxlength="10" value="0" readonly>&#36;
                                            </td>
                                           
                                            <td align="center"><input NAME="subt10" id="subt10" type="text" class="cajaPequena2" value="0" onchange="actualizar_totales(10)" readonly></td>
                                            <td align="center"><img src="../img/eliminar.png" width="16" height="16" onClick="limpiar_articulo(10)" onMouseOver="style.cursor=cursor" title="Eliminar"> </td>                                        
					</tr>

                                        <input NAME="importe10" id="importe10" type="hidden" value="0">
                                        <input NAME="ivaporc10" id="ivaporc10" type="hidden" onChange="suma_iva(10)">
                                        <input NAME="iva10" id="iva10" type="hidden" value="0">

                                        <input name="idarticulo10" id="idarticulo10" value="<?php   echo $idarticulo?>" type="hidden" >
                                        <input name="costo10" id="costo10" value="<?php   echo $costo?>" type="hidden" >
                                        <input name="stock10" id="stock10" type="hidden">

                                        <input name="transformacion10" id="transformacion10" type="hidden">
                                        <input name="precio_con_iva10" id="precio_con_iva10" type="hidden">
                                        <input name="importe_con_iva10" id="importe_con_iva10" type="hidden">
                                        <!--FIN ITEM No. 10 de la Factura-------------------------------------------------------------------- -->
                                        <!--************************************************************************************************ -->

                                        <!--************************************************************************************************ -->
                                        <!--INICIO ITEM No. 11 de la Factura----------------------------------------------------------------- -->

                                        <tr class="itemImparTabla">
                                            <td ><input NAME="codarticulo11" id="codarticulo11" type="text" class="cajaPequena"  size="15" maxlength="15" readonly></td>
                                            <td >
                                                <img src="../img/ver.png" width="16" height="16" onClick="ventanaArticulos(11)" onMouseOver="style.cursor=cursor" title="Buscar articulos">
                                                <input NAME="descripcion11" id="descripcion11" type="text" class="cajaExtraGrande" size="30" maxlength="30" onClick="ventanaArticulos(11)" readonly>
						<input style="display: none" name="grabaiva11" id="grabaiva11" class="cajaExtraMinima" readonly>
                                            </td>
                                            <td align="center"><input NAME="cantidad11" id="cantidad11" type="text" class="cajaMinima" size="10" maxlength="10" value="1" onChange="actualizar_importe(11)"></td>
                                            <td align="center"><input NAME="precio11" id="precio11" type="text" class="cajaPequena2" size="10" maxlength="10" onChange="actualizar_importe(11)"></td>
                                            <!--<td ><input NAME="1importe11" id="1importe11" type="text" class="cajaPequena2" size="10" maxlength="10" value="0" readonly>&#36;</td>-->
                                            <td align="center">
                                                <input NAME="descuentoporc11" id="descuentoporc11" type="text" class="cajaMinima" size="10" maxlength="10" onChange="actualizar_descuento(11)" value="0">%
                                                <input NAME="descuento11" id="descuento11" type="text" class="cajaPequena2" size="10" maxlength="10" value="0" readonly>&#36;
                                            </td>
                                            <!--<td >
                                                <input NAME="1ivaporc11" id="1ivaporc11" type="text" class="cajaMinima" size="10" maxlength="10" onChange="suma_iva(11)" readonly>%
                                                <input NAME="1iva11" id="1iva11" type="text" class="cajaPequena2" size="10" maxlength="10" value="0" readonly>&#36;
                                            </td>-->
                                            <td align="center"><input NAME="subt11" id="subt11" type="text" class="cajaPequena2" value="0" onchange="actualizar_totales(11)" readonly></td>
                                            <td align="center"><img src="../img/eliminar.png" width="16" height="16" onClick="limpiar_articulo(11)" onMouseOver="style.cursor=cursor" title="Eliminar"> </td>                                        
					</tr>

                                        <input NAME="importe11" id="importe11" type="hidden" value="0">
                                        <input NAME="ivaporc11" id="ivaporc11" type="hidden" onChange="suma_iva(11)">
                                        <input NAME="iva11" id="iva11" type="hidden" value="0">

                                        <input name="idarticulo11" id="idarticulo11" value="<?php   echo $idarticulo?>" type="hidden" >
                                        <input name="costo11" id="costo11" value="<?php   echo $costo?>" type="hidden" >
                                        <input name="stock11" id="stock11" type="hidden">

                                        <input name="transformacion11" id="transformacion11" type="hidden">
                                        <input name="precio_con_iva11" id="precio_con_iva11" type="hidden">
                                        <input name="importe_con_iva11" id="importe_con_iva11" type="hidden">
                                        <!--FIN ITEM No. 11 de la Factura-------------------------------------------------------------------- -->
                                        <!--************************************************************************************************ -->
                                    </table>
                               <br/>

                          </div>
                                
			  <div id="frmBusqueda">
                                <table width="27%" border=0 align="right" cellpadding=3 cellspacing=0 class="fuente8">
                                                  <tr>
                                                      <td width="" class="busqueda">Subtotal</td>
                                                        <td width="" align="right"><div align="center">
                                                      <input class="cajaTotales" name="baseimponible" type="text" id="baseimponible" size="12" value=0 align="right" readonly>
                                                &#36;</div></td>
                                                  </tr>
                                                    
                                                   <tr>
                                                    <td width="" class="busqueda">Descuento                                                   
                                                        <!--<input class="cajaTotales" name="descuentomanual" type="text" id="descuentomanual" size="12" value=0 align="right" onchange="prorratear()"> =-->
                                                    </td>
                                                
                                                <td width="" align="right"><div align="center">
                                                                <input class="cajaTotales" name="descuentototal" type="text" id="descuentototal" size="12" value=0 align="right" readonly>
                                                &#36;</div></td>

                                                  </tr>

                                                  <tr>
                                                    <td width="" class="busqueda">IVA 0%</td>
                                                        <td width="" align="right"><div align="center">
                                                      <input class="cajaTotales" name="iva0" type="text" id="iva0" size="12" value=0 align="right" readonly>
                                                &#36;</div></td>
                                                  </tr>


                                                  <tr>
                                                        <td class="busqueda">IVA 12%</td>
                                                        <td align="right"><div align="center">
                                                      <input class="cajaTotales" name="iva12" type="text" id="iva12" size="12" align="right" value=0 readonly>
                                                &#36;</div></td>
                                                  </tr>

                                                  <tr>
                                                    <td width="" class="busqueda">Total IVA</td>
                                                        <td width="" align="right"><div align="center">
                                                      <input class="cajaTotales" name="importeiva" type="text" id="importeiva" size="12" value=0 align="right" readonly>
                                                &#36;</div></td>
                                                  </tr>
                                                  <tr>
                                                    <td width="" class="busqueda" >Flete</td>
                                                        <td width="" align="right"><div align="center">
                                                                <input class="cajaTotales" name="flete" type="text" id="flete" size="12" value=0 align="right" onchange="sumar_flete()">
                                                &#36;</div></td>
                                                  </tr>

                                                 

                                                  <tr>
                                                        <td class="busqueda">Precio Total</td>
                                                        <td align="right"><div align="center">
                                                      <input class="cajaTotales" name="preciototal" type="text" id="preciototal" size="12" align="right" value=0 readonly>
                                                &#36;</div></td>
                                                  </tr>

                                        </table>
                          </div>
                                <table width="50%" border=0 align="right" cellpadding=3 cellspacing=0 class="fuente8">
                                    <tr>
                                        <td>
                                            <div id="botonBusqueda">
                                              <div align="center">
                                                <img src="../img/botonaceptar.jpg" width="85" height="22" onClick="validar_cabecera()" border="1" onMouseOver="style.cursor=cursor">
                                                    <img src="../img/botoncancelar.jpg" width="85" height="22" onClick="cancelar()" border="1" onMouseOver="style.cursor=cursor">
                                                 
                                                
                                            </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
			  		<!--<iframe id="frame_datos" name="frame_datos" width="0" height="0" frameborder="0">
					<ilayer width="0" height="0" id="frame_datos" name="frame_datos"></ilayer>
					</iframe>-->
                                <input id="accion" name="accion" value="alta" type="hidden">
			  </form>
			 </div>
		  </div>
		</div>
	</body>
</html>
