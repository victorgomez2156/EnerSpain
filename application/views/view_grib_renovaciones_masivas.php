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
 <div ng-controller="Controlador_Renovaciones_Masivas as vm">
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header">Renovacíones Masivas</h3>
           
          </div>
        </div>
        <!-- Form validations -->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
             
              <div class="panel-body">


<form id="form_renovaciones_masivas" name="form_renovaciones_masivas" ng-submit="submitFormRenovacionesMasivas($event)" ng-init="vm.CargarDatosServer()"> 
     <div class='row'>              
      
      <div class="col-12 col-sm-4">
       <div class="form">                          
      <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Desde</label>        
        <input type="text" class="form-control FecDesde" id="FecDesde" name="FecDesde" ng-model="vm.FecDesde" placeholder="* DD/MM/YYYY"/>       
      </div>
       </div>
       </div>

      <div class="col-12 col-sm-4">
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Hasta</label>         
        <input type="text" class="form-control FecHasta" id="FecHasta" name="FecHasta" ng-model="vm.FecHasta" placeholder="* DD/MM/YYYY"/> 
         </div>
         </div>
      </div>

      <div class="col-12 col-sm-4">
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Comercializadora</label>
          <select class="form-control" id="CodRef" name="CodRef" required ng-model="vm.fdatos.CodCom" ng-change="vm.FilterProductosAnexos(vm.fdatos.CodCom,1)"> 
        <option ng-repeat="dato_act in vm.List_Comercializadoras" value="{{dato_act.CodCom}}">{{dato_act.RazSocCom}}</option>
        </select>
         </div>
         </div>
      </div>

      <div class="col-12 col-sm-5">
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Productos</label>
          <select class="form-control" id="CodPro" name="CodPro" required ng-model="vm.fdatos.CodPro" ng-disabled="vm.fdatos.CodCom==undefined" ng-change="vm.FilterProductosAnexos(vm.fdatos.CodPro,2)"> 
                <option value="0">Todos</option>
                <option ng-repeat="dato_act in vm.List_Productos" value="{{dato_act.CodPro}}">{{dato_act.DesPro}}</option>
            </select>
         </div>
         </div>
      </div>

       <div class="col-12 col-sm-5">
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Anexos</label>        
        <select class="form-control" id="CodAnePro" name="CodAnePro" required ng-model="vm.fdatos.CodAnePro" ng-disabled="vm.fdatos.CodPro==undefined"> 
            <option value="0">Todos</option>
            <option ng-repeat="dato_act in vm.List_Anexos" value="{{dato_act.CodAnePro}}">{{dato_act.DesAnePro}}</option>
        </select>         
         </div>
         </div>
      </div>      

        <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">
            <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
            <button style="margin-top: 22px; margin-left: -10px;" class="btn btn-info" type="submit">Consultar</button>
             </div>
             </div>
          </div>          

  </div><!--FINAL ROW -->
        </form>
    
    <div ng-show="vm.T_Contratos_Renovaciones.length>0">
     <a class="btn btn-primary" style="margin-top: 10px;" target="_black" ng-click="vm.AgregarTodosContratos()">Seleccionar Todos</a>
     
     <a class="btn btn-info" style="margin-top: 0px;" target="_black" ng-show="vm.fdatos.ContratoDetalle.length>0" ng-click="vm.RenovarPantalla()">Renovar</a>
    <div class="table-responsive">
              <table class="table table-striped table-advance table-hover table-responsive">
                    <tbody>
                      <tr>
                      <th></th>
                      <th>Fecha Vencimiento</th>
                      <th>Cliente</th>
                      <th>Producto</th> 
                      <th>Anexo</th>  
                      <th>Consumo actualizado</th>
                      </tr>
                      <tr ng-show="vm.T_Contratos_Renovaciones.length==0"> 
                        <td colspan="6" align="center">
                          <div class="td-usuario-table"><i class="fa fa-close"></i> No hay información.</div>
                        </td>           
                        </tr>
                      <tr ng-repeat="dato in vm.T_Contratos_Renovaciones | filter:paginate" ng-class-odd="odd">                    
                        <td>
                          <button type="button" ng-click="vm.agregarContratosDetalle($index,dato.CodConCom,dato)" title="Seleccionar Contrato {{dato.FecVenCon}}" ng-show="!vm.Select_DetalleContratos[dato.CodConCom]"><i class="fa fa fa-square-o" style="color:black;"></i></button>
                      
                          <button type="button" ng-show="vm.Select_DetalleContratos[dato.CodConCom]" ng-click="vm.quitarContratosDetalle($index,dato.CodConCom,dato)"><i class="fa fa fa-check-circle" title="Quitar Contrato {{dato.FecVenCon}}" style="color:green;"></i></button>

                          <!--input type="checkbox" ng-model="vm.SelecContrato[$index]"/--></td>
                        <td>{{dato.FecVenCon}}</td>
                        <td>{{dato.RazSocCli}}</td>
                        <td>{{dato.DesPro}}</td> 
                        <td>{{dato.DesAnePro}}</td>
                        <td>no</td>
                      </tr>
                    </tbody>
                    <tfoot>                 
                      <th></th>
                      <th>Fecha Vencimiento</th>
                      <th>Cliente</th>
                      <th>Producto</th> 
                      <th>Anexo</th>  
                      <th>Consumo actualizado</th>
                    </tfoot>
                  </table>
              </div>
              <div align="center">  
                <select id="filterpaginate" name="filterpaginate" style="width: auto;" ng-model="vm.paginate" ng-change="vm.FilterPaginate()">
                  <option value="5">5</option>
                  <option value="10">10</option>
                  <option value="25">25</option>
                  <option value="50">50</option>
                  <option value="100">100</option>                          
                </select>       
                <div class='btn-group' align="center">                  
                  <pagination total-items="totalItems" ng-model="currentPage" max-size="5" boundary-links="true" items-per-page="numPerPage" class="pagination-sm"> </pagination>
                </div>
        </div>
    </div>

            </section>

            <section class="panel" ng-show="vm.ConfirRenovacion==true">
             <label class="font-weight-bold nexa-dark" style="color:black;">RENOVACIÓN MASIVO CONTRATOS </label>
              <div class="panel-body">

            <div>
            

            <div class="col-12 col-sm-4">
             <div class="form">                          
            <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Comercializadora </label>        
              <input type="text" class="form-control" readonly ng-model="vm.NomComer"/>       
            </div>
             </div>
             </div>

            <div class="col-12 col-sm-4">
               <div class="form">                          
               <div class="form-group">
               <label class="font-weight-bold nexa-dark" style="color:black;">Contratos a Renovar</label>         
              <input type="text" class="form-control" ng-model="vm.CountContratos" readonly/> 
               </div>
               </div>
            </div>

            <div class="col-12 col-sm-4">
               <div class="form">                          
               <div class="form-group">
               <label class="font-weight-bold nexa-dark" style="color:black;">Cambiar Producto y Anexo</label>
                <input type="checkbox" class="form-control" ng-model="vm.fdatos.CambiarProAne"/> 
               </div>
               </div>
            </div>

            <div class="col-12 col-sm-6">
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Nuevo Producto</label>
          <select class="form-control" id="CodPro" name="CodPro" required ng-model="vm.fdatos.NewCodPro" ng-disabled="vm.fdatos.CambiarProAne==false" ng-change="vm.FilterProductosAnexos(vm.fdatos.NewCodPro,3)">> 
                  <option ng-repeat="dato_act in vm.List_ProductosNew" value="{{dato_act.CodPro}}">{{dato_act.DesPro}}</option>
            </select>
         </div>
         </div>
      </div>

       <div class="col-12 col-sm-6">
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Nuevo Anexo</label>        
        <select class="form-control" id="CodAnePro" name="CodAnePro" required ng-model="vm.fdatos.NewCodAnePro" ng-disabled="vm.fdatos.CambiarProAne==false"> 
              <option ng-repeat="dato_act in vm.List_AnexosNew" value="{{dato_act.CodAnePro}}">{{dato_act.DesAnePro}}</option>
        </select>         
         </div>
         </div>
      </div>  

            <div class="form" align="right">                          
             <div class="form-group">
             <button class="btn btn-info" type="button" ng-click="vm.GenerarRenovacionContratos()">Generar Renovación</button>
             </div>
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
          Diseñado por <a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2019 - 2021</a>
        </div>
    </div>
  </section>
</div>
  <!-- container section end -->

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

</script>
<script type="text/javascript" src="application/libraries/estilos/js/jquery.validate.min.js"></script>
  <!-- custom form validation script for this page-->
  <script src="application/libraries/estilos/js/form-validation-script.js"></script>
  <!--custome script for all page-->
  <!--script src="application/libraries/estilos/js/scripts.js"></script-->
</body>
<div id="RenovacionMasiva" class="loader loader-default"  data-text="Consultado Contratos"></div>
<div id="Consultando" class="loader loader-default"  data-text="Consultando Información"></div>
<div id="Generando" class="loader loader-default"  data-text="Generando Renovaciones Masivas"></div>
</html>
