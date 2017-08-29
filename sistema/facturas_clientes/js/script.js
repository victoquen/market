/*
 * Add edit delete rows dynamically using jquery and php
 * http://www.amitpatil.me/
 *
 * @version
 * 2.0 (4/19/2014)
 *
 * @copyright
 * Copyright (C) 2014-2015
 *
 * @Auther
 * Amit Patil
 * Maharashtra (India)
 *
 * @license
 * This file is part of Add edit delete rows dynamically using jquery and php.
 *
 * Add edit delete rows dynamically using jquery and php is freeware script. you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Add edit delete rows dynamically using jquery and php is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this script.  If not, see <http://www.gnu.org/copyleft/lesser.html>.
 */


// init variables
var trcopy;
var editing = 0;
var tdediting = 0;
var editingtrid = 0;
var editingtdcol = 0;
var inputs = ':checked,:selected,:text,textarea,:hidden';

// Q : 81 113  guardar item seleccionado
//enter : 13   para mandar a buscar al item
// a: 65 97 cambiar al pvpA
// b: 66 98 cambiar al pvpB
// c: 67 99 cambiar al pvpC
// d: 68 100 cambiar al pvpD

$(document).ready(function () {

    $(document).on("keypress", function (e) {

        
        if ((e.which == 81)||(e.which == 113)) {
           $("." + savebutton).click();
           document.getElementById("dproducto").focus();
        }else if((e.which == 65)||(e.which == 97)&&(document.getElementById("precio").value != "")){
            document.getElementById("tipo_pvp").innerHTML = "A";
            document.getElementById("precio").value = document.getElementById("pvpa").value;
            actualizar_importe_post();
        }else if((e.which == 66)||(e.which == 98)&&(document.getElementById("precio").value != "")){
            document.getElementById("tipo_pvp").innerHTML = "B";
            document.getElementById("precio").value = document.getElementById("pvpb").value;
            actualizar_importe_post();
        }else if((e.which == 67)||(e.which == 99)&&(document.getElementById("precio").value != "")){
            document.getElementById("tipo_pvp").innerHTML = "C";
            document.getElementById("precio").value = document.getElementById("pvpc").value;
            actualizar_importe_post();
        }else if((e.which == 68)||(e.which == 100)&&(document.getElementById("precio").value != "")){
            document.getElementById("tipo_pvp").innerHTML = "D";
            document.getElementById("precio").value = document.getElementById("pvpd").value;
            actualizar_importe_post();
        }

    });




    // set images for edit and delete
    $(".eimage").attr("src", editImage);
    $(".dimage").attr("src", deleteImage);

    // init table
    blankrow = '<tr valign="top" class="inputform"><td></td>';
    for (i = 0; i < columns.length; i++) {
        // Create input element as per the definition
        input = createInput(i, "");

        if (inputType[i] != "hidden")
            blankrow += '<td class="ajaxReq">' + input + '</td>';
        else
            blankrow += input;
    }
    blankrow += '<td><a href="javascript:;"  class="' + savebutton + '"><img src="' + saveImage + '"></a></td></tr>';

    // append blank row at the end of table
    $("." + table + " > thead").prepend(blankrow);

    // Delete record
    $(document).on("click", "." + deletebutton, function () {
        var id = $(this).attr("id");
        var codf = localStorage.getItem('codtmp');
        if (id) {
            if (confirm("Do you really want to delete record ? " + id + "--" + codf))

                ajax("rid=" + id + "&rcod=" + codf, "del");
        }
    });

    // Add new record
    $("." + savebutton).on("click", function () {

        var itemstotal = localStorage.getItem('itemstotal');
        var totalrecord = localStorage.getItem('totalrecord');


        //if(totalrecord < itemstotal){ //if para controlar el total de items
            var validation = 1;
            var $inputs =
                $(document).find("." + table).find(inputs).filter(function () {
                    // check if input element is blank ??
                    if ($.trim(this.value) == "") {
                        $(this).addClass("error");
                        validation = 0;
                    } else {
                        $(this).addClass("success");
                    }
                    return $.trim(this.value);
                });

            var array = $inputs.map(function () {
                return this.value;
            }).get();

            var serialized = $inputs.serialize();
            if (validation == 1) {
                ajax(serialized, "save");
            }
        /*}else{
            alert("NO SE ADMINITE MAS ARTICULOS");
        }*/


    });

    // update all record
    $(document).on("click", "." + editbutton, function () {
        var id = $(this).attr("id");
        if (id && editing == 0 && tdediting == 0) {
            // hide editing row, for the time being
            $("." + table + " tr:first-child").fadeOut("fast");
            //$("."+table+" tr:last-child").fadeOut("fast");

            var html;
            html += "<td>" + $("." + table + " tr[id=" + id + "] td:first-child").html() + "</td>";
            for (i = 0; i < columns.length; i++) {
                // fetch value inside the TD and place as VALUE in input field
                var val = $(document).find("." + table + " tr[id=" + id + "] td[class='" + columns[i] + "']").html();
                input = createInput(i, val);
                html += '<td>' + input + '</td>';
            }
            html += '<td><a href="javascript:;" id="' + id + '" class="' + updatebutton + '"><img src="' + updateImage + '"></a> <a href="javascript:;" id="' + id + '" class="' + cancelbutton + '"><img src="' + cancelImage + '"></a></td>';

            // Before replacing the TR contents, make a copy so when user clicks on
            trcopy = $("." + table + " tr[id=" + id + "]").html();
            $("." + table + " tr[id=" + id + "]").html(html);

            // set editing flag
            editing = 1;
        }
    });

    $(document).on("click", "." + cancelbutton, function () {
        var id = $(this).attr("id");
        $("." + table + " tr[id='" + id + "']").html(trcopy);
        $("." + table + " tr:first-child").fadeIn("fast");
        //$("."+table+" tr:last-child").fadeIn("fast");
        editing = 0;
    });

    $(document).on("click", "." + updatebutton, function () {
        var id = $(this).attr("id");
        var codf = localStorage.getItem('codtmp');
        serialized = $("." + table + " tr[id='" + id + "']").find(inputs).serialize();
        ajax(serialized + "&rid=" + id + "&rcod=" + codf, "update");
        return;
        // clear editing flag
        editing = 0;
    });

    // td doubleclick event
    $(document).on("dblclick", "." + table + " td", function (e) {
        // check if any other TD is in editing mode ? If so then dont show editing box
        //alert(tdediting+"==="+editing);

        var isEditingform = $(this).closest("tr").attr("class");
        if (tdediting == 0 && editing == 0 && isEditingform != "inputform") {
            editingtrid = $(this).closest('tr').attr("id");
            editingtdcol = $(this).attr("class");
            if (editingtdcol != undefined) {
                var text = $(this).html();
                var tr = $(this).parent();
                var tbody = tr.parent();
                for (var i = 0; i < tr.children().length; i++) {
                    if (tr.children().get(i) == this) {
                        var column = i;
                        break;
                    }
                }

                // decrement column value by one to avoid sr no column
                column--;
                //alert(column+"==="+placeholder[column]);
                if ((column <= columns.length) && (columns[column] != "dproducto" ) && (columns[column] != "importe" ) && (columns[column] != "iva" )) {

                    var text = $(this).html();
                    //alert(text);
                    input = createInput(column, text);
                    $(this).html(input);
                    $(this).find(inputs).focus();
                    tdediting = 1;

                }
            }

        }
    });

    // td lost focus event
    $(document).on("blur", "." + table + " td", function (e) {
        if (tdediting == 1) {
            var codf = localStorage.getItem('codtmp');
            var newval = $("." + table + " tr[id='" + editingtrid + "'] td[class='" + editingtdcol + "']").find(inputs).val();
            ajax(editingtdcol + "=" + newval + "&rid=" + editingtrid + "&rcod=" + codf, "updatetd");
        }
    });


});

function onChangeDescuento() {
    localStorage.setItem('descuento', document.querySelector('input[name=tipo_precio]:checked').value);
    localStorage.setItem('forma_pago', document.querySelector('input[name=forma_pago]:checked').value);
    //alert("n: "+localStorage.getItem('descuento'));
    var codf = localStorage.getItem('codtmp');
    ajax("tipo_precio=" + localStorage.getItem('descuento') + "&forma_pago=" + localStorage.getItem('forma_pago') +  "&rcod=" + codf, "descuentos");
}




/*function ventanaArticulos() {

 miPopup = window.open("ver_articulos.php", "miwin", "width=700,height=580,scrollbars=yes");
 miPopup.focus();

 }*/

function limpiarTexto(elemento){
    //document.getElementById('dproducto').value = "";
    elemento.value="";
}


function handleKeyPress(e){
    var key=e.keyCode || e.which;
    if ((key==13)){
        ventanaArticulos();
    }
}

createInput = function (i, str) {
    str = typeof str !== 'undefined' ? str : null;
    if (inputType[i] == "text") {
        if (columns[i] == "dproducto") {
            input = '<input class="cajaExtraGrande" onkeypress="handleKeyPress(event)" onclick="javascript: limpiarTexto(this);"  type=' + inputType[i] + ' name=' + columns[i] + ' id=' + columns[i] + ' placeholder="' + placeholder[i] + '" value=' + str + '  > ' +
                '<img src="../img/ver.png" width="20%" height="20%" onClick="ventanaArticulos()" onMouseOver="style.cursor=cursor" title="Buscar articulos">';

        } else if (columns[i] == "dcto") {
            input = '<input class="cajaPequena2" onChange="actualizar_importe_post()" type=' + inputType[i] + ' name=' + columns[i] + ' id=' + columns[i] + '  placeholder="' + placeholder[i] + '" value=' + str + ' >';

        } else if (columns[i] == "cantidad") {
            input = '<input class="cajaPequena2" onChange="actualizar_importe_post()" type=' + inputType[i] + ' name=' + columns[i] + ' id=' + columns[i] + '  placeholder="' + placeholder[i] + '" value=' + str + ' >';

        } else if (columns[i] == "precio") {
            input = '<input class="cajaPequena2" onChange="actualizar_importe_post()" type=' + inputType[i] + ' name=' + columns[i] + ' id=' + columns[i] + '  placeholder="' + placeholder[i] + '" value=' + str + ' >' ;

        } else if (columns[i] == "iva") {
            input = '<input class="cajaPequena2" readonly="true" type=' + inputType[i] + ' name=' + columns[i] + ' id=' + columns[i] + '  placeholder="' + placeholder[i] + '" value=' + str + ' >';

        } else if (columns[i] == "importe") {
            input = '<input class="cajaPequena2" readonly="true" type=' + inputType[i] + ' name=' + columns[i] + ' id=' + columns[i] + '  placeholder="' + placeholder[i] + '" value=' + str + ' >';

        } else {
            input = '<input class="cajaPequena2"  type=' + inputType[i] + ' name=' + columns[i] + ' id=' + columns[i] + '  placeholder="' + placeholder[i] + '" value=' + str + ' >';

        }

    } else if (inputType[i] == "textarea") {
        input = '<textarea name=' + columns[i] + ' id=' + columns[i] + ' placeholder="' + placeholder[i] + '">' + str + '</textarea>';
    } else if (inputType[i] == "hidden") {
        input = '<input  type=' + inputType[i] + ' name=' + columns[i] + ' id=' + columns[i] + '  />';
    }
    return input;
}


createInputHidden = function (i, str) {
    str = typeof str !== 'undefined' ? str : null;
    input = '<input  type=' + inputType[i] + ' name=' + columns[i] + ' id=' + columns[i] + ' value=' + str + ' />';
    return input;
}

function actualizar_totales_post($datos) {
    for (j = 0; j < columns_totales.length; j++) {
        document.getElementById(columns_totales[j]).value = $datos[columns_totales[j]];
    }
    sumar_flete();
}


ajax = function (params, action) {
    $.ajax({
        type: "POST",
        url: "ajax.php",
        data: params + "&action=" + action,
        dataType: "json",
        success: function (response) {
            switch (response.action) {
                case "save":
                    //var seclastRow = $("."+table+" tr").length;
                    var seclastRow = response["id"];
                    if (response.success == 1) {
                        var html = "";

                        //html += "<td>"+parseInt(seclastRow - 1)+"</td>";
                        html += "<td>" + parseInt(seclastRow) + "</td>";
                        for (i = 0; i < columns.length; i++) {

                            if ((inputType[i] != "hidden"))
                                html += '<td class="' + columns[i] + '">' + response[columns[i]] + '</td>';
                            else
                                html += response[columns[i]];
                        }
                        html += '<td><a href="javascript:;" id="' + response["id"] + '" class="' + deletebutton + '"><img src="' + deleteImage + '"></a></td>';
                        //html += '<td><a href="javascript:;" id="'+response["id"]+'" class="ajaxEdit"><img src="'+editImage+'"></a> <a href="javascript:;" id="'+response["id"]+'" class="'+deletebutton+'"><img src="'+deleteImage+'"></a></td>';
                        // Append new row as a second last row of a table
                        $("." + table + " > thead ").first().after('<tr id="' + response.id + '">' + html + '</tr>');


                        actualizar_totales_post(response);
                        localStorage.setItem('totalrecord', response['totalrecord']);

                        /*
                         if (effect == "slide") {
                         // Little hack to animate TR element smoothly, wrap it in div and replace then again replace with td and tr's ;)
                         $("." + table + " tr:nth-child(" + seclastRow + ")").find('td')
                         .wrapInner('<div style="display: none;" />')
                         .parent()
                         .find('td > div')
                         .slideDown(700, function () {
                         var $set = $(this);
                         $set.replaceWith($set.contents());
                         });
                         }
                         else if (effect == "flash") {
                         $("." + table + " tr:nth-child(" + seclastRow + ")").effect("highlight", {color: '#acfdaa'}, 100);
                         } else
                         $("." + table + " tr:nth-child(" + seclastRow + ")").effect("highlight", {color: '#acfdaa'}, 100);
                         */


                        // Blank input fields
                        $(document).find("." + table).find(inputs).filter(function () {
                            // check if input element is blank ??
                            this.value = "";
                            $(this).removeClass("success").removeClass("error");
                        });
                    }
                    break;
                case "del":
                    var seclastRow = $("." + table + " tr").length;
                    if (response.success == 1) {
                        $("." + table + " tr[id='" + response.id + "']").effect("highlight", {color: '#f4667b'}, 1, function () {
                            $("." + table + " tr[id='" + response.id + "']").remove();
                        });

                        actualizar_totales_post(response);
                        localStorage.setItem('totalrecord', response['totalrecord']);

                    }
                    break;
                case "update":
                    /* $("." + cancelbutton).trigger("click");
                     for (i = 0; i < columns_edit.length; i++) {
                     $("tr[id='" + response.id + "'] td[class='" + columns_edit[i] + "']").html(response[columns_edit[i]]);
                     }
                     actualizar_totales_post(response);*/

                    for (i = 0; i < columns_edit.length; i++) {
                        $("tr[id='" + response.id + "'] td[class='" + columns_edit[i] + "']").html(response[columns_edit[i]]);
                    }
                    actualizar_totales_post(response);
                    // remove editing flag
                    //tdediting = 0;
                    // $("." + table + " tr[id='" + response.id + "'] td[class='cantidad']").effect("highlight", {color: '#acfdaa'}, 1);
                    $(document).find("." + table).find(inputs).filter(function () {
                        // check if input element is blank ??
                        this.value = "";
                        $(this).removeClass("success").removeClass("error");
                    });

                    break;
                case "updatetd":
                    // var newval = $("." + table + " tr[id='" + editingtrid + "'] td[class='" + editingtdcol + "']").find(inputs).val();
                    // $("." + table + " tr[id='" + editingtrid + "'] td[class='" + editingtdcol + "']").html(newval);
                    for (i = 0; i < columns_edit.length; i++) {
                        $("tr[id='" + editingtrid + "'] td[class='" + columns_edit[i] + "']").html(response[columns_edit[i]]);
                    }
                    actualizar_totales_post(response);
                    // remove editing flag
                    tdediting = 0;
                    $("." + table + " tr[id='" + editingtrid + "'] td[class='" + editingtdcol + "']").effect("highlight", {color: '#acfdaa'}, 1);
                    break;
                case "descuentos":

                    var record = null;
                    for (i = 0; i < response["records"].length; i++) {
                        record = response["records"][i];
                        for (j = 0; j < columns_edit.length; j++) {
                            $("tr[id='" + record["numlinea"] + "'] td[class='" + columns_edit[j] + "']").html(record[columns_edit[j]]);
                        }
                    }

                    actualizar_totales_post(response);
                    break;
            }
        },
        error: function () {
            alert("Unexpected error, Please try again");
        }
    });
}