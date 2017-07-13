<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
    </head>

<script>
function eliminar_linea(codproveedortmp,numfono)
{
	if (confirm(" Desea eliminar este telefono ? "))
            {				
		document.getElementById("frame_datos").src="eliminar_telefonos_oficina.php?codproveedortmp="+codproveedortmp+"&numfono="+numfono;
            }
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
				$numero=$_POST["numero"];
				$operadora=$_POST["operadora"];
				$descripcion=strtoupper($_POST["descripcion"]);
				

				$sel_insert="INSERT INTO proveedorfonotmp (idproveedor,numfono,numero,descripcion,operadora)
                                            VALUES ('$codproveedortmp',null,'$numero','$descripcion','$operadora')";
				$rs_insert=mysql_query($sel_insert, $conn);

		}

//}
?>
      <div id="pagina">
          
                <div align="center">
                    <table class="fuente8" width="55%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
            <?php
            $sel_lineas="SELECT a.numfono,a.numero,a.descripcion, b.nombre
                        FROM proveedorfonotmp a INNER JOIN operadora b ON a.operadora=b.id_operadora
                        WHERE a.idproveedor = $codproveedortmp ORDER BY a.numfono DESC";
            $rs_lineas=mysql_query($sel_lineas, $conn);
            for ($i = 0; $i < mysql_num_rows($rs_lineas); $i++) {
                    $numfono=mysql_result($rs_lineas,$i,"numfono");
                    //$codfamilia=mysql_result($rs_lineas,$i,"codfamilia");

                    $numero=mysql_result($rs_lineas,$i,"numero");
                    $descripcion=mysql_result($rs_lineas,$i,"descripcion");
                    $operadora=mysql_result($rs_lineas,$i,"nombre");
                    
                    if ($i % 2) { $fondolinea="itemParTabla"; } else { $fondolinea="itemImparTabla"; } ?>
                        <tr class="<?php echo $fondolinea?>" style="height: 5px">

                                            <td align="center" width="15%"><?php echo $numero?></td>
                                            <td align="center" width="15%"><?php echo $operadora?></td>
                                            <td align="center" width="25%"><?php echo $descripcion?></td>
                                            <td align="center" width="5%"><a href="javascript:eliminar_linea(<?php echo $codproveedortmp;?>,<?php echo $numfono;?>)"><img src="../img/eliminar.png" border="0"></a></td>
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