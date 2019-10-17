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
 <div ng-controller="Controlador_Clientes as vm">
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header" ng-show="vm.fdatos.CodCli==undefined"><i class="fa fa-users"></i> Registro de Clientes </h3>
            <h3 class="page-header" ng-show="vm.fdatos.CodCli>0"><i class="fa fa-users"></i> Actualización de Datos del Cliente </h3>
            <ol class="breadcrumb">
            
             <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>             
              
              <li ng-show="vm.fdatos.CodCli==undefined"><i class="fa fa-users"></i>Registro de Clientes</li>
              <li ng-show="vm.fdatos.CodCli>0"><i class="fa fa-users"></i>Actualización de Datos del Cliente</li>
            </ol>
          </div>
        </div>
        <!-- Form validations -->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading" style="color:black;">
                <b>Datos Basicos del Cliente:</b>
              </header>
              <div class="panel-body">              
             

               <div id="tabs_clientes" class="ui-tabs-nav ui-corner-all">
      <ul >
       <li>
        <a href="#tabs-1"><i class="fa fa-user-circle"></i> Datos Basicos</a>
        </li>
       
      <li ng-show="vm.fdatos.CodCli>0">
      <a href="#tabs-2"><i class="fa fa-briefcase"></i> Actividad</a>
      </li>
      <li ng-show="vm.fdatos.CodCli>0">
      <a href="#tabs-3"><i class="fa fa-bullseye"></i> Punto Sumistro</a>
      </li>
      <li ng-show="vm.fdatos.CodCli>0">
      <a href="#tabs-4"><i class="fa fa-child"></i> Contactos</a>
      </li>
      <li ng-show="vm.fdatos.CodCli>0">
      <a href="#tabs-5"><i class="fa fa-bank"></i> Cuenta Bancaria</a>
      </li>
      <li ng-show="vm.fdatos.CodCli>0">
      <a href="#tabs-6" ><i class="fa fa-file"></i> Documentos</a>
      </li>
     </ul>

         <!--INICIO TABS 1 DATOS BASICOS DEL CLIENTE -->
  <div id="tabs-1">          
   
    
    <form id="register_form" name="register_form" ng-submit="submitForm($event)"> 
     <div class='row'>              
       <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">CIF <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fdatos.NumCifCli" maxlength="9" ng-disabled="vm.validate_cif==1 || vm.fdatos.CodCli>=0" placeholder="* Número del CIF del Cliente Comercial"/>
       
       </div>
       </div>
       </div>       
       <div class="col-12 col-sm-4">
       <div class="form"> 
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Fecha de Inicio</label>       
        <div class="input-append date" id="dpYears" data-date="18-06-2013" data-date-format="dd-mm-yyyy" data-date-viewmode="years">
          <input class="form-control" size="16" type="text" placeholder="mm/dd/yyyy" readonly ng-model="vm.fdatos.FecIniCli" ng-disabled="vm.validate_info==1">      
      </div>
      
       </div>
       </div>
       </div>
        <br><br><br><br>

       <div class="col-12 col-sm-12">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Razón Social <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fdatos.RazSocCli" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Razón Social del Cliente" maxlength="50" ng-disabled="vm.validate_info==1" ng-change="vm.asignar_a_nombre_comercial()"/>       
       </div>
       </div>
       </div>
      <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Nombre Comercial <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fdatos.NomComCli" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Razón Social del Cliente" maxlength="50" ng-disabled="vm.fdatos.misma_razon==false || vm.validate_info==1"/>
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

      <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Tipo de Cliente <b style="color:red;">(*)</b></label>
       <select class="form-control" id="CodTipCli" name="CodTipCli" ng-model="vm.fdatos.CodTipCli" placeholder="* Tipo de Cliente" ng-disabled="vm.validate_info==1">
         <option ng-repeat="dato in vm.tTipoCliente" value="{{dato.CodTipCli}}">{{dato.DesTipCli}}</option>                        
        </select>
       </div>
       </div>
       </div>  
        <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Sector <b style="color:red;">(*)</b></label>
       <select class="form-control" id="CodSecCli" name="CodSecCli" ng-model="vm.fdatos.CodSecCli" placeholder="* Sector" ng-disabled="vm.validate_info==1">
         <option ng-repeat="dato in vm.tSectores" value="{{dato.CodSecCli}}">{{dato.DesSecCli}}</option>                        
        </select>
       </div>
       </div>
       </div>      
      <div style="margin-top: 8px;">
       <div align="center"><label class="font-weight-bold nexa-dark" style="color:blue;"><b>DOMICILIO SOCIAL</b></label></div></div>
      
      <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Tipo de Via <b style="color:red;">(*)</b></label>
       <select class="form-control" id="CodTipViaSoc" name="CodTipViaSoc"  placeholder="* Tipo de Via" ng-model="vm.fdatos.CodTipViaSoc" ng-change="vm.asignar_tipo_via()" ng-disabled="vm.validate_info==1">
         <option ng-repeat="dato in vm.tTiposVias" value="{{dato.CodTipVia}}">{{dato.DesTipVia}} - {{dato.IniTipVia}}</option>                        
        </select>
       </div>
       </div>
       </div>

      <div class="col-12 col-sm-5">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Nombre del Domicilio <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fdatos.NomViaDomSoc" onkeyup="this.value=this.value.toUpperCase();" ng-change="vm.asignar_domicilio()" placeholder="* Nombre de la Via del Domicilio del Cliente" maxlength="30"  ng-disabled="vm.validate_info==1"/>       
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Número del Domicilio <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fdatos.NumViaDomSoc" onkeyup="this.value=this.value.toUpperCase();" min="1" ng-change="vm.asignar_num_domicilio()" placeholder="* Numero del Domicilio" maxlength="3" ng-disabled="vm.validate_info==1"/>       
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Bloque</label>
       <input type="text" class="form-control" ng-model="vm.fdatos.BloDomSoc" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Bloque del Domicilio" maxlength="3" ng-change="vm.asignar_bloq_domicilio()" ng-disabled="vm.validate_info==1"/>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Escalera</label>
       <input type="text" class="form-control" ng-model="vm.fdatos.EscDomSoc" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Escalera del Domicilio" ng-change="vm.asignar_esc_domicilio()" maxlength="2" ng-disabled="vm.validate_info==1"/>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Planta</label>
       <input type="text" class="form-control" ng-model="vm.fdatos.PlaDomSoc" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Planta del Domicilio" ng-change="vm.asignar_pla_domicilio()" maxlength="2" ng-disabled="vm.validate_info==1"/>
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Puerta</label>
       <input type="text" class="form-control" ng-model="vm.fdatos.PueDomSoc" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Puerta del Domicilio" ng-change="vm.asignar_puer_domicilio()" maxlength="4" ng-disabled="vm.validate_info==1"/>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Provincia <b style="color:red;">(*)</b></label>
        <select class="form-control" id="CodPro" name="CodPro"  ng-model="vm.fdatos.CodProSoc" ng-change="vm.filtrarLocalidad()" ng-disabled="vm.validate_info==1">
        <option ng-repeat="dato in vm.tProvidencias" value="{{dato.CodPro}}">{{dato.DesPro}}</option>                          
        </select>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Localidad <b style="color:red;">(*)</b></label>
       <select class="form-control" id="CodLoc" name="CodLoc" ng-change="vm.filtrar_zona_postal()"  ng-model="vm.fdatos.CodLocSoc" ng-disabled="vm.validate_info==1">
        <option ng-repeat="dato in vm.TLocalidadesfiltrada" value="{{dato.CodLoc}}">{{dato.DesLoc}}</option>                         
        </select>
       </div>
       </div>
       </div>
         <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Código Postal</label>
       <input type="text" class="form-control" ng-model="vm.fdatos.ZonPosSoc" placeholder="* Zona Postal" readonly ng-disabled="vm.validate_info==1"/>
       </div>
       </div>
       </div>
       <div style="margin-top: 8px;">
       <div align="center"><label class="font-weight-bold nexa-dark" style="color:blue;"><b>DOMICILIO FISCAL</b></label></div></div>
        <div align="left">
        <input type="checkbox" ng-model="vm.fdatos.distinto_a_social" ng-disabled="vm.validate_info==1||vm.fdatos.CodTipViaSoc==undefined||vm.fdatos.NomViaDomSoc==undefined||vm.fdatos.NumViaDomSoc           ==undefined||vm.fdatos.CodProSoc==undefined||vm.fdatos.CodLocSoc==undefined" ng-click="vm.distinto_a_social()"/><label class="font-weight-bold nexa-dark" style="color:black;">&nbsp;<b>Distinto a Domicilio Social</b></label> 
       </div>

       <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Tipo de Via <b style="color:red;" >(*)</b></label>
       <select class="form-control" id="CodTipViaFis" name="CodTipViaFis"  placeholder="* Tipo de Via" ng-model="vm.fdatos.CodTipViaFis" ng-disabled="vm.validate_info==1 ||vm.fdatos.distinto_a_social==false">
         <option ng-repeat="dato in vm.tTiposVias" value="{{dato.CodTipVia}}">{{dato.DesTipVia}} - {{dato.IniTipVia}}</option>                        
        </select>
       </div>
       </div>
       </div>

      <div class="col-12 col-sm-5">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Nombre del Domicilio <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fdatos.NomViaDomFis" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Nombre de la Via del Domicilio del Cliente" maxlength="30"  ng-disabled="vm.validate_info==1||vm.fdatos.distinto_a_social==false"/>       
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Número del Domicilio <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fdatos.NumViaDomFis" onkeyup="this.value=this.value.toUpperCase();"  min="1" placeholder="* Numero del Domicilio" maxlength="3" ng-disabled="vm.validate_info==1||vm.fdatos.distinto_a_social==false"/>       
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Bloque</label>
       <input type="text" class="form-control" ng-model="vm.fdatos.BloDomFis" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Bloque del Domicilio" maxlength="3" ng-disabled="vm.validate_info==1||vm.fdatos.distinto_a_social==false"/>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Escalera</label>
       <input type="text" class="form-control" ng-model="vm.fdatos.EscDomFis" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Escalera del Domicilio" maxlength="2" ng-disabled="vm.validate_info==1||vm.fdatos.distinto_a_social==false"/>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Planta</label>
       <input type="text" class="form-control" ng-model="vm.fdatos.PlaDomFis" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Planta del Domicilio" maxlength="2" ng-disabled="vm.validate_info==1||vm.fdatos.distinto_a_social==false"/>
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Puerta</label>
       <input type="text" class="form-control" ng-model="vm.fdatos.PueDomFis" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Puerta del Domicilio" maxlength="4" ng-disabled="vm.validate_info==1||vm.fdatos.distinto_a_social==false"/>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Provincia <b style="color:red;">(*)</b></label>
        <select class="form-control" id="CodProFisc" name="CodProFisc"  ng-model="vm.fdatos.CodProFis" ng-change="vm.filtrarLocalidadFisc()" ng-disabled="vm.validate_info==1||vm.fdatos.distinto_a_social==false">
        <option ng-repeat="dato in vm.tProvidencias" value="{{dato.CodPro}}">{{dato.DesPro}}</option>                          
        </select>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Localidad <b style="color:red;">(*)</b></label>
       <select class="form-control" id="CodLocFis" name="CodLocFis" ng-change="vm.filtrar_zona_postalFis()"  ng-model="vm.fdatos.CodLocFis" ng-disabled="vm.validate_info==1||vm.fdatos.distinto_a_social==false">
        <option ng-repeat="dato in vm.TLocalidadesfiltradaFisc" value="{{dato.CodLoc}}">{{dato.DesLoc}}</option>                         
        </select>
       </div>
       </div>
       </div>
         <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Código Postal</label>
       <input type="text" class="form-control" ng-model="vm.fdatos.ZonPosFis" placeholder="* Zona Postal" readonly ng-disabled="vm.validate_info==1||vm.fdatos.distinto_a_social==false"/>
       </div>
       </div>
       </div>





       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Teléfono <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fdatos.TelFijCli" ng-change="vm.validarsinuermo(vm.fdatos.TelFijCli)" placeholder="* Telefono del Cliente" maxlength="14"  ng-disabled="vm.validate_info==1"/>       
       </div>
       </div>
       </div>
       
       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Email <b style="color:red;">(*)</b></label>
       <input type="email" class="form-control" ng-model="vm.fdatos.EmaCli" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Correo Electrónico del Cliente" maxlength="50"  ng-disabled="vm.validate_info==1"/>       
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Página Web</label>
       <input type="url" class="form-control" ng-model="vm.fdatos.WebCli" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Pagina Web del Cliente" maxlength="50"  ng-disabled="vm.validate_info==1"/>       
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Comercial <b style="color:red;" >(*)</b></label>
        <select class="form-control" id="CodCom" name="CodCom"  ng-model="vm.fdatos.CodCom" ng-disabled="vm.validate_info==1"> 
          <option ng-repeat="dato in vm.tComerciales" value="{{dato.CodCom}}">NIF: {{dato.NIFCom}} - {{dato.NomCom}}</option>                          
        </select>       
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Colaborador</label>
        <select class="form-control" id="CodCol" name="CodCol"  ng-model="vm.fdatos.CodCol" ng-disabled="vm.validate_info==1"> 
          <option ng-repeat="dato in vm.tColaboradores" value="{{dato.CodCol}}">{{dato.NomCol}}</option>                          
        </select>       
       </div>
       </div>
       </div>

     
       <div class="form">                          
       <div class="form-group">
        <textarea class="form-control" style="display: inline-block;" onkeyup="this.value=this.value.toUpperCase();" id="ObsCli" name="ObsCli" type="text" minlength="1" maxlength="200" rows="5"  ng-model="vm.fdatos.ObsCli" ng-disabled="vm.validate_info==1"></textarea>
        <input class="form-control" id="CodCli" name="CodCli" type="hidden" ng-model="vm.fdatos.CodCli" readonly/>
       </div>
       </div>
      
         <div class="form-group" >
          <div class="col-12 col-sm-6">
            <button class="btn btn-info" type="submit" ng-show="vm.fdatos.CodCli==undefined||vm.fdatos.CodCli==null||vm.fdatos.CodCli==''" >GRABAR</button>
            <button class="btn btn-success" type="submit" ng-show="vm.fdatos.CodCli>0 && vm.validate_info==undefined" ng-disabled="vm.validate_info==1" >ACTUALIZAR</button>
            
            <button class="btn btn-danger" type="button"  ng-click="vm.borrar()" ng-show="vm.fdatos.CodCli>0 && vm.validate_info==undefined" ng-disabled="vm.Nivel==3 || vm.validate_info==1">BORRAR</button>

            <!--button class="btn btn-warning" type="button" ng-click="vm.limpiar()" ng-show="vm.fdatos.CodCli==undefined||vm.fdatos.CodCli==null||vm.fdatos.CodCli==''">LIMPIAR</button-->
            <button class="btn btn-primary" type="button" style="margin-top: 10px;" ng-click="vm.regresar()">REGRESAR</button>
          </div>
        </div>
         </div><!--FINAL ROW -->
        </form>
   
  </div><!--FINAL TABS 1 DATOS BASICOS DEL CLIENTE -->

      <!--INICIO TABS 2-->
      <div id="tabs-2">
        <!--t-0002 start-->  
       

      <div class='row'>              
       <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">CIF</label>
       <input type="text" class="form-control" ng-model="vm.fdatos.NumCifCli" maxlength="9" readonly placeholder="* Número del CIF del Cliente Comercial"/>
       
       </div>
       </div>
       </div> 
       <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Razon Social</label>
       <input type="text" class="form-control" ng-model="vm.fdatos.RazSocCli" placeholder="* Razon Social del Cliente" maxlength="50" required readonly/>       
       </div>
       </div>
       </div>
     </div>

        <div id="t-0002"><!--t-0002 start-->   
          <div style="float:left;margin-left: 0px;padding: 10px;margin-top: 10px;margin-bottom: 2px;" class="removeForMobile"><!--DIV removeformobile start-->                    
            <div class="t-0029"><!--t-0029 start--> 
              <div class="t-0031" style="margin-top: -8px; "><!--t-0031 start-->
                <div class="btn-group">
                  <button data-toggle="dropdown" title="Agregar Columnas" class="btn btn-default" type="button"><i class="fa fa-columns"></i> <span class="caret"></span></button>
                <ul class="dropdown-menu">
                  <li><input type="checkbox" ng-model="vm.fdatos.DesSec"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Sección</b></li>
                  <li><input type="checkbox" ng-model="vm.fdatos.DesGru"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Grupo</b></li></li>
                  <li><input type="checkbox" ng-model="vm.fdatos.DesEpi"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Epígrafe</b></li></li>
                  <li><input type="checkbox" ng-model="vm.fdatos.EstAct"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Estatus</b></li>
                  <li><input type="checkbox" ng-model="vm.fdatos.FecIniAct1"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Fecha Actividad</b></li></li>
                  <li><input type="checkbox" ng-model="vm.fdatos.AccAct"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Action</b></li>
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
                <a data-toggle="modal" title='Filtros' data-target="#modal_filtro_actividades" class="btn btn-default"><div><i class="fa fa-filter"></i><span class="caret"></span></div></a>                     
              </div>
            </div><!--t-0031 end--> 
          </div><!--t-0029 end--> 
        </div><!--DIV removeformobile end-->
          <div style="float:right;margin-left: 0px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
              <div class="t-0029">
                <form class="form-inline" role="form">
                  <div class="form-group">
                    <input type="text" class="form-control" ng-model="vm.fdatos.filtrar" minlength="1" id="exampleInputEmail2" placeholder="Escribe par filtrar...">
                  </div>  
                   <!--a data-toggle="modal" title="Asignar Actividad" style="margin-right: 5px;" data-target="#modal_asignar_actividades" class="btn btn-info"><div><i class="fa fa-plus-square"></i></div></a-->
                    <button title="Asignar Actividad" style="margin-right: 5px;" ng-disabled="vm.validate_info==1" ng-click="vm.asignar_actividad()" class="btn btn-info"><div><i class="fa fa-plus-square"></i></div></button>              
                  
                </form>                    
            </div>
          </div>
        </div>  <!--t-0002 end-->
      <br><br><br><br>
      <div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive">
                <tbody>
                  <tr>
                    <th ng-show="vm.fdatos.DesSec==true"><i class="fa fa-asterisk"></i> Sección</th>
                    <th ng-show="vm.fdatos.DesGru==true"><i class="fa fa-vcard"></i> Grupo</th>
                   <th ng-show="vm.fdatos.DesEpi==true"><i class="fa fa-building"></i> Epígrafe</th>
                    <th ng-show="vm.fdatos.EstAct==true"><i class="fa fa-bolt"></i> Estatus Actividad</th>
                    <th ng-show="vm.fdatos.FecIniAct1==true"><i class="fa fa-calendar"></i> Fecha Actividad</th>                    
                    <th ng-show="vm.fdatos.AccAct==true"><i class="icon_cogs"></i> Action</th>
                  </tr>
                  <tr ng-show="vm.TActividades==undefined"> 
                     <td colspan="6" align="center"><div class="td-usuario-table"><i class="fa fa-close"></i> Actualmente este cliente no tiene actividades asignadas.</div></td>           
                    </tr>
                  <tr ng-repeat="dato in vm.TActividades | filter:paginate1 | filter:vm.fdatos.filtrar" ng-class-odd="odd">
                    <td ng-show="vm.fdatos.DesSec==true">{{dato.DesSec}}</td>
                    <td ng-show="vm.fdatos.DesGru==true">{{dato.DesGru}}</td>
                    <td ng-show="vm.fdatos.DesEpi==true">{{dato.DesEpi}}</td>
                    <td ng-show="vm.fdatos.EstAct==true">{{dato.EstAct}}</td>
                    <td ng-show="vm.fdatos.FecIniAct1==true">{{dato.FecIniAct}}</td>                   
                    <td ng-show="vm.fdatos.AccAct==true">
                      <div class="btn-group">
                        <select class="form-control" id="opciones_actividades" name="opciones_actividades" ng-disabled="vm.validate_info==1" ng-model="vm.opciones_actividades[$index]" ng-change="vm.validar_actividad($index,vm.opciones_actividades[$index],dato)">
                          <option ng-repeat="opcion in vm.topcionesactividades" value="{{opcion.id}}">{{opcion.nombre}}</option>                          
                        </select>
                      
                      </div>
                    </td>
                  </tr>
                </tbody>
                <tfoot>                 
                    <th ng-show="vm.fdatos.DesSec==true"><i class="fa fa-asterisk"></i> Sección</th>
                    <th ng-show="vm.fdatos.DesGru==true"><i class="fa fa-vcard"></i> Grupo</th>
                    <th ng-show="vm.fdatos.DesEpi==true"><i class="fa fa-building"></i> Epígrafe</th>
                    <th ng-show="vm.fdatos.EstAct==true"><i class="fa fa-bolt"></i> Estatus Actividad</th>
                    <th ng-show="vm.fdatos.FecIniAct1==true"><i class="fa fa-calendar"></i> Fecha Actividad</th>                    
                    <th ng-show="vm.fdatos.AccAct==true"><i class="icon_cogs"></i> Action</th>
                </tfoot>
              </table>
        </div> 
        <div align="center">
          <span class="store-qty"> <a ng-click="vm.mostrar_all_actividades()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       
          <div class='btn-group' align="center">
            <pagination total-items="totalItems1" ng-model="currentPage1" max-size="5" boundary-links="true" items-per-page="numPerPage1" class="pagination-sm">  
            </pagination>
          </div>
        </div>



      </div>
      <!--FINAL TABS 2-->
      <!-- INICIO DE TABS 3-->
      <div id="tabs-3">
  
      <div ng-show="vm.fdatos.agregar_puntos_suministros==false">
      <div class='row'>              
       <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">CIF</label>
       <input type="text" class="form-control" ng-model="vm.fdatos.NumCifCli" maxlength="9" readonly placeholder="* Número del CIF del Cliente Comercial"/>
       
       </div>
       </div>
       </div> 
       <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Razon Social</label>
       <input type="text" class="form-control" ng-model="vm.fdatos.RazSocCli" placeholder="* Razon Social del Cliente" maxlength="50" required readonly/>       
       </div>
       </div>
       </div>
     </div>

        <div id="t-0002"><!--t-0002 start-->   
          <div style="float:left;margin-left: 0px;padding: 10px;margin-top: 10px;margin-bottom: 2px;" class="removeForMobile"><!--DIV removeformobile start-->                    
            <div class="t-0029"><!--t-0029 start--> 
              <div class="t-0031" style="margin-top: -8px; "><!--t-0031 start-->
                <div class="btn-group">
                  <button data-toggle="dropdown" title="Agregar Columnas" class="btn btn-default" type="button"><i class="fa fa-columns"></i> <span class="caret"></span></button>
                <ul class="dropdown-menu">
                  <li><input type="checkbox" ng-model="vm.TipRegDir1"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Tipo Dirección</b></li>
                  <li><input type="checkbox" ng-model="vm.CodTipVia1"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Tipo Via</b></li></li>
                  <li><input type="checkbox" ng-model="vm.fpuntosuministro.NomViaPunSum1"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Nombre Via</b></li></li>
                  <li><input type="checkbox" ng-model="vm.NumViaPunSum1"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Número</b></li>
                  <li><input type="checkbox" ng-model="vm.BloPunSum1"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Bloque</b></li></li>
                  <li><input type="checkbox" ng-model="vm.EscPunSum1"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Escalera</b></li></li>
                  <li><input type="checkbox" ng-model="vm.PlaPunSum1"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Planta</b></li></li>
                  <li><input type="checkbox" ng-model="vm.CodPro1"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Provincia</b></li></li>
                  <li><input type="checkbox" ng-model="vm.CodLoc1"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Localidad</b></li></li>
                  <li><input type="checkbox" ng-model="vm.TelPunSum1"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Teléfono</b></li></li>
                  <li><input type="checkbox" ng-model="vm.CodTipInm1"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Inmueble</b></li></li>
                  <li><input type="checkbox" ng-model="vm.RefCasPunSum1"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Referencia Catastral</b></li></li>
                  <li><input type="checkbox" ng-model="vm.DimPunSum1"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Área del Punto</b></li></li>
                  <li><input type="checkbox" ng-model="vm.ObsPunSum1"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Observación</b></li></li>
                  <li><input type="checkbox" ng-model="vm.EstPunSum1"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Estatus</b></li></li>
                  <li><input type="checkbox" ng-model="vm.AccPunSum1"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Action</b></li>
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
                <a data-toggle="modal" title='Filtro Puntos de Suministros'  data-target="#modal_filtro_puntos_suministros" class="btn btn-default"><div><i class="fa fa-filter"></i><span class="caret"></span></div></a>                     
              </div>
            </div><!--t-0031 end--> 
          </div><!--t-0029 end--> 
        </div><!--DIV removeformobile end-->
          <div style="float:right;margin-left: 0px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
              <div class="t-0029">
                <form class="form-inline" role="form">
                  <div class="form-group">
                    <input type="text" class="form-control" ng-model="vm.filtrar" minlength="1" id="exampleInputEmail2" placeholder="Escribe par filtrar...">
                  </div>  
                   <!--a data-toggle="modal" title="Asignar Actividad" style="margin-right: 5px;" data-target="#modal_asignar_actividades" class="btn btn-info"><div><i class="fa fa-plus-square"></i></div></a-->
                    <button title="Agregar Punto Suministro" ng-disabled="vm.validate_info==1" style="margin-right: 5px;" ng-click="vm.asignar_punto_suministro()" class="btn btn-info"><div><i class="fa fa-plus-square"></i></div></button>              
                  
                </form>                    
            </div>
          </div>
        </div>  <!--t-0002 end-->
      <br><br><br><br>
      <div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive">
                <tbody>
                  <tr>
                  <th ng-show="vm.TipRegDir1==true"><i class="fa fa-asterisk"></i> Tipo Dirección</th>
                  <th ng-show="vm.CodTipVia1==true"><i class="fa fa-vcard"></i> Tipo Via</th>
                  <th ng-show="vm.NomViaPunSum1==true"><i class="fa fa-building"></i> Nombre Via</th>
                  <th ng-show="vm.NumViaPunSum1==true"><i class="fa fa-bolt"></i> Número Via</th>
                  <th ng-show="vm.BloPunSum1==true"><i class="fa fa-calendar"></i> Bloque</th>
                  <th ng-show="vm.EscPunSum1==true"><i class="fa fa-calendar"></i> Escalera</th>
                  <th ng-show="vm.PlaPunSum1==true"><i class="fa fa-calendar"></i> Planta</th> 
                  <th ng-show="vm.PuePunSum1==true"><i class="fa fa-calendar"></i> Puerta</th> 
                  <th ng-show="vm.CodPro1==true"><i class="fa fa-calendar"></i> Provincia</th>
                  <th ng-show="vm.CodLoc1==true"><i class="fa fa-calendar"></i> Localidad</th>
                  <th ng-show="vm.TelPunSum1==true"><i class="fa fa-phone"></i> Teléfono</th>
                  <th ng-show="vm.CodTipInm1==true"><i class="fa fa-calendar"></i> Inmueble</th>
                  <th ng-show="vm.RefCasPunSum1==true"><i class="fa fa-calendar"></i> Referencia Catastral</th>
                  <th ng-show="vm.DimPunSum1==true"><i class="fa fa-calendar"></i> Área del Punto</th>
                  <th ng-show="vm.ObsPunSum1==true"><i class="fa fa-calendar"></i> Observación</th>
                  <th ng-show="vm.EstPunSum1==true"><i class="fa fa-calendar"></i> Estatus</th>
                  <th ng-show="vm.AccPunSum1==true"><i class="icon_cogs"></i> Action</th>
                  </tr>
                  <tr ng-show="vm.tPuntosSuminitros==false"> 
                     <td colspan="17" align="center"><div class="td-usuario-table"><i class="fa fa-close"></i> Actualmente este cliente no hay puntos de suministros asignados.</div></td>           
                    </tr>
                  <tr ng-repeat="dato in vm.tPuntosSuminitros | filter:paginate2 | filter:vm.filtrar" ng-class-odd="odd">
                    <td ng-show="vm.TipRegDir1==true">{{dato.TipDir}}</td>
                    <td ng-show="vm.CodTipVia1==true">{{dato.DesTipVia}}</td>
                    <td ng-show="vm.NomViaPunSum1==true">{{dato.NomViaPunSum}}</td>
                    <td ng-show="vm.NumViaPunSum1==true">{{dato.NumViaPunSum}}</td>
                    <td ng-show="vm.BloPunSum1==true">{{dato.BloPunSum}}</td> 
                    <td ng-show="vm.EscPunSum1==true">{{dato.EscPunSum}}</td>
                    <td ng-show="vm.PlaPunSum1==true">{{dato.PlaPunSum}}</td>
                    <td ng-show="vm.PuePunSum1==true">{{dato.PuePunSum}}</td>
                    <td ng-show="vm.CodPro1==true">{{dato.DesPro}}</td> 
                    <td ng-show="vm.CodLoc1==true">{{dato.DesLoc}}</td>
                    <td ng-show="vm.TelPunSum1==true">{{dato.TelPunSum}}</td>
                    <td ng-show="vm.CodTipInm1==true">{{dato.DesTipInm}}</td>  
                    <td ng-show="vm.RefCasPunSum1==true">{{dato.RefCasPunSum}}</td> 
                    <td ng-show="vm.DimPunSum1==true">{{dato.DimPunSum}}</td>
                    <td ng-show="vm.ObsPunSum1==true">{{dato.ObsPunSum}}</td>
                    <td ng-show="vm.EstPunSum1==true">{{dato.EstuPunSum}}</td>
                    <td ng-show="vm.AccPunSum1==true">
                      <div class="btn-group">
                        <select class="form-control" id="opciones_PunSum" name="opciones_PunSum" ng-disabled="vm.validate_info==1" ng-model="vm.opciones_PunSum[$index]" ng-change="vm.validar_PunSum($index,vm.opciones_PunSum[$index],dato)">
                          <option ng-repeat="opcion in vm.topcionesPunSum" value="{{opcion.id}}">{{opcion.nombre}}</option>                          
                        </select>
                      </div>
                    </td>
                  </tr>
                </tbody>
                <tfoot>                 
                  <th ng-show="vm.TipRegDir1==true"><i class="fa fa-asterisk"></i> Tipo Dirección</th>
                  <th ng-show="vm.CodTipVia1==true"><i class="fa fa-vcard"></i> Tipo Via</th>
                  <th ng-show="vm.NomViaPunSum1==true"><i class="fa fa-building"></i> Nombre Via</th>
                  <th ng-show="vm.NumViaPunSum1==true"><i class="fa fa-bolt"></i> Número Via</th>
                  <th ng-show="vm.BloPunSum1==true"><i class="fa fa-calendar"></i> Bloque</th>
                  <th ng-show="vm.EscPunSum1==true"><i class="fa fa-calendar"></i> Escalera</th>
                  <th ng-show="vm.PlaPunSum1==true"><i class="fa fa-calendar"></i> Planta</th> 
                  <th ng-show="vm.PuePunSum1==true"><i class="fa fa-calendar"></i> Puerta</th> 
                  <th ng-show="vm.CodPro1==true"><i class="fa fa-calendar"></i> Provincia</th>
                  <th ng-show="vm.CodLoc1==true"><i class="fa fa-calendar"></i> Localidad</th>
                  <th ng-show="vm.TelPunSum1==true"><i class="fa fa-phone"></i> Teléfono</th>
                  <th ng-show="vm.CodTipInm1==true"><i class="fa fa-calendar"></i> Inmueble</th>
                  <th ng-show="vm.RefCasPunSum1==true"><i class="fa fa-calendar"></i> Referencia Catastral</th>
                  <th ng-show="vm.DimPunSum1==true"><i class="fa fa-calendar"></i> Área del Punto</th>
                  <th ng-show="vm.ObsPunSum1==true"><i class="fa fa-calendar"></i> Observación</th>
                  <th ng-show="vm.EstPunSum1==true"><i class="fa fa-calendar"></i> Estatus</th>
                  <th ng-show="vm.AccPunSum1==true"><i class="icon_cogs"></i> Action</th>
                </tfoot>
              </table>
        </div> 
        <div align="center">
          <span class="store-qty"> <a ng-click="vm.mostrar_all_puntos()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       
          <div class='btn-group' align="center">
            <pagination total-items="totalItems2" ng-model="currentPage2" max-size="5" boundary-links="true" items-per-page="numPerPage2" class="pagination-sm">  
            </pagination>
          </div>
        </div>

        <!-- modal container section end -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_filtro_puntos_suministros" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Tipos de Filtros</h4>
          </div>
          <div class="modal-body">
                        <div class="panel">                  
      <form class="form-validate" id="frmfiltroPumSum" name="frmfiltroPumSum" ng-submit="SubmitFormFiltrosPumSum($event)">                 
     
     <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">TIPO DE FILTRO</label>
      <select class="form-control" id="tipo_filtro" name="tipo_filtro" required ng-model="vm.fpuntosuministro.tipo_filtro">
          <option ng-repeat="dato in vm.ttipofiltrosPunSum" value="{{dato.id}}">{{dato.nombre}}</option>
        </select>     
     </div>
     </div>
     </div>
     <br>
     <br>
     <br>
     <br> 
     <div class="col-12 col-sm-6" ng-show="vm.fpuntosuministro.tipo_filtro==1 || vm.fpuntosuministro.tipo_filtro==2">
     <div class="form">                          
     <div class="form-group">
     
      <select class="form-control" name="CodPro" ng-model="vm.fpuntosuministro.CodPro" ng-change="vm.filtrar_locaPumSum()">
        <option ng-repeat="dato in vm.tProvidencias" value="{{dato.DesPro}}">{{dato.DesPro}}</option>                          
      </select>    
     </div>
     </div>
    </div>

     <div class="col-12 col-sm-6" ng-show="vm.fpuntosuministro.tipo_filtro==2">
     <div class="form">                          
     <div class="form-group">
     
      <select class="form-control" id="CodLocFil" name="CodLocFil" ng-model="vm.fpuntosuministro.CodLocFil" ng-disabled="vm.fpuntosuministro.CodPro==undefined || vm.fpuntosuministro.CodPro==null">
        <option ng-repeat="dato in vm.TLocalidadesfiltradaPumSum" value="{{dato.DesLoc}}">{{dato.DesLoc}}</option>                         
      </select>     
     </div>
     </div>
     </div>

     <div class="col-12 col-sm-6" ng-show="vm.fpuntosuministro.tipo_filtro==3">
     <div class="form">                          
     <div class="form-group">
     
      <select class="form-control" id="CodTipInm" name="CodTipInm" ng-model="vm.fpuntosuministro.CodTipInm">
        <option ng-repeat="dato in vm.TtiposInmuebles" value="{{dato.DesTipInm}}">{{dato.DesTipInm}}</option>                        
      </select>   
     </div>
     </div>
    </div>
   

    <div class="col-12 col-sm-6" ng-show="vm.fpuntosuministro.tipo_filtro==4">
     <div class="form">                          
     <div class="form-group">
     
      <select class="form-control" id="EstPunSum" name="EstPunSum" ng-model="vm.fpuntosuministro.EstPunSum">
        <option value="1">ACTIVO</option> 
        <option value="2">BLOQUEADO</option>                         
      </select>     
     </div> 
     </div>
     </div>     
    <br ng-show="vm.fpuntosuministro.tipo_filtro==1 || vm.fpuntosuministro.tipo_filtro==3 || vm.fpuntosuministro.tipo_filtro==4">
     <br ng-show="vm.fpuntosuministro.tipo_filtro==1 || vm.fpuntosuministro.tipo_filtro==3|| vm.fpuntosuministro.tipo_filtro==4"> 
    <br>
    <div style="margin-left:15px; ">
     <button class="btn btn-info" type="submit" ng-disabled="frmfiltroPumSum.$invalid">APLICAR</button>
      <a class="btn btn-danger" ng-click="vm.regresar_filtroPumSum()">REGRESAR</a>
      </div>
</form>
   </div>
    </div>
</div>
</div>
</div>
<!--modal container section end -->







      

      </div>  <!-- FINAL DE NG-SHOW-->

      <div ng-show="vm.fdatos.agregar_puntos_suministros==true">
        
    <form id="register_form" name="register_form" ng-submit="submitFormPuntoSuministro($event)"> 
     <div class='row'>              
       <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">CIF <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fdatos.NumCifCli" maxlength="9" ng-disabled="vm.validate_cif==1 || vm.fdatos.CodCli>=0" placeholder="* Número del CIF del Cliente Comercial"/>
       
       </div>
       </div>
       </div>
       <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Razón Social <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fdatos.RazSocCli" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Razón Social del Cliente" maxlength="50"  ng-disabled="vm.validate_cif==1 || vm.fdatos.CodCli>=0" ng-change="vm.asignar_a_nombre_comercial()"/>       
       </div>
       </div>
       </div>
      
      <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Nuevo</label>
      <input type="radio" class="form-control" name="punto_suministro" id="punto_suministro" ng-model="vm.fpuntosuministro.TipRegDir" value="0" ng-click="vm.punto_suministro(1,vm.fpuntosuministro.TipRegDir)" ng-disabled="vm.validate_info==1"/> 
       </div>
       </div>
       </div>
      <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Misma Dirección Social</label>
       <input type="radio" class="form-control" name="punto_suministro" id="punto_suministro" ng-model="vm.fpuntosuministro.TipRegDir" value="1" ng-click="vm.punto_suministro(2,vm.fpuntosuministro.TipRegDir)" ng-disabled="vm.validate_info==1"/>       
       </div>
       </div>
       </div> 

      <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Misma Dirección Fiscal</label>
       <input type="radio" class="form-control" name="punto_suministro" id="punto_suministro" ng-model="vm.fpuntosuministro.TipRegDir" value="2" ng-click="vm.punto_suministro(3,vm.fpuntosuministro.TipRegDir)" ng-disabled="vm.validate_info==1"/>
       </div>
       </div>
       </div>

     
      <div style="margin-top: 8px;">
       <div align="center"><label class="font-weight-bold nexa-dark" style="color:blue;"><b>DIRECCIÓN</b></label></div></div>
      
      <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Tipo de Via <b style="color:red;">(*)</b></label>
       <select class="form-control" id="CodTipVia" name="CodTipVia"  placeholder="* Tipo de Via" ng-model="vm.fpuntosuministro.CodTipVia" ng-change="vm.asignar_tipo_via()" ng-disabled="vm.validate_info==1 || vm.fpuntosuministro.TipRegDir==undefined">
         <option ng-repeat="dato in vm.tTiposVias" value="{{dato.CodTipVia}}">{{dato.DesTipVia}} - {{dato.IniTipVia}}</option>                        
        </select>
       </div>
       </div>
       </div>

      <div class="col-12 col-sm-5">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Nombre de la Via <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fpuntosuministro.NomViaPunSum" onkeyup="this.value=this.value.toUpperCase();" ng-change="vm.asignar_domicilio()" placeholder="* Nombre de la Via del Punto de Suministro" maxlength="30"  ng-disabled="vm.validate_info==1|| vm.fpuntosuministro.TipRegDir==undefined"/>       
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Número <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fpuntosuministro.NumViaPunSum" onkeyup="this.value=this.value.toUpperCase();" min="1" ng-change="vm.asignar_num_domicilio()" placeholder="* Numero del Punto de Suministro" maxlength="2" ng-disabled="vm.validate_info==1|| vm.fpuntosuministro.TipRegDir==undefined"/>       
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-2">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Bloque</label>
       <input type="text" class="form-control" ng-model="vm.fpuntosuministro.BloPunSum" onkeyup="this.value=this.value.toUpperCase();" placeholder="Bloque del Punto de Suministro" maxlength="3" ng-change="vm.asignar_bloq_domicilio()" ng-disabled="vm.validate_info==1|| vm.fpuntosuministro.TipRegDir==undefined"/>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-2">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Escalera</label>
       <input type="text" class="form-control" ng-model="vm.fpuntosuministro.EscPunSum" onkeyup="this.value=this.value.toUpperCase();" placeholder="Escalera del Punto de Suministro" ng-change="vm.asignar_esc_domicilio()" maxlength="2" ng-disabled="vm.validate_info==1|| vm.fpuntosuministro.TipRegDir==undefined"/>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-2">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Planta</label>
       <input type="text" class="form-control" ng-model="vm.fpuntosuministro.PlaPunSum" onkeyup="this.value=this.value.toUpperCase();" placeholder="Planta del Punto de Suministro" ng-change="vm.asignar_pla_domicilio()" maxlength="3" ng-disabled="vm.validate_info==1|| vm.fpuntosuministro.TipRegDir==undefined"/>
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Puerta</label>
       <input type="text" class="form-control" ng-model="vm.fpuntosuministro.PuePunSum" onkeyup="this.value=this.value.toUpperCase();" placeholder="Puerta del Punto de Suministro" ng-change="vm.asignar_puer_domicilio()" maxlength="4" ng-disabled="vm.validate_info==1|| vm.fpuntosuministro.TipRegDir==undefined"/>
       </div>
       </div>
       </div>
        <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Aclarador</label>
       <input type="text" class="form-control" ng-model="vm.fpuntosuministro.Aclarador" onkeyup="this.value=this.value.toUpperCase();" placeholder="Aclarador" ng-change="vm.asignar_puer_domicilio()" maxlength="4" ng-disabled="vm.validate_info==1|| vm.fpuntosuministro.TipRegDir==undefined"/>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Provincia <b style="color:red;">(*)</b></label>
        <select class="form-control" id="CodPro" name="CodPro"  ng-model="vm.fpuntosuministro.CodProPunSum" ng-change="vm.filtrarLocalidadPunSum()" ng-disabled="vm.validate_info==1|| vm.fpuntosuministro.TipRegDir==undefined">
        <option ng-repeat="dato in vm.tProvidencias" value="{{dato.CodPro}}">{{dato.DesPro}}</option>                          
        </select>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Localidad <b style="color:red;">(*)</b></label>
       <select class="form-control" id="CodLocPunSum" name="CodLocPunSum" ng-change="vm.filtrar_zona_postalPunSum()"  ng-model="vm.fpuntosuministro.CodLocPunSum" ng-disabled="vm.validate_info==1|| vm.fpuntosuministro.TipRegDir==undefined">
        <option ng-repeat="dato in vm.TLocalidadesfiltradaPunSum" value="{{dato.CodLoc}}">{{dato.DesLoc}}</option>                         
        </select>
       </div>
       </div>
       </div>
         <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Código Postal</label>
       <input type="text" class="form-control" ng-model="vm.ZonPosPunSum" placeholder="Zona Postal" readonly ng-disabled="vm.validate_info==1|| vm.fpuntosuministro.TipRegDir==undefined"/>
       </div>
       </div>
       </div>      

       <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Teléfono <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fpuntosuministro.TelPunSum" ng-change="vm.validarsinuermo(vm.fpuntosuministro.TelPunSum)" placeholder="* Telefono del Punto de Suministro" maxlength="9" ng-disabled="vm.validate_info==1|| vm.fpuntosuministro.TipRegDir==undefined"/>       
       </div>
       </div>
       </div>
       
       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Tipo de Inmueble <b style="color:red;">(*)</b></label>
       <select class="form-control" id="CodTipInm" name="CodTipInm"  placeholder="* Tipo de Via" ng-model="vm.fpuntosuministro.CodTipInm" ng-disabled="vm.validate_info==1|| vm.fpuntosuministro.TipRegDir==undefined">
         <option ng-repeat="dato in vm.TtiposInmuebles" value="{{dato.CodTipInm}}">{{dato.DesTipInm}}</option>                        
        </select>       
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Referencia Castastral</label>
       <input type="text" class="form-control" ng-model="vm.fpuntosuministro.RefCasPunSum" onkeyup="this.value=this.value.toUpperCase();" placeholder="Referencia Castastral del Punto de Suministro" maxlength="20" ng-disabled="vm.validate_info==1|| vm.fpuntosuministro.TipRegDir==undefined"/>       
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Area</label>
        <input type="text" class="form-control" ng-model="vm.fpuntosuministro.DimPunSum" onkeyup="this.value=this.value.toUpperCase();" placeholder="Área del Punto de Suministro" maxlength="5" ng-disabled="vm.validate_info==1 || vm.fpuntosuministro.TipRegDir==undefined" ng-change="vm.validarsinuermoPumSumArea(vm.fpuntosuministro.DimPunSum)"/>       
       </div>
       </div>
       </div>

       <div class="form">                          
       <div class="form-group">
        <textarea class="form-control" style="display: inline-block;" onkeyup="this.value=this.value.toUpperCase();" id="ObsPunSum" name="ObsPunSum" type="text" minlength="1" maxlength="200" rows="5"  ng-model="vm.fpuntosuministro.ObsPunSum" ng-disabled="vm.validate_info==1|| vm.fpuntosuministro.TipRegDir==undefined"></textarea>
       
       </div>
       </div>
       <input class="form-control" id="CodPunSum" name="CodPunSum" type="hidden" ng-model="vm.fpuntosuministro.CodPunSum" readonly/>
         <div class="form-group" >
          <div class="col-12 col-sm-6">
            
            <button class="btn btn-info" type="submit" ng-show="vm.fpuntosuministro.CodPunSum==undefined&& vm.validate_info==undefined||vm.fpuntosuministro.CodPunSum==null&& vm.validate_info==undefined||vm.fpuntosuministro.CodPunSum==''&& vm.validate_info==undefined" ng-disabled="vm.fpuntosuministro.TipRegDir==undefined">REGISTRAR</button>

            <button class="btn btn-success" type="submit" ng-show="vm.fpuntosuministro.CodPunSum>0 && vm.validate_info==undefined" ng-disabled="vm.validate_info==1">ACTUALIZAR</button>            
            
            <button class="btn btn-danger" type="button" ng-click="vm.regresar_punto_suministro()">REGRESAR</button>
          </div>
        </div>
         </div><!--FINAL ROW -->
        </form>


      </div>


      <!-- modal container section end -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_motivo_bloqueo_punto_suministro" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Bloqueo de Puntos de Suministros</h4>
          </div>
          <div class="modal-body">
                        <div class="panel"> 
                 <input type="hidden" class="form-control" ng-model="vm.fdatos.CodCli" required readonly />
    <form class="form-validate" id="form_lock_PunSum" name="form_lock_PunSum" ng-submit="submitFormlockPunSum($event)">                 
     <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">CIF</label>
     <input type="text" class="form-control" ng-model="vm.fdatos.NumCifCli" required readonly/>     
     </div>
     </div>
     </div>

    <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Fecha de Bloqueo</label>
     <input type="text" class="form-control" ng-model="vm.FecBloPun" required readonly/>    
     </div>
     </div>
     </div>

     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Razon Social del Cliente</label>
     <input type="text" class="form-control" ng-model="vm.fdatos.RazSocCli" required readonly />     
     </div>
     </div>

      <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Motivo del Bloqueo</label>
     
      <select class="form-control" id="MotBloPunSum" name="MotBloPunSum" required ng-model="vm.tPunSum.MotBloPunSum">
          <option ng-repeat="dato in vm.tMotivosBloqueosPunSum" value="{{dato.CodMotBloPun}}">{{dato.DesMotBloPun}}</option>
        </select>


     </div>
     </div>

     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Observación</label>
     <textarea type="text" class="form-control" ng-model="vm.tPunSum.ObsBloPunSum" rows="5" maxlength="100"/></textarea>
     </div>
     </div>
    
    <br>
     <button class="btn btn-info" type="submit" ng-disabled="form_lock_PunSum.$invalid">Bloquear</button>
      <a class="btn btn-danger" data-dismiss="modal">Regresar</a>
</form>
   </div>
    </div>
</div>
</div>
</div>
<!-- modal container section end -->

      </div>
      <!-- FINAL DE TABS 3-->
       <!-- INICIO DE TABS 4-->
      <div id="tabs-4">

         hola esto es tabs 4       
      </div>
      <!-- FINAL DE TABS 4-->

       <!-- INICIO DE TABS 5-->
      <div id="tabs-5">
 <div ng-show="vm.agregar_cuentas==false">
      <div class='row'>              
       <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">CIF</label>
       <input type="text" class="form-control" ng-model="vm.fdatos.NumCifCli" maxlength="9" readonly placeholder="* Número del CIF del Cliente Comercial"/>
       
       </div>
       </div>
       </div> 
       <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Razon Social</label>
       <input type="text" class="form-control" ng-model="vm.fdatos.RazSocCli" placeholder="* Razon Social del Cliente" maxlength="50" required readonly/>       
       </div>
       </div>
       </div>
     </div>

        <div id="t-0002"><!--t-0002 start-->   
          <div style="float:left;margin-left: 0px;padding: 10px;margin-top: 10px;margin-bottom: 2px;" class="removeForMobile"><!--DIV removeformobile start-->                    
            <div class="t-0029"><!--t-0029 start--> 
              <div class="t-0031" style="margin-top: -8px; "><!--t-0031 start-->
                <div class="btn-group">
                  <button data-toggle="dropdown" title="Agregar Columnas" class="btn btn-default" type="button"><i class="fa fa-columns"></i> <span class="caret"></span></button>
                <ul class="dropdown-menu">
                  <li><input type="checkbox" ng-model="vm.CodBan1"/> <i class="fa fa-plus-square"></i> <b style="color:black;">BANCO</b></li>
                  <li><input type="checkbox" ng-model="vm.NumIBan1"/> <i class="fa fa-plus-square"></i> <b style="color:black;">IBAN</b></li></li>
                  <li><input type="checkbox" ng-model="vm.EstCue"/> <i class="fa fa-plus-square"></i> <b style="color:black;">ESTATUS</b></li></li>
                  <li><input type="checkbox" ng-model="vm.ActBan1"/> <i class="fa fa-plus-square"></i> <b style="color:black;">ACCIÓN</b></li>
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
                <a data-toggle="modal" title='Filtros' data-target="#modal_filtro_cuentas_bancarias" class="btn btn-default"><div><i class="fa fa-filter"></i><span class="caret"></span></div></a>                     
              </div>
            </div><!--t-0031 end--> 
          </div><!--t-0029 end--> 
        </div><!--DIV removeformobile end-->
          <div style="float:right;margin-left: 0px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
              <div class="t-0029">
                <form class="form-inline" role="form">
                  <div class="form-group">
                    <input type="text" class="form-control" ng-model="vm.tgribBancos.filtrar" minlength="1" id="exampleInputEmail2" placeholder="Escribe par filtrar...">
                  </div>  
                   <!--a data-toggle="modal" title="Asignar Actividad" style="margin-right: 5px;" data-target="#modal_asignar_actividades" class="btn btn-info"><div><i class="fa fa-plus-square"></i></div></a-->
                    <a title="Agregar Cuenta Bancaria" style="margin-right: 5px;" ng-click="vm.asignar_cuenta_bancaria()" class="btn btn-info"><div><i class="fa fa-plus-square"></i></div></a>              
                  
                </form>                    
            </div>
          </div>
        </div>  <!--t-0002 end-->
      <br><br><br><br>
      <div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive">
                <tbody>
                  <tr>
                  <th ng-show="vm.CodBan1==true"><i class="fa fa-bank"></i> BANCO</th>
                  <th ng-show="vm.NumIBan1==true"><i class="fa fa-asterisk"></i> IBAN</th> 
                  <th ng-show="vm.EstCue==true"><i class="fa fa-building"></i> ESTATUS</th>                
                  <th ng-show="vm.ActBan1==true"><i class="icon_cogs"></i> ACCIÓN</th>
                  </tr>
                  <tr ng-show="vm.tCuentaBan==false"> 
                    <td colspan="3" align="center">
                      <div class="td-usuario-table"><i class="fa fa-close"></i> Actualmente este cliente no hay cuentas bancarias registradas.</div>
                    </td>           
                    </tr>
                  <tr ng-repeat="dato in vm.tCuentaBan | filter:paginate3 | filter:vm.tgribBancos.filtrar" ng-class-odd="odd">
                    <td ng-show="vm.CodBan1==true">{{dato.DesBan}}</td>
                    <td ng-show="vm.NumIBan1==true">{{dato.CodEur}} {{dato.IBAN1}} {{dato.IBAN2}} {{dato.IBAN3}} {{dato.IBAN4}} {{dato.IBAN5}}</td>
                    <td ng-show="vm.EstCue==true">
                      <span class="label label-info" ng-show="dato.EstCue==1"><i class="fa fa-check-circle"></i> {{dato.EstaCue}}</span>
                      <span class="label label-danger" ng-show="dato.EstCue==2"><i class="fa fa-ban"></i> {{dato.EstaCue}}</span>



                   </td>
                    <td ng-show="vm.ActBan1==true">
                      <div class="btn-group">
                        <select class="form-control" id="opciones_Ban" name="opciones_Ban" ng-model="vm.opciones_Ban[$index]" ng-change="vm.validar_OpcBan($index,vm.opciones_Ban[$index],dato)">
                          <option ng-repeat="opcion in vm.topcionesBan" value="{{opcion.id}}">{{opcion.nombre}}</option>                          
                        </select>
                      </div>
                    </td>
                  </tr>
                </tbody>
                <tfoot>                 
                   <th ng-show="vm.CodBan1==true"><i class="fa fa-bank"></i> BANCO</th>
                  <th ng-show="vm.NumIBan1==true"><i class="fa fa-asterisk"></i> IBAN</th> 
                  <th ng-show="vm.EstCue==true"><i class="fa fa-building"></i> ESTATUS</th>                
                  <th ng-show="vm.ActBan1==true"><i class="icon_cogs"></i> ACCIÓN</th>
                </tfoot>
              </table>
        </div> 
        <div align="center">
          <span class="store-qty"> <a ng-click="vm.cargar_cuentas_bancarias()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       
          <div class='btn-group' align="center">
            <pagination total-items="totalItems3" ng-model="currentPage3" max-size="5" boundary-links="true" items-per-page="numPerPage3" class="pagination-sm">  
            </pagination>
          </div>
        </div>
      </div>  <!-- FINAL DE NG-SHOW-->


      <div ng-show="vm.agregar_cuentas==true">
            
        <form class="form-validate" id="form_cuenta_bancaria" name="form_cuenta_bancaria" ng-submit="submitFormRegistroCuentaBanca($event)">                 
             <div class="col-12 col-sm-6">
             <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">CIF</label>
             <input type="text" class="form-control" ng-model="vm.fdatos.NumCifCli" required readonly/>     
             </div>
             </div>
             </div>
            <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Razon Social del Cliente</label>
             <input type="text" class="form-control" ng-model="vm.fdatos.RazSocCli" required readonly />     
             </div>
             </div>
          </div>
           <div class="col-12 col-sm-12">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Banco</label>
             <select class="form-control" id="CodBan" name="CodBan" required ng-model="vm.tgribBancos.CodBan" ng-change="vm.filtrar_cod_banco()">
               <option ng-repeat="dato in vm.tListBanc" value="{{dato.CodBan}}">{{dato.DesBan}}</option>
            </select>     
             </div>
             </div>
          </div>
          <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">IBAN</label>
             <input type="text" class="form-control" ng-model="vm.CodEur" maxlength="4" required ng-disabled="vm.tgribBancos.CodBan==undefined" ng-change="vm.validarsinuermoCodEur(vm.CodEur)" />     
             </div>
             </div>
          </div>
          <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">   
              <label class="font-weight-bold nexa-dark" style="color:black;"></label>          
             <input type="text" class="form-control" style="margin-top: 5px;" ng-model="vm.IBAN1" maxlength="4" ng-change="vm.validarsinuermoIBAN1(vm.IBAN1)" required  ng-disabled="vm.tgribBancos.CodBan==undefined"/>     
             </div>
             </div>
          </div>
           <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;"></label>         
             <input type="text" style="margin-top: 5px;" class="form-control" ng-model="vm.IBAN2" maxlength="4" required ng-change="vm.validarsinuermoIBAN2(vm.IBAN2)" ng-disabled="vm.tgribBancos.CodBan==undefined"/>     
             </div>
             </div>
          </div>
           <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">  
              <label class="font-weight-bold nexa-dark" style="color:black;"></label>           
             <input type="text" style="margin-top: 5px;" class="form-control" ng-model="vm.IBAN3" maxlength="4" required ng-change="vm.validarsinuermoIBAN3(vm.IBAN3)"  ng-disabled="vm.tgribBancos.CodBan==undefined"/>     
             </div>
             </div>
          </div>
           <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">
              <label class="font-weight-bold nexa-dark" style="color:black;"></label>             
             <input type="text" style="margin-top: 5px;" class="form-control" ng-model="vm.IBAN4" maxlength="4" required ng-change="vm.validarsinuermoIBAN4(vm.IBAN4)"  ng-disabled="vm.tgribBancos.CodBan==undefined"/>     
             </div>
             </div>
          </div>
           <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">  
              <label class="font-weight-bold nexa-dark" style="color:black;"></label>           
             <input type="text" style="margin-top: 5px;" class="form-control" ng-model="vm.IBAN5" maxlength="4" required ng-change="vm.validarsinuermoIBAN5(vm.IBAN5)" ng-disabled="vm.tgribBancos.CodBan==undefined"/>     
             </div>
             </div>
          </div>
            
             <button class="btn btn-info" type="submit" ng-disabled="form_cuenta_bancaria.$invalid || vm.numIBanValidado==true">REGISTRAR</button>
              <a class="btn btn-danger" ng-click="vm.regresar_cuenta_bancaria()">REGRESAR</a>
        </form>
        <input type="hidden" class="form-control" ng-model="vm.tgribBancos.CodCueBan" required readonly />
      </div>
  
      </div>
      <!-- FINAL DE TABS 5-->

       <!-- INICIO DE TABS 3-->
      <div id="tabs-6">

         hola esto es tabs 6       
      </div>
      <!-- FINAL DE TABS 6-->
            
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

  <!--modal container section end -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_filtro_actividades" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Filtrar Actividades</h4>
          </div>
          <div class="modal-body">
                        <div class="panel">                  
      <form class="form-validate" id="frmfiltrAct" name="frmfiltrAct" ng-submit="SubmitFormFiltrosAct($event)">                 
     
     <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">TIPO DE FILTRO</label>
      <select class="form-control" id="MotBloq" name="MotBloq" required ng-model="vm.tmodal_data.tipo_filtro_actividad">
          <option ng-repeat="dato in vm.ttipofiltrosact" value="{{dato.id}}">{{dato.nombre}}</option>
        </select>     
     </div>
     </div>
     </div>
     <br>
     <br>
     <br>
     <br> 

    <div class="col-12 col-sm-6" ng-show="vm.tmodal_data.tipo_filtro_actividad==1">
     <div class="form">                          
     <div class="form-group">
      <input class="form-control" type="text" ng-change="vm.validarsifecha(vm.tmodal_data.FecIniActFil)" ng-model="vm.tmodal_data.FecIniActFil" placeholder="DD-MM-YYYY">        
     <!--input type="text" class="form-control" ng-model="vm.tmodal_data.FecIniActFil" id="FecIniActFil" minlength="1" id="exampleInputEmail2" placeholder="DD-MM-YYYY"-->
     </div>
     </div>    
    </div>

    <div class="col-12 col-sm-6" ng-show="vm.tmodal_data.tipo_filtro_actividad==2">
     <div class="form">                          
     <div class="form-group">
    
      <select class="form-control" id="EstActFil" name="EstActFil" ng-model="vm.tmodal_data.EstActFil">
        <option ng-repeat="dato in vm.ttipofiltrosEstAct" value="{{dato.nombre}}">{{dato.nombre}}</option>                         
      </select>     
     </div>
     </div>
     </div>   
    <br ng-show="vm.tmodal_data.tipo_filtro_actividad==1 || vm.tmodal_data.tipo_filtro_actividad==2">
     <br ng-show="vm.tmodal_data.tipo_filtro_actividad==1 || vm.tmodal_data.tipo_filtro_actividad==2">
    <br>
    <div style="margin-left:15px; ">
     <button class="btn btn-info" type="submit" ng-disabled="frmfiltrAct.$invalid">APLICAR</button>
      <a class="btn btn-danger" data-dismiss="modal">REGRESAR</a>
      </div>
</form>
   </div>
    </div>
</div>
</div>
</div>
                <!--modal container section end -->

                <!--modal container section end -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_asignar_actividades" class="modal fade">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                        <h4 class="modal-title">Activadades:</h4>
                      </div>
                      <div class="modal-body">
                    
                        <form class="form-validate" id="form_lock" name="form_lock" ng-submit="SubmitAsignarActivadades($event)">
                           <div class="col-12 col-sm-6">
                           <div class="form">                          
                           <div class="form-group">
                           <label class="font-weight-bold nexa-dark" style="color:black;">CIF</label>
                           <input type="text" class="form-control" ng-model="vm.fdatos.NumCifCli" maxlength="9" readonly placeholder="* Número del CIF del Cliente Comercial"/>     
                           </div>
                           </div>
                           </div>

                           <div class="col-12 col-sm-6">
                           <div class="form">                          
                           <div class="form-group">
                           <label class="font-weight-bold nexa-dark" style="color:black;">Razon Social</label>
                            <input type="text" class="form-control" ng-model="vm.fdatos.RazSocCli" placeholder="* Razon Social del Cliente" maxlength="50" readonly/>    
                           </div>
                           </div>
                           </div>

                           <div class="col-12 col-sm-6">
                           <div class="form">                          
                           <div class="form-group">
                           <label class="font-weight-bold nexa-dark" style="color:black;">Sección</label>
                            <select class="form-control" name="CodSec" ng-model="vm.fdatos.CodSec" ng-change="vm.filtrar_actividad(1,vm.fdatos.CodSec)">
                              <option ng-repeat="dato in vm.tSeccion" value="{{dato.DesSec}}">{{dato.DesSec}}</option>                          
                            </select>
                           </div>
                           </div>
                           </div>

                           <div class="col-12 col-sm-6">
                           <div class="form">                          
                           <div class="form-group">
                           <label class="font-weight-bold nexa-dark" style="color:black;">Grupo</label>                           
                           <select class="form-control" name="CodGrup" ng-model="vm.fdatos.CodGrup" ng-change="vm.filtrar_actividad(2,vm.fdatos.CodGrup)">
                              <option ng-repeat="dato in vm.tGrupos" value="{{dato.DesGru}}">{{dato.DesGru}}</option>                          
                            </select>
                           </div>
                           </div>
                           </div>

                            <div class="col-12 col-sm-6">
                           <div class="form">                          
                           <div class="form-group">
                           <label class="font-weight-bold nexa-dark" style="color:black;">Epígrafe</label>
                            <select class="form-control" name="CodEpi" ng-model="vm.fdatos.CodEpi" ng-change="vm.filtrar_actividad(3,vm.fdatos.CodEpi)">
                              <option ng-repeat="dato in vm.tEpigrafe" value="{{dato.DesEpi}}">{{dato.DesEpi}}</option>                          
                            </select>
                           </div>
                           </div>
                           </div>

                           <div class="col-12 col-sm-6">
                           <div class="form">                          
                           <div class="form-group">
                           <label class="font-weight-bold nexa-dark" style="color:black;">Fecha de Inicio</label>
                            <input type="text" class="form-control" ng-model="vm.fdatos.FecIniAct" name="FecIniAct" id="FecIniAct" ng-disabled="vm.Habilita_Fecha==false" placeholder="* Fecha Asignación de la Actividad"/>
                           </div>
                           </div>
                           </div>
                           <input type="hidden" class="form-control" ng-model="vm.fdatos.CodActEco" maxlength="9" readonly placeholder="* Código de la Actividad Economica"/> 
                        <div align="right"> 
                          <button class="btn btn-info" type="submit" ng-disabled="vm.fdatos.CodSec==undefined || vm.fdatos.CodGrup==undefined || vm.fdatos.CodEpi==undefined">ASIGNAR</button>
                          <button class="btn btn-danger" data-dismiss="modal">REGRESAR</button>
                        </div>

                         
                        </form>
                      </div>
                    </div>
                  </div>
                </div>


<!-- modal container section end -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_motivo_bloqueo_actividades" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Bloqueo de Actividades</h4>
          </div>
          <div class="modal-body">
            <div class="panel"> 
                 <input type="hidden" class="form-control" ng-model="vm.tmodal_data.CodCli" required readonly />
                  <input type="hidden" class="form-control" ng-model="vm.tmodal_data.CodTActCli" required readonly />
      <form class="form-validate" id="form_lock" name="form_lock" ng-submit="submitFormlockActividades($event)">                 
     <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">CIF</label>
     <input type="text" class="form-control" ng-model="vm.tmodal_data.NumCif" required readonly/>     
     </div>
     </div>
     </div>

    <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Fecha de Bloqueo</label>
     <input type="text" class="form-control" ng-model="vm.tmodal_data.FecBloAct" required readonly/>    
     </div>
     </div>
     </div>

     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Razon Social del Cliente</label>
     <input type="text" class="form-control" ng-model="vm.tmodal_data.RazSoc" required readonly />     
     </div>
     </div>

      <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Sección</label>
     <input type="text" class="form-control" ng-model="vm.tmodal_data.DesSec" required readonly/>     
     </div>
     </div>
     </div>

    <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Grupo</label>
     <input type="text" class="form-control" ng-model="vm.tmodal_data.DesGru" required readonly/>    
     </div>
     </div>
     </div>

     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Epígrafe</label>
     <input type="text" class="form-control" ng-model="vm.tmodal_data.DesEpi" required readonly />     
     </div>
     </div>

      <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Motivo del Bloqueo</label>
     
      <select class="form-control" id="MotBloq" name="MotBloq" required ng-model="vm.tmodal_data.MotBloq">
          <option ng-repeat="dato in vm.tMotivosBloqueosActividades" value="{{dato.CodMotBloAct}}">{{dato.DesMotBloAct}}</option>
        </select>


     </div>
     </div>

     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Observación</label>
     <textarea type="text" class="form-control" ng-model="vm.tmodal_data.ObsBloAct" rows="5" maxlength="100"/></textarea>
     </div>
     </div>
    
    <br>
     <button class="btn btn-info" type="submit" ng-disabled="form_lock.$invalid">Bloquear</button>
      <a class="btn btn-danger" data-dismiss="modal">Regresar</a>
</form>
   </div>
    </div>
</div>
</div>
</div>
<!--modal container section end -->


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
<div id="cargando_I" class="loader loader-default"  data-text="Cargando Datos del Cliente, Por Favor Espere..."></div>
<div id="crear_clientes" class="loader loader-default"  data-text="Creando o Actualizando Cliente, Por Favor Espere..."></div>
<div id="comprobando_disponibilidad" class="loader loader-default"  data-text="Comprobando Disponibilidad, Por Favor Espere..."></div>
<div id="asignando_actividad" class="loader loader-default"  data-text="Asignando Actividad, Por Favor Espere..."></div>
<div id="cargando_actividades" class="loader loader-default"  data-text="Cargando Actividades, Por Favor Espere..."></div>
</html>