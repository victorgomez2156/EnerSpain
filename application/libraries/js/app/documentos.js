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
    scope.CodCli = true;
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
                
                scope.T_Documentos = [];
                scope.T_DocumentosBack = [];
            }
        }, function(error) {
            $("#cargar_documentos").removeClass("loader loader-default is-active").addClass("loader loader-default");
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

    $scope.SubmitFormFiltrosDocumentos = function(event) {
        if (scope.t_modal_documentos.tipo_filtro == 1) {

            if (!scope.t_modal_documentos.CodCli > 0) {
                scope.toast('error','Debe Seleccionar un Cliente para aplicar el filtro.','Error');
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
                scope.toast('error','Debe Seleccionar un Tipo de Documento para aplicar el filtro.','Error');
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
                scope.toast('error','Debe Seleccionar un Tipo de Documento para aplicar el filtro.','Error');
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
        scope.NumCifCliSearch=undefined;
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
        
        scope.validar_archivos();


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
                
                
                
                $("#" + title).removeClass("loader loader-default").addClass("loader loader-default is-active");
                var url = base_urlHome() + "api/Clientes/Registrar_Documentos";
                $http.post(url, scope.fagregar_documentos).then(function(result) {

                    $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (result.data != false) {
                        if ($Archivo_DocCliDoc.files.length > 0) {
                            $scope.uploadFile(3);
                        }
                        scope.toast('success',response,title);
                        scope.fagregar_documentos = result.data;
                        scope.restringir_cliente_doc = 1;
                        document.getElementById('DocCliDoc').value = '';
                        $('#filenameDocCli').html('');
                        console.log(result.data);
                    } else {
                        scope.toast('error','Error en el proceso intente nuevamente.','Error');                        
                    }

                }, function(error) {
                    $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
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
                console.log('Cancelando ando...');
            }
        });
    };
    scope.validar_archivos = function() {
        
        let Archivo_DocCliDoc = $Archivo_DocCliDoc.files;
        if ($Archivo_DocCliDoc.files.length > 0) {
            if ($Archivo_DocCliDoc.files[0].size > 2097152) {
                scope.toast('error','El tamaño del fichero no debe ser superior a 2 MB','Error');
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
                    scope.toast('error','Formato de fichero incorrecto, debe ser PDF, JPG o PNG','Error');
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
            scope.toast('error','Seleccione un Cliente.','');
            return false;
        }
        if (!scope.fagregar_documentos.CodTipDoc > 0) {
            scope.toast('error','Seleccione un Tipo de Documento.','');
           return false;
        } 
        
        if (scope.fagregar_documentos.DesDoc ==null) {
            scope.toast('error','Debe Seleccionar un Documento.','');
           return false;
        }
        

        if (scope.fagregar_documentos.TieVen == 0) {
            scope.toast('error','Indicar si el Documento tiene o no Fecha de Vencimiento.','');
            return false;
        }
        if (scope.fagregar_documentos.TieVen == 1) {

            var FecVenDocAco = document.getElementById("FecVenDocAco").value;
            scope.FecVenDocAco = FecVenDocAco;
            if (scope.FecVenDocAco == undefined) {
                scope.toast('error','Colocar Fecha de Vencimiento con el formato DD/MM/YYYY.','');
                return false;
            } else {
                var FecActDoc = (scope.FecVenDocAco).split("/");
                if (FecActDoc.length < 3) {
                    scope.toast('error','Error en Fecha de Vencimiento, el formato correcto es DD/MM/YYYY.','');
                    event.preventDefault();
                    return false;
                } else {
                    if (FecActDoc[0].length > 2 || FecActDoc[0].length < 2) {
                        scope.toast('error','Error en Día, debe contener dos números.','');
                        event.preventDefault();
                        return false;

                    }
                    if (FecActDoc[1].length > 2 || FecActDoc[1].length < 2) {
                        scope.toast('error','Error en Mes, debe contener dos números.','');
                        event.preventDefault();
                        return false;
                    }
                    if (FecActDoc[2].length < 4 || FecActDoc[2].length > 4) {
                        scope.toast('error','Error en Año, debe contener cuatro números.','');
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
                scope.NumCifCliSearch=result.data.NumCifCli;
            } else {
                scope.toast('error','No hemos encontrado datos relacionados con este código','Error');
                
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
    scope.FetchDocumentos = function() {
        if (scope.filtrar_search == undefined || scope.filtrar_search == null || scope.filtrar_search == '') {
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
        } else {
            if (scope.filtrar_search.length >= 2) {
                scope.fdatos.filtrar_search = scope.filtrar_search;
                var url = base_urlHome() + "api/Clientes/getDocumentosFilter";
                $http.post(url, scope.fdatos).then(function(result) {
                    console.log(result.data);
                    if (result.data != false) {
                        $scope.predicate7 = 'id';
                        $scope.reverse7 = true;
                        $scope.currentPage7 = 1;
                        $scope.order7 = function(predicate7) {
                            $scope.reverse7 = ($scope.predicate7 === predicate7) ? !$scope.reverse7 : false;
                            $scope.predicate7 = predicate7;
                        };
                        scope.T_Documentos = result.data;
                        $scope.totalItems7 = scope.T_Documentos.length;
                        $scope.numPerPage7 = 50;
                        $scope.paginate7 = function(value7) {
                            var begin7, end7, index7;
                            begin7 = ($scope.currentPage7 - 1) * $scope.numPerPage7;
                            end7 = begin7 + $scope.numPerPage7;
                            index7 = scope.T_Documentos.indexOf(value7);
                            return (begin7 <= index7 && index7 < end7);
                        }
                        scope.ruta_reportes_pdf_Documentos = 4 + "/" + scope.filtrar_search;
                        scope.ruta_reportes_excel_Documentos = 4 + "/" + scope.filtrar_search;
                    } else {
                        
                        scope.T_Documentos = [];
                        scope.ruta_reportes_pdf_Documentos = 0;
                        scope.ruta_reportes_excel_Documentos = 0;
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
            }
        }
    }
     scope.fetchClientes = function(metodo) {

        if(metodo==1 || metodo==2)
        {
            var searchText_len = scope.NumCifCliSearch.trim().length;
            scope.fdatos.filtrar_clientes = scope.NumCifCliSearch;
        } if (searchText_len > 0) {
                var url = base_urlHome() + "api/Clientes/getClientesFilter";
                $http.post(url, scope.fdatos).then(function(result) {
                //console.log(result);
                if (result.data != false) {
                    scope.searchResult = result.data;
                } else {
               
                         scope.searchResult = {};
                                         }
                                     },
                                     function(error) {
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
                             scope.searchResult = {};
                         }
        
            
    }  
     scope.containerClicked = function() {
        scope.searchResult = {};
    }
    scope.searchboxClicked = function($event) {
                     $event.stopPropagation();
                 }
    scope.setValue = function(index, $event, result,metodo) 
    {
        if(metodo==1)
        {
            scope.NumCifCliSearch = scope.searchResult[index].NumCifCli;
            scope.t_modal_documentos.CodCli= scope.searchResult[index].CodCli;
            scope.searchResult = {};
            $event.stopPropagation(); 
        }
        if(metodo==2)
        {
            scope.NumCifCliSearch = scope.searchResult[index].NumCifCli;
            scope.fagregar_documentos.CodCli= scope.searchResult[index].CodCli;
            scope.searchResult = {};
            $event.stopPropagation(); 
        }
       
                            
    }
    scope.cargar_TipoDocumentos=function()
         {
           var url = base_urlHome()+"api/Clientes/RealizarConsultaFiltros/metodo/"+11;
           $http.get(url).then(function (result)
           {
            if(result.data)
            {
                scope.tListDocumentos=result.data;
            }
            else
            {
                scope.tListaContactos=[];
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
        scope.BuscarXIDDocumentos();
    }

    scope.cargar_TipoDocumentos();
    ////////////////////////////////////////////////////////////// MODULO DOCUMENTOS END ////////////////////////////////////////////////////////////////////

}