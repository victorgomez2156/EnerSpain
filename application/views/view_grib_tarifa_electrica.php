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
 <div ng-controller="Controlador_Tarifa_Electrica as vm">
 <!--main content start-->
    <section id="main-content">
      <!--wrapper start-->
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-bolt"></i> Tarifa Electrica</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>              
              <li><i class="fa fa-bolt"></i>Tarifa Electrica</li>
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
                        <li><input type="checkbox" ng-model="vm.TipTen"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Tipo Tensión</b></li></li>
                        <li><input type="checkbox" ng-model="vm.NomTarEle"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Nomenclatura</b></li>
                        <li><input type="checkbox" ng-model="vm.CanPerTar"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Periodos</b></li></li>
                        <li><input type="checkbox" ng-model="vm.MinPotCon"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Minimo Potencia</b></li>
                        <li><input type="checkbox" ng-model="vm.MaxPotCom"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Maximo Potencia</b></li>
                        <li><input type="checkbox" ng-model="vm.AccTarElec"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Acción</b></li>
                      </ul> 
                    </div>                    
                    <!--div class="btn-group">
                      <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button"><i class="fa fa-cloud-upload"></i><span class="caret"></span> </button>
                      <ul class="dropdown-menu">
                        <li style="cursor: pointer;"><a ><i class="fa fa-file"></i> Exportar en PDF</a></li>
                        <li style="cursor: pointer;"><a ><i class="fa fa-file-excel-o"></i> Exportar en Excel</a></li>                        
                      </ul>
                    </div>
                    <div class="btn-group">
                       <a data-toggle="modal" title='Filtros' data-target="#modal_filtros_Tarifa_Electrica" class="btn btn-default"><div><i class="fa fa-filter"></i><span class="caret"></span></div></a>
                    </div-->
    </div>
  </div>
</div>     
              <div style="float:right;margin-left: 0px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
                <div class="t-0029">
                  <form class="form-inline" role="form">
                    <div class="form-group">
                      <input type="text" class="form-control" ng-model="vm.filtrar_tarifa_electrinca" minlength="1" id="exampleInputEmail2" placeholder="Escribe para filtrar...">
                    </div>                 
                    <a style="margin-right: 10px;" class="btn btn-info" title="Agregar Tarifa Electrica" href="#/Add_Tarifa_Electrica"><i class="fa fa-plus-square"></i></a>
                  </form>                    
                  </div>
              </div>
</div>  <!--t-0002 end-->    
<br><br><br><br>
      <div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive" ng-init="vm.cargar_lista_Tarifa_Electrica()">
                <tbody>
                  <tr>
                    
                    <th ng-show="vm.TipTen==true"><i class="fa fa-building"></i> Tipo Tensión</th>
                    <th ng-show="vm.NomTarEle==true"><i class="fa fa-vcard"></i> Nomenclatura</th>                    
                    <th ng-show="vm.CanPerTar==true"><i class="fa fa-archive"></i> Periodos</th>
                    <th ng-show="vm.MinPotCon==true"><i class="fa fa-crop"></i> Minimo Potencia</th>
                    <th ng-show="vm.MaxPotCom==true"><i class="fa fa-crosshairs"></i> Maximo Potencia</th> 
                    <th ng-show="vm.AccTarElec==true"><i class="icon_cogs"></i> Acción</th>
                  </tr>
                  <tr ng-show="vm.Tarifa_Electrica==undefined"> 
                     <td colspan="5" align="center"><div class="td-usuario-table"><i class="fa fa-close"></i> Actualmente no hay datos disponibles.</div></td>           
                    </tr>
                  <tr ng-repeat="dato in vm.Tarifa_Electrica | filter:paginate | filter:vm.filtrar_tarifa_electrinca" ng-class-odd="odd">
                    
                    <td ng-show="vm.TipTen==true">{{dato.TipTen}}</td>
                    <td ng-show="vm.NomTarEle==true">{{dato.NomTarEle}}</td>
                    <td ng-show="vm.CanPerTar==true">{{dato.CanPerTar}}</td>
                    <td ng-show="vm.MinPotCon==true">{{dato.MinPotCon}}</td>
                    <td ng-show="vm.MaxPotCom==true">{{dato.MaxPotCon}}</td>
                    
                    <td ng-show="vm.AccTarElec==true">                     
                      <a href="#/Edit_Tarifa_Electrica/{{dato.CodTarEle}}" title='Editar Tarifa Electrica' class="btn btn-info btn-icon mg-r-5"><div><i class="fa fa-edit" style="color:white;"></i></div></a>
                      <a ng-click="vm.borrar_row($index,dato.CodTarEle)" title='Eliminar Tarifa Electrica' class="btn btn-danger btn-icon mg-r-5"><div><i class="fa fa-trash" style="color:white;"></i></div></a>



                    </td>
                  </tr>
                </tbody>
                <tfoot>
                   <th ng-show="vm.TipTen==true"><i class="fa fa-building"></i> Tipo Tensión</th>
                    <th ng-show="vm.NomTarEle==true"><i class="fa fa-vcard"></i> Nomenclatura</th>                    
                    <th ng-show="vm.CanPerTar==true"><i class="fa fa-archive"></i> Periodos</th>
                    <th ng-show="vm.MinPotCon==true"><i class="fa fa-crop"></i> Minimo Potencia</th>
                    <th ng-show="vm.MaxPotCom==true"><i class="fa fa-crosshairs"></i> Maximo Potencia</th> 
                    <th ng-show="vm.AccTarElec==true"><i class="icon_cogs"></i> Acción</th>
                </tfoot>
              </table>
        </div> 
        <div align="center">
          <span class="store-qty"> <a ng-click="vm.cargar_lista_Tarifa_Electrica()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       
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
          <!--
            All the links in the footer should remain intact.
            You can delete the links only if you purchased the pro version.
            Licensing information: https://bootstrapmade.com/license/
            Purchase the pro version form: https://bootstrapmade.com/buy/?theme=NiceAdmin
          -->
          Designed by <a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2019</a>
        </div>
    </div>
  </section>

</div>
</body>
<div id="cargando" class="loader loader-default"  data-text="Cargando lista de Tarifa Electrica, Por Favor Espere..."></div>
<div id="borrando" class="loader loader-default"  data-text="Borrando Tarifa Electrica, Por Favor Espere..."></div> 
</html>
