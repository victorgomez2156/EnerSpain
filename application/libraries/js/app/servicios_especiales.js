 app.controller('Controlador_Servicios_Especiales', ['$http', '$scope', '$filter', '$route', '$interval', '$controller', '$cookies', '$compile', 'ServiceComercializadora', 'upload', Controlador])
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

 function Controlador($http, $scope, $filter, $route, $interval, $controller, $cookies, $compile, ServiceComercializadora, upload) {
     //declaramos una variable llamada scope donde tendremos a vm
     /*inyectamos un controlador para acceder a sus variables y metodos*/
     //$controller('Controlador_Clientes as vmAE',{$scope:$scope});
     //var testCtrl1ViewModel = $scope.$new(); //You need to supply a scope while instantiating.	
     //$controller('Controlador_Clientes',{$scope : testCtrl1ViewModel });		
     //var testCtrl1ViewModel = $controller('Controlador_Clientes');
     //testCtrl1ViewModel.cargar_lista_clientes();
     var scope = this;
     scope.fdatos = {};
     scope.nIDSerEsp = $route.current.params.ID;
     scope.INF = $route.current.params.INF;
     scope.Nivel = $cookies.get('nivel');
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
     scope.NumCifCom = true;
     scope.RazSocCom = true;
     scope.DesSerEsp = true;
     scope.TipCli = true;
     scope.SerElecSerEsp = true;
     scope.SerGasSerEsp = true;
     scope.FecIniSerEsp = true;
     scope.EstSerEsp = true;
     scope.AccSerEsp = true;
     scope.reporte_pdf_servicio_especiales = 0;
     scope.reporte_excel_servicio_especiales = 0;
     scope.TServicioEspeciales = [];
     scope.TServicioEspecialesBack = [];
     scope.servicio_especial = {};

     scope.servicio_especial.SerEle = false;
     scope.servicio_especial.SerGas = false;
     scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj = [];
     scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt = [];
     scope.select_tarifa_Elec_Baj_SerEsp = []
     scope.select_tarifa_Elec_Alt_SerEsp = [];
     scope.select_tarifa_gas_SerEsp = [];

     scope.servicio_especial.T_DetalleServicioEspecialTarifaGas = [];
     scope.ttipofiltrosServicioEspecial = [{ id: 1, nombre: 'Comercializadora' }, { id: 2, nombre: 'Tipo de Suministro' }, { id: 3, nombre: 'Tipo de Cliente' }, { id: 4, nombre: 'Tipo Comisión' }, { id: 5, nombre: 'Fecha de Inicio' }, { id: 6, nombre: 'Estatus' }];
     scope.Topciones_Grib = [{ id: 4, nombre: 'Ver' }, { id: 3, nombre: 'Editar' }, { id: 1, nombre: 'Activar' }, { id: 2, nombre: 'Bloquear' }, { id: 5, nombre: 'Comisiones' }];
     //scope.Topciones_Grib = [{id: 4, nombre: 'VER'},{id: 3, nombre: 'EDITAR'},{id: 1, nombre: 'ACTIVAR'},{id: 2, nombre: 'BLOQUEAR'},{id: 5, nombre: 'COMISIONES'}];
     scope.validate_info_servicio_especiales = scope.INF;
     console.log($route.current.$$route.originalPath);

     scope.TComisionesDet = [];
     scope.TComisionesRangoGrib = [];
     ////////////////////////////////////////////////// PARA LA LISTA Y CONFIGURACIONES DE SERVICIOS ESPECIALES START ////////////////////////////////////////////////////////
     ServiceComercializadora.getAll().then(function(dato) {

         scope.Tcomercializadoras = dato.Comercializadora;
         scope.Tipos_Comision = dato.Tipos_Comision;
         scope.Tarifa_Gas_Anexos = dato.Tarifa_Gas;
         scope.Tarifa_Ele_Anexos = dato.Tarifa_Ele;
         scope.FecIniSerEspForm = dato.fecha;
         $('.datepicker').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.FecIniSerEspForm);
         scope.Fecha_Server = dato.fecha;
         $scope.predicate3 = 'id';
         $scope.reverse3 = true;
         $scope.currentPage3 = 1;
         $scope.order3 = function(predicate3) {
             $scope.reverse3 = ($scope.predicate3 === predicate3) ? !$scope.reverse3 : false;
             $scope.predicate3 = predicate3;
         };
         scope.TServicioEspeciales = dato.Servicios_Especiales;
         scope.TServicioEspecialesBack = dato.Servicios_Especiales;
         $scope.totalItems3 = scope.TServicioEspeciales.length;
         $scope.numPerPage3 = 50;
         $scope.paginate3 = function(value3) {
             var begin3, end3, index3;
             begin3 = ($scope.currentPage3 - 1) * $scope.numPerPage3;
             end3 = begin3 + $scope.numPerPage3;
             index3 = scope.TServicioEspeciales.indexOf(value3);
             return (begin3 <= index3 && index3 < end3);
         };
         if(scope.TServicioEspeciales==false || scope.TServicioEspeciales==undefined)
         {
            scope.TServicioEspeciales=[];
         }
         console.log(scope.TServicioEspeciales);
         angular.forEach(scope.Tarifa_Ele_Anexos, function(Tarifa_Electrica) {
             if (Tarifa_Electrica.TipTen == 'BAJA') {
                 var ObjTarifaElecBaj = new Object();
                 if (scope.Tarifa_Elec_Baja == undefined || scope.Tarifa_Elec_Baja == false) {
                     scope.Tarifa_Elec_Baja = [];
                 }
                 scope.Tarifa_Elec_Baja.push({ TipTen: Tarifa_Electrica.TipTen, NomTarEle: Tarifa_Electrica.NomTarEle, MinPotCon: Tarifa_Electrica.MinPotCon, MaxPotCon: Tarifa_Electrica.MaxPotCon, CodTarEle: Tarifa_Electrica.CodTarEle, CanPerTar: Tarifa_Electrica.CanPerTar });
                //console.log(scope.Tarifa_Elec_Baja);
             } else {
                 var ObjTarifaElecAlt = new Object();
                 if (scope.Tarifa_Elec_Alt == undefined || scope.Tarifa_Elec_Alt == false) {
                     scope.Tarifa_Elec_Alt = [];
                 }
                 scope.Tarifa_Elec_Alt.push({ TipTen: Tarifa_Electrica.TipTen, NomTarEle: Tarifa_Electrica.NomTarEle, MinPotCon: Tarifa_Electrica.MinPotCon, MaxPotCon: Tarifa_Electrica.MaxPotCon, CodTarEle: Tarifa_Electrica.CodTarEle, CanPerTar: Tarifa_Electrica.CanPerTar });
                //console.log(scope.Tarifa_Elec_Alt);
             }
         });
     }).catch(function(error) {
         console.log(error); //Tratar el error
         /*if(error.status==404 && error.statusText=="Not Found")
         {
         	Swal.fire({title:"Error.",text:"El método que está intentando usar no puede ser localizado",type:"error",confirmButtonColor:"#188ae2"});
         }
         if(error.status==401 && error.statusText=="Unauthorized")
         {
         	Swal.fire({title:"Error de Privilegios",text:"Usuario no autorizado para acceder a este Módulo",type:"info",confirmButtonColor:"#188ae2"});
         }
         if(error.status==403 && error.statusText=="Forbidden")
         {
         	Swal.fire({title:"Seguridad.",text:"Está intentando utilizar un APIKEY incorrecto",type:"question",confirmButtonColor:"#188ae2"});
         }
         if(error.status==500 && error.statusText=="Internal Server Error")
         {				
         	Swal.fire({title:"Error.",text:"Ha ocurrido una falla en el Servidor, intente más tarde",type:"error",confirmButtonColor:"#188ae2"});
         }*/

     });

     scope.cargar_lista_servicos_especiales = function() {
         $("#List_Serv").removeClass("loader loader-default").addClass("loader loader-default  is-active");
         var url = base_urlHome() + "api/Comercializadora/get_list_servicos_especiales/";
         $http.get(url).then(function(result) {
             $("#List_Serv").removeClass("loader loader-default is-active").addClass("loader loader-default");
             if (result.data != false) {
                 $scope.predicate3 = 'id';
                 $scope.reverse3 = true;
                 $scope.currentPage3 = 1;
                 $scope.order3 = function(predicate3) {
                     $scope.reverse3 = ($scope.predicate3 === predicate3) ? !$scope.reverse3 : false;
                     $scope.predicate3 = predicate3;
                 };
                 scope.TServicioEspeciales = result.data;
                 scope.TServicioEspecialesBack = result.data;
                 $scope.totalItems3 = scope.TServicioEspeciales.length;
                 $scope.numPerPage3 = 50;
                 $scope.paginate3 = function(value3) {
                     var begin3, end3, index3;
                     begin3 = ($scope.currentPage3 - 1) * $scope.numPerPage3;
                     end3 = begin3 + $scope.numPerPage3;
                     index3 = scope.TServicioEspeciales.indexOf(value3);
                     return (begin3 <= index3 && index3 < end3);
                 };
             } else {
                 console.log('No hemos encontrado servicios especiales registrados.');
                 Swal.fire({ title: "Error", text: 'No hemos encontrado servicios especiales registrados.', type: "error", confirmButtonColor: "#188ae2" });
                 scope.TServicioEspeciales = [];
                 scope.TServicioEspecialesBack = [];
             }
         }, function(error) {
             $("#List_Serv").removeClass("loader loader-default is-active").addClass("loader loader-default");
             if (error.status == 404 && error.statusText == "Not Found") {
                 Swal.fire({ title: "Error.", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
             }
             if (error.status == 401 && error.statusText == "Unauthorized") {
                 Swal.fire({ title: "Error de Privilegios", text: "Usuario no autorizado para acceder a este Módulo", type: "info", confirmButtonColor: "#188ae2" });
             }
             if (error.status == 403 && error.statusText == "Forbidden") {
                 Swal.fire({ title: "Seguridad.", text: "Está intentando utilizar un APIKEY incorrecto", type: "question", confirmButtonColor: "#188ae2" });
             }
             if (error.status == 500 && error.statusText == "Internal Server Error") {
                 Swal.fire({ title: "Error.", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
             }
         });
     }

     $scope.SubmitFormFiltrosServiciosEspeciales = function(event) {
         if (scope.tmodal_servicio_especiales.ttipofiltrosServicioEspecial == 1) {
             if (!scope.tmodal_servicio_especiales.CodCom > 0) {
                 Swal.fire({ title: "Comercializadora", text: 'Debe Seleccionar una Comercializadora de la lista.', type: "error", confirmButtonColor: "#188ae2" });
                 return false;
             }
             $scope.predicate3 = 'id';
             $scope.reverse3 = true;
             $scope.currentPage3 = 1;
             $scope.order3 = function(predicate3) {
                 $scope.reverse3 = ($scope.predicate3 === predicate3) ? !$scope.reverse3 : false;
                 $scope.predicate3 = predicate3;
             };
             scope.TServicioEspeciales = $filter('filter')(scope.TServicioEspecialesBack, { NumCifCom: scope.tmodal_servicio_especiales.CodCom }, true);
             $scope.totalItems3 = scope.TServicioEspeciales.length;
             $scope.numPerPage3 = 50;
             $scope.paginate3 = function(value3) {
                 var begin3, end3, index3;
                 begin3 = ($scope.currentPage3 - 1) * $scope.numPerPage3;
                 end3 = begin3 + $scope.numPerPage3;
                 index3 = scope.TServicioEspeciales.indexOf(value3);
                 return (begin3 <= index3 && index3 < end3);
             };
             console.log(scope.TServicioEspeciales);
             scope.reporte_pdf_servicio_especiales = scope.tmodal_servicio_especiales.ttipofiltrosServicioEspecial + "/" + scope.tmodal_servicio_especiales.CodCom;
             scope.reporte_excel_servicio_especiales = scope.tmodal_servicio_especiales.ttipofiltrosServicioEspecial + "/" + scope.tmodal_servicio_especiales.CodCom;
         }
         if (scope.tmodal_servicio_especiales.ttipofiltrosServicioEspecial == 2) {
             if (!scope.tmodal_servicio_especiales.TipServ > 0) {
                 Swal.fire({ title: 'Tipo Suministro', text: 'Debe Seleccionar un Tipo de Suministro de la lista.', type: "error", confirmButtonColor: "#188ae2" });
                 return false;
             }
             /*if(!scope.tmodal_servicio_especiales.Select>0)
             {
             	Swal.fire({title:"Error",text:"Seleccione un Elemento de la Lista.",type:"error",confirmButtonColor:"#188ae2"});
             	return false;
             }*/
             $scope.predicate3 = 'id';
             $scope.reverse3 = true;
             $scope.currentPage3 = 1;
             $scope.order3 = function(predicate3) {
                 $scope.reverse3 = ($scope.predicate3 === predicate3) ? !$scope.reverse3 : false;
                 $scope.predicate3 = predicate3;
             };
             if (scope.tmodal_servicio_especiales.TipServ == 1) {
                 scope.Servicio = "GAS";
                 scope.TServicioEspeciales = $filter('filter')(scope.TServicioEspecialesBack, { SerGas: scope.tmodal_servicio_especiales.Select }, true);
             }
             if (scope.tmodal_servicio_especiales.TipServ == 2) {
                 scope.Servicio = "ELÉCTRICO";
                 scope.TServicioEspeciales = $filter('filter')(scope.TServicioEspecialesBack, { SerEle: scope.tmodal_servicio_especiales.Select }, true);

             }
             if (scope.tmodal_servicio_especiales.TipServ == 3) {
                 scope.Servicio = "AMBOS";
                 //scope.TServicioEspeciales =$filter('filter')(scope.TServicioEspecialesBack, {SerEle: scope.tmodal_servicio_especiales.Select}, true);
             }
             $scope.totalItems3 = scope.TServicioEspeciales.length;
             $scope.numPerPage3 = 50;
             $scope.paginate3 = function(value3) {
                 var begin3, end3, index3;
                 begin3 = ($scope.currentPage3 - 1) * $scope.numPerPage3;
                 end3 = begin3 + $scope.numPerPage3;
                 index3 = scope.TServicioEspeciales.indexOf(value3);
                 return (begin3 <= index3 && index3 < end3);
             };
             console.log(scope.TServicioEspeciales);
             scope.reporte_pdf_servicio_especiales = scope.tmodal_servicio_especiales.ttipofiltrosServicioEspecial + "/" + scope.Servicio;
             scope.reporte_excel_servicio_especiales = scope.tmodal_servicio_especiales.ttipofiltrosServicioEspecial + "/" + scope.Servicio;
         }
         if (scope.tmodal_servicio_especiales.ttipofiltrosServicioEspecial == 3) {
             if (!scope.tmodal_servicio_especiales.TipCli > 0) {
                 Swal.fire({ title: "Tipo Cliente", text: 'Debe Seleccionar un Tipo de Cliente de la lista.', type: "error", confirmButtonColor: "#188ae2" });
                 return false;
             }
             $scope.predicate3 = 'id';
             $scope.reverse3 = true;
             $scope.currentPage3 = 1;
             $scope.order3 = function(predicate3) {
                 $scope.reverse3 = ($scope.predicate3 === predicate3) ? !$scope.reverse3 : false;
                 $scope.predicate3 = predicate3;
             };
             scope.TServicioEspeciales = $filter('filter')(scope.TServicioEspecialesBack, { TipCli: scope.tmodal_servicio_especiales.TipCli }, true);
             $scope.totalItems3 = scope.TServicioEspeciales.length;
             $scope.numPerPage3 = 50;
             $scope.paginate3 = function(value3) {
                 var begin3, end3, index3;
                 begin3 = ($scope.currentPage3 - 1) * $scope.numPerPage3;
                 end3 = begin3 + $scope.numPerPage3;
                 index3 = scope.TServicioEspeciales.indexOf(value3);
                 return (begin3 <= index3 && index3 < end3);
             };
             console.log(scope.TServicioEspeciales);
             scope.reporte_pdf_servicio_especiales = scope.tmodal_servicio_especiales.ttipofiltrosServicioEspecial + "/" + scope.tmodal_servicio_especiales.TipCli;
             scope.reporte_excel_servicio_especiales = scope.tmodal_servicio_especiales.ttipofiltrosServicioEspecial + "/" + scope.tmodal_servicio_especiales.TipCli;
         }
         if (scope.tmodal_servicio_especiales.ttipofiltrosServicioEspecial == 4) {
             if (!scope.tmodal_servicio_especiales.DesTipCom > 0) {
                 Swal.fire({ title: "Tipo Comision", text: 'Debe Seleccionar un Tipo de Comisión de la lista.', type: "error", confirmButtonColor: "#188ae2" });
                 return false;
             }
             $scope.predicate3 = 'id';
             $scope.reverse3 = true;
             $scope.currentPage3 = 1;
             $scope.order3 = function(predicate3) {
                 $scope.reverse3 = ($scope.predicate3 === predicate3) ? !$scope.reverse3 : false;
                 $scope.predicate3 = predicate3;
             };

             scope.TServicioEspeciales = $filter('filter')(scope.TServicioEspecialesBack, { DesTipCom: scope.tmodal_servicio_especiales.DesTipCom }, true);
             $scope.totalItems3 = scope.TServicioEspeciales.length;
             $scope.numPerPage3 = 50;
             $scope.paginate3 = function(value3) {
                 var begin3, end3, index3;
                 begin3 = ($scope.currentPage3 - 1) * $scope.numPerPage3;
                 end3 = begin3 + $scope.numPerPage3;
                 index3 = scope.TServicioEspeciales.indexOf(value3);
                 return (begin3 <= index3 && index3 < end3);
             };
             console.log(scope.TServicioEspeciales);
             scope.reporte_pdf_servicio_especiales = scope.tmodal_servicio_especiales.ttipofiltrosServicioEspecial + "/" + scope.tmodal_servicio_especiales.DesTipCom;
             scope.reporte_excel_servicio_especiales = scope.tmodal_servicio_especiales.ttipofiltrosServicioEspecial + "/" + scope.tmodal_servicio_especiales.DesTipCom;
         }
         if (scope.tmodal_servicio_especiales.ttipofiltrosServicioEspecial == 5) {
             var FecIniSerEsp = document.getElementById("FecIniSerEsp").value;
             scope.tmodal_servicio_especiales.FecIniSerEsp = FecIniSerEsp;
             if (scope.tmodal_servicio_especiales.FecIniSerEsp == undefined || scope.tmodal_servicio_especiales.FecIniSerEsp == null || scope.tmodal_servicio_especiales.FecIniSerEsp == "") {
                 Swal.fire({ title: "Fecha de Inicio", text: 'La Fecha de Inicio es Requerida.', type: "error", confirmButtonColor: "#188ae2" });
                 return false;
             } else {
                 var FecIniSerEsp = (scope.tmodal_servicio_especiales.FecIniSerEsp).split("/");
                 if (FecIniSerEsp.length < 3) {
                     Swal.fire({ title: "Fecha de Inicio", text: "El Formato de la Fecha de Inicio de Ser: " + fecha, type: "error", confirmButtonColor: "#188ae2" });
                     event.preventDefault();
                     return false;
                 } else {
                     if (FecIniSerEsp[0].length > 2 || FecIniSerEsp[0].length < 2) {
                         Swal.fire({ title: "Fecha de Inicio", text: "El Formato del Día Debe Ser: " + dd, type: "error", confirmButtonColor: "#188ae2" });
                         event.preventDefault();
                         return false;

                     }
                     if (FecIniSerEsp[1].length > 2 || FecIniSerEsp[1].length < 2) {
                         Swal.fire({ title: "Fecha de Inicio", text: "El Formato del Mes Debe Ser: " + mm, type: "error", confirmButtonColor: "#188ae2" });
                         event.preventDefault();
                         return false;
                     }
                     if (FecIniSerEsp[2].length < 4 || FecIniSerEsp[2].length > 4) {
                         Swal.fire({ title: "Fecha de Inicio", text: "El Formato del Año Debe Ser: " + yyyy, type: "error", confirmButtonColor: "#188ae2" });
                         event.preventDefault();
                         return false;
                     }
                     scope.tmodal_servicio_especiales.FecIniSerEsp = FecIniSerEsp[0] + "/" + FecIniSerEsp[1] + "/" + FecIniSerEsp[2];
                 }
             }
             $scope.predicate3 = 'id';
             $scope.reverse3 = true;
             $scope.currentPage3 = 1;
             $scope.order3 = function(predicate3) {
                 $scope.reverse3 = ($scope.predicate3 === predicate3) ? !$scope.reverse3 : false;
                 $scope.predicate3 = predicate3;
             };

             scope.TServicioEspeciales = $filter('filter')(scope.TServicioEspecialesBack, { FecIniSerEsp: scope.tmodal_servicio_especiales.FecIniSerEsp }, true);
             $scope.totalItems3 = scope.TServicioEspeciales.length;
             $scope.numPerPage3 = 50;
             $scope.paginate3 = function(value3) {
                 var begin3, end3, index3;
                 begin3 = ($scope.currentPage3 - 1) * $scope.numPerPage3;
                 end3 = begin3 + $scope.numPerPage3;
                 index3 = scope.TServicioEspeciales.indexOf(value3);
                 return (begin3 <= index3 && index3 < end3);
             };
             console.log(scope.TServicioEspeciales);
             scope.reporte_pdf_servicio_especiales = scope.tmodal_servicio_especiales.ttipofiltrosServicioEspecial + "/" + scope.tmodal_servicio_especiales.FecIniSerEsp;
             scope.reporte_excel_servicio_especiales = scope.tmodal_servicio_especiales.ttipofiltrosServicioEspecial + "/" + scope.tmodal_servicio_especiales.FecIniSerEsp;
         }
         if (scope.tmodal_servicio_especiales.ttipofiltrosServicioEspecial == 6) {
             if (!scope.tmodal_servicio_especiales.EstSerEsp > 0) {
                 Swal.fire({ title: "Estatus", text: 'Debe Seleccionar un Estatus de la lista.', type: "error", confirmButtonColor: "#188ae2" });
                 return false;
             }
             $scope.predicate2 = 'id';
             $scope.reverse2 = true;
             $scope.currentPage2 = 1;
             $scope.order2 = function(predicate2) {
                 $scope.reverse2 = ($scope.predicate2 === predicate2) ? !$scope.reverse2 : false;
                 $scope.predicate2 = predicate2;
             };
             scope.TServicioEspeciales = $filter('filter')(scope.TServicioEspecialesBack, { EstSerEsp: scope.tmodal_servicio_especiales.EstSerEsp }, true);
             $scope.totalItems2 = scope.TServicioEspeciales.length;
             $scope.numPerPage2 = 50;
             $scope.paginate2 = function(value2) {
                 var begin2, end2, index2;
                 begin2 = ($scope.currentPage2 - 1) * $scope.numPerPage2;
                 end2 = begin2 + $scope.numPerPage2;
                 index2 = scope.TServicioEspeciales.indexOf(value2);
                 return (begin2 <= index2 && index2 < end2);
             };
             console.log(scope.TServicioEspeciales);
             scope.reporte_pdf_servicio_especiales = scope.tmodal_servicio_especiales.ttipofiltrosServicioEspecial + "/" + scope.tmodal_servicio_especiales.EstSerEsp;
             scope.reporte_excel_servicio_especiales = scope.tmodal_servicio_especiales.ttipofiltrosServicioEspecial + "/" + scope.tmodal_servicio_especiales.EstSerEsp;
         }
     };
     scope.regresar_filtro_servicio_especial = function() {
         scope.tmodal_servicio_especiales = {};
         scope.reporte_pdf_servicio_especiales = 0;
         scope.reporte_excel_servicio_especiales = 0;
         $scope.predicate3 = 'id';
         $scope.reverse3 = true;
         $scope.currentPage3 = 1;
         $scope.order3 = function(predicate3) {
             $scope.reverse3 = ($scope.predicate3 === predicate3) ? !$scope.reverse3 : false;
             $scope.predicate3 = predicate3;
         };
         scope.TServicioEspeciales = scope.TServicioEspecialesBack;
         $scope.totalItems3 = scope.TServicioEspeciales.length;
         $scope.numPerPage3 = 50;
         $scope.paginate3 = function(value3) {
             var begin3, end3, index3;
             begin3 = ($scope.currentPage3 - 1) * $scope.numPerPage3;
             end3 = begin3 + $scope.numPerPage3;
             index3 = scope.TServicioEspeciales.indexOf(value3);
             return (begin3 <= index3 && index3 < end3);
         };
         console.log(scope.TServicioEspeciales);
     }
     scope.validarsifechaserespe = function(object, metodo) {
         if (object != undefined && metodo == 1) {
             numero = object;
             if (!/^([/0-9])*$/.test(numero))
                 scope.tmodal_servicio_especiales.FecIniSerEsp = numero.substring(0, numero.length - 1);
         }
         if (object != undefined && metodo == 2) {
             numero = object;
             if (!/^([/0-9])*$/.test(numero))
                 scope.FecBloSerEsp = numero.substring(0, numero.length - 1);
         }
     }

     scope.validar_opcion_servicios_especiales = function(index, opciones_servicio_especiales, dato) {
         console.log(index);
         console.log(opciones_servicio_especiales);
         console.log(dato);
         scope.opciones_servicio_especiales[index] = undefined;
         if (opciones_servicio_especiales == 1) {
             if (dato.EstSerEsp == "ACTIVO") {
                 Swal.fire({ title: 'Activando', text: 'Este Servicio Especial ya se encuentra activo.', type: "error", confirmButtonColor: "#188ae2" });
                 return false;
             }
             Swal.fire({
                 title: 'Activando',
                 text: '¿Seguro que desea activar el Servicio Especial?',
                 type: "question",
                 showCancelButton: !0,
                 confirmButtonColor: "#31ce77",
                 cancelButtonColor: "#f34943",
                 confirmButtonText: 'Confirmar'
             }).then(function(t) {
                 if (t.value == true) {
                     scope.cambiar_estatus_servicio_especial(opciones_servicio_especiales, dato.CodSerEsp, index);
                 } else {
                     console.log('Cancelando ando...');
                 }
             });
         }
         if (opciones_servicio_especiales == 2) {
             if (dato.EstSerEsp == "BLOQUEADO") {
                 Swal.fire({ title: 'Bloqueando', text: 'Este Servicio Especial se encuentra bloqueado ya.', type: "error", confirmButtonColor: "#188ae2" });
                 return false;
             }
             scope.servicio_especial_bloqueo = {};
             scope.RazSocCom_BloSerEsp = dato.NumCifCom + " - " + dato.RazSocCom;
             scope.DesSerEsp_Blo = dato.DesSerEsp;
             scope.FecBloSerEsp = scope.Fecha_Server;
             $('.datepicker2').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.FecBloSerEsp);
             scope.servicio_especial_bloqueo.CodSerEsp = dato.CodSerEsp;
             scope.servicio_especial_bloqueo.EstSerEsp = opciones_servicio_especiales;
             $("#modal_motivo_bloqueo_servicio_especial").modal('show');
         }
         if (opciones_servicio_especiales == 3) {
             location.href = "#/Edit_Servicios_Adicionales/" + dato.CodSerEsp;
         }
         if (opciones_servicio_especiales == 4) {
             location.href = "#/Ver_Servicios_Adicionales/" + dato.CodSerEsp + "/" + 1;
         }
         if (opciones_servicio_especiales == 5) {
             location.href = "#/Comisiones_Servicios_Adicionales/" + dato.CodSerEsp + "/" + dato.NumCifCom + "/" + dato.RazSocCom + "/" + dato.DesSerEsp;
         }
     }

     scope.cambiar_estatus_servicio_especial = function(opciones_servicio_especiales, CodSerEsp, index) {
         scope.status_servicio_especial = {};
         scope.status_servicio_especial.EstSerEsp = opciones_servicio_especiales;
         scope.status_servicio_especial.CodSerEsp = CodSerEsp;

         if (opciones_servicio_especiales == 2) {
             scope.status_servicio_especial.MotBloSerEsp = scope.servicio_especial_bloqueo.MotBloSerEsp;
             scope.status_servicio_especial.ObsMotBloSerEsp = scope.servicio_especial_bloqueo.ObsMotBloSerEsp;
             scope.status_servicio_especial.FecBlo = scope.servicio_especial_bloqueo.FecBlo;
             console.log(scope.status_servicio_especial);
         }
         console.log(scope.status_servicio_especial);
         $("#estatus").removeClass("loader loader-default").addClass("loader loader-default is-active");
         var url = base_urlHome() + "api/Comercializadora/cambiar_estatus_servicio_especial/";
         $http.post(url, scope.status_servicio_especial).then(function(result) {
             if (result.data.resultado != false) {
                 if (opciones_servicio_especiales == 1) {
                     var title = 'Activando';
                     var text = 'El Servicio Especial ha sido activado de forma correcta';
                 }
                 if (opciones_servicio_especiales == 2) {
                     var title = 'Bloqueando';
                     var text = 'El Servicio Especial ha sido bloqueado de forma correcta';
                     $("#modal_motivo_bloqueo_servicio_especial").modal('hide');
                 }
                 $("#estatus").removeClass("loader loader-default is-active").addClass("loader loader-default");
                 Swal.fire({ title: title, text: text, type: "success", confirmButtonColor: "#188ae2" });
                 scope.opciones_servicio_especiales[index] = undefined;
                 scope.cargar_lista_servicos_especiales();
             } else {
                 $("#estatus").removeClass("loader loader-default is-active").addClass("loader loader-default");
                 Swal.fire({ title: "Error", text: 'Un error a ocurrido en el proceso de actualización del estatus.', type: "error", confirmButtonColor: "#188ae2" });
                 scope.cargar_lista_servicos_especiales();
             }
         }, function(error) {
             $("#estatus").removeClass("loader loader-default is-active").addClass("loader loader-default");
             if (error.status == 404 && error.statusText == "Not Found") {
                 Swal.fire({ title: "Error.", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
             }
             if (error.status == 401 && error.statusText == "Unauthorized") {
                 Swal.fire({ title: "Error de Privilegios", text: "Usuario no autorizado para acceder a este Módulo", type: "info", confirmButtonColor: "#188ae2" });
             }
             if (error.status == 403 && error.statusText == "Forbidden") {
                 Swal.fire({ title: "Seguridad.", text: "Está intentando utilizar un APIKEY incorrecto", type: "question", confirmButtonColor: "#188ae2" });
             }
             if (error.status == 500 && error.statusText == "Internal Server Error") {
                 Swal.fire({ title: "Error.", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
             }

         });
     }

     $scope.submitFormlockServicioEspecial = function(event) {
         if (scope.servicio_especial_bloqueo.ObsMotBloSerEsp == undefined || scope.servicio_especial_bloqueo.ObsMotBloSerEsp == null || scope.servicio_especial_bloqueo.ObsMotBloSerEsp == '') {
             scope.servicio_especial_bloqueo.ObsMotBloSerEsp = null;
         } else {
             scope.servicio_especial_bloqueo.ObsMotBloSerEsp = scope.servicio_especial_bloqueo.ObsMotBloSerEsp;
         }
         var FecBloSerEsp1 = document.getElementById("FecBloSerEsp").value;
         scope.FecBloSerEsp = FecBloSerEsp1;
         if (scope.FecBloSerEsp == undefined || scope.FecBloSerEsp == null || scope.FecBloSerEsp == '') {
             Swal.fire({ title: 'Fecha de Bloqueo', text: 'La Fecha de Bloqueo es requerido', type: "error", confirmButtonColor: "#188ae2" });
             return false;
         } else {
             var FecBlo = (scope.FecBloSerEsp).split("/");
             if (FecBlo.length < 3) {
                 Swal.fire({ title: 'Fecha de Bloqueo', text: 'El Formato de la Fecha de Bloqueo Debe Ser: ' + scope.Fecha_Server, type: "error", confirmButtonColor: "#188ae2" });
                 event.preventDefault();
                 return false;
             } else {
                 if (FecBlo[0].length > 2 || FecBlo[0].length < 2) {
                     Swal.fire({ title: 'Fecha de Bloqueo', text: 'El Formato Día la Fecha de Bloqueo Debe Ser EJ: 01', type: "error", confirmButtonColor: "#188ae2" });
                     event.preventDefault();
                     return false;
                 }
                 if (FecBlo[1].length > 2 || FecBlo[1].length < 2) {
                     Swal.fire({ title: 'Fecha de Bloqueo', text: 'El Formato Mes la Fecha de Bloqueo Debe Ser EJ: 01', type: "error", confirmButtonColor: "#188ae2" });
                     event.preventDefault();
                     return false;
                 }
                 if (FecBlo[2].length < 4 || FecBlo[2].length > 4) {
                     Swal.fire({ title: 'Fecha de Bloqueo', text: 'El Formato Año la Fecha de Bloqueo Debe Ser EJ: 1999', type: "error", confirmButtonColor: "#188ae2" });
                     event.preventDefault();
                     return false;
                 }
                 valuesStart = scope.FecBloSerEsp.split("/");
                 valuesEnd = scope.Fecha_Server.split("/");
                 // Verificamos que la fecha no sea posterior a la actual
                 var dateStart = new Date(valuesStart[2], (valuesStart[1] - 1), valuesStart[0]);
                 var dateEnd = new Date(valuesEnd[2], (valuesEnd[1] - 1), valuesEnd[0]);
                 if (dateStart > dateEnd) {
                     Swal.fire({ title: 'Fecha de Bloqueo', text: "La Fecha de Bloqueo No Puede Ser Mayor a: " + scope.Fecha_Server + 'Por Favor verifique e intente nuevamente.', type: "error", confirmButtonColor: "#188ae2" });
                     return false;
                 }
                 scope.servicio_especial_bloqueo.FecBlo = valuesStart[2] + "-" + valuesStart[1] + "-" + valuesStart[0];
             }
         }
         console.log(scope.servicio_especial_bloqueo);
         Swal.fire({
             title: 'Bloqueando',
             text: 'Estás Seguro de Bloquear Este Servicio Especial?',
             type: "question",
             showCancelButton: !0,
             confirmButtonColor: "#31ce77",
             cancelButtonColor: "#f34943",
             confirmButtonText: 'Bloquear'
         }).then(function(t) {
             if (t.value == true) {
                 console.log(scope.servicio_especial_bloqueo);
                 scope.cambiar_estatus_servicio_especial(scope.servicio_especial_bloqueo.EstSerEsp, scope.servicio_especial_bloqueo.CodSerEsp);
             } else {
                 event.preventDefault();
                 console.log('Cancelando ando...');
             }
         });
     };

     $scope.submitFormServiciosEspeciales = function(event) {
         if (scope.servicio_especial.CodSerEsp == undefined) {
             //var titulo='Guardando_Anexo';
             var titulo = 'Guardando';
             var texto = 'Está seguro de registrar este nuevo registro';
             var response = 'Servicio Especial creado de forma correcta';
         } else {
             //var titulo='Actualizando_Anexo';
             var titulo = 'Actualizando';
             var texto = 'Está seguro de registrar este nuevo registro';
             var response = 'Servicio Especial modificado de forma correcta';
         }
         if (!scope.validar_campos_servicio_especial()) {
             return false;
         }
         console.log(scope.servicio_especial);
         Swal.fire({
             title: titulo,
             text: texto,
             type: "question",
             showCancelButton: !0,
             confirmButtonColor: "#31ce77",
             cancelButtonColor: "#f34943",
             confirmButtonText: "OK"
         }).then(function(t) {
             if (t.value == true) {
                 $("#" + titulo).removeClass("loader loader-default").addClass("loader loader-default is-active");
                 var url = base_urlHome() + "api/Comercializadora/registrar_servicios_especiales/";
                 $http.post(url, scope.servicio_especial).then(function(result) {
                     scope.nIDSerEsp = result.data.CodSerEsp;
                     if (result.data != false) {
                         $("#" + titulo).removeClass("loader loader-default is-active").addClass("loader loader-default");
                         Swal.fire({ title: titulo, text: response, type: "success", confirmButtonColor: "#188ae2" });
                         location.href = "#/Edit_Servicios_Adicionales/" + scope.nIDSerEsp;
                     } else {
                         $("#" + titulo).removeClass("loader loader-default is-active").addClass("loader loader-default");
                         Swal.fire({ title: "Error", text: 'Un error a ocurrido durante el proceso, por favor intente nuevamente.', type: "error", confirmButtonColor: "#188ae2" });
                     }

                 }, function(error) {
                     $("#" + titulo).removeClass("loader loader-default is-active").addClass("loader loader-default");
                     if (error.status == 404 && error.statusText == "Not Found") {
                         Swal.fire({ title: "Error.", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
                     }
                     if (error.status == 401 && error.statusText == "Unauthorized") {
                         Swal.fire({ title: "Error de Privilegios", text: "Usuario no autorizado para acceder a este Módulo", type: "info", confirmButtonColor: "#188ae2" });
                     }
                     if (error.status == 403 && error.statusText == "Forbidden") {
                         Swal.fire({ title: "Seguridad.", text: "Está intentando utilizar un APIKEY incorrecto", type: "question", confirmButtonColor: "#188ae2" });
                     }
                     if (error.status == 500 && error.statusText == "Internal Server Error") {
                         Swal.fire({ title: "Error.", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
                     }

                 });
             } else {
                 event.preventDefault();
             }
         });
     };
     scope.validar_campos_servicio_especial = function() {
         resultado = true;
         if (!scope.servicio_especial.CodCom > 0) {
             Swal.fire({ title: 'Comercializadora', text: 'Debe Seleccionar una Comercializadora de la lista.', type: "error", confirmButtonColor: "#188ae2" });
             return false;
         }
         if (scope.servicio_especial.DesSerEsp == null || scope.servicio_especial.DesSerEsp == undefined || scope.servicio_especial.DesSerEsp == '') {
             Swal.fire({ title: 'Servicio Especial', text: 'El Nombre del Servicio Especial Es requerido', type: "error", confirmButtonColor: "#188ae2" });
             return false;
         }
         var FecIniSerEspForm1 = document.getElementById("FecIniSerEspForm").value;
         scope.FecIniSerEspForm = FecIniSerEspForm1;
         if (scope.FecIniSerEspForm == null || scope.FecIniSerEspForm == undefined || scope.FecIniSerEspForm == '') {
             Swal.fire({ title: 'Fecha de Inicio', text: 'La Fecha de Inicio es Requerida.', type: "error", confirmButtonColor: "#188ae2" });
             return false;
         } else {
             var FecIniSerEspForm = (scope.FecIniSerEspForm).split("/");
             if (FecIniSerEspForm.length < 3) {
                 Swal.fire({ title: 'Fecha de Inicio', text: 'El Formato de la Fecha de Inicio Debe Ser: ' + scope.Fecha_Server, type: "error", confirmButtonColor: "#188ae2" });
                 event.preventDefault();
                 return false;
             } else {
                 if (FecIniSerEspForm[0].length > 2 || FecIniSerEspForm[0].length < 2) {
                     Swal.fire({ title: 'Fecha de Inicio', text: 'El Formato del Día Debe Ser: EJ: 01', type: "error", confirmButtonColor: "#188ae2" });
                     event.preventDefault();
                     return false;

                 }
                 if (FecIniSerEspForm[1].length > 2 || FecIniSerEspForm[1].length < 2) {
                     Swal.fire({ title: 'Fecha de Inicio', text: 'El Formato del Mes Debe Ser: EJ: 01', type: "error", confirmButtonColor: "#188ae2" });
                     event.preventDefault();
                     return false;
                 }
                 if (FecIniSerEspForm[2].length < 4 || FecIniSerEspForm[2].length > 4) {
                     Swal.fire({ title: 'Fecha de Inicio', text: 'El Formato del Año Debe Ser: EJ: 1999', type: "error", confirmButtonColor: "#188ae2" });
                     event.preventDefault();
                     return false;
                 }
                 var h1 = new Date();
                 var final = FecIniSerEspForm[2] + "/" + FecIniSerEspForm[1] + "/" + FecIniSerEspForm[0];
                 scope.servicio_especial.FecIniSerEspForm = final;
                 valuesStart = scope.FecIniSerEspForm.split("/");
                 valuesEnd = scope.Fecha_Server.split("/");
                 // Verificamos que la fecha no sea posterior a la actual
                 var dateStart = new Date(valuesStart[2], (valuesStart[1] - 1), valuesStart[0]);
                 var dateEnd = new Date(valuesEnd[2], (valuesEnd[1] - 1), valuesEnd[0]);
                 if (dateStart > dateEnd) {
                     Swal.fire({ text: "La Fecha de Inicio No Puede Ser Mayor a: " + scope.Fecha_Server + 'Por favor Verifique he intente nuevamente.', type: "error", confirmButtonColor: "#188ae2" });
                     return false;
                 }
             }
         }

         if (scope.servicio_especial.SerEle == false && scope.servicio_especial.SerGas == false) {
             Swal.fire({ title: 'Tipo de Suministros', text: 'Debe Seleccionar un Tipo de Suministro Eléctrico, Gas o Ambos.', type: "error", confirmButtonColor: "#188ae2" });
             return false;
         }
         if (scope.servicio_especial.SerEle == true) {
             if (scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj.length == 0 && scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt.length == 0 || scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj == false && scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt == false) {
                 Swal.fire({ title: 'Tarifa Eléctrica', text: 'Debe Seleccionar un Tipo de Tensión Alta o Baja', type: "error", confirmButtonColor: "#188ae2" });
                 return false;
             }
         }
         if (scope.servicio_especial.SerGas == true) {
             console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaGas);
             if (scope.servicio_especial.T_DetalleServicioEspecialTarifaGas.length == 0) {
                 Swal.fire({ title: 'Tarifa Gas', text: 'Debe Seleccionar una Tarifa de Gas', type: "error", confirmButtonColor: "#188ae2" });
                 return false;
             }
         }
         if (!scope.servicio_especial.TipCli > 0) {
             Swal.fire({ title: 'Tipo Clientes', text: 'Debe Seleccionar un Tipo de Cliente', type: "error", confirmButtonColor: "#188ae2" });
             return false;
         }
         if (scope.servicio_especial.CarSerEsp == null || scope.servicio_especial.CarSerEsp == undefined || scope.servicio_especial.CarSerEsp == '') {
             Swal.fire({ title: "Caracteristicas", text: 'Caracteristicas', type: "error", confirmButtonColor: "#188ae2" });
             return false;
         }
         if (!scope.servicio_especial.CodTipCom > 0) {
             Swal.fire({ title: 'Comisión', text: 'Debe Seleccionar un Tipo de Comisión', type: "error", confirmButtonColor: "#188ae2" });
             return false;
         }
         if (scope.servicio_especial.OsbSerEsp == undefined || scope.servicio_especial.OsbSerEsp == null || scope.servicio_especial.OsbSerEsp == '') {
             scope.servicio_especial.OsbSerEsp = null;
         } else {
             scope.servicio_especial.OsbSerEsp = scope.servicio_especial.OsbSerEsp;
         }
         if (scope.servicio_especial.SerEle == false) {
             if (scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt.length == 0) {
                 scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt = false;
             } else {
                 scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt = scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt;
             }

             if (scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj.length == 0) {
                 scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj = false;
             } else {
                 scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj = scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj;
             }
         } else {
             if (scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt.length == 0 || scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt == false) {
                 scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt = false;
             } else {
                 scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt = scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt;
             }

             if (scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj.length == 0) {
                 scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj = false;
             } else {
                 scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj = scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj;
             }
         }
         if (scope.servicio_especial.SerGas == false) {
             if (scope.servicio_especial.T_DetalleServicioEspecialTarifaGas.length == 0) {
                 scope.servicio_especial.T_DetalleServicioEspecialTarifaGas = false;
             } else {
                 scope.servicio_especial.T_DetalleServicioEspecialTarifaGas = scope.servicio_especial.T_DetalleServicioEspecialTarifaGas;
             }
         }

         if (resultado == false) {
             //quiere decir que al menos un renglon no paso la validacion
             return false;
         }
         return true;
     }
     scope.limpiar_Servicio_Electrico_SerEsp = function(SerEle) {
         if (SerEle == false) {
             scope.servicio_especial.AggAllBaj = false;
             scope.disabled_all_baja_SerEsp = 0;
             scope.select_tarifa_Elec_Baj_SerEsp = [];
             scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj = [];

             scope.disabled_all_alta_SerEsp = 0;
             scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt = [];
             scope.select_tarifa_Elec_Alt_SerEsp = [];
             scope.servicio_especial.AggAllAlt = false;

             console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj);
             console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt);
         }
     }
     scope.limpiar_Servicio_Gas_SerEsp = function(SerGas) {
         if (SerGas == false) {
             scope.Todas_Gas_SerEsp = false;
             scope.disabled_all_SerEsp = 0;
             scope.servicio_especial.T_DetalleAnexoTarifaGas = [];
             scope.select_tarifa_gas_SerEsp = [];
             scope.servicio_especial.T_DetalleAnexoTarifaGas = [];
             console.log(scope.servicio_especial.T_DetalleAnexoTarifaGas);
         }
     }
     scope.validarfecini = function(object) {
         if (object != undefined) {
             numero = object;
             if (!/^([/0-9])*$/.test(numero))
                 scope.FecIniSerEspForm = numero.substring(0, numero.length - 1);

         }
         console.log(scope.FecIniSerEspForm);
     }
     scope.agregar_tarifa_elec_baja_SerEsp = function(index, CodTarEle, opcion_tension_baja) {
         console.log(index);
         console.log(opcion_tension_baja);
         console.log(CodTarEle);
         var ObjTarifaElecBaja = new Object();
         scope.select_tarifa_Elec_Baj_SerEsp[CodTarEle] = opcion_tension_baja;
         var ObjTarifaGas = new Object();
         if (scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj == undefined || scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj == false) {
             scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj = [];
         }
         scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj.push({ CodTarEle: opcion_tension_baja.CodTarEle });
         console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj);
     }
     scope.quitar_tarifa_elec_baja_SerEsp = function(index, CodTarEle, opcion_tension_baja) {
         console.log(index);
         console.log(opcion_tension_baja);
         console.log(CodTarEle);
         scope.select_tarifa_Elec_Baj_SerEsp[CodTarEle] = false;
         i = 0;
         for (var i = 0; i < scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj.length; i++) {
             if (scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj[i].CodTarEle == CodTarEle) {
                 scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj.splice(i, 1);
             }
         }
         console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj);
     }
     scope.agregar_todas_baja_tension_SerEsp = function(full_datos, AggAllBaj) {
         console.log(full_datos);
         if (AggAllBaj == true) {
             scope.disabled_all_baja_SerEsp = 1;
             angular.forEach(scope.Tarifa_Elec_Baja, function(Tarifa_Elec_Baja) {

                 if (scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj != false) {
                     if (scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj.length > 0) {
                         for (var i = 0; i < scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj.length; i++) {
                             if (scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj[i].CodTarEle == Tarifa_Elec_Baja.CodTarEle) {
                                 scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj.splice(i, 1);
                             }
                         }
                     }
                 }
                 var ObjTarifaGas = new Object();
                 scope.select_tarifa_Elec_Baj_SerEsp[Tarifa_Elec_Baja.CodTarEle] = Tarifa_Elec_Baja;

                 if (scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj == undefined || scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj == false) {
                     scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj = [];
                 }
                 scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj.push({ CodTarEle: Tarifa_Elec_Baja.CodTarEle });
                 for (var index = 0; index <= scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj.length; index++) {
                     scope.servicio_especial[index] = index;
                 }
                 console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj);
             });
         } else {
             scope.disabled_all_baja_SerEsp = 0;
             console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj);
         }
     }
     scope.agregar_tarifa_elec_alta_SerEsp = function(index, CodTarEle, opcion_tension_alta) {
         console.log(index);
         console.log(CodTarEle);
         console.log(opcion_tension_alta);
         scope.select_tarifa_Elec_Alt_SerEsp[CodTarEle] = opcion_tension_alta;
         var ObjTarifaElecAlt = new Object();
         if (scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt == undefined || scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt == false) {
             scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt = [];
         }
         scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt.push({ CodTarEle: opcion_tension_alta.CodTarEle });
         console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt);
     }
     scope.quitar_tarifa_elec_alta_SerEsp = function(index, CodTarEle, opcion_tension_alta) {
         console.log(index);
         console.log(opcion_tension_alta);
         console.log(CodTarEle);
         scope.select_tarifa_Elec_Alt_SerEsp[CodTarEle] = false;
         i = 0;
         for (var i = 0; i < scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt.length; i++) {
             if (scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt[i].CodTarEle == CodTarEle) {
                 scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt.splice(i, 1);
             }
         }
         console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt);
     }
     scope.agregar_todas_alta_tension_SerEsp = function(full_datos, AggAllAlt) {
         console.log(full_datos);
         if (AggAllAlt == true) {
             scope.disabled_all_alta_SerEsp = 1;
             angular.forEach(scope.Tarifa_Elec_Alt, function(Tarifa_Elec_Alta) {
                 if (scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt != false) {
                     if (scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt.length > 0) {
                         for (var i = 0; i < scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt.length; i++) {
                             if (scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt[i].CodTarEle == Tarifa_Elec_Alta.CodTarEle) {
                                 scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt.splice(i, 1);
                             }
                         }
                     }
                 }
                 var ObjTarifaGas = new Object();
                 scope.select_tarifa_Elec_Alt_SerEsp[Tarifa_Elec_Alta.CodTarEle] = Tarifa_Elec_Alta;

                 if (scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt == undefined || scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt == false) {
                     scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt = [];
                 }
                 scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt.push({ CodTarEle: Tarifa_Elec_Alta.CodTarEle });
                 for (var index = 0; index <= scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt.length; index++) {
                     scope.servicio_especial[index] = index;
                 }
                 console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt);
             });
         } else {
             scope.disabled_all_alta_SerEsp = 0;
             console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt);
         }
     }
     scope.agregar_tarifa_gas_individual_SerEsp = function(index, dato, CodTarGas) {
         scope.select_tarifa_gas_SerEsp[CodTarGas] = dato;
         var ObjTarifaGasSerEsp = new Object();
         if (scope.servicio_especial.T_DetalleServicioEspecialTarifaGas == undefined || scope.servicio_especial.T_DetalleServicioEspecialTarifaGas == false) {
             scope.servicio_especial.T_DetalleServicioEspecialTarifaGas = [];
         }
         scope.servicio_especial.T_DetalleServicioEspecialTarifaGas.push({ CodTarGas: dato.CodTarGas });
         console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaGas);
     }
     scope.quitar_tarifa_gas_SerEsp = function(index, CodTarGas, tarifa_gas) {
         scope.select_tarifa_gas_SerEsp[CodTarGas] = false;
         i = 0;
         for (var i = 0; i < scope.servicio_especial.T_DetalleServicioEspecialTarifaGas.length; i++) {
             if (scope.servicio_especial.T_DetalleServicioEspecialTarifaGas[i].CodTarGas == CodTarGas) {
                 scope.servicio_especial.T_DetalleServicioEspecialTarifaGas.splice(i, 1);
             }
         }
         console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaGas);
     }
     scope.agregar_todas_detalle_SerEsp = function(valor) {
         if (valor == true) {
             scope.disabled_all_SerEsp = 1;
             angular.forEach(scope.Tarifa_Gas_Anexos, function(Tarifa) {
                 if (scope.servicio_especial.T_DetalleServicioEspecialTarifaGas != false) {
                     if (scope.servicio_especial.T_DetalleServicioEspecialTarifaGas.length > 0) {
                         for (var i = 0; i < scope.servicio_especial.T_DetalleServicioEspecialTarifaGas.length; i++) {
                             if (scope.servicio_especial.T_DetalleServicioEspecialTarifaGas[i].CodTarGas == Tarifa.CodTarGas) {
                                 scope.servicio_especial.T_DetalleServicioEspecialTarifaGas.splice(i, 1);
                             }
                         }
                     }
                 }
                 var ObjTarifaGas = new Object();
                 scope.select_tarifa_gas_SerEsp[Tarifa.CodTarGas] = Tarifa;

                 if (scope.servicio_especial.T_DetalleServicioEspecialTarifaGas == undefined || scope.servicio_especial.T_DetalleServicioEspecialTarifaGas == false) {
                     scope.servicio_especial.T_DetalleServicioEspecialTarifaGas = [];
                 }
                 scope.servicio_especial.T_DetalleServicioEspecialTarifaGas.push({ CodTarGas: Tarifa.CodTarGas });
                 for (var index = 0; index <= scope.servicio_especial.T_DetalleServicioEspecialTarifaGas.length; index++) {
                     scope.servicio_especial[index] = index;
                 }
                 console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaGas);
             });
         } else {
             scope.disabled_all_SerEsp = 0;
             console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaGas);
         }
     }

     scope.regresar_servicios_especiales = function() {
         if (scope.INF == undefined) {
             if (scope.servicio_especial.CodSerEsp == undefined) {
                 var title = 'Guardando';
                 var text = '¿Seguro que desea cerrar sin registrar el Servicio Especial?';
             } else {
                 var title = 'Actualizando';
                 var text = '¿Seguro que desea cerrar sin actualizar la información del Servicio Especial?';
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
                     //scope.TvistaServiciosEspeciales=1;
                     scope.servicio_especial = {};
                     scope.select_tarifa_Elec_Baj_SerEsp = [];
                     scope.select_tarifa_Elec_Alt_SerEsp = [];
                     scope.select_tarifa_gas_SerEsp = [];
                     scope.servicio_especial.T_DetalleServicioEspecialTarifaGas = [];
                     scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj = [];
                     scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt = [];
                     scope.servicio_especial.SerGas = false;
                     scope.servicio_especial.SerEle = false;
                     scope.servicio_especial.AggAllBaj = false;
                     scope.servicio_especial.AggAllAlt = false;
                     location.href = "#/Servicios_Adicionales/";
                     //console.log(scope.TvistaServiciosEspeciales);	   
                 } else {
                     console.log('Cancelando ando...');
                 }
             });
         } else {
             location.href = "#/Servicios_Adicionales/";
         }
     }
     scope.buscarXIDServicioEspecial = function() {
         $("#buscando").removeClass("loader loader-default").addClass("loader loader-default is-active");
         var url = base_urlHome() + "api/Comercializadora/Buscar_xID_ServicioEspecial/CodSerEsp/" + scope.nIDSerEsp;
         $http.get(url).then(function(result) {
             $("#buscando").removeClass("loader loader-default is-active").addClass("loader loader-default");
             if (result.data != false) { //scope.anexos=result.data;
                 scope.servicio_especial = {};
                 var index = 0;
                 scope.index = 0;
                 scope.servicio_especial.CodSerEsp = result.data.CodSerEsp;
                 scope.servicio_especial.CodCom = result.data.CodCom;
                 scope.servicio_especial.DesSerEsp = result.data.DesSerEsp;
                 scope.FecIniSerEspForm = result.data.FecIniSerEsp;
                 if (result.data.SerEle == "NO") {
                     scope.servicio_especial.SerEle = false;
                     scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj = [];
                     scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt = [];
                     scope.select_tarifa_Elec_Baj_SerEsp = [];
                     scope.select_tarifa_Elec_Alt_SerEsp = [];
                 } else {
                     scope.servicio_especial.SerEle = true;
                     scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj = [];
                     scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt = [];
                     scope.select_tarifa_Elec_Baj_SerEsp = [];
                     scope.select_tarifa_Elec_Alt_SerEsp = [];
                     angular.forEach(result.data.T_DetalleServicioEspecialTarifaEle, function(Tarifa_Electrica) {
                         if (Tarifa_Electrica.TipTen == 0) {
                             var ObjTarifaElecBaja = new Object();
                             scope.select_tarifa_Elec_Baj_SerEsp[Tarifa_Electrica.CodTarEle] = Tarifa_Electrica;
                             var ObjTarifaGas = new Object();
                             if (scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj == undefined || scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj == false) {
                                 scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj = [];
                             }
                             scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj.push({ CodTarEle: Tarifa_Electrica.CodTarEle });
                             console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecBaj);
                         } else {
                             scope.select_tarifa_Elec_Alt_SerEsp[Tarifa_Electrica.CodTarEle] = Tarifa_Electrica;
                             var ObjTarifaElecAlt = new Object();
                             if (scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt == undefined || scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt == false) {
                                 scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt = [];
                             }
                             scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt.push({ CodTarEle: Tarifa_Electrica.CodTarEle });
                             console.log(scope.servicio_especial.T_DetalleServicioEspecialTarifaElecAlt);
                         }
                     });
                 }
                 if (result.data.SerGas == "NO") {
                     scope.servicio_especial.SerGas = false;
                     scope.servicio_especial.T_DetalleServicioEspecialTarifaGas = [];
                     scope.select_tarifa_gas_SerEsp = [];
                 } else {
                     scope.servicio_especial.SerGas = true;
                     scope.servicio_especial.T_DetalleServicioEspecialTarifaGas = [];
                     scope.select_tarifa_gas_SerEsp = [];
                     scope.servicio_especial.T_DetalleServicioEspecialTarifaGas = result.data.T_DetalleServicioEspecialTarifaGas;
                     angular.forEach(scope.servicio_especial.T_DetalleServicioEspecialTarifaGas, function(select_tarifa_gas) {
                         scope.select_tarifa_gas_SerEsp[select_tarifa_gas.CodTarGas] = select_tarifa_gas;

                     });
                 }
                 scope.servicio_especial.TipCli = result.data.TipCli;
                 scope.servicio_especial.CarSerEsp = result.data.CarSerEsp;
                 scope.servicio_especial.CodTipCom = result.data.CodTipCom;
                 scope.servicio_especial.OsbSerEsp = result.data.OsbSerEsp;
                 scope.servicio_especial.AggAllBaj = false;
                 scope.servicio_especial.AggAllAlt = false;
                 scope.Todas_Gas_SerEsp = false;
                 scope.disabled_all_baja_SerEsp = 0;
                 scope.disabled_all_alta_SerEsp = 0;
                 scope.disabled_all_SerEsp = 0;
                 //console.log(result.data);
                 console.log(scope.servicio_especial);
             } else {
                 Swal.fire({ title: "Error", text: 'No hay información', type: "error", confirmButtonColor: "#188ae2" });
             }
         }, function(error) {
             $("#buscando").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
     scope.fetchServiciosEspeciales = function() {
         if (scope.filtrar_search == undefined || scope.filtrar_search == null || scope.filtrar_search == '') {
             $scope.predicate3 = 'id';
             $scope.reverse3 = true;
             $scope.currentPage3 = 1;
             $scope.order3 = function(predicate3) {
                 $scope.reverse3 = ($scope.predicate3 === predicate3) ? !$scope.reverse3 : false;
                 $scope.predicate3 = predicate3;
             };
             scope.TServicioEspeciales = scope.TServicioEspecialesBack;
             $scope.totalItems3 = scope.TServicioEspeciales.length;
             $scope.numPerPage3 = 50;
             $scope.paginate3 = function(value3) {
                 var begin3, end3, index3;
                 begin3 = ($scope.currentPage3 - 1) * $scope.numPerPage3;
                 end3 = begin3 + $scope.numPerPage3;
                 index3 = scope.TServicioEspeciales.indexOf(value3);
                 return (begin3 <= index3 && index3 < end3);
             };
             scope.reporte_pdf_servicio_especiales = 0;
             scope.reporte_excel_servicio_especiales = 0;
         } else {
             if (scope.filtrar_search.length >= 1) {
                 scope.fdatos.filtrar_search = scope.filtrar_search;
                 var url = base_urlHome() + "api/Comercializadora/getServiciosEspecialesFilter";
                 $http.post(url, scope.fdatos).then(function(result) {
                     console.log(result.data);
                     if (result.data != false) {
                         $scope.predicate3 = 'id';
                         $scope.reverse3 = true;
                         $scope.currentPage3 = 1;
                         $scope.order3 = function(predicate3) {
                             $scope.reverse3 = ($scope.predicate3 === predicate3) ? !$scope.reverse3 : false;
                             $scope.predicate3 = predicate3;
                         };
                         scope.TServicioEspeciales = result.data;
                         $scope.totalItems3 = scope.TServicioEspeciales.length;
                         $scope.numPerPage3 = 50;
                         $scope.paginate3 = function(value3) {
                             var begin3, end3, index3;
                             begin3 = ($scope.currentPage3 - 1) * $scope.numPerPage3;
                             end3 = begin3 + $scope.numPerPage3;
                             index3 = scope.TServicioEspeciales.indexOf(value3);
                             return (begin3 <= index3 && index3 < end3);
                         };
                         scope.reporte_pdf_servicio_especiales = 7 + "/" + scope.filtrar_search;
                         scope.reporte_excel_servicio_especiales = 7 + "/" + scope.filtrar_search;
                     } else {
                         $scope.predicate3 = 'id';
                         $scope.reverse3 = true;
                         $scope.currentPage3 = 1;
                         $scope.order3 = function(predicate3) {
                             $scope.reverse3 = ($scope.predicate3 === predicate3) ? !$scope.reverse3 : false;
                             $scope.predicate3 = predicate3;
                         };
                         scope.TServicioEspeciales = scope.TServicioEspecialesBack;
                         $scope.totalItems3 = scope.TServicioEspeciales.length;
                         $scope.numPerPage3 = 50;
                         $scope.paginate3 = function(value3) {
                             var begin3, end3, index3;
                             begin3 = ($scope.currentPage3 - 1) * $scope.numPerPage3;
                             end3 = begin3 + $scope.numPerPage3;
                             index3 = scope.TServicioEspeciales.indexOf(value3);
                             return (begin3 <= index3 && index3 < end3);
                         };
                         scope.reporte_pdf_servicio_especiales = 0;
                         scope.reporte_excel_servicio_especiales = 0;
                     }
                 }, function(error) {
                     if (error.status == 404 && error.statusText == "Not Found") {
                         Swal.fire({ title: "Error 404", text: "El método que esté intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
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
         }
     }
     if (scope.nIDSerEsp != undefined) {
         scope.buscarXIDServicioEspecial();
     }
     ////////////////////////////////////////////////// PARA LA LISTA Y CONFIGURACIONES DE SERVICIOS ESPECIALES END ////////////////////////////////////////////////////////
 }