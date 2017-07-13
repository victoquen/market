<?php   
include ("../js/fechas.php");
include ("../conexion/conexion.php");
error_reporting(0);

$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$fechahoy=date("Y-m-d");

error_reporting(0);
$idretencion=$_GET["idretencion"];


$query_ret="SELECT id_factura, serie1, serie2, codigo_retencion, autorizacion, concepto, totalretencion,fecha
            FROM retencion
            WHERE id_retencion=$idretencion";
$res_ret=mysql_query($query_ret,$conn);
$idfactura=mysql_result($res_ret,0,"id_factura");

//datos proveedor
$query_prov="SELECT fp.id_proveedor id_proveedor, p.empresa as empresa, p.ci_ruc as ci_ruc, p.direccion as direccion, fp.tipocomprobante as tipocomprobante, fp.serie1 as serie1, fp.serie2 as serie2, fp.codigo_factura as codigo_factura
             FROM proveedor p INNER JOIN facturasp fp ON p.id_proveedor = fp.id_proveedor
             WHERE fp.id_facturap= $idfactura";
$res_prov=mysql_query($query_prov,$conn);


//telefono proveedor
$id_prov=mysql_result($res_prov,0,"id_proveedor");
$query_fono="SELECT numero FROM proveedorfono WHERE id_proveedor = $id_prov";
$res_fono=mysql_query($query_fono,$conn);

//datos codigos retencion
$query_reten = "SELECT id_codretencion, codigo, nombre, porcentaje, tipo FROM codretencion WHERE borrado = 0 ORDER BY codigo";
$res_reten = mysql_query($query_reten, $conn);
?>




<html>
	<head>
		<title>Principal</title>
                <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
		<link href="../calendario/calendar-blue.css" rel="stylesheet" type="text/css">
		<script type="text/JavaScript" language="javascript" src="../calendario/calendar.js"></script>
		<script type="text/JavaScript" language="javascript" src="../calendario/lang/calendar-sp.js"></script>
		<script type="text/JavaScript" language="javascript" src="../calendario/calendar-setup.js"></script>	
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
               
               function activar_codigo(op,indice)
                {

                    switch (op)
                    {
                        case 1:
                               with (document.formulario)
                               {
                                     impuesto=(impuesto1.options[indice].value).split("*");                                     
                                     codigoimpuesto1.value=impuesto[0];									 
									 porcretencion1.value = impuesto[1];									                                   
                               }
                                break;
                        case 2:
                                with (document.formulario)
                               {
                                     impuesto=(impuesto2.options[indice].value).split("*");                                     
                                     codigoimpuesto2.value=impuesto[0];									 
									 porcretencion2.value = impuesto[1];
                               }
                                break;
                        case 3:
                                with (document.formulario)
                               {
                                     impuesto=(impuesto3.options[indice].value).split("*");                                     
                                     codigoimpuesto3.value=impuesto[0];									 
									 porcretencion3.value = impuesto[1];
                               }
                                break;
                        case 4:
                                with (document.formulario)
                               {
                                     impuesto=(impuesto4.options[indice].value).split("*");                                     
                                     codigoimpuesto4.value=impuesto[0];									 
									 porcretencion4.value = impuesto[1];
                               }
                                break;
                        case 5:
                                with (document.formulario)
                               {
                                     impuesto=(impuesto5.options[indice].value).split("*");                                     
                                     codigoimpuesto5.value=impuesto[0];									 
									 porcretencion5.value = impuesto[1];
                               }
                                break;
                    }
                    calcular_porc(op);
                    llenar_concepto();
                }

                
                function calcular_porc(op)
                {
                    var original=0;
                    var result=0;
                    switch(op)
                    {
                        case 1:                                                           
                                if((isNaN(document.getElementById("base1").value)==true))
                                {
                                    alert("Base imponible debe ser numerico");
                                }
                                else
                                {
                                    document.getElementById("valorretenido1").value=parseFloat(document.getElementById("base1").value) * parseFloat(document.getElementById("porcretencion1").value / 100);
                                    document.getElementById("base1").value=parseFloat(document.getElementById("base1").value).toFixed(2);
                                    original=parseFloat(document.getElementById("valorretenido1").value);
                                    result=Math.round(original*100)/100 ;
                                    document.getElementById("valorretenido1").value=result.toFixed(2);
                                }                                
                                break;
                        case 2:
                                if((isNaN(document.getElementById("base2").value)==true))
                                {
                                    alert("Base imponible debe ser numerico");
                                }
                                else
                                {
                                    document.getElementById("valorretenido2").value=parseFloat(document.getElementById("base2").value) * parseFloat(document.getElementById("porcretencion2").value / 100);
                                    document.getElementById("base2").value=parseFloat(document.getElementById("base2").value).toFixed(2);
                                    original=parseFloat(document.getElementById("valorretenido2").value);
                                    result=Math.round(original*100)/100 ;
                                    document.getElementById("valorretenido2").value=result.toFixed(2);
                                }
                                break;
                        case 3:
                                if((isNaN(document.getElementById("base3").value)==true))
                                {
                                    alert("Base imponible debe ser numerico");
                                }
                                else
                                {
                                    document.getElementById("valorretenido3").value=parseFloat(document.getElementById("base3").value) * parseFloat(document.getElementById("porcretencion3").value / 100);
                                    document.getElementById("base3").value=parseFloat(document.getElementById("base3").value).toFixed(2);
                                    original=parseFloat(document.getElementById("valorretenido3").value);
                                    result=Math.round(original*100)/100 ;
                                    document.getElementById("valorretenido3").value=result.toFixed(2);
                                }
                                break;
                        case 4:
                                if((isNaN(document.getElementById("base4").value)==true))
                                {
                                    alert("Base imponible debe ser numerico");
                                }
                                else
                                {
                                    document.getElementById("valorretenido4").value=parseFloat(document.getElementById("base4").value) * parseFloat(document.getElementById("porcretencion4").value / 100);
                                    document.getElementById("base4").value=parseFloat(document.getElementById("base4").value).toFixed(2);
                                    original=parseFloat(document.getElementById("valorretenido4").value);
                                    result=Math.round(original*100)/100 ;
                                    document.getElementById("valorretenido4").value=result.toFixed(2);
                                }
                                break;
                        case 5:
                                if((isNaN(document.getElementById("base5").value)==true))
                                {
                                    alert("Base imponible debe ser numerico");
                                }
                                else
                                {
                                    document.getElementById("valorretenido5").value=parseFloat(document.getElementById("base5").value) * parseFloat(document.getElementById("porcretencion5").value / 100);
                                    document.getElementById("base5").value=parseFloat(document.getElementById("base5").value).toFixed(2);
                                    original=parseFloat(document.getElementById("valorretenido5").value);
                                    result=Math.round(original*100)/100 ;
                                    document.getElementById("valorretenido5").value=result.toFixed(2);
                                }
                                break;
                    }
                    sumar_total();
                }

                function sumar_total()
                {
                    var tot=0
                    if(document.getElementById("valorretenido1").value!="")
                        tot += parseFloat(document.getElementById("valorretenido1").value);
                    if(document.getElementById("valorretenido2").value!="")
                        tot += parseFloat(document.getElementById("valorretenido2").value);
                    if(document.getElementById("valorretenido3").value!="")
                        tot += parseFloat(document.getElementById("valorretenido3").value);
                    if(document.getElementById("valorretenido4").value!="")
                        tot += parseFloat(document.getElementById("valorretenido4").value);
                    if(document.getElementById("valorretenido5").value!="")
                        tot += parseFloat(document.getElementById("valorretenido5").value);

                    document.getElementById("totalretencion").value=tot;
                    var orig=parseFloat(document.getElementById("totalretencion").value);
                    var result=Math.round(orig*100)/100;
                    document.getElementById("totalretencion").value=result.toFixed(2);
                }

                function limpiar_retencion(op)
                {
                    var fecha=new Date();
                    var year=fecha.getFullYear();
                    switch (op)
                    {
                        case 1:
                                document.getElementById("ejercicio1").value=year;
                                document.getElementById("base1").value=0;
                                document.getElementById("impuesto1").value=0;
                                document.getElementById("codigoimpuesto1").value="";
                                document.getElementById("porcretencion1").value=0;
                                document.getElementById("valorretenido1").value="";
                                break;
                        case 2:
                                document.getElementById("ejercicio2").value=year;
                                document.getElementById("base2").value=0;
                                document.getElementById("impuesto2").value=0;
                                document.getElementById("codigoimpuesto2").value="";
                                document.getElementById("porcretencion2").value=0;
                                document.getElementById("valorretenido2").value="";
                                break;
                        case 3:
                                document.getElementById("ejercicio3").value=year;
                                document.getElementById("base3").value=0;
                                document.getElementById("impuesto3").value=0;
                                document.getElementById("codigoimpuesto3").value="";
                                document.getElementById("porcretencion3").value=0;
                                document.getElementById("valorretenido3").value="";
                                break;
                        case 4:
                                document.getElementById("ejercicio4").value=year;
                                document.getElementById("base4").value=0;
                                document.getElementById("impuesto4").value=0;
                                document.getElementById("codigoimpuesto4").value="";
                                document.getElementById("porcretencion4").value=0;
                                document.getElementById("valorretenido4").value="";
                                break;
                        case 5:
                                document.getElementById("ejercicio5").value=year;
                                document.getElementById("base5").value=0;
                                document.getElementById("impuesto5").value=0;
                                document.getElementById("codigoimpuesto5").value="";
                                document.getElementById("porcretencion5").value=0;
                                document.getElementById("valorretenido5").value="";
                                break;
                      
                    }
                    sumar_total();
                    llenar_concepto();
                }


                function llenar_concepto()
                {
                    var concepto="";
                    var indice;
                    if(document.getElementById("impuesto1").value !="0")
                    {
                        indice = document.formulario.impuesto1.selectedIndex;
                        concepto += document.formulario.impuesto1.options[indice].text +" - ";
                    }
                    if(document.getElementById("impuesto2").value !="0")
                    {
                        indice = document.formulario.impuesto2.selectedIndex;
                        concepto += document.formulario.impuesto2.options[indice].text +" - ";
                    }
                    if(document.getElementById("impuesto3").value !="0")
                    {
                        indice = document.formulario.impuesto3.selectedIndex;
                        concepto += document.formulario.impuesto3.options[indice].text +" - ";
                    }
                    if(document.getElementById("impuesto4").value !="0")
                    {
                        indice = document.formulario.impuesto4.selectedIndex;
                        concepto += document.formulario.impuesto4.options[indice].text +" - ";
                    }
                    if(document.getElementById("impuesto5").value !="0")
                    {
                        indice = document.formulario.impuesto5.selectedIndex;
                        concepto += document.formulario.impuesto5.options[indice].text +" - ";
                    }
                    document.getElementById("concepto").value=concepto;
                }

                function validar()
                {
                    if(document.getElementById("totalretencion").value==0)
                        {
                            alert("ERROR\nDebe existir al menos 1 impuesto");
                        }
                    else
                    {
                        document.getElementById("formulario").submit();
                    }

                }

                function imprimir(idretencion) {
			window.open("../imprimir/imprimir_retencion_venta.php?idretencion="+idretencion);
		}

                function cancelar() {
			location.href="index.php";
		}

		</script>
	</head>
        <body  >
		<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header">INSERTAR RETENCION COMPRA</div>
				<div id="frmBusqueda">
				<form id="formulario" name="formulario" method="post" action="guardar_retencion.php">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
                                                <tr>
                                                    <td width="10%">No. retenci&oacute;n</td>
                                                    <td>
                                                        <input NAME="serie1" type="text" class="cajaMinima" id="serie1" value="<?php  echo mysql_result($res_ret,0,"serie1")?>" readonly>
                                                        <input NAME="serie2" type="text" class="cajaMinima" id="serie2" value="<?php  echo mysql_result($res_ret,0,"serie2")?>" readonly>
                                                        <input NAME="codretencion" type="text" class="cajaPequena" id="codretencion" value="<?php  echo mysql_result($res_ret,0,"codigo_retencion")?>">

                                                    </td>
                                                    <td width="12%">Autorizaci&oacute;n</td>
                                                    <td colspan="2">
                                                        <input NAME="autorizacion" type="text" class="cajaPequena" id="autorizacion" value="<?php  echo mysql_result($res_ret,0,"autorizacion")?>" readonly>
                                                    </td>
                                                </tr>                                               
						<tr>
                                                    <td width="10%">Proveedor</td>
                                                    <td width="27%"><input NAME="empresa" type="text" class="cajaGrande" id="empresa" value="<?php  echo mysql_result($res_prov,0,"empresa");?>" readonly></td>
                                                    <td width="12%">CI/RUC</td>
                                                    <td  colspan="2"><input NAME="ci_ruc" type="text" class="cajaMedia" id="ci_ruc"  value="<?php  echo mysql_result($res_prov,0,"ci_ruc");?>" readonly></td>
						</tr>
                                                <tr>
                                                    <td width="10%">Direcci&oacute;n</td>
						    <td width="27%"><input NAME="direccion" type="text" class="cajaGrande" id="direccion" value="<?php  echo mysql_result($res_prov,0,"direccion");?>" readonly></td>
                                                    <td width="12%">Telf.:</td>
                                                    <td  colspan="1"><input NAME="telefono" type="text" class="cajaMedia" id="telefono" value="<?php  echo mysql_result($res_fono,0,"numero");?>" readonly></td>
                                                    <td width="12%" align="center">No. Comprobante</td>
						</tr>
						
						<tr>
                                                    <td width="10%">Fecha</td>
						    <td width="27%"><input NAME="fecha" type="text" class="cajaPequena" id="fecha" size="10" maxlength="10" value="<?php   echo implota(mysql_result($res_ret,0,"fecha"))?>" readonly></td>
                                                    
                                                    <td width="12%">Tipo Comprobante</td>
                                                    <?php  
                                                        $tipocomprob= mysql_result($res_prov,0,"tipocomprobante");
                                                        switch ($tipocomprob)
                                                        {
                                                            // 1 FACTURA
                                                            case 1:
                                                                    $comprobante="FACTURA";
                                                                    break;
                                                            // 2 LIQUIDACIONES DE COMPRA
                                                            case 2:
                                                                    $comprobante="LIQUIDACIONES DE COMPRA";
                                                                    break;
                                                            // 3 NOTA DE VENTA
                                                            case 3:
                                                                    $comprobante="NOTA DE VENTA";
                                                                    break;
                                                        }
                                                    ?>
                                                    <td ><input NAME="tipo_comprobante" type="text" class="cajaMedia" id="tipo_comprobante" value="<?php  echo $comprobante;?>" readonly></td>

                                                    
                                                    <td><input style="text-align: center" NAME="numero_comprobante" type="text" class="cajaGrande" id="numero_comprobante" value="<?php  echo mysql_result($res_prov,0,"serie1")." - ".mysql_result($res_prov,0,"serie2")."  # ".mysql_result($res_prov,0,"codigo_factura")?>" readonly></td>
                                                        
                                                </tr>
                                                <tr>
                                                    <td>Concepto</td>
                                                    <td colspan="5"><textarea name="concepto" cols="96" rows="2" id="concepto" class="areaTexto"><?php  echo mysql_result($res_ret,0,"concepto")?></textarea> </td>
                                                </tr>
					</table>										
			  </div>
			 
                         

                                    <br>
			  <div id="frmBusqueda">			
				
                                    <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=1>
                                        <tr class="cabeceraTabla">
                                            <td width="15%">EJERCICIO FISCAL</td>
                                            <td width="15%">BASE IMPONIBLE</td>
                                            <td width="15%">IMPUESTO</td>
                                            <td width="10%">COD IMPUESTO</td>
                                            <td width="10%">% RETENCION</td>
                                            <td width="10%">VALOR RETENIDO</td>
                                            <td width="4%"></td>
                                        </tr>

                                         <?php  
                                                $sel_lineas="SELECT rt.ejercicio_fiscal as ejercicio_fiscal, rt.base_imponible as base_imponible, rt.impuesto as impuesto,
                                                            rt.codigo_impuesto as codigo_impuesto, rt.porcentaje_retencion as porcentaje_retencion,
                                                            rt.valor_retenido as valor_retenido
                                                            FROM retenlinea rt  WHERE rt.id_retencion = '$idretencion'";
                                                $rs_lineas=mysql_query($sel_lineas,$conn);
                                                $num_registros=mysql_num_rows($rs_lineas);
                                                
                                                $year=date ("Y");
                                                
                                                if(mysql_result($rs_lineas,0,"base_imponible"))
                                                {
                                                    $ejercicio_fiscal1=mysql_result($rs_lineas,0,"ejercicio_fiscal");
                                                    $base_imponible1=mysql_result($rs_lineas,0,"base_imponible");
                                                    $impuesto1=mysql_result($rs_lineas,0,"impuesto");
                                                    $codigo_impuesto1=mysql_result($rs_lineas,0,"codigo_impuesto");
                                                    $porcentaje_retencion1=mysql_result($rs_lineas,0,"porcentaje_retencion");
                                                    $valor_retenido1=mysql_result($rs_lineas,0,"valor_retenido");
                                                }
                                                else
                                                {
                                                    $ejercicio_fiscal1=$year;
                                                    $base_imponible1=0;
                                                    $impuesto1="";
                                                    $codigo_impuesto1="";
                                                    $porcentaje_retencion1=0;
                                                    $valor_retenido1="";
                                                }
                                                
												if(mysql_result($rs_lineas,1,"base_imponible"))
                                                {
                                                    $ejercicio_fiscal2=mysql_result($rs_lineas,1,"ejercicio_fiscal");
                                                    $base_imponible2=mysql_result($rs_lineas,1,"base_imponible");
                                                    $impuesto2=mysql_result($rs_lineas,1,"impuesto");
                                                    $codigo_impuesto2=mysql_result($rs_lineas,1,"codigo_impuesto");
                                                    $porcentaje_retencion2=mysql_result($rs_lineas,1,"porcentaje_retencion");
                                                    $valor_retenido2=mysql_result($rs_lineas,1,"valor_retenido");
                                                }
                                                else
                                                {
                                                    $ejercicio_fiscal2=$year;
                                                    $base_imponible2=0;
                                                    $impuesto2="";
                                                    $codigo_impuesto2="";
                                                    $porcentaje_retencion2=0;
                                                    $valor_retenido2="";
                                                }

                                                if(mysql_result($rs_lineas,2,"base_imponible"))
                                                {
                                                    $ejercicio_fiscal3=mysql_result($rs_lineas,2,"ejercicio_fiscal");
                                                    $base_imponible3=mysql_result($rs_lineas,2,"base_imponible");
                                                    $impuesto3=mysql_result($rs_lineas,2,"impuesto");
                                                    $codigo_impuesto3=mysql_result($rs_lineas,2,"codigo_impuesto");
                                                    $porcentaje_retencion3=mysql_result($rs_lineas,2,"porcentaje_retencion");
                                                    $valor_retenido3=mysql_result($rs_lineas,2,"valor_retenido");
                                                }
                                                else
                                                {
                                                    $ejercicio_fiscal3=$year;
                                                    $base_imponible3=0;
                                                    $impuesto3="";
                                                    $codigo_impuesto3="";
                                                    $porcentaje_retencion3=0;
                                                    $valor_retenido3="";
                                                }

                                                if(mysql_result($rs_lineas,3,"base_imponible"))
                                                {
                                                    $ejercicio_fiscal4=mysql_result($rs_lineas,3,"ejercicio_fiscal");
                                                    $base_imponible4=mysql_result($rs_lineas,3,"base_imponible");
                                                    $impuesto4=mysql_result($rs_lineas,3,"impuesto");
                                                    $codigo_impuesto4=mysql_result($rs_lineas,3,"codigo_impuesto");
                                                    $porcentaje_retencion4=mysql_result($rs_lineas,3,"porcentaje_retencion");
                                                    $valor_retenido4=mysql_result($rs_lineas,3,"valor_retenido");
                                                }
                                                else
                                                {
                                                    $ejercicio_fiscal4=$year;
                                                    $base_imponible4=0;
                                                    $impuesto4="";
                                                    $codigo_impuesto4="";
                                                    $porcentaje_retencion4=0;
                                                    $valor_retenido4="";
                                                }

                                                if(mysql_result($rs_lineas,4,"base_imponible"))
                                                {
                                                    $ejercicio_fiscal5=mysql_result($rs_lineas,4,"ejercicio_fiscal");
                                                    $base_imponible5=mysql_result($rs_lineas,4,"base_imponible");
                                                    $impuesto5=mysql_result($rs_lineas,4,"impuesto");
                                                    $codigo_impuesto5=mysql_result($rs_lineas,4,"codigo_impuesto");
                                                    $porcentaje_retencion5=mysql_result($rs_lineas,4,"porcentaje_retencion");
                                                    $valor_retenido5=mysql_result($rs_lineas,4,"valor_retenido");
                                                }
                                                else
                                                {
                                                    $ejercicio_fiscal5=$year;
                                                    $base_imponible5=0;
                                                    $impuesto5="";
                                                    $codigo_impuesto5="";
                                                    $porcentaje_retencion5=0;
                                                    $valor_retenido5="";
                                                }

                                        ?>

                                        <!--************************************************************************************************ -->
                                        <!--INICIO ITEM No. 1 de la retencion----------------------------------------------------------------- -->

                                        <tr class="itemImparTabla">
                                            <td width="15%"><input NAME="ejercicio1" id="ejercicio1" type="text" class="cajaMedia" value="<?php  echo $ejercicio_fiscal1?>"></td>
                                            <td width="15%"><input NAME="base1" id="base1" type="text" class="cajaMedia" value="<?php  echo $base_imponible1?>" onchange="calcular_porc(1)"></td>
                                            <td width="15%">
                                                <select style="background: #dddddd" name="impuesto1" id="impuesto1" class="comboGrande" onchange="activar_codigo(1,this.selectedIndex)">
                                                    
													<option value="0"></option>
													<?php  
														$contador = 0;
														while ($contador<mysql_num_rows($res_reten))
														{	
															if(mysql_result($res_reten,$contador,"codigo") == $codigo_impuesto1){
													?>
																<option selected value="<?php  echo mysql_result($res_reten,$contador,"codigo") ."*". mysql_result($res_reten,$contador,"porcentaje") ."*". mysql_result($res_reten,$contador,"tipo") ?>"><?php  echo mysql_result($res_reten,$contador,"nombre")?></option>
													<?php 
															}else{
													?>
																<option value="<?php  echo mysql_result($res_reten,$contador,"codigo") ."*". mysql_result($res_reten,$contador,"porcentaje") ."*". mysql_result($res_reten,$contador,"tipo") ?>"><?php  echo mysql_result($res_reten,$contador,"nombre")?></option>
													<?php 
															}
															$contador++;
														}
													?>																																								                                                    
                                                </select>                                                
                                            </td>
                                            <td width="10%" align="center"><input NAME="codigoimpuesto1" id="codigoimpuesto1" type="text" class="cajaPequena2" value="<?php  echo $codigo_impuesto1 ?>" readonly ></td>
                                            <td width="10%" align="center"><input NAME="porcretencion1" id="porcretencion1" type="text" class="cajaPequena2" value="<?php  echo $porcentaje_retencion1?>" readonly></td>
                                            <td width="10%" align="center"><input NAME="valorretenido1" id="valorretenido1" type="text" class="cajaPequena2" value="<?php  echo $valor_retenido1 ?>" readonly></td>
                                            <td width="4%" align="center"><img src="../img/eliminar.png" width="16" height="16" onClick="limpiar_retencion(1)" onMouseOver="style.cursor=cursor" title="Eliminar"> </td>
                                        </tr>
                                        <!--FIN ITEM No. 1 de la retencion-------------------------------------------------------------------- -->
                                        <!--************************************************************************************************ -->

                                        <!--************************************************************************************************ -->
                                        <!--INICIO ITEM No. 2 de la retencion----------------------------------------------------------------- -->
                                        <tr class="itemImparTabla">
                                            <td width="15%"><input NAME="ejercicio2" id="ejercicio2" type="text" class="cajaMedia" value="<?php  echo $ejercicio_fiscal2?>"></td>
                                            <td width="15%"><input NAME="base2" id="base2" type="text" class="cajaMedia" value="<?php  echo $base_imponible2?>" onchange="calcular_porc(2)"></td>
                                            <td width="15%">
                                                <select style="background: #dddddd" name="impuesto2" id="impuesto2" class="comboGrande" onchange="activar_codigo(2,this.selectedIndex)">
                                                    <option value="0"></option>
													<?php  
														$contador = 0;
														while ($contador<mysql_num_rows($res_reten))
														{	
															if(mysql_result($res_reten,$contador,"codigo") == $codigo_impuesto2){
													?>
																<option selected value="<?php  echo mysql_result($res_reten,$contador,"codigo") ."*". mysql_result($res_reten,$contador,"porcentaje") ."*". mysql_result($res_reten,$contador,"tipo") ?>"><?php  echo mysql_result($res_reten,$contador,"nombre")?></option>
													<?php 
															}else{
													?>
																<option value="<?php  echo mysql_result($res_reten,$contador,"codigo") ."*". mysql_result($res_reten,$contador,"porcentaje") ."*". mysql_result($res_reten,$contador,"tipo") ?>"><?php  echo mysql_result($res_reten,$contador,"nombre")?></option>
													<?php 
															}
															$contador++;
														}
													?>
                                                </select>
                                            </td>
                                            <td width="10%" align="center"><input NAME="codigoimpuesto2" id="codigoimpuesto2" type="text" class="cajaPequena2" value="<?php  echo $codigo_impuesto2?>" readonly></td>
                                            <td width="10%" align="center"><input NAME="porcretencion2" id="porcretencion2" type="text" class="cajaPequena2" value="<?php  echo $porcentaje_retencion2?>" onchange="calcular_porc(2)"></td>
                                            <td width="10%" align="center"><input NAME="valorretenido2" id="valorretenido2" type="text" class="cajaPequena2" value="<?php  echo $valor_retenido2?>" readonly></td>
                                            <td width="4%" align="center"><img src="../img/eliminar.png" width="16" height="16" onClick="limpiar_retencion(2)" onMouseOver="style.cursor=cursor" title="Eliminar"> </td>
                                        </tr>


                                        <!--FIN ITEM No. 2 de la retencion-------------------------------------------------------------------- -->
                                        <!--************************************************************************************************ -->

                                        <!--************************************************************************************************ -->
                                        <!--INICIO ITEM No. 3 de la retencion----------------------------------------------------------------- -->
                                        <tr class="itemImparTabla">
                                            <td width="15%"><input NAME="ejercicio3" id="ejercicio3" type="text" class="cajaMedia" value="<?php  echo $ejercicio_fiscal3?>"></td>
                                            <td width="15%"><input NAME="base3" id="base3" type="text" class="cajaMedia" value="<?php  echo $base_imponible3?>" onchange="calcular_porc(3)"></td>
                                            <td width="15%">
                                                <select style="background: #dddddd" name="impuesto3" id="impuesto3" class="comboGrande" onchange="activar_codigo(3,this.selectedIndex)">
                                                    <option value="0"></option>
													<?php  
														$contador = 0;
														while ($contador<mysql_num_rows($res_reten))
														{	
															if(mysql_result($res_reten,$contador,"codigo") == $codigo_impuesto3){
													?>
																<option selected value="<?php  echo mysql_result($res_reten,$contador,"codigo") ."*". mysql_result($res_reten,$contador,"porcentaje") ."*". mysql_result($res_reten,$contador,"tipo") ?>"><?php  echo mysql_result($res_reten,$contador,"nombre")?></option>
													<?php 
															}else{
													?>
																<option value="<?php  echo mysql_result($res_reten,$contador,"codigo") ."*". mysql_result($res_reten,$contador,"porcentaje") ."*". mysql_result($res_reten,$contador,"tipo") ?>"><?php  echo mysql_result($res_reten,$contador,"nombre")?></option>
													<?php 
															}
															$contador++;
														}
													?>
                                                </select>
                                            </td>
                                            <td width="10%" align="center"><input NAME="codigoimpuesto3" id="codigoimpuesto3" type="text" class="cajaPequena2" value="<?php  echo $codigo_impuesto3?>" readonly></td>
                                            <td width="10%" align="center"><input NAME="porcretencion3" id="porcretencion3" type="text" class="cajaPequena2" value="<?php  echo $porcentaje_retencion3?>" onchange="calcular_porc(3)"></td>
                                            <td width="10%" align="center"><input NAME="valorretenido3" id="valorretenido3" type="text" class="cajaPequena2" value="<?php  echo $valor_retenido3?>" readonly></td>
                                            <td width="4%" align="center"><img src="../img/eliminar.png" width="16" height="16" onClick="limpiar_retencion(3)" onMouseOver="style.cursor=cursor" title="Eliminar"> </td>
                                        </tr>

                                        <!--FIN ITEM No. 3 de la retencion-------------------------------------------------------------------- -->
                                        <!--************************************************************************************************ -->
                                       
                                        
                                        <!--************************************************************************************************ -->
                                        <!--INICIO ITEM No. 4 de la retencion----------------------------------------------------------------- -->
                                         <tr class="itemImparTabla">
                                            <td width="15%"><input NAME="ejercicio4" id="ejercicio4" type="text" class="cajaMedia" value="<?php  echo $ejercicio_fiscal4?>"></td>
                                            <td width="15%"><input NAME="base4" id="base4" type="text" class="cajaMedia" value="<?php  echo $base_imponible4?>" onchange="calcular_porc(4)"></td>
                                            <td width="15%">
                                                <select style="background: #ffffff" name="impuesto4" id="impuesto4" class="comboGrande" onchange="activar_codigo(4,this.selectedIndex)">
                                                    <option value="0"></option>
													<?php  
														$contador = 0;
														while ($contador<mysql_num_rows($res_reten))
														{	
															if(mysql_result($res_reten,$contador,"codigo") == $codigo_impuesto4){
													?>
																<option selected value="<?php  echo mysql_result($res_reten,$contador,"codigo") ."*". mysql_result($res_reten,$contador,"porcentaje") ."*". mysql_result($res_reten,$contador,"tipo") ?>"><?php  echo mysql_result($res_reten,$contador,"nombre")?></option>
													<?php 
															}else{
													?>
																<option value="<?php  echo mysql_result($res_reten,$contador,"codigo") ."*". mysql_result($res_reten,$contador,"porcentaje") ."*". mysql_result($res_reten,$contador,"tipo") ?>"><?php  echo mysql_result($res_reten,$contador,"nombre")?></option>
													<?php 
															}
															$contador++;
														}
													?>
                                                </select>
                                            </td>
                                            <td width="10%" align="center"><input NAME="codigoimpuesto4" id="codigoimpuesto4" type="text" class="cajaPequena2" value="<?php  echo $codigo_impuesto4?>" readonly></td>
                                            <td width="10%" align="center"><input NAME="porcretencion4" id="porcretencion4" type="text" class="cajaPequena2"  value="<?php  echo $porcentaje_retencion4?>" onchange="calcular_porc(4)"></td>
                                            <td width="10%" align="center"><input NAME="valorretenido4" id="valorretenido4" type="text" class="cajaPequena2" value="<?php  echo $valor_retenido4?>" readonly></td>
                                            <td width="4%" align="center"><img src="../img/eliminar.png" width="16" height="16" onClick="limpiar_retencion(4)" onMouseOver="style.cursor=cursor" title="Eliminar"> </td>
                                         </tr>
                                        <!--FIN ITEM No. 4 de la retencion-------------------------------------------------------------------- -->
                                        <!--************************************************************************************************ -->


                                        <!--************************************************************************************************ -->
                                        <!--INICIO ITEM No. 5 de la retencion----------------------------------------------------------------- -->
                                         <tr class="itemImparTabla">
                                            <td width="15%"><input NAME="ejercicio5" id="ejercicio5" type="text" class="cajaMedia" value="<?php  echo $ejercicio_fiscal5?>"></td>
                                            <td width="15%"><input NAME="base5" id="base5" type="text" class="cajaMedia" value="<?php  echo $base_imponible5?>" onchange="calcular_porc(5)"></td>
                                            <td width="15%">
                                                <select style="background: #ffffff" name="impuesto5" id="impuesto5" class="comboGrande" onchange="activar_codigo(5,this.selectedIndex)">
                                                    <option value="0"></option>
													<?php  
														$contador = 0;
														while ($contador<mysql_num_rows($res_reten))
														{	
															if(mysql_result($res_reten,$contador,"codigo") == $codigo_impuesto5){
													?>
																<option selected value="<?php  echo mysql_result($res_reten,$contador,"codigo") ."*". mysql_result($res_reten,$contador,"porcentaje") ."*". mysql_result($res_reten,$contador,"tipo") ?>"><?php  echo mysql_result($res_reten,$contador,"nombre")?></option>
													<?php 
															}else{
													?>
																<option value="<?php  echo mysql_result($res_reten,$contador,"codigo") ."*". mysql_result($res_reten,$contador,"porcentaje") ."*". mysql_result($res_reten,$contador,"tipo") ?>"><?php  echo mysql_result($res_reten,$contador,"nombre")?></option>
													<?php 
															}
															$contador++;
														}
													?>
                                                </select>
                                            </td>
                                            <td width="10%" align="center"><input NAME="codigoimpuesto5" id="codigoimpuesto5" type="text" class="cajaPequena2" value="<?php  echo $codigo_impuesto5?>" readonly></td>
                                            <td width="10%" align="center"><input NAME="porcretencion5" id="porcretencion5" type="text" class="cajaPequena2" value="<?php  echo $porcentaje_retencion5?>" onchange="calcular_porc(5)"></td>
                                            <td width="10%" align="center"><input NAME="valorretenido5" id="valorretenido5" type="text" class="cajaPequena2" value="<?php  echo $valor_retenido5?>" readonly></td>
                                            <td width="4%" align="center"><img src="../img/eliminar.png" width="16" height="16" onClick="limpiar_retencion(5)" onMouseOver="style.cursor=cursor" title="Eliminar"> </td>
                                         </tr>
                                        <!--FIN ITEM No. 5 de la retencion-------------------------------------------------------------------- -->
                                        <!--************************************************************************************************ -->


                                       
                                    </table>
                               <br/>

                          </div>
                                
			  <div id="frmBusqueda">
                                <table width="35%" border=0 align="right" cellpadding=3 cellspacing=0 class="fuente8">

                                                  <tr>
                                                      <td class="busqueda" align="right">Total Retenci&oacute;n</td>
                                                        <td align="right"><div align="center">
                                                      <input class="cajaTotales" name="totalretencion" type="text" id="totalretencion" size="12" align="right" value="<?php  echo number_format(mysql_result($res_ret,0,"totalretencion"),2)?>" readonly>
                                                &#36;</div></td>
                                                  </tr>

                                        </table>
                          </div>
                                <table width="50%" border=0 align="right" cellpadding=3 cellspacing=0 class="fuente8">
                                    <tr>
                                        <td>
                                            <div id="botonBusqueda">
                                              <div align="center">
                                                <img src="../img/botonaceptar.jpg" width="85" height="22" onClick="validar()" border="1" onMouseOver="style.cursor=cursor">
                                                <img src="../img/botoncancelar.jpg" width="85" height="22" onClick="cancelar()" border="1" onMouseOver="style.cursor=cursor">                                                                                                 
                                            </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
			  		<!--<iframe id="frame_datos" name="frame_datos" width="0" height="0" frameborder="0">
					<ilayer width="0" height="0" id="frame_datos" name="frame_datos"></ilayer>
					</iframe>-->
                                <input id="idretencion" name="idretencion" value="<?php  echo $idretencion?>" type="hidden">
                                <input id="accion" name="accion" value="modificar" type="hidden">
			  </form>
			 </div>
		  </div>
		</div>
	</body>
</html>
