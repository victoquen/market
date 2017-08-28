<?php
include("../conexion/conexion.php");

$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

?>
<html>
<head>
    <title>Reportes x Cuenta</title>
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
            <div id="tituloForm" class="header">Reportes x Cuenta</div>
            <div id="frmBusqueda">
                <form id="formulario" name="formulario" method="post" action="rejilla.php" target="frame_rejilla">
                    <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
                        <tr>
                            <td width="20%"></td>
                            <td width="13%">Cuenta:</td>

                            <td width="15%" align="right">Fecha Inicio</td>
                            <td width="43%"><input id="fechainicio" type="text" class="cajaPequena" NAME="fechainicio"
                                                   maxlength="10" value="<?php echo date("d/m/Y") ?>" readonly/></td>

                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <select name="cbocuenta" id="cbocuenta" class="comboMedio" onchange="buscar()">
                                    <option value="0">Seleccionar Cuenta</option>
                                    <?php
                                    $query_cuenta = "SELECT id_cuenta, nombre FROM cuenta WHERE gasto=1";
                                    $sel_query = mysql_query($query_cuenta, $conn);
                                    while ($row = mysql_fetch_array($sel_query)) {

                                        ?>
                                        <option
                                            value="<?php echo $row['id_cuenta'] ?>"><?php echo $row['nombre'] ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td width="15%" align="right">Fecha Fin</td>
                            <td width="43%"><input id="fechafin" type="text" class="cajaPequena" NAME="fechafin"
                                                   maxlength="10" value="<?php echo date("d/m/Y") ?>" readonly/></td>

                        </tr>
                        <tr>
                            <td align="right">
                                <input type="submit" value="Buscar"/>
                            </td>
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
