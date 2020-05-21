 app.controller('Controlador_Propuestas_Comerciales', ['$http', '$scope', '$filter', '$route', '$interval', '$controller', '$cookies', '$compile', Controlador]);

 function Controlador($http, $scope, $filter, $route, $interval, $controller, $cookies, $compile) {
     var scope = this;
     scope.fdatos = {};
     scope.TPropuesta_Comerciales = [];
     scope.TPropuesta_ComercialesBack = [];
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
         console.log(event);
         //event.preventDefault();
         if (scope.NumCifCli == undefined || scope.NumCifCli == null || scope.NumCifCli == '') {
             Swal.fire({ title: 'Número de CIF', text: 'El número de CIF del Cliente es requerido', type: "error", confirmButtonColor: "#188ae2" });
             return false;
         }
         $("#NumCifCli").removeClass("loader loader-default").addClass("loader loader-default is-active");
         var url = base_urlHome() + "api/PropuestaComercial/get_valida_datos_clientes/NumCifCli/" + scope.NumCifCli;
         $http.get(url).then(function(result) {
             console.log(result);
             $("#NumCifCli").removeClass("loader loader-default is-active").addClass("loader loader-default");
             if (result.data != false) {
                 if (result.data.status == false && result.data.statusText == "Error") {
                     Swal.fire({ title: result.data.statusText, text: result.data.menssage, type: "error", confirmButtonColor: "#188ae2" });
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
             } else {
                 Swal.fire({ title: "Error", text: "El número del CIF no se encuentra asignando a ningun cliente.", type: "error", confirmButtonColor: "#188ae2" });
             }
         }, function(error) {
             $("#NumCifCli").removeClass("loader loader-default is-active").addClass("loader loader-default");
             if (error.status == 404 && error.statusText == "Not Found") {
                 Swal.fire({ title: "Error 404", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
             }
             if (error.status == 401 && error.statusText == "Unauthorized") {
                 Swal.fire({ title: "Error 401", text: "Usuario no autorizado para acceder a este Módulo", type: "error", confirmButtonColor: "#188ae2" });
             }
             if (error.status == 403 && error.statusText == "Forbidden") {
                 Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY incorrecto", type: "error", confirmButtonColor: "#188ae2" });
             }
             if (error.status == 500 && error.statusText == "Internal Server Error") {
                 Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
             }

         });
     }
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
                 Swal.fire({ title: "Error", text: "No hay Propuestas Comerciales registradas", type: "error", confirmButtonColor: "#188ae2" });
                 scope.TPropuesta_Comerciales = [];
                 scope.TPropuesta_ComercialesBack = [];
             }
         }, function(error) {
             $("#PropuestasComerciales").removeClass("loader loader-default is-active").addClass("loader loader-default");
             if (error.status == 404 && error.statusText == "Not Found") {
                 Swal.fire({ title: "Error 404", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
             }
             if (error.status == 401 && error.statusText == "Unauthorized") {
                 Swal.fire({ title: "Error 401", text: "Usuario no autorizado para acceder a este Módulo", type: "error", confirmButtonColor: "#188ae2" });
             }
             if (error.status == 403 && error.statusText == "Forbidden") {
                 Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY incorrecto", type: "error", confirmButtonColor: "#188ae2" });
             }
             if (error.status == 500 && error.statusText == "Internal Server Error") {
                 Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
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
                             console.log(result);
                             if (result.data != false) {
                                 scope.searchResult = result.data;
                                 console.log(scope.searchResult);
                             } else {
                                 Swal.fire({
                                             title: "Error",
                                             text: "No hay Clientes registrados",
                                             incorrectorror ", confirmButtonColor: "
                                             #188ae2" });
                         scope.searchResult = {};
                                         }
                                     },
                                     function(error) {
                                         if (error.status == 404 && error.statusText == "Not Found") {
                                             Swal.fire({ title: "Error 404", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
                                         }
                                         if (error.status == 401 && error.statusText == "Unauthorized") {
                                             Swal.fire({ title: "Error 401", text: "Disculpe, Usuario no autorizado para acceder a ester módulo", type: "error", confirmButtonColor: "#188ae2" });
                                         }
                                         if (error.status == 403 && error.statusText == "Forbidden") {
                                             Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY incorrecto", type: "error", confirmButtonColor: "#188ae2" });
                                         }
                                         if (error.status == 500 && error.statusText == "Internal Server Error") {
                                             Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
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
                                     Swal.fire({ title: "Error", text: "No hay Clientes registrados", type: "error", confirmButtonColor: "#188ae2" });
                                     scope.searchResult = {};
                                 }
                             }, function(error) {
                                 if (error.status == 404 && error.statusText == "Not Found") {
                                     Swal.fire({ title: "Error 404", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
                                 }
                                 if (error.status == 401 && error.statusText == "Unauthorized") {
                                     Swal.fire({ title: "Error 401", text: "Disculpe, Usuario no autorizado para acceder a ester módulo", type: "error", confirmButtonColor: "#188ae2" });
                                 }
                                 if (error.status == 403 && error.statusText == "Forbidden") {
                                     incorrecto
                                     Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY incorrecto", type: "error", confirmButtonColor: "#188ae2" });
                                 }
                                 if (error.status == 500 && error.statusText == "Internal Server Error") {
                                     Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
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
                                 Swal.fire({
                                         title: "Error",
                                         text: "Debe indicar una fecha para poder aplicar el fincorrecto type: "
                                         error ", confirmButtonColor: "
                                         #188ae2" });
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
                                             Swal.fire({ title: "Error", text: "Debe buscar un cliente para poder aplicar el filtro.", type: "error", confirmButtonColor: "#188ae2" });
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
                                             Swal.fire({ title: "Error", text: "Debe seleccionar un estatus para poder aplicar el filtro.", type: "error", confirmButtonColor: "#188ae2" });
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



                                 if (scope.CodConCom != undefined) {

                                 } else {
                                     scope.PropuestasClientesAll();
                                 }
                                 ////////////////////////////////////////////////// PARA LOS CONTACTOS END ////////////////////////////////////////////////////////    
                             }