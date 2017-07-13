<?php
include ("../js/fechas.php");
include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$idfactura = $_GET["idfactura"];

$select_facturas = "SELECT cliente.id_cliente,cliente.nombre,cliente.ci_ruc,
                    facturas.id_factura, facturas.codigo_factura,facturas.serie1,facturas.serie2,facturas.autorizacion, estado,totalfactura, facturas.ret_iva, facturas.ret_fuente
                  FROM facturas LEFT JOIN cobros ON facturas.id_factura=cobros.id_factura INNER JOIN cliente ON facturas.id_cliente=cliente.id_cliente
                  WHERE facturas.id_factura='$idfactura'";
$rs_facturas = mysql_query($select_facturas, $conn);




$hoy = date("d/m/Y");

$sel_cobros = "SELECT sum(importe) as aportaciones FROM cobros WHERE id_factura='$idfactura'";
$rs_cobros = mysql_query($sel_cobros, $conn);
if ($rs_cobros)
    $aportaciones = mysql_result($rs_cobros, 0, "aportaciones");
else
    $aportaciones = 0;
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
                cursor = 'hand';
            } else {
                // Está utilizando MOZILLA/NETSCAPE
                cursor = 'pointer';
            }


            function cancelar() {
                location.href = "index.php";
            }

            function cambiar_estado() {
                var estado = document.getElementById("cboEstados").value;
                var idfactura = document.getElementById("idfactura").value;
                miPopup = window.open("actualizarestado.php?estado=" + estado + "&idfactura=" + idfactura, "frame_datos", "width=700,height=80,scrollbars=yes");
            }

            function cambiar_vencimiento() {
                var fechavencimiento = document.getElementById("fechavencimiento").value;
                var idfactura = document.getElementById("idfactura").value;
                miPopup = window.open("actualizarvencimiento.php?fechavencimiento=" + fechavencimiento + "&idfactura=" + idfactura, "frame_datos", "width=700,height=80,scrollbars=yes");
            }

            function activar_bancos(indice)
            {
                with (document.formulario)
                {
                    value = AcboFP.options[indice].value;
                    switch (value)
                    {
                        case "1":
                            acbobanco.selectedIndex = 0;
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
                var billete = document.getElementById("billete").value;
                var importe = document.getElementById("Rimporte").value;
                if (((billete > 0) && (billete != "")) && ((importe > 0) && (importe != "")))
                {
                    document.getElementById("cambio").value = (billete - importe).toFixed(2);
                }
            }
        </script>



    </head>
    <body>
        <div id="pagina">
            <div id="zonaContenido">
                <div align="center">
                    <div id="tituloForm" class="header">COBROS </div>
                    <div id="frmBusqueda">
                        <form id="formdatos" name="formdatos" method="post" action="guardar_cobro.php">
                            <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
<?php
$codfactura = mysql_result($rs_facturas, 0, "codigo_factura");
$serie1 = mysql_result($rs_facturas, 0, "serie1");
$serie2 = mysql_result($rs_facturas, 0, "serie2");
$autorizacion = mysql_result($rs_facturas, 0, "autorizacion");
$idcliente = mysql_result($rs_facturas, 0, "id_cliente");
$ci_ruc = mysql_result($rs_facturas, 0, "ci_ruc");
$nombre = mysql_result($rs_facturas, 0, "nombre");
$idfactura = mysql_result($rs_facturas, 0, "id_factura");
$totalfactura = mysql_result($rs_facturas, 0, "totalfactura");
$estado = mysql_result($rs_facturas, 0, "estado");
$retiva = mysql_result($rs_facturas, 0, "ret_iva");
$retfuente = mysql_result($rs_facturas, 0, "ret_fuente");


$sel_cliente = "SELECT tc.nombre as tipocliente
                                                            FROM cliente c INNER JOIN tipo_cliente tc ON c.codigo_tipocliente = tc.codigo_tipocliente
                                                            WHERE id_cliente='$idcliente'";
$rs_cliente = mysql_query($sel_cliente, $conn);
?>

                                <tr>
                                    <td width="10%">Total de la factura</td>
                                    <td width="10%"><input type="text" name="totfact" id="totfact" style="text-align: right"  value="<?php echo number_format($totalfactura, 2, ".", "") ?>" readonly="yes" class="cajaPequena" > &#36;</td>
                                    <td width="8%">Cliente Ci/Ruc</td>
                                    <td width="38%"><?php echo $nombre . " -- " . $ci_ruc . " -- " . mysql_result($rs_cliente, 0, "tipocliente") ?></td>              

                                </tr>
                                
                                <tr>
                                    <td width="10%">Retenci&oacute;n Iva</td>
                                    <td width="10%"><input type="text" name="reti" id="reti" value="<?php echo "- ". number_format($retiva, 2, ".", "") ?>" readonly="yes" class="cajaTotales"> &#36;</td>
                                    
                                    <td width="8%">No. de factura</td>
                                    <td width="38%"><?php echo $serie1 . "--" . $serie2 . "--" . $codfactura ?>  ...    Autorizaci&oacute;n: <?php echo $autorizacion ?></td>                                                                        
                                </tr>
                                
                                <tr>
                                    <td width="10%">Retenci&oacute;n Fuente</td>
                                    <td width="10%"><input type="text" name="retf" id="retf" value="<?php echo "- ". number_format($retfuente, 2, ".", "") ?>" readonly="yes" class="cajaTotales"> &#36;</td>                                    
                                </tr>
<?php 
    $pendiente = $totalfactura - $aportaciones - $retiva - $retfuente;
    if(($pendiente > -1) &&($pendiente <0)){
        $pendiente = $pendiente *(-1);
    }
    $pendiente = round($pendiente, 2);
?>
                                <tr>
                                    <td width="10%">Pendiente por pagar</td>
                                    <td width="10%"><input type="text" name="pendiente" id="pendiente" value="<?php echo number_format($pendiente, 2, ".", "") ?>" readonly="yes" class="cajaTotales"> &#36;</td>
                                </tr>
                                <tr>
                                    <td width="10%">Estado de la factura</td>
                                    <td width="10%"><select id="cboEstados" name="cboEstados" class="comboMedio" onChange="cambiar_estado()">
                                    <?php if ($estado == 0) { ?><option value="0" selected="selected">Sin Cobrar</option>
                                                <option value="1">Cobrada</option><?php } else { ?>
                                                <option value="0">Sin Cobrar</option>
                                                <option value="1" selected="selected">Cobrada</option>
                                    <?php } ?> 			
                                        </select></td>

                                </tr>	

                            </table>
                        </form>
                    </div>
                    <br>
                    <div id="frmBusqueda">
                        <form id="formulario" name="formulario" method="post" action="frame_cobros.php" target="frame_cobros">
                            <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>

<?php
$query_fp = "SELECT * FROM formapago WHERE borrado=0 ORDER BY nombre ASC";
$res_fp = mysql_query($query_fp, $conn);
$contador = 0;
?>
                                <tr>
                                    <td width="11%">Fecha de cobro</td>
                                    <td width="12%"><input id="fechacobro" type="text" class="cajaPequena" NAME="fechacobro" maxlength="10" value="<?php echo $hoy ?>" readonly><img src="../img/calendario.png" name="Image1" id="Image1" width="16" height="16" border="0" id="Image1" onMouseOver="this.style.cursor = 'pointer'" title="Calendario">
                                        <script type="text/javascript">
                                            Calendar.setup(
                                                    {
                                                        inputField: "fechacobro",
                                                        ifFormat: "%d/%m/%Y",
                                                        button: "Image1"
                                                    }
                                            );
                                        </script>
                                    </td>

                                    <td width="11%">Forma de pago</td>
                                    <td width="35%"><select id="AcboFP" name="AcboFP" class="comboGrande" onchange="activar_bancos(this.selectedIndex)">

                                            <option value="0">Seleccione una forma de pago</option>
<?php while ($contador < mysql_num_rows($res_fp)) { ?>
                                                <option value="<?php echo mysql_result($res_fp, $contador, "id_formapago") ?>"><?php echo mysql_result($res_fp, $contador, "nombre") ?></option>
                                                <?php $contador++;
                                            }
                                            ?>				
                                        </select>							
                                    </td>

                                    <td width="50%" rowspan="14" align="left" valign="top"><ul id="lista-errores"></ul></td>
                                </tr>

<?php
$query_b = "SELECT * FROM banco WHERE borrado=0 ORDER BY nombre ASC";
$res_b = mysql_query($query_b, $conn);
$contador = 0;
?>
                                <tr>
                                    <td width="11%">Importe x Cobrar:</td>
                                    <td width="12%"><input  id="Rimporte" type="text" class="cajaPequena" NAME="Rimporte" maxlength="12" onchange="calcular_cambio()" style="text-align: right" value="<?php echo $pendiente?>"> &#36;</td>
                                    <td width="11%">Entidad Bancaria</td>
                                    <td width="35%"><select id="acbobanco"  class="comboGrande" NAME="acbobanco" disabled="true">
                                            <option value="1">Seleccione una entidad bancaria</option>
<?php while ($contador < mysql_num_rows($res_b)) { ?>
                                                <option value="<?php echo mysql_result($res_b, $contador, "id_banco") ?>"><?php echo mysql_result($res_b, $contador, "nombre") ?></option>
                                                <?php $contador++;
                                            }
                                            ?>
                                        </select> 
                                    </td>
                                </tr>

                                <tr>
				    <td></td>
                                    <td width="12%"><input type="hidden" id="billete" type="text" class="cajaPequena" NAME="billete" maxlength="12" onchange="calcular_cambio()" style="text-align: right"></td>
                                    
                                    <td width="11%">Observaciones</td>
                                    <td width="35%"><textarea rows="1" cols="30" class="areaTexto" name="observaciones" id="observaciones"></textarea></td>
                                    <td width="50%" rowspan="14" align="left" valign="top"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><input type="hidden" id="cambio" type="text" NAME="cambio" maxlength="12" readonly="yes" class="cajaTotales" value="0"></td>
                                    <td colspan="2" align="center">
                                        <img src="../img/botonagregar.jpg" width="85" height="22" onClick="javascript:validar(formulario, true);" border="1" onMouseOver="style.cursor = cursor">
                                        <img src="../img/botonvolver.jpg" width="85" height="22" onClick="cancelar()" border="1" onMouseOver="style.cursor = cursor">
                                    </td>
                                </tr>                                                																												
                            </table>                                                                                
                    </div>				
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="accion" id="accion" value="insertar">
                    <input type="hidden" name="idcliente" id="codcliente" value="<?php echo $idcliente ?>">
                    <input type="hidden" name="idfactura" id="idfactura" value="<?php echo $idfactura ?>">
                    <input type="hidden" name="retiva" id="retiva" value="<?php echo $retiva?>" >
                    <input type="hidden" name="retfuente" id="retfuente" value="<?php echo $retfuente?>" >
                    </form>
                    <br>
                    <div id="frmBusqueda">
                        <div id="tituloForm" class="header">RELACION DE COBROS </div>
                        <div id="frmResultado2">
                            <table class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
                                <tr class="cabeceraTabla">
                                    <td width="10%" align="center">ITEM</td>
                                    <td width="12%" align="center">FECHA</td>
                                    <td width="12%" align="center">IMPORTE </td>
                                    <td width="20%" align="center">FORMA PAGO</td>
                                    <td width="20%" align="center">ENTIDAD BANCARIA</td>
                                    <td width="5%">OBV.</td>
                                    <td width="6%">&nbsp;</td>
                                </tr>
                            </table>
                        </div>
                        <div id="lineaResultado">
                            <iframe width="100%" height="250" id="frame_cobros" name="frame_cobros" frameborder="0" src="frame_cobros.php?accion=ver&idfactura=<?php echo $idfactura ?>">
                            <ilayer width="100%" height="250" id="frame_cobros" name="frame_cobros"></ilayer>
                            </iframe>
                            <iframe id="frame_datos" name="frame_datos" width="0" height="0" frameborder="0">
                            <ilayer width="0" height="0" id="frame_datos" name="frame_datos"></ilayer>
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
