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
 <div ng-controller="Controlador_ConsumoCUPs as vm">
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header">Reporte Consumo CUPS</h3>
           
          </div>
        </div>
        <!-- Form validations -->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
             
              <div class="panel-body">


<form id="form_rueda" name="form_rueda" ng-submit="submitFormConsumo($event)"> 
     <div class='row'>              
      
      <div class="col-12 col-sm-12">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Comercializadora </label>
             <select class="form-control" id="CodCom" name="CodCom" ng-model="vm.fdatos.CodCom"> 
                <option ng-repeat="dato_act in vm.List_Comercializadora" value="{{dato_act.CodCom}}">{{dato_act.NomComCom}}</option>
        </select>     
             </div>
             </div>
          </div>

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
         <button class="btn btn-info" type="submit">Generar Reporte <!--div ng-show="vm.Table_Contratos.length>0">{{vm.Table_Contratos.length}}</div></button-->           
         </div>
         </div>
          

  </div><!--FINAL ROW -->
        </form>

            
          <div ng-show="vm.MostrarDatos==true">

          <div class="foreign-supplier-title clearfix">
            <h4 class="breadcrumb">     
              <span class="foreign-supplier-text" style="color:black;"> Total Puntos Suministro: {{vm.totalCount}} </span>
            </h4>
          </div>

          <div class="foreign-supplier-title clearfix">
            <h4 class="breadcrumb">     
              <span class="foreign-supplier-text" style="color:black;"> Consumo CUPs: {{vm.ConsumoTotalFinal}} </span>
            </h4>
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
          Dise??ado por <a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2019 - 2021</a>
        </div>
    </div>
  </section>
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
   $('.FecProCom').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});  

</script>
<script type="text/javascript" src="application/libraries/estilos/js/jquery.validate.min.js"></script>
  <!-- custom form validation script for this page-->
  <script src="application/libraries/estilos/js/form-validation-script.js"></script>
  <!--custome script for all page-->
  <!--script src="application/libraries/estilos/js/scripts.js"></script-->
</body>
<div id="Loading" class="loader loader-default"  data-text="Generando Reporte"></div>
</html>
