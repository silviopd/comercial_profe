<?php

require_once '../negocio/Articulo.clase.php';
require_once '../util/funciones/Funciones.clase.php';

if (! isset($_POST["p_datosFormulario"]) ){
    Funciones::imprimeJSON(500, "Faltan parametros", "");
    exit();
}

$datosFormulario = $_POST["p_datosFormulario"];

//Convertir todos los datos que llegan concatenados a un array
parse_str($datosFormulario, $datosFormularioArray);



////quitar
//print_r($datosFormularioArray);
//exit();

try {
    $objArticulo = new Articulo();
    $objArticulo->setNombre( $datosFormularioArray["txtnombre"] );
    $objArticulo->setPrecioVenta( $datosFormularioArray["txtprecio"] );
    $objArticulo->setCodigoCategoria( $datosFormularioArray["cbocategoriamodal"] );
    $objArticulo->setCodigoMarca( $datosFormularioArray["cbomarcamodal"] );
    
    if ($datosFormularioArray["txttipooperacion"]=="agregar"){
        $resultado = $objArticulo->agregar();
        if ($resultado==true){
            Funciones::imprimeJSON(200, "Grabado correctamente", "");
        }
    }else{
        $objArticulo->setCodigoArticulo( $datosFormularioArray["txtcodigo"] );
        
        $resultado = $objArticulo->editar();
        if ($resultado==true){
            Funciones::imprimeJSON(200, "Grabado correctamente", "");
        }
    }
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
