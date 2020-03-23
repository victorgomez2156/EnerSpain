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
 <div ng-controller="Controlador_Servicios_Especiales as vm">
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header">Registro de Servicio Especial</h3>
            <!--<ol class="breadcrumb">
             <li><i class="fa fa-home"></i><a href="#/Dashboard"> Dashboard</a></li>            
              <li><i class="fa fa-bullseye"></i> Registro de Servicios Especiales</li>
            </ol>-->
          </div>
        </div>
        <!-- Form validations -->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
             
              <div class="panel-body">




<form id="register_formSerEsp" name="register_formSerEsp" ng-submit="submitFormServiciosEspeciales($event)"> 
     <div class='row'>              
       <div class="col-12 col-sm-12">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Comercializadora <b style="color:red;">(*)</b></label>
       <select class="form-control" name="CodCom" ng-model="vm.servicio_especial.CodCom" ng-disabled="vm.validate_info_servicio_especiales!=undefined">
         <option ng-repeat="dato in vm.Tcomercializadoras" value="{{dato.CodCom}}">{{dato.RazSocCom}} - {{dato.NumCifCom}}</option>                        
        </select>
       
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Nombre del Servicio Especial <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.servicio_especial.DesSerEsp" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Nombre del Servicio Especial" maxlength="50" ng-disabled="vm.validate_info_servicio_especiales!=undefined"/>       
       </div>
       </div>
       </div>
      
      <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Fecha de Inicio <b style="color:red;">DD/MM/YYYY</b></label>
       <input type="text" class="form-control datepicker" id="FecIniSerEspForm" name="FecIniSerEspForm" ng-model="vm.FecIniSerEspForm" placeholder="* DD/MM/YYYY" maxlength="10" ng-disabled="vm.validate_info_servicio_especiales!=undefined" ng-change="vm.validarfecini(vm.FecIniSerEspForm)"/>
       </div>
       </div>
       </div>

      <div style="margin-top: 8px;">
       <div align="center"><label class="font-weight-bold nexa-dark" style="color:#394a59;"><b>Tipos de Suministros</b></label></div></div>
      
      <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">SUMINISTRO ELÉCTRICO</label>
        <input type="checkbox" ng-model="vm.servicio_especial.SerEle" ng-click="vm.limpiar_Servicio_Electrico_SerEsp(vm.servicio_especial.SerEle)" ng-disabled="vm.validate_info_servicio_especiales!=undefined"/>
       </div>
       </div>
       </div>
      <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">SUMINISTRO GAS</label>
        <input type="checkbox" ng-model="vm.servicio_especial.SerGas" ng-click="vm.limpiar_Servicio_Gas_SerEsp(vm.servicio_especial.SerGas)" ng-disabled="vm.validate_info_servicio_especiales!=undefined"/>
       </div>
       </div>
       </div>
        <div style="margin-top: 8px;">
       <div align="center"><label class="font-weight-bold nexa-dark" style="color:#394a59;"><b>Tarifas de Acceso Eléctrico</b></label></div></div>
        
        <div class="col-lg-6">
                <section class="panel">
                  <header class="panel-heading">
                   <div align="center"> <b>Baja Tensión</b> </div>
                  </header>
                   <div class="panel-body">
                    <div class="checkboxes"ng-repeat="opcion_tension_baja in vm.Tarifa_Elec_Baja">                      
                       
                         <button type="button" ng-click="vm.agregar_tarifa_elec_baja_SerEsp($index,opcion_tension_baja.CodTarEle,opcion_tension_baja)" title="Agregar {{opcion_tension_baja.NomTarEle}}" ng-disabled="vm.validate_info_servicio_especiales!=undefined||vm.disabled_all_baja==1||vm.servicio_especial.SerEle==false ||vm.validate_info_servicio_especiales!=undefined" ng-show="!vm.select_tarifa_Elec_Baj_SerEsp[opcion_tension_baja.CodTarEle]"><i class="fa fa fa-square-o" title="Agregar {{tari_gas.NomTarGas}}" style="color:black;"></i></button>
                        

                        <button type="button" ng-show="vm.select_tarifa_Elec_Baj_SerEsp[opcion_tension_baja.CodTarEle]" ng-click="vm.quitar_tarifa_elec_baja_SerEsp($index,opcion_tension_baja.CodTarEle,opcion_tension_baja)" ng-disabled="vm.disabled_all_baja_SerEsp==1||vm.servicio_especial.AggAllBaj==true||vm.validate_info_servicio_especiales!=undefined"><i class="fa fa fa-check-circle" title="Quitar {{opcion_tension_baja.NomTarEle}}" style="color:green;"></i></button>


                        <label class="font-weight-bold nexa-dark" style="color:black;">{{opcion_tension_baja.NomTarEle}}</label>
                    </div>
                     <div align="center">
                    <label>
                        <input name="sample-checkbox-01" id="checkbox-011" type="checkbox" ng-click="vm.agregar_todas_baja_tension_SerEsp(vm.Tarifa_Elec_Baja,vm.servicio_especial.AggAllBaj)" ng-disabled="vm.validate_info_servicio_especiales!=undefined||vm.servicio_especial.SerEle==false||vm.validate_info_servicio_especiales!=undefined" ng-model="vm.servicio_especial.AggAllBaj"/> <b><i class="fa fa-check-circle"></i> Todas</b>
                      </label></div>
                  </div>
                </section> 
              </div>

               <div class="col-lg-6">
                <section class="panel">
                  <header class="panel-heading">
                   <div align="center"> <b>Alta Tensión</b> </div>
                  </header>
                   <div class="panel-body">
                    <div class="checkboxes"ng-repeat="opcion_tension_alta in vm.Tarifa_Elec_Alt"> 

                        <button type="button" ng-disabled="vm.validate_info_servicio_especiales!=undefined||vm.disabled_all_alta==1||vm.servicio_especial.SerEle==false||vm.validate_info_servicio_especiales!=undefined " ng-show="!vm.select_tarifa_Elec_Alt_SerEsp[opcion_tension_alta.CodTarEle]" ng-click="vm.agregar_tarifa_elec_alta_SerEsp($index,opcion_tension_alta.CodTarEle,opcion_tension_alta)" title="Agregar {{opcion_tension_alta.NomTarEle}}"><i class="fa fa fa-square-o" title="Agregar {{tari_gas.NomTarGas}}" style="color:black;"></i></button>                       

                        <button type="button" ng-show="vm.select_tarifa_Elec_Alt_SerEsp[opcion_tension_alta.CodTarEle]" ng-click="vm.quitar_tarifa_elec_alta_SerEsp($index,opcion_tension_alta.CodTarEle,opcion_tension_alta)" ng-disabled="vm.disabled_all_alta_SerEsp==1||vm.servicio_especial.AggAllBaj==true||vm.validate_info_servicio_especiales!=undefined"><i class="fa fa fa-check-circle" title="Quitar {{opcion_tension_alta.NomTarEle}}" style="color:green;"></i></button>

                        <label class="font-weight-bold nexa-dark" style="color:black;">{{opcion_tension_alta.NomTarEle}}</label>

                    </div>
                     <div align="center">
                    <label>
                        <input name="sample-checkbox-01" id="checkbox-012" type="checkbox" ng-disabled="vm.validate_info_servicio_especiales!=undefined||vm.servicio_especial.SerEle==false||vm.validate_info_servicio_especiales!=undefined" ng-model="vm.servicio_especial.AggAllAlt" ng-click="vm.agregar_todas_alta_tension_SerEsp(vm.Tarifa_Elec_Alt,vm.servicio_especial.AggAllAlt)"/> <b><i class="fa fa-check-circle"></i> Todas</b>
                      </label></div>
                  </div>
                </section> 
              </div>



  <div style="margin-top: 8px;">
      <div align="center"><label class="font-weight-bold nexa-dark" style="color:#394a59;"><b>Tarifas de Acceso Gas</b></label></div></div>
       
       <div class="col-12 col-sm-3" ng-repeat="tari_gas in vm.Tarifa_Gas_Anexos">
       <div class="form">                          
       <div class="form-group">

       <button type="button" name="tarifa_gas_SerEsp" ng-show="!vm.select_tarifa_gas_SerEsp[tari_gas.CodTarGas]" ng-click="vm.agregar_tarifa_gas_individual_SerEsp($index,tari_gas,tari_gas.CodTarGas)" ng-disabled="vm.validate_info_servicio_especiales!=undefined||vm.disabled_all_SerEsp==1||vm.servicio_especial.SerGas==false||vm.validate_info_servicio_especiales!=undefined"><i class="fa fa fa-square-o" title="Agregar {{tari_gas.NomTarGas}}" style="color:black;"></i></button>   
       
       <button type="button" ng-show="vm.select_tarifa_gas_SerEsp[tari_gas.CodTarGas]" ng-click="vm.quitar_tarifa_gas_SerEsp($index,tari_gas.CodTarGas,tari_gas)" ng-disabled="vm.disabled_all_SerEsp==1||vm.validate_info_servicio_especiales!=undefined"><i class="fa fa fa-check-circle" title="Quitar {{tari_gas.NomTarGas}}" style="color:green;"></i></button>
       <label class="font-weight-bold nexa-dark" style="color:black;"><b>{{tari_gas.NomTarGas}}</b></label> 

       </div>
       </div>
       </div>
        
        <div align="center">
                    <label class="label_check" for="checkbox-01">
                        <input name="sample-checkbox-01" id="checkbox-013" type="checkbox" ng-model="vm.Todas_Gas_SerEsp" ng-click="vm.agregar_todas_detalle_SerEsp(vm.Todas_Gas_SerEsp)" ng-disabled="vm.validate_info_servicio_especiales!=undefined||vm.servicio_especial.SerGas==false||vm.validate_info_servicio_especiales!=undefined" /> <b><i class="fa fa-check-circle"></i> Todas</b>
                      </label></div><br>
     <div style="margin-top: 10px;">
      <div align="center"><label class="font-weight-bold nexa-dark" style="color:#394a59;"><b>Tipo de Clientes</b></label></div></div>

      
      <div class="col-12 col-sm-12">
       <div class="form">                          
       <div class="form-group">
       
       <input type="radio" name="tipo_cliente1" id="tipo_cliente1" value="0" ng-model="vm.servicio_especial.TipCli" ng-disabled="vm.validate_info_servicio_especiales!=undefined">
       <label class="font-weight-bold nexa-dark" style="color:black;">Particulares</label>

       <input type="radio" name="tipo_cliente2" id="tipo_cliente2" value="1" ng-model="vm.servicio_especial.TipCli" ng-disabled="vm.validate_info_servicio_especiales!=undefined">
       <label class="font-weight-bold nexa-dark" style="color:black;">Negocios</label> 
       </div>
       </div>
       </div>
       <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:black;"><i class="fa fa-adjust"></i> Caracteristicas del Servicio Especial <b style="color:red;">(*)</b></label>
        <textarea class="form-control" style="display: inline-block;" onkeyup="this.value=this.value.toUpperCase();" id="CarSerEsp" name="CarSerEsp" type="text" minlength="1" maxlength="200" rows="5"  ng-model="vm.servicio_especial.CarSerEsp" ng-disabled="vm.validate_info_servicio_especiales!=undefined"></textarea>
        
       </div>
       </div> 


      <div class="col-12 col-sm-12">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Tipo de Comisión <b style="color:red;">(*)</b></label>
       <select class="form-control" id="CodTipCom2" name="CodTipCom" ng-model="vm.servicio_especial.CodTipCom" ng-disabled="vm.validate_info_servicio_especiales!=undefined">
         <option ng-repeat="dato in vm.Tipos_Comision" value="{{dato.CodTipCom}}">{{dato.DesTipCom}}</option>                        
        </select>
       
       </div>
       </div>
       </div>


      <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:black;"><i class="fa fa-adjust"></i> Observación</label>
        <textarea class="form-control" style="display: inline-block;" onkeyup="this.value=this.value.toUpperCase();" id="OsbSerEsp" name="OsbSerEsp" type="text" minlength="1" maxlength="200" rows="5"  ng-model="vm.servicio_especial.OsbSerEsp" ng-disabled="vm.validate_info_servicio_especiales!=undefined"></textarea>
        
       </div>
       </div>    
      <input class="form-control" id="CodSerEsp" name="CodSerEsp" type="hidden" ng-model="vm.servicio_especial.CodSerEsp" readonly/>
         <div class="form-group" >
          <div class="col-12 col-sm-6">
            <button class="btn btn-info" type="submit" ng-show="vm.servicio_especial.CodSerEsp==undefined||vm.servicio_especial.CodSerEsp==null||vm.servicio_especial.CodSerEsp==''" ng-disabled="vm.disabled_button==1"><i class="fa fa-save"></i> Guardar</button>
            <button class="btn btn-success" type="submit" ng-show="vm.servicio_especial.CodSerEsp>0 && vm.validate_info_servicio_especiales==undefined" ng-disabled="vm.validate_info_servicio_especiales!=undefined"><i class="fa fa-save"></i> Actualizar</button>            
            <!--button class="btn btn-warning" type="button" ng-click="vm.limpiar_servicio_especial()" ng-show="vm.validate_info_servicio_especiales==undefined && vm.servicio_especial.CodSerEsp==undefined"><i class="fa fa-trash"></i> {{ 'lim_modal' | translate }}</button-->
            <button class="btn btn-primary" type="button" style="margin-top: 10px;" ng-click="vm.regresar_servicios_especiales()">Volver</button>
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
<script>
  $('.datepicker').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});
  $('#FecIniSerEspForm').on('changeDate', function() 
  {
     var FecIniSerEspForm=document.getElementById("FecIniSerEspForm").value;
     console.log("FecIniSerEspForm: "+FecIniSerEspForm);
  });
</script>
  <!-- container section end -->
<script type="text/javascript" src="application/libraries/estilos/js/jquery.validate.min.js"></script>
  <!-- custom form validation script for this page-->
  <script src="application/libraries/estilos/js/form-validation-script.js"></script>
  <!--custome script for all page-->
  <!--script src="application/libraries/estilos/js/scripts.js"></script-->
</body>
<div id="Guardando" class="loader loader-default"  data-text="Guardando el Servicio Especial, por favor espere ..."></div>
<div id="Actualizando" class="loader loader-default"  data-text="Actualizando el Servicio Especial, por favor espere ..."></div>
<div id="buscando" class="loader loader-default"  data-text="Cargnado listado de Servicios Especiales, por favor espere ..."></div>
</html>
