<?php  
include ("../js/fechas.php");
include ("../conexion/conexion.php");

$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

error_reporting(0);

$idfactura=$_REQUEST["idfactura"];

$query="SELECT *, DATE_ADD(fecha,INTERVAL (plazo*30) DAY) as fecha_venc FROM proformas WHERE id_factura='$idfactura'";
$rs_query=mysql_query($query,$conn);

$idfactura=mysql_result($rs_query,0,"id_factura");

$codfactura=mysql_result($rs_query,0,"codigo_factura");
$serie1=mysql_result($rs_query,0,"serie1");
$serie2=mysql_result($rs_query,0,"serie2");
$autorizacion=mysql_result($rs_query,0,"autorizacion");
$idcliente=mysql_result($rs_query,0,"id_cliente");
$fecha=mysql_result($rs_query,0,"fecha");
$fecha_venc=mysql_result($rs_query,0,"fecha_venc");
$credito=mysql_result($rs_query,0,"credito");
$plazo=mysql_result($rs_query,0,"plazo");
$remision=mysql_result($rs_query,0,"remision");

$descuento=mysql_result($rs_query,0,"descuento");
$iva0=mysql_result($rs_query,0,"iva0");
$iva12=mysql_result($rs_query,0,"iva12");
$importeiva=mysql_result($rs_query,0,"iva");
$flete=mysql_result($rs_query,0,"flete");
$totalfactura=mysql_result($rs_query,0,"totalfactura");
$baseimponible=$totalfactura-$flete-$importeiva+$descuento;


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
        <body>
		<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header">MODIFICAR FACTURA VENTA</div>
				<div id="frmBusqueda">
				<form id="formulario" name="formulario" method="post" action="guardar_factura.php">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
<!--                                                <tr>
                                                    <td width="6%">No. Factura</td>
                                                    <td width="35%">                                                       
                                                        <input NAME="codfactura" type="text" class="cajaPequena" id="codfactura" value="<?php  echo $maximo?>" readonly>
                                                    </td>                                                    
                                                </tr>-->
                                                <?php  
						 $sel_cliente="SELECT * FROM cliente WHERE id_cliente='$idcliente'";
						  $rs_cliente=mysql_query($sel_cliente,$conn); 
                                                ?>
                                                <tr>
                                                        <td width="6%">Nombre</td>
                                                        <td width="35%"><input NAME="nombre" type="text" class="cajaGrande" id="nombre" size="45" maxlength="45" onClick="abreVentana()" readonly value="<?php  echo utf8_decode(mysql_result($rs_cliente,0,"nombre"));?>">
                                                             <img src="../img/ver.png" width="16" height="16" onClick="abreVentana()" title="Buscar cliente" onMouseOver="style.cursor=cursor">
                                                        </td>
							<td width="10%">C&oacute;digo Cliente</td>
                                                        <td width="25%"><input NAME="codcliente" type="text" class="cajaPequena" id="codcliente" size="6" maxlength="5" value="<?php  echo $idcliente?>" readonly>
                                                       </td>

                                                       <td width="35%" rowspan="3" align="center">FACTURA<br/><br/>
                                                       <input  NAME="codfactura" type="text" class="cajaMinimaFactura" id="codfactura" value="<?php  echo $codfactura; ?>" >
                                                       </td>
<!--                                                        <td width="8%">Tipo Cliente</td>
                                                        <td><input name="tipocliente" id="tipocliente" class="cajaMedia" type="text" readonly></td>-->
						</tr>
						<tr>
                                                    
                                                    <td >CI/RUC</td>
                                                    <td  colspan="4"><input NAME="ci_ruc" type="text" class="cajaMedia" id="ci_ruc" size="20" maxlength="15" value="<?php  echo mysql_result($rs_cliente,0,"ci_ruc");?>" readonly></td>
                                                    
						</tr>
                                                <tr>
                                                    <?php  
                                                        $codtipo=mysql_result($rs_cliente,0,"codigo_tipocliente");
                                                        $sel_tipocliente="SELECT nombre FROM tipo_cliente WHERE codigo_tipocliente='$codtipo'";
                                                        $rs_tipocliente=mysql_query($sel_tipocliente,$conn); 
                                                                                                          
                                                    ?>
                                                    <td >Tipo Cliente</td>
                                                    <td  colspan="4">
                                                        <input NAME="tipo_cliente" type="text" class="cajaPequena" id="tipo_cliente" size="20" maxlength="15" value="<?php  echo mysql_result($rs_tipocliente,0,"nombre");?>" readonly>
                                                         Guia Remision: 
                                                         <?php  if($remision == 0){?>
                                                         <select name="cboremision" id="cboremision" class="comboPequeno">
                                                                <option selected value="0">No</option>
                                                                <option value="1">Si</option>
                                                         </select>
                                                         <?php  } else {?>
                                                         <select name="cboremision" id="cboremision" class="comboPequeno">
                                                                <option value="0">No</option>
                                                                <option selected value="1">Si</option>
                                                         </select>
                                                         <?php  }?>
                                                    </td>
                                                </tr>

						<?php  $hoy=date("d/m/Y"); ?>
						<tr>
                                                    <td >Fecha</td>
						    <td ><input NAME="fecha" type="text" class="cajaPequena" id="fecha" size="10" maxlength="10" value="<?php  echo implota($fecha) ?>" readonly> <img src="../img/calendario.png" name="Image1" id="Image1" width="16" height="16" border="0" id="Image1" onMouseOver="this.style.cursor='pointer'">
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
                                                            <?php  if($credito == 0){?>
                                                            <!--<select name="cbocredito" id="cbocredito" class="comboPequeno" onchange="activar_plazo(this.selectedIndex)">
                                                                <option selected value="0">No</option>
                                                                <option value="1">Si</option>
                                                                
                                                            </select>-->
                                                            <b>No</b> ---
                                                            <?php  } else {?>
                                                            <!--<select name="cbocredito" id="cbocredito" class="comboPequeno" onchange="activar_plazo(this.selectedIndex)">
                                                                <option value="0">No</option>
                                                                <option selected value="1">Si</option>
                                                                
                                                            </select>-->
                                                            <b>Si</b> ---
                                                            <?php  }?>
                                                            Fech. Venc.: <?php  echo implota($fecha_venc)?>
                                                            <!--
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
                                                            -->   
                                                        </td>
                                                        
                                                        
                                                </tr>
					</table>										
			  </div>

                                <input NAME="serie1" type="hidden"  id="serie1" value="<?php  echo $serie1?>" >
                                <input NAME="serie2" type="hidden"  id="serie2" value="<?php  echo $serie2?>">
                                <input NAME="autorizacion" type="hidden"  id="autorizacion" value="<?php  echo $autorizacion?>" >
                                <input NAME="idfactura" type="hidden"  id="idfactura" value="<?php  echo $idfactura;?>" >
                          <!--
                         
			  <input id="accion" name="accion" value="alta" type="hidden">-->
			 <!-- </form>-->

                          <?php  $sel_lineas="SELECT a.id_factulinea as id_factulinea, a.id_producto as id_producto, b.stock as stock, b.costo as costo, b.codigo as codigo, b.nombre as nombre, b.transformacion as transformacion, a.cantidad as cantidad, a.precio as precio, a.subtotal as subtotal, a.dcto as dcto, a.iva as iva FROM proforlinea a INNER JOIN producto b ON a.id_producto=b.id_producto WHERE a.id_factura = '$idfactura'";
                                $rs_lineas=mysql_query($sel_lineas,$conn);                                                                 
                         ?>
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
                                        <?php  
                                            $idproducto1=mysql_result($rs_lineas,0,"id_producto");
                                            $idfactulinea1=mysql_result($rs_lineas,0,"id_factulinea");
                                            $codarticulo1=mysql_result($rs_lineas,0,"codigo");
                                            $descripcion1=utf8_decode(mysql_result($rs_lineas,0,"nombre"));
                                            $cantidad1=mysql_result($rs_lineas,0,"cantidad");
                                            $precio1=mysql_result($rs_lineas,0,"precio");
                                            $subtotal1=mysql_result($rs_lineas,0,"subtotal");
                                            $descuento_ind1=mysql_result($rs_lineas,0,"dcto");
                                            $iva1=mysql_result($rs_lineas,0,"iva");
                                            $transformacion1=mysql_result($rs_lineas,0,"transformacion");
                                            $costo1=mysql_result($rs_lineas,0,"costo");
                                            $stock1=mysql_result($rs_lineas,0,"stock");
                                            
                                            $descuento_porcentaje1=number_format(round((($descuento_ind1*100)/$subtotal1)*10)/10,2);
                                            
                                            if(($transformacion1 ==2)&&($iva1!=0))
                                                {
                                                    $query_tmp="SELECT SUM(p.pvp)as importeiva
                                                                FROM producto_transformacion pt INNER JOIN producto p ON pt.id_producto = p.id_producto
                                                                WHERE pt.id_transformacion = $idproducto1 AND p.iva=1" ;
                                                    $rs_tmp=mysql_query($query_tmp, $conn);

                                                    $precio_con_iva1=(mysql_result($rs_tmp,0,"importeiva"));
                                                }
                                                else
                                                {
                                                    $precio_con_iva1=0;
                                                }
                                            
                                        ?>
                                        
                                        <tr class="itemImparTabla">
                                            <td ><input NAME="codarticulo1" id="codarticulo1" type="text" class="cajaPequena"  size="15" maxlength="15" value="<?php  echo $codarticulo1;?>" readonly></td>
                                            <td >
                                                <img src="../img/ver.png" width="16" height="16" onClick="ventanaArticulos(1)" onMouseOver="style.cursor=cursor" title="Buscar articulos">
                                                <input NAME="descripcion1" id="descripcion1" type="text" class="cajaExtraGrande"  onClick="ventanaArticulos(1)" value="<?php  echo $descripcion1;?>" readonly>
                                                <?php  if($iva1!=0){  ?>
						<input style="display: inherit" name="grabaiva1" id="grabaiva1" class="cajaExtraMinima" readonly>
                                                <?php  }else{?>
                                                <input style="display: none" name="grabaiva1" id="grabaiva1" class="cajaExtraMinima" readonly>
                                                <?php  }?>
                                            </td>
                                            <?php  if($idfactulinea1){?>
                                            <td align="center"><input NAME="cantidad1" id="cantidad1" type="text" class="cajaMinima" size="10" maxlength="10" value="<?php  echo $cantidad1;?>" onChange="actualizar_importe(1)"></td>
                                            <?php  }else{?>
                                            <td align="center"><input NAME="cantidad1" id="cantidad1" type="text" class="cajaMinima" size="10" maxlength="10" value="1" onChange="actualizar_importe(1)"></td>
                                            <?php  }?>
                                            <td align="center"><input NAME="precio1" id="precio1" type="text" class="cajaPequena2" size="10" maxlength="10" value="<?php  echo $precio1;?>"  onChange="actualizar_importe(1)"></td>
                                            
                                            <td align="center">
                                                <?php  if($idfactulinea1){?>
                                                <input NAME="descuentoporc1" id="descuentoporc1" type="text" class="cajaMinima" size="10" maxlength="10" onChange="actualizar_descuento(1)" value="<?php  echo $descuento_porcentaje1;?>">%
                                                <input NAME="descuento1" id="descuento1" type="text" class="cajaPequena2" size="10" maxlength="10" value="<?php  echo $descuento_ind1?>" readonly>&#36;
                                                <?php  }else{?>
                                                <input NAME="descuentoporc1" id="descuentoporc1" type="text" class="cajaMinima" size="10" maxlength="10" onChange="actualizar_descuento(1)" value="0">%
                                                <input NAME="descuento1" id="descuento1" type="text" class="cajaPequena2" size="10" maxlength="10" value="0" readonly>&#36;
                                                <?php  }?>
                                            </td>
                                            <?php  if($idfactulinea1){?>
                                            <td align="center"><input NAME="subt1" id="subt1" type="text" class="cajaPequena2" value="<?php  echo $subtotal1 - $descuento_ind1 + $iva1?>"  readonly></td>
                                            <?php  }else{?>
                                            <td align="center"><input NAME="subt1" id="subt1" type="text" class="cajaPequena2" value="0"  readonly></td>
                                            <?php  }?>
                                            <td align="center"><img src="../img/eliminar.png" width="16" height="16" onClick="limpiar_articulo(1)" onMouseOver="style.cursor=cursor" title="Eliminar"> </td>                                           
                                        </tr>
                                        
                                        
                                        
                                        <?php  if($idfactulinea1){?>
                                        <input name="idfactulinea1" id="idfactulinea1" type="hidden" value="<?php  echo $idfactulinea1;?>">
                                        <input name="idarticulo1" id="idarticulo1"  type="hidden" value="<?php  echo $idproducto1;?>" >
                                        <input NAME="iva1" id="iva1" type="hidden" value="<?php  echo $iva1;?>">
                                        <input name="transformacion1" id="transformacion1" value="<?php  echo $transformacion1;?>" type="hidden">
                                        <input name="precio_con_iva1" id="precio_con_iva1" value="<?php  echo $precio_con_iva1;?>" type="hidden">
                                        <input NAME="importe1" id="importe1" type="hidden" value="<?php  echo $subtotal1;?>">
                                        <input name="costo1" id="costo1" value<?php  echo $costo1;?> type="hidden" >
                                        <input name="stock1" id="stock1" value="<?php  echo $stock1;?>" type="hidden">                                                                               
                                        <input name="importe_con_iva1" id="importe_con_iva1" value="<?php  echo $iva1;?>" type="hidden">
                                        <?php  }else{?>
                                        <input name="idarticulo1" id="idarticulo1"  type="hidden" >
                                        <input NAME="iva1" id="iva1" type="hidden" value="0">    
                                        <input name="transformacion1" id="transformacion1" type="hidden">
                                        <input name="precio_con_iva1" id="precio_con_iva1" type="hidden">
                                        <input NAME="importe1" id="importe1" type="hidden" value="0">
                                        <input name="costo1" id="costo1"  type="hidden" >
                                        <input name="stock1" id="stock1" type="hidden">                                                                               
                                        <input name="importe_con_iva1" id="importe_con_iva1" type="hidden">
                                        <?php  }?>
                                        
                                        
                                        <?php  if($iva1!==0){  ?>                                                                  
                                        <input NAME="ivaporc1" id="ivaporc1" type="hidden" value="12"  onChange="suma_iva(1)">
                                        <?php  }else{?>
                                        <input NAME="ivaporc1" id="ivaporc1" value="0" type="hidden" onChange="suma_iva(1)">
                                        <?php  }?>
                                        
                                        
                                                                              
                                        
                                        <!--FIN ITEM No. 1 de la Factura-------------------------------------------------------------------- -->
                                        <!--************************************************************************************************ -->

                                        
                                        <!--************************************************************************************************ -->
                                        <!--INICIO ITEM No. 2 de la Factura----------------------------------------------------------------- -->
                                        <?php  
                                            $idfactulinea2=mysql_result($rs_lineas,1,"id_factulinea");
                                            if($idfactulinea2)
                                            {
                                                $idproducto2=mysql_result($rs_lineas,1,"id_producto");                                               
                                                $codarticulo2=mysql_result($rs_lineas,1,"codigo");
                                                $descripcion2=utf8_decode(mysql_result($rs_lineas,1,"nombre"));
                                                $cantidad2=mysql_result($rs_lineas,1,"cantidad");
                                                $precio2=mysql_result($rs_lineas,1,"precio");
                                                $subtotal2=mysql_result($rs_lineas,1,"subtotal");
                                                $descuento_ind2=mysql_result($rs_lineas,1,"dcto");
                                                $iva2=mysql_result($rs_lineas,1,"iva");
                                                $transformacion2=mysql_result($rs_lineas,1,"transformacion");
                                                $costo2=mysql_result($rs_lineas,1,"costo");
                                                $stock2=mysql_result($rs_lineas,1,"stock");
                                                
                                                $descuento_porcentaje2=number_format(round((($descuento_ind2*100)/$subtotal2)*10)/10,2);
                                                
                                                if(($transformacion2 ==2)&&($iva2!=0))
                                                {
                                                    $query_tmp="SELECT SUM(p.pvp)as importeiva
                                                                FROM producto_transformacion pt INNER JOIN producto p ON pt.id_producto = p.id_producto
                                                                WHERE pt.id_transformacion = $idproducto2 AND p.iva=1" ;
                                                    $rs_tmp=mysql_query($query_tmp, $conn);

                                                    $precio_con_iva2=(mysql_result($rs_tmp,0,"importeiva"));
                                                }
                                                else
                                                {
                                                    $precio_con_iva2=0;
                                                }
                                                
                                           ?>                                      
                                        
                                        <tr class="itemParTabla">
                                            <td ><input NAME="codarticulo2" id="codarticulo2" type="text" class="cajaPequena"  size="15" maxlength="15" value="<?php  echo $codarticulo2;?>" readonly></td>
                                            <td >
                                                <img src="../img/ver.png" width="16" height="16" onClick="ventanaArticulos(2)" onMouseOver="style.cursor=cursor" title="Buscar articulos">
                                                <input NAME="descripcion2" id="descripcion2" type="text" class="cajaExtraGrande" size="30" maxlength="30" value="<?php  echo $descripcion2?>"  onClick="ventanaArticulos(2)" readonly>
                                                <?php  if($iva2!=0){  ?>
                                                <input style="display: inherit" name="grabaiva2" id="grabaiva2" class="cajaExtraMinima" readonly>
                                                <?php  }else{?>
                                            	<input style="display: none" name="grabaiva2" id="grabaiva2" class="cajaExtraMinima" readonly>
                                                <?php  }?>
					    </td>
                                            <td align="center"><input NAME="cantidad2" id="cantidad2" type="text" class="cajaMinima" size="10" maxlength="10" value="<?php  echo $cantidad2?>" onChange="actualizar_importe(2)"></td>
                                            <td align="center"><input NAME="precio2" id="precio2" type="text" class="cajaPequena2" size="10" maxlength="10" value="<?php  echo $precio2?>" onChange="actualizar_importe(2)"></td>
                                            
                                            <td align="center">
                                                <input NAME="descuentoporc2" id="descuentoporc2" type="text" class="cajaMinima" size="10" maxlength="10" onChange="actualizar_descuento(2)" value="<?php  echo $descuento_porcentaje2;?>">%
                                                <input NAME="descuento2" id="descuento2" type="text" class="cajaPequena2" size="10" maxlength="10" value="<?php  echo $descuento_ind2?>" readonly>&#36;
                                            </td>
                                            
                                            <td align="center"><input NAME="subt2" id="subt2" type="text" class="cajaPequena2" onchange="actualizar_totales(2)" value="<?php  echo $subtotal2 - $descuento_ind2 + $iva2?>" readonly></td>
                                            <td align="center"><img src="../img/eliminar.png" width="16" height="16" onClick="limpiar_articulo(2)" onMouseOver="style.cursor=cursor" title="Eliminar"> </td>
                                        </tr>
                                        
                                        <input name="idfactulinea2" id="idfactulinea2" type="hidden" value="<?php  echo $idfactulinea2;?>">
                                        <input name="idarticulo2" id="idarticulo2"  type="hidden" value="<?php  echo $idproducto2;?>" >
                                        <input NAME="iva2" id="iva2" type="hidden" value="<?php  echo $iva2;?>">
                                        <input name="transformacion2" id="transformacion2" type="hidden" value="<?php  echo $transformacion2;?>">
                                        <input name="precio_con_iva2" id="precio_con_iva2" type="hidden" value="<?php  echo $precio_con_iva2;?>">
                                        <input NAME="importe2" id="importe2" type="hidden" value="<?php  echo $subtotal2;?>">                                        
                                        <input name="costo2" id="costo2"  type="hidden" value="<?php  echo $costo2;?>">
                                        <input name="stock2" id="stock2" type="hidden" value="<?php  echo $stock2;?>">                                        
                                        <input name="importe_con_iva2" id="importe_con_iva2" value="<?php  echo $iva2;?>" type="hidden">
                                        
                                            <?php  if($iva2!=0){  ?>   
                                            <input NAME="ivaporc2" id="ivaporc2" type="hidden" value="12" onChange="suma_iva(2)">
                                            <?php  }else{?>
                                            <input NAME="ivaporc2" id="ivaporc2" type="hidden" value="0" onChange="suma_iva(2)">
                                            <?php  }?>
                                       
                                        <?php 
                                            } 
                                            else
                                            {
                                        ?> 
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
                                        
                                        <input name="idarticulo2" id="idarticulo2"  type="hidden" >
                                        <input name="transformacion2" id="transformacion2" type="hidden">
                                        <input name="precio_con_iva2" id="precio_con_iva2" type="hidden">
                                        <input NAME="importe2" id="importe2" type="hidden" value="0">
                                        <input NAME="ivaporc2" id="ivaporc2" type="hidden" onChange="suma_iva(2)">
                                        <input NAME="iva2" id="iva2" type="hidden" value="0">   
                                        <input name="costo2" id="costo2"  type="hidden" >
                                        <input name="stock2" id="stock2" type="hidden">                                        
                                        <input name="importe_con_iva2" id="importe_con_iva2" type="hidden">
                                        <?php    }?>

                                       
                                        
                                        <!--FIN ITEM No. 2 de la Factura-------------------------------------------------------------------- -->
                                        <!--************************************************************************************************ -->

                                        <!--************************************************************************************************ -->
                                        <!--INICIO ITEM No. 3 de la Factura----------------------------------------------------------------- -->
                                        <?php  
                                            $idfactulinea3=mysql_result($rs_lineas,2,"id_factulinea");
                                            if($idfactulinea3)
                                            {
                                                $idproducto3=mysql_result($rs_lineas,2,"id_producto");                                               
                                                $codarticulo3=mysql_result($rs_lineas,2,"codigo");
                                                $descripcion3=utf8_decode(mysql_result($rs_lineas,2,"nombre"));
                                                $cantidad3=mysql_result($rs_lineas,2,"cantidad");
                                                $precio3=mysql_result($rs_lineas,2,"precio");
                                                $subtotal3=mysql_result($rs_lineas,2,"subtotal");
                                                $descuento_ind3=mysql_result($rs_lineas,2,"dcto");
                                                $iva3=mysql_result($rs_lineas,2,"iva");
                                                $transformacion3=mysql_result($rs_lineas,2,"transformacion");
                                                $costo3=mysql_result($rs_lineas,2,"costo");
                                                $stock3=mysql_result($rs_lineas,2,"stock");                                                
                                                
                                                $descuento_porcentaje3=number_format(round((($descuento_ind3*100)/$subtotal3)*10)/10,2);
                                                
                                                if(($transformacion3 ==2)&&($iva3!=0))
                                                {
                                                    $query_tmp="SELECT SUM(p.pvp)as importeiva
                                                                FROM producto_transformacion pt INNER JOIN producto p ON pt.id_producto = p.id_producto
                                                                WHERE pt.id_transformacion = $idproducto3 AND p.iva=1" ;
                                                    $rs_tmp=mysql_query($query_tmp, $conn);

                                                    $precio_con_iva3=(mysql_result($rs_tmp,0,"importeiva"));
                                                }
                                                else
                                                {
                                                    $precio_con_iva3=0;
                                                }
                                           ?>
                                            <tr class="itemImparTabla">
                                            <td ><input NAME="codarticulo3" id="codarticulo3" type="text" class="cajaPequena"  size="15" maxlength="15" value="<?php  echo $codarticulo3?>" readonly></td>
                                            <td >
                                                <img src="../img/ver.png" width="16" height="16" onClick="ventanaArticulos(3)" onMouseOver="style.cursor=cursor" title="Buscar articulos">
                                                <input NAME="descripcion3" id="descripcion3" type="text" class="cajaExtraGrande" size="30" maxlength="30" value="<?php  echo $descripcion3?>" onClick="ventanaArticulos(3)" readonly>
						<?php  if($iva3!=0){  ?>
                                                <input style="display: inherit" name="grabaiva3" id="grabaiva3"  class="cajaExtraMinima" readonly>
                                                <?php  }else{?>
                                                <input style="display: none" name="grabaiva3" id="grabaiva3" class="cajaExtraMinima" readonly>
                                                <?php  }?>
                                            </td>
                                            <td align="center"><input NAME="cantidad3" id="cantidad3" type="text" class="cajaMinima" size="10" maxlength="10" value="<?php  echo $cantidad3?>" onChange="actualizar_importe(3)"></td>
                                            <td align="center"><input NAME="precio3" id="precio3" type="text" class="cajaPequena2" size="10" maxlength="10" value="<?php  echo $precio3?>" onChange="actualizar_importe(3)"></td>
                                            
                                            <td align="center">
                                                <input NAME="descuentoporc3" id="descuentoporc3" type="text" class="cajaMinima" size="10" maxlength="10" onChange="actualizar_descuento(3)" value="<?php  echo $descuento_porcentaje3;?>">%
                                                <input NAME="descuento3" id="descuento3" type="text" class="cajaPequena2" size="10" maxlength="10" value="<?php  echo $descuento_ind3;?>" readonly>&#36;
                                            </td>                                            
                                            <td align="center"><input NAME="subt3" id="subt3" type="text" class="cajaPequena2" value="<?php  echo $subtotal3 - $descuento_ind3 + $iva3?>" onchange="actualizar_totales(3)" readonly></td>
                                            <td align="center"><img src="../img/eliminar.png" width="16" height="16" onClick="limpiar_articulo(3)" onMouseOver="style.cursor=cursor" title="Eliminar"> </td>                                        
					</tr>

                                        <input name="idfactulinea3" id="idfactulinea3" type="hidden" value="<?php  echo $idfactulinea3;?>">
                                        <input NAME="importe3" id="importe3" type="hidden" value="<?php  echo $subtotal3 ?>">                                        
                                        <input NAME="iva3" id="iva3" type="hidden" value="<?php  echo $iva3 ?>">
                                        <input name="idarticulo3" id="idarticulo3" value="<?php  echo $idproducto3?>" type="hidden" >                                        
                                        <input name="transformacion3" id="transformacion3" value="<?php  echo $transformacion3;?>" type="hidden">
                                        <input name="precio_con_iva3" id="precio_con_iva3" value="<?php  echo $precio_con_iva3 ?>" type="hidden">
                                        <input name="costo3" id="costo3" value="<?php  echo $costo3;?>" type="hidden" >
                                        <input name="stock3" id="stock3" value="<?php  echo $stock3;?>" type="hidden">
                                        <input name="importe_con_iva3" id="importe_con_iva3" value="<?php  echo $iva3 ?>" type="hidden">
                                        
                                            <?php  if($iva3!=0){  ?>
                                            <input NAME="ivaporc3" id="ivaporc3" value="12" type="hidden" onChange="suma_iva(3)">
                                            <?php  }else{?>
                                            <input NAME="ivaporc3" id="ivaporc3" value="0" type="hidden" onChange="suma_iva(3)">
                                            <?php  }?>

                                        <?php 
                                            } 
                                            else
                                            {
                                        ?>
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
                                        <input name="idarticulo3" id="idarticulo3" type="hidden" >                                        
                                        <input name="transformacion3" id="transformacion3" type="hidden">
                                        <input name="precio_con_iva3" id="precio_con_iva3" type="hidden">
                                        <input name="costo3" id="costo3" type="hidden" >
                                        <input name="stock3" id="stock3" type="hidden">
                                        <input name="importe_con_iva3" id="importe_con_iva3" type="hidden">
                                        <?php  }?>                                                                                
                                        <!--FIN ITEM No. 3 de la Factura-------------------------------------------------------------------- -->
                                        <!--************************************************************************************************ -->
                                        
                                        
                                        <!--************************************************************************************************ -->
                                        <!--INICIO ITEM No. 4 de la Factura----------------------------------------------------------------- -->
                                        <?php  
                                            $idfactulinea4=mysql_result($rs_lineas,3,"id_factulinea");
                                            if($idfactulinea4)
                                            {
                                                $idproducto4=mysql_result($rs_lineas,3,"id_producto");                                               
                                                $codarticulo4=mysql_result($rs_lineas,3,"codigo");
                                                $descripcion4=utf8_decode(mysql_result($rs_lineas,3,"nombre"));
                                                $cantidad4=mysql_result($rs_lineas,3,"cantidad");
                                                $precio4=mysql_result($rs_lineas,3,"precio");
                                                $subtotal4=mysql_result($rs_lineas,3,"subtotal");
                                                $descuento_ind4=mysql_result($rs_lineas,3,"dcto");
                                                $iva4=mysql_result($rs_lineas,3,"iva");
                                                $transformacion4=mysql_result($rs_lineas,3,"transformacion");
                                                $costo4=mysql_result($rs_lineas,3,"costo");
                                                $stock4=mysql_result($rs_lineas,3,"stock");
                                                
                                                $descuento_porcentaje4=number_format(round((($descuento_ind4*100)/$subtotal4)*10)/10,2);
                                                
                                                if(($transformacion4 ==2)&&($iva4!=0))
                                                {
                                                    $query_tmp="SELECT SUM(p.pvp)as importeiva
                                                                FROM producto_transformacion pt INNER JOIN producto p ON pt.id_producto = p.id_producto
                                                                WHERE pt.id_transformacion = $idproducto4 AND p.iva=1" ;
                                                    $rs_tmp=mysql_query($query_tmp, $conn);

                                                    $precio_con_iva4=(mysql_result($rs_tmp,0,"importeiva"));
                                                }
                                                else
                                                {
                                                    $precio_con_iva4=0;
                                                }
                                                
                                                
                                           ?>
                                            <tr class="itemParTabla">
                                                <td ><input NAME="codarticulo4" id="codarticulo4" type="text" class="cajaPequena"  size="15" maxlength="15" value="<?php  echo $codarticulo4;?>" readonly></td>
                                                <td >
                                                    <img src="../img/ver.png" width="16" height="16" onClick="ventanaArticulos(4)" onMouseOver="style.cursor=cursor" title="Buscar articulos">
                                                    <input NAME="descripcion4" id="descripcion4" type="text" class="cajaExtraGrande" size="30" maxlength="30" value="<?php  echo $descripcion4;?>" onClick="ventanaArticulos(4)" readonly>
                                                    <?php  if($iva4!=0){  ?>
                                                    <input style="display: inherit" name="grabaiva4" id="grabaiva4" class="cajaExtraMinima" readonly>
                                                    <?php  }else{?>
                                                    <input style="display: none" name="grabaiva4" id="grabaiva4" class="cajaExtraMinima" readonly>
                                                    <?php  }?>
                                                    
                                                </td>
                                                <td align="center"><input NAME="cantidad4" id="cantidad4" type="text" class="cajaMinima" size="10" maxlength="10" value="<?php  echo $cantidad4;?>" onChange="actualizar_importe(4)"></td>
                                                <td align="center"><input NAME="precio4" id="precio4" type="text" class="cajaPequena2" size="10" maxlength="10" value="<?php  echo $precio4;?>" onChange="actualizar_importe(4)" ></td>

                                                <td align="center">
                                                    <input NAME="descuentoporc4" id="descuentoporc4" type="text" class="cajaMinima" size="10" maxlength="10" onChange="actualizar_descuento(4)" value="<?php  echo $descuento_porcentaje4;?>">%
                                                    <input NAME="descuento4" id="descuento4" type="text" class="cajaPequena2" size="10" maxlength="10" value="<?php  echo $descuento_ind4;?>" readonly>&#36;
                                                </td>

                                                <td align="center"><input NAME="subt4" id="subt4" type="text" class="cajaPequena2" value="<?php  echo $subtotal4 - $descuento_ind4 + $iva4;?>" onchange="actualizar_totales(4)" readonly></td>
                                                <td align="center"><img src="../img/eliminar.png" width="16" height="16" onClick="limpiar_articulo(4)" onMouseOver="style.cursor=cursor" title="Eliminar"> </td>                                        
                                            </tr>

                                            <input name="idfactulinea4" id="idfactulinea4" type="hidden" value="<?php  echo $idfactulinea4;?>">
                                            <input NAME="importe4" id="importe4" type="hidden" value="<?php  echo $subtotal4;?>">                                            
                                            <input NAME="iva4" id="iva4" type="hidden" value="<?php  echo $iva4;?>">
                                            <input name="idarticulo4" id="idarticulo4" value="<?php  echo $idproducto4; ?>" type="hidden" >
                                            <input name="transformacion4" id="transformacion4" type="hidden" value="<?php  echo $transformacion4;?>">
                                            <input name="precio_con_iva4" id="precio_con_iva4" type="hidden" value="<?php  echo $precio_con_iva4;?>">
                                            <input name="costo4" id="costo4" value="<?php  echo $costo4;?>" type="hidden" >
                                            <input name="stock4" id="stock4" value="<?php  echo $stock4;?>" type="hidden">
                                            <input name="importe_con_iva4" id="importe_con_iva4" value="<?php  echo $iva4;?>" type="hidden">
                                                <?php  if($iva4!=0){  ?>
                                                <input NAME="ivaporc4" id="ivaporc4" value="12" type="hidden" onChange="suma_iva(4)">
                                                <?php  }else{?>
                                                <input NAME="ivaporc4" id="ivaporc4" value="0" type="hidden" onChange="suma_iva(4)">
                                                <?php  }?>						

                                        <?php 
                                            } 
                                            else
                                            {
                                        ?>
                                        
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
                                        <input name="idarticulo4" id="idarticulo4" value="<?php  echo $idarticulo?>" type="hidden" >
                                        <input name="transformacion4" id="transformacion4" type="hidden">
                                        <input name="precio_con_iva4" id="precio_con_iva4" type="hidden">
                                        <input name="costo4" id="costo4" type="hidden" >
                                        <input name="stock4" id="stock4" type="hidden">
                                        <input name="importe_con_iva4" id="importe_con_iva4" type="hidden">
                                        <?php  }?>                                        
                                        <!--FIN ITEM No. 4 de la Factura-------------------------------------------------------------------- -->
                                        <!--************************************************************************************************ -->


                                        <!--************************************************************************************************ -->
                                        <!--INICIO ITEM No. 5 de la Factura----------------------------------------------------------------- -->
                                        <?php  
                                            $idfactulinea5=mysql_result($rs_lineas,4,"id_factulinea");
                                            if($idfactulinea5)
                                            {
                                                $idproducto5=mysql_result($rs_lineas,4,"id_producto");                                               
                                                $codarticulo5=mysql_result($rs_lineas,4,"codigo");
                                                $descripcion5=utf8_decode(mysql_result($rs_lineas,4,"nombre"));
                                                $cantidad5=mysql_result($rs_lineas,4,"cantidad");
                                                $precio5=mysql_result($rs_lineas,4,"precio");
                                                $subtotal5=mysql_result($rs_lineas,4,"subtotal");
                                                $descuento_ind5=mysql_result($rs_lineas,4,"dcto");
                                                $iva5=mysql_result($rs_lineas,4,"iva");
                                                $transformacion5=mysql_result($rs_lineas,4,"transformacion");
                                                $costo5=mysql_result($rs_lineas,4,"costo");
                                                $stock5=mysql_result($rs_lineas,4,"stock");
                                                
                                                $descuento_porcentaje5=number_format(round((($descuento_ind5*100)/$subtotal5)*10)/10,2);
                                                
                                                if(($transformacion5 ==2)&&($iva5!=0))
                                                {
                                                    $query_tmp="SELECT SUM(p.pvp)as importeiva
                                                                FROM producto_transformacion pt INNER JOIN producto p ON pt.id_producto = p.id_producto
                                                                WHERE pt.id_transformacion = $idproducto5 AND p.iva=1" ;
                                                    $rs_tmp=mysql_query($query_tmp, $conn);

                                                    $precio_con_iva5=(mysql_result($rs_tmp,0,"importeiva"));
                                                }
                                                else
                                                {
                                                    $precio_con_iva5=0;
                                                }
                                           ?>
                                            <tr class="itemImparTabla">
                                                <td ><input NAME="codarticulo5" id="codarticulo5" type="text" class="cajaPequena"  size="15" maxlength="15" value="<?php  echo $codarticulo5;?>" readonly></td>
                                                <td >
                                                    <img src="../img/ver.png" width="16" height="16" onClick="ventanaArticulos(5)"  onMouseOver="style.cursor=cursor" title="Buscar articulos">
                                                    <input NAME="descripcion5" id="descripcion5" type="text" class="cajaExtraGrande" size="30" maxlength="30" value="<?php  echo $descripcion5;?>" onClick="ventanaArticulos(5)" readonly>
                                                    <?php  if($iva5!=0){  ?>
                                                    <input style="display: inherit" name="grabaiva5" id="grabaiva5" class="cajaExtraMinima" readonly>
                                                    <?php  }else{?>
                                                    <input style="display: none" name="grabaiva5" id="grabaiva5" class="cajaExtraMinima" readonly>
                                                    <?php  }?>
                                                    
                                                </td>
                                                <td align="center"><input NAME="cantidad5" id="cantidad5" type="text" class="cajaMinima" size="10" maxlength="10" value="<?php  echo $cantidad5;?>" onChange="actualizar_importe(5)"></td>
                                                <td align="center"><input NAME="precio5" id="precio5" type="text" class="cajaPequena2" size="10" maxlength="10" value="<?php  echo $precio5;?>" onChange="actualizar_importe(5)"></td>

                                                <td align="center">
                                                    <input NAME="descuentoporc5" id="descuentoporc5" type="text" class="cajaMinima" size="10" maxlength="10" onChange="actualizar_descuento(5)" value="<?php  echo $descuento_porcentaje5;?>">%
                                                    <input NAME="descuento5" id="descuento5" type="text" class="cajaPequena2" size="10" maxlength="10" value="<?php  echo $descuento_ind5; ?>" readonly>&#36;
                                                </td>

                                                <td align="center"><input NAME="subt5" id="subt5" type="text" class="cajaPequena2" value="<?php  echo $subtotal5 - $descuento_ind5 + $iva5; ?>" onchange="actualizar_totales(5)" readonly></td>
                                                <td align="center"><img src="../img/eliminar.png" width="16" height="16" onClick="limpiar_articulo(5)" onMouseOver="style.cursor=cursor" title="Eliminar"> </td>                                        
                                            </tr>
                                            
                                            <input name="idfactulinea5" id="idfactulinea5" type="hidden" value="<?php  echo $idfactulinea5;?>">
                                            <input NAME="importe5" id="importe5" type="hidden" value="<?php  echo $subtotal5; ?>">                                            
                                            <input NAME="iva5" id="iva5" type="hidden" value="<?php  echo $iva5; ?>">
                                            <input name="idarticulo5" id="idarticulo5" value="<?php  echo $idproducto5; ?>" type="hidden" >                                       
                                            <input name="transformacion5" id="transformacion5" type="hidden" value="<?php  echo $transformacion5; ?>">
                                            <input name="precio_con_iva5" id="precio_con_iva5" type="hidden" value="<?php  echo $precio_con_iva5; ?>">
                                            <input name="costo5" id="costo5" value="<?php  echo $costo5 ?>" type="hidden" >
                                            <input name="stock5" id="stock5" type="hidden" value="<?php  echo $stock5;?>">
                                            <input name="importe_con_iva5" id="importe_con_iva5" type="hidden" value="<?php  echo $iva5;?>">
                                                <?php  if($iva5!=0){  ?>
                                                <input NAME="ivaporc5" id="ivaporc5" value="12" type="hidden" onChange="suma_iva(5)">
                                                <?php  }else{?>
                                                <input NAME="ivaporc5" id="ivaporc5" value="0" type="hidden" onChange="suma_iva(5)">
                                                <?php  }?>

                                        <?php 
                                            } 
                                            else
                                            {
                                        ?> 
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
                                        <input name="idarticulo5" id="idarticulo5"  type="hidden" >                                       
                                        <input name="transformacion5" id="transformacion5" type="hidden">
                                        <input name="precio_con_iva5" id="precio_con_iva5" type="hidden">
                                        <input name="costo5" id="costo5" type="hidden" >
                                        <input name="stock5" id="stock5" type="hidden">
                                        <input name="importe_con_iva5" id="importe_con_iva5" type="hidden">
                                        <?php  }?>
                                        
                                        <!--FIN ITEM No. 5 de la Factura-------------------------------------------------------------------- -->
                                        <!--************************************************************************************************ -->


                                        <!--************************************************************************************************ -->
                                        <!--INICIO ITEM No. 6 de la Factura----------------------------------------------------------------- -->
                                        <?php  
                                            $idfactulinea6=mysql_result($rs_lineas,5,"id_factulinea");
                                            if($idfactulinea6)
                                            {
                                                $idproducto6=mysql_result($rs_lineas,5,"id_producto");                                               
                                                $codarticulo6=mysql_result($rs_lineas,5,"codigo");
                                                $descripcion6=utf8_decode(mysql_result($rs_lineas,5,"nombre"));
                                                $cantidad6=mysql_result($rs_lineas,5,"cantidad");
                                                $precio6=mysql_result($rs_lineas,5,"precio");
                                                $subtotal6=mysql_result($rs_lineas,5,"subtotal");
                                                $descuento_ind6=mysql_result($rs_lineas,5,"dcto");
                                                $iva6=mysql_result($rs_lineas,5,"iva");
                                                $transformacion6=mysql_result($rs_lineas,5,"transformacion");
                                                $costo6=mysql_result($rs_lineas,5,"costo");
                                                $stock6=mysql_result($rs_lineas,5,"stock");
                                                
                                                $descuento_porcentaje6=number_format(round((($descuento_ind6*100)/$subtotal6)*10)/10,2);
                                                
                                                if(($transformacion6 ==2)&&($iva6!=0))
                                                {
                                                    $query_tmp="SELECT SUM(p.pvp)as importeiva
                                                                FROM producto_transformacion pt INNER JOIN producto p ON pt.id_producto = p.id_producto
                                                                WHERE pt.id_transformacion = $idproducto6 AND p.iva=1" ;
                                                    $rs_tmp=mysql_query($query_tmp, $conn);

                                                    $precio_con_iva6=(mysql_result($rs_tmp,0,"importeiva"));
                                                }
                                                else
                                                {
                                                    $precio_con_iva6=0;
                                                }
                                           ?>
                                            <tr class="itemParTabla">
                                                <td ><input NAME="codarticulo6" id="codarticulo6" type="text" class="cajaPequena"  size="15" maxlength="15" value="<?php  echo $codarticulo6; ?>" readonly></td>
                                                <td >
                                                    <img src="../img/ver.png" width="16" height="16" onClick="ventanaArticulos(6)" onMouseOver="style.cursor=cursor" title="Buscar articulos">
                                                    <input NAME="descripcion6" id="descripcion6" type="text" class="cajaExtraGrande" size="30" maxlength="30" value="<?php  echo $descripcion6; ?>" onClick="ventanaArticulos(6)"  readonly>
                                                    <?php  if($iva6!=0){  ?>
                                                    <input style="display: inherit" name="grabaiva6" id="grabaiva6" class="cajaExtraMinima" readonly>
                                                    <?php  }else{?>
                                                    <input style="display: none" name="grabaiva6" id="grabaiva6" class="cajaExtraMinima" readonly>
                                                    <?php  }?>
                                                    
                                                </td>
                                                <td align="center"><input NAME="cantidad6" id="cantidad6" type="text" class="cajaMinima" size="10" maxlength="10" value="<?php  echo $cantidad6; ?>" onChange="actualizar_importe(6)"></td>
                                                <td align="center"><input NAME="precio6" id="precio6" type="text" class="cajaPequena2" size="10" maxlength="10" value="<?php  echo $precio6; ?>" onChange="actualizar_importe(6)"></td>

                                                <td align="center">
                                                    <input NAME="descuentoporc6" id="descuentoporc6" type="text" class="cajaMinima" size="10" maxlength="10" onChange="actualizar_descuento(6)" value="<?php  echo $descuento_porcentaje6;?>">%
                                                    <input NAME="descuento6" id="descuento6" type="text" class="cajaPequena2" size="10" maxlength="10" value="<?php  echo $descuento_ind6; ?>" readonly>&#36;
                                                </td>

                                                <td align="center"><input NAME="subt6" id="subt6" type="text" class="cajaPequena2" value="<?php  echo $subtotal6 - $descuento_ind6 + $iva6; ?>" onchange="actualizar_totales(6)" readonly></td>
                                                <td align="center"><img src="../img/eliminar.png" width="16" height="16" onClick="limpiar_articulo(6)" onMouseOver="style.cursor=cursor" title="Eliminar"> </td>                                        
                                            </tr>
                                            
                                            <input name="idfactulinea6" id="idfactulinea6" type="hidden" value="<?php  echo $idfactulinea6;?>">
                                            <input NAME="importe6" id="importe6" type="hidden" value="<?php  echo $subtotal6; ?>">                                            
                                            <input NAME="iva6" id="iva6" type="hidden" value="<?php  echo $iva6; ?>">
                                            <input name="idarticulo6" id="idarticulo6" value="<?php  echo $idproducto6; ?>" type="hidden" >                                       
                                            <input name="transformacion6" id="transformacion6" value="<?php  echo $transformacion6; ?>" type="hidden">
                                            <input name="precio_con_iva6" id="precio_con_iva6" value="<?php  echo $precio_con_iva6; ?>" type="hidden">
                                            <input name="costo6" id="costo6" value="<?php  echo $costo6 ?>" type="hidden" >
                                            <input name="stock6" id="stock6" type="hidden" value<?php  echo $stock6;?>>
                                            <input name="importe_con_iva6" id="importe_con_iva6" type="hidden" value="<?php  echo $iva6;?>">
                                                <?php  if($iva6!=0){  ?>
                                                <input NAME="ivaporc6" id="ivaporc6" type="hidden" value="12" onChange="suma_iva(6)">
                                                <?php  }else{?>
                                                <input NAME="ivaporc6" id="ivaporc6" type="hidden" value="0" onChange="suma_iva(6)">
                                                <?php  }?>


                                        <?php 
                                            } 
                                            else
                                            {
                                        ?> 
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
                                        <input name="idarticulo6" id="idarticulo6" type="hidden" >                                       
                                        <input name="transformacion6" id="transformacion6" type="hidden">
                                        <input name="precio_con_iva6" id="precio_con_iva6" type="hidden">   
                                        <input name="costo6" id="costo6" type="hidden" >
                                        <input name="stock6" id="stock6" type="hidden">
                                        <input name="importe_con_iva6" id="importe_con_iva6" type="hidden">
                                        <?php  }?>
                                        
                                        <!--FIN ITEM No. 6 de la Factura-------------------------------------------------------------------- -->
                                        <!--************************************************************************************************ -->


                                        <!--************************************************************************************************ -->
                                        <!--INICIO ITEM No. 7 de la Factura----------------------------------------------------------------- -->
                                        <?php  
                                            $idfactulinea7=mysql_result($rs_lineas,6,"id_factulinea");
                                            if($idfactulinea7)
                                            {
                                                $idproducto7=mysql_result($rs_lineas,6,"id_producto");                                               
                                                $codarticulo7=mysql_result($rs_lineas,6,"codigo");
                                                $descripcion7=utf8_decode(mysql_result($rs_lineas,6,"nombre"));
                                                $cantidad7=mysql_result($rs_lineas,6,"cantidad");
                                                $precio7=mysql_result($rs_lineas,6,"precio");
                                                $subtotal7=mysql_result($rs_lineas,6,"subtotal");
                                                $descuento_ind7=mysql_result($rs_lineas,6,"dcto");
                                                $iva7=mysql_result($rs_lineas,6,"iva");
                                                $transformacion7=mysql_result($rs_lineas,6,"transformacion");
                                                $costo7=mysql_result($rs_lineas,6,"costo");
                                                $stock7=mysql_result($rs_lineas,6,"stock");
                                                
                                                $descuento_porcentaje7=number_format(round((($descuento_ind7*100)/$subtotal7)*10)/10,2);
                                                
                                                if(($transformacion7 ==2)&&($iva7!=0))
                                                {
                                                    $query_tmp="SELECT SUM(p.pvp)as importeiva
                                                                FROM producto_transformacion pt INNER JOIN producto p ON pt.id_producto = p.id_producto
                                                                WHERE pt.id_transformacion = $idproducto7 AND p.iva=1" ;
                                                    $rs_tmp=mysql_query($query_tmp, $conn);

                                                    $precio_con_iva7=(mysql_result($rs_tmp,0,"importeiva"));
                                                }
                                                else
                                                {
                                                    $precio_con_iva7=0;
                                                }
                                           ?>
                                            <tr class="itemImparTabla">
                                                <td ><input NAME="codarticulo7" id="codarticulo7" type="text" class="cajaPequena"  size="15" maxlength="15" value="<?php  echo $codarticulo7;?>" readonly></td>
                                                <td >
                                                    <img src="../img/ver.png" width="16" height="16" onClick="ventanaArticulos(7)" onMouseOver="style.cursor=cursor" title="Buscar articulos">
                                                    <input NAME="descripcion7" id="descripcion7" type="text" class="cajaExtraGrande" size="30" maxlength="30" value="<?php  echo $descripcion7;?>" onClick="ventanaArticulos(7)" readonly>
                                                    <?php  if($iva7!=0){  ?>
                                                    <input style="display: inherit" name="grabaiva7" id="grabaiva7" class="cajaExtraMinima" readonly>
                                                    <?php  }else{?>
                                                    <input style="display: none" name="grabaiva7" id="grabaiva7" class="cajaExtraMinima" readonly>
                                                    <?php  }?>
                                                    
                                                </td>
                                                <td align="center"><input NAME="cantidad7" id="cantidad7" type="text" class="cajaMinima" size="10" maxlength="10" value="<?php  echo $cantidad7;?>" onChange="actualizar_importe(7)"></td>
                                                <td align="center"><input NAME="precio7" id="precio7" type="text" class="cajaPequena2" size="10" maxlength="10" value="<?php  echo $precio7;?>" onChange="actualizar_importe(7)"></td>

                                                <td align="center">
                                                    <input NAME="descuentoporc7" id="descuentoporc7" type="text" class="cajaMinima" size="10" maxlength="10" onChange="actualizar_descuento(7)" value="<?php  echo $descuento_porcentaje7;?>">%
                                                    <input NAME="descuento7" id="descuento7" type="text" class="cajaPequena2" size="10" maxlength="10" value="<?php  echo $descuento_ind7;?>" readonly>&#36;
                                                </td>

                                                <td align="center"><input NAME="subt7" id="subt7" type="text" class="cajaPequena2" value="<?php  echo $subtotal7 - $descuento_ind7 + $iva7;?>" onchange="actualizar_totales(7)" readonly></td>
                                                <td align="center"><img src="../img/eliminar.png" width="16" height="16" onClick="limpiar_articulo(7)" onMouseOver="style.cursor=cursor" title="Eliminar"> </td>                                        
                                            </tr>

                                            <input name="idfactulinea7" id="idfactulinea7" type="hidden" value="<?php  echo $idfactulinea7;?>">
                                            <input NAME="importe7" id="importe7" type="hidden" value="<?php  echo $subtotal7;?>">                                           
                                            <input NAME="iva7" id="iva7" type="hidden" value="<?php  echo $iva7;?>">
                                            <input name="idarticulo7" id="idarticulo7" value="<?php  echo $idproducto7;?>" type="hidden" >                                        
                                            <input name="transformacion7" id="transformacion7" type="hidden" value="<?php  echo $transformacion7;?>">
                                            <input name="precio_con_iva7" id="precio_con_iva7" type="hidden" value="<?php  echo $precio_con_iva7;?>">
                                            <input name="costo7" id="costo7" value="<?php  echo $costo7;?>" type="hidden" >
                                            <input name="stock7" id="stock7" type="hidden" value="<?php  echo $stock7;?>">
                                            <input name="importe_con_iva7" id="importe_con_iva7" type="hidden" value="<?php  echo $iva7;?>">
                                                <?php  if($iva7!=0){  ?>
                                                <input NAME="ivaporc7" id="ivaporc7" type="hidden" value="12" onChange="suma_iva(7)">
                                                <?php  }else{?>
                                                <input NAME="ivaporc7" id="ivaporc7" type="hidden" value="0" onChange="suma_iva(7)">
                                                <?php  }?>


                                        <?php 
                                            } 
                                            else
                                            {
                                        ?>
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
                                        <input name="idarticulo7" id="idarticulo7" type="hidden" >                                        
                                        <input name="transformacion7" id="transformacion7" type="hidden">
                                        <input name="precio_con_iva7" id="precio_con_iva7" type="hidden">
                                        <input name="costo7" id="costo7" type="hidden" >
                                        <input name="stock7" id="stock7" type="hidden">
                                        <input name="importe_con_iva7" id="importe_con_iva7" type="hidden">
                                        <?php  }?>                                        
                                        <!--FIN ITEM No. 7 de la Factura-------------------------------------------------------------------- -->
                                        <!--************************************************************************************************ -->

                                        <!--************************************************************************************************ -->
                                        <!--INICIO ITEM No. 8 de la Factura----------------------------------------------------------------- -->
                                        <?php  
                                            $idfactulinea8=mysql_result($rs_lineas,7,"id_factulinea");
                                            if($idfactulinea8)
                                            {
                                                $idproducto8=mysql_result($rs_lineas,7,"id_producto");                                               
                                                $codarticulo8=mysql_result($rs_lineas,7,"codigo");
                                                $descripcion8=utf8_decode(mysql_result($rs_lineas,7,"nombre"));
                                                $cantidad8=mysql_result($rs_lineas,7,"cantidad");
                                                $precio8=mysql_result($rs_lineas,7,"precio");
                                                $subtotal8=mysql_result($rs_lineas,7,"subtotal");
                                                $descuento_ind8=mysql_result($rs_lineas,7,"dcto");
                                                $iva8=mysql_result($rs_lineas,7,"iva");
                                                $transformacion8=mysql_result($rs_lineas,7,"transformacion");
                                                $costo8=mysql_result($rs_lineas,7,"costo");
                                                $stock8=mysql_result($rs_lineas,7,"stock");
                                                
                                                $descuento_porcentaje8=number_format(round((($descuento_ind8*100)/$subtotal8)*10)/10,2);
                                                
                                                if(($transformacion8 ==2)&&($iva8!=0))
                                                {
                                                    $query_tmp="SELECT SUM(p.pvp)as importeiva
                                                                FROM producto_transformacion pt INNER JOIN producto p ON pt.id_producto = p.id_producto
                                                                WHERE pt.id_transformacion = $idproducto8 AND p.iva=1" ;
                                                    $rs_tmp=mysql_query($query_tmp, $conn);

                                                    $precio_con_iva8=(mysql_result($rs_tmp,0,"importeiva"));
                                                }
                                                else
                                                {
                                                    $precio_con_iva8=0;
                                                }
                                           ?>
                                            <tr class="itemParTabla">
                                                <td ><input NAME="codarticulo8" id="codarticulo8" type="text" class="cajaPequena" value="<?php  echo $codarticulo8;?>"  size="15" maxlength="15" readonly></td>
                                                <td >
                                                    <img src="../img/ver.png" width="16" height="16" onClick="ventanaArticulos(8)" onMouseOver="style.cursor=cursor" title="Buscar articulos">
                                                    <input NAME="descripcion8" id="descripcion8" type="text" class="cajaExtraGrande" value="<?php  echo $descripcion8;?>" size="30" maxlength="30" onClick="ventanaArticulos(8)" readonly>
                                                    <?php  if($iva8!=0){  ?>
                                                    <input style="display: inherit" name="grabaiva8" id="grabaiva8" class="cajaExtraMinima" readonly>
                                                    <?php  }else{?>
                                                    <input style="display: none" name="grabaiva8" id="grabaiva8" class="cajaExtraMinima" readonly>
                                                    <?php  }?>
                                                    
                                                </td>
                                                <td align="center"><input NAME="cantidad8" id="cantidad8" type="text" class="cajaMinima" value="<?php  echo $cantidad8;?>" size="10" maxlength="10" value="1" onChange="actualizar_importe(8)"></td>
                                                <td align="center"><input NAME="precio8" id="precio8" type="text" class="cajaPequena2" value="<?php  echo $precio8;?>" size="10" maxlength="10" onChange="actualizar_importe(8)"></td>

                                                <td align="center">
                                                    <input NAME="descuentoporc8" id="descuentoporc8" type="text" class="cajaMinima" size="10" maxlength="10" onChange="actualizar_descuento(8)" value="<?php  echo $descuento_porcentaje8;?>">%
                                                    <input NAME="descuento8" id="descuento8" type="text" class="cajaPequena2" value="<?php  echo $descuento_ind8;?>" size="10" maxlength="10" readonly>&#36;
                                                </td>

                                                <td align="center"><input NAME="subt8" id="subt8" type="text" class="cajaPequena2" value="<?php  echo $subtotal8 - $descuento_ind8 + $iva8;?>" onchange="actualizar_totales(8)" readonly></td>
                                                <td width="4%" align="center"><img src="../img/eliminar.png" width="16" height="16" onClick="limpiar_articulo(8)" onMouseOver="style.cursor=cursor" title="Eliminar"> </td>                                        
                                            </tr>

                                            <input name="idfactulinea8" id="idfactulinea8" type="hidden" value="<?php  echo $idfactulinea8;?>">
                                            <input NAME="importe8" id="importe8" type="hidden" value="<?php  echo $subtotal8;?>">                                            
                                            <input NAME="iva8" id="iva8" type="hidden" value="<?php  echo $iva8;?>">
                                            <input name="idarticulo8" id="idarticulo8" value="<?php  echo $idproducto8;?>" type="hidden" >                                        
                                            <input name="transformacion8" id="transformacion8" value="<?php  echo $transformacion8;?>" type="hidden">
                                            <input name="precio_con_iva8" id="precio_con_iva8" value="<?php  echo $precio_con_iva8;?>" type="hidden">
                                             <input name="costo8" id="costo8" value="<?php  echo $costo8;?>" type="hidden" >
                                            <input name="stock8" id="stock8" type="hidden" value="<?php  echo $stock8;?>">
                                            <input name="importe_con_iva8" id="importe_con_iva8" type="hidden" value="<?php  echo $iva8;?>">
                                                <?php  if($iva8!=0){  ?>
                                                <input NAME="ivaporc8" id="ivaporc8" value="12" type="hidden" onChange="suma_iva(8)">
                                                <?php  }else{?>
                                                <input NAME="ivaporc8" id="ivaporc8" value="0" type="hidden" onChange="suma_iva(8)">
                                                <?php  }?>


                                        <?php 
                                            } 
                                            else
                                            {
                                        ?> 
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
                                        <input name="idarticulo8" id="idarticulo8" type="hidden" >                                        
                                        <input name="transformacion8" id="transformacion8" type="hidden">
                                        <input name="precio_con_iva8" id="precio_con_iva8" type="hidden">
                                         <input name="costo8" id="costo8"  type="hidden" >
                                        <input name="stock8" id="stock8" type="hidden">
                                        <input name="importe_con_iva8" id="importe_con_iva8" type="hidden">
                                        <?php  }?>                                                                               
                                        <!--FIN ITEM No. 8 de la Factura-------------------------------------------------------------------- -->
                                        <!--************************************************************************************************ -->


                                        <!--************************************************************************************************ -->
                                        <!--INICIO ITEM No. 9 de la Factura----------------------------------------------------------------- -->
                                        <?php  
                                            $idfactulinea9=mysql_result($rs_lineas,8,"id_factulinea");
                                            if($idfactulinea9)
                                            {
                                                $idproducto9=mysql_result($rs_lineas,8,"id_producto");                                               
                                                $codarticulo9=mysql_result($rs_lineas,8,"codigo");
                                                $descripcion9=utf8_decode(mysql_result($rs_lineas,8,"nombre"));
                                                $cantidad9=mysql_result($rs_lineas,8,"cantidad");
                                                $precio9=mysql_result($rs_lineas,8,"precio");
                                                $subtotal9=mysql_result($rs_lineas,8,"subtotal");
                                                $descuento_ind9=mysql_result($rs_lineas,8,"dcto");
                                                $iva9=mysql_result($rs_lineas,8,"iva");
                                                $transformacion9=mysql_result($rs_lineas,8,"transformacion");
                                                $costo9=mysql_result($rs_lineas,8,"costo");
                                                $stock9=mysql_result($rs_lineas,8,"stock");
                                                
                                                $descuento_porcentaje9=number_format(round((($descuento_ind9*100)/$subtotal9)*10)/10,2);
                                                
                                                if(($transformacion9 ==2)&&($iva9!=0))
                                                {
                                                    $query_tmp="SELECT SUM(p.pvp)as importeiva
                                                                FROM producto_transformacion pt INNER JOIN producto p ON pt.id_producto = p.id_producto
                                                                WHERE pt.id_transformacion = $idproducto9 AND p.iva=1" ;
                                                    $rs_tmp=mysql_query($query_tmp, $conn);

                                                    $precio_con_iva9=(mysql_result($rs_tmp,0,"importeiva"));
                                                }
                                                else
                                                {
                                                    $precio_con_iva9=0;
                                                }
                                           ?>
                                            <tr class="itemImparTabla">
                                                <td ><input NAME="codarticulo9" id="codarticulo9" type="text" class="cajaPequena" value="<?php  echo $codarticulo9;?>"  size="15" maxlength="15" readonly></td>
                                                <td >
                                                    <img src="../img/ver.png" width="16" height="16" onClick="ventanaArticulos(9)" onMouseOver="style.cursor=cursor" title="Buscar articulos">
                                                    <input NAME="descripcion9" id="descripcion9" type="text" class="cajaExtraGrande" value="<?php  echo $descripcion9;?>" size="30" maxlength="30" onClick="ventanaArticulos(9)" readonly>
                                                    <?php  if($iva9!=0){  ?>
                                                    <input style="display: inherit" name="grabaiva9" id="grabaiva9" class="cajaExtraMinima" readonly>
                                                    <?php  }else{?>
                                                    <input style="display: none" name="grabaiva9" id="grabaiva9" class="cajaExtraMinima" readonly>
                                                    <?php  }?>                                                    
                                                </td>
                                                <td align="center"><input NAME="cantidad9" id="cantidad9" type="text" class="cajaMinima" value="<?php  echo $cantidad9;?>" size="10" maxlength="10" value="1" onChange="actualizar_importe(9)"></td>
                                                <td align="center"><input NAME="precio9" id="precio9" type="text" class="cajaPequena2" value="<?php  echo $precio9;?>" size="10" maxlength="10" onChange="actualizar_importe(9)" ></td>

                                                <td align="center">
                                                    <input NAME="descuentoporc9" id="descuentoporc9" type="text" class="cajaMinima" size="10" maxlength="10" onChange="actualizar_descuento(9)" value="<?php  echo $descuento_porcentaje9;?>">%
                                                    <input NAME="descuento9" id="descuento9" type="text" class="cajaPequena2" value="<?php  echo $descuento_ind9;?>" size="10" maxlength="10" readonly>&#36;
                                                </td>

                                                <td align="center"><input NAME="subt9" id="subt9" type="text" class="cajaPequena2" value="<?php  echo $subtotal9 - $descuento_ind9 + $iva9;?>" onchange="actualizar_totales(9)" readonly></td>
                                                <td align="center"><img src="../img/eliminar.png" width="16" height="16" onClick="limpiar_articulo(9)" onMouseOver="style.cursor=cursor" title="Eliminar"> </td>                                        
                                            </tr>

                                            <input name="idfactulinea9" id="idfactulinea9" type="hidden" value="<?php  echo $idfactulinea9;?>">
                                            <input NAME="importe9" id="importe9" type="hidden" value="<?php  echo $subtotal9;?>">                                            
                                            <input NAME="iva9" id="iva9" type="hidden" value="<?php  echo $iva9;?>">
                                            <input name="idarticulo9" id="idarticulo9" value="<?php  echo $idproducto9;?>" type="hidden" >                                       
                                            <input name="transformacion9" id="transformacion9" value="<?php  echo $transformacion9;?>" type="hidden">
                                            <input name="precio_con_iva9" id="precio_con_iva9" value="<?php  echo $precio_con_iva9;?>" type="hidden">
                                            <input name="costo9" id="costo9" value="<?php  echo $costo9;?>" type="hidden" >
                                            <input name="stock9" id="stock9" type="hidden" value="<?php  echo $stock9;?>">
                                            <input name="importe_con_iva9" id="importe_con_iva9" type="hidden" value="<?php  echo $iva9;?>">
                                                <?php  if($iva9!=0){  ?>
                                                <input NAME="ivaporc9" id="ivaporc9" value="12" type="hidden" onChange="suma_iva(9)">
                                                <?php  }else{?>
                                                <input NAME="ivaporc9" id="ivaporc9" value="0" type="hidden" onChange="suma_iva(9)">
                                                <?php  }?>
                                        <?php 
                                            } 
                                            else
                                            {
                                        ?>
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
                                        <input name="idarticulo9" id="idarticulo9" value="<?php  echo $idarticulo?>" type="hidden" >                                       
                                        <input name="transformacion9" id="transformacion9" type="hidden">
                                        <input name="precio_con_iva9" id="precio_con_iva9" type="hidden">
                                        <input name="costo9" id="costo9" type="hidden" >
                                        <input name="stock9" id="stock9" type="hidden">
                                        <input name="importe_con_iva9" id="importe_con_iva9" type="hidden">
                                        <?php  }?>                                        
                                        <!--FIN ITEM No. 9 de la Factura-------------------------------------------------------------------- -->
                                        <!--************************************************************************************************ -->

                                        <!--************************************************************************************************ -->
                                        <!--INICIO ITEM No. 10 de la Factura----------------------------------------------------------------- -->
                                        <?php  
                                            $idfactulinea10=mysql_result($rs_lineas,9,"id_factulinea");
                                            if($idfactulinea10)
                                            {
                                                $idproducto10=mysql_result($rs_lineas,9,"id_producto");                                               
                                                $codarticulo10=mysql_result($rs_lineas,9,"codigo");
                                                $descripcion10=utf8_decode(mysql_result($rs_lineas,9,"nombre"));
                                                $cantidad10=mysql_result($rs_lineas,9,"cantidad");
                                                $precio10=mysql_result($rs_lineas,9,"precio");
                                                $subtotal10=mysql_result($rs_lineas,9,"subtotal");
                                                $descuento_ind10=mysql_result($rs_lineas,9,"dcto");
                                                $iva10=mysql_result($rs_lineas,9,"iva");
                                                $transformacion10=mysql_result($rs_lineas,9,"transformacion");
                                                $costo10=mysql_result($rs_lineas,9,"costo");
                                                $stock10=mysql_result($rs_lineas,9,"stock");
                                                
                                                $descuento_porcentaje10=number_format(round((($descuento_ind10*100)/$subtotal10)*10)/10,2);
                                                
                                                if(($transformacion10 ==2)&&($iva10!=0))
                                                {
                                                    $query_tmp="SELECT SUM(p.pvp)as importeiva
                                                                FROM producto_transformacion pt INNER JOIN producto p ON pt.id_producto = p.id_producto
                                                                WHERE pt.id_transformacion = $idproducto10 AND p.iva=1" ;
                                                    $rs_tmp=mysql_query($query_tmp, $conn);

                                                    $precio_con_iva10=(mysql_result($rs_tmp,0,"importeiva"));
                                                }
                                                else
                                                {
                                                    $precio_con_iva10=0;
                                                }
                                           ?>
                                            <tr class="itemParTabla">
                                                <td ><input NAME="codarticulo10" id="codarticulo10" type="text" class="cajaPequena" value="<?php  echo $codarticulo10;?>"  size="15" maxlength="15" readonly></td>
                                                <td >
                                                    <img src="../img/ver.png" width="16" height="16" onClick="ventanaArticulos(10)" onMouseOver="style.cursor=cursor" title="Buscar articulos">
                                                    <input NAME="descripcion10" id="descripcion10" type="text" class="cajaExtraGrande" value="<?php  echo $descripcion10;?>" size="30" maxlength="30" onClick="ventanaArticulos(10)" readonly>
                                                    <?php  if($iva10!=0){  ?>
                                                    <input style="display: inherit" name="grabaiva10" id="grabaiva10" class="cajaExtraMinima" readonly>
                                                    <?php  }else{?>
                                                    <input style="display: none" name="grabaiva10" id="grabaiva10" class="cajaExtraMinima" readonly>
                                                    <?php  }?>                                                    
                                                </td>
                                                <td align="center"><input NAME="cantidad10" id="cantidad10" type="text" class="cajaMinima" value="<?php  echo $cantidad10;?>" size="10" maxlength="10" value="1" onChange="actualizar_importe(10)"></td>
                                                <td align="center"><input NAME="precio10" id="precio10" type="text" class="cajaPequena2" value="<?php  echo $precio10;?>" size="10" maxlength="10" onChange="actualizar_importe(10)"></td>

                                                <td align="center">
                                                    <input NAME="descuentoporc10" id="descuentoporc10" type="text" class="cajaMinima" size="10" maxlength="10" onChange="actualizar_descuento(10)" value="<?php  echo $descuento_porcentaje10;?>">%
                                                    <input NAME="descuento10" id="descuento10" type="text" class="cajaPequena2" value="<?php  echo $descuento_ind10;?>" size="10" maxlength="10"  readonly>&#36;
                                                </td>

                                                <td align="center"><input NAME="subt10" id="subt10" type="text" class="cajaPequena2" value="<?php  echo $subtotal10 - $descuento_ind10 + $iva10;?>" onchange="actualizar_totales(10)" readonly></td>
                                                <td align="center"><img src="../img/eliminar.png" width="16" height="16" onClick="limpiar_articulo(10)" onMouseOver="style.cursor=cursor" title="Eliminar"> </td>                                        
                                            </tr>

                                            <input name="idfactulinea10" id="idfactulinea10" type="hidden" value="<?php  echo $idfactulinea10;?>">
                                            <input NAME="importe10" id="importe10" type="hidden" value="<?php  echo $subtotal10;?>">                                            
                                            <input NAME="iva10" id="iva10" type="hidden" value="<?php  echo $iva10;?>">
                                            <input name="idarticulo10" id="idarticulo10" value="<?php  echo $idproducto10;?>" type="hidden" >                                        
                                            <input name="transformacion10" id="transformacion10" value="<?php  echo $transformacion10;?>" type="hidden">
                                            <input name="precio_con_iva10" id="precio_con_iva10" value="<?php  echo $precio_con_iva10;?>" type="hidden">
                                            <input name="costo10" id="costo10" value="<?php  echo $costo10;?>" type="hidden" >
                                            <input name="stock10" id="stock10" type="hidden" value="<?php  echo $stock10;?>">
                                            <input name="importe_con_iva10" id="importe_con_iva10" type="hidden" value="<?php  echo $iva10;?>">
                                                <?php  if($iva10!=0){  ?>
                                                <input NAME="ivaporc10" id="ivaporc10" value="12" type="hidden" onChange="suma_iva(10)">
                                                <?php  }else{?>
                                                <input NAME="ivaporc10" id="ivaporc10" value="0" type="hidden" onChange="suma_iva(10)">
                                                <?php  }?>


                                        <?php 
                                            } 
                                            else
                                            {
                                        ?>
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
                                        <input name="idarticulo10" id="idarticulo10" value="<?php  echo $idarticulo?>" type="hidden" >                                        
                                        <input name="transformacion10" id="transformacion10" type="hidden">
                                        <input name="precio_con_iva10" id="precio_con_iva10" type="hidden">
                                        <input name="costo10" id="costo10" type="hidden" >
                                        <input name="stock10" id="stock10" type="hidden">
                                        <input name="importe_con_iva10" id="importe_con_iva10" type="hidden">
                                        <?php  }?>
                                        
                                        <!--FIN ITEM No. 10 de la Factura-------------------------------------------------------------------- -->
                                        <!--************************************************************************************************ -->

                                        <!--************************************************************************************************ -->
                                        <!--INICIO ITEM No. 11 de la Factura----------------------------------------------------------------- -->
                                        <?php  
                                            $idfactulinea11=mysql_result($rs_lineas,10,"id_factulinea");
                                            if($idfactulinea11)
                                            {
                                                $idproducto11=mysql_result($rs_lineas,10,"id_producto");                                               
                                                $codarticulo11=mysql_result($rs_lineas,10,"codigo");
                                                $descripcion11=utf8_decode(mysql_result($rs_lineas,10,"nombre"));
                                                $cantidad11=mysql_result($rs_lineas,10,"cantidad");
                                                $precio11=mysql_result($rs_lineas,10,"precio");
                                                $subtotal11=mysql_result($rs_lineas,10,"subtotal");
                                                $descuento_ind11=mysql_result($rs_lineas,10,"dcto");
                                                $iva11=mysql_result($rs_lineas,10,"iva");
                                                $transformacion11=mysql_result($rs_lineas,10,"transformacion");
                                                $costo11=mysql_result($rs_lineas,10,"costo");
                                                $stock11=mysql_result($rs_lineas,10,"stock");
                                                
                                                $descuento_porcentaje11=number_format(round((($descuento_ind11*100)/$subtotal11)*10)/10,2);
                                                
                                                if(($transformacion11 ==2)&&($iva11!=0))
                                                {
                                                    $query_tmp="SELECT SUM(p.pvp)as importeiva
                                                                FROM producto_transformacion pt INNER JOIN producto p ON pt.id_producto = p.id_producto
                                                                WHERE pt.id_transformacion = $idproducto11 AND p.iva=1" ;
                                                    $rs_tmp=mysql_query($query_tmp, $conn);

                                                    $precio_con_iva11=(mysql_result($rs_tmp,0,"importeiva"));
                                                }
                                                else
                                                {
                                                    $precio_con_iva11=0;
                                                }
                                           ?>
                                            <tr class="itemImparTabla">
                                                <td ><input NAME="codarticulo11" id="codarticulo11" type="text" class="cajaPequena" value="<?php  echo $codarticulo11;?>"  size="15" maxlength="15" readonly></td>
                                                <td >
                                                    <img src="../img/ver.png" width="16" height="16" onClick="ventanaArticulos(11)" onMouseOver="style.cursor=cursor" title="Buscar articulos">
                                                    <input NAME="descripcion11" id="descripcion11" type="text" class="cajaExtraGrande" value="<?php  echo $descripcion11;?>" size="30" maxlength="30" onClick="ventanaArticulos(11)" readonly>
                                                    <?php  if($iva11!=0){  ?>
                                                    <input style="display: inherit" name="grabaiva11" id="grabaiva11" class="cajaExtraMinima" readonly>
                                                    <?php  }else{?>
                                                    <input style="display: none" name="grabaiva11" id="grabaiva11" class="cajaExtraMinima" readonly>
                                                    <?php  }?>                                                    
                                                </td>
                                                <td align="center"><input NAME="cantidad11" id="cantidad11" type="text" class="cajaMinima" value="<?php  echo $cantidad11;?>" size="10" maxlength="10" value="1" onChange="actualizar_importe(11)"></td>
                                                <td align="center"><input NAME="precio11" id="precio11" type="text" class="cajaPequena2" value="<?php  echo $precio11;?>" size="10" maxlength="10" onChange="actualizar_importe(11)"></td>                                                
                                                <td align="center">
                                                    <input NAME="descuentoporc11" id="descuentoporc11" type="text" class="cajaMinima"  size="10" maxlength="10" onChange="actualizar_descuento(11)" value="<?php  echo $descuento_porcentaje11;?>">%
                                                    <input NAME="descuento11" id="descuento11" type="text" class="cajaPequena2" value="<?php  echo $descuento_ind11;?>" size="10" maxlength="10" readonly>&#36;
                                                </td>
                                                <td align="center"><input NAME="subt11" id="subt11" type="text" class="cajaPequena2" value="<?php  echo $subtotal11 - $descuento_ind11 + $iva11;?>" onchange="actualizar_totales(11)" readonly></td>
                                                <td align="center"><img src="../img/eliminar.png" width="16" height="16" onClick="limpiar_articulo(11)" onMouseOver="style.cursor=cursor" title="Eliminar"> </td>                                        
                                            </tr>
                                            
                                            <input name="idfactulinea11" id="idfactulinea11" type="hidden" value="<?php  echo $idfactulinea11;?>">
                                            <input NAME="importe11" id="importe11" type="hidden" value="<?php  echo $subtotal11;?>">                                            
                                            <input NAME="iva11" id="iva11" type="hidden" value="<?php  echo $iva11;?>">
                                            <input name="idarticulo11" id="idarticulo11" value="<?php  echo $idproducto11;?>" type="hidden" >                                        
                                            <input name="transformacion11" id="transformacion11" value="<?php  echo $transformacion11;?>" type="hidden">
                                            <input name="precio_con_iva11" id="precio_con_iva11" value="<?php  echo $precio_con_iva11;?>" type="hidden">
                                            <input name="costo11" id="costo11" value="<?php  echo $costo11;?>" type="hidden" >
                                            <input name="stock11" id="stock11" type="hidden" value="<?php  echo $stock11;?>">
                                            <input name="importe_con_iva11" id="importe_con_iva11" type="hidden" value="<?php  echo $iva11;?>">
                                                <?php  if($iva11!=0){  ?>
                                                <input NAME="ivaporc11" id="ivaporc11" value="12" type="hidden" onChange="suma_iva(11)">
                                                <?php  }else{?>
                                                <input NAME="ivaporc11" id="ivaporc11" value="0" type="hidden" onChange="suma_iva(11)">
                                                <?php  }?>


                                        <?php 
                                            } 
                                            else
                                            {
                                        ?>
                                        <tr class="itemImparTabla">
                                            <td ><input NAME="codarticulo11" id="codarticulo11" type="text" class="cajaPequena"  size="15" maxlength="15" readonly></td>
                                            <td >
                                                <img src="../img/ver.png" width="16" height="16" onClick="ventanaArticulos(11)" onMouseOver="style.cursor=cursor" title="Buscar articulos">
                                                <input NAME="descripcion11" id="descripcion11" type="text" class="cajaExtraGrande" size="30" maxlength="30" onClick="ventanaArticulos(11)" readonly>
						<input style="display: none" name="grabaiva11" id="grabaiva11" class="cajaExtraMinima" readonly>
                                            </td>
                                            <td align="center"><input NAME="cantidad11" id="cantidad11" type="text" class="cajaMinima" size="10" maxlength="10" value="1" onChange="actualizar_importe(11)"></td>
                                            <td align="center"><input NAME="precio11" id="precio11" type="text" class="cajaPequena2" size="10" maxlength="10" onChange="actualizar_importe(11)"></td>                                           
                                            <td align="center">
                                                <input NAME="descuentoporc11" id="descuentoporc11" type="text" class="cajaMinima" size="10" maxlength="10" onChange="actualizar_descuento(11)" value="0">%
                                                <input NAME="descuento11" id="descuento11" type="text" class="cajaPequena2" size="10" maxlength="10" value="0" readonly>&#36;
                                            </td>                                            
                                            <td align="center"><input NAME="subt11" id="subt11" type="text" class="cajaPequena2" value="0" onchange="actualizar_totales(11)" readonly></td>
                                            <td align="center"><img src="../img/eliminar.png" width="16" height="16" onClick="limpiar_articulo(11)" onMouseOver="style.cursor=cursor" title="Eliminar"> </td>                                        
					</tr>

                                        <input NAME="importe11" id="importe11" type="hidden" value="0">
                                        <input NAME="ivaporc11" id="ivaporc11" type="hidden" onChange="suma_iva(11)">
                                        <input NAME="iva11" id="iva11" type="hidden" value="0">
                                        <input name="idarticulo11" id="idarticulo11" value="<?php  echo $idarticulo?>" type="hidden" >                                        
                                        <input name="transformacion11" id="transformacion11" type="hidden">
                                        <input name="precio_con_iva11" id="precio_con_iva11" type="hidden">
                                        <input name="costo11" id="costo11" type="hidden">
                                        <input name="stock11" id="stock11" type="hidden">
                                        <input name="importe_con_iva11" id="importe_con_iva11" type="hidden">
                                        <?php  }?>
                                        
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
                                                        <input class="cajaTotales" name="baseimponible" type="text" id="baseimponible" value="<?php  echo number_format($baseimponible,2);?>" size="12" value=0 align="right" readonly>
                                                &#36;</div></td>
                                                  </tr>
                                                    
                                                   <tr>
                                                    <td width="" class="busqueda">Descuento                                                                                                           
                                                    </td>
                                                
                                                <td width="" align="right"><div align="center">
                                                                <input class="cajaTotales" name="descuentototal" type="text" id="descuentototal" value="<?php  echo number_format($descuento,2);?>" size="12" value=0 align="right" readonly>
                                                &#36;</div></td>

                                                  </tr>

                                                  <tr>
                                                    <td width="" class="busqueda">IVA 0%</td>
                                                        <td width="" align="right"><div align="center">
                                                      <input class="cajaTotales" name="iva0" type="text" id="iva0" value="<?php  echo number_format($iva0,2);?>" size="12" value=0 align="right" readonly>
                                                &#36;</div></td>
                                                  </tr>


                                                  <tr>
                                                        <td class="busqueda">IVA 12%</td>
                                                        <td align="right"><div align="center">
                                                      <input class="cajaTotales" name="iva12" type="text" id="iva12" value="<?php  echo number_format($iva12,2);?>" size="12" align="right" value=0 readonly>
                                                &#36;</div></td>
                                                  </tr>

                                                  <tr>
                                                    <td width="" class="busqueda">Total IVA</td>
                                                        <td width="" align="right"><div align="center">
                                                      <input class="cajaTotales" name="importeiva" type="text" id="importeiva" value="<?php  echo number_format($importeiva,2);?>" size="12" value=0 align="right" readonly>
                                                &#36;</div></td>
                                                  </tr>
                                                  <tr>
                                                    <td width="" class="busqueda" >Flete</td>
                                                        <td width="" align="right"><div align="center">
                                                                <input class="cajaTotales" name="flete" type="text" id="flete" value="<?php  echo $flete?>" size="12" value=0 align="right" onchange="sumar_flete()">
                                                &#36;</div></td>
                                                  </tr>

                                                 

                                                  <tr>
                                                        <td class="busqueda">Precio Total</td>
                                                        <td align="right"><div align="center">
                                                      <input class="cajaTotales" name="preciototal" type="text" id="preciototal" value="<?php  echo $totalfactura?>" size="12" align="right" value=0 readonly>
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
                                <input id="accion" name="accion" value="modificar" type="hidden">
			  </form>
			 </div>
		  </div>
		</div>
	</body>
</html>
