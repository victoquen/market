<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
    </head>
    <link href="../estilos/estilos.css" type="text/css" rel="stylesheet">


<?php 

error_reporting(0);
include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();


$idproveedor=$_GET["idproveedor"];
$idcontacto=$_GET["idcontacto"];
?>




<script>
    function validar_telefono()
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
                document.getElementById("formulario_telefonos_contacto").submit();
                document.getElementById("numero").value="";
                document.getElementById("descripcion").value="";
                document.getElementById("operadora").value="0";
            }
        }

        function cargar_telefonos()
        {
           document.getElementById("modif").value=1;
           document.formulario_telefonos_contacto.submit();
           document.getElementById("modif").value=0;
        }
</script>
    <body onload="cargar_telefonos()">
    <div id="pagina">
        <div id="zonaContenido">
            <div align="center">
                 <div id="frmBusqueda">
                        <form id="formulario_telefonos_contacto" name="formulario_telefonos_contacto" method="post" action="frame_telefonos_contacto_final.php" target="frame_telefonos_contacto">
                            <div id="tituloForm" class="header">CONTACTO TELEFONOS</div>
                            <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0 >

                                 <?php 

                                    $query_o="SELECT * FROM operadora WHERE borrado=0 ORDER BY nombre ASC";
                                    $res_o=mysql_query($query_o,$conn);

                                ?>
                                <tr>
                                    <td width="12%">
                                        Numero Telf:
                                    </td>
                                    <td width="25%">
                                        <input NAME="numero" type="text" class="cajaPequena" id="numero" maxlength="13">
                                    </td>
                                    <td rowspan="3" align="left">
                                        <img src="../img/guardar.png" width="23" height="29" onClick="validar_telefono()" onMouseOver="style.cursor=cursor" title="Agregar telefono">
                                    </td>
                                </tr>
                                <tr>
                                    <td width="12%">
                                         Operadora:
                                    </td>
                                    <td width="25%">
                                        <select id="operadora"  class="comboMedio" NAME="operadora">
                                            <option value="0">Seleccionar operadora</option>
                                            <?php 
                                            $contador=0;
                                            while ($contador < mysql_num_rows($res_o))
                                                {
                                              ?>
                                                        <option value="<?php  echo mysql_result($res_o,$contador,"id_operadora")?>"><?php  echo mysql_result($res_o,$contador,"nombre")?></option>
                                            <?php  $contador++;
                                            } ?>
                                        </select>
                                   </td>
                                   <td></td>
                                 </tr>
                                 <tr>
                                     <td width="12%">
                                         Descripci&oacute;n:
                                     </td>
                                     <td width="25%">
                                        <input NAME="descripcion" type="text" class="cajaMedia" id="descripcion" size="45" maxlength="45">                                                                              
                                    </td>
                                    <td></td>
                                </tr>

                                                                 
                            </table>
                    </div>


                     <div id="frmBusqueda">
				<table class="fuente8" width="50%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
						<tr class="cabeceraTabla">
							<td width="15%">#</td>
                                                        <td width="10%">OPERADORA</td>
                                                        <td width="20%">DESCRIPCION</td>
							<td width="5%">&nbsp;</td>
						</tr>
				</table>
				<div id="lineaResultado">
                                    <iframe align="middle" width="100%" height="180" id="frame_telefonos_contacto" name="frame_telefonos_contacto" frameborder="0" >
						<ilayer  width="100%" height="180" id="frame_telefonos_contacto" name="frame_telefonos_contacto"></ilayer>
					</iframe>



				</div>

                    </div>






            </div>
            <table width="100%" border="0">
              <tr>
                <td><div align="center">                  
                  <img src="../img/botoncerrar.jpg" width="70" height="22" onClick="window.close()" border="1" onMouseOver="style.cursor=cursor">

                </div></td>
              </tr>
            </table>
              <input id="modif" name="modif" value="0" type="hidden">
             <input id="idproveedor" name="idproveedor" value="<?php  echo $idproveedor;?>" type="hidden">
             <input id="idcontacto" name="idcontacto" value="<?php  echo $idcontacto;?>" type="hidden">
            </form>
        </div>
    </div>
</body>
</html>