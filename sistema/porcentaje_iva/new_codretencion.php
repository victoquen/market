<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
        <title>Principal</title>
        <link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
       
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
            

            function validarForm(){
                var mensaje = "";


                if (document.getElementById("porcentaje").value == "") mensaje += "  - Ingresar procentaje\n";
                if (document.getElementById("Acbotipos").value == "") mensaje += "  - Escoger activo\n";

                if (mensaje != "") {
                    alert("Atencion, se han detectado las siguientes incorrecciones:\n\n" + mensaje);
                } else {

                    document.getElementById("formulario").submit();
                    document.getElementById("porcentaje").value = "";
                    document.getElementById("Acbotipos").value = 0;

                }

        }
        </script>
    </head>
    <body>
        <div id="pagina">
            <div id="zonaContenido">
                <div align="center">
                    <div id="tituloForm" class="header">INSERTAR CODIGO IVA</div>
                    <div id="frmBusqueda">
                        <form id="formulario" name="formulario" method="post" action="save_codretencion.php">
                            <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>                                

								<tr>
                                    <td width="15%">Porcentaje</td>
                                    <td width="43%"><input NAME="porcentaje" type="text" class="cajaPequena" id="porcentaje" size="45" maxlength="45" ></td>
                                </tr>
								<tr>
                                    <td width="15%">Activo</td>
									<td>
									<select id="Acbotipos" name="Acbotipos" class="comboGrande">
										<option value="">Seleccione un Tipo</option>
										<option value="0">NO</option>
										<option value="1">SI</option>
									</select>
									</td>
								</tr>
                            </table>
                    </div>

                    <div id="botonBusqueda">
                        <img src="../img/botonaceptar.jpg" width="85" height="22" onClick="validarForm()" border="1" onMouseOver="style.cursor=cursor">
                        <img src="../img/botonlimpiar.jpg" width="69" height="22" onClick="limpiar()" border="1" onMouseOver="style.cursor=cursor">
                        <img src="../img/botoncancelar.jpg" width="85" height="22" onClick="cancelar()" border="1" onMouseOver="style.cursor=cursor">
                        <input id="accion" name="accion" value="alta" type="hidden">
                        <input id="id" name="Zid" value="" type="hidden">
                    </div>
            </form>
            </div>
            </div>
        </div>
    </body>
</html>