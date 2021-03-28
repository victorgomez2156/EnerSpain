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
.datepicker{z-index:1151 !important;}
</style>
<body>
 <div ng-controller="Controlador_Logs as vm">
 <!--main content start-->
    <section id="main-content">
      <!--wrapper start-->
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header">Listado de Logs</h3>
           
          </div>
        </div>
        <!-- page start-->
        <div class="row">
          <div class="col-lg-12">
            <!--panel start-->
            <section class="panel">
 <!--t-0002 start-->                  
<div id="t-0002">
  <div style="float:left;margin-left: 0px;padding: 10px;margin-top: 10px;margin-bottom: 2px;" class="removeForMobile">                   
    <div class="t-0029">
      <div class="t-0031" style="margin-top: -8px; ">
                    <div class="btn-group">
                      <button data-toggle="dropdown" title="Agregar Columnas" class="btn btn-default" type="button"><i class="fa fa-columns"></i> <span class="caret"></span></button>
                      <ul class="dropdown-menu">
                        <!--li><input type="checkbox" ng-model="vm.fdatos.Cod"/> <i class="fa fa-plus-square"></i> <b style="color:black;">CodCli</b></li-->
                        <li><input type="checkbox" ng-model="vm.huser"/> <b style="color:black;">Usuario</b></li>
                        <li><input type="checkbox" ng-model="vm.fecha"/> <b style="color:black;">Fecha</b></li></li>
                        <li><input type="checkbox" ng-model="vm.tabla"/> <b style="color:black;">Tabla</b></li></li>
                        <li><input type="checkbox" ng-model="vm.metodo"/> <b style="color:black;">Metodo</b></li>
                        <li><input type="checkbox" ng-model="vm.ip"/> <b style="color:black;">Ip</b></li>
                        <li><input type="checkbox" ng-model="vm.navegador"/> <b style="color:black;">Navegador</b></li>
                        <li><input type="checkbox" ng-model="vm.idafec"/> <b style="color:black;">Id Afecado</b></li>
                        <li><input type="checkbox" ng-model="vm.even"/> <b style="color:black;">Evento</b></li>
                      </ul> 
                    </div>
    </div>
  </div>
</div>
           
</div> 
<br><br><br><br>
      <div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive" ng-init="vm.cargar_lista_distribuidoras()">
                <tbody>
                  <tr>
                    <th ng-show="vm.huser==true">Usuario</th> 
                    <th ng-show="vm.fecha==true">Fecha</th>                   
                    <!--th ng-show="vm.tabla==true">Tabla</th-->
                    <th ng-show="vm.metodo==true">Metodo</th>
                    <th ng-show="vm.ip==true">Ip</th> 
                    <th ng-show="vm.navegador==true">Navegador</th>                   
                    <!--th ng-show="vm.idafec==true">ID Afectado</th-->
                    <th ng-show="vm.even==true">Evento</th> 
                  </tr>
                  <tr ng-show="vm.TLogs.length==0"> 
                     <td colspan="9" align="center"><div class="td-usuario-table">No hay información disponible</div></td>           
                    </tr>
                  <tr ng-repeat="dato in vm.TLogs | filter:paginate" ng-class-odd="odd">
                    
                    <td ng-show="vm.huser==true">{{dato.username}}</td>
                    <td ng-show="vm.fecha==true">{{dato.hora}}</td>
                    <!--td ng-show="vm.tabla==true">{{dato.tablaafectada}}</td-->                    
                    <td ng-show="vm.metodo==true">{{dato.operacion}}</td>
                    <td ng-show="vm.ip==true">{{dato.ip}}</td>
                    <td ng-show="vm.navegador==true">{{dato.navegador}}</td>
                    <!--td ng-show="vm.idafec==true">{{dato.idafectado}}</td--> 
                    <td ng-show="vm.even==true">{{dato.evento}}</td>
                    <!--td ng-show="vm.metodo==true">
                      <span class="ip label-info" ng-show="dato.EstDist=='ACTIVO'">Activo</span>
                      <span class="label label-danger" ng-show="dato.EstDist=='BLOQUEADO'">Bloqueado</span>
                    </td--> 
                    
                  </tr>
                </tbody>
                <tfoot>                   
                   <th ng-show="vm.huser==true">Usuario</th> 
                    <th ng-show="vm.fecha==true">Fecha</th>                   
                    <!--th ng-show="vm.tabla==true">Tabla</th-->
                    <th ng-show="vm.metodo==true">Metodo</th>
                    <th ng-show="vm.ip==true">Ip</th> 
                    <th ng-show="vm.navegador==true">Navegador</th>                   
                    <!--th ng-show="vm.idafec==true">ID Afectado</th-->
                    <th ng-show="vm.even==true">Evento</th> 
                </tfoot>
              </table>
        </div> 
        <div align="center">
          <span class="store-qty"> <a ng-click="vm.cargar_lista_logs()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       
          <div class='btn-group' align="center">
            <pagination total-items="totalItems" ng-model="currentPage" max-size="5" boundary-links="true" items-per-page="numPerPage" class="pagination-sm">  
            </pagination>
          </div>
        </div>
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
         Diseñado Por <a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2019 - 2021</a>
        </div>
    </div>
  </section>
</div>
</body>
<div id="cargando" class="loader loader-default"  data-text="Cargando Logs, por favor espere..."></div>
<div id="borrando" class="loader loader-default"  data-text="Borrando Distribuidora, por favor espere ..."></div>
<div id="NumCifDis" class="loader loader-default"  data-text="Comprobando Número de CIF, Por Favor Espere"></div>
</html>
