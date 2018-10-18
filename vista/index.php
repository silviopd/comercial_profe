<?php
    if (isset($_COOKIE["loginusuario"])){
        $loginUsuario = $_COOKIE["loginusuario"];
    }else{
        $loginUsuario = "";
    }
    
    require_once '../util/funciones/definiciones.php';
    
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo C_NOMBRE_SOFTWARE; ?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="../util/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="../util/lte/css/font-awesome.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="../util/lte/css/AdminLTE.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="../util/lte/plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
    <!-- box-msg -->
    <link href="../util/bootstrap/css/box-msg.css" rel="stylesheet" type="text/css" />

  </head>
  <body class="login-page">
    <div class="login-box">
      <div class="login-logo">
          <a href="../../index2.html"><h3><?php echo C_NOMBRE_SOFTWARE; ?></h3></a>
      </div><!-- /.login-logo -->

      <div class = "row">
        <div class = "col-xs-3">
          <div class="login-box-image">
              <img src="../imagenes/logo2.jpg" style="width: 100%; height: 210px"/>
          </div>
        </div>
        <div class = "col-xs-1">
        </div>
        <div class = "col-xs-4">
          <div class="login-box-body">
            <p class="login-box-msg">
            Ingrese sus datos para iniciar sesión</p>
            <form action="../controlador/sesion.iniciar.controlador.php" method="post">
              <div class="form-group has-feedback">
                <input type="email" class="form-control" placeholder="Usuario" autofocus="" name="txtusuario" required="" value="<?php echo $loginUsuario; ?>" />
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
              </div>
              <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Contraseña" name="txtclave"/>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
              </div>
              <div class="row">
                <div class="col-xs-8">    
                  <div class="checkbox icheck">
                    <label>
                        <input type="checkbox" name="chkrecordar" value="S"> Recordar datos
                    </label>
                  </div>                        
                </div><!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-success btn-block btn-flat">Ingresar</button>
                </div><!-- /.col -->
              </div>
            </form>
            <a href="#">Recuperar Contraseña</a><br>
          </div><!-- /.login-box-body -->
        </div>
    </div>

  </div><!-- /.login-box -->

    <div class="box-footer">
            El acceso proporciona información de carácter CONFIDENCIAL, por esta razón durante la sesión, todas las acciones del usuario pueden AUDITADAS; es decir, se generarán reportes de uso y son de responsabilidad absoluta del usuario. No debe compartir su usuario ni contraseña, ni proporcionar información a personas ajenas a estas, toda consulta deberá ser realizada mediante documentación sustentatoria. El USUARIO y CONTRASEÑA son personales e intransferibles. Tome sus medidas de seguridad.
    </div>

    <!-- jQuery 2.1.3 -->
    <script src="../util/jquery/jquery.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="../util/bootstrap/js/bootstrap.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="../util/lte/plugins/iCheck/icheck.js" type="text/javascript"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>