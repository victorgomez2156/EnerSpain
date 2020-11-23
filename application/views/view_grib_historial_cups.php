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
 <div ng-controller="Controlador_Cups as vm">
 <!--main content start-->
    <section id="main-content">
      <!--wrapper start-->
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header">Ver Historial Consumo del CUP</h3>
            <!--<ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>              
              <li><i class="fa fa-cube"></i>Historial Consumo Cups</li>
            </ol>-->
          </div>
        </div>
        <!-- page start-->
        <div class="row">
          <div class="col-lg-12">
            <!--panel start-->
            <section class="panel">


    <div class="panel-body"> 

<form id="historial_form" name="historial_form" ng-submit="submitFormHistorial($event)"> 
 
 <input type="hidden" class="form-control" ng-model="vm.historial.CodCup" readonly />
      <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">         
        <label class="font-weight-bold nexa-dark" style="color:black;">Desde <b style="color:red;">DD/MM/YYYY</b></label>
        <input type="text" class="form-control datepicker" name="desde" id="desde" ng-model="vm.historial.desde"  ng-change="vm.validar_fecha_inputs(20,vm.historial.desde)" maxlength="10" />
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">         
        <label class="font-weight-bold nexa-dark" style="color:black;">Hasta <b style="color:red;">DD/MM/YYYY</b></label>
        <input type="text" class="form-control datepicker2" name="hasta" id="hasta" ng-model="vm.historial.hasta"  ng-change="vm.validar_fecha_inputs(21,vm.historial.hasta)" maxlength="10" />
       </div>
       </div>
       </div>
     <div align="center" >
          
            <button class="btn btn-info" type="submit" ng-disabled="historial_form.$invalid">Consultar</button>       
            <button class="btn btn-primary" type="button" style="margin-top: 10px;" ng-click="vm.regresar_a_cups()">Volver</button>
         
        </div>
</form> 

<div ng-show="vm.result_his==true">
<div class="table-responsive">
          <table class="table table-striped table-advance table-hover table-responsive">
                <tbody>
                  <tr>
                    <th ng-show="vm.PotCon1==true">PotCon1</th>
                    <th ng-show="vm.PotCon2==true">PotCon2</th>                                        
                    <th ng-show="vm.PotCon3==true">PotCon3</th>
                    <th ng-show="vm.PotCon4==true">PotCon4</th>
                    <th ng-show="vm.PotCon5==true">PotCon5</th>
                    <th ng-show="vm.PotCon6==true">PotCon6</th>
                    <th ng-show="vm.FecIniConHis==true"><i class="fa fa-calendar"></i> Fecha Inicio</th>
                    <th ng-show="vm.FecFinConHis==true"><i class="fa fa-calendar"></i> Fecha Final</th>
                    <th ng-show="vm.ConCupHis==true">Consumo</th>
                  </tr>
                  <tr ng-show="vm.T_Historial_Consumo.length==0"> 
                     <td colspan="9" align="center"><div class="td-usuario-table"><i class="fa fa-close"></i> No ahi datos disponibles.</div></td>
                  </tr>
                  <tr ng-repeat="dato in vm.T_Historial_Consumo | filter:paginate1250" ng-class-odd="odd">                    
                    <td ng-show="vm.PotCon1==true">{{dato.PotCon1}}</td>
                    <td ng-show="vm.PotCon2==true">{{dato.PotCon2}}</td>
                    <td ng-show="vm.PotCon3==true">{{dato.PotCon3}}</td>
                    <td ng-show="vm.PotCon4==true">{{dato.PotCon4}}</td>  
                    <td ng-show="vm.PotCon5==true">{{dato.PotCon5}}</td>  
                    <td ng-show="vm.PotCon6==true">{{dato.PotCon6}}</td>
                    <td ng-show="vm.FecIniConHis==true">{{dato.FecIniCon}}</td>
                    <td ng-show="vm.FecFinConHis==true">{{dato.FecFinCon}}</td>
                    <td ng-show="vm.ConCupHis==true">{{dato.ConCup}}</td>
                  </tr>
                  <tr>                    
                    <td><b>Total Consumo:</b> </td>
                    <td ng-show="vm.PotCon1==true"></td>
                    <td ng-show="vm.PotCon1==true"></td>
                    <td ng-show="vm.PotCon1==true"></td>
                    <td ng-show="vm.PotCon1==true"></td>
                    <td ng-show="vm.PotCon1==true"></td>
                    <td ng-show="vm.PotCon1==true"></td>
                    <td></td>
                    <td>{{vm.Total_Consumo}}</td>
                  </tr>
                </tbody>
                <tfoot>
                    <th ng-show="vm.PotCon1==true">PotCon1</th>
                    <th ng-show="vm.PotCon2==true">PotCon2</th>                                        
                    <th ng-show="vm.PotCon3==true">PotCon3</th>
                    <th ng-show="vm.PotCon4==true">PotCon4</th>
                    <th ng-show="vm.PotCon5==true">PotCon5</th>
                    <th ng-show="vm.PotCon6==true">PotCon6</th>
                    <th ng-show="vm.FecIniConHis==true"><i class="fa fa-calendar"></i> Fecha Inicio</th>
                    <th ng-show="vm.FecFinConHis==true"><i class="fa fa-calendar"></i> Fecha Final</th>
                    <th ng-show="vm.ConCupHis==true">Consumo</th>
                </tfoot>
              </table>               
        </div>
        
        <div align="center">
          <span class="store-qty"> <a href="reportes/Exportar_Documentos/Historial_Consumo_CUPs_PDF/{{vm.desde}}/{{vm.hasta}}/{{vm.CodCup}}/{{vm.historial.TipServ}}" target="_black" title='Descargar PDF' class="btn btn-info"><div><i class="fa fa-file" style="color:white;"></i></div></a> </span>
           <span class="store-qty"> <a href="reportes/Exportar_Documentos/Historial_Consumo_CUPs_Excel/{{vm.desde}}/{{vm.hasta}}/{{vm.CodCup}}/{{vm.historial.TipServ}}" target="_black" title='Descargar EXCEL' class="btn btn-info"><div><i class="fa fa-file-excel-o" style="color:white;"></i></div></a> </span>       
          <div class='btn-group' align="center">
            <pagination total-items="totalItems" ng-model="currentPage" max-size="5" boundary-links="true" items-per-page="numPerPage" class="pagination-sm">  
            </pagination>
          </div>
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
          Diseñado Por <a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2020</a>
        </div>
    </div>
  </section>

</div>

 <script>
      $(function(){
        'use strict'
        jQuery(function($) 
        {      
          //jquery tabs
          $( "#tabs_clientes").tabs(); 
         
      });
      });
    </script>
     <script>
      $(function(){
        'use strict'

        $('.datepicker').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true}); 
        $('#desde').on('changeDate', function() 
        {
           var desde=document.getElementById("desde").value;
           console.log("desde: "+desde);
        });
        $('.datepicker2').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});   

        $('#hasta').on('changeDate', function() 
        {
           var hasta=document.getElementById("hasta").value;
           console.log("hasta: "+hasta);
        });
      });
    </script>
</body>


<div id="carganto_servicio" class="loader loader-default"  data-text="Cargando Información"></div>

<div id="cargando" class="loader loader-default"  data-text="Cargando listado de CUPs"></div>
<div id="cargandos_cups" class="loader loader-default"  data-text="Cargando Información del CUP"></div>
<div id="Actualizando" class="loader loader-default"  data-text="Actualizando CUP"></div>
<div id="Guardando" class="loader loader-default"  data-text="Guardando CUP"></div>                 
<div id="Baja" class="loader loader-default"  data-text="Dando de Baja CUP"></div>   
<div id="Generar_Consumo" class="loader loader-default"  data-text="Generando Historial de Consumo"></div> 

</html>
