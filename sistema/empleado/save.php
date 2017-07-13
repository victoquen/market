<?php
include_once 'class/empleado.php';
include_once '../conexion/conexion.php';
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

    $nombre = $_POST["Anombre"];
    $cedula = $_POST["Vci_ruc"];
    
}

if ($accion == "alta") {
    $empleado = new Empleado();
    $result = $empleado->save($conn, $nombre, $cedula);

    if ($result) {
        $mensaje = "El empleado ha sido dado de alta correctamente";
        $validacion = 0;
    } else {
        $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   El CODIGO ya existe, ERROR al ingresar el empleado</span>";
        $validacion = 1;
    }
    $cabecera1 = "Inicio >> empleados &gt;&gt; Nuevo empleado ";
    $cabecera2 = "INSERTAR empleado ";
}

if ($accion == "modificar") {
    $idempleado = $_POST["idempleado"];
    $empleado = new Empleado();
    $result = $empleado->update($conn, $idempleado, $nombre, $cedula);



    if ($result) {
        $mensaje = "Los datos de la entidad bancaria han sido modificados correctamente";
        $validacion = 0;
    } else {
        $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   El CODIGO ya existe, ERROR al ingresar el empleado</span>";
        $validacion = 1;
    }
    $cabecera1 = "Inicio >> empleados &gt;&gt; Modificar empleado ";
    $cabecera2 = "MODIFICAR EMPLEADO ";
}

if ($accion == "baja") {
    $idempleado = $_REQUEST["idempleado"];
    $empleado = new Empleado();
    $result = $empleado->delete($conn, $idempleado);

    if ($result) {
        $mensaje = "La entidad bancaria ha sido dado de baja correctamente";
        $validacion = 0;
    } else {
        $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'> ERROR al dar de baja el empleado</span>";
        $validacion = 1;
    }
    $cabecera1 = "Inicio >> empleado &gt;&gt; Eliminar empleado ";
    $cabecera2 = "ELIMINAR empleado ";

    $result = $empleado->get_borrado_id($conn, $idempleado);
    $nombre = $result['nombre'];
    $cedula = $result['Vci_ruc'];



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
                        <td width="15%">Nombre</td>
                        <td width="85%" colspan="2"><?php echo $nombre ?></td>
                    </tr>

                    <tr>
                        <td width="15%"><strong>CEDULA</strong></td>
                        <td width="85%" colspan="2"><?php echo $cedula ?></td>
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