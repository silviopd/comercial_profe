/*INICIO: BUSQUEDA DE CLIENTES*/
$("#txtnombrecliente").autocomplete({
    source: "../controlador/cliente.autocompletar.controlador.php",
    minLength: 3, //Filtrar desde que colocamos 3 o mas caracteres
    focus: f_enfocar_registro,
    select: f_seleccionar_registro
});

function f_enfocar_registro(event, ui){
    var registro = ui.item.value;
    $("#txtnombrecliente").val(registro.nombre);
    event.preventDefault();
}

function f_seleccionar_registro(event, ui){
    var registro = ui.item.value;
    $("#txtnombrecliente").val(registro.nombre);
    $("#txtcodigocliente").val(registro.codigo);
    $("#lbldireccioncliente").val(registro.direccion);
    $("#lbltelefonocliente").val(registro.telefono);
    
    event.preventDefault();
}

/*FIN: BUSQUEDA DE CLIENTES*/



/*INICIO: BUSQUEDA DE ARTICULOS*/
$("#txtarticulo").autocomplete({
    source: "../controlador/articulo.autocompletar.controlador.php",
    minLength: 3, //Filtrar desde que colocamos 3 o mas caracteres
    focus: f_enfocar_registro_articulo,
    select: f_seleccionar_registro_articulo
});

function f_enfocar_registro_articulo(event, ui){
    var registro = ui.item.value;
    $("#txtarticulo").val(registro.nombre);
    event.preventDefault();
}

function f_seleccionar_registro_articulo(event, ui){
    var registro = ui.item.value;
    $("#txtarticulo").val(registro.nombre);
    $("#txtcodigoarticulo").val(registro.codigo);
    $("#txtprecio").val(registro.precio);
    $("#txtcantidad").focus();
    
    
    event.preventDefault();
}

/*FIN: BUSQUEDA DE ARTICULOS*/