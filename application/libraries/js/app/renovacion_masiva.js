app.controller('Controlador_Renovaciones_Masivas', ['$http', '$scope', '$filter', '$route', '$interval', '$controller', '$cookies', Controlador]);

function Controlador($http, $scope, $filter, $route, $interval, $controller, $cookies) {
    var scope = this;
    scope.fdatos = {}; // datos del formulario
    scope.frenovaciones={};
    scope.frenovaciones.detalle=[];
    scope.Nivel = $cookies.get('nivel');
    scope.T_Contratos_Renovaciones = [];
    scope.T_Contratos_RenovacionesBack = [];
    scope.fdatos.ContratoDetalle=[];
    scope.Select_DetalleContratos=[];
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
    //console.log($route.current.$$route.originalPath);
    scope.paginate='5';
    scope.fdatos.CambiarProAne=false;
    scope.ConfirRenovacion=false;
    scope.CargarDatosServer=function()
    {
         var url = base_urlHome() + "api/RenovacionMasiva/DatosServer";
         $http.get(url).then(function(result)
         {
            if(result.data!=false)
            {
                scope.FecDesde=result.data.FecDesde;
                $('.FecDesde').datepicker({format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.FecDesde);
                scope.FecHasta=result.data.FecHasta;
                $('.FecHasta').datepicker({format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.FecHasta);
                scope.List_Comercializadoras=result.data.Comercializadoras;
            }
            else
            {
                scope.toast('error','Error al cargar los datos.','');
                //scope.T_Contratos_Renovaciones=[];
                //scope.T_Contratos_RenovacionesBack=[];
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
     $scope.submitFormRenovacionesMasivas = function(event)
     {
        //console.log(scope.fdatos);
        if (!scope.validar_campos_masiva()) {
            return false;
        }
        $("#RenovacionMasiva").removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url=base_urlHome()+"api/RenovacionMasiva/Consultar_Contratos/";
        $http.post(url,scope.fdatos).then(function(result)
        {
            $("#RenovacionMasiva").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if(result.data!=false)
            {
                if(result.data.response==false)
                {
                    scope.toast('error','No se encontraron Contratos con los datos ingresado','');
                    scope.T_Contratos_Renovaciones=[];
                    scope.T_Contratos_RenovacionesBack=[];
                }
                else
                {
                    $scope.predicate = 'id';
                    $scope.reverse = true;
                    $scope.currentPage = 1;
                    $scope.order = function(predicate) {
                        $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                        $scope.predicate = predicate1;
                    };
                    scope.T_Contratos_Renovaciones=result.data.response;
                    scope.T_Contratos_RenovacionesBack=result.data.response;
                    $scope.totalItems = scope.T_Contratos_Renovaciones.length;
                    $scope.numPerPage = scope.paginate;
                    $scope.paginate = function(value) {
                        var begin, end, index;
                        begin = ($scope.currentPage - 1) * $scope.numPerPage;
                        end = begin + $scope.numPerPage;
                        index = scope.T_Contratos_Renovaciones.indexOf(value);
                        return (begin <= index && index < end);
                    };

                }
                
            }
            else
            {
                scope.T_Contratos_Renovaciones=[];
                scope.T_Contratos_RenovacionesBack=[];
                return false;
            }

        },function(error)
        {
                    $("#RenovacionMasiva").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    //console.log(error);        
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
     scope.validar_campos_masiva = function() {
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
        if(!scope.fdatos.CodCom>0)
        {
            scope.toast('error','Debe seleccionar una Comercializadora de la lista.','Comercializadora');
            event.preventDefault();
            return false;
        }
        if(!scope.fdatos.CodPro>0)
        {
            scope.toast('error','Debe seleccionar un Producto de la lista.','Producto');
            event.preventDefault();
            return false;
        }
        if(!scope.fdatos.CodAnePro>0)
        {
            scope.toast('error','Debe seleccionar un Anexo de la lista.','Anexo');
            event.preventDefault();
            return false;
        }
        if (resultado == false) {
            //quiere decir que al menos un renglon no paso la validacion
            return false;
        }
        return true;
    }
    scope.FilterProductosAnexos=function(CodFilter,Metodo)
    {        
        if(CodFilter==0)
        {
            scope.List_Anexos=[];
            scope.List_AnexosNew=[];
            return false;
        }
        for (var i = 0; i < scope.List_Comercializadoras.length; i++) {
             if (scope.List_Comercializadoras[i].CodCom == CodFilter) {
                //console.log(scope.List_Comercializadoras[i]);
                scope.NomComer = scope.List_Comercializadoras[i].NomComCom;               
            }
        }
        $("#Consultando").removeClass("loader loader-default").addClass("loader loader-default  is-active");
        var url=base_urlHome()+"api/RenovacionMasiva/SearchFilterProdAne/Metodo/"+Metodo+"/CodFilter/"+CodFilter;
        $http.get(url).then(function(result)
        {
            $("#Consultando").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if(result.data!=false)
            {
                if(Metodo==1)
                {
                    scope.List_Productos=result.data;
                    scope.List_ProductosNew=result.data;  
                }
                else if(Metodo==2)
                {
                    scope.List_Anexos=result.data;
                    scope.List_AnexosNew=result.data; 
                } 
                else if(Metodo==3)
                {
                    scope.List_AnexosNew=result.data; 
                }                
            }
            else
            {
                if(Metodo==1)
                {
                    scope.toast('error','Comercializadora sin productos asignados','');
                    scope.List_Productos=[];
                    scope.List_ProductosNew=[]; 
                }
                else if(Metodo==2)
                { 
                    scope.toast('error','Producto sin anexos asignados','');                    
                    scope.List_Anexos=[];
                    scope.List_AnexosNew=[]; 
                }
                else if(Metodo==3)
                { 
                    scope.toast('error','Producto sin anexos asignados','');
                    scope.List_AnexosNew=[]; 
                }

            }
        },function(error)
        {
            $("#Consultando").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
    scope.agregarContratosDetalle = function(index, CodConCom, dato) 
    {
        scope.Select_DetalleContratos[CodConCom] = dato;
        var ObjDetCom = new Object();
        if (scope.fdatos.ContratoDetalle == undefined || scope.fdatos.ContratoDetalle == false){
            scope.fdatos.ContratoDetalle = [];
        }
        scope.fdatos.ContratoDetalle.push({ CodConCom:dato.CodConCom,CodPro:dato.CodPro,CodCom:dato.CodCom,CodAnePro:dato.CodAnePro,CodProCom:dato.CodProCom,CodCli:dato.CodCli,DurCon:dato.DurCon
            ,FecVenCon:dato.FecVenCon});       
        scope.CountContratos=scope.fdatos.ContratoDetalle.length;             
        
    }
    scope.quitarContratosDetalle = function(index, CodConCom, dato) {
        
        scope.Select_DetalleContratos[CodConCom] = false;
        i = 0;
        for (var i = 0; i < scope.fdatos.ContratoDetalle.length; i++) {
            if (scope.fdatos.ContratoDetalle[i].CodConCom == CodConCom) {
                scope.fdatos.ContratoDetalle.splice(i, 1);
            }
        }
        //console.log(scope.Select_DetalleContratos); 
        //console.log(scope.fdatos.ContratoDetalle);
        scope.CountContratos=scope.fdatos.ContratoDetalle.length;
    };
    scope.AgregarTodosContratos=function()
    {
        if(scope.T_Contratos_Renovaciones.length==0)
        {
            scope.toast('error','No ahí contratos para seleccionar','Error');
            return false;
        }        
        angular.forEach(scope.T_Contratos_Renovaciones, function(Contratos_Renovaciones) 
        {
            scope.Select_DetalleContratos[Contratos_Renovaciones.CodConCom] = Contratos_Renovaciones;
            var ObjDetCom = new Object();
            if (scope.fdatos.ContratoDetalle == undefined || scope.fdatos.ContratoDetalle == false){
                scope.fdatos.ContratoDetalle = [];
            }
            if(scope.fdatos.ContratoDetalle.length>0)
            {
                for (var i = 0; i < scope.fdatos.ContratoDetalle.length; i++) {
                    if (scope.fdatos.ContratoDetalle[i].CodConCom == Contratos_Renovaciones.CodConCom) {
                        scope.fdatos.ContratoDetalle.splice(i, 1);
                        scope.Select_DetalleContratos[Contratos_Renovaciones.CodConCom] = false;
                    }
                } 
            }
            scope.Select_DetalleContratos[Contratos_Renovaciones.CodConCom] = Contratos_Renovaciones;
            scope.fdatos.ContratoDetalle.push({ CodConCom:Contratos_Renovaciones.CodConCom,CodPro:Contratos_Renovaciones.CodPro,CodCom:Contratos_Renovaciones.CodCom,CodAnePro:Contratos_Renovaciones.CodAnePro,CodProCom:Contratos_Renovaciones.CodProCom,CodCli:Contratos_Renovaciones.CodCli,DurCon:Contratos_Renovaciones.DurCon
            ,FecVenCon:Contratos_Renovaciones.FecVenCon});
           // scope.fdatos.ContratoDetalle.push({ CodConCom: Contratos_Renovaciones.CodConCom });
            //console.log(scope.fdatos.ContratoDetalle);
            scope.CountContratos=scope.fdatos.ContratoDetalle.length;

        });


    }
    scope.RenovarPantalla=function()
    {
        if(scope.fdatos.ContratoDetalle.length==0)
        {
            scope.toast('error','Debe seleccionar al menos un contrato para generar la renovación masiva.','');
            return false;
        }//scope.toast('info','Se procese a la siguente vista.','Información');
        scope.ConfirRenovacion=true;
        scope.fdatos.CambiarProAne=false;
    }

    scope.FilterPaginate=function()
    {
        $scope.predicate = 'id';
        $scope.reverse = true;
        $scope.currentPage = 1;
        $scope.order = function(predicate) {
            $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
            $scope.predicate = predicate1;
        };
        scope.T_Contratos_Renovaciones=scope.T_Contratos_RenovacionesBack;
        $scope.totalItems = scope.T_Contratos_Renovaciones.length;
        $scope.numPerPage = scope.paginate;
        $scope.paginate = function(value) {
            var begin, end, index;
            begin = ($scope.currentPage - 1) * $scope.numPerPage;
            end = begin + $scope.numPerPage;
            index = scope.T_Contratos_Renovaciones.indexOf(value);
            return (begin <= index && index < end);
        };

    }
    scope.GenerarRenovacionContratos=function()
    {        
        if(scope.fdatos.CambiarProAne==true)
        {
            if(!scope.fdatos.NewCodPro>0)
            {
                scope.toast('error','Debe seleccionar el nuevo producto para aplicar la renovación.','Nuevo Producto');
                return false;
            }
            else
            {
                scope.frenovaciones.CodPro=scope.fdatos.NewCodPro;
            }
            if(!scope.fdatos.NewCodAnePro>0)
            {
                scope.toast('error','Debe seleccionar el nuevo anexo para aplicar la renovación.','Nuevo Anexo');
                return false;
            }
            else
            {
                scope.frenovaciones.CodAnePro=scope.fdatos.NewCodAnePro;
            }
        }
        else
        {
            scope.fdatos.NewCodPro=null;
            scope.fdatos.NewCodAnePro=null;
            scope.frenovaciones.CodPro=null;
            scope.frenovaciones.CodAnePro=null;
        }
        scope.frenovaciones.detalle=scope.fdatos.ContratoDetalle;
        scope.frenovaciones.CambiarProAne=scope.fdatos.CambiarProAne;       
        console.log(scope.frenovaciones);
        if(scope.frenovaciones.detalle.length==0)
        {
           scope.toast('error','Debe seleccionar al menos un contrato para realizar la Renovación Masiva','');
           return false; 
        }

        Swal.fire({
            title:'Renovaciones Masivas',
            text:'Estás seguro de generar las renovaciones masivas.',
            type: "question",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: "Continuar"
        }).then(function(t){
        if (t.value == true)
        { 
            scope.toast('error','Esta Función esta en mantenimiento. mientras se evalua como sera el proceso de renovación.','');
            /*$("#Generando").removeClass("loader loader-default").addClass("loader loader-default is-active");
            var url = base_urlHome()+"api/RenovacionMasiva/RenovarMasivamenteContratos/";
            $http.post(url,scope.frenovaciones).then(function(result)
            {
                $("#Generando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                if(result.data!=false)
                {
                    scope.toast('success','Se renovaron los contratos correctamente.','');
                    $scope.submitFormRenovacionesMasivas();
                    scope.Select_DetalleContratos= [];
                    scope.fdatos.ContratoDetalle= [];
                    scope.frenovaciones.detalle= [];
                    scope.ConfirRenovacion=false;
                    scope.CountContratos=scope.fdatos.ContratoDetalle.length;
                    scope.fdatos.NewCodPro=undefined;
                    scope.fdatos.NewCodAnePro=undefined;
                    scope.fdatos.CambiarProAne=false;
                }
                else
                {
                    scope.toast('error','Ha ocurrido un error durante el proceso renovaciones masiva, por favor intente nuevamente.','');
                }
            },function(error)
            {
                $("#Generando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                if (error.status == 404 && error.statusText == "Not Found"){
                scope.toast('error','El método que esté intentando usar no puede ser localizado','Error 404');
                }if (error.status == 401 && error.statusText == "Unauthorized"){
                scope.toast('error','Disculpe, Usuario no autorizado para acceder a ester módulo','Error 401');
                }if (error.status == 403 && error.statusText == "Forbidden"){
                scope.toast('error','Está intentando utilizar un APIKEY inválido','Error 403');
                }if (error.status == 500 && error.statusText == "Internal Server Error") {
                scope.toast('error','Ha ocurrido una falla en el Servidor, intente más tarde','Error 500');
                }

            });*/
        }else 
        {
            scope.toast('info','Cancelando Proceso.','');
            console.log('Cancelando ando...');
        }});

        
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