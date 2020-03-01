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
 <div ng-controller="Controlador_Documentos as vm">
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-file"></i> Registro de Documentos</h3>
            <ol class="breadcrumb">
             <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>             
              <li><i class="fa fa-file"></i>Registro de Documentos</li>
            </ol>
          </div>
        </div>
        <!-- Form validations -->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
             
              <div class="panel-body">


 <form class="form-validate" id="form_documentos" name="form_documentos" ng-submit="submitFormRegistroDocumentos($event)">                 
      
      <div class="col-12 col-sm-12">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Clientes <b style="color:red;">(*)</b></label>
       <select class="form-control" id="CodCliDoc" name="CodCli" ng-disabled="vm.restringir_cliente_doc==1||vm.no_editable_doc==1" ng-model="vm.fagregar_documentos.CodCli"> 
          <option ng-repeat="dato_act in vm.Tclientes" required value="{{dato_act.CodCli}}">{{dato_act.NumCifCli}} - {{dato_act.RazSocCli}}</option>                          
        </select>       
       </div>
       </div>
       </div>
           <div class="col-12 col-sm-12">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Tipo Documento</label>
             <select class="form-control" id="CodTipDoc" required name="CodTipDoc" ng-model="vm.fagregar_documentos.CodTipDoc">
               <option ng-repeat="dato in vm.tListDocumentos" value="{{dato.CodTipDoc}}">{{dato.DesTipDoc}}</option>
            </select>     
             </div>
             </div>
          </div>          

          <div class="col-12 col-sm-12">
            <div class="form">                          
             <div class="form-group">
              <label class="font-weight-bold nexa-dark" style="color:black;">Fotocopia del Documento: <a title='Descargar Documento' ng-show="vm.fagregar_documentos.ArcDoc!=null && vm.fagregar_documentos.CodTipDocAI>0" href="{{vm.fagregar_documentos.ArcDoc}}" download class="btn btn-info btn-icon mg-r-5"><div><i class="fa fa-download" style="color:white;"></i></div></a></label>             
             <input type="file" class="form-control" accept="application/pdf" id="DocCliDoc" name="DocCliDoc" uploader-model="DocCliDoc"/>     
             </div>
             </div>
          </div>

          <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Tiene Vencimiento: </label>
             <input type="radio" ng-model="vm.fagregar_documentos.TieVen" value="1" /> 
             <label class="font-weight-bold nexa-dark" style="color:black;">SI</label>
             <input type="radio" ng-model="vm.fagregar_documentos.TieVen" value="2" ng-click="vm.limpiar_fecha_no()" /> 
             <label class="font-weight-bold nexa-dark" style="color:black;">NO</label>    
             </div>
             </div>
          </div>

          <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Fecha Vencimiento <b style="color:red;">DD/MM/YYYY</b>  </label>
             <input type="text" class="form-control datepicker" ng-model="vm.FecVenDocAco" name="FecVenDocAco" id="FecVenDocAco" ng-change="vm.validarfechadocumento(vm.FecVenDocAco)" maxlength="10" ng-disabled="vm.fagregar_documentos.TieVen!=1" />     
             </div>
             </div>
          </div>
          <div cla
          ss="col-12 col-sm-12">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Observación</label>
             <textarea class="form-control" rows="5" ng-model="vm.fagregar_documentos.ObsDoc"></textarea>   
             </div>
             </div>
          </div>
           
          
                  
             <button class="btn btn-info" type="submit" ng-disabled="form_documentos.$invalid" ng-show="vm.fagregar_documentos.CodTipDocAI==undefined">REGISTRAR</button>
             <button class="btn btn-success" type="submit" ng-disabled="form_documentos.$invalid" ng-show="vm.fagregar_documentos.CodTipDocAI>0">ACTUALIZAR</button>
              <a class="btn btn-danger" ng-click="vm.regresar_documentos()">REGRESAR</a>
        </form>
        <input type="hidden" class="form-control" ng-model="vm.fagregar_documentos.CodTipDocAI" readonly />



<script>
  $('.datepicker').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});   

  $('#FecVenDocAco').on('changeDate', function() 
  {
     var FecVenDocAco=document.getElementById("FecVenDocAco").value;
     console.log("FecVenDocAco: "+FecVenDocAco);
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
<div id="buscando" class="loader loader-default"  data-text="Cargando Datos del Documento, Por Favor Espere..."></div>

<div id="crear_clientes" class="loader loader-default"  data-text="Creando o Actualizando Comercial, Por Favor Espere..."></div>

<div id="Actualizando" class="loader loader-default"  data-text="Actualizando Documento, Por Favor Espere..."></div>
<div id="Guardando" class="loader loader-default"  data-text="Creando Documento, Por Favor Espere..."></div>

</html>
