<?php

require_once '../datos/Conexion.clase.php';

class Venta extends Conexion {
    private $numeroVenta;
    private $codigoTipoComprobante;
    private $numeroSerie;
    private $numeroDocumento;
    private $codigoCliente;
    private $fechaVenta;
    private $porcentajeIgv;
    private $subTotal;
    private $igv;
    private $total;
    private $codigoUsuario;
    
    private $detalleVenta; //JSON
    
    function getNumeroVenta() {
        return $this->numeroVenta;
    }

    function getCodigoTipoComprobante() {
        return $this->codigoTipoComprobante;
    }

    function getNumeroSerie() {
        return $this->numeroSerie;
    }

    function getNumeroDocumento() {
        return $this->numeroDocumento;
    }

    function getCodigoCliente() {
        return $this->codigoCliente;
    }

    function getFechaVenta() {
        return $this->fechaVenta;
    }

    function getPorcentajeIgv() {
        return $this->porcentajeIgv;
    }

    function getSubTotal() {
        return $this->subTotal;
    }

    function getIgv() {
        return $this->igv;
    }

    function getTotal() {
        return $this->total;
    }

    function getCodigoUsuario() {
        return $this->codigoUsuario;
    }

    function getDetalleVenta() {
        return $this->detalleVenta;
    }

    function setNumeroVenta($numeroVenta) {
        $this->numeroVenta = $numeroVenta;
    }

    function setCodigoTipoComprobante($codigoTipoComprobante) {
        $this->codigoTipoComprobante = $codigoTipoComprobante;
    }

    function setNumeroSerie($numeroSerie) {
        $this->numeroSerie = $numeroSerie;
    }

    function setNumeroDocumento($numeroDocumento) {
        $this->numeroDocumento = $numeroDocumento;
    }

    function setCodigoCliente($codigoCliente) {
        $this->codigoCliente = $codigoCliente;
    }

    function setFechaVenta($fechaVenta) {
        $this->fechaVenta = $fechaVenta;
    }

    function setPorcentajeIgv($porcentajeIgv) {
        $this->porcentajeIgv = $porcentajeIgv;
    }

    function setSubTotal($subTotal) {
        $this->subTotal = $subTotal;
    }

    function setIgv($igv) {
        $this->igv = $igv;
    }

    function setTotal($total) {
        $this->total = $total;
    }

    function setCodigoUsuario($codigoUsuario) {
        $this->codigoUsuario = $codigoUsuario;
    }

    function setDetalleVenta($detalleVenta) {
        $this->detalleVenta = $detalleVenta;
    }


    public function agregar() {
        $this->dblink->beginTransaction();
        try {
            $sql = "select * from f_generar_correlativo('venta') as nc";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetch();
            
            if ($sentencia->rowCount()){
                $nuevoNumeroVenta = $resultado["nc"];
                $this->setNumeroVenta($nuevoNumeroVenta);
                
                
                $sql = "
                        INSERT INTO venta
                            (
                                    numero_venta,
                                    codigo_tipo_comprobante, 
                                    numero_serie, 
                                    numero_documento, 
                                    codigo_cliente, 
                                    fecha_venta, 
                                    porcentaje_igv, 
                                    sub_total, 
                                    igv, 
                                    total, 
                                    codigo_usuario
                            )
                        VALUES 
                            (
                                    :p_numero_venta,
                                    :p_codigo_tipo_comprobante, 
                                    :p_numero_serie, 
                                    :p_numero_documento, 
                                    :p_codigo_cliente, 
                                    :p_fecha_venta, 
                                    :p_porcentaje_igv, 
                                    :p_sub_total, 
                                    :p_igv, 
                                    :p_total, 
                                    :p_codigo_usuario
                            );
                    ";
                
                //Preparar la sentencia
                $sentencia = $this->dblink->prepare($sql);
                
                //Asignar un valor a cada parametro
                $sentencia->bindParam(":p_numero_venta", $this->getNumeroVenta());
                $sentencia->bindParam(":p_codigo_tipo_comprobante", $this->getCodigoTipoComprobante());
                $sentencia->bindParam(":p_numero_serie", $this->getNumeroSerie());
                $sentencia->bindParam(":p_numero_documento", $this->getNumeroDocumento());
                $sentencia->bindParam(":p_codigo_cliente", $this->getCodigoCliente());
                $sentencia->bindParam(":p_fecha_venta", $this->getFechaVenta());
                $sentencia->bindParam(":p_porcentaje_igv", $this->getPorcentajeIgv());
                $sentencia->bindParam(":p_sub_total", $this->getSubTotal());
                $sentencia->bindParam(":p_igv", $this->getIgv());
                $sentencia->bindParam(":p_total", $this->getTotal());
                $sentencia->bindParam(":p_codigo_usuario", $this->getCodigoUsuario());
                
                //Ejecutar la sentencia preparada
                $sentencia->execute();
                
                
                /*INSERTAR EN LA TABLA VENTA_DETALLE*/
                $detalleVentaArray = json_decode( $this->getDetalleVenta() ); //Convertir de formato JSON a formato array
                
                
                $item = 0;
                
                foreach ($detalleVentaArray as $key => $value) { //permite recorrer el array
                    
                    $sql = "select stock, nombre from articulo where codigo_articulo = :p_codigo_articulo";
                    $sentencia = $this->dblink->prepare($sql);
                    $sentencia->bindParam(":p_codigo_articulo", $value->codigoArticulo);
		    $sentencia->execute();
                    $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
                    if ($resultado["stock"] < $value->cantidad){
                        throw new Exception("No hay stock suficiente" . "\n" . "Artículo: " . $value->codigoArticulo . " - " . $resultado["nombre"] . "\n" . "Stock actual: " . $resultado["stock"] . "\n" . "Cantidad de venta: " . $value->cantidad);
                    }
                    

                    $sql = "
                            INSERT INTO venta_detalle
                            (       numero_venta, 
                                    item, 
                                    codigo_articulo, 
                                    cantidad, 
                                    precio, 
                                    descuento1, 
                                    descuento2,
                                    importe
                            )
                                VALUES 
                            (
                                    :p_numero_venta, 
                                    :p_item, 
                                    :p_codigo_articulo, 
                                    :p_cantidad, 
                                    :p_precio, 
                                    :p_descuento1, 
                                    :p_descuento2,
                                    :p_importe
                            )
                        ";
                    
                    
                    //Preparar la sentencia
                    $sentencia = $this->dblink->prepare($sql);
                    
                    $item++;
                    
                    //Asignar un valor a cada parametro
                    $sentencia->bindParam(":p_numero_venta", $this->getNumeroVenta());
                    $sentencia->bindParam(":p_item", $item);
                    $sentencia->bindParam(":p_codigo_articulo", $value->codigoArticulo);
                    $sentencia->bindParam(":p_cantidad", $value->cantidad);
                    $sentencia->bindParam(":p_precio", $value->precio);
                    $sentencia->bindParam(":p_importe", $value->importe);
                    
                    $descuento1 = 0;
                    $descuento2 = 0;
                    
                    $sentencia->bindParam(":p_descuento1", $descuento1);
                    $sentencia->bindParam(":p_descuento2", $descuento2);
                    
                    //Ejecutar la sentencia preparada
                    $sentencia->execute();
                    
                    
                    /*ACTUALIZAR EL STOCK DE CADA ARTICULO VENDIDO*/
                    $sql = "update articulo 
                            set stock = stock - :p_cantidad 
                            where codigo_articulo = :p_codigo_articulo";
                    
                    $sentencia = $this->dblink->prepare($sql);
                    $sentencia->bindParam(":p_codigo_articulo", $value->codigoArticulo);
                    $sentencia->bindParam(":p_cantidad", $value->cantidad);
                    $sentencia->execute();
                    /*ACTUALIZAR EL STOCK DE CADA ARTICULO VENDIDO*/
                    
                    
                }
                /*INSERTAR EN LA TABLA VENTA_DETALLE*/
                
                
                //Actualizar el correlativo en +1
                $sql = "update correlativo set numero = numero + 1 where tabla = 'venta'";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->execute();
                
                //Actualizar el correlativo segun el tipo de doc (BV/FA) y la serie
                $sql = "update serie_comprobante set numero_documento = numero_documento + 1 where codigo_tipo_comprobante = :p_codigo_tipo_comprobante and numero_serie = :p_numero_serie";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->bindParam(":p_codigo_tipo_comprobante", $this->getCodigoTipoComprobante());
                $sentencia->bindParam(":p_numero_serie", $this->getNumeroSerie());
                $sentencia->execute();
                
                //Terminar la transacción
                $this->dblink->commit();
                
                return true;
            }
            
        } catch (Exception $exc) {
            $this->dblink->rollBack(); //Extornar toda la transacción
            throw $exc;
        }
        
        return false;
        
    }
    
    public function listar($fecha1, $fecha2, $tipo) {
        try {
            $sql = "select * from f_listar_venta(:p_fecha1, :p_fecha2, :p_tipo)";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_fecha1", $fecha1);
            $sentencia->bindParam(":p_fecha2", $fecha2);
            $sentencia->bindParam(":p_tipo", $tipo);
            $sentencia->execute();

            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);

            return $resultado;
            
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    public function anular($numeroVenta) {
        $this->dblink->beginTransaction();
        try {
            $sql = "update venta set estado = 'A' where numero_venta = :p_numero_venta";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_numero_venta", $numeroVenta);
            $sentencia->execute();
            
            $sql = "select codigo_articulo, cantidad from venta_detalle where numero_venta = :p_numero_venta";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_numero_venta", $numeroVenta);
            $sentencia->execute();
            
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            
            for ($i = 0; $i < count($resultado); $i++) {
                $sql = "update articulo set stock = stock + :p_cantidad where codigo_articulo = :p_codigo_articulo";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->bindParam(":p_cantidad", $resultado[$i]["cantidad"]);
                $sentencia->bindParam(":p_codigo_articulo", $resultado[$i]["codigo_articulo"]);
                $sentencia->execute();
            }
            
            //Terminar la transacción
            $this->dblink->commit();
            
            return true;
                    
        } catch (Exception $exc) {
            $this->dblink->rollBack(); //Extornar toda la transacción
            throw $exc;
        }
    }

}
