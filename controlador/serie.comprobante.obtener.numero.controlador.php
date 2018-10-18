<?php

    require_once '../negocio/SerieComprobante.clase.php';
    require_once '../util/funciones/Funciones.clase.php';

    try {
	$obj = new SerieComprobante();
        $tipoComprobante = $_POST["p_tipoComprobante"];
        $serie = $_POST["p_serie"];
        $resultado = $obj->cargarNumeroComprobante($tipoComprobante, $serie);
	Funciones::imprimeJSON(200, "", $resultado);
	
    } catch (Exception $exc) {
	Funciones::imprimeJSON(500, $exc->getMessage(), "");
	
    }
