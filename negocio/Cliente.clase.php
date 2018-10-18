<?php

require_once '../datos/Conexion.clase.php';

class Cliente extends Conexion {
    
    public function cargarDatosCliente($nombre) {
        try {
            $sql = "
		select 
		    codigo_cliente, 
		    (apellido_paterno || ' ' || apellido_materno || ', ' || nombres) as nombre_completo, 
		    direccion, 
		    telefono_fijo, 
		    coalesce(telefono_movil1, '-')  as movil1,
		    coalesce(telefono_movil2, '')  as movil2
		from 
		    cliente 
		where 
		    lower(apellido_paterno || ' ' || apellido_materno || ' ' || nombres) like :p_nombre";
            $sentencia = $this->dblink->prepare($sql);
            $nombre = '%'.  strtolower($nombre).'%';
            $sentencia->bindParam(":p_nombre", $nombre);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);

            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
            
    }
}
