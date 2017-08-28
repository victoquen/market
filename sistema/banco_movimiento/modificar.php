<?php

include("../js/fechas.php");
include_once '../conexion/conexion.php';
include_once 'class/banco_movimiento.php';


$id = $_REQUEST["id"];
$db = new ServidorBaseDatos();
$conn = $db->getConexion();

$obj = new Banco_movimiento();
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
                            <td width="15%">BANCO:</td>
                            <td>
                                <select name="Abanco" id="banco" class="comboMedio" onchange="buscar()">
                                    <option value="0">Seleccionar</option>
                                    <?php
                                    $query_cuenta = "SELECT id_banco, nombre FROM banco WHERE borrado=0";
                                    $sel_query = mysql_query($query_cuenta, $conn);
                                    while ($rowb = mysql_fetch_array($sel_query)) {

                                        if($rowb['id_banco'] == $row['id_banco']){
                                        ?>
                                        <option value="<?php echo $rowb['id_banco'] ?>" selected>
                                            <?php echo $rowb['nombre'] ?>
                                        </option>
                                    <?php } else{ ?>
                                            <option value="<?php echo $rowb['id_banco'] ?>" >
                                                <?php echo $rowb['nombre'] ?>
                                            </option>
                                    <?php } }?>
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
                                    <?php if ($row['operacion'] == "1") { ?>
                                        <option selected value="1">Ingreso</option>
                                        <option value="2">Egreso</option>
                                    <?php } else { ?>
                                        <option value="1">Ingreso</option>
                                        <option selected value="2">Egreso</option>
                                    <?php } ?>

                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td width="15%">ID Transacción</td>
                            <td><input type="text" id="transaccion" name="atransaccion" value="<?php echo $row['transaccion']?>"/></td>
                        </tr>
                        <tr>
                            <td width="15%">Concepto Descripción</td>
                            <td><input type="text" id="descripcion" name="Adescripcion" value="<?php echo $row['descripcion']?>"/></td>
                        </tr>
                        <tr>
                            <td width="15%">Valor monetario</td>
                            <td><input type="text" id="monto" name="Rmonto" value="<?php echo $row['monto']?>"/></td>
                        </tr>
                        <tr>
                            <td width="15%">Fecha movimiento</td>
                            <td>
                                <input id="fecha" type="text" class="cajaPequena" NAME="fecha"
                                       value="<?php echo implota($row['fecha']) ?>" readonly/>
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
