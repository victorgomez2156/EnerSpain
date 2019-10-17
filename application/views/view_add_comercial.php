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
 <div ng-controller="Controlador_Comercial as vm">
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-users"></i> Registro Comercial</h3>
            <ol class="breadcrumb">
             <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>             
              <li><i class="fa fa-users"></i>Registro Comercial</li>
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
                      <label for="fullname" class="control-label col-lg-2">NIF del Comercial <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class=" form-control" id="NIFCom" name="NIFCom" type="text" required ng-model="vm.fdatos.NIFCom" ng-blur="vm.buscar_nif_comercial()"/>
                      </div>
                    </div>
                    <div class="form-group ">
                      <label for="fullname" class="control-label col-lg-2">Nombre del Comercial <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class=" form-control" id="NomCom" name="NomCom" type="text" required ng-model="vm.fdatos.NomCom"/>
                      </div>
                    </div>
                     
                    <div class="form-group ">
                      <label for="address" class="control-label col-lg-2">Teléfono Fijo del Comercial <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class=" form-control" id="TelFijCom" name="TelFijCom" type="text" required ng-model="vm.fdatos.TelFijCom"/>                        
                      </div>
                    </div>
                    <div class="form-group ">
                      <label for="username" class="control-label col-lg-2">Teléfono Celular del Comercial <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class="form-control " id="TelCelCom" name="TelCelCom" type="text" required ng-model="vm.fdatos.TelCelCom"/>                                               
                      </div>
                    </div>
                    <div class="form-group ">
                      <label for="username" class="control-label col-lg-2">Email del Comercial <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class="form-control " id="EmaCom" name="EmaCom" type="email" required ng-model="vm.fdatos.EmaCom"/>                                               
                      </div>
                    </div>
                    <div class="form-group ">
                      <label for="username" class="control-label col-lg-2">Cargo Comercial <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class="form-control " id="CarCom" name="CarCom" type="text" required ng-model="vm.fdatos.CarCom"/>                                               
                      </div>
                    </div>
                    <div class="form-group ">
                      <label for="username" class="control-label col-lg-2">Porcenjate de Comisión Asignado <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class="form-control " id="PorComCom" name="PorComCom" type="text" required ng-model="vm.fdatos.PorComCom"/>                                               
                      </div>
                    </div>
                     <div class="form-group ">
                      <label for="username" class="control-label col-lg-2">Observación Comercial <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <textarea class="form-control " id="ObsCom" name="ObsCom" rows="5" required ng-model="vm.fdatos.ObsCom"></textarea>                                             
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                        <button class="btn btn-primary" type="submit" ng-show="vm.fdatos.CodCom==undefined||vm.fdatos.CodCom==null||vm.fdatos.CodCom==''" ng-disabled="register_form.$invalid">Crear Comercial</button>
                        
                        <button class="btn btn-info" type="submit" ng-show="vm.fdatos.CodCom>0" ng-disabled="register_form.$invalid">Actualizar Comercial</button>
                        <button class="btn btn-danger" type="button"  ng-click="vm.borrar()" ng-show="vm.fdatos.CodCom>0" ng-disabled="vm.Nivel==3">Borrar Registro</button>
                        <button class="btn btn-warning" type="button" ng-click="vm.limpiar()">Limpiar</button>
                        <a class="btn btn-danger" href="#/Comercial">Regresar</a>
                      </div>
                    </div>
                    <input class="form-control " id="huser" name="huser" type="hidden" ng-model="vm.fdatos.CodCom" readonly />
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
<div id="cargando" class="loader loader-default"  data-text="Cargando Listado Comercial, Por Favor Espere..."></div>
<div id="cargando_I" class="loader loader-default"  data-text="Cargando Datos Comercial, Por Favor Espere..."></div>
<div id="crear_clientes" class="loader loader-default"  data-text="Creando o Actualizando Comercial, Por Favor Espere..."></div>
</html>
