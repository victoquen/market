<?php 
include_once 'class/ruc.php';
include_once '../conexion/conexion.php';
include ("../js/fechas.php");
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
    $idinformante = $_POST["Vidinformante"];
    $razonsocial = strtoupper($_POST["Arazonsocial"]);
}

if ($accion == "alta") {
    
}



if ($accion == "modificar") {
    $idruc = $_POST["idruc"];
    $ruc = new ruc();
    $result = $ruc->update_ruc($conn, $idruc, $idinformante, $razonsocial);

    if ($result) {
        $mensaje = "Los datos del ruc han sido modificados correctamente";
        $validacion = 0;
    } else {
        $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   El CODIGO ya existe, ERROR al ingresar el proveedor</span>";
        $validacion = 1;
    }
    $cabecera1 = "Inicio >> RUC &gt;&gt; Modificar RUC ";
    $cabecera2 = "MODIFICAR RUC ";
}





if ($accion == "baja") {
    
}
?>


<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
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
                    <div id="tituloForm" class="header"><?php  echo $cabecera2 ?>--<?php  echo $mensaje ?></div>
                    <div id="frmBusqueda">
                        <table class="fuente8" width="30%" cellspacing=0 cellpadding=3 border=0>
                            <tr>
                                <td width="15%"><b>RUC</b></td>
                                <td width="43%"><?php  echo $idinformante ?></td>
                            </tr>

                            <tr>
                                <td width="15%"><b>RAZON SOCIAL</b></td>
                                <td width="43%"><?php  echo $razonsocial ?></td>

                            </tr>

                        </table>
                        <!-- Inicio FACTUREROS---------------------------------------------------->

                        <table class="fuente8" width="70%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
                            
                            <tr class="cabeceraTabla">
                                <td width="10%">Establec.</td>
                                <td width="10%">Servicio</td>
                                <td width="10%">Inicio</td>
                                <td width="10%">Fin</td>
                                <td width="10%">Autorizaci&oacute;n</td>
                                <td width="10%">Caducidad</td>
                                                        
                            </tr>
                            
                            
                        <?php 
                        $sel_lineas = "SELECT a.id_facturero, a.id_ruc,a.serie1,a.serie2, a.autorizacion, a.inicio,a.fin, a.fecha_caducidad
                                                FROM facturero a 
                                                WHERE a.id_ruc = $idruc";
                        $rs_lineas = mysql_query($sel_lineas, $conn);
                        for ($i = 0; $i < mysql_num_rows($rs_lineas); $i++) {
                            $idfacturero = mysql_result($rs_lineas, $i, "id_facturero");


                            $establecimiento = mysql_result($rs_lineas, $i, "serie1");
                            $tiposervicio = mysql_result($rs_lineas, $i, "serie2");
                            $serieinicio = mysql_result($rs_lineas, $i, "inicio");
                            $seriefin = mysql_result($rs_lineas, $i, "fin");
                            $autorizacion = mysql_result($rs_lineas, $i, "autorizacion");
                            $fecha_caducidad = implota(mysql_result($rs_lineas, $i, "fecha_caducidad"));

                            if ($i % 2) {
                                $fondolinea = "itemImparTabla";
                            } else {
                                $fondolinea = "itemParTabla";
                            }
                            ?>
                                <tr class="<?php  echo $fondolinea ?>" style="height: 5px">

                                    <td align="center" width="10%"><?php  echo $establecimiento ?></td>
                                    <td align="center" width="10%"><?php  echo $tiposervicio ?></td>                                           
                                    <td align="center" width="10%"><?php  echo $serieinicio ?></td>
                                    <td align="center" width="10%"><?php  echo $seriefin ?></td>
                                    <td align="center" width="10%"><?php  echo $autorizacion ?></td>   
                                    <td align="center" width="10%"><?php  echo $fecha_caducidad ?></td>                                            
                                    
                                </tr>
                            <?php  } ?>
                                
                                
                        </table>
                        <!-- Fin FACTUREROS---------------------------------------------------->









                    </div>
                    <div id="botonBusqueda">                                    					                                    
                        <img src="../img/botonaceptar.jpg" width="85" height="22" onClick="aceptar(<?php  echo $validacion ?>)" border="1" onMouseOver="style.cursor = cursor">

                    </div>
                </div>
            </div>
        </div>
    </body>
</html>