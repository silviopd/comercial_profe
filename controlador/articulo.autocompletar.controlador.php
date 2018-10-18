<?php

require_once '../negocio/Articulo.clase.php';

$obj = new Articulo();

$valorBusqueda = $_GET["term"];

$resultado = $obj->cargarDatosArticulo($valorBusqueda);

$datos = array();

for ($i = 0; $i < count($resultado); $i++) {
    $registro = array
            (
                "label" => $resultado[$i]["nombre"],
                "value" => array
                            (
                                "codigo" => $resultado[$i]["codigo_articulo"],
                                "nombre" => $resultado[$i]["nombre"],
                                "precio" => $resultado[$i]["precio_venta"]
                            )
            );
    
    $datos[$i] = $registro;
}

echo json_encode($datos);