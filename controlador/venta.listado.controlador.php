<?php

require_once '../negocio/Venta.clase.php';
require_once '../util/funciones/Funciones.clase.php';

if  (
        (! isset($_POST["p_fecha1"])) ||
        (! isset($_POST["p_fecha2"])) ||
        (! isset($_POST["p_tipo"]))
    )
{
    Funciones::imprimeJSON(500, "Faltan parametros", "");
    exit();
}

$objVenta = new Venta();
try {
    $fecha1     = $_POST["p_fecha1"];
    $fecha2     = $_POST["p_fecha2"];
    $tipo       = $_POST["p_tipo"];
    
    $resultado = $objVenta->listar($fecha1, $fecha2, $tipo);
    
    Funciones::imprimeJSON(200, "", $resultado);
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


