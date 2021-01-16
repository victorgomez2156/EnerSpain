 app.controller('Controlador_Dashbord', ['$http', '$scope', '$filter', '$route', '$interval', '$controller', '$cookies', '$compile','ServiceAddClientes', Controlador]);

 function Controlador($http, $scope, $filter, $route, $interval, $controller, $cookies, $compile,ServiceAddClientes) {
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
     scope.tContacto_data_modal={};
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
   scope.fetchClientes = function() 
   {
        //console.log(scope.searchText);
        var searchText_len = scope.searchText.trim().length;
        //console.log(searchText_len);             
        scope.fdatos.searchText = scope.searchText;
        scope.response_customer.CUPs_Electrico = [];
        scope.response_customer.CUPs_Gas = [];
        //console.log(scope.response_customer.CUPs_Electrico);
        //console.log(scope.response_customer.CUPs_Gas);
        if (searchText_len > 0) 
        {
            console.log(scope.fdatos);
            var url = base_urlHome() + "api/Dashboard/getclientes";
            $http.post(url, scope.fdatos).then(function(result) {
                //console.log(result);
                if (result.data != false) {
                    scope.searchResult = result.data;
                    //console.log(scope.searchResult);
                }else {
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
         //console.log(index);
         //console.log($event);
         //console.log(result);

         scope.response_customer.CUPs_Electrico = [];
         scope.response_customer.CUPs_Gas = [];
         //console.log(scope.searchResult[index].CodCli);
         scope.fdatos.CodCli = scope.searchResult[index].CodCli;
         scope.searchText=scope.searchResult[index].CodCli+" - "+scope.searchResult[index].NumCifCli;
         scope.searchResult = {};
         $event.stopPropagation();
         scope.view_information();
     }
     scope.searchboxClicked = function($event) {
       $event.stopPropagation();
   }
   scope.containerClicked = function() 
   {
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
               scope.response_customer.DomSoc = result.data.customer.NomViaDomSoc+" "+result.data.customer.NumViaDomSoc;
               scope.response_customer.EscPlaPuerSoc = result.data.customer.EscDomSoc + " " + result.data.customer.PlaDomSoc + " " + result.data.customer.PueDomSoc;
               scope.response_customer.DesSoc = result.data.customer.DesLocSoc;
               scope.response_customer.ProSoc = result.data.customer.DesProSoc;
               scope.response_customer.LocSoc = result.data.customer.CPLocSoc;

               scope.response_customer.CodPro = result.data.customer.CodPro;
               scope.response_customer.CodProFis = result.data.customer.CodProFis;
               scope.response_customer.DomFis = result.data.customer.NomViaDomFis+" "+result.data.customer.NumViaDomFis;
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

                        ,TipServ:CUPs_Electricos.TipServ,CodCups:CUPs_Electricos.CodCupsEle,TipServLetra:'Eléctrico'
                    });

                });
            }
            if(result.data.CUPs_Gas.length>0)
            {
                angular.forEach(result.data.CUPs_Gas, function(CUPs_Gas)
                {
                    scope.response_customer.All_CUPs.push({CUPsName:CUPs_Gas.CupsGas,DirPunSum:CUPs_Gas.DirPumSum+" "+CUPs_Gas.CPLocSoc+" "+CUPs_Gas.EscPlaPue
                        ,NomTar:CUPs_Gas.NomTarGas,RazSocDis:CUPs_Gas.RazSocDis
                        ,TipServ:CUPs_Gas.TipServ,CodCups:CUPs_Gas.CodCupGas,TipServLetra:'Gas'
                    });



                });
            }
                //console.log(scope.response_customer.All_CUPs);

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
                             scope.response_customer.documentos.push({ ArcDoc: Contactos.DocNIF, DesDoc: Fichero_Final, DesTipDoc: Contactos.TipRepr, CodTipDoc: null });
                         }
                     });
               }
               console.log(scope.response_customer.documentos);
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
             scope.response_customer.CUPs_Electrico = result.data.CUPs_Electricos;
             scope.response_customer.CUPs_Gas = result.data.CUPs_Gas;

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

        //console.log(mystring);
        //document.write(mystring);     

        if(TipServ=="E")
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
     






































/////////////////////////////////////////////////////////////// PARA AGREGAR DATOS EN EL MODALES DASHBOARD START //////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////








/////////////////////////////////////////////////////////////// PARA editar DATOS EN LOS MODALES DASHBOARD START //////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////














/////////////////////////////////////////////////////////////// PARA editar DATOS EN LOS MODALES DASHBOARD END //////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
scope.agregar_datos_dashboard=function(metodo)
{
        if(metodo==1)
        {
            scope.tListaRepre = [{ id: 1, DesTipRepr: 'INDEPENDIENTE' }, { id: 2, DesTipRepr: 'MANCOMUNADA' }];     
            scope.tContacto_data_modal={};
            scope.tContacto_data_modal.CodCli=scope.response_customer.CodCli;
            scope.tContacto_data_modal.TipRepr='1';
            scope.tContacto_data_modal.ConPrin=false;
            scope.tContacto_data_modal.CanMinRep='1';
            document.getElementById('filenameDocNIF').value = '';
            document.getElementById('DocPod').value = '';
            var namefileDocNIF = '';
            $('#filenameDocNIF1').html(namefileDocNIF);
            var filenameDocPod = '';
            $('#filenameDocPod').html(filenameDocPod);
            scope.cargar_tiposContactos(9);
            scope.cargar_tiposContactos(3);
            scope.cargar_tiposContactos(12);
            scope.DirCliente();
            $('#modal_agregarContactos').modal('show');  
        }
        else if(metodo==2)
        {
          scope.fdatos_cups={};
          scope.fdatos_cups.TipServ = 0;
          scope.fdatos_cups.CodCli=scope.response_customer.CodCli;
          scope.fdatos_cups.cups='ES';
          scope.T_PuntoSuministrosVistaNuevaDireccion=false;
          scope.fdatos_cups.AgregarNueva=true;
          scope.fdatos_cups.TipRegDir='1';
          scope.search_PunSum();
          $('#modal_agregarCUPs').modal('show');  
        }
        else if(metodo==3)
        {
            scope.tgribBancos={};
            scope.tgribBancos.CodCli=scope.response_customer.CodCli;
            scope.CodEur='ES';
            $('#modal_agregarCuentasBancarias').modal('show');  
        }
        else if(metodo==4)
        {
          scope.cargar_tiposContactos(11);
          scope.fagregar_documentos={};
          scope.fagregar_documentos.CodCli=scope.response_customer.CodCli;
          scope.fagregar_documentos.TieVen=0;
          scope.FecVenDocAco=null;
          document.getElementById('DocCliDoc').value = '';
          var filenameDocCli = '';
          $('#filenameDocCli').html(filenameDocCli);
          $('#modal_agregarDocumentos').modal('show');  
        }
        else if(metodo==5)
        {
           scope.tModalDatosClientes={};
           scope.index = 0;
           scope.tProvidencias = [];
           scope.tTipoCliente = [];
           scope.tLocalidades = [];
           scope.tComerciales = [];
           scope.tSectores = [];
           scope.tColaboradores = [];
           scope.tTiposVias = [];
           scope.TtiposInmuebles = [];
           scope.tModalDatosClientes.misma_razon = false;
           scope.tModalDatosClientes.distinto_a_social = false;
           scope.tModalDatosClientes.CodCli=undefined;
           scope.validate_cif=false;
           scope.validate_info==undefined;
           ServiceAddClientes.getAll().then(function(dato) {
           scope.Fecha_Server = dato.Fecha_Server;         
           scope.FecIniCli = dato.Fecha_Server;
           scope.tProvidencias = dato.Provincias;
           scope.tTipoCliente = dato.Tipo_Cliente;
           scope.tComerciales = dato.Comerciales;
           scope.tSectores = dato.Sector_Cliente;
           scope.tColaboradores = dato.Colaborador;
           scope.tTiposVias = dato.Tipo_Vias;
       }).catch(function(err) { console.log(err); });
          $('#modal_agregarNuevoCliente').modal('show');  
        }
        else
        {

        }
}
scope.EditarDatosModal=function(variable,metodo)
{
    if(metodo==1)
    {
        ServiceAddClientes.getAll().then(function(dato) 
        {
	         scope.Fecha_Server = dato.Fecha_Server;         
	         scope.FecIniCli = dato.Fecha_Server;
	         scope.tProvidencias = dato.Provincias;
	         scope.tTipoCliente = dato.Tipo_Cliente;
	         scope.tComerciales = dato.Comerciales;
	         scope.tSectores = dato.Sector_Cliente;
	         scope.tColaboradores = dato.Colaborador;
	         scope.tTiposVias = dato.Tipo_Vias;
      	}).catch(function(err) { console.log(err); });
             
    }
    else if(metodo==2)
    {
        scope.tModalDatosClientes= {};
        scope.tContacto_data_modal={};
        scope.tContacto_data_modal.CodCli=scope.response_customer.CodCli;
        scope.tListaRepre = [{ id: 1, DesTipRepr: 'INDEPENDIENTE' }, { id: 2, DesTipRepr: 'MANCOMUNADA' }];
        document.getElementById('filenameDocNIF').value = '';
        document.getElementById('DocPod').value = '';
        var namefileDocNIF = '';
        $('#filenameDocNIF1').html(namefileDocNIF);
        var filenameDocPod = '';
        $('#filenameDocPod').html(filenameDocPod);
        scope.cargar_tiposContactos(9);
        scope.cargar_tiposContactos(3);
        scope.cargar_tiposContactos(12);
        scope.tModalDatosClientes.distinto_a_social= false;        
        $('#modal_agregarContactos').modal('show');
    }
    scope.FuncionEditarDatos(variable,metodo); 
    
}

scope.FuncionEditarDatos=function(CodBuscar,metodo)
{
    var url=base_urlHome()+"api/Dashboard/BuscarPorCodEditar/CodBuscar/"+CodBuscar+"/metodo/"+metodo;
    $http.get(url).then(function(result)
    {
      if(result.data!=false)
      {
        if(metodo==1)
        {
            scope.tModalDatosClientes=result.data;
            scope.FecIniCli = undefined;
                 if (result.data.CodLocSoc == result.data.CodLocFis) {
                    scope.tModalDatosClientes.distinto_a_social = false;
                    scope.BuscarLocalidad(1,result.data.CodProSoc);
                    scope.BuscarLocalidad(2,result.data.CodProFis);

                 } else {
                     scope.tModalDatosClientes.distinto_a_social = true;
                     scope.BuscarLocalidad(1,result.data.CodProSoc);
                     scope.BuscarLocalidad(2,result.data.CodProFis);
                 }
                scope.tModalDatosClientes.CodLocSoc=result.data.CodLocSoc;
                scope.tModalDatosClientes.CodLocFis=result.data.CodLocFis;
                 if (result.data.RazSocCli == result.data.NomComCli) {
                     scope.tModalDatosClientes.misma_razon = false;
                 } else {
                     scope.tModalDatosClientes.misma_razon = true;
                 }
                 scope.FecIniCli = result.data.FecIniCli;
                 $('.datepicker').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", scope.FecIniCli);
                $('#modal_agregarNuevoCliente').modal('show');
        }
        else if(metodo==2)
        { 
          scope.tContacto_data_modal=result.data;
          scope.CodCliContacto=result.data.NumCifCli;  
          if(result.data.ConPrin==null ||result.data.ConPrin==0)
          {
            scope.tContacto_data_modal.ConPrin=false;
          }
          else
          {
            scope.tContacto_data_modal.ConPrin=true;
          }
          scope.DirCliente();
        }
      }
      else
      {
         scope.toast('error','Disculpe, error en el procedimiento intente nuevamente','Error');
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



////////////////////////////////////////////////////// PARA AGREGAR CLIENTES DESDE DASHBOARD START ///////////////////////////////////////////////////////////
scope.asignar_a_nombre_comercial = function() {
         scope.tModalDatosClientes.NomComCli = scope.tModalDatosClientes.RazSocCli;
     }
scope.misma_razon = function(opcion) {
         if (opcion == true) {
             scope.tModalDatosClientes.NomComCli = undefined;
         } else {
             scope.tModalDatosClientes.NomComCli = scope.tModalDatosClientes.RazSocCli;
         }
     }
     scope.asignar_tipo_via = function() {
         if (scope.tModalDatosClientes.distinto_a_social == false) {
             scope.tModalDatosClientes.CodTipViaFis = scope.tModalDatosClientes.CodTipViaSoc;
         }
     }
     scope.asignar_domicilio = function() {
         if (scope.tModalDatosClientes.distinto_a_social == false) {
             scope.tModalDatosClientes.NomViaDomFis = scope.tModalDatosClientes.NomViaDomSoc;
         }
     }
     scope.asignar_num_domicilio = function(object) {
         console.log(object);
         if (scope.tModalDatosClientes.distinto_a_social == false) 
         {
            /*if (object != undefined) {
                 numero = object;
                 if (!/^([0-9])*$/.test(numero))
                     scope.fdatos.NumViaDomSoc = numero.substring(0, numero.length - 1);
            }*/
             scope.tModalDatosClientes.NumViaDomFis = scope.tModalDatosClientes.NumViaDomSoc;
         }
     }
     scope.asignar_bloq_domicilio = function() {
         if (scope.tModalDatosClientes.distinto_a_social == false) {
             scope.tModalDatosClientes.BloDomFis = scope.tModalDatosClientes.BloDomSoc;
         }
     }
     scope.asignar_esc_domicilio = function() {
         if (scope.tModalDatosClientes.distinto_a_social == false) {
             scope.tModalDatosClientes.EscDomFis = scope.tModalDatosClientes.EscDomSoc;
         }
     }
     scope.asignar_pla_domicilio = function() {
         if (scope.tModalDatosClientes.distinto_a_social == false) {
             scope.tModalDatosClientes.PlaDomFis = scope.tModalDatosClientes.PlaDomSoc;
         }
     }
     scope.asignar_puer_domicilio = function() {
         if (scope.tModalDatosClientes.distinto_a_social == false) {
             scope.tModalDatosClientes.PueDomFis = scope.tModalDatosClientes.PueDomSoc;
         }
     }
     scope.asignar_CPLoc = function()
     {
        if (scope.tModalDatosClientes.distinto_a_social == false) {
             scope.tModalDatosClientes.CPLocFis = scope.tModalDatosClientes.CPLocSoc;
        }
        scope.LocalidadCodigoPostal(1);
     }
     scope.distinto_a_social = function() 
     {
         
         if (scope.tModalDatosClientes.distinto_a_social == true) {
             scope.tModalDatosClientes.CodTipViaFis = undefined;
             scope.tModalDatosClientes.NomViaDomFis = undefined;
             scope.tModalDatosClientes.NumViaDomFis = undefined;
             scope.tModalDatosClientes.BloDomFis = undefined;
             scope.tModalDatosClientes.EscDomFis = undefined;
             scope.tModalDatosClientes.PlaDomFis = undefined;
             scope.tModalDatosClientes.PueDomFis = undefined;
             scope.tModalDatosClientes.CodProFis = undefined;
             scope.tModalDatosClientes.CodLocFis = undefined;
             scope.tModalDatosClientes.CPLocFis = undefined;
             scope.TLocalidadesfiltradaFisc = [];
         } else {
             scope.tModalDatosClientes.CodTipViaFis = scope.tModalDatosClientes.CodTipViaSoc;
             scope.tModalDatosClientes.NomViaDomFis = scope.tModalDatosClientes.NomViaDomSoc;
             scope.tModalDatosClientes.NumViaDomFis = scope.tModalDatosClientes.NumViaDomSoc;
             scope.tModalDatosClientes.BloDomFis = scope.tModalDatosClientes.BloDomSoc;
             scope.tModalDatosClientes.EscDomFis = scope.tModalDatosClientes.EscDomSoc;
             scope.tModalDatosClientes.PlaDomFis = scope.tModalDatosClientes.PlaDomSoc;
             scope.tModalDatosClientes.PueDomFis = scope.tModalDatosClientes.PueDomSoc;
             scope.tModalDatosClientes.CodProFis = scope.tModalDatosClientes.CodProSoc;
             scope.tModalDatosClientes.CodLocFis = scope.tModalDatosClientes.CodLocSoc;
             scope.tModalDatosClientes.CPLocFis = scope.tModalDatosClientes.CPLocSoc;
             scope.TLocalidadesfiltradaFisc = scope.TLocalidadesfiltrada;
             //scope.filtrarLocalidadFisc();
         }
     }
     scope.asignar_LocalidadFis = function() {
         if (scope.tModalDatosClientes.distinto_a_social == false) {
             scope.tModalDatosClientes.CodLocFis = scope.tModalDatosClientes.CodLocSoc;
         }
     }
   
    scope.containerClickedCliente = function($event) {
       $event.stopPropagation();
   }
   scope.searchboxClickedCliente = function() 
   {
       scope.searchResultCPLocModal = {};
   }
   $scope.submitForm = function(event) {
         console.log(scope.tModalDatosClientes);
         if (scope.nID > 0 && scope.Nivel == 3) {
             scope.toast('error','No tiene permisos para realizar esta operación','Usuario no Autorizado');
             return false;
         }
         if (!scope.validarNIFDNIClienteDashboard()) {
               return false;
           }
         if (!scope.validar_campos_datos_basicos()) {
             return false;
         }

         if (scope.tModalDatosClientes.CodCli > 0) {
             var title = 'Actualizando';
             var text = '¿Seguro que desea modificar la información del Cliente?';
             var response = "Cliente actualizado de forma correcta";
         }
         if (scope.tModalDatosClientes.CodCli == undefined) {
             var title = 'Guardando';
             var text = '¿Seguro que desea registrar el Cliente?';
             var response = "Cliente creado de forma correcta";
         }
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
     scope.validar_campos_datos_basicos = function() 
     {
         resultado = true;         
         if (scope.tModalDatosClientes.NumCifCli == null || scope.tModalDatosClientes.NumCifCli == undefined || scope.tModalDatosClientes.NumCifCli == '') {
             scope.toast('error','El número de DNI/NIE/CIF es requerido','');
             return false;
         }
         var FecIniCli1 = document.getElementById("FecIniCli").value;
         scope.FecIniCli = FecIniCli1;
         if (scope.FecIniCli == null || scope.FecIniCli == undefined || scope.FecIniCli == '') {
             scope.toast('error','La Fecha de Inicio es requerida','');
             return false;
         } else {
             var FecIniCli = (scope.FecIniCli).split("/");
             if (FecIniCli.length < 3) {
                 scope.toast('error','El formato de Fecha de Inicio correcto es DD/MM/YYYY','');
                 event.preventDefault();
                 return false;
             } else {
                 if (FecIniCli[0].length > 2 || FecIniCli[0].length < 2) {
                     scope.toast('error','Error en Día, debe introducir dos números','');
                     event.preventDefault();
                     return false;
                 }
                 if (FecIniCli[1].length > 2 || FecIniCli[1].length < 2) {
                     scope.toast('error','Error en Mes, debe introducir dos números','');
                     event.preventDefault();
                     return false;
                 }
                 if (FecIniCli[2].length < 4 || FecIniCli[2].length > 4) {
                     scope.toast('error','Error en Año, debe introducir cuatro números','');
                     event.preventDefault();
                     return false;
                 }
                 valuesStart = scope.FecIniCli.split("/");
                 valuesEnd = scope.Fecha_Server.split("/");
                 // Verificamos que la fecha no sea posterior a la actual
                 var dateStart = new Date(valuesStart[2], (valuesStart[1] - 1), valuesStart[0]);
                 var dateEnd = new Date(valuesEnd[2], (valuesEnd[1] - 1), valuesEnd[0]);
                 if (dateStart > dateEnd) {
                     scope.toast('error',"La Fecha de Inicio no puede ser mayor al " + scope.Fecha_Server + " Verifique e intente nuevamente",'');
                     return false;
                 }
                 scope.tModalDatosClientes.FecIniCli = FecIniCli[2] + "-" + FecIniCli[1] + "-" + FecIniCli[0];
             }
         }
         if (scope.tModalDatosClientes.RazSocCli == null || scope.tModalDatosClientes.RazSocCli == undefined || scope.tModalDatosClientes.RazSocCli == '') {
             scope.toast('error','La Razón Social del Cliente es requerida','');
             return false;
         }
         if (scope.tModalDatosClientes.NomComCli == null || scope.tModalDatosClientes.NomComCli == undefined || scope.tModalDatosClientes.NomComCli == '') {
             scope.toast('error','El Nombre Comercial del Cliente es requerido','');
             return false;
         }
         if (!scope.tModalDatosClientes.CodTipCli > 0) {
             scope.toast('error','Seleccione un Tipo de Cliente','');
             return false;
         }
         if (!scope.tModalDatosClientes.CodSecCli > 0) 
         {
            scope.tModalDatosClientes.CodSecCli=null;             
         }
         else
         {
            scope.tModalDatosClientes.CodSecCli=scope.tModalDatosClientes.CodSecCli;
         }

         if (!scope.tModalDatosClientes.CodTipViaSoc > 0) {
             scope.toast('error','Seleccione un Tipo de Vía para el Domicilio Social','');
             return false;
         }
         if (scope.tModalDatosClientes.NomViaDomSoc == null || scope.tModalDatosClientes.NomViaDomSoc == undefined || scope.tModalDatosClientes.NomViaDomSoc == '') {
             scope.toast('error','El Nombre de la Vía es requerido','');
             return false;
         }
         if (scope.tModalDatosClientes.NumViaDomSoc == null || scope.tModalDatosClientes.NumViaDomSoc == undefined || scope.tModalDatosClientes.NumViaDomSoc == '') {
             scope.toast('error','El Número de la Vía es requerido','');
             return false;
         }
         if (!scope.tModalDatosClientes.CodProSoc > 0) {
             scope.toast('error','Seleccione una Provincia para el Domicilio Social','');
             return false;
         }
         if (!scope.tModalDatosClientes.CodLocSoc > 0) {
             scope.toast('error','Seleccione una Localidad para el Domicilio Social','');
             return false;
         }
         if (scope.tModalDatosClientes.distinto_a_social == true) {
             if (!scope.tModalDatosClientes.CodTipViaFis > 0) {
                 scope.toast('error','Seleccione un Tipo de Vía para el Domicilio Fiscal','');
                 return false;
             }
             if (scope.tModalDatosClientes.NomViaDomFis == null || scope.tModalDatosClientes.NomViaDomFis == undefined || scope.tModalDatosClientes.NomViaDomFis == '') {
                 scope.toast('error','El Nombre del Domicilio Fiscal del Cliente es obligatorio','');
                 
                 return false;
             }
             if (scope.tModalDatosClientes.NumViaDomFis == null || scope.tModalDatosClientes.NumViaDomFis == undefined || scope.tModalDatosClientes.NumViaDomFis == '') {
                 scope.toast('error','El Número del Domicilio Fiscal del Cliente es requerido','');
                 return false;
             }
             if (!scope.tModalDatosClientes.CodProFis > 0) {
                 scope.toast('error','Seleccione una Provincia para el Domicilio Fiscal','');
                 return false;
             }
             if (!scope.tModalDatosClientes.CodLocFis > 0) {
                 scope.toast('error','Seleccione una Localidad para el Domicilio Fiscal','');
                 return false;
             }
         }
         if (scope.tModalDatosClientes.TelFijCli == null || scope.tModalDatosClientes.TelFijCli == undefined || scope.tModalDatosClientes.TelFijCli == '') {
             /*scope.toast('error','El Número de Teléfono Fijo es requerido','');
             return false;*/
             scope.tModalDatosClientes.TelFijCli = null;
         }
         else
         {
            scope.tModalDatosClientes.TelFijCli = scope.tModalDatosClientes.TelFijCli;
         }
         if (scope.tModalDatosClientes.TelMovCli == null || scope.tModalDatosClientes.TelMovCli == undefined || scope.tModalDatosClientes.TelMovCli == '') {
             scope.tModalDatosClientes.TelMovCli=null;
         }
         else
         {
            scope.tModalDatosClientes.TelMovCli=scope.tModalDatosClientes.TelMovCli;
         }
         if (scope.tModalDatosClientes.EmaCli == null || scope.tModalDatosClientes.EmaCli == undefined || scope.tModalDatosClientes.EmaCli == '') {
             scope.toast('error','El Correo Electrónico es requerido','');
             return false;
         }
         if (scope.tModalDatosClientes.EmaCliOpc == null || scope.tModalDatosClientes.EmaCliOpc == undefined || scope.tModalDatosClientes.EmaCliOpc == '') {
             scope.tModalDatosClientes.EmaCliOpc=null;
         }
         else
         {
            scope.tModalDatosClientes.EmaCliOpc=scope.tModalDatosClientes.EmaCliOpc;
         }

         if (!scope.tModalDatosClientes.CodCom > 0) {
             scope.tModalDatosClientes.CodCom=null;
         }
         else
         {
            scope.tModalDatosClientes.CodCom=scope.tModalDatosClientes.CodCom;
         }
         if (scope.tModalDatosClientes.BloDomSoc == undefined || scope.tModalDatosClientes.BloDomSoc == null || scope.tModalDatosClientes.BloDomSoc == '') {
             scope.tModalDatosClientes.BloDomSoc = null;
         } else {
             scope.tModalDatosClientes.BloDomSoc = scope.tModalDatosClientes.BloDomSoc;
         }
         if (scope.tModalDatosClientes.EscDomSoc == undefined || scope.tModalDatosClientes.EscDomSoc == null || scope.tModalDatosClientes.EscDomSoc == '') {
             scope.tModalDatosClientes.EscDomSoc = null;
         } else {
             scope.tModalDatosClientes.EscDomSoc = scope.tModalDatosClientes.EscDomSoc;
         }
         if (scope.tModalDatosClientes.PlaDomSoc == undefined || scope.tModalDatosClientes.PlaDomSoc == null || scope.tModalDatosClientes.PlaDomSoc == '') {
             scope.tModalDatosClientes.PlaDomSoc = null;
         } else {
             scope.tModalDatosClientes.PlaDomSoc = scope.tModalDatosClientes.PlaDomSoc;
         }
         if (scope.tModalDatosClientes.PueDomSoc == undefined || scope.tModalDatosClientes.PueDomSoc == null || scope.tModalDatosClientes.PueDomSoc == '') {
             scope.tModalDatosClientes.PueDomSoc = null;
         } else {
             scope.tModalDatosClientes.PueDomSoc = scope.tModalDatosClientes.PueDomSoc;
         }
         if (scope.tModalDatosClientes.BloDomFis == undefined || scope.tModalDatosClientes.BloDomFis == null || scope.tModalDatosClientes.BloDomFis == '') {
             scope.tModalDatosClientes.BloDomFis = null;
         } else {
             scope.tModalDatosClientes.BloDomFis = scope.tModalDatosClientes.BloDomFis;
         }
         if (scope.tModalDatosClientes.EscDomFis == undefined || scope.tModalDatosClientes.EscDomFis == null || scope.tModalDatosClientes.EscDomFis == '') {
             scope.tModalDatosClientes.EscDomFis = null;
         } else {
             scope.tModalDatosClientes.EscDomFis = scope.tModalDatosClientes.EscDomFis;
         }
         if (scope.tModalDatosClientes.PlaDomFis == undefined || scope.tModalDatosClientes.PlaDomFis == null || scope.tModalDatosClientes.PlaDomFis == '') {
             scope.tModalDatosClientes.PlaDomFis = null;
         } else {
             scope.tModalDatosClientes.PlaDomFis = scope.tModalDatosClientes.PlaDomFis;
         }
         if (scope.tModalDatosClientes.PueDomFis == undefined || scope.tModalDatosClientes.PueDomFis == null || scope.tModalDatosClientes.PueDomFis == '') {
             scope.tModalDatosClientes.PueDomFis = null;
         } else {
             scope.tModalDatosClientes.PueDomFis = scope.tModalDatosClientes.PueDomFis;
         }
         if (scope.tModalDatosClientes.WebCli == undefined || scope.tModalDatosClientes.WebCli == null || scope.tModalDatosClientes.WebCli == '') {
             scope.tModalDatosClientes.WebCli = null;
         } else {
             scope.tModalDatosClientes.WebCli = scope.tModalDatosClientes.WebCli;
         }
         if (scope.tModalDatosClientes.ObsCli == undefined || scope.tModalDatosClientes.ObsCli == null || scope.tModalDatosClientes.ObsCli == '') {
             scope.tModalDatosClientes.ObsCli = null;
         } else {
             scope.tModalDatosClientes.ObsCli = scope.tModalDatosClientes.ObsCli;
         }
         if (scope.tModalDatosClientes.CodCol == undefined || scope.tModalDatosClientes.CodCol == null || scope.tModalDatosClientes.CodCol == '') {
             scope.tModalDatosClientes.CodCol = null;
         } else {
             scope.tModalDatosClientes.CodCol = scope.tModalDatosClientes.CodCol;
         }
         if (scope.tModalDatosClientes.CPLocSoc == undefined || scope.tModalDatosClientes.CPLocSoc == null || scope.tModalDatosClientes.CPLocSoc == '') {
             scope.tModalDatosClientes.CPLocSoc = null;
         } else {
             scope.tModalDatosClientes.CPLocSoc = scope.tModalDatosClientes.CPLocSoc;
         }
         if (scope.tModalDatosClientes.CPLocFis == undefined || scope.tModalDatosClientes.CPLocFis == null || scope.tModalDatosClientes.CPLocFis == '') {
             scope.tModalDatosClientes.CPLocFis = null;
         } else {
             scope.tModalDatosClientes.CPLocFis = scope.tModalDatosClientes.CPLocFis;
         }





         if (resultado == false) {
             //quiere decir que al menos un renglon no paso la validacion
             return false;
         }
         return true;
     }
     scope.guardar = function() {
         
         if (scope.tModalDatosClientes.CodCli > 0) {
             var title = 'Actualizando';
             var text = '¿Seguro que desea actualizar la información del Cliente?';
             var response = "El Cliente ha sido modificado de forma correcta";
         }
         if (scope.tModalDatosClientes.CodCli == undefined) {
             var title = 'Guardando';
             var text = '¿Seguro que desea crear el Cliente?';
             var response = "El Cliente ha sido registrado de forma correcta";
         }
         $("#" + title).removeClass("loader loader-default").addClass("loader loader-default is-active");
         var url = base_urlHome() + "api/Dashboard/crear_clientes/";
         $http.post(url, scope.tModalDatosClientes).then(function(result) 
         {
            console.log(result);
            $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
            if (result.data.status == false && result.data.response == false) {
                 scope.toast('error',result.data.message,'DNI/NIE/CIF');                 
                 scope.validate_cif = true;
                 //document.getElementById("NumCifCliRe").removeAttribute("readonly");
                 return false;
             }
            
             scope.nID = result.data.CodCli;
             if (scope.nID > 0) 
             {
                scope.toast('success',response,title);
                $('#modal_agregarNuevoCliente').modal('hide');
                scope.searchText=result.data.CodCli+" - "+result.data.RazSocCli;
                scope.fdatos.CodCli=result.data.CodCli;
                scope.view_information();                
             } else {
                 $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
                 scope.toast('error','Ha ocurrido un error, por favor intente nuevamente','Error');

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
     scope.validar_email = function(metodo) {
         
         if(metodo==1)
         {
            document.getElementById('EmaCli').addEventListener('input', function() {
             campo = event.target;
             valido = document.getElementById('emailOK');
             emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
             //Se muestra un texto a modo de ejemplo, luego va a ser un icono
             if (emailRegex.test(campo.value)) {
                 valido.innerText = "";
                 scope.disabled_button_by_email = false;
             } else {
                 valido.innerText = "Formato de Email incorrecto";
                 scope.disabled_button_by_email = true;
             }
            });
         }
         if(metodo==2)
         {
            document.getElementById('EmaCliOpc').addEventListener('input', function() {
             campo = event.target;
             valido = document.getElementById('emailOKOpc');
             emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
             //Se muestra un texto a modo de ejemplo, luego va a ser un icono
             if (emailRegex.test(campo.value)) {
                 valido.innerText = "";
                 scope.disabled_button_by_email = false;
             } else {
                 valido.innerText = "Formato de Email incorrecto";
                 scope.disabled_button_by_email = true;
             }
         });
         }
     }
     
///////////////////////////////////////////////////// PARA AGREGAR CLIENTES DESDE DASHBOARD END///////////////////////////////////////////////////////////
     



















     

    scope.LocalidadCodigoPostal=function(metodo)
    {
            if(metodo==1)
            { 
               var searchText_len = scope.tModalDatosClientes.CPLocSoc.trim().length;
               var url= base_urlHome()+"api/Clientes/LocalidadCodigoPostal/CPLoc/"+scope.tModalDatosClientes.CPLocSoc;
            }
            else if(metodo==2)
            {
              var searchText_len = scope.tModalDatosClientes.CPLocFis.trim().length;
              var url= base_urlHome()+"api/Clientes/LocalidadCodigoPostal/CPLoc/"+scope.tModalDatosClientes.CPLocFis;
            }
            else if(metodo==3)
            {
              var searchText_len = scope.tContacto_data_modal.CodProSoc.trim().length;
              var url= base_urlHome()+"api/Clientes/LocalidadCodigoPostal/CPLoc/"+scope.tContacto_data_modal.CodProSoc;
            }
        if (searchText_len >=3) 
        {
            $http.get(url).then(function(result) 
            {
                if (result.data != false) 
                {
                    if(metodo==1)
                    {
                        scope.searchResultCPLocModal = result.data;
                    }
                    else if(metodo==2)
                    {
                        scope.searchResultFis = result.data;
                    }
                    else if(metodo==3)
                    {
                        scope.searchResultCPLoc = result.data;
                    }
                } 
                else
                {                    
                    if(metodo==1)
                    {
                        scope.searchResult = {};
                        scope.toast('error','No se Encontraron Provincias & Localidades Registradas con este código postal','Error');
                        scope.tContacto_data_modal.CPLocSoc=null;
                    }
                    else if(metodo==2)
                    {
                        scope.searchResultFis = {};
                        scope.toast('error','No se Encontraron Provincias & Localidades Registradas con este código postal','Error');
                        scope.tContacto_data_modal.CPLocFis=null;
                    }
                    else if(metodo==3)
                    {
                        scope.searchResultCPLoc = {};
                        scope.toast('error','No se Encontraron Provincias & Localidades Registradas con este código postal','Error');
                        scope.tContacto_data_modal.CodProSoc=null;
                    }
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
        else 
        {
            scope.searchResult = {};
            scope.searchResultFis = {};
        }
    }
     scope.BuscarLocalidad=function(metodo,CodPro)
    {
        console.log(metodo);
        console.log(CodPro);
        var url = base_urlHome()+"api/Clientes/BuscarLocalidadAddClientes/metodo/"+metodo+"/CodPro/"+CodPro;        
        $http.get(url).then(function(result)
        {
            if(result.data!=false)
            {
                if(metodo==1)
                {
                    if (scope.tModalDatosClientes.distinto_a_social == false) 
                    {
                        scope.TLocalidadesfiltradaFisc=[];
                        scope.TLocalidadesfiltradaFisc=result.data;
                        scope.tModalDatosClientes.CodProFis = CodPro;                         
                    }
                    scope.TLocalidadesfiltrada=[];
                    scope.TLocalidadesfiltrada=result.data;
                }
                else if(metodo==2)
                {
                    scope.TLocalidadesfiltradaFisc=[];
                    scope.TLocalidadesfiltradaFisc=result.data;
                }
                else
                {

                }
            }
            else
            {
                if(metodo==1)
                {
                    scope.tModalDatosClientes.CodLocSoc=undefined;
                    scope.TLocalidadesfiltrada=[];
                    scope.toast('error','No se encontraron Localidades asignada a esta provincia.','Error');                    
                }
                else
                {
                    scope.tModalDatosClientes.CodLocFis=undefined;
                    scope.TLocalidadesfiltradaFisc=[];
                    scope.toast('error','No se encontraron Localidades asignada a esta provincia.','Error');                    
                }

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
 scope.DirCliente=function()
 {
    var url=base_urlHome()+"api/Dashboard/DirCliente/CodCli/"+scope.response_customer.CodCli;
    $http.get(url).then(function(result)
    {
        if(result.data!=false)
        {
            scope.tContacto_data_modal.CodTipViaSoc=result.data.CodTipViaSoc;
            scope.tContacto_data_modal.NomViaDomSoc=result.data.NomViaDomSoc;
            scope.tContacto_data_modal.NumViaDomSoc=result.data.NumViaDomSoc;
            scope.tContacto_data_modal.BloDomSoc=result.data.BloDomSoc;
            scope.tContacto_data_modal.EscDomSoc=result.data.EscDomSoc;
            scope.tContacto_data_modal.PlaDomSoc=result.data.PlaDomSoc;
            scope.tContacto_data_modal.PueDomSoc=result.data.PueDomSoc;
            scope.tContacto_data_modal.CPLocSoc=result.data.CPLocSoc;
            scope.BuscarLocalidad(1,result.data.CodProSoc);
            scope.tContacto_data_modal.CodProSoc=result.data.CodProSoc;
            scope.tContacto_data_modal.CodLocSoc=result.data.CodLocSoc;
        }
        else
        {
            scope.tContacto_data_modal.CodTipViaSoc=null;
            scope.tContacto_data_modal.NomViaDomSoc=null;
            scope.tContacto_data_modal.NumViaDomSoc=null;
            scope.tContacto_data_modal.BloDomSoc=null;
            scope.tContacto_data_modal.EscDomSoc=null;
            scope.tContacto_data_modal.PlaDomSoc=null;
            scope.tContacto_data_modal.PueDomSoc=null;
            scope.tContacto_data_modal.CPLocSoc=null;
            scope.tContacto_data_modal.CodProSoc=null;
            scope.tContacto_data_modal.CodLocSoc=null;
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
         scope.fetchClientesModal = function(metodo) 
        {
            if(metodo==1)
            {
                var searchText_len = scope.CodCliContacto.trim().length;
                scope.fdatos.searchText = scope.CodCliContacto;   
            }

            if (searchText_len > 0) 
            {
                console.log(scope.fdatos);
                var url = base_urlHome() + "api/Dashboard/getclientes";
                $http.post(url, scope.fdatos).then(function(result) {
                        //console.log(result);
                        if (result.data != false) {
                            if(metodo==1)
                            {
                                scope.searchResultContactos = result.data;
                            }

                        }else {
                            if(metodo==1)
                            {
                                scope.searchResultContactos = {};
                            }
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
                if(metodo==1)
                {
                    scope.searchResultContactos = {};
                }

            }
        }
         // Set value to search box
         scope.setValueModal = function(index, $event, result,metodo) 
         {
            if (metodo == 1) 
            {
            	scope.tModalDatosClientes.CodProSoc=scope.searchResultCPLocModal[index].CodPro;
                scope.BuscarLocalidad(1,scope.tModalDatosClientes.CodProSoc);
                scope.tModalDatosClientes.CodLocSoc=scope.searchResultCPLocModal[index].CodLoc;
                scope.tModalDatosClientes.CPLocSoc= scope.searchResultCPLocModal[index].CPLoc;           
                if (scope.tModalDatosClientes.distinto_a_social == false) 
                {
                    scope.tModalDatosClientes.CodProFis=scope.searchResultCPLocModal[index].CodPro;
                    scope.tModalDatosClientes.CodLocFis = scope.searchResultCPLocModal[index].CodLoc;
                    scope.tModalDatosClientes.CPLocFis=scope.searchResultCPLocModal[index].CPLoc;
                }
                scope.searchResultCPLocModal = {};
                $event.stopPropagation();
            }
        }
        scope.searchboxClickedModal = function($event) {
           $event.stopPropagation();
       }
       scope.containerClickedModal = function(metodo) {

           if(metodo==1)
           {
            scope.searchResultContactos = {};
        }

    }
    scope.setValueCPLoc = function(index, $event, result, metodo) 
    {
        if (metodo == 1) 
        {
            console.log(index);
            console.log($event);
            console.log(result);
            console.log(metodo);
            scope.tContacto_data_modal.CodProSoc=scope.searchResultCPLoc[index].CodPro;
            scope.BuscarLocalidad(1,scope.tContacto_data_modal.CodProSoc);
            scope.tContacto_data_modal.CodLocSoc=scope.searchResultCPLoc[index].CodLoc;
            scope.tContacto_data_modal.CPLocSoc= scope.searchResultCPLoc[index].CPLoc;
            scope.searchResultCPLoc = {};
            $event.stopPropagation();
        }
    }
    
    scope.ValidarNumCIFContacto=function()
    {
        if (!scope.validarNIFDNI())
        {
            return false;
        }
        var url = base_urlHome() + "api/Dashboard/comprobar_cif_contacto_Cliente/CodCli/"+scope.response_customer.CodCli+"/NIFConCli/"+scope.tContacto_data_modal.NIFConCli;
           $http.get(url).then(function(result) {
               $("#NIFConCli").removeClass("loader loader-default is-active").addClass("loader loader-default");
               if (result.data != false) 
               {
                   
                   if(result.data.status==202 && result.data.statusText=='Error')
                   {
                        scope.tContacto_data_modal.NIFConCli=null;
                        scope.toast('error',result.data.menssage,'Error');
                        return false;
                   }
                   if(result.data.status==200 && result.data.statusText=='OK'){
                        scope.tContacto_data_modal.CodTipCon=result.data.menssage.CodTipCon;
                        scope.tContacto_data_modal.CarConCli=result.data.menssage.CarConCli;
                        scope.tContacto_data_modal.NomConCli=result.data.menssage.NomConCli;
                        scope.tContacto_data_modal.NumColeCon=result.data.menssage.NumColeCon;
                        scope.tContacto_data_modal.TelFijConCli=result.data.menssage.TelFijConCli;
                        scope.tContacto_data_modal.TelCelConCli=result.data.menssage.TelCelConCli;
                        scope.tContacto_data_modal.EmaConCli=result.data.menssage.EmaConCli;
                        scope.tContacto_data_modal.EsRepLeg=result.data.menssage.EsRepLeg;
                        scope.tContacto_data_modal.TipRepr=result.data.menssage.TipRepr;
                        scope.tContacto_data_modal.CanMinRep=result.data.menssage.CanMinRep;
                        scope.tContacto_data_modal.TieFacEsc=result.data.menssage.TieFacEsc;
                        scope.tContacto_data_modal.DocNIF=result.data.menssage.DocNIF;
                        scope.tContacto_data_modal.DocPod=result.data.menssage.DocPod;
                        scope.tContacto_data_modal.ObsConC  =result.data.menssage.ObsConC;
                        return false;
                   }
                   if(result.data.status==201 && result.data.statusText=='OK'){
                        scope.tContacto_data_modal.CodTipCon=null;
                        scope.tContacto_data_modal.CarConCli=null;
                        scope.tContacto_data_modal.NomConCli=null;
                        scope.tContacto_data_modal.NumColeCon=null;
                        scope.tContacto_data_modal.TelFijConCli=null;
                        scope.tContacto_data_modal.TelCelConCli=null;
                        scope.tContacto_data_modal.EmaConCli=null;
                        scope.tContacto_data_modal.EsRepLeg=null;
                        scope.tContacto_data_modal.TipRepr='1';
                        scope.tContacto_data_modal.TieFacEsc=null;
                        scope.tContacto_data_modal.DocNIF=null;
                        scope.tContacto_data_modal.DocPod=null;
                        scope.tContacto_data_modal.ObsConC  =null;
                        scope.tContacto_data_modal.ConPrin=false;
                        scope.tContacto_data_modal.CanMinRep='1';
                        document.getElementById('filenameDocNIF').value = '';
                        document.getElementById('DocPod').value = '';
                        scope.cargar_tiposContactos(9);
                        scope.cargar_tiposContactos(3);
                        scope.cargar_tiposContactos(12);
                        scope.DirCliente();
                        return false;
                   }
               } else {
                   /*$("#modal_cif_cliente_contacto").modal('hide');
                   location.href = "#/Add_Contactos";
                   $cookies.put('CIF_Contacto', scope.tContacto_data_modal.NIFConCli);*/
               }
           }, function(error) {
               $("#NIFConCli").removeClass("loader loader-default").addClass("loader loader-default is-active");
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
        ///////// PARA CALCULAR DNI/NIE START /////////////////
    scope.validarNIFDNI = function() 
    {
           if($("#NIFConCli1").val().length<9 || $("#NIFConCli1").val().length>9)
           {
                scope.toast('error',"El Número de DNI/NIE debe contener solo 9 números.",'');
                return false;
           }
           var letter = scope.validar_dni_nie($("#NIFConCli1").parent(), $("#NIFConCli1").val());
           //console.log(letter[0]);
           if(letter[0].status==200&&letter[0].statusText=='OK'&&letter[0].menssage=="DNI")
           {
                console.log(letter[0].letter.toUpperCase());
                scope.dni_nie_validar = scope.tContacto_data_modal.NIFConCli.substring(0,8)+letter[0].letter.toUpperCase();
                if(scope.dni_nie_validar!=scope.tContacto_data_modal.NIFConCli)
                {
                scope.toast('error',"El Número de DNI/NIE es Invalido Intente Nuevamente.",'');
                return false;
                }
             else
             {
                return true;
            } 
            }
            else if(letter[0].status==200&&letter[0].statusText=='OK'&&letter[0].menssage=="CIF")
            {
                console.log(letter[0].letter.toUpperCase());
                scope.dni_nie_validar = scope.tContacto_data_modal.NIFConCli.substring(0,8)+letter[0].letter.toUpperCase();
                if(scope.dni_nie_validar!=scope.tContacto_data_modal.NIFConCli)
                {
                 	scope.toast('error',"El Número de CIF es Invalido Intente Nuevamente.",'');
                 	return false;
             	}
             else
             {
                return true;
            } 
            }
            else if(letter[0].status==200&&letter[0].statusText=='OK'&&letter[0].menssage=="No CIF/DNI")
            {
             return true;
            }
            else
            {
            scope.toast('error',"Error en Calculo de CIF/DNI/NIF/NIE.",'');
            return false;
            }  
    }
    scope.validarNIFDNIClienteDashboard = function() 
    {
           if($("#NumCifCliDashboard").val().length<9 || $("#NumCifCliDashboard").val().length>9)
           {
                scope.toast('error',"El Número de DNI/NIE debe contener solo 9 números.",'');
                return false;
           }
           var letter = scope.validar_dni_nie($("#NumCifCliDashboard").parent(), $("#NumCifCliDashboard").val());
           //console.log(letter[0]);
           if(letter[0].status==200&&letter[0].statusText=='OK'&&letter[0].menssage=="DNI")
           {
                console.log(letter[0].letter.toUpperCase());
                scope.dni_nie_validar = scope.tModalDatosClientes.NumCifCli.substring(0,8)+letter[0].letter.toUpperCase();
                if(scope.dni_nie_validar!=scope.tModalDatosClientes.NumCifCli)
                {
                scope.toast('error',"El Número de DNI/NIE es Invalido Intente Nuevamente.",'');
                return false;
                }
             else
             {
                return true;
            } 
            }
            else if(letter[0].status==200&&letter[0].statusText=='OK'&&letter[0].menssage=="CIF")
            {
                console.log(letter[0].letter.toUpperCase());
                scope.dni_nie_validar = scope.tModalDatosClientes.NumCifCli.substring(0,8)+letter[0].letter.toUpperCase();
                if(scope.dni_nie_validar!=scope.tModalDatosClientes.NumCifCli)
                {
                 	scope.toast('error',"El Número de CIF es Invalido Intente Nuevamente.",'');
                 	return false;
             	}
             else
             {
                return true;
            } 
            }
            else if(letter[0].status==200&&letter[0].statusText=='OK'&&letter[0].menssage=="No CIF/DNI")
            {
             return true;
            }
            else
            {
            scope.toast('error',"Error en Calculo de CIF/DNI/NIF/NIE.",'');
            return false;
            }  
    }
    function isNumeric(expression) 
    {
        return (String(expression).search(/^\d+$/) != -1);
    }
    function calculateLetterForDni(dni)
    {
        // Letras en funcion del modulo de 23
        string = "TRWAGMYFPDXBNJZSQVHLCKE"
        // se obtiene la posiciÃ³n de la cadena anterior
        position = dni % 23
        // se extrae dicha posiciÃ³n de la cadena
        letter = string.substring(position, position + 1)
        return letter
    }
    scope.validar_dni_nie=function(field, txt)
    {
        var letter = ""
        // Si es un dni extrangero, es decir, empieza por X, Y, Z
        // Si la longitud es 8 longitud total de los dni nacionales)
        if (txt.length == 9) 
        {
            //var text_ini=txt.toUpperCase();
            console.log(txt);
            var first = txt.substring(0, 1).toUpperCase();
            var last = txt.substring(8,9).toUpperCase();
            console.log(first);
            console.log(last);
            if (first == 'X' || first == 'Y' || first == 'Z') 
            {               
                // Si la longitud es 9(longitud total de los dni extrangeros)
                // Se calcula la letra para el numero de dni
                var number = txt.substring(1, 8);
                if (first == 'X') {
                    number = '0' + number
                    //final = first + number
                }
                if (first == 'Y') {
                    number = '1' + number
                    //final = first + number
                }
                if (first == 'Z') {
                    number = '2' + number
                    //final = first + number
                }
                if (isNumeric(number)){
                    letter = calculateLetterForDni(number)
                }
                var response = [{ status: 200, menssage: 'DNI',statusText:'OK',letter:letter}];               
                return response;
            }
            else if(first == 'A' || first == 'B' || first == 'C'||first == 'D' || first == 'E' || first == 'F'||first == 'G' || first == 'H' || first == 'J'||first == 'P' || first == 'Q' || first == 'R'||first == 'S' || first == 'U' || first == 'V'||first == 'N' || first == 'W')
            {
                var response = [{ status: 200, menssage: 'No CIF/DNI',statusText:'OK'}];               
                return response;
            } 
            else 
            {
                letter = calculateLetterForDni(txt.substring(0, 8))                
                var response = [{ status: 200, menssage: 'CIF',statusText:'OK',letter:letter}];               
                return response;
            }
        }
        else
        {
            return false
        }

    } 
    scope.cargar_tiposContactos=function(metodo)
    {
     var url = base_urlHome()+"api/Dashboard/RealizarConsultaFiltros/metodo/"+metodo;
     $http.get(url).then(function (result)
     {
        if(result.data)
        {
            if(metodo==9)
            {
                scope.tListaContactos=result.data;
            }
            else if(metodo==3)
            {
                scope.tProvidencias=result.data;
            }
            else if(metodo==11)
            {   
                scope.tListDocumentos=result.data;
            } 
            else if(metodo==12)
            {   
                scope.tTiposVias=result.data;
            }                                
        }
        else
        {
            if(metodo==9)
            {
                scope.tListaContactos=[];
            }
            else if(metodo==3)
            {
                scope.tProvidencias=[];
            }
            else if(metodo==11)
            {   
                scope.tListDocumentos=[];
            } 
            else if(metodo==12)
            {   
                scope.tTiposVias=[];
            } 
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
    $scope.SelectFile = function (e,metodo) 
    {
        scope.AddImagen(e.target.files[0],metodo);
    };
    scope.AddImagen = function(archivo,metodo)
    {
        console.log(archivo);
        console.log(metodo);
        if (archivo==null){
            $("#subiendo_archivo").removeClass( "loader loader-default is-active" ).addClass("loader loader-default");   
            scope.toast('error','Seleccione otro archivo','Error');
        }
        else
        { 
            $("#subiendo_archivo").removeClass("loader loader-default").addClass("loader loader-default is-active");
            formData = new FormData();
            formData.append('file', archivo);
            formData.append('x-api-key', $cookies.get('ApiKey'));
            formData.append('metodo', metodo);             
            $.ajax({
                url : base_urlHome()+"api/Dashboard/agregar_documento_dashboard/",
                type: "POST",
                data : formData,
                processData: false,
                contentType: false,
                async:false,
                success:function(data,textStatus,jqXHR)
                { 
                    console.log(data);
                    console.log(textStatus);
                    console.log(jqXHR);
                        $("#subiendo_archivo").removeClass( "loader loader-default is-active" ).addClass("loader loader-default")                          
                        if(data.metodo==1)
                        {
                            var namefileDocNIF = '<i class="fa fa-file"> '+data.file_name+'</i>';
                            $('#filenameDocNIF1').html(namefileDocNIF);
                            scope.tContacto_data_modal.DocNIF=data.DocNIF;
                            scope.toast('success','Archivo subido correctamente no actualice ni cierre la página hasta finalizar el proceso correctamente.','Archivo Cargado');
                        }
                        if(data.metodo==2)
                        {
                            var namefileDocPod = '<i class="fa fa-file"> '+data.file_name+'</i>';
                            $('#filenameDocPod').html(namefileDocPod);
                             scope.tContacto_data_modal.DocPod=data.DocNIF;
                            scope.toast('success','Archivo subido correctamente no actualice ni cierre la página hasta finalizar el proceso correctamente.','Archivo Cargado');
                        }
                        if(data.metodo==4)
                        {
                            var filenameDocCli = '<i class="fa fa-file"> '+data.file_name+'</i>';
                            $('#filenameDocCli').html(filenameDocCli);
                            scope.fagregar_documentos.ArcDoc =data.DocNIF;
                            scope.fagregar_documentos.DesDoc =data.file_name;
                            scope.toast('success','Archivo subido correctamente no actualice ni cierre la página hasta finalizar el proceso correctamente.','Archivo Cargado');
                        }
                      },              
                error: function(jqXHR, textStatus, errorThrown){
                        $("#subiendo_archivo").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );  
                        console.log(jqXHR);
                        console.log(textStatus);
                        scope.toast('error','Error Subiendo archivo.','Error');
                    }
            });
        }
            
    }
    scope.ComprobarContactoPrincipal=function(ConPri)
{
    if(ConPri==true && scope.tContacto_data_modal.CodCli!=undefined)
    {
        scope.tContacto_data_modal.ConPrin=false;
        $("#Principal").removeClass("loader loader-default").addClass("loader loader-default is-active");
        var url = base_urlHome()+"api/Dashboard/ValidarContactoPrincipal/CodCli/"+scope.tContacto_data_modal.CodCli+"/ConPri/"+1;
        $http.get(url).then(function(result)
        {
            $("#Principal").removeClass("loader loader-default is-active").addClass("loader loader-default");
            if(result.data!=false)
            {
                Swal.fire({ title: 'Contacto Principal',text: '¿Este Cliente ya tiene un contacto asignado como principal quiere establecer este como principal?',
                   type: "question",
                   showCancelButton: !0,
                   confirmButtonColor: "#31ce77",
                   cancelButtonColor: "#f34943",
                   confirmButtonText: "Confirmar"
               }).then(function(t) {
                if (t.value == true)
                {
                    scope.tContacto_data_modal.ConPrin=true;                        
                    var url=base_urlHome()+"api/Dashboard/UpdateOldContacto/CodConCli/"+result.data.CodConCli;
                    $http.get(url).then(function(result)
                    {
                        if(result.data!=false)
                        {
                            scope.toast('info','El Contacto anterior ya no es principal guarde los datos para establecer este como principal.','');
                        }
                        else
                        {
                            scope.toast('error','Ha ocurrido un error al intenta actualizar el contacto.','');
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
                else 
                {
                    scope.tContacto_data_modal.ConPrin=false;
                    scope.toast('error','Contacto no establecido como principal','Contacto No Principal');
                    console.log('cancelando ando...');
                }
            });


                    //scope.toast('error','Este Cliente ya tiene un contacto como principal','Error 404');
                }
                else
                {
                    scope.tContacto_data_modal.ConPrin=true;
                    scope.toast('success','Contacto Seleccionado como Principal.','Contacto Principal');
                }

            },function(error)
            {
                $("#Principal").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
$scope.submitFormRegistroContacto = function(event) 
{
    if (!scope.validar_campos_contactos_null()) {
           return false;
       }
       //console.log(scope.tContacto_data_modal);
       
       if (scope.tContacto_data_modal.CodConCli > 0) {
           var title = 'Actualizando';
           var text = '¿Seguro que desea actualizar la información del Contacto?';
       }
       if (scope.tContacto_data_modal.CodConCli == undefined) {
           var title = 'Guardando';
           var text = '¿Seguro que desea registrar el Contacto?';
       }
       console.log(scope.tContacto_data_modal);
       Swal.fire({
           title: text,
           type: "question",
           showCancelButton: !0,
           confirmButtonColor: "#31ce77",
           cancelButtonColor: "#f34943",
           confirmButtonText: "OK"
       }).then(function(t) {
           if (t.value == true) {               
               $("#" + title).removeClass("loader loader-default").addClass("loader loader-default is-active");
               var url = base_urlHome() + "api/Dashboard/Registro_Contacto";
               $http.post(url, scope.tContacto_data_modal).then(function(result) 
                {
                   $("#" + title).removeClass("loader loader-default  is-active").addClass("loader loader-default");                       
                   console.log(result);
                   if (result.data.status == false && result.data.response == false) {
                       scope.toast('error',result.data.menssage,title);
                   }
                   if (result.data.status == true && result.data.response == true) {
                       $('#modal_agregarContactos').modal('hide'); 
                        /*$('#modal_agregarCUPs').modal('hide');
                        $('#modal_agregarCuentasBancarias').modal('hide');
                        $('#modal_agregarDocumentos').modal('hide');
                        $('#modal_agregarNuevoCliente').modal('hide');*/

                       //$('#modal_agregarContactos').modal('hide');
                       scope.view_information();                       
                   }
                }, function(error) {
                   $("#" + title).removeClass("loader loader-default  is-active").addClass("loader loader-default");
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
           } else {
               console.log('Cancelando ando...');
           }
       });
   };
   scope.validar_campos_contactos_null = function() {
       resultado = true;
      
       if (scope.tContacto_data_modal.NIFConCli == null || scope.tContacto_data_modal.NIFConCli == undefined || scope.tContacto_data_modal.NIFConCli == '') {
           scope.toast('error','Debe ingresar un número de DNI/NIE/CIF','');
           return false;
       }
       if (!scope.tContacto_data_modal.CodTipViaSoc > 0) {
           scope.toast('error','Seleccione un Tipo de Vía para el Domicilio Social','');
           return false;
       }
       if (scope.tContacto_data_modal.NomViaDomSoc == null || scope.tContacto_data_modal.NomViaDomSoc == undefined || scope.tContacto_data_modal.NomViaDomSoc == '') {
           scope.toast('error','El Nombre de la Vía es requerido','');
           return false;
       }
       if (scope.tContacto_data_modal.NumViaDomSoc == null || scope.tContacto_data_modal.NumViaDomSoc == undefined || scope.tContacto_data_modal.NumViaDomSoc == '') {
           scope.toast('error','El Número de la Vía es requerido','');
           return false;
       }
       if (!scope.tContacto_data_modal.CodProSoc > 0) {
           scope.toast('error','Seleccione una Provincia para el Domicilio Social','');
           return false;
       }
       if (!scope.tContacto_data_modal.CodLocSoc > 0) {
           scope.toast('error','Seleccione una Localidad para el Domicilio Social','');
           return false;
       }
       if (!scope.tContacto_data_modal.CodTipCon > 0) {
           scope.toast('error','Seleccione un Tipo de Contacto','');
           return false;
       }
       if (scope.tContacto_data_modal.CarConCli == null || scope.tContacto_data_modal.CarConCli == undefined || scope.tContacto_data_modal.CarConCli == '') {
           scope.toast('error','El Cargo del Contacto es requerido','');
           return false;
       }
       if (scope.tContacto_data_modal.NomConCli == null || scope.tContacto_data_modal.NomConCli == undefined || scope.tContacto_data_modal.NomConCli == '') {
           scope.toast('error','El Nombre del Contacto es requerido','');
           return false;
       }
       if (scope.tContacto_data_modal.TelFijConCli == null || scope.tContacto_data_modal.TelFijConCli == undefined || scope.tContacto_data_modal.TelFijConCli == '') {
           scope.toast('error','El Teléfono Fijo del Contato es requerido','');
           return false;
       }
       if (scope.tContacto_data_modal.TelCelConCli == null || scope.tContacto_data_modal.TelCelConCli == undefined || scope.tContacto_data_modal.TelCelConCli == '') {
           scope.tContacto_data_modal.TelCelConCli=null;             
       }
       else
           {scope.tContacto_data_modal.TelCelConCli=scope.tContacto_data_modal.TelCelConCli;

           }
           if (scope.tContacto_data_modal.EmaConCli == null || scope.tContacto_data_modal.EmaConCli == undefined || scope.tContacto_data_modal.EmaConCli == '') {
               scope.toast('error','El Email del Contacto es requerido','');
               return false;
           }
           if (scope.tContacto_data_modal.CanMinRep <= 0) {
               scope.toast('error','El Cliente debe tener al menos un Firmante','');
               return false;
           }
           if (scope.tContacto_data_modal.ObsConC == null || scope.tContacto_data_modal.ObsConC == undefined || scope.tContacto_data_modal.ObsConC == '') {
               scope.tContacto_data_modal.ObsConC = null;
           } else {
               scope.tContacto_data_modal.ObsConC = scope.tContacto_data_modal.ObsConC;
           }
           if (scope.tContacto_data_modal.EsRepLeg == 1) {
               if (!scope.tContacto_data_modal.TipRepr > 0) {
                   scope.toast('error','Seleccione el Tipo de Representación','');
                   return false;
               }
               if (scope.tContacto_data_modal.DocNIF == undefined || scope.tContacto_data_modal.DocNIF == null) {
                scope.tContacto_data_modal.DocNIF=null;
            }
            else
            {
                scope.tContacto_data_modal.DocNIF=scope.tContacto_data_modal.DocNIF;
            }

        }
        if (scope.tContacto_data_modal.EsRepLeg == undefined) {
           scope.toast('error','Indique si el Firmante es o no Representante Legal','');
           return false;
       }

       if (scope.tContacto_data_modal.TieFacEsc == undefined||scope.tContacto_data_modal.TieFacEsc == null) {
           scope.tContacto_data_modal.TieFacEsc =null;
             //scope.toast('error','Indique si el Firmante tiene o no falcutad en Escrituras','');
             //return false;
         }
         else
         {
            scope.tContacto_data_modal.TieFacEsc=scope.tContacto_data_modal.TieFacEsc;
        } 
        if (scope.tContacto_data_modal.NumColeCon == undefined||scope.tContacto_data_modal.NumColeCon == null||scope.tContacto_data_modal.NumColeCon == '') {
           scope.tContacto_data_modal.NumColeCon =null;
             //scope.toast('error','Indique si el Firmante tiene o no falcutad en Escrituras','');
             //return false;
         }
         else
         {
            scope.tContacto_data_modal.NumColeCon=scope.tContacto_data_modal.NumColeCon;
        }         
        if (scope.tContacto_data_modal.TieFacEsc == 0) {

           if (scope.tContacto_data_modal.DocPod == undefined || scope.tContacto_data_modal.DocPod == null) {
               scope.toast('error','Adjunte el documento Poder del Representante Legal','');
               return false;
           }
       }
       if (scope.tContacto_data_modal.DocPod == null || scope.tContacto_data_modal.DocPod == undefined || scope.tContacto_data_modal.DocPod == '') {
           scope.tContacto_data_modal.DocPod = null;
       } else {
           scope.tContacto_data_modal.DocPod = scope.tContacto_data_modal.DocPod;
       }
       if (scope.tContacto_data_modal.DocNIF == null || scope.tContacto_data_modal.DocNIF == undefined || scope.tContacto_data_modal.DocNIF == '') {
           scope.tContacto_data_modal.DocNIF = null;
       } else {
           scope.tContacto_data_modal.DocNIF = scope.tContacto_data_modal.DocNIF;
       }

       if (scope.tContacto_data_modal.BloDomSoc == null || scope.tContacto_data_modal.BloDomSoc == undefined || scope.tContacto_data_modal.BloDomSoc == '') {
           scope.tContacto_data_modal.BloDomSoc = null;
       } else {
           scope.tContacto_data_modal.BloDomSoc = scope.tContacto_data_modal.BloDomSoc;
       }
       if (scope.tContacto_data_modal.EscDomSoc == null || scope.tContacto_data_modal.EscDomSoc == undefined || scope.tContacto_data_modal.EscDomSoc == '') {
           scope.tContacto_data_modal.EscDomSoc = null;
       } else {
           scope.tContacto_data_modal.EscDomSoc = scope.tContacto_data_modal.EscDomSoc;
       }

       if (scope.tContacto_data_modal.PlaDomSoc == null || scope.tContacto_data_modal.PlaDomSoc == undefined || scope.tContacto_data_modal.PlaDomSoc == '') {
           scope.tContacto_data_modal.PlaDomSoc = null;
       } else {
           scope.tContacto_data_modal.PlaDomSoc = scope.tContacto_data_modal.PlaDomSoc;
       }
       if (scope.tContacto_data_modal.PueDomSoc == null || scope.tContacto_data_modal.PueDomSoc == undefined || scope.tContacto_data_modal.PueDomSoc == '') {
           scope.tContacto_data_modal.PueDomSoc = null;
       } else {
           scope.tContacto_data_modal.PueDomSoc = scope.tContacto_data_modal.PueDomSoc;
       }
       if (scope.tContacto_data_modal.CPLocSoc == null || scope.tContacto_data_modal.CPLocSoc == undefined || scope.tContacto_data_modal.CPLocSoc == '') {
           scope.tContacto_data_modal.CPLocSoc = null;
       } else {
           scope.tContacto_data_modal.CPLocSoc = scope.tContacto_data_modal.CPLocSoc;
       }
       if (resultado == false) {
           return false;
       }
       return true;
   }
   scope.verificar_representante_legal = function() {

       if (scope.tContacto_data_modal.EsRepLeg == 0) {
           scope.tContacto_data_modal.TipRepr = "1";
           scope.tContacto_data_modal.CanMinRep = 1;
           document.getElementById('filenameDocNIF').value = '';
           scope.tContacto_data_modal.DocNIF = null;
       }
   }
   scope.verificar_facultad_escrituras = function() {
       if (scope.tContacto_data_modal.TieFacEsc == 1) {
           document.getElementById('DocPod').value = '';
           scope.tContacto_data_modal.DocPod = null;
       }
   }











//////////////////////////////////////////////////////// para cups start///////////////////////////////////////////////////////////
scope.search_PunSum = function() 
    {
            var url = base_urlHome() + "api/Dashboard/search_PunSum_Data/CodCli/" + scope.fdatos_cups.CodCli;
            $http.get(url).then(function(result) {
                if (result.data != false) 
                {
                    scope.T_PuntoSuministros = result.data;
                } else {
                    scope.toast('error','No existen Direcciones de Suministros Registrados','Error');
                    scope.T_PuntoSuministros = [];
                }
            }, function(error) {
                //$("#cargandos_cups").removeClass("loader loader-defaul is-active").addClass("loader loader-default");
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
        scope.agregarnuevadireccion=function(value)
        {
            console.log(value);

            if(value==false)
            {
                if (!scope.fdatos_cups.CodCli > 0) 
                {
                    scope.toast('error','Debe Seleccionar un Cliente Para Aplicar la Dirección.','Error');
                    return false;
                }
                scope.fdatos_cups.TipRegDir=1;
                scope.punto_suministro();
                scope.T_PuntoSuministrosVistaNuevaDireccion=true;
                var oldpunsum=scope.fdatos_cups.CodPunSum;
                console.log(oldpunsum);
                scope.fdatos_cups.CodPunSum=null;
                scope.fdatos_cups.AgregarNueva=value;
                var url = base_urlHome()+"api/Dashboard/TipViaProvin/";
                $http.get(url).then(function(result)
                {
                    if(result.data!=false)
                    {
                        scope.tTiposVias=result.data.tTiposVias;
                        scope.tProvidencias=result.data.tProvidencias;

                    }
                    else
                    {
                        scope.toast('error','no se encontraron los complementos para este procedimiento','Error');
                        scope.tTiposVias=[];
                        scope.tProvidencias=[];
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
            else
            {
                scope.T_PuntoSuministrosVistaNuevaDireccion=false;
                scope.fdatos_cups.AgregarNueva=value;
                //scope.fdatos_cups.CodPunSum=null;
            }
            
        }
        scope.punto_suministro = function() 
    {
        if (!scope.fdatos_cups.CodCli > 0) 
        {
            scope.toast('error','Debe Seleccionar un Cliente Para Aplicar la Dirección.','Error');
            return false;
        }
        if (scope.fdatos_cups.TipRegDir == 0) 
        {
             scope.restringir_input = 0;
             scope.fdatos_cups.CodTipVia = undefined;
             scope.fdatos_cups.NomViaPunSum = undefined;
             scope.fdatos_cups.NumViaPunSum = undefined;
             scope.fdatos_cups.BloPunSum = undefined;
             scope.fdatos_cups.EscPunSum = undefined;
             scope.fdatos_cups.PlaPunSum = undefined;
             scope.fdatos_cups.PuePunSum = undefined;             
             scope.fdatos_cups.CPLocSoc = undefined;
             scope.fdatos_cups.CodProPunSum = undefined;
             scope.fdatos_cups.CodLocPunSum = undefined;
             scope.fdatos_cups.ObsPunSum = undefined;
        }        
        else if (scope.fdatos_cups.TipRegDir == 1) 
        {
             scope.restringir_input = 1;
             $("#DirFisSoc").removeClass("loader loader-default").addClass("loader loader-default  is-active");
             var url = base_urlHome() + "api/Dashboard/buscar_direccion_Soc_Fis/Cliente/" + scope.fdatos_cups.CodCli + "/TipRegDir/" + scope.fdatos_cups.TipRegDir;
             $http.get(url).then(function(result) {
                 $("#DirFisSoc").removeClass("loader loader-default is-active").addClass("loader loader-default");
                 if (result.data != false) {
                    
                    scope.fdatos_cups.CodTipVia = result.data.CodTipViaSoc;
                    scope.fdatos_cups.NomViaPunSum = result.data.NomViaDomSoc;
                    scope.fdatos_cups.NumViaPunSum = result.data.NumViaDomSoc;
                    scope.fdatos_cups.BloPunSum = result.data.BloDomSoc;
                    scope.fdatos_cups.EscPunSum = result.data.EscDomSoc;
                    scope.fdatos_cups.PlaPunSum = result.data.PlaDomSoc;
                    scope.fdatos_cups.PuePunSum = result.data.PueDomSoc;
                    scope.fdatos_cups.CodProPunSum = result.data.CodProSoc;
                    scope.fdatos_cups.CodLocPunSum = result.data.CodLocSoc;
                    scope.fdatos_cups.CPLocSoc = result.data.CPLocSoc;
                    scope.TLocalidadesfiltradaPunSum = [];                    
                    scope.BuscarLocalidadesPunSun(result.data.CodProSoc,2);
                 } else {
                    scope.toast('error','No hemos encontrados dirección compatible con este cliente.','Error');
                 }

             }, function(error) {
                 $("#DirFisSoc").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
        else if (scope.fdatos_cups.TipRegDir == 2) 
        {
             scope.restringir_input = 1;
             $("#DirFisSoc").removeClass("loader loader-default").addClass("loader loader-default  is-active");
             var url = base_urlHome() + "api/Dashboard/buscar_direccion_Soc_Fis/Cliente/" + scope.fdatos_cups.CodCli + "/TipRegDir/" + scope.fdatos_cups.TipRegDir;
             $http.get(url).then(function(result) {
                 $("#DirFisSoc").removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (result.data != false) {
                     scope.fdatos_cups.CodTipVia = result.data.CodTipViaFis;
                     scope.fdatos_cups.NomViaPunSum = result.data.NomViaDomFis;
                     scope.fdatos_cups.NumViaPunSum = result.data.NumViaDomFis;
                     scope.fdatos_cups.BloPunSum = result.data.BloDomFis;
                     scope.fdatos_cups.EscPunSum = result.data.EscDomFis;
                     scope.fdatos_cups.PlaPunSum = result.data.PlaDomFis;
                     scope.fdatos_cups.PuePunSum = result.data.PueDomFis;
                     scope.fdatos_cups.CodProPunSum = result.data.CodProFis;
                     scope.fdatos_cups.CodLocPunSum = result.data.CodLocFis;
                     scope.fdatos_cups.CPLocSoc = result.data.CPLocFis;
                     scope.TLocalidadesfiltradaPunSum = [];
                     scope.BuscarLocalidadesPunSun(result.data.CodProFis,2);

                 } else {
                     scope.toast('error','No hemos encontrados dirección compatible con este cliente.','Error');
                 }

             }, function(error) {
                 $("#DirFisSoc").removeClass("loader loader-default is-active").addClass("loader loader-default");
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
        else
        {

        }
    }    
     scope.BuscarLocalidadesPunSun=function(CodPro,metodo)
    {
        console.log(CodPro);        
        var url=base_urlHome()+"api/Dashboard/BuscarLocalidadesFil/CodPro/"+CodPro;
        $http.get(url).then(function(result)
        {
            if(result.data!=false)
            {
                scope.TLocalidadesfiltradaPunSum=result.data;
            }
            else
            {
               scope.toast('error','No se encontraron Localidades asignada a esta Provincia','Error');
               scope.TLocalidadesfiltradaPunSum=[];
               scope.fdatos_cups.CodLocPunSum=undefined;
               scope.fdatos_cups.CodLocFil=undefined;
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
    scope.por_servicios = function(objecto) {
        if (scope.fdatos_cups.CodCup > 0 && scope.fdatos_cups.TipServ != scope.fdatos_cups.TipServAnt) {
            scope.fdatos_cups.PotConP1 = null;
            scope.fdatos_cups.PotConP2 = null;
            scope.fdatos_cups.PotConP3 = null;
            scope.fdatos_cups.PotConP4 = null;
            scope.fdatos_cups.PotConP5 = null;
            scope.fdatos_cups.PotConP6 = null;
            scope.fdatos_cups.PotMaxBie = null;
            scope.fdatos_cups.CodDis = null;
            scope.fdatos_cups.CodTar = null;
            scope.fdatos_cups.FecAltCup = null;
            scope.fdatos_cups.FecUltLec = null;
            scope.fdatos_cups.ConAnuCup = null;
        }
        if (scope.fdatos_cups.CodCup == undefined && scope.fdatos_cups.TipServAnt == undefined) {
            scope.fdatos_cups.PotConP1 = null;
            scope.fdatos_cups.PotConP2 = null;
            scope.fdatos_cups.PotConP3 = null;
            scope.fdatos_cups.PotConP4 = null;
            scope.fdatos_cups.PotConP5 = null;
            scope.fdatos_cups.PotConP6 = null;
            scope.fdatos_cups.PotMaxBie = null;
            scope.fdatos_cups.CodDis = null;
            scope.fdatos_cups.CodTar = null;
            scope.fdatos_cups.FecAltCup = null;
            scope.fdatos_cups.FecUltLec = null;
            scope.fdatos_cups.ConAnuCup = null;
        }
        scope.sin_data = 1;
        if (objecto == 1) {
            var url = base_urlHome() + "api/Dashboard/Por_Servicios";
            $http.post(url, scope.fdatos_cups).then(function(result) {
                if (result.data != false) {
                    scope.T_Distribuidoras = result.data.Distribuidoras;
                    scope.T_Tarifas = result.data.Tarifas;
                    scope.sin_data = 0;
                } else {
                    scope.toast('info','No existen datos registrados.','Error');
                    scope.sin_data = 1;
                }

            }, function(error) {
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
        if (objecto == 2) {
            var url = base_urlHome() + "api/Dashboard/Por_Servicios";
            $http.post(url, scope.fdatos_cups).then(function(result) {
                if (result.data != false) {
                    scope.T_Distribuidoras = result.data.Distribuidoras;
                    scope.T_Tarifas = result.data.Tarifas;
                    scope.sin_data = 0;
                } else {
                    scope.toast('error','No existen datos registrados.','Error');
                    scope.sin_data = 1;
                }

            }, function(error) {
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
    scope.PeriodosTarifas = function(TipServ, CodTar) {
        if (TipServ == 1) {
            console.log(TipServ);
            console.log(CodTar);
            console.log(scope.T_Tarifas);
            for (var i = 0; i < scope.T_Tarifas.length; i++) {
                if (scope.T_Tarifas[i].CodTar == CodTar) {
                    //console.log(scope.T_Tarifas[i]);
                    scope.totalPot = scope.T_Tarifas[i].CanPerTar;
                }
            }
            console.log(scope.totalPot);
        }
    }
    scope.validar_fecha_inputs = function(metodo, object) {
        if (metodo == 1) {
            if (object != undefined) {
                numero = object;
                if (!/^([/0-9])*$/.test(numero))
                    scope.fdatos_cups.FecAltCup = numero.substring(0, numero.length - 1);
            }
        }
        if (metodo == 2) {
            if (object != undefined) {
                numero = object;
                if (!/^([/0-9])*$/.test(numero))
                    scope.fdatos_cups.FecUltLec = numero.substring(0, numero.length - 1);
            }
        }
        if (metodo == 3) {
            if (object != undefined) {
                numero = object;
                if (!/^([.0-9])*$/.test(numero))
                    scope.fdatos_cups.ConAnuCup = numero.substring(0, numero.length - 1);
            }
        }
        if (metodo == 4) {
            if (object != undefined) {
                numero = object;
                if (!/^([.0-9])*$/.test(numero))
                    scope.fdatos_cups.PotConP1 = numero.substring(0, numero.length - 1);
            }
        }
        if (metodo == 5) {
            if (object != undefined) {
                numero = object;
                if (!/^([.0-9])*$/.test(numero))
                    scope.fdatos_cups.PotConP2 = numero.substring(0, numero.length - 1);
            }
        }
        if (metodo == 6) {
            if (object != undefined) {
                numero = object;
                if (!/^([.0-9])*$/.test(numero))
                    scope.fdatos_cups.PotConP3 = numero.substring(0, numero.length - 1);
            }
        }
        if (metodo == 7) {
            if (object != undefined) {
                numero = object;
                if (!/^([.0-9])*$/.test(numero))
                    scope.fdatos_cups.PotConP4 = numero.substring(0, numero.length - 1);
            }
        }
        if (metodo == 8) {
            if (object != undefined) {
                numero = object;
                if (!/^([.0-9])*$/.test(numero))
                    scope.fdatos_cups.PotConP5 = numero.substring(0, numero.length - 1);
            }
        }
        if (metodo == 9) {
            if (object != undefined) {
                numero = object;
                if (!/^([.0-9])*$/.test(numero))
                    scope.fdatos_cups.PotConP6 = numero.substring(0, numero.length - 1);
            }
        }
        if (metodo == 10) {
            if (object != undefined) {
                numero = object;
                if (!/^([.0-9])*$/.test(numero))
                    scope.fdatos_cups.PotMaxBie = numero.substring(0, numero.length - 1);
            }
        }

        if (metodo == 20) {
            if (object != undefined) {
                numero = object;
                if (!/^([/0-9])*$/.test(numero))
                    scope.historial.desde = numero.substring(0, numero.length - 1);
            }
        }

        if (metodo == 21) {
            if (object != undefined) {
                numero = object;
                if (!/^([/0-9])*$/.test(numero))
                    scope.historial.hasta = numero.substring(0, numero.length - 1);
            }
        }
        if (metodo == 22) {
            if (object != undefined) {
                numero = object;
                if (!/^([/0-9])*$/.test(numero))
                    scope.tmodal_data.FecBaj = numero.substring(0, numero.length - 1);
            }
        }
         if (metodo == 23) {
            if (object != undefined) {
                numero = object;
                if (!/^([,0-9])*$/.test(numero))
                    scope.fdatos_cups.DerAccKW = numero.substring(0, numero.length - 1);
            }
        }
    }
     $scope.submitFormCups = function(event) {
        //scope.fdatos_cups.CodPunSum=scope.CodPunSum;
        console.log(scope.fdatos_cups);
        if (!scope.validar_campos_cups()) {
            return false;
        }
        if (scope.fdatos_cups.CodCup > 0) {
            var title = 'Actualizando';
            var text = '¿Seguro que desea modificar la información del CUPs?';
            var response = "CUPs actualizado de forma correcta";
        }
        if (scope.fdatos_cups.CodCup == undefined) {
            var title = 'Guardando';
            var text = '¿Seguro que desea registrar el CUPs?';
            var response = "CUPs creado de forma correcta";
        }
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
                $("#" + title).removeClass("loader loader-default").addClass("loader loader-default is-active");
                var url = base_urlHome() + "api/Dashboard/Registrar_Cups/";
                $http.post(url, scope.fdatos_cups).then(function(result) 
                {
                    $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
                    console.log(result.data);
                    if(result.data.status==400 && result.data.statusText=='OK')
                    {
                        scope.toast('error',result.data.response,'CUPs Registrado');
                        return false;
                    }
                    else if(result.data.status==200 && result.data.statusText=='OK')
                    {
                        $('#modal_agregarCUPs').modal('hide');  
                        scope.view_information();                         
                        /*console.log(result.data.objSalida);
                        scope.fdatos_cups = result.data.objSalida;
                        console.log(scope.fdatos_cups);
                        $('.datepicker').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", result.data.objSalida.FecAltCup);
                        $('.datepicker2').datepicker({ format: 'dd/mm/yyyy', autoclose: true, todayHighlight: true }).datepicker("setDate", result.data.objSalida.FecUltLec);
                        scope.toast('success',result.data.response,title);
                        if(scope.fdatos_cups.AgregarNueva==false && scope.fdatos_cups.CodCup!=undefined)                            
                        { 
                            scope.agregarnuevadireccion(true)
                            scope.search_PunSum();
                            scope.fdatos_cups.CodPunSum=result.data.objSalida.CodPunSum;
                            console.log(result.data.objSalida.CodPunSum);
                            console.log(scope.fdatos_cups.CodPunSum);
                        }*/
                    }
                }, function(error) {
                    $("#" + title).removeClass("loader loader-defaul is-active").addClass("loader loader-default");
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
            } else {
                event.preventDefault();
            }
        });
    };
    scope.validar_campos_cups = function()
    {
        resultado = true;
        if (!scope.fdatos_cups.CodCli > 0) {
            scope.toast('error','Debe seleccionar un Cliente.','');
            return false;
        }        
        if(scope.fdatos_cups.AgregarNueva==true)
        {
            if (!scope.fdatos_cups.CodPunSum > 0) 
            {
                scope.toast('error','Debe seleccionar un Dirección de Suministro de la lista.','');
                return false;
            }  
        }
        else
        {
            if (!scope.fdatos_cups.CodTipVia > 0) 
            {
               scope.toast('error','Debe seleccionar un Tipo de Vía de la lista.','');
                return false;
            } 
            if (scope.fdatos_cups.NomViaPunSum == null || scope.fdatos_cups.NomViaPunSum == undefined || scope.fdatos_cups.NomViaPunSum == '') {
                scope.toast('error','Debe colocar el nombre de la vía','Requerido');
                return false;
            }
            if (scope.fdatos_cups.NumViaPunSum == null || scope.fdatos_cups.NumViaPunSum == undefined || scope.fdatos_cups.NumViaPunSum == '') {
                scope.toast('error','Debe colocar el nombre de la vía','Requerido');
                return false;
            }
            if (scope.fdatos_cups.BloPunSum == null || scope.fdatos_cups.BloPunSum == undefined || scope.fdatos_cups.BloPunSum == '') {
                scope.fdatos_cups.BloPunSum=null;
            } 
            else 
            {
                scope.fdatos_cups.BloPunSum=scope.fdatos_cups.BloPunSum;
            }
            if (scope.fdatos_cups.EscPunSum == null || scope.fdatos_cups.EscPunSum == undefined || scope.fdatos_cups.EscPunSum == '') {
                 scope.fdatos_cups.EscPunSum=null;
            } 
            else 
            {
                scope.fdatos_cups.EscPunSum=scope.fdatos_cups.EscPunSum;
            }


            if (scope.fdatos_cups.PlaPunSum == null || scope.fdatos_cups.PlaPunSum == undefined || scope.fdatos_cups.PlaPunSum == '') {
                 scope.fdatos_cups.PlaPunSum=null;
            } 
            else 
            {
                scope.fdatos_cups.PlaPunSum=scope.fdatos_cups.PlaPunSum;
            }
            if (scope.fdatos_cups.PuePunSum == null || scope.fdatos_cups.PuePunSum == undefined || scope.fdatos_cups.PuePunSum == '') {
                 scope.fdatos_cups.PuePunSum=null;
            } 
            else 
            {
                scope.fdatos_cups.PuePunSum=scope.fdatos_cups.PuePunSum;
            }
            if (scope.fdatos_cups.CPLocSoc == null || scope.fdatos_cups.CPLocSoc == undefined || scope.fdatos_cups.CPLocSoc == '') {
                 scope.fdatos_cups.CPLocSoc=null;
            } 
            else 
            {
                scope.fdatos_cups.CPLocSoc=scope.fdatos_cups.CPLocSoc;
            }
            if (!scope.fdatos_cups.CodProPunSum > 0) 
            {
               scope.toast('error','Debe seleccionar una provincia de la lista.','');
                return false;
            } 
            if (!scope.fdatos_cups.CodLocPunSum > 0) 
            {
               scope.toast('error','Debe seleccionar una localidad de la lista.','');
                return false;
            }
            if (scope.fdatos_cups.ObsPunSum == null || scope.fdatos_cups.ObsPunSum == undefined || scope.fdatos_cups.ObsPunSum == '') {
                 scope.fdatos_cups.ObsPunSum=null;
            } 
            else 
            {
                scope.fdatos_cups.ObsPunSum=scope.fdatos_cups.ObsPunSum;
            }
        }
        if (scope.fdatos_cups.cups == null || scope.fdatos_cups.cups == undefined || scope.fdatos_cups.cups == '') {
            scope.toast('error','El Campo CUPs es requerido','');
            return false;
        } else {
            if (scope.fdatos_cups.cups.length < 2) {
                scope.toast('error','El Campo CUPs Debe Contener 2 Letras o Números.','');
                return false;
            }
        }
        if (scope.fdatos_cups.cups1 == null || scope.fdatos_cups.cups1 == undefined || scope.fdatos_cups.cups1 == '') {
            scope.toast('error','El Campo CUPs 1 es requerido','');
            return false;
        } else {
            if (scope.fdatos_cups.cups1.length < 16) {
                scope.toast('error','El Campo CUPs Debe Contener 16 Letras o Números.','');
                return false;
            }
        }        
        if (scope.fdatos_cups.TipServ == 0) {
            scope.toast('error','Debe Seleccionar un Tipo de Suministro','');
            return false;
        }

        if (scope.fdatos_cups.TipServ == 1) {
            
            if (!scope.fdatos_cups.CodDis > 0) {
                //scope.toast('error','Debe Seleccionar una Distribuidora Eléctrica de la lista.','');
                //return false;
                scope.fdatos_cups.CodDis=null;
            }
            else
            {
                scope.fdatos_cups.CodDis=scope.fdatos_cups.CodDis;
            }            
            if (!scope.fdatos_cups.CodTar > 0) {
                scope.toast('error','Debe Seleccionar una Tarifa de Eléctrica la lista.','');
                return false;
            }
            if (scope.totalPot == 1) {
                if (scope.fdatos_cups.PotConP1 == null || scope.fdatos_cups.PotConP1 == undefined || scope.fdatos_cups.PotConP1 == '') {
                    scope.toast('error','El Campo P1 Es requerido','');
                    return false;
                }
                /*if (scope.fdatos_cups.PotMaxBie == null || scope.fdatos_cups.PotMaxBie == undefined || scope.fdatos_cups.PotMaxBie == '') {
                    scope.toast('error','El Campo Potencia Máxima Es requerido','');                   
                    return false;
                }*/
                scope.fdatos_cups.PotConP2 = null;
                scope.fdatos_cups.PotConP3 = null;
                scope.fdatos_cups.PotConP4 = null;
                scope.fdatos_cups.PotConP5 = null;
                scope.fdatos_cups.PotConP6 = null;

            }
            if (scope.totalPot == 2) {
                if (scope.fdatos_cups.PotConP1 == null || scope.fdatos_cups.PotConP1 == undefined || scope.fdatos_cups.PotConP1 == '') {
                    scope.toast('error','El Campo P1 Es requerido','');
                    return false;
                }
                if (scope.fdatos_cups.PotConP2 == null || scope.fdatos_cups.PotConP2 == undefined || scope.fdatos_cups.PotConP2 == '') {
                    scope.toast('error','El Campo P2 Es requerido','');
                    return false;
                }
                /*if (scope.fdatos_cups.PotMaxBie == null || scope.fdatos_cups.PotMaxBie == undefined || scope.fdatos_cups.PotMaxBie == '') {
                    scope.toast('error','El Campo Potencia Máxima Es requerido','');
                    return false;
                }*/
                scope.fdatos_cups.PotConP3 = null;
                scope.fdatos_cups.PotConP4 = null;
                scope.fdatos_cups.PotConP5 = null;
                scope.fdatos_cups.PotConP6 = null;
            }
            if (scope.totalPot == 3) {
                if (scope.fdatos_cups.PotConP1 == null || scope.fdatos_cups.PotConP1 == undefined || scope.fdatos_cups.PotConP1 == '') {
                    scope.toast('error','El Campo P1 Es requerido','');
                    return false;
                }
                if (scope.fdatos_cups.PotConP2 == null || scope.fdatos_cups.PotConP2 == undefined || scope.fdatos_cups.PotConP2 == '') {
                    scope.toast('error','El Campo P2 Es requerido','');
                    return false;
                }
                if (scope.fdatos_cups.PotConP3 == null || scope.fdatos_cups.PotConP3 == undefined || scope.fdatos_cups.PotConP3 == '') {
                    scope.toast('error','El Campo P3 Es requerido','');
                    return false;
                }
                /*if (scope.fdatos_cups.PotMaxBie == null || scope.fdatos_cups.PotMaxBie == undefined || scope.fdatos_cups.PotMaxBie == '') {
                    scope.toast('error','El Campo Potencia Máxima Es requerido','');
                    return false;
                }*/
                scope.fdatos_cups.PotConP4 = null;
                scope.fdatos_cups.PotConP5 = null;
                scope.fdatos_cups.PotConP6 = null;
            }
            if (scope.totalPot == 4) {
                if (scope.fdatos_cups.PotConP1 == null || scope.fdatos_cups.PotConP1 == undefined || scope.fdatos_cups.PotConP1 == '') {
                    scope.toast('error','El Campo P1 Es requerido','');
                    
                    return false;
                }
                if (scope.fdatos_cups.PotConP2 == null || scope.fdatos_cups.PotConP2 == undefined || scope.fdatos_cups.PotConP2 == '') {
                    scope.toast('error','El Campo P2 Es requerido','');
                    
                    return false;
                }
                if (scope.fdatos_cups.PotConP3 == null || scope.fdatos_cups.PotConP3 == undefined || scope.fdatos_cups.PotConP3 == '') {
                    scope.toast('error','El Campo P3 Es requerido','');
                    
                    return false;
                }
                if (scope.fdatos_cups.PotConP4 == null || scope.fdatos_cups.PotConP4 == undefined || scope.fdatos_cups.PotConP4 == '') {
                    scope.toast('error','El Campo P4 Es requerido','');
                    
                    return false;
                }
                /*if (scope.fdatos_cups.PotMaxBie == null || scope.fdatos_cups.PotMaxBie == undefined || scope.fdatos_cups.PotMaxBie == '') {
                    scope.toast('error','El Campo Potencia Máxima Es requerido','');
                    return false;
                }*/
                scope.fdatos_cups.PotConP5 = null;
                scope.fdatos_cups.PotConP6 = null;
            }
            if (scope.totalPot == 5) {
                if (scope.fdatos_cups.PotConP1 == null || scope.fdatos_cups.PotConP1 == undefined || scope.fdatos_cups.PotConP1 == '') {
                    scope.toast('error','El Campo P1 Es requerido','');
                    return false;
                }
                if (scope.fdatos_cups.PotConP2 == null || scope.fdatos_cups.PotConP2 == undefined || scope.fdatos_cups.PotConP2 == '') {
                    scope.toast('error','El Campo P2 Es requerido','');
                    return false;
                }
                if (scope.fdatos_cups.PotConP3 == null || scope.fdatos_cups.PotConP3 == undefined || scope.fdatos_cups.PotConP3 == '') {
                    scope.toast('error','El Campo P3 Es requerido','');
                    return false;
                }
                if (scope.fdatos_cups.PotConP4 == null || scope.fdatos_cups.PotConP4 == undefined || scope.fdatos_cups.PotConP4 == '') {
                    scope.toast('error','El Campo P4 Es requerido','');
                    return false;
                }
                if (scope.fdatos_cups.PotConP5 == null || scope.fdatos_cups.PotConP5 == undefined || scope.fdatos_cups.PotConP5 == '') {
                    scope.toast('error','El CampoP5 Es requerido','');
                    return false;
                }
                /*if (scope.fdatos_cups.PotMaxBie == null || scope.fdatos_cups.PotMaxBie == undefined || scope.fdatos_cups.PotMaxBie == '') {
                    scope.toast('error','El Campo Potencia Máxima Es requerido','');
                    return false;
                }*/
                scope.fdatos_cups.PotConP6 = null;
            }
            if (scope.totalPot == 6) {
                if (scope.fdatos_cups.PotConP1 == null || scope.fdatos_cups.PotConP1 == undefined || scope.fdatos_cups.PotConP1 == '') {
                    scope.toast('error','El Campo P1 Es requerido','');
                    return false;
                }
                if (scope.fdatos_cups.PotConP2 == null || scope.fdatos_cups.PotConP2 == undefined || scope.fdatos_cups.PotConP2 == '') {
                    scope.toast('error','El Campo P2 Es requerido','');
                    return false;
                }
                if (scope.fdatos_cups.PotConP3 == null || scope.fdatos_cups.PotConP3 == undefined || scope.fdatos_cups.PotConP3 == '') {
                    scope.toast('error','El Campo P3 Es requerido','');                    
                    return false;
                }
                if (scope.fdatos_cups.PotConP4 == null || scope.fdatos_cups.PotConP4 == undefined || scope.fdatos_cups.PotConP4 == '') {
                    scope.toast('error','El Campo P4 Es requerido','');
                    return false;
                }
                if (scope.fdatos_cups.PotConP5 == null || scope.fdatos_cups.PotConP5 == undefined || scope.fdatos_cups.PotConP5 == '') {
                    scope.toast('error','El CampoP5 Es requerido','');
                    return false;
                }
                if (scope.fdatos_cups.PotConP6 == null || scope.fdatos_cups.PotConP6 == undefined || scope.fdatos_cups.PotConP6 == '') {
                    scope.toast('error','El Campo P6 Es requerido','');
                    return false;
                }
                /*if (scope.fdatos_cups.PotMaxBie == null || scope.fdatos_cups.PotMaxBie == undefined || scope.fdatos_cups.PotMaxBie == '') {
                    scope.toast('error','El Campo Potencia Máxima Es requerido','');
                    return false;
                }*/
            }
            if (scope.fdatos_cups.ConAnuCup == null || scope.fdatos_cups.ConAnuCup == undefined || scope.fdatos_cups.ConAnuCup == '') {
                scope.toast('error','El Campo Consumo es requerido','');
                return false;
            }
            if (scope.fdatos_cups.PotMaxBie == null || scope.fdatos_cups.PotMaxBie == undefined || scope.fdatos_cups.PotMaxBie == '') {
                   
                   scope.fdatos_cups.PotMaxBie = null;
            }
        }
        if (scope.fdatos_cups.TipServ == 2) {
            if (!scope.fdatos_cups.CodDis > 0) {
                //scope.toast('error','Debe Seleccionar una Distribuidora Gas de la lista.','');
                //return false;
                scope.fdatos_cups.CodDis=null;
            }
            else
            {
                scope.fdatos_cups.CodDis=scope.fdatos_cups.CodDis;
            }
            if (!scope.fdatos_cups.CodTar > 0) {
                scope.toast('error','Debe Seleccionar una Tarifa de Gas la lista.','');
                return false;
            }

            if (scope.fdatos_cups.ConAnuCup == null || scope.fdatos_cups.ConAnuCup == undefined || scope.fdatos_cups.ConAnuCup == '') {
                scope.toast('error','El Campo Consumo es requerido','');
                return false;
            }
            scope.fdatos_cups.PotConP1 = null;
            scope.fdatos_cups.PotConP2 = null;
            scope.fdatos_cups.PotConP3 = null;
            scope.fdatos_cups.PotConP4 = null;
            scope.fdatos_cups.PotConP5 = null;
            scope.fdatos_cups.PotConP6 = null;
            scope.fdatos_cups.PotMaxBie = null;

        }
        var FecAltCup = document.getElementById("FecAltCup").value;
        scope.fdatos_cups.FecAltCup = FecAltCup;
        if (scope.fdatos_cups.FecAltCup == null || scope.fdatos_cups.FecAltCup == undefined || scope.fdatos_cups.FecAltCup == '') {
            scope.fdatos_cups.FecAltCup == null;
        } else {
            var FecAltCup = (scope.fdatos_cups.FecAltCup).split("/");
            if (FecAltCup.length < 3) {
                scope.toast('error','El formato Fecha de Alta correcto es DD/MM/YYYY','');
                return false;
            } else {
                if (FecAltCup[0].length > 2 || FecAltCup[0].length < 2) {
                    scope.toast('error','Error en Día, debe introducir dos números','');
                    return false;

                }
                if (FecAltCup[1].length > 2 || FecAltCup[1].length < 2) {
                    scope.toast('error','Error en Mes, debe introducir dos números','');
                    return false;
                }
                if (FecAltCup[2].length < 4 || FecAltCup[2].length > 4) {
                    scope.toast('error','Error en Año, debe introducir cuatro números','');
                    return false;
                }
                var h1 = new Date();
                var final = FecAltCup[0] + "/" + FecAltCup[1] + "/" + FecAltCup[2];
                scope.fdatos_cups.FecAltCup = final;
            }

        }
        scope.fdatos_cups.FecUltLec = null;        
        var CUPS = scope.fdatos_cups.cups+""+scope.fdatos_cups.cups1;
        if (!scope.valida_cups(CUPS)) {
            return false;
        }
        if (scope.fdatos_cups.DerAccKW == null || scope.fdatos_cups.DerAccKW == undefined || scope.fdatos_cups.DerAccKW == '') {
            scope.fdatos_cups.DerAccKW = null;
        }
        else
        {   
            scope.fdatos_cups.DerAccKW = scope.fdatos_cups.DerAccKW;
        }
        if (resultado == false) {
            return false;
        }
        return true;
    }
    scope.valida_cups_existe=function(CUPS)
    {
        var url=base_urlHome()+"api/Cups/VerificarCUPsExistente/Cups/"+CUPS;
        $http.get(url).then(function(result)
        {
            if(result.data.status==200 && result.data.statusText=='OK')
            {
                scope.toast('success',result.data.response,result.data.statusText);
                return true;
            }
            else if(result.data.status==400  && result.data.statusText=='Bad Request')
            {
                scope.toast('error',result.data.response,result.data.statusText);
                return false;
            }
            else
            {
                scope.toast('error','Error en Petición intente nuevamente.','Error');
                return false;
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
                            return false;
        });
    }
    Math.fmod = function (a,b) { return Number((a - (Math.floor(a / b) * b)).toPrecision(8)); };
    scope.valida_cups=function(CUPS)
    { 
        
        console.log(CUPS);
        var status=false;
        var RegExPattern =/^ES[0-9]{16}[a-zA-Z]{2}[0-9]{0,1}[a-zA-Z]{0,1}$/;
        if ((CUPS.match(RegExPattern)) && (CUPS!='')) {
            var CUPS_16 = CUPS.substr(2,16);
            var control = CUPS.substr(18,2);
            var letters = Array('T','R','W','A','G','M','Y','F','P','D','X','B','N','J','Z','S','Q','V','H','L','C','K','E');

            var fmodv = Math.fmod(CUPS_16,529);
            var imod = parseInt(fmodv);
            var quotient = Math.floor(imod / 23);
            var remainder = imod % 23;            
            var dc1 = letters[quotient];
            var dc2 = letters[remainder];
            status = (control == dc1+dc2);
        } else {
            status=false;
        }
        if(!status){
           //alert("ERROR: Código CUPS incorrecto");
            scope.toast('error','Este CUPS es incorrecto por favor intente con otro','Error CUPS');            
            $('#CUPSNUM').val("");
            $('#CUPSNUM2').val("");
            $('#CUPSES').focus();
            $('#CUPSNUM').focus();
            $('#CUPSNUM2').focus();
        }
        console.log(status);
        return status;  
    }

//////////////////////////////////////////////////////// para cups end ///////////////////////////////////////////////////////////






























/////////////////////////////////// PARA CUENTAS BANCARIAS DASHBOARD START /////////////////////////////
 scope.validarsinuermoIBAN = function(IBAN, object) {
         
         if (object != undefined && IBAN == 1) {
             numero = object;
             if (!/^([0-9])*$/.test(numero))
                scope.IBAN1 = numero.substring(0, numero.length - 1);
         }
         if (object != undefined && IBAN == 2) {
             numero = object;
             if (!/^([0-9])*$/.test(numero))
                 scope.IBAN2 = numero.substring(0, numero.length - 1);
         }
         if (object != undefined && IBAN == 3) {
             numero = object;
             if (!/^([0-9])*$/.test(numero))
                 scope.IBAN3 = numero.substring(0, numero.length - 1);
         }
         if (object != undefined && IBAN == 4) {
             numero = object;
             if (!/^([0-9])*$/.test(numero))
                 scope.IBAN4 = numero.substring(0, numero.length - 1);
         }
         if (object != undefined && IBAN == 5) {
             numero = object;
             if (!/^([0-9])*$/.test(numero))
                 scope.IBAN5 = numero.substring(0, numero.length - 1);
         }
         
         if (scope.IBAN1.length == 4 && scope.IBAN2.length == 4 && scope.IBAN3.length == 4 && scope.IBAN4.length == 4 && scope.IBAN5.length == 4) 
         {             
            scope.dig_control = scope.CodEur.substr(2, 4);
            scope.cod_pais = "1428";
            scope.tira_cuenta = scope.IBAN1 + scope.IBAN2 + scope.IBAN3 + scope.IBAN4 + scope.IBAN5;
            scope.tira_completa = scope.tira_cuenta + scope.cod_pais + scope.dig_control;
            scope.TIR_RES1 = scope.tira_completa.substr(0, 8);
            scope.VAL_TIR_RES1 = parseInt(scope.TIR_RES1);
            scope.VAL_RES_TIR_RES1 = scope.VAL_TIR_RES1 - (97 * parseInt(scope.VAL_TIR_RES1 / 97));
            var x = scope.VAL_RES_TIR_RES1,
                toString = x.toString(),
                toConcat = x + "";
            scope.CAR_RES_TIR_RES1 = toConcat;
            scope.TIR_RES2 = scope.CAR_RES_TIR_RES1 + scope.tira_completa.substr(8, 8);
            scope.VAL_TIR_RES2 = parseInt(scope.TIR_RES2);
            scope.VAL_RES_TIR_RES2 = scope.VAL_TIR_RES2 - (97 * parseInt(scope.VAL_TIR_RES2 / 97));
            scope.CAR_RES_TIR_RES2 = "0" + scope.VAL_RES_TIR_RES2;
            scope.TIR_RES3 = scope.CAR_RES_TIR_RES2 + scope.tira_completa.substr(16, 6);
            scope.VAL_TIR_RES3 = parseInt(scope.TIR_RES3);
            scope.VAL_RES_TIR_RES3 = scope.VAL_TIR_RES3 - (97 * parseInt(scope.VAL_TIR_RES3 / 97));
            var x1 = scope.VAL_RES_TIR_RES3,
                toString1 = x1.toString(),
                toConcat1 = x1 + "";
            scope.CAR_RES_TIR_RES3 = toConcat1;
            scope.TIR_RES4 = scope.CAR_RES_TIR_RES3 + scope.tira_completa.substr(22, 4);
            scope.VAL_TIR_RES4 = parseInt(scope.TIR_RES4);
            scope.VAL_RES_TIR_RES2 = scope.VAL_TIR_RES4 - (97 * parseInt(scope.VAL_TIR_RES4 / 97));
             
             /*console.log(scope.tira_cuenta);
             console.log(scope.dig_control);
             console.log(scope.cod_pais);
             console.log(scope.tira_completa);
             console.log(scope.TIR_RES1);
             console.log(scope.VAL_TIR_RES1);
             console.log(scope.VAL_RES_TIR_RES1);
             console.log(scope.CAR_RES_TIR_RES1);
             console.log(scope.TIR_RES2);
             console.log(scope.VAL_TIR_RES2);
             console.log(scope.VAL_RES_TIR_RES2);
             console.log(scope.CAR_RES_TIR_RES2);
             console.log(scope.TIR_RES3);
             console.log(scope.VAL_TIR_RES3);
             console.log(scope.VAL_RES_TIR_RES3);
             console.log(scope.CAR_RES_TIR_RES3);
             console.log(scope.TIR_RES4);
             console.log(scope.VAL_TIR_RES4);
             console.log(scope.VAL_RES_TIR_RES2);*/
             if (scope.VAL_RES_TIR_RES2 == 1) {
                 scope.toast('success','El IBAN que introdujo es correcto','IBAN');
                 scope.numIBanValidado = true;
             } else {
                 scope.toast('error','El IBAN que introdujo es incorrecto, verifique e intente de nuevo','Error');
                 scope.numIBanValidado = false;
             }
         } else {
             scope.numIBanValidado = false;
         }
     }
     $scope.submitFormRegistroCuentaBanca = function(event) {
         scope.tgribBancos.CodBan=null;
         scope.tgribBancos.NumIBan = scope.CodEur + '' + scope.IBAN1 + '' + scope.IBAN2 + '' + scope.IBAN3 + '' + scope.IBAN4 + '' + scope.IBAN5;
         var url = base_urlHome() + "api/Dashboard/Comprobar_Cuenta_Bancaria/";
         $http.post(url, scope.tgribBancos).then(function(result) {
             if (result.data == true) {
                 scope.toast('error','La Cuenta Bancaria ya se encuentra registrada','Error');
                 scope.numIBanValidado = false;
                 return false;
             } else {
                 if (scope.tgribBancos.CodCueBan > 0) {
                     var title = 'Actualizando';
                     var text = '¿Seguro que desea modificar la información de la Cuenta Bancaria?';
                     var response = "Cuenta Bancaria actualizada de forma correcta";
                 }
                 if (scope.tgribBancos.CodCueBan == undefined) {
                     var title = 'Guardando';
                     var text = '¿Seguro que desea registrar la Cuenta Bancaria?';
                     var response = "Cuenta Bancaria creada de forma correcta";
                 }
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
                         
                         $("#" + title).removeClass("loader loader-default").addClass("loader loader-default  is-active");
                         var url = base_urlHome() + "api/Dashboard/crear_cuenta_bancaria/";
                         $http.post(url, scope.tgribBancos).then(function(result) {
                             scope.tgribBancos = result.data;
                             if (result.data != false) {
                                 $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
                                 scope.toast('success',response,title);
                                 scope.numIBanValidado = false;
                                 $('#modal_agregarCuentasBancarias').modal('hide');  
                                 scope.view_information();
                             } else {
                                 $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
                                 scope.toast('error','Hubo un error al ejecutar esta acción por favor intente nuevamente.','Error');
                                 scope.numIBanValidado = false;
                                 scope.view_information();
                             }
                         }, function(error) {
                             $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
                             scope.numIBanValidado = false;

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

                     } else {
                         event.preventDefault();
                         scope.numIBanValidado = false;
                         scope.view_information();
                         console.log('Cancelando ando...');
                     }
                 });
             } //end else////
         }, function(error) {
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




///////////////////////////////// PARA CUENTAS BAMCARIAS DASHBOARD END //////////////////////////////////






///////////////////////////////////// PARA DOCUMENTOS DASHBOARD START //////////////////////////////////////////////////
$scope.submitFormRegistroDocumentos = function(event) 
{  
  if (!scope.validar_campos_documentos_null()) {
            return false;
        }
        if (scope.fagregar_documentos.CodTipDocAI > 0) {
            var title = 'Actualizando';
            var text = '¿Seguro que desea modificar la información del Documento?';
            var response = "Documento actualizado de forma correcta";
        }
        if (scope.fagregar_documentos.CodTipDocAI == undefined) {
            var title = 'Guardando';
            var text = '¿Seguro que desea registrar el Documento?';
            var response = "Documento registrado de forma correcta";
        }
        Swal.fire({
            title: title,
            text: text,
            type: "info",
            showCancelButton: !0,
            confirmButtonColor: "#31ce77",
            cancelButtonColor: "#f34943",
            confirmButtonText: "Confirmar"
        }).then(function(t) {
            if (t.value == true) {                
                
                
                $("#" + title).removeClass("loader loader-default").addClass("loader loader-default is-active");
                var url = base_urlHome() + "api/Dashboard/Registrar_Documentos";
                $http.post(url, scope.fagregar_documentos).then(function(result) {

                    $("#" + title).removeClass("loader loader-default is-active").addClass("loader loader-default");
                    if (result.data != false) {

                        scope.toast('success',response,title);
                        scope.fagregar_documentos = result.data; 
                        $('#modal_agregarDocumentos').modal('hide');                       
                        console.log(result.data);
                        scope.view_information();
                    } else {
                        scope.toast('error','Error en el proceso intente nuevamente.','Error');                        
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
            } else {
                event.preventDefault();
                console.log('Cancelando ando...');
            }
        });
    };
    scope.validar_campos_documentos_null = function() {
        resultado = true;
        if (!scope.fagregar_documentos.CodCli > 0) {
            scope.toast('error','Seleccione un Cliente.','');
            return false;
        }
        if (!scope.fagregar_documentos.CodTipDoc > 0) {
            scope.toast('error','Seleccione un Tipo de Documento.','');
           return false;
        }         
        if (scope.fagregar_documentos.DesDoc ==null) {
            scope.toast('error','Debe Seleccionar un Documento.','');
           return false;
        }        

        if (scope.fagregar_documentos.TieVen == 0) {
            scope.toast('error','Indicar si el Documento tiene o no Fecha de Vencimiento.','');
            return false;
        }
        if (scope.fagregar_documentos.TieVen == 1) {

            var FecVenDocAco = document.getElementById("FecVenDocAco").value;
            scope.FecVenDocAco = FecVenDocAco;
            if (scope.FecVenDocAco == undefined) {
                scope.toast('error','Colocar Fecha de Vencimiento con el formato DD/MM/YYYY.','');
                return false;
            } else {
                var FecActDoc = (scope.FecVenDocAco).split("/");
                if (FecActDoc.length < 3) {
                    scope.toast('error','Error en Fecha de Vencimiento, el formato correcto es DD/MM/YYYY.','');
                    event.preventDefault();
                    return false;
                } else {
                    if (FecActDoc[0].length > 2 || FecActDoc[0].length < 2) {
                        scope.toast('error','Error en Día, debe contener dos números.','');
                        event.preventDefault();
                        return false;

                    }
                    if (FecActDoc[1].length > 2 || FecActDoc[1].length < 2) {
                        scope.toast('error','Error en Mes, debe contener dos números.','');
                        event.preventDefault();
                        return false;
                    }
                    if (FecActDoc[2].length < 4 || FecActDoc[2].length > 4) {
                        scope.toast('error','Error en Año, debe contener cuatro números.','');
                        event.preventDefault();
                        return false;
                    }
                    scope.fagregar_documentos.FecVenDocAco = FecActDoc[2] + "/" + FecActDoc[1] + "/" + FecActDoc[0];
                    //scope.tmodal_servicio_especiales.FecIniSerEsp=FecIniSerEsp[0]+"/"+FecIniSerEsp[1]+"/"+FecIniSerEsp[2];          
                }
            }
        }
        if (scope.fagregar_documentos.TieVen == 2) {
            scope.fagregar_documentos.FecVenDocAco = null;
        }
        if (scope.fagregar_documentos.ObsDoc == null || scope.fagregar_documentos.ObsDoc == undefined || scope.fagregar_documentos.ObsDoc == '') {
            scope.fagregar_documentos.ObsDoc = null;
        } else {
            scope.fagregar_documentos.ObsDoc = scope.fagregar_documentos.ObsDoc;
        }
        if (resultado == false) {
            return false;
        }
        return true;
    }
    scope.validarfechadocumento = function(object) {
        if (object != undefined) {
            numero = object;
            if (!/^([/0-9])*$/.test(numero))
                scope.FecVenDocAco = numero.substring(0, numero.length - 1);
        }
    }

/////////////////////////////////// PARA DOCUMENTOS DASHBOARD END ////////////////////////////////////////////////////


   //////////////////////////////////////////////// para mensajes y alertas dinamicas /////////////////////////////////////////////
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