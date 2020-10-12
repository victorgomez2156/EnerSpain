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
                $('.FecDesde').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", result.data.FecDesde).datepicker("setEndDate", result.data.FecHasta);
                $('.FecHasta').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", result.data.FecHasta);
                scope.FecDesde=result.data.FecDesde;
                scope.FecHasta=result.data.FecHasta;
            } else {
                scope.toast('error','Error General intente nuevamente.','Error General');
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
                scope.Table_ContratosBack=result.data;
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
            if (error.status == 404 && error.statusText == "Not Found"){
                    scope.toast('error','El método que esté intentando usar no puede ser localizado','Error 404');
                    }if (error.status == 401 && error.statusText == "Unauthorized"){
                        scope.toast('error','Disculpe, Usuario no autorizado para acceder a ester módulo','Error 401');
                    }if (error.status == 403 && error.statusText == "Forbidden"){
                        scope.toast('error','Está intentando utilizar un APIKEY inválido','Error 403');
                    }if (error.status == 500 && error.statusText == "Internal Server Error") {
                    scope.toast('error','Ha ocurrido una falla en el Servidor, intente más tarde','Error 500');
                    }});        
    }; 
     scope.validar_campos_rueda = function() {
        resultado = true;        
        var FecDesde1 = document.getElementById("FecDesde").value;
        scope.FecDesde = FecDesde1;
        if (scope.FecDesde == null || scope.FecDesde == undefined || scope.FecDesde == '') {
            scope.toast('error','La Fecha Desde es requerida','');
            return false;
        } else {
            var FecDesde = (scope.FecDesde).split("/");
            if (FecDesde.length < 3) {
                scope.toast('error','El formato Fecha Desde correcto es DD/MM/YYYY','');
                event.preventDefault();
                return false;
            } else {
                if (FecDesde[0].length > 2 || FecDesde[0].length < 2) {
                    scope.toast('error','Error en Día, debe introducir dos números','');
                    event.preventDefault();
                    return false;
                }
                if (FecDesde[1].length > 2 || FecDesde[1].length < 2) {
                    scope.toast('error','Error en Mes, debe introducir dos números','');
                    event.preventDefault();
                    return false;
                }
                if (FecDesde[2].length < 4 || FecDesde[2].length > 4) {
                    scope.toast('error','Error en Año, debe introducir cuatro números','');
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
            scope.toast('error','La Fecha Hasta es requerida','');
            return false;
        } else {
            var FecHasta = (scope.FecHasta).split("/");
            if (FecHasta.length < 3) {
                scope.toast('error','El formato Fecha de Vencimiento correcto es DD/MM/YYYY','');
                event.preventDefault();
                return false;
            } else {
                if (FecHasta[0].length > 2 || FecHasta[0].length < 2) {
                    scope.toast('error','Error en Día, debe introducir dos números','');
                    event.preventDefault();
                    return false;
                }
                if (FecHasta[1].length > 2 || FecHasta[1].length < 2) {
                    scope.toast('error','Error en Mes, debe introducir dos números','');
                    event.preventDefault();
                    return false;
                }
                if (FecHasta[2].length < 4 || FecHasta[2].length > 4) {
                    scope.toast('error','Error en Año, debe introducir cuatro números','');
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
            scope.tmodal_data.FecDesde=scope.FecDesde;
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
                            //scope.toast('info',result.data.menssage,result.data.statusText);
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
                        $scope.submitFormRueda();
                        return false;
                    }
                    if (result.data != false) {
                        scope.toast('error','Contrato dado de baja sastifactoriamente.','Contrato');
                        //$("#modal_baja_contrato").modal('hide');
                        $scope.submitFormRueda();
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
                        scope.toast('error','Error en Año, debe introducir dos números','');
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
    scope.traer_datos_server();
    scope.validar_campos_asignar_propuestas = function() {
         resultado = true;
         var FecProCom1 = document.getElementById("FecProCom").value;
         scope.FecProCom = FecProCom1;
         if (scope.FecProCom == null || scope.FecProCom == undefined || scope.FecProCom == '') {
             scope.toast('error','La Fecha de la Propuesta es requerida.','');
             return false;
         } else {
             var FecProCom = (scope.FecProCom).split("/");
             if (FecProCom.length < 3) {
                 scope.toast('error','El Formato de Fecha de la Propuesta debe Ser EJ: DD/MM/YYYY.','');
                 //event.preventDefault();
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
             scope.toast('error','Debe seleccionar una Comercializadora.','');
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
                            $scope.submitFormRueda();
                            scope.toast('success',result.data.menssage,result.data.statusText,);
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
     scope.FetchContratosRuedaFilter=function()
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
            scope.Table_Contratos = scope.Table_ContratosBack;
            $scope.totalItems = scope.Table_Contratos.length;
            $scope.numPerPage = 50;
            $scope.paginate = function(value) {
                var begin, end, index;
                begin= ($scope.currentPage - 1) * $scope.numPerPage;
                end = begin + $scope.numPerPage;
                index = scope.Table_Contratos.indexOf(value);
                return (begin <= index && index < end);
            }
        }
        else
        {
            if(scope.filtrar_search.length>=2)
            {
                scope.fdatos.filtrar_search=scope.filtrar_search;   
                var url = base_urlHome()+"api/Reportes/getContratosFilterRueda";
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
                        scope.Table_Contratos = result.data;
                        $scope.totalItems = scope.Table_Contratos.length;
                        $scope.numPerPage = 50;
                        $scope.paginate = function(value) {
                            var begin, end, index;
                            begin= ($scope.currentPage - 1) * $scope.numPerPage;
                            end = begin + $scope.numPerPage;
                            index = scope.Table_Contratos.indexOf(value);
                            return (begin <= index && index < end);
                        }
                    }
                    else
                    {
                        scope.toast('info','No se encontraron registros','');
                        scope.Table_Contratos=[];
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
    ////////////////////////////////////////////////// PARA EL REPORTE RUEDA END ///////////////////////////////////////////////////////////////    
}