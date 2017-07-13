<?php
include_once '../conexion/conexion.php';

$db = new ServidorBaseDatos();
$conn = $db->getConexion();



?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
        <title>Principal</title>
        <link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="../css/jquery-ui.css"/>
        
        <script src="../js/jqueryComplementos.js"></script>
        <script src="../js/jquery-ui.js"></script>
        <script src="../js/datepicker_language.js"></script>
        <script language="javascript">
            $(function () {
                $("#fechainicio").datepicker();
            });

            $(function () {
                $("#fechafin").datepicker();
            });
            $(function () {
                $("#Image1").datepicker();
            });

            $(function () {
                $("#Image2").datepicker();
            });

            function dateChanged() {
                document.getElementById("formulario").submit();
            }
            ;

        </script>
       
        <script type="text/javascript" src="../js/validar.js"></script>
        <script language="javascript">

        function cancelar() {
                location.href="index.php";
        }

        var cursor;
        if (document.all) {
        // Está utilizando EXPLORER
        cursor='hand';
        } else {
        // Está utilizando MOZILLA/NETSCAPE
        cursor='pointer';
        }

        function limpiar() {
                document.getElementById("formulario").reset();
        }

        </script>
    </head>
    <body>
        <div id="pagina">
            <div id="zonaContenido">
                <div align="center">
                    <div id="tituloForm" class="header">INSERTAR ENTIDAD BANCARIA </div>
                    <div id="frmBusqueda">
                        <form id="formulario" name="formulario" method="post" action="save.php">
                            <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>

                                <?php
                                $query_o = "SELECT id, CONCAT( nombre,  '-', cedula ) AS emple FROM empleado ";
                                $res_o = mysql_query($query_o, $conn);
                                ?>
                                <tr>
                                    <td width="15%">Empleado</td>
                                    <td width="43%">
                                        <select id="Acboempleado" class="comboMedio" NAME="Acboempleado">
                                            <option  value="">Escoger Empleado</option>
                                            <?php
                                            $contador = 0;
                                            while ($contador < mysql_num_rows($res_o)) {
                                                ?>
                                                <option value="<?php echo mysql_result($res_o, $contador, "id") ?>"><?php echo mysql_result($res_o, $contador, "emple") ?></option>
                                                <?php $contador++;
                                            }?>
                                        </select>

                                    </td>
                                    <td width="42%" rowspan="8" align="left" valign="top"><ul id="lista-errores"></ul></td>
                                </tr>


                                <?php
                                $query_a = "SELECT id, nombre FROM contrato ";
                                $res_a= mysql_query($query_a, $conn);
                                ?>
                                <tr>
                                    <td width="">Contrato</td>
                                    <td>
                                        <select id="Acbocontrato" class="comboMedio" NAME="Acbocontrato">
                                            <option  value="">Escoger Contrato</option>
                                            <?php
                                            $contador1 = 0;
                                            while ($contador1 < mysql_num_rows($res_a)) {
                                                ?>
                                                <option value="<?php echo mysql_result($res_a, $contador1, "id") ?>"><?php echo mysql_result($res_a, $contador1, "nombre") ?></option>
                                                <?php $contador1++;
                                            }?>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="15%">Fecha Inicio</td>
                                    <td width="43%"><input id="fechainicio" type="text" class="cajaPequena" NAME="fechainicio" maxlength="10" value="<?php echo date("d/m/Y") ?>" readonly/></td>

                                </tr>

                                <tr>
                                    <td width="15%">Fecha Fin</td>
                                    <td width="43%"><input id="fechafin" type="text" class="cajaPequena" NAME="fechafin" maxlength="10" value="<?php echo date("d/m/Y") ?>" readonly/></td>
                                </tr>

                                <tr>
                                    <td width="15%">Codigo Contrato</td>
                                    <td width="43%"><input id="codigo" type="text" class="cajaGrande" NAME="codigo"  /></td>
                                </tr>

                                <tr>
                                    <td width="15%">Sueldo</td>
                                    <td width="43%"><input id="Asueldo" type="text" class="cajaPequena" NAME="Asueldo"  /></td>
                                </tr>

                            </table>
                    </div>

                    <div id="botonBusqueda">
                        <img src="../img/botonaceptar.jpg" width="85" height="22" onClick="validar(formulario,true)" border="1" onMouseOver="style.cursor=cursor">
                        <img src="../img/botonlimpiar.jpg" width="69" height="22" onClick="limpiar()" border="1" onMouseOver="style.cursor=cursor">
                        <img src="../img/botoncancelar.jpg" width="85" height="22" onClick="cancelar()" border="1" onMouseOver="style.cursor=cursor">
                        <input id="accion" name="accion" value="alta" type="hidden">
                        <input id="id" name="Zid" value="" type="hidden">
                    </div>
            </form>
            </div>
            </div>
        </div>
    </body>
</html>