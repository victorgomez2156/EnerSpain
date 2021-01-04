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
            <h3 class="page-header">Registro de Comercial</h3>
            <!--<ol class="breadcrumb">
             <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>             
              <li>Registro Comercial</li>
            </ol>-->
          </div>
        </div>
        <!-- Form validations -->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
             
              <div class="panel-body">
                 <form id="register_form_com" name="register_form_com" ng-submit="submitForm($event)"> 
     <div class='row'>              
       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">DNI/NIE  <b style="color:red;">(*)</b></label></label>
       <input class=" form-control" id="NIFCom" name="NIFCom" type="text"  ng-model="vm.fdatos.NIFCom" readonly="readonly" ng-disabled="vm.validate_form==1||vm.validate_form==undefined"/>       
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-8">
       <div class="form"> 
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Nombre del Comercial <b style="color:red;">(*)</b></label></label>       
       <input class=" form-control" id="NomCom" name="NomCom" type="text"  ng-model="vm.fdatos.NomCom" ng-disabled="vm.validate_form==1" />     
       </div>
       </div>
       </div>


       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Cargo </label>
       <input class="form-control " id="CarCom" name="CarCom" type="text"  ng-model="vm.fdatos.CarCom" ng-disabled="vm.validate_form==1" />        
       </div>
       </div>
       </div>
       
        <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Fecha Inicio </label>
       <input class="form-control datepicker" id="FecIniCom" name="FecIniCom" type="text" ng-model="vm.fdatos.FecIniCom" ng-disabled="vm.validate_form==1" ng-change="vm.validar_inputs(1,vm.fdatos.FecIniCom)"/>        
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">% Beneficio </label>
       <input class="form-control " id="PorComCom" name="PorComCom" type="text"  ng-model="vm.fdatos.PorComCom" ng-disabled="vm.validate_form==1" ng-change="vm.validar_inputs(2,vm.fdatos.PorComCom)"/>        
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Teléfono Fijo </label>
       <input class=" form-control" id="TelFijCom" name="TelFijCom" type="text"  ng-model="vm.fdatos.TelFijCom" ng-disabled="vm.validate_form==1" ng-change="vm.validar_inputs(3,vm.fdatos.TelFijCom)" maxlength="9" /> 
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Teléfono Móvil <b style="color:red;">(*)</b></label>
       <input class="form-control " id="TelCelCom" name="TelCelCom" type="text"  ng-model="vm.fdatos.TelCelCom" ng-disabled="vm.validate_form==1" ng-change="vm.validar_inputs(4,vm.fdatos.TelCelCom)" maxlength="9"/>       
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Email <b style="color:red;">(*)</b></label>
       <input class="form-control " id="EmaCom" name="EmaCom" type="email"  ng-model="vm.fdatos.EmaCom" ng-disabled="vm.validate_form==1" />       
       </div>
       </div>
       </div> 

       <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">IBAN</label>
             <input type="text" class="form-control" ng-model="vm.CodEur"  maxlength="4" ng-change="vm.validarsinuermoCodEur(vm.CodEur)" />     
             </div>
             </div>
          </div>
          <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">   
              <label class="font-weight-bold nexa-dark" style="color:black;"></label>          
             <input type="text" class="form-control" style="margin-top: 5px;" ng-model="vm.IBAN1" maxlength="4" ng-change="vm.validarsinuermoIBAN(1,vm.IBAN1)" />     
             </div>
             </div>
          </div>
           <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;"></label>         
             <input type="text" style="margin-top: 5px;" class="form-control" ng-model="vm.IBAN2" maxlength="4" ng-change="vm.validarsinuermoIBAN(2,vm.IBAN2)"/>     
             </div>
             </div>
          </div>
           <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">  
              <label class="font-weight-bold nexa-dark" style="color:black;"></label>           
             <input type="text" style="margin-top: 5px;" class="form-control" ng-model="vm.IBAN3" maxlength="4" ng-change="vm.validarsinuermoIBAN(3,vm.IBAN3)"/>     
             </div>
             </div>
          </div>
           <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">
              <label class="font-weight-bold nexa-dark" style="color:black;"></label>             
             <input type="text" style="margin-top: 5px;" class="form-control" ng-model="vm.IBAN4" maxlength="4" ng-change="vm.validarsinuermoIBAN(4,vm.IBAN4)" />     
             </div>
             </div>
          </div>
           <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">  
              <label class="font-weight-bold nexa-dark" style="color:black;"></label>           
             <input type="text" style="margin-top: 5px;" class="form-control" ng-model="vm.IBAN5" maxlength="4"  ng-change="vm.validarsinuermoIBAN(5,vm.IBAN5)"/>     
             </div>
             </div>
          </div>  
       
       <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:black;"><i class="fa fa-adjust"></i> Comentarios</label>
        <textarea class="form-control" style="display: inline-block;"  id="ObsCom" name="ObsCom" type="text" minlength="1" maxlength="200" rows="5"  ng-model="vm.fdatos.ObsCom" ng-disabled="vm.validate_form==1"></textarea>
       <input class="form-control" id="CodCom" name="CodCom" type="hidden" ng-model="vm.fdatos.CodCom" readonly/>
       </div>
       </div>
       
    
           <div class="col-12 col-sm-6">
            <button class="btn btn-info" type="submit" ng-show="vm.fdatos.CodCom==undefined||vm.fdatos.CodCom==null||vm.fdatos.CodCom==''" ng-disabled="vm.habilitar_button==1">Crear</button>
            
            <button class="btn btn-success" type="submit" ng-show="vm.fdatos.CodCom>0 && vm.validate_form==undefined" ng-disabled="vm.validate_form==1||vm.habilitar_button==1" >Actualizar</button>
            
            <!--button class="btn btn-danger" type="button"  ng-click="vm.borrar()" ng-show="vm.fdatos.CodCom>0 && vm.validate_form==undefined" ng-disabled="vm.Nivel==3 || vm.validate_form==1">Borrar</button-->

            <button class="btn btn-warning" type="button" ng-click="vm.limpiar()" ng-show="vm.fdatos.CodCom==undefined||vm.fdatos.CodCom==null||vm.fdatos.CodCom==''">Limpiar</button>            
            <button class="btn btn-primary" style="margin-top: 10px;" type="button" ng-click="vm.regresar()">Volver</button>
            
          </div>
         </div><!--FINAL ROW -->
        </form>
<script>

  $('.datepicker').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});   

  $('#FecIniCom').on('changeDate', function() 
  {
     var FecIniCom=document.getElementById("FecIniCom").value;
     console.log("FecIniCom: "+FecIniCom);
  });
</script>


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
          Diseñado Por <a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2019 - 2021</a>
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
<div id="cargando" class="loader loader-default"  data-text="Cargando listado de Comerciales"></div>
<div id="cargando_I" class="loader loader-default"  data-text="Cargando Información del Comercial"></div>
<div id="crear_clientes" class="loader loader-default"  data-text="Creando o Actualizando Comercial"></div>
<div id="Guardando" class="loader loader-default"  data-text="Grabando Comercial"></div>
<div id="Actualizando" class="loader loader-default"  data-text="Actualizando Comercial"></div>
</html>
