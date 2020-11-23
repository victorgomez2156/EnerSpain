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

#searchResult{
  list-style: none;
  padding: 0px;
  width: auto;
  position: absolute;
  margin: 0;
  z-index:1151 !important;
}

#searchResult li{
  background: lavender;
  padding: 4px;
  margin-bottom: 1px;
}

#searchResult li:nth-child(even){
  background: cadetblue;
  color: white;
}

#searchResult li:hover{
  cursor: pointer;
}
</style>
<body>
 <div ng-controller="Controlador_Puntos_Suministros as vm">
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header" ng-show="vm.fpuntosuministro.CodPunSum==undefined">Registro Dirección de Suministro</h3>
            <h3 class="page-header" ng-show="vm.fpuntosuministro.CodPunSum>0&&vm.validate_info_PunSum!=undefined">Consultando Dirección de Suministro</h3>
            <h3 class="page-header" ng-show="vm.fpuntosuministro.CodPunSum>0&&vm.validate_info_PunSum==undefined">Modificando Dirección de Suministro</h3>
            <!--<ol class="breadcrumb">
             <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>             
              <li><i class="fa fa-bullseye"></i>Registro Direccón de Suministros</li>
            </ol>-->
          </div>
        </div>
        <!-- Form validations -->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
             
              <div class="panel-body">

 <form id="register_form2" name="register_form2" ng-submit="submitFormPuntoSuministro($event)"> 
     <div class='row'>              
       
       <div class="col-12 col-sm-12">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Clientes {{vm.fpuntosuministro.CodCliPunSum}}<b style="color:red;">(*)</b></label>
          <input type="text" class="form-control" ng-model="vm.CodCliPunSumFil" placeholder="* Introduzca CIF" ng-keyup='vm.fetchClientes(2)' ng-click='vm.searchboxClicked($event)'/>
          <ul id='searchResult'>
            <li ng-click='vm.setValue($index,$event,result,2)' ng-repeat="result in vm.searchResult" >
            {{ result.CodCli }}, {{ result.NumCifCli }} - {{ result.RazSocCli }} 
            </li>
          </ul> 
        <input type="hidden" name="CodCliPunSum" id="CodCliPunSum" ng-model="vm.fpuntosuministro.CodCliPunSum">

       <!--select class="form-control" id="CodCliPunSum" name="CodCliPunSum" ng-model="vm.fpuntosuministro.CodCliPunSum" required ng-disabled="vm.validate_info_PunSum!=undefined || vm.fpuntosuministro.CodPunSum>0"> 
          <option ng-repeat="dato_act in vm.Tclientes" value="{{dato_act.CodCli}}">{{dato_act.NumCifCli}} - {{dato_act.RazSocCli}}</option>                          
        </select-->



       </div>
       </div>
       </div>
      
      <div class="col-12 col-sm-4">
        <div class="form">                          
          <div class="form-group">
            <label class="font-weight-bold nexa-dark" style="color:black;">Nuevo</label>
            <input type="radio" class="form-control" name="punto_suministro"  ng-model="vm.fpuntosuministro.TipRegDir" value="0" ng-click="vm.punto_suministro(1,vm.fpuntosuministro.TipRegDir)" ng-disabled="vm.validate_info_PunSum!=undefined || vm.fpuntosuministro.CodCliPunSum==undefined"/> 
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Misma Dirección Social</label>
       <input type="radio" class="form-control" name="punto_suministro" ng-model="vm.fpuntosuministro.TipRegDir" value="1" ng-click="vm.punto_suministro(2,vm.fpuntosuministro.TipRegDir)" ng-disabled="vm.validate_info_PunSum!=undefined|| vm.fpuntosuministro.CodCliPunSum==undefined"/>       
       </div>
       </div>
       </div> 

      <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Misma Dirección Fiscal</label>
       <input type="radio" class="form-control" name="punto_suministro" ng-model="vm.fpuntosuministro.TipRegDir" value="2" ng-click="vm.punto_suministro(3,vm.fpuntosuministro.TipRegDir)" ng-disabled="vm.validate_info_PunSum!=undefined|| vm.fpuntosuministro.CodCliPunSum==undefined"/>
       </div>
       </div>
       </div>

     
      <div style="margin-top: 8px;">
       <div align="center"><label class="font-weight-bold nexa-dark" style="color:#6d6e71;;"><b>DIRECCIÓN</b></label></div></div>
      
      <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Tipo de Via <b style="color:red;">(*)</b></label>
       <select class="form-control" id="CodTipVia" name="CodTipVia"  placeholder="* Tipo de Via" ng-model="vm.fpuntosuministro.CodTipVia" ng-disabled="vm.validate_info_PunSum!=undefined || vm.fpuntosuministro.TipRegDir==undefined " required>
         <option ng-repeat="dato in vm.tTiposVias" value="{{dato.CodTipVia}}">{{dato.DesTipVia}} - {{dato.IniTipVia}}</option>                        
        </select>
       </div>
       </div>
       </div>

      <div class="col-12 col-sm-5">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Nombre de la Via <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fpuntosuministro.NomViaPunSum"  placeholder="* Nombre de la Via del Dirección de Suministro" maxlength="30"  ng-disabled="vm.validate_info_PunSum!=undefined|| vm.fpuntosuministro.TipRegDir==undefined" required/>       
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Número <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fpuntosuministro.NumViaPunSum"  min="1" placeholder="* Numero del Dirección de Suministro" maxlength="2" ng-change="vm.validarsinuermo(vm.fpuntosuministro.NumViaPunSum,1)" ng-disabled="vm.validate_info_PunSum!=undefined|| vm.fpuntosuministro.TipRegDir==undefined" required/>       
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Bloque</label>
       <input type="text" class="form-control" ng-model="vm.fpuntosuministro.BloPunSum"  placeholder="Bloque del Dirección de Suministro" maxlength="3" ng-disabled="vm.validate_info_PunSum!=undefined|| vm.fpuntosuministro.TipRegDir==undefined"/>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Escalera</label>
       <input type="text" class="form-control" ng-model="vm.fpuntosuministro.EscPunSum"  placeholder="Escalera del Dirección de Suministro" maxlength="2" ng-disabled="vm.validate_info_PunSum!=undefined|| vm.fpuntosuministro.TipRegDir==undefined"/>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Planta</label>
       <input type="text" class="form-control" ng-model="vm.fpuntosuministro.PlaPunSum"  placeholder="Planta del Dirección de Suministro" maxlength="3" ng-disabled="vm.validate_info_PunSum!=undefined|| vm.fpuntosuministro.TipRegDir==undefined"/>
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Puerta</label>
       <input type="text" class="form-control" ng-model="vm.fpuntosuministro.PuePunSum"  placeholder="Puerta del Dirección de Suministro" maxlength="4" ng-disabled="vm.validate_info_PunSum!=undefined|| vm.fpuntosuministro.TipRegDir==undefined"/>
       </div>
       </div>
       </div>
        <!--div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Aclarador</label>
       <input type="text" class="form-control" ng-model="vm.fpuntosuministro.Aclarador"  placeholder="Aclarador" maxlength="50" ng-disabled="vm.validate_info_PunSum!=undefined|| vm.fpuntosuministro.TipRegDir==undefined"/>
       </div>
       </div>
       </div-->
        <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Provincia <b style="color:red;">(*)</b></label>
        <select class="form-control" name="CodPro"  ng-model="vm.fpuntosuministro.CodProPunSum" ng-change="vm.BuscarLocalidadesPunSun(vm.fpuntosuministro.CodProPunSum,2)" ng-disabled="vm.validate_info_PunSum!=undefined|| vm.fpuntosuministro.TipRegDir==undefined" required>
        <option ng-repeat="dato in vm.tProvidencias" value="{{dato.CodPro}}">{{dato.DesPro}}</option>                          
        </select>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Localidad <b style="color:red;">(*)</b></label>
       <select class="form-control" id="CodLocPunSum" name="CodLocPunSum" ng-model="vm.fpuntosuministro.CodLocPunSum" ng-disabled="vm.validate_info_PunSum!=undefined|| vm.fpuntosuministro.TipRegDir==undefined || vm.fpuntosuministro.CodProPunSum==undefined" required>
        <option ng-repeat="dato in vm.TLocalidadesfiltradaPunSum" value="{{dato.CodLoc}}">{{dato.DesLoc}}</option>                         
        </select>
       </div>
       </div>
       </div>
         <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Código Postal</label>
       <input type="text" class="form-control" ng-model="vm.fpuntosuministro.CPLocSoc" placeholder="Zona Postal" ng-disabled="vm.validate_info_PunSum!=undefined|| vm.fpuntosuministro.TipRegDir==undefined"/>
       </div>
       </div>
       </div>      

       <!--div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Teléfono <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fpuntosuministro.TelPunSum" ng-change="vm.validarsinuermo(vm.fpuntosuministro.TelPunSum)" placeholder="* Telefono del Dirección de Suministro" maxlength="9" ng-disabled="vm.validate_info==1|| vm.fpuntosuministro.TipRegDir==undefined"/>       
       </div>
       </div>
       </div-->
       
       <!--div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Tipo de Inmueble <b style="color:red;">(*)</b></label>
       <select class="form-control" name="CodTipInm"  placeholder="* Tipo de Via" ng-model="vm.fpuntosuministro.CodTipInm" ng-disabled="vm.validate_info_PunSum!=undefined|| vm.fpuntosuministro.TipRegDir==undefined" required>
         <option ng-repeat="dato in vm.TtiposInmuebles" value="{{dato.CodTipInm}}">{{dato.DesTipInm}}</option>                        
        </select>       
       </div>
       </div>
       </div-->

       <!--div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Referencia Castastral</label>
       <input type="text" class="form-control" ng-model="vm.fpuntosuministro.RefCasPunSum"  placeholder="Referencia Castastral del Dirección de Suministro" maxlength="20" ng-change="vm.validarsinuermo(vm.fpuntosuministro.RefCasPunSum,2)" ng-disabled="vm.validate_info_PunSum!=undefined|| vm.fpuntosuministro.TipRegDir==undefined"/>       
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Area</label>
        <input type="text" class="form-control" ng-model="vm.fpuntosuministro.DimPunSum"  placeholder="Área del Dirección de Suministro" maxlength="5" ng-disabled="vm.validate_info_PunSum!=undefined || vm.fpuntosuministro.TipRegDir==undefined" ng-change="vm.validarsinuermo(vm.fpuntosuministro.DimPunSum,3)"/>       
       </div>
       </div>
       </div-->
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Comentarios</label>
       </div>
       </div>
       <div class="form">                          
       <div class="form-group">
        <textarea class="form-control" style="display: inline-block;"  id="ObsPunSum" name="ObsPunSum" type="text" minlength="1" maxlength="200" rows="5"  ng-model="vm.fpuntosuministro.ObsPunSum" ng-disabled="vm.validate_info_PunSum!=undefined|| vm.fpuntosuministro.TipRegDir==undefined"></textarea>
       
       </div>
       </div>
       <input class="form-control" id="CodPunSum" name="CodPunSum" type="hidden" ng-model="vm.fpuntosuministro.CodPunSum" readonly/>
         <div class="form-group" >
          <div class="col-12 col-sm-6">
            
            <button class="btn btn-info" type="submit" ng-show="vm.fpuntosuministro.CodPunSum==undefined&& vm.validate_info_PunSum==undefined||vm.fpuntosuministro.CodPunSum==null&& vm.validate_info_PunSum==undefined||vm.fpuntosuministro.CodPunSum==''&& vm.validate_info_PunSum==undefined" ng-disabled="vm.fpuntosuministro.TipRegDir==undefined">GUARDAR</button>

            <button class="btn btn-success" type="submit" ng-show="vm.fpuntosuministro.CodPunSum>0 && vm.validate_info_PunSum==undefined" ng-disabled="vm.validate_info_PunSum!=undefined">ACTUALIZAR</button>            
            
            <button class="btn btn-danger" type="button" ng-click="vm.regresar_punto_suministro()">Volver</button>
          </div>
        </div>
         </div><!--FINAL ROW -->
        </form>









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
<div id="cargando_I" class="loader loader-default"  data-text="Cargando Información de la Dirección de Suministro"></div>
<div id="crear_clientes" class="loader loader-default"  data-text="Creando o Actualizando Comercial"></div>

<div id="Guardando" class="loader loader-default"  data-text="Guardando Dirección de Suministro"></div>
<div id="Actualizando" class="loader loader-default"  data-text="Actualizando Dirección de Suministro"></div>
</html>
