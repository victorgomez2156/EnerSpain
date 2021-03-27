 app.controller('Controlador_Clientes', ['$http', '$scope', '$filter', '$route', '$interval', '$controller', '$cookies', '$compile', 'ServiceClientes', 'upload', Controlador])
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
     }).directive('uploaderModel', ["$parse", function($parse) {
         return {
             restrict: 'A',
             link: function(scope, iElement, iAttrs) {
                 iElement.on("change", function(e) {
                     $parse(iAttrs.uploaderModel).assign(scope, iElement[0].files[0]);
                 });
             }
         };
     }])

 .service('upload', ["$http", "$q", function($http, $q) {
     this.uploadFile = function(file, name) {
         var deferred = $q.defer();
         var formData = new FormData();
         //formData.append("name", name);
         formData.append("file", file);
         return $http.post("server.php", formData, {
                 headers: {
                     "Content-type": undefined
                 },
                 transformRequest: angular.identity
             })
             .success(function(res) {
                 deferred.resolve(res);
             })
             .error(function(msg, code) {
                 deferred.reject(msg);
             })
         return deferred.promise;
     }
 }])

 function Controlador($http, $scope, $filter, $route, $interval, $controller, $cookies, $compile, ServiceClientes, upload) {
     var scope = this;
     scope.fdatos = {};
     scope.nID = $route.current.params.ID;
     scope.validate_info = $route.current.params.INF;
     scope.Nivel = $cookies.get('nivel');
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
     scope.index = 0;
     scope.tProvidencias = [];
     scope.tTipoCliente = [];
     scope.tLocalidades = [];
     scope.tComerciales = [];
     scope.tSectores = [];
     scope.tColaboradores = [];
     scope.tTiposVias = [];
     scope.TtiposInmuebles = [];
     scope.tListBanc = [];
     scope.tListBancBack = [];
     scope.tListaContactos = [];
     scope.tActividadesEconomicas = [];
     scope.tActividadesEconomicasBack = [];
     scope.tMotivosBloqueoContacto = [];

     scope.Tclientes = [];
     scope.TclientesBack = [];
    scope.CodCli = true;
     scope.RazSoc = true;
     scope.NumCif = true;
     scope.Tel = true;
     scope.Est = true;
     scope.Acc = true;
     scope.ruta_reportes_pdf = 0;
     scope.ruta_reportes_excel = 0;
     scope.Tclientes = [];
     scope.TclientesBack = [];
     scope.topciones = [{ id: 1, nombre: 'VER' }, { id: 2, nombre: 'EDITAR' }, { id: 3, nombre: 'ACTIVAR' }, { id: 4, nombre: 'SUSPENDER' }];
     scope.Filtro_Clientes = [{ id: 1, nombre: 'TIPO DE CLIENTE' }, { id: 2, nombre: 'SECTOR' }, { id: 3, nombre: 'PROVINCIA FISCAL' }, { id: 4, nombre: 'LOCALIDAD FISCAL' }, { id: 5, nombre: 'COMERCIAL' }, { id: 6, nombre: 'COLABORADOR' }, { id: 7, nombre: 'ESTATUS CLIENTE' }];
     scope.tmodal_data = {};
     scope.fdatos.misma_razon = false;
     console.log($route.current.$$route.originalPath);
     ////////////////////////////////////////////////// PARA LA LISTA Y CONFIGURACIONES DE SERVICIOS ESPECIALES START ////////////////////////////////////////////////////////
     ServiceClientes.getAll().then(function(dato) {
        
        if(dato.Clientes==false)
        {
            scope.Tclientes = [];
            scope.TclientesBack = []; 
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
            scope.Tclientes = dato.Clientes;
            scope.TclientesBack = dato.Clientes;
            $scope.totalItems = scope.Tclientes.length;
            $scope.numPerPage = 50;
            $scope.paginate = function(value) {
                var begin, end, index;
                begin = ($scope.currentPage - 1) * $scope.numPerPage;
                end = begin + $scope.numPerPage;
                index = scope.Tclientes.indexOf(value);
                return (begin <= index && index < end);
            };
        }
        scope.fecha_server = dato.Fecha_Server;
     }).catch(function(err) { console.log(err); });

     ////////////////////////////////////////////////////////////// MODULO CLIENTES DATOS BASICOS START ////////////////////////////////////////////////////////////////////

     scope.cargar_lista_clientes = function() {
        
        /*$("#List_Cli").removeClass("loader loader-default").addClass("loader loader-default  is-active");
         var url = 'http://192.168.1.100:8782/EnerSpain-ws/Clientes';
         $http.get(url).then(function(result)
         {$("#List_Cli").removeClass("loader loader-default is-active").addClass("loader loader-default");
            
            console.log(result);
         },function(error)
         {
            console.log(error);
            $("#List_Cli").removeClass("loader loader-default is-active").addClass("loader loader-default");
              if (error.status == 404 && error.statusText == "Not Found"){
                                        scope.toast('error','El método que esté intentando usar no puede ser localizado','Error 404');
                                        }if (error.status == 401 && error.statusText == "Unauthorized"){
                                            scope.toast('error','Disculpe, Usuario no autorizado para acceder a ester módulo','Error 401');
                                        }if (error.status == 403 && error.statusText == "Forbidden"){
                                            scope.toast('error','Está intentando utilizar un APIKEY inválido','Error 403');
                                        }if (error.status == 500 && error.statusText == "Internal Server Error") {
                                        scope.toast('error','Ha ocurrido una falla en el Servidor, intente más tarde','Error 500');
                                        }

         });*/
         $("#List_Cli").removeClass("loader loader-default").addClass("loader loader-default  is-active");
         var url = base_urlHome() + "api/Clientes/list_clientes/";
         $http.get(url).then(function(result) {
             $("#List_Cli").removeClass("loader loader-default is-active").addClass("loader loader-default");
             if (result.data != false) {
                 $scope.predicate = 'id';
                 $scope.reverse = true;
                 $scope.currentPage = 1;
                 $scope.order = function(predicate) {
                     $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                     $scope.predicate = predicate;
                 };
                 scope.Tclientes = result.data;
                 scope.TclientesBack = result.data;
                 $scope.totalItems = scope.Tclientes.length;
                 $scope.numPerPage = 50;
                 $scope.paginate = function(value) {
                     var begin, end, index;
                     begin = ($scope.currentPage - 1) * $scope.numPerPage;
                     end = begin + $scope.numPerPage;
                     index = scope.Tclientes.indexOf(value);
                     return (begin <= index && index < end);
                 };
             } else {
                 
                 scope.Tclientes = [];
                 scope.TclientesBack = [];
             }
         }, function(error) {
             $("#List_Cli").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
     scope.modal_cif_cliente = function() {
         $("#modal_cif_cliente").modal('show');
         scope.Clientes_CIF = undefined;
     }

     $scope.Consultar_CIF_Clientes = function(event) {

            if (!scope.validarNIFDNI()) {
               return false;
            }

         if (scope.fdatos.Clientes_CIF == undefined || scope.fdatos.Clientes_CIF == null || scope.fdatos.Clientes_CIF == '') {
             scope.toast('error','El campo CIF es requerido','Error');
             return false;
         } else {
             $("#NumCifCli").removeClass("loader loader-default").addClass("loader loader-default  is-active");
             var url = base_urlHome() + "api/Clientes/comprobar_cif_existente/";
             $http.post(url, scope.fdatos).then(function(result) {
                 $("#NumCifCli").removeClass("loader loader-default is-active").addClass("loader loader-default");
                 if (result.data != false) {
                     scope.toast('error','Ya existe un Cliente registrado con el mismo CIF','Error');                     
                 } else {
                     $("#modal_cif_cliente").modal('hide');
                     scope.toast('success','El Número de CIF se encuentra disponible.','Disponible');
                     $cookies.put('CIF', scope.fdatos.Clientes_CIF);
                     location.href = "#/Datos_Basicos_Clientes/";
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
     };

     $scope.SubmitFormFiltrosClientes = function(event) {
         if (scope.tmodal_data.tipo_filtro == 1) {
             if (!scope.tmodal_data.CodTipCliFil > 0) {
                 scope.toast('error','Seleccione el Tipo de Cliente','Error');
                 return false;
             }
             $scope.predicate = 'id';
             $scope.reverse = true;
             $scope.currentPage = 1;
             $scope.order = function(predicate) {
                 $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                 $scope.predicate = predicate;
             };
             scope.Tclientes = $filter('filter')(scope.TclientesBack, { CodTipCli: scope.tmodal_data.CodTipCliFil }, true);
             $scope.totalItems = scope.Tclientes.length;
             $scope.numPerPage = 50;
             $scope.paginate = function(value) {
                 var begin, end, index;
                 begin = ($scope.currentPage - 1) * $scope.numPerPage;
                 end = begin + $scope.numPerPage;
                 index = scope.Tclientes.indexOf(value);
                 return (begin <= index && index < end);
             };
             scope.ruta_reportes_pdf = scope.tmodal_data.tipo_filtro + '/' + scope.tmodal_data.CodTipCliFil;
             scope.ruta_reportes_excel = scope.tmodal_data.tipo_filtro + '/' + scope.tmodal_data.CodTipCliFil;
         }
         if (scope.tmodal_data.tipo_filtro == 2) {
             if (!scope.tmodal_data.CodSecCliFil > 0) {
                 scope.toast('error','Seleccione el Sector','Error');
                 return false;
             }
             $scope.predicate = 'id';
             $scope.reverse = true;
             $scope.currentPage = 1;
             $scope.order = function(predicate) {
                 $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                 $scope.predicate = predicate;
             };
             scope.Tclientes = $filter('filter')(scope.TclientesBack, { CodSecCli: scope.tmodal_data.CodSecCliFil }, true);
             $scope.totalItems = scope.Tclientes.length;
             $scope.numPerPage = 50;
             $scope.paginate = function(value) {
                 var begin, end, index;
                 begin = ($scope.currentPage - 1) * $scope.numPerPage;
                 end = begin + $scope.numPerPage;
                 index = scope.Tclientes.indexOf(value);
                 return (begin <= index && index < end);
             };
             scope.ruta_reportes_pdf = scope.tmodal_data.tipo_filtro + '/' + scope.tmodal_data.CodSecCliFil;
             scope.ruta_reportes_excel = scope.tmodal_data.tipo_filtro + '/' + scope.tmodal_data.CodSecCliFil;
         }
         if (scope.tmodal_data.tipo_filtro == 3) {
             //$("#CodPro").removeClass( "col-sm-6" ).addClass( "col-sm-12");
             if (!scope.tmodal_data.CodPro > 0) {
                 scope.toast('error','Seleccione Provincia','Error');
                 return false;
             }
             $scope.predicate = 'id';
             $scope.reverse = true;
             $scope.currentPage = 1;
             $scope.order = function(predicate) {
                 $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                 $scope.predicate = predicate;
             };
             scope.Tclientes = $filter('filter')(scope.TclientesBack, { CodProFis: scope.tmodal_data.CodPro }, true);
             $scope.totalItems = scope.Tclientes.length;
             $scope.numPerPage = 50;
             $scope.paginate = function(value) {
                 var begin, end, index;
                 begin = ($scope.currentPage - 1) * $scope.numPerPage;
                 end = begin + $scope.numPerPage;
                 index = scope.Tclientes.indexOf(value);
                 return (begin <= index && index < end);
             };
             scope.ruta_reportes_pdf = scope.tmodal_data.tipo_filtro + '/' + scope.tmodal_data.CodPro;
             scope.ruta_reportes_excel = scope.tmodal_data.tipo_filtro + '/' + scope.tmodal_data.CodPro;
         }
         if (scope.tmodal_data.tipo_filtro == 4) {
             if (!scope.tmodal_data.CodPro > 0) {
                 scope.toast('error','Seleccione Provincia','Error');
                 return false;
             }
             if (!scope.tmodal_data.CodLocFil > 0) {
                 scope.toast('error','Seleccione Localidad','Error');
                  return false;
             }
             $scope.predicate = 'id';
             $scope.reverse = true;
             $scope.currentPage = 1;
             $scope.order = function(predicate) {
                 $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                 $scope.predicate = predicate;
             };
             scope.Tclientes = $filter('filter')(scope.TclientesBack, { CodProFis: scope.tmodal_data.CodPro, CodLocFis: scope.tmodal_data.CodLocFil }, true);
             $scope.totalItems = scope.Tclientes.length;
             $scope.numPerPage = 50;
             $scope.paginate = function(value) {
                 var begin, end, index;
                 begin = ($scope.currentPage - 1) * $scope.numPerPage;
                 end = begin + $scope.numPerPage;
                 index = scope.Tclientes.indexOf(value);
                 return (begin <= index && index < end);
             };
             scope.ruta_reportes_pdf = scope.tmodal_data.tipo_filtro + '/' + scope.tmodal_data.CodPro + '/' + scope.tmodal_data.CodLocFil;
             scope.ruta_reportes_excel = scope.tmodal_data.tipo_filtro + '/' + scope.tmodal_data.CodPro + '/' + scope.tmodal_data.CodLocFil;
         }
         if (scope.tmodal_data.tipo_filtro == 5) {
             if (!scope.tmodal_data.CodCom > 0) {
                 scope.toast('error','Seleccione Comercial','Error');
                 return false;
             }
             $scope.predicate = 'id';
             $scope.reverse = true;
             $scope.currentPage = 1;
             $scope.order = function(predicate) {
                 $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                 $scope.predicate = predicate;
             };
             scope.Tclientes = $filter('filter')(scope.TclientesBack, { CodCom: scope.tmodal_data.CodCom }, true);
             $scope.totalItems = scope.Tclientes.length;
             $scope.numPerPage = 50;
             $scope.paginate = function(value) {
                 var begin, end, index;
                 begin = ($scope.currentPage - 1) * $scope.numPerPage;
                 end = begin + $scope.numPerPage;
                 index = scope.Tclientes.indexOf(value);
                 return (begin <= index && index < end);
             };
             scope.ruta_reportes_pdf = scope.tmodal_data.tipo_filtro + '/' + scope.tmodal_data.CodCom;
             scope.ruta_reportes_excel = scope.tmodal_data.tipo_filtro + '/' + scope.tmodal_data.CodCom;
         }
         if (scope.tmodal_data.tipo_filtro == 6) {
             if (!scope.tmodal_data.CodCol > 0) {
                 scope.toast('error','Seleccione Colaborador','Error');
                 return false;
             }
             $scope.predicate = 'id';
             $scope.reverse = true;
             $scope.currentPage = 1;
             $scope.order = function(predicate) {
                 $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                 $scope.predicate = predicate;
             };
             scope.Tclientes = $filter('filter')(scope.TclientesBack, { CodCol: scope.tmodal_data.CodCol }, true);
             $scope.totalItems = scope.Tclientes.length;
             $scope.numPerPage = 50;
             $scope.paginate = function(value) {
                 var begin, end, index;
                 begin = ($scope.currentPage - 1) * $scope.numPerPage;
                 end = begin + $scope.numPerPage;
                 index = scope.Tclientes.indexOf(value);
                 return (begin <= index && index < end);
             };
             scope.ruta_reportes_pdf = scope.tmodal_data.tipo_filtro + '/' + scope.tmodal_data.CodCol;
             scope.ruta_reportes_excel = scope.tmodal_data.tipo_filtro + '/' + scope.tmodal_data.CodCol;
         }
         if (scope.tmodal_data.tipo_filtro == 7) {
             if (!scope.tmodal_data.EstCliFil > 0) {
                 scope.toast('error','Seleccione Estatus','Error');
                 return false;
             }
             $scope.predicate = 'id';
             $scope.reverse = true;
             $scope.currentPage = 1;
             $scope.order = function(predicate) {
                 $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                 $scope.predicate = predicate;
             };
             scope.Tclientes = $filter('filter')(scope.TclientesBack, { EstCli: scope.tmodal_data.EstCliFil }, true);
             $scope.totalItems = scope.Tclientes.length;
             $scope.numPerPage = 50;
             $scope.paginate = function(value) {
                 var begin, end, index;
                 begin = ($scope.currentPage - 1) * $scope.numPerPage;
                 end = begin + $scope.numPerPage;
                 index = scope.Tclientes.indexOf(value);
                 return (begin <= index && index < end);
             };
             scope.ruta_reportes_pdf = scope.tmodal_data.tipo_filtro + '/' + scope.tmodal_data.EstCliFil;
             scope.ruta_reportes_excel = scope.tmodal_data.tipo_filtro + '/' + scope.tmodal_data.EstCliFil;
         }
     };
     scope.regresar_filtro_clientes = function() {
         scope.tmodal_data = {};
         $scope.predicate = 'id';
         $scope.reverse = true;
         $scope.currentPage = 1;
         $scope.order = function(predicate) {
             $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
             $scope.predicate = predicate;
         };
         scope.Tclientes = scope.TclientesBack;
         $scope.totalItems = scope.Tclientes.length;
         $scope.numPerPage = 50;
         $scope.paginate = function(value) {
             var begin, end, index;
             begin = ($scope.currentPage - 1) * $scope.numPerPage;
             end = begin + $scope.numPerPage;
             index = scope.Tclientes.indexOf(value);
             return (begin <= index && index < end);
         };
         scope.tmodal_data.tipo_filtro = 0;
         scope.tmodal_data.CodPro = undefined;
         scope.tmodal_data.CodLocFil = undefined;
         scope.tmodal_data.CodTipCliFil = undefined;
         scope.tmodal_data.EstCliFil = undefined;
         scope.ruta_reportes_pdf = 0;
         scope.ruta_reportes_excel = 0;
     }

     scope.validar_opcion = function(index, opcion, datos) {
         console.log(opcion);
         console.log(datos);
         scope.opciones_clientes[index] = undefined;
         if (opcion == 1) {
             location.href = "#/Edit_Datos_Basicos_Clientes/" + datos.CodCli + "/" + 1;
         }
         if (opcion == 2) {
             location.href = "#/Edit_Datos_Basicos_Clientes/" + datos.CodCli;
         }
         if (opcion == 3) {
             if (datos.EstCli == 1) {
                scope.toast('error','El Cliente ya se encuentra activo','');
                return false;
             }
             Swal.fire({
                 title: "¿Seguro que desea activar el Cliente?",
                 type: "info",
                 showCancelButton: !0,
                 confirmButtonColor: "#31ce77",
                 cancelButtonColor: "#f34943",
                 confirmButtonText: "Confirmar"
             }).then(function(t) {
                 if (t.value == true) {
                     scope.datos_update = {};
                     scope.datos_update.opcion = 1;
                     scope.datos_update.hcliente = datos.CodCli;
                     var url = base_urlHome() + "api/Clientes/update_status/";
                     $http.post(url, scope.datos_update).then(function(result) {
                         if (result.data != false) {
                             scope.toast('success','El Cliente ha sido activado de forma correcta','');
                             scope.cargar_lista_clientes();
                         } else {
                             scope.toast('error','Ha ocurrido un error, intente nuevamente','');
                             scope.cargar_lista_clientes();
                         }
                     }, function(error) {
                         $("#comprobando_disponibilidad").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
                     console.log('Cancelando ando...');
                 }
             });
         }
         if (opcion == 4) {
             if (datos.EstCli == 2) {
                 scope.toast('error','Ya este cliente se encuentra suspendido.','Error');
                 return false;
             }
             scope.tmodal_data = {};
             scope.tmodal_data.CodCli = datos.CodCli;
             scope.tmodal_data.NumCif = datos.NumCifCli;
             scope.FechBlo = scope.fecha_server;
             $('.datepicker').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.FechBlo);
             scope.tmodal_data.RazSoc = datos.RazSocCli;
             scope.cargar_lista_motivos_bloqueos();
         }
     }

     scope.cargar_lista_motivos_bloqueos = function() {
         var url = base_urlHome() + "api/Clientes/Motivos_Bloqueos/";
         $http.get(url).then(function(result) {
             if (result.data != false) {
                 $("#modal_motivo_bloqueo").modal('show');
                 scope.tMotivosBloqueos = result.data;
             } else {
                 scope.toast('error','No hay Motivos de Suspensión registrados','Error');
                
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

     $scope.submitFormlock = function(event) {
         var FechBlo = document.getElementById("FechBlo").value;
         scope.FechBlo = FechBlo;
         if (scope.FechBlo == undefined || scope.FechBlo == null || scope.FechBlo == '') {
             scope.toast('error','La Fecha de Suspensión es requerida','');
             event.preventDefault();
             return false;
         } else {
             var FechBlo = (scope.FechBlo).split("/");
             if (FechBlo.length < 3) {
                 scope.toast('error','El dormato de Fecha de Suspensión debe ser DD/MM/YYYY','');
                 event.preventDefault();
                 return false;
             } else {
                 if (FechBlo[0].length > 2 || FechBlo[0].length < 2) {
                     scope.toast('error','Error en Día, debe introducir dos números','');
                     event.preventDefault();
                     return false;
                 }
                 if (FechBlo[1].length > 2 || FechBlo[1].length < 2) {
                     scope.toast('error','Error en Mes, debe introducir dos números','');
                     event.preventDefault();
                     return false;
                 }
                 if (FechBlo[2].length < 4 || FechBlo[2].length > 4) {
                     scope.toast('error','Error en Año, debe introducir cuatro números','');
                     event.preventDefault();
                     return false;
                 }
                 valuesStart = scope.FechBlo.split("/");
                 valuesEnd = scope.fecha_server.split("/");
                 // Verificamos que la fecha no sea posterior a la actual
                 var dateStart = new Date(valuesStart[2], (valuesStart[1] - 1), valuesStart[0]);
                 var dateEnd = new Date(valuesEnd[2], (valuesEnd[1] - 1), valuesEnd[0]);
                 if (dateStart > dateEnd) {
                     scope.toast('error',"La Fecha de Suspensión no puede ser mayor a" + scope.fecha_server + "verifique e intente nuevamente",'');
                     //Swal.fire({ text: , type: "error", confirmButtonColor: "#188ae2" });
                     return false;
                 }
                 scope.tmodal_data.FechBlo = scope.FechBlo;
             }
         }
         Swal.fire({
             title: "¿Seguro que desea suspender el Cliente?",
             type: "info",
             showCancelButton: !0,
             confirmButtonColor: "#31ce77",
             cancelButtonColor: "#f34943",
             confirmButtonText: "Confirmar"
         }).then(function(t) {
             if (t.value == true) {
                 scope.datos_update = {};
                 scope.datos_update.opcion = 2;
                 scope.datos_update.hcliente = scope.tmodal_data.CodCli;
                 scope.datos_update.CodMotBloCli = scope.tmodal_data.MotBloq;
                 scope.datos_update.FechBlo = scope.tmodal_data.FechBlo;
                 if (scope.tmodal_data.ObsBloCli == undefined || scope.tmodal_data.ObsBloCli == null || scope.tmodal_data.ObsBloCli == '') {
                     scope.datos_update.ObsBloCli = null;
                 } else {
                     scope.datos_update.ObsBloCli = scope.tmodal_data.ObsBloCli;
                 }

                 console.log(scope.datos_update);
                 var url = base_urlHome() + "api/Clientes/update_status/";
                 $http.post(url, scope.datos_update).then(function(result) {
                     if (result.data != false) {
                         $("#modal_motivo_bloqueo").modal('hide');
                         scope.toast('error','El Cliente ha sido suspendido de forma correcta','Procesado');
                          scope.cargar_lista_clientes();
                     } else {
                         scope.toast('error','Ha ocurrido un error, intente nuevamente','Error');
                         scope.cargar_lista_clientes();
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
                 event.preventDefault();
                 console.log('Cancelando ando...');
             }
         });
     };
     scope.validar_fecha_blo = function(object) {
         console.log(object);
         if (object != undefined) {
             numero = object;
             if (!/^([/0-9])*$/.test(numero))
                 scope.FechBlo = numero.substring(0, numero.length - 1);
         }
     }
     scope.filtrar_loca = function() {
         scope.TLocalidadesfiltrada = $filter('filter')(scope.tLocalidades, { DesPro: scope.tmodal_data.CodPro }, true);
         console.log(scope.TLocalidadesfiltrada);
     }
     scope.fetchClientesFilter = function() {
         if (scope.filtrar_clientes == undefined || scope.filtrar_clientes == null || scope.filtrar_clientes == '') {

             $scope.predicate = 'id';
             $scope.reverse = true;
             $scope.currentPage = 1;
             $scope.order = function(predicate) {
                 $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                 $scope.predicate = predicate;
             };
             scope.Tclientes = scope.TclientesBack;
             $scope.totalItems = scope.Tclientes.length;
             $scope.numPerPage = 50;
             $scope.paginate = function(value) {
                 var begin, end, index;
                 begin = ($scope.currentPage - 1) * $scope.numPerPage;
                 end = begin + $scope.numPerPage;
                 index = scope.Tclientes.indexOf(value);
                 return (begin <= index && index < end);
             };
             scope.ruta_reportes_pdf = 0;
             scope.ruta_reportes_excel = 0;

         } else {
             if (scope.filtrar_clientes.length >= 2) {
                 scope.fdatos.filtrar_clientes = scope.filtrar_clientes;
                 console.log(scope.fdatos.filtrar_clientes);
                 var url = base_urlHome() + "api/Clientes/getClientesFilter";
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
                         scope.Tclientes = result.data;
                         $scope.totalItems = scope.Tclientes.length;
                         $scope.numPerPage = 50;
                         $scope.paginate = function(value) {
                             var begin, end, index;
                             begin = ($scope.currentPage - 1) * $scope.numPerPage;
                             end = begin + $scope.numPerPage;
                             index = scope.Tclientes.indexOf(value);
                             return (begin <= index && index < end);
                         };
                         scope.ruta_reportes_pdf = 8 + "/" + scope.filtrar_clientes;
                         scope.ruta_reportes_excel = 8 + "/" + scope.filtrar_clientes;
                     } else {
                         scope.toast('error','No hay clientes registrados','Error');
                         scope.Tclientes =[];
                    scope.ruta_reportes_pdf = 0;
                    scope.ruta_reportes_excel = 0;
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
                         scope.Tclientes = scope.TclientesBack;
                         $scope.totalItems = scope.Tclientes.length;
                         $scope.numPerPage = 50;
                         $scope.paginate = function(value) {
                             var begin, end, index;
                             begin = ($scope.currentPage - 1) * $scope.numPerPage;
                             end = begin + $scope.numPerPage;
                             index = scope.Tclientes.indexOf(value);
                             return (begin <= index && index < end);
                         };
                         scope.ruta_reportes_pdf = 0;
                         scope.ruta_reportes_excel = 0;
             }
         }
     }
     scope.RealizarConsulta=function(metodo)
     {        
        console.log(metodo);
        $("#carganto_servicio").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active");
        var url=base_urlHome()+"api/Clientes/RealizarConsultaFiltros/metodo/"+metodo;
        $http.get(url).then(function(result)
        {
            $("#carganto_servicio").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default");
            if(result.data!=false)
            {
                if(metodo==1)
                {
                    scope.tTipoCliente=result.data;
                    scope.metodo=undefined;
                }
                else if(metodo==2)
                {
                    scope.tSectores=result.data;
                    scope.metodo=undefined;
                }
                else if(metodo==3)
                {
                    scope.tProvidencias=result.data;
                    scope.metodo=undefined;
                }
                else if(metodo==4)
                {
                    scope.tProvidencias=[];
                    scope.tmodal_data.CodPro=undefined;
                    scope.TLocalidadesfiltrada=[];
                    scope.metodo=4;
                    scope.tProvidencias=result.data;
                }
                else if(metodo==5)
                {
                    scope.tComerciales=result.data;
                    scope.metodo=undefined;
                }
                else if(metodo==6)
                {
                    scope.tColaboradores=result.data;
                    scope.metodo=undefined;
                }
            }
            else // 99999999
            {
                if(metodo==1)
                {
                    scope.tTipoCliente=[];
                    scope.toast('error','No se encontraron tipos de clientes registrados.','Error');
                    
                }
                else if(metodo==2)
                {
                    scope.tSectores=[];
                    scope.toast('error','No se encontraron Sectores registrados.','Error');
                }
                else if(metodo==3)
                {
                    scope.tProvidencias=[];
                    scope.toast('error','No se encontraron Sectores registrados.','Error');
                }
                else if(metodo==4)
                {
                    scope.tProvidencias=[];
                    scope.TLocalidadesfiltrada=[];
                    scope.toast('error','No se encontraron Sectores registrados.','Error');
                }
            }
        },function(error)
        {
            $("#carganto_servicio").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default");
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
    scope.BuscarLocalidad=function(CodPro)
    {
        console.log(scope.metodo);
        console.log(scope.tmodal_data.CodPro);
        console.log(scope.tProvidencias);

        for (var i = 0; i < scope.tProvidencias.length; i++) 
        {
            if (scope.tProvidencias[i].DesPro == CodPro) 
            {
                console.log(scope.tProvidencias[i].CodPro);
                scope.CodPro=scope.tProvidencias[i].CodPro;
                console.log(scope.CodPro);
            }
        }
        if(scope.metodo==4)
        {
            var url = base_urlHome()+"api/Clientes/BuscarLocalidadesFil/CodPro/"+scope.CodPro;
            $http.get(url).then (function(result)
            {
                if(result.data!=false)
                {
                    scope.TLocalidadesfiltrada=result.data;
                }
                else
                {
                   scope.toast('error','No hemos encontrado Localidades asignada a esta Provincia','Error');
                   scope.TLocalidadesfiltrada=[];
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
    }



    //////// PARA CALCULAR DNI/NIE START /////////////////
    scope.validarNIFDNI = function() 
    {
           var letter = scope.validar_dni_nie($("#CliDNI").parent(), $("#CliDNI").val());
           console.log(letter[0]);
           if(letter[0].status==200&&letter[0].statusText=='OK'&&letter[0].menssage=="DNI")
           {
            scope.dni_nie_validar = scope.fdatos.Clientes_CIF.substring(0,8)+letter[0].letter;
            if(scope.dni_nie_validar!=scope.fdatos.Clientes_CIF)
            {
             scope.toast('error',"El Número de DNI/NIE es Invalido Intente Nuevamente.",'');
             return false;
             }
             else
             {
                return true;
            } 
            }
            else if(letter[0].status==200&&letter[0].statusText=='OK'&&letter[0].menssage=="CIF")
            {
                scope.dni_nie_validar = scope.fdatos.Clientes_CIF.substring(0,8)+letter[0].letter;
                if(scope.dni_nie_validar!=scope.fdatos.Clientes_CIF)
                {
                 scope.toast('error',"El Número de CIF es Invalido Intente Nuevamente.",'');
                 return false;
             }
             else
             {
                return true;
            } 
            }
            else if(letter[0].status==200&&letter[0].statusText=='OK'&&letter[0].menssage=="No CIF/DNI")
            {
             return true;
            }
            else
            {
            scope.toast('error',"Error en Calculo de CIF/DNI/NIF/NIE.",'');
            return false;
            }  
    }

    function isNumeric(expression) 
    {
        return (String(expression).search(/^\d+$/) != -1);
    }
    function calculateLetterForDni(dni)
    {
        // Letras en funcion del modulo de 23
        string = "TRWAGMYFPDXBNJZSQVHLCKE"
        // se obtiene la posiciÃ³n de la cadena anterior
        position = dni % 23
        // se extrae dicha posiciÃ³n de la cadena
        letter = string.substring(position, position + 1)
        return letter
    }
    scope.validar_dni_nie=function(field, txt)
    {
        var letter = ""
        // Si es un dni extrangero, es decir, empieza por X, Y, Z
        // Si la longitud es 8 longitud total de los dni nacionales)
        if (txt.length == 9) 
        {
          var first = txt.substring(0, 1)
          var last = txt.substring(8,9)
            if (first == 'X' || first == 'Y' || first == 'Z') 
            {               
                // Si la longitud es 9(longitud total de los dni extrangeros)
                // Se calcula la letra para el numero de dni
                var number = txt.substring(1, 8);
                if (first == 'X') {
                    number = '0' + number
                    //final = first + number
                }
                if (first == 'Y') {
                    number = '1' + number
                    //final = first + number
                }
                if (first == 'Z') {
                    number = '2' + number
                    //final = first + number
                }
                if (isNumeric(number)){
                    letter = calculateLetterForDni(number)
                }
                var response = [{ status: 200, menssage: 'DNI',statusText:'OK',letter:letter}];               
                return response;
            }
            else if(first == 'A' || first == 'B' || first == 'C'||first == 'D' || first == 'E' || first == 'F'||first == 'G' || first == 'H' || first == 'J'||first == 'P' || first == 'Q' || first == 'R'||first == 'S' || first == 'U' || first == 'V'||first == 'N' || first == 'W')
            {
                var response = [{ status: 200, menssage: 'No CIF/DNI',statusText:'OK'}];               
                return response;
            } 
            else 
            {
                letter = calculateLetterForDni(txt.substring(0, 8))                
                var response = [{ status: 200, menssage: 'CIF',statusText:'OK',letter:letter}];               
                return response;
            }
        }
        else
        {
            return false
        }

    }
    //////// PARA CALCULAR DNI/NIE END /////////////////
    
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


 }