app.controller('Controlador_Contratos', ['$http', '$scope', '$filter', '$route', '$interval', '$controller', '$cookies', '$compile', 'upload', Controlador])
    .directive('updloadfotocopiaModel', ["$parse", function($parse) {
        return {
            restrict: 'A',
            link: function(scope, iElement, iAttrs) {
                iElement.on("change", function(e) {
                    $parse(iAttrs.updloadfotocopiaModel).assign(scope, iElement[0].files[0]);
                    //console.log($parse(iAttrs.updloadfotocopiaModel).assign(scope, iElement[0].files[0]));
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

function Controlador($http, $scope, $filter, $route, $interval, $controller, $cookies, $compile, upload) {
    
    var scope = this;
    scope.fdatos = {};
    scope.T_Contratos = [];
    scope.T_ContratosBack = [];
    scope.tmodal_filtros = {};
    scope.fdatos.detalleCUPs=[];
    scope.CodConCom = $route.current.params.CodConCom;
    scope.CodCli = $route.current.params.CodCli;
    scope.CodProCom = $route.current.params.CodProCom;
    scope.fdatos.tipo = $route.current.params.Tipo;
    scope.TipProCom = $route.current.params.TipProCom;
    scope.fdatos.TDocumentosContratos=[];
    scope.Nivel = $cookies.get('nivel');
    scope.List_TipPre = [{ TipPre: 0, nombre: 'Fijo' }, { TipPre: 1, nombre: 'Indexado' }];
    //
    //scope.url_pdf_audax="https://www.systemsmaster.com.ve/AudaxPDFSencillo/";
    //scope.url_pdf_audax="http://10.72.0.16/AudaxPDFSencillo/";
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
    ////////////////////////////////////////////////// PARA LOS CONTRATOS START /////////////////////////////////////////////////////////////
    //console.log($route.current.$$route.originalPath);
    //console.log(scope.CodConCom);
    //console.log(scope.CodCli);
    //console.log(scope.fdatos.tipo);

    const $archivofotocopia = document.querySelector("#file_fotocopia");
    scope.get_list_contratos = function() {
        $("#Contratos").removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url = base_urlHome() + "api/Contratos/get_list_contratos_clientes";
        $http.get(url).then(function(result) {
            $("#Contratos").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (result.data != false) {
                $scope.predicate = 'id';
                $scope.reverse = true;
                $scope.currentPage = 1;
                $scope.order = function(predicate) {
                    $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                    $scope.predicate = predicate;
                };
                scope.T_Contratos = result.data;
                scope.T_ContratosBack = result.data;
                $scope.totalItems = scope.T_Contratos.length;
                $scope.numPerPage = 50;
                $scope.paginate = function(value) {
                    var begin, end, index;
                    begin = ($scope.currentPage - 1) * $scope.numPerPage;
                    end = begin + $scope.numPerPage;
                    index = scope.T_Contratos.indexOf(value);
                    return (begin <= index && index < end);
                }
            } else {
                scope.T_Contratos = [];
                scope.T_ContratosBack = [];
            }
        }, function(error) {
            $("#Contratos").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
    scope.fetchClientes = function(metodo) {
        scope.fdatos.metodo=metodo;
        if (metodo == 1) {
            var searchText_len = scope.NumCifCli.trim().length;
            scope.fdatos.NumCifCli = scope.NumCifCli;

            if (searchText_len > 0) {
                var url = base_urlHome() + "api/Contratos/getclientes";
                $http.post(url, scope.fdatos).then(function(result) {
                    console.log(result);
                    if (result.data != false) {
                        scope.searchResult = result.data;
                        console.log(scope.searchResult);
                    } else {
                        scope.searchResult = {};
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
                scope.searchResult = {};
            }
        }
        if (metodo == 2) {
            var searchText_len = scope.NumCifCliFil.trim().length;
            scope.fdatos.NumCifCli = scope.NumCifCliFil;
            if (searchText_len > 0) {
                var url = base_urlHome() + "api/Contratos/getclientes";
                $http.post(url, scope.fdatos).then(function(result) {
                    console.log(result);
                    if (result.data != false) {
                        scope.searchResult = result.data;
                        console.log(scope.searchResult);
                    } else {
                        scope.searchResult = {};
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
                scope.searchResult = {};
            }
        }

    }

    scope.setValue = function(index, $event, result, metodo)
    {
        if (metodo == 1) {
            scope.NumCifCli = scope.searchResult[index].NumCifCli;
            scope.searchResult = {};
            $event.stopPropagation();
        }
        if (metodo == 2) {
            scope.NumCifCliFil = scope.searchResult[index].NumCifCli + " - " + scope.searchResult[index].RazSocCli;
            scope.CodCliFil = scope.searchResult[index].CodCli;
            scope.searchResult = {};
            $event.stopPropagation();
        }
    }
    scope.searchboxClicked = function($event) {
        $event.stopPropagation();
    }
    scope.containerClicked = function() {
        scope.searchResult = {};
    }//3775000,00 alexander lopez
    $scope.Consultar_CIF = function(event) {
        if (scope.NumCifCli == undefined || scope.NumCifCli == null || scope.NumCifCli == '') {
            scope.toast('error','El número de cif del cliente es requerido.','Número de CIF');
            return false;
        }
        $("#NumCifCli").removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url = base_urlHome() + "api/Contratos/get_valida_datos_clientes/NumCifCli/" + scope.NumCifCli;
        $http.get(url).then(function(result) {
            console.log(result);
            $("#NumCifCli").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (result.data != false) {
                if (result.data.status == false && result.data.statusText == "Error") {
                    scope.toast('error',result.data.menssage,result.data.statusText);
                    return false;
                }
                if (result.data.status == true && result.data.statusText == 'Contrato') {
                    $('#modal_add_contratos').modal('hide');
                    location.href = "#/Add_Contrato/" + result.data.Cliente.CodCli + "/nuevo";
                }
                if (result.data.status == true && result.data.statusText == 'Propuesta_Nueva') {
                    $("#modal_add_contratos").modal('hide');
                    //location.href="#/Add_Propuesta_Comercial/"+result.data.CodCli+"/nueva";
                }
            } else {
              scope.toast('error','El número del CIF no se encuentra asignando a ningun cliente.','Error');
            }
        }, function(error) {
            $("#NumCifCli").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
    scope.BuscarXIDPropuestaContrato = function() {
        $("#NumCifCli").removeClass("loader loader-default").addClass("loader loader-default is-active");
        scope.CanPerEle = 6;
        var url = base_urlHome() + "api/Contratos/BuscarXIDPropuestaContrato/CodCli/" + scope.CodCli;
        $http.get(url).then(function(result) {
            console.log(result);
            $("#NumCifCli").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (result.data != false) {
                if (result.data.status == false && result.data.statusText == "Error") {
                  scope.toast('error',result.data.menssage,'Error');
                    location.href = "#/Contratos/";
                    return false;
                }
                scope.fdatos.CodCli = result.data.Cliente.CodCli;
                scope.RazSocCli = result.data.Cliente.RazSocCli;
                scope.NumCifCli = result.data.Cliente.NumCifCli;
                scope.List_Propuestas_Comerciales = result.data.List_Propuesta;
                scope.fdatos.RefCon = result.data.RefCon;
                $("#FecVenConClass").removeClass("col-sm-4").addClass("col-sm-6");
                $("#DurConClass").removeClass("col-sm-6").addClass("col-sm-6");
                $("#TipPreClass").removeClass("col-sm-4").addClass("col-sm-6");
                $("#FecActClass").removeClass("col-sm-4").addClass("col-sm-6");
                //$("#RefConClass").removeClass("col-sm-6").addClass("col-sm-4");

                $('.datepicker_Inicio').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", result.data.FechaServer);
            } else {
              scope.toast('error','Este Número de CIF no se encuentra registrado.','Error');
            }

        }, function(error) {
            $("#NumCifCli").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
    scope.calcular_vencimiento = function() 
    {
        scope.parafechas = {};
        scope.FecIniCon = document.getElementById("FecIniCon").value;
        scope.parafechas.FechaCalcular = scope.FecIniCon;
        scope.parafechas.DurCon = scope.fdatos.DurCon;
        scope.parafechas.tipo=scope.fdatos.tipo;
        var url = base_urlHome() + "api/Contratos/calcular_vencimiento/";
        $http.post(url, scope.parafechas).then(function(result) {

            if (result.data.status == false && result.data.statusText == "Fecha") {
                scope.toast('error',result.data.menssage,result.data.statusText);              
                scope.FecVenCon = undefined;
                $('.datepicker_Inicio').datepicker({format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", result.data.FechaServer);
                scope.calcular_vencimiento();
                return false;
            }
            $('.datepicker_Vencimiento').datepicker({format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true })
            .datepicker("setDate", result.data.FecVenc);/*
            .datepicker("setEndDate", result.data.FecVenc)*/
                
            scope.FecVenCon = result.data.FecVenc;
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
   
    scope.validar_formatos_input = function(metodo, object){
        
        if (metodo == 1) {
            if (object != undefined){
                numero = object;
                if (!/^([/0-9])*$/.test(numero))
                    scope.FecIniCon = numero.substring(0, numero.length - 1);
            }
            if(object.length==10 && scope.fdatos.DurCon!=undefined){
                scope.calcular_vencimiento();
            }
        }
        if (metodo == 2) {
            if (object != undefined) {
                numero = object;
                if (!/^([/0-9])*$/.test(numero))
                    scope.FecBajCon = numero.substring(0, numero.length - 1);
            }
        }
        if (metodo == 3) {
            if (object != undefined) {
                numero = object;
                if (!/^([/0-9])*$/.test(numero))
                    scope.RangFec = numero.substring(0, numero.length - 1);
            }
        }

        if (metodo == 4) {
             if (object != undefined) {
                 numero = object;
                 if (!/^([/0-9])*$/.test(numero))
                     scope.FecProCom = numero.substring(0, numero.length - 1);
             }
         }
         if (metodo == 5) {
             if (object != undefined) {
                 numero = object;
                 if (!/^([.0-9])*$/.test(numero))
                     scope.fdatos.PotConP1 = numero.substring(0, numero.length - 1);
             }
         }
         if (metodo == 6) {
             if (object != undefined) {
                 numero = object;
                 if (!/^([.0-9])*$/.test(numero))
                     scope.fdatos.PotConP2 = numero.substring(0, numero.length - 1);
             }
         }
         if (metodo == 7) {
             if (object != undefined) {
                 numero = object;
                 if (!/^([.0-9])*$/.test(numero))
                     scope.fdatos.PotConP3 = numero.substring(0, numero.length - 1);
             }
         }
         if (metodo == 8) {
             if (object != undefined) {
                 numero = object;
                 if (!/^([.0-9])*$/.test(numero))
                     scope.fdatos.PotConP4 = numero.substring(0, numero.length - 1);
             }
         }
         if (metodo == 9) {
             if (object != undefined) {
                 numero = object;
                 if (!/^([.0-9])*$/.test(numero))
                     scope.fdatos.PotConP5 = numero.substring(0, numero.length - 1);
             }
         }
         if (metodo == 10) {
             if (object != undefined) {
                 numero = object;
                 if (!/^([.0-9])*$/.test(numero))
                     scope.fdatos.PotConP6 = numero.substring(0, numero.length - 1);
             }
         }
         if (metodo == 11) {
             if (object != undefined) {
                 numero = object;
                 if (!/^([.0-9])*$/.test(numero))
                     scope.fdatos.ImpAhoEle = numero.substring(0, numero.length - 1);
             }
             if (scope.fdatos.ImpAhoEle != undefined || scope.fdatos.ImpAhoEle != null || scope.fdatos.ImpAhoEle != '' && scope.fdatos.ImpAhoGas != undefined || scope.fdatos.ImpAhoGas != null || scope.fdatos.ImpAhoGas != '') {
                 scope.fdatos.ImpAhoTot = Math.max(parseFloat(scope.fdatos.ImpAhoEle), 0) + Math.max(parseFloat(scope.fdatos.ImpAhoGas), 0);
                 //scope.fdatos.ImpAhoTot = Math.max(parseInt(scope.fdatos.ImpAhoEle).toFixed(2)) + Math.max(parseInt(scope.fdatos.ImpAhoGas).toFixed(2));
             }
             if (scope.fdatos.ImpAhoGas == undefined || scope.fdatos.ImpAhoGas == null || scope.fdatos.ImpAhoGas == '') {
                 scope.fdatos.ImpAhoTot = scope.fdatos.ImpAhoEle;
             }

         }
         if (metodo == 12) {
             if (object != undefined) {
                 numero = object;
                 if (!/^([.0-9])*$/.test(numero))
                     scope.fdatos.PorAhoEle = numero.substring(0, numero.length - 1);
             }
             if (scope.fdatos.PorAhoEle != undefined || scope.fdatos.PorAhoEle != null || scope.fdatos.PorAhoEle != '' && scope.fdatos.PorAhoGas != undefined || scope.fdatos.PorAhoGas != null || scope.fdatos.PorAhoGas != '') {
                 scope.fdatos.PorAhoTot = Math.max(parseFloat(scope.fdatos.PorAhoEle), 0) + Math.max(parseFloat(scope.fdatos.PorAhoGas), 0);
                 //scope.fdatos.PorAhoTot = Math.max(parseInt(scope.fdatos.PorAhoEle).toFixed(2)) + Math.max(parseInt(scope.fdatos.PorAhoGas).toFixed(2));
             }
             if (scope.fdatos.PorAhoGas == undefined || scope.fdatos.PorAhoGas == null || scope.fdatos.PorAhoGas == '') {
                 scope.fdatos.PorAhoTot = scope.fdatos.PorAhoEle;
             }
         }
         if (metodo == 13) {
             if (object != undefined) {
                 numero = object;
                 if (!/^([.0-9])*$/.test(numero))
                     scope.fdatos.Consumo = numero.substring(0, numero.length - 1);
             }
         }
         if (metodo == 14) {
             if (object != undefined) {
                 numero = object;
                 if (!/^([.0-9])*$/.test(numero))
                     scope.fdatos.CauDia = numero.substring(0, numero.length - 1);
             }
         }
         if (metodo == 15) {
             if (object != undefined) {
                 numero = object;
                 if (!/^([.0-9])*$/.test(numero))
                     scope.fdatos.ImpAhoGas = numero.substring(0, numero.length - 1);
             }
             if (scope.fdatos.ImpAhoEle != undefined || scope.fdatos.ImpAhoEle != null || scope.fdatos.ImpAhoEle != '' && scope.fdatos.ImpAhoGas != undefined || scope.fdatos.ImpAhoGas != null || scope.fdatos.ImpAhoGas != '') {
                 scope.fdatos.ImpAhoTot = Math.max(parseFloat(scope.fdatos.ImpAhoEle), 0) + Math.max(parseFloat(scope.fdatos.ImpAhoGas), 0);
                 //scope.fdatos.ImpAhoTot = Math.max(parseInt(scope.fdatos.ImpAhoEle).toFixed(2)) + Math.max(parseInt(scope.fdatos.ImpAhoGas).toFixed(2));
             }
             if (scope.fdatos.ImpAhoEle == undefined || scope.fdatos.ImpAhoEle == null || scope.fdatos.ImpAhoEle == '') {
                 scope.fdatos.ImpAhoTot = scope.fdatos.ImpAhoGas;
             }

         }
         if (metodo == 16) {
             if (object != undefined) {
                 numero = object;
                 if (!/^([.0-9])*$/.test(numero))
                     scope.fdatos.PorAhoGas = numero.substring(0, numero.length - 1);
             }
             if (scope.fdatos.PorAhoEle != undefined || scope.fdatos.PorAhoEle != null || scope.fdatos.PorAhoEle != '' && scope.fdatos.PorAhoGas != undefined || scope.fdatos.PorAhoGas != null || scope.fdatos.PorAhoGas != '') {
                 scope.fdatos.PorAhoTot = Math.max(parseFloat(scope.fdatos.PorAhoEle), 0) + Math.max(parseFloat(scope.fdatos.PorAhoGas), 0);
                 //scope.fdatos.PorAhoTot = Math.max(parseInt(scope.fdatos.PorAhoEle).toFixed(2)) + Math.max(parseInt(scope.fdatos.PorAhoGas).toFixed(2));
             }
             if (scope.fdatos.PorAhoEle == undefined || scope.fdatos.PorAhoEle == null || scope.fdatos.PorAhoEle == '') {
                 scope.fdatos.PorAhoTot = scope.fdatos.PorAhoGas;
             }
         }
         if (metodo == 17) {
            if (object != undefined){
                numero = object;
                if (!/^([/0-9])*$/.test(numero))
                    scope.FecFirmCon = numero.substring(0, numero.length - 1);
            }            
        }
        if (metodo == 18) {
            if (object != undefined){
                numero = object;
                if (!/^([/0-9])*$/.test(numero))
                    scope.FecVenCon = numero.substring(0, numero.length - 1);
            }           
        }
        if (metodo == 19) {
            if (object != undefined){
                numero = object;
                if (!/^([/0-9])*$/.test(numero))
                    scope.FecAct = numero.substring(0, numero.length - 1);
            }           
        }
    }       
    scope.blurfechachange = function()
    {
        scope.FecIniCon = document.getElementById("FecIniCon").value;
        if (scope.fdatos.DurCon != undefined && scope.FecIniCon.length==10) {
            $('#FecIniCon').on('changeDate', function()
            {
                scope.calcular_vencimiento();
            });
        }

    }
    scope.filtrar_propuesta_contratos = function() 
    {
        
        for (var i = 0; i < scope.List_Propuestas_Comerciales.length; i++) {
            if (scope.List_Propuestas_Comerciales[i].CodProCom == scope.fdatos.CodProCom) 
            {
                //console.log(scope.List_Propuestas_Comerciales[i]);
                scope.fdatos.TipProCom=scope.List_Propuestas_Comerciales[i].TipProCom;
                scope.FecProCom = scope.List_Propuestas_Comerciales[i].FecProCom;
                scope.RefProCom = scope.List_Propuestas_Comerciales[i].RefProCom;
                if(scope.List_Propuestas_Comerciales[i].NumCifCom==null||scope.List_Propuestas_Comerciales[i].NumCifCom==undefined||scope.List_Propuestas_Comerciales[i].NumCifCom=='')
                {
                    scope.List_Propuestas_Comerciales[i].NumCifCom='S/I';
                }
                else
                {
                    scope.List_Propuestas_Comerciales[i].NumCifCom=scope.List_Propuestas_Comerciales[i].NumCifCom;
                }
                scope.CodCom = scope.List_Propuestas_Comerciales[i].RazSocCom;
                scope.CodPro = scope.List_Propuestas_Comerciales[i].DesProducto;
                scope.CodAnePro = scope.List_Propuestas_Comerciales[i].DesAnePro;
                scope.TipPre = scope.List_Propuestas_Comerciales[i].TipPre;
                scope.CorpoGo = scope.List_Propuestas_Comerciales[i].CorpoGo;
                if(scope.List_Propuestas_Comerciales[i].TipProCom==1)
                {
                    scope.GetdetallePropuestaContratos(scope.List_Propuestas_Comerciales[i].TipProCom,scope.List_Propuestas_Comerciales[i].CodProComCli);
                }
                else if(scope.List_Propuestas_Comerciales[i].TipProCom==2)
                {
                    scope.GetdetallePropuestaContratos(scope.List_Propuestas_Comerciales[i].TipProCom,scope.List_Propuestas_Comerciales[i].CodProComCli);
                }
                else if(scope.List_Propuestas_Comerciales[i].TipProCom==3)
                {
                    scope.GetdetallePropuestaContratos(scope.List_Propuestas_Comerciales[i].TipProCom,scope.List_Propuestas_Comerciales[i].CodProComCli);
                }

                /*
                scope.DirPunSum = scope.List_Propuestas_Comerciales[i].DirPunSum + " " + scope.List_Propuestas_Comerciales[i].BloPunSum;
                scope.EscPlaPuerPunSum = scope.List_Propuestas_Comerciales[i].EscPunSum + " " + scope.List_Propuestas_Comerciales[i].PlaPunSum + " " + scope.List_Propuestas_Comerciales[i].PuePunSum;
                scope.DesLocPunSum = scope.List_Propuestas_Comerciales[i].DesLoc;
                scope.DesLocPunSum = scope.List_Propuestas_Comerciales[i].DesLoc;
                scope.DesProPunSum = scope.List_Propuestas_Comerciales[i].DesPro;
                
                scope.CodCupGas = scope.List_Propuestas_Comerciales[i].CupsGas;
                scope.CodTarGas = scope.List_Propuestas_Comerciales[i].NomTarGas;
                scope.Consumo = scope.List_Propuestas_Comerciales[i].Consumo;
                scope.CauDia = scope.List_Propuestas_Comerciales[i].CauDia;
                
                if (scope.List_Propuestas_Comerciales[i].CanPerTar == null) {
                    scope.CanPerEle = 6;
                } else {
                    scope.CanPerEle = scope.List_Propuestas_Comerciales[i].CanPerTar;
                }*/



            }
        }
    }
    scope.GetdetallePropuestaContratos=function(TipProCom,CodProComCli)
    {
        console.log('Tipo Propuesta: '+TipProCom);
        console.log('Código del Detalle CUPs: '+CodProComCli);
        $("#DetallesCUPs").removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url=base_urlHome()+"api/Contratos/GetDetallesCUPsTipProCom/TipProCom/"+TipProCom+"/CodProComCli/"+CodProComCli;
        $http.get(url).then(function(result)
        {
            $("#DetallesCUPs").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if(result.data.status==200 && result.data.statusText=="CUPs")
            {
            	if(TipProCom==1)
                {
                    angular.forEach(result.data.BuscarDetallesCUPs,function(CUPs)
                    {
                        if(CUPs.CanPerTar==null || CUPs.CanPerTar==0)
                        {
                            scope.CanPerEle=6;
                        }
                        else
                        {
                            scope.CanPerEle=CUPs.CanPerTar;
                        }
                        if(CUPs.TipServ==1)
                        {                            
                            scope.CodCupsEleNum=CUPs.CodCups;
                            scope.CodProComCli=CUPs.CodProComCli;
                            scope.CodProComCup=CUPs.CodProComCup;
                            scope.CodCupSEle=CUPs.CUPsName;
                            scope.CodTarEle=CUPs.NomTar;
                            scope.PotConP1 = CUPs.PotConP1;
                            scope.PotConP2 = CUPs.PotConP2;
                            scope.PotConP3 = CUPs.PotConP3;
                            scope.PotConP4 = CUPs.PotConP4;
                            scope.PotConP5 = CUPs.PotConP5;
                            scope.PotConP6 = CUPs.PotConP6;
                            scope.ConCups=CUPs.ConCUPs;
                            scope.FecVenCUPs_Ele=CUPs.FecVenCUPs;
                            scope.FecActCUPs_Ele=CUPs.FecActCUPs;
                            $('.FecVenCUPs_Ele').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.FecVenCUPs_Ele);
                            $('.FecActCUPs_Ele').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.FecActCUPs_Ele);
                            scope.TipServ=CUPs.TipServ;
                            
                        }
                        if(CUPs.TipServ==2)
                        {
                            scope.CodCupsGasNum=CUPs.CodCups;
                            scope.CodProComCli=CUPs.CodProComCli;
                            scope.CodProComCup=CUPs.CodProComCup;
                            scope.CodCupGas = CUPs.CUPsName;
                            scope.CodTarGas = CUPs.NomTar;
                            scope.Consumo = CUPs.ConCUPs;
                            scope.CauDia = CUPs.CauDia;
                            scope.FecVenCUPs_Gas=CUPs.FecVenCUPs;
                            scope.FecActCUPs_Gas=CUPs.FecActCUPs;
                            $('.FecVenCUPs_Gas').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.FecVenCUPs_Ele);
                            $('.FecActCUPs_Gas').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.FecActCUPs_Ele);
                            scope.TipServ=CUPs.TipServ;
                        }
                        scope.DirPunSum = CUPs.DirPunSum+" "+CUPs.NomViaPunSum+" "+CUPs.NumViaPunSum+" "+CUPs.BloPunSum;
                        scope.DesLocPunSum=CUPs.DesLoc;
                        scope.DesProPunSum=CUPs.DesPro;
                        scope.CPLocPunSum=CUPs.CPLocSoc;
                        scope.EscPlaPuerPunSum=CUPs.EscPunSum+" "+CUPs.PlaPunSum+" "+CUPs.PuePunSum;
                       
                    }); 

                }
                else if(TipProCom==2)
                {
                    scope.fdatos.detalleCUPs=result.data.BuscarDetallesCUPs;
                }
                else if(TipProCom==3)
                {
                    scope.fdatos.detalleCUPs=result.data.BuscarDetallesCUPs;
                }
                else
                {
                	scope.toast('error','Error en Tipo de Propuesta Comercial','Error');
                	scope.fdatos.detalleCUPs=[];
                }
            }
            if(result.data.status==404 && result.data.statusText=="Error")
            {
            	scope.toast('error','No se encontraron CUPs para este contrato','Error');
            	
            	scope.fdatos.detalleCUPs=[];
            	console.log(scope.fdatos.detalleCUPs);
            }
        },function(error)
        {
            $("#DetallesCUPs").removeClass("loader loader-default is-active").addClass("loader loader-default"); 
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
    scope.validar_fecha=function(FecActCUPs,index,dato,metodo)
    {
    	console.log(FecActCUPs);
    	console.log(index);
    	console.log(dato);

        if(metodo==1)
        {
            if (FecActCUPs != undefined) {
                numero = FecActCUPs;
                if (!/^([/0-9])*$/.test(numero))
                    scope.fdatos.detalleCUPs[index].FecActCUPs = numero.substring(0, numero.length - 1);
            }
            var FecActCUPs = document.getElementById("FecActCUPs_"+index);
            var id = FecActCUPs.getAttribute("id");
            console.log(id);
        }
        else if(metodo==2)
        {
            if (FecVenCUPs != undefined) {
                numero = FecVenCUPs;
                if (!/^([/0-9])*$/.test(numero))
                    scope.fdatos.detalleCUPs[index].FecVenCUPs = numero.substring(0, numero.length - 1);
            }
            var FecVenCUPs = document.getElementById("FecActCUPs_"+index);
            var id = FecVenCUPs.getAttribute("id");
            console.log(id);
        }
    	

    }
    scope.regresar = function() {
        Swal.fire({
            title: "Estás seguro de regresar y no realizar los cambios?",
            type: "question",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: "OK"
        }).then(function(t) {
            if (t.value == true) {
                location.href = "#/Contratos";
            } else {
                console.log('Cancelando ando...');
            }
        });
    }
    $scope.updloadfotocopia = function() {
        var file = $scope.file_fotocopia;
        upload.uploadFile(file, name).then(function(res) {
            //console.log(res);
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
    $scope.submitFormContratos = function(event) 
    {
        if (scope.fdatos.tipo == 'nuevo') {
            var titulo = 'Guardando';
            var texto = '¿Seguro de grabar el contrato?';
            var response = 'Contrato registrado de forma correcta';
        }
        if (scope.fdatos.tipo == 'ver' || scope.fdatos.tipo == 'editar') {
            var titulo = 'Actualizando';
            var texto = '¿Seguro de actualizar el contrato?';
            var response = 'Contrato actualizado de forma correcta';
        }

        if (!scope.validar_campos_contratos()) {
            return false;
        }
        //let archivos_fotocopia = $archivofotocopia.files;
        //if ($archivofotocopia.files.length > 0) 
        //{
           // var tipo_file = ($archivofotocopia.files[0].type).split("/");
            //$archivofotocopia.files[0].type;
            //$scope.updloadfotocopia();
            //scope.fdatos.DocConRut = 'documentos/' + $archivofotocopia.files[0].name;
            /*if ($archivofotocopia.files[0].type == "application/pdf") {
                console.log('Fichero correcto');
                var tipo_file = ($archivofotocopia.files[0].type).split("/");
                $archivofotocopia.files[0].type;
                $scope.updloadfotocopia();
                scope.fdatos.DocConRut = 'documentos/' + $archivofotocopia.files[0].name;
            } else {
                scope.toast('error','Error en fichero, el formato debe ser PDF','Error');
                scope.fdatos.DocConRut = null;
                document.getElementById('file_fotocopia').value = '';
                $('#file_fotocopia1').html('');
                return false;
            }*/
        //}// else {

            //if (scope.fdatos.DocConRut != null) {
              //  scope.fdatos.DocConRut = scope.fdatos.DocConRut;
           // } else {
             //   scope.fdatos.DocConRut = null;
           // }

       // }
        console.log(scope.fdatos);
        Swal.fire({
            title: titulo,
            text: texto,
            type: "question",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: "OK!"
        }).then(function(t) {
            if (t.value == true) {
                $("#" + titulo).removeClass("loader loader-default").addClass("loader loader-default is-active");
                var url = base_urlHome() + "api/Contratos/registrar_contratos/";
                $http.post(url, scope.fdatos).then(function(result) {
                    $("#" + titulo).removeClass("loader loader-default is-active").addClass("loader loader-default");
                    //scope.nIDfdatos = result.data.CodAnePro;
                    if (result.data != false) {

                        if (result.data.status == 200 && result.data.statusText == 'OK') {
                            scope.toast('success',result.data.menssage,titulo);
                            document.getElementById('file_fotocopia').value = '';
                            $('#file_fotocopia1').html('');
                            if(result.data.objSalida.TipProCom==1 || result.data.objSalida.TipProCom==2)
                            {
                               location.href = "#/Edit_Contrato/"+result.data.objSalida.CodCli+"/"+result.data.objSalida.CodConCom+"/"+result.data.objSalida.CodProCom+"/"+result.data.objSalida.tipo;
                            }
                            if(result.data.objSalida.TipProCom==3)
                            {
                               //location.href = "#/Edit_Contrato/"+result.data.objSalida.CodCli+"/"+result.data.objSalida.CodConCom+"/"+result.data.objSalida.CodProCom+"/"+result.data.objSalida.tipo+"/"+3;
                               location.href = "#/Edit_Contrato/"+result.data.objSalida.CodCli+"/"+result.data.objSalida.CodConCom+"/"+result.data.objSalida.CodProCom+"/"+result.data.objSalida.tipo;
                            
                            }
                        } 
                        if (result.data.status == false && result.data.statusText == 'Fecha') {
                            scope.toast('error',result.data.menssage,titulo);
                            document.getElementById('file_fotocopia').value = '';
                            $('#file_fotocopia1').html('');
                            if(result.data.objSalida.TipProCom==1 || result.data.objSalida.TipProCom==2)
                            { 
                               location.href = "#/Edit_Contrato/"+result.data.objSalida.CodCli+"/"+result.data.objSalida.CodConCom+"/"+result.data.objSalida.CodProCom+"/"+result.data.objSalida.tipo;
                            } 
                            if(result.data.objSalida.TipProCom==3)
                            {
                               location.href = "#/Edit_Contrato/"+result.data.objSalida.CodCli+"/"+result.data.objSalida.CodConCom+"/"+result.data.objSalida.CodProCom+"/"+result.data.objSalida.tipo;
                            //location.href = "#/Edit_Contrato/"+result.data.objSalida.CodCli+"/"+result.data.objSalida.CodConCom+"/"+result.data.objSalida.CodProCom+"/"+result.data.objSalida.tipo+"/"+3;
                            }                        
                        } 
                    } else {
                      scope.toast('error','No se ha completado la operación, intente nuevamente','');
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
    scope.validar_campos_contratos = function() 
    {
        resultado = true;
        if (!scope.fdatos.CodProCom > 0) {
          scope.toast('error','Debe seleccionar una Propuesta Comercial.','');
            return false;
        }
        /*var FecIniCon1 = document.getElementById("FecIniCon").value;
        scope.FecIniCon = FecIniCon1;
        if (scope.FecIniCon == null || scope.FecIniCon == undefined || scope.FecIniCon == '') {
          scope.toast('error','La Fecha de Inicio es requerida','');
            return false;
        } else {
            var FecIniCon = (scope.FecIniCon).split("/");
            if (FecIniCon.length < 3) {
              scope.toast('error','El formato Fecha de Inicio correcto es DD/MM/YYYY','');
                event.preventDefault();
                return false;
            } else {
                if (FecIniCon[0].length > 2 || FecIniCon[0].length < 2) {
                  scope.toast('error','Error en Día, debe introducir dos números','');
                    event.preventDefault();
                    return false;
                }
                if (FecIniCon[1].length > 2 || FecIniCon[1].length < 2) {
                  scope.toast('error','Error en Mes, debe introducir dos números','');
                    event.preventDefault();
                    return false;
                }
                if (FecIniCon[2].length < 4 || FecIniCon[2].length > 4) {
                  scope.toast('error','Error en Año, debe introducir cuatro números','');
                    event.preventDefault();
                    return false;
                }
                valuesStart = scope.FecIniCon.split("/");
                scope.fdatos.FecIniCon = FecIniCon[2] + "-" + FecIniCon[1] + "-" + FecIniCon[0];
            }
        }*/
        scope.fdatos.FecIniCon =null;
        scope.fdatos.DurCon=null;
        scope.fdatos.FecVenCon =null;
        /*if (!scope.fdatos.DurCon > 0) {
          scope.toast('error','La Duración del Contrato es requerida','');
            return false;
        }
        var FecVenCon1 = document.getElementById("FecVenCon").value;
        scope.FecVenCon = FecVenCon1;
        
        if (scope.FecVenCon == null || scope.FecVenCon == undefined || scope.FecVenCon == '') {
          scope.toast('error','La Fecha de Vencimiento es requerida','');
            return false;
        } else {
            var FecVenCon = (scope.FecVenCon).split("/");
            if (FecVenCon.length < 3) {
              scope.toast('error','El formato Fecha de Vencimiento correcto es DD/MM/YYYY','');
                event.preventDefault();
                return false;
            } else {
                if (FecVenCon[0].length > 2 || FecVenCon[0].length < 2) {
                  scope.toast('error','Error en Día, debe introducir dos números','');
                    event.preventDefault();
                    return false;
                }
                if (FecVenCon[1].length > 2 || FecVenCon[1].length < 2) {
                  scope.toast('error','Error en Mes, debe introducir dos números','');
                    event.preventDefault();
                    return false;
                }
                if (FecVenCon[2].length < 4 || FecVenCon[2].length > 4) {
                  scope.toast('error','Error en Año, debe introducir cuatro números','');
                    event.preventDefault();
                    return false;
                }
                valuesStart = scope.FecVenCon.split("/");
                scope.fdatos.FecVenCon = FecVenCon[2] + "-" + FecVenCon[1] + "-" + FecVenCon[0];
            }
        }*/
        /*if(scope.fdatos.tipo=='editar')
        {
            var FecFirmCon1 = document.getElementById("FecFirmCon").value;
            scope.FecFirmCon = FecFirmCon1;
            if (scope.FecFirmCon == null || scope.FecFirmCon == undefined || scope.FecFirmCon == '') {
              scope.toast('error','La Fecha de Firma es requerida','');
                return false;
            } else {
                var FecFirmCon = (scope.FecFirmCon).split("/");
                if (FecFirmCon.length < 3) {
                  scope.toast('error','El formato Fecha de Inicio correcto es DD/MM/YYYY','');
                    event.preventDefault();
                    return false;
                } else {
                    if (FecFirmCon[0].length > 2 || FecFirmCon[0].length < 2) {
                      scope.toast('error','Error en Día, debe introducir dos números','');
                        event.preventDefault();
                        return false;
                    }
                    if (FecFirmCon[1].length > 2 || FecFirmCon[1].length < 2) {
                      scope.toast('error','Error en Mes, debe introducir dos números','');
                        event.preventDefault();
                        return false;
                    }
                    if (FecFirmCon[2].length < 4 || FecFirmCon[2].length > 4) {
                      scope.toast('error','Error en Año, debe introducir cuatro números','');
                        event.preventDefault();
                        return false;
                    }
                    valuesStart = scope.FecFirmCon.split("/");
                    scope.fdatos.FecFirmCon = FecFirmCon[2] + "-" + FecFirmCon[1] + "-" + FecFirmCon[0];
                }
            }
        }
        var FecAct1 = document.getElementById("FecAct").value;
            scope.FecAct = FecAct1;
            if (scope.FecAct == null || scope.FecAct == undefined || scope.FecAct == '') {
              scope.fdatos.FecAct =null;
            } else {
                var FecAct = (scope.FecAct).split("/");
                if (FecAct.length < 3) {
                  scope.toast('error','El formato Fecha de Inicio correcto es DD/MM/YYYY','');
                    event.preventDefault();
                    return false;
                } else {
                    if (FecAct[0].length > 2 || FecAct[0].length < 2) {
                      scope.toast('error','Error en Día, debe introducir dos números','');
                        event.preventDefault();
                        return false;
                    }
                    if (FecAct[1].length > 2 || FecAct[1].length < 2) {
                      scope.toast('error','Error en Mes, debe introducir dos números','');
                        event.preventDefault();
                        return false;
                    }
                    if (FecAct[2].length < 4 || FecAct[2].length > 4) {
                      scope.toast('error','Error en Año, debe introducir cuatro números','');
                        event.preventDefault();
                        return false;
                    }
                    valuesStart = scope.FecAct.split("/");
                    scope.fdatos.FecAct = FecAct[2] + "-" + FecAct[1] + "-" + FecAct[0];
                }
            }*/
        scope.fdatos.FecFirmCon=null;
        scope.fdatos.FecAct=null;
        if (scope.fdatos.ObsCon == null || scope.fdatos.ObsCon == undefined || scope.fdatos.ObsCon == '') {
            scope.fdatos.ObsCon = null;
        } else {
            scope.fdatos.ObsCon = scope.fdatos.ObsCon;
        }
        /*for(var i=0; i<scope.fdatos.detalleCUPs.length; i++) 
		{
			if (scope.fdatos.detalleCUPs[i].FecActCUPs==null||scope.fdatos.detalleCUPs[i].FecActCUPs=='') 
			{
				//scope.toast('error','El CUPs '+scope.fdatos.detalleCUPs[i].CUPsName+' no tiene fecha de activación debe colocarla','Fecha Activación');
				scope.fdatos.detalleCUPs[i].FecActCUPs=null;
				i=scope.fdatos.detalleCUPs.length;
				//resultado = true;
			}						
		}*/
        if(scope.fdatos.TipProCom==1)
        {
            scope.fdatos.detalleCUPs = []; 
            if(scope.CodCupsEleNum!=null || scope.CodCupsEleNum!=undefined)
            {
                var FecActCUPs_Ele = document.getElementById("FecActCUPs_Ele").value;
                var FecVenCUPs_Ele = document.getElementById("FecVenCUPs_Ele").value;
        //FecActCUPs_Ele

                scope.fdatos.detalleCUPs.push({CodProComCup: scope.CodProComCup,CodCups:scope.CodCupsEleNum,CodProComCli: scope.CodProComCli,
                FecActCUPs:FecActCUPs_Ele,FecVenCUPs:FecVenCUPs_Ele,TipServ:scope.TipServ});
            }
            if(scope.CodCupsGasNum!=null || scope.CodCupsGasNum!=undefined)
            {                
                var FecVenCUPs_Gas = document.getElementById("FecVenCUPs_Gas").value;
                var FecActCUPs_Gas = document.getElementById("FecActCUPs_Gas").value;
                scope.fdatos.detalleCUPs.push({CodProComCup: scope.CodProComCup,CodCups:scope.CodCupsGasNum,CodProComCli: scope.CodProComCli,
                FecActCUPs:FecActCUPs_Gas,FecVenCUPs:FecVenCUPs_Gas,TipServ:scope.TipServ});               
            }
        }

		for(var i=0; i<scope.fdatos.detalleCUPs.length; i++) 
		{
			
            //console.log(scope.fdatos.detalleCUPs[i].FecActCUPs);
            if(scope.fdatos.detalleCUPs[i].FecActCUPs==null || scope.fdatos.detalleCUPs[i].FecActCUPs==""|| scope.fdatos.detalleCUPs[i].FecActCUPs==undefined)
            {
                scope.fdatos.detalleCUPs[i].FecActCUPs=null;
            }
            else
            {
                //scope.toast('success','Formato de Fecha de Activación del CUPs '+scope.fdatos.detalleCUPs[i].CUPsName+' DD/MM/YYYY.','');
                var FecActCUPs = (scope.fdatos.detalleCUPs[i].FecActCUPs).split("/");
                //console.log(FecActCUPs);
                if (FecActCUPs.length < 3) 
                {
                    scope.toast('error','El Formato de Fecha de Activación del CUPs '+scope.fdatos.detalleCUPs[i].CUPsName+' debe Ser EJ: DD/MM/YYYY.','');
                    i=scope.fdatos.detalleCUPs.length;
                    return false;
                }
                else{

                    if (FecActCUPs[0].length > 2 || FecActCUPs[0].length < 2 || FecActCUPs[0] > 31) {
                        scope.toast('error','Por Favor Corrija el Formato del dia en la Fecha de Activación en el CUPs '+scope.fdatos.detalleCUPs[i].CUPsName+ ' deben ser 2 números solamente. EJ: 01','');
                        i=scope.fdatos.detalleCUPs.length;
                        return false;
                    }
                    if (FecActCUPs[1].length > 2 || FecActCUPs[1].length < 2 || FecActCUPs[1] > 12) {
                        scope.toast('error','Por Favor Corrija el Formato del mes de la Fecha de Activación en el CUPs '+scope.fdatos.detalleCUPs[i].CUPsName+ ' deben ser 2 números solamente. EJ: 01','');
                        i=scope.fdatos.detalleCUPs.length;
                        return false;
                    }
                    if (FecActCUPs[2].length < 4 || FecActCUPs[2].length > 4) {
                        scope.toast('error','Por Favor Corrija el Formato del año en la Fecha de Activación en el CUPs '+scope.fdatos.detalleCUPs[i].CUPsName+ ' Ya que deben ser 4 números solamente.','');
                        i=scope.fdatos.detalleCUPs.length;
                        return false;
                    }
                }    
            }				
		}
        console.log(scope.fdatos.detalleCUPs);
        if (resultado == false) {
            //quiere decir que al menos un renglon no paso la validacion
            return false;
        }
        return true;
    }
    scope.validar_campos_asignar_propuestas = function() {
         resultado = true;
         var FecProCom1 = document.getElementById("FecProCom").value;
         scope.FecProCom = FecProCom1;
         if (scope.FecProCom == null || scope.FecProCom == undefined || scope.FecProCom == '') {
           scope.toast('error','La Fecha de la Propuesta es requerida','');
             return false;
         } else {
             var FecProCom = (scope.FecProCom).split("/");
             if (FecProCom.length < 3) {
                scope.toast('error','El Formato de Fecha de la Propuesta debe Ser EJ: DD/MM/YYYY.','');
                 event.preventDefault();
                 return false;
             } else {
                 if (FecProCom[0].length > 2 || FecProCom[0].length < 2) {
                   scope.toast('error','Por Favor Corrija el Formato del dia en la Fecha de la Propuesta deben ser 2 números solamente. EJ: 01','');
                   event.preventDefault();
                     return false;
                 }
                 if (FecProCom[1].length > 2 || FecProCom[1].length < 2) {
                   scope.toast('error','Por Favor Corrija el Formato del mes de la Fecha de la Propuesta deben ser 2 números solamente. EJ: 01','');
                   event.preventDefault();
                     return false;
                 }
                 if (FecProCom[2].length < 4 || FecProCom[2].length > 4) {
                    scope.toast('error','Por Favor Corrija el Formato del ano en la Fecha de la Propuesta Ya que deben ser 4 números solamente. EJ: 1999','');
                    event.preventDefault();
                    return false;
                 }
                 valuesStart = scope.FecProCom.split("/");
                 valuesEnd = scope.Fecha_Propuesta.split("/");
                 // Verificamos que la fecha no sea posterior a la actual
                 var dateStart = new Date(valuesStart[2], (valuesStart[1] - 1), valuesStart[0]);
                 var dateEnd = new Date(valuesEnd[2], (valuesEnd[1] - 1), valuesEnd[0]);
                 if (dateStart > dateEnd) {
                   scope.toast('error',"La Fecha de la Propuesta no puede ser mayor al " + scope.Fecha_Propuesta + " Por Favor Verifique he intente nuevamente.",'');
                   return false;
                 }
                 scope.fdatos.FecProCom = FecProCom[2] + "-" + FecProCom[1] + "-" + FecProCom[0];
             }
         }
         if (scope.fdatos.RefProCom == null || scope.fdatos.RefProCom == undefined || scope.fdatos.RefProCom == '') {
           scope.toast('error','El número de la propuesta es requerido.','');
             return false;
         }

         if (!scope.fdatos.EstProCom > 0) {
           scope.toast('error','El Estatus de la propuesta es requerido.','');
             return false;
         }

         if (!scope.fdatos.CodPunSum > 0) {
           scope.toast('error','Debe seleccionar un punto de suministro.','');
             return false;
         }
         if (!scope.fdatos.CodCupSEle > 0 && !scope.fdatos.CodCupGas > 0) {
           scope.toast('error','Debe seleccionar un Tipo de CUPs Para generer una propuesta comercial','');
             return false;
         }
         if (scope.fdatos.CodCupSEle > 0) {
             if (!scope.fdatos.CodTarEle > 0) {
                scope.toast('error','Debe seleccionar una Tarifa Eléctrica.','');
                 return false;
             }

             if (scope.CanPerEle == 1) {
                 if (scope.fdatos.PotConP1 == null || scope.fdatos.PotConP1 == undefined || scope.fdatos.PotConP1 == '') {
                    scope.toast('error','Debe indicar la Potencia 1','');
                    return false;
                 }
             }
             if (scope.CanPerEle == 2) {
                 if (scope.fdatos.PotConP1 == null || scope.fdatos.PotConP1 == undefined || scope.fdatos.PotConP1 == '') {
                   scope.toast('error','Debe indicar la Potencia 1','');
                     return false;
                 }
                 if (scope.fdatos.PotConP2 == null || scope.fdatos.PotConP2 == undefined || scope.fdatos.PotConP2 == '') {
                   scope.toast('error','Debe indicar la Potencia 2','');
                   return false;
                 }
             }
             if (scope.CanPerEle == 3) {
                 if (scope.fdatos.PotConP1 == null || scope.fdatos.PotConP1 == undefined || scope.fdatos.PotConP1 == '') {
                   scope.toast('error','Debe indicar la Potencia 1','');
                    return false;
                 }
                 if (scope.fdatos.PotConP2 == null || scope.fdatos.PotConP2 == undefined || scope.fdatos.PotConP2 == '') {
                   scope.toast('error','Debe indicar la Potencia 2','');
                   return false;
                 }
                 if (scope.fdatos.PotConP3 == null || scope.fdatos.PotConP3 == undefined || scope.fdatos.PotConP3 == '') {
                   scope.toast('error','Debe indicar la Potencia 3','');
                   return false;
                 }
             }
             if (scope.CanPerEle == 4) {
                 if (scope.fdatos.PotConP1 == null || scope.fdatos.PotConP1 == undefined || scope.fdatos.PotConP1 == '') {
                   scope.toast('error','Debe indicar la Potencia 1','');
                     return false;
                 }
                 if (scope.fdatos.PotConP2 == null || scope.fdatos.PotConP2 == undefined || scope.fdatos.PotConP2 == '') {
                   scope.toast('error','Debe indicar la Potencia 2','');
                     return false;
                 }
                 if (scope.fdatos.PotConP3 == null || scope.fdatos.PotConP3 == undefined || scope.fdatos.PotConP3 == '') {
                   scope.toast('error','Debe indicar la Potencia 3','');
                     return false;
                 }
                 if (scope.fdatos.PotConP4 == null || scope.fdatos.PotConP4 == undefined || scope.fdatos.PotConP4 == '') {
                   scope.toast('error','Debe indicar la Potencia 4','');
                     return false;
                 }
             }
             if (scope.CanPerEle == 5) {
                 if (scope.fdatos.PotConP1 == null || scope.fdatos.PotConP1 == undefined || scope.fdatos.PotConP1 == '') {
                   scope.toast('error','Debe indicar la Potencia 1','');
                   
                     return false;
                 }
                 if (scope.fdatos.PotConP2 == null || scope.fdatos.PotConP2 == undefined || scope.fdatos.PotConP2 == '') {
                   scope.toast('error','Debe indicar la Potencia 2','');
                     return false;
                 }
                 if (scope.fdatos.PotConP3 == null || scope.fdatos.PotConP3 == undefined || scope.fdatos.PotConP3 == '') {
                   scope.toast('error','Debe indicar la Potencia 3','');
                     return false;
                 }
                 if (scope.fdatos.PotConP4 == null || scope.fdatos.PotConP4 == undefined || scope.fdatos.PotConP4 == '') {
                   scope.toast('error','Debe indicar la Potencia 4','');
                   return false;
                 }
                 if (scope.fdatos.PotConP5 == null || scope.fdatos.PotConP5 == undefined || scope.fdatos.PotConP5 == '') {
                   scope.toast('error','Debe indicar la Potencia 5','');
                     return false;
                 }
             }
             if (scope.CanPerEle == 6) {
                 if (scope.fdatos.PotConP1 == null || scope.fdatos.PotConP1 == undefined || scope.fdatos.PotConP1 == '') {
                   scope.toast('error','Debe indicar la Potencia 1','');
                     return false;
                 }
                 if (scope.fdatos.PotConP2 == null || scope.fdatos.PotConP2 == undefined || scope.fdatos.PotConP2 == '') {
                   scope.toast('error','Debe indicar la Potencia 2','');
                     return false;
                 }
                 if (scope.fdatos.PotConP3 == null || scope.fdatos.PotConP3 == undefined || scope.fdatos.PotConP3 == '') {
                   scope.toast('error','Debe indicar la Potencia 3','');
                     return false;
                 }
                 if (scope.fdatos.PotConP4 == null || scope.fdatos.PotConP4 == undefined || scope.fdatos.PotConP4 == '') {
                   scope.toast('error','Debe indicar la Potencia 4','');
                     return false;
                 }
                 if (scope.fdatos.PotConP5 == null || scope.fdatos.PotConP5 == undefined || scope.fdatos.PotConP5 == '') {
                   scope.toast('error','Debe indicar la Potencia 5','');
                     return false;
                 }
                 if (scope.fdatos.PotConP6 == null || scope.fdatos.PotConP6 == undefined || scope.fdatos.PotConP6 == '') {
                   scope.toast('error','Debe indicar la Potencia 6','');
                     return false;
                 }
             }
             if (scope.fdatos.ImpAhoEle == null || scope.fdatos.ImpAhoEle == undefined || scope.fdatos.ImpAhoEle == '') {
               scope.toast('error','Debe indicar un importe de ahorro eléctrico.','');
                 return false;
             }
             if (scope.fdatos.PorAhoEle == null || scope.fdatos.PorAhoEle == undefined || scope.fdatos.PorAhoEle == '') {
               scope.toast('error','Debe indicar un porcentaje eléctrico.','');
                 return false;
             }
             if (scope.fdatos.ObsAhoEle == null || scope.fdatos.ObsAhoEle == undefined || scope.fdatos.ObsAhoEle == '') {
                 scope.fdatos.ObsAhoEle = null;
             } else {
                 scope.fdatos.ObsAhoEle = scope.fdatos.ObsAhoEle;
             }
         } else {
             scope.fdatos.CodCupSEle = null;
             scope.fdatos.CodTarEle = null;
             scope.fdatos.PotConP1 = null;
             scope.fdatos.PotConP2 = null;
             scope.fdatos.PotConP3 = null;
             scope.fdatos.PotConP4 = null;
             scope.fdatos.PotConP5 = null;
             scope.fdatos.PotConP6 = null;
             scope.fdatos.ImpAhoEle = null;
             scope.fdatos.PorAhoEle = null;
             scope.fdatos.ObsAhoEle = null;
         }
         if (scope.fdatos.CodCupGas > 0) {
             if (!scope.fdatos.CodTarGas > 0) {
               scope.toast('error','Debe seleccionar una Tarifa de Gas.','');
                 return false;
             }
             if (scope.fdatos.Consumo == null || scope.fdatos.Consumo == undefined || scope.fdatos.Consumo == '') {
                scope.toast('error','Debe indicar un consumo.','');
                return false;
             }
             if (scope.fdatos.CauDia == null || scope.fdatos.CauDia == undefined || scope.fdatos.CauDia == '') {
                scope.toast('error','Debe indicar un Caudal Diario.','');
                return false;
             }
             if (scope.fdatos.ImpAhoGas == null || scope.fdatos.ImpAhoGas == undefined || scope.fdatos.ImpAhoGas == '') {
               scope.toast('error','Debe indicar un importe de ahorro de gas.','');
                 return false;
             }
             if (scope.fdatos.PorAhoGas == null || scope.fdatos.PorAhoGas == undefined || scope.fdatos.PorAhoGas == '') {
               scope.toast('error','Debe indicar un porcentaje de gas.','');
                 return false;
             }
             if (scope.fdatos.ObsAhoGas == null || scope.fdatos.ObsAhoGas == undefined || scope.fdatos.ObsAhoGas == '') {
                 scope.fdatos.ObsAhoGas = null;
             } else {
                 scope.fdatos.ObsAhoGas = scope.fdatos.ObsAhoGas;
             }
         } else {
             scope.fdatos.CodCupGas = null;
             scope.fdatos.CodTarGas = null;
             scope.fdatos.Consumo = null;
             scope.fdatos.CauDia = null;
             scope.fdatos.ImpAhoGas = null;
             scope.fdatos.PorAhoGas = null;
             scope.fdatos.ObsAhoGas = null;
         }
         if (!scope.fdatos.CodCom > 0) {
           scope.toast('error','','Debe seleccionar una Comercializadora.');
             return false;
         }
         if (!scope.fdatos.CodPro > 0) {
           scope.toast('error','Debe seleccionar un producto.','');
             return false;
         }
         if (!scope.fdatos.CodAnePro > 0) {
           scope.toast('error','Debe seleccionar un Anexo.','');
             return false;
         }
         if (!scope.fdatos.TipPre > 0) {
           scope.toast('error','Debe seleccionar un Tipo de Precio.','');
             return false;
         }
         if (scope.fdatos.ObsProCom == null || scope.fdatos.ObsProCom == undefined || scope.fdatos.ObsProCom == '') {
             scope.fdatos.ObsProCom = null;
         } else {
             scope.fdatos.ObsProCom = scope.fdatos.ObsProCom;
         }
         if (scope.fdatos.tipo == 'editar' || scope.fdatos.tipo == 'ver') {
             if (scope.fdatos.Apro == false && scope.fdatos.Rech == false) {
               scope.toast('error','Debe indicar si es aprobada o rechazada.','');
                 return false;
             }
         }
         if (scope.fdatos.Rech == true) {
             if (scope.fdatos.JusRecProCom == null || scope.fdatos.JusRecProCom == undefined || scope.fdatos.JusRecProCom == '') {
                scope.toast('error','Debe indicar una justificación del rechazo.','');
                return false;
             }
         } else {
             scope.fdatos.JusRecProCom = null;
         }


         if (resultado == false) {
             //quiere decir que al menos un renglon no paso la validacion
             return false;
         }
         return true;
     }
    $scope.SubmitFormAsignarPropuesta = function(event)
    {
        if (!scope.validar_campos_asignar_propuestas()) {
            return false;
        }       
        console.log(scope.fdatos);
        Swal.fire({
            title: 'Asignando Propuesta Comercial',
            text: '¿Estás seguro de asignar esta propuesta comercial es este contrato?',
            type: "question",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: "Asignar!"
        }).then(function(t) {
            if (t.value == true) 
            {
               $("#Propuesta").removeClass("loader loader-default").addClass("loader loader-default is-active");
                var url = base_urlHome() + "api/Contratos/AsignarPropuestaContrato/";
                $http.post(url, scope.fdatos).then(function(result) {
                    $("#Propuesta").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (result.data != false){
                        if (result.data.status == 200 && result.data.statusText == 'OK')
                        {
                            $("#Form_PropuestaComercial").modal('hide');
                            scope.fdatos={};
                            scope.get_list_contratos();                          
                          scope.toast('success',result.data.menssage,result.data.statusText);
                          //  Swal.fire({ title:, text: , type: "", confirmButtonColor: "#188ae2" });
                        }                        
                    }
                    else 
                    {
                      scope.toast('error','No se ha completado la operación, intente nuevamente','Error');
                    }
                }, function(error) {
                    $("#Propuesta").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
    scope.filter_DirPumSum = function(CodPunSum)
    {
        console.log(CodPunSum);
        scope.fdatos.CodCupSEle = undefined;
        scope.fdatos.CodTarEle = undefined;
        scope.fdatos.PotConP1 = undefined;
        scope.fdatos.PotConP2 = undefined;
        scope.fdatos.PotConP3 = undefined;
        scope.fdatos.PotConP4 = undefined;
        scope.fdatos.PotConP5 = undefined;
        scope.fdatos.PotConP6 = undefined;
        scope.fdatos.CodCupGas = undefined;
        scope.fdatos.CodTarGas = undefined;
        scope.fdatos.Consumo = undefined;
        scope.fdatos.CauDia = undefined;
        for (var i = 0; i < scope.List_Puntos_Suministros.length; i++) 
        {
            if (scope.List_Puntos_Suministros[i].CodPunSum == CodPunSum) 
            {
                //console.log(scope.List_Puntos_Suministros[i]);
                scope.DirPumSum = scope.List_Puntos_Suministros[i].DirPumSum;
                scope.EscPlaPuerPumSum = scope.List_Puntos_Suministros[i].EscPunSum + " " + scope.List_Puntos_Suministros[i].PlaPunSum + " " + scope.List_Puntos_Suministros[i].PuePunSum;
                scope.DesLocPumSum = scope.List_Puntos_Suministros[i].DesLoc;
                scope.DesProPumSum = scope.List_Puntos_Suministros[i].DesPro;
                scope.CPLocPumSum = scope.List_Puntos_Suministros[i].CPLocSoc;
            }
         }
         $("#CUPs").removeClass("loader loader-default").addClass("loader loader-default is-active");
         var url = base_urlHome() + "api/Contratos/Search_CUPs_Customer/CodPumSum/" + scope.fdatos.CodPunSum;
         $http.get(url).then(function(result) {
             $("#CUPs").removeClass("loader loader-default is-active").addClass("loader loader-default");

             if (result.data != false) {
                 console.log(result);
                 scope.List_CUPsEle = result.data.CUPs_Electricos;
                 scope.List_CUPs_Gas = result.data.CUPs_Gas;
             }
             if (result.data.CUPs_Electricos == false && result.data.CUPs_Gas == false) {
               scope.toast('error','El Cliente debe tener al menos un tipo de CUPs registrado para poder generar una Propuesta Comercial','CUPs');
               
             }
        }, function(error)
        {
            $("#CUPs").removeClass("loader loader-default is-active").addClass("loader loader-default");
            console.log(error);
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
     scope.filtrerCanPeriodos = function(CodTarEle) {
        console.log(CodTarEle);
        for (var i = 0; i < scope.List_TarEle.length; i++) {
            if (scope.List_TarEle[i].CodTarEle == CodTarEle) {
                scope.CanPerEle = scope.List_TarEle[i].CanPerTar;
                console.log(scope.CanPerEle);
            }
        }

     }
     scope.CUPsFilter = function(metodo, CodCUPs) {
         if (metodo == 1) {
             console.log(CodCUPs);
             for (var i = 0; i < scope.List_CUPsEle.length; i++) {
                 if (scope.List_CUPsEle[i].CodCupsEle == CodCUPs) {
                     console.log(scope.List_CUPsEle[i]);
                     scope.fdatos.CodTarEle = scope.List_CUPsEle[i].CodTarElec;
                     scope.fdatos.PotConP1 = scope.List_CUPsEle[i].PotConP1;
                     scope.fdatos.PotConP2 = scope.List_CUPsEle[i].PotConP2;
                     scope.fdatos.PotConP3 = scope.List_CUPsEle[i].PotConP3;
                     scope.fdatos.PotConP4 = scope.List_CUPsEle[i].PotConP4;
                     scope.fdatos.PotConP5 = scope.List_CUPsEle[i].PotConP5;
                     scope.fdatos.PotConP6 = scope.List_CUPsEle[i].PotConP6;
                     scope.CanPerEle = scope.List_CUPsEle[i].CanPerTar;
                 }
             }
         }
         if (metodo == 2) {
             for (var i = 0; i < scope.List_CUPs_Gas.length; i++) {
                 if (scope.List_CUPs_Gas[i].CodCupGas == CodCUPs) {
                     console.log(scope.List_CUPs_Gas[i]);
                     scope.fdatos.CodTarGas = scope.List_CUPs_Gas[i].CodTarGas;
                     scope.fdatos.Consumo = scope.List_CUPs_Gas[i].ConAnuCup;
                 }
             }
         }
     }
     scope.realizar_filtro = function(metodo, PrimaryKey) {
         var url = base_urlHome() + "api/Contratos/realizar_filtro/metodo/" + metodo + "/PrimaryKey/" + PrimaryKey;
         $http.get(url).then(function(result) {
             if (result.data != false) {
                 if (metodo == 1) {
                     scope.List_Productos = result.data;
                 }
                 if (metodo == 2) {
                     scope.List_Anexos = result.data;
                 }
                 if (metodo == 3) {
                     scope.fdatos.TipPre = result.data.TipPre;
                 }
             } else {
                 if (metodo == 1) {
                   scope.toast('error','No existen productos asignado a esta Comercializadora.','Error');
                     scope.List_Productos = [];
                     scope.List_Anexos = [];
                     scope.fdatos.CodPro = undefined;
                     scope.fdatos.CodAnePro = undefined;
                     scope.fdatos.TipPre = undefined;
                 }
                 if (metodo == 2) {
                   scope.toast('error','No existen anexos asignados a este producto.','Error');
                     scope.List_Anexos = [];
                     scope.fdatos.CodAnePro = undefined;
                     scope.fdatos.TipPre = undefined;
                 }
             }
         }, function(error) {
             console.log(error);
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
    scope.validar_opcion_contratos = function(index, opcion_select, dato) {
        //console.log('index: '+index);
        console.log('opcion: '+opcion_select);
        console.log(dato);
        scope.opcion_select[index] = undefined;
        if (opcion_select == 1) {
            location.href = "#/Ver_Contrato/" + dato.CodCli + "/" + dato.CodConCom + "/" + dato.CodProCom + "/ver";
        }
        if (opcion_select == 2) {
            location.href = "#/Edit_Contrato/" + dato.CodCli + "/" + dato.CodConCom + "/" + dato.CodProCom + "/editar";
        }
        if (opcion_select == 3) {
            
            if (dato.EstBajCon == 3)
            {
              scope.toast('error','El Contrato ya fue renovado.','Error');
                return false;
            }
            if (dato.EstBajCon == 4)
            {
              scope.toast('error','Este contrato se encuentra en proceso de renovación.','Error');
                return false;
            }

            if(dato.CodProCom==null || dato.CodProCom==0)
            {
              scope.toast('error','Este contrato no posee una propuesta comercial cargue la información de la propuesta comercial para continuar con la renovación del contrato.','Error');
              scope.fdatos={};
                scope.DirPumSum=undefined;
                scope.EscPlaPuerPumSum=undefined;
                scope.DesLocPumSum=undefined;
                scope.DesProPumSum=undefined;
                scope.CPLocPumSum=undefined;
                scope.fdatos.RenConEle=false;
                scope.fdatos.RenConGas=false;
                scope.fdatos.EstProCom='P';
                scope.fdatos.CodCli=dato.CodCli;
                scope.fdatos.CodConCom=dato.CodConCom;
                scope.RazSocCli=dato.RazSocCli;
                scope.NumCifCli=dato.NumCifCli;
                scope.disabled_status=true;
                scope.CanPerEle=6;
                var url =base_urlHome()+"api/Contratos/AsignarPropuestaContrato/CodCli/"+dato.CodCli;
                $http.get(url).then(function(result)
                {
                    if(result.data!=false)
                    {
                        scope.FecProCom=result.data.FecProCom;
                        scope.fdatos.RefProCom=result.data.RefProCom; 
                        scope.Fecha_Propuesta=result.data.FecProCom;                   
                        $('.FecProCom').datepicker({format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.fdatos.RefProCom);
                        scope.List_Puntos_Suministros=result.data.Puntos_Suministros;
                        if(scope.List_Puntos_Suministros.length==1)
                        {
                            scope.fdatos.CodPunSum=scope.List_Puntos_Suministros[0].CodPunSum;
                            scope.filter_DirPumSum(scope.fdatos.CodPunSum);
                        }
                        scope.List_TarEle=result.data.TarEle;
                        scope.List_TarGas=result.data.TarGas;
                        scope.List_Comercializadora=result.data.Comercializadoras;
                        $("#Form_PropuestaComercial").modal('show');
                    }
                    else
                    {

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
                return false;
            }           
            scope.tmodal_data = {};
            scope.tmodal_data.CodCli = dato.CodCli;
            scope.tmodal_data.CodProCom = dato.CodProCom;
            scope.tmodal_data.CodConCom = dato.CodConCom;
            scope.tmodal_data.FecConCom = dato.FecConCom;
            scope.tmodal_data.FecVenCon = dato.FecVenCon;
            scope.tmodal_data.FecIniCon = dato.FecIniCon;
            scope.tmodal_data.TipProCom=dato.TipProCom;
            scope.tmodal_data.SinMod = false;
            scope.tmodal_data.ConMod = false;
            scope.RazSocCli = dato.RazSocCli;
            scope.CodCom = dato.CodCom;
            scope.Anexo = dato.Anexo;
            if (dato.EstBajCon == 0)
            {
                console.log(scope.tmodal_data);
                var url = base_urlHome() + "api/Contratos/verificar_renovacion";
                $http.post(url, scope.tmodal_data).then(function(result)
                {
                    if (result.data!=false)
                    {
                        if (result.data.status == 201 && result.data.statusText == "Renovación Anticipada") 
                        {
                            Swal.fire({title: result.data.statusText,text: result.data.message,type: "question",
                            showCancelButton: !0,confirmButtonColor: "#31ce77",cancelButtonColor: "#f34943",
                            confirmButtonText: "Continuar!"}).then(function(t) 
                            {
                                if (t.value == true) 
                                {
                                    var FecIniCon = (dato.FecVenCon).split("/");
                                    var new_fecha= FecIniCon[1]+"/"+FecIniCon[0]+"/"+FecIniCon[2];
                                    var TuFecha = new Date(new_fecha);
                                    var numero=1;
                                    var dias = parseInt(numero);
                                    TuFecha.setDate(TuFecha.getDate() + dias);
                                    var FecIniCon1 = TuFecha.getDate() + '/' + (TuFecha.getMonth() + 1) + '/' + TuFecha.getFullYear();
                                    var FecIniConFinal=(FecIniCon1).split("/");
                                    var dia=FecIniConFinal[0];
                                    var mes=FecIniConFinal[1];
                                    var ano=FecIniConFinal[2];
                                    if(dia<10)
                                    {dia='0'+dia;}
                                    if(mes<10)
                                    {mes='0'+mes;}
                                    console.log(dia+"/"+mes+"/"+ano);
                                    scope.FecIniCon= dia+"/"+mes+"/"+ano;
                                    $('.FecIniCon').datepicker({format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.FecIniCon);     
                
                                    $("#Tipo_Renovacion").modal('show');
                                } else {
                                    event.preventDefault();
                                    console.log('Cancelando ando...');
                                }
                            });
                             //scope.toast('info',result.data.menssage,result.data.statusText);
                          //  //Swal.fire({ title: , text: , type: "info", confirmButtonColor: "#188ae2" });
                            //scope.tmodal_data = {};
                            //$("#Tipo_Renovacion").modal('hide');
                            return false;
                        }
                        if (result.data.status == 200 && result.data.statusText == "OK") {
                            scope.toast('success',result.data.message,'');
                            var FecIniCon = (dato.FecVenCon).split("/");
                            var new_fecha= FecIniCon[1]+"/"+FecIniCon[0]+"/"+FecIniCon[2];
                            var TuFecha = new Date(new_fecha);
                            var numero=1;
                            var dias = parseInt(numero);
                            TuFecha.setDate(TuFecha.getDate() + dias);
                            var FecIniCon1 = TuFecha.getDate() + '/' + (TuFecha.getMonth() + 1) + '/' + TuFecha.getFullYear();
                            var FecIniConFinal=(FecIniCon1).split("/");
                            var dia=FecIniConFinal[0];
                            var mes=FecIniConFinal[1];
                            var ano=FecIniConFinal[2];
                            if(dia<10)
                            {dia='0'+dia;}
                            if(mes<10)
                            {mes='0'+mes;}
                            console.log(dia+"/"+mes+"/"+ano);
                            scope.FecIniCon= dia+"/"+mes+"/"+ano;
                            $('.FecIniCon').datepicker({format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.FecIniCon);     
                            $("#Tipo_Renovacion").modal('show');
                            return false;
                        }
                    } else {
                      scope.toast('error','Error en el proceso intente nuevamente','Error General');
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
            else if (dato.EstBajCon == 1)
            {
              scope.toast('error','Este Contrato fue dado de baja. elabore una nueva propuesta comercial para crear un nuevo contrato.','');
              return false;
            }
            else if (dato.EstBajCon == 2)
            {
                var FecIniCon = (dato.FecVenCon).split("/");
                var new_fecha= FecIniCon[1]+"/"+FecIniCon[0]+"/"+FecIniCon[2];
                var TuFecha = new Date(new_fecha);
                var numero=1;
                var dias = parseInt(numero);
                TuFecha.setDate(TuFecha.getDate() + dias);
                var FecIniCon1 = TuFecha.getDate() + '/' + (TuFecha.getMonth() + 1) + '/' + TuFecha.getFullYear();
                var FecIniConFinal=(FecIniCon1).split("/");
                var dia=FecIniConFinal[0];
                var mes=FecIniConFinal[1];
                var ano=FecIniConFinal[2];
                if(dia<10)
                {dia='0'+dia;}
                if(mes<10)
                {mes='0'+mes;}
                console.log(dia+"/"+mes+"/"+ano);
                scope.FecIniCon= dia+"/"+mes+"/"+ano;
                $('.FecIniCon').datepicker({format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.FecIniCon);     
                $("#Tipo_Renovacion").modal('show');                
                return false;
            }
        }
        if (opcion_select == 4) {
            scope.tmodal_data = {};
            if (dato.EstBajCon == 1) {
              scope.toast('error','Este contrato ya fue dado de baja.','Error');
              return false;
            }
            if (dato.EstBajCon == 3){
              scope.toast('error','Este contrato fue renovado y no puede ser dado de baja.','Error');
              return false;
            }
            scope.RazSocCom = dato.NumCifCli + " " + dato.CodCom;
            scope.FecBajCon = fecha;
            $('.FecBajCon').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.FecBajCon);
            scope.tmodal_data.CodConCom = dato.CodConCom;
            $("#modal_baja_contrato").modal('show');
        }
        if(opcion_select== 5 || opcion_select== 6)
        {
            if(dato.EstBajCon==3)
            {
                scope.toast('error','Contrato Renovado no puede cambiar a este estatus.','Error');
                return false;
            }
            else if(dato.EstBajCon==4)
            {
                scope.toast('error','Contrato En Renovación no puede cambiar a este estatus.','Error');
                return false;
            }
            var url=base_urlHome()+"api/Contratos/HuerImpli/opcion_select/"+opcion_select+"/CodConCom/"+dato.CodConCom;
            $http.get(url).then(function(result)
            {
                if(result.data!=false)
                {
                    scope.toast('success','Estatus cambiado correctamente.','Estatus');
                    scope.get_list_contratos();
                }
                else
                {
                    scope.toast('error','Hubo un error al intentar cambiar el estatus del contrato intente nuevamente.','Error');

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
        if(opcion_select==7 || opcion_select==8|| opcion_select==0)
        {
           if(dato.EstBajCon==3)
            {
                scope.toast('error','Contrato Renovado no puede cambiar a este estatus.','Error');
                return false;
            }
            else if(dato.EstBajCon==4)
            {
                scope.toast('error','Contrato En Renovación no puede cambiar a este estatus.','Error');
                return false;
            } 
            var url=base_urlHome()+"api/Contratos/HuerImpli/opcion_select/"+opcion_select+"/CodConCom/"+dato.CodConCom;
            $http.get(url).then(function(result)
            {
                if(result.data!=false)
                {
                    scope.toast('success','Estatus cambiado correctamente.','Estatus');
                    scope.get_list_contratos();
                }
                else
                {
                    scope.toast('error','Hubo un error al intentar cambiar el estatus del contrato intente nuevamente.','Error');

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
        

    }
    $scope.SubmitFormRenovacion = function(event) {
        if (!scope.validar_campos_renovacion()) {
            return false;
        }
        console.log(scope.tmodal_data);
        Swal.fire({
            title:'Renovación Contrato',
            text: '¿Seguro de Renovar el contrato?',
            type: "question",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: 'Renovar'
        }).then(function(t) {
            if (t.value == true) {
                $("#Renovando").removeClass("loader loader-default").addClass("loader loader-default is-active");
                console.log(scope.tmodal_data);
                var url = base_urlHome() + "api/Contratos/RenovarContrato/";
                $http.post(url, scope.tmodal_data).then(function(result) {
                    $("#Renovando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (result.data.status == 203 && result.data.statusText == 'Error') {
                       scope.toast('error',result.data.menssage,result.data.statusText);
                       return false;
                    }
                    if (result.data.status == 200 && result.data.statusText == 'OK') 
                    {
                        scope.toast('success',result.data.menssage,'Renovación');
                        if(scope.tmodal_data.TipProCom==1)
                        {
                            $("#Tipo_Renovacion").modal('hide');
                            location.href = "#/Renovar_Propuesta_Comercial/" + scope.tmodal_data.CodCli + "/" + scope.tmodal_data.CodConCom + "/" + scope.tmodal_data.CodProCom + "/renovar";
                            return false;
                        }
                        else if(scope.tmodal_data.TipProCom==2)
                        {

                            $("#Tipo_Renovacion").modal('hide');
                            location.href = "#/Renovar_Propuesta_Comercial_UniCliente_MultiPunto/" + scope.tmodal_data.CodCli + "/" + scope.tmodal_data.CodConCom + "/" + scope.tmodal_data.CodProCom + "/renovar";
                            return false;
                        }
                        else if(scope.tmodal_data.TipProCom==3)
                        {
                            
                            $("#Tipo_Renovacion").modal('hide');
                            location.href = "#/Renovar_Propuesta_Comercial_MulCliente_MultiPunto/" + scope.tmodal_data.CodCli + "/" + scope.tmodal_data.CodConCom + "/" + scope.tmodal_data.CodProCom + "/renovar";
                            return false;
                        }
                        else
                        {

                        }
                        scope.tmodal_data = {};
                        $("#Tipo_Renovacion").modal('hide');
                        //scope.get_list_contratos();
                        return false;
                    }
                    if (result.data != false) {
                      scope.toast('success','Contrato dado de baja sastifactoriamente.','Contrato');
                      //$("#modal_baja_contrato").modal('hide');
                        scope.get_list_contratos();
                    } else {
                      scope.toast('error','Error durante el proceso, intente nuevamente.','Error General');                      
                    }

                }, function(error) {
                    $("#Renovando").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
    scope.validar_campos_renovacion = function() {
        resultado = true;
        if (scope.tmodal_data.SinMod == false && scope.tmodal_data.ConMod == false) {
          scope.toast('error','Debe indicar que tipo de renovación es el contrato.','Error');
          //  Swal.fire({ title: "", text: "", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }

        if (scope.tmodal_data.SinMod == true) {
            var FecIniCon1 = document.getElementById("FecIniCon").value;
            scope.FecIniCon = FecIniCon1;
            if (scope.FecIniCon == null || scope.FecIniCon == undefined || scope.FecIniCon == '') {
              scope.toast('error','La Fecha de Inicio es requerida.','');
                return false;
            } else {
                var FecIniCon = (scope.FecIniCon).split("/");
                if (FecIniCon.length < 3) {
                  scope.toast('error','El formato Fecha de Inicio correcto es DD/MM/YYYY','');
                  event.preventDefault();
                    return false;
                } else {
                    if (FecIniCon[0].length > 2 || FecIniCon[0].length < 2) {
                      scope.toast('error','Error en Día, debe introducir dos números','');
                      event.preventDefault();
                        return false;
                    }
                    if (FecIniCon[1].length > 2 || FecIniCon[1].length < 2) {
                      scope.toast('error','Error en Mes, debe introducir dos números','');
                       event.preventDefault();
                        return false;
                    }
                    if (FecIniCon[2].length < 4 || FecIniCon[2].length > 4) {
                      scope.toast('error','Error en Año, debe introducir cuatros números','');
                        event.preventDefault();
                        return false;
                    }
                    valuesStart = scope.FecIniCon.split("/");
                    scope.tmodal_data.FecIniCon = FecIniCon[2] + "-" + FecIniCon[1] + "-" + FecIniCon[0];
                }
            }
            if (!scope.tmodal_data.DurCon > 0) {
              scope.toast('error','La Duración del Contrato es requerida','');
                return false;
            }
        }


        if (resultado == false) {
            //quiere decir que al menos un renglon no paso la validacion
            return false;
        }
        return true;
    }
    scope.BuscarXIDContrato = function() {
        $("#cargando").removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url = base_urlHome() + "api/Contratos/BuscarXIDContrato/CodCli/" + scope.CodCli + "/CodConCom/" + scope.CodConCom + "/CodProCom/" + scope.CodProCom;
        $http.get(url).then(function(result) {
            $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (result.data != false) 
            {
                scope.RazSocCli = result.data.Cliente.RazSocCli;
                scope.NumCifCli = result.data.Cliente.NumCifCli;
                scope.fdatos.CodCli = result.data.Cliente.CodCli;
                scope.List_Propuestas_Comerciales = result.data.List_Pro;
                scope.fdatos.CodConCom = scope.CodConCom;               
                scope.fdatos.CodProCom = scope.CodProCom;
                scope.filtrar_propuesta_contratos();
                scope.FecIniCon = result.data.Contrato.FecIniCon;
                scope.fdatos.DurCon = result.data.Contrato.DurCon;
                scope.FecVenCon = result.data.Contrato.FecVenCon;
                scope.FecAct = result.data.Contrato.FecAct;
                scope.fdatos.RefCon = result.data.Contrato.RefCon;
                scope.fdatos.DocConRut = result.data.Contrato.DocConRut;
                scope.fdatos.ObsCon = result.data.Contrato.ObsCon;
                scope.FecFirmCon = result.data.Contrato.FecFirmCon;
                $("#RefConClass").removeClass("col-sm-4").addClass("col-sm-2");
                $('.datepicker_Inicio').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", result.data.Contrato.FecIniCon);
                $('.datepicker_Vencimiento').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", result.data.Contrato.FecVenCon);
                $('.FecFirmCon').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", result.data.Contrato.FecFirmCon);
                $('.FecAct').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", result.data.Contrato.FecAct);
                if(result.data.List_Archivos!=false)
                {
                    scope.fdatos.TDocumentosContratos=result.data.List_Archivos;
                }
                else
                {
                    scope.fdatos.TDocumentosContratos=[];
                }                
            } 
            else {
              scope.toast('error','','');
              //  Swal.fire({ title: "Error", text: "El número de CIF no se encuentra asignado a ningun cliente.", type: "error", confirmButtonColor: "#188ae2" });
                location.href = "#/Contratos";
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

    if (scope.CodConCom == undefined && $route.current.$$route.originalPath == "/Contratos/") {
        scope.ruta_reportes_pdf_Contratos = 0;
        scope.ruta_reportes_excel_Contratos = 0;
        scope.FecCon = true;
        scope.CodCli = true;
        scope.NifCliente = true;
        scope.CodCom = true;
        scope.CUPsEleCh=true;
        scope.CUPsGasCh=true;
        scope.CodAnePro = true;
        scope.DurCon = true;
        scope.FecVenCon = true;
        scope.EstBajCon = true;
        scope.ActCont = true;
        scope.opciones_contratos = [{ id: 1, nombre: 'VER' }, { id: 2, nombre: 'EDITAR' }, { id: 3, nombre: 'Renovar' }, { id: 4, nombre: 'Dar Baja' },{ id: 5, nombre: 'Huérfano' }, { id: 6, nombre: 'Implícita' }, { id: 7, nombre: 'Redactado' }, { id: 8, nombre: 'Enviado' }, { id: 0, nombre: 'Activo' }];
        scope.get_list_contratos();
    }
    $scope.submitFormlock = function(event) {

        var FecBajCon = document.getElementById("FecBajCon").value;
        scope.FecBajCon = FecBajCon;
        if (scope.FecBajCon == undefined || scope.FecBajCon == null || scope.FecBajCon == '') {
            scope.toast('error','La Fecha de Baja es obligatoria','');
            return false;
        } else {
            var FecBajCon = (scope.FecBajCon).split("/");
            if (FecBajCon.length < 3) {
                scope.toast('error','Error en Fecha de Baja, el formato correcto es DD/MM/YYYY','');
               event.preventDefault();
                return false;
            } else {
                if (FecBajCon[0].length > 2 || FecBajCon[0].length < 2) {
                    scope.toast('error','Error en Día, debe introducir dos números','');
                    event.preventDefault();
                    return false;
                }
                if (FecBajCon[1].length > 2 || FecBajCon[1].length < 2) {
                    scope.toast('error','Error en Mes, debe introducir dos números','');
                    event.preventDefault();
                    return false;
                }
                if (FecBajCon[2].length < 4 || FecBajCon[2].length > 4) {
                    scope.toast('error','Error en Año, debe introducir cuatro números','');
                    event.preventDefault();
                    return false;
                }
                valuesStart = scope.FecBajCon.split("/");
                valuesEnd = fecha.split("/");
                // Verificamos que la fecha no sea posterior a la actual
                var dateStart = new Date(valuesStart[2], (valuesStart[1] - 1), valuesStart[0]);
                var dateEnd = new Date(valuesEnd[2], (valuesEnd[1] - 1), valuesEnd[0]);
                if (dateStart > dateEnd) {
                    scope.toast('error','La Fecha de Baja no debe ser mayor a ' + fecha,'');
                    //Swal.fire({ text: , type: "error", confirmButtonColor: "#188ae2" });
                    return false;
                }
                scope.tmodal_data.FecBajCon = valuesStart[2] + "-" + valuesStart[1] + "-" + valuesStart[0];
            }
            if (scope.tmodal_data.JusBajCon == undefined || scope.tmodal_data.JusBajCon == null || scope.tmodal_data.JusBajCon == '') {
                scope.toast('error','Debe indicar una justicación de la baja del contrato.','');
                //Swal.fire({ text: '', type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }
        }
        console.log(scope.tmodal_data);
        Swal.fire({
            text: '¿Seguro que desea dar de baja este contrato?',
            type: "question",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: 'Dar Baja'
        }).then(function(t) {
            if (t.value == true) {
                $("#BajaContrato").removeClass("loader loader-default").addClass("loader loader-default is-active");
                console.log(scope.tmodal_data);
                var url = base_urlHome() + "api/Contratos/dandobajaContrato/";
                $http.post(url, scope.tmodal_data).then(function(result) {
                    $("#BajaContrato").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (result.data != false) {
                        scope.toast('error','Contrato dado de baja sastifactoriamente.','Contrato');
                        $("#modal_baja_contrato").modal('hide');
                        scope.get_list_contratos();
                    } else {
                        scope.toast('error','Error durante el proceso, intente nuevamente.','Error General');                        
                    }

                }, function(error) {
                    $("#BajaContrato").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
    scope.regresar_filtro = function() {
        $scope.predicate = 'id';
        $scope.reverse = true;
        $scope.currentPage = 1;
        $scope.order = function(predicate) {
            $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
            $scope.predicate = predicate;
        };
        scope.T_Contratos = scope.T_ContratosBack;
        $scope.totalItems = scope.T_Contratos.length;
        $scope.numPerPage = 50;
        $scope.paginate = function(value) {
            var begin, end, index;
            begin = ($scope.currentPage - 1) * $scope.numPerPage;
            end = begin + $scope.numPerPage;
            index = scope.T_Contratos.indexOf(value);
            return (begin <= index && index < end);
        }
        scope.ruta_reportes_pdf_Contratos = 0;
        scope.ruta_reportes_excel_Contratos = 0;
        scope.tmodal_filtros = {};
        scope.RangFec = undefined;
        scope.NumCifCliFil = undefined;
        scope.EstBajConFil = undefined;
        scope.CodCliFil = undefined;
    }
    $scope.SubmitFormFiltrosContratos = function(event) {
        if (scope.tmodal_filtros.tipo_filtro == 1) {
            var RangFec1 = document.getElementById("RangFec").value;
            scope.RangFec = RangFec1;
            if (scope.RangFec == undefined || scope.RangFec == null || scope.RangFec == '') {
                scope.toast('error','Debe indicar una fecha para poder aplicar el filtro.','Error');
                return false;
            }
            $scope.predicate = 'id';
            $scope.reverse = true;
            $scope.currentPage = 1;
            $scope.order = function(predicate) {
                $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                $scope.predicate = predicate;
            };
            //scope.Tabla_Contacto=result.data;
            scope.T_Contratos = $filter('filter')(scope.T_ContratosBack, { FecConCom: scope.RangFec }, true);
            $scope.totalItems = scope.T_Contratos.length;
            $scope.numPerPage = 50;
            $scope.paginate = function(value) {
                var begin, end, index;
                begin = ($scope.currentPage - 1) * $scope.numPerPage;
                end = begin + $scope.numPerPage;
                index = scope.T_Contratos.indexOf(value);
                return (begin <= index && index < end);
            }
            scope.ruta_reportes_pdf_Contratos = scope.tmodal_filtros.tipo_filtro + "/" + scope.RangFec;
            scope.ruta_reportes_excel_Contratos = scope.tmodal_filtros.tipo_filtro + "/" + scope.RangFec;

        }
        if (scope.tmodal_filtros.tipo_filtro == 2) {
            if (scope.CodCliFil == undefined || scope.CodCliFil == null || scope.CodCliFil == '') {
                scope.toast('error','Debe buscar un cliente para poder aplicar el filtro.','Error');
                return false;
            }
            $scope.predicate = 'id';
            $scope.reverse = true;
            $scope.currentPage = 1;
            $scope.order = function(predicate) {
                $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                $scope.predicate = predicate;
            };
            //scope.Tabla_Contacto=result.data;
            scope.T_Contratos = $filter('filter')(scope.T_ContratosBack, { CodCli: scope.CodCliFil }, true);
            $scope.totalItems = scope.T_Contratos.length;
            $scope.numPerPage = 50;
            $scope.paginate = function(value) {
                var begin, end, index;
                begin = ($scope.currentPage - 1) * $scope.numPerPage;
                end = begin + $scope.numPerPage;
                index = scope.T_Contratos.indexOf(value);
                return (begin <= index && index < end);
            }
            scope.ruta_reportes_pdf_Contratos = scope.tmodal_filtros.tipo_filtro + "/" + scope.CodCliFil;
            scope.ruta_reportes_excel_Contratos = scope.tmodal_filtros.tipo_filtro + "/" + scope.CodCliFil;

        }
        if (scope.tmodal_filtros.tipo_filtro == 3) {
            if (!scope.EstBajConFil > 0) {
                scope.toast('error','Debe seleccionar un estatus para poder aplicar el filtro.','Error');
                return false;
            }
            $scope.predicate = 'id';
            $scope.reverse = true;
            $scope.currentPage = 1;
            $scope.order = function(predicate) {
                $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                $scope.predicate = predicate;
            };
            //scope.Tabla_Contacto=result.data;
            scope.T_Contratos = $filter('filter')(scope.T_ContratosBack, { EstBajCon: scope.EstBajConFil }, true);
            $scope.totalItems = scope.T_Contratos.length;
            $scope.numPerPage = 50;
            $scope.paginate = function(value) {
                var begin, end, index;
                begin = ($scope.currentPage - 1) * $scope.numPerPage;
                end = begin + $scope.numPerPage;
                index = scope.T_Contratos.indexOf(value);
                return (begin <= index && index < end);
            }
            scope.ruta_reportes_pdf_Contratos = scope.tmodal_filtros.tipo_filtro + "/" + scope.EstBajConFil;
            scope.ruta_reportes_excel_Contratos = scope.tmodal_filtros.tipo_filtro + "/" + scope.EstBajConFil;

        }

    };
    scope.FetchContratos=function()
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
            scope.T_Contratos = scope.T_ContratosBack;
            $scope.totalItems = scope.T_Contratos.length;
            $scope.numPerPage = 50;
            $scope.paginate = function(value) {
                var begin, end, index;
                begin= ($scope.currentPage - 1) * $scope.numPerPage;
                end = begin + $scope.numPerPage;
                index = scope.T_Contratos.indexOf(value);
                return (begin <= index && index < end);
            }    

            scope.ruta_reportes_pdf_Contratos = 0;
            scope.ruta_reportes_excel_Contratos =0;
        }
        else
        {
            if(scope.filtrar_search.length>=2)
            {
                scope.fdatos.filtrar_search=scope.filtrar_search;   
                var url = base_urlHome()+"api/Contratos/getContratosFilter";
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
                        scope.T_Contratos = result.data;
                        $scope.totalItems = scope.T_Contratos.length;
                        $scope.numPerPage = 50;
                        $scope.paginate = function(value) {
                            var begin, end, index;
                            begin= ($scope.currentPage - 1) * $scope.numPerPage;
                            end = begin + $scope.numPerPage;
                            index = scope.T_Contratos.indexOf(value);
                            return (begin <= index && index < end);
                        }
                        scope.ruta_reportes_pdf_Contratos = 4 + "/" + scope.filtrar_search;
                        scope.ruta_reportes_excel_Contratos = 4 + "/" + scope.filtrar_search;
                    }
                    else
                    {
                        scope.T_Contratos=[];
                        scope.ruta_reportes_pdf_Contratos = 0;
                        scope.ruta_reportes_excel_Contratos =0;
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
        }     
     }          
     scope.generar_audax=function(metodo)
     {
     	scope.toast('info','Debe permitir el uso de ventanas emergentes para poder ver el contrato audax.','Ventana Emergente');
     	if(scope.fdatos.CodConCom==undefined||scope.fdatos.CodConCom==null||scope.fdatos.CodConCom=='')
        {
            scope.toast('error','Código Contrato Comercial es Requerido.','');
            return false;
        }
        scope.metodo=metodo;
        scope.CodContCli=0;
        scope.CodCuenBan=0;
		scope.List_Firmantes=[];
        console.log(scope.fdatos);
     	var url=base_urlHome()+"api/Contratos/generar_audax/";
     	$http.post(url,scope.fdatos).then(function(result)
     	{
     		console.log(result.data);
     		if(result.data!=false)
     		{
     			if(result.data.Contactos.length==0)
     			{
     				scope.CodContCli=0;  				
     			}
                else if(result.data.Contactos.length==1)
                {
                    if(result.data.Contactos[0].EsRepLeg==1)
                    {
                        scope.CodContCli=result.data.Contactos[0].CodConCli;
                    }
                    else
                    {
                        scope.CodContCli=0;
                    } 
                }
                if(result.data.CuentasBancarias.length==0)
                {
                    scope.CodCuenBan=0;                                      
                }
                else if(result.data.CuentasBancarias.length==1)
                {
                    scope.CodCuenBan=result.data.CuentasBancarias[0].CodCueBan
                }
                else
                {                    
                    scope.List_Cuentas=result.data.CuentasBancarias;
                    console.log(scope.List_Cuentas);
                }
     			if(result.data.Contactos.length>1)
     			{
     				angular.forEach(result.data.Contactos,function(RepresentantesLegal)
					{
						if(RepresentantesLegal.EsRepLeg==1)
						{
							if (scope.List_Firmantes==undefined || scope.List_Firmantes==false)
							{
							 scope.List_Firmantes = []; 
							}
							scope.List_Firmantes.push({CodConCli:RepresentantesLegal.CodConCli,NomConCli:RepresentantesLegal.NomConCli,NIFConCli:RepresentantesLegal.NIFConCli});
						}
					}); 
                    scope.titulo_modal='Quien Firma';                    
					//scope.get_list_contratos();
					console.log(scope.List_Firmantes);
                    scope.List_Cuentas=result.data.CuentasBancarias;
                    console.log(scope.List_Cuentas);
     				$("#modal_representante_legal").modal('show');
     				return false;
     			}
                if(result.data.CuentasBancarias.length>1)
                {
                    scope.titulo_modal='Cuentas Bancarias';
                    //scope.get_list_contratos();
                    console.log(scope.List_Firmantes);                    
                    scope.List_Cuentas=result.data.CuentasBancarias;
                    console.log(scope.List_Cuentas);
                    $("#modal_representante_legal").modal('show');
                    return false;
                }
                if(result.data.Contactos.length>1 && result.data.CuentasBancarias.length<=1)
                {
                    scope.titulo_modal='Quien Firma';
                    return false;
                }
                else if (result.data.Contactos.length<=1 && result.data.CuentasBancarias.length>1)
                {
                    scope.titulo_modal='Cuentas Bancarias';
                    return false;
                }
                /*else
                {
                    scope.titulo_modal='Quien Firma / Cuentas Bancarias';
                    return false;
                }*/
                if(metodo==1)
                {
                    scope.url_pdf_audax="http://10.72.0.16/AudaxPDFSencillo/";
                    var url=scope.url_pdf_audax+scope.CodCli+"/"+scope.CodConCom+"/"+scope.CodProCom+"/"+scope.CodContCli+"/"+scope.CodCuenBan;                
                }
                else if(metodo==2)
                {
                    scope.url_pdf_audax="http://10.72.0.16/Contrato_MultiPunto_V14/";
                    var url=scope.url_pdf_audax+scope.CodCli+"/"+scope.CodConCom+"/"+scope.CodProCom+"/"+scope.CodContCli+"/"+scope.CodCuenBan;                

                    scope.url_AnexoPunSumEle="http://10.72.0.16/Anexo_Puntos_SumEle/";
                    var url2=scope.url_AnexoPunSumEle+scope.CodCli+"/"+scope.CodConCom+"/"+scope.CodProCom;
                    var win2 = window.open(url2, '_blank');

                    scope.url_AnexoPunSumGas="http://10.72.0.16/Anexo_Puntos_SumGas/";
                    var url3=scope.url_AnexoPunSumGas+scope.CodCli+"/"+scope.CodConCom+"/"+scope.CodProCom;
                    var win3 = window.open(url3, '_blank');
                }
                else if(metodo==3)
                {
                   
                   scope.url_pdf_audax_multiCIF="http://10.72.0.16/Contrato_MultiCIF_v1_sinSEPA/";
                   var url_MultiCIFSinSepa=scope.url_pdf_audax_multiCIF+scope.CodCli+"/"+scope.CodConCom+"/"+scope.CodProCom+"/"+scope.CodContCli+"/"+scope.CodCuenBan;

                   scope.url_pdf_audax="http://10.72.0.16/Anexo_Datos_ClientesPunSum/";
                   var url=scope.url_pdf_audax+scope.CodCli+"/"+scope.CodConCom+"/"+scope.CodProCom+"/"+scope.CodContCli+"/"+scope.CodCuenBan;                
                
                    var url_Sepa =base_urlHome()+"api/Contratos/GenerarSepaClientes/CodCli/"+scope.CodCli+"/CodProCom/"+scope.CodProCom+"/CodConCom/"+scope.CodConCom;
                    $http.get(url_Sepa).then(function(result)
                    {
                        if(result.data!=false)
                        {
                            console.log(result.data);
                            angular.forEach(result.data, function(data) {
                                //console.log(data);
                                scope.url_AnexoPunSumEle="http://10.72.0.16/SepaAudax/";
                                var url2=scope.url_AnexoPunSumEle+data.CodCli+"/"+scope.CodConCom+"/"+scope.CodProCom+"/"+scope.CodContCli+"/"+data.CodCueBan; 
                                var win2 = window.open(url2, '_blank');
                            });
                        }
                        else
                        {

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
                    var win2 = window.open(url_MultiCIFSinSepa, '_blank');
                    win2.focus();   
                }
     			console.log(url);
                
                var win = window.open(url, '_blank');
                             
		    }
     		else
     		{
     			scope.CodContCli=0;
                scope.CodCuenBan=0;
                if(metodo==1)
                {
                    scope.url_pdf_audax="http://10.72.0.16/AudaxPDFSencillo/";
                    var url=scope.url_pdf_audax+scope.CodCli+"/"+scope.CodConCom+"/"+scope.CodProCom+"/"+scope.CodContCli+"/"+scope.CodCuenBan;                
                }
                else if(metodo==2)
                {
                    scope.url_pdf_audax="http://10.72.0.16/Contrato_MultiPunto_V14/";
                    var url=scope.url_pdf_audax+scope.CodCli+"/"+scope.CodConCom+"/"+scope.CodProCom+"/"+scope.CodContCli+"/"+scope.CodCuenBan;                
                    scope.url_AnexoPunSumEle="http://10.72.0.16/Anexo_Puntos_SumEle/";
                    var url2=scope.url_AnexoPunSumEle+scope.CodCli+"/"+scope.CodConCom+"/"+scope.CodProCom;
                    var win = window.open(url2, '_blank');
                    win.focus();
                            
                }
                else if(metodo==3)
                {
                   scope.url_pdf_audax="http://10.72.0.16/Anexo_Datos_ClientesPunSum/";
                   var url=scope.url_pdf_audax+scope.CodCli+"/"+scope.CodConCom+"/"+scope.CodProCom+"/"+scope.CodContCli+"/"+scope.CodCuenBan;                
                  
                }
                var win = window.open(url, '_blank');
		        win.focus();
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
     $scope.SubmitFormGenAudax = function(event)
     {       
       	if(!scope.CodContCli>0)
       	{
       		scope.toast('error','Debe Seleccionar Quien Firma El Contrato Audax.','Error');
            return false;
       	}
        if(!scope.CodCuenBan>0)
        {
            scope.toast('error','Debe Seleccionar Una Cuenta Bancaria Para El Contrato Audax.','Error');
           return false;
        }
        Swal.fire({
            title: 'Contrato Audax',
            text: '¿Estás seguro de continuar con los datos seleccionado?',
            type: "question",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: "OK!"
        }).then(function(t) {
            if (t.value == true)
            {
            	
                if(scope.metodo==1)
                {
                    scope.url_pdf_audax="http://10.72.0.16/AudaxPDFSencillo/";
                    var url=scope.url_pdf_audax+scope.CodCli+"/"+scope.CodConCom+"/"+scope.CodProCom+"/"+scope.CodContCli+"/"+scope.CodCuenBan;                
                }
                else if(scope.metodo==2)
                {
                    scope.url_pdf_audax="http://10.72.0.16/Contrato_MultiPunto_V14/";
                    var url=scope.url_pdf_audax+scope.CodCli+"/"+scope.CodConCom+"/"+scope.CodProCom+"/"+scope.CodContCli+"/"+scope.CodCuenBan;                

                    scope.url_AnexoPunSumEle="http://10.72.0.16/Anexo_Puntos_SumEle/";
                    var url2=scope.url_AnexoPunSumEle+scope.CodCli+"/"+scope.CodConCom+"/"+scope.CodProCom;
                    var win2 = window.open(url2, '_blank');

                    scope.url_AnexoPunSumGas="http://10.72.0.16/Anexo_Puntos_SumGas/";
                    var url3=scope.url_AnexoPunSumGas+scope.CodCli+"/"+scope.CodConCom+"/"+scope.CodProCom;
                    var win3 = window.open(url3, '_blank');
                }

                //scope.url_pdf_audax="http://10.72.0.16/Contrato_MultiPunto_V14/";

                var url=scope.url_pdf_audax+scope.CodCli+"/"+scope.CodConCom+"/"+scope.CodProCom+"/"+scope.CodContCli+"/"+scope.CodCuenBan;
     			console.log(url);
                var win = window.open(url, '_blank');
		        win.focus();
		        scope.CodContCli=undefined;
		        scope.List_Firmantes=[];
		        $("#modal_representante_legal").modal('hide');

            } else {
                event.preventDefault();
            }
        });
    };

    scope.tramitar_Audax=function()
    {
        $("#enviandoaudax").removeClass("loader loader-default").addClass("loader loader-default is-active");
        var req = {
        method: 'POST',
        url: 'http://webservice.audaxenergia.com:8080/WSAudaxTest/Login',
            headers: {
            'Access-Control-Allow-Credentials':undefined,
            'Access-Control-Allow-Methods':undefined,
            'Access-Control-Allow-Origin':undefined,
            'Access-Control-Max-Age':undefined,
            'Accept':undefined,
            'x-api-key':undefined,
            'Access-Control-Allow-Headers':undefined,
            'content-type':undefined
        },
            data: { UserId: 'Enerspain',Password: '1404'}            
        }
        $http(req).then(function(result)
        {
        	$("#enviandoaudax").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if(result.data.Data!=false && result.data.Error==null)
        	{
        		scope.toast('success','Sesión inciada correctamente siguiente paso.','Sesión Iniciada');
                scope.SessionStart={};
                scope.SessionStart.sessionToken=result.data.Data.sessionToken;
                scope.SessionStart.userId=result.data.Data.userId;
                scope.SendAudaxContrato();
        	}
        	else if(result.data.Error!=false && result.data.Data==null)
        	{
        		scope.toast('error','Ocurrio un error al enviar el contrato a audax.',result.data.Error.AdditionalInfo);
                scope.SessionStart={};
        	}
        },function(error)
        {
            $("#enviandoaudax").removeClass("loader loader-default is-active").addClass("loader loader-default");
        	if(error.data==null && error.statusText=="" )
        	{
        		scope.toast('error','Ocurrio un error al enviar el contrato a audax.','Error Protocolo');
                scope.SessionStart={};
        	}
        	console.log(error)
        });      
    }
    scope.SendAudaxContrato=function()
    {
       // if(scope.fdatos.TipProCom==1)
        //{
            //scope.DatosAudax={};
            scope.SessionStart.CodCli=scope.fdatos.CodCli;
            scope.SessionStart.CodConCom=scope.fdatos.CodConCom;
            scope.SessionStart.CodProCom=scope.fdatos.CodProCom;
            scope.SessionStart.TipProCom=scope.fdatos.TipProCom;
            //console.log(scope.SessionStart);
            var url= base_urlHome()+"api/Contratos/DatosParaAudax/";
            $http.post(url,scope.SessionStart).then(function(result)
            {
                scope.DatosAudaxSend={};
                scope.DatosAudaxSend=result.data;                
                if(scope.fdatos.TipProCom==1)
                {
                    if(scope.DatosAudaxSend.DetallesCUPs.length==1)
                    {
                        angular.forEach(scope.DatosAudaxSend.DetallesCUPs, function(CUPs)
                        {
                            if(CUPs.TipCups==1)
                            {                               
                                scope.cups_luz=CUPs.CUPsName;
                                scope.cups_gas='';                        
                                scope.direccion_cups=CUPs.NomViaPunSum;
                                scope.tipovia_cups=CUPs.IniTipVia;
                                scope.numerodire_cups=CUPs.NumViaPunSum;
                                scope.pisodire_cups='';
                                scope.cp_cups=CUPs.CPLocSoc;
                                scope.email_cups=scope.DatosAudaxSend.EmaCli;
                                scope.escalera_cups= CUPs.EscPunSum;
                                scope.puerta_cups= CUPs.PuePunSum;
                                scope.gama_comentario=CUPs.ObsProGam;
                                scope.gama=CUPs.DesProGam;

                                scope.potencia1=CUPs.PotEleConP1;
                                scope.potencia2=CUPs.PotEleConP2;
                                scope.potencia3=CUPs.PotEleConP3;
                                scope.potencia4=CUPs.PotEleConP4;
                                scope.potencia5=CUPs.PotEleConP5;
                                scope.potencia6=CUPs.PotEleConP6;
                               
                                scope.subtarifa=CUPs.NomTar;
                                scope.subtarifa_gas='';
                                scope.procedencia='';
                                scope.tipovia_envio=CUPs.IniTipVia;
                                scope.direccion_envio=CUPs.NomViaPunSum;
                                scope.numerodire_envio=CUPs.NumViaPunSum;
                                scope.cp_envio=CUPs.CPLocSoc;
                                scope.tarifacups=CUPs.NomTar;
                                scope.tarifa=CUPs.NomTar;
                                scope.tarifacups_gas='';
                                scope.tarifa_gas='';
                                scope.consumo_gas='';
                                scope.consumo_media_anual_gas='';
                                scope.consumo=CUPs.ConCup;
                            }
                            else
                            {
                                scope.cups_luz='';
                                scope.cups_gas=CUPs.CUPsName;                      
                                scope.direccion_cups=CUPs.NomViaPunSum;
                                scope.tipovia_cups=CUPs.IniTipVia;
                                scope.numerodire_cups=CUPs.NumViaPunSum;
                                scope.pisodire_cups='';
                                scope.cp_cups=CUPs.CPLocSoc;
                                scope.email_cups=scope.DatosAudaxSend.EmaCli;
                                scope.escalera_cups= CUPs.EscPunSum;
                                scope.puerta_cups= CUPs.PuePunSum;
                                scope.gama_comentario=CUPs.ObsProGam;
                                scope.gama=CUPs.DesProGam;

                                scope.potencia1='';
                                scope.potencia2='';
                                scope.potencia3='';
                                scope.potencia4='';
                                scope.potencia5='';
                                scope.potencia6='';
                               
                                scope.subtarifa='';
                                scope.subtarifa_gas=CUPs.NomTar;
                                scope.procedencia='';
                                scope.tipovia_envio=CUPs.IniTipVia;
                                scope.direccion_envio=CUPs.NomViaPunSum;
                                scope.numerodire_envio=CUPs.NumViaPunSum;
                                scope.cp_envio=CUPs.CPLocSoc;
                                scope.tarifacups='';
                                scope.tarifa='';
                                scope.tarifacups_gas=CUPs.NomTar;
                                scope.tarifa_gas=CUPs.NomTar;
                                scope.consumo_gas=CUPs.ConCup;
                                scope.consumo_media_anual_gas=CUPs.ConCup;
                                scope.consumo=CUPs.ConCup;
                            }
                        });
                    }
                    $("#enviandoaudax").removeClass("loader loader-default ").addClass("loader loader-default is-active");
                    var req = 
                    {
                        method: 'POST',
                        url: 'http://webservice.audaxenergia.com:8080/WSAudaxTest/Contratar',
                        //url:'http://10.72.0.16/Audax',
                        headers: {
                        'Access-Control-Allow-Credentials':undefined,
                        'Access-Control-Allow-Methods':undefined,
                        'Access-Control-Allow-Origin':undefined,
                        'Access-Control-Max-Age':undefined,
                        'Accept':undefined,
                        'x-api-key':undefined,
                        'Access-Control-Allow-Headers':undefined,
                        'content-type':undefined
                    },
                        data: 
                        {   
                            authToken:scope.SessionStart.sessionToken,
                            comercial:'01171',
                            //////// DATOS CLIENTES START /////
                            razon_social: scope.DatosAudaxSend.RazSocCli,
                            nif_cliente: scope.DatosAudaxSend.NumCifCli,
                            escalera_cliente: scope.DatosAudaxSend.EscDomSoc,
                            puerta_cliente: scope.DatosAudaxSend.PueDomSoc,
                            escalera_envio: scope.DatosAudaxSend.EscDomCliEnv,
                            puerta_envio: scope.DatosAudaxSend.PueDomCliEnv,
                            direccion_cliente: scope.DatosAudaxSend.NomViaDomSoc,
                            tipovia_cliente: scope.DatosAudaxSend.IniTipVia,
                            numdire_cliente: scope.DatosAudaxSend.NumViaDomSoc,
                            pisodire_cliente: '',
                            cp_cliente: scope.DatosAudaxSend.CPLocSoc,
                            telefono_cliente: scope.DatosAudaxSend.TelFijCli,
                            movil_cliente:scope.DatosAudaxSend.TelMovCli,
                            fax_cliente: '',
                            email_cliente:scope.DatosAudaxSend.EmaCli,
                            numerodire_cliente2:'',
                            letra_cliente:'',
                            //////// DATOS CLIENTES END /////
                            
                            //////// DATOS CONTACTOS START /////
                            nombreApellidos_contacto:scope.DatosAudaxSend.NomConCli,
                            cargo_contacto:scope.DatosAudaxSend.CarConCli,
                            nif_contacto:scope.DatosAudaxSend.NIFConCli,
                            direccion_contacto:scope.DatosAudaxSend.direccion_contacto,
                            tipovia_contacto:scope.DatosAudaxSend.tipovia_contacto,
                            numdire_contacto:scope.DatosAudaxSend.numdire_contacto,
                            pisodire_contacto:'',
                            cp_contacto:scope.DatosAudaxSend.cp_contacto,
                            telefono_contacto:'',
                            fax_contacto:'',                        
                            email_contacto:scope.DatosAudaxSend.EmaConCli,
                            //////// DATOS CONTACTOS END /////

                            //////// DATOS CUENTA BANCARIA START /////
                            iban:scope.DatosAudaxSend.iban,
                            entidad:scope.DatosAudaxSend.entidad,
                            sucursal:scope.DatosAudaxSend.sucursal,
                            dc:scope.DatosAudaxSend.dc,
                            cuenta:scope.DatosAudaxSend.cuenta,
                            //////// DATOS CUENTA BANCARIA END /////

                            cups_luz:scope.cups_luz,
                            cups_gas:scope.cups_gas,                        
                            direccion_cups:scope.direccion_cups,
                            tipovia_cups:scope.tipovia_cups,
                            numerodire_cups:scope.numerodire_cups,
                            pisodire_cups:scope.pisodire_cups,
                            cp_cups:scope.cp_cups,
                            email_cups:scope.email_cups,
                            escalera_cups: scope.escalera_cups,
                            puerta_cups: scope.puerta_cups,
                            
                            numerodire_cups2:'',
                            letra_cups:'',

                            gama_comentario:scope.gama_comentario,
                            gama:scope.gama, 
                            
                            potencia1:scope.potencia1,
                            potencia2:scope.potencia2,
                            potencia3:scope.potencia3,
                            potencia4:scope.potencia4,
                            potencia5:scope.potencia5,
                            potencia6:scope.potencia6,
                            
                            potencia_anterior1:'',
                            potencia_anterior2:'',
                            potencia_anterior3:'',
                            potencia_anterior4:'',
                            potencia_anterior5:'',
                            potencia_anterior6:'',
                                
                            subtarifa:scope.subtarifa,
                            subtarifa_gas:scope.subtarifa_gas,
                            procedencia:scope.procedencia,
                            
                            duracion:scope.DatosAudaxSend.duracion+' MESES',
                            titular_suministro:scope.DatosAudaxSend.RazSocCli,
                            nif_titular_suministro:scope.DatosAudaxSend.NumCifCli,
                            //tipo_contrato_comentario:'1 -> Fijo, 2-> Indexado', 
                            tipo_contrato_comentario:scope.DatosAudaxSend.tipo_contrato_comentario, 
                            tipo_contrato:scope.DatosAudaxSend.tipo_contrato, 
                            tipo_contrato_gas:scope.DatosAudaxSend.tipo_contrato_gas, 
                            consumo:scope.consumo,
                            importe_medio_factura:0,
                            fecha_firma:scope.DatosAudaxSend.fecha_firma,
                            deposito:'',
                            desvios:'',
                            
                            nif_representante_contacto:scope.DatosAudaxSend.NIFConCli,
                            representante_contacto:scope.DatosAudaxSend.NomConCli,
                            cnae:'0',
                            
                            distribuidora_anterior:'',
                            cambio_titular_luz:'',
                            Nombre_apellidos_cambiotit_luz:'',
                            causa_cambio_titular_luz_comentario:'',
                            causa_cambio_titular_luz:'',
                            nif_anterior_titular_luz:'',
                            cambio_titular_gas:'',
                            Nombre_apellidos_cambiotit_gas:'',
                            nif_anterior_titular_gas:'',
                            cambio_potencia:'',
                            referencia_catastral:'',
                            
                            nombre_envio:scope.DatosAudaxSend.RazSocCli,
                            tipovia_envio:scope.tipovia_envio,
                            direccion_envio:scope.direccion_envio,
                            numerodire_envio:scope.numerodire_envio,
                            pisodire_envio:'',
                            cp_envio:scope.cp_envio,
                            numerodire_envio2:'',
                            letra_envio:'',
                            liquidacion:'',    
                            
                            tarifacups:scope.tarifacups,
                            tarifa:scope.tarifacups,
                            tarifacups_gas:scope.tarifacups_gas,
                            tarifa_gas:scope.tarifa_gas,
                            
                            cert_verde:'',
                            complemento_municipio_cliente:'',
                            complemento_municipio_envio:'',
                            complemento_municipio_cups:'',
                            servicio_urgencias:'',
                            servicio_mantenimiento:'',
                            servicio_proteccion:'',
                            securluz_particular_plus:'',
                            securLuz_particular_elect:'',
                            securLuz_particular_urge:'',
                            securLuz_negocios:'',
                            securGas_particular:'',
                            securGas_negocios:'',

                            consumo_gas:scope.consumo_gas,
                            consumo_media_anual_gas:scope.consumo_media_anual_gas,

                            fecha_inicio_corporate:scope.DatosAudaxSend.fecha_inicio_corporate,
                            tarifa_corporate:[],
                            tarifa_corporate_gas:[]
                        }
                    }
                    $http(req).then(function(result)
                    {
                        $("#enviandoaudax").removeClass("loader loader-default is-active").addClass("loader loader-default");
                        //console.log(data);
                        console.log(result);
                        /*if(result.data.Data!=false && result.data.Error==null)
                        {
                            scope.toast('success','El Contrato fue enviado a Audax correctamente.','Enviado A Audax');
                            scope.SessionStart={};
                            scope.SessionStart.sessionToken=result.data.Data.sessionToken;
                            scope.SessionStart.userId=result.data.Data.userId;
                            scope.SendAudaxContrato();
                        }
                        else if(result.data.Error!=false && result.data.Data==null)
                        {
                            scope.toast('error','Ocurrio un error al enviar el contrato a audax.',result.data.Error.AdditionalInfo);
                            scope.SessionStart={};
                        }*/
                    },function(error)
                    {
                        $("#enviandoaudax").removeClass("loader loader-default is-active").addClass("loader loader-default");
                        /*if(error.data==null && error.statusText=="" )
                        {
                            scope.toast('error','Ocurrio un error al enviar el contrato a audax.','Error Protocolo');
                           scope.SessionStart={};
                        }*/
                        //console.log(error)
                    });

                }           

            },function(error)
            {
                console.log(error);
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
        //}
        
    }
    scope.BuscarXIDPropuestaContratoColaborador=function()
    {
        var url=base_urlHome()+"api/Contratos/PropuestaMultiCliente/CodCol/"+scope.CodCli;
        $http.get(url).then(function(result)
        {
           // console.log(result);
            $("#NumCifCli").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (result.data != false) {
                if (result.data.status == false && result.data.statusText == "Error") {
                  scope.toast('error',result.data.menssage,'Error');
                    location.href = "#/Contratos/";
                    return false;
                }
                scope.fdatos.CodCli = result.data.Cliente.CodCli;
                scope.RazSocCli = result.data.Cliente.RazSocCli;
                scope.NumCifCli = result.data.Cliente.NumCifCli;
                scope.List_Propuestas_Comerciales = result.data.List_Propuesta;
                scope.fdatos.RefCon = result.data.RefCon;
                $("#TipPreClass").removeClass("col-sm-4").addClass("col-sm-6");
                $("#FecVenConClass").removeClass("col-sm-6").addClass("col-sm-6");
                $("#DurConClass").removeClass("col-sm-6").addClass("col-sm-6");                
                $("#FecActClass").removeClass("col-sm-4").addClass("col-sm-6");
                /*scope.fdatos.CodProCom=scope.CodProCom;
                scope.filtrar_propuesta_contratos();
                console.log(scope.fdatos.CodProCom);*/
                $('.datepicker_Inicio').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", result.data.FechaServer);
            } else {
              scope.toast('error','Este Número de CIF no se encuentra registrado.','Error');
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
    scope.generar_contratos_t=function(fdatos,tipo_t)
    {
        
        if(tipo_t==2)
        {
            scope.url_pdf_t2='http://10.72.0.16/Generar_T2/';
            var url=scope.url_pdf_t2+scope.CodCli+"/"+fdatos.TipProCom;
            var win = window.open(url, '_blank');
            win.focus();
        }
        else if(tipo_t==3)
        {
            scope.url_pdf_t2='http://10.72.0.16/Generar_T3/';
            var url=scope.url_pdf_t2+scope.CodCli+"/"+fdatos.TipProCom;
            var win = window.open(url, '_blank');
            win.focus();
        }
        else if(tipo_t==4)
        {
            scope.url_pdf_t2='http://10.72.0.16/Generar_T4/';
            var url=scope.url_pdf_t2+scope.CodCli+"/"+fdatos.TipProCom;
            var win = window.open(url, '_blank');
            win.focus();
        }        
    }
    $scope.SelectFile = function (e) {
        //scope.AddImagen(e.target.files[0]);
        //console.log(e);
        //alert(e.target.files[0]);
        //console.log(e.target.files[0]);
        scope.AddImagen(e.target.files[0]);
    };
    scope.AddImagen = function(archivo)
    {
        //$("#subiendo_archivo").removeClass("loader loader-default").addClass("loader loader-default is-active");        
        /*if(scope.fdatos.CodConCom==null || scope.fdatos.CodConCom==undefined|| scope.fdatos.CodConCom=='')
        {
            scope.toast('error','Debe generar primero el contrato para poder agregar un documento.','Error');
            return false;
        }*/
        if (archivo==null){
            $("#subiendo_archivo").removeClass( "loader loader-default is-active" ).addClass("loader loader-default");   
            scope.toast('error','Seleccione otro archivo','Error');
        }
        else
        {
            $("#subiendo_archivo").removeClass("loader loader-default").addClass("loader loader-default is-active");
            formData = new FormData();
            formData.append('file', archivo);
            formData.append('x-api-key', $cookies.get('ApiKey'));
            formData.append('CodConCom', scope.fdatos.CodConCom);             
            $.ajax({
                url : base_urlHome()+"api/Contratos/agregar_documento_contrato/",
                type: "POST",
                headers:{'x-api-key':$cookies.get('ApiKey')},
                data : formData,
                processData: false,
                contentType: false,
                async:false,
                success:function(data,textStatus,jqXHR)
                { 
                    $("#subiendo_archivo").removeClass( "loader loader-default is-active" ).addClass("loader loader-default")                          
                        if(data.status==404 && data.statusText=="Error")
                        {
                            scope.toast('error',data.menssage,data.statusText);
                            return false; 
                        }
                        if(data.status==200 && data.statusText=="OK")
                        {
                            scope.toast('success',data.menssage,data.statusText);
                            scope.imagen = null;
                            document.getElementById('file_fotocopia').value = '';
                            scope.fdatos.TDocumentosContratos.push({CodDetDocCon:data.CodDetDocCon,file_ext:data.file_ext,CodConCom:data.CodConCom,DocGenCom:data.DocGenCom,DocConRut:data.DocConRut}); 
                            $scope.$apply();
                            return false; 
                        }
                },              
                error: function(jqXHR, textStatus, errorThrown){
                        $("#subiendo_archivo").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );  
                        console.log(jqXHR);
                        console.log(textStatus);
                        scope.toast('error','Error Subiendo archivo.','Error');
                    }
            });
        }
            
    }
    scope.borrar_row=function(index,CodDetDocCon)
    {
        console.log(index);
        console.log(CodDetDocCon);
        $("#borrando_archivo").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active" );
        var url =base_urlHome()+"api/Contratos/borrar_documento_contrato/CodDetDocCon/"+CodDetDocCon;
        $http.get(url).then(function(result)
        {
            $("#borrando_archivo").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
            if (result.data!=false)
            {
                scope.toast('success','Archivo borrado correctamente','Borrado');
                scope.fdatos.TDocumentosContratos.splice(index,1);
            }
            else
            {
                scope.toast('error','Error al intentar Borrar el Archivo','Error');
            }   
        },function(error)
        {
           $("#borrando_archivo").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
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
        scope.toast=function(type,msg,title)
        {
        	var shortCutFunction = type;
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
    ///////// PARA CALCULAR DNI/NIE START /////////////////
    scope.validarNIFDNI = function() {
        var letter = scope.validar_dni_nfi($("#NumCifCli1").parent(), $("#NumCifCli1").val());
        if (letter != false) {
            $("#iLetter").replaceWith("<p id='iLetter' class='ok'>La letra es: <strong>" + letter + "</strong> <br/> El DNI o NIE es: <strong>" + $("#NumCifCli1").val() + letter + "</strong> </p>");
        } else {
            $("#iLetter").replaceWith("<p id='iLetter' class='error'>Esperando a los n&uacute;meros</p>");
        }
    }

    function isNumeric(expression) {
        return (String(expression).search(/^\d+$/) != -1);
    }

    function calculateLetterForDni(dni) {
        // Letras en funcion del modulo de 23
        string = "TRWAGMYFPDXBNJZSQVHLCKET"
            // se obtiene la posiciÃ³n de la cadena anterior
        position = dni % 23
            // se extrae dicha posiciÃ³n de la cadena
        letter = string.substring(position, position + 1)
        return letter
    }
    scope.validar_dni_nfi = function(field, txt) {
            //console.log(field);
            //console.log(txt);
            var letter = ""
                // Si es un dni extrangero, es decir, empieza por X, Y, Z
                // Si la longitud es 8longitud total de los dni nacionales)
            if (txt.length == 8) {
                var first = txt.substring(0, 1)
                if (first == 'X' || first == 'Y' || first == 'Z') {
                    // Si la longitud es 9(longitud total de los dni extrangeros)

                    // Se calcula la letra para el numero de dni
                    var number = txt.substring(1, 8);
                    if (first == 'X') {
                        number = '0' + number
                    }
                    if (first == 'Y') {
                        number = '1' + number
                    }
                    if (first == 'Z') {
                        number = '2' + number
                    }
                    if (isNumeric(number)) {
                        letter = calculateLetterForDni(number)
                    }

                    if (letter != "") {
                        field.removeClass("kindagood welldone")
                            // Se aÃ±ade solo la clase welldone que indica que esta
                            // correcto
                        field.addClass("welldone")
                        return letter
                    }

                } else {
                    // Se realizan las mismas operaciones que para el caso anterior
                    // pero con un caracter menos
                    letter = calculateLetterForDni(txt.substring(0, 8))
                    if (letter != "") {

                        field.removeClass("kindagood welldone")
                        field.addClass("welldone")
                        return letter
                    }
                }
            }
            // Si no es ningun dni, se borran las clases kindagoog y welldone si es
            // estÃ¡n activas
            // Para que se muestre la ayuda en le color original.
            field.removeClass("kindagood welldone")

            if (txt.length == 8) {
                // Si la longitud es la correcta pero el dni no lo es, entonces se
                // aÃ±ade
                // la clase kindagood que indica que ha habido algun error en la
                // escritura
                field.addClass("kindagood")
            }
            return false
        }
        ///////// PARA CALCULAR DNI/NIE END /////////////////

    if (scope.CodCli != undefined && scope.fdatos.tipo == "nuevo" && scope.TipProCom==3) {
        scope.BuscarXIDPropuestaContratoColaborador();
    }    
    if (scope.CodCli != undefined && scope.fdatos.tipo == "nuevo" && scope.TipProCom==undefined) {
        scope.BuscarXIDPropuestaContrato();
    }
    if (scope.CodCli != undefined && scope.fdatos.tipo == "ver" && scope.TipProCom==undefined || scope.CodCli != undefined && scope.fdatos.tipo == "editar" && scope.TipProCom==undefined) {
        scope.BuscarXIDContrato();
    }
    if (scope.CodCli != undefined && scope.fdatos.tipo == "ver" && scope.TipProCom==3 || scope.CodCli != undefined && scope.fdatos.tipo == "editar" && scope.TipProCom==3) {
        scope.BuscarXIDContratoColaborador();
    }
    /*if(scope.CodCli!=undefined)
    {
        scope.BuscarXIDPropuestaContrato();
    }*/
    /*else
    {
       scope.BuscarXIDPropuestaContrato(); 
    }*/
    ////////////////////////////////////////////////// PARA LOS CONTRATOS END ///////////////////////////////////////////////////////////////    
}