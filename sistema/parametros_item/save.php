<?php
include_once 'class/param_item.php';
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

    $serie_unica = $_POST["Aserie_unica"];
    $item = $_POST["Zitem"];
    
}

if ($accion == "alta") {
    $obj = new Param_item();
    $result = $obj->save($conn, $serie_unica, $item);

    if ($result) {
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
    $obj = new Param_item();
    $result = $obj->update($conn, $id, $serie_unica, $item);



    if ($result) {
        $mensaje = "Los datos  han sido modificados correctamente";
        $validacion = 0;
    } else {
        $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   El CODIGO ya existe, ERROR al ingresar</span>";
        $validacion = 1;
    }
    $cabecera1 = "Inicio >> empleados &gt;&gt; Modificar empleado ";
    $cabecera2 = "MODIFICAR EMPLEADO ";
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
    $cabecera1 = "Inicio >> PARAMETRO ITEM &gt;&gt; Eliminar PARAMETRO ITEM ";
    $cabecera2 = "ELIMINAR PARAMETRO ITEM ";

    $result = $obj->get_borrado_id($conn, $id);
    $serie_unica = $result['serie_unica'];
    $item = $result['item'];



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
                        <td width="15%">SERIE UNICA</td>
                        <td width="85%" colspan="2"><?php echo $serie_unica ?></td>
                    </tr>

                    <tr>
                        <td width="15%"><strong># ITEMS</strong></td>
                        <td width="85%" colspan="2"><?php echo $item ?></td>
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