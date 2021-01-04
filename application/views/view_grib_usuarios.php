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
 <div ng-controller="Controlador_Empleados as vm">
 <!--main content start-->
    <section id="main-content">
      <!--wrapper start-->
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header">Configurar Usuarios</h3>
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
                        <li><input type="checkbox" ng-model="vm.NomComp"/> <b style="color:black;">Nombre Completo</b></li>
                        <li><input type="checkbox" ng-model="vm.correo_electronico"/> <b style="color:black;">Email</b></li></li>
                        <li><input type="checkbox" ng-model="vm.nivel"/> <b style="color:black;">Rol</b></li></li>
                        <li><input type="checkbox" ng-model="vm.fecha_registro"/> <b style="color:black;">Fecha Registro</b></li>
                        <li><input type="checkbox" ng-model="vm.bloqueado"/> <b style="color:black;">Estatus</b></li>
                        <li><input type="checkbox" ng-model="vm.AccUser"/> <b style="color:black;">Acción</b></li>
                      </ul> 
                    </div>
                    
                    <div class="btn-group" ng-show="vm.Nivel==1 || vm.Nivel==2">
                      <button data-toggle="dropdown" title="Generar Reportes" class="btn btn-default dropdown-toggle" type="button"><i class="fa fa-cloud-upload"></i><span class="caret"></span> </button>
                      <ul class="dropdown-menu">
                        <li style="cursor: pointer;"><a title="Exportar en PDF" target="_black"  href="reportes/Exportar_Documentos/Doc_PDF_Usuarios/{{vm.ruta_reportes_pdf_Usuarios}}"><i class="fa fa-file"></i> Exportar en PDF</a></li>
                        <li style="cursor: pointer;"><a title="Exportar en Excel" target="_black" href="reportes/Exportar_Documentos/Doc_Excel_Usuarios/{{vm.ruta_reportes_excel_Usuarios}}"><i class="fa fa-file-excel-o"></i> Exportar en Excel</a></li>                        
                      </ul>
                    </div>
    </div>
  </div>
</div>
  <div style="float:right;margin-left: 0px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">
    <div class="t-0029">
      <form class="form-inline" role="form">
        <div class="form-group">
              <input type="text" class="form-control" ng-model="vm.filter_search" title="Escribe para Filtrar..." minlength="1" id="exampleInputEmail2" placeholder="Escribe para Filtrar..." ng-keyup="vm.FetchUsuarios()">
        </div>                 
        <a style="margin-right: 10px;" class="btn btn-info" title="Agregar Distribuidora" href="#/Agregar_Usuarios"><i class="fa fa-plus-square"></i></a>
      </form>                    
    </div>
  </div>
</div>  <!--t-0002 end-->    
<br><br><br><br>
      <div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive" ng-init="vm.cargar_lista_empleados()">
                <tbody>
                  <tr>
                    <th ng-show="vm.NomComp==true">Nombre Completo</th> 
                    <th ng-show="vm.correo_electronico==true">Email</th>                   
                    <th ng-show="vm.nivel==true">Rol</th>
                    <th ng-show="vm.fecha_registro==true">Fecha Registro</th> 
                    <th ng-show="vm.bloqueado==true">Estatus</th>     
                    <th ng-show="vm.AccUser==true">Acción</th>
                  </tr>
                  <tr ng-show="vm.Templeados.length==0"> 
                     <td colspan="6" align="center"><div class="td-usuario-table">No hay información disponible</div></td>           
                    </tr>
                  <tr ng-repeat="dato in vm.Templeados | filter:paginate" ng-class-odd="odd">
                    
                    <td ng-show="vm.NomComp==true">{{dato.nombres}} {{dato.apellidos}}</td>
                    <td ng-show="vm.correo_electronico==true">{{dato.correo_electronico}}</td>
                    <td ng-show="vm.nivel==true">
                      <span class="label label-primary" ng-show="dato.nivel==1">Super Administrador</span>
                      <span class="label label-info" ng-show="dato.nivel==2">Administrador</span>
                      <span class="label label-warning" ng-show="dato.nivel==3">Estándar</span></td> 
                    <td ng-show="vm.fecha_registro==true">{{dato.fecha_registro}}</td>                    
                    <td ng-show="vm.bloqueado==true">
                       <span class="label label-primary" ng-show="dato.bloqueado==1">Activo</span>
                      <span class="label label-info" ng-show="dato.bloqueado==2">Bloqueo de Seguridad</span>
                      <span class="label label-warning" ng-show="dato.bloqueado==3">Intentos Fallidos</span>
                    </td> 
                    <td ng-show="vm.AccUser==true">
                      <div class="btn-group">
                       <a class="btn btn-primary" href="#/Editar_Usuarios/{{dato.id}}" ng-disabled="vm.Nivel==3"><i class="icon_pencil-edit_alt"></i></a>                         
                      </div>
                    </td>
                  </tr>
                </tbody>
                <tfoot>                   
                   <th ng-show="vm.NomComp==true">Nombre Completo</th> 
                    <th ng-show="vm.correo_electronico==true">Email</th>                   
                    <th ng-show="vm.nivel==true">Rol</th>
                    <th ng-show="vm.fecha_registro==true">Fecha Registro</th> 
                    <th ng-show="vm.bloqueado==true">Estatus</th>     
                    <th ng-show="vm.AccUser==true">Acción</th>
                </tfoot>
              </table>
        </div> 
        <div align="center">
          <span class="store-qty"> <a ng-click="vm.cargar_lista_empleados()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       
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
         Diseñado Por <a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2019 - 2021</a>
        </div>
    </div>
  </section>
</div>
</body>
<div id="cargando" class="loader loader-default"  data-text="Cargando lista de usuarios, por favor espere ..."></div>
</html>
