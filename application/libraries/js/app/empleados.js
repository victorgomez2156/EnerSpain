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

    scope.NomComp=true;
    scope.correo_electronico=true;
    scope.nivel=true;
    scope.fecha_registro=true;
    scope.bloqueado=true;
    scope.AccUser=true;
    scope.ruta_reportes_pdf_Usuarios = 0;
    scope.ruta_reportes_excel_Usuarios =0;
    
    $scope.submitForm = function(event)
    {
        console.log(scope.fdatos);
        if(scope.fdatos.id==undefined||scope.fdatos.id==null||scope.fdatos.id=='')
        {
            scope.title="Guardando";
            scope.text="¿Seguro que desea crear el Usuario?";
            scope.response = "Usuario creado correctamente";
        }
        else
        {
            scope.title="Actualizando";
            scope.text="¿Seguro que desea modificar el Usuario?";
            scope.response = "Usuario modificado correctamente";
        }
        Swal.fire({
            title:scope.title,
            text:scope.text,
            type: "question",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: "Continuar"
        }).then(function(t){
        if (t.value == true)
        { 
            scope.guardar();
        }else 
        {
            console.log('Cancelando ando...');
        }}); 
    };
    scope.regresar=function()
    {
        if(scope.fdatos.id==undefined||scope.fdatos.id==null||scope.fdatos.id=='')
        {
            var title="Regresar";
            var text="¿Estas seguro de regresar y no grabar el usuario?";
        }
        else
        {
            var title="Regresar";
            var text="¿Estas seguro de regresar y no modificar el usuario?";
        }
        Swal.fire({
            title:title,
            text:text,
            type: "question",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: "Continuar"
        }).then(function(t){
        if (t.value == true)
        { 
            location.href="#/Usuarios";
        }else 
        {
            console.log('Cancelando ando...');
        }});

    }
    scope.generar_key = function() {
        
        scope.disabled_button = false;
        $("#generar_key").removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url = base_urlHome() + "api/Usuarios/newApiKey/";
        $http.get(url).then(function(result){
            if (result.data != false) {
                console.log(result.data);
                $("#generar_key").removeClass("loader loader-default is-active").addClass("loader loader-default");
                scope.fdatos.key = result.data;
                scope.disabled_button = true;
            } else {
                $("#generar_key").removeClass("loader loader-default is-active").addClass("loader loader-default");
                Swal.fire({ title: "Error", text: "Ha ocurrido un error intentando generar el key, intente nuevamente", type: "error", confirmButtonColor: "#188ae2" });
                scope.disabled_button = false;
            }

        }, function(error) {
            $("#generar_key").removeClass("loader loader-default is-active").addClass("loader loader-default");
             if (error.status == 404 && error.statusText == "Not Found") {
                Swal.fire({ title: "Error General", text: "El método que esté intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 401 && error.statusText == "Unauthorized") {
                Swal.fire({ title: "Error de Privilegios", text: "Usuario no autorizado para acceder a este Módulo", type: "info", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 403 && error.statusText == "Forbidden") {
                Swal.fire({ title: "Error de Seguridad", text: "Está intentando utilizar un APIKEY inválido", type: "question", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 500 && error.statusText == "Internal Server Error") {
                Swal.fire({ title: "Error de Servidor", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
            }
        });
    }
    scope.guardar = function(){        
        $("#"+scope.title).removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url = base_urlHome() + "api/Usuarios/crear_usuario/";
        $http.post(url, scope.fdatos).then(function(result) {
            scope.nID = result.data.id;
            if (scope.nID > 0) {
                console.log(result.data);
                $("#"+scope.title).removeClass("loader loader-default is-active").addClass("loader loader-default");
               Swal.fire({ title: scope.response, type: "success", confirmButtonColor: "#188ae2" });                
                location.href="#/Editar_Usuarios/"+scope.nID;
                //scope.buscarXID();
            } else {
                $("#"+scope.title).removeClass("loader loader-default is-active").addClass("loader loader-default");
                Swal.fire({ title: 'Ha ocurrido un error intentando grabar el Usuario, por favor intente nuevamente', type: "success", confirmButtonColor: "#188ae2" });
               
            }
        }, function(error) {
             $("#"+scope.title).removeClass("loader loader-default is-active").addClass("loader loader-default");
             if (error.status == 404 && error.statusText == "Not Found") {
                Swal.fire({ title: "Error General", text: "El método que esté intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 401 && error.statusText == "Unauthorized") {
                Swal.fire({ title: "Error de Privilegios", text: "Usuario no autorizado para acceder a este Módulo", type: "info", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 403 && error.statusText == "Forbidden") {
                Swal.fire({ title: "Error de Seguridad", text: "Está intentando utilizar un APIKEY inválido", type: "question", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 500 && error.statusText == "Internal Server Error") {
                Swal.fire({ title: "Error de Servidor", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
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
                scope.TempleadosBack = result.data;
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
                 Swal.fire({text: "No existen Empleados registrados", type: "info", confirmButtonColor: "#188ae2" });               
                scope.Templeados = [];
            }
        }, function(error) {
            $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
             if (error.status == 404 && error.statusText == "Not Found") {
                Swal.fire({ title: "Error General", text: "El método que esté intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 401 && error.statusText == "Unauthorized") {
                Swal.fire({ title: "Error de Privilegios", text: "Usuario no autorizado para acceder a este Módulo", type: "info", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 403 && error.statusText == "Forbidden") {
                Swal.fire({ title: "Error de Seguridad", text: "Está intentando utilizar un APIKEY inválido", type: "question", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 500 && error.statusText == "Internal Server Error") {
                Swal.fire({ title: "Error de Servidor", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
            }
           
        });
    }
    scope.buscarXID = function() {
        $("#cargando").removeClass("loader loader-default").addClass("loader loader-default  is-active");
        var url = base_urlHome() + "api/Usuarios/buscar_xID/huser/" + scope.nID;
        $http.get(url).then(function(result) {
            $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (result.data != false) {
                
                scope.fdatos = result.data;

                angular.forEach(result.data.detalle, function(controllers) {
                    scope.select_controller[controllers.id] = controllers;
                });
            } else {               
                Swal.fire({ title: "Error General", text: "Hubo un error al intentar cargar los datos.", type: "error", confirmButtonColor: "#188ae2" });
            }
        }, function(error) {
            $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
             if (error.status == 404 && error.statusText == "Not Found") {
                Swal.fire({ title: "Error General", text: "El método que esté intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 401 && error.statusText == "Unauthorized") {
                Swal.fire({ title: "Error de Privilegios", text: "Usuario no autorizado para acceder a este Módulo", type: "info", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 403 && error.statusText == "Forbidden") {
                Swal.fire({ title: "Error de Seguridad", text: "Está intentando utilizar un APIKEY inválido", type: "question", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 500 && error.statusText == "Internal Server Error") {
                Swal.fire({ title: "Error de Servidor", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
            }
        });
    }
    scope.limpiar = function() {
        scope.fdatos = {};
        scope.select_controller = [];
        location.href="#/Agregar_Usuarios";
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
                Swal.fire({ title: "Error General", text: "El método que esté intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 401 && error.statusText == "Unauthorized") {
                Swal.fire({ title: "Error de Privilegios", text: "Usuario no autorizado para acceder a este Módulo", type: "info", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 403 && error.statusText == "Forbidden") {
                Swal.fire({ title: "Error de Seguridad", text: "Está intentando utilizar un APIKEY inválido", type: "question", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 500 && error.statusText == "Internal Server Error") {
                Swal.fire({ title: "Error de Servidor", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
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
                Swal.fire({ title: "Error General", text: "El método que esté intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 401 && error.statusText == "Unauthorized") {
                Swal.fire({ title: "Error de Privilegios", text: "Usuario no autorizado para acceder a este Módulo", type: "info", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 403 && error.statusText == "Forbidden") {
                Swal.fire({ title: "Error de Seguridad", text: "Está intentando utilizar un APIKEY inválido", type: "question", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 500 && error.statusText == "Internal Server Error") {
                Swal.fire({ title: "Error de Servidor", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
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
                Swal.fire({ title: "Error General", text: "El método que esté intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 401 && error.statusText == "Unauthorized") {
                Swal.fire({ title: "Error de Privilegios", text: "Usuario no autorizado para acceder a este Módulo", type: "info", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 403 && error.statusText == "Forbidden") {
                Swal.fire({ title: "Error de Seguridad", text: "Está intentando utilizar un APIKEY inválido", type: "question", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 500 && error.statusText == "Internal Server Error") {
                Swal.fire({ title: "Error de Servidor", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
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
    scope.FetchUsuarios=function()
     {
        if(scope.filter_search==undefined||scope.filter_search==null||scope.filter_search=='')
        {
            $scope.predicate = 'id';
            $scope.reverse = true;
            $scope.currentPage = 1;
            $scope.order = function(predicate) {
                $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                $scope.predicate = predicate;
            };            
            scope.Templeados = scope.TempleadosBack;
            $scope.totalItems = scope.Templeados.length;
            $scope.numPerPage = 50;
            $scope.paginate = function(value) {
                var begin, end, index;
                begin= ($scope.currentPage - 1) * $scope.numPerPage;
                end = begin + $scope.numPerPage;
                index = scope.Templeados.indexOf(value);
                return (begin <= index && index < end);
            }    

            scope.ruta_reportes_pdf_Usuarios = 0;
            scope.ruta_reportes_excel_Usuarios =0;
        }
        else
        {
            if(scope.filter_search.length>=2)
            {
                scope.fdatos.filter_search=scope.filter_search;   
                var url = base_urlHome()+"api/Usuarios/getUsuariosFilter";
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
                        scope.Templeados = result.data;
                        $scope.totalItems = scope.Templeados.length;
                        $scope.numPerPage = 50;
                        $scope.paginate = function(value) {
                            var begin, end, index;
                            begin= ($scope.currentPage - 1) * $scope.numPerPage;
                            end = begin + $scope.numPerPage;
                            index = scope.Templeados.indexOf(value);
                            return (begin <= index && index < end);
                        }
                        scope.ruta_reportes_pdf_Usuarios = 1 + "/" + scope.filter_search;
                        scope.ruta_reportes_excel_Usuarios = 1 + "/" + scope.filter_search;
                    }
                    else
                    {
                        Swal.fire({ title: "Error", text: "No existen Usuarios registrados", type: "error", confirmButtonColor: "#188ae2" });                    
                        scope.Templeados=[];
                        scope.ruta_reportes_pdf_Usuarios = 0;
                        scope.ruta_reportes_excel_Usuarios =0;
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


    if (scope.nID != undefined) {
        scope.buscarXID();
    }

}