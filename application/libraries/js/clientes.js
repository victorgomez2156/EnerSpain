 app.controller('Controlador_Clientes', ['$http', '$scope', '$filter', '$route', '$interval', '$controller', '$cookies', '$compile', 'ServiceMaster', 'upload', Controlador])
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

 function Controlador($http, $scope, $filter, $route, $interval, $controller, $cookies, $compile, ServiceMaster, upload) {
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

     scope.RazSoc = true;
     scope.NumCif = true;
     scope.Tel = true;
     scope.Est = true;
     scope.Acc = true;
     scope.ruta_reportes_pdf = 0;
     scope.ruta_reportes_excel = 0;
     scope.Tclientes = [];
     scope.TclientesBack = [];
     scope.topciones = [{ id: 1, nombre: 'VER' }, { id: 2, nombre: 'EDITAR' }, { id: 3, nombre: 'ACTIVAR' }, { id: 4, nombre: 'BLOQUEAR' }];
     scope.Filtro_Clientes = [{ id: 1, nombre: 'TIPO DE CLIENTE' }, { id: 2, nombre: 'SECTOR' }, { id: 3, nombre: 'PROVINCIA FISCAL' }, { id: 4, nombre: 'LOCALIDAD FISCAL' }, { id: 5, nombre: 'COMERCIAL' }, { id: 6, nombre: 'COLABORADOR' }, { id: 7, nombre: 'ESTATUS CLIENTE' }];
     scope.tmodal_data = {};
     scope.fdatos.misma_razon = false;
     console.log($route.current.$$route.originalPath);
     ////////////////////////////////////////////////// PARA LA LISTA Y CONFIGURACIONES DE SERVICIOS ESPECIALES START ////////////////////////////////////////////////////////
     ServiceMaster.getAll().then(function(dato) {
         scope.tProvidencias = dato.Provincias;
         scope.tLocalidades = dato.Localidades;
         scope.tTipoCliente = dato.Tipo_Cliente;
         scope.tComerciales = dato.Comerciales;
         scope.tSectores = dato.Sector_Cliente;
         scope.tColaboradores = dato.Colaborador;
         scope.tTiposVias = dato.Tipo_Vias;
         scope.TtiposInmuebles = dato.Tipo_Inmuebles;
         scope.tListBanc = dato.Bancos;
         scope.tListaContactos = dato.Tipo_Contacto;
         scope.tListDocumentos = dato.Tipos_Documentos;
         scope.fdatos.FecIniCli = dato.Fecha_Server;
         scope.fecha_server = dato.Fecha_Server;

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
         if (scope.Tclientes == false) {
             scope.Tclientes = [];
             scope.TclientesBack = [];
         }
     }).catch(function(err) { console.log(err); });

     ////////////////////////////////////////////////////////////// MODULO CLIENTES DATOS BASICOS START ////////////////////////////////////////////////////////////////////

     scope.cargar_lista_clientes = function() {
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
                 Swal.fire({ title: "Error", text: "No hay Clientes registrados", type: "error", confirmButtonColor: "#188ae2" });
                 scope.Tclientes = [];
                 scope.TclientesBack = [];
             }
         }, function(error) {
             $("#List_Cli").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
     }
     scope.modal_cif_cliente = function() {
         $("#modal_cif_cliente").modal('show');
         scope.Clientes_CIF = undefined;
     }

     $scope.Consultar_CIF_Clientes = function(event) {
         if (scope.fdatos.Clientes_CIF == undefined || scope.fdatos.Clientes_CIF == null || scope.fdatos.Clientes_CIF == '') {
             Swal.fire({ title: "Error.", text: "El campo CIF es requerido", type: "error", confirmButtonColor: "#188ae2" });
             return false;
         } else {
             $("#NumCifCli").removeClass("loader loader-default").addClass("loader loader-default  is-active");
             var url = base_urlHome() + "api/Clientes/comprobar_cif_existente/";
             $http.post(url, scope.fdatos).then(function(result) {
                 $("#NumCifCli").removeClass("loader loader-default is-active").addClass("loader loader-default");
                 if (result.data != false) {
                     Swal.fire({ title: "Error", text: "Ya existe un Cliente registrado con el mismo CIF", type: "info", confirmButtonColor: "#188ae2" });
                 } else {
                     $("#modal_cif_cliente").modal('hide');
                     //Swal.fire({title:"Disponible.",text:"El Número de CIF se encuentra disponible.",type:"success",confirmButtonColor:"#188ae2"});
                     $cookies.put('CIF', scope.fdatos.Clientes_CIF);
                     location.href = "#/Datos_Basicos_Clientes/";
                 }
             }, function(error) {
                 $("#NumCifCli").removeClass("loader loader-default is-active").addClass("loader loader-default");
                 if (error.status == 404 && error.statusText == "Not Found") {
                     Swal.fire({ title: "Error General", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
                 }
                 if (error.status == 401 && error.statusText == "Unauthorized") {
                     Swal.fire({ title: "Error de Privilegios", text: "Usuario no autorizado para acceder a este Módulo", type: "info", confirmButtonColor: "#188ae2" });
                 }
                 if (error.status == 403 && error.statusText == "Forbidden") {
                     Swal.fire({ title: "Error de Seguridad", text: "Está intentando utilizar un APIKEY incorrecto", type: "question", confirmButtonColor: "#188ae2" });
                 }
                 if (error.status == 500 && error.statusText == "Internal Server Error") {
                     Swal.fire({ title: "Error de Servidor", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
                 }
             });
         }
     };

     $scope.SubmitFormFiltrosClientes = function(event) {
         if (scope.tmodal_data.tipo_filtro == 1) {
             if (!scope.tmodal_data.CodTipCliFil > 0) {
                 Swal.fire({ title: "Error", text: "Seleccione el Tipo de Cliente", type: "error", confirmButtonColor: "#188ae2" });
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
                 Swal.fire({ title: "Error", text: "Seleccione el Sector", type: "error", confirmButtonColor: "#188ae2" });
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
                 Swal.fire({ title: "Error", text: "Seleccione Provincia", type: "error", confirmButtonColor: "#188ae2" });
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
                 Swal.fire({ title: "Error", text: "Seleccione Provincia", type: "error", confirmButtonColor: "#188ae2" });
                 return false;
             }
             if (!scope.tmodal_data.CodLocFil > 0) {
                 Swal.fire({ title: "Error", text: "Seleccione Localidad", type: "error", confirmButtonColor: "#188ae2" });
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
                 Swal.fire({ title: "Error", text: "Seleccione Comercial", type: "error", confirmButtonColor: "#188ae2" });
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
                 Swal.fire({ title: "Error", text: "Seleccione Colaborador", type: "error", confirmButtonColor: "#188ae2" });
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
                 Swal.fire({ title: "Error", text: "Seleccione Estatus", type: "error", confirmButtonColor: "#188ae2" });
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
                 Swal.fire({ text: "El Cliente ya se encuentra activo", type: "error", confirmButtonColor: "#188ae2" });
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
                             Swal.fire({ text: "El Cliente ha sido activado de forma correcta", type: "success", confirmButtonColor: "#188ae2" });
                             scope.cargar_lista_clientes();
                         } else {
                             Swal.fire({ text: "Ha ocurrido un error, intente nuevamente", type: "error", confirmButtonColor: "#188ae2" });
                             scope.cargar_lista_clientes();
                         }
                     }, function(error) {
                         $("#comprobando_disponibilidad").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
                 } else {
                     console.log('Cancelando ando...');
                 }
             });
         }
         if (opcion == 4) {
             if (datos.EstCli == 2) {
                 Swal.fire({ title: "Error!.", text: "Ya este cliente se encuentra bloqueado.", type: "error", confirmButtonColor: "#188ae2" });
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
                 Swal.fire({ title: "Error", text: "No hay Motivos de Bloqueo registrados", type: "error", confirmButtonColor: "#188ae2" });
             }
         }, function(error) {
             if (error.status == 404 && error.statusText == "Not Found") {
                 Swal.fire({ title: "Error General", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
             }
             if (error.status == 401 && error.statusText == "Unauthorized") {
                 Swal.fire({ title: "Error de Privilegios", text: "Usuario no autorizado para acceder a este Módulo", type: "info", confirmButtonColor: "#188ae2" });
             }
             if (error.status == 403 && error.statusText == "Forbidden") {
                 Swal.fire({ title: "Seguridad", text: "Está intentando utilizar un APIKEY incorrecto", type: "question", confirmButtonColor: "#188ae2" });
             }
             if (error.status == 500 && error.statusText == "Internal Server Error") {
                 Swal.fire({ title: "Error", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
             }
         });
     }

     $scope.submitFormlock = function(event) {
         var FechBlo = document.getElementById("FechBlo").value;
         scope.FechBlo = FechBlo;
         if (scope.FechBlo == undefined || scope.FechBlo == null || scope.FechBlo == '') {
             Swal.fire({ text: "La Fecha de Bloqueo es requerida", type: "error", confirmButtonColor: "#188ae2" });
             event.preventDefault();
             return false;
         } else {
             var FechBlo = (scope.FechBlo).split("/");
             if (FechBlo.length < 3) {
                 Swal.fire({ text: "El dormato de Fecha de Bloqueo debe ser DD/MM/YYYY", type: "error", confirmButtonColor: "#188ae2" });
                 event.preventDefault();
                 return false;
             } else {
                 if (FechBlo[0].length > 2 || FechBlo[0].length < 2) {
                     Swal.fire({ text: "Error en Día, debe introducir dos números", type: "error", confirmButtonColor: "#188ae2" });
                     event.preventDefault();
                     return false;
                 }
                 if (FechBlo[1].length > 2 || FechBlo[1].length < 2) {
                     Swal.fire({ text: "Error en Mes, debe introducir dos números", type: "error", confirmButtonColor: "#188ae2" });
                     event.preventDefault();
                     return false;
                 }
                 if (FechBlo[2].length < 4 || FechBlo[2].length > 4) {
                     Swal.fire({ text: "Error en Año, debe introducir cuatro números", type: "error", confirmButtonColor: "#188ae2" });
                     event.preventDefault();
                     return false;
                 }
                 valuesStart = scope.FechBlo.split("/");
                 valuesEnd = scope.fecha_server.split("/");
                 // Verificamos que la fecha no sea posterior a la actual
                 var dateStart = new Date(valuesStart[2], (valuesStart[1] - 1), valuesStart[0]);
                 var dateEnd = new Date(valuesEnd[2], (valuesEnd[1] - 1), valuesEnd[0]);
                 if (dateStart > dateEnd) {
                     Swal.fire({ text: "La Fecha de Bloqueo no puede ser mayor a" + scope.fecha_server + "verifique e intente nuevamente", type: "error", confirmButtonColor: "#188ae2" });
                     return false;
                 }
                 scope.tmodal_data.FechBlo = scope.FechBlo;
             }
         }
         Swal.fire({
             title: "¿Seguro que desea Bloquear el Cliente?",
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
                         Swal.fire({ title: "Procesado", text: "El Cliente ha sido bloqueado de forma correcta", type: "success", confirmButtonColor: "#188ae2" });
                         scope.cargar_lista_clientes();
                     } else {
                         Swal.fire({ title: "Error", text: "Ha ocurrido un error, intente nuevamente", type: "error", confirmButtonColor: "#188ae2" });
                         scope.cargar_lista_clientes();
                     }
                 }, function(error) {
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



 }