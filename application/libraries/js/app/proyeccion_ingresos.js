 app.controller('Controlador_Proyeccion_Ingresos', ['$http', '$scope', '$filter', '$route', '$interval', '$controller', '$cookies', '$compile', Controlador])
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
    scope.excel_proyeccion=false;
    $scope.submitFormProIng = function(event) 
    {
        scope.excel_proyeccion=false;
        scope.nombre_reporte='';
        if (!scope.validar_campos_reportes())
        {
            return false;
        }
        //console.log(event);
        console.log(scope.fdatos);
        $("#Proyeccion_Ingresos").removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url = base_urlHome()+"api/Reportes/Proyeccion_Ingresos/";
        $http.post(url,scope.fdatos).then(function(result)
        {
            $("#Proyeccion_Ingresos").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if(result.data!=false)
            {
                scope.excel_proyeccion=true;
                scope.nombre_reporte=result.data.nombre_reporte;
                console.log(result.data);
            }
            
        },function(error)
        {
            console.log(error);
            $("#Proyeccion_Ingresos").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (error.status == 404 && error.statusText == "Not Found") {
                Swal.fire({ title: "Error.", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 401 && error.statusText == "Unauthorized") {
                Swal.fire({ title: "Error de Privilegios", text: "Usuario no autorizado para acceder a este Módulo", type: "info", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 403 && error.statusText == "Forbidden") {
                Swal.fire({ title: "Seguridad.", text: "Está intentando utilizar un APIKEY incorrecto", type: "question", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 500 && error.statusText == "Internal Server Error") {
                Swal.fire({ title: "Error.", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
            }
        });
    }
    scope.validar_campos_reportes=function()
    {
        resultado = true;
        if (!scope.fdatos.ano > 0) {
            Swal.fire({ title: "Debe seleccionar un año.", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }        
        if (resultado == false)
        {
            return false;
        }
        return true;
     

    }    
}
