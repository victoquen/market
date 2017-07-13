<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
    </head>

<script>
function eliminar_linea(codproveedortmp,numcontacto)
{
	if (confirm(" Desea eliminar este contacto? "))
            {				
		document.getElementById("frame_datos").src="eliminar_contactos.php?codproveedortmp="+codproveedortmp+"&numcontacto="+numcontacto;
            }
}

var mipopup;
function agregar_movil(codproveedortmp,numcontacto)
{
     miPopup = window.open("telefonos_contacto.php?idproveedor="+codproveedortmp+"&numcontacto="+numcontacto,"miwin","width=600,height=400,scrollbars=yes");
     miPopup.focus();
     //window.opener.frame_datos.location.reload("frame_telefonos_final.php?idcliente="+idcliente);
}

</script>
<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
<body>
<?php

error_reporting(0);
include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();


$codproveedortmp=$_POST["codproveedortmp"];
$retorno=0;
//if ($modif<>1) {
		if (!isset($codproveedortmp)) {
			$codproveedortmp=$_GET["codproveedortmp"];
			$retorno=1;                         
                        }
		if ($retorno==0) {	
				//$codfamilia=$_POST["codfamilia"];
                                $cargo=strtoupper($_POST["cargo"]);
                                $nombre_contacto=strtoupper( $_POST["nombre_contacto"]);
				$linea_contacto=strtoupper($_POST["linea_contacto"]);
				$email_contacto=$_POST["email_contacto"];
				
				

				$sel_insert="INSERT INTO proveedorcontactotmp (idproveedor,numcontacto,cargo,nombre,linea,email)
                                            VALUES ('$codproveedortmp',null,'$cargo','$nombre_contacto','$linea_contacto','$email_contacto')";
				$rs_insert=mysql_query($sel_insert, $conn);

		}

//}
?>
      <div id="pagina">
          
                <div align="center">
                    <table class="fuente8" width="90%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
            <?php
            $sel_lineas="SELECT numcontacto, cargo, nombre, linea, email
                        FROM proveedorcontactotmp 
                        WHERE idproveedor = $codproveedortmp ORDER BY numcontacto DESC";
            $rs_lineas=mysql_query($sel_lineas, $conn);
            for ($i = 0; $i < mysql_num_rows($rs_lineas); $i++) {
                    $numcontacto=mysql_result($rs_lineas,$i,"numcontacto");
                    //$codfamilia=mysql_result($rs_lineas,$i,"codfamilia");
                    $cargo=mysql_result($rs_lineas,$i,"cargo");
                    $nombre=mysql_result($rs_lineas,$i,"nombre");
                    $linea=mysql_result($rs_lineas,$i,"linea");
                    $email=mysql_result($rs_lineas,$i,"email");
                   
                    if ($i % 2) { $fondolinea="itemParTabla"; } else { $fondolinea="itemImparTabla"; } ?>
                        <tr class="<?php echo $fondolinea?>" style="height: 5px">

                                            <td align="center" width="16%"><?php echo $cargo?></td>
                                            <td align="center" width="32%"><?php echo $nombre?></td>
                                            <td align="center" width="16%"><?php echo $linea?></td>
                                            <td align="center" width="16%"><?php echo $email?></td>
                                            <td align="center" width="5%"><a href="javascript:agregar_movil(<?php echo $codproveedortmp;?>,<?php echo $numcontacto;?>)"><img width="22" height="16" src="../img/movil.gif" border="0" title="Telefonos"></a></td>
                                            <td align="center" width="5%"><a href="javascript:eliminar_linea(<?php echo $codproveedortmp;?>,<?php echo $numcontacto;?>)"><img src="../img/eliminar.png" border="0"></a></td>
                                    </tr>
            <?php } ?>
            </table>
      </div>
   </div>
          
<iframe id="frame_datos" name="frame_datos" width="0%" height="0" frameborder="0">
	<ilayer width="0" height="0" id="frame_datos" name="frame_datos"></ilayer>
</iframe>
</body>
</html>