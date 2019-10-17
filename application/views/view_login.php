<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="keyword" content="Aplicación para la Gestión de Servicios Energéticos - AGSE">
  <link rel="shortcut icon" href="<?php echo ESTILOS;?>img/logo-big.png">

  <title>Login Page | <?php echo TITULO;?></title>
  <!-- Bootstrap CSS -->
  <link href="<?php echo ESTILOS;?>css/bootstrap.min.css" rel="stylesheet">
  <!-- bootstrap theme -->
  <link href="<?php echo ESTILOS;?>css/bootstrap-theme.css" rel="stylesheet">
  <!--external css-->
  <!-- font icon -->
  <link href="<?php echo ESTILOS;?>css/elegant-icons-style.css" rel="stylesheet" />
  <link href="<?php echo ESTILOS;?>css/font-awesome.css" rel="stylesheet" />
  <!-- Custom styles -->
  <link href="<?php echo ESTILOS;?>css/style.css" rel="stylesheet">
  <link href="<?php echo ESTILOS;?>css/style-responsive.css" rel="stylesheet" />
  <link href="<?php echo ESTILOS;?>css-loader-master/dist/css-loader.css" rel="stylesheet" />
  <script src="<?php echo ESTILOS.'js/jquery-3.2.1.min.js'?>"></script>
  <script src="<?php echo ESTILOS.'js/bootstrap.min.js'?>"></script>
  <script src="<?php echo ESTILOS.'js/bootbox.js'?>"></script>
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 -->
  <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->

    <!-- =======================================================
      Theme Name: NiceAdmin
      Theme URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
      Author: BootstrapMade
      Author URL: https://bootstrapmade.com
    ======================================================= -->
    <script type="text/javascript"> 
$(document).ready(function() 
{
  
  $('#formulario').submit(function()
  {
$("#sesion").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active" );
  $.ajax({
    type: 'POST',
     url: $(this).attr('action'),
    data: $(this).serialize(),
    success: function(data) {
      //alert(data);
      if (data == 1)
      {
          $("#sesion").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
        bootbox.alert({
            title:'Datos Incorrectos',
            message: "El usuario o clave son incorrectas. Inténtelo de Nuevo",
            size: 'large'
        });
      }

      if(data==7){
         $("#sesion").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
        bootbox.alert({
          title:'Usuario no encontrado',
            message: "El usuario no se encuentra registrado en la base de datos",
            size: 'large'
        });
        
      }
      
      if(data == 6){
        
       $("#sesion").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
        bootbox.alert({
          title:'Seguridad',
            message: "El usuario ha sido bloqueado por seguridad",
            size: 'large'
        });
      }
       if (data == 9)
      {
          $("#sesion").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
        bootbox.alert({
          title:'Oficina',
            message: "Actualmente la oficina no se encuentra disponible por lo que no es posible iniciar sesión",
            size: 'large'
        });
      }         
      
      if (data == 2)
      {
          $("#sesion").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
      url = "<?php echo base_url('Principal#/Dashboard/') ?>";
      $(location).attr('href',url);
      }
      
      
    }
    })
      return false;
  }); 
   
});
</script>
</head>

<body class="login-img3-body">

  <div class="container">

    <form class="login-form" method="POST" action="<?=site_url('Login/accesando')?>" name="formulario" id="formulario" accept-charset="UTF-8">
      <div class="login-wrap">
        <p class="login-img"><i class="icon_lock_alt"></i></p>
        <div class="input-group">
          <span class="input-group-addon"><i class="icon_profile"></i></span>
          <input type="text" class="form-control" name="usuario" id="usuario" placeholder="Nombre de Usuario o Correo Electrónico" autofocus>
        </div>
        <div class="input-group">
          <span class="input-group-addon"><i class="icon_key_alt"></i></span>
          <input type="password" name="password" id="password" class="form-control" placeholder="Clave o Contraseña">
        </div>
        <label class="checkbox">
                <input type="checkbox" value="remember-me"> Remember me
                <span class="pull-right"> <a href="#"> Forgot Password?</a></span>
            </label>
        <button class="btn btn-primary btn-lg btn-block" type="submit"><i class="fa fa-sign-in"></i> Iniciar Sesión</button>
        <!--button class="btn btn-info btn-lg btn-block" type="submit">Signup</button-->
      </div>
    </form>
    <div class="text-right">
      <div class="credits">
          <!--
            All the links in the footer should remain intact.
            You can delete the links only if you purchased the pro version.
            Licensing information: https://bootstrapmade.com/license/
            Purchase the pro version form: https://bootstrapmade.com/buy/?theme=NiceAdmin
          -->
          Designed by <a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2019</a>
        </div>
    </div>
  </div>


</body>
<div id="sesion" class="loader loader-default"  data-text="Estamos Iniciando su Sesión, Por Favor Espere..."></div>
</html>
