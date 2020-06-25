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
 <div ng-controller="Controlador_Rueda as vm">
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header">Reporte Rueda</h3>
           
          </div>
        </div>
        <!-- Form validations -->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
             
              <div class="panel-body">


<form id="form_rueda" name="form_rueda" ng-submit="submitFormRueda($event)"> 
     <div class='row'>              
     
      <div class="col-12 col-sm-6">
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Fecha Desde</label>
       <input type="text" class="form-control FecDesde" name="FecDesde" id="FecDesde" ng-model="vm.FecDesde" placeholder="DD/MM/YYYY" maxlength="10" ng-change="vm.validar_formatos_input(1,vm.FecDesde) "/>
         
         </div>
         </div>
      </div>

       <div class="col-12 col-sm-6">
         <div class="form">                          
         <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Fecha Hasta</label>
       <input type="text" class="form-control FecHasta" name="FecHasta" id="FecHasta" ng-model="vm.FecHasta" placeholder="DD/MM/YYYY" maxlength="10" ng-change="vm.validar_formatos_input(2,vm.FecHasta) "/>
         
         </div>
         </div>
      </div>

        <div class="form" align="center">                          
         <div class="form-group">
         <button class="btn btn-info" type="submit">Generar Rueda <!--div ng-show="vm.Table_Contratos.length>0">{{vm.Table_Contratos.length}}</div></button-->           
         </div>
         </div>
          

  </div><!--FINAL ROW -->
        </form>
<div ng-show="vm.Table_Contratos.length>0">
  <a class="btn btn-primary" href="reportes/Exportar_Documentos/Doc_Reporte_Rueda_PDF/{{vm.FecDesde}}/{{vm.FecHasta}}" style="margin-top: 0px;" target="_black" >Ver PDF</a> 
<a class="btn btn-primary" href="reportes/Exportar_Documentos/Doc_Reporte_Rueda_Excel/{{vm.FecDesde}}/{{vm.FecHasta}}" style="margin-top: 0px;" target="_black" >Ver Excel</a>

<label style="margin-top: 0px;">Total: {{vm.Table_Contratos.length}}</label>

<div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive">
                <tbody>
                  <tr>
                  <th >Fecha Inicio</th>
                  <th >Cliente</th>
                  <th >Comercializadora</th>
                  <th >Anexo</th> 
                  <th >Duración</th>  
                  <th >Vencimiento</th>
                  <th >Estatus</th>              
                  <th >Acción</th>
                  </tr>
                  <tr ng-show="vm.Table_Contratos.length==0"> 
                    <td colspan="8" align="center">
                      <div class="td-usuario-table"><i class="fa fa-close"></i> No existe información.</div>
                    </td>           
                    </tr>
                  <tr ng-repeat="dato in vm.Table_Contratos | filter:paginate" ng-class-odd="odd">                    
                    <td >{{dato.FecIniCon}}</td>
                    <td >{{dato.NumCifCli}} - {{dato.RazSocCli}}</td>
                    <td >{{dato.CodCom}}</td>
                    <td >{{dato.Anexo}}</td> 
                    <td >{{dato.DurCon}} Meses</td> 
                    <td >{{dato.FecVenCon}}</td>
                    <td >
                      <span class="label label-success" ng-show="dato.EstBajCon==0"><i class="fa fa-check-circle"></i> Activo</span>
                      <span class="label label-danger" ng-show="dato.EstBajCon==1"><i class="fa fa-ban"></i> Dado de Baja</span>
                      <span class="label label-info" ng-show="dato.EstBajCon==2"><i class="fa fa-close"></i> Vencido</span>
                      <span class="label label-primary" ng-show="dato.EstBajCon==3"><i class="fa fa-check-circle"></i> Renovado</span>
                      <span class="label label-warning" ng-show="dato.EstBajCon==4"><i class="fa fa-check-clock-o"></i> En Renovación</span>
                   </td>
                    <td >
                      <div class="btn-group">
                        <select class="form-control" id="opcion_select" style="width: auto;" name="opcion_select" ng-model="vm.opcion_select[$index]" ng-change="vm.validar_opcion_rueda($index,vm.opcion_select[$index],dato)">
                          <option ng-repeat="opcion in vm.opcion_rueda" value="{{opcion.id}}">{{opcion.nombre}}</option>
                        </select>
                      </div>
                    </td>

                  </tr>
                </tbody>
                <tfoot>                 
                  <th >Fecha Inicio</th>
                  <th >Cliente</th>
                  <th >Comercializadora</th>
                  <th >Anexo</th> 
                  <th >Duración</th>  
                  <th >Vencimiento</th>
                  <th >Estatus</th>              
                  <th >Acción</th>
                </tfoot>
              </table>
        </div>
        <div align="center">          
          <div class='btn-group' align="center">
            <pagination total-items="totalItems" ng-model="currentPage" max-size="5" boundary-links="true" items-per-page="numPerPage" class="pagination-sm">  
            </pagination>
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
          Diseñado por <a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2019</a>
        </div>
    </div>
  </section>

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

</div>
<script>

  
  $('.FecDesde').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});   
  $('#FecDesde').on('changeDate', function() 
  {
     var FecDesde=document.getElementById("FecDesde").value;
     console.log("FecDesde: "+FecDesde);
  });
  $('.FecHasta').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});
  $('#FecHasta').on('changeDate', function() 
  {
     var FecHasta=document.getElementById("FecHasta").value;
     console.log("FecHasta: "+FecHasta);
  }); 

</script>
<script type="text/javascript" src="application/libraries/estilos/js/jquery.validate.min.js"></script>
  <!-- custom form validation script for this page-->
  <script src="application/libraries/estilos/js/form-validation-script.js"></script>
  <!--custome script for all page-->
  <!--script src="application/libraries/estilos/js/scripts.js"></script-->
</body>
<div id="Rueda" class="loader loader-default"  data-text="Generando Reporte Rueda"></div>
</html>
