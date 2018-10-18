<?php

require_once '../negocio/Articulo.clase.php';
require_once '../util/funciones/Funciones.clase.php';

try {
    
    if ( !isset( $_POST["codigoCategoria"] )){
        Funciones::imprimeJSON(500, "Faltan parametros", "");
        exit;
    }
    $codigoLinea = $_POST["codigoLinea"];
    $codigoCategoria = $_POST["codigoCategoria"];
    $codigoMarca = $_POST["codigoMarca"];
    
    $objArticulo = new Articulo();
    $resultado = $objArticulo->listar($codigoLinea, $codigoCategoria, $codigoMarca);
    
    Funciones::imprimeJSON(200, "", $resultado);
    
    
} catch (Exception $exc) {
    //Funciones::mensaje($exc->getMessage(), "e");
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}

