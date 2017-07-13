<?php 

include ("../js/fechas.php");
include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

error_reporting(0);

$accion=$_POST["accion"];
if (!isset($accion)) { $accion=$_GET["accion"]; }
if($accion!="baja")
{
    
    $codfactura=$_POST["codfactura"];
    $serie1=$_POST["serie1"];
    $serie2=$_POST["serie2"];
    $autorizacion=$_POST["autorizacion"];
    $idcliente=$_POST["codcliente"];
    $fecha=explota($_POST["fecha"]);
    $credito=$_POST["cbocredito"];
    $plazo=$_POST["cboplazo"];

    $tipocliente=$_POST["tipo_cliente"];
    $remision=$_POST["cboremision"];


    $baseimponible=$_POST["baseimponible"];
    $descuento=$_POST["descuentototal"];
    $iva0=$_POST["iva0"];
    $iva12=$_POST["iva12"];
    $importeiva=$_POST["importeiva"];
    $flete=$_POST["flete"];
    $totalfactura=$_POST["preciototal"];

    $array_productos=array();
    $cont_array=0;
     
    if(($_POST["codarticulo1"]!="")&&($_POST["descripcion1"]!="")&&($_POST["cantidad1"]>0))
    {
        $array_productos[$cont_array]["idarticulo"]=$_POST["idarticulo1"];
        $array_productos[$cont_array]["cantidad"]=$_POST["cantidad1"];
        $array_productos[$cont_array]["costo"]=$_POST["costo1"];
        $array_productos[$cont_array]["precio"]=$_POST["precio1"];
        $array_productos[$cont_array]["importe"]=$_POST["importe1"];
        $array_productos[$cont_array]["dcto"]=$_POST["descuento1"];
        $array_productos[$cont_array]["iva"]=$_POST["iva1"];
        $array_productos[$cont_array]["subt"]=$_POST["subt1"];
        
        if($accion=='modificar')
        {
            $array_productos[$cont_array]["idfactulinea"]=$_POST["idfactulinea1"];
        }
        
        $cont_array++;
    }
    else
    {
        if(($accion=='modificar')&&($_POST["idfactulinea1"]))
        {
            $array_productos[$cont_array]["idfactulinea"]=$_POST["idfactulinea1"];
            $cont_array++;
        }                
    }
    
    if(($_POST["codarticulo2"]!="")&&($_POST["descripcion2"]!="")&&($_POST["cantidad2"]>0))
    {
        $array_productos[$cont_array]["idarticulo"]=$_POST["idarticulo2"];
        $array_productos[$cont_array]["cantidad"]=$_POST["cantidad2"];
        $array_productos[$cont_array]["costo"]=$_POST["costo2"];
        $array_productos[$cont_array]["precio"]=$_POST["precio2"];
        $array_productos[$cont_array]["importe"]=$_POST["importe2"];
        $array_productos[$cont_array]["dcto"]=$_POST["descuento2"];
        $array_productos[$cont_array]["iva"]=$_POST["iva2"];
        $array_productos[$cont_array]["subt"]=$_POST["subt2"];
        
        if($accion=='modificar')
        {
            $array_productos[$cont_array]["idfactulinea"]=$_POST["idfactulinea2"];
        }
        
        $cont_array++;
    }
    else
    {
        if(($accion=='modificar')&&($_POST["idfactulinea2"]))
        {
            $array_productos[$cont_array]["idfactulinea"]=$_POST["idfactulinea2"];
            $cont_array++;
        }                
    }
    
    
    if(($_POST["codarticulo3"]!="")&&($_POST["descripcion3"]!="")&&($_POST["cantidad3"]>0))
    {
        $array_productos[$cont_array]["idarticulo"]=$_POST["idarticulo3"];
        $array_productos[$cont_array]["cantidad"]=$_POST["cantidad3"];
        $array_productos[$cont_array]["costo"]=$_POST["costo3"];
        $array_productos[$cont_array]["precio"]=$_POST["precio3"];
        $array_productos[$cont_array]["importe"]=$_POST["importe3"];
        $array_productos[$cont_array]["dcto"]=$_POST["descuento3"];
        $array_productos[$cont_array]["iva"]=$_POST["iva3"];
        $array_productos[$cont_array]["subt"]=$_POST["subt3"];
        
        if($accion=='modificar')
        {
            $array_productos[$cont_array]["idfactulinea"]=$_POST["idfactulinea3"];
        }
        
        $cont_array++;
    }
    else
    {
        if(($accion=='modificar')&&($_POST["idfactulinea3"]))
        {
            $array_productos[$cont_array]["idfactulinea"]=$_POST["idfactulinea3"];
            $cont_array++;
        }                
    }
    
    if(($_POST["codarticulo4"]!="")&&($_POST["descripcion4"]!="")&&($_POST["cantidad4"]>0))
    {
        $array_productos[$cont_array]["idarticulo"]=$_POST["idarticulo4"];
        $array_productos[$cont_array]["cantidad"]=$_POST["cantidad4"];
        $array_productos[$cont_array]["costo"]=$_POST["costo4"];
        $array_productos[$cont_array]["precio"]=$_POST["precio4"];
        $array_productos[$cont_array]["importe"]=$_POST["importe4"];
        $array_productos[$cont_array]["dcto"]=$_POST["descuento4"];
        $array_productos[$cont_array]["iva"]=$_POST["iva4"];
        $array_productos[$cont_array]["subt"]=$_POST["subt4"];
        
        if($accion=='modificar')
        {
            $array_productos[$cont_array]["idfactulinea"]=$_POST["idfactulinea4"];
        }
        
        $cont_array++;
    }
    else
    {
        if(($accion=='modificar')&&($_POST["idfactulinea4"]))
        {
            $array_productos[$cont_array]["idfactulinea"]=$_POST["idfactulinea4"];
            $cont_array++;
        }                
    }
    
    
    if(($_POST["codarticulo5"]!="")&&($_POST["descripcion5"]!="")&&($_POST["cantidad5"]>0))
    {
        $array_productos[$cont_array]["idarticulo"]=$_POST["idarticulo5"];
        $array_productos[$cont_array]["cantidad"]=$_POST["cantidad5"];
        $array_productos[$cont_array]["costo"]=$_POST["costo5"];
        $array_productos[$cont_array]["precio"]=$_POST["precio5"];
        $array_productos[$cont_array]["importe"]=$_POST["importe5"];
        $array_productos[$cont_array]["dcto"]=$_POST["descuento5"];
        $array_productos[$cont_array]["iva"]=$_POST["iva5"];
        $array_productos[$cont_array]["subt"]=$_POST["subt5"];
        
        if($accion=='modificar')
        {
            $array_productos[$cont_array]["idfactulinea"]=$_POST["idfactulinea5"];
        }
        
        $cont_array++;
    }
    else
    {
        if(($accion=='modificar')&&($_POST["idfactulinea5"]))
        {
            $array_productos[$cont_array]["idfactulinea"]=$_POST["idfactulinea5"];
            $cont_array++;
        }                
    }
    
    
    if(($_POST["codarticulo6"]!="")&&($_POST["descripcion6"]!="")&&($_POST["cantidad6"]>0))
    {
        $array_productos[$cont_array]["idarticulo"]=$_POST["idarticulo6"];
        $array_productos[$cont_array]["cantidad"]=$_POST["cantidad6"];
        $array_productos[$cont_array]["costo"]=$_POST["costo6"];
        $array_productos[$cont_array]["precio"]=$_POST["precio6"];
        $array_productos[$cont_array]["importe"]=$_POST["importe6"];
        $array_productos[$cont_array]["dcto"]=$_POST["descuento6"];
        $array_productos[$cont_array]["iva"]=$_POST["iva6"];
        $array_productos[$cont_array]["subt"]=$_POST["subt6"];
        
        if($accion=='modificar')
        {
            $array_productos[$cont_array]["idfactulinea"]=$_POST["idfactulinea6"];
        }
        
        $cont_array++;
    }
    else
    {
        if(($accion=='modificar')&&($_POST["idfactulinea6"]))
        {
            $array_productos[$cont_array]["idfactulinea"]=$_POST["idfactulinea6"];
            $cont_array++;
        }                
    }
    
    
    
    
    if(($_POST["codarticulo7"]!="")&&($_POST["descripcion7"]!="")&&($_POST["cantidad7"]>0))
    {
        $array_productos[$cont_array]["idarticulo"]=$_POST["idarticulo7"];
        $array_productos[$cont_array]["cantidad"]=$_POST["cantidad7"];
        $array_productos[$cont_array]["costo"]=$_POST["costo7"];
        $array_productos[$cont_array]["precio"]=$_POST["precio7"];
        $array_productos[$cont_array]["importe"]=$_POST["importe7"];
        $array_productos[$cont_array]["dcto"]=$_POST["descuento7"];
        $array_productos[$cont_array]["iva"]=$_POST["iva7"];
        $array_productos[$cont_array]["subt"]=$_POST["subt7"];
        
        if($accion=='modificar')
        {
            $array_productos[$cont_array]["idfactulinea"]=$_POST["idfactulinea7"];
        }
        
        $cont_array++;
    }
    else
    {
        if(($accion=='modificar')&&($_POST["idfactulinea7"]))
        {
            $array_productos[$cont_array]["idfactulinea"]=$_POST["idfactulinea7"];
            $cont_array++;
        }                
    }
        
    
    if(($_POST["codarticulo8"]!="")&&($_POST["descripcion8"]!="")&&($_POST["cantidad8"]>0))
    {
        $array_productos[$cont_array]["idarticulo"]=$_POST["idarticulo8"];
        $array_productos[$cont_array]["cantidad"]=$_POST["cantidad8"];
        $array_productos[$cont_array]["costo"]=$_POST["costo8"];
        $array_productos[$cont_array]["precio"]=$_POST["precio8"];
        $array_productos[$cont_array]["importe"]=$_POST["importe8"];
        $array_productos[$cont_array]["dcto"]=$_POST["descuento8"];
        $array_productos[$cont_array]["iva"]=$_POST["iva8"];
        $array_productos[$cont_array]["subt"]=$_POST["subt8"];
        
        if($accion=='modificar')
        {
            $array_productos[$cont_array]["idfactulinea"]=$_POST["idfactulinea8"];
        }
        
        $cont_array++;
    }
    else
    {
        if(($accion=='modificar')&&($_POST["idfactulinea8"]))
        {
            $array_productos[$cont_array]["idfactulinea"]=$_POST["idfactulinea8"];
            $cont_array++;
        }                
    }
    
    
    if(($_POST["codarticulo9"]!="")&&($_POST["descripcion9"]!="")&&($_POST["cantidad9"]>0))
    {
        $array_productos[$cont_array]["idarticulo"]=$_POST["idarticulo9"];
        $array_productos[$cont_array]["cantidad"]=$_POST["cantidad9"];
        $array_productos[$cont_array]["costo"]=$_POST["costo9"];
        $array_productos[$cont_array]["precio"]=$_POST["precio9"];
        $array_productos[$cont_array]["importe"]=$_POST["importe9"];
        $array_productos[$cont_array]["dcto"]=$_POST["descuento9"];
        $array_productos[$cont_array]["iva"]=$_POST["iva9"];
        $array_productos[$cont_array]["subt"]=$_POST["subt9"];
        
        if($accion=='modificar')
        {
            $array_productos[$cont_array]["idfactulinea"]=$_POST["idfactulinea9"];
        }
        
        $cont_array++;
    }
    else
    {
        if(($accion=='modificar')&&($_POST["idfactulinea9"]))
        {
            $array_productos[$cont_array]["idfactulinea"]=$_POST["idfactulinea9"];
            $cont_array++;
        }                
    }
    
    
    if(($_POST["codarticulo10"]!="")&&($_POST["descripcion10"]!="")&&($_POST["cantidad10"]>0))
    {
        $array_productos[$cont_array]["idarticulo"]=$_POST["idarticulo10"];
        $array_productos[$cont_array]["cantidad"]=$_POST["cantidad10"];
        $array_productos[$cont_array]["costo"]=$_POST["costo10"];
        $array_productos[$cont_array]["precio"]=$_POST["precio10"];
        $array_productos[$cont_array]["importe"]=$_POST["importe10"];
        $array_productos[$cont_array]["dcto"]=$_POST["descuento10"];
        $array_productos[$cont_array]["iva"]=$_POST["iva10"];
        $array_productos[$cont_array]["subt"]=$_POST["subt10"];
        
        if($accion=='modificar')
        {
            $array_productos[$cont_array]["idfactulinea"]=$_POST["idfactulinea10"];
        }
        
        $cont_array++;
    }
    else
    {
        if(($accion=='modificar')&&($_POST["idfactulinea10"]))
        {
            $array_productos[$cont_array]["idfactulinea"]=$_POST["idfactulinea10"];
            $cont_array++;
        }                
    }
    
    
    if(($_POST["codarticulo11"]!="")&&($_POST["descripcion11"]!="")&&($_POST["cantidad11"]>0))
    {
        $array_productos[$cont_array]["idarticulo"]=$_POST["idarticulo11"];
        $array_productos[$cont_array]["cantidad"]=$_POST["cantidad11"];
        $array_productos[$cont_array]["costo"]=$_POST["costo11"];
        $array_productos[$cont_array]["precio"]=$_POST["precio11"];
        $array_productos[$cont_array]["importe"]=$_POST["importe11"];
        $array_productos[$cont_array]["dcto"]=$_POST["descuento11"];
        $array_productos[$cont_array]["iva"]=$_POST["iva11"];
        $array_productos[$cont_array]["subt"]=$_POST["subt11"];
        
        if($accion=='modificar')
        {
            $array_productos[$cont_array]["idfactulinea"]=$_POST["idfactulinea11"];
        }
        
        $cont_array++;
    }  
    else
    {
        if(($accion=='modificar')&&($_POST["idfactulinea11"]))
        {
            $array_productos[$cont_array]["idfactulinea"]=$_POST["idfactulinea11"];
            $cont_array++;
        }                
    }
    
    
}


$minimo=0;

if ($accion=="alta") {


        include("class/facturas.php");
        $factura = new Factura();
        $idfactura=$factura->save_factura($conn, $idcliente, $codfactura, $serie1,$serie2,$autorizacion,$fecha, $descuento,$iva0, $iva12,$importeiva,$flete,$totalfactura, $credito, $plazo,$remision);


	if ($idfactura)
        {
            $mensaje_minimo="<ul>";
            $mensaje="La Proforma ha sido dada de alta correctamente";
            $validacion=0;


                $contador=0;
                //$baseimponible=0;
                include("class/factulinea.php");
                $factulinea= new Factulinea();


                while ($contador<$cont_array)
                {                   
 
                    $id_producto=$array_productos[$contador]["idarticulo"];
                    $cantidad=$array_productos[$contador]["cantidad"];
                    $costo=$array_productos[$contador]["costo"];
                    $precio=$array_productos[$contador]["precio"];
                    $subtotal=$array_productos[$contador]["importe"];
                    $dcto=$array_productos[$contador]["dcto"];
                    $iva=$array_productos[$contador]["iva"];
                    $iva=$array_productos[$contador]["iva"];
                    $subt=$array_productos[$contador]["subt"];
                    
                    $result=$factulinea->save_factulinea($conn,$idfactura, $id_producto, $cantidad, $costo, $precio, $dcto, $subtotal,$iva,$subt);

                    
                    


                    $sel_minimos = "SELECT stock,nombre FROM producto where id_producto='$id_producto'";
                    $rs_minimos= mysql_query($sel_minimos, $conn);
                    if (mysql_result($rs_minimos,0,"stock") <= 0)
                    {
                            $mensaje_minimo=$mensaje_minimo . " <li>" . mysql_result($rs_minimos,0,"nombre")." ---- STOCK = ". mysql_result($rs_minimos,0,"stock")."</li>";
                            $minimo=1;
                    };
                    $contador++;
                }
        }
         
        else
        {
            $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   El CODIGO ya existe, ERROR al ingresar la PROFORMA</span>";
            $validacion=1;
        }
             
	$cabecera1="Inicio >> Ventas &gt;&gt; Nueva Proforma ";
	$cabecera2="INSERTAR PROFORMA ";
}



if ($accion=="baja") {


	$idfactura=$_GET["idfactura"];
        include("class/facturas.php");
        $factura= new Factura();

        $result=$factura->delete_factura($conn,$idfactura);
        
        

	$query="SELECT * FROM proforlinea WHERE id_factura='$idfactura'";
	$rs_tmp=mysql_query($query,$conn);
	$contador=0;
	$baseimponible=0;
	while ($contador < mysql_num_rows($rs_tmp)) {

		$idproducto=mysql_result($rs_tmp,$contador,"id_producto");
		$cantidad=mysql_result($rs_tmp,$contador,"cantidad");
		
		$contador++;
	}
	if ($result) { $mensaje="La proforma ha sido anulada correctamente"; }
	$cabecera1="Inicio >> Ventas &gt;&gt; Anular Factura";
	$cabecera2="ANULAR PROFORMA";
	$query_mostrar="SELECT * FROM proformas WHERE id_factura='$idfactura'";
	$rs_mostrar=mysql_query($query_mostrar);

        $codfactura=mysql_result($rs_mostrar,0,"codigo_factura");
        $serie1=mysql_result($rs_mostrar,0,"serie1");
        $serie2=mysql_result($rs_mostrar,0,"serie2");
        $autorizacion=mysql_result($rs_mostrar,0,"autorizacion");
        $idcliente=mysql_result($rs_mostrar,0,"id_cliente");
        $fecha=mysql_result($rs_mostrar,0,"fecha");
        $credito=mysql_result($rs_mostrar,0,"credito");
        $plazo=mysql_result($rs_mostrar,0,"plazo");

       
        $descuento=mysql_result($rs_mostrar,0,"descuento");
        $iva0=mysql_result($rs_mostrar,0,"iva0");
        $iva12=mysql_result($rs_mostrar,0,"iva12");
        $importeiva=mysql_result($rs_mostrar,0,"iva");
        $flete=mysql_result($rs_mostrar,0,"flete");
        $totalfactura=mysql_result($rs_mostrar,0,"totalfactura");
        $baseimponible=$totalfactura-$flete-$importeiva+$descuento;
        
       
        $validacion=0;
}


if ($accion=="modificar") {

        $idfactura=$_POST["idfactura"];
        include("class/facturas.php");
        $factura = new Factura();
        $result=$factura->update_factura($conn, $idfactura, $idcliente, $codfactura,$serie1,$serie2,$autorizacion, $fecha, $descuento,$iva0, $iva12,$importeiva,$flete,$totalfactura, $remision);


	if ($result)
        {
            $mensaje_minimo="<ul>";
            $mensaje="La Proforma ha sido modificada correctamente";
            $validacion=0;


                $contador=0;
                //$baseimponible=0;
                include("class/factulinea.php");
                $factulinea= new Factulinea();


                while ($contador<$cont_array)
                {                   
 
                    $id_producto=$array_productos[$contador]["idarticulo"];
                    $cantidad=$array_productos[$contador]["cantidad"];
                    $costo=$array_productos[$contador]["costo"];
                    $precio=$array_productos[$contador]["precio"];
                    $subtotal=$array_productos[$contador]["importe"];
                    $dcto=$array_productos[$contador]["dcto"];
                    $iva=$array_productos[$contador]["iva"];
                    $iva=$array_productos[$contador]["iva"];
                    $subt=$array_productos[$contador]["subt"];
                    
                    if($array_productos[$contador]["idfactulinea"])
                    {
                        $idfactulinea=$array_productos[$contador]["idfactulinea"];
                        $query_cant="SELECT cantidad, id_producto FROM proforlinea WHERE id_factulinea='$idfactulinea'";
                        $res_cant=mysql_query($query_cant, $conn);
                        $cantidad_anterior=mysql_result($res_cant,0,"cantidad");
                        
                        if($cantidad_anterior != $cantidad)
                        {
                            $diferencia_cantidad = $cantidad - $cantidad_anterior;
                        }                                                
                        
                    }
                    
                    if(($array_productos[$contador]["idfactulinea"]) && ($array_productos[$contador]["idarticulo"]=="") && ($array_productos[$contador]["precio"]==""))
                    {
                        $id_producto=mysql_result($res_cant,0,"id_producto");
                        $diferencia_cantidad= $cantidad_anterior * (-1);
                        $query_delete="DELETE FROM proforlinea WHERE id_factulinea='$idfactulinea'";
                        $res_delete=mysql_query($query_delete, $conn);
                        
                    }
                    else
                    {    
                        if($array_productos[$contador]["idfactulinea"])
                        {
                            $result=$factulinea->update_factulinea($conn, $idfactulinea, $id_producto, $cantidad, $costo, $precio, $dcto, $subtotal, $iva);
                        }
                        else
                        {
                            $result=$factulinea->save_factulinea($conn,$idfactura, $id_producto, $cantidad, $costo, $precio, $dcto, $subtotal,$iva,$subt);
                        }
                    }
                                        
                                        
                    


                    $sel_minimos = "SELECT stock,nombre FROM producto where id_producto='$id_producto'";
                    $rs_minimos= mysql_query($sel_minimos, $conn);
                    if (mysql_result($rs_minimos,0,"stock") <= 5)
                    {
                            $mensaje_minimo=$mensaje_minimo . " <li>" . mysql_result($rs_minimos,0,"nombre")." ---- STOCK = ". mysql_result($rs_minimos,0,"stock")."</li>";
                            $minimo=1;
                    };
                    $contador++;
                }
        }
         
        else
        {
            $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   El CODIGO ya existe, ERROR al ingresar la PROFORMA</span>";
            $validacion=1;
        }
             
	$cabecera1="Inicio >> Ventas &gt;&gt; Modificar Proforma ";
	$cabecera2="MODIFICAR PROFORMA ";
}


?>




<html>
	<head>
		<title>Principal</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
                <link href="../calendario/calendar-blue.css" rel="stylesheet" type="text/css">
                <script type="text/javascript" src="../js/validar.js"></script>
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
		
		function aceptar(validacion, accion, idfactura) {
			if(validacion==0)
                        {
                            if(accion=="alta")
                            {
                                //location.href="../cobros/ver_cobros.php?idfactura=" + idfactura;
                                location.href="index.php";
                            }
                            else
                            {
                                location.href="index.php";
                            }
                        }
                        else
                            history.back();
		}
		
		function imprimir(idfactura) {
			window.open("../imprimir/imprimir_proforma.php?idfactura="+idfactura);
		}
                
                
                
                
                
                //funciones parte COBROS
                function cambiar_estado() {
			var estado=document.getElementById("cboEstados").value;
			var idfactura=document.getElementById("idfactura").value;
			miPopup = window.open("actualizarestado.php?estado="+estado+"&idfactura="+idfactura,"frame_datos","width=700,height=80,scrollbars=yes");
		}
		
		function cambiar_vencimiento() {
			var fechavencimiento=document.getElementById("fechavencimiento").value;
			var idfactura=document.getElementById("idfactura").value;
			miPopup = window.open("actualizarvencimiento.php?fechavencimiento="+fechavencimiento+"&idfactura="+idfactura,"frame_datos","width=700,height=80,scrollbars=yes");
		}

                function activar_bancos(indice)
                {
                   with (document.formulario)
                   {
                       value=AcboFP.options[indice].value ;
                     switch (value)
                      {                                                        
                          case "1":
                            acbobanco.selectedIndex=0;
                            acbobanco.disabled = true;
                            break;
                          default:                           
                            acbobanco.disabled = false;
                            break;
                      }
                   }
                }

                function calcular_cambio()
                {
                    var billete=document.getElementById("billete").value;
                    var importe=document.getElementById("Rimporte").value;
                    if(((billete>0)&&(billete!=""))&&((importe>0)&&(importe!="")))
                    {
                        document.getElementById("cambio").value=(billete - importe).toFixed(2);
                    }
                }
               
                
                
		
		</script>
	</head>
        <body onload="imprimir(<?php  echo $idfactura?>)">
		<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header"><?php  echo $cabecera2?></div>
				<div id="frmBusqueda">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
						<tr>
							<td width="15%"></td>
							<td width="85%" colspan="3" class="mensaje"><?php  echo $mensaje;?></td>
					    </tr>
						<?php  if ($minimo==1) { ?>
                                            <tr>
							<td width="15%"></td>
							<td width="85%" colspan="3" class="mensajeminimo">Los siguientes productos se encuentran sin stock:<br><?php  echo $mensaje_minimo ."</ul>"?></td>
					    </tr>
                                            <?php  } 
                                                $sel_cliente="SELECT c.nombre as nombre, c.ci_ruc as ci_ruc, c.direccion as direccion, tc.nombre as tipocliente
                                                               FROM cliente c INNER JOIN tipo_cliente tc ON c.codigo_tipocliente = tc.codigo_tipocliente 
                                                               WHERE id_cliente='$idcliente'";
                                                $rs_cliente=mysql_query($sel_cliente,$conn); 
                                            ?>
                                            <tr>
                                                <td width="15%">Cliente CI/RUC</td>
                                                <td width="35%"><?php  echo mysql_result($rs_cliente,0,"nombre")." -- ".mysql_result($rs_cliente,0,"ci_ruc");?></td>
                                                <td width="15%">Tipo Cliente</td>
                                                <td width="35%"><?php  echo $tipocliente?></td>
					    </tr>                                            
                                             
                                            <tr>
                                                <td>Guia Remision</td>
                                                <td><?php  if($remision==0) {echo "No";} else {echo "Si";} ?></td>
                                                <td>Direcci&oacute;n</td>
                                                <td><?php  echo mysql_result($rs_cliente,0,"direccion"); ?></td>
					    </tr>
                                            <tr>
                                                
                                            </tr>
                                            <tr>
                                                <td>No. Factura</td>
                                                <td><?php  echo $serie1."--".$serie2."--".$codfactura?></td>
                                                <td>Autorizaci&oacute;n</td>
                                                <td><?php  echo $autorizacion?></td>
                                            </tr>                                           
                                            <tr>
                                                <td>Fecha</td>
                                                <td><?php  echo implota($fecha)?></td>
                                                <td>Cr&eacute;dito</td>
                                                <td>
                                                <?php 
                                                    if ($credito==1)
                                                        echo "Si --- <b>PLAZO: </b> ".($plazo*30);
                                                    else
                                                        echo "No"
                                                ?>
                                                </td>
                                            </tr>                                            
					 
				  </table>
					 <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
						<tr class="cabeceraTabla">
							
							<td width="16%">CODIGO</td>
							<td width="36%">DESCRIPCION</td>
                                                        <td width="5%">CANT.</td>
							<td width="8%">PRECIO</td>
                                                        <td width="8%">*</td>
							<td width="8%">DCTO</td>                                                        
							<td width="8%">IVA</td>
                                                        <td width="8">SUBT</td>
						</tr>
					</table>
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
                                            
					  <?php  //$sel_lineas="SELECT factulinea.*,articulos.*,familias.nombre as nombrefamilia FROM factulinea,articulos,familias WHERE factulinea.codfactura='$codfactura' AND factulinea.codigo=articulos.codarticulo AND factulinea.codfamilia=articulos.codfamilia AND articulos.codfamilia=familias.codfamilia ORDER BY factulinea.numlinea ASC";
                                                $sel_lineas="SELECT b.codigo as codigo, b.nombre as nombre, a.cantidad as cantidad, a.precio as precio, a.subtotal as subtotal, a.dcto as dcto, a.iva as iva FROM proforlinea a INNER JOIN producto b ON a.id_producto=b.id_producto WHERE a.id_factura = '$idfactura'";
                                                $rs_lineas=mysql_query($sel_lineas,$conn);
						for ($i = 0; $i < mysql_num_rows($rs_lineas); $i++) {							
							$codarticulo=mysql_result($rs_lineas,$i,"codigo");
                                                        $descripcion=utf8_decode(mysql_result($rs_lineas,$i,"nombre"));
                                                        $cantidad=mysql_result($rs_lineas,$i,"cantidad");
                                                        $precio=mysql_result($rs_lineas,$i,"precio");
                                                        $subtotal=mysql_result($rs_lineas,$i,"subtotal");
                                                        $descuento_ind=mysql_result($rs_lineas,$i,"dcto");
                                                        $iva=mysql_result($rs_lineas, $i, "iva");
							if ($i % 2) { $fondolinea="itemParTabla"; } else { $fondolinea="itemImparTabla"; } ?>
									<tr class="<?php  echo $fondolinea?>">
										
                                                                                <td width="16%"><?php  echo $codarticulo?></td>
                                                                                <td width="36%"><?php  echo $descripcion?></td>
                                                                                <td width="5%"><?php  echo $cantidad?></td>
                                                                                <td width="8%" align="center"><?php  echo $precio?></td>
                                                                                <td width="8%" align="center"><?php  echo $subtotal?></td>
                                                                                <td width="8%" align="center"><?php  echo $descuento_ind?></td>
                                                                                <td width="8%" align="center"><?php  echo $iva?></td>
                                                                                <td width="8%" align="center"><?php  echo (($subtotal-$descuento_ind)+$iva)?></td>
									</tr>
					<?php  } ?>
					</table>
                                </div>

					<div id="frmBusqueda">
					<table width="25%" border=0 align="right" cellpadding=1 cellspacing=0 class="fuente8">
						<tr>
							<td width="15%">Subtotal:</td>
							<td width="5%" align="right"><?php  echo number_format($baseimponible,2);?> &#36;</td>
                                                        <td width="3%"></td>
						</tr>
                                                <tr>
							<td width="15%">Dcto.:</td>
							<td width="5%" align="right"><?php  echo number_format($descuento,2);?> &#36;</td>
                                                        <td width="1%"></td>
						</tr>
                                                <tr>
							<td width="15%">IVA 0:</td>
							<td width="5%" align="right"><?php  echo number_format($iva0,2);?> &#36;</td>
                                                        <td width="1%"></td>
						</tr>
                                                <tr>
							<td width="15%">IVA 12:</td>
							<td width="5%" align="right"><?php  echo number_format($iva12,2);?> &#36;</td>
                                                        <td width="1%"></td>
						</tr>
						<tr>
							<td width="15%">Total IVA:</td>
							<td width="5%" align="right"><?php  echo number_format($importeiva,2);?> &#36;</td>
                                                        <td width="1%"></td>
						</tr>
                                                 <tr>
                                                        <td width="15%">Flete:</td>
							<td width="5%" align="right"><?php  echo $flete?> &#36;</td>
                                                        <td width="1%"></td>
						</tr>
						<tr>
							<td width="15%">Total:</td>
							<td width="5%" align="right"><?php  echo $totalfactura?> &#36;</td>
                                                        <td width="1%"></td>
						</tr>
                                               
					</table>                                        
                                        </div>                                      
                                        <div id="botonBusqueda">
                                                <div align="center">
                                                    <!--
                                                    <?php  if ($accion=="alta")
                                                    {
                                                    ?>
                                                    <img src="../img/botoncobrar.png" width="85" height="22" onClick="aceptar(<?php echo $validacion?>,'<?php  echo $accion?>',<?php  echo $idfactura?>)" border="1" onMouseOver="style.cursor=cursor">
                                                    <?php  } else{?>
                                                    <img src="../img/botonaceptar.jpg" width="85" height="22" onClick="aceptar(<?php echo $validacion?>,'<?php  echo $accion?>',<?php  echo $idfactura?>)" border="1" onMouseOver="style.cursor=cursor">
                                                    <?php }?>
                                                    -->
                                                <img src="../img/botonaceptar.jpg" width="85" height="22" onClick="aceptar(<?php echo $validacion?>,'<?php  echo $accion?>',<?php  echo $idfactura?>)" border="1" onMouseOver="style.cursor=cursor">
                                                <img src="../img/botonimprimir.jpg" width="79" height="22" border="1" onClick="imprimir(<?php  echo $idfactura?>)" onMouseOver="style.cursor=cursor">
                                                </div>
                                        </div>   
                                
                                
                                
                                
                                
			  </div>                                                                                                                                                         
		  </div>                                                                                                    
		</div>
            
	</body>
</html>
