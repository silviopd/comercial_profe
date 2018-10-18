<?php

    require_once '../negocio/Articulo.clase.php';
    require_once '../util/funciones/Funciones.clase.php';

    if (! isset($_POST["codigoArticulo"])){
	Funciones::imprimeJSON(500, "Faltan parametros", "");
	exit();
    }
    
    try {
        $objArti = new Articulo();
        $codigoArticulo = $_POST["codigoArticulo"];
        $resultado = $objArti->eliminar($codigoArticulo);
        if ($resultado == true){
            //Eliminó correctamente
            Funciones::imprimeJSON(200, "El registro se ha eleiminado satisfactoriamente", "");
        }
    } catch (Exception $exc) {
        Funciones::imprimeJSON(500, $exc->getMessage(), "");
    }

    