app.controller('Controlador_ConsumoCUPs', ['$http', '$scope', '$filter', '$route', '$interval', '$controller', '$cookies', '$compile', Controlador])

function Controlador($http, $scope, $filter, $route, $interval, $controller, $cookies, $compile) {
    var scope = this;
    scope.fdatos = {};
    //scope.CodConCom = $route.current.params.CodConCom;
    scope.Nivel = $cookies.get('nivel');
    var fecha = new Date();
    var dd = fecha.getDate();
    var mm = fecha.getMonth() + 1; //January is 0!
    var yyyy = fecha.getFullYear();
    scope.MostrarDatos=false;
    scope.totalCount=0;
    scope.ConsumoTotalFinal=0;
    if (dd < 10) {
        dd = '0' + dd
    }
    if (mm < 10) {
        mm = '0' + mm
    }
    var fecha = dd + '/' + mm + '/' + yyyy;
     ////////////////////////////////////////////////// PARA EL REPORTE CONSUMO CUPS START /////////////////////////////////////////////////////////////
    console.log($route.current.$$route.originalPath);
    scope.List_Comercializadora=[];
 
    
    scope.ComercializadorasActivas=function()
    {
        var url = base_urlHome()+"api/Reportes/ComActivas/";
        $http.get(url).then(function(result)
        {
            if(result.data!=false)
            {
                scope.List_Comercializadora=result.data;
            }
            else
            {
                scope.List_Comercializadora=[];
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
    $scope.submitFormConsumo = function(event) {
         
         if (!scope.validar_camposConsumos()) {
             return false;
         }        
            var url = base_urlHome() + "api/Reportes/Generar_ConsumoCUPS/";
            $http.post(url, scope.fdatos).then(function(result) 
            {
                if (result.data != false) 
                {
                    //var datax = JSON.parse(result.data);
                    console.log(result.data);
                    scope.totalCount=result.data.CountRegistro.total;
                    if(result.data.ConsumoElectrico.totalConsumoEle!=null && result.data.ConsumoElectrico.totalConsumoGas==null)
                    {
                        scope.ConsumoTotalFinal=result.data.ConsumoElectrico.totalConsumoEle;
                    }
                    else if(result.data.ConsumoElectrico.totalConsumoGas!=null && result.data.ConsumoElectrico.totalConsumoEle==null)
                    {
                        scope.ConsumoTotalFinal=result.data.ConsumoElectrico.totalConsumoGas;
                    }
                    else
                    {
                        scope.ConsumoTotalFinal=result.data.ConsumoElectrico.totalConsumoEle+result.data.ConsumoElectrico.totalConsumoGas;
                    }
                    scope.MostrarDatos=true;
                } 
                else 
                {
                    scope.toast('error','No se encontraton datos con la busqueda.','Error');
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
         
     };

     scope.validar_camposConsumos = function() {
        resultado = true;
        
        if(!scope.fdatos.CodCom>0)
        {
            scope.toast('error','Debe Seleccionar una Comercializadora','Comercializadoras');
            return false;
        }
        var FecDesde1 = document.getElementById("FecDesde").value;
        scope.FecDesde = FecDesde1;
        if (scope.FecDesde == null || scope.FecDesde == undefined || scope.FecDesde == '') {
             scope.toast('error','La Fecha Desde es requerida','');
             return false;
        } 
        else 
        {
            var FecDesde = (scope.FecDesde).split("/");
            if (FecDesde.length < 3) {
                 scope.toast('error','El Formato de Fecha Desde debe Ser EJ: DD/MM/YYYY.','');
                 event.preventDefault();
                 return false;
            } 
            else 
            {
                 if (FecDesde[0].length > 2 || FecDesde[0].length < 2) {
                     scope.toast('error','Por Favor Corrija el Formato del dia en la Fecha Desde deben ser 2 números solamente. EJ: 01','');
                     event.preventDefault();
                     return false;
                 }
                 if (FecDesde[1].length > 2 || FecDesde[1].length < 2) {
                    scope.toast('error','Por Favor Corrija el Formato del mes de la Fecha Desde deben ser 2 números solamente. EJ: 01','');
                   
                    event.preventDefault();
                    return false;
                 }
                 if (FecDesde[2].length < 4 || FecDesde[2].length > 4) {
                     scope.toast('error','Por Favor Corrija el Formato del ano en la Fecha Desde Ya que deben ser 4 números solamente.','');
                     
                     event.preventDefault();
                     return false;
                 }                
                 scope.fdatos.FecDesde = FecDesde[2] + "-" + FecDesde[1] + "-" + FecDesde[0];
            }
        }
        var FecHasta1 = document.getElementById("FecHasta").value;
        scope.FecHasta = FecHasta1;
        if (scope.FecHasta == null || scope.FecHasta == undefined || scope.FecHasta == '') {
             scope.toast('error','La Fecha Hasta es requerida','');
             return false;
        } 
        else 
        {
            var FecHasta = (scope.FecHasta).split("/");
            if (FecHasta.length < 3) {
                 scope.toast('error','El Formato de Fecha Hasta debe Ser EJ: DD/MM/YYYY.','');
                 event.preventDefault();
                 return false;
            } 
            else 
            {
                 if (FecHasta[0].length > 2 || FecHasta[0].length < 2) {
                     scope.toast('error','Por Favor Corrija el Formato del dia en la Fecha Hasta deben ser 2 números solamente. EJ: 01','');
                     event.preventDefault();
                     return false;
                 }
                 if (FecHasta[1].length > 2 || FecHasta[1].length < 2) {
                    scope.toast('error','Por Favor Corrija el Formato del mes de la Fecha Hasta deben ser 2 números solamente. EJ: 01','');
                   
                    event.preventDefault();
                    return false;
                 }
                 if (FecHasta[2].length < 4 || FecHasta[2].length > 4) {
                     scope.toast('error','Por Favor Corrija el Formato del ano en la Fecha Hasta Ya que deben ser 4 números solamente.','');
                     
                     event.preventDefault();
                     return false;
                 }                
                 scope.fdatos.FecHasta = FecHasta[2] + "-" + FecHasta[1] + "-" + FecHasta[0];
            }
        }
         if (resultado == false) {
             //quiere decir que al menos un renglon no paso la validacion
             return false;
         }
         return true;
     }
     scope.validar_formatos_input = function(metodo, object) {
         console.log(object);
         console.log(metodo);
         if (metodo == 1) {
             if (object != undefined) {
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




    scope.ComercializadorasActivas();
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
    ////////////////////////////////////////////////// PARA EL REPORTE CONSUMO CUPS END ///////////////////////////////////////////////////////////////    
}