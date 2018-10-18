<?php

require_once '../datos/Conexion.clase.php';

class TipoComprobante extends Conexion {
    

    public function cargarTipoComprobante(){
        try {
            $sql = "select * from tipo_comprobante order by 2";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    
}
