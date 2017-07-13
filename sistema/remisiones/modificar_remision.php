<?php 
include ("../js/fechas.php");
include ("../conexion/conexion.php");
error_reporting(0);

$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$fechahoy=date("Y-m-d");

error_reporting(0);
$idremision=$_GET["idremision"];

//datos remision
$query="SELECT id_factura,codigo_remision,serie1,serie2, autorizacion,fecha_fin,motivo,punto_partida,nombre_trans,ci_trans
                FROM remision
                WHERE id_remision ='$idremision'";
$res_rem = mysql_query($query, $conn);
$id_factura=mysql_result($res_rem,0,"id_factura");
//fin datos remision


//datos factura-cliente
$query_clie="SELECT f.id_cliente as id_cliente, c.nombre as nombre, c.ci_ruc as ci_ruc, c.direccion as direccion, c.lugar as lugar,
                    f.serie1 as serie1, f.serie2 as serie2, f.codigo_factura as codigo_factura, f.fecha as fecha
             FROM cliente c INNER JOIN facturas f ON c.id_cliente = f.id_cliente
             WHERE f.id_factura= $id_factura";
$res_clie=mysql_query($query_clie,$conn);
//fin datos factura-cliente

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
                    
                        document.getElementById("formulario").submit();
                    

                }

                function imprimir(idremision) {
			window.open("../imprimir/imprimir_remision_compra.php?idremision="+idremision);
		}

                function cancelar() {
			location.href="index.php";
		}


                 function motivo_traslado()
                {
                    var op=document.getElementById("motivo_tras").value;
                    document.getElementById("motivo").value=op;
                    
                }
		</script>
	</head>
        <body  >
		<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header">MODIFICAR GUIA DE REMISION</div>
				<div id="frmBusqueda">
				<form id="formulario" name="formulario" method="post" action="guardar_remision.php">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
                                                
					 <tr>
                                                    <td width="10%">No. remision</td>
                                                    <td>
                                                        <input NAME="serie1" type="text" class="cajaMinima" id="serie1" value="<?php echo mysql_result($res_rem,0,"serie1");?>" readonly>
                                                        <input NAME="serie2" type="text" class="cajaMinima" id="serie2" value="<?php echo mysql_result($res_rem,0,"serie2");?>" readonly>
                                                        <input NAME="codremision" type="text" class="cajaPequena" id="codremision" value="<?php echo mysql_result($res_rem,0,"codigo_remision");?>" readonly>

                                                    </td>
                                                    <td width="5%">Autorizaci&oacute;n</td>
                                                    <td colspan="2">
                                                        <input NAME="autorizacion" type="text" class="cajaPequena" id="autorizacion" value="<?php echo mysql_result($res_rem,0,"autorizacion");?>" readonly>
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
                                                        <input NAME="fecha_fin" type="text" class="cajaPequena" id="fecha_fin" size="10" maxlength="10" value="<?php echo implota(mysql_result($res_rem,0,"fecha_fin"))?>"  readonly>
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
                                                            
                                                            <?php  
                                                                $op=mysql_result($res_rem,0,"motivo"); 
                                                                switch (op)
                                                                {
                                                                   case "venta":
                                                                   case "VENTA":
                                                            ?>
                                                            
                                                                            <option selected value="venta">Venta</option>
                                                                            <option value="consignacion">Consignacion</option>
                                                                            <option value="devolucion">Devolucion</option>
                                                                            <option value="otros">Otros</option>
                                                            <?php 
                                                                            break;
                                                                  case 'consignacion':
                                                                  case 'CONSIGNACION':
                                                            ?>
                                                                            <option value="venta">Venta</option>
                                                                            <option selected value="consignacion">Consignacion</option>
                                                                            <option value="devolucion">Devolucion</option>
                                                                            <option value="otros">Otros</option>
                                                            <?php 
                                                                            break;
                                                                  case 'devolucion':
                                                                  case 'DEVOLUCION':
                                                            ?>
                                                                            <option value="venta">Venta</option>
                                                                            <option value="consignacion">Consignacion</option>
                                                                            <option selected value="devolucion">Devolucion</option>
                                                                            <option value="otros">Otros</option>


                                                            <?php 
                                                                            break;
                                                                  case 'otros':
                                                                  case 'OTROS':
                                                            ?>
                                                                            <option value="venta">Venta</option>
                                                                            <option value="consignacion">Consignacion</option>
                                                                            <option value="devolucion">Devolucion</option>
                                                                            <option selected value="otros">Otros</option>
                                                            <?php 
                                                                            break;
                                                                  default :
                                                            ?>
                                                                            <option value="venta">Venta</option>
                                                                            <option value="consignacion">Consignacion</option>
                                                                            <option value="devolucion">Devolucion</option>
                                                                            <option selected value="otros">Otros</option>


                                                            <?php 
                                                                }
                                                            ?>
                                                        </select>
                                                        <input id="motivo" name="motivo" class="cajaMedia" type="text" value="<?php echo mysql_result($res_rem,0,"motivo")?>">
                                                    </td>
                                                </tr>

						<tr>
                                                    <td width="10%">Fecha Emision</td>
                                                    <td><input name="fecha_emision" id="fecha_emision" type="text" class="cajaPequena" value="<?php echo implota(mysql_result($res_clie,0,"fecha"))?>" readonly></td>
						</tr>
                                                <tr>
                                                    <td width="10%">Punto Partida</td>
						    <td width="27%"><input NAME="punto_partida" type="text" class="cajaMedia" id="punto_partida" value="<?php echo mysql_result($res_rem,0,"punto_partida")?>" readonly></td>
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
                                                    <td width="27%"><input NAME="nombre_trans" type="text" class="cajaGrande" id="nombre_trans" value="<?php echo mysql_result($res_rem,0,"nombre_trans")?>"></td>
                                                </tr>
                                                <tr>
                                                    <td>CI/RUC</td>
                                                    <td width="27%"><input NAME="ci_trans" type="text" class="cajaMedia" id="ci_trans" maxlength="13" value="<?php echo mysql_result($res_rem,0,"ci_trans")?>"></td>
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
                                <input id="idremision" name="idremision" value="<?php echo $idremision?>" type="hidden">
                                 <input id="idfactura" name="idfactura" value="<?php echo $id_factura?>" type="hidden">
                                <input id="accion" name="accion" value="modificar" type="hidden">
			  </form>
			 </div>
		  </div>
		</div>
	</body>
</html>
