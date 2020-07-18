 app.controller('Controlador_Propuestas_Comerciales', ['$http', '$scope', '$filter', '$route', '$interval', '$controller', '$cookies', '$compile', Controlador]);

 function Controlador($http, $scope, $filter, $route, $interval, $controller, $cookies, $compile) {
     var scope = this;
     scope.fdatos = {};
     scope.TPropuesta_Comerciales = [];
     scope.TPropuesta_ComercialesBack = [];
     scope.T_ContratosProRenPen=[];
     scope.select_DetProPenRen=[];
     scope.tmodal_filtros = {};
     scope.CodCli = $route.current.params.CodCli;
     scope.CodConCom = $route.current.params.CodConCom;
     scope.CodProCom = $route.current.params.CodProCom;
     scope.no_editable = $route.current.params.INF;
     scope.Nivel = $cookies.get('nivel');
     scope.CodCli = $cookies.get('CodCli');
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
     ////////////////////////////////////////////////// PARA LOS CONTACTOS START ////////////////////////////////////////////////////////
     console.log($route.current.$$route.originalPath);
     scope.ruta_reportes_pdf_Propuestas = 0;
     scope.ruta_reportes_excel_Propuestas = 0;
     scope.FecProCom = true;
     scope.NifCliente = true;
     scope.CodCli = true;
     scope.CUPsEle = true;
     scope.CUPsGas = true;
     scope.EstPro = true;
     scope.ActPro = true;
     scope.opciones_propuestas = [{ id: 1, nombre: 'VER' }, { id: 2, nombre: 'EDITAR' }];

     scope.regresar_filtro = function() {
         $scope.predicate = 'id';
         $scope.reverse = true;
         $scope.currentPage = 1;
         $scope.order = function(predicate) {
             $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
             $scope.predicate = predicate;
         };
         scope.TPropuesta_Comerciales = scope.TPropuesta_ComercialesBack;
         $scope.totalItems = scope.TPropuesta_Comerciales.length;
         $scope.numPerPage = 50;
         $scope.paginate = function(value) {
             var begin, end, index;
             begin = ($scope.currentPage - 1) * $scope.numPerPage;
             end = begin + $scope.numPerPage;
             index = scope.TPropuesta_Comerciales.indexOf(value);
             return (begin <= index && index < end);
         }
         scope.ruta_reportes_pdf_Propuestas = 0;
         scope.ruta_reportes_excel_Propuestas = 0;
         scope.tmodal_filtros = {};
         scope.RangFec = undefined;
         scope.NumCifCli = undefined;
         scope.CodCliFil = undefined;
         scope.EstProCom = undefined;
     }
     $scope.Consultar_CIF = function(event) {
         if (scope.NumCifCli == undefined || scope.NumCifCli == null || scope.NumCifCli == '') {
             scope.toast('error','l número de CIF del Cliente es requerido','Número de CIF');
             return false;
         }
         $("#NumCifCli").removeClass("loader loader-default").addClass("loader loader-default is-active");
         var url = base_urlHome() + "api/PropuestaComercial/get_valida_datos_clientes/NumCifCli/" + scope.NumCifCli;
         $http.get(url).then(function(result) {
             $("#NumCifCli").removeClass("loader loader-default is-active").addClass("loader loader-default");
             if (result.data != false) {
                 if (result.data.status == false && result.data.statusText == "Error") {
                     scope.toast('error',result.data.menssage,result.data.statusText);
                     return false;
                 }
                 if (result.data.status == true && result.data.statusText == 'Contrato') {
                    $('#modal_add_propuesta').modal('hide');
                    location.href = "#/Renovar_Propuesta_Comercial/" + result.data.Contrato.CodCli + "/" + result.data.Contrato.CodConCom + "/" + result.data.Contrato.CodProCom + "/renovar";
                 }                 
                 if (result.data.status == true && result.data.statusText == 'Propuesta_Nueva') {
                     $("#modal_add_propuesta").modal('hide');
                     location.href = "#/Add_Propuesta_Comercial/" + result.data.CodCli + "/nueva";
                 }
                 if (result.data.status == 200 && result.data.statusText == 'OK') 
                 {                     
                    //$("#modal_add_propuesta").modal('hide');
                    scope.fdatos.ContratosSinProPenRen = [];
                    scope.fdatos.ContratosProRenPen = []; 
                    angular.forEach(result.data.Contratos, function(Contratos)
                    {
                        if(Contratos.ProRenPen==1)
                        {
                           scope.fdatos.ContratosProRenPen.push({CodCli:Contratos.CodCli,CodConCom:Contratos.CodConCom
                            ,CodProCom:Contratos.CodProCom,DocConRut:Contratos.DocConRut,DocGenCom:Contratos.DocGenCom
                            ,DurCon:Contratos.DurCon,EstBajCon:Contratos.EstBajCon,EstRen:Contratos.EstRen
                            ,FecBajCon:Contratos.FecBajCon,FecConCom:Contratos.FecConCom,FecFinCon:Contratos.FecFinCon
                            ,FecIniCon:Contratos.FecIniCon,FecVenCon:Contratos.FecVenCon,JusBajCon:Contratos.JusBajCon
                            ,ObsCon:Contratos.ObsCon,ProRenPen:Contratos.ProRenPen,RefCon:Contratos.RefCon
                            ,RenMod:Contratos.RenMod,UltTipSeg:Contratos.UltTipSeg});                         
                        }
                        else
                        {
                           scope.fdatos.ContratosSinProPenRen.push({CodCli:Contratos.CodCli,CodConCom:Contratos.CodConCom
                            ,CodProCom:Contratos.CodProCom,DocConRut:Contratos.DocConRut,DocGenCom:Contratos.DocGenCom
                            ,DurCon:Contratos.DurCon,EstBajCon:Contratos.EstBajCon,EstRen:Contratos.EstRen
                            ,FecBajCon:Contratos.FecBajCon,FecConCom:Contratos.FecConCom,FecFinCon:Contratos.FecFinCon
                            ,FecIniCon:Contratos.FecIniCon,FecVenCon:Contratos.FecVenCon,JusBajCon:Contratos.JusBajCon
                            ,ObsCon:Contratos.ObsCon,ProRenPen:Contratos.ProRenPen,RefCon:Contratos.RefCon
                            ,RenMod:Contratos.RenMod,UltTipSeg:Contratos.UltTipSeg}); 
                        }
                    }); 
                    console.log(scope.fdatos.ContratosProRenPen);
                    console.log(scope.fdatos.ContratosSinProPenRen);
                    if(scope.fdatos.ContratosProRenPen.length>0)
                    {
                        if(scope.fdatos.ContratosProRenPen.length==1)
                        {
                            $("#modal_add_propuesta").modal('hide');
                            location.href = "#/Renovar_Propuesta_Comercial/" + scope.fdatos.ContratosProRenPen[0].CodCli + "/" + scope.fdatos.ContratosProRenPen[0].CodConCom + "/" + scope.fdatos.ContratosProRenPen[0].CodProCom + "/renovar";
                            return false;
                        }
                        else
                        {
                            $("#modal_contratosProRenPen").modal('show');
                            $("#modal_add_propuesta").modal('hide');
                            scope.T_ContratosProRenPen=scope.fdatos.ContratosProRenPen;
                            //alert('se detectaron mas de un contrato con ProRenPen');
                            scope.toast('info',"Se encontraron "+scope.fdatos.ContratosProRenPen.length+" Contratos Pendientes de Renovación, se le mostrara una lista con los contratos para que eliga cual va a modificar.",'Renovación Pendiente');
                           
                        }
                    }
                    else if(scope.fdatos.ContratosProRenPen.length==0 && scope.fdatos.ContratosSinProPenRen.length>0)
                    {
                        $("#modal_add_propuesta").modal('hide');
                        location.href = "#/Add_Propuesta_Comercial/" + scope.fdatos.ContratosSinProPenRen[0].CodCli + "/nueva";
                        return false;
                    }
                }                 
             } else {
                 scope.toast('error','El número del CIF no se encuentra asignando a ningun cliente.','Error');
             }
         }, function(error) {
             $("#NumCifCli").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
     scope.agregar_ContratoProRenPen=function(index,CodConCom,dato)
     {
        if(scope.Block_Deta==1)
        {
            scope.toast('error','ya ha seleccionado un contrato para la renovación.','Error');
            return false;
        }
        //console.log(index);
        //console.log(dato);
        //console.log(CodConCom);
        scope.select_DetProPenRen[CodConCom]=dato;
        scope.Block_Deta = 1;
        scope.url_location="#/Renovar_Propuesta_Comercial/" + dato.CodCli + "/" + dato.CodConCom + "/" + dato.CodProCom + "/renovar";
        console.log(scope.select_DetProPenRen);
        console.log(scope.Block_Deta);
        console.log(scope.url_location);
     }
     scope.quitar_ContratoProRenPen = function(index, CodConCom, dato) {
        scope.select_DetProPenRen[CodConCom] = false;        
        scope.Block_Deta = 0;
    }
    $scope.SubmitFormContratosProRenPen = function(event) 
    { 
        if(scope.Block_Deta==0)
        {
            scope.toast('error','Debe seleccionar un contrato para poder procesar la renovación.','Error');
            return false;
        }
        Swal.fire({
            title: 'Contrato',
            text: '¿Está seguro de ir a la renovación del contrato.?',
            type: "question",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: "Confirmar"
        }).then(function(t) {
            if (t.value == true) {
               $("#modal_contratosProRenPen").modal('hide');
               location.href=scope.url_location;
            } else {
                console.log('Cancelando Ando...');
                event.preventDefault();
            }
        });
        
                    
    };
     scope.validar_opcion_propuestas = function(index, opcion_select, dato) {
         scope.opcion_select[index] = undefined;
         //console.log('index: '+index);
         //console.log('opcion: '+opcion_select);
         //console.log(dato);
         if (opcion_select == 1) {
             location.href = "#/Ver_Propuesta_Comercial/" + dato.CodProCom + "/ver";
         }
         if (opcion_select == 2) {
             location.href = "#/Edit_Propuesta_Comercial/" + dato.CodProCom + "/editar";
         }
     }
     scope.PropuestasClientesAll = function() {
         $("#PropuestasComerciales").removeClass("loader loader-default").addClass("loader loader-default is-active");
         var url = base_urlHome() + "api/PropuestaComercial/get_list_propuesta_clientes";
         $http.get(url).then(function(result) {
             $("#PropuestasComerciales").removeClass("loader loader-default is-active").addClass("loader loader-default");
             if (result.data != false) {
                 $scope.predicate = 'id';
                 $scope.reverse = true;
                 $scope.currentPage = 1;
                 $scope.order = function(predicate) {
                     $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                     $scope.predicate = predicate;
                 };
                 scope.TPropuesta_Comerciales = result.data;
                 scope.TPropuesta_ComercialesBack = result.data;
                 $scope.totalItems = scope.TPropuesta_Comerciales.length;
                 $scope.numPerPage = 50;
                 $scope.paginate = function(value) {
                     var begin, end, index;
                     begin = ($scope.currentPage - 1) * $scope.numPerPage;
                     end = begin + $scope.numPerPage;
                     index = scope.TPropuesta_Comerciales.indexOf(value);
                     return (begin <= index && index < end);
                 }
             } else {
                
                scope.TPropuesta_Comerciales = [];
                 scope.TPropuesta_ComercialesBack = [];
             }
         }, function(error) {
             $("#PropuestasComerciales").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
     scope.fetchClientes = function(metodo) {
             if (metodo == 1) {
                 var searchText_len = scope.NumCifCli.trim().length;
                 scope.fdatos.NumCifCli = scope.NumCifCli;
                 if (searchText_len > 0) {
                     var url = base_urlHome() + "api/PropuestaComercial/getclientes";
                     $http.post(url, scope.fdatos).then(function(result) {
                             //console.log(result);
                             if (result.data != false) {
                                 scope.searchResult = result.data;
                                 //console.log(scope.searchResult);
                             } else {
                                
                                    scope.searchResult = {};
                                         }
                                     },
                                     function(error) {
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
                             scope.searchResult = {};
                         }
                     }
                     if (metodo == 2) {
                         var searchText_len = scope.NumCifCli.trim().length;
                         scope.fdatos.NumCifCli = scope.NumCifCli;
                         if (searchText_len > 0) {
                             var url = base_urlHome() + "api/PropuestaComercial/getclientes";
                             $http.post(url, scope.fdatos).then(function(result) {
                                 console.log(result);
                                 if (result.data != false) {
                                     scope.searchResult = result.data;
                                     console.log(scope.searchResult);
                                 } else {
                                     scope.searchResult = {};
                                 }
                             }, function(error) {
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
                             scope.searchResult = {};
                         }
                     }


                 }
                 scope.setValue = function(index, $event, result, metodo) {
                     if (metodo == 1) {
                         scope.NumCifCli = scope.searchResult[index].NumCifCli;
                         scope.searchResult = {};
                         $event.stopPropagation();
                     }
                     if (metodo == 2) {
                         scope.CodCliFil = scope.searchResult[index].CodCli;
                         scope.NumCifCli = scope.searchResult[index].NumCifCli;
                         scope.searchResult = {};
                         $event.stopPropagation();
                     }

                 }
                 scope.setValueFilter = function(index, $event, result) {
                     scope.NumCifCli = scope.searchResult[index].NumCifCli;
                     scope.searchResult = {};
                     $event.stopPropagation();
                 }
                 scope.searchboxClicked = function($event) {
                     $event.stopPropagation();
                 }
                 scope.containerClicked = function() {
                     scope.searchResult = {};
                 }
                 $scope.SubmitFormFiltrosPropuestas = function(event) {
                         if (scope.tmodal_filtros.tipo_filtro == 1) {
                             var RangFec1 = document.getElementById("RangFec").value;
                             scope.RangFec = RangFec1;
                             if (scope.RangFec == undefined || scope.RangFec == null || scope.RangFec == '') {
                                scope.toast('error','Debe indicar una fecha para poder aplicar el incorrecto.','Error');
                                return false;
             }
             $scope.predicate = 'id';
                                         $scope.reverse = true;
                                         $scope.currentPage = 1;
                                         $scope.order = function(predicate) {
                                             $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                                             $scope.predicate = predicate;
                                         };
                                         //scope.Tabla_Contacto=result.data;
                                         scope.TPropuesta_Comerciales = $filter('filter')(scope.TPropuesta_ComercialesBack, { FecProCom: scope.RangFec }, true);
                                         $scope.totalItems = scope.TPropuesta_Comerciales.length;
                                         $scope.numPerPage = 50;
                                         $scope.paginate = function(value) {
                                             var begin, end, index;
                                             begin = ($scope.currentPage - 1) * $scope.numPerPage;
                                             end = begin + $scope.numPerPage;
                                             index = scope.TPropuesta_Comerciales.indexOf(value);
                                             return (begin <= index && index < end);
                                         }
                                         scope.ruta_reportes_pdf_Propuestas = scope.tmodal_filtros.tipo_filtro + "/" + scope.RangFec;
                                         scope.ruta_reportes_excel_Propuestas = scope.tmodal_filtros.tipo_filtro + "/" + scope.RangFec;

                                     }
                                     if (scope.tmodal_filtros.tipo_filtro == 2) {
                                         if (scope.CodCliFil == undefined || scope.CodCliFil == null || scope.CodCliFil == '') {
                                             scope.toast('error','Debe buscar un cliente para poder aplicar el filtro.','Error');
                                             return false;
                                         }
                                         $scope.predicate = 'id';
                                         $scope.reverse = true;
                                         $scope.currentPage = 1;
                                         $scope.order = function(predicate) {
                                             $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                                             $scope.predicate = predicate;
                                         };
                                         //scope.Tabla_Contacto=result.data;
                                         scope.TPropuesta_Comerciales = $filter('filter')(scope.TPropuesta_ComercialesBack, { CodCli: scope.CodCliFil }, true);
                                         $scope.totalItems = scope.TPropuesta_Comerciales.length;
                                         $scope.numPerPage = 50;
                                         $scope.paginate = function(value) {
                                             var begin, end, index;
                                             begin = ($scope.currentPage - 1) * $scope.numPerPage;
                                             end = begin + $scope.numPerPage;
                                             index = scope.TPropuesta_Comerciales.indexOf(value);
                                             return (begin <= index && index < end);
                                         }
                                         scope.ruta_reportes_pdf_Propuestas = scope.tmodal_filtros.tipo_filtro + "/" + scope.CodCliFil;
                                         scope.ruta_reportes_excel_Propuestas = scope.tmodal_filtros.tipo_filtro + "/" + scope.CodCliFil;

                                     }
                                     if (scope.tmodal_filtros.tipo_filtro == 3) {
                                         if (!scope.EstProComFil > 0) {
                                             scope.toast('error','Debe seleccionar un estatus para poder aplicar el filtro.','Error');
                                             return false;
                                         }
                                         $scope.predicate = 'id';
                                         $scope.reverse = true;
                                         $scope.currentPage = 1;
                                         $scope.order = function(predicate) {
                                             $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                                             $scope.predicate = predicate;
                                         };
                                         //scope.Tabla_Contacto=result.data;
                                         scope.TPropuesta_Comerciales = $filter('filter')(scope.TPropuesta_ComercialesBack, { EstProCom: scope.EstProComFil }, true);
                                         $scope.totalItems = scope.TPropuesta_Comerciales.length;
                                         $scope.numPerPage = 50;
                                         $scope.paginate = function(value) {
                                             var begin, end, index;
                                             begin = ($scope.currentPage - 1) * $scope.numPerPage;
                                             end = begin + $scope.numPerPage;
                                             index = scope.TPropuesta_Comerciales.indexOf(value);
                                             return (begin <= index && index < end);
                                         }
                                         scope.ruta_reportes_pdf_Propuestas = scope.tmodal_filtros.tipo_filtro + "/" + scope.EstProComFil;
                                         scope.ruta_reportes_excel_Propuestas = scope.tmodal_filtros.tipo_filtro + "/" + scope.EstProComFil;

                                     }

                                 };
                                 scope.FetchPropuestaComerciales = function() {
                                     if (scope.filtrar_search == undefined || scope.filtrar_search == null || scope.filtrar_search == '') {
                                         $scope.predicate = 'id';
                                         $scope.reverse = true;
                                         $scope.currentPage = 1;
                                         $scope.order = function(predicate) {
                                             $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                                             $scope.predicate = predicate;
                                         };
                                         //scope.Tabla_Contacto=result.data;
                                         scope.TPropuesta_Comerciales = scope.TPropuesta_ComercialesBack;
                                         $scope.totalItems = scope.TPropuesta_Comerciales.length;
                                         $scope.numPerPage = 50;
                                         $scope.paginate = function(value) {
                                             var begin, end, index;
                                             begin = ($scope.currentPage - 1) * $scope.numPerPage;
                                             end = begin + $scope.numPerPage;
                                             index = scope.TPropuesta_Comerciales.indexOf(value);
                                             return (begin <= index && index < end);
                                         }
                                         scope.ruta_reportes_pdf_Propuestas = 0;
                                         scope.ruta_reportes_excel_Propuestas = 0;
                                     } else {
                                         
                                        if (scope.filtrar_search.length >= 2) 
                                        {
                                             scope.fdatos.filtrar_search = scope.filtrar_search;
                                             var url = base_urlHome() + "api/PropuestaComercial/getPropuestasFilter";
                                             $http.post(url, scope.fdatos).then(function(result) {
                                                 console.log(result.data);
                                                 if (result.data != false) {
                                                     $scope.predicate = 'id';
                                                     $scope.reverse = true;
                                                     $scope.currentPage = 1;
                                                     $scope.order = function(predicate) {
                                                         $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                                                         $scope.predicate = predicate;
                                                     };
                                                     //scope.Tabla_Contacto=result.data;
                                                     scope.TPropuesta_Comerciales = result.data;
                                                     $scope.totalItems = scope.TPropuesta_Comerciales.length;
                                                     $scope.numPerPage = 50;
                                                     $scope.paginate = function(value) {
                                                         var begin, end, index;
                                                         begin = ($scope.currentPage - 1) * $scope.numPerPage;
                                                         end = begin + $scope.numPerPage;
                                                         index = scope.TPropuesta_Comerciales.indexOf(value);
                                                         return (begin <= index && index < end);
                                                     }
                                                     scope.ruta_reportes_pdf_Propuestas = 4 + "/" + scope.filtrar_search;
                                                     scope.ruta_reportes_excel_Propuestas = 4 + "/" + scope.filtrar_search;
                                                 } else {
                                                     scope.TPropuesta_Comerciales = [];
                                                     scope.ruta_reportes_pdf_Propuestas = 0;
                                                     scope.ruta_reportes_excel_Propuestas = 0;
                                                 }
                                             }, function(error) {
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
                                        else
                                        {
                                            $scope.predicate = 'id';
                                                     $scope.reverse = true;
                                                     $scope.currentPage = 1;
                                                     $scope.order = function(predicate) {
                                                         $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                                                         $scope.predicate = predicate;
                                                     };
                                                     //scope.Tabla_Contacto=result.data;
                                                     scope.TPropuesta_Comerciales = scope.TPropuesta_ComercialesBack;
                                                     $scope.totalItems = scope.TPropuesta_Comerciales.length;
                                                     $scope.numPerPage = 50;
                                                     $scope.paginate = function(value) {
                                                         var begin, end, index;
                                                         begin = ($scope.currentPage - 1) * $scope.numPerPage;
                                                         end = begin + $scope.numPerPage;
                                                         index = scope.TPropuesta_Comerciales.indexOf(value);
                                                         return (begin <= index && index < end);
                                                     }
                                                     scope.ruta_reportes_pdf_Propuestas = 0;
                                                     scope.ruta_reportes_excel_Propuestas = 0;
                                        }
                                     }



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
                'Have fun storming the castle!'
            ];
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

                                 if (scope.CodConCom != undefined) {

                                 } else {
                                     scope.PropuestasClientesAll();
                                 }
                                 ////////////////////////////////////////////////// PARA LOS CONTACTOS END ////////////////////////////////////////////////////////    
                             }