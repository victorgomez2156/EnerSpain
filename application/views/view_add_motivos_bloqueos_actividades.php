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
 <div ng-controller="Controlador_Motivos_Bloqueos_Actividades as vm">
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-ban"></i> Registro de Motivos de Bloqueos Actividades</h3>
            <ol class="breadcrumb">
             <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>             
              <li><i class="fa fa-ban"></i>Registro de Motivos de Bloqueos Actividades</li>
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
                      <label for="fullname" class="control-label col-lg-2">Descripción del Motivo de Bloqueo <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class=" form-control" id="DesMotBloAct" name="DesMotBloAct" type="text" required ng-model="vm.fdatos.DesMotBloAct"/>
                      </div>
                    </div>                   
                  
                   <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                        <button class="btn btn-primary" type="submit" ng-show="vm.fdatos.CodMotBloAct==undefined||vm.fdatos.CodMotBloAct==null||vm.fdatos.CodMotBloAct==''" ng-disabled="register_form.$invalid">Crear</button>
                        <button class="btn btn-info" type="submit" ng-show="vm.fdatos.CodMotBloAct>0" ng-disabled="register_form.$invalid">Actualizar</button>
                        <button class="btn btn-danger" type="button"  ng-click="vm.borrar()" ng-show="vm.fdatos.CodMotBloAct>0" ng-disabled="vm.Nivel==3">Borrar </button>
                        <button class="btn btn-warning" type="button" ng-click="vm.limpiar()">Limpiar</button>
                        <a class="btn btn-danger" href="#/Motivos_Bloqueos_Actividades">Regresar</a>
                      </div>
                    </div>
                    <input class="form-control " id="CodMotBloAct" name="CodMotBloAct" type="hidden" ng-model="vm.fdatos.CodMotBloAct" readonly />
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
<div id="cargando" class="loader loader-default"  data-text="Cargando Listado, Por Favor Espere..."></div>
<div id="cargando_I" class="loader loader-default"  data-text="Cargando Datos, Por Favor Espere..."></div>
<div id="crear" class="loader loader-default"  data-text="Creando o Actualizando, Por Favor Espere..."></div>

</html>
