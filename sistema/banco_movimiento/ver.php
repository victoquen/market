<?php
include("../js/fechas.php");
include_once '../conexion/conexion.php';
include_once 'class/banco_movimiento.php';

$id = $_REQUEST["id"];

$db = new ServidorBaseDatos();
$conn = $db->getConexion();

$obj = new Banco_movimiento();
$row = $obj->get_id($conn, $id);


$id_banco = $row['id_banco'];
$operacion = $row['operacion'];
$transaccion = $row['transaccion'];
$descripcion = $row['descripcion'];
$monto = $row['monto'];
$fecha = implota($row['fecha']);
$banco_nombre = $row['nombre'];
if($operacion == 1){
    $operacion_nombre = "INGRESO";
}else{
    $operacion_nombre = "EGRESO";
}

?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8"/>
    <title>Principal</title>
    <link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
    <script language="javascript">

        function aceptar() {
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

    </script>
</head>
<body>
<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
            <div id="tituloForm" class="header">VER PARAMETROS ITEMS</div>
            <div id="frmBusqueda">
                <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
                    <tr>
                        <td width="15%"></td>
                        <td width="85%" colspan="2" class="mensaje"><?php echo $mensaje; ?></td>
                    </tr>
                    <tr>
                        <td width="15%">BANCO</td>
                        <td width="85%" colspan="2"><?php echo $banco_nombre ?></td>
                    </tr>

                    <tr>
                        <td width="15%"><strong>OPERACION</strong></td>
                        <td width="85%" colspan="2"><?php echo $operacion_nombre ?></td>
                    </tr>
                    <tr>
                        <td width="15%"><strong>ID TRANSACCION</strong></td>
                        <td width="85%" colspan="2"><?php echo $transaccion ?></td>
                    </tr>

                    <tr>
                        <td width="15%"><strong>CONCEPTO DESCRIPCION</strong></td>
                        <td width="85%" colspan="2"><?php echo $descripcion ?></td>
                    </tr>
                    <tr>
                        <td width="15%"><strong>MONTO</strong></td>
                        <td width="85%" colspan="2">$ <?php echo $monto ?></td>
                    </tr>

                    <tr>
                        <td width="15%"><strong>FECHA</strong></td>
                        <td width="85%" colspan="2"><?php echo $fecha ?></td>
                    </tr>

                </table>
            </div>
            <div id="botonBusqueda">
                <img src="../img/botonaceptar.jpg" width="85" height="22" onClick="aceptar()" border="1"
                     onMouseOver="style.cursor=cursor">
            </div>
        </div>
    </div>
</div>
</body>
</html>
