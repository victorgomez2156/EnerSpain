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
 <div ng-controller="Controlador_Documentos as vm">
 <!--main content start-->
    <section id="main-content">
      <!--wrapper start-->
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-file"></i> Documentos</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>              
              <li><i class="fa fa-file"></i>Documentos</li>
            </ol>
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
                  <li><input type="checkbox" ng-model="vm.DocClie"/> <i class="fa fa-plus-square"></i> <b style="color:black;">CLIENTES</b></li>
                  <li><input type="checkbox" ng-model="vm.CodTipDoc"/> <i class="fa fa-plus-square"></i> <b style="color:black;">TIPO DOCUMENTO</b></li></li>
                  <li><input type="checkbox" ng-model="vm.DesDoc"/> <i class="fa fa-plus-square"></i> <b style="color:black;">NOMBRE DEL FICHERO</b></li></li>
                  <li><input type="checkbox" ng-model="vm.TieVen"/> <i class="fa fa-plus-square"></i> <b style="color:black;">TIENE VENCIMIENTO</b></li>
                  <li><input type="checkbox" ng-model="vm.FecVenDoc"/> <i class="fa fa-plus-square"></i> <b style="color:black;">FECHA VENCIMIENTO</b></li>
                  <li><input type="checkbox" ng-model="vm.AccDoc"/> <i class="fa fa-plus-square"></i> <b style="color:black;">ACCIÓN</b></li>
                </ul> 
              </div>
              <div class="btn-group">
                <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button"><i class="fa fa-cloud-upload"></i><span class="caret"></span> </button>
                 <ul class="dropdown-menu">
                  <li style="cursor: pointer;"><a title='Exportar PDF' target="_black"  href="reportes/Exportar_Documentos/Clientes_Doc_PDF_Documentos/{{vm.ruta_reportes_pdf_Documentos}}"><i class="fa fa-file"></i> Exportar en PDF</a></li>
                  <li style="cursor: pointer;"><a title='Exportar Excel' target="_black" href="reportes/Exportar_Documentos/Clientes_Doc_Excel_Documentos/{{vm.ruta_reportes_excel_Documentos}}"><i class="fa fa-file-excel-o"></i> Exportar en Excel</a></li>
                </ul>
              </div>
              <div class="btn-group">
                <a data-toggle="modal" title='Filtros' data-target="#modal_filtro_documentos" class="btn btn-default"><div><i class="fa fa-filter"></i><span class="caret"></span></div></a>                     
              </div>
            </div><!--t-0031 end--> 
          </div><!--t-0029 end--> 
        </div><!--DIV removeformobile end-->
          <div style="float:right;margin-left: 0px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
              <div class="t-0029">
                <form class="form-inline" role="form">
                  <div class="form-group">
                    <input type="text" class="form-control" ng-model="vm.t_documentos.filtrar" minlength="1" placeholder="Escribe para filtrar...">
                  </div>  
                   <!--a data-toggle="modal" title="Asignar Actividad" style="margin-right: 5px;" data-target="#modal_asignar_actividades" class="btn btn-info"><div><i class="fa fa-plus-square"></i></div></a-->
                    <a title="Agregar Documentos" style="margin-right: 5px;" href="#/Add_Documentos" class="btn btn-info"><div><i class="fa fa-plus-square"></i></div></a>              
                  
                </form>                    
            </div>
          </div>
        </div>  <!--t-0002 end-->
      <br><br><br><br>
      <div class="table-responsive">
        <table class="table table-striped table-advance table-hover table-responsive">
          <tbody>
            <tr>
              <th ng-show="vm.DocClie==true"><i class="fa fa-users"></i> CLIENTES</th>
              <th ng-show="vm.CodTipDoc==true"><i class="fa fa-bank"></i> TIPO DOCUMENTO</th>
              <th ng-show="vm.DesDoc==true"><i class="fa fa-bank"></i> NOMBRE DEL FICHERO</th>
              <th ng-show="vm.TieVen==true"><i class="fa fa-asterisk"></i> TIENE VENCIMIENTO</th> 
              <th ng-show="vm.FecVenDoc==true"><i class="fa fa-calendar"></i> FECHA VENCIMIENTO</th>                
              <th ng-show="vm.AccDoc==true"><i class="icon_cogs"></i> ACCIÓN</th>
            </tr>
            <tr ng-show="vm.T_Documentos.length==0"> 
              <td colspan="6" align="center">
                <div class="td-usuario-table"><i class="fa fa-close"></i> Actualmente no ahí documentos registrados.</div>
              </td>           
            </tr>
                <tr ng-repeat="dato in vm.T_Documentos | filter:paginate7 | filter:vm.t_documentos.filtrar" ng-class-odd="odd">
                  <td ng-show="vm.DocClie==true">{{dato.NumCifCli}} - {{dato.RazSocCli}}</td>
                  <td ng-show="vm.CodTipDoc==true">{{dato.DesTipDoc}}</td>
                  <td ng-show="vm.DesDoc==true">{{dato.DesDoc}}</td>                    
                  <td ng-show="vm.TieVen==true">{{dato.TieVenDes}}</td> 
                  <td ng-show="vm.FecVenDoc==true">{{dato.FecVenDoc}}</td> 
                  <td ng-show="vm.AccDoc==true">
                    <div class="btn-group">
                      <select class="form-control" id="opciones_documentos" name="opciones_documentos" ng-model="vm.opciones_documentos[$index]" ng-change="vm.validar_opc_documentos($index,vm.opciones_documentos[$index],dato)">
                        <option ng-repeat="opcion in vm.topciondocumentos" value="{{opcion.id}}">{{opcion.nombre}}</option>                          
                      </select>
                    </div>
                  </td>
                  </tr>
                </tbody>
                <tfoot>                 
                <th ng-show="vm.DocClie==true"><i class="fa fa-users"></i> CLIENTES</th>
              <th ng-show="vm.CodTipDoc==true"><i class="fa fa-bank"></i> TIPO DOCUMENTO</th>
              <th ng-show="vm.DesDoc==true"><i class="fa fa-bank"></i> NOMBRE DEL FICHERO</th>
              <th ng-show="vm.TieVen==true"><i class="fa fa-asterisk"></i> TIENE VENCIMIENTO</th> 
              <th ng-show="vm.FecVenDoc==true"><i class="fa fa-calendar"></i> FECHA VENCIMIENTO</th>                
              <th ng-show="vm.AccDoc==true"><i class="icon_cogs"></i> ACCIÓN</th>
                </tfoot>
              </table>
        </div>
         <div align="center">
          <span class="store-qty"> <a ng-click="vm.cargar_documentos()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       
          <div class='btn-group' align="center">
            <pagination total-items="totalItems7" ng-model="currentPage7" max-size="5" boundary-links="true" items-per-page="numPerPage7" class="pagination-sm">  
            </pagination>
          </div>
        </div> 

           <!-- modal container section end -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_filtro_documentos" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Tipos de Filtros</h4>
          </div>
          <div class="modal-body">
                        <div class="panel">                  
      <form class="form-validate" id="frmfildocumentos" name="frmfildocumentos" ng-submit="SubmitFormFiltrosDocumentos($event)">                 
     
     <div class="col-12 col-sm-12">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">TIPO DE FILTRO</label>
      <select class="form-control" name="tipo_filtro" required ng-model="vm.t_modal_documentos.tipo_filtro">
          <option value="1">CLIENTES</option>
          <option value="2">TIPO DOCUMENTO</option>
          <option value="3">TIENE VENCIMIENTO</option>
        </select>     
     </div>
     </div>
     </div>    

    <div class="col-12 col-sm-12" ng-show="vm.t_modal_documentos.tipo_filtro==1">
     <div class="form">                          
     <div class="form-group">     
       <select class="form-control" name="CodCli" ng-model="vm.t_modal_documentos.CodCli" > 
          <option ng-repeat="dato_act in vm.Tclientes" value="{{dato_act.CodCli}}">{{dato_act.NumCifCli}} - {{dato_act.RazSocCli}}</option>                          
        </select>  
     </div>
     </div>
    </div>

     <div class="col-12 col-sm-12" ng-show="vm.t_modal_documentos.tipo_filtro==2">
     <div class="form">                          
     <div class="form-group">     
      <select class="form-control" name="CodTipDoc" ng-model="vm.t_modal_documentos.CodTipDoc">
        <option ng-repeat="dato in vm.tListDocumentos" value="{{dato.CodTipDoc}}">{{dato.DesTipDoc}}</option>                        
      </select>   
     </div>
     </div>
    </div>

    <div class="col-12 col-sm-12" ng-show="vm.t_modal_documentos.tipo_filtro==3">
     <div class="form">                          
     <div class="form-group">
     
      <select class="form-control" name="TieVen" ng-model="vm.t_modal_documentos.TieVen">
        <option value="1">SI</option>
        <option value="2">NO</option>                         
      </select>   
     </div>
     </div>
    </div>

    <div style="margin-left:15px; ">
     <button class="btn btn-info" type="submit" ng-disabled="frmfildocumentos.$invalid"><i class="fa fa-check-circle"></i> APLICAR</button>
      <a class="btn btn-danger" ng-click="vm.regresar_filtro_documentos()"><i class="fa fa-trash"></i> LIMPIAR FILTRO</a>
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
<div id="carganto_servicio" class="loader loader-default"  data-text="Cargando Datos del Modulo, Por Favor Espere..."></div>
<div id="cargar_documentos" class="loader loader-default"  data-text="Cargando lista de Documentos, Por Favor Espere..."></div>

<div id="borrando" class="loader loader-default"  data-text="Borrando Cliente, Por Favor Espere..."></div>
<div id="NumCifCom" class="loader loader-default"  data-text="Comprobando Número de CIF, Por Favor Espere..."></div>

</html>
