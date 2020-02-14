app.controller('Controlador_Cups', ['$http', '$scope', '$filter','$route','$interval', '$controller','$cookies','$compile','ServiceCups', Controlador]);
function Controlador($http,$scope,$filter,$route,$interval,$controller,$cookies,$compile,ServiceCups)
{
	//declaramos una variable llamada scope donde tendremos a vm
	/*inyectamos un controlador para acceder a sus variables y metodos*/
	//$controller('Controlador_Clientes as vmAE',{$scope:$scope});
	//var testCtrl1ViewModel = $scope.$new(); //You need to supply a scope while instantiating.	
	//$controller('Controlador_Clientes',{$scope : testCtrl1ViewModel });		
	//var testCtrl1ViewModel = $controller('Controlador_Clientes');
   	//testCtrl1ViewModel.cargar_lista_clientes();
	var scope = this;
	scope.fdatos_cups = {};
	scope.fdatos_cups_cups={};	
	scope.CodCups = $route.current.params.CodCups;
	scope.TipServ = $route.current.params.TipServ;
	scope.validate_info= $route.current.params.INF;
	scope.Nivel = $cookies.get('nivel');
	scope.TCups=[];
	scope.TCupsBack=[];
	scope.fdatos_cups.TipServ="0";
	
	var fecha = new Date();
	var dd = fecha.getDate();
	var mm = fecha.getMonth()+1; //January is 0!
	var yyyy = fecha.getFullYear();
	if(dd<10)
	{
		dd='0'+dd 
	} 
	if(mm<10)
	{
		mm='0'+mm
	} 
	var fecha = dd+'/'+mm+'/'+yyyy;
	/*ServiceCups.getAll().then(function(dato) 
	{
		scope.TCups=dato.Cups;
		scope.TCupsBack=dato.Cups;
		
	}).catch(function(err){console.log(err);});	*/
	console.log($route.current.$$route.originalPath);	
	console.log(scope.CodCups);
	console.log(scope.TipServ);
	console.log(scope.Nivel);
	console.log(fecha);
	scope.Cif=true;
	scope.RazSoc=true;
	scope.Cups=true;
	scope.Cups_Ser=true;
	scope.Cups_Tar=true;
	scope.Cups_Acc=true;
	scope.EstCUPs=true;
	scope.ruta_reportes_pdf_cups=0;
	scope.ruta_reportes_excel_cups=0;
	scope.topciones = [{id: 1, nombre: 'EDITAR'},{id: 2, nombre: 'VER'},{id: 3, nombre: 'CONSUMO'},{id: 4, nombre: 'DAR BAJA'},{id: 5, nombre: 'HISTORIAL'}];
	scope.Filtro_CUPs = [{id: 1, nombre: 'TIPO SERVICIO'},{id: 2, nombre: 'TARIFA'},{id: 3, nombre: 'ESTATUS'}];
	
	scope.cargar_lista_cups=function()
	{
		$("#cargando").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active" );
		var url = base_urlHome()+"api/Cups/get_all_cups_PumSum/";
		$http.get(url).then(function(result)
		{
			$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );			
			if(result.data.Cups!=false)
			{
				$scope.predicate = 'id';  
				$scope.reverse = true;						
				$scope.currentPage = 1;  
				$scope.order = function (predicate) 
				{  
					$scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;  
					$scope.predicate = predicate;  
				};	
				scope.TCups=result.data.Cups;
				scope.TCupsBack=result.data.Cups;
				$scope.totalItems = scope.TCups.length; 
				$scope.numPerPage = 50;  
				$scope.paginate = function (value) 
				{  
					var begin, end, index;  
					begin = ($scope.currentPage - 1) * $scope.numPerPage;  
					end = begin + $scope.numPerPage;  
					index = scope.TCups.indexOf(value);  
					return (begin <= index && index < end);  
				};
				scope.fecha_server=result.data.Fecha;
			}
			else
			{
				Swal.fire({title:"Cups",text:"No se Encontraron Cups Registrados.",type:"error",confirmButtonColor:"#188ae2"});				
				scope.disabled_button_add_punt=false;
				scope.TCups=[];
				scope.TCupsBack=[];	
			}
		},function(error)
		{
			$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
			if(error.status==404 && error.statusText=="Not Found")
			{
				Swal.fire({title:"Error 404",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				Swal.fire({title:"Error 401",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				Swal.fire({title:"Error 403",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{
				Swal.fire({title:"Error 500",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
			}

		});
		
	}

	scope.agregar_cups=function()
	{
		location.href="#/Add_Cups";
		scope.fdatos_cups_cups.TipServ=0;
	}

scope.validar_opcion_cups=function(index,opciones_cups,dato)
{
	console.log(index);
	console.log(opciones_cups);
	console.log(dato);
	scope.opciones_cups[index]=undefined;
	if(opciones_cups==1)
	{
		location.href="#/Edit_Cups/"+dato.CodCupGas+"/"+dato.TipServ;
	}
	if(opciones_cups==2)
	{
		location.href="#/Edit_Cups/"+dato.CodCupGas+"/"+dato.TipServ+"/"+1;
	}
	if(opciones_cups==3)
	{
		location.href="#/Consumo_CUPs/"+dato.CodCupGas+"/"+dato.TipServ+"/"+dato.CodPunSum;
	}

	if(opciones_cups==4)
	{
		if(dato.EstCUPs=="DADO DE BAJA")
		{
			Swal.fire({title:"Error",text:"El CUPs Ya Fue Dado de Baja.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		var url=base_urlHome()+"api/Cups/list_motivos_bloqueo_CUPs";
		$http.get(url).then(function(result)
		{
			if(result.data!=false)
			{
				$("#modal_motivo_bloqueo").modal('show');
				scope.tMotivosBloqueos=result.data;
				scope.tmodal_data={};
				scope.tmodal_data.FecBaj=scope.fecha_server;
				scope.tmodal_data.TipServ=dato.TipServ;
				scope.CupsNom =dato.CupsGas;
				scope.NumCifCUPs =dato.Cups_Cif;
				scope.RazSocCUPs =dato.Cups_RazSocCli;
				scope.DirPunSumCUPs = dato.TipVia+" "+dato.NomViaPunSum+" "+dato.NumViaPunSum+" "+dato.BloPunSum+" "+dato.EscPunSum+" "+dato.PlaPunSum+" "+dato.PuePunSum+" "+dato.DesPro+" "+dato.DesLoc+" "+dato.CPLoc;                    //dato.Cups_Dir;
				scope.tmodal_data.CodCUPs=dato.CodCupGas;
			}
			else
			{
				Swal.fire({title:"Información",text:"No se encontraron motivos de bloqueos registrados, contacte un administrador y notifiquelo.",type:"info",confirmButtonColor:"#188ae2"});
			}

		},function(error)
		{
			$("#cargandos_cups").removeClass( "loader loader-defaul is-active" ).addClass( "loader loader-default" );
	        if(error.status==404 && error.statusText=="Not Found")
			{
				Swal.fire({title:"Error 404",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				Swal.fire({title:"Error 401",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				Swal.fire({title:"Error 403",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{
				Swal.fire({title:"Error 500",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
			}
		});
	}



	/*if(opciones_cups==2)
	{
		scope.validate_info=1;		
		if(dato.TipServ=="Eléctrico")
		{		
			$("#cargandos_cups").removeClass( "loader loader-defaul").addClass( "loader loader-default is-active");
			var url = base_urlHome()+"api/Cups/Buscar_XID_Servicio/TipServ/"+1+"/CodCup/"+dato.CodCupGas;
			$http.get(url).then(function(result)
			{
				$("#cargandos_cups").removeClass( "loader loader-defaul is-active").addClass("loader loader-default");
				if(result.data!=false)
				{
					scope.fdatos_cups_cups=result.data;
					scope.TVistaCups=false;
					scope.por_servicios(1);
					console.log(result.data);
				}
				else
				{
					Swal.fire({title:"Error",text:"No se encontraron datos intente nuevamente.",type:"error",confirmButtonColor:"#188ae2"});
					scope.fdatos_cups_cups={};
					scope.TVistaCups=true;
				}

			},function(error)
			{
				$("#cargandos_cups").removeClass( "loader loader-defaul is-active" ).addClass( "loader loader-default" );
	            if(error.status==404 && error.statusText=="Not Found")
				{
					Swal.fire({title:"Error 404",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
				}
				if(error.status==401 && error.statusText=="Unauthorized")
				{
					Swal.fire({title:"Error 401",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
				}
				if(error.status==403 && error.statusText=="Forbidden")
				{
					Swal.fire({title:"Error 403",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
				}
				if(error.status==500 && error.statusText=="Internal Server Error")
				{
					Swal.fire({title:"Error 500",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
				}


			});

		}
		if(dato.TipServ=="Gas")
		{
			$("#cargandos_cups").removeClass( "loader loader-defaul").addClass( "loader loader-default is-active");
			var url = base_urlHome()+"api/Cups/Buscar_XID_Servicio/TipServ/"+2+"/CodCup/"+dato.CodCupGas;
			$http.get(url).then(function(result)
			{
				$("#cargandos_cups").removeClass( "loader loader-defaul is-active").addClass("loader loader-default");
				if(result.data!=false)
				{
					scope.fdatos_cups_cups=result.data;
					scope.TVistaCups=false;
					scope.por_servicios(2);
					console.log(result.data);
				}
				else
				{
					Swal.fire({title:"Error",text:"No se encontraron datos intente nuevamente.",type:"error",confirmButtonColor:"#188ae2"});
					scope.fdatos_cups_cups={};
					scope.TVistaCups=true;
				}
			},function(error)
			{
				$("#cargandos_cups").removeClass( "loader loader-defaul is-active" ).addClass( "loader loader-default" );
	            if(error.status==404 && error.statusText=="Not Found")
				{
					Swal.fire({title:"Error 404",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
				}
				if(error.status==401 && error.statusText=="Unauthorized")
				{
					Swal.fire({title:"Error 401",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
				}
				if(error.status==403 && error.statusText=="Forbidden")
				{
					Swal.fire({title:"Error 403",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
				}
				if(error.status==500 && error.statusText=="Internal Server Error")
				{
					Swal.fire({title:"Error 500",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
				}
			});
		}
		
	}
	
	
	if(opciones_cups==5)
	{
		//$("#modal_motivo_bloqueo").modal('show');
		scope.TVistaCups=undefined;
		scope.historial={};
		scope.historial.CodCup=dato.CodCupGas;
		scope.historial.TipServ=dato.TipServ;
		console.log(scope.TVistaCups);
		scope.T_Historial_Consumo=[];
		scope.FecIniConHis=true;
		scope.FecFinConHis=true;
		scope.ConCupHis=true;
	}*/
}
scope.regresar_cups=function()
{
	
	if(scope.validate_info==undefined)
	{
		if(scope.fdatos_cups.CodCup==undefined)
		{
			var title="Confirmar";
			var text ="Estás seguro de regresar y no guardar los datos?";
		}
		else
		{
			var title="Confirmar";
			var text ="Estás seguro de regresar y no actualizar los datos?";
		}
		Swal.fire({title:title,text:text,			
		type:"question",
		showCancelButton:!0,
		confirmButtonColor:"#31ce77",
		cancelButtonColor:"#f34943",
		confirmButtonText:"OK"}).then(function(t)
		{
			if(t.value==true)
		    {
		        location.href="#/Gestionar_Cups";
		    }
		    else
		    {
		        console.log('Cancelando ando...');
		    }
		});	
	}
	else
	{
		location.href="#/Gestionar_Cups";
	}    
}
	scope.validar_fecha_inputs=function(metodo,object)
{
	if(metodo==1)
	{	
		if(object!=undefined)
		{
			numero=object;		
			if(!/^([/0-9])*$/.test(numero))
			scope.fdatos_cups.FecAltCup=numero.substring(0,numero.length-1);
		}
	}
	if(metodo==2)
	{	
		if(object!=undefined)
		{
			numero=object;		
			if(!/^([/0-9])*$/.test(numero))
			scope.fdatos_cups.FecUltLec=numero.substring(0,numero.length-1);
		}
	}
	if(metodo==3)
	{	
		if(object!=undefined)
		{
			numero=object;		
			if(!/^([.0-9])*$/.test(numero))
			scope.fdatos_cups.ConAnuCup=numero.substring(0,numero.length-1);
		}
	}
	if(metodo==4)
	{	
		if(object!=undefined)
		{
			numero=object;		
			if(!/^([.0-9])*$/.test(numero))
			scope.fdatos_cups.PotConP1=numero.substring(0,numero.length-1);
		}
	}
	if(metodo==5)
	{	
		if(object!=undefined)
		{
			numero=object;		
			if(!/^([.0-9])*$/.test(numero))
			scope.fdatos_cups.PotConP2=numero.substring(0,numero.length-1);
		}
	}
	if(metodo==6)
	{	
		if(object!=undefined)
		{
			numero=object;		
			if(!/^([.0-9])*$/.test(numero))
			scope.fdatos_cups.PotConP3=numero.substring(0,numero.length-1);
		}
	}
	if(metodo==7)
	{	
		if(object!=undefined)
		{
			numero=object;		
			if(!/^([.0-9])*$/.test(numero))
			scope.fdatos_cups.PotConP4=numero.substring(0,numero.length-1);
		}
	}
	if(metodo==8)
	{	
		if(object!=undefined)
		{
			numero=object;		
			if(!/^([.0-9])*$/.test(numero))
			scope.fdatos_cups.PotConP5=numero.substring(0,numero.length-1);
		}
	}
	if(metodo==9)
	{	
		if(object!=undefined)
		{
			numero=object;		
			if(!/^([.0-9])*$/.test(numero))
			scope.fdatos_cups.PotConP6=numero.substring(0,numero.length-1);
		}
	}
	if(metodo==10)
	{	
		if(object!=undefined)
		{
			numero=object;		
			if(!/^([.0-9])*$/.test(numero))
			scope.fdatos_cups.PotMaxBie=numero.substring(0,numero.length-1);
		}
	}

	if(metodo==20)
	{	
		if(object!=undefined)
		{
			numero=object;		
			if(!/^([/0-9])*$/.test(numero))
			scope.historial.desde=numero.substring(0,numero.length-1);
		}
	}

	if(metodo==21)
	{	
		if(object!=undefined)
		{
			numero=object;		
			if(!/^([/0-9])*$/.test(numero))
			scope.historial.hasta=numero.substring(0,numero.length-1);
		}
	}
	if(metodo==22)
	{	
		if(object!=undefined)
		{
			numero=object;		
			if(!/^([/0-9])*$/.test(numero))
			scope.tmodal_data.FecBaj=numero.substring(0,numero.length-1);
		}
	}	
}
$scope.submitFormlockCUPs = function(event) 
{ 
	console.log(scope.tmodal_data);	
	if(scope.tmodal_data.ObsMotCUPs==undefined || scope.tmodal_data.ObsMotCUPs==null || scope.tmodal_data.ObsMotCUPs=='') 
	{
		scope.tmodal_data.ObsMotCUPs=null;
	}	
	else
	{
		scope.tmodal_data.ObsMotCUPs=scope.tmodal_data.ObsMotCUPs;
	}
	if(scope.tmodal_data.FecBaj==undefined || scope.tmodal_data.FecBaj==null || scope.tmodal_data.FecBaj=='') 
	{
		Swal.fire({text:"El Campo Fecha de Bloqueo no puede estar vacio.",type:"error",confirmButtonColor:"#188ae2"});
		event.preventDefault();	
		return false;
	}	
	else
	{
		var FecBaj= (scope.tmodal_data.FecBaj).split("/");
		if(FecBaj.length<3)
		{
			Swal.fire({text:"El Formato de Fecha de Bloqueo debe Ser EJ: "+scope.fecha_server,type:"error",confirmButtonColor:"#188ae2"});
			event.preventDefault();	
			return false;
		}
		else
		{		
			if(FecBaj[0].length>2 || FecBaj[0].length<2)
			{
				Swal.fire({text:"Por Favor Corrija el Formato del dia en la Fecha de Bloqueo deben ser 2 números solamente. EJ: 01",type:"error",confirmButtonColor:"#188ae2"});
				event.preventDefault();	
				return false;
				}
			if(FecBaj[1].length>2 || FecBaj[1].length<2)
			{
				Swal.fire({text:"Por Favor Corrija el Formato del mes de la Fecha de Bloqueo deben ser 2 números solamente. EJ: 01",type:"error",confirmButtonColor:"#188ae2"});
				event.preventDefault();	
				return false;
			}
			if(FecBaj[2].length<4 || FecBaj[2].length>4)
			{
				Swal.fire({text:"Por Favor Corrija el Formato del ano en la Fecha de Bloqueo Ya que deben ser 4 números solamente. EJ: 1999",type:"error",confirmButtonColor:"#188ae2"});
				event.preventDefault();	
				return false;
			}
			valuesStart=scope.tmodal_data.FecBaj.split("/");
	        valuesEnd=scope.fecha_server.split("/"); 
	        // Verificamos que la fecha no sea posterior a la actual
	        var dateStart=new Date(valuesStart[2],(valuesStart[1]-1),valuesStart[0]);
	        var dateEnd=new Date(valuesEnd[2],(valuesEnd[1]-1),valuesEnd[0]);
	        if(dateStart>dateEnd)
	        {
	            Swal.fire({text:"La Fecha de Bloqueo no puede ser mayor al "+scope.fecha_server+" Por Favor Verifique he intente nuevamente.",type:"error",confirmButtonColor:"#188ae2"});					
	            return false;
	        }			
		}
	}
		Swal.fire({title:'Dar Baja CUPs',
		text:'Esta Seguro Dar de Baja Este CUPs',
		type:"question",
		showCancelButton:!0,
		confirmButtonColor:"#31ce77",
		cancelButtonColor:"#f34943",
		confirmButtonText:"Dar de Baja"}).then(function(t)
		{
	        if(t.value==true)
	        { 
	        	$("#Baja").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active" );
	            var url = base_urlHome()+"api/Cups/Dar_Baja_Cups/";
	            $http.post(url,scope.tmodal_data).then(function(result)
	            {
	            	$("#Baja").removeClass( "loader loader-default is-active").addClass( "loader loader-default");
	            	if(result.data!=false)
	            	{
	            		Swal.fire({title:'CUPs',text:'El CUPs ha sido dado de baja correctamente.',type:"success",confirmButtonColor:"#188ae2"});
	            		scope.tmodal_data={};
	            		$("#modal_motivo_bloqueo").modal('hide');
	            		scope.cargar_lista_cups();
	            	}
	            	else
	            	{
	            		Swal.fire({title:"Error",text:"Error en la operación por favor intente nuevamente.",type:"error",confirmButtonColor:"#188ae2"});
	            		scope.cargar_lista_cups();
	            	}
	            },function(error)
	            {
	            	$("#Baja").removeClass( "loader loader-defaul is-active" ).addClass( "loader loader-default" );
	            	if(error.status==404 && error.statusText=="Not Found")
					{
						Swal.fire({title:"Error 404",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
					}
					if(error.status==401 && error.statusText=="Unauthorized")
					{
						Swal.fire({title:"Error 401",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
					}
					if(error.status==403 && error.statusText=="Forbidden")
					{
						Swal.fire({title:"Error 403",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
					}
					if(error.status==500 && error.statusText=="Internal Server Error")
					{
						Swal.fire({title:"Error 500",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
					}

	            });
	        }
	        else
	        {
				event.preventDefault();							
	        }
	    });		
	};
	scope.por_servicios=function(objecto)
	{
		if(scope.fdatos_cups.CodCup>0 && scope.fdatos_cups.TipServ!=scope.fdatos_cups.TipServAnt)
		{
			scope.fdatos_cups.PotConP1=null;
			scope.fdatos_cups.PotConP2=null;
			scope.fdatos_cups.PotConP3=null;
			scope.fdatos_cups.PotConP4=null;
			scope.fdatos_cups.PotConP5=null;
			scope.fdatos_cups.PotConP6=null;
			scope.fdatos_cups.PotMaxBie=null;
			scope.fdatos_cups.CodDis=null;
			scope.fdatos_cups.CodTar=null;
			scope.fdatos_cups.FecAltCup=null;
			scope.fdatos_cups.FecUltLec=null;
			scope.fdatos_cups.ConAnuCup=null;
		}
		if(scope.fdatos_cups.CodCup==undefined && scope.fdatos_cups.TipServAnt==undefined)
		{
			scope.fdatos_cups.PotConP1=null;
			scope.fdatos_cups.PotConP2=null;
			scope.fdatos_cups.PotConP3=null;
			scope.fdatos_cups.PotConP4=null;
			scope.fdatos_cups.PotConP5=null;
			scope.fdatos_cups.PotConP6=null;
			scope.fdatos_cups.PotMaxBie=null;
			scope.fdatos_cups.CodDis=null;
			scope.fdatos_cups.CodTar=null;
			scope.fdatos_cups.FecAltCup=null;
			scope.fdatos_cups.FecUltLec=null;
			scope.fdatos_cups.ConAnuCup=null;
		}
		scope.sin_data=1;
		if(objecto==1)
		{			
			var url=base_urlHome()+"api/Cups/Por_Servicios";
			$http.post(url,scope.fdatos_cups).then(function(result)
			{
				if(result.data!=false)
				{
					scope.T_Distribuidoras=result.data.Distribuidoras;
					scope.T_Tarifas=result.data.Tarifas;
					scope.sin_data=0;
				}
				else
				{
					Swal.fire({title:"Error",text:"No se encontraron datos registrados.",type:"info",confirmButtonColor:"#188ae2"});
					scope.sin_data=1;	
				}

			},function(error)
			{
				if(error.status==404 && error.statusText=="Not Found")
				{
					Swal.fire({title:"Error 404",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
				}
				if(error.status==401 && error.statusText=="Unauthorized")
				{
					Swal.fire({title:"Error 401",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
				}
				if(error.status==403 && error.statusText=="Forbidden")
				{
					Swal.fire({title:"Error 403",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
				}
				if(error.status==500 && error.statusText=="Internal Server Error")
				{
					Swal.fire({title:"Error 500",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
				}
			});
		}
		if(objecto==2)
		{		
			var url=base_urlHome()+"api/Cups/Por_Servicios";
			$http.post(url,scope.fdatos_cups).then(function(result)
			{
				if(result.data!=false)
				{					
					scope.T_Distribuidoras=result.data.Distribuidoras;
					scope.T_Tarifas=result.data.Tarifas;
					scope.sin_data=0;
				}
				else
				{
					Swal.fire({title:"Error",text:"No se encontraron datos registrados.",type:"info",confirmButtonColor:"#188ae2"});
					scope.sin_data=1;	
				}

			},function(error)
			{
				if(error.status==404 && error.statusText=="Not Found")
				{
					Swal.fire({title:"Error 404",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
				}
				if(error.status==401 && error.statusText=="Unauthorized")
				{
					Swal.fire({title:"Error 401",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
				}
				if(error.status==403 && error.statusText=="Forbidden")
				{
					Swal.fire({title:"Error 403",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
				}
				if(error.status==500 && error.statusText=="Internal Server Error")
				{
					Swal.fire({title:"Error 500",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
				}
			});
		}
	}
	scope.BuscarxIDCups=function()
	{
		if(scope.TipServ=="Eléctrico")
		{		
			$("#cargandos_cups").removeClass( "loader loader-defaul").addClass( "loader loader-default is-active");
			var url = base_urlHome()+"api/Cups/Buscar_XID_Servicio/TipServ/"+1+"/CodCup/"+scope.CodCups;
			$http.get(url).then(function(result)
			{
				$("#cargandos_cups").removeClass( "loader loader-defaul is-active").addClass("loader loader-default");
				if(result.data!=false)
				{
					scope.fdatos_cups=result.data;
					//scope.TVistaCups=false;
					scope.por_servicios(1);
					console.log(result.data);
				}
				else
				{
					Swal.fire({title:"Error",text:"No se encontraron datos intente nuevamente.",type:"error",confirmButtonColor:"#188ae2"});
					scope.fdatos_cups={};
					//scope.TVistaCups=true;
				}
			},function(error)
			{
				$("#cargandos_cups").removeClass( "loader loader-defaul is-active" ).addClass( "loader loader-default" );
	            if(error.status==404 && error.statusText=="Not Found")
				{
					Swal.fire({title:"Error 404",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
				}
				if(error.status==401 && error.statusText=="Unauthorized")
				{
					Swal.fire({title:"Error 401",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
				}
				if(error.status==403 && error.statusText=="Forbidden")
				{
					Swal.fire({title:"Error 403",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
				}
				if(error.status==500 && error.statusText=="Internal Server Error")
				{
					Swal.fire({title:"Error 500",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
				}
			});
		}
		if(scope.TipServ=="Gas")
		{
			$("#cargandos_cups").removeClass( "loader loader-defaul").addClass( "loader loader-default is-active");
			var url = base_urlHome()+"api/Cups/Buscar_XID_Servicio/TipServ/"+2+"/CodCup/"+scope.CodCups;
			$http.get(url).then(function(result)
			{
				$("#cargandos_cups").removeClass( "loader loader-defaul is-active").addClass("loader loader-default");
				if(result.data!=false)
				{
					scope.fdatos_cups=result.data;
					//scope.TVistaCups=false;
					scope.por_servicios(2);
					console.log(result.data);
				}
				else
				{
					Swal.fire({title:"Error",text:"No se encontraron datos intente nuevamente.",type:"error",confirmButtonColor:"#188ae2"});
					scope.fdatos_cups={};
					//scope.TVistaCups=true;
				}
			},function(error)
			{
				$("#cargandos_cups").removeClass( "loader loader-defaul is-active" ).addClass( "loader loader-default" );
	            if(error.status==404 && error.statusText=="Not Found")
				{
					Swal.fire({title:"Error 404",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
				}
				if(error.status==401 && error.statusText=="Unauthorized")
				{
					Swal.fire({title:"Error 401",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
				}
				if(error.status==403 && error.statusText=="Forbidden")
				{
					Swal.fire({title:"Error 403",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
				}
				if(error.status==500 && error.statusText=="Internal Server Error")
				{
					Swal.fire({title:"Error 500",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
				}
			});
		}

	}
	scope.search_PunSum=function()
	{
		var url = base_urlHome()+"api/Cups/search_PunSum_Data";
		$http.get(url).then(function(result)
		{
			if(result.data!=false)
			{
				scope.T_PuntoSuministros=result.data;
			}
			else
			{
				Swal.fire({title:"Error",text:"No Se Encontraron Puntos de Suministros Registrados",type:"error",confirmButtonColor:"#188ae2"});				
			}
		},function(error)
		{
			$("#cargandos_cups").removeClass( "loader loader-defaul is-active" ).addClass( "loader loader-default" );
	        if(error.status==404 && error.statusText=="Not Found")
			{
				Swal.fire({title:"Error 404",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				Swal.fire({title:"Error 401",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				Swal.fire({title:"Error 403",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{
				Swal.fire({title:"Error 500",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
			}
		});
	}
	if($route.current.$$route.originalPath=="/Add_Cups/")
	{
		scope.search_PunSum();
	}
	$scope.submitFormCups = function(event) 
	{      
	 	//scope.fdatos_cups.CodPunSum=scope.CodPunSum;
	 	console.log(scope.fdatos_cups);
	 	if (!scope.validar_campos_cups())
		{
			return false;
		}
		if(scope.fdatos_cups.CodCup>0)
		{
			var title='Actualizando';
			var text='¿Esta Seguro de Actualizar Este CUPs?';
			var response="CUPs modificado satisfactoriamente";
		}
		if(scope.fdatos_cups.CodCup==undefined)
		{
			var title='Guardando';
			var text='¿Esta Seguro de Incluir Un Nuevo CUPs?';
			var response="CUPs creado satisfactoriamente.";
		}
		Swal.fire({title:title,
		text:text,
		type:"question",
		showCancelButton:!0,
		confirmButtonColor:"#31ce77",
		cancelButtonColor:"#f34943",
		confirmButtonText:"SI"}).then(function(t)
		{
	        if(t.value==true)
	        { 
	        	$("#"+title).removeClass( "loader loader-default" ).addClass( "loader loader-default is-active" );
	            var url = base_urlHome()+"api/Cups/Registrar_Cups/";
	            $http.post(url,scope.fdatos_cups).then(function(result)
	            {
	            	$("#"+title).removeClass( "loader loader-default is-active").addClass( "loader loader-default");
	            	if(result.data!=false)
	            	{
	            		scope.fdatos_cups=result.data;
	            		Swal.fire({title:title,text:response,type:"success",confirmButtonColor:"#188ae2"});

	            	}
	            	else
	            	{
	            		Swal.fire({title:"Error",text:"Error en la operación por favor intente nuevamente.",type:"error",confirmButtonColor:"#188ae2"});
	            	}

	            },function(error)
	            {
	            	$("#"+title).removeClass( "loader loader-defaul is-active" ).addClass( "loader loader-default" );
	            	if(error.status==404 && error.statusText=="Not Found")
					{
						Swal.fire({title:"Error 404",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
					}
					if(error.status==401 && error.statusText=="Unauthorized")
					{
						Swal.fire({title:"Error 401",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
					}
					if(error.status==403 && error.statusText=="Forbidden")
					{
						Swal.fire({title:"Error 403",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
					}
					if(error.status==500 && error.statusText=="Internal Server Error")
					{
						Swal.fire({title:"Error 500",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
					}

	            });
	        }
	        else
	        {
				event.preventDefault();							
	        }
	    });		
	};
	scope.validar_campos_cups = function()
{
	resultado = true;	
	if (!scope.fdatos_cups.CodPunSum>0)
	{
		Swal.fire({title:"Debe seleccionar un punto de suministro de la lista.",type:"error",confirmButtonColor:"#188ae2"});
		return false;
	}
	if (scope.fdatos_cups.cups==null || scope.fdatos_cups.cups==undefined || scope.fdatos_cups.cups=='')
	{
		Swal.fire({title:"El Campo CUPs es Requerido.",type:"error",confirmButtonColor:"#188ae2"});
		return false;
	}
	else
	{
		if(scope.fdatos_cups.cups.length<2)
		{
			Swal.fire({title:"El Campo CUPs Debe Contener 2 Letras o Números.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
	}	
	if (scope.fdatos_cups.cups1==null || scope.fdatos_cups.cups1==undefined || scope.fdatos_cups.cups1=='')
	{
		Swal.fire({title:"El Campo CUPs 1 es Requerido.",type:"error",confirmButtonColor:"#188ae2"});
		return false;
	}
	else
	{
		if(scope.fdatos_cups.cups1.length<16)
		{
			Swal.fire({title:"El Campo CUPs Debe Contener 16 Letras o Números.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
	}	
	if (scope.fdatos_cups.cups2==null || scope.fdatos_cups.cups2==undefined || scope.fdatos_cups.cups2=='')
	{
		Swal.fire({title:"El Campo CUPs 2 es Requerido.",type:"error",confirmButtonColor:"#188ae2"});
		return false;
	}
	else
	{
		if(scope.fdatos_cups.cups2.length<2)
		{
			Swal.fire({title:"El Campo CUPs Debe Contener 2 Letras o Números.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
	}
	if(scope.fdatos_cups.TipServ==0)
	{
		Swal.fire({title:"Debe Seleccionar un Tipo de Servicio.",type:"error",confirmButtonColor:"#188ae2"});
		return false;
	}

	if(scope.fdatos_cups.TipServ==1)
	{
		if (!scope.fdatos_cups.CodDis > 0)
		{
			Swal.fire({title:"Debe Seleccionar una Distribuidora Eléctrica de la lista.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (!scope.fdatos_cups.CodTar > 0)
		{
			Swal.fire({title:"Debe Seleccionar una Tarifa de Eléctrica la lista.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		
		if (scope.fdatos_cups.PotConP1==null || scope.fdatos_cups.PotConP1==undefined || scope.fdatos_cups.PotConP1=='')
		{
			Swal.fire({title:"El Campo P1 Es Requerido.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (scope.fdatos_cups.PotConP2==null || scope.fdatos_cups.PotConP2==undefined || scope.fdatos_cups.PotConP2=='')
		{
			Swal.fire({title:"El Campo P2 Es Requerido.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (scope.fdatos_cups.PotConP3==null || scope.fdatos_cups.PotConP3==undefined || scope.fdatos_cups.PotConP3=='')
		{
			Swal.fire({title:"El Campo P3 Es Requerido.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (scope.fdatos_cups.PotConP4==null || scope.fdatos_cups.PotConP4==undefined || scope.fdatos_cups.PotConP4=='')
		{
			Swal.fire({title:"El Campo P4 Es Requerido.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (scope.fdatos_cups.PotConP5==null || scope.fdatos_cups.PotConP5==undefined || scope.fdatos_cups.PotConP5=='')
		{
			Swal.fire({title:"El CampoP5 Es Requerido.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (scope.fdatos_cups.PotConP6==null || scope.fdatos_cups.PotConP6==undefined || scope.fdatos_cups.PotConP6=='')
		{
			Swal.fire({title:"El Campo P6 Es Requerido.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (scope.fdatos_cups.PotMaxBie==null || scope.fdatos_cups.PotMaxBie==undefined || scope.fdatos_cups.PotMaxBie=='')
		{
			Swal.fire({title:"El Campo Potencia Máxima Es Requerido.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (scope.fdatos_cups.FecAltCup==null || scope.fdatos_cups.FecAltCup==undefined || scope.fdatos_cups.FecAltCup=='')
		{
			Swal.fire({title:"El Campo Fecha de Alta Es Requerido.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		else
		{
			var FecAltCup= (scope.fdatos_cups.FecAltCup).split("/");
			if(FecAltCup.length<3)
			{
				Swal.fire({text:"El Formato de Fecha de Alta debe Ser EJ: DD/MM/YYYY.",type:"error",confirmButtonColor:"#188ae2"});
				//event.preventDefault();	
				return false;
			}
			else
			{		
				if(FecAltCup[0].length>2 || FecAltCup[0].length<2)
				{
					Swal.fire({text:"Por Favor Corrija el Formato del dia deben ser 2 números solamente. EJ: 01",type:"error",confirmButtonColor:"#188ae2"});
					//event.preventDefault();	
					return false;

				}
				if(FecAltCup[1].length>2 || FecAltCup[1].length<2)
				{
					Swal.fire({text:"Por Favor Corrija el Formato del mes deben ser 2 números solamente. EJ: 01",type:"error",confirmButtonColor:"#188ae2"});
					//event.preventDefault();	
					return false;
				}
				if(FecAltCup[2].length<4 || FecAltCup[2].length>4)
				{
					Swal.fire({text:"Por Favor Corrija el Formato del ano deben ser 4 números solamente. EJ: 1999",type:"error",confirmButtonColor:"#188ae2"});
					//event.preventDefault();	
					return false;
				}
				var h1=new Date();			
				var final = FecAltCup[0]+"/"+FecAltCup[1]+"/"+FecAltCup[2];
				scope.fdatos_cups.FecAltCup=final;
			}

		}
		if (scope.fdatos_cups.FecUltLec==null || scope.fdatos_cups.FecUltLec==undefined || scope.fdatos_cups.FecUltLec=='')
		{
			Swal.fire({title:"El Campo Fecha de Última Lectura es Requerido.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		else
		{
			var FecUltLec= (scope.fdatos_cups.FecUltLec).split("/");
			if(FecUltLec.length<3)
			{
				Swal.fire({text:"El Formato de Fecha Última Lectura debe Ser EJ: DD/MM/YYYY.",type:"error",confirmButtonColor:"#188ae2"});
				//event.preventDefault();	
				return false;
			}
			else
			{		
				if(FecUltLec[0].length>2 || FecUltLec[0].length<2)
				{
					Swal.fire({text:"Por Favor Corrija el Formato del dia deben ser 2 números solamente. EJ: 01",type:"error",confirmButtonColor:"#188ae2"});
					//event.preventDefault();	
					return false;

				}
				if(FecUltLec[1].length>2 || FecUltLec[1].length<2)
				{
					Swal.fire({text:"Por Favor Corrija el Formato del mes deben ser 2 números solamente. EJ: 01",type:"error",confirmButtonColor:"#188ae2"});
					//event.preventDefault();	
					return false;
				}
				if(FecUltLec[2].length<4 || FecUltLec[2].length>4)
				{
					Swal.fire({text:"Por Favor Corrija el Formato del ano deben ser 4 números solamente. EJ: 1999",type:"error",confirmButtonColor:"#188ae2"});
					//event.preventDefault();	
					return false;
				}
				var h1=new Date();			
				var final_UltFec = FecUltLec[0]+"/"+FecUltLec[1]+"/"+FecUltLec[2];
				scope.fdatos_cups.FecUltLec=final_UltFec;
			}
		}
		if (scope.fdatos_cups.ConAnuCup==null || scope.fdatos_cups.ConAnuCup==undefined || scope.fdatos_cups.ConAnuCup=='')
		{
			Swal.fire({title:"El Campo Consumo es Requerido.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
	}
	if(scope.fdatos_cups.TipServ==2)
	{
		if (!scope.fdatos_cups.CodDis > 0)
		{
			Swal.fire({title:"Debe Seleccionar una Distribuidora de Gas de la lista.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (!scope.fdatos_cups.CodTar > 0)
		{
			Swal.fire({title:"Debe Seleccionar una Tarifa de Gas la lista.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (scope.fdatos_cups.FecAltCup==null || scope.fdatos_cups.FecAltCup==undefined || scope.fdatos_cups.FecAltCup=='')
		{
			Swal.fire({title:"El Campo Fecha de Alta Es Requerido.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		else
		{
			var FecAltCup= (scope.fdatos_cups.FecAltCup).split("/");
			if(FecAltCup.length<3)
			{
				Swal.fire({text:"El Formato de Fecha de Alta debe Ser EJ: DD/MM/YYYY.",type:"error",confirmButtonColor:"#188ae2"});
				//event.preventDefault();	
				return false;
			}
			else
			{		
				if(FecAltCup[0].length>2 || FecAltCup[0].length<2)
				{
					Swal.fire({text:"Por Favor Corrija el Formato del dia deben ser 2 números solamente. EJ: 01",type:"error",confirmButtonColor:"#188ae2"});
					//event.preventDefault();	
					return false;

				}
				if(FecAltCup[1].length>2 || FecAltCup[1].length<2)
				{
					Swal.fire({text:"Por Favor Corrija el Formato del mes deben ser 2 números solamente. EJ: 01",type:"error",confirmButtonColor:"#188ae2"});
					//event.preventDefault();	
					return false;
				}
				if(FecAltCup[2].length<4 || FecAltCup[2].length>4)
				{
					Swal.fire({text:"Por Favor Corrija el Formato del ano deben ser 4 números solamente. EJ: 1999",type:"error",confirmButtonColor:"#188ae2"});
					//event.preventDefault();	
					return false;
				}
				var h1=new Date();			
				var final = FecAltCup[0]+"/"+FecAltCup[1]+"/"+FecAltCup[2];
				scope.fdatos_cups.FecAltCup=final;
			}

		}
		if (scope.fdatos_cups.FecUltLec==null || scope.fdatos_cups.FecUltLec==undefined || scope.fdatos_cups.FecUltLec=='')
		{
			Swal.fire({title:"El Campo Fecha de Última Lectura es Requerido.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		else
		{
			var FecUltLec= (scope.fdatos_cups.FecUltLec).split("/");
			if(FecUltLec.length<3)
			{
				Swal.fire({text:"El Formato de Fecha debe Ser EJ: DD/MM/YYYY.",type:"error",confirmButtonColor:"#188ae2"});
				//event.preventDefault();	
				return false;
			}
			else
			{		
				if(FecUltLec[0].length>2 || FecUltLec[0].length<2)
				{
					Swal.fire({text:"Por Favor Corrija el Formato del dia deben ser 2 números solamente. EJ: 01",type:"error",confirmButtonColor:"#188ae2"});
					//event.preventDefault();	
					return false;

				}
				if(FecUltLec[1].length>2 || FecUltLec[1].length<2)
				{
					Swal.fire({text:"Por Favor Corrija el Formato del mes deben ser 2 números solamente. EJ: 01",type:"error",confirmButtonColor:"#188ae2"});
					//event.preventDefault();	
					return false;
				}
				if(FecUltLec[2].length<4 || FecUltLec[2].length>4)
				{
					Swal.fire({text:"Por Favor Corrija el Formato del ano deben ser 4 números solamente. EJ: 1999",type:"error",confirmButtonColor:"#188ae2"});
					//event.preventDefault();	
					return false;
				}
				var h1=new Date();			
				var final_UltFec = FecUltLec[0]+"/"+FecUltLec[1]+"/"+FecUltLec[2];
				scope.fdatos_cups.FecUltLec=final_UltFec;
			}
		}
		if (scope.fdatos_cups.ConAnuCup==null || scope.fdatos_cups.ConAnuCup==undefined || scope.fdatos_cups.ConAnuCup=='')
		{
			Swal.fire({title:"El Campo Consumo es Requerido.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		scope.fdatos_cups.PotConP1=null;
		scope.fdatos_cups.PotConP2=null;
		scope.fdatos_cups.PotConP3=null;
		scope.fdatos_cups.PotConP4=null;
		scope.fdatos_cups.PotConP5=null;
		scope.fdatos_cups.PotConP6=null;
		scope.fdatos_cups.PotMaxBie=null;

	}
	if (resultado == false)
	{
		return false;
	} 
	return true;
}
$scope.SubmitFormFiltrosCUPs = function(event) 
	{      
	 	console.log(scope.tmodal_filtro);
	 	if(scope.tmodal_filtro.tipo_filtro==1)
	 	{
	 		if(!scope.tmodal_filtro.TipServ>0)
	 		{
				Swal.fire({title:"Error",text:"Debe seleccionar un tipo de servicio para aplicar el filtro.",type:"error",confirmButtonColor:"#188ae2"});
	 			return false;
	 		}
	 		$scope.predicate = 'id';  
			$scope.reverse = true;						
			$scope.currentPage = 1;  
			$scope.order = function (predicate) 
			{  
				$scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;  
				$scope.predicate = predicate;  
			};
			scope.TCups= $filter('filter')(scope.TCupsBack, {TipServ: scope.tmodal_filtro.TipServ}, true);							
			$scope.totalItems = scope.TCups.length; 
			$scope.numPerPage = 50;  
			$scope.paginate= function (value) 
			{  
				var begin, end, index;  
				begin = ($scope.currentPage- 1) * $scope.numPerPage;  
				end = begin + $scope.numPerPage;  
				index = scope.TCups.indexOf(value);  
				return (begin <= index && index < end);
			}
			scope.ruta_reportes_pdf_cups=scope.tmodal_filtro.tipo_filtro+"/"+scope.tmodal_filtro.TipServ;
			scope.ruta_reportes_excel_cups=scope.tmodal_filtro.tipo_filtro+"/"+scope.tmodal_filtro.TipServ;
		}
		if(scope.tmodal_filtro.tipo_filtro==2)
	 	{
	 		if(!scope.tmodal_filtro.tipo_tarifa>0)
	 		{
				Swal.fire({title:"Error",text:"Debe seleccionar un tipo de servicio para la tarifa.",type:"error",confirmButtonColor:"#188ae2"});
	 			return false;
	 		}
	 		if(!scope.tmodal_filtro.NomTar>0)
	 		{
				Swal.fire({title:"Error",text:"Debe seleccionar una tarifa de la lista para poder aplicar el filtro.",type:"error",confirmButtonColor:"#188ae2"});
	 			return false;
	 		}

	 		$scope.predicate = 'id';  
			$scope.reverse = true;						
			$scope.currentPage = 1;  
			$scope.order = function (predicate) 
			{  
				$scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;  
				$scope.predicate = predicate;  
			};
			scope.TCups= $filter('filter')(scope.TCupsBack, {NomTarGas: scope.tmodal_filtro.NomTar}, true);							
			$scope.totalItems = scope.TCups.length; 
			$scope.numPerPage = 50;  
			$scope.paginate= function (value) 
			{  
				var begin, end, index;  
				begin = ($scope.currentPage- 1) * $scope.numPerPage;  
				end = begin + $scope.numPerPage;  
				index = scope.TCups.indexOf(value);  
				return (begin <= index && index < end);
			}
			scope.ruta_reportes_pdf_cups=scope.tmodal_filtro.tipo_filtro+"/"+scope.tmodal_filtro.tipo_tarifa+"/"+scope.tmodal_filtro.NomTar;
			scope.ruta_reportes_excel_cups=scope.tmodal_filtro.tipo_filtro+"/"+scope.tmodal_filtro.tipo_tarifa+"/"+scope.tmodal_filtro.NomTar;
		}
		if(scope.tmodal_filtro.tipo_filtro==3)
	 	{
	 		if(!scope.tmodal_filtro.EstCUPs>0)
	 		{
				Swal.fire({title:"Error",text:"Debe seleccionar un Estatus para poder aplicar el filtro.",type:"error",confirmButtonColor:"#188ae2"});
	 			return false;
	 		}
	 		$scope.predicate = 'id';  
			$scope.reverse = true;						
			$scope.currentPage = 1;  
			$scope.order = function (predicate) 
			{  
				$scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;  
				$scope.predicate = predicate;  
			};
			scope.TCups= $filter('filter')(scope.TCupsBack, {EstCUPs: scope.tmodal_filtro.EstCUPs}, true);							
			$scope.totalItems = scope.TCups.length; 
			$scope.numPerPage = 50;  
			$scope.paginate= function (value) 
			{  
				var begin, end, index;  
				begin = ($scope.currentPage- 1) * $scope.numPerPage;  
				end = begin + $scope.numPerPage;  
				index = scope.TCups.indexOf(value);  
				return (begin <= index && index < end);
			}
			scope.ruta_reportes_pdf_cups=scope.tmodal_filtro.tipo_filtro+"/"+scope.tmodal_filtro.EstCUPs;
			scope.ruta_reportes_excel_cups=scope.tmodal_filtro.tipo_filtro+"/"+scope.tmodal_filtro.EstCUPs;
	 	}

					
	};

	scope.regresar_filtro_cups=function()
	{
		
		$scope.predicate = 'id';  
		$scope.reverse = true;						
		$scope.currentPage = 1;  
		$scope.order = function (predicate) 
		{  
			$scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;  
			$scope.predicate = predicate;  
		};

		scope.TCups=scope.TCupsBack;							
		$scope.totalItems = scope.TCups.length; 
		$scope.numPerPage = 50;  
		$scope.paginate= function (value) 
		{  
			var begin, end, index;  
			begin = ($scope.currentPage- 1) * $scope.numPerPage;  
			end = begin + $scope.numPerPage;  
			index = scope.TCups.indexOf(value);  
			return (begin <= index && index < end);
		}
		scope.tmodal_filtro={};
		scope.ruta_reportes_pdf_cups=0;
		scope.ruta_reportes_excel_cups=0;
		scope.result_tar=false;

	}

scope.buscar_tarifa=function()
{
	$scope.predicate = 'id';  
	$scope.reverse = true;						
	$scope.currentPage = 1;  
	$scope.order = function (predicate) 
	{  
		$scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;  
		$scope.predicate = predicate;  
	};
	scope.TCups=scope.TCupsBack;							
	$scope.totalItems = scope.TCups.length; 
	$scope.numPerPage = 50;  
	$scope.paginate= function (value) 
	{  
		var begin, end, index;  
		begin = ($scope.currentPage- 1) * $scope.numPerPage;  
		end = begin + $scope.numPerPage;  
		index = scope.TCups.indexOf(value);  
		return (begin <= index && index < end);
	}
	var url = base_urlHome()+"api/Cups/Buscar_Tarifas/TipServ/"+scope.tmodal_filtro.tipo_tarifa;
	$http.get(url).then(function(result)
	{
		if(result.data!=false)
		{
			scope.result_tar=true;
			scope.T_TarifasFiltros=result.data;	
		}
		else
		{
			Swal.fire({title:"Error",text:"No se encontraron tarifas.",type:"error",confirmButtonColor:"#188ae2"});	
			scope.result_tar=false;			
		}
	},function(error)
	{
		if(error.status==404 && error.statusText=="Not Found")
		{
			Swal.fire({title:"Error 404",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
		}
		if(error.status==401 && error.statusText=="Unauthorized")
		{
			Swal.fire({title:"Error 401",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
		}
		if(error.status==403 && error.statusText=="Forbidden")
		{
			Swal.fire({title:"Error 403",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
		}
		if(error.status==500 && error.statusText=="Internal Server Error")
		{
			Swal.fire({title:"Error 500",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
		}
	});
}

	if(scope.CodCups!=undefined)
	{
		scope.search_PunSum();
		scope.BuscarxIDCups();
	}
	else
	{
		scope.cargar_lista_cups();
	}

}			