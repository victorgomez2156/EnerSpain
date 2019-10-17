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
 <div ng-controller="Controlador_BloPumSum as vm">
 <!--main content start-->
    <section id="main-content">
      <!--wrapper start-->
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-bus"></i> Motivos Bloqueos Puntos Suministros</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>              
              <li><i class="fa fa-bus"></i>Motivos Bloqueos Puntos Suministros</li>
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
                        <li><input type="checkbox" ng-model="vm.CodMotBloPun"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Código Motivo</b></li>
                        <li><input type="checkbox" ng-model="vm.DesMotBloPun"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Descripción del Motivo</b></li></li>                      
                        <li><input type="checkbox" ng-model="vm.Acc"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Accion</b></li>
                      </ul> 
                    </div>
                  </div>
  </div>
</div>
              
              <div style="float:right;margin-left: 0px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
                <div class="t-0029">
                  <form class="form-inline" role="form">
                    <div class="form-group">
                      <input type="text" class="form-control" ng-model="vm.filtrar" minlength="1" id="exampleInputEmail2" placeholder="Escribe para filtrar...">
                    </div>                 
                    <a style="margin-right: 10px;" href="#/Add_Motivos_Bloqueos_Puntos_Suministros" class="btn btn-info" title="Agregar Motivos Punto Suministro" ><i class="fa fa-plus-square"></i></a>
                  </form>                    
                  </div>
              </div>
</div>  <!--t-0002 end-->    
<br><br><br><br>
      
      <div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive" ng-init="vm.cargar_lista_motivos_PumSum()">
                <tbody>
                  <tr>
                    <th ng-show="vm.CodMotBloPun==true"><i class="icon_cogs"></i> Código</th>
                    <th ng-show="vm.DesMotBloPun==true"><i class="icon_cogs"></i> Descripción</th>
                    <th ng-show="vm.Acc==true"><i class="icon_cogs"></i> Acción</th>                   
                  </tr>  

                   <tr ng-show="vm.TMotBloPunSum==undefined"> 
                     <td colspan="29" align="center"><div class="td-usuario-table"><i class="fa fa-close"></i> Actualmente no hay datos disponibles.</div></td>
                  </tr>               
                  

                  <tr ng-repeat="dato in vm.TMotBloPunSum | filter:paginate | filter:vm.filtrar" ng-class-odd="odd">
                    <td ng-show="vm.CodMotBloPun==true">{{dato.CodMotBloPun}}</td>
                    <td ng-show="vm.DesMotBloPun==true">{{dato.DesMotBloPun}}</td>
                    <td ng-show="vm.Acc==true">
                      <a class="btn btn-primary"  href="#/Edit_Motivos_Bloqueos_Puntos_Suministros/{{dato.CodMotBloPun}}" title="Editar Motivo Punto Suministro" ng-disabled="vm.Nivel==3"><i class="icon_pencil-edit_alt"></i></a>                        
                      
                      <button class="btn btn-danger" style="margin-bottom: 8px;" title="Borrar Motivo Punto Suministro" type="button" ng-click="vm.borrar_row($index,dato.CodMotBloPun)" ng-disabled="vm.Nivel==3"><i class="icon_close_alt2"></i></button> 


                    </td>
                  </tr>
                </tbody>
                <tfoot>
                   <th ng-show="vm.CodMotBloPun==true"><i class="icon_cogs"></i> Código</th>
                    <th ng-show="vm.DesMotBloPun==true"><i class="icon_cogs"></i> Descripción</th>
                    <th ng-show="vm.Acc==true"><i class="icon_cogs"></i> Acción</th>
                </tfoot>
              </table>
        </div> 
        <div align="center">
          <span class="store-qty"> <a ng-click="vm.cargar_lista_motivos_PumSum()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       
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
<div id="List_Comer" class="loader loader-default"  data-text="Cargando lista de Comercializadoras, Por Favor Espere..."></div>
<div id="borrando" class="loader loader-default"  data-text="Borrando Cliente, Por Favor Espere..."></div>
<div id="NumCifCom" class="loader loader-default"  data-text="Comprobando Número de CIF, Por Favor Espere..."></div>
</html>
