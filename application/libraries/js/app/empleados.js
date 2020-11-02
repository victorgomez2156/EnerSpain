app.controller('Controlador_Empleados', ['$http', '$scope', '$filter', '$route', '$interval', '$controller', '$cookies', Controlador]);

function Controlador($http, $scope, $filter, $route, $interval, $controller, $cookies) {
    //declaramos una variable llamada scope donde tendremos a vm
    /*inyectamos un controlador para acceder a sus variables y metodos*/
    //$controller('ControladorArticuloExistencia as vmAE',{$scope:$scope});			
    var scope = this;
    scope.fdatos = {}; // datos del formulario
    scope.fdatos.detalle = [];
    scope.fdatos.detalle_menu = [];
    scope.nID = $route.current.params.ID; //contiene el id del registro en caso de estarse consultando desde la grid
    scope.Nivel = $cookies.get('nivel');
    scope.Templeados = [];
    scope.TempleadosBack = [];
    scope.select_controller = [];
    scope.controladores_seleccionados = [];
    scope.t_Menu=[];
    scope.select_menu=[];
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
    scope.cargar_menu=function()
    {
        var url=base_urlHome()+"api/Usuarios/cargar_menu_users/";
        $http.get(url).then(function(result)
        {
            if(result.data!=false)
            {
                    scope.t_Menu=result.data;
            }
            else
            {
                scope.toast('error','no se encontraron menu para asignar','Error');
                scope.t_Menu=[];
                scope.select_menu=[];
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
                scope.toast('error','Ha ocurrido un error intentando generar el key, intente nuevamente','Error');
                scope.disabled_button = false;
            }

        }, function(error) {
            $("#generar_key").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
    scope.guardar = function(){        
        $("#"+scope.title).removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url = base_urlHome() + "api/Usuarios/crear_usuario/";
        $http.post(url, scope.fdatos).then(function(result) {
            scope.nID = result.data.id;
            if (scope.nID > 0) {
                console.log(result.data);
                $("#"+scope.title).removeClass("loader loader-default is-active").addClass("loader loader-default");
                scope.toast('success',scope.response,'');                
                location.href="#/Editar_Usuarios/"+scope.nID;
                //scope.buscarXID();
            } else {
                $("#"+scope.title).removeClass("loader loader-default is-active").addClass("loader loader-default");
                scope.toast('error','Ha ocurrido un error intentando grabar el Usuario, por favor intente nuevamente','');
               
            }
        }, function(error) {
             $("#"+scope.title).removeClass("loader loader-default is-active").addClass("loader loader-default");
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
                scope.Templeados = [];
            }
        }, function(error) {
            $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
    scope.buscarXID = function() {
        $("#cargando").removeClass("loader loader-default").addClass("loader loader-default  is-active");
        var url = base_urlHome() + "api/Usuarios/buscar_xID/huser/" + scope.nID;
        $http.get(url).then(function(result) {
            $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (result.data != false) {
                
                scope.fdatos = result.data;
                angular.forEach(result.data.detalle, function(controllers){
                    scope.select_controller[controllers.id] = controllers;
                });
                 angular.forEach(result.data.detalle_menu, function(menu){
                    scope.select_menu[menu.CodMenuAsi] = menu;
                });
            } else {               
                scope.toast('error','Hubo un error al intentar cargar los datos.','Error General');
            }
        }, function(error) {
            $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
    scope.agregar_controlador = function(index, id, datos) {
        if (scope.Nivel == 3) {
            scope.toast('error','No tiene permisos para realizar esta operación','Usuario no Autorizado');
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
            scope.toast('error','No tiene permisos para realizar esta operación','Usuario no Autorizado');
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
    scope.agregar_menu = function(index, id, datos) {
        if (scope.Nivel == 3) {
            scope.toast('error','No tiene permisos para realizar esta operación','Usuario no Autorizado');
            return false;
        }
        var ObjMenu = new Object();
        scope.select_menu[id] = datos;
        if (scope.fdatos.detalle_menu == undefined || scope.fdatos.detalle_menu == false) {
            scope.fdatos.detalle_menu = [];
        }
        scope.fdatos.detalle_menu.push({ CodMenuAsi: datos.id, opcion: datos.titulo});
        console.log(scope.fdatos.detalle_menu);       
    }
    scope.quitar_menu = function(index, id, datos) {
        if (scope.Nivel == 3) {
            scope.toast('error','No tiene permisos para realizar esta operación','Usuario no Autorizado');
            return false;
        }
        scope.select_menu[id] = false;
        i = 0;
        for (var i = 0; i < scope.fdatos.detalle_menu.length; i++) {
            if (scope.fdatos.detalle_menu[i].CodMenuAsi == id) {
                scope.fdatos.detalle_menu.splice(i, 1);
            }
        }
        console.log(scope.fdatos.detalle_menu);
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
                        scope.Templeados=[];
                        scope.ruta_reportes_pdf_Usuarios = 0;
                        scope.ruta_reportes_excel_Usuarios =0;
                    }
                }, function(error)
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
        }     
     }
    scope.CambiarContrasena=function()
    {
        $('#modal_contrasena').modal('show');
        scope.fcontrasena={};
        scope.fcontrasena.id=scope.fdatos.id;
    }
    $scope.SubmitFormChangePassword = function(event)
    {
        console.log(scope.fcontrasena);
        
        if (!scope.validar_campos_ConfirmarContrasena()) {
            return false;
        }
        Swal.fire({
            title:'Cambio de Contraseña',
            text:'¿Estás seguro de cambiar la contraseña del usuario?',
            type: "question",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: "Confirmar"
        }).then(function(t){
        if (t.value == true)
        { 
           $("#Actualizando").removeClass("loader loader-default").addClass("loader loader-default is-active");
           var url=base_urlHome()+"api/Usuarios/ChangePassword/";
           $http.post(url,scope.fcontrasena).then(function(result)
           {
                $("#Actualizando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                if(result.data!=false)
                {
                    scope.toast('success','Contraseña actualizada correctamente','Contraseña');
                    $('#modal_contrasena').modal('hide');
                    scope.fcontrasena={};
                }
                else
                {
                    scope.toast('error','Ha ocurrido un error durante el cambio de la contraseña por favor intente nuevamente.','Error');
                }

           },function(error)
           {
                $("#Actualizando").removeClass("loader loader-default is-active").addClass("loader loader-default");
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


           //scope.toast('success','si','Prueba');
        }else 
        {
            console.log('Cancelando ando...');
        }}); 
    };
    scope.validar_campos_ConfirmarContrasena = function() {
        resultado = true;       
        
        
        if (scope.fcontrasena.newpassword == null || scope.fcontrasena.newpassword == undefined || scope.fcontrasena.newpassword == '') {
            scope.toast('error','EL campo nueva contraseña es requerido.','Nueva Contraseña');
            return false;
        }
        if (scope.fcontrasena.repassword == null || scope.fcontrasena.repassword == undefined || scope.fcontrasena.repassword == '') {
            scope.toast('error','EL campo confirmar contraseña es requerido.','Confirmar Contraseña');
            return false;
        }
        if (resultado == false) {
            //quiere decir que al menos un renglon no paso la validacion
            return false;
        }
        if(scope.fcontrasena.newpassword!=scope.fcontrasena.repassword)
        {
            scope.toast('error','Las contraseña no coinciden..','Contraseña Incorrecta');
            return false; 
        }
        return true;
    }
     scope.showDetails = function(menu) {
         if (menu == 1) {
             if (scope.showAsigMenu == true) {
                 scope.showAsigMenu = false;
             } else {
                 scope.showAsigMenu = true;
             }
         }
         else if (menu == 2) {
             if (scope.showAsigControllers == true) {
                 scope.showAsigControllers = false;
             } else {
                 scope.showAsigControllers = true;
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
            var $timeOut = 1000;
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
        scope.buscarXID();
    }

}