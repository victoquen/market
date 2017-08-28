/*
funciones de javascript para seleccionar los articulos de la factura
gestionando totales

*/
                var credit=0;




		var miPopup
		function abreVentana(){
                    var codfactura = document.getElementById("codfactura").value;
                    if(codfactura=="")
                    {
                        alert ("Debe ingresar el codigo de la FACTURA");
                    }
                    else
                    {
			miPopup = window.open("ver_clientes.php","miwin","width=900px,height=550px,scrollbars=yes");
			miPopup.focus();
                    }
		}

		function ventanaArticulos(op){
//			var codigo=document.getElementById("codcliente").value;
//			if (codigo=="") {
//				alert ("Debe seleccionar el cliente");
//			} else {
				miPopup = window.open("ver_articulos.php?op="+op,"miwin","width=700,height=580,scrollbars=yes");
				miPopup.focus();
//			}
		}

		function validarcliente(){
			var codigo=document.getElementById("codcliente").value;
			miPopup = window.open("comprobarcliente.php?codcliente="+codigo,"frame_datos","width=700,height=80,scrollbars=yes");
		}

		function cancelar() {
			location.href="index.php";
		}

		function limpiarcaja() {
                    document.getElementById("codcliente").value="";
			document.getElementById("nombre").value="";
			document.getElementById("nif").value="";
		}



		function validar_cabecera()
			{      
				var mensaje="";
                                if (document.getElementById("codfactura").value=="") mensaje+="  - Codigo Factura no ingresado\n";
				if (document.getElementById("nombre").value=="") mensaje+="  - Cliente no ingresado\n";
				if (document.getElementById("fecha").value=="") mensaje+="  - Fecha\n";
                                //if (credit =="0") mensaje+="  - Credito no seleccionado\n";
//				if (document.getElementById("cantidad1").value=="")
//                                {
//                                mensaje+="  - Falta la cantidad\n";
//                                } else {
//                                        enteroo=parseInt(document.getElementById("cantidad").value);
//                                        if (isNaN(enteroo)==true) {
//                                                mensaje+="  - La cantidad debe ser numerica\n";
//                                        } else {
//                                                        document.getElementById("cantidad").value=enteroo;
//                                                }
//                                }
//				if (document.getElementById("descuentoporc1").value=="")
//                                {
//                                document.getElementById("descuentoporc").value=0
//                                } else {
//                                        entero=parseInt(document.getElementById("descuentoporc").value);
//                                        if (isNaN(entero)==true) {
//                                                mensaje+="  - El descuento debe ser numerico\n";
//                                        } else {
//                                                document.getElementById("descuentoporc").value=entero;
//                                        }
//                                }
                                if (mensaje!="") {
					alert("Atencion, se han detectado las siguientes incorrecciones:\n\n"+mensaje);
				} else {
                                    //var afactur=document.getElementById("preciototal").value;
                                    //if (confirm("TOTAL A FACTURAR = "+afactur+"\n\nESTA SEGURO DE PROCEDER A FACTURAR?\nATENCION!\nAl confirmar no se podra modificar los datos de la Factura.")) {
					document.getElementById("formulario").submit();
                                     //}
				}
			}

		function validar()
			{
				var mensaje="";
				var entero=0;
				var enteroo=0;

				if (document.getElementById("codarticulo").value=="") mensaje="  - Codigo Producto\n";
				if (document.getElementById("descripcion").value=="") mensaje+="  - Descripcion Producto\n";
				if (document.getElementById("precio").value=="") {
							mensaje+="  - Falta el precio\n";
						} else {
							if (isNaN(document.getElementById("precio").value)==true) {
								mensaje+="  - El precio debe ser numerico\n";
							}
						}
				if (document.getElementById("cantidad").value=="")
						{
						mensaje+="  - Falta la cantidad\n";
						} else {
							enteroo=parseInt(document.getElementById("cantidad").value);
							if (isNaN(enteroo)==true) {
								mensaje+="  - La cantidad debe ser numerica\n";
							} else {
									document.getElementById("cantidad").value=enteroo;
								}
						}
				if (document.getElementById("descuentoporc").value=="")
						{
						document.getElementById("descuentoporc").value=0
						} else {
							entero=parseInt(document.getElementById("descuentoporc").value);
							if (isNaN(entero)==true) {
								mensaje+="  - El descuento debe ser numerico\n";
							} else {
								document.getElementById("descuentoporc").value=entero;
							}
						}
				if (document.getElementById("importe").value=="") mensaje+="  - Falta el importe\n";

				if (mensaje!="") {
					alert("Atencion, se han detectado las siguientes incorrecciones:\n\n"+mensaje);
				} else {
					document.getElementById("baseimponible").value=parseFloat(document.getElementById("baseimponible").value) + parseFloat(document.getElementById("importe").value);
					var original1=parseFloat(document.getElementById("baseimponible").value);
                                        var result1=Math.round(original1*100)/100 ;
                                        document.getElementById("baseimponible").value=result1;

                                        actualizar_totales();
					document.getElementById("formulario_lineas").submit();
					document.getElementById("codarticulo").value="";
					document.getElementById("descripcion").value="";
					document.getElementById("precio").value="";
					document.getElementById("cantidad").value=1;
					document.getElementById("importe").value="";
                                        document.getElementById("descuentoporc").value=0;
					document.getElementById("descuento").value=0;
                                        document.getElementById("iva").value="0";
				}
			}




                function actualizar_importe(op)
			{
                            var precio=0;
			    var precio_con_iva=0;
                            var cantidad=0;
                            var stock=0;
                            var original=0;
			    var original_iva=0;
                            var result=0;
			    var result_iva=0;
                            var total=0;
		            var total_con_iva=0;
                            var password=null;
                            var clave="a"
                            var password="a";
                            switch(op)
                            {
                                case 1:
					precio_con_iva=document.getElementById("precio_con_iva1").value;

					precio=document.getElementById("precio1").value;
                                        cantidad=document.getElementById("cantidad1").value;
                                        stock=document.getElementById("stock1").value;
                                        if(parseInt(cantidad)>parseInt(stock))
                                        {
                                            //password=prompt("STOCK INSUFICIENTE\nStock existente = "+stock+"\n\nPara permitira la cantidad\nIngrese el password ",'' );
                                            
                                            if(password!=clave)
                                            {
                                                //alert("Password incorrecto\nSTOCK INSUFICIENTE\n Stock existente = "+stock);
                                                
						total=precio*stock;

						total_con_iva=precio_con_iva*stock;

                                                document.getElementById("cantidad1").value=stock;
                                            }
                                            else
                                            {
                                                document.getElementById("cantidad1").value=cantidad;
                                                total=precio*cantidad;

						total_con_iva=precio_con_iva*cantidad;
                                            }
                                        }
                                        else
                                        {
                                            total=precio*cantidad;

					    total_con_iva=precio_con_iva*cantidad;	
                                        }
                                        original=parseFloat(total);
                                        result=Math.round(original*100)/100 ;
                                        document.getElementById("importe1").value=result.toFixed(2);

					original_iva=parseFloat(total_con_iva);
                                        result_iva=Math.round(original_iva*100)/100 ;
                                        document.getElementById("importe_con_iva1").value=result_iva.toFixed(2);

                                        break;
                                 case 2:
					precio_con_iva=document.getElementById("precio_con_iva2").value;

                                        precio=document.getElementById("precio2").value;
                                        cantidad=document.getElementById("cantidad2").value;
                                        stock=document.getElementById("stock2").value;
                                        if(parseInt(cantidad)>parseInt(stock))
                                        {
                                             //password=prompt("STOCK INSUFICIENTE\nStock existente = "+stock+"\n\nPara permitira la cantidad\nIngrese el password ",'' );

                                            if(password!=clave)
                                            {
                                                //alert("Password incorrecto\nSTOCK INSUFICIENTE\n Stock existente = "+stock);
                                                total=precio*stock;

						total_con_iva=precio_con_iva*stock;

                                                document.getElementById("cantidad2").value=stock;
                                            }
                                            else
                                            {
                                                document.getElementById("cantidad2").value=cantidad;
                                                 total=precio*cantidad;
						total_con_iva=precio_con_iva*cantidad;
                                            }
                                        }
                                        else
                                        {
                                            total=precio*cantidad;
					    total_con_iva=precio_con_iva*cantidad;
                                        }
                                        original=parseFloat(total);
                                        result=Math.round(original*100)/100 ;
                                        document.getElementById("importe2").value=result.toFixed(2);

					original_iva=parseFloat(total_con_iva);
                                        result_iva=Math.round(original_iva*100)/100 ;
                                        document.getElementById("importe_con_iva2").value=result_iva.toFixed(2);
                                        break;
                                 case 3:

					precio_con_iva=document.getElementById("precio_con_iva3").value;					

                                        precio=document.getElementById("precio3").value;
                                        cantidad=document.getElementById("cantidad3").value;
                                        stock=document.getElementById("stock3").value;
                                        if(parseInt(cantidad)>parseInt(stock))
                                        {
                                            //password=prompt("STOCK INSUFICIENTE\nStock existente = "+stock+"\n\nPara permitira la cantidad\nIngrese el password ",'' );

                                            if(password!=clave)
                                            {
                                                //alert("Password incorrecto\nSTOCK INSUFICIENTE\n Stock existente = "+stock);
                                                total=precio*stock;
						total_con_iva=precio_con_iva*stock;
                                                document.getElementById("cantidad3").value=stock;
                                            }
                                            else
                                            {
                                                document.getElementById("cantidad3").value=cantidad;
                                                 total=precio*cantidad;
						total_con_iva=precio_con_iva*cantidad;
                                            }
                                        }
                                        else
                                        {
                                            total=precio*cantidad;
					    total_con_iva=precio_con_iva*cantidad;
                                        }
                                        original=parseFloat(total);
                                        result=Math.round(original*100)/100 ;
                                        document.getElementById("importe3").value=result.toFixed(2);


					original_iva=parseFloat(total_con_iva);
                                        result_iva=Math.round(original_iva*100)/100 ;
                                        document.getElementById("importe_con_iva3").value=result_iva.toFixed(2);
                                        break;
                                 case 4:


					precio_con_iva=document.getElementById("precio_con_iva4").value;

                                        precio=document.getElementById("precio4").value;
                                        cantidad=document.getElementById("cantidad4").value;
                                        stock=document.getElementById("stock4").value;
                                        if(parseInt(cantidad)>parseInt(stock))
                                        {
                                            //password=prompt("STOCK INSUFICIENTE\nStock existente = "+stock+"\n\nPara permitira la cantidad\nIngrese el password ",'' );

                                            if(password!=clave)
                                            {
                                                //alert("Password incorrecto\nSTOCK INSUFICIENTE\n Stock existente = "+stock);
                                                total=precio*stock;
						total_con_iva=precio_con_iva*stock;
                                                document.getElementById("cantidad4").value=stock;
                                            }
                                            else
                                            {
                                                document.getElementById("cantidad4").value=cantidad;
                                                 total=precio*cantidad;
						total_con_iva=precio_con_iva*cantidad;
                                            }
                                        }
                                        else
                                        {
                                            total=precio*cantidad;
					    total_con_iva=precio_con_iva*cantidad;
                                        }
                                        original=parseFloat(total);
                                        result=Math.round(original*100)/100 ;
                                        document.getElementById("importe4").value=result.toFixed(2);

					original_iva=parseFloat(total_con_iva);
                                        result_iva=Math.round(original_iva*100)/100 ;
                                        document.getElementById("importe_con_iva4").value=result_iva.toFixed(2);
                                        break;
                                 case 5:

					precio_con_iva=document.getElementById("precio_con_iva5").value;

                                        precio=document.getElementById("precio5").value;
                                        cantidad=document.getElementById("cantidad5").value;
                                        stock=document.getElementById("stock5").value;
                                        if(parseInt(cantidad)>parseInt(stock))
                                        {
                                             //password=prompt("STOCK INSUFICIENTE\nStock existente = "+stock+"\n\nPara permitira la cantidad\nIngrese el password ",'' );

                                            if(password!=clave)
                                            {
                                                //alert("Password incorrecto\nSTOCK INSUFICIENTE\n Stock existente = "+stock);
                                                total=precio*stock;
						total_con_iva=precio_con_iva*stock;
                                                document.getElementById("cantidad5").value=stock;
                                            }
                                            else
                                            {
                                                document.getElementById("cantidad5").value=cantidad;
                                                 total=precio*cantidad;
						total_con_iva=precio_con_iva*cantidad;
                                            }
                                        }
                                        else
                                        {
                                            total=precio*cantidad;
					    total_con_iva=precio_con_iva*cantidad;
                                        }
                                        original=parseFloat(total);
                                        result=Math.round(original*100)/100 ;
                                        document.getElementById("importe5").value=result.toFixed(2);

					original_iva=parseFloat(total_con_iva);
                                        result_iva=Math.round(original_iva*100)/100 ;
                                        document.getElementById("importe_con_iva5").value=result_iva.toFixed(2);
                                        break;
                                 case 6:

					precio_con_iva=document.getElementById("precio_con_iva6").value;

                                        precio=document.getElementById("precio6").value;
                                        cantidad=document.getElementById("cantidad6").value;
                                        stock=document.getElementById("stock6").value;
                                        if(parseInt(cantidad)>parseInt(stock))
                                        {
                                             //password=prompt("STOCK INSUFICIENTE\nStock existente = "+stock+"\n\nPara permitira la cantidad\nIngrese el password ",'' );

                                            if(password!=clave)
                                            {
                                                //alert("Password incorrecto\nSTOCK INSUFICIENTE\n Stock existente = "+stock);
                                                total=precio*stock;
						total_con_iva=precio_con_iva*stock;
                                                document.getElementById("cantidad6").value=stock;
                                            }
                                            else
                                            {
                                                document.getElementById("cantidad6").value=cantidad;
                                                 total=precio*cantidad;
						total_con_iva=precio_con_iva*cantidad;
                                            }
                                        }
                                        else
                                        {
                                            total=precio*cantidad;
					    total_con_iva=precio_con_iva*cantidad;
                                        }
                                        original=parseFloat(total);
                                        result=Math.round(original*100)/100 ;
                                        document.getElementById("importe6").value=result.toFixed(2);

					original_iva=parseFloat(total_con_iva);
                                        result_iva=Math.round(original_iva*100)/100 ;
                                        document.getElementById("importe_con_iva6").value=result_iva.toFixed(2);
                                        break;
                                 case 7:

					precio_con_iva=document.getElementById("precio_con_iva7").value;

                                        precio=document.getElementById("precio7").value;
                                        cantidad=document.getElementById("cantidad7").value;
                                        stock=document.getElementById("stock7").value;
                                        if(parseInt(cantidad)>parseInt(stock))
                                        {
                                             //password=prompt("STOCK INSUFICIENTE\nStock existente = "+stock+"\n\nPara permitira la cantidad\nIngrese el password ",'' );

                                            if(password!=clave)
                                            {
                                                //alert("Password incorrecto\nSTOCK INSUFICIENTE\n Stock existente = "+stock);
                                                total=precio*stock;
						total_con_iva=precio_con_iva*stock;
                                                document.getElementById("cantidad7").value=stock;
                                            }
                                            else
                                            {
                                                document.getElementById("cantidad7").value=cantidad;
                                                 total=precio*cantidad;
						total_con_iva=precio_con_iva*cantidad;
                                            }
                                        }
                                        else
                                        {
                                            total=precio*cantidad;
					    total_con_iva=precio_con_iva*cantidad;
                                        }
                                        original=parseFloat(total);
                                        result=Math.round(original*100)/100 ;
                                        document.getElementById("importe7").value=result.toFixed(2);

					original_iva=parseFloat(total_con_iva);
                                        result_iva=Math.round(original_iva*100)/100 ;
                                        document.getElementById("importe_con_iva7").value=result_iva.toFixed(2);
                                        break;
                                 case 8:

					precio_con_iva=document.getElementById("precio_con_iva8").value;

                                        precio=document.getElementById("precio8").value;
                                        cantidad=document.getElementById("cantidad8").value;
                                        stock=document.getElementById("stock8").value;
                                        if(parseInt(cantidad)>parseInt(stock))
                                        {
                                             //password=prompt("STOCK INSUFICIENTE\nStock existente = "+stock+"\n\nPara permitira la cantidad\nIngrese el password ",'' );

                                            if(password!=clave)
                                            {
                                                //alert("Password incorrecto\nSTOCK INSUFICIENTE\n Stock existente = "+stock);
                                                total=precio*stock;
						total_con_iva=precio_con_iva*stock;
                                                document.getElementById("cantidad8").value=stock;
                                            }
                                            else
                                            {
                                                document.getElementById("cantidad8").value=cantidad;
                                                 total=precio*cantidad;
						total_con_iva=precio_con_iva*cantidad;
                                            }
                                        }
                                        else
                                        {
                                            total=precio*cantidad;
					    total_con_iva=precio_con_iva*cantidad;
                                        }
                                        original=parseFloat(total);
                                        result=Math.round(original*100)/100 ;
                                        document.getElementById("importe8").value=result.toFixed(2);

					original_iva=parseFloat(total_con_iva);
                                        result_iva=Math.round(original_iva*100)/100 ;
                                        document.getElementById("importe_con_iva8").value=result_iva.toFixed(2);
                                        break;
                                 case 9:

					precio_con_iva=document.getElementById("precio_con_iva9").value;

                                        precio=document.getElementById("precio9").value;
                                        cantidad=document.getElementById("cantidad9").value;
                                        stock=document.getElementById("stock9").value;
                                        if(parseInt(cantidad)>parseInt(stock))
                                        {
                                            //password=prompt("STOCK INSUFICIENTE\nStock existente = "+stock+"\n\nPara permitira la cantidad\nIngrese el password ",'' );

                                            if(password!=clave)
                                            {
                                                //alert("Password incorrecto\nSTOCK INSUFICIENTE\n Stock existente = "+stock);
                                                total=precio*stock;
						total_con_iva=precio_con_iva*stock;
                                                document.getElementById("cantidad9").value=stock;
                                            }
                                            else
                                            {
                                                document.getElementById("cantidad9").value=cantidad;
                                                 total=precio*cantidad;
						total_con_iva=precio_con_iva*cantidad;
                                            }
                                        }
                                        else
                                        {
                                            total=precio*cantidad;
					    total_con_iva=precio_con_iva*cantidad;
                                        }
                                        original=parseFloat(total);
                                        result=Math.round(original*100)/100 ;
                                        document.getElementById("importe9").value=result.toFixed(2);

					original_iva=parseFloat(total_con_iva);
                                        result_iva=Math.round(original_iva*100)/100 ;
                                        document.getElementById("importe_con_iva9").value=result_iva.toFixed(2);
                                        break;
                                 case 10:

					precio_con_iva=document.getElementById("precio_con_iva10").value;

                                        precio=document.getElementById("precio10").value;
                                        cantidad=document.getElementById("cantidad10").value;
                                        stock=document.getElementById("stock10").value;
                                        if(parseInt(cantidad)>parseInt(stock))
                                        {
                                             //password=prompt("STOCK INSUFICIENTE\nStock existente = "+stock+"\n\nPara permitira la cantidad\nIngrese el password ",'' );

                                            if(password!=clave)
                                            {
                                                //alert("Password incorrecto\nSTOCK INSUFICIENTE\n Stock existente = "+stock);
                                                total=precio*stock;
						total_con_iva=precio_con_iva*stock;
                                                document.getElementById("cantidad10").value=stock;
                                            }
                                            else
                                            {
                                                document.getElementById("cantidad10").value=cantidad;
                                                 total=precio*cantidad;
						total_con_iva=precio_con_iva*cantidad;
                                            }
                                        }
                                        else
                                        {
                                            total=precio*cantidad;
					    total_con_iva=precio_con_iva*cantidad;
                                        }
                                        original=parseFloat(total);
                                        result=Math.round(original*100)/100 ;
                                        document.getElementById("importe10").value=result.toFixed(2);

					original_iva=parseFloat(total_con_iva);
                                        result_iva=Math.round(original_iva*100)/100 ;
                                        document.getElementById("importe_con_iva10").value=result_iva.toFixed(2);
                                        break;
                                 case 11:

					precio_con_iva=document.getElementById("precio_con_iva11").value;

                                        precio=document.getElementById("precio11").value;
                                        cantidad=document.getElementById("cantidad11").value;
                                        stock=document.getElementById("stock11").value;
                                        if(parseInt(cantidad)>parseInt(stock))
                                        {
                                             //password=prompt("STOCK INSUFICIENTE\nStock existente = "+stock+"\n\nPara permitira la cantidad\nIngrese el password ",'' );

                                            if(password!=clave)
                                            {
                                                //alert("Password incorrecto\nSTOCK INSUFICIENTE\n Stock existente = "+stock);
                                                total=precio*stock;
						total_con_iva=precio_con_iva*stock;
                                                document.getElementById("cantidad11").value=stock;
                                            }
                                            else
                                            {
                                                document.getElementById("cantidad11").value=cantidad;
                                                 total=precio*cantidad;
						total_con_iva=precio_con_iva*cantidad;
                                            }
                                        }
                                        else
                                        {
                                            total=precio*cantidad;
					    total_con_iva=precio_con_iva*cantidad;
                                        }
                                        original=parseFloat(total);
                                        result=Math.round(original*100)/100 ;
                                        document.getElementById("importe11").value=result.toFixed(2);
	
					original_iva=parseFloat(total_con_iva);
                                        result_iva=Math.round(original_iva*100)/100 ;
                                        document.getElementById("importe_con_iva11").value=result_iva.toFixed(2);
                                        break;

                            }
                                actualizar_descuento(op);
                                //suma_iva(op);
			}

                function actualizar_descuento(op)
                {
                    switch(op)
                    {
                        case 1:
                                var original=parseFloat(document.getElementById("importe1").value);
                                var result=Math.round(original*100)/100 ;
                                document.getElementById("descuento1").value=parseFloat(result * parseFloat(document.getElementById("descuentoporc1").value / 100));
                                var original1=parseFloat(document.getElementById("descuento1").value);
                                var result1=Math.round(original1*100)/100 ;
                                document.getElementById("descuento1").value=result1.toFixed(2);
                                break;
                        case 2:
                                var original=parseFloat(document.getElementById("importe2").value);
                                var result=Math.round(original*100)/100 ;
                                document.getElementById("descuento2").value=parseFloat(result * parseFloat(document.getElementById("descuentoporc2").value / 100));
                                var original1=parseFloat(document.getElementById("descuento2").value);
                                var result1=Math.round(original1*100)/100 ;
                                document.getElementById("descuento2").value=result1.toFixed(2);
                                break;
                       case 3:
                                var original=parseFloat(document.getElementById("importe3").value);
                                var result=Math.round(original*100)/100 ;
                                document.getElementById("descuento3").value=parseFloat(result * parseFloat(document.getElementById("descuentoporc3").value / 100));
                                var original1=parseFloat(document.getElementById("descuento3").value);
                                var result1=Math.round(original1*100)/100 ;
                                document.getElementById("descuento3").value=result1.toFixed(2);
                                break;
                       case 4:
                                var original=parseFloat(document.getElementById("importe4").value);
                                var result=Math.round(original*100)/100 ;
                                document.getElementById("descuento4").value=parseFloat(result * parseFloat(document.getElementById("descuentoporc4").value / 100));
                                var original1=parseFloat(document.getElementById("descuento4").value);
                                var result1=Math.round(original1*100)/100 ;
                                document.getElementById("descuento4").value=result1.toFixed(2);
                                break;
                       case 5:
                                var original=parseFloat(document.getElementById("importe5").value);
                                var result=Math.round(original*100)/100 ;
                                document.getElementById("descuento5").value=parseFloat(result * parseFloat(document.getElementById("descuentoporc5").value / 100));
                                var original1=parseFloat(document.getElementById("descuento5").value);
                                var result1=Math.round(original1*100)/100 ;
                                document.getElementById("descuento5").value=result1.toFixed(2);
                                break;
                       case 6:
                                var original=parseFloat(document.getElementById("importe6").value);
                                var result=Math.round(original*100)/100 ;
                                document.getElementById("descuento6").value=parseFloat(result * parseFloat(document.getElementById("descuentoporc6").value / 100));
                                var original1=parseFloat(document.getElementById("descuento6").value);
                                var result1=Math.round(original1*100)/100 ;
                                document.getElementById("descuento6").value=result1.toFixed(2);
                                break;
                        case 7:
                                var original=parseFloat(document.getElementById("importe7").value);
                                var result=Math.round(original*100)/100 ;
                                document.getElementById("descuento7").value=parseFloat(result * parseFloat(document.getElementById("descuentoporc7").value / 100));
                                var original1=parseFloat(document.getElementById("descuento7").value);
                                var result1=Math.round(original1*100)/100 ;
                                document.getElementById("descuento7").value=result1.toFixed(2);
                                break;
                        case 8:
                                var original=parseFloat(document.getElementById("importe8").value);
                                var result=Math.round(original*100)/100 ;
                                document.getElementById("descuento8").value=parseFloat(result * parseFloat(document.getElementById("descuentoporc8").value / 100));
                                var original1=parseFloat(document.getElementById("descuento8").value);
                                var result1=Math.round(original1*100)/100 ;
                                document.getElementById("descuento8").value=result1.toFixed(2);
                                break;
                       case 9:
                                var original=parseFloat(document.getElementById("importe9").value);
                                var result=Math.round(original*100)/100 ;
                                document.getElementById("descuento9").value=parseFloat(result * parseFloat(document.getElementById("descuentoporc9").value / 100));
                                var original1=parseFloat(document.getElementById("descuento9").value);
                                var result1=Math.round(original1*100)/100 ;
                                document.getElementById("descuento9").value=result1.toFixed(2);
                                break;
                       case 10:
                                var original=parseFloat(document.getElementById("importe10").value);
                                var result=Math.round(original*100)/100 ;
                                document.getElementById("descuento10").value=parseFloat(result * parseFloat(document.getElementById("descuentoporc10").value / 100));
                                var original1=parseFloat(document.getElementById("descuento10").value);
                                var result1=Math.round(original1*100)/100 ;
                                document.getElementById("descuento10").value=result1.toFixed(2);
                                break;
                       case 11:
                                var original=parseFloat(document.getElementById("importe11").value);
                                var result=Math.round(original*100)/100 ;
                                document.getElementById("descuento11").value=parseFloat(result * parseFloat(document.getElementById("descuentoporc11").value / 100));
                                var original1=parseFloat(document.getElementById("descuento11").value);
                                var result1=Math.round(original1*100)/100 ;
                                document.getElementById("descuento11").value=result1.toFixed(2);
                                break;
                    }

                        suma_iva(op);
                }

                function suma_iva(op)
                {
                    switch(op)
                    {
                        case 1:

				if(document.getElementById("transformacion1").value == 2)
                                {
					var org=parseFloat(document.getElementById("importe_con_iva1").value);
                                	var res=Math.round(org*100)/100 ;
                                	var desc=parseFloat(res * parseFloat(document.getElementById("descuentoporc1").value / 100));
                                	var org1=parseFloat(desc);
                                	var res1=Math.round(org1*100)/100 ;											                                        	                        
                        	        var result_aux=res-res1;	
				}
				else
				{
                                	var original=parseFloat(document.getElementById("importe1").value);
	                                var result=Math.round(original*100)/100 ;
        	                        var original1=parseFloat(document.getElementById("descuento1").value);
                	                var result1=Math.round(original1*100)/100 ;
                        	        var result_aux=result-result1;
				}
				
                                document.getElementById("iva1").value=parseFloat(result_aux * parseFloat(document.getElementById("ivaporc1").value / 100));
                                var original2=parseFloat(document.getElementById("iva1").value);
                                var result2=Math.round(original2*100)/100 ;
                                document.getElementById("iva1").value=result2.toFixed(2);
                                break;
                        case 2:

				if(document.getElementById("transformacion2").value == 2)
                                {
					var org=parseFloat(document.getElementById("importe_con_iva2").value);
                                	var res=Math.round(org*100)/100 ;
                                	var desc=parseFloat(res * parseFloat(document.getElementById("descuentoporc2").value / 100));
                                	var org1=parseFloat(desc);
                                	var res1=Math.round(org1*100)/100 ;
					
					
	                                
        	                        
                        	        var result_aux=res-res1;	
				}
				else
				{							
                                	var original=parseFloat(document.getElementById("importe2").value);
                                	var result=Math.round(original*100)/100 ;
                                	var original1=parseFloat(document.getElementById("descuento2").value);
                                	var result1=Math.round(original1*100)/100 ;
                                	var result_aux=result-result1;
				}

                                document.getElementById("iva2").value=parseFloat(result_aux * parseFloat(document.getElementById("ivaporc2").value / 100));
                                var original2=parseFloat(document.getElementById("iva2").value);
                                var result2=Math.round(original2*100)/100 ;
                                document.getElementById("iva2").value=result2.toFixed(2);
                                break;
                        case 3:

				if(document.getElementById("transformacion3").value == 2)
                                {
					var org=parseFloat(document.getElementById("importe_con_iva3").value);
                                	var res=Math.round(org*100)/100 ;
                                	var desc=parseFloat(res * parseFloat(document.getElementById("descuentoporc3").value / 100));
                                	var org1=parseFloat(desc);
                                	var res1=Math.round(org1*100)/100 ;
					
					
	                                
        	                        
                        	        var result_aux=res-res1;	
				}
				else
				{
                                	var original=parseFloat(document.getElementById("importe3").value);
                                	var result=Math.round(original*100)/100 ;
                                	var original1=parseFloat(document.getElementById("descuento3").value);
                                	var result1=Math.round(original1*100)/100 ;
                                	var result_aux=result-result1;
				}

                                document.getElementById("iva3").value=parseFloat(result_aux * parseFloat(document.getElementById("ivaporc3").value / 100));
                                var original2=parseFloat(document.getElementById("iva3").value);
                                var result2=Math.round(original2*100)/100 ;
                                document.getElementById("iva3").value=result2.toFixed(2);
                                break;
                        case 4:
				if(document.getElementById("transformacion4").value == 2)
                                {
					var org=parseFloat(document.getElementById("importe_con_iva4").value);
                                	var res=Math.round(org*100)/100 ;
                                	var desc=parseFloat(res * parseFloat(document.getElementById("descuentoporc4").value / 100));
                                	var org1=parseFloat(desc);
                                	var res1=Math.round(org1*100)/100 ;
					
					
	                                
        	                        
                        	        var result_aux=res-res1;	
				}
				else
				{
                                	var original=parseFloat(document.getElementById("importe4").value);
                                	var result=Math.round(original*100)/100 ;
                                	var original1=parseFloat(document.getElementById("descuento4").value);
                                	var result1=Math.round(original1*100)/100 ;
                                	var result_aux=result-result1;
				}

                                document.getElementById("iva4").value=parseFloat(result_aux * parseFloat(document.getElementById("ivaporc4").value / 100));
                                var original2=parseFloat(document.getElementById("iva4").value);
                                var result2=Math.round(original2*100)/100 ;
                                document.getElementById("iva4").value=result2.toFixed(2);
                                break;
                        case 5:
				if(document.getElementById("transformacion5").value == 2)
                                {
					var org=parseFloat(document.getElementById("importe_con_iva5").value);
                                	var res=Math.round(org*100)/100 ;
                                	var desc=parseFloat(res * parseFloat(document.getElementById("descuentoporc5").value / 100));
                                	var org1=parseFloat(desc);
                                	var res1=Math.round(org1*100)/100 ;
					
					
	                                
        	                        
                        	        var result_aux=res-res1;	
				}
				else
				{
                                	var original=parseFloat(document.getElementById("importe5").value);
                                	var result=Math.round(original*100)/100 ;
                                	var original1=parseFloat(document.getElementById("descuento5").value);
                                	var result1=Math.round(original1*100)/100 ;
                                	var result_aux=result-result1;
				}

                                document.getElementById("iva5").value=parseFloat(result_aux * parseFloat(document.getElementById("ivaporc5").value / 100));
                                var original2=parseFloat(document.getElementById("iva5").value);
                                var result2=Math.round(original2*100)/100 ;
                                document.getElementById("iva5").value=result2.toFixed(2);
                                break;
                        case 6:
				if(document.getElementById("transformacion6").value == 2)
                                {
					var org=parseFloat(document.getElementById("importe_con_iva6").value);
                                	var res=Math.round(org*100)/100 ;
                                	var desc=parseFloat(res * parseFloat(document.getElementById("descuentoporc6").value / 100));
                                	var org1=parseFloat(desc);
                                	var res1=Math.round(org1*100)/100 ;
					
					
	                                
        	                        
                        	        var result_aux=res-res1;	
				}
				else
				{
                                	var original=parseFloat(document.getElementById("importe6").value);
                                	var result=Math.round(original*100)/100 ;
                                	var original1=parseFloat(document.getElementById("descuento6").value);
                                	var result1=Math.round(original1*100)/100 ;
                                	var result_aux=result-result1;
				}

                                document.getElementById("iva6").value=parseFloat(result_aux * parseFloat(document.getElementById("ivaporc6").value / 100));
                                var original2=parseFloat(document.getElementById("iva6").value);
                                var result2=Math.round(original2*100)/100 ;
                                document.getElementById("iva6").value=result2.toFixed(2);
                                break;
                        case 7:
				if(document.getElementById("transformacion7").value == 2)
                                {
					var org=parseFloat(document.getElementById("importe_con_iva7").value);
                                	var res=Math.round(org*100)/100 ;
                                	var desc=parseFloat(res * parseFloat(document.getElementById("descuentoporc7").value / 100));
                                	var org1=parseFloat(desc);
                                	var res1=Math.round(org1*100)/100 ;
					
					
	                                
        	                        
                        	        var result_aux=res-res1;	
				}
				else
				{
                                	var original=parseFloat(document.getElementById("importe7").value);
                                	var result=Math.round(original*100)/100 ;
                                	var original1=parseFloat(document.getElementById("descuento7").value);
                                	var result1=Math.round(original1*100)/100 ;
                                	var result_aux=result-result1;
				}

                                document.getElementById("iva7").value=parseFloat(result_aux * parseFloat(document.getElementById("ivaporc7").value / 100));
                                var original2=parseFloat(document.getElementById("iva7").value);
                                var result2=Math.round(original2*100)/100 ;
                                document.getElementById("iva7").value=result2.toFixed(2);
                                break;
                        case 8:
				if(document.getElementById("transformacion8").value == 2)
                                {
					var org=parseFloat(document.getElementById("importe_con_iva8").value);
                                	var res=Math.round(org*100)/100 ;
                                	var desc=parseFloat(res * parseFloat(document.getElementById("descuentoporc8").value / 100));
                                	var org1=parseFloat(desc);
                                	var res1=Math.round(org1*100)/100 ;
					
					
	                                
        	                        
                        	        var result_aux=res-res1;	
				}
				else
				{
                                	var original=parseFloat(document.getElementById("importe8").value);
                                	var result=Math.round(original*100)/100 ;
                                	var original1=parseFloat(document.getElementById("descuento8").value);
                                	var result1=Math.round(original1*100)/100 ;
                                	var result_aux=result-result1;
				}

                                document.getElementById("iva8").value=parseFloat(result_aux * parseFloat(document.getElementById("ivaporc8").value / 100));
                                var original2=parseFloat(document.getElementById("iva8").value);
                                var result2=Math.round(original2*100)/100 ;
                                document.getElementById("iva8").value=result2.toFixed(2);
                                break;
                        case 9:
				if(document.getElementById("transformacion9").value == 2)
                                {
					var org=parseFloat(document.getElementById("importe_con_iva9").value);
                                	var res=Math.round(org*100)/100 ;
                                	var desc=parseFloat(res * parseFloat(document.getElementById("descuentoporc9").value / 100));
                                	var org1=parseFloat(desc);
                                	var res1=Math.round(org1*100)/100 ;
					
					
	                                
        	                        
                        	        var result_aux=res-res1;	
				}
				else
				{
                                	var original=parseFloat(document.getElementById("importe9").value);
                                	var result=Math.round(original*100)/100 ;
                                	var original1=parseFloat(document.getElementById("descuento9").value);
                                	var result1=Math.round(original1*100)/100 ;
                                	var result_aux=result-result1;
				}

                                document.getElementById("iva9").value=parseFloat(result_aux * parseFloat(document.getElementById("ivaporc9").value / 100));
                                var original2=parseFloat(document.getElementById("iva9").value);
                                var result2=Math.round(original2*100)/100 ;
                                document.getElementById("iva9").value=result2.toFixed(2);
                                break;
                        case 10:
				if(document.getElementById("transformacion10").value == 2)
                                {
					var org=parseFloat(document.getElementById("importe_con_iva10").value);
                                	var res=Math.round(org*100)/100 ;
                                	var desc=parseFloat(res * parseFloat(document.getElementById("descuentoporc10").value / 100));
                                	var org1=parseFloat(desc);
                                	var res1=Math.round(org1*100)/100 ;
					
					
	                                
        	                        
                        	        var result_aux=res-res1;	
				}
				else
				{
                                	var original=parseFloat(document.getElementById("importe10").value);
                                	var result=Math.round(original*100)/100 ;
                                	var original1=parseFloat(document.getElementById("descuento10").value);
                                	var result1=Math.round(original1*100)/100 ;
                                	var result_aux=result-result1;
				}

                                document.getElementById("iva10").value=parseFloat(result_aux * parseFloat(document.getElementById("ivaporc10").value / 100));
                                var original2=parseFloat(document.getElementById("iva10").value);
                                var result2=Math.round(original2*100)/100 ;
                                document.getElementById("iva10").value=result2.toFixed(2);
                                break;
                        case 11:
				if(document.getElementById("transformacion11").value == 2)
                                {
					var org=parseFloat(document.getElementById("importe_con_iva11").value);
                                	var res=Math.round(org*100)/100 ;
                                	var desc=parseFloat(res * parseFloat(document.getElementById("descuentoporc11").value / 100));
                                	var org1=parseFloat(desc);
                                	var res1=Math.round(org1*100)/100 ;
					
					
	                                
        	                        
                        	        var result_aux=res-res1;	
				}
				else
				{
                                	var original=parseFloat(document.getElementById("importe11").value);
                                	var result=Math.round(original*100)/100 ;
                                	var original1=parseFloat(document.getElementById("descuento11").value);
                                	var result1=Math.round(original1*100)/100 ;
                                	var result_aux=result-result1;
				}
                                document.getElementById("iva11").value=parseFloat(result_aux * parseFloat(document.getElementById("ivaporc11").value / 100));
                                var original2=parseFloat(document.getElementById("iva11").value);
                                var result2=Math.round(original2*100)/100 ;
                                document.getElementById("iva11").value=result2.toFixed(2);
                                break;
                    }
                    actualizar_subtotal(op)

                }

                function actualizar_subtotal(op)
                {
                    switch(op)
                    {
                         case 1:
                                var original=parseFloat(document.getElementById("importe1").value);
                                var result=Math.round(original*100)/100 ;
                                var original1=parseFloat(document.getElementById("descuento1").value);
                                var result1=Math.round(original1*100)/100 ;
                                var original2=parseFloat(document.getElementById("iva1").value);
                                var result2=Math.round(original2*100)/100 ;
                                var result_aux=result-result1+result2;
                                var res_subt=Math.round(result_aux*100)/100;
                                document.getElementById("subt1").value=res_subt.toFixed(2);
                                break;
                        case 2:
                                var original=parseFloat(document.getElementById("importe2").value);
                                var result=Math.round(original*100)/100 ;
                                var original1=parseFloat(document.getElementById("descuento2").value);
                                var result1=Math.round(original1*100)/100 ;
                                var original2=parseFloat(document.getElementById("iva2").value);
                                var result2=Math.round(original2*100)/100 ;
                                var result_aux=result-result1+result2;
                                var res_subt=Math.round(result_aux*100)/100;
                                document.getElementById("subt2").value=res_subt.toFixed(2);
                                break;
                        case 3:
                                var original=parseFloat(document.getElementById("importe3").value);
                                var result=Math.round(original*100)/100 ;
                                var original1=parseFloat(document.getElementById("descuento3").value);
                                var result1=Math.round(original1*100)/100 ;
                                var original2=parseFloat(document.getElementById("iva3").value);
                                var result2=Math.round(original2*100)/100 ;
                                var result_aux=result-result1+result2;
                                var res_subt=Math.round(result_aux*100)/100;
                                document.getElementById("subt3").value=res_subt.toFixed(2);
                                break;
                        case 4:
                                var original=parseFloat(document.getElementById("importe4").value);
                                var result=Math.round(original*100)/100 ;
                                var original1=parseFloat(document.getElementById("descuento4").value);
                                var result1=Math.round(original1*100)/100 ;
                                var original2=parseFloat(document.getElementById("iva4").value);
                                var result2=Math.round(original2*100)/100 ;
                                var result_aux=result-result1+result2;
                                var res_subt=Math.round(result_aux*100)/100;
                                document.getElementById("subt4").value=res_subt.toFixed(2);
                                break;
                        case 5:
                                var original=parseFloat(document.getElementById("importe5").value);
                                var result=Math.round(original*100)/100 ;
                                var original1=parseFloat(document.getElementById("descuento5").value);
                                var result1=Math.round(original1*100)/100 ;
                                var original2=parseFloat(document.getElementById("iva5").value);
                                var result2=Math.round(original2*100)/100 ;
                                var result_aux=result-result1+result2;
                                var res_subt=Math.round(result_aux*100)/100;
                                document.getElementById("subt5").value=res_subt.toFixed(2);
                                break;
                        case 6:
                                var original=parseFloat(document.getElementById("importe6").value);
                                var result=Math.round(original*100)/100 ;
                                var original1=parseFloat(document.getElementById("descuento6").value);
                                var result1=Math.round(original1*100)/100 ;
                                var original2=parseFloat(document.getElementById("iva6").value);
                                var result2=Math.round(original2*100)/100 ;
                                var result_aux=result-result1+result2;
                                var res_subt=Math.round(result_aux*100)/100;
                                document.getElementById("subt6").value=res_subt.toFixed(2);
                                break;
                        case 7:
                                var original=parseFloat(document.getElementById("importe7").value);
                                var result=Math.round(original*100)/100 ;
                                var original1=parseFloat(document.getElementById("descuento7").value);
                                var result1=Math.round(original1*100)/100 ;
                                var original2=parseFloat(document.getElementById("iva7").value);
                                var result2=Math.round(original2*100)/100 ;
                                var result_aux=result-result1+result2;
                                var res_subt=Math.round(result_aux*100)/100;
                                document.getElementById("subt7").value=res_subt.toFixed(2);
                                break;
                        case 8:
                                var original=parseFloat(document.getElementById("importe8").value);
                                var result=Math.round(original*100)/100 ;
                                var original1=parseFloat(document.getElementById("descuento8").value);
                                var result1=Math.round(original1*100)/100 ;
                                var original2=parseFloat(document.getElementById("iva8").value);
                                var result2=Math.round(original2*100)/100 ;
                                var result_aux=result-result1+result2;
                                var res_subt=Math.round(result_aux*100)/100;
                                document.getElementById("subt8").value=res_subt.toFixed(2);
                                break;
                        case 9:
                                var original=parseFloat(document.getElementById("importe9").value);
                                var result=Math.round(original*100)/100 ;
                                var original1=parseFloat(document.getElementById("descuento9").value);
                                var result1=Math.round(original1*100)/100 ;
                                var original2=parseFloat(document.getElementById("iva9").value);
                                var result2=Math.round(original2*100)/100 ;
                                var result_aux=result-result1+result2;
                                var res_subt=Math.round(result_aux*100)/100;
                                document.getElementById("subt9").value=res_subt.toFixed(2);
                                break;
                        case 10:
                                var original=parseFloat(document.getElementById("importe10").value);
                                var result=Math.round(original*100)/100 ;
                                var original1=parseFloat(document.getElementById("descuento10").value);
                                var result1=Math.round(original1*100)/100 ;
                                var original2=parseFloat(document.getElementById("iva10").value);
                                var result2=Math.round(original2*100)/100 ;
                                var result_aux=result-result1+result2;
                                var res_subt=Math.round(result_aux*100)/100;
                                document.getElementById("subt10").value=res_subt.toFixed(2);
                                break;
                        case 11:
                                var original=parseFloat(document.getElementById("importe11").value);
                                var result=Math.round(original*100)/100 ;
                                var original1=parseFloat(document.getElementById("descuento11").value);
                                var result1=Math.round(original1*100)/100 ;
                                var original2=parseFloat(document.getElementById("iva11").value);
                                var result2=Math.round(original2*100)/100 ;
                                var result_aux=result-result1+result2;
                                var res_subt=Math.round(result_aux*100)/100;
                                document.getElementById("subt11").value=res_subt.toFixed(2);
                                break;
                    }
                    actualizar_totales();
                }


                 function actualizar_totales()
                {

                    var subtotal=0;
                    subtotal=parseFloat(document.getElementById("importe1").value) +
                                 parseFloat(document.getElementById("importe2").value) +
                                 parseFloat(document.getElementById("importe3").value) +
                                 parseFloat(document.getElementById("importe4").value) +
                                 parseFloat(document.getElementById("importe5").value) +
                                 parseFloat(document.getElementById("importe6").value) +
                                 parseFloat(document.getElementById("importe7").value) +
                                 parseFloat(document.getElementById("importe8").value) +
                                 parseFloat(document.getElementById("importe9").value) +
                                 parseFloat(document.getElementById("importe10").value) +
                                 parseFloat(document.getElementById("importe11").value);

                    var descuento=0;
	 	    descuento=parseFloat(document.getElementById("descuento1").value)+
                                  parseFloat(document.getElementById("descuento2").value)+
                                  parseFloat(document.getElementById("descuento3").value)+
                                  parseFloat(document.getElementById("descuento4").value)+
                                  parseFloat(document.getElementById("descuento5").value)+
                                  parseFloat(document.getElementById("descuento6").value)+
                                  parseFloat(document.getElementById("descuento7").value)+
                                  parseFloat(document.getElementById("descuento8").value)+
                                  parseFloat(document.getElementById("descuento9").value)+
                                  parseFloat(document.getElementById("descuento10").value)+
                                  parseFloat(document.getElementById("descuento11").value);


	 	    var imp_iva0=0;
	 	    var imp_iva12=0;
	 	    var importe_iva=0;


		    if(document.getElementById("ivaporc1").value=='0')
                    {
                        imp_iva0 +=parseFloat(document.getElementById("importe1").value) - parseFloat(document.getElementById("descuento1").value);

                    }
                    else
                    {
			if(document.getElementById("transformacion1").value=='2')
			{				
				var iva0=(parseFloat(document.getElementById("importe1").value) - parseFloat(document.getElementById("importe_con_iva1").value));
				var iva12=parseFloat(document.getElementById("importe_con_iva1").value);

				var desc_iva0 = parseFloat(iva0 * parseFloat(document.getElementById("descuentoporc1").value / 100));
                                var orig_iva0=parseFloat(desc_iva0);
                                var res_iva0=Math.round(orig_iva0*100)/100 ;

				var desc_iva12 = parseFloat(iva12 * parseFloat(document.getElementById("descuentoporc1").value / 100));
                                var orig_iva12=parseFloat(desc_iva12);
                                var res_iva12=Math.round(orig_iva12*100)/100 ;
							

				imp_iva0 += iva0 - res_iva0;
				imp_iva12 += iva12 - res_iva12;
                        	importe_iva += parseFloat(document.getElementById("iva1").value);	
			}
			else
			{			
                        	imp_iva12 +=parseFloat(document.getElementById("importe1").value) - parseFloat(document.getElementById("descuento1").value);
                        	importe_iva += parseFloat(document.getElementById("iva1").value);
			}
                    }


		    if(document.getElementById("ivaporc2").value=='0')
                    {
                        imp_iva0 +=parseFloat(document.getElementById("importe2").value) - parseFloat(document.getElementById("descuento2").value);

                    }
                    else
                    {
			if(document.getElementById("transformacion2").value=='2')
			{				
				var iva0=(parseFloat(document.getElementById("importe2").value) - parseFloat(document.getElementById("importe_con_iva2").value));
				var iva12=parseFloat(document.getElementById("importe_con_iva2").value);

				var desc_iva0 = parseFloat(iva0 * parseFloat(document.getElementById("descuentoporc2").value / 100));
                                var orig_iva0=parseFloat(desc_iva0);
                                var res_iva0=Math.round(orig_iva0*100)/100 ;

				var desc_iva12 = parseFloat(iva12 * parseFloat(document.getElementById("descuentoporc2").value / 100));
                                var orig_iva12=parseFloat(desc_iva12);
                                var res_iva12=Math.round(orig_iva12*100)/100 ;
							

				imp_iva0 += iva0 - res_iva0;
				imp_iva12 += iva12 - res_iva12;
                        	importe_iva += parseFloat(document.getElementById("iva2").value);	
			}
			else
			{
			

                        	imp_iva12 +=parseFloat(document.getElementById("importe2").value) - parseFloat(document.getElementById("descuento2").value);
                        	importe_iva += parseFloat(document.getElementById("iva2").value);
			}
			
                    }

		    if(document.getElementById("ivaporc3").value=='0')
                    {
                        imp_iva0 +=parseFloat(document.getElementById("importe3").value) - parseFloat(document.getElementById("descuento3").value);

                    }
                    else
                    {
			if(document.getElementById("transformacion3").value=='2')
			{				
				var iva0=(parseFloat(document.getElementById("importe3").value) - parseFloat(document.getElementById("importe_con_iva3").value));
				var iva12=parseFloat(document.getElementById("importe_con_iva3").value);

				var desc_iva0 = parseFloat(iva0 * parseFloat(document.getElementById("descuentoporc3").value / 100));
                                var orig_iva0=parseFloat(desc_iva0);
                                var res_iva0=Math.round(orig_iva0*100)/100 ;

				var desc_iva12 = parseFloat(iva12 * parseFloat(document.getElementById("descuentoporc3").value / 100));
                                var orig_iva12=parseFloat(desc_iva12);
                                var res_iva12=Math.round(orig_iva12*100)/100 ;
							

				imp_iva0 += iva0 - res_iva0;
				imp_iva12 += iva12 - res_iva12;
                        	importe_iva += parseFloat(document.getElementById("iva3").value);	
			}
			else
			{

                        	imp_iva12 +=parseFloat(document.getElementById("importe3").value) - parseFloat(document.getElementById("descuento3").value);
                        	importe_iva += parseFloat(document.getElementById("iva3").value);
			}
                    }


		    if(document.getElementById("ivaporc4").value=='0')
                    {
                        imp_iva0 +=parseFloat(document.getElementById("importe4").value) - parseFloat(document.getElementById("descuento4").value);

                    }
                    else
                    {
			if(document.getElementById("transformacion4").value=='2')
			{				
				var iva0=(parseFloat(document.getElementById("importe4").value) - parseFloat(document.getElementById("importe_con_iva4").value));
				var iva12=parseFloat(document.getElementById("importe_con_iva4").value);

				var desc_iva0 = parseFloat(iva0 * parseFloat(document.getElementById("descuentoporc4").value / 100));
                                var orig_iva0=parseFloat(desc_iva0);
                                var res_iva0=Math.round(orig_iva0*100)/100 ;

				var desc_iva12 = parseFloat(iva12 * parseFloat(document.getElementById("descuentoporc4").value / 100));
                                var orig_iva12=parseFloat(desc_iva12);
                                var res_iva12=Math.round(orig_iva12*100)/100 ;
							

				imp_iva0 += iva0 - res_iva0;
				imp_iva12 += iva12 - res_iva12;
                        	importe_iva += parseFloat(document.getElementById("iva4").value);	
			}
			else
			{
                        	imp_iva12 +=parseFloat(document.getElementById("importe4").value) - parseFloat(document.getElementById("descuento4").value);
				importe_iva += parseFloat(document.getElementById("iva4").value);
			}
                    }



		    if(document.getElementById("ivaporc5").value=='0')
                    {
                        imp_iva0 +=parseFloat(document.getElementById("importe5").value) - parseFloat(document.getElementById("descuento5").value);

                    }
                    else
                    {
			if(document.getElementById("transformacion5").value=='2')
			{				
				var iva0=(parseFloat(document.getElementById("importe5").value) - parseFloat(document.getElementById("importe_con_iva5").value));
				var iva12=parseFloat(document.getElementById("importe_con_iva5").value);

				var desc_iva0 = parseFloat(iva0 * parseFloat(document.getElementById("descuentoporc5").value / 100));
                                var orig_iva0=parseFloat(desc_iva0);
                                var res_iva0=Math.round(orig_iva0*100)/100 ;

				var desc_iva12 = parseFloat(iva12 * parseFloat(document.getElementById("descuentoporc5").value / 100));
                                var orig_iva12=parseFloat(desc_iva12);
                                var res_iva12=Math.round(orig_iva12*100)/100 ;
							

				imp_iva0 += iva0 - res_iva0;
				imp_iva12 += iva12 - res_iva12;
                        	importe_iva += parseFloat(document.getElementById("iva5").value);	
			}
			else
			{			

                        	imp_iva12 +=parseFloat(document.getElementById("importe5").value) - parseFloat(document.getElementById("descuento5").value);
                        	importe_iva += parseFloat(document.getElementById("iva5").value);
			}
                    }


		    if(document.getElementById("ivaporc6").value=='0')
                    {
                        imp_iva0 +=parseFloat(document.getElementById("importe6").value) - parseFloat(document.getElementById("descuento6").value);

                    }
                    else
                    {
			if(document.getElementById("transformacion6").value=='2')
			{				
				var iva0=(parseFloat(document.getElementById("importe6").value) - parseFloat(document.getElementById("importe_con_iva6").value));
				var iva12=parseFloat(document.getElementById("importe_con_iva6").value);

				var desc_iva0 = parseFloat(iva0 * parseFloat(document.getElementById("descuentoporc6").value / 100));
                                var orig_iva0=parseFloat(desc_iva0);
                                var res_iva0=Math.round(orig_iva0*100)/100 ;

				var desc_iva12 = parseFloat(iva12 * parseFloat(document.getElementById("descuentoporc6").value / 100));
                                var orig_iva12=parseFloat(desc_iva12);
                                var res_iva12=Math.round(orig_iva12*100)/100 ;
							

				imp_iva0 += iva0 - res_iva0;
				imp_iva12 += iva12 - res_iva12;
                        	importe_iva += parseFloat(document.getElementById("iva6").value);	
			}
			else
			{

                        	imp_iva12 +=parseFloat(document.getElementById("importe6").value) - parseFloat(document.getElementById("descuento6").value);
                        	importe_iva += parseFloat(document.getElementById("iva6").value);
			}
                    }

		    if(document.getElementById("ivaporc7").value=='0')
                    {
                        imp_iva0 +=parseFloat(document.getElementById("importe7").value) - parseFloat(document.getElementById("descuento7").value);

                    }
                    else
                    {
			if(document.getElementById("transformacion7").value=='2')
			{				
				var iva0=(parseFloat(document.getElementById("importe7").value) - parseFloat(document.getElementById("importe_con_iva7").value));
				var iva12=parseFloat(document.getElementById("importe_con_iva7").value);

				var desc_iva0 = parseFloat(iva0 * parseFloat(document.getElementById("descuentoporc7").value / 100));
                                var orig_iva0=parseFloat(desc_iva0);
                                var res_iva0=Math.round(orig_iva0*100)/100 ;

				var desc_iva12 = parseFloat(iva12 * parseFloat(document.getElementById("descuentoporc7").value / 100));
                                var orig_iva12=parseFloat(desc_iva12);
                                var res_iva12=Math.round(orig_iva12*100)/100 ;
							

				imp_iva0 += iva0 - res_iva0;
				imp_iva12 += iva12 - res_iva12;
                        	importe_iva += parseFloat(document.getElementById("iva7").value);	
			}
			else
			{		

          	              	imp_iva12 +=parseFloat(document.getElementById("importe7").value) - parseFloat(document.getElementById("descuento7").value);
          	              	importe_iva += parseFloat(document.getElementById("iva7").value);
			}
                    }


		    if(document.getElementById("ivaporc8").value=='0')
                    {
                        imp_iva0 +=parseFloat(document.getElementById("importe8").value) - parseFloat(document.getElementById("descuento8").value);

                    }
                    else
                    {
			if(document.getElementById("transformacion8").value=='2')
			{				
				var iva0=(parseFloat(document.getElementById("importe8").value) - parseFloat(document.getElementById("importe_con_iva8").value));
				var iva12=parseFloat(document.getElementById("importe_con_iva8").value);

				var desc_iva0 = parseFloat(iva0 * parseFloat(document.getElementById("descuentoporc8").value / 100));
                                var orig_iva0=parseFloat(desc_iva0);
                                var res_iva0=Math.round(orig_iva0*100)/100 ;

				var desc_iva12 = parseFloat(iva12 * parseFloat(document.getElementById("descuentoporc8").value / 100));
                                var orig_iva12=parseFloat(desc_iva12);
                                var res_iva12=Math.round(orig_iva12*100)/100 ;
							

				imp_iva0 += iva0 - res_iva0;
				imp_iva12 += iva12 - res_iva12;
                        	importe_iva += parseFloat(document.getElementById("iva8").value);	
			}
			else
			{

             	           	imp_iva12 +=parseFloat(document.getElementById("importe8").value) - parseFloat(document.getElementById("descuento8").value);
				importe_iva += parseFloat(document.getElementById("iva8").value);
			}
             	    }


		    if(document.getElementById("ivaporc9").value=='0')
                    {
                        imp_iva0 +=parseFloat(document.getElementById("importe9").value) - parseFloat(document.getElementById("descuento9").value);

                    }
                    else
                    {
			if(document.getElementById("transformacion9").value=='2')
			{				
				var iva0=(parseFloat(document.getElementById("importe9").value) - parseFloat(document.getElementById("importe_con_iva9").value));
				var iva12=parseFloat(document.getElementById("importe_con_iva9").value);

				var desc_iva0 = parseFloat(iva0 * parseFloat(document.getElementById("descuentoporc9").value / 100));
                                var orig_iva0=parseFloat(desc_iva0);
                                var res_iva0=Math.round(orig_iva0*100)/100 ;

				var desc_iva12 = parseFloat(iva12 * parseFloat(document.getElementById("descuentoporc9").value / 100));
                                var orig_iva12=parseFloat(desc_iva12);
                                var res_iva12=Math.round(orig_iva12*100)/100 ;
							

				imp_iva0 += iva0 - res_iva0;
				imp_iva12 += iva12 - res_iva12;
                        	importe_iva += parseFloat(document.getElementById("iva9").value);	
			}
			else
			{

                      	  	imp_iva12 +=parseFloat(document.getElementById("importe9").value) - parseFloat(document.getElementById("descuento9").value);
                      	  	importe_iva += parseFloat(document.getElementById("iva9").value);
			}
                    }

		    if(document.getElementById("ivaporc10").value=='0')
                    {
                        imp_iva0 +=parseFloat(document.getElementById("importe10").value) - parseFloat(document.getElementById("descuento10").value);

                    }
                    else
                    {
			if(document.getElementById("transformacion10").value=='2')
			{				
				var iva0=(parseFloat(document.getElementById("importe10").value) - parseFloat(document.getElementById("importe_con_iva10").value));
				var iva12=parseFloat(document.getElementById("importe_con_iva10").value);

				var desc_iva0 = parseFloat(iva0 * parseFloat(document.getElementById("descuentoporc10").value / 100));
                                var orig_iva0=parseFloat(desc_iva0);
                                var res_iva0=Math.round(orig_iva0*100)/100 ;

				var desc_iva12 = parseFloat(iva12 * parseFloat(document.getElementById("descuentoporc10").value / 100));
                                var orig_iva12=parseFloat(desc_iva12);
                                var res_iva12=Math.round(orig_iva12*100)/100 ;
							

				imp_iva0 += iva0 - res_iva0;
				imp_iva12 += iva12 - res_iva12;
                        	importe_iva += parseFloat(document.getElementById("iva10").value);	
			}
			else
			{			
                        	imp_iva12 +=parseFloat(document.getElementById("importe10").value) - parseFloat(document.getElementById("descuento10").value);
                        	importe_iva += parseFloat(document.getElementById("iva10").value);
			}
                    }


		    if(document.getElementById("ivaporc11").value=='0')
                    {
                        imp_iva0 +=parseFloat(document.getElementById("importe11").value) - parseFloat(document.getElementById("descuento11").value);

                    }
                    else
                    {
			if(document.getElementById("transformacion11").value=='2')
			{				
				var iva0=(parseFloat(document.getElementById("importe11").value) - parseFloat(document.getElementById("importe_con_iva11").value));
				var iva12=parseFloat(document.getElementById("importe_con_iva11").value);

				var desc_iva0 = parseFloat(iva0 * parseFloat(document.getElementById("descuentoporc11").value / 100));
                                var orig_iva0=parseFloat(desc_iva0);
                                var res_iva0=Math.round(orig_iva0*100)/100 ;

				var desc_iva12 = parseFloat(iva12 * parseFloat(document.getElementById("descuentoporc11").value / 100));
                                var orig_iva12=parseFloat(desc_iva12);
                                var res_iva12=Math.round(orig_iva12*100)/100 ;
							

				imp_iva0 += iva0 - res_iva0;
				imp_iva12 += iva12 - res_iva12;
                        	importe_iva += parseFloat(document.getElementById("iva11").value);	
			}
			else
			{
                        	imp_iva12 +=parseFloat(document.getElementById("importe11").value) - parseFloat(document.getElementById("descuento11").value);
				importe_iva += parseFloat(document.getElementById("iva11").value);
			}
                    }





                    document.getElementById("baseimponible").value=subtotal;
                    var original1=parseFloat(document.getElementById("baseimponible").value);
                    var result1=Math.round(original1*100)/100 ;
                    document.getElementById("baseimponible").value=result1.toFixed(2);

                    document.getElementById("descuentototal").value=descuento;
                    var original2=parseFloat(document.getElementById("descuentototal").value);
                    var result2=Math.round(original2*100)/100 ;
                    document.getElementById("descuentototal").value=result2.toFixed(2);

                        document.getElementById("iva0").value=imp_iva0;
                        var original3=parseFloat(document.getElementById("iva0").value);
                        var result3=Math.round(original3*100)/100 ;
                        document.getElementById("iva0").value=result3.toFixed(2);


                        document.getElementById("iva12").value=imp_iva12;
                        var original4=parseFloat(document.getElementById("iva12").value);
                        var result4=Math.round(original4*100)/100 ;
                        document.getElementById("iva12").value=result4.toFixed(2);


                    document.getElementById("importeiva").value=importe_iva;
                    var original5=parseFloat(document.getElementById("importeiva").value);
                    var result5=Math.round(original5*100)/100 ;
                    document.getElementById("importeiva").value=result5.toFixed(2);

                    var original6=parseFloat(document.getElementById("flete").value);
                    var result6=Math.round(original6*100)/100 ;


                    document.getElementById("preciototal").value= result1 - result2 + result5 + result6;
                    var original7=parseFloat(document.getElementById("preciototal").value);
                    var result7=Math.round(original7*100)/100 ;
                    document.getElementById("preciototal").value=result7.toFixed(2);




                }

		function limpiar_articulo(op)
		{
			switch(op)
			{
				case 1:
					document.getElementById("codarticulo1").value="";
					document.getElementById("descripcion1").value="";
					document.getElementById("cantidad1").value=1;
					document.getElementById("precio1").value="";
					document.getElementById("importe1").value=0;
					document.getElementById("descuentoporc1").value=0;
					document.getElementById("descuento1").value=0;
					document.getElementById("ivaporc1").value=0;
					document.getElementById("iva1").value=0;
					document.getElementById("subt1").value=0;
					document.getElementById("idarticulo1").value="";
					document.getElementById("costo1").value="";
					
															

					break;
				case 2:
					document.getElementById("codarticulo2").value="";
					document.getElementById("descripcion2").value="";
					document.getElementById("cantidad2").value=1;
					document.getElementById("precio2").value="";
					document.getElementById("importe2").value=0;
					document.getElementById("descuentoporc2").value=0;
					document.getElementById("descuento2").value=0;
					document.getElementById("ivaporc2").value=0;
					document.getElementById("iva2").value=0;
					document.getElementById("subt2").value=0;
					document.getElementById("idarticulo2").value="";
					document.getElementById("costo2").value="";

					break;
				case 3:
					document.getElementById("codarticulo3").value="";
					document.getElementById("descripcion3").value="";
					document.getElementById("cantidad3").value=1;
					document.getElementById("precio3").value="";
					document.getElementById("importe3").value=0;
					document.getElementById("descuentoporc3").value=0;
					document.getElementById("descuento3").value=0;
					document.getElementById("ivaporc3").value=0;
					document.getElementById("iva3").value=0;
					document.getElementById("subt3").value=0;
					document.getElementById("idarticulo3").value="";
					document.getElementById("costo3").value="";

					break;
				case 4:
					document.getElementById("codarticulo4").value="";
					document.getElementById("descripcion4").value="";
					document.getElementById("cantidad4").value=1;
					document.getElementById("precio4").value="";
					document.getElementById("importe4").value=0;
					document.getElementById("descuentoporc4").value=0;
					document.getElementById("descuento4").value=0;
					document.getElementById("ivaporc4").value=0;
					document.getElementById("iva4").value=0;
					document.getElementById("subt4").value=0;
					document.getElementById("idarticulo4").value="";
					document.getElementById("costo4").value="";

					break;
				case 5:
					document.getElementById("codarticulo5").value="";
					document.getElementById("descripcion5").value="";
					document.getElementById("cantidad5").value=1;
					document.getElementById("precio5").value="";
					document.getElementById("importe5").value=0;
					document.getElementById("descuentoporc5").value=0;
					document.getElementById("descuento5").value=0;
					document.getElementById("ivaporc5").value=0;
					document.getElementById("iva5").value=0;
					document.getElementById("subt5").value=0;
					document.getElementById("idarticulo5").value="";
					document.getElementById("costo5").value="";

					break;
				case 6:
					document.getElementById("codarticulo6").value="";
					document.getElementById("descripcion6").value="";
					document.getElementById("cantidad6").value=1;
					document.getElementById("precio6").value="";
					document.getElementById("importe6").value=0;
					document.getElementById("descuentoporc6").value=0;
					document.getElementById("descuento6").value=0;
					document.getElementById("ivaporc6").value=0;
					document.getElementById("iva6").value=0;
					document.getElementById("subt6").value=0;
					document.getElementById("idarticulo6").value="";
					document.getElementById("costo6").value="";

					break;
				case 7:
					document.getElementById("codarticulo7").value="";
					document.getElementById("descripcion7").value="";
					document.getElementById("cantidad7").value=1;
					document.getElementById("precio7").value="";
					document.getElementById("importe7").value=0;
					document.getElementById("descuentoporc7").value=0;
					document.getElementById("descuento7").value=0;
					document.getElementById("ivaporc7").value=0;
					document.getElementById("iva7").value=0;
					document.getElementById("subt7").value=0;
					document.getElementById("idarticulo7").value="";
					document.getElementById("costo7").value="";

					break;
				case 8:
					document.getElementById("codarticulo8").value="";
					document.getElementById("descripcion8").value="";
					document.getElementById("cantidad8").value=1;
					document.getElementById("precio8").value="";
					document.getElementById("importe8").value=0;
					document.getElementById("descuentoporc8").value=0;
					document.getElementById("descuento8").value=0;
					document.getElementById("ivaporc8").value=0;
					document.getElementById("iva8").value=0;
					document.getElementById("subt8").value=0;
					document.getElementById("idarticulo8").value="";
					document.getElementById("costo8").value="";

					break;
				case 9:
					document.getElementById("codarticulo9").value="";
					document.getElementById("descripcion9").value="";
					document.getElementById("cantidad9").value=1;
					document.getElementById("precio9").value="";
					document.getElementById("importe9").value=0;
					document.getElementById("descuentoporc9").value=0;
					document.getElementById("descuento9").value=0;
					document.getElementById("ivaporc9").value=0;
					document.getElementById("iva9").value=0;
					document.getElementById("subt9").value=0;
					document.getElementById("idarticulo9").value="";
					document.getElementById("costo9").value="";

					break;
				case 10:
					document.getElementById("codarticulo10").value="";
					document.getElementById("descripcion10").value="";
					document.getElementById("cantidad10").value=1;
					document.getElementById("precio10").value="";
					document.getElementById("importe10").value=0;
					document.getElementById("descuentoporc10").value=0;
					document.getElementById("descuento10").value=0;
					document.getElementById("ivaporc10").value=0;
					document.getElementById("iva10").value=0;
					document.getElementById("subt10").value=0;
					document.getElementById("idarticulo10").value="";
					document.getElementById("costo10").value="";

					break;
				case 11:
					document.getElementById("codarticulo11").value="";
					document.getElementById("descripcion11").value="";
					document.getElementById("cantidad11").value=1;
					document.getElementById("precio11").value="";
					document.getElementById("importe11").value=0;
					document.getElementById("descuentoporc11").value=0;
					document.getElementById("descuento11").value=0;
					document.getElementById("ivaporc11").value=0;
					document.getElementById("iva11").value=0;
					document.getElementById("subt11").value=0;
					document.getElementById("idarticulo11").value="";
					document.getElementById("costo11").value="";

					break;
			}
			actualizar_totales();
		}

                function activar_plazo(indice)
                {
                   with (document.formulario)
                   {
                       value=cbocredito.options[indice].value ;
                     switch (value)
                      {
                          case "0":
                              credit=1;
                            cboplazo.selectedIndex=0;
                            cboplazo.readonly = true;
                            break;
                            case "2":
                             credit=0;
                            cboplazo.selectedIndex=0;
                            cboplazo.readonly = true;
                            break;
                          default:
                              credit=1;
                            cboplazo.readonly = false;
                            cboplazo.selectedIndex=1;
                            break;
                      }
                   }
                }

                function sumar_flete()
                {
                    var original=parseFloat(document.getElementById("flete").value);
                    if (isNaN(original)==true)
                    {

			alert("Atencion, el valor del Flete debe ser numerico");
                        document.getElementById("flete").value=0;
                        actualizar_totales();
                    } else
                    {
                             var result=Math.round(original*100)/100 ;
                             document.getElementById("flete").value=result.toFixed(2);

                             actualizar_totales();
                    }


                }

                function prorratear()
                {
                    var original=parseFloat(document.getElementById("descuentomanual").value);
                    if (isNaN(original)==true)
                    {

			alert("Atencion, el valor del Descuento debe ser numerico");
                        document.getElementById("descuentomanual").value=0;
                        actualizar_totales();
                    } else
                    {
                             var result=Math.round(original*100)/100 ;
                             document.getElementById("descuentomanual").value=result.toFixed(2);

                             actualizar_totales();
                    }
                }

