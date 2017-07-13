<?php
include_once 'class/contrato.php';
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

    $nombre = $_POST["Anombre"];
    
}

if ($accion == "alta") {
    $contrato = new Contrato();
    $result = $contrato->save($conn, $nombre);

    if ($result) {
        $mensaje = "El contrato ha sido dado de alta correctamente";
        $validacion = 0;
    } else {
        $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   El CODIGO ya existe, ERROR al ingresar el contrato</span>";
        $validacion = 1;
    }
    $cabecera1 = "Inicio >> contratos &gt;&gt; Nuevo contrato ";
    $cabecera2 = "INSERTAR contrato ";
}

if ($accion == "modificar") {
    $idcontrato = $_POST["idcontrato"];
    $contrato = new Contrato();
    $result = $contrato->update($conn, $idcontrato, $nombre);



    if ($result) {
        $mensaje = "Los datos de la entidad bancaria han sido modificados correctamente";
        $validacion = 0;
    } else {
        $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   El CODIGO ya existe, ERROR al ingresar el contrato</span>";
        $validacion = 1;
    }
    $cabecera1 = "Inicio >> contratos &gt;&gt; Modificar contrato ";
    $cabecera2 = "MODIFICAR contrato ";
}

if ($accion == "baja") {
    $idcontrato = $_REQUEST["idcontrato"];
    $contrato = new Contrato();
    $result = $contrato->delete($conn, $idcontrato);

    if ($result) {
        $mensaje = "La entidad bancaria ha sido dado de baja correctamente";
        $validacion = 0;
    } else {
        $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'> ERROR al dar de baja el contrato</span>";
        $validacion = 1;
    }
    $cabecera1 = "Inicio >> contrato &gt;&gt; Eliminar contrato ";
    $cabecera2 = "ELIMINAR contrato ";

    $result = $contrato->get_borrado_id($conn, $idcontrato);
    $nombre = $result['nombre'];




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