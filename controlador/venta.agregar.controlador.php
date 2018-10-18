<?php

session_name("sistemacomercial1");
session_start();

require_once '../negocio/Venta.clase.php';
require_once '../util/funciones/Funciones.clase.php';

if (! isset($_POST["p_datosFormulario"]) ){
    Funciones::imprimeJSON(500, "Faltan parametros", "");
    exit();
}

$datosFormulario = $_POST["p_datosFormulario"];
$datosJSONDetalle = $_POST["p_datosJSONDetalle"];

//Convertir todos los datos que llegan concatenados a un array
parse_str($datosFormulario, $datosFormularioArray);

/*
echo '<pre>';
print_r($datosFormularioArray);
echo '</pre>';
*/

try {
    $objVenta = new Venta();
    $objVenta->setCodigoTipoComprobante( $datosFormularioArray["cbotipocomp"]);
    $objVenta->setNumeroSerie( $datosFormularioArray["cboserie"]);
    $objVenta->setNumeroDocumento( $datosFormularioArray["txtnrodoc"]);
    $objVenta->setCodigoCliente( $datosFormularioArray["txtcodigocliente"]);
    $objVenta->setFechaVenta( $datosFormularioArray["txtfec"]);
    $objVenta->setPorcentajeIgv( $datosFormularioArray["txtigv"]);
    $objVenta->setSubTotal( $datosFormularioArray["txtimportesubtotal"]);
    $objVenta->setIgv( $datosFormularioArray["txtimporteigv"]);
    $objVenta->setTotal( $datosFormularioArray["txtimporteneto"]);
    
    $codigoUsuarioSesion = $_SESSION["s_codigo_usuario"];
    $objVenta->setCodigoUsuario( $codigoUsuarioSesion );
    
    
    //Enviar los datos del detalle en formato JSON
    $objVenta->setDetalleVenta( $datosJSONDetalle );
    
    $resultado = $objVenta->agregar();
    
    if ($resultado == true){
        Funciones::imprimeJSON(200, "La venta ha sido registrada correctamente", "");
    }
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}



