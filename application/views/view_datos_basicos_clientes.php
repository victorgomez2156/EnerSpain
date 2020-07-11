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
 <div ng-controller="Controlador_Datos_Basicos_Clientes as vm">
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header" ng-show="vm.fdatos.CodCli==undefined">Registrar Cliente</h3>
            <h3 class="page-header" ng-show="vm.fdatos.CodCli>0">Datos Básicos del Cliente </h3>
            <!--<ol class="breadcrumb">
            
             <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>             
              
              <li ng-show="vm.fdatos.CodCli==undefined">Registro de Cliente</li>
              <li ng-show="vm.fdatos.CodCli>0">Modificación de Cliente</li>
            </ol>-->
          </div>
        </div>
        <!-- Form validations -->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading" style="color:black;">
                <b>Datos Básicos del Cliente: {{vm.fdatos.CodCli}}</b>
              </header>
              <div class="panel-body">



    <form id="register_form" name="register_form" ng-submit="submitForm($event)"> 
     <div class='row'>              
       <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">CIF <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" id="NumCifCliRe" ng-model="vm.fdatos.NumCifCli" maxlength="9" ng-disabled="vm.validate_cif==undefined" readonly placeholder="* Número del CIF del Cliente Comercial"/>
       
       </div>
       </div>
       </div>       
       <div class="col-12 col-sm-4">
       <div class="form"> 
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Fecha de Inicio <b style="color:red;">DD/MM/YYYY</b></label>       
        <div class="input-append date" id="dpYears" data-date="18-06-2013" data-date-format="dd-mm-yyyy" data-date-viewmode="years">
          <input class="form-control datepicker" size="16" type="text" placeholder="mm/dd/yyyy" name="FecIniCli" id="FecIniCli" ng-model="vm.FecIniCli" maxlength="10" ng-disabled="vm.validate_info!=undefined" ng-change="vm.validar_fecha_blo(4,vm.FecIniCli)">      
      </div>
      
       </div>
       </div>
       </div>
        <br><br><br><br>

       <div class="col-12 col-sm-12">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Razón Social <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fdatos.RazSocCli" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Razón Social del Cliente" maxlength="50" ng-disabled="vm.validate_info!=undefined" ng-change="vm.asignar_a_nombre_comercial()"/>       
       </div>
       </div>
       </div>
      <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Nombre Comercial <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fdatos.NomComCli" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Razón Social del Cliente" maxlength="50" ng-disabled="vm.fdatos.misma_razon==false || vm.validate_info!=undefined"/>
       </div>
       </div>
       </div>
       <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Distinto a Razón Social</label>
       <input type="checkbox" class="form-control" ng-model="vm.fdatos.misma_razon" ng-disabled="vm.validate_info!=undefined" ng-click="vm.misma_razon(vm.fdatos.misma_razon)"/>       
       </div>
       </div>
       </div> 

      <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Tipo de Cliente <b style="color:red;">(*)</b></label>
       <select class="form-control" id="CodTipCli" name="CodTipCli" ng-model="vm.fdatos.CodTipCli" placeholder="* Tipo de Cliente" ng-disabled="vm.validate_info!=undefined">
         <option ng-repeat="dato in vm.tTipoCliente" value="{{dato.CodTipCli}}">{{dato.DesTipCli}}</option>                        
        </select>
       </div>
       </div>
       </div>  
        <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Sector </label>
       <select class="form-control" id="CodSecCli" name="CodSecCli" ng-model="vm.fdatos.CodSecCli" placeholder="* Sector" ng-disabled="vm.validate_info!=undefined">
         <option ng-repeat="dato in vm.tSectores" value="{{dato.CodSecCli}}">{{dato.DesSecCli}}</option>                        
        </select>
       </div>
       </div>
       </div>      
      <div style="margin-top: 8px;">
      <div align="center">
        <label ng-hide="vm.fdatos.DireccionBBDD==null" ng-show="vm.fdatos.DireccionBBDD!=null" class="font-weight-bold nexa-dark" style="color:#6d6e71;"><b>DOMICILIO SOCIAL</b></label>
      </div>
      </div>
            

      <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">DIRECCIÓN BBDD<b style="color:red;">(*)</b></label>
            <input ng-hide="vm.fdatos.DireccionBBDD==null" ng-show="vm.fdatos.DireccionBBDD!=null" style="border:none; background:transparent" type="text" class="form-control" ng-model="vm.fdatos.DireccionBBDD" readonly/>        
       </div>
       </div>


      <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Tipo de Via <b style="color:red;">(*)</b></label>
       <select class="form-control" id="CodTipViaSoc" name="CodTipViaSoc"  placeholder="* Tipo de Via" ng-model="vm.fdatos.CodTipViaSoc" ng-change="vm.asignar_tipo_via()" ng-disabled="vm.validate_info!=undefined">
         <option ng-repeat="dato in vm.tTiposVias" value="{{dato.CodTipVia}}">{{dato.DesTipVia}} - {{dato.IniTipVia}}</option>                        
        </select>
       </div>
       </div>
       </div>

      <div class="col-12 col-sm-5">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Nombre de la Vía <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fdatos.NomViaDomSoc" onkeyup="this.value=this.value.toUpperCase();" ng-change="vm.asignar_domicilio()" placeholder="* Nombre de la Via del Domicilio del Cliente" maxlength="30"  ng-disabled="vm.validate_info!=undefined"/>       
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Número de la Vía <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fdatos.NumViaDomSoc" onkeyup="this.value=this.value.toUpperCase();" min="1" ng-change="vm.asignar_num_domicilio(vm.fdatos.NumViaDomSoc)" placeholder="* Numero del Domicilio" maxlength="3" ng-disabled="vm.validate_info!=undefined"/>       
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Bloque</label>
       <input type="text" class="form-control" ng-model="vm.fdatos.BloDomSoc" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Bloque del Domicilio" maxlength="3" ng-change="vm.asignar_bloq_domicilio()" ng-disabled="vm.validate_info!=undefined"/>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Escalera</label>
       <input type="text" class="form-control" ng-model="vm.fdatos.EscDomSoc" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Escalera del Domicilio" ng-change="vm.asignar_esc_domicilio()" maxlength="2" ng-disabled="vm.validate_info!=undefined"/>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Planta</label>
       <input type="text" class="form-control" ng-model="vm.fdatos.PlaDomSoc" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Planta del Domicilio" ng-change="vm.asignar_pla_domicilio()" maxlength="2" ng-disabled="vm.validate_info!=undefined"/>
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Puerta</label>
       <input type="text" class="form-control" ng-model="vm.fdatos.PueDomSoc" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Puerta del Domicilio" ng-change="vm.asignar_puer_domicilio()" maxlength="4" ng-disabled="vm.validate_info!=undefined"/>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Provincia <b style="color:red;">(*)</b></label>
        <select class="form-control" id="CodPro" name="CodPro"  ng-model="vm.fdatos.CodProSoc" ng-change="vm.BuscarLocalidad(1,vm.fdatos.CodProSoc)" ng-disabled="vm.validate_info!=undefined">
        <option ng-repeat="dato in vm.tProvidencias" value="{{dato.CodPro}}">{{dato.DesPro}}</option>                          
        </select>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Localidad <b style="color:red;">(*)</b></label>
       <select class="form-control" id="CodLoc" name="CodLoc" ng-model="vm.fdatos.CodLocSoc" ng-disabled="vm.validate_info!=undefined" ng-change="vm.asignar_LocalidadFis()">
        <option ng-repeat="dato in vm.TLocalidadesfiltrada" value="{{dato.CodLoc}}">{{dato.DesLoc}}</option>                         
        </select>
       </div>
       </div>
       </div>
         <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Código Postal</label>
       <input type="text" class="form-control" ng-model="vm.fdatos.CPLocSoc" placeholder="* Zona Postal Social" ng-change="vm.asignar_CPLoc()" ng-disabled="vm.validate_info!=undefined"/>
       </div>
       </div>
       </div>
       <div style="margin-top: 8px;">
       <div align="center"><label class="font-weight-bold nexa-dark" style="color:#6d6e71;"><b>DOMICILIO FISCAL</b></label></div></div>
        <div align="left">
        <input type="checkbox" ng-model="vm.fdatos.distinto_a_social" ng-disabled="vm.validate_info!=undefined || vm.fdatos.CodTipViaSoc==undefined|| vm.fdatos.NomViaDomSoc==undefined|| vm.fdatos.NumViaDomSoc==undefined|| vm.fdatos.CodProSoc==undefined|| vm.fdatos.CodLocSoc==undefined" ng-click="vm.distinto_a_social()"/><label class="font-weight-bold nexa-dark" style="color:black;">&nbsp;<b>Distinto a Domicilio Social</b></label> 
       </div>

       <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Tipo de Via <b style="color:red;" >(*)</b></label>
       <select class="form-control" id="CodTipViaFis" name="CodTipViaFis"  placeholder="* Tipo de Via" ng-model="vm.fdatos.CodTipViaFis" ng-disabled="vm.validate_info!=undefined ||vm.fdatos.distinto_a_social==false">
         <option ng-repeat="dato in vm.tTiposVias" value="{{dato.CodTipVia}}">{{dato.DesTipVia}} - {{dato.IniTipVia}}</option>                        
        </select>
       </div>
       </div>
       </div>

      <div class="col-12 col-sm-5">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Nombre de la Vía <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fdatos.NomViaDomFis" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Nombre de la Via del Domicilio del Cliente" maxlength="30"  ng-disabled="vm.validate_info!=undefined||vm.fdatos.distinto_a_social==false"/>       
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Número de la Vía <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fdatos.NumViaDomFis" onkeyup="this.value=this.value.toUpperCase();"  min="1" placeholder="* Numero del Domicilio" maxlength="3" ng-disabled="vm.validate_info!=undefined||vm.fdatos.distinto_a_social==false" ng-change="vm.validar_fecha_blo(3,vm.fdatos.NumViaDomFis)"/>       
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Bloque</label>
       <input type="text" class="form-control" ng-model="vm.fdatos.BloDomFis" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Bloque del Domicilio" maxlength="3" ng-disabled="vm.validate_info!=undefined||vm.fdatos.distinto_a_social==false"/>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Escalera</label>
       <input type="text" class="form-control" ng-model="vm.fdatos.EscDomFis" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Escalera del Domicilio" maxlength="2" ng-disabled="vm.validate_info!=undefined||vm.fdatos.distinto_a_social==false"/>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Planta</label>
       <input type="text" class="form-control" ng-model="vm.fdatos.PlaDomFis" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Planta del Domicilio" maxlength="2" ng-disabled="vm.validate_info!=undefined||vm.fdatos.distinto_a_social==false"/>
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Puerta</label>
       <input type="text" class="form-control" ng-model="vm.fdatos.PueDomFis" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Puerta del Domicilio" maxlength="4" ng-disabled="vm.validate_info!=undefined||vm.fdatos.distinto_a_social==false"/>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Provincia <b style="color:red;">(*)</b></label>
        <select class="form-control" id="CodProFisc" name="CodProFisc"  ng-model="vm.fdatos.CodProFis" ng-change="vm.BuscarLocalidad(2,vm.fdatos.CodProFis)"  ng-disabled="vm.validate_info!=undefined||vm.fdatos.distinto_a_social==false">
        <option ng-repeat="dato in vm.tProvidencias" value="{{dato.CodPro}}">{{dato.DesPro}}</option>                          
        </select>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Localidad <b style="color:red;">(*)</b></label>
       <select class="form-control" id="CodLocFis" name="CodLocFis" ng-model="vm.fdatos.CodLocFis" ng-disabled="vm.validate_info!=undefined||vm.fdatos.distinto_a_social==false">
        <option ng-repeat="dato in vm.TLocalidadesfiltradaFisc" value="{{dato.CodLoc}}">{{dato.DesLoc}}</option>                         
        </select>
       </div>
       </div>
       </div>
         <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Código Postal</label>
       <input type="text" class="form-control" ng-model="vm.fdatos.CPLocFis" placeholder="* Zona Postal Fiscal" ng-disabled="vm.validate_info!=undefined||vm.fdatos.distinto_a_social==false"/>
       </div>
       </div>
       </div>





       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Teléfono <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fdatos.TelFijCli" ng-change="vm.validar_fecha_blo(2,vm.fdatos.TelFijCli)" placeholder="* Telefono del Cliente" maxlength="14"  ng-disabled="vm.validate_info!=undefined"/>       
       </div>
       </div>
       </div>
       
       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Email <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" id="EmaCli" ng-model="vm.fdatos.EmaCli" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Correo Electrónico del Cliente" maxlength="50"ng-disabled="vm.validate_info!=undefined" ng-change="vm.validar_email()"/>
       <span id="emailOK"></span>       
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Página Web</label>
       <input type="url" class="form-control" ng-model="vm.fdatos.WebCli" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Pagina Web del Cliente" maxlength="50"  ng-disabled="vm.validate_info!=undefined"/>       
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Comercial <b style="color:red;" >(*)</b></label>
        <select class="form-control" id="CodCom" name="CodCom"  ng-model="vm.fdatos.CodCom" ng-disabled="vm.validate_info!=undefined"> 
          <option ng-repeat="dato in vm.tComerciales" value="{{dato.CodCom}}">NIF: {{dato.NIFCom}} - {{dato.NomCom}}</option>                          
        </select>       
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Colaborador</label>
        <select class="form-control" id="CodCol" name="CodCol"  ng-model="vm.fdatos.CodCol" ng-disabled="vm.validate_info!=undefined"> 
          <option ng-repeat="dato in vm.tColaboradores" value="{{dato.CodCol}}">{{dato.NomCol}}</option>                          
        </select>       
       </div>
       </div>
       </div>

     
       <div class="form">                          
       <div class="form-group">
        <textarea class="form-control" style="display: inline-block;" onkeyup="this.value=this.value.toUpperCase();" id="ObsCli" name="ObsCli" type="text" minlength="1" maxlength="200" rows="5"  ng-model="vm.fdatos.ObsCli" ng-disabled="vm.validate_info!=undefined"></textarea>
        <input class="form-control" id="CodCli" name="CodCli" type="hidden" ng-model="vm.fdatos.CodCli" readonly/>
       </div>
       </div>
      
         <div class="form-group" >
          <div class="col-12 col-sm-6">
            <button class="btn btn-info" type="submit" ng-show="vm.fdatos.CodCli==undefined||vm.fdatos.CodCli==null||vm.fdatos.CodCli==''" ng-disabled="vm.disabled_button_by_email==true">Grabar</button>
            <button class="btn btn-success" type="submit" ng-show="vm.fdatos.CodCli>0 && vm.validate_info==undefined" ng-disabled="vm.validate_info!=undefined || vm.disabled_button_by_email==true" >Actualizar</button>
            
            <!--button class="btn btn-danger" type="button"  ng-click="vm.borrar()" ng-show="vm.fdatos.CodCli>0 && vm.validate_info==undefined" ng-disabled="vm.Nivel==3 || vm.validate_info!=undefined">BORRAR</button-->

            <!--button class="btn btn-warning" type="button" ng-click="vm.limpiar()" ng-show="vm.fdatos.CodCli==undefined||vm.fdatos.CodCli==null||vm.fdatos.CodCli==''">LIMPIAR</button-->
            <button class="btn btn-primary" type="button" style="margin-top: 10px;" ng-click="vm.regresar()">Volver</button>
          </div>
        </div>
         </div><!--FINAL ROW -->
        </form>





<script>
  $('.datepicker').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});   

  $('#FecIniCli').on('changeDate', function() 
  {
     var FecIniCli=document.getElementById("FecIniCli").value;
     console.log("FecIniCli: "+FecIniCli);
  });
</script>








              </div><!--FINAL PANEL-BODY-->
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

<div id="crear_clientes" class="loader loader-default"  data-text="Creando o Actualizando Comercial"></div>
<div id="cargando" class="loader loader-default"  data-text="Cargando listado de Comerciales"></div>

<div id="Actualizando" class="loader loader-default" data-text="Actualizando Cliente"></div>
<div id="Guardando" class="loader loader-default" data-text="Grabando Cliente"></div>
<div id="cargando_I" class="loader loader-default"  data-text="Cargando Información del Cliente"></div>


</html>
