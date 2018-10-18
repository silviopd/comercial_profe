<?php

    require_once '../negocio/TipoComprobante.clase.php';
    require_once '../util/funciones/Funciones.clase.php';

    try {
	$obj = new TipoComprobante();
        $resultado = $obj->cargarTipoComprobante();
	Funciones::imprimeJSON(200, "", $resultado);
	
    } catch (Exception $exc) {
	Funciones::imprimeJSON(500, $exc->getMessage(), "");
	
    }
