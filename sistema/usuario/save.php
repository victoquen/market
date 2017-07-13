<?php 
include_once 'class/usuario.php';
include_once '../conexion/conexion.php';
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

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
    $password = $_POST["Apassword"];
    $tipo = $_POST["Acbotipos"];
    $id_facturero = $_POST["Acbofacturero"];
    $id_bodega = $_POST["Acbobodega"];


}

if ($accion == "alta") {
    $usuario = new usuario();
    $result = $usuario->save($conn, $id_facturero, $nombre, $password, $tipo,$id_bodega);

    if ($result) {
        $mensaje = "El usuario ha sido dado de alta correctamente";
        $validacion = 0;
    } else {
        $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   El CODIGO ya existe, ERROR al ingresar el usuario</span>";
        $validacion = 1;
    }
    $cabecera1 = "Inicio >> usuarios &gt;&gt; Nuevo usuario ";
    $cabecera2 = "INSERTAR usuario ";
}

if ($accion == "modificar") {
    $idusuario = $_POST["idusuario"];
    $usuario = new usuario();
    $result = $usuario->update($conn, $idusuario, $id_facturero, $nombre, $password, $tipo,$id_bodega);



    if ($result) {
        $mensaje = "Los datos de la entidad bancaria han sido modificados correctamente";

        $leyendafacturero = "CONTROL TOTAL";
        if ($id_facturero != -1) {
            $rowfacturero = $usuario->get_leyenda_facturero($conn, $id_facturero);
            $leyendafacturero = $rowfacturero['leyendafacturero'];
        }

        $rowbodega = $usuario->get_leyenda_bodega($conn,$id_bodega);
        $leyendabodega = $rowbodega['nombre'];

        $validacion = 0;
    } else {
        $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   El CODIGO ya existe, ERROR al ingresar el usuario</span>";
        $validacion = 1;
    }
    $cabecera1 = "Inicio >> usuarios &gt;&gt; Modificar usuario ";
    $cabecera2 = "MODIFICAR ENTIDAD BANCARIA ";
}

if ($accion == "baja") {
    $idusuario = $_REQUEST["idusuario"];
    $usuario = new usuario();
    $result = $usuario->delete($conn, $idusuario);

    if ($result) {
        $mensaje = "La entidad bancaria ha sido dado de baja correctamente";
        $validacion = 0;
    } else {
        $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'> ERROR al dar de baja el usuario</span>";
        $validacion = 1;
    }
    $cabecera1 = "Inicio >> usuario &gt;&gt; Eliminar usuario ";
    $cabecera2 = "ELIMINAR usuario ";

    $result = $usuario->get_borrado_id($conn, $idusuario);
    $nombre = $result['nombre'];
    $password = $result['password'];
    $tipo = $result['tipo'];
    $id_facturero = $result['id_facturero'];
    $id_bodega = $result['id_bodega'];

    $leyendafacturero = "CONTROL TOTAL";
    if ($id_facturero != -1) {
        $rowfacturero = $usuario->get_leyenda_facturero($conn, $id_facturero);
        $leyendafacturero = $rowfacturero['leyendafacturero'];
    }

    $rowbodega = $usuario->get_leyenda_bodega($conn,$id_bodega);
    $leyendabodega = $rowbodega['nombre'];

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
            <div id="tituloForm" class="header"><?php  echo $cabecera2 ?></div>
            <div id="frmBusqueda">
                <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
                    <tr>
                        <td width="15%"></td>
                        <td width="85%" colspan="2" class="mensaje"><?php  echo $mensaje; ?></td>
                    </tr>
                    <tr>
                        <td width="15%">Nombre</td>
                        <td width="85%" colspan="2"><?php  echo $nombre ?></td>
                    </tr>

                    <tr>
                        <td width="15%"><strong>Password</strong></td>
                        <td width="85%" colspan="2"><?php  echo $password ?></td>
                    </tr>
                    <tr>
                        <td width="15%"><strong>Tipo</strong></td>
                        <td width="85%" colspan="2"><?php  echo $tipo ?></td>
                    </tr>
                    <tr>
                        <td width="15%"><strong>Facturero</strong></td>
                        <td width="85%" colspan="2"><?php  echo $leyendafacturero ?></td>
                    </tr>
                    <tr>
                        <td width="15%"><strong>Bodega-Sucursal</strong></td>
                        <td width="85%" colspan="2"><?php  echo $leyendabodega ?></td>
                    </tr>

                </table>
            </div>
            <div id="botonBusqueda">
                <img src="../img/botonaceptar.jpg" width="85" height="22" onClick="aceptar(<?php  echo $validacion ?>)"
                     border="1" onMouseOver="style.cursor=cursor">
            </div>
        </div>
    </div>
</div>
</body>
</html>