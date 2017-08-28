<html>
<head>
    <title>Cobros</title>
    <link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
    <!-- INICIO ARCHIVOS CALENDARIO -->
    <link rel="stylesheet" href="../css/jquery-ui.css"/>
    <link rel="stylesheet" href="../css/jquery-ui.min.css"/>
    <link rel="stylesheet" href="../css/jquery-ui.structure.css"/>
    <link rel="stylesheet" href="../css/jquery-ui.structure.min.css"/>
    <script src="../js/jquery-1.12.4.js"></script>
    <script src="../js/1.12.1_jquery-ui..js"></script>
    <script language="javascript">
        $(function () {
            $("#fechainicio").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd/mm/yy',
                showOn: "button",
                buttonImage: "../img/calendario.png",
                buttonImageOnly: true,
                buttonText: "Seleccionar Fecha"
            });
        });

        $(function () {
            $("#fechafin").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd/mm/yy',
                showOn: "button",
                buttonImage: "../img/calendario.png",
                buttonImageOnly: true,
                buttonText: "Seleccionar Fecha"
            });
        });

        function dateChanged() {
            document.getElementById("formulario").submit();
        }
        ;

    </script>
    <!-- FIN ARCHIVOS CALENDARIO -->
    <script language="javascript">
        var cursor;
        if (document.all) {
            // Está utilizando EXPLORER
            cursor = 'hand';
        } else {
            // Está utilizando MOZILLA/NETSCAPE
            cursor = 'pointer';
        }


        function inicio() {
            document.getElementById("formulario").submit();
        }

        function buscar() {

            document.getElementById("formulario").submit();
        }

        function limpiar() {
            document.getElementById("formulario").reset();
        }
    </script>
</head>
<body onLoad="inicio()">
<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
            <div id="tituloForm" class="header">LIBRO DIARIO</div>
            <div id="frmBusqueda">
                <form id="formulario" name="formulario" method="post" action="rejilla.php" target="frame_rejilla">
                    <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
                        <tr>
                            <td align="right">Fecha de Inicio</td>
                            <td>
                                <input id="fechainicio" type="text" class="cajaPequena" NAME="fechainicio"
                                       maxlength="10" value="<?php echo date("d/m/Y") ?>" readonly onchange="dateChanged()"/></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="right">Fecha de Fin</td>
                            <td>
                                <input id="fechafin" type="text" class="cajaPequena" NAME="fechafin"
                                       maxlength="10" value="<?php echo date("d/m/Y") ?>" readonly onchange="dateChanged()"/>
                            </td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
            </div>
            <div id="botonBusqueda">
                <!--<img src="../img/botonbuscar.jpg" width="69" height="22" border="1" onClick="buscar()" onMouseOver="style.cursor=cursor">-->
                <img src="../img/botonlimpiar.jpg" width="69" height="22" border="1" onClick="limpiar()"
                     onMouseOver="style.cursor=cursor">
            </div>

            <div id="cabeceraResultado" class="header">
                relacion de MOVIMIENTOS
            </div>
            <div id="frmResultado">
                </form>
                <div id="lineaResultado">
                    <iframe width="100%" height="350" id="frame_rejilla" name="frame_rejilla" frameborder="0">
                        <ilayer width="100%" height="350" id="frame_rejilla" name="frame_rejilla"></ilayer>
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
