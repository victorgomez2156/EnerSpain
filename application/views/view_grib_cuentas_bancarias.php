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
 <div ng-controller="Controlador_Cuentas_Bancarias as vm">
 <!--main content start-->
    <section id="main-content">
      <!--wrapper start-->
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header">Registrar Cuenta Bancaria</h3>
            <!--<ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>              
              <li><i class="fa fa-bank"></i>Cuentas Bancarias</li>
            </ol>-->
          </div>
        </div>
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
              <!--panel start-->
              <section class="panel">
                <div id="t-0002"><!--t-0002 start-->   
          <div style="float:left;margin-left: 0px;padding: 10px;margin-top: 10px;margin-bottom: 2px;" class="removeForMobile"><!--DIV removeformobile start-->                    
            <div class="t-0029"><!--t-0029 start--> 
              <div class="t-0031" style="margin-top: -8px; "><!--t-0031 start-->
                <div class="btn-group">
                  <button data-toggle="dropdown" title="Agregar Columnas" class="btn btn-default" type="button"><i class="fa fa-columns"></i> <span class="caret"></span></button>
                <ul class="dropdown-menu">
                  <li><input type="checkbox" ng-model="vm.NumCifCli"/> <i class="fa fa-plus-square"></i> <b style="color:black;">CIF</b></li>
                  <li><input type="checkbox" ng-model="vm.RazSocCli"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Razón Social</b></li>
                  <li><input type="checkbox" ng-model="vm.CodBan1"/> <i class="fa fa-plus-square"></i> <b style="color:black;">BANCO</b></li>
                  <li><input type="checkbox" ng-model="vm.NumIBan1"/> <i class="fa fa-plus-square"></i> <b style="color:black;">IBAN</b></li></li>
                  <li><input type="checkbox" ng-model="vm.EstCue"/> <i class="fa fa-plus-square"></i> <b style="color:black;">ESTATUS</b></li></li>
                  <li><input type="checkbox" ng-model="vm.ActBan1"/> <i class="fa fa-plus-square"></i> <b style="color:black;">ACCIÓN</b></li>
                </ul> 
              </div>
              <div class="btn-group">
                <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button"><i class="fa fa-cloud-upload"></i><span class="caret"></span> </button>
                 <ul class="dropdown-menu">
                  <li style="cursor: pointer;"><a title='Exportar PDF' target="_black"  href="reportes/Exportar_Documentos/Clientes_Doc_PDF_Bancos/{{vm.ruta_reportes_pdf_Banco}}"><i class="fa fa-file"></i> Exportar en PDF</a></li>
                  <li style="cursor: pointer;"><a title='Exportar Excel' target="_black" href="reportes/Exportar_Documentos/Clientes_Doc_Excel_Bancos/{{vm.ruta_reportes_excel_Banco}}"><i class="fa fa-file-excel-o"></i> Exportar en Excel</a></li>
                </ul>
              </div>
              <div class="btn-group">
                <a data-toggle="modal" title='Filtros' data-target="#modal_filtros_bancos" class="btn btn-default"><div><i class="fa fa-filter"></i><span class="caret"></span></div></a>                     
              </div>
            </div><!--t-0031 end--> 
          </div><!--t-0029 end--> 
        </div><!--DIV removeformobile end-->
          <div style="float:right;margin-left: 0px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
              <div class="t-0029">
                <form class="form-inline" role="form">
                  <div class="form-group">
                    <input type="text" class="form-control" ng-model="vm.tgribBancos.filtrar" minlength="1" id="exampleInputEmail2" placeholder="Escribe para filtrar...">
                  </div>  
                   <!--a data-toggle="modal" title="Asignar Actividad" style="margin-right: 5px;" data-target="#modal_asignar_actividades" class="btn btn-info"><div><i class="fa fa-plus-square"></i></div></a-->
                    <a title="Agregar Cuenta Bancaria" style="margin-right: 5px;" href="#/Add_Cuentas_Bancarias" class="btn btn-info"><div><i class="fa fa-plus-square"></i></div></a>              
                  
                </form>                    
            </div>
          </div>
        </div>  <!--t-0002 end-->
      <br><br><br><br>
       <div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive">
                <tbody>
                  <tr>
                  <th ng-show="vm.NumCifCli==true"><i class="fa fa-users"></i> CIF</th>
                  <th ng-show="vm.RazSocCli==true"><i class="fa fa-users"></i> Razón Social</th>
                  <th ng-show="vm.CodBan1==true"><i class="fa fa-bank"></i> BANCO</th>
                  <th ng-show="vm.NumIBan1==true"><i class="fa fa-asterisk"></i> IBAN</th> 
                  <th ng-show="vm.EstCue==true"><i class="fa fa-building"></i> ESTATUS</th>                
                  <th ng-show="vm.ActBan1==true"><i class="icon_cogs"></i> ACCIÓN</th>
                  </tr>
                  <tr ng-show="vm.tCuentaBan.length==0"> 
                    <td colspan="6" align="center">
                      <div class="td-usuario-table"><i class="fa fa-close"></i> Actualmente no hay cuentas bancarias registradas.</div>
                    </td>           
                    </tr>
                  <tr ng-repeat="dato in vm.tCuentaBan | filter:paginate3 | filter:vm.tgribBancos.filtrar" ng-class-odd="odd">
                    <td ng-show="vm.NumCifCli==true">{{dato.NumCifCli}}</td>
                     <td ng-show="vm.RazSocCli==true">{{dato.RazSocCli}}</td>
                    <td ng-show="vm.CodBan1==true">{{dato.DesBan}}</td>
                    <td ng-show="vm.NumIBan1==true">{{dato.CodEur}} {{dato.IBAN1}} {{dato.IBAN2}} {{dato.IBAN3}} {{dato.IBAN4}} {{dato.IBAN5}}</td>
                    <td ng-show="vm.EstCue==true">

                      <span class="label label-info" ng-show="dato.EstCue==1"><i class="fa fa-check-circle"></i> {{dato.EstaCue}}</span>
                      <span class="label label-danger" ng-show="dato.EstCue==2"><i class="fa fa-ban"></i> {{dato.EstaCue}}</span>
                   </td>
                    <td ng-show="vm.ActBan1==true">
                      <div class="btn-group">
                        <select class="form-control" id="opciones_Ban" name="opciones_Ban" ng-model="vm.opciones_Ban[$index]" ng-change="vm.validar_OpcBan($index,vm.opciones_Ban[$index],dato)">
                          <option ng-repeat="opcion in vm.topcionesBan" value="{{opcion.id}}">{{opcion.nombre}}</option>                          
                        </select>
                      </div>
                    </td>
                  </tr>
                </tbody>
                <tfoot>                 
                  <th ng-show="vm.NumCifCli==true"><i class="fa fa-users"></i> CIF</th>
                  <th ng-show="vm.RazSocCli==true"><i class="fa fa-users"></i> Razón Social</th>
                  <th ng-show="vm.CodBan1==true"><i class="fa fa-bank"></i> BANCO</th>
                  <th ng-show="vm.NumIBan1==true"><i class="fa fa-asterisk"></i> IBAN</th> 
                  <th ng-show="vm.EstCue==true"><i class="fa fa-building"></i> ESTATUS</th>                
                  <th ng-show="vm.ActBan1==true"><i class="icon_cogs"></i> ACCIÓN</th>
                </tfoot>
              </table>
        </div> 
        <div align="center">
          <span class="store-qty"> <a ng-click="vm.cargar_cuentas_bancarias()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       
          <div class='btn-group' align="center">
            <pagination total-items="totalItems3" ng-model="currentPage3" max-size="5" boundary-links="true" items-per-page="numPerPage3" class="pagination-sm">  
            </pagination>
          </div>
        </div>



         <!-- modal container section end -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_filtros_bancos" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Seleccione Filtro</h4>
          </div>
          <div class="modal-body">
                        <div class="panel">                  
      <form class="form-validate" id="frmfiltrobancos" name="frmfiltrobancos" ng-submit="SubmitFormFiltrosBancos($event)">                 
     
     <div class="col-12 col-sm-12">
     <div class="form">                          
     <div class="form-group">
        <select class="form-control" name="tipo_filtro" required ng-model="vm.tmodal_bancos.tipo_filtro">
          <option value="1">Bancos</option>
          <option value="2">Clientes</option>
        </select>     
     </div>
     </div>
     </div>

     <div class="col-12 col-sm-12" ng-show="vm.tmodal_bancos.tipo_filtro==1">
     <div class="form">                          
     <div class="form-group">
     
      <select class="form-control" name="CodBan" ng-model="vm.tmodal_bancos.CodBan">
        <option ng-repeat="dato in vm.tListBanc" value="{{dato.CodBan}}">{{dato.DesBan}}</option>                        
      </select>   
     </div>
     </div>
    </div>

    <div class="col-12 col-sm-12" ng-show="vm.tmodal_bancos.tipo_filtro==2">
     <div class="form">                          
     <div class="form-group">     
       <select class="form-control" id="CodCliBanFil" name="CodCli" ng-model="vm.tmodal_bancos.CodCli" > 
          <option ng-repeat="dato_act in vm.Tclientes" value="{{dato_act.CodCli}}">{{dato_act.NumCifCli}} - {{dato_act.RazSocCli}}</option>                          
        </select>  
     </div>
     </div>
    </div>
    <div style="margin-left:15px; ">
     <button class="btn btn-info" type="submit" ng-disabled="frmfiltrobancos.$invalid">Aplicar</button>
      <a class="btn btn-danger" ng-click="vm.regresar_filtro_bancos()">Borrar Filtro</a>
      </div>
</form>
   </div>
    </div>
</div>
</div>
</div>
<!--modal container section end -->

              </section>
            </div>
        </div>
      </section>
    </section>

</div>
</body>
<div id="carganto_servicio" class="loader loader-default"  data-text="Cargando Información"></div>
<div id="cuentas_bancarias" class="loader loader-default"  data-text="Cargando listado de Cuentas Bancarias"></div>

<div id="borrando" class="loader loader-default"  data-text="Eliminando Cliente"></div>
<div id="NumCifCom" class="loader loader-default"  data-text="Comprobando CIF"></div>

</html>
