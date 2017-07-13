<?php 
    include_once '../conexion/conexion.php';
    
    $usuario = new ServidorBaseDatos();
    $conn= $usuario->getConexion();


    error_reporting(0);
    $origen=$_GET["origen"];
    $op=$_GET["op"];
?>

<html>
    <head>
        <title>Principal</title>
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



        function ventanaArticulos()
        {

            miPopup = window.open("ver_articulos.php","miwin","width=700,height=580,scrollbars=yes");
            miPopup.focus();

        }


        function convertir()
        {
            
            var costo=parseFloat(document.getElementById("costo_aux").value);


            var convers=parseFloat(document.getElementById("conversion").value);

            var cantidad=parseFloat(document.getElementById("cantidad_convertir").value);

            var producto=costo/convers;
            var result2=Math.round(producto*10000)/10000;

            document.getElementById("stock").value=Math.round((cantidad*convers)*100)/100;
            document.getElementById("costo").value=result2;
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
			
			
		// creando objeto XMLHttpRequest de Ajax	
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
		
		

			
			
			
        

        </script>
    </head>
    <body>
        <div id="pagina">
            <div id="zonaContenido">
                <div align="center">
                    <div id="tituloForm" class="header">NUEVA TRANSFORMACION</div>
                    <div id="frmBusqueda">
                        <form id="formulario" name="formulario" method="post" action="save_producto.php">
                            <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
                                <tr>
                                    <td width="15%">Codigo</td>
                                    <td width=""><input NAME="Acodigo" type="text" class="cajaGrande" id="codigo" size="45" maxlength="45"></td>
                                    <td width="42%" rowspan="6" align="left" valign="top"><ul id="lista-errores"></ul></td>
                                </tr>
                                <tr>
                                    <td width="15%">Nombre</td>
                                    <td width=""><input NAME="Anombre" type="text" class="cajaGrande" id="nombre" size="45" maxlength="45"></td>

                                </tr>

                                <tr style="background: lightblue">
                                    
                                        
                                        <td>Producto Derivado</td>
                                        <td>
                                            <input NAME="Anombrearticulo" type="text" class="cajaGrande" id="nombrearticulo" size="15" maxlength="15" onClick="ventanaArticulos()" readonly>
                                            <img src="../img/ver.png" width="16" height="16" onClick="ventanaArticulos()" onMouseOver="style.cursor=cursor" title="Buscar articulos">
											<br/>Bodega:<select name="Acbobodega" id="Acbobodega" class="comboMedio"  ></select>
                                            <br/>Costo:<input name="costo_aux" id="costo_aux" type="text" class="cajaPequena" readonly onchange="convertir()" value="0"> Pvp:<input name="pvp_aux" id="pvp_aux" type="text" class="cajaPequena" readonly>
                                        </td>  
                                     
                                </tr>
									
											
									
									
																																		
									

                                <tr style="background: lightblue">
                                        <td>Factor de Conversion</td>
                                        <td>
                                            1 a <input NAME="Aconversion" type="text" class="cajaPequena" id="conversion" size="15" maxlength="15" onchange="convertir()" value="1">
                                        </td>
                                </tr>
                                <tr style="background: lightblue">
                                        <td><b>Cantidad a Convertir</b></td>
                                        <td>
                                            <input NAME="Acantidad_convertir" type="text" class="cajaMedia" id="cantidad_convertir" size="15" maxlength="15" onchange="convertir()" value="0">
                                        </td>
                                </tr>


                                <tr>
                                    <td width="15%">GRAVA IVA</td>
                                    <td width=""><input name="iva_show" type="text" class="cajaPequena" id="iva_show" readonly></td>
                                </tr>
                                <tr>
                                    <td width="15%">Stock</td>
                                    <td width=""><input NAME="Astock" type="text" class="cajaPequena" id="stock" size="15" maxlength="45" value="0" readonly></td>
                                </tr>
                                <tr>
                                    <td width="15%">Stock Consignacion</td>
                                    <td width=""><input readonly NAME="astock_consignacion" type="text" class="cajaPequena" id="stock_consignacion" size="15" maxlength="45" value="0"></td>
                                </tr>
                                <tr>
                                    <td width="15%">Costo</td>
                                    <td width=""><input NAME="qcosto" type="text" class="cajaPequena" id="costo" size="15" maxlength="45" value="0"></td>
                                </tr>
                                <tr>
                                    <td width="15%">PVP</td>
                                    <td width=""><input NAME="Qpvp" type="text" class="cajaPequena" id="pvp" size="15" maxlength="45"></td>
                                </tr>
                                
								<tr>
                                    <td width="15%">Utilidad</td>
                                    <td width=""><input NAME="qutilidad" type="text" class="cajaPequena" id="utilidad" size="15" maxlength="45" value="0">%</td>
                                </tr>
								
                                <tr>
                                    <td width="17%">Composici&oacute;n</td>
                                    <td><textarea name="acomposicion" cols="41" rows="2" id="composicion" class="areaTexto"></textarea></td>
                                </tr>
                                 <tr>
                                    <td width="17%">Aplicaci&oacute;n</td>
                                    <td><textarea name="aplicacion" cols="41" rows="2" id="aplicacion" class="areaTexto"></textarea></td>
                                </tr>
                                <tr>
                                    <td width="15%">Proveedor</td>
                                    <?php 
                                        $query_prov="SELECT id_proveedor, empresa FROM proveedor";
                                        $result_prov=mysql_query($query_prov,$conn);                                      
                                    ?>
                                    <td width="">
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
                                </tr>

                                <tr>
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

                    <div id="botonBusqueda">

                         <?php if (($origen=="factura")||($origen=="facturacompra")){?>
                            <img src="../img/botonaceptar.jpg" width="85" height="22" onClick="validar(formulario,true)" border="1" onMouseOver="style.cursor=cursor">
                         <?php }else{?>
                            <img src="../img/botonaceptar.jpg" width="85" height="22" onClick="validar(formulario,true)" border="1" onMouseOver="style.cursor=cursor">
                            <img src="../img/botonlimpiar.jpg" width="69" height="22" onClick="limpiar()" border="1" onMouseOver="style.cursor=cursor">
                            <img src="../img/botoncancelar.jpg" width="85" height="22" onClick="cancelar()" border="1" onMouseOver="style.cursor=cursor">
                        <?php }?>

                            <input name="stock_producto" id="stock_producto" type="hidden">
                            <input name="stockconsignacion_producto" id="stockconsignacion_producto" type="hidden">
                            <input name="id_producto" id="id_producto" type="hidden">

                            
                         <input name="iva" type="hidden" id="iva">
                         <input id="origen" name="origen" value="<?php  echo $origen?>" type="hidden">
                         <input id="op" name="op" value="<?php  echo $op?>" type="hidden">
                        <input id="accion" name="accion" value="alta" type="hidden">
                        <input id="id" name="Zid" value="" type="hidden">

                        
                    </div>
            </form>
            </div>
            </div>
        </div>

    </body>
</html>