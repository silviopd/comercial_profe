<?php

require_once '../negocio/Configuracion.clase.php';
require_once '../util/funciones/Funciones.clase.php';

$objConf = new Configuracion();

try {
    $codigoParametro = $_POST["p_codigo_parametro"];
    $valorObtenido = $objConf->obtenerValorConfiguracion($codigoParametro);
    Funciones::imprimeJSON(200, "", $valorObtenido);
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
