app.controller('Datos_Basicos_Comercializadora', ['$http', '$scope', '$filter', '$route', '$interval', '$controller', '$cookies', 'ServiceComercializadora', 'upload', Controlador])
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

    //////////////////////////////////////////////////////////// DATOS BASICOS DE COMERCIALIZADORAS START //////////////////////////////////////////////////////////
    var scope = this;
    scope.fdatos = {}; // datos del formulario
    scope.nID = $route.current.params.ID; //contiene el id del registro en caso de estarse consultando desde la grid
    scope.INF = $route.current.params.INF;
    scope.CIF_COM = $cookies.get('CIF_COM');
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
    scope.fdatos.misma_razon = false;
    const $archivos = document.querySelector("#file");
    scope.TProvincias = [];
    scope.tLocalidades = [];
    scope.tTiposVias = [];
    scope.myDate = new Date();
    scope.isOpen = false;
    console.log($route.current.$$route.originalPath);
    ServiceComercializadora.getAll().then(function(dato) {
        scope.TProvincias = dato.Provincias;
        scope.tLocalidades = dato.Localidades;
        scope.tTiposVias = dato.Tipos_Vias;
        scope.fecha_server = dato.fecha;
        if ($route.current.$$route.originalPath == "/Datos_Basicos_Comercializadora/") {
            scope.FecIniCom = scope.fecha_server;
            console.log(scope.FecIniCom);
            $('.datepicker').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.FecIniCom);
        }
        //scope.FecIniCom=scope.fecha_server;
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
    if ($route.current.$$route.originalPath == "/Datos_Basicos_Comercializadora/") {
        if (scope.CIF_COM == undefined) { //
            location.href = "#/Comercializadora";
            $("#btn_modal_cif_com").removeClass("btn btn-info").addClass("btn btn-danger");
        } else {
            scope.fdatos.NumCifCom = scope.CIF_COM;
            scope.fdatos.RenAutConCom = false;
            scope.fdatos.SerEle = false;
            scope.fdatos.SerGas = false;
            scope.fdatos.SerEsp = false;
            scope.FecIniCom = scope.fecha_server;
            console.log(scope.FecIniCom);
        }
    }
    if ($route.current.$$route.originalPath == "/Datos_Basicos_Comercializadora/:ID"); {
        scope.validate_info = scope.INF;
    }
    if ($route.current.$$route.originalPath == "/Datos_Basicos_Comercializadora/:ID/:INF"); {
        scope.validate_info = scope.INF;
    }
    console.log(scope.validate_info);

    scope.validar_fecha = function(metodo, object) {
        if (metodo == 1) {
            if (object != undefined) {
                numero = object;
                if (!/^([/0-9])*$/.test(numero))
                    scope.FecConCom = numero.substring(0, numero.length - 1);
            }
        }
        if (metodo == 2) {
            if (object != undefined) {
                numero = object;
                if (!/^([/0-9])*$/.test(numero))
                    scope.FecVenConCom = numero.substring(0, numero.length - 1);
            }
        }
        if (metodo == 3) {
            if (object != undefined) {
                numero = object;
                if (!/^([/0-9])*$/.test(numero))
                    scope.FecIniCom = numero.substring(0, numero.length - 1);
            }
        }
        if (metodo == 4) {
            if (object != undefined) {
                numero = object;
                if (!/^([0-9])*$/.test(numero))
                    scope.fdatos.NumViaDirCom = numero.substring(0, numero.length - 1);
            }
        }
        if (metodo == 5) {
            if (object != undefined) {
                numero = object;
                if (!/^([+0-9])*$/.test(numero))
                    scope.fdatos.TelFijCom = numero.substring(0, numero.length - 1);
            }
        }
    }
    scope.calcular_anos = function() {

        var FecConCom = document.getElementById("FecConCom").value;
        scope.FecConCom = FecConCom;

        var FecVenConCom = document.getElementById("FecVenConCom").value;
        scope.FecVenConCom = FecVenConCom;

        if (scope.FecConCom != undefined && scope.FecVenConCom != undefined) {
            if (new Date(scope.FecVenConCom) < new Date(scope.FecConCom)) {
                scope.toast('error','Error en fechas','Fecha de Contrato');

                scope.fdatos.DurConCom = undefined;
                scope.FecVenConCom = undefined;
                return false;
            }
            var hora3 = (scope.FecVenConCom).split("/"),
                hora4 = (scope.FecConCom).split("/"),
                t3 = new Date(),
                t4 = new Date();
            t3.setHours(hora3[2], hora3[1], hora3[0]);
            t4.setHours(hora4[2], hora4[1], hora4[0]);
            t3.setHours(t3.getHours() - t4.getHours(), t3.getMinutes() - t4.getMinutes(), t3.getSeconds() - t4.getSeconds());
            scope.fdatos.DurConCom = (t3.getHours());
            //console.log(scope.fdatos.DurConCom);
            if (scope.fdatos.DurConCom == 0) {
                scope.toast('error','El tiempo mínimo del contrato debe ser de 1 año en adelante.','');
                scope.FecVenConCom = undefined;
                scope.fdatos.DurConCom = undefined;
                scope.disabled_button = 1;
            } else {
                scope.disabled_button = 0;
            }
        }
    }
    scope.asignar_a_nombre_comercial = function() {
        if (scope.fdatos.RazSocCom != undefined || scope.fdatos.RazSocCom != null || scope.fdatos.RazSocCom != '') {
            scope.fdatos.NomComCom = scope.fdatos.RazSocCom;
        }
    }
    
    scope.SearchLocalidades=function()
    {
        scope.TLocalidadesfiltrada=[];
        var url = base_urlHome()+"api/Comercializadora/getLocalidadSearch/CodPro/"+scope.fdatos.CodPro;
        $http.get(url).then(function(result)
        {
            if(result.data!=false)
            {
                scope.TLocalidadesfiltrada =result.data;
            }
            else
            {
                scope.toast('error','Esta Provincia no tiene localidades asignadas.','');
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

    scope.filtrarLocalidadCom = function() {
        scope.TLocalidadesfiltrada = $filter('filter')(scope.tLocalidades, { CodPro: scope.fdatos.CodPro }, true);
        if ($route.current.$$route.originalPath == "/Datos_Basicos_Comercializadora/:ID/:INF" || $route.current.$$route.originalPath == "/Datos_Basicos_Comercializadora/:ID") {
            scope.contador = 0;
            scope.contador = scope.contador + 1;
        }
        console.log('para ver si se ejecuta cada 5 segundos?');
        console.log(scope.contador);
        if (scope.contador == 1) {
            $interval.cancel(promise);
        }
    }
    scope.filtrar_zona_postal = function() {
        scope.CodLocZonaPostal = $filter('filter')(scope.tLocalidades, { CodLoc: scope.fdatos.CodLoc }, true);
        angular.forEach(scope.CodLocZonaPostal, function(data) {
            scope.fdatos.ZonPos = data.CPLoc;
        });

    }

    $scope.submitForm = function(event) {
        console.log(scope);
        if (scope.fdatos.CodCom == undefined) {
            var titulo = 'Guardando';
            var texto = '¿Seguro que desea registrar la Comercializadora?';
            var response = 'Comercializadora registrada de forma correcta';
        } else {
            var titulo = 'Actualizando';
            var texto = '¿Seguro que desea actualizar la información de la Comercializadora?';
            var response = 'Comercializadora modificada de forma correcta';
        }
        if (!scope.validar_campos_datos_basicos()) {
            return false;
        }
        scope.calcular_anos();
        let archivos = $archivos.files;
        if ($archivos.files.length > 0) {
            console.log($archivos.files);
            if ($archivos.files[0].type == "application/pdf") //|| $archivos.files[0].type=="image/jpeg" || $archivos.files[0].type=="image/png")
            {
                console.log('Fichero Permitido');
                var tipo_file = ($archivos.files[0].type).split("/");
                $archivos.files[0].type;
                console.log(tipo_file[1]);
                $scope.uploadFile();
                scope.fdatos.DocConCom = 'documentos/' + $archivos.files[0].name;
            } else {
                console.log('Fichero No Permitido');
                scope.toast('error','Formato de fichero incorrecto, debe ser PDF.','');
                document.getElementById('file').value = '';
                return false;
            }
        }
        scope.validar_campos_nulos();
        console.log(scope.fdatos);
        Swal.fire({
            title: titulo,
            text: texto,
            type: "question",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: "Confirmar!"
        }).then(function(t) {
            if (t.value == true) {
                $("#" + titulo).removeClass("loader loader-default").addClass("loader loader-default is-active");
                var url = base_urlHome() + "api/Comercializadora/registrar_comercializadora/";
                $http.post(url, scope.fdatos).then(function(result) {
                    scope.nID = result.data.CodCom;
                    if (result.data != false) {
                        $("#" + titulo).removeClass("loader loader-default is-active").addClass("loader loader-default");
                        scope.toast('success',response,titulo);
                        document.getElementById('file').value = '';
                        $('#filenameDocCont').html('');
                        $cookies.remove('CIF_COM');
                        location.href = "#/Datos_Basicos_Comercializadora/" + scope.nID;
                        //scope.fdatos=result.data;"/Datos_Basicos_Comercializadora
                    } else {
                        $("#" + titulo).removeClass("loader loader-default is-active").addClass("loader loader-default");
                        scope.toast('error',"Error durante el proceso, Por Favor Intente nuevamente.",titulo);
                    }

                }, function(error) {
                    $("#" + titulo).removeClass("loader loader-default is-active").addClass("loader loader-default");
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
    scope.validar_campos_datos_basicos = function() {
        resultado = true;
        var FecIniCom = document.getElementById("FecIniCom").value;
        scope.FecIniCom = FecIniCom;
        if (scope.FecIniCom == null || scope.FecIniCom == undefined || scope.FecIniCom == '') {
            scope.toast('error',"La fecha de inicio es requerida.",'');
            return false;
        } else {
            var FecIniCom = (scope.FecIniCom).split("/");
            if (FecIniCom.length < 3) {
                scope.toast('error',"El formato Fecha de Inicio correcto es DD/MM/YYYY.",'');
                event.preventDefault();
                return false;
            } else {
                if (FecIniCom[0].length > 2 || FecIniCom[0].length < 2) {
                    scope.toast('error',"Error en Día, debe introducir dos números.",'');
                    event.preventDefault();
                    return false;

                }
                if (FecIniCom[1].length > 2 || FecIniCom[1].length < 2) {
                    scope.toast('error',"Error en Mes, debe introducir dos números.",'');
                    event.preventDefault();
                    return false;
                }
                if (FecIniCom[2].length < 4 || FecIniCom[2].length > 4) {
                    scope.toast('error',"Error en Año, debe introducir cuatro números.",'');
                    event.preventDefault();
                    return false;
                }
                valuesStart = scope.FecIniCom.split("/");
                valuesEnd = scope.fecha_server.split("/");
                // Verificamos que la fecha no sea posterior a la actual
                var dateStart = new Date(valuesStart[2], (valuesStart[1] - 1), valuesStart[0]);
                var dateEnd = new Date(valuesEnd[2], (valuesEnd[1] - 1), valuesEnd[0]);
                if (dateStart > dateEnd) {
                    scope.toast('error','La Fecha de Inicio no puede ser mayor al ' + scope.fecha_server + 'Verifique e intente nuevamente','');
                    return false;
                }
                scope.fdatos.FecIniCom = valuesStart[2] + "/" + valuesStart[1] + "/" + valuesStart[0];
            }
        }
        if (scope.fdatos.RazSocCom == null || scope.fdatos.RazSocCom == undefined || scope.fdatos.RazSocCom == '') {
            scope.toast('error',"Debe indicar la Razón Social.",'');
            return false;
        }
        if (scope.fdatos.NomComCom == null || scope.fdatos.NomComCom == undefined || scope.fdatos.NomComCom == '') {
            scope.toast('error',"El nombre de la comercializadora es requerido.",'');
            return false;
        }
        if (!scope.fdatos.CodTipVia > 0) {
            scope.toast('error',"Debe seleccionar un tipo de vía.",'');
            return false;
        }
        if (scope.fdatos.NomViaDirCom == null || scope.fdatos.NomViaDirCom == undefined || scope.fdatos.NomViaDirCom == '') {
            scope.toast('error',"El nombre de la vía es requerido.",'');
            return false;
        }
        if (scope.fdatos.NumViaDirCom == null || scope.fdatos.NumViaDirCom == undefined || scope.fdatos.NumViaDirCom == '') {
            scope.toast('error',"El numero de vía es requerido.",'');
            return false;
        }
        if (!scope.fdatos.CodPro > 0) {
            scope.toast('error',"Debe seleccionar un Provincia.",'');
            return false;
        }
        if (!scope.fdatos.CodLoc > 0) {
            scope.toast('error',"Debe seleccionar una localidad.",'');
            return false;
        }
        if (scope.fdatos.TelFijCom == null || scope.fdatos.TelFijCom == undefined || scope.fdatos.TelFijCom == '') {
            scope.toast('error',"Debe indicar un número de teléfono fijo.",'');
            return false;
        }
        if (scope.fdatos.EmaCom == null || scope.fdatos.EmaCom == undefined || scope.fdatos.EmaCom == '') {
            scope.toast('error',"El email es requerido.",'');
            return false;
        }
        if (scope.fdatos.NomConCom == null || scope.fdatos.NomConCom == undefined || scope.fdatos.NomConCom == '') {
            scope.toast('error',"el campo persona de contacto es requerido.",'');
            return false;
        }
        if (scope.fdatos.CarConCom == null || scope.fdatos.CarConCom == undefined || scope.fdatos.CarConCom == '') {
            scope.toast('error',"Debe indicar el cargo de la persona de contacto.",'');
           return false;
        }
        var FecConCom1 = document.getElementById("FecConCom").value;
        scope.FecConCom = FecConCom1;
        if (scope.FecConCom == undefined || scope.FecConCom == null || scope.FecConCom == '') {
            scope.fdatos.FecConCom = null;
        } else {
            var FecConCom = (scope.FecConCom).split("/");
            console.log(FecConCom);
            if (FecConCom.length < 3) {
                scope.toast('error',"Error en formato de la fecha de contrato.",'');
                return false;
            } else {
                if (FecConCom[0].length > 2 || FecConCom[0].length < 2) {
                    scope.toast('error',"El formato del dia es incorrecto.",'');
                    return false;

                }
                if (FecConCom[1].length > 2 || FecConCom[1].length < 2) {
                    scope.toast('error',"El formato del mes es incorrecto.",'');
                    return false;
                }
                if (FecConCom[2].length < 4 || FecConCom[2].length > 4) {
                    scope.toast('error',"EL formato del año es incorrecto.",'');
                    return false;
                }
                var h1 = new Date();
                var final2 = FecConCom[2] + "/" + FecConCom[1] + "/" + FecConCom[0];
                scope.fdatos.FecConCom = final2;
            }
        }
        var FecVenConCom1 = document.getElementById("FecVenConCom").value;
        scope.FecVenConCom = FecVenConCom1;
        if (scope.FecVenConCom == undefined || scope.FecVenConCom == null || scope.FecVenConCom == '') {
            scope.fdatos.FecVenConCom = null;
        } else {
            var FecVenConCom = (scope.FecVenConCom).split("/");
            if (FecVenConCom.length < 3) {
                scope.toast('error',"Error en la fecha de vencimiento.",'');
                return false;
            } else {
                if (FecVenConCom[0].length > 2 || FecVenConCom[0].length < 2) {
                    scope.toast('error',"el formato del dia es incorrecto.",'');
                    return false;

                }
                if (FecVenConCom[1].length > 2 || FecVenConCom[1].length < 2) {
                    scope.toast('error',"el formato del mes es incorrecto.",'');
                    return false;
                }
                if (FecVenConCom[2].length < 4 || FecVenConCom[2].length > 4) {
                    scope.toast('error',"el formato del año es incorrecto.",'');
                    return false;
                }
                var h1 = new Date();
                var final1 = FecVenConCom[2] + "/" + FecVenConCom[1] + "/" + FecVenConCom[0];
                scope.fdatos.FecVenConCom = final1;
            }
        }
        if (resultado == false) {
            return false;
        }
        return true;
    }
    scope.validar_campos_nulos = function() {
        if (scope.fdatos.BloDirCom == undefined || scope.fdatos.BloDirCom == null || scope.fdatos.BloDirCom == '') {
            scope.fdatos.BloDirCom = null;
        } else {
            scope.fdatos.BloDirCom = scope.fdatos.BloDirCom;
        }
        if (scope.fdatos.EscDirCom == undefined || scope.fdatos.EscDirCom == null || scope.fdatos.EscDirCom == '') {
            scope.fdatos.EscDirCom = null;
        } else {
            scope.fdatos.EscDirCom = scope.fdatos.EscDirCom;
        }
        if (scope.fdatos.PlaDirCom == undefined || scope.fdatos.PlaDirCom == null || scope.fdatos.PlaDirCom == '') {
            scope.fdatos.PlaDirCom = null;
        } else {
            scope.fdatos.PlaDirCom = scope.fdatos.PlaDirCom;
        }
        if (scope.fdatos.PueDirCom == undefined || scope.fdatos.PueDirCom == null || scope.fdatos.PueDirCom == '') {
            scope.fdatos.PueDirCom = null;
        } else {
            scope.fdatos.PueDirCom = scope.fdatos.PueDirCom;
        }

        if (scope.fdatos.DurConCom == undefined || scope.fdatos.DurConCom == null || scope.fdatos.DurConCom == '') {
            scope.fdatos.DurConCom = null;
        } else {
            scope.fdatos.DurConCom = scope.fdatos.DurConCom;
        }

        if (scope.fdatos.ObsCom == undefined || scope.fdatos.ObsCom == null || scope.fdatos.ObsCom == '') {
            scope.fdatos.ObsCom = null;
        } else {
            scope.fdatos.ObsCom = scope.fdatos.ObsCom;
        }
        if (scope.fdatos.PagWebCom == undefined || scope.fdatos.PagWebCom == null || scope.fdatos.PagWebCom == '') {
            scope.fdatos.PagWebCom = null;
        } else {
            scope.fdatos.PagWebCom = scope.fdatos.PagWebCom;
        }
        if (scope.fdatos.DocConCom == undefined || scope.fdatos.DocConCom == null || scope.fdatos.DocConCom == '') {
            scope.fdatos.DocConCom = null;
        } else {
            scope.fdatos.DocConCom = scope.fdatos.DocConCom;
        }
        if (scope.fdatos.ZonPos == undefined || scope.fdatos.ZonPos == null || scope.fdatos.ZonPos == '') {
            scope.fdatos.ZonPos = null;
        } else {
            scope.fdatos.ZonPos = scope.fdatos.ZonPos;
        }
        if(scope.fdatos.FecConCom==null && scope.fdatos.FecVenConCom==null)
        {
            scope.fdatos.DurConCom=null;
        }
    }
    $scope.uploadFile = function() {
        var file = $scope.file;
        upload.uploadFile(file, name).then(function(res) {
            console.log(res);
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
    scope.regresar = function() {

        if (scope.INF == undefined) {
            if (scope.fdatos.CodCom == undefined) {
                var title = 'Guardando';
                var text = '¿Seguro que desea cerrar sin registrar la Comercializadora?';
            } else {
                var title = 'Actualizando';
                var text = '¿Seguro que desea cerrar sin actualizar la información de la Comercializadora?';
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
                    $cookies.remove('CIF_COM');
                    location.href = "#/Comercializadora";
                    scope.fdatos = {};
                } else {
                    console.log('Cancelando ando...');
                }
            });

        } else {
            $cookies.remove('CIF_COM');
            location.href = "#/Comercializadora";
            scope.fdatos = {};
        }
    }
    scope.buscarXID = function() 
    {
        $("#buscando").removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url = base_urlHome() + "api/Comercializadora/Buscar_xID_Comercializadora/CodCom/" + scope.nID;
        $http.get(url).then(function(result) {
            if (result.data != false) {
                $("#buscando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                scope.fdatos = result.data;
                scope.FecIniCom = result.data.FecIniCom;
                scope.FecConCom = result.data.FecConCom;
                scope.FecVenConCom = result.data.FecVenConCom;

                console.log(scope.FecIniCom);
                $('.datepicker').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.FecIniCom);
                $('.datepicker2').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.FecConCom);
                $('.datepicker3').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.FecVenConCom);

                if (result.data.RenAutConCom == 0) {
                    scope.fdatos.RenAutConCom = false;
                } else {
                    scope.fdatos.RenAutConCom = true;
                }
                if (result.data.SerEle == 1) {
                    scope.fdatos.SerEle = true;
                } else {
                    scope.fdatos.SerEle = false;
                }
                if (result.data.SerEsp == 1) {
                    scope.fdatos.SerEsp = true;
                } else {
                    scope.fdatos.SerEsp = false;
                }
                if (result.data.SerGas == 1) {
                    scope.fdatos.SerGas = true;
                } else {
                    scope.fdatos.SerGas = false;
                }
                scope.fdatos.misma_razon = false;
                scope.SearchLocalidades();
                console.log(scope.fdatos);
            } else {
                $("#buscando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                scope.toast('error',"No existen datos con el código que esta intentando buscar.",'');
                location.href = "#/Comercializadora";
            }

        }, function(error) {
            $("#buscando").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
    scope.misma_razon = function(opcion) {
        if (opcion == true) {
            scope.fdatos.NomComCom = undefined;
        } else {
            scope.fdatos.NomComCom = scope.fdatos.RazSocCom;
        }

    }
    scope.containerClicked = function() 
    {
        scope.searchResult = {};
    }
    scope.searchboxClicked = function($event) 
    {
        $event.stopPropagation();
    }
    scope.LocalidadCodigoPostal=function()
    {
        var searchText_len = scope.fdatos.ZonPos.trim().length;
        if (searchText_len >=3) 
        {
            var url= base_urlHome()+"api/Comercializadora/LocalidadCodigoPostal/CPLoc/"+scope.fdatos.ZonPos;
            $http.get(url).then(function(result) 
            {
                if (result.data != false) 
                {
                    scope.searchResult = result.data;
                } 
                else
                {
                    scope.searchResult = {};
                    scope.toast('error','No se Encontraron Provincias & Localidades Registradas con este código postal','Error');
                    scope.fdatos.ZonPos=null;
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
            scope.searchResult = {};
        }
    }
    scope.setValue = function(index, $event, result, metodo) 
    {
        if (metodo == 1) 
        {
            
        	console.log(index);
        	console.log($event);
        	console.log(result);
        	console.log(metodo);
        	scope.fdatos.CodPro=scope.searchResult[index].CodPro;
        	scope.SearchLocalidades();
        	scope.fdatos.CodLoc=scope.searchResult[index].CodLoc;
        	scope.searchResult = {};
            $event.stopPropagation();
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
    if (scope.nID != undefined) {
        scope.buscarXID();
        /*var promise = $interval(function() {
            scope.filtrarLocalidadCom();
        }, 7000);
        $scope.$on('$destroy', function() {
            $interval.cancel(promise);
        });*/
    }
    //////////////////////////////////////////////////////////// DATOS BASICOS DE COMERCIALIZADORAS END ////////////////////////////////////////////////////////////////
}