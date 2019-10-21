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
 <div ng-controller="Controlador_Tarifa_Electrica as vm">
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-bolt"></i> Registro de Tarifas Electricas</h3>
            <ol class="breadcrumb">
             <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>             
              <li><i class="fa fa-bolt"></i>Registro de Tarifas Electricas</li>
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
                      <label for="fullname" class="control-label col-lg-2">Tipo de Tensión <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <select class="form-control" id="opciones_anexos" name="opciones_anexos" ng-model="vm.fdatos.TipTen">
                          <option ng-repeat="opcion in vm.tension" value="{{opcion.id}}">{{opcion.nombre}}</option>                          
                        </select>
                      </div>
                    </div>
                    
                    <div class="form-group ">
                      <label for="fullname" class="control-label col-lg-2">Nomenclatura de la Tarifa <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class=" form-control" id="NomTarEle" onkeyup="this.value=this.value.toUpperCase();" name="NomTarEle" type="text" maxlength="10" required ng-model="vm.fdatos.NomTarEle"/>
                      </div>
                    </div>

                    <div class="form-group ">
                      <label for="fullname" class="control-label col-lg-2">Cantidad Periodos <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class=" form-control" id="CanPerTar" name="CanPerTar" maxlength="2" type="text" required ng-model="vm.fdatos.CanPerTar" ng-change="vm.validar_numeros(1,vm.fdatos.CanPerTar)"/>
                      </div>
                    </div>

                     <div class="form-group ">
                      <label for="fullname" class="control-label col-lg-2">Minima Potencia <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class=" form-control" id="MinPotCon" name="MinPotCon" maxlength="10" type="text" required ng-model="vm.fdatos.MinPotCon" ng-change="vm.validar_numeros(2,vm.fdatos.MinPotCon)"/>
                      </div>
                    </div> 

                    <div class="form-group ">
                      <label for="fullname" class="control-label col-lg-2">Maxima Potencia <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class=" form-control" id="MaxPotCon" name="MaxPotCon" maxlength="10" type="text" required ng-model="vm.fdatos.MaxPotCon" ng-change="vm.validar_numeros(3,vm.fdatos.MaxPotCon)"/>
                      </div>
                    </div>  


                   <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                        <button class="btn btn-primary" type="submit" style="margin-bottom: 8px;" ng-show="vm.fdatos.CodTarEle==undefined||vm.fdatos.CodTarEle==null||vm.fdatos.CodTarEle==''" ng-disabled="register_form.$invalid">CREAR</button>
                        <button class="btn btn-info" type="submit" ng-show="vm.fdatos.CodTarEle>0" ng-disabled="register_form.$invalid">ACTUALIZAR</button>
                        <button class="btn btn-danger" type="button"  ng-click="vm.borrar()" ng-show="vm.fdatos.CodTarEle>0" ng-disabled="vm.Nivel==3">BORRAR</button>
                        <button class="btn btn-warning" type="button" ng-click="vm.limpiar()">LIMPIAR</button>
                        <a class="btn btn-danger" href="#/Tarifa_Electrica">REGRESAR</a>
                      </div>
                    </div>
                    <input class="form-control " id="CodTarEle" name="CodTarEle" type="hidden" ng-model="vm.fdatos.CodTarEle" readonly />
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
