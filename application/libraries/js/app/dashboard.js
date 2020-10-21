 app.controller('Controlador_Dashbord', ['$http', '$scope', '$filter', '$route', '$interval', '$controller', '$cookies', '$compile', Controlador]);

 function Controlador($http, $scope, $filter, $route, $interval, $controller, $cookies, $compile) {
     var scope = this;
     scope.fdatos = {};
     scope.searchResult = {};
     scope.list_customers = [];
     scope.response_customer = {};
     scope.Nivel = $cookies.get('nivel');
     var fecha = new Date();
     var dd = fecha.getDate();
     var mm = fecha.getMonth() + 1; //January is 0!
     var yyyy = fecha.getFullYear();
     if (dd < 10) {
         dd = '0' + dd;
     }
     if (mm < 10) {
         mm = '0' + mm;
     }
     var fecha = dd + '/' + mm + '/' + yyyy;
     ////////////////////////////////////////////////// PARA EL DASHBOARD START ////////////////////////////////////////////////////////
     //console.log($route.current.$$route.originalPath);

     scope.showDatosGenerales = true;
     scope.showContactosRepresentante = true;
     scope.showPuntosSuministros = true;
     scope.showCuentasBancarias = true;
     scope.showDocumentos = true;
     scope.response_customer.Contactos = [];
     scope.response_customer.Cuentas_Bancarias = [];
     scope.response_customer.documentos = [];
     scope.response_customer.Puntos_Suministros = [];
     scope.response_customer.All_CUPs=[];

     //console.log(scope.response_customer.Contactos);
     //console.log(scope.response_customer.Cuentas_Bancarias);
     //console.log(scope.response_customer.documentos);
     scope.showDetails = function(menu) {
         if (menu == 1) {
             if (scope.showDatosGenerales == true) {
                 scope.showDatosGenerales = false;
             } else {
                 scope.showDatosGenerales = true;
             }
         }
         if (menu == 2) {
             if (scope.showContactosRepresentante == true) {
                 scope.showContactosRepresentante = false;
             } else {
                 scope.showContactosRepresentante = true;
             }
         }
         if (menu == 3) {
             if (scope.showPuntosSuministros == true) {
                 scope.showPuntosSuministros = false;
             } else {
                 scope.showPuntosSuministros = true;
             }
         }
         if (menu == 4) {
             if (scope.showCuentasBancarias == true) {
                 scope.showCuentasBancarias = false;
             } else {
                 scope.showCuentasBancarias = true;
             }
         }
         if (menu == 5) {
             if (scope.showDocumentos == true) {
                 scope.showDocumentos = false;
             } else {
                 scope.showDocumentos = true;
             }
         }
     }
     scope.fetchClientes = function() {
             //console.log(scope.searchText);
             var searchText_len = scope.searchText.trim().length;
             //console.log(searchText_len);
             scope.fdatos.searchText = scope.searchText;
             scope.response_customer.CUPs_Electrico = [];
             scope.response_customer.CUPs_Gas = [];
             console.log(scope.response_customer.CUPs_Electrico);
             console.log(scope.response_customer.CUPs_Gas);
             if (searchText_len > 0) {
                 var url = base_urlHome() + "api/Dashboard/getclientes";
                 $http.post(url, scope.fdatos).then(function(result) {
                     console.log(result);
                     if (result.data != false) {
                         scope.searchResult = result.data;
                         console.log(scope.searchResult);
                     } else {
                         scope.searchResult = {};
                     }
                 }, function(error) {
                     if (error.status == 404 && error.statusText == "Not Found") {
                         Swal.fire({ title: "Error 404", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
                     }
                     if (error.status == 401 && error.statusText == "Unauthorized") {
                         Swal.fire({ title: "Error 401", text: "Disculpe, Usuario no autorizado para acceder a ester módulo", type: "error", confirmButtonColor: "#188ae2" });
                     }
                     if (error.status == 403 && error.statusText == "Forbidden") {
                         Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY incorrecto", type: "error", confirmButtonColor: "#188ae2" });
                     }
                     if (error.status == 500 && error.statusText == "Internal Server Error") {
                         Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
                     }
                 });
             } else {
                 scope.searchResult = {};
             }
         }
         // Set value to search box
     scope.setValue = function(index, $event, result) {
         console.log(index);
         console.log($event);
         console.log(result);

         scope.response_customer.CUPs_Electrico = [];
         scope.response_customer.CUPs_Gas = [];
         console.log(scope.searchResult[index].CodCli);
         scope.fdatos.CodCli = scope.searchResult[index].CodCli;
         scope.searchText=scope.searchResult[index].CodCli+" - "+scope.searchResult[index].NumCifCli;
         scope.searchResult = {};
         $event.stopPropagation();
         scope.view_information();
     }
     scope.searchboxClicked = function($event) {
         $event.stopPropagation();
     }
     scope.containerClicked = function() {
         scope.searchResult = {};
     }
     scope.load_customers = function() {
         $("#List_Cli").removeClass("loader loader-default").addClass("loader loader-default  is-active");
         var url = base_urlHome() + "api/Dashboard/get_all_list_customers";
         $http.get(url).then(function(result) {
             $("#List_Cli").removeClass("loader loader-default is-active").addClass("loader loader-default");
             if (result.data != false) {
                 scope.list_customers = result.data;
             } else {
                scope.searchResult = {};
             }
         }, function(error) {
             $("#List_Cli").removeClass("loader loader-default is-active").addClass("loader loader-default");
             if (error.status == 404 && error.statusText == "Not Found") {
                 Swal.fire({ title: "Error 404", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
             }
             if (error.status == 401 && error.statusText == "Unauthorized") {
                 Swal.fire({ title: "Error 401", text: "Disculpe, Usuario no autorizado para acceder a ester módulo", type: "error", confirmButtonColor: "#188ae2" });
             }
             if (error.status == 403 && error.statusText == "Forbidden") {
                 Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY incorrecto", type: "error", confirmButtonColor: "#188ae2" });
             }
             if (error.status == 500 && error.statusText == "Internal Server Error") {
                 Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
             }
         });
     }
     scope.view_information = function() {
         scope.response_customer.DirPumSum = undefined;
         scope.response_customer.EscPlaPuerPumSum = undefined;
         scope.response_customer.DesLocPumSum = undefined;
         scope.response_customer.DesProPumSum = undefined;
         scope.response_customer.CPLocPumSum = undefined;
         scope.response_customer.CUPs_Electrico = [];
         scope.response_customer.CUPs_Gas = [];
         scope.response_customer.All_CUPs=[];
         if (scope.fdatos.CodCli == '' || scope.fdatos.CodCli == null || scope.fdatos.CodCli == undefined) {
             Swal.fire({
                 title: "Error",
                 text: "Debe seleccionar un cliente de la lista.",
                 type: "error",
                 confirmButtonColor: "#188ae2"
             });
             $("#CodCli").addClass("btn-danger");
             setTimeout(function() {
                 $("#CodCli").removeClass("btn-danger");
             }, 3000);
             return false;
         }
         $("#Buscando_Informacion").removeClass("loader loader-default").addClass("loader loader-default is-active");
         var url = base_urlHome() + "api/Dashboard/view_information_customers/CodCli/" + scope.fdatos.CodCli;
         $http.get(url).then(function(result) {
             $("#Buscando_Informacion").removeClass("loader loader-default is-active").addClass("loader loader-default");
             if (result.data != false) {
                 scope.response_customer.CodCli = result.data.customer.CodCli;
                 scope.response_customer.RazSocCli = result.data.customer.RazSocCli;
                 scope.response_customer.NumCifCli = result.data.customer.NumCifCli;
                 scope.response_customer.DomSoc = result.data.customer.DomSoc;
                 scope.response_customer.EscPlaPuerSoc = result.data.customer.EscDomSoc + " " + result.data.customer.PlaDomSoc + " " + result.data.customer.PueDomSoc;
                 scope.response_customer.DesSoc = result.data.customer.DesLocSoc;
                 scope.response_customer.ProSoc = result.data.customer.DesProSoc;
                 scope.response_customer.LocSoc = result.data.customer.CPLocSoc;

                 scope.response_customer.CodPro = result.data.customer.CodPro;
                 scope.response_customer.CodProFis = result.data.customer.CodProFis;
                 scope.response_customer.DomFis = result.data.customer.DomFis;
                 scope.response_customer.EscPlaPuerFis = result.data.customer.EscDomFis + " " + result.data.customer.PlaDomFis + " " + result.data.customer.PueDomFis;
                 scope.response_customer.DesLocFis = result.data.customer.DesLocFis;
                 scope.response_customer.DesProFis = result.data.customer.DesProFis;
                 scope.response_customer.CPLocFis = result.data.customer.CodLocFis;

                scope.response_customer.TelFijCli = result.data.customer.TelFijCli;
                scope.response_customer.TelMovCli = result.data.customer.TelMovCli;
                scope.response_customer.EmaCli = result.data.customer.EmaCli;
                 scope.response_customer.EmaCliOpc = result.data.customer.EmaCliOpc;

                if(result.data.CUPs_Electricos.length>0)
                {
                    angular.forEach(result.data.CUPs_Electricos, function(CUPs_Electricos)
                    {
                        scope.response_customer.All_CUPs.push({CUPsName:CUPs_Electricos.CUPsEle,
                            DirPunSum:CUPs_Electricos.DirPumSum+" "+CUPs_Electricos.CPLocSoc+" "+CUPs_Electricos.EscPlaPue,CanPerTar:CUPs_Electricos.CanPerTar,PotConP1:CUPs_Electricos.PotConP1
                            ,PotConP2:CUPs_Electricos.PotConP2,PotConP3:CUPs_Electricos.PotConP3,PotConP4:CUPs_Electricos.PotConP4
                            ,PotConP5:CUPs_Electricos.PotConP5,PotConP6:CUPs_Electricos.PotConP6,NomTar:CUPs_Electricos.NomTarEle,
                            RazSocDis:CUPs_Electricos.RazSocDis

                        ,TipServ:CUPs_Electricos.TipServ,CodCups:CUPs_Electricos.CodCupsEle
                        });
                     
                    });
                }
                if(result.data.CUPs_Gas.length>0)
                {
                    angular.forEach(result.data.CUPs_Gas, function(CUPs_Gas)
                    {
                        scope.response_customer.All_CUPs.push({CUPsName:CUPs_Gas.CupsGas,DirPunSum:CUPs_Gas.DirPumSum+" "+CUPs_Gas.CPLocSoc+" "+CUPs_Gas.EscPlaPue
                        ,NomTar:CUPs_Gas.NomTarGas,RazSocDis:CUPs_Gas.RazSocDis
                        ,TipServ:CUPs_Gas.TipServ,CodCups:CUPs_Gas.CodCupGas
                    });
                     


                    });
                }
                console.log(scope.response_customer.All_CUPs);

                if (result.data.Contactos != false) {
                     scope.response_customer.Contactos = result.data.Contactos;
                 } else {
                     scope.response_customer.Contactos = [];
                 }

                 if (result.data.Cuenta_Bancarias != false) {
                     scope.response_customer.Cuentas_Bancarias = result.data.Cuenta_Bancarias;
                 } else {
                     scope.response_customer.Cuentas_Bancarias = [];
                 }

                 if (result.data.Documentos != false) {
                     scope.response_customer.documentos = result.data.Documentos;

                 } else {
                     scope.response_customer.documentos = [];
                 }
                 if (result.data.Contactos != false) {
                     angular.forEach(result.data.Contactos, function(Contactos) {
                         if (Contactos.EsRepLeg == 1) {
                             //Contactos.DocNIF
                             var Fichero = (Contactos.DocNIF).split("/");
                             //console.log(Fichero);
                             var Fichero_Final = Fichero[1];
                             //console.log(Fichero_Final);
                             scope.response_customer.documentos.push({ ArcDoc: Contactos.DocNIF, DesDoc: Fichero_Final, DesTipDoc: Contactos.TipRepr });
                         }
                     });
                 }
                 //console.log(result.data.customer);
                 //console.log(scope.response_customer.Puntos_Suministros);
                 ///console.log(scope.response_customer.Contactos);
                 //console.log(scope.response_customer.Cuentas_Bancarias);
                 //console.log(scope.response_customer.documentos);
             } else {
                 Swal.fire({ title: "Error", text: "No existen datos relacionados con este cliente.", type: "error", confirmButtonColor: "#188ae2" });
             }
         }, function(error) {
             $("#Buscando_Informacion").removeClass("loader loader-default is-active").addClass("loader loader-default");
             if (error.status == 404 && error.statusText == "Not Found") {
                 Swal.fire({ title: "Error 404", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
             }
             if (error.status == 401 && error.statusText == "Unauthorized") {
                 Swal.fire({ title: "Error 401", text: "Disculpe, Usuario no autorizado para acceder a ester módulo", type: "error", confirmButtonColor: "#188ae2" });
             }
             if (error.status == 403 && error.statusText == "Forbidden") {
                 Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY incorrecto", type: "error", confirmButtonColor: "#188ae2" });
             }
             if (error.status == 500 && error.statusText == "Internal Server Error") {
                 Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
             }

         });
     }
     scope.filter_DirPumSum = function(CodPunSum) {
         //console.log(CodPunSum);
         //scope.response_customer.DirPumSum=undefined;
         scope.response_customer.EscPlaPuerPumSum = undefined;
         scope.response_customer.DesLocPumSum = undefined;
         scope.response_customer.DesProPumSum = undefined;
         scope.response_customer.CPLocPumSum = undefined;
         scope.response_customer.CUPs_Electrico = [];
         scope.response_customer.CUPs_Gas = [];
         for (var i = 0; i < scope.response_customer.Puntos_Suministros.length; i++) {
             if (scope.response_customer.Puntos_Suministros[i].CodPunSum == CodPunSum) {
                 //console.log(scope.response_customer.Puntos_Suministros[i]);
                 scope.response_customer.DirDesPumSum = scope.response_customer.Puntos_Suministros[i].DirPumSum;
                 scope.response_customer.EscPlaPuerPumSum = scope.response_customer.Puntos_Suministros[i].EscPunSum + " " + scope.response_customer.Puntos_Suministros[i].PlaPunSum + " " + scope.response_customer.Puntos_Suministros[i].PuePunSum;
                 scope.response_customer.DesLocPumSum = scope.response_customer.Puntos_Suministros[i].DesLoc;
                 scope.response_customer.DesProPumSum = scope.response_customer.Puntos_Suministros[i].DesPro;
                 scope.response_customer.CPLocPumSum = scope.response_customer.Puntos_Suministros[i].CPLocSoc;
             }
         }
         $("#Buscando_Informacion").removeClass("loader loader-default").addClass("loader loader-default is-active");
         var url = base_urlHome() + "api/Dashboard/Search_CUPs_Customer/CodPumSum/" + CodPunSum;
         $http.get(url).then(function(result) {
             $("#Buscando_Informacion").removeClass("loader loader-default is-active").addClass("loader loader-default");
             console.log(result);
             scope.response_customer.CUPs_Electrico = result.data.CUPs_Electricos;
             scope.response_customer.CUPs_Gas = result.data.CUPs_Gas;

         }, function(error) {
             $("#Buscando_Informacion").removeClass("loader loader-default is-active").addClass("loader loader-default");
             console.log(error);
             if (error.status == 404 && error.statusText == "Not Found") {
                 Swal.fire({ title: "Error 404", text: "El método que está intentando usar no puede ser localizado", type: "error", confirmButtonColor: "#188ae2" });
             }
             if (error.status == 401 && error.statusText == "Unauthorized") {
                 Swal.fire({ title: "Error 401", text: "Disculpe, Usuario no autorizado para acceder a ester módulo", type: "error", confirmButtonColor: "#188ae2" });
             }
             if (error.status == 403 && error.statusText == "Forbidden") {
                 Swal.fire({ title: "Error 403", text: "Está intentando utilizar un APIKEY incorrecto", type: "error", confirmButtonColor: "#188ae2" });
             }
             if (error.status == 500 && error.statusText == "Internal Server Error") {
                 Swal.fire({ title: "Error 500", text: "Ha ocurrido una falla en el Servidor, intente más tarde", type: "error", confirmButtonColor: "#188ae2" });
             }


         });
     }
     scope.copyText = function(metodo) {
         if (metodo == 1) {
             var RazSocCli = document.getElementById("RazSocCli");
             var contenedor = document.getElementById("xcontainer");
             RazSocCli.select();
             try {
                 var successful = document.execCommand('copy');
                 if (successful) contenedor.innerHTML = '<span class="label label-success"><i class="fa fa-check-circle"></i> Copiado!</span>';
                 else contenedor.innerHTML = '<span class="label label-warning"><i class="fa fa-ban"></i> Incapaz de copiar!</span>';
             } catch (err) {
                 contenedor.innerHTML = '<span class="label label-danger"><i class="fa fa-ban"></i> Browser no soportado!</span>';
             }
             setTimeout(function() { contenedor.innerHTML = ''; }, 3000);
         }
         if (metodo == 2) {
             var NumCifCli = document.getElementById("NumCifCli");
             var contenedor = document.getElementById("xcontainer");
             NumCifCli.select();
             try {
                 var successful = document.execCommand('copy');
                 if (successful) contenedor.innerHTML = '<span class="label label-success"><i class="fa fa-check-circle"></i> Copiado!</span>';
                 else contenedor.innerHTML = '<span class="label label-warning"><i class="fa fa-ban"></i> Incapaz de copiar!</span>';
             } catch (err) {
                 contenedor.innerHTML = '<span class="label label-danger"><i class="fa fa-ban"></i> Browser no soportado!</span>';
             }
             setTimeout(function() { contenedor.innerHTML = ''; }, 3000);
         }
         if (metodo == 3) {
             var DomSoc = document.getElementById("DomSoc");
             var contenedor = document.getElementById("xcontainer");
             DomSoc.select();
             try {
                 var successful = document.execCommand('copy');
                 if (successful) contenedor.innerHTML = '<span class="label label-success"><i class="fa fa-check-circle"></i> Copiado!</span>';
                 else contenedor.innerHTML = '<span class="label label-warning"><i class="fa fa-ban"></i> Incapaz de copiar!</span>';
             } catch (err) {
                 contenedor.innerHTML = '<span class="label label-danger"><i class="fa fa-ban"></i> Browser no soportado!</span>';
             }
             setTimeout(function() { contenedor.innerHTML = ''; }, 3000);
         }
         if (metodo == 4) {
             var EscPlaPuerSoc = document.getElementById("EscPlaPuerSoc");
             var contenedor = document.getElementById("xcontainer");
             EscPlaPuerSoc.select();
             try {
                 var successful = document.execCommand('copy');
                 if (successful) contenedor.innerHTML = '<span class="label label-success"><i class="fa fa-check-circle"></i> Copiado!</span>';
                 else contenedor.innerHTML = '<span class="label label-warning"><i class="fa fa-ban"></i> Incapaz de copiar!</span>';
             } catch (err) {
                 contenedor.innerHTML = '<span class="label label-danger"><i class="fa fa-ban"></i> Browser no soportado!</span>';
             }
             setTimeout(function() { contenedor.innerHTML = ''; }, 3000);
         }
         if (metodo == 5) {
             var DesLocSoc = document.getElementById("DesLocSoc");
             var contenedor = document.getElementById("xcontainer");
             DesLocSoc.select();
             try {
                 var successful = document.execCommand('copy');
                 if (successful) contenedor.innerHTML = '<span class="label label-success"><i class="fa fa-check-circle"></i> Copiado!</span>';
                 else contenedor.innerHTML = '<span class="label label-warning"><i class="fa fa-ban"></i> Incapaz de copiar!</span>';
             } catch (err) {
                 contenedor.innerHTML = '<span class="label label-danger"><i class="fa fa-ban"></i> Browser no soportado!</span>';
             }
             setTimeout(function() { contenedor.innerHTML = ''; }, 3000);
         }
         if (metodo == 6) {
             var DesProSoc = document.getElementById("DesProSoc");
             var contenedor = document.getElementById("xcontainer");
             DesProSoc.select();
             try {
                 var successful = document.execCommand('copy');
                 if (successful) contenedor.innerHTML = '<span class="label label-success"><i class="fa fa-check-circle"></i> Copiado!</span>';
                 else contenedor.innerHTML = '<span class="label label-warning"><i class="fa fa-ban"></i> Incapaz de copiar!</span>';
             } catch (err) {
                 contenedor.innerHTML = '<span class="label label-danger"><i class="fa fa-ban"></i> Browser no soportado!</span>';
             }
             setTimeout(function() { contenedor.innerHTML = ''; }, 3000);
         }
         if (metodo == 7) {
             var LocSoc = document.getElementById("LocSoc");
             var contenedor = document.getElementById("xcontainer");
             LocSoc.select();
             try {
                 var successful = document.execCommand('copy');
                 if (successful) contenedor.innerHTML = '<span class="label label-success"><i class="fa fa-check-circle"></i> Copiado!</span>';
                 else contenedor.innerHTML = '<span class="label label-warning"><i class="fa fa-ban"></i> Incapaz de copiar!</span>';
             } catch (err) {
                 contenedor.innerHTML = '<span class="label label-danger"><i class="fa fa-ban"></i> Browser no soportado!</span>';
             }
             setTimeout(function() { contenedor.innerHTML = ''; }, 3000);
         }
         if (metodo == 8) {
             var DomFis = document.getElementById("DomFis");
             var contenedor = document.getElementById("xcontainer");
             DomFis.select();
             try {
                 var successful = document.execCommand('copy');
                 if (successful) contenedor.innerHTML = '<span class="label label-success"><i class="fa fa-check-circle"></i> Copiado!</span>';
                 else contenedor.innerHTML = '<span class="label label-warning"><i class="fa fa-ban"></i> Incapaz de copiar!</span>';
             } catch (err) {
                 contenedor.innerHTML = '<span class="label label-danger"><i class="fa fa-ban"></i> Browser no soportado!</span>';
             }
             setTimeout(function() { contenedor.innerHTML = ''; }, 3000);
         }
         if (metodo == 9) {
             var EscPlaPuerFis = document.getElementById("EscPlaPuerFis");
             var contenedor = document.getElementById("xcontainer");
             EscPlaPuerFis.select();
             try {
                 var successful = document.execCommand('copy');
                 if (successful) contenedor.innerHTML = '<span class="label label-success"><i class="fa fa-check-circle"></i> Copiado!</span>';
                 else contenedor.innerHTML = '<span class="label label-warning"><i class="fa fa-ban"></i> Incapaz de copiar!</span>';
             } catch (err) {
                 contenedor.innerHTML = '<span class="label label-danger"><i class="fa fa-ban"></i> Browser no soportado!</span>';
             }
             setTimeout(function() { contenedor.innerHTML = ''; }, 3000);
         }
         if (metodo == 10) {
             var DesLocFis = document.getElementById("DesLocFis");
             var contenedor = document.getElementById("xcontainer");
             DesLocFis.select();
             try {
                 var successful = document.execCommand('copy');
                 if (successful) contenedor.innerHTML = '<span class="label label-success"><i class="fa fa-check-circle"></i> Copiado!</span>';
                 else contenedor.innerHTML = '<span class="label label-warning"><i class="fa fa-ban"></i> Incapaz de copiar!</span>';
             } catch (err) {
                 contenedor.innerHTML = '<span class="label label-danger"><i class="fa fa-ban"></i> Browser no soportado!</span>';
             }
             setTimeout(function() { contenedor.innerHTML = ''; }, 3000);
         }
         if (metodo == 11) {
             var DesProFis = document.getElementById("DesProFis");
             var contenedor = document.getElementById("xcontainer");
             DesProFis.select();
             try {
                 var successful = document.execCommand('copy');
                 if (successful) contenedor.innerHTML = '<span class="label label-success"><i class="fa fa-check-circle"></i> Copiado!</span>';
                 else contenedor.innerHTML = '<span class="label label-warning"><i class="fa fa-ban"></i> Incapaz de copiar!</span>';
             } catch (err) {
                 contenedor.innerHTML = '<span class="label label-danger"><i class="fa fa-ban"></i> Browser no soportado!</span>';
             }
             setTimeout(function() { contenedor.innerHTML = ''; }, 3000);
         }
         if (metodo == 12) {
             var CPLocFis = document.getElementById("CPLocFis");
             var contenedor = document.getElementById("xcontainer");
             CPLocFis.select();
             try {
                 var successful = document.execCommand('copy');
                 if (successful) contenedor.innerHTML = '<span class="label label-success"><i class="fa fa-check-circle"></i> Copiado!</span>';
                 else contenedor.innerHTML = '<span class="label label-warning"><i class="fa fa-ban"></i> Incapaz de copiar!</span>';
             } catch (err) {
                 contenedor.innerHTML = '<span class="label label-danger"><i class="fa fa-ban"></i> Browser no soportado!</span>';
             }
             setTimeout(function() { contenedor.innerHTML = ''; }, 3000);
         }
         if (metodo == 13) {
             var TelFijCli = document.getElementById("TelFijCli");
             var contenedor = document.getElementById("xcontainer");
             TelFijCli.select();
             try {
                 var successful = document.execCommand('copy');
                 if (successful) contenedor.innerHTML = '<span class="label label-success"><i class="fa fa-check-circle"></i> Copiado!</span>';
                 else contenedor.innerHTML = '<span class="label label-warning"><i class="fa fa-ban"></i> Incapaz de copiar!</span>';
             } catch (err) {
                 contenedor.innerHTML = '<span class="label label-danger"><i class="fa fa-ban"></i> Browser no soportado!</span>';
             }
             setTimeout(function() { contenedor.innerHTML = ''; }, 3000);
         }
         if (metodo == 14) {
             var EmaCli = document.getElementById("EmaCli");
             var contenedor = document.getElementById("xcontainer");
             EmaCli.select();
             try {
                 var successful = document.execCommand('copy');
                 if (successful) contenedor.innerHTML = '<span class="label label-success"><i class="fa fa-check-circle"></i> Copiado!</span>';
                 else contenedor.innerHTML = '<span class="label label-warning"><i class="fa fa-ban"></i> Incapaz de copiar!</span>';
             } catch (err) {
                 contenedor.innerHTML = '<span class="label label-danger"><i class="fa fa-ban"></i> Browser no soportado!</span>';
             }
             setTimeout(function() { contenedor.innerHTML = ''; }, 3000);
         }

         if (metodo == 15) {
             var CUpsNameModal = document.getElementById("CUpsNameModal");
             var contenedor = document.getElementById("xcontainer");
             //console.log(DirDesPumSum);

             CUpsNameModal.select();
             try {
                 var successful = document.execCommand('copy');
                 if (successful) contenedor.innerHTML = '<span class="label label-success"><i class="fa fa-check-circle"></i> Copiado!</span>';
                 else contenedor.innerHTML = '<span class="label label-warning"><i class="fa fa-ban"></i> Incapaz de copiar!</span>';
             } catch (err) {
                 contenedor.innerHTML = '<span class="label label-danger"><i class="fa fa-ban"></i> Browser no soportado!</span>';
             }
             setTimeout(function() { contenedor.innerHTML = ''; }, 3000);
         }
        if (metodo == 16) {
             var DirPunSumModal = document.getElementById("DirPunSumModal");
             var contenedor = document.getElementById("xcontainer");
             DirPunSumModal.select();
             try {
                 var successful = document.execCommand('copy');
                 if (successful) contenedor.innerHTML = '<span class="label label-success"><i class="fa fa-check-circle"></i> Copiado!</span>';
                 else contenedor.innerHTML = '<span class="label label-warning"><i class="fa fa-ban"></i> Incapaz de copiar!</span>';
             } catch (err) {
                 contenedor.innerHTML = '<span class="label label-danger"><i class="fa fa-ban"></i> Browser no soportado!</span>';
             }
             setTimeout(function() { contenedor.innerHTML = ''; }, 3000);
         }
         if (metodo == 17) {
             var NomTarModal = document.getElementById("NomTarModal");
             var contenedor = document.getElementById("xcontainer");
             NomTarModal.select();
             try {
                 var successful = document.execCommand('copy');
                 if (successful) contenedor.innerHTML = '<span class="label label-success"><i class="fa fa-check-circle"></i> Copiado!</span>';
                 else contenedor.innerHTML = '<span class="label label-warning"><i class="fa fa-ban"></i> Incapaz de copiar!</span>';
             } catch (err) {
                 contenedor.innerHTML = '<span class="label label-danger"><i class="fa fa-ban"></i> Browser no soportado!</span>';
             }
             setTimeout(function() { contenedor.innerHTML = ''; }, 3000);
         }
         if (metodo == 18) {
             var RazSocDisModal = document.getElementById("RazSocDisModal");
             var contenedor = document.getElementById("xcontainer");
             RazSocDisModal.select();
             try {
                 var successful = document.execCommand('copy');
                 if (successful) contenedor.innerHTML = '<span class="label label-success"><i class="fa fa-check-circle"></i> Copiado!</span>';
                 else contenedor.innerHTML = '<span class="label label-warning"><i class="fa fa-ban"></i> Incapaz de copiar!</span>';
             } catch (err) {
                 contenedor.innerHTML = '<span class="label label-danger"><i class="fa fa-ban"></i> Browser no soportado!</span>';
             }
             setTimeout(function() { contenedor.innerHTML = ''; }, 3000);
         }
        
        /*if (metodo == 19) {
             var CPLocPumSum = document.getElementById("CPLocPumSum");
             var contenedor = document.getElementById("xcontainer");
             CPLocPumSum.select();
             try {
                 var successful = document.execCommand('copy');
                 if (successful) contenedor.innerHTML = '<span class="label label-success"><i class="fa fa-check-circle"></i> Copiado!</span>';
                 else contenedor.innerHTML = '<span class="label label-warning"><i class="fa fa-ban"></i> Incapaz de copiar!</span>';
             } catch (err) {
                 contenedor.innerHTML = '<span class="label label-danger"><i class="fa fa-ban"></i> Browser no soportado!</span>';
             }
             setTimeout(function() { contenedor.innerHTML = ''; }, 3000);
        }*/
        if (metodo == 20) {
             var TelMovCli = document.getElementById("TelMovCli");
             var contenedor = document.getElementById("xcontainer");
             TelMovCli.select();
             try {
                 var successful = document.execCommand('copy');
                 if (successful) contenedor.innerHTML = '<span class="label label-success"><i class="fa fa-check-circle"></i> Copiado!</span>';
                 else contenedor.innerHTML = '<span class="label label-warning"><i class="fa fa-ban"></i> Incapaz de copiar!</span>';
             } catch (err) {
                 contenedor.innerHTML = '<span class="label label-danger"><i class="fa fa-ban"></i> Browser no soportado!</span>';
             }
             setTimeout(function() { contenedor.innerHTML = ''; }, 3000);
         }
         if (metodo == 21) {
             var EmaCliOpc = document.getElementById("EmaCliOpc");
             var contenedor = document.getElementById("xcontainer");
             EmaCliOpc.select();
             try {
                 var successful = document.execCommand('copy');
                 if (successful) contenedor.innerHTML = '<span class="label label-success"><i class="fa fa-check-circle"></i> Copiado!</span>';
                 else contenedor.innerHTML = '<span class="label label-warning"><i class="fa fa-ban"></i> Incapaz de copiar!</span>';
             } catch (err) {
                 contenedor.innerHTML = '<span class="label label-danger"><i class="fa fa-ban"></i> Browser no soportado!</span>';
             }
             setTimeout(function() { contenedor.innerHTML = ''; }, 3000);
         }
     }
     scope.copyTextArray = function(metodo, index) {
         if (metodo == 1) {
             var NomConCli = document.getElementById("NomConCli_" + index);
             var contenedor = document.getElementById("xcontainer");
             NomConCli.select();
             try {
                 var successful = document.execCommand('copy');
                 if (successful) contenedor.innerHTML = '<span class="label label-success"><i class="fa fa-check-circle"></i> Copiado!</span>';
                 else contenedor.innerHTML = '<span class="label label-warning"><i class="fa fa-ban"></i> Incapaz de copiar!</span>';
             } catch (err) {
                 contenedor.innerHTML = '<span class="label label-danger"><i class="fa fa-ban"></i> Browser no soportado!</span>';
             }
             setTimeout(function() { contenedor.innerHTML = ''; }, 3000);
         }
         if (metodo == 2) {
             var NIFConCli = document.getElementById("NIFConCli_" + index);
             var contenedor = document.getElementById("xcontainer");
             NIFConCli.select();
             try {
                 var successful = document.execCommand('copy');
                 if (successful) contenedor.innerHTML = '<span class="label label-success"><i class="fa fa-check-circle"></i> Copiado!</span>';
                 else contenedor.innerHTML = '<span class="label label-warning"><i class="fa fa-ban"></i> Incapaz de copiar!</span>';
             } catch (err) {
                 contenedor.innerHTML = '<span class="label label-danger"><i class="fa fa-ban"></i> Browser no soportado!</span>';
             }
             setTimeout(function() { contenedor.innerHTML = ''; }, 3000);
         }
         if (metodo == 3) {
             var CarConCli = document.getElementById("CarConCli_" + index);
             var contenedor = document.getElementById("xcontainer");
             CarConCli.select();
             try {
                 var successful = document.execCommand('copy');
                 if (successful) contenedor.innerHTML = '<span class="label label-success"><i class="fa fa-check-circle"></i> Copiado!</span>';
                 else contenedor.innerHTML = '<span class="label label-warning"><i class="fa fa-ban"></i> Incapaz de copiar!</span>';
             } catch (err) {
                 contenedor.innerHTML = '<span class="label label-danger"><i class="fa fa-ban"></i> Browser no soportado!</span>';
             }
             setTimeout(function() { contenedor.innerHTML = ''; }, 3000);
         }
         if (metodo == 4) {
             var TipRepr = document.getElementById("TipRepr_" + index);
             var contenedor = document.getElementById("xcontainer");
             TipRepr.select();
             try {
                 var successful = document.execCommand('copy');
                 if (successful) contenedor.innerHTML = '<span class="label label-success"><i class="fa fa-check-circle"></i> Copiado!</span>';
                 else contenedor.innerHTML = '<span class="label label-warning"><i class="fa fa-ban"></i> Incapaz de copiar!</span>';
             } catch (err) {
                 contenedor.innerHTML = '<span class="label label-danger"><i class="fa fa-ban"></i> Browser no soportado!</span>';
             }
             setTimeout(function() { contenedor.innerHTML = ''; }, 3000);
         }

         if (metodo == 5) {
             var CUPsEle = document.getElementById("CUPs_" + index);
             var contenedor = document.getElementById("xcontainer");
             CUPsEle.select();
             try {
                 var successful = document.execCommand('copy');
                 if (successful) contenedor.innerHTML = '<span class="label label-success"><i class="fa fa-check-circle"></i> Copiado!</span>';
                 else contenedor.innerHTML = '<span class="label label-warning"><i class="fa fa-ban"></i> Incapaz de copiar!</span>';
             } catch (err) {
                 contenedor.innerHTML = '<span class="label label-danger"><i class="fa fa-ban"></i> Browser no soportado!</span>';
             }
             setTimeout(function() { contenedor.innerHTML = ''; }, 3000);
         }
         if (metodo == 6) {
             var DirPunSum = document.getElementById("DirPunSum_" + index);
             var contenedor = document.getElementById("xcontainer");
             DirPunSum.select();
             try {
                 var successful = document.execCommand('copy');
                 if (successful) contenedor.innerHTML = '<span class="label label-success"><i class="fa fa-check-circle"></i> Copiado!</span>';
                 else contenedor.innerHTML = '<span class="label label-warning"><i class="fa fa-ban"></i> Incapaz de copiar!</span>';
             } catch (err) {
                 contenedor.innerHTML = '<span class="label label-danger"><i class="fa fa-ban"></i> Browser no soportado!</span>';
             }
             setTimeout(function() { contenedor.innerHTML = ''; }, 3000);
         }
         if (metodo == 7) {
             var TipServ = document.getElementById("TipServ_" + index);
             var contenedor = document.getElementById("xcontainer");
             TipServ.select();
             try {
                 var successful = document.execCommand('copy');
                 if (successful) contenedor.innerHTML = '<span class="label label-success"><i class="fa fa-check-circle"></i> Copiado!</span>';
                 else contenedor.innerHTML = '<span class="label label-warning"><i class="fa fa-ban"></i> Incapaz de copiar!</span>';
             } catch (err) {
                 contenedor.innerHTML = '<span class="label label-danger"><i class="fa fa-ban"></i> Browser no soportado!</span>';
             }
             setTimeout(function() { contenedor.innerHTML = ''; }, 3000);
         }
         if (metodo == 8) {
             var P1 = document.getElementById("P1_" + index);
             var contenedor = document.getElementById("xcontainer");
             P1.select();
             try {
                 var successful = document.execCommand('copy');
                 if (successful) contenedor.innerHTML = '<span class="label label-success"><i class="fa fa-check-circle"></i> Copiado!</span>';
                 else contenedor.innerHTML = '<span class="label label-warning"><i class="fa fa-ban"></i> Incapaz de copiar!</span>';
             } catch (err) {
                 contenedor.innerHTML = '<span class="label label-danger"><i class="fa fa-ban"></i> Browser no soportado!</span>';
             }
             setTimeout(function() { contenedor.innerHTML = ''; }, 3000);
         }
         if (metodo == 9) {
             var P2 = document.getElementById("P2_" + index);
             var contenedor = document.getElementById("xcontainer");
             P2.select();
             try {
                 var successful = document.execCommand('copy');
                 if (successful) contenedor.innerHTML = '<span class="label label-success"><i class="fa fa-check-circle"></i> Copiado!</span>';
                 else contenedor.innerHTML = '<span class="label label-warning"><i class="fa fa-ban"></i> Incapaz de copiar!</span>';
             } catch (err) {
                 contenedor.innerHTML = '<span class="label label-danger"><i class="fa fa-ban"></i> Browser no soportado!</span>';
             }
             setTimeout(function() { contenedor.innerHTML = ''; }, 3000);
         }
         if (metodo == 10) {
             var P3 = document.getElementById("P3_" + index);
             var contenedor = document.getElementById("xcontainer");
             P3.select();
             try {
                 var successful = document.execCommand('copy');
                 if (successful) contenedor.innerHTML = '<span class="label label-success"><i class="fa fa-check-circle"></i> Copiado!</span>';
                 else contenedor.innerHTML = '<span class="label label-warning"><i class="fa fa-ban"></i> Incapaz de copiar!</span>';
             } catch (err) {
                 contenedor.innerHTML = '<span class="label label-danger"><i class="fa fa-ban"></i> Browser no soportado!</span>';
             }
             setTimeout(function() { contenedor.innerHTML = ''; }, 3000);
         }
         if (metodo == 11) {
             var P4 = document.getElementById("P4_" + index);
             var contenedor = document.getElementById("xcontainer");
             P4.select();
             try {
                 var successful = document.execCommand('copy');
                 if (successful) contenedor.innerHTML = '<span class="label label-success"><i class="fa fa-check-circle"></i> Copiado!</span>';
                 else contenedor.innerHTML = '<span class="label label-warning"><i class="fa fa-ban"></i> Incapaz de copiar!</span>';
             } catch (err) {
                 contenedor.innerHTML = '<span class="label label-danger"><i class="fa fa-ban"></i> Browser no soportado!</span>';
             }
             setTimeout(function() { contenedor.innerHTML = ''; }, 3000);
         }
         if (metodo == 12) {
             var P5 = document.getElementById("P5_" + index);
             var contenedor = document.getElementById("xcontainer");
             P5.select();
             try {
                 var successful = document.execCommand('copy');
                 if (successful) contenedor.innerHTML = '<span class="label label-success"><i class="fa fa-check-circle"></i> Copiado!</span>';
                 else contenedor.innerHTML = '<span class="label label-warning"><i class="fa fa-ban"></i> Incapaz de copiar!</span>';
             } catch (err) {
                 contenedor.innerHTML = '<span class="label label-danger"><i class="fa fa-ban"></i> Browser no soportado!</span>';
             }
             setTimeout(function() { contenedor.innerHTML = ''; }, 3000);
         }
         if (metodo == 13) {
             var P6 = document.getElementById("P6_" + index);
             var contenedor = document.getElementById("xcontainer");
             P6.select();
             try {
                 var successful = document.execCommand('copy');
                 if (successful) contenedor.innerHTML = '<span class="label label-success"><i class="fa fa-check-circle"></i> Copiado!</span>';
                 else contenedor.innerHTML = '<span class="label label-warning"><i class="fa fa-ban"></i> Incapaz de copiar!</span>';
             } catch (err) {
                 contenedor.innerHTML = '<span class="label label-danger"><i class="fa fa-ban"></i> Browser no soportado!</span>';
             }
             setTimeout(function() { contenedor.innerHTML = ''; }, 3000);
         }
         if (metodo == 14) {
             var CUPs_Gas = document.getElementById("CUPs_Gas_" + index);
             var contenedor = document.getElementById("xcontainer");
             CUPs_Gas.select();
             try {
                 var successful = document.execCommand('copy');
                 if (successful) contenedor.innerHTML = '<span class="label label-success"><i class="fa fa-check-circle"></i> Copiado!</span>';
                 else contenedor.innerHTML = '<span class="label label-warning"><i class="fa fa-ban"></i> Incapaz de copiar!</span>';
             } catch (err) {
                 contenedor.innerHTML = '<span class="label label-danger"><i class="fa fa-ban"></i> Browser no soportado!</span>';
             }
             setTimeout(function() { contenedor.innerHTML = ''; }, 3000);
         }
         if (metodo == 15) {
             var RazSocDisGas = document.getElementById("RazSocDisGas_" + index);
             var contenedor = document.getElementById("xcontainer");
             RazSocDisGas.select();
             try {
                 var successful = document.execCommand('copy');
                 if (successful) contenedor.innerHTML = '<span class="label label-success"><i class="fa fa-check-circle"></i> Copiado!</span>';
                 else contenedor.innerHTML = '<span class="label label-warning"><i class="fa fa-ban"></i> Incapaz de copiar!</span>';
             } catch (err) {
                 contenedor.innerHTML = '<span class="label label-danger"><i class="fa fa-ban"></i> Browser no soportado!</span>';
             }
             setTimeout(function() { contenedor.innerHTML = ''; }, 3000);
         }
         if (metodo == 16) {
             var NomTarGas = document.getElementById("NomTarGas_" + index);
             var contenedor = document.getElementById("xcontainer");
             NomTarGas.select();
             try {
                 var successful = document.execCommand('copy');
                 if (successful) contenedor.innerHTML = '<span class="label label-success"><i class="fa fa-check-circle"></i> Copiado!</span>';
                 else contenedor.innerHTML = '<span class="label label-warning"><i class="fa fa-ban"></i> Incapaz de copiar!</span>';
             } catch (err) {
                 contenedor.innerHTML = '<span class="label label-danger"><i class="fa fa-ban"></i> Browser no soportado!</span>';
             }
             setTimeout(function() { contenedor.innerHTML = ''; }, 3000);
         }
         if (metodo == 17) {
             var NumIBan = document.getElementById("NumIBan_" + index);
             var contenedor = document.getElementById("xcontainer");
             NumIBan.select();
             try {
                 var successful = document.execCommand('copy');
                 if (successful) contenedor.innerHTML = '<span class="label label-success"><i class="fa fa-check-circle"></i> Copiado!</span>';
                 else contenedor.innerHTML = '<span class="label label-warning"><i class="fa fa-ban"></i> Incapaz de copiar!</span>';
             } catch (err) {
                 contenedor.innerHTML = '<span class="label label-danger"><i class="fa fa-ban"></i> Browser no soportado!</span>';
             }
             setTimeout(function() { contenedor.innerHTML = ''; }, 3000);
         }
         if (metodo == 18) {
             var DesBan = document.getElementById("DesBan_" + index);
             var contenedor = document.getElementById("xcontainer");
             DesBan.select();
             try {
                 var successful = document.execCommand('copy');
                 if (successful) contenedor.innerHTML = '<span class="label label-success"><i class="fa fa-check-circle"></i> Copiado!</span>';
                 else contenedor.innerHTML = '<span class="label label-warning"><i class="fa fa-ban"></i> Incapaz de copiar!</span>';
             } catch (err) {
                 contenedor.innerHTML = '<span class="label label-danger"><i class="fa fa-ban"></i> Browser no soportado!</span>';
             }
             setTimeout(function() { contenedor.innerHTML = ''; }, 3000);
         }
         if (metodo == 19) {
             var DesTipDoc = document.getElementById("DesTipDoc_" + index);
             var contenedor = document.getElementById("xcontainer");
             DesTipDoc.select();
             try {
                 var successful = document.execCommand('copy');
                 if (successful) contenedor.innerHTML = '<span class="label label-success"><i class="fa fa-check-circle"></i> Copiado!</span>';
                 else contenedor.innerHTML = '<span class="label label-warning"><i class="fa fa-ban"></i> Incapaz de copiar!</span>';
             } catch (err) {
                 contenedor.innerHTML = '<span class="label label-danger"><i class="fa fa-ban"></i> Browser no soportado!</span>';
             }
             setTimeout(function() { contenedor.innerHTML = ''; }, 3000);
         }
         if (metodo == 20) {
             var DesDoc = document.getElementById("DesDoc_" + index);
             var contenedor = document.getElementById("xcontainer");
             DesDoc.select();
             try {
                 var successful = document.execCommand('copy');
                 if (successful) contenedor.innerHTML = '<span class="label label-success"><i class="fa fa-check-circle"></i> Copiado!</span>';
                 else contenedor.innerHTML = '<span class="label label-warning"><i class="fa fa-ban"></i> Incapaz de copiar!</span>';
             } catch (err) {
                 contenedor.innerHTML = '<span class="label label-danger"><i class="fa fa-ban"></i> Browser no soportado!</span>';
             }
             setTimeout(function() { contenedor.innerHTML = ''; }, 3000);
         }



     }
     scope.VerDetallesCUPs=function(index,dato,TipServ)
     {
        console.log(index);
        console.log(dato);
        console.log(TipServ);
        scope.ContratosTCups=[];
        scope.CUpsNameModal=dato.CUPsName;
        scope.DirPunSumModal=dato.DirPunSum;
        scope.NomTarModal=dato.NomTar;
        scope.RazSocDisModal=dato.RazSocDis;
        scope.ModalTipServ=dato.TipServ;

        var mystring = "1,23,45,448.00";

            mystring = mystring.replace(/[,.]/g, function (m) {
       // m is the match found in the string
       // If `,` is matched return `.`, if `.` matched return `,`
        return m === ',' ? '.' : ',';
        });

        console.log(mystring);
        //document.write(mystring);     

        if(TipServ=='Eléctrico')
        {
            scope.PotConP1Modal=dato.PotConP1;
            scope.PotConP2Modal=dato.PotConP2;
            scope.PotConP3Modal=dato.PotConP3;
            scope.PotConP4Modal=dato.PotConP4;
            scope.PotConP5Modal=dato.PotConP5;
            scope.PotConP6Modal=dato.PotConP6;
            scope.CanPerTar=dato.CanPerTar;            
            scope.TipServ=1;
        }
        else
        {
            scope.PotConP1Modal=null;
            scope.PotConP2Modal=null;
            scope.PotConP3Modal=null;
            scope.PotConP4Modal=null;
            scope.PotConP5Modal=null;
            scope.PotConP6Modal=null;
            scope.CanPerTar=0;            
            scope.TipServ=2;
        }
        var url = base_urlHome()+"api/Dashboard/GetContratosElectricosGas/CodCups/"+dato.CodCups+"/CodCli/"+scope.fdatos.CodCli+"/TipCups/"+scope.TipServ;
            $http.get(url).then(function(result)
            {
                if(result.data!=false)
                {
                    
                        $scope.predicate1 = 'id';
                        $scope.reverse1 = true;
                        $scope.currentPage1 = 1;
                        $scope.order1 = function(predicate1) {
                            $scope.reverse1 = ($scope.predicate1 === predicate1) ? !$scope.reverse1 : false;
                            $scope.predicate1 = predicate1;
                        };            
                        scope.ContratosTCups=result.data;
                        $scope.totalItems1 = scope.ContratosTCups.length;
                        $scope.numPerPage1 = 50;
                        $scope.paginate1 = function(value1) {
                            var begin1, end1, index1;
                            begin1= ($scope.currentPage1 - 1) * $scope.numPerPage1;
                            end1 = begin1 + $scope.numPerPage1;
                            index1 = scope.ContratosTCups.indexOf(value1);
                            return (begin1 <= index1 && index1< end1);
                        }
                }
                else
                {
                    scope.toast('info','No se encontraron contratos asignados a este CUPs','Contratos');
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
        $('#modal_detalles_CUPs').modal('show');
     }
     //scope.load_customers();

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
        ///////////////////////////////////////////////// PARA EL DASHBOARD END ////////////////////////////////////////////////////////
 }