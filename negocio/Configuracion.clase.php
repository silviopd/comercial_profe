<?php

require_once '../datos/Conexion.clase.php';

class Configuracion extends Conexion {
    
    public function obtenerValorConfiguracion($p_CodigoParametro) {
        try {
            $sql = "select valor from configuracion where codigo = :p_codigoParametro";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigoParametro", $p_CodigoParametro);
            $sentencia->execute();
            $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
            return $resultado["valor"];
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    
}
