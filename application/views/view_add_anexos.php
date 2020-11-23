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
	background: inherit ;
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
 <div ng-controller="Controlador_Anexos as vm">
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header" ng-show="vm.anexos.CodAnePro==undefined">Registro de Anexo</h3>
            <h3 class="page-header" ng-show="vm.anexos.CodAnePro>0&&vm.validate_info_anexos!=undefined">Cosultando Anexo</h3>
            <h3 class="page-header" ng-show="vm.anexos.CodAnePro>0&&vm.validate_info_anexos==undefined">Actualizando Anexo</h3>
            <!--<ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="#/Dashboard"> Dashboard</a></li>         
              <li><i class="fa fa-bullseye"></i> Registro de Anexos</li>
            </ol>-->
          </div>
        </div>
        <!-- Form validations -->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
             
              <div class="panel-body">


<form id="register_formAnex" name="register_formAnex" ng-submit="submitFormAnexos($event)"> 
     <div class='row'>              
       <div class="col-12 col-sm-12">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Comercializadora <b style="color:red;">(*)</b></label>
       <select class="form-control" id="CodTProComAnex" name="CodTProComAnex" ng-model="vm.anexos.CodTProCom" ng-change="vm.filtrar_productos_com()" ng-disabled="vm.validate_info_anexos!=undefined">
         <option ng-repeat="dato in vm.Tcomercializadoras" value="{{dato.CodCom}}">{{dato.RazSocCom}} - {{dato.NumCifCom}}</option>                        
        </select>
       
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-12">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Producto <b style="color:red;">(*)</b></label>
       <select class="form-control" id="CodProducAnex" name="CodPro" ng-model="vm.anexos.CodPro" ng-disabled="vm.anexos.CodTProCom==undefined||vm.validate_info_anexos!=undefined ">
         <option ng-repeat="dato in vm.TProductosActivosFiltrados" value="{{dato.CodPro}}">{{dato.DesPro}}</option>                        
        </select>
       
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Nombre del Anexo <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.anexos.DesAnePro" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Nombre del Anexo" maxlength="50" ng-disabled="vm.validate_info_anexos!=undefined"/>       
       </div>
       </div>
       </div>
      
      <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Fecha de Inicio <b style="color:red;">DD/MM/YYYY</b></label>
       <input type="text" class="form-control datepicker" ng-model="vm.FecIniAneA" id="FecIniAneA" ng-change="vm.validarFecIni(vm.FecIniAneA)" placeholder="* DD/MM/YYYY" maxlength="10" ng-disabled="vm.validate_info_anexos!=undefined"/>
       </div>
       </div>
       </div>

      <div style="margin-top: 8px;">
       <div align="center"><label class="font-weight-bold nexa-dark" style="color:#6d6e71;"><b>Tipos de Suministro</b></label></div></div>
      
      <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">ELÉCTRICO</label>
        <input type="checkbox" ng-model="vm.anexos.SerEle" ng-click="vm.limpiar_Servicio_Electrico(vm.anexos.SerEle)" ng-disabled="vm.validate_info_anexos!=undefined"/>
       </div>
       </div>
       </div>

      <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">GAS</label>
        <input type="checkbox" ng-model="vm.anexos.SerGas" ng-click="vm.limpiar_Servicio_Gas(vm.anexos.SerGas)" ng-disabled="vm.validate_info_anexos!=undefined"/>
       </div>
       </div>
       </div>
        <div style="margin-top: 8px;">
       <div align="center"><label class="font-weight-bold nexa-dark" style="color:#6d6e71;"><b>Tipo de Precio</b></label></div></div>
       <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">FIJO</label>
        <input type="checkbox" ng-model="vm.anexos.Fijo" ng-disabled="vm.validate_info_anexos!=undefined"/>
       </div>
       </div>
       </div>

      <div class="col-12 col-sm-6">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">INDEXADO</label>
        <input type="checkbox" ng-model="vm.anexos.Indexado" ng-disabled="vm.validate_info_anexos!=undefined"/>
       </div>
       </div>
       </div>



      <div style="margin-top: 8px;">
       <div align="center"><label class="font-weight-bold nexa-dark" style="color:#6d6e71;"><b>Tarifas Suministro Eléctrico</b></label></div></div>
        
        <div class="col-lg-6">
                <section class="panel">
                  <header class="panel-heading">
                   <div align="center"> <b>Baja Tensión</b> </div>
                  </header>
                   <div class="panel-body">
                    
                    <div ng-repeat="opcion_tension_baja in vm.Tarifa_Elec_Baja">                      
                        
                        <button type="button"  ng-click="vm.agregar_tarifa_elec_baja($index,opcion_tension_baja.CodTarEle,opcion_tension_baja)" title="Agregar {{opcion_tension_baja.NomTarEle}}" ng-disabled="vm.validate_info==1||vm.disabled_all_baja==1||vm.anexos.SerEle==false ||vm.validate_info_anexos!=undefined" ng-show="!vm.select_tarifa_Elec_Baj[opcion_tension_baja.CodTarEle]"><i class="fa fa fa-square-o" title="Agregar {{tari_gas.NomTarGas}}" style="color:black;"></i></button>                        

                        <button type="button" ng-show="vm.select_tarifa_Elec_Baj[opcion_tension_baja.CodTarEle]" ng-click="vm.quitar_tarifa_elec_baja($index,opcion_tension_baja.CodTarEle,opcion_tension_baja)" ng-disabled="vm.disabled_all_baja==1||vm.anexos.AggAllBaj==true||vm.validate_info_anexos!=undefined"><i class="fa fa fa-check-circle" title="Quitar {{opcion_tension_baja.NomTarEle}}" style="color:green;"></i></button>

                        <label class="font-weight-bold nexa-dark" style="color:black;">{{opcion_tension_baja.NomTarEle}}</label>
                    </div>
                    

                    <div align="center">
                      <label>
                        <input name="sample-checkbox-01" id="checkbox-016" type="checkbox" ng-click="vm.agregar_todas_baja_tension(vm.Tarifa_Elec_Baja,vm.anexos.AggAllBaj)" ng-disabled="vm.validate_info==1||vm.anexos.SerEle==false||vm.validate_info_anexos!=undefined" ng-model="vm.anexos.AggAllBaj"/> <b><i class="fa fa-check-circle"></i> Todas</b>
                      </label>
                    </div>
                  </div>
                </section> 
              </div>

              <div class="col-lg-6">
                <section class="panel">
                  <header class="panel-heading">
                   <div align="center"> <b>Alta Tensión</b> </div>
                  </header>
                   <div class="panel-body">
                    <div ng-repeat="opcion_tension_alta in vm.Tarifa_Elec_Alt"> 

                        <button type="button" ng-disabled="vm.validate_info==1||vm.disabled_all_alta==1||vm.anexos.SerEle==false||vm.validate_info_anexos!=undefined " ng-show="!vm.select_tarifa_Elec_Alt[opcion_tension_alta.CodTarEle]" ng-click="vm.agregar_tarifa_elec_alta($index,opcion_tension_alta.CodTarEle,opcion_tension_alta)" title="Agregar {{opcion_tension_alta.NomTarEle}}"><i class="fa fa fa-square-o" title="Agregar {{tari_gas.NomTarGas}}" style="color:black;"></i></button>
                        

                        <button type="button" ng-show="vm.select_tarifa_Elec_Alt[opcion_tension_alta.CodTarEle]" ng-click="vm.quitar_tarifa_elec_alta($index,opcion_tension_alta.CodTarEle,opcion_tension_alta)" ng-disabled="vm.disabled_all_baja==1||vm.anexos.AggAllBaj==true||vm.validate_info_anexos!=undefined"><i class="fa fa fa-check-circle" title="Quitar {{opcion_tension_alta.NomTarEle}}" style="color:green;"></i></button>



                        <label class="font-weight-bold nexa-dark" style="color:black;">{{opcion_tension_alta.NomTarEle}}</label>
                    



                    </div>
                     <div align="center">
                    <label>
                        <input name="sample-checkbox-01" id="checkbox-014" type="checkbox" ng-disabled="vm.validate_info==1||vm.anexos.SerEle==false||vm.validate_info_anexos!=undefined" ng-model="vm.anexos.AggAllAlt" ng-click="vm.agregar_todas_alta_tension(vm.Tarifa_Elec_Alt,vm.anexos.AggAllAlt)"/> <b><i class="fa fa-check-circle"></i> Todas</b>
                      </label></div>
                  </div>
                </section> 
              </div>



      <div style="margin-top: 12px;">
      <div align="center"><label class="font-weight-bold nexa-dark" style="color:#6d6e71;"><b>Tarifas Suministro de Gas</b></label></div></div>
       
       <div class="col-12 col-sm-3" ng-repeat="tari_gas in vm.Tarifa_Gas_Anexos">
       <div class="form">                          
       <div class="form-group">

       <button type="button" name="tarifa_gas" ng-show="!vm.select_tarifa_gas[tari_gas.CodTarGas]" ng-click="vm.agregar_tarifa_gas_individual($index,tari_gas,tari_gas.CodTarGas)" ng-disabled="vm.validate_info==1||vm.disabled_all==1||vm.anexos.SerGas==false||vm.validate_info_anexos!=undefined"><i class="fa fa fa-square-o" title="Agregar {{tari_gas.NomTarGas}}" style="color:black;"></i></button>   
       
       <button type="button" ng-show="vm.select_tarifa_gas[tari_gas.CodTarGas]" ng-click="vm.quitar_tarifa_gas($index,tari_gas.CodTarGas,tari_gas)" ng-disabled="vm.disabled_all==1||vm.validate_info_anexos!=undefined"><i class="fa fa fa-check-circle" title="Quitar {{tari_gas.NomTarGas}}" style="color:green;"></i></button>
       <label class="font-weight-bold nexa-dark" style="color:black;"><b>{{tari_gas.NomTarGas}}</b></label> 

       </div>
       </div>
       </div>
        
        <div align="center">
                    <label class="label_check" for="checkbox-01">
                        <input name="sample-checkbox-01" id="checkbox-015" type="checkbox" ng-model="vm.Todas_Gas" ng-click="vm.agregar_todas_detalle(vm.Todas_Gas)" ng-disabled="vm.validate_info==1||vm.anexos.SerGas==false||vm.validate_info_anexos!=undefined" /> <b><i class="fa fa-check-circle"></i> Todas</b>
                      </label></div>


       <div class="col-12 col-sm-12">
      <div class="form">                          
        <div class="form-group"><br>
           <label class="font-weight-bold nexa-dark" style="color:black;">PDF del Anexo <a title='Descargar Documento' ng-show="vm.anexos.DocAnePro!=null && vm.anexos.CodAnePro>0" href="{{vm.anexos.DocAnePro}}" download class="btn btn-info btn-icon mg-r-5"><div><i class="fa fa-download" style="color:white;"></i></div></a></label>         
          
          <!--input type="file" id="file_anexo"  accept="*/*" class="form-control btn-info"  uploadanexo-model="file_anexo" ng-disabled="vm.validate_info==1||vm.validate_info_anexos!=undefined"-->
        
 <div id="file-wrap">
            <p>Presione para adjuntar el fichero o <strong>arrastrar</strong> el fichero y <strong>soltar</strong> aquí</p>                       
            <input  type="file" id="file_anexo" class="file_b" uploadanexo-model="file_anexo" ng-disabled="vm.validate_info==1||vm.validate_info_anexos!=undefined" draggable="true">
            <div id="filenameDocAnexo"></div>                       
          </div>
        </div>
      </div>
</div>

<script>
      $('#file_anexo').on('change', function() 
      {  
        const $Archivo_DocAne = document.querySelector("#file_anexo");         
        let Archivo_DocAne= $Archivo_DocAne.files;                      
        filenameDocAnexo = '<i class="fa fa-file"> '+$Archivo_DocAne.files[0].name+'</i>'; //$Archivo_DocPod.files[0].name;
          $('#filenameDocAnexo').html(filenameDocAnexo);
      });
</script>

      <div class="col-12 col-sm-12">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Tipo de Comisión <b style="color:red;">(*)</b></label>
       <select class="form-control" id="CodTipCom1" name="CodTipCom" ng-model="vm.anexos.CodTipCom" ng-disabled="vm.validate_info_anexos!=undefined">
         <option ng-repeat="dato in vm.Tipos_Comision" value="{{dato.CodTipCom}}">{{dato.DesTipCom}}</option>                        
        </select>
       
       </div>
       </div>
       </div>


      <div class="form">                          
       <div class="form-group">
        <label class="font-weight-bold nexa-dark" style="color:black;">Comentarios</label>
        <textarea class="form-control" style="display: inline-block;" onkeyup="this.value=this.value.toUpperCase();" id="ObsAnePro" name="ObsAnePro" type="text" minlength="1" maxlength="200" rows="5"  ng-model="vm.anexos.ObsAnePro" ng-disabled="vm.validate_info_anexos!=undefined"></textarea>
        
       </div>
       </div>    
      <input class="form-control" id="CodAnePro" name="CodAnePro" type="hidden" ng-model="vm.anexos.CodAnePro" readonly/>
         <div class="form-group" >
          <div class="col-12 col-sm-6">
            <button class="btn btn-info" type="submit" ng-show="vm.anexos.CodAnePro==undefined||vm.anexos.CodAnePro==null||vm.anexos.CodAnePro==''" ng-disabled="vm.disabled_button==1">Grabar</button>
            <button class="btn btn-success" type="submit" ng-show="vm.anexos.CodAnePro>0 && vm.validate_info_anexos==undefined" ng-disabled="vm.validate_info_anexos!=undefined">Actualizar</button>            
            <button class="btn btn-warning" type="button"  ng-click="vm.limpiar_anexo()" ng-show="vm.anexos.CodAnePro==undefined||vm.anexos.CodAnePro==null||vm.anexos.CodAnePro==''">Limpiar</button>
            <button class="btn btn-primary" type="button" style="margin-top: 10px;" ng-click="vm.regresar_anexos()">Volver</button>
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
          Diseñado por <a href="https://somostuwebmaster.es/" target="_black">SomosTuWebMaster.es - 2020</a>
        </div>
    </div>
  </section>
</div>
  <!-- container section end -->

<script>

  $('.datepicker').datepicker({format: 'dd/mm/yyyy',autoclose:true,todayHighlight: true});   

  $('#FecIniAneA').on('changeDate', function() 
  {
     var FecIniAneA=document.getElementById("FecIniAneA").value;
     console.log("FecIniAneA: "+FecIniAneA);
  });

</script>
<script type="text/javascript" src="application/libraries/estilos/js/jquery.validate.min.js"></script>
  <!-- custom form validation script for this page-->
  <script src="application/libraries/estilos/js/form-validation-script.js"></script>
  <!--custome script for all page-->
  <!--script src="application/libraries/estilos/js/scripts.js"></script-->
</body>
<div id="Guardando" class="loader loader-default"  data-text="Grabando Anexo, por favor espere ..."></div>
<div id="Actualizando" class="loader loader-default"  data-text="Actualizando Anexo, por favor espere ..."></div>
<div id="buscando" class="loader loader-default"  data-text="'Cargando listado de Anexos, por favor espere ...'"></div>
</html>
