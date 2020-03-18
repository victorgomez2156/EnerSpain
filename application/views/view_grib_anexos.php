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

.input-required
{
  border:2px solid red;
}
</style>
<body>
 <div ng-controller="Controlador_Anexos as vm">
 <!--main content start-->
    <section id="main-content">
      <!--wrapper start-->
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-bullseye"></i> {{ 'ANNEXES' | translate }}</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="#/{{ 'DASHBOARD' | translate }}">{{ 'DASHBOARD' | translate }}</a></li>                   
              <li><i class="fa fa-bullseye"></i>{{ 'ANNEXES' | translate }}</li>
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
                      <button data-toggle="dropdown" title="{{ 'Add_Columns' | translate }}" class="btn btn-default" type="button"><i class="fa fa-columns"></i> <span class="caret"></span></button>
                      <ul class="dropdown-menu">
                        <li><input type="checkbox" ng-model="vm.NumCifCom"/> <i class="fa fa-plus-square"></i> <b style="color:black;">CIF</b></li>
                        <li><input type="checkbox" ng-model="vm.RazSocCom"/> <i class="fa fa-plus-square"></i> <b style="color:black;">{{ 'RAZ_SOC' | translate }}</b></li>
                        <li><input type="checkbox" ng-model="vm.CodAneTPro"/> <i class="fa fa-plus-square"></i> <b style="color:black;">{{ 'PRODUCTS' | translate }}</b></li></li>
                        <li><input type="checkbox" ng-model="vm.DesAnePro"/> <i class="fa fa-plus-square"></i> <b style="color:black;">{{ 'DESC_ANNEX' | translate }}</b></li></li>
                        <li><input type="checkbox" ng-model="vm.SerGasAne"/> <i class="fa fa-plus-square"></i> <b style="color:black;">{{ 'SER_GAS' | translate }}</b></li>
                        <li><input type="checkbox" ng-model="vm.SerTEleAne"/> <i class="fa fa-plus-square"></i> <b style="color:black;">{{ 'SER_ELE' | translate }}</b></li>
                        <li><input type="checkbox" ng-model="vm.TipPreAne"/> <i class="fa fa-plus-square"></i> <b style="color:black;">{{ 'TIP_PRICE' | translate }}</b></li>
                        <li><input type="checkbox" ng-model="vm.CodTipComAne"/> <i class="fa fa-plus-square"></i> <b style="color:black;">{{ 'TIP_COM' | translate }}</b></li>
                        <li><input type="checkbox" ng-model="vm.ObsAnePro"/> <i class="fa fa-plus-square"></i> <b style="color:black;">{{ 'OBS_COM_BLO' | translate }}</b></li>
                        <li><input type="checkbox" ng-model="vm.FecIniAne"/> <i class="fa fa-plus-square"></i> <b style="color:black;">{{ 'FECH_INI' | translate }}</b></li>   
                        <li><input type="checkbox" ng-model="vm.EstAne"/> <i class="fa fa-plus-square"></i> <b style="color:black;">{{ 'ESTATUS' | translate }}</b></li>
                        <li><input type="checkbox" ng-model="vm.AccTAne"/> <i class="fa fa-plus-square"></i> <b style="color:black;">{{ 'ACCION' | translate }}</b></li>
                      </ul> 
                    </div>                    
                    <div class="btn-group">
                      <button data-toggle="dropdown" title="{{ 'Ex_Reports' | translate }}" class="btn btn-default dropdown-toggle" type="button"><i class="fa fa-cloud-upload"></i><span class="caret"></span> </button>
                      <ul class="dropdown-menu">
                        <li style="cursor: pointer;"><a title='{{ "PDF" | translate }}' target="_black"  href="reportes/Exportar_Documentos/Doc_PDF_Anexos/{{vm.reporte_pdf_anexos}}"><i class="fa fa-file"></i> {{ 'PDF' | translate }}</a></li>
                        <li style="cursor: pointer;"><a title='{{ "EXCEL" | translate }}' target="_black" href="reportes/Exportar_Documentos/Doc_Excel_Anexos/{{vm.reporte_excel_anexos}}"><i class="fa fa-file-excel-o"></i> {{ 'EXCEL' | translate }}</a></li>                        
                      </ul>
                    </div>
                    <div class="btn-group">
                       <a data-toggle="modal" title='{{ "FILTRO" | translate }}' data-target="#modal_filtros_anexos" class="btn btn-default"><div><i class="fa fa-filter"></i><span class="caret"></span></div></a>
                   </div>
          </div>
        </div>
    </div>              
        <div style="float:right;margin-left: 0px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
            <div class="t-0029">
                <form class="form-inline" role="form">
                    <div class="form-group">
                      <input type="text" class="form-control" ng-model="vm.filtrar_anexos" title="{{ 'FILTRO_SEARCH' | translate }}" minlength="1" id="exampleInputEmail22" placeholder="{{ 'FILTRO_SEARCH' | translate }}">
                    </div>                 
                    <a style="margin-right: 10px;" class="btn btn-info" title="{{ 'ADD_ANNEX' | translate }}" href="#/Add_{{ 'ANNEXES' | translate }}"><i class="fa fa-plus-square"></i></a>
                  </form>                    
                  </div>
            </div>
  </div>  
<!--t-0002 end--> 
<br><br><br><br>
      <div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive">
                <tbody>
                  <tr>
                    <th ng-show="vm.NumCifCom==true"><i class="icon_cogs"></i> CIF</th>
                    <th ng-show="vm.RazSocCom==true"><i class="icon_cogs"></i> {{ 'RAZ_SOC' | translate }}</th>
                    <th ng-show="vm.CodAneTPro==true"><i class="icon_cogs"></i> {{ 'PRODUCTS' | translate }}</th>
                    <th ng-show="vm.DesAnePro==true"><i class="icon_cogs"></i> {{ 'DESC_ANNEX' | translate }}</th>
                    <th ng-show="vm.SerGasAne==true"><i class="icon_cogs"></i> {{ 'SER_GAS' | translate }}</th>
                    <th ng-show="vm.SerTEleAne==true"><i class="icon_cogs"></i> {{ 'SER_ELE' | translate }}</th>
                    <th ng-show="vm.TipPreAne==true"><i class="icon_cogs"></i> {{ 'TIP_PRICE' | translate }}</th>
                    <th ng-show="vm.CodTipComAne==true"><i class="icon_cogs"></i> {{ 'TIP_COM' | translate }}</th>
                    <th ng-show="vm.ObsAnePro==true"><i class="icon_cogs"></i> {{ 'OBS_COM_BLO' | translate }}</th>
                    <th ng-show="vm.FecIniAne==true"><i class="icon_cogs"></i> {{ 'FECH_INI' | translate }}</th>
                    <th ng-show="vm.EstAne==true"><i class="icon_cogs"></i> {{ 'ESTATUS' | translate }}</th>
                    <th ng-show="vm.AccTAne==true"><i class="icon_cogs"></i> {{ 'ACCION' | translate }}</th>
                  </tr> 
                  <tr ng-show="vm.TAnexos.length==0"> 
                    <td colspan="12" align="center"><div class="td-usuario-table"><i class="fa fa-close"></i> {{ 'Sin_Data' | translate }}</div></td>
                  </tr>
                  <tr ng-repeat="dato in vm.TAnexos | filter:paginate2 | filter:vm.filtrar_anexos" ng-class-odd="odd">                    
                    <td ng-show="vm.NumCifCom==true">{{dato.NumCifCom}}</td>
                    <td ng-show="vm.RazSocCom==true">{{dato.RazSocCom}}</td>
                    <td ng-show="vm.CodAneTPro==true">{{dato.DesPro}}</td>                  
                    <td ng-show="vm.DesAnePro==true">{{dato.DesAnePro}}</td>
                    <td ng-show="vm.SerGasAne==true">{{dato.SerGas}}</td>
                    <td ng-show="vm.SerTEleAne==true">{{dato.SerEle}}</td>
                    <td ng-show="vm.TipPreAne==true">{{dato.TipPre}}</td>
                    <td ng-show="vm.CodTipComAne==true">{{dato.DesTipCom}}</td>
                    <td ng-show="vm.ObsAnePro==true">{{dato.ObsAnePro}}</td>
                    <td ng-show="vm.FecIniAne==true">{{dato.FecIniAne}}</td>
                    <td ng-show="vm.EstAne==true">
                      <span class="label label-info" ng-show="dato.EstAne=='ACTIVO'"><i class="fa fa-check-circle"></i> {{ 'ACTIVO' | translate }}</span>
                      <span class="label label-danger" ng-show="dato.EstAne=='BLOQUEADO'"><i class="fa fa-ban"></i> {{ 'BLOQUEADO' | translate }}</span>
                    </td>
                    <td ng-show="vm.AccTAne==true">
                      <div class="btn-group">
                        <select class="form-control" id="opciones_anexos" name="opciones_anexos" ng-model="vm.opciones_anexos[$index]" ng-change="vm.validar_opcion_anexos($index,vm.opciones_anexos[$index],dato)">
                          <option ng-repeat="opcion in vm.Topciones_Grib" value="{{opcion.id}}">{{opcion.nombre}}</option>                          
                        </select>
                      </div>
                    </td>

                  </tr>
                </tbody>
                <tfoot>
                     <th ng-show="vm.NumCifCom==true"><i class="icon_cogs"></i> CIF</th>
                    <th ng-show="vm.RazSocCom==true"><i class="icon_cogs"></i> {{ 'RAZ_SOC' | translate }}</th>
                    <th ng-show="vm.CodAneTPro==true"><i class="icon_cogs"></i> {{ 'PRODUCTS' | translate }}</th>
                    <th ng-show="vm.DesAnePro==true"><i class="icon_cogs"></i> {{ 'DESC_ANNEX' | translate }}</th>
                    <th ng-show="vm.SerGasAne==true"><i class="icon_cogs"></i> {{ 'SER_GAS' | translate }}</th>
                    <th ng-show="vm.SerTEleAne==true"><i class="icon_cogs"></i> {{ 'SER_ELE' | translate }}</th>
                    <th ng-show="vm.TipPreAne==true"><i class="icon_cogs"></i> {{ 'TIP_PRICE' | translate }}</th>
                    <th ng-show="vm.CodTipComAne==true"><i class="icon_cogs"></i> {{ 'TIP_COM' | translate }}</th>
                    <th ng-show="vm.ObsAnePro==true"><i class="icon_cogs"></i> {{ 'OBS_COM_BLO' | translate }}</th>
                    <th ng-show="vm.FecIniAne==true"><i class="icon_cogs"></i> {{ 'FECH_INI' | translate }}</th>
                    <th ng-show="vm.EstAne==true"><i class="icon_cogs"></i> {{ 'ESTATUS' | translate }}</th>
                    <th ng-show="vm.AccTAne==true"><i class="icon_cogs"></i> {{ 'ACCION' | translate }}</th>
                </tfoot>
              </table>
        </div> 
          <div align="center">
          <span class="store-qty"> <a ng-click="vm.cargar_lista_anexos()" title='{{ "RELOAD" | translate }}' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       
          <div class='btn-group' align="center">
            <pagination total-items="totalItems2" ng-model="currentPage2" max-size="5" boundary-links="true" items-per-page="numPerPage2" class="pagination-sm">  
            </pagination>
          </div>
        </div>
    
 <!-- modal container section start -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_filtros_anexos" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">{{ 'tip_fil_modal' | translate }}</h4>
          </div>
          <div class="modal-body">
                        <div class="panel">                  
      <form class="form-validate" id="frmfiltroAnexos" name="frmfiltroAnexos" ng-submit="SubmitFormFiltrosAnexos($event)">                 
 
      <div class="col-12 col-sm-12">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">{{ 'tip_fil1_modal' | translate }}</label>
      <select class="form-control" id="ttipofiltrosAnexos" name="ttipofiltrosAnexos" required ng-model="vm.tmodal_anexos.ttipofiltrosAnexos">
          <option ng-repeat="dato in vm.ttipofiltrosAnexos" value="{{dato.id}}">{{dato.nombre}}</option>
        </select>     
     </div>
     </div>
     </div>

     <div class="col-12 col-sm-12" ng-show="vm.tmodal_anexos.ttipofiltrosAnexos==1">
     <div class="form">                          
     <div class="form-group">     
      <select class="form-control" name="CodCom" ng-model="vm.tmodal_anexos.CodCom">
        <option ng-repeat="dato in vm.Tcomercializadoras | orderBy:'+RazSocCom'" value="{{dato.NumCifCom}}">{{dato.NumCifCom}} - {{dato.RazSocCom}}</option>                        
      </select>   
     </div>
     </div>
    </div> 

    <div class="col-12 col-sm-12" ng-show="vm.tmodal_anexos.ttipofiltrosAnexos==2">
     <div class="form">                          
     <div class="form-group">     
      <select class="form-control" id="DesPro" name="DesPro" ng-model="vm.tmodal_anexos.DesPro">
        <option ng-repeat="dato in vm.TProductos| orderBy:'+DesPro'" value="{{dato.DesPro}}">{{dato.DesPro}}</option>                        
      </select>   
     </div>
     </div>
    </div>

    <div class="col-12 col-sm-12" ng-show="vm.tmodal_anexos.ttipofiltrosAnexos==3">
     <div class="form">                          
     <div class="form-group">     
      <select class="form-control" id="TipServ3" name="TipServ" ng-model="vm.tmodal_anexos.TipServ">
        <option value="1">{{ 'SER_GAS' | translate }}</option>
        <option value="2">{{ 'SER_ELE' | translate }}</option>        
      </select>   
     </div>
     </div>
    </div> 
     <div class="col-12 col-sm-12" ng-show="vm.tmodal_anexos.ttipofiltrosAnexos==3 && vm.tmodal_anexos.TipServ!=undefined">
     <div class="form">                          
     <div class="form-group">     
      <select class="form-control" id="Select1" name="Select" ng-model="vm.tmodal_anexos.Select">
        <option value="SI">{{ 'si_modal' | translate }}</option>
        <option value="NO">{{ 'no_modal' | translate }}</option>      
      </select>   
     </div>
     </div>
    </div> 
    
    <div class="col-12 col-sm-12" ng-show="vm.tmodal_anexos.ttipofiltrosAnexos==4">
     <div class="form">                          
     <div class="form-group">     
      <select class="form-control" id="DesTipCom1" name="DesTipCom" ng-model="vm.tmodal_anexos.DesTipCom">
        <option ng-repeat="dato in vm.Tipos_Comision| orderBy:'+DesTipCom'" value="{{dato.DesTipCom}}">{{dato.DesTipCom}}</option>
      </select>   
     </div>
     </div>
    </div> 

     <div class="col-12 col-sm-12" ng-show="vm.tmodal_anexos.ttipofiltrosAnexos==5">
     <div class="form">                          
     <div class="form-group">     
      
      <input type="text" name="FecIniAne" id="FecIniAne" class="form-control datepicker" ng-model="vm.tmodal_anexos.FecIniAne" placeholder="EJ: DD/MM/YYYY" ng-change="vm.validarsifechaanexos(vm.tmodal_anexos.FecIniAne,1)" maxlength="10">  


     </div>
     </div>
    </div> 

     <div class="col-12 col-sm-12" ng-show="vm.tmodal_anexos.ttipofiltrosAnexos==6">
     <div class="form">                          
     <div class="form-group">     
      <select class="form-control" id="EstAne" name="EstAne" ng-model="vm.tmodal_anexos.EstAne">
        <option value="ACTIVO">{{ 'ACTIVO' | translate }}</option>
        <option value="BLOQUEADO">{{ 'BLOQUEADO' | translate }}</option>                          
      </select>   
     </div>
     </div>
    </div> 

    <div style="margin-left:15px; ">
     <button class="btn btn-info" type="submit" ng-disabled="frmfiltroAnexos.$invalid"><i class="fa fa-check-circle"></i> {{ 'app_modal' | translate }}</button>
      <a class="btn btn-danger" ng-click="vm.quitar_filtro_anexos()" ng-show="vm.tmodal_anexos.ttipofiltrosAnexos>0"><i class="fa fa-trash"></i> {{ 'lim_modal' | translate }}</a>
      </div>
</form>
   </div>
    </div>
</div>
</div>
</div>
<!--modal container section end -->


<!-- modal container section end -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_motivo_bloqueo_anexos" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title"><i class="fa fa-ban"></i> {{ 'BLO_ANNE' | translate }}</h4>
          </div>
          <div class="modal-body">
                        <div class="panel"> 
    <input type="hidden" class="form-control" ng-model="vm.anexos_motivo_bloqueos.CodAnePro" required readonly />
      <form class="form-validate" id="form_lock_Anexos" name="form_lock_Anexos" ng-submit="submitFormlockAnexos($event)">                 
     
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">{{ 'MARKETER' | translate }}</label>
     <input type="text" class="form-control" ng-model="vm.RazSocCom_BloAne" required readonly/>     
     </div>
     </div>

     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">{{ 'PRODUCTS' | translate }}</label>
      <input type="text" class="form-control" ng-model="vm.DesPro_BloAne" required readonly />     
     </div>
     </div>

      <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">{{ 'ANNEXES' | translate }}</label>
      <input type="text" class="form-control" ng-model="vm.DesAnePro_BloAne" required readonly />     
     </div>
     </div>
<div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">{{ 'MOT_BLO_COM_MODAL' | translate }}</label>
       <input type="text" class="form-control" ng-model="vm.anexos_motivo_bloqueos.MotBloAne" required/> 
     </div>
     </div>
    
</div>
    <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">{{ 'FEC_BLO_COM_MODAL' | translate }}</label>
     <input type="text" class="form-control datepicker2" id="FecBloAne" name="FecBloAne" ng-model="vm.FecBloAne" required maxlength="10" ng-change="vm.validarsifechaanexos(vm.FecBloAne,2)" />    
     </div>
     </div>
     </div>

     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">{{ 'OBS_COM_BLO' | translate }}</label>
     <textarea type="text" class="form-control" ng-model="vm.anexos_motivo_bloqueos.ObsMotBloAne" rows="5" maxlength="100"/></textarea>
     </div>
     </div>
    
    <br>
     <button class="btn btn-info" type="submit" ng-disabled="form_lock_Anexos.$invalid"><i class="fa fa-lock"></i>  {{ 'BUTTON_COM_BLO' | translate }}</button>
      <a class="btn btn-danger" data-dismiss="modal"><i class="fa fa-arrow-left"></i> {{ 'BUTTON_COM_REG' | translate }}</a>
</form>
   </div>
    </div>
</div>
</div>
</div>
<!-- modal container section end -->


<script>

  $('.datepicker').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});
  $('#FecIniAne').on('changeDate', function() 
  {
     var FecIniAne=document.getElementById("FecIniAne").value;
     console.log("FecIniAne: "+FecIniAne);
  });

  $('.datepicker2').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});
  $('#FecBloAne').on('changeDate', function() 
  {
     var FecBloAne=document.getElementById("FecBloAne").value;
     console.log("FecBloAne: "+FecBloAne);
  });

</script>


</div>
</body>
<div id="carganto_servicio" class="loader loader-default"  data-text="{{ 'module_data' | translate }}"></div>
<div id="List_Anex" class="loader loader-default"  data-text="{{ 'List_Anex' | translate }}"></div>
</html>
