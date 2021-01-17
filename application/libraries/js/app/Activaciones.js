    app.controller('Controlador_Activaciones', ['$http', '$scope', '$filter', '$route', '$interval', '$controller', '$cookies', Controlador]);

    function Controlador($http, $scope, $filter, $route, $interval, $controller, $cookies) 
    {
        var scope = this;
        scope.fdatos = {}; // datos del formulario
        //scope.nID = $route.current.params.ID; //contiene el id del registro en caso de estarse consultando desde la grid
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
        scope.CUPsName='ES';
        
        scope.buscarCUPsActivaciones=function()
        {
            console.log(scope.CUPsName.length);
            if(scope.CUPsName.length>5)
            {
                var url = base_urlHome() + "api/Activaciones/getCUPsActivaciones/CUPsName/"+scope.CUPsName;
                $http.get(url).then(function(result) {
                    if (result.data != false) 
                    {
                        console.log(result.data);
                              
                    } 
                    else 
                    {
                            scope.toast('error','No hay CUPs registrados','Error');                             
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
        



















        var i = -1;
        var toastCount = 0;
        var $toastlast;
        var getMessage = function () {
        var msgs = ['My name is Inigo Montoya. You killed my father. Prepare to die!',
                    '<div><input class="input-small" value="textbox"/>&nbsp;<a href="http://johnpapa.net" target="_blank">This is a hyperlink</a></div><div><button type="button" id="okBtn" class="btn btn-primary">Close me</button><button type="button" id="surpriseBtn" class="btn" style="margin: 0 8px 0 8px">Surprise me</button></div>',
                    'Are you the six fingered man?',
                    'Inconceivable!',
                    'I do not think that means what you think it means.',
                    'Have fun storming the castle!'];
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
    }