<?php /** @package WordPress @subpackage Default_Theme  **/
header("Access-Control-Allow-Origin: *"); 
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
   
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
  
</head>

<body>
 <div ng-controller="Datos_Basicos_Comercializadora as vm">.
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header" ng-show="vm.fdatos.CodCom==undefined">Registrar Comercializadora</h3>
            <h3 class="page-header" ng-show="vm.fdatos.CodCom>0 && vm.validate_info==undefined">Modificar Comercializadora</h3>
            <h3 class="page-header" ng-show="vm.fdatos.CodCom>0 && vm.validate_info!=undefined">Consultando Comercializadora</h3>
          </div>
        </div>
        <!-- Form validations -->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading" style="color:black;">
                <b>Comercializadora</b>
              </header>
              <div class="panel-body">

    <form id="register_form" name="register_form" ng-submit="submitForm($event)"> 
     <div class='row'>              
       <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">CIF <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fdatos.NumCifCom" maxlength="8" readonly ng-disabled="vm.validate_cif==1" placeholder="* N??mero del CIF de la Comercializadora Comercial"/>
       
       </div>
       </div>
       </div>       
       
       <div class="col-12 col-sm-6">
       <div class="form"> 
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;"><i class="fa fa-calendar"></i> Fecha de Inicio <b style="color:red;">(*)</b></label>       
        <input class="form-control selectSimple datepicker" id="FecIniCom" type="text" placeholder="DD/MM/YYYY" ng-change="vm.validar_fecha(3,vm.FecIniCom)" maxlength="10" ng-model="vm.FecIniCom" ng-disabled="vm.validate_info!=undefined">   
        <!--input type="text" id="fecha_pago" class="selectSimple soloValidFecha datepicker" style="width: 100px;height: 37px;border-radius: 5px;  text-align: center;" placeholder="dd-mm-yyyy" ng-model="vm.FecIniCom"--> 
      
       </div>
       </div>
       </div>
       <br><br><br>

       <div class="col-12 col-sm-12">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;"> Raz??n Social <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fdatos.RazSocCom"  placeholder="* Raz??n Social" maxlength="150" ng-disabled="vm.validate_info!=undefined" ng-change="vm.asignar_a_nombre_comercial()"/>       
       </div>
       </div>
       </div>
      <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Nombre de la Comercializadora <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fdatos.NomComCom"  placeholder="* Nombre de la Comercializadora" maxlength="150" ng-disabled="vm.fdatos.misma_razon==false || vm.validate_info!=undefined"/>
       </div>
       </div>
       </div>
      <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Distinto a Raz??n Social</label>
       <input type="checkbox" class="form-control" ng-model="vm.fdatos.misma_razon" ng-disabled="vm.validate_info!=undefined" ng-click="vm.misma_razon(vm.fdatos.misma_razon)"/>       
       </div>
       </div>
       </div> 
          
      <div style="margin-top: 8px;">
       <div align="center"><label class="font-weight-bold nexa-dark" style="color:#6d6e71;"><b>Direcci??n</b></label></div></div>
      
      <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Tipo de V??a <b style="color:red;">(*)</b></label>
       <select class="form-control" id="CodTipVia" name="CodTipVia"  placeholder="* Tipo de V??a" ng-model="vm.fdatos.CodTipVia" ng-disabled="vm.validate_info!=undefined">
         <option ng-repeat="dato in vm.tTiposVias" value="{{dato.CodTipVia}}">{{dato.DesTipVia}} - {{dato.IniTipVia}}</option>                        
        </select>
       </div>
       </div>
       </div>

      <div class="col-12 col-sm-5">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Nombre de la V??a <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fdatos.NomViaDirCom"  ng-change="vm.asignar_domicilio()" placeholder="* Nombre de l V??a" maxlength="30"  ng-disabled="vm.validate_info!=undefined"/>       
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">N??mero de la V??a <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fdatos.NumViaDirCom"  min="1" ng-change="vm.validar_fecha(4,vm.fdatos.NumViaDirCom)" placeholder="* N??mero de la V??a" maxlength="3" ng-disabled="vm.validate_info!=undefined"/>       
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Bloque </label>
       <input type="text" class="form-control" ng-model="vm.fdatos.BloDirCom"  placeholder="* Bloque" maxlength="3" ng-change="vm.asignar_bloq_domicilio()" ng-disabled="vm.validate_info!=undefined"/>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Escalera </label>
       <input type="text" class="form-control" ng-model="vm.fdatos.EscDirCom"  placeholder="* Escalera" ng-change="vm.asignar_esc_domicilio()" maxlength="2" ng-disabled="vm.validate_info!=undefined"/>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Planta </label>
       <input type="text" class="form-control" ng-model="vm.fdatos.PlaDirCom"  placeholder="* Planta" ng-change="vm.asignar_pla_domicilio()" maxlength="2" ng-disabled="vm.validate_info!=undefined"/>
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Puerta </label>
       <input type="text" class="form-control" ng-model="vm.fdatos.PueDirCom"  placeholder="* Puerta" ng-change="vm.asignar_puer_domicilio()" maxlength="4" ng-disabled="vm.validate_info!=undefined"/>
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-4" ng-click="vm.containerClicked()">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">C??digo Postal </label>
       <input type="text" class="form-control" ng-model="vm.fdatos.ZonPos" placeholder="* Zona Postal" ng-disabled="vm.validate_info!=undefined" ng-click='vm.searchboxClicked($event)' ng-keyup='vm.LocalidadCodigoPostal()'/>
       <ul id='searchResult'>
          <li ng-click='vm.setValue($index,$event,result,1)' ng-repeat="result in vm.searchResult" >
          {{ result.DesPro }}  / {{ result.DesLoc }} / {{ result.CPLoc }} 
          </li>
        </ul>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Provincia <b style="color:red;">(*)</b></label>
        <select class="form-control" id="CodPro" name="CodPro"  ng-model="vm.fdatos.CodPro" ng-change="vm.SearchLocalidades()" ng-disabled="vm.validate_info!=undefined">
        <option ng-repeat="dato in vm.TProvincias" value="{{dato.CodPro}}">{{dato.DesPro}}</option>                          
        </select>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Localidad <b style="color:red;">(*)</b></label>
       <select class="form-control" id="CodLoc" name="CodLoc"  ng-model="vm.fdatos.CodLoc" ng-disabled="vm.validate_info!=undefined || vm.fdatos.CodPro==undefined  ">
        <option ng-repeat="dato in vm.TLocalidadesfiltrada" value="{{dato.CodLoc}}">{{dato.DesLoc}}</option>                         
        </select>
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Tel??fono Fijo <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fdatos.TelFijCom" ng-change="vm.validar_fecha(5,vm.fdatos.TelFijCom)" placeholder="* Tel??fono Fijo" maxlength="9"  ng-disabled="vm.validate_info!=undefined"/>       
       </div>
       </div>
       </div>
       
       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Correo El??ctronico <b style="color:red;">(*)</b></label>
       <input type="email" class="form-control" ng-model="vm.fdatos.EmaCom"  placeholder="* Correo El??ctronico" maxlength="150"  ng-disabled="vm.validate_info!=undefined"/>       
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">P??gina Web </label>
       <input type="url" class="form-control" ng-model="vm.fdatos.PagWebCom"  placeholder="* P??gina Web" maxlength="150"  ng-disabled="vm.validate_info!=undefined"/>       
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Persona de Contacto <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fdatos.NomConCom"  placeholder="* Persona de Contacto" maxlength="150"  ng-disabled="vm.validate_info!=undefined"/>       
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Cargo <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.fdatos.CarConCom"  placeholder="* Cargo de la Persona" maxlength="150"  ng-disabled="vm.validate_info!=undefined"/>       
       </div>
       </div>
       </div>
         <div style="margin-top: 8px;">
       <div align="center"><label class="font-weight-bold nexa-dark" style="color:#6d6e71;"><b>Tipos de Suministro</b></label></div></div>

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">SUMINISTRO EL??CTRICO</label>
       <input type="checkbox" class="form-control" ng-model="vm.fdatos.SerEle"  ng-disabled="vm.validate_info!=undefined"/>       
       </div>
       </div>
       </div>
       
       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">SUMINISTRO GAS</label>
       <input type="checkbox" class="form-control" ng-model="vm.fdatos.SerGas"  ng-disabled="vm.validate_info!=undefined"/>       
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">SERVICIO ADICIONALES</label>
       <input type="checkbox" class="form-control" ng-model="vm.fdatos.SerEsp"  ng-disabled="vm.validate_info!=undefined"/>        
       </div>
       </div>
       </div>
      
      <div class="form">                          
       <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black; padding-left:15px">Fotocopia del Contrato <a title='Descargar Documentos' ng-show="vm.fdatos.DocConCom!=null && vm.fdatos.CodCom>0" href="{{vm.fdatos.DocConCom}}" download class="btn btn-info btn-icon mg-r-5"><div><i class="fa fa-download" style="color:white;"></i></div></a>   </label>  

         <div id="file-wrap">
            <p>Presione para adjuntar el fichero o <strong>arrastrar</strong> el fichero y <strong>soltarlo</strong> aqu??</p>                       
            <input type="file" id="file" class="file_b" uploader-model="file" ng-disabled="vm.validate_info!=undefined" draggable="true">
            <div id="filenameDocCont"></div>                       
          </div>
    <script>         
      $('#file').on('change', function() 
      {   
        const $Archivo_DocCont = document.querySelector("#file");       
        let Archivo_DocCont = $Archivo_DocCont.files;                      
        filenameDocCont = '<i class="fa fa-file"> '+$Archivo_DocCont.files[0].name+'</i>';
          $('#filenameDocCont').html(filenameDocCont);
      });     
</script>
       </div>
       </div>


       <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Fecha de Contrato</label>
       <input type="text" class="form-control selectSimple datepicker2" ng-model="vm.FecConCom" id="FecConCom"  ng-change="vm.validar_fecha(1,vm.FecConCom)" placeholder="DD/MM/YYYY" ng-disabled="vm.validate_info!=undefined" maxlength="10" />
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Duraci??n</label>
       <input type="text" class="form-control" ng-model="vm.fdatos.DurConCom" readonly  placeholder=" Duraci??n del Contrato" maxlength="11" ng-disabled="vm.validate_info!=undefined"/>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Fecha de Vencimiento</label>
       <input type="text" class="form-control selectSimple datepicker3" ng-model="vm.FecVenConCom" id="FecVenConCom" ng-change="vm.validar_fecha(2,vm.FecVenConCom)" placeholder="DD/MM/YYYY" ng-disabled="vm.validate_info!=undefined" maxlength="10"/>
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Renovaci??n Autom??tica</label>
       <input type="checkbox" class="form-control" ng-model="vm.fdatos.RenAutConCom" ng-disabled="vm.validate_info!=undefined"/>
       </div>
       </div>
       </div>
     
       <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:black;padding-left:15px">Comentarios</label>
        <textarea class="form-control" style="display: inline-block;"  id="ObsCom" name="ObsCom" type="text" minlength="1" maxlength="200" rows="5"  ng-model="vm.fdatos.ObsCom" ng-disabled="vm.validate_info!=undefined"></textarea>
        <input class="form-control" name="CodCom" type="hidden" ng-model="vm.fdatos.CodCom" readonly/>
       </div>
       </div>
      
         <div class="form-group" >
          <div class="col-12 col-sm-6">
            <button class="btn btn-info" type="submit" ng-show="vm.fdatos.CodCom==undefined||vm.fdatos.CodCom==null||vm.fdatos.CodCom==''" ng-disabled="vm.disabled_button==1"> Guardar</button>
            <button class="btn btn-success" type="submit" ng-show="vm.fdatos.CodCom>0 && vm.validate_info==undefined" ng-disabled="vm.validate_info!=undefined || vm.disabled_button==1" > Actualizar</button>
            
            <!--button class="btn btn-danger" type="button"  ng-click="vm.borrar()" ng-show="vm.fdatos.CodCom>0 && vm.validate_info==undefined" ng-disabled="vm.Nivel==3 || vm.validate_info!=undefined">BORRAR</button-->

            <button class="btn btn-primary" type="button" style="margin-top: 10px;" ng-click="vm.regresar()">Volver</button>
          </div>
        </div>
         </div><!--FINAL ROW -->
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
          Dise??ado por <a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2019 - 2021</a>
        </div>
    </div>
  </section>

<div id="buscando" class="loader loader-default"  data-text="Cargando Informaci??n"></div>
<div id="Guardando" class="loader loader-default"  data-text="Registrando Comercializadora"></div>
<div id="Actualizando" class="loader loader-default"  data-text="Actualizando Comercializadora"></div>

</div>
  <!-- container section end -->

   <!--script>
      $(function(){
        'use strict'

        // Input Masks
        $('#FecIniAct').mask('99/99/9999');
        jQuery(function($) 
        {      
          //jquery tabs
          $( "#tabs_clientes" ).tabs(); 
            $('.datepicker').datepicker({
          autoclose: true,
          todayHighlight: true,
          maxDate: "<?php echo date("m/d/Y")?>"
        })
      });

        function mayus(e)
        {
          var tecla=e.value;
          var tecla2=tecla.toUpperCase();
        }


      });
    </script-->
  
    <script>

  $('.datepicker').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true}); 
  $('.datepicker2').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true}); 
  $('.datepicker3').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true}); 

  $('#FecIniCom').on('changeDate', function() 
  {
     var FecIniCom=document.getElementById("FecIniCom").value;
     console.log("FecIniCom: "+FecIniCom);
  });
  $('#FecConCom').on('changeDate', function() 
  {
     var FecConCom=document.getElementById("FecConCom").value;
     console.log("FecConCom: "+FecConCom);
  });
  $('#FecVenConCom').on('changeDate', function() 
  {
     var FecVenConCom=document.getElementById("FecVenConCom").value;
     console.log("FecVenConCom: "+FecVenConCom);
  });
jQuery('.soloNumeros').keypress(function (tecla) {
  if ((tecla.charCode == 46 )) return true;
  if ((tecla.charCode < 48 || tecla.charCode > 57)) return false;
  
});

jQuery('.soloValidFecha').keypress(function (tecla) {
  
  if ((tecla.charCode == 45 )) return true;
  if ((tecla.charCode < 48 || tecla.charCode > 57)) return false;
  
});

</script>
</body>



</html>