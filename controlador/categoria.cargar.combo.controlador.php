<?php

    //require_once 'sesion.validar.controlador.php';

    require_once '../negocio/Categoria.clase.php';
    require_once '../util/funciones/Funciones.clase.php';

    try {
        $p_codigoLinea = $_POST["p_codigoLinea"];
        
	$obj = new Categoria();
        $resultado = $obj->cargarListaDatos($p_codigoLinea);
	Funciones::imprimeJSON(200, "", $resultado);
	
    } catch (Exception $exc) {
	Funciones::imprimeJSON(500, $exc->getMessage(), "");
	
    }
