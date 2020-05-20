app.controller('Controlador_Empleados', ['$http', '$scope', '$filter', '$route', '$interval', '$controller', '$cookies', Controlador]);

function Controlador($http, $scope, $filter, $route, $interval, $controller, $cookies) {
    //declaramos una variable llamada scope donde tendremos a vm
    /*inyectamos un controlador para acceder a sus variables y metodos*/
    //$controller('ControladorArticuloExistencia as vmAE',{$scope:$scope});			
    var scope = this;
    scope.fdatos = {}; // datos del formulario
    scope.fdatos.detalle = [];
    scope.nID = $route.current.params.ID; //contiene el id del registro en caso de estarse consultando desde la grid
    scope.Nivel = $cookies.get('nivel');
    scope.Templeados = [];
    scope.TempleadosBack = [];
    scope.select_controller = [];
    scope.controladores_seleccionados = [];


    $scope.submitForm = function(event) {
        console.log(scope.fdatos);
        bootbox.confirm({
            title: "Confirmación",
            message: "¿Seguro que desea crear el Usuario?",
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> Cancelar'
                },
                confirm: {
                    label: '<i class="fa fa-check"></i> Confirmar'
                }
            },
            callback: function(result) {
                if (result == false) {
                    event.preventDefault();
                } else {
                    scope.guardar();
                }
            }
        });

    };
    scope.generar_key = function() {
        scope.disabled_button = false;
        $("#generar_key").removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url = base_urlHome() + "api/Usuarios/newApiKey/";
        $http.get(url).then(function(result) {
            if (result.data != false) {
                console.log(result.data);
                $("#generar_key").removeClass("loader loader-default is-active").addClass("loader loader-default");
                scope.fdatos.key = result.data;
                scope.disabled_button = true;
            } else {
                $("#generar_key").removeClass("loader loader-default is-active").addClass("loader loader-default");
                bootbox.alert({
                    message: "Ha ocurrido un error intentando generar el key, intente nuevamente",
                    size: 'middle'
                });
                scope.disabled_button = false;
            }

        }, function(error) {
            if (error.status == 404 && error.statusText == "Not Found") {
                $("#generar_key").removeClass("loader loader-default is-active").addClass("loader loader-default");
                bootbox.alert({
                    message: "El método que está intentando usar no puede ser localizado",
                    size: 'middle'
                });
            }
            if (error.status == 401 && error.statusText == "Unauthorized") {
                $("#generar_key").removeClass("loader loader-default is-active").addClass("loader loader-default");
                bootbox.alert({
                    message: "Usuario no autorizado para acceder a este Módulo",
                    size: 'middle'
                });
            }
            if (error.status == 403 && error.statusText == "Forbidden") {
                $("#generar_key").removeClass("loader loader-default is-active").addClass("loader loader-default");
                bootbox.alert({
                    message: "Está intentando utilizar un APIKEY inválido",
                    size: 'middle'
                });
            }
            if (error.status == 500 && error.statusText == "Internal Server Error") {
                $("#generar_key").removeClass("loader loader-default is-active").addClass("loader loader-default");
                bootbox.alert({
                    message: "Ha ocurrido una falla en el Servidor, intente más tarde",
                    size: 'middle'
                });
            }
        });
    }
    scope.guardar = function() {
        $("#crear_usuario").removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url = base_urlHome() + "api/Usuarios/crear_usuario/";
        $http.post(url, scope.fdatos).then(function(result) {
            scope.nID = result.data.id;
            if (scope.nID > 0) {
                console.log(result.data);
                $("#crear_usuario").removeClass("loader loader-default is-active").addClass("loader loader-default");
                bootbox.alert({
                    message: "El usuario ha sido registrado de forma correcta",
                    size: 'middle'
                });
                scope.buscarXID();
            } else {
                $("#crear_usuario").removeClass("loader loader-default is-active").addClass("loader loader-default");
                bootbox.alert({
                    message: "Ha ocurrido un error intentando grabar el Usuario, por favor intente nuevamente",
                    size: 'middle'
                });
            }
        }, function(error) {
            if (error.status == 404 && error.statusText == "Not Found") {
                $("#crear_usuario").removeClass("loader loader-default is-active").addClass("loader loader-default");
                bootbox.alert({
                    message: "El método que está intentando usar no puede ser localizado",
                    size: 'middle'
                });
            }
            if (error.status == 401 && error.statusText == "Unauthorized") {
                $("#crear_usuario").removeClass("loader loader-default is-active").addClass("loader loader-default");
                bootbox.alert({
                    message: "Usuario no autorizado para acceder a este Módulo",
                    size: 'middle'
                });
            }
            if (error.status == 403 && error.statusText == "Forbidden") {
                $("#crear_usuario").removeClass("loader loader-default is-active").addClass("loader loader-default");
                bootbox.alert({
                    message: "Está intentando utilizar un APIKEY inválido",
                    size: 'middle'
                });
            }
            if (error.status == 500 && error.statusText == "Internal Server Error") {
                $("#crear_usuario").removeClass("loader loader-default is-active").addClass("loader loader-default");
                bootbox.alert({
                    message: "Ha ocurrido una falla en el Servidor, intente más tarde",
                    size: 'middle'
                });
            }
        });
    }
    scope.borrar = function() {
        if (scope.Nivel == 3) {
            Swal.fire({ title: "Usuario no Autorizado", text: "No tiene permisos para realizar esta operación", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        bootbox.confirm({
            title: "Confirmación",
            message: "¿Seguro que desea eliminar el Usuario?",
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> Cancelar'
                },
                confirm: {
                    label: '<i class="fa fa-check"></i> Confirmar'
                }
            },
            callback: function(result) {
                if (result == false) {
                    console.log('Cancelando Ando...');
                } else {
                    $("#borrando").removeClass("loader loader-default").addClass("loader loader-default  is-active");
                    var url = base_urlHome() + "api/Usuarios/borrar_row/huser/" + scope.fdatos.id;
                    $http.delete(url).then(function(result) {
                        if (result.data != false) {
                            $("#borrando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                            bootbox.alert({
                                message: "Registro eliminado de forma correcta",
                                size: 'middle'
                            });
                        } else {
                            $("#borrando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                            bootbox.alert({
                                message: "No se ha podido eliminar el registro, intente nuevamente",
                                size: 'middle'
                            });
                        }

                    }, function(error) {
                        if (error.status == 404 && error.statusText == "Not Found") {
                            $("#borrando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                            bootbox.alert({
                                message: "El método que está intentando usar no puede ser localizado",
                                size: 'middle'
                            });
                        }
                        if (error.status == 401 && error.statusText == "Unauthorized") {
                            $("#borrando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                            bootbox.alert({
                                message: "Usuario no autorizado para acceder a este Módulo",
                                size: 'middle'
                            });
                        }
                        if (error.status == 403 && error.statusText == "Forbidden") {
                            $("#borrando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                            bootbox.alert({
                                message: "Está intentando utilizar un APIKEY inválido",
                                size: 'middle'
                            });
                        }
                        if (error.status == 500 && error.statusText == "Internal Server Error") {
                            $("#borrando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                            bootbox.alert({
                                message: "Ha ocurrido una falla en el Servidor, intente más tarde",
                                size: 'middle'
                            });
                        }
                    });
                }
            }
        });
    }
    scope.borrar_row = function(index, id) {
        if (scope.Nivel == 3) {
            Swal.fire({ title: "Usuario no Autorizado", text: "No tiene permisos para realizar esta operación", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        bootbox.confirm({
            title: "Confirmación",
            message: "¿Seguro que desea eliminar el Usuario?",
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> Cancelar'
                },
                confirm: {
                    label: '<i class="fa fa-check"></i> Confirmar'
                }
            },
            callback: function(result) {
                if (result == false) {
                    console.log('Cancelando Ando...');
                } else {
                    $("#borrando").removeClass("loader loader-default").addClass("loader loader-default  is-active");
                    var url = base_urlHome() + "api/Usuarios/borrar_row/huser/" + id;
                    $http.delete(url).then(function(result) {
                        if (result.data != false) {
                            $("#borrando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                            bootbox.alert({
                                message: "Registro eliminado de forma correcta",
                                size: 'middle'
                            });
                            scope.Templeados.splice(index, 1);
                        } else {
                            $("#borrando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                            bootbox.alert({
                                message: "No se ha podido eliminar el registro, intente nuevamente",
                                size: 'middle'
                            });
                        }

                    }, function(error) {
                        if (error.status == 404 && error.statusText == "Not Found") {
                            $("#borrando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                            bootbox.alert({
                                message: "El método que está intentando usar no puede ser localizado",
                                size: 'middle'
                            });
                        }
                        if (error.status == 401 && error.statusText == "Unauthorized") {
                            $("#borrando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                            bootbox.alert({
                                message: "Usuario no autorizado para acceder a este Módulo",
                                size: 'middle'
                            });
                        }
                        if (error.status == 403 && error.statusText == "Forbidden") {
                            $("#borrando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                            bootbox.alert({
                                message: "Está intentando utilizar un APIKEY inválido",
                                size: 'middle'
                            });
                        }
                        if (error.status == 500 && error.statusText == "Internal Server Error") {
                            $("#borrando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                            bootbox.alert({
                                message: "Ha ocurrido una falla en el Servidor, intente más tarde",
                                size: 'middle'
                            });
                        }
                    });
                }
            }
        });
    }

    scope.cargar_lista_empleados = function() {
        $("#cargando").removeClass("loader loader-default").addClass("loader loader-default  is-active");
        var url = base_urlHome() + "api/Usuarios/list_empleados/";
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
                scope.Templeados = result.data;
                $scope.totalItems = scope.Templeados.length;
                $scope.numPerPage = 50;
                $scope.paginate = function(value) {
                    var begin, end, index;
                    begin = ($scope.currentPage - 1) * $scope.numPerPage;
                    end = begin + $scope.numPerPage;
                    index = scope.Templeados.indexOf(value);
                    return (begin <= index && index < end);
                };
                console.log(scope.Templeados);
            } else {
                $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                bootbox.alert({
                    message: "No existen Empleados registrados",
                    size: 'middle'
                });
                scope.Templeados = undefined;
            }
        }, function(error) {
            if (error.status == 404 && error.statusText == "Not Found") {
                $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                bootbox.alert({
                    message: "El método que está intentando usar no puede ser localizado",
                    size: 'middle'
                });
            }
            if (error.status == 401 && error.statusText == "Unauthorized") {
                $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                bootbox.alert({
                    message: "Usuario no autorizado para acceder a este Módulo",
                    size: 'middle'
                });
            }
            if (error.status == 403 && error.statusText == "Forbidden") {
                $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                bootbox.alert({
                    message: "Está intentando utilizar un APIKEY inválido",
                    size: 'middle'
                });
            }
            if (error.status == 500 && error.statusText == "Internal Server Error") {
                $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                bootbox.alert({
                    message: "Ha ocurrido una falla en el Servidor, intente más tarde",
                    size: 'middle'
                });
            }
        });
    }
    scope.buscarXID = function() {
        $("#cargando").removeClass("loader loader-default").addClass("loader loader-default  is-active");
        var url = base_urlHome() + "api/Usuarios/buscar_xID/huser/" + scope.nID;
        $http.get(url).then(function(result) {
            if (result.data != false) {
                $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                scope.fdatos = result.data;

                angular.forEach(result.data.detalle, function(controllers) {
                    scope.select_controller[controllers.id] = controllers;
                });
                //console.log(scope.fdatos);
            } else {
                $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                bootbox.alert({
                    message: "Hubo un error al intentar cargar los datos.",
                    size: 'middle'
                });
            }
        }, function(error) {
            if (error.status == 404 && error.statusText == "Not Found") {
                $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                bootbox.alert({
                    message: "El método que está intentando usar no puede ser localizado",
                    size: 'middle'
                });
            }
            if (error.status == 401 && error.statusText == "Unauthorized") {
                $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                bootbox.alert({
                    message: "Usuario no autorizado para acceder a este Módulo",
                    size: 'middle'
                });
            }
            if (error.status == 403 && error.statusText == "Forbidden") {
                $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                bootbox.alert({
                    message: "Está intentando utilizar un APIKEY inválido",
                    size: 'middle'
                });
            }
            if (error.status == 500 && error.statusText == "Internal Server Error") {
                $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                bootbox.alert({
                    message: "Ha ocurrido una falla en el Servidor, intente más tarde",
                    size: 'middle'
                });
            }
        });
    }
    scope.limpiar = function() {
        scope.fdatos = {};
        scope.select_controller = [];
        //console.log(scope.fdatos);
    }
    scope.comprobar_disponibilidad_correo = function() {
        if (scope.fdatos.correo_electronico != undefined) {
            scope.disponibilidad_email = undefined;
            $("#comprobando_disponibilidad").removeClass("loader loader-default").addClass("loader loader-default  is-active");
            var url = base_urlHome() + "api/Usuarios/comprobar_email/email/" + scope.fdatos.correo_electronico;
            $http.get(url).then(function(result) {
                if (result.data != false) {
                    $("#comprobando_disponibilidad").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    //console.log(result.data);
                    scope.disponibilidad_email = true;
                } else {
                    $("#comprobando_disponibilidad").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    scope.disponibilidad_email = false;
                }

            }, function(error) {
                if (error.status == 404 && error.statusText == "Not Found") {
                    $("#comprobando_disponibilidad").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    bootbox.alert({
                        message: "El método que está intentando usar no puede ser localizado",
                        size: 'middle'
                    });
                }
                if (error.status == 401 && error.statusText == "Unauthorized") {
                    $("#comprobando_disponibilidad").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    bootbox.alert({
                        message: "Usuario no autorizado para acceder a este Módulo",
                        size: 'middle'
                    });
                }
                if (error.status == 403 && error.statusText == "Forbidden") {
                    $("#comprobando_disponibilidad").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    bootbox.alert({
                        message: "Está intentando utilizar un APIKEY inválido",
                        size: 'middle'
                    });
                }
                if (error.status == 500 && error.statusText == "Internal Server Error") {
                    $("#comprobando_disponibilidad").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    bootbox.alert({
                        message: "Ha ocurrido una falla en el Servidor, intente más tarde",
                        size: 'middle'
                    });
                }
            });
        } else {
            scope.disponibilidad_email = undefined;
        }
    }
    scope.comprobar_disponibilidad_username = function() {
        if (scope.fdatos.username != undefined) {
            $("#comprobando_disponibilidad").removeClass("loader loader-default").addClass("loader loader-default  is-active");
            scope.disponibilidad_username = undefined;
            var url = base_urlHome() + "api/Usuarios/comprobar_username/username/" + scope.fdatos.username;
            $http.get(url).then(function(result) {
                //console.log(result.data);
                if (result.data != false) {
                    $("#comprobando_disponibilidad").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    scope.disponibilidad_username = true;
                } else {
                    $("#comprobando_disponibilidad").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    scope.disponibilidad_username = false;
                }
            }, function(error) {
                if (error.status == 404 && error.statusText == "Not Found") {
                    $("#comprobando_disponibilidad").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    bootbox.alert({
                        message: "El método que está intentando usar no puede ser localizado",
                        size: 'middle'
                    });
                    scope.disponibilidad_username = undefined;
                }
                if (error.status == 401 && error.statusText == "Unauthorized") {
                    $("#comprobando_disponibilidad").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    bootbox.alert({
                        message: "Usuario no autorizado para acceder a este Módulo",
                        size: 'middle'
                    });
                    scope.disponibilidad_username = undefined;
                }
                if (error.status == 403 && error.statusText == "Forbidden") {
                    $("#comprobando_disponibilidad").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    bootbox.alert({
                        message: "Está intentando utilizar un APIKEY inválido",
                        size: 'middle'
                    });
                    scope.disponibilidad_username = undefined;
                }
                if (error.status == 500 && error.statusText == "Internal Server Error") {
                    $("#comprobando_disponibilidad").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    scope.disponibilidad_username = undefined;
                    bootbox.alert({
                        message: "Ha ocurrido una falla en el Servidor, intente más tarde",
                        size: 'middle'
                    });
                }
            });
        } else {
            scope.disponibilidad_username = undefined;
        }
    }
    scope.cargar_controladores = function() {
        var url = base_urlHome() + "api/Usuarios/cargar_controladores/";
        $http.get(url).then(function(result) {
            if (result.data != false) {
                scope.tController = result.data;
            } else {
                scope.tController = false;
            }

        }, function(error) {
            if (error.status == 404 && error.statusText == "Not Found") {
                bootbox.alert({
                    message: "El método que está intentando usar no puede ser localizado",
                    size: 'middle'
                });
            }
            if (error.status == 401 && error.statusText == "Unauthorized") {
                bootbox.alert({
                    message: "Usuario no autorizado para acceder a este Módulo",
                    size: 'middle'
                });
            }
            if (error.status == 403 && error.statusText == "Forbidden") {
                bootbox.alert({
                    message: "Está intentando utilizar un APIKEY inválido",
                    size: 'middle'
                });
            }
            if (error.status == 500 && error.statusText == "Internal Server Error") {
                bootbox.alert({
                    message: "Ha ocurrido una falla en el Servidor, intente más tarde",
                    size: 'middle'
                });
            }
        });
    }
    scope.agregar_controlador = function(index, id, datos) {
        if (scope.Nivel == 3) {
            Swal.fire({ title: "Usuario no Autorizado", text: "No tiene permisos para realizar esta operación", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        var ObjControladores = new Object();
        scope.select_controller[id] = datos;
        if (scope.fdatos.detalle == undefined || scope.fdatos.detalle == false) {
            scope.fdatos.detalle = [];
        }
        scope.fdatos.detalle.push({ id: datos.id, controller: datos.controller });
        //console.log(scope.fdatos.detalle);
    }
    scope.quitar_controlador = function(index, id, datos) {
        if (scope.Nivel == 3) {
            Swal.fire({ title: "Usuario no Autorizado", text: "No tiene permisos para realizar esta operación", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        scope.select_controller[id] = false;
        i = 0;
        for (var i = 0; i < scope.fdatos.detalle.length; i++) {
            if (scope.fdatos.detalle[i].id == id) {
                scope.fdatos.detalle.splice(i, 1);
            }
        }
        //console.log(scope.fdatos.detalle);
    };


    if (scope.nID != undefined) {
        scope.buscarXID();
    }

}