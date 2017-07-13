<?php  
include ("../conexion/conexion.php");

$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$fechahoy=date("Y-m-d");
$sel_fact="INSERT INTO productotmp (codproducto,fecha) VALUE ('','$fechahoy')";
$rs_fact=mysql_query($sel_fact, $conn);
$codproductotmp=mysql_insert_id();
?>
<html>
	<head>
		<title>Principal</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
		<link href="../calendario/calendar-blue.css" rel="stylesheet" type="text/css">
		<script type="text/JavaScript" language="javascript" src="../calendario/calendar.js"></script>
		<script type="text/JavaScript" language="javascript" src="../calendario/lang/calendar-sp.js"></script>
		<script type="text/JavaScript" language="javascript" src="../calendario/calendar-setup.js"></script>
               
		<script language="javascript">
        var cursor;
        if (document.all) {
        // Está utilizando EXPLORER
        cursor='hand';
        } else {
        // Está utilizando MOZILLA/NETSCAPE
        cursor='pointer';
        }
		
		var miPopup


        // creando objeto XMLHttpRequest de Ajax
        var obXHR;
        try {
                obXHR=new XMLHttpRequest();
        } catch(err) {
                try {
                        obXHR=new ActiveXObject("Msxml2.XMLHTTP");
                } catch(err) {
                        try {
                                obXHR=new ActiveXObject("Microsoft.XMLHTTP");
                        } catch(err) {
                                obXHR=false;
                        }
                }
        }

		
        function activar_subgrupo(url,obId)
        {
            document.getElementById(obId).disabled=false;

            var obCon = document.getElementById(obId);
            obXHR.open("GET", url);
            obXHR.onreadystatechange = function() {
                    if (obXHR.readyState == 4 && obXHR.status == 200) {
                            obXML = obXHR.responseXML;
                            obCod = obXML.getElementsByTagName("id");
                            obDes = obXML.getElementsByTagName("nombre");
                            obCon.length=obCod.length;
                            for (var i=0; i<obCod.length;i++) {
                                    obCon.options[i].value=obCod[i].firstChild.nodeValue;
                  obCon.options[i].text=obDes[i].firstChild.nodeValue;
                            }
                    }
            }
            obXHR.send(null);

        }



        function ventanaArticulos()
        {

            miPopup = window.open("ver_articulos.php","miwin","width=700,height=580,scrollbars=yes");
            miPopup.focus();

        }
		
			
		
        function cancelar() {
                location.href="index.php";
        }
		

        function validar_cabecera()
        {

            var mensaje="";
            if(document.getElementById("codigo").value == "")
                mensaje +="  - Codigo\n";

            if(document.getElementById("nombre").value == "")
                mensaje +="  - Nombre\n";

            if(document.getElementById("pvp").value == 0)
                mensaje +="  - PVP\n";
            if(document.getElementById("stock").value == 0)
                mensaje +="  - Cantidad\n";

            if(document.getElementById("proveedor").value == 0)
                mensaje +="  - Proveedor\n";
            if(document.getElementById("grupo").value == 0)
                mensaje +="  - Grupo\n";

            if(mensaje!="")
            {
                alert("Atencion, se han detectado las siguientes incorrecciones:\n\n"+mensaje);
            }
            else
            {

                document.getElementById("formulario").submit();
            }


        }

        function validar_linea()
        {
            if((document.getElementById("codarticulo").value == "")||(document.getElementById("descripcion").value == ""))
            {
                alert("Ingresar el producto ha Agrupar");
            }
            else
            {
                document.getElementById("costo").value= parseFloat(document.getElementById("costo").value)+ parseFloat(document.getElementById("costo_articulo").value)
                var original= parseFloat(document.getElementById("costo").value);
                var result=Math.round(original*100)/100 ;
                document.getElementById("costo").value=result;


                document.getElementById("pvp").value= parseFloat(document.getElementById("pvp").value)+ parseFloat(document.getElementById("pvp_articulo").value)
                var original= parseFloat(document.getElementById("pvp").value);
                var result=Math.round(original*100)/100 ;
                document.getElementById("pvp").value=result;

                document.getElementById("formulario_lineas").submit();
                document.getElementById("codarticulo").value = "";
                document.getElementById("descripcion").value = "";
            }            
        }


                
		</script>
	</head>
	<body>
		<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header">NUEVO PRODUCTO AGRUPACION</div>
				<div id="frmBusqueda">
				<form id="formulario" name="formulario" method="post" action="guardar_producto.php">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
                                            <tr>
                                                <td width="9%">Codigo</td>
                                                <td width="35%"><input NAME="Acodigo" type="text" class="cajaGrande" id="codigo" size="45" maxlength="45"></td>
                                               <td width="9%">Nombre</td>
                                                <td width="35%"><input NAME="Anombre" type="text" class="cajaGrande" id="nombre" size="45" maxlength="45"></td>
                                            </tr>                                           

                                            <tr>
                                                
                                            </tr>


                                            <tr>
                                                <td width="9%">Cantidad</td>
                                                <td width="35%"><input NAME="Nstock" type="text" class="cajaPequena" id="stock" size="15" maxlength="45" value="0"></td>
                                            </tr>


<!--                                            <tr>
                                                <td width="9%">Cantidad Consignacion</td>
                                                <td width="35%"><input readonly NAME="astock_consignacion" type="text" class="cajaPequena" id="stock_consignacion" size="15" maxlength="45" value="0"></td>
                                            </tr>-->


                                            <tr>
                                                <td width="9%">PVP</td>
                                                <td width="35%"><input NAME="Qpvp" type="text" class="cajaPequena" id="pvp" size="15" maxlength="45" value="0"></td>
                                                <td width="9%">Costo</td>
                                                <td width="35%"><input NAME="qcosto" type="text" class="cajaPequena" id="costo" size="15" maxlength="45" value="0"></td>
                                                
                                            </tr>

											<tr>
												<td width="15%">Utilidad</td>
												<td width="43%"><input NAME="qutilidad" type="text" class="cajaPequena" id="utilidad" size="15" maxlength="45" value="0">%</td>
											</tr>
                                           



                                            <tr>
                                                <td width="9%">Composici&oacute;n</td>
                                                <td><textarea name="acomposicion" cols="35" rows="2" id="composicion" class="areaTexto"></textarea></td>
                                                <td width="9%">Aplicaci&oacute;n</td>
                                                <td><textarea name="aplicacion" cols="35" rows="2" id="aplicacion" class="areaTexto"></textarea></td>
                                            </tr>                                       

                                            <tr>
                                                <td width="9%">Proveedor</td>
                                                <?php 
                                                    $query_prov="SELECT id_proveedor, empresa FROM proveedor";
                                                    $result_prov=mysql_query($query_prov,$conn);
                                                ?>
                                                <td width="35%">
                                                    <select name="Aproveedor" id="proveedor" class="comboGrande">
                                                        <option value="0">Seleccionar Proveedor</option>
                                                    <?php 
                                                        $contador=0;
                                                        while ($contador<mysql_num_rows($result_prov))
                                                        {
                                                    ?>
                                                        <option value="<?php echo mysql_result($result_prov,$contador,"id_proveedor")?>"><?php echo mysql_result($result_prov,$contador,"empresa")?></option>
                                                     <?php 
                                                        $contador++;
                                                        }
                                                    ?>
                                                    </select>

                                                </td>

<!--                                                <td width="9%">GRAVA IVA</td>
                                                <td width="35%"><input name="iva_show" type="text" class="cajaPequena" id="iva_show" readonly></td>-->
                                            </tr>
                                            <tr>
                                                <td>Grupo</td>
                                                <?php 
                                                    $query_grupo="SELECT id_grupo, nombre FROM grupo";
                                                    $result_grupo=mysql_query($query_grupo,$conn);
                                                ?>
                                                <td>
                                                    <select name="Agrupo" id="grupo" class="comboGrande" onchange="activar_subgrupo('subgrupo.php?grupo='+this.value,'subgrupo')">
                                                        <option value="0">Seleccionar Grupo</option>
                                                    <?php 
                                                        $contador1=0;
                                                        while ($contador1<mysql_num_rows($result_grupo))
                                                        {
                                                    ?>
                                                        <option value="<?php echo mysql_result($result_grupo,$contador1,"id_grupo")?>"><?php echo mysql_result($result_grupo,$contador1,"nombre")?></option>
                                                     <?php 
                                                        $contador1++;
                                                        }
                                                    ?>
                                                    </select>
                                                </td>

                                                <td>Subgrupo</td>
                                                <?php 
                                                    //$id_grupo="<script> document.write(opc)</script>";

                                                ?>
                                                <td>
                                                    <select name="Asubgrupo" id="subgrupo" class="comboGrande" disabled="true">


                                                    </select>
                                                </td>
                                            </tr>

					</table>										
			  </div>



                         <input id="codproductotmp" name="codproductotmp" value="<?php  echo $codproductotmp?>" type="hidden">
                          
                          
			  <input id="accion" name="accion" value="alta" type="hidden">
			  </form>
			  <br>
			  <div id="frmBusqueda">
				<form id="formulario_lineas" name="formulario_lineas" method="post" action="frame_lineas.php" target="frame_lineas">
				<div id="tituloForm" class="header">PRODUCTOS</div>
                                    <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
                                   
                                  <tr>
                                      <td>
                                          <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
                                              <tr>
                                                <td >C&oacute;digo Producto</td>
                                                <td><input NAME="codarticulo" type="text" class="cajaMedia" id="codarticulo" size="15" maxlength="15" onClick="ventanaArticulos()" readonly> <img src="../img/ver.png" width="16" height="16" onClick="ventanaArticulos()" onMouseOver="style.cursor=cursor" title="Buscar articulos"></td>
                                                <td>Descripci&oacute;n</td>
                                                <td><input NAME="descripcion" type="text" class="cajaGrande" id="descripcion" size="30" maxlength="30" readonly></td>
                                              </tr>
                                          </table>
                                      </td>
                                      <td><img src="../img/botonagregar.jpg" width="72" height="22" border="1" onClick="validar_linea()" onMouseOver="style.cursor=cursor" title="Agregar articulo"></td>
				  </tr>				                                                                                                       
				</table>
				</div>
                                   <input name="idarticulo" value="<?php  echo $idarticulo?>" type="hidden" id="idarticulo">
                                   <input name="costo_articulo" value="<?php  echo $costo?>" type="hidden" id="costo_articulo">
                                   <input name="pvp_articulo" value="<?php  echo $pvp?>" type="hidden" id="pvp_articulo">
                                   <input name="iva_articulo" value="<?php  echo $iva?>" type="hidden" id="iva_articulo">
				<br>
				<div id="frmBusqueda">
				<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
						<tr class="cabeceraTabla">
							
							<td width="5%">CODIGO</td>
							<td width="40%">DESCRIPCION</td>
							<td width="8%">COSTO</td>
                                                        <td width="8%">PVP</td>
                                                        <td width="8%">IVA</td>							
                                                        <td width="3%">&nbsp;</td>
						</tr>
				</table>
				<div id="lineaResultado">
					<iframe width="100%" height="100" id="frame_lineas" name="frame_lineas" frameborder="0">
						<ilayer width="100%" height="250" id="frame_lineas" name="frame_lineas"></ilayer>
					</iframe>
				</div>					
			  </div>
			  <div id="frmBusqueda">
			
			  </div>
                                <table width="50%" border=0 align="right" cellpadding=3 cellspacing=0 class="fuente8">
                                    <tr>
                                        <td>
                                            <div id="botonBusqueda">
                                              <div align="center">
                                                    <img src="../img/botonaceptar.jpg" width="85" height="22" onClick="validar_cabecera()" border="1" onMouseOver="style.cursor=cursor">
                                                    <img src="../img/botoncancelar.jpg" width="85" height="22" onClick="cancelar()" border="1" onMouseOver="style.cursor=cursor">
                                                <!--<input id="codfamilia" name="codfamilia" value="<?php  echo $codfamilia?>" type="hidden">-->
                                                    <input id="codproductotmp" name="codproductotmp" value="<?php  echo $codproductotmp?>" type="hidden">
                                                   
                                              </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
			  		<!--<iframe id="frame_datos" name="frame_datos" width="0" height="0" frameborder="0">
					<ilayer width="0" height="0" id="frame_datos" name="frame_datos"></ilayer>
					</iframe>-->
			  </form>
			 </div>
		  </div>
		</div>
	</body>
</html>
