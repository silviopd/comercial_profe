$("#btnregresar").click(function(){
    document.location.href = "venta.listado.vista.php";
});

$(document).ready(function(){
    cargarComboTC("#cbotipocomp", "seleccione");
    obtenerPorcentajeIGV();
});

$("#cbotipocomp").change(function(){
    var tipoComprobante = $("#cbotipocomp").val();
    cargarComboSerie("#cboserie", "seleccione", tipoComprobante );
});


function obtenerNumeroComprobante(){
    var tipoComprobante = $("#cbotipocomp").val();
    var serie = $("#cboserie").val();
    
    $.post
        (
           "../controlador/serie.comprobante.obtener.numero.controlador.php",
            {
                p_tipoComprobante: tipoComprobante,
                p_serie: serie
            }
        ).done(function(resultado){
            var datosJSON = resultado;
            if (datosJSON.estado === 200){
                var numeroComprobante = datosJSON.datos.numero;
                $("#txtnrodoc").val(numeroComprobante);
            }else{
                swal("Mensaje del sistema", resultado , "warning");
            }
        }).fail(function(error){
            var datosJSON = $.parseJSON( error.responseText );
            swal("Error", datosJSON.mensaje , "error");
        });
    
}

$("#cboserie").change(function(){
    obtenerNumeroComprobante();
});

$("#btnagregar").click(function(){
    if ($("#txtcodigoarticulo").val().toString() === ""){
        //alert("Debe seleccionar un artículo");
        swal("Verifique", "Debe seleccionar un artículo", "warning");
        $("#txtarticulo").focus();
        return 0; //detiene el programa
    }
    
    //capturar las variables para agregar al detalle
    var codigoArticulo  = $("#txtcodigoarticulo").val();
    var nombreArticulo  = $("#txtarticulo").val();
    var precioVenta     = $("#txtprecio").val();
    var cantidadVenta   = $("#txtcantidad").val();
    var importe         = precioVenta * cantidadVenta;
    
    //Elaborar una variable con el HTML para agregar al detalle
    var fila = '<tr>'+
                    '<td class="text-center">' + codigoArticulo + '</td>' +
                    '<td>' + nombreArticulo + '</td>' +
                    '<td class="text-right">' + precioVenta + '</td>' +
                    '<td class="text-right">' + cantidadVenta + '</td>' +
                    '<td class="text-right">' + importe + '</td>' +
                    '<td id="celiminar" class="text-center"><a href="#"> <i style="font-size:20px;" class="fa fa-close text-orange"></i> </a></td>' +
                '</tr>';
        
        
    //Agregar el registro al detalle de la venta
    $("#detalleventa").append(fila);
    
    
    //LLamar a la función calcular totales
    calcularTotales();
    
    //Limpiar los controles y enfocar a la caja de texto txtarticulo
    $("#txtcodigoarticulo").val("");
    $("#txtarticulo").val("");
    $("#txtprecio").val("");
    $("#txtcantidad").val("");
    $("#txtarticulo").focus();    
    
    
});


$(document).on("click", "#celiminar", function(){
    
    var filaEliminar = $(this).parents().get(0); //Capturar la fila que se desea eliminar
    
    swal({
		title: "Confirme",
		text: "¿Desea eliminar el registro seleccionado?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#ff0000',
		confirmButtonText: 'Si',
		cancelButtonText: "No",
		closeOnConfirm: true,
		closeOnCancel: true
	},
	function(isConfirm){ 
            if (isConfirm){ //el usuario hizo clic en el boton SI     
                filaEliminar.remove();
                calcularTotales();
                $("#txtarticulo").focus();
            }
	});   
});

function calcularTotales(){
    var subTotal = 0;
    var igv = 0;
    var neto = 0;
    
    $("#detalleventa tr").each(function(){
        var importe = $(this).find("td").eq(4).html();
        neto = neto  + parseFloat(importe);
    });
    
    var porcentajeIGV = 18; //Remplazar por el valor de la caja de texto txtigv
    
    subTotal = neto / (1 + (porcentajeIGV / 100));
    igv = neto - subTotal;
    
    //Mostrar los totales
    $("#txtimporteneto").val(neto.toFixed(2));
    $("#txtimportesubtotal").val(subTotal.toFixed(2));
    $("#txtimporteigv").val(igv.toFixed(2));
    
}

$("#txtcantidad").keypress(function(evento){
    if (evento.which === 13){ //Significa que el usuario ha presionado la tecla ENTER
        evento.preventDefault();
        $("#btnagregar").click();
    }else{
        return validarNumeros(evento);
    }
});


function obtenerPorcentajeIGV(){
    $.post
        (
            "../controlador/configuracion.controlador.php",
            {
                p_codigo_parametro: 1  // 1 = IGV
            }
        ).done(function(resultado){
            var datosJSON = resultado;
            if (datosJSON.estado === 200){
                var valorObtenido = datosJSON.datos;
                $("#txtigv").val(valorObtenido);
            }else{
                swal("Mensaje del sistema", resultado , "warning");
            }
        }).fail(function(error){
            var datosJSON = $.parseJSON( error.responseText );
            swal("Error", datosJSON.mensaje , "error");
        });
}



var arrayDetalle = new Array(); //permite almacenar todos los articulos agregados en el detalle de la venta

$("#frmgrabar").submit(function(evento){
    evento.preventDefault();
    
    swal({
		title: "Confirme",
		text: "¿Esta seguro de grabar la venta?",
		
		showCancelButton: true,
		confirmButtonColor: '#3d9205',
		confirmButtonText: 'Si',
		cancelButtonText: "No",
		closeOnConfirm: false,
		closeOnCancel: true,
                imageUrl: "../imagenes/pregunta.png"
	},
	function(isConfirm){ 

            if (isConfirm){ //el usuario hizo clic en el boton SI     
                
                //procedo a grabar
                
                /*CAPTURAR TODOS LOS DATOS NECESARIOS PARA GRABAR EN EL VENTA_DETALLE*/
                
                /*limpiar el array*/
                arrayDetalle.splice(0, arrayDetalle.length);
                /*limpiar el array*/
                
                /*RECORREMOS CADA FILA DE LA TABLA DONDE ESTAN LOS ARTICULOS VENDIDOS*/
                $("#detalleventa tr").each(function(){
                    var codigoArticulo = $(this).find("td").eq(0).html();
                    var precio = $(this).find("td").eq(2).html();
                    var cantidad = $(this).find("td").eq(3).html();
                    var importe = $(this).find("td").eq(4).html();
                    
                    var objDetalle = new Object(); //Crear un objeto para almacenar los datos
                    
                    /*declaramos y asignamos los valores a los atributos*/
                    objDetalle.codigoArticulo = codigoArticulo;
                    objDetalle.cantidad  = cantidad;
                    objDetalle.precio    = precio;
                    objDetalle.importe   = importe;
                    /*declaramos y asignamos los valores a los atributos*/
                    
                    arrayDetalle.push(objDetalle); //agregar el objeto objDetalle al array arrayDetalle
                    
                });
                
                /*RECORREMOS CADA FILA DE LA TABLA DONDE ESTAN LOS ARTICULOS VENDIDOS*/
                
                //Convertimos el array "arrayDetalle" a formato de JSON
                var jsonDetalle = JSON.stringify(arrayDetalle);
                
                //alert(jsonDetalle);
                //return 0;
                
    
                /*CAPTURAR TODOS LOS DATOS NECESARIOS PARA GRABAR EN EL VENTA_DETALLE*/
                
                $.post(
                    "../controlador/venta.agregar.controlador.php",
                    {
                        p_datosFormulario: $("#frmgrabar").serialize(),
                        p_datosJSONDetalle: jsonDetalle
                    }
                  ).done(function(resultado){                    
		      var datosJSON = resultado;

                      if (datosJSON.estado===200){
			  //swal("Exito", datosJSON.mensaje, "success");
                          //document.location.href = "venta.listado.vista.php";
                          
                          swal({
                                title: "Exito",
                                text: datosJSON.mensaje,
                                type: "success",
                                showCancelButton: false,
                                //confirmButtonColor: '#3d9205',
                                confirmButtonText: 'Ok',
                                closeOnConfirm: true,
                            },
                            function(){
                                document.location.href="venta.listado.vista.php";
                            });

                          
                      }else{
                          swal("Mensaje del sistema", resultado , "warning");
                      }

                  }).fail(function(error){
			var datosJSON = $.parseJSON( error.responseText );
			swal("Error", datosJSON.mensaje , "error");
                  }) ;
                
            }
	});    
});