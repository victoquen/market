<html>
<head>
    <title>Cobros</title>
    <link href="../estilos/estilos.css" type="text/css" rel="stylesheet">


    <link rel="stylesheet" href="../css/jquery-ui.css"/>
    <!--<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
     <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>-->
    <script src="../js/jqueryComplementos.js"></script>
    <script src="../js/jquery-ui.js"></script>
    <script src="../js/datepicker_language.js"></script>
    <script language="javascript">
        $(function () {
            $("#fechainicio").datepicker();
        });

        $(function () {
            $("#fechafin").datepicker();
        });
        $(function () {
            $("#Image1").datepicker();
        });

        $(function () {
            $("#Image2").datepicker();
        });

        function dateChanged() {
            document.getElementById("formulario").submit();
        }
        ;

    </script>

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
            <div id="tituloForm" class="header">TOTALES IVA0% IVA12% VENTAS</div>
            <div id="frmBusqueda">
                <form id="formulario" name="formulario" method="post" action="rejilla.php" target="frame_rejilla">
                    <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
                        <tr>
                            <td align="right">Fecha de Inicio</td>
                            <td><input onchange="dateChanged()" id="fechainicio" type="text" class="cajaPequena"
                                       NAME="fechainicio" maxlength="10" readonly/></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="right">Fecha de Fin</td>
                            <td><input onchange="dateChanged()" id="fechafin" type="text" class="cajaPequena"
                                       NAME="fechafin" maxlength="10" value="<?php echo date("d/m/Y") ?>" readonly/>
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
