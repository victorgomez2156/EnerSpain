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
</style>

<style>

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
    </style>
<body>
 <div ng-controller="Controlador_Documentos as vm">
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header" ng-show="vm.fagregar_documentos.CodTipDocAI==undefined">Agregando Documento</h3>
            <h3 class="page-header" ng-show="vm.fagregar_documentos.CodTipDocAI>0">Modificando Documento</h3>
            <!--<ol class="breadcrumb">
             <li><i class="fa fa-home"></i><a href="#/Dashboard">Dashboard</a></li>             
              <li><i class="fa fa-file"></i>Registro de Documentos</li>
            </ol>-->
          </div>
        </div>
        <!-- Form validations -->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
             
              <div class="panel-body">


 <form class="form-validate" id="form_documentos" name="form_documentos" ng-submit="submitFormRegistroDocumentos($event)">                 
      
      <div class="col-12 col-sm-12" ng-click="vm.containerClicked()">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Clientes {{vm.fagregar_documentos.CodCli}}<b style="color:red;">(*)</b></label>
       
       <input type="text" class="form-control" ng-model="vm.NumCifCliSearch" placeholder="* Introduzca CIF" ng-keyup='  vm.fetchClientes(2)' ng-click='vm.searchboxClicked($event)' ng-disabled="vm.restringir_cliente_doc==1||vm.no_editable_doc==1"/>
          <ul id='searchResult'>
            <li ng-click='vm.setValue($index,$event,result,2)' ng-repeat="result in vm.searchResult" >
            {{ result.CodCli }},  {{ result.NumCifCli }} - {{ result.RazSocCli }} 
            </li>
          </ul> 
        <input type="hidden" name="CodCli" id="CodCli" ng-model="vm.fagregar_documentos.CodCli" class="form-control">
       


       <!--select class="form-control" id="CodCliDoc" name="CodCli" ng-disabled="vm.restringir_cliente_doc==1||vm.no_editable_doc==1" ng-model="vm.fagregar_documentos.CodCli"> 
          <option ng-repeat="dato_act in vm.Tclientes" required value="{{dato_act.CodCli}}">{{dato_act.NumCifCli}} - {{dato_act.RazSocCli}}</option>                          
        </select-->



       </div>
       </div>
       </div>
           <div class="col-12 col-sm-12">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Tipo Documento</label>
             <select class="form-control" id="CodTipDoc" required name="CodTipDoc" ng-model="vm.fagregar_documentos.CodTipDoc">
               <option ng-repeat="dato in vm.tListDocumentos" value="{{dato.CodTipDoc}}">{{dato.DesTipDoc}}</option>
            </select>     
             </div>
             </div>
          </div>          

          <div class="col-12 col-sm-12">
            <div class="form">                          
             <div class="form-group">
              <label class="font-weight-bold nexa-dark" style="color:black;">Fotocopia del Documento: <a title='Descargar Documento' ng-show="vm.fagregar_documentos.ArcDoc!=null && vm.fagregar_documentos.CodTipDocAI>0" href="{{vm.fagregar_documentos.ArcDoc}}" download class="btn btn-info btn-icon mg-r-5"><div><i class="fa fa-download" style="color:white;"></i></div></a></label> 

            <div id="file-wrap">
            <p>Presione para adjuntar el fichero o <strong>arrastrar</strong> el fichero y <strong>soltar</strong> aquí</p>                       
            <input type="file" id="DocCliDoc" name="DocCliDoc" class="file_b" uploader-model="DocCliDoc" draggable="true">
            <div id="filenameDocCli"></div>                       
          </div>
    <script>

      
      $('#DocCliDoc').on('change', function() 
      {          
        const $Archivo_DocCli1 = document.querySelector("#DocCliDoc");
        //console.log($Archivo_DocCli1);
        let Archivo_DocCli1 = $Archivo_DocCli1.files;                      
        filenameDocCli = '<i class="fa fa-file"> '+$Archivo_DocCli1.files[0].name+'</i>';
          $('#filenameDocCli').html(filenameDocCli);
      });
     
</script>            
             <!--input type="file" class="form-control" accept="application/pdf" id="DocCliDoc" name="DocCliDoc" uploader-model="DocCliDoc"/-->     
             </div>
             </div>
          </div>

          <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Tiene Vencimiento: </label>
             <input type="radio" ng-model="vm.fagregar_documentos.TieVen" value="1" /> 
             <label class="font-weight-bold nexa-dark" style="color:black;">SI</label>
             <input type="radio" ng-model="vm.fagregar_documentos.TieVen" value="2" ng-click="vm.limpiar_fecha_no()" /> 
             <label class="font-weight-bold nexa-dark" style="color:black;">NO</label>    
             </div>
             </div>
          </div>

          <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Fecha Vencimiento <b style="color:red;">DD/MM/YYYY</b>  </label>
             <input type="text" class="form-control datepicker" ng-model="vm.FecVenDocAco" name="FecVenDocAco" id="FecVenDocAco" ng-change="vm.validarfechadocumento(vm.FecVenDocAco)" maxlength="10" ng-disabled="vm.fagregar_documentos.TieVen!=1" />     
             </div>
             </div>
          </div>
          <div cla
          ss="col-12 col-sm-12">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Observación</label>
             <textarea class="form-control" rows="5" ng-model="vm.fagregar_documentos.ObsDoc"></textarea>   
             </div>
             </div>
          </div>
           
          
                  
             <button class="btn btn-info" type="submit" ng-disabled="form_documentos.$invalid" ng-show="vm.fagregar_documentos.CodTipDocAI==undefined">REGISTRAR</button>
             <button class="btn btn-success" type="submit" ng-disabled="form_documentos.$invalid" ng-show="vm.fagregar_documentos.CodTipDocAI>0">ACTUALIZAR</button>
              <a class="btn btn-danger" ng-click="vm.regresar_documentos()">Volver</a>
        </form>
        <input type="hidden" class="form-control" ng-model="vm.fagregar_documentos.CodTipDocAI" readonly />



<script>
  $('.datepicker').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});   

  $('#FecVenDocAco').on('changeDate', function() 
  {
     var FecVenDocAco=document.getElementById("FecVenDocAco").value;
     console.log("FecVenDocAco: "+FecVenDocAco);
  });
</script>



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
          Designed by <a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2019</a>
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
<div id="buscando" class="loader loader-default"  data-text="Cargando Información del Documento"></div>

<div id="crear_clientes" class="loader loader-default"  data-text="Creando o Actualizando Comercial"></div>

<div id="Actualizando" class="loader loader-default"  data-text="Actualizando Documento"></div>
<div id="Guardando" class="loader loader-default"  data-text="Creando Documento"></div>

</html>
