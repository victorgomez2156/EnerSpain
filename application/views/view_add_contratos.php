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

<style>

        .file-item{
            background: white;
    height: 35px;
    padding: 10px;
    margin-left: 0;
    font-size: 12px;
    border-bottom: 1px solid gainsboro;
        }

        .file_b{
            position:absolute;
            left:0;
            top:0;
            background:red;
            width:100%;
            height:100%;
            opacity:0;
        }     

        #file-wrap{
            position:relative;
            width:100%;
            padding: 5px;
            display: block;
            border: 2px dashed #ccc;
            margin: 0 auto;
            text-align: center;
            box-sizing:border-box;
            border-radius: 5px;
        }

      
        .file_b{
            position:absolute;
            left:0;
            top:0;
            background:red;
            width:100%;
            height:100%;
            opacity:0;
        }
    </style>
<body>
 <div ng-controller="Controlador_Contratos as vm">
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header" ng-show="vm.fdatos.tipo=='nuevo'">Registro de Contratos</h3>
            <h3 class="page-header" ng-show="vm.fdatos.tipo=='ver'">Consultando Contrato</h3>
            <h3 class="page-header" ng-show="vm.fdatos.tipo=='renovar'">Renovación de Propuesta Comercial</h3>
            <h3 class="page-header" ng-show="vm.fdatos.tipo=='editar'">Modificando Contrato</h3>
          </div>
        </div>
        <!-- Form validations -->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
             
              <div class="panel-body">


<form id="register_form_contratos" name="register_form_contratos" ng-submit="submitFormContratos($event)"> 
     <div class='row'>              
       <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Razón Social / Apellidos, Nombre</label>
        
        <input type="text" class="form-control" ng-model="vm.RazSocCli" placeholder="* Razón Social / Apellidos, Nombre" maxlength="50" readonly="readonly" />
       
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
         <label class="font-weight-bold nexa-dark" style="color:black;">Propuesta Comercial</label>
          <select class="form-control" id="CodProCom" name="CodProCom" required ng-model="vm.fdatos.CodProCom" ng-disabled="vm.fdatos.tipo=='ver'" ng-change="vm.filtrar_propuesta_contratos()"> 
        <option ng-repeat="dato_act in vm.List_Propuestas_Comerciales" value="{{dato_act.CodProCom}}">{{dato_act.CodProCom}} - {{dato_act.FecProCom}} - {{dato_act.RefProCom}}</option>
        </select>
        
         
         </div>
         </div>
      </div>

      <div class="col-12 col-sm-4">
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Fecha Propuesta</label>
       <input type="text" class="form-control datepicker" name="FecProCom" id="FecProCom" ng-model="vm.FecProCom" placeholder="DD/MM/YYYY" maxlength="10" ng-change="vm.validar_formatos_input(1,vm.FecProCom) " readonly="readonly" />
         
         </div>
         </div>
      </div>

       <div class="col-12 col-sm-4">
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Nº Propuesta</label>
          
       <input type="text" class="form-control" name="RefProCom" id="RefProCom" ng-model="vm.RefProCom" placeholder="00000000001" readonly="readonly"/>
         
         </div>
         </div>
      </div>
  
  <div ng-show="vm.fdatos.TipProCom=='1'">  
      <div class="col-12 col-sm-7">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Dirección de Suministro</label>
             <input type="text" class="form-control" placeholder="Dirección" ng-model="vm.DirPunSum" readonly="readonly"/>     
             </div>
             </div>
      </div>

      <div class="col-12 col-sm-5">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Escalera / Planta / Puerta </label>
             <input type="text" class="form-control" ng-model="vm.EscPlaPuerPunSum" placeholder="Escalera / Planta / Puerta" readonly="readonly"/>  
             </div>
             </div>
      </div>
      <div class="col-12 col-sm-5">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Localidad </label>
             <input type="text" class="form-control" ng-model="vm.DesLocPunSum" placeholder="Localidad" readonly="readonly"/>     
             </div>
             </div>
      </div>
      
      <div class="col-12 col-sm-5">
            <div class="form">                          
             <div class="form-group">   
              <label class="font-weight-bold nexa-dark" style="color:black;">Provincia </label>          
             <input type="text" class="form-control" ng-model="vm.DesProPunSum" placeholder="Provincia" readonly="readonly"/>     
             </div>
             </div>
      </div>

      <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">Código Postal </label>         
             <input type="text"  class="form-control" ng-model="vm.CPLocPunSum" placeholder="Código Postal" readonly="readonly"/>     
             </div>
             </div>
      </div>  

<!--- PARA LOS CUPS ELECTRICOS START-->
       
          <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:blue;">CUPs Eléctrico</label>
             <input type="text"  class="form-control" ng-model="vm.CodCupSEle" placeholder="CUPs Eléctrico" readonly="readonly"/>
             </div>
             </div>
          </div>
          
          <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">   
              <label class="font-weight-bold nexa-dark" style="color:black;"> Tarifa</label>    
        <input type="text"  class="form-control" ng-model="vm.CodTarEle" placeholder="Tarifa" readonly="readonly"/>                 
             </div>
             </div>
          </div>        

        <div ng-show="vm.CanPerEle==6">
          
          <div class="col-12 col-sm-1">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P1 </label>         
             <input type="text"  class="form-control" ng-model="vm.PotConP1" placeholder="P1" readonly />     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-1">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P2 </label>         
             <input type="text"  class="form-control" ng-model="vm.PotConP2" placeholder="P2" readonly />     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-1">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P3 </label>         
             <input type="text"  class="form-control" ng-model="vm.PotConP3" placeholder="P3" readonly />     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-1">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P4 </label>         
             <input type="text"  class="form-control" ng-model="vm.PotConP4" placeholder="P4" readonly />     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-1">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P5 </label>         
             <input type="text"  class="form-control" ng-model="vm.PotConP5" placeholder="P5" readonly />     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-1">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P6 </label>         
             <input type="text"  class="form-control" ng-model="vm.PotConP6" placeholder="P6" readonly />     
             </div>
             </div>
          </div>
        </div>

        <div ng-show="vm.CanPerEle==1">
          <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P1 </label>         
             <input type="text"  class="form-control" ng-model="vm.PotConP1" placeholder="P1" readonly />     
             </div>
             </div>
          </div>
          
        </div>

        <div ng-show="vm.CanPerEle==2">

          <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P1 </label>         
             <input type="text"  class="form-control" ng-model="vm.PotConP1" placeholder="P1" readonly />     
             </div>
             </div>
          </div>

            <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P2 </label>         
             <input type="text"  class="form-control" ng-model="vm.PotConP2" placeholder="P2" readonly />     
             </div>
             </div>
          </div>

           

        </div>

        <div ng-show="vm.CanPerEle==3">
          
          <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P1 </label>         
             <input type="text"  class="form-control" ng-model="vm.PotConP1" placeholder="P1" readonly />     
             </div>
             </div>
          </div>
           <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P2 </label>         
             <input type="text"  class="form-control" ng-model="vm.PotConP2" placeholder="P2" readonly />     
             </div>
             </div>
          </div>
           <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P3 </label>         
             <input type="text"  class="form-control" ng-model="vm.PotConP3" placeholder="P3" readonly />     
             </div>
             </div>
          </div>

          
        </div>

        <div ng-show="vm.CanPerEle==4">
          
          <div class="col-12 col-sm-1">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P1 </label>         
             <input type="text"  class="form-control" ng-model="vm.PotConP1" placeholder="P1" readonly />     
             </div>
             </div>
          </div>
           <div class="col-12 col-sm-1">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P2 </label>         
             <input type="text"  class="form-control" ng-model="vm.PotConP2" placeholder="P2" readonly />     
             </div>
             </div>
          </div>
           <div class="col-12 col-sm-1">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P3 </label>         
             <input type="text"  class="form-control" ng-model="vm.PotConP3" placeholder="P3" readonly />     
             </div>
             </div>
          </div>
           <div class="col-12 col-sm-1">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P4 </label>         
             <input type="text"  class="form-control" ng-model="vm.PotConP4" placeholder="P4" readonly />     
             </div>
             </div>
          </div>

          
        </div>

        <div ng-show="vm.CanPerEle==5">
          
          <div class="col-12 col-sm-1">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P1 </label>         
             <input type="text"  class="form-control" ng-model="vm.PotConP1" placeholder="P1" readonly />     
             </div>
             </div>
          </div>
           <div class="col-12 col-sm-1">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P2 </label>         
             <input type="text"  class="form-control" ng-model="vm.PotConP2" placeholder="P2" readonly />     
             </div>
             </div>
          </div>
           <div class="col-12 col-sm-1">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P3 </label>         
             <input type="text"  class="form-control" ng-model="vm.PotConP3" placeholder="P3" readonly />     
             </div>
             </div>
          </div>
           <div class="col-12 col-sm-1">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P4 </label>         
             <input type="text"  class="form-control" ng-model="vm.PotConP4" placeholder="P4" readonly />     
             </div>
             </div>
          </div>
           <div class="col-12 col-sm-1">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P5 </label>         
             <input type="text"  class="form-control" ng-model="vm.PotConP5" placeholder="P5" readonly />     
             </div>
             </div>
          </div>
           
        </div>
         
         <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark">Consumo</label>
             <input type="text"  class="form-control" ng-model="vm.ConCups" placeholder="Consumo CUPs" readonly="readonly"/>
             </div>
             </div>
          </div>

          <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark">Fecha Vencimiento</label>
             <input type="text"  class="form-control FecVenCUPs_Ele" id="FecVenCUPs_Ele" ng-model="vm.FecVenCUPs_Ele" placeholder="DD/MM/YYYY"/>
             </div>
             </div>
          </div>

          <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark">Fecha Activación</label>
             <input type="text"  class="form-control FecActCUPs_Ele" id="FecActCUPs_Ele"  ng-model="vm.FecActCUPs_Ele" placeholder="DD/MM/YYYY"/>
             </div>
             </div>
          </div>

          <div class="">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark">Nº Audax Eléctrico</label>
             <input type="text"  class="form-control" ng-model="vm.NumComAudaxEle" placeholder="Nº de Contrato Audax" readonly="readonly"/>
             </div>
             </div>
          </div>
        <!--- PARA LOS CUPS ELECTRICOS END -->



      <!--- PARA LOS CUPS GAS START-->
      
          <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:blue;">CUPs Gas </label>
             <input type="text"  class="form-control" ng-model="vm.CodCupGas" placeholder="CUP Gas" readonly="readonly"/>    
             </div>
             </div>
          </div>
          
          <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">   
              <label class="font-weight-bold nexa-dark" style="color:black;">Tarifa </label>          
            
            <input type="text"  class="form-control" ng-model="vm.CodTarGas" placeholder="Tarifa" readonly="readonly"/>                 
             </div>
             </div>
          </div>        

           <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">Consumo </label>         
             <input type="text"  class="form-control" ng-model="vm.Consumo" placeholder="Consumo" readonly="readonly"/>     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">Caudal Diario </label>         
             <input type="text"  class="form-control" ng-model="vm.CauDia" placeholder="Caudal Diario" readonly="readonly"/>     
             </div>
             </div>
          </div>

            <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark">Fecha Vencimiento</label>
             <input type="text"  class="form-control FecVenCUPs_Gas" id="FecVenCUPs_Gas"  ng-model="vm.FecVenCUPs_Gas" placeholder="DD/MM/YYYY"/>
             </div>
             </div>
          </div>

          <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark">Fecha Activación</label>
             <input type="text"  class="form-control FecActCUPs_Gas" id="FecActCUPs_Gas"  ng-model="vm.FecActCUPs_Gas" placeholder="DD/MM/YYYY"/>
             </div>
             </div>
          </div>
        
    <div class="">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark">Nº Audax Gas</label>
             <input type="text"  class="form-control" ng-model="vm.NumComAudaxGas" placeholder="Nº de Contrato Audax" readonly="readonly"/>
             </div>
             </div>
          </div>
  <!--- PARA LOS CUPS GAS END -->
</div> 
<!--- FINAL DIV PARA VISTAS NG -->


<!-- INICIO TABLA PARA TIPPROCOM 2 STARTT ///// -->
<div class="table-responsive" ng-show="vm.fdatos.TipProCom==2">
          <table class="table table-striped table-advance table-hover table-responsive">
                <tbody>
                  <tr> 
                    <th></th>
                    <th>Dirección de Suministro</th>
                    <th>Tipo de CUPs</th>
                    <th>CUPs</th>
                    <th>Tárifa</th>
                    <th>Consumo</th>
                    <th>Ren</th>
                    <th>Ahorro €</th> 
                    <th>Fecha Activación<br>DD/MM/YYYY</th> 
                    <th>Fecha Vencimiento<br>DD/MM/YYYY</th>
                    <th>Nº Contrato Audax</th>                    
                  </tr>
                  <tr ng-show="vm.fdatos.detalleCUPs.length==0"> 
                     <td colspan="8" align="center"><div class="td-usuario-table">No hay información disponible</div></td>           
                  </tr>
                  <tr ng-repeat="dato in vm.fdatos.detalleCUPs | filter:paginate" ng-class-odd="odd">                    
                    <td>{{$index+1}}</td>
                    <td>{{dato.DirPunSum}}</td>
                    <td>
                      <span ng-show="dato.TipServ==1">E</span>
                      <span ng-show="dato.TipServ==2">G</span>
                    </td>
                    <td>{{dato.CUPsName}}</td>
                    <td>{{dato.NomTar}}</td>
                    <td>{{dato.ConCUPs}}</td>
                    <td><span ng-show="dato.RenCon==false || dato.RenCon=='0'">No</span>
                      <span ng-show="dato.RenCon==true || dato.RenCon=='1'">Si</td>
                    <td>{{dato.ImpAho}}</td>
                    <td><input class="form-control" name="FecActCUPs_{{$index}}" id="FecActCUPs_{{$index}}" type="text" ng-model="vm.fdatos.detalleCUPs[$index].FecActCUPs" ng-change="vm.validar_fecha(vm.fdatos.detalleCUPs[$index].FecActCUPs,$index,dato,1)" maxlength="10" placeholder="DD/MM/YYYY" /></td>
                    <td><input class="form-control" name="FecVenCUPs_{{$index}}" id="FecVenCUPs_{{$index}}" type="text" ng-model="vm.fdatos.detalleCUPs[$index].FecVenCUPs" ng-change="vm.validar_fecha(vm.fdatos.detalleCUPs[$index].FecVenCUPs,$index,dato,2)" maxlength="10" placeholder="DD/MM/YYYY" /></td>
                    <td><input class="form-control" name="Nr_Audax_2_{{$index}}" id="Nr_Audax_2_{{$index}}" type="text" ng-model="vm.fdatos.detalleCUPs[$index].Nr_Audax" readonly="readonly"/></td>                     
                  </tr>
                </tbody>
                <tfoot> 
                    <th></th>
                    <th>Dirección de Suministro</th>
                    <th>Tipo de CUPs</th>
                    <th>CUPs</th>
                    <th>Tárifa</th>
                    <th>Consumo</th>
                    <th>Ren</th>
                    <th>Ahorro €</th> 
                    <th>Fecha Activación<br>DD/MM/YYYY</th> 
                    <th>Fecha Vencimiento<br>DD/MM/YYYY</th>
                    <th>Nº Contrato Audax</th>     
                </tfoot>
              </table>
        </div>
<!-- INICIO TABLA PARA TIPPROCOM 2 END ///// -->



<!-- INICIO TABLA PARA TIPPROCOM 3 STARTT ///// -->
<div class="table-responsive" ng-show="vm.fdatos.TipProCom==3">
          <table class="table table-striped table-advance table-hover table-responsive" >
                <tbody>
                  <tr> 
                    <th></th>
                    <th>Cliente</th>
                    <th>CIF/NIF</th>
                    <th>Dirección de Suministro</th>
                    <th>Tipo de CUPs</th>
                    <th>CUPs</th>
                    <th>Tárifa</th>
                    <th>Consumo</th>
                    <th>Ren</th>
                    <th>Ahorro €</th>
                    <th>Fecha Activación<br>DD/MM/YYYY</th>
                    <th>Fecha Vencimiento<br>DD/MM/YYYY</th>
                    <th>Nº Contrato Audax</th>                      
                  </tr>
                  <tr ng-show="vm.fdatos.detalleCUPs.length==0"> 
                     <td colspan="10" align="center"><div class="td-usuario-table">No hay información disponible</div></td>           
                  </tr>
                  <tr ng-repeat="dato in vm.fdatos.detalleCUPs | filter:paginate" ng-class-odd="odd">                    
                    <td>{{$index+1}}</td>
                    <td>{{dato.RazSocCli}}</td>                                        
                    <td>{{dato.NumCifCli}}</td>
                    <td>{{dato.DirPunSum}}</td>
                    <td>
                      <span ng-show="dato.TipServ==1">E</span>
                      <span ng-show="dato.TipServ==2">G</span>
                    </td>
                    <td>{{dato.CUPsName}}</td>
                    <td>{{dato.NomTar}}</td>
                    <td>{{dato.ConCUPs}}</td>
                    <td><span ng-show="dato.RenCon==false || dato.RenCon=='0'">No</span>
                      <span ng-show="dato.RenCon==true || dato.RenCon=='1'">Si</td>
                    <td>{{dato.ImpAho}}</td> 
                    <td><input class="form-control" name="FecActCUPs_{{$index}}_{{$index}}" id="FecActCUPs_{{$index}}_{{$index}}" type="text" ng-model="vm.fdatos.detalleCUPs[$index].FecActCUPs" ng-change="vm.validar_fecha(vm.fdatos.detalleCUPs[$index].FecActCUPs,$index,dato,1)" maxlength="10" placeholder="DD/MM/YYYY" /></td>
                    <td><input class="form-control" name="FecVenCUPs_{{$index}}_{{$index}}" id="FecVenCUPs_{{$index}}_{{$index}}" type="text" ng-model="vm.fdatos.detalleCUPs[$index].FecVenCUPs" ng-change="vm.validar_fecha(vm.fdatos.detalleCUPs[$index].FecVenCUPs,$index,dato,2)" maxlength="10" placeholder="DD/MM/YYYY" /></td> 
                    <td><input class="form-control" name="Nr_Audax_3_{{$index}}" id="Nr_Audax_3_{{$index}}" type="text" ng-model="vm.fdatos.detalleCUPs[$index].Nr_Audax" readonly="readonly"/></td>                   
                  </tr>
                </tbody>
                <tfoot> 
                     <th></th>
                    <th>Cliente</th>
                    <th>CIF/NIF</th>
                    <th>Dirección de Suministro</th>
                    <th>Tipo de CUPs</th>
                    <th>CUPs</th>
                    <th>Tárifa</th>
                    <th>Consumo</th>
                    <th>Ren</th>
                    <th>Ahorro €</th>
                    <th>Fecha Activación<br>DD/MM/YYYY</th>
                    <th>Fecha Vencimiento<br>DD/MM/YYYY</th>
                    <th>Nº Contrato Audax</th>      
                </tfoot>
              </table>
        </div>

<!-- INICIO TABLA PARA TIPPROCOM 3 STARTT ///// -->





   <div class="col-12 col-sm-4">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Comercializadora </label>
         <input type="text"  class="form-control" ng-model="vm.CodCom" placeholder="Comercializadora" readonly="readonly"/>
             </div>
             </div>
          </div>
          
          <div class="col-12 col-sm-4">
            <div class="form">                          
             <div class="form-group">   
              <label class="font-weight-bold nexa-dark" style="color:black;">Producto </label>
        <input type="text" class="form-control" ng-model="vm.CodPro" placeholder="Producto" readonly="readonly"/>               
             </div>
             </div>
          </div>  

           <div class="col-12 col-sm-4">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Anexo </label>
        <input type="text"  class="form-control" ng-model="vm.CodAnePro" placeholder="Anexo" readonly="readonly"/>     
             </div>
             </div>
          </div>


          
        <div class="col-12 col-sm-4" id="TipPreClass">
            <div class="form">                          
              <div class="form-group">   
                <label class="font-weight-bold nexa-dark" style="color:black;">Tipo Precio </label>
                <input type="text"  class="form-control" ng-model="vm.TipPre" placeholder="Tipo Precio" readonly="readonly"/>
              </div>
            </div>
        </div>  

      <!--div class="col-12 col-sm-2">
        <div class="form">                          
          <div class="form-group">
            <label class="font-weight-bold nexa-dark" style="color:black;">Fecha de Inicio</label>
            <input type="text" class="form-control datepicker_Inicio" name="FecIniCon" id="FecIniCon" ng-model="vm.FecIniCon" placeholder="DD/MM/YYYY" maxlength="10" ng-keyup="vm.validar_formatos_input(1,vm.FecIniCon)" ng-disabled="vm.fdatos.tipo=='ver'" ng-blur="vm.blurfechachange()"/>         
         </div>
        </div>
      </div-->
      <div class="col-12 col-sm-4" id="FecFirmConClass" ng-show="vm.fdatos.tipo=='ver' || vm.fdatos.tipo=='editar'">
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Fecha Firma</label>
        <input type="text" class="form-control FecFirmCon" name="FecFirmCon" id="FecFirmCon" ng-model="vm.FecFirmCon" placeholder="Fecha de Firma de Contrato" ng-disabled="vm.fdatos.tipo=='ver'" ng-change="vm.validar_formatos_input(17,vm.FecFirmCon)"/>
         
         </div>
         </div>
      </div> 

      <div class="col-12 col-sm-4" id="FecActClass">
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Fecha Activación</label>
        <input type="text" class="form-control FecAct" name="FecAct" id="FecAct" ng-model="vm.FecAct" placeholder="Fecha de Activación" ng-disabled="vm.fdatos.tipo=='ver'" ng-change="vm.validar_formatos_input(19,vm.FecAct)"/>
         
         </div>
         </div>
      </div> 

      <div class="col-12 col-sm-6" id="FecVenConClass">
        <div class="form">                          
          <div class="form-group">
          <label class="font-weight-bold nexa-dark" style="color:black;">Fecha Vencimiento</label>
          <input type="text" class="form-control datepicker_Vencimiento" name="FecVenCon" id="FecVenCon" ng-model="vm.FecVenCon" placeholder="DD/MM/YYYY" maxlength="10" ng-disabled="vm.fdatos.tipo=='ver'" ng-change="vm.validar_formatos_input(18,vm.FecVenCon)"/>
         
         </div>
        </div>
      </div>

      <div class="col-12 col-sm-6" id="DurConClass">
        <div class="form">                          
          <div class="form-group">   
            <label class="font-weight-bold nexa-dark" style="color:black;">Duración </label>          
            <select class="form-control" id="DurCon" name="DurCon" required ng-model="vm.fdatos.DurCon" ng-disabled="vm.fdatos.tipo=='ver'">   
              <option value="12">12 Meses</option>
              <option value="18">18 Meses</option>
              <option value="24">24 Meses</option>
              <option value="36">36 Meses</option>
            </select> 
          </div>
        </div>
      </div>

     <!--div class="col-12 col-sm-6" id="RefConClass">
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Referencia</label>
        <input type="text" class="form-control" name="RefCon" id="RefCon" ng-model="vm.fdatos.RefCon" placeholder="Referencia" ng-disabled="vm.fdatos.tipo=='ver'"/>
         
         </div>
         </div>
      </div-->

         <div class="form">                          
         <div class="form-group">
         <!--label class="font-weight-bold nexa-dark" style="color:black; padding-left:15px">Fotocopia del Contrato <a title='Descargar Documento' ng-show="vm.fdatos.DocConRut!=null && vm.fdatos.CodConCom>0" href="{{vm.fdatos.DocConRut}}" download class="btn btn-info btn-icon mg-r-5"><div><i class="fa fa-download" style="color:white;"></i></div></a></label-->
         <label class="font-weight-bold nexa-dark" style="color:black; padding-left:15px">Agregar Documento </label>
          <div id="file-wrap" style="cursor: pointer">
            <p>Presione para adjuntar el fichero o <strong>arrastrar</strong> el fichero y <strong>soltar</strong> aquí</p>                       
            <input type="file" id="file_fotocopia"  name="file_fotocopia" class="file_b" ng-model="vm.imagen" onchange="angular.element(this).scope().SelectFile(event)" draggable="true">
            <div id="file_fotocopia1"></div>                       
          </div>
        <script>      
        /*$('#file_fotocopia').on('change', function() 
        {          
          const $file_fotocopia = document.querySelector("#file_fotocopia");
          //console.log($file_fotocopia);
          let file_fotocopia = $file_fotocopia.files;                      
          filenameDocCliDoc = '<i class="fa fa-file"> '+$file_fotocopia.files[0].name+'</i>';
          $('#file_fotocopia1').html(filenameDocCliDoc);
         // console.log($file_fotocopia.files[0].name);
        });*/    
      </script> 
         </div>
         </div>
     
         
         <div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive">
                <tbody>
                  <tr>
                    <th> Nombre Documento</th>
                    <th> Acción</th>
                  </tr> 
                  <tr ng-show="vm.fdatos.TDocumentosContratos.length==0"> 
                    <td colspan="2" align="center"><div class="td-usuario-table">No hay información disponible</div></td>
                  </tr>
                  <tr ng-repeat="dato in vm.fdatos.TDocumentosContratos" ng-class-odd="odd">                    
                    <td>{{dato.DocGenCom}}</td>
                    <td >
                      <a title='Ver Archivo {{dato.DocGenCom}}' class="btn btn-info btn-icon mg-r-5" target="_black" href="uploads/{{dato.DocConRut}}"><div><i class="fa fa-eye" style="color:white;"></i></div></a>
                      <a ng-click="vm.borrar_row($index,dato.CodDetDocCon)" title='Eliminar Archivo {{dato.DocGenCom}}' class="btn btn-danger btn-icon mg-r-5"><div><i class="fa fa-trash" style="color:white;"></i></div></a>
                    </td>
                  </tr>
                </tbody>
                <tfoot>
                    <th> Nombre Documento</th>
                    <th> Acción</th>
                </tfoot>
              </table>
        </div>




         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;padding-left:15px">Comentarios</label>
        <textarea class="form-control" name="ObsCon" id="ObsCon" ng-disabled="vm.fdatos.tipo=='ver'" rows="5" placeholder="Comentarios" ng-model="vm.fdatos.ObsCon" ></textarea>        
         </div>
         </div>
            <input class="form-control" id="CodConCom" name="CodConCom" type="hidden" ng-model="vm.fdatos.CodConCom" readonly/>
         

<!--href="http://pdfaudax.local/AudaxPDF/{{vm.CodCli}}/{{vm.CodConCom}}/{{vm.CodProCom}}"-->
         <div class="form-group" >
          <div class="col-12 col-sm-12">
            <button class="btn btn-info" type="submit" ng-show="vm.fdatos.tipo=='nuevo'" ng-disabled="vm.disabled_button==true">Grabar</button>
            <button class="btn btn-success" type="submit" ng-show="vm.fdatos.tipo=='editar'|| vm.fdatos.tipo=='ver'">Actualizar</button>
            
            <button class="btn btn-info" id="showtoast" ng-show="vm.fdatos.TipProCom==1 && vm.fdatos.tipo=='editar'||vm.fdatos.TipProCom==1 &&  vm.fdatos.tipo=='ver'" type="button" ng-click="vm.generar_audax(1)" style="margin-top: 0px;" target="_black" ng-show="vm.fdatos.tipo=='editar' || vm.fdatos.tipo=='ver'">Generar Contrato Audax</button>

            <button class="btn btn-info" id="showtoast2" ng-show="vm.fdatos.TipProCom==2 && vm.fdatos.tipo=='editar'||vm.fdatos.TipProCom==2 &&  vm.fdatos.tipo=='ver'" type="button" ng-click="vm.generar_audax(2)" style="margin-top: 0px;" target="_black" ng-show="vm.fdatos.tipo=='editar' || vm.fdatos.tipo=='ver'">Generar Contrato UniCliente - MultiPunto</button>

            <button class="btn btn-info" id="showtoast3" ng-show="vm.fdatos.TipProCom==3 && vm.fdatos.tipo=='editar'||vm.fdatos.TipProCom==3&&  vm.fdatos.tipo=='ver'" type="button" ng-click="vm.generar_audax(3)" style="margin-top: 0px;" target="_black" ng-show="vm.fdatos.tipo=='editar' || vm.fdatos.tipo=='ver'">Generar Contrato MultiCliente - MultiPunto</button>
            
            <button class="btn btn-info" id="showtoast6" type="button" style="margin-top: 0px;" target="_black" ng-show="vm.fdatos.tipo=='editar' || vm.fdatos.tipo=='ver'" ng-click="vm.generar_contratos_t(vm.fdatos,2)">Generar T2</button>
            <button class="btn btn-info" id="showtoast7" type="button" style="margin-top: 0px;" target="_black" ng-show="vm.fdatos.tipo=='editar' || vm.fdatos.tipo=='ver'" ng-click="vm.generar_contratos_t(vm.fdatos,3)">Generar T3</button>
            <button class="btn btn-info" id="showtoast8" type="button" style="margin-top: 0px;" target="_black" ng-show="vm.fdatos.tipo=='editar' || vm.fdatos.tipo=='ver'" ng-click="vm.generar_contratos_t(vm.fdatos,4)">Generar T4</button>

            <button class="btn btn-danger" id="showtoast4" ng-show="vm.fdatos.tipo=='editar'||vm.fdatos.tipo=='ver'" type="button" ng-click="vm.tramitar_Audax()" style="margin-top: 0px;" target="_black" ng-show="vm.fdatos.tipo=='editar' || vm.fdatos.tipo=='ver'">Tramitar Contrato En Audax</button>

            <a class="btn btn-primary" href="reportes/Exportar_Documentos/Doc_Contrato_Comercial_Cliente_PDF/{{vm.fdatos.CodConCom}}" style="margin-top: 9px;" target="_black" ng-show="vm.fdatos.tipo=='editar' || vm.fdatos.tipo=='ver'">Generar PDF</a>
            

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
          Diseñado por <a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2019 - 2021</a>
        </div>
    </div>
  </section>
  <!-- modal container section end -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_representante_legal" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">{{vm.titulo_modal}}</h4>
          </div>
          <div class="modal-body">
    <div class="panel">                 
      <form class="form-validate" id="frmRepresentanteLegal" name="frmRepresentanteLegal" ng-submit="SubmitFormGenAudax($event)">

    <div class="col-12 col-sm-12" ng-show="vm.List_Firmantes.length>1">
     <div class="form">                          
     <div class="form-group">
      <label class="font-weight-bold nexa-dark" style="color:black;">Quien Firma</label>         
        <select class="form-control" id="List_Firmantes" name="List_Firmantes" ng-model="vm.CodContCli">
          <option ng-repeat="opcion in vm.List_Firmantes" value="{{opcion.CodConCli}}">{{opcion.NIFConCli}} - {{opcion.NomConCli}}</option>
        </select>
     </div>
     </div>
     </div> 

     <div class="col-12 col-sm-12" ng-show="vm.List_Cuentas.length>1">
     <div class="form">                          
     <div class="form-group">
      <label class="font-weight-bold nexa-dark" style="color:black;">Cuentas Bancarias</label>         
        <select class="form-control" id="List_Cuentas" name="List_Cuentas" ng-model="vm.CodCuenBan">
          <option ng-repeat="opcion in vm.List_Cuentas" value="{{opcion.CodCueBan}}">{{opcion.NumIBan}}</option>
        </select>
     </div>
     </div>
     </div>     

     
    <div style="margin-left:15px; ">
     <button class="btn btn-info" type="submit" ng-disabled="frmRepresentanteLegal.$invalid">{{vm.titulo_modal}}</button>
      <!--a class="btn btn-danger" ng-click="vm.regresar_filtro()">Borrar Filtro</a-->
      </div>
</form>
   </div>
    </div>
</div>
</div>
</div>
<!--modal container section end -->
</div>


<script>    
  $('.datepicker_Inicio').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});   
  $('.datepicker_Vencimiento').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});
  $('.FecFirmCon').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});
  $('.FecAct').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});  

  $('.FecVenCUPs_Ele').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true}); 
  $('.FecActCUPs_Ele').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true}); 
  $('.FecVenCUPs_Gas').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true}); 
  $('.FecActCUPs_Gas').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true}); 

</script>
<script type="text/javascript" src="application/libraries/estilos/js/jquery.validate.min.js"></script>
  <script src="application/libraries/estilos/js/form-validation-script.js"></script>
<div id="Guardando" class="loader loader-default"  data-text="Grabando Contrato"></div>
<div id="Actualizando" class="loader loader-default"  data-text="Actualizando Contrato"></div>
<div id="cargando" class="loader loader-default"  data-text="Cargando datos del Contrato"></div>
<div id="DetallesCUPs" class="loader loader-default"  data-text="Cargando Detalles del Contrato"></div>
<div id="subiendo_archivo" class="loader loader-default"  data-text="Subiendo Archivo"></div>
<div id="borrando_archivo" class="loader loader-default"  data-text="Borrando Archivo"></div>
<div id="enviandoaudax" class="loader loader-default"  data-text="Enviando contrato a Audax"></div>
</html>
