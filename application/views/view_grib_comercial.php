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
 <div ng-controller="Controlador_Comercial as vm">
 <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-bank"></i> Comerciales</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>              
              <li><i class="fa fa-bank"></i>Comerciales</li>
            </ol>
          </div>
        </div>
        <!-- page start-->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <table class="table table-striped table-advance table-hover" ng-init="vm.cargar_lista_comercial()">
                <tbody>
                  <tr>
                    <th><i class="icon_box-empty"></i> Nombre del Comercial</th>
                    <th><i class="fa fa-bookmark"></i> NIF del Comercial</th>
                    <th><i class="fa fa-mobile"></i> Teléfono Fijo</th>
                    <th><i class="fa fa-mobile"></i> Teléfono Celular</th>
                    <th><i class="fa fa-envelope"></i> Email del Comercial</th>
                    <th><i class="fa fa-bookmark"></i> Cargo del Comercial</th>
                    <th><i class="fa fa-calendar"></i> Fecha Inicio Comercial</th>
                    <th><i class="fa fa-asterisk"></i> % de Comisión</th>
                    <th><i class="fa fa-adjust"></i> Observación</th>  
                    <th><i class="icon_cogs"></i> Action</th>
                  </tr>
                  <tr ng-show="vm.TComercial==undefined"> 
                     <td colspan="10" align="center"><div class="td-usuario-table"><i class="fa fa-close"></i> Actualmente no hay datos disponibles.</div></td>           
                    </tr>
                  <tr ng-repeat="dato in vm.TComercial | filter:paginate | filter:search" ng-class-odd="odd">
                    <td>{{dato.NomCom}}</td>
                    <td>{{dato.NIFCom}}</td> 
                    <td>{{dato.TelFijCom}}</td>                  
                    <td>{{dato.TelCelCom}}</td>
                    <td>{{dato.EmaCom}}</td> 
                    <td>{{dato.CarCom}}</td>
                    <td>{{dato.FecIniCom}}</td>
                    <td>{{dato.PorComCom}} %</td> 
                    <td>{{dato.ObsCom}}</td>
                    <td>
                      <div class="btn-group">
                       <a class="btn btn-primary" href="#/Editar_Comercial/{{dato.CodCom}}" ng-disabled="vm.Nivel==3"><i class="icon_pencil-edit_alt"></i></a>
                        <button class="btn btn-danger" type="button" ng-click="vm.borrar_row($index,dato.CodCom)" ng-disabled="vm.Nivel==3"><i class="icon_close_alt2"></i></button> 
                      </div>
                    </td>
                  </tr>
                 
                </tbody>
              </table>
              <div align="center">
              <span class="store-qty"> <a title='Agregar Comercial' href="#/Agregar_Comercial" class="btn btn-info"><div><i class="fa fa-plus" style="color:white;"></i></div></a> </span> 
              <span class="store-qty"> <a ng-click="vm.cargar_lista_comercial()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       

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
  <!-- container section end -->
</div>
</body>
<div id="cargando" class="loader loader-default"  data-text="Cargando lista Comercial, Por Favor Espere..."></div>
<div id="borrando" class="loader loader-default"  data-text="Borrando Comercial, Por Favor Espere..."></div>
</html>
