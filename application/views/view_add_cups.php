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
            <h3 class="page-header"></i>Listado de CUPs</h3>
            <!--<ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>              
              <li><i class="fa fa-cube"></i>Registrar Cups</li>
            </ol>-->
          </div>
        </div>
        <!-- page start-->
        <div class="row">
          <div class="col-lg-12">
            <!--panel start-->
            <section class="panel">
 <div class="panel-body"> 



 <form id="register_form" name="register_form" ng-submit="submitFormCups($event)"> 
     <div class='row'>              
        <div class="col-12 col-sm-12">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Punto de Suministro <b style="color:red;">(*)</b></label>
        <select class="form-control" id="CodDis" name="CodDis" ng-model="vm.fdatos_cups.CodPunSum" ng-disabled="vm.validate_info!=undefined">
        <option ng-repeat="dato in vm.T_PuntoSuministros" value="{{dato.CodPunSum}}">{{dato.NumCifCli}} - {{dato.RazSocCli}},
        {{dato.DesTipVia}} {{dato.NomViaPunSum}} {{dato.NumViaPunSum}} {{dato.BloPunSum}} {{dato.EscPunSum}} {{dato.PlaPunSum}} {{dato.PuePunSum}}</option>                          
        </select>
       </div>
       </div>
       </div>
       
       <!--div ng-show="vm.fdatos_cups.CodPunSum!=undefined">

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">CIF</label>
       <input type="text" class="form-control" ng-model="vm.Cups_Cif" maxlength="9" readonly placeholder="* Número del CIF del Cliente"/>
       
       </div>
       </div>
       </div>       
       <div class="col-12 col-sm-8">
       <div class="form"> 
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Razón Social</label>       
        <div class="input-append date">
          <input class="form-control" size="16" type="text" readonly ng-model="vm.Cups_RazSocCli" placeholder="* Razón Social del Cliente">      
      </div>
      
       </div>
       </div>
       </div>
       

       <div class="col-12 col-sm-12">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Punto de Suministro</label>
       <input type="text" class="form-control" ng-model="vm.Cups_Dir" onkeyup="this.value=this.value.toUpperCase();" readonly maxlength="100"/>       
       </div>
       </div>
       </div>
       
       </div-->


      <div class="col-12 col-sm-2">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">CUPS <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fdatos_cups.cups" onkeyup="this.value=this.value.toUpperCase();" placeholder="* ES" maxlength="2" ng-disabled=" vm.validate_info!=undefined"/>
       </div>
       </div>
       </div>    

      <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">  
       <label class="font-weight-bold nexa-dark" style="color:white;">.</label>     
       <input type="text" class="form-control" ng-model="vm.fdatos_cups.cups1" onkeyup="this.value=this.value.toUpperCase();" maxlength="16" ng-disabled="vm.validate_info!=undefined"/>
       </div>
       </div>
       </div>  
        <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
       <input type="text" class="form-control" ng-model="vm.fdatos_cups.cups2" onkeyup="this.value=this.value.toUpperCase();" maxlength="2" ng-disabled=" vm.validate_info!=undefined"/>
       </div>
       </div>
       </div>      
      <div style="margin-top: 8px;">
       <div align="left"><label class="font-weight-bold nexa-dark" style="color:black;"><b>TIPO SERVICIO</b></label></div></div>
      
      <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Eléctrico</label>
       <input type="radio" ng-model="vm.fdatos_cups.TipServ" ng-disabled=" vm.validate_info!=undefined" value="1" ng-click="vm.por_servicios(vm.fdatos_cups.TipServ)"/>
       <label class="font-weight-bold nexa-dark" style="color:black;">Gas</label>
       <input type="radio" ng-model="vm.fdatos_cups.TipServ" ng-disabled=" vm.validate_info!=undefined" value="2" ng-click="vm.por_servicios(vm.fdatos_cups.TipServ)"/>
       </div>
       </div>
       </div>

     <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Distribuidora <b style="color:red;">(*)</b></label>
        <select class="form-control" id="CodDis" name="CodDis"  ng-model="vm.fdatos_cups.CodDis" ng-disabled="vm.fdatos_cups.TipServ==0||vm.validate_info!=undefined">
        <option ng-repeat="dato in vm.T_Distribuidoras" value="{{dato.CodDist}}">{{dato.NumCifDis}} - {{dato.RazSocDis}}</option>                          
        </select>
       </div>
       </div>
       </div>
<!-- || vm.validate_info!=undefined||vm.sin_data!=undefined
|| vm.validate_info!=undefined||vm.sin_data!=undefined-->
      <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Tarifa <b style="color:red;">(*)</b></label>
        <select class="form-control" id="CodTar" name="CodTar"  ng-model="vm.fdatos_cups.CodTar" ng-disabled="vm.fdatos_cups.TipServ==0||vm.validate_info!=undefined">
        <option ng-repeat="dato in vm.T_Tarifas" value="{{dato.CodTar}}">{{dato.NomTar}}</option>                          
        </select>
       </div>
       </div>
       </div>


<div ng-show="vm.fdatos_cups.TipServ==1">   
  <div class="col-12 col-sm-1">
       <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:black;">Potencia </label>
        <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotConP1" onkeyup="this.value=this.value.toUpperCase();" ng-disabled=" vm.validate_info!=undefined" placeholder="P1" ng-change="vm.validar_fecha_inputs(4,vm.fdatos_cups.PotConP1)"/>
       </div>
       </div>
       </div>

  <div class="col-12 col-sm-1">
       <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:black;"> Contratada </label>
        <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotConP2" onkeyup="this.value=this.value.toUpperCase();" ng-disabled=" vm.validate_info!=undefined" placeholder="P2" ng-change="vm.validar_fecha_inputs(5,vm.fdatos_cups.PotConP2)"/>
       </div>
       </div>
    </div>

       <div class="col-12 col-sm-1">
       <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:black;">  (Kw)</label>
        <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotConP3" onkeyup="this.value=this.value.toUpperCase();" ng-disabled=" vm.validate_info!=undefined" placeholder="P3" ng-change="vm.validar_fecha_inputs(6,vm.fdatos_cups.PotConP3)"/>
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-1">
       <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
        <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotConP4" onkeyup="this.value=this.value.toUpperCase();" ng-disabled=" vm.validate_info!=undefined" placeholder="P4" ng-change="vm.validar_fecha_inputs(7,vm.fdatos_cups.PotConP4)"/>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-1">
       <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
        <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotConP5" onkeyup="this.value=this.value.toUpperCase();" ng-disabled=" vm.validate_info!=undefined" placeholder="P5" ng-change="vm.validar_fecha_inputs(8,vm.fdatos_cups.PotConP5)"/>
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-1">
       <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:white;">.</label>
        <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotConP6" onkeyup="this.value=this.value.toUpperCase();" ng-disabled=" vm.validate_info!=undefined" placeholder="P6" ng-change="vm.validar_fecha_inputs(9,vm.fdatos_cups.PotConP6)"/>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">         
        <label class="font-weight-bold nexa-dark" style="color:black;">Potencia Máxima BIE <b style="color:red;">(*)</b></label>
        <input type="text" class="form-control" ng-model="vm.fdatos_cups.PotMaxBie" onkeyup="this.value=this.value.toUpperCase();" ng-disabled=" vm.validate_info!=undefined" ng-change="vm.validar_fecha_inputs(10,vm.fdatos_cups.PotMaxBie)"/>
       </div>
       </div>
       </div>

       
  </div> 
<div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">         
        <label class="font-weight-bold nexa-dark" style="color:black;">Fecha de Alta <b style="color:red;">DD/MM/YYYY</b></label>
        <input type="text" class="form-control datepicker" ng-model="vm.fdatos_cups.FecAltCup" name="FecAltCup" id="FecAltCup" onkeyup="this.value=this.value.toUpperCase();" ng-disabled=" vm.validate_info!=undefined" ng-change="vm.validar_fecha_inputs(1,vm.fdatos_cups.FecAltCup)"/>
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">         
        <label class="font-weight-bold nexa-dark" style="color:black;">Fecha Última Lectura <b style="color:red;">DD/MM/YYYY</b></label>
        <input type="text" class="form-control datepicker2" ng-model="vm.fdatos_cups.FecUltLec"  name="FecUltLec" id="FecUltLec" onkeyup="this.value=this.value.toUpperCase();" ng-disabled=" vm.validate_info!=undefined" ng-change="vm.validar_fecha_inputs(2,vm.fdatos_cups.FecUltLec)"/>
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">         
        <label class="font-weight-bold nexa-dark" style="color:black;">Consumo (Kw) <b style="color:red;">(*)</b></label>
        <input type="text" class="form-control" ng-model="vm.fdatos_cups.ConAnuCup" onkeyup="this.value=this.value.toUpperCase();" ng-disabled=" vm.validate_info!=undefined" ng-change="vm.validar_fecha_inputs(3,vm.fdatos_cups.ConAnuCup)"/>
       </div>
       </div>
       </div>
  <input type="hidden" class="form-control" ng-model="vm.fdatos_cups.CodCup" readonly />      
         <div class="form-group" >
          <div class="col-12 col-sm-6">
            <button class="btn btn-info" type="submit" ng-show="vm.fdatos_cups.CodCup==undefined||vm.fdatos_cups.CodCup==null||vm.fdatos_cups.CodCup==''" >Crear</button>
            <button class="btn btn-success" type="submit" ng-show="vm.fdatos_cups.CodCup>0 && vm.validate_info==undefined">Actualizar</button>            
            <button class="btn btn-primary" type="button" style="margin-top: 10px;" ng-click="vm.regresar_cups()">Volver</button>
          </div>
        </div>








        

        
         </div><!--FINAL ROW -->
        </form>


 </div>




          </section>
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


 <script>
      $(function(){
        jQuery(function($) 
        {      
          //jquery tabs
          $( "#tabs_clientes" ).tabs(); 
         /*FecAltCup
*/
      });
        $('.datepicker').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});  
        $('#FecAltCup').on('changeDate', function() 
        {
          var FecAltCup=document.getElementById("FecAltCup").value;
          console.log("FecAltCup: "+FecAltCup);
        });
        $('.datepicker2').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});  
        $('#FecUltLec').on('changeDate', function() 
        {
          var FecUltLec=document.getElementById("FecUltLec").value;
          console.log("FecUltLec: "+FecUltLec);
        });
       
        function mayus(e)
        {
          var tecla=e.value;
          var tecla2=tecla.toUpperCase();
        }


      });
    </script>
</div>
</body>
<div id="cargandos_cups" class="loader loader-default"  data-text="Cargando Información del CUPs"></div>
<div id="List_Produc" class="loader loader-default"  data-text="Cargando listado de Productos"></div>

<div id="borrando" class="loader loader-default"  data-text="Eliminando Cliente"></div>
<div id="NumCifCom" class="loader loader-default"  data-text="Comprobando CIF"></div>

</html>
