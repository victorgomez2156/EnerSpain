    <header class="header white-bg">
      <div class="toggle-nav">
        <div class="icon-reorder tooltips" data-original-title="Menu Principal" data-placement="bottom"><i class="icon_menu"></i></div>
      </div>
      <!--logo start-->
      <a class="logo"><img src="<?php echo ESTILOS;?>img/logo_web_desktop.png" style="height:50px;"></a>
      <!--logo end-->
       <!--  search form start -->
      <!--div class="nav search-row" id="top_menu">       
        <ul class="nav top-menu">
          <li>
            <form class="navbar-form"> 
              <input class="form-control" placeholder="Search" type="text">
            </form>
          </li>
        </ul>       
      </div-->
     <!--  search form end -->
      <div class="top-nav notification-row">
        <!-- notificatoin dropdown start-->
        <ul class="nav pull-right top-menu">

          <!-- task notificatoin start -->
          <li id="task_notificatoin_bar" class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" onclick="cambiarModo()" href="#">
              <i class="fa fa-globe" title="Modo Oscuro / Claro"></i>
              <!--span class="badge bg-important">O / C</span-->
            </a>
            <!--ul class="dropdown-menu extended tasks-bar">
              <div class="notify-arrow notify-arrow-blue"></div>
              <li>
                <p class="blue">Sin Cartas</p>
              </li>
              <li>
                <a href="#">
                  <div class="task-info">
                    <div class="desc">Design PSD </div>
                    <div class="percent">90%</div>
                  </div>
                  <div class="progress progress-striped">
                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: 90%">
                      <span class="sr-only">90% Complete (success)</span>
                    </div>
                  </div>
                </a>
              </li>           
              <li class="external">
                <a href="#">Ver Todas las Cartas</a>
              </li>
            </ul-->
          </li>
          <!-- task notificatoin end -->
          <!-- inbox notificatoin start-->
          <!--li id="mail_notificatoin_bar" class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="icon-envelope-l"></i>
                            <span class="badge bg-important">0</span>
                        </a>
            <ul class="dropdown-menu extended inbox">
              <div class="notify-arrow notify-arrow-blue"></div>
              <li>
                <p class="blue">No tienes mensajes</p>
              </li-->
              <!--li>
                <a href="#">
                <span class="photo"><img alt="avatar" src="<?php echo ESTILOS;?>/img/avatar-mini.jpg"></span>
                                    <span class="subject">
                                    <span class="from">Greg  Martin</span>
                                    <span class="time">1 min</span>
                                    </span>
                                    <span class="message">
                                        I really like this admin panel.
                                    </span>
                                </a>
              </li-->              
              <!--li>
                <a href="#">Ver todos los mensajes</a>
              </li>
            </ul>
          </li-->
          <!-- inbox notificatoin end -->
          <!-- alert notification start-->
          <!--li id="alert_notificatoin_bar" class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">

                            <i class="icon-bell-l"></i>
                            <span class="badge bg-important">0</span>
                        </a>
            <ul class="dropdown-menu extended notification">
              <div class="notify-arrow notify-arrow-blue"></div>
              <li>
                <p class="blue">Sin notificaciones</p>
              </li-->
              <!--li>
                <a href="#">
                                    <span class="label label-primary"><i class="icon_profile"></i></span>
                                    Friend Request
                                    <span class="small italic pull-right">5 mins</span>
                                </a>
              </li-->
              <!--li>
                <a href="#">Ver todas las notificaciones</a>
              </li>
            </ul>
          </li-->
          <!-- alert notification end-->
          <!-- user login dropdown start-->
          <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="profile-ava">
                                <img alt="" height="50" width="50" src="<?php echo ESTILOS;?>img/EnerSpain.png">
                            </span>
                            <span class="username"><b style="color: black;"><?php echo $this->usuario;?></b></span>
                            <b class="caret"></b>
                        </a> 
            <ul class="dropdown-menu extended logout">
              <div class="log-arrow-up"></div>
              <!--li class="eborder-top">
                <a href="#"><i class="icon_profile"></i> My Profile</a>
              </li--> 
              <li>
                <a href="javascript:void;" id="cerrar-sesion" data-username="<?php $this->usuario;?> " data-end-url="<?php echo 'Login/desconectar';?>" onclick="javascript:void(0)"><span class="fa fa-sign-in"></span> Cerrar Sesión</a>
              </li>
              
              
            </ul>
          </li>
          <!-- user login dropdown end -->
        </ul>
        <!-- notificatoin dropdown end-->
      </div>
    </header>
    <!--header end-->

     <!--sidebar start-->
    <aside>
      <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu">
          <li class="active">
            <a href="#/Dashboard">
              <i class="icon_house_alt"></i><span>Dashboard</span></a>
          </li>

          <li class="sub-menu">
            <a href="javascript:;" class="">
              <i class="fa fa-bus"></i>
              <span>Comercializadora</span>
              <span class="menu-arrow arrow_carrot-right"></span>
            </a>
            <ul class="sub">            	
              <li><a href="#/Comercializadora"> Datos Básicos</a></li>
              <li><a href="#/Productos"> Productos</a></li>
              <li><a href="#/Anexos"> Anexos</a></li>
              <li><a href="#/Servicios_Adicionales"> Servicios Especiales</a></li>         
            </ul>
          </li>

            <li class="sub-menu">
            <a href="javascript:;" class="">
              <i class="fa fa-user"></i>
              <span>Clientes</span>
              <span class="menu-arrow arrow_carrot-right"></span>
            </a>
            <ul class="sub">
              <li><a href="#/Clientes"> Datos Básicos</a></li>
              <li><a href="#/Actividades"> Actividad</a></li>
              <li><a href="#/Puntos_Suministros"> Dirección Suministros</a></li>
              <li><a href="#/Gestionar_Cups"> Gestionar Cups</a></li>  
              <li><a href="#/Contactos"> Contactos</a></li>  
              <li><a href="#/Cuentas_Bancarias"> Cuentas Bancarias</a></li>  
              <li><a href="#/Documentos"> Documentos</a></li> 
                
            </ul>
          </li>

          <li class="sub-menu">
            <a href="javascript:;" class="">
              <i class="fa fa-cube"></i>
              <span>Gestión Comercial</span>
              <span class="menu-arrow arrow_carrot-right"></span>
            </a>
            <ul class="sub">
              <li><a href="#/Propuesta_Comercial"> Propuesta Comercial</a></li>
              <li><a href="#/Contratos"> Contratos</a></li>
              <li><a href="#/Renovacion_Masiva"> Renovación Masiva</a></li>
              <li><a href="#/Otras_Gestiones"> Otras Gestiones</a></li>
              <li><a href="#/Seguimientos"> Seguimientos</a></li>
                
            </ul>
          </li>

          <li class="sub-menu">
            <a href="javascript:;" class="">
              <i class="fa fa-file"></i>
              <span>Reportes</span>
              <span class="menu-arrow arrow_carrot-right"></span>
            </a>
            <ul class="sub">
              <li><a href="#/Reporte_Cups_Colaboradores">Colaboradores</a></li>
              <li><a href="#/Rueda">Rueda</a></li>
              <li><a href="#/Proyeccion_Ingresos">Proyección de Ingresos</a></li>
              <li><a href="#/Ingresos_Reales">Ingresos Reales </a></li>
              <li><a href="#/Ingresos_Vs_Proyectado">Ing. Reales Vs Proyectado</a></li>
            </ul>
        </li>
          
          <li class="sub-menu">
            <a href="javascript:;" class="">
              <i class="icon_cogs"></i>
              <span>Configuración</span>
              <span class="menu-arrow arrow_carrot-right"></span>
            </a>
            <ul class="sub">
            	<li><a href="#/Distribuidora"> Distribuidora</a></li>
            	<li><a href="#/Tarifas"> Tarifas</a></li>
            	<li><a href="#/Colaboradores"> Colaboradores</a></li>
            	<li><a href="#/Comercial"> Comerciales</a></li>
            	<li><a href="#/Tipos"> Tipos</a></li>
            	<li><a href="#/Motivos_Bloqueos"> Motivos</a></li>
              <li><a href="#/Usuarios"> Usuarios</a></li>  
              <li><a href="#/Logs"> Logs</a></li>          
              
              <!--li><a class="fa fa-user" href="#/Tipo_Clientes"> Tipo Clientes</a></li>
              <li><a class="fa fa-bullhorn" href="#/Tipo_Contacto"> Tipo Contacto</a></li>
              <li><a class="fa fa-flag" href="#/Tipo_Inmueble"> Tipo Inmueble</a></li>
             
              <li><a class="fa fa-industry" href="#/Sector_Cliente"> Sector Cliente</a></li> 
              <li><a class="fa fa-bookmark" href="#/Provincia"> Provincia</a></li>
              <li><a class="fa fa-child" href="#/Localidad"> Localidad</a></li>              
              <li><a class="fa fa-bank" href="#/Bancos"> Bancos</a></li>
              <li><a class="fa fa-bolt" href="#/Tarifa_Electrica"> Tarifa Electrica</a></li>
              <li><a class="fa fa-circle-o" href="#/Tarifa_Gas"> Tarifa Gas</a></li>
              <li><a class="fa fa-thermometer" href="#/Tipo_Comision"> Tipo Comisión</a></li>
              <li><a class="fa fa-universal-access" href="#/Tipo_Vias"> Tipo Via</a></li>
              <li><a class="fa fa-ban" href="#/Motivos_Bloqueos"> Motivos Clientes</a></li>
              <li><a class="fa fa-ban" href="#/Motivos_Bloqueos_Actividades"> Motivos Actividades</a></li>                 
              <li><a class="fa fa-ban" href="#/Motivos_Bloqueos_Puntos_Suministros"> Motivos Puntos Sum</a></li>
              <li><a class="fa fa-ban" href="#/Motivos_Bloqueos_Comercializadora"> Motivos Comerci</a></li>
              <li><a class="fa fa-ban" href="#/Motivos_Bloqueos_Contacto"> Motivos Contacto</a></li>
              <li><a class="fa fa-gears" href="#/Configuracion_Sistema"> Configuraciones Sistema</a></li-->
            </ul>
          </li>          
        </ul>
        <!-- sidebar menu end-->
      </div>
    </aside>
    <!--sidebar end-->
    <script type="text/javascript"> 
      function cambiarModo() { 
        var cuerpoweb = document.body; 
        cuerpoweb.classList.toggle("oscuro"); 
      } 
    </script>

    
     <script>

$(function(){
    var username = "<?php echo $this->usuario;?>";
 
  $("#cerrar-sesion").on('click', function(){
    Swal.fire({title:"Cerrar Sesión",text:"Seguro que desea cerrar la sesión?",		
		type:"question",
		showCancelButton:!0,
		confirmButtonColor:"#31ce77",
		cancelButtonColor:"#f34943",
		confirmButtonText:"OK"}).then(function(t)
		{
	        if(t.value==true)
	        {
	           document.location.href = 'Login/desconectar';
	        }
	        else
	        {
	            console.log('Cancelando ando...');
	        }
	    });
  });
}); 
 
</script>