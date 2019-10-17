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

  input[type="file"]#importar {
 width: 0.1px;
 height: 0.1px;
 opacity: 0;
 overflow: hidden;
 position: absolute;
 z-index: -1;
 }


label[for="importar"] {
 font-size: 14px;
 font-weight: 600;
 color: #fff;
 background-color: #106BA0;
 display: inline-block;
 transition: all .5s;
 cursor: pointer;
 padding: 7px 20px !important;
 width: fit-content;
 text-align: center;
 height: 34px;
 margin-left: 5px;
 margin-bottom: -2px;
 border-radius: 3px;
    -webkit-box-shadow: none;
    box-shadow: none;
    border: 1px solid transparent;
 }


label[for="importar"]:hover {
    color: #fff;
    background-color: #286090;
    border-color: #204d74;
}
</style>
<body>
 <div ng-controller="Controlador_Localidad as vm">
 <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-bookmark"></i> Localidad</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>              
              <li><i class="fa fa-bookmark"></i>Localidad</li>
            </ol>
          </div>
        </div>
        <!-- page start-->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <table class="table table-striped table-advance table-hover" ng-init="vm.cargar_lista_localidad()">
                <tbody>
                  <tr>
                    
                    <!--th><i class="icon_box-empty"></i> Nombre de la Provincia
                    </th-->
                    <th><i class="fa fa-bookmark"></i> Descripción de la Localidad
                    <select class="form-control" id="CodPro" name="CodPro" required ng-model="vm.fdatos.CodPro" ng-change="vm.filtrarLocalidad()">
                      <option ng-repeat="dato in vm.tProvidencias" value="{{dato.CodPro}}">{{dato.DesPro}}</option>                          
                    </select></th> 

                    <th><i class="fa fa-bookmark"></i> Código Postal</th>  
                    <th><i class="icon_cogs"></i> Action</th>
                  </tr>
                  <tr ng-show="vm.TLocalidadesfiltrada==undefined"> 
                     <td colspan="5" align="center"><div class="td-usuario-table"><i class="fa fa-close"></i> Actualmente no hay datos disponibles.</div></td>           
                    </tr>
                  <tr ng-repeat="dato in vm.TLocalidadesfiltrada | filter:paginate | filter:search" ng-class-odd="odd">
                    <!--td>{{dato.DesPro}}</td-->
                    <td>{{dato.DesLoc}}</td> 
                    <td><div ng-show="dato.CPLoc!=null">{{dato.CPLoc}}</div>
                        <div ng-show="dato.CPLoc==null">Sin Zona Postal</div></td>                  
                    <td>
                      <div class="btn-group">
                       <a class="btn btn-primary" href="#/Editar_Localidad/{{dato.CodLoc}}" ng-disabled="vm.Nivel==3"><i class="icon_pencil-edit_alt"></i></a>
                        <button class="btn btn-danger" type="button" ng-click="vm.borrar_row($index,dato.CodLoc)" ng-disabled="vm.Nivel==3"><i class="icon_close_alt2"></i></button> 
                      </div>
                    </td>
                  </tr>
                 
                </tbody>
              </table>
              <div align="center">
              <span class="store-qty"> <a title='Agregar Localidad' href="#/Agregar_Localidad" class="btn btn-info"><div><i class="fa fa-plus" style="color:white;"></i></div></a> </span> 
              <span class="store-qty"> <a ng-click="vm.cargar_lista_localidad()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       

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
<div id="cargando" class="loader loader-default"  data-text="Cargando lista de Localidades, Por Favor Espere..."></div>
<div id="borrando" class="loader loader-default"  data-text="Borrando Localidad, Por Favor Espere..."></div>
<div id="Importar_Localidades" class="loader loader-default"  data-text="Estamos Importando Sus Localidades, Por Favor Espere..."></div>
</html>
