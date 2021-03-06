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

#searchResult{
  list-style: none;
  padding: 0px;
  width: auto;
  position: absolute;
  margin: 0;
  z-index:1151 !important;
}

#searchResult li{
  background: lavender;
  padding: 4px;
  margin-bottom: 1px;
}

#searchResult li:nth-child(even){
  background: cadetblue;
  color: white;
}

#searchResult li:hover{
  cursor: pointer;
}
.datepicker{z-index:1151 !important;}
</style>
<body>
 <div ng-controller="Controlador_Propuestas_Comerciales as vm">
 <!--main content start-->
    <section id="main-content">
      <!--wrapper start-->
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
          	<h3 class="page-header" ng-show="vm.tipo_propuesta==undefined">Listado de Propuestas Comerciales</h3>
            <h3 class="page-header" ng-show="vm.tipo_propuesta==1">Listado de Propuestas Sencillas</h3>
			<h3 class="page-header" ng-show="vm.tipo_propuesta==2">Listado de Propuestas UniCliente - MultiPunto</h3>
			<h3 class="page-header" ng-show="vm.tipo_propuesta==3">Listado de Propuestas MultiCliente  ??? Multipunto</h3>
          </div>
        </div>
        <!-- page start-->
       
        <div class="row">
            <div class="col-lg-12">
              <!--panel start-->
              <section class="panel">
        
          <div class="col-12 col-sm-12">
           <div class="form">                          
           <div class="form-group">
           <label class="font-weight-bold nexa-dark" style="color:black;">Tipos de Propuestas</label>          
          <select class="form-control" id="tipo_propuesta" name="tipo_propuesta" ng-model="vm.tipo_propuesta" ng-change="vm.FiltrarPropuestasComerciales()">
           <option value="1">Sencilla</option>
           <option value="2">UniCliente ??? Multipunto</option> 
           <option value="3">MultiCliente ??? Multipunto</option>        
          </select>         
         </div>
         </div>
      </div>
       
<br><br>  
  <div ng-show="vm.tipo_propuesta==1">
          <div id="t-0002"><!--t-0002 start-->   
          <div style="float:left;margin-left: 0px;padding: 10px;margin-top: 10px;margin-bottom: 2px;" class="removeForMobile"><!--DIV removeformobile start-->                    
            <div class="t-0029"><!--t-0029 start--> 
              <div class="t-0031" style="margin-top: -8px; "><!--t-0031 start-->
                <div class="btn-group">
                  <button data-toggle="dropdown" title="Agregar Columnas" class="btn btn-default" type="button"><i class="fa fa-columns"></i> <span class="caret"></span></button>
                <ul class="dropdown-menu">
                  <li><input type="checkbox" ng-model="vm.FecProCom"/> <b style="color:black;">Fecha</b></li>
                  <li><input type="checkbox" ng-model="vm.CodCli"/> <b style="color:black;">CodCli</b></li>
                  <li><input type="checkbox" ng-model="vm.NifCliente"/> <b style="color:black;">NIF</b></li>
                  <li><input type="checkbox" ng-model="vm.CodCli"/> <b style="color:black;">Cliente</b></li>
                  <li><input type="checkbox" ng-model="vm.CUPsEle"/> <b style="color:black;">CUPs El??ctrico</b></li>
                  <li><input type="checkbox" ng-model="vm.CUPsGas"/>  <b style="color:black;">CUPs Gas</b></li>
                  <li><input type="checkbox" ng-model="vm.EstPro"/> <b style="color:black;">Estatus</b></li>
                  <li><input type="checkbox" ng-model="vm.ActPro"/> <b style="color:black;">Acci??n</b></li>
                </ul> 
              </div>
              <div class="btn-group" ng-show="vm.Nivel==1 || vm.Nivel==2">
                <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button"><i class="fa fa-cloud-upload"></i><span class="caret"></span> </button>
                 <ul class="dropdown-menu">
                  <li style="cursor: pointer;"><a title='Exportar PDF' target="_black"  href="reportes/Exportar_Documentos/Doc_Propuestas_PDF/{{vm.ruta_reportes_pdf_Propuestas}}"><i class="fa fa-file"></i> Exportar en PDF</a></li>
                  <li style="cursor: pointer;"><a title='Exportar Excel' target="_black" href="reportes/Exportar_Documentos/Doc_Propuestas_Excel/{{vm.ruta_reportes_excel_Propuestas}}"><i class="fa fa-file-excel-o"></i> Exportar en Excel</a></li>
                </ul>
              </div>
              <div class="btn-group">
                <a data-toggle="modal" title='Filtros' data-target="#modal_filtros_propuestas" class="btn btn-default"><div><i class="fa fa-filter"></i><span class="caret"></span></div></a>                     
              </div>
            </div><!--t-0031 end--> 
          </div><!--t-0029 end--> 
        </div><!--DIV removeformobile end-->
          <div style="float:right;margin-left: 0px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
              <div class="t-0029">
                <form class="form-inline" role="form">
                  <div class="form-group">
                    <input type="text" class="form-control" ng-model="vm.filtrar_search" minlength="1" id="exampleInputEmail2" placeholder="Escribe para filtrar..." ng-keyup="vm.FetchPropuestaComerciales(1)">
                  </div>  
                   <a data-toggle="modal" title="Agregar Propuesta Comercial" style="margin-right: 5px;" data-target="#modal_add_propuesta" class="btn btn-info"><div><i class="fa fa-plus-square"></i></div></a>                  
                </form>                    
            </div>
          </div>
        </div>  <!--t-0002 end-->
      <br><br><br><br>
       <div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive">
                <tbody>
                  <tr>
                  <th ng-show="vm.FecProCom==true">Fecha</th>
                  <th ng-show="vm.CodCli==true">CodCli</th>
                  <th ng-show="vm.NifCliente==true">NIF</th>
                  <th ng-show="vm.CodCli==true">Cliente</th>
                  <th ng-show="vm.CUPsEle==true">CUPs El??ctrico</th>
                  <th ng-show="vm.CUPsGas==true">CUPs Gas</th> 
                  <th ng-show="vm.EstPro==true">Estatus</th>                
                  <th ng-show="vm.ActPro==true">Acci??n</th>
                  </tr>
                  <tr ng-show="vm.TPropuesta_Comerciales.length==0"> 
                    <td colspan="8" align="center">
                      <div class="td-usuario-table"><i class="fa fa-close"></i> No hay informaci??n</div>
                    </td>           
                    </tr>
                  <tr ng-repeat="dato in vm.TPropuesta_Comerciales | filter:paginate" ng-class-odd="odd">
                    
                    <td ng-show="vm.FecProCom==true">{{dato.FecProCom}}</td>
                    <td ng-show="vm.NifCliente==true">{{dato.CodCli}}</td>
                    <td ng-show="vm.NifCliente==true">{{dato.NumCifCli}}</td>
                    <td ng-show="vm.CodCli==true">{{dato.RazSocCli}}</td>
                    <td ng-show="vm.CUPsEle==true">{{dato.CUPsEle}}</td>
                    <td ng-show="vm.CUPsGas==true">{{dato.CupsGas}}</td> 
                    <td ng-show="vm.EstPro==true">
                      
                      <span class="label label-info" style="background-color: #FFFF00" ng-show="dato.EstProCom=='P'"><i style="color:black;" class="fa fa-clock-o"></i> <b style="color:black;">Pendiente</b></span>
                      <span class="label label-info" ng-show="dato.EstProCom=='A'"><i class="fa fa-check-circle"></i> Aprobada</span>
                      <span class="label label-success" ng-show="dato.EstProCom=='C'"><i class="fa fa-check-circle"></i> Completada</span>  
                      <span class="label label-danger" ng-show="dato.EstProCom=='R'"><i class="fa fa-ban"></i> Rechazada</span>
                   </td>
                    <td ng-show="vm.ActPro==true">
                      <div class="btn-group">
                        <select class="form-control" style="width: auto;" id="opcion_select" name="opcion_select" ng-model="vm.opcion_select[$index]" ng-change="vm.validar_opcion_propuestas($index,vm.opcion_select[$index],dato,1)">
                          <option ng-repeat="opcion in vm.opciones_propuestas" value="{{opcion.id}}">{{opcion.nombre}}</option>
                        </select>
                      </div>
                    </td>

                  </tr>
                </tbody>
                <tfoot>                 
                  <th ng-show="vm.FecProCom==true">Fecha</th>
                  <th ng-show="vm.CodCli==true">CodCli</th>
                  <th ng-show="vm.NifCliente==true">NIF</th>
                  <th ng-show="vm.CodCli==true">Cliente</th>
                  <th ng-show="vm.CUPsEle==true">CUPs El??ctrico</th>
                  <th ng-show="vm.CUPsGas==true">CUPs Gas</th> 
                  <th ng-show="vm.EstPro==true">Estatus</th>                
                  <th ng-show="vm.ActPro==true">Acci??n</th>
                </tfoot>
              </table>
        </div> 
        <div align="center">
          <span class="store-qty"> <a ng-click="vm.FiltrarPropuestasComerciales()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       
          <div class='btn-group' align="center">
            <pagination total-items="totalItems" ng-model="currentPage" max-size="5" boundary-links="true" items-per-page="numPerPage" class="pagination-sm">  
            </pagination>
          </div>
        </div>
</div>

<div ng-show="vm.tipo_propuesta==2">
          <div id="t-0002"><!--t-0002 start-->   
          <div style="float:left;margin-left: 0px;padding: 10px;margin-top: 10px;margin-bottom: 2px;" class="removeForMobile"><!--DIV removeformobile start-->                    
            <div class="t-0029"><!--t-0029 start--> 
              <div class="t-0031" style="margin-top: -8px; "><!--t-0031 start-->
                <div class="btn-group">
                  <button data-toggle="dropdown" title="Agregar Columnas" class="btn btn-default" type="button"><i class="fa fa-columns"></i> <span class="caret"></span></button>
                <ul class="dropdown-menu">
                  <li><input type="checkbox" ng-model="vm.FecProComUniCli"/> <b style="color:black;">Fecha</b></li>
                  <li><input type="checkbox" ng-model="vm.CodCliUniCli"/> <b style="color:black;">CodCli</b></li>
                  <li><input type="checkbox" ng-model="vm.NifClienteUniCli"/> <b style="color:black;">NIF</b></li>
                  <li><input type="checkbox" ng-model="vm.NomCliUniCli"/> <b style="color:black;">Cliente</b></li>
                  <li><input type="checkbox" ng-model="vm.CUPsEleUniCli"/> <b style="color:black;">Cantidad CUPs</b></li>
                  <li><input type="checkbox" ng-model="vm.EstProUniCli"/> <b style="color:black;">Estatus</b></li>
                  <li><input type="checkbox" ng-model="vm.ActProUniCli"/> <b style="color:black;">Acci??n</b></li>
                </ul> 
              </div>
              <div class="btn-group">
                <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button"><i class="fa fa-cloud-upload"></i><span class="caret"></span> </button>
                 <ul class="dropdown-menu">
                  <li style="cursor: pointer;"><a title='Exportar PDF' target="_black"  href="reportes/Exportar_Documentos/Doc_Propuestas_PDF_UniCliente/{{vm.ruta_reportes_pdf_PropuestasUniCli}}"><i class="fa fa-file"></i> Exportar en PDF</a></li>
                  <li style="cursor: pointer;"><a title='Exportar Excel' target="_black" href="reportes/Exportar_Documentos/Doc_Propuestas_Excel_UniCliente/{{vm.ruta_reportes_excel_PropuestasUniCli}}"><i class="fa fa-file-excel-o"></i> Exportar en Excel</a></li>
                </ul>
              </div>
              <div class="btn-group">
                <a data-toggle="modal" title='Filtros' data-target="#modal_filtros_propuestasUniCliente" class="btn btn-default"><div><i class="fa fa-filter"></i><span class="caret"></span></div></a>                     
              </div>
            </div><!--t-0031 end--> 
          </div><!--t-0029 end--> 
        </div><!--DIV removeformobile end-->
          <div style="float:right;margin-left: 0px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
              <div class="t-0029">
                <form class="form-inline" role="form">
                  <div class="form-group">
                    <input type="text" class="form-control" ng-model="vm.filtrar_searchUniCliente" minlength="1" id="exampleInputEmail3" placeholder="Escribe para filtrar..." ng-keyup="vm.FetchPropuestaComerciales(2)">
                  </div>  
                   <a data-toggle="modal" title="Agregar Propuesta Comercial UniCliente - MultiPunto" style="margin-right: 5px;" data-target="#modal_add_propuestaUniCliente" class="btn btn-info"><div><i class="fa fa-plus-square"></i></div></a>                  
                </form>                    
            </div>
          </div>
        </div>  <!--t-0002 end-->
      <br><br><br><br>
       <div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive">
                <tbody>
                  <tr>
                  <th ng-show="vm.FecProComUniCli==true">Fecha</th>
                  <th ng-show="vm.CodCliUniCli==true">CodCli</th>
                  <th ng-show="vm.NifClienteUniCli==true">NIF</th>
                  <th ng-show="vm.NomCliUniCli==true">Cliente</th>
                  <th ng-show="vm.CUPsEleUniCli==true">Cantidad CUPs</th>
                  <th ng-show="vm.EstProUniCli==true">Estatus</th>                
                  <th ng-show="vm.ActProUniCli==true">Acci??n</th>
                  </tr>
                  <tr ng-show="vm.TPropuesta_ComercialesUniCliente.length==0"> 
                    <td colspan="7" align="center">
                      <div class="td-usuario-table"><i class="fa fa-close"></i> No hay informaci??n</div>
                    </td>           
                    </tr>
                  <tr ng-repeat="dato in vm.TPropuesta_ComercialesUniCliente | filter:paginate1" ng-class-odd="odd">
                    
                    <td ng-show="vm.FecProComUniCli==true">{{dato.FecProCom}}</td>
                    <td ng-show="vm.CodCliUniCli==true">{{dato.CodCli}}</td>
                    <td ng-show="vm.NifClienteUniCli==true">{{dato.NumCifCli}}</td>
                    <td ng-show="vm.NomCliUniCli==true">{{dato.RazSocCli}}</td>
                    <td ng-show="vm.CUPsEleUniCli==true">{{dato.TotalCUPs}}</td>                    
                    <td ng-show="vm.EstProUniCli==true">
                       <span class="label label-info" style="background-color: #FFFF00" ng-show="dato.EstProCom=='P'"><i style="color:black;" class="fa fa-clock-o"></i> <b style="color:black;">Pendiente</b></span>
                      <span class="label label-info" ng-show="dato.EstProCom=='A'"><i class="fa fa-check-circle"></i> Aprobada</span>
                      <span class="label label-success" ng-show="dato.EstProCom=='C'"><i class="fa fa-check-circle"></i> Completada</span>  
                      <span class="label label-danger" ng-show="dato.EstProCom=='R'"><i class="fa fa-ban"></i> Rechazada</span>
                   </td>
                    <td ng-show="vm.ActProUniCli==true">
                      <div class="btn-group">
                        <select class="form-control" style="width: auto;" id="opcion_selectUniCli" name="opcion_selectUniCli" ng-model="vm.opcion_selectUniCli[$index]" ng-change="vm.validar_opcion_propuestas($index,vm.opcion_selectUniCli[$index],dato,2)">
                          <option ng-repeat="opcion in vm.opciones_propuestas" value="{{opcion.id}}">{{opcion.nombre}}</option>
                        </select>
                      </div>
                    </td>
                  </tr>
                </tbody>
                <tfoot>                 
                  <th ng-show="vm.FecProComUniCli==true">Fecha</th>
                  <th ng-show="vm.CodCliUniCli==true">CodCli</th>
                  <th ng-show="vm.NifClienteUniCli==true">NIF</th>
                  <th ng-show="vm.NomCliUniCli==true">Cliente</th>
                  <th ng-show="vm.CUPsEleUniCli==true">Cantidad CUPs</th>
                  <th ng-show="vm.EstProUniCli==true">Estatus</th>                
                  <th ng-show="vm.ActProUniCli==true">Acci??n</th>
                </tfoot>
              </table>
        </div> 
        <div align="center">
          <span class="store-qty"> <a ng-click="vm.FiltrarPropuestasComerciales()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       
          <div class='btn-group' align="center">
            <pagination total-items="totalItems1" ng-model="currentPage1" max-size="5" boundary-links="true" items-per-page="numPerPage1" class="pagination-sm">  
            </pagination>
          </div>
        </div>
</div>


<div ng-show="vm.tipo_propuesta==3">
          <div id="t-0002"><!--t-0002 start-->   
          <div style="float:left;margin-left: 0px;padding: 10px;margin-top: 10px;margin-bottom: 2px;" class="removeForMobile"><!--DIV removeformobile start-->                    
            <div class="t-0029"><!--t-0029 start--> 
              <div class="t-0031" style="margin-top: -8px; "><!--t-0031 start-->
                <div class="btn-group">
                  <button data-toggle="dropdown" title="Agregar Columnas" class="btn btn-default" type="button"><i class="fa fa-columns"></i> <span class="caret"></span></button>
                <ul class="dropdown-menu">
                  <li><input type="checkbox" ng-model="vm.FecProComMulCli"/> <b style="color:black;">Fecha</b></li>
                  <li><input type="checkbox" ng-model="vm.NifDni"/> <b style="color:black;">NIF</b></li>
                  <li><input type="checkbox" ng-model="vm.RepLeg"/> <b style="color:black;">Representante Legal</b></li><li><input type="checkbox" ng-model="vm.CanCliMulCli"/> <b style="color:black;">Cantidad Clientes</b></li>
                  <li><input type="checkbox" ng-model="vm.CanCups"/> <b style="color:black;">Cantidad CUPs</b></li>
                  <li><input type="checkbox" ng-model="vm.EstProMulCli"/> <b style="color:black;">Estatus</b></li>
                  <li><input type="checkbox" ng-model="vm.ActProMulCli"/> <b style="color:black;">Acci??n</b></li>
                </ul> 
              </div>
              <div class="btn-group">
                <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button"><i class="fa fa-cloud-upload"></i><span class="caret"></span> </button>
                 <ul class="dropdown-menu">
                  <li style="cursor: pointer;"><a title='Exportar PDF' target="_black"  href="reportes/Exportar_Documentos/Doc_Propuestas_PDF_MultiCliente/{{vm.ruta_reportes_pdf_PropuestasMulCli}}"><i class="fa fa-file"></i> Exportar en PDF</a></li>
                  <li style="cursor: pointer;"><a title='Exportar Excel' target="_black" href="reportes/Exportar_Documentos/Doc_Propuestas_Excel_MultiCliente/{{vm.ruta_reportes_excel_PropuestasMulCli}}"><i class="fa fa-file-excel-o"></i> Exportar en Excel</a></li>
                </ul>
              </div>
              <div class="btn-group">
                <a data-toggle="modal" title='Filtros' data-target="#modal_filtros_propuestasMulCliente" class="btn btn-default"><div><i class="fa fa-filter"></i><span class="caret"></span></div></a>                     
              </div>
            </div><!--t-0031 end--> 
          </div><!--t-0029 end--> 
        </div><!--DIV removeformobile end-->
          <div style="float:right;margin-left: 0px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
              <div class="t-0029">
                <form class="form-inline" role="form">
                  <div class="form-group">
                    <input type="text" class="form-control" ng-model="vm.filtrar_searchMulCliente" minlength="1" id="exampleInputEmail4" placeholder="Escribe para filtrar..." ng-keyup="vm.FetchPropuestaComerciales(3)">
                  </div>  
                   <a data-toggle="modal" title="Agregar Propuesta Comercial MultiCliente - MultiPunto" style="margin-right: 5px;" data-target="#modal_add_propuestaMulCliente" class="btn btn-info"><div><i class="fa fa-plus-square"></i></div></a>                  
                </form>                    
            </div>
          </div>
        </div>  <!--t-0002 end-->
      <br><br><br><br>
       <div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive">
                <tbody>
                  <tr>
                  <th ng-show="vm.FecProComMulCli==true">Fecha</th>
                  <th ng-show="vm.NifDni==true">NIF</th>
                  <th ng-show="vm.RepLeg==true">Representante Legal</th>
                  <th ng-show="vm.CanCliMulCli==true">Cantidad Clientes</th>                  
                  <th ng-show="vm.CanCups==true">Cantidad CUPs</th>
                  <th ng-show="vm.EstProMulCli==true">Estatus</th>                
                  <th ng-show="vm.ActProMulCli==true">Acci??n</th>
                  </tr>
                  <tr ng-show="vm.TPropuesta_ComercialesMulCliente.length==0"> 
                    <td colspan="8" align="center">
                      <div class="td-usuario-table"><i class="fa fa-close"></i> No hay informaci??n</div>
                    </td>           
                    </tr>
                  <tr ng-repeat="dato in vm.TPropuesta_ComercialesMulCliente | filter:paginate2" ng-class-odd="odd">
                    
                    <td ng-show="vm.FecProComMulCli==true">{{dato.FecProCom}}</td>
                    <td ng-show="vm.NifDni==true">{{dato.NumCifCli}}</td>
                    <td ng-show="vm.RepLeg==true">{{dato.RazSocCli}}</td>
                    <td ng-show="vm.CanCliMulCli==true">{{dato.CantCli}}</td>
                    <td ng-show="vm.CanCups==true">{{dato.CantCups}}</td>                    
                    <td ng-show="vm.EstProMulCli==true">
                      <span class="label label-info" style="background-color: #FFFF00" ng-show="dato.EstProCom=='P'"><i style="color:black;" class="fa fa-clock-o"></i> <b style="color:black;">Pendiente</b></span>
                      <span class="label label-info" ng-show="dato.EstProCom=='A'"><i class="fa fa-check-circle"></i> Aprobada</span>
                      <span class="label label-success" ng-show="dato.EstProCom=='C'"><i class="fa fa-check-circle"></i> Completada</span>  
                      <span class="label label-danger" ng-show="dato.EstProCom=='R'"><i class="fa fa-ban"></i> Rechazada</span>
                   </td>
                    <td ng-show="vm.ActProMulCli==true">
                      <div class="btn-group">
                        <select class="form-control" style="width: auto;" id="opcion_selectMulCli" name="opcion_selectMulCli" ng-model="vm.opcion_selectMulCli[$index]" ng-change="vm.validar_opcion_propuestas($index,vm.opcion_selectMulCli[$index],dato,3)">
                          <option ng-repeat="opcion in vm.opciones_propuestas" value="{{opcion.id}}">{{opcion.nombre}}</option>
                        </select>
                      </div>
                    </td>
                  </tr>
                </tbody>
                <tfoot>                 
                  <th ng-show="vm.FecProComMulCli==true">Fecha</th>
                  <th ng-show="vm.NifDni==true">NIF</th>
                  <th ng-show="vm.RepLeg==true">Representante Legal</th>
                  <th ng-show="vm.CanCliMulCli==true">Cantidad Clientes</th>                  
                  <th ng-show="vm.CanCups==true">Cantidad CUPs</th>
                  <th ng-show="vm.EstProMulCli==true">Estatus</th>                
                  <th ng-show="vm.ActProMulCli==true">Acci??n</th>
                </tfoot>
              </table>
        </div> 
        <div align="center">
          <span class="store-qty"> <a ng-click="vm.FiltrarPropuestasComerciales()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       
          <div class='btn-group' align="center">
            <pagination total-items="totalItems2" ng-model="currentPage2" max-size="5" boundary-links="true" items-per-page="numPerPage2" class="pagination-sm">  
            </pagination>
          </div>
        </div>
</div>



<!-- modal container section end -->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_filtros_propuestas" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">??</button>
            <h4 class="modal-title">Seleccione Filtro</h4>
          </div>
          <div class="modal-body">
    <div class="panel">                 
      <form class="form-validate" id="frmfiltroPropuestas" name="frmfiltroPropuestas" ng-submit="SubmitFormFiltrosPropuestas($event,1)">

    <div class="col-12 col-sm-12">
     <div class="form">                          
     <div class="form-group">
        <select class="form-control" name="tipo_filtro" required ng-model="vm.tmodal_filtros.tipo_filtro">
          <option value="1">Rango de Fechas</option>
          <option value="2">Clientes</option>
          <option value="3">Estatus</option>
        </select>     
     </div>
     </div>
     </div>

     <div class="col-12 col-sm-12" ng-show="vm.tmodal_filtros.tipo_filtro==1">
     <div class="form">                          
     <div class="form-group">
        <input type="text" name="RangFec" id="RangFec" class="form-control RangFec" ng-model="vm.RangFec" placeholder="DD/MM/YYYY">   
     </div>
     </div>
     </div>

     <div class="col-12 col-sm-12" ng-show="vm.tmodal_filtros.tipo_filtro==2" ng-click="vm.containerClicked()">
     <div class="form">                          
     <div class="form-group">
        <input type="text" class="form-control" ng-model="vm.NumCifCli" placeholder="* Representante" ng-keyup='vm.fetchClientes(2)' ng-click='vm.searchboxClicked($event)'/>
        <ul id='searchResult'>
          <li ng-click='vm.setValue($index,$event,result,2)' ng-repeat="result in vm.searchResult" >
          {{ result.CodCli }}, {{ result.NumCifCli }} - {{ result.RazSocCli }} 
          </li>
        </ul>   
     </div>
     </div>
     <input type="hidden" name="CodCliFil" id="CodCliFil" ng-model="vm.CodCliFil">
     </div>

      <div class="col-12 col-sm-12" ng-show="vm.tmodal_filtros.tipo_filtro==3" ng-click="vm.containerClicked()">
         <div class="form">                          
         <div class="form-group">
          <select class="form-control" id="EstProCom" name="EstProCom" ng-model="vm.EstProComFil">
         <option value="P">Pendiente</option>
         <option value="A">Aprobada</option> 
         <option value="C">Completada</option> 
         <option value="R">Rechazada</option>                         
        </select>
         
         </div>
         </div>
      </div>
    <div style="margin-left:15px; ">
     <button class="btn btn-info" type="submit" ng-disabled="frmfiltroPropuestas.$invalid">Aplicar</button>
      <a class="btn btn-danger" ng-click="vm.regresar_filtro(1)">Borrar Filtro</a>
      </div>
  </form>
     </div>
      </div>
  </div>
  </div>
</div>
<!--modal container section end -->

<!-- modal modal_filtros_propuestasUniCliente start -->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_filtros_propuestasUniCliente" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">??</button>
            <h4 class="modal-title">Seleccione Filtro</h4>
          </div>
          <div class="modal-body">
    <div class="panel">                 
      <form class="form-validate" id="frmfiltroPropuestasUniCliente" name="frmfiltroPropuestasUniCliente" ng-submit="SubmitFormFiltrosPropuestas($event,2)">

    <div class="col-12 col-sm-12">
     <div class="form">                          
     <div class="form-group">
        <select class="form-control" name="tipo_filtro" required ng-model="vm.tmodal_filtros.tipo_filtro">
          <option value="1">Rango de Fechas</option>
          <option value="2">Clientes</option>
          <option value="3">Estatus</option>
        </select>     
     </div>
     </div>
     </div>

     <div class="col-12 col-sm-12" ng-show="vm.tmodal_filtros.tipo_filtro==1">
     <div class="form">                          
     <div class="form-group">
        <input type="text" name="RangFec1" id="RangFec1" class="form-control RangFec" ng-model="vm.RangFec" placeholder="DD/MM/YYYY">   
     </div>
     </div>
     </div>

     <div class="col-12 col-sm-12" ng-show="vm.tmodal_filtros.tipo_filtro==2" ng-click="vm.containerClicked()">
     <div class="form">                          
     <div class="form-group">
        <input type="text" class="form-control" ng-model="vm.NumCifCli" placeholder="* Representante" ng-keyup='vm.fetchClientes(2)' ng-click='vm.searchboxClicked($event)'/>
        <ul id='searchResult'>
          <li ng-click='vm.setValue($index,$event,result,2)' ng-repeat="result in vm.searchResult" >
          {{ result.CodCli }}, {{ result.NumCifCli }} - {{ result.RazSocCli }} 
          </li>
        </ul>   
     </div>
     </div>
     <input type="hidden" name="CodCliFil1" id="CodCliFil1" ng-model="vm.CodCliFil">
     </div>

      <div class="col-12 col-sm-12" ng-show="vm.tmodal_filtros.tipo_filtro==3" ng-click="vm.containerClicked()">
         <div class="form">                          
         <div class="form-group">
          <select class="form-control" id="EstProCom1" name="EstProCom1" ng-model="vm.EstProComFil">
         <option value="P">Pendiente</option>
         <option value="A">Aprobada</option> 
         <option value="C">Completada</option> 
         <option value="R">Rechazada</option>                         
        </select>
         
         </div>
         </div>
      </div>
    <div style="margin-left:15px; ">
     <button class="btn btn-info" type="submit" ng-disabled="frmfiltroPropuestasUniCliente.$invalid">Aplicar</button>
      <a class="btn btn-danger" ng-click="vm.regresar_filtro(2)">Borrar Filtro</a>
      </div>
  </form>
     </div>
      </div>
  </div>
  </div>
</div>
<!--modal modal_filtros_propuestasUniCliente end -->

<!-- modal modal_filtros_propuestasMulCliente start -->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_filtros_propuestasMulCliente" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">??</button>
            <h4 class="modal-title">Seleccione Filtro</h4>
          </div>
          <div class="modal-body">
    <div class="panel">                 
      <form class="form-validate" id="frmfiltroMultiClienteMultiPunto" name="frmfiltroMultiClienteMultiPunto" ng-submit="SubmitFormFiltrosPropuestas($event,3)">

    <div class="col-12 col-sm-12">
     <div class="form">                          
     <div class="form-group">
        <select class="form-control" name="tipo_filtro" required ng-model="vm.tmodal_filtros.tipo_filtro">
          <option value="1">Rango de Fechas</option>
          <option value="2">Clientes</option>
          <option value="3">Estatus</option>
        </select>     
     </div>
     </div>
     </div>

     <div class="col-12 col-sm-12" ng-show="vm.tmodal_filtros.tipo_filtro==1">
     <div class="form">                          
     <div class="form-group">
        <input type="text" name="RangFec2" id="RangFec2" class="form-control RangFec" ng-model="vm.RangFec" placeholder="DD/MM/YYYY">   
     </div>
     </div>
     </div>

     <div class="col-12 col-sm-12" ng-show="vm.tmodal_filtros.tipo_filtro==2" ng-click="vm.containerClicked()">
     <div class="form">                          
     <div class="form-group">
        <input type="text" class="form-control" ng-model="vm.NumCifCliUniMulCli" placeholder="* Representante" ng-keyup='vm.fetchClientes(3)' ng-click='vm.searchboxClicked($event)'/>
        <ul id='searchResult'>
          <li ng-click='vm.setValue($index,$event,result,3)' ng-repeat="result in vm.searchResult" >
          {{ result.CodCli }}, {{ result.NumCifCli }} - {{ result.RazSocCli }} 
          </li>
        </ul>   
     </div>
     </div>
     <input type="hidden" name="CodCliFil2" id="CodCliFil2" ng-model="vm.CodCliFil">
     </div>

      <div class="col-12 col-sm-12" ng-show="vm.tmodal_filtros.tipo_filtro==3" ng-click="vm.containerClicked()">
         <div class="form">                          
         <div class="form-group">
          <select class="form-control" id="EstProCom2" name="EstProCom2" ng-model="vm.EstProComFil">
         <option value="P">Pendiente</option>
         <option value="A">Aprobada</option> 
         <option value="C">Completada</option> 
         <option value="R">Rechazada</option>                         
        </select>
         
         </div>
         </div>
      </div>
    <div style="margin-left:15px; ">
     <button class="btn btn-info" type="submit" ng-disabled="frmfiltroMultiClienteMultiPunto.$invalid">Aplicar</button>
      <a class="btn btn-danger" ng-click="vm.regresar_filtro(3)">Borrar Filtro</a>
      </div>
  </form>
     </div>
      </div>
  </div>
  </div>
</div>
<!--modal modal_filtros_propuestasMulCliente end -->

<!-- modal modal_contratosProRenPen start -->
  <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_contratosProRenPen" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">??</button>
            <h4 class="modal-title">Contratos Renovaci??n Pendiente</h4>
          </div>
          <div class="modal-body">
                        <div class="panel">                  
        <form class="form-validate" id="frmProRenPen" name="frmProRenPen" ng-submit="SubmitFormContratosProRenPen($event)">                  
        <div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive">
                <tbody>
                  <tr>
                  <th></th>
                  <th>Tipo Propuesta</th>
                  <th>Fecha Inicio</th>
                  <th>Duraci??n</th>  
                  <th>Vencimiento</th>
                  <th>Estatus</th>
                  </tr>
                  <tr ng-show="vm.T_ContratosProRenPen.length==0"> 
                    <td colspan="8" align="center">
                      <div class="td-usuario-table"><i class="fa fa-close"></i> No existe informaci??n.</div>
                    </td>           
                    </tr>
                  <tr ng-repeat="dato in vm.T_ContratosProRenPen | filter:paginate6" ng-class-odd="odd">                    
                    <td>

                      <!--input type="checkbox" name="select_contra_{{$index}}" id="select_contra_{{$index}}" ng-model="vm.select_ContrProRenPen[$index]" ng-click="vm.SelectContrato($index,dato,vm.select_ContrProRenPen[$index])"-->
                      <button type="button"  ng-click="vm.agregar_ContratoProRenPen($index,dato.CodConCom,dato)" title="Seleccionar" ng-show="!vm.select_DetProPenRen[dato.CodConCom]"><i class="fa fa fa-square-o" style="color:black;"></i></button>
                                            
                      <button type="button" ng-show="vm.select_DetProPenRen[dato.CodConCom]" ng-click="vm.quitar_ContratoProRenPen($index,dato.CodConCom,dato)"><i class="fa fa fa-check-circle" title="Quitar" style="color:green;"></i></button> 
                    </td>
                    <td>
                      <span class="label label-danger" ng-show="dato.TipProCom==1"><i class="fa fa-user"></i> Sencilla</span>
                      <span class="label label-info" ng-show="dato.TipProCom==2"><i class="fa fa-user"></i> UniCliente - MultiPunto</span>
                      <span class="label label-primary" ng-show="dato.TipProCom==3"><i class="fa fa-users"></i> MultiCliente - MultiPunto</span></td>
                    <td>{{dato.FecIniCon}}</td>
                    <td>{{dato.DurCon}} Meses</td> 
                    <td>{{dato.FecVenCon}}</td>
                    <td>
                      <span class="label label-success" ng-show="dato.EstBajCon==0"><i class="fa fa-check-circle"></i> Activo</span>
                      <span class="label label-danger" ng-show="dato.EstBajCon==1"><i class="fa fa-ban"></i> Dado de Baja</span>
                      <span class="label label-info" ng-show="dato.EstBajCon==2"><i class="fa fa-close"></i> Vencido</span>
                      <span class="label label-primary" ng-show="dato.EstBajCon==3"><i class="fa fa-check-circle"></i> Renovado</span>
                      <span class="label label-warning" ng-show="dato.EstBajCon==4"><i class="fa fa-check-clock-o"></i> En Renovaci??n</span>
                   </td>
                   
                  </tr>
                </tbody>
                <tfoot> 
                  <th></th>
                  <th>Tipo Propuesta</th>
                  <th>Fecha Inicio</th>
                  <th>Duraci??n</th>  
                  <th>Vencimiento</th>
                  <th>Estatus</th>
                </tfoot>
              </table>
        </div>
      <div style="margin-left:15px; ">
        <button class="btn btn-info" type="submit" ng-disabled="frmProRenPen.$invalid">Renovar</button>
      </div>
    </form>
   </div>
    </div>
    </div>
    </div>
  </div>
<!--modal modal_contratosProRenPen end -->

<!--modal modal_add_propuesta section START -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_add_propuesta" class="modal fade">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">??</button>
                        <h4 class="modal-title">NIF/Nombre</h4>
                      </div>
                      <div class="modal-body">
                        <form class="form-horizontal" role="form" id="cif_consulta_form" name="cif_consulta_form" ng-submit="Consultar_CIF($event)" ng-click="vm.containerClicked()"> 
                          <div class="form-group">
                            <label for="inputEmail1" class="col-lg-2 control-label">NIF/Nombre:</label>
                            <div class="col-lg-10">
                              <input type="text" class="form-control" ng-model="vm.NumCifCli" placeholder="* NIF/Nombre" required ng-keyup='vm.fetchClientes(1)' ng-click='vm.searchboxClicked($event)'/>                                
                             <ul id='searchResult'>
                              <li ng-click='vm.setValue($index,$event,result,1)' ng-repeat="result in vm.searchResult" >
                               {{ result.NumCifCli }} - {{ result.RazSocCli }} 
                              </li>
                            </ul> 



                            </div>
                          </div>
                          <button class="btn btn-info" type="submit" ng-disabled="cif_consulta_form.$invalid"> Consultar</button>
                        </form>
                      </div>
                    </div>
                  </div>
  </div>
<!--modal modal_add_propuesta section END -->

<!--modal modal_add_propuestaUniCliente section START -->
  <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_add_propuestaUniCliente" class="modal fade">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">??</button>
                        <h4 class="modal-title">NIF/Nombre</h4>
                      </div>
                      <div class="modal-body">
                        <form class="form-horizontal" role="form" id="cif_consulta_form_UniCli" name="cif_consulta_form_UniCli" ng-submit="Consultar_CIFUniMulCli($event,2)" ng-click="vm.containerClicked()"> 
                          <div class="form-group">
                            <label for="inputEmail1" class="col-lg-2 control-label">NIF/Nombre:</label>
                            <div class="col-lg-10">
                              <input type="text" class="form-control" ng-model="vm.NumCifCliUniMulCli" placeholder="* NIF/Nombre" required ng-keyup='vm.fetchClientes(2)' ng-click='vm.searchboxClicked($event)'/>                                
                             <ul id='searchResult'>
                              <li ng-click='vm.setValue($index,$event,result,3)' ng-repeat="result in vm.searchResult" >
                               {{ result.NumCifCli }} - {{ result.RazSocCli }} 
                              </li>
                            </ul> 
                            </div>
                          </div>
                          <button class="btn btn-info" type="submit" ng-disabled="cif_consulta_form_UniCli.$invalid"> Consultar</button>
                        </form>
                      </div>
                    </div>
                  </div>
  </div>
<!--modal modal_add_propuestaUniCliente section END -->

<!--modal modal_add_propuestaMulCliente section START -->
  <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_add_propuestaMulCliente" class="modal fade">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">??</button>
                        <h4 class="modal-title">Representante</h4>
                      </div>
                      <div class="modal-body">
                        <form class="form-horizontal" role="form" id="cif_consulta_form_MulCli" name="cif_consulta_form_MulCli" ng-submit="Consultar_CIFUniMulCli($event,3)" ng-click="vm.containerClicked()"> 
                          <div class="form-group">
                            <label for="inputEmail1" class="col-lg-2 control-label">Representante:</label>
                            <div class="col-lg-10">
                              <input type="text" class="form-control" ng-model="vm.NumCifCliUniMulCli" placeholder="* Representante" required ng-keyup='vm.fetchClientes(3)' ng-click='vm.searchboxClicked($event)'/>                                
                             <ul id='searchResult' style="height: 350px; overflow-y: auto;">
                              <li ng-click='vm.setValue($index,$event,result,3)' ng-repeat="result in vm.searchResult" >
                               {{ result.NumCifCli }} - {{ result.RazSocCli }} 
                              </li>
                              <input type="hidden" name="CodRepLeg" id="CodRepLeg" ng-model="vm.CodRepLeg">
                            </ul> 
                            </div>
                          </div>
                          <button class="btn btn-info" type="submit" ng-disabled="cif_consulta_form_MulCli.$invalid"> Consultar</button>
                        </form>
                      </div>
                    </div>
                  </div>
  </div>
<!--modal modal_add_propuestaMulCliente section END -->



              </section>
            </div>
        </div>


      </section>
    </section>

</div>
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
<script>
  $('.RangFec').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});   

  $('#RangFec').on('changeDate', function() 
  {
     var RangFec=document.getElementById("RangFec").value;
     console.log("RangFec: "+RangFec);
  });
</script>
</body>
<div id="carganto_servicio" class="loader loader-default"  data-text="Cargando Informaci??n"></div>
<div id="PropuestasComerciales" class="loader loader-default"  data-text="Cargando listado de Propuestas Comerciales"></div>
<div id="NumCifCli" class="loader loader-default"  data-text="Comprobando si el Cliente posee una Propuesta Comercial"></div>
</html>
