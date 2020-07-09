function ServiceMenu ($http, $q, $cookies) {  
    return {
        getAll: getAll
    }
    function getAll () {
        var defered = $q.defer();
        var promise = defered.promise;
        var url = base_urlHome()+"api/Menu/usuariomenu/";
        /*ApiKey = $cookies.get('ApiKey');
        $http.defaults.headers.common["x-api-key"] = ApiKey;*/
        $http.get(url)
            .success(function(data) {
                defered.resolve(data);
            })
            .error(function(err) {
                defered.reject(err)
            });

        return promise;
    }
};
function ServiceMaster ($http, $q, $cookies) {  
    return {
        getAll: getAll
    }  
    function getAll () { 
        var defered = $q.defer();
        var promise = defered.promise;
        $("#carganto_servicio").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
        var url = base_urlHome()+"api/Clientes/get_all_functions";
        $http.get(url).success(function(data)
        {
           $("#carganto_servicio").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default");
            defered.resolve(data);
        }).error(function(err) 
        {
            $("#carganto_servicio").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default");
            defered.reject(err)
        });
        return promise;
    }
};
function ServiceComercializadora ($http, $q, $cookies) {  
    return {
        getAll: getAll
    }  
    function getAll () { 
        var defered = $q.defer();
        var promise = defered.promise;
        $("#carganto_servicio").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
        var url = base_urlHome()+"api/Comercializadora/get_service_comercializadora";
        $http.get(url).success(function(data) 
        {
            $("#carganto_servicio").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default");
            defered.resolve(data);
        }).error(function(err) 
        {
            $("#carganto_servicio").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default");
            defered.reject(err)
        });
        return promise;
    }
};
function ServiceProductos ($http, $q, $cookies) {  
    return {
        getAll: getAll
    }  
    function getAll () { 
        var defered = $q.defer();
        var promise = defered.promise;
        $("#carganto_servicio").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
        var url = base_urlHome()+"api/Comercializadora/get_service_productos";
        $http.get(url).success(function(data) 
        {
            $("#carganto_servicio").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default");
            defered.resolve(data);
        }).error(function(err) 
        {
            $("#carganto_servicio").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default");
            defered.reject(err)
        });
        return promise;
    }
};
function ServiceAnexos ($http, $q, $cookies) {  
    return {
        getAll: getAll
    }  
    function getAll () { 
        var defered = $q.defer();
        var promise = defered.promise;
        $("#carganto_servicio").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
        var url = base_urlHome()+"api/Comercializadora/get_service_anexos";
        $http.get(url).success(function(data) 
        {
            $("#carganto_servicio").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default");
            defered.resolve(data);
        }).error(function(err) 
        {
            $("#carganto_servicio").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default");
            defered.reject(err)
        });
        return promise;
    }
};
function ServiceServiciosEspeciales ($http, $q, $cookies) {  
    return {
        getAll: getAll
    }  
    function getAll () { 
        var defered = $q.defer();
        var promise = defered.promise;
        $("#carganto_servicio").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
        var url = base_urlHome()+"api/Comercializadora/get_service_ServiciosEspeciales";
        $http.get(url).success(function(data) 
        {
            $("#carganto_servicio").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default");
            defered.resolve(data);
        }).error(function(err) 
        {
            $("#carganto_servicio").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default");
            defered.reject(err)
        });
        return promise;
    }
};

function ServiceClientes ($http, $q, $cookies) {  
    return {
        getAll: getAll
    }  
    function getAll () { 
        var defered = $q.defer();
        var promise = defered.promise;
        $("#carganto_servicio").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active");
        var url = base_urlHome()+"api/Clientes/get_service_clientes";
        $http.get(url)
            .success(function(data) {
            $("#carganto_servicio").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default");
                defered.resolve(data);
            })
            .error(function(err) {
            $("#carganto_servicio").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default");
                 defered.reject(err)
            });
        return promise;
    }
};
function ServiceAddClientes ($http, $q, $cookies) {  
    return {
        getAll: getAll
    }  
    function getAll () { 
        var defered = $q.defer();
        var promise = defered.promise;
        $("#carganto_servicio").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active");
        var url = base_urlHome()+"api/Clientes/get_service_AddClientes";
        $http.get(url)
            .success(function(data) {
            $("#carganto_servicio").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default");
                defered.resolve(data);
            })
            .error(function(err) {
            $("#carganto_servicio").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default");
                 defered.reject(err)
            });
        return promise;
    }
};

function ServicePuntoSuministro ($http, $q, $cookies) {  
    return {
        getAll: getAll
    }  
    function getAll () { 
        var defered = $q.defer();
        var promise = defered.promise;
        $("#carganto_servicio").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active");
        var url = base_urlHome()+"api/Clientes/get_service_PuntoSuministros";
        $http.get(url)
            .success(function(data) {
            $("#carganto_servicio").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default");
                defered.resolve(data);
            })
            .error(function(err) {
            $("#carganto_servicio").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default");
                 defered.reject(err)
            });
        return promise;
    }
};








function ServiceColaboradores ($http, $q, $cookies) {  
    return {
        getAll: getAll
    }  
    function getAll () { 
        var defered = $q.defer();
        var promise = defered.promise;
        $("#cargando").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active");
        var url = base_urlHome()+"api/Colaboradores/get_all_functions_colaboradores";
        $http.get(url)
            .success(function(data) {
            $("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default");
                defered.resolve(data);
            })
            .error(function(err) {
 $("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default");
                 defered.reject(err)
            });
        return promise;
    }
};

function ServiceOnlyColaboradores ($http, $q, $cookies) {  
    return {
        getAll: getAll
    }  
    function getAll () { 
        var defered = $q.defer();
        var promise = defered.promise;
        var url = base_urlHome()+"api/Colaboradores/get_only_colaboradores";
        $http.get(url)
            .success(function(data) {
                defered.resolve(data);
            })
            .error(function(err) {
                defered.reject(err)
            });
        return promise;
    }
};

function ServiceCups ($http, $q, $cookies) {  
    return {
        getAll: getAll
    }  
    function getAll () { 
        var defered = $q.defer();
        var promise = defered.promise;
        $("#carganto_servicio").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
        var url = base_urlHome()+"api/Cups/get_all_functions";
        $http.get(url).success(function(data)
        {
           $("#carganto_servicio").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default");
            defered.resolve(data);
        }).error(function(err) 
        {
            $("#carganto_servicio").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default");
            defered.reject(err)
        });
        return promise;
    }
};
app.service('ServiceMenu',ServiceMenu);
app.service('ServiceMaster',ServiceMaster);
app.service('ServiceComercializadora',ServiceComercializadora);
app.service('ServiceProductos',ServiceProductos);
app.service('ServiceAnexos',ServiceAnexos);
app.service('ServiceServiciosEspeciales',ServiceServiciosEspeciales);
app.service('ServiceClientes',ServiceClientes);
app.service('ServiceAddClientes',ServiceAddClientes);
app.service('ServicePuntoSuministro',ServicePuntoSuministro);
app.service('ServiceColaboradores',ServiceColaboradores);
app.service('ServiceCups',ServiceCups);
app.service('ServiceOnlyColaboradores',ServiceOnlyColaboradores);
