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
 <div ng-controller="Controlador_Productos as vm">
 <!--main content start-->
    <section id="main-content">
      <!--wrapper start-->
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <!--<h3 class="page-header">Datos Básicos del Producto</h3>-->
            <h3 class="page-header" ng-show="vm.productos.CodTPro==undefined">Registrar Producto</h3>
            <h3 class="page-header" ng-show="vm.productos.CodTPro>0&&vm.validate_info_productos==undefined">Actualizar Producto </h3>
            <h3 class="page-header" ng-show="vm.productos.CodTPro>0&&vm.validate_info_productos!=undefined">Consultando Producto</h3>
            <!-- <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="#/Dashboard"> Dashboard</a></li>           
              <li><i class="fa fa-briefcase"></i> Registro de Productos</li>
            </ol>-->
          </div>
        </div>
        <!-- page start-->
        <div class="row">
          <div class="col-lg-12">
            <!--panel start-->
            <section class="panel">
 <div class="panel-body"> 



  <form id="register_formProd" name="register_formProd" ng-submit="submitFormProductos($event)"> 
     <div class='row'>              
       <div class="col-12 col-sm-12">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Comercializadora <b style="color:red;">(*)</b></label>
       <select class="form-control" id="CodTProCom" name="CodTProCom" ng-model="vm.productos.CodTProCom" ng-disabled="vm.validate_info_productos!=undefined">
         <option ng-repeat="dato in vm.TProComercializadoras" value="{{dato.CodCom}}">{{dato.RazSocCom}} - {{dato.NumCifCom}}</option>                        
        </select>
       
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Nombre del Producto <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.productos.DesPro" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Nombre del Producto" maxlength="50" ng-disabled="vm.validate_info_productos!=undefined"/>       
       </div>
       </div>
       </div>
      
      <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Fecha de Inicio <b style="color:red;">DD/MM/YYYY</b></label>
       <input type="text" class="form-control datepicker" id="FecIniPro" name="FecIniPro" ng-model="vm.FecIniPro" placeholder="* DD/MM/YYYY" maxlength="10" ng-change="vm.validar_fecha(vm.FecIniPro)" ng-disabled="vm.validate_info_productos!=undefined"/>
       </div>
       </div>
       </div>

      <div style="margin-top: 8px;">
       <div align="center"><label class="font-weight-bold nexa-dark" style="color:#6d6e71;"><b>Tipos de Suministro</b></label></div></div>
      
      <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">GAS </label>
        <input type="checkbox" ng-model="vm.productos.SerGas" ng-disabled="vm.validate_info_productos!=undefined"/>
       </div>
       </div>
       </div>
      <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">ELÉCTRICO </label>
        <input type="checkbox" ng-model="vm.productos.SerEle" ng-disabled="vm.validate_info_productos!=undefined"/>
       </div>
       </div>
       </div>

      <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:black;">Comentarios</label>
        <textarea class="form-control" style="display: inline-block;" onkeyup="this.value=this.value.toUpperCase();" id="ObsPro" name="ObsPro" type="text" minlength="1" maxlength="200" rows="5"  ng-model="vm.productos.ObsPro" ng-disabled="vm.validate_info_productos!=undefined"></textarea>
        
       </div>
       </div>    
      <input class="form-control" id="CodTPro" name="CodTPro" type="hidden" ng-model="vm.productos.CodTPro" readonly/>
         <div class="form-group" >
          <div class="col-12 col-sm-6">
            <button class="btn btn-info" type="submit" ng-show="vm.productos.CodTPro==undefined && vm.validate_info_productos==undefined||vm.productos.CodTPro==null&& vm.validate_info_productos==undefined||vm.productos.CodTPro==''&& vm.validate_info_productos==undefined" ng-disabled="vm.disabled_button==1">Grabar</button>
            <button class="btn btn-success" type="submit" ng-show="vm.productos.CodTPro>0 && vm.validate_info_productos==undefined" ng-disabled="vm.validate_info_productos!=undefined">Actualizar</button>            
            <button class="btn btn-warning" type="button" ng-show="vm.validate_info_productos==undefined && vm.productos.CodTPro==undefined" ng-click="vm.limpiar_productos()">Limpiar</button>
            <button class="btn btn-primary" type="button" style="margin-top: 10px;" ng-click="vm.regresar_productos()">Volver</button>
          </div>
        </div>
         </div><!--FINAL ROW -->
        </form>

        <script>

  $('.datepicker').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});
  $('#FecIniPro').on('changeDate', function() 
  {
     var FecIniPro=document.getElementById("FecIniPro").value;
     console.log("FecIniPro: "+FecIniPro);
  });

</script>

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
          Diseñador Por <a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2020</a>
        </div>
    </div>
  </section>

<div id="Guardando" class="loader loader-default"  data-text="Registrando Producto, por favor espere ..."></div>
<div id="Actualizando" class="loader loader-default"  data-text="Actualizando Producto, por favor espere ..."></div>
<div id="carganto_servicio" class="loader loader-default"  data-text="Cargando información, por favor espere ..."></div>
<div id="List_Produc" class="loader loader-default"  data-text="Cargando Listado de Productos, por favor espere ..."></div>

</div>
</body>


</html>
