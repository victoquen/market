<?php 
include_once 'class/cliente.php';
include_once '../conexion/conexion.php';
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

error_reporting(0);


$accion = $_REQUEST["accion"];
if (!isset($accion)) {
    $accion = $_GET["accion"];
    if (!isset($accion)) {
        $accion = $_REQUEST["accion"];
    }
}

if ($accion != "baja") {
    $codclientetmp = $_POST["codclientetmp"];
    $origen = $_POST["origen"];


    $nombres = strtoupper($_POST["Anombres"]);
    $apellidos = strtoupper($_POST["Aapellidos"]);
    if ($nombres) {
        if ($apellidos) {
            $nombre = $apellidos . " " . $nombres;
        } else {
            $nombre = $nombres;
        }
    }

    $empresa = strtoupper($_POST["aempresa"]);
    $ci_ruc = $_POST["Vci_ruc"];
    $tipo = $_POST["Acbotipos"];

    $email = $_POST["aemail"];
    $direccion = strtoupper($_POST["adireccion"]);
    $lugar = strtoupper($_POST["alugar"]);
    $credito = $_POST["acredito"];
    $cliente = new cliente();
    $resultt = $cliente->get_nombretipo($tipo, $conn);
    $nombre_tipo = $resultt["nombre"];

    if ($credito == 0) {
        $credito_nombre = "NO";
    } else {
        $credito_nombre = "SI";
    }

    $imgFile = $_FILES['cliente_image']['name'];
    $tmp_dir = $_FILES['cliente_image']['tmp_name'];
    $imgSize = $_FILES['cliente_image']['size'];

}

if ($accion == "alta") {


    if (!empty($imgFile)) {
        $upload_dir = 'fotografias/'; // upload directory
        $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension
        // valid image extensions
        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
        // rename uploading image
        $userpic = rand(1000, 1000000) . "." . $imgExt;
        // allow valid image file formats
        if (in_array($imgExt, $valid_extensions)) {
            // Check file size '5MB'
            if ($imgSize < 5000000) {
                move_uploaded_file($tmp_dir, $upload_dir . $userpic);
            } else {
                $errMSG = "Sorry, your file is too large.";
            }
        } else {
            $errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed. Ext: " . $imgExt . " Size: " . $imgSize . " File: " . $imgFile;
        }
    }


    if (!isset($errMSG)) {
        $cliente = new cliente();
        $idcliente = $cliente->save_cliente($conn, $tipo, $nombre, $empresa, $ci_ruc, $email, $direccion, $lugar, $credito, $userpic);
    }
    if ($idcliente) {
        $mensaje = "El cliente ha sido dado de alta correctamente";
        $validacion = 0;

        $query_tmp = "SELECT * FROM clientefonotmp WHERE idcliente='$codclientetmp' ORDER BY numfono ASC";
        $rs_tmp = mysql_query($query_tmp, $conn);
        $contador = 0;

        include("class/clientefono.php");
        $telefono = new Clientefono();
        $num_rows = mysql_num_rows($rs_tmp);
        while ($contador < $num_rows) {
            $numero = mysql_result($rs_tmp, $contador, "numero");
            $descripcion = mysql_result($rs_tmp, $contador, "descripcion");
            $operadora = mysql_result($rs_tmp, $contador, "operadora");
            $result = $telefono->save_telefono($conn, $idcliente, $numero, $descripcion, $operadora);
            $contador++;
        }

        $query = "DELETE FROM clientefonotmp WHERE idcliente='$codclientetmp'";
        $rs = mysql_query($query, $conn);
        $query = "DELETE FROM clientetmp WHERE idcliente='$codclientetmp'";
        $rs = mysql_query($query, $conn);
    } else {
        $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   El CI/RUC ya existe, ERROR al ingresar el cliente</span>";
        $validacion = 1;
    }
    $cabecera1 = "Inicio >> clientees &gt;&gt; Nuevo cliente ";
    $cabecera2 = "INSERTAR cliente ";
}

if ($accion == "modificar") {

    $userpic = $_POST["userpic"];

    if (!empty($imgFile)) {
        $upload_dir = 'fotografias/'; // upload directory
        $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension
        // valid image extensions
        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
        // rename uploading image
        $userpic = rand(1000, 1000000) . "." . $imgExt;
        // allow valid image file formats
        if (in_array($imgExt, $valid_extensions)) {
            // Check file size '5MB'
            if ($imgSize < 5000000) {

                move_uploaded_file($tmp_dir, $upload_dir . $userpic);
            } else {
                $errMSG = "Sorry, your file is too large.";
            }
        } else {
            $errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed. Ext: " . $imgExt . " Size: " . $imgSize . " File: " . $imgFile;
        }
    }


    if (!isset($errMSG)) {
        $idcliente = $_POST["idcliente"];
        $cliente = new cliente();
        $result = $cliente->update_cliente($conn, $tipo, $idcliente, $nombre, $empresa, $ci_ruc, $email, $direccion, $lugar, $credito,$userpic);
    }


    if ($result) {
        $mensaje = "Los datos del cliente han sido modificados correctamente";
        $validacion = 0;
    } else {
        $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   El CODIGO ya existe, ERROR al ingresar el cliente</span>";
        $validacion = 1;
    }
    $cabecera1 = "Inicio >> clientees &gt;&gt; Modificar cliente ";
    $cabecera2 = "MODIFICAR cliente ";
}

if ($accion == "baja") {
    $idcliente = $_REQUEST["idcliente"];
    $cliente = new cliente();
    $result = $cliente->delete_cliente($conn, $idcliente);

    if ($result) {
        $mensaje = "El cliente ha sido dado de baja correctamente";
        $validacion = 0;
    } else {
        $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'> ERROR al dar de baja el cliente</span>";
        $validacion = 1;
    }
    $cabecera1 = "Inicio >> cliente &gt;&gt; Eliminar cliente ";
    $cabecera2 = "ELIMINAR cliente ";

    $result = $cliente->get_cliente_borrado_id($conn, $idcliente);

    $nombre = $result["nombre"];
    $empresa = $result["empresa"];
    $ci_ruc = $result["ci_ruc"];

    $email = $result["email"];
    $direccion = $result["direccion"];
    $lugar = $result["lugar"];
    $credito = $credito["credito"];

    $nombre_tipo = $result["tipocliente"];
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

        function ingreso_factura(validacion, id, nombre, ci_ruc, tipocliente) {
            if (validacion == 0) {
                parent.opener.document.formulario.codcliente.value = id;
                parent.opener.document.formulario.nombre.value = nombre;
                parent.opener.document.formulario.ci_ruc.value = ci_ruc;
                parent.opener.document.formulario.tipo_cliente.value = tipocliente;
                parent.window.close();
            }
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
                        <td width="85%" colspan="2" class="mensaje"><?php  echo $mensaje; ?>--<?php  echo $errMSG ?></td>
                    </tr>
                    <tr>
                        <td width="15%">Nombre</td>
                        <td width="85%" colspan="2"><?php  echo $nombre ?></td>
                    </tr>
                    <tr>
                        <td width="15%">Empresa</td>
                        <td width="85%" colspan="2"><?php  echo $empresa ?></td>
                    </tr>
                    <tr>
                        <td width="15%">CI/RUC</td>
                        <td width="85%" colspan="2"><?php  echo $ci_ruc ?></td>
                    </tr>
                    <tr>
                        <td width="15%">Tipo</td>
                        <td width="85%" colspan="2"><?php  echo $nombre_tipo ?></td>
                    </tr>
                    <tr>
                        <td width="15%">Email</td>
                        <td width="85%" colspan="2"><?php  echo $email ?></td>
                    </tr>
                    <tr>
                        <td width="15%">Direcci&oacute;n</td>
                        <td width="85%" colspan="2"><?php  echo $direccion ?></td>
                    </tr>
                    <tr>
                        <td width="15%">Lugar</td>
                        <td width="85%" colspan="2"><?php  echo $lugar ?></td>
                    </tr>
                    <tr>
                        <td width="15%">Credito</td>
                        <td width="85%" colspan="2"><?php  echo $credito_nombre ?></td>
                    </tr>

                    <tr>
                        <td colspan="2" width="100%">Tel&eacute;fono(s):</td>
                    </tr>
                    <?php 
                    $query_fono = "SELECT numero, operadora, descripcion FROM clientefono WHERE id_cliente='$idcliente'";
                    $rs_fono = mysql_query($query_fono, $conn);
                    if ($rs_fono) {
                        $contador = 0;
                        $num_rows_fono = mysql_num_rows($rs_fono);
                        while ($contador < $num_rows_fono) {

                            ?>
                            <tr>
                                <td colspan="2" width="100%">
                                    <BLOCKQUOTE>
                                        <?php 
                                        $id_operadora = mysql_result($rs_fono, $contador, 'operadora');
                                        $query_operadora = "SELECT nombre FROM operadora WHERE id_operadora='$id_operadora'";
                                        $rs_operadora = mysql_query($query_operadora, $conn);
                                        echo mysql_result($rs_fono, $contador, 'numero') . "(" . mysql_result($rs_operadora, 0, 'nombre') . ") " . mysql_result($rs_fono, $contador, 'descripcion');
                                        ?>
                                    </BLOCKQUOTE>
                                </td>
                            </tr>
                            <?php 
                            $contador++;
                        }
                    }
                    ?>
                    <tr>
                        <td></td>
                        <td>
                            <img src="fotografias/<?php  echo $userpic; ?>" class="img-rounded" width="150px"
                                 height="200px"/>
                        </td>
                    </tr>
                </table>
            </div>
            <div id="botonBusqueda">
                <?php  if ($origen == "factura") { ?>
                    <img src="../img/botonaceptar.jpg" width="85" height="22"
                         onClick="ingreso_factura(<?php  echo $validacion ?>,'<?php  echo $idcliente ?>','<?php  echo $nombre ?>','<?php  echo $ci_ruc ?>','<?php  echo $nombre_tipo ?>')"
                         border="1" onMouseOver="style.cursor=cursor">
                <?php  } else { ?>
                    <img src="../img/botonaceptar.jpg" width="85" height="22"
                         onClick="aceptar(<?php  echo $validacion ?>)" border="1" onMouseOver="style.cursor=cursor">
                <?php  } ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>