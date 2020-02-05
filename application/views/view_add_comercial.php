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
                 <form id="register_form" name="register_form" ng-submit="submitForm($event)"> 
     <div class='row'>              
       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">DNI/NIE  <b style="color:red;">(*)</b></label></label>
       <input class=" form-control" id="NIFCom" name="NIFCom" type="text" required ng-model="vm.fdatos.NIFCom" readonly="readonly" ng-disabled="vm.validate_form==1||vm.validate_form==undefined"/>       
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-8">
       <div class="form"> 
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Nombre del Comercial <b style="color:red;">(*)</b></label></label>       
       <input class=" form-control" id="NomCom" name="NomCom" type="text" required ng-model="vm.fdatos.NomCom" ng-disabled="vm.validate_form==1"/>     
       </div>
       </div>
       </div>


       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Cargo <b style="color:red;">(*)</b></label>
       <input class="form-control " id="CarCom" name="CarCom" type="text" required ng-model="vm.fdatos.CarCom" ng-disabled="vm.validate_form==1"/>        
       </div>
       </div>
       </div>
       

        <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Fecha Inicio <b style="color:red;">(*)</b></label>
       <input class="form-control " id="FecIniCom" name="FecIniCom" type="text" required ng-model="vm.fdatos.FecIniCom" ng-disabled="vm.validate_form==1"/>        
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">% Beneficio <b style="color:red;">(*)</b></label>
       <input class="form-control " id="PorComCom" name="PorComCom" type="text" required ng-model="vm.fdatos.PorComCom" ng-disabled="vm.validate_form==1"/>        
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Teléfono Fijo <b style="color:red;">(*)</b></label>
       <input class=" form-control" id="TelFijCom" name="TelFijCom" type="text" required ng-model="vm.fdatos.TelFijCom" ng-disabled="vm.validate_form==1"/> 
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Teléfono Celular <b style="color:red;">(*)</b></label>
       <input class="form-control " id="TelCelCom" name="TelCelCom" type="text" required ng-model="vm.fdatos.TelCelCom" ng-disabled="vm.validate_form==1"/>       
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Email <b style="color:red;">(*)</b></label>
       <input class="form-control " id="EmaCom" name="EmaCom" type="email" required ng-model="vm.fdatos.EmaCom" ng-disabled="vm.validate_form==1"/>       
       </div>
       </div>
       </div>   
       
       <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:black;"><i class="fa fa-adjust"></i> Observación</label>
        <textarea class="form-control" style="display: inline-block;" onkeyup="this.value=this.value.toUpperCase();" id="ObsCom" name="ObsCom" type="text" minlength="1" maxlength="200" rows="5"  ng-model="vm.fdatos.ObsCom" ng-disabled="vm.validate_form==1"></textarea>
       <input class="form-control" id="CodCom" name="CodCom" type="hidden" ng-model="vm.fdatos.CodCom" readonly/>
       </div>
       </div>
       
    
           <div class="col-12 col-sm-6">
            <button class="btn btn-info" type="submit" ng-show="vm.fdatos.CodCom==undefined||vm.fdatos.CodCom==null||vm.fdatos.CodCom==''" ng-disabled="vm.habilitar_button==1"><i class="fa fa-save"></i> CREAR</button>
            
            <button class="btn btn-success" type="submit" ng-show="vm.fdatos.CodCom>0 && vm.validate_form==undefined" ng-disabled="vm.validate_form==1||vm.habilitar_button==1" ><i class="fa fa-spinner"></i> ACTUALIZAR</button>
            
            <button class="btn btn-danger" type="button"  ng-click="vm.borrar()" ng-show="vm.fdatos.CodCom>0 && vm.validate_form==undefined" ng-disabled="vm.Nivel==3 || vm.validate_form==1"><i class="fa fa-trash"></i>  BORRAR</button>

            <button class="btn btn-warning" type="button" ng-click="vm.limpiar()" ng-show="vm.fdatos.CodCom==undefined||vm.fdatos.CodCom==null||vm.fdatos.CodCom==''"><i class="fa fa-leaf"></i> LIMPIAR</button>            
            <button class="btn btn-primary" style="margin-top: 10px;" type="button" ng-click="vm.regresar()"><i class="fa fa-backward"></i> REGRESAR</button>
            
          </div>
         </div><!--FINAL ROW -->
        </form>

                <!--div class="form">
                  <form class="form-validate form-horizontal " id="register_form" name="register_form" ng-submit="submitForm($event)">
                    <div class="form-group ">
                      <label for="fullname" class="control-label col-lg-2">NIF del Comercial <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class=" form-control" id="NIFCom" name="NIFCom" type="text" required ng-model="vm.fdatos.NIFCom" ng-disabled="vm.validate_form==1" ng-blur="vm.buscar_nif_comercial()"/>
                      </div>
                    </div>
                    <div class="form-group ">
                      <label for="fullname" class="control-label col-lg-2">Nombre del Comercial <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class=" form-control" id="NomCom" name="NomCom" type="text" required ng-model="vm.fdatos.NomCom" ng-disabled="vm.validate_form==1"/>
                      </div>
                    </div>
                     
                    <div class="form-group ">
                      <label for="address" class="control-label col-lg-2">Teléfono Fijo del Comercial <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class=" form-control" id="TelFijCom" name="TelFijCom" type="text" required ng-model="vm.fdatos.TelFijCom" ng-disabled="vm.validate_form==1"/>                        
                      </div>
                    </div>
                    <div class="form-group ">
                      <label for="username" class="control-label col-lg-2">Teléfono Celular del Comercial <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class="form-control " id="TelCelCom" name="TelCelCom" type="text" required ng-model="vm.fdatos.TelCelCom" ng-disabled="vm.validate_form==1"/>                                               
                      </div>
                    </div>
                    <div class="form-group ">
                      <label for="username" class="control-label col-lg-2">Email del Comercial <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class="form-control " id="EmaCom" name="EmaCom" type="email" required ng-model="vm.fdatos.EmaCom" ng-disabled="vm.validate_form==1"/>                                               
                      </div>
                    </div>
                    <div class="form-group ">
                      <label for="username" class="control-label col-lg-2">Cargo Comercial <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class="form-control " id="CarCom" name="CarCom" type="text" required ng-model="vm.fdatos.CarCom" ng-disabled="vm.validate_form==1"/>                                               
                      </div>
                    </div>
                    <div class="form-group ">
                      <label for="username" class="control-label col-lg-2">Porcenjate de Comisión Asignado <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class="form-control " id="PorComCom" name="PorComCom" type="text" required ng-model="vm.fdatos.PorComCom" ng-disabled="vm.validate_form==1"/>                                               
                      </div>
                    </div>
                     <div class="form-group ">
                      <label for="username" class="control-label col-lg-2">Observación Comercial <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <textarea class="form-control " id="ObsCom" name="ObsCom" rows="5" required ng-model="vm.fdatos.ObsCom" ng-disabled="vm.validate_form==1"></textarea>                                             
                      </div>
                    </div>                    
                    <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                        <button class="btn btn-primary" type="submit" ng-show="vm.fdatos.CodCom==undefined||vm.fdatos.CodCom==null||vm.fdatos.CodCom==''" ng-disabled="register_form.$invalid">Crear Comercial</button>
                        
                        <button class="btn btn-info" type="submit" ng-show="vm.fdatos.CodCom>0&&vm.validate_form==undefined" ng-disabled="register_form.$invalid">Actualizar Comercial</button>
                        <button class="btn btn-danger" type="button"  ng-click="vm.borrar()" ng-show="vm.fdatos.CodCom>0&&vm.validate_form==undefined" ng-disabled="vm.Nivel==3">Borrar Registro</button>
                        <button class="btn btn-warning" type="button" ng-show="vm.validate_form==undefined" ng-click="vm.limpiar()">Limpiar</button>
                        <a class="btn btn-primary" href="#/Comercial">Regresar</a>
                      </div>
                    </div>
                    <input class="form-control " id="huser" name="huser" type="hidden" ng-model="vm.fdatos.CodCom" readonly />
                  </form>
                </div-->







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
