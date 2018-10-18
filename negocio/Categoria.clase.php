<?php

require_once '../datos/Conexion.clase.php';

class Categoria extends Conexion {
    private $codigoCategoria;
    private $descripcion;
    private $codigoLinea;
    
    public function cargarListaDatos($p_codigoLinea){
	try {
            $sql = " select * from categoria where codigo_linea = :p_codigoLinea order by 2";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigoLinea", $p_codigoLinea);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
}
