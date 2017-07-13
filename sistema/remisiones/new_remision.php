<?php 
include ("../js/fechas.php");
include ("../conexion/conexion.php");
error_reporting(0);

$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$fechahoy=date("Y-m-d");



//numero remisionero
$sel_remisionero="select serie1, serie2, autorizacion, inicio, fin, fecha_caducidad FROM remisionero where id_remisionero=1";
$rs_remisionero=mysql_query($sel_remisionero, $conn);
$serie1=mysql_result($rs_remisionero,0,"serie1");
$serie2=mysql_result($rs_remisionero,0,"serie2");
$autorizacion=mysql_result($rs_remisionero,0,"autorizacion");
$inicio=mysql_result($rs_remisionero,0,"inicio");
$fin=mysql_result($rs_remisionero,0,"fin");
$fecha_caducidad=mysql_result($rs_remisionero,0,"fecha_caducidad");

//numero de remision maxima
$sel_max="SELECT max(codigo_remision)as maximo FROM remision";
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

if(($maximo>=$inicio)&&($maximo<=$fin)&&($fechah<=$fechac)){
    $aceptacion=1;
    $mensaje_aceptacion="todo valido";
}
else{
    $aceptacion=0;
    $mensaje_aceptacion="Numeracion de remision Caducado, no guia de remision. Por Favor Actualizar datos de la remision.";
}

// id_factura por GET
$id_factura=$_GET["idfactura"];


//datos cliente
$query_clie="SELECT f.id_cliente as id_cliente, c.nombre as nombre, c.ci_ruc as ci_ruc, c.direccion as direccion, c.lugar as lugar,
                    f.serie1 as serie1, f.serie2 as serie2, f.codigo_factura as codigo_factura, f.fecha as fecha
             FROM cliente c INNER JOIN facturas f ON c.id_cliente = f.id_cliente
             WHERE f.id_factura= $id_factura";
$res_clie=mysql_query($query_clie,$conn);


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
                               
                function validar()
                {
                    if((document.getElementById("nombre_trans").value=="")||(document.getElementById("ci_trans").value==""))
                        {
                            alert("ERROR\nFalta de DATOS");
                        }
                    else
                    {
                        document.getElementById("formulario").submit();
                    }

                }

                function cancelar() {
			location.href="../facturas_clientes/index.php";
		}

                function motivo_traslado()
                {
                    var op=document.getElementById("motivo_tras").value;
                    document.getElementById("motivo").value=op;                    
                    if(op=="otros")
                    {
                        document.getElementById("motivo").disabled=false;
                    }
                    else
                    {
                        document.getElementById("motivo").disabled=true;
                    }
                }
		</script>
	</head>
        <body onload="inicio('<?php  echo $aceptacion?>','<?php  echo $mensaje_aceptacion?>')" >
		<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header">INSERTAR remision COMPRA</div>
				<div id="frmBusqueda">
				<form id="formulario" name="formulario" method="post" action="guardar_remision.php">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
                                                <tr>
                                                    <td width="10%">No. remision</td>
                                                    <td>
                                                        <input NAME="serie1" type="text" class="cajaMinima" id="serie1" value="<?php echo $serie1?>" readonly>
                                                        <input NAME="serie2" type="text" class="cajaMinima" id="serie2" value="<?php echo $serie2?>" readonly>
                                                        <input NAME="codremision" type="text" class="cajaPequena" id="codremision" value="<?php echo $maximo?>" readonly>

                                                    </td>
                                                    <td width="5%">Autorizaci&oacute;n</td>
                                                    <td colspan="2">
                                                        <input NAME="autorizacion" type="text" class="cajaPequena" id="autorizacion" value="<?php echo $autorizacion?>" readonly>
                                                    </td>
                                                    
                                                </tr>
                                                
                                                <tr><td colspan="4"><hr/></td></tr>

                                                <tr>
                                                    <td width="12%">No. Comprobante</td>
                                                    <td><input NAME="numero_comprobante" type="text" class="cajaMedia" id="numero_comprobante" value="<?php echo mysql_result($res_clie,0,"serie1")." - ".mysql_result($res_clie,0,"serie2")."  # ".mysql_result($res_clie,0,"codigo_factura")?>" readonly></td>
                                                <tr/>
                                                <tr>
                                                    <td width="12%">Fecha de Emisi&oacute;n</td>
                                                    <td><input name="fecha_emision" id="fecha_emision" type="text" class="cajaPequena" value="<?php echo implota(mysql_result($res_clie,0,"fecha"))?>" readonly></td>
                                                </tr>

                                                <tr><td colspan="4"><hr/></td></tr>

                                                <tr>
                                                    <td width="12%">Fecha Inicio Traslado</td>
                                                    <td><input name="fecha_inicio" id="fecha_inicio" type="text" class="cajaPequena" value="<?php echo implota(mysql_result($res_clie,0,"fecha"))?>" readonly></td>
                                                </tr>

                                                <?php  $hoy=date("d/m/Y"); ?>
                                                <tr>
                                                    <td width="12%">Fecha Fin Traslado</td>
                                                    <td>
                                                        <input NAME="fecha_fin" type="text" class="cajaPequena" id="fecha_fin" size="10" maxlength="10"  readonly>
                                                        <img src="../img/calendario.png" name="Image1" id="Image1" width="16" height="16" border="0" id="Image1" onMouseOver="this.style.cursor='pointer'">
                                                        <script type="text/javascript">
                                                                                Calendar.setup(
                                                                                  {
                                                                                inputField : "fecha_fin",
                                                                                ifFormat   : "%d/%m/%Y",
                                                                                button     : "Image1"
                                                                                  }
                                                                                );
                                                        </script></td>
                                                </tr>

                                                <tr>
                                                    <td>Motivo del Traslado:</td>
                                                    <td> <select id="motivo_tras" name="motivo_tras" class="comboPequeno" onchange="motivo_traslado()">
                                                            <option value="venta">Venta</option>
                                                            <option value="consignacion">Consignacion</option>
                                                            <option value="devolucion">Devolucion</option>
                                                            <option value="otros">Otros</option>
                                                        </select>
                                                        <input id="motivo" name="motivo" class="cajaMedia" type="text" value="VENTA" disabled>
                                                    </td>
                                                </tr>

						<tr>
                                                    <td width="10%">Fecha Emision</td>
                                                    <td><input name="fecha_emision" id="fecha_emision" type="text" class="cajaPequena" value="<?php echo implota(mysql_result($res_clie,0,"fecha"))?>" readonly></td>
						</tr>
                                                <tr>
                                                    <td width="10%">Punto Partida</td>
						    <td width="27%"><input NAME="punto_partida" type="text" class="cajaMedia" id="punto_partida" value="RIOBAMBA" readonly></td>
						</tr>
                                                <tr><td><b>DESTINATARIO</b></td></tr>

                                                <tr>
                                                    <td width="10%">NOMBRE</td>
						    <td width="27%"><input NAME="nombre_clie" type="text" class="cajaGrande" id="nombre_clie" value="<?php echo mysql_result($res_clie,0,"nombre")?>" readonly></td>
						</tr>

                                                <tr>
                                                    <td>CI/RUC</td>
                                                    <td width="27%"><input NAME="ci_clie" type="text" class="cajaMedia" id="ci_clie" value="<?php echo mysql_result($res_clie,0,"ci_ruc")?>" readonly></td>
                                                </tr>

						<tr>
                                                    <td width="10%">Punto LLegada</td>
						    <td width="27%"><input NAME="punto_llegada" type="text" class="cajagrande" id="punto_llegada" size="10" maxlength="10" value="<?php  echo mysql_result($res_clie,0,"lugar")." -- ". mysql_result($res_clie,0,"direccion") ?>" readonly></td>
                                                </tr>

                                                <tr><td colspan="4"><hr/></td></tr>
                                                <tr><td colspan="2"><b>IDENTIFICACION PERSONA ENCARGADA TRANSPORTE</b></td></tr>
                                                <tr>
                                                    <td>NOMBRE</td>
                                                    <td width="27%"><input NAME="nombre_trans" type="text" class="cajaGrande" id="nombre_trans"></td>
                                                </tr>
                                                <tr>
                                                    <td>CI/RUC</td>
                                                    <td width="27%"><input NAME="ci_trans" type="text" class="cajaMedia" id="ci_trans" maxlength="13"></td>
                                                </tr>
					</table>

                                    <?php  $query_productos="SELECT f.cantidad as cantidad, p.nombre as nombre
                                                         FROM factulinea as f INNER JOIN producto as p ON f.id_producto = p.id_producto
                                                         WHERE f.id_factura = $id_factura";

                                       $res_prod=mysql_query($query_productos, $conn);
                                    ?>


                                    <p style="text-align: center"><b>BIENES TRANSPORTADOS</b></p>
                                    <table class="fuente8" width="60%" cellspacing=0 cellpadding=3 border=1>
                                        <tr>
                                            <th width="10%">CANTIDADES</th>
                                            <th width="90%">DESCRIPCION</th>
                                        </tr>
                                        <?php 
                                        while ( $aRow = mysql_fetch_array( $res_prod ) )
                                        {
                                        ?>
                                            <tr>
                                                <td align="center">
                                                    <?php  echo $aRow["cantidad"]?>
                                                </td>
                                                <td align="center">
                                                    <?php  echo $aRow["nombre"]?>
                                                </td>
                                            </tr>
                                        <?php 
                                        }
                                        ?>
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
                                <input id="idfactura" name="idfactura" value="<?php echo $id_factura?>" type="hidden">
                                <input id="accion" name="accion" value="alta" type="hidden">
			  </form>
			 </div>
		  </div>
		</div>
	</body>
</html>
