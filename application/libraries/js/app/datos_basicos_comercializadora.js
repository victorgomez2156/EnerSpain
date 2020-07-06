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
                Swal.fire({ title: "Fecha de Contrato", text: '', type: "error", confirmButtonColor: "#188ae2" });
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
                Swal.fire({ title: "Error", text: 'El tiempo mínimo del contrato debe ser de 1 año en adelante.', type: "error", confirmButtonColor: "#188ae2" });
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
                Swal.fire({ title: "Error", text: "Esta Provincia no tiene localidades asignadas.", type: "error", confirmButtonColor: "#188ae2" });
                scope.TLocalidadesfiltrada=[];
            }
        },function(error)
        {   
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
                Swal.fire({ title: 'Error', text: 'Formato de fichero incorrecto, debe ser PDF', type: "error", confirmButtonColor: "#188ae2" });
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
                        Swal.fire({ title: titulo, text: response, type: "success", confirmButtonColor: "#188ae2" });
                        document.getElementById('file').value = '';
                        $('#filenameDocCont').html('');
                        $cookies.remove('CIF_COM');
                        location.href = "#/Datos_Basicos_Comercializadora/" + scope.nID;
                        //scope.fdatos=result.data;"/Datos_Basicos_Comercializadora
                    } else {
                        $("#" + titulo).removeClass("loader loader-default is-active").addClass("loader loader-default");
                        Swal.fire({ title: "Error", text: 'Error durante el proceso, Por Favor Intente nuevamente.', type: "error", confirmButtonColor: "#188ae2" });
                    }

                }, function(error) {
                    $("#" + titulo).removeClass("loader loader-default is-active").addClass("loader loader-default");
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
    scope.validar_campos_datos_basicos = function() {
        resultado = true;
        var FecIniCom = document.getElementById("FecIniCom").value;
        scope.FecIniCom = FecIniCom;
        if (scope.FecIniCom == null || scope.FecIniCom == undefined || scope.FecIniCom == '') {
            Swal.fire({ title: 'La fecha de inicio es requerida', type: "error", confirmButtonColor: "#188ae2" });
            return false;
        } else {
            var FecIniCom = (scope.FecIniCom).split("/");
            if (FecIniCom.length < 3) {
                Swal.fire({ text: 'El formato Fecha de Inicio correcto es DD/MM/YYYY.', type: "error", confirmButtonColor: "#188ae2" });
                event.preventDefault();
                return false;
            } else {
                if (FecIniCom[0].length > 2 || FecIniCom[0].length < 2) {
                    Swal.fire({ text: 'Error en Día, debe introducir dos números', type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;

                }
                if (FecIniCom[1].length > 2 || FecIniCom[1].length < 2) {
                    Swal.fire({ text: 'Error en Mes, debe introducir dos números', type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;
                }
                if (FecIniCom[2].length < 4 || FecIniCom[2].length > 4) {
                    Swal.fire({ text: 'Error en Año, debe introducir dos números', type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;
                }
                valuesStart = scope.FecIniCom.split("/");
                valuesEnd = scope.fecha_server.split("/");
                // Verificamos que la fecha no sea posterior a la actual
                var dateStart = new Date(valuesStart[2], (valuesStart[1] - 1), valuesStart[0]);
                var dateEnd = new Date(valuesEnd[2], (valuesEnd[1] - 1), valuesEnd[0]);
                if (dateStart > dateEnd) {
                    Swal.fire({ title: 'Fecha de Inicio', text: 'La Fecha de Inicio no puede ser mayor al ' + scope.fecha_server + 'Verifique e intente nuevamente', type: "error", confirmButtonColor: "#188ae2" });
                    return false;
                }
                scope.fdatos.FecIniCom = valuesStart[2] + "/" + valuesStart[1] + "/" + valuesStart[0];
            }
        }
        if (scope.fdatos.RazSocCom == null || scope.fdatos.RazSocCom == undefined || scope.fdatos.RazSocCom == '') {
            Swal.fire({ title: 'La Razón social es requerida', type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (scope.fdatos.NomComCom == null || scope.fdatos.NomComCom == undefined || scope.fdatos.NomComCom == '') {
            Swal.fire({ title: 'El nombre comercial es requerido.', type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (!scope.fdatos.CodTipVia > 0) {
            Swal.fire({ title: 'Debe seleccionar un tipo de vía.', type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (scope.fdatos.NomViaDirCom == null || scope.fdatos.NomViaDirCom == undefined || scope.fdatos.NomViaDirCom == '') {
            Swal.fire({ title: 'El nombre de la vía es requerido.', type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (scope.fdatos.NumViaDirCom == null || scope.fdatos.NumViaDirCom == undefined || scope.fdatos.NumViaDirCom == '') {
            Swal.fire({ title: 'El numero de vía es requerido', type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (!scope.fdatos.CodPro > 0) {
            Swal.fire({ title: 'Debe seleccionar un Provincia', type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (!scope.fdatos.CodLoc > 0) {
            Swal.fire({ title: 'Debe seleccionar una localidad', type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (scope.fdatos.TelFijCom == null || scope.fdatos.TelFijCom == undefined || scope.fdatos.TelFijCom == '') {
            Swal.fire({ title: 'Debe indicar un número de teléfono fijo.', type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (scope.fdatos.EmaCom == null || scope.fdatos.EmaCom == undefined || scope.fdatos.EmaCom == '') {
            Swal.fire({ title: 'El email es requerido.', type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (scope.fdatos.NomConCom == null || scope.fdatos.NomConCom == undefined || scope.fdatos.NomConCom == '') {
            Swal.fire({ title: 'el campo persona de contacto es requerido.', type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (scope.fdatos.CarConCom == null || scope.fdatos.CarConCom == undefined || scope.fdatos.CarConCom == '') {
            Swal.fire({ title: 'Debe indicar el cargo de la persona de contacto', type: "error", confirmButtonColor: "#188ae2" });
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
                Swal.fire({ text: 'Error en formato de la fecha de contrato.', type: "error", confirmButtonColor: "#188ae2" });
                //event.preventDefault();	
                return false;
            } else {
                if (FecConCom[0].length > 2 || FecConCom[0].length < 2) {
                    Swal.fire({ text: 'El formato del dia es incorrecto', type: "error", confirmButtonColor: "#188ae2" });
                    //event.preventDefault();	
                    return false;

                }
                if (FecConCom[1].length > 2 || FecConCom[1].length < 2) {
                    Swal.fire({ text: 'El formato del mes es incorrecto', type: "error", confirmButtonColor: "#188ae2" });
                    //event.preventDefault();	
                    return false;
                }
                if (FecConCom[2].length < 4 || FecConCom[2].length > 4) {
                    Swal.fire({ text: 'EL formato del año es incorrecto', type: "error", confirmButtonColor: "#188ae2" });
                    //event.preventDefault();	
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
                Swal.fire({ text: 'Error en la fecha de vencimiento..', type: "error", confirmButtonColor: "#188ae2" });
                event.preventDefault();
                return false;
            } else {
                if (FecVenConCom[0].length > 2 || FecVenConCom[0].length < 2) {
                    Swal.fire({ text: 'el formato del dia es incorrecto', type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;

                }
                if (FecVenConCom[1].length > 2 || FecVenConCom[1].length < 2) {
                    Swal.fire({ text: 'el formato del mes es incorrecto', type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;
                }
                if (FecVenConCom[2].length < 4 || FecVenConCom[2].length > 4) {
                    Swal.fire({ text: 'el formato del año es incorrecto', type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
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

    }
    $scope.uploadFile = function() {
        var file = $scope.file;
        upload.uploadFile(file, name).then(function(res) {
            console.log(res);
        }, function(error) {
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
    scope.buscarXID = function() {
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
                Swal.fire({ title: "Error", text: 'No existen datos con el código que esta intentando buscar.', type: "error", confirmButtonColor: "#188ae2" });
                location.href = "#/Comercializadora";
            }

        }, function(error) {
            $("#buscando").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
    scope.misma_razon = function(opcion) {
        if (opcion == true) {
            scope.fdatos.NomComCom = undefined;
        } else {
            scope.fdatos.NomComCom = scope.fdatos.RazSocCom;
        }

    }
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