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
 <div ng-controller="Controlador_Cups as vm">
 <!--main content start-->
    <section id="main-content">
      <!--wrapper start-->
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header" ng-show="vm.fdatos_cups.CodCup==undefined"></i>Registrar CUPs</h3>
            <h3 class="page-header" ng-show="vm.fdatos_cups.CodCup>0&&vm.validate_info!=undefined"></i>Consultando CUPs</h3>
            <h3 class="page-header" ng-show="vm.fdatos_cups.CodCup>0&&vm.validate_info==undefined"></i>Modificando CUPs</h3>

            <!--<ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>              
              <li><i class="fa fa-cube"></i>Registrar Cups</li>
            </ol>-->
          </div>
        </div>
        <!-- page start-->
        <div class="row">
          <div class="col-lg-12">
            <!--panel start-->
            <section class="panel">
 <div class="panel-body"> 



 <form id="register_form" name="register_form" ng-submit="submitFormCups($event)"> 
     <div class='row'>              
      
      <div class="col-12 col-sm-12" ng-click="vm.containerClicked()">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Cliente {{vm.fdatos_cups.CodCli}}<b style="color:red;">(*)</b></label>
        <input type="text" class="form-control" ng-model="vm.Cups_Cif" maxlength="9" placeholder="* Razón Social / Número CIF / Email / Teléfono" ng-keyup='vm.fetchClientes()' ng-click='vm.searchboxClicked($event)' ng-disabled="vm.validate_info!=undefined || vm.validate_info==undefined&&vm.fdatos_cups.CodCup>0">
         <ul id='searchResult'>
          <li ng-click='vm.setValue($index,$event,result)' ng-repeat="result in vm.searchResult" >
           <div ng-show="result.NumCifCli!=''">{{ result.CodCli }}, {{ result.NumCifCli }} - </div>{{ result.RazSocCli }} 
          </li>
        </ul>
        <input type="hidden" ng-model="vm.fdatos_cups.CodCli" placeholder="CodCli" readonly />

        <label class="font-weight-bold nexa-dark" style="color:black;" ng-show="vm.fdatos_cups.CodCup>0">Cambio de Titular <i class="fa fa-refresh" title="Cambiar de Cliente" ng-disabled="vm.validate_info!=undefined || vm.fdatos_cups.CodCli==undefined" ng-click="vm.CambiarTitularModal()"></i></label>
       </div>
       </div>
      </div>
      

      <div class="col-12 col-sm-12">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Dirección de Suministro <b style="color:red;">(*)</b> <i class="fa fa-plus-square" title="Agregar Dirección Suministros" ng-click="vm.agregarnuevadireccion(false)" ng-show="vm.fdatos_cups.AgregarNueva==true" ng-disabled="vm.validate_info!=undefined"></i> <i class="fa fa-close" title="Quitar Dirección Suministros" ng-click="vm.agregarnuevadireccion(true)" ng-show="vm.fdatos_cups.AgregarNueva==false"></i></label>
        <select class="form-control" id="CodPunSum" name="CodPunSum" ng-model="vm.fdatos_cups.CodPunSum" ng-disabled="vm.validate_info!=undefined || vm.fdatos_cups.CodCli==undefined|| vm.fdatos_cups.AgregarNueva==false">
        <option ng-repeat="dato in vm.T_PuntoSuministros" value="{{dato.CodPunSum}}">{{dato.DesTipVia}} {{dato.NomViaPunSum}} {{dato.NumViaPunSum}} {{dato.BloPunSum}} {{dato.EscPunSum}} {{dato.PlaPunSum}} {{dato.PuePunSum}}</option>                          
        </select>
       </div>
       </div>
      </div>

    <div ng-show="vm.T_PuntoSuministros.length==0 || vm.T_PuntoSuministrosVistaNuevaDireccion==true">
      <div class="col-12 col-sm-4">
        <div class="form">                          
          <div class="form-group">
            <label class="font-weight-bold nexa-dark" style="color:black;">Nuevo</label>
            <input type="radio" class="form-control" name="punto_suministro"  ng-model="vm.fdatos_cups.TipRegDir" value="0" ng-click="vm.punto_suministro(1,vm.fdatos_cups.TipRegDir)" ng-disabled="vm.validate_info!=undefined || vm.fdatos_cups.CodCli==undefined"/> 
          </div>
        </div>
      </div>
      
      <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Misma Dirección Social</label>
       <input type="radio" class="form-control" name="punto_suministro" ng-model="vm.fdatos_cups.TipRegDir" value="1" ng-click="vm.punto_suministro(2,vm.fdatos_cups.TipRegDir)" ng-disabled="vm.validate_info!=undefined || vm.fdatos_cups.CodCli==undefined"/>       
       </div>
       </div>
       </div> 

      <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Misma Dirección Fiscal</label>
       <input type="radio" class="form-control" name="punto_suministro" ng-model="vm.fdatos_cups.TipRegDir" value="2" ng-click="vm.punto_suministro(3,vm.fdatos_cups.TipRegDir)" ng-disabled="vm.validate_info!=undefined || vm.fdatos_cups.CodCli==undefined"/>
       </div>
       </div>
       </div> 

       <div style="margin-top: 8px;">
       <div align="center"><label class="font-weight-bold nexa-dark" style="color:#6d6e71;;"><b>DIRECCIÓN</b></label></div></div>
      
      <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Tipo de Via <b style="color:red;">(*)</b></label>
       <select class="form-control" id="CodTipVia" placeholder="* Tipo de Via" ng-model="vm.fdatos_cups.CodTipVia" ng-disabled="vm.validate_info!=undefined || vm.fdatos_cups.TipRegDir==undefined || vm.fdatos_cups.CodCli==undefined" required>
         <option ng-repeat="dato in vm.tTiposVias" value="{{dato.CodTipVia}}">{{dato.DesTipVia}} - {{dato.IniTipVia}}</option>                        
        </select>
       </div>
       </div>
       </div>

      <div class="col-12 col-sm-5">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Nombre de la Via <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fdatos_cups.NomViaPunSum"  placeholder="* Nombre de la Via del Dirección de Suministro" ng-disabled=" vm.fdatos_cups.TipRegDir==undefined || vm.validate_info!=undefined " required/>       
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Número <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fdatos_cups.NumViaPunSum"  min="1" placeholder="* Numero del Dirección de Suministro" maxlength="2" ng-change="vm.validarsinuermo(vm.fdatos_cups.NumViaPunSum,1)" ng-disabled=" vm.fdatos_cups.TipRegDir==undefined|| vm.validate_info!=undefined" required/>       
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Bloque</label>
       <input type="text" class="form-control" ng-model="vm.fdatos_cups.BloPunSum"  placeholder="Bloque del Dirección de Suministro" maxlength="3" ng-disabled=" vm.fdatos_cups.TipRegDir==undefined|| vm.validate_info!=undefined"/>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Escalera</label>
       <input type="text" class="form-control" ng-model="vm.fdatos_cups.EscPunSum"  placeholder="Escalera del Dirección de Suministro" maxlength="2" ng-disabled=" vm.fdatos_cups.TipRegDir==undefined|| vm.validate_info!=undefined"/>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Planta</label>
       <input type="text" class="form-control" ng-model="vm.fdatos_cups.PlaPunSum"  placeholder="Planta del Dirección de Suministro" maxlength="3" ng-disabled=" vm.fdatos_cups.TipRegDir==undefined|| vm.validate_info!=undefined"/>
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Puerta</label>
       <input type="text" class="form-control" ng-model="vm.fdatos_cups.PuePunSum"  placeholder="Puerta del Dirección de Suministro" maxlength="4" ng-disabled=" vm.fdatos_cups.TipRegDir==undefined|| vm.validate_info!=undefined"/>
       </div>
       </div>
       </div>
      
       <div class="col-12 col-sm-4" ng-click="vm.containerClicked()">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Código Postal</label>
       <input type="text" class="form-control" ng-click='vm.searchboxClicked($event)' ng-model="vm.fdatos_cups.CPLocSoc" placeholder="Zona Postal" ng-disabled=" vm.fdatos_cups.TipRegDir==undefined|| vm.validate_info!=undefined" ng-keyup='vm.LocalidadCodigoPostal(1)'/>
        <ul id='searchResult'>
          <li ng-click='vm.setValueCPLoc($index,$event,result,1)' ng-repeat="result in vm.searchResultCPLoc" >
          {{ result.DesPro }}  / {{ result.DesLoc }} / {{ result.CPLoc }} 
          </li>
        </ul>

       </div>
       </div>
       </div>  

        <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Provincia <b style="color:red;">(*)</b></label>
        <select class="form-control" ng-model="vm.fdatos_cups.CodProPunSum" ng-change="vm.BuscarLocalidadesPunSun(vm.fdatos_cups.CodProPunSum,2)" ng-disabled=" vm.fdatos_cups.TipRegDir==undefined|| vm.validate_info!=undefined" required>
        <option ng-repeat="dato in vm.tProvidencias" value="{{dato.CodPro}}">{{dato.DesPro}}</option>                          
        </select>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Localidad <b style="color:red;">(*)</b></label>
       <select class="form-control" id="CodLocPunSum" ng-model="vm.fdatos_cups.CodLocPunSum" ng-disabled=" vm.fdatos_cups.TipRegDir==undefined || vm.fdatos_cups.CodProPunSum==undefined|| vm.validate_info!=undefined" required>
        <option ng-repeat="dato in vm.TLocalidadesfiltradaPunSum" value="{{dato.CodLoc}}">{{dato.DesLoc}}</option>                         
        </select>
       </div>
       </div>
       </div>
        
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Comentarios</label>
       </div>
       </div>
       <div class="form">                          
       <div class="form-group">
        <textarea class="form-control" style="display: inline-block;"  id="ObsPunSum" type="text" minlength="1" maxlength="200" rows="5"  ng-model="vm.fdatos_cups.ObsPunSum" ng-disabled=" vm.fdatos_cups.TipRegDir==undefined|| vm.validate_info!=undefined"></textarea>
       </div>
       </div>      


    </div>


      <div class="col-12 col-sm-2">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">CUPs <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" name="CUPSES" id="CUPSES" ng-model="vm.fdatos_cups.cups"  placeholder="* ES" readonly="readonly" maxlength="2" ng-disabled=" vm.validate_info==undefined || vm.validate_info!=undefined"/>
       </div>
       </div>
       </div>    

      <div class="col-12 col-sm-10">
       <div class="form">                          
       <div class="form-group">  
       <label class="font-weight-bold nexa-dark" style="color:white;">.</label>     
       <input type="text" class="form-control" name="CUPSNUM" id="CUPSNUM" ng-model="vm.fdatos_cups.cups1" onkeyup="this.value=this.value.toUpperCase();" maxlength="18" ng-disabled="vm.validate_info!=undefined"/>
       </div>
       </div>
       </div>  
        
        <!--div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
       <input type="text" class="form-control" name="CUPSNUM2" id="CUPSNUM2" ng-model="vm.fdatos_cups.cups2"  maxlength="2" ng-disabled=" vm.validate_info!=undefined"/>
       </div>
       </div>
       </div-->      
      <div style="margin-top: 8px;">
       <div align="left"><label class="font-weight-bold nexa-dark" style="color:black;"><b>  TIPO SUMINISTRO</b></label></div></div>
      
      <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Eléctrico</label>
       <input type="radio" ng-model="vm.fdatos_cups.TipServ" ng-disabled=" vm.validate_info!=undefined" value="1" ng-click="vm.por_servicios(vm.fdatos_cups.TipServ)"/>
       <label class="font-weight-bold nexa-dark" style="color:black;">Gas</label>
       <input type="radio" ng-model="vm.fdatos_cups.TipServ" ng-disabled=" vm.validate_info!=undefined" value="2" ng-click="vm.por_servicios(vm.fdatos_cups.TipServ)"/>
       </div>
       </div>
       </div>

     <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Distribuidora</label>
        <select class="form-control" id="CodDis" name="CodDis"  ng-model="vm.fdatos_cups.CodDis" ng-disabled="vm.fdatos_cups.TipServ==0||vm.validate_info!=undefined">
        <option ng-repeat="dato in vm.T_Distribuidoras" value="{{dato.CodDist}}">{{dato.RazSocDis}}</option>                          
        </select>
       </div>
       </div>
       </div>
<!-- || vm.validate_info!=undefined||vm.sin_data!=undefined
|| vm.validate_info!=undefined||vm.sin_data!=undefined-->
      <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Tarifa <b style="color:red;">(*)</b></label>
        <select class="form-control" id="CodTar" name="CodTar"  ng-model="vm.fdatos_cups.CodTar" ng-disabled="vm.fdatos_cups.TipServ==0||vm.validate_info!=undefined" ng-change="vm.PeriodosTarifas(vm.fdatos_cups.TipServ,vm.fdatos_cups.CodTar)">
        <option ng-repeat="dato in vm.T_Tarifas" value="{{dato.CodTar}}">{{dato.NomTar}}</option>                          
        </select>
       </div>
       </div>
       </div>




<div ng-show="vm.fdatos_cups.TipServ==1">

 <div style="margin-top: 8px; margin-left: 15px; margin-bottom: -20px;" ng-show="vm.totalPot>0">
       <div align="left"><label class="font-weight-bold nexa-dark" style="color:black;"> Potencia Contratada (Kw) <b style="color:red;">(*)</b></label></div></div>
 


    <div ng-show="vm.totalPot==1">
        
      <div class="col-12 col-sm-6" id="PotConP1">
       <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
        <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotConP1"  ng-disabled=" vm.validate_info!=undefined" placeholder="P1" ng-change="vm.validar_fecha_inputs(4,vm.fdatos_cups.PotConP1)"/>
       </div>
       </div>
       </div> 

      <div class="col-12 col-sm-6" id="PotMaxBie">
       <div class="form">                          
       <div class="form-group">         
        <label class="font-weight-bold nexa-dark" style="color:black;">Potencia Máxima BIE </label>
        <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotMaxBie" placeholder="Potencia Máxima BIE"  ng-disabled=" vm.validate_info!=undefined" ng-change="vm.validar_fecha_inputs(10,vm.fdatos_cups.PotMaxBie)"/>
       </div>
       </div>
       </div>

    </div>

     <div ng-show="vm.totalPot==2">
        
      <div class="col-12 col-sm-3" id="PotConP1">
       <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
        <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotConP1"  ng-disabled=" vm.validate_info!=undefined" placeholder="P1" ng-change="vm.validar_fecha_inputs(4,vm.fdatos_cups.PotConP1)"/>
       </div>
       </div>
       </div> 

      <div class="col-12 col-sm-3" id="PotConP2">
      <div class="form">                          
        <div class="form-group">
          <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
          <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotConP2"  ng-disabled=" vm.validate_info!=undefined" placeholder="P2" ng-change="vm.validar_fecha_inputs(5,vm.fdatos_cups.PotConP2)"/>
        </div>
      </div>
      </div>

      <div class="col-12 col-sm-6" id="PotMaxBie">
       <div class="form">                          
       <div class="form-group">         
        <label class="font-weight-bold nexa-dark" style="color:black;">Potencia Máxima BIE </label>
        <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotMaxBie" placeholder="Potencia Máxima BIE"  ng-disabled=" vm.validate_info!=undefined" ng-change="vm.validar_fecha_inputs(10,vm.fdatos_cups.PotMaxBie)"/>
       </div>
       </div>
       </div>
       
    </div>


     <div ng-show="vm.totalPot==3">
        
      <div class="col-12 col-sm-3" id="PotConP1">
       <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
        <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotConP1"  ng-disabled=" vm.validate_info!=undefined" placeholder="P1" ng-change="vm.validar_fecha_inputs(4,vm.fdatos_cups.PotConP1)"/>
       </div>
       </div>
       </div> 

      <div class="col-12 col-sm-3" id="PotConP2">
      <div class="form">                          
        <div class="form-group">
          <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
          <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotConP2"  ng-disabled=" vm.validate_info!=undefined" placeholder="P2" ng-change="vm.validar_fecha_inputs(5,vm.fdatos_cups.PotConP2)"/>
        </div>
      </div>
      </div>

       <div class="col-12 col-sm-3" id="PotConP3">
      <div class="form">                          
        <div class="form-group">
          <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
          <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotConP3"  ng-disabled=" vm.validate_info!=undefined" placeholder="P3" ng-change="vm.validar_fecha_inputs(6,vm.fdatos_cups.PotConP3)"/>
        </div>
      </div>
      </div>

      <div class="col-12 col-sm-3" id="PotMaxBie">
       <div class="form">                          
       <div class="form-group">         
        <label class="font-weight-bold nexa-dark" style="color:black;">Potencia Máxima BIE </label>
        <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotMaxBie" placeholder="Potencia Máxima BIE"  ng-disabled=" vm.validate_info!=undefined" ng-change="vm.validar_fecha_inputs(10,vm.fdatos_cups.PotMaxBie)"/>
       </div>
       </div>
       </div>
       
    </div>

   <div ng-show="vm.totalPot==4">
        
      <div class="col-12 col-sm-2" id="PotConP1">
       <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
        <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotConP1"  ng-disabled=" vm.validate_info!=undefined" placeholder="P1" ng-change="vm.validar_fecha_inputs(4,vm.fdatos_cups.PotConP1)"/>
       </div>
       </div>
       </div> 

      <div class="col-12 col-sm-2" id="PotConP2">
      <div class="form">                          
        <div class="form-group">
          <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
          <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotConP2"  ng-disabled=" vm.validate_info!=undefined" placeholder="P2" ng-change="vm.validar_fecha_inputs(5,vm.fdatos_cups.PotConP2)"/>
        </div>
      </div>
      </div>

       <div class="col-12 col-sm-2" id="PotConP3">
      <div class="form">                          
        <div class="form-group">
          <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
          <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotConP3"  ng-disabled=" vm.validate_info!=undefined" placeholder="P3" ng-change="vm.validar_fecha_inputs(6,vm.fdatos_cups.PotConP3)"/>
        </div>
      </div>
      </div>

      <div class="col-12 col-sm-2" id="PotConP4">
      <div class="form">                          
        <div class="form-group">
          <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
          <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotConP4"  ng-disabled=" vm.validate_info!=undefined" placeholder="P4" ng-change="vm.validar_fecha_inputs(7,vm.fdatos_cups.PotConP4)"/>
        </div>
      </div>
      </div>

      <div class="col-12 col-sm-4" id="PotMaxBie">
       <div class="form">                          
       <div class="form-group">         
        <label class="font-weight-bold nexa-dark" style="color:black;">Potencia Máxima BIE </label>
        <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotMaxBie" placeholder="Potencia Máxima BIE"  ng-disabled=" vm.validate_info!=undefined" ng-change="vm.validar_fecha_inputs(10,vm.fdatos_cups.PotMaxBie)"/>
       </div>
       </div>
       </div>
       
    </div>



    <div ng-show="vm.totalPot==5">
        
      <div class="col-12 col-sm-2" id="PotConP1">
       <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
        <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotConP1"  ng-disabled=" vm.validate_info!=undefined" placeholder="P1" ng-change="vm.validar_fecha_inputs(4,vm.fdatos_cups.PotConP1)"/>
       </div>
       </div>
       </div> 

      <div class="col-12 col-sm-2" id="PotConP2">
      <div class="form">                          
        <div class="form-group">
          <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
          <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotConP2"  ng-disabled=" vm.validate_info!=undefined" placeholder="P2" ng-change="vm.validar_fecha_inputs(5,vm.fdatos_cups.PotConP2)"/>
        </div>
      </div>
      </div>
      
       <div class="col-12 col-sm-2" id="PotConP3">
      <div class="form">                          
        <div class="form-group">
          <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
          <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotConP3"  ng-disabled=" vm.validate_info!=undefined" placeholder="P3" ng-change="vm.validar_fecha_inputs(6,vm.fdatos_cups.PotConP3)"/>
        </div>
      </div>
      </div>

      <div class="col-12 col-sm-2" id="PotConP4">
      <div class="form">                          
        <div class="form-group">
          <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
          <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotConP4"  ng-disabled=" vm.validate_info!=undefined" placeholder="P4" ng-change="vm.validar_fecha_inputs(7,vm.fdatos_cups.PotConP4)"/>
        </div>
      </div>
      </div>

       <div class="col-12 col-sm-2" id="PotConP5">
      <div class="form">                          
        <div class="form-group">
          <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
          <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotConP5"  ng-disabled=" vm.validate_info!=undefined" placeholder="P5" ng-change="vm.validar_fecha_inputs(8,vm.fdatos_cups.PotConP5)"/>
        </div>
      </div>
      </div>

      <div class="col-12 col-sm-2" id="PotMaxBie">
       <div class="form">                          
       <div class="form-group">         
        <label class="font-weight-bold nexa-dark" style="color:black;">Potencia Máxima BIE </label>
        <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotMaxBie" placeholder="Potencia Máxima BIE"  ng-disabled=" vm.validate_info!=undefined" ng-change="vm.validar_fecha_inputs(10,vm.fdatos_cups.PotMaxBie)"/>
       </div>
       </div>
       </div>
       
    </div>



    <div ng-show="vm.totalPot==6">
        
      <div class="col-12 col-sm-1" id="PotConP1">
       <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
        <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotConP1"  ng-disabled=" vm.validate_info!=undefined" placeholder="P1" ng-change="vm.validar_fecha_inputs(4,vm.fdatos_cups.PotConP1)"/>
       </div>
       </div>
       </div> 

      <div class="col-12 col-sm-1" id="PotConP2">
      <div class="form">                          
        <div class="form-group">
          <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
          <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotConP2"  ng-disabled=" vm.validate_info!=undefined" placeholder="P2" ng-change="vm.validar_fecha_inputs(5,vm.fdatos_cups.PotConP2)"/>
        </div>
      </div>
      </div>
      
       <div class="col-12 col-sm-1" id="PotConP3">
      <div class="form">                          
        <div class="form-group">
          <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
          <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotConP3"  ng-disabled=" vm.validate_info!=undefined" placeholder="P2" ng-change="vm.validar_fecha_inputs(6,vm.fdatos_cups.PotConP3)"/>
        </div>
      </div>
      </div>

      <div class="col-12 col-sm-1" id="PotConP4">
      <div class="form">                          
        <div class="form-group">
          <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
          <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotConP4"  ng-disabled=" vm.validate_info!=undefined" placeholder="P4" ng-change="vm.validar_fecha_inputs(7,vm.fdatos_cups.PotConP4)"/>
        </div>
      </div>
      </div>

       <div class="col-12 col-sm-1" id="PotConP5">
      <div class="form">                          
        <div class="form-group">
          <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
          <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotConP5"  ng-disabled=" vm.validate_info!=undefined" placeholder="P5" ng-change="vm.validar_fecha_inputs(8,vm.fdatos_cups.PotConP5)"/>
        </div>
      </div>
      </div>

       <div class="col-12 col-sm-1" id="PotConP6">
      <div class="form">                          
        <div class="form-group">
          <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
          <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotConP6"  ng-disabled=" vm.validate_info!=undefined" placeholder="P6" ng-change="vm.validar_fecha_inputs(9,vm.fdatos_cups.PotConP6)"/>
        </div>
      </div>
      </div>

      <div class="col-12 col-sm-6" id="PotMaxBie">
       <div class="form">                          
       <div class="form-group">         
        <label class="font-weight-bold nexa-dark" style="color:black;">Potencia Máxima BIE </label>
        <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotMaxBie" placeholder="Potencia Máxima BIE"  ng-disabled=" vm.validate_info!=undefined" ng-change="vm.validar_fecha_inputs(10,vm.fdatos_cups.PotMaxBie)"/>
       </div>
       </div>
       </div>
       
    </div>
    

       
  </div> 
<div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">         
        <label class="font-weight-bold nexa-dark" style="color:black;">Fecha de Alta</label>
        <input type="text" class="form-control datepicker" ng-model="vm.fdatos_cups.FecAltCup" name="FecAltCup" id="FecAltCup"  placeholder="DD/MM/YYYY" ng-disabled=" vm.validate_info!=undefined" ng-change="vm.validar_fecha_inputs(1,vm.fdatos_cups.FecAltCup)"/>
       </div>
       </div>
       </div>

       <!--div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">         
        <label class="font-weight-bold nexa-dark" style="color:black;">Fecha Última Lectura </label>
        <input type="text" class="form-control datepicker2" ng-model="vm.fdatos_cups.FecUltLec"  name="FecUltLec" id="FecUltLec"  ng-disabled=" vm.validate_info!=undefined" ng-change="vm.validar_fecha_inputs(2,vm.fdatos_cups.FecUltLec)"/>
       </div>
       </div>
       </div-->

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">         
        <label class="font-weight-bold nexa-dark" style="color:black;">Consumo (Kw) <b style="color:red;">(*)</b></label>
        <input type="text" class="form-control" ng-model="vm.fdatos_cups.ConAnuCup"  ng-disabled=" vm.validate_info!=undefined" ng-change="vm.validar_fecha_inputs(3,vm.fdatos_cups.ConAnuCup)"/>
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">         
        <label class="font-weight-bold nexa-dark" style="color:black;">Derechos de Acceso (Kw) </label>
        <input type="text" class="form-control" ng-model="vm.fdatos_cups.DerAccKW"  ng-disabled=" vm.validate_info!=undefined" ng-change="vm.validar_fecha_inputs(23,vm.fdatos_cups.DerAccKW)"/>
       </div>
       </div>
       </div>



  <input type="hidden" class="form-control" ng-model="vm.fdatos_cups.CodCup" readonly />      
         <div class="form-group" >
          <div class="col-12 col-sm-6">
            <button class="btn btn-info" type="submit" ng-show="vm.fdatos_cups.CodCup==undefined||vm.fdatos_cups.CodCup==null||vm.fdatos_cups.CodCup==''" >Crear</button>
            <button class="btn btn-success" type="submit" ng-show="vm.fdatos_cups.CodCup>0 && vm.validate_info==undefined">Actualizar</button>            
            <button class="btn btn-primary" type="button" style="margin-top: 10px;" ng-click="vm.regresar_cups()">Volver</button>
          </div>
        </div>
        
         </div><!--FINAL ROW -->
        </form>


 </div>




          </section>
        <!--/section-->
        </div>
        </div>
        <!-- page end-->
      </section>
      <!--wrappen end-->
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
          Diseñado Por <a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2019 - 2021</a>
        </div>
    </div>
  </section>

<!--modal modal_cif_comercializadora section START -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modalCambiarTitularCUPs" class="modal fade">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                        <h4 class="modal-title">Cambiar CUPs de Cliente</h4>
                      </div>
                      <div class="modal-body">
                        <form class="form-horizontal" role="form" id="CambiarTitular_form" name="CambiarTitular_form" ng-submit="CambiarTitular($event)"> 
                          <div class="form-group" ng-click='vm.containerClickedCUPs()'>
                            <label for="inputEmail1" class="col-lg-2 control-label">Número de CIF:</label>
                            <div class="col-lg-10">
                              <input type="text" class="form-control" name="CambiarTitularCUPs" id="CambiarTitularCUPs" ng-model="vm.NumCifCliCambio" placeholder="* Introduzca CIF" required onkeyup="this.value=this.value.toUpperCase();" ng-keyup='vm.fetchClientesCambioTitular()' ng-click='vm.searchboxClicked($event)'/>
                              <ul id='searchResult' style="height: 250px; overflow-y: auto;">
                                <li ng-click='vm.setValueCambio($index,$event,result)' ng-repeat="result in vm.searchResultCUPs" >
                                 <div ng-show="result.NumCifCli!=''">NumCli: {{ result.CodCli }}, {{ result.NumCifCli }} - </div>{{ result.RazSocCli }} 
                                </li>
                            </ul>   
                            </div>
                          </div>
                          <input type="hidden" name="" ng-model="vm.CambioTitular.CodCli" readonly="readonly">
                          <button class="btn btn-info" type="submit" ng-disabled="CambiarTitular_form.$invalid" style="color:black;"> Cambiar Titular</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
<!--modal modal_cif_comercializadora section END -->
 <script>
      $(function(){
        jQuery(function($) 
        {      
          //jquery tabs
          $( "#tabs_clientes" ).tabs(); 
         /*FecAltCup
*/
      });
        $('.datepicker').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});  
        $('#FecAltCup').on('changeDate', function() 
        {
          var FecAltCup=document.getElementById("FecAltCup").value;
          console.log("FecAltCup: "+FecAltCup);
        });
        $('.datepicker2').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});  
        $('#FecUltLec').on('changeDate', function() 
        {
          var FecUltLec=document.getElementById("FecUltLec").value;
          console.log("FecUltLec: "+FecUltLec);
        });
       
        function mayus(e)
        {
          var tecla=e.value;
          var tecla2=tecla.toUpperCase();
        }


      });
    </script>
</div>
</body>
<div id="cargandos_cups" class="loader loader-default"  data-text="Cargando Información del CUPs"></div>
<div id="List_Produc" class="loader loader-default"  data-text="Cargando listado de Productos"></div>

<div id="borrando" class="loader loader-default"  data-text="Eliminando Cliente"></div>
<div id="NumCifCom" class="loader loader-default"  data-text="Comprobando CIF"></div>

</html>
