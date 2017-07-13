<?php  
include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$idproveedor=$_GET["idproveedor"];
$idbanco=$_GET["idbanco"];

$query_f="SELECT banco,titular,numero_cuenta,tipo_cuenta FROM proveedorbanco WHERE id_proveedor ='".$idproveedor."' AND id_banco='".$idbanco."'";
$rs_f=mysql_query($query_f,$conn);


$query_b="SELECT * FROM banco WHERE borrado=0 ORDER BY nombre ASC";
$res_b=mysql_query($query_b,$conn);

?>

<html>
<head>
    <title>Modificar Banco</title>
<script>
var cursor;
		if (document.all) {
		// Está utilizando EXPLORER
		cursor='hand';
		} else {
		// Está utilizando MOZILLA/NETSCAPE
		cursor='pointer';
		}

function guardar_banco(idproveedor)
{
     var mensaje="";
            if(document.getElementById("banco").value=="0")
            {
                mensaje+="   - Escoja el banco.\n"
            }
            if(document.getElementById("numero_cuenta").value=="")
            {
                mensaje+="   - Ingrese numero de cuenta.\n";
            }
            if(document.getElementById("titular").value=="")
            {
                mensaje+="   - Ingrese titular de cuenta.\n";
            }

            if(document.getElementById("tipo").value=="0")
            {
                mensaje+="   - Escoja tipo de cuenta.\n"
            }
            if(mensaje!="")
            {
                alert("Atencion:\n"+mensaje);
            }
            else
            {
                document.getElementById("form1").submit();
               
                //parent.location.href="frame_bancos_final.php?idproveedor="+idproveedor;
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
			<div id="tituloForm" class="header">banco</div>
			<div id="frmBusqueda">



        <form name="form1" id="form1" method="post" action="guardar_bancos_final.php" >
          <table class="fuente8" width="95%" id="tabla_resultado" name="tabla_resultado" align="center">
              <tr>
                   <td width="5%"> Banco:</td>
                   <td width="10%">
                       <select id="banco"  class="comboMedio" NAME="banco">
                            <option value="0">Seleccionar banco</option>
                            <?php  
                            $contador=0;
                            while ($contador < mysql_num_rows($res_b))
                                {
                                    if(mysql_result($res_b,$contador,"id_banco")==mysql_result($rs_f,0,"banco"))
                                    {
                            ?>
                                <option selected value="<?php   echo mysql_result($res_b,$contador,"id_banco")?>"><?php   echo mysql_result($res_b,$contador,"nombre")?></option>
                             <?php  }else{?>
                               <option value="<?php   echo mysql_result($res_b,$contador,"id_banco")?>"><?php   echo mysql_result($res_b,$contador,"nombre")?></option>
                            <?php   }$contador++;
                            } ?>
                      </select>
                </td>
              </tr>
               
              <tr>
                 <td width="5%">Titular Cuenta:</td>
                 <td width="10%"><input NAME="titular" type="text" value="<?php   echo  mysql_result($rs_f,0,"titular")?>" class="cajaMedia" id="titular" size="45" maxlength="45"></td>
              </tr>
              <tr>
                 <td width="5%">Numero Cuenta:</td>
                 <td width="10%"><input NAME="numero_cuenta" type="text" value="<?php   echo  mysql_result($rs_f,0,"numero_cuenta")?>" class="cajaPequena" id="numero_cuenta" maxlength="13"></td>
              </tr>
              <tr>
                 <td width="5%">Tipo Cuenta:
                 <td width="10%">
                    <select id="tipo" class="comboMedio" name="tipo">
                        <?php  if (mysql_result($rs_f,0,"tipo_cuenta")==1){?>
                            <option selected value="1">Cuenta Corriente</option>
                            <option value="2">Cuenta de Ahorros</option>
                         <?php  }else{ ?>
                             <option value="1">Cuenta Corriente</option>
                             <option selected value="2">Cuenta de Ahorros</option>
                         <?php  }?>
                    </select>
                 </td>
            </tr>
        </table>
        

        </div>
</div>

        <table width="100%" border="0">
          <tr>
            <td><div align="center">
              <img src="../img/botonaceptar.jpg"  onClick="guardar_banco(<?php   echo  $idproveedor?>)" border="1" onMouseOver="style.cursor=cursor">
              <img src="../img/botoncerrar.jpg" width="70" height="22" onClick="window.close()" border="1" onMouseOver="style.cursor=cursor">
              
            </div></td>
          </tr>
        </table>
        <iframe id="frame_datos" name="frame_datos" width="0%" height="0" frameborder="0">
                <ilayer width="0" height="0" id="frame_datos" name="frame_datos"></ilayer>
        </iframe>

       <input id="idproveedor" name="idproveedor" value="<?php   echo $idproveedor?>" type="hidden">
       <input id="idbanco" name="idbanco" value="<?php   echo $idbanco?>" type="hidden">

        </form>


</div>
</div>



</body>
</html>
