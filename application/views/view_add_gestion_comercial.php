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
  .datepicker{z-index:1151 !important;}
</style>
<body>
 <div ng-controller="Controlador_Gestiones as vm">
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header" ng-show="vm.fdatos.tipo=='nueva'">Registro de Gestión Comercial</h3>
            <h3 class="page-header" ng-show="vm.fdatos.tipo=='ver'">Consultando Gestión Comercial</h3>
            <h3 class="page-header" ng-show="vm.fdatos.tipo=='renovar'">Renovación de Gestión Comercial</h3>
            <h3 class="page-header" ng-show="vm.fdatos.tipo=='editar'">Modificando Gestión Comercial</h3>
          </div>
        </div>
        <!-- Form validations -->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
             
              <div class="panel-body">


<form id="register_form_gestion" name="register_form_gestion" ng-submit="submitFormGestionComercial($event)"> 
     <div class='row'>              
       <div class="col-12 col-sm-8">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Razón Social / Apellidos, Nombre</label>
        
        <input type="text" class="form-control" ng-model="vm.RazSocCli" placeholder="* Razón Social / Apellidos, Nombre" maxlength="50" readonly="readonly" />
       
       </div>
       </div>
       </div>

      <div class="col-12 col-sm-4">
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Nº Documento Fiscal</label>
        <input type="text" class="form-control" ng-model="vm.NumCifCli" placeholder="Nº Documento Fiscal" maxlength="50" readonly="readonly" />
         
         </div>
         </div>
      </div>

      <div class="col-12 col-sm-3">
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Tipo de Gestion General</label>
          <select class="form-control" id="TipGesGen" name="TipGesGen" required ng-model="vm.fdatos.TipGesGen" ng-disabled="vm.fdatos.tipo=='ver'"> 
        <option ng-repeat="dato_act in vm.List_GestionesComerciales" value="{{dato_act.CodTipGes}}">{{dato_act.CodTipGes}} - {{dato_act.DesTipGes}}</option>
        </select>
        
         
         </div>
         </div>
      </div>

      <div class="col-12 col-sm-3">
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Fecha de Registro</label>
       <input type="text" class="form-control FecGesGen" name="FecGesGen" id="FecGesGen" ng-model="vm.FecGesGen" placeholder="DD/MM/YYYY" maxlength="10" ng-change="vm.validar_formatos_input(2,vm.FecGesGen) " ng-disabled="vm.fdatos.tipo=='ver'"/>
         
         </div>
         </div>
      </div>

       <div class="col-12 col-sm-3">
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Nº Gestión</label>
          
       <input type="text" class="form-control" name="NGesGen" id="NGesGen" ng-model="vm.fdatos.NGesGen" placeholder="00000000001" readonly="readonly" ng-disabled="vm.fdatos.tipo=='ver'"/>
         
         </div>
         </div>
      </div>

      <div class="col-12 col-sm-3">
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Resultado</label>          
       <!--input type="text" class="form-control" name="EstGesGen" id="EstGesGen" ng-model="vm.EstGesGen" placeholder="Pendiente" readonly="readonly"/-->
       <select class="form-control" id="EstGesGen" name="EstGesGen" required ng-model="vm.fdatos.EstGesGen" ng-disabled="vm.fdatos.tipo=='ver'|| vm.fdatos.tipo=='nueva'|| vm.fdatos.tipo=='editar'"> 
        <option value="P">Pendiente</option><option value="R">Resuelto</option><option value="C">Cerrado</option>
        </select>
         
         </div>
         </div>
      </div>

     
       
       <div class="col-12 col-sm-4" style="margin-top: 25px;">
       <div class="form">                 
       <div class="form-group">  
       <label class="font-weight-bold nexa-dark" style="color:black;">Tipo de Suministro: </label>     
        <input type="radio" name="tipo_cups_electrico" id="tipo_cups_electrico" value="0" ng-model="vm.fdatos.TipCups" ng-disabled="vm.disabled_form_TarEle==1 ||vm.fdatos.tipo=='ver'" ng-click="vm.traer_cups(vm.fdatos.TipCups,1)">
        <label class="font-weight-bold nexa-dark" style="color:black;">Eléctrico</label>
        <input type="radio" name="tipo_cups_gas" id="tipo_cups_gas" value="1" ng-model="vm.fdatos.TipCups" ng-disabled="vm.disabled_form_TarEle==1||vm.fdatos.tipo=='ver'" ng-click="vm.traer_cups(vm.fdatos.TipCups,2)">
        <label class="font-weight-bold nexa-dark" style="color:black;">Gas</label> 
       </div>
       </div>
       </div>
      
      <div class="col-12 col-sm-4">
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">CUP</label>
          <select class="form-control" id="CodCups" name="CodCups" required ng-model="vm.fdatos.CodCups" ng-disabled="vm.fdatos.tipo=='ver'" ng-change="vm.filter_Cups(vm.fdatos.CodCups)"> 
        <option ng-repeat="dato_act in vm.ListCUPs" value="{{dato_act.CodCups}}">{{dato_act.CUPsNom}}</option>
        </select>
        
         
         </div>
         </div>
      </div>

      <div class="col-12 col-sm-4">
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Comercializadora</label>
          <input type="text" class="form-control" name="ComerNom" id="ComerNom" ng-model="vm.ComerNom" placeholder="Comercializadora" readonly="readonly"/>  
         </div>
         </div>
      </div>
      

       <div class="col-12 col-sm-5" style="margin-top: 25px;">
       <div class="form">                          
       <div class="form-group">  
       <label class="font-weight-bold nexa-dark" style="color:black;">Mecanismo: </label>     
        <input type="radio" name="MecGesGen" id="MecGesGen" value="0" ng-model="vm.fdatos.MecGesGen" ng-disabled="vm.fdatos.tipo=='ver'">
        <label class="font-weight-bold nexa-dark" style="color:black;">Plataforma On Line</label>
        <input type="radio" name="Presencial" id="Presencial" value="1" ng-model="vm.fdatos.MecGesGen" ng-disabled="vm.fdatos.tipo=='ver'">
        <label class="font-weight-bold nexa-dark" style="color:black;">Presencial</label>

        <!--label class="font-weight-bold nexa-dark" style="color:black;"><b style="color:black;">Precio (€)</b></label> 
        <input type="text" name="PreGesGen" id="PreGesGen" value="1" ng-model="vm.fdatos.PreGesGen" >
        <label class="font-weight-bold nexa-dark" style="color:black;"><b style="color:black;">+ IVA</b></label>   

        <label class="font-weight-bold nexa-dark" style="color:black;">Referencia</label> 
        <input type="text" name="RefGesGen" id="RefGesGen" value="1" ng-model="vm.fdatos.RefGesGen" -->
       </div>
       </div>
       </div>

      <div class="col-12 col-sm-4" style="margin-top: 25px;">
       <div class="form">                          
       <div class="form-group">  
        <label class="font-weight-bold nexa-dark" style="color:black;"><b style="color:black;">Precio (€)</b></label> 
        <input type="text" name="PreGesGen" id="PreGesGen" value="1" ng-model="vm.fdatos.PreGesGen" ng-change="vm.validar_formatos_input(3,vm.fdatos.PreGesGen)" ng-disabled="vm.fdatos.tipo=='ver'">
        <label class="font-weight-bold nexa-dark" style="color:black;"><b style="color:black;">+ IVA</b></label>   

        <!--label class="font-weight-bold nexa-dark" style="color:black;">Referencia</label> 
        <input type="text" name="RefGesGen" id="RefGesGen" value="1" ng-model="vm.fdatos.RefGesGen" -->
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group"> 
        <label class="font-weight-bold nexa-dark" style="color:black;">Referencia</label> 
        <input type="text" name="RefGesGen" id="RefGesGen" value="1" ng-model="vm.fdatos.RefGesGen" class="form-control" ng-disabled="vm.fdatos.tipo=='ver'" onkeyup="this.value=this.value.toUpperCase();">
       </div>
       </div>
       </div>

         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Análisis previo</label>
        <textarea class="form-control" name="DesAnaGesGen" id="DesAnaGesGen" ng-disabled="vm.fdatos.tipo=='ver'" rows="5" placeholder="Análisis previo" ng-model="vm.fdatos.DesAnaGesGen" onkeyup="this.value=this.value.toUpperCase();" ></textarea>        
         </div>
         </div>
     
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Observación</label>
        <textarea class="form-control" name="ObsGesGen" id="ObsGesGen" ng-disabled="vm.fdatos.tipo=='ver'" rows="5" placeholder="Observación" ng-model="vm.fdatos.ObsGesGen" onkeyup="this.value=this.value.toUpperCase();"></textarea>        
         </div>
         </div>
            <input class="form-control" id="CodGesGen" name="CodGesGen" type="text" ng-model="vm.fdatos.CodGesGen" readonly/>
         <div class="form-group" >
          <div class="col-12 col-sm-6">
            <button class="btn btn-info" type="submit" ng-show="vm.fdatos.tipo=='nueva'">Grabar</button>
            <button class="btn btn-success" type="submit" ng-show="vm.fdatos.tipo=='editar'">Actualizar</button>
            <!--a class="btn btn-warning" href="reportes/Exportar_Documentos/Doc_Contrato_Cliente_PDF/{{vm.fdatos.CodGesGen}}" style="margin-top: 0px;" target="_black" ng-show="vm.fdatos.tipo=='editar' || vm.fdatos.tipo=='ver'">Generar PDF</a-->
            <!--button class="btn btn-success" type="submit" ng-show="vm.fdatos.CodGesGen>0 " >Actualizar</button-->            
            <!--button class="btn btn-warning" type="button"  ng-click="vm.limpiar()" ng-show="vm.fdatos.CodGesGen==undefined||vm.fdatos.CodGesGen==null||vm.fdatos.CodGesGen==''">Limpiar</button-->
            <button class="btn btn-primary" type="button" style="margin-top: 10px;" ng-click="vm.regresar()">Volver</button>
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
          Diseñado por <a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2019</a>
        </div>
    </div>
  </section>
</div>
  <!-- container section end -->

<script>

  
  $('.FecGesGen').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});   
  $('.datepicker_Vencimiento').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});

//datepicker_Vencimiento
  /*$('#FecIniCon').on('changeDate', function() 
  {
     var FecIniCon=document.getElementById("FecIniCon").value;
     console.log("FecIniCon: "+FecIniCon);
  });*/

</script>
<script type="text/javascript" src="application/libraries/estilos/js/jquery.validate.min.js"></script>
  <!-- custom form validation script for this page-->
  <script src="application/libraries/estilos/js/form-validation-script.js"></script>
  <!--custome script for all page-->
  <!--script src="application/libraries/estilos/js/scripts.js"></script-->
</body>
<div id="Guardando" class="loader loader-default" data-text="Grabando Gestión Comercial"></div>
<div id="Actualizando" class="loader loader-default" data-text="Actualizando Gestión Comercial"></div>
<div id="cargando" class="loader loader-default" data-text="Cargando datos de la gestión comercial"></div>
<div id="generar" class="loader loader-default" data-text="Generando datos para la gestión"></div>
<div id="CUPs" class="loader loader-default" data-text="Buscando CUPs"></div>
</html>
