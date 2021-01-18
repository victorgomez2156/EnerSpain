    app.controller('Controlador_Activaciones', ['$http', '$scope', '$filter', '$route', '$interval', '$controller', '$cookies', Controlador]);

    function Controlador($http, $scope, $filter, $route, $interval, $controller, $cookies) 
    {
        var scope = this;
        scope.fdatos = {}; // datos del formulario
        //scope.nID = $route.current.params.ID; //contiene el id del registro en caso de estarse consultando desde la grid
        scope.Nivel = $cookies.get('nivel');
        scope.T_Contratos = [];
        scope.T_ContratosBack = [];
        scope.VistaResponse=false;
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
            if(scope.CUPsName.length<20)
            {
                scope.toast('error','El Campo CUPs debe estar Completo con sus 20 digitos.','Error');
                return false;
            }
            console.log(scope.CUPsName.length);
            if(scope.CUPsName.length>=20)
            {
                $("#buscando").removeClass("loader loader-default").addClass("loader loader-default  is-active");
                var url = base_urlHome() + "api/Activaciones/getCUPsActivaciones/CUPsName/"+scope.CUPsName;
                $http.get(url).then(function(result){
                    $("#buscando").removeClass("loader loader-default  is-active").addClass("loader loader-default");
                    if (result.data != false) 
                    {                        
                        if(result.data.status==400 && result.data.statusText=='CUPs Sin Contrato')
                        {
                            scope.toast('error',result.data.menssage,result.data.statusText);
                            return false;
                        }
                        if(result.data.status==200 && result.data.statusText=='Contratos')
                        {
                            scope.toast('success',result.data.menssage,result.data.statusText);
                            scope.T_Contratos=result.data.ListContratos;
                            $("#modal_lista_contratos").modal('show');
                            return false;
                        }                              
                    } 
                    else 
                    {
                            scope.toast('error','No hay CUPs registrados','Error');                             
                    }
                }, function(error) 
                {
                        $("#buscando").removeClass("loader loader-default  is-active").addClass("loader loader-default");
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
        scope.asignarcontrato=function(index,dato,status)
        {
            //console.log(index);
            //console.log(dato);
            scope.VistaResponse=true;
            scope.RazSocCli=dato.RazSocCli;
            scope.CUPsName=dato.CUPsName;
            scope.NomTar=dato.NomTar;
            scope.DesPro=dato.DesPro;
            scope.FecActCUPs=dato.FecActCUPs;
            scope.fdatos.CodConCom=dato.CodConCom;
            scope.fdatos.CodCups=dato.CodCups;
            scope.fdatos.TipCups=dato.TipCups;
            scope.fdatos.CodProCom=dato.CodProCom;
            scope.fdatos.CodProComCli=dato.CodProComCli;
            scope.fdatos.CodProComCup=dato.CodProComCup;
            $('.FecActCUPs').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.FecActCUPs);
            scope.FecVenCUPs=dato.FecVenCUPs;
            $('.FecVenCUPs').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.FecVenCUPs);
            scope.ConCup=dato.ConCup;
        }
         $scope.submitFormCUPsActivacionesFechas = function(event) {
         
         if (!scope.validar_campos_activaciones()) {
             return false;
         }
         console.log(scope.fdatos);
            var title = 'Actualizando';
            var text = '¿Seguro que desea modificar la información del contrato?';
            var response = "información modificada correctamente.";
       
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
                 scope.guardar();
             } else {
                 event.preventDefault();
             }
         });
     };
     scope.validar_campos_activaciones = function() {
         
        resultado = true;
        var FecActCUPs = document.getElementById("FecActCUPs").value;
        scope.FecActCUPs = FecActCUPs;
        if (scope.FecActCUPs == null || scope.FecActCUPs == undefined || scope.FecActCUPs == '') 
        {
             scope.fdatos.FecActCUPs=null;
        } 
        else 
        {
            var FecActCUPsFinal = (scope.FecActCUPs).split("/");
            if (FecActCUPsFinal.length < 3) {
                 scope.toast('error','El formato de Fecha de Activación correcto es DD/MM/YYYY','');
                 event.preventDefault();
                 return false;
            } else {
                 if (FecActCUPsFinal[0].length > 2 || FecActCUPsFinal[0].length < 2) {
                     scope.toast('error','Error en Día, debe introducir dos números','');
                     event.preventDefault();
                     return false;
                 }
                 if (FecActCUPsFinal[1].length > 2 || FecActCUPsFinal[1].length < 2) {
                     scope.toast('error','Error en Mes, debe introducir dos números','');
                     event.preventDefault();
                     return false;
                 }
                 if (FecActCUPsFinal[2].length < 4 || FecActCUPsFinal[2].length > 4) {
                     scope.toast('error','Error en Año, debe introducir cuatro números','');
                     event.preventDefault();
                     return false;
                }                 
                scope.fdatos.FecActCUPs = FecActCUPsFinal[2] + "-" + FecActCUPsFinal[1] + "-" + FecActCUPsFinal[0];
            }
        }
        var FecVenCUPs = document.getElementById("FecVenCUPs").value;
        scope.FecVenCUPs = FecVenCUPs;
        if (scope.FecVenCUPs == null || scope.FecVenCUPs == undefined || scope.FecVenCUPs == '') 
        {
             scope.fdatos.FecVenCUPs=null;
        } 
        else 
        {
            var FecVenCUPsFinal = (scope.FecVenCUPs).split("/");
            if (FecVenCUPsFinal.length < 3) {
                 scope.toast('error','El formato de Fecha de Activación correcto es DD/MM/YYYY','');
                 event.preventDefault();
                 return false;
            } else {
                 if (FecVenCUPsFinal[0].length > 2 || FecVenCUPsFinal[0].length < 2) {
                     scope.toast('error','Error en Día, debe introducir dos números','');
                     event.preventDefault();
                     return false;
                 }
                 if (FecVenCUPsFinal[1].length > 2 || FecVenCUPsFinal[1].length < 2) {
                     scope.toast('error','Error en Mes, debe introducir dos números','');
                     event.preventDefault();
                     return false;
                 }
                 if (FecVenCUPsFinal[2].length < 4 || FecVenCUPsFinal[2].length > 4) {
                     scope.toast('error','Error en Año, debe introducir cuatro números','');
                     event.preventDefault();
                     return false;
                 }                 
                 scope.fdatos.FecVenCUPs = FecVenCUPsFinal[2] + "-" + FecVenCUPsFinal[1] + "-" + FecVenCUPsFinal[0];
             }
         }
         if (scope.ConCup == undefined || scope.ConCup == null || scope.ConCup == '') {
             scope.ConCup = null;
             scope.fdatos.ConCup = null;
         } else {
             scope.fdatos.ConCup = scope.ConCup;
         }
         if (resultado == false) {
             //quiere decir que al menos un renglon no paso la validacion
             return false;
         }
         return true;
     }
     scope.guardar = function() {
         
        var title = 'Actualizando';
        var text = '¿Seguro que desea modificar la información del contrato?';
        var response = "información modificada correctamente.";
         $("#" + title).removeClass("loader loader-default").addClass("loader loader-default is-active");
         var url = base_urlHome() + "api/Activaciones/UpdateInformationContratos/";
         $http.post(url, scope.fdatos).then(function(result) {             
             $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
             if(result.data!=false)
             {
                scope.toast('success','información actualizada correctamente.','Contrato');
                scope.buscarCUPsActivaciones();
             }
             else
             {
                scope.toast('error','Error Actualizando información intente nuevamente.','Error');
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