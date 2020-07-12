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

.datepicker{z-index:1151 !important;}
</style>
<body>
 <div ng-controller="Controlador_Rueda as vm">
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header">Reporte Rueda</h3>
           
          </div>
        </div>
        <!-- Form validations -->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
             
              <div class="panel-body">


<form id="form_rueda" name="form_rueda" ng-submit="submitFormRueda($event)"> 
     <div class='row'>              
     
      <div class="col-12 col-sm-6">
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Fecha Desde</label>
       <input type="text" class="form-control FecDesde" name="FecDesde" id="FecDesde" ng-model="vm.FecDesde" placeholder="DD/MM/YYYY" maxlength="10" ng-change="vm.validar_formatos_input(1,vm.FecDesde) "/>
         
         </div>
         </div>
      </div>

       <div class="col-12 col-sm-6">
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Fecha Hasta</label>
       <input type="text" class="form-control FecHasta" name="FecHasta" id="FecHasta" ng-model="vm.FecHasta" placeholder="DD/MM/YYYY" maxlength="10" ng-change="vm.validar_formatos_input(2,vm.FecHasta) "/>
         
         </div>
         </div>
      </div>

        <div class="form" align="center">                          
         <div class="form-group">
         <button class="btn btn-info" type="submit">Generar Rueda <!--div ng-show="vm.Table_Contratos.length>0">{{vm.Table_Contratos.length}}</div></button-->           
         </div>
         </div>
          

  </div><!--FINAL ROW -->
        </form>
<div ng-show="vm.Table_Contratos.length>0">
  <a class="btn btn-primary" href="reportes/Exportar_Documentos/Doc_Reporte_Rueda_PDF/{{vm.FecDesde}}/{{vm.FecHasta}}" style="margin-top: 0px;" target="_black" >Ver PDF</a> 
<a class="btn btn-primary" href="reportes/Exportar_Documentos/Doc_Reporte_Rueda_Excel/{{vm.FecDesde}}/{{vm.FecHasta}}" style="margin-top: 0px;" target="_black" >Ver Excel</a>

<label style="margin-top: 0px;">Total: {{vm.Table_Contratos.length}}</label>

<div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive">
                <tbody>
                  <tr>
                  <th>Fecha Inicio</th>
                  <th>CODCLI</th>
                  <th>NIF</th>
                  <th>Cliente</th>
                  <th>NIF</th>
                  <th>Comercializadora</th>
                  <th>Anexo</th> 
                  <th>Duración</th>  
                  <th>Vencimiento</th>
                  <th>Estatus</th>              
                  <th>Acción</th>
                  </tr>
                  <tr ng-show="vm.Table_Contratos.length==0"> 
                    <td colspan="8" align="center">
                      <div class="td-usuario-table"><i class="fa fa-close"></i> No existe información.</div>
                    </td>           
                    </tr>
                  <tr ng-repeat="dato in vm.Table_Contratos | filter:paginate" ng-class-odd="odd">                    
                    <td >{{dato.FecIniCon}}</td>
                    <td >{{dato.CodCli}}</td>
                    <td >{{dato.NumCifCli}}</td>
                    <td >{{dato.RazSocCli}}</td>
                    <td >{{dato.NumCifCom}}</td>
                    <td >{{dato.RazSocCom}}</td>
                    <td >{{dato.Anexo}}</td> 
                    <td >{{dato.DurCon}} Meses</td> 
                    <td >{{dato.FecVenCon}}</td>
                    <td >
                      <span class="label label-success" ng-show="dato.EstBajCon==0"><i class="fa fa-check-circle"></i> Activo</span>
                      <span class="label label-danger" ng-show="dato.EstBajCon==1"><i class="fa fa-ban"></i> Dado de Baja</span>
                      <span class="label label-info" ng-show="dato.EstBajCon==2"><i class="fa fa-close"></i> Vencido</span>
                      <span class="label label-primary" ng-show="dato.EstBajCon==3"><i class="fa fa-check-circle"></i> Renovado</span>
                      <span class="label label-warning" ng-show="dato.EstBajCon==4"><i class="fa fa-check-clock-o"></i> En Renovación</span>
						<span class="label label-danger" ng-show="dato.CodProCom==null"><i class="fa fa-ban"></i> S/P/C</span>
                      
                   </td>
                    <td >
                      <div class="btn-group">
                        <select class="form-control" id="opcion_select" style="width: auto;" name="opcion_select" ng-model="vm.opcion_select[$index]" ng-change="vm.validar_opcion_rueda($index,vm.opcion_select[$index],dato)">
                          <option ng-repeat="opcion in vm.opcion_rueda" value="{{opcion.id}}">{{opcion.nombre}}</option>
                        </select>
                      </div>
                    </td>

                  </tr>
                </tbody>
                <tfoot>                 
                  <th>Fecha Inicio</th>
                  <th>CODCLI</th>
                  <th>NIF</th>
                  <th>Cliente</th>
                  <th>NIF</th>
                  <th>Comercializadora</th>
                  <th>Anexo</th> 
                  <th>Duración</th>  
                  <th>Vencimiento</th>
                  <th>Estatus</th>              
                  <th>Acción</th>
                </tfoot>
              </table>
        </div>
        <div align="center">          
          <div class='btn-group' align="center">
            <pagination total-items="totalItems" ng-model="currentPage" max-size="5" boundary-links="true" items-per-page="numPerPage" class="pagination-sm">  
            </pagination>
          </div>
        </div>
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

<!-- modal container section end -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="Tipo_Renovacion" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Tipo Renovación Contrato</h4>
          </div>
          <div class="modal-body">
                        <div class="panel">                  
    
    <form class="form-validate" id="frmRenovacion" name="frmRenovacion" ng-submit="SubmitFormRenovacion($event)">                 
     <input type="hidden" class="form-control" ng-model="vm.tmodal_data.CodCli" name="CodCliModalReno" id="CodCliModalReno" readonly="readonly" />
     <input type="hidden" class="form-control" ng-model="vm.tmodal_data.CodProCom" name="CodProComModalReno" id="CodProComModalReno" readonly="readonly" />
     <input type="hidden" class="form-control" ng-model="vm.tmodal_data.CodConCom" name="CodConComModalReno" id="CodConComModalReno" readonly="readonly" />

    <div class="col-12 col-sm-12">
     <div class="form">                          
     <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:black;">Razón Social</label>
        <input type="text" class="form-control" ng-model="vm.RazSocCli" readonly/>
     </div>
     </div>
     </div>

      <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:black;">Comercializadora</label>
        <input type="text" class="form-control" ng-model="vm.CodCom" readonly/>
     </div>
     </div>
     </div>

      <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:black;">Anexo</label>
        <input type="text" class="form-control" ng-model="vm.Anexo" readonly/>
     </div>
     </div>
     </div>

     <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:black;">Sin Modificaciones</label>
        <input type="checkbox" class="form-control" ng-model="vm.tmodal_data.SinMod" name="SinMod" id="SinMod" ng-disabled="vm.tmodal_data.ConMod==true"/>
     </div>
     </div>
     </div>

    <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:black;">Con Modificaciones</label>
        <input type="checkbox" class="form-control" ng-model="vm.tmodal_data.ConMod" ng-disabled="vm.tmodal_data.SinMod==true" name="ConMod" id="ConMod"/>

     </div>
     </div>
     </div>


     <div class="col-12 col-sm-6" ng-show="vm.tmodal_data.SinMod==true">
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Fecha de Inicio</label>
        <input type="text" class="form-control FecIniCon" name="FecIniCon" id="FecIniCon" ng-model="vm.FecIniCon" placeholder="DD/MM/YYYY" maxlength="10" ng-change="vm.validar_formatos_input(3,vm.FecIniCon)"/>
         
         </div>
         </div>
      </div>


        <div class="col-12 col-sm-6" ng-show="vm.tmodal_data.SinMod==true">
            <div class="form">                          
             <div class="form-group">   
              <label class="font-weight-bold nexa-dark" style="color:black;">Duración </label>          
             <select class="form-control" id="DurCon" name="DurCon" ng-model="vm.tmodal_data.DurCon">   
                <option value="12">12 Meses</option>
                <option value="18">18 Meses</option>
                <option value="24">24 Meses</option>
                <option value="36">36 Meses</option>
        </select> 
                       
             </div>
             </div>
          </div>

     <div align="center">
        <button class="btn btn-info" type="submit" ng-disabled="frmRenovacion.$invalid">Solicitar</button>
      </div>
</form>
   </div>
    </div>
</div>
</div>
</div>
<!--modal container section end -->
<!-- modal container section start -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="Form_PropuestaComercial" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Asignar Propuesta Comercial</h4>
          </div>
          <div class="modal-body" style="height: 500px; overflow-y: scroll; ">
    <div class="panel">                  
    
    <form class="form-validate" id="Form_PropuestaComercial_Form" name="Form_PropuestaComercial_Form" ng-submit="SubmitFormAsignarPropuesta($event)" >                 
    
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
        <input type="text" class="form-control FecProCom" name="FecProCom" id="FecProCom" ng-model="vm.FecProCom" placeholder="DD/MM/YYYY" maxlength="10" ng-change="vm.validar_formatos_input(4,vm.FecProCom) " ng-disabled="vm.fdatos.tipo=='ver'||vm.fdatos.tipo=='editar'"/>
         
         </div>
         </div>
      </div>

      <div class="col-12 col-sm-4">
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Nº Propuesta</label>
        <input type="text" class="form-control" ng-model="vm.fdatos.RefProCom" ng-disabled="vm.disabled_status==true" placeholder="0000000001" readonly maxlength="10"/>
         
         </div>
         </div>
      </div>

    <div class="col-12 col-sm-4">
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Estatus</label>
          
        <select class="form-control" id="EstProCom" name="EstProCom" ng-model="vm.fdatos.EstProCom" ng-disabled="vm.disabled_status==true">
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
       <select class="form-control" id="CodPunSum" name="CodPunSum" ng-model="vm.fdatos.CodPunSum" ng-change="vm.filter_DirPumSum(vm.fdatos.CodPunSum)" ng-disabled="vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'"> 
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
    
    <div class="col-12 col-sm-4">
            <div class="form">                          
             <div class="form-group">   
              <label class="font-weight-bold nexa-dark" style="color:black;">Povincia </label>          
             <input type="text" class="form-control" ng-model="vm.DesProPumSum" placeholder="Provincia" readonly/>     
             </div>
             </div>
    </div>

    <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">Código Postal </label>         
             <input type="text"  class="form-control" ng-model="vm.CPLocPumSum" placeholder="Código Postal" readonly/>     
             </div>
             </div>
    </div>  

<!--- PARA LOS CUPS ELECTRICOS START-->
        <div >
          <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:blue;">CUPs Eléctrico</label>
             <select class="form-control" id="CodCupSEle" name="CodCupSEle" ng-model="vm.fdatos.CodCupSEle" ng-change="vm.CUPsFilter(1,vm.fdatos.CodCupSEle)" ng-disabled="vm.fdatos.CodPunSum==undefined|| vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'"> 
                <option ng-repeat="dato_act in vm.List_CUPsEle" value="{{dato_act.CodCupsEle}}">{{dato_act.CUPsEle}}</option>
        </select>     
             </div>
             </div>
          </div>
          
          <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">   
              <label class="font-weight-bold nexa-dark" style="color:black;"> Tarifa</label>          
             <select class="form-control" id="CodTarEle" name="CodTarEle" ng-model="vm.fdatos.CodTarEle" ng-disabled="vm.fdatos.CodCupSEle==undefined" ng-change="vm.filtrerCanPeriodos(vm.fdatos.CodTarEle)"> 
                <option ng-repeat="dato_act in vm.List_TarEle" value="{{dato_act.CodTarEle}}">{{dato_act.NomTarEle}}</option>
        </select>                  
             </div>
             </div>
          </div>        

<div ng-show="vm.CanPerEle==6">
          
        <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P1 </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PotConP1" placeholder="P1" ng-disabled="vm.fdatos.CodCupSEle==undefined" ng-change="vm.validar_formatos_input(5,vm.fdatos.PotConP1)"/>     
             </div>
             </div>
        </div>

           <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P2 </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PotConP2" placeholder="P2" ng-disabled="vm.fdatos.CodCupSEle==undefined" ng-change="vm.validar_formatos_input(6,vm.fdatos.PotConP2)"/>     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P3 </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PotConP3" placeholder="P3" ng-disabled="vm.fdatos.CodCupSEle==undefined" ng-change="vm.validar_formatos_input(7,vm.fdatos.PotConP3)"/>     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P4 </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PotConP4" placeholder="P4" ng-disabled="vm.fdatos.CodCupSEle==undefined" ng-change="vm.validar_formatos_input(8,vm.fdatos.PotConP4)"/>     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P5 </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PotConP5" placeholder="P5" ng-disabled="vm.fdatos.CodCupSEle==undefined" ng-change="vm.validar_formatos_input(9,vm.fdatos.PotConP5)"/>     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P6 </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PotConP6" placeholder="P6" ng-disabled="vm.fdatos.CodCupSEle==undefined" ng-change="vm.validar_formatos_input(10,vm.fdatos.PotConP6)"/>     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">Ahorro (€)</label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.ImpAhoEle" placeholder="Ahorro (€)" ng-disabled="vm.fdatos.CodCupSEle==undefined" ng-change="vm.validar_formatos_input(11,vm.fdatos.ImpAhoEle)"/>     
             </div>
             </div>
          </div>
    

  <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">% </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PorAhoEle" placeholder="%" ng-disabled="vm.fdatos.CodCupSEle==undefined" ng-change="vm.validar_formatos_input(12,vm.fdatos.PorAhoEle)"/>     
             </div>
             </div>
  </div>

  <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">Renovación </label>         
             <input type="checkbox"  class="form-control" style="margin-top: -1px;" ng-model="vm.fdatos.RenConEle" ng-disabled="vm.fdatos.CodCupSEle==undefined || vm.disabled_status==true"/>     
             </div>
             </div>
  </div>
  
  <div class="col-12 col-sm-3">
      <div class="form" >                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:black;">Observación </label>
        <textarea class="form-control" style="display: inline-block;" onkeyup="this.value=this.value.toUpperCase();" minlength="1" maxlength="200" rows="5" placeholder="Observación" ng-model="vm.fdatos.ObsAhoEle" ng-disabled="vm.fdatos.CodCupSEle==undefined"></textarea>        
       </div>
      </div> 
  </div>
</div>

<div ng-show="vm.CanPerEle==1">
  
  <div class="col-12 col-sm-6">
    <div class="form">                          
      <div class="form-group">    
        <label class="font-weight-bold nexa-dark" style="color:black;">P1 </label>         
        <input type="text"  class="form-control" ng-model="vm.fdatos.PotConP1" placeholder="P1" ng-disabled="vm.fdatos.CodCupSEle==undefined" ng-change="vm.validar_formatos_input(5,vm.fdatos.PotConP1)"/>     
      </div>
    </div>
  </div>

          <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">Ahorro (€)</label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.ImpAhoEle" placeholder="Ahorro (€)" ng-disabled="vm.fdatos.CodCupSEle==undefined" ng-change="vm.validar_formatos_input(11,vm.fdatos.ImpAhoEle)"/>     
             </div>
             </div>
          </div>

          <div class="col-12 col-sm-4">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">% </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PorAhoEle" placeholder="%" ng-disabled="vm.fdatos.CodCupSEle==undefined" ng-change="vm.validar_formatos_input(12,vm.fdatos.PorAhoEle)"/>     
             </div>
             </div>
          </div>

        <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">Renovación </label>         
             <input type="checkbox"  class="form-control" style="margin-top: -1px;" ng-model="vm.fdatos.RenConEle" ng-disabled="vm.fdatos.CodCupSEle==undefined || vm.disabled_status==true"/>     
             </div>
             </div>
  </div>
  
  <div class="col-12 col-sm-4">
      <div class="form" >                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:black;">Observación </label>
        <textarea class="form-control" style="display: inline-block;" onkeyup="this.value=this.value.toUpperCase();" minlength="1" maxlength="200" rows="5" placeholder="Observación" ng-model="vm.fdatos.ObsAhoEle" ng-disabled="vm.fdatos.CodCupSEle==undefined"></textarea>        
       </div>
      </div> 
  </div>




</div>

  <div ng-show="vm.CanPerEle==2">

          <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P1 </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PotConP1" placeholder="P1" ng-disabled="vm.fdatos.CodCupSEle==undefined" ng-change="vm.validar_formatos_input(5,vm.fdatos.PotConP1)"/>     
             </div>
             </div>
          </div>

            <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P2 </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PotConP2" placeholder="P2" ng-disabled="vm.fdatos.CodCupSEle==undefined" ng-change="vm.validar_formatos_input(6,vm.fdatos.PotConP2)"/>     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">Ahorro (€)</label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.ImpAhoEle" placeholder="Ahorro (€)" ng-disabled="vm.fdatos.CodCupSEle==undefined" ng-change="vm.validar_formatos_input(11,vm.fdatos.ImpAhoEle)"/>     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">% </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PorAhoEle" placeholder="%" ng-disabled="vm.fdatos.CodCupSEle==undefined" ng-change="vm.validar_formatos_input(12,vm.fdatos.PorAhoEle)"/>     
             </div>
             </div>
          </div>

         <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">Renovación </label>         
             <input type="checkbox"  class="form-control" style="margin-top: -1px;" ng-model="vm.fdatos.RenConEle" ng-disabled="vm.fdatos.CodCupSEle==undefined || vm.disabled_status==true"/>     
             </div>
             </div>
  </div>
  
  <div class="col-12 col-sm-6">
      <div class="form" >                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:black;">Observación </label>
        <textarea class="form-control" style="display: inline-block;" onkeyup="this.value=this.value.toUpperCase();" minlength="1" maxlength="200" rows="5" placeholder="Observación" ng-model="vm.fdatos.ObsAhoEle" ng-disabled="vm.fdatos.CodCupSEle==undefined"></textarea>        
       </div>
      </div> 
  </div>

  </div>

  <div ng-show="vm.CanPerEle==3">
          
          <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P1 </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PotConP1" placeholder="P1" ng-disabled="vm.fdatos.CodCupSEle==undefined" ng-change="vm.validar_formatos_input(5,vm.fdatos.PotConP1)"/>     
             </div>
             </div>
          </div>
           <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P2 </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PotConP2" placeholder="P2" ng-disabled="vm.fdatos.CodCupSEle==undefined" ng-change="vm.validar_formatos_input(6,vm.fdatos.PotConP2)"/>     
             </div>
             </div>
          </div>
           <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P3 </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PotConP3" placeholder="P3" ng-disabled="vm.fdatos.CodCupSEle==undefined" ng-change="vm.validar_formatos_input(7,vm.fdatos.PotConP3)"/>     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">Ahorro (€)</label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.ImpAhoEle" placeholder="Ahorro (€)" ng-disabled="vm.fdatos.CodCupSEle==undefined" ng-change="vm.validar_formatos_input(11,vm.fdatos.ImpAhoEle)"/>     
             </div>
             </div>
          </div>

          <div class="col-12 col-sm-4">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">% </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PorAhoEle" placeholder="%" ng-disabled="vm.fdatos.CodCupSEle==undefined" ng-change="vm.validar_formatos_input(12,vm.fdatos.PorAhoEle)"/>     
             </div>
             </div>
          </div>

          <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">Renovación </label>         
             <input type="checkbox"  class="form-control" style="margin-top: -1px;" ng-model="vm.fdatos.RenConEle" ng-disabled="vm.fdatos.CodCupSEle==undefined || vm.disabled_status==true"/>     
             </div>
             </div>
  </div>
  
  <div class="col-12 col-sm-4">
      <div class="form" >                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:black;">Observación </label>
        <textarea class="form-control" style="display: inline-block;" onkeyup="this.value=this.value.toUpperCase();"  minlength="1" maxlength="200" rows="5" placeholder="Observación" ng-model="vm.fdatos.ObsAhoEle" ng-disabled="vm.fdatos.CodCupSEle==undefined"></textarea>        
       </div>
      </div> 
  </div>



  </div>

  <div ng-show="vm.CanPerEle==4">
          
          <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P1 </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PotConP1" placeholder="P1" ng-disabled="vm.fdatos.CodCupSEle==undefined" ng-change="vm.validar_formatos_input(5,vm.fdatos.PotConP1)"/>     
             </div>
             </div>
          </div>
           <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P2 </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PotConP2" placeholder="P2" ng-disabled="vm.fdatos.CodCupSEle==undefined" ng-change="vm.validar_formatos_input(6,vm.fdatos.PotConP2)"/>     
             </div>
             </div>
          </div>
           <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P3 </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PotConP3" placeholder="P3" ng-disabled="vm.fdatos.CodCupSEle==undefined" ng-change="vm.validar_formatos_input(7,vm.fdatos.PotConP3)"/>     
             </div>
             </div>
          </div>
           <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P4 </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PotConP4" placeholder="P4" ng-disabled="vm.fdatos.CodCupSEle==undefined" ng-change="vm.validar_formatos_input(8,vm.fdatos.PotConP4)"/>     
             </div>
             </div>
          </div>

           <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">Ahorro (€)</label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.ImpAhoEle" placeholder="Ahorro (€)" ng-disabled="vm.fdatos.CodCupSEle==undefined" ng-change="vm.validar_formatos_input(11,vm.fdatos.ImpAhoEle)"/>     
             </div>
             </div>
          </div>


             <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">% </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PorAhoEle" placeholder="%" ng-disabled="vm.fdatos.CodCupSEle==undefined" ng-change="vm.validar_formatos_input(12,vm.fdatos.PorAhoEle)"/>     
             </div>
             </div>
          </div>

         <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">Renovación </label>         
             <input type="checkbox"  class="form-control" style="margin-top: -1px;" ng-model="vm.fdatos.RenConEle" ng-disabled="vm.fdatos.CodCupSEle==undefined || vm.disabled_status==true"/>     
             </div>
             </div>
  </div>
  
  <div class="col-12 col-sm-3">
      <div class="form" >                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:black;">Observación </label>
        <textarea class="form-control" style="display: inline-block;" onkeyup="this.value=this.value.toUpperCase();" minlength="1" maxlength="200" rows="5" placeholder="Observación" ng-model="vm.fdatos.ObsAhoEle" ng-disabled="vm.fdatos.CodCupSEle==undefined"></textarea>        
       </div>
      </div> 
  </div>


  </div>

  <div ng-show="vm.CanPerEle==5">
          
          <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P1 </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PotConP1" placeholder="P1" ng-disabled="vm.fdatos.CodCupSEle==undefined" ng-change="vm.validar_formatos_input(5,vm.fdatos.PotConP1)"/>     
             </div>
             </div>
          </div>
           <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P2 </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PotConP2" placeholder="P2" ng-disabled="vm.fdatos.CodCupSEle==undefined" ng-change="vm.validar_formatos_input(6,vm.fdatos.PotConP2)"/>     
             </div>
             </div>
          </div>
           <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P3 </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PotConP3" placeholder="P3" ng-disabled="vm.fdatos.CodCupSEle==undefined" ng-change="vm.validar_formatos_input(7,vm.fdatos.PotConP3)"/>     
             </div>
             </div>
          </div>
           <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P4 </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PotConP4" placeholder="P4" ng-disabled="vm.fdatos.CodCupSEle==undefined" ng-change="vm.validar_formatos_input(8,vm.fdatos.PotConP4)"/>     
             </div>
             </div>
          </div>
           <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">P5 </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PotConP5" placeholder="P5" ng-disabled="vm.fdatos.CodCupSEle==undefined" ng-change="vm.validar_formatos_input(9,vm.fdatos.PotConP5)"/>     
             </div>
             </div>
          </div>

          <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">Ahorro (€)</label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.ImpAhoEle" placeholder="Ahorro (€)" ng-disabled="vm.fdatos.CodCupSEle==undefined" ng-change="vm.validar_formatos_input(11,vm.fdatos.ImpAhoEle)"/>     
             </div>
             </div>
          </div>


             <div class="col-12 col-sm-4">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">% </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PorAhoEle" placeholder="%" ng-disabled="vm.fdatos.CodCupSEle==undefined" ng-change="vm.validar_formatos_input(12,vm.fdatos.PorAhoEle)"/>     
             </div>
             </div>
          </div>

         <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">Renovación </label>         
             <input type="checkbox"  class="form-control" style="margin-top: -1px;" ng-model="vm.fdatos.RenConEle" ng-disabled="vm.fdatos.CodCupSEle==undefined || vm.disabled_status==true"/>     
             </div>
             </div>
  </div>
  
  <div class="col-12 col-sm-4">
      <div class="form" >                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:black;">Observación </label>
        <textarea class="form-control" style="display: inline-block;" onkeyup="this.value=this.value.toUpperCase();"  minlength="1" maxlength="200" rows="5" placeholder="Observación" ng-model="vm.fdatos.ObsAhoEle" ng-disabled="vm.fdatos.CodCupSEle==undefined"></textarea>        
       </div>
      </div> 
  </div>


  </div>
  
  



  </div>
          <!--- PARA LOS CUPS ELECTRICOS END -->


<!--- PARA LOS CUPS GAS START-->
    <div >
        <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:blue;">CUPs Gas </label>
             <select class="form-control" id="CodCupGas" name="CodCupGas" ng-model="vm.fdatos.CodCupGas" ng-change="vm.CUPsFilter(2,vm.fdatos.CodCupGas)" ng-disabled="vm.fdatos.CodPunSum==undefined"> 
                <option ng-repeat="dato_act in vm.List_CUPs_Gas" value="{{dato_act.CodCupGas}}">{{dato_act.CupsGas}}</option>
              </select>     
             </div>
             </div>
        </div>
          
        <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">   
              <label class="font-weight-bold nexa-dark" style="color:black;">Tarifa </label>          
             <select class="form-control" id="CodTarGas" name="CodTarGas" ng-model="vm.fdatos.CodTarGas" ng-disabled="vm.fdatos.CodCupGas==undefined"> 
                <option ng-repeat="dato_act in vm.List_TarGas" value="{{dato_act.CodTarGas}}">{{dato_act.NomTarGas}}</option>
              </select>                  
             </div>
             </div>
        </div>        

        <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">Consumo </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.Consumo" placeholder="Consumo" ng-disabled="vm.fdatos.CodCupGas==undefined" ng-change="vm.validar_formatos_input(13,vm.fdatos.Consumo)"/>     
             </div>
             </div>
        </div>

        <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">Caudal Diario </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.CauDia" placeholder="Caudal Diario" ng-disabled="vm.fdatos.CodCupGas==undefined" ng-change="vm.validar_formatos_input(14,vm.fdatos.Caudal_Diario)"/>     
             </div>
             </div>
        </div>

          <div class="col-12 col-sm-5">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">Ahorro (€)</label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.ImpAhoGas" placeholder="Ahorro (€)" ng-disabled="vm.fdatos.CodCupGas==undefined" ng-change="vm.validar_formatos_input(15,vm.fdatos.ImpAhoGas)"/>     
             </div>
             </div>
          </div>

          <div class="col-12 col-sm-5">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">% </label>         
             <input type="text"  class="form-control" ng-model="vm.fdatos.PorAhoGas" placeholder="%" ng-disabled="vm.fdatos.CodCupGas==undefined" ng-change="vm.validar_formatos_input(16,vm.fdatos.PorAhoGas)"/>     
             </div>
             </div>
          </div>

          <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">Ren </label>         
             <input type="checkbox"  class="form-control" style="margin-top: -1px;" ng-model="vm.fdatos.RenConGas" ng-disabled="vm.fdatos.CodCupGas==undefined || vm.disabled_status==true"/>     
             </div>
             </div>
          </div>
      <div class="form" >                          
       <div class="form-group">
        <textarea class="form-control" style="display: inline-block;" onkeyup="this.value=this.value.toUpperCase();" id="ObsAhoGas" name="ObsAhoGas" minlength="1" maxlength="200" rows="5" placeholder="Observación" ng-model="vm.fdatos.ObsAhoGas" ng-disabled="vm.fdatos.CodCupGas==undefined"></textarea>        
       </div>
       </div>  
    </div>
  <!--- PARA LOS CUPS ELECTRICOS END -->

   <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Comercializadora </label>
             <select class="form-control" id="CodCom" name="CodCom" ng-model="vm.fdatos.CodCom" ng-change="vm.realizar_filtro(1,vm.fdatos.CodCom)" ng-disabled="vm.fdatos.tipo=='ver'|| vm.fdatos.EstProCom=='C'"> 
                <option ng-repeat="dato_act in vm.List_Comercializadora" value="{{dato_act.CodCom}}">{{dato_act.NumCifCom}} - {{dato_act.NomComCom}}</option>
        </select>     
             </div>
             </div>
          </div>
          
          <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">   
              <label class="font-weight-bold nexa-dark" style="color:black;">Producto </label>          
             <select class="form-control" id="CodPro" name="CodPro" ng-model="vm.fdatos.CodPro" ng-disabled="vm.fdatos.CodCom==undefined || vm.List_Productos.length==0 || vm.fdatos.tipo=='ver' || vm.fdatos.EstProCom=='C'" ng-change="vm.realizar_filtro(2,vm.fdatos.CodPro)"> 
                <option ng-repeat="dato_act in vm.List_Productos" value="{{dato_act.CodPro}}">{{dato_act.DesPro}}</option>
        </select>                  
             </div>
             </div>
          </div>  

           <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Anexo </label>
             <select class="form-control" id="CodAnePro" name="CodAnePro" ng-model="vm.fdatos.CodAnePro" ng-disabled="vm.fdatos.CodCom==undefined || vm.fdatos.CodPro==undefined || vm.fdatos.tipo=='ver' || vm.fdatos.EstProCom=='C'" ng-change="vm.realizar_filtro(3,vm.fdatos.CodAnePro)"> 
                <option ng-repeat="dato_act in vm.List_Anexos" value="{{dato_act.CodAnePro}}">{{dato_act.DesAnePro}}</option>
        </select>     
             </div>
             </div>
          </div>
          
          <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">   
              <label class="font-weight-bold nexa-dark" style="color:black;">Tipo Precio </label>          
             <select class="form-control" id="TipPre" name="TipPre" ng-model="vm.fdatos.TipPre" ng-disabled="vm.fdatos.CodAnePro==undefined || vm.fdatos.tipo=='ver' || vm.fdatos.EstProCom=='C'"> 
                <option ng-repeat="dato_act in vm.List_TipPre" value="{{dato_act.TipPre}}">{{dato_act.nombre}}</option>
        </select>                  
             </div>
             </div>
          </div>        
       
          <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">    
              <label class="font-weight-bold nexa-dark" style="color:black;">Ahorro Total </label>         
             <input type="text" class="form-control" ng-model="vm.fdatos.ImpAhoTot" placeholder="123,35 €" readonly />                  
             </div>
             </div>
          </div>
          
          <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">    
             <label class="font-weight-bold nexa-dark" style="color:black;">% </label> 
             <input type="text" class="form-control" ng-model="vm.fdatos.PorAhoTot" readonly />                   
             </div>
             </div>
          </div>
          

          <div class="form" >                          
       <div class="form-group">
        <textarea class="form-control" style="display: inline-block;" onkeyup="this.value=this.value.toUpperCase();" id="ObsProCom" name="ObsProCom" minlength="1" maxlength="200" rows="5" ng-disabled="vm.fdatos.EstProCom=='C'" placeholder="Observaciónes Generales" ng-model="vm.fdatos.ObsProCom"></textarea>        
       </div>
       </div> 

    </div>

     <div align="center">
        <button class="btn btn-info" type="submit">Asignar Propuesta</button>
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

  
  $('.FecDesde').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});   
  $('#FecDesde').on('changeDate', function() 
  {
     var FecDesde=document.getElementById("FecDesde").value;
     console.log("FecDesde: "+FecDesde);
  });
  $('.FecHasta').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});
  $('#FecHasta').on('changeDate', function() 
  {
     var FecHasta=document.getElementById("FecHasta").value;
     console.log("FecHasta: "+FecHasta);
  });
   $('.FecProCom').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});  

</script>
<script type="text/javascript" src="application/libraries/estilos/js/jquery.validate.min.js"></script>
  <!-- custom form validation script for this page-->
  <script src="application/libraries/estilos/js/form-validation-script.js"></script>
  <!--custome script for all page-->
  <!--script src="application/libraries/estilos/js/scripts.js"></script-->
</body>
<div id="Rueda" class="loader loader-default"  data-text="Generando Reporte Rueda"></div>
</html>
