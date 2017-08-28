<?php
include("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$idproducto = $_GET["idproducto"];
$id = $_GET["id"];


$query_l = "SELECT codigo  FROM producto_barracodigo WHERE id = '$id'";
$result_l = mysql_query($query_l, $conn);
$codigo = mysql_result($result_l, 0, "codigo");


?>
<html>
<head>
    <title>Modificar STOCK</title>
    <script>
        var cursor;
        if (document.all) {
            // Está utilizando EXPLORER
            cursor = 'hand';
        } else {
            // Está utilizando MOZILLA/NETSCAPE
            cursor = 'pointer';
        }


        function guardar_articulo() {
            var mensaje = "";
            if (document.getElementById("acodigo").value == "") {
                mensaje += "   - Ingrese el codigo de barras.\n";
            }


            if (mensaje != "") {
                alert("Atencion:\n" + mensaje);
            }
            else {

                document.getElementById("form1").submit();


            }
        }
    </script>
    <link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style type="text/css">
        <!--
        body {
            margin-left: 0px;
            margin-top: 0px;
            margin-right: 0px;
            margin-bottom: 0px;
        }

        -->
    </style>
</head>

<body>
<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
            <div id="tituloForm" class="header">EDITAR CODIGO DE BARRAS</div>
            <div id="frmBusqueda">


                <form name="form1" id="form1" method="get" action="guardar_codigo_final.php">
                    <table class="fuente8" width="95%" id="tabla_resultado" name="tabla_resultado" align="center">

                        <tr>
                            <td width="5%">Codigo Barras:</td>
                            <td width="40%"><input NAME="acodigo" type="text" class="cajaGrande" id="acodigo"
                                                   value="<?php echo $codigo ?>"></td>

                        </tr>

                    </table>


            </div>
        </div>

        <table width="100%" border="0">
            <tr>
                <td>
                    <div align="center">
                        <img src="../img/botonaceptar.jpg" onClick="guardar_articulo()" border="1"
                             onMouseOver="style.cursor=cursor">
                        <img src="../img/botoncerrar.jpg" width="70" height="22" onClick="window.close()" border="1"
                             onMouseOver="style.cursor=cursor">

                    </div>
                </td>
            </tr>
        </table>
        <input id="idproducto" name="idproducto" value="<?php echo $idproducto ?>" type="hidden">
        <input id="id" name="id" value="<?php echo $id ?>" type="hidden">

        </form>


    </div>
</div>


</body>
</html>
