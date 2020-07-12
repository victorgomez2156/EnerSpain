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
            <h3 class="page-header">Listado de Propuestas Comerciales</h3>
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
                  <li><input type="checkbox" ng-model="vm.FecProCom"/> <b style="color:black;">Fecha</b></li>
                  <li><input type="checkbox" ng-model="vm.CodCli"/> <b style="color:black;">CodCli</b></li>
                  <li><input type="checkbox" ng-model="vm.NifCliente"/> <b style="color:black;">NIF</b></li>
                  <li><input type="checkbox" ng-model="vm.CodCli"/> <b style="color:black;">Cliente</b></li>
                  <li><input type="checkbox" ng-model="vm.CUPsEle"/> <b style="color:black;">CUPs Eléctrico</b></li>
                  <li><input type="checkbox" ng-model="vm.CUPsGas"/>  <b style="color:black;">CUPs Gas</b></li>
                  <li><input type="checkbox" ng-model="vm.EstPro"/> <b style="color:black;">Estatus</b></li>
                  <li><input type="checkbox" ng-model="vm.ActPro"/> <b style="color:black;">Acción</b></li>
                </ul> 
              </div>
              <div class="btn-group">
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
                    <input type="text" class="form-control" ng-model="vm.filtrar_search" minlength="1" id="exampleInputEmail2" placeholder="Escribe para filtrar..." ng-keyup="vm.FetchPropuestaComerciales()">
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
                  <th ng-show="vm.CUPsEle==true">CUPs Eléctrico</th>
                  <th ng-show="vm.CUPsGas==true">CUPs Gas</th> 
                  <th ng-show="vm.EstPro==true">Estatus</th>                
                  <th ng-show="vm.ActPro==true">Acción</th>
                  </tr>
                  <tr ng-show="vm.TPropuesta_Comerciales.length==0"> 
                    <td colspan="6" align="center">
                      <div class="td-usuario-table"><i class="fa fa-close"></i> No hay información</div>
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
                      <span class="label label-warning" ng-show="dato.EstProCom=='P'"><i class="fa fa-clock-o"></i> Pendiente</span>
                      <span class="label label-info" ng-show="dato.EstProCom=='A'"><i class="fa fa-check-circle"></i> Aprobada</span>
                      <span class="label label-success" ng-show="dato.EstProCom=='C'"><i class="fa fa-check-circle"></i> Completada</span>  
                      <span class="label label-danger" ng-show="dato.EstProCom=='R'"><i class="fa fa-ban"></i> Rechazada</span>
                   </td>
                    <td ng-show="vm.ActPro==true">
                      <div class="btn-group">
                        <select class="form-control" style="width: auto;" id="opcion_select" name="opcion_select" ng-model="vm.opcion_select[$index]" ng-change="vm.validar_opcion_propuestas($index,vm.opcion_select[$index],dato)">
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
                  <th ng-show="vm.CUPsEle==true">CUPs Eléctrico</th>
                  <th ng-show="vm.CUPsGas==true">CUPs Gas</th> 
                  <th ng-show="vm.EstPro==true">Estatus</th>                
                  <th ng-show="vm.ActPro==true">Acción</th>
                </tfoot>
              </table>
        </div> 
        <div align="center">
          <span class="store-qty"> <a ng-click="vm.PropuestasClientesAll()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       
          <div class='btn-group' align="center">
            <pagination total-items="totalItems" ng-model="currentPage" max-size="5" boundary-links="true" items-per-page="numPerPage" class="pagination-sm">  
            </pagination>
          </div>
        </div>

<!-- modal container section end -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_filtros_propuestas" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Seleccione Filtro</h4>
          </div>
          <div class="modal-body">
    <div class="panel">                 
      <form class="form-validate" id="frmfiltroPropuestas" name="frmfiltroPropuestas" ng-submit="SubmitFormFiltrosPropuestas($event)">

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
        <input type="text" class="form-control" ng-model="vm.NumCifCli" placeholder="* Introduzca CIF" ng-keyup='vm.fetchClientes(2)' ng-click='vm.searchboxClicked($event)'/>
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
      <a class="btn btn-danger" ng-click="vm.regresar_filtro()">Borrar Filtro</a>
      </div>
</form>
   </div>
    </div>
</div>
</div>
</div>
<!--modal container section end -->


<!-- modal container section end -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_contratosProRenPen" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Contratos Renovación Pendiente</h4>
          </div>
          <div class="modal-body">
                        <div class="panel">                  
    <form class="form-validate" id="frmProRenPen" name="frmProRenPen" ng-submit="SubmitFormContratosProRenPen($event)">                  
     <div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive">
                <tbody>
                  <tr>
                  <th></th>
                  <th>Fecha Inicio</th>
                  <th>Duración</th>  
                  <th>Vencimiento</th>
                  <th>Estatus</th>              
                  
                  </tr>
                  <tr ng-show="vm.T_ContratosProRenPen.length==0"> 
                    <td colspan="8" align="center">
                      <div class="td-usuario-table"><i class="fa fa-close"></i> No existe información.</div>
                    </td>           
                    </tr>
                  <tr ng-repeat="dato in vm.T_ContratosProRenPen | filter:paginate6" ng-class-odd="odd">                    
                    <td>

                      <!--input type="checkbox" name="select_contra_{{$index}}" id="select_contra_{{$index}}" ng-model="vm.select_ContrProRenPen[$index]" ng-click="vm.SelectContrato($index,dato,vm.select_ContrProRenPen[$index])"-->
                      <button type="button"  ng-click="vm.agregar_ContratoProRenPen($index,dato.CodConCom,dato)" title="Seleccionar" ng-show="!vm.select_DetProPenRen[dato.CodConCom]"><i class="fa fa fa-square-o" style="color:black;"></i></button>
                                            
                      <button type="button" ng-show="vm.select_DetProPenRen[dato.CodConCom]" ng-click="vm.quitar_ContratoProRenPen($index,dato.CodConCom,dato)"><i class="fa fa fa-check-circle" title="Quitar" style="color:green;"></i></button>  



                    </td>
                    



                    <td>{{dato.FecIniCon}}</td>
                    <td>{{dato.DurCon}} Meses</td> 
                    <td>{{dato.FecVenCon}}</td>
                    <td>
                      <span class="label label-success" ng-show="dato.EstBajCon==0"><i class="fa fa-check-circle"></i> Activo</span>
                      <span class="label label-danger" ng-show="dato.EstBajCon==1"><i class="fa fa-ban"></i> Dado de Baja</span>
                      <span class="label label-info" ng-show="dato.EstBajCon==2"><i class="fa fa-close"></i> Vencido</span>
                      <span class="label label-primary" ng-show="dato.EstBajCon==3"><i class="fa fa-check-circle"></i> Renovado</span>
                      <span class="label label-warning" ng-show="dato.EstBajCon==4"><i class="fa fa-check-clock-o"></i> En Renovación</span>
                   </td>
                   
                  </tr>
                </tbody>
                <tfoot> 
                  <th></th>                
                  <th>Fecha Inicio</th>                  
                  <th>Duración</th>  
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
<!--modal container section end -->

<!--modal modal_cif_comercializadora section START -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_add_propuesta" class="modal fade">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                        <h4 class="modal-title">Introduzca CIF</h4>
                      </div>
                      <div class="modal-body">
                        <form class="form-horizontal" role="form" id="cif_consulta_form" name="cif_consulta_form" ng-submit="Consultar_CIF($event)" ng-click="vm.containerClicked()"> 
                          <div class="form-group">
                            <label for="inputEmail1" class="col-lg-2 control-label">Número de CIF:</label>
                            <div class="col-lg-10">
                              <input type="text" class="form-control" ng-model="vm.NumCifCli" placeholder="* Introduzca CIF" required ng-keyup='vm.fetchClientes(1)' ng-click='vm.searchboxClicked($event)'/>                                
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
<!--modal modal_cif_comercializadora section END -->
              </section>
            </div>
        </div>
      </section>
    </section>

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
<div id="carganto_servicio" class="loader loader-default"  data-text="Cargando Información"></div>
<div id="PropuestasComerciales" class="loader loader-default"  data-text="Cargando listado de Propuestas Comerciales"></div>
<div id="NumCifCli" class="loader loader-default"  data-text="Comprobando si el Cliente posee una Propuesta Comercial"></div>

</html>
