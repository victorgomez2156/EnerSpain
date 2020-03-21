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
</style>

<style>
.datepicker{z-index:1151 !important;}
</style>
<body>
<div ng-controller="Controlador_Comisiones as vm">
  <!--main content start-->
  <section id="main-content">
    <!--wrapper start-->
    <section class="wrapper">
      <div class="row">
        <div class="col-lg-12">
          <h3 class="page-header"><i class="fa fa-dollar"></i> Comisiones de Anexos</h3>
          <ol class="breadcrumb">
          <li><i class="fa fa-home"></i><a href="#/Dashboard"> Dashboard</a></li>              
          <li><i class="fa fa-dollar"></i> Comisiones de Anexos</li>
          </ol>
        </div>
      </div>
      <!-- page start-->
      <div class="row">
        <div class="col-lg-12">
          <!--panel start-->
          <section class="panel">
            <div class="panel-body"> 
        
        <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">CIF <b style="color:red;">(*)</b></label>
        <input type="text" name="CIFComision" id="CIFComision" class="form-control" ng-model="vm.CIFComision" readonly="readonly">       
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Comercializadora <b style="color:red;">(*)</b></label>
        <input type="text" name="ComerComision" id="ComerComision" class="form-control" ng-model="vm.ComerComision" readonly="readonly">     
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Productos <b style="color:red;">(*)</b></label>
        <input type="text" name="ProComision" id="ProComision" class="form-control" ng-model="vm.ProComision" readonly="readonly">     
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Anexos <b style="color:red;">(*)</b></label>
        <input type="text" name="AneComision" id="AneComision" class="form-control" ng-model="vm.AneComision" readonly="readonly">     
       </div>
       </div>
       </div>
       <br>
        <!--div class="table-responsive"-->
           <table class="table table-striped table-advance table-hover table-responsive">
                <tbody>
                  <tr>
                    <th><i class="fa fa-arrow-down"></i></th>
                    <th><i class="fa fa-arrow-down"></i> Tipos de Servicios</th>
                    <th><i class="fa fa-arrow-down"></i> Tipos de Precios</th>
                    <th><i class="fa fa-arrow-down"></i> Tarifas</th>
                  </tr> 
                  <tr ng-show="vm.TComisionesDet.length==0"> 
                    <td colspan="4" align="center"><div class="td-usuario-table"><i class="fa fa-close"></i> Actualmente no hay datos disponibles.</div></td>
                  </tr>
                  <tr ng-repeat="dato in vm.TComisionesDet | filter:paginate3" ng-class-odd="odd">                    
                    <td>
                      <button type="button"  ng-click="vm.agregar_detalle_comision($index,dato.CodDetAneTarEle,dato)" title="Agregar {{dato.NomTarEle}}" ng-show="!vm.select_det_com[dato.CodDetAneTarEle]"><i class="fa fa fa-square-o" style="color:black;"></i></button>                        

                      <button type="button" ng-show="vm.select_det_com[dato.CodDetAneTarEle]" ng-click="vm.quitar_detalle_comision($index,dato.CodDetAneTarEle,dato)"><i class="fa fa fa-check-circle" title="Quitar {{dato.NomTarEle}}" style="color:green;"></i></button>
                      </td>
                    <td>{{dato.TipServ}}</td>
                    <td>{{dato.TipPre}}</td>                  
                    <td>{{dato.NomTarEle}}</td>
                  </tr>
                </tbody>
                <tfoot>
                    <th><i class="fa fa-arrow-up"></i></th>
                    <th><i class="fa fa-arrow-up"></i> Tipos de Servicios</th>
                    <th><i class="fa fa-arrow-up"></i> Tipos de Precios</th>
                    <th><i class="fa fa-arrow-up"></i> Tarifas</th>
                </tfoot>
              </table><!--/div-->
        <div align="center">
          <span class="store-qty" ng-show="vm.TComisionesRangoGrib.length==0"> <a ng-click="vm.regresar_comisiones()" title='Volver' class="btn btn-success"><div><i class="fa fa-arrow-left" style="color:white;"></i></div></a> </span>
          <div class='btn-group' align="center">
            <pagination total-items="totalItems3" ng-model="currentPage3" max-size="5" boundary-links="true" items-per-page="numPerPage3" class="pagination-sm">  
            </pagination>
          </div>
        </div>

<br>  
  <div ng-show="vm.TComisionesRangoGrib.length>0">
      <div align="right" style="margin-right: 50px;">
         <span class="store-qty"> <a title="Quitar" ng-click="vm.quitar_detalle_comision_length()" class="btn btn-info"><div><i class="fa fa-minus-square" style="color:white;"></i></div></a></span>
         <span class="store-qty"> <a title="Agregar" ng-click="vm.agregardetalle()" class="btn btn-info"><div><i class="fa fa-plus" style="color:white;"></i></div></a></span>
        </div> <br>
        <div class="table-responsive">
        <table class="table table-striped table-advance table-hover table-responsive">
                <tbody>
                  <tr>
                    <!--th><i class="fa fa-arrow-down"></i> Rango de Consumo</th-->
                    <th><i class="fa fa-arrow-down"></i> Consumo Mínimo Anual</th>
                    <th><i class="fa fa-arrow-down"></i> Consumo Máximo Anual</th>
                    <th><i class="fa fa-arrow-down"></i> Comisión Servicios</th>
                    <th><i class="fa fa-arrow-down"></i> Comisión Certificado Verde</th>
                  </tr> 
                  <tr ng-show="vm.TComisionesRangoGrib.length==0"> 
                    <td colspan="5" align="center"><div class="td-usuario-table"><i class="fa fa-close"></i> Actualmente no hay datos disponibles.</div></td>
                  </tr>
                  <tr ng-repeat="dato in vm.TComisionesRangoGrib | filter:paginate4" ng-class-odd="odd">                    
                    <!--td><input type="text" name="RanCon" ng-model="vm.TComisionesRangoGrib[$index].RanCon" ng-change="vm.validar_inputs(1,vm.TComisionesRangoGrib[$index].RanCon,$index)" class="form-control"></td-->
                    
                    <td><input type="text" name="ConMinAnu" ng-model="vm.TComisionesRangoGrib[$index].ConMinAnu" ng-change="vm.validar_inputs(2,vm.TComisionesRangoGrib[$index].ConMinAnu,$index)" class="form-control"></td>
                   
                    <td><input type="text" name="ConMaxAnu" ng-model="vm.TComisionesRangoGrib[$index].ConMaxAnu" ng-change="vm.validar_inputs(3,vm.TComisionesRangoGrib[$index].ConMaxAnu,$index)" class="form-control"></td>
                    
                    <td><input type="text" name="ConSer" ng-model="vm.TComisionesRangoGrib[$index].ConSer" ng-change="vm.validar_inputs(4,vm.TComisionesRangoGrib[$index].ConSer,$index)" class="form-control"></td>
                    
                    <td><input type="text" name="ConCerVer" ng-model="vm.TComisionesRangoGrib[$index].ConCerVer" ng-change="vm.validar_inputs(5,vm.TComisionesRangoGrib[$index].ConCerVer,$index)" class="form-control"></td>
                  </tr>
                </tbody>
                <tfoot>
                    <!--th><i class="fa fa-arrow-up"></i> Rango de Consumo</th-->
                    <th><i class="fa fa-arrow-up"></i> Consumo Mínimo Anual</th>
                    <th><i class="fa fa-arrow-up"></i> Consumo Máximo Anual</th>
                    <th><i class="fa fa-arrow-up"></i> Comisión Servicios</th>
                    <th><i class="fa fa-arrow-up"></i> Comisión Certificado Verde</th>
                </tfoot>
              </table></div>


               <div class="form-group" >
          <div align="right">
            <button class="btn btn-success" ng-click="vm.guardar_comisiones()" ><i class="fa fa-save"></i> Continuar</button>           
            <button class="btn btn-info" type="button" ng-click="vm.regresar_comisiones()"><i class="fa fa-arrow-left"></i> Regresar</button>
          </div>
        </div>

        <div align="center">
          <div class='btn-group' align="center">
            <pagination total-items="totalItems4" ng-model="currentPage4" max-size="5" boundary-links="true" items-per-page="numPerPage4" class="pagination-sm">  
            </pagination>
          </div>
        </div>
                               
        </div> 

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
          Diseñado Por <a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2019</a>
        </div>
    </div> 
</div>
</body>
<div id="Car_Det" class="loader loader-default"  data-text="Cargando Tarifas, Por Favor Espere..."></div>
<div id="Guar_Deta" class="loader loader-default"  data-text="Procesando Comisiones, Por Favor Espere..."></div>
</html>
