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
 <div ng-controller="Controlador_Tarifa_Gas as vm">
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-square"></i> Registro de Tarifas Gas</h3>
            <ol class="breadcrumb">
             <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>             
              <li><i class="fa fa-square"></i>Registro de Tarifas Gas</li>
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
                      <label for="fullname" class="control-label col-lg-2">Nomenclatura de la Tarifa <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class=" form-control" id="NomTarGas" onkeyup="this.value=this.value.toUpperCase();" name="NomTarGas" maxlength="10" type="text" required ng-model="vm.fdatos.NomTarGas"/>
                      </div>
                    </div>

                     <div class="form-group ">
                      <label for="fullname" class="control-label col-lg-2">Minima Consumo Anual <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class=" form-control" id="MinConAnu" name="MinConAnu" maxlength="10" type="text" required ng-model="vm.fdatos.MinConAnu" ng-change="vm.validar_numeros(1,vm.fdatos.MinConAnu)"/>
                      </div>
                    </div> 

                    <div class="form-group ">
                      <label for="fullname" class="control-label col-lg-2">Maxima Consumo Anual <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class=" form-control" id="MaxConAnu" name="MaxConAnu" maxlength="10" type="text" required ng-model="vm.fdatos.MaxConAnu" ng-change="vm.validar_numeros(2,vm.fdatos.MaxConAnu)"/>
                      </div>
                    </div>  


                   <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                        <button class="btn btn-primary" type="submit" style="margin-bottom: 8px;" ng-show="vm.fdatos.CodTarGas==undefined||vm.fdatos.CodTarGas==null||vm.fdatos.CodTarGas==''" ng-disabled="register_form.$invalid">CREAR</button>
                        <button class="btn btn-info" type="submit" ng-show="vm.fdatos.CodTarGas>0" ng-disabled="register_form.$invalid">ACTUALIZAR</button>
                        <button class="btn btn-danger" type="button"  ng-click="vm.borrar()" ng-show="vm.fdatos.CodTarGas>0" ng-disabled="vm.Nivel==3">BORRAR</button>
                        <button class="btn btn-warning" type="button" ng-click="vm.limpiar()">LIMPIAR</button>
                        <a class="btn btn-danger" href="#/Tarifa_Gas">REGRESAR</a>
                      </div>
                    </div>
                    <input class="form-control " id="CodTarGas" name="CodTarGas" type="hidden" ng-model="vm.fdatos.CodTarGas" readonly />
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
            You can dGaste the links only if you purchased the pro version.
            Licensing information: https://bootstrapmade.com/license/
            Purchase the pro version form: https://bootstrapmade.com/buy/?theme=NiceAdmin
          -->Designed by <a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2019</a>
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
<div id="generar_key" class="loader loader-default"  data-text="Generando ApiKey, Por Favor Espere..."></div>
<div id="cargando" class="loader loader-default"  data-text="Cargando Listado de Clientes, Por Favor Espere..."></div>
<div id="cargando_I" class="loader loader-default"  data-text="Cargando Datos del Cliente, Por Favor Espere..."></div>
<div id="crear_clientes" class="loader loader-default"  data-text="Creando o Actualizando Cliente, Por Favor Espere..."></div>
<div id="comprobando_disponibilidad" class="loader loader-default"  data-text="Comprobando Disponibilidad, Por Favor Espere..."></div>
</html>
