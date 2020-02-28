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
    $("#login").prop('disabled', true);
    $.ajax({
    type: 'POST',
     url: $(this).attr('action'),
    data: $(this).serialize(),
    success: function(data) 
    {
      $("#sesion").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
      console.log(data);
       var datax = JSON.parse(data)
      console.log(datax);
      if(datax.status==false && datax.data==1)
      {
        $("#login").prop('disabled', false);
        bootbox.alert({
        title:'¡Usuario no registrado!',
        message: "<i class='fa fa-close' ></i> "+datax.message+"",
        size: 'large'});
      }
      if(datax.status==false && datax.data==2)
      {
        $("#login").prop('disabled', false);
        bootbox.alert({
        title:'¡Usuario Bloqueado!',
        message: "<i class='fa fa-close' ></i> "+datax.message+"",
        size: 'large'});
      }
      if(datax.status==false && datax.data==3)
      {
       $("#login").prop('disabled', false);
        bootbox.alert({
        title:'¡Error en datos!',
        message: "<i class='fa fa-close' ></i> "+datax.message+"",
        size: 'large'});
      }
      if(datax.status==true && datax.data!=false)
      {
        $("#login").prop('disabled', false);
        bootbox.alert({
        title:'¡Iniciando Sesión!',
        message: "<i class='fa fa-check-circle' ></i> "+datax.message+"",
        size: 'large'});        
        url = "<?php echo base_url('Principal#/Dashboard/')?>";
        $(location).attr('href',url);
      }      
    },error:function(error)
    {
      $("#sesion").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );    
        console.log(error);
       if(error.status==401 && error.statusText=="Unauthorized")
          {
           $("#login").prop('disabled', false);
            bootbox.alert({
            title:'¡Api-Key!',
            message: "Usted no tiene un api asignado para poder realizar esta acción.",
            size: 'large'});
          }
          if(error.status==500 && error.statusText=="Internal Server Error")
          {
           $("#login").prop('disabled', false);
             bootbox.alert({
            title:'¡Error-Interno!',
            message: "Un error a ocurrido al intentar iniciar sesión por favor intente nuevamente.",
            size: 'large'});
          }
           if(error.status==404 && error.statusText=="Not Found")
          {
           $("#login").prop('disabled', false);
             bootbox.alert({
            title:'¡Metodo Invalido!',
            message: "No hemos podido localizar el metodo por favor intente nuevamente.",
            size: 'large'});
          }
           if(error.status==403 && error.statusText=="Forbidden")
          {
            $("#login").prop('disabled', false);
            bootbox.alert({
            title:'¡Seguridad!',
            message: "No esta autorizado.",
            size: 'large'});
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
                <input type="checkbox" value="remember-me" name="remember-me" id="remember-me"> Remember me
                <span class="pull-right"> <a href="forgot_password"> Forgot Password?</a></span>
            </label>
        <button class="btn btn-primary btn-lg btn-block" type="submit" id="login"><i class="fa fa-sign-in"></i> Iniciar Sesión</button>
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
