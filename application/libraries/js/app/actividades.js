 app.controller('Controlador_Actividades', ['$http', '$scope', '$filter', '$route', '$interval', '$controller', '$cookies', '$compile', 'upload', Controlador])
     .directive('uploaderModel', ["$parse", function($parse) {
         return {
             restrict: 'A',
             link: function(scope, iElement, iAttrs) {
                 iElement.on("change", function(e) {
                     $parse(iAttrs.uploaderModel).assign(scope, iElement[0].files[0]);
                 });
             }
         };
     }])
     .directive('uploadanexoModel', ["$parse", function($parse) {
         return {
             restrict: 'A',
             link: function(scope, iElement, iAttrs) {
                 iElement.on("change", function(e) {
                     $parse(iAttrs.uploadanexoModel).assign(scope, iElement[0].files[0]);
                     //console.log($parse(iAttrs.uploadanexoModel).assign(scope, iElement[0].files[0]));
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

 function Controlador($http, $scope, $filter, $route, $interval, $controller, $cookies, $compile, upload) {
     var scope = this;
     scope.fdatos = {};
     scope.nID = $route.current.params.ID;
     scope.INF = $route.current.params.INF;
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

     ////////////////////////////////////////////////// PARA LAS ACTIVIDADES GRIB START /////////////////////////////////////////////////////////

     ///////////////////////////////////////////////////////// PARA LAS ACTIVIDADES START //////////////////////////////////////////////////////////
     scope.CodCli = true;
     scope.NumCifCli = true;
     scope.RazSocCli = true;
     scope.DesSec = true;
     scope.DesGru = true;
     scope.DesEpi = true;
     scope.EstAct = true;
     scope.FecIniAct1 = true;
     scope.AccAct = true;

     scope.ttipofiltrosact = [{ id: 1, nombre: 'FECHA DE INICIO' }, { id: 2, nombre: 'ESTATUS ACTIVIDAD' }, { id: 3, nombre: 'CLIENTE' }];
     scope.topcionesactividades = [{ id: 1, nombre: 'ACTIVAR' }, { id: 2, nombre: 'BLOQUEAR' }];
     scope.ttipofiltrosEstAct = [{ id: 1, nombre: 'Activa' }, { id: 2, nombre: 'Bloqueada' }];
     scope.tmodal_filtroAct = {};
     scope.ruta_reportes_pdf_actividad = 0;
     scope.ruta_reportes_excel_actividad = 0;
     //scope.T_ActEcoGrib=1;
     scope.fdatos_actividades = {};
     scope.TActividades = [];
     scope.TActividadesBack = [];
     scope.tProvidencias = [];
     scope.tLocalidades = [];
     scope.tTipoCliente = [];
     scope.tComerciales = [];
     scope.tSectores = [];
     scope.tColaboradores = [];
     scope.tTiposVias = [];
     scope.TtiposInmuebles = [];
     scope.tListBanc = [];
     scope.tListaContactos = [];
     scope.tListDocumentos = [];
     scope.Tclientes = [];
     ////////////////////////////// PARA LAS ACTIVIDADES END //////////////////////////	
     console.log($route.current.$$route.originalPath);     
     
     scope.mostrar_all_actividades = function() {
         $("#cargando_actividades").removeClass("loader loader-default").addClass("loader loader-default  is-active");
         var url = base_urlHome() + "api/Clientes/all_actividades/";
         $http.get(url).then(function(result) {
             $("#cargando_actividades").removeClass("loader loader-default  is-active").addClass("loader loader-default");
             if (result.data != false) {
                 $scope.predicate1 = 'id';
                 $scope.reverse1 = true;
                 $scope.currentPage1 = 1;
                 $scope.order1 = function(predicate1) {
                     $scope.reverse1 = ($scope.predicate1 === predicate1) ? !$scope.reverse1 : false;
                     $scope.predicate1 = predicate1;
                 };
                 scope.TActividades = result.data;
                 scope.TActividadesBack = result.data;
                 $scope.totalItems1 = scope.TActividades.length;
                 $scope.numPerPage1 = 50;
                 $scope.paginate1 = function(value1) {
                     var begin1, end1, index1;
                     begin1 = ($scope.currentPage1 - 1) * $scope.numPerPage1;
                     end1 = begin1 + $scope.numPerPage1;
                     index1 = scope.TActividades.indexOf(value1);
                     return (begin1 <= index1 && index1 < end1);
                 };
             } else {
                 
                 scope.TActividades = [];
                 scope.TActividadesBack = [];
             }
         }, function(error) {
             $("#cargando_actividades").removeClass("loader loader-default is-active").addClass("loader loader-default");
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

     $scope.SubmitFormFiltrosAct = function(event) {
         if (scope.tmodal_filtroAct.tipo_filtro_actividad == 1) {
             var FecIniActFil = document.getElementById("FecIniActFil").value;
             scope.FecIniActFil = FecIniActFil;
             if (scope.FecIniActFil == undefined || scope.FecIniActFil == null || scope.FecIniActFil == '') {
                 scope.toast('error','Para aplicar el filtro debe introducir una Fecha','');
                 return false;
             } else {
                 var FecActFil = (scope.FecIniActFil).split("/");
                 if (FecActFil.length < 3) {
                     scope.toast('error','Error en Fecha, el formato correcto es DD/MM/YYYY','Fecha de Inicio');
                     event.preventDefault();
                     return false;
                 } else {
                     if (FecActFil[0].length > 2 || FecActFil[0].length < 2) {
                         scope.toast('error','Error en Día, el formato correcto es de 2 números','Fecha de Inicio');
                         event.preventDefault();
                         return false;

                     }
                     if (FecActFil[1].length > 2 || FecActFil[1].length < 2) {
                         scope.toast('error','Error en Mes, el formato correcto es de 2 números','Fecha de Inicio');
                         event.preventDefault();
                         return false;
                     }
                     if (FecActFil[2].length < 4 || FecActFil[2].length > 4) {
                         scope.toast('error','Error en Año, el formato correcto es de 4 números','Fecha de Inicio');
                         event.preventDefault();
                         return false;
                     }
                     var h1 = new Date();
                     var Final_Act_Fil = FecActFil[0] + "/" + FecActFil[1] + "/" + FecActFil[2];
                     scope.tmodal_filtroAct.FecIniActFil = Final_Act_Fil;
                     scope.filtro_fecha = FecActFil[0] + "-" + FecActFil[1] + "-" + FecActFil[2];
                 }
             }
             $scope.predicate1 = 'id';
             $scope.reverse1 = true;
             $scope.currentPage1 = 1;
             $scope.order1 = function(predicate1) {
                 $scope.reverse1 = ($scope.predicate1 === predicate1) ? !$scope.reverse1 : false;
                 $scope.predicate1 = predicate1;
             };
             scope.TActividades = $filter('filter')(scope.TActividadesBack, { FecIniAct: scope.tmodal_filtroAct.FecIniActFil }, true);
             $scope.totalItems1 = scope.TActividades.length;
             $scope.numPerPage1 = 50;
             $scope.paginate1 = function(value1) {
                 var begin1, end1, index1;
                 begin1 = ($scope.currentPage1 - 1) * $scope.numPerPage1;
                 end1 = begin1 + $scope.numPerPage1;
                 index1 = scope.TActividades.indexOf(value1);
                 return (begin1 <= index1 && index1 < end1);
             };

             scope.ruta_reportes_pdf_actividad = scope.tmodal_filtroAct.tipo_filtro_actividad + "/" + scope.filtro_fecha;
             scope.ruta_reportes_excel_actividad = scope.tmodal_filtroAct.tipo_filtro_actividad + "/" + scope.filtro_fecha;
         }
         if (scope.tmodal_filtroAct.tipo_filtro_actividad == 2) {
             if (!scope.tmodal_filtroAct.EstActFil > 0) {
                 scope.toast('error','Para aplicar el filtro debe seleccionar un Estatus','Estatus');
                 return false;
             }
             $scope.predicate1 = 'id';
             $scope.reverse1 = true;
             $scope.currentPage1 = 1;
             $scope.order1 = function(predicate1) {
                 $scope.reverse1 = ($scope.predicate1 === predicate1) ? !$scope.reverse1 : false;
                 $scope.predicate1 = predicate1;
             };
             scope.TActividades = $filter('filter')(scope.TActividadesBack, { EstAct: scope.tmodal_filtroAct.EstActFil }, true);
             $scope.totalItems1 = scope.TActividades.length;
             $scope.numPerPage1 = 50;
             $scope.paginate1 = function(value1) {
                 var begin1, end1, index1;
                 begin1 = ($scope.currentPage1 - 1) * $scope.numPerPage1;
                 end1 = begin1 + $scope.numPerPage1;
                 index1 = scope.TActividades.indexOf(value1);
                 return (begin1 <= index1 && index1 < end1);
             };

             scope.ruta_reportes_pdf_actividad = scope.tmodal_filtroAct.tipo_filtro_actividad + "/" + scope.tmodal_filtroAct.EstActFil;
             scope.ruta_reportes_excel_actividad = scope.tmodal_filtroAct.tipo_filtro_actividad + "/" + scope.tmodal_filtroAct.EstActFil;
         }
         if (scope.tmodal_filtroAct.tipo_filtro_actividad == 3) {
             if (!scope.tmodal_filtroAct.CodCliActFil > 0) {
                 scope.toast('error','Para aplicar el filtro debe seleccionar un Cliente','Clientes');
                 return false;
             }
             $scope.predicate1 = 'id';
             $scope.reverse1 = true;
             $scope.currentPage1 = 1;
             $scope.order1 = function(predicate1) {
                 $scope.reverse1 = ($scope.predicate1 === predicate1) ? !$scope.reverse1 : false;
                 $scope.predicate1 = predicate1;
             };
             scope.TActividades = $filter('filter')(scope.TActividadesBack, { CodCli: scope.tmodal_filtroAct.CodCliActFil }, true);
             $scope.totalItems1 = scope.TActividades.length;
             $scope.numPerPage1 = 50;
             $scope.paginate1 = function(value1) {
                 var begin1, end1, index1;
                 begin1 = ($scope.currentPage1 - 1) * $scope.numPerPage1;
                 end1 = begin1 + $scope.numPerPage1;
                 index1 = scope.TActividades.indexOf(value1);
                 return (begin1 <= index1 && index1 < end1);
             };

             scope.ruta_reportes_pdf_actividad = scope.tmodal_filtroAct.tipo_filtro_actividad + "/" + scope.tmodal_filtroAct.CodCliActFil;
             scope.ruta_reportes_excel_actividad = scope.tmodal_filtroAct.tipo_filtro_actividad + "/" + scope.tmodal_filtroAct.CodCliActFil;
         }
     };
     scope.quitar_filtro_actividad = function() {
         $scope.predicate1 = 'id';
         $scope.reverse1 = true;
         $scope.currentPage1 = 1;
         $scope.order1 = function(predicate1) {
             $scope.reverse1 = ($scope.predicate1 === predicate1) ? !$scope.reverse1 : false;
             $scope.predicate1 = predicate1;
         };
         scope.TActividades = scope.TActividadesBack;
         $scope.totalItems1 = scope.TActividades.length;
         $scope.numPerPage1 = 50;
         $scope.paginate1 = function(value1) {
             var begin1, end1, index1;
             begin1 = ($scope.currentPage1 - 1) * $scope.numPerPage1;
             end1 = begin1 + $scope.numPerPage1;
             index1 = scope.TActividades.indexOf(value1);
             return (begin1 <= index1 && index1 < end1);
         };
         scope.tmodal_filtroAct = {};
         scope.ruta_reportes_pdf_actividad = 0;
         scope.ruta_reportes_excel_actividad = 0;
         scope.filtro_fecha = undefined;
         scope.FecIniActFil = undefined;
         scope.NumCifCliFil=undefined;
     }
     scope.validar_fecha_act = function(metodo, object) {

         if (object != undefined && metodo == 1) {
             numero = object;
             if (!/^([/0-9])*$/.test(numero))
                 scope.FecIniAct = numero.substring(0, numero.length - 1);
         }
         if (object != undefined && metodo == 2) {
             numero = object;
             if (!/^([/0-9])*$/.test(numero))
                 scope.FecIniActFil = numero.substring(0, numero.length - 1);
         }
         if (object != undefined && metodo == 3) {
             numero = object;
             if (!/^([/0-9])*$/.test(numero))
                 scope.FecBloAct = numero.substring(0, numero.length - 1);
         }
     }
     scope.validar_actividad = function(index, opcion, datos) {
         scope.update_status_activity = {};
         scope.update_status_activity.opcion = opcion;
         scope.update_status_activity.CodTActCli = datos.CodTActCli;
         scope.update_status_activity.CodCli = datos.CodCli;
         if (opcion == 1) {
             if (datos.EstAct == "Activa") {
                 scope.toast('error','La Actividad seleccionada se encuentra activa','Activando');
                 scope.opciones_actividades[index] = undefined;
                 return false;
             }
             Swal.fire({
                 title: "Activando",
                 text: "¿Seguro que desea activar la Actividad?",
                 type: "info",
                 showCancelButton: !0,
                 confirmButtonColor: "#31ce77",
                 cancelButtonColor: "#f34943",
                 confirmButtonText: "Confirmar"
             }).then(function(t) {
                 if (t.value == true) {
                     $("#estatus_actividad").removeClass("loader loader-default").addClass("loader loader-default  is-active");
                     var url = base_urlHome() + "api/Clientes/update_status_activity/";
                     $http.post(url, scope.update_status_activity).then(function(result) {
                         $("#estatus_actividad").removeClass("loader loader-default is-active").addClass("loader loader-default");
                                 
                         if (result.data != false) {
                             if (result.data.opcion == 1) {
                                 //scope.buscarXID();					
                                 scope.toast('success','La Actividad ha sido activada de forma correcta','');
                                 scope.opciones_actividades[index] = undefined;
                                 scope.mostrar_all_actividades();
                             }
                         } else {
                             scope.toast('error','Ha ocurrido un error al asignar la Actividad, intente nuevamente','');
                             
                         }
                     }, function(error) {
                         $("#estatus_actividad").removeClass("loader loader-default is-active").addClass("loader loader-default");
                             
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
                     scope.opciones_actividades[index] = undefined;
                 }
             });
         }
         if (opcion == 2) {
             if (datos.EstAct == "Bloqueada") {
                 scope.toast('error','La Actividad ya se encuentra bloqueada','Bloqueando');
                 scope.opciones_actividades[index] = undefined;
                 return false;
             }

             scope.tmodal_data = {};
             scope.tmodal_data.opcion = opcion;
             scope.tmodal_data.index = index;
             if (scope.tmodal_data.ObsBloAct == undefined) {
                 scope.tmodal_data.ObsBloAct = null;
             } else {
                 scope.tmodal_data.ObsBloAct = scope.tmodal_data.ObsBloAct;
             }

             scope.tmodal_data.CodCli = datos.CodCli;
             scope.tmodal_data.CodTActCli = datos.CodTActCli;
             scope.FecBloAct = scope.fecha_server;
             $('.datepicker2').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.FecBloAct);
             scope.tmodal_data.NumCif = datos.NumCifCli;
             scope.tmodal_data.RazSoc = datos.RazSocCli;
             scope.tmodal_data.DesActCNAE = datos.DesActCNAE;
             scope.tmodal_data.GruActCNAE = datos.GruActCNAE;
             scope.tmodal_data.SubGruActCNAE = datos.SubGruActCNAE;
             scope.tmodal_data.SecActCNAE = datos.SecActCNAE;
             scope.opciones_actividades[index] = undefined;
             scope.cargar_lista_motivos_bloqueos_actividades();
             $("#modal_motivo_bloqueo_actividades").modal('show');
         }

     }
     scope.cargar_lista_motivos_bloqueos_actividades = function() {
         var url = base_urlHome() + "api/Clientes/Motivos_Bloqueos_Actividades/";
         $http.get(url).then(function(result) {
             if (result.data != false) {
                 scope.tMotivosBloqueosActividades = result.data.data;
                 scope.fecha_server=result.data.FechaServer;
                 scope.FecBloAct=result.data.FechaServer;
                 $('.datepicker2').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.FecBloAct);
             } else {
                 scope.toast('error','No hay Motivos de Bloqueo registrados','Motivos Bloqueos');
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

     $scope.submitFormlockActividades = function(event) {
         var FecBloAct = document.getElementById("FecBloAct").value;
         scope.FecBloAct = FecBloAct;
         if (scope.FecBloAct == undefined || scope.FecBloAct == null || scope.FecBloAct == '') {
             scope.toast('error','La Fecha de Bloqueo es requerida','Fecha de Bloqueo');
             event.preventDefault();
             return false;
         } else {
             var FecBloAct = (scope.FecBloAct).split("/");
             if (FecBloAct.length < 3) {
                 scope.toast('error','Error en Fecha de Bloqueo, el formato correcto es DD/MM/YYYY','Fecha de Bloqueo');
                 event.preventDefault();
                 return false;
             } else {
                 if (FecBloAct[0].length > 2 || FecBloAct[0].length < 2) {
                     scope.toast('error','Error en Día, debe introducir dos números','Fecha de Bloqueo');
                     event.preventDefault();
                     return false;
                 }
                 if (FecBloAct[1].length > 2 || FecBloAct[1].length < 2) {
                     scope.toast('error','Error en Mes, debe introducir dos números','Fecha de Bloqueo');
                     event.preventDefault();
                     return false;
                 }
                 if (FecBloAct[2].length < 4 || FecBloAct[2].length > 4) {
                     scope.toast('error','Error en Año, debe introducir cuatro números','Fecha de Bloqueo');
                     event.preventDefault();
                     return false;
                 }
                 valuesStart = scope.FecBloAct.split("/");
                 valuesEnd = scope.fecha_server.split("/");
                 // Verificamos que la fecha no sea posterior a la actual
                 var dateStart = new Date(valuesStart[2], (valuesStart[1] - 1), valuesStart[0]);
                 var dateEnd = new Date(valuesEnd[2], (valuesEnd[1] - 1), valuesEnd[0]);
                 if (dateStart > dateEnd) {
                     scope.toast('error',"Fecha de Bloqueo no debe ser mayor a " + scope.fecha_server,'Fecha de Bloqueo');
                     return false;
                 }
                 scope.tmodal_data.FecBloAct = valuesStart[2] + "-" + valuesStart[1] + "-" + valuesStart[0];
             }
         }
         console.log(scope.tmodal_data.FecBloAct);
         Swal.fire({
             title: 'Bloqueando',
             text: "¿Seguro que desea bloquear la Actividad?",
             type: "question",
             showCancelButton: !0,
             confirmButtonColor: "#31ce77",
             cancelButtonColor: "#f34943",
             confirmButtonText: "Confirmar"
         }).then(function(t) {
             if (t.value == true) {
                 $("#estatus_actividad").removeClass("loader loader-default").addClass("loader loader-default  is-active");
                 var url = base_urlHome() + "api/Clientes/update_status_activity/";
                 $http.post(url, scope.tmodal_data).then(function(result) {
                     if (result.data != false) {
                         if (result.data.opcion == 2) {
                             scope.mostrar_all_actividades();
                             $("#estatus_actividad").removeClass("loader loader-default is-active").addClass("loader loader-default");
                             scope.toast('success','La Actividad ha sido bloqueada de forma de forma correcta','Bloqueando');
                             scope.opciones_actividades[scope.tmodal_data.index] = undefined;
                             $("#modal_motivo_bloqueo_actividades").modal('hide');
                         }
                     } else {
                         $("#estatus_actividad").removeClass("loader loader-default is-active").addClass("loader loader-default");
                         scope.toast('error','Ha ocurrido un error, intente nuevamente','Bloqueando');
                         scope.opciones_actividades[scope.tmodal_data.index] = undefined;
                     }
                 }, function(error) {
                     $("#estatus_actividad").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
                 event.preventDefault();

             }
         });
     };
     scope.buscar_CNAE = function() {
         if (scope.CodActCNAE != undefined) {
             $("#buscar_cnae").removeClass("loader loader-default").addClass("loader loader-default  is-active");
             var url = base_urlHome() + "api/Clientes/Buscar_CNAE/CodActCNAE/" + scope.CodActCNAE;
             $http.get(url).then(function(result) {
                 $("#buscar_cnae").removeClass("loader loader-default  is-active").addClass("loader loader-default");
                 if (result.data != false) {
                     scope.resultado_actividad = 1;
                     scope.fdatos_actividades = result.data;
                     scope.fecha_server=result.data.FechaServer;
                     scope.FecIniAct=result.data.FechaServer;
                     $('.datepicker').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", result.data.FechaServer);
                 } else {
                     scope.toast('error','El Código CNAE no existe','Código CNAE');
                     scope.resultado_actividad = 0;
                     scope.fdatos_actividades = {};
                     scope.fecha_server=undefined;
                     scope.FecIniAct=undefined;
                 }
             }, function(error) {
                 $("#buscar_cnae").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
     $scope.submitFormActividades = function(event) {
         scope.fdatos_actividades.CodCli = scope.tmodal_filtroAct.CodCliActFil;
         if (scope.nIDAct > 0 && scope.Nivel == 3) {
             scope.toast('error','No tiene permisos para realizar esta operación','Usuario no Autorizado');
            return false;
         }
         /*if (!scope.validar_campos_datos_basicos())
         {
         	return false;
         }*/
         if (scope.fdatos_actividades.CodTActCli > 0) {
             var title = 'Actualizando';
             var text = '¿Seguro que desea actualizar la Actividad?';
             var response = "Actividad modificada de forma correcta";
         }
         if (scope.fdatos_actividades.CodTActCli == undefined) {
             var title = 'Guardando';
             var text = '¿Seguro que desea grabar la Actividad?';
             var response = "Actividad registrada de forma correcta";
         }
         var FecIniAct = document.getElementById("FecIniAct").value;
         scope.FecIniAct = FecIniAct;
         if (scope.FecIniAct == undefined || scope.FecIniAct == null || scope.FecIniAct == '') {
             scope.toast('error','La Fecha de Inicio es requerida','Fecha de Inicio');
             event.preventDefault();
             return false;
         }
         var FecActCon = (scope.FecIniAct).split("/");
         if (FecActCon.length < 3) {
             scope.toast('error','Error en Fecha, el formato correcto es DD/MM/YYYY','Fecha de Inicio');
             event.preventDefault();
             return false;
         } else {
             if (FecActCon[0].length > 2 || FecActCon[0].length < 2) {
                 scope.toast('error','Error en Día, debe introducir dos números','Fecha de Inicio');
                 event.preventDefault();
                 return false;

             }
             if (FecActCon[1].length > 2 || FecActCon[1].length < 2) {
                 scope.toast('error','Error en Mes, debe introducir dos números','Fecha de Inicio');
                 event.preventDefault();
                 return false;
             }
             if (FecActCon[2].length < 4 || FecActCon[2].length > 4) {
                 scope.toast('error','Error en Año, debe introducir cuatro números','Fecha de Inicio');
                 event.preventDefault();
                 return false;
             }
             var h1 = new Date();
             var final = FecActCon[2] + "/" + FecActCon[1] + "/" + FecActCon[0];
             scope.fdatos_actividades.FecIniAct = final;

             valuesStart = scope.FecIniAct.split("/");
             valuesEnd = scope.fecha_server.split("/");
             // Verificamos que la fecha no sea posterior a la actual
             var dateStart = new Date(valuesStart[2], (valuesStart[1] - 1), valuesStart[0]);
             var dateEnd = new Date(valuesEnd[2], (valuesEnd[1] - 1), valuesEnd[0]);
             if (dateStart > dateEnd) {
                 scope.toast('error',"La Fecha de Inicio no puede ser mayor a" + scope.fecha_server,'Fecha de Inicio');
                 return false;
             }
         }
         Swal.fire({
             title: title,
             text: text,
             type: "question",
             showCancelButton: !0,
             confirmButtonColor: "#31ce77",
             cancelButtonColor: "#f34943",
             confirmButtonText: "SI"
         }).then(function(t) {
             if (t.value == true) {
                 $("#asignando_actividad").removeClass("loader loader-default").addClass("loader loader-default  is-active");
                 var url = base_urlHome() + "api/Clientes/Asignar_Actividad";
                 $http.post(url, scope.fdatos_actividades).then(function(result) {
                     $("#asignando_actividad").removeClass("loader loader-default  is-active").addClass("loader loader-default");
                     if (result.data != false) {
                         scope.toast('success',response,title);
                         scope.fdatos_actividades.CodTActCli = result.data.CodTActCli;
                     } else {
                         scope.toast('error','La Actividad ya se encuentra asignada al Cliente','');
                         
                     }
                 }, function(error) {
                     $("#asignando_actividad").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
     scope.regresar_actividad = function() {

         if (scope.fdatos_actividades.CodTActCli == undefined) {
             var title = "Guardando";
             var text = "¿Seguro que desea cerrar sin registrar la Actividad?";
         } else {
             var title = "Actualizando";
             var text = "¿Seguro que desea cerrar sin actualizar la información de la Actividad?";
         }
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
                 location.href = "#/Actividades";
             } else {
                 console.log('Cancelando ando...');
             }
         });
     }

     scope.fetchActividades = function() {
         if (scope.filtrar_search == undefined || scope.filtrar_search == null || scope.filtrar_search == '') {

             $scope.predicate1 = 'id';
             $scope.reverse1 = true;
             $scope.currentPage1 = 1;
             $scope.order1 = function(predicate1) {
                 $scope.reverse1 = ($scope.predicate1 === predicate1) ? !$scope.reverse1 : false;
                 $scope.predicate1 = predicate1;
             };
             scope.TActividades = scope.TActividadesBack;
             $scope.totalItems1 = scope.TActividades.length;
             $scope.numPerPage1 = 50;
             $scope.paginate1 = function(value1) {
                 var begin1, end1, index1;
                 begin1 = ($scope.currentPage1 - 1) * $scope.numPerPage1;
                 end1 = begin1 + $scope.numPerPage1;
                 index1 = scope.TActividades.indexOf(value1);
                 return (begin1 <= index1 && index1 < end1);
             };
             scope.ruta_reportes_pdf_actividad = 0;
             scope.ruta_reportes_excel_actividad = 0;

         } else {
             if (scope.filtrar_search.length >= 2) {
                 scope.fdatos.filtrar_search = scope.filtrar_search;
                 var url = base_urlHome() + "api/Clientes/getActividadesFilter";
                 $http.post(url, scope.fdatos).then(function(result) {
                     console.log(result.data);
                     if (result.data != false) {
                         $scope.predicate1 = 'id';
                         $scope.reverse1 = true;
                         $scope.currentPage1 = 1;
                         $scope.order1 = function(predicate1) {
                             $scope.reverse1 = ($scope.predicate1 === predicate1) ? !$scope.reverse1 : false;
                             $scope.predicate1 = predicate1;
                         };
                         scope.TActividades = result.data;
                         $scope.totalItems1 = scope.TActividades.length;
                         $scope.numPerPage1 = 50;
                         $scope.paginate1 = function(value1) {
                             var begin1, end1, index1;
                             begin1 = ($scope.currentPage1 - 1) * $scope.numPerPage1;
                             end1 = begin1 + $scope.numPerPage1;
                             index1 = scope.TActividades.indexOf(value1);
                             return (begin1 <= index1 && index1 < end1);
                         };
                         scope.ruta_reportes_pdf_actividad = 4 + "/" + scope.filtrar_search;
                         scope.ruta_reportes_excel_actividad = 4 + "/" + scope.filtrar_search;
                     } else {
                         scope.TActividades = [];                         
                         scope.ruta_reportes_pdf_actividad = 0;
                         scope.ruta_reportes_excel_actividad = 0;
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
                $scope.predicate1 = 'id';
                         $scope.reverse1 = true;
                         $scope.currentPage1 = 1;
                         $scope.order1 = function(predicate1) {
                             $scope.reverse1 = ($scope.predicate1 === predicate1) ? !$scope.reverse1 : false;
                             $scope.predicate1 = predicate1;
                         };
                         scope.TActividades = scope.TActividadesBack;
                         $scope.totalItems1 = scope.TActividades.length;
                         $scope.numPerPage1 = 50;
                         $scope.paginate1 = function(value1) {
                             var begin1, end1, index1;
                             begin1 = ($scope.currentPage1 - 1) * $scope.numPerPage1;
                             end1 = begin1 + $scope.numPerPage1;
                             index1 = scope.TActividades.indexOf(value1);
                             return (begin1 <= index1 && index1 < end1);
                         };
                         scope.ruta_reportes_pdf_actividad = 0;
                         scope.ruta_reportes_excel_actividad = 0;
             }
         }
     }
     scope.containerClicked = function() 
     {
        scope.searchResult = {};
     }
     scope.searchboxClicked = function($event) {
                     $event.stopPropagation();
                 }
    scope.setValue = function(index, $event, result) {
                    
                         scope.NumCifCliFil = scope.searchResult[index].NumCifCli;
                         scope.tmodal_filtroAct.CodCliActFil=scope.searchResult[index].CodCli;
                         scope.searchResult = {};
                         $event.stopPropagation();
                    
                    

                 }            

     scope.fetchClientes = function() {
             
                 var searchText_len = scope.NumCifCliFil.trim().length;
                 scope.fdatos.filtrar_clientes = scope.NumCifCliFil;
                 if (searchText_len > 0) {
                     var url = base_urlHome() + "api/Clientes/getClientesFilter";
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
                 if($route.current.$$route.originalPath=="/Actividades/")
                 {
                    scope.mostrar_all_actividades();
                 }
     ////////////////////////////////////////////////// PARA LAS ACTIVIDADES GRIB END //////////////////////////////////////////////////////////
 }