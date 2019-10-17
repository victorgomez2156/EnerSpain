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
 <div ng-controller="Controlador_Inmueble as vm">
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-bank"></i> Registro de Tipos de Inmuebles</h3>
            <ol class="breadcrumb">
             <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>             
              <li><i class="fa fa-bank"></i>Registro de Tipos de Inmuebles</li>
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
                      <label for="fullname" class="control-label col-lg-2">Descripción del Inmueble <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class=" form-control" id="DesTipInm" name="DesTipInm" type="text" required ng-model="vm.fdatos.DesTipInm"/>
                      </div>
                    </div>                    
                  
                   <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                        <button class="btn btn-primary" style="margin-top: 10px;" type="submit" ng-show="vm.fdatos.CodTipInm==undefined||vm.fdatos.CodTipInm==null||vm.fdatos.CodTipInm==''" ng-disabled="register_form.$invalid">CREAR</button>
                        <button class="btn btn-success" type="submit" ng-show="vm.fdatos.CodTipInm>0" ng-disabled="register_form.$invalid">ACTUALIZAR</button>
                        <button class="btn btn-danger" type="button"  ng-click="vm.borrar()" ng-show="vm.fdatos.CodTipInm>0" ng-disabled="vm.Nivel==3">BORRAR</button>
                        <a class="btn btn-info" href="#/Tipo_Inmueble">REGRESAR</a>
                      </div>
                    </div>
                    <input class="form-control " id="CodTipInm" name="CodTipInm" type="hidden" ng-model="vm.fdatos.CodTipInm" readonly />
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
<div id="crear_tipo_inmueble" class="loader loader-default"  data-text="Creando o Actualizado Registro, Por Favor Espere..."></div>
</html>
