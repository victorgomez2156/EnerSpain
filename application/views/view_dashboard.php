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
  width: 250px;
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
  <div ng-controller="Controlador_Dashbord as vm">
 <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <!--overview start-->

       <!--Dashboard start -->
        <div class="row" style="margin-top: 20px;">
          
          <div class="col-md-6 portlets">
            <!-- View Information -->
            <div class="panel panel-default">
              <div class="panel-body" ng-click='vm.containerClicked()'>
                <div id="t-0002" ><!--t-0002 start-->   
                  <div style="float:left;margin-left: 0px;padding: 10px;margin-top: 10px;margin-bottom: 2px;" class="removeForMobile"><!--DIV removeformobile start-->                    
                      <div class="t-0029"><!--t-0029 start--> 
                        <div class="t-0031" style="margin-top: -8px; "><!--t-0031 start-->
                          
                        <div class="btn-group">
                          <button data-toggle="dropdown" title="Generar Reportes" class="btn btn-default dropdown-toggle" type="button"><i class="fa fa-cloud-upload"></i><span class="caret"></span> </button>
                          <ul class="dropdown-menu">
                                  <li style="cursor: pointer;"><a title='Exportar PDF' target="_black"  href="reportes/Exportar_Documentos/"><i class="fa fa-file"></i> Exportar en PDF</a></li>
                                  <li style="cursor: pointer;"><a title='Exportar Excel' target="_black" href="reportes/Exportar_Documentos/"><i class="fa fa-file-excel-o"></i> Exportar en Excel</a></li>                         
                          </ul>
                        </div> <div id="xcontainer"></div>              
                      </div><!--t-0031 end--> 
                    </div><!--t-0029 end--> 
                  </div><!--DIV removeformobile end-->
                </div>
                 <div style="float: right; margin-left:-100px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
              <div class="t-0029">
                <form class="form-inline" role="form">
                  <div class="form-group">
                 <input type='text' ng-keyup='vm.fetchClientes()' ng-click='vm.searchboxClicked($event)' ng-model='vm.searchText' placeholder='Buscar Cliente...' class="form-control">
                 
                 <ul id='searchResult'>
                  <li ng-click='vm.setValue($index,$event,result)' ng-repeat="result in vm.searchResult" >
                   <div ng-show="result.NumCifCli!=''">{{ result.NumCifCli }} - </div>{{ result.RazSocCli }} 
                  </li>
                </ul>

                  </div><button class="btn btn-info" ng-click="vm.fetchClientes()" type="button"><i class="fa fa-search"></i></button>  
                </form>                    
            </div>
          </div><!--t-0002 end-->
          <br><br><br><br>
          <form role="form" name="formu">
      <div class="col-12 col-sm-12">       
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Clientes</label>
       <select class="form-control" id="CodCli" ng-class="{'has-error': formu.CodCli.$error.required && formu.CodCli.$dirty}" name="CodCli" required ng-model="vm.fdatos.CodCli" ng-change="vm.view_information()"> 
          <option ng-repeat="dato_act in vm.list_customers" value="{{dato_act.CodCli}}"><div ng-show="dato_act.NumCifCli!=''">{{dato_act.NumCifCli}} - </div>{{dato_act.RazSocCli}}</option>                          
        </select>       
       </div>
       </div>
       </div>       
      </form>

<div class="foreign-supplier-title clearfix" ng-click="vm.showDetails(1)">
    <h4 class="breadcrumb">     
      <span class="foreign-supplier-text" style="color:black;"> Datos Generales</span><div align="right" style="margin-top: -16px;"><span class="foreign-supplier-arrow" style="color:black;"><i ng-class="!vm.showDatosGenerales?'fa fa-angle-right':'fa fa-angle-down'" aria-hidden="true"></i></span></div>
    </h4>
</div>
<div ng-if="vm.showDatosGenerales">   
  <div ng-show="vm.response_customer.CodCli==undefined">      
    <div align="center"><label style="color:black;">No hay información registrada</label></div>
  </div>

  <div ng-show="vm.response_customer.CodCli>0">

   <form class="form-validate" id="form_datos_generales" name="form_datos_generales">                 
           <input type="hidden" class="form-control" ng-model="vm.response_customer.CodCli"/>          
      <div class="col-12 col-sm-8">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Razón Social / Apellidos, Nombre </label>
       <input type="text" class="form-control" id="RazSocCli" name="RazSocCli" placeholder="Razón Social / Apellidos, Nombre" ng-model="vm.response_customer.RazSocCli" readonly ng-click="vm.copyText(1)" /> 
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-4">
          <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Nº Documento </label>
             <input type="text"  class="form-control" placeholder="Nº Documento" ng-model="vm.response_customer.NumCifCli" id="NumCifCli" name="NumCifCli" readonly ng-click="vm.copyText(2)"/>
             </div>
             </div>
        </div>

        <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Dom. Social</label> <label ng-show="vm.response_customer.CodPro!=vm.response_customer.CodProFis" class="font-weight-bold nexa-dark" style="color:black;"> / Dom. Fiscal</label>
             <input type="text" class="form-control" placeholder="Domicilio Social" ng-model="vm.response_customer.DomSoc" id="DomSoc" name="DomSoc" readonly ng-click="vm.copyText(3)"/>     
             </div>
             </div>
          </div>

        <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Escalera / Planta / Puerta </label>
             <input type="text" class="form-control" ng-model="vm.response_customer.EscPlaPuerSoc" placeholder="Escalera / Planta / Puerta" id="EscPlaPuerSoc" name="EscPlaPuerSoc" readonly ng-click="vm.copyText(4)"/>  
             </div>
             </div>
          </div>
          <div class="col-12 col-sm-4">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Localidad </label>
             <input type="text" class="form-control" ng-model="vm.response_customer.DesSoc" placeholder="Localidad" readonly id="DesLocSoc" name="DesLocSoc" ng-click="vm.copyText(5)"/>     
             </div>
             </div>
          </div>
          <div class="col-12 col-sm-4">
            <div class="form">                          
             <div class="form-group">   
              <label class="font-weight-bold nexa-dark" style="color:black;">Provincia </label>          
             <input type="text" class="form-control" ng-model="vm.response_customer.ProSoc" placeholder="Provincia" readonly id="DesProSoc" name="DesProSoc" ng-click="vm.copyText(6)"/>     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-4">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">Código Postal </label>         
             <input type="text"  class="form-control" ng-model="vm.response_customer.LocSoc" placeholder="Código Postal" readonly id="LocSoc" name="LocSoc" ng-click="vm.copyText(7)"/>     
             </div>
             </div>
          </div>

          
      <div ng-show="vm.response_customer.CodPro!=vm.response_customer.CodProFis">
          
          <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Domicilio Fiscal </label>
             <input type="text" class="form-control" placeholder="Domicilio Fiscal" ng-model="vm.response_customer.DomFis" id="DomFis" name="DomFis" readonly ng-click="vm.copyText(8)"/>     
             </div>
             </div>
          </div>

        <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Escalera / Planta / Puerta </label>
             <input type="text" class="form-control" ng-model="vm.response_customer.EscPlaPuerFis" placeholder="Escalera / Planta / Puerta" id="EscPlaPuerFis" name="EscPlaPuerFis"  readonly ng-click="vm.copyText(9)"/>  
             </div>
             </div>
          </div>
          <div class="col-12 col-sm-5">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Localidad </label>
             <input type="text" class="form-control" ng-model="vm.response_customer.DesLocFis" placeholder="Localidad" readonly ng-click="vm.copyText(10)" id="DesLocFis" name="DesLocFis"/>     
             </div>
             </div>
          </div>
          <div class="col-12 col-sm-5">
            <div class="form">                          
             <div class="form-group">   
              <label class="font-weight-bold nexa-dark" style="color:black;">Provincia </label>          
             <input type="text" class="form-control" ng-model="vm.response_customer.DesProFis" placeholder="Provincia" readonly ng-click="vm.copyText(11)" id="DesProFis" name="DesProFis"/>     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">Código Postal </label>         
             <input type="text"  class="form-control" ng-model="vm.response_customer.CPLocFis" placeholder="Código Postal" readonly ng-click="vm.copyText(12)" id="CPLocFis" name="CPLocFis"/>     
             </div>
             </div>
          </div>
          </div><!-- FINAL DIV SHOW DOM SOC DIST DOM FIS-->
          

           <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">  
              <label class="font-weight-bold nexa-dark" style="color:black;">Teléfono </label>           
             <input type="email" class="form-control" id="TelFijCli" name="TelFijCli" ng-model="vm.response_customer.TelFijCli" readonly ng-click="vm.copyText(13)"/>     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">  
              <label class="font-weight-bold nexa-dark" style="color:black;"> Email</label>           
             <input type="email" class="form-control" id="EmaCli" name="EmaCli" ng-model="vm.response_customer.EmaCli" readonly ng-click="vm.copyText(14)"/>     
             </div>
             </div>
          </div> 
        </form>
      </div>
</div>

<div class="foreign-supplier-title clearfix" ng-click="vm.showDetails(2)">
    <h4 class="breadcrumb">     
      <span class="foreign-supplier-text" style="color:black;"> Contactos / Representante Legal</span> <div align="right" style="margin-top: -16px;"><span class="foreign-supplier-arrow" style="color:black;"><i ng-class="!vm.showContactosRepresentante?'fa fa-angle-right':'fa fa-angle-down'" aria-hidden="true"></i></span></div>
    </h4>
</div>
<div ng-if="vm.showContactosRepresentante">
  <div ng-show="vm.response_customer.Contactos.length==0">      
    <div align="center"><label style="color:black;">No hay información registrada</label></div>
  </div>

  <div class="row" ng-repeat="dato in vm.response_customer.Contactos">
   
   <div class="col-12 col-sm-3">
      <div class="form">                          
          <div class="form-group">
            <label class="font-weight-bold nexa-dark" style="color:black;">Nombre Completo </label>
            <input type="text" class="form-control" placeholder="Nombre Completo" ng-model="vm.response_customer.Contactos[$index].NomConCli" readonly id="NomConCli_{{$index}}" name="NomConCli_{{$index}}" ng-click="vm.copyTextArray(1,$index)"/>     
          </div>
        </div>
    </div>

    <div class="col-12 col-sm-3">
      <div class="form">                          
        <div class="form-group">
          <label class="font-weight-bold nexa-dark" style="color:black;">Nº Documento </label>
          <input type="text" class="form-control" ng-model="vm.response_customer.Contactos[$index].NIFConCli" placeholder="Nº Documento" readonly ng-click="vm.copyTextArray(2,$index)" id="NIFConCli_{{$index}}" name="NIFConCli_{{$index}}"/>  
        </div>
      </div>
    </div>
          
    <div class="col-12 col-sm-3">
      <div class="form">                          
        <div class="form-group">
          <label class="font-weight-bold nexa-dark" style="color:black;">Cargo </label>
          <input type="text" class="form-control" ng-model="vm.response_customer.Contactos[$index].CarConCli" placeholder="Cargo" readonly  ng-click="vm.copyTextArray(3,$index)" id="CarConCli_{{$index}}" name="CarConCli_{{$index}}"/>     
        </div>
      </div>
    </div>

    <div class="col-12 col-sm-3">
      <div class="form">                          
        <div class="form-group">   
          <label class="font-weight-bold nexa-dark" style="color:black;">Representación </label>
            <input type="text" class="form-control" ng-model="vm.response_customer.Contactos[$index].TipRepr" placeholder="Representación" readonly  ng-click="vm.copyTextArray(4,$index)" id="TipRepr_{{$index}}" name="TipRepr_{{$index}}"/>     
        </div>
      </div>
    </div>
  </div>
</div>              
               
              </div>
            </div>
          </div>

          <div class="col-md-6 portlets">
            <!-- View Information -->
            <div class="panel panel-default">
              
              <div class="panel-body" >
                <div class="foreign-supplier-title clearfix" ng-click="vm.showDetails(3)">
    <h4 class="breadcrumb">     
      <span class="foreign-supplier-text" style="color:black;"> Puntos de Suministros</span> <div align="right" style="margin-top: -16px;"><span class="foreign-supplier-arrow" style="color:black;"><i ng-class="!vm.showPuntosSuministros?'fa fa-angle-right':'fa fa-angle-down'" aria-hidden="true"></i></span></div>
    </h4>
</div>

<div ng-if="vm.showPuntosSuministros">
  <div ng-show="vm.response_customer.Puntos_Suministros.length==0">      
    <div align="center"><label style="color:black;">No hay información registrada</label></div>
  </div>

  <div ng-show="vm.response_customer.Puntos_Suministros.length>0">      
     <div class="col-12 col-sm-12">       
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Seleccione una Dirección de Suministro</label>
       <select class="form-control" id="DirPumSum" name="DirPumSum" required ng-model="vm.fdatos.DirPumSum" ng-change="vm.filter_DirPumSum(vm.fdatos.DirPumSum)"> 
        <option ng-repeat="dato_act in vm.response_customer.Puntos_Suministros" value="{{dato_act.CodPunSum}}">{{dato_act.DirPumSum}} {{dato_act.DesLoc}} {{dato_act.DesPro}} {{dato_act.CPLocSoc}} {{dato_act.EscPunSum}} {{dato_act.PlaPunSum}} {{dato_act.PuePunSum}}</option>
        </select>       
       </div>
       </div>
      </div>

       <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Dirección </label>
             <input type="text" class="form-control" placeholder="Domicilio Social" ng-model="vm.response_customer.DirDesPumSum" readonly id="DirDesPumSum" name="DirDesPumSum" ng-click="vm.copyText(15)"/>     
             </div>
             </div>
          </div>

        <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Escalera / Planta / Puerta </label>
             <input type="text" class="form-control" ng-model="vm.response_customer.EscPlaPuerPumSum" placeholder="Escalera / Planta / Puerta" readonly id="EscPlaPuerPumSum" name="EscPlaPuerPumSum" ng-click="vm.copyText(16)"/>  
             </div>
             </div>
          </div>
          <div class="col-12 col-sm-5">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Localidad </label>
             <input type="text" class="form-control" ng-model="vm.response_customer.DesLocPumSum" placeholder="Localidad" readonly id="DesLocPumSum" name="DesLocPumSum" ng-click="vm.copyText(17)"/>     
             </div>
             </div>
          </div>
          <div class="col-12 col-sm-5">
            <div class="form">                          
             <div class="form-group">   
              <label class="font-weight-bold nexa-dark" style="color:black;">Provincia </label>          
             <input type="text" class="form-control" ng-model="vm.response_customer.DesProPumSum" placeholder="Provincia" readonly id="DesProPumSum" name="DesProPumSum" ng-click="vm.copyText(18)"/>     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">Código Postal </label>         
             <input type="text"  class="form-control" ng-model="vm.response_customer.CPLocPumSum" placeholder="Código Postal" readonly id="CPLocPumSum" name="CPLocPumSum" ng-click="vm.copyText(19)"/>     
             </div>
             </div>
          </div>  


          <!--- PARA LOS CUPS ELECTRICOS START -->
          <div ng-show="vm.response_customer.CUPs_Electrico.length==0 || vm.response_customer.CUPs_Electrico==false">      
            <div align="center"><label style="color:black;">No hay CUPS Eléctricos registrados para el Cliente seleccionado</label></div>
          </div>
          <div class="row" ng-repeat="dato in vm.response_customer.CUPs_Electrico">
          <div class="col-12 col-sm-4">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:blue;">CUPS Eléctrico</label>
             <input type="text" class="form-control" ng-model="vm.response_customer.CUPs_Electrico[$index].CUPsEle" placeholder="CUP Eléctrico" readonly id="CUPsEle_{{$index}}" name="CUPsEle_{{$index}}" ng-click="vm.copyTextArray(5,$index)"/>     
             </div>
             </div>
          </div>
          
            <div class="col-12 col-sm-4">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">Distribuidora</label>         
             <input type="text"  class="form-control" ng-model="vm.response_customer.CUPs_Electrico[$index].RazSocDis" placeholder="Distribuidora" readonly id="RazSocDis_{{$index}}" name="RazSocDis_{{$index}}" ng-click="vm.copyTextArray(6,$index)"/>     
             </div>
             </div>
          </div> 

          <div class="col-12 col-sm-4">
            <div class="form">                          
             <div class="form-group">   
              <label class="font-weight-bold nexa-dark" style="color:black;">Tarifa </label>          
             <input type="text" class="form-control" ng-model="vm.response_customer.CUPs_Electrico[$index].NomTarEle" placeholder="Tarifa" readonly id="NomTarEle_{{$index}}" name="NomTarEle_{{$index}}" ng-click="vm.copyTextArray(7,$index)"/>     
             </div>
             </div>
          </div>        

           <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P1 </label>         
             <input type="text"  class="form-control" ng-model="vm.response_customer.CUPs_Electrico[$index].PotConP1" placeholder="P1" readonly id="P1_{{$index}}" name="P1_{{$index}}" ng-click="vm.copyTextArray(8,$index)"/>     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P2 </label>         
             <input type="text"  class="form-control" ng-model="vm.response_customer.CUPs_Electrico[$index].PotConP2" placeholder="P2" readonly id="P2_{{$index}}" name="P2_{{$index}}" ng-click="vm.copyTextArray(9,$index)"/>     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P3 </label>         
             <input type="text"  class="form-control" ng-model="vm.response_customer.CUPs_Electrico[$index].PotConP3" placeholder="P3" readonly id="P3_{{$index}}" name="P3_{{$index}}" ng-click="vm.copyTextArray(10,$index)"/>     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P4 </label>         
             <input type="text"  class="form-control" ng-model="vm.response_customer.CUPs_Electrico[$index].PotConP4" placeholder="P4" readonly id="P4_{{$index}}" name="P4_{{$index}}" ng-click="vm.copyTextArray(11,$index)"/>     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P5 </label>         
             <input type="text"  class="form-control" ng-model="vm.response_customer.CUPs_Electrico[$index].PotConP5" placeholder="P5" readonly id="P5_{{$index}}" name="P5_{{$index}}" ng-click="vm.copyTextArray(12,$index)"/>     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P6 </label>         
             <input type="text"  class="form-control" ng-model="vm.response_customer.CUPs_Electrico[$index].PotConP6" placeholder="P6" readonly id="P6_{{$index}}" name="P6_{{$index}}" ng-click="vm.copyTextArray(13,$index)"/>     
             </div>
             </div>
          </div>
          </div>
          <!--- PARA LOS CUPS ELECTRICOS END -->

          <!--- PARA LOS CUPS GAS START -->
          <div ng-show="vm.response_customer.CUPs_Gas.length==0 || vm.response_customer.CUPs_Gas==false">      
            <div align="center"><label style="color:black;">No hay CUPS Gas registrados para el Cliente seleccionado</label></div>
          </div>
          <div class="row" ng-repeat="dato in vm.response_customer.CUPs_Gas">
          <div class="col-12 col-sm-4">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:blue;">CUPS Gas </label>
             <input type="text" class="form-control" ng-model="vm.response_customer.CUPs_Gas[$index].CupsGas" placeholder="CUP Gas" readonly id="CUPs_Gas_{{$index}}" name="CUPs_Gas_{{$index}}" ng-click="vm.copyTextArray(14,$index)"/>     
             </div>
             </div>
          </div>
          
            <div class="col-12 col-sm-4">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">Distribuidora </label>         
             <input type="text"  class="form-control" ng-model="vm.response_customer.CUPs_Gas[$index].RazSocDis" placeholder="Distribuidora" readonly id="RazSocDisGas_{{$index}}" name="RazSocDisGas_{{$index}}" ng-click="vm.copyTextArray(15,$index)"/>     
             </div>
             </div>
          </div> 

          <div class="col-12 col-sm-4">
            <div class="form">                          
             <div class="form-group">   
              <label class="font-weight-bold nexa-dark" style="color:black;">Tarifa </label>          
             <input type="text" class="form-control" ng-model="vm.response_customer.CUPs_Gas[$index].NomTarGas" placeholder="Tarifa" readonly id="NomTarGas_{{$index}}" name="NomTarGas_{{$index}}" ng-click="vm.copyTextArray(16,$index)"/>     
             </div>
             </div>
          </div>       
          </div>
          <!--- PARA LOS CUPS GAS END -->
  </div> 
</div>

<div class="foreign-supplier-title clearfix" ng-click="vm.showDetails(4)">
    <h4 class="breadcrumb">     
      <span class="foreign-supplier-text" style="color:black;"> Datos Bancarios</span> <div align="right" style="margin-top: -16px;"><span class="foreign-supplier-arrow" style="color:black;"><i ng-class="!vm.showCuentasBancarias?'fa fa-angle-right':'fa fa-angle-down'" aria-hidden="true"></i></span></div>
    </h4>
</div>

<div ng-if="vm.showCuentasBancarias">
      
  <div ng-show="vm.response_customer.Cuentas_Bancarias.length==0">      
    <div align="center"><label style="color:black;">No hay información registrada</label></div>
  </div>

    <div class="row" ng-repeat="dato in vm.response_customer.Cuentas_Bancarias">
      <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Cuenta Bancaria </label>
             <input type="text" class="form-control" ng-model="vm.response_customer.Cuentas_Bancarias[$index].NumIBan" readonly placeholder="Cuenta Bancaria" id="NumIBan_{{$index}}" name="NumIBan_{{$index}}" ng-click="vm.copyTextArray(17,$index)"/>     
             </div>
             </div>
          </div>          
          
          <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">Banco </label>         
             <input type="text"  class="form-control" ng-model="vm.response_customer.Cuentas_Bancarias[$index].DesBan" readonly placeholder="Banco" id="DesBan_{{$index}}" name="DesBan_{{$index}}" ng-click="vm.copyTextArray(18,$index)"/>     
             </div>
             </div>
          </div> 
  </div>
</div>

<div class="foreign-supplier-title clearfix" ng-click="vm.showDetails(5)">
    <h4 class="breadcrumb">     
      <span class="foreign-supplier-text" style="color:black;"> Documentos</span> <div align="right" style="margin-top: -16px;"><span class="foreign-supplier-arrow" style="color:black;"><i ng-class="!vm.showDocumentos?'fa fa-angle-right':'fa fa-angle-down'" aria-hidden="true"></i></span></div>
    </h4>
</div>

<div ng-if="vm.showDocumentos">
  
  <div ng-show="vm.response_customer.documentos.length==0">      
    <div align="center"><label style="color:black;">No hay información registrada</label></div>
  </div>

  <div class="row" ng-repeat="dato in vm.response_customer.documentos">
  <div class="col-12 col-sm-5">
    <div class="form">                          
      <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:black;">Tipo de Documento </label>
        <input type="text" class="form-control" ng-model="vm.response_customer.documentos[$index].DesTipDoc" placeholder="Tipo de Documento" readonly id="DesTipDoc_{{$index}}" name="DesTipDoc_{{$index}}" ng-click="vm.copyTextArray(19,$index)"/>     
      </div>
    </div>
  </div>          
          
  <div class="col-12 col-sm-5">
    <div class="form">                          
      <div class="form-group">    
        <label class="font-weight-bold nexa-dark" style="color:black;">Fichero </label>         
        <input type="text"  class="form-control" ng-model="vm.response_customer.documentos[$index].DesDoc" placeholder="Fichero" readonly id="DesDoc_{{$index}}" name="DesDoc_{{$index}}" ng-click="vm.copyTextArray(20,$index)"/>     
      </div>
    </div>
  </div> 

  <div class="col-12 col-sm-2">
    <div class="form">                          
      <div class="form-group">    
        <a class="btn btn-info" href="{{vm.response_customer.documentos[$index].ArcDoc}}" download="Documento" style="margin-left:-15px; margin-top: 24px;" type="button"><i class="fa fa-download"></i></a>     
      </div>
    </div>
  </div>
</div>
               
               
              
              </div>
            </div>
          </div>
        </div>

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
        <!--main content end-->
   </div>
   <div id="List_Cli" class="loader loader-default"  data-text="Cargando listado de Clientes"></div>
   <div id="Buscando_Informacion" class="loader loader-default"  data-text="Buscando Información"></div>

  <script language="JavaScript">
    // Establecemos las variables
    var DesSoc = document.getElementById("RazSocCli");
    var contenedor = document.getElementById("xcontainer");
    //var copy   = document.getElementById("d_clip_url1");
    DesSoc.addEventListener('click', function(e) {
       // Sleccionando el texto
       console.log('pasando por aqui');
       DesSoc.select(); 
       try {
           // Copiando el texto seleccionado
           var successful = document.execCommand('DesSoc');     
           if(successful) contenedor.innerHTML = 'Copiado!';
           else contenedor.innerHTML = 'Incapaz de copiar!';
       } catch (err) {
           contenedor.innerHTML = 'Browser no soportado!';
       }
    });
  </script>


</body>
</html>
