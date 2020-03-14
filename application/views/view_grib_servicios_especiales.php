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
 <div ng-controller="Controlador_Servicios_Especiales as vm">
 <!--main content start-->
    <section id="main-content">
      <!--wrapper start-->
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-child"></i> Servicios Especiales</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>              
              <li><i class="fa fa-child"></i>Servicios Especiales</li>
            </ol>
          </div>
        </div>
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
              <!--panel start-->
              <section class="panel">
                <div id="t-0002">
      <div style="float:left;margin-left: 0px;padding: 10px;margin-top: 10px;margin-bottom: 2px;" class="removeForMobile">                   
        <div class="t-0029">
            <div class="t-0031" style="margin-top: -8px; ">
                    <div class="btn-group">
                      <button data-toggle="dropdown" title="Agregar Columnas" class="btn btn-default" type="button"><i class="fa fa-columns"></i> <span class="caret"></span></button>
                      <ul class="dropdown-menu">
                        <li><input type="checkbox" ng-model="vm.NumCifCom"/> <i class="fa fa-plus-square"></i> <b style="color:black;">CIF</b></li>
                        <li><input type="checkbox" ng-model="vm.RazSocCom"/> <i class="fa fa-plus-square"></i> <b style="color:black;">RAZÓN SOCIAL</b></li>
                        <li><input type="checkbox" ng-model="vm.DesSerEsp"/> <i class="fa fa-plus-square"></i> <b style="color:black;">SERVICIO ESPECIAL</b></li></li>
                        <li><input type="checkbox" ng-model="vm.TipCli"/> <i class="fa fa-plus-square"></i> <b style="color:black;">TIPO CLIENTE</b></li></li>
                        <li><input type="checkbox" ng-model="vm.SerElecSerEsp"/> <i class="fa fa-plus-square"></i> <b style="color:black;">ELECTRICIDAD</b></li>
                        <li><input type="checkbox" ng-model="vm.SerGasSerEsp"/> <i class="fa fa-plus-square"></i> <b style="color:black;">GAS</b></li>
                        <li><input type="checkbox" ng-model="vm.FecIniSerEsp"/> <i class="fa fa-plus-square"></i> <b style="color:black;">FECHA INICIO</b></li>
                        <li><input type="checkbox" ng-model="vm.EstSerEsp"/> <i class="fa fa-plus-square"></i> <b style="color:black;">ESTATUS</b></li>
                        <li><input type="checkbox" ng-model="vm.AccSerEsp"/> <i class="fa fa-plus-square"></i> <b style="color:black;">ACCIÓN</b></li>
                      </ul> 
                    </div>                    
                    <div class="btn-group">
                      <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button"><i class="fa fa-cloud-upload"></i><span class="caret"></span> </button>
                      <ul class="dropdown-menu">
                        <li style="cursor: pointer;"><a title='Exportar PDF' target="_black"  href="reportes/Exportar_Documentos/Doc_PDF_Servicios_Especiales/{{vm.reporte_pdf_servicio_especiales}}"><i class="fa fa-file"></i> Exportar en PDF</a></li>
                        <li style="cursor: pointer;"><a title='Exportar Excel' target="_black" href="reportes/Exportar_Documentos/Doc_Excel_Servicios_Especiales/{{vm.reporte_excel_servicio_especiales}}"><i class="fa fa-file-excel-o"></i> Exportar en Excel</a></li>                       
                      </ul>
                    </div>
                    <div class="btn-group">
                       <a data-toggle="modal" title='Filtrar Servicios Especiales' data-target="#modal_filtros_servicios_especiales" class="btn btn-default"><div><i class="fa fa-filter"></i><span class="caret"></span></div></a>
                   </div>
          </div>
        </div>
    </div>              
        <div style="float:right;margin-left: 0px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
            <div class="t-0029">
                <form class="form-inline" role="form">
                    <div class="form-group">
                      <input type="text" class="form-control" ng-model="vm.filtrar_servicio_esp" minlength="1" id="exampleInputEmail23" placeholder="Escribe para filtrar...">
                    </div>                 
                    <a style="margin-right: 10px;" class="btn btn-info" title="Agregar Servicio Especial" href="#/Add_Servicios_Adicionales"><i class="fa fa-plus-square"></i></a>
                  </form>                    
                  </div>
            </div>
  </div>  
<!--t-0002 end--> 
<br><br><br><br>
      <div class="table-responsive" >
          <table class="table table-striped table-advance table-hover table-responsive">
                <tbody>
                  <tr>
                    <th ng-show="vm.NumCifCom==true"><i class="icon_cogs"></i> CIF</th>
                     <th ng-show="vm.RazSocCom==true"><i class="icon_cogs"></i> RAZÓN SOCIAL</th>
                    <th ng-show="vm.DesSerEsp==true"><i class="icon_cogs"></i> SERVICIO ESPECIAL</th>
                    <th ng-show="vm.TipCli==true"><i class="icon_cogs"></i> TIPO CLIENTE</th>
                    <th ng-show="vm.SerElecSerEsp==true"><i class="icon_cogs"></i> ELECTRICIDAD</th>
                    <th ng-show="vm.SerGasSerEsp==true"><i class="icon_cogs"></i> GAS</th>
                    <th ng-show="vm.FecIniSerEsp==true"><i class="fa fa-calendar"></i> FECHA INICIO</th>
                    <th ng-show="vm.EstSerEsp==true"><i class="icon_cogs"></i> ESTATUS</th>
                    <th ng-show="vm.AccSerEsp==true"><i class="icon_cogs"></i> Acción</th>
                  </tr> 
                  <tr ng-show="vm.TServicioEspeciales.length==0"> 
                    <td colspan="10" align="center"><div class="td-usuario-table"><i class="fa fa-close"></i> Actualmente no hay datos disponibles.</div></td>
                  </tr>
                  <tr ng-repeat="dato in vm.TServicioEspeciales | filter:paginate3 | filter:vm.filtrar_servicio_esp" ng-class-odd="odd">
                    <td ng-show="vm.NumCifCom==true">{{dato.NumCifCom}}</td>
                     <td ng-show="vm.RazSocCom==true">{{dato.RazSocCom}}</td>
                    <td ng-show="vm.DesSerEsp==true">{{dato.DesSerEsp}}</td>
                    <td ng-show="vm.TipCli==true">{{dato.TipCli}}</td>
                    <td ng-show="vm.SerElecSerEsp==true">{{dato.SerEle}}</td>                     
                    <td ng-show="vm.SerGasSerEsp==true">{{dato.SerGas}}</td>
                    <td ng-show="vm.FecIniSerEsp==true">{{dato.FecIniSerEsp}}</td>
                    <td ng-show="vm.EstSerEsp==true">
                      <span class="label label-info" ng-show="dato.EstSerEsp=='ACTIVO'"><i class="fa fa-check-circle"></i> {{dato.EstSerEsp}}</span>
                      <span class="label label-danger" ng-show="dato.EstSerEsp=='BLOQUEADO'"><i class="fa fa-ban"></i> {{dato.EstSerEsp}}</span>
                    </td>
                    <td ng-show="vm.AccSerEsp==true">
                      <div class="btn-group">
                        <select class="form-control" id="opciones_servicio_especiales" name="opciones_servicio_especiales" ng-model="vm.opciones_servicio_especiales[$index]" ng-change="vm.validar_opcion_servicios_especiales($index,vm.opciones_servicio_especiales[$index],dato)">
                          <option ng-repeat="opcion in vm.Topciones_Grib" value="{{opcion.id}}">{{opcion.nombre}}</option>                          
                        </select>
                      </div>
                    </td>

                  </tr>
                </tbody>
                <tfoot>
                      <th ng-show="vm.NumCifCom==true"><i class="icon_cogs"></i> CIF</th>
                     <th ng-show="vm.RazSocCom==true"><i class="icon_cogs"></i> RAZÓN SOCIAL</th>
                    <th ng-show="vm.DesSerEsp==true"><i class="icon_cogs"></i> SERVICIO ESPECIAL</th>
                    <th ng-show="vm.TipCli==true"><i class="icon_cogs"></i> TIPO CLIENTE</th>
                    <th ng-show="vm.SerElecSerEsp==true"><i class="icon_cogs"></i> ELECTRICIDAD</th>
                    <th ng-show="vm.SerGasSerEsp==true"><i class="icon_cogs"></i> GAS</th>
                    <th ng-show="vm.FecIniSerEsp==true"><i class="fa fa-calendar"></i> FECHA INICIO</th>
                    <th ng-show="vm.EstSerEsp==true"><i class="icon_cogs"></i> ESTATUS</th>
                    <th ng-show="vm.AccSerEsp==true"><i class="icon_cogs"></i> Acción</th>
                </tfoot>
              </table>
        </div> 
          <div align="center">
          <span class="store-qty"> <a ng-click="vm.cargar_lista_servicos_especiales()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       
          <div class='btn-group' align="center">
            <pagination total-items="totalItems3" ng-model="currentPage3" max-size="5" boundary-links="true" items-per-page="numPerPage3" class="pagination-sm">  
            </pagination>
          </div>
        </div>

        <div ng-show="vm.comisiones==true">

      <div align="center"><label class="font-weight-bold nexa-dark" style="color:#394a59;"><b>COMISIONES</b></label></div>

     
        </div>











 <!-- modal container section start -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_filtros_servicios_especiales" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Tipos de Filtros</h4>
          </div>
          <div class="modal-body">
                        <div class="panel">                  
      <form class="form-validate" id="frmFiltroServicioEspecial" name="frmFiltroServicioEspecial" ng-submit="SubmitFormFiltrosServiciosEspeciales($event)">                 
     
     <div class="col-12 col-sm-12">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">TIPO DE FILTRO</label>
      <select class="form-control" id="ttipofiltrosServicioEspecial" name="ttipofiltrosServicioEspecial" required ng-model="vm.tmodal_servicio_especiales.ttipofiltrosServicioEspecial">
          <option ng-repeat="dato in vm.ttipofiltrosServicioEspecial" value="{{dato.id}}">{{dato.nombre}}</option>
        </select>     
     </div>
     </div>
     </div>

     <div class="col-12 col-sm-12" ng-show="vm.tmodal_servicio_especiales.ttipofiltrosServicioEspecial==1">
     <div class="form">                          
     <div class="form-group">     
      <select class="form-control" name="CodCom" ng-model="vm.tmodal_servicio_especiales.CodCom">
        <option ng-repeat="dato in vm.Tcomercializadoras | orderBy:'+RazSocCom'" value="{{dato.NumCifCom}}">{{dato.NumCifCom}} - {{dato.RazSocCom}}</option>
      </select>  
     </div>
     </div>
    </div> 

      <div class="col-12 col-sm-12" ng-show="vm.tmodal_servicio_especiales.ttipofiltrosServicioEspecial==2">
     <div class="form">                          
     <div class="form-group">     
      <select class="form-control" id="TipServ2" name="TipServ" ng-model="vm.tmodal_servicio_especiales.TipServ">
        <option value="1">SERVICIO GAS</option>
        <option value="2">SERVICIO ELÉCTRICO</option> 
        <option value="3">AMBOS</option>                
      </select>   
     </div>
     </div>
    </div> 
     <!--div class="col-12 col-sm-6" ng-show="vm.tmodal_servicio_especiales.ttipofiltrosServicioEspecial==2 && vm.tmodal_servicio_especiales.TipServ!=undefined">
     <div class="form">                          
     <div class="form-group">     
      <select class="form-control" id="Select" name="Select" ng-model="vm.tmodal_servicio_especiales.Select">
        <option value="SI">SI</option>
        <option value="NO">NO</option>                        
      </select>   
     </div>
     </div>
    </div--> 

    <div class="col-12 col-sm-12" ng-show="vm.tmodal_servicio_especiales.ttipofiltrosServicioEspecial==3">
     <div class="form">                          
     <div class="form-group">     
      <select class="form-control" id="TipCli" name="TipCli" ng-model="vm.tmodal_servicio_especiales.TipCli">
        <option value="NEGOCIO">NEGOCIO</option>
        <option value="PARTICULAR">PARTICULAR</option>                
      </select>   
     </div>
     </div>
    </div> 

    <div class="col-12 col-sm-12" ng-show="vm.tmodal_servicio_especiales.ttipofiltrosServicioEspecial==4">
     <div class="form">                          
     <div class="form-group">     
      <select class="form-control" id="DesTipCom2" name="DesTipCom" ng-model="vm.tmodal_servicio_especiales.DesTipCom">
        <option ng-repeat="dato in vm.Tipos_Comision| orderBy:'+DesTipCom'" value="{{dato.DesTipCom}}">{{dato.DesTipCom}}</option>                        
      </select>   
     </div>
     </div>
    </div> 
    <div class="col-12 col-sm-12" ng-show="vm.tmodal_servicio_especiales.ttipofiltrosServicioEspecial==5">
     <div class="form">                          
     <div class="form-group"> 
      <input type="text" name="FecIniSerEsp" id="FecIniSerEsp" class="form-control datepicker" ng-model="vm.tmodal_servicio_especiales.FecIniSerEsp" placeholder="EJ: DD/MM/YYYY" ng-change="vm.validarsifechaserespe(vm.tmodal_servicio_especiales.FecIniSerEsp,1)" maxlength="10"> 
     </div>
     </div>
    </div> 
      <div class="col-12 col-sm-12" ng-show="vm.tmodal_servicio_especiales.ttipofiltrosServicioEspecial==6">
     <div class="form">                          
     <div class="form-group">     
      <select class="form-control" id="EstSerEsp" name="EstSerEsp" ng-model="vm.tmodal_servicio_especiales.EstSerEsp">
        <option value="ACTIVO">ACTIVO</option>
        <option value="BLOQUEADO">BLOQUEADO</option>                          
      </select>   
     </div>
     </div>
    </div> 

    <div style="margin-left:15px; ">
     <button class="btn btn-info" type="submit" ng-disabled="frmFiltroServicioEspecial.$invalid"><i class="fa fa-check-circle"></i> APLICAR</button>
      <a class="btn btn-danger" ng-click="vm.regresar_filtro_servicio_especial()" ng-show="vm.tmodal_servicio_especiales.ttipofiltrosServicioEspecial>0"><i class="fa fa-trash"></i> LIMPIAR</a>
      </div>
</form>
   </div>
    </div>
</div>
</div>
</div>
<!--modal container section end -->



<!-- modal container section end -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_motivo_bloqueo_servicio_especial" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title"><i class="fa fa-ban"></i> Bloqueo de Servicio Especial</h4>
          </div>
          <div class="modal-body">
                        <div class="panel"> 
    <input type="hidden" class="form-control" ng-model="vm.servicio_especial_bloqueo.CodSerEsp" required readonly />
      <form class="form-validate" id="form_lock_servicio_especial" name="form_lock_servicio_especial" ng-submit="submitFormlockServicioEspecial($event)">                 
     
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">COMERCIALIZADORA</label>
     <input type="text" class="form-control" ng-model="vm.RazSocCom_BloSerEsp" required readonly/>     
     </div>
     </div>

      <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">SERVICIO ESPECIAL</label>
      <input type="text" class="form-control" ng-model="vm.DesSerEsp_Blo" required readonly />     
     </div>
     </div>
<div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">MOTIVO DEL BLOQUEO</label>
       <input type="text" class="form-control" ng-model="vm.servicio_especial_bloqueo.MotBloSerEsp" required/> 
     </div>
     </div>
    
</div>
    <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Fecha de Bloqueo</label>
     <input type="text" class="form-control datepicker2" name="FecBloSerEsp" id="FecBloSerEsp" ng-model="vm.FecBloSerEsp" required maxlength="10" ng-change="vm.validarsifechaserespe(vm.FecBloSerEsp,2)" />    
     </div>
     </div>
     </div>

     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Observación</label>
     <textarea type="text" class="form-control" ng-model="vm.servicio_especial_bloqueo.ObsMotBloSerEsp" rows="5" maxlength="100"/></textarea>
     </div>
     </div>
    
    <br>
     <button class="btn btn-info" type="submit" ng-disabled="form_lock_servicio_especial.$invalid">Bloquear</button>
      <a class="btn btn-danger" data-dismiss="modal">Regresar</a>
</form>
   </div>
    </div>
</div>
</div>
</div>
<!-- modal container section end -->
<script>
  $('.datepicker').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});
  $('#FecIniSerEsp').on('changeDate', function() 
  {
     var FecIniSerEsp=document.getElementById("FecIniSerEsp").value;
     console.log("FecIniSerEsp: "+FecIniSerEsp);
  });
  $('.datepicker2').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});
  $('#FecBloSerEsp').on('changeDate', function() 
  {
     var FecBloSerEsp=document.getElementById("FecBloSerEsp").value;
     console.log("FecBloSerEsp: "+FecBloSerEsp);
  });

</script>
            </section>
          </div>
        </div>
      </section>
    </section>

</div>
</body>
<div id="carganto_servicio" class="loader loader-default"  data-text="Cargando Datos del Modulo, Por Favor Espere..."></div>
<div id="List_Serv" class="loader loader-default"  data-text="Cargando lista de Servicios Adicionales, Por Favor Espere..."></div>
<div id="Car_Det" class="loader loader-default"  data-text="Cargando Detalles del Servicios Adicionales, Por Favor Espere..."></div>
<div id="borrando" class="loader loader-default"  data-text="Borrando Cliente, Por Favor Espere..."></div>
<div id="NumCifCom" class="loader loader-default"  data-text="Comprobando Número de CIF, Por Favor Espere..."></div>

</html>
