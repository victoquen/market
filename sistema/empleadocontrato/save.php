<?php
include_once 'class/Relacion_empleado_contrato.php';
include_once '../conexion/conexion.php';
include ("../js/fechas.php");

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

    
    $id_empleado =  $_POST["Acboempleado"];
    $id_contrato =  $_POST["Acbocontrato"];
    $fecha_inicio =  explota($_POST["fechainicio"]);
    $fecha_fin =  explota($_POST["fechafin"]);
    $codigo =  $_POST["codigo"];
    $sueldo =  $_POST["Asueldo"];

}

if ($accion == "alta") {
    $relacion_empleado_contrato = new Relacion_empleado_contrato();

    $result_desactivados = $relacion_empleado_contrato->update_desactivados($conn, $id_empleado);
    $result = $relacion_empleado_contrato->save($conn, $id_empleado, $id_contrato, $fecha_inicio, $fecha_fin, $codigo, $sueldo);

    if ($result) {
        $mensaje = "El relacion_empleado_contrato ha sido dado de alta correctamente";

        $rowempleado = $relacion_empleado_contrato->get_leyenda_empleado($conn,$id_empleado);
        $leyendaempleado = $rowempleado['leyendaempleado'];

        $rowcontrato = $relacion_empleado_contrato->get_leyenda_contrato($conn,$id_contrato);
        $leyendacontrato = $rowcontrato['leyendacontrato'];

        $leyendaactivo = "SI";


        $validacion = 0;
    } else {
        $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   El CODIGO ya existe, ERROR al ingresar el relacion_empleado_contrato</span>";
        $validacion = 1;
    }
    $cabecera1 = "Inicio >> relacion_empleado_contratos &gt;&gt; Nuevo relacion_empleado_contrato ";
    $cabecera2 = "INSERTAR relacion_empleado_contrato ";
}

if ($accion == "modificar") {
    $idrelacion_empleado_contrato = $_POST["idrelacion_empleado_contrato"];
    $relacion_empleado_contrato = new Relacion_empleado_contrato();
    $result = $relacion_empleado_contrato->update($conn, $idrelacion_empleado_contrato, $id_empleado, $id_contrato, $fecha_inicio, $fecha_fin, $codigo, $sueldo);



    if ($result) {
        $mensaje = "Los datos de la contratacion empleado han sido modificados correctamente";

        $rowempleado = $relacion_empleado_contrato->get_leyenda_empleado($conn,$id_empleado);
        $leyendaempleado = $rowempleado['leyendaempleado'];

        $rowcontrato = $relacion_empleado_contrato->get_leyenda_contrato($conn,$id_contrato);
        $leyendacontrato = $rowempleado['leyendacontrato'];

        $validacion = 0;
    } else {
        $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   El CODIGO ya existe, ERROR al ingresar el relacion_empleado_contrato</span>";
        $validacion = 1;
    }
    $cabecera1 = "Inicio >> relacion_empleado_contratos &gt;&gt; Modificar relacion_empleado_contrato ";
    $cabecera2 = "MODIFICAR CONTRATACION EMPLEADO ";
}

if ($accion == "baja") {
    $idrelacion_empleado_contrato = $_REQUEST["idrelacion_empleado_contrato"];
    $relacion_empleado_contrato = new Relacion_empleado_contrato();
    $result = $relacion_empleado_contrato->delete($conn, $idrelacion_empleado_contrato);

    if ($result) {
        $mensaje = "La entidad bancaria ha sido dado de baja correctamente";
        $validacion = 0;
    } else {
        $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'> ERROR al dar de baja el relacion_empleado_contrato</span>";
        $validacion = 1;
    }
    $cabecera1 = "Inicio >> relacion_empleado_contrato &gt;&gt; Eliminar relacion_empleado_contrato ";
    $cabecera2 = "ELIMINAR relacion_empleado_contrato ";

    $result = $relacion_empleado_contrato->get_borrado_id($conn, $idrelacion_empleado_contrato);


    $id_empleado =   $result['Acboempleado'];
    $id_contrato =  $result['Acbocontrato'];
    $fecha_inicio =   $result['fechainicio'];
    $fecha_fin =   $result['fechafin'];
    $codigo =  $result['codigo'];
    $sueldo =   $result['Asueldo'];

    $rowempleado = $relacion_empleado_contrato->get_leyenda_empleado($conn,$id_empleado);
    $leyendaempleado = $rowempleado['leyendaempleado'];

    $rowcontrato = $relacion_empleado_contrato->get_leyenda_contrato($conn,$id_contrato);
    $leyendacontrato = $rowcontrato['leyendacontrato'];

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
                        <td width="15%"><strong>Empleado</strong></td>
                        <td width="85%" colspan="2"><?php echo $leyendaempleado ?></td>
                    </tr>
                    <tr>
                        <td width="15%"><strong>Contrato</strong></td>
                        <td width="85%" colspan="2"><?php echo $leyendacontrato ?></td>
                    </tr>
                    <tr>
                        <td width="15%"><strong>Fecha Inicio</strong></td>
                        <td width="85%" colspan="2"><?php echo implota($fecha_inicio) ?></td>
                    </tr>
                    <tr>
                        <td width="15%"><strong>Fecha Fin</strong></td>
                        <td width="85%" colspan="2"><?php echo implota($fecha_fin) ?></td>
                    </tr>

                    <tr>
                        <td width="15%"><strong>Codigo Contrato</strong></td>
                        <td width="85%" colspan="2"><?php echo $codigo ?></td>
                    </tr>

                    <tr>
                        <td width="15%"><strong>Sueldo</strong></td>
                        <td width="85%" colspan="2"><?php echo $sueldo ?></td>
                    </tr>
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