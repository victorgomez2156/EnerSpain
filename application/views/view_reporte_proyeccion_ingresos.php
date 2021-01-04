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
  <div ng-controller="Controlador_Proyeccion_Ingresos as vm">
    <!--main content start-->
    <section id="main-content">
      <!--wrapper start-->
      <section class="wrapper">
      <div class="row">
            <div class="col-lg-12">
              <h3 class="page-header">Reporte de Proyección de Ingresos</h3>           
            </div>
      </div>

      <div class="row">
        <div class="col-lg-12">
        <!--panel start-->
        <section class="panel">

    <form id="register_form_proyeccion_ingresos" name="register_form_proyeccion_ingresos" ng-submit="submitFormProIng($event)">

      <div class="col-12 col-sm-12">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Año <b style="color:red;">(*)</b></label>
        <select class="form-control" id="ano" name="ano" ng-model="vm.fdatos.ano">
         
          <!--option ng-repeat="dato in vm.List_Ano" value="{{dato.ano}}">{{dato.ano}}</option-->
          <?php   
            $fsis = date("Y m d h i a");
            list($sano, $smes, $sdia, $shora, $smin, $sap ) = explode(" ", $fsis);            
            $actual = strtotime($sano);
            $Hasta = date("Y", strtotime("+ 10 year", $actual)); 
            for($i=2020; $i <=$Hasta; $i++)   
            {
              echo "<option value=".$i." ng-model='vm.fdatos.ano' name='ano' id='ano'>".$i."</option>";
            }          
          ?>
        </select> 
       
       </div>
       </div>
       </div>

      <div class="form-group" >
          <div class="col-12 col-sm-12">
            <button class="btn btn-info" type="submit">Generar</button>
            
            <a ng-show="vm.excel_proyeccion==true" title='Descargar Reporte Proyección de Ingresos {{vm.fdatos.ano}}' href="documentos/reportes/{{vm.nombre_reporte}}" class="btn btn-success" download><div><i class="fa fa-cloud-download" style="color:white;"></i></div></a>
          </div>
      </div>


      </form><br>
        </section> 
       </div>
      </div>
      <!-- page end-->
      </section>
      <!--wrapper end-->
    </section>
      <!--main content end-->
    <div class="text-right">
      <div class="credits">
        Diseñador Por <a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2019 - 2021</a>
      </div>
    </div>
  <div id="Proyeccion_Ingresos" class="loader loader-default"  data-text="Generando Reporte de Proyecciones de Ingresos Año {{vm.fdatos.ano}}"></div>
  </div> <!--fin div controller-->
</body>
</html>
