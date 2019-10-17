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
<body>
 <div ng-controller="Controlador_Colaboradores as vm">
 <!--main content start-->
    <section id="main-content">
      <!--wrapper start-->
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-users"></i> Colaboradores</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>              
              <li><i class="fa fa-users"></i>Colaboradores</li>
            </ol>
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
                        <li><input type="checkbox" ng-model="vm.fdatos.CodCol"/> <i class="fa fa-plus-square"></i> <b style="color:black;">CodCol</b></li>
                        <li><input type="checkbox" ng-model="vm.fdatos.TipCol"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Tipo Colaborador</b></li>
                        <li><input type="checkbox" ng-model="vm.fdatos.NumIdeFis"/> <i class="fa fa-plus-square"></i> <b style="color:black;">CIF o NIF</b></li></li>
                        <li><input type="checkbox" ng-model="vm.fdatos.NomCol"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Nombre</b></li>
                        <li><input type="checkbox" ng-model="vm.fdatos.DirCol"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Dirección</b></li>
                        <li><input type="checkbox" ng-model="vm.fdatos.TelFijCol"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Teléfono Fijo</b></li>
                        <li><input type="checkbox" ng-model="vm.fdatos.TelCelCol"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Teléfono Movil</b></li>
                        <li><input type="checkbox" ng-model="vm.fdatos.EmaCol"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Email</b></li>
                        <li><input type="checkbox" ng-model="vm.fdatos.ObsCol"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Observación</b></li>
                        <li><input type="checkbox" ng-model="vm.fdatos.PorCol"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Porcentaje</b></li>
                        <li><input type="checkbox" ng-model="vm.fdatos.EstCol"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Estatus</b></li>
                        <li><input type="checkbox" ng-model="vm.fdatos.AccCol"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Action</b></li>
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
                       <a data-toggle="modal" title='Filtros' data-target="#modal_filtros" class="btn btn-default"><div><i class="fa fa-filter"></i><span class="caret"></span></div></a>
                    </div>
    </div>
  </div>
</div>       
              <div style="float:right;margin-left: 0px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
                <div class="t-0029">
                  <form class="form-inline" role="form">
                    <div class="form-group">
                      <input type="text" class="form-control" ng-model="vm.fdatos.filtrar" minlength="1" id="exampleInputEmail2" placeholder="Escribe para filtrar...">
                    </div>

                    <a style="margin-right: 10px;" href="#/Add_Colaborador" title='Agregar Colaborador' class="btn btn-info btn-icon mg-r-5"><div><i class="fa fa-plus-square" style="color:white;"></i></div></a>
                  </form>                    
                  </div>
              </div>
</div>  <!--t-0002 end-->    
<br><br><br><br>
      <div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive" ng-init="vm.cargar_lista_colaboradores()">
                <tbody>
                  <tr>
                    <th ng-show="vm.fdatos.CodCol==true"><i class="fa fa-asterisk"></i> Código</th>
                    <th ng-show="vm.fdatos.TipCol==true"><i class="fa fa-vcard"></i> Tipo</th>
                    <th ng-show="vm.fdatos.NumIdeFis==true"><i class="fa fa-vcard"></i> CIF O NIF</th>
                    <th ng-show="vm.fdatos.NomCol==true"><i class="fa fa-user-circle"></i> Nombre</th>
                    <th ng-show="vm.fdatos.DirCol==true"><i class="fa fa-location-arrow"></i> Dirección</th>
                    <th ng-show="vm.fdatos.TelFijCol==true"><i class="fa fa-volume-control-phone"></i> Teléfono Fijo</th>
                    <th ng-show="vm.fdatos.TelCelCol==true"><i class="fa fa-phone"></i> Teléfono</th>
                    <th ng-show="vm.fdatos.EmaCol==true"><i class="fa fa-crosshairs"></i> Email</th>
                    <th ng-show="vm.fdatos.ObsCol==true"><i class="fa fa-question-circle-o"></i> Observación</th>
                    <th ng-show="vm.fdatos.PorCol==true"><i class="fa fa-bar-chart"></i> Porcentaje</th>
                    <th ng-show="vm.fdatos.EstCol==true"><i class="fa fa-bar-exclamation-circle"></i> Estatus</th>
                    <th ng-show="vm.fdatos.AccCol==true"><i class="fa fa-bullseye"></i> Acción</th>
                  </tr>
                  <tr ng-show="vm.tColaboradores==undefined"> 
                     <td colspan="12" align="center"><div class="td-usuario-table"><i class="fa fa-close"></i> Actualmente no hay datos disponibles.</div></td>           
                  </tr>
                  <tr ng-repeat="dato in vm.tColaboradores | filter:paginate | filter:vm.fdatos.filtrar" ng-class-odd="odd">
                    
                    <td ng-show="vm.fdatos.CodCol==true">{{dato.CodCol}}</td>
                    <td ng-show="vm.fdatos.TipCol==true">{{dato.TipCol}}</td>
                    <td ng-show="vm.fdatos.NumIdeFis==true">{{dato.NumIdeFis}}</td>
                    <td ng-show="vm.fdatos.NomCol==true">{{dato.NomCol}}</td>
                    <td ng-show="vm.fdatos.DirCol==true">{{dato.NomViaDir}}</td> 
                    <td ng-show="vm.fdatos.TelFijCol==true">{{dato.TelFijCol}}</td> 
                    <td ng-show="vm.fdatos.TelCelCol==true">{{dato.TelCelCol}}</td> 
                    <td ng-show="vm.fdatos.EmaCol==true">{{dato.EmaCol}}</td> 
                    <td ng-show="vm.fdatos.ObsCol==true">{{dato.ObsCol}}</td>  
                    <td ng-show="vm.fdatos.PorCol==true">{{dato.PorCol}}</td>
                    <td ng-show="vm.fdatos.EstCol==true">{{dato.EstCol}}</td>                    
                    <td ng-show="vm.fdatos.AccCol==true">
                      <a href="#/Editar_Colaborador/{{dato.CodCol}}" title='Editar Colaborador {{dato.NomCol}}' class="btn btn-info btn-icon mg-r-5"><div><i class="fa fa-edit" style="color:white;"></i></div></a>

                      <a ng-click="vm.borrar_row($index,dato.CodCol)" title='Eliminar Colaborador {{dato.NomCol}}' class="btn btn-danger btn-icon mg-r-5"><div><i class="fa fa-trash" style="color:white;"></i></div></a>
                    </td>
                  </tr>
                </tbody>
                <tfoot>                 
                     <th ng-show="vm.fdatos.CodCol==true"><i class="fa fa-asterisk"></i> Código</th>
                    <th ng-show="vm.fdatos.TipCol==true"><i class="fa fa-vcard"></i> Tipo</th>
                    <th ng-show="vm.fdatos.NumIdeFis==true"><i class="fa fa-vcard"></i> CIF O NIF</th>
                    <th ng-show="vm.fdatos.NomCol==true"><i class="fa fa-user-circle"></i> Nombre</th>
                    <th ng-show="vm.fdatos.DirCol==true"><i class="fa fa-location-arrow"></i> Dirección</th>
                    <th ng-show="vm.fdatos.TelFijCol==true"><i class="fa fa-volume-control-phone"></i> Teléfono Fijo</th>
                    <th ng-show="vm.fdatos.TelCelCol==true"><i class="fa fa-phone"></i> Teléfono</th>
                    <th ng-show="vm.fdatos.EmaCol==true"><i class="fa fa-crosshairs"></i> Email</th>
                    <th ng-show="vm.fdatos.ObsCol==true"><i class="fa fa-question-circle-o"></i> Observación</th>
                    <th ng-show="vm.fdatos.PorCol==true"><i class="fa fa-bar-chart"></i> Porcentaje</th>
                    <th ng-show="vm.fdatos.EstCol==true"><i class="fa fa-bar-exclamation-circle"></i> Estatus</th>
                    <th ng-show="vm.fdatos.AccCol==true"><i class="fa fa-bullseye"></i> Acción</th>
                </tfoot>
              </table>
        </div> 
        <div align="center">
          <span class="store-qty"> <a ng-click="vm.cargar_lista_colaboradores()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       
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
          Designed by <a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2019</a>
        </div>
    </div>
  </section>

</div>
</body>
<div id="cargando" class="loader loader-default"  data-text="Cargando lista de Clientes, Por Favor Espere..."></div>
<div id="borrando" class="loader loader-default"  data-text="Borrando Colaborador, Por Favor Espere..."></div>
<div id="NumCifCli" class="loader loader-default"  data-text="Comprobando Número de CIF, Por Favor Espere..."></div>
</html>
