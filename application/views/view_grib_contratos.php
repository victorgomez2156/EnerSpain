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
 <div ng-controller="Controlador_Contratos as vm">
 <!--main content start-->
    <section id="main-content">
      <!--wrapper start-->
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header">Listado de Contratos</h3>
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
                  <li><input type="checkbox" ng-model="vm.FecCon"/> <b style="color:black;">Fecha</b></li>
                  <li><input type="checkbox" ng-model="vm.CodCli"/> <b style="color:black;">Cliente</b></li>
                  <li><input type="checkbox" ng-model="vm.CodCom"/> <b style="color:black;">Comercializadora</b></li>
                  <li><input type="checkbox" ng-model="vm.CodAnePro"/>  <b style="color:black;">Anexo</b></li>
                  <li><input type="checkbox" ng-model="vm.DurCon"/> <b style="color:black;">Duración</b></li>
                  <li><input type="checkbox" ng-model="vm.FecVenCon"/> <b style="color:black;">Vencimiento</b></li>
                  <li><input type="checkbox" ng-model="vm.EstBajCon"/> <b style="color:black;">Estatus</b></li>
                  <li><input type="checkbox" ng-model="vm.ActCont"/> <b style="color:black;">Acción</b></li>
                </ul> 
              </div>
              <div class="btn-group">
                <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button"><i class="fa fa-cloud-upload"></i><span class="caret"></span> </button>
                 <ul class="dropdown-menu">
                  <li style="cursor: pointer;"><a title='Exportar PDF' target="_black"  href="reportes/Exportar_Documentos/Doc_Contratos_PDF/{{vm.ruta_reportes_pdf_Contratos}}"><i class="fa fa-file"></i> Exportar en PDF</a></li>
                  <li style="cursor: pointer;"><a title='Exportar Excel' target="_black" href="reportes/Exportar_Documentos/Doc_Contratos_Excel/{{vm.ruta_reportes_excel_Contratos}}"><i class="fa fa-file-excel-o"></i> Exportar en Excel</a></li>
                </ul>
              </div>
              <div class="btn-group">
                <a data-toggle="modal" title='Filtros' data-target="#filtro_contratos" class="btn btn-default"><div><i class="fa fa-filter"></i><span class="caret"></span></div></a>                     
              </div>
            </div><!--t-0031 end--> 
          </div><!--t-0029 end--> 
        </div><!--DIV removeformobile end-->
          <div style="float:right;margin-left: 0px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
              <div class="t-0029">
                <form class="form-inline" role="form">
                  <div class="form-group">
                    <input type="text" class="form-control" ng-model="vm.filtrar_search" minlength="1" id="exampleInputEmail2" placeholder="Escribe para filtrar..." ng-keyup="vm.FetchContratos()">
                  </div>  
                   <a data-toggle="modal" title="Agregar Contrato" style="margin-right: 5px;" data-target="#modal_add_contratos" class="btn btn-info"><div><i class="fa fa-plus-square"></i></div></a>                  
                </form>                    
            </div>
          </div>
        </div>  <!--t-0002 end-->
      <br><br><br><br>
       <div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive">
                <tbody>
                  <tr>
                  <th ng-show="vm.FecCon==true">Fecha</th>
                  <th ng-show="vm.CodCli==true">Cliente</th>
                  <th ng-show="vm.CodCom==true">Comercializadora</th>
                  <th ng-show="vm.CodAnePro==true">Anexo</th> 
                  <th ng-show="vm.DurCon==true">Duración</th>  
                  <th ng-show="vm.FecVenCon==true">Vencimiento</th>
                  <th ng-show="vm.EstBajCon==true">Estatus</th>              
                  <th ng-show="vm.ActCont==true">Acción</th>
                  </tr>
                  <tr ng-show="vm.T_Contratos.length==0"> 
                    <td colspan="8" align="center">
                      <div class="td-usuario-table"><i class="fa fa-close"></i> No existe información.</div>
                    </td>           
                    </tr>
                  <tr ng-repeat="dato in vm.T_Contratos | filter:paginate" ng-class-odd="odd">                    
                    <td ng-show="vm.FecCon==true">{{dato.FecConCom}}</td>
                    <td ng-show="vm.CodCli==true">{{dato.NumCifCli}} - {{dato.RazSocCli}}</td>
                    <td ng-show="vm.CodCom==true">{{dato.CodCom}}</td>
                    <td ng-show="vm.CodAnePro==true">{{dato.Anexo}}</td> 
                    <td ng-show="vm.DurCon==true">{{dato.DurCon}} Meses</td> 
                    <td ng-show="vm.FecVenCon==true">{{dato.FecVenCon}}</td>
                    <td ng-show="vm.EstBajCon==true">
                      <span class="label label-success" ng-show="dato.EstBajCon==0"><i class="fa fa-check-circle"></i> Activo</span>
                      <span class="label label-danger" ng-show="dato.EstBajCon==1"><i class="fa fa-ban"></i> Dado de Baja</span>
                      <span class="label label-info" ng-show="dato.EstBajCon==2"><i class="fa fa-close"></i> Vencido</span>
                      <span class="label label-primary" ng-show="dato.EstBajCon==3"><i class="fa fa-check-circle"></i> Renovado</span>
                   </td>
                    <td ng-show="vm.ActCont==true">
                      <div class="btn-group">
                        <select class="form-control" id="opcion_select" style="width: auto;" name="opcion_select" ng-model="vm.opcion_select[$index]" ng-change="vm.validar_opcion_contratos($index,vm.opcion_select[$index],dato)">
                          <option ng-repeat="opcion in vm.opciones_contratos" value="{{opcion.id}}">{{opcion.nombre}}</option>
                        </select>
                      </div>
                    </td>

                  </tr>
                </tbody>
                <tfoot>                 
                  <th ng-show="vm.FecCon==true">Fecha</th>
                  <th ng-show="vm.CodCli==true">Cliente</th>
                  <th ng-show="vm.CodCom==true">Comercializadora</th>
                  <th ng-show="vm.CodAnePro==true">Anexo</th> 
                  <th ng-show="vm.DurCon==true">Duración</th>  
                  <th ng-show="vm.FecVenCon==true">Vencimiento</th>
                  <th ng-show="vm.EstBajCon==true">Estatus</th>              
                  <th ng-show="vm.ActCont==true">Acción</th>
                </tfoot>
              </table>
        </div> 
        <div align="center">
          <span class="store-qty"> <a ng-click="vm.get_list_contratos()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       
          <div class='btn-group' align="center">
            <pagination total-items="totalItems" ng-model="currentPage" max-size="5" boundary-links="true" items-per-page="numPerPage" class="pagination-sm">  
            </pagination>
          </div>
        </div>

<!-- modal container section end -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="filtro_contratos" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Seleccione Filtro</h4>
          </div>
          <div class="modal-body">
                        <div class="panel">                  
      <form class="form-validate" id="frmfiltros" name="frmfiltros" ng-submit="SubmitFormFiltrosContratos($event)">                 
     
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
        <input type="text" name="RangFec" id="RangFec" class="form-control RangFec" ng-model="vm.RangFec" placeholder="DD/MM/YYYY" ng-change="vm.validar_formatos_input(3,vm.RangFec)">   
     </div>
     </div>
     </div>

     <div class="col-12 col-sm-12" ng-show="vm.tmodal_filtros.tipo_filtro==2" ng-click="vm.containerClicked()">
     <div class="form">                          
     <div class="form-group">
        <input type="text" class="form-control" ng-model="vm.NumCifCliFil" placeholder="* Introduzca CIF" ng-keyup='vm.fetchClientes(2)' ng-click='vm.searchboxClicked($event)'/>
        <ul id='searchResult'>
          <li ng-click='vm.setValue($index,$event,result,2)' ng-repeat="result in vm.searchResult" >
            {{ result.NumCifCli }} - {{ result.RazSocCli }} 
          </li>
        </ul>   
     </div>
     </div>
     <input type="hidden" name="CodCliFil" id="CodCliFil" ng-model="vm.CodCliFil" readonly>
     </div>

      <div class="col-12 col-sm-12" ng-show="vm.tmodal_filtros.tipo_filtro==3" ng-click="vm.containerClicked()">
         <div class="form">                          
         <div class="form-group">
          <select class="form-control" id="EstBajCon" name="EstBajCon" ng-model="vm.EstBajConFil">
         <option value="0">Activo</option>
         <option value="1">Dado de Baja</option> 
         <option value="2">Vencido</option> 
         <option value="3">Renovado</option>                         
        </select>
         
         </div>
         </div>
      </div>

     <div style="margin-left:15px; ">
     <button class="btn btn-info" type="submit" ng-disabled="frmfiltros.$invalid">Aplicar</button>
      <a class="btn btn-danger" ng-click="vm.regresar_filtro()">Borrar Filtro</a>
      </div>
</form>
   </div>
    </div>
</div>
</div>
</div>
<!--modal container section end -->


<!--modal modal_cif_comercializadora section START -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_add_contratos" class="modal fade">
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
                              
                              <!--input type="text" class="form-control" ng-model="vm.NumCifCli" placeholder="* Introduzca CIF" required ng-keyup='vm.fetchClientes(1)' ng-click='vm.searchboxClicked($event)'  onkeyup="this.value=this.value.toUpperCase();"/-->                                
                             <input type="text" class="form-control" ng-model="vm.NumCifCli" placeholder="* Introduzca CIF" ng-keyup='vm.fetchClientes(1)' ng-click='vm.searchboxClicked($event)' name="NumCifCli1" id="NumCifCli1" onkeyup="this.value=this.value.toUpperCase();">
                             
                             <ul id='searchResult'>
                              <li ng-click='vm.setValue($index,$event,result,1)' ng-repeat="result in vm.searchResult" >
                               {{ result.NumCifCli }} - {{ result.RazSocCli }} 
                              </li>
                            </ul>

                            </div>
                          </div>
                          <!--p id="iLetter"></p-->
                          <button class="btn btn-info" type="submit" ng-disabled="cif_consulta_form.$invalid"> Consultar</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
<!--modal modal_cif_comercializadora section END -->

<!-- modal container section end -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_baja_contrato" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title"><i class="fa fa-lock"></i> Dar Baja Contrato</h4>
          </div>
          <div class="modal-body">
      <div class="panel"> 
      <input type="hidden" class="form-control" ng-model="vm.tmodal_data.CodConCom" required readonly />
      <form class="form-validate" id="form_lock" name="form_lock" ng-submit="submitFormlock($event)">                 
        
        <div class="col-12 col-sm-12">
          <div class="form">                          
          <div class="form-group">
          <label class="font-weight-bold nexa-dark" style="color:black;">CIF</label>
          <input type="text" class="form-control" ng-model="vm.RazSocCom" readonly/>     
          </div>
          </div>
        </div>

        <div class="col-12 col-sm-6">
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Fecha de Baja</label>
         <input type="text" class="form-control FecBajCon" ng-model="vm.FecBajCon" required name="FecBajCon" id="FecBajCon" ng-change="vm.validar_formatos_input(2,vm.FecBajCon)"/>    
         </div>
         </div>
        </div>
         <div class="col-12 col-sm-6">
        <div class="form">                          
          <div class="form-group">
            <label class="font-weight-bold nexa-dark" style="color:black;">Justificación de Baja</label>
            <input type="text" class="form-control" ng-model="vm.tmodal_data.JusBajCon" required/>      
          </div>
        </div>
      </div>
      <br>
      <button class="btn btn-info" type="submit" ng-disabled="form_lock.$invalid">Bloquear</button>
      <a class="btn btn-danger" data-dismiss="modal">Volver</a>
    </form>
   </div>
    </div>
</div>
</div>
</div>

<!-- modal container section end -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="Tipo_Renovacion" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Tipo Renovación Contrato</h4>
          </div>
          <div class="modal-body">
                        <div class="panel">                  
    
    <form class="form-validate" id="frmRenovacion" name="frmRenovacion" ng-submit="SubmitFormRenovacion($event)">                 
     <input type="hidden" class="form-control" ng-model="vm.tmodal_data.CodCli" name="CodCliModalReno" id="CodCliModalReno" readonly="readonly" />
     <input type="hidden" class="form-control" ng-model="vm.tmodal_data.CodProCom" name="CodProComModalReno" id="CodProComModalReno" readonly="readonly" />
     <input type="hidden" class="form-control" ng-model="vm.tmodal_data.CodConCom" name="CodConComModalReno" id="CodConComModalReno" readonly="readonly" />

    <div class="col-12 col-sm-12">
     <div class="form">                          
     <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:black;">Razón Social</label>
        <input type="text" class="form-control" ng-model="vm.RazSocCli" readonly/>
     </div>
     </div>
     </div>

      <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:black;">Comercializadora</label>
        <input type="text" class="form-control" ng-model="vm.CodCom" readonly/>
     </div>
     </div>
     </div>

      <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:black;">Anexo</label>
        <input type="text" class="form-control" ng-model="vm.Anexo" readonly/>
     </div>
     </div>
     </div>

     <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:black;">Sin Modificaciones</label>
        <input type="checkbox" class="form-control" ng-model="vm.tmodal_data.SinMod" name="SinMod" id="SinMod" ng-disabled="vm.tmodal_data.ConMod==true"/>
     </div>
     </div>
     </div>

    <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:black;">Con Modificaciones</label>
        <input type="checkbox" class="form-control" ng-model="vm.tmodal_data.ConMod" ng-disabled="vm.tmodal_data.SinMod==true" name="ConMod" id="ConMod"/>

     </div>
     </div>
     </div>


     <div class="col-12 col-sm-6" ng-show="vm.tmodal_data.SinMod==true">
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Fecha de Inicio</label>
        <input type="text" class="form-control FecIniCon" name="FecIniCon" id="FecIniCon" ng-model="vm.FecIniCon" placeholder="DD/MM/YYYY" maxlength="10" ng-change="vm.validar_formatos_input(1,vm.FecIniCon)"/>
         
         </div>
         </div>
      </div>


        <div class="col-12 col-sm-6" ng-show="vm.tmodal_data.SinMod==true">
            <div class="form">                          
             <div class="form-group">   
              <label class="font-weight-bold nexa-dark" style="color:black;">Duración </label>          
             <select class="form-control" id="DurCon" name="DurCon" ng-model="vm.tmodal_data.DurCon">   
                <option value="12">12 Meses</option>
                <option value="18">18 Meses</option>
                <option value="24">24 Meses</option>
                <option value="36">36 Meses</option>
        </select> 
                       
             </div>
             </div>
          </div>

     <div align="center">
        <button class="btn btn-info" type="submit" ng-disabled="frmRenovacion.$invalid">Solicitar</button>
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
<script type="text/javascript">
  $('.FecBajCon').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true}); 
  $('.FecIniCon').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});  

  $('.RangFec').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});  

  $('#RangFec').on('changeDate', function() 
  {
     var RangFec=document.getElementById("RangFec").value;
     console.log("RangFec: "+RangFec);
  });
</script>
</body>

<div id="Contratos" class="loader loader-default"  data-text="Cargando listado de Contratos Comerciales"></div>
<div id="NumCifCli" class="loader loader-default"  data-text="Comprobando si el Cliente posee una Propuesta Comercial"></div>
<div id="BajaContrato" class="loader loader-default"  data-text="Dando de Baja a Contrato"></div>

</html>
