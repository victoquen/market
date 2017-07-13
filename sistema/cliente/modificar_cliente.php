<?php 

$idcliente = $_GET["idcliente"];

include_once '../conexion/conexion.php';
include_once 'class/cliente.php';

$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();


$cliente = new cliente();
$row = $cliente->get_cliente_id($conn, $idcliente);

if ($row['image'] === "") {
    $row['image'] = "person.png";
}

?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8"/>
    <title>Principal</title>
    <link href="../estilos/estilos.css" type="text/css" rel="stylesheet">

    <script type="text/javascript" src="../js/validar.js"></script>
    <script type="text/javascript" src="js/fotografiaJuery.js"></script>
    <script language="javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#image').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function cancelar() {
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

        function limpiar() {
            document.getElementById("formulario").reset();
        }


        function validar_formulario(formulario, val) {
            validar(formulario, val);
        }

        function validar_telefono() {
            var mensaje = "";
            if (document.getElementById("numero").value == "") {
                mensaje += "   - Ingrese numero telefonico.\n";
            }

            if (document.getElementById("operadora").value == "0") {
                mensaje += "   - Escoja operadora.\n"
            }
            if (mensaje != "") {
                alert("Atencion:\n" + mensaje);
            }
            else {
                document.getElementById("formulario_telefonos").submit();
                document.getElementById("numero").value = "";
                document.getElementById("descripcion").value = "";
                document.getElementById("operadora").value = "0";
            }
        }

        function cargar_telefonos() {
            document.getElementById("modif").value = 1;
            document.formulario_telefonos.submit();
            document.getElementById("modif").value = 0;
        }
    </script>
</head>
<body onload="cargar_telefonos()">
<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
            <div id="tituloForm" class="header">MODIFICAR cliente</div>
            <div id="frmBusqueda">
                <form id="formulario" name="formulario" method="post" action="save_cliente.php" enctype="multipart/form-data">
                    <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
                        <tr>
                            <td>ID</td>
                            <td><?php  echo $idcliente ?></td>
                            <td width="42%" rowspan="7" align="left" valign="top">
                                <ul id="lista-errores"></ul>
                            </td>
                        </tr>
                        <tr>
                            <td width="15%">Apellidos - Nombres</td>
                            <td width="43%"><input NAME="Anombres" type="text" class="cajaGrande" id="nombre"
                                                   value="<?php  echo $row['nombre'] ?>" size="44"></td>

                        </tr>

                        <tr>
                            <td width="15%">Empresa</td>
                            <td width="43%"><input NAME="aempresa" type="text" class="cajaGrande" id="empresa"
                                                   value="<?php  echo $row['empresa'] ?>" size="50"></td>
                        </tr>

                        <tr>
                            <td width="15%">CI/RUC</td>
                            <td width="43%"><input NAME="Vci_ruc" type="text" class="cajaGrande" id="cogigo"
                                                   value="<?php  echo $row['ci_ruc'] ?>" size="45" maxlength="45"></td>
                        </tr>
                        <?php 

                        $rows = $cliente->listado_tipocliente($conn);
                        //$rtipo= $cliente->get_nombretipo();
                        ?>
                        <tr>
                            <td width="17%">Tipo</td>
                            <td><select id="cboFamilias" name="Acbotipos" class="comboGrande">
                                    <option value="0">Seleccione un Tipo</option>
                                    <?php 
                                    foreach ($rows as $rowaux => $value) {
                                        if ($rows[$rowaux]['codigo_tipocliente'] == $row['codigo_tipocliente']) {
                                            ?>
                                            <option selected="true"
                                                    value="<?php  echo $rows[$rowaux]['codigo_tipocliente'] ?>"><?php  echo $rows[$rowaux]['nombre'] ?></option>
                                            <?php 
                                        } else {
                                            ?>
                                            <option
                                                value="<?php  echo $rows[$rowaux]['codigo_tipocliente'] ?>"><?php  echo $rows[$rowaux]['nombre'] ?></option>
                                            <?php 
                                        }
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td width="15%">Email</td>
                            <td width="43%"><input NAME="aemail" id="email" type="text" class="cajaGrande1"
                                                   value="<?php  echo $row['email'] ?>" size="35" maxlength="50"></td>
                        </tr>
                        <tr>
                            <td width="17%">Direcci&oacute;n</td>
                            <td><textarea name="adireccion" cols="41" rows="2" id="direccion"
                                          class="areaTexto"><?php  echo $row['direccion'] ?></textarea></td>
                        </tr>
                        <tr>
                            <td width="15%">Lugar/Ciudad</td>
                            <td width="43%"><input NAME="alugar" id="lugar" type="text" class="cajaGrande"
                                                   value="<?php  echo $row['lugar'] ?>" size="35" maxlength="50"></td>
                        </tr>
                        <tr>
                            <td width="15%">Acreedor a Cr&eacute;dito</td>
                            <td width="43%">
                                <select id="credito" name="acredito" class="comboPequeno">
                                    <?php  if ($row['credito'] == "NO") { ?>
                                        <option value="0" selected>No</option>
                                        <option value="1">Si</option>
                                    <?php  } else { ?>
                                        <option value="0">No</option>
                                        <option value="1" selected>Si</option>
                                    <?php  } ?>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td>FOTOGRAFIA</td>
                            <td>

                                <input type='file' id="cliente_image" name="cliente_image" accept="image/*"
                                       onchange=" readURL(this)"/>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <img id="image" name="image" src="fotografias/<?php  echo $row['image']; ?>"
                                     alt="your image" width="150"
                                     height="200"/>
                            </td>
                        </tr>
                    </table>
            </div>
            <div id="botonBusqueda">

                <input id="accion" name="accion" value="modificar" type="hidden">
                <input id="id" name="id" value="" type="hidden">
                <input id="idcliente" name="idcliente" value="<?php  echo $idcliente ?>" type="hidden">
                <input id="userpic" name="userpic" value="<?php  echo $row['image']; ?>" type="hidden"/>
            </div>
            </form>


            <div id="frmBusqueda">
                <form id="formulario_telefonos" name="formulario_telefonos" method="post"
                      action="frame_telefonos_final.php" target="frame_telefonos_final">
                    <div id="tituloForm" class="header">TELEFONOS</div>
                    <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>

                        <?php 

                        $query_o = "SELECT * FROM operadora WHERE borrado=0 ORDER BY nombre ASC";
                        $res_o = mysql_query($query_o, $conn);

                        ?>
                        <tr>
                            <td width="">
                                Numero Telf:&nbsp;
                                <input NAME="numero" type="text" class="cajaPequena" id="numero" maxlength="13">&nbsp;
                                Operadora:&nbsp;
                                <select id="operadora" class="comboMedio" NAME="operadora">
                                    <option value="0">Seleccionar operadora</option>
                                    <?php 
                                    $contador = 0;
                                    while ($contador < mysql_num_rows($res_o)) { ?>
                                        <option
                                            value="<?php  echo mysql_result($res_o, $contador, "id_operadora") ?>"><?php  echo mysql_result($res_o, $contador, "nombre") ?></option>
                                        <?php  $contador++;
                                    } ?>
                                </select>
                                &nbsp;
                                Descripci&oacute;n:&nbsp;
                                <input NAME="descripcion" type="text" class="cajaMedia" id="descripcion" size="45"
                                       maxlength="45">
                                &nbsp;
                                <img src="../img/guardar.png" width="23" height="29" onClick="validar_telefono()"
                                     onMouseOver="style.cursor=cursor" title="Agregar telefono">
                            </td>
                        </tr>
                    </table>
            </div>


            <div id="frmBusqueda">
                <table class="fuente8" width="50%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
                    <tr class="cabeceraTabla">
                        <td width="15%">#</td>
                        <td width="10%">OPERADORA</td>
                        <td width="20%">DESCRIPCION</td>
                        <td width="5%">&nbsp;</td>
                        <td width="5%">&nbsp;</td>
                    </tr>
                </table>
                <div id="lineaResultado">
                    <iframe align="middle" width="100%" height="110" id="frame_telefono" name="frame_telefonos_final"
                            frameborder="0">
                        <ilayer width="100%" height="110" id="frame_telefono" name="frame_telefonos_final"></ilayer>
                    </iframe>


                </div>

            </div>

            <div id="botonBusqueda">

                <img src="../img/botonaceptar.jpg" width="85" height="22" onClick="validar_formulario(formulario,true)"
                     border="1" onMouseOver="style.cursor=cursor">
                <img src="../img/botonlimpiar.jpg" width="69" height="22" onClick="limpiar()" border="1"
                     onMouseOver="style.cursor=cursor">
                <img src="../img/botoncancelar.jpg" width="85" height="22" onClick="cancelar()" border="1"
                     onMouseOver="style.cursor=cursor">


            </div>
            <input id="idcliente" name="idcliente" value="<?php  echo $idcliente ?>" type="hidden">
            <input id="modif" name="modif" value="0" type="hidden">
            </form>


        </div>
    </div>
</div>
</body>
</html>
