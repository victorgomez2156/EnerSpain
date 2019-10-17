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
 <div ng-controller="Controlador_Inmueble as vm">
 <!--main content start-->
    <section id="main-content">
      <!--wrapper start-->
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-users"></i> Tipos de Inmueble</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>              
              <li><i class="fa fa-users"></i>Tipos de Inmueble</li>
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
                        <li><input type="checkbox" ng-model="vm.fdatos.CodTipInm"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Código</b></li></li>
                        <li><input type="checkbox" ng-model="vm.fdatos.DesTipInm"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Descripción</b></li>
                        <li><input type="checkbox" ng-model="vm.fdatos.Acc"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Action</b></li>
                      </ul> 
                    </div>
                    
                    <div class="btn-group">
                      <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button"><i class="fa fa-cloud-upload"></i><span class="caret"></span> </button>
                      <ul class="dropdown-menu">
                        <li style="cursor: pointer;"><a ><i class="fa fa-file"></i> Exportar en PDF</a></li>
                        <li style="cursor: pointer;"><a ><i class="fa fa-file-excel-o"></i> Exportar en Excel</a></li>                        
                      </ul>
                    </div>

    </div>
  </div>
</div>
              
              <div style="float:right;margin-left: 0px;padding: 0px;margin-top: 10px;margin-bottom: 2px; " class="removeForMobile">                   
                <div class="t-0029">
                  <form class="form-inline" role="form">
                    <div class="form-group">
                      <input type="text" class="form-control" ng-model="vm.fdatos.filtrar" minlength="1" id="exampleInputEmail2" placeholder="Escribe para filtrar...">
                    </div>                 
                    <a style="margin-right: 10px;" class="btn btn-info" href="#/Add_Tipo_Inmueble" title="Agregar Inmueble" ><i class="fa fa-plus-square"></i></a>
                  </form>                    
                  </div>
              </div>
</div>  <!--t-0002 end-->    
<br><br><br><br>
      <div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive" ng-init="vm.cargar_lista_inmuebles()">
                <tbody>
                  <tr>
                    
                    <th ng-show="vm.fdatos.CodTipInm==true"><i class="fa fa-building"></i> Código</th>
                    <th ng-show="vm.fdatos.DesTipInm==true"><i class="fa fa-vcard"></i> Descripción</th>
                    <th ng-show="vm.fdatos.Acc==true"><i class="icon_cogs"></i> Action</th>
                  </tr>
                  <tr ng-show="vm.Tinmuebles==undefined"> 
                     <td colspan="3" align="center"><div class="td-usuario-table"><i class="fa fa-close"></i> Actualmente no hay datos disponibles.</div></td>           
                    </tr>
                  <tr ng-repeat="dato in vm.Tinmuebles | filter:paginate | filter:vm.fdatos.filtrar" ng-class-odd="odd">
                    
                     <td ng-show="vm.fdatos.CodTipInm==true">{{dato.CodTipInm}}</td>
                    <td ng-show="vm.fdatos.DesTipInm==true">{{dato.DesTipInm}}</td>                   
                    <td ng-show="vm.fdatos.Acc==true">
                       <a href="#/Edit_Tipo_Inmueble/{{dato.CodTipInm}}" title='Editar Colaborador {{dato.DesTipInm}}' class="btn btn-info btn-icon mg-r-5"><div><i class="fa fa-edit" style="color:white;"></i></div></a>

                        <a ng-click="vm.borrar_row($index,dato.CodTipInm)" title='Eliminar Colaborador {{dato.DesTipInm}}' class="btn btn-danger btn-icon mg-r-5"><div><i class="fa fa-trash" style="color:white;"></i></div></a>
                    </td>
                  </tr>
                </tbody>
                <tfoot>
                    <th ng-show="vm.fdatos.CodTipInm==true"><i class="fa fa-building"></i> Código</th>
                    <th ng-show="vm.fdatos.DesTipInm==true"><i class="fa fa-vcard"></i> Descripción</th>
                    <th ng-show="vm.fdatos.Acc==true"><i class="icon_cogs"></i> Action</th>
                </tfoot>
              </table>
        </div> 
        <div align="center">
          <span class="store-qty"> <a ng-click="vm.cargar_lista_inmuebles()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       
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
          Designed by <a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2019</a>
        </div>
    </div>
  </section>
  <!-- modal container section end -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_motivo_bloqueo" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Bloqueo de Clientes</h4>
          </div>
          <div class="modal-body">
                        <div class="panel"> 
                 <input type="hidden" class="form-control" ng-model="vm.tmodal_data.CodCli" required readonly />
      <form class="form-validate" id="form_lock" name="form_lock" ng-submit="submitFormlock($event)">                 
     <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">CIF</label>
     <input type="text" class="form-control" ng-model="vm.tmodal_data.NumCif" required readonly/>     
     </div>
     </div>
     </div>

    <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Fecha de Bloqueo</label>
     <input type="text" class="form-control" ng-model="vm.tmodal_data.FechBlo" required readonly/>    
     </div>
     </div>
     </div>

     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Razon Social del Cliente</label>
     <input type="text" class="form-control" ng-model="vm.tmodal_data.RazSoc" required readonly />     
     </div>
     </div>

      <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Motivo del Bloqueo</label>
     
      <select class="form-control" id="MotBloq" name="MotBloq" required ng-model="vm.tmodal_data.MotBloq">
          <option ng-repeat="dato in vm.tMotivosBloqueos" value="{{dato.CodMotBloCli}}">{{dato.DesMotBloCli}}</option>
        </select>


     </div>
     </div>

     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Observación</label>
     <textarea type="text" class="form-control" ng-model="vm.tmodal_data.ObsBloCli" rows="5" maxlength="100"/></textarea>
     </div>
     </div>
    
    <br>
     <button class="btn btn-info" type="submit" ng-disabled="form_lock.$invalid">Bloquear</button>
      <a class="btn btn-danger">Regresar</a>
</form>
   </div>
    </div>
</div>
</div>
</div>
<!-- modal container section end -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_filtros" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Tipos de Filtros</h4>
          </div>
          <div class="modal-body">
                        <div class="panel">                  
      <form class="form-validate" id="frmfiltros" name="frmfiltros" ng-submit="SubmitFormFiltros($event)">                 
     
     <div class="col-12 col-sm-6">
     <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">TIPO DE FILTRO</label>
      <select class="form-control" id="MotBloq" name="MotBloq" required ng-model="vm.tmodal_data.tipo_filtro">
          <option ng-repeat="dato in vm.ttipofiltros" value="{{dato.id}}">{{dato.nombre}}</option>
        </select>     
     </div>
     </div>
     </div>
     <br>
     <br>
     <br>
     <br> 

    <div class="col-12 col-sm-6" ng-show="vm.tmodal_data.tipo_filtro==1 || vm.tmodal_data.tipo_filtro==2">
     <div class="form">                          
     <div class="form-group">
     
      <select class="form-control" name="CodPro" ng-model="vm.tmodal_data.CodPro" ng-change="vm.filtrar_loca()">
        <option ng-repeat="dato in vm.tProvidencias" value="{{dato.DesPro}}">{{dato.DesPro}}</option>                          
      </select>    
     </div>
     </div>
    </div>

    <div class="col-12 col-sm-6" ng-show="vm.tmodal_data.tipo_filtro==2">
     <div class="form">                          
     <div class="form-group">
     
      <select class="form-control" id="CodLocFil" name="CodLocFil" ng-model="vm.tmodal_data.CodLocFil" ng-disabled="vm.tmodal_data.CodPro==undefined || vm.tmodal_data.CodPro==null">
        <option ng-repeat="dato in vm.TLocalidadesfiltrada" value="{{dato.DesLoc}}">{{dato.DesLoc}}</option>                         
      </select>     
     </div>
     </div>
     </div> 

      <div class="col-12 col-sm-6" ng-show="vm.tmodal_data.tipo_filtro==3">
     <div class="form">                          
     <div class="form-group">
     
      <select class="form-control" id="CodTipCli" name="CodTipCli" ng-model="vm.tmodal_data.CodTipCliFil">
        <option ng-repeat="dato in vm.tTipoCliente" value="{{dato.DesTipCli}}">{{dato.DesTipCli}}</option>                        
      </select>   
     </div>
     </div>
    </div>

    <div class="col-12 col-sm-6" ng-show="vm.tmodal_data.tipo_filtro==4">
     <div class="form">                          
     <div class="form-group">
     
      <select class="form-control" id="EstCliFil" name="EstCliFil" ng-model="vm.tmodal_data.EstCliFil">
        <option value="3">Activo</option> 
        <option value="4">Bloqueado</option>                         
      </select>     
     </div> 
     </div>
     </div>     
    <br ng-show="vm.tmodal_data.tipo_filtro==1 || vm.tmodal_data.tipo_filtro==3 || vm.tmodal_data.tipo_filtro==4">
     <br ng-show="vm.tmodal_data.tipo_filtro==1 || vm.tmodal_data.tipo_filtro==3 || vm.tmodal_data.tipo_filtro==4"> 
    <br>
    <div style="margin-left:15px; ">
     <button class="btn btn-info" type="submit" ng-disabled="frmfiltros.$invalid">APLICAR</button>
      <a class="btn btn-danger" ng-click="vm.regresar_filtro()">REGRESAR</a>
      </div>
</form>
   </div>
    </div>
</div>
</div>
</div>
<!--modal container section end -->
<!--modal modal_cif_cliente section START -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_cif_cliente" class="modal fade">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                        <h4 class="modal-title">Ingrese Número de CIF:</h4>
                      </div>
                      <div class="modal-body">
                        <form class="form-horizontal" role="form" id="cif_consulta_form" name="cif_consulta_form" ng-submit="Consultar_CIF($event)"> 
                          <div class="form-group">
                            <label for="inputEmail1" class="col-lg-2 control-label"><i class="fa fa-vcard" title="Número de CIF"></i> Número de CIF:</label>
                            <div class="col-lg-10">
                              <input type="text" class="form-control" ng-model="vm.fdatos.NumCifCli" placeholder="* Ingrese Número de CIF" maxlength="50" required/>   
                            </div>
                          </div>
                          <button class="btn btn-info" type="submit" ng-disabled="cif_consulta_form.$invalid">CONSULTAR</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
<!--modal modal_cif_cliente section END -->




</div>
</body>
<div id="cargando" class="loader loader-default"  data-text="Cargando lista de Clientes, Por Favor Espere..."></div>
<div id="borrando" class="loader loader-default"  data-text="Borrando Cliente, Por Favor Espere..."></div>
<div id="NumCifCli" class="loader loader-default"  data-text="Comprobando Número de CIF, Por Favor Espere..."></div>
</html>
