<?php


include_once '../conexion/conexion.php';
include_once 'class/param_item.php';


$id = $_REQUEST["id"];
$db = new ServidorBaseDatos();
$conn = $db->getConexion();

$obj = new Param_item();
$row = $obj->get_id($conn, $id);


?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8"/>
    <title>Principal</title>
    <link href="../estilos/estilos.css" type="text/css" rel="stylesheet">

    <script type="text/javascript" src="../js/validar.js"></script>
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
            <div id="tituloForm" class="header">MODIFICAR PARAMETROS ITEMS</div>
            <div id="frmBusqueda">
                <form id="formulario" name="formulario" method="post" action="save.php">
                    <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
                        <tr>
                            <td>ID</td>
                            <td><?php echo $id ?></td>
                            <td width="42%" rowspan="14" align="left" valign="top">
                                <ul id="lista-errores"></ul>
                            </td>
                        </tr>
                        <tr>
                            <td width="15%">SERIE UNICA</td>
                            <td>
                                <select id="Aserie_unica" name="Aserie_unica" class="comboGrande">
                                    <?php if ($row['serie_unica'] == "2") { ?>
                                        <option selected value="2">NO</option>
                                        <option value="1">SI</option>
                                    <?php } else { ?>
                                        <option value="2">NO</option>
                                        <option selected value="1">SI</option>
                                    <?php } ?>
                                </select>
                            </td>

                        </tr>

                        <tr>
                            <td width="15%"># ITEMS</td>
                            <td width="43%"><input NAME="Zitem" type="text" id="item" value="<?php echo $row['item'] ?>"
                                                   size="45" maxlength="45"></td>

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
                <input id="accion" name="accion" value="modificar" type="hidden">
                <input id="id" name="id" value="" type="hidden">
                <input id="id" name="id" value="<?php echo $id ?>" type="hidden">
            </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
