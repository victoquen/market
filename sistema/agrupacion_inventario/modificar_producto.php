<?php   

$idproducto=$_GET["idproducto"];

include_once '../conexion/conexion.php';
include_once 'class/producto.php';

$usuario = new ServidorBaseDatos();
$conn= $usuario->getConexion();

$producto= new Producto();
$row = $producto->get_producto_id($conn, $idproducto);

?>
<html>
	<head>
		<title>Principal</title>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">

                <link href="../calendario/calendar-blue.css" rel="stylesheet" type="text/css">
                <script type="text/JavaScript" language="javascript" src="../calendario/calendar.js"></script>
                <script type="text/JavaScript" language="javascript" src="../calendario/lang/calendar-sp.js"></script>
                <script type="text/JavaScript" language="javascript" src="../calendario/calendar-setup.js"></script>


		<script type="text/javascript" src="../js/validar.js"></script>
		<script language="javascript">
		
		function cancelar() {
			location.href="index.php";
		}
		
		var cursor;
		if (document.all) {
		// Está utilizando EXPLORER
		cursor='hand';
		} else {
		// Está utilizando MOZILLA/NETSCAPE
		cursor='pointer';
		}
		
		function limpiar() {
			document.getElementById("formulario").reset();
		}





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

        function cargainicio(idgrupo)
        {
            url="subgrupo.php?grupo="+idgrupo;
            obId="subgrupo";
            activar_subgrupo(url,obId);
        }



        function ventanaArticulos()
        {

            miPopup = window.open("ver_articulos.php","miwin","width=700,height=580,scrollbars=yes");
            miPopup.focus();

        }


function validar_cabecera()
        {
            
            var mensaje="";
//            if(document.getElementById("codigo").value == "")
//                mensaje +="  - Codigo\n";
//
//            if(document.getElementById("nombre").value == "")
//                mensaje +="  - Nombre\n";
//
//            if(document.getElementById("pvp").value == 0)
//                mensaje +="  - PVP\n";
//            if(document.getElementById("stock").value == 0)
//                mensaje +="  - Stock\n";


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

                //alert("id producto="+document.getElementById("idproducto").value+"\nid articulo="+document.getElementById("idarticulo").value+"\n modif="+document.getElementById("modif").value);
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




        function carga_articulos()
                {

                    document.getElementById("modif").value=1;
                    document.formulario_lineas.submit();

                    document.getElementById("modif").value=0;
                }

		</script>
	</head>
        <body onload="carga_articulos()">
		<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header">MODIFICAR PRODUCTO</div>
				<div id="frmBusqueda">
				<form id="formulario" name="formulario" method="post" action="guardar_producto.php">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
						<tr>
							<td>ID</td>
							<td><?php  echo $idproducto?></td>
						  
						</tr>
                                                <tr>
                                                    <td width="15%">Codigo</td>
                                                    <td width="43%"><input readonly NAME="Acodigo" type="text" class="cajaMedia" id="cogigo" value="<?php  echo $row['codigo']?>" size="45" maxlength="45"></td>

                                                    <td width="15%">Nombre</td>
                                                    <td width="43%"><input readonly NAME="Anombre" type="text" class="cajaGrande" id="nombre" value="<?php  echo $row['nombre']?>" size="45" maxlength="45"></td>
                                                </tr>
						                                                                                               
                                                
                                                <tr style="background: lightblue">
                                                    <td width="15%">Stock</td>
                                                    <td width="43%"><?php echo $row['stock']?> + <input NAME="Nstock" type="text" class="cajaPequena" id="stock" value="0" size="15" maxlength="45" ></td>
                                                </tr>
                                               
                                                <tr>
                                                    <td width="15%">Costo</td>
                                                    <td width="43%"><input NAME="qcosto" type="text" class="cajaPequena" id="costo" value="<?php  echo $row['costo']?>" size="15" maxlength="45" value="0"></td>

                                                    
                                                    <td width="15%">PVP</td>
                                                    <td width="43%"><input NAME="Qpvp" type="text" class="cajaPequena" id="pvp" value="<?php  echo $row['pvp']?>" size="15" maxlength="45"></td>
                                                </tr>
                                              
												<tr>
                                                    <td width="15%">Utilidad</td>
                                                    <td width="43%"><input NAME="qutilidad" type="text" class="cajaPequena" id="utilidad" size="15" maxlength="45" value="<?php  echo $row['utilidad']?>">%</td>
                                                </tr>
											  
                                                
                                                <tr>
                                                    <td width="15%">Composici&oacute;n</td>
                                                    <td><textarea disabled name="acomposicion" cols="41" rows="2" id="composicion" class="areaTexto"><?php  echo $row['composicion']?></textarea></td>

                                                    <td width="15%">Aplicaci&oacute;n</td>
                                                    <td><textarea disabled name="aplicacion" cols="41" rows="2" id="aplicacion" class="areaTexto"><?php  echo $row['aplicacion']?></textarea></td>
                                                </tr>
                                               
                                                <tr>
                                                    <td width="15%">Proveedor</td>                                                    
                                                       <?php 
                                                        $query_prov="SELECT id_proveedor, empresa FROM proveedor";
                                                        $result_prov=mysql_query($query_prov,$conn);
                                                    ?>
                                                    <td width="43%">
                                                        <select disabled name="Aproveedor" id="proveedor" class="comboGrande">
                                                            <option value="0">Seleccionar Proveedor</option>
                                                        <?php 
                                                            $contador=0;
                                                            while ($contador<mysql_num_rows($result_prov))
                                                            {
                                                                if($row['proveedor']== mysql_result($result_prov,$contador,"id_proveedor"))
                                                                {
                                                        ?>
                                                                <option selected value="<?php echo mysql_result($result_prov,$contador,"id_proveedor")?>"><?php echo mysql_result($result_prov,$contador,"empresa")?></option>
                                                        <?php 
                                                                }
                                                                else
                                                                {
                                                        ?>
                                                                <option value="<?php echo mysql_result($result_prov,$contador,"id_proveedor")?>"><?php echo mysql_result($result_prov,$contador,"empresa")?></option>
                                                         <?php 
                                                                }
                                                            $contador++;
                                                            }
                                                        ?>
                                                        </select>

                                                    </td>
                                                    
                                                </tr>


                                                 <tr>
                                                    <td>Grupo</td>
                                                    <?php 
                                                        $query_grupo="SELECT id_grupo, nombre FROM grupo";
                                                        $result_grupo=mysql_query($query_grupo,$conn);
                                                    ?>
                                                    <td>
                                                        <select disabled name="Agrupo" id="grupo" class="comboGrande" onchange="activar_subgrupo('subgrupo.php?grupo='+this.value,'subgrupo')">
                                                            <option value="0">Seleccionar Grupo</option>
                                                        <?php 
                                                            $contador1=0;
                                                            while ($contador1<mysql_num_rows($result_grupo))
                                                            {
                                                                if($row['grupo']==mysql_result($result_grupo,$contador1,"id_grupo"))
                                                                {

                                                        ?>
                                                            <option selected value="<?php echo mysql_result($result_grupo,$contador1,"id_grupo")?>"><?php echo mysql_result($result_grupo,$contador1,"nombre")?></option>
                                                        <?php 
                                                                }
                                                                else
                                                                {
                                                        ?>
                                                            <option value="<?php echo mysql_result($result_grupo,$contador1,"id_grupo")?>"><?php echo mysql_result($result_grupo,$contador1,"nombre")?></option>
                                                         <?php 
                                                                }
                                                            $contador1++;
                                                            }
                                                        ?>
                                                        </select>
                                                    </td>

                                                     <td>Subgrupo</td>
                                                    <td>
                                                        <?php 
                                                            $query_subgrupo="SELECT id_subgrupo, nombre FROM subgrupo WHERE id_grupo=".$row['grupo'];
                                                            $result_subgrupo=mysql_query($query_subgrupo,$conn);
                                                        ?>
                                                        <select disabled name="Asubgrupo" id="subgrupo" class="comboGrande" >

                                                         <?php 
                                                            $contador2=0;
                                                            while ($contador2<mysql_num_rows($result_subgrupo))
                                                            {
                                                                if($row['subgrupo']==mysql_result($result_subgrupo,$contador2,"id_subgrupo"))
                                                                {

                                                        ?>
                                                            <option selected value="<?php echo mysql_result($result_subgrupo,$contador2,"id_subgrupo")?>"><?php echo mysql_result($result_subgrupo,$contador2,"nombre")?></option>
                                                        <?php 
                                                                }
                                                                else
                                                                {
                                                        ?>
                                                            <option value="<?php echo mysql_result($result_subgrupo,$contador2,"id_grupo")?>"><?php echo mysql_result($result_subgrupo,$contador2,"nombre")?></option>
                                                         <?php 
                                                                }
                                                            $contador2++;
                                                            }
                                                        ?>
                                                        </select>
                                                    </td>
                                                </tr>                                                                                                                                            
					</table>
                                    
                                        
                                     </div>

                                        <input id="accion" name="accion" value="modificar" type="hidden">
					<input id="id" name="id" value="" type="hidden">
                                        <input id="idproducto" name="idproducto" value="<?php  echo $idproducto?>" type="hidden">

                                     </form>

                                <br/>
                                
                                <div id="frmBusqueda">
                                
				<form id="formulario_lineas" name="formulario_lineas" method="post" action="frame_lineas_final.php" target="frame_lineas">
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



				<div id="botonBusqueda">
					<img src="../img/botonaceptar.jpg" width="85" height="22" onClick="validar_cabecera()" border="1" onMouseOver="style.cursor=cursor">
					
					<img src="../img/botoncancelar.jpg" width="85" height="22" onClick="cancelar()" border="1" onMouseOver="style.cursor=cursor">                                                                              
                                </div>


                               <input name="idarticulo" value="<?php  echo $idarticulo?>" type="hidden" id="idarticulo">
                               <input name="costo_articulo" value="<?php  echo $costo?>" type="hidden" id="costo_articulo">
                               <input name="pvp_articulo" value="<?php  echo $pvp?>" type="hidden" id="pvp_articulo">
                               <input name="iva_articulo" value="<?php  echo $iva?>" type="hidden" id="iva_articulo">

                               <input id="modif" name="modif" value="0" type="hidden">

                               <input id="idproducto" name="idproducto" value="<?php  echo $idproducto?>" type="hidden">

                          </form>
		  </div>
		  </div>
		</div>
	</body>
</html>
