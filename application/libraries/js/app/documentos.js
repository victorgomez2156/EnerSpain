app.controller('Controlador_Documentos', ['$http', '$scope', '$filter', '$route', '$interval', '$controller', '$cookies', 'ServiceMaster', 'upload', Controlador])
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
    }).directive('uploaderModel', ["$parse", function($parse) {
        return {
            restrict: 'A',
            link: function(scope, iElement, iAttrs) {
                iElement.on("change", function(e) {
                    $parse(iAttrs.uploaderModel).assign(scope, iElement[0].files[0]);
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

function Controlador($http, $scope, $filter, $route, $interval, $controller, $cookies, ServiceMaster, upload) {
    //declaramos una variable llamada scope donde tendremos a vm
    /*inyectamos un controlador para acceder a sus variables y metodos*/
    //$controller('ControladorArticuloExistencia as vmAE',{$scope:$scope});			
    var scope = this;
    scope.fdatos = {}; // datos del formulario
    scope.nID = $route.current.params.ID; //contiene el id del registro en caso de estarse consultando desde la grid
    scope.validate_info = $route.current.params.MET;
    scope.Nivel = $cookies.get('nivel');
    scope.index = 0;

    ///////////////////////////// DOCUMENTOS CLIENTES START ///////////////////////////	
    scope.ruta_reportes_pdf_Documentos = 0;
    scope.ruta_reportes_excel_Documentos = 0;
    scope.NumCifCli = true;
    scope.RazSocCli = true;
    scope.CodTipDoc = true;
    scope.DesDoc = true;
    scope.TieVen = true;
    scope.FecVenDoc = true;
    scope.AccDoc = true;
    scope.topciondocumentos = [{ id: 1, nombre: 'ACTUALIZAR' }];
    scope.t_modal_documentos = {};
    scope.fagregar_documentos = {};
    const $Archivo_DocCliDoc = document.querySelector("#DocCliDoc");
    scope.T_Documentos = [];
    scope.T_DocumentosBack = [];
    ///////////////////////////// DOCUMENTOS CLIENTES END ///////////////////////////
    console.log($route.current.$$route.originalPath);
    if ($route.current.$$route.originalPath == "/Add_Documentos/") {
        scope.fagregar_documentos = {};
        scope.fagregar_documentos.TieVen = 0;
        scope.fagregar_documentos.ArcDoc = null;
        scope.fagregar_documentos.DesDoc = null;
    }

    ////////////////////////////////////////////////////////////// MODULO DOCUMENTOS START ////////////////////////////////////////////////////////////////////

    scope.tListDocumentos = [];
    scope.Tclientes = [];
    ServiceMaster.getAll().then(function(dato) {
        scope.fecha_server = dato.Fecha_Server;
        scope.tListDocumentos = dato.Tipos_Documentos;
        scope.Tclientes = dato.Clientes;
        $scope.predicate7 = 'id';
        $scope.reverse7 = true;
        $scope.currentPage7 = 1;
        $scope.order7 = function(predicate7) {
            $scope.reverse7 = ($scope.predicate7 === predicate7) ? !$scope.reverse7 : false;
            $scope.predicate7 = predicate7;
        };
        scope.T_Documentos = dato.Documentos;
        scope.T_DocumentosBack = dato.Documentos;
        $scope.totalItems7 = scope.T_Documentos.length;
        $scope.numPerPage7 = 50;
        $scope.paginate7 = function(value7) {
            var begin7, end7, index7;
            begin7 = ($scope.currentPage7 - 1) * $scope.numPerPage7;
            end7 = begin7 + $scope.numPerPage7;
            index7 = scope.T_Documentos.indexOf(value7);
            return (begin7 <= index7 && index7 < end7);
        }
        if (scope.T_Documentos == false) {
            scope.T_Documentos = [];
            scope.T_DocumentosBack = [];
        }
    }).catch(function(err) { console.log(err); });
    scope.cargar_documentos = function() {
        $("#cargar_documentos").removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url = base_urlHome() + "api/Clientes/get_all_documentos";
        $http.get(url).then(function(result) {
            $("#cargar_documentos").removeClass("loader loader-default  is-active").addClass("loader loader-default");
            if (result.data != false) {
                $scope.predicate7 = 'id';
                $scope.reverse7 = true;
                $scope.currentPage7 = 1;
                $scope.order7 = function(predicate7) {
                    $scope.reverse7 = ($scope.predicate7 === predicate7) ? !$scope.reverse7 : false;
                    $scope.predicate7 = predicate7;
                };
                scope.T_Documentos = result.data;
                scope.T_DocumentosBack = result.data;
                $scope.totalItems7 = scope.T_Documentos.length;
                $scope.numPerPage7 = 50;
                $scope.paginate7 = function(value7) {
                    var begin7, end7, index7;
                    begin7 = ($scope.currentPage7 - 1) * $scope.numPerPage7;
                    end7 = begin7 + $scope.numPerPage7;
                    index7 = scope.T_Documentos.indexOf(value7);
                    return (begin7 <= index7 && index7 < end7);
                }
            } else {
                Swal.fire({ title: "No se Encontraron Documentos Registrados.", type: "error", confirmButtonColor: "#188ae2" });
                scope.T_Documentos = [];
                scope.T_DocumentosBack = [];
            }
        }, function(error) {
            $("#cargar_documentos").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (error.status == 404 && error.statusText == "Not Found") {
                Swal.fire({ title: "Error General", text: "El método que esté intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 401 && error.statusText == "Unauthorized") {
                Swal.fire({ title: "Error de Privilegios", text: "Usuario no autorizado para acceder a este Módulo", type: "info", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 403 && error.statusText == "Forbidden") {
                Swal.fire({ title: "Seguridad.", text: "Está intentando utilizar un APIKEY inválido", type: "question", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 500 && error.statusText == "Internal Server Error") {
                Swal.fire({ title: "Error.", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
            }
        });
    }

    $scope.SubmitFormFiltrosDocumentos = function(event) {
        if (scope.t_modal_documentos.tipo_filtro == 1) {

            if (!scope.t_modal_documentos.CodCli > 0) {
                Swal.fire({ title: "Error.", text: "Debe Seleccionar un Cliente para aplicar el filtro.", type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }
            $scope.predicate7 = 'id';
            $scope.reverse7 = true;
            $scope.currentPage7 = 1;
            $scope.order7 = function(predicate7) {
                $scope.reverse7 = ($scope.predicate7 === predicate7) ? !$scope.reverse7 : false;
                $scope.predicate7 = predicate7;
            };
            scope.T_Documentos = $filter('filter')(scope.T_DocumentosBack, { CodCli: scope.t_modal_documentos.CodCli }, true);
            $scope.totalItems7 = scope.T_Documentos.length;
            $scope.numPerPage7 = 50;
            $scope.paginate7 = function(value7) {
                var begin7, end7, index7;
                begin7 = ($scope.currentPage7 - 1) * $scope.numPerPage7;
                end7 = begin7 + $scope.numPerPage7;
                index7 = scope.T_Documentos.indexOf(value7);
                return (begin7 <= index7 && index7 < end7);
            }
            scope.ruta_reportes_pdf_Documentos = scope.t_modal_documentos.tipo_filtro + "/" + scope.t_modal_documentos.CodCli;
            scope.ruta_reportes_excel_Documentos = scope.t_modal_documentos.tipo_filtro + "/" + scope.t_modal_documentos.CodCli;
        }
        if (scope.t_modal_documentos.tipo_filtro == 2) {

            if (!scope.t_modal_documentos.CodTipDoc > 0) {
                Swal.fire({ title: "Error.", text: "Debe Seleccionar un Tipo de Documento para aplicar el filtro.", type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }
            $scope.predicate7 = 'id';
            $scope.reverse7 = true;
            $scope.currentPage7 = 1;
            $scope.order7 = function(predicate7) {
                $scope.reverse7 = ($scope.predicate7 === predicate7) ? !$scope.reverse7 : false;
                $scope.predicate7 = predicate7;
            };
            scope.T_Documentos = $filter('filter')(scope.T_DocumentosBack, { CodTipDoc: scope.t_modal_documentos.CodTipDoc }, true);
            $scope.totalItems7 = scope.T_Documentos.length;
            $scope.numPerPage7 = 50;
            $scope.paginate7 = function(value7) {
                var begin7, end7, index7;
                begin7 = ($scope.currentPage7 - 1) * $scope.numPerPage7;
                end7 = begin7 + $scope.numPerPage7;
                index7 = scope.T_Documentos.indexOf(value7);
                return (begin7 <= index7 && index7 < end7);
            }
            scope.ruta_reportes_pdf_Documentos = scope.t_modal_documentos.tipo_filtro + "/" + scope.t_modal_documentos.CodTipDoc;
            scope.ruta_reportes_excel_Documentos = scope.t_modal_documentos.tipo_filtro + "/" + scope.t_modal_documentos.CodTipDoc;
        }
        if (scope.t_modal_documentos.tipo_filtro == 3) {

            if (!scope.t_modal_documentos.TieVen > 0) {
                Swal.fire({ title: "Error.", text: "Debe Seleccionar un Tipo de Documento para aplicar el filtro.", type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }
            $scope.predicate7 = 'id';
            $scope.reverse7 = true;
            $scope.currentPage7 = 1;
            $scope.order7 = function(predicate7) {
                $scope.reverse7 = ($scope.predicate7 === predicate7) ? !$scope.reverse7 : false;
                $scope.predicate7 = predicate7;
            };
            scope.T_Documentos = $filter('filter')(scope.T_DocumentosBack, { TieVen: scope.t_modal_documentos.TieVen }, true);
            $scope.totalItems7 = scope.T_Documentos.length;
            $scope.numPerPage7 = 50;
            $scope.paginate7 = function(value7) {
                var begin7, end7, index7;
                begin7 = ($scope.currentPage7 - 1) * $scope.numPerPage7;
                end7 = begin7 + $scope.numPerPage7;
                index7 = scope.T_Documentos.indexOf(value7);
                return (begin7 <= index7 && index7 < end7);
            }
            scope.ruta_reportes_pdf_Documentos = scope.t_modal_documentos.tipo_filtro + "/" + scope.t_modal_documentos.TieVen;
            scope.ruta_reportes_excel_Documentos = scope.t_modal_documentos.tipo_filtro + "/" + scope.t_modal_documentos.TieVen;
        }
    };
    scope.regresar_filtro_documentos = function() {
        $scope.predicate7 = 'id';
        $scope.reverse7 = true;
        $scope.currentPage7 = 1;
        $scope.order7 = function(predicate7) {
            $scope.reverse7 = ($scope.predicate7 === predicate7) ? !$scope.reverse7 : false;
            $scope.predicate7 = predicate7;
        };
        scope.T_Documentos = scope.T_DocumentosBack;
        $scope.totalItems7 = scope.T_Documentos.length;
        $scope.numPerPage7 = 50;
        $scope.paginate7 = function(value7) {
            var begin7, end7, index7;
            begin7 = ($scope.currentPage7 - 1) * $scope.numPerPage7;
            end7 = begin7 + $scope.numPerPage7;
            index7 = scope.T_Documentos.indexOf(value7);
            return (begin7 <= index7 && index7 < end7);
        }
        scope.ruta_reportes_pdf_Documentos = 0;
        scope.ruta_reportes_excel_Documentos = 0;
        scope.t_modal_documentos = {};
    }
    scope.validar_opc_documentos = function(index, opciones_documentos, dato) {
        console.log(index);
        console.log(opciones_documentos);
        console.log(dato);
        scope.opciones_documentos[index] = undefined;
        if (opciones_documentos == 1) {
            /*scope.fagregar_documentos=dato;
            scope.restringir_cliente_doc=1;
            document.getElementById('DocCliDoc').value ='';
            scope.agregar_documentos=false;
            scope.FecVenDocAco=dato.FecVenDoc;*/
            location.href = "#/Edit_Documentos/" + dato.CodTipDocAI;
        }
    }
    scope.limpiar_fecha_no = function() {
        if (scope.fagregar_documentos.TieVen == 2) {
            scope.FecVenDocAco = undefined;
        }
    }
    scope.validarfechadocumento = function(object) {
        if (object != undefined) {
            numero = object;
            if (!/^([/0-9])*$/.test(numero))
                scope.FecVenDocAco = numero.substring(0, numero.length - 1);
        }
    }
    scope.regresar_documentos = function() {
        if (scope.fagregar_documentos.CodTipDocAI == undefined) {
            var title = "Guardando";
            var text = "¿Seguro que desea cerrar sin registrar el Documento?";
        }
        if (scope.fagregar_documentos.CodTipDocAI > 0) {
            var title = "Actualizando";
            var text = "¿Seguro que desea cerrar sin actualizar la información del Documento?";
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
                location.href = "#/Documentos";
            } else {
                console.log('Cancelando ando...');
            }
        });
    }
    $scope.submitFormRegistroDocumentos = function(event) {
        if (!scope.validar_campos_documentos_null()) {
            return false;
        }
        if (scope.fagregar_documentos.CodTipDocAI > 0) {
            var title = 'Actualizando';
            var text = '¿Seguro que desea modificar la información del Documento?';
            var response = "Documento actualizado de forma correcta";
        }
        if (scope.fagregar_documentos.CodTipDocAI == undefined) {
            var title = 'Guardando';
            var text = '¿Seguro que desea registrar el Documento?';
            var response = "Documento registrado de forma correcta";
        }
        Swal.fire({
            title: title,
            text: text,
            type: "info",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: "Confirmar"
        }).then(function(t) {
            if (t.value == true) {
                scope.validar_archivos();
                $("#" + title).removeClass("loader loader-default").addClass("loader loader-default is-active");
                var url = base_urlHome() + "api/Clientes/Registrar_Documentos";
                $http.post(url, scope.fagregar_documentos).then(function(result) {

                    $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (result.data != false) {
                        if ($Archivo_DocCliDoc.files.length > 0) {
                            $scope.uploadFile(3);
                        }
                        Swal.fire({ title: title, text: response, type: "success", confirmButtonColor: "#188ae2" });
                        scope.fagregar_documentos = result.data;
                        scope.restringir_cliente_doc = 1;
                        document.getElementById('DocCliDoc').value = '';
                        console.log(result.data);
                    } else {
                        Swal.fire({ title: "Error.", text: "Error en el proceso intente nuevamente.", type: "error", confirmButtonColor: "#188ae2" });
                    }

                }, function(error) {
                    $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (error.status == 404 && error.statusText == "Not Found") {
                        Swal.fire({ title: "Error General", text: "El método que esté intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 401 && error.statusText == "Unauthorized") {
                        Swal.fire({ title: "Error de Privilegios", text: "Usuario no autorizado para acceder a este Módulo", type: "info", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 403 && error.statusText == "Forbidden") {
                        Swal.fire({ title: "Seguridad.", text: "Está intentando utilizar un APIKEY inválido", type: "question", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 500 && error.statusText == "Internal Server Error") {
                        Swal.fire({ title: "Error.", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
                    }
                });
            } else {
                event.preventDefault();
                console.log('Cancelando ando...');
            }
        });
    };
    scope.validar_archivos = function() {
        let Archivo_DocCliDoc = $Archivo_DocCliDoc.files;
        if ($Archivo_DocCliDoc.files.length > 0) {
            if ($Archivo_DocCliDoc.files[0].size > 2097152) {
                Swal.fire({ title: 'Error', text: "El tamaño del fichero no debe ser superior a 2 MB", type: "error", confirmButtonColor: "#188ae2" });
                scope.fagregar_documentos.ArcDoc = null;
                scope.fagregar_documentos.DesDoc = null;
                document.getElementById('DocCliDoc').value = '';
                return false;
            } else {
                if ($Archivo_DocCliDoc.files[0].type == "application/pdf" || $Archivo_DocCliDoc.files[0].type == "image/jpeg" || $Archivo_DocCliDoc.files[0].type == "image/png") {
                    var tipo_file = ($Archivo_DocCliDoc.files[0].type).split("/");
                    $Archivo_DocCliDoc.files[0].type;
                    scope.fagregar_documentos.ArcDoc = 'documentos/' + $Archivo_DocCliDoc.files[0].name;
                    scope.fagregar_documentos.DesDoc = $Archivo_DocCliDoc.files[0].name;
                } else {
                    Swal.fire({ title: 'Error', text: "Formato de fichero incorrecto, debe ser PDF, JPG o PNG", type: "error", confirmButtonColor: "#188ae2" });
                    document.getElementById('DocCliDoc').value = '';
                    scope.fagregar_documentos.ArcDoc = null;
                    scope.fagregar_documentos.DesDoc = null;
                    return false;
                }
            }
        } else {
            document.getElementById('DocCliDoc').value = '';
            if (scope.fagregar_documentos.DocCliDoc == undefined || scope.fagregar_documentos.DocCliDoc == null) {
                scope.fagregar_documentos.DocCliDoc = null;
            } else {
                scope.fagregar_documentos.DocCliDoc = scope.fagregar_documentos.DocCliDoc;
            }
        }
        console.log(scope.fagregar_documentos);
    }
    scope.validar_campos_documentos_null = function() {
        resultado = true;
        if (!scope.fagregar_documentos.CodCli > 0) {
            Swal.fire({ title: "Seleccione un Cliente", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (!scope.fagregar_documentos.CodTipDoc > 0) {
            Swal.fire({ title: "Seleccione un Tipo de Documento", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (scope.fagregar_documentos.TieVen == 0) {
            Swal.fire({ title: "Indicar si el Documento tiene o no Fecha de Vencimiento", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        if (scope.fagregar_documentos.TieVen == 1) {
            if (scope.FecVenDocAco == undefined) {
                Swal.fire({ title: "Colocar Fecha de Vencimiento con el formato DD/MM/YYYY", type: "info", confirmButtonColor: "#188ae2" });
                return false;
            } else {
                var FecActDoc = (scope.FecVenDocAco).split("/");
                if (FecActDoc.length < 3) {
                    Swal.fire({ text: "Error en Fecha de Vencimiento, el formato correcto es DD/MM/YYYY", type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;
                } else {
                    if (FecActDoc[0].length > 2 || FecActDoc[0].length < 2) {
                        Swal.fire({ text: "Error en Día, debe contener dos números", type: "error", confirmButtonColor: "#188ae2" });
                        event.preventDefault();
                        return false;

                    }
                    if (FecActDoc[1].length > 2 || FecActDoc[1].length < 2) {
                        Swal.fire({ text: "Error en Mes, debe contener dos números", type: "error", confirmButtonColor: "#188ae2" });
                        event.preventDefault();
                        return false;
                    }
                    if (FecActDoc[2].length < 4 || FecActDoc[2].length > 4) {
                        Swal.fire({ text: "Error en Año, debe contener cuatro números", type: "error", confirmButtonColor: "#188ae2" });
                        event.preventDefault();
                        return false;
                    }
                    scope.fagregar_documentos.FecVenDocAco = FecActDoc[2] + "/" + FecActDoc[1] + "/" + FecActDoc[0];
                    //scope.tmodal_servicio_especiales.FecIniSerEsp=FecIniSerEsp[0]+"/"+FecIniSerEsp[1]+"/"+FecIniSerEsp[2];					
                }
            }
        }
        if (scope.fagregar_documentos.TieVen == 2) {
            scope.fagregar_documentos.FecVenDocAco = null;
        }
        if (scope.fagregar_documentos.ObsDoc == null || scope.fagregar_documentos.ObsDoc == undefined || scope.fagregar_documentos.ObsDoc == '') {
            scope.fagregar_documentos.ObsDoc = null;
        } else {
            scope.fagregar_documentos.ObsDoc = scope.fagregar_documentos.ObsDoc;
        }
        if (resultado == false) {
            return false;
        }
        return true;
    }
    $scope.uploadFile = function(metodo) {
        if (metodo == 3) {
            var file = $scope.DocCliDoc;
        }

        upload.uploadFile(file, name).then(function(res) {}, function(error) {
            if (error.status == 404 && error.statusText == "Not Found") {
                bootbox.alert({
                    message: "El método que está intentando usar no puede ser localizado",
                    size: 'middle'
                });
            }
            if (error.status == 401 && error.statusText == "Unauthorized") {
                bootbox.alert({
                    message: "Usted no tiene acceso a este controlador",
                    size: 'middle'
                });
            }
            if (error.status == 403 && error.statusText == "Forbidden") {
                bootbox.alert({
                    message: "Está intentando usar un APIKEY inválido",
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
    scope.BuscarXIDDocumentos = function() {
        $("#buscando").removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url = base_urlHome() + "api/Clientes/Buscar_xID_Documentos/CodTipDocAI/" + scope.nID;
        $http.get(url).then(function(result) {
            $("#buscando").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (result.data != false) {
                scope.fagregar_documentos = result.data;
                scope.FecVenDocAco = result.data.FecVenDoc;
                $('.datepicker').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.FecVenDocAco);
                console.log(result.data);
            } else {
                Swal.fire({ title: "Error", text: "No hemos encontrado datos relacionados con este código", type: "error", confirmButtonColor: "#188ae2" });
            }

        }, function(error) {
            $("#buscando").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (error.status == 404 && error.statusText == "Not Found") {
                Swal.fire({ title: "Error 404", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 401 && error.statusText == "Unauthorized") {
                Swal.fire({ title: "Error 401.", text: "Usuario no autorizado para acceder a este Módulo", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 403 && error.statusText == "Forbidden") {
                Swal.fire({ title: "Error 403.", text: "Está intentando utilizar un APIKEY inválido", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 500 && error.statusText == "Internal Server Error") {
                Swal.fire({ title: "Error 500.", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
            }
        });
    }
    if (scope.nID != undefined) {
        scope.BuscarXIDDocumentos();
    }
    ////////////////////////////////////////////////////////////// MODULO DOCUMENTOS END ////////////////////////////////////////////////////////////////////

}