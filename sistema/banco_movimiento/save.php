<?php
include_once 'class/banco_movimiento.php';
include_once '../conexion/conexion.php';
include("../js/fechas.php");
$db = new ServidorBaseDatos();
$conn = $db->getConexion();

//error_reporting(0);

$accion = $_REQUEST["accion"];
if (!isset($accion)) {
    $accion = $_GET["accion"];
    if (!isset($accion)) {
        $accion = $_REQUEST["accion"];
    }
}

if ($accion != "baja") {


    $id_banco = $_POST['Abanco'];
    $operacion = $_POST['Aoperacion'];
    $transaccion = $_POST['atransaccion'];
    $descripcion = $_POST['Adescripcion'];
    $monto = $_POST['Rmonto'];
    $fecha = explota($_POST['fecha']);
    if($operacion == 1){
        $operacion_nombre = "INGRESO";
    }else{
        $operacion_nombre = "EGRESO";
    }

}

if ($accion == "alta") {
    $obj = new Banco_movimiento();
    $result = $obj->save($conn, $id_banco, $operacion, $transaccion, $descripcion, $monto, $fecha);

    if ($result) {
        $re_b = $obj->get_id($conn, $result);
        $banco_nombre = $re_b['nombre'];
        $mensaje = "El ingreso ha sido dado de alta correctamente";
        $validacion = 0;
    } else {
        $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   El CODIGO ya existe, ERROR al ingresar</span>";
        $validacion = 1;
    }
    $cabecera1 = "Inicio >> empleados &gt;&gt; Nuevo empleado ";
    $cabecera2 = "INSERTAR empleado ";
}

if ($accion == "modificar") {
    $id = $_POST["id"];
    $obj = new Banco_movimiento();
    $result = $obj->update($conn, $id, $id_banco, $operacion, $transaccion, $descripcion, $monto, $fecha);


    if ($result) {

        $re_b = $obj->get_id($conn, $id);
        $banco_nombre = $re_b['nombre'];

        $mensaje = "Los datos  han sido modificados correctamente";
        $validacion = 0;
    } else {
        $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   El CODIGO ya existe, ERROR al ingresar</span>";
        $validacion = 1;
    }
    $cabecera1 = "Inicio >> MOVIMIENTOS &gt;&gt; Modificar MOVIMIENTOS BANCOS ";
    $cabecera2 = "MODIFICAR EMPLEADO ";
}

if ($accion == "baja") {
    $id = $_REQUEST["id"];
    $obj = new Banco_movimiento();
    $result = $obj->delete($conn, $id);

    if ($result) {
        $mensaje = "La informacion ha sido dado de baja correctamente";
        $validacion = 0;
    } else {
        $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'> ERROR al dar de baja</span>";
        $validacion = 1;
    }
    $cabecera1 = "Inicio >> MOVIMIENTO &gt;&gt; Eliminar MOVIMIENTO BANCO ";
    $cabecera2 = "ELIMINAR MOVIMIENTO BANCO ";

    $result = $obj->get_borrado_id($conn, $id);

    $id_banco = $result['Abanco'];
    $operacion = $result['Aoperacion'];
    $transaccion = $result['atransaccion'];
    $descripcion = $result['Adescripcion'];
    $monto = $result['Rmonto'];
    $fecha = implota($result['fecha']);
    $banco_nombre = $result['nombre'];
    if($operacion == 1){
        $operacion_nombre = "INGRESO";
    }else{
        $operacion_nombre = "EGRESO";
    }
}
?>


<html>
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8"/>
    <title>Principal</title>
    <link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
    <script language="javascript">

        function aceptar(validacion) {
            if (validacion == 0)
                location.href = "index.php";
            else
                history.back();
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
            <div id="tituloForm" class="header"><?php echo $cabecera2 ?></div>
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
                <img src="../img/botonaceptar.jpg" width="85" height="22" onClick="aceptar(<?php echo $validacion ?>)"
                     border="1" onMouseOver="style.cursor=cursor">
            </div>
        </div>
    </div>
</div>
</body>
</html>