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
 <div ng-controller="Controlador_Seguimientos as vm">
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header">Control de Seguimientos</h3>
           
          </div>
        </div>
        <!-- Form validations -->
        <div class="row">
          <div class="col-lg-12">
            
            <section class="panel">
             
              <div class="panel-body">


<form id="register_form_seguimientos" name="register_form_seguimientos" ng-submit="submitFormSeguimientos($event)"> 
     <div class='row'>              
       <div class="col-12 col-sm-4" ng-click="vm.containerClicked()">
       <div class="form">                          
      <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Cliente <i class="fa fa-refresh" ng-show="vm.fdatos.CodCli!=undefined" ng-click="vm.limpiar_cliente()"></i> </label>        
        <input type="text" class="form-control" ng-model="vm.RazSocCli" ng-keyup='vm.fetchClientes()' ng-click='vm.searchboxClicked($event)' placeholder="* Razón Social / Apellidos, Nombre, CIF, Email"/>
        <ul id='searchResult'>
        <li ng-click='vm.setValue($index,$event,result,1)' ng-repeat="result in vm.searchResult" >
        {{ result.NumCifCli }} - {{ result.RazSocCli }} 
        </li>
        </ul> 
        <input type="hidden" class="form-control" ng-model="vm.fdatos.CodCli" readonly="readonly"/>
      </div>
       </div>
       </div>

      <div class="col-12 col-sm-4">
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Tipo de Gestión Comercial</label>
         
         <select class="form-control" id="TipSeg" name="TipSeg" required ng-model="vm.fdatos.TipSeg" ng-disabled="vm.fdatos.CodCli==undefined" ng-change="vm.BuscarTipoGestionComercial()"> 
         <option value="P">Propuesta Comercial</option>
         <option value="C">Contrato</option>
         <option value="G">Gestion General</option>
        </select>
         </div>
         </div>
      </div>

      <div class="col-12 col-sm-4">
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Gestión Comercial</label>
          <select class="form-control" id="CodRef" name="CodRef" required ng-model="vm.fdatos.CodRef" ng-disabled="vm.fdatos.TipSeg==undefined" ng-change="vm.FilterGestion(vm.fdatos.CodRef)"> 
        <option ng-repeat="dato_act in vm.List_Gestiones" value="{{dato_act.CodRef}}">{{dato_act.FecGes}} - {{dato_act.NumGes}} - {{dato_act.RefGes}}</option>
        </select>
        
         
         </div>
         </div>
      </div>

      <div class="col-12 col-sm-3">
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Fecha de Registro</label>
       <input type="text" class="form-control FecSeg" name="FecSeg" id="FecSeg" ng-model="vm.FecSeg" placeholder="DD/MM/YYYY" maxlength="10" ng-change="vm.validar_formatos_input(1,vm.FecSeg) "/>
         
         </div>
         </div>
      </div>

       <div class="col-12 col-sm-3">
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Nº Seguimiento</label>
          
       <input type="text" class="form-control" name="NumSeg" id="NumSeg" ng-model="vm.fdatos.NumSeg" placeholder="00000000001" readonly="readonly"/>
         
         </div>
         </div>
      </div>
  
      <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Tipo de Seguimiento</label>
             <select class="form-control" id="ResSeg" name="ResSeg" required ng-model="vm.fdatos.ResSeg"> 
              <option value="P">En Proceso</option>
              <option value="C">Completado</option>
              <option value="R">Rechazado</option>
        </select>    
             </div>
             </div>
          </div>

        <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Referencia </label>
             <input type="text" class="form-control" name="RefSeg" id="RefSeg" ng-model="vm.fdatos.RefSeg" placeholder="Referencia"/>  
             </div>
             </div>
          </div>

         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Descripción</label>
        <textarea class="form-control" name="DesSeg" id="DesSeg" rows="5" placeholder="Descripción del seguimiento" ng-model="vm.fdatos.DesSeg" ></textarea>        
         </div>
         </div>

         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Comentarios</label>
        <textarea class="form-control" name="ObsSeg" id="ObsSeg" rows="5" placeholder="Comentarios del seguimiento" ng-model="vm.fdatos.ObsSeg" ></textarea>        
         </div>
         </div>

         <div class="form-group" >
          <div class="col-12 col-sm-12" align="right">
            <button class="btn btn-info" type="submit">Registrar</button>

            <!--a class="btn btn-warning" href="reportes/Exportar_Documentos/Doc_Contrato_Cliente_PDF/{{vm.fdatos.CodConCom}}" style="margin-top: 0px;" target="_black" ng-show="vm.fdatos.tipo=='editar' || vm.fdatos.tipo=='ver'">Generar PDF</a-->
            <!--button class="btn btn-success" type="submit" ng-show="vm.fdatos.CodConCom>0 " >Actualizar</button-->            
            <!--button class="btn btn-warning" type="button"  ng-click="vm.limpiar()" ng-show="vm.fdatos.CodConCom==undefined||vm.fdatos.CodConCom==null||vm.fdatos.CodConCom==''">Limpiar</button-->
            <!--button class="btn btn-primary" type="button" style="margin-top: 10px;" ng-click="vm.regresar()">Volver</button-->
          </div>
        </div> <input class="form-control" id="CodSeg" name="CodSeg" type="hidden" ng-model="vm.fdatos.CodSeg" readonly/>

  </div><!--FINAL ROW -->
        </form>
<div ng-show="vm.fdatos.UltTipSeg=='P'||vm.fdatos.UltTipSeg=='C'||vm.fdatos.UltTipSeg=='R'">
<label class="font-weight-bold nexa-dark" style="color:black;">Reporte de Seguimientos </label> <a class="btn btn-primary" href="reportes/Exportar_Documentos/Doc_Reporte_Seguimiento_PDF/{{vm.fdatos.CodCli}}/{{vm.fdatos.TipSeg}}/{{vm.fdatos.CodRef}}" style="margin-top: 0px;" target="_black" >Generar PDF</a>
<div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive">
                <tbody>
                  <tr>
                  <th>Fecha</th>
                  <th>Nº Seguimiento</th>
                  <th>Descripción</th>
                  <th>Referencia</th> 
                  <th>Resultado</th>  
                  <th>Comentarios</th>
                  </tr>
                  <tr ng-show="vm.T_Seguimientos.length==0"> 
                    <td colspan="6" align="center">
                      <div class="td-usuario-table"><i class="fa fa-close"></i> No hay información.</div>
                    </td>           
                    </tr>
                  <tr ng-repeat="dato in vm.T_Seguimientos | filter:paginate | filter:vm.filtrar" ng-class-odd="odd">                    
                    <td >{{dato.FecSeg}}</td>
                    <td >{{dato.NumSeg}}</td>
                    <td >{{dato.DesSeg}}</td>
                    <td>{{dato.RefSeg}}</td> 
                    <td> 
                      <span class="label label-info" ng-show="dato.ResSeg=='P'"><i class="fa fa-clock-o"></i> En Proceso</span>
                      <span class="label label-success" ng-show="dato.ResSeg=='C'"><i class="fa fa-check-circle"></i> Completado</span>
                      <span class="label label-danger" ng-show="dato.ResSeg=='R'"><i class="fa fa-ban"></i> Rechazado</span>
                    </td>
                    <td>{{dato.ObsSeg}}</td>
                  </tr>
                </tbody>
                <tfoot>                 
                  <th>Fecha</th>
                  <th>Nº Seguimiento</th>
                  <th>Descripción</th>
                  <th>Referencia</th> 
                  <th>Resultado</th>  
                  <th>Comentarios</th>
                </tfoot>
              </table>
          </div>
</div>










</div>
            </section>


            
          </div>
        </div>
        <!-- page end-->
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
          Diseñado por <a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2019 - 2021</a>
        </div>
    </div>
  </section>
</div>
  <!-- container section end -->

<script>

  
  $('.FecSeg').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});   
  //$('.datepicker_Vencimiento').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});

//datepicker_Vencimiento
  $('#FecSeg').on('changeDate', function() 
  {
     var FecSeg=document.getElementById("FecSeg").value;
     console.log("FecSeg: "+FecSeg);
  });

</script>
<script type="text/javascript" src="application/libraries/estilos/js/jquery.validate.min.js"></script>
  <!-- custom form validation script for this page-->
  <script src="application/libraries/estilos/js/form-validation-script.js"></script>
  <!--custome script for all page-->
  <!--script src="application/libraries/estilos/js/scripts.js"></script-->
</body>
<div id="Guardando" class="loader loader-default"  data-text="Grabando Seguimiento"></div>
<div id="Actualizando" class="loader loader-default"  data-text="Actualizando Seguimiento"></div>
<div id="buscando" class="loader loader-default"  data-text="Buscando Seguimiento"></div>
</html>
