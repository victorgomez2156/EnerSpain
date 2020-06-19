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
 <div ng-controller="Controlador_Add_Propuestas as vm">
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header" ng-show="vm.fdatos.tipo=='nueva'">Registro de Propuesta Comercial</h3>
            <h3 class="page-header" ng-show="vm.fdatos.tipo=='ver'">Consultando Propuesta Comercial</h3>
            <h3 class="page-header" ng-show="vm.fdatos.tipo=='renovar'">Renovación de Propuesta Comercial</h3>
            <h3 class="page-header" ng-show="vm.fdatos.tipo=='editar'">Modificando Propuesta Comercial</h3>
          </div>
        </div>
        <!-- Form validations -->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
             
              <div class="panel-body">


<form id="register_formAnex" name="register_formAnex" ng-submit="submitFormPropuesta($event)"> 
     <div class='row'>              
       <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Razón Social / Apellidos, Nombre</label>
        
        <input type="text" class="form-control" ng-model="vm.RazSocCli" placeholder="* Razón Social / Apellidos, Nombre" maxlength="50" readonly="readonly"/>
       
       </div>
       </div>
       </div>

      <div class="col-12 col-sm-6">
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Nº Documento Fiscal</label>
        <input type="text" class="form-control" ng-model="vm.NumCifCli" placeholder="Nº Documento Fiscal" maxlength="50" readonly="readonly" />
         
         </div>
         </div>
      </div>

      <div class="col-12 col-sm-4">
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Fecha de la Propuesta</label>
        <input type="text" class="form-control datepicker" name="FecProCom" id="FecProCom" ng-model="vm.FecProCom" placeholder="DD/MM/YYYY" maxlength="10" ng-change="vm.validar_formatos_input(1,vm.FecProCom) " ng-disabled="vm.fdatos.tipo=='ver'||vm.fdatos.tipo=='editar'"/>
         
         </div>
         </div>
      </div>

      <div class="col-12 col-sm-4">
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Nº Propuesta</label>
        <input type="text" class="form-control" ng-model="vm.fdatos.RefProCom" placeholder="0000000001" readonly maxlength="10"/>
         
         </div>
         </div>
      </div>

       <div class="col-12 col-sm-4">
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Estatus</label>
          
        <select class="form-control" id="EstProCom" name="EstProCom" ng-model="vm.fdatos.EstProCom" ng-disabled="vm.disabled_status==true || vm.fdatos.tipo=='ver'">
         <option value="P">Pendiente</option>
         <option value="A">Aprobada</option> 
         <option value="C">Completada</option> 
         <option value="R">Rechazada</option>                         
        </select>
         
         </div>
         </div>
      </div>

  <div class="foreign-supplier-title clearfix">
    <h4 class="breadcrumb">     
      <span class="foreign-supplier-text" style="color:black;"> Puntos de Suministros - CUPs</span><div align="right" style="margin-top: -16px;"></div>
    </h4>
  </div>

   <div class="col-12 col-sm-12">       
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Seleccione una Dirección de Suministro</label>
       <select class="form-control" id="CodPunSum" name="CodPunSum" required ng-model="vm.fdatos.CodPunSum" ng-change="vm.filter_DirPumSum(vm.fdatos.CodPunSum)" ng-disabled="vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'"> 
        <option ng-repeat="dato_act in vm.List_Puntos_Suministros" value="{{dato_act.CodPunSum}}">{{dato_act.DirPumSum}} {{dato_act.DesLoc}} {{dato_act.DesPro}} {{dato_act.CPLocSoc}} {{dato_act.EscPunSum}} {{dato_act.PlaPunSum}} {{dato_act.PuePunSum}}</option>
        </select>       
       </div>
       </div>
    </div>

    <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Dirección </label>
             <input type="text" class="form-control" placeholder="Dirección" ng-model="vm.DirPumSum" readonly />     
             </div>
             </div>
          </div>

        <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Escalera / Planta / Puerta </label>
             <input type="text" class="form-control" ng-model="vm.EscPlaPuerPumSum" placeholder="Escalera / Planta / Puerta" readonly/>  
             </div>
             </div>
          </div>
          <div class="col-12 col-sm-5">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Localidad </label>
             <input type="text" class="form-control" ng-model="vm.DesLocPumSum" placeholder="Localidad" readonly/>     
             </div>
             </div>
          </div>
          <div class="col-12 col-sm-5">
            <div class="form">                          
             <div class="form-group">   
              <label class="font-weight-bold nexa-dark" style="color:black;">Povincia </label>          
             <input type="text" class="form-control" ng-model="vm.DesProPumSum" placeholder="Provincia" readonly/>     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">Código Postal </label>         
             <input type="text"  class="form-control" ng-model="vm.CPLocPumSum" placeholder="Código Postal" readonly/>     
             </div>
             </div>
          </div>  

<!--- PARA LOS CUPS ELECTRICOS START-->
        <div >
          <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:blue;">CUPs Eléctrico</label>
             <select class="form-control" id="CodCupSEle" name="CodCupSEle" required ng-model="vm.fdatos.CodCupSEle" ng-change="vm.CUPsFilter(1,vm.fdatos.CodCupSEle)" ng-disabled="vm.fdatos.CodPunSum==undefined|| vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'"> 
                <option ng-repeat="dato_act in vm.List_CUPsEle" value="{{dato_act.CodCupsEle}}">{{dato_act.CUPsEle}}</option>
        </select>     
             </div>
             </div>
          </div>
          
          <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">   
              <label class="font-weight-bold nexa-dark" style="color:black;"> Tarifa</label>          
             <select class="form-control" id="CodTarEle" name="CodTarEle" required ng-model="vm.fdatos.CodTarEle" ng-disabled="vm.fdatos.CodCupSEle==undefined || vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'" ng-change="vm.filtrerCanPeriodos(vm.fdatos.CodTarEle)"> 
                <option ng-repeat="dato_act in vm.List_TarEle" value="{{dato_act.CodTarEle}}">{{dato_act.NomTarEle}}</option>
        </select>                  
             </div>
             </div>
          </div>        

        <div ng-show="vm.CanPerEle==6">
          
          <div class="col-12 col-sm-1">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P1 </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PotConP1" placeholder="P1" ng-disabled="vm.fdatos.CodCupSEle==undefined || vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'" ng-change="vm.validar_formatos_input(2,vm.fdatos.PotConP1)"/>     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-1">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P2 </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PotConP2" placeholder="P2" ng-disabled="vm.fdatos.CodCupSEle==undefined || vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'" ng-change="vm.validar_formatos_input(3,vm.fdatos.PotConP2)"/>     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-1">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P3 </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PotConP3" placeholder="P3" ng-disabled="vm.fdatos.CodCupSEle==undefined || vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'" ng-change="vm.validar_formatos_input(4,vm.fdatos.PotConP3)"/>     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-1">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P4 </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PotConP4" placeholder="P4" ng-disabled="vm.fdatos.CodCupSEle==undefined || vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'" ng-change="vm.validar_formatos_input(5,vm.fdatos.PotConP4)"/>     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-1">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P5 </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PotConP5" placeholder="P5" ng-disabled="vm.fdatos.CodCupSEle==undefined || vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'" ng-change="vm.validar_formatos_input(6,vm.fdatos.PotConP5)"/>     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-1">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P6 </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PotConP6" placeholder="P6" ng-disabled="vm.fdatos.CodCupSEle==undefined || vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'" ng-change="vm.validar_formatos_input(7,vm.fdatos.PotConP6)"/>     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">Ahorro (€)</label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.ImpAhoEle" placeholder="Ahorro (€)" ng-disabled="vm.fdatos.CodCupSEle==undefined || vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'" ng-change="vm.validar_formatos_input(8,vm.fdatos.ImpAhoEle)"/>     
             </div>
             </div>
          </div>
        </div>

        <div ng-show="vm.CanPerEle==1">
          <div class="col-12 col-sm-4">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P1 </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PotConP1" placeholder="P1" ng-disabled="vm.fdatos.CodCupSEle==undefined || vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'" ng-change="vm.validar_formatos_input(2,vm.fdatos.PotConP1)"/>     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-4">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">Ahorro (€)</label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.ImpAhoEle" placeholder="Ahorro (€)" ng-disabled="vm.fdatos.CodCupSEle==undefined || vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'" ng-change="vm.validar_formatos_input(8,vm.fdatos.ImpAhoEle)"/>     
             </div>
             </div>
          </div>
        </div>

         <div ng-show="vm.CanPerEle==2">

          <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P1 </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PotConP1" placeholder="P1" ng-disabled="vm.fdatos.CodCupSEle==undefined || vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'" ng-change="vm.validar_formatos_input(2,vm.fdatos.PotConP1)"/>     
             </div>
             </div>
          </div>

            <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P2 </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PotConP2" placeholder="P2" ng-disabled="vm.fdatos.CodCupSEle==undefined || vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'" ng-change="vm.validar_formatos_input(3,vm.fdatos.PotConP2)"/>     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">Ahorro (€)</label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.ImpAhoEle" placeholder="Ahorro (€)" ng-disabled="vm.fdatos.CodCupSEle==undefined || vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'" ng-change="vm.validar_formatos_input(8,vm.fdatos.ImpAhoEle)"/>     
             </div>
             </div>
          </div>

        </div>

        <div ng-show="vm.CanPerEle==3">
          
          <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P1 </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PotConP1" placeholder="P1" ng-disabled="vm.fdatos.CodCupSEle==undefined || vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'" ng-change="vm.validar_formatos_input(2,vm.fdatos.PotConP1)"/>     
             </div>
             </div>
          </div>
           <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P2 </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PotConP2" placeholder="P2" ng-disabled="vm.fdatos.CodCupSEle==undefined || vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'" ng-change="vm.validar_formatos_input(3,vm.fdatos.PotConP2)"/>     
             </div>
             </div>
          </div>
           <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P3 </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PotConP3" placeholder="P3" ng-disabled="vm.fdatos.CodCupSEle==undefined || vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'" ng-change="vm.validar_formatos_input(4,vm.fdatos.PotConP3)"/>     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">Ahorro (€)</label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.ImpAhoEle" placeholder="Ahorro (€)" ng-disabled="vm.fdatos.CodCupSEle==undefined || vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'" ng-change="vm.validar_formatos_input(8,vm.fdatos.ImpAhoEle)"/>     
             </div>
             </div>
          </div>
        </div>

        <div ng-show="vm.CanPerEle==4">
          
          <div class="col-12 col-sm-1">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P1 </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PotConP1" placeholder="P1" ng-disabled="vm.fdatos.CodCupSEle==undefined || vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'" ng-change="vm.validar_formatos_input(2,vm.fdatos.PotConP1)"/>     
             </div>
             </div>
          </div>
           <div class="col-12 col-sm-1">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P2 </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PotConP2" placeholder="P2" ng-disabled="vm.fdatos.CodCupSEle==undefined || vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'" ng-change="vm.validar_formatos_input(3,vm.fdatos.PotConP2)"/>     
             </div>
             </div>
          </div>
           <div class="col-12 col-sm-1">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P3 </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PotConP3" placeholder="P3" ng-disabled="vm.fdatos.CodCupSEle==undefined || vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'" ng-change="vm.validar_formatos_input(4,vm.fdatos.PotConP3)"/>     
             </div>
             </div>
          </div>
           <div class="col-12 col-sm-1">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P4 </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PotConP4" placeholder="P4" ng-disabled="vm.fdatos.CodCupSEle==undefined || vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'" ng-change="vm.validar_formatos_input(5,vm.fdatos.PotConP4)"/>     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-4">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">Ahorro (€)</label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.ImpAhoEle" placeholder="Ahorro (€)" ng-disabled="vm.fdatos.CodCupSEle==undefined || vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'" ng-change="vm.validar_formatos_input(8,vm.fdatos.ImpAhoEle)"/>     
             </div>
             </div>
          </div>
        </div>

        <div ng-show="vm.CanPerEle==5">
          
          <div class="col-12 col-sm-1">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P1 </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PotConP1" placeholder="P1" ng-disabled="vm.fdatos.CodCupSEle==undefined || vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'" ng-change="vm.validar_formatos_input(2,vm.fdatos.PotConP1)"/>     
             </div>
             </div>
          </div>
           <div class="col-12 col-sm-1">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P2 </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PotConP2" placeholder="P2" ng-disabled="vm.fdatos.CodCupSEle==undefined || vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'" ng-change="vm.validar_formatos_input(3,vm.fdatos.PotConP2)"/>     
             </div>
             </div>
          </div>
           <div class="col-12 col-sm-1">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P3 </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PotConP3" placeholder="P3" ng-disabled="vm.fdatos.CodCupSEle==undefined || vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'" ng-change="vm.validar_formatos_input(4,vm.fdatos.PotConP3)"/>     
             </div>
             </div>
          </div>
           <div class="col-12 col-sm-1">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P4 </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PotConP4" placeholder="P4" ng-disabled="vm.fdatos.CodCupSEle==undefined || vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'" ng-change="vm.validar_formatos_input(5,vm.fdatos.PotConP4)"/>     
             </div>
             </div>
          </div>
           <div class="col-12 col-sm-1">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P5 </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PotConP5" placeholder="P5" ng-disabled="vm.fdatos.CodCupSEle==undefined || vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'" ng-change="vm.validar_formatos_input(6,vm.fdatos.PotConP5)"/>     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">Ahorro (€)</label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.ImpAhoEle" placeholder="Ahorro (€)" ng-disabled="vm.fdatos.CodCupSEle==undefined || vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'" ng-change="vm.validar_formatos_input(8,vm.fdatos.ImpAhoEle)"/>     
             </div>
             </div>
          </div>
        </div>
          <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">% </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PorAhoEle" placeholder="%" ng-disabled="vm.fdatos.CodCupSEle==undefined || vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'" ng-change="vm.validar_formatos_input(9,vm.fdatos.PorAhoEle)"/>     
             </div>
             </div>
          </div>

          <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">Renovación </label>         
             <input type="checkbox"  class="form-control" style="margin-top: -1px;" ng-model="vm.fdatos.RenConEle" ng-disabled="vm.fdatos.CodCupSEle==undefined || vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'|| vm.fdatos.tipo=='renovar'|| vm.fdatos.tipo=='nueva' || vm.ProRenPen==1|| vm.fdatos.tipo=='editar'"/>     
             </div>
             </div>
          </div>
          <div class="col-12 col-sm-8">
      <div class="form" >                          
       <div class="form-group">
        <textarea class="form-control" style="display: inline-block;" onkeyup="this.value=this.value.toUpperCase();" id="ObsAhoEle" name="ObsAhoEle" minlength="1" maxlength="200" rows="5" placeholder="Observación" ng-model="vm.fdatos.ObsAhoEle" ng-disabled="vm.fdatos.CodCupSEle==undefined || vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'"></textarea>        
       </div>
       </div> </div> 
          </div>
          <!--- PARA LOS CUPS ELECTRICOS END -->


<!--- PARA LOS CUPS GAS START-->
        <div >
          <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:blue;">CUPs Gas </label>
             <select class="form-control" id="CodCupGas" name="CodCupGas" required ng-model="vm.fdatos.CodCupGas" ng-change="vm.CUPsFilter(2,vm.fdatos.CodCupGas)" ng-disabled="vm.fdatos.CodPunSum==undefined || vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'"> 
                <option ng-repeat="dato_act in vm.List_CUPs_Gas" value="{{dato_act.CodCupGas}}">{{dato_act.CupsGas}}</option>
              </select>     
             </div>
             </div>
          </div>
          
          <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">   
              <label class="font-weight-bold nexa-dark" style="color:black;">Tarifa </label>          
             <select class="form-control" id="CodTarGas" name="CodTarGas" required ng-model="vm.fdatos.CodTarGas" ng-disabled="vm.fdatos.CodCupGas==undefined || vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'"> 
                <option ng-repeat="dato_act in vm.List_TarGas" value="{{dato_act.CodTarGas}}">{{dato_act.NomTarGas}}</option>
        </select>                  
             </div>
             </div>
          </div>        

           <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">Consumo </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.Consumo" placeholder="Consumo" ng-disabled="vm.fdatos.CodCupGas==undefined || vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'" ng-change="vm.validar_formatos_input(10,vm.fdatos.Consumo)"/>     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">Caudal Diario </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.CauDia" placeholder="Caudal Diario" ng-disabled="vm.fdatos.CodCupGas==undefined || vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'" ng-change="vm.validar_formatos_input(11,vm.fdatos.Caudal_Diario)"/>     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">Ahorro (€)</label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.ImpAhoGas" placeholder="Ahorro (€)" ng-disabled="vm.fdatos.CodCupGas==undefined || vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'" ng-change="vm.validar_formatos_input(12,vm.fdatos.ImpAhoGas)"/>     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-1">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">% </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PorAhoGas" placeholder="%" ng-disabled="vm.fdatos.CodCupGas==undefined || vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'" ng-change="vm.validar_formatos_input(13,vm.fdatos.PorAhoGas)"/>     
             </div>
             </div>
          </div>

          <div class="col-12 col-sm-1">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">Ren </label>         
             <input type="checkbox"  class="form-control" style="margin-top: -1px;" ng-model="vm.fdatos.RenConGas" ng-disabled="vm.fdatos.CodCupGas==undefined || vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C' || vm.fdatos.tipo=='renovar'|| vm.fdatos.tipo=='nueva'|| vm.ProRenPen==1|| vm.fdatos.tipo=='editar'"/>     
             </div>
             </div>
          </div>
        <div class="form" >                          
       <div class="form-group">
        <textarea class="form-control" style="display: inline-block;" onkeyup="this.value=this.value.toUpperCase();" id="ObsAhoGas" name="ObsAhoGas" minlength="1" maxlength="200" rows="5" placeholder="Observación" ng-model="vm.fdatos.ObsAhoGas" ng-disabled="vm.fdatos.CodCupGas==undefined || vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'"></textarea>        
       </div>
       </div>  
    </div>
  <!--- PARA LOS CUPS ELECTRICOS END -->

   <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Comercializadora </label>
             <select class="form-control" id="CodCom" name="CodCom" required ng-model="vm.fdatos.CodCom" ng-change="vm.realizar_filtro(1,vm.fdatos.CodCom)" ng-disabled="vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'"> 
                <option ng-repeat="dato_act in vm.List_Comercializadora" value="{{dato_act.CodCom}}">{{dato_act.NumCifCom}} - {{dato_act.NomComCom}}</option>
        </select>     
             </div>
             </div>
          </div>
          
          <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">   
              <label class="font-weight-bold nexa-dark" style="color:black;">Producto </label>          
             <select class="form-control" id="CodPro" name="CodPro" required ng-model="vm.fdatos.CodPro" ng-disabled="vm.fdatos.CodCom==undefined || vm.List_Productos.length==0 || vm.fdatos.tipo=='ver' || vm.fdatos.EstProCom=='C'" ng-change="vm.realizar_filtro(2,vm.fdatos.CodPro)"> 
                <option ng-repeat="dato_act in vm.List_Productos" value="{{dato_act.CodPro}}">{{dato_act.DesPro}}</option>
        </select>                  
             </div>
             </div>
          </div>  

           <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Anexo </label>
             <select class="form-control" id="CodAnePro" name="CodAnePro" required ng-model="vm.fdatos.CodAnePro" ng-disabled="vm.fdatos.CodCom==undefined || vm.fdatos.CodPro==undefined || vm.fdatos.tipo=='ver' || vm.fdatos.EstProCom=='C'" ng-change="vm.realizar_filtro(3,vm.fdatos.CodAnePro)"> 
                <option ng-repeat="dato_act in vm.List_Anexos" value="{{dato_act.CodAnePro}}">{{dato_act.DesAnePro}}</option>
        </select>     
             </div>
             </div>
          </div>
          
          <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">   
              <label class="font-weight-bold nexa-dark" style="color:black;">Tipo Precio </label>          
             <select class="form-control" id="TipPre" name="TipPre" required ng-model="vm.fdatos.TipPre" ng-disabled="vm.fdatos.CodAnePro==undefined || vm.fdatos.tipo=='ver' || vm.fdatos.EstProCom=='C'"> 
                <option ng-repeat="dato_act in vm.List_TipPre" value="{{dato_act.TipPre}}">{{dato_act.nombre}}</option>
        </select>                  
             </div>
             </div>
          </div>  
      
        <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">Ahorro Total </label>         
             <input type="text" ng-model="vm.fdatos.ImpAhoTot" placeholder="123,35 €" readonly />
             <input type="text" ng-model="vm.fdatos.PorAhoTot" readonly />
             <label class="font-weight-bold nexa-dark" style="color:black;">% </label>       
             </div>
             </div>
          </div>

          <div class="col-12 col-sm-6" ng-show="vm.fdatos.tipo=='editar' && vm.fdatos.EstProCom!='C'|| vm.fdatos.tipo=='ver' && vm.fdatos.EstProCom!='C'">
            <div class="form">                          
             <div class="form-group">
             <input type="checkbox" ng-model="vm.fdatos.Apro" ng-disabled="vm.fdatos.Rech==true"/>
             <label class="font-weight-bold nexa-dark" style="color:black;">Aprobada </label><br>
             <input type="checkbox"  ng-model="vm.fdatos.Rech" ng-disabled="vm.fdatos.Apro==true"/>
             <label class="font-weight-bold nexa-dark" style="color:black;">Rechazada </label> <input type="text" ng-model="vm.fdatos.JusRecProCom" placeholder="Introduzca justificación del rechazo..." ng-disabled="vm.fdatos.Rech==false"/>       
             </div>
             </div>
          </div>

          <div class="form" >                          
       <div class="form-group">
        <textarea class="form-control" style="display: inline-block;" onkeyup="this.value=this.value.toUpperCase();" id="ObsProCom" name="ObsProCom" minlength="1" maxlength="200" rows="5" ng-disabled="vm.fdatos.EstProCom=='C'" placeholder="Observaciónes Generales" ng-model="vm.fdatos.ObsProCom"></textarea>        
       </div>
       </div> 
      <input class="form-control" id="CodProCom" name="CodProCom" type="hidden" ng-model="vm.fdatos.CodProCom" readonly/>
         


         <div class="form-group" >
          <div class="col-12 col-sm-6">
            <button class="btn btn-info" type="submit" ng-show="vm.fdatos.tipo=='nueva' || vm.fdatos.tipo=='renovar'" ng-disabled="vm.disabled_button==true">Grabar</button>
            <button class="btn btn-success" type="submit" ng-show="vm.fdatos.tipo=='editar' && vm.fdatos.EstProCom!='C' || vm.fdatos.tipo=='ver' && vm.fdatos.EstProCom!='C'">Actualizar</button>

            <a class="btn btn-warning" href="reportes/Exportar_Documentos/Doc_Propuesta_Comercial_Cliente_PDF/{{vm.fdatos.CodProCom}}" style="margin-top: 0px;" target="_black" ng-show="vm.fdatos.tipo=='editar' || vm.fdatos.tipo=='ver'">Generar PDF</a>
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

  
  $('.datepicker').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});   

  $('#fecha_bloqueo').on('changeDate', function() 
  {
     var fecha_bloqueo=document.getElementById("fecha_bloqueo").value;
     console.log("fecha_bloqueo: "+fecha_bloqueo);
  });

</script>
<script type="text/javascript" src="application/libraries/estilos/js/jquery.validate.min.js"></script>
  <!-- custom form validation script for this page-->
  <script src="application/libraries/estilos/js/form-validation-script.js"></script>
  <!--custome script for all page-->
  <!--script src="application/libraries/estilos/js/scripts.js"></script-->
</body>
<div id="Guardando" class="loader loader-default"  data-text="Grabando Propuesta Comercial"></div>
<div id="Actualizando" class="loader loader-default"  data-text="Actualizando Propuesta Comercial"></div>
<div id="cargando" class="loader loader-default"  data-text="Cargando datos de la Propuesta Comercial"></div>
<div id="CUPs" class="loader loader-default"  data-text="Cargando CUPs del Cliente"></div>
</html>
