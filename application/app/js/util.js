/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



function nobackbutton() {
    window.location.hash = "no-back-button";
    window.location.hash = "Again-No-back-button" //chrome
    window.onhashchange = function () {
        window.location.hash = "no-back-button";
    }

}


function setValue(campo, valor, formatofecha) {
    //console.log(campo + ":" + valor);
    if (valor !== null && valor.length > 0 && !(/^\s+$/.test(valor))) {

        if (formatofecha) {
            valor = valor.substring(0, 10);
            //console.log(campo + " substring:" + valor);
        }

        if ($('#' + campo).is('input:radio')) {
            $('input:radio[name=' + campo + ']').filter('[value=' + valor + ']').prop('checked', true);
        } else if ($('#' + campo).is('input:text')) {
            $('#' + campo).val(valor);
        } else if ($('#' + campo).is('input:checkbox')) {
            //console.log("is checkbox")
            if (valor === "1") {
                $('#' + campo).prop("checked", true);
            } else if (valor === "0") {
                $('#' + campo).prop("checked", false);
            }
        } else if ($('#' + campo).is('input:select')) {
            $('#' + campo).val(valor);
        }
    }
}

function inputValue(campo, valor) {
    /* ******************************************
     Sofditech: 15/07/2020 v1
     Funcion para leer y asignar valores a inputs de diferentes tipos.

     si lleva el atributo valor, asigna el valor al input.
     si no lleva atributo valor, lee actual valor del input.

     Segun el tipo de input:
        radio:      <campo> use name html, <valor> value option
        text:       <campo> use id html, <valor> texto
        checkbox:   <campo> use id html, <valor> use true/false para marcar seleccionado el checkbox
        select:     <campo> use id html, <valor> value option
    ****************************************** */
    if ($("input[name='" + campo + "']").is('input:radio')) {
        if (valor) {
            $('input:radio[name=' + campo + ']').filter('[value=' + valor + ']').prop('checked', true).change();
        } else {
            return $("input[name='" + campo + "']:checked").val();
        }

    } else if ($('#' + campo).is('input:text')) {
        if (valor) {
            $('#' + campo).val(valor).change();
        } else {
            return $('#' + campo).val();
        }

    } else if ($('#' + campo).is('input:checkbox')) {
        if (valor) {
            $('#' + campo).prop("checked", valor).change();
        } else {
            return $('#' + campo).prop("checked");
        }

    } else if ($('#' + campo).is('select')) {
        if (valor) {
            $('#' + campo).val(valor).change();
        } else {
            return $('#' + campo).val();
        }

    } else {
        if (valor) {
            $('#' + campo).val(valor);
        } else {
            return $('#' + campo).val();
        }
    }
}

function number_format(amount, decimals) {
    /*
     * Fuente: https://gist.github.com/jrobinsonc/5718959
     */

    amount += ''; // por si pasan un numero en vez de un string
    //amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto 
    amount = parseFloat(amount.replace(/[^0-9\.-]/g, '')); // andresfgiraldo: En la expresion regular se agrega "-" para permitir negativos.

    decimals = decimals || 0; // por si la variable no fue fue pasada

    // si no es un numero o es igual a cero retorno el mismo cero
    if (isNaN(amount) || amount === 0)
        return parseFloat(0).toFixed(decimals);

    // si es mayor o menor que cero retorno el valor formateado como numero
    amount = '' + amount.toFixed(decimals);

    var amount_parts = amount.split('.'),
        regexp = /(\d+)(\d{3})/;

    while (regexp.test(amount_parts[0]))
        amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');

    return amount_parts.join('.');
}

function cboLoad(campo, url, selected, deleteopt, tx_none = null, col_idx = 0, col_dsc = 1) {
    let conf = {
        url,
        headers: { 'access-token': getToken() }
    }
    $.get(conf, function (responseJson) {
        var $select = $('#' + campo);

        if (deleteopt) {
            $select.find('option').remove();
        }

        if (tx_none !== null) {
            $('<option>').val('').text(tx_none).appendTo($select);
        }

        $.each(responseJson, function (key, value) {

            if (selected == value[col_idx]) {
                $('<option selected>').val(value[col_idx]).text(value[col_dsc]).appendTo($select);
                $select.change();
            } else {
                $('<option>').val(value[col_idx]).text(value[col_dsc]).appendTo($select);
            }

        });

    });
}

function loadSelectOption(config) {
    // object config example
    // const cnf = {
    //     url: url_site(`api/tipo-servicio/lista`),
    //     input: [
    //         {
    //             id: 'tipo_concepto',
    //             clearOptions: true,
    //             emptyText: 'Seleccione un concepto',
    //             selectedValue: 'favorabilidad'
    //         }
    //     ],
    //     columnKey: 'codigo',
    //     columnDescription: 'descripcion',
    //     responsePath: 'data'
    // }
    $.get({
        url: config.url,
        headers: { 'access-token': getToken() }
    }, function (resp) {
        // console.log(resp);
        for (const input of config.input) {
            let select_input = $('#' + input.id);

            if (input.clearOptions) {
                select_input.find('option').remove();
            }

            if (input.emptyText) {
                $('<option>').val('').text(input.emptyText).appendTo(select_input);
            }

            const data = config.responsePath ? eval(`resp.${config.responsePath}`) : resp;
            for (row of data) {
                if (input.selectedValue == row[config.columnKey]) {
                    $('<option selected>')
                        .val(row[config.columnKey])
                        .text(row[config.columnDescription])
                        .appendTo(select_input);
                    select_input.change();
                } else {
                    $('<option>')
                        .val(row[config.columnKey])
                        .text(row[config.columnDescription])
                        .appendTo(select_input);
                }
            }
        }
    })
}

function cboLoad2(campo = [], url, deleteopt, tx_none, col_idx = 0, col_dsc = 1) {
    let conf = {
        url,
        headers: { 'access-token': getToken() }
    }
    $.get(conf, function (responseJson) {

        for (i = 0; i < campo.length; i++) {
            let select = $('#' + campo[i]);

            if (deleteopt) {
                select.find('option').remove();
            }

            if (tx_none !== null) {
                $('<option>').val('').text(tx_none).appendTo(select);
            }

            $.each(responseJson, function (key, value) {
                $('<option>').val(value[col_idx]).text(value[col_dsc]).appendTo(select);
            });
        }
    })
}

function alertSwalR(v_type, v_title, v_text, v_redirect) {
    Swal.fire({
        icon: v_type,
        title: v_title,
        text: v_text,
        showConfirmButton: true,
        confirmButtonText: "Cerrar"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location = v_redirect;
        }
    });
}

function alertSwal(v_type, v_title, v_text, v_toast = true) {
    if (v_type == 'success') {
        if (v_toast) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: v_type,
                title: v_title,
                text: v_text,
            })
        } else {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: v_title,
                text: v_text,
                showConfirmButton: false,
                timer: 1500
            })
        }
    } else {
        Swal.fire({
            icon: v_type,
            title: v_title,
            text: v_text,
            showConfirmButton: true,
            confirmButtonText: "Cerrar"
        });
    }
}

function recursoDatos(params) {
    $.ajax({
        url: params.pUrl,
        method: ((params.hasOwnProperty("pMethod")) ? params.pMethod : 'GET'),
        data: ((params.hasOwnProperty("pData")) ? params.pData : ''),
        processData: ((params.hasOwnProperty("pProcessData")) ? params.pProcessData : false),
        async: ((params.hasOwnProperty("pAsync")) ? params.pAsync : true),
        dataType: ((params.hasOwnProperty("pDataType")) ? params.pDataType : "json"),
        success: function (respuesta) {
            if (respuesta) {
                return respuesta;
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("textStatus: " + textStatus + " : " + errorThrown);
        }
    });
}


String.prototype.initCap = function () {
    return this.toLowerCase().replace(/(?:^|\s)[a-z]/g, function (m) {
        return m.toUpperCase();
    });
};


function HabilitarInputsForm(formulario, tipo_attr = 'disabled', valor = false) {
    // tipo_attr = disabled | readonly
    var elem = document.getElementById(formulario).elements;
    for (var i = 0; i < elem.length; i++) {
        //console.log (`habilitar: name=${elem[i].name} type=${elem[i].type} value=${elem[i].value}`)
        if (elem[i].name != null && elem[i].name != "" && elem[i].type != "submit")
            $(`#${elem[i].name}`).attr(tipo_attr, valor);
    }

    //fuente: http://pietschsoft.com/post/2006/06/01/JavaScript-Loop-through-all-elements-in-a-form
    /*function DisplayFormValues(){
        var str = '';
        var elem = document.getElementById('frmMain').elements;
        for(var i = 0; i < elem.length; i++)
        {
            str += "<b>Type:</b>" + elem[i].type + "&nbsp&nbsp";
            str += "<b>Name:</b>" + elem[i].name + "&nbsp;&nbsp;";
            str += "<b>Value:</b><i>" + elem[i].value + "</i>&nbsp;&nbsp;";
            str += "<BR>";
        } 
        document.getElementById('lblValues').innerHTML = str;
    }*/
}


function descripcionTamanoArchivo(tamano, nivel = 0) {

    var medida = ["Bytes", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB"];
    var factor = 1024;
    nivel++;

    while (tamano >= factor || nivel <= 1) {
        nivel++;
        tamano = Math.max(tamano / factor, 1);

    }

    return number_format(tamano, 1) + ' ' + medida[nivel - 1];

}


function ocultarColumnaDataTable(tabla, indexCol) {
    if (typeof indexCol == 'number') {
        var column = tabla.column(indexCol);
        column.visible(!column.visible());
    } else if (Array.isArray(indexCol)) {
        indexCol.forEach(function (index) {
            var column = tabla.column(index);
            column.visible(!column.visible());
        });
    }
}

Date.prototype.yyyymmdd = function () {
    var mm = this.getMonth() + 1; // getMonth() is zero-based
    var dd = this.getDate();

    return [this.getFullYear(),
    (mm > 9 ? '' : '0') + mm,
    (dd > 9 ? '' : '0') + dd
    ].join('-');
};


(function ($) {
    var originalVal = $.fn.val;
    $.fn.val = function () {
        var prev;
        if (arguments.length > 0) {
            prev = originalVal.apply(this, []);
        }
        var result = originalVal.apply(this, arguments);
        if (arguments.length > 0 && prev != originalVal.apply(this, []))
            $(this).change(); // OR with custom event $(this).trigger('value-changed')
        return result;
    };
    //Fuente: https://stackoverflow.com/questions/3179385/val-doesnt-trigger-change-in-jquery
})(jQuery);

function current_date() {
    var fecStart = new Date();
    return fecStart;
}

function current_date_array() {
    var fecStart = new Date();
    return [fecStart.getFullYear(), fecStart.getMonth(), fecStart.getDay()];
}

function current_year() {
    var fecStart = new Date();
    return fecStart.getFullYear();
}

function current_month() {
    var fecStart = new Date();
    return fecStart.getMonth() + 1;
}

function current_day() {
    var fecStart = new Date();
    return fecStart.getDay();
}

$(document).ready(function () {
    $('.solo-numero')
        .keyup(function () {
            this.value = (this.value + '').replace(/[^0-9-.]/g, '');
        })
    // .on('blur', function (e) {
    //     $(this).val(number_format($(this).val()))
    // });

    $('.solo-letras').keyup(function () {
        this.value = (this.value + '').replace(/[^a-zA-Z\s]/g, '');
    });

    $('.solo-mayuscula').keyup(function () {
        this.value = this.value.toUpperCase();
    });

    $('.solo-fecha').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        autoUpdateInput: false,
        locale: {
            format: 'YYYY-MM-DD'
        },
    }, function (chosen_date) {
        $(`#${$(this)[0].element[0].id}`).val(chosen_date.format('YYYY-MM-DD'))
    });

    $('.solo-fecha-hora').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        autoUpdateInput: false,
        timePicker: true,
        timePickerIncrement: 1,
        timePicker24Hour: true,
        locale: {
            format: 'YYYY-MM-DD HH:mm',
            "separator": " ... ",
            "daysOfWeek": ["D", "L", "M", "X", "J", "V", "S"]
        },
    }, function (chosen_date) {
        $(`#${$(this)[0].element[0].id}`).val(chosen_date.format('YYYY-MM-DD HH:mm'))
    });
});


function sleep(ms) {
    // fuente: https://stackoverflow.com/questions/951021/what-is-the-javascript-version-of-sleep
    return new Promise(resolve => setTimeout(resolve, ms));
}