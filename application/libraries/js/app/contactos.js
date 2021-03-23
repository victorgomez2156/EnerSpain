 app.controller('Controlador_Contactos', ['$http', '$scope', '$filter', '$route', '$interval', '$controller', '$cookies', '$compile', 'ServiceMaster', 'upload', Controlador])
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

 function Controlador($http, $scope, $filter, $route, $interval, $controller, $cookies, $compile, ServiceMaster, upload) {
   var scope = this;
   scope.tContacto_data_modal = {};
   scope.nID = $route.current.params.ID;
   scope.no_editable = $route.current.params.INF;
   scope.Nivel = $cookies.get('nivel');
   scope.CIF_Contacto = $cookies.get('CIF_Contacto');
    scope.EsRepLeg=null;
    scope.TipRepr='1';
    scope.CanMinRep='1';
    scope.TieFacEsc=null;
    scope.EsColaborador=null;
    scope.EsPrescritor=null;
    scope.DocPod=null;
     //const $archivosanexos = document.querySelector("#file_anexo");
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
     if ($route.current.$$route.originalPath == "/Add_Contactos/") {
       console.log(scope.CIF_Contacto);
       //if (scope.CIF_Contacto == undefined) {
           //scope.toast('error','El Número de CIF del Contacto No Puede Estar Vacio.','Error');
           //location.href = "#/Contactos";
       //} else {
        scope.tContacto_data_modal.ConPrin=false;        
        //scope.tContacto_data_modal.NIFConCli = scope.CIF_Contacto;
        //scope.tContacto_data_modal.EsRepLeg = null;
        //scope.tContacto_data_modal.TieFacEsc = null;
        //scope.tContacto_data_modal.CanMinRep = 1;
        //scope.tContacto_data_modal.TipRepr = "1";        
        //scope.tContacto_data_modal.EsColaborador=null;
        //scope.tContacto_data_modal.EsPrescritor=null;
    //}
}
     /*if($route.current.$$route.originalPath=="/Contacto_Otro_Cliente/:NIFConCli")
     {
     	scope.tContacto_data_modal.NIFConCli=$route.current.params.NIFConCli;
     	scope.tContacto_data_modal.TipRepr="1";
     	scope.tContacto_data_modal.CanMinRep=1;
     	console.log(scope.tContacto_data_modal.NIFConCli);	
     }*/
     ///////////////////////////// CONTACTOS CLIENTES START ///////////////////////////	
     scope.ruta_reportes_pdf_Contactos = 0;
     scope.ruta_reportes_excel_Contactos = 0;
     scope.CodCli = true;
     scope.NumCifCli = true;
     scope.RazSocCli = true;
     scope.NomConCli = true;
     scope.NIFConCli = true;
     scope.CodTipCon = true;
     scope.CarConCli = true;
     scope.EstConCli = true;
     scope.ActCont = true;
     scope.T_Filtro_Contactos = [{ id: 1, nombre: 'Tipo de Contacto' }, { id: 2, nombre: 'Representante Legal' }, { id: 3, nombre: 'Tipo de Representación' }, { id: 4, nombre: 'Estatus' }];
     scope.tListaRepre = [{ id: 1, DesTipRepr: 'INDEPENDIENTE' }, { id: 2, DesTipRepr: 'MANCOMUNADA' }];
     scope.tmodal_contacto = {};
     const $Archivo_DocNIF = document.querySelector("#DocNIF");
     const $Archivo_DocPod = document.querySelector("#DocPod");
     scope.topciones = [{ id: 1, nombre: 'VER' }, { id: 2, nombre: 'EDITAR' }, { id: 3, nombre: 'ACTIVAR' }, { id: 4, nombre: 'SUSPENDER' }];
     ///////////////////////////// CONTACTOS CLIENTES END ///////////////////////////
     scope.index = 0;
     scope.tListaContactos = [];
     scope.Tabla_Contacto = [];
     scope.Tabla_ContactoBack = [];
     scope.Tclientes = [];
     scope.tContacto_data_modal.Tabla_Contacto=[];
     /*ServiceMaster.getAll().then(function(dato) {
         scope.tListaContactos = dato.Tipo_Contacto;
         scope.Tclientes = dato.Clientes;
         scope.fecha_server = dato.Fecha_Server;
         $scope.predicate4 = 'id';
         $scope.reverse4 = true;
         $scope.currentPage4 = 1;
         $scope.order4 = function(predicate4) {
             $scope.reverse4 = ($scope.predicate4 === predicate4) ? !$scope.reverse4 : false;
             $scope.predicate4 = predicate4;
         };
         scope.Tabla_Contacto = dato.Contactos;
         scope.Tabla_ContactoBack = dato.Contactos;
         $scope.totalItems4 = scope.Tabla_Contacto.length;
         $scope.numPerPage4 = 50;
         $scope.paginate4 = function(value4) {
             var begin4, end4, index4;
             begin4 = ($scope.currentPage4 - 1) * $scope.numPerPage4;
             end4 = begin4 + $scope.numPerPage4;
             index4 = scope.Tabla_Contacto.indexOf(value4);
             return (begin4 <= index4 && index4 < end4);
         };
         if (scope.Tabla_Contacto == false) {
             scope.Tabla_Contacto = [];
             scope.Tabla_ContactoBack = [];
         }
     }).catch(function(err) { console.log(err); });*/

     scope.cargar_lista_contactos = function() {
       $("#cargando_contactos").removeClass("loader loader-default").addClass("loader loader-default is-active");
       var url = base_urlHome() + "api/Clientes/lista_contactos";
       $http.get(url).then(function(result) {
           $("#cargando_contactos").removeClass("loader loader-default is-active").addClass("loader loader-default");
           if (result.data != false) {

               $scope.predicate4 = 'id';
               $scope.reverse4 = true;
               $scope.currentPage4 = 1;
               $scope.order4 = function(predicate4) {
                   $scope.reverse4 = ($scope.predicate4 === predicate4) ? !$scope.reverse4 : false;
                   $scope.predicate4 = predicate4;
               };
               scope.Tabla_Contacto = result.data;
               scope.Tabla_ContactoBack = result.data;
               $scope.totalItems4 = scope.Tabla_Contacto.length;
               $scope.numPerPage4 = 50;
               $scope.paginate4 = function(value4) {
                   var begin4, end4, index4;
                   begin4 = ($scope.currentPage4 - 1) * $scope.numPerPage4;
                   end4 = begin4 + $scope.numPerPage4;
                   index4 = scope.Tabla_Contacto.indexOf(value4);
                   return (begin4 <= index4 && index4 < end4);
               };
               scope.tmodal_contacto = {};
               scope.ruta_reportes_pdf_Contactos = 0;
               scope.ruta_reportes_excel_Contactos = 0;
           } else {
               scope.ruta_reportes_pdf_Contactos = 0;
               scope.ruta_reportes_excel_Contactos = 0;
               scope.Tabla_Contacto =[];
           }
       }, function(error) {
           $("#cargando_contactos").removeClass("loader loader-default is-active").addClass("loader loader-default");
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

   $scope.SubmitFormFiltrosContactos = function(event) {
       if (scope.tmodal_contacto.tipo_filtro == 1) {

           if (!scope.tmodal_contacto.DesTipCon > 0) {
               scope.toast('error','Debe Seleccionar un tipo de contacto para aplicar el filtro.','Error');
               return false;
           }
           $scope.predicate4 = 'id';
           $scope.reverse4 = true;
           $scope.currentPage4 = 1;
           $scope.order4 = function(predicate4) {
               $scope.reverse4 = ($scope.predicate4 === predicate4) ? !$scope.reverse4 : false;
               $scope.predicate4 = predicate4;
           };
             //scope.Tabla_Contacto=result.data;
             scope.Tabla_Contacto = $filter('filter')(scope.Tabla_ContactoBack, { DesTipCon: scope.tmodal_contacto.DesTipCon }, true);
             $scope.totalItems4 = scope.Tabla_Contacto.length;
             $scope.numPerPage4 = 50;
             $scope.paginate4 = function(value4) {
               var begin4, end4, index4;
               begin4 = ($scope.currentPage4 - 1) * $scope.numPerPage4;
               end4 = begin4 + $scope.numPerPage4;
               index4 = scope.Tabla_Contacto.indexOf(value4);
               return (begin4 <= index4 && index4 < end4);
           }
           scope.ruta_reportes_pdf_Contactos = scope.tmodal_contacto.tipo_filtro + "/" + scope.tmodal_contacto.DesTipCon;
           scope.ruta_reportes_excel_Contactos = scope.tmodal_contacto.tipo_filtro + "/" + scope.tmodal_contacto.DesTipCon;
       }
       if (scope.tmodal_contacto.tipo_filtro == 2) {
           if (!scope.tmodal_contacto.EsRepLeg > 0) {
               scope.toast('error','Debe Seleccionar un tipo de representación legal para aplicar el filtro.','Error');
               return false;
           }
           $scope.predicate4 = 'id';
           $scope.reverse4 = true;
           $scope.currentPage4 = 1;
           $scope.order4 = function(predicate4) {
               $scope.reverse4 = ($scope.predicate4 === predicate4) ? !$scope.reverse4 : false;
               $scope.predicate4 = predicate4;
           };
             //scope.Tabla_Contacto=result.data;
             scope.Tabla_Contacto = $filter('filter')(scope.Tabla_ContactoBack, { EsRepLeg: scope.tmodal_contacto.EsRepLeg }, true);
             $scope.totalItems4 = scope.Tabla_Contacto.length;
             $scope.numPerPage4 = 50;
             $scope.paginate4 = function(value4) {
               var begin4, end4, index4;
               begin4 = ($scope.currentPage4 - 1) * $scope.numPerPage4;
               end4 = begin4 + $scope.numPerPage4;
               index4 = scope.Tabla_Contacto.indexOf(value4);
               return (begin4 <= index4 && index4 < end4);
           }
           scope.ruta_reportes_pdf_Contactos = scope.tmodal_contacto.tipo_filtro + "/" + scope.tmodal_contacto.EsRepLeg;
           scope.ruta_reportes_excel_Contactos = scope.tmodal_contacto.tipo_filtro + "/" + scope.tmodal_contacto.EsRepLeg;
       }
       if (scope.tmodal_contacto.tipo_filtro == 3) {
           if (!scope.tmodal_contacto.TipRepr > 0) {
               scope.toast('error','Debe Seleccionar un tipo de representación para aplicar el filtro','Error');
               return false;
           }
           $scope.predicate4 = 'id';
           $scope.reverse4 = true;
           $scope.currentPage4 = 1;
           $scope.order4 = function(predicate4) {
               $scope.reverse4 = ($scope.predicate4 === predicate4) ? !$scope.reverse4 : false;
               $scope.predicate4 = predicate4;
           };
             //scope.Tabla_Contacto=result.data;
             scope.Tabla_Contacto = $filter('filter')(scope.Tabla_ContactoBack, { representacion: scope.tmodal_contacto.TipRepr }, true);
             $scope.totalItems4 = scope.Tabla_Contacto.length;
             $scope.numPerPage4 = 50;
             $scope.paginate4 = function(value4) {
               var begin4, end4, index4;
               begin4 = ($scope.currentPage4 - 1) * $scope.numPerPage4;
               end4 = begin4 + $scope.numPerPage4;
               index4 = scope.Tabla_Contacto.indexOf(value4);
               return (begin4 <= index4 && index4 < end4);
           }
           scope.ruta_reportes_pdf_Contactos = scope.tmodal_contacto.tipo_filtro + "/" + scope.tmodal_contacto.TipRepr;
           scope.ruta_reportes_excel_Contactos = scope.tmodal_contacto.tipo_filtro + "/" + scope.tmodal_contacto.TipRepr;
       }
       if (scope.tmodal_contacto.tipo_filtro == 4) {
           if (!scope.tmodal_contacto.EstConCli > 0) {
               scope.toast('error','Debe Seleccionar un Estatus para aplicar el filtro.','Error');
               return false;
           }
           $scope.predicate4 = 'id';
           $scope.reverse4 = true;
           $scope.currentPage4 = 1;
           $scope.order4 = function(predicate4) {
               $scope.reverse4 = ($scope.predicate4 === predicate4) ? !$scope.reverse4 : false;
               $scope.predicate4 = predicate4;
           };
             //scope.Tabla_Contacto=result.data;
             scope.Tabla_Contacto = $filter('filter')(scope.Tabla_ContactoBack, { EstConCli: scope.tmodal_contacto.EstConCli }, true);
             $scope.totalItems4 = scope.Tabla_Contacto.length;
             $scope.numPerPage4 = 50;
             $scope.paginate4 = function(value4) {
               var begin4, end4, index4;
               begin4 = ($scope.currentPage4 - 1) * $scope.numPerPage4;
               end4 = begin4 + $scope.numPerPage4;
               index4 = scope.Tabla_Contacto.indexOf(value4);
               return (begin4 <= index4 && index4 < end4);
           }
           scope.ruta_reportes_pdf_Contactos = scope.tmodal_contacto.tipo_filtro + "/" + scope.tmodal_contacto.EstConCli;
           scope.ruta_reportes_excel_Contactos = scope.tmodal_contacto.tipo_filtro + "/" + scope.tmodal_contacto.EstConCli;
       }
   };
   scope.regresar_filtro_contactos = function() {
       $scope.predicate4 = 'id';
       $scope.reverse4 = true;
       $scope.currentPage4 = 1;
       $scope.order4 = function(predicate4) {
           $scope.reverse4 = ($scope.predicate4 === predicate4) ? !$scope.reverse4 : false;
           $scope.predicate4 = predicate4;
       };
       scope.Tabla_Contacto = scope.Tabla_ContactoBack;
       $scope.totalItems4 = scope.Tabla_Contacto.length;
       $scope.numPerPage4 = 50;
       $scope.paginate4 = function(value4) {
           var begin4, end4, index4;
           begin4 = ($scope.currentPage4 - 1) * $scope.numPerPage4;
           end4 = begin4 + $scope.numPerPage4;
           index4 = scope.Tabla_Contacto.indexOf(value4);
           return (begin4 <= index4 && index4 < end4);
       }
       scope.ruta_reportes_pdf_Contactos = 0;
       scope.ruta_reportes_excel_Contactos = 0;
       scope.tmodal_contacto = {};
   }
   scope.validar_OpcCont = function(index, validar_OpcCont, dato) {
       scope.validar_OpcCont[index] = undefined;
       console.log(validar_OpcCont);
       console.log(dato);
       if (validar_OpcCont == 1) {
           location.href = "#/Edit_Contactos/" + dato.CodConCli + "/" + 1;
       }
       if (validar_OpcCont == 2) {
           location.href = "#/Edit_Contactos/" + dato.CodConCli;
       }
       if (validar_OpcCont == 3) {
           if (dato.EstConCli == "ACTIVO") {
               scope.toast('error','Este Contacto Ya Se Encuentra Activo.','');
               return false;
           }
           Swal.fire({
               title: "¿Esta Seguro de Activar Este Contacto?",
               type: "question",
               showCancelButton: !0,
               confirmButtonColor: "#31ce77",
               cancelButtonColor: "#f34943",
               confirmButtonText: "OK"
           }).then(function(t) {
               if (t.value == true) {
                   scope.update_estatus_contacto(1, dato.CodConCli, index)
               } else {
                   console.log('Cancelando ando...');
               }
           });
       }
       if (validar_OpcCont == 4) {
           if (dato.EstConCli == "SUSPENDIDO") {
               scope.toast('error','Este Contacto Ya Se Encuentra Suspendido.','');
               return false;
           }
           scope.tmodal_data = {};
           scope.NumCif = dato.NIFConCli;
           scope.FechBlo = scope.fecha_server;
           $('.datepicker').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.FechBlo);
           scope.RazSocCli = dato.NomConCli;
           scope.tmodal_data.CodCli = dato.CodCli;
           scope.tmodal_data.index = index;
           scope.tmodal_data.CodConCli = dato.CodConCli;
           scope.cargar_lista_motivos_bloqueos_contactos();
       }

   }
   scope.validar_fecha_blo = function(object) {
       console.log(object);
       if (object != undefined) {
           numero = object;
           if (!/^([/0-9])*$/.test(numero))
               scope.FechBlo = numero.substring(0, numero.length - 1);
       }
   }
   scope.cargar_lista_motivos_bloqueos_contactos = function() {
       var url = base_urlHome() + "api/Clientes/list_motivos_bloqueos_contactos";
       $http.get(url).then(function(result) {
           if (result.data.resultado != false) 
           {
               scope.tMotivosBloqueoContacto = result.data.MotivosContactos;
               scope.fecha_server= result.data.FechaServer;
               scope.FechBlo=result.data.FechaServer;
               $('.datepicker').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.FechBlo);
               $("#modal_motivo_bloqueo_contacto").modal('show');
           } else {
               scope.toast('info','No existen motivos de suspensión de contacto','Contactos');
               scope.tMotivosBloqueoContacto =[];
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
   scope.update_estatus_contacto = function(validar_OpcCont, CodConCli, index) {
       scope.status_comer = {};
       scope.status_comer.EstConCli = validar_OpcCont;
       scope.status_comer.CodConCli = CodConCli;

       if (validar_OpcCont == 2) {
           scope.status_comer.MotBloqcontacto = scope.tmodal_data.MotBloqcontacto;
           scope.status_comer.ObsBloContacto = scope.tmodal_data.ObsBloContacto;
           scope.status_comer.FechBlo = scope.tmodal_data.FechBlo;
       }
       $("#estatus_contactos").removeClass("loader loader-default").addClass("loader loader-default is-active");
       var url = base_urlHome() + "api/Clientes/cambiar_estatus_contactos/";
       $http.post(url, scope.status_comer).then(function(result) {
           $("#estatus_contactos").removeClass("loader loader-default is-active").addClass("loader loader-default");
           if (result.data.resultado != false) {
               if (validar_OpcCont == 1) {
                   var title = 'Activando.';
                   var text = 'El Contacto ha sido activado con exito.';
               }
               if (validar_OpcCont == 2) {
                   var title = 'Bloquear.';
                   var text = 'El Contacto ha sido suspendido con exito.';
                   $("#modal_motivo_bloqueo_contacto").modal('hide');
               }
               scope.tmodal_data = {};
               scope.toast('success',text,title);
               scope.validar_OpcCont[index] = undefined;
               scope.cargar_lista_contactos();
           } else {
               scope.toast('error','No Hemos Podido Actualizar el Estatus del Contacto.','Error');
               scope.tmodal_data = {};
               scope.cargar_lista_contactos();
           }

       }, function(error) {
           $("#estatus_contactos").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
   $scope.submitFormlockContactos = function(event) {
       var FechBlo1 = document.getElementById("FechBlo").value;
       scope.FechBlo = FechBlo1;
       if (scope.FechBlo == undefined || scope.FechBlo == null || scope.FechBlo == '') {
           scope.toast('error','La Fecha de Suspensión es requerida','');
           event.preventDefault();
           return false;
       } else {
           var FechBlo = (scope.FechBlo).split("/");
           if (FechBlo.length < 3) {
               scope.toast('error','El formato Fecha de Suspensión correcto es DD/MM/YYYY','');
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
                   scope.toast('error',"La Fecha de Suspensión no puede ser mayor al " + scope.fecha_server + " Verifique e intente nuevamente",'');

                   return false;
               }
               scope.tmodal_data.FechBlo = valuesStart[2] + "-" + valuesStart[1] + "-" + valuesStart[0];
           }
       }
       if (scope.tmodal_data.ObsBloContacto == undefined || scope.tmodal_data.ObsBloContacto == null || scope.tmodal_data.ObsBloContacto == '') {
           scope.tmodal_data.ObsBloContacto = null;
       } else {
           scope.tmodal_data.ObsBloContacto = scope.tmodal_data.ObsBloContacto;
       }
       Swal.fire({
           title: "¿Esta Seguro de Suspender Este Contacto?",
           type: "question",
           showCancelButton: !0,
           confirmButtonColor: "#31ce77",
           cancelButtonColor: "#f34943",
           confirmButtonText: "Suspender"
       }).then(function(t) {
           if (t.value == true) {
               scope.update_estatus_contacto(2, scope.tmodal_data.CodConCli, scope.tmodal_data.index);
           } else {
               event.preventDefault();
               console.log('Cancelando ando...');
           }
       });
   };
   scope.asignar_contacto = function() {
       scope.tContacto_data_modal = {};
       $("#modal_cif_cliente_contacto").modal('show');
   }
   $scope.Consultar_CIF_Contacto = function(event) {
       if (scope.tContacto_data_modal.NIFConCli == undefined || scope.tContacto_data_modal.NIFConCli == null || scope.tContacto_data_modal.NIFConCli == '') {
           scope.toast('error','El Número de CIF no puede estar vacio.','Error');
           return false;
       } else {

           if (!scope.validarNIFDNI()) {
               return false;
           }
           $("#NIFConCli").removeClass("loader loader-default").addClass("loader loader-default is-active");
           var url = base_urlHome() + "api/Clientes/comprobar_cif_contacto/";
           $http.post(url, scope.tContacto_data_modal).then(function(result) {
               $("#NIFConCli").removeClass("loader loader-default is-active").addClass("loader loader-default");
               if (result.data != false) {
                   Swal.fire({
                       title: "DNI/NIE Encontrado",
                       text: "El DNI/NIE ya se encuentra registrado, presione el botón Continuar si desea asignarlo a otro Cliente",
                       type: "question",
                       showCancelButton: !0,
                       confirmButtonColor: "#31ce77",
                       cancelButtonColor: "#f34943",
                       confirmButtonText: "Continuar"
                   }).then(function(t) {
                       if (t.value == true) {
                           $("#modal_cif_cliente_contacto").modal('hide');
                           $cookies.put('CIF_Contacto', scope.tContacto_data_modal.NIFConCli);
                           location.href = "#/Add_Contactos/";
                       } else {
                           event.preventDefault();
                           console.log('Cancelando ando...');
                       }
                   });
               } else {
                   $("#modal_cif_cliente_contacto").modal('hide');
                   location.href = "#/Add_Contactos";
                   $cookies.put('CIF_Contacto', scope.tContacto_data_modal.NIFConCli);
               }
           }, function(error) {
               $("#NIFConCli").removeClass("loader loader-default").addClass("loader loader-default is-active");
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
   scope.regresar_contacto = function() {
       if (scope.no_editable == undefined) {
           if (scope.tContacto_data_modal.CodConCli == undefined) {
               var title = "Guardando";
               var text = "¿Seguro que desea cerrar sin registrar el Contacto?";
           } else {
               var title = "Actualizando";
               var text = "¿Seguro que desea cerrar sin actualizar la información del Contacto?";
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
                   location.href = "#/Contactos";
               } else {
                   console.log('Cancelando ando...');
               }
           });

       } else {
           location.href = "#/Contactos";
       }
   }
   scope.BuscarXIDContactos = function() {
       $("#cargando_I").removeClass("loader loader-default").addClass("loader loader-default  is-active");
       var url = base_urlHome() + "api/Clientes/BuscarXIDContactos_Data/CodConCli/" + scope.nID;
       $http.get(url).then(function(result) {
           $("#cargando_I").removeClass("loader loader-default is-active").addClass("loader loader-default");
           if (result.data != false) {
            scope.tContacto_data_modal = result.data; 
            scope.BuscarLocalidad(1,result.data.CodProFis);
            if(result.data.ConPrin==null ||result.data.ConPrin==0)
            {
                scope.tContacto_data_modal.ConPrin=false;
            }
            else
            {
                scope.tContacto_data_modal.ConPrin=true;
            }
        } else {
           scope.toast('error','No existe información del Contacto seleccionado','Error');
           scope.tContacto_data_modal = {};

       }
   }, function(error) {
       $("#cargando_I").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
   $scope.uploadImage = function() {
       console.log('Changed');
   }
   $scope.submitFormRegistroContacto = function(event) 
   { 
       let Archivo_DocNIF = $Archivo_DocNIF.files;
       if ($Archivo_DocNIF.files.length > 0) {
           if ($Archivo_DocNIF.files[0].type == "application/pdf" || $Archivo_DocNIF.files[0].type == "image/jpeg" || $Archivo_DocNIF.files[0].type == "image/png") {
               if ($Archivo_DocNIF.files[0].size > 2097152) {
                   scope.toast('error','El tamaño del fichero no debe ser superior a 2 MB','Error');
                   scope.tContacto_data_modal.DocNIF = null;
                   document.getElementById('DocNIF').value = '';
                   return false;
               } else {
                   var tipo_file = ($Archivo_DocNIF.files[0].type).split("/");
                   $Archivo_DocNIF.files[0].type;
                   scope.tContacto_data_modal.DocNIF = 'documentos/' + $Archivo_DocNIF.files[0].name;
               }
           } else {
               scope.toast('error','Formato de fichero incorrecto, debe ser PDF, JPG o PNG','Error');
               document.getElementById('DocNIF').value = '';
               return false;
           }
       } else {
           document.getElementById('DocNIF').value = '';
           if (scope.tContacto_data_modal.DocNIF == undefined || scope.tContacto_data_modal.DocNIF == null) {
               scope.tContacto_data_modal.DocNIF = null;
           } else {
               scope.tContacto_data_modal.DocNIF = scope.tContacto_data_modal.DocNIF;
           }
       }
      /* let Archivo_DocPod = $Archivo_DocPod.files;
       if ($Archivo_DocPod.files.length > 0) 
       {
           if ($Archivo_DocPod.files[0].type == "application/pdf" || $Archivo_DocPod.files[0].type == "image/jpeg" || $Archivo_DocPod.files[0].type == "image/png") {
               if ($Archivo_DocPod.files[0].size > 2097152) {
                   scope.toast('error','El tamaño del fichero no debe ser superior a 2 MB','Error');
                   scope.tContacto_data_modal.DocPod = null;
                   document.getElementById('DocPod').value = '';
                   return false;
               } else {
                   var tipo_file = ($Archivo_DocPod.files[0].type).split("/");
                   $Archivo_DocPod.files[0].type;
                   scope.tContacto_data_modal.DocPod = 'documentos/' + $Archivo_DocPod.files[0].name;
               }
           } else {
               scope.toast('error','Formato de fichero incorrecto, debe ser PDF, JPG o PNG','Error');
               document.getElementById('DocPod').value = '';
               return false;
           }
       } else 
       {
           document.getElementById('DocPod').value = '';
           if (scope.tContacto_data_modal.DocPod == undefined || scope.tContacto_data_modal.DocPod == null) {
               scope.tContacto_data_modal.DocPod = null;
           } else {
               scope.tContacto_data_modal.DocPod = scope.tContacto_data_modal.DocPod;
           }
       }*/
       if (!scope.validar_campos_contactos_null()) {
           return false;
       }
       if (scope.tContacto_data_modal.CodConCli > 0) {
           var title = 'Actualizando';
           var text = '¿Seguro que desea actualizar la información del Contacto?';
       }
       if (scope.tContacto_data_modal.CodConCli == undefined) {
           var title = 'Guardando';
           var text = '¿Seguro que desea registrar el Contacto??';
       }
       console.log(scope.tContacto_data_modal);
       Swal.fire({
           title: text,
           type: "question",
           showCancelButton: !0,
           confirmButtonColor: "#31ce77",
           cancelButtonColor: "#f34943",
           confirmButtonText: "OK"
       }).then(function(t) {
           if (t.value == true) {
               if ($Archivo_DocNIF.files.length > 0) {
                   $scope.uploadFile(1);
               }
               /*if ($Archivo_DocPod.files.length > 0) {
                   $scope.uploadFile(2);
               }*/
               $("#" + title).removeClass("loader loader-default").addClass("loader loader-default  is-active");
               var url = base_urlHome() + "api/Clientes/Registro_Contacto";
               $http.post(url, scope.tContacto_data_modal).then(function(result) {
                   //console.log(result);
                  $("#" + title).removeClass("loader loader-default  is-active").addClass("loader loader-default");
                  if(result.data.status == 400 && result.data.response =="Error CIF")
                  {
                    scope.toast('error',result.data.menssage,title);
                  }
                  if (result.data.status == 200 && result.data.response == 'Exito') {
                       scope.toast('success',result.data.menssage,title);
                       document.getElementById('DocNIF').value = '';
                       $('#filenameDocNIF').html('');
                       location.href = "#/Edit_Contactos/" + result.data.objSalida.CodConCli;
                   }
               }, function(error) {
                   $("#" + title).removeClass("loader loader-default  is-active").addClass("loader loader-default");
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
   };
   scope.validar_campos_contactos_null = function() {
       resultado = true;
       

       if (scope.tContacto_data_modal.NomConCli == null || scope.tContacto_data_modal.NomConCli == undefined || scope.tContacto_data_modal.NomConCli == '') {
           scope.toast('error','El Nombre del Contacto es requerido','');
           return false;
       }
        if (scope.tContacto_data_modal.NumColeCon == null || scope.tContacto_data_modal.NumColeCon == undefined || scope.tContacto_data_modal.NumColeCon == '') {
           scope.tContacto_data_modal.NumColeCon=null;             
       }
       else
           {scope.tContacto_data_modal.NumColeCon=scope.tContacto_data_modal.NumColeCon;

           }
         if (scope.tContacto_data_modal.NIFConCli == null || scope.tContacto_data_modal.NIFConCli == undefined || scope.tContacto_data_modal.NIFConCli == '') {
           scope.tContacto_data_modal.NIFConCli=null;             
       }
       else
           {scope.tContacto_data_modal.NIFConCli=scope.tContacto_data_modal.NIFConCli;

           }

       if (scope.tContacto_data_modal.CarConCli == null || scope.tContacto_data_modal.CarConCli == undefined || scope.tContacto_data_modal.CarConCli == '') {
           scope.toast('error','El Cargo del Contacto es requerido','');
           return false;
       }
        if (scope.tContacto_data_modal.TelFijConCli == null || scope.tContacto_data_modal.TelFijConCli == undefined || scope.tContacto_data_modal.TelFijConCli == '') {
           scope.toast('error','El Teléfono Fijo del Contato es requerido','');
           return false;
       }
       if (scope.tContacto_data_modal.TelCelConCli == null || scope.tContacto_data_modal.TelCelConCli == undefined || scope.tContacto_data_modal.TelCelConCli == '') {
           scope.tContacto_data_modal.TelCelConCli=null;             
       }
       else
           {scope.tContacto_data_modal.TelCelConCli=scope.tContacto_data_modal.TelCelConCli;

           }
        if (scope.tContacto_data_modal.EmaConCli == null || scope.tContacto_data_modal.EmaConCli == undefined || scope.tContacto_data_modal.EmaConCli == '') {
           scope.tContacto_data_modal.EmaConCli=null;             
       }
       else
        {
          scope.tContacto_data_modal.EmaConCli=scope.tContacto_data_modal.EmaConCli;
        }
       if (scope.tContacto_data_modal.DocNIF == null || scope.tContacto_data_modal.DocNIF == undefined || scope.tContacto_data_modal.DocNIF == '') {
           scope.tContacto_data_modal.DocNIF = null;
       } else {
           scope.tContacto_data_modal.DocNIF = scope.tContacto_data_modal.DocNIF;
       }
         if (scope.tContacto_data_modal.ObsConC == null || scope.tContacto_data_modal.ObsConC == undefined || scope.tContacto_data_modal.ObsConC == '') {
               scope.tContacto_data_modal.ObsConC = null;
           } else {
               scope.tContacto_data_modal.ObsConC = scope.tContacto_data_modal.ObsConC;
           }
                
        if (scope.tContacto_data_modal.CodTipViaFis == null || scope.tContacto_data_modal.CodTipViaFis == undefined || scope.tContacto_data_modal.CodTipViaFis == '') {
           scope.tContacto_data_modal.CodTipViaFis = null;
       } else {
           scope.tContacto_data_modal.CodTipViaFis = scope.tContacto_data_modal.CodTipViaFis;
       }

       if (scope.tContacto_data_modal.NomViaDomFis == null || scope.tContacto_data_modal.NomViaDomFis == undefined || scope.tContacto_data_modal.NomViaDomFis == '') {
           scope.tContacto_data_modal.NomViaDomFis = null;
       } else {
           scope.tContacto_data_modal.NomViaDomFis = scope.tContacto_data_modal.NomViaDomFis;
       }

       if (scope.tContacto_data_modal.NumViaDomFis == null || scope.tContacto_data_modal.NumViaDomFis == undefined || scope.tContacto_data_modal.NumViaDomFis == '') {
           scope.tContacto_data_modal.NumViaDomFis = null;
       } else {
           scope.tContacto_data_modal.NumViaDomFis = scope.tContacto_data_modal.NumViaDomFis;
       }

       if (scope.tContacto_data_modal.CPLocFis == null || scope.tContacto_data_modal.CPLocFis == undefined || scope.tContacto_data_modal.CPLocFis == '') {
           scope.tContacto_data_modal.CPLocFis = null;
       } else {
           scope.tContacto_data_modal.CPLocFis = scope.tContacto_data_modal.CPLocFis;
       }

       if (scope.tContacto_data_modal.CodProFis == null || scope.tContacto_data_modal.CodProFis == undefined || scope.tContacto_data_modal.CodProFis == '') {
           scope.tContacto_data_modal.CodProFis = null;
       } else {
           scope.tContacto_data_modal.CodProFis = scope.tContacto_data_modal.CodProFis;
       }
       if (scope.tContacto_data_modal.CodProFis == null || scope.tContacto_data_modal.CodProFis == undefined || scope.tContacto_data_modal.CodProFis == '') {
           scope.tContacto_data_modal.CodProFis = null;
       } else {
           scope.tContacto_data_modal.CodProFis = scope.tContacto_data_modal.CodProFis;
       }
       if (scope.tContacto_data_modal.CodLocFis == null || scope.tContacto_data_modal.CodLocFis == undefined || scope.tContacto_data_modal.CodLocFis == '') {
           scope.tContacto_data_modal.CodLocFis = null;
          } else {
           scope.tContacto_data_modal.CodLocFis = scope.tContacto_data_modal.CodLocFis;
        }





       if(scope.Tabla_Contacto.length==0)
       {
          scope.tContacto_data_modal.Tabla_Contacto=false;
       }
       else
       {
          scope.tContacto_data_modal.Tabla_Contacto=scope.Tabla_Contacto;
       }
       if (resultado == false) {
           return false;
       }
       return true;
   }
   scope.verificar_representante_legal = function() {

       if (scope.EsRepLeg == 0) 
       {
            scope.TipRepr = "1";
            scope.CanMinRep = 1;
            document.getElementById('DocNIF').value = '';
            
       }
   }
   scope.verificar_facultad_escrituras = function() {
       if (scope.TieFacEsc == 1) {
           document.getElementById('DocPod').value = '';
           scope.DocPod = null;
       }
   }
   $scope.uploadFile = function(metodo) {
       if (metodo == 1) {
           var file = $scope.DocNIF;
       }
       if (metodo == 2) {
           var file = $scope.DocPod;
       }
       upload.uploadFile(file, name).then(function(res) {}, function(error) {



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
   scope.validarsinuermoContactos = function(object, metodo) {
       if (object != undefined && metodo == 1) {
           numero = object;
           if (!/^([0-9])*$/.test(numero))
               scope.tContacto_data_modal.TelFijConCli = numero.substring(0, numero.length - 1);
       }
       if (object != undefined && metodo == 2) {
           numero = object;
           if (!/^([0-9])*$/.test(numero))
               scope.tContacto_data_modal.TelCelConCli = numero.substring(0, numero.length - 1);
       }
       if (object != undefined && metodo == 3) {
           numero = object;
           if (!/^([0-9])*$/.test(numero))
               scope.tContacto_data_modal.CanMinRep = numero.substring(0, numero.length - 1);
       }

   }
    
    //////// PARA CALCULAR DNI/NIE START /////////////////
    scope.validarNIFDNI = function() 
    {
           var letter = scope.validar_dni_nie($("#NIFConCli1").parent(), $("#NIFConCli1").val());
           console.log(letter[0]);
           if(letter[0].status==200&&letter[0].statusText=='OK'&&letter[0].menssage=="DNI")
           {
            scope.dni_nie_validar = scope.tContacto_data_modal.NIFConCli.substring(0,8)+letter[0].letter;
            if(scope.dni_nie_validar!=scope.tContacto_data_modal.NIFConCli)
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
                scope.dni_nie_validar = scope.tContacto_data_modal.NIFConCli.substring(0,8)+letter[0].letter;
                if(scope.dni_nie_validar!=scope.tContacto_data_modal.NIFConCli)
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
    scope.cargar_tiposContactos=function(metodo)
    {
     var url = base_urlHome()+"api/Clientes/RealizarConsultaFiltros/metodo/"+metodo;
     $http.get(url).then(function (result)
     {
        if(result.data)
        {
            if(metodo==9)
            {
                scope.tListaContactos=result.data;
            }
            else if(metodo==3)
            {
                scope.tProvidencias=result.data;
            }
            else if(metodo==12)
            {   
                scope.tTiposVias=result.data;

            }                
        }
        else
        {
            scope.tListaContactos=[];
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
         ///////// PARA CALCULAR DNI/NIE END /////////////////
        scope.containerClickedNIFNombre=function(metodo)
        {
          if(metodo==1)
          {
            scope.ResultNombreContacto={};
          }
          else if(metodo==2)
          {
            scope.ResultNIFContacto={};
          }

        }

        scope.containerClicked = function() {
            scope.searchResult = {};
        }
        scope.searchboxClicked = function($event) {
           $event.stopPropagation();
       }
       scope.setValue = function(index, $event, result) 
       {
          scope.CodCliContacto = scope.searchResult[index].NumCifCli;
          scope.CodCliInsert=scope.searchResult[index].CodCli;
          scope.NumCifCli=scope.searchResult[index].NumCifCli;
          scope.RazSocCli=scope.searchResult[index].RazSocCli;
          scope.searchResult = {};
          $event.stopPropagation(); 

    }




    scope.BuscarPorNombreoDni = function(metodo,InputText) 
    {
      if(metodo==1)
      {
          var searchText_len = InputText.trim().length;
          if(searchText_len > 0)
          {
            var url = base_urlHome() + "api/Clientes/BuscarPorNombreoDni/metodo/"+metodo+"/InputText/"+InputText;
          }
      }
      else if(metodo==2)
      {
          var searchText_len = InputText.trim().length;
          if(searchText_len > 0)
          {
            var url = base_urlHome() + "api/Clientes/BuscarPorNombreoDni/metodo/"+metodo+"/InputText/"+InputText;
          }
      }
      $http.get(url).then(function(result) 
      {
        if(result.data!=false)
        {
            if(metodo==1)
            {
              scope.ResultNombreContacto=result.data;                
            }
            else if(metodo==2)
            {
              scope.ResultNIFContacto=result.data;                
            }
        }
        else
        {
            if(metodo==1)
            {
              scope.ResultNombreContacto={};
            }
            else if(metodo==2)
            {
              scope.ResultNIFContacto={};                
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
       /*var searchText_len = scope.CodCliContacto.trim().length;
       scope.tContacto_data_modal.filtrar_clientes = scope.CodCliContacto;
       if (searchText_len > 0) {
           var url = base_urlHome() + "api/Clientes/getClientesFilter";
           $http.post(url, scope.tContacto_data_modal).then(function(result) {
                             //console.log(result);
                             if (result.data != false) {
                               scope.searchResult = result.data;
                                 //console.log(scope.searchResult);
                             } else {

                               scope.searchResult = {};
                           }
                       },
                       function(error) {
                           
                    });
       } else {
           scope.searchResult = {};
       }*/
    } 
    scope.setValuePorCliente = function(index, $event, result,metodo) 
    {
          if(metodo==1)
          {
            location.href="#/Edit_Contactos/"+scope.ResultNombreContacto[index].CodConCli;
            scope.tContacto_data_modal.NomConCli=scope.ResultNombreContacto[index].NomConCli;
            scope.ResultNombreContacto = {};
            $event.stopPropagation();
            
          }
          else if(metodo==2)
          {
            location.href="#/Edit_Contactos/"+scope.ResultNIFContacto[index].CodConCli;
            scope.tContacto_data_modal.NIFConCli=scope.ResultNIFContacto[index].NIFConCli;
            scope.ResultNIFContacto = {};
            $event.stopPropagation();            
          }
          
    }
    scope.fetchClientes = function() 
    {

       var searchText_len = scope.CodCliContacto.trim().length;
       scope.tContacto_data_modal.filtrar_clientes = scope.CodCliContacto;
       if (searchText_len > 0) {
           var url = base_urlHome() + "api/Clientes/getClientesFilter";
           $http.post(url, scope.tContacto_data_modal).then(function(result) {
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
   scope.FetchContactos = function() {

       var searchText_len = scope.filtrar_search.trim().length;
       scope.tContacto_data_modal.filtrar_search = scope.filtrar_search;
       if (searchText_len > 0) {
           var url = base_urlHome() + "api/Clientes/getContactosFilter";
           $http.post(url, scope.tContacto_data_modal).then(function(result) {
                             //console.log(result);
                             if (result.data != false) {
                               $scope.predicate4 = 'id';
                               $scope.reverse4 = true;
                               $scope.currentPage4 = 1;
                               $scope.order4 = function(predicate4) {
                                   $scope.reverse4 = ($scope.predicate4 === predicate4) ? !$scope.reverse4 : false;
                                   $scope.predicate4 = predicate4;
                               };
                               scope.Tabla_Contacto = result.data;
                               $scope.totalItems4 = scope.Tabla_Contacto.length;
                               $scope.numPerPage4 = 50;
                               $scope.paginate4 = function(value4) {
                                   var begin4, end4, index4;
                                   begin4 = ($scope.currentPage4 - 1) * $scope.numPerPage4;
                                   end4 = begin4 + $scope.numPerPage4;
                                   index4 = scope.Tabla_Contacto.indexOf(value4);
                                   return (begin4 <= index4 && index4 < end4);
                               };
                               scope.ruta_reportes_pdf_Contactos = 5 + "/" + scope.tContacto_data_modal.filtrar_search;
                               scope.ruta_reportes_excel_Contactos = 5 + "/" + scope.tContacto_data_modal.filtrar_search;
                                 //console.log(scope.searchResult);



                             } else {

                                        //scope.searchResult = {};
                                        scope.Tabla_Contacto=[];
                                        scope.ruta_reportes_pdf_Contactos = 0;
                                        scope.ruta_reportes_excel_Contactos = 0;
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

        $scope.predicate4 = 'id';
        $scope.reverse4 = true;
        $scope.currentPage4 = 1;
        $scope.order4 = function(predicate4) {
           $scope.reverse4 = ($scope.predicate4 === predicate4) ? !$scope.reverse4 : false;
           $scope.predicate4 = predicate4;
       };
       scope.Tabla_Contacto=scope.Tabla_ContactoBack;
       $scope.totalItems4 = scope.Tabla_Contacto.length;
       $scope.numPerPage4 = 50;
       $scope.paginate4 = function(value4) {
           var begin4, end4, index4;
           begin4 = ($scope.currentPage4 - 1) * $scope.numPerPage4;
           end4 = begin4 + $scope.numPerPage4;
           index4 = scope.Tabla_Contacto.indexOf(value4);
           return (begin4 <= index4 && index4 < end4);
       };

       scope.ruta_reportes_pdf_Contactos = 0;
       scope.ruta_reportes_excel_Contactos = 0;
   }



} 
scope.ComprobarContactoPrincipal=function(ConPri)
{
    if(ConPri==true && scope.tContacto_data_modal.CodCli!=undefined)
    {
        scope.tContacto_data_modal.ConPrin=false;
        $("#Principal").removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url = base_urlHome()+"api/Clientes/ValidarContactoPrincipal/CodCli/"+scope.tContacto_data_modal.CodCli+"/ConPri/"+1;
        $http.get(url).then(function(result)
        {
            $("#Principal").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if(result.data!=false)
            {
                Swal.fire({ title: 'Contacto Principal',text: '¿Este Cliente ya tiene un contacto asignado como principal quiere establecer este como principal?',
                   type: "question",
                   showCancelButton: !0,
                   confirmButtonColor: "#31ce77",
                   cancelButtonColor: "#f34943",
                   confirmButtonText: "Confirmar"
               }).then(function(t) {
                if (t.value == true)
                {
                    scope.tContacto_data_modal.ConPrin=true;                        
                    var url=base_urlHome()+"api/Clientes/UpdateOldContacto/CodConCli/"+result.data.CodConCli;
                    $http.get(url).then(function(result)
                    {
                        if(result.data!=false)
                        {
                            scope.toast('info','El Contacto anterior ya no es principal guarde los datos para establecer este como principal.','');
                        }
                        else
                        {
                            scope.toast('error','Ha ocurrido un error al intenta actualizar el contacto.','');
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
                else 
                {
                    scope.tContacto_data_modal.ConPrin=false;
                    scope.toast('error','Contacto no establecido como principal','Contacto No Principal');
                    console.log('cancelando ando...');
                }
            });


                    //scope.toast('error','Este Cliente ya tiene un contacto como principal','Error 404');
                }
                else
                {
                    scope.tContacto_data_modal.ConPrin=true;
                    scope.toast('success','Contacto Seleccionado como Principal.','Contacto Principal');
                }

            },function(error)
            {
                $("#Principal").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
scope.BuscarLocalidad=function(metodo,CodPro)
{   
    var url = base_urlHome()+"api/Clientes/BuscarLocalidadesFil/CodPro/"+CodPro;
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
scope.containerClicked = function() 
{
    scope.searchResultCPLoc = {};
}
scope.searchboxClicked = function($event) 
{
    $event.stopPropagation();
}
scope.LocalidadCodigoPostal=function(metodo)
{
  if(metodo==1)
  {
    var searchText_len = scope.tContacto_data_modal.CPLocSoc.trim().length;
    var url= base_urlHome()+"api/Clientes/LocalidadCodigoPostal/CPLoc/"+scope.tContacto_data_modal.CPLocSoc;
  }
  else if(metodo==2)
  {
    var searchText_len = scope.tContacto_data_modal.CPLocFis.trim().length;
    var url= base_urlHome()+"api/Clientes/LocalidadCodigoPostal/CPLoc/"+scope.tContacto_data_modal.CPLocFis;
  } 
  $http.get(url).then(function(result) 
  {
    if (result.data != false) 
    {
      if(metodo==1)
      {
        scope.searchResultCPLoc = result.data;
      }
      else if (metodo==2)
      {
        scope.searchResultFis=result.data;
      }
    }
    else
    {                    
      if(metodo==1)
      {
          scope.searchResultCPLoc = {};
          scope.toast('error','No se Encontraron Provincias & Localidades Registradas con este código postal','Error');
          scope.fpuntosuministro.CPLocSoc=null;
      }
      else if(metodo==2)
      {
        scope.searchResultFis = {};
        scope.toast('error','No se Encontraron Provincias & Localidades Registradas con este código postal','Error');
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

    /*
    if (searchText_len >=3) 
    {
    if(metodo==1)
    {
      
    }
     
 } 
 else 
 {
    scope.searchResultCPLoc = {};
}*/
}
scope.setValueCPLoc = function(index, $event, result, metodo) 
{
    if (metodo == 1) 
    {
        console.log(index);
        console.log($event);
        console.log(result);
        console.log(metodo);
        scope.tContacto_data_modal.CodProSoc=scope.searchResultCPLoc[index].CodPro;
        scope.BuscarLocalidad(1,scope.tContacto_data_modal.CodProSoc);
        scope.tContacto_data_modal.CodLocSoc=scope.searchResultCPLoc[index].CodLoc;
        scope.tContacto_data_modal.CPLocSoc= scope.searchResultCPLoc[index].CPLoc;
        scope.searchResultCPLoc = {};
        $event.stopPropagation();
    }
    if (metodo == 2) 
    {
        console.log(index);
        console.log($event);
        console.log(result);
        console.log(metodo);
        scope.tContacto_data_modal.CodProFis=scope.searchResultFis[index].CodPro;
        scope.BuscarLocalidad(2,scope.tContacto_data_modal.CodProFis);
        scope.tContacto_data_modal.CodLocFis=scope.searchResultFis[index].CodLoc;
        scope.tContacto_data_modal.CPLocFis= scope.searchResultFis[index].CPLoc;
        scope.searchResultFis = {};
        $event.stopPropagation();
    }
    
}

$scope.SubmitFormClienteContactos = function(event) 
{
  if (!scope.validar_campos_detalles()) 
  {
    return false;
  }
    //Swal.fire({
    //title: 'Estás seguro de asignar este cliente a este contacto?',
    //type: "question",
    //showCancelButton: !0,
    //confirmButtonColor: "#31ce77",
    //cancelButtonColor: "#f34943",
    //confirmButtonText: "OK"
   // }).then(function(t) 
    //{
      //if (t.value == true) 
     // {
        var ObjDetCUPs = new Object();
        if (scope.Tabla_Contacto== undefined || scope.Tabla_Contacto == false) 
        {
          scope.Tabla_Contacto = [];
        }
        scope.Tabla_Contacto.push({CodCli:scope.CodCliInsert,NumCifCli:scope.NumCifCli,RazSocCli:scope.RazSocCli,EsRepLeg:scope.EsRepLeg,TipRepr:scope.TipRepr,CanMinRep:scope.CanMinRep,TieFacEsc:scope.TieFacEsc,
        EsColaborador:scope.EsColaborador,EsPrescritor:scope.EsPrescritor,DocPod:scope.DocPod});
        scope.toast('success','Cliente Asignado Correctamente.','');
        $("#modal_agregar_clientes").modal('hide');
        scope.CodCliContacto=null;
        scope.CodCliInsert=null;
        scope.NumCifCli=null;
        scope.RazSocCli=null;
        scope.EsRepLeg=null;
        scope.TipRepr='1';
        scope.CanMinRep='1';
        scope.TieFacEsc=null;
        scope.EsColaborador=null;
        scope.EsPrescritor=null;
        scope.DocPod=null;
        console.log(scope.Tabla_Contacto);
      //} 
      //else 
      //{
       // console.log('Cancelando ando...');
      //}
    //});

};
scope.validar_campos_detalles = function() 
    {
        resultado = true;        
        if(scope.CodCliContacto==null||scope.CodCliContacto==undefined||scope.CodCliContacto=='')
        {
          scope.toast('error','Debe Seleccionar un Cliente.','Error');
          return false;
        }
        if(scope.EsRepLeg==null||scope.EsRepLeg==undefined)
        {
          scope.toast('error','Debe indicar si es representante legal o no.','Error');
          return false;
        }
        else
        {
          if(scope.EsRepLeg==0)
          {
            scope.DocPod=null;
          }
          else if(scope.EsRepLeg==1)
          {
            if(!scope.TipRepr>0)
            {
              scope.toast('error','Debe seleccionar un tipo de representación','Error');
              return false;
            }
            if(scope.CanMinRep<0)
            {
              scope.toast('error','La cantidad de firmantes debe ser mayor a 0.','Error');
              return false;
            }
            if(scope.DocPod==null||scope.DocPod==undefined)
            {
              scope.DocPod=null;
            }
            else
            {
              scope.DocPod=scope.DocPod;
            }
          }
        }
        if (resultado == false) 
        {
          return false;
        }
        return true;
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


        if (scope.nID != undefined) {
           scope.BuscarXIDContactos();
           scope.cargar_tiposContactos(9);
           scope.cargar_tiposContactos(3);
           scope.cargar_tiposContactos(12);
       }
       else
       {
           scope.cargar_tiposContactos(9);
           scope.cargar_tiposContactos(3);
           scope.cargar_tiposContactos(12);
       }
       if($route.current.$$route.originalPath=="/Contactos/")
       {
        scope.cargar_lista_contactos();

    }
     ////////////////////////////////////////////////// PARA LOS CONTACTOS END ////////////////////////////////////////////////////////
 }