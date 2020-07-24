 app.controller('Controlador_Ingresos_Vs_Proyectados', ['$http', '$scope', '$filter', '$route', '$interval', '$controller', '$cookies', '$compile', Controlador])
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
     })
 function Controlador($http, $scope, $filter, $route, $interval, $controller, $cookies, $compile) {
    var scope = this;
    scope.fdatos = {};
     
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
    scope.index = 0;
    
    scope.excel_reales_vs_proyectado=false;
    scope.nombre_reporte='';
    
    $scope.submitFormProyectadosVsReales = function(event) 
    {
        scope.excel_reales_vs_proyectado=false;
        scope.nombre_reporte='';
        if (!scope.validar_campos_reportes())
        {
            return false;
        }
        //console.log(event);
        console.log(scope.fdatos);
        $("#Ingresos_Vs_Proyectados").removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url = base_urlHome()+"api/Reportes/Proyectado_Vs_Reales/";
        $http.post(url,scope.fdatos).then(function(result)
        {
            $("#Ingresos_Vs_Proyectados").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if(result.data!=false)
            {
                scope.excel_reales_vs_proyectado=true;
                scope.nombre_reporte=result.data.nombre_reporte;
                console.log(result.data);
            }            
        },function(error)
        {
            $("#Ingresos_Vs_Proyectados").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
    scope.validar_campos_reportes=function()
    {
        resultado = true;
        if (!scope.fdatos.ano > 0) {
            scope.toast('error','Debe seleccionar un año.','');
            return false;
        }        
        if (resultado == false)
        {
            return false;
        }
        return true;
     

    }             

 }