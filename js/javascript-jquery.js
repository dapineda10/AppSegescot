/*Variables globales*/
/*Vector para guardar codigo de producto para la cotización*/
var codigoproductorep = new Array();
/*Vector para guardar codigo de producto para despacho*/
var codigodespacho = new Array();
//configuración de Jquery, javascript y ajax
/*A continucación las funciones con sus respectivos comentarios, este js está unido con el resto del proyeto
 por medio de los layout*/

//variables para crear código único en cotizacion
var d;
var codigounico;


var thisAgregar;

//Radio button de contacto para elegir el tipo al que pertenece el contacto
//Danny Pineda
$(document).ready(function () {
    $(".foraneas").hide();
    $(".foraneasmodificar").show();
});
function checkin(valor) {
    $(".foraneas").hide();
    if (valor == 1) {
        $("#cliente2").show();
    } else if (valor == 2) {
        $("#Proveedor2").show();
    }
}
/*Final checkbox de contacto*/

/* Animación del menú Vertical de la pantalla de inicio, menu desplegable,permite esconder el menú que está en el layout, cuando se pasa por encima de él
 entonces aparece de nuevo generando un efecto de transición*/
$(function () {
    $('#navigation a').stop().animate({'marginLeft': '-160px'}, 1000);
    $('#navigation > li').hover(
            function () {
                $('a', $(this)).stop().animate({'marginLeft': '-2px'}, 200);
            },
            function () {
                $('a', $(this)).stop().animate({'marginLeft': '-160px'}, 200);
            }
    );
    //Final de función para menú lateral dinamico

    //Funcion de Jquery para comprobar que checkbox esté seleccionado o no (validación de privacidad de datos)
    $("#btnContinuarPrivacidad").on("click", function () {
        if ($("#checkPrivacidad").is(':checked')) {
            window.location.href = "index.php?";
        } else {
            alert("Debe aceptar terminos y condiciones");
        }
    });
    //Final de jquery para provacidad


    //Esta es la configuración de tabs para pasar entre vistas sin recargar la pagina, utilizado en crear cotizaciones
    function log(message) {
        $("<div>").text(message).prependTo("#log");
        $("#log").scrollTop(0);
    }
    $("#tabs").tabs();
});
//Final de función de tabs

//Funcion para mostrar detalles de tabla con el +
function format(d) {
    return 'Descripción: ' + d.prd_descripcion + '' + '<br>';
}

//Función para realizar la busqueda de los productos en la cotización de manera dinamica
$(document).ready(function () {
    listar();
});
var listar = function () {
    //Cargar todos los datos en #tablacotizaciones
    var table = $('#tablacotizaciones').DataTable({
        "ajax": {
            "method": "POST",
            //Se hace consulta en el controlador de cotización y se recibe como json
            "url": "index.php?controller=Cotizacion&action=buscador2"
        },
        "columns": [
            {
                "class": "details-control",
                "orderable": false,
                "data": null,
                "defaultContent": ""
            },
            {"data": "prd_codigoProducto"},
            {"data": "prd_nombre"},
            {"data": "pro_Nombre"},
            {"data": "prd_costo"},
            {"data": "cat_nombre"},
            {"defaultContent": "<input type='number' id='porcentaje'  class=' porcentaje form-control col-lg-1'>"},
            {"defaultContent": "<button class='btn btn-info agregarPreciosFijos'>Agregar Precios</button>"},
            {"defaultContent": "<input type='hidden' class='form-control precio'>"},
            {"defaultContent": "<input type='number' class='cantidad form-control'>"},
            {"defaultContent": "<button id='agreg' class='btn btn-info agregar'>Agregar</button>"}
        ]
    });

    //Funcion para los detalles con el mas (+)
    // Array to track the ids of the details displayed rows
    var detailRows = [];

    $('#tablacotizaciones tbody').on('click', 'tr td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row(tr);
        var idx = $.inArray(tr.attr('id'), detailRows);

        if (row.child.isShown()) {
            tr.removeClass('details');
            row.child.hide();

            // Remove from the 'open' array
            detailRows.splice(idx, 1);
        } else {
            tr.addClass('details');
            row.child(format(row.data())).show();

            // Add to the 'open' array
            if (idx === -1) {
                detailRows.push(tr.attr('id'));
            }
        }
    });

    // On each draw, loop over the `detailRows` array and show any child rows
    table.on('draw', function () {
        $.each(detailRows, function (i, id) {
            $('#' + id + ' td.details-control').trigger('click');
        });
    });

    $obtener_data_adicionar("#tablacotizaciones tbody", table)
    // Setup - add a text input to each footer cell
    $('#tablacotizaciones tfoot th').each(function () {
        var title = $(this).text();
        $(this).html('<input type="text" style="width: 125px;text-align: center" placeholder="' + title + '" />');
    });



    $("#btnagregarcoti").click(function () {
        $agregarNuevamenteProducto(table);
    });



    // DataTable
    var table = $('#tablacotizaciones').DataTable();

    // Apply the search
    table.columns().every(function () {
        var that = this;

        $('input', this.footer()).on('keyup change', function () {
            if (that.search() !== this.value) {
                that
                        .search(this.value)
                        .draw();
            }
        });
    });
}
//Agregar de nuevo un producto ya existente dentro de la cotizacion
$agregarNuevamenteProducto = function () {
    var table = $('#tablacotizaciones').DataTable();
    //Agregar la linea en la tabla de productos cotizados
    //La primera linea toma el nombre del producto y lo agrega, la segunda el porcentaje,
    //la tercera la operacion del precio, la cuarta la cantidad y la quinta declara el precio como false
    var data = table.row($(thisAgregar).parents("tr")).data();
    var porcentaje = $(thisAgregar).parent().prev().prev().prev().prev().children('input.porcentaje').val();
    var sumarprecio = (data.prd_costo / porcentaje);
    var cant = $(thisAgregar).parent().prev().children('input.cantidad').val();
    var esPrecioFijo = false;

    // En caso de que haya seleccionado la opción de precios fijos, el preciototal será el seleccionado 
    // sino se tendrá en cuenta el porcentaje de ganancia + costo producto
    //Si el .length es mayor a uno entonces entra a la condición
    if ($(thisAgregar).parent().prev().prev().prev().children('select').length == 1) {
        //Si selecciona la opcion de precios fijos pero no selecciona ningún precio entonces aparece el mensaje "Debe seleccionar un precio de la lista"
        if ($(thisAgregar).parent().prev().prev().prev().children('select').val() == "") {
            alert("Debe seleccionar un precio de la lista");
        } else {
            //Si selecciona un precio de la lista entonces el precio fijo es true
            var preciototal = parseInt($(thisAgregar).parent().prev().prev().prev().children('select').val());
            esPrecioFijo = true;
        }
    } else {
        ////Si el .length no es mayor a uno entonces entra a la siguiente condición
        var preciototal = Math.round(parseFloat(sumarprecio));
    }

    //La variable nuevoparametro contiene el codigo que se recibe en ese momento
    nuevoparametro = data.prd_codigoProducto;
    //console.log(data);
    /*La variable valor contenido es un booleano que se usa en la condición dentro del for, si es true quiere 
     decir que está contenido pero si es false no está contenido*/
    valorcontenido = false;
    //Se hace el ciclo que recorre el vector
    for (x = 0; x < codigoproductorep.length; x++) {
        //Se hace la condición que compara el vector (codigoproductorep) con el valor que llega (nuevoparametro)
        if (codigoproductorep[x] == nuevoparametro) {
            //Si código el valor contenido está dentro del vector entonces la condición pasa a ser true
            valorcontenido = true;
        }
    }

    /*Si el valorcontenido es igual a true entonces entra a la condición
     y permite agregar datos en la tabla de cotizaciones*/
    if (valorcontenido == true) {
        //Si los input de cantidad y porcentaje no están vacíos entonces entra a la condición
        if (cant != '' && (esPrecioFijo || porcentaje != '')) {
            d = new Date();
            codigounico = d.getFullYear() + "" + d.getMonth() + "" + d.getDate() + "" + d.getHours() + "" + d.getMinutes() + "" + d.getSeconds();
            codigoproductorep.push(data.prd_codigoProducto);
            //Si se necesita ver lo que imprime la consola se descomenta la siguiente función
            //console.log(data);
            $('#cotizadorfinal').append
                    ("<tr><td style='border: 1px solid black;text-align: center'>" + data.prd_nombre + "</td>,\n\
                      <td style='border: 1px solid black;text-align: center'>" + "$" + preciototal + "</td>,\n\
                      <td style='border: 1px solid black;text-align: center'>" + data.prd_tipoPresentacion + "</td>,\n\
                      <td style='border: 1px solid black;text-align: center'>" + cant + "</td>\\n\
                      <td style='border: 1px solid black;text-align: center'>" + data.prd_iva + "%" + "</td>\
                      <td style='border: 1px solid black;text-align: center'>" + "<button class='btn btn-info quitarproducto' id='" + codigounico + "'>Quitar</button>" + "</td>,\n\ ");
            $("button.quitarproducto").click(function () {
                $(this).closest('tr').remove();
                $eliminarproductocotizacion($(this).attr("id"));
            });
            $.ajax({
                method: "POST",
                url: "index.php?controller=Cotizacion&action=agregarproducto",
                //Se agregan los datos en la base de datos
                data: {prd_CodigoProducto: data.prd_codigoProducto,
                    cot_precioVenta: preciototal, cot_cantdad: cant, prd_codigo: codigounico}
            })
                    .done(function (msg) {

                    });
            //Borrar todos los cajetines cuando le de click al botón agregar
            alert('Producto agregado');
            $(":text").each(function () {
                $($(thisAgregar)).val('');
            });
            //Fin
        } else {
            alert("debe llenar todos los campos");
        }
    }
}
$obtener_data_adicionar = function (tbody, table) {
    // Funcion para agregar precios dinamicos
    $(tbody).on("click", "button.agregarPreciosFijos", function () {
        var optionsSelect = "";
        var data = table.row($(this).parents("tr")).data();
        var codigoProducto = data.prd_codigoProducto;
        var objButton = $(this); // Representa todo el botón agregar Precio Fijo
        // Se llama por AJAX al método que traerá los precios dado el código de un producto
        $.ajax({
            method: "POST",
            url: "index.php?controller=Cotizacion&action=consultarPreciosFijos",
            data: {prd_CodigoProducto: codigoProducto}
        }).done(function (resp) {
            //            console.log("CodigoProducto> "+codigoProducto);
            var data = JSON.parse(resp);
            if (data.length > 0) {
                for (i in data) {
                    optionsSelect += "<option value='" + data[i].prd_costo + "'>" + data[i].prd_costo + "</option>";
                }
                // Se crea una variable para guardar el HTML que se va incorporar con el SELECT con los precios fijos
                var htmlSelect = "<select class='preciosFijos form-control col-lg-1'><option value=''>Seleccione precio</option>" + optionsSelect + "</select>";

                // Si no existe la lista desplegable de precios fijos, se crea el respectivo SELECT
                if (!objButton.parent().children('select').length == 1) {
                    objButton.parent().append("<button class='btn btn-warning eliminarPreciosFijos'>Eliminar Precios</button>");
                    objButton.parent().append(htmlSelect);
                    objButton.hide();
                    objButton.parent().prev().children('.porcentaje').attr('disabled', 'disabled');
                    objButton.parent().prev().children('.porcentaje').val('');
                }
            } else {
                alert("Este producto no tiene precios fijos");
            }
        });
    });
    // FIN Funcion para agregar precios dinamicos

    // Funcion para eliminar precios dinamicos
    $(tbody).on("click", "button.eliminarPreciosFijos", function () {
        $(this).hide();
        $(this).parent().children('button.agregarPreciosFijos').show();
        $(this).parent().children('select').remove();
        $(this).parent().prev().children('.porcentaje').removeAttr('disabled');
    });
    // FIN Funcion para eliminar precios dinamicos

    $(tbody).on("click", "button.agregar", function () {
        /*La variable data toma el código de la cotización*/
        var data = table.row($(this).parents("tr")).data();
        var porcentaje = $(this).parent().prev().prev().prev().prev().children('input.porcentaje').val();
        var sumarprecio = (data.prd_costo / porcentaje);
        var cant = $(this).parent().prev().children('input.cantidad').val();
        var esPrecioFijo = false;

        // En caso de que haya seleccionado la opción de precios fijos, el preciototal será el seleccionado 
        // sino se tendrá en cuenta el porcentaje de ganancia + costo producto
        if ($(this).parent().prev().prev().prev().children('select').length == 1) {
            if ($(this).parent().prev().prev().prev().children('select').val() == "") {
                alert("Debe seleccionar un precio de la lista");
            } else {
                var preciototal = parseInt($(this).parent().prev().prev().prev().children('select').val());
                esPrecioFijo = true;
            }
        } else {
            var preciototal = Math.round(parseFloat(sumarprecio));
        }

        //La variable nuevo para metro contiene el codigo que se recibe en ese momento
        nuevoparametro = data.prd_codigoProducto;
        /*La variable valor contenido es un booleano que se usa en la condición dentro del for, si es true quiere 
         decir que está contenido pero si es false no está contenido*/
        valorcontenido = false;
        //Se hace el ciclo que recorre el vector
        for (x = 0; x < codigoproductorep.length; x++) {
            //Se hace la condición que compara el vector (codigoproductorep) con el valor que llega (nuevoparametro)
            if (codigoproductorep[x] == nuevoparametro) {
                valorcontenido = true;
            }
        }

        /*Si el valorcontenido es igual a false entonces entra a la condición
         y permite agregar datos en la tabla de cotizaciones*/
        if (valorcontenido == false) {

            if (cant != '' && (esPrecioFijo || porcentaje != '')) {
                d = new Date();
                codigounico = d.getFullYear() + "" + d.getMonth() + "" + d.getDate() + "" + d.getHours() + "" + d.getMinutes() + "" + d.getSeconds();
                codigoproductorep.push(data.prd_codigoProducto);
                //Si se necesita ver lo que imprime la consola se descomenta la siguiente función
                //console.log(data);
                $('#cotizadorfinal').append
                        ("<tr><td style='border: 1px solid black;text-align: center'>" + data.prd_nombre + "</td>,\n\
                      <td style='border: 1px solid black;text-align: center'>" + "$" + preciototal + "</td>,\n\
                      <td style='border: 1px solid black;text-align: center'>" + data.prd_tipoPresentacion + "</td>,\n\
                      <td style='border: 1px solid black;text-align: center'>" + cant + "</td>\\n\
                      <td style='border: 1px solid black;text-align: center'>" + data.prd_iva + "%" + "</td>\
                      <td style='border: 1px solid black;text-align: center'>" + "<button class=' btn btn-info quitarproducto' id='" + codigounico + "'>Quitar</button>" + "</td>,\n\ ");
                $("button.quitarproducto").click(function () {
                    $(this).closest('tr').remove();
                    $eliminarproductocotizacion($(this).attr("id"));
                });
                $.ajax({
                    method: "POST",
                    url: "index.php?controller=Cotizacion&action=agregarproducto",
                    //Se agregan los datos en la base de datos
                    data: {prd_CodigoProducto: data.prd_codigoProducto,
                        cot_precioVenta: preciototal, cot_cantdad: cant, prd_codigo: codigounico}
                })
                        .done(function (msg) {

                        });
                //Borrar todos los cajetines cuando le de click al botón agregar
                alert('Producto agregado');
                $(":text").each(function () {
                    $($(this)).val('');
                });
                //Fin
            } else {
                alert("debe llenar todos los campos");
            }
        } else {
            //Mostrar Modal de cotizaciones agregar producto
            thisAgregar = this;

            $("#ModalAceptarAggPro").modal('show');
            //Esta función se llama al oprimir el botón btnagregarcoti que está en la vista de crear cotización, se usa
            //cuándo el producto ya existe en la cotizacion

        }
    });
}
//Final de función de datatable para busqueda de productos.



//cargar cotización que ya existe
$(document).ready(function (e) {
    $("#cargarcotizacion").click(function () {
        var mostrar = $("#codigocotizacioncargar").val();
        $.ajax({
            method: "POST",
            url: "index.php?controller=Cotizacion&action=buscarcotizacion",
            //Se agregan los datos en la base de datos
            data: {cot_codigoCotizacion: mostrar}
        })

                .done(function (msg) {

                    var datos = JSON.parse(msg);
                    var haydatos = false;

                    for (i in datos) {
                        //Se hace la condición que compara el vector (codigoproductorep) con el valor que llega (nuevoparametro)
                        if (datos[i].cot_codigoCotizacion == mostrar) {
                            haydatos = true;
                        }
                    }
                    if (haydatos == true) {
                        alert("Se ha cargado la cotizacion" + mostrar);
                        codigoproductorep = new Array();
                        //Quitar los row de la tabla sin quitar el header
                        $("#cotizadorfinal").find("tr:gt(0)").remove();

                        for (i in datos) {
                            codigoproductorep.push(datos[i].prd_CodigoProducto);
                            if (codigoproductorep != '') {
                                var nuevafila = "\
                               <tr border><td style='border: 1px solid black;text-align: center'>" + datos[i].prd_nombre + "</td>,\n\
                                    <td style='border: 1px solid black;text-align: center'>" + "$" + datos[i].cot_precioVenta + "</td>,\n\
                                    <td style='border: 1px solid black;text-align: center'>" + datos[i].prd_tipoPresentacion + "</td>,\n\
                                    <td style='border: 1px solid black;text-align: center'>" + datos[i].cot_cantdad + "</td>\
                                    <td style='border: 1px solid black;text-align: center'>" + datos[i].prd_iva + "%" + "</td>,\n\
                                    \n\<td style='border: 1px solid black;text-align: center'>" + "<button class='btn btn-info quitarproducto' id='" + datos[i].prd_codigo + "'>Quitar</button>" + "</td>,\n\ ";
                                $("#cotizadorfinal").append(nuevafila);
                                $("button.quitarproducto").click(function () {
                                    $(this).closest('tr').remove();
                                    $eliminarproductocotizacion($(this).attr("id"));
                                });

                            } else {
                                alert("El codigo de cotización " + mostrar + " no tiene productos asociados,click en aceptar para continuar");
                            }
                        }
                        //Limpiar campo de codigo cotización despues de cargar la cotización
                        $("#codigocotizacioncargar").each(function () {
                            $($(this)).val('');
                        });
                    } else {
                        alert("la cotización no existe");
                    }
                });
    });
});
$eliminarproductocotizacion = function (idunico)
{
    $.ajax({
        method: "POST",
        url: "index.php?controller=Cotizacion&action=eliminarproducto",
        //Se agregan los datos en la base de datos
        data: {prd_codigo: idunico}
    });
};


//Modal que abre el formulario de crear de SERVICIO AL CLIENTE
/*Esta función es de ajax y realiza crea un servucio en base de datos por medio de la accioón
 */
$(document).ready(function (e) {
    $('#myModalServicio').on('show.bs.modal', function (e) {
        var id = $(e.relatedTarget).data().id;
        $(e.currentTarget).find('#ser_ticket').val(id);
        $.ajax({
            method: "POST",
            url: "index.php?controller=Serviciocliente&action=mostrardatoservicio",
            data: {id: id}
        })
                .done(function (msg) {
                    var json = JSON.parse(msg);
                    $(e.currentTarget).find('#ser_ticket').val(json.ser_ticket);
                    $(e.currentTarget).find('#ser_fechaInicial').val(json.ser_fechaInicial);
                    $(e.currentTarget).find('#cli_documento').val(json.cli_documento);
                    $(e.currentTarget).find('#ser_estado').val(json.ser_estado);
                    $(e.currentTarget).find('#ser_tipoSoporte').val(json.ser_tipoSoporte);
                    $(e.currentTarget).find('#ser_descripcion').val(json.ser_descripcion);
                    $(e.currentTarget).find('#ser_fechaFin').val(json.ser_fechaFin);

                    // alert( "Data Saved: " + msg );
                    //alert( "cli_paginaWeb: " + json.cli_paginaWeb );
                });
    });

    //Función para mostrar en modo acordeon los tickets en el servicio al cliente del administrador
    $(".accordion-titulo").click(function () {

        var contenido = $(this).next(".accordion-content");

        if (contenido.css("display") == "none") { //open		
            contenido.slideDown(250);
            $(this).addClass("open");
        } else { //close		
            contenido.slideUp(250);
            $(this).removeClass("open");
        }
    });
});

//Modal que abre el formulario de seguimiento de COTIZACION
/*Esta función es de ajax y realiza una consulta en base de datos por medio de la accioón
 mostrardatos, esta información es asignada al formulario por medio de los nombres unidos con #
 y al final con el nombre del campo en basen de datos*/
$(document).ready(function (e) {
    $('#Modalseguimientocotizacion').on('show.bs.modal', function (e) {
        var id = $(e.relatedTarget).data().id;
        $(e.currentTarget).find('#cot_codigoCotizacion').val(id);
        $.ajax({
            method: "POST",
            url: "index.php?controller=Cotizacion&action=mostrardatos",
            data: {id: id}
        })
                .done(function (msg) {
                    var json = JSON.parse(msg);
                    $(e.currentTarget).find('#cot_codigoCotizacion').val(json.cot_codigoCotizacion);
                });
    });
});
//Final de modal de editar Cotizacion

$(document).ready(function (e) {
    /*Inicia librearia autocomplete*/
    //inicia autocomplete de cotizaciones en contacto
    var options = {
        url: "index.php?controller=Cotizacion&action=buscarcontacto",
        getValue: function (element) {
            if (element.pro_Nombre == null) {
                return element.con_nombreCompleto + " - " + element.cli_nombre;
            } else if (element.cli_nombre == null) {
                return element.con_nombreCompleto + " - " + element.pro_Nombre;
            }
        },
        list: {
            match: {
                enabled: true
            },
            onSelectItemEvent: function () {
                var selectedItemValue = $("#inputOne").getSelectedItemData().con_codigo;

                $("#input2").val(selectedItemValue).trigger("change");
                $("#input3").val(selectedItemValue).trigger("change");
            },
        }
    };
    $("#inputOne").easyAutocomplete(options);
    // Finaliza autocomplete de cotizaciones en contacto

    //inicia autocomplete
    var options = {
        url: "index.php?controller=despacho&action=buscarcliente",
        getValue: "cli_documento",
        template: {
            type: "description",
            fields: {
                description: "cli_nombre"
            }
        },
        list: {
            match: {
                enabled: true
            }
        },
        theme: "plate-dark"
    };

    $("#clienteeasy").easyAutocomplete(options);

    //inicia autocomplete
    var options = {
        url: "index.php?controller=despacho&action=buscarusuario",
        getValue: "usu_documento",
        template: {
            type: "description",
            fields: {
                description: "usu_nombre"
            }
        },
        list: {
            match: {
                enabled: true
            }
        },
        theme: "plate-dark"
    };

    $("#usuarioeasy").easyAutocomplete(options);

    //Cliente autocompletar

    var optionsCliente = {
        url: "index.php?controller=Cliente&action=buscarcliente",
        getValue: function (element) {
            return element.cli_nombre + " - " + element.cli_documento;
        },
        list: {
            match: {
                enabled: true
            },
            onSelectItemEvent: function () {
                var selectedItemValue = $("#cmbCliente").getSelectedItemData().cli_documento;

                $("#cmbClienteSel").val(selectedItemValue).trigger("change");

            },
        }
    };

    $("#cmbCliente").easyAutocomplete(optionsCliente);



    //Proveedor autocompletar

    var optionsProveedor = {
        url: "index.php?controller=Proveedor&action=buscarproveedor",
        getValue: function (element) {
            return element.pro_nit + " - " + element.pro_Nombre;
        },
        list: {
            match: {
                enabled: true
            },
            onSelectItemEvent: function () {
                var selectedItemValue = $("#cmbProveedor").getSelectedItemData().pro_nit;

                $("#cmbProveedorSel").val(selectedItemValue).trigger("change");

            },
        }
    };

    $("#cmbProveedor").easyAutocomplete(optionsProveedor);

});
//Final de modal de editar Cotizacion

/*finaliza librearia autocomplete*/

// Crear precios dinámicos en la creación de productos
var iCnt = 1; // Limite de precios
var divSubmit = $(document.createElement('div'));
var isEdit = false;
$(document).ready(function () {
    $('#btAdd').click(function () {
        if (iCnt <= 9) {
            iCnt = iCnt + 1;
            // Añadir caja de texto.
            $('#precios_container').append('<input type=text class="input precios allprecios form-control" id=precio' + iCnt + ' ' +
                    'placeholder="Precio ' + iCnt + '" />');
            $('#main_precio').after($('#precios_container'), divSubmit);
            if (iCnt > 1) {
                $('#btRemove').removeAttr('disabled');
                $('#btRemove').attr('class', 'btn-warning');
                $('#btRemoveAll').removeAttr('disabled');
                $('#btRemoveAll').attr('class', 'btn-warning');
            }
        } else { //se establece un limite para añadir elementos, 20 es el limite
            $('#precios_container').append('<label>Limite Alcanzado</label>');
            $('#btAdd').attr('class', 'bt-disable');
            $('#btAdd').attr('disabled', 'disabled');
        }
    });

    $('#btRemove').click(function () { // Elimina un elemento por click
        if (iCnt != 1) {
            $('#precio' + iCnt).remove();
            iCnt = iCnt - 1;
        }
        if (iCnt == 1) {
            $('#btRemove').attr('class', 'bt-disable');
            $('#btRemove').attr('disabled', 'disabled');
            $('#btRemoveAll').attr('class', 'bt-disable');
            $('#btRemoveAll').attr('disabled', 'disabled');
        }
        if (iCnt <= 9) {
            $('#btAdd').removeAttr('disabled');
            $('#btAdd').attr('class', 'bt btn-success');
            $('#precios_container > label').remove();
        }
    });

    $('#btRemoveAll').click(function () { // Elimina todos los elementos del contenedor
        //$('#precios_container > allprecios').empty();
        removeAllPrecios();
    });
});

// Obtiene los valores de los textbox al dar click en el boton "Enviar"
var values = '';
function GetTextValue() {
    $('.input').each(function () {
        if (this.value != "") {
            values += $.trim(this.value) + ','
        }
    });
    finalValues = values.substring(0, values.length - 1);
    $("#prdPrecios").val(finalValues);
}

function removeAllPrecios() {
    $('.allprecios').remove();
    if (isEdit) {
        iCnt = 0;
    } else {
        iCnt = 1;
    }
    $('#btAdd').removeAttr('disabled');
    $('#btAdd').attr('class', 'bt btn-success');
    $('#btRemove').attr('class', 'bt-disable');
    $('#btRemove').attr('disabled', 'disabled');
    $('#btRemoveAll').attr('class', 'bt-disable');
    $('#btRemoveAll').attr('disabled', 'disabled');
    $('#precios_container > label').remove();
}

// FIN Crear precios dinámicos en la creación de productos

$(document).ready(function () {
    //Cotizacion, realizar consulta ajax para mostrar datos dinamicamente en la tabla
    listar1();
});

//tabla dinamica de producto
var listar1 = function () {
    var table = $('#tablaproducto').DataTable({
        "ajax": {
            "method": "POST",
            "url": "index.php?controller=Cotizacion&action=buscador2"
        },
        "columns": [
            {"data": "prd_codigoProducto"},
            {"data": "cat_idCategoria"},
            {"data": "prd_nombre"},
            {"data": "pro_Nombre"},
            {"defaultContent": "<button id='editarproducto' class='btn btn-info editarproducto'>Editar</button>"},
            {"defaultContent": "<button id='eliminarproducto' class='btn btn-danger eliminarproducto'>Eliminar</button>"}
        ]
    });
    $obtener_data_adicionar1("#tablaproducto tbody", table)
    // Setup - add a text input to each footer cell
    $('#tablaproducto tfoot th').each(function () {
        var title = $(this).text();
        $(this).html('<input type="text" style="width: 135px;text-align: center" placeholder="' + title + '" />');
    });

    // DataTable
    var table = $('#tablaproducto').DataTable();

    // Apply the search
    table.columns().every(function () {
        var that = this;

        $('input', this.footer()).on('keyup change', function () {
            if (that.search() !== this.value) {
                that
                        .search(this.value)
                        .draw();
            }
        });
    });

}

$obtener_data_adicionar1 = function (tbody, table) {
    $(tbody).on("click", "button.editarproducto", function () {
        var data = table.row($(this).parents("tr")).data();
        $(document).ready(function () {
            $("#myModalProducto").modal('show');
            $("#prd_codigoProducto").val(data.prd_codigoProducto);
            $("#prd_codigoProducto1").val(data.prd_codigoProducto);
            $("#cat_idCategoria").val(data.cat_idCategoria);
            $("#Proveedorproducto").val(data.pro_Nombre);
            $("#Proveedorproducto1").val(data.pro_nit);
            $("#prd_tipoDivisa").val(data.prd_tipoDivisa);
            $("#prd_costo").val(data.prd_costo);
            $("#prd_tipoPresentacion").val(data.prd_tipoPresentacion);
            $("#prd_nombre").val(data.prd_nombre);
            $("#prd_descripcion").val(data.prd_descripcion);
            $("#prd_foto").attr("src", data.prd_foto);
            $("#prd_foto").css("width", "350px");
            $("#prd_loteSerial").val(data.prd_loteSerial);
            $("#prd_fechaVencimiento").val(data.prd_fechaVencimiento);
            $("#prd_cantidadPresentacion").val(data.prd_cantidadPresentacion);
            $("#prd_iva").val(data.prd_iva);

            // Traer precios fijos del producto a traves de un llamado AJAX
            isEdit = true;
            $.ajax({
                method: "GET",
                url: "index.php?controller=Producto&action=getProductoPrecio",
                data: {id: data.prd_codigoProducto}
            })
                    .done(function (dataP) {
                        var json = JSON.parse(dataP);
                        removeAllPrecios(); // se remueven todos los precios anteriores
                        iCnt = 1;
                        // Se recorre el vector para colocar todos los precios traidos de la base de datos
                        $.each(json, function (key, value) {
                            $('#precios_container').append('<input type=text class="input precios allprecios form-control" id=precio' + iCnt + ' ' +
                                    'placeholder="Precio ' + iCnt + '" value="' + value.prd_costo + '" />');
                            $('#main_precio').after($('#precios_container'), divSubmit);
                            iCnt++;
                        });
                        iCnt--;
                        // Si existe algún precio se organizan los botones de Añadir y Eliminar el precio
                        if (iCnt >= 1) {
                            $('#btRemove').removeAttr('disabled');
                            $('#btRemove').attr('class', 'btn-warning');
                            $('#btRemoveAll').removeAttr('disabled');
                            $('#btRemoveAll').attr('class', 'btn-warning');
                        } else {
                            if (iCnt == 0)
                                iCnt++;
                            $('#precios_container').append('<input type=text class="input precios allprecios form-control" id=precio' + iCnt + ' ' +
                                    'placeholder="Precio ' + iCnt + '" />');
                            $('#main_precio').after($('#precios_container'), divSubmit);
                        }
                    });
        });
    });
    $(tbody).on("click", "button.eliminarproducto", function () {
        var data = table.row($(this).parents("tr")).data();
        $(document).ready(function () {
            $("#ModalborrarProducto").modal('show');
            $("#input_delete_producto").val(data.prd_codigoProducto);
        });
    });
};

//Eliminar producto con mensaje de confirmación
$(document).ready(function (e) {
    $("#btneliminar2").click(function () {
        var id = $("#input_delete_producto").val();
        $.ajax({
            method: "GET",
            url: "index.php?controller=Producto&action=borrar",
            data: {id: id}
        })
                .done(function (msg) {
                    var json = JSON.parse(msg);
                    alert(json.Mensaje);
                    location.reload();
                    //                    $(e.currentTarget).find('#input_delete_producto').val(json.Mensaje);
                    //                    alert(e.currentTarget);
                });
    });
});
//Termina modal de eliminar producto

$(document).ready(function () {
    //Cotizacion, realizar consulta ajax para mostrar datos dinamicamente en la tabla
    listar2();
});
//tabla dinamica de cliente
var listar2 = function () {
    var table = $('#tablacliente').DataTable({
        "ajax": {
            "method": "POST",
            "url": "index.php?controller=Cliente&action=mostrardatos",
        },
        "columns": [
            {"data": "cli_documento"},
            {"data": "cli_nombre"},
            {"data": "cli_direccion"},
            {"data": "cli_email"},
            {"data": "cli_zonaCliente"},
            {"defaultContent": "<button id='editarclieente' class='btn btn-info editarclieente'>Editar</button>"},
            {"defaultContent": "<button id='eliminarcliente' class='btn btn-danger eliminarcliente'>Eliminar</button>"}
        ]
    });
    $obtener_data_adicionar2("#tablacliente tbody", table)

}
$obtener_data_adicionar2 = function (tbody, table) {
    $(tbody).on("click", "button.editarclieente", function () {
        var data = table.row($(this).parents("tr")).data();
        $(document).ready(function () {
            $("#myModal").modal('show');
            $("#codigo1").val(data.cli_documento);
            $("#codigo").val(data.cli_documento);
            $("#nombre").val(data.cli_nombre);
            $("#paginaweb").val(data.cli_paginaWeb);
            $("#direccion").val(data.cli_direccion);
            $("#email").val(data.cli_email);
            $("#zonacliente").val(data.cli_zonaCliente);
            $("#ciudad").val(data.cli_ciudad);
            $("#pais").val(data.cli_pais);
            $("#paginaweb").val(data.cli_paginaWeb);
            $("#telefono").val(data.cli_telefono);
            $("#password").val(data.cli_password);
        });
    });
    $(tbody).on("click", "button.eliminarcliente", function () {
        var data = table.row($(this).parents("tr")).data();
        $(document).ready(function () {
            $("#Modalborrarcliente").modal('show');
            $("#input_delete").val(data.cli_documento);
        });
    });
};

//Eliminar producto con mensaje de confirmación
$(document).ready(function (e) {
    $("#btneliminar").click(function () {
        var id = $("#input_delete").val();
        $.ajax({
            method: "GET",
            url: "index.php?controller=Cliente&action=borrar",
            data: {id: id}
        })
                .done(function (msg) {
                    var json = JSON.parse(msg);
                    alert(json.Mensaje);
                    location.reload();
                    //                    $(e.currentTarget).find('#input_delete_producto').val(json.Mensaje);
                    //                    alert(e.currentTarget);
                });
    });
});
//Termina modal de eliminar producto




//Modal que abre el formulario de editar de despacho
/*Esta función es de ajax y realiza una consulta en base de datos por medio de la accioón
 mostrardatosdespacho, esta información es asignada al formulario por medio de los nombres unidos con #
 y al final con el nombre del campo en basen de datos*/
$(document).ready(function () {
    //Cotizacion, realizar consulta ajax para mostrar datos dinamicamente en la tabla
    listar3();
});

//tabla dinamica de despacho
var listar3 = function () {
    var table = $('#tabladespacho').DataTable({
        "ajax": {
            "method": "POST",
            "url": "index.php?controller=Despacho&action=buscartodoslosdespachos",
        },
        "columns": [
            {"data": "des_CodigoDespacho"},
            {"data": "des_Contrato_Oc"},
            {"data": "des_Numfactura"},
            {"data": "cli_documento"},
            {"data": "des_ObservacionesEnvio"},
            {"defaultContent": "<button id='editardespacho' class='btn btn-info editardespacho'>Editar</button>"},
            {"defaultContent": "<button id='eliminardespacho' class='btn btn-danger eliminardespacho'>Eliminar</button>"}
        ]
    });
    $obtener_data_adicionar3("#tabladespacho tbody", table)

}
$obtener_data_adicionar3 = function (tbody, table) {
    $(tbody).on("click", "button.editardespacho", function () {
        var data = table.row($(this).parents("tr")).data();
        $(document).ready(function () {
            $("#ModalDespacho").modal('show');
            $("#codigodespacho").val(data.des_CodigoDespacho);
            $("#codigodespacho1").val(data.des_CodigoDespacho);
            $("#fechaenvio").val(data.des_FechaEnvio);
            $("#transportadora").val(data.des_Transportadora);
            $("#ObservacionesEnvio").val(data.des_ObservacionesEnvio);
            $("#contrato").val(data.des_Contrato_Oc);
            $("#NumeroGuia").val(data.des_NumeroGuia);
            $("#CantidadCajas").val(data.des_CantidadCajas);
            $("#Numfactura").val(data.des_Numfactura);
            $("#clienteeasy").val(data.cli_documento);
            $("#usuarioeasy").val(data.usu_documento);
        });
    });
    $(tbody).on("click", "button.eliminardespacho", function () {
        var data = table.row($(this).parents("tr")).data();
        $(document).ready(function () {
            $("#ModalborrarDespachop").modal('show');
            $("#input_delete2").val(data.des_CodigoDespacho);
        });
    });
};

//Modal con notificación para eliminar un despacho
$(document).ready(function (e) {
    $("#btneliminar5").click(function () {
        var id = $("#input_delete2").val();
        $.ajax({
            method: "GET",
            url: "index.php?controller=Despacho&action=borrar",
            data: {id: id}
        })
                .done(function (msg) {
                    var json = JSON.parse(msg);
                    alert(json.Mensaje);
                    location.reload();
                    //                    $(e.currentTarget).find('#input_delete_producto').val(json.Mensaje);
                    //                    alert(e.currentTarget);
                });
    });
});
//Termina modal de Eliminar despacho





//cotización
$(document).ready(function () {
    //Cotizacion, realizar consulta ajax para mostrar datos dinamicamente en la tabla
    listar4();
    listar5();
    listar6();
    listar7();
    listar8();
    listar9();
    listar10();
    listar11();
});

//tabla dinamica de cotizaciones
var listar4 = function () {
    var table = $('#tablacotizaciones1').DataTable({
        "ajax": {
            "method": "POST",
            "url": "index.php?controller=Cotizacion&action=mostrardatoscotizacionvendida",
        },
        "columns": [
            {"data": "cot_codigoCotizacion"},
            {"data": "cot_lugarEntrega"},
            {"data": "con_nombreCompleto"},
            {"data": "cot_fechaCotizacion"},
            {"data": "cot_estadoventa"},
            {"defaultContent": "<button id='editarcot' class='btn btn-info editarcot'>Editar</button>"},
            {"defaultContent": "<button id='eliminarcot' class='btn btn-danger eliminarcot'>Eliminar</button>"},
            {"defaultContent": "<button id='crearseg' class='btn btn-primary crearseg'>Seguimiento</button>"},
        ]
    });
    $obtener_data_adicionar4("#tablacotizaciones1 tbody", table)

}
$obtener_data_adicionar4 = function (tbody, table) {
    $(tbody).on("click", "button.editarcot", function () {
        var data = table.row($(this).parents("tr")).data();
        $(document).ready(function () {
            $("#myModalCotizacion").modal('show');
            $("#cot_codigoCotizacion1").val(data.cot_codigoCotizacion);
            $("#cot_codigoCotizacion").val(data.cot_codigoCotizacion);
            $("#inputcontactoeditar").val(data.con_nombreCompleto);
            $("#inputcontactoeditar3").val(data.con_codigo);
            $("#inputcontactoeditar2").val(data.con_codigo);
            $("#cot_validez").val(data.cot_validez);
            $("#cot_tiempoEntrega").val(data.cot_tiempoEntrega);
            $("#cot_lugarEntrega").val(data.cot_lugarEntrega);
            $("#cot_formaPago").val(data.cot_formaPago);
            $("#cot_fechaCotizacion1").val(data.cot_fechaCotizacion);
            $("#cot_estadoventaselect").val(data.cot_estadoventa);
        });
    });
    $(tbody).on("click", "button.crearseg", function () {
        var data = table.row($(this).parents("tr")).data();
        $(document).ready(function () {
            $("#Modalseguimiento1").modal('show');
            $("#cot_codigoCotizacionseguimiento").val(data.cot_codigoCotizacion);
            $("#cot_codigoCotizacionseguimiento1").val(data.cot_codigoCotizacion);
        });
    });


    $(tbody).on("click", "button.eliminarcot", function () {
        var data = table.row($(this).parents("tr")).data();
        $(document).ready(function () {
            $("#Modalborrarcotizacion").modal('show');
            $("#input_delete_cotizacion").val(data.cot_codigoCotizacion);
        });
    });
};

//Modal con notificación para eliminar una cotizacion
$(document).ready(function (e) {
    $("#btneliminarContizacion").click(function () {
        var id = $("#input_delete_cotizacion").val();
        $.ajax({
            method: "GET",
            url: "index.php?controller=Cotizacion&action=borrar",
            data: {id: id}
        })
                .done(function (msg) {
                    var json = JSON.parse(msg);
                    alert(json.Mensaje);
                    location.reload();
                    //                    $(e.currentTarget).find('#input_delete_producto').val(json.Mensaje);
                    //                    alert(e.currentTarget);
                });
    });
});
//Termina modal de Eliminar cotizacion

//tabla dinamica de cliente potencial
var listar8 = function () {
    var table = $('#tablaclientepotencial').DataTable({
        "ajax": {
            "method": "POST",
            "url": "index.php?controller=cliente&action=mostrardatoscp",
        },
        "columns": [
            {"data": "cli_documento"},
            {"data": "cli_nombre"},
            {"data": "cli_ciudad"},
            {"data": "cli_telefono"},
            {"defaultContent": "<button id='editarcp' class='btn btn-info editarcp'>Editar</button>"},
            {"defaultContent": "<button id='eliminarcp' class='btn btn-danger eliminarcp'>Eliminar</button>"},
            {"defaultContent": "<button style='align: center' id='pasarcliente' class='btn btn-dark pasarcliente'>Pasar a cliente</button>"}
        ]
    });
    $obtener_data_adicionar5("#tablaclientepotencial tbody", table)
}

$obtener_data_adicionar5 = function (tbody, table) {
    $(tbody).on("click", "button.editarcp", function () {
        var data = table.row($(this).parents("tr")).data();
        $(document).ready(function () {
            $("#myModalCp").modal('show');
            $("#codigo1").val(data.cli_documento);
            $("#codigo").val(data.cli_documento);
            $("#nombre").val(data.cli_nombre);
            $("#paginaweb").val(data.cli_paginaWeb);
            $("#direccion").val(data.cli_direccion);
            $("#email").val(data.cli_email);
            $("#zonacliente").val(data.cli_zonaCliente);
            $("#ciudad").val(data.cli_ciudad);
            $("#pais").val(data.cli_pais);
            $("#paginaweb").val(data.cli_paginaWeb);
            $("#telefono").val(data.cli_telefono);
            $("#password").val(data.cli_password);
        });
    });

    //Eliminar
    $(tbody).on("click", "button.eliminarcp", function () {
        var data = table.row($(this).parents("tr")).data();
        $(document).ready(function () {
            $("#ModalborrarclientPot").modal('show');
            $("#input_delete_cp").val(data.cli_documento);
        });
    });

    //Modal con notificación para eliminar un cliente potencial
    $(document).ready(function (e) {
        $("#btneliminarcp").click(function () {
            var id = $("#input_delete_cp").val();
            $.ajax({
                method: "GET",
                url: "index.php?controller=Cliente&action=borrar",
                data: {id: id}
            })
                    .done(function (msg) {
                        var json = JSON.parse(msg);
                        alert(json.Mensaje);
                        location.reload();
                    });
        });
    });
//Termina modal de Eliminar cliente potencial

    //Modal para pasar el cliente potencial
    $(tbody).on("click", "button.pasarcliente", function () {
        var data = table.row($(this).parents("tr")).data();
        $(document).ready(function () {
            $("#Modalpasaracliente").modal('show');
            $("#tipocliente").val('0');
            $("#documento").val(data.cli_documento);
        });
    });
    //Boton de pasar el cliente potencial
    $("#btnpasarcliente").click(function () {
        var documento = $("#documento").val();
        var tipocliente = $("#tipocliente").val();
        $.ajax({
            method: "GET",
            url: "index.php?controller=Cliente&action=modificarbdpasarcliente",
            data: {tipocliente: tipocliente, documento: documento}
        })
                .done(function (msg1) {
                    var json = JSON.parse(msg1);
                    alert(json.Mensaje);
                    location.reload();
                });
    });
    //Recargar la pagina cuándo se edita
        $(document).ready(function() {
        $('#btnpasarcliente').click(function() {
            // Recargo la página
            alert('Felicitaciones! Tienes un nuevo cliente');
            location.reload();
        });
    });
};
//Termina modal para pasar cliente potencial
//
//tabla dinamica de seguimiento cotizaciones
var listar6 = function () {
    var f = new Date();

    if (f.getDate() == 1 || f.getDate() == 2 || f.getDate() == 3 || f.getDate() == 4 || f.getDate() == 5 || f.getDate() == 6 || f.getDate() == 7 || f.getDate() == 8 || f.getDate() == 9 || f.getMonth() == 11 || f.getMonth() == 12) {
        var fecha = (f.getFullYear() + "-" + "0" + (f.getMonth() + 1) + "-" + "0" + f.getDate());
        var fecha1 = (f.getFullYear() + "-" + "0" + (f.getMonth() + 1) + "-" + "0" + (f.getDate() + 1));
        //  document.write(fecha1)
    } else {
        fecha = (f.getFullYear() + "-" + "0" + (f.getMonth() + 1) + "-" + f.getDate());
        fecha1 = (f.getFullYear() + "-" + "0" + (f.getMonth() + 1) + "-" + (f.getDate() + 1));
    }
    var table = $('#tablaseguimientocotizacion').DataTable({
        "ajax": {
            "method": "POST",
            "url": "index.php?controller=Seguimiento&action=mostrardatosseg",
        },
        "columns": [
            {"data": "seg_ticket"},
            {"data": "cot_codigoCotizacion"},
            {"data": "con_nombreCompleto"},
            {"data": "seg_fechaRegistro"},
            {"data": "seg_fechacompromiso"},
            {"defaultContent": "<button id='editarseguimiento1' class='btn btn-info editarseguimiento1'>Editar</button>"}
        ],
        //Cambiar de color la fila con fecha actual y del día de mañana
        "createdRow": function (row, data, dataIndex) {
            if (data['seg_fechacompromiso'] == fecha) {
                $('td', row).css('background-color', '#F96B5B');
            } else if (data['seg_fechacompromiso'] == fecha1) {
                $('td', row).css('background-color', '#F9B85B');
            }
        }
    });
    $obtener_data_adicionar6("#tablaseguimientocotizacion tbody", table)
}
$obtener_data_adicionar6 = function (tbody, table) {
    $(tbody).on("click", "button.editarseguimiento1", function () {
        var data = table.row($(this).parents("tr")).data();
        $(document).ready(function () {
            $("#myModalseguimiento1").modal('show');
            $("#seg_ticket").val(data.seg_ticket);
            $("#seg_ticket1").val(data.seg_ticket);
            $("#usu_documento").val(data.usu_documento);
            $("#usu_documento1").val(data.usu_documento);
            $("#cot_codigoCotizacionseguimiento").val(data.cot_codigoCotizacion);
            $("#cot_codigoCotizacionseguimiento1").val(data.cot_codigoCotizacion);
            $("#seg_comentario").val(data.seg_comentario);
            $("#seg_fechaRegistro").val(data.seg_fechaRegistro);
            $("#seg_fechaRegistro1").val(data.seg_fechaRegistro);
            $("#seg_fechacompromiso").val(data.seg_fechacompromiso);
        });
    });
};


//tabla dinamica de proveedor
var listar5 = function () {
    var table = $('#tablaproveedor').DataTable({
        "ajax": {
            "method": "POST",
            "url": "index.php?controller=Proveedor&action=mostrarproveedor",
        },
        "columns": [
            {"data": "pro_nit"},
            {"data": "pro_Nombre"},
            {"data": "pro_emailEmpresa"},
            {"data": "pro_ciudad"},
            {"data": "pro_telefono"},
            {"defaultContent": "<button id='editarproveedor' class='btn btn-info editarproveedor'>Editar</button>"},
            {"defaultContent": "<button id='eliminarproveedor' class='btn btn-danger eliminarproveedor'>Eliminar</button>"}
        ]
    });
    $obtener_data_adicionar7("#tablaproveedor tbody", table)

}
$obtener_data_adicionar7 = function (tbody, table) {
    $(tbody).on("click", "button.editarproveedor", function () {
        var data = table.row($(this).parents("tr")).data();
        $(document).ready(function () {
            $("#myModalproveedor").modal('show');
            $("#pro_nit1").val(data.pro_nit);
            $("#pro_nit2").val(data.pro_nit);
            $("#pro_Nombre").val(data.pro_Nombre);
            $("#pro_paginaWeb").val(data.pro_paginaWeb);
            $("#pro_emailEmpresa").val(data.pro_emailEmpresa);
            $("#pro_direccion").val(data.pro_direccion);
            $("#pro_telefono").val(data.pro_telefono);
            $("#pro_pais").val(data.pro_pais);
            $("#pro_ciudad").val(data.pro_ciudad);
        });
    });

    $(tbody).on("click", "button.eliminarproveedor", function () {
        var data = table.row($(this).parents("tr")).data();
        $(document).ready(function () {
            $("#ModalborrarProveedor").modal('show');
            $("#input_delete_proveedor").val(data.pro_nit);
        });
    });
};

//Modal con notificación para eliminar un proveedor
$(document).ready(function (e) {
    $("#btneliminar3").click(function () {
        var id = $("#input_delete_proveedor").val();
        $.ajax({
            method: "GET",
            url: "index.php?controller=Proveedor&action=borrar",
            data: {id: id}
        })
                .done(function (msg) {
                    var json = JSON.parse(msg);
                    alert(json.Mensaje);
                    location.reload();
                });
    });
});
//Termina modal de Eliminar proveedor

/*autocomplete editar de cotizacion para combo de contacto*/
$(document).ready(function (e) {
    /*Inicia librearia autocomplete*/
    //inicia autocomplete de cotizaciones en contacto (al editar)
    var options = {
        url: "index.php?controller=Cotizacion&action=buscarcontacto",
        getValue: function (element) {
            return element.con_nombreCompleto + " - " + element.con_codigo;
        },
        list: {
            match: {
                enabled: true
            },
            onSelectItemEvent: function () {
                var selectedItemValue = $("#inputcontactoeditar").getSelectedItemData().con_codigo;

                $("#inputcontactoeditar2").val(selectedItemValue).trigger("change");
            },
        }
    };
    $("#inputcontactoeditar").easyAutocomplete(options);
});
// Finaliza autocomplete de cotizaciones en contacto

//tabla dinamica de contacto
var listar7 = function () {
    var table = $('#tablacontacto').DataTable({
        "ajax": {
            "method": "POST",
            "url": "index.php?controller=contacto&action=mostrarcontacto",
        },
        "columns": [
            {"data": "con_codigo"},
            {"data": "con_nombreCompleto"},
            {"data": "con_telefono"},
            {"data": "con_profesion"},
            {"data": "con_email"},
            {"defaultContent": "<button id='editarcontacto1' class='btn btn-info editarcontacto1'>Editar</button>"},
            {"defaultContent": "<button id='eliminarcontacto1' class='btn btn-danger eliminarcontacto1'>Eliminar</button>"}
        ]
    });
    $obtener_data_adicionar8("#tablacontacto tbody", table)
    // Setup - add a text input to each footer cell
    $('#tablacontacto tfoot th').each(function () {
        var title = $(this).text();
        $(this).html('<input type="text" style="width: 135px;text-align: center" placeholder="' + title + '" />');
    });

    // DataTable
    var table = $('#tablacontacto').DataTable();

    // Apply the search
    table.columns().every(function () {
        var that = this;

        $('input', this.footer()).on('keyup change', function () {
            if (that.search() !== this.value) {
                that
                        .search(this.value)
                        .draw();
            }
        });
    });
}
//Editar un contacto
$obtener_data_adicionar8 = function (tbody, table) {
    $(tbody).on("click", "button.editarcontacto1", function () {
        var data = table.row($(this).parents("tr")).data();
        $(document).ready(function () {
            $("#myModalContacto").modal('show');
            $("#codigo").val(data.con_codigo);
            $("#codigo1").val(data.con_codigo);
            $("#nombre").val(data.con_nombreCompleto);
            $("#telefono").val(data.con_telefono);
            $("#profesion").val(data.con_profesion);
            $("#correo").val(data.con_email);
            $("#estadoCivil").val(data.con_estadoCivil);
            $("#cargo1").val(data.con_cargo);
            $("#fechaNacimiento").val(data.con_fechaNacimiento);
            $("#clientecombo").val(data.cli_nombre);
            $("#clientecombo1").val(data.cli_documento);
            $("#Proveedor").val(data.pro_Nombre);
            $("#Proveedor1").val(data.pro_nit);
            //Validación para mostrar el tipo  de contacto (Proveedor,cliente potencial,cliente)
            if (data.pro_nit == null) {
                $("#clientediv").show();
                $("#proveedordiv").hide();
            } else if (data.cli_documento == null) {
                $("#clientediv").hide();
                $("#proveedordiv").show();
            }


        });
    });

    $(tbody).on("click", "button.eliminarcontacto1", function () {
        var data = table.row($(this).parents("tr")).data();
        $(document).ready(function () {
            $("#ModalborrarContacto").modal('show');
            $("#input_delete_contacto").val(data.con_codigo);
        });
    });
};

//Modal con notificación para eliminar un proveedor
$(document).ready(function (e) {
    $("#btneliminarcontacto").click(function () {
        var id = $("#input_delete_contacto").val();
        $.ajax({
            method: "GET",
            url: "index.php?controller=Contacto&action=borrar",
            data: {id: id}
        })
                .done(function (msg) {
                    var json = JSON.parse(msg);
                    alert(json.Mensaje);
                    location.reload();
                });
    });
});
//Termina modal de Eliminar proveedor

/*autocomplete editar de contacto para combo de contacto al editar*/
$(document).ready(function (e) {
    /*Inicia librearia autocomplete*/
    //inicia autocomplete de cotizaciones en contacto (al editar)
    var options = {
        url: "index.php?controller=Cliente&action=buscarcliente",
        getValue: function (element) {
            return element.cli_nombre + " - " + element.cli_documento;
        },
        list: {
            match: {
                enabled: true
            },
            onSelectItemEvent: function () {
                var selectedItemValue = $("#clientecombo").getSelectedItemData().cli_documento;

                $("#clientecombo1").val(selectedItemValue).trigger("change");
            },
        }
    };
    $("#clientecombo").easyAutocomplete(options);
    $("#clientecombo").blur(function () {

        if ($("#clientecombo").val() == "") {

            $("#clientecombo1").val(null);
        }
    });
});
// Finaliza autocomplete de cotizaciones en contacto

/*autocomplete editar de contacto para combo de proveedor al editar*/
$(document).ready(function (e) {
    /*Inicia librearia autocomplete*/
    //inicia autocomplete de cotizaciones en contacto (al editar)
    var options = {
        url: "index.php?controller=proveedor&action=buscarproveedor",
        getValue: function (element) {
            return element.pro_Nombre + " - " + element.pro_nit;
        },
        list: {
            match: {
                enabled: true
            },
            onSelectItemEvent: function () {
                var selectedItemValue = $("#Proveedor").getSelectedItemData().pro_nit;

                $("#Proveedor1").val(selectedItemValue).trigger("change");
            },
        }
    };
    $("#Proveedor").easyAutocomplete(options);
    $("#Proveedor").blur(function () {

        if ($("#Proveedor").val() == "") {

            $("#Proveedor1").val(null);
        }
    });
});
// Finaliza autocomplete de contacto (Proveedor)

$(document).ready(function (e) {
    /*Inicia librearia autocomplete*/
    //inicia autocomplete de cotizaciones en contacto (al editar)
    var options = {
        url: "index.php?controller=proveedor&action=buscarproveedor",
        getValue: function (element) {
            return element.pro_Nombre + " - " + element.pro_nit;
        },
        list: {
            match: {
                enabled: true
            },
            onSelectItemEvent: function () {
                var selectedItemValue = $("#Proveedorproducto").getSelectedItemData().pro_nit;

                $("#Proveedorproducto1").val(selectedItemValue).trigger("change");
            },
        }
    };
    $("#Proveedorproducto").easyAutocomplete(options);
    $("#Proveedorproducto").blur(function () {

        if ($("#Proveedorproducto").val() == "") {

            $("#Proveedorproducto1").val(null);
        }
    });
});
// Finaliza autocomplete de contacto (Proveedor)

//tabla dinamica de usuarios
var listar9 = function () {
    var table = $('#tablausuarios').DataTable({
        "ajax": {
            "method": "POST",
            "url": "index.php?controller=Usuario&action=mostrarusuarios",
        },
        "columns": [
            {"data": "usu_documento"},
            {"data": "usu_nombre"},
            {"data": "usu_fechaNacimiento"},
            {"data": "usu_telefono"},
            {"data": "usu_email"},
            {"defaultContent": "<button id='editarusuario' class='btn btn-info editarusuario'>Editar</button>"},
        ]
    });
    $obtener_data_adicionar9("#tablausuarios tbody", table)

}
$obtener_data_adicionar9 = function (tbody, table) {
    $(tbody).on("click", "button.editarusuario", function () {
        var data = table.row($(this).parents("tr")).data();
        $(document).ready(function () {
            $("#myModalusuarios").modal('show');
            $("#usu_documento").val(data.usu_documento);
            $("#usu_documento2").val(data.usu_documento);
            $("#usu_nombre").val(data.usu_nombre);
            $("#usu_fechaNacimiento").val(data.usu_fechaNacimiento);
            $("#usu_password").val(data.usu_password);
            $("#usu_telefono").val(data.usu_telefono);
            $("#usu_nombreUsuario").val(data.usu_nombreUsuario);
            $("#usu_direccion").val(data.usu_direccion);
            //$("#usu_rol").val(data.usu_rol);
        });
    });
};


//Lista para Mostrar reportes
var listar10 = function () {
    var table = $('#tablareportes').DataTable({
        "ajax": {
            "method": "POST",
            "url": "index.php?controller=Reportes&action=consultarReportes",
        },
        "columns": [
            {"data": "rep_id"},
            {"data": "rep_nombre"},
            {"defaultContent": "<button id='descargarreporte' class='btn btn-info descargarreporte'>Descargar</button>"}
        ]
    });
    $obtener_data_adicionar10("#tablareportes tbody", table)
}

$obtener_data_adicionar10 = function (tbody, table) {
    $(tbody).on("click", "button.descargarreporte", function () {
        var data = table.row($(this).parents("tr")).data();
        $(document).ready(function () {
            $("#Modaldescargar").modal('show');
            $("#input_id").val(data.rep_id);
            $("#btndescargar").attr("href", data.rep_url);
        });
    });
};

//Mostrar cotizaciones pendientes
var listar11 = function () {
    var table = $('#tablacotizaciones2').DataTable({
        "ajax": {
            "method": "POST",
            "url": "index.php?controller=Cotizacion&action=mostrardatoscotizacionpendiente",
        },
        "columns": [
            {"data": "cot_codigoCotizacion"},
            {"data": "cot_lugarEntrega"},
            {"data": "con_nombreCompleto"},
            {"data": "cot_fechaCotizacion"},
            {"data": "cot_estadoventa"},
            {"defaultContent": "<button id='editarcot' class='btn btn-info editarcot'>Editar</button>"},
            {"defaultContent": "<button id='eliminarcot' class='btn btn-danger eliminarcot'>Eliminar</button>"},
            {"defaultContent": "<button id='crearseg' class='btn btn-primary crearseg'>Seguimiento</button>"},
        ]
    });
    $obtener_data_adicionar4("#tablacotizaciones2 tbody", table)

}
$obtener_data_adicionar4 = function (tbody, table) {
    $(tbody).on("click", "button.editarcot", function () {
        var data = table.row($(this).parents("tr")).data();
        $(document).ready(function () {
            $("#myModalCotizacion").modal('show');
            $("#cot_codigoCotizacion1").val(data.cot_codigoCotizacion);
            $("#cot_codigoCotizacion").val(data.cot_codigoCotizacion);
            $("#inputcontactoeditar").val(data.con_nombreCompleto);
            $("#inputcontactoeditar3").val(data.con_codigo);
            $("#inputcontactoeditar2").val(data.con_codigo);
            $("#cot_validez").val(data.cot_validez);
            $("#cot_tiempoEntrega").val(data.cot_tiempoEntrega);
            $("#cot_lugarEntrega").val(data.cot_lugarEntrega);
            $("#cot_formaPago").val(data.cot_formaPago);
            $("#cot_fechaCotizacion1").val(data.cot_fechaCotizacion);
            $("#cot_estadoventaselect").val(data.cot_estadoventa);
        });
    });
    $(tbody).on("click", "button.crearseg", function () {
        var data = table.row($(this).parents("tr")).data();
        $(document).ready(function () {
            $("#Modalseguimiento1").modal('show');
            $("#cot_codigoCotizacionseguimiento").val(data.cot_codigoCotizacion);
            $("#cot_codigoCotizacionseguimiento1").val(data.cot_codigoCotizacion);
        });
    });


    $(tbody).on("click", "button.eliminarcot", function () {
        var data = table.row($(this).parents("tr")).data();
        $(document).ready(function () {
            $("#Modalborrarcotizacion").modal('show');
            $("#input_delete_cotizacion").val(data.cot_codigoCotizacion);
        });
    });
};


//Hacer un tooltip en los input
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

   //Mostrar Modal de bienvenida al momento de ingresar un usuario completamente nuevo al sistema
   $(document).ready(function()
   {
      $("#mostrarmodal").modal("show");
   });
   
   function jsFunction() {
    $(document).ready(function () {
        $("#MyModalMensaje").modal('show');
    });

    $(document).on("click", "#volverMasivo", function () {
            window.location = "index.php?controller=Producto&action=CargaMasivaView";
    });
    $(document).on("click", "#log", function () {
            window.location = "index.php?controller=Reportes&action=mostrarReportes";
    });
}

$(document).ready(function(){
	$("#prd_codigoProducto").change(function(){
        $.ajax({
            // la URL para la petición
            url : 'index.php?controller=Producto&action=ConsultarProductoRepetido',
            data : { id : $("#prd_codigoProducto").val() },
            type : 'POST',
            dataType : 'json',
            success:function(data){
                if(data.estado == 'ok')
                {
                    document.getElementById("ProductoRepetido").style.display = "block";
                    document.getElementById("ProductoRepetido").style.color = "red";
                    document.getElementById("btnAddProduct").disabled = true;
                    document.getElementById("btAdd").disabled = true;
                    document.getElementById("btRemove").disabled = true;
                    document.getElementById("btnRemoveAll").disabled = true;
                }
            },
            error:function(data){
                document.getElementById("ProductoRepetido").style.display = "none";
                document.getElementById("btnAddProduct").disabled = false;
                document.getElementById("btAdd").disabled = false;
                document.getElementById("btRemove").disabled = false;
                document.getElementById("btnRemoveAll").disabled = false;
            }
        })
    })
})

$(document).ready(function(){
	$("#cli_documento").change(function(){
        $.ajax({
            // la URL para la petición
            url : 'index.php?controller=Cliente&action=ConsultarClienteRepetido',
            data : { id : $("#cli_documento").val() },
            type : 'POST',
            dataType : 'json',
            success:function(data){
                if(data.estado == 'ok')
                {
                    document.getElementById("ClienteRepetido").style.display = "block";
                    document.getElementById("ClienteRepetido").style.color = "red";
                    document.getElementById("btnAddClient").disabled = true;
                }
            },
            error:function(data){
                document.getElementById("ClienteRepetido").style.display = "none";
                document.getElementById("btnAddClient").disabled = false;
            }
        })
    })
})