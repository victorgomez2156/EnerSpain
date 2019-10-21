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
  <link href="application/libraries/estilos/css/daterangepicker.css" rel="stylesheet" />
  <link href="application/libraries/estilos/css/bootstrap-datepicker.css" rel="stylesheet" />
  <link href="application/libraries/estilos/css/bootstrap-colorpicker.css" rel="stylesheet" />
  
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
  .table-responsive {
    min-height: .01%;
    overflow-x: auto
}

@media screen and (max-width:767px) {
    .table-responsive {
        width: 100%;
        margin-bottom: 15px;
        overflow-y: hidden;
        -ms-overflow-style: -ms-autohiding-scrollbar;
        border: 1px solid #ddd
    }

    .table-responsive > .table {
        margin-bottom: 0
    }

    .table-responsive > .table > tbody > tr > td, .table-responsive > .table > tbody > tr > th,
    .table-responsive > .table > tfoot > tr > td, .table-responsive > .table > tfoot > tr > th,
    .table-responsive > .table > thead > tr > td, .table-responsive > .table > thead > tr > th {
        white-space: nowrap
    }

    .table-responsive > .table-bordered {
        border: 0
    }

    .table-responsive > .table-bordered > tbody > tr > td:first-child, .table-responsive > .table-bordered > tbody > tr > th:first-child,
    .table-responsive > .table-bordered > tfoot > tr > td:first-child, .table-responsive > .table-bordered > tfoot > tr > th:first-child,
    .table-responsive > .table-bordered > thead > tr > td:first-child, .table-responsive > .table-bordered > thead > tr > th:first-child {
        border-left: 0
    }

    .table-responsive > .table-bordered > tbody > tr > td:last-child, .table-responsive > .table-bordered > tbody > tr > th:last-child,
    .table-responsive > .table-bordered > tfoot > tr > td:last-child, .table-responsive > .table-bordered > tfoot > tr > th:last-child,
    .table-responsive > .table-bordered > thead > tr > td:last-child, .table-responsive > .table-bordered > thead > tr > th:last-child {
        border-right: 0
    }

    .table-responsive > .table-bordered > tbody > tr:last-child > td, .table-responsive > .table-bordered > tbody > tr:last-child > th,
    .table-responsive > .table-bordered > tfoot > tr:last-child > td, .table-responsive > .table-bordered > tfoot > tr:last-child > th {
        border-bottom: 0
    }
}
</style>
</head>

<body>
 <div ng-controller="Controlador_Comercializadora as vm">
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header" ng-show="vm.fdatos.CodCom==undefined"><i class="fa fa-users"></i> Registro de Comercializadora </h3>
            <h3 class="page-header" ng-show="vm.fdatos.CodCom>0"><i class="fa fa-users"></i> Actualización de Datos de Comercializadora</h3>
            <ol class="breadcrumb">
            
             <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>             
              
              <li ng-show="vm.fdatos.CodCom==undefined"><i class="fa fa-users"></i>Registro de Comercializadora</li>
              <li ng-show="vm.fdatos.CodCom>0"><i class="fa fa-users"></i>Actualización de Datos de Comercializadora</li>
            </ol>
          </div>
        </div>
        <!-- Form validations -->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading" style="color:black;">
                <b>Datos Básicos de la Comercializadora:</b>
              </header>
              <div class="panel-body">              
             

               <div id="tabs_clientes" class="ui-tabs-nav ui-corner-all">
      <ul>
	      <li>
	      	<a href="#tabs-1"><i class="fa fa-user-circle"></i> Datos Básicos</a>
	      </li>
	      <li ng-show="vm.fdatos.CodCom>0">
	      <a href="#tabs-2"><i class="fa fa-briefcase"></i> Productos</a>
	      </li>
	      <li ng-show="vm.fdatos.CodCom>0">
	      <a href="#tabs-3"><i class="fa fa-bullseye"></i> Anexos</a>
	      </li>
	      <li ng-show="vm.fdatos.CodCom>0">
	      <a href="#tabs-4"><i class="fa fa-child"></i> Servicios Adicionales</a>
	      </li>
	      <li ng-show="vm.fdatos.CodCom>0">
	      <a href="#tabs-5"><i class="fa fa-bank"></i> Comisiones</a>
	      </li>
     </ul>

         <!--INICIO TABS 1 DATOS Básicos DE la Comercializadora -->
  <div id="tabs-1">          
   
    
    <form id="register_form" name="register_form" ng-submit="submitForm($event)"> 
     <div class='row'>              
       <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">CIF <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fdatos.NumCifCom" maxlength="8" readonly ng-disabled="vm.validate_cif==1" placeholder="* Número del CIF de la Comercializadora Comercial"/>
       
       </div>
       </div>
       </div>       
       <div class="col-12 col-sm-4">
       <div class="form"> 
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;"><i class="fa fa-calendar"></i> Fecha de Inicio</label>       
        <div class="input-append date" id="dpYears" data-date="18-06-2013" data-date-format="dd-mm-yyyy" data-date-viewmode="years">
          <input class="form-control" size="16" type="text" placeholder="mm/dd/yyyy" readonly ng-model="vm.FecIniCom" ng-disabled="vm.validate_info==1">      
      </div>
      
       </div>
       </div>
       </div>
        <br><br><br><br>

       <div class="col-12 col-sm-12">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Razón Social <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fdatos.RazSocCom" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Razón Social de la Comercializadora" maxlength="50" ng-disabled="vm.validate_info==1" ng-change="vm.asignar_a_nombre_comercial()"/>       
       </div>
       </div>
       </div>
      <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Nombre Comercial <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fdatos.NomComCom" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Razón Social de la Comercializadora" maxlength="50" ng-disabled="vm.fdatos.misma_razon==false || vm.validate_info==1"/>
       </div>
       </div>
       </div>
      <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Distinto a Razón Social</label>
       <input type="checkbox" class="form-control" ng-model="vm.fdatos.misma_razon" ng-disabled="vm.validate_info==1" ng-click="vm.misma_razon(vm.fdatos.misma_razon)"/>       
       </div>
       </div>
       </div> 
          
      <div style="margin-top: 8px;">
       <div align="center"><label class="font-weight-bold nexa-dark" style="color:blue;"><b>DIRECCIÓN</b></label></div></div>
      
      <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Tipo de Vía <b style="color:red;">(*)</b></label>
       <select class="form-control" id="CodTipVia" name="CodTipVia"  placeholder="* Tipo de Vía" ng-model="vm.fdatos.CodTipVia" ng-disabled="vm.validate_info==1">
         <option ng-repeat="dato in vm.tTiposVias" value="{{dato.CodTipVia}}">{{dato.DesTipVia}} - {{dato.IniTipVia}}</option>                        
        </select>
       </div>
       </div>
       </div>

      <div class="col-12 col-sm-5">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Nombre de la Vía <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fdatos.NomViaDirCom" onkeyup="this.value=this.value.toUpperCase();" ng-change="vm.asignar_domicilio()" placeholder="* Nombre de la Vía" maxlength="30"  ng-disabled="vm.validate_info==1"/>       
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Número de la Vía <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fdatos.NumViaDirCom" onkeyup="this.value=this.value.toUpperCase();" min="1" ng-change="vm.asignar_num_domicilio()" placeholder="* Numero del Domicilio" maxlength="3" ng-disabled="vm.validate_info==1"/>       
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Bloque</label>
       <input type="text" class="form-control" ng-model="vm.fdatos.BloDirCom" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Bloque del Domicilio" maxlength="3" ng-change="vm.asignar_bloq_domicilio()" ng-disabled="vm.validate_info==1"/>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Escalera</label>
       <input type="text" class="form-control" ng-model="vm.fdatos.EscDirCom" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Escalera del Domicilio" ng-change="vm.asignar_esc_domicilio()" maxlength="2" ng-disabled="vm.validate_info==1"/>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Planta</label>
       <input type="text" class="form-control" ng-model="vm.fdatos.PlaDirCom" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Planta del Domicilio" ng-change="vm.asignar_pla_domicilio()" maxlength="2" ng-disabled="vm.validate_info==1"/>
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Puerta</label>
       <input type="text" class="form-control" ng-model="vm.fdatos.PueDirCom" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Puerta del Domicilio" ng-change="vm.asignar_puer_domicilio()" maxlength="4" ng-disabled="vm.validate_info==1"/>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Provincia <b style="color:red;">(*)</b></label>
        <select class="form-control" id="CodPro" name="CodPro"  ng-model="vm.fdatos.CodPro" ng-change="vm.filtrarLocalidadCom()" ng-disabled="vm.validate_info==1">
        <option ng-repeat="dato in vm.TProvincias" value="{{dato.CodPro}}">{{dato.DesPro}}</option>                          
        </select>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Localidad <b style="color:red;">(*)</b></label>
       <select class="form-control" id="CodLoc" name="CodLoc" ng-change="vm.filtrar_zona_postal()"  ng-model="vm.fdatos.CodLoc" ng-disabled="vm.validate_info==1">
        <option ng-repeat="dato in vm.TLocalidadesfiltrada" value="{{dato.CodLoc}}">{{dato.DesLoc}}</option>                         
        </select>
       </div>
       </div>
       </div>
         <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Código Postal</label>
       <input type="text" class="form-control" ng-model="vm.fdatos.ZonPos" placeholder="* Zona Postal" readonly ng-disabled="vm.validate_info==1"/>
       </div>
       </div>
       </div>


       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Teléfono Fijo<b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fdatos.TelFijCom" ng-change="vm.validarsinuermo(vm.fdatos.TelFijCom)" placeholder="* Telefono de la Comercializadora" maxlength="9"  ng-disabled="vm.validate_info==1"/>       
       </div>
       </div>
       </div>
       
       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Email <b style="color:red;">(*)</b></label>
       <input type="email" class="form-control" ng-model="vm.fdatos.EmaCom" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Correo Electrónico de la Comercializadora" maxlength="50"  ng-disabled="vm.validate_info==1"/>       
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Página Web</label>
       <input type="url" class="form-control" ng-model="vm.fdatos.PagWebCom" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Pagina Web de la Comercializadora" maxlength="50"  ng-disabled="vm.validate_info==1"/>       
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Persona Contacto <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fdatos.NomConCom" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Nombre Persona Contacto" maxlength="50"  ng-disabled="vm.validate_info==1"/>       
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Cargo Persona Contacto <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fdatos.CarConCom" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Cargo Persona Contacto" maxlength="50"  ng-disabled="vm.validate_info==1"/>       
       </div>
       </div>
       </div>
         <div style="margin-top: 8px;">
       <div align="center"><label class="font-weight-bold nexa-dark" style="color:blue;"><b>Tipo de Servicios</b></label></div></div>

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">SUMINISTRO ELÉCTRICO</label>
       <input type="checkbox" class="form-control" ng-model="vm.fdatos.SerEle"  ng-disabled="vm.validate_info==1"/>       
       </div>
       </div>
       </div>
       
       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">SUMINISTRO GAS</label>
       <input type="checkbox" class="form-control" ng-model="vm.fdatos.SerGas"  ng-disabled="vm.validate_info==1"/>       
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">SERVICIOS ADICIONALES</label>
       <input type="checkbox" class="form-control" ng-model="vm.fdatos.SerEsp"  ng-disabled="vm.validate_info==1"/>        
       </div>
       </div>
       </div>
      
      <div class="form">                          
       <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Fotocopia del Contrato <a title='Descargar Documento' ng-show="vm.fdatos.DocConCom!=null && vm.fdatos.CodCom>0" href="{{vm.fdatos.DocConCom}}" download class="btn btn-info btn-icon mg-r-5"><div><i class="fa fa-download" style="color:white;"></i></div></a>   </label>
         
      	<input type="file" id="file"  accept="*/*" class="form-control btn-info"  uploader-model="file" ng-disabled="vm.validate_info==1">


       </div>
       </div>


       <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;"><i class="fa fa-calendar"></i> Fecha de Contrato</label>
       <input type="text" class="form-control" ng-model="vm.FecConCom" id="FechaInCont" onkeyup="this.value=this.value.toUpperCase();" ng-change="vm.validar_fecha(1,vm.FecConCom)" ng-blur="vm.calcular_anos()" placeholder="DD/MM/YYYY" ng-disabled="vm.validate_info==1"/>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;"><i class="fa fa-clock-o"></i> Duración</label>
       <input type="text" class="form-control" ng-model="vm.fdatos.DurConCom" readonly onkeyup="this.value=this.value.toUpperCase();" placeholder="Duración del Contrato" maxlength="11" ng-disabled="vm.validate_info==1"/>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;"><i class="fa fa-ban"></i> Vencimiento</label>
       <input type="text" class="form-control" ng-model="vm.FecVenConCom" id="FecVenConCom" ng-change="vm.validar_fecha(2,vm.FecVenConCom)" ng-blur="vm.calcular_anos()" placeholder="DD/MM/YYYY" ng-disabled="vm.validate_info==1"/>
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;"><i class="fa fa-refresh"></i> Renovación Automatica</label>
       <input type="checkbox" class="form-control" ng-model="vm.fdatos.RenAutConCom" ng-disabled="vm.validate_info==1"/>
       </div>
       </div>
       </div>
     
       <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:black;"><i class="fa fa-adjust"></i> Observación</label>
        <textarea class="form-control" style="display: inline-block;" onkeyup="this.value=this.value.toUpperCase();" id="ObsCom" name="ObsCom" type="text" minlength="1" maxlength="200" rows="5"  ng-model="vm.fdatos.ObsCom" ng-disabled="vm.validate_info==1"></textarea>
        <input class="form-control" id="CodCom" name="CodCom" type="hidden" ng-model="vm.fdatos.CodCom" readonly/>
       </div>
       </div>
      
         <div class="form-group" >
          <div class="col-12 col-sm-6">
            <button class="btn btn-info" type="submit" ng-show="vm.fdatos.CodCom==undefined||vm.fdatos.CodCom==null||vm.fdatos.CodCom==''" ng-disabled="vm.disabled_button==1">REGISTRAR</button>
            <button class="btn btn-success" type="submit" ng-show="vm.fdatos.CodCom>0 && vm.validate_info==undefined" ng-disabled="vm.validate_info==1 || vm.disabled_button==1" >ACTUALIZAR</button>
            
            <!--button class="btn btn-danger" type="button"  ng-click="vm.borrar()" ng-show="vm.fdatos.CodCom>0 && vm.validate_info==undefined" ng-disabled="vm.Nivel==3 || vm.validate_info==1">BORRAR</button-->

            <button class="btn btn-primary" type="button" style="margin-top: 10px;" ng-click="vm.regresar()">REGRESAR</button>
          </div>
        </div>
         </div><!--FINAL ROW -->
        </form>
   
  </div><!--FINAL TABS 1 DATOS Básicos DE la Comercializadora -->

      <!--INICIO TABS 2-->
<div id="tabs-2">
	<!--t-0002 start-->
<div ng-show="vm.TvistaProductos==1">                 
	<div id="t-0002">
  		<div style="float:left;margin-left: 0px;padding: 10px;margin-top: 10px;margin-bottom: 2px;" class="removeForMobile">                   
    		<div class="t-0029">
      			<div class="t-0031" style="margin-top: -8px; ">
                    <div class="btn-group">
                      <button data-toggle="dropdown" title="Agregar Columnas" class="btn btn-default" type="button"><i class="fa fa-columns"></i> <span class="caret"></span></button>
                      <ul class="dropdown-menu">
                        <li><input type="checkbox" ng-model="vm.CodTCom"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Comercializadora</b></li></li>
                        <li><input type="checkbox" ng-model="vm.DesTPro"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Descripción</b></li></li>
                        <li><input type="checkbox" ng-model="vm.SerTGas"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Servicio Gas</b></li>
                        <li><input type="checkbox" ng-model="vm.SerTEle"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Servicio Eléctrico</b></li>
                        <li><input type="checkbox" ng-model="vm.ObsTPro"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Observación</b></li>
                        <li><input type="checkbox" ng-model="vm.FecIniTPro"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Fecha Inicio Pro</b></li>		<li><input type="checkbox" ng-model="vm.EstTPro"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Estatus</b></li>
                        <li><input type="checkbox" ng-model="vm.AccTPro"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Accion</b></li>
                      </ul> 
                    </div>                    
                    <div class="btn-group">
                      <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button"><i class="fa fa-cloud-upload"></i><span class="caret"></span> </button>
                      <ul class="dropdown-menu">
                        <li style="cursor: pointer;"><a ><i class="fa fa-file"></i> Exportar en PDF</a></li>
                        <li style="cursor: pointer;"><a ><i class="fa fa-file-excel-o"></i> Exportar en Excel</a></li>                        
                      </ul>
                    </div>
                    <div class="btn-group">
                       <a data-toggle="modal" title='Filtrar Productos' data-target="#modal_filtros_productos" class="btn btn-default"><div><i class="fa fa-filter"></i><span class="caret"></span></div></a>
                   </div>
    			</div>
  			</div>
		</div>              
        <div style="float:right;margin-left: 0px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
            <div class="t-0029">
                <form class="form-inline" role="form">
                    <div class="form-group">
                      <input type="text" class="form-control" ng-model="vm.filtrar" minlength="1" id="exampleInputEmail2" placeholder="Escribe para filtrar...">
                    </div>                 
                    <button style="margin-right: 10px;" class="btn btn-info" title="Agregar Productos" ng-click="vm.agg_productos()"><i class="fa fa-plus-square"></i></button>
                  </form>                    
                  </div>
            </div>
	</div>  
<!--t-0002 end--> 
<br><br><br><br>
      <div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive" ng-init="vm.cargar_lista_productos()">
                <tbody>
                  <tr>
                   
                    <th ng-show="vm.CodTCom==true"><i class="icon_cogs"></i> Comercializadora</th>
                    <th ng-show="vm.DesTPro==true"><i class="icon_cogs"></i> Producto</th>
                    <th ng-show="vm.SerTGas==true"><i class="icon_cogs"></i> Servicio Gas</th>
                    <th ng-show="vm.SerTEle==true"><i class="icon_cogs"></i> Servicio Eléctrico</th>
                    <th ng-show="vm.ObsTPro==true"><i class="icon_cogs"></i> Observación</th>
                    <th ng-show="vm.FecIniTPro==true"><i class="icon_cogs"></i> Fecha Inicio Pro</th>
                    <th ng-show="vm.EstTPro==true"><i class="icon_cogs"></i> Estatus</th>
                    <th ng-show="vm.AccTPro==true"><i class="icon_cogs"></i> Acción</th>
                  </tr> 
                  <tr ng-show="vm.TProductos==undefined"> 
                    <td colspan="9" align="center"><div class="td-usuario-table"><i class="fa fa-close"></i> Actualmente no hay datos disponibles.</div></td>
                  </tr>
                  <tr ng-repeat="dato in vm.TProductos | filter:paginate1 | filter:vm.filtrar" ng-class-odd="odd">                   
                    <td ng-show="vm.CodTCom==true">{{dato.NumCifCom}} - {{dato.RazSocCom}}</td>                  
                    <td ng-show="vm.DesTPro==true">{{dato.DesPro}}</td>
                    <td ng-show="vm.SerTGas==true">{{dato.SerGas}}</td>
                    <td ng-show="vm.SerTEle==true">{{dato.SerEle}}</td>
                    <td ng-show="vm.ObsTPro==true">{{dato.ObsPro}}</td>
                    <td ng-show="vm.FecIniTPro==true">{{dato.FecIniPro}}</td>
                    <td ng-show="vm.EstTPro==true">
                      <span class="label label-info" ng-show="dato.EstPro=='ACTIVO'"><i class="fa fa-check-circle"></i> {{dato.EstPro}}</span>
                      <span class="label label-danger" ng-show="dato.EstPro=='BLOQUEADO'"><i class="fa fa-ban"></i> {{dato.EstPro}}</span>
                    </td>
                    <td ng-show="vm.AccTPro==true">
                      <div class="btn-group">
                        <select class="form-control" id="opciones_productos" name="opciones_productos" ng-model="vm.opciones_productos[$index]" ng-change="vm.validar_opcion_productos($index,vm.opciones_productos[$index],dato)">
                          <option ng-repeat="opcion in vm.Topciones_Grib" value="{{opcion.id}}">{{opcion.nombre}}</option>                          
                        </select>
                      </div>
                    </td>
                  </tr>
                </tbody>
                <tfoot>
                    <th ng-show="vm.CodTCom==true"><i class="icon_cogs"></i> Comercializadora</th>
                    <th ng-show="vm.DesTPro==true"><i class="icon_cogs"></i> Producto</th>
                    <th ng-show="vm.SerTGas==true"><i class="icon_cogs"></i> Servicio Gas</th>
                    <th ng-show="vm.SerTEle==true"><i class="icon_cogs"></i> Servicio Eléctrico</th>
                    <th ng-show="vm.ObsTPro==true"><i class="icon_cogs"></i> Observación</th>
                    <th ng-show="vm.FecIniTPro==true"><i class="icon_cogs"></i> Fecha Inicio Pro</th>
                    <th ng-show="vm.EstTPro==true"><i class="icon_cogs"></i> Estatus</th>
                    <th ng-show="vm.AccTPro==true"><i class="icon_cogs"></i> Acción</th>
                </tfoot>
              </table>
        </div>
         <div align="center">
          <span class="store-qty"> <a ng-click="vm.cargar_lista_productos()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       
          <div class='btn-group' align="center">
            <pagination total-items="totalItems1" ng-model="currentPage1" max-size="5" boundary-links="true" items-per-page="numPerPage1" class="pagination-sm">  
            </pagination>
          </div>
        </div>




  <!-- modal container section start -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_motivo_bloqueo_productos" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title"><i class="fa fa-ban"></i> Bloqueo de Productos</h4>
          </div>
          <div class="modal-body">
                        <div class="panel"> 
      <input type="hidden" class="form-control" ng-model="vm.t_modal_data.CodPro" required readonly />
      <form class="form-validate" id="form_lockPro" name="form_lockPro" ng-submit="submitFormlockPro($event)">                 
     
    <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Comercializadora</label>
     <input type="text" class="form-control" ng-model="vm.Comercializadora" readonly />
     </div>
     </div>

      
    <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Producto</label>
     <input type="text" class="form-control" ng-model="vm.Producto" readonly />
     </div>
     </div>

     <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Motivo del Bloqueo <b style="color:red;">(*)</b></label>
      <input type="text" class="form-control" ng-model="vm.t_modal_data.MotBloPro" required /> 
     </div>
     </div>
     </div>

    <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Fecha de Bloqueo</label>
     <input type="text" class="form-control" ng-model="vm.fecha_bloqueo" readonly/>    
     </div>
     </div>
     </div>

     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Observación</label>
     <textarea type="text" class="form-control" ng-model="vm.t_modal_data.ObsBloPro" rows="5" maxlength="100"/></textarea>
     </div>
     </div>
    
    <br>
     <button class="btn btn-info" type="submit" ng-disabled="form_lockPro.$invalid">Bloquear</button>
      <a class="btn btn-danger" data-dismiss="modal">Regresar</a>
</form>
   </div>
    </div>
</div>
</div>
</div>
<!-- modal container section end -->
 <!-- modal container section start -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_filtros_productos" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Tipos de Filtros</h4>
          </div>
          <div class="modal-body">
                        <div class="panel">                  
      <form class="form-validate" id="frmfiltroproductos" name="frmfiltroproductos" ng-submit="SubmitFormFiltrosClientes($event)">                 
     
     <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">TIPO DE FILTRO</label>
      <select class="form-control" id="ttipofiltrosProductos" name="ttipofiltrosProductos" required ng-model="vm.tmodal_data.ttipofiltrosProductos">
          <option ng-repeat="dato in vm.ttipofiltrosProductos" value="{{dato.id}}">{{dato.nombre}}</option>
        </select>     
     </div>
     </div>
     </div>
     <br>
     <br>
     <br>
     <br> 

     <div class="col-12 col-sm-6" ng-show="vm.tmodal_data.ttipofiltrosProductos==1">
     <div class="form">                          
     <div class="form-group">
     
      <select class="form-control" id="TipServ" name="TipServ" ng-model="vm.tmodal_data.TipServ">
        <option ng-repeat="dato in vm.TipServ" value="{{dato.id}}">{{dato.nom_serv}}</option>                        
      </select>   
     </div>
     </div>
    </div>
 

   
    <br ng-show="vm.tmodal_data.ttipofiltrosProductos==1">
     <br ng-show="vm.tmodal_data.ttipofiltrosProductos==1"> 
    <br>
    <div style="margin-left:15px; ">
     <button class="btn btn-info" type="submit" ng-disabled="frmfiltroproductos.$invalid">APLICAR</button>
      <a class="btn btn-danger" ng-click="vm.regresar_filtro()">LIMPIAR</a>
      </div>
</form>
   </div>
    </div>
</div>
</div>
</div>
<!--modal container section end -->

 </div> 



<div ng-show="vm.TvistaProductos==2">
  
<form id="register_form" name="register_form" ng-submit="submitFormProductos($event)" ng-init="vm.cargar_lista_ComAct()"> 
     <div class='row'>              
       <div class="col-12 col-sm-12">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Comercializadora <b style="color:red;">(*)</b></label>
       <select class="form-control" id="CodTProCom" name="CodTProCom" ng-model="vm.productos.CodTProCom" ng-disabled="vm.validate_info_productos==1">
         <option ng-repeat="dato in vm.TProComercializadoras" value="{{dato.CodCom}}">{{dato.RazSocCom}} - {{dato.NumCifCom}}</option>                        
        </select>
       
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Nombre del Producto <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.productos.DesPro" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Nombre del Producto" maxlength="50" ng-disabled="vm.validate_info_productos==1"/>       
       </div>
       </div>
       </div>
      
      <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Fecha de Inicio</label>
       <input type="text" class="form-control" ng-model="vm.FecIniPro" placeholder="* DD/MM/YYYY" maxlength="10" readonly ng-disabled="vm.validate_info_productos==1"/>
       </div>
       </div>
       </div>

      <div style="margin-top: 8px;">
       <div align="center"><label class="font-weight-bold nexa-dark" style="color:blue;"><b>TIPO DE SUMINISTROS</b></label></div></div>
      
      <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">SUMINISTRO ELÉCTRICO</label>
        <input type="checkbox" class="form-control" ng-model="vm.productos.SerGas" ng-disabled="vm.validate_info_productos==1"/>
       </div>
       </div>
       </div>
      <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">SUMINISTRO ELÉCTRICO</label>
        <input type="checkbox" class="form-control" ng-model="vm.productos.SerEle" ng-disabled="vm.validate_info_productos==1"/>
       </div>
       </div>
       </div>

      <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:black;"><i class="fa fa-adjust"></i> Observación</label>
        <textarea class="form-control" style="display: inline-block;" onkeyup="this.value=this.value.toUpperCase();" id="ObsPro" name="ObsPro" type="text" minlength="1" maxlength="200" rows="5"  ng-model="vm.productos.ObsPro" ng-disabled="vm.validate_info_productos==1"></textarea>
        
       </div>
       </div>    
      <input class="form-control" id="CodTPro" name="CodTPro" type="hidden" ng-model="vm.productos.CodTPro" readonly/>
         <div class="form-group" >
          <div class="col-12 col-sm-6">
            <button class="btn btn-info" type="submit" ng-show="vm.productos.CodTPro==undefined||vm.productos.CodTPro==null||vm.productos.CodTPro==''" ng-disabled="vm.disabled_button==1">REGISTRAR</button>
            <button class="btn btn-success" type="submit" ng-show="vm.productos.CodTPro>0 && vm.validate_info_productos==undefined" ng-disabled="vm.validate_info_productos==1">ACTUALIZAR</button>            
            <button class="btn btn-warning" type="button"  ng-click="vm.limpiar_productos()">LIMPIAR</button>
            <button class="btn btn-primary" type="button" style="margin-top: 10px;" ng-click="vm.regresar_productos()">REGRESAR</button>
          </div>
        </div>
         </div><!--FINAL ROW -->
        </form>






</div>




      </div>
      <!--FINAL TABS 2-->

      <!-- INICIO DE TABS 3-->
      <div id="tabs-3">
  <div ng-show="vm.TvistaAnexos==1">                 
	<div id="t-0002">
  		<div style="float:left;margin-left: 0px;padding: 10px;margin-top: 10px;margin-bottom: 2px;" class="removeForMobile">                   
    		<div class="t-0029">
      			<div class="t-0031" style="margin-top: -8px; ">
                    <div class="btn-group">
                      <button data-toggle="dropdown" title="Agregar Columnas" class="btn btn-default" type="button"><i class="fa fa-columns"></i> <span class="caret"></span></button>
                      <ul class="dropdown-menu">
                        <li><input type="checkbox" ng-model="vm.CodAnePro"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Comercializadora</b></li>
                        <li><input type="checkbox" ng-model="vm.CodAneTPro"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Producto</b></li></li>
                        <li><input type="checkbox" ng-model="vm.DesAnePro"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Descripción Anexo</b></li></li>
                        <li><input type="checkbox" ng-model="vm.SerGasAne"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Servicio Gas</b></li>
                        <li><input type="checkbox" ng-model="vm.SerTEleAne"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Servicio Eléctrico</b></li>
                        <li><input type="checkbox" ng-model="vm.ObsAnePro"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Observación</b></li>
                        <li><input type="checkbox" ng-model="vm.FecIniAne"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Fecha de Inicio</b></li>		<li><input type="checkbox" ng-model="vm.EstAne"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Estatus</b></li>
                        <li><input type="checkbox" ng-model="vm.AccTAne"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Accion</b></li>
                      </ul> 
                    </div>                    
                    <div class="btn-group">
                      <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button"><i class="fa fa-cloud-upload"></i><span class="caret"></span> </button>
                      <ul class="dropdown-menu">
                        <li style="cursor: pointer;"><a ><i class="fa fa-file"></i> Exportar en PDF</a></li>
                        <li style="cursor: pointer;"><a ><i class="fa fa-file-excel-o"></i> Exportar en Excel</a></li>                        
                      </ul>
                    </div>
                    <div class="btn-group">
                       <a data-toggle="modal" title='Filtrar Productos' data-target="#modal_filtros_anexos" class="btn btn-default"><div><i class="fa fa-filter"></i><span class="caret"></span></div></a>
                   </div>
    			</div>
  			</div>
		</div>              
        <div style="float:right;margin-left: 0px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
            <div class="t-0029">
                <form class="form-inline" role="form">
                    <div class="form-group">
                      <input type="text" class="form-control" ng-model="vm.filtrar_anexos" minlength="1" id="exampleInputEmail2" placeholder="Escribe para filtrar...">
                    </div>                 
                    <button style="margin-right: 10px;" class="btn btn-info" title="Agregar Anexos" ng-click="vm.agg_anexos()"><i class="fa fa-plus-square"></i></button>
                  </form>                    
                  </div>
            </div>
	</div>  
<!--t-0002 end--> 
<br><br><br><br>
      <div class="table-responsive" ng-init="vm.cargar_lista_anexos()">
          <table class="table table-striped table-advance table-hover table-responsive">
                <tbody>
                  <tr>
                    <th ng-show="vm.CodAnePro==true"><i class="icon_cogs"></i> Comercializadora</th>
                    <th ng-show="vm.CodAneTPro==true"><i class="icon_cogs"></i> Producto</th>
                    <th ng-show="vm.DesAnePro==true"><i class="icon_cogs"></i> Anexos</th>
                    <th ng-show="vm.SerGasAne==true"><i class="icon_cogs"></i> Servicio Gas</th>
                    <th ng-show="vm.SerTEleAne==true"><i class="icon_cogs"></i> Servicio Eléctrico</th>
                    <th ng-show="vm.ObsAnePro==true"><i class="icon_cogs"></i> Observación</th>
                    <th ng-show="vm.FecIniAne==true"><i class="icon_cogs"></i> Fecha Inicio</th>
                    <th ng-show="vm.EstAne==true"><i class="icon_cogs"></i> Estatus</th>
                    <th ng-show="vm.AccTAne==true"><i class="icon_cogs"></i> Acción</th>
                  </tr> 
                  <tr ng-show="vm.TAnexos==undefined"> 
                    <td colspan="9" align="center"><div class="td-usuario-table"><i class="fa fa-close"></i> Actualmente no hay datos disponibles.</div></td>
                  </tr>
                  <tr ng-repeat="dato in vm.TAnexos | filter:paginate2 | filter:vm.filtrar_anexos" ng-class-odd="odd">
                    <td ng-show="vm.CodAnePro==true">{{dato.NumCifCom}} - {{dato.RazSocCom}}</td>
                    <td ng-show="vm.CodAneTPro==true">{{dato.DesPro}}</td>                  
                    <td ng-show="vm.DesAnePro==true">{{dato.DesAnePro}}</td>
                    <td ng-show="vm.SerGasAne==true">{{dato.SerGas}}</td>
                    <td ng-show="vm.SerTEleAne==true">{{dato.SerEle}}</td>
                    <td ng-show="vm.ObsAnePro==true">{{dato.ObsAnePro}}</td>
                    <td ng-show="vm.FecIniAne==true">{{dato.FecIniAne}}</td>
                    
                    
                    <td ng-show="vm.EstAne==true">
                      <span class="label label-info" ng-show="dato.EstAne=='ACTIVO'"><i class="fa fa-check-circle"></i> {{dato.EstAne}}</span>
                      <span class="label label-danger" ng-show="dato.EstAne=='BLOQUEADO'"><i class="fa fa-ban"></i> {{dato.EstAne}}</span>
                    </td>
                    <td ng-show="vm.AccTAne==true">
                      <div class="btn-group">
                        <select class="form-control" id="opciones_anexos" name="opciones_anexos" ng-model="vm.opciones_anexos[$index]" ng-change="vm.validar_opcion_anexos($index,vm.opciones_anexos[$index],dato)">
                          <option ng-repeat="opcion in vm.Topciones_Grib" value="{{opcion.id}}">{{opcion.nombre}}</option>                          
                        </select>
                      </div>
                    </td>

                  </tr>
                </tbody>
                <tfoot>
                    <th ng-show="vm.CodAnePro==true"><i class="icon_cogs"></i> Comercializadora</th>
                    <th ng-show="vm.CodAneTPro==true"><i class="icon_cogs"></i> Producto</th>
                    <th ng-show="vm.DesAnePro==true"><i class="icon_cogs"></i> Anexos</th>
                    <th ng-show="vm.SerGasAne==true"><i class="icon_cogs"></i> Servicio Gas</th>
                    <th ng-show="vm.SerTEleAne==true"><i class="icon_cogs"></i> Servicio Eléctrico</th>
                    <th ng-show="vm.ObsAnePro==true"><i class="icon_cogs"></i> Observación</th>
                    <th ng-show="vm.FecIniAne==true"><i class="icon_cogs"></i> Fecha Inicio</th>
                    <th ng-show="vm.EstAne==true"><i class="icon_cogs"></i> Estatus</th>
                    <th ng-show="vm.AccTAne==true"><i class="icon_cogs"></i> Acción</th>
                </tfoot>
              </table>
        </div> 
          <div align="center">
          <span class="store-qty"> <a ng-click="vm.cargar_lista_anexos()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       
          <div class='btn-group' align="center">
            <pagination total-items="totalItems2" ng-model="currentPage2" max-size="5" boundary-links="true" items-per-page="numPerPage2" class="pagination-sm">  
            </pagination>
          </div>
        </div>

 <!-- modal container section start -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_filtros_anexos" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Tipos de Filtros</h4>
          </div>
          <div class="modal-body">
                        <div class="panel">                  
      <form class="form-validate" id="frmfiltroAnexos" name="frmfiltroAnexos" ng-submit="SubmitFormFiltrosAnexos($event)">                 
     
     <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">TIPO DE FILTRO</label>
      <select class="form-control" id="ttipofiltrosAnexos" name="ttipofiltrosAnexos" required ng-model="vm.tmodal_data.ttipofiltrosAnexos">
          <option ng-repeat="dato in vm.ttipofiltrosAnexos" value="{{dato.id}}">{{dato.nombre}}</option>
        </select>     
     </div>
     </div>
     </div>
     <br>
     <br>
     <br>
     <br> 

     <div class="col-12 col-sm-6" ng-show="vm.tmodal_data.ttipofiltrosAnexos==1">
     <div class="form">                          
     <div class="form-group">
     
      <select class="form-control" id="TipServ" name="TipServ" ng-model="vm.tmodal_data.TipServ">
        <option ng-repeat="dato in vm.TipServ" value="{{dato.id}}">{{dato.nom_serv}}</option>                        
      </select>   
     </div>
     </div>
    </div>   
    <br ng-show="vm.tmodal_data.ttipofiltrosAnexos==1">
     <br ng-show="vm.tmodal_data.ttipofiltrosAnexos==1"> 
    <br>
    <div style="margin-left:15px; ">
     <button class="btn btn-info" type="submit" ng-disabled="frmfiltroAnexos.$invalid">APLICAR</button>
      <a class="btn btn-danger" ng-click="vm.regresar_filtro()">LIMPIAR</a>
      </div>
</form>
   </div>
    </div>
</div>
</div>
</div>
<!--modal container section end -->


<!-- modal container section end -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_motivo_bloqueo_anexos" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title"><i class="fa fa-ban"></i> Bloqueo de Anexos</h4>
          </div>
          <div class="modal-body">
                        <div class="panel"> 
    <input type="text" class="form-control" ng-model="vm.anexos_motivo_bloqueos.CodAnePro" required readonly />
      <form class="form-validate" id="form_lock_Anexos" name="form_lock_Anexos" ng-submit="submitFormlockAnexos($event)">                 
     
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">COMERCIALIZADORA</label>
     <input type="text" class="form-control" ng-model="vm.RazSocCom_BloAne" required readonly/>     
     </div>
     </div>

     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">PRODUCTO</label>
      <input type="text" class="form-control" ng-model="vm.DesPro_BloAne" required readonly />     
     </div>
     </div>

      <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">ANEXO</label>
      <input type="text" class="form-control" ng-model="vm.DesAnePro_BloAne" required readonly />     
     </div>
     </div>
<div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">MOTIVO DEL BLOQUEO</label>
       <input type="text" class="form-control" ng-model="vm.anexos_motivo_bloqueos.MotBloAne" required/> 
     </div>
     </div>
    
</div>
    <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Fecha de Bloqueo</label>
     <input type="text" class="form-control" ng-model="vm.FecBloAne" required readonly/>    
     </div>
     </div>
     </div>

     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Observación</label>
     <textarea type="text" class="form-control" ng-model="vm.anexos_motivo_bloqueos.ObsMotBloAne" rows="5" maxlength="100"/></textarea>
     </div>
     </div>
    
    <br>
     <button class="btn btn-info" type="submit" ng-disabled="form_lock_Anexos.$invalid">Bloquear</button>
      <a class="btn btn-danger" data-dismiss="modal">Regresar</a>
</form>
   </div>
    </div>
</div>
</div>
</div>
<!-- modal container section end -->









 </div> 

<div ng-show="vm.TvistaAnexos==2">

<form id="register_form" name="register_form" ng-submit="submitFormAnexos($event)"> 
     <div class='row'>              
       <div class="col-12 col-sm-12">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Comercializadora <b style="color:red;">(*)</b></label>
       <select class="form-control" id="CodTProCom" name="CodTProCom" ng-model="vm.anexos.CodTProCom" ng-change="vm.filtrar_productos_com()" ng-disabled="vm.validate_info_anexos==1">
         <option ng-repeat="dato in vm.TProComercializadoras" value="{{dato.CodCom}}">{{dato.RazSocCom}} - {{dato.NumCifCom}}</option>                        
        </select>
       
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-12">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Productos <b style="color:red;">(*)</b></label>
       <select class="form-control" id="CodPro" name="CodPro" ng-model="vm.anexos.CodPro" ng-disabled="vm.anexos.CodTProCom==undefined||vm.validate_info_anexos==1 " >
         <option ng-repeat="dato in vm.TProductosActivosFiltrados" value="{{dato.CodPro}}">{{dato.DesPro}}</option>                        
        </select>
       
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Nombre del Anexo <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.anexos.DesAnePro" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Nombre del Anexo" maxlength="50" ng-disabled="vm.validate_info_anexos==1"/>       
       </div>
       </div>
       </div>
      
      <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Fecha de Inicio</label>
       <input type="text" class="form-control" ng-model="vm.FecIniAneA" placeholder="* DD/MM/YYYY" maxlength="10" readonly ng-disabled="vm.validate_info_anexos==1"/>
       </div>
       </div>
       </div>

      <div style="margin-top: 8px;">
       <div align="center"><label class="font-weight-bold nexa-dark" style="color:black;"><b>TIPO DE SUMINISTROS</b></label></div></div>
      
      <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">SUMINISTRO ELÉCTRICO</label>
        <input type="checkbox" class="form-control" ng-model="vm.anexos.SerEle" ng-click="vm.limpiar_Servicio_Electrico(vm.anexos.SerEle)" ng-disabled="vm.validate_info_anexos==1"/>
       </div>
       </div>
       </div>

      <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">SUMINISTRO GAS</label>
        <input type="checkbox" class="form-control" ng-model="vm.anexos.SerGas" ng-click="vm.limpiar_Servicio_Gas(vm.anexos.SerGas)" ng-disabled="vm.validate_info_anexos==1"/>
       </div>
       </div>
       </div>
        <div style="margin-top: 8px;">
       <div align="center"><label class="font-weight-bold nexa-dark" style="color:black;"><b>TIPO DE PRECIOS</b></label></div></div>
       <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">FIJO</label>
        <input type="checkbox" class="form-control" ng-model="vm.anexos.Fijo" ng-disabled="vm.validate_info_anexos==1"/>
       </div>
       </div>
       </div>

      <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">INDEXADO</label>
        <input type="checkbox" class="form-control" ng-model="vm.anexos.Indexado" ng-disabled="vm.validate_info_anexos==1"/>
       </div>
       </div>
       </div>



        <div style="margin-top: 8px;">
       <div align="center"><label class="font-weight-bold nexa-dark" style="color:black;"><b>TARIFA DE ACCESO ELÉCTRICO</b></label></div></div>
        
        <div class="col-lg-6">
                <section class="panel">
                  <header class="panel-heading">
                   <div align="center"> <b>BAJA TENSIÓN</b> </div>
                  </header>
                   <div class="panel-body">
                    <div class="checkboxes"ng-repeat="opcion_tension_baja in vm.Tarifa_Elec_Baja">                      
                        
                         <button type="button"  ng-click="vm.agregar_tarifa_elec_baja($index,opcion_tension_baja.CodTarEle,opcion_tension_baja)" title="Agregar {{opcion_tension_baja.NomTarEle}}" ng-disabled="vm.validate_info==1||vm.disabled_all_baja==1||vm.anexos.SerEle==false ||vm.validate_info_anexos==1" ng-show="!vm.select_tarifa_Elec_Baj[opcion_tension_baja.CodTarEle]"><i class="fa fa fa-square-o" title="Agregar {{tari_gas.NomTarGas}}" style="color:black;"></i></button>
                        

                        <button type="button" ng-show="vm.select_tarifa_Elec_Baj[opcion_tension_baja.CodTarEle]" ng-click="vm.quitar_tarifa_elec_baja($index,opcion_tension_baja.CodTarEle,opcion_tension_baja)" ng-disabled="vm.disabled_all_baja==1||vm.anexos.AggAllBaj==true||vm.validate_info_anexos==1"><i class="fa fa fa-check-circle" title="Quitar {{opcion_tension_baja.NomTarEle}}" style="color:green;"></i></button>


                        <label class="font-weight-bold nexa-dark" style="color:black;">{{opcion_tension_baja.NomTarEle}}</label>
                    </div>
                     <div align="center">
                    <label>
                        <input name="sample-checkbox-01" id="checkbox-01" type="checkbox" ng-click="vm.agregar_todas_baja_tension(vm.Tarifa_Elec_Baja,vm.anexos.AggAllBaj)" ng-disabled="vm.validate_info==1||vm.anexos.SerEle==false||vm.validate_info_anexos==1" ng-model="vm.anexos.AggAllBaj"/> <b><i class="fa fa-check-circle"></i> Todas</b>
                      </label></div>
                  </div>
                </section> 
              </div>

               <div class="col-lg-6">
                <section class="panel">
                  <header class="panel-heading">
                   <div align="center"> <b>ALTA TENSIÓN</b> </div>
                  </header>
                   <div class="panel-body">
                    <div class="checkboxes"ng-repeat="opcion_tension_alta in vm.Tarifa_Elec_Alt"> 

                        <button type="button" ng-disabled="vm.validate_info==1||vm.disabled_all_alta==1||vm.anexos.SerEle==false||vm.validate_info_anexos==1 " ng-show="!vm.select_tarifa_Elec_Alt[opcion_tension_alta.CodTarEle]" ng-click="vm.agregar_tarifa_elec_alta($index,opcion_tension_alta.CodTarEle,opcion_tension_alta)" title="Agregar {{opcion_tension_alta.NomTarEle}}"><i class="fa fa fa-square-o" title="Agregar {{tari_gas.NomTarGas}}" style="color:black;"></i></button>
                        

                        <button type="button" ng-show="vm.select_tarifa_Elec_Alt[opcion_tension_alta.CodTarEle]" ng-click="vm.quitar_tarifa_elec_alta($index,opcion_tension_alta.CodTarEle,opcion_tension_alta)" ng-disabled="vm.disabled_all_baja==1||vm.anexos.AggAllBaj==true||vm.validate_info_anexos==1"><i class="fa fa fa-check-circle" title="Quitar {{opcion_tension_alta.NomTarEle}}" style="color:green;"></i></button>



                        <label class="font-weight-bold nexa-dark" style="color:black;">{{opcion_tension_alta.NomTarEle}}</label>
                    



                    </div>
                     <div align="center">
                    <label>
                        <input name="sample-checkbox-01" id="checkbox-01" type="checkbox" ng-disabled="vm.validate_info==1||vm.anexos.SerEle==false||vm.validate_info_anexos==1" ng-model="vm.anexos.AggAllAlt" ng-click="vm.agregar_todas_alta_tension(vm.Tarifa_Elec_Alt,vm.anexos.AggAllAlt)"/> <b><i class="fa fa-check-circle"></i> Todas</b>
                      </label></div>
                  </div>
                </section> 
              </div>



  <div style="margin-top: 8px;">
      <div align="center"><label class="font-weight-bold nexa-dark" style="color:black;"><b>TARIFA DE ACCESO GAS</b></label></div></div>
       
       <div class="col-12 col-sm-3" ng-repeat="tari_gas in vm.Tarifa_Gas_Anexos">
       <div class="form">                          
       <div class="form-group">

       <button type="button" name="tarifa_gas" id="tarifa_gas" ng-show="!vm.select_tarifa_gas[tari_gas.CodTarGas]" ng-click="vm.agregar_tarifa_gas_individual($index,tari_gas,tari_gas.CodTarGas)" ng-disabled="vm.validate_info==1||vm.disabled_all==1||vm.anexos.SerGas==false||vm.validate_info_anexos==1"><i class="fa fa fa-square-o" title="Agregar {{tari_gas.NomTarGas}}" style="color:black;"></i></button>   
       
       <button type="button" ng-show="vm.select_tarifa_gas[tari_gas.CodTarGas]" ng-click="vm.quitar_tarifa_gas($index,tari_gas.CodTarGas,tari_gas)" ng-disabled="vm.disabled_all==1||vm.validate_info_anexos==1"><i class="fa fa fa-check-circle" title="Quitar {{tari_gas.NomTarGas}}" style="color:green;"></i></button>
       <label class="font-weight-bold nexa-dark" style="color:black;"><b>{{tari_gas.NomTarGas}}</b></label> 

       </div>
       </div>
       </div>
        
        <div align="center">
                    <label class="label_check" for="checkbox-01">
                        <input name="sample-checkbox-01" id="checkbox-01" type="checkbox" ng-model="vm.Todas_Gas" ng-click="vm.agregar_todas_detalle(vm.Todas_Gas)" ng-disabled="vm.validate_info==1||vm.anexos.SerGas==false||vm.validate_info_anexos==1" /> <b><i class="fa fa-check-circle"></i> Todas</b>
                      </label></div>
      
      <div class="form">                          
        <div class="form-group">
           <label class="font-weight-bold nexa-dark" style="color:black;">Fotocopia del Anexo <a title='Descargar Documento' ng-show="vm.anexos.DocAnePro!=null && vm.anexos.CodAnePro>0" href="{{vm.anexos.DocAnePro}}" download class="btn btn-info btn-icon mg-r-5"><div><i class="fa fa-download" style="color:white;"></i></div></a></label>         
          <input type="file" id="file_anexo"  accept="*/*" class="form-control btn-info"  uploadanexo-model="file_anexo" ng-disabled="vm.validate_info==1||vm.validate_info_anexos==1">
        </div>
      </div>

      <div class="col-12 col-sm-12">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Tipo de Comisión <b style="color:red;">(*)</b></label>
       <select class="form-control" id="CodTipCom" name="CodTipCom" ng-model="vm.anexos.CodTipCom" ng-disabled="vm.validate_info_anexos==1">
         <option ng-repeat="dato in vm.Tipos_Comision" value="{{dato.CodTipCom}}">{{dato.DesTipCom}}</option>                        
        </select>
       
       </div>
       </div>
       </div>


      <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:black;"><i class="fa fa-adjust"></i> Observación</label>
        <textarea class="form-control" style="display: inline-block;" onkeyup="this.value=this.value.toUpperCase();" id="ObsAnePro" name="ObsAnePro" type="text" minlength="1" maxlength="200" rows="5"  ng-model="vm.anexos.ObsAnePro" ng-disabled="vm.validate_info_anexos==1"></textarea>
        
       </div>
       </div>    
      <input class="form-control" id="CodAnePro" name="CodAnePro" type="hidden" ng-model="vm.anexos.CodAnePro" readonly/>
         <div class="form-group" >
          <div class="col-12 col-sm-6">
            <button class="btn btn-info" type="submit" ng-show="vm.anexos.CodAnePro==undefined||vm.anexos.CodAnePro==null||vm.anexos.CodAnePro==''" ng-disabled="vm.disabled_button==1">REGISTRAR</button>
            <button class="btn btn-success" type="submit" ng-show="vm.anexos.CodAnePro>0 && vm.validate_info_anexos==0" ng-disabled="vm.validate_info_anexos==1">ACTUALIZAR</button>            
            <button class="btn btn-warning" type="button"  ng-click="vm.limpiar_anexo()">LIMPIAR</button>
            <button class="btn btn-primary" type="button" style="margin-top: 10px;" ng-click="vm.regresar_anexos()">REGRESAR</button>
          </div>
        </div>
         </div><!--FINAL ROW -->
        </form>
</div><!-- FINAL DE DIV NG-SHOW-->




   
      </div>
      <!-- FINAL DE TABS 3-->
       <!-- INICIO DE TABS 4-->
      <div id="tabs-4">








  <div ng-show="vm.TvistaServiciosEspeciales==1">                 
  <div id="t-0002">
      <div style="float:left;margin-left: 0px;padding: 10px;margin-top: 10px;margin-bottom: 2px;" class="removeForMobile">                   
        <div class="t-0029">
            <div class="t-0031" style="margin-top: -8px; ">
                    <div class="btn-group">
                      <button data-toggle="dropdown" title="Agregar Columnas" class="btn btn-default" type="button"><i class="fa fa-columns"></i> <span class="caret"></span></button>
                      <ul class="dropdown-menu">
                        <li><input type="checkbox" ng-model="vm.CodComSerEsp"/> <i class="fa fa-plus-square"></i> <b style="color:black;">COMERCIALIZADORA</b></li>
                        <li><input type="checkbox" ng-model="vm.DesSerEsp"/> <i class="fa fa-plus-square"></i> <b style="color:black;">SERVICIO ESPECIAL</b></li></li>
                        <li><input type="checkbox" ng-model="vm.TipCli"/> <i class="fa fa-plus-square"></i> <b style="color:black;">TIPO CLIENTE</b></li></li>
                        <li><input type="checkbox" ng-model="vm.SerElecSerEsp"/> <i class="fa fa-plus-square"></i> <b style="color:black;">ELECTRICIDAD</b></li>
                        <li><input type="checkbox" ng-model="vm.SerGasSerEsp"/> <i class="fa fa-plus-square"></i> <b style="color:black;">GAS</b></li>
                        <li><input type="checkbox" ng-model="vm.EstSerEsp"/> <i class="fa fa-plus-square"></i> <b style="color:black;">ESTATUS</b></li>
                        <li><input type="checkbox" ng-model="vm.AccSerEsp"/> <i class="fa fa-plus-square"></i> <b style="color:black;">ACCIÓN</b></li>
                      </ul> 
                    </div>                    
                    <div class="btn-group">
                      <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button"><i class="fa fa-cloud-upload"></i><span class="caret"></span> </button>
                      <ul class="dropdown-menu">
                        <li style="cursor: pointer;"><a ><i class="fa fa-file"></i> Exportar en PDF</a></li>
                        <li style="cursor: pointer;"><a ><i class="fa fa-file-excel-o"></i> Exportar en Excel</a></li>                        
                      </ul>
                    </div>
                    <div class="btn-group">
                       <a data-toggle="modal" title='Filtrar Servicios Especiales' data-target="#modal_filtros_servicios_especiales" class="btn btn-default"><div><i class="fa fa-filter"></i><span class="caret"></span></div></a>
                   </div>
          </div>
        </div>
    </div>              
        <div style="float:right;margin-left: 0px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
            <div class="t-0029">
                <form class="form-inline" role="form">
                    <div class="form-group">
                      <input type="text" class="form-control" ng-model="vm.filtrar_servicio_esp" minlength="1" id="exampleInputEmail2" placeholder="Escribe para filtrar...">
                    </div>                 
                    <button style="margin-right: 10px;" class="btn btn-info" title="Agregar Servicio Especial" ng-click="vm.agg_servicio_especial()"><i class="fa fa-plus-square"></i></button>
                  </form>                    
                  </div>
            </div>
  </div>  
<!--t-0002 end--> 
<br><br><br><br>
      <div class="table-responsive" ng-init="vm.cargar_lista_servicos_especiales()">
          <table class="table table-striped table-advance table-hover table-responsive">
                <tbody>
                  <tr>
                    <th ng-show="vm.CodComSerEsp==true"><i class="icon_cogs"></i> COMERCIALIZADORA</th>
                    <th ng-show="vm.DesSerEsp==true"><i class="icon_cogs"></i> SERVICIO ESPECIAL</th>
                    <th ng-show="vm.TipCli==true"><i class="icon_cogs"></i> TIPO CLIENTE</th>
                    <th ng-show="vm.SerElecSerEsp==true"><i class="icon_cogs"></i> ELECTRICIDAD</th>
                    <th ng-show="vm.SerGasSerEsp==true"><i class="icon_cogs"></i> GAS</th>
                    <th ng-show="vm.EstSerEsp==true"><i class="icon_cogs"></i> ESTATUS</th>
                    <th ng-show="vm.AccSerEsp==true"><i class="icon_cogs"></i> Acción</th>
                  </tr> 
                  <tr ng-show="vm.TServicioEspeciales==undefined"> 
                    <td colspan="10" align="center"><div class="td-usuario-table"><i class="fa fa-close"></i> Actualmente no hay datos disponibles.</div></td>
                  </tr>
                  <tr ng-repeat="dato in vm.TServicioEspeciales | filter:paginate3 | filter:vm.filtrar_servicio_esp" ng-class-odd="odd">
                    <td ng-show="vm.CodComSerEsp==true">{{dato.NumCifCom}} - {{dato.RazSocCom}}</td>
                    <td ng-show="vm.DesSerEsp==true">{{dato.DesSerEsp}}</td>
                    <td ng-show="vm.TipCli==true">{{dato.TipCli}}</td>
                    <td ng-show="vm.SerElecSerEsp==true">{{dato.SerEle}}</td>
                    <td ng-show="vm.SerGasSerEsp==true">{{dato.SerGas}}</td> 
                    <td ng-show="vm.EstSerEsp==true">
                      <span class="label label-info" ng-show="dato.EstSerEsp=='ACTIVO'"><i class="fa fa-check-circle"></i> {{dato.EstSerEsp}}</span>
                      <span class="label label-danger" ng-show="dato.EstSerEsp=='BLOQUEADO'"><i class="fa fa-ban"></i> {{dato.EstSerEsp}}</span>
                    </td>
                    <td ng-show="vm.AccSerEsp==true">
                      <div class="btn-group">
                        <select class="form-control" id="opciones_servicio_especiales" name="opciones_servicio_especiales" ng-model="vm.opciones_servicio_especiales[$index]" ng-change="vm.validar_opcion_servicios_especiales($index,vm.opciones_servicio_especiales[$index],dato)">
                          <option ng-repeat="opcion in vm.Topciones_Grib" value="{{opcion.id}}">{{opcion.nombre}}</option>                          
                        </select>
                      </div>
                    </td>

                  </tr>
                </tbody>
                <tfoot>
                    <th ng-show="vm.CodComSerEsp==true"><i class="icon_cogs"></i> COMERCIALIZADORA</th>
                    <th ng-show="vm.DesSerEsp==true"><i class="icon_cogs"></i> SERVICIO ESPECIAL</th>
                    <th ng-show="vm.TipCli==true"><i class="icon_cogs"></i> TIPO CLIENTE</th>
                    <th ng-show="vm.SerElecSerEsp==true"><i class="icon_cogs"></i> ELECTRICIDAD</th>
                    <th ng-show="vm.SerGasSerEsp==true"><i class="icon_cogs"></i> GAS</th>
                    <th ng-show="vm.EstSerEsp==true"><i class="icon_cogs"></i> ESTATUS</th>
                    <th ng-show="vm.AccSerEsp==true"><i class="icon_cogs"></i> Acción</th>
                </tfoot>
              </table>
        </div> 
          <div align="center">
          <span class="store-qty"> <a ng-click="vm.cargar_lista_servicos_especiales()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       
          <div class='btn-group' align="center">
            <pagination total-items="totalItems3" ng-model="currentPage3" max-size="5" boundary-links="true" items-per-page="numPerPage3" class="pagination-sm">  
            </pagination>
          </div>
        </div>

 <!-- modal container section start -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_filtros_servicios_especiales" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Tipos de Filtros</h4>
          </div>
          <div class="modal-body">
                        <div class="panel">                  
      <form class="form-validate" id="frmFiltroServicioEspecial" name="frmFiltroServicioEspecial" ng-submit="SubmitFormFiltrosServiciosEspeciales($event)">                 
     
     <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">TIPO DE FILTRO</label>
      <select class="form-control" id="ttipofiltrosServicioEspecial" name="ttipofiltrosServicioEspecial" required ng-model="vm.tmodal_data.ttipofiltrosServicioEspecial">
          <option ng-repeat="dato in vm.ttipofiltrosServicioEspecial" value="{{dato.id}}">{{dato.nombre}}</option>
        </select>     
     </div>
     </div>
     </div>
     <br>
     <br>
     <br>
     <br> 

     <div class="col-12 col-sm-6" ng-show="vm.tmodal_data.ttipofiltrosServicioEspecial==1">
     <div class="form">                          
     <div class="form-group">
     
      <select class="form-control" id="TipServ" name="TipServ" ng-model="vm.tmodal_data.TipServ">
        <option ng-repeat="dato in vm.TipServ" value="{{dato.id}}">{{dato.nom_serv}}</option>                        
      </select>   
     </div>
     </div>
    </div>   
    <br ng-show="vm.tmodal_data.ttipofiltrosServicioEspecial==1">
     <br ng-show="vm.tmodal_data.ttipofiltrosServicioEspecial==1"> 
    <br>
    <div style="margin-left:15px; ">
     <button class="btn btn-info" type="submit" ng-disabled="frmFiltroServicioEspecial.$invalid">APLICAR</button>
      <a class="btn btn-danger" ng-click="vm.regresar_filtro()">LIMPIAR</a>
      </div>
</form>
   </div>
    </div>
</div>
</div>
</div>
<!--modal container section end -->



<!-- modal container section end -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_motivo_bloqueo_servicio_especial" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title"><i class="fa fa-ban"></i> Bloqueo de Servicio Especial</h4>
          </div>
          <div class="modal-body">
                        <div class="panel"> 
    <input type="hidden" class="form-control" ng-model="vm.servicio_especial_bloqueo.CodSerEsp" required readonly />
      <form class="form-validate" id="form_lock_servicio_especial" name="form_lock_servicio_especial" ng-submit="submitFormlockServicioEspecial($event)">                 
     
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">COMERCIALIZADORA</label>
     <input type="text" class="form-control" ng-model="vm.RazSocCom_BloSerEsp" required readonly/>     
     </div>
     </div>

      <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">SERVICIO ESPECIAL</label>
      <input type="text" class="form-control" ng-model="vm.DesSerEsp_Blo" required readonly />     
     </div>
     </div>
<div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">MOTIVO DEL BLOQUEO</label>
       <input type="text" class="form-control" ng-model="vm.servicio_especial_bloqueo.MotBloSerEsp" required/> 
     </div>
     </div>
    
</div>
    <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Fecha de Bloqueo</label>
     <input type="text" class="form-control" ng-model="vm.FecBloSerEsp" required readonly/>    
     </div>
     </div>
     </div>

     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Observación</label>
     <textarea type="text" class="form-control" ng-model="vm.servicio_especial_bloqueo.ObsMotBloSerEsp" rows="5" maxlength="100"/></textarea>
     </div>
     </div>
    
    <br>
     <button class="btn btn-info" type="submit" ng-disabled="form_lock_servicio_especial.$invalid">Bloquear</button>
      <a class="btn btn-danger" data-dismiss="modal">Regresar</a>
</form>
   </div>
    </div>
</div>
</div>
</div>
<!-- modal container section end -->



 </div> 





<div ng-show="vm.TvistaServiciosEspeciales==2">

<form id="register_form" name="register_form" ng-submit="submitFormServiciosEspeciales($event)"> 
     <div class='row'>              
       <div class="col-12 col-sm-12">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Comercializadora <b style="color:red;">(*)</b></label>
       <select class="form-control" id="CodCom" name="CodCom" ng-model="vm.servicio_especial.CodCom" ng-disabled="vm.validate_info_servicio_especiales==1">
         <option ng-repeat="dato in vm.TProComercializadoras" value="{{dato.CodCom}}">{{dato.RazSocCom}} - {{dato.NumCifCom}}</option>                        
        </select>
       
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Nombre del Servicio Especial <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.servicio_especial.DesSerEsp" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Nombre del Servicio Especial" maxlength="50" ng-disabled="vm.validate_info_servicio_especiales==1"/>       
       </div>
       </div>
       </div>
      
      <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Fecha de Inicio</label>
       <input type="text" class="form-control" ng-model="vm.FecIniSerEsp" placeholder="* DD/MM/YYYY" maxlength="10" readonly ng-disabled="vm.validate_info_servicio_especiales==1"/>
       </div>
       </div>
       </div>

      <div style="margin-top: 8px;">
       <div align="left"><label class="font-weight-bold nexa-dark" style="color:black;"><b>TIPO DE SUMINISTROS</b></label></div></div>
      
      <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">SUMINISTRO ELÉCTRICO</label>
        <input type="checkbox" class="form-control" ng-model="vm.servicio_especial.SerEle" ng-click="vm.limpiar_Servicio_Electrico_SerEsp(vm.servicio_especial.SerEle)" ng-disabled="vm.validate_info_servicio_especiales==1"/>
       </div>
       </div>
       </div>
      <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">SUMINISTRO GAS</label>
        <input type="checkbox" class="form-control" ng-model="vm.servicio_especial.SerGas" ng-click="vm.limpiar_Servicio_Gas_SerEsp(vm.servicio_especial.SerGas)" ng-disabled="vm.validate_info_servicio_especiales==1"/>
       </div>
       </div>
       </div>
        <div style="margin-top: 8px;">
       <div align="center"><label class="font-weight-bold nexa-dark" style="color:black;"><b>TARIFA DE ACCESO ELÉCTRICO</b></label></div></div>
        
        <div class="col-lg-6">
                <section class="panel">
                  <header class="panel-heading">
                   <div align="center"> <b>BAJA TENSIÓN</b> </div>
                  </header>
                   <div class="panel-body">
                    <div class="checkboxes"ng-repeat="opcion_tension_baja in vm.Tarifa_Elec_Baja">                      
                       
                         <button type="button"  ng-click="vm.agregar_tarifa_elec_baja_SerEsp($index,opcion_tension_baja.CodTarEle,opcion_tension_baja)" title="Agregar {{opcion_tension_baja.NomTarEle}}" ng-disabled="vm.validate_info==1||vm.disabled_all_baja==1||vm.servicio_especial.SerEle==false ||vm.validate_info_servicio_especiales==1" ng-show="!vm.select_tarifa_Elec_Baj_SerEsp[opcion_tension_baja.CodTarEle]"><i class="fa fa fa-square-o" title="Agregar {{tari_gas.NomTarGas}}" style="color:black;"></i></button>
                        

                        <button type="button" ng-show="vm.select_tarifa_Elec_Baj_SerEsp[opcion_tension_baja.CodTarEle]" ng-click="vm.quitar_tarifa_elec_baja_SerEsp($index,opcion_tension_baja.CodTarEle,opcion_tension_baja)" ng-disabled="vm.disabled_all_baja_SerEsp==1||vm.servicio_especial.AggAllBaj==true||vm.validate_info_servicio_especiales==1"><i class="fa fa fa-check-circle" title="Quitar {{opcion_tension_baja.NomTarEle}}" style="color:green;"></i></button>


                        <label class="font-weight-bold nexa-dark" style="color:black;">{{opcion_tension_baja.NomTarEle}}</label>
                    </div>
                     <div align="center">
                    <label>
                        <input name="sample-checkbox-01" id="checkbox-01" type="checkbox" ng-click="vm.agregar_todas_baja_tension_SerEsp(vm.Tarifa_Elec_Baja,vm.servicio_especial.AggAllBaj)" ng-disabled="vm.validate_info==1||vm.servicio_especial.SerEle==false||vm.validate_info_servicio_especiales==1" ng-model="vm.servicio_especial.AggAllBaj"/> <b><i class="fa fa-check-circle"></i> Todas</b>
                      </label></div>
                  </div>
                </section> 
              </div>

               <div class="col-lg-6">
                <section class="panel">
                  <header class="panel-heading">
                   <div align="center"> <b>ALTA TENSIÓN</b> </div>
                  </header>
                   <div class="panel-body">
                    <div class="checkboxes"ng-repeat="opcion_tension_alta in vm.Tarifa_Elec_Alt"> 

                        <button type="button" ng-disabled="vm.validate_info==1||vm.disabled_all_alta==1||vm.servicio_especial.SerEle==false||vm.validate_info_servicio_especiales==1 " ng-show="!vm.select_tarifa_Elec_Alt_SerEsp[opcion_tension_alta.CodTarEle]" ng-click="vm.agregar_tarifa_elec_alta_SerEsp($index,opcion_tension_alta.CodTarEle,opcion_tension_alta)" title="Agregar {{opcion_tension_alta.NomTarEle}}"><i class="fa fa fa-square-o" title="Agregar {{tari_gas.NomTarGas}}" style="color:black;"></i></button>                       

                        <button type="button" ng-show="vm.select_tarifa_Elec_Alt_SerEsp[opcion_tension_alta.CodTarEle]" ng-click="vm.quitar_tarifa_elec_alta_SerEsp($index,opcion_tension_alta.CodTarEle,opcion_tension_alta)" ng-disabled="vm.disabled_all_alta_SerEsp==1||vm.servicio_especial.AggAllBaj==true||vm.validate_info_servicio_especiales==1"><i class="fa fa fa-check-circle" title="Quitar {{opcion_tension_alta.NomTarEle}}" style="color:green;"></i></button>

                        <label class="font-weight-bold nexa-dark" style="color:black;">{{opcion_tension_alta.NomTarEle}}</label>

                    </div>
                     <div align="center">
                    <label>
                        <input name="sample-checkbox-01" id="checkbox-01" type="checkbox" ng-disabled="vm.validate_info==1||vm.servicio_especial.SerEle==false||vm.validate_info_servicio_especiales==1" ng-model="vm.servicio_especial.AggAllAlt" ng-click="vm.agregar_todas_alta_tension_SerEsp(vm.Tarifa_Elec_Alt,vm.servicio_especial.AggAllAlt)"/> <b><i class="fa fa-check-circle"></i> Todas</b>
                      </label></div>
                  </div>
                </section> 
              </div>



  <div style="margin-top: 8px;">
      <div align="center"><label class="font-weight-bold nexa-dark" style="color:black;"><b>TARIFA DE ACCESO GAS</b></label></div></div>
       
       <div class="col-12 col-sm-3" ng-repeat="tari_gas in vm.Tarifa_Gas_Anexos">
       <div class="form">                          
       <div class="form-group">

       <button type="button" name="tarifa_gas_SerEsp" id="tarifa_gas_SerEsp" ng-show="!vm.select_tarifa_gas_SerEsp[tari_gas.CodTarGas]" ng-click="vm.agregar_tarifa_gas_individual_SerEsp($index,tari_gas,tari_gas.CodTarGas)" ng-disabled="vm.validate_info==1||vm.disabled_all_SerEsp==1||vm.servicio_especial.SerGas==false||vm.validate_info_servicio_especiales==1"><i class="fa fa fa-square-o" title="Agregar {{tari_gas.NomTarGas}}" style="color:black;"></i></button>   
       
       <button type="button" ng-show="vm.select_tarifa_gas_SerEsp[tari_gas.CodTarGas]" ng-click="vm.quitar_tarifa_gas_SerEsp($index,tari_gas.CodTarGas,tari_gas)" ng-disabled="vm.disabled_all_SerEsp==1||vm.validate_info_servicio_especiales==1"><i class="fa fa fa-check-circle" title="Quitar {{tari_gas.NomTarGas}}" style="color:green;"></i></button>
       <label class="font-weight-bold nexa-dark" style="color:black;"><b>{{tari_gas.NomTarGas}}</b></label> 

       </div>
       </div>
       </div>
        
        <div align="center">
                    <label class="label_check" for="checkbox-01">
                        <input name="sample-checkbox-01" id="checkbox-01" type="checkbox" ng-model="vm.Todas_Gas_SerEsp" ng-click="vm.agregar_todas_detalle_SerEsp(vm.Todas_Gas_SerEsp)" ng-disabled="vm.validate_info==1||vm.servicio_especial.SerGas==false||vm.validate_info_servicio_especiales==1" /> <b><i class="fa fa-check-circle"></i> Todas</b>
                      </label></div>
     <div style="margin-top: 8px;">
      <div align="center"><label class="font-weight-bold nexa-dark" style="color:black;"><b>TIPO DE CLIENTE</b></label></div></div>

      
      <div class="col-12 col-sm-12">
       <div class="form">                          
       <div class="form-group">
       
       <input type="radio" name="tipo_cliente" id="tipo_cliente" value="0" ng-model="vm.servicio_especial.TipCli" ng-disabled="vm.validate_info_servicio_especiales==1">
       <label class="font-weight-bold nexa-dark" style="color:black;">Clientes Particulares</label>

       <input type="radio" name="tipo_cliente" id="tipo_cliente" value="1" ng-model="vm.servicio_especial.TipCli" ng-disabled="vm.validate_info_servicio_especiales==1">
       <label class="font-weight-bold nexa-dark" style="color:black;">Clientes Negocios</label> 
       </div>
       </div>
       </div>
       <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:black;"><i class="fa fa-adjust"></i> Características principales del Servicio Especial</label>
        <textarea class="form-control" style="display: inline-block;" onkeyup="this.value=this.value.toUpperCase();" id="CarSerEsp" name="CarSerEsp" type="text" minlength="1" maxlength="200" rows="5"  ng-model="vm.servicio_especial.CarSerEsp" ng-disabled="vm.validate_info_servicio_especiales==1"></textarea>
        
       </div>
       </div> 


      <div class="col-12 col-sm-12">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Tipo de Comisión <b style="color:red;">(*)</b></label>
       <select class="form-control" id="CodTipCom" name="CodTipCom" ng-model="vm.servicio_especial.CodTipCom" ng-disabled="vm.validate_info_servicio_especiales==1">
         <option ng-repeat="dato in vm.Tipos_Comision" value="{{dato.CodTipCom}}">{{dato.DesTipCom}}</option>                        
        </select>
       
       </div>
       </div>
       </div>


      <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:black;"><i class="fa fa-adjust"></i> Observación</label>
        <textarea class="form-control" style="display: inline-block;" onkeyup="this.value=this.value.toUpperCase();" id="OsbSerEsp" name="OsbSerEsp" type="text" minlength="1" maxlength="200" rows="5"  ng-model="vm.servicio_especial.OsbSerEsp" ng-disabled="vm.validate_info_servicio_especiales==1"></textarea>
        
       </div>
       </div>    
      <input class="form-control" id="CodSerEsp" name="CodSerEsp" type="hidden" ng-model="vm.servicio_especial.CodSerEsp" readonly/>
         <div class="form-group" >
          <div class="col-12 col-sm-6">
            <button class="btn btn-info" type="submit" ng-show="vm.servicio_especial.CodSerEsp==undefined||vm.servicio_especial.CodSerEsp==null||vm.servicio_especial.CodSerEsp==''" ng-disabled="vm.disabled_button==1">REGISTRAR</button>
            <button class="btn btn-success" type="submit" ng-show="vm.servicio_especial.CodSerEsp>0 && vm.validate_info_servicio_especiales==0" ng-disabled="vm.validate_info_servicio_especiales==1">ACTUALIZAR</button>            
            <button class="btn btn-warning" type="button"  ng-click="vm.limpiar_servicio_especial()">LIMPIAR</button>
            <button class="btn btn-primary" type="button" style="margin-top: 10px;" ng-click="vm.regresar_servicios_especiales()">REGRESAR</button>
          </div>
        </div>
         </div><!--FINAL ROW -->
        </form>
</div><!-- FINAL DE DIV NG-SHOW-->















      </div>
      <!-- FINAL DE TABS 4-->

       <!-- INICIO DE TABS 5-->
      <div id="tabs-5">
 		

      </div>
      <!-- FINAL DE TABS 5-->      
            
        </div><!-- FINAL DE TABS--> 
                
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
   <script>
      $(function(){
        'use strict'

        // Input Masks
        $('#FecIniAct').mask('9999/99/99');
        $('#FecIniActFil').mask('99-99-9999');
        //$('#FechaInCont').mask('99-99-9999');
        //$('#FecVenConCom').mask('99-99-9999'); 
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

        function mayus(e)
        {
          var tecla=e.value;
          var tecla2=tecla.toUpperCase();
        }


      });
    </script>
</body>
<div id="estatus_actividad" class="loader loader-default"  data-text="Actualizando Estatus de la Actividad, Por Favor Espere..."></div>
<div id="cargando" class="loader loader-default"  data-text="Cargando Listado de Clientes, Por Favor Espere..."></div>
<div id="cargando_I" class="loader loader-default"  data-text="Cargando Datos de la Comercializadora, Por Favor Espere..."></div>
<div id="crear_clientes" class="loader loader-default"  data-text="Creando o Actualizando Cliente, Por Favor Espere..."></div>
<div id="comprobando_disponibilidad" class="loader loader-default"  data-text="Comprobando Disponibilidad, Por Favor Espere..."></div>
<div id="asignando_actividad" class="loader loader-default"  data-text="Asignando Actividad, Por Favor Espere..."></div>
<div id="cargando_actividades" class="loader loader-default"  data-text="Cargando Actividades, Por Favor Espere..."></div>


<div id="buscando" class="loader loader-default"  data-text="Cargando Datos, Por Favor Espere..."></div>
<div id="Guardando" class="loader loader-default"  data-text="Guardando Comercializadora, Por Favor Espere..."></div>
<div id="Actualizando" class="loader loader-default"  data-text="Actualizando Comercializadora, Por Favor Espere..."></div>


</html>