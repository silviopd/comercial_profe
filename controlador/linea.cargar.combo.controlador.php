<?php

    //require_once 'sesion.validar.controlador.php';

    require_once '../negocio/Linea.clase.php';
    require_once '../util/funciones/Funciones.clase.php';

    try {
	$obj = new Linea();
        $resultado = $obj->cargarListaDatos();
	Funciones::imprimeJSON(200, "", $resultado);
	
    } catch (Exception $exc) {
	Funciones::imprimeJSON(500, $exc->getMessage(), "");
	
    }
