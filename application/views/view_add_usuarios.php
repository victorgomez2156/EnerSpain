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
 <div ng-controller="Controlador_Empleados as vm">
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header">Registro de Usuario</h3>
            <!--<ol class="breadcrumb">
             <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>             
              <li>Registro de Usuarios</li>
            </ol>-->
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
                      <label for="fullname" class="control-label col-lg-2">Nombres <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class=" form-control" id="nombres" name="nombres" type="text" required ng-model="vm.fdatos.nombres"/>
                      </div>
                    </div>

                     <div class="form-group ">
                      <label for="fullname" class="control-label col-lg-2">Apellidos <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class=" form-control" id="apellidos" name="apellidos" type="text" required ng-model="vm.fdatos.apellidos"/>
                      </div>
                    </div>
                    <div class="form-group ">
                      <label for="address" class="control-label col-lg-2">Correo Electrónico <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class=" form-control" id="email" name="email" type="email" required ng-model="vm.fdatos.correo_electronico" ng-blur="vm.comprobar_disponibilidad_correo()"/>
                        <br>
                        <span class="label label-success" ng-show="vm.disponibilidad_email==false"><i class="fa fa-circle-check"></i> Correo Eletrónico Disponible</span>
                        <span class="label label-danger" ng-show="vm.disponibilidad_email==true"><i class="fa fa-close"></i> Correo Eletrónico No Disponible</span>
                      </div>
                    </div>
                    <div class="form-group ">
                      <label for="username" class="control-label col-lg-2">Username <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class="form-control " id="username" name="username" type="text" required ng-model="vm.fdatos.username" ng-blur="vm.comprobar_disponibilidad_username()"/>
                        <br>
                        <span class="label label-success" ng-show="vm.disponibilidad_username==false"><i class="fa fa-circle-check"></i> Nombre de Usuario Disponible</span>
                        <span class="label label-danger" ng-show="vm.disponibilidad_username==true"><i class="fa fa-close"></i> Nombre de Usuario No Disponible</span>
                      </div>
                    </div>
                    <div class="form-group " ng-show="vm.fdatos.id==undefined||vm.fdatos.id==null||vm.fdatos.id==''">
                      <label for="password" class="control-label col-lg-2">Contraseña <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class="form-control " id="password" name="password" type="password" ng-model="vm.fdatos.contrasena"/>
                      </div>
                    </div>
                    <div class="form-group " ng-show="vm.fdatos.id==undefined||vm.fdatos.id==null||vm.fdatos.id==''">
                      <label for="confirm_password" class="control-label col-lg-2">Confirme su Contraseña <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class="form-control " id="confirm_password" name="confirm_password" type="password" ng-model="vm.fdatos.re_contrasena"/>
                      </div>
                    </div>
                    <div class="form-group ">
                      <label for="confirm_password" class="control-label col-lg-2">Rol <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <select class="form-control" id="nivel" name="nivel" required ng-model="vm.fdatos.nivel" ng-disabled="vm.Nivel==3">
                          <option value="1">Super Administrador</option>
                          <option value="2">Administrador</option>
                          <option value="3">Estandar</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group" ng-show="vm.fdatos.id==undefined||vm.fdatos.id==null||vm.fdatos.id==''">
                      <label for="confirm_password" class="control-label col-lg-2" >Api-Key <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class="form-control" id="apikey" name="apikey" type="text" required ng-model="vm.fdatos.key" readonly />
                        <br>
                        <button class="btn btn-default" type="button" ng-disabled="vm.fdatos.id>0 || vm.disabled_button==true" ng-click="vm.generar_key()"><i class="fa fa-refresh"></i> Generar ApiKey</button>
                      </div>
                    </div>
                   <div class="form-group ">
                      <label for="confirm_password" class="control-label col-lg-2">Estatus <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <select class="form-control" id="estatus" name="estatus" required ng-model="vm.fdatos.bloqueado" ng-disabled="vm.Nivel==3">
                          <option value="1">Activo</option>
                          <option value="2">Bloqueado</option>
                          <option value="3">Intentos Fallidos</option>
                        </select>
                      </div>
                    </div>



          <header class="panel-heading">Asignación de Controladores</header>
          <div class="col-lg-12" ng-init="vm.cargar_controladores()">
            <section class="panel">
              <table class="table table-striped table-advance table-hover">
                <tbody>
                  <tr>
                    <th><i class="icon_profile"></i> Controlador</th>                    
                    <th><i class="icon_cogs"></i> Action</th>
                  </tr>
                  <tr ng-show="vm.tController==undefined || vm.tController==false"> 
                     <td colspan="6" align="center"><div class="td-usuario-table">No hay información disponible</div></td>           
                  </tr>
                  <tr ng-repeat="dato in vm.tController | filter:paginatecontroller | filter:search" ng-class-odd="odd">
                    <td>{{dato.controller}}</td>                                    
                    <td>
                      <div class="btn-group">
                       <button class="btn btn-success" type="button" ng-show="!vm.select_controller[dato.id]" ng-click="vm.agregar_controlador($index,dato.id,dato)"><i class="icon_check"></i></button>                        
                        <button class="btn btn-danger" type="button" ng-show="vm.select_controller[dato.id]" ng-disabled="vm.Nivel==3" ng-click="vm.quitar_controlador($index,dato.id,dato)"><i class="icon_close_alt2"></i></button>                        
                      </div>
                    </td>
                  </tr>
                 
                </tbody>
              </table>             
            </section>
          </div>
            <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                        <button class="btn btn-info" type="submit" ng-show="vm.fdatos.id==undefined||vm.fdatos.id==null||vm.fdatos.id==''" ng-disabled="register_form.$invalid || vm.disponibilidad_username==true || vm.disponibilidad_email==true">Crear Usuario</button>
                        
                        <button class="btn btn-info" type="submit" ng-show="vm.fdatos.id>0" ng-disabled="register_form.$invalid || vm.disponibilidad_username==true || vm.disponibilidad_email==true">Actualizar Usuario</button>
                         <button class="btn btn-danger" type="button"  ng-click="vm.borrar()" ng-show="vm.fdatos.id>0" ng-disabled="vm.Nivel==3">Borrar Registro</button>
                        <button class="btn btn-warning" type="button" ng-click="vm.limpiar()">Limpiar</button>
                        <a class="btn btn-danger" href="#/Usuarios">Volver</a>
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
<div id="generar_key" class="loader loader-default"  data-text="Generando ApiKey"></div>
<div id="cargando" class="loader loader-default"  data-text="Cargando Información del Usuario"></div>
<div id="crear_usuario" class="loader loader-default"  data-text="Creando o Actualizando Usuario"></div>
<div id="comprobando_disponibilidad" class="loader loader-default"  data-text="Comprobando disponibilidad"></div>
</html>
