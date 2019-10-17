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
</style>
<body>
 <div ng-controller="Controlador_Tipos_Vias as vm">
 <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-universal-access"></i> Tipos de Vias</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>              
              <li><i class="fa fa-universal-access"></i>Tipos de Vias</li>
            </ol>
          </div>
        </div>
        <!-- page start-->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              
          <!--div id="t-0002">
                <div style="float:left;margin-left: 0px;padding: 10px;margin-top: 10px;margin-bottom: 2px;" class="removeForMobile">                   
                  <div class="t-0029">
                      <div class="t-0031" style="margin-top: -8px; ">
                          <button style="" title="Agregar Columnas" class="btn t-0032 status-task active-status" id="all_active"><i class="fa fa-columns"></i></button>
                          <button style="" class="btn t-0032 status-task" id="active" title="Exportar Lista"><i class="fa fa-cloud-upload"></i></button>
                          <button style="" class="btn t-0032 status-task" id="all_disabled" title="Filtros"><i class="fa fa-filter"></i></button>
                      </div>
                  </div>
                </div>
              <div style="float:right;margin-left: 0px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
                  <div class="t-0029">
                <form class="form-inline" role="form">
                  <div class="form-group">
                    <input type="text" class="form-control" ng-model="search.NumCifCli" minlength="1" maxlength="9" ng-change="vm.filtrar_grib(search.NumCifCli)" id="exampleInputEmail2" placeholder="Ingrese numero de CIF">
                  </div>                 
                  <button style="margin-right: 10px;" class="btn btn-info" id="all_disabled" title="Agregar Cliente"><i class="fa fa-plus-square"></i></button>
                </form>
                  </div>
                
                </div>
              </div-->
              <table class="table table-striped table-advance table-hover" ng-init="vm.cargar_lista_tipos_vias()">
                <tbody>
                  <tr>
                    <th><i class="fa fa-vcard"></i> Descripción Via</th>
                    <th><i class="fa fa-building"></i> Iniciales de Tipo de Via</th>
                    <th><i class="icon_cogs"></i> Action</th>
                  </tr>
                  <tr ng-show="vm.Tipos_Vias==undefined"> 
                     <td colspan="5" align="center"><div class="td-usuario-table"><i class="fa fa-close"></i> Actualmente no hay datos disponibles.</div></td>           
                    </tr>
                  <tr ng-repeat="dato in vm.Tipos_Vias | filter:paginate | filter:search" ng-class-odd="odd">
                    <td>{{dato.DesTipVia}}</td>
                    <td>{{dato.IniTipVia}}</td>                  
                    <td>
                      <div class="btn-group">
                       
                       <a class="btn btn-primary" href="#/Edit_Tipo_Vias/{{dato.CodTipVia}}" ng-disabled="vm.Nivel==3"><i class="fa fa-edit"></i></a>
                        <button class="btn btn-danger" type="button" ng-click="vm.borrar_row($index,dato.CodTipVia)" ng-disabled="vm.Nivel!=1"><i class="icon_close_alt2"></i></button> 
                      </div>
                    </td>
                  </tr>
                 
                </tbody>
              </table>
              <div align="center">
              <span class="store-qty"> <a title='Agregar Tipos de Vias' href="#/Add_Tipo_Vias" class="btn btn-info"><div><i class="fa fa-plus" style="color:white;"></i></div></a> </span> 
              <span class="store-qty"> <a ng-click="vm.cargar_lista_tipos_vias()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       

            <div class='btn-group' align="center">
              <pagination total-items="totalItems" ng-model="currentPage" max-size="5" boundary-links="true" items-per-page="numPerPage" class="pagination-sm">  
              </pagination>
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
          Designed by <a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2019</a>
        </div>
    </div>
  </section>
  
</div>
</body>
<div id="cargando" class="loader loader-default"  data-text="Cargando lista, Por Favor Espere..."></div>
<div id="borrando" class="loader loader-default"  data-text="Borrando Cliente, Por Favor Espere..."></div>
</html>
