app.controller('Controlador_Rueda', ['$http', '$scope', '$filter', '$route', '$interval', '$controller', '$cookies', '$compile', Controlador])

function Controlador($http, $scope, $filter, $route, $interval, $controller, $cookies, $compile) {
    var scope = this;
    scope.fdatos = {};
    scope.T_Seguimientos = [];
    scope.T_SeguimientosBack = [];
    scope.List_Gestiones = [];
    scope.List_GestionesBack = [];
    //scope.CodConCom = $route.current.params.CodConCom;

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
    scope.opcion_rueda=[{id:3,nombre:'Renovar'}];
    ////////////////////////////////////////////////// PARA EL REPORTE RUEDA START /////////////////////////////////////////////////////////////
    console.log($route.current.$$route.originalPath);
    scope.Show_Contratos = undefined;
    scope.Table_Contratos = [];
 
    scope.traer_datos_server = function() {
        var url = base_urlHome() + "api/Reportes/Fecha_Server/";
        $http.get(url).then(function(result) {
            if (result.data != false) {
                $('.FecDesde').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", result.data.FecDesde);
                $('.FecHasta').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", result.data.FecHasta);
                scope.FecDesde=result.data.FecDesde;
                scope.FecHasta=result.data.FecHasta;
            } else {
                Swal.fire({ title: "Error General", text: "Error General intente nuevamente.", type: "error", confirmButtonColor: "#188ae2" });
            }

        }, function(error) 
        {
            if (error.status == 404 && error.statusText == "Not Found") { Swal.fire({ title: "Error 404", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" }); }
            if (error.status == 401 && error.statusText == "Unauthorized") { Swal.fire({ title: "Error 401", text: "Disculpe, Usuario no autorizado para acceder a ester módulo", type: "error", confirmButtonColor: "#188ae2" }); }
            if (error.status == 403 && error.statusText == "Forbidden") { Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY incorrecto", type: "error", confirmButtonColor: "#188ae2" }); }
            if (error.status == 500 && error.statusText == "Internal Server Error") { Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" }); }

        });
    }
     scope.validar_formatos_input = function(metodo, object){
        
        if (metodo == 1) {
            if (object != undefined){
                numero = object;
                if (!/^([/0-9])*$/.test(numero))
                scope.FecDesde = numero.substring(0, numero.length - 1);
            }            
        }
        if (metodo == 2) {
            if (object != undefined) {
                numero = object;
                if (!/^([/0-9])*$/.test(numero))
                scope.FecHasta = numero.substring(0, numero.length - 1);
            }
        }       
    }
    $scope.submitFormRueda = function(event){
        console.log(scope.fdatos);
        if (!scope.validar_campos_rueda()) {
            return false;
        }
        $("#Rueda").removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url=base_urlHome()+"api/Reportes/Generar_Rueda/";
        $http.post(url,scope.fdatos).then(function(result)
        {
            $("#Rueda").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if(result.data!=false)
            {
                $scope.predicate = 'id';
                $scope.reverse = true;
                $scope.currentPage = 1;
                $scope.order = function(predicate) {
                    $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                    $scope.predicate = predicate;
                };
                scope.Table_Contratos=result.data;
                $scope.totalItems = scope.Table_Contratos.length;
                $scope.numPerPage = 50;
                $scope.paginate = function(value) {
                    var begin, end, index;
                    begin = ($scope.currentPage - 1) * $scope.numPerPage;
                    end = begin + $scope.numPerPage;
                    index = scope.Table_Contratos.indexOf(value);
                    return (begin <= index && index < end);
                }
            }
            else
            {
                scope.Table_Contratos=[];
                Swal.fire({ title: "Error", text: "No se encontraron contratos en este rango de fecha.", type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }

        },function(error)
        {
            $("#Rueda").removeClass("loader loader-default is-active").addClass("loader loader-default");
            console.log(error);        
            if (error.status == 404 && error.statusText == "Not Found") { Swal.fire({ title: "Error 404", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" }); }
            if (error.status == 401 && error.statusText == "Unauthorized") { Swal.fire({ title: "Error 401", text: "Disculpe, Usuario no autorizado para acceder a ester módulo", type: "error", confirmButtonColor: "#188ae2" }); }
            if (error.status == 403 && error.statusText == "Forbidden") { Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY incorrecto", type: "error", confirmButtonColor: "#188ae2" }); }
            if (error.status == 500 && error.statusText == "Internal Server Error") { Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" }); }
        });        
    }; 
     scope.validar_campos_rueda = function() {
        resultado = true;        
        var FecDesde1 = document.getElementById("FecDesde").value;
        scope.FecDesde = FecDesde1;
        if (scope.FecDesde == null || scope.FecDesde == undefined || scope.FecDesde == '') {
            Swal.fire({ title: "La Fecha Desde es requerida", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        } else {
            var FecDesde = (scope.FecDesde).split("/");
            if (FecDesde.length < 3) {
                Swal.fire({ title: "El formato Fecha Desde correcto es DD/MM/YYYY", type: "error", confirmButtonColor: "#188ae2" });
                event.preventDefault();
                return false;
            } else {
                if (FecDesde[0].length > 2 || FecDesde[0].length < 2) {
                    Swal.fire({ title: "Error en Día, debe introducir dos números", type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;
                }
                if (FecDesde[1].length > 2 || FecDesde[1].length < 2) {
                    Swal.fire({ title: "Error en Mes, debe introducir dos números", type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;
                }
                if (FecDesde[2].length < 4 || FecDesde[2].length > 4) {
                    Swal.fire({ title: "Error en Año, debe introducir cuatro números", type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;
                }
                valuesStart = scope.FecDesde.split("/");
                scope.fdatos.FecDesde = FecDesde[2] + "-" + FecDesde[1] + "-" + FecDesde[0];
            }
        }
        
        var FecHasta1 = document.getElementById("FecHasta").value;
        scope.FecHasta = FecHasta1;
        if (scope.FecHasta == null || scope.FecHasta == undefined || scope.FecHasta == '') {
            Swal.fire({ title: "La Fecha Hasta es requerida", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        } else {
            var FecHasta = (scope.FecHasta).split("/");
            if (FecHasta.length < 3) {
                Swal.fire({ title: "El formato Fecha de Vencimiento correcto es DD/MM/YYYY", type: "error", confirmButtonColor: "#188ae2" });
                event.preventDefault();
                return false;
            } else {
                if (FecHasta[0].length > 2 || FecHasta[0].length < 2) {
                    Swal.fire({ title: "Error en Día, debe introducir dos números", type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;
                }
                if (FecHasta[1].length > 2 || FecHasta[1].length < 2) {
                    Swal.fire({ title: "Error en Mes, debe introducir dos números", type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;
                }
                if (FecHasta[2].length < 4 || FecHasta[2].length > 4) {
                    Swal.fire({ title: "Error en Año, debe introducir cuatro números", type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;
                }
                valuesStart = scope.FecHasta.split("/");
                scope.fdatos.FecHasta = FecHasta[2] + "-" + FecHasta[1] + "-" + FecHasta[0];
            }
        }       
        if (resultado == false) {
            //quiere decir que al menos un renglon no paso la validacion
            return false;
        }
        return true;
    }
    scope.validar_opcion_rueda = function(index, opcion_select, dato) {
        //console.log('index: '+index);
        //console.log('opcion: '+opcion_select);
        console.log(dato);
        scope.opcion_select[index]=undefined;
        if (opcion_select == 3) {
            
            if (dato.EstBajCon == 3)
            {
                Swal.fire({ title: "Error", text: "El Contrato ya fue renovado.", type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }
            if (dato.EstBajCon == 4)
            {
                Swal.fire({ title: "Error", text: "Este contrato se encuentra en proceso de renovación.", type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }
            scope.tmodal_data = {};
            scope.tmodal_data.CodCli = dato.CodCli;
            scope.tmodal_data.CodProCom = dato.CodProCom;
            scope.tmodal_data.CodConCom = dato.CodConCom;
            scope.tmodal_data.FecConCom = dato.FecConCom;
            scope.tmodal_data.FecVenCon = dato.FecVenCon;
            scope.tmodal_data.FecIniCon = dato.FecIniCon;
            scope.tmodal_data.SinMod = false;
            scope.tmodal_data.ConMod = false;
            scope.RazSocCli = dato.RazSocCli;
            scope.CodCom = dato.CodCom;
            scope.Anexo = dato.Anexo;
            if (dato.EstBajCon == 0)
            {
                //console.log(scope.tmodal_data);
                var url = base_urlHome() + "api/Reportes/verificar_renovacion";
                $http.post(url, scope.tmodal_data).then(function(result)
                {
                    if (result.data!=false)
                    {
                        //console.log(result.data); 
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
                            //Swal.fire({ title: result.data.statusText, text: result.data.menssage, type: "info", confirmButtonColor: "#188ae2" });
                            //scope.tmodal_data = {};
                            //$("#Tipo_Renovacion").modal('hide');
                            return false;
                        }
                        if (result.data.status == 200 && result.data.statusText == "OK") {
                            Swal.fire({ title: result.data.message, type: "success", confirmButtonColor: "#188ae2" });
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
                        Swal.fire({ title: "Error General", text: "Error en el proceso intente nuevamente", type: "error", confirmButtonColor: "#188ae2" });
                    }

                }, function(error) {
                    if (error.status == 404 && error.statusText == "Not Found") {
                        Swal.fire({ title: "Error General", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
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
            else if (dato.EstBajCon == 1)
            {
                Swal.fire({ title: 'Este Contrato fue dado de baja. elabore una nueva propuesta comercial para crear un nuevo contrato.', type: "error", confirmButtonColor: "#188ae2" });
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
    }
    $scope.SubmitFormRenovacion = function(event) {
        if (!scope.validar_campos_renovacion()) {
            return false;
        }
        console.log(scope.tmodal_data);
        Swal.fire({
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
                var url = base_urlHome() + "api/Reportes/RenovarContrato/";
                $http.post(url, scope.tmodal_data).then(function(result) {
                    $("#Renovando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (result.data.status == 203 && result.data.statusText == 'Error') {
                        Swal.fire({ title: result.data.statusText, text: result.data.menssage, type: "error", confirmButtonColor: "#188ae2" });
                        return false;
                    }
                    if (result.data.status == 200 && result.data.statusText == 'OK') {
                        Swal.fire({ title: 'Renovación', text: result.data.menssage, type: "success", confirmButtonColor: "#188ae2" });
                        scope.tmodal_data = {};
                        $("#Tipo_Renovacion").modal('hide');
                        $scope.submitFormRueda();
                        return false;
                    }
                    if (result.data != false) {
                        //Swal.fire({ title: "Contrato", text: "Contrato dado de baja sastifactoriamente.", type: "error", confirmButtonColor: "#188ae2" });
                        //$("#modal_baja_contrato").modal('hide');
                        $scope.submitFormRueda();
                    } else {
                        Swal.fire({ title: "Error General", text: "Error durante el proceso, intente nuevamente.", type: "error", confirmButtonColor: "#188ae2" });
                    }

                }, function(error) {
                    $("#Renovando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (error.status == 404 && error.statusText == "Not Found") {
                        Swal.fire({ title: "Error General", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
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
                event.preventDefault();
                console.log('Cancelando ando...');
            }
        });
    };
    scope.validar_campos_renovacion = function() {
        resultado = true;
        if (scope.tmodal_data.SinMod == false && scope.tmodal_data.ConMod == false) {
            Swal.fire({ title: "Error", text: "Debe indicar que tipo de renovación es el contrato.", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }

        if (scope.tmodal_data.SinMod == true) {
            var FecIniCon1 = document.getElementById("FecIniCon").value;
            scope.FecIniCon = FecIniCon1;
            if (scope.FecIniCon == null || scope.FecIniCon == undefined || scope.FecIniCon == '') {
                Swal.fire({ title: "La Fecha de Inicio es requerida", type: "error", confirmButtonColor: "#188ae2" });
                return false;
            } else {
                var FecIniCon = (scope.FecIniCon).split("/");
                if (FecIniCon.length < 3) {
                    Swal.fire({ title: "El formato Fecha de Inicio correcto es DD/MM/YYYY", type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;
                } else {
                    if (FecIniCon[0].length > 2 || FecIniCon[0].length < 2) {
                        Swal.fire({ title: "Error en Día, debe introducir dos números", type: "error", confirmButtonColor: "#188ae2" });
                        event.preventDefault();
                        return false;
                    }
                    if (FecIniCon[1].length > 2 || FecIniCon[1].length < 2) {
                        Swal.fire({ title: "Error en Mes, debe introducir dos números", type: "error", confirmButtonColor: "#188ae2" });
                        event.preventDefault();
                        return false;
                    }
                    if (FecIniCon[2].length < 4 || FecIniCon[2].length > 4) {
                        Swal.fire({ title: "Error en Año, debe introducir dos números", type: "error", confirmButtonColor: "#188ae2" });
                        event.preventDefault();
                        return false;
                    }
                    valuesStart = scope.FecIniCon.split("/");
                    scope.tmodal_data.FecIniCon = FecIniCon[2] + "-" + FecIniCon[1] + "-" + FecIniCon[0];
                }
            }
            if (!scope.tmodal_data.DurCon > 0) {
                Swal.fire({ title: "La Duración del Contrato es requerida", type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }
        }


        if (resultado == false) {
            //quiere decir que al menos un renglon no paso la validacion
            return false;
        }
        return true;
    }
    scope.traer_datos_server();
    ////////////////////////////////////////////////// PARA EL REPORTE RUEDA END ///////////////////////////////////////////////////////////////    
}