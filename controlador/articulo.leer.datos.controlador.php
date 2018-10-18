<?php

require_once '../negocio/Articulo.clase.php';
require_once '../util/funciones/Funciones.clase.php';

if (! isset($_POST["p_codigoArticulo"]) ){
    Funciones::imprimeJSON(500, "Faltan parametros", "");
    exit();
}

try {
    $objArti = new Articulo();
    $codigoArticulo = $_POST["p_codigoArticulo"];
    $resultado = $objArti->leerDatos($codigoArticulo);
    
    Funciones::imprimeJSON(200, "", $resultado);
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


