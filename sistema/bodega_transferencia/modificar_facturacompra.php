<?php   
include ("../js/fechas.php");
include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

error_reporting(0);

$idfactura=$_GET["idfactura"];
//$cadena_busqueda=$_GET["cadena_busqueda"];

$query="SELECT *, DATE_ADD(fecha,INTERVAL (plazo*30) DAY) as fecha_venc FROM facturasp WHERE id_facturap='$idfactura'";
$rs_query=mysql_query($query,$conn);


$codfactura=mysql_result($rs_query,0,"codigo_factura");
$serie1=mysql_result($rs_query,0,"serie1");
$serie2=mysql_result($rs_query,0,"serie2");
$autorizacion=mysql_result($rs_query,0,"autorizacion");
$idproveedor=mysql_result($rs_query,0,"id_proveedor");
$fecha=mysql_result($rs_query,0,"fecha");
$fecha_venc=mysql_result($rs_query,0,"fecha_venc");
$credito=mysql_result($rs_query,0,"credito");
$plazo=mysql_result($rs_query,0,"plazo");
$tipo_comprobante=mysql_result($rs_query,0,"tipocomprobante");
$retencion=mysql_result($rs_query,0,"retencion");
$cuenta=mysql_result($rs_query,0,"cuenta");

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
		<script language="javascript">
		var cursor;
		if (document.all) {
		// Está utilizando EXPLORER
		cursor='hand';
		} else {
		// Está utilizando MOZILLA/NETSCAPE
		cursor='pointer';
		}
		
		var miPopup
		function abreVentana(){
                    var codfactura = document.getElementById("codfactura").value;
                    var codfactura = document.getElementById("serie1").value;
                    var codfactura = document.getElementById("serie2").value;
                    var codfactura = document.getElementById("autorizacion").value;
                    if((codfactura=="")||(serie1=="")||(serie2=="")||(autorizacion==""))
                    {
                        alert ("Debe ingresar el No. y Autorizacion de la FACTURA");
                    }
                    else
                    {
			miPopup = window.open("ver_proveedores.php","miwin","width=880,height=650,scrollbars=yes");
			miPopup.focus();
                    }
		}
		
		function ventanaArticulos(){
//			var codigo=document.getElementById("codproveedor").value;
//			if (codigo=="") {
//				alert ("Debe seleccionar el proveedor");
//			} else {
				miPopup = window.open("ver_articulos.php","miwin","width=700,height=580,scrollbars=yes");
				miPopup.focus();
//			}
		}
		
		function validarcliente(){
			var codigo=document.getElementById("codproveedor").value;
			miPopup = window.open("comprobarcliente.php?codproveedor="+codigo,"frame_datos","width=700,height=80,scrollbars=yes");
		}	
		
		function cancelar() {
			location.href="index.php";
		}
		
		function limpiarcaja() {
                    document.getElementById("codproveedor").value="";
			document.getElementById("nombre").value="";
			document.getElementById("nif").value="";
		}
		
		function actualizar_importe()
                {
                        var precio=document.getElementById("precio").value;
                        var cantidad=document.getElementById("cantidad").value;
                        var descuento_porc=document.getElementById("descuento_porc").value;
                                                
                        var total=precio*cantidad;
                        var descuento = total * (descuento_porc/100);
                        
                        var originaldesc=parseFloat(descuento);
                        var resultdesc=Math.round(originaldesc*10000)/10000;
                        document.getElementById("descuento").value=resultdesc;
                        
                        
                        var original=parseFloat(total - descuento);
                        var result=Math.round(original*10000)/10000 ;
                        document.getElementById("importe").value=result;
                        suma_iva();
                }

                         var credit=0;

		function validar_cabecera()
			{
				var mensaje="";
                                if (document.getElementById("codfactura").value=="") mensaje+="  - No. Factura no ingresado\n";
                                if (document.getElementById("serie1").value=="") mensaje+="  - Datos No. Factura no ingresado\n";
                                if (document.getElementById("serie2").value=="") mensaje+="  - Datos No. Factura no ingresado\n";
                                if (document.getElementById("autorizacion").value=="") mensaje+="  - Autorizacion Factura no ingresado\n";
				if (document.getElementById("nombre").value=="") mensaje+="  - Cliente no ingresado\n";
				if (document.getElementById("fecha").value=="") mensaje+="  - Fecha\n";                                
                                //if (credit =="0") mensaje+="  - Credito no seleccionado\n";
                                if (document.getElementById("cbocredito").value=="2") mensaje+="  - Credito no seleccionado\n";
                                if(document.getElementById("cboretencion").value=="2") mensaje+="  - Retencion no seleccionado\n";


				if (mensaje!="") {
					alert("Atencion, se han detectado las siguientes incorrecciones:\n\n"+mensaje);
				} else {
					document.getElementById("formulario").submit();
				}
			}	
		
		function validar() 
			{
				var mensaje="";
				var entero=0;
				var enteroo=0;
		
				if (document.getElementById("codarticulo").value=="") mensaje="  - Codigo Producto\n";
				if (document.getElementById("descripcion").value=="") mensaje+="  - Descripcion Producto\n";
				if(document.getElementById("cbobodega").value==0) mensaje+="  - Bodega\n";
				if (document.getElementById("precio").value=="") { 
							mensaje+="  - Falta el precio\n"; 
						} else {
							if (isNaN(document.getElementById("precio").value)==true) {
								mensaje+="  - El precio debe ser numerico\n";
							}
						}
				if (document.getElementById("cantidad").value=="") 
						{ 
						mensaje+="  - Falta la cantidad\n";
						} else {
							enteroo=parseInt(document.getElementById("cantidad").value);
							if (isNaN(enteroo)==true) {
								mensaje+="  - La cantidad debe ser numerica\n";
							} else {
									document.getElementById("cantidad").value=enteroo;
								}
						}
//				if (document.getElementById("descuento").value=="")
//						{
//						document.getElementById("descuento").value=0
//						} else {
//							entero=parseInt(document.getElementById("descuento").value);
//							if (isNaN(entero)==true) {
//								mensaje+="  - El descuento debe ser numerico\n";
//							} else {
//								document.getElementById("descuento").value=entero;
//							}
//						}
				if (document.getElementById("importe").value=="") mensaje+="  - Falta el importe\n";
				
				if (mensaje!="") {
					alert("Atencion, se han detectado las siguientes incorrecciones:\n\n"+mensaje);
				} else {
					document.getElementById("baseimponible").value=parseFloat(document.getElementById("baseimponible").value) + parseFloat(document.getElementById("importe").value) + parseFloat(document.getElementById("descuento").value);	
					var original1=parseFloat(document.getElementById("baseimponible").value);
                                        var result1=Math.round(original1*10000)/10000 ;
                                        document.getElementById("baseimponible").value=result1;

                                        actualizar_totales();
					document.getElementById("formulario_lineas").submit();
					document.getElementById("codarticulo").value="";
					document.getElementById("descripcion").value="";
					document.getElementById("precio").value="0";
					document.getElementById("cantidad").value=1;
					document.getElementById("importe").value="";
					document.getElementById("descuento_porc").value=0;
					document.getElementById("descuento").value=0;
                                        document.getElementById("iva").value="0";
				}
			}
			
		
                function actualizar_totales()
                {
                    document.getElementById("descuentototal").value=parseFloat(document.getElementById("descuentototal").value) + parseFloat(document.getElementById("descuento").value);                    
                    var original1=parseFloat(document.getElementById("descuentototal").value);
                    var result1=Math.round(original1*10000)/10000 ;
                    document.getElementById("descuentototal").value=result1;
                    document.getElementById("descuentototal2").value=result1;


                    document.getElementById("iva0").value=parseFloat(document.getElementById("iva0").value) + parseFloat(document.getElementById("iva02").value);
                    var original2=parseFloat(document.getElementById("iva0").value);
                    var result2=Math.round(original2*10000)/10000 ;
                    document.getElementById("iva0").value=result2;
                    document.getElementById("iva0final").value=result2;
                    document.getElementById("iva02").value=0;


                    document.getElementById("iva12").value=parseFloat(document.getElementById("iva12").value) + parseFloat(document.getElementById("iva122").value);
                    var original3=parseFloat(document.getElementById("iva12").value);
                    var result3=Math.round(original3*10000)/10000 ;
                    document.getElementById("iva12").value=result3;
                    document.getElementById("iva12final").value=result3;
                    document.getElementById("iva122").value=0;


                    document.getElementById("importeiva").value=parseFloat(document.getElementById("importeiva").value) + parseFloat(document.getElementById("iva").value);
                    var original4=parseFloat(document.getElementById("importeiva").value);
                    var result4=Math.round(original4*10000)/10000 ;
                    document.getElementById("importeiva").value=result4;
                    document.getElementById("importeiva2").value=result4;


                    var original5=parseFloat(document.getElementById("flete").value);
                    var result5=Math.round(original5*10000)/10000 ;
                    document.getElementById("flete2").value=result5;

                    var original6=parseFloat(document.getElementById("baseimponible").value);
                    var result6=Math.round(original6*10000)/10000 ;
                    document.getElementById("baseimponible2").value=result6;
                    

                    document.getElementById("preciototal").value= result6 - result1 + result4 + result5;
                    var original7=parseFloat(document.getElementById("preciototal").value);
                    var result7=Math.round(original7*100)/100 ;
                    document.getElementById("preciototal").value=result7;
                    document.getElementById("preciototal2").value=result7;
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
                        
                        if(result1==0)
                        {
                            document.getElementById("iva02").value=result; 
                        }
                        else
                        {
                            document.getElementById("iva122").value=result;   
                        }
			//var original2=parseFloat(result + result1);
			//var result2=Math.round(original2*100)/100 ;
			//document.getElementById("importe").value=result2;
                }




                function actualizar_descuento()
                {
                        var original=parseFloat(document.getElementById("importe").value);
			var result=Math.round(original*10000)/10000 ;

                        document.getElementById("descuento").value=parseFloat(result * parseFloat(document.getElementById("descuentoporc").value / 100));
                        var original1=parseFloat(document.getElementById("descuento").value);
			var result1=Math.round(original1*10000)/10000 ;
			document.getElementById("descuento").value=result1;
                        suma_iva();
                }


                function activar_plazo(indice)
                {
                   with (document.formulario)
                   {
                       value=cbocredito.options[indice].value ;
                     switch (value)
                      {
                          case "0":
                              credit=1;
                            cboplazo.selectedIndex=0;
                            cboplazo.disabled = true;
                            break;
                            case "2":
                             credit=0;
                            cboplazo.selectedIndex=0;
                            cboplazo.disabled = true;
                            break;
                          default:
                              credit=1;
                            cboplazo.disabled = false;
                            cboplazo.selectedIndex=1;
                            break;
                      }
                   }
                }

                function sumar_flete()
                {
                    var original=parseFloat(document.getElementById("flete").value);
                    if (isNaN(original)==true)
                    {

			alert("Atencion, el valor del Flete debe ser numerico");
                        document.getElementById("flete").value=0;
                        actualizar_totales();
                    } else
                    {
                             var result=Math.round(original*10000)/10000 ;
                             document.getElementById("flete").value=result;

                             actualizar_totales();
                    }


                }

                function restar_descuento()
                {
                    var original=parseFloat(document.getElementById("descuentototal").value);
                    if (isNaN(original)==true)
                    {

			alert("Atencion, el valor del Descuento debe ser numerico");
                        document.getElementById("descuentototal").value=0;
                        actualizar_totales();
                    } else
                    {
                             var result=Math.round(original*10000)/10000 ;
                             document.getElementById("descuentototal").value=result;

                             actualizar_totales();
                    }


                }

                function carga_articulos()
                {
                    document.getElementById("modif").value=1;
                    document.formulario_lineas.submit();

                    document.getElementById("modif").value=0;
                }
		</script>
	</head>
        <body onload="carga_articulos()">
		<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header">MODIFICAR FACTURA COMPRA</div>
				<div id="frmBusqueda">
				<form id="formulario" name="formulario" method="post" action="guardar_factura.php">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
                                                <tr>
                                                    <td width="6%">No. Factura</td>

                                                    <td>
                                                        <input NAME="serie1" type="text" class="cajaMinima" id="serie1" maxlength="3" value="<?php  echo $serie1?>">
                                                        <input NAME="serie2" type="text" class="cajaMinima" id="serie2" maxlength="3" value="<?php  echo $serie2?>">
                                                        <input NAME="codfactura" type="text" class="cajaMedia" id="codfactura" maxlength="16" value="<?php  echo $codfactura?>">

                                                    </td>
                                                    <td width="6%">Autorizaci&oacute;n</td>
                                                    <td colspan="2">
                                                        <input NAME="autorizacion" type="text" class="cajaPequena" id="autorizacion" maxlength="12" value="<?php  echo $autorizacion?>">
                                                    </td>


                                                </tr>

                                                <?php  
						 $sel_proveedor="SELECT * FROM proveedor WHERE id_proveedor='$idproveedor'";
						  $rs_proveedor=mysql_query($sel_proveedor,$conn);
                                                ?>


                                                <tr>
							<td width="6%">Proveedor</td>
                                                        <td width="35%"><input NAME="nombre" type="text" class="cajaGrande" id="nombre" size="45" maxlength="45" onClick="abreVentana()" readonly value="<?php   echo mysql_result($rs_proveedor,0,"empresa");?>">
                                                        <img src="../img/ver.png" width="16" height="16" onClick="abreVentana()" title="Buscar cliente" onMouseOver="style.cursor=cursor"></td>

                                                        <td width="3%">CI/RUC</td>
                                                    <td colspan="2"><input NAME="ci_ruc" type="text" class="cajaMedia" id="ci_ruc" size="20" maxlength="15" readonly value="<?php   echo mysql_result($rs_proveedor,0,"ci_ruc");?>"></td>
                                                       
                                                </tr>
						<tr>
                                                    <td width="6%">Cod. Proveedor</td>
                                                    <td ><input NAME="codproveedor" type="text" class="cajaPequena" id="codproveedor" size="6" maxlength="5" readonly value="<?php   echo mysql_result($rs_proveedor,0,"id_proveedor");?>" ></td>
                                                    <td width="6%">Tipo Comprobante</td>
                                                    <td>
                                                        <select name="cbotipocomprobante" id="cbotipocomprobante" class="comboMedio" >
                                                            <?php  
                                                                switch ($tipo_comprobante)
                                                                {
                                                                    case 1:
                                                            ?>
                                                                            <option value="1" selected>Factura</option>
                                                                            <option value="2">Liquidaciones de  Compra</option>
                                                                            <option value="3">Nota de Venta</option>
                                                            <?php  
                                                                        break;
                                                                    case 2:
                                                            ?>
                                                                            <option value="1">Factura</option>
                                                                            <option value="2" selected>Liquidaciones de  Compra</option>
                                                                            <option value="3" >Nota de Venta</option>
                                                            <?php  
                                                                        break;
                                                                    case 3:
                                                            ?>
                                                                            <option value="1">Factura</option>
                                                                            <option value="2" >Liquidaciones de  Compra</option>
                                                                            <option value="3" selected>Nota de Venta</option>
                                                            <?php  
                                                                        break;
                                                                }
                                                            ?>                                             
                                                        </select>
                                                    </td>
                                                    
                                                    <td>CUENTA:
                                                        <select name="cbocuenta" id="cbocuenta" class="comboMedio" >
                                                        <?php   
                                                            $query_cuenta="SELECT id_cuenta, nombre FROM cuenta WHERE gasto=0";
                                                            $sel_query=mysql_query($query_cuenta, $conn);
                                                            while ($row = mysql_fetch_array($sel_query)) {
                                                                if($row['id_cuenta']==$cuenta)
                                                                {
                                                        ?>
                                                                    <option selected value="<?php   echo $row['id_cuenta']?>"><?php   echo $row['nombre']?></option>
                                                          <?php   } else {?>
                                                                    <option value="<?php   echo $row['id_cuenta']?>"><?php   echo $row['nombre']?></option>
                                                              <?php   }?>
                                                        <?php   }?>
                                                        </select>                                                    
                                                    </td>
                                                    
                                                    
                                                    
						</tr>
						
						<tr>
                                                    <td width="6%">Fecha</td>
                                                    <td width="27%" >
                                                        <input NAME="fecha" type="text" class="cajaPequena" id="fecha" size="10" maxlength="10" value="<?php   echo implota($fecha)?>" readonly> <img src="../img/calendario.png" name="Image1" id="Image1" width="16" height="16" border="0" id="Image1" onMouseOver="this.style.cursor='pointer'">
                                                    <script type="text/javascript">
                                                                                    Calendar.setup(
                                                                                      {
                                                                                    inputField : "fecha",
                                                                                    ifFormat   : "%d/%m/%Y",
                                                                                    button     : "Image1"
                                                                                      }
                                                                                    );
                                                    </script></td>
                                                    
                                                    
                                                    <td width="6%">CREDITO</td>
                                                        <td>
                                                            <select name="cbocredito" id="cbocredito" class="comboPequeno" onchange="activar_plazo(this.selectedIndex)">
                                                                <?php  
                                                                    if ($credito==1)
                                                                    {
                                                                ?>
                                                                        <option value="0">No</option>
                                                                        <option value="1" selected>Si</option>

                                                                <?php  
                                                                    }
                                                                    else
                                                                    {
                                                                ?>
                                                                        <option value="0" selected>No</option>
                                                                        <option value="1">Si</option>
                                                                <?php  
                                                                    }
                                                                ?>
                                                            </select>

                                                            <select name="cboplazo" id="cboplazo" class="comboPequeno" disabled="true">
                                                                <?php  
                                                                    switch ($plazo)
                                                                    {
                                                                        case 0:
                                                                ?>
                                                                                <option value="0" selected>0 d&iacute;as</option>
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
                                                                 <?php  
                                                                                break;
                                                                        case 1:
                                                                 ?>
                                                                                <option value="0">0 d&iacute;as</option>
                                                                                <option value="1" selected>30 d&iacute;as</option>
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
                                                                 <?php  
                                                                                break;
                                                                        case 2:
                                                                 ?>
                                                                                <option value="0">0 d&iacute;as</option>
                                                                                <option value="1">30 d&iacute;as</option>
                                                                                <option value="2" selected>60 d&iacute;as</option>
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
                                                                 <?php  
                                                                                break;
                                                                        case 3:
                                                                 ?>
                                                                                <option value="0">0 d&iacute;as</option>
                                                                                <option value="1">30 d&iacute;as</option>
                                                                                <option value="2">60 d&iacute;as</option>
                                                                                <option value="3" selected>90 d&iacute;as</option>
                                                                                <option value="4">120 d&iacute;as</option>
                                                                                <option value="5">150 d&iacute;as</option>
                                                                                <option value="6">180 d&iacute;as</option>
                                                                                <option value="7">210 d&iacute;as</option>
                                                                                <option value="8">240 d&iacute;as</option>
                                                                                <option value="9">270 d&iacute;as</option>
                                                                                <option value="10">300 d&iacute;as</option>
                                                                                <option value="11">330 d&iacute;as</option>
                                                                                <option value="12">360 d&iacute;as</option>
                                                                 <?php  
                                                                                break;
                                                                        case 4:
                                                                 ?>
                                                                                <option value="0">0 d&iacute;as</option>
                                                                                <option value="1">30 d&iacute;as</option>
                                                                                <option value="2">60 d&iacute;as</option>
                                                                                <option value="3">90 d&iacute;as</option>
                                                                                <option value="4" selected>120 d&iacute;as</option>
                                                                                <option value="5">150 d&iacute;as</option>
                                                                                <option value="6">180 d&iacute;as</option>
                                                                                <option value="7">210 d&iacute;as</option>
                                                                                <option value="8">240 d&iacute;as</option>
                                                                                <option value="9">270 d&iacute;as</option>
                                                                                <option value="10">300 d&iacute;as</option>
                                                                                <option value="11">330 d&iacute;as</option>
                                                                                <option value="12">360 d&iacute;as</option>
                                                                 <?php  
                                                                                break;
                                                                        case 5:
                                                                 ?>
                                                                                <option value="0">0 d&iacute;as</option>
                                                                                <option value="1">30 d&iacute;as</option>
                                                                                <option value="2">60 d&iacute;as</option>
                                                                                <option value="3">90 d&iacute;as</option>
                                                                                <option value="4">120 d&iacute;as</option>
                                                                                <option value="5" selected>150 d&iacute;as</option>
                                                                                <option value="6">180 d&iacute;as</option>
                                                                                <option value="7">210 d&iacute;as</option>
                                                                                <option value="8">240 d&iacute;as</option>
                                                                                <option value="9">270 d&iacute;as</option>
                                                                                <option value="10">300 d&iacute;as</option>
                                                                                <option value="11">330 d&iacute;as</option>
                                                                                <option value="12">360 d&iacute;as</option>
                                                                 <?php  
                                                                                break;
                                                                        case 6:
                                                                 ?>
                                                                                <option value="0">0 d&iacute;as</option>
                                                                                <option value="1">30 d&iacute;as</option>
                                                                                <option value="2">60 d&iacute;as</option>
                                                                                <option value="3">90 d&iacute;as</option>
                                                                                <option value="4">120 d&iacute;as</option>
                                                                                <option value="5">150 d&iacute;as</option>
                                                                                <option value="6" selected>180 d&iacute;as</option>
                                                                                <option value="7">210 d&iacute;as</option>
                                                                                <option value="8">240 d&iacute;as</option>
                                                                                <option value="9">270 d&iacute;as</option>
                                                                                <option value="10">300 d&iacute;as</option>
                                                                                <option value="11">330 d&iacute;as</option>
                                                                                <option value="12">360 d&iacute;as</option>
                                                                 <?php  
                                                                                break;
                                                                        case 7:
                                                                 ?>
                                                                                <option value="0">0 d&iacute;as</option>
                                                                                <option value="1">30 d&iacute;as</option>
                                                                                <option value="2">60 d&iacute;as</option>
                                                                                <option value="3">90 d&iacute;as</option>
                                                                                <option value="4">120 d&iacute;as</option>
                                                                                <option value="5">150 d&iacute;as</option>
                                                                                <option value="6">180 d&iacute;as</option>
                                                                                <option value="7">210 d&iacute;as</option>
                                                                                <option value="8" selected>240 d&iacute;as</option>
                                                                                <option value="9">270 d&iacute;as</option>
                                                                                <option value="10">300 d&iacute;as</option>
                                                                                <option value="11">330 d&iacute;as</option>
                                                                                <option value="12">360 d&iacute;as</option>
                                                                 <?php  
                                                                                break;
                                                                        case 8:
                                                                 ?>
                                                                                <option value="0">0 d&iacute;as</option>
                                                                                <option value="1">30 d&iacute;as</option>
                                                                                <option value="2">60 d&iacute;as</option>
                                                                                <option value="3">90 d&iacute;as</option>
                                                                                <option value="4">120 d&iacute;as</option>
                                                                                <option value="5">150 d&iacute;as</option>
                                                                                <option value="6">180 d&iacute;as</option>
                                                                                <option value="7">210 d&iacute;as</option>
                                                                                <option value="8" selected>240 d&iacute;as</option>
                                                                                <option value="9">270 d&iacute;as</option>
                                                                                <option value="10">300 d&iacute;as</option>
                                                                                <option value="11">330 d&iacute;as</option>
                                                                                <option value="12">360 d&iacute;as</option>
                                                                 <?php  
                                                                                break;
                                                                        case 9:
                                                                 ?>
                                                                                <option value="0">0 d&iacute;as</option>
                                                                                <option value="1">30 d&iacute;as</option>
                                                                                <option value="2">60 d&iacute;as</option>
                                                                                <option value="3">90 d&iacute;as</option>
                                                                                <option value="4">120 d&iacute;as</option>
                                                                                <option value="5">150 d&iacute;as</option>
                                                                                <option value="6">180 d&iacute;as</option>
                                                                                <option value="7">210 d&iacute;as</option>
                                                                                <option value="8">240 d&iacute;as</option>
                                                                                <option value="9" selected>270 d&iacute;as</option>
                                                                                <option value="10">300 d&iacute;as</option>
                                                                                <option value="11">330 d&iacute;as</option>
                                                                                <option value="12">360 d&iacute;as</option>
                                                                 <?php  
                                                                                break;
                                                                        case 10:
                                                                 ?>
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
                                                                                <option value="10" selected>300 d&iacute;as</option>
                                                                                <option value="11">330 d&iacute;as</option>
                                                                                <option value="12">360 d&iacute;as</option>
                                                                 <?php  
                                                                                break;
                                                                        case 11:
                                                                 ?>
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
                                                                                <option value="11" selected>330 d&iacute;as</option>
                                                                                <option value="12">360 d&iacute;as</option>
                                                                 <?php  
                                                                                break;
                                                                        case 12:
                                                                 ?>
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
                                                                                <option value="12" selected>360 d&iacute;as</option>
                                                                  <?php  
                                                                                break;
                                                                    }
                                                                  ?>
                                                            </select>

                                                        </td>

                                                        <td>SUJETA A RETENCION:
                                                            <select name="cboretencion" id="cboretencion" class="comboPequeno">
                                                                <?php  
                                                                    if ($retencion==1)
                                                                    {
                                                                ?>
                                                                        <option value="0">No</option>
                                                                        <option value="1" selected>Si</option>
                                                                        
                                                                <?php  
                                                                    }
                                                                    else
                                                                    {
                                                                ?>
                                                                        <option value="0" selected>No</option>
                                                                        <option value="1">Si</option>
                                                                        
                                                                <?php  
                                                                    }
                                                                ?>
                                                            </select>
                                                        </td>
                                                        
                                                        


						</tr>
					</table>										
			  </div>
			  <!--<input id="codfacturatmp" name="codfacturatmp" value="<?php   echo $codfacturatmp?>" type="hidden">
			  <input id="baseimpuestos2" name="baseimpuestos2" value="<?php   echo $baseimpuestos?>" type="hidden">
			  <input id="baseimponible2" name="baseimponible2" value="<?php   echo $baseimponible?>" type="hidden">
			  <input id="preciototal2" name="preciototal2" value="<?php   echo $preciototal?>" type="hidden">
                          <input id="baseretencion2" name="baseretencion2" value="<?php  echo $baseretencion?>" type="hidden">-->
                         <input id="idfactura" name="idfactura" value="<?php   echo $idfactura?>" type="hidden">
                          <input id="iva02" name="iva02" type="hidden" >
                          <input id="iva122" name="iva122" value="0" type="hidden">
                          <input id="iva0final" name="iva0final" value="<?php  echo $iva0?>" type="hidden">
                          <input id="iva12final" name="iva12final" value="<?php  echo $iva12?>" type="hidden">
                          <input id="descuentototal2" name="descuentototal2" value="<?php  echo $descuento?>" type="hidden">
                          <input id="importeiva2" name="importeiva2" value="<?php  echo $importeiva?>" type="hidden">
			  <input id="baseimponible2" name="baseimponible2" value="<?php  echo $baseimponible?>" type="hidden">
                          <input id="flete2" name="flete2" value="<?php  echo $flete?>" type="hidden">
			  <input id="preciototal2" name="preciototal2" value="<?php  echo $totalfactura?>" type="hidden">
                          
			  <input id="accion" name="accion" value="modificar" type="hidden">
			  </form>
			  <br>
			  <div id="frmBusqueda">
				<form id="formulario_lineas" name="formulario_lineas" method="post" action="frame_lineas_final.php" target="frame_lineas">
				<div id="tituloForm" class="header">PRODUCTOS</div>
                                    <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
                                   
                                  <tr>
                                      <td colspan="6">
                                          <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
                                              <tr>
                                                <td >C&oacute;digo Producto</td>
                                                <td><input NAME="codarticulo" type="text" class="cajaMedia" id="codarticulo" size="15" maxlength="15" onClick="ventanaArticulos()" readonly> <img src="../img/ver.png" width="16" height="16" onClick="ventanaArticulos()" onMouseOver="style.cursor=cursor" title="Buscar articulos"></td>
                                                <td>Descripci&oacute;n</td>
                                                <td><input NAME="descripcion" type="text" class="cajaGrande" id="descripcion" size="30" maxlength="30" readonly></td>
												<td>Bodega</td>
												<td>
												
													<?php  
														
														$queryb = "SELECT b.id_bodega as idbodega, b.nombre as nombre FROM bodega b ";
															   $resb = mysql_query($queryb, $conn);?>
													
														<select name="cbobodega" id="cbobodega" class="comboMedio" >
														<option value="0">Escoger</option>
														<?php 
														
																$contador=0;
																while ($contador < mysql_num_rows($resb))
																{
																	if(mysql_result($resb,$contador,"idbodega")==$bodega1)
																	{?>
																		<option selected value="<?php  echo mysql_result($resb,$contador,"idbodega")?>"><?php  echo mysql_result($resb,$contador,"nombre");?></option>
																	   


																	 <?php  } else {?>
																		<option  value="<?php  echo mysql_result($resb,$contador,"idbodega")?>"><?php  echo mysql_result($resb,$contador,"nombre");?></option>
																<?php  }$contador++;
																} ?>
														
										
										
														</select>
												
												
												</td>
                                              </tr>
                                          </table>
                                      </td>
				  </tr>
				  <tr>
                                        
                                      <td>
                                            Costo: <input NAME="precio" type="text" class="cajaPequena2" id="precio" size="10" maxlength="10" onChange="actualizar_importe()"  value="0"> 	&#36;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cantidad: <input NAME="cantidad" type="text" class="cajaMinima" id="cantidad" size="10" maxlength="10" value="1" onChange="actualizar_importe()"></td>
                                        <td>
                                            Dcto.: <input NAME="descuento_porc" type="text" class="cajaMinima" id="descuento_porc" size="10" maxlength="10" onChange="actualizar_importe()" value="0"> %
                                            <input NAME="descuento" type="text" class="cajaPequena2" id="descuento" size="10" maxlength="10" value="0" readonly="yes">
                                        </td>
                                        <td>Subtotal:</td>
                                        <td><input NAME="importe" type="text" class="cajaPequena2" id="importe" size="10" maxlength="10" value="0" readonly> 	&#36;</td>
					<td></td>
				  </tr>
                                  <tr>
                                      <td colspan="2">
                                          Pvp: &nbsp;&nbsp;&nbsp;<input NAME="pvp" type="text" class="cajaPequena2" id="pvp" size="10" maxlength="10"> &#36;
                                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Utilidad: <input NAME="utilidad" type="text" class="cajaMinima" id="utilidad" size="10" maxlength="10" value="0.00">%
                                      </td>
                                      <td>
                                          Iva
                                          <input NAME="ivaporc" type="text" class="cajaMinima" id="ivaporc" size="10" maxlength="10" onChange="suma_iva()" readonly>%
                                      </td>
                                      <td>                                            
                                            <input NAME="iva" type="text" class="cajaPequena2" id="iva" size="10" maxlength="10" value="0" readonly> 	&#36;
                                      </td>
                                      <td><img src="../img/botonagregar.jpg" width="72" height="22" border="1" onClick="validar()" onMouseOver="style.cursor=cursor" title="Agregar articulo"></td>
                                  </tr>                                                                       
				</table>
				</div>
				<input name="idarticulo" value="<?php   echo $idarticulo?>" type="hidden" id="idarticulo">
                               <!-- <input name="costo" value="<?php   //echo $costo?>" type="hidden" id="costo">-->
				<br>
				<div id="frmBusqueda">
				<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
						<tr class="cabeceraTabla">
							
							<td width="5%">CODIGO</td>
							<td width="41%">DESCRIPCION</td>
							<td width="8%">Bodega</td>
                                                        <td width="5%">CANT</td>
							<td width="8%">COSTO</td>
                                                        <td width="8%">DCTO.</td>
                                                        <td width="8%">SUBT.</td>
							<td width="8%">IVA</td>
							<td width="3%">&nbsp;</td>
                                                        <td width="3%">&nbsp;</td>
						</tr>
				</table>
				<div id="lineaResultado">
					<iframe width="100%" height="250" id="frame_lineas" name="frame_lineas" frameborder="0">
						<ilayer width="100%" height="250" id="frame_lineas" name="frame_lineas"></ilayer>
					</iframe>
				</div>					
			  </div>
			  <div id="frmBusqueda">
			<table width="25%" border=0 align="right" cellpadding=3 cellspacing=0 class="fuente8">
                                    <tr>
                                        <td width="27%" class="busqueda" align="right">Subtotal</td>
                                            <td width="73%" align="right"><div align="center">
                                                    <input class="cajaTotales" name="baseimponible" type="text" id="baseimponible" size="12" align="right" readonly value="<?php  echo $baseimponible?>">
                                    &#36;</div></td>
                                      </tr>

                                       <tr>
                                        <td width="27%" class="busqueda" align="right">Descuento</td>
                                            <td width="73%" align="right"><div align="center">
                                                    <input class="cajaTotales" name="descuentototal" type="text" id="descuentototal" size="12" align="right" onchange="restar_descuento()" value="<?php  echo $descuento?>">
                                    &#36;</div></td>
                                      </tr>

                                      <tr>
                                        <td width="27%" class="busqueda" align="right">IVA 0%</td>
                                            <td width="73%" align="right"><div align="center">
                                          <input class="cajaTotales" name="iva0" type="text" id="iva0" size="12" align="right" readonly value="<?php  echo $iva0?>">
                                    &#36;</div></td>
                                      </tr>


                                      <tr>
                                            <td class="busqueda" align="right">IVA 12%</td>
                                            <td align="right"><div align="center">
                                          <input class="cajaTotales" name="iva12" type="text" id="iva12" size="12" align="right" readonly value="<?php  echo $iva12?>">
                                    &#36;</div></td>
                                      </tr>

                                      <tr>
                                        <td width="27%" class="busqueda" align="right">Total IVA</td>
                                            <td width="73%" align="right"><div align="center">
                                          <input class="cajaTotales" name="importeiva" type="text" id="importeiva" size="12" align="right" readonly value="<?php  echo $importeiva?>">
                                    &#36;</div></td>
                                      </tr>
                                      <tr>
                                        <td width="27%" class="busqueda" align="right">Flete</td>
                                            <td width="73%" align="right"><div align="center">
                                                    <input class="cajaTotales" name="flete" type="text" id="flete" size="12" align="right" onchange="sumar_flete()" value="<?php  echo $flete?>">
                                    &#36;</div></td>
                                      </tr>



                                      <tr>
                                          <td class="busqueda" align="right">Precio Total </td>
                                            <td align="right"><div align="center">
                                          <input class="cajaTotales" name="preciototal" type="text" id="preciototal" size="12" align="right" readonly value="<?php  echo $totalfactura?>">
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
                                                
                                                    <input id="idfactura" name="idfactura" value="<?php   echo $idfactura?>" type="hidden">
                                                    <input id="modif" name="modif" value="0" type="hidden">
                                                    <input id="preciototal2" name="preciototal2" value="<?php   echo $totalfactura?>" type="hidden">
                                              </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
			  		<!--<iframe id="frame_datos" name="frame_datos" width="0" height="0" frameborder="0">
					<ilayer width="0" height="0" id="frame_datos" name="frame_datos"></ilayer>
					</iframe>-->
			  </form>
			 </div>
		  </div>
		</div>
	</body>
</html>