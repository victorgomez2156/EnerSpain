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
 <div ng-controller="Controlador_Clientes as vm">
 <!--main content start-->
    <section id="main-content">
      <!--wrapper start-->
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-users"></i> Clientes</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>              
              <li><i class="fa fa-users"></i>Clientes</li>
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
                        <li><input type="checkbox" ng-model="vm.fdatos.RazSoc"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Razon Social</b></li></li>
                        <li><input type="checkbox" ng-model="vm.fdatos.NumCif"/> <i class="fa fa-plus-square"></i> <b style="color:black;">CIF</b></li>
                        <li><input type="checkbox" ng-model="vm.fdatos.NomCli"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Nombre Comercial</b></li></li>
                        <li><input type="checkbox" ng-model="vm.fdatos.NomVia"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Domicilio Social</b></li>
                        <li><input type="checkbox" ng-model="vm.fdatos.NumVia"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Número Social</b></li>
                        <li><input type="checkbox" ng-model="vm.fdatos.Blo"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Bloque Social</b></li>
                        <li><input type="checkbox" ng-model="vm.fdatos.Esc"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Escalera Social</b></li>
                        <li><input type="checkbox" ng-model="vm.fdatos.Pla"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Planta Social</b></li>
                        <li><input type="checkbox" ng-model="vm.fdatos.Puer"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Puerta Social</b></li>
                        <li><input type="checkbox" ng-model="vm.fdatos.Pro"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Provincia Social</b></li>
                        <li><input type="checkbox" ng-model="vm.fdatos.Loc"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Localidad Social</b></li>
                        <li><input type="checkbox" ng-model="vm.NomViaFis"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Domicilio Fiscal</b></li>
                        <li><input type="checkbox" ng-model="vm.NumViaFis"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Número Fiscal</b></li>
                        <li><input type="checkbox" ng-model="vm.BloFis"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Bloque Fiscal</b></li>
                        <li><input type="checkbox" ng-model="vm.EscFis"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Escalera Fiscal</b></li>
                        <li><input type="checkbox" ng-model="vm.PlaFis"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Planta Fiscal</b></li>
                        <li><input type="checkbox" ng-model="vm.PuerFis"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Puerta Fiscal</b></li>
                        <li><input type="checkbox" ng-model="vm.ProFis"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Provincia Fiscal</b></li>
                        <li><input type="checkbox" ng-model="vm.LocFis"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Localidad Fiscal</b></li>
                        <li><input type="checkbox" ng-model="vm.fdatos.Tel"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Teléfono</b></li>
                        <li><input type="checkbox" ng-model="vm.fdatos.Ema"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Email</b></li>
                        <li><input type="checkbox" ng-model="vm.fdatos.CodTip"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Tipo Cliente</b></li>
                        <li><input type="checkbox" ng-model="vm.fdatos.CodSecCli"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Sector</b></li>
                        <li><input type="checkbox" ng-model="vm.fdatos.CodCo"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Comercial</b></li>
                        <li><input type="checkbox" ng-model="vm.fdatos.CodCol"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Colaborador</b></li>
                        <li><input type="checkbox" ng-model="vm.fdatos.FechRe"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Fecha Inicio</b></li>
                        <li><input type="checkbox" ng-model="vm.fdatos.Est"/> <i class="fa fa-plus-square"></i> <b style="color:black;">Estatus</b></li>
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

                    <div class="btn-group">
                       <a data-toggle="modal" title='Filtros' data-target="#modal_filtros_clientes" class="btn btn-default"><div><i class="fa fa-filter"></i><span class="caret"></span></div></a>
                     
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
                    <button style="margin-right: 10px;" class="btn btn-info" title="Agregar Cliente" ng-click="vm.modal_cif_cliente()"><i class="fa fa-plus-square"></i></button>
                  </form>                    
                  </div>
              </div>
</div>  <!--t-0002 end-->    
<br><br><br><br>
      <div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive" ng-init="vm.cargar_lista_clientes()">
                <tbody>
                  <tr>
                    
                    <th ng-show="vm.fdatos.RazSoc==true"><i class="fa fa-building"></i> Razon Social</th>
                    <th ng-show="vm.fdatos.NumCif==true"><i class="fa fa-vcard"></i> CIF</th>                    
                    <th ng-show="vm.fdatos.NomCli==true"><i class="fa fa-archive"></i> Nombre Comercial</th>
                    <th ng-show="vm.fdatos.NomVia==true"><i class="fa fa-crop"></i> Dominicilio Social</th>
                    <th ng-show="vm.fdatos.NumVia==true"><i class="fa fa-crosshairs"></i> Número Social</th>
                    <th ng-show="vm.fdatos.Blo==true"><i class="fa fa-bookmark"></i> Bloque Social</th>
                    <th ng-show="vm.fdatos.Esc==true"><i class="fa fa-circle"></i> Escalera Social</th>
                    <th ng-show="vm.fdatos.Pla==true"><i class="fa fa-bullseye"></i> Planta Social</th>
                    <th ng-show="vm.fdatos.Puer==true"><i class="fa fa-braille"></i> Puerta Social</th>
                    <th ng-show="vm.fdatos.Pro==true"><i class="fa fa-dot-circle-o"></i> Provincia Social</th>
                    <th ng-show="vm.fdatos.Loc==true"><i class="fa fa-chain"></i> Localidad Social</th>     
                    <th ng-show="vm.NomViaFis==true"><i class="fa fa-crop"></i> Dominicilio Fiscal</th>
                    <th ng-show="vm.NumViaFis==true"><i class="fa fa-crosshairs"></i> Número Fiscal</th>
                    <th ng-show="vm.BloFis==true"><i class="fa fa-bookmark"></i> Bloque Fiscal</th>
                    <th ng-show="vm.EscFis==true"><i class="fa fa-circle"></i> Escalera Fiscal</th>
                    <th ng-show="vm.PlaFis==true"><i class="fa fa-bullseye"></i> Planta Fiscal</th>
                    <th ng-show="vm.PuerFis==true"><i class="fa fa-braille"></i> Puerta Fiscal</th>
                    <th ng-show="vm.ProFis==true"><i class="fa fa-dot-circle-o"></i> Provincia Fiscal</th>
                    <th ng-show="vm.LocFis==true"><i class="fa fa-chain"></i> Localidad Fiscal</th>
                    <th ng-show="vm.fdatos.Tel==true"><i class="fa fa-phone"></i> Teléfono</th>
                    <th ng-show="vm.fdatos.Ema==true"><i class="fa fa-phone"></i> Email</th>  
                    <th ng-show="vm.fdatos.CodTip==true"><i class="fa fa-tree"></i> Tipo Cliente</th>
                    <th ng-show="vm.fdatos.CodSecCli==true"><i class="fa fa-industry"></i> Sector</th>
                    <th ng-show="vm.fdatos.CodCo==true"><i class="fa fa-tint"></i> Comercial</th>
                    <th ng-show="vm.fdatos.CodCol==true"><i class="fa fa-tint"></i> Colaborador</th>
                    <th ng-show="vm.fdatos.FechRe==true"><i class="fa fa-calendar"></i> Fecha Inicio</th>
                    <th ng-show="vm.fdatos.Est==true"><i class="fa fa-bolt"></i> Estatus</th>                    
                    <th ng-show="vm.fdatos.Acc==true"><i class="icon_cogs"></i> Action</th>
                  </tr>
                  <tr ng-show="vm.Tclientes==undefined"> 
                     <td colspan="5" align="center"><div class="td-usuario-table"><i class="fa fa-close"></i> Actualmente no hay datos disponibles.</div></td>           
                    </tr>
                  <tr ng-repeat="dato in vm.Tclientes | filter:paginate | filter:vm.fdatos.filtrar" ng-class-odd="odd">
                    
                     <td ng-show="vm.fdatos.RazSoc==true">{{dato.RazSocCli}}</td>
                    <td ng-show="vm.fdatos.NumCif==true">{{dato.NumCifCli}}</td>
                    <td ng-show="vm.fdatos.NomCli==true">{{dato.NomComCli}}</td>
                    <td ng-show="vm.fdatos.NomVia==true">{{dato.NomViaDomSoc}}</td>
                    <td ng-show="vm.fdatos.NumVia==true">{{dato.NumViaDomSoc}}</td> 
                    <td ng-show="vm.fdatos.Blo==true">{{dato.BloDomSoc}}</td>  
                    <td ng-show="vm.fdatos.Esc==true">{{dato.EscDomSoc}}</td> 
                    <td ng-show="vm.fdatos.Pla==true">{{dato.PlaDomSoc}}</td> 
                    <td ng-show="vm.fdatos.Puer==true">{{dato.PueDomSoc}}</td> 
                    <td ng-show="vm.fdatos.Pro==true">{{dato.CodPro}}</td> 
                    <td ng-show="vm.fdatos.Loc==true">{{dato.CodLoc}}</td>
                    <td ng-show="vm.NomViaFis==true">{{dato.NomViaDomFis}}</td>
                    <td ng-show="vm.NumViaFis==true">{{dato.NumViaDomFis}}</td> 
                    <td ng-show="vm.BloFis==true">{{dato.BloDomFis}}</td>  
                    <td ng-show="vm.EscFis==true">{{dato.EscDomFis}}</td> 
                    <td ng-show="vm.PlaFis==true">{{dato.PlaDomFis}}</td> 
                    <td ng-show="vm.PuerFis==true">{{dato.PueDomFis}}</td> 
                    <td ng-show="vm.ProFis==true">{{dato.CodProFis}}</td> 
                    <td ng-show="vm.LocFis==true">{{dato.CodLocFis}}</td>
                    <td ng-show="vm.fdatos.Tel==true">{{dato.TelFijCli}}</td> 
                    <td ng-show="vm.fdatos.Ema==true">{{dato.EmaCli}}</td>
                    <td ng-show="vm.fdatos.CodTip==true">{{dato.CodTipCli}}</td>
                    <td ng-show="vm.fdatos.CodSecCli==true">{{dato.CodSecCli}}</td>
                    <td ng-show="vm.fdatos.CodCo==true">{{dato.CodCom}}</td>
                    <td ng-show="vm.fdatos.CodCol==true">
                      <span ng-show="dato.CodCol==null">Sin Colaborador</span>
                      <span ng-show="dato.CodCol!=null">{{dato.CodCol}}</span>
                    </td>
                    <td ng-show="vm.fdatos.FechRe==true">{{dato.FecIniCli}}</td>
                    <td ng-show="vm.fdatos.Est==true">
                      <span class="label label-info" ng-show="dato.EstCli==3"><i class="fa fa-check-circle"></i> {{dato.EstCliN}}</span>
                      <span class="label label-danger" ng-show="dato.EstCli==4"><i class="fa fa-ban"></i> {{dato.EstCliN}}</span>
                    </td> 
                    <td ng-show="vm.fdatos.Acc==true">
                      <div class="btn-group">
                        <select class="form-control" id="opciones_clientes" name="opciones_clientes" ng-model="vm.opciones_clientes[$index]" ng-change="vm.validar_opcion($index,vm.opciones_clientes[$index],dato)">
                          <option ng-repeat="opcion in vm.topciones" value="{{opcion.id}}">{{opcion.nombre}}</option>                          
                        </select>
                      </div>
                    </td>
                  </tr>
                </tbody>
                <tfoot>
                    <th ng-show="vm.fdatos.RazSoc==true"><i class="fa fa-building"></i> Razon Social</th>
                    <th ng-show="vm.fdatos.NumCif==true"><i class="fa fa-vcard"></i> CIF</th>                    
                    <th ng-show="vm.fdatos.NomCli==true"><i class="fa fa-archive"></i> Nombre Comercial</th>
                    <th ng-show="vm.fdatos.NomVia==true"><i class="fa fa-crop"></i> Dominicilio Social</th>
                    <th ng-show="vm.fdatos.NumVia==true"><i class="fa fa-crosshairs"></i> Número Social</th>
                    <th ng-show="vm.fdatos.Blo==true"><i class="fa fa-bookmark"></i> Bloque Social</th>
                    <th ng-show="vm.fdatos.Esc==true"><i class="fa fa-circle"></i> Escalera Social</th>
                    <th ng-show="vm.fdatos.Pla==true"><i class="fa fa-bullseye"></i> Planta Social</th>
                    <th ng-show="vm.fdatos.Puer==true"><i class="fa fa-braille"></i> Puerta Social</th>
                    <th ng-show="vm.fdatos.Pro==true"><i class="fa fa-dot-circle-o"></i> Provincia Social</th>
                    <th ng-show="vm.fdatos.Loc==true"><i class="fa fa-chain"></i> Localidad Social</th>     
                    <th ng-show="vm.NomViaFis==true"><i class="fa fa-crop"></i> Dominicilio Fiscal</th>
                    <th ng-show="vm.NumViaFis==true"><i class="fa fa-crosshairs"></i> Número Fiscal</th>
                    <th ng-show="vm.BloFis==true"><i class="fa fa-bookmark"></i> Bloque Fiscal</th>
                    <th ng-show="vm.EscFis==true"><i class="fa fa-circle"></i> Escalera Fiscal</th>
                    <th ng-show="vm.PlaFis==true"><i class="fa fa-bullseye"></i> Planta Fiscal</th>
                    <th ng-show="vm.PuerFis==true"><i class="fa fa-braille"></i> Puerta Fiscal</th>
                    <th ng-show="vm.ProFis==true"><i class="fa fa-dot-circle-o"></i> Provincia Fiscal</th>
                    <th ng-show="vm.LocFis==true"><i class="fa fa-chain"></i> Localidad Fiscal</th>
                    <th ng-show="vm.fdatos.Tel==true"><i class="fa fa-phone"></i> Teléfono</th>
                    <th ng-show="vm.fdatos.Ema==true"><i class="fa fa-phone"></i> Email</th>  
                    <th ng-show="vm.fdatos.CodTip==true"><i class="fa fa-tree"></i> Tipo Cliente</th>
                    <th ng-show="vm.fdatos.CodSecCli==true"><i class="fa fa-industry"></i> Sector</th>
                    <th ng-show="vm.fdatos.CodCo==true"><i class="fa fa-tint"></i> Comercial</th>
                    <th ng-show="vm.fdatos.CodCol==true"><i class="fa fa-tint"></i> Colaborador</th>
                    <th ng-show="vm.fdatos.FechRe==true"><i class="fa fa-calendar"></i> Fecha Inicio</th>
                    <th ng-show="vm.fdatos.Est==true"><i class="fa fa-bolt"></i> Estatus</th>                    
                    <th ng-show="vm.fdatos.Acc==true"><i class="icon_cogs"></i> Action</th>
                </tfoot>
              </table>
        </div> 
        <div align="center">
          <span class="store-qty"> <a ng-click="vm.cargar_lista_clientes()" title='Refrescar' class="btn btn-success"><div><i class="fa fa-refresh" style="color:white;"></i></div></a> </span>       
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
      <a class="btn btn-danger" data-dismiss="modal">Regresar</a>
</form>
   </div>
    </div>
</div>
</div>
</div>
<!-- modal container section end -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_filtros_clientes" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Tipos de Filtros</h4>
          </div>
          <div class="modal-body">
                        <div class="panel">                  
      <form class="form-validate" id="frmfiltros" name="frmfiltros" ng-submit="SubmitFormFiltrosClientes($event)">                 
     
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

     <div class="col-12 col-sm-6" ng-show="vm.tmodal_data.tipo_filtro==1">
     <div class="form">                          
     <div class="form-group">
     
      <select class="form-control" id="CodTipCli" name="CodTipCli" ng-model="vm.tmodal_data.CodTipCliFil">
        <option ng-repeat="dato in vm.tTipoCliente" value="{{dato.DesTipCli}}">{{dato.DesTipCli}}</option>                        
      </select>   
     </div>
     </div>
    </div>

     <div class="col-12 col-sm-6" ng-show="vm.tmodal_data.tipo_filtro==2">
     <div class="form">                          
     <div class="form-group">
     
      <select class="form-control" id="CodSecCliFil" name="CodSecCliFil" ng-model="vm.tmodal_data.CodSecCliFil">
        <option ng-repeat="dato in vm.tSectores" value="{{dato.DesSecCli}}">{{dato.DesSecCli}}</option>                        
      </select>   
     </div>
     </div>
    </div>

    <div class="col-12 col-sm-6" ng-show="vm.tmodal_data.tipo_filtro==3 || vm.tmodal_data.tipo_filtro==4">
     <div class="form">                          
     <div class="form-group">
     
      <select class="form-control" name="CodPro" ng-model="vm.tmodal_data.CodPro" ng-change="vm.filtrar_loca()">
        <option ng-repeat="dato in vm.tProvidencias" value="{{dato.DesPro}}">{{dato.DesPro}}</option>                          
      </select>    
     </div>
     </div>
    </div>

    <div class="col-12 col-sm-6" ng-show="vm.tmodal_data.tipo_filtro==4">
     <div class="form">                          
     <div class="form-group">
     
      <select class="form-control" id="CodLocFil" name="CodLocFil" ng-model="vm.tmodal_data.CodLocFil" ng-disabled="vm.tmodal_data.CodPro==undefined || vm.tmodal_data.CodPro==null">
        <option ng-repeat="dato in vm.TLocalidadesfiltrada" value="{{dato.DesLoc}}">{{dato.DesLoc}}</option>                         
      </select>     
     </div>
     </div>
     </div> 

     <div class="col-12 col-sm-6" ng-show="vm.tmodal_data.tipo_filtro==5">
     <div class="form">                          
     <div class="form-group">
     
      <select class="form-control" id="CodCom" name="CodCom" ng-model="vm.tmodal_data.CodCom">
        <option ng-repeat="dato in vm.tComerciales" value="{{dato.NomCom}}">{{dato.NomCom}}</option>                        
      </select>   
     </div>
     </div>
    </div> 

    <div class="col-12 col-sm-6" ng-show="vm.tmodal_data.tipo_filtro==6">
     <div class="form">                          
     <div class="form-group">
     
      <select class="form-control" id="CodCol" name="CodCol" ng-model="vm.tmodal_data.CodCol">
        <option ng-repeat="dato in vm.tColaboradores" value="{{dato.NomCol}}">{{dato.NomCol}}</option>                        
      </select>   
     </div>
     </div>
    </div>    

    <div class="col-12 col-sm-6" ng-show="vm.tmodal_data.tipo_filtro==7">
     <div class="form">                          
     <div class="form-group">
     
      <select class="form-control" id="EstCliFil" name="EstCliFil" ng-model="vm.tmodal_data.EstCliFil">
        <option value="3">ACTIVO</option> 
        <option value="4">BLOQUEADO</option>                         
      </select>     
     </div> 
     </div>
     </div>     
    <br ng-show="vm.tmodal_data.tipo_filtro==1 || vm.tmodal_data.tipo_filtro==2 || vm.tmodal_data.tipo_filtro==3|| vm.tmodal_data.tipo_filtro==5|| vm.tmodal_data.tipo_filtro==6|| vm.tmodal_data.tipo_filtro==7">
     <br ng-show="vm.tmodal_data.tipo_filtro==1 || vm.tmodal_data.tipo_filtro==2|| vm.tmodal_data.tipo_filtro==3|| vm.tmodal_data.tipo_filtro==5|| vm.tmodal_data.tipo_filtro==6|| vm.tmodal_data.tipo_filtro==7"> 
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
