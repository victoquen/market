
<html>
    <head>
        <title>CUENTAS X COBRAR INDIVIDUAL</title>
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
		
		
            function inicio() {
                document.getElementById("codcliente").value=0;
                document.getElementById("formulario").submit();
            }
		
            function buscar() {
			
                document.getElementById("formulario").submit();
            }
				
            function limpiar() {
                document.getElementById("formulario").reset();
            }
                
                
            var miPopup
            function abreVentana(){
                
                miPopup = window.open("ver_clientes.php","miwin","width=900px,height=550px,scrollbars=yes");
                miPopup.focus();                
            }
                
        </script>
    </head>
    <body onLoad="inicio()">
        <div id="pagina">
            <div id="zonaContenido">
                <div align="center">
                    <div id="tituloForm" class="header">CUENTAS X COBRAR INDIVIDUAL</div>
                    <div id="frmBusqueda">
                        <form id="formulario" name="formulario" method="post" action="rejilla.php" target="frame_rejilla">
                            <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>					
                                <tr>
                                    <td width="6%">Cliente</td>
                                    <td width="35%"><input NAME="nombre" type="text" class="cajaGrande" id="nombre" size="45" maxlength="45" onClick="abreVentana()" readonly>
                                        <img src="../img/ver.png" width="16" height="16" onClick="abreVentana()" title="Buscar cliente" onMouseOver="style.cursor=cursor">
                                    </td> 

                                    <td width="10%">C&oacute;digo Cliente</td>
                                    <td width="25%"><input NAME="codcliente" type="text" class="cajaPequena" id="codcliente" size="6" maxlength="5"  readonly>
                                </tr>
                                <tr>
                                    <td>CI/RUC</td>
                                    <td><input NAME="ci_ruc" type="text" class="cajaMedia" id="ci_ruc" size="20" maxlength="15" readonly></td>

                                    <td >Tipo Cliente</td>
                                    <td>
                                        <input NAME="tipo_cliente" type="text" class="cajaPequena" id="tipo_cliente" size="20" maxlength="15" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right" colspan="2">
                                        <input type="submit" value="Buscar"/>
                                    </td>
                                </tr>
                            </table>
                    </div>
                    <div id="botonBusqueda">
                        <!--<img src="../img/botonbuscar.jpg" width="69" height="22" border="1" onClick="buscar()" onMouseOver="style.cursor=cursor">-->
                        <img src="../img/botonlimpiar.jpg" width="69" height="22" border="1" onClick="limpiar()" onMouseOver="style.cursor=cursor">	
                    </div>

                    <div id="cabeceraResultado" class="header">
                        relacion de MOVIMIENTOS </div>
                    <div id="frmResultado">				
                        </form>
                        <div id="lineaResultado">
                            <iframe width="100%" height="600" id="frame_rejilla" name="frame_rejilla" frameborder="0">
                            <ilayer width="100%" height="600" id="frame_rejilla" name="frame_rejilla"></ilayer>
                            </iframe>
                        </div>
                        <iframe id="frame_datos" name="frame_datos" width="0" height="0" frameborder="0">
                        <ilayer width="0" height="0" id="frame_datos" name="frame_datos"></ilayer>
                        </iframe>
                    </div>
                </div>			
            </div>
        </div>
    </body>
</html>
