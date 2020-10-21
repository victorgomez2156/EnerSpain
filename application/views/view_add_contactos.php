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
           <input type="hidden" class="form-control" ng-model="vm.tContacto_data_modal.CodConCli" readonly />          
      

      <div class="col-12 col-sm-10" ng-click="vm.containerClicked()">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Clientes {{vm.tContacto_data_modal.CodCli}} <b style="color:red;">(*)</b></label>
       

       <input type="text" class="form-control" ng-model="vm.CodCliContacto" placeholder="* Introduzca CIF" ng-keyup='  vm.fetchClientes()' ng-click='vm.searchboxClicked($event)' ng-disabled="vm.restringir_cliente_cont==1||vm.no_editable!=undefined"/>
          <ul id='searchResult'>
            <li ng-click='vm.setValue($index,$event,result)' ng-repeat="result in vm.searchResult" >
            {{ result.CodCli }}, {{ result.NumCifCli }} - {{ result.RazSocCli }} 
            </li>
          </ul> 
        <input type="hidden" name="CodCli" id="CodCli" ng-model="vm.tContacto_data_modal.CodCli" class="form-control">
      
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-2">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Es Principal </label>             
             <input type="checkbox" class="form-control" ng-model="vm.tContacto_data_modal.ConPrin" ng-click="vm.ComprobarContactoPrincipal(vm.tContacto_data_modal.ConPrin)" ng-disabled="vm.no_editable!=undefined || vm.tContacto_data_modal.CodCli==undefined"/> 

             </div>
             </div>
          </div>

    <div ng-show="vm.tContacto_data_modal.CodCli!=undefined">
      <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Tipo de Via <b style="color:red;">(*)</b></label>
       <select class="form-control" id="CodTipViaSoc" name="CodTipViaSoc"  placeholder="* Tipo de Via" ng-model="vm.tContacto_data_modal.CodTipViaSoc" ng-disabled="vm.validate_info!=undefined">
         <option ng-repeat="dato in vm.tTiposVias" value="{{dato.CodTipVia}}">{{dato.DesTipVia}} - {{dato.IniTipVia}}</option>                        
        </select>
       </div>
       </div>
      </div>

      <div class="col-12 col-sm-5">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Nombre de la Vía <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.tContacto_data_modal.NomViaDomSoc" onkeyup="this.value=this.value.toUpperCase();"  placeholder="* Nombre de la Via del Domicilio del Cliente" ng-disabled="vm.validate_info!=undefined"/>       
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Número de la Vía <b style="color:red;">(*)</b></label>
       <input type="text" class="form-control" ng-model="vm.tContacto_data_modal.NumViaDomSoc" onkeyup="this.value=this.value.toUpperCase();" min="1" placeholder="* Numero del Domicilio" maxlength="3" ng-disabled="vm.validate_info!=undefined"/>       
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Bloque</label>
       <input type="text" class="form-control" ng-model="vm.tContacto_data_modal.BloDomSoc" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Bloque del Domicilio" maxlength="3" ng-disabled="vm.validate_info!=undefined"/>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Escalera</label>
       <input type="text" class="form-control" ng-model="vm.tContacto_data_modal.EscDomSoc" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Escalera del Domicilio" maxlength="2" ng-disabled="vm.validate_info!=undefined"/>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Planta</label>
       <input type="text" class="form-control" ng-model="vm.tContacto_data_modal.PlaDomSoc" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Planta del Domicilio" maxlength="2" ng-disabled="vm.validate_info!=undefined"/>
       </div>
       </div>
       </div>

       <div class="col-12 col-sm-3">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Puerta</label>
       <input type="text" class="form-control" ng-model="vm.tContacto_data_modal.PueDomSoc" onkeyup="this.value=this.value.toUpperCase();" placeholder="* Puerta del Domicilio" maxlength="4" ng-disabled="vm.validate_info!=undefined"/>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Provincia <b style="color:red;">(*)</b></label>
        <select class="form-control" id="CodPro" name="CodPro"  ng-model="vm.tContacto_data_modal.CodProSoc" ng-change="vm.BuscarLocalidad(1,vm.tContacto_data_modal.CodProSoc)" ng-disabled="vm.validate_info!=undefined">
        <option ng-repeat="dato in vm.tProvidencias" value="{{dato.CodPro}}">{{dato.DesPro}}</option>                          
        </select>
       </div>
       </div>
       </div>

        <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Localidad <b style="color:red;">(*)</b></label>
       <select class="form-control" id="CodLoc" name="CodLoc" ng-model="vm.tContacto_data_modal.CodLocSoc" ng-disabled="vm.validate_info!=undefined" >
        <option ng-repeat="dato in vm.TLocalidadesfiltrada" value="{{dato.CodLoc}}">{{dato.DesLoc}}</option>                         
        </select>
       </div>
       </div>
       </div>
         <div class="col-12 col-sm-4">
       <div class="form">                          
       <div class="form-group">
       <label class="font-weight-bold nexa-dark" style="color:black;">Código Postal</label>
       <input type="text" class="form-control" ng-model="vm.tContacto_data_modal.CPLocSoc" placeholder="* Zona Postal Social" ng-disabled="vm.validate_info!=undefined"/>
       </div>
       </div>
       </div>
  </div>
           <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Tipo de Contacto <b style="color:red;">(*)</b></label>
             <select class="form-control" id="CodTipCon" name="CodTipCon" ng-model="vm.tContacto_data_modal.CodTipCon"  ng-disabled="vm.no_editable!=undefined">
               <option ng-repeat="dato in vm.tListaContactos" value="{{dato.CodTipCon}}">{{dato.DesTipCon}}</option>
            </select>     
             </div>
             </div>
          </div>
          <div class="col-12 col-sm-6">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Cargo <b style="color:red;">(*)</b></label>
             <input type="text" class="form-control" ng-model="vm.tContacto_data_modal.CarConCli" onkeyup="this.value=this.value.toUpperCase();" maxlength="50"  ng-disabled="vm.no_editable!=undefined"/>     
             </div>
             </div>
          </div>
          <div class="col-12 col-sm-4">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Nombre <b style="color:red;">(*)</b></label>
             <input type="text" class="form-control" ng-model="vm.tContacto_data_modal.NomConCli" onkeyup="this.value=this.value.toUpperCase();" maxlength="50"  ng-disabled="vm.no_editable!=undefined"/>  
             </div>
             </div>
          </div>
         
          <div class="col-12 col-sm-4">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Número de Documento <b style="color:red;">(*)</b></label>
             <input type="text" class="form-control" ng-model="vm.tContacto_data_modal.NIFConCli" maxlength="9" readonly ng-disabled="vm.no_editable!=undefined"/>     
             </div>
             </div>
          </div>

          <div class="col-12 col-sm-4">
            <div class="form">                          
             <div class="form-group">
             <label class="font-weight-bold nexa-dark" style="color:black;">Número de Colegiado </label>
             <input type="text" class="form-control" ng-model="vm.tContacto_data_modal.NumColeCon" maxlength="9" ng-disabled="vm.no_editable!=undefined"/>     
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
             <input type="email" class="form-control" ng-model="vm.tContacto_data_modal.EmaConCli" onkeyup="this.value=this.value.toUpperCase();" maxlength="50" ng-disabled="vm.no_editable!=undefined"/>     
             </div>
             </div>
          </div>
           
           

           <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">
            <label class="font-weight-bold nexa-dark" style="color:black;">Es Representante Legal <b style="color:red;">(*)</b></label>             
             
            <br>
             <input type="radio" name="tipo_cliente" value="1" ng-model="vm.tContacto_data_modal.EsRepLeg" ng-disabled="vm.validate_info_servicio_especiales==1 || vm.no_editable!=undefined" ng-click="vm.verificar_representante_legal()">
            <label class="font-weight-bold nexa-dark" style="color:black;">Si</label>

             <input type="radio" name="tipo_cliente" value="0" ng-model="vm.tContacto_data_modal.EsRepLeg" ng-disabled="vm.validate_info_servicio_especiales==1 || vm.no_editable!=undefined" ng-click="vm.verificar_representante_legal()">
             <label class="font-weight-bold nexa-dark" style="color:black;">No</label>


             </div>
             </div>
          </div>
           <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">  
              <label class="font-weight-bold nexa-dark" style="color:black;">Tipo de Representación <b style="color:red;">(*)</b></label> 
              <select class="form-control" id="TipRepr" name="TipRepr" ng-model="vm.tContacto_data_modal.TipRepr" ng-disabled="vm.tContacto_data_modal.EsRepLeg==undefined||vm.tContacto_data_modal.EsRepLeg==0 || vm.no_editable!=undefined" >
               <option ng-repeat="dato in vm.tListaRepre" value="{{dato.id}}">{{dato.DesTipRepr}}</option>
            </select>     
             </div>
             </div>
          </div>
           <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">  
              <label class="font-weight-bold nexa-dark" style="color:black;">Firmantes <b style="color:red;">(*)</b></label>           
             
             <input type="text" class="form-control" ng-model="vm.tContacto_data_modal.CanMinRep" ng-change="vm.validarsinuermoContactos(vm.tContacto_data_modal.CanMinRep,3)" min="1" maxlength="4" ng-disabled="vm.no_editable!=undefined || vm.tContacto_data_modal.TipRepr!=='2'"/>     
             </div>
             </div>
          </div>
           <div class="col-12 col-sm-3">
            <div class="form">                          
             <div class="form-group">  
              <label class="font-weight-bold nexa-dark" style="color:black;">Facultad de Escrituras </label>           
             <br>
             <input type="radio" name="TieFacEsc" value="1" ng-model="vm.tContacto_data_modal.TieFacEsc" ng-disabled="vm.no_editable!=undefined" ng-click="vm.verificar_facultad_escrituras()">
            <label class="font-weight-bold nexa-dark" style="color:black;">Si</label>

             <input type="radio" name="TieFacEsc" value="0" ng-model="vm.tContacto_data_modal.TieFacEsc" ng-disabled="vm.no_editable!=undefined">
             <label class="font-weight-bold nexa-dark" style="color:black;">No</label>

             </div>
             </div>
          </div>
      <div style="margin-top: 8px;">
       <div align="center"><label class="font-weight-bold nexa-dark" style="color:gray;"><b>.</b></label></div></div>
        

      <div class="form">                          
       <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Fotocopia del DNI/NIE <a title='Descargar Documento' ng-show="vm.tContacto_data_modal.DocNIF!=null && vm.tContacto_data_modal.CodConCli>0" href="{{vm.tContacto_data_modal.DocNIF}}" download class="btn btn-info btn-icon mg-r-5"><div><i class="fa fa-download" style="color:white;"></i></div></a>   </label>
         
         <div id="file-wrap">
            <p>Presione para adjuntar el fichero o <strong>arrastrar</strong> el fichero y <strong>soltar</strong> aquí</p>                       
            <input type="file" id="DocNIF" class="file_b" uploader-model="DocNIF" ng-disabled="vm.tContacto_data_modal.EsRepLeg==0||vm.tContacto_data_modal.EsRepLeg==undefined||vm.no_editable!=undefined" draggable="true">
            <div id="filenameDocNIF"></div>                       
          </div>

      </div>
       </div>
       
       <div class="form">                          
       <div class="form-group">
         <label class="font-weight-bold nexa-dark" style="color:black;">Fotocopia del PODER <a title='Descargar Documento' ng-show="vm.tContacto_data_modal.DocPod!=null && vm.tContacto_data_modal.CodConCli>0" href="{{vm.tContacto_data_modal.DocPod}}" download class="btn btn-info btn-icon mg-r-5"><div><i class="fa fa-download" style="color:white;"></i></div></a></label>

          <div id="file-wrap">
            <p>Presione para adjuntar el fichero o <strong>arrastrar</strong> el fichero y <strong>soltar</strong> aquí</p>                       
            <input  type="file" id="DocPod" class="file_b" uploader-model="DocPod" ng-disabled="vm.tContacto_data_modal.TieFacEsc==1 || vm.tContacto_data_modal.TieFacEsc==undefined ||vm.no_editable!=undefined" draggable="true">
            <div id="filenameDocPod"></div>                       
          </div>

<script>
          
      $('#DocNIF').on('change', function() 
      { const $Archivo_DocNIF = document.querySelector("#DocNIF");         
        let Archivo_DocNIF = $Archivo_DocNIF.files;                      
        namefileDocNIF = '<i class="fa fa-file"> '+$Archivo_DocNIF.files[0].name+'</i>';
          $('#filenameDocNIF').html(namefileDocNIF);
      });
          
      $('#DocPod').on('change', function() 
      {
        const $Archivo_DocPod = document.querySelector("#DocPod");           
        let Archivo_DocPod = $Archivo_DocPod.files;                      
        namefile = '<i class="fa fa-file"> '+$Archivo_DocPod.files[0].name+'</i>'; //$Archivo_DocPod.files[0].name;
          $('#filenameDocPod').html(namefile);
      });
</script>
       </div>
       </div>

            <div class="form">                          
     <div class="form-group">
     <label class="font-weight-bold nexa-dark" style="color:black;">Observación</label>
     <textarea type="text" class="form-control" ng-model="vm.tContacto_data_modal.ObsConC" onkeyup="this.value=this.value.toUpperCase();" rows="5" maxlength="200" ng-disabled="vm.no_editable!=undefined"/></textarea>
     </div>
     </div>
            
             <button class="btn btn-info" type="submit" ng-show="vm.tContacto_data_modal.CodConCli==undefined && vm.no_editable==undefined" ng-disabled="form_contacto2.$invalid">Registrar</button>
             <button class="btn btn-success" type="submit" ng-show="vm.tContacto_data_modal.CodConCli>0 && vm.no_editable==undefined">Actualizar</button>
             <a class="btn btn-danger" ng-click="vm.regresar_contacto()">Volver</a>
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
<div id="cargando_I" class="loader loader-default"  data-text="Cargando Información del Contacto"></div>

<div id="crear_clientes" class="loader loader-default"  data-text="Creando o Actualizando Comercial"></div>
<div id="Principal" class="loader loader-default"  data-text="Verificando Contacto Principal"></div>

</html>
