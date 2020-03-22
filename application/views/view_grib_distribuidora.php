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
 <div ng-controller="Controlador_Distribuidora as vm">
 <!--main content start-->
    <section id="main-content">
      <!--wrapper start-->
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-users"></i> Distribuidoras</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="#/Dashboard"> Dashboard</a></li>              
              <li><i class="fa fa-users"></i> Distribuidoras</li>
            </ol>
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
                        <!--li><input type="checkbox" ng-model="vm.fdatos.Cod"/> <i class="fa fa-plus-square"></i> <b style="color:black;">CodCli</b></li-->
                        <li><input type="checkbox" ng-model="vm.NumCifDis"/> <i class="fa fa-plus-square"></i> <b style="color:black;">CIF</b></li>
                        <li><input type="checkbox" ng-model="vm.RazSocDis"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Razón Social</b></li></li>
                        <li><input type="checkbox" ng-model="vm.TelFijDis"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Teléfono</b></li></li>
                        <li><input type="checkbox" ng-model="vm.EstDist"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Estatus</b></li>
                        <li><input type="checkbox" ng-model="vm.AccDis"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Acción</b></li>
                      </ul> 
                    </div>
                    
                    <div class="btn-group">
                      <button data-toggle="dropdown" title="Generar Reportes" class="btn btn-default dropdown-toggle" type="button"><i class="fa fa-cloud-upload"></i><span class="caret"></span> </button>
                      <ul class="dropdown-menu">
                        <li style="cursor: pointer;"><a title="Exportar en PDF" target="_black"  href="reportes/Exportar_Documentos/Doc_PDF_Distribuidora/{{vm.ruta_reportes_pdf_distribuidora}}"><i class="fa fa-file"></i> Exportar en PDF</a></li>
                        <li style="cursor: pointer;"><a title="Exportar en Excel" target="_black" href="reportes/Exportar_Documentos/Doc_Excel_Distribuidora/{{vm.ruta_reportes_excel_distribuidora}}"><i class="fa fa-file-excel-o"></i> Exportar en Excel</a></li>                        
                      </ul>
                    </div>
                    <div class="btn-group">
                       <a data-toggle="modal" title='Filtros' data-target="#modal_filtro_distribuidoras" class="btn btn-default"><div><i class="fa fa-filter"></i><span class="caret"></span></div></a>
                    </div>
    </div>
  </div>
</div>
              
              <div style="float:right;margin-left: 0px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
                <div class="t-0029">
                  <form class="form-inline" role="form">
                    <div class="form-group">
                      <input type="text" class="form-control" ng-model="vm.fdatos.filtrar" title="Escribe para Filtrar..." minlength="1" id="exampleInputEmail2" placeholder="Escribe para Filtrar...">
                    </div>                 
                    <button style="margin-right: 10px;" class="btn btn-info" title="Agregar Distribuidora" ng-click="vm.modal_cif_distribuidora()"><i class="fa fa-plus-square"></i></button>
                  </form>                    
                  </div>
              </div>
</div>  <!--t-0002 end-->    
<br><br><br><br>
      <div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive" ng-init="vm.cargar_lista_distribuidoras()">
                <tbody>
                  <tr>
                    <th ng-show="vm.NumCifDis==true"><i class="fa fa-vcard"></i> CIF</th> 
                    <th ng-show="vm.RazSocDis==true"><i class="fa fa-building"></i> Razón Social</th>                   
                    <th ng-show="vm.TelFijDis==true"><i class="fa fa-archive"></i> Teléfono</th>
                    <th ng-show="vm.EstDist==true"><i class="fa fa-crop"></i> Estatus</th>      
                    <th ng-show="vm.AccDis==true"><i class="icon_cogs"></i> Acción</th>
                  </tr>
                  <tr ng-show="vm.TDistribuidora.length==0"> 
                     <td colspan="5" align="center"><div class="td-usuario-table"><i class="fa fa-close"></i> Actualmente no hay datos disponibles.</div></td>           
                    </tr>
                  <tr ng-repeat="dato in vm.TDistribuidora | filter:paginate | filter:vm.filtrar" ng-class-odd="odd">
                    
                    <td ng-show="vm.NumCifDis==true">{{dato.NumCifDis}}</td>
                    <td ng-show="vm.RazSocDis==true">{{dato.RazSocDis}}</td>
                    <td ng-show="vm.TelFijDis==true">{{dato.TelFijDis}}</td>                    
                    <td ng-show="vm.EstDist==true">
                      <span class="label label-info" ng-show="dato.EstDist=='ACTIVO'"><i class="fa fa-check-circle"></i> Activo</span>
                      <span class="label label-danger" ng-show="dato.EstDist=='BLOQUEADO'"><i class="fa fa-ban"></i> Bloqueado</span>
                    </td> 
                    <td ng-show="vm.AccDis==true">
                      <div class="btn-group">
                        <select class="form-control" id="opciones_distribuidoras" name="opciones_distribuidoras" ng-model="vm.opciones_distribuidoras[$index]" ng-change="vm.validar_opcion_distribuidora($index,vm.opciones_distribuidoras[$index],dato)">
                          <option ng-repeat="opcion in vm.topciones" value="{{opcion.id}}">{{opcion.nombre}}</option>                          
                        </select>
                      </div>
                    </td>
                  </tr>
                </tbody>
                <tfoot>                   
                   <th ng-show="vm.NumCifDis==true"><i class="fa fa-vcard"></i> CIF</th> 
                    <th ng-show="vm.RazSocDis==true"><i class="fa fa-building"></i> Razón Social</th>                   
                    <th ng-show="vm.TelFijDis==true"><i class="fa fa-archive"></i> Teléfono</th>
                    <th ng-show="vm.EstDist==true"><i class="fa fa-crop"></i> Estatus</th>      
                    <th ng-show="vm.AccDis==true"><i class="icon_cogs"></i> Acción</th>
                </tfoot>
              </table>
        </div> 
        <div align="center">
          <span class="store-qty"> <a ng-click="vm.cargar_lista_distribuidoras()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       
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
         Diseñador Por <a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2019</a>
        </div>
    </div>
  </section>
  <!-- modal container section end -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_motivo_bloqueo" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title"><i class="fa fa-lock"></i> Bloqueo de Distribuidora</h4>
          </div>
          <div class="modal-body">
                        <div class="panel"> 
                 <input type="hidden" class="form-control" ng-model="vm.tmodal_data.CodDist" required readonly />
      <form class="form-validate" id="form_lock" name="form_lock" ng-submit="submitFormlock($event)">                 
     <div class="col-12 col-sm-4">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">CIF</label>
     <input type="text" class="form-control" ng-model="vm.tmodal_data.NumCifDis" required readonly/>     
     </div>
     </div>
     </div>

    <div class="col-12 col-sm-4">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Fecha de Bloqueo</label>
     <input type="text" class="form-control datepicker" ng-model="vm.FechBlo" name="FechBlo" id="FechBlo"/>    
     </div>
     </div>
     </div>
     <div class="col-12 col-sm-4">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Razón Social</label>
     <input type="text" class="form-control" ng-model="vm.tmodal_data.RazSocDis" required readonly />     
     </div>
     </div>
     </div>

    <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Motivo de Bloqueo</label>
     <input type="text" class="form-control" ng-model="vm.tmodal_data.MotBloq" required/>      
     </div>
     </div>

     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Observación</label>
     <textarea type="text" class="form-control" ng-model="vm.tmodal_data.ObsBloDis" rows="5" maxlength="100"></textarea>
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

<script>

  $('.datepicker').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});
  $('#FechBlo').on('changeDate', function() 
  {
     var FechBlo=document.getElementById("FechBlo").value;
     console.log("FechBlo: "+FechBlo);
  });
</script>
<!-- modal container section end -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_filtro_distribuidoras" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Tipo de Filtro</h4>
          </div>
          <div class="modal-body">
                        <div class="panel">                  
      <form class="form-validate" id="frmfiltros" name="frmfiltros" ng-submit="SubmitFormFiltrosDistribuidora($event)">                 
     
     <div class="col-12 col-sm-12">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Seleccione Filtro</label>
      <select class="form-control" id="tipo_filtro" name="tipo_filtro" required ng-model="vm.tmodal_distribuidora.tipo_filtro">
         <option value="1">Tipo de Suministro</option> 
        <option value="2">Estatus</option>
        </select>     
     </div>
     </div>
     </div>
    
     <div class="col-12 col-sm-12" ng-show="vm.tmodal_distribuidora.tipo_filtro==1">
     <div class="form">                          
     <div class="form-group">     
      <select class="form-control" id="TipSerDis" name="TipSerDis" ng-model="vm.tmodal_distribuidora.TipSerDis">
        <option value="GAS">Suministro Gas</option> 
        <option value="ELÉCTRICO">Suministro Eléctrico</option>
        <option value="AMBOS SERVICIOS">Ambos</option>                         
      </select>   
     </div>
     </div>
    </div>    

    <div class="col-12 col-sm-12" ng-show="vm.tmodal_distribuidora.tipo_filtro==2">
     <div class="form">                          
     <div class="form-group">     
      <select class="form-control" id="EstDist" name="EstDist" ng-model="vm.tmodal_distribuidora.EstDist">
        <option value="ACTIVO">Activo</option> 
        <option value="BLOQUEADO">Bloqueado</option>                         
      </select>     
     </div> 
     </div>
     </div>     
   
    <div style="margin-left:15px; ">
     <button class="btn btn-info" type="submit" ng-disabled="frmfiltros.$invalid">Aplicar</button>
      <a class="btn btn-danger" ng-click="vm.regresar_filtro_distribuidora()" ng-show="vm.tmodal_distribuidora.tipo_filtro>0">Quitar</a>
      </div>
</form>
   </div>
    </div>
</div>
</div>
</div>
<!--modal container section end -->
<!--modal modal_cif_cliente section START -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_cif_distribuidora" class="modal fade">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                        <h4 class="modal-title">Comprobación de CIF</h4>
                      </div>
                      <div class="modal-body">
                        <form class="form-horizontal" role="form" id="cif_consulta_form" name="cif_consulta_form" ng-submit="Consultar_CIF($event)"> 
                          <div class="form-group">
                            <label for="inputEmail1" class="col-lg-2 control-label"><i class="fa fa-vcard" title="Ingrese Número de CIF"></i> Ingrese Número de CIF:</label>
                            <div class="col-lg-10">
                              <input type="text" class="form-control" ng-model="vm.NumCifDisConsulta" placeholder="* Ingrese Número de CIF" maxlength="50" required/>   
                            </div>
                          </div>
                          <button class="btn btn-info" type="submit" ng-disabled="cif_consulta_form.$invalid"><i class="fa fa-search"></i> Consultar</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
<!--modal modal_cif_cliente section END -->

</div>
</body>
<div id="cargando" class="loader loader-default"  data-text="Cargando lista de distribuidoras, Por Favor Espere..."></div>
<div id="borrando" class="loader loader-default"  data-text="Borrando Distribuidora, Por Favor Espere..."></div>
<div id="NumCifDis" class="loader loader-default"  data-text="Comprobando Número de CIF, Por Favor Espere"></div>
</html>
