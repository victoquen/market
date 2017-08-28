<?php
include("../conexion/conexion.php");

$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8"/>
    <title>empleadoS</title>
    <link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
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
            document.getElementById("form_busqueda").submit();
        }

        function nuevo() {
            location.href = "new.php";
        }

        function buscar() {

            document.getElementById("form_busqueda").submit();
        }
    </script>
</head>
<body onLoad="inicio()">
<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
            <div id="tituloForm" class="header">ITEMS PARAMETROS</div>
            <div id="frmBusqueda">
                <form id="form_busqueda" name="form_busqueda" method="post" action="rejilla.php" target="frame_rejilla">
                    <table class="fuente8" width="35%" cellspacing=0 cellpadding=3 border=0>
                        <tr>
                            <td>
                                BANCO:
                                <select name="cbobanco" id="cbobanco" class="comboMedio" onchange="buscar()">
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
                            <td>
                                <img src="../img/icono_nuevo.jpg" title="nuevo" border="0" width="30" height="30"
                                     border="1"
                                     onClick="nuevo()" onMouseOver="style.cursor=cursor">
                            </td>
                        </tr>

                    </table>

            </div>

            </form>

            <div id="lineaResultado">
                <iframe width="100%" height="800px" id="frame_rejilla" name="frame_rejilla" frameborder="0">
                    <ilayer width="100%" height="800px" id="frame_rejilla" name="frame_rejilla"></ilayer>
                </iframe>
            </div>
           
        </div>
    </div>
</div>
</body>
</html>
