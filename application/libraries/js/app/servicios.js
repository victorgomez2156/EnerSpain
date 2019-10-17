function ServiceMenu ($http, $q, $cookies) {  
    return {
        getAll: getAll
    }
    function getAll () {
        var defered = $q.defer();
        var promise = defered.promise;
        var url = base_urlHome()+"api/Usuarios/usuariomenu/";
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
function ServiceCodPro ($http, $q, $cookies) {  
    return {
        getAll: getAll
    }
    function getAll () {
        var defered = $q.defer();
        var promise = defered.promise;
        var url = base_urlHome()+"api/Clientes/get_providencias/";
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
function ServiceCodLoc ($http, $q, $cookies) {  
    return {
        getAll: getAll
    }
    function getAll () {
        var defered = $q.defer();
        var promise = defered.promise;
        var url = base_urlHome()+"api/Clientes/get_localidad/";       
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
function ServiceCodTipCli ($http, $q, $cookies) {  
    return {
        getAll: getAll
    }
    function getAll () {
        var defered = $q.defer();
        var promise = defered.promise;
        var url = base_urlHome()+"api/Clientes/get_tipo_cliente/";
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
function ServiceCodCom ($http, $q, $cookies){  
    return {
        getAll: getAll
    }
    function getAll () {
        var defered = $q.defer();
        var promise = defered.promise;
        var url = base_urlHome()+"api/Clientes/get_Comerciales/";
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
function ServiceProvincias ($http, $q, $cookies) {  
    return {
        getAll: getAll
    }
    function getAll () {
        var defered = $q.defer();
        var promise = defered.promise;
        var url = base_urlHome()+"api/Configuraciones_Generales/get_providencias/";
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
function ServiceLocalidades ($http, $q, $cookies) {  
    return {
        getAll: getAll
    }
    function getAll () {
        var defered = $q.defer();
        var promise = defered.promise;
        var url = base_urlHome()+"api/Configuraciones_Generales/get_localidades/";
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
function ServiceTipoViasCom ($http, $q, $cookies){  
    return {
        getAll: getAll
    }
    function getAll () {
        var defered = $q.defer();
        var promise = defered.promise;
        var url = base_urlHome()+"api/Configuraciones_Generales/get_tipos_vias/";
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
function ServiceTipoVias ($http, $q, $cookies){  
    return {
        getAll: getAll
    }
    function getAll () {
        var defered = $q.defer();
        var promise = defered.promise;
        var url = base_urlHome()+"api/Clientes/get_tipos_vias/";
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
function ServiceSectorCliente ($http, $q, $cookies){  
    return {
        getAll: getAll
    }
    function getAll () {
        var defered = $q.defer();
        var promise = defered.promise;
        var url = base_urlHome()+"api/Clientes/get_sector_cliente/";
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
function ServiceColaborador ($http, $q, $cookies){  
    return {
        getAll: getAll
    }
    function getAll () {
        var defered = $q.defer();
        var promise = defered.promise;
        var url = base_urlHome()+"api/Clientes/get_colaboradores/";
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
function ServiceTipoInmueble ($http, $q, $cookies) {  
    return {
        getAll: getAll
    }  
    function getAll () { 
        var defered = $q.defer();
        var promise = defered.promise;
        var url = base_urlHome()+"api/Clientes/get_all_tipo_inmueble";
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
function ServiceBancos ($http, $q, $cookies) {  
    return {
        getAll: getAll
    }  
    function getAll () { 
        var defered = $q.defer();
        var promise = defered.promise;
        var url = base_urlHome()+"api/Clientes/get_all_bancos";
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
app.service('ServiceMenu',ServiceMenu);
app.service('ServiceCodPro',ServiceCodPro);
app.service('ServiceCodLoc',ServiceCodLoc);
app.service('ServiceCodTipCli',ServiceCodTipCli);
app.service('ServiceCodCom',ServiceCodCom);
app.service('ServiceProvincias',ServiceProvincias);
app.service('ServiceLocalidades',ServiceLocalidades);
app.service('ServiceTipoViasCom',ServiceTipoViasCom);
app.service('ServiceTipoVias',ServiceTipoVias);
app.service('ServiceSectorCliente',ServiceSectorCliente);
app.service('ServiceColaborador',ServiceColaborador);
app.service('ServiceTipoInmueble',ServiceTipoInmueble);
app.service('ServiceBancos',ServiceBancos);