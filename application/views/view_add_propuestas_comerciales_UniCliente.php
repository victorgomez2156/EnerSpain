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
 <div ng-controller="Controlador_Add_PropuestasUniCliente as vm">
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header" ng-show="vm.fdatos.tipo=='nueva'">Registro de Propuesta Comercial UniCliente - MultiPunto</h3>
            <h3 class="page-header" ng-show="vm.fdatos.tipo=='ver'">Consultando Propuesta Comercial UniCliente - MultiPunto</h3>
            <h3 class="page-header" ng-show="vm.fdatos.tipo=='renovar'">Renovación de Propuesta Comercial UniCliente - MultiPunto</h3>
            <h3 class="page-header" ng-show="vm.fdatos.tipo=='editar'">Modificando Propuesta Comercial UniCliente - MultiPunto</h3>
          </div>
        </div>
        <!-- Form validations -->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
             
              <div class="panel-body">
    <form id="register_form_uniCliente" name="register_form_uniCliente" ng-submit="submitFormPropuestaUniCliente($event)"> 
      <div class='row'> 
        <div class="col-12 col-sm-4">
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Fecha de la Propuesta</label>
        <input type="text" class="form-control datepicker" name="FecProCom" id="FecProCom" ng-model="vm.FecProCom" placeholder="DD/MM/YYYY" maxlength="10" ng-change="vm.validar_formatos_input(11,vm.FecProCom) " ng-disabled="vm.fdatos.tipo=='ver'||vm.fdatos.tipo=='editar'"/>
         
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
        <span class="foreign-supplier-text" style="color:black;"> Datos del Cliente</span><div align="right" style="margin-top: -16px;"></div>
      </h4>
    </div>

    <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Razón Social / Apellidos, Nombre {{vm.fdatos.CodCli}}</label>
        
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

    <div class="foreign-supplier-title clearfix">
      <h4 class="breadcrumb">     
        <span class="foreign-supplier-text" style="color:black;"> Listado de CUPs</span><div align="right" style="margin-top: -16px;"></div>
      </h4>
    </div>

    <div class="col-12 col-sm-6">
         <div class="form">                          
         <div class="form-group">

          <button type="button" title="Agregar CUPs Eléctrico" style="margin-right: 5px;" class="btn btn-info" ng-click="vm.AgregarCUPs(1)" ng-disabled="vm.fdatos.tipo=='ver'"><div style="color:black;"><i class="fa fa-plus-square"> </i> Agregar <br>CUPs <br>Eléctrico</div></button>

          <button type="button" title="Agregar CUPs Gas" style="margin-right: 5px;" class="btn btn-info" ng-click="vm.AgregarCUPs(2)" ng-disabled="vm.fdatos.tipo=='ver'"><div style="color:black;"><i class="fa fa-plus-square"></i> Agregar <br>CUPs <br>Gas</div></button>

          <button type="button" title="Quitar CUPs" style="margin-right: 5px;" class="btn btn-primary" ng-click="vm.QuitarCUPs()" ng-disabled="vm.fdatos.tipo=='ver'"><div style="color:black;"><i class="fa fa-close"></i> Quitar <br>CUPs {{vm.TDetallesCUPsEli.length}}</div></button>
          </div>
         </div>
      </div>
      <div class="col-12 col-sm-6">
         <div class="form">                          
         <div class="form-group">
          <label class="font-weight-bold nexa-dark" style="color:black;">Cantidad CUPs</label>
        <input type="text" class="form-control" ng-model="vm.CanCups" maxlength="50" readonly="readonly"/>
         </div>
         </div>
      </div>

      <div class="table-responsive">
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
                  </tr>
                  <tr ng-show="vm.fdatos.detalleCUPs.length==0"> 
                     <td colspan="8" align="center"><div class="td-usuario-table">No hay información disponible</div></td>           
                  </tr>
                  <tr ng-repeat="dato in vm.fdatos.detalleCUPs | filter:paginate" ng-class-odd="odd" ng-click="vm.SelecQuitCUPs(dato,$index)">                    
                    <td>{{$index+1}}</td>
                    <td>{{dato.DirPunSum}}</td>
                    <td>
                      <span ng-show="dato.TipServ==1">Eléctrico</span>
                      <span ng-show="dato.TipServ==2">Gas</span>
                    </td>
                    <td>{{dato.CUPsName}}</td>
                    <td>{{dato.NomTar}}</td>
                    <td>{{dato.ConCUPs}}</td>
                    <td><span ng-show="dato.RenCon==false || dato.RenCon=='0'">No</span>
                      <span ng-show="dato.RenCon==true || dato.RenCon=='1'">Si</td>
                    <td>{{dato.ImpAho}}</td>                    
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
                </tfoot>
              </table>
        </div>

    <div class="foreign-supplier-title clearfix">
      <h4 class="breadcrumb">     
        <span class="foreign-supplier-text" style="color:black;">Asignación de Producto</span><div align="right" style="margin-top: -16px;"></div>
      </h4>
    </div>    
    <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Comercializadora </label>
             <select class="form-control" id="CodCom" name="CodCom" required ng-model="vm.fdatos.CodCom" ng-change="vm.realizar_filtro(1,vm.fdatos.CodCom)" ng-disabled="vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'"> 
                <option ng-repeat="dato_act in vm.List_Comercializadora" value="{{dato_act.CodCom}}">{{dato_act.NomComCom}}</option>
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
             <input type="text" ng-model="vm.fdatos.ImpAhoTot" placeholder="0,00 €" readonly />
             <input type="text" ng-model="vm.fdatos.PorAhoTot" placeholder="0,00 €" readonly />
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
            <button class="btn btn-info" type="submit" ng-show="vm.fdatos.tipo=='nueva' || vm.fdatos.tipo=='renovar'" ng-disabled="vm.disabled_button==true" style="color:black;">Grabar</button>
            <button class="btn btn-success" type="submit" ng-show="vm.fdatos.tipo=='editar' && vm.fdatos.EstProCom!='C' || vm.fdatos.tipo=='ver' && vm.fdatos.EstProCom!='C'" style="color:black;">Actualizar</button>

            <a class="btn btn-warning" href="reportes/Exportar_Documentos/Doc_Propuesta_Comercial_UniCliente/{{vm.fdatos.CodProCom}}" style="margin-top: 0px; color:black" target="_black" ng-show="vm.fdatos.tipo=='editar' || vm.fdatos.tipo=='ver'" >Generar PDF</a>
            <button class="btn btn-success" type="button" ng-show="vm.fdatos.tipo=='editar' || vm.fdatos.tipo=='ver'" ng-click="vm.enviarcorreopropuesta()">Enviar Propuesta</button>
            <button class="btn btn-primary" type="button" style="margin-top: 10px; color:black" ng-click="vm.regresar()">Volver</button>
          </div>
        </div>




      </div>
    </form>



              </div>
            </section>
          </div>
        </div>
        <!-- page end-->
      </section>
    </section>
    <!--main content end-->

<!-- modal container section end -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_CUPsElectrico" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Agregar CUPs Eléctrico</h4>
          </div>
          <div class="modal-body">
    <div class="panel">                 
      <form class="form-validate" id="frmCUPsElectrico" name="frmCUPsElectrico" ng-submit="AgregarCUPsElectricoGas($event,1)">

        <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:blue;">CUPs Eléctrico </label>
             <select class="form-control" id="CodCup" name="CodCup" ng-model="vm.fdatos.CodCupSEle" ng-change="vm.CUPsFilter(1,vm.fdatos.CodCupSEle)"> 
                <option ng-repeat="dato_act in vm.List_CUPsEle" value="{{dato_act.CodCupsEle}}">{{dato_act.CUPsEle}}</option>
        </select>     
             </div>
             </div>
          </div>

        <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Dirección </label>
             <input type="text" class="form-control" placeholder="Dirección" ng-model="vm.DirPunSumCUPsEle" readonly />     
             </div>
             </div>
        </div>

        <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">   
              <label class="font-weight-bold nexa-dark" style="color:black;"> Tarifa</label>          
             <select class="form-control" id="CodTarEle" name="CodTarEle" ng-model="vm.fdatos.CodTar" ng-disabled="vm.fdatos.CodCupSEle==undefined || vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'" ng-change="vm.filtrerCanPeriodos(vm.fdatos.CodTar)"> 
                <option ng-repeat="dato_act in vm.List_TarEle" value="{{dato_act.CodTarEle}}">{{dato_act.NomTarEle}}</option>
              </select>                  
             </div>
             </div>
          </div>
           <!-- Start Cantidad de Periodos 5 start-->
        <div ng-show="vm.CanPerTar==1">
          <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Pot 1 </label>
             <input type="text" class="form-control" ng-change="vm.validar_formatos_input(1,vm.fdatos.PotEleConP1)" placeholder="PotEleConP1" ng-model="vm.fdatos.PotEleConP1"/>     
             </div>
             </div>
        </div>     
       
        </div>
      <!-- Start Cantidad de Periodos 1 end-->  
           <!-- Start Cantidad de Periodos 2 start-->
        <div ng-show="vm.CanPerTar==2">
          <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Pot 1 </label>
             <input type="text" class="form-control" ng-change="vm.validar_formatos_input(1,vm.fdatos.PotEleConP1)" placeholder="PotEleConP1" ng-model="vm.fdatos.PotEleConP1"/>     
             </div>
             </div>
        </div>
        <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Pot 2 </label>
             <input type="text" class="form-control" ng-change="vm.validar_formatos_input(2,vm.fdatos.PotEleConP2)" placeholder="PotEleConP2" ng-model="vm.fdatos.PotEleConP2"/>     
             </div>
             </div>
        </div>        
       
        </div>
      <!-- Start Cantidad de Periodos 2 end-->  

           <!-- Start Cantidad de Periodos 3 start-->
        <div ng-show="vm.CanPerTar==3">
          <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Pot 1 </label>
             <input type="text" class="form-control" ng-change="vm.validar_formatos_input(1,vm.fdatos.PotEleConP1)" placeholder="PotEleConP1" ng-model="vm.fdatos.PotEleConP1"/>     
             </div>
             </div>
        </div>
        <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Pot 2 </label>
             <input type="text" class="form-control" ng-change="vm.validar_formatos_input(2,vm.fdatos.PotEleConP2)" placeholder="PotEleConP2" ng-model="vm.fdatos.PotEleConP2"/>     
             </div>
             </div>
        </div>
        <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Pot 3 </label>
             <input type="text" class="form-control" ng-change="vm.validar_formatos_input(3,vm.fdatos.PotEleConP3)" placeholder="PotEleConP3" ng-model="vm.fdatos.PotEleConP3"/>     
             </div>
             </div>
        </div>
       
       
        </div>
      <!-- Start Cantidad de Periodos 3 end-->  


           <!-- Start Cantidad de Periodos 4 start-->
        <div ng-show="vm.CanPerTar==4">
          <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Pot 1 </label>
             <input type="text" class="form-control" ng-change="vm.validar_formatos_input(1,vm.fdatos.PotEleConP1)" placeholder="PotEleConP1" ng-model="vm.fdatos.PotEleConP1"/>     
             </div>
             </div>
        </div>
        <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Pot 2 </label>
             <input type="text" class="form-control" ng-change="vm.validar_formatos_input(2,vm.fdatos.PotEleConP2)" placeholder="PotEleConP2" ng-model="vm.fdatos.PotEleConP2"/>     
             </div>
             </div>
        </div>
        <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Pot 3 </label>
             <input type="text" class="form-control" ng-change="vm.validar_formatos_input(3,vm.fdatos.PotEleConP3)" placeholder="PotEleConP3" ng-model="vm.fdatos.PotEleConP3"/>     
             </div>
             </div>
        </div>
        <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Pot 4</label>
             <input type="text" class="form-control" ng-change="vm.validar_formatos_input(4,vm.fdatos.PotEleConP4)" placeholder="PotEleConP4" ng-model="vm.fdatos.PotEleConP4"/>     
             </div>
             </div>
        </div>
        
       
        </div>
      <!-- Start Cantidad de Periodos 4 end-->  

        <!-- Start Cantidad de Periodos 5 start-->
        <div ng-show="vm.CanPerTar==5">
          <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Pot 1 </label>
             <input type="text" class="form-control" ng-change="vm.validar_formatos_input(1,vm.fdatos.PotEleConP1)" placeholder="PotEleConP1" ng-model="vm.fdatos.PotEleConP1"/>     
             </div>
             </div>
        </div>
        <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Pot 2 </label>
             <input type="text" class="form-control" ng-change="vm.validar_formatos_input(2,vm.fdatos.PotEleConP2)" placeholder="PotEleConP2" ng-model="vm.fdatos.PotEleConP2"/>     
             </div>
             </div>
        </div>
        <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Pot 3 </label>
             <input type="text" class="form-control" ng-change="vm.validar_formatos_input(3,vm.fdatos.PotEleConP3)" placeholder="PotEleConP3" ng-model="vm.fdatos.PotEleConP3"/>     
             </div>
             </div>
        </div>
        <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Pot 4</label>
             <input type="text" class="form-control" ng-change="vm.validar_formatos_input(4,vm.fdatos.PotEleConP4)" placeholder="PotEleConP4" ng-model="vm.fdatos.PotEleConP4"/>     
             </div>
             </div>
        </div>
        <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Pot 5 </label>
             <input type="text" class="form-control" ng-change="vm.validar_formatos_input(5,vm.fdatos.PotEleConP5)" placeholder="PotEleConP5" ng-model="vm.fdatos.PotEleConP5"/>     
             </div>
             </div>
        </div>
       
        </div>
      <!-- Start Cantidad de Periodos 5 end-->   

        <!-- Start Cantidad de Periodos 6 start-->
        <div ng-show="vm.CanPerTar==6">
          <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Pot 1 </label>
             <input type="text" class="form-control" ng-change="vm.validar_formatos_input(1,vm.fdatos.PotEleConP1)" placeholder="PotEleConP1" ng-model="vm.fdatos.PotEleConP1"/>     
             </div>
             </div>
        </div>
        <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Pot 2 </label>
             <input type="text" class="form-control" ng-change="vm.validar_formatos_input(2,vm.fdatos.PotEleConP2)" placeholder="PotEleConP2" ng-model="vm.fdatos.PotEleConP2"/>     
             </div>
             </div>
        </div>
        <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Pot 3 </label>
             <input type="text" class="form-control" ng-change="vm.validar_formatos_input(3,vm.fdatos.PotEleConP3)" placeholder="PotEleConP3" ng-model="vm.fdatos.PotEleConP3"/>     
             </div>
             </div>
        </div>
        <div class="col-12 col-sm-4">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Pot 4</label>
             <input type="text" class="form-control" ng-change="vm.validar_formatos_input(4,vm.fdatos.PotEleConP4)" placeholder="PotEleConP4" ng-model="vm.fdatos.PotEleConP4"/>     
             </div>
             </div>
        </div>
        <div class="col-12 col-sm-4">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Pot 5 </label>
             <input type="text" class="form-control" ng-change="vm.validar_formatos_input(5,vm.fdatos.PotEleConP5)" placeholder="PotEleConP5" ng-model="vm.fdatos.PotEleConP5"/>     
             </div>
             </div>
        </div>
        <div class="col-12 col-sm-4">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Pot 6 </label>
             <input type="text" class="form-control" ng-change="vm.validar_formatos_input(6,vm.fdatos.PotEleConP6)" placeholder="PotEleConP6" ng-model="vm.fdatos.PotEleConP6"/>     
             </div>
             </div>
        </div>
        </div>
      <!-- Start Cantidad de Periodos 6 end-->
        



        <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Consumo </label>
             <input type="text" class="form-control" ng-change="vm.validar_formatos_input(7,vm.fdatos.ConCup)" placeholder="Consumo Eléctrico" ng-model="vm.fdatos.ConCup"/>     
             </div>
             </div>
        </div>

        <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Ahorro € </label>
             <input type="text" class="form-control" ng-change="vm.validar_formatos_input(8,vm.fdatos.ImpAho)" placeholder="Ahorro €" ng-model="vm.fdatos.ImpAho"/>     
             </div>
             </div>
        </div>

        <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">% </label>
             <input type="text" class="form-control" ng-change="vm.validar_formatos_input(9,vm.fdatos.PorAho)" placeholder="Porcentaje" ng-model="vm.fdatos.PorAho"/>     
             </div>
             </div>
        </div>

        <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Ren </label>
             <input type="checkbox" class="form-control" placeholder="Renovación CUPs" ng-model="vm.fdatos.RenCup"/>     
             </div>
             </div>
        </div>



      <div class="form" >                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:black;"> Observación</label>    
        <textarea class="form-control" style="display: inline-block;" onkeyup="this.value=this.value.toUpperCase();" minlength="1" maxlength="200" rows="5" ng-disabled="vm.fdatos.EstProCom=='C'" placeholder="Observaciónes Generales" ng-model="vm.fdatos.ObsCup"></textarea>        
       </div>
       </div>     
    <div style="margin-left:15px; ">
     <button class="btn btn-info" type="submit" ng-disabled="frmCUPsElectrico.$invalid">Confirmar</button>
      <a class="btn btn-danger" data-dismiss="modal">Volver</a>
      </div>
</form>


   </div>
    </div>
</div>
</div>
</div>
<!--modal container section end -->


<!-- modal container section end -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_CUPsGas" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Agregar CUPs Gas</h4>
          </div>
          <div class="modal-body">
    <div class="panel">                 
      <form class="form-validate" id="frmCUPsGas" name="frmCUPsGas" ng-submit="AgregarCUPsElectricoGas($event,2)">

        <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:blue;">CUPs Gas </label>
             <select class="form-control" id="CodCupGas" name="CodCupGas" ng-model="vm.fdatos.CodCupSGas" ng-change="vm.CUPsFilter(2,vm.fdatos.CodCupSGas)"> 
                <option ng-repeat="dato_act in vm.List_CUPsGas" value="{{dato_act.CodCupGas}}">{{dato_act.CupsGas}}</option>
        </select>     
             </div>
             </div>
          </div>

        <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Dirección </label>
             <input type="text" class="form-control" placeholder="Dirección" ng-model="vm.DirPunSumCUPsGas" readonly />     
             </div>
             </div>
        </div>

        <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">   
              <label class="font-weight-bold nexa-dark" style="color:black;"> Tarifa</label>          
             <select class="form-control" id="CodTarGas" name="CodTarGas" ng-model="vm.fdatos.CodTar" ng-disabled="vm.fdatos.CodCupSGas==undefined || vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'"> 
                <option ng-repeat="dato_act in vm.List_TarGas" value="{{dato_act.CodTarGas}}">{{dato_act.NomTarGas}}</option>
              </select>                  
             </div>
             </div>
          </div>

          <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Caudal Diario </label>
             <input type="text" class="form-control" ng-change="vm.validar_formatos_input(10,vm.fdatos.CauDiaGas)" placeholder="Caudal Diario" ng-model="vm.fdatos.CauDiaGas"/>     
             </div>
             </div>
        </div> 

        <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Consumo </label>
             <input type="text" class="form-control" ng-change="vm.validar_formatos_input(7,vm.fdatos.ConCup)" placeholder="Consumo Gas" ng-model="vm.fdatos.ConCup"/>     
             </div>
             </div>
        </div>

        <div class="col-12 col-sm-4">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Ahorro € </label>
             <input type="text" class="form-control" ng-change="vm.validar_formatos_input(8,vm.fdatos.ImpAho)" placeholder="Ahorro €" ng-model="vm.fdatos.ImpAho"/>     
             </div>
             </div>
        </div>

        <div class="col-12 col-sm-4">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">% </label>
             <input type="text" class="form-control" ng-change="vm.validar_formatos_input(9,vm.fdatos.PorAho)" placeholder="Porcentaje" ng-model="vm.fdatos.PorAho"/>     
             </div>
             </div>
        </div>

        <div class="col-12 col-sm-4">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Ren </label>
             <input type="checkbox" class="form-control" placeholder="Renovación CUPs" ng-model="vm.fdatos.RenCup"/>     
             </div>
             </div>
        </div>



      <div class="form" >                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:black;"> Observación</label>    
        <textarea class="form-control" style="display: inline-block;" onkeyup="this.value=this.value.toUpperCase();" minlength="1" maxlength="200" rows="5" ng-disabled="vm.fdatos.EstProCom=='C'" placeholder="Observaciónes Generales" ng-model="vm.fdatos.ObsCup"></textarea>        
       </div>
       </div> 





    
    <div style="margin-left:15px; ">
     <button class="btn btn-info" type="submit" ng-disabled="frmCUPsGas.$invalid">Confirmar</button>
      <a class="btn btn-danger" data-dismiss="modal">Volver</a>
      </div>
</form>


   </div>
    </div>
</div>
</div>
</div>
<!--modal container section end -->
     <div class="text-right">
      <div class="credits">
          <!--
            All the links in the footer should remain intact.
            You can delete the links only if you purchased the pro version.
            Licensing information: https://bootstrapmade.com/license/
            Purchase the pro version form: https://bootstrapmade.com/buy/?theme=NiceAdmin
          -->
          Diseñado por <a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2020</a>
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
<div id="enviando" class="loader loader-default"  data-text="Enviando Propuesta Comercial"></div>
</html>
