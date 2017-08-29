/*
 funciones de javascript para seleccionar los articulos de la factura
 gestionando totales

 */
var credit = 0;


var miPopup;
function abreVentana() {
    var codfactura = document.getElementById("codfactura").value;
    if (codfactura == "") {
        alert("Debe ingresar el codigo de la FACTURA");
    }
    else {
        miPopup = window.open("ver_clientes.php", "miwin", "width=900px,height=550px,scrollbars=yes");
        miPopup.focus();
    }
}


function ventanaArticulos1(op) {

    miPopup = window.open("ver_articulos.php", "miwin", "width=700,height=580,scrollbars=yes");
    miPopup.focus();

}

function ventanaArticulos() {
    var tx = document.getElementById("dproducto").value;

    miPopup = window.open("ver_articulos.php?text_search="+tx, "miwin", "width=700,height=580,scrollbars=yes");
    miPopup.focus();

}




function actualizar_importe_individual(cant, pvp) {
    var sub = cant * pvp;
    var original = parseFloat(sub);
    var result = Math.round(original * 100) / 100;
    return result;
}

function actualizar_iva_individual(imp, por, iv) {
    var impor_iva = 0;
    if (iv == 1) {
        impor_iva = imp * por / 100;
    }
    var original = parseFloat(impor_iva);
    var result = Math.round(original * 100) / 100;
    return result;
}
function actualizar_importe_post() {

    var orgdcto = parseFloat(document.getElementById("dcto").value);
    var resdcto = Math.round(orgdcto * 100) / 100;

    var orgimp = parseFloat(document.getElementById("cantidad").value * document.getElementById("precio").value);
    var resimp = Math.round(orgimp * 100) / 100;

    var res = resimp - resdcto;
    var original = parseFloat(res);
    var result = Math.round(original * 100) / 100;
    document.getElementById("importe").value = result.toFixed(2);

    var orgiva = parseFloat(document.getElementById("iva").value);
    var resiva =  Math.round(orgiva * 100) / 100;

    if(resiva >0){
        var porc = localStorage.getItem('iva_porcentaje')
        document.getElementById("iva").value = actualizar_iva_individual(result,porc,1);
    }
}

function actualizar_importe_post_modificar() {

    var orgdcto = parseFloat(document.getElementById("dcto").value);
    var resdcto = Math.round(orgdcto * 100) / 100;

    var orgimp = parseFloat(document.getElementById("cantidad").value * document.getElementById("precio").value);
    var resimp = Math.round(orgimp * 100) / 100;

    var res = resimp - resdcto;
    var original = parseFloat(res);
    var result = Math.round(original * 100) / 100;
    document.getElementById("subtotal").value = result.toFixed(2);

    var orgiva = parseFloat(document.getElementById("iva").value);
    var resiva =  Math.round(orgiva * 100) / 100;

    if(resiva >0){
        var porc = localStorage.getItem('iva_porcentaje')
        document.getElementById("iva").value = actualizar_iva_individual(result,porc,1);
    }
}




function validarcliente() {
    var codigo = document.getElementById("codcliente").value;
    miPopup = window.open("comprobarcliente.php?codcliente=" + codigo, "frame_datos", "width=700,height=80,scrollbars=yes");
}

function cancelar() {
    location.href = "index.php";
}

function limpiarcaja() {
    document.getElementById("codcliente").value = "";
    document.getElementById("nombre").value = "";
    document.getElementById("nif").value = "";
}


function validar_cabecera() {
    var mensaje = "";
    if (document.getElementById("codfactura").value == "") mensaje += "  - Codigo Factura no ingresado\n";
    if (document.getElementById("nombre").value == "") mensaje += "  - Cliente no ingresado\n";
    if (document.getElementById("fecha").value == "") mensaje += "  - Fecha\n";
    if (document.getElementById("cbocredito").value == "2") mensaje += "  - Credito no seleccionado\n";
    if (document.getElementById("forma_pago").value == "") mensaje += "  - Forma Pago no seleccionado\n";
    var count = $("." + table + " tr").length;
    if (count == 2) mensaje += "  - Factura sin artículos\n";





    if (mensaje != "") {



        alert("Atencion, se han detectado las siguientes inconsistencias:\n\n" + mensaje);
    } else {
        document.getElementById("formulario").submit();
        localStorage.clear();
    }

}


function activar_plazo(indice) {
    with (document.formulario) {
        value = cbocredito.options[indice].value;
        switch (value) {
            case "0":
                credit = 1;
                cboplazo.selectedIndex = 0;
                cboplazo.readonly = true;
                break;
            case "2":
                credit = 0;
                cboplazo.selectedIndex = 0;
                cboplazo.readonly = true;
                break;
            default:
                credit = 1;
                cboplazo.readonly = false;
                cboplazo.selectedIndex = 0;
                break;
        }
    }
}

function sumar_flete() {
    var original = parseFloat(document.getElementById("flete").value);
    if (isNaN(original) == true) {

        alert("Atencion, el valor del Flete debe ser numerico");
        document.getElementById("flete").value = 0;
        actualizar_totales();
    } else {
        var result = Math.round(original * 100) / 100;
        document.getElementById("flete").value = result.toFixed(2);


        var original7 = parseFloat(document.getElementById("preciototal").value);
        var result7 = Math.round(original7 * 100) / 100;
        var tot = result7 + result;

        document.getElementById("preciototal").value = tot.toFixed(2);

    }
}





function sumarFlete(textbox) {
    //alert("Value is " + textbox.value + "\n" + "Old Value is " + textbox.oldvalue);

    var fleteAnt = textbox.oldvalue;
    var fleteNuevo =textbox.value;
    var diferencia = fleteNuevo - fleteAnt;


    var original7 = parseFloat(document.getElementById("preciototal").value);
    var result7 = Math.round(original7 * 100) / 100;
    var tot = result7 + diferencia;
    //var tot = result7 + fleteNuevo - fleteAnt;
    document.getElementById("preciototal").value = tot.toFixed(2);
}

function prorratear() {
    var original = parseFloat(document.getElementById("descuentomanual").value);
    if (isNaN(original) == true) {

        alert("Atencion, el valor del Descuento debe ser numerico");
        document.getElementById("descuentomanual").value = 0;
        actualizar_totales();
    } else {
        var result = Math.round(original * 100) / 100;
        document.getElementById("descuentomanual").value = result.toFixed(2);

        actualizar_totales();
    }
}

