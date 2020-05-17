app.controller('Controlador_Contratos', ['$http', '$scope', '$filter', '$route', '$interval', '$controller', '$cookies', '$compile','upload',Controlador])
.directive('updloadfotocopiaModel', ["$parse", function($parse) {
        return {
            restrict: 'A',
            link: function(scope, iElement, iAttrs) {
                iElement.on("change", function(e) {
                    $parse(iAttrs.updloadfotocopiaModel).assign(scope, iElement[0].files[0]);
                    //console.log($parse(iAttrs.updloadfotocopiaModel).assign(scope, iElement[0].files[0]));
                });
            }
        };
    }])
    .service('upload', ["$http", "$q", function($http, $q) {
        this.uploadFile = function(file, name) {
            var deferred = $q.defer();
            var formData = new FormData();
            //formData.append("name", name);
            formData.append("file", file);
            return $http.post("server.php", formData, {
                    headers: {
                        "Content-type": undefined
                    },
                    transformRequest: angular.identity
                })
                .success(function(res) {
                    deferred.resolve(res);
                })
                .error(function(msg, code) {
                    deferred.reject(msg);
                })
            return deferred.promise;
        }
    }])     
function Controlador($http, $scope, $filter, $route, $interval, $controller, $cookies, $compile,upload) {
     var scope = this;
     scope.fdatos = {};
     scope.T_Contratos=[];
     scope.T_ContratosBack=[];
     scope.tmodal_filtros={};
     scope.CodConCom = $route.current.params.CodConCom;
     scope.CodCli = $route.current.params.CodCli;
     scope.CodProCom = $route.current.params.CodProCom;
     scope.fdatos.tipo = $route.current.params.Tipo;
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
////////////////////////////////////////////////// PARA LOS CONTRATOS START /////////////////////////////////////////////////////////////
    //console.log($route.current.$$route.originalPath);
    //console.log(scope.CodConCom);
    //console.log(scope.CodCli);
    //console.log(scope.fdatos.tipo);
    const $archivofotocopia = document.querySelector("#file_fotocopia");
   
     scope.get_list_contratos=function()
    {
        $("#Contratos").removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url = base_urlHome() +"api/Contratos/get_list_contratos_clientes";
        $http.get(url).then(function(result)
        {   
            $("#Contratos").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if(result.data!=false)
            {
               $scope.predicate = 'id';
                $scope.reverse = true;
                $scope.currentPage = 1;
                $scope.order = function(predicate){
                    $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                    $scope.predicate = predicate;
                };
                scope.T_Contratos = result.data;
                scope.T_ContratosBack= result.data;
                $scope.totalItems = scope.T_Contratos.length;
                $scope.numPerPage = 50;
                $scope.paginate = function(value){
                    var begin, end, index;
                    begin = ($scope.currentPage - 1) * $scope.numPerPage;
                    end = begin + $scope.numPerPage;
                    index = scope.T_Contratos.indexOf(value);
                    return (begin <= index && index < end);
                }  
            }
            else
            {   
                Swal.fire({ title: "Error", text: "no se encontraron contratos registrados.", type: "error", confirmButtonColor: "#188ae2" });
                scope.T_Contratos=[];
                scope.T_ContratosBack=[];
            }
        },function(error)
        {
            $("#Contratos").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (error.status == 404 && error.statusText == "Not Found") {
                Swal.fire({ title: "Error 404", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 401 && error.statusText == "Unauthorized") {
                Swal.fire({ title: "Error 401", text: "Usuario no autorizado para acceder a este Módulo", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 403 && error.statusText == "Forbidden") {
                Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY inválido", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 500 && error.statusText == "Internal Server Error") {
                Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
            }

        });    
    }
    scope.fetchClientes = function(metodo)
    {
        if(metodo==1)
        {
            var searchText_len = scope.NumCifCli.trim().length;
            scope.fdatos.NumCifCli=scope.NumCifCli;   
            if(searchText_len > 0)
            {
                    var url = base_urlHome()+"api/Contratos/getclientes";
                $http.post(url,scope.fdatos).then(function(result)
                {
                    console.log(result);
                    if (result.data != false)
                    {
                        scope.searchResult = result.data;
                        console.log(scope.searchResult);
                    }
                    else
                    {
                        Swal.fire({ title: "Error", text: "No existen Clientes registrados", type: "error", confirmButtonColor: "#188ae2" });                    
                        scope.searchResult = {};
                    }
                }, function(error)
                {
                    if (error.status == 404 && error.statusText == "Not Found")
                    {
                        Swal.fire({ title: "Error 404", text: "El método que esté intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 401 && error.statusText == "Unauthorized")
                    {
                        Swal.fire({ title: "Error 401", text: "Disculpe, Usuario no autorizado para acceder a ester módulo", type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 403 && error.statusText == "Forbidden")
                    {
                        Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY inválido", type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 500 && error.statusText == "Internal Server Error") {
                        Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
                    }
                });
            }
            else
            {
                scope.searchResult = {};
            }            
        }
        if(metodo==2)
        {
            var searchText_len = scope.NumCifCliFil.trim().length;
            scope.fdatos.NumCifCli=scope.NumCifCliFil;   
            if(searchText_len > 0)
            {
                    var url = base_urlHome()+"api/Contratos/getclientes";
                $http.post(url,scope.fdatos).then(function(result)
                {
                    console.log(result);
                    if (result.data != false)
                    {
                        scope.searchResult = result.data;
                        console.log(scope.searchResult);
                    }
                    else
                    {
                        Swal.fire({ title: "Error", text: "No existen Clientes registrados", type: "error", confirmButtonColor: "#188ae2" });                    
                        scope.searchResult = {};
                    }
                }, function(error)
                {
                    if (error.status == 404 && error.statusText == "Not Found")
                    {
                        Swal.fire({ title: "Error 404", text: "El método que esté intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 401 && error.statusText == "Unauthorized")
                    {
                        Swal.fire({ title: "Error 401", text: "Disculpe, Usuario no autorizado para acceder a ester módulo", type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 403 && error.statusText == "Forbidden")
                    {
                        Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY inválido", type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 500 && error.statusText == "Internal Server Error") {
                        Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
                    }
                });
            }
            else
            {
                scope.searchResult = {};
            }            
        }
             
    }
    
    scope.setValue = function(index,$event,result,metodo)
   {
        if(metodo==1)
        {
            scope.NumCifCli=scope.searchResult[index].NumCifCli;
            scope.searchResult = {};
            $event.stopPropagation();  
        } 
        if(metodo==2)
        {
            scope.NumCifCliFil=scope.searchResult[index].NumCifCli+" - "+scope.searchResult[index].RazSocCli;
            scope.CodCliFil=scope.searchResult[index].CodCli;
            scope.searchResult = {};
            $event.stopPropagation();  
        }       
        
   }
    scope.searchboxClicked = function($event){
      $event.stopPropagation();
    }
    scope.containerClicked = function()
    {
      scope.searchResult = {};
    }
     $scope.Consultar_CIF=function(event)
    {
        if(scope.NumCifCli==undefined || scope.NumCifCli==null || scope.NumCifCli=='')
        {
            Swal.fire({ title: 'Número de CIF', text: 'El número de cif del cliente es requerido.', type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }
        $("#NumCifCli").removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url = base_urlHome() +"api/Contratos/get_valida_datos_clientes/NumCifCli/"+scope.NumCifCli;
        $http.get(url).then(function(result)
        {   
            console.log(result);
            $("#NumCifCli").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if(result.data!=false)
            {
                if(result.data.status==false && result.data.statusText=="Error")
                {
                   Swal.fire({ title:result.data.statusText, text: result.data.menssage, type: "error", confirmButtonColor: "#188ae2" }); 
                   return false;
                }
                if(result.data.status==true && result.data.statusText=='Contrato')
                {
                  $('#modal_add_contratos').modal('hide');
                  location.href="#/Add_Contrato/"+result.data.Cliente.CodCli+"/nuevo";
                }
                if(result.data.status==true && result.data.statusText=='Propuesta_Nueva')
                {
                    $("#modal_add_contratos").modal('hide');
                    //location.href="#/Add_Propuesta_Comercial/"+result.data.CodCli+"/nueva";
                }
            }
            else
            {
                Swal.fire({ title: "Error", text: "El número del CIF no se encuentra asignando a ningun cliente.", type: "error", confirmButtonColor: "#188ae2" });                
            }
        },function(error)
        {
            $("#NumCifCli").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (error.status == 404 && error.statusText == "Not Found") {
                Swal.fire({ title: "Error 404", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 401 && error.statusText == "Unauthorized") {
                Swal.fire({ title: "Error 401", text: "Usuario no autorizado para acceder a este Módulo", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 403 && error.statusText == "Forbidden") {
                Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY inválido", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 500 && error.statusText == "Internal Server Error") {
                Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
            }

        });       
    }
    scope.BuscarXIDPropuestaContrato=function()
    {
        $("#NumCifCli").removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url = base_urlHome()+"api/Contratos/BuscarXIDPropuestaContrato/CodCli/"+scope.CodCli;
        $http.get(url).then(function(result)
        {
            console.log(result);
            $("#NumCifCli").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if(result.data!=false)
            {                
                if(result.data.status==false && result.data.statusText=="Error")
                {
                    Swal.fire({ title:"Error", text: result.data.menssage, type: "error", confirmButtonColor: "#188ae2" });
                    location.href="#/Contratos/";
                    return false;
                }
                scope.fdatos.CodCli=result.data.Cliente.CodCli;
                scope.RazSocCli=result.data.Cliente.RazSocCli;
                scope.NumCifCli=result.data.Cliente.NumCifCli;
                scope.List_Propuestas_Comerciales=result.data.List_Propuesta;
                scope.fdatos.RefCon=result.data.RefCon;
                $('.datepicker_Inicio').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", result.data.FechaServer);
            }
            else
            {
                Swal.fire({ title: "Error", text: "Este Número de CIF no se encuentra registrado.", type: "error", confirmButtonColor: "#188ae2" });
            }

        },function(error)
        {
            $("#NumCifCli").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (error.status == 404 && error.statusText == "Not Found") {
                Swal.fire({ title: "Error 404", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 401 && error.statusText == "Unauthorized") {
                Swal.fire({ title: "Error 401", text: "Usuario no autorizado para acceder a este Módulo", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 403 && error.statusText == "Forbidden") {
                Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY inválido", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 500 && error.statusText == "Internal Server Error") {
                Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
            }
        });

    }
    scope.calcular_vencimiento=function()
    {
        scope.parafechas={};
        var FecIniCon = document.getElementById("FecIniCon").value;
        scope.parafechas.FechaCalcular=FecIniCon;
        scope.parafechas.DurCon=scope.fdatos.DurCon;
        console.log(scope.fdatos);
        var url = base_urlHome()+"api/Contratos/calcular_vencimiento/";
        $http.post(url,scope.parafechas).then(function(result)
        {
            if(result.data.status==false && result.data.statusText=="Fecha")
            {
               Swal.fire({ title: result.data.statusText, text: result.data.menssage, type: "error", confirmButtonColor: "#188ae2" });
               scope.FecVenCon=undefined;
               scope.fdatos.DurCon=undefined;
               $('.datepicker_Inicio').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", result.data.FechaServer);
               return false; 
            }

            console.log(result);
            scope.FecVenCon=result.data.FecVenc;

        },function(error)
        {  
            if (error.status == 404 && error.statusText == "Not Found") {
                Swal.fire({ title: "Error 404", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 401 && error.statusText == "Unauthorized") {
                Swal.fire({ title: "Error 401", text: "Usuario no autorizado para acceder a este Módulo", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 403 && error.statusText == "Forbidden") {
                Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY inválido", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 500 && error.statusText == "Internal Server Error") {
                Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
            }

        });
    }
    scope.validar_formatos_input = function(metodo, object){
        console.log(object);
        console.log(metodo);        
        if (metodo == 1) 
        {
            if (object != undefined)
            {
                 numero = object;
                 if (!/^([/0-9])*$/.test(numero))
                     scope.FecIniCon = numero.substring(0, numero.length - 1);
            }
        } 
        if (metodo == 2) 
        {
            if (object != undefined)
            {
                 numero = object;
                 if (!/^([/0-9])*$/.test(numero))
                     scope.FecBajCon = numero.substring(0, numero.length - 1);
            }
        } 
        if (metodo == 3) 
        {
            if (object != undefined)
            {
                 numero = object;
                 if (!/^([/0-9])*$/.test(numero))
                     scope.RangFec = numero.substring(0, numero.length - 1);
            }
        }       
    }
    scope.blurfechachange=function()
    {
        if(scope.fdatos.DurCon!=undefined)
        {
            $('#FecIniCon').on('changeDate', function() 
            {
                scope.calcular_vencimiento();
            });
        }

    }
    scope.filtrar_propuesta_contratos=function()
    {
        for (var i = 0; i < scope.List_Propuestas_Comerciales.length; i++) 
        {
            if(scope.List_Propuestas_Comerciales[i].CodProCom==scope.fdatos.CodProCom)
            {
                console.log(scope.List_Propuestas_Comerciales[i]);
                scope.FecProCom=scope.List_Propuestas_Comerciales[i].FecProCom;
                scope.RefProCom=scope.List_Propuestas_Comerciales[i].RefProCom;
                scope.DirPunSum=scope.List_Propuestas_Comerciales[i].DirPunSum+" "+scope.List_Propuestas_Comerciales[i].BloPunSum;
                scope.EscPlaPuerPunSum=scope.List_Propuestas_Comerciales[i].EscPunSum+" "+scope.List_Propuestas_Comerciales[i].PlaPunSum+" "+scope.List_Propuestas_Comerciales[i].PuePunSum;
                scope.DesLocPunSum=scope.List_Propuestas_Comerciales[i].DesLoc;
                scope.DesLocPunSum=scope.List_Propuestas_Comerciales[i].DesLoc;                
                scope.DesProPunSum=scope.List_Propuestas_Comerciales[i].DesPro;
                scope.CodCupSEle=scope.List_Propuestas_Comerciales[i].CUPsEle;                
                scope.CodTarEle=scope.List_Propuestas_Comerciales[i].NomTarEle;
                scope.PotConP1=scope.List_Propuestas_Comerciales[i].PotConP1;
                scope.PotConP2=scope.List_Propuestas_Comerciales[i].PotConP2;
                scope.PotConP3=scope.List_Propuestas_Comerciales[i].PotConP3;
                scope.PotConP4=scope.List_Propuestas_Comerciales[i].PotConP4;
                scope.PotConP5=scope.List_Propuestas_Comerciales[i].PotConP5;
                scope.PotConP6=scope.List_Propuestas_Comerciales[i].PotConP6;
                scope.CodCupGas=scope.List_Propuestas_Comerciales[i].CupsGas;                
                scope.CodTarGas=scope.List_Propuestas_Comerciales[i].NomTarGas;
                scope.Consumo=scope.List_Propuestas_Comerciales[i].Consumo;
                scope.CauDia=scope.List_Propuestas_Comerciales[i].CauDia;
                scope.CodCom=scope.List_Propuestas_Comerciales[i].NomCom;
                scope.CodPro=scope.List_Propuestas_Comerciales[i].DesProducto;
                scope.CodAnePro=scope.List_Propuestas_Comerciales[i].DesAnePro;
                scope.TipPre=scope.List_Propuestas_Comerciales[i].TipPre;
            }
        }
    }
    scope.regresar=function()
    {
       Swal.fire({
            title:"Estás seguro de regresar y no realizar los cambios?",
            type: "question",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: "OK"
        }).then(function(t){
        if (t.value == true)
        {
             location.href="#/Contratos"; 
        }else 
        {
            console.log('Cancelando ando...');
        }});    
    }
    $scope.updloadfotocopia = function() 
    {
        var file = $scope.file_fotocopia;
        upload.uploadFile(file, name).then(function(res) 
        {
            //console.log(res);
        }, function(error) {
            if (error.status == 404 && error.statusText == "Not Found") {
                Swal.fire({ title: "Error General", text: "El método que esté intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 401 && error.statusText == "Unauthorized") {
                Swal.fire({ title: "Error de Privilegios", text: "Usuario no autorizado para acceder a este Módulo", type: "info", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 403 && error.statusText == "Forbidden") {
                Swal.fire({ title: "Error de Seguridad", text: "Está intentando utilizar un APIKEY inválido", type: "question", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 500 && error.statusText == "Internal Server Error") {
                Swal.fire({ title: "Error de Servidor", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
            }
        });
    }
     $scope.submitFormContratos = function(event)
     {
        if (scope.fdatos.tipo == 'nuevo'){
            var titulo = 'Guardando';
            var texto = '¿Seguro de grabar el contrato?';
            var response = 'Contrato registrado de forma correcta';
        }
        if (scope.fdatos.tipo == 'ver' || scope.fdatos.tipo == 'editar'){
            var titulo = 'Actualizando';
            var texto = '¿Seguro de actualizar el contrato?';
            var response = 'Contrato actualizado de forma correcta';
        }

        if (!scope.validar_campos_contratos()) {
            return false;
        }
        let archivos_fotocopia = $archivofotocopia.files;
        if ($archivofotocopia.files.length > 0)
        {
            if ($archivofotocopia.files[0].type == "application/pdf") {
                console.log('Fichero correcto');
                var tipo_file = ($archivofotocopia.files[0].type).split("/");
                $archivofotocopia.files[0].type;          
                $scope.updloadfotocopia();
                scope.fdatos.DocConRut = 'documentos/' + $archivofotocopia.files[0].name;
            } else {
                Swal.fire({ title: 'Error', text: 'Error en fichero, el formato debe ser PDF', type: "error", confirmButtonColor: "#188ae2" });
                scope.fdatos.DocConRut = null;
                document.getElementById('file_fotocopia').value = '';
                return false;
            }
        } else
        {
            
            if(scope.fdatos.DocConRut!=null)
            {
                scope.fdatos.DocConRut=scope.fdatos.DocConRut;
            }
            else
            {
                scope.fdatos.DocConRut = null;
            }
            
        }
        console.log(scope.fdatos);        
        Swal.fire({
            title: titulo,
            text: texto,
            type: "question",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: "OK!"
        }).then(function(t) {
            if (t.value == true) {
                $("#" + titulo).removeClass("loader loader-default").addClass("loader loader-default is-active");
                var url = base_urlHome() + "api/Contratos/registrar_contratos/";
                $http.post(url, scope.fdatos).then(function(result) {
                    $("#" + titulo).removeClass("loader loader-default is-active").addClass("loader loader-default");
                    //scope.nIDfdatos = result.data.CodAnePro;
                    if (result.data != false) 
                    {                       

                        if(result.data.status==200 && result.data.statusText=='OK')
                        {
                            Swal.fire({ title: titulo, text: result.data.menssage, type: "success", confirmButtonColor: "#188ae2" });
                            document.getElementById('file_fotocopia').value = '';
                            $('#file_fotocopia1').html('');
                            location.href="#/Contratos";
                        }//location.href = "#/Edit_fdatos/" + scope.nIDfdatos;
                    } else {
                        Swal.fire({ title: "Error", text: "No se ha completado la operación, intente nuevamente", type: "error", confirmButtonColor: "#188ae2" });
                    }
                }, function(error) {
                    $("#" + titulo).removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (error.status == 404 && error.statusText == "Not Found") {
                        Swal.fire({ title: "Error General", text: "El método que esté intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 401 && error.statusText == "Unauthorized") {
                        Swal.fire({ title: "Error de Privilegios", text: "Usuario no autorizado para acceder a este Módulo", type: "info", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 403 && error.statusText == "Forbidden") {
                        Swal.fire({ title: "Error de Seguridad", text: "Está intentando utilizar un APIKEY inválido", type: "question", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 500 && error.statusText == "Internal Server Error") {
                        Swal.fire({ title: "Error de Servidor", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
                    }
                });
            } else {
                event.preventDefault();
            }
        });
    };
    scope.validar_campos_contratos = function() 
    {
         resultado = true;
         if (!scope.fdatos.CodProCom > 0) {
             Swal.fire({ title: "Debe seleccionar una Propuesta Comercial.", type: "error", confirmButtonColor: "#188ae2" });
             return false;
         }
         var FecIniCon1 = document.getElementById("FecIniCon").value;
         scope.FecIniCon = FecIniCon1;
         if (scope.FecIniCon == null || scope.FecIniCon == undefined || scope.FecIniCon == ''){
            Swal.fire({ title: "La Fecha de Inicio es requerida", type: "error", confirmButtonColor: "#188ae2" });
            return false;
         }else{
            var FecIniCon = (scope.FecIniCon).split("/");
            if (FecIniCon.length < 3) {
                 Swal.fire({ title: "El formato Fecha de Inicio correcto es DD/MM/YYYY", type: "error", confirmButtonColor: "#188ae2" });
                 event.preventDefault();
                 return false;
            }else{
                if (FecIniCon[0].length > 2 || FecIniCon[0].length < 2) {
                    Swal.fire({ title: "Error en Día, debe introducir dos números", type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;
                }
                if (FecIniCon[1].length > 2 || FecIniCon[1].length < 2) {
                     Swal.fire({ title: "Error en Mes, debe introducir dos números", type: "error", confirmButtonColor: "#188ae2" });
                     event.preventDefault();
                     return false;
                 }
                 if (FecIniCon[2].length < 4 || FecIniCon[2].length > 4) {
                     Swal.fire({ title: "Error en Año, debe introducir cuatro números", type: "error", confirmButtonColor: "#188ae2" });
                     event.preventDefault();
                     return false;
                 }
                 valuesStart = scope.FecIniCon.split("/");                
                 scope.fdatos.FecIniCon = FecIniCon[2] + "-" + FecIniCon[1] + "-" + FecIniCon[0];
            }
         }
         if (!scope.fdatos.DurCon > 0) {
             Swal.fire({ title: "La Duración del Contrato es requerida", type: "error", confirmButtonColor: "#188ae2" });
             return false;
         }
         var FecVenCon1 = document.getElementById("FecVenCon").value;
         scope.FecVenCon = FecVenCon1;
         if (scope.FecVenCon == null || scope.FecVenCon == undefined || scope.FecVenCon == ''){
            Swal.fire({ title: "La Fecha de Vencimiento es requerida", type: "error", confirmButtonColor: "#188ae2" });
            return false;
         }else{
            var FecVenCon = (scope.FecVenCon).split("/");
            if (FecVenCon.length < 3) {
                 Swal.fire({ title: "El formato Fecha de Vencimiento correcto es DD/MM/YYYY", type: "error", confirmButtonColor: "#188ae2" });
                 event.preventDefault();
                 return false;
            }else{
                if (FecVenCon[0].length > 2 || FecVenCon[0].length < 2) {
                    Swal.fire({ title: "Error en Día, debe introducir dos números", type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;
                }
                if (FecVenCon[1].length > 2 || FecVenCon[1].length < 2) {
                     Swal.fire({ title: "Error en Mes, debe introducir dos números", type: "error", confirmButtonColor: "#188ae2" });
                     event.preventDefault();
                     return false;
                 }
                 if (FecVenCon[2].length < 4 || FecVenCon[2].length > 4) {
                     Swal.fire({ title: "Error en Año, debe introducir cuatro números", type: "error", confirmButtonColor: "#188ae2" });
                     event.preventDefault();
                     return false;
                 }
                 valuesStart = scope.FecVenCon.split("/");                
                 scope.fdatos.FecVenCon = FecVenCon[2] + "-" + FecVenCon[1] + "-" + FecVenCon[0];
            }
         }
         if (scope.fdatos.ObsCon == null || scope.fdatos.ObsCon == undefined || scope.fdatos.ObsCon == '') {
             scope.fdatos.ObsCon=null;
         }
         else{
           scope.fdatos.ObsCon=scope.fdatos.ObsCon; 
       }
        if (resultado == false)
        {
            //quiere decir que al menos un renglon no paso la validacion
            return false;
        }
        return true;
     }
     scope.validar_opcion_contratos=function(index,opcion_select,dato)
     {
        //console.log('index: '+index);
        //console.log('opcion: '+opcion_select);
        //console.log(dato);
        scope.opcion_select[index]=undefined;
        if(opcion_select==1)
        {
            location.href="#/Ver_Contrato/"+dato.CodCli+"/"+dato.CodConCom+"/"+dato.CodProCom+"/ver";
        }
        if(opcion_select==2)
        {
            location.href="#/Edit_Contrato/"+dato.CodCli+"/"+dato.CodConCom+"/"+dato.CodProCom+"/editar";
        }
        if(opcion_select==3)
        {           
            if(dato.EstBajCon==3)
            {
                Swal.fire({ title: "Error", text: "El Contrato ya fue renovado.", type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }
            scope.tmodal_data={};
            scope.tmodal_data.CodCli=dato.CodCli;
            scope.tmodal_data.CodProCom=dato.CodProCom;
            scope.tmodal_data.CodConCom=dato.CodConCom;
            scope.tmodal_data.FecConCom=dato.FecConCom;
            scope.tmodal_data.FecVenCon=dato.FecVenCon;
            scope.tmodal_data.FecIniCon=dato.FecIniCon;
            scope.tmodal_data.SinMod=false;
            scope.tmodal_data.ConMod=false;
            scope.RazSocCli=dato.RazSocCli;
            scope.CodCom=dato.CodCom;
            scope.Anexo=dato.Anexo;
            if(dato.EstBajCon==0)
            {
                var url=base_urlHome()+"api/Contratos/verificar_renovacion";
                $http.post(url,scope.tmodal_data).then(function(result)
                {
                    if(result.data!=false)
                    {
                        console.log(result.data);
                        if(result.data.status==203 && result.data.statusText=="Error")
                        {
                            Swal.fire({ title: result.data.statusText, text: result.data.menssage, type: "error", confirmButtonColor: "#188ae2" });
                            scope.tmodal_data={};
                            $("#Tipo_Renovacion").modal('hide');
                            return false;
                        }
                        if(result.data.status==200 && result.data.statusText=="OK")
                        {
                            Swal.fire({ title: result.data.menssage,type: "success", confirmButtonColor: "#188ae2" });
                            $("#Tipo_Renovacion").modal('show');
                           
                            return false;
                        }

                    }
                    else
                    {
                        Swal.fire({ title: "Error General", text: "Error en el proceso intente nuevamente", type: "error", confirmButtonColor: "#188ae2" });
                    }

                },function(error)
                {   
                    if (error.status == 404 && error.statusText == "Not Found") {
                        Swal.fire({ title: "Error General", text: "El método que esté intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 401 && error.statusText == "Unauthorized") {
                        Swal.fire({ title: "Error de Privilegios", text: "Usuario no autorizado para acceder a este Módulo", type: "info", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 403 && error.statusText == "Forbidden") {
                        Swal.fire({ title: "Error de Seguridad", text: "Está intentando utilizar un APIKEY inválido", type: "question", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 500 && error.statusText == "Internal Server Error") {
                        Swal.fire({ title: "Error de Servidor", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
                    }

                });
            }
            else
            {
                $("#Tipo_Renovacion").modal('show');
            }
           
        }

        if(opcion_select==4)
        {
            scope.tmodal_data={};
            if(dato.EstBajCon==1)
            {
                Swal.fire({ title: "Error", text: "Este contrato ya fue dado de baja.", type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }           
            scope.RazSocCom=dato.NumCifCli+" "+dato.CodCom;
            scope.FecBajCon=fecha;
            $('.FecBajCon').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.FecBajCon);
            scope.tmodal_data.CodConCom=dato.CodConCom;
            $("#modal_baja_contrato").modal('show');
        }

    }
      $scope.SubmitFormRenovacion = function(event)
    {   
        /**/
        if (!scope.validar_campos_renovacion()) {
            return false;
        }
        
       console.log(scope.tmodal_data);
        Swal.fire({
            text: '¿Seguro de Renovar el contrato?',
            type: "question",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: 'Renovar'
        }).then(function(t){
            if (t.value == true)
            {
               $("#Renovando").removeClass("loader loader-default").addClass("loader loader-default is-active");
                console.log(scope.tmodal_data);
                var url = base_urlHome()+"api/Contratos/RenovarContrato/";
                $http.post(url,scope.tmodal_data).then(function(result)
                {
                    $("#Renovando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if(result.data.status==203 && result.data.statusText=='Error')
                    {
                       Swal.fire({ title: result.data.statusText, text: result.data.menssage, type: "error", confirmButtonColor: "#188ae2" });     
                       return false;
                    }
                    if(result.data.status==200 && result.data.statusText=='OK')
                    {
                       Swal.fire({ title: 'Renovación', text: result.data.menssage, type: "success", confirmButtonColor: "#188ae2" });     
                       scope.tmodal_data={};
                       $("#Tipo_Renovacion").modal('hide');
                       scope.get_list_contratos();
                       return false;
                    }



                    if(result.data!=false)
                    {
                        //Swal.fire({ title: "Contrato", text: "Contrato dado de baja sastifactoriamente.", type: "error", confirmButtonColor: "#188ae2" });
                        //$("#modal_baja_contrato").modal('hide');
                        

                        scope.get_list_contratos();
                    }
                    else
                    {
                        Swal.fire({ title: "Error General", text: "Error durante el proceso, intente nuevamente.", type: "error", confirmButtonColor: "#188ae2" });
                    }

                },function(error)
                {
                    $("#Renovando").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (error.status == 404 && error.statusText == "Not Found") {
                        Swal.fire({ title: "Error General", text: "El método que esté intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 401 && error.statusText == "Unauthorized") {
                        Swal.fire({ title: "Error de Privilegios", text: "Usuario no autorizado para acceder a este Módulo", type: "info", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 403 && error.statusText == "Forbidden") {
                        Swal.fire({ title: "Error de Seguridad", text: "Está intentando utilizar un APIKEY inválido", type: "question", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 500 && error.statusText == "Internal Server Error") {
                        Swal.fire({ title: "Error de Servidor", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
                    }

                });
                
            } else {
                event.preventDefault();
                console.log('Cancelando ando...');
            }
        });
    };
    scope.validar_campos_renovacion = function() 
    {
         resultado = true;
        



        if(scope.tmodal_data.SinMod==false && scope.tmodal_data.ConMod==false)
        {
            Swal.fire({ title: "Error", text: "Debe indicar que tipo de renovación es el contrato.", type: "error", confirmButtonColor: "#188ae2" });
            return false;
        }

         if(scope.tmodal_data.SinMod==true)
         {
             var FecIniCon1 = document.getElementById("FecIniCon").value;
             scope.FecIniCon = FecIniCon1;
             if (scope.FecIniCon == null || scope.FecIniCon == undefined || scope.FecIniCon == ''){
                Swal.fire({ title: "La Fecha de Inicio es requerida", type: "error", confirmButtonColor: "#188ae2" });
                return false;
             }else{
                var FecIniCon = (scope.FecIniCon).split("/");
                if (FecIniCon.length < 3) {
                     Swal.fire({ title: "El formato Fecha de Inicio correcto es DD/MM/YYYY", type: "error", confirmButtonColor: "#188ae2" });
                     event.preventDefault();
                     return false;
                }else{
                    if (FecIniCon[0].length > 2 || FecIniCon[0].length < 2) {
                        Swal.fire({ title: "Error en Día, debe introducir dos números", type: "error", confirmButtonColor: "#188ae2" });
                        event.preventDefault();
                        return false;
                    }
                    if (FecIniCon[1].length > 2 || FecIniCon[1].length < 2) {
                         Swal.fire({ title: "Error en Mes, debe introducir dos números", type: "error", confirmButtonColor: "#188ae2" });
                         event.preventDefault();
                         return false;
                     }
                     if (FecIniCon[2].length < 4 || FecIniCon[2].length > 4) {
                         Swal.fire({ title: "Error en Año, debe introducir dos números", type: "error", confirmButtonColor: "#188ae2" });
                         event.preventDefault();
                         return false;
                     }
                     valuesStart = scope.FecIniCon.split("/");                
                     scope.tmodal_data.FecIniCon = FecIniCon[2] + "-" + FecIniCon[1] + "-" + FecIniCon[0];
                }
             }
             if (!scope.tmodal_data.DurCon > 0) {
                 Swal.fire({ title: "La Duración del Contrato es requerida", type: "error", confirmButtonColor: "#188ae2" });
                 return false;
            }
         }
            
        
        if (resultado == false)
        {
            //quiere decir que al menos un renglon no paso la validacion
            return false;
        }
        return true;
     }
    scope.BuscarXIDContrato=function()
    {
         $("#NumCifCli").removeClass("loader loader-default").addClass("loader loader-default is-active");
         var url = base_urlHome()+"api/Contratos/BuscarXIDContrato/CodCli/"+scope.CodCli+"/CodConCom/"+scope.CodConCom+"/CodProCom/"+scope.CodProCom;
         $http.get(url).then(function(result)
         {
            $("#NumCifCli").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if(result.data!=false)
            {
                scope.RazSocCli=result.data.Cliente.RazSocCli;
                scope.NumCifCli=result.data.Cliente.NumCifCli;
                scope.fdatos.CodCli=result.data.Cliente.CodCli;
                scope.fdatos.CodConCom=scope.CodConCom;     
                scope.List_Propuestas_Comerciales=result.data.List_Pro;
                scope.fdatos.CodProCom=scope.CodProCom;
                scope.filtrar_propuesta_contratos();
                scope.FecIniCon=result.data.Contrato.FecIniCon;
                scope.fdatos.DurCon=result.data.Contrato.DurCon;
                scope.FecVenCon=result.data.Contrato.FecVenCon;
                scope.fdatos.RefCon=result.data.Contrato.RefCon;
                scope.fdatos.DocConRut=result.data.Contrato.DocConRut;
                scope.fdatos.ObsCon=result.data.Contrato.ObsCon;
                $('.datepicker_Inicio').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", result.data.Contrato.FecIniCon);
                $('.datepicker_Vencimiento').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", result.data.Contrato.FecVenCon);
                console.log(result.data.List_Pro);
                console.log(scope.fdatos);
            }
            else
            {
                Swal.fire({ title: "Error", text: "El número de CIF no se encuentra asignado a ningun cliente.", type: "error", confirmButtonColor: "#188ae2" });
                location.href="#/Contratos";
            }

         },function(error)
         {
            $("#NumCifCli").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (error.status == 404 && error.statusText == "Not Found") {
                Swal.fire({ title: "Error General", text: "El método que esté intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 401 && error.statusText == "Unauthorized") {
                Swal.fire({ title: "Error de Privilegios", text: "Usuario no autorizado para acceder a este Módulo", type: "info", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 403 && error.statusText == "Forbidden") {
                Swal.fire({ title: "Error de Seguridad", text: "Está intentando utilizar un APIKEY inválido", type: "question", confirmButtonColor: "#188ae2" });
            }
            if (error.status == 500 && error.statusText == "Internal Server Error") {
                Swal.fire({ title: "Error de Servidor", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
            }
         });
    }

    if(scope.CodConCom==undefined && $route.current.$$route.originalPath=="/Contratos/")
    {
        scope.ruta_reportes_pdf_Contratos=0;
        scope.ruta_reportes_excel_Contratos=0;
        scope.FecCon=true;
        scope.CodCli=true;
        scope.CodCom=true;
        scope.CodAnePro=true;
        scope.DurCon=true;
        scope.FecVenCon=true;
        scope.EstBajCon=true;
        scope.ActCont=true;
        scope.opciones_contratos = [{ id: 1, nombre: 'VER' }, { id: 2, nombre: 'EDITAR' }, { id: 3, nombre: 'Renovar' }, { id: 4, nombre: 'Dar Baja' }];
        scope.get_list_contratos();
    }
    $scope.submitFormlock = function(event){
        
        var FecBajCon = document.getElementById("FecBajCon").value;
        scope.FecBajCon = FecBajCon;
        if (scope.FecBajCon == undefined || scope.FecBajCon == null || scope.FecBajCon == '') {
            Swal.fire({ text: 'La Fecha de Baja es obligatoria', type: "error", confirmButtonColor: "#188ae2" });
            return false;
        } 
        else {
            var FecBajCon = (scope.FecBajCon).split("/");
            if (FecBajCon.length < 3) {
                Swal.fire({ text: 'Error en Fecha de Baja, el formato correcto es DD/MM/YYYY', type: "error", confirmButtonColor: "#188ae2" });
                event.preventDefault();
                return false;
            } else {
                if (FecBajCon[0].length > 2 || FecBajCon[0].length < 2) {
                    Swal.fire({ text: 'Error en Día, debe introducir dos números', type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;
                }
                if (FecBajCon[1].length > 2 || FecBajCon[1].length < 2) {
                    Swal.fire({ text: 'Error en Mes, debe introducir dos números', type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;
                }
                if (FecBajCon[2].length < 4 || FecBajCon[2].length > 4) {
                    Swal.fire({ text: 'Error en Año, debe introducir cuatro números', type: "error", confirmButtonColor: "#188ae2" });
                    event.preventDefault();
                    return false;
                }
                valuesStart = scope.FecBajCon.split("/");
                valuesEnd = fecha.split("/");
                // Verificamos que la fecha no sea posterior a la actual
                var dateStart = new Date(valuesStart[2], (valuesStart[1] - 1), valuesStart[0]);
                var dateEnd = new Date(valuesEnd[2], (valuesEnd[1] - 1), valuesEnd[0]);
                if (dateStart > dateEnd) {
                    Swal.fire({ text: 'La Fecha de Baja no debe ser mayor a ' + fecha, type: "error", confirmButtonColor: "#188ae2" });
                    return false;
                }
                scope.tmodal_data.FecBajCon = valuesStart[2] + "-" + valuesStart[1] + "-" + valuesStart[0];
            }
            if (scope.tmodal_data.JusBajCon == undefined || scope.tmodal_data.JusBajCon == null || scope.tmodal_data.JusBajCon == '')
            {
                Swal.fire({ text: 'Debe indicar una justicación de la baja del contrato.', type: "error", confirmButtonColor: "#188ae2" });
                return false;
            }


        }
        console.log(scope.tmodal_data);
        Swal.fire({
            text: '¿Seguro que desea dar de baja este contrato?',
            type: "question",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: 'Dar Baja'
        }).then(function(t){
            if (t.value == true)
            {
                $("#BajaContrato").removeClass("loader loader-default").addClass("loader loader-default is-active");
                console.log(scope.tmodal_data);
                var url = base_urlHome()+"api/Contratos/dandobajaContrato/";
                $http.post(url,scope.tmodal_data).then(function(result)
                {
                    $("#BajaContrato").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if(result.data!=false)
                    {
                        Swal.fire({ title: "Contrato", text: "Contrato dado de baja sastifactoriamente.", type: "error", confirmButtonColor: "#188ae2" });
                        $("#modal_baja_contrato").modal('hide');
                        scope.get_list_contratos();
                    }
                    else
                    {
                        Swal.fire({ title: "Error General", text: "Error durante el proceso, intente nuevamente.", type: "error", confirmButtonColor: "#188ae2" });
                    }

                },function(error)
                {
                    $("#BajaContrato").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (error.status == 404 && error.statusText == "Not Found") {
                        Swal.fire({ title: "Error General", text: "El método que esté intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 401 && error.statusText == "Unauthorized") {
                        Swal.fire({ title: "Error de Privilegios", text: "Usuario no autorizado para acceder a este Módulo", type: "info", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 403 && error.statusText == "Forbidden") {
                        Swal.fire({ title: "Error de Seguridad", text: "Está intentando utilizar un APIKEY inválido", type: "question", confirmButtonColor: "#188ae2" });
                    }
                    if (error.status == 500 && error.statusText == "Internal Server Error") {
                        Swal.fire({ title: "Error de Servidor", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
                    }

                });
                
            } else {
                event.preventDefault();
                console.log('Cancelando ando...');
            }
        });
    };
    scope.regresar_filtro = function()
    {
        $scope.predicate = 'id';
        $scope.reverse = true;
        $scope.currentPage = 1;
        $scope.order = function(predicate) {
            $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
            $scope.predicate = predicate;
        };
        scope.T_Contratos = scope.T_ContratosBack;
        $scope.totalItems = scope.T_Contratos.length;
        $scope.numPerPage = 50;
        $scope.paginate = function(value) {
            var begin, end, index;
            begin = ($scope.currentPage - 1) * $scope.numPerPage;
            end = begin + $scope.numPerPage;
            index = scope.T_Contratos.indexOf(value);
            return (begin <= index && index < end);
        }
        scope.ruta_reportes_pdf_Contratos = 0;
        scope.ruta_reportes_excel_Contratos = 0;
        scope.tmodal_filtros = {};
        scope.RangFec=undefined;
        scope.NumCifCliFil=undefined;
        scope.EstBajConFil=undefined;
        scope.CodCliFil=undefined;
    }
     $scope.SubmitFormFiltrosContratos = function(event) 
    {   
        if(scope.tmodal_filtros.tipo_filtro==1)
        {
            var RangFec1 = document.getElementById("RangFec").value;
            scope.RangFec = RangFec1;
            if(scope.RangFec==undefined || scope.RangFec==null || scope.RangFec=='')
            {
                Swal.fire({ title: "Error", text: "Debe indicar una fecha para poder aplicar el filtro.", type: "error", confirmButtonColor: "#188ae2" }); 
                return false;
            }
            $scope.predicate = 'id';
            $scope.reverse = true;
            $scope.currentPage = 1;
            $scope.order = function(predicate) {
                $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                $scope.predicate = predicate;
            };
             //scope.Tabla_Contacto=result.data;
            scope.T_Contratos = $filter('filter')(scope.T_ContratosBack, { FecConCom: scope.RangFec }, true);
            $scope.totalItems = scope.T_Contratos.length;
            $scope.numPerPage = 50;
            $scope.paginate = function(value) {
                var begin, end, index;
                begin= ($scope.currentPage - 1) * $scope.numPerPage;
                end = begin + $scope.numPerPage;
                index = scope.T_Contratos.indexOf(value);
                return (begin <= index && index < end);
            }
            scope.ruta_reportes_pdf_Contratos = scope.tmodal_filtros.tipo_filtro + "/" + scope.RangFec;
            scope.ruta_reportes_excel_Contratos = scope.tmodal_filtros.tipo_filtro + "/" + scope.RangFec;

        }
        if(scope.tmodal_filtros.tipo_filtro==2)
        {
            if(scope.CodCliFil==undefined || scope.CodCliFil==null || scope.CodCliFil=='')
            {
                Swal.fire({ title: "Error", text: "Debe buscar un cliente para poder aplicar el filtro.", type: "error", confirmButtonColor: "#188ae2" }); 
                return false;
            }
            $scope.predicate = 'id';
            $scope.reverse = true;
            $scope.currentPage = 1;
            $scope.order = function(predicate) {
                $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                $scope.predicate = predicate;
            };
             //scope.Tabla_Contacto=result.data;
            scope.T_Contratos = $filter('filter')(scope.T_ContratosBack, { CodCli: scope.CodCliFil }, true);
            $scope.totalItems = scope.T_Contratos.length;
            $scope.numPerPage = 50;
            $scope.paginate = function(value) {
                var begin, end, index;
                begin= ($scope.currentPage - 1) * $scope.numPerPage;
                end = begin + $scope.numPerPage;
                index = scope.T_Contratos.indexOf(value);
                return (begin <= index && index < end);
            }
            scope.ruta_reportes_pdf_Contratos = scope.tmodal_filtros.tipo_filtro + "/" + scope.CodCliFil;
            scope.ruta_reportes_excel_Contratos = scope.tmodal_filtros.tipo_filtro + "/" + scope.CodCliFil;

        }
        if(scope.tmodal_filtros.tipo_filtro==3)
        {
            if(!scope.EstBajConFil>0)
            {
                Swal.fire({ title: "Error", text: "Debe seleccionar un estatus para poder aplicar el filtro.", type: "error", confirmButtonColor: "#188ae2" }); 
                return false;
            }
            $scope.predicate = 'id';
            $scope.reverse = true;
            $scope.currentPage = 1;
            $scope.order = function(predicate) {
                $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                $scope.predicate = predicate;
            };
             //scope.Tabla_Contacto=result.data;
            scope.T_Contratos = $filter('filter')(scope.T_ContratosBack, { EstBajCon: scope.EstBajConFil }, true);
            $scope.totalItems = scope.T_Contratos.length;
            $scope.numPerPage = 50;
            $scope.paginate = function(value) {
                var begin, end, index;
                begin= ($scope.currentPage - 1) * $scope.numPerPage;
                end = begin + $scope.numPerPage;
                index = scope.T_Contratos.indexOf(value);
                return (begin <= index && index < end);
            }
            scope.ruta_reportes_pdf_Contratos = scope.tmodal_filtros.tipo_filtro + "/" + scope.EstBajConFil;
            scope.ruta_reportes_excel_Contratos = scope.tmodal_filtros.tipo_filtro + "/" + scope.EstBajConFil;

        }
                           
    };
    ///////// PARA CALCULAR DNI/NIE START /////////////////
    scope.validarNIFDNI=function()
    {
        var letter = scope.validar_dni_nfi($("#NumCifCli").parent(),$("#NumCifCli").val());
        if(letter != false){
            $("#iLetter").replaceWith("<p id='iLetter' class='ok'>La letra es: <strong>" + letter + "</strong> <br/> El DNI o NIE es: <strong>" + $("#NumCifCli").val() + letter + "</strong> </p>");
        }else{
            $("#iLetter").replaceWith("<p id='iLetter' class='error'>Esperando a los n&uacute;meros</p>");
        }
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
    scope.validar_dni_nfi=function(field, txt)
    {
        console.log(field);
        console.log(txt);
        var letter = ""
        // Si es un dni extrangero, es decir, empieza por X, Y, Z
        // Si la longitud es 8longitud total de los dni nacionales)
        if (txt.length == 8) {
            var first = txt.substring(0, 1)
            if (first == 'X' || first == 'Y' || first == 'Z') {
                // Si la longitud es 9(longitud total de los dni extrangeros)

                // Se calcula la letra para el numero de dni
                var number = txt.substring(1, 8);
                if (first == 'X') {
                    number = '0' + number
                }
                if (first == 'Y') {
                    number = '1' + number
                }
                if (first == 'Z') {
                    number = '2' + number
                }
                if (isNumeric(number)){
                    letter = calculateLetterForDni(number)
                }

                if (letter != "")
                {
                    field.removeClass("kindagood welldone")
                    // Se aÃ±ade solo la clase welldone que indica que esta
                    // correcto
                    field.addClass("welldone")
                    return letter
                }

            } else {
                // Se realizan las mismas operaciones que para el caso anterior
                // pero con un caracter menos
                letter = calculateLetterForDni(txt.substring(0, 8))
                if (letter != "") {

                    field.removeClass("kindagood welldone")
                    field.addClass("welldone")
                    return letter
                }
            }
        }
        // Si no es ningun dni, se borran las clases kindagoog y welldone si es
        // estÃ¡n activas
        // Para que se muestre la ayuda en le color original.
        field.removeClass("kindagood welldone")

        if (txt.length == 8) {
            // Si la longitud es la correcta pero el dni no lo es, entonces se
            // aÃ±ade
            // la clase kindagood que indica que ha habido algun error en la
            // escritura
            field.addClass("kindagood")
        }
        return false
    }
    ///////// PARA CALCULAR DNI/NIE END /////////////////
  
    if(scope.CodCli!=undefined && scope.fdatos.tipo=="nuevo")
    {
        scope.BuscarXIDPropuestaContrato();
    }
    if(scope.CodCli!=undefined && scope.fdatos.tipo=="ver" || scope.CodCli!=undefined && scope.fdatos.tipo=="editar")
    {
        scope.BuscarXIDContrato();
    }
    /*if(scope.CodCli!=undefined)
    {
        scope.BuscarXIDPropuestaContrato();
    }*/
    /*else
    {
       scope.BuscarXIDPropuestaContrato(); 
    }*/
////////////////////////////////////////////////// PARA LOS CONTRATOS END ///////////////////////////////////////////////////////////////    
 }