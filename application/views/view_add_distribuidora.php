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
 <div ng-controller="Controlador_Distribuidora as vm">
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header" ng-show="vm.fdatos.CodDist==undefined">Registro de Distribuidora</h3><h3 class="page-header" ng-show="vm.fdatos.CodDist>0"><i class="fa fa-cube"></i> Actualizando Distribuidora</h3>
            <!--<ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="#/Dashboard"> Dashboard</a></li>             
              <li ng-show="vm.fdatos.CodDist==undefined"><i class="fa fa-cube"></i>Registro de Distribuidora</li><li ng-show="vm.fdatos.CodDist>0"><i class="fa fa-cube"></i>Actualizando Distribuidora</li>
            </ol>-->
          </div>
        </div>
        <!-- Form validations -->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
             
              <div class="panel-body">
                <div class="form">
                  <form id="register_form" name="register_form" ng-submit="submitForm($event)">
                      
                      
                      <div class="col-12 col-sm-6">
                        <div class="form">                          
                        <div class="form-group">
                        <label class="font-weight-bold nexa-dark" style="color:black;">CIF <b style="color:red;">(*)</b></label>
                        <input type="text" class="form-control" ng-model="vm.fdatos.NumCifDis" maxlength="25"  placeholder="* B12345678"/>
                        </div>
                        </div>
                      </div>       
                       
                       <div class="col-12 col-sm-6">
                         <div class="form">                          
                         <div class="form-group">
                         <label class="font-weight-bold nexa-dark" style="color:black;">Raz??n Social <b style="color:red;">(*)</b></label>
                         <input type="text" class="form-control" ng-model="vm.fdatos.RazSocDis"  required placeholder="* Raz??n Social" ng-change="vm.misma_comercial()" ng-disabled="vm.disabled_form==1"/>                       
                         </div>
                         </div>
                       </div>  
                      
                      <div class="col-12 col-sm-6">
                        <div class="form">                          
                        <div class="form-group">
                        <label class="font-weight-bold nexa-dark" style="color:black;">Nombre Comercial <b style="color:red;">(*)</b></label>
                        <input type="text" class="form-control" ng-model="vm.fdatos.NomComDis"  ng-disabled="vm.fdatos.misma_razon==false||vm.disabled_form==1" required placeholder="* Nombre Comercial"/>
                        </div>
                        </div>
                      </div>       
                       
                    <div class="col-12 col-sm-6">
                      <div class="form">                          
                      <div class="form-group">
                      <label class="font-weight-bold nexa-dark" style="color:black;">Distinto a Raz??n Social</label>
                      <input type="checkbox" class="form-control" ng-model="vm.fdatos.misma_razon" ng-disabled="vm.disabled_form==1" ng-click="vm.misma_razon(vm.fdatos.misma_razon)"/>       
                      </div>
                      </div>
                    </div>

                      <div class="col-12 col-sm-4">
                        <div class="form">                          
                        <div class="form-group">
                        <label class="font-weight-bold nexa-dark" style="color:black;">Tel??fono Fijo</label>
                        <input type="text" class="form-control" ng-model="vm.fdatos.TelFijDis" maxlength="9" ng-change="vm.validarnumero(vm.fdatos.TelFijDis)" placeholder="Tel??fono Fijo" ng-disabled="vm.disabled_form==1"/>
                        </div>
                        </div>
                      </div>       
                       
                       <div class="col-12 col-sm-4">
                         <div class="form">                          
                         <div class="form-group">
                         <label class="font-weight-bold nexa-dark" style="color:black;"> Correo El??ctronico</label>
                         <input type="email" class="form-control" ng-model="vm.fdatos.EmaDis"  maxlength="50" placeholder="Correo El??ctronico" ng-disabled="vm.disabled_form==1"/>                       
                         </div>
                         </div>
                       </div> 

                        <div class="col-12 col-sm-4">
                         <div class="form">                          
                         <div class="form-group">
                         <label class="font-weight-bold nexa-dark" style="color:black;"> Prefijo CUPs</label>
                         <input type="text" class="form-control" ng-model="vm.fdatos.PreCups"  maxlength="50" placeholder="Prefijo CUPs" ng-disabled="vm.disabled_form==1"/>                       
                         </div>
                         </div>
                       </div> 

                        <div class="col-12 col-sm-6">
                         <div class="form">                          
                         <div class="form-group">
                         <label class="font-weight-bold nexa-dark" style="color:black;"> P??gina Web</label>
                         <input type="text" class="form-control" ng-model="vm.fdatos.PagWebDis"  maxlength="50" placeholder="P??gina Web" ng-disabled="vm.disabled_form==1"/>                       
                         </div>
                         </div>
                       </div>

                       <div class="col-12 col-md-6">
                         <div class="form">                          
                         <div class="form-group">
                         <label class="font-weight-bold nexa-dark" style="color:black;"> Persona Contacto</label>
                         <input type="text" class="form-control" ng-model="vm.fdatos.PerConDis"  maxlength="100" placeholder="Persona Contacto" ng-disabled="vm.disabled_form==1"/>                       
                         </div>
                         </div>
                       </div>                       
                     
                    <div style="margin-top: 8px;">
                         <div align="center"><label class="font-weight-bold nexa-dark" style="color:#6d6e71;"><b>Tipos de Suministro</b></label></div></div>
                        
                        <div class="col-12 col-sm-6">
                         <div class="form">                          
                         <div class="form-group">
                         <label class="font-weight-bold nexa-dark" style="color:black;">SUMINISTRO EL??CTRICO</label>
                          <input type="checkbox" class="form-control" name="SerEle" ng-model="vm.SerEle" ng-disabled="vm.disabled_form==1"/>
                         </div>
                         </div>
                         </div>
                        <div class="col-12 col-sm-6">
                         <div class="form">                          
                         <div class="form-group">
                         <label class="font-weight-bold nexa-dark" style="color:black;">SUMINISTRO GAS</label>
                          <input type="checkbox" class="form-control" name="SerGas" ng-model="vm.SerGas" ng-disabled="vm.disabled_form==1"/>
                         </div>
                         </div>
                         </div>

                         
                         <div class="form">                          
                         <div class="form-group">
                         <label class="font-weight-bold nexa-dark" style="color:black;">Comentarios</label>
                         <textarea class="form-control" ng-model="vm.fdatos.ObsDis"  rows="5" placeholder="Comentarios" ng-disabled="vm.disabled_form==1"/></textarea>                  
                         </div>
                         </div>

                      <div class="form-group">
                      <div class="col-12 col-sm-12">                        
                        <button class="btn btn-primary" type="submit" ng-show="vm.fdatos.CodDist==undefined||vm.fdatos.CodDist==null||vm.fdatos.CodDist==''" ng-disabled="register_form.$invalid" style="margin-top: 8px;"> Guardar</button>                        
                        <button class="btn btn-success" type="submit" ng-show="vm.fdatos.CodDist>0 && vm.disabled_form==undefined" ng-disabled="register_form.$invalid"> Actualizar</button>
                        <!--button class="btn btn-danger" type="button"  ng-click="vm.borrar()" ng-show="vm.fdatos.CodDist>0 && vm.Nivel==1 && vm.disabled_form==undefined" ng-disabled="vm.Nivel==3">{{ 'DELETE' | translate }}</button-->
                        <button class="btn btn-warning" type="button" ng-click="vm.limpiar()" ng-show="vm.fdatos.CodDist==undefined||vm.fdatos.CodDist==null||vm.fdatos.CodDist==''">Limpiar</button>
                        <a class="btn btn-info" ng-click="vm.regresar()"><i class="fa fa-arrow-left"></i> Volver</a>
                      </div>
                    </div>
                    <input class="form-control " id="CodDist" name="CodDist" type="hidden" ng-model="vm.fdatos.CodDist" readonly />
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
          Dise??ado por <a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2019 - 2021</a>
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
<div id="cargando_I" class="loader loader-default"  data-text="Cargarndo Lista de Distribuidoras, por favor espere ..."></div>
<div id="Guardando" class="loader loader-default"  data-text="Guardando Distribuidora, por favor espere ..."></div>
<div id="Actualizando" class="loader loader-default"  data-text="Actualizando Distribuidora, por favor espere ..."></div>
</html>
