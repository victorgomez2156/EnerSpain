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
            <h3 class="page-header"><i class="fa fa-cube"></i> Registro de Distribuidora</h3>
            <ol class="breadcrumb">
             <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>             
              <li><i class="fa fa-cube"></i>Registro de Distribuidora</li>
            </ol>
          </div>
        </div>
        <!-- Form validations -->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
             
              <div class="panel-body">
                <div class="form">
                  <form id="register_form" name="register_form" ng-submit="submitForm($event)">
                      <div class="row">
                      <div class="col-12 col-sm-6">
                        <div class="form">                          
                        <div class="form-group">
                        <label class="font-weight-bold nexa-dark" style="color:black;">CIF <b style="color:red;">(*)</b></label>
                        <input type="text" class="form-control" ng-model="vm.fdatos.NumCifDis" maxlength="25" onkeyup="this.value=this.value.toUpperCase();" placeholder="* B12345678" ng-disabled="vm.disabled_cif==1" readonly/>
                        </div>
                        </div>
                      </div>       
                       
                       <div class="col-12 col-sm-6">
                         <div class="form">                          
                         <div class="form-group">
                         <label class="font-weight-bold nexa-dark" style="color:black;">Razón Social <b style="color:red;">(*)</b></label>
                         <input type="text" class="form-control" ng-model="vm.fdatos.RazSocDis" maxlength="50" onkeyup="this.value=this.value.toUpperCase();" required placeholder="* RAZÓN SOCIAL" ng-change="vm.misma_comercial()" ng-disabled="vm.disabled_form==1"/>                       
                         </div>
                         </div>
                       </div>  
                      
                      <div class="col-12 col-sm-6">
                        <div class="form">                          
                        <div class="form-group">
                        <label class="font-weight-bold nexa-dark" style="color:black;">Nombre Comercial <b style="color:red;">(*)</b></label>
                        <input type="text" class="form-control" ng-model="vm.fdatos.NomComDis" onkeyup="this.value=this.value.toUpperCase();" ng-disabled="vm.fdatos.misma_razon==false||vm.disabled_form==1" maxlength="25" placeholder="* NOMBRE COMERCIAL"/>
                        </div>
                        </div>
                      </div>       
                       
                    <div class="col-12 col-sm-6">
                      <div class="form">                          
                      <div class="form-group">
                      <label class="font-weight-bold nexa-dark" style="color:black;">Distinto a Razón Social</label>
                      <input type="checkbox" class="form-control" ng-model="vm.fdatos.misma_razon" ng-disabled="vm.disabled_form==1" ng-click="vm.misma_razon(vm.fdatos.misma_razon)"/>       
                      </div>
                      </div>
                    </div>

                      <div class="col-12 col-sm-4">
                        <div class="form">                          
                        <div class="form-group">
                        <label class="font-weight-bold nexa-dark" style="color:black;">Teléfono Fijo</label>
                        <input type="text" class="form-control" ng-model="vm.fdatos.TelFijDis" maxlength="9" ng-change="vm.validarnumero(vm.fdatos.TelFijDis)" placeholder="TELÉFONO FIJO" ng-disabled="vm.disabled_form==1"/>
                        </div>
                        </div>
                      </div>       
                       
                       <div class="col-12 col-sm-4">
                         <div class="form">                          
                         <div class="form-group">
                         <label class="font-weight-bold nexa-dark" style="color:black;">Email</label>
                         <input type="email" class="form-control" ng-model="vm.fdatos.EmaDis" onkeyup="this.value=this.value.toUpperCase();" maxlength="50" placeholder="EMAIL" ng-disabled="vm.disabled_form==1"/>                       
                         </div>
                         </div>
                       </div> 

                        <div class="col-12 col-sm-4">
                         <div class="form">                          
                         <div class="form-group">
                         <label class="font-weight-bold nexa-dark" style="color:black;">Pagina Web</label>
                         <input type="text" class="form-control" ng-model="vm.fdatos.PagWebDis" onkeyup="this.value=this.value.toUpperCase();" maxlength="50" placeholder="PÁGINA WEB" ng-disabled="vm.disabled_form==1"/>                       
                         </div>
                         </div>
                       </div> 
                       
                      
                         <div class="form">                          
                         <div class="form-group">
                         <label class="font-weight-bold nexa-dark" style="color:black; margin-left: 18px;">Persona Contacto</label>
                         <input type="text" class="form-control" ng-model="vm.fdatos.PerConDis" onkeyup="this.value=this.value.toUpperCase();" maxlength="100" placeholder="PERSONA CONTACTO" ng-disabled="vm.disabled_form==1"/>                       
                         </div>
                         </div>

                    <div style="margin-top: 8px;">
                         <div align="center"><label class="font-weight-bold nexa-dark" style="color:blue;"><b>TIPO DE SERVICIOS</b></label></div></div>
                        
                        <div class="col-12 col-sm-6">
                         <div class="form">                          
                         <div class="form-group">
                         <label class="font-weight-bold nexa-dark" style="color:black;">SUMINISTRO ELÉCTRICO</label>
                          <input type="checkbox" class="form-control" ng-model="vm.SerEle" ng-disabled="vm.disabled_form==1"/>
                         </div>
                         </div>
                         </div>
                        <div class="col-12 col-sm-6">
                         <div class="form">                          
                         <div class="form-group">
                         <label class="font-weight-bold nexa-dark" style="color:black;">SUMINISTRO GAS</label>
                          <input type="checkbox" class="form-control" ng-model="vm.SerGas" ng-disabled="vm.disabled_form==1"/>
                         </div>
                         </div>
                         </div>

                         <div class="form">                          
                         <div class="form-group">
                         <label class="font-weight-bold nexa-dark" style="color:black; margin-left: 18px;">Observación</label>
                         <textarea type="text" class="form-control" ng-model="vm.fdatos.ObsDis" onkeyup="this.value=this.value.toUpperCase();" rows="5" placeholder="OBSERVACIÓN" ng-disabled="vm.disabled_form==1"/> </textarea>                      
                         </div>
                         </div>


                    </div><!--final row-->
                    <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">                        
                        <button class="btn btn-primary" type="submit" ng-show="vm.fdatos.CodDist==undefined||vm.fdatos.CodDist==null||vm.fdatos.CodDist==''" ng-disabled="register_form.$invalid" style="margin-top: 8px;">CREAR</button>                        
                        <button class="btn btn-success" type="submit" ng-show="vm.fdatos.CodDist>0 && vm.disabled_form==undefined" ng-disabled="register_form.$invalid">ACTUALIZAR</button>
                        <button class="btn btn-danger" type="button"  ng-click="vm.borrar()" ng-show="vm.fdatos.CodDist>0 && vm.Nivel==1 && vm.disabled_form==undefined" ng-disabled="vm.Nivel==3">BORRAR</button>
                        <button class="btn btn-warning" type="button" ng-click="vm.limpiar()" ng-show="vm.fdatos.CodDist==undefined||vm.fdatos.CodDist==null||vm.fdatos.CodDist==''">LIMPIAR</button>
                        <a class="btn btn-info" href="#/Distribuidora">REGRESAR</a>
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
<div id="cargando_I" class="loader loader-default"  data-text="Cargando Datos de la Distribuidora, Por Favor Espere..."></div>
<!--div id="crear_clientes" class="loader loader-default"  data-text="Creando o Actualizando Comercial, Por Favor Espere..."></div-->

<div id="Actualizando" class="loader loader-default"  data-text="Actualizando Distribuidora, Por Favor Espere..."></div>
<div id="Guardando" class="loader loader-default"  data-text="Creando Distribuidora, Por Favor Espere..."></div>
</html>
