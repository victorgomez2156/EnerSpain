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
 <div ng-controller="Controlador_Actividades as vm">
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header" ng-show="vm.fdatos_actividades.CodTActCli==undefined">Registro de Actividad</h3>
            <h3 class="page-header" ng-show="vm.fdatos_actividades.CodTActCli>0">Modificando Actividad</h3>
           <!-- <ol class="breadcrumb">
             <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>             
              <li><i class="fa fa-briefcase"></i>Registro de Actividades</li>
            </ol>-->
          </div>
        </div>
        <!-- Form validations -->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
             
              <div class="panel-body">
<form id="form_actividades" name="form_actividades" ng-submit="submitFormActividades($event)"> 
    <div class='row'>              
       
       <div class="col-12 col-sm-12" ng-click="vm.containerClicked()">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Clientes {{vm.tmodal_filtroAct.CodCliActFil}}<b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.NumCifCliFil" placeholder="* Introduzca CIF" ng-keyup='vm.fetchClientes()' ng-click='vm.searchboxClicked($event)'/>
        <ul id='searchResult'>
          <li ng-click='vm.setValue($index,$event,result)' ng-repeat="result in vm.searchResult" >
          {{ result.CodCli }},  {{ result.NumCifCli }} - {{ result.RazSocCli }} 
          </li>
        </ul> 
        <input type="hidden" name="CodCliActFil" class="form-control" id="CodCliActFil" ng-model="vm.tmodal_filtroAct.CodCliActFil">
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-12">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Código CNAE <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.CodActCNAE" maxlength="4" ng-blur="vm.buscar_CNAE()" ng-disabled="vm.tmodal_filtroAct.CodCliActFil==undefined" placeholder="* introduzca Código CNAE"/>       
       </div>
       </div>
       </div>
       <!-- inicio resultado de la actividad-->  
       <div ng-show="vm.resultado_actividad==1">
        
        <div class="col-12 col-sm-12">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Código IAE <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fdatos_actividades.CodIAE" readonly="readonly" placeholder="* CodIAE"/>       
       </div>
       </div>
       </div> 


       <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Descripción <b style="color:red;">(*)</b></label>
       <textarea class="form-control" required ng-model="vm.fdatos_actividades.DesActCNAE" readonly></textarea>
       <!--input type="text" class="form-control" ng-model="vm.CodActCNAE" maxlength="4" ng-blur="vm.buscar_CNAE()" ng-disabled="vm.CodCliAct==undefined" required placeholder="* introduzca Código CNAE"/-->
       </div>
       </div>
       </div>

      <div class="col-12 col-sm-6">
      <div class="form">                          
      <div class="form-group">
      <label class="font-weight-bold nexa-dark" style="color:black;">Grupo <b style="color:red;">(*)</b></label>
      <textarea class="form-control" required ng-model="vm.fdatos_actividades.GruActCNAE" readonly></textarea>
      </div>
      </div>
      </div>

      <div class="col-12 col-sm-6">
      <div class="form">                          
      <div class="form-group">
      <label class="font-weight-bold nexa-dark" style="color:black;">Sub-Grupo <b style="color:red;">(*)</b></label>
      <textarea class="form-control" required ng-model="vm.fdatos_actividades.SubGruActCNAE" readonly></textarea>
      </div>
      </div>
      </div>

      <div class="col-12 col-sm-6">
      <div class="form">                          
      <div class="form-group">
      <label class="font-weight-bold nexa-dark" style="color:black;">Sección <b style="color:red;">(*)</b></label>
      <textarea class="form-control" required ng-model="vm.fdatos_actividades.SecActCNAE" readonly></textarea>
      </div>
      </div>
      </div>

      <div class="col-12 col-sm-6">
      <div class="form">                          
      <div class="form-group">
      <label class="font-weight-bold nexa-dark" style="color:black;">Fecha de Inicio <b style="color:red;">DD/MM/YYYY</b></label>
      <input type="text" class="form-control datepicker" id="FecIniAct" name="FecIniAct" ng-model="vm.FecIniAct" ng-change="vm.validar_fecha_act(1,vm.FecIniAct)" placeholder="* EJ: DD/MM/YYYY"/>
      </div>
      </div>
      </div>
       </div><!-- final resultado de la actividad--> 
    
    </div>
    <input type="hidden" class="form-control" ng-model="vm.fdatos_actividades.CodTActCli" readonly/>
    <input type="hidden" class="form-control" ng-model="vm.fdatos_actividades.id" readonly/>
     <div class="form-group" >
        <div class="col-12 col-sm-6">
          <button class="btn btn-info" ng-disabled="form_actividades.$invalid" ng-show="vm.fdatos_actividades.CodTActCli==undefined" type="submit">Asignar</button>
          <button class="btn btn-success" ng-disabled="form_actividades.$invalid" ng-show="vm.fdatos_actividades.CodTActCli>0" type="submit">Actualizar</button>           
          <button class="btn btn-primary" type="button" style="margin-top: 10px;" ng-click="vm.regresar_actividad()">Volver</button>
        </div>
      </div>
  </form>

<script>
  $('.datepicker').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true}); 
  $('#FecIniAct').on('changeDate', function() 
  {
     var FecIniAct=document.getElementById("FecIniAct").value;
     console.log("FecIniAct: "+FecIniAct);
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
<div id="cargando_I" class="loader loader-default"  data-text="Cargando Información de Comerciales"></div>
<div id="buscar_cnae" class="loader loader-default"  data-text="Buscando Código CNAE"></div>

</html>
