<?php
    require_once 'sesion.validar.vista.php';
    
    require_once '../util/funciones/definiciones.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo C_NOMBRE_SOFTWARE; ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	
        <?php
	    include 'estilos.vista.php';
	?>

    </head>
    <body class="skin-green layout-top-nav">
        <!-- Site wrapper -->
        <div class="wrapper">

            <?php
                include 'cabecera.vista.php';
            ?>

            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1 class="text-bold text-black" style="font-size: 20px;">Registro de Ventas</h1>
                </section>

		<small>
                    <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <form class="form-inline">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="rbtipo" id="rbtipo" value="1" checked="" >
                                              Solo Hoy
                                            </label>
                                        </div>
                                        &nbsp;&nbsp;
                                        <div class="radio">
                                            <label>
                                              <input type="radio" name="rbtipo" id="rbtipo" value="2">
                                              Rango de Fechas
                                            </label>
                                        </div>
                                        &nbsp;&nbsp;
                                        <div class="radio">
                                            <label>
                                              <input type="radio" name="rbtipo" id="rbtipo" value="3">
                                              Todas las Fechas
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                &nbsp;
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="input-group">
                                            <label>Desde:&nbsp;</label>
                                            <div class="input-group">
                                              <input type="date" id="txtfecha1" class="form-control input-sm" value="<?php echo date('Y-m-d'); ?>"/>
                                            </div><!-- /.input group -->
                                        </div><!-- /.form group -->
                                        &nbsp;&nbsp;
                                        <div class="input-group">
                                            <label>Hasta:&nbsp;</label>
                                            <div class="input-group">
                                                <input type="date" id="txtfecha2" class="form-control input-sm" value="<?php echo date('Y-m-d'); ?>"/>
                                            </div><!-- /.input group -->
                                        </div><!-- /.form group -->

                                        &nbsp;
                                        <button type="button" class="btn btn-primary btn-sm" id="btnfiltrar">Filtrar datos</button>

                                        &nbsp;
                                        <button type="button" class="btn btn-danger btn-sm" id="btnagregar">Agregar nueva venta</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                    </div>
                    <p>
                        <div class="box box-success">
                            <div class="box-body">
                                <div id="listado">
                                    
                                </div>
                            </div>
                        </div>
                    </p>
                </section>
		</small>
            </div>
        </div><!-- ./wrapper -->
	<?php
	    include 'scripts.vista.php';
	?>
	
	<!--JS-->
        <script src="js/venta.listado.js" type="text/javascript"></script>

    </body>
</html>