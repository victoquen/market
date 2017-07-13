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
                    <div id="tituloForm" class="header">INSERTAR USUARIO </div>
                    <div id="frmBusqueda">
                        <form id="formulario" name="formulario" method="post" action="save.php">
                            <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>                                
                                <tr>
                                    <td width="15%">Nombre</td>
                                    <td width="43%"><input NAME="Anombre" type="text"  id="nombre" size="45" maxlength="45"></td>
                                    <td width="42%" rowspan="8" align="left" valign="top"><ul id="lista-errores"></ul></td>
                                </tr>

                                <tr>
                                    <td width="15%">Password</td>
                                    <td width="43%"><input NAME="Apassword" type="text"  id="password"  size="45" maxlength="45"></td>

                                </tr>


                                <tr>
                                    <td width="17%">Tipo de USUARIO</td>
                                    <td><select id="Acbotipos" name="Acbotipos" class="comboGrande">
                                            <option value="">Escoger Tipo</option>
                                            <option value="administrador">administrador</option>
                                            <option value="facturacion">facturacion</option>

                                        </select>
                                    </td>
                                </tr>

                                <?php 

                                $query_o = "SELECT id_facturero, CONCAT( serie1,  '-', serie2 ) AS leyendafacturero FROM facturero ";
                                $res_o = mysql_query($query_o, $conn);

                                ?>
                                <tr>
                                    <td width="">Facturero:</td>
                                    <td>
                                        <select id="Acbofacturero" class="comboMedio" NAME="Acbofacturero">
                                            <option  value="">Escoger Facturero</option>
                                            <option  value="-1">CONTROL TOTAL</option>
                                            <?php 
                                            $contador = 0;
                                            while ($contador < mysql_num_rows($res_o)) {
                                                ?>
                                                <option
                                                    value="<?php  echo mysql_result($res_o, $contador, "id_facturero") ?>"><?php  echo mysql_result($res_o, $contador, "leyendafacturero") ?></option>
                                                <?php  $contador++;
                                            }?>
                                        </select>

                                    </td>
                                </tr>

                                <?php 

                                $query_b = "SELECT id_bodega, nombre FROM bodega";
                                $res_b = mysql_query($query_b, $conn);

                                ?>
                                <tr>
                                    <td width="">Bodega-Sucursal:</td>
                                    <td>
                                        <select id="Acbobodega" class="comboMedio" NAME="Acbobodega">
                                            <option  value="">Escoger Bodega-Sucursal</option>
                                            <?php 
                                            $contadorb = 0;
                                            while ($contadorb < mysql_num_rows($res_b)) {
                                                ?>
                                                <option
                                                    value="<?php  echo mysql_result($res_b, $contadorb, "id_bodega") ?>"><?php  echo mysql_result($res_b, $contadorb, "nombre") ?></option>
                                                <?php  $contadorb++;
                                            }?>
                                        </select>

                                    </td>
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