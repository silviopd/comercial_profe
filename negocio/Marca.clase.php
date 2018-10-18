<?php

require_once '../datos/Conexion.clase.php';

class Marca extends Conexion {
    private $codigoMarca;
    private $descripcion;
    
    public function cargarListaDatos() {
	try {
            $sql = " select * from marca order by 2";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
}
