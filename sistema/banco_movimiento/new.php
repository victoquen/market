<?php
include("../js/fechas.php");
include_once '../conexion/conexion.php';

$db = new ServidorBaseDatos();
$conn = $db->getConexion();
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8"/>
    <title>Principal</title>
    <link href="../estilos/estilos.css" type="text/css" rel="stylesheet">

    <script type="text/javascript" src="../js/validar.js"></script>


    <!-- INICIO ARCHIVOS CALENDARIO -->
    <link rel="stylesheet" href="../css/jquery-ui.css"/>
    <link rel="stylesheet" href="../css/jquery-ui.min.css"/>
    <link rel="stylesheet" href="../css/jquery-ui.structure.css"/>
    <link rel="stylesheet" href="../css/jquery-ui.structure.min.css"/>
    <script src="../js/jquery-1.12.4.js"></script>
    <script src="../js/1.12.1_jquery-ui..js"></script>

    <script language="javascript">
        $( function() {
            $( "#fecha" ).datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd/mm/yy',
                showOn: "button",
                buttonImage: "../img/calendario.png",
                buttonImageOnly: true,
                buttonText: "Seleccionar Fecha"
            });
        } );
    </script>
    <!-- FIN ARCHIVOS CALENDARIO -->

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

    </script>
</head>
<body>
<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
            <div id="tituloForm" class="header">INSERTAR PARAMETRO ITEM</div>
            <div id="frmBusqueda">
                <form id="formulario" name="formulario" method="post" action="save.php">
                    <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
                        <tr>
                            <td width="15%">BANCO:</td>
                            <td>
                                <select name="Abanco" id="banco" class="comboMedio" onchange="buscar()">
                                    <option value="0">Seleccionar</option>
                                    <?php
                                    $query_cuenta = "SELECT id_banco, nombre FROM banco WHERE borrado=0";
                                    $sel_query = mysql_query($query_cuenta, $conn);
                                    while ($row = mysql_fetch_array($sel_query)) {

                                        ?>
                                        <option
                                            value="<?php echo $row['id_banco'] ?>"><?php echo $row['nombre'] ?></option>
                                    <? } ?>
                                </select>
                            </td>
                            <td width="42%" rowspan="5" align="left" valign="top">
                                <ul id="lista-errores"></ul>
                            </td>
                        </tr>
                        <tr>
                            <td width="15%">OPERACION:</td>
                            <td>
                                <select id="operacion" name="Aoperacion" class="comboGrande">
                                    <option value="0" selected>Seleccione</option>
                                    <option value="1">Ingreso</option>
                                    <option value="2">Egreso</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td width="15%">ID Transacción</td>
                            <td><input type="text" id="transaccion" name="atransaccion"/> </td>
                        </tr>
                        <tr>
                            <td width="15%">Concepto Descripción</td>
                            <td><input type="text" id="descripcion" name="Adescripcion"/> </td>
                        </tr>
                        <tr>
                            <td width="15%">Valor monetario</td>
                            <td><input type="text" id="monto" name="Rmonto"/> </td>
                        </tr>
                        <tr>
                            <td width="15%">Fecha movimiento</td>
                            <td>
                            <input id="fecha" type="text" class="cajaPequena" NAME="fecha"
                                   value="<?php echo date("d/m/Y") ?>" readonly/>
                            </td>

                        </tr>

                    </table>
            </div>

            <div id="botonBusqueda">
                <img src="../img/botonaceptar.jpg" width="85" height="22" onClick="validar(formulario,true)" border="1"
                     onMouseOver="style.cursor=cursor">
                <img src="../img/botonlimpiar.jpg" width="69" height="22" onClick="limpiar()" border="1"
                     onMouseOver="style.cursor=cursor">
                <img src="../img/botoncancelar.jpg" width="85" height="22" onClick="cancelar()" border="1"
                     onMouseOver="style.cursor=cursor">
                <input id="accion" name="accion" value="alta" type="hidden">
                <input id="id" name="Zid" value="" type="hidden">
            </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>