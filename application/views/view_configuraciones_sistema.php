<?php /** @package WordPress @subpackage Default_Theme  **/
header("Access-Control-Allow-Origin: *"); 
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<style>
  #sinborde {
    border: 0;
	background: inherit;
	background-color:transparent;
	width: 120px;
  }
  #sinbordeAJUST {
    border: 0;
	background: inherit;
	background-color:transparent;
  }
</style>
<body>
 <div ng-controller="Controlador_Configuraciones_Sistemas as vm">
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-gears"></i> Configuraciones del Sistema</h3>
            <ol class="breadcrumb">
             <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>             
              <li><i class="fa fa-gears"></i>Configuraciones del Sistema</li>
               <li><i class="fa fa-clock-o"></i><b style="color:red;">Ultima Actualización: {{vm.fdatos.fecha_ultima_actualizacion}}</b></li>
            </ol>
          </div>
        </div>
        <!-- Form validations -->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
             
              <div class="panel-body">
                <div class="form">
                  <form class="form-validate form-horizontal " id="register_form" name="register_form" ng-submit="submitForm($event)">
                    <div class="form-group ">
                      <label for="fullname" class="control-label col-lg-2">Nombre del Sistema <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class=" form-control" id="nombre_sistema" name="nombre_sistema" type="text" required ng-model="vm.fdatos.nombre_sistema"  required/>
                      </div>
                    </div>
                     <div class="form-group ">
                      <label for="fullname" class="control-label col-lg-2">Logo <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class=" form-control" id="logo" name="logo" type="text" required ng-model="vm.fdatos.logo" required/>
                      </div>
                    </div>
                    <div class="form-group ">
                      <label for="address" class="control-label col-lg-2">Teléfono <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class=" form-control" id="telefono" name="telefono" type="text" required ng-model="vm.fdatos.telefono" required/>
                      </div>
                    </div>
                    <div class="form-group ">
                      <label for="username" class="control-label col-lg-2">Dirección <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class="form-control " id="direccion" name="direccion" type="text" required ng-model="vm.fdatos.direccion" required/>
                        
                      </div>
                    </div>
                    <div class="form-group ">
                      <label for="password" class="control-label col-lg-2">Version Sistema<span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class="form-control " id="version_sistema" name="version_sistema" type="text" ng-model="vm.fdatos.version_sistema " required/>
                      </div>
                    </div>
                    <div class="form-group ">
                      <label for="confirm_password" class="control-label col-lg-2">Correo Principal <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class="form-control " id="correo_principal" name="correo_principal" type="email" ng-model="vm.fdatos.correo_principal" required/>
                      </div>
                    </div>
                     <div class="form-group ">
                      <label for="confirm_password" class="control-label col-lg-2">Correo Copia <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class="form-control " id="correo_cc" name="correo_cc" type="email" ng-model="vm.fdatos.correo_cc"/>
                      </div>
                    </div>
                    <div class="form-group ">
                      <label for="confirm_password" class="control-label col-lg-2">URL Sistema <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class="form-control " id="url" name="url" type="text" ng-model="vm.fdatos.url" required/>
                      </div>
                    </div>

                    <header><div align="center">Para Configuración de Envio de Correo Electrónico</div></header>
                    <hr>
                    <div class="form-group ">
                      <label for="confirm_password" class="control-label col-lg-2">Protocolo <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class="form-control " id="protocol" name="protocol" type="text" ng-model="vm.fdatos.protocol" required/>
                      </div>
                    </div>
                     <div class="form-group ">
                      <label for="confirm_password" class="control-label col-lg-2">SMTP HOST <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class="form-control " id="smtp_host" name="smtp_host" type="text" ng-model="vm.fdatos.smtp_host" required/>
                      </div>
                    </div>
                    <div class="form-group ">
                      <label for="confirm_password" class="control-label col-lg-2">SMTP USER <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class="form-control " id="smtp_user" name="smtp_user" type="text" ng-model="vm.fdatos.smtp_user" required/>
                      </div>
                    </div>
                     <div class="form-group ">
                      <label for="confirm_password" class="control-label col-lg-2">SMTP CONTRASEÑA <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class="form-control " id="smtp_pass" name="smtp_pass" type="password" ng-model="vm.fdatos.smtp_pass" required/>
                      </div>
                    </div>
                    <div class="form-group ">
                      <label for="confirm_password" class="control-label col-lg-2">SMTP PORT <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class="form-control " id="smtp_port" name="smtp_port" type="text" ng-model="vm.fdatos.smtp_port" required />
                      </div>
                    </div>
            <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">                        
                        <button class="btn btn-info" type="submit" ng-disabled="register_form.$invalid">Actualizar Configuración</button> 
                      </div>
                    </div>
                    <input class="form-control " id="huser" name="huser" type="hidden" ng-model="vm.fdatos.id" readonly />
                  </form>
                </div>
              </div>
            </section>
          </div>
        </div>
        <!-- page end-->
      </section>
    </section>
    <!--main content end-->
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
  </section>
</div>
  <!-- container section end -->
<script type="text/javascript" src="application/libraries/estilos/js/jquery.validate.min.js"></script>
  <!-- custom form validation script for this page-->
  <script src="application/libraries/estilos/js/form-validation-script.js"></script>
  <!--custome script for all page-->
  <!--script src="application/libraries/estilos/js/scripts.js"></script-->
</body>

<div id="cargando" class="loader loader-default"  data-text="Cargando Datos, Por Favor Espere..."></div>
<div id="actualizando" class="loader loader-default"  data-text="Actualizando Configuración, Por Favor Espere..."></div>
</html>
