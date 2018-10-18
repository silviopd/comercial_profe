<header class="main-header">               
<nav class="navbar navbar-static-top">
  <div class="container-fluid">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
      <i class="fa fa-bars"></i>
    </button>
  </div>
  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse" id="navbar-collapse">
    <ul class="nav navbar-nav">
        
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-edit"></i>&nbsp;Mantenimientos <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">Lineas</a></li>
            <li><a href="#">Categorías</a></li>
            <li><a href="articulo.vista.php">Artículos</a></li>
            <li class="divider"></li>
            <li><a href="#">Mantenimiento 4</a></li>
	    <li><a href="#">Mantenimiento n</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-laptop"></i>&nbsp;Transacciones <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="compra.listado.vista.php">Registro de Compras</a></li>
            <li><a href="venta.listado.vista.php">Registro de Ventas</a></li>
            <li class="divider"></li>
            <li><a href="#">Transacción n</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-book"></i>&nbsp;Reportes <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="articulo.reporte.vista.php">Artículos</a></li>
	    <li><a href="#">Reporte 2</a></li>
            <li class="divider"></li>
	    <li><a href="#">Reporte n</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-bar-chart-o"></i>&nbsp;Estadísticas <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
              <li><a href="grafico.php">Gráfico de prueba</a></li>
            <li><a href="#">Reporte 1</a></li>
            <li class="divider"></li>
            <li><a href="#">Reporte 3</a></li>
            <li><a href="#">Reporte n</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-gears"></i>&nbsp;Administración <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">Grupos de usaurios</a></li>
            <li><a href="#">Usuarios</a></li>
            <li class="divider"></li>
            <li><a href="#">Permisos</a></li>
          </ul>
        </li>
    </ul>
    <ul class="nav navbar-nav navbar-right">      
        
      <li class="dropdown user user-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="../imagenes/<?php echo $fotoUsuario; ?>" class="user-image" alt="User Image"/>
          <span class="hidden-xs"><?php echo $nombreUsuario; ?></span>
        </a>
        <ul class="dropdown-menu">
          <!-- User image -->
          <li class="user-header">
            <!--<img src="../imagenes/1.png" class="img-circle" alt="User Image" />-->
            <img src="../imagenes/<?php echo $fotoUsuario; ?>" class="img-circle" alt="User Image" />
            <p>
              <?php echo $nombreUsuario; ?>
              <br>
              <small><?php echo $cargoUsuario; ?></small>
            </p>
          </li>

          <!-- Menu Footer-->
          <li class="user-footer">
            <div class="pull-left">
                <a href="#" class="btn btn-default btn-flat"><i class="fa fa-key"></i> Cambiar Contraseña</a>
            </div>
            <div class="pull-right">
                <a href="../controlador/sesion.cerrar.controlador.php" class="btn btn-default btn-flat"><i class="fa fa-power-off"></i> Salir</a>
            </div>
          </li>
        </ul>
      </li>          
    </ul>
  </div><!-- /.navbar-collapse -->

  </div><!-- /.container-fluid -->
</nav>
</header>




