app.controller('Datos_Basicos_Comercializadora', ['$http', '$scope', '$filter','$route','$interval', '$controller','$cookies','ServiceComercializadora','upload', Controlador])
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
	
//////////////////////////////////////////////////////////// DATOS BASICOS DE COMERCIALIZADORAS START //////////////////////////////////////////////////////////
	var scope = this;
	scope.fdatos = {}; // datos del formulario
	scope.nID = $route.current.params.ID;	  //contiene el id del registro en caso de estarse consultando desde la grid
	scope.INF = $route.current.params.INF;
	scope.CIF_COM=$cookies.get('CIF_COM');
	scope.Nivel = $cookies.get('nivel');
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
	scope.fdatos.misma_razon=false;
	const $archivos = document.querySelector("#file");
	scope.TProvincias=[];
	scope.tLocalidades=[];
	scope.tTiposVias=[];

	console.log($route.current.$$route.originalPath);	
	if($route.current.$$route.originalPath=="/Datos_Basicos_Comercializadora/")
	{
		if(scope.CIF_COM==undefined)
		{
			Swal.fire({title:'Error',text:"El Número de CIF No Puede Estar Vacio.",type:"error",confirmButtonColor:"#188ae2"});
			location.href="#/Comercializadora";
			$("#btn_modal_cif_com").removeClass( "btn btn-info").addClass("btn btn-danger");
		}
		else
		{
			scope.fdatos.NumCifCom=scope.CIF_COM;
			scope.fdatos.RenAutConCom=false;
			scope.fdatos.SerEle=false;
			scope.fdatos.SerGas=false;
			scope.fdatos.SerEsp=false;
		}		
	}
	if($route.current.$$route.originalPath=="/Datos_Basicos_Comercializadora/:ID");
	{
		scope.validate_info=scope.INF;
	}
	if($route.current.$$route.originalPath=="/Datos_Basicos_Comercializadora/:ID/:INF");
	{
		scope.validate_info=scope.INF;
	}
	/**/
	console.log(scope.validate_info);
	ServiceComercializadora.getAll().then(function(dato) 
		{
			scope.TProvincias = dato.Provincias;
			scope.tLocalidades= dato.Localidades;
			scope.tTiposVias=dato.Tipos_Vias;
			scope.fecha_server=dato.fecha;		
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
	scope.validar_fecha=function(metodo,object)
	{		
		if(metodo==1)
		{
			if(object!=undefined)
			{
				numero=object;		
				if(!/^([/0-9])*$/.test(numero))
				scope.FecConCom=numero.substring(0,numero.length-1);
			}	
		}
		if(metodo==2)
		{
			if(object!=undefined)
			{
				numero=object;		
				if(!/^([/0-9])*$/.test(numero))
				scope.FecVenConCom=numero.substring(0,numero.length-1);
			}
		}
		if(metodo==3)
		{
			if(object!=undefined)
			{
				numero=object;		
				if(!/^([/0-9])*$/.test(numero))
				scope.FecIniCom=numero.substring(0,numero.length-1);
				if(scope.FecIniCom.length==10)
				{
					if(scope.FecIniCom>scope.fecha_server)
					{
						Swal.fire({title:"Error",text:"La fecha que esta colocando no puede ser mayor a la actual por favor intente nuevamente.",type:"error",confirmButtonColor:"#188ae2"});
						scope.FecIniCom=undefined;
					}
				}				
			}
		}
		if(metodo==4)
		{
			if(object!=undefined)
			{
				numero=object;		
				if(!/^([0-9])*$/.test(numero))
				scope.fdatos.NumViaDirCom=numero.substring(0,numero.length-1);
			}
		}	
	}
	scope.calcular_anos=function()
	{		
		if(scope.FecConCom!=undefined && scope.FecVenConCom!=undefined)
		{
			if(new Date(scope.FecVenConCom)<new Date(scope.FecConCom))
			{
				Swal.fire({title:"Error",text:"La fecha de vencimiento no puede ser menor a la fecha de inicio.",type:"error",confirmButtonColor:"#188ae2"});
				scope.fdatos.DurConCom=undefined;
				scope.FecVenConCom=undefined;
				return false;
			}
			var hora3 = (scope.FecVenConCom).split("/"),
	   		hora4 =(scope.FecConCom).split("/"),
	   		t3 = new Date(),
	    	t4 = new Date();
	 		t3.setHours(hora3[2], hora3[1], hora3[0]);
			t4.setHours(hora4[2], hora4[1], hora4[0]);
			t3.setHours(t3.getHours() - t4.getHours(), t3.getMinutes() - t4.getMinutes(), t3.getSeconds() - t4.getSeconds());			
			scope.fdatos.DurConCom = (t3.getHours());
			//console.log(scope.fdatos.DurConCom);
			if(scope.fdatos.DurConCom==0)
			{
				Swal.fire({title:"Error",text:"El Tiempo Minimo del contrato debe ser de 1 año en adelante.",type:"error",confirmButtonColor:"#188ae2"});
				scope.FecVenConCom=undefined;
				scope.fdatos.DurConCom=undefined;
				scope.disabled_button=1;					
			}
			else
			{
				scope.disabled_button=0;
			}
		}		
	}
	scope.asignar_a_nombre_comercial=function()
	{
		if(scope.fdatos.RazSocCom!=undefined || scope.fdatos.RazSocCom!=null || scope.fdatos.RazSocCom!='')
		{
			scope.fdatos.NomComCom=scope.fdatos.RazSocCom;
		}		
	}
	scope.filtrarLocalidadCom =  function()
	{
		scope.TLocalidadesfiltrada = $filter('filter')(scope.tLocalidades, {CodPro: scope.fdatos.CodPro}, true);		
		if($route.current.$$route.originalPath=="/Datos_Basicos_Comercializadora/:ID/:INF" || $route.current.$$route.originalPath=="/Datos_Basicos_Comercializadora/:ID")
		{
			scope.contador=0;
			scope.contador=scope.contador+1;
		}
		console.log('para ver si se ejecuta cada 5 segundos?');
		console.log(scope.contador);
		if(scope.contador==1)
		{
			$interval.cancel(promise);
		}
	}
	scope.filtrar_zona_postal =  function()
	{
		scope.CodLocZonaPostal = $filter('filter')(scope.tLocalidades, {CodLoc: scope.fdatos.CodLoc}, true);
		angular.forEach(scope.CodLocZonaPostal, function(data)
		{
			scope.fdatos.ZonPos=data.CPLoc;						
		});		

	}

	$scope.submitForm = function(event) 
	{ 	
	 	if(scope.fdatos.CodCom==undefined)
	 	{
	 		var titulo='Guardando';
	 		var texto='¿Esta Seguro de Ingresar este nuevo registro.?';
	 		var response="Comercializadora registrada satisfactoriamente";
	 	}
	 	else
	 	{
	 		var titulo='Actualizando';
	 		var texto='¿Esta Seguro de Actualizar este registro.?';
	 		var response="Comercializadora modificada satisfactoriamente";
	 	}
		if (!scope.validar_campos_datos_basicos())
		{
			return false;
		}
		
		let archivos = $archivos.files;
	 	if($archivos.files.length>0)
	 	{	
	 		console.log($archivos.files);
		 	if($archivos.files[0].type=="application/pdf" || $archivos.files[0].type=="image/jpeg" || $archivos.files[0].type=="image/png")
		 	{
		 		console.log('Archivo Permitido');
		 		var tipo_file=($archivos.files[0].type).split("/");$archivos.files[0].type;
		 		console.log(tipo_file[1]);		 		
		 		$scope.uploadFile();
				scope.fdatos.DocConCom='documentos/'+$archivos.files[0].name;
		 	}
		 	else	 	
		 	{
		 		console.log('Archivo No Permitido');
		 		Swal.fire({title:'Error',text:"Formato incorrecto solo se permite archivos PDF, JPG o PNG.",type:"error",confirmButtonColor:"#188ae2"});		 		
				document.getElementById('file').value ='';
				return false;
			}
	 	}
	 	scope.validar_campos_nulos();
		console.log(scope.fdatos);
	 	Swal.fire({title:titulo,
		text:texto,
		type:"question",
		showCancelButton:!0,
		confirmButtonColor:"#31ce77",
		cancelButtonColor:"#f34943",
		confirmButtonText:"Confirmar!"}).then(function(t)
		{
	        if(t.value==true)
	        {
	           	    $("#"+titulo).removeClass( "loader loader-default" ).addClass( "loader loader-default is-active");
	           	    var url = base_urlHome()+"api/Comercializadora/registrar_comercializadora/";
	           	    $http.post(url,scope.fdatos).then(function(result)
	           	    {
	           	    	scope.nID=result.data.CodCom;
	           	    	if(result.data!=false)
	           	    	{
	           	    		$("#"+titulo).removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
							Swal.fire({title:titulo,text:response,type:"success",confirmButtonColor:"#188ae2"});
	           	    		document.getElementById('file').value ='';
	           	    		$cookies.remove('CIF_COM');
	           	    		location.href="#/Datos_Basicos_Comercializadora/"+scope.nID;
	           	    		//scope.fdatos=result.data;
	           	    	}
	           	    	else
	           	    	{
	           	    		$("#"+titulo).removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
							Swal.fire({title:"Error",text:"No hemos podidos guardar los datos intente nuevamente.",type:"error",confirmButtonColor:"#188ae2"});
	           	    	}

	           	    },function(error)
	           	    {
	           	    	$("#"+titulo).removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );							
			           	if(error.status==404 && error.statusText=="Not Found")
						{
							Swal.fire({title:"Error 404.",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
						}
						if(error.status==401 && error.statusText=="Unauthorized")
						{
							Swal.fire({title:"Error 401.",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
						}
						if(error.status==403 && error.statusText=="Forbidden")
						{
							Swal.fire({title:"Error 403.",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
							
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
scope.validar_campos_datos_basicos = function()
	{
		resultado = true;
		if (scope.FecIniCom==null || scope.FecIniCom==undefined || scope.FecIniCom=='')
		{
			Swal.fire({title:"El Campo Fecha de Inicio es Requerido.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		else
		{
			var FecIniCom= (scope.FecIniCom).split("/");
			if(FecIniCom.length<3)
			{
				Swal.fire({text:"El Formato de Fecha de Inicio debe Ser EJ: DD/MM/YYYY.",type:"error",confirmButtonColor:"#188ae2"});
				event.preventDefault();	
				return false;
			}
			else
			{		
				if(FecIniCom[0].length>2 || FecIniCom[0].length<2)
				{
					Swal.fire({text:"Por Favor Corrija el Formato del dia en la Fecha de Inicio deben ser 2 números solamente. EJ: 01",type:"error",confirmButtonColor:"#188ae2"});
					event.preventDefault();	
					return false;

				}
				if(FecIniCom[1].length>2 || FecIniCom[1].length<2)
				{
					Swal.fire({text:"Por Favor Corrija el Formato del mes de la Fecha de Inicio deben ser 2 números solamente. EJ: 01",type:"error",confirmButtonColor:"#188ae2"});
					event.preventDefault();	
					return false;
				}
				if(FecIniCom[2].length<4 || FecIniCom[2].length>4)
				{
					Swal.fire({text:"Por Favor Corrija el Formato del ano en la Fecha de Inicio Ya que deben ser 4 números solamente. EJ: 1999",type:"error",confirmButtonColor:"#188ae2"});
					event.preventDefault();	
					return false;
				}
				var h1=new Date();			
				var final = FecIniCom[2]+"/"+FecIniCom[1]+"/"+FecIniCom[0];
				scope.fdatos.FecIniCom=final;
			}
		}
		if (scope.fdatos.RazSocCom==null || scope.fdatos.RazSocCom==undefined || scope.fdatos.RazSocCom=='')
		{
			Swal.fire({title:"El Campo Razon Social es Requerido.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}		
		if (scope.fdatos.NomComCom==null || scope.fdatos.NomComCom==undefined || scope.fdatos.NomComCom=='')
		{
			Swal.fire({title:"El Campo Nombre Comercial es Requerido.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (!scope.fdatos.CodTipVia > 0)
		{
			Swal.fire({title:"Debe Seleccionar un Tipo de Vía de la lista.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (scope.fdatos.NomViaDirCom==null || scope.fdatos.NomViaDirCom==undefined || scope.fdatos.NomViaDirCom=='')
		{
			Swal.fire({title:"El Campo Nombre de la Vía es Requerido.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (scope.fdatos.NumViaDirCom==null || scope.fdatos.NumViaDirCom==undefined || scope.fdatos.NumViaDirCom=='')
		{
			Swal.fire({title:"El Campo Número de la Vía es Requerido.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (!scope.fdatos.CodPro > 0)
		{
			Swal.fire({title:"Debe Seleccionar una Provincia de la lista.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (!scope.fdatos.CodLoc > 0)
		{
			Swal.fire({title:"Debe Seleccionar una Localidad de la lista.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (scope.fdatos.TelFijCom==null || scope.fdatos.TelFijCom==undefined || scope.fdatos.TelFijCom=='')
		{
			Swal.fire({title:"El Campo Teléfono es Requerido.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (scope.fdatos.EmaCom==null || scope.fdatos.EmaCom==undefined || scope.fdatos.EmaCom=='')
		{
			Swal.fire({title:"El Campo Correo Electrónico es Requerido.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (scope.fdatos.NomConCom==null || scope.fdatos.NomConCom==undefined || scope.fdatos.NomConCom=='')
		{
			Swal.fire({title:"El Campo Persona Contacto es Requerido.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (scope.fdatos.CarConCom==null || scope.fdatos.CarConCom==undefined || scope.fdatos.CarConCom=='')
		{
			Swal.fire({title:"El Campo Cargo Persona es Requerido.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (scope.FecConCom==undefined || scope.FecConCom==null || scope.FecConCom=='')
		{
			scope.fdatos.FecConCom=null;
		}
		else
		{			
			var FecConCom= (scope.FecConCom).split("/");
			console.log(FecConCom);
			if(FecConCom.length<3)
			{
				Swal.fire({text:"El Formato de Fecha de Contrato debe Ser EJ: DD/MM/YYYY.",type:"error",confirmButtonColor:"#188ae2"});
				//event.preventDefault();	
				return false;
			}
			else
			{		
				if(FecConCom[0].length>2 || FecConCom[0].length<2)
				{
					Swal.fire({text:"Por Favor Corrija el Formato del dia en la Fecha de Contrato deben ser 2 números solamente. EJ: 01",type:"error",confirmButtonColor:"#188ae2"});
					//event.preventDefault();	
					return false;

				}
				if(FecConCom[1].length>2 || FecConCom[1].length<2)
				{
					Swal.fire({text:"Por Favor Corrija el Formato del mes de la Fecha de Contrato deben ser 2 números solamente. EJ: 01",type:"error",confirmButtonColor:"#188ae2"});
					//event.preventDefault();	
					return false;
				}
				if(FecConCom[2].length<4 || FecConCom[2].length>4)
				{
					Swal.fire({text:"Por Favor Corrija el Formato del ano en la Fecha de Contrato Ya que deben ser 4 números solamente. EJ: 1999",type:"error",confirmButtonColor:"#188ae2"});
					//event.preventDefault();	
					return false;
				}
				var h1=new Date();			
				var final2 = FecConCom[2]+"/"+FecConCom[1]+"/"+FecConCom[0];
				scope.fdatos.FecConCom=final2;
			}
		}
		if (scope.FecVenConCom==undefined || scope.FecVenConCom==null || scope.FecVenConCom=='')
		{
			scope.fdatos.FecVenConCom=null;
		}
		else
		{
			var FecVenConCom= (scope.FecVenConCom).split("/");
			if(FecVenConCom.length<3)
			{
				Swal.fire({text:"El Formato de Fecha de Vencimiento debe Ser EJ: DD/MM/YYYY.",type:"error",confirmButtonColor:"#188ae2"});
				event.preventDefault();	
				return false;
			}
			else
			{		
				if(FecVenConCom[0].length>2 || FecVenConCom[0].length<2)
				{
					Swal.fire({text:"Por Favor Corrija el Formato del dia en la Fecha de Vencimiento deben ser 2 números solamente. EJ: 01",type:"error",confirmButtonColor:"#188ae2"});
					event.preventDefault();	
					return false;

				}
				if(FecVenConCom[1].length>2 || FecVenConCom[1].length<2)
				{
					Swal.fire({text:"Por Favor Corrija el Formato del mes de la Fecha de Vencimiento deben ser 2 números solamente. EJ: 01",type:"error",confirmButtonColor:"#188ae2"});
					event.preventDefault();	
					return false;
				}
				if(FecVenConCom[2].length<4 || FecVenConCom[2].length>4)
				{
					Swal.fire({text:"Por Favor Corrija el Formato del ano en la Fecha de Vencimiento Ya que deben ser 4 números solamente. EJ: 1999",type:"error",confirmButtonColor:"#188ae2"});
					event.preventDefault();	
					return false;
				}
				var h1=new Date();			
				var final1 = FecVenConCom[2]+"/"+FecVenConCom[1]+"/"+FecVenConCom[0];
				scope.fdatos.FecVenConCom=final1;
			}
		}		
		if (resultado == false) 
		{
			return false;
		} 
			return true;
	}
	scope.validar_campos_nulos=function()
	{
		if (scope.fdatos.BloDirCom==undefined || scope.fdatos.BloDirCom==null || scope.fdatos.BloDirCom=='')
		{
			scope.fdatos.BloDirCom=null;
		}
		else
		{
			scope.fdatos.BloDirCom=scope.fdatos.BloDirCom;
		}
		if (scope.fdatos.EscDirCom==undefined || scope.fdatos.EscDirCom==null || scope.fdatos.EscDirCom=='')
		{
			scope.fdatos.EscDirCom=null;
		}
		else
		{
			scope.fdatos.EscDirCom=scope.fdatos.EscDirCom;
		}
		if (scope.fdatos.PlaDirCom==undefined || scope.fdatos.PlaDirCom==null || scope.fdatos.PlaDirCom=='')
		{
			scope.fdatos.PlaDirCom=null;
		}
		else
		{
			scope.fdatos.PlaDirCom=scope.fdatos.PlaDirCom;
		}
		if (scope.fdatos.PueDirCom==undefined || scope.fdatos.PueDirCom==null || scope.fdatos.PueDirCom=='')
		{
			scope.fdatos.PueDirCom=null;
		}
		else
		{
			scope.fdatos.PueDirCom=scope.fdatos.PueDirCom;
		}
		
		if (scope.fdatos.DurConCom==undefined || scope.fdatos.DurConCom==null || scope.fdatos.DurConCom=='')
		{
			scope.fdatos.DurConCom=null;
		}
		else
		{
			scope.fdatos.DurConCom=scope.fdatos.DurConCom;
		}	
		
		if (scope.fdatos.ObsCom==undefined || scope.fdatos.ObsCom==null || scope.fdatos.ObsCom=='')
		{
			scope.fdatos.ObsCom=null;
		}
		else
		{
			scope.fdatos.ObsCom=scope.fdatos.ObsCom;
		}
		if (scope.fdatos.PagWebCom==undefined || scope.fdatos.PagWebCom==null || scope.fdatos.PagWebCom=='')
		{
			scope.fdatos.PagWebCom=null;
		}
		else
		{
			scope.fdatos.PagWebCom=scope.fdatos.PagWebCom;
		}
		if (scope.fdatos.DocConCom==undefined || scope.fdatos.DocConCom==null || scope.fdatos.DocConCom=='')
		{
			scope.fdatos.DocConCom=null;
		}
		else
		{
			scope.fdatos.DocConCom=scope.fdatos.DocConCom;
		}
	}
	$scope.uploadFile = function()
	{
		var file = $scope.file;
		upload.uploadFile(file, name).then(function(res)
		{ 
			console.log(res);
		},function(error)
		{
			if(error.status==404 && error.statusText=="Not Found")
			{
				Swal.fire({title:"Error 404.",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				Swal.fire({title:"Error 401.",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				Swal.fire({title:"Error 403.",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{
				Swal.fire({title:"Error 500",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
			}
		});
	}
	scope.regresar=function()
	{
		if(scope.fdatos.CodCom==undefined)
		{		
			Swal.fire({title:"Esta seguro de no completar el registro de la Comercializadora?",			
			type:"question",
			showCancelButton:!0,
			confirmButtonColor:"#31ce77",
			cancelButtonColor:"#f34943",
			confirmButtonText:"OK"}).then(function(t)
			{
	          if(t.value==true)
	          {
	              	$cookies.remove('CIF_COM');
	              	location.href="#/Comercializadora/";
	          }
	          else
	          {
	               console.log('Cancelando ando...');	                
	          }
	       });	
		}
		else
		{
			location.href="#/Comercializadora/";	
		}
	}
	scope.buscarXID=function()
	{
		$("#buscando").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active");
		 var url= base_urlHome()+"api/Comercializadora/Buscar_xID_Comercializadora/CodCom/"+scope.nID;
		 $http.get(url).then(function(result)
		 {
		 	if(result.data!=false)
		 	{
		 		$("#buscando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
		 		scope.fdatos=result.data;
		 		scope.FecIniCom=result.data.FecIniCom;
		 		scope.FecConCom=result.data.FecConCom;
				scope.FecVenConCom=result.data.FecVenConCom;		 		
				if(result.data.RenAutConCom==0)
				{
					scope.fdatos.RenAutConCom=false;
				}	
				else
				{
					scope.fdatos.RenAutConCom=true;
				}
				if(result.data.SerEle==1)
				{
					scope.fdatos.SerEle=true;
				}
				else
				{
					scope.fdatos.SerEle=false;
				}
				if(result.data.SerEsp==1)
				{
					scope.fdatos.SerEsp=true;
				}
				else
				{
					scope.fdatos.SerEsp=false;
				}
				if(result.data.SerGas==1)
				{
					scope.fdatos.SerGas=true;
				}
				else
				{
					scope.fdatos.SerGas=false;
				}
				scope.fdatos.misma_razon=false;				
				console.log(scope.fdatos);
		 	}
		 	else
		 	{
		 		$("#buscando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				Swal.fire({title:"Error",text:"No hemos encontrado datos relacionados con este código.",type:"error",confirmButtonColor:"#188ae2"});
		 	}

		 },function(error)
		 {
		 	if(error.status==404 && error.statusText=="Not Found")
			{
				$("#buscando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				Swal.fire({title:"Error 404.",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				$("#buscando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				Swal.fire({title:"Error 401.",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				$("#buscando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				Swal.fire({title:"Error 403.",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{
				$("#buscando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
				Swal.fire({title:"Error 500.",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
			}
		 });

	}





	if(scope.nID!=undefined) 
	{
		scope.buscarXID();
		var promise = $interval(function() 
		{ 
			scope.filtrarLocalidadCom();
			},7000);	
			$scope.$on('$destroy', function () 
			{ 
			$interval.cancel(promise); 
		});
	}
//////////////////////////////////////////////////////////// DATOS BASICOS DE COMERCIALIZADORAS END ////////////////////////////////////////////////////////////////
}