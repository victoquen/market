<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
    </head>

<script>
function eliminar_fono(idcliente,idtelefono)
{
	if (confirm(" Desea eliminar este telefono ? "))
            {				
		document.getElementById("frame_datos").src="eliminar_telefonos_final.php?idcliente="+idcliente+"&idtelefono="+idtelefono;
            }
}

var miPopup

function modificar_fono(idcliente,idtelefono)
{
    miPopup = window.open("ver_telefono.php?idcliente="+idcliente+"&idtelefono="+idtelefono,"miwin","width=600,height=300,scrollbars=yes");
    miPopup.focus();
   //window.opener.frame_datos.location.reload("frame_telefonos_final.php?idcliente="+idcliente);
    //document.getElementById("frame_datos").src="frame_telefonos_final.php?idcliente="+idcliente;
}
</script>
<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
<body>
<?php  
include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();
error_reporting(0);

$idcliente=$_POST["idcliente"];
$modif=$_POST["modif"];
$retorno=0;
if ($modif<>1) {
		if (!isset($idcliente)) {
			$idcliente=$_GET["idcliente"];
			$retorno=1;                         
                        }
		if ($retorno==0) {	
				//$codfamilia=$_POST["codfamilia"];
				$numero=$_POST["numero"];
				$operadora=$_POST["operadora"];
				$descripcion=$_POST["descripcion"];
				

				$sel_insert="INSERT INTO clientefono (id_telefono,id_cliente,numero,descripcion,operadora)
                                            VALUES ('','$idcliente','$numero','$descripcion','$operadora')";
				$rs_insert=mysql_query($sel_insert, $conn);

		}

}
?>
      <div id="pagina">

                <div align="center">
                    <table class="fuente8" width="55%" cellspacing=0 cellpadding=0 border=0 ID="Table1">
            <?php 
            $sel_lineas="SELECT a.id_telefono,a.numero,a.descripcion, b.nombre
                        FROM clientefono a INNER JOIN operadora b ON a.operadora=b.id_operadora
                        WHERE a.id_cliente = $idcliente ORDER BY a.id_telefono DESC";
            $rs_lineas=mysql_query($sel_lineas, $conn);
            for ($i = 0; $i < mysql_num_rows($rs_lineas); $i++) {
                    $idtelefono=mysql_result($rs_lineas,$i,"id_telefono");
                    

                    $numero=mysql_result($rs_lineas,$i,"numero");
                    $descripcion=mysql_result($rs_lineas,$i,"descripcion");
                    $operadora=mysql_result($rs_lineas,$i,"nombre");
                    
                    if ($i % 2) { $fondolinea="itemParTabla"; } else { $fondolinea="itemImparTabla"; } ?>
                        <tr class="<?php  echo $fondolinea?>" style="height: 5px">

                                            <td align="center" width="15%"><?php  echo $numero?></td>
                                            <td align="center" width="15%"><?php  echo $operadora?></td>
                                            <td align="center" width="25%"><?php  echo $descripcion?></td>
                                            <td align="center" width="5%"><a href="javascript:eliminar_fono(<?php  echo $idcliente?>,<?php  echo $idtelefono?>)"><img src="../img/eliminar.png" border="0"></a></td>
                                            <td align="center" width="5%"><a href="javascript:modificar_fono(<?php  echo $idcliente?>,<?php  echo $idtelefono?>)"><img src="../img/modificar.png" border="0"></a></td>
                        </tr>
            <?php  } ?>
            </table>
                </div>
      </div>
          
<iframe id="frame_datos" name="frame_datos" width="0%" height="0" frameborder="0">
	<ilayer width="0" height="0" id="frame_datos" name="frame_datos"></ilayer>
</iframe>
                   
</body>
</html>