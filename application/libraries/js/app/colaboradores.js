app.controller('Controlador_Colaboradores', ['$http', '$scope', '$filter', '$route', '$interval', '$controller', '$cookies', 'ServiceColaboradores', 'ServiceOnlyColaboradores', Controlador])
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

function Controlador($http, $scope, $filter, $route, $interval, $controller, $cookies, ServiceColaboradores, ServiceOnlyColaboradores) {
    var scope = this;
    scope.fdatos = {}; // datos del formulario
    scope.nID = $route.current.params.ID; //contiene el id del registro en caso de estarse consultando desde la grid	
    scope.validate_info = $route.current.params.INF
    scope.Nivel = $cookies.get('nivel');
    scope.CIF = $cookies.get('CIF');
    scope.tColaboradores = [];
    scope.tColaboradoresBack = [];
    scope.index = 0;
    scope.tTipoColaborador = [{ CodTipCol: 1, DesTipCol: 'Persona Física' }, { CodTipCol: 2, DesTipCol: 'Empresa' }];
    scope.tEstColaborador = [{ id: 1, nombre: 'Activo' }, { id: 2, nombre: 'Bloqueado' }];
    scope.vColaboradorSeleccionado = null;
    scope.habilitar_button = 0;
    resultado = false;

    scope.NomComCli = true;
    scope.NumCifCli = true;
    scope.RazSocCli = true;
    scope.CupsCol = true;
    scope.DireccionCol = true;
    scope.EmailCol = true;
    scope.TelCol = true;
    console.log($route.current.$$route.originalPath);
    /*if($route.current.$$route.originalPath=="/Editar_Colaborador/:ID/:INF")
    {
    	scope.validate_info = $route.current.params.INF;
    	if(scope.validate_info!=1)
    	{
    		location.href="#/Colaboradores/";
    	}
    }*/
    if ($route.current.$$route.originalPath == "/Colaboradores/") {
        scope.NomCol = true;
        scope.NumIdeFis = true;
        scope.TipCol = true;
        scope.PorCol = true;
        scope.TelCelCol = true;
        scope.EstCol = true;
        scope.AccCol = true;
        scope.ruta_reportes_pdf_colaboradores = 0;
        scope.ruta_reportes_excel_colaboradores = 0;
        scope.topciones = [{ id: 1, nombre: 'Ver' }, { id: 2, nombre: 'Editar' }, { id: 3, nombre: 'Activar' }, { id: 4, nombre: 'Bloquear' }];
        scope.ttipofiltros = [{ id: 1, nombre: 'Tipo Colaborador' }, { id: 2, nombre: 'Estatus del Colaborador' }];
    }

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
    scope.FecIniAct = fecha;
    scope.tProvidencias = [];
    scope.tTiposVias = [];
    scope.tLocalidades = [];
    scope.tOnlyColaboradores = [];
    scope.tClientes_x_Colaboradores = [];
    ServiceColaboradores.getAll().then(function(dato) {
        scope.tProvidencias = dato.Provincias;
        scope.tTiposVias = dato.Tipo_Vias;
        scope.tLocalidades = dato.Localidades;
    }).catch(function(error) {
        console.log(error); //Tratar el error
        if (error.status == false && error.error == "This API key does not have access to the requested controller.") {
            Swal.fire({ title: "Error 401.", text: "Usted No Tiene Acceso al Controlador de Configuraciones Generales.", type: "error", confirmButtonColor: "#188ae2" });
        }
        if (error.status == false && error.error == "Unknown method.") {
            Swal.fire({ title: "Error 404.", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
        }
        if (error.status == false && error.error == "Unauthorized") {
            Swal.fire({ title: "Error 401.", text: "Usuario no autorizado para acceder a este Módulo", type: "error", confirmButtonColor: "#188ae2" });
        }
        if (error.status == false && error.error == "Invalid API Key.") {
            Swal.fire({ title: "Error 403.", text: "Está intentando utilizar un APIKEY inválido", type: "error", confirmButtonColor: "#188ae2" });
        }
        if (error.status == false && error.error == "Internal Server Error") {
            Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
        }
    });
    ServiceOnlyColaboradores.getAll().then(function(dato) {
        scope.tOnlyColaboradores = dato;

    }).catch(function(error) {
        console.log(error); //Tratar el error
        if (error.status == false && error.error == "This API key does not have access to the requested controller.") {
            Swal.fire({ title: "Error 401", text: "Usted No Tiene Acceso al Controlador de Configuraciones Generales.", type: "error", confirmButtonColor: "#188ae2" });
        }
        if (error.status == false && error.error == "Unknown method.") {
            Swal.fire({ title: "Error 404", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
        }
        if (error.status == false && error.error == "Unauthorized") {
            Swal.fire({ title: "Error 401", text: "Usuario no autorizado para acceder a este Módulo", type: "error", confirmButtonColor: "#188ae2" });
        }
        if (error.status == false && error.error == "Invalid API Key.") {
            Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY inválido", type: "error", confirmButtonColor: "#188ae2" });
        }
        if (error.status == false && error.error == "Internal Server Error") {
            Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
        }
    });

    $scope.submitForm = function(event) {
        //console.log(scope.fdatos);
        if (scope.nID > 0 && scope.Nivel == 3) {
            Swal.fire({ title: "Usuario no Autorizado", text: "No tiene permisos para realizar esta operación", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (!scope.validar_campos()) {
            return false;
        }
        Swal.fire({
            title: "Confirmación",
            text: "¿Seguro que desea incluir el Colaborador?",
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
                console.log('Cancelando ando...');
            }
        });
    };

    scope.validar_campos = function() {
        resultado = true;
        if (scope.fdatos.NumIdeFis == null || scope.fdatos.NumIdeFis == undefined || scope.fdatos.NumIdeFis == '') {
            Swal.fire({ title: "El Número de DNI/NIE es requerido", type: "error", confirmButtonColor: "#188ae2" });
            /*console.log($route.current.$$route.originalPath);
            if($route.current.$$route.originalPath=="/Editar_Colaborador/:ID")	
            {
            	document.getElementById('NumIdeFis').removeAttribute('readonly');
            }*/
            return false;
        }
        if (!scope.fdatos.TipCol > 0) {
            Swal.fire({ title: "Debe Seleccionar un Tipo de Colaborador.", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (scope.fdatos.NomCol == null || scope.fdatos.NomCol == undefined || scope.fdatos.NomCol == '') {
            Swal.fire({ title: "El Nombre del Colaborador es requerido", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (scope.fdatos.PorCol == null || scope.fdatos.PorCol == undefined || scope.fdatos.PorCol == '') {
            Swal.fire({ title: "Debe Indicar el % de Beneficio.", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (!scope.fdatos.CodTipVia > 0) {
            Swal.fire({ title: "Debe Seleccionar un Tipo de Via.", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (scope.fdatos.NomViaDir == null || scope.fdatos.NomViaDir == undefined || scope.fdatos.NomViaDir == '') {
            Swal.fire({ title: "El Nombre de la Vía es requerido", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (scope.fdatos.NumViaDir == null || scope.fdatos.NumViaDir == undefined || scope.fdatos.NumViaDir == '') {
            Swal.fire({ title: "El Número de la Vía es requerido", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (!scope.fdatos.CodPro > 0) {
            Swal.fire({ title: "Debe Seleccionar una Provincia.", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (!scope.fdatos.CodLoc > 0) {
            Swal.fire({ title: "Debe Seleccionar una Localidad.", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (scope.fdatos.CPLoc == null || scope.fdatos.CPLoc == undefined || scope.fdatos.CPLoc == '') {
            scope.fdatos.CPLoc = null;
        } else {
            scope.fdatos.CPLoc = scope.fdatos.CPLoc;
        }
        if (scope.fdatos.TelCelCol == null || scope.fdatos.TelCelCol == undefined || scope.fdatos.TelCelCol == '') {
            Swal.fire({ title: "El Campo Teléfono es requerido", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (resultado == false) {
            return false;
        }
        return true;
    }
    scope.guardar = function() {
        $("#crear_colaborador").removeClass("loader loader-default").addClass("loader loader-default is-active");
        if (scope.fdatos.TelFijCol == undefined || scope.fdatos.TelFijCol == null || scope.fdatos.TelFijCol == '') {
            scope.fdatos.TelFijCol = null;
        } else {
            scope.fdatos.TelFijCol = scope.fdatos.TelFijCol;
        }
        if (scope.fdatos.EmaCol == undefined || scope.fdatos.EmaCol == null || scope.fdatos.EmaCol == '') {
            scope.fdatos.EmaCol = null;
        } else {
            scope.fdatos.EmaCol = scope.fdatos.EmaCol;
        }
        if (scope.fdatos.PorCol == undefined || scope.fdatos.PorCol == null || scope.fdatos.PorCol == '') {
            scope.fdatos.PorCol = null;
        } else {
            scope.fdatos.PorCol = scope.fdatos.PorCol;
        }
        if (scope.fdatos.ObsCol == undefined || scope.fdatos.ObsCol == null || scope.fdatos.ObsCol == '') {
            scope.fdatos.ObsCol = null;
        } else {
            scope.fdatos.ObsCol = scope.fdatos.ObsCol;
        }
        if (scope.fdatos.BloDir == undefined || scope.fdatos.BloDir == null || scope.fdatos.BloDir == '') {
            scope.fdatos.BloDir = null;
        } else {
            scope.fdatos.BloDir = scope.fdatos.BloDir;
        }
        if (scope.fdatos.EscDir == undefined || scope.fdatos.EscDir == null || scope.fdatos.EscDir == '') {
            scope.fdatos.EscDir = null;
        } else {
            scope.fdatos.EscDir = scope.fdatos.EscDir;
        }
        if (scope.fdatos.PlaDir == undefined || scope.fdatos.PlaDir == null || scope.fdatos.PlaDir == '') {
            scope.fdatos.PlaDir = null;
        } else {
            scope.fdatos.PlaDir = scope.fdatos.PlaDir;
        }
        if (scope.fdatos.PueDir == undefined || scope.fdatos.PueDir == null || scope.fdatos.PueDir == '') {
            scope.fdatos.PueDir = null;
        } else {
            scope.fdatos.PueDir = scope.fdatos.PueDir;
        }
        console.log(scope.fdatos);
        if (scope.fdatos.CodCol > 0) {
            var title = 'Actualizando';
            var text = '¿Esta Seguro de Actualizar Este Colaborador?';
            var response = "Los Datos del Colaborador Fueron Actualizados Correctamente.";
        }
        if (scope.fdatos.CodCol == undefined) {
            var title = 'Guardando';
            var text = '¿Esta Seguro de Incluir Este Colaborador?';
            var response = "El Colaborador Fue Registrado Correctamente.";
        }
        var url = base_urlHome() + "api/Colaboradores/crear_colaborador/";
        $http.post(url, scope.fdatos).then(function(result) {
            $("#crear_colaborador").removeClass("loader loader-default is-active").addClass("loader loader-default");
            scope.nID = result.data.CodCol;
            if (scope.nID > 0) {
                Swal.fire({ title: title, text: response, type: "success", confirmButtonColor: "#188ae2" });
                scope.buscarXID();
            } else {
                Swal.fire({ title: "Error", text: "ha ocurrido un error intentando guardar por favor intente nuevamente.", type: "error", confirmButtonColor: "#188ae2" });
            }
        }, function(error) {
            $("#crear_colaborador").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (error.status == 404 && error.statusText == "Not Found") {
                Swal.fire({ title: "Error 404", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 401 && error.statusText == "Unauthorized") {
                Swal.fire({ title: "Error 401", text: "Usuario no autorizado para acceder a este Módulo", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 403 && error.statusText == "Forbidden") {
                Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY inválido", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 500 && error.statusText == "Internal Server Error") {
                Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
            }
        });
    }
    scope.buscarXID = function() {
        $("#cargando").removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url = base_urlHome() + "api/Colaboradores/get_colaborador_data/CodCol/" + scope.nID;
        $http.get(url).then(function(result) {
            $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (result.data != false) {
                scope.fdatos = result.data;
            } else {
                Swal.fire({ title: "Error", text: "Ha ocurrido un error al cargar los datos.", type: "error", confirmButtonColor: "#188ae2" });
            }
        }, function(error) {
            $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (error.status == 404 && error.statusText == "Not Found") {
                Swal.fire({ title: "Error 404", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 401 && error.statusText == "Unauthorized") {
                Swal.fire({ title: "Error 401", text: "Usuario no autorizado para acceder a este Módulo", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 403 && error.statusText == "Forbidden") {
                Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY inválido", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 500 && error.statusText == "Internal Server Error") {
                Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
            }
        });
    }

    scope.validarsiletras = function(object) {
        if (object != undefined) {
            letras = object;
            if (!/^([0-9a-zA-Z])*$/.test(letras))
                scope.fdatos.NumIdeFis = letras.substring(0, letras.length - 1);
        }
    }
    scope.comprobar_cif = function() {
        if (scope.fdatos.NumIdeFis == undefined || scope.fdatos.NumIdeFis == null || scope.fdatos.NumIdeFis == "") {
            scope.fdatos.NumIdeFis = undefined;
            scope.habilitar_button = 0;
        } else {
            $("#comprobar_cif").removeClass("loader loader-default").addClass("loader loader-default is-active");
            var url = base_urlHome() + "api/Colaboradores/comprobar_cif/NumIdeFis/" + scope.fdatos.NumIdeFis;
            $http.get(url).then(function(result) {
                $("#comprobar_cif").removeClass("loader loader-default is-active").addClass("loader loader-default");
                if (result.data != false) {
                    scope.habilitar_button = 1;
                    Swal.fire({ title: "Error", text: "El Número de DNI/NIE no existe", type: "error", confirmButtonColor: "#188ae2" });
                } else {
                    Swal.fire({ title: "Disponible", text: "El Número de DNI/NIE ya existe", type: "success", confirmButtonColor: "#188ae2" });
                    scope.habilitar_button = 2;
                }
                scope.fdatos.habilitar_button = scope.habilitar_button;
            }, function(error) {
                console.log(error);
                $("#comprobar_cif").removeClass("loader loader-default is-active").addClass("loader loader-default");
                if (error.status == 404 && error.statusText == "Not Found") {
                    Swal.fire({ title: "Error 404", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
                }
                if (error.status == 401 && error.statusText == "Unauthorized") {
                    Swal.fire({ title: "Error 401", text: "Usuario no autorizado para acceder a este Módulo", type: "error", confirmButtonColor: "#188ae2" });
                }
                if (error.status == 403 && error.statusText == "Forbidden") {
                    Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY inválido", type: "error", confirmButtonColor: "#188ae2" });
                }
                if (error.status == 500 && error.statusText == "Internal Server Error") {
                    Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
                }

            });
            console.log(scope.fdatos.NumIdeFis);
        }
    }

    scope.validarsinuermotelefonofijo = function(object) {
        if (object != undefined) {
            numero = object;
            if (!/^([+0-9])*$/.test(numero))
                scope.fdatos.TelFijCol = numero.substring(0, numero.length - 1);
        }
    }
    scope.validarsinuermotelefonocel = function(object) {
        if (object != undefined) {
            numero = object;
            if (!/^([+0-9])*$/.test(numero))
                scope.fdatos.TelCelCol = numero.substring(0, numero.length - 1);
        }
    }

    scope.validarsinuermo = function(object) {
        if (object != undefined) {
            numero = object;
            if (!/^([.0-9])*$/.test(numero))
                scope.fdatos.PorCol = numero.substring(0, numero.length - 1);
        }
    }
    scope.cargar_lista_colaboradores = function() {
        $("#cargando").removeClass("loader loader-default").addClass("loader loader-default  is-active");
        var url = base_urlHome() + "api/Colaboradores/list_colaboradores/";
        $http.get(url).then(function(result) {
            if (result.data != false) {
                $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                $scope.predicate = 'id';
                $scope.reverse = true;
                $scope.currentPage = 1;
                $scope.order = function(predicate) {
                    $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                    $scope.predicate = predicate;
                };
                scope.tColaboradores = result.data;
                scope.tColaboradoresBack = result.data;
                $scope.totalItems = scope.tColaboradores.length;
                $scope.numPerPage = 50;
                $scope.paginate = function(value) {
                    var begin, end, index;
                    begin = ($scope.currentPage - 1) * $scope.numPerPage;
                    end = begin + $scope.numPerPage;
                    index = scope.tColaboradores.indexOf(value);
                    return (begin <= index && index < end);
                };
            } else {
                $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                Swal.fire({ title: "Error", text: "No hemos encontrado colaboradores registrados.", type: "info", confirmButtonColor: "#188ae2" });
                scope.tColaboradores = [];
                scope.tColaboradoresBack = [];
            }
        }, function(error) {
            $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (error.status == 404 && error.statusText == "Not Found") {
                Swal.fire({ title: "Error 404", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 401 && error.statusText == "Unauthorized") {
                Swal.fire({ title: "Error 401", text: "Usuario no autorizado para acceder a este Módulo", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 403 && error.statusText == "Forbidden") {
                Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY inválido", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 500 && error.statusText == "Internal Server Error") {
                Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
            }
        });
    }
    scope.borrar_row = function(index, id) {
        if (scope.Nivel == 3) {
            Swal.fire({ title: "Usuario no Autorizado", text: "No tiene permisos para realizar esta operación", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        Swal.fire({
            title: "¿Seguro que desea eliminar el Colaborador?",
            type: "question",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: "Confirmar"
        }).then(function(t) {
            if (t.value == true) {
                $("#borrando").removeClass("loader loader-default").addClass("loader loader-default  is-active");
                var url = base_urlHome() + "api/Colaboradores/borrar_row_colaboradores/CodCol/" + id;
                $http.delete(url).then(function(result) {
                    $("#borrando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (result.data != false) {
                        Swal.fire({ title: "Exito!!", text: "Registro eliminado de forma correcta.", type: "success", confirmButtonColor: "#188ae2" });
                        scope.tColaboradores.splice(index, 1);
                    } else {
                        Swal.fire({ title: "Error", text: "No se ha podido eliminar el registro, intente nuevamente", type: "error", confirmButtonColor: "#188ae2" });
                    }

                }, function(error) {
                    $("#borrando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (error.status == 404 && error.statusText == "Not Found") {
                        Swal.fire({ title: "Error 404", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 401 && error.statusText == "Unauthorized") {
                        Swal.fire({ title: "Error 401", text: "Usuario no autorizado para acceder a este Módulo", type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 403 && error.statusText == "Forbidden") {
                        Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY inválido", type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 500 && error.statusText == "Internal Server Error") {
                        Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
                    }
                });
            } else {
                console.log('Cancelando Ando...');
            }
        });
    }
    scope.borrar = function() {
        if (scope.Nivel == 3) {
            Swal.fire({ title: "Usuario no Autorizado", text: "No tiene permisos para realizar esta operación", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        Swal.fire({
            title: "¿Seguro que desea eliminar el Colaborador?",
            type: "question",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: "Confirmar"
        }).then(function(t) {
            if (t.value == true) {
                $("#borrando").removeClass("loader loader-default").addClass("loader loader-default  is-active");
                var url = base_urlHome() + "api/Colaboradores/borrar_row_colaboradores/CodCol/" + scope.fdatos.CodCol;
                $http.delete(url).then(function(result) {
                    $("#borrando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (result.data != false) {
                        Swal.fire({ title: "Exito!!", text: "Registro eliminado de forma correcta.", type: "success", confirmButtonColor: "#188ae2" });
                        location.href = "#/Colaboradores";
                    } else {
                        Swal.fire({ title: "Error", text: "No se ha podido eliminar el registro, intente nuevamente", type: "error", confirmButtonColor: "#188ae2" });
                    }
                }, function(error) {
                    $("#borrando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (error.status == 404 && error.statusText == "Not Found") {
                        Swal.fire({ title: "Error 404", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 401 && error.statusText == "Unauthorized") {
                        Swal.fire({ title: "Error 401", text: "Usuario no autorizado para acceder a este Módulo", type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 403 && error.statusText == "Forbidden") {
                        Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY inválido", type: "error", confirmButtonColor: "#188ae2" });
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
    scope.validar_opcion = function(index, opcion, datos) {
        console.log(index);
        console.log(opcion);
        console.log(datos);
        scope.opciones_colaboradores[index] = undefined;
        if (opcion == 1) {
            location.href = "#/Editar_Colaborador/" + datos.CodCol + "/" + 1;
        }
        if (opcion == 2) {
            location.href = "#/Editar_Colaborador/" + datos.CodCol;
        }
        if (opcion == 3) {
            if (datos.EstCol == 1) {
                Swal.fire({ title: "Error!.", text: "Ya este Colaborador se encuentra activo.", type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }
            Swal.fire({
                title: "¿Esta Seguro de Activar Este Colaborador?",
                type: "info",
                showCancelButton: !0,
                confirmButtonColor: "#31ce77",
                cancelButtonColor: "#f34943",
                confirmButtonText: "Activar"
            }).then(function(t) {
                if (t.value == true) {
                    scope.datos_update = {};
                    scope.datos_update.opcion = 1;
                    scope.datos_update.CodCol = datos.CodCol;
                    var url = base_urlHome() + "api/Colaboradores/update_status/";
                    $http.post(url, scope.datos_update).then(function(result) {
                        if (result.data != false) {
                            Swal.fire({ title: "Exito!.", text: "El Colaborador a sido activado correctamente.", type: "success", confirmButtonColor: "#188ae2" });
                            scope.cargar_lista_colaboradores();
                        } else {
                            Swal.fire({ title: "Error.", text: "Hubo un error al ejecutar esta acción por favor intente nuevamente.", type: "error", confirmButtonColor: "#188ae2" });
                            scope.cargar_lista_colaboradores();
                        }
                    }, function(error) {
                        if (error.status == 404 && error.statusText == "Not Found") {
                            Swal.fire({ title: "Error 404", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
                        }
                        if (error.status == 401 && error.statusText == "Unauthorized") {
                            Swal.fire({ title: "Error 401", text: "Usuario no autorizado para acceder a este Módulo", type: "error", confirmButtonColor: "#188ae2" });
                        }
                        if (error.status == 403 && error.statusText == "Forbidden") {
                            Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY inválido", type: "error", confirmButtonColor: "#188ae2" });
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
            if (datos.EstCol == 2) {
                Swal.fire({ title: "Error!.", text: "Ya este Colaborador se encuentra bloqueado.", type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }
            scope.t_modal_data = {};
            scope.t_modal_data.CodCol = datos.CodCol;
            scope.NumIdeFisBlo = datos.NumIdeFis;
            scope.NomColBlo = datos.NomCol;
            scope.FecBloColBlo = fecha;
            $('.datepicker').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.FecBloColBlo);
            $("#modal_motivo_bloqueo").modal('show');
        }
    }
    scope.regresar = function() {
        if (scope.validate_info == undefined) {
            if (scope.fdatos.CodCol == undefined) {
                var title = 'Guardando';
                var text = '¿Seguro que desea cerrar sin crear el Colaborador?';
            } else {
                var title = 'Actualizando';
                var text = '¿Seguro que desea cerrar y no actualizar la información del Colaborador';
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
                    location.href = "#/Colaboradores";
                } else {
                    console.log('Cancelando ando...');
                }
            });

        } else {
            location.href = "#/Colaboradores";
        }
    }
    $scope.submitFormlockCol = function(event) {
        var FecBloColBlo = document.getElementById("FecBloColBlo").value;
        scope.FecBloColBlo = FecBloColBlo;
        if (scope.FecBloColBlo == null || scope.FecBloColBlo == undefined || scope.FecBloColBlo == '') {
            Swal.fire({ title: "La Fecha de Bloqueo es obligatoria", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        } else {
            var FecBloColBlo = (scope.FecBloColBlo).split("/");
            if (FecBloColBlo.length < 3) {
                Swal.fire({ text: "Error en Fecha de Bloqueo, el formato correcto es DD/MM/YYYY", type: "error", confirmButtonColor: "#188ae2" });
                event.preventDefault();
                return false;
            } else {
                if (FecBloColBlo[0].length > 2 || FecBloColBlo[0].length < 2) {
                    Swal.fire({ text: "Error en Día, debe contener dos números", type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;
                }
                if (FecBloColBlo[1].length > 2 || FecBloColBlo[1].length < 2) {
                    Swal.fire({ text: "Error en Mes, debe contener dos números", type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;
                }
                if (FecBloColBlo[2].length < 4 || FecBloColBlo[2].length > 4) {
                    Swal.fire({ text: "Error en Año, debe contener cuatro números", type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;
                }
                valuesStart = scope.FecBloColBlo.split("/");
                valuesEnd = fecha.split("/");
                //Verificamos que la fecha no sea posterior a la actual
                var dateStart = new Date(valuesStart[2], (valuesStart[1] - 1), valuesStart[0]);
                var dateEnd = new Date(valuesEnd[2], (valuesEnd[1] - 1), valuesEnd[0]);
                if (dateStart > dateEnd) {
                    Swal.fire({
                        text: "La Fecha de Bloqueo no puede ser mayor a " + fecha,
                        type: "error ",
                        confirmButtonColor: "#188ae2"
                    });
                    return false;
                }
                scope.t_modal_data.FecBloColBlo = valuesStart[2] + "/" + valuesStart[1] + "/" + valuesStart[0];
            }
        }
        if (scope.t_modal_data.ObsBloColBlo == undefined || scope.t_modal_data.ObsBloColBlo == null || scope.t_modal_data.ObsBloColBlo == '') {
            scope.t_modal_data.ObsBloColBlo = null;
        } else {
            scope.t_modal_data.ObsBloColBlo = scope.t_modal_data.ObsBloColBlo;
        }
        scope.t_modal_data.opcion = 2;
        console.log(scope.t_modal_data);
        Swal.fire({
            title: "¿Seguro que desea bloquear el Colaborador?",
            type: "question",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: "Confirmar"
        }).then(function(t) {
            if (t.value == true) {

                var url = base_urlHome() + "api/Colaboradores/update_status/";
                $http.post(url, scope.t_modal_data).then(function(result) {
                    if (result.data != false) {
                        Swal.fire({ title: "Exito!.", text: "El Colaborador se ha Bloqueado de forma correcta", type: "success", confirmButtonColor: "#188ae2" });
                        $("#modal_motivo_bloqueo").modal('hide');
                        scope.t_modal_data = {};
                        scope.NumIdeFisBlo = undefined;
                        scope.NomColBlo = undefined;
                        scope.FecBloColBlo = undefined;
                        scope.cargar_lista_colaboradores();
                    } else {
                        Swal.fire({ title: "Error.", text: "Ha ocurrido un error, intente nuevamente", type: "error", confirmButtonColor: "#188ae2" });
                        scope.cargar_lista_colaboradores();
                    }
                }, function(error) {

                    if (error.status == 404 && error.statusText == "Not Found") {
                        Swal.fire({ title: "Error 404", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 401 && error.statusText == "Unauthorized") {
                        Swal.fire({ title: "Error 401", text: "Usuario no autorizado para acceder a este Módulo", type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 403 && error.statusText == "Forbidden") {
                        Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY inválido", type: "error", confirmButtonColor: "#188ae2" });
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
    //scope.ruta_reportes_pdf_colaboradores=
    //scope.ruta_reportes_excel_colaboradores=
    $scope.SubmitFormFiltrosColaboradores = function(event) {
        if (scope.tmodal_colaboradores.tipo_filtro == 1) {
            $scope.predicate = 'id';
            $scope.reverse = true;
            $scope.currentPage = 1;
            $scope.order = function(predicate) {
                $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                $scope.predicate = predicate;
            };
            scope.tColaboradores = $filter('filter')(scope.tColaboradoresBack, { TipCol: scope.tmodal_colaboradores.TipColFil }, true); //scope.tColaboradoresBack;		
            console.log(scope.tColaboradores);
            console.log(scope.tColaboradoresBack);
            $scope.totalItems = scope.tColaboradores.length;
            $scope.numPerPage = 50;
            $scope.paginate = function(value) {
                var begin, end, index;
                begin = ($scope.currentPage - 1) * $scope.numPerPage;
                end = begin + $scope.numPerPage;
                index = scope.tColaboradores.indexOf(value);
                return (begin <= index && index < end);
            };
            scope.ruta_reportes_pdf_colaboradores = scope.tmodal_colaboradores.tipo_filtro + "/" + scope.tmodal_colaboradores.TipColFil;
            scope.ruta_reportes_excel_colaboradores = scope.tmodal_colaboradores.tipo_filtro + "/" + scope.tmodal_colaboradores.TipColFil;

        }
        if (scope.tmodal_colaboradores.tipo_filtro == 2) {
            $scope.predicate = 'id';
            $scope.reverse = true;
            $scope.currentPage = 1;
            $scope.order = function(predicate) {
                $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                $scope.predicate = predicate;
            };
            scope.tColaboradores = $filter('filter')(scope.tColaboradoresBack, { EstCol: scope.tmodal_colaboradores.EstColFil }, true); //scope.tColaboradoresBack;		
            console.log(scope.tColaboradores);
            console.log(scope.tColaboradoresBack);
            $scope.totalItems = scope.tColaboradores.length;
            $scope.numPerPage = 50;
            $scope.paginate = function(value) {
                var begin, end, index;
                begin = ($scope.currentPage - 1) * $scope.numPerPage;
                end = begin + $scope.numPerPage;
                index = scope.tColaboradores.indexOf(value);
                return (begin <= index && index < end);
            };
            scope.ruta_reportes_pdf_colaboradores = scope.tmodal_colaboradores.tipo_filtro + "/" + scope.tmodal_colaboradores.EstColFil;
            scope.ruta_reportes_excel_colaboradores = scope.tmodal_colaboradores.tipo_filtro + "/" + scope.tmodal_colaboradores.EstColFil;

        }

    };
    scope.regresar_filtro_colaboradores = function() {
        $scope.predicate = 'id';
        $scope.reverse = true;
        $scope.currentPage = 1;
        $scope.order = function(predicate) {
            $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
            $scope.predicate = predicate;
        };
        scope.tColaboradores = scope.tColaboradoresBack;
        $scope.totalItems = scope.tColaboradores.length;
        $scope.numPerPage = 50;
        $scope.paginate = function(value) {
            var begin, end, index;
            begin = ($scope.currentPage - 1) * $scope.numPerPage;
            end = begin + $scope.numPerPage;
            index = scope.tColaboradores.indexOf(value);
            return (begin <= index && index < end);
        };
        scope.tmodal_colaboradores = {};
        scope.ruta_reportes_pdf_colaboradores = 0;
        scope.ruta_reportes_excel_colaboradores = 0;
    }
    scope.filtrarLocalidad = function() {
        scope.TLocalidadesfiltrada = $filter('filter')(scope.tLocalidades, { CodPro: scope.fdatos.CodPro }, true);
        if (scope.fdatos.CodCol > 0) {
            $interval.cancel(promise);
        }


    }
    scope.filtrar_zona_postal = function() {
        scope.CodLocZonaPostal = $filter('filter')(scope.tLocalidades, { CodLoc: scope.fdatos.CodLoc }, true);
        angular.forEach(scope.CodLocZonaPostal, function(data) {
            scope.fdatos.CPLoc = data.CPLoc;
        });
    }

    if (scope.nID != undefined) {
        scope.buscarXID();
        var promise = $interval(function() {
            console.log('por aqui');
            scope.filtrarLocalidad();
        }, 5000);
        $scope.$on('$destroy', function() {
            $interval.cancel(promise);
        });
    }
    scope.search = 1;
    scope.Clientes_x_Colaboradores = function(cod) {
        scope.spinner_loader = 1;
        scope.data_result = 0;
        var url = base_urlHome() + "api/Colaboradores/clientes_colaboradores/CodCol/" + cod;
        $http.get(url).then(function(result) {
            scope.spinner_loader = 0;
            if (result.data != false) {
                scope.data_result = 1;
                scope.tClientes_x_Colaboradores = result.data;
            } else {
                scope.data_result = 2;
                scope.tClientes_x_Colaboradores = [];
            }
        }, function(error) {
            scope.spinner_loader = 0;
            scope.data_result = 0;

            if (error.status == 404 && error.statusText == "Not Found") {
                Swal.fire({ title: "Error 404", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 401 && error.statusText == "Unauthorized") {
                Swal.fire({ title: "Error 401", text: "Usuario no autorizado para acceder a este Módulo", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 403 && error.statusText == "Forbidden") {
                Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY inválido", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 500 && error.statusText == "Internal Server Error") {
                Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
            }
        });
    }
    scope.FetchColaboradores = function()
    {
        if(scope.filtrar_search==undefined||scope.filtrar_search==null||scope.filtrar_search=='')
        {
           
            $scope.predicate = 'id';
            $scope.reverse = true;
            $scope.currentPage = 1;
            $scope.order = function(predicate) {
                $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                $scope.predicate = predicate;
            };
             scope.tColaboradores=scope.tColaboradoresBack;
            $scope.totalItems = scope.tColaboradores.length;
            $scope.numPerPage = 50;
            $scope.paginate = function(value) {
                var begin, end, index;
                begin = ($scope.currentPage - 1) * $scope.numPerPage;
                end = begin + $scope.numPerPage;
                index = scope.tColaboradores.indexOf(value);
                return (begin <= index && index < end);
            };
            scope.ruta_reportes_pdf_colaboradores = 0;
            scope.ruta_reportes_excel_colaboradores =0;

        }
        else
        {
            if(scope.filtrar_search.length>=2)
            {
                scope.fdatos.filtrar_search=scope.filtrar_search;   
                var url = base_urlHome()+"api/Colaboradores/getColaboradoresFilter";
                $http.post(url,scope.fdatos).then(function(result)
                {
                    console.log(result.data);
                    if (result.data != false)
                    {                        
                        $scope.predicate = 'id';
                        $scope.reverse = true;
                        $scope.currentPage = 1;
                        $scope.order = function(predicate) {
                            $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                            $scope.predicate = predicate;
                        };
                         scope.tColaboradores=result.data;
                        $scope.totalItems = scope.tColaboradores.length;
                        $scope.numPerPage = 50;
                        $scope.paginate = function(value) {
                            var begin, end, index;
                            begin = ($scope.currentPage - 1) * $scope.numPerPage;
                            end = begin + $scope.numPerPage;
                            index = scope.tColaboradores.indexOf(value);
                            return (begin <= index && index < end);
                        };
                        scope.ruta_reportes_pdf_colaboradores = 3 + "/" + scope.filtrar_search;
                        scope.ruta_reportes_excel_colaboradores = 3 + "/" + scope.filtrar_search;
                    }
                    else
                    {
                        Swal.fire({ title: "Error", text: "No existen Colaboradores registrados", type: "error", confirmButtonColor: "#188ae2" });                    
                        $scope.predicate = 'id';
                        $scope.reverse = true;
                        $scope.currentPage = 1;
                        $scope.order = function(predicate) {
                            $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                            $scope.predicate = predicate;
                        };
                         scope.tColaboradores=scope.tColaboradoresBack;
                        $scope.totalItems = scope.tColaboradores.length;
                        $scope.numPerPage = 50;
                        $scope.paginate = function(value) {
                            var begin, end, index;
                            begin = ($scope.currentPage - 1) * $scope.numPerPage;
                            end = begin + $scope.numPerPage;
                            index = scope.tColaboradores.indexOf(value);
                            return (begin <= index && index < end);
                        };
                        scope.ruta_reportes_pdf_colaboradores = 0;
                        scope.ruta_reportes_excel_colaboradores =0;
                    }
                }, function(error)
                {
                    if (error.status == 404 && error.statusText == "Not Found"){
                        Swal.fire({ title: "Error 404", text: "El método que esté intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
                    }if (error.status == 401 && error.statusText == "Unauthorized"){
                        Swal.fire({ title: "Error 401", text: "Disculpe, Usuario no autorizado para acceder a ester módulo", type: "error", confirmButtonColor: "#188ae2" });
                    }if (error.status == 403 && error.statusText == "Forbidden"){
                        Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY inválido", type: "error", confirmButtonColor: "#188ae2" });
                    }if (error.status == 500 && error.statusText == "Internal Server Error") {
                        Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
                    }
                });
            }
        }              
    }
}