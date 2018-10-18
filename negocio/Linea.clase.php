<?php

require_once '../datos/Conexion.clase.php';

class Linea extends Conexion {
    
    public function cargarListaDatos(){
        try {
            $sql = "select * from linea order by 2";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll();
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
            
    }
    
}
