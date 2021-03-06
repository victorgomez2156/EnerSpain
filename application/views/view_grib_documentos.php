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
 <div ng-controller="Controlador_Documentos as vm" ng-init="vm.cargar_documentos()">
 <!--main content start-->
    <section id="main-content">
      <!--wrapper start-->
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header">Listado de Documentos</h3>
            <!--<ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>              
              <li><i class="fa fa-file"></i>Documentos</li>
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
                  <li><input type="checkbox" ng-model="vm.CodCli"/> <b style="color:black;">CodCli</b></li>
                  <li><input type="checkbox" ng-model="vm.NumCifCli"/> <b style="color:black;">CIF</b></li>
                  <li><input type="checkbox" ng-model="vm.RazSocCli"/> <b style="color:black;">Raz??n Social</b></li>
                  <li><input type="checkbox" ng-model="vm.CodTipDoc"/> <b style="color:black;">Tipo Documento</b></li></li>
                  <li><input type="checkbox" ng-model="vm.DesDoc"/> <b style="color:black;">Fichero</b></li></li>
                  <li><input type="checkbox" ng-model="vm.TieVen"/> <b style="color:black;">Tiene Vencimiento</b></li>
                  <li><input type="checkbox" ng-model="vm.FecVenDoc"/> <b style="color:black;">Fecha Vencimiento</b></li>
                  <li><input type="checkbox" ng-model="vm.AccDoc"/> <b style="color:black;">Acci??n</b></li>
                </ul> 
              </div>
              <div class="btn-group" ng-show="vm.Nivel==1 || vm.Nivel==2">
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
                    <input type="text" class="form-control" ng-model="vm.filtrar_search" minlength="1" placeholder="Escribe para filtrar..." ng-keyup="vm.FetchDocumentos()">
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
              <th ng-show="vm.CodCli==true">CodCli</th>
              <th ng-show="vm.NumCifCli==true">CIF</th>
              <th ng-show="vm.RazSocCli==true">Raz??n Social</th>
              <th ng-show="vm.CodTipDoc==true">Tipo de Documento</th>
              <th ng-show="vm.DesDoc==true">Fichero</th>
              <th ng-show="vm.TieVen==true">Tiene Vencimiento</th> 
              <th ng-show="vm.FecVenDoc==true">Fecha Vencimiento</th>                
              <th ng-show="vm.AccDoc==true">Acci??n</th>
            </tr>
            <tr ng-show="vm.T_Documentos.length==0"> 
              <td colspan="8" align="center">
                <div class="td-usuario-table"><i class="fa fa-close"></i> No hay Documentos registrados</div>
              </td>           
            </tr>
                <tr ng-repeat="dato in vm.T_Documentos | filter:paginate7" ng-class-odd="odd">
                  <td ng-show="vm.CodCli==true">{{dato.CodCli}}</td>
                  <td ng-show="vm.NumCifCli==true">{{dato.NumCifCli}}</td>
                  <td ng-show="vm.RazSocCli==true">{{dato.RazSocCli}}</td>
                  <td ng-show="vm.CodTipDoc==true">{{dato.DesTipDoc}}</td>
                  <td ng-show="vm.DesDoc==true">{{dato.DesDoc}}</td>                    
                  <td ng-show="vm.TieVen==true">{{dato.TieVenDes}}</td> 
                  <td ng-show="vm.FecVenDoc==true">{{dato.FecVenDoc}}</td> 
                  <td ng-show="vm.AccDoc==true">
                    <div class="btn-group">
                      <select class="form-control" style="width: auto;" id="opciones_documentos" name="opciones_documentos" ng-model="vm.opciones_documentos[$index]" ng-change="vm.validar_opc_documentos($index,vm.opciones_documentos[$index],dato)">
                        <option ng-repeat="opcion in vm.topciondocumentos" value="{{opcion.id}}">{{opcion.nombre}}</option>                          
                      </select>
                    </div>
                  </td>
                  </tr>
                </tbody>
                <tfoot>                 
                <th ng-show="vm.CodCli==true">CodCli</th>
              <th ng-show="vm.NumCifCli==true">CIF</th>
              <th ng-show="vm.RazSocCli==true">Raz??n Social</th>
              <th ng-show="vm.CodTipDoc==true">Tipo de Documento</th>
              <th ng-show="vm.DesDoc==true">Fichero</th>
              <th ng-show="vm.TieVen==true">Tiene Vencimiento</th> 
              <th ng-show="vm.FecVenDoc==true">Fecha Vencimiento</th>                
              <th ng-show="vm.AccDoc==true">Acci??n</th>
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
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">??</button>
            <h4 class="modal-title">Seleccione Filtro</h4>
          </div>
          <div class="modal-body">
                        <div class="panel">                  
      <form class="form-validate" id="frmfildocumentos" name="frmfildocumentos" ng-submit="SubmitFormFiltrosDocumentos($event)">                 
     
     <div class="col-12 col-sm-12">
     <div class="form">                          
     <div class="form-group">
        <select class="form-control" name="tipo_filtro" required ng-model="vm.t_modal_documentos.tipo_filtro">
          <option value="1">Cliente</option>
          <option value="2">Tipo de Documento</option>
          <option value="3">Tiene Vencimiento</option>
        </select>     
     </div>
     </div>
     </div>    

    <div class="col-12 col-sm-12" ng-show="vm.t_modal_documentos.tipo_filtro==1">
     <div class="form">                          
     <div class="form-group">     
       
        <input type="text" class="form-control" ng-model="vm.NumCifCliSearch" placeholder="* Introduzca CIF" ng-keyup='  vm.fetchClientes(1)' ng-click='vm.searchboxClicked($event)' ng-disabled="vm.restringir_cliente_doc==1||vm.no_editable_doc==1"/>
          <ul id='searchResult'>
            <li ng-click='vm.setValue($index,$event,result,1)' ng-repeat="result in vm.searchResult" >
            {{ result.CodCli }},  {{ result.NumCifCli }} - {{ result.RazSocCli }} 
            </li>
          </ul> 
        <input type="hidden" name="CodCli" id="CodCli" ng-model="vm.t_modal_documentos.CodCli" class="form-control">
      
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
     <button class="btn btn-info" type="submit" ng-disabled="frmfildocumentos.$invalid">Aplicar</button>
      <a class="btn btn-danger" ng-click="vm.regresar_filtro_documentos()">Borrar Filtro</a>
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
<!--main content end-->
     <div class="text-right">
      <div class="credits">
          <!--
            All the links in the footer should remain intact.
            You can delete the links only if you purchased the pro version.
            Licensing information: https://bootstrapmade.com/license/
            Purchase the pro version form: https://bootstrapmade.com/buy/?theme=NiceAdmin
          -->
          Dise??ado Por <a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2019 - 2021</a>
        </div>
    </div>
</div>
</body>
<div id="carganto_servicio" class="loader loader-default"  data-text="Cargando Informaci??n"></div>
<div id="cargar_documentos" class="loader loader-default"  data-text="Cargando listado de Documentos"></div>

<div id="borrando" class="loader loader-default"  data-text="Eliminando Cliente"></div>
<div id="NumCifCom" class="loader loader-default"  data-text="Comprobando CIF"></div>

</html>
