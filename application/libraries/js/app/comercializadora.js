app.controller('Controlador_Comercializadora', ['$http', '$scope', '$filter', '$route', '$interval', '$controller', '$cookies', 'ServiceComercializadora', 'upload', Controlador])
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

function Controlador($http, $scope, $filter, $route, $interval, $controller, $cookies, ServiceComercializadora, upload) {
    var scope = this;
    scope.fdatos = {}; // datos del formulario
    scope.nID = $route.current.params.ID; //contiene el id del registro en caso de estarse consultando desde la grid
    scope.Nivel = $cookies.get('nivel');
    scope.index = 0;
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
    scope.TProvincias = [];
    scope.tLocalidades = [];
    scope.Tcomercializadoras = [];
    scope.TcomercializadorasBack = [];

    console.log($route.current.$$route.originalPath);
    //////////////////////////////////////////////////////////// VISTA PRINCIPAL DE LAS COMERCIALIZADORAS START //////////////////////////////////////////////////////////
    ServiceComercializadora.getAll().then(function(dato) {
        scope.TProvincias = dato.Provincias;
        scope.tLocalidades = dato.Localidades;
        $scope.predicate = 'id';
        $scope.reverse = true;
        $scope.currentPage = 1;
        $scope.order = function(predicate) {
            $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
            $scope.predicate = predicate;
        };
        scope.Tcomercializadoras = dato.Comercializadora;
        scope.TcomercializadorasBack = dato.Comercializadora;
        $scope.totalItems = scope.Tcomercializadoras.length;
        $scope.numPerPage = 50;
        $scope.paginate = function(value) {
            var begin, end, index;
            begin = ($scope.currentPage - 1) * $scope.numPerPage;
            end = begin + $scope.numPerPage;
            index = scope.Tcomercializadoras.indexOf(value);
            return (begin <= index && index < end);
        };
        scope.fecha_server = dato.fecha;
        //console.log(scope.fecha_server);
    }).catch(function(error) {
        console.log(error); //Tratar el error
        /*if(error.status==false && error.error=="This API key does not have access to the requested controller.")
        {
        	Swal.fire({title:"Error 401.",text:$translate('NO_FOUND1'),type:"error",confirmButtonColor:"#188ae2"});
        }
        if(error.status==false && error.error=="Unknown method.")
        {
        	Swal.fire({title:"Error 404.",text:$translate('NO_FOUND'),type:"error",confirmButtonColor:"#188ae2"});
        }
        if(error.status==false && error.error=="Unauthorized")
        {
        	Swal.fire({title:"Error 401.",text:$translate('UNAUTHORIZED'),type:"error",confirmButtonColor:"#188ae2"});
        }
        if(error.status==false && error.error=="Invalid API Key.")
        {
        	Swal.fire({title:"Error 403.",text:$translate('FORBIDDEN'),type:"error",confirmButtonColor:"#188ae2"});
        }
        if(error.status==false && error.error=="Internal Server Error")
        {
        	Swal.fire({title:"Error 500",text:$translate('INTERNAL_ERROR'),type:"error",confirmButtonColor:"#188ae2"});
        }*/

    });
    scope.NumCifCom = true;
    scope.RazSocCom = true;
    scope.TelFijCom = true;
    scope.EstCom = true;
    scope.Acc = true;
    scope.validate_cif == 1
    resultado = false;
    scope.Topciones_comercializadoras = [{ id: 4, nombre: 'Ver' }, { id: 3, nombre: 'Editar' }, { id: 1, nombre: 'Activar' }, { id: 2, nombre: 'Suspender' }];
    scope.ttipofiltros = [{ id: 1, nombre: 'Tipo de Suministro' }, { id: 2, nombre: 'Provincia' }, { id: 3, nombre: 'Localidad' }, { id: 4, nombre: 'Estatus' }];
    scope.EstComFil = [{ id: 1, nombre: 'Activa' }, { id: 2, nombre: 'Suspendida' }];
    scope.TipServ = [{ id: 1, nom_serv: 'Gas' }, { id: 2, nom_serv: 'Eléctrico' }, { id: 3, nom_serv: 'Servicio Especial' }];
    scope.tmodal_comercializadora = {};
    scope.reporte_pdf_comercializadora = 0;
    scope.reporte_excel_comercializadora = 0;
    console.log(scope.Tcomercializadoras);
    scope.modal_cif_comercializadora = function() {
        scope.fdatos.NumCifCom = undefined;
        $("#modal_cif_comercializadora").modal('show');
    }
    scope.cargar_lista_comercializadoras = function() {
        $("#List_Comer").removeClass("loader loader-default").addClass("loader loader-default  is-active");
        var url = base_urlHome() + "api/Comercializadora/get_list_comercializadora";
        $http.get(url).then(function(result) {
            $("#List_Comer").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (result.data != false) {
                $scope.predicate = 'id';
                $scope.reverse = true;
                $scope.currentPage = 1;
                $scope.order = function(predicate) {
                    $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                    $scope.predicate = predicate;
                };
                scope.Tcomercializadoras = result.data;
                scope.TcomercializadorasBack = result.data;
                $scope.totalItems = scope.Tcomercializadoras.length;
                $scope.numPerPage = 50;
                $scope.paginate = function(value) {
                    var begin, end, index;
                    begin = ($scope.currentPage - 1) * $scope.numPerPage;
                    end = begin + $scope.numPerPage;
                    index = scope.Tcomercializadoras.indexOf(value);
                    return (begin <= index && index < end);
                };
            } else {
                scope.Tcomercializadoras = [];
                scope.TcomercializadorasBack = [];
            }
        }, function(error) {
            $("#List_Comer").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
    $scope.Consultar_CIF = function(event) {
        if (scope.fdatos.NumCifCom == undefined || scope.fdatos.NumCifCom == null || scope.fdatos.NumCifCom == '') {
            scope.toast('error',"El CIF es requerido.",'');
            return false;
        } else {
            $("#NumCifCom").removeClass("loader loader-default").addClass("loader loader-default  is-active");
            var url = base_urlHome() + "api/Comercializadora/comprobar_cif_comercializadora";
            $http.post(url, scope.fdatos).then(function(result) {
                $("#NumCifCom").removeClass("loader loader-default is-active").addClass("loader loader-default");
                if (result.data != false) {
                   scope.toast('error','Ya existe una Comercializadora con el CIF introducido.','');
                } else {
                    $("#modal_cif_comercializadora").modal('hide');
                    $cookies.put('CIF_COM', scope.fdatos.NumCifCom);
                    location.href = "#/Datos_Basicos_Comercializadora/";
                }
            }, function(error) {
                $("#NumCifCom").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
    $scope.SubmitFormFiltrosComercializadoras = function(event) {
        console.log(event);
        console.log(scope.tmodal_comercializadora.tipo_filtro);
        if (scope.tmodal_comercializadora.tipo_filtro == 1) {
            console.log(scope.tmodal_comercializadora);

            $scope.predicate = 'id';
            $scope.reverse = true;
            $scope.currentPage = 1;
            $scope.order = function(predicate) {
                $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                $scope.predicate = predicate;
            };

            if (scope.tmodal_comercializadora.TipServ == 1) {
                scope.Tcomercializadoras = $filter('filter')(scope.TcomercializadorasBack, { SerGas: scope.tmodal_comercializadora.Selec }, true);
            }
            if (scope.tmodal_comercializadora.TipServ == 2) {
                scope.Tcomercializadoras = $filter('filter')(scope.TcomercializadorasBack, { SerEle: scope.tmodal_comercializadora.Selec }, true);
            }
            if (scope.tmodal_comercializadora.TipServ == 3) {
                scope.Tcomercializadoras = $filter('filter')(scope.TcomercializadorasBack, { SerEsp: scope.tmodal_comercializadora.Selec }, true);
            }
            $scope.totalItems = scope.Tcomercializadoras.length;
            $scope.numPerPage = 50;
            $scope.paginate = function(value) {
                var begin, end, index;
                begin = ($scope.currentPage - 1) * $scope.numPerPage;
                end = begin + $scope.numPerPage;
                index = scope.Tcomercializadoras.indexOf(value);
                return (begin <= index && index < end);
            };

            scope.reporte_pdf_comercializadora = scope.tmodal_comercializadora.tipo_filtro + "/" + scope.tmodal_comercializadora.TipServ + "/" + scope.tmodal_comercializadora.Selec;
            scope.reporte_excel_comercializadora = scope.tmodal_comercializadora.tipo_filtro + "/" + scope.tmodal_comercializadora.TipServ + "/" + scope.tmodal_comercializadora.Selec;
        }
        if (scope.tmodal_comercializadora.tipo_filtro == 2) {
            
            for (var i = 0; i < scope.TProvincias.length; i++) 
            {
                if (scope.TProvincias[i].CodPro == scope.tmodal_data.CodPro) {
                    scope.FilterPro = scope.TProvincias[i].DesPro;
                    console.log(scope.FilterPro);
                }
            }
            console.log(scope.tmodal_comercializadora);
            $scope.predicate = 'id';
            $scope.reverse = true;
            $scope.currentPage = 1;
            $scope.order = function(predicate) {
                $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                $scope.predicate = predicate;
            };
            scope.Tcomercializadoras = $filter('filter')(scope.TcomercializadorasBack, { ProDirCom: scope.FilterPro }, true);
            $scope.totalItems = scope.Tcomercializadoras.length;
            $scope.numPerPage = 50;
            $scope.paginate = function(value) {
                var begin, end, index;
                begin = ($scope.currentPage - 1) * $scope.numPerPage;
                end = begin + $scope.numPerPage;
                index = scope.Tcomercializadoras.indexOf(value);
                return (begin <= index && index < end);
            };
            scope.reporte_pdf_comercializadora = scope.tmodal_comercializadora.tipo_filtro + "/" + scope.FilterPro;
            scope.reporte_excel_comercializadora = scope.tmodal_comercializadora.tipo_filtro + "/" + scope.FilterPro;
        }
        if (scope.tmodal_comercializadora.tipo_filtro == 3) {
            console.log(scope.tmodal_comercializadora);
            $scope.predicate = 'id';
            $scope.reverse = true;
            $scope.currentPage = 1;
            $scope.order = function(predicate) {
                $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                $scope.predicate = predicate;
            };
            scope.Tcomercializadoras = $filter('filter')(scope.TcomercializadorasBack, { CodLoc: scope.tmodal_comercializadora.CodLocFil }, true);
            $scope.totalItems = scope.Tcomercializadoras.length;
            $scope.numPerPage = 50;
            $scope.paginate = function(value) {
                var begin, end, index;
                begin = ($scope.currentPage - 1) * $scope.numPerPage;
                end = begin + $scope.numPerPage;
                index = scope.Tcomercializadoras.indexOf(value);
                return (begin <= index && index < end);
            };
            scope.reporte_pdf_comercializadora = scope.tmodal_comercializadora.tipo_filtro + "/" + scope.tmodal_data.CodPro + "/" + scope.tmodal_comercializadora.CodLocFil;
            scope.reporte_excel_comercializadora = scope.tmodal_comercializadora.tipo_filtro + "/" + scope.tmodal_data.CodPro + "/" + scope.tmodal_comercializadora.CodLocFil;
        }
        if (scope.tmodal_comercializadora.tipo_filtro == 4) {
            console.log(scope.tmodal_comercializadora);
            $scope.predicate = 'id';
            $scope.reverse = true;
            $scope.currentPage = 1;
            $scope.order = function(predicate) {
                $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                $scope.predicate = predicate;
            };
            scope.Tcomercializadoras = $filter('filter')(scope.TcomercializadorasBack, { EstCom: scope.tmodal_comercializadora.EstCom }, true);
            $scope.totalItems = scope.Tcomercializadoras.length;
            $scope.numPerPage = 50;
            $scope.paginate = function(value) {
                var begin, end, index;
                begin = ($scope.currentPage - 1) * $scope.numPerPage;
                end = begin + $scope.numPerPage;
                index = scope.Tcomercializadoras.indexOf(value);
                return (begin <= index && index < end);
            };
            scope.reporte_pdf_comercializadora = scope.tmodal_comercializadora.tipo_filtro + "/" + scope.tmodal_comercializadora.EstCom;
            scope.reporte_excel_comercializadora = scope.tmodal_comercializadora.tipo_filtro + "/" + scope.tmodal_comercializadora.EstCom;
        }

    };
    scope.regresar_filtro_comercializadora = function() {
        scope.tmodal_data = {};
        scope.tmodal_comercializadora = {};
        $scope.predicate = 'id';
        $scope.reverse = true;
        $scope.currentPage = 1;
        $scope.order = function(predicate) {
            $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
            $scope.predicate = predicate;
        };
        scope.Tcomercializadoras = scope.TcomercializadorasBack;
        $scope.totalItems = scope.Tcomercializadoras.length;
        $scope.numPerPage = 50;
        $scope.paginate = function(value) {
            var begin, end, index;
            begin = ($scope.currentPage - 1) * $scope.numPerPage;
            end = begin + $scope.numPerPage;
            index = scope.Tcomercializadoras.indexOf(value);
            return (begin <= index && index < end);
        };
        scope.reporte_pdf_comercializadora = 0;
        scope.reporte_excel_comercializadora = 0;
    }
    scope.validar_opcion = function(index, opciones_comercializadoras, dato) {
        //console.log(index);
        //console.log(opciones_comercializadoras);
        //console.log(dato);
        if (opciones_comercializadoras == 1) {
            scope.opciones_comercializadoras[index] = undefined;
            if (dato.EstCom == 'Activa') {
                scope.toast('error','La Comercializadora ya se encuentra activa.','');
                return false;
            }
            Swal.fire({
                text: '¿Seguro que desea activar la Comercializadora?',
                type: "info",
                showCancelButton: !0,
                confirmButtonColor: "#31ce77",
                cancelButtonColor: "#f34943",
                confirmButtonText: 'Confirmar'
            }).then(function(t) {
                if (t.value == true) {
                    scope.cambiar_estatus_comercializadora(opciones_comercializadoras, dato.CodCom);
                } else {
                    console.log('Cancelando ando...');
                }
            });
        }
        if (opciones_comercializadoras == 2) {
            scope.opciones_comercializadoras[index] = undefined;
            scope.t_modal_data = {};
            if (dato.EstCom == 'Suspendida') {
                scope.toast('error','La Comercializadora ya se encuentra suspendida.','');
                return false;
            }
            scope.t_modal_data.CodCom = dato.CodCom;
            scope.NumCifComBlo = dato.NumCifCom;
            scope.RazSocComBlo = dato.RazSocCom;
            scope.t_modal_data.OpcCom = opciones_comercializadoras;
            scope.fecha_bloqueo = scope.fecha_server;
            $('.datepicker').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.fecha_bloqueo);
            scope.cargar_lista_MotBloCom(index);
        }
        if (opciones_comercializadoras == 3) {
            location.href = "#/Datos_Basicos_Comercializadora/" + dato.CodCom;
        }
        if (opciones_comercializadoras == 4) {
            location.href = "#/Datos_Basicos_Comercializadora/" + dato.CodCom + "/" + 1;
            scope.validate_info = 1;
        }
    }
    scope.cargar_lista_MotBloCom = function(index) {
        var url = base_urlHome() + "api/Comercializadora/list_MotBloCom/";
        $http.get(url).then(function(result) {
            if (result.data != false) {
                scope.tMotBloCom = result.data;
                scope.opciones_comercializadoras[index] = undefined;
                $("#modal_motivo_bloqueo_comercializadora").modal('show');
            } else {
                scope.toast('error','No se encontraron motivos para suspender registrados.','');
                scope.opciones_comercializadoras[index] = undefined;
            }

        }, function(error) {
            scope.opciones_comercializadoras[index] = undefined;
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
    $scope.submitFormlockCom = function(event) {
        if (scope.t_modal_data.ObsBloCom == undefined || scope.t_modal_data.ObsBloCom == null || scope.t_modal_data.ObsBloCom == '') {
            scope.t_modal_data.ObsBloCom = null;
        } else {
            scope.t_modal_data.ObsBloCom = scope.t_modal_data.ObsBloCom;
        }
        var fecha_bloqueo = document.getElementById("fecha_bloqueo").value;
        scope.fecha_bloqueo = fecha_bloqueo;
        if (scope.fecha_bloqueo == undefined || scope.fecha_bloqueo == null || scope.fecha_bloqueo == '') {
            scope.toast('error','La Fecha de Suspender es requerida.','');
            return false;
        } else {
            var FecBlo = (scope.fecha_bloqueo).split("/");
            if (FecBlo.length < 3) {
                scope.toast('error','Error en Fecha de Suspender, el formato correcto es DD/MM/YYYY.','');
                event.preventDefault();
                return false;
            } else {
                if (FecBlo[0].length > 2 || FecBlo[0].length < 2) {
                    scope.toast('error','Error en Día, debe introducir dos números.','');
                   event.preventDefault();
                    return false;
                }
                if (FecBlo[1].length > 2 || FecBlo[1].length < 2) {
                    scope.toast('error','Error en Mes, debe introducir dos números.','');
                   event.preventDefault();
                    return false;
                }
                if (FecBlo[2].length < 4 || FecBlo[2].length > 4) {
                    scope.toast('error','LError en Año, debe introducir cuatro números.','');
                    event.preventDefault();
                    return false;
                }
                valuesStart = scope.fecha_bloqueo.split("/");
                valuesEnd = scope.fecha_server.split("/");
                // Verificamos que la fecha no sea posterior a la actual
                var dateStart = new Date(valuesStart[2], (valuesStart[1] - 1), valuesStart[0]);
                var dateEnd = new Date(valuesEnd[2], (valuesEnd[1] - 1), valuesEnd[0]);
                if (dateStart > dateEnd) {
                    scope.toast('error','La Fecha de Suspender no debe ser mayor a ' + scope.fecha_server,'');
                    return false;
                }
                scope.t_modal_data.FecBlo = valuesStart[2] + "-" + valuesStart[1] + "-" + valuesStart[0];
            }

        }
        Swal.fire({
            text: '¿Seguro que desea suspender la Comercializadora?',
            type: "question",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: 'Confirmar'
        }).then(function(t) {
            if (t.value == true) {
                console.log(scope.t_modal_data);
                scope.cambiar_estatus_comercializadora(scope.t_modal_data.OpcCom, scope.t_modal_data.CodCom);
            } else {
                event.preventDefault();
                console.log('Cancelando ando...');
            }
        });
    };
    scope.cambiar_estatus_comercializadora = function(opciones_comercializadoras, CodCom, index) {
        scope.status_comer = {};
        scope.status_comer.EstCom = opciones_comercializadoras;
        scope.status_comer.CodCom = CodCom;
        if (opciones_comercializadoras == 2) {
            scope.status_comer.MotBloq = scope.t_modal_data.MotBloq;
            scope.status_comer.ObsBloCom = scope.t_modal_data.ObsBloCom;
            scope.status_comer.FecBlo = scope.t_modal_data.FecBlo;
            console.log(scope.status_comer);
        }
        $("#estatus").removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url = base_urlHome() + "api/Comercializadora/cambiar_estatus_comercializadora/";
        $http.post(url, scope.status_comer).then(function(result) {
            if (result.data.resultado != false) {
                if (opciones_comercializadoras == 1) {

                    var title = 'Activando';
                    var text = 'La Comercializadora se ha activado de forma correcta';
                }
                if (opciones_comercializadoras == 2) {
                    var title = 'Bloqueando';
                    var text = 'La Comercializadora ha sido suspendida de forma correcta';
                    $("#modal_motivo_bloqueo_comercializadora").modal('hide');
                }

                $("#estatus").removeClass("loader loader-default is-active").addClass("loader loader-default");
                scope.toast('success',text,title);                
                scope.opciones_comercializadoras[index] = undefined;
                scope.cargar_lista_comercializadoras();
            } else {
                $("#estatus").removeClass("loader loader-default is-active").addClass("loader loader-default");
                scope.toast('success',"Ha ocurrido un error, intente nuevamente",'');
                scope.cargar_lista_comercializadoras();
            }

        }, function(error) {
            $("#estatus").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
    scope.filtrarLocalidad = function() {
        scope.TLocalidadesfiltrada = $filter('filter')(scope.tLocalidades, { DesPro: scope.tmodal_data.CodPro }, true);

    }
    scope.SearchLocalidades=function()
    {
        var url = base_urlHome()+"api/Comercializadora/getLocalidadSearch/CodPro/"+scope.tmodal_data.CodPro;
        $http.get(url).then(function(result)
        {
            if(result.data!=false)
            {
                scope.TLocalidadesfiltrada =result.data;
            }
            else
            {
                scope.toast('error',"Esta Provincia no tiene localidades asignadas.",'');
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
    scope.fetchComercializadoras = function() {
            if (scope.filtrar_search == undefined || scope.filtrar_search == null || scope.filtrar_search == '') {

                $scope.predicate = 'id';
                $scope.reverse = true;
                $scope.currentPage = 1;
                $scope.order = function(predicate) {
                    $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                    $scope.predicate = predicate;
                };
                scope.Tcomercializadoras = scope.TcomercializadorasBack;
                $scope.totalItems = scope.Tcomercializadoras.length;
                $scope.numPerPage = 50;
                $scope.paginate = function(value) {
                    var begin, end, index;
                    begin = ($scope.currentPage - 1) * $scope.numPerPage;
                    end = begin + $scope.numPerPage;
                    index = scope.Tcomercializadoras.indexOf(value);
                    return (begin <= index && index < end);
                };
                scope.reporte_pdf_comercializadora = 0;
                scope.reporte_excel_comercializadora = 0;

            } else {
                if (scope.filtrar_search.length >= 1) {
                    scope.fdatos.filtrar_search = scope.filtrar_search;
                    var url = base_urlHome() + "api/Comercializadora/getComercializadoraFilter";
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
                            scope.Tcomercializadoras = result.data;
                            $scope.totalItems = scope.Tcomercializadoras.length;
                            $scope.numPerPage = 50;
                            $scope.paginate = function(value) {
                                var begin, end, index;
                                begin = ($scope.currentPage - 1) * $scope.numPerPage;
                                end = begin + $scope.numPerPage;
                                index = scope.Tcomercializadoras.indexOf(value);
                                return (begin <= index && index < end);
                            };
                            scope.reporte_pdf_comercializadora = 5 + "/" + scope.filtrar_search;
                            scope.reporte_excel_comercializadora = 5 + "/" + scope.filtrar_search;
                        } else {
                            
                            scope.Tcomercializadoras =[];                                                    
                            scope.reporte_pdf_comercializadora = 0;
                            scope.reporte_excel_comercializadora = 0;
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
                    scope.Tcomercializadoras = scope.TcomercializadorasBack;
                            $scope.totalItems = scope.Tcomercializadoras.length;
                            $scope.numPerPage = 50;
                            $scope.paginate = function(value) {
                                var begin, end, index;
                                begin = ($scope.currentPage - 1) * $scope.numPerPage;
                                end = begin + $scope.numPerPage;
                                index = scope.Tcomercializadoras.indexOf(value);
                                return (begin <= index && index < end);
                            };
                    scope.reporte_pdf_comercializadora = 0;
                    scope.reporte_excel_comercializadora = 0;
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
        /*scope.filtrar = function(expresion)
        {
           console.log(expresion);
            if (expresion.length>0){
                scope.Tcomercializadoras = $filter('filter')(scope.TcomercializadorasBack, {NumCifCom: expresion});
            }
            else
            {
                scope.Tcomercializadoras = scope.TcomercializadorasBack;
            }                
        }*/
        //////////////////////////////////////////////////////////// VISTA PRINCIPAL DE LAS COMERCIALIZADORAS START //////////////////////////////////////////////////////////	
}