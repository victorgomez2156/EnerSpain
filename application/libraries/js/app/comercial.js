app.controller('Controlador_Comercial', ['$http', '$scope', '$filter', '$route', '$interval', '$controller', '$cookies', Controlador]);

function Controlador($http, $scope, $filter, $route, $interval, $controller, $cookies) {
    var scope = this;
    scope.fdatos = {}; // datos del formulario
    scope.nID = $route.current.params.ID; //contiene el id del registro en caso de estarse consultando desde la grid
    scope.Nivel = $cookies.get('nivel');
    scope.TComercial = [];
    scope.TComercialBack = [];
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
    scope.CodEur='ES';
    scope.ruta_reportes_pdf_comercial = 0;
    scope.ruta_reportes_excel_comercial = 0;
    scope.NomCom = true;
    scope.NIFCom = true;
    scope.TelFijCom = true;
    scope.TelCelCom = true;
    scope.EmaCom = true;
    scope.EstCom = true;
    scope.AccCom = true;
    scope.topciones = [{ id: 1, nombre: 'VER' }, { id: 2, nombre: 'EDITAR' }, { id: 3, nombre: 'ACTIVAR' }, { id: 4, nombre: 'BLOQUEAR' }];
    console.log($route.current.$$route.originalPath);
    if ($route.current.$$route.originalPath == "/Editar_Comercial/:ID/:INF") {
       
        scope.validate_form = $route.current.params.INF;
        if (scope.validate_form != 1) {
            location.href = "#/Comercial";
        }
    }
    if ($route.current.$$route.originalPath == "/Agregar_Comercial/") 
    {
       
        scope.CIF_COMERCIAL = $cookies.get('CIF_COMERCIAL');
        if (scope.CIF_COMERCIAL == undefined) {
            location.href = "#/Comercial";
        } else {
            scope.fdatos.NIFCom = scope.CIF_COMERCIAL;
            scope.fdatos.FecIniCom=fecha;
            
            $('.datepicker').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.fdatos.FecIniCom);

        }
    }

    $scope.submitForm = function(event){

        if (!scope.validar_campos_datos_basicos()) {
            return false;
        }
        console.log(scope.fdatos);
        if (scope.fdatos.CodCom > 0) {
            var title = 'Actualizando';
            var text = '¿Seguro que desea modificar la información del Comercial?';
            var response = "Comercial actualizado de forma correcta";
        }
        if (scope.fdatos.CodCom == undefined) {
            $cookies.remove('CIF_COMERCIAL');
            var title = 'Guardando';
            var text = '¿Seguro que desea registrar el Comercial?';
            var response = "Comercial creado de forma correcta";
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
                $("#" + title).removeClass("loader loader-default").addClass("loader loader-default is-active");
                var url = base_urlHome() + "api/Comercial/crear_comercial/";
                $http.post(url, scope.fdatos).then(function(result) {
                    scope.nID = result.data.CodCom;
                    $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (scope.nID > 0) {
                        console.log(result.data);
                        scope.toast('success',response,'');
                        location.href = "#/Editar_Comercial/" + scope.nID;
                    } else {
                        scope.toast('error','Ha ocurrido durante el proceso, Por Favor Intente Nuevamente.','');
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
                console.log('Cancelando ando...');

            }
        });
    };
    scope.validar_campos_datos_basicos = function() {
        resultado = true;
        if (scope.fdatos.NomCom == null || scope.fdatos.NomCom == undefined || scope.fdatos.NomCom == '') {
           scope.toast('error',"El Nombre Comercial es requerido",'');           
            return false;
        }
        if (scope.fdatos.CarCom == null || scope.fdatos.CarCom == undefined || scope.fdatos.CarCom == '') {
           scope.fdatos.CarCom = null;
        }
        else
        {
            scope.fdatos.CarCom = scope.fdatos.CarCom;
        }
        var FecIniCom = document.getElementById("FecIniCom").value;
        scope.fdatos.FecIniCom = FecIniCom;
        if (scope.fdatos.FecIniCom == null || scope.fdatos.FecIniCom == undefined || scope.fdatos.FecIniCom == '') {
            scope.fdatos.FecIniCom = null;
            
        } else {
            var FecIniCom = (scope.fdatos.FecIniCom).split("/");
            if (FecIniCom.length < 3) {
               scope.toast('error',"El formato Fecha de Inicio correcto es DD/MM/YYYY",'');
                event.preventDefault();
                return false;
            } else {
                if (FecIniCom[0].length > 2 || FecIniCom[0].length < 2) {
                    scope.toast('error',"Error en Día, debe introducir dos números",'');
                    event.preventDefault();
                    return false;
                }
                if (FecIniCom[1].length > 2 || FecIniCom[1].length < 2) {
                    scope.toast('error',"Error en Mes, debe introducir dos números",'');
                    event.preventDefault();
                    return false;
                }
                if (FecIniCom[2].length < 4 || FecIniCom[2].length > 4) {
                  scope.toast('error',"Error en Año, debe introducir cuatro números",'');
                    event.preventDefault();
                    return false;
                }
                valuesStart = scope.fdatos.FecIniCom.split("/");
                valuesEnd = fecha.split("/");
                // Verificamos que la fecha no sea posterior a la actual
                var dateStart = new Date(valuesStart[2], (valuesStart[1] - 1), valuesStart[0]);
                var dateEnd = new Date(valuesEnd[2], (valuesEnd[1] - 1), valuesEnd[0]);
                if (dateStart > dateEnd) {
                    scope.toast('error',"La Fecha de Inicio no debe ser mayor al " + fecha + " Verifique e intente nuevamente",'');
                    return false;
                }
                scope.fdatos.FecIniCom = valuesStart[0] + "/" + valuesStart[1] + "/" + valuesStart[2];
            }
        }
        if (scope.fdatos.PorComCom == null || scope.fdatos.PorComCom == undefined || scope.fdatos.PorComCom == '') {
           scope.fdatos.PorComCom = null;
        }
        else
        {
            scope.fdatos.PorComCom =scope.fdatos.PorComCom;
        }
        if (scope.fdatos.TelFijCom == null || scope.fdatos.TelFijCom == undefined || scope.fdatos.TelFijCom == '') {
           scope.fdatos.TelFijCom = null;
        }
        else
        {
            scope.fdatos.TelFijCom = scope.fdatos.TelFijCom;
        }
        if (scope.fdatos.TelCelCom == null || scope.fdatos.TelCelCom == undefined || scope.fdatos.TelCelCom == '') {
           scope.toast('error',"El Teléfono Celular es requerido",'');
            return false;
        }
        if (scope.fdatos.EmaCom == null || scope.fdatos.EmaCom == undefined || scope.fdatos.EmaCom == '') {
           scope.toast('error',"El Email es requerido",'');
            return false;
        }
        if (scope.fdatos.ObsCom == null || scope.fdatos.ObsCom == undefined || scope.fdatos.ObsCom == '') {
            scope.fdatos.ObsCom = null;
        } else {
            scope.fdatos.ObsCom = scope.fdatos.ObsCom;
        } 
               
        if(scope.IBAN1==undefined||scope.IBAN1==null||scope.IBAN1=='')
        {
            scope.IBAN1=null;
        }
        else
        {
            if(scope.IBAN1.length<=3)
            {
                scope.toast('error','El IBAN1 Debe contener 4 números','');
                return false;
            }
        }
        if(scope.IBAN2==undefined||scope.IBAN2==null||scope.IBAN2=='')
        {
            scope.IBAN2=null;
        }
        else
        {
            if(scope.IBAN2.length<=3)
            {
                scope.toast('error','El IBAN2 Debe contener 4 números','');
                return false;
            }
        }
        if(scope.IBAN3==undefined||scope.IBAN3==null||scope.IBAN3=='')
        {
            scope.IBAN3=null;
        }
        else
        {
            if(scope.IBAN3.length<=3)
            {
                scope.toast('error','El IBAN3 Debe contener 4 números','');
                return false;
            }
        }
        if(scope.IBAN4==undefined||scope.IBAN4==null||scope.IBAN4=='')
        {
            scope.IBAN4=null;
        }
        else
        {
            if(scope.IBAN4.length<=3)
            {
                scope.toast('error','El IBAN4 Debe contener 4 números','');
                return false;
            }
        }
        if(scope.IBAN5==undefined||scope.IBAN5==null||scope.IBAN5=='')
        {
            scope.IBAN5=null;
        }
        else
        {
            if(scope.IBAN5.length<=3)
            {
                scope.toast('error','El IBAN5 Debe contener 4 números','');
                return false;
            }
        }


        if(scope.IBAN1!=null && scope.IBAN2!=null && scope.IBAN3!=null&& scope.IBAN4!=null && scope.IBAN5!=null)
        {
            if(scope.CodEur.length<=3)
            {
                scope.toast('error','Debe completar el Código ES','');
                return false;
            }
        }
        console.log(scope.IBAN1);
        console.log(scope.IBAN2);
        console.log(scope.IBAN3);
        console.log(scope.IBAN4);
        console.log(scope.IBAN5); 
        if (scope.IBAN1!=null && scope.IBAN2!=null && scope.IBAN3!=null&& scope.IBAN4!=null && scope.IBAN5!=null) 
        {
            scope.dig_control = scope.CodEur.substr(2, 4);
            scope.cod_pais = "1428";
            scope.tira_cuenta = scope.IBAN1 + scope.IBAN2 + scope.IBAN3 + scope.IBAN4 + scope.IBAN5;
            scope.tira_completa = scope.tira_cuenta + scope.cod_pais + scope.dig_control;
            scope.TIR_RES1 = scope.tira_completa.substr(0, 8);
            scope.VAL_TIR_RES1 = parseInt(scope.TIR_RES1);
            scope.VAL_RES_TIR_RES1 = scope.VAL_TIR_RES1 - (97 * parseInt(scope.VAL_TIR_RES1 / 97));
            var x = scope.VAL_RES_TIR_RES1,
                toString = x.toString(),
                toConcat = x + "";
            scope.CAR_RES_TIR_RES1 = toConcat;
            scope.TIR_RES2 = scope.CAR_RES_TIR_RES1 + scope.tira_completa.substr(8, 8);
            scope.VAL_TIR_RES2 = parseInt(scope.TIR_RES2);
            scope.VAL_RES_TIR_RES2 = scope.VAL_TIR_RES2 - (97 * parseInt(scope.VAL_TIR_RES2 / 97));
            scope.CAR_RES_TIR_RES2 = "0" + scope.VAL_RES_TIR_RES2;
            scope.TIR_RES3 = scope.CAR_RES_TIR_RES2 + scope.tira_completa.substr(16, 6);
            scope.VAL_TIR_RES3 = parseInt(scope.TIR_RES3);
            scope.VAL_RES_TIR_RES3 = scope.VAL_TIR_RES3 - (97 * parseInt(scope.VAL_TIR_RES3 / 97));
            var x1 = scope.VAL_RES_TIR_RES3,
                toString1 = x1.toString(),
                toConcat1 = x1 + "";
            scope.CAR_RES_TIR_RES3 = toConcat1;
            scope.TIR_RES4 = scope.CAR_RES_TIR_RES3 + scope.tira_completa.substr(22, 4);
            scope.VAL_TIR_RES4 = parseInt(scope.TIR_RES4);
            scope.VAL_RES_TIR_RES2 = scope.VAL_TIR_RES4 - (97 * parseInt(scope.VAL_TIR_RES4 / 97));
            console.log(scope.tira_cuenta);
            console.log(scope.dig_control);
            console.log(scope.cod_pais);
            console.log(scope.tira_completa);
            console.log(scope.TIR_RES1);
            console.log(scope.VAL_TIR_RES1);
            console.log(scope.VAL_RES_TIR_RES1);
            console.log(scope.CAR_RES_TIR_RES1);
            console.log(scope.TIR_RES2);
            console.log(scope.VAL_TIR_RES2);
            console.log(scope.VAL_RES_TIR_RES2);
            console.log(scope.CAR_RES_TIR_RES2);
            console.log(scope.TIR_RES3);
            console.log(scope.VAL_TIR_RES3);
            console.log(scope.VAL_RES_TIR_RES3);
            console.log(scope.CAR_RES_TIR_RES3);
            console.log(scope.TIR_RES4);
            console.log(scope.VAL_TIR_RES4);
            console.log(scope.VAL_RES_TIR_RES2);
            if (scope.VAL_RES_TIR_RES2 == 1){
                scope.fdatos.NumIBAN=scope.CodEur+scope.IBAN1 + scope.IBAN2 + scope.IBAN3 + scope.IBAN4 + scope.IBAN5;
                scope.toast('success','El IBAN que introdujo es correcto','');
                return true;
             }
             else{               
                scope.toast('error','El IBAN que introdujo es incorrecto, verifique e intente de nuevo.','');
                scope.fdatos.NumIBAN=null;
                scope.numIBanValidado = false;
                return false;              
            }        
        }
        else
        {
            scope.fdatos.NumIBAN=null;
        }
        if (resultado == false) {
            //quiere decir que al menos un renglon no paso la validacion
            return false;
        }
        return true;
    }
    scope.validar_inputs = function(metodo, object) {
        console.log(object);
        console.log(metodo);
        if (metodo == 1) {
            if (object != undefined) {
                numero = object;
                if (!/^([/0-9])*$/.test(numero))
                    scope.fdatos.FecIniCom = numero.substring(0, numero.length - 1);
            }
        }
        if (metodo == 2) {
            if (object != undefined) {
                numero = object;
                if (!/^([.0-9])*$/.test(numero))
                    scope.fdatos.PorComCom = numero.substring(0, numero.length - 1);
            }
        }
        if (metodo == 3) {
            if (object != undefined) {
                numero = object;
                if (!/^([0-9])*$/.test(numero))
                    scope.fdatos.TelFijCom = numero.substring(0, numero.length - 1);
            }
        }
        if (metodo == 4) {
            if (object != undefined) {
                numero = object;
                if (!/^([/0-9])*$/.test(numero))
                    scope.fdatos.TelCelCom = numero.substring(0, numero.length - 1);
            }
        }
    }
    scope.validar_email = function() {
        document.getElementById('EmaCli').addEventListener('input', function() {
            campo = event.target;
            valido = document.getElementById('emailOK');
            emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
            //Se muestra un texto a modo de ejemplo, luego va a ser un icono
            if (emailRegex.test(campo.value)) {
                valido.innerText = "";
                scope.disabled_button_by_email = false;
            } else {
                valido.innerText = "Email Incorrecto.";
                scope.disabled_button_by_email = true;
            }
        });
    }
    $scope.Consultar_DNI_NIE = function(event) {
        /*if (!scope.validarNIFDNI())
            {
                return false;
            }*/
        $("#comprobando_dni").removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url = base_urlHome() + "api/Comercial/comprobar_dni_nie/NIFComCon/" + scope.fdatos.NumDNI_NIECli;
        $http.get(url).then(function(result) {
            $("#comprobando_dni").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (result.data != false) {
                 scope.toast('error',"El Comercial ya se encuentra registrado",'');
                return false;
            } else {
                $("#modal_dni_comprobar").modal('hide');
                $cookies.put('CIF_COMERCIAL', scope.fdatos.NumDNI_NIECli);
                location.href = "#/Agregar_Comercial/";
            }
        }, function(error) {
            $("#comprobando_dni").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
    };
    $scope.SubmitFormFiltrosComercial = function(event) {
        if (scope.tmodal_data.tipo_filtro == 1) {
            $scope.predicate = 'id';
            $scope.reverse = true;
            $scope.currentPage = 1;
            $scope.order = function(predicate) {
                $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                $scope.predicate = predicate;
            };
            scope.TComercial = $filter('filter')(scope.TComercialBack, { EstCom: scope.tmodal_data.EstCom }, true);
            $scope.totalItems = scope.TComercial.length;
            $scope.numPerPage = 50;
            $scope.paginate = function(value) {
                var begin, end, index;
                begin = ($scope.currentPage - 1) * $scope.numPerPage;
                end = begin + $scope.numPerPage;
                index = scope.TComercial.indexOf(value);
                return (begin <= index && index < end);
            };
            scope.ruta_reportes_pdf_comercial = scope.tmodal_data.tipo_filtro + "/" + scope.tmodal_data.EstCom;
            scope.ruta_reportes_excel_comercial = scope.tmodal_data.tipo_filtro + "/" + scope.tmodal_data.EstCom;
        }
    };
    scope.regresar_filtro_comercial = function() {
        $scope.predicate = 'id';
        $scope.reverse = true;
        $scope.currentPage = 1;
        $scope.order = function(predicate) {
            $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
            $scope.predicate = predicate;
        };
        scope.TComercial = scope.TComercialBack;
        $scope.totalItems = scope.TComercial.length;
        $scope.numPerPage = 50;
        $scope.paginate = function(value) {
            var begin, end, index;
            begin = ($scope.currentPage - 1) * $scope.numPerPage;
            end = begin + $scope.numPerPage;
            index = scope.TComercial.indexOf(value);
            return (begin <= index && index < end);
        };
        scope.tmodal_data = {};
        scope.ruta_reportes_pdf_comercial = 0;
        scope.ruta_reportes_excel_comercial = 0;
    }
    scope.cargar_lista_comercial = function() {
        $("#cargando").removeClass("loader loader-default").addClass("loader loader-default  is-active");
        var url = base_urlHome() + "api/Comercial/list_comercial/";
        $http.get(url).then(function(result) {
            $("#cargando").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (result.data != false) {
                $scope.predicate = 'id';
                $scope.reverse = true;
                $scope.currentPage = 1;
                $scope.order = function(predicate) {
                    $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                    $scope.predicate = predicate;
                };
                scope.TComercial = result.data;
                scope.TComercialBack = result.data;
                $scope.totalItems = scope.TComercial.length;
                $scope.numPerPage = 50;
                $scope.paginate = function(value) {
                    var begin, end, index;
                    begin = ($scope.currentPage - 1) * $scope.numPerPage;
                    end = begin + $scope.numPerPage;
                    index = scope.TComercial.indexOf(value);
                    return (begin <= index && index < end);
                };
                console.log(scope.TComercial);
            } else {
                scope.TComercial = [];
                scope.TComercialBack = [];
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
        if (scope.fdatos.CodCom == undefined) {
            scope.fdatos = {};
            scope.fdatos.NIFCom = scope.CIF_COMERCIAL;
        } else {
            console.log('No existen datos por limpiar');
        }
    }
    scope.regresar = function() {
        if (scope.fdatos.CodCom == undefined) {
            Swal.fire({
                title: "¿Seguro de cerrar?",
                type: "question",
                showCancelButton: !0,
                confirmButtonColor: "#31ce77",
                cancelButtonColor: "#f34943",
                confirmButtonText: "OK"
            }).then(function(t) {
                if (t.value == true) {
                    $cookies.remove('CIF_COMERCIAL');
                    location.href = "#/Comercial/";
                } else {
                    console.log('Cancelando ando...');
                }
            });
        } else {
            $cookies.remove('CIF_COMERCIAL');
            scope.fdatos = {};
            location.href = "#/Comercial/";
        }
    }

    scope.modal_agg_comercial = function() {
        scope.fdatos = {};
        $("#modal_dni_comprobar").modal('show');
    }
    scope.buscarXID = function() {
        $("#cargando_I").removeClass("loader loader-default").addClass("loader loader-default  is-active");
        var url = base_urlHome() + "api/Comercial/buscar_xID_Comercial/CodCom/" + scope.nID;
        $http.get(url).then(function(result) {
            $("#cargando_I").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (result.data != false) {
                scope.fdatos = result.data;
                if(result.data.IBANBD!=null)
                {
                    var CodBan = result.data.IBANBD.substring(0, 4);
                    var IBAN1 = result.data.IBANBD.substring(4, 8);
                    var IBAN2 = result.data.IBANBD.substring(8, 12);
                    var IBAN3 = result.data.IBANBD.substring(12,16);
                    var IBAN4 = result.data.IBANBD.substring(16,20);
                    var IBAN5 = result.data.IBANBD.substring(20, 24);
                    scope.CodEur=CodBan;
                    scope.IBAN1=IBAN1;
                    scope.IBAN2=IBAN2;
                    scope.IBAN3=IBAN3;
                    scope.IBAN4=IBAN4;
                    scope.IBAN5=IBAN5;
                }
                $('.datepicker').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", result.data.FecIniCom);
                console.log(scope.fdatos);
            } else {
               scope.toast('error',"Hubo un error al intentar cargar los datos.",'');
            }
        }, function(error) {
            $("#cargando_I").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
    scope.borrar_row = function(index, id) {
        if (scope.Nivel == 3) {
          scope.toast('error',"No tiene permisos para realizar esta operación",'Usuario no Autorizado');
            return false;
        }
        bootbox.confirm({
            title: "Confirmación",
            message: "¿Seguro que desea eliminar el Comercial?",
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> Cancelar'
                },
                confirm: {
                    label: '<i class="fa fa-check"></i> Confirmar'
                }
            },
            callback: function(result) {
                if (result == false) {
                    console.log('Cancelando Ando...');
                } else {
                    $("#borrando").removeClass("loader loader-default").addClass("loader loader-default  is-active");
                    var url = base_urlHome() + "api/Comercial/borrar_row_comercial/CodCom/" + id;
                    $http.delete(url).then(function(result) {
                        $("#borrando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                        if (result.data != false) {
                             scope.toast('success',"Registro eliminado de forma correcta",'');
                            scope.TComercial.splice(index, 1);
                        } else {
                           scope.toast('error',"Error Al Borrar el Registro.",'');
                        }
                    }, function(error) {
                        $("#borrando").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
        });
    }
    scope.borrar = function() {
        if (scope.Nivel == 3) {
          scope.toast('error',"No tiene permisos para realizar esta operación",'Usuario no Autorizado');
            return false;
        }
        bootbox.confirm({
            title: "Confirmación",
            message: "¿Seguro que desea eliminar el Comercial?",
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> Cancelar'
                },
                confirm: {
                    label: '<i class="fa fa-check"></i> Confirmar'
                }
            },
            callback: function(result) {
                if (result == false) {
                    console.log('Cancelando Ando...');
                } else {
                    $("#borrando").removeClass("loader loader-default").addClass("loader loader-default  is-active");
                    var url = base_urlHome() + "api/Comercial/borrar_row_comercial/CodCom/" + scope.fdatos.CodCom;
                    $http.delete(url).then(function(result) {
                        $("#borrando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                        if (result.data != false) {
                           scope.toast('success',"Registro eliminado de forma correcta",'');
                            location.href = "#/Comercial";
                        } else {
                            scope.toast('error',"Error Al Borrar el Registro.",'');
                        }
                    }, function(error) {
                        $("#borrando").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
        });
    }
    scope.validar_opcion = function(index, opcion, datos) {
        if (opcion == 1) {
            location.href = "#/Editar_Comercial/" + datos.CodCom + "/" + 1;
        }
        if (opcion == 2) {
            location.href = "#/Editar_Comercial/" + datos.CodCom;
        }
        if (opcion == 3) {
            scope.opciones_comercial[index] = undefined;
            if (datos.EstCom == 1) {
            scope.toast('error',"Ya este Comercial se encuentra activo.",'');
                return false;
            }
            Swal.fire({
                title: "¿Esta Seguro de Activar Este Comercial?",
                type: "info",
                showCancelButton: !0,
                confirmButtonColor: "#31ce77",
                cancelButtonColor: "#f34943",
                confirmButtonText: "Activar"
            }).then(function(t) {
                if (t.value == true) {
                    scope.datos_update = {};
                    scope.datos_update.EstCom = 1;
                    scope.datos_update.CodCom = datos.CodCom;
                    console.log(scope.datos_update);
                    var url = base_urlHome() + "api/Comercial/update_status/";
                    $http.post(url, scope.datos_update).then(function(result) {
                        if (result.data != false) {
                            scope.toast('success',"El Comercial ha sido activado correctamente.",'');
                            scope.cargar_lista_comercial();
                            scope.opciones_comercial[index] = undefined;
                        } else {
                           scope.toast('error',"Hubo un error al ejecutar esta acción por favor intente nuevamente.",'');
                            scope.cargar_lista_comercial();
                        }
                    }, function(error) {
                        //$("#comprobando_disponibilidad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
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
                    console.log('Cancelando ando...');
                    scope.opciones_comercial[index] = undefined;
                }
            });

        }
        if (opcion == 4) {
            scope.opciones_comercial[index] = undefined;
            if (datos.EstCom == 2) {
                scope.toast('error',"Ya este Comercial se encuentra bloqueado.",'');
                return false;
            }
            scope.datos_update = {};
            scope.datos_update.CodCom = datos.CodCom;
            scope.NIFCom = datos.NIFCom;
            scope.NomCom = datos.NomCom;
            scope.FechBloCom = fecha;
            $('.datepicker').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.FechBloCom);
            scope.datos_update.EstCom = 2;
            $("#modal_motivo_bloqueo").modal('show');
        }
    }
    $scope.submitFormlock = function(event) {
        var FechBloCom = document.getElementById("FechBloCom").value;
        scope.FechBloCom = FechBloCom;
        if (scope.FechBloCom == null || scope.FechBloCom == undefined || scope.FechBloCom == '') {
            scope.toast('error',"La Fecha de Bloqueo es requerida.",'');
            return false;
        } else {
            var FechBloCom = (scope.FechBloCom).split("/");
            if (FechBloCom.length < 3) {
                scope.toast('error',"El formato Fecha de Bloqueo correcto es DD/MM/YYYY.",'');
                event.preventDefault();
                return false;
            } else {
                if (FechBloCom[0].length > 2 || FechBloCom[0].length < 2) {
                    scope.toast('error',"Error en Día, debe introducir dos números.",'');
                    event.preventDefault();
                    return false;
                }
                if (FechBloCom[1].length > 2 || FechBloCom[1].length < 2) {
                     scope.toast('error',"Error en Mes, debe introducir dos números.",'');
                    event.preventDefault();
                    return false;
                }
                if (FechBloCom[2].length < 4 || FechBloCom[2].length > 4) {
                    scope.toast('error',"Error en Año, debe introducir cuatro números.",'');
                    event.preventDefault();
                    return false;
                }
                valuesStart = scope.FechBloCom.split("/");
                valuesEnd = fecha.split("/");
                // Verificamos que la fecha no sea posterior a la actual
                var dateStart = new Date(valuesStart[2], (valuesStart[1] - 1), valuesStart[0]);
                var dateEnd = new Date(valuesEnd[2], (valuesEnd[1] - 1), valuesEnd[0]);
                if (dateStart > dateEnd) {
                    scope.toast('error',"La Fecha de Bloqueo no puede ser mayor al " + fecha + " Verifique e intente nuevamente.",'');
                    return false;
                }
                scope.datos_update.FechBloCom = valuesStart[2] + "/" + valuesStart[1] + "/" + valuesStart[0];
            }
        }
        if (scope.datos_update.ObsBloCom == null || scope.datos_update.ObsBloCom == undefined || scope.datos_update.ObsBloCom == '') {
            scope.datos_update.ObsBloCom = null;
        } else {
            scope.datos_update.ObsBloCom = scope.datos_update.ObsBloCom;
        }
        console.log(scope.datos_update);
        Swal.fire({
            title: 'BLOQUEAR',
            text: "¿Seguro que desea de bloquear el Comercial?",
            type: "question",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: "Confirmar"
        }).then(function(t) {
            if (t.value == true) {
                $("#bloqueando").removeClass("loader loader-default").addClass("loader loader-default is-active");
                var url = base_urlHome() + "api/Comercial/update_status/";
                $http.post(url, scope.datos_update).then(function(result) {
                    $("#bloqueando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (result.data.resultado != false) {
                        console.log(result.data);
                        scope.datos_update = {};
                        scope.toast('success',"Comercial Bloqueado Correctamente.",'');
                        $("#modal_motivo_bloqueo").modal('hide');
                        scope.cargar_lista_comercial();
                    } else {
                        scope.toast('error',"Ha ocurrido durante el proceso, Por Favor Intente Nuevamente.",'');
                       
                    }
                }, function(error) {
                    $("#bloqueando").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
                console.log('Cancelando ando...');

            }
        });
    };
    scope.FetchComercial = function()
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
             scope.TComercial=scope.TComercialBack;
            $scope.totalItems = scope.TComercial.length;
            $scope.numPerPage = 50;
            $scope.paginate = function(value) {
                var begin, end, index;
                begin = ($scope.currentPage - 1) * $scope.numPerPage;
                end = begin + $scope.numPerPage;
                index = scope.TComercial.indexOf(value);
                return (begin <= index && index < end);
            };
            scope.ruta_reportes_pdf_comercial = 0;
            scope.ruta_reportes_excel_comercial =0;
        }
        else
        {
            if(scope.filtrar_search.length>=2)
            {
                scope.fdatos.filtrar_search=scope.filtrar_search;   
                var url = base_urlHome()+"api/Comercial/geTComercialFilter";
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
                         scope.TComercial=result.data;
                        $scope.totalItems = scope.TComercial.length;
                        $scope.numPerPage = 50;
                        $scope.paginate = function(value) {
                            var begin, end, index;
                            begin = ($scope.currentPage - 1) * $scope.numPerPage;
                            end = begin + $scope.numPerPage;
                            index = scope.TComercial.indexOf(value);
                            return (begin <= index && index < end);
                        };
                        scope.ruta_reportes_pdf_comercial = 2 + "/" + scope.filtrar_search;
                        scope.ruta_reportes_excel_comercial = 2 + "/" + scope.filtrar_search;
                    }
                    else
                    {
                        
                        scope.TComercial=[];                       
                        scope.ruta_reportes_pdf_comercial = 0;
                        scope.ruta_reportes_excel_comercial =0;
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
     ///////// PARA CALCULAR DNI/NIE START /////////////////
    scope.validarNIFDNI=function()
    {
        var letter = scope.validar_dni_nie($("#NumDNI_NIECli").parent(),$("#NumDNI_NIECli").val());
        if(letter != false)
        {
            //$("#iLetter").replaceWith("<p id='iLetter' class='ok'>La letra es: <strong>" + letter+ "</strong></p>");
            scope.dni_nie_validar = scope.fdatos.NumDNI_NIECli.substring(0,8)+letter;
            if(scope.dni_nie_validar!=scope.fdatos.NumDNI_NIECli)
            {
               scope.toast('error',"El Número de DNI/NIE es Invalido Intente Nuevamente.",'');
                return false;
            }
            else
            {
                return true;
            }  
        }
        else
        {
          scope.toast('error',"Debe ingresar los 9 Números de su DNI/NIE EJ: 12345678F/Y1234567B",'');
            //$("#iLetter").replaceWith("<p id='iLetter' class='error'>Esperando a los n&uacute;meros</p>");
        }
        //console.log(letter);
        //console.log($("#NIFConCli").val() + letter);
    }    
    function isNumeric(expression) {
    return (String(expression).search(/^\d+$/) != -1);
    }
    function calculateLetterForDni(dni)
    {
        // Letras en funcion del modulo de 23
        string = "TRWAGMYFPDXBNJZSQVHLCKET"
        // se obtiene la posiciÃ³n de la cadena anterior
        position = dni % 23
        // se extrae dicha posiciÃ³n de la cadena
        letter = string.substring(position, position + 1)
        return letter
    }
    scope.validar_dni_nie=function(field, txt)
    {
        var letter = ""
        // Si es un dni extrangero, es decir, empieza por X, Y, Z
        // Si la longitud es 8 longitud total de los dni nacionales)
        if (txt.length == 9) 
        {
          
            var first = txt.substring(0, 1)
            var last = txt.substring(8,9)
            if (first == 'X' || first == 'Y' || first == 'Z') 
            {               
                // Si la longitud es 9(longitud total de los dni extrangeros)
                // Se calcula la letra para el numero de dni
                var number = txt.substring(1, 8);
                console.log(number)
                if (first == 'X') {
                    number = '0' + number
                    //final = first + number
                }
                if (first == 'Y') {
                    number = '1' + number
                    //final = first + number
                }
                if (first == 'Z') {
                    number = '2' + number
                    //final = first + number
                }
                
                if (isNumeric(number)){
                    letter = calculateLetterForDni(number)
                }
                return letter

            } else {
              
                letter = calculateLetterForDni(txt.substring(0, 8))                
                return letter
            }
        }
        else
        {
            return false
        }
       
    } 
    scope.validarsinuermoCodEur=function(object)
    {
        if(object==undefined||object==null||object=='')
        {
            scope.CodEur='ES';
        }
        if(object.length<1)
        {
            scope.CodEur='ES';
        }
        else if(object.length<2)
        {
            scope.CodEur='ES';
        }
        else if(object.length>2)
        {
            var first = object.substring(0, 2);
            var last = object.substring(2, 4);
            if(first!='ES')
            {
                scope.CodEur=undefined;
                scope.CodEur="ES";
            }
        }      
    } 
    scope.validarsinuermoIBAN = function(IBAN, object) 
    {
        if (object != undefined && IBAN == 1) {
             numero = object;
             if (!/^([0-9])*$/.test(numero))
                scope.IBAN1 = numero.substring(0, numero.length - 1);
        }
         if (object != undefined && IBAN == 2) {
             numero = object;
             if (!/^([0-9])*$/.test(numero))
                 scope.IBAN2 = numero.substring(0, numero.length - 1);
         }
         if (object != undefined && IBAN == 3) {
             numero = object;
             if (!/^([0-9])*$/.test(numero))
                 scope.IBAN3 = numero.substring(0, numero.length - 1);
         }
         if (object != undefined && IBAN == 4) {
             numero = object;
             if (!/^([0-9])*$/.test(numero))
                 scope.IBAN4 = numero.substring(0, numero.length - 1);
         }
         if (object != undefined && IBAN == 5) {
             numero = object;
             if (!/^([0-9])*$/.test(numero))
                 scope.IBAN5 = numero.substring(0, numero.length - 1);
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

    

    if (scope.nID != undefined) 
    {
        scope.buscarXID();
    }

}