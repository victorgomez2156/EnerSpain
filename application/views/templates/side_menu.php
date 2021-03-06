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
                            <span class="username"><b style="color: black;"><?php echo $this->NombreMostrar;?></b></span>
                            <b class="caret"></b>
                        </a> 
            <ul class="dropdown-menu extended logout">
              <div class="log-arrow-up"></div>
              <!--li class="eborder-top">
                <a href="#"><i class="icon_profile"></i> My Profile</a>
              </li--> 
              <li>
                <a href="javascript:void;" id="cerrar-sesion" data-username="<?php $this->NombreMostrar;?> " data-end-url="<?php echo 'Login/desconectar';?>" onclick="javascript:void(0)"><span class="fa fa-sign-in"></span> Cerrar Sesi??n</a>
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
    <aside ng-controller="CtrlMenuController as Menu">
      <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu">
          
          <li class="" ng-show="Menu.Dashboard==true">
            <a href="#/Dashboard">
              <i class="fa fa-home"></i><span>Dashboard</span></a>
          </li>

          <li class="sub-menu" ng-show="Menu.Comercializadora==true">
            <a href="javascript:;" class="">
              <i class="fa fa-bus"></i>
              <span>Comercializadora</span>
              <span class="menu-arrow arrow_carrot-right"></span>
            </a>
            <ul class="sub">            	
              <li ng-show="Menu.Comercializadora_DatosBasicos==true"><a href="#/Comercializadora"> Datos B??sicos</a></li>
              <li ng-show="Menu.Comercializadora_Productos==true"><a href="#/Productos"> Productos</a></li>
              <li ng-show="Menu.Comercializadora_Anexos==true"><a href="#/Anexos"> Anexos</a></li>
              <li ng-show="Menu.Comercializadora_ServiciosEspeciales==true"><a href="#/Servicios_Adicionales"> Servicios Especiales</a></li>         
            </ul>
          </li>

            <li class="sub-menu" ng-show="Menu.Clientes==true">
            <a href="javascript:;" class="">
              <i class="fa fa-user"></i>
              <span>Clientes</span>
              <span class="menu-arrow arrow_carrot-right"></span>
            </a>
            <ul class="sub">
              <li ng-show="Menu.Clientes_DatosBasicos==true"><a href="#/Clientes"> Datos B??sicos</a></li>
              <li ng-show="Menu.Clientes_Actividad==true"><a href="#/Actividades"> Actividad</a></li>
              <li ng-show="Menu.Clientes_DirPunSum==true"><a href="#/Puntos_Suministros"> Detalle Suministros</a></li>
              <li ng-show="Menu.Clientes_GestionesCups==true"><a href="#/Gestionar_Cups"> Gestionar Cups</a></li>  
              <li ng-show="Menu.Clientes_Contactos==true"><a href="#/Contactos"> Contactos</a></li>  
              <li ng-show="Menu.Clientes_CuentasBancarias==true"><a href="#/Cuentas_Bancarias"> Cuentas Bancarias</a></li>  
              <li ng-show="Menu.Clientes_Documentos==true"><a href="#/Documentos"> Documentos</a></li> 
                
            </ul>
          </li>

          <li class="sub-menu" ng-show="Menu.Gestion_Comercial==true">
            <a href="javascript:;" class="">
              <i class="fa fa-cube"></i>
              <span>Gesti??n Comercial</span>
              <span class="menu-arrow arrow_carrot-right"></span>
            </a>
            <ul class="sub">
              <li ng-show="Menu.Gestion_Comercial_ProCom==true"><a href="#/Propuesta_Comercial"> Propuesta Comercial</a></li>
              <li ng-show="Menu.Gestion_Comercial_Contrato==true"><a href="#/Contratos"> Contratos</a></li>
              <li ng-show="Menu.Gestion_Comercial_Activaciones==true"><a href="#/Activaciones"> Activaciones</a></li>
              <li ng-show="Menu.Gestion_Comercial_RenMas==true"><a href="#/Renovacion_Masiva"> Renovaci??n Masiva</a></li>
              <li ng-show="Menu.Gestion_Comercial_SIP==true"><a href="#/SIP"> SIPS</a></li>
              <li ng-show="Menu.Gestion_Comercial_OtrasGestiones==true"><a href="#/Otras_Gestiones"> Otras Gestiones</a></li>
              <li ng-show="Menu.Gestion_Comercial_Seguimientos==true"><a href="#/Seguimientos"> Seguimientos</a></li>
                
            </ul>
          </li>

          <li class="sub-menu" ng-show="Menu.Reportes==true">
            <a href="javascript:;" class="">
              <i class="fa fa-file"></i>
              <span>Reportes</span>
              <span class="menu-arrow arrow_carrot-right"></span>
            </a>
            <ul class="sub">
              <li ng-show="Menu.Reportes_Colaboradores==true"><a href="#/Reporte_Cups_Colaboradores">Colaboradores</a></li>
              <li ng-show="Menu.Reportes_Rueda==true"><a href="#/Rueda">Rueda</a></li>
              <li><a href="#/Rueda20">Rueda 2.0</a></li>
              <li ng-show="Menu.Reportes_ProyeccionIngresos==true"><a href="#/Proyeccion_Ingresos">Proyecci??n de Ingresos</a></li>
              <li ng-show="Menu.Reportes_IngresosReales==true"><a href="#/Ingresos_Reales">Ingresos Reales </a></li>
              <li ng-show="Menu.Reportes_IngVsProyec==true"><a href="#/Ingresos_Vs_Proyectado">Ing. Reales Vs Proyectado</a></li>
              <li ng-show="Menu.CUPSConsumos==true"><a href="#/CUPSConsumos">CUPS/Consumos</a></li>
            </ul>
        </li>
          
          <li class="sub-menu" ng-show="Menu.Configuracion==true">
            <a href="javascript:;" class="">
              <i class="fa fa-gears"></i>
              <span>Configuraci??n</span>
              <span class="menu-arrow arrow_carrot-right"></span>
            </a>
            <ul class="sub">
            	<li ng-show="Menu.Configuracion_Distribuidora==true"><a href="#/Distribuidora"> Distribuidora</a></li>
            	<li ng-show="Menu.Configuracion_Tarifas==true"><a href="#/Tarifas"> Tarifas</a></li>
            	<li ng-show="Menu.Configuracion_Colaboradores==true"><a href="#/Colaboradores"> Colaboradores</a></li>
            	<li ng-show="Menu.Configuracion_Comercial==true"><a href="#/Comercial"> Comerciales</a></li>
            	<li ng-show="Menu.Configuracion_Tipos==true"><a href="#/Tipos"> Tipos</a></li>
            	<li ng-show="Menu.Configuracion_Motivos==true"><a href="#/Motivos_Bloqueos"> Motivos</a></li>
              <li ng-show="Menu.Configuracion_Usuarios==true"><a href="#/Usuarios"> Usuarios</a></li>  
              <li ng-show="Menu.Configuracion_Logs==true"><a href="#/Logs"> Logs</a></li>          
              
              <!--li><a class="fa fa-user" href="#/Tipo_Clientes"> Tipo Clientes</a></li>
              <li><a class="fa fa-bullhorn" href="#/Tipo_Contacto"> Tipo Contacto</a></li>
              <li><a class="fa fa-flag" href="#/Tipo_Inmueble"> Tipo Inmueble</a></li>
             
              <li><a class="fa fa-industry" href="#/Sector_Cliente"> Sector Cliente</a></li> 
              <li><a class="fa fa-bookmark" href="#/Provincia"> Provincia</a></li>
              <li><a class="fa fa-child" href="#/Localidad"> Localidad</a></li>              
              <li><a class="fa fa-bank" href="#/Bancos"> Bancos</a></li>
              <li><a class="fa fa-bolt" href="#/Tarifa_Electrica"> Tarifa Electrica</a></li>
              <li><a class="fa fa-circle-o" href="#/Tarifa_Gas"> Tarifa Gas</a></li>
              <li><a class="fa fa-thermometer" href="#/Tipo_Comision"> Tipo Comisi??n</a></li>
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
    var username = "<?php echo $this->NombreMostrar;?>";
 
  $("#cerrar-sesion").on('click', function(){
    Swal.fire({title:"Cerrar Sesi??n",text:"Seguro que desea cerrar la sesi??n?",		
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