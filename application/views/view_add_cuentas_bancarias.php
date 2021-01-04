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
 <div ng-controller="Controlador_Cuentas_Bancarias as vm">
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header">Registro de Cuenta Bancaria del Cliente</h3>
            <!--<ol class="breadcrumb">
             <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>             
              <li><i class="fa fa-bank"></i>Registro de Cuentas Bancarias</li>
            </ol>-->
          </div>
        </div>
        <!-- Form validations -->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
             
              <div class="panel-body">

 <form class="form-validate" id="form_cuenta_bancaria" name="form_cuenta_bancaria" ng-submit="submitFormRegistroCuentaBanca($event)">                 
      <div class="col-12 col-sm-12">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Clientes {{vm.tgribBancos.CodCli}}<b style="color:red;">(*)</b></label>
       

       <input type="text" class="form-control" ng-model="vm.NumCifCliSearch" placeholder="* Introduzca CIF" ng-keyup='  vm.fetchClientes(2)' ng-click='vm.searchboxClicked($event)' ng-disabled="vm.restringir_cliente_cuen==1||vm.no_editable_cuen==1"/>
          <ul id='searchResult'>
            <li ng-click='vm.setValue($index,$event,result,2)' ng-repeat="result in vm.searchResult" >
            {{ result.CodCli }},  {{ result.NumCifCli }} - {{ result.RazSocCli }} 
            </li>
          </ul> 
        <input type="hidden" name="CodCliCuen" id="CodCliCuen" ng-model="vm.tgribBancos.CodCli" class="form-control">

       <!--select class="form-control" id="CodCliCuen" name="CodCli" ng-disabled="vm.restringir_cliente_cuen==1||vm.no_editable_cuen==1" ng-model="vm.tgribBancos.CodCli"> 
          <option ng-repeat="dato_act in vm.Tclientes" value="{{dato_act.CodCli}}">{{dato_act.NumCifCli}} - {{dato_act.RazSocCli}}</option>                          
        </select--> 



       </div>
       </div>
       </div>
           <!--div class="col-12 col-sm-12">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Banco</label>
             <select class="form-control" id="CodBan" name="CodBan" required ng-model="vm.tgribBancos.CodBan" ng-disabled="vm.tgribBancos.CodCli==undefined">
               <option ng-repeat="dato in vm.tListBanc" value="{{dato.CodBan}}">{{dato.DesBan}}</option>
            </select>     
             </div>
             </div>
          </div-->
          
          <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">IBAN</label>
             <input type="text" class="form-control" ng-model="vm.CodEur" maxlength="4" required  ng-change="vm.validarsinuermoCodEur(vm.CodEur)" />     
             </div>
             </div>
          </div>
          <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">   
              <label class="font-weight-bold nexa-dark" style="color:black;"></label>          
             <input type="text" class="form-control" style="margin-top: 5px;" ng-model="vm.IBAN1" maxlength="4" ng-change="vm.validarsinuermoIBAN(1,vm.IBAN1)" required  />     
             </div>
             </div>
          </div>
           <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;"></label>         
             <input type="text" style="margin-top: 5px;" class="form-control" ng-model="vm.IBAN2" maxlength="4" required ng-change="vm.validarsinuermoIBAN(2,vm.IBAN2)" />     
             </div>
             </div>
          </div>
           <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">  
              <label class="font-weight-bold nexa-dark" style="color:black;"></label>           
             <input type="text" style="margin-top: 5px;" class="form-control" ng-model="vm.IBAN3" maxlength="4" required ng-change="vm.validarsinuermoIBAN(3,vm.IBAN3)"  />     
             </div>
             </div>
          </div>
           <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">
              <label class="font-weight-bold nexa-dark" style="color:black;"></label>             
             <input type="text" style="margin-top: 5px;" class="form-control" ng-model="vm.IBAN4" maxlength="4" required ng-change="vm.validarsinuermoIBAN(4,vm.IBAN4)"  />     
             </div>
             </div>
          </div>
           <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">  
              <label class="font-weight-bold nexa-dark" style="color:black;"></label>           
             <input type="text" style="margin-top: 5px;" class="form-control" ng-model="vm.IBAN5" maxlength="4" required ng-change="vm.validarsinuermoIBAN(5,vm.IBAN5)" />     
             </div>
             </div>
          </div>
            
             <button class="btn btn-info" type="submit" ng-disabled="form_cuenta_bancaria.$invalid || vm.numIBanValidado==false" ng-show="vm.tgribBancos.CodCueBan==undefined">REGISTRAR</button>
             <button class="btn btn-success" type="submit" ng-disabled="form_cuenta_bancaria.$invalid || vm.numIBanValidado==false" ng-show="vm.tgribBancos.CodCueBan>0">ACTUALIZAR</button>
              <a class="btn btn-danger" ng-click="vm.regresar_cuenta_bancaria()">VOLVER</a>
        </form>
        <input type="hidden" class="form-control" ng-model="vm.tgribBancos.CodCueBan" required readonly />









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
          Diseñado Por <a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2020</a>
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
<div id="cargando_I" class="loader loader-default"  data-text="Cargando Información de la Cuenta Bancaria"></div>

<div id="Actualizando" class="loader loader-default"  data-text="Actualizando Cuenta Bancaria"></div>
<div id="Guardando" class="loader loader-default"  data-text="Creando Cuenta Bancaria"></div>
</html>
