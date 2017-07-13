<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
    </head>

<script>
function eliminar_linea(idruc,idfacturero)
{
	if (confirm(" Desea eliminar este Facturero ? "))
            {				
		document.getElementById("frame_datos").src="eliminar_telefonos_oficina_final.php?idruc="+idruc+"&idfacturero="+idfacturero;
            }
}


function modificar_facturero(idruc,idfacturero)
{
    miPopup = window.open("ver_facturero.php?idruc="+idruc+"&idfacturero="+idfacturero,"miwin","width=600,height=300,scrollbars=yes");
    miPopup.focus();
   //window.opener.frame_datos.location.reload("frame_telefonos_final.php?idcliente="+idcliente);
    //document.getElementById("frame_datos").src="frame_telefonos_final.php?idcliente="+idcliente;
}
</script>
<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
<body>
<?php 

error_reporting(0);
include ("../js/fechas.php");
include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();


$idruc=$_POST["idruc"];
$modif=$_POST["modif"];
$retorno=0;
if ($modif<>1) {
		if (!isset($idruc)) {
			$idruc=$_GET["idruc"];
			$retorno=1;                         
                        }
		if ($retorno==0) {	
				
				$establecimiento=$_POST["establecimiento"];
				$tiposervicio=$_POST["tiposervicio"];
				$serieinicio=$_POST["serieinicio"];
                                $seriefin=$_POST["seriefin"];
				$autorizacion=$_POST["autorizacion"];
				$fecha_caducidad=explota($_POST["fecha_caducidad"]);
				

				$sel_insert="INSERT INTO facturero (id_facturero, id_ruc, serie1, serie2, autorizacion, inicio, fin, fecha_caducidad)
                                            VALUES (null,'$idruc','$establecimiento','$tiposervicio','$autorizacion','$serieinicio','$seriefin','$fecha_caducidad')";
				$rs_insert=mysql_query($sel_insert, $conn);

		}

}
?>
      <div id="pagina">
          
                <div align="center">
                   
                    <table class="fuente8" width="70%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
            <?php 
            $sel_lineas="SELECT a.id_facturero, a.id_ruc,a.serie1,a.serie2, a.autorizacion, a.inicio,a.fin, a.fecha_caducidad
                        FROM facturero a 
                        WHERE a.id_ruc = $idruc";
            $rs_lineas=mysql_query($sel_lineas, $conn);
            for ($i = 0; $i < mysql_num_rows($rs_lineas); $i++) {
                $idfacturero=mysql_result($rs_lineas,$i,"id_facturero");
                   

                $establecimiento=mysql_result($rs_lineas,$i,"serie1");
                $tiposervicio=mysql_result($rs_lineas,$i,"serie2");
                $serieinicio=mysql_result($rs_lineas,$i,"inicio");
                $seriefin=mysql_result($rs_lineas,$i,"fin");
                $autorizacion=mysql_result($rs_lineas,$i,"autorizacion");
                $fecha_caducidad=implota(mysql_result($rs_lineas,$i,"fecha_caducidad"));
                    
                    if ($i % 2) { $fondolinea="itemImparTabla"; } else { $fondolinea="itemParTabla"; } ?>
                        <tr class="<?php  echo $fondolinea?>" style="height: 5px">

                                            <td align="center" width="10%"><?php  echo $establecimiento?></td>
                                            <td align="center" width="10%"><?php  echo $tiposervicio?></td>                                           
                                            <td align="center" width="10%"><?php  echo $serieinicio?></td>
                                            <td align="center" width="10%"><?php  echo $seriefin?></td>
                                            <td align="center" width="10%"><?php  echo $autorizacion?></td>   
                                            <td align="center" width="10%"><?php  echo $fecha_caducidad?></td>                                            
                                            <td align="center" width="5%"><a href="javascript:modificar_facturero(<?php  echo $idruc?>,<?php  echo $idfacturero?>)"><img src="../img/modificar.png" border="0"></a></td>
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