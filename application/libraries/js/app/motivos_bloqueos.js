app.controller('Controlador_Motivos_Bloqueos', ['$http', '$scope', '$filter', '$route', '$interval', '$controller', '$cookies', Controlador]);

function Controlador($http, $scope, $filter, $route, $interval, $controller, $cookies) {
    //declaramos una variable llamada scope donde tendremos a vm
    /*inyectamos un controlador para acceder a sus variables y metodos*/
    //$controller('ControladorArticuloExistencia as vmAE',{$scope:$scope});			
    var scope = this;
    scope.fdatos = {}; // datos del formulario
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
    scope.topciones = [{ id: 1, nombre: 'VER' }, { id: 2, nombre: 'EDITAR' }];

    scope.TVistaMotCliente = 1;
    scope.DesMotBloCli = true;
    scope.AccMotBloCli = true;
    scope.ruta_reportes_pdf_bloqueo_cliente = 0;
    scope.ruta_reportes_excel_bloqueo_cliente = 0;
    scope.TMotivo_BloCliente = [];
    scope.fdatos_mot_clientes = {};


    scope.TVistaMotBloAct = 1;
    scope.DesMotBloAct = true;
    scope.AcctMotBloAct = true;
    scope.TMotivo_BloActividad = [];
    scope.ruta_reportes_pdf_MotBloAct = 0;
    scope.ruta_reportes_excel_MotBloAct = 0;
    scope.fdatos_mot_actividad = {};
    //TMotivo_BloActividad

    scope.TvistaMotBloPunSum = 1;
    scope.DesMotBloPun = true;
    scope.AcctMotBloPunSum = true;
    scope.TMotivo_BloPunSum = [];
    scope.ruta_reportes_pdf_MotBloPunSum = 0;
    scope.ruta_reportes_excel_MotBloPunSum = 0;
    scope.fdatos_mot_PunSum = {};

    scope.TVistaBloqueoContacto = 1;
    scope.DesMotBlocon = true;
    scope.AcctMotBloCon = true;
    scope.TMotivo_BloContacto = [];
    scope.ruta_reportes_pdf_MotBloContacto = 0;
    scope.ruta_reportes_excel_MotBloContacto = 0;
    scope.fdatos_mot_contacto = {};

    scope.TVistaBloqueoComercializadora = 1;
    scope.DesMotBloCom = true;
    scope.AcctMotBloCom = true;
    scope.TMotivo_BloComercializadora = [];
    scope.ruta_reportes_pdf_MotBloComercializadora = 0;
    scope.ruta_reportes_excel_MotBloComercializadora = 0;
    scope.fdatos_mot_comercializadora = {};

    scope.TVistaBloqueoCUPs = 1;
    scope.DesMotBloCUPs = true;
    scope.AcctMotBloCUPs = true;
    scope.TMotivo_BloCUPs = [];
    scope.ruta_reportes_pdf_MotBloCUPs = 0;
    scope.ruta_reportes_excel_MotBloCUPs = 0;
    scope.fdatos_mot_cups = {};

    //////////////////////////////////////////////////////////////////MOTIVOS BLOQUEOS CLIENTES START//////////////////////////////////////////////////////////////////////////////
    scope.cargar_lista_motivos_clientes = function() {
        $("#cargando_lista").removeClass("loader loader-default").addClass("loader loader-default  is-active");
        var url = base_urlHome() + "api/Motivos_Bloqueos/list_motivo_clientes/";
        $http.get(url).then(function(result) {
            $("#cargando_lista").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (result.data != false) {
                $scope.predicate = 'id';
                $scope.reverse = true;
                $scope.currentPage = 1;
                $scope.order = function(predicate) {
                    $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                    $scope.predicate = predicate;
                };
                scope.TMotivo_BloCliente = result.data;
                $scope.totalItems = scope.TMotivo_BloCliente.length;
                $scope.numPerPage = 50;
                $scope.paginate = function(value) {
                    var begin, end, index;
                    begin = ($scope.currentPage - 1) * $scope.numPerPage;
                    end = begin + $scope.numPerPage;
                    index = scope.TMotivo_BloCliente.indexOf(value);
                    return (begin <= index && index < end);
                };
                console.log(scope.TMotivo_BloCliente);
            } else {
                scope.TMotivo_BloCliente = [];
            }
        }, function(error) {
            $("#cargando_lista").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
    scope.agg_bloqueo_cliente = function() {
        scope.fdatos_mot_clientes = {};
        scope.TVistaMotCliente = 2;
        scope.validate_mot_bloqueo_cliente = undefined;
    }
    scope.regresar_bloqueo_cliente = function() {
        if (scope.validate_mot_bloqueo_cliente == undefined) {
            Swal.fire({

                text: "¿Seguro que desea cerrar sin bloquear el Cliente?",
                type: "question",
                showCancelButton: !0,
                confirmButtonColor: "#31ce77",
                cancelButtonColor: "#f34943",
                confirmButtonText: "Confirmar"
            }).then(function(t) {
                if (t.value == true) {
                    scope.fdatos_mot_clientes = {};
                    scope.TVistaMotCliente = 1;
                    scope.validate_mot_bloqueo_cliente = undefined;
                    scope.cargar_lista_motivos_clientes();
                    return false;
                } else {
                    console.log('Cancelando Ando...');
                    return false;
                }
            });
        } else {
            scope.fdatos_mot_clientes = {};
            scope.TVistaMotCliente = 1;
            scope.validate_mot_bloqueo_cliente = undefined;
            scope.cargar_lista_motivos_clientes();
        }
    }
    $scope.submitFormMotClientes = function(event) {
        console.log(scope.fdatos_mot_clientes);
        if (scope.fdatos_mot_clientes.CodMotBloCli > 0) {
            var title = 'Actualizando';
            var text = '¿Seguro que desea actualizar el Motivo?';
            var response = "El Motivo Bloqueo de Cliente modificado de forma correcta";
        }
        if (scope.fdatos_mot_clientes.CodMotBloCli == undefined) {

            var title = 'Guardando';
            var text = '¿Seguro que desea registrar el Motivo de Bloqueo?';
            var response = "El Motivo Bloqueo de Cliente ha sido registrado de forma correcta";
        }
        if (scope.fdatos_mot_clientes.ObsMotBloCli == undefined || scope.fdatos_mot_clientes.ObsMotBloCli == null || scope.fdatos_mot_clientes.ObsMotBloCli == "") {
            scope.fdatos_mot_clientes.ObsMotBloCli = null;
        } else {
            scope.fdatos_mot_clientes.ObsMotBloCli = scope.fdatos_mot_clientes.ObsMotBloCli;
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
                $("#" + title).removeClass("loader loader-default").addClass("loader loader-default is-active");
                var url = base_urlHome() + "api/Motivos_Bloqueos/crear_motivo_bloqueo_cliente/";
                $http.post(url, scope.fdatos_mot_clientes).then(function(result) {
                    scope.nIDMotBloCli = result.data.CodMotBloCli;
                    $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (scope.nIDMotBloCli > 0) {
                        console.log(result.data);
                        Swal.fire({ title: title, text: response, type: "success", confirmButtonColor: "#188ae2" });
                        scope.buscarXID_MotBloClientes();
                    } else {
                        Swal.fire({ title: "Error", text: "Ha ocurrido un error, intente nuevamente", type: "error", confirmButtonColor: "#188ae2" });
                    }
                }, function(error) {
                    console.log(error);
                    $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
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
            }
        });
    };
    scope.buscarXID_MotBloClientes = function() {
        $("#cargando").removeClass("loader loader-default").addClass("loader loader-default  is-active");
        var url = base_urlHome() + "api/Motivos_Bloqueos/buscar_xID_MotBloCli/CodMotBloCli/" + scope.nIDMotBloCli;
        $http.get(url).then(function(result) {
            $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (result.data != false) {
                scope.fdatos_mot_clientes = result.data;
                console.log(scope.fdatos_mot_clientes);
            } else {
                Swal.fire({ title: "Error", text: "Ha ocurrido un error cargando la información", type: "error", confirmButtonColor: "#188ae2" });
            }
        }, function(error) {
            console.log(error);
            $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
    scope.limpiar_bloqueo_cliente = function() {
        scope.fdatos_mot_clientes = {};
    }
    scope.borrar_bloqueo_cliente = function() {
        var event = true;
        if (scope.Nivel == 3) {
            Swal.fire({ title: "Usuario no Autorizado", text: "No tiene permisos para realizar esta operación", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        Swal.fire({
            title: "Borrar",
            text: "¿Seguro que desea eliminar el Motivo?",
            type: "question",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: "Confirmar"
        }).then(function(t) {
            if (t.value == true) {
                $("#borrando").removeClass("loader loader-default").addClass("loader loader-default  is-active");
                var url = base_urlHome() + "api/Motivos_Bloqueos/borrar_row_MotBloCli/CodMotBloCli/" + scope.fdatos_mot_clientes.CodMotBloCli;
                $http.delete(url).then(function(result) {
                    $("#borrando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (result.data != false) {
                        Swal.fire({ title: "Exito!!", text: "Registro eliminado de forma correcta", type: "success", confirmButtonColor: "#188ae2" });
                        scope.TVistaMotCliente = 1;
                        scope.cargar_lista_motivos_clientes();
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
                        Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY incorrecto", type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 500 && error.statusText == "Internal Server Error") {
                        Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
                    }
                });
            } else {
                event.preventDefault();
            }
        });
    }
    scope.validar_opcion_MotBloCli = function(index, opciones_motivo_cliente, datos) {
            scope.opciones_motivo_cliente[index] = undefined;
            if (opciones_motivo_cliente == 1) {
                scope.TVistaMotCliente = 2;
                scope.fdatos_mot_clientes = datos;
                scope.validate_mot_bloqueo_cliente = 1;
            }
            if (opciones_motivo_cliente == 2) {
                scope.TVistaMotCliente = 2;
                scope.fdatos_mot_clientes = datos;
                scope.validate_mot_bloqueo_cliente = undefined;
            }
        }
        //////////////////////////////////////////////////////////////////MOTIVOS BLOQUEOS CLIENTES END//////////////////////////////////////////////////////////////////////////////





    //////////////////////////////////////////////////////////////////MOTIVOS BLOQUEOS ACTIVIDADES START//////////////////////////////////////////////////////////////////////////////
    scope.cargar_lista_motivos_actividades = function() {
        $("#cargando_lista").removeClass("loader loader-default").addClass("loader loader-default  is-active");
        var url = base_urlHome() + "api/Motivos_Bloqueos/list_motivo_actividades/";
        $http.get(url).then(function(result) {
            $("#cargando_lista").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (result.data != false) {
                $scope.predicate2 = 'id';
                $scope.reverse2 = true;
                $scope.currentPage2 = 1;
                $scope.order2 = function(predicate2) {
                    $scope.reverse2 = ($scope.predicate2 === predicate2) ? !$scope.reverse2 : false;
                    $scope.predicate2 = predicate2;
                };
                scope.TMotivo_BloActividad = result.data;
                $scope.totalItems2 = scope.TMotivo_BloActividad.length;
                $scope.numPerPage2 = 50;
                $scope.paginate2 = function(value2) {
                    var begin2, end2, index2;
                    begin2 = ($scope.currentPage2 - 1) * $scope.numPerPage2;
                    end2 = begin2 + $scope.numPerPage2;
                    index2 = scope.TMotivo_BloActividad.indexOf(value2);
                    return (begin2 <= index2 && index2 < end2);
                };
                console.log(scope.TMotivo_BloActividad);
            } else {
                scope.TMotivo_BloActividad = [];
            }
        }, function(error) {
            $("#cargando_lista").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
    scope.agg_bloqueo_actividad = function() {
        scope.fdatos_mot_actividad = {};
        scope.TVistaMotBloAct = 2;
        scope.validate_mot_bloqueo_actividad = undefined;
    }
    scope.regresar_bloqueo_actividad = function() {
        if (scope.validate_mot_bloqueo_actividad == undefined) {
            Swal.fire({

                text: "¿Seguro que desea cerrar sin bloquear la Actividad?",
                type: "question",
                showCancelButton: !0,
                confirmButtonColor: "#31ce77",
                cancelButtonColor: "#f34943",
                confirmButtonText: "Confirmar"
            }).then(function(t) {
                if (t.value == true) {
                    scope.fdatos_mot_actividad = {};
                    scope.TVistaMotBloAct = 1;
                    scope.validate_mot_bloqueo_actividad = undefined;
                    scope.cargar_lista_motivos_actividades();
                    return false;
                } else {
                    console.log('Cancelando Ando...');
                    return false;
                }
            });
        } else {
            scope.fdatos_mot_actividad = {};
            scope.TVistaMotBloAct = 1;
            scope.validate_mot_bloqueo_actividad = undefined;
            scope.cargar_lista_motivos_actividades();
        }
    }
    $scope.submitFormActividad = function(event) {
        console.log(scope.fdatos_mot_actividad);
        if (scope.fdatos_mot_actividad.CodMotBloAct > 0) {
            var title = 'Actualizando';
            var text = '¿Seguro que desea modificar el Motivo de Bloqueo de la Actividad?';
            var response = "El Motivo de Bloqueo de la Actividad ha sido actualizado de forma correcta";
        }
        if (scope.fdatos_mot_actividad.CodMotBloAct == undefined) {

            var title = 'Guardando';
            var text = '¿Seguro que desea registrar el Motivo de Bloqueo de la Actividad?';
            var response = "El Motivo de Bloqueo de la Actividad ha sido registrado de forma correcta";
        }
        if (scope.fdatos_mot_actividad.ObsMotBloAct == undefined || scope.fdatos_mot_actividad.ObsMotBloAct == null || scope.fdatos_mot_actividad.ObsMotBloAct == "") {
            scope.fdatos_mot_actividad.ObsMotBloAct = null;
        } else {
            scope.fdatos_mot_actividad.ObsMotBloAct = scope.fdatos_mot_actividad.ObsMotBloAct;
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
                $("#" + title).removeClass("loader loader-default").addClass("loader loader-default is-active");
                var url = base_urlHome() + "api/Motivos_Bloqueos/crear_motivo_bloqueo_actividad/";
                $http.post(url, scope.fdatos_mot_actividad).then(function(result) {
                    scope.nIDMotBloAct = result.data.CodMotBloAct;
                    $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (scope.nIDMotBloAct > 0) {
                        console.log(result.data);
                        Swal.fire({ title: title, text: response, type: "success", confirmButtonColor: "#188ae2" });
                        scope.buscarXID_MotBloActividad();
                    } else {
                        Swal.fire({ title: "Error", text: "Ha ocurrido un error, intente nuevamente", type: "error", confirmButtonColor: "#188ae2" });
                    }
                }, function(error) {
                    console.log(error);
                    $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
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
            }
        });
    };
    scope.buscarXID_MotBloActividad = function() {
        $("#cargando").removeClass("loader loader-default").addClass("loader loader-default  is-active");
        var url = base_urlHome() + "api/Motivos_Bloqueos/buscar_xID_MotBloAct/CodMotBloAct/" + scope.nIDMotBloAct;
        $http.get(url).then(function(result) {
            $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (result.data != false) {
                scope.fdatos_mot_actividad = result.data;
                console.log(scope.fdatos_mot_actividad);
            } else {
                Swal.fire({ title: "Error", text: "Ha ocurrido un error al cargar la información", type: "error", confirmButtonColor: "#188ae2" });
            }
        }, function(error) {
            console.log(error);
            $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
    scope.limpiar_actividad = function() {
        scope.fdatos_mot_actividad = {};
    }
    scope.borrar_actividad = function() {
        var event = true;
        if (scope.Nivel == 3) {
            Swal.fire({ title: "Usuario no Autorizado", text: "No tiene permisos para realizar esta operación", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        Swal.fire({
            title: "Borrar",
            text: "¿Seguro que desea eliminar el Motivo?",
            type: "question",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: "Confirmar"
        }).then(function(t) {
            if (t.value == true) {
                $("#borrando").removeClass("loader loader-default").addClass("loader loader-default  is-active");
                var url = base_urlHome() + "api/Motivos_Bloqueos/borrar_row_MotBloAct/CodMotBloAct/" + scope.fdatos_mot_actividad.CodMotBloAct;
                $http.delete(url).then(function(result) {
                    $("#borrando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (result.data != false) {
                        Swal.fire({ title: "Exito!!", text: "Registro eliminado de forma correcta", type: "success", confirmButtonColor: "#188ae2" });
                        scope.TVistaMotBloAct = 1;
                        scope.cargar_lista_motivos_actividades();
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
                        Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY incorrecto", type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 500 && error.statusText == "Internal Server Error") {
                        Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
                    }
                });
            } else {
                event.preventDefault();
            }
        });
    }
    scope.validar_opcion_activadad = function(index, opciones_actividad, datos) {
            scope.opciones_actividad[index] = undefined;
            if (opciones_actividad == 1) {
                scope.TVistaMotBloAct = 2;
                scope.fdatos_mot_actividad = datos;
                scope.validate_mot_bloqueo_actividad = 1;
            }
            if (opciones_actividad == 2) {
                scope.TVistaMotBloAct = 2;
                scope.fdatos_mot_actividad = datos;
                scope.validate_mot_bloqueo_actividad = undefined;
            }
        }
        //////////////////////////////////////////////////////////////////MOTIVOS BLOQUEOS ACTIVIDADES END//////////////////////////////////////////////////////////////////////////////

    //////////////////////////////////////////////////////////////////MOTIVOS BLOQUEOS PUNTOS SUMINISTROS START//////////////////////////////////////////////////////////////////////////////
    scope.cargar_lista_motivos_punto_sumininistro = function() {
        $("#cargando_lista").removeClass("loader loader-default").addClass("loader loader-default  is-active");
        var url = base_urlHome() + "api/Motivos_Bloqueos/list_motivo_punto_sumininistro/";
        $http.get(url).then(function(result) {
            $("#cargando_lista").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (result.data != false) {
                $scope.predicate3 = 'id';
                $scope.reverse3 = true;
                $scope.currentPage3 = 1;
                $scope.order3 = function(predicate3) {
                    $scope.reverse3 = ($scope.predicate3 === predicate3) ? !$scope.reverse3 : false;
                    $scope.predicate3 = predicate3;
                };
                scope.TMotivo_BloPunSum = result.data;
                $scope.totalItems3 = scope.TMotivo_BloPunSum.length;
                $scope.numPerPage3 = 50;
                $scope.paginate3 = function(value3) {
                    var begin3, end3, index3;
                    begin3 = ($scope.currentPage3 - 1) * $scope.numPerPage3;
                    end3 = begin3 + $scope.numPerPage3;
                    index3 = scope.TMotivo_BloPunSum.indexOf(value3);
                    return (begin3 <= index3 && index3 < end3);
                };
                console.log(scope.TMotivo_BloPunSum);
            } else {
                scope.TMotivo_BloPunSum = [];
            }
        }, function(error) {
            $("#cargando_lista").removeClass("loader loader-default is-active").addClass("loader loader-default");
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

    scope.agg_bloqueo_PunSum = function() {
        scope.fdatos_mot_PunSum = {};
        scope.TvistaMotBloPunSum = 2;
        scope.validato_mot_bloqueo_PunSum = undefined;
    }
    scope.regresar_bloqueo_PunSum = function() {
        if (scope.validato_mot_bloqueo_PunSum == undefined) {
            Swal.fire({

                text: "¿Seguro que desea cerrar sin bloquear la Dirección?",
                type: "question",
                showCancelButton: !0,
                confirmButtonColor: "#31ce77",
                cancelButtonColor: "#f34943",
                confirmButtonText: "Confirmar"
            }).then(function(t) {
                if (t.value == true) {
                    scope.fdatos_mot_PunSum = {};
                    scope.TvistaMotBloPunSum = 1;
                    scope.validato_mot_bloqueo_PunSum = undefined;
                    scope.cargar_lista_motivos_punto_sumininistro();
                    return false;
                } else {
                    console.log('Cancelando Ando...');
                    return false;
                }
            });
        } else {
            scope.fdatos_mot_PunSum = {};
            scope.TvistaMotBloPunSum = 1;
            scope.validato_mot_bloqueo_PunSum = undefined;
            scope.cargar_lista_motivos_punto_sumininistro();
        }
    }
    $scope.submitFormPunSum = function(event) {
        console.log(scope.fdatos_mot_PunSum);
        if (scope.fdatos_mot_PunSum.CodMotBloPun > 0) {

            var title = 'Actualizando';
            var text = '¿Seguro que desea actualizar el Motivo de Bloqueo de la Dirección de Suministro?';
            var response = "El Motivo de Bloqueo de la Dirección de Suministro ha sido modificado de forma correcta";
        }
        if (scope.fdatos_mot_PunSum.CodMotBloPun == undefined) {
            var title = 'Guardando';
            var text = '¿Seguro que desea grabar el Motivo de Bloqueo de la Dirección de Suministro?';
            var response = "El Motivo de Bloqueo de la Dirección de Suministro ha sido registrado de forma correcta";
        }
        if (scope.fdatos_mot_PunSum.ObsMotBloPun == undefined || scope.fdatos_mot_PunSum.ObsMotBloPun == null || scope.fdatos_mot_PunSum.ObsMotBloPun == "") {
            scope.fdatos_mot_PunSum.ObsMotBloPun = null;
        } else {
            scope.fdatos_mot_PunSum.ObsMotBloPun = scope.fdatos_mot_PunSum.ObsMotBloPun;
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
                $("#" + title).removeClass("loader loader-default").addClass("loader loader-default is-active");
                var url = base_urlHome() + "api/Motivos_Bloqueos/crear_motivo_bloqueo_PunSum/";
                $http.post(url, scope.fdatos_mot_PunSum).then(function(result) {
                    scope.nIDMotBloPunSum = result.data.CodMotBloPun;
                    $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (scope.nIDMotBloPunSum > 0) {
                        console.log(result.data);
                        Swal.fire({ title: title, text: response, type: "success", confirmButtonColor: "#188ae2" });
                        scope.buscarXID_MotBloPunSum();
                    } else {
                        Swal.fire({ title: "Error", text: "Ha ocurrido un error, intente nuevamente", type: "error", confirmButtonColor: "#188ae2" });
                    }
                }, function(error) {
                    console.log(error);
                    $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
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
            }
        });
    };
    scope.buscarXID_MotBloPunSum = function() {
        $("#cargando").removeClass("loader loader-default").addClass("loader loader-default  is-active");
        var url = base_urlHome() + "api/Motivos_Bloqueos/buscar_xID_MotBloPunSum/CodMotBloPun/" + scope.nIDMotBloPunSum;
        $http.get(url).then(function(result) {
            $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (result.data != false) {
                scope.fdatos_mot_PunSum = result.data;
                console.log(scope.fdatos_mot_PunSum);
            } else {
                Swal.fire({ title: "Error", text: "Hubo un error al intentar cargar los datos.", type: "error", confirmButtonColor: "#188ae2" });
            }
        }, function(error) {
            console.log(error);
            $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
    scope.limpiar_PunSum = function() {
        scope.fdatos_mot_PunSum = {};
    }

    scope.borrar_PunSum = function() {
        var event = true;
        if (scope.Nivel == 3) {
            Swal.fire({ title: "Usuario no Autorizado", text: "No tiene permisos para realizar esta operación", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        Swal.fire({
            title: "Borrar",
            text: "¿Seguro que desea eliminar el Motivo?",
            type: "question",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: "Confirmar"
        }).then(function(t) {
            if (t.value == true) {
                $("#borrando").removeClass("loader loader-default").addClass("loader loader-default  is-active");
                var url = base_urlHome() + "api/Motivos_Bloqueos/borrar_row_MotBloPunSum/CodMotBloPun/" + scope.fdatos_mot_PunSum.CodMotBloPun;
                $http.delete(url).then(function(result) {
                    $("#borrando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (result.data != false) {
                        Swal.fire({ title: "Exito!!", text: "Registro eliminado de forma correcta", type: "success", confirmButtonColor: "#188ae2" });
                        scope.TvistaMotBloPunSum = 1;
                        scope.cargar_lista_motivos_punto_sumininistro();
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
                        Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY incorrecto", type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 500 && error.statusText == "Internal Server Error") {
                        Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
                    }
                });
            } else {
                event.preventDefault();
            }
        });
    }
    scope.validar_opcion_PunSum = function(index, opciones_PunSum, datos) {
            scope.opciones_PunSum[index] = undefined;
            if (opciones_PunSum == 1) {
                scope.TvistaMotBloPunSum = 2;
                scope.fdatos_mot_PunSum = datos;
                scope.validato_mot_bloqueo_PunSum = 1;
            }
            if (opciones_PunSum == 2) {
                scope.TvistaMotBloPunSum = 2;
                scope.fdatos_mot_PunSum = datos;
                scope.validato_mot_bloqueo_PunSum = undefined;
            }
        }
        //////////////////////////////////////////////////////////////MOTIVOS BLOQUEOS PUNTOS SUMINISTROS END//////////////////////////////////////////////////////////////////////////////


    //////////////////////////////////////////////////////////////MOTIVOS BLOQUEOS CONTACTOS START//////////////////////////////////////////////////////////////////////////////
    scope.cargar_lista_motivo_contactos = function() {
        $("#cargando_lista").removeClass("loader loader-default").addClass("loader loader-default  is-active");
        var url = base_urlHome() + "api/Motivos_Bloqueos/list_motivo_contactos/";
        $http.get(url).then(function(result) {
            $("#cargando_lista").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (result.data != false) {
                $scope.predicate4 = 'id';
                $scope.reverse4 = true;
                $scope.currentPage4 = 1;
                $scope.order4 = function(predicate4) {
                    $scope.reverse4 = ($scope.predicate4 === predicate4) ? !$scope.reverse4 : false;
                    $scope.predicate4 = predicate4;
                };
                scope.TMotivo_BloContacto = result.data;
                $scope.totalItems4 = scope.TMotivo_BloContacto.length;
                $scope.numPerPage4 = 50;
                $scope.paginate4 = function(value4) {
                    var begin4, end4, index4;
                    begin4 = ($scope.currentPage4 - 1) * $scope.numPerPage4;
                    end4 = begin4 + $scope.numPerPage4;
                    index4 = scope.TMotivo_BloContacto.indexOf(value4);
                    return (begin4 <= index4 && index4 < end4);
                };
                console.log(scope.TMotivo_BloContacto);
            } else {
                scope.TMotivo_BloContacto = [];
            }
        }, function(error) {
            $("#cargando_lista").removeClass("loader loader-default is-active").addClass("loader loader-default");
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

    scope.agg_bloqueo_Contacto = function() {
        scope.fdatos_mot_contacto = {};
        scope.TVistaBloqueoContacto = 2;
        scope.validate_mot_contacto = undefined;
    }
    scope.regresar_Contacto = function() {
        if (scope.validate_mot_contacto == undefined) {
            Swal.fire({

                text: "¿Seguro que desea cerrar sin bloquear el Contacto?",
                type: "question",
                showCancelButton: !0,
                confirmButtonColor: "#31ce77",
                cancelButtonColor: "#f34943",
                confirmButtonText: "Confirmar"
            }).then(function(t) {
                if (t.value == true) {
                    scope.fdatos_mot_contacto = {};
                    scope.TVistaBloqueoContacto = 1;
                    scope.validate_mot_contacto = undefined;
                    scope.cargar_lista_motivo_contactos();
                    return false;
                } else {
                    console.log('Cancelando Ando...');
                    return false;
                }
            });
        } else {
            scope.fdatos_mot_contacto = {};
            scope.TVistaBloqueoContacto = 1;
            scope.validate_mot_contacto = undefined;
            scope.cargar_lista_motivo_contactos();
        }
    }
    $scope.submitFormContactos = function(event) {
        console.log(scope.fdatos_mot_contacto);
        if (scope.fdatos_mot_contacto.CodMotBloCon > 0) {
            var title = 'Actualizando';
            var text = '¿Seguro que desea modificar el Motivo de Bloqueo del Contacto?';
            var response = "El Motivo de Bloqueo del Contacto ha sido modificado de forma correcta";
        }
        if (scope.fdatos_mot_contacto.CodMotBloCon == undefined) {

            var title = 'Guardando';
            var text = '¿Seguro que desea grabar el Motivo de Bloqueo del Contacto?';
            var response = "El Motivo de Bloqueo del Contacto ha sido registrado de formar correcta";
        }
        if (scope.fdatos_mot_contacto.ObsMotBloCon == undefined || scope.fdatos_mot_contacto.ObsMotBloCon == null || scope.fdatos_mot_contacto.ObsMotBloCon == "") {
            scope.fdatos_mot_contacto.ObsMotBloCon = null;
        } else {
            scope.fdatos_mot_contacto.ObsMotBloCon = scope.fdatos_mot_contacto.ObsMotBloCon;
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
                $("#" + title).removeClass("loader loader-default").addClass("loader loader-default is-active");
                var url = base_urlHome() + "api/Motivos_Bloqueos/crear_motivo_bloqueo_Contacto/";
                $http.post(url, scope.fdatos_mot_contacto).then(function(result) {
                    scope.nIDMotBloContacto = result.data.CodMotBloCon;
                    $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (scope.nIDMotBloContacto > 0) {
                        console.log(result.data);
                        Swal.fire({ title: title, text: response, type: "success", confirmButtonColor: "#188ae2" });
                        scope.buscarXID_MotBloContacto();
                    } else {
                        Swal.fire({ title: "Error", text: "Ha ocurrido un error, intente nuevamente", type: "error", confirmButtonColor: "#188ae2" });
                    }
                }, function(error) {
                    console.log(error);
                    $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
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
            }
        });
    };
    scope.buscarXID_MotBloContacto = function() {
        $("#cargando").removeClass("loader loader-default").addClass("loader loader-default  is-active");
        var url = base_urlHome() + "api/Motivos_Bloqueos/buscar_xID_MotBloContacto/CodMotBloCon/" + scope.nIDMotBloContacto;
        $http.get(url).then(function(result) {
            $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (result.data != false) {
                scope.fdatos_mot_contacto = result.data;
                console.log(scope.fdatos_mot_contacto);
            } else {
                Swal.fire({ title: "Error", text: "Hubo un error cargando la información", type: "error", confirmButtonColor: "#188ae2" });
            }
        }, function(error) {
            console.log(error);
            $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
    scope.limpiar_PunSum = function() {
        scope.fdatos_mot_contacto = {};
    }

    scope.borrar_Contacto = function() {
        var event = true;
        if (scope.Nivel == 3) {
            Swal.fire({ title: "Usuario no Autorizado", text: "No tiene permisos para realizar esta operación", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        Swal.fire({
            title: "Borrar",
            text: "¿Seguro que desea eliminar el Motivo?",
            type: "question",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: "Confirmar"
        }).then(function(t) {
            if (t.value == true) {
                $("#borrando").removeClass("loader loader-default").addClass("loader loader-default  is-active");
                var url = base_urlHome() + "api/Motivos_Bloqueos/borrar_row_MotBloContacto/CodMotBloCon/" + scope.fdatos_mot_contacto.CodMotBloCon;
                $http.delete(url).then(function(result) {
                    $("#borrando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (result.data != false) {
                        Swal.fire({ title: "Exito!!", text: "Registro eliminado de forma correcta", type: "success", confirmButtonColor: "#188ae2" });
                        scope.TVistaBloqueoContacto = 1;
                        scope.cargar_lista_motivo_contactos();
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
                        Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY incorrecto", type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 500 && error.statusText == "Internal Server Error") {
                        Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
                    }
                });
            } else {
                event.preventDefault();
            }
        });
    }
    scope.validar_opcion_contacto = function(index, opciones_contacto, datos) {
            scope.opciones_contacto[index] = undefined;
            if (opciones_contacto == 1) {
                scope.TVistaBloqueoContacto = 2;
                scope.fdatos_mot_contacto = datos;
                scope.validate_mot_contacto = 1;
            }
            if (opciones_contacto == 2) {
                scope.TVistaBloqueoContacto = 2;
                scope.fdatos_mot_contacto = datos;
                scope.validate_mot_contacto = undefined;
            }
        }
        //////////////////////////////////////////////////////////////MOTIVOS BLOQUEOS CONTACTOS END//////////////////////////////////////////////////////////////////////////////



    //////////////////////////////////////////////////////////////MOTIVOS BLOQUEOS COMERCIALIZADORAS START//////////////////////////////////////////////////////////////////////////////
    scope.cargar_lista_motivo_comercializadora = function() {
        $("#cargando_lista").removeClass("loader loader-default").addClass("loader loader-default  is-active");
        var url = base_urlHome() + "api/Motivos_Bloqueos/list_motivo_comercializadora/";
        $http.get(url).then(function(result) {
            $("#cargando_lista").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (result.data != false) {
                $scope.predicate5 = 'id';
                $scope.reverse5 = true;
                $scope.currentPage5 = 1;
                $scope.order5 = function(predicate5) {
                    $scope.reverse5 = ($scope.predicate5 === predicate5) ? !$scope.reverse5 : false;
                    $scope.predicate5 = predicate5;
                };
                scope.TMotivo_BloComercializadora = result.data;
                $scope.totalItems5 = scope.TMotivo_BloComercializadora.length;
                $scope.numPerPage5 = 50;
                $scope.paginate5 = function(value5) {
                    var begin5, end5, index5;
                    begin5 = ($scope.currentPage5 - 1) * $scope.numPerPage5;
                    end5 = begin5 + $scope.numPerPage5;
                    index5 = scope.TMotivo_BloComercializadora.indexOf(value5);
                    return (begin5 <= index5 && index5 < end5);
                };
                console.log(scope.TMotivo_BloComercializadora);
            } else {
                scope.TMotivo_BloComercializadora = [];
            }
        }, function(error) {
            $("#cargando_lista").removeClass("loader loader-default is-active").addClass("loader loader-default");
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

    scope.agg_bloqueo_Comercializadora = function() {
        scope.fdatos_mot_comercializadora = {};
        scope.TVistaBloqueoComercializadora = 2;
        scope.validate_mot_comercializadora = undefined;
    }
    scope.regresar_Comercializadora = function() {
        if (scope.validate_mot_comercializadora == undefined) {
            Swal.fire({

                text: "¿Seguro que desea cerrar sin bloquear la Comercializadora?",
                type: "question",
                showCancelButton: !0,
                confirmButtonColor: "#31ce77",
                cancelButtonColor: "#f34943",
                confirmButtonText: "Confirmar"
            }).then(function(t) {
                if (t.value == true) {
                    scope.fdatos_mot_comercializadora = {};
                    scope.TVistaBloqueoComercializadora = 1;
                    scope.validate_mot_comercializadora = undefined;
                    scope.cargar_lista_motivo_comercializadora();
                    return false;
                } else {
                    console.log('Cancelando Ando...');
                    return false;
                }
            });
        } else {
            scope.fdatos_mot_comercializadora = {};
            scope.TVistaBloqueoComercializadora = 1;
            scope.validate_mot_comercializadora = undefined;
            scope.cargar_lista_motivo_comercializadora();
        }
    }
    $scope.submitFormComercializadora = function(event) {
        console.log(scope.fdatos_mot_comercializadora);
        if (scope.fdatos_mot_comercializadora.CodMotBloCom > 0) {

            var title = 'Actualizando';
            var text = '¿Seguro que desea actualizar el Motivo de Bloqueo de la Comercializadora?';
            var response = "El Motivo de Bloqueo de la Comercializadora ha sido modificado de forma correcta";
        }
        if (scope.fdatos_mot_comercializadora.CodMotBloCom == undefined) {

            var title = 'Guardando';
            var text = '¿Seguro que desea grabar el Notivo de Bloqueo de la Comercializadora?';
            var response = "El Motivo de Bloqueo de la Comercializadora ha sido registrado de forma correcta";
        }
        if (scope.fdatos_mot_comercializadora.ObsMotBloCom == undefined || scope.fdatos_mot_comercializadora.ObsMotBloCom == null || scope.fdatos_mot_comercializadora.ObsMotBloCom == "") {
            scope.fdatos_mot_comercializadora.ObsMotBloCom = null;
        } else {
            scope.fdatos_mot_comercializadora.ObsMotBloCom = scope.fdatos_mot_comercializadora.ObsMotBloCom;
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
                $("#" + title).removeClass("loader loader-default").addClass("loader loader-default is-active");
                var url = base_urlHome() + "api/Motivos_Bloqueos/crear_motivo_bloqueo_Comercializadora/";
                $http.post(url, scope.fdatos_mot_comercializadora).then(function(result) {
                    scope.nIDMotBloComercializadora = result.data.CodMotBloCom;
                    $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (scope.nIDMotBloComercializadora > 0) {
                        console.log(result.data);
                        Swal.fire({ title: title, text: response, type: "success", confirmButtonColor: "#188ae2" });
                        scope.buscarXID_MotBloComercializadora();
                    } else {
                        Swal.fire({ title: "Error", text: "Ha ocurrido un error, intente nuevamente", type: "error", confirmButtonColor: "#188ae2" });
                    }
                }, function(error) {
                    console.log(error);
                    $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
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
            }
        });
    };
    scope.buscarXID_MotBloComercializadora = function() {
        $("#cargando").removeClass("loader loader-default").addClass("loader loader-default  is-active");
        var url = base_urlHome() + "api/Motivos_Bloqueos/buscar_xID_MotBloComercializadora/CodMotBloCom/" + scope.nIDMotBloComercializadora;
        $http.get(url).then(function(result) {
            $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (result.data != false) {
                scope.fdatos_mot_comercializadora = result.data;
                console.log(scope.fdatos_mot_comercializadora);
            } else {
                Swal.fire({ title: "Error", text: "Ha ocurrido un error al cargar la información", type: "error", confirmButtonColor: "#188ae2" });
            }
        }, function(error) {
            console.log(error);
            $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
    scope.limpiar_Comercializadora = function() {
        scope.fdatos_mot_comercializadora = {};
    }

    scope.borrar_Comercializadora = function() {
        var event = true;
        if (scope.Nivel == 3) {
            Swal.fire({ title: "Usuario no Autorizado", text: "No tiene permisos para realizar esta operación", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        Swal.fire({
            title: "Borrar",
            text: "¿Seguro que desea eliminar el Motivo?",
            type: "question",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: "Confirmar"
        }).then(function(t) {
            if (t.value == true) {
                $("#borrando").removeClass("loader loader-default").addClass("loader loader-default  is-active");
                var url = base_urlHome() + "api/Motivos_Bloqueos/borrar_row_MotBloComercializadora/CodMotBloCom/" + scope.fdatos_mot_comercializadora.CodMotBloCom;
                $http.delete(url).then(function(result) {
                    $("#borrando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (result.data != false) {
                        Swal.fire({ title: "Exito!!", text: "Registro eliminado de forma correcta", type: "success", confirmButtonColor: "#188ae2" });
                        scope.TVistaBloqueoComercializadora = 1;
                        scope.cargar_lista_motivo_comercializadora();
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
                        Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY incorrecto", type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 500 && error.statusText == "Internal Server Error") {
                        Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
                    }
                });
            } else {
                event.preventDefault();
            }
        });
    }
    scope.validar_opcion_comercializadora = function(index, opciones_comercializadora, datos) {
            scope.opciones_comercializadora[index] = undefined;
            if (opciones_comercializadora == 1) {
                scope.TVistaBloqueoComercializadora = 2;
                scope.fdatos_mot_comercializadora = datos;
                scope.validate_mot_comercializadora = 1;
            }
            if (opciones_comercializadora == 2) {
                scope.TVistaBloqueoComercializadora = 2;
                scope.fdatos_mot_comercializadora = datos;
                scope.validate_mot_comercializadora = undefined;
            }
        }
        //////////////////////////////////////////////////////////////MOTIVOS BLOQUEOS COMERCIALIZADORAS END//////////////////////////////////////////////////////////////////////////////


    //////////////////////////////////////////////////////////////////MOTIVOS BLOQUEOS CUPS START//////////////////////////////////////////////////////////////////////////////
    scope.cargar_lista_motivo_cups = function() {
        $("#cargando_lista").removeClass("loader loader-default").addClass("loader loader-default  is-active");
        var url = base_urlHome() + "api/Motivos_Bloqueos/list_motivo_CUPS/";
        $http.get(url).then(function(result) {
            $("#cargando_lista").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (result.data != false) {
                $scope.predicate6 = 'id';
                $scope.reverse6 = true;
                $scope.currentPage6 = 1;
                $scope.order6 = function(predicate6) {
                    $scope.reverse6 = ($scope.predicate6 === predicate6) ? !$scope.reverse6 : false;
                    $scope.predicate6 = predicate6;
                };
                scope.TMotivo_BloCUPs = result.data;
                $scope.totalItems6 = scope.TMotivo_BloCUPs.length;
                $scope.numPerPage6 = 50;
                $scope.paginate6 = function(value6) {
                    var begin6, end6, index6;
                    begin6 = ($scope.currentPage6 - 1) * $scope.numPerPage6;
                    end6 = begin6 + $scope.numPerPage6;
                    index6 = scope.TMotivo_BloCUPs.indexOf(value6);
                    return (begin6 <= index6 && index6 < end6);
                };
                console.log(scope.TMotivo_BloCUPs);
            } else {
                scope.TMotivo_BloCUPs = [];
            }
        }, function(error) {
            $("#cargando_lista").removeClass("loader loader-default is-active").addClass("loader loader-default");
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

    scope.agg_bloqueo_CUPs = function() {
        scope.fdatos_mot_cups = {};
        scope.TVistaBloqueoCUPs = 2;
        scope.validate_mot_bloqueo_cups = undefined;
    }
    scope.validar_opcion_cups = function(index, opciones_cups, datos) {
        scope.opciones_cups[index] = undefined;
        if (opciones_cups == 1) {
            scope.TVistaBloqueoCUPs = 2;
            scope.fdatos_mot_cups = datos;
            scope.validate_mot_bloqueo_cups = 1;
        }
        if (opciones_cups == 2) {
            scope.TVistaBloqueoCUPs = 2;
            scope.fdatos_mot_cups = datos;
            scope.validate_mot_bloqueo_cups = undefined;
        }
    }
    scope.limpiar_CUPs = function() {
        scope.fdatos_mot_cups = {};
    }

    scope.regresar_CUPs = function() {
        if (scope.validate_mot_bloqueo_cups == undefined) {
            Swal.fire({
                /**title: "Regresar",**/
                text: "¿Seguro que desea cerrar sin bloquear el CUP?",
                type: "question",
                showCancelButton: !0,
                confirmButtonColor: "#31ce77",
                cancelButtonColor: "#f34943",
                confirmButtonText: "Confirmar"
            }).then(function(t) {
                if (t.value == true) {
                    scope.fdatos_mot_cups = {};
                    scope.TVistaBloqueoCUPs = 1;
                    scope.validate_mot_bloqueo_cups = undefined;
                    scope.cargar_lista_motivo_cups();
                    return false;
                } else {
                    console.log('Cancelando Ando...');
                    return false;
                }
            });
        } else {
            scope.fdatos_mot_cups = {};
            scope.TVistaBloqueoCUPs = 1;
            scope.validate_mot_bloqueo_cups = undefined;
            scope.cargar_lista_motivo_cups();
        }
    }

    scope.buscarXID_MotBloCUPs = function() {
        $("#cargando").removeClass("loader loader-default").addClass("loader loader-default  is-active");
        var url = base_urlHome() + "api/Motivos_Bloqueos/buscar_xID_MotBloCUPs/CodMotBloCUPs/" + scope.nIDMotBloCUPs;
        $http.get(url).then(function(result) {
            $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (result.data != false) {
                scope.fdatos_mot_cups = result.data;
                console.log(scope.fdatos_mot_cups);
            } else {
                Swal.fire({ title: "Error", text: "Ha ocurrido un error cargando la información", type: "error", confirmButtonColor: "#188ae2" });
            }
        }, function(error) {
            console.log(error);
            $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
    $scope.submitFormCUPs = function(event) {
        console.log(scope.fdatos_mot_cups);
        if (scope.fdatos_mot_cups.CodMotBloCUPs > 0) {
            var title = 'Actualizando';
            var text = '¿Seguro que desea actualizar el Motivo de Bloqueo de Comercializadora?';
            var response = "El Motivo de Bloqueo de la Comercializadora ha sido modificado de forma correcta";
        }
        if (scope.fdatos_mot_cups.CodMotBloCUPs == undefined) {
            var title = 'Guardando';
            var text = '¿Seguro que desea creado el Motivo de Bloqueo de Comercializadora?';
            var response = "El Motivo de Bloqueo de Comercializadora ha sido registrado de forma correcta";
        }
        if (scope.fdatos_mot_cups.ObsMotBloCUPs == undefined || scope.fdatos_mot_cups.ObsMotBloCUPs == null || scope.fdatos_mot_cups.ObsMotBloCUPs == "") {
            scope.fdatos_mot_cups.ObsMotBloCUPs = null;
        } else {
            scope.fdatos_mot_cups.ObsMotBloCUPs = scope.fdatos_mot_cups.ObsMotBloCUPs;
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
                $("#" + title).removeClass("loader loader-default").addClass("loader loader-default is-active");
                var url = base_urlHome() + "api/Motivos_Bloqueos/crear_motivo_bloqueo_CUPs/";
                $http.post(url, scope.fdatos_mot_cups).then(function(result) {
                    scope.nIDMotBloCUPs = result.data.CodMotBloCUPs;
                    $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (scope.nIDMotBloCUPs > 0) {
                        console.log(result.data);
                        Swal.fire({ title: title, text: response, type: "success", confirmButtonColor: "#188ae2" });
                        scope.buscarXID_MotBloCUPs();
                    } else {
                        Swal.fire({ title: "Error", text: "Ha ocurrido un error, intente nuevamente", type: "error", confirmButtonColor: "#188ae2" });
                    }
                }, function(error) {
                    console.log(error);
                    $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
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
            }
        });
    };
    scope.borrar_CUPs = function() {
            var event = true;
            if (scope.Nivel == 3) {
                Swal.fire({ title: "Usuario no Autorizado", text: "No tiene permisos para realizar esta operación", type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }
            Swal.fire({
                /**title: "Borrar",**/
                text: "¿Seguro que desea eliminar el Motivo de Bloqueo?",
                type: "question",
                showCancelButton: !0,
                confirmButtonColor: "#31ce77",
                cancelButtonColor: "#f34943",
                confirmButtonText: "Confirmar"
            }).then(function(t) {
                if (t.value == true) {
                    $("#borrando").removeClass("loader loader-default").addClass("loader loader-default  is-active");
                    var url = base_urlHome() + "api/Motivos_Bloqueos/borrar_row_MotBloCUPs/CodMotBloCUPs/" + scope.fdatos_mot_cups.CodMotBloCUPs;
                    $http.delete(url).then(function(result) {
                        $("#borrando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                        if (result.data != false) {
                            Swal.fire({ text: "El registro ha sido eliminado de forma correcta", type: "success", confirmButtonColor: "#188ae2" });
                            scope.TVistaBloqueoCUPs = 1;
                            scope.cargar_lista_motivo_cups();
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
                            Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY incorrecto", type: "error", confirmButtonColor: "#188ae2" });
                        }
                        if (error.status == 500 && error.statusText == "Internal Server Error") {
                            Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
                        }
                    });
                } else {
                    event.preventDefault();
                }
            });
        }
        //////////////////////////////////////////////////////////////////MOTIVOS BLOQUEOS CUPS END//////////////////////////////////////////////////////////////////////////////


}