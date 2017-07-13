<?php
include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$idproveedor=$_GET["idproveedor"];
$idtelefono=$_GET["idtelefono"];

$query_f="SELECT numero,operadora,descripcion FROM proveedorfono WHERE id_proveedor ='".$idproveedor."' AND id_telefono='".$idtelefono."'";
$rs_f=mysql_query($query_f,$conn);


$query_o="SELECT * FROM operadora WHERE borrado=0 ORDER BY nombre ASC";
$res_o=mysql_query($query_o,$conn);

?>

<html>
<head>
    <title>Modificar Tel&eacute;fono</title>
<script>
var cursor;
		if (document.all) {
		// Está utilizando EXPLORER
		cursor='hand';
		} else {
		// Está utilizando MOZILLA/NETSCAPE
		cursor='pointer';
		}

function guardar_telefono(idproveedor)
{
    var mensaje="";
            if(document.getElementById("numero").value=="")
            {
                mensaje+="   - Ingrese numero telefonico.\n";
            }

            if(document.getElementById("operadora").value=="0")
            {
                mensaje+="   - Escoja operadora.\n"
            }
            if(mensaje!="")
            {
                alert("Atencion:\n"+mensaje);
            }
            else
            {
                document.getElementById("form1").submit();
               
                //parent.location.href="frame_telefonos_final.php?idproveedor="+idproveedor;
                parent.opener.document.location.href="modificar_proveedor.php?idproveedor="+idproveedor;

                 window.close();

            }
}

</script>
<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>




<body>
    <div id="pagina">
	<div id="zonaContenido">
		<div align="center">
			<div id="tituloForm" class="header">Telefono</div>
			<div id="frmBusqueda">



        <form name="form1" id="form1" method="post" action="guardar_telefonos_oficina_final.php" >
          <table class="fuente8" width="95%" id="tabla_resultado" name="tabla_resultado" align="center">
                <tr>
                    <td width="5%">Numero Telf:</td>
                    <td width="10%"><input NAME="numero" type="text" class="cajaPequena" id="numero" value="<?php echo mysql_result($rs_f,0,'numero');?>" maxlength="13"></td>
                </tr>
                <tr>
                    <td width="5%">Operadora:</td>
                    <td width="10%">
                        <select id="operadora"  class="comboMedio" NAME="operadora">
                                <?php
                                $contador=0;
                                while ($contador < mysql_num_rows($res_o))
                                {
                                    if(mysql_result($res_o,$contador,"id_operadora")==mysql_result($rs_f,0,"operadora"))
                                    {
                                ?>
                                    <option selected value="<?php echo mysql_result($res_o,$contador,"id_operadora")?>"><?php echo mysql_result($res_o,$contador,"nombre")?></option>
                                <?}else{?>
                                    <option value="<?php echo mysql_result($res_o,$contador,"id_operadora")?>"><?php echo mysql_result($res_o,$contador,"nombre")?></option>
                                <?php }$contador++;
                                } ?>
                       </select>
                    </td>
                </tr>
                <tr>
                    <td width="5%"> Descripci&oacute;n:</td>
                    <td width="10%"><input NAME="descripcion" type="text" class="cajaMedia" id="descripcion" value="<?php echo mysql_result($rs_f,0,"descripcion");?>" size="45" maxlength="45"></td>
                </tr>
        </table>
        

        </div>
</div>

        <table width="100%" border="0">
          <tr>
            <td><div align="center">
              <img src="../img/botonaceptar.jpg"  onClick="guardar_telefono(<?php echo $idproveedor?>)" border="1" onMouseOver="style.cursor=cursor">
              <img src="../img/botoncerrar.jpg" width="70" height="22" onClick="window.close()" border="1" onMouseOver="style.cursor=cursor">
              
            </div></td>
          </tr>
        </table>
        <iframe id="frame_datos" name="frame_datos" width="0%" height="0" frameborder="0">
                <ilayer width="0" height="0" id="frame_datos" name="frame_datos"></ilayer>
        </iframe>

       <input id="idproveedor" name="idproveedor" value="<?php echo $idproveedor?>" type="hidden">
       <input id="idtelefono" name="idtelefono" value="<?php echo $idtelefono?>" type="hidden">

        </form>


</div>
</div>



</body>
</html>
