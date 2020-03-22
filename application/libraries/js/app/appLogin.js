var app = angular.module('appLogin', ['checklist-model', 'ngResource', 'ngCookies', 'ui.bootstrap', 'angular.ping', 'ngRoute', 'pascalprecht.translate'])
    .config(function($httpProvider, $routeProvider, $translateProvider) {

        $httpProvider.defaults.useXDomain = true;
        $httpProvider.defaults.headers.common["Access-Control-Allow-Origin"] = "*";
        $httpProvider.defaults.headers.common["Access-Control-Allow-Methods"] = "GET, POST, PUT, DELETE, OPTIONS";
        $httpProvider.defaults.headers.common["Access-Control-Max-Age"] = "86400";
        $httpProvider.defaults.headers.common["Access-Control-Allow-Credentials"] = "true";
        $httpProvider.defaults.headers.common["Accept"] = "application/javascript";
        $httpProvider.defaults.headers.common["content-type"] = "application/json";
        //$httpProvider.defaults.headers.common["Authorization"] = "Token token=xxxxYYYYZzzz";
        //$httpProvider.defaults.withCredentials = true;
        //delete $httpProvider.defaults.headers.common["X-Requested-With"];
        delete $httpProvider.defaults.headers.common['X-Requested-With'];
        $routeProvider
        //Se debe colocar  para cada uno de los controladores que desea para el acceso todos los formularios

        $translateProvider.translations('sp', {
            'REMEMBER': 'Recordar Datos',
            'RECOVERY': 'Recuperar Contraseña?',
            'USERNAME': 'Usuario o Correo Eléctronico',
            'PASSWORD': 'Clave o Contraseña',
            'DESIGNED': 'Diseñado por',
            'LOGIN': 'Iniciar Sesión',
            'SESSION': "Iniciando Sesión, por favor espere ...",
            'TITLE': 'Aplicación para la Gestión de Servicios Energéticos'


        });

        $translateProvider.translations('en', {
            'REMEMBER': 'Remember-me',
            'RECOVERY': 'Forgot Password?',
            'USERNAME': 'Username or Email',
            'PASSWORD': 'Password',
            'DESIGNED': 'Designed By',
            'LOGIN': 'Log in',
            'SESSION': "We Are Logging In, Please Wait...",
            'TITLE': "Application for the Management of Energy Services."

        });
        $translateProvider.preferredLanguage('en');


    }).run(function run($http, $cookies, netTesting, $translate) {
        if ($cookies.get('idioma') == undefined) {
            $cookies.put('idioma', 'en');
        } else {
            $translate.uses($cookies.get('idioma'));
        }

    });