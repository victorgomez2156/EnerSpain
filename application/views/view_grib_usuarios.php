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
 <div ng-controller="Controlador_Empleados as vm">
 <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-users"></i> Usuarios</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>              
              <li><i class="fa fa-users"></i>Usuarios</li>
            </ol>
          </div>
        </div>
        <!-- page start-->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <table class="table table-striped table-advance table-hover" ng-init="vm.cargar_lista_empleados()">
                <tbody>
                  <tr>
                    <th><i class="icon_profile"></i> Nombres & Apellidos</th>
                    <th><i class="icon_mail_alt"></i> Email</th>
                    <th><i class="icon_pin_alt"></i> Rol</th>
                    <th><i class="icon_calendar"></i> Fecha Registro</th>
                    <th><i class="icon_mobile"></i> Estatus</th>
                    <th><i class="icon_cogs"></i> Action</th>
                  </tr>
                  <tr ng-show="vm.Templeados.length==0"> 
                     <td colspan="6" align="center"><div class="td-usuario-table"><i class="fa fa-close"></i> Actualmente no hay datos disponibles.</div></td>           
                    </tr>
                  <tr ng-repeat="dato in vm.Templeados | filter:paginate | filter:search" ng-class-odd="odd">
                    <td>{{dato.nombres}} {{dato.apellidos}}</td>
                    <td>{{dato.correo_electronico}}</td>
                    <td>
                      <span class="label label-primary" ng-show="dato.nivel==1">Super Administrador</span>
                      <span class="label label-info" ng-show="dato.nivel==2">Administrador</span>
                      <span class="label label-warning" ng-show="dato.nivel==3">Estandar</span>
                    </td>                    
                    <td>{{dato.fecha_registro}}</td>
                    <td>
                      <span class="label label-primary" ng-show="dato.bloqueado==1">Activo</span>
                      <span class="label label-info" ng-show="dato.bloqueado==2">Bloqueo de Seguridad</span>
                      <span class="label label-warning" ng-show="dato.bloqueado==3">Intentos Fallidos</span>
                    </td>
                    <td>
                      <div class="btn-group">
                       <a class="btn btn-primary" href="#/Editar_Usuarios/{{dato.id}}" ng-disabled="vm.Nivel==3"><i class="icon_pencil-edit_alt"></i></a>                        
                        <button class="btn btn-danger" type="button" ng-click="vm.borrar_row($index,dato.id)" ng-disabled="vm.Nivel==3"><i class="icon_close_alt2"></i></button>                       
                       
                        
                      </div>
                    </td>
                  </tr>
                 
                </tbody>
              </table>
              <div align="center">
              <span class="store-qty"> <a title='Agregar Usuarios' href="#/Agregar_Usuarios" class="btn btn-info"><div><i class="fa fa-plus" style="color:white;"></i></div></a> </span> 
              <span class="store-qty"> <a ng-click="vm.cargar_lista_empleados()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       

              <div class='btn-group' align="center">
                      <pagination total-items="totalItems" ng-model="currentPage"  
                    max-size="5" boundary-links="true"  
                    items-per-page="numPerPage" class="pagination-sm">  
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
<div id="cargando" class="loader loader-default"  data-text="Cargando lista de Empleados, Por Favor Espere..."></div>
<div id="borrando" class="loader loader-default"  data-text="Borrando Empleado, Por Favor Espere..."></div>
</html>
