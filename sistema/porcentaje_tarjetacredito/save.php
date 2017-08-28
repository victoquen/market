<?php
include_once 'class/porcentaje_tarjetacredito.php';
include_once '../conexion/conexion.php';
$db = new ServidorBaseDatos();
$conn = $db->getConexion();

error_reporting(0);

$accion = $_REQUEST["accion"];
if (!isset($accion)) {
    $accion = $_GET["accion"];
    if (!isset($accion)) {
        $accion = $_REQUEST["accion"];
    }
}

if ($accion != "baja") {


    $porcentaje = $_POST["Rporcentaje"];
    
}

if ($accion == "alta") {
    $obj = new Porcentaje_tarjetacredito();
    $result = $obj->save($conn, $porcentaje);

    if ($result) {
        $mensaje = "El ingreso ha sido dado de alta correctamente";
        $validacion = 0;
    } else {
        $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   El CODIGO ya existe, ERROR al ingresar</span>";
        $validacion = 1;
    }
    $cabecera1 = "Inicio >> % TARJETA CREDITO &gt;&gt; Nuevo % TARJETA CREDITO ";
    $cabecera2 = "INSERTAR TARJETA CREDITO ";
}

if ($accion == "modificar") {
    $id = $_POST["id"];
    $obj = new Porcentaje_tarjetacredito();
    $result = $obj->update($conn, $id, $porcentaje);



    if ($result) {
        $mensaje = "Los datos  han sido modificados correctamente";
        $validacion = 0;
    } else {
        $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   El CODIGO ya existe, ERROR al ingresar</span>";
        $validacion = 1;
    }
    $cabecera1 = "Inicio >> % TARJETA CREDITO &gt;&gt; Modificar % TARJETA CREDITO ";
    $cabecera2 = "MODIFICAR % TARJETA CREDITO ";
}

if ($accion == "baja") {
    $id = $_REQUEST["id"];
    $obj = new Param_item();
    $result = $obj->delete($conn, $id);

    if ($result) {
        $mensaje = "La informacion ha sido dado de baja correctamente";
        $validacion = 0;
    } else {
        $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'> ERROR al dar de baja</span>";
        $validacion = 1;
    }
    $cabecera1 = "Inicio >> % TARJETA CREDITO &gt;&gt; Eliminar % TARJETA CREDITO ";
    $cabecera2 = "ELIMINAR % TARJETA CREDITO";

    $result = $obj->get_borrado_id($conn, $id);
    $porcentaje = $result['porcentaje'];




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
                        <td width="15%"><strong>% TARJETA DE CREDITO</strong></td>
                        <td width="85%" colspan="2"><?php echo $porcentaje ?></td>
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