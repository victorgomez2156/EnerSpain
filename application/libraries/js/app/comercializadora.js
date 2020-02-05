app.controller('Controlador_Comercializadora', ['$http', '$scope', '$filter','$route','$interval', '$controller','$cookies','ServiceComercializadora','upload', Controlador])
.directive('uploaderModel', ["$parse", function ($parse) 
{
	return {
		restrict: 'A',
		link: function (scope, iElement, iAttrs) 
		{
			iElement.on("change", function(e)
			{
				$parse(iAttrs.uploaderModel).assign(scope, iElement[0].files[0]);
			});
		}
	};
}])
.directive('uploadanexoModel', ["$parse", function ($parse) 
{
	return {
		restrict: 'A',
		link: function (scope, iElement, iAttrs) 
		{
			iElement.on("change", function(e)
			{
				$parse(iAttrs.uploadanexoModel).assign(scope, iElement[0].files[0]);
				//console.log($parse(iAttrs.uploadanexoModel).assign(scope, iElement[0].files[0]));
			});
		}
	};
}])
.service('upload', ["$http", "$q", function ($http, $q) 
{
	this.uploadFile = function(file, name)
	{
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
		.success(function(res)
		{
			deferred.resolve(res);
		})
		.error(function(msg, code)
		{
			deferred.reject(msg);
		})
		return deferred.promise;
	}	
}])
function Controlador($http,$scope,$filter,$route,$interval,$controller,$cookies,ServiceComercializadora,upload)
{
	var scope = this;
	scope.fdatos = {}; // datos del formulario
	scope.nID = $route.current.params.ID;	  //contiene el id del registro en caso de estarse consultando desde la grid
	scope.Nivel = $cookies.get('nivel');
	scope.Tcomercializadoras=undefined;
	scope.TcomercializadorasBack=undefined;
	scope.index=0;
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
	
	console.log($route.current.$$route.originalPath);	
//////////////////////////////////////////////////////////// VISTA PRINCIPAL DE LAS COMERCIALIZADORAS START //////////////////////////////////////////////////////////
		ServiceComercializadora.getAll().then(function(dato) 
		{
			scope.TProvincias = dato.Provincias;
			scope.tLocalidades= dato.Localidades;
			$scope.predicate = 'id';  
			$scope.reverse = true;						
			$scope.currentPage = 1;  
			$scope.order = function (predicate) 
			{  
				$scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;  
				$scope.predicate = predicate;  
			}; 						
			scope.Tcomercializadoras =dato.Comercializadora;
			scope.TcomercializadorasBack =dato.Comercializadora; 	 								
			$scope.totalItems = scope.Tcomercializadoras.length; 
			$scope.numPerPage = 50;  
			$scope.paginate = function (value) 
			{  
				var begin, end, index;  
				begin = ($scope.currentPage - 1) * $scope.numPerPage;  
				end = begin + $scope.numPerPage;  
				index = scope.Tcomercializadoras.indexOf(value);  
				return (begin <= index && index < end);  
			};			
		}).catch(function(error) 
		{
			console.log(error);//Tratar el error
			if(error.status==false && error.error=="This API key does not have access to the requested controller.")
			{
				Swal.fire({title:"Error 401.",text:"Usted No Tiene Acceso al Controlador de Configuraciones Generales.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==false && error.error=="Unknown method.")
			{
				Swal.fire({title:"Error 404.",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==false && error.error=="Unauthorized")
			{
				Swal.fire({title:"Error 401.",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==false && error.error=="Invalid API Key.")
			{
				Swal.fire({title:"Error 403.",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==false && error.error=="Internal Server Error")
			{
				Swal.fire({title:"Error 500",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
			}

		});		


		scope.NumCifCom=true;
		scope.RazSocCom=true;
		scope.TelFijCom=true;
		scope.EstCom=true;
		scope.Acc=true;
		scope.validate_cif==1
		resultado = false;	
		scope.Topciones_comercializadoras = [{id: 4, nombre: 'VER'},{id: 3, nombre: 'EDITAR'},{id: 1, nombre: 'ACTIVAR'},{id: 2, nombre: 'BLOQUEAR'}];
		scope.ttipofiltros = [{id: 1, nombre: 'TIPO DE SERVICIO'},{id: 2, nombre: 'PROVINCIA'},{id: 3, nombre: 'LOCALIDAD'},{id: 4, nombre: 'ESTATUS'}];
		scope.EstComFil = [{id: 1, nombre: 'ACTIVA'},{id: 2, nombre: 'BLOQUEADA'}];
		scope.TipServ= [{id: 1, nom_serv: 'Servicio Gas'},{id: 2, nom_serv: 'Servicio Electrico'},{id: 3, nom_serv: 'Servicio Especiales'}];
		scope.tmodal_comercializadora={};		
		scope.reporte_pdf_comercializadora=0;
		scope.reporte_excel_comercializadora=0;
		scope.Tcomercializadoras=[];
		scope.TcomercializadorasBack=[];
		console.log(scope.Tcomercializadoras);

		scope.modal_cif_comercializadora=function()
	{		
		scope.fdatos.NumCifCom=undefined;
		$("#modal_cif_comercializadora").modal('show');		
	}

	scope.cargar_lista_comercializadoras=function()
	{
		$("#List_Comer").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
	    var url=base_urlHome()+"api/Comercializadora/get_list_comercializadora";
		$http.get(url).then(function(result)
		{
			$("#List_Comer").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
			if(result.data!=false)
			{
				$scope.predicate = 'id';  
				$scope.reverse = true;						
				$scope.currentPage = 1;  
				$scope.order = function (predicate) 
				{  
					$scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;  
					$scope.predicate = predicate;  
				}; 						
				scope.Tcomercializadoras =result.data;
				scope.TcomercializadorasBack =result.data; 	 								
				$scope.totalItems = scope.Tcomercializadoras.length; 
				$scope.numPerPage = 50;  
				$scope.paginate = function (value) 
				{  
					var begin, end, index;  
					begin = ($scope.currentPage - 1) * $scope.numPerPage;  
					end = begin + $scope.numPerPage;  
					index = scope.Tcomercializadoras.indexOf(value);  
					return (begin <= index && index < end);  
				};
			}
			else
			{
				Swal.fire({title:"Comercializadora.",text:"No hemos encontrado Comercializadora Registradas Actualmente.",type:"info",confirmButtonColor:"#188ae2"});
				scope.Tcomercializadoras=[];
				scope.TcomercializadorasBack=[];
			}
		},function(error)
		{				
			$("#List_Comer").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );					
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
	$scope.Consultar_CIF = function(event) 
	{      
	 	if(scope.fdatos.NumCifCom==undefined || scope.fdatos.NumCifCom==null || scope.fdatos.NumCifCom=='')
		{
			Swal.fire({title:"Error.",text:"El número de CIF no puede estar vacio.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		else
		{
	        $("#NumCifCom").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
	        var url=base_urlHome()+"api/Comercializadora/comprobar_cif_comercializadora";
			$http.post(url,scope.fdatos).then(function(result)
			{
				if(result.data!=false)
				{
					$("#NumCifCom").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					Swal.fire({title:"Comercializadora Registrada.",text:"La Comercializadora ya se encuentra registrada.",type:"success",confirmButtonColor:"#188ae2"});					
				}
				else
				{
					$("#NumCifCom").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					$("#modal_cif_comercializadora").modal('hide');
					$cookies.put('CIF_COM', scope.fdatos.NumCifCom);
					location.href ="#/Datos_Basicos_Comercializadora/";
				}
			},function(error)
			{
				if(error.status==404 && error.statusText=="Not Found")
				{
					$("#NumCifCom").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					Swal.fire({title:"Error 404.",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
				}
				if(error.status==401 && error.statusText=="Unauthorized")
				{
					$("#NumCifCom").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					Swal.fire({title:"Error 401.",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
				}
				if(error.status==403 && error.statusText=="Forbidden")
				{
					$("#NumCifCom").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					Swal.fire({title:"Error 403.",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
					
				}
				if(error.status==500 && error.statusText=="Internal Server Error")
				{
					$("#NumCifCom").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
					Swal.fire({title:"Error 500",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
				}
			});
		}						
	};
	$scope.SubmitFormFiltrosComercializadoras = function(event) 
	{    
		console.log(event);  
		console.log(scope.tmodal_comercializadora.tipo_filtro);
		if(scope.tmodal_comercializadora.tipo_filtro==1)
		{
			console.log(scope.tmodal_comercializadora);
			
			$scope.predicate = 'id';  
			$scope.reverse = true;						
			$scope.currentPage = 1;  
			$scope.order = function (predicate) 
			{  
				$scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;  
				$scope.predicate = predicate;  
			}; 						
			
			if(scope.tmodal_comercializadora.TipServ==1)
			{
				scope.Tcomercializadoras =$filter('filter')(scope.TcomercializadorasBack, {SerGas: scope.tmodal_comercializadora.Selec}, true);
			}
			if(scope.tmodal_comercializadora.TipServ==2)
			{
				scope.Tcomercializadoras =$filter('filter')(scope.TcomercializadorasBack, {SerEle: scope.tmodal_comercializadora.Selec}, true);
			}
			if(scope.tmodal_comercializadora.TipServ==3)
			{
				scope.Tcomercializadoras =$filter('filter')(scope.TcomercializadorasBack, {SerEsp: scope.tmodal_comercializadora.Selec}, true);
			}
			$scope.totalItems = scope.Tcomercializadoras.length; 
			$scope.numPerPage = 50;  
			$scope.paginate = function (value) 
			{  
				var begin, end, index;  
				begin = ($scope.currentPage - 1) * $scope.numPerPage;  
				end = begin + $scope.numPerPage;  
				index = scope.Tcomercializadoras.indexOf(value);  
				return (begin <= index && index < end);
			};

			scope.reporte_pdf_comercializadora=scope.tmodal_comercializadora.tipo_filtro+"/"+scope.tmodal_comercializadora.TipServ+"/"+scope.tmodal_comercializadora.Selec;
			scope.reporte_excel_comercializadora=scope.tmodal_comercializadora.tipo_filtro+"/"+scope.tmodal_comercializadora.TipServ+"/"+scope.tmodal_comercializadora.Selec;
		}
		if(scope.tmodal_comercializadora.tipo_filtro==2)
		{
			console.log(scope.tmodal_comercializadora);
			$scope.predicate = 'id';  
			$scope.reverse = true;						
			$scope.currentPage = 1;  
			$scope.order = function (predicate) 
			{  
				$scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;  
				$scope.predicate = predicate;  
			}; 
			scope.Tcomercializadoras =$filter('filter')(scope.TcomercializadorasBack, {ProDirCom: scope.tmodal_data.CodPro}, true);	
			$scope.totalItems = scope.Tcomercializadoras.length; 
			$scope.numPerPage = 50;  
			$scope.paginate = function (value) 
			{  
				var begin, end, index;  
				begin = ($scope.currentPage - 1) * $scope.numPerPage;  
				end = begin + $scope.numPerPage;  
				index = scope.Tcomercializadoras.indexOf(value);  
				return (begin <= index && index < end);  
			};
			scope.reporte_pdf_comercializadora=scope.tmodal_comercializadora.tipo_filtro+"/"+scope.tmodal_data.CodPro;
			scope.reporte_excel_comercializadora=scope.tmodal_comercializadora.tipo_filtro+"/"+scope.tmodal_data.CodPro;
		}
		if(scope.tmodal_comercializadora.tipo_filtro==3)
		{
			console.log(scope.tmodal_comercializadora);
			$scope.predicate = 'id';  
			$scope.reverse = true;						
			$scope.currentPage = 1;  
			$scope.order = function (predicate) 
			{  
				$scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;  
				$scope.predicate = predicate;  
			};
			scope.Tcomercializadoras =$filter('filter')(scope.TcomercializadorasBack, {CodLoc: scope.tmodal_comercializadora.CodLocFil}, true);						
			$scope.totalItems = scope.Tcomercializadoras.length; 
			$scope.numPerPage = 50;  
			$scope.paginate = function (value) 
			{  
				var begin, end, index;  
				begin = ($scope.currentPage - 1) * $scope.numPerPage;  
				end = begin + $scope.numPerPage;  
				index = scope.Tcomercializadoras.indexOf(value);  
				return (begin <= index && index < end);  
			};
			scope.reporte_pdf_comercializadora=scope.tmodal_comercializadora.tipo_filtro+"/"+scope.tmodal_data.CodPro+"/"+scope.tmodal_comercializadora.CodLocFil;
			scope.reporte_excel_comercializadora=scope.tmodal_comercializadora.tipo_filtro+"/"+scope.tmodal_data.CodPro+"/"+scope.tmodal_comercializadora.CodLocFil;
		}
		if(scope.tmodal_comercializadora.tipo_filtro==4)
		{
			console.log(scope.tmodal_comercializadora);
			$scope.predicate = 'id';  
			$scope.reverse = true;						
			$scope.currentPage = 1;  
			$scope.order = function (predicate) 
			{  
				$scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;  
				$scope.predicate = predicate;  
			}; 	
			scope.Tcomercializadoras =$filter('filter')(scope.TcomercializadorasBack, {EstCom: scope.tmodal_comercializadora.EstCom}, true);							
			$scope.totalItems = scope.Tcomercializadoras.length; 
			$scope.numPerPage = 50;  
			$scope.paginate = function (value) 
			{  
				var begin, end, index;  
				begin = ($scope.currentPage - 1) * $scope.numPerPage;  
				end = begin + $scope.numPerPage;  
				index = scope.Tcomercializadoras.indexOf(value);  
				return (begin <= index && index < end);  
			};
			scope.reporte_pdf_comercializadora=scope.tmodal_comercializadora.tipo_filtro+"/"+scope.tmodal_comercializadora.EstCom;
			scope.reporte_excel_comercializadora=scope.tmodal_comercializadora.tipo_filtro+"/"+scope.tmodal_comercializadora.EstCom;
		}
		
	};
	scope.regresar_filtro_comercializadora=function()
	{
		scope.tmodal_data={};
		scope.tmodal_comercializadora={};		
		$scope.predicate = 'id';  
		$scope.reverse = true;						
		$scope.currentPage = 1;  
		$scope.order = function (predicate) 
		{  
			$scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;  
			$scope.predicate = predicate;  
		}; 						
		scope.Tcomercializadoras =scope.TcomercializadorasBack;							
		$scope.totalItems = scope.Tcomercializadoras.length; 
		$scope.numPerPage = 50;  
		$scope.paginate = function (value) 
		{  
			var begin, end, index;  
			begin = ($scope.currentPage - 1) * $scope.numPerPage;  
			end = begin + $scope.numPerPage;  
			index = scope.Tcomercializadoras.indexOf(value);  
			return (begin <= index && index < end);  
		};
		scope.reporte_pdf_comercializadora=0;
		scope.reporte_excel_comercializadora=0;
	}
	scope.validar_opcion=function(index,opciones_comercializadoras,dato)
	{
		//console.log(index);
		console.log(opciones_comercializadoras);
		console.log(dato);
		if(opciones_comercializadoras==1)
		{
			scope.opciones_comercializadoras[index]=undefined;
			if(dato.EstCom=='ACTIVA')
			{
				Swal.fire({title:"Error",text:"Ya esta Comercializadora se encuentra activa.",type:"error",confirmButtonColor:"#188ae2"});				
				return false;				
			}			
			Swal.fire({title:"¿Esta Seguro de Activar Esta Comercializadora?",
			type:"info",
			showCancelButton:!0,
			confirmButtonColor:"#31ce77",
			cancelButtonColor:"#f34943",
			confirmButtonText:"Activar"}).then(function(t)
			{
	            if(t.value==true)
	            {	              	
					scope.cambiar_estatus_comercializadora(opciones_comercializadoras,dato.CodCom); 
	            }
	            else
	            {
	            	console.log('Cancelando ando...');	                
	            }
	        });			
		}
		if(opciones_comercializadoras==2)
		{	
			scope.opciones_comercializadoras[index]=undefined;
			scope.t_modal_data={};
			if(dato.EstCom=='BLOQUEADA')
			{
				Swal.fire({title:"Error",text:"Ya esta Comercializadora se encuentra bloqueada.",type:"error",confirmButtonColor:"#188ae2"});				
				return false;				
			}
			scope.t_modal_data.CodCom=dato.CodCom;
			scope.NumCifComBlo=dato.NumCifCom;
			scope.RazSocComBlo=dato.RazSocCom;
			scope.t_modal_data.OpcCom=opciones_comercializadoras;
			scope.fecha_bloqueo=fecha;
			scope.cargar_lista_MotBloCom(index);			
			//
			//scope.cambiar_estatus_comercializadora(opciones_comercializadoras,dato.CodCom);
		}
		if(opciones_comercializadoras==3)
		{
			location.href ="#/Datos_Basicos_Comercializadora/"+dato.CodCom;
		}
		if(opciones_comercializadoras==4)
		{
			location.href ="#/Datos_Basicos_Comercializadora/"+dato.CodCom+"/"+1;
			scope.validate_info=1;
		}
	}
	scope.cargar_lista_MotBloCom=function(index)
	{
		var url=base_urlHome()+"api/Comercializadora/list_MotBloCom/";
		$http.get(url).then(function(result)
		{
			if(result.data!=false)
			{
				scope.tMotBloCom=result.data;
				scope.opciones_comercializadoras[index]=undefined;
				$("#modal_motivo_bloqueo_comercializadora").modal('show'); 
			}
			else
			{
				Swal.fire({title:"Error",text:"No Hemos encontrado motivos de bloqueos para las Comercializadora por lo que no puede continuar con esta operación.",type:"error",confirmButtonColor:"#188ae2"});	
				scope.opciones_comercializadoras[index]=undefined;
			}

		},function(error)
		{
			if(error.status==404 && error.statusText=="Not Found")
			{
				Swal.fire({title:"Error 404",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
				scope.opciones_comercializadoras[index]=undefined;
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				Swal.fire({title:"Error 401",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
				scope.opciones_comercializadoras[index]=undefined;
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				Swal.fire({title:"Error 403",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
				scope.opciones_comercializadoras[index]=undefined;
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{			
				Swal.fire({title:"Error 500",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
				scope.opciones_comercializadoras[index]=undefined;
			}	
		});
	}
	$scope.submitFormlockCom = function(event) 
	{
	 	if(scope.t_modal_data.ObsBloCom==undefined||scope.t_modal_data.ObsBloCom==null||scope.t_modal_data.ObsBloCom=='')
	 	{
	 		scope.t_modal_data.ObsBloCom=null;
	 	}
	 	else
	 	{
	 		scope.t_modal_data.ObsBloCom=scope.t_modal_data.ObsBloCom;
	 	}
	 	Swal.fire({title:"¿Esta Seguro de Bloquear Esta Comercializadora?",
		type:"question",
		showCancelButton:!0,
		confirmButtonColor:"#31ce77",
		cancelButtonColor:"#f34943",
		confirmButtonText:"Bloquear"}).then(function(t)
		{
	        if(t.value==true)
	        {
	            console.log(scope.t_modal_data);
	            scope.cambiar_estatus_comercializadora(scope.t_modal_data.OpcCom,scope.t_modal_data.CodCom);
	        }
	        else
	        {
	            event.preventDefault();
	            console.log('Cancelando ando...');
	        }
	        });		
	};
	scope.cambiar_estatus_comercializadora=function(opciones_comercializadoras,CodCom,index)
	{
		scope.status_comer={};
		scope.status_comer.EstCom=opciones_comercializadoras;
		scope.status_comer.CodCom=CodCom;
		if(opciones_comercializadoras==2)
		{
			scope.status_comer.MotBloq=scope.t_modal_data.MotBloq;
			scope.status_comer.ObsBloCom=scope.t_modal_data.ObsBloCom;
			console.log(scope.status_comer);
		}
		$("#estatus").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active");
		 var url= base_urlHome()+"api/Comercializadora/cambiar_estatus_comercializadora/";
		 $http.post(url,scope.status_comer).then(function(result)
		 {
		 	if(result.data.resultado!=false)
		 	{
		 		if(opciones_comercializadoras==1)
		 		{
		 			var title='Activando.';
		 			var text='La Comercializadora a sido activada con exito.';
		 		}
		 		if(opciones_comercializadoras==2)
		 		{
		 			var title='Bloquear.';
		 			var text='La Comercializadora a sido bloqueada con exito.';
		 			$("#modal_motivo_bloqueo_comercializadora").modal('hide');
		 		}

		 		$("#estatus").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
		 		Swal.fire({title:title,text:text,type:"success",confirmButtonColor:"#188ae2"});
		 		scope.opciones_comercializadoras[index]=undefined;
		 		scope.cargar_lista_comercializadoras();
		 	}
		 	else
		 	{
		 		$("#estatus").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				Swal.fire({title:"Error",text:"No hemos podido actualizar el estatus de la Comercializadora.",type:"error",confirmButtonColor:"#188ae2"});
				scope.cargar_lista_comercializadoras();
		 	}

		 },function(error)
		 {
		 	if(error.status==404 && error.statusText=="Not Found")
			{
				$("#estatus").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				Swal.fire({title:"Error 404.",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				$("#estatus").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				Swal.fire({title:"Error 401.",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				$("#estatus").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				Swal.fire({title:"Error 403.",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{
				$("#estatus").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
				Swal.fire({title:"Error 500.",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
			}
		 });
	}
	scope.filtrarLocalidad =  function()
	{
		scope.TLocalidadesfiltrada = $filter('filter')(scope.tLocalidades, {DesPro: scope.tmodal_data.CodPro}, true);
		
	}
//////////////////////////////////////////////////////////// VISTA PRINCIPAL DE LAS COMERCIALIZADORAS START //////////////////////////////////////////////////////////	
}			