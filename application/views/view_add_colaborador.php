<?php /** @package WordPress @subpackage Default_Theme  **/
header("Access-Control-Allow-Origin: *"); 
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <style>
  #sinborde 
  {
    border: 0;
    background: inherit;
    background-color:transparent;
    width: 120px;
  }
  #sinbordeAJUST 
  {
    border: 0;
    background: inherit;
    background-color:transparent;
  }
   .removeForMobile{
                display: none !important;
            }
</style>
</head>

<body>
 <div ng-controller="Controlador_Colaboradores as vm">
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header" ng-show="vm.fdatos.CodCol==undefined">Registro de Colaborador</h3>
            <h3 class="page-header" ng-show="vm.fdatos.CodCol>0">Actualización de Colaborador</h3>
            <!--<ol class="breadcrumb">
             <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>             
              <li>Registro de Colaboradores</li>
            </ol>-->
          </div>
        </div>
        <!-- Form validations -->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading" style="color:black;">
                <b>Datos del Colaborador:</b>
              </header>
              <div class="panel-body">              
       


    
    <form id="register_form" name="register_form" ng-submit="submitForm($event)"> 
     <div class='row'>              
       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">DNI/NIE  <b style="color:red;">(*)</b></label></label>
       <input type="text" class="form-control" ng-model="vm.fdatos.NumIdeFis" id="NumIdeFis" name="NumIdeFis" maxlength="9" ng-change="vm.validarsiletras(vm.fdatos.NumIdeFis)" placeholder="* Número del DNI/NIE del Colaborador"  ng-blur="vm.comprobar_cif()" ng-disabled="vm.validate_info!=undefined"/>       
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-8">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Tipo Colaborador <b style="color:red;">(*)</b></label>
       <select class="form-control" id="TipCol" name="TipCol" ng-model="vm.fdatos.TipCol" placeholder="* Tipo de Colaborador" ng-disabled="vm.validate_info!=undefined">
         <option ng-repeat="dato in vm.tTipoColaborador" value="{{dato.CodTipCol}}">{{dato.DesTipCol}}</option>                        
        </select>
       </div>
       </div>
       </div>
       
       <div class="col-12 col-sm-8">
       <div class="form"> 
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Nombre del Colaborador <b style="color:red;">(*)</b></label></label>       
        <input class="form-control" type="text" placeholder="* Nombre del Colaborador"  maxlength="50" ng-model="vm.fdatos.NomCol" ng-disabled="vm.validate_info!=undefined">     
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">% Beneficio <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fdatos.PorCol" placeholder="* % BENEFICIO" ng-disabled="vm.validate_info!=undefined" ng-change="vm.validarsinuermo(vm.fdatos.PorCol)"/>       
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Tipo de Via <b style="color:red;">(*)</b></label>
       <select class="form-control" id="CodTipVia" name="CodTipVia" ng-model="vm.fdatos.CodTipVia" ng-disabled="vm.validate_info!=undefined">
         <option ng-repeat="dato in vm.tTiposVias" value="{{dato.CodTipVia}}">{{dato.DesTipVia}} - {{dato.IniTipVia}}</option>                        
        </select>
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Nombre de la Vía <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fdatos.NomViaDir"  ng-change="vm.asignar_domicilio()" placeholder="* Nombre de la Via del Domicilio del Cliente" maxlength="30" ng-disabled="vm.validate_info!=undefined"/>       
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Número de la Vía <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fdatos.NumViaDir"  min="1" ng-change="vm.asignar_num_domicilio()" placeholder="* Numero del Domicilio" maxlength="100" ng-disabled="vm.validate_info!=undefined"/>       
       </div>
       </div>
       </div>

        <!--div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Bloque</label>
       <input type="text" class="form-control" ng-model="vm.fdatos.BloDir"  placeholder="* Bloque del Domicilio" maxlength="3" ng-change="vm.asignar_bloq_domicilio()" ng-disabled="vm.validate_info!=undefined"/>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Escalera</label>
       <input type="text" class="form-control" ng-model="vm.fdatos.EscDir"  placeholder="* Escalera del Domicilio" ng-change="vm.asignar_esc_domicilio()" maxlength="2" ng-disabled="vm.validate_info!=undefined"/>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Planta</label>
       <input type="text" class="form-control" ng-model="vm.fdatos.PlaDir"  placeholder="* Planta del Domicilio" ng-change="vm.asignar_pla_domicilio()" maxlength="2" ng-disabled="vm.validate_info!=undefined"/>
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Puerta</label>
       <input type="text" class="form-control" ng-model="vm.fdatos.PueDir"  placeholder="* Puerta del Domicilio" ng-change="vm.asignar_puer_domicilio()" maxlength="3" ng-disabled="vm.validate_info!=undefined"/>
       </div>
       </div>
       </div-->

        <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Provincia <b style="color:red;">(*)</b></label>
        <select class="form-control" id="CodPro" name="CodPro"  ng-model="vm.fdatos.CodPro" ng-change="vm.filtrarLocalidad(vm.fdatos.CodPro)" ng-disabled="vm.validate_info!=undefined">
        <option ng-repeat="dato in vm.tProvidencias" value="{{dato.CodPro}}">{{dato.DesPro}}</option>                          
        </select>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Localidad <b style="color:red;">(*)</b></label>
       <select class="form-control" id="CodLoc" name="CodLoc" ng-model="vm.fdatos.CodLoc" ng-disabled="vm.validate_info!=undefined || vm.fdatos.CodPro==undefined">
        <option ng-repeat="dato in vm.TLocalidadesfiltrada" value="{{dato.CodLoc}}">{{dato.DesLoc}}</option>                         
        </select>
       </div>
       </div>
       </div>
         <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Código Postal</label>
       <input type="text" class="form-control" ng-model="vm.fdatos.CPLoc" placeholder="* Zona Postal" ng-disabled="vm.validate_info!=undefined"/>
       </div>
       </div>
       </div>

     
      <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Teléfono Fijo </label>
       <input type="text" class="form-control" ng-model="vm.fdatos.TelFijCol" ng-change="vm.validarsinuermotelefonofijo(vm.fdatos.TelFijCol)" placeholder="* Teléfono Fijo" maxlength="9" ng-disabled="vm.validate_info!=undefined"/>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Teléfono Móvil <b style="color:red;" >(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fdatos.TelCelCol" ng-change="vm.validarsinuermotelefonocel(vm.fdatos.TelCelCol)"  placeholder="* Teléfono Móvil" maxlength="9" ng-disabled="vm.validate_info!=undefined"/>
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Correo Eléctronico</label>
       <input type="email" class="form-control" ng-model="vm.fdatos.EmaCol"  placeholder="* Correo Electrónico del Colaborador" maxlength="50"  ng-disabled="vm.validate_info!=undefined"/>       
       </div>
       </div>
       </div>      
       
       <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:black;"><i class="fa fa-adjust"></i> Comentarios</label>
        <textarea class="form-control" style="display: inline-block;"  id="ObsCol" name="ObsCol" type="text" minlength="1" maxlength="200" rows="5"  ng-model="vm.fdatos.ObsCol" ng-disabled="vm.validate_info!=undefined"></textarea>
        <input class="form-control" id="CodCom" name="CodCom" type="hidden" ng-model="vm.fdatos.CodCom" readonly/>
       </div>
       </div>
       
      <br>
      <input class="form-control" id="CodCol" name="CodCol" type="hidden" ng-model="vm.fdatos.CodCol" readonly/>
         <div class="form-group" >
          <div class="col-12 col-sm-6">
            <button class="btn btn-info" type="submit" ng-show="vm.fdatos.CodCol==undefined||vm.fdatos.CodCol==null||vm.fdatos.CodCol==''" ng-disabled="vm.habilitar_button==1">Crear</button>
            <button class="btn btn-success" type="submit" ng-show="vm.fdatos.CodCol>0 && vm.validate_info==undefined" ng-disabled="vm.validate_info!=undefined||vm.habilitar_button==1" >Actualizar</button>
            
            <!--button class="btn btn-danger" type="button"  ng-click="vm.borrar()" ng-show="vm.fdatos.CodCol>0 && vm.validate_info==undefined" ng-disabled="vm.Nivel==3 || vm.validate_info!=undefined">Borrar</button-->

            <button class="btn btn-warning" type="button" ng-click="vm.limpiar()" ng-show="vm.fdatos.CodCol==undefined||vm.fdatos.CodCol==null||vm.fdatos.CodCol==''">Limpiar</button>
            <a class="btn btn-primary" type="button" style="margin-top: 10px;" ng-click="vm.regresar()">Volver</a>
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
          Diseñado por <a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2019 - 2021</a>
        </div>
    </div>
  </section>


</div>
  <!-- container section end -->
   <script>
      $(function(){
        'use strict'

        // Input Masks
        $('#FecIniAct').mask('9999/99/99');
        $('#FecIniActFil').mask('99-99-9999');
        jQuery(function($) 
        {      
          //jquery tabs
          $( "#tabs_clientes" ).tabs(); 
          $('.date-picker').datepicker({
            autoclose: true,
            todayHighlight: true,
            //mixDate: "<?php echo date("m/d/Y")?>"
            maxDate: "<?php echo date("m/d/Y")?>"
        });
      });



      });
    </script>
</body>
<div id="cargando" class="loader loader-default"  data-text="Cargando Información del Colaborador"></div>
<div id="Guardando" class="loader loader-default"  data-text="Guardando Colaborador"></div>
<div id="Actualiando" class="loader loader-default"  data-text="Actualizando Colaborador"></div>
<div id="borrando" class="loader loader-default"  data-text="Eliminando Colaborador"></div>
<div id="comprobar_cif" class="loader loader-default"  data-text="Comprobando DNI/NIE"></div>

</html>