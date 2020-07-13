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
    scope.List_TipPre = [{ TipPre: 0, nombre: 'Fijo' }, { TipPre: 1, nombre: 'Indexado' }, { TipPre: 2, nombre: 'Ambos' }];
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
        console.log(metodo);
        console.log(object);
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

        if (metodo == 3) {
             if (object != undefined) {
                 numero = object;
                 if (!/^([/0-9])*$/.test(numero))
                     scope.FecIniCon = numero.substring(0, numero.length - 1);
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
            if(dato.CodProCom==null || dato.CodProCom==0)
            {
                Swal.fire({ title: "Error", text: "Este contrato no posee una propuesta comercial cargue la información de la propuesta comercial para continuar con la renovación del contrato.", type: "error", confirmButtonColor: "#188ae2" });
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
                var url =base_urlHome()+"api/Reportes/AsignarPropuestaContrato/CodCli/"+dato.CodCli;
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
    scope.validar_campos_asignar_propuestas = function() {
         resultado = true;
         var FecProCom1 = document.getElementById("FecProCom").value;
         scope.FecProCom = FecProCom1;
         if (scope.FecProCom == null || scope.FecProCom == undefined || scope.FecProCom == '') {
             Swal.fire({ title: "La Fecha de la Propuesta es requerida", type: "error", confirmButtonColor: "#188ae2" });
             return false;
         } else {
             var FecProCom = (scope.FecProCom).split("/");
             if (FecProCom.length < 3) {
                 Swal.fire({ title: "El Formato de Fecha de la Propuesta debe Ser EJ: DD/MM/YYYY.", type: "error", confirmButtonColor: "#188ae2" });
                 event.preventDefault();
                 return false;
             } else {
                 if (FecProCom[0].length > 2 || FecProCom[0].length < 2) {
                     Swal.fire({ title: "Por Favor Corrija el Formato del dia en la Fecha de la Propuesta deben ser 2 números solamente. EJ: 01", type: "error", confirmButtonColor: "#188ae2" });
                     event.preventDefault();
                     return false;
                 }
                 if (FecProCom[1].length > 2 || FecProCom[1].length < 2) {
                     Swal.fire({ title: "Por Favor Corrija el Formato del mes de la Fecha de la Propuesta deben ser 2 números solamente. EJ: 01", type: "error", confirmButtonColor: "#188ae2" });
                     event.preventDefault();
                     return false;
                 }
                 if (FecProCom[2].length < 4 || FecProCom[2].length > 4) {
                     Swal.fire({ title: "Por Favor Corrija el Formato del ano en la Fecha de la Propuesta Ya que deben ser 4 números solamente. EJ: 1999", type: "error", confirmButtonColor: "#188ae2" });
                     event.preventDefault();
                     return false;
                 }
                 valuesStart = scope.FecProCom.split("/");
                 valuesEnd = scope.Fecha_Propuesta.split("/");
                 // Verificamos que la fecha no sea posterior a la actual
                 var dateStart = new Date(valuesStart[2], (valuesStart[1] - 1), valuesStart[0]);
                 var dateEnd = new Date(valuesEnd[2], (valuesEnd[1] - 1), valuesEnd[0]);
                 if (dateStart > dateEnd) {
                     Swal.fire({ title: "La Fecha de la Propuesta no puede ser mayor al " + scope.Fecha_Propuesta + " Por Favor Verifique he intente nuevamente.", type: "error", confirmButtonColor: "#188ae2" });
                     return false;
                 }
                 scope.fdatos.FecProCom = FecProCom[2] + "-" + FecProCom[1] + "-" + FecProCom[0];
             }
         }
         if (scope.fdatos.RefProCom == null || scope.fdatos.RefProCom == undefined || scope.fdatos.RefProCom == '') {
             Swal.fire({ title: "El número de la propuesta es requerido.", type: "error", confirmButtonColor: "#188ae2" });
             return false;
         }

         if (!scope.fdatos.EstProCom > 0) {
             Swal.fire({ title: "El Estatus de la propuesta es requerido.", type: "error", confirmButtonColor: "#188ae2" });
             return false;
         }

         if (!scope.fdatos.CodPunSum > 0) {
             Swal.fire({ title: "Debe seleccionar un punto de suministro.", type: "error", confirmButtonColor: "#188ae2" });
             return false;
         }
         if (!scope.fdatos.CodCupSEle > 0 && !scope.fdatos.CodCupGas > 0) {
             Swal.fire({ title: "Debe seleccionar un Tipo de CUPs Para generer una propuesta comercial", type: "error", confirmButtonColor: "#188ae2" });
             return false;
         }
         if (scope.fdatos.CodCupSEle > 0) {
             if (!scope.fdatos.CodTarEle > 0) {
                 Swal.fire({ title: "Debe seleccionar una Tarifa Eléctrica.", type: "error", confirmButtonColor: "#188ae2" });
                 return false;
             }

             if (scope.CanPerEle == 1) {
                 if (scope.fdatos.PotConP1 == null || scope.fdatos.PotConP1 == undefined || scope.fdatos.PotConP1 == '') {
                     Swal.fire({ title: "Debe indicar la Potencia 1", type: "error", confirmButtonColor: "#188ae2" });
                     return false;
                 }
             }
             if (scope.CanPerEle == 2) {
                 if (scope.fdatos.PotConP1 == null || scope.fdatos.PotConP1 == undefined || scope.fdatos.PotConP1 == '') {
                     Swal.fire({ title: "Debe indicar la Potencia 1", type: "error", confirmButtonColor: "#188ae2" });
                     return false;
                 }
                 if (scope.fdatos.PotConP2 == null || scope.fdatos.PotConP2 == undefined || scope.fdatos.PotConP2 == '') {
                     Swal.fire({ title: "Debe indicar la Potencia 2", type: "error", confirmButtonColor: "#188ae2" });
                     return false;
                 }
             }
             if (scope.CanPerEle == 3) {
                 if (scope.fdatos.PotConP1 == null || scope.fdatos.PotConP1 == undefined || scope.fdatos.PotConP1 == '') {
                     Swal.fire({ title: "Debe indicar la Potencia 1", type: "error", confirmButtonColor: "#188ae2" });
                     return false;
                 }
                 if (scope.fdatos.PotConP2 == null || scope.fdatos.PotConP2 == undefined || scope.fdatos.PotConP2 == '') {
                     Swal.fire({ title: "Debe indicar la Potencia 2", type: "error", confirmButtonColor: "#188ae2" });
                     return false;
                 }
                 if (scope.fdatos.PotConP3 == null || scope.fdatos.PotConP3 == undefined || scope.fdatos.PotConP3 == '') {
                     Swal.fire({ title: "Debe indicar la Potencia 3", type: "error", confirmButtonColor: "#188ae2" });
                     return false;
                 }
             }
             if (scope.CanPerEle == 4) {
                 if (scope.fdatos.PotConP1 == null || scope.fdatos.PotConP1 == undefined || scope.fdatos.PotConP1 == '') {
                     Swal.fire({ title: "Debe indicar la Potencia 1", type: "error", confirmButtonColor: "#188ae2" });
                     return false;
                 }
                 if (scope.fdatos.PotConP2 == null || scope.fdatos.PotConP2 == undefined || scope.fdatos.PotConP2 == '') {
                     Swal.fire({ title: "Debe indicar la Potencia 2", type: "error", confirmButtonColor: "#188ae2" });
                     return false;
                 }
                 if (scope.fdatos.PotConP3 == null || scope.fdatos.PotConP3 == undefined || scope.fdatos.PotConP3 == '') {
                     Swal.fire({ title: "Debe indicar la Potencia 3", type: "error", confirmButtonColor: "#188ae2" });
                     return false;
                 }
                 if (scope.fdatos.PotConP4 == null || scope.fdatos.PotConP4 == undefined || scope.fdatos.PotConP4 == '') {
                     Swal.fire({ title: "Debe indicar la Potencia 4", type: "error", confirmButtonColor: "#188ae2" });
                     return false;
                 }
             }
             if (scope.CanPerEle == 5) {
                 if (scope.fdatos.PotConP1 == null || scope.fdatos.PotConP1 == undefined || scope.fdatos.PotConP1 == '') {
                     Swal.fire({ title: "Debe indicar la Potencia 1", type: "error", confirmButtonColor: "#188ae2" });
                     return false;
                 }
                 if (scope.fdatos.PotConP2 == null || scope.fdatos.PotConP2 == undefined || scope.fdatos.PotConP2 == '') {
                     Swal.fire({ title: "Debe indicar la Potencia 2", type: "error", confirmButtonColor: "#188ae2" });
                     return false;
                 }
                 if (scope.fdatos.PotConP3 == null || scope.fdatos.PotConP3 == undefined || scope.fdatos.PotConP3 == '') {
                     Swal.fire({ title: "Debe indicar la Potencia 3", type: "error", confirmButtonColor: "#188ae2" });
                     return false;
                 }
                 if (scope.fdatos.PotConP4 == null || scope.fdatos.PotConP4 == undefined || scope.fdatos.PotConP4 == '') {
                     Swal.fire({ title: "Debe indicar la Potencia 4", type: "error", confirmButtonColor: "#188ae2" });
                     return false;
                 }
                 if (scope.fdatos.PotConP5 == null || scope.fdatos.PotConP5 == undefined || scope.fdatos.PotConP5 == '') {
                     Swal.fire({ title: "Debe indicar la Potencia 5", type: "error", confirmButtonColor: "#188ae2" });
                     return false;
                 }
             }
             if (scope.CanPerEle == 6) {
                 if (scope.fdatos.PotConP1 == null || scope.fdatos.PotConP1 == undefined || scope.fdatos.PotConP1 == '') {
                     Swal.fire({ title: "Debe indicar la Potencia 1", type: "error", confirmButtonColor: "#188ae2" });
                     return false;
                 }
                 if (scope.fdatos.PotConP2 == null || scope.fdatos.PotConP2 == undefined || scope.fdatos.PotConP2 == '') {
                     Swal.fire({ title: "Debe indicar la Potencia 2", type: "error", confirmButtonColor: "#188ae2" });
                     return false;
                 }
                 if (scope.fdatos.PotConP3 == null || scope.fdatos.PotConP3 == undefined || scope.fdatos.PotConP3 == '') {
                     Swal.fire({ title: "Debe indicar la Potencia 3", type: "error", confirmButtonColor: "#188ae2" });
                     return false;
                 }
                 if (scope.fdatos.PotConP4 == null || scope.fdatos.PotConP4 == undefined || scope.fdatos.PotConP4 == '') {
                     Swal.fire({ title: "Debe indicar la Potencia 4", type: "error", confirmButtonColor: "#188ae2" });
                     return false;
                 }
                 if (scope.fdatos.PotConP5 == null || scope.fdatos.PotConP5 == undefined || scope.fdatos.PotConP5 == '') {
                     Swal.fire({ title: "Debe indicar la Potencia 5", type: "error", confirmButtonColor: "#188ae2" });
                     return false;
                 }
                 if (scope.fdatos.PotConP6 == null || scope.fdatos.PotConP6 == undefined || scope.fdatos.PotConP6 == '') {
                     Swal.fire({ title: "Debe indicar la Potencia 6", type: "error", confirmButtonColor: "#188ae2" });
                     return false;
                 }
             }
             if (scope.fdatos.ImpAhoEle == null || scope.fdatos.ImpAhoEle == undefined || scope.fdatos.ImpAhoEle == '') {
                 Swal.fire({ title: "Debe indicar un importe de ahorro eléctrico.", type: "error", confirmButtonColor: "#188ae2" });
                 return false;
             }
             if (scope.fdatos.PorAhoEle == null || scope.fdatos.PorAhoEle == undefined || scope.fdatos.PorAhoEle == '') {
                 Swal.fire({ title: "Debe indicar un porcentaje eléctrico.", type: "error", confirmButtonColor: "#188ae2" });
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
                 Swal.fire({ title: "Debe seleccionar una Tarifa de Gas.", type: "error", confirmButtonColor: "#188ae2" });
                 return false;
             }
             if (scope.fdatos.Consumo == null || scope.fdatos.Consumo == undefined || scope.fdatos.Consumo == '') {
                 Swal.fire({ title: "Debe indicar un consumo.", type: "error", confirmButtonColor: "#188ae2" });
                 return false;
             }
             if (scope.fdatos.CauDia == null || scope.fdatos.CauDia == undefined || scope.fdatos.CauDia == '') {
                 Swal.fire({ title: "Debe indicar un Caudal Diario.", type: "error", confirmButtonColor: "#188ae2" });
                 return false;
             }
             if (scope.fdatos.ImpAhoGas == null || scope.fdatos.ImpAhoGas == undefined || scope.fdatos.ImpAhoGas == '') {
                 Swal.fire({ title: "Debe indicar un importe de ahorro de gas..", type: "error", confirmButtonColor: "#188ae2" });
                 return false;
             }
             if (scope.fdatos.PorAhoGas == null || scope.fdatos.PorAhoGas == undefined || scope.fdatos.PorAhoGas == '') {
                 Swal.fire({ title: "Debe indicar un porcentaje de gas..", type: "error", confirmButtonColor: "#188ae2" });
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
             Swal.fire({ title: "Debe seleccionar una Comercializadora.", type: "error", confirmButtonColor: "#188ae2" });
             return false;
         }
         if (!scope.fdatos.CodPro > 0) {
             Swal.fire({ title: "Debe seleccionar un producto.", type: "error", confirmButtonColor: "#188ae2" });
             return false;
         }
         if (!scope.fdatos.CodAnePro > 0) {
             Swal.fire({ title: "Debe seleccionar un Anexo.", type: "error", confirmButtonColor: "#188ae2" });
             return false;
         }
         if (!scope.fdatos.TipPre > 0) {
             Swal.fire({ title: "Debe seleccionar un Tipo de Precio.", type: "error", confirmButtonColor: "#188ae2" });
             return false;
         }
         if (scope.fdatos.ObsProCom == null || scope.fdatos.ObsProCom == undefined || scope.fdatos.ObsProCom == '') {
             scope.fdatos.ObsProCom = null;
         } else {
             scope.fdatos.ObsProCom = scope.fdatos.ObsProCom;
         }
         if (scope.fdatos.tipo == 'editar' || scope.fdatos.tipo == 'ver') {
             if (scope.fdatos.Apro == false && scope.fdatos.Rech == false) {
                 Swal.fire({ title: "Debe indicar si es aprobada o rechazada.", type: "error", confirmButtonColor: "#188ae2" });
                 return false;
             }
         }
         if (scope.fdatos.Rech == true) {
             if (scope.fdatos.JusRecProCom == null || scope.fdatos.JusRecProCom == undefined || scope.fdatos.JusRecProCom == '') {
                 Swal.fire({ title: "Debe indicar una justificación del rechazo.", type: "error", confirmButtonColor: "#188ae2" });
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
                            //scope.get_list_contratos();                          
                            $scope.submitFormRueda();
                            Swal.fire({ title:result.data.statusText, text: result.data.menssage, type: "success", confirmButtonColor: "#188ae2" });
                        }                        
                    }
                    else 
                    {
                        Swal.fire({ title: "Error", text: "No se ha completado la operación, intente nuevamente", type: "error", confirmButtonColor: "#188ae2" });
                    }
                }, function(error) {
                    $("#Propuesta").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
                 Swal.fire({ title: "CUPs", text: "El Cliente debe tener al menos un tipo de CUPs registrado para poder generar una Propuesta Comercial", type: "error", confirmButtonColor: "#188ae2" });
             }
        }, function(error)
        {
            $("#CUPs").removeClass("loader loader-default is-active").addClass("loader loader-default");
            console.log(error);
            if (error.status == 404 && error.statusText == "Not Found") {
                Swal.fire({ title: "Error 404", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 401 && error.statusText == "Unauthorized") {
                Swal.fire({ title: "Error 401", text: "Disculpe, Usuario no autorizado para acceder a ester módulo", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 403 && error.statusText == "Forbidden") {
                Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY incorrecto", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 500 && error.statusText == "Internal Server Error") {
                Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
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
                     scope.List_Productos = [];
                     scope.List_Anexos = [];
                     scope.fdatos.CodPro = undefined;
                     scope.fdatos.CodAnePro = undefined;
                     scope.fdatos.TipPre = undefined;
                 }
                 if (metodo == 2) {
                     scope.List_Anexos = [];
                     scope.fdatos.CodAnePro = undefined;
                     scope.fdatos.TipPre = undefined;
                 }
             }
         }, function(error) {
             console.log(error);
             if (error.status == 404 && error.statusText == "Not Found") {
                 Swal.fire({ title: "Error 404", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
             }
             if (error.status == 401 && error.statusText == "Unauthorized") {
                 Swal.fire({ title: "Error 401", text: "Disculpe, Usuario no autorizado para acceder a ester módulo", type: "error", confirmButtonColor: "#188ae2" });
             }
             if (error.status == 403 && error.statusText == "Forbidden") {
                 Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY incorrecto", type: "error", confirmButtonColor: "#188ae2" });
             }
             if (error.status == 500 && error.statusText == "Internal Server Error") {
                 Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
             }
         });
     }
    ////////////////////////////////////////////////// PARA EL REPORTE RUEDA END ///////////////////////////////////////////////////////////////    
}