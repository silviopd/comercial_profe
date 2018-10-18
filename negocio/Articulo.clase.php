<?php

require_once '../datos/Conexion.clase.php';

class Articulo extends Conexion {
    private $codigoArticulo;
    private $nombre;
    private $precioVenta;
    private $codigoCategoria;
    private $codigoMarca;
    
    function getCodigoArticulo() {
        return $this->codigoArticulo;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getPrecioVenta() {
        return $this->precioVenta;
    }

    function getCodigoCategoria() {
        return $this->codigoCategoria;
    }

    function getCodigoMarca() {
        return $this->codigoMarca;
    }

    function setCodigoArticulo($codigoArticulo) {
        $this->codigoArticulo = $codigoArticulo;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setPrecioVenta($precioVenta) {
        $this->precioVenta = $precioVenta;
    }

    function setCodigoCategoria($codigoCategoria) {
        $this->codigoCategoria = $codigoCategoria;
    }

    function setCodigoMarca($codigoMarca) {
        $this->codigoMarca = $codigoMarca;
    }

        
    public function listar( $p_codigoLinea, $p_codigoCategoria, $p_codigoMarca ) {
        try {
            $sql = "select * from f_listar_articulo(:p_codigoLinea, :p_codigoCategoria, :p_codigoMarca)";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigoLinea", $p_codigoLinea);
            $sentencia->bindParam(":p_codigoCategoria", $p_codigoCategoria);
            $sentencia->bindParam(":p_codigoMarca", $p_codigoMarca);
            $sentencia->execute();
            
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            
            return $resultado;
            
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    public function eliminar( $p_codigoArticulo ){
        $this->dblink->beginTransaction();
        try {
            $sql = "delete from articulo where codigo_articulo = :p_codigoArticulo";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigoArticulo", $p_codigoArticulo);
            $sentencia->execute();
            
            $this->dblink->commit();
            
            return true;
        } catch (Exception $exc) {
            $this->dblink->rollBack();
            throw $exc;
        }
        
        return false;
    }
    
    public function agregar() {
        $this->dblink->beginTransaction();
        
        try {
            $sql = "select * from f_generar_correlativo('articulo') as nc";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetch();
            
            if ($sentencia->rowCount()){
                $nuevoCodigoArticulo = $resultado["nc"];
                $this->setCodigoArticulo($nuevoCodigoArticulo);
                
                $sql = "
                        INSERT INTO articulo
                        (
                                codigo_articulo, 
                                nombre, 
                                precio_venta, 
                                codigo_categoria, 
                                codigo_marca
                        )
                        VALUES 
                        (
                                :p_codigo_articulo, 
                                :p_nombre, 
                                :p_precio_venta, 
                                :p_codigo_categoria, 
                                :p_codigo_marca
                        );
                    ";
                
                //Preparar la sentencia
                $sentencia = $this->dblink->prepare($sql);
                
                //Asignar un valor a cada parametro
                $sentencia->bindParam(":p_codigo_articulo", $this->getCodigoArticulo());
                $sentencia->bindParam(":p_nombre", $this->getNombre());
                $sentencia->bindParam(":p_precio_venta", $this->getPrecioVenta());
                $sentencia->bindParam(":p_codigo_categoria", $this->getCodigoCategoria());
                $sentencia->bindParam(":p_codigo_marca", $this->getCodigoMarca());
                
                //Ejecutar la sentencia preparada
                $sentencia->execute();
                
                
                //Actualizar el correlativo en +1
                $sql = "update correlativo set numero = numero + 1 where tabla = 'articulo'";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->execute();
                
                $this->dblink->commit();
                
                return true; //significa que todo se ha ejecutado correctamente
                
            }else{
                throw new Exception("No se ha configurado el correlativo para la tabla artículo");
            }
            
        } catch (Exception $exc) {
            $this->dblink->rollBack(); //Extornar toda la transacción
            throw $exc;
        }
        
        return false;
            
    }
    
    
    public function leerDatos($p_codigoArticulo) {
        try {
            $sql = "
                    select
                            a.*,
                            c.codigo_linea
                    from
                            articulo a 
                            inner join categoria c on ( a.codigo_categoria = c.codigo_categoria )
                    where
                            a.codigo_articulo = :p_codigo_articulo
                ";
            
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_articulo", $p_codigoArticulo);
            $sentencia->execute();
            
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            
            return $resultado;
            
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    
    public function editar() {
        $this->dblink->beginTransaction();
        
        try {
           $sql = " 
                    update articulo set
                        nombre              = :p_nombre,
                        precio_venta        = :p_precio_venta,
                        codigo_categoria    = :p_codigo_categoria,
                        codigo_marca        = :p_codigo_marca
                    where
                        codigo_articulo     = :p_codigo_articulo
               ";
           
           
           //Preparar la sentencia
            $sentencia = $this->dblink->prepare($sql);

            //Asignar un valor a cada parametro
            $sentencia->bindParam(":p_nombre", $this->getNombre());
            $sentencia->bindParam(":p_precio_venta", $this->getPrecioVenta());
            $sentencia->bindParam(":p_codigo_categoria", $this->getCodigoCategoria());
            $sentencia->bindParam(":p_codigo_marca", $this->getCodigoMarca());
            $sentencia->bindParam(":p_codigo_articulo", $this->getCodigoArticulo());

            //Ejecutar la sentencia preparada
            $sentencia->execute();
            
            
            $this->dblink->commit();
                
            return true;
            
        } catch (Exception $exc) {
           $this->dblink->rollBack();
           throw $exc;
        }
        
        return false;
            
    }
    
    
    public function cargarDatosArticulo($p_nombreArticulo) {
        try {
            $sql = "select  
                        codigo_articulo, 
                        nombre, 
                        precio_venta 
                    from 
                        articulo 
                    where 
                        lower(nombre) like :p_nombreArticulo";
            
            $sentencia = $this->dblink->prepare($sql);
            $valorBusqueda = '%' . strtolower($p_nombreArticulo) . '%';
            $sentencia->bindParam(":p_nombreArticulo", $valorBusqueda);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
            
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    
}


