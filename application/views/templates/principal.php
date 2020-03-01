<!DOCTYPE html>
<html lang="en">
<head>
 <?php $this->load->view('view_header');?>
   <script type="text/javascript">
      /*  window.oncontextmenu = function () 
        {
            return false;
        }
        $(document).keydown(function (event)
        {
          if (event.keyCode == 123)
          {
            return false;
          }
          else if ((event.ctrlKey && event.shiftKey && event.keyCode == 73) || (event.ctrlKey && event.shiftKey && event.keyCode == 74)) 
          {
            return false;
          }
        });
         function right(e) {    
     var ano=new Date().getFullYear();
      var msg = "Esta Prohibido Usar el Click Derecho En Esta Pagina !!! ";
      if (navigator.appName == 'Netscape' && e.which == 3) 
      {
        //Swal.fire({title:"Error",text:msg,type:"error",confirmButtonColor:"#188ae2"});
          bootbox.alert({
          title:'Seguridad',
            message: "<b></b>"+msg+" <br><b>Copyright &copy; 2019 Todos los Derechos Reservados | Este Sistema Fue Desarrollado <i class='fa fa-heart-o' aria-text='true'></i> Por <a href='https://www.sistemasonline2018.com.ve' target='_blank'>Tsu. Victor Gómez</a> </b>" ,
            size: 'middle'
        });
         return false;
      }
      else if (navigator.appName == 'Microsoft Internet Explorer' && event.button==2) {
      bootbox.alert({
          title:'Seguridad',
            message: "<b></b>"+msg+" <br><b>Copyright &copy; 2019 Todos los Derechos Reservados | Este Sistema Fue Desarrollado <i class='fa fa-heart-o' aria-text='true'></i> Por <a href='https://www.sistemasonline2018.com.ve' target='_blank'>Tsu. Victor Gómez</a> </b>" ,
            size: 'middle'
        });
      return false;
      }
   return true;
}
document.onmousedown = right;*/
    </script>
</head>

<body>  

<div ng-app="appPrincipal">
  
 
  <!-- container section start -->
  <section id="container" class="">

  	<!--header start-->
  	<?php $this->load->view('templates/side_menu');?>
    <!--header end-->
      <section class="wrapper" ng-hide="!layout.loading">
        <!--overview start-->
         <!--overview start-->
        <div class="row" align="center">
          <div class="col-lg-12">
            <h3><img src="<?php echo ESTILOS;?>img/ajax-loader.gif" /><b style="color:black;"> Cargando Vista, Por Favor Espere...</b></h3>
            
          </div>
        </div></section>
 <div>
 	<ng-view/>
 </div>

   
  </section>
  <!-- container section start -->
  <input id="IdUsers" type='hidden' value="<?php echo $this->session->userdata('id');?>" readonly></input>
	<input id="NivelUsers" type='hidden' value="<?php echo $this->session->userdata('nivel');?>" readonly></input> 
	<input id="ApiKey" type='hidden' value="<?php echo $this->session->userdata('key');?>" readonly></input> 
  <input id="correo_electronico" type='hidden' value="<?php echo $this->session->userdata('correo_electronico');?>" readonly></input>  
</div>
 

  <!-- javascripts -->
  <script src="<?php echo ESTILOS;?>js/jquery.js"></script>
  <script src="<?php echo ESTILOS;?>js/jquery-ui-1.10.4.min.js"></script>
  <script src="<?php echo ESTILOS;?>js/jquery-1.8.3.min.js"></script>  
  <script src="<?php echo ESTILOS;?>js/bootstrap.min.js"></script>
  <!-- nice scroll -->
  <script src="<?php echo ESTILOS;?>js/jquery.scrollTo.min.js"></script>
  <script src="<?php echo ESTILOS;?>js/jquery.nicescroll.js" type="text/javascript"></script>

  <!-- jquery ui -->
  <script src="<?php echo ESTILOS;?>js/jquery-ui-1.9.2.custom.min.js"></script>

  <!--custom checkbox & radio-->
  <script type="text/javascript" src="<?php echo ESTILOS;?>js/ga.js"></script>
  <!--custom switch-->
  <script src="<?php echo ESTILOS;?>js/bootstrap-switch.js"></script>
  <!--custom tagsinput-->
  <script src="<?php echo ESTILOS;?>js/jquery.tagsinput.js"></script>

  <!-- colorpicker -->

  <!-- bootstrap-wysiwyg -->
  <script src="<?php echo ESTILOS;?>js/jquery.hotkeys.js"></script>
  <script src="<?php echo ESTILOS;?>js/bootstrap-wysiwyg.js"></script>
  <script src="<?php echo ESTILOS;?>js/bootstrap-wysiwyg-custom.js"></script>

  <script src="<?php echo ESTILOS;?>js/bootstrap-datepicker.js"></script>
  <script src="<?php echo ESTILOS;?>js/bootstrap-timepicker.js"></script>
  <script src="<?php echo ESTILOS;?>js/moment.js"></script>
  <script src="<?php echo ESTILOS;?>js/daterangepicker.js"></script>
  <script src="<?php echo ESTILOS;?>js/bootstrap-datetimepicker.js"></script>
  <script src="<?php echo ESTILOS;?>js/bootstrap-colorpicker.js"></script>
  <!-- ck editor -->
  <script type="text/javascript" src="<?php echo ESTILOS;?>assets/ckeditor/ckeditor.js"></script>
  <!-- custom form component script for this page-->
  <!-- custome script for all page -->
  <script src="<?php echo ESTILOS;?>js/scripts.js"></script>
  

  <script src="<?php echo ESTILOS;?>js/sweetalert2.min.js"></script>  
  <script src="<?php echo ESTILOS;?>js/jquery.maskedinput.js"></script>


<script type="text/javascript">
/*var contador = 0;
var fin_contador = 10; // Tiempo en en el que deseas que redireccione la funcion.
var iniciado = false;
function cuenta()
{
  if(contador >= fin_contador)
  {
      //window.location.href = "http://google.com.do"; 
      console.log('si');
  }
  else
  {
    document.getElementById("contador").innerHTML  = "Redireccionando en " + fin_contador + " Seg";
    fin_contador = fin_contador - 1;
  }
} 
function ini()
{
  cuenta();
  setInterval("cuenta()",1000);
}*/
/*var idleTime = 300;
$(document).ready(function () 
{
 //Increment the idle time counter every minute.
  var idleInterval = setInterval(timerIncrement, 1000); // 1 minute
  $(this).mousemove(function (e) 
  {
    idleTime = 300;
    //console.log(idleTime);
  });
  $(this).click(function (e) 
  {
    idleTime = 300;
    //console.log(idleTime);
  });
  $(this).mouseover(function (e) 
  {
    idleTime = 300;
    //console.log(idleTime);
  });
  $(this).keypress(function (e) 
  {
    idleTime = 300;
    //console.log(idleTime);
  });   
});
function timerIncrement() 
{
    idleTime = idleTime - 1;
    console.log('Tiempo Restante de Inactividad: '+idleTime);
    if(idleTime==0)
    {
      clearTimeout(idleTime);
      document.location.href = 'Login/desconectar';
    }
    if (idleTime == 10)
    {
      Swal.fire({title:"Inactividad Detectada?",text:"Estimado Usuario no hemos detectado actividad recientemente y su sesión se cerrar en: "+idleTime+" Segundos Aproximadamente. ¿Desea Mantener su sesión activa?",type:"warning",confirmButtonColor:"#31ce77",confirmButtonText:"Si, Deseo mantener la sesión activa!"}).then(function(t)
      {
        if(t.value==true)
        {                
          clearTimeout(idleTime);
          idleTime = 300;
        }
      });
    }
}*/
</script>
</body>


</html>
