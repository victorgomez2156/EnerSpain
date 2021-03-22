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

        .file-item{
            background: white;
    height: 35px;
    padding: 10px;
    margin-left: 0;
    font-size: 12px;
    border-bottom: 1px solid gainsboro;
        }

        .file_b{
            position:absolute;
            left:0;
            top:0;
            background:red;
            width:100%;
            height:100%;
            opacity:0;
        }     

        #file-wrap{
            position:relative;
            width:100%;
            padding: 5px;
            display: block;
            border: 2px dashed #ccc;
            margin: 0 auto;
            text-align: center;
            box-sizing:border-box;
            border-radius: 5px;
        }

      
        .file_b{
            position:absolute;
            left:0;
            top:0;
            background:red;
            width:100%;
            height:100%;
            opacity:0;
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
    </style>
<body>
 <div ng-controller="Controlador_Contactos as vm">
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header" ng-show="vm.tContacto_data_modal.CodConCli==undefined">Registro de Contacto del Cliente</h3>
            <h3 class="page-header" ng-show="vm.tContacto_data_modal.CodConCli>0">Actualización de Contacto del Cliente</h3>
            <!--<ol class="breadcrumb">
             <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>             
              <li><i class="fa fa-child"></i>Registro de Contacto</li>
            </ol>-->
          </div>
        </div>
        <!-- Form validations -->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">             
              <div class="panel-body">
                <form class="form-validate" id="form_contacto2" name="form_contacto2" ng-submit="submitFormRegistroContacto($event)">                 
                  
                  <div class="col-12 col-sm-6">
                    <div class="form">                          
                     <div class="form-group">
                     <label class="font-weight-bold nexa-dark" style="color:black;">Nombre <b style="color:red;">(*)</b></label>
                     <input type="text" class="form-control" ng-model="vm.tContacto_data_modal.NomConCli"  maxlength="50"  ng-disabled="vm.no_editable!=undefined"/>  
                     </div>
                     </div>
                  </div>

                  <div class="col-12 col-sm-6">
                    <div class="form">                          
                     <div class="form-group">
                     <label class="font-weight-bold nexa-dark" style="color:black;">Número de Colegiado </label>
                     <input type="text" class="form-control" ng-model="vm.tContacto_data_modal.NumColeCon" maxlength="9" ng-disabled="vm.no_editable!=undefined"/>     
                     </div>
                     </div>
                  </div>

                  <div class="col-12 col-sm-6">
                    <div class="form">                          
                      <div class="form-group">
                        <label class="font-weight-bold nexa-dark" style="color:black;">Número de Documento </label>
                        <input type="text" class="form-control" ng-model="vm.tContacto_data_modal.NIFConCli" maxlength="9" ng-disabled="vm.no_editable!=undefined"/>     
                      </div>
                    </div>
                  </div>

                  <div class="col-12 col-sm-6">
                    <div class="form">                          
                      <div class="form-group">
                        <label class="font-weight-bold nexa-dark" style="color:black;">Cargo <b style="color:red;">(*)</b></label>
                        <input type="text" class="form-control" ng-model="vm.tContacto_data_modal.CarConCli"  maxlength="50"  ng-disabled="vm.no_editable!=undefined"/>     
                      </div>
                   </div>
                  </div>

                  <div class="col-12 col-sm-4">
                    <div class="form">                          
                      <div class="form-group">   
                        <label class="font-weight-bold nexa-dark" style="color:black;">Teléfono Fijo <b style="color:red;">(*)</b></label>          
                        <input type="text" class="form-control" ng-model="vm.tContacto_data_modal.TelFijConCli"  ng-change="vm.validarsinuermoContactos(vm.tContacto_data_modal.TelFijConCli,1)" maxlength="9" ng-disabled="vm.no_editable!=undefined"/>     
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-sm-4">
                    <div class="form">                          
                      <div class="form-group">    
                        <label class="font-weight-bold nexa-dark" style="color:black;">Teléfono Móvil </label>         
                        <input type="text"  class="form-control" ng-model="vm.tContacto_data_modal.TelCelConCli"  ng-change="vm.validarsinuermoContactos(vm.tContacto_data_modal.TelCelConCli,2)" maxlength="9" ng-disabled="vm.no_editable!=undefined"/>     
                      </div>
                    </div>
                  </div>
                  
                  <div class="col-12 col-sm-4">
                    <div class="form">                          
                      <div class="form-group">  
                        <label class="font-weight-bold nexa-dark" style="color:black;">Email <b style="color:red;">(*)</b></label>           
                        <input type="email" class="form-control" ng-model="vm.tContacto_data_modal.EmaConCli"  maxlength="50" ng-disabled="vm.no_editable!=undefined"/>     
                      </div>
                   </div>
                  </div>
                
               
                 
         

                


                  <button class="btn btn-info" type="submit" ng-show="vm.tContacto_data_modal.CodConCli==undefined && vm.no_editable==undefined" ng-disabled="form_contacto2.$invalid">Registrar</button>
                  <button class="btn btn-success" type="submit" ng-show="vm.tContacto_data_modal.CodConCli>0 && vm.no_editable==undefined">Actualizar</button>
                  <a class="btn btn-danger" ng-click="vm.regresar_contacto()">Volver</a>
                  <input type="hidden" class="form-control" ng-model="vm.tContacto_data_modal.CodConCli" readonly /> 
                </form>
              


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
          Diseñado Por <a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2019 - 2021</a>
        </div>
    </div>
  </section>
</div>
  <!-- container section end -->
<script type="text/javascript" src="application/libraries/estilos/js/jquery.validate.min.js"></script>
  <!-- custom form validation script for this page-->
  <script src="application/libraries/estilos/js/form-validation-script.js"></script>
  <!--custome script for all page-->
  <!--script src="application/libraries/estilos/js/scripts.js"></script-->
</body>

<div id="cargando" class="loader loader-default"  data-text="Cargando listado de Comerciales"></div>
<div id="cargando_I" class="loader loader-default"  data-text="Cargando Información del Contacto"></div>

<div id="crear_clientes" class="loader loader-default"  data-text="Creando o Actualizando Comercial"></div>
<div id="Principal" class="loader loader-default"  data-text="Verificando Contacto Principal"></div>

</html>
