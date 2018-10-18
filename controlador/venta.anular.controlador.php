<?php

require_once '../negocio/Venta.clase.php';
require_once '../util/funciones/Funciones.clase.php';

if  (
        (! isset($_POST["p_numero_venta"]))
    )
{
    Funciones::imprimeJSON(500, "Faltan parametros", "");
    exit();
}


$objVenta = new Venta();
try {
    $numero_venta = $_POST["p_numero_venta"];
    $resultado = $objVenta->anular($numero_venta);
    if ($resultado == true){
        Funciones::imprimeJSON(200, "Venta anulada correctamente", "");
    }
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
