<?php 
include_once 'class/producto.php';
include_once '../conexion/conexion.php';
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

//porcentaje iva parametrizable*****************************************
$sel_iva = "select porcentaje FROM iva where activo=1 AND borrado=0";
$rs_iva = mysql_query($sel_iva, $conn);
$ivaporcetaje = mysql_result($rs_iva, 0, "porcentaje");
//**********************************************************************

error_reporting(0);


$accion = $_REQUEST["accion"];
if (!isset($accion)) {
    $accion = $_GET["accion"];
    if (!isset($accion)) {
        $accion = $_REQUEST["accion"];
    }
}

if ($accion != "baja") {

    $origen = $_POST["origen"];
    $op = $_POST["op"];


    $codigo = strtoupper($_POST["Acodigo"]);
    $nombre = strtoupper($_POST["Anombre"]);
    $stock = $_POST["Rstock"];
    $costo = $_POST["qcosto"];
    $pvp = $_POST["Qpvp"];
    $iva = $_POST["iva"];
    $especial = $_POST["especial"];

    $composicion = strtoupper($_POST["acomposicion"]);
    $aplicacion = strtoupper($_POST["aplicacion"]);
    $proveedor = $_POST["Aproveedor"];
    $grupo = $_POST["Agrupo"];
    $subgrupo = $_POST["Asubgrupo"];

    $stock_consignacion = $_POST["astock_consignacion"];

    $utilidad = $_POST["qutilidad"];
    $bodega = $_POST["Acbobodega"];

    $esGasto = $_POST["Agasto"];
    if ($esGasto == "no") {
        $gasto = 0;
    } else {
        $gasto = 1;
    }

} else {
    $origen = "ninguno";
}

if ($accion == "alta") {
    $producto = new Producto();
    $idproducto = $producto->save_producto($conn, $codigo, $nombre, $stock, $costo, $pvp, $iva, $composicion, $aplicacion, $proveedor, $grupo, $subgrupo, $stock_consignacion, $gasto, $utilidad, $bodega, $especial);


    if ($idproducto) {
        $mensaje = "El producto ha sido dado de alta correctamente";
        $validacion = 0;
    } else {
        $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   El CODIGO ya existe, ERROR al ingresar el PRODUCTO</span>";
        $validacion = 1;
    }
    $cabecera1 = "Inicio >> Productos &gt;&gt; Nuevo Producto ";
    $cabecera2 = "INSERTAR PRODUCTO ";
}

if ($accion == "modificar") {
    $idproducto = $_POST["idproducto"];
    $producto = new Producto();
    $result = $producto->update_producto($conn, $idproducto, $codigo, $nombre, $stock, $costo, $pvp, $iva, $composicion, $aplicacion, $proveedor, $grupo, $subgrupo, $stock_consignacion, $gasto, $utilidad, $especial);

    if ($result) {
        $mensaje = "Los datos del producto han sido modificados correctamente";
        $validacion = 0;
    } else {
        $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   El CODIGO ya existe, ERROR al ingresar el PRODUCTO</span>";
        $validacion = 1;
    }
    $cabecera1 = "Inicio >> Productos &gt;&gt; Modificar Producto ";
    $cabecera2 = "MODIFICAR PRODUCTO ";
}

if ($accion == "baja") {
    $idproducto = $_REQUEST["idproducto"];
    $producto = new Producto();
    $result = $producto->delete_producto($conn, $idproducto);

    if ($result) {
        $mensaje = "El producto ha sido dado de baja correctamente";
        $validacion = 0;
    } else {
        $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'> ERROR al dar de baja el producto</span>";
        $validacion = 1;
    }
    $cabecera1 = "Inicio >> Producto &gt;&gt; Eliminar Producto ";
    $cabecera2 = "ELIMINAR PRODUCTO ";

    $result = $producto->get_producto_borrado_id($conn, $idproducto);
    $codigo = $result['codigo'];
    $nombre = $result['nombre'];
    $stock = $result['stock'];
    $costo = $result['costo'];
    $pvp = $result['pvp'];
    $iva = $result['iva'];
    $utilidad = $result['utilidad'];
    $especial = $result['moto'];

    $composicion = $result['composicion'];
    $aplicacion = $result['aplicacion'];
    $proveedor = $result['proveedor'];
    $grupo = $result['grupo'];
    $subgrupo = $result['subgrupo'];

    $stock_consignacion = $result['stock_consignacion'];
}
?>


<html>
<head>
    <title>Principal</title>
    <link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
    <script language="javascript">

        function aceptar(validacion) {
            if (validacion == 0)
                location.href = "index.php";
            else
                history.back();
        }

        var cursor;
        if (document.all) {
            // Está utilizando EXPLORER
            cursor = 'hand';
        } else {
            // Está utilizando MOZILLA/NETSCAPE
            cursor = 'pointer';
        }


        function ingreso_factura_venta(validacion, codarticulo, nombre, precio, idarticulo, costo, stock, stock_consignacion, iva, op) {

            var password = null;
            var clave = "validaragro2012";


            if (validacion == 0) {
                if (stock > 0) {
                    switch (op) {
                        case 1:
                            parent.opener.document.formulario.codarticulo1.value = codarticulo;
                            parent.opener.document.formulario.descripcion1.value = nombre;
                            parent.opener.document.formulario.precio1.value = precio;
                            parent.opener.document.formulario.idarticulo1.value = idarticulo;
                            parent.opener.document.formulario.costo1.value = costo;
                            parent.opener.document.formulario.stock1.value = stock;
                            if (iva == 1) {
                                parent.opener.document.formulario.ivaporc1.value =<?php  echo $ivaporcetaje; ?>;
                                parent.opener.document.formulario.grabaiva1.style.display = 'inherit';

                            }
                            else {
                                parent.opener.document.formulario.ivaporc1.value = 0;
                                parent.opener.document.formulario.grabaiva1.style.display = 'none';
                            }
                            break;

                        case 2:
                            parent.opener.document.formulario.codarticulo2.value = codarticulo;
                            parent.opener.document.formulario.descripcion2.value = nombre;
                            parent.opener.document.formulario.precio2.value = precio;
                            parent.opener.document.formulario.idarticulo2.value = idarticulo;
                            parent.opener.document.formulario.costo2.value = costo;
                            parent.opener.document.formulario.stock2.value = stock;
                            if (iva == 1) {
                                parent.opener.document.formulario.ivaporc2.value =<?php  echo $ivaporcetaje; ?>;
                                parent.opener.document.formulario.grabaiva2.style.display = 'inherit';
                            }
                            else {
                                parent.opener.document.formulario.ivaporc2.value = 0;
                                parent.opener.document.formulario.grabaiva2.style.display = 'none';
                            }
                            break;

                        case 3:
                            parent.opener.document.formulario.codarticulo3.value = codarticulo;
                            parent.opener.document.formulario.descripcion3.value = nombre;
                            parent.opener.document.formulario.precio3.value = precio;
                            parent.opener.document.formulario.idarticulo3.value = idarticulo;
                            parent.opener.document.formulario.costo3.value = costo;
                            parent.opener.document.formulario.stock3.value = stock;
                            if (iva == 1) {
                                parent.opener.document.formulario.ivaporc3.value =<?php  echo $ivaporcetaje; ?>;
                                parent.opener.document.formulario.grabaiva3.style.display = 'inherit';
                            }
                            else {
                                parent.opener.document.formulario.ivaporc3.value = 0;
                                parent.opener.document.formulario.grabaiva3.style.display = 'none';
                            }
                            break;

                        case 4:
                            parent.opener.document.formulario.codarticulo4.value = codarticulo;
                            parent.opener.document.formulario.descripcion4.value = nombre;
                            parent.opener.document.formulario.precio4.value = precio;
                            parent.opener.document.formulario.idarticulo4.value = idarticulo;
                            parent.opener.document.formulario.costo4.value = costo;
                            parent.opener.document.formulario.stock4.value = stock;
                            if (iva == 1) {
                                parent.opener.document.formulario.ivaporc4.value =<?php  echo $ivaporcetaje; ?>;
                                parent.opener.document.formulario.grabaiva4.style.display = 'inherit';
                            }
                            else {
                                parent.opener.document.formulario.ivaporc4.value = 0;
                                parent.opener.document.formulario.grabaiva4.style.display = 'none';
                            }
                            break;

                        case 5:
                            parent.opener.document.formulario.codarticulo5.value = codarticulo;
                            parent.opener.document.formulario.descripcion5.value = nombre;
                            parent.opener.document.formulario.precio5.value = precio;
                            parent.opener.document.formulario.idarticulo5.value = idarticulo;
                            parent.opener.document.formulario.costo5.value = costo;
                            parent.opener.document.formulario.stock5.value = stock;
                            if (iva == 1) {
                                parent.opener.document.formulario.ivaporc5.value =<?php  echo $ivaporcetaje; ?>;
                                parent.opener.document.formulario.grabaiva5.style.display = 'inherit';
                            }
                            else {
                                parent.opener.document.formulario.ivaporc5.value = 0;
                                parent.opener.document.formulario.grabaiva5.style.display = 'none';
                            }
                            break;

                        case 6:
                            parent.opener.document.formulario.codarticulo6.value = codarticulo;
                            parent.opener.document.formulario.descripcion6.value = nombre;
                            parent.opener.document.formulario.precio6.value = precio;
                            parent.opener.document.formulario.idarticulo6.value = idarticulo;
                            parent.opener.document.formulario.costo6.value = costo;
                            parent.opener.document.formulario.stock6.value = stock;
                            if (iva == 1) {
                                parent.opener.document.formulario.ivaporc6.value =<?php  echo $ivaporcetaje; ?>;
                                parent.opener.document.formulario.grabaiva6.style.display = 'inherit';
                            }
                            else {
                                parent.opener.document.formulario.ivaporc6.value = 0;
                                parent.opener.document.formulario.grabaiva6.style.display = 'none';
                            }
                            break;

                        case 7:
                            parent.opener.document.formulario.codarticulo7.value = codarticulo;
                            parent.opener.document.formulario.descripcion7.value = nombre;
                            parent.opener.document.formulario.precio7.value = precio;
                            parent.opener.document.formulario.idarticulo7.value = idarticulo;
                            parent.opener.document.formulario.costo7.value = costo;
                            parent.opener.document.formulario.stock7.value = stock;
                            if (iva == 1) {
                                parent.opener.document.formulario.ivaporc7.value =<?php  echo $ivaporcetaje; ?>;
                                parent.opener.document.formulario.grabaiva7.style.display = 'inherit';
                            }
                            else {
                                parent.opener.document.formulario.ivaporc7.value = 0;
                                parent.opener.document.formulario.grabaiva7.style.display = 'none';
                            }
                            break;

                        case 8:
                            parent.opener.document.formulario.codarticulo8.value = codarticulo;
                            parent.opener.document.formulario.descripcion8.value = nombre;
                            parent.opener.document.formulario.precio8.value = precio;
                            parent.opener.document.formulario.idarticulo8.value = idarticulo;
                            parent.opener.document.formulario.costo8.value = costo;
                            parent.opener.document.formulario.stock8.value = stock;
                            if (iva == 1) {
                                parent.opener.document.formulario.ivaporc8.value =<?php  echo $ivaporcetaje; ?>;
                                parent.opener.document.formulario.grabaiva8.style.display = 'inherit';
                            }
                            else {
                                parent.opener.document.formulario.ivaporc8.value = 0;
                                parent.opener.document.formulario.grabaiva8.style.display = 'none';
                            }
                            break;

                        case 9:
                            parent.opener.document.formulario.codarticulo9.value = codarticulo;
                            parent.opener.document.formulario.descripcion9.value = nombre;
                            parent.opener.document.formulario.precio9.value = precio;
                            parent.opener.document.formulario.idarticulo9.value = idarticulo;
                            parent.opener.document.formulario.costo9.value = costo;
                            parent.opener.document.formulario.stock9.value = stock;
                            if (iva == 1) {
                                parent.opener.document.formulario.ivaporc9.value =<?php  echo $ivaporcetaje; ?>;
                                parent.opener.document.formulario.grabaiva9.style.display = 'inherit';
                            }
                            else {
                                parent.opener.document.formulario.ivaporc9.value = 0;
                                parent.opener.document.formulario.grabaiva9.style.display = 'none';
                            }
                            break;

                        case 10:
                            parent.opener.document.formulario.codarticulo10.value = codarticulo;
                            parent.opener.document.formulario.descripcion10.value = nombre;
                            parent.opener.document.formulario.precio10.value = precio;
                            parent.opener.document.formulario.idarticulo10.value = idarticulo;
                            parent.opener.document.formulario.costo10.value = costo;
                            parent.opener.document.formulario.stock10.value = stock;
                            if (iva == 1) {
                                parent.opener.document.formulario.ivaporc10.value =<?php  echo $ivaporcetaje; ?>;
                                parent.opener.document.formulario.grabaiva10.style.display = 'inherit';
                            }
                            else {
                                parent.opener.document.formulario.ivaporc10.value = 0;
                                parent.opener.document.formulario.grabaiva10.style.display = 'none';
                            }
                            break;
                        case 11:
                            parent.opener.document.formulario.codarticulo11.value = codarticulo;
                            parent.opener.document.formulario.descripcion11.value = nombre;
                            parent.opener.document.formulario.precio11.value = precio;
                            parent.opener.document.formulario.idarticulo11.value = idarticulo;
                            parent.opener.document.formulario.costo11.value = costo;
                            parent.opener.document.formulario.stock11.value = stock;
                            if (iva == 1) {
                                parent.opener.document.formulario.ivaporc11.value =<?php  echo $ivaporcetaje; ?>;
                                parent.opener.document.formulario.grabaiva11.style.display = 'inherit';
                            }
                            else {
                                parent.opener.document.formulario.ivaporc11.value = 0;
                                parent.opener.document.formulario.grabaiva11.style.display = 'none';
                            }
                            break;
                    }

                    parent.opener.actualizar_importe(op);
                    parent.window.close();
                }
                else {
                    if (stock_consignacion > 0) {
                        switch (op) {
                            case 1:
                                parent.opener.document.formulario.codarticulo1.value = codarticulo;
                                parent.opener.document.formulario.descripcion1.value = nombre;
                                parent.opener.document.formulario.precio1.value = precio;
                                parent.opener.document.formulario.idarticulo1.value = idarticulo;
                                parent.opener.document.formulario.costo1.value = costo;
                                parent.opener.document.formulario.stock1.value = stock_consignacion;
                                if (iva == 1) {
                                    parent.opener.document.formulario.ivaporc1.value =<?php  echo $ivaporcetaje; ?>;
                                    parent.opener.document.formulario.grabaiva1.style.display = 'inherit';

                                }
                                else {
                                    parent.opener.document.formulario.ivaporc1.value = 0;
                                    parent.opener.document.formulario.grabaiva1.style.display = 'none';
                                }
                                break;

                            case 2:
                                parent.opener.document.formulario.codarticulo2.value = codarticulo;
                                parent.opener.document.formulario.descripcion2.value = nombre;
                                parent.opener.document.formulario.precio2.value = precio;
                                parent.opener.document.formulario.idarticulo2.value = idarticulo;
                                parent.opener.document.formulario.costo2.value = costo;
                                parent.opener.document.formulario.stock2.value = stock_consignacion;
                                if (iva == 1) {
                                    parent.opener.document.formulario.ivaporc2.value =<?php  echo $ivaporcetaje; ?>;
                                    parent.opener.document.formulario.grabaiva2.style.display = 'inherit';
                                }
                                else {
                                    parent.opener.document.formulario.ivaporc2.value = 0;
                                    parent.opener.document.formulario.grabaiva2.style.display = 'none';
                                }
                                break;

                            case 3:
                                parent.opener.document.formulario.codarticulo3.value = codarticulo;
                                parent.opener.document.formulario.descripcion3.value = nombre;
                                parent.opener.document.formulario.precio3.value = precio;
                                parent.opener.document.formulario.idarticulo3.value = idarticulo;
                                parent.opener.document.formulario.costo3.value = costo;
                                parent.opener.document.formulario.stock3.value = stock_consignacion;
                                if (iva == 1) {
                                    parent.opener.document.formulario.ivaporc3.value =<?php  echo $ivaporcetaje; ?>;
                                    parent.opener.document.formulario.grabaiva3.style.display = 'inherit';
                                }
                                else {
                                    parent.opener.document.formulario.ivaporc3.value = 0;
                                    parent.opener.document.formulario.grabaiva3.style.display = 'none';
                                }
                                break;

                            case 4:
                                parent.opener.document.formulario.codarticulo4.value = codarticulo;
                                parent.opener.document.formulario.descripcion4.value = nombre;
                                parent.opener.document.formulario.precio4.value = precio;
                                parent.opener.document.formulario.idarticulo4.value = idarticulo;
                                parent.opener.document.formulario.costo4.value = costo;
                                parent.opener.document.formulario.stock4.value = stock_consignacion;
                                if (iva == 1) {
                                    parent.opener.document.formulario.ivaporc4.value =<?php  echo $ivaporcetaje; ?>;
                                    parent.opener.document.formulario.grabaiva4.style.display = 'inherit';
                                }
                                else {
                                    parent.opener.document.formulario.ivaporc4.value = 0;
                                    parent.opener.document.formulario.grabaiva4.style.display = 'none';
                                }
                                break;

                            case 5:
                                parent.opener.document.formulario.codarticulo5.value = codarticulo;
                                parent.opener.document.formulario.descripcion5.value = nombre;
                                parent.opener.document.formulario.precio5.value = precio;
                                parent.opener.document.formulario.idarticulo5.value = idarticulo;
                                parent.opener.document.formulario.costo5.value = costo;
                                parent.opener.document.formulario.stock5.value = stock_consignacion;
                                if (iva == 1) {
                                    parent.opener.document.formulario.ivaporc5.value =<?php  echo $ivaporcetaje; ?>;
                                    parent.opener.document.formulario.grabaiva5.style.display = 'inherit';
                                }
                                else {
                                    parent.opener.document.formulario.ivaporc5.value = 0;
                                    parent.opener.document.formulario.grabaiva5.style.display = 'none';
                                }
                                break;

                            case 6:
                                parent.opener.document.formulario.codarticulo6.value = codarticulo;
                                parent.opener.document.formulario.descripcion6.value = nombre;
                                parent.opener.document.formulario.precio6.value = precio;
                                parent.opener.document.formulario.idarticulo6.value = idarticulo;
                                parent.opener.document.formulario.costo6.value = costo;
                                parent.opener.document.formulario.stock6.value = stock_consignacion;
                                if (iva == 1) {
                                    parent.opener.document.formulario.ivaporc6.value =<?php  echo $ivaporcetaje; ?>;
                                    parent.opener.document.formulario.grabaiva6.style.display = 'inherit';
                                }
                                else {
                                    parent.opener.document.formulario.ivaporc6.value = 0;
                                    parent.opener.document.formulario.grabaiva6.style.display = 'none';
                                }
                                break;

                            case 7:
                                parent.opener.document.formulario.codarticulo7.value = codarticulo;
                                parent.opener.document.formulario.descripcion7.value = nombre;
                                parent.opener.document.formulario.precio7.value = precio;
                                parent.opener.document.formulario.idarticulo7.value = idarticulo;
                                parent.opener.document.formulario.costo7.value = costo;
                                parent.opener.document.formulario.stock7.value = stock_consignacion;
                                if (iva == 1) {
                                    parent.opener.document.formulario.ivaporc7.value =<?php  echo $ivaporcetaje; ?>;
                                    parent.opener.document.formulario.grabaiva7.style.display = 'inherit';
                                }
                                else {
                                    parent.opener.document.formulario.ivaporc7.value = 0;
                                    parent.opener.document.formulario.grabaiva7.style.display = 'none';
                                }
                                break;

                            case 8:
                                parent.opener.document.formulario.codarticulo8.value = codarticulo;
                                parent.opener.document.formulario.descripcion8.value = nombre;
                                parent.opener.document.formulario.precio8.value = precio;
                                parent.opener.document.formulario.idarticulo8.value = idarticulo;
                                parent.opener.document.formulario.costo8.value = costo;
                                parent.opener.document.formulario.stock8.value = stock_consignacion;
                                if (iva == 1) {
                                    parent.opener.document.formulario.ivaporc8.value =<?php  echo $ivaporcetaje; ?>;
                                    parent.opener.document.formulario.grabaiva8.style.display = 'inherit';
                                }
                                else {
                                    parent.opener.document.formulario.ivaporc8.value = 0;
                                    parent.opener.document.formulario.grabaiva8.style.display = 'none';
                                }
                                break;

                            case 9:
                                parent.opener.document.formulario.codarticulo9.value = codarticulo;
                                parent.opener.document.formulario.descripcion9.value = nombre;
                                parent.opener.document.formulario.precio9.value = precio;
                                parent.opener.document.formulario.idarticulo9.value = idarticulo;
                                parent.opener.document.formulario.costo9.value = costo;
                                parent.opener.document.formulario.stock9.value = stock_consignacion;
                                if (iva == 1) {
                                    parent.opener.document.formulario.ivaporc9.value =<?php  echo $ivaporcetaje; ?>;
                                    parent.opener.document.formulario.grabaiva9.style.display = 'inherit';
                                }
                                else {
                                    parent.opener.document.formulario.ivaporc9.value = 0;
                                    parent.opener.document.formulario.grabaiva9.style.display = 'none';
                                }
                                break;

                            case 10:
                                parent.opener.document.formulario.codarticulo10.value = codarticulo;
                                parent.opener.document.formulario.descripcion10.value = nombre;
                                parent.opener.document.formulario.precio10.value = precio;
                                parent.opener.document.formulario.idarticulo10.value = idarticulo;
                                parent.opener.document.formulario.costo10.value = costo;
                                parent.opener.document.formulario.stock10.value = stock_consignacion;
                                if (iva == 1) {
                                    parent.opener.document.formulario.ivaporc10.value =<?php  echo $ivaporcetaje; ?>;
                                    parent.opener.document.formulario.grabaiva10.style.display = 'inherit';
                                }
                                else {
                                    parent.opener.document.formulario.ivaporc10.value = 0;
                                    parent.opener.document.formulario.grabaiva10.style.display = 'none';
                                }
                                break;
                            case 11:
                                parent.opener.document.formulario.codarticulo11.value = codarticulo;
                                parent.opener.document.formulario.descripcion11.value = nombre;
                                parent.opener.document.formulario.precio11.value = precio;
                                parent.opener.document.formulario.idarticulo11.value = idarticulo;
                                parent.opener.document.formulario.costo11.value = costo;
                                parent.opener.document.formulario.stock11.value = stock_consignacion;
                                if (iva == 1) {
                                    parent.opener.document.formulario.ivaporc11.value =<?php  echo $ivaporcetaje; ?>;
                                    parent.opener.document.formulario.grabaiva11.style.display = 'inherit';
                                }
                                else {
                                    parent.opener.document.formulario.ivaporc11.value = 0;
                                    parent.opener.document.formulario.grabaiva11.style.display = 'none';
                                }
                                break;
                        }

                        parent.opener.actualizar_importe(op);
                        parent.window.close();
                    }


                    else {
                        password = prompt("Producto sin STOCK en bodega.\n\nPara permitira su seleccion\nIngrese el password ", '');
                        if (password == clave) {
                            switch (op) {
                                case 1:
                                    parent.opener.document.formulario.codarticulo1.value = codarticulo;
                                    parent.opener.document.formulario.descripcion1.value = nombre;
                                    parent.opener.document.formulario.precio1.value = precio;
                                    parent.opener.document.formulario.idarticulo1.value = idarticulo;
                                    parent.opener.document.formulario.costo1.value = costo;
                                    parent.opener.document.formulario.stock1.value = stock;
                                    if (iva == 1) {
                                        parent.opener.document.formulario.ivaporc1.value =<?php  echo $ivaporcetaje; ?>;
                                        parent.opener.document.formulario.grabaiva1.style.display = 'inherit';
                                    }
                                    else {
                                        parent.opener.document.formulario.ivaporc1.value = 0;
                                        parent.opener.document.formulario.grabaiva1.style.display = 'none';
                                    }

                                    parent.opener.document.formulario.cantidad1.value = 0;
                                    break;

                                case 2:
                                    parent.opener.document.formulario.codarticulo2.value = codarticulo;
                                    parent.opener.document.formulario.descripcion2.value = nombre;
                                    parent.opener.document.formulario.precio2.value = precio;
                                    parent.opener.document.formulario.idarticulo2.value = idarticulo;
                                    parent.opener.document.formulario.costo2.value = costo;
                                    parent.opener.document.formulario.stock2.value = stock;
                                    if (iva == 1) {
                                        parent.opener.document.formulario.ivaporc2.value =<?php  echo $ivaporcetaje; ?>;
                                        parent.opener.document.formulario.grabaiva2.style.display = 'inherit';
                                    }
                                    else {
                                        parent.opener.document.formulario.ivaporc2.value = 0;
                                        parent.opener.document.formulario.grabaiva2.style.display = 'none';
                                    }

                                    parent.opener.document.formulario.cantidad2.value = 0;
                                    break;

                                case 3:
                                    parent.opener.document.formulario.codarticulo3.value = codarticulo;
                                    parent.opener.document.formulario.descripcion3.value = nombre;
                                    parent.opener.document.formulario.precio3.value = precio;
                                    parent.opener.document.formulario.idarticulo3.value = idarticulo;
                                    parent.opener.document.formulario.costo3.value = costo;
                                    parent.opener.document.formulario.stock3.value = stock;
                                    if (iva == 1) {
                                        parent.opener.document.formulario.ivaporc3.value =<?php  echo $ivaporcetaje; ?>;
                                        parent.opener.document.formulario.grabaiva3.style.display = 'inherit';
                                    }
                                    else {
                                        parent.opener.document.formulario.ivaporc3.value = 0;
                                        parent.opener.document.formulario.grabaiva3.style.display = 'none';
                                    }

                                    parent.opener.document.formulario.cantidad3.value = 0;
                                    break;

                                case 4:
                                    parent.opener.document.formulario.codarticulo4.value = codarticulo;
                                    parent.opener.document.formulario.descripcion4.value = nombre;
                                    parent.opener.document.formulario.precio4.value = precio;
                                    parent.opener.document.formulario.idarticulo4.value = idarticulo;
                                    parent.opener.document.formulario.costo4.value = costo;
                                    parent.opener.document.formulario.stock4.value = stock;
                                    if (iva == 1) {
                                        parent.opener.document.formulario.ivaporc4.value =<?php  echo $ivaporcetaje; ?>;
                                        parent.opener.document.formulario.grabaiva4.style.display = 'inherit';
                                    }
                                    else {
                                        parent.opener.document.formulario.ivaporc4.value = 0;
                                        parent.opener.document.formulario.grabaiva4.style.display = 'none';
                                    }

                                    parent.opener.document.formulario.cantidad4.value = 0;
                                    break;

                                case 5:
                                    parent.opener.document.formulario.codarticulo5.value = codarticulo;
                                    parent.opener.document.formulario.descripcion5.value = nombre;
                                    parent.opener.document.formulario.precio5.value = precio;
                                    parent.opener.document.formulario.idarticulo5.value = idarticulo;
                                    parent.opener.document.formulario.costo5.value = costo;
                                    parent.opener.document.formulario.stock5.value = stock;
                                    if (iva == 1) {
                                        parent.opener.document.formulario.ivaporc5.value =<?php  echo $ivaporcetaje; ?>;
                                        parent.opener.document.formulario.grabaiva5.style.display = 'inherit';
                                    }
                                    else {
                                        parent.opener.document.formulario.ivaporc5.value = 0;
                                        parent.opener.document.formulario.grabaiva5.style.display = 'none';
                                    }

                                    parent.opener.document.formulario.cantidad5.value = 0;
                                    break;

                                case 6:
                                    parent.opener.document.formulario.codarticulo6.value = codarticulo;
                                    parent.opener.document.formulario.descripcion6.value = nombre;
                                    parent.opener.document.formulario.precio6.value = precio;
                                    parent.opener.document.formulario.idarticulo6.value = idarticulo;
                                    parent.opener.document.formulario.costo6.value = costo;
                                    parent.opener.document.formulario.stock6.value = stock;
                                    if (iva == 1) {
                                        parent.opener.document.formulario.ivaporc6.value =<?php  echo $ivaporcetaje; ?>;
                                        parent.opener.document.formulario.grabaiva6.style.display = 'inherit';
                                    }
                                    else {
                                        parent.opener.document.formulario.ivaporc6.value = 0;
                                        parent.opener.document.formulario.grabaiva6.style.display = 'none';
                                    }

                                    parent.opener.document.formulario.cantidad6.value = 0;
                                    break;

                                case 7:
                                    parent.opener.document.formulario.codarticulo7.value = codarticulo;
                                    parent.opener.document.formulario.descripcion7.value = nombre;
                                    parent.opener.document.formulario.precio7.value = precio;
                                    parent.opener.document.formulario.idarticulo7.value = idarticulo;
                                    parent.opener.document.formulario.costo7.value = costo;
                                    parent.opener.document.formulario.stock7.value = stock;
                                    if (iva == 1) {
                                        parent.opener.document.formulario.ivaporc7.value =<?php  echo $ivaporcetaje; ?>;
                                        parent.opener.document.formulario.grabaiva7.style.display = 'inherit';
                                    }
                                    else {
                                        parent.opener.document.formulario.ivaporc7.value = 0;
                                        parent.opener.document.formulario.grabaiva7.style.display = 'none';
                                    }

                                    parent.opener.document.formulario.cantidad7.value = 0;
                                    break;

                                case 8:
                                    parent.opener.document.formulario.codarticulo8.value = codarticulo;
                                    parent.opener.document.formulario.descripcion8.value = nombre;
                                    parent.opener.document.formulario.precio8.value = precio;
                                    parent.opener.document.formulario.idarticulo8.value = idarticulo;
                                    parent.opener.document.formulario.costo8.value = costo;
                                    parent.opener.document.formulario.stock8.value = stock;
                                    if (iva == 1) {
                                        parent.opener.document.formulario.ivaporc8.value =<?php  echo $ivaporcetaje; ?>;
                                        parent.opener.document.formulario.grabaiva8.style.display = 'inherit';
                                    }
                                    else {
                                        parent.opener.document.formulario.ivaporc8.value = 0;
                                        parent.opener.document.formulario.grabaiva8.style.display = 'none';
                                    }

                                    parent.opener.document.formulario.cantidad8.value = 0;
                                    break;

                                case 9:
                                    parent.opener.document.formulario.codarticulo9.value = codarticulo;
                                    parent.opener.document.formulario.descripcion9.value = nombre;
                                    parent.opener.document.formulario.precio9.value = precio;
                                    parent.opener.document.formulario.idarticulo9.value = idarticulo;
                                    parent.opener.document.formulario.costo9.value = costo;
                                    parent.opener.document.formulario.stock9.value = stock;
                                    if (iva == 1) {
                                        parent.opener.document.formulario.ivaporc9.value =<?php  echo $ivaporcetaje; ?>;
                                        parent.opener.document.formulario.grabaiva9.style.display = 'inherit';
                                    }
                                    else {
                                        parent.opener.document.formulario.ivaporc9.value = 0;
                                        parent.opener.document.formulario.grabaiva9.style.display = 'none';
                                    }

                                    parent.opener.document.formulario.cantidad9.value = 0;
                                    break;

                                case 10:
                                    parent.opener.document.formulario.codarticulo10.value = codarticulo;
                                    parent.opener.document.formulario.descripcion10.value = nombre;
                                    parent.opener.document.formulario.precio10.value = precio;
                                    parent.opener.document.formulario.idarticulo10.value = idarticulo;
                                    parent.opener.document.formulario.costo10.value = costo;
                                    parent.opener.document.formulario.stock10.value = stock;
                                    if (iva == 1) {
                                        parent.opener.document.formulario.ivaporc10.value =<?php  echo $ivaporcetaje; ?>;
                                        parent.opener.document.formulario.grabaiva10.style.display = 'inherit';
                                    }
                                    else {
                                        parent.opener.document.formulario.ivaporc10.value = 0;
                                        parent.opener.document.formulario.grabaiva10.style.display = 'none';
                                    }

                                    parent.opener.document.formulario.cantidad10.value = 0;
                                    break;
                                case 11:
                                    parent.opener.document.formulario.codarticulo11.value = codarticulo;
                                    parent.opener.document.formulario.descripcion11.value = nombre;
                                    parent.opener.document.formulario.precio11.value = precio;
                                    parent.opener.document.formulario.idarticulo11.value = idarticulo;
                                    parent.opener.document.formulario.costo11.value = costo;
                                    parent.opener.document.formulario.stock11.value = stock;
                                    if (iva == 1) {
                                        parent.opener.document.formulario.ivaporc11.value =<?php  echo $ivaporcetaje; ?>;
                                        parent.opener.document.formulario.grabaiva11.style.display = 'inherit';
                                    }
                                    else {
                                        parent.opener.document.formulario.ivaporc11.value = 0;
                                        parent.opener.document.formulario.grabaiva11.style.display = 'none';
                                    }

                                    parent.opener.document.formulario.cantidad11.value = 0;
                                    break;
                            }

                            parent.opener.actualizar_importe(op);
                            parent.window.close();
                        }
                    }
                }
            }
            else {
                history.back();
            }
        }


        function ingreso_factura_compra(validacion, codarticulo, nombre, idarticulo, iva, costo, pvp) {
            if (validacion == 0) {
                parent.opener.document.formulario_lineas.codarticulo.value = codarticulo;
                parent.opener.document.formulario_lineas.descripcion.value = nombre;
                parent.opener.document.formulario_lineas.idarticulo.value = idarticulo;
                parent.opener.document.formulario_lineas.precio.value = costo;
                parent.opener.document.formulario_lineas.pvp.value = pvp;
                if (iva == 1) {
                    parent.opener.document.formulario_lineas.ivaporc.value =<?php  echo $ivaporcetaje; ?>;
                }
                else {
                    parent.opener.document.formulario_lineas.ivaporc.value = 0;
                }
                parent.opener.actualizar_importe();
                parent.window.close();
            }
            else {
                history.back();
            }
        }
    </script>
</head>
<body>
<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
            <div id="tituloForm" class="header"><?php  echo $cabecera2 ?></div>
            <div id="frmBusqueda">
                <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
                    <tr>
                        <td width="15%"></td>
                        <td width="85%" colspan="2" class="mensaje"><?php  echo $mensaje; ?></td>
                    </tr>
                    <tr>
                        <td width="15%">Producto Gasto:</td>
                        <td width="85%" colspan="2"><?php  echo $esGasto ?></td>
                    </tr>
                    <tr>
                        <td width="15%">C&oacute;digo</td>
                        <td width="85%" colspan="2"><?php  echo $codigo ?></td>
                    </tr>
                    <tr>
                        <td width="15%">Nombre</td>
                        <td width="85%" colspan="2"><?php  echo $nombre ?></td>
                    </tr>
                    <tr>
                        <td width="15%">GRAVA IVA:</td>
                        <?php  if ($iva == 0) { ?>
                            <td width="85%" colspan="2">NO</td>
                        <?php  } else { ?>
                            <td width="85%" colspan="2">SI</td>
                        <?php  } ?>
                    </tr>

                    <tr>
                        <td>PRODUCTO ESPECIAL</td>
                        <?php  if ($especial == 0) { ?>
                            <td width="85%" colspan="2">NO</td>
                        <?php  } else { ?>
                            <td width="85%" colspan="2">SI</td>
                        <?php  } ?>
                    </tr>
                    <tr>
                        <td>Stock</td>
                        <td colspan="2"><?php  echo $stock ?></td>
                    </tr>
                    <tr>
                        <td>Stock Consignacion</td>
                        <td colspan="2"><?php  echo $stock_consignacion ?></td>
                    </tr>
                    <tr>
                        <td>PVP</td>
                        <td colspan="2"><?php  echo $pvp ?></td>
                    </tr>

                    <tr>
                        <td>Utilidad</td>
                        <td colspan="2"><?php  echo $utilidad ?>%</td>
                    </tr>

                    <tr>
                        <td>Composici&oacute;n</td>
                        <td colspan="2"><?php  echo $composicion ?></td>
                    </tr>
                    <tr>
                        <td>Aplicaci&oacute;n</td>
                        <td colspan="2"><?php  echo $aplicacion ?></td>
                    </tr>
                    <?php 
                    $quer = "SELECT empresa FROM proveedor WHERE id_proveedor=$proveedor";
                    $res = mysql_query($quer, $conn);
                    ?>

                    <tr>
                        <td>Proveedor</td>
                        <td colspan="2"><?php  echo mysql_result($res, 0, "empresa") ?></td>
                    </tr>

                    <?php 
                    $quer = "SELECT nombre FROM grupo WHERE id_grupo=$grupo";
                    $res = mysql_query($quer, $conn);
                    ?>

                    <tr>
                        <td>Grupo</td>
                        <td><?php  echo mysql_result($res, 0, "nombre") ?></td>
                    </tr>

                    <?php 
                    $quer = "SELECT nombre FROM subgrupo WHERE id_subgrupo=$subgrupo";
                    $res = mysql_query($quer, $conn);
                    ?>


                    <tr>
                        <td>Subgrupo</td>
                        <td><?php  echo mysql_result($res, 0, "nombre") ?></td>
                    </tr>
                </table>
            </div>
            <div id="botonBusqueda">
                <?php  if ($origen == "factura") { ?>
                    <img src="../img/botonaceptar.jpg" width="85" height="22"
                         onClick="ingreso_factura_venta(<?php  echo $validacion ?>,'<?php  echo $codigo ?>','<?php  echo $nombre ?>','<?php  echo $pvp ?>','<?php  echo $idproducto ?>','<?php  echo $costo ?>','<?php  echo $stock ?>','<?php  echo $iva ?>',<?php  echo $op ?>)"
                         border="1" onMouseOver="style.cursor=cursor">
                <?php  } else {
                    if ($origen == "facturacompra") { ?>
                        <img src="../img/botonaceptar.jpg" width="85" height="22"
                             onClick="ingreso_factura_compra(<?php  echo $validacion ?>,'<?php  echo $codigo ?>','<?php  echo $nombre ?>','<?php  echo $idproducto ?>','<?php  echo $iva ?>', '<?php  echo $costo ?>','<?php  echo $pvp ?>')"
                             border="1" onMouseOver="style.cursor=cursor">
                    <?php  } else {
                        ?>
                        <img src="../img/botonaceptar.jpg" width="85" height="22"
                             onClick="aceptar(<?php  echo $validacion ?>)" border="1" onMouseOver="style.cursor=cursor">
                    <?php  }
                } ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>