<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
    </head>

<script>
function eliminar_linea(idproveedor,idbanco)
{
	if (confirm(" Desea eliminar este banco? "))
            {				
		document.getElementById("frame_datos").src="eliminar_bancos_final.php?idproveedor="+idproveedor+"&idbanco="+idbanco;
            }
}

function modificar_banco(idproveedor,idbanco)
{
    miPopup = window.open("ver_banco_final.php?idproveedor="+idproveedor+"&idbanco="+idbanco,"miwin","width=600,height=300,scrollbars=yes");
    miPopup.focus();  
}
</script>
<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
<body>
<?php 

error_reporting(0);
include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();


$idproveedor=$_POST["idproveedor"];
$modif=$_POST["modif_bancos"];
$retorno=0;
if ($modif<>1) {
		if (!isset($idproveedor)) {
			$idproveedor=$_GET["idproveedor"];
			$retorno=1;                         
                        }
		if ($retorno==0) {					
                                $banco=$_POST["banco"];
                                $titular=strtoupper( $_POST["titular"]);
				$numero_cuenta=$_POST["numero_cuenta"];
				$tipo=$_POST["tipo"];
				
				

				$sel_insert="INSERT INTO proveedorbanco (id_banco,id_proveedor,banco,titular,numero_cuenta,tipo_cuenta)
                                            VALUES ('','$idproveedor','$banco','$titular','$numero_cuenta','$tipo')";
				$rs_insert=mysql_query($sel_insert, $conn);

		}

}
?>
      <div id="pagina">
          
                <div align="center">
                    <table class="fuente8" width="85%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
            <?php 
            $sel_lineas="SELECT a.id_banco, a.titular, a.numero_cuenta,a.tipo_cuenta, b.nombre
                        FROM proveedorbanco a INNER JOIN banco b ON a.banco=b.id_banco
                        WHERE a.id_proveedor = $idproveedor ORDER BY a.id_banco DESC";
            $rs_lineas=mysql_query($sel_lineas, $conn);
            for ($i = 0; $i < mysql_num_rows($rs_lineas); $i++) {
                    $idbanco=mysql_result($rs_lineas,$i,"id_banco");
                    //$codfamilia=mysql_result($rs_lineas,$i,"codfamilia");
                    $banco=mysql_result($rs_lineas,$i,"nombre");
                    $titular=mysql_result($rs_lineas,$i,"titular");
                    $numero=mysql_result($rs_lineas,$i,"numero_cuenta");
                    $tipo=mysql_result($rs_lineas,$i,"tipo_cuenta");

                    //tipo cuenta = 1 CUENTA CORRIENTE
                    //tipo cuenta = 1 CUENTA DE AHORROS

                    if($tipo=="1")
                    {
                        $tipocuenta="CUENTA CORRIENTE";
                    }
                    else
                    {
                        $tipocuenta="CUENTA DE AHORROS";
                    }
                    
                    if ($i % 2) { $fondolinea="itemParTabla"; } else { $fondolinea="itemImparTabla"; } ?>
                        <tr class="<?php  echo $fondolinea?>" style="height: 5px">

                            <td align="center" width="16%"><?php  echo $banco?></td>
                            <td align="center" width="32%"><?php  echo $titular?></td>
                            <td align="center" width="16%"><?php  echo $numero?></td>
                            <td align="center" width="16%"><?php  echo $tipocuenta?></td>
                            <td align="center" width="5%"><a href="javascript:eliminar_linea(<?php  echo $idproveedor?>,<?php  echo $idbanco?>)"><img src="../img/eliminar.png" border="0"></a></td>
                            <td align="center" width="5%"><a href="javascript:modificar_banco(<?php  echo $idproveedor?>,<?php  echo $idbanco?>)"><img src="../img/modificar.png" border="0"></a></td>
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