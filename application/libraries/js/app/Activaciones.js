    app.controller('Controlador_Activaciones', ['$http', '$scope', '$filter', '$route', '$interval', '$controller', '$cookies', Controlador])
    .directive('stringToNumber', function() {
  return {
    require: 'ngModel',
    link: function(scope, element, attrs, ngModel) {
      ngModel.$parsers.push(function(value) {
        return '' + value;
      });
      ngModel.$formatters.push(function(value) {
        return parseFloat(value);
      });
    }
  };
})

    function Controlador($http, $scope, $filter, $route, $interval, $controller, $cookies) 
    {
        var scope = this;
        scope.fdatos = {}; // datos del formulario
        //scope.nID = $route.current.params.ID; //contiene el id del registro en caso de estarse consultando desde la grid
        scope.Nivel = $cookies.get('nivel');
        scope.T_Contratos = [];
        scope.T_ContratosBack = [];
        scope.VistaResponse=false;
        var fecha = new Date();
        var dd = fecha.getDate();
        var mm = fecha.getMonth() + 1; //January is 0!
        var yyyy = fecha.getFullYear();
        if (dd < 10) {
            dd = '0' + dd
        }
        if (mm < 10) {
            mm = '0' + mm
        }
        var fecha = dd + '/' + mm + '/' + yyyy;
        scope.CUPsName='ES';
        scope.ListNuevosEstadosContrato = [{ EstConCups: 1, nombre: 'Contrato' }, { EstConCups: 2, nombre: 'Implícita' }, { EstConCups: 3, nombre: 'Baja Rescatable' }, { EstConCups: 4, nombre: 'Baja Definitiva' }];
        scope.List_TipPre = [{ TipPre: 0, nombre: 'Fijo' }, { TipPre: 1, nombre: 'Indexado' }];
        
        scope.buscarCUPsActivaciones=function()
        { 
            if(scope.CUPsName.length<20)
            {
                scope.toast('error','El Campo CUPs debe estar Completo con sus 20 digitos.','Error');
                return false;
            }
            scope.VistaResponse=false;
            scope.RazSocCli=null;
            scope.CodConCom=null;
            scope.NomTar=null;
            scope.PotEleConP1=null;
            scope.PotEleConP2=null;
            scope.PotEleConP3=null;
            scope.PotEleConP4=null;
            scope.PotEleConP5=null;
            scope.PotEleConP6=null;
            scope.DesPro=null;
            scope.FecActCUPs=null;
            scope.FecVenCUPs=null;
            scope.ConCup=null;
            scope.EstConCups=null;
            console.log(scope.CUPsName.length);
            if(scope.CUPsName.length>=20)
            {
                $("#buscando").removeClass("loader loader-default").addClass("loader loader-default  is-active");
                var url = base_urlHome() + "api/Activaciones/getCUPsActivaciones/CUPsName/"+scope.CUPsName;
                $http.get(url).then(function(result){
                    $("#buscando").removeClass("loader loader-default  is-active").addClass("loader loader-default");
                    if (result.data != false) 
                    {                        
                        if(result.data.status==400 && result.data.statusText=='CUPs Sin Contrato')
                        {
                            scope.VistaResponseSinData=true;
                            scope.toast('error',result.data.menssage,result.data.statusText);
                            return false;
                        }
                        if(result.data.status==200 && result.data.statusText=='Contratos')
                        {
                            //scope.toast('success',result.data.menssage,result.data.statusText);
                            scope.T_Contratos=result.data.ListContratos;
                            $("#modal_lista_contratos").modal('show');
                            return false;
                        }                              
                    } 
                    else 
                    {
                            scope.toast('error','No hay CUPs registrados','Error');                             
                    }
                }, function(error) 
                {
                        $("#buscando").removeClass("loader loader-default  is-active").addClass("loader loader-default");
                        if (error.status == 404 && error.statusText == "Not Found"){
                            scope.toast('error','El método que esté intentando usar no puede ser localizado','Error 404');
                        }if (error.status == 401 && error.statusText == "Unauthorized"){
                            scope.toast('error','Disculpe, Usuario no autorizado para acceder a ester módulo','Error 401');
                        }if (error.status == 403 && error.statusText == "Forbidden"){
                            scope.toast('error','Está intentando utilizar un APIKEY inválido','Error 403');
                        }if (error.status == 500 && error.statusText == "Internal Server Error") {
                            scope.toast('error','Ha ocurrido una falla en el Servidor, intente más tarde','Error 500');
                        }
                });
            }
        }
        scope.filtrerCanPeriodos = function(CodTarEle) 
        {
            console.log(CodTarEle);         
            for (var i = 0; i < scope.ListTar.length; i++) 
            {
                if (scope.ListTar[i].CodTar == CodTarEle) 
                {
                    scope.CanPerEle = scope.ListTar[i].CanPerTar;
                    console.log(scope.CanPerEle);
                    if(scope.CanPerEle==0||scope.CanPerEle==null)
                    {
                       scope.toast('error','Esta Tárifa no tiene cantidad de periodos asignada','Error en Periodos');
                       scope.CanPerEle=6;
                    }
                }
            }
        }
        scope.asignarcontrato=function(index,dato,status)
        {
            if(dato.TipCups==1)
            {
                scope.cargar_tiposFiltros(1);
            }
            scope.CanPerEle=null;
            scope.VistaResponse=true;
            scope.RazSocCli=dato.RazSocCli;
            scope.NumCifCli=dato.NumCifCli;
            scope.CUPsName=dato.CUPsName;
            scope.NomTar=dato.CodTar;
            scope.DesPro=dato.CodPro;
            scope.fdatos.TipProCom='1';
            scope.fdatos.CodConCom=dato.CodConCom;            
            scope.EstConCups=dato.EstConCups;
            scope.fdatos.CodCups=dato.CodCups;
            scope.fdatos.TipCups=dato.TipCups;
            scope.fdatos.CodProCom=dato.CodProCom;
            scope.fdatos.CodProComCli=dato.CodProComCli;
            scope.fdatos.CodProComCup=dato.CodProComCup;
            scope.fdatos.CodPunSum=dato.CodPunSum;
            scope.CodCom=dato.CodCom;
            scope.fdatos.CodCli=dato.CodCli;
            scope.CodAnePro=dato.CodAnePro;
            scope.ObsCup=dato.ObsCup;
            scope.TipPre=dato.TipPre;            
            scope.FecActCUPs=dato.FecActCUPs;
            $('.FecActCUPs').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.FecActCUPs);
            scope.FecVenCUPs=dato.FecVenCUPs;
            $('.FecVenCUPs').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.FecVenCUPs);
            scope.ConCup=dato.ConCup;
            if(dato.TipCups==1)
            {
                scope.CauDiaGas=null;
                scope.PotEleConP1=dato.PotEleConP1;
                scope.PotEleConP2=dato.PotEleConP2;
                scope.PotEleConP3=dato.PotEleConP3;
                scope.PotEleConP4=dato.PotEleConP4;
                scope.PotEleConP5=dato.PotEleConP5;
                scope.PotEleConP6=dato.PotEleConP6;
                setTimeout(function(){ scope.filtrerCanPeriodos(dato.CodTar);scope.cargar_tiposFiltros(1); }, 2000);
            }
            else
            {
                scope.CauDiaGas=dato.CauDiaGas;
                scope.PotEleConP1=null;
                scope.PotEleConP2=null;
                scope.PotEleConP3=null;
                scope.PotEleConP4=null;
                scope.PotEleConP5=null;
                scope.PotEleConP6=null;
                scope.cargar_tiposFiltros(2);
            }
            scope.cargar_tiposFiltros(3);            
        }
        scope.filtrerCanPeriodosModal = function(CodTarEle) 
        {
            console.log(CodTarEle);         
            for (var i = 0; i < scope.ListTar.length; i++) 
            {
                if (scope.ListTar[i].CodTar == CodTarEle) 
                {
                    scope.CanPerEleModalContratoRapido = scope.ListTar[i].CanPerTar;
                    console.log(scope.CanPerEleModalContratoRapido);
                    if(scope.CanPerEleModalContratoRapido==0||scope.CanPerEleModalContratoRapido==null)
                    {
                       scope.toast('error','Esta Tárifa no tiene cantidad de periodos asignada','Error en Periodos');
                       scope.CanPerEleModalContratoRapido=6;
                    }
                }
            }
        }
        scope.cargar_tiposFiltros=function(metodo)
        {
            var url = base_urlHome()+"api/Activaciones/RealizarConsultaFiltros/metodo/"+metodo;
            $http.get(url).then(function (result)
            {
                if(result.data)
                {
                    if(metodo==1||metodo==2)
                    {
                        scope.ListTar=result.data;
                    }
                    else if(metodo==3)
                    {
                        scope.ListProducts=result.data;
                    }
                    else if(metodo==4)
                    {
                        scope.List_Comercializadora=result.data;
                    }                    
                    else
                    {   
                        scope.ListTar=[];
                        scope.ListProducts=[];
                    }                
                }
                else
                {
                   if(metodo==1||metodo==2)
                    {
                        scope.ListTar=[];
                    }
                    else if(metodo==3)
                    {
                        scope.ListProducts=result.data;
                    }
                     else if(metodo==4)
                    {
                        scope.List_Comercializadora=[];
                    }
                    else
                    {   
                        scope.ListTar=[];
                        scope.ListProducts=[];

                    }  
                }
            },function(error)
                {
                    if (error.status == 404 && error.statusText == "Not Found"){
                        scope.toast('error','El método que esté intentando usar no puede ser localizado','Error 404');
                    }if (error.status == 401 && error.statusText == "Unauthorized"){
                        scope.toast('error','Disculpe, Usuario no autorizado para acceder a ester módulo','Error 401');
                    }if (error.status == 403 && error.statusText == "Forbidden"){
                        scope.toast('error','Está intentando utilizar un APIKEY inválido','Error 403');
                    }if (error.status == 500 && error.statusText == "Internal Server Error") {
                        scope.toast('error','Ha ocurrido una falla en el Servidor, intente más tarde','Error 500');
                    }
            });  
        }
        scope.GenerarContratoRapido=function(metodo)
        {
            if(metodo==1)
            {
                var url = base_urlHome()+"api/Activaciones/ComprobarDatosCUPs/CUPsName/"+scope.CUPsName;
                $http.get(url).then(function(result)
                {
                    if(result.data!=false)
                    {
                        $("#modal_lista_contratos").modal('hide');
                        $("#modal_contrato_rapido").modal('show');
                        scope.RazSocCli=result.data.Cups_RazSocCli;
                        scope.NumCifCli=result.data.Cups_Cif;
                        scope.contrato_fdatos={};
                        scope.contrato_fdatos.PotEleConP1=null;
                        scope.contrato_fdatos.PotEleConP2=null;
                        scope.contrato_fdatos.PotEleConP3=null;
                        scope.contrato_fdatos.PotEleConP4=null;
                        scope.contrato_fdatos.PotEleConP5=null;
                        scope.contrato_fdatos.PotEleConP6=null;
                        scope.contrato_fdatos.TDocumentosContratos=[];        
                        if(result.data.TipServ=='Eléctrico')
                        {
                           scope.contrato_fdatos.TipCups=1; 
                           scope.contrato_fdatos.CodCupSEle=result.data.CodCupGas;
                           scope.cargar_tiposFiltros(1);
                           scope.realizar_filtro(4, result.data.CodCupGas)
                        }
                        else if(result.data.TipServ=='Gas')
                        {
                            scope.contrato_fdatos.TipCups=2;
                            scope.contrato_fdatos.CodCupGas=result.data.CodCupGas;
                            scope.cargar_tiposFiltros(2);
                            scope.realizar_filtro(5, result.data.CodCupGas)
                            
                        }
                        else
                        {
                            scope.toast('error','no se ha definido que tipo de servicio es el CUPs','Error');
                            scope.contrato_fdatos.TipCups=null;
                        }                        
                        
                        scope.cargar_tiposFiltros(4);
                        scope.contrato_fdatos.CodPunSum=result.data.CodPunSum;
                        scope.realizar_filtro(6,result.data.CodCli);
                        scope.contrato_fdatos.CodCom=null;
                        scope.contrato_fdatos.CodCli=result.data.CodCli;
                        scope.contrato_fdatos.CodAnePro=null;
                        scope.contrato_fdatos.TipPre=null;  
                        scope.contrato_fdatos.ObsCup=null;  

                        console.log(scope);
                    }
                    else
                    {
                        scope.toast('error','Este CUPs no Existe','Error');
                    }
                },function(error)
                {
                    if (error.status == 404 && error.statusText == "Not Found"){
                        scope.toast('error','El método que esté intentando usar no puede ser localizado','Error 404');
                    }if (error.status == 401 && error.statusText == "Unauthorized"){
                        scope.toast('error','Disculpe, Usuario no autorizado para acceder a ester módulo','Error 401');
                    }if (error.status == 403 && error.statusText == "Forbidden"){
                        scope.toast('error','Está intentando utilizar un APIKEY inválido','Error 403');
                    }if (error.status == 500 && error.statusText == "Internal Server Error") {
                        scope.toast('error','Ha ocurrido una falla en el Servidor, intente más tarde','Error 500');
                    }
                });
            }
            else if (metodo==2) 
            {
                $("#modal_lista_contratos").modal('hide');
                $("#modal_contrato_rapido").modal('show');        
                scope.contrato_fdatos={};
                scope.contrato_fdatos.TDocumentosContratos=[];
                scope.contrato_fdatos.TipCups=scope.fdatos.TipCups;            
                scope.cargar_tiposFiltros(4);            
                scope.contrato_fdatos.CodPunSum=scope.fdatos.CodPunSum;
                scope.contrato_fdatos.CodCom=scope.CodCom;
                scope.contrato_fdatos.CodCli=scope.fdatos.CodCli;
                scope.contrato_fdatos.CodAnePro=scope.CodAnePro;
                scope.contrato_fdatos.TipPre=scope.TipPre;  
                scope.contrato_fdatos.ObsCup=scope.ObsCup;
                if(scope.contrato_fdatos.TipCups==1)
                {
                    scope.contrato_fdatos.CodTarEle=scope.NomTar;
                    scope.CanPerEleModalContratoRapido=6;
                    scope.realizar_filtro(4,scope.fdatos.CodCups);
                    scope.contrato_fdatos.CodCupSEle=scope.fdatos.CodCups;
                    scope.filtrerCanPeriodosModal(scope.contrato_fdatos.CodTarEle);
                    scope.contrato_fdatos.ConCupsEle=scope.ConCup;                
                    scope.contrato_fdatos.PotEleConP1=scope.PotEleConP1;
                    scope.contrato_fdatos.PotEleConP2=scope.PotEleConP2;
                    scope.contrato_fdatos.PotEleConP3=scope.PotEleConP3;
                    scope.contrato_fdatos.PotEleConP4=scope.PotEleConP4;
                    scope.contrato_fdatos.PotEleConP5=scope.PotEleConP5;
                    scope.contrato_fdatos.PotEleConP6=scope.PotEleConP6;
                }
                else
                { 
                    scope.realizar_filtro(5,scope.fdatos.CodCups); 
                    scope.contrato_fdatos.CodCupGas=scope.fdatos.CodCups;
                    scope.contrato_fdatos.CodTarGas=scope.NomTar;
                    scope.contrato_fdatos.Consumo=scope.ConCup;
                    scope.contrato_fdatos.CauDiaGas=scope.CauDiaGas;
                }  
                if(scope.contrato_fdatos.CodCom!=null)
                {
                    scope.realizar_filtro(1, scope.contrato_fdatos.CodCom);
                }
                scope.contrato_fdatos.CodPro=scope.DesPro;
                if( scope.DesPro!=null)
                {
                    scope.realizar_filtro(2, scope.DesPro);
                }
                scope.realizar_filtro(6,scope.fdatos.CodCli);
            }
            else
            {
                $("#modal_lista_contratos").modal('hide');
                $("#modal_contrato_rapido").modal('hide');
                scope.toast('error','Error en Método intente nuevamente','Error');
            }

            /*if(scope.T_Contratos.length==0)
            {
                                
            }
            else
            {
                
            }*/
        }
    
        $scope.submitFormCUPsActivacionesFechas = function(event) 
        {
            if (!scope.validar_campos_activaciones()) {
                 return false;
            }
            //var  
            //nStr += '';
            /*x = scope.PotConP1.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? ',' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                    x1 = x1.replace(rgx, '$1' + '.' + '$2');
            }
            console.log(x1 + x2);*/
            //return x1 + x2;


             console.log(scope.fdatos);
             //console.log(parseFloat(scope.PotConP1.toString()).toFixed(2));
             //console.log(parseFloat(scope.PotConP1));
                var title = 'Actualizando';
                var text = '¿Seguro que desea modificar la información del contrato?';
                var response = "información modificada correctamente.";
           
                Swal.fire({
                 title: title,
                 text: text,
                 type: "question",
                 showCancelButton: !0,
                 confirmButtonColor: "#31ce77",
                 cancelButtonColor: "#f34943",
                 confirmButtonText: "Confirmar"
                }).then(function(t) {
                 if (t.value == true) {
                     scope.guardar();
                 } else {
                     event.preventDefault();
                 }
             });
        };
        scope.validar_campos_activaciones = function() 
        {
         
            resultado = true;
            var FecActCUPs = document.getElementById("FecActCUPs").value;
            scope.FecActCUPs = FecActCUPs;
            if (scope.FecActCUPs == null || scope.FecActCUPs == undefined || scope.FecActCUPs == '') 
            {
                 scope.fdatos.FecActCUPs=null;
            } 
            else 
            {
                var FecActCUPsFinal = (scope.FecActCUPs).split("/");
                if (FecActCUPsFinal.length < 3) {
                     scope.toast('error','El formato de Fecha de Activación correcto es DD/MM/YYYY','');
                     event.preventDefault();
                     return false;
                } else {
                     if (FecActCUPsFinal[0].length > 2 || FecActCUPsFinal[0].length < 2) {
                         scope.toast('error','Error en Día, debe introducir dos números','');
                         event.preventDefault();
                         return false;
                     }
                     if (FecActCUPsFinal[1].length > 2 || FecActCUPsFinal[1].length < 2) {
                         scope.toast('error','Error en Mes, debe introducir dos números','');
                         event.preventDefault();
                         return false;
                     }
                     if (FecActCUPsFinal[2].length < 4 || FecActCUPsFinal[2].length > 4) {
                         scope.toast('error','Error en Año, debe introducir cuatro números','');
                         event.preventDefault();
                         return false;
                    }                 
                    scope.fdatos.FecActCUPs = FecActCUPsFinal[2] + "-" + FecActCUPsFinal[1] + "-" + FecActCUPsFinal[0];
                }
            }
            var FecVenCUPs = document.getElementById("FecVenCUPs").value;
            scope.FecVenCUPs = FecVenCUPs;
            if (scope.FecVenCUPs == null || scope.FecVenCUPs == undefined || scope.FecVenCUPs == '') 
            {
                 scope.fdatos.FecVenCUPs=null;
            } 
            else 
            {
                var FecVenCUPsFinal = (scope.FecVenCUPs).split("/");
                if (FecVenCUPsFinal.length < 3) {
                     scope.toast('error','El formato de Fecha de Activación correcto es DD/MM/YYYY','');
                     event.preventDefault();
                     return false;
                } else {
                     if (FecVenCUPsFinal[0].length > 2 || FecVenCUPsFinal[0].length < 2) {
                         scope.toast('error','Error en Día, debe introducir dos números','');
                         event.preventDefault();
                         return false;
                     }
                     if (FecVenCUPsFinal[1].length > 2 || FecVenCUPsFinal[1].length < 2) {
                         scope.toast('error','Error en Mes, debe introducir dos números','');
                         event.preventDefault();
                         return false;
                     }
                     if (FecVenCUPsFinal[2].length < 4 || FecVenCUPsFinal[2].length > 4) {
                         scope.toast('error','Error en Año, debe introducir cuatro números','');
                         event.preventDefault();
                         return false;
                     }                 
                     scope.fdatos.FecVenCUPs = FecVenCUPsFinal[2] + "-" + FecVenCUPsFinal[1] + "-" + FecVenCUPsFinal[0];
                 }
             }
             if (scope.ConCup == undefined || scope.ConCup == null || scope.ConCup == '') {
                 scope.fdatos.ConCup = null;
             } else {
                 scope.fdatos.ConCup = scope.ConCup;
             }

             if(scope.fdatos.TipCups==1)
             {            
                scope.fdatos.PotEleConP1=null;
                scope.fdatos.PotEleConP2=null;
                scope.fdatos.PotEleConP3=null;
                scope.fdatos.PotEleConP4=null;
                scope.fdatos.PotEleConP5=null;
                scope.fdatos.PotEleConP6=null;
                if (scope.CanPerEle == 0) {
                     
                     scope.toast('error','La Tárifa no posee cantidad de periodos asignados.','');
                     scope.fdatos.PotEleConP1=null;
                     scope.fdatos.PotEleConP2=null;
                     scope.fdatos.PotEleConP3=null;
                     scope.fdatos.PotEleConP4=null;
                     scope.fdatos.PotEleConP5=null;
                     scope.fdatos.PotEleConP6=null;
                }
                else if (scope.CanPerEle == 1) {
                     if (scope.PotEleConP1 == null || scope.PotEleConP1 == undefined || scope.PotEleConP1 == '') {
                         scope.toast('error','Debe indicar la Potencia 1','');
                         return false;
                     }
                     else
                     {
                        scope.fdatos.PotEleConP1=scope.PotEleConP1;                    
                     }
                 }
                else if (scope.CanPerEle == 2) {
                     if (scope.PotEleConP1 == null || scope.PotEleConP1 == undefined || scope.PotEleConP1 == '') {
                         scope.toast('error','Debe indicar la Potencia 1','');
                         return false;
                     }
                     else
                     {
                        scope.fdatos.PotEleConP1=scope.PotEleConP1;
                     }
                     if (scope.PotEleConP2 == null || scope.PotEleConP2 == undefined || scope.PotEleConP2 == '') {
                         scope.toast('error','Debe indicar la Potencia 2','');
                         return false;
                     }
                     else
                     {
                        scope.fdatos.PotEleConP2=scope.PotEleConP2;
                     }
                 }
                else if (scope.CanPerEle == 3) {
                     if (scope.PotEleConP1 == null || scope.PotEleConP1 == undefined || scope.PotEleConP1 == '') {
                         scope.toast('error','Debe indicar la Potencia 1','');
                         return false;
                     }
                     else
                     {
                        scope.fdatos.PotEleConP1=scope.PotEleConP1;
                     }
                     if (scope.PotEleConP2 == null || scope.PotEleConP2 == undefined || scope.PotEleConP2 == '') {
                         scope.toast('error','Debe indicar la Potencia 2','');
                         return false;
                     }
                     else
                     {
                        scope.fdatos.PotEleConP2=scope.PotEleConP2;
                     }
                     if (scope.PotEleConP3 == null || scope.PotEleConP3 == undefined || scope.PotEleConP3 == '') {
                         scope.toast('error','Debe indicar la Potencia 3','');
                         return false;
                     }
                     else
                     {
                        scope.fdatos.PotEleConP3=scope.PotEleConP3;
                     }
                 }
                if (scope.CanPerEle == 4) 
                {
                      if (scope.PotEleConP1 == null || scope.PotEleConP1 == undefined || scope.PotEleConP1 == '') {
                         scope.toast('error','Debe indicar la Potencia 1','');
                         return false;
                     }
                     else
                     {
                        scope.fdatos.PotEleConP1=scope.PotEleConP1;
                     }
                     if (scope.PotEleConP2 == null || scope.PotEleConP2 == undefined || scope.PotEleConP2 == '') {
                         scope.toast('error','Debe indicar la Potencia 2','');
                         return false;
                     }
                     else
                     {
                        scope.fdatos.PotEleConP2=scope.PotEleConP2;
                     }
                     if (scope.PotEleConP3 == null || scope.PotEleConP3 == undefined || scope.PotEleConP3 == '') {
                         scope.toast('error','Debe indicar la Potencia 3','');
                         return false;
                     }
                     else
                     {
                        scope.fdatos.PotEleConP3=scope.PotEleConP3;
                     }
                     if (scope.PotEleConP4 == null || scope.PotEleConP4 == undefined || scope.PotEleConP4 == '') {
                         scope.toast('error','Debe indicar la Potencia 4','');
                         return false;
                     }
                     else
                     {
                        scope.fdatos.PotEleConP4=scope.PotEleConP4;
                     }
                }
                if (scope.CanPerEle == 5) {
                     if (scope.PotEleConP1 == null || scope.PotEleConP1 == undefined || scope.PotEleConP1 == '') {
                         scope.toast('error','Debe indicar la Potencia 1','');
                         return false;
                     }
                     else
                     {
                        scope.fdatos.PotEleConP1=scope.PotEleConP1;
                     }
                     if (scope.PotEleConP2 == null || scope.PotEleConP2 == undefined || scope.PotEleConP2 == '') {
                         scope.toast('error','Debe indicar la Potencia 2','');
                         return false;
                     }
                     else
                     {
                        scope.fdatos.PotEleConP2=scope.PotEleConP2;
                     }
                     if (scope.PotEleConP3 == null || scope.PotEleConP3 == undefined || scope.PotEleConP3 == '') {
                         scope.toast('error','Debe indicar la Potencia 3','');
                         return false;
                     }
                     else
                     {
                        scope.fdatos.PotEleConP3=scope.PotEleConP3;
                     }
                     if (scope.PotEleConP4 == null || scope.PotEleConP4 == undefined || scope.PotEleConP4 == '') {
                         scope.toast('error','Debe indicar la Potencia 4','');
                         return false;
                     }
                     else
                     {
                        scope.fdatos.PotEleConP4=scope.PotEleConP4;
                     }
                     if (scope.PotEleConP5 == null || scope.PotEleConP5 == undefined || scope.PotEleConP5 == '') {
                         scope.toast('error','Debe indicar la Potencia 5','');
                         return false;
                     }
                     else
                     {
                        scope.fdatos.PotEleConP5=scope.PotEleConP5;
                     }
                }
                if (scope.CanPerEle == 6) 
                {
                    if (scope.PotEleConP1 == null || scope.PotEleConP1 == undefined || scope.PotEleConP1 == '') {
                         scope.toast('error','Debe indicar la Potencia 1','');
                         return false;
                     }
                     else
                     {
                        scope.fdatos.PotEleConP1=scope.PotEleConP1;
                     }
                     if (scope.PotEleConP2 == null || scope.PotEleConP2 == undefined || scope.PotEleConP2 == '') {
                         scope.toast('error','Debe indicar la Potencia 2','');
                         return false;
                     }
                     else
                     {
                        scope.fdatos.PotEleConP2=scope.PotEleConP2;
                     }
                     if (scope.PotEleConP3 == null || scope.PotEleConP3 == undefined || scope.PotEleConP3 == '') {
                         scope.toast('error','Debe indicar la Potencia 3','');
                         return false;
                     }
                     else
                     {
                        scope.fdatos.PotEleConP3=scope.PotEleConP3;
                     }
                     if (scope.PotEleConP4 == null || scope.PotEleConP4 == undefined || scope.PotEleConP4 == '') {
                         scope.toast('error','Debe indicar la Potencia 4','');
                         return false;
                     }
                     else
                     {
                        scope.fdatos.PotEleConP4=scope.PotEleConP4;
                     }
                     if (scope.PotEleConP5 == null || scope.PotEleConP5 == undefined || scope.PotEleConP5 == '') {
                         scope.toast('error','Debe indicar la Potencia 5','');
                         return false;
                     }
                     else
                     {
                        scope.fdatos.PotEleConP5=scope.PotEleConP5;
                     }
                    if (scope.PotEleConP6 == null || scope.PotEleConP6 == undefined || scope.PotEleConP6 == '') 
                    {
                        scope.toast('error','Debe indicar la Potencia 6','');
                        return false;
                    }
                    else
                    {
                        scope.fdatos.PotEleConP6=scope.PotEleConP6;
                    }
                }
             }
             scope.fdatos.EstConCups=scope.EstConCups;
             scope.fdatos.CodTar=scope.NomTar;
             scope.fdatos.CodPro=scope.DesPro;

             if (resultado == false) {
                 //quiere decir que al menos un renglon no paso la validacion
                 return false;
             }
             return true;
        }
    scope.guardar = function() 
    {
         
        var title = 'Actualizando';
        var text = '¿Seguro que desea modificar la información del contrato?';
        var response = "información modificada correctamente.";
         $("#" + title).removeClass("loader loader-default").addClass("loader loader-default is-active");
         var url = base_urlHome() + "api/Activaciones/UpdateInformationContratos/";
         $http.post(url, scope.fdatos).then(function(result) {             
             $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
             if(result.data!=false)
             {
                scope.toast('success','información actualizada correctamente.','Contrato');
                scope.buscarCUPsActivaciones();
             }
             else
             {
                scope.toast('error','Error Actualizando información intente nuevamente.','Error');
             }             
         }, function(error) {
             $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (error.status == 404 && error.statusText == "Not Found"){
                    scope.toast('error','El método que esté intentando usar no puede ser localizado','Error 404');
                    }if (error.status == 401 && error.statusText == "Unauthorized"){
                        scope.toast('error','Disculpe, Usuario no autorizado para acceder a ester módulo','Error 401');
                    }if (error.status == 403 && error.statusText == "Forbidden"){
                        scope.toast('error','Está intentando utilizar un APIKEY inválido','Error 403');
                    }if (error.status == 500 && error.statusText == "Internal Server Error") {
                    scope.toast('error','Ha ocurrido una falla en el Servidor, intente más tarde','Error 500');
                    }
         });
    }
    scope.validar_formatos_input = function(metodo, object) 
    {
        
        if (metodo == 1) {
             if (object != undefined) {
                 numero = object;
                 if (!/^([.0-9])*$/.test(numero))
                     scope.PotEleConP1 = numero.substring(0, numero.length - 1);
             }
         }
         if (metodo == 2) {
             if (object != undefined) {
                 numero = object;
                 if (!/^([.0-9])*$/.test(numero))
                     scope.PotEleConP2 = numero.substring(0, numero.length - 1);
             }
         }
         if (metodo == 3) {
             if (object != undefined) {
                 numero = object;
                 if (!/^([.0-9])*$/.test(numero))
                     scope.PotEleConP3 = numero.substring(0, numero.length - 1);
             }
         }
         if (metodo == 4) {
             if (object != undefined) {
                 numero = object;
                 if (!/^([.0-9])*$/.test(numero))
                     scope.PotEleConP4 = numero.substring(0, numero.length - 1);
             }
         }
         if (metodo == 5) {
             if (object != undefined) {
                 numero = object;
                 if (!/^([.0-9])*$/.test(numero))
                     scope.PotEleConP5 = numero.substring(0, numero.length - 1);
             }
         }
         if (metodo == 6) {
             if (object != undefined) {
                 numero = object;
                 if (!/^([.0-9])*$/.test(numero))
                     scope.PotEleConP6 = numero.substring(0, numero.length - 1);
             }
         }
         if (metodo == 7) {
             if (object != undefined) {
                 numero = object;
                 if (!/^([/0-9])*$/.test(numero))
                     scope.FecActCUPs = numero.substring(0, numero.length - 1);
             }
         }
         if (metodo == 8) {
             if (object != undefined) {
                 numero = object;
                 if (!/^([/0-9])*$/.test(numero))
                     scope.FecVenCUPs = numero.substring(0, numero.length - 1);
             }
         }
         if (metodo == 9) {
             if (object != undefined) {
                 numero = object;
                 if (!/^([.0-9])*$/.test(numero))
                     scope.ConCup = numero.substring(0, numero.length - 1);
             }
         }         
    }
    scope.realizar_filtro = function(metodo, PrimaryKey) 
    {
        var url = base_urlHome() + "api/Activaciones/realizar_filtro/metodo/" + metodo + "/PrimaryKey/" + PrimaryKey;
        $http.get(url).then(function(result) {
             if (result.data != false) {
                 if (metodo == 1) {
                     scope.List_Productos = result.data;
                 }
                 if (metodo == 2) {
                     scope.List_Anexos = result.data;
                 }
                 if (metodo == 3) {
                     scope.contrato_fdatos.TipPre = result.data.TipPre;
                 }
                 if (metodo == 4) {
                     scope.List_CUPsEle = result.data;
                 }
                 if (metodo == 5) {
                     scope.List_CUPsGas = result.data;
                 }
                 if (metodo == 6) {
                     scope.List_Puntos_Suministros = result.data;
                 }
             } else {
                 if (metodo == 1) {
                     scope.toast('error','No existen productos asignado a esta Comercializadora.','Comercializadoras');
                     scope.List_Productos = [];
                     scope.List_Anexos = [];
                     scope.contrato_fdatos.CodPro = undefined;
                     scope.contrato_fdatos.CodAnePro = undefined;
                     scope.contrato_fdatos.TipPre = undefined;
                 }
                 if (metodo == 2) {
                     scope.toast('error','No existen anexos asignados a este producto.','productos');
                     scope.List_Anexos = [];
                     scope.contrato_fdatos.CodAnePro = undefined;
                     scope.contrato_fdatos.TipPre = undefined;
                 }
             }
         }, function(error) {
             console.log(error);
              if (error.status == 404 && error.statusText == "Not Found"){
                    scope.toast('error','El método que esté intentando usar no puede ser localizado','Error 404');
                    }if (error.status == 401 && error.statusText == "Unauthorized"){
                        scope.toast('error','Disculpe, Usuario no autorizado para acceder a ester módulo','Error 401');
                    }if (error.status == 403 && error.statusText == "Forbidden"){
                        scope.toast('error','Está intentando utilizar un APIKEY inválido','Error 403');
                    }if (error.status == 500 && error.statusText == "Internal Server Error") {
                    scope.toast('error','Ha ocurrido una falla en el Servidor, intente más tarde','Error 500');
                    }
         });
    }

    scope.siguiente_paso_contrato=function()
    {
        $("#modal_contrato_rapido").modal('hide');
        $("#modal_contrato_rapido_final").modal('show');
        //setTimeout(function(){ $("#modal_contrato_rapido_final").modal('show'); }, 1000);
        //
    }
    scope.anterior_paso_contrato=function()
    {
        $("#modal_contrato_rapido_final").modal('hide');
        $("#modal_contrato_rapido").modal('show');
    }
    $scope.SelectFile = function (e) 
    {
        //scope.AddImagen(e.target.files[0]);
        //console.log(e);
        //alert(e.target.files[0]);
        //console.log(e.target.files[0]);
        scope.AddImagen(e.target.files[0]);
    };
    scope.AddImagen = function(archivo)
    {        
        if (archivo==null){
            $("#subiendo_archivo").removeClass( "loader loader-default is-active" ).addClass("loader loader-default");   
            scope.toast('error','Seleccione otro archivo','Error');
        }
        else
        {
            $("#subiendo_archivo").removeClass("loader loader-default").addClass("loader loader-default is-active");
            formData = new FormData();
            formData.append('file', archivo);
            formData.append('x-api-key', $cookies.get('ApiKey'));
            $.ajax({
                url : base_urlHome()+"api/Activaciones/agregar_documento_contrato/",
                type: "POST",
                data : formData,
                processData: false,
                contentType: false,
                async:false,
                success:function(data,textStatus,jqXHR)
                { 
                        $("#subiendo_archivo").removeClass( "loader loader-default is-active" ).addClass("loader loader-default")                          
                        if(data.status==404 && data.statusText=="Error")
                        {
                            scope.toast('error',data.menssage,data.statusText);
                            return false; 
                        }
                        if(data.status==200 && data.statusText=="OK")
                        {
                            scope.toast('success',data.menssage,data.statusText);
                            scope.imagen = null;
                            document.getElementById('file_fotocopia').value = '';
                            scope.contrato_fdatos.TDocumentosContratos.push({file_ext:data.file_ext,DocGenCom:data.DocGenCom,DocConRut:data.DocConRut}); 
                            console.log(scope.contrato_fdatos.TDocumentosContratos);
                            $scope.$apply();
                            return false; 
                        }
                },              
                error: function(jqXHR, textStatus, errorThrown){
                        $("#subiendo_archivo").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );  
                        console.log(jqXHR);
                        console.log(textStatus);
                        scope.toast('error','Error Subiendo archivo.','Error');
                    }
            });
        }
            
    }
    $scope.submitFormContratos = function(event) 
    {
       
        var titulo = 'Guardando';
        var texto = '¿Seguro de grabar el contrato?';
        var response = 'Contrato registrado de forma correcta';
        if (!scope.validar_campos_contratos()) {
            return false;
        }
       
        console.log(scope.contrato_fdatos);
        Swal.fire({
            title: titulo,
            text: texto,
            type: "question",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: "OK!"
        }).then(function(t) {
            if (t.value == true) {
                $("#" + titulo).removeClass("loader loader-default").addClass("loader loader-default is-active");
                var url=base_urlHome()+"api/Activaciones/Generar_Contrato_Rapido";
                $http.post(url,scope.contrato_fdatos).then(function(result)
                {
                    $("#" + titulo).removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if(result.data!=false)
                    {
                        scope.toast('success','Contrato rapido creado correctamente.','Contrato Rapido');
                        $("#modal_contrato_rapido_final").modal('hide');
                        location.href = "#/Edit_Contrato/"+result.data.CodCli+"/"+result.data.CodConCom+"/"+result.data.CodProCom+"/editar";
                    }
                    else
                    {
                        scope.toast('error','Ocurrio un error al intentar crear el contrato intente nuevamente.','Contrato Rapido');
                    }
                },function(error)
                {
                    $("#" + titulo).removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (error.status == 404 && error.statusText == "Not Found"){
                    scope.toast('error','El método que esté intentando usar no puede ser localizado','Error 404');
                    }if (error.status == 401 && error.statusText == "Unauthorized"){
                        scope.toast('error','Disculpe, Usuario no autorizado para acceder a ester módulo','Error 401');
                    }if (error.status == 403 && error.statusText == "Forbidden"){
                        scope.toast('error','Está intentando utilizar un APIKEY inválido','Error 403');
                    }if (error.status == 500 && error.statusText == "Internal Server Error") {
                    scope.toast('error','Ha ocurrido una falla en el Servidor, intente más tarde','Error 500');
                    }
                });
                
            } else {
                event.preventDefault();
            }
        });
    };
    scope.validar_campos_contratos = function() 
    {
        resultado = true;            
        scope.contrato_fdatos.FecProCom=fecha;
        scope.contrato_fdatos.TipProCom='1';
        scope.contrato_fdatos.CodCon='0';
        scope.contrato_fdatos.PorAhoTot='0.00';
        scope.contrato_fdatos.ImpAhoTot='0.00';
        scope.contrato_fdatos.EstProCom='C';
        scope.crear_array_cups();
        //////////////////////// AQUI VAMOS A VALIDAR LOS CAMPOS DE LA PROPUESTA COMERCIAL PARA EVITAR QUE VALLAN CAMPOS NULL START ///////////////////////////////




        //////////////////////// AQUI VAMOS A VALIDAR LOS CAMPOS DE LA PROPUESTA COMERCIAL PARA EVITAR QUE VALLAN CAMPOS NULL END ////////////////////////////////

        if(scope.contrato_fdatos.TipCups==1)
        {
            if(!scope.contrato_fdatos.CodTarEle>0)
            {
                scope.toast('error','Debe seleccionar una tárifa para poder continuar.','Error');
                return false;
            }            
            if(scope.CanPerEleModalContratoRapido==0)
            {
                scope.toast('error','Debe seleccionar una tárifa que posea cantidad de periodos.','Error');
                return false;
            }
            else if(scope.CanPerEleModalContratoRapido==1)
            {
                if(scope.contrato_fdatos.PotEleConP1==null || scope.contrato_fdatos.PotEleConP1==undefined||scope.contrato_fdatos.PotEleConP1=='')
                {
                    scope.toast('error','Debe indicar la potencia 1.','Error');
                    return false;
                }
                else
                {
                    scope.contrato_fdatos.PotEleConP1=scope.contrato_fdatos.PotEleConP1;
                }
            }
            else if(scope.CanPerEleModalContratoRapido==2)
            {
                if(scope.contrato_fdatos.PotEleConP1==null || scope.contrato_fdatos.PotEleConP1==undefined||scope.contrato_fdatos.PotEleConP1=='')
                {
                    scope.toast('error','Debe indicar la potencia 1.','Error');
                    return false;
                }
                else
                {
                    scope.contrato_fdatos.PotEleConP1=scope.contrato_fdatos.PotEleConP1;
                }
                if(scope.contrato_fdatos.PotEleConP2==null || scope.contrato_fdatos.PotEleConP2==undefined||scope.contrato_fdatos.PotEleConP2=='')
                {
                    scope.toast('error','Debe indicar la potencia 2.','Error');
                    return false;
                }
                else
                {
                    scope.contrato_fdatos.PotEleConP2=scope.contrato_fdatos.PotEleConP2;
                }
            }
            else if(scope.CanPerEleModalContratoRapido==3)
            {
                if(scope.contrato_fdatos.PotEleConP1==null || scope.contrato_fdatos.PotEleConP1==undefined||scope.contrato_fdatos.PotEleConP1=='')
                {
                    scope.toast('error','Debe indicar la potencia 1.','Error');
                    return false;
                }
                else
                {
                    scope.contrato_fdatos.PotEleConP1=scope.contrato_fdatos.PotEleConP1;
                }
                if(scope.contrato_fdatos.PotEleConP2==null || scope.contrato_fdatos.PotEleConP2==undefined||scope.contrato_fdatos.PotEleConP2=='')
                {
                    scope.toast('error','Debe indicar la potencia 2.','Error');
                    return false;
                }
                else
                {
                    scope.contrato_fdatos.PotEleConP2=scope.contrato_fdatos.PotEleConP2;
                }
                if(scope.contrato_fdatos.PotEleConP3==null || scope.contrato_fdatos.PotEleConP3==undefined||scope.contrato_fdatos.PotEleConP3=='')
                {
                    scope.toast('error','Debe indicar la potencia 3.','Error');
                    return false;
                }
                else
                {
                    scope.contrato_fdatos.PotEleConP3=scope.contrato_fdatos.PotEleConP3;
                }
            }
            else if(scope.CanPerEleModalContratoRapido==4)
            {
                if(scope.contrato_fdatos.PotEleConP1==null || scope.contrato_fdatos.PotEleConP1==undefined||scope.contrato_fdatos.PotEleConP1=='')
                {
                    scope.toast('error','Debe indicar la potencia 1.','Error');
                    return false;
                }
                else
                {
                    scope.contrato_fdatos.PotEleConP1=scope.contrato_fdatos.PotEleConP1;
                }
                if(scope.contrato_fdatos.PotEleConP2==null || scope.contrato_fdatos.PotEleConP2==undefined||scope.contrato_fdatos.PotEleConP2=='')
                {
                    scope.toast('error','Debe indicar la potencia 2.','Error');
                    return false;
                }
                else
                {
                    scope.contrato_fdatos.PotEleConP2=scope.contrato_fdatos.PotEleConP2;
                }
                if(scope.contrato_fdatos.PotEleConP3==null || scope.contrato_fdatos.PotEleConP3==undefined||scope.contrato_fdatos.PotEleConP3=='')
                {
                    scope.toast('error','Debe indicar la potencia 3.','Error');
                    return false;
                }
                else
                {
                    scope.contrato_fdatos.PotEleConP3=scope.contrato_fdatos.PotEleConP3;
                }
                if(scope.contrato_fdatos.PotEleConP4==null || scope.contrato_fdatos.PotEleConP4==undefined||scope.contrato_fdatos.PotEleConP4=='')
                {
                    scope.toast('error','Debe indicar la potencia 4.','Error');
                    return false;
                }
                else
                {
                    scope.contrato_fdatos.PotEleConP4=scope.contrato_fdatos.PotEleConP4;
                }
            }
            else if(scope.CanPerEleModalContratoRapido==5)
            {
                if(scope.contrato_fdatos.PotEleConP1==null || scope.contrato_fdatos.PotEleConP1==undefined||scope.contrato_fdatos.PotEleConP1=='')
                {
                    scope.toast('error','Debe indicar la potencia 1.','Error');
                    return false;
                }
                else
                {
                    scope.contrato_fdatos.PotEleConP1=scope.contrato_fdatos.PotEleConP1;
                }
                if(scope.contrato_fdatos.PotEleConP2==null || scope.contrato_fdatos.PotEleConP2==undefined||scope.contrato_fdatos.PotEleConP2=='')
                {
                    scope.toast('error','Debe indicar la potencia 2.','Error');
                    return false;
                }
                else
                {
                    scope.contrato_fdatos.PotEleConP2=scope.contrato_fdatos.PotEleConP2;
                }
                if(scope.contrato_fdatos.PotEleConP3==null || scope.contrato_fdatos.PotEleConP3==undefined||scope.contrato_fdatos.PotEleConP3=='')
                {
                    scope.toast('error','Debe indicar la potencia 3.','Error');
                    return false;
                }
                else
                {
                    scope.contrato_fdatos.PotEleConP3=scope.contrato_fdatos.PotEleConP3;
                }
                if(scope.contrato_fdatos.PotEleConP4==null || scope.contrato_fdatos.PotEleConP4==undefined||scope.contrato_fdatos.PotEleConP4=='')
                {
                    scope.toast('error','Debe indicar la potencia 4.','Error');
                    return false;
                }
                else
                {
                    scope.contrato_fdatos.PotEleConP4=scope.contrato_fdatos.PotEleConP4;
                }
                if(scope.contrato_fdatos.PotEleConP5==null || scope.contrato_fdatos.PotEleConP5==undefined||scope.contrato_fdatos.PotEleConP5=='')
                {
                    scope.toast('error','Debe indicar la potencia 5.','Error');
                    return false;
                }
                else
                {
                    scope.contrato_fdatos.PotEleConP5=scope.contrato_fdatos.PotEleConP5;
                }
            }
            else if(scope.CanPerEleModalContratoRapido==6)
            {
                if(scope.contrato_fdatos.PotEleConP1==null || scope.contrato_fdatos.PotEleConP1==undefined||scope.contrato_fdatos.PotEleConP1=='')
                {
                    scope.toast('error','Debe indicar la potencia 1.','Error');
                    return false;
                }
                else
                {
                    scope.contrato_fdatos.PotEleConP1=scope.contrato_fdatos.PotEleConP1;
                }
                if(scope.contrato_fdatos.PotEleConP2==null || scope.contrato_fdatos.PotEleConP2==undefined||scope.contrato_fdatos.PotEleConP2=='')
                {
                    scope.toast('error','Debe indicar la potencia 2.','Error');
                    return false;
                }
                else
                {
                    scope.contrato_fdatos.PotEleConP2=scope.contrato_fdatos.PotEleConP2;
                }
                if(scope.contrato_fdatos.PotEleConP3==null || scope.contrato_fdatos.PotEleConP3==undefined||scope.contrato_fdatos.PotEleConP3=='')
                {
                    scope.toast('error','Debe indicar la potencia 3.','Error');
                    return false;
                }
                else
                {
                    scope.contrato_fdatos.PotEleConP3=scope.contrato_fdatos.PotEleConP3;
                }
                if(scope.contrato_fdatos.PotEleConP4==null || scope.contrato_fdatos.PotEleConP4==undefined||scope.contrato_fdatos.PotEleConP4=='')
                {
                    scope.toast('error','Debe indicar la potencia 4.','Error');
                    return false;
                }
                else
                {
                    scope.contrato_fdatos.PotEleConP4=scope.contrato_fdatos.PotEleConP4;
                }
                if(scope.contrato_fdatos.PotEleConP5==null || scope.contrato_fdatos.PotEleConP5==undefined||scope.contrato_fdatos.PotEleConP5=='')
                {
                    scope.toast('error','Debe indicar la potencia 5.','Error');
                    return false;
                }
                else
                {
                    scope.contrato_fdatos.PotEleConP5=scope.contrato_fdatos.PotEleConP5;
                }
                if(scope.contrato_fdatos.PotEleConP6==null || scope.contrato_fdatos.PotEleConP6==undefined||scope.contrato_fdatos.PotEleConP6=='')
                {
                    scope.toast('error','Debe indicar la potencia 6.','Error');
                    return false;
                }
                else
                {
                    scope.contrato_fdatos.PotEleConP6=scope.contrato_fdatos.PotEleConP6;
                }
            }
            else
            {
                scope.toast('error','Debe seleccionar una tárifa para poder continuar.','Error');
                return false;
            }
        }
        else
        {
            if(!scope.contrato_fdatos.CodTarGas>0)
            {
                scope.toast('error','Debe seleccionar una tárifa para poder continuar.','Error');
                return false;
            }
            if(scope.contrato_fdatos.Consumo==null || scope.contrato_fdatos.Consumo==undefined|| scope.contrato_fdatos.Consumo=='')
            {
                scope.contrato_fdatos.Consumo=null;
            }
            else
            {
                scope.contrato_fdatos.Consumo=scope.contrato_fdatos.Consumo;
            }
            if(scope.contrato_fdatos.CauDiaGas==null || scope.contrato_fdatos.CauDiaGas==undefined|| scope.contrato_fdatos.CauDiaGas=='')
            {
                scope.contrato_fdatos.CauDiaGas=null;
            }
            else
            {
                scope.contrato_fdatos.CauDiaGas=null;
            }
            scope.contrato_fdatos.PotEleConP1=null;
            scope.contrato_fdatos.PotEleConP2=null;
            scope.contrato_fdatos.PotEleConP3=null;
            scope.contrato_fdatos.PotEleConP4=null;
            scope.contrato_fdatos.PotEleConP5=null;
            scope.contrato_fdatos.PotEleConP6=null; 
        } 
        if(scope.contrato_fdatos.ObsCup==null || scope.contrato_fdatos.ObsCup==undefined|| scope.contrato_fdatos.ObsCup=='')
            {
                scope.contrato_fdatos.ObsCup=null;
            }
            else
            {
                scope.contrato_fdatos.ObsCup=scope.contrato_fdatos.ObsCup;
            }       
            if(!scope.contrato_fdatos.CodCom>0)
            {
                scope.toast('error','Debe seleccionar una Comercializadora.','Error');
                return false;
            }
            if(!scope.contrato_fdatos.CodPro>0)
            {
                scope.toast('error','Debe seleccionar un Producto.','Error');
                return false;
            }
            if(!scope.contrato_fdatos.CodAnePro>0)
            {
                scope.toast('error','Debe seleccionar un Anexo.','Error');
                return false;
            }
            if(!scope.contrato_fdatos.TipPre>0)
            {
                scope.toast('error','Debe seleccionar un Tipo de Precio.','Error');
                return false;
            }
       
        if(scope.contrato_fdatos.ObsCon==null || scope.contrato_fdatos.ObsCon==undefined|| scope.contrato_fdatos.ObsCon=='')
            {
                scope.contrato_fdatos.ObsCon=null;
            }
            else
            {
                scope.contrato_fdatos.ObsCon=scope.contrato_fdatos.ObsCon;
            } 
       
        if (resultado == false) {
            //quiere decir que al menos un renglon no paso la validacion
            return false;
        }
        return true;
    }

    scope.crear_array_cups=function()
    {
        scope.contrato_fdatos.detalleCUPs = [];
        if(scope.contrato_fdatos.CodCupSEle>0)
        {
            scope.contrato_fdatos.RenConEle=false;
            var ObjDetCUPs = new Object();
            if (scope.contrato_fdatos.detalleCUPs == undefined || scope.contrato_fdatos.detalleCUPs == false) {
                scope.contrato_fdatos.detalleCUPs = [];
            }
               if(scope.contrato_fdatos.RenConEle==false)
               {
                    scope.contrato_fdatos.RenConEle=0;
               }
               else
               {
                    scope.contrato_fdatos.RenConEle=1;
               }
                var FecVenCUPs_Ele=document.getElementById("FecVenCUPs_Ele").value;
                var FecActCUPs_Ele=document.getElementById("FecActCUPs_Ele").value;
                if(FecVenCUPs_Ele==undefined ||FecVenCUPs_Ele==null ||FecVenCUPs_Ele=="")
                {
                    scope.FecVenCUPs_Ele=null;
                    var FinalVenCUPs=null;
                }
                else
                {
                    var FecFinalVenCUPs = (FecVenCUPs_Ele).split("/");
                    if (FecFinalVenCUPs.length < 3) 
                    {
                        scope.toast('error','El Formato de Fecha de Vencimiento debe Ser EJ: DD/MM/YYYY.','');
                        event.preventDefault();
                        return false;
                    } 
                    else 
                    {
                        if (FecFinalVenCUPs[0].length > 2 || FecFinalVenCUPs[0].length < 2) {
                             scope.toast('error','Por Favor Corrija el Formato del dia en la Fecha de Vencimiento deben ser 2 números solamente. EJ: 01','');
                             event.preventDefault();
                             return false;
                        }
                        if (FecFinalVenCUPs[1].length > 2 || FecFinalVenCUPs[1].length < 2) {
                            scope.toast('error','Por Favor Corrija el Formato del mes de la Fecha de Vencimiento deben ser 2 números solamente. EJ: 01','');
                           
                            event.preventDefault();
                            return false;
                        }
                        if (FecFinalVenCUPs[2].length < 4 || FecFinalVenCUPs[2].length > 4) {
                             scope.toast('error','Por Favor Corrija el Formato del ano en la Fecha de Vencimiento Ya que deben ser 4 números solamente.','');
                             
                             event.preventDefault();
                             return false;
                        }
                        var FinalVenCUPs=FecFinalVenCUPs[2] + "-" + FecFinalVenCUPs[1] + "-" + FecFinalVenCUPs[0];
                    }
                }
                if(FecActCUPs_Ele==undefined ||FecActCUPs_Ele==null ||FecActCUPs_Ele=="")
                {
                    scope.FecActCUPs_Ele=null;
                    var FinalActCUPs=null;

                }
                else
                {
                    var FecFinalActCUPs = (FecActCUPs_Ele).split("/");
                    if (FecFinalActCUPs.length < 3) 
                    {
                        scope.toast('error','El Formato de Fecha de Activación debe Ser EJ: DD/MM/YYYY.','');
                        event.preventDefault();
                        return false;
                    } 
                    else 
                    {
                        if (FecFinalActCUPs[0].length > 2 || FecFinalActCUPs[0].length < 2) {
                             scope.toast('error','Por Favor Corrija el Formato del dia en la Fecha de Activación deben ser 2 números solamente. EJ: 01','');
                             event.preventDefault();
                             return false;
                        }
                        if (FecFinalActCUPs[1].length > 2 || FecFinalActCUPs[1].length < 2) {
                            scope.toast('error','Por Favor Corrija el Formato del mes de la Fecha de Activación deben ser 2 números solamente. EJ: 01','');
                           
                            event.preventDefault();
                            return false;
                        }
                        if (FecFinalActCUPs[2].length < 4 || FecFinalActCUPs[2].length > 4) {
                             scope.toast('error','Por Favor Corrija el Formato del ano en la Fecha de Activación Ya que deben ser 4 números solamente.','');
                             
                             event.preventDefault();
                             return false;
                        }
                        var FinalActCUPs=FecFinalActCUPs[2] + "-" + FecFinalActCUPs[1] + "-" + FecFinalActCUPs[0];
                    }
                }
               scope.contrato_fdatos.detalleCUPs.push({CodCups:scope.contrato_fdatos.CodCupSEle,CodTar:scope.contrato_fdatos.CodTarEle,
                PotConP1:scope.contrato_fdatos.PotEleConP1,PotConP2:scope.contrato_fdatos.PotEleConP2,PotConP3:scope.contrato_fdatos.PotEleConP3,
                PotConP4:scope.contrato_fdatos.PotEleConP4,PotConP5:scope.contrato_fdatos.PotEleConP5,PotConP6:scope.contrato_fdatos.PotEleConP6,
                ImpAho:'0.00',PorAho:'0.00',RenCon:scope.contrato_fdatos.RenConEle,
                ObsCup:scope.contrato_fdatos.ObsCup,ConCUPs:scope.contrato_fdatos.ConCupsEle,CauDia:null,TipServ:1,FecActCUPs:FinalActCUPs,FecVenCUPs:FinalVenCUPs});
        }
        if (scope.contrato_fdatos.CodCupGas>0) 
        {
            scope.contrato_fdatos.RenConGas=false;
            if(scope.contrato_fdatos.RenConGas==false)
            {
                    scope.contrato_fdatos.RenConGas=0;
            }
            else
            {
                scope.contrato_fdatos.RenConGas=1;
            }            
            var FecVenCUPs_Gas=document.getElementById("FecVenCUPs_Gas").value;
            if(FecVenCUPs_Gas==undefined || FecVenCUPs_Gas==null ||FecVenCUPs_Gas=="" )
            {
                scope.FecVenCUPs_Gas=null;
                var FinalVenCUPsGas=null;
            }
            else
            {
                //scope.FecVenCUPs_Gas=FecVenCUPs_Gas;
                    var FecFinalVenCUPsGas = (FecVenCUPs_Gas).split("/");
                    if (FecFinalVenCUPsGas.length < 3) 
                    {
                        scope.toast('error','El Formato de Fecha de Vencimiento debe Ser EJ: DD/MM/YYYY.','');
                        event.preventDefault();
                        return false;
                    } 
                    else 
                    {
                        if (FecFinalVenCUPsGas[0].length > 2 || FecFinalVenCUPsGas[0].length < 2) {
                             scope.toast('error','Por Favor Corrija el Formato del dia en la Fecha de Vencimiento deben ser 2 números solamente. EJ: 01','');
                             event.preventDefault();
                             return false;
                        }
                        if (FecFinalVenCUPsGas[1].length > 2 || FecFinalVenCUPsGas[1].length < 2) {
                            scope.toast('error','Por Favor Corrija el Formato del mes de la Fecha de Vencimiento deben ser 2 números solamente. EJ: 01','');
                           
                            event.preventDefault();
                            return false;
                        }
                        if (FecFinalVenCUPsGas[2].length < 4 || FecFinalVenCUPsGas[2].length > 4) {
                             scope.toast('error','Por Favor Corrija el Formato del ano en la Fecha de Vencimiento Ya que deben ser 4 números solamente.','');
                             
                             event.preventDefault();
                             return false;
                        }
                        var FinalVenCUPsGas=FecFinalVenCUPsGas[2] + "-" + FecFinalVenCUPsGas[1] + "-" + FecFinalVenCUPsGas[0];
                    }

            }
            console.log(scope.FecVenCUPs_Gas);
            var FecActCUPs_Gas=document.getElementById("FecActCUPs_Gas").value;
            if(FecActCUPs_Gas==undefined || FecActCUPs_Gas==null ||FecActCUPs_Gas=="" )
            {
                scope.FecActCUPs_Gas=null;
                var FinalActCUPsGas=null;
            }
            else
            {
                //scope.FecActCUPs_Gas=FecActCUPs_Gas;
                var FecFinalActCUPsGas = (FecActCUPs_Gas).split("/");
                    if (FecFinalActCUPsGas.length < 3) 
                    {
                        scope.toast('error','El Formato de Fecha de Vencimiento debe Ser EJ: DD/MM/YYYY.','');
                        event.preventDefault();
                        return false;
                    } 
                    else 
                    {
                        if (FecFinalActCUPsGas[0].length > 2 || FecFinalActCUPsGas[0].length < 2) {
                             scope.toast('error','Por Favor Corrija el Formato del dia en la Fecha de Vencimiento deben ser 2 números solamente. EJ: 01','');
                             event.preventDefault();
                             return false;
                        }
                        if (FecFinalActCUPsGas[1].length > 2 || FecFinalActCUPsGas[1].length < 2) {
                            scope.toast('error','Por Favor Corrija el Formato del mes de la Fecha de Vencimiento deben ser 2 números solamente. EJ: 01','');
                           
                            event.preventDefault();
                            return false;
                        }
                        if (FecFinalActCUPsGas[2].length < 4 || FecFinalActCUPsGas[2].length > 4) {
                             scope.toast('error','Por Favor Corrija el Formato del ano en la Fecha de Vencimiento Ya que deben ser 4 números solamente.','');
                             
                             event.preventDefault();
                             return false;
                        }
                        var FinalActCUPsGas=FecFinalActCUPsGas[2] + "-" + FecFinalActCUPsGas[1] + "-" + FecFinalActCUPsGas[0];
                    }
            }
            console.log(scope.FecActCUPs_Gas);
            var ObjDetCUPs = new Object();
            if (scope.contrato_fdatos.detalleCUPs == undefined || scope.contrato_fdatos.detalleCUPs == false) {
                scope.contrato_fdatos.detalleCUPs = [];
            }
            scope.contrato_fdatos.detalleCUPs.push({CodCups:scope.contrato_fdatos.CodCupGas,CodTar:scope.contrato_fdatos.CodTarGas,
                PotConP1:null,PotConP2:null,PotConP3:null,
                PotConP4:null,PotConP5:null,PotConP6:null,
                ImpAho:'0.00',PorAho:'0.00',RenCon:scope.contrato_fdatos.RenConGas,
                ObsCup:scope.contrato_fdatos.ObsCup,ConCUPs:scope.contrato_fdatos.Consumo,CauDia:scope.contrato_fdatos.CauDiaGas,TipServ:2,FecActCUPs:FinalActCUPsGas,FecVenCUPs:FinalVenCUPsGas});
        }        
        console.log(scope.contrato_fdatos.detalleCUPs);
    }
















        var i = -1;
        var toastCount = 0;
        var $toastlast;
        var getMessage = function () {
        var msgs = ['My name is Inigo Montoya. You killed my father. Prepare to die!',
                    '<div><input class="input-small" value="textbox"/>&nbsp;<a href="http://johnpapa.net" target="_blank">This is a hyperlink</a></div><div><button type="button" id="okBtn" class="btn btn-primary">Close me</button><button type="button" id="surpriseBtn" class="btn" style="margin: 0 8px 0 8px">Surprise me</button></div>',
                    'Are you the six fingered man?',
                    'Inconceivable!',
                    'I do not think that means what you think it means.',
                    'Have fun storming the castle!'];
        i++;
        if (i === msgs.length) {
            i = 0;
        }

                return msgs[i];
            };
            var getMessageWithClearButton = function (msg){
                msg = msg ? msg : 'Clear itself?';
                msg += '<br /><br /><button type="button" class="btn clear">Yes</button>';
                return msg;
            };
            $('#closeButton').click(function(){
                if($(this).is(':checked')) {
                    $('#addBehaviorOnToastCloseClick').prop('disabled', false);
                } else {
                    $('#addBehaviorOnToastCloseClick').prop('disabled', true);
                    $('#addBehaviorOnToastCloseClick').prop('checked', false);
                }
            });
            scope.toast=function(status,msg,title)
            {
                var shortCutFunction = status;
                var msg = msg;
                var title = title;
                var $showDuration = 100;
                var $hideDuration = 1000;
                var $timeOut = 800;
                var $extendedTimeOut = 1000;
                var $showEasing = 'swing';
                var $hideEasing = 'linear';
                var $showMethod = 'fadeIn';
                var $hideMethod = "fadeOut";
                var toastIndex = toastCount++;
                var addClear = false;

                toastr.options = {
                    closeButton: true,
                    debug: false,
                    newestOnTop: false,
                    progressBar: true,
                    rtl: false,
                    positionClass: "toast-top-right",
                    preventDuplicates: true,
                    onclick: null
                };

                if ($showDuration.length) {
                    toastr.options.showDuration = parseInt($showDuration);
                }

                if ($hideDuration.length) {
                    toastr.options.hideDuration = parseInt($hideDuration);
                }

                if ($timeOut.length) {
                    toastr.options.timeOut = addClear ? 0 : parseInt($timeOut);
                }

                if ($extendedTimeOut.length) {
                    toastr.options.extendedTimeOut = addClear ? 0 : parseInt($extendedTimeOut);
                }

                if ($showEasing.length) {
                    toastr.options.showEasing = $showEasing;
                }

                if ($hideEasing.length) {
                    toastr.options.hideEasing = $hideEasing;
                }

                if ($showMethod.length) {
                    toastr.options.showMethod = $showMethod;
                }

                if ($hideMethod.length) {
                    toastr.options.hideMethod = $hideMethod;
                }

                if (addClear) {
                    msg = getMessageWithClearButton(msg);
                    toastr.options.tapToDismiss = false;
                }
                if (!msg) {
                    msg = getMessage();
                }
                var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists
                $toastlast = $toast;

                if(typeof $toast === 'undefined'){
                    return;
                }
                if ($toast.find('#okBtn').length) {
                    $toast.delegate('#okBtn', 'click', function () {
                        alert('you clicked me. i was toast #' + toastIndex + '. goodbye!');
                        $toast.remove();
                    });
                }
                if ($toast.find('#surpriseBtn').length) {
                    $toast.delegate('#surpriseBtn', 'click', function () {
                        alert('Surprise! you clicked me. i was toast #' + toastIndex + '. You could perform an action here.');
                    });
                }
                if ($toast.find('.clear').length) {
                    $toast.delegate('.clear', 'click', function () {
                        toastr.clear($toast, { force: true });
                    });
                }
            }
            function getLastToast()
            {
                return $toastlast;
            }
            $('#clearlasttoast').click(function (){
                toastr.clear(getLastToast());
            });
            $('#cleartoasts').click(function () {
                toastr.clear();
            });
    }