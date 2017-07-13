<?php 

include_once '../conexion/conexion.php';
include_once 'class/ruc.php';

$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$ruc = new ruc();
$row = $ruc->get_ruc_id($conn, 1);
$idruc = $row["id_ruc"];
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
        <title>Principal</title>
        <link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
        
        <link href="../calendario/calendar-blue.css" rel="stylesheet" type="text/css">
        <script type="text/JavaScript" language="javascript" src="../calendario/calendar.js"></script>
        <script type="text/JavaScript" language="javascript" src="../calendario/lang/calendar-sp.js"></script>
        <script type="text/JavaScript" language="javascript" src="../calendario/calendar-setup.js"></script>

       
        <script type="text/javascript" src="../js/fechas.js"></script>
        
        <script language="javascript">

            function cancelar() {
                location.href = "index.php";
            }

            var cursor;
            if (document.all) {
                // Está utilizando EXPLORER
                cursor = 'hand';
            } else {
                // Está utilizando MOZILLA/NETSCAPE
                cursor = 'pointer';
            }

            function limpiar() {
                document.getElementById("formulario").reset();
            }

            function validar_formulario()
            {
                var mensaje = "";
                if (document.getElementById("idinformante").value == "")
                {
                    mensaje += "   - Ingrese Ruc.\n";
                }

                if (document.getElementById("razonsocial").value == "")
                {
                    mensaje += "   - Ingrese Razon Social.\n"
                } 
                
                if (mensaje != "")
                {
                    alert("Atencion:\n" + mensaje);
                }
                else
                {
                    document.getElementById("formulario").submit();
                                      
                }
            }

            function validar_facturero()
            {
                var mensaje = "";
                if (document.getElementById("establecimiento").value == "")
                {
                    mensaje += "   - Ingrese Establecimiento.\n";
                }

                if (document.getElementById("tiposervicio").value == "")
                {
                    mensaje += "   - Ingrese Tipo Servicio.\n"
                }
                
                if (document.getElementById("serieinicio").value == "")
                {
                    mensaje += "   - Ingrese Serie Inicio.\n";
                }
                
                if (document.getElementById("seriefin").value == "")
                {
                    mensaje += "   - Ingrese Serie Fin.\n";
                }
                
                if (document.getElementById("autorizacion").value == "")
                {
                    mensaje += "   - Ingrese Autorizacion.\n";
                }
                
                if (document.getElementById("fecha_caducidad").value == "")
                {
                    mensaje += "   - Ingrese Fecha Caducidad.\n";
                }
                
                
                if (mensaje != "")
                {
                    alert("Atencion:\n" + mensaje);
                }
                else
                {
                    document.getElementById("formulario_factureros").submit();
                    document.getElementById("establecimiento").value = "";
                    document.getElementById("tiposervicio").value = "";
                    document.getElementById("serieinicio").value = "";                    
                    document.getElementById("seriefin").value = "";
                    document.getElementById("autorizacion").value = "";
                    document.getElementById("fecha_caducidad").value = "";                    
                }
            }           

            function cargar_frames()
            {
                document.getElementById("modif").value = 1;
                document.formulario_factureros.submit();
             
                document.getElementById("modif").value = 0;
            }
        </script>
    </head>
    <body onload="cargar_frames()">
        <div id="pagina">
            <div id="zonaContenido">
                <div align="center">
                    <div id="tituloForm" class="header">DATOS RUC</div>
                    <div id="frmBusqueda">
                        <form id="formulario" name="formulario" method="post" action="save_ruc.php">
                            <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>						
                                <tr>
                                    <td width="8%">RUC: </td>
                                    <td ><input NAME="Vidinformante" type="text" class="cajaGrande" id="idinformante" value="<?php  echo $row["idinformante"] ?>" size="45" maxlength="45"></td>
                                </tr>

                                <tr>
                                    <td width="8%">RAZON SOCIAL:</td>
                                    <td ><input NAME="Arazonsocial" type="text" class="cajaGrande" id="razonsocial" value="<?php  echo $row["razonsocial"] ?>" size="45" maxlength="45"></td>

                                </tr>                                                 
                            </table>
                    </div>
                    <div id="botonBusqueda">
                        <img src="../img/botonaceptar.jpg" width="85" height="22" onClick="validar_formulario()" border="1" onMouseOver="style.cursor = cursor">
                        
                        <input id="accion" name="accion" value="modificar" type="hidden">
                        <input id="id" name="id" value="" type="hidden">
                        <input id="idruc" name="idruc" value="<?php  echo $idruc; ?>" type="hidden">
                    </div>
                    </form>

                    <!--- INICIO FORMULARIO FACTUREROS------------------------------------------------------------------------------------->

                    <div id="frmBusqueda">
                        <form id="formulario_factureros" name="formulario_factureros" method="post" action="frame_factureros.php" target="frame_factureros">
                            <div id="tituloForm" class="header" style="background: #EFD279">FACTUREROS</div>
                            <table class="fuente8" width="98%" cellspacing=0 cellpadding=1 border=0 >

                                
                                <tr>
                                    <td width="6%">
                                        Establecimiento:
                                    </td>
                                    <td width="8%">                                        
                                        <input NAME="establecimiento" type="text" class="cajaPequena" id="establecimiento" size="3" maxlength="3">
                                    </td>
                                    <td width="6%">
                                        Serie Inicio:
                                    </td>
                                    <td width="15%">
                                        <input NAME="serieinicio" type="text" class="cajaMedia" id="serieinicio" size="20" maxlength="20">
                                    </td>
                                    <td width="6%">
                                        Autorizaci&oacute;n:
                                    </td>
                                    <td width="15%">
                                        <input NAME="autorizacion" type="text" class="cajaMedia" id="autorizacion" size="20" maxlength="20">
                                    </td>
                                    <td rowspan="2" >
                                        <img src="../img/guardar.png" width="23" height="29" onClick="validar_facturero()" onMouseOver="style.cursor = cursor" title="Agregar Facturerod">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Tipo Servicio:
                                    </td>
                                    <td>                                        
                                        <input NAME="tiposervicio" type="text" class="cajaPequena" id="tiposervicio" size="3" maxlength="3">
                                    </td>
                                    <td>
                                        Serie Fin:
                                    </td>
                                    <td>
                                        <input NAME="seriefin" type="text" class="cajaMedia" id="seriefin" size="20" maxlength="20">
                                    </td>

                                    <td >Fecha Vencto.:</td>
                                    <td ><input NAME="fecha_caducidad" type="text" class="cajaPequena" id="fecha_caducidad" size="10" maxlength="10"  readonly> <img src="../img/calendario.png" name="Image1" id="Image1" width="16" height="16" border="0" id="Image1" onMouseOver="this.style.cursor = 'pointer'">
                                        <script type="text/javascript">
                                            Calendar.setup(
                                                    {
                                                        inputField: "fecha_caducidad",
                                                        ifFormat: "%d/%m/%Y",
                                                        button: "Image1"
                                                    }
                                            );
                                        </script>
                                    </td>                                    
                                </tr>
                            </table>
                    </div>


                    <div id="frmBusqueda">
                        <table class="fuente8" width="65%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
                            <tr class="cabeceraTabla">
                                <td width="10%">Establec.</td>
                                <td width="10%">Servicio</td>
                                <td width="10%">Inicio</td>
                                <td width="10%">Fin</td>
                                <td width="10%">Autorizaci&oacute;n</td>
                                <td width="10%">Caducidad</td>
                                <td width="5%">&nbsp;</td>                                
                            </tr>
                        </table>
                        <div id="lineaResultado">
                            <iframe align="middle" width="100%" height="110" id="frame_factureros" name="frame_factureros" frameborder="0" >
                            <ilayer  width="100%" height="110" id="frame_factureros" name="frame_factureros"></ilayer>
                            </iframe>
                        </div>
                    </div>

                    <input id="idruc" name="idruc" value="<?php  echo $idruc;?>" type="hidden">
                    <input id="modif" name="modif" value="0" type="hidden">
                    </form>

                    <!--- FIN FORMULARIO TELEFONOS OFICINA------------------------------------------------------------------------------------->


                </div>
            </div>
        </div>
    </body>
</html>
