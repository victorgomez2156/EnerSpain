app.controller('Controlador_Clientes', ['$http', '$scope', '$filter','$route','ServiceCodPro','ServiceCodLoc','ServiceCodTipCli','ServiceCodCom','ServiceSectorCliente','$interval', '$controller','$cookies','ServiceTipoVias','ServiceColaborador','ServiceTipoInmueble','ServiceBancos', Controlador])
.directive('stringToNumber', function() 
{
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
function Controlador($http,$scope,$filter,$route,ServiceCodPro,ServiceCodLoc,ServiceCodTipCli,ServiceCodCom,ServiceSectorCliente,$interval,$controller,$cookies,ServiceTipoVias,ServiceColaborador,ServiceTipoInmueble,ServiceBancos)
{
	//declaramos una variable llamada scope donde tendremos a vm
	/*inyectamos un controlador para acceder a sus variables y metodos*/
	//$controller('ControladorArticuloExistencia as vmAE',{$scope:$scope});			
	var scope = this;
	scope.fdatos = {}; // datos del formulario
	scope.fpuntosuministro={};
	scope.nID = $route.current.params.ID;	//contiene el id del registro en caso de estarse consultando desde la grid
	scope.validate_info = $route.current.params.MET; 
	scope.Nivel = $cookies.get('nivel');
	scope.CIF = $cookies.get('CIF');
	scope.Tclientes=undefined;
	scope.TclientesBack=undefined;
	scope.validacion_formulario=0;	
	scope.validate_form=false;
	scope.enabled_button=false;
	scope.index=0;	
	scope.topciones = [{id: 1, nombre: 'VER'},{id: 2, nombre: 'EDITAR'},{id: 3, nombre: 'ACTIVAR'},{id: 4, nombre: 'BLOQUEAR'}];
	scope.topcionescliente = [{id: 3, nombre: 'ACTIVO'},{id: 4, nombre: 'BLOQUEADO'}];
	scope.topcionesactividades = [{id: 1, nombre: 'ACTIVAR'},{id: 2, nombre: 'BLOQUEAR'}];
	scope.ttipofiltrosPunSum = [{id: 1, nombre: 'PROVINCIA'},{id: 2, nombre: 'LOCALIDAD'},{id: 3, nombre: 'TIPO INMUEBLE'},{id: 4, nombre: 'ESTATUS'}];	
	scope.ttipofiltros = [{id: 1, nombre: 'TIPO DE CLIENTE'},{id: 2, nombre: 'SECTOR'},{id: 3, nombre: 'PROVINCIA FISCAL'},{id: 4, nombre: 'LOCALIDAD FISCAL'},{id: 5, nombre: 'COMERCIAL'},{id: 6, nombre: 'COLABORADOR'},{id: 7, nombre: 'ESTATUS CLIENTE'}];
	scope.ttipofiltrosact = [{id: 1, nombre: 'FECHA DE INICIO'},{id: 2, nombre: 'ESTATUS ACTIVIDAD'}];
	scope.ttipofiltrosEstAct = [{id: 1, nombre: 'Activa'},{id: 2, nombre: 'Bloqueada'}];
	scope.topcionesPunSum = [{id: 4, nombre: 'VER'},{id: 3, nombre: 'EDITAR'},{id: 2, nombre: 'BLOQUEAR'},{id: 1, nombre: 'ACTIVAR'}];
	scope.topcionesBan = [{id: 3, nombre: 'EDITAR'},{id: 1, nombre: 'ACTIVAR'},{id: 2, nombre: 'BLOQUEAR'}];
	scope.tPuntosSuminitros=undefined;
	scope.tPuntosSuminitrosBack=undefined;	
	if($route.current.$$route.originalPath=="/Clientes/")
	{
		scope.fdatos.NumCif=true;
		scope.fdatos.RazSoc=true;
		scope.fdatos.Tel=true;
		scope.fdatos.Est=true;
		scope.fdatos.Acc=true;
		scope.ProFis=true;
		scope.LocFis=true;
	}	
	scope.validate_cif=1;
	scope.fdatos.misma_razon=false;
	scope.fdatos.distinto_a_social=false;
	scope.Habilita_Fecha=false;
	resultado = false;
	$scope.patterNumber=/^[+0123456789]*$/;
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
	var fecha = dd+'-'+mm+'-'+yyyy;
	scope.FecIniAct = fecha;
	scope.funcion_services=function()
	{
		ServiceCodPro.getAll().then(function(dato) 
		{
			scope.tProvidencias = dato;		
		}).catch(function(err) 
		{
			console.log(err); //Tratar el error
		});	
		ServiceCodTipCli.getAll().then(function(dato) 
		{
			scope.tTipoCliente = dato;		
		}).catch(function(err) 
		{
			console.log(err); //Tratar el error
		});
		ServiceCodCom.getAll().then(function(dato) 
		{
			scope.tComerciales = dato;		
		}).catch(function(err) 
		{
			console.log(err); //Tratar el error
		});
		ServiceTipoVias.getAll().then(function(dato) 
		{
			scope.tTiposVias = dato;		
		}).catch(function(err) 
		{
			console.log(err); //Tratar el error
		});
		ServiceCodLoc.getAll().then(function(dato) 
		{
			scope.tLocalidades = dato;								
					
		}).catch(function(err) 
		{
			console.log(err); //Tratar el error
		});
		ServiceSectorCliente.getAll().then(function(dato) 
		{
			scope.tSectores = dato;								
					
		}).catch(function(err) 
		{
			console.log(err); //Tratar el error
		});
		ServiceColaborador.getAll().then(function(dato) 
		{
			scope.tColaboradores = dato;								
					
		}).catch(function(err) 
		{
			console.log(err); //Tratar el error
		});

	}
scope.funcion_services_filtros=function()
{
	ServiceCodPro.getAll().then(function(dato) 
	{
		scope.tProvidencias = dato;		
	}).catch(function(err) 
	{
		console.log(err); //Tratar el error
	});	
	ServiceCodTipCli.getAll().then(function(dato) 
	{
		scope.tTipoCliente = dato;		
	}).catch(function(err) 
	{
		console.log(err); //Tratar el error
	});
	ServiceCodLoc.getAll().then(function(dato) 
	{
		scope.tLocalidades = dato;								
	}).catch(function(err) 
	{
		console.log(err); //Tratar el error
	});
	ServiceCodCom.getAll().then(function(dato) 
	{
		scope.tComerciales = dato;		
	}).catch(function(err) 
	{
		console.log(err); //Tratar el error
	});
	ServiceSectorCliente.getAll().then(function(dato) 
	{
		scope.tSectores = dato;
	}).catch(function(err) 
	{
		console.log(err); //Tratar el error
	});
	ServiceColaborador.getAll().then(function(dato) 
	{
		scope.tColaboradores = dato;
	}).catch(function(err) 
	{
		console.log(err); //Tratar el error
	});
}

	if($route.current.$$route.originalPath=="/Creacion_Clientes/")
	{
		if(scope.CIF==undefined)
		{
			Swal.fire({title:"Error.",text:"El Número de CIF no estar vacio sera regresado a la pantalla de clientes.",type:"error",confirmButtonColor:"#188ae2"})
			scope.validate_cif=1;
			scope.validate_form=1;
			location.href="#/Clientes/";
		}
		else
		{
			scope.fdatos.NumCifCli=scope.CIF;			
			scope.funcion_services();
		}
	}


	$scope.submitForm = function(event) 
	{      
	 	console.log(scope.fdatos);
	 	if(scope.nID>0 && scope.Nivel==3)
		{
			Swal.fire({title:"Nivel no Autorizado.",text:"Su nivel no esta autorizado para esta operación.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (!scope.validar_campos_datos_basicos())
		{
			return false;
		}
	 	bootbox.confirm({
	    title:"Confirmación",
	    message: "¿Está seguro que desea incluir este nuevo registro?",
	    buttons: {
	    cancel: {
	    label: '<i class="fa fa-times"></i> Cancelar'
	    },
	    confirm: {
		label: '<i class="fa fa-check"></i> Confirmar'
		}
		},
		callback: function (result) 
		{
			if (result==false) 
			{ 
				event.preventDefault();
			}     
			else
			{
				scope.guardar();	
			}
		}});
					
	};
		scope.validar_campos_datos_basicos = function()
			{
				resultado = true;
				if (scope.fdatos.RazSocCli==null || scope.fdatos.RazSocCli==undefined || scope.fdatos.RazSocCli=='')
				{
					Swal.fire({title:"El Campo Razon Social es Requerido.",type:"error",confirmButtonColor:"#188ae2"});
					return false;
				}
				if (scope.fdatos.NomComCli==null || scope.fdatos.NomComCli==undefined || scope.fdatos.NomComCli=='')
				{
					Swal.fire({title:"El Campo Nombre Comercial es Requerido.",type:"error",confirmButtonColor:"#188ae2"});
					return false;
				}				
				if (!scope.fdatos.CodTipCli > 0)
				{
					Swal.fire({title:"Debe Seleccionar un Tipo de Cliente.",type:"error",confirmButtonColor:"#188ae2"});
					return false;
				}				
				if (!scope.fdatos.CodSecCli > 0)
				{
					Swal.fire({title:"Debe Seleccionar un Sector.",type:"error",confirmButtonColor:"#188ae2"});
					return false;
				}
				if (!scope.fdatos.CodTipViaSoc > 0)
				{
					Swal.fire({title:"Debe Seleccionar un Tipo de Via.",type:"error",confirmButtonColor:"#188ae2"});
					return false;
				}				
				if (scope.fdatos.NomViaDomSoc==null || scope.fdatos.NomViaDomSoc==undefined || scope.fdatos.NomViaDomSoc=='')
				{
					Swal.fire({title:"El Nombre del Domicilio es Requerido.",type:"error",confirmButtonColor:"#188ae2"});		           
					return false;
				}
				if (scope.fdatos.NumViaDomSoc==null || scope.fdatos.NumViaDomSoc==undefined || scope.fdatos.NumViaDomSoc=='')
				{
					Swal.fire({title:"El Número del Domicilio es Requerido.",type:"error",confirmButtonColor:"#188ae2"});		           
					return false;
				}				
				if (!scope.fdatos.CodProSoc > 0)
				{
					Swal.fire({title:"Debe seleccionar una Provincia de la lista.",type:"error",confirmButtonColor:"#188ae2"});
		            scope.CodProReq=true;
					return false;
				}				
				if (!scope.fdatos.CodLocSoc > 0)
				{
					Swal.fire({title:"Debe seleccionar una Localidad de la lista.",type:"error",confirmButtonColor:"#188ae2"});
		            scope.CodLocReq=true;
					return false;
				}				
				
				if(scope.fdatos.distinto_a_social==true)
				{
					if (!scope.fdatos.CodTipViaFis > 0)
					{
						Swal.fire({title:"Debe Seleccionar un Tipo de Via Fiscal.",type:"error",confirmButtonColor:"#188ae2"});
						return false;
					}				
					if (scope.fdatos.NomViaDomFis==null || scope.fdatos.NomViaDomFis==undefined || scope.fdatos.NomViaDomFis=='')
					{
						Swal.fire({title:"El Nombre del Domicilio Fiscal es Requerido.",type:"error",confirmButtonColor:"#188ae2"});		           
						return false;
					}
					if (scope.fdatos.NumViaDomFis==null || scope.fdatos.NumViaDomFis==undefined || scope.fdatos.NumViaDomFis=='')
					{
						Swal.fire({title:"El Número del Domicilio Fiscal es Requerido.",type:"error",confirmButtonColor:"#188ae2"});		           
						return false;
					}				
					if (!scope.fdatos.CodProFis > 0)
					{
						Swal.fire({title:"Debe Seleccionar una Provincia de la lista Fiscal.",type:"error",confirmButtonColor:"#188ae2"});
			            scope.CodProReq=true;
						return false;
					}				
					if (!scope.fdatos.CodLocFis > 0)
					{
						Swal.fire({title:"Debe seleccionar una Localidad de la lista Fiscal.",type:"error",confirmButtonColor:"#188ae2"});
			            scope.CodLocReq=true;
						return false;
					}
				}
				if (scope.fdatos.TelFijCli==null || scope.fdatos.TelFijCli==undefined || scope.fdatos.TelFijCli=='')
				{
					Swal.fire({title:"El Campo Número de Teléfono es Requerido.",type:"error",confirmButtonColor:"#188ae2"});
		            scope.TelFijCliReq=true;
					return false;
				}
				if (scope.fdatos.EmaCli==null || scope.fdatos.EmaCli==undefined || scope.fdatos.EmaCli=='')
				{
					Swal.fire({title:"El Campo Correo Electrónico es Requerido.",type:"error",confirmButtonColor:"#188ae2"});
		            scope.EmaCliReq=true;
					return false;
				}
				if (!scope.fdatos.CodCom > 0)
				{
					Swal.fire({title:"Debe seleccionar un Comercial de la lista.",type:"error",confirmButtonColor:"#188ae2"});
		            scope.CodComReq=true;
					return false;
				}

				if (resultado == false)
				{
					//quiere decir que al menos un renglon no paso la validacion
					return false;
				} 
				return true;
			} 
	scope.guardar=function()
	{		
		$("#crear_clientes").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active");			
		if(scope.fdatos.BloDomSoc==undefined||scope.fdatos.BloDomSoc==null||scope.fdatos.BloDomSoc=='')
		{
			scope.fdatos.BloDomSoc=null;
		}
		else
		{
			scope.fdatos.BloDomSoc=scope.fdatos.BloDomSoc;
		}
		if(scope.fdatos.EscDomSoc==undefined||scope.fdatos.EscDomSoc==null||scope.fdatos.EscDomSoc=='')
		{
			scope.fdatos.EscDomSoc=null;
		}
		else
		{
			scope.fdatos.EscDomSoc=scope.fdatos.EscDomSoc;
		}
		if(scope.fdatos.PlaDomSoc==undefined||scope.fdatos.PlaDomSoc==null||scope.fdatos.PlaDomSoc=='')
		{
			scope.fdatos.PlaDomSoc=null;
		}
		else
		{
			scope.fdatos.PlaDomSoc=scope.fdatos.PlaDomSoc;
		}
		if(scope.fdatos.PueDomSoc==undefined||scope.fdatos.PueDomSoc==null||scope.fdatos.PueDomSoc=='')
		{
			scope.fdatos.PueDomSoc=null;
		}
		else
		{
			scope.fdatos.PueDomSoc=scope.fdatos.PueDomSoc;
		}
		if(scope.fdatos.BloDomFis==undefined||scope.fdatos.BloDomFis==null||scope.fdatos.BloDomFis=='')
		{
			scope.fdatos.BloDomFis=null;
		}
		else
		{
			scope.fdatos.BloDomFis=scope.fdatos.BloDomFis;
		}
		if(scope.fdatos.EscDomFis==undefined||scope.fdatos.EscDomFis==null||scope.fdatos.EscDomFis=='')
		{
			scope.fdatos.EscDomFis=null;
		}
		else
		{
			scope.fdatos.EscDomFis=scope.fdatos.EscDomFis;
		}
		if(scope.fdatos.PlaDomFis==undefined||scope.fdatos.PlaDomFis==null||scope.fdatos.PlaDomFis=='')
		{
			scope.fdatos.PlaDomFis=null;
		}
		else
		{
			scope.fdatos.PlaDomFis=scope.fdatos.PlaDomFis;
		}
		if(scope.fdatos.PueDomFis==undefined||scope.fdatos.PueDomFis==null||scope.fdatos.PueDomFis=='')
		{
			scope.fdatos.PueDomFis=null;
		}
		else
		{
			scope.fdatos.PueDomFis=scope.fdatos.PueDomFis;
		}			
		if(scope.fdatos.WebCli==undefined||scope.fdatos.WebCli==null||scope.fdatos.WebCli=='')
		{
			scope.fdatos.WebCli=null;
		}
		else
		{
			scope.fdatos.WebCli=scope.fdatos.WebCli;
		}
		if(scope.fdatos.ObsCli==undefined||scope.fdatos.ObsCli==null||scope.fdatos.ObsCli=='')
		{
			scope.fdatos.ObsCli=null;
		}
		else
		{
			scope.fdatos.ObsCli=scope.fdatos.ObsCli;
		}
		if(scope.fdatos.CodCol==undefined||scope.fdatos.CodCol==null||scope.fdatos.CodCol=='')
		{
			scope.fdatos.CodCol=null;
		}
		else
		{
			scope.fdatos.CodCol=scope.fdatos.CodCol;
		}
		console.log(scope.fdatos);
		var url=base_urlHome()+"api/Clientes/crear_clientes/";
		$http.post(url,scope.fdatos).then(function(result)
		{
			scope.nID=result.data.CodCli;
			if(scope.nID>0)
			{
				//console.log(result.data);
				if(scope.CIF!=undefined)
				{
					$cookies.remove('CIF');
				}				
				$("#crear_clientes").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "Cliente creado satisfactoriamente.",				
				size: 'middle'});
				scope.buscarXID();				
			}
			else
			{
				$("#crear_clientes").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "ha ocurrido un error intentando guardar el usuario por favor intente nuevamente.",
				size: 'middle'});				
			}
		},function(error)
		{
			if(error.status==404 && error.statusText=="Not Found")
			{
				$("#crear_clientes").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "El método que esté intentando usar no puede ser localizado.",
				size: 'middle'});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				$("#crear_clientes").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",
				size: 'middle'});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				$("#crear_clientes").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "Está intentando usar un APIKEY inválido.",
				size: 'middle'});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{
				$("#crear_clientes").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
				bootbox.alert({
				message: "Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",
				size: 'middle'});
			}
		});
	}
	scope.cargar_lista_clientes=function()
	{
		$("#cargando").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
		var url = base_urlHome()+"api/Clientes/list_clientes/";
		$http.get(url).then(function(result)
		{
			if(result.data!=false)
			{
				$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				$scope.predicate = 'id';  
				$scope.reverse = true;						
				$scope.currentPage = 1;  
				$scope.order = function (predicate) 
				{  
					$scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;  
					$scope.predicate = predicate;  
				}; 						
				scope.Tclientes=result.data;
				scope.TclientesBack=result.data;					
				$scope.totalItems = scope.Tclientes.length; 
				$scope.numPerPage = 50;  
				$scope.paginate = function (value) 
				{  
					var begin, end, index;  
					begin = ($scope.currentPage - 1) * $scope.numPerPage;  
					end = begin + $scope.numPerPage;  
					index = scope.Tclientes.indexOf(value);  
					return (begin <= index && index < end);  
				};				
				//console.log(scope.Tclientes);
				scope.fdatos.CodTipCliFil=undefined;
				scope.fdatos.CodPro=undefined;
				scope.fdatos.CodLocFil=undefined;
				scope.fdatos.EstCliFil=undefined;
				scope.funcion_services_filtros();
			}
			else
			{
				$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "No hemos encontrado clientes registrados.",
				size: 'middle'});
				scope.Tclientes=undefined;
			}
		},function(error)
		{
			if(error.status==404 && error.statusText=="Not Found")
			{
				$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "El método que esté intentando usar no puede ser localizado.",
				size: 'middle'});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",
				size: 'middle'});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "Está intentando usar un APIKEY inválido.",
				size: 'middle'});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{
				$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
				bootbox.alert({
				message: "Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",
				size: 'middle'});
			}
		});
	}
	scope.limpiar=function()
	{
		scope.fdatos={};
		scope.validate_form=true;
		scope.enabled_button=false;
		scope.cif_cliente_validado=null;
	}	

	scope.buscarXID=function()
	{
		$("#cargando_I").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active" );
		var url = base_urlHome()+"api/Clientes/buscar_xID/huser/"+scope.nID;
		$http.get(url).then(function(result)
		{
			if(result.data!=false)
			{
				$("#cargando_I").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				ServiceCodLoc.getAll().then(function(dato) 
				{
					scope.tLocalidades = dato;
					scope.filtrarLocalidad();
					scope.filtrarLocalidadFisc();								
					
				}).catch(function(err) 
				{
						console.log(err); //Tratar el error
				});						
				ServiceCodPro.getAll().then(function(dato) 
				{
					scope.tProvidencias = dato;		
				}).catch(function(err) 
				{
					console.log(err); //Tratar el error
				});	
				ServiceCodTipCli.getAll().then(function(dato) 
				{
					scope.tTipoCliente = dato;		
				}).catch(function(err) 
				{
					console.log(err); //Tratar el error
				});
				ServiceCodCom.getAll().then(function(dato) 
				{
					scope.tComerciales = dato;		
				}).catch(function(err) 
				{
					console.log(err); //Tratar el error
				});
				ServiceTipoVias.getAll().then(function(dato) 
				{
					scope.tTiposVias = dato;		
				}).catch(function(err) 
				{
					console.log(err); //Tratar el error
				});
				ServiceSectorCliente.getAll().then(function(dato) 
				{
					scope.tSectores = dato;								
							
				}).catch(function(err) 
				{
					console.log(err); //Tratar el error
				});
				ServiceColaborador.getAll().then(function(dato) 
				{
					scope.tColaboradores = dato;								
							
				}).catch(function(err) 
				{
					console.log(err); //Tratar el error
				});
				ServiceTipoInmueble.getAll().then(function(dato) 
				{
					scope.TtiposInmuebles = dato;								
							
				}).catch(function(err) 
				{
					console.log(err); //Tratar el error
				});
				ServiceBancos.getAll().then(function(dato) 
				{
					scope.tListBanc = dato;
					scope.tListBancBack=dato;								
							
				}).catch(function(err) 
				{
					console.log(err); //Tratar el error
				});	
				scope.fdatos=result.data;		
				
				$scope.predicate1 = 'id';  
				$scope.reverse1 = true;						
				$scope.currentPage1 = 1;  
				$scope.order1 = function (predicate1) 
				{  
					$scope.reverse1 = ($scope.predicate1 === predicate1) ? !$scope.reverse1 : false;  
					$scope.predicate1 = predicate1;  
				};	
				scope.TActividades=result.data.activity_clientes;
				scope.TActividadesBack=result.data.activity_clientes;							
				$scope.totalItems1 = scope.TActividades.length; 
				$scope.numPerPage1 = 50;  
				$scope.paginate1 = function (value1) 
				{  
					var begin1, end1, index1;  
					begin1 = ($scope.currentPage1 - 1) * $scope.numPerPage1;  
					end1 = begin1 + $scope.numPerPage1;  
					index1 = scope.TActividades.indexOf(value1);  
					return (begin1 <= index1 && index1 < end1);  
				};
				scope.tmodal_data={};
				scope.fpuntosuministro={};
				scope.tgribBancos={};
				scope.tActividadesEconomicas=result.data.tActividadesEconomicas;
				scope.tActividadesEconomicasBack=result.data.tActividadesEconomicas;
				scope.tPuntosSuminitros=result.data.tPuntosSuminitros;
				scope.tPuntosSuminitrosBack=result.data.tPuntosSuminitros;
				scope.tCuentaBan=result.data.tCuentasBancarias;
				scope.tCuentaBanBack=result.data.tCuentasBancarias;
				scope.tmodal_data.FecIniActFil=scope.FecIniAct;
				scope.tSeccion1=scope.tActividadesEconomicas;
				scope.tGrupos1=scope.tActividadesEconomicas;
				scope.tEpigrafe1=scope.tActividadesEconomicas;
				scope.fdatos.DesSec=true;
				scope.fdatos.DesGru=true;
				scope.fdatos.DesEpi=true;
				scope.fdatos.EstAct=true;
				scope.fdatos.FecIniAct1=true;
				scope.fdatos.agregar_puntos_suministros=false;
				scope.agregar_cuentas=false;
				scope.fdatos.FecIniAct=	yyyy+'/'+mm+'/'+dd;
				scope.fdatos.AccAct=true;
				scope.cif_cliente_validado=null;
				scope.validate_form=true;
				scope.fdatos.misma_razon=false;
				
				//scope.fdatos.TipRegDir=1;
				if(result.data.CodLocSoc!=result.data.CodLocFis)
				{
					scope.fdatos.distinto_a_social=true;
				}
				else
				{
					scope.fdatos.distinto_a_social=false;
				}
				
				scope.enabled_button=true;
				scope.Activity_Found=true;
				if(result.data.activity_clientes==false)
				{
					scope.TActividades=undefined;
				}
				if(scope.fdatos.agregar_puntos_suministros==false)
				{
					scope.TipRegDir1=true;
					scope.CodTipVia1=true;
					scope.NomViaPunSum1=true;
					scope.NumViaPunSum1=true;
					scope.BloPunSum1=true;
					scope.CodPro1=true;
					scope.CodLoc1=true;
					scope.EstPunSum1=true;
					scope.AccPunSum1=true;
				}
				
				scope.CodBan1=true;
				scope.NumIBan1=true;
				scope.EstCue=true;
				scope.ActBan1=true;	

				
			}
			else
			{
				$("#cargando_I").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "Hubo un error al intentar cargar los datos.",
				size: 'middle'});
			}

		},function(error)
		{
			if(error.status==404 && error.statusText=="Not Found")
			{
				$("#cargando_I").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "El método que esté intentando usar no puede ser localizado.",
				size: 'middle'});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				$("#cargando_I").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",
				size: 'middle'});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				$("#cargando_I").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "Está intentando usar un APIKEY inválido.",
				size: 'middle'});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{
				$("#cargando_I").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
				bootbox.alert({
				message: "Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",
				size: 'middle'});
			}
		});
	}
	scope.borrar_row=function(index,id)
	{
		
		if(scope.Nivel==3)
		{
			Swal.fire({title:"Nivel no Autorizado.",text:"Su nivel no esta autorizado para esta operación.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		bootbox.confirm({
	    title:"Confirmación",
	    message: "¿Está seguro que desea eliminar este registro?",
	    buttons: {
	    cancel: {
	    label: '<i class="fa fa-times"></i> Cancelar'
	    },
	    confirm: {
		label: '<i class="fa fa-check"></i> Confirmar'
		}
		},
		callback: function (result) 
		{
			if (result==false) 
			{ 
				console.log('Cancelando Ando...');
			}     
			else
			{					
				$("#borrando").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
				var url = base_urlHome()+"api/Clientes/borrar_row/hcliente/"+id;
				$http.delete(url).then(function(result)
				{
					if(result.data!=false)
					{
						$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						bootbox.alert({
						message: "Registro Eliminado Correctamente.",
						size: 'middle'});
						scope.Tclientes.splice(index,1);
					}
					else
					{
						$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						bootbox.alert({
						message: "No hemos podido borrar el registro intente nuevamente.",
						size: 'middle'});	
					}

				},function(error)
				{
					if(error.status==404 && error.statusText=="Not Found")
					{
						$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						bootbox.alert({
						message: "El método que esté intentando usar no puede ser localizado.",
						size: 'middle'});
					}
					if(error.status==401 && error.statusText=="Unauthorized")
					{
						$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						bootbox.alert({
						message: "Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",
						size: 'middle'});
					}
					if(error.status==403 && error.statusText=="Forbidden")
					{
						$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						bootbox.alert({
						message: "Está intentando usar un APIKEY inválido.",
						size: 'middle'});
					}
					if(error.status==500 && error.statusText=="Internal Server Error")
					{
						$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
						bootbox.alert({
						message: "Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",
						size: 'middle'});
					}
				});
			}
		}});
	}
	scope.borrar=function()
	{
		if(scope.Nivel==3)
		{
			Swal.fire({title:"Nivel no Autorizado.",text:"Su nivel no esta autorizado para esta operación.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		bootbox.confirm({
	    title:"Confirmación",
	    message: "¿Está seguro que desea eliminar este registro?",
	    buttons: {
	    cancel: {
	    label: '<i class="fa fa-times"></i> Cancelar'
	    },
	    confirm: {
		label: '<i class="fa fa-check"></i> Confirmar'
		}
		},
		callback: function (result) 
		{
			if (result==false) 
			{ 
				console.log('Cancelando Ando...');
			}     
			else
			{					
				$("#borrando").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
				var url = base_urlHome()+"api/Clientes/borrar_row/hcliente/"+scope.fdatos.CodCli;
				$http.delete(url).then(function(result)
				{
					if(result.data!=false)
					{
						$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						bootbox.alert({
						message: "Registro Eliminado Correctamente.",
						size: 'middle'});
						location.href ="#/Clientes/";						
					}
					else
					{
						$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						bootbox.alert({
						message: "No hemos podido borrar el registro intente nuevamente.",
						size: 'middle'});	
					}

				},function(error)
				{
					if(error.status==404 && error.statusText=="Not Found")
					{
						$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						bootbox.alert({
						message: "El método que esté intentando usar no puede ser localizado.",
						size: 'middle'});
					}
					if(error.status==401 && error.statusText=="Unauthorized")
					{
						$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						bootbox.alert({
						message: "Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",
						size: 'middle'});
					}
					if(error.status==403 && error.statusText=="Forbidden")
					{
						$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						bootbox.alert({
						message: "Está intentando usar un APIKEY inválido.",
						size: 'middle'});
					}
					if(error.status==500 && error.statusText=="Internal Server Error")
					{
						$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
						bootbox.alert({
						message: "Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",
						size: 'middle'});
					}
				});
			}
		}});
	}
	scope.buscar_cif_cliente=function()
	{
		//scope.cif_cliente_validado=false;
		if(scope.fdatos.NumCifCli!=undefined)
		{
			scope.cif_cliente_validado=null;
			$("#comprobando_disponibilidad").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active");
			
			var NumCifCli=scope.fdatos.NumCifCli;
			var url= base_urlHome()+"api/Clientes/comprobar_cif/";
			$http.post(url,scope.fdatos).then(function(result)
			{
				if(result.data!=false)
				{					
					scope.cif_cliente_validado=true;
					var all_data=result.data;
					scope.fdatos={};
					scope.fdatos.NumCifCli=NumCifCli;
					$("#comprobando_disponibilidad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					Swal.fire({title:"Datos Encontrados.",
					text:"Se han encontrado datos asociados a este numero de CIF. ¿Desea cargar estos datos?",
					type:"info",
					showCancelButton:!0,
					confirmButtonColor:"#31ce77",
					cancelButtonColor:"#f34943",
					confirmButtonText:"Si, Deseo continuar!"}).then(function(t)
					{
	                    if(t.value==true)
	                    {
	                    	$("#cargando_I").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active" );
	                    	var url = base_urlHome()+"api/Clientes/buscar_datos_clientes/NumCifCli/"+scope.fdatos.NumCifCli;
							$http.get(url).then(function(result)
							{
								if(result.data!=false)
								{
									$("#cargando_I").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
									//Swal.fire({title:"Error.",text:"cargando los datos intente nuevamente.",type:"error",confirmButtonColor:"#188ae2"})
									scope.fdatos=result.data;
									scope.cif_cliente_validado=null;
									scope.enabled_button=true;
									scope.TLocalidadesfiltrada = $filter('filter')(scope.tLocalidades, {CodPro: scope.fdatos.CodProSoc}, true);
									scope.TLocalidadesfiltradaFisc = $filter('filter')(scope.tLocalidades, {CodPro: scope.fdatos.CodProFis}, true);
								}
								else
								{
									scope.cif_cliente_validado=null;
									scope.enabled_button=false;
									swal.fire({title:"Error al mostrar los datos intente nuevamente.",type:"error",confirmButtonColor:"#188ae2"})
								}
								
							},function(error)
							{
								if(error.status==404 && error.statusText=="Not Found")
								{
									$("#cargando_I").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
									bootbox.alert({
									message: "El método que esté intentando usar no puede ser localizado.",
									size: 'middle'});
								}
								if(error.status==401 && error.statusText=="Unauthorized")
								{
									$("#cargando_I").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
									bootbox.alert({
									message: "Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",
									size: 'middle'});
								}
								if(error.status==403 && error.statusText=="Forbidden")
								{
									$("#cargando_I").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
									bootbox.alert({
									message: "Está intentando usar un APIKEY inválido.",
									size: 'middle'});
								}
								if(error.status==500 && error.statusText=="Internal Server Error")
								{
									$("#cargando_I").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
									bootbox.alert({
									message: "Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",
									size: 'middle'});
								}	
							});
	                    }
	                    else
	                    {
							scope.cif_cliente_validado=null;							
	                    }
	                });
				}
				else
				{
					//console.log(result.data);
					$("#comprobando_disponibilidad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					scope.cif_cliente_validado=false;
					scope.enabled_button=true;
					scope.fdatos={};
					scope.fdatos.NumCifCli=NumCifCli;
				}
			},function(error)
			{	
				if(error.status==404 && error.statusText=="Not Found")
				{
					$("#comprobando_disponibilidad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					bootbox.alert({
					message: "El método que esté intentando usar no puede ser localizado.",
					size: 'middle'});
				}
				if(error.status==401 && error.statusText=="Unauthorized")
				{
					$("#comprobando_disponibilidad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					bootbox.alert({
					message: "Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",
					size: 'middle'});
				}
				if(error.status==403 && error.statusText=="Forbidden")
				{
					$("#comprobando_disponibilidad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					bootbox.alert({
					message: "Está intentando usar un APIKEY inválido.",
					size: 'middle'});
				}
				if(error.status==500 && error.statusText=="Internal Server Error")
				{
					$("#comprobando_disponibilidad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
					bootbox.alert({
					message: "Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",
					size: 'middle'});
				}

			});

		}
		else
		{
			scope.cif_cliente_validado=null;
		}
	}
	scope.validar_form=function()
	{
		
		if($route.current.$$route.originalPath=="/Editar_Clientes/:ID")
		{
			Swal.fire({title:"Error!.",text:"Estimado Usuario Por Favor Pulse el Boton Regresar Para Salir de Esta Vista.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}

		scope.validate_form=true;
		scope.fdatos={};
		scope.enabled_button=false;
		scope.cif_cliente_validado=null;
	}

	scope.filtrarLocalidad =  function()
	{
		scope.TLocalidadesfiltrada = $filter('filter')(scope.tLocalidades, {CodPro: scope.fdatos.CodProSoc}, true);
		if(scope.fdatos.distinto_a_social==false && scope.nID==undefined)
		{
			scope.fdatos.CodProFis=scope.fdatos.CodProSoc;
			scope.filtrarLocalidadFisc();	
		}

		//console.log(scope.TLocalidadesfiltrada);
	}
	
	scope.filtrarLocalidadFisc =  function()
	{
		scope.TLocalidadesfiltradaFisc = $filter('filter')(scope.tLocalidades, {CodPro: scope.fdatos.CodProFis}, true);
		//console.log(scope.TLocalidadesfiltradaFisc);
	}
	scope.filtrar_zona_postal =  function()
	{
		scope.CodLocZonaPostal = $filter('filter')(scope.tLocalidades, {CodLoc: scope.fdatos.CodLocSoc}, true);
		angular.forEach(scope.CodLocZonaPostal, function(data)
		{					
			scope.fdatos.ZonPosSoc=data.CPLoc;						
		});
		if(scope.fdatos.distinto_a_social==false && scope.nID==undefined)
		{
			scope.fdatos.CodLocFis=scope.fdatos.CodLocSoc;
			scope.filtrar_zona_postalFis();	
		}
		
		//console.log(scope.fdatos.ZonPos);
	}
	scope.filtrar_zona_postalFis =  function()
	{
		scope.CodLocZonaPostal = $filter('filter')(scope.tLocalidades, {CodLoc: scope.fdatos.CodLocFis}, true);
		angular.forEach(scope.CodLocZonaPostal, function(data)
		{					
			scope.fdatos.ZonPosFis=data.CPLoc;						
		});
		//console.log(scope.fdatos.ZonPos);
	}
	
	scope.filtrar_grib = function(expresion)
	{
		if (expresion.length>0)
		{
			//
			$scope.predicate = 'id';  
			$scope.reverse = true;						
			$scope.currentPage = 1;  
			$scope.order = function (predicate) 
			{  
				$scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;  
				$scope.predicate = predicate;  
			}; 						
			scope.Tclientes = $filter('filter')(scope.TclientesBack, {NumCifCli: expresion});								
			$scope.totalItems = scope.Tclientes.length; 
			$scope.numPerPage = 50;  
			$scope.paginate = function (value) 
			{  
				var begin, end, index;  
				begin = ($scope.currentPage - 1) * $scope.numPerPage;  
				end = begin + $scope.numPerPage;  
				index = scope.Tclientes.indexOf(value);  
				return (begin <= index && index < end);  
			};				
		}
		else
		{
			$scope.predicate = 'id';  
			$scope.reverse = true;						
			$scope.currentPage = 1;  
			$scope.order = function (predicate) 
			{  
				$scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;  
				$scope.predicate = predicate;  
			}; 						
			scope.Tclientes=scope.TclientesBack;								
			$scope.totalItems = scope.Tclientes.length; 
			$scope.numPerPage = 50;  
			$scope.paginate = function (value) 
			{  
				var begin, end, index;  
				begin = ($scope.currentPage - 1) * $scope.numPerPage;  
				end = begin + $scope.numPerPage;  
				index = scope.Tclientes.indexOf(value);  
				return (begin <= index && index < end);  
			};			

		}
		
	}	
	scope.validar_opcion=function(index,opcion,datos)
	{
		if(opcion==1)
		{
			location.href ="#/Editar_Clientes/"+datos.CodCli+"/"+1;
		}
		if(opcion==2)
		{
	        location.href ="#/Editar_Clientes/"+datos.CodCli;
		}
		if(opcion==3)
		{
			//console.log(datos);
			if(datos.EstCli==3)
			{
				scope.opciones_clientes[index]=undefined;
				Swal.fire({title:"Error!.",text:"Ya este cliente se encuentra activo.",type:"error",confirmButtonColor:"#188ae2"});
				return false;
			}
			Swal.fire({title:"¿Esta Seguro de Activar Este Cliente?",
			type:"info",
			showCancelButton:!0,
			confirmButtonColor:"#31ce77",
			cancelButtonColor:"#f34943",
			confirmButtonText:"Activar"}).then(function(t)
			{
	            if(t.value==true)
	            {
	               	scope.datos_update={};
					scope.datos_update.opcion=opcion;
					scope.datos_update.hcliente=datos.CodCli;
					var url = base_urlHome()+"api/Clientes/update_status/";
					$http.post(url,scope.datos_update).then(function(result)
					{
						if(result.data!=false)
						{
							Swal.fire({title:"Exito!.",text:"El Cliente a sido activado correctamente.",type:"success",confirmButtonColor:"#188ae2"});
							scope.cargar_lista_clientes();
							scope.opciones_clientes[index]=undefined;
						}
						else
						{
							Swal.fire({title:"Error.",text:"Hubo un error al ejecutar esta acción por favor intente nuevamente.",type:"error",confirmButtonColor:"#188ae2"});
							scope.cargar_lista_clientes();
						}
					},function(error)
					{
						if(error.status==404 && error.statusText=="Not Found")
						{
							//$("#comprobando_disponibilidad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
							bootbox.alert({
							message: "El método que esté intentando usar no puede ser localizado.",
							size: 'middle'});
						}
						if(error.status==401 && error.statusText=="Unauthorized")
						{
							//$("#comprobando_disponibilidad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
							bootbox.alert({
							message: "Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",
							size: 'middle'});
						}
						if(error.status==403 && error.statusText=="Forbidden")
						{
							//$("#comprobando_disponibilidad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
							bootbox.alert({
							message: "Está intentando usar un APIKEY inválido.",
							size: 'middle'});
						}
						if(error.status==500 && error.statusText=="Internal Server Error")
						{
							//$("#comprobando_disponibilidad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
							bootbox.alert({
							message: "Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",
							size: 'middle'});
						}
					});
	            }
	            else
	            {
	                console.log('Cancelando ando...');
	                scope.opciones_clientes[index]=undefined;
	            }
	        });

		}

		if(opcion==4)
		{

			if(datos.EstCli==4)
			{
				scope.opciones_clientes[index]=undefined;
				Swal.fire({title:"Error!.",text:"Ya este cliente se encuentra bloqueado.",type:"error",confirmButtonColor:"#188ae2"});
				return false;
			}
			//console.log(datos);
			scope.tmodal_data={};
			scope.tmodal_data.CodCli=datos.CodCli;
			scope.tmodal_data.NumCif=datos.NumCifCli;
			var url = base_urlHome()+"api/Clientes/Consulta_Fecha/";
			$http.get(url).then(function(result)
			{
				scope.tmodal_data.FechBlo=result.data;

			},function(error)
			{

			});
			scope.tmodal_data.RazSoc=datos.RazSocCli;			
	        scope.opciones_clientes[index]=undefined;
	        scope.cargar_lista_motivos_bloqueos();	            	
	        $("#modal_motivo_bloqueo").modal('show'); 
		}	
	}
	$scope.submitFormlock = function(event) 
	{      
	 	//console.log(scope.tmodal_data);
	 	Swal.fire({title:"¿Esta Seguro de Bloquear Este Cliente?",
			type:"info",
			showCancelButton:!0,
			confirmButtonColor:"#31ce77",
			cancelButtonColor:"#f34943",
			confirmButtonText:"Bloquear"}).then(function(t)
			{
	            if(t.value==true)
	            {
	             	scope.datos_update={};
					scope.datos_update.opcion=4;
					scope.datos_update.hcliente=scope.tmodal_data.CodCli;
					scope.datos_update.CodMotBloCli=scope.tmodal_data.MotBloq;
					
					if(scope.tmodal_data.ObsBloCli==undefined|| scope.tmodal_data.ObsBloCli==null||scope.tmodal_data.ObsBloCli=='')
					{
						scope.datos_update.ObsBloCli=null;
					}
					else
					{
						scope.datos_update.ObsBloCli=scope.tmodal_data.ObsBloCli;
					}										
					var url = base_urlHome()+"api/Clientes/update_status/";
					$http.post(url,scope.datos_update).then(function(result)
					{
						if(result.data!=false)
						{
							$("#modal_motivo_bloqueo").modal('hide');
							Swal.fire({title:"Exito!.",text:"El Cliente fue bloqueado correctamente.",type:"success",confirmButtonColor:"#188ae2"});
							scope.cargar_lista_clientes();							
						}
						else
						{
							Swal.fire({title:"Error.",text:"Hubo un error al ejecutar esta acción por favor intente nuevamente.",type:"error",confirmButtonColor:"#188ae2"});
							scope.cargar_lista_clientes();
						}
					},function(error)
					{
						if(error.status==404 && error.statusText=="Not Found")
						{
							//$("#comprobando_disponibilidad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
							bootbox.alert({
							message: "El método que esté intentando usar no puede ser localizado.",
							size: 'middle'});
						}
						if(error.status==401 && error.statusText=="Unauthorized")
						{
							//$("#comprobando_disponibilidad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
							bootbox.alert({
							message: "Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",
							size: 'middle'});
						}
						if(error.status==403 && error.statusText=="Forbidden")
						{
							//$("#comprobando_disponibilidad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
							bootbox.alert({
							message: "Está intentando usar un APIKEY inválido.",
							size: 'middle'});
						}
						if(error.status==500 && error.statusText=="Internal Server Error")
						{
							//$("#comprobando_disponibilidad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
							bootbox.alert({
							message: "Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",
							size: 'middle'});
						}
					}); 
	              
	            }
	            else
	            {
	                console.log('Cancelando ando...');
	                
	            }
	        });		
	};

	$scope.submitFormPuntoSuministro = function(event) 
	{ 	
	 	if (!scope.validar_campos_punto_suministro())
		{
			return false;
		}
		if(scope.fpuntosuministro.BloPunSum==undefined||scope.fpuntosuministro.BloPunSum==null||scope.fpuntosuministro.BloPunSum=='')
		{
			scope.fpuntosuministro.BloPunSum=null;
		}
		else
		{
			scope.fpuntosuministro.BloPunSum=scope.fpuntosuministro.BloPunSum;
		}
		if(scope.fpuntosuministro.EscPunSum==undefined||scope.fpuntosuministro.EscPunSum==null||scope.fpuntosuministro.EscPunSum=='')
		{
			scope.fpuntosuministro.EscPunSum=null;
		}
		else
		{
			scope.fpuntosuministro.EscPunSum=scope.fpuntosuministro.EscPunSum;
		}
		if(scope.fpuntosuministro.PlaPunSum==undefined||scope.fpuntosuministro.PlaPunSum==null||scope.fpuntosuministro.PlaPunSum=='')
		{
			scope.fpuntosuministro.PlaPunSum=null;
		}
		else
		{
			scope.fpuntosuministro.PlaPunSum=scope.fpuntosuministro.PlaPunSum;
		}
		if(scope.fpuntosuministro.PuePunSum==undefined||scope.fpuntosuministro.PuePunSum==null||scope.fpuntosuministro.PuePunSum=='')
		{
			scope.fpuntosuministro.PuePunSum=null;
		}
		else
		{
			scope.fpuntosuministro.PuePunSum=scope.fpuntosuministro.PuePunSum;
		}
		if(scope.fpuntosuministro.Aclarador==undefined||scope.fpuntosuministro.Aclarador==null||scope.fpuntosuministro.Aclarador=='')
		{
			scope.fpuntosuministro.Aclarador=null;
		}
		else
		{
			scope.fpuntosuministro.Aclarador=scope.fpuntosuministro.Aclarador;
		}
		if(scope.fpuntosuministro.RefCasPunSum==undefined||scope.fpuntosuministro.RefCasPunSum==null||scope.fpuntosuministro.RefCasPunSum=='')
		{
			scope.fpuntosuministro.RefCasPunSum=null;
		}
		else
		{
			scope.fpuntosuministro.RefCasPunSum=scope.fpuntosuministro.RefCasPunSum;
		}
		if(scope.fpuntosuministro.DimPunSum==undefined||scope.fpuntosuministro.DimPunSum==null||scope.fpuntosuministro.DimPunSum=='')
		{
			scope.fpuntosuministro.DimPunSum=null;
		}
		else
		{
			scope.fpuntosuministro.DimPunSum=scope.fpuntosuministro.DimPunSum;
		}
		if(scope.fpuntosuministro.ObsPunSum==undefined||scope.fpuntosuministro.ObsPunSum==null||scope.fpuntosuministro.ObsPunSum=='')
		{
			scope.fpuntosuministro.ObsPunSum=null;
		}
		else
		{
			scope.fpuntosuministro.ObsPunSum=scope.fpuntosuministro.ObsPunSum;
		}
		scope.fpuntosuministro.CodCli=scope.fdatos.CodCli;
		console.log(scope.fpuntosuministro);
	 	Swal.fire({title:"¿Esta Seguro de agregar esta Punto de Suministro?",
			type:"question",
			showCancelButton:!0,
			confirmButtonColor:"#31ce77",
			cancelButtonColor:"#f34943",
			confirmButtonText:"OK"}).then(function(t)
			{
	            if(t.value==true)
	            {								
					var url = base_urlHome()+"api/Clientes/crear_punto_suministro_cliente/";
					$http.post(url,scope.fpuntosuministro).then(function(result)
					{
						scope.fpuntosuministro=result.data;
						if(result.data!=false)
						{
							Swal.fire({title:"Exito!.",text:"El Punto de Suministro a sido registrado correctamente.",type:"success",confirmButtonColor:"#188ae2"});
							//scope.buscarXCodPunSum();							
						}
						else
						{
							Swal.fire({title:"Error.",text:"Hubo un error al ejecutar esta acción por favor intente nuevamente.",type:"error",confirmButtonColor:"#188ae2"});							
						}
					},function(error)
					{
						if(error.status==404 && error.statusText=="Not Found")
						{
							//$("#comprobando_disponibilidad").removeClass("loader loader-default is-active" ).addClass( "loader loader-default" );
							bootbox.alert({
							message: "El método que esté intentando usar no puede ser localizado.",
							size: 'middle'});
						}
						if(error.status==401 && error.statusText=="Unauthorized")
						{
							//$("#comprobando_disponibilidad").removeClass("loader loader-default is-active" ).addClass( "loader loader-default" );
							bootbox.alert({
							message: "Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",
							size: 'middle'});
						}
						if(error.status==403 && error.statusText=="Forbidden")
						{
							//$("#comprobando_disponibilidad").removeClass("loader loader-default is-active" ).addClass( "loader loader-default" );
							bootbox.alert({
							message: "Está intentando usar un APIKEY inválido.",
							size: 'middle'});
						}
						if(error.status==500 && error.statusText=="Internal Server Error")
						{
							//$("#comprobando_disponibilidad").removeClass("loader loader-default is-active" ).addClass( "loader loader-default" );				
							bootbox.alert({
							message: "Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",
							size: 'middle'});
						}
					}); 
	              
	            }
	            else
	            {
	                console.log('Cancelando ando...');
	                
	            }
	        });		
	}; 
	scope.buscarXCodPunSum=function()
	{
		var url = base_urlHome()+"api/Clientes/buscarXID_PunSum/CodPunSum/"+scope.nCodPunSum;
		$http.get(url).then(function(result)
		{
			if(result.data!=false)
			{			
				scope.fpuntosuministro=result.data;					
			}
			else
			{
				bootbox.alert({
				message: "Hubo un error al intentar cargar los datos.",
				size: 'middle'});
			}

		},function(error)
		{
			if(error.status==404 && error.statusText=="Not Found")
			{
				bootbox.alert({
				message: "El método que esté intentando usar no puede ser localizado.",
				size: 'middle'});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				bootbox.alert({
				message: "Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",
				size: 'middle'});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				bootbox.alert({
				message: "Está intentando usar un APIKEY inválido.",
				size: 'middle'});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{				
				bootbox.alert({
				message: "Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",
				size: 'middle'});
			}
		});
	}
	scope.validar_campos_punto_suministro = function()
	{
		resultado = true;
		if (!scope.fpuntosuministro.TipRegDir > 0)
		{
			Swal.fire({title:"Debe Seleccionar el Tipo de Dirección",type:"error",confirmButtonColor:"#188ae2"});
			return false;
			}				
		if (!scope.fpuntosuministro.CodTipVia > 0)
		{
			Swal.fire({title:"Debe Seleccionar un Tipo de Via.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}								
		if (scope.fpuntosuministro.NomViaPunSum==null || scope.fpuntosuministro.NomViaPunSum==undefined || scope.fpuntosuministro.NomViaPunSum=='')
		{
			Swal.fire({title:"El Nombre del Domicilio es Requerido.",type:"error",confirmButtonColor:"#188ae2"});		           
			return false;
		}
		if (scope.fpuntosuministro.NumViaPunSum==null || scope.fpuntosuministro.NumViaPunSum==undefined || scope.fpuntosuministro.NumViaPunSum=='')
		{
			Swal.fire({title:"El Número del Domicilio es Requerido.",type:"error",confirmButtonColor:"#188ae2"});		           
			return false;
		}				
		if (!scope.fpuntosuministro.CodProPunSum > 0)
		{
			Swal.fire({title:"Debe seleccionar una Provincia de la lista.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}				
		if (!scope.fpuntosuministro.CodLocPunSum > 0)
		{
			Swal.fire({title:"Debe seleccionar una Localidad de la lista.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (scope.fpuntosuministro.TelPunSum==null || scope.fpuntosuministro.TelPunSum==undefined || scope.fpuntosuministro.TelPunSum=='')
		{
			Swal.fire({title:"El Campo Número de Teléfono es Requerido.",type:"error",confirmButtonColor:"#188ae2"});		           
			return false;
		}				
		if (!scope.fpuntosuministro.CodTipInm > 0)
		{
			Swal.fire({title:"Debe seleccionar un tipo de inmueble de la lista.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (resultado == false)
		{
			return false;
		} 
			return true;
	}
	scope.filtrarLocalidadPunSum =  function()
	{
		scope.TLocalidadesfiltradaPunSum = $filter('filter')(scope.tLocalidades, {CodPro: scope.fpuntosuministro.CodProPunSum}, true);
	}
	scope.filtrar_zona_postalPunSum =  function()
	{
		scope.CodLocZonaPostalPunSum = $filter('filter')(scope.tLocalidades, {CodLoc: scope.fpuntosuministro.CodLocPunSum}, true);
		angular.forEach(scope.CodLocZonaPostalPunSum, function(data)
		{					
			scope.ZonPosPunSum=data.CPLoc;						
		});
	} 
	scope.asignar_punto_suministro=function()
	{
		scope.fdatos.agregar_puntos_suministros=true;
	}
	scope.regresar_punto_suministro=function()
	{
		scope.fdatos.agregar_puntos_suministros=false;
		scope.fpuntosuministro={};
		scope.fpuntosuministro.TipRegDir1=true;
		scope.fpuntosuministro.CodTipVia1=true;
		scope.fpuntosuministro.NomViaPunSum1=true;
		scope.fpuntosuministro.NumViaPunSum1=true;
		scope.fpuntosuministro.BloPunSum1=true;
		scope.fpuntosuministro.CodPro1=true;
		scope.fpuntosuministro.CodLoc1=true;
		scope.fpuntosuministro.EstPunSum1=true;
		scope.fpuntosuministro.AccPunSum1=true;
		scope.ZonPosPunSum=undefined;
		if(scope.nID>0&&scope.MET==undefined)
		{
			scope.validate_info=undefined;
		}
		scope.mostrar_all_puntos();
	}
	scope.validar_PunSum=function(index,opciones_PunSum,dato)
	{
		console.log(index);
		console.log(opciones_PunSum);
		console.log(dato);
		if(opciones_PunSum==1)
		{
			if(dato.EstPunSum==1)
			{
				scope.opciones_PunSum[index]=undefined;
				Swal.fire({title:"Este Punto de Suministro Ya Se Encuentra Activo.",type:"error",confirmButtonColor:"#188ae2"});
				return false;
			}
			scope.opciones_PunSum[index]=undefined;
			scope.tPunSum={};
			scope.tPunSum.opcion=opciones_PunSum;
			scope.tPunSum.CodPunSum=dato.CodPunSum;
			scope.tPunSum.CodCli=dato.CodCli;
			var url = base_urlHome()+"api/Clientes/bloquear_PunSum/";
			$http.post(url,scope.tPunSum).then(function(result)
			{
				if(result.data!=false)
				{
					Swal.fire({title:"Exito!.",text:"El Punto de Suministro a sido activo correctamente.",type:"success",confirmButtonColor:"#188ae2"});
					scope.mostrar_all_puntos();				
				}
				else
				{
					Swal.fire({title:"Error.",text:"Hubo un error al ejecutar esta acción por favor intente nuevamente.",type:"error",confirmButtonColor:"#188ae2"});							
				}
			},function(error)
			{
				if(error.status==404 && error.statusText=="Not Found")
				{
					//$("#comprobando_disponibilidad").removeClass("loader loader-default is-active" ).addClass( "loader loader-default" );
					bootbox.alert({
					message: "El método que esté intentando usar no puede ser localizado.",
					size: 'middle'});
				}
				if(error.status==401 && error.statusText=="Unauthorized")
				{
					//$("#comprobando_disponibilidad").removeClass("loader loader-default is-active" ).addClass( "loader loader-default" );
					bootbox.alert({
					message: "Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",
					size: 'middle'});
				}
				if(error.status==403 && error.statusText=="Forbidden")
				{
					//$("#comprobando_disponibilidad").removeClass("loader loader-default is-active" ).addClass( "loader loader-default" );
					bootbox.alert({
					message: "Está intentando usar un APIKEY inválido.",
					size: 'middle'});
				}
				if(error.status==500 && error.statusText=="Internal Server Error")
				{
					//$("#comprobando_disponibilidad").removeClass("loader loader-default is-active" ).addClass( "loader loader-default" );				
					bootbox.alert({
					message: "Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",
					size: 'middle'});
				}
			});
		}
		if(opciones_PunSum==2)
		{
			if(dato.EstPunSum==2)
			{
				scope.opciones_PunSum[index]=undefined;
				Swal.fire({title:"Este Punto de Suministro Ya Se Encuentra Bloqueado.",type:"error",confirmButtonColor:"#188ae2"});
				return false;
			}
			scope.tPunSum={};
			scope.tPunSum.CodPunSum=dato.CodPunSum;
			scope.FecBloPun=scope.FecIniAct;
			scope.tPunSum.opcion=opciones_PunSum;
			console.log(scope.tPunSum);
			scope.cargar_lista_motivos_bloqueos_puntos_suministros();
			scope.opciones_PunSum[index]=undefined;
			$("#modal_motivo_bloqueo_punto_suministro").modal('show');
		}
		if(opciones_PunSum==3)
		{
			scope.fpuntosuministro=dato;
			scope.ZonPosPunSum=dato.ZonPosPunSum;
			scope.filtrarLocalidadPunSum();
			scope.fdatos.agregar_puntos_suministros=true;
			scope.validate_info=undefined;
			scope.opciones_PunSum[index]=undefined;

		}
		if(opciones_PunSum==4)
		{
			scope.validate_info=1;
			scope.fpuntosuministro=dato;
			scope.ZonPosPunSum=dato.ZonPosPunSum;
			scope.filtrarLocalidadPunSum();
			scope.fdatos.agregar_puntos_suministros=true;			
			scope.opciones_PunSum[index]=undefined;
		}


	}
	$scope.submitFormlockPunSum = function(event) 
	{ 
		if(scope.tPunSum.ObsPunSum==undefined||scope.tPunSum.ObsPunSum==null||scope.tPunSum.ObsPunSum=='')
		{
			scope.tPunSum.ObsPunSum=null;
		}
		else
		{
			scope.tPunSum.ObsPunSum=scope.tPunSum.ObsPunSum;
		}
		scope.tPunSum.CodCli=scope.fdatos.CodCli;

		var fecha_a_convertir= (scope.FecBloPun).split("-");
		var h1=new Date();			
		var convertida = fecha_a_convertir[2]+"/"+fecha_a_convertir[1]+"/"+fecha_a_convertir[0];
		//console.log(convertida);
		scope.tPunSum.FecBloPun=convertida;
		console.log(scope.tPunSum);
	 	Swal.fire({title:"¿Esta Seguro de Bloquear esta Punto de Suministro?",
			type:"question",
			showCancelButton:!0,
			confirmButtonColor:"#31ce77",
			cancelButtonColor:"#f34943",
			confirmButtonText:"OK"}).then(function(t)
			{
	            if(t.value==true)
	            {								
					var url = base_urlHome()+"api/Clientes/bloquear_PunSum/";
					$http.post(url,scope.tPunSum).then(function(result)
					{
						scope.tPunSum=result.data;
						if(result.data!=false)
						{
							Swal.fire({title:"Exito!.",text:"El Punto de Suministro a sido bloqueado correctamente.",type:"success",confirmButtonColor:"#188ae2"});
							$("#modal_motivo_bloqueo_punto_suministro").modal('hide');
							scope.mostrar_all_puntos();							
						}
						else
						{
							Swal.fire({title:"Error.",text:"Hubo un error al ejecutar esta acción por favor intente nuevamente.",type:"error",confirmButtonColor:"#188ae2"});							
						}
					},function(error)
					{
						if(error.status==404 && error.statusText=="Not Found")
						{
							//$("#comprobando_disponibilidad").removeClass("loader loader-default is-active" ).addClass( "loader loader-default" );
							bootbox.alert({
							message: "El método que esté intentando usar no puede ser localizado.",
							size: 'middle'});
						}
						if(error.status==401 && error.statusText=="Unauthorized")
						{
							//$("#comprobando_disponibilidad").removeClass("loader loader-default is-active" ).addClass( "loader loader-default" );
							bootbox.alert({
							message: "Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",
							size: 'middle'});
						}
						if(error.status==403 && error.statusText=="Forbidden")
						{
							//$("#comprobando_disponibilidad").removeClass("loader loader-default is-active" ).addClass( "loader loader-default" );
							bootbox.alert({
							message: "Está intentando usar un APIKEY inválido.",
							size: 'middle'});
						}
						if(error.status==500 && error.statusText=="Internal Server Error")
						{
							//$("#comprobando_disponibilidad").removeClass("loader loader-default is-active" ).addClass( "loader loader-default" );				
							bootbox.alert({
							message: "Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",
							size: 'middle'});
						}
					}); 
	              
	            }
	            else
	            {
	                console.log('Cancelando ando...');
	                
	            }
	        });		
	}; 
	scope.mostrar_all_puntos=function()
	{
		var url=base_urlHome()+"api/Clientes/get_all_puntos_sum/hcliente/"+scope.nID;
		$http.get(url).then(function(result)
		{
			if(result.data!=false)
			{
				$scope.predicate2 = 'id';  
				$scope.reverse2 = true;						
				$scope.currentPage2 = 1;  
				$scope.order2 = function (predicate2) 
				{  
					$scope.reverse2 = ($scope.predicate2 === predicate2) ? !$scope.reverse2 : false;  
					$scope.predicate2 = predicate2;  
				}; 						
				scope.tPuntosSuminitros=result.data;
				scope.tPuntosSuminitrosBack=result.data;								
				$scope.totalItems2 = scope.tPuntosSuminitros.length; 
				$scope.numPerPage2 = 50;  
				$scope.paginate2 = function (value2) 
				{  
					var begin2, end2, index2;  
					begin2 = ($scope.currentPage2 - 1) * $scope.numPerPage2;  
					end2 = begin2 + $scope.numPerPage2;  
					index2 = scope.tPuntosSuminitros.indexOf(value2);  
					return (begin2 <= index2 && index2 < end2);  
				};		
			}
			else
			{
				
			}

		},function(error)
		{
			if(error.status==404 && error.statusText=="Not Found")
			{
				//$("#comprobando_disponibilidad").removeClass("loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "El método que esté intentando usar no puede ser localizado.",
				size: 'middle'});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				//$("#comprobando_disponibilidad").removeClass("loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",
				size: 'middle'});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				//$("#comprobando_disponibilidad").removeClass("loader loader-default is-active" ).addClass( "loader loader-default" );
				bootbox.alert({
				message: "Está intentando usar un APIKEY inválido.",
				size: 'middle'});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{
				//$("#comprobando_disponibilidad").removeClass("loader loader-default is-active" ).addClass( "loader loader-default" );				
				bootbox.alert({
				message: "Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",
				size: 'middle'});
			}
		});
		/*
		console.log(scope.tPuntosSuminitros);*/

		
	}
	
	scope.validarsinuermoPumSumArea=function(object)
	{
		if(object!=undefined)
		{
			numero=object;		
			if(!/^([+0-9])*$/.test(numero))
			scope.fpuntosuministro.DimPunSum=numero.substring(0,numero.length-1);
		}
	}

	//////////////////////////////////CUENTAS BANCARIAS START ///////////////////////////////////////////

	scope.asignar_cuenta_bancaria=function()
	{
		scope.agregar_cuentas=true;
	}

	scope.regresar_cuenta_bancaria=function()
	{
		scope.agregar_cuentas=false;
		scope.tgribBancos.CodBan=undefined;
		scope.CodEur=undefined;
		scope.IBAN1=undefined;
		scope.IBAN2=undefined;
		scope.IBAN3=undefined;
		scope.IBAN4=undefined;
		scope.IBAN5=undefined;
	}
	scope.filtrar_cod_banco =  function()
	{
		scope.CodEurBan = $filter('filter')(scope.tListBancBack, {CodBan: scope.tgribBancos.CodBan}, true);
		angular.forEach(scope.CodEurBan, function(data)
		{					
			scope.CodEur=data.CodEurMod;						
		});
	}
	scope.validarsinuermoCodEur=function(object)
	{
		if(object!=undefined)
		{
			numero=object;		
			if(!/^([a-zA-Z0-9])*$/.test(numero))
			scope.CodEur=numero.substring(0,numero.length-1);
		}
	}
	scope.validarsinuermoIBAN1=function(object)
	{
		if(object!=undefined)
		{
			numero=object;		
			if(!/^([0-9])*$/.test(numero))
			scope.IBAN1=numero.substring(0,numero.length-1);
		}
	}
	scope.validarsinuermoIBAN2=function(object)
	{
		if(object!=undefined)
		{
			numero=object;		
			if(!/^([0-9])*$/.test(numero))
			scope.IBAN2=numero.substring(0,numero.length-1);
		}
	}
	scope.validarsinuermoIBAN3=function(object)
	{
		if(object!=undefined)
		{
			numero=object;		
			if(!/^([0-9])*$/.test(numero))
			scope.IBAN3=numero.substring(0,numero.length-1);
		}
	}
	scope.validarsinuermoIBAN4=function(object)
	{
		if(object!=undefined)
		{
			numero=object;		
			if(!/^([0-9])*$/.test(numero))
			scope.IBAN4=numero.substring(0,numero.length-1);
		}
	}
	scope.validarsinuermoIBAN5=function(object)
	{
		if(object!=undefined)
		{
			numero=object;		
			if(!/^([0-9])*$/.test(numero))
			scope.IBAN5=numero.substring(0,numero.length-1);
		}
	}
	$scope.submitFormRegistroCuentaBanca = function(event) 
	{ 
		scope.tgribBancos.CodCli=scope.nID;
		scope.tgribBancos.NumIBan=scope.CodEur+''+scope.IBAN1+''+scope.IBAN2+''+scope.IBAN3+''+scope.IBAN4+''+scope.IBAN5;
		console.log(scope.tgribBancos);
	 	scope.numIBanValidado=true;
	 	var url = base_urlHome()+"api/Clientes/Comprobar_Cuenta_Bancaria/";
	 	$http.post(url,scope.tgribBancos).then(function(result)
	 	{
	 		if(result.data==true)
	 		{
	 			Swal.fire({title:"Error.",text:"Este Número de Cuenta Ya Se Encuentra Registrado.",type:"error",confirmButtonColor:"#188ae2"});
	 			scope.numIBanValidado=false;
	 			return false;
	 		}
	 		else
	 		{
	 			//scope.numIBanValidado=false;
	 			Swal.fire({title:"¿Esta Seguro de agregar este nuevo registro?",
				type:"question",
				showCancelButton:!0,
				confirmButtonColor:"#31ce77",
				cancelButtonColor:"#f34943",
				confirmButtonText:"OK"}).then(function(t)
				{
		            if(t.value==true)
		            {								
						var url = base_urlHome()+"api/Clientes/crear_cuenta_bancaria/";
						$http.post(url,scope.tgribBancos).then(function(result)
						{
							scope.tgribBancos=result.data;
							if(result.data!=false)
							{
								Swal.fire({title:"Exito!.",text:"Cuenta Bancaria creada satisfactoriamente.",type:"success",confirmButtonColor:"#188ae2"});
								scope.numIBanValidado=false;
								scope.cargar_cuentas_bancarias();													
							}
							else
							{
								Swal.fire({title:"Error.",text:"Hubo un error al ejecutar esta acción por favor intente nuevamente.",type:"error",confirmButtonColor:"#188ae2"});							
								scope.numIBanValidado=false;
								scope.cargar_cuentas_bancarias();
							}
						},function(error)
						{
							if(error.status==404 && error.statusText=="Not Found")
							{
								scope.numIBanValidado=false;
								Swal.fire({title:"Error.",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
							}
							if(error.status==401 && error.statusText=="Unauthorized")
							{
								scope.numIBanValidado=false;
								Swal.fire({title:"Error en Permisos.",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"info",confirmButtonColor:"#188ae2"});
							}
							if(error.status==403 && error.statusText=="Forbidden")
							{
								scope.numIBanValidado=false;
								Swal.fire({title:"Seguridad.",text:"Está intentando usar un APIKEY inválido.",type:"question",confirmButtonColor:"#188ae2"});
							}
							if(error.status==500 && error.statusText=="Internal Server Error")
							{				
								scope.numIBanValidado=false;
								Swal.fire({title:"Error.",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
							}
						}); 
		              
		            }
		            else
		            {
		            	event.preventDefault();
		               	scope.numIBanValidado=false;
		               	scope.cargar_cuentas_bancarias();
		                console.log('Cancelando ando...');
		            }
		        });	
	 		}//end else////
	 	},function(error)
	 	{	
	 		if(error.status==404 && error.statusText=="Not Found")
			{
				Swal.fire({title:"Error.",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				Swal.fire({title:"Error en Permisos.",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"info",confirmButtonColor:"#188ae2"});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				Swal.fire({title:"Seguridad.",text:"Está intentando usar un APIKEY inválido.",type:"question",confirmButtonColor:"#188ae2"});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{				
				Swal.fire({title:"Error.",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
			}
	 	});
	}; 
	scope.validar_OpcBan=function(index,opcion,datos)
	{

		//console.log(index);
		//console.log(opcion);
		//console.log(datos);
		scope.bloquear_cueban={};
		scope.bloquear_cueban.CodCli=datos.CodCli;
		scope.bloquear_cueban.CodCueBan=datos.CodCueBan;
		scope.bloquear_cueban.EstCue=opcion;
		//console.log(scope.bloquear_cueban);
		scope.opciones_Ban[index]=undefined;
		if(opcion==1)
		{
			if(datos.EstCue==1)
			{
				scope.opciones_Ban[index]=undefined;
				Swal.fire({title:"Esta Cuenta Bancaria Ya Se Encuentra Activa.",type:"error",confirmButtonColor:"#188ae2"});
				return false;
			}
			scope.update_status_CueBan(scope.bloquear_cueban);
		}
		if(opcion==2)
		{
			if(datos.EstCue==2)
			{
				scope.opciones_Ban[index]=undefined;
				Swal.fire({title:"Esta Cuenta Bancaria Ya Se Encuentra Bloqueada.",type:"error",confirmButtonColor:"#188ae2"});
				return false;
			}
			scope.update_status_CueBan(scope.bloquear_cueban);
		}
		if(opcion==3)
		{
			scope.agregar_cuentas=true;
			scope.tgribBancos.CodBan=datos.CodBan;
			scope.tgribBancos.CodCueBan=datos.CodCueBan;
			scope.CodEur=datos.CodEur;
			scope.IBAN1=datos.IBAN1;
			scope.IBAN2=datos.IBAN2;
			scope.IBAN3=datos.IBAN3;
			scope.IBAN4=datos.IBAN4;
			scope.IBAN5=datos.IBAN5;

		}

	}
	scope.update_status_CueBan=function(total_datos)
	{
		console.log(total_datos);
		var url=base_urlHome()+"api/Clientes/update_status_CueBan/";
		$http.post(url,total_datos).then(function(result)
		{
			if(result.data!=false)
			{
				if(total_datos.EstCue==1)
				{
					Swal.fire({title:"Cuenta Bancaria Activada Correctamente.",type:"success",confirmButtonColor:"#188ae2"});
				}
				if(total_datos.EstCue==2)
				{
					Swal.fire({title:"Cuenta Bancaria Bloqueada Correctamente.",type:"success",confirmButtonColor:"#188ae2"});
				}
				scope.cargar_cuentas_bancarias();
			}
			else
			{
				Swal.fire({title:"Error.",text:"Error al intentar actualizar estatus de cuenta.",type:"error",confirmButtonColor:"#188ae2"});	
				scope.cargar_cuentas_bancarias();
			}

		},function(error)
		{
			if(error.status==404 && error.statusText=="Not Found")
			{
				Swal.fire({title:"Error.",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				Swal.fire({title:"Error en Permisos.",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"info",confirmButtonColor:"#188ae2"});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				Swal.fire({title:"Seguridad.",text:"Está intentando usar un APIKEY inválido.",type:"question",confirmButtonColor:"#188ae2"});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{				
				Swal.fire({title:"Error.",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
			}
		});
	}

	scope.cargar_cuentas_bancarias=function()
	{
		var url=base_urlHome()+"api/Clientes/get_cuentas_bancarias_cliente/CodCli/"+scope.nID;
		$http.get(url).then(function(result)
		{
			if(result.data!=false)
			{
				
				$scope.predicate3 = 'id';  
				$scope.reverse3 = true;						
				$scope.currentPage3 = 1;  
				$scope.order3 = function (predicate3) 
				{  
					$scope.reverse3 = ($scope.predicate3 === predicate3) ? !$scope.reverse3 : false;  
					$scope.predicate3 = predicate3;  
				}; 						
				scope.tCuentaBan=result.data;
				scope.tCuentaBanBack=result.data;								
				$scope.totalItems3 = scope.tCuentaBan.length; 
				$scope.numPerPage3 = 50;  
				$scope.paginate3 = function (value3) 
				{  
					var begin3, end3, index3;  
					begin3 = ($scope.currentPage3 - 1) * $scope.numPerPage3;  
					end3 = begin3 + $scope.numPerPage3;  
					index3 = scope.tCuentaBan.indexOf(value3);  
					return (begin3 <= index3 && index3 < end3);  
				};
			}
			else
			{
				Swal.fire({title:"No se Encontraron Cuentas Bancarias Afiliadas.",type:"error",confirmButtonColor:"#188ae2"});		
			}

		},function(error)
		{	
			if(error.status==404 && error.statusText=="Not Found")
			{
				Swal.fire({title:"Error.",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				Swal.fire({title:"Error en Permisos.",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"info",confirmButtonColor:"#188ae2"});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				Swal.fire({title:"Seguridad.",text:"Está intentando usar un APIKEY inválido.",type:"question",confirmButtonColor:"#188ae2"});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{				
				Swal.fire({title:"Error.",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
			}
		});
	}




	//////////////////////////////////CUENTAS BANCARIAS END ///////////////////////////////////////////

	scope.cargar_lista_motivos_bloqueos_puntos_suministros=function()
	{
		var url=base_urlHome()+"api/Clientes/Motivos_Bloqueos_PunSum/";
		$http.get(url).then(function(result)
		{
			if(result.data!=false)
			{
				scope.tMotivosBloqueosPunSum=result.data;
			}
			else
			{
				bootbox.alert({
				message: "No hemos encontrados Motivos de Bloqueos para el Punto de Suministro.",
				size: 'middle'});
			}

		},function(error)
		{
			if(error.status==404 && error.statusText=="Not Found")
			{
				Swal.fire({title:"Error.",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				Swal.fire({title:"Error en Permisos.",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"info",confirmButtonColor:"#188ae2"});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				Swal.fire({title:"Seguridad.",text:"Está intentando usar un APIKEY inválido.",type:"question",confirmButtonColor:"#188ae2"});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{				
				Swal.fire({title:"Error.",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
			}
		});
	}


	
	scope.cargar_lista_motivos_bloqueos=function()
	{
		var url=base_urlHome()+"api/Clientes/Motivos_Bloqueos/";
		$http.get(url).then(function(result)
		{
			if(result.data!=false)
			{
				scope.tMotivosBloqueos=result.data;
			}
			else
			{
				bootbox.alert({
				message: "No hemos encontrados Motivos de Bloqueos Registrados.",
				size: 'middle'});
			}

		},function(error)
		{
			if(error.status==404 && error.statusText=="Not Found")
			{
				Swal.fire({title:"Error.",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				Swal.fire({title:"Error en Permisos.",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"info",confirmButtonColor:"#188ae2"});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				Swal.fire({title:"Seguridad.",text:"Está intentando usar un APIKEY inválido.",type:"question",confirmButtonColor:"#188ae2"});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{				
				Swal.fire({title:"Error.",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
			}
		});
	}
	scope.cargar_lista_motivos_bloqueos_actividades=function()
	{
		var url=base_urlHome()+"api/Clientes/Motivos_Bloqueos_Actividades/";
		$http.get(url).then(function(result)
		{
			if(result.data!=false)
			{
				scope.tMotivosBloqueosActividades=result.data;
			}
			else
			{
				bootbox.alert({
				message: "No hemos encontrados Motivos de Bloqueos Registrados.",
				size: 'middle'});
			}

		},function(error)
		{
			if(error.status==404 && error.statusText=="Not Found")
			{
				Swal.fire({title:"Error.",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				Swal.fire({title:"Error en Permisos.",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"info",confirmButtonColor:"#188ae2"});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				Swal.fire({title:"Seguridad.",text:"Está intentando usar un APIKEY inválido.",type:"question",confirmButtonColor:"#188ae2"});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{				
				Swal.fire({title:"Error.",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
			}
		});
	}
	scope.misma_razon=function(opcion)
	{
		if(opcion==true)
		{
			scope.fdatos.NomComCli=undefined;
		}
		else
		{
			scope.fdatos.NomComCli=scope.fdatos.RazSocCli;
		}
		
	}
	scope.asignar_a_nombre_comercial=function()
	{
		scope.fdatos.NomComCli=scope.fdatos.RazSocCli;
	}
	scope.modal_cif_cliente=function()
	{		
		$("#modal_cif_cliente").modal('show');		
	}
	$scope.Consultar_CIF = function(event) 
	{      
	 	if(scope.fdatos.NumCifCli==undefined || scope.fdatos.NumCifCli==null || scope.fdatos.NumCifCli=='')
		{
			Swal.fire({title:"Error.",text:"El número de CIF no puede estar vacio.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		else
		{
	        $("#NumCifCli").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
	        var url=base_urlHome()+"api/Clientes/comprobar_cif/";
			$http.post(url,scope.fdatos).then(function(result)
			{
				if(result.data!=false)
				{
					$("#NumCifCli").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					Swal.fire({title:"Cliente Registrado.",text:"El Número de CIF del Cliente ya se encuentra registrado.",type:"info",confirmButtonColor:"#188ae2"});					
				}
				else
				{
					$("#NumCifCli").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					$("#modal_cif_cliente").modal('hide');
					$cookies.put('CIF', scope.fdatos.NumCifCli);
					location.href ="#/Creacion_Clientes/";
				}
			},function(error)
			{
				if(error.status==404 && error.statusText=="Not Found")
				{
					$("#NumCifCli").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					Swal.fire({title:"Error.",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
				}
				if(error.status==401 && error.statusText=="Unauthorized")
				{
					$("#NumCifCli").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					Swal.fire({title:"Error en Permisos.",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"info",confirmButtonColor:"#188ae2"});
				}
				if(error.status==403 && error.statusText=="Forbidden")
				{
					$("#NumCifCli").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					Swal.fire({title:"Seguridad.",text:"Está intentando usar un APIKEY inválido.",type:"question",confirmButtonColor:"#188ae2"});
					
				}
				if(error.status==500 && error.statusText=="Internal Server Error")
				{
					$("#NumCifCli").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
					Swal.fire({title:"Error.",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
				}
			});	

		}						
	}; 
	scope.regresar=function()
	{
		if(scope.fdatos.CodCli==undefined)
		{
			
			Swal.fire({title:"Esta seguro de no completar el registro del cliente?",			
			type:"question",
			showCancelButton:!0,
			confirmButtonColor:"#31ce77",
			cancelButtonColor:"#f34943",
			confirmButtonText:"OK"}).then(function(t)
			{
	          if(t.value==true)
	          {
	              	$cookies.remove('CIF');
	              	location.href="#/Clientes/";
	          }
	          else
	          {
	               console.log('Cancelando ando...');	                
	          }
	       });	
		}
		else
		{
			location.href="#/Clientes/";	
		}
	}
	scope.mostrar_all_actividades=function()
	{
		
		var url = base_urlHome()+"api/Clientes/all_actividades/CodCli/"+scope.nID;
		$http.get(url).then(function(result)
		{
			if(result.data!=false)
			{
				$scope.predicate1 = 'id';  
				$scope.reverse1 = true;						
				$scope.currentPage1 = 1;  
				$scope.order1 = function (predicate1) 
				{  
					$scope.reverse1 = ($scope.predicate1 === predicate1) ? !$scope.reverse1 : false;  
					$scope.predicate1 = predicate1;  
				};	
				scope.TActividades= result.data;							
				$scope.totalItems1 = scope.TActividades.length; 
				$scope.numPerPage1 = 50;  
				$scope.paginate1 = function (value1) 
				{  
					var begin1, end1, index1;  
					begin1 = ($scope.currentPage1 - 1) * $scope.numPerPage1;  
					end1 = begin1 + $scope.numPerPage1;  
					index1 = scope.TActividades.indexOf(value1);  
					return (begin1 <= index1 && index1 < end1);  
				};
			}
			else
			{
				Swal.fire({title:"Error.",text:"No hemos encontrado actividades asignadas a este cliente.",type:"error",confirmButtonColor:"#188ae2"});
			}

		},function(error)
		{	
			if(error.status==404 && error.statusText=="Not Found")
			{
				Swal.fire({title:"Error.",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
			}
			if(error.status==401 && error.statusText=="Unauthorized")
			{
				Swal.fire({title:"Error en Permisos.",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"info",confirmButtonColor:"#188ae2"});
			}
			if(error.status==403 && error.statusText=="Forbidden")
			{
				Swal.fire({title:"Seguridad.",text:"Está intentando usar un APIKEY inválido.",type:"question",confirmButtonColor:"#188ae2"});
			}
			if(error.status==500 && error.statusText=="Internal Server Error")
			{			
				Swal.fire({title:"Error.",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
			}
		});		
	}
	$scope.SubmitFormFiltrosAct = function(event) 
	{      
	 	console.log(scope.tmodal_data.tipo_filtro_actividad);
	 	console.log(scope.tmodal_data.FecIniActFil);	 	
	 	if(scope.tmodal_data.tipo_filtro_actividad==1)
	 	{
	 		if(scope.tmodal_data.FecIniActFil==undefined || scope.tmodal_data.FecIniActFil==null || scope.tmodal_data.FecIniActFil=='')
	 		{
	 			Swal.fire({title:"Debe Ingresar la Fecha para Poder Aplicar el Filtro.",type:"error",confirmButtonColor:"#188ae2"});
	 			return false;
	 		}
	 		$scope.predicate1 = 'id';  
			$scope.reverse1 = true;						
			$scope.currentPage1 = 1;  
			$scope.order1 = function (predicate1) 
			{  
				$scope.reverse1 = ($scope.predicate1 === predicate1) ? !$scope.reverse1 : false;  
				$scope.predicate1 = predicate1;  
			};	
			scope.TActividades= $filter('filter')(scope.TActividadesBack, {FecIniAct: scope.tmodal_data.FecIniActFil}, true);							
			$scope.totalItems1 = scope.TActividades.length; 
			$scope.numPerPage1 = 50;  
			$scope.paginate1 = function (value1) 
			{  
				var begin1, end1, index1;  
				begin1 = ($scope.currentPage1 - 1) * $scope.numPerPage1;  
				end1 = begin1 + $scope.numPerPage1;  
				index1 = scope.TActividades.indexOf(value1);  
				return (begin1 <= index1 && index1 < end1);  
			};
			//scope.tmodal_data.FecIniActFil=undefined;
			if(scope.TActividades.length==0)
			{
				scope.TActividades=undefined;	
			}
			console.log(scope.TActividades.length);
			console.log(scope.TActividades);

	 	}
	 	if(scope.tmodal_data.tipo_filtro_actividad==2)
	 	{
	 		if(!scope.tmodal_data.EstActFil>0)
	 		{
	 			Swal.fire({title:"Debe Seleccionar un Estatus para Poder Aplicar el Filtro.",type:"error",confirmButtonColor:"#188ae2"});
	 			return false;
	 		}
	 		$scope.predicate1 = 'id';  
			$scope.reverse1 = true;						
			$scope.currentPage1 = 1;  
			$scope.order1 = function (predicate1) 
			{  
				$scope.reverse1 = ($scope.predicate1 === predicate1) ? !$scope.reverse1 : false;  
				$scope.predicate1 = predicate1;  
			};	
			scope.TActividades= $filter('filter')(scope.TActividadesBack, {EstAct: scope.tmodal_data.EstActFil}, true);							
			$scope.totalItems1 = scope.TActividades.length; 
			$scope.numPerPage1 = 50;  
			$scope.paginate1 = function (value1) 
			{  
				var begin1, end1, index1;  
				begin1 = ($scope.currentPage1 - 1) * $scope.numPerPage1;  
				end1 = begin1 + $scope.numPerPage1;  
				index1 = scope.TActividades.indexOf(value1);  
				return (begin1 <= index1 && index1 < end1);  
			};
			if(scope.TActividades.length==0)
			{
				scope.TActividades=undefined;	
			}
			console.log(scope.TActividades.length);
			console.log(scope.TActividades);
	 	}					
	};
	$scope.SubmitFormFiltrosClientes = function(event) 
	{
	 	//console.log(event);
	 	//console.log(scope.tmodal_data);
	 	if(scope.tmodal_data.tipo_filtro==1)
	 	{
	 		$scope.predicate = 'id';  
			$scope.reverse = true;						
			$scope.currentPage = 1;  
			$scope.order = function (predicate) 
			{  
				$scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;  
				$scope.predicate = predicate;  
			}; 						
			scope.Tclientes = $filter('filter')(scope.TclientesBack, {CodTipCli: scope.tmodal_data.CodTipCliFil}, true);
			$scope.totalItems = scope.Tclientes.length; 
			$scope.numPerPage = 50;  
			$scope.paginate = function (value) 
			{  
				var begin, end, index;  
				begin = ($scope.currentPage - 1) * $scope.numPerPage;  
				end = begin + $scope.numPerPage;  
				index = scope.Tclientes.indexOf(value);  
				return (begin <= index && index < end);  
			};	
	 	}

	 	if(scope.tmodal_data.tipo_filtro==2)
	 	{
	 		$scope.predicate = 'id';  
			$scope.reverse = true;						
			$scope.currentPage = 1;  
			$scope.order = function (predicate) 
			{  
				$scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;  
				$scope.predicate = predicate;  
			}; 						
			scope.Tclientes = $filter('filter')(scope.TclientesBack, {CodSecCli: scope.tmodal_data.CodSecCliFil}, true);
			$scope.totalItems = scope.Tclientes.length; 
			$scope.numPerPage = 50;  
			$scope.paginate = function (value) 
			{  
				var begin, end, index;  
				begin = ($scope.currentPage - 1) * $scope.numPerPage;  
				end = begin + $scope.numPerPage;  
				index = scope.Tclientes.indexOf(value);  
				return (begin <= index && index < end);  
			};	
	 	}

	 	if(scope.tmodal_data.tipo_filtro==3)
	 	{
	 		$scope.predicate = 'id';  
			$scope.reverse = true;						
			$scope.currentPage = 1;  
			$scope.order = function (predicate) 
			{  
				$scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;  
				$scope.predicate = predicate;  
			}; 						
			scope.Tclientes = $filter('filter')(scope.TclientesBack, {CodProFis: scope.tmodal_data.CodPro}, true);		
			$scope.totalItems = scope.Tclientes.length; 
			$scope.numPerPage = 50;  
			$scope.paginate = function (value) 
			{  
				var begin, end, index;  
				begin = ($scope.currentPage - 1) * $scope.numPerPage;  
				end = begin + $scope.numPerPage;  
				index = scope.Tclientes.indexOf(value);  
				return (begin <= index && index < end);  
			};
	 	}
	 	
	 	if(scope.tmodal_data.tipo_filtro==4)
	 	{
	 		$scope.predicate = 'id';  
			$scope.reverse = true;						
			$scope.currentPage = 1;  
			$scope.order = function (predicate) 
			{  
				$scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;  
				$scope.predicate = predicate;  
			}; 						
			scope.Tclientes = $filter('filter')(scope.TclientesBack, {CodProFis: scope.tmodal_data.CodPro,CodLocFis: scope.tmodal_data.CodLocFil}, true);					
			$scope.totalItems = scope.Tclientes.length; 
			$scope.numPerPage = 50;  
			$scope.paginate = function (value) 
			{  
				var begin, end, index;  
				begin = ($scope.currentPage - 1) * $scope.numPerPage;  
				end = begin + $scope.numPerPage;  
				index = scope.Tclientes.indexOf(value);  
				return (begin <= index && index < end);  
			};
	 	}	
	 	if(scope.tmodal_data.tipo_filtro==5)
	 	{
	 		$scope.predicate = 'id';  
			$scope.reverse = true;						
			$scope.currentPage = 1;  
			$scope.order = function (predicate) 
			{  
				$scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;  
				$scope.predicate = predicate;  
			}; 						
			scope.Tclientes = $filter('filter')(scope.TclientesBack, {CodCom: scope.tmodal_data.CodCom}, true);					
			$scope.totalItems = scope.Tclientes.length; 
			$scope.numPerPage = 50;  
			$scope.paginate = function (value) 
			{  
				var begin, end, index;  
				begin = ($scope.currentPage - 1) * $scope.numPerPage;  
				end = begin + $scope.numPerPage;  
				index = scope.Tclientes.indexOf(value);  
				return (begin <= index && index < end);  
			};
	 	}
	 	if(scope.tmodal_data.tipo_filtro==6)
	 	{
	 		$scope.predicate = 'id';  
			$scope.reverse = true;						
			$scope.currentPage = 1;  
			$scope.order = function (predicate) 
			{  
				$scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;  
				$scope.predicate = predicate;  
			}; 						
			scope.Tclientes = $filter('filter')(scope.TclientesBack, {CodCol: scope.tmodal_data.CodCol}, true);					
			$scope.totalItems = scope.Tclientes.length; 
			$scope.numPerPage = 50;  
			$scope.paginate = function (value) 
			{  
				var begin, end, index;  
				begin = ($scope.currentPage - 1) * $scope.numPerPage;  
				end = begin + $scope.numPerPage;  
				index = scope.Tclientes.indexOf(value);  
				return (begin <= index && index < end);  
			};
	 	}
	 	

	 	if(scope.tmodal_data.tipo_filtro==7)
	 	{
	 		$scope.predicate = 'id';  
			$scope.reverse = true;						
			$scope.currentPage = 1;  
			$scope.order = function (predicate) 
			{  
				$scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;  
				$scope.predicate = predicate;  
			}; 						
			scope.Tclientes = $filter('filter')(scope.TclientesBack, {EstCli:scope.tmodal_data.EstCliFil}, true);				
			$scope.totalItems = scope.Tclientes.length; 
			$scope.numPerPage = 50;  
			$scope.paginate = function (value) 
			{  
				var begin, end, index;  
				begin = ($scope.currentPage - 1) * $scope.numPerPage;  
				end = begin + $scope.numPerPage;  
				index = scope.Tclientes.indexOf(value);  
				return (begin <= index && index < end);  
			};
	 	}					
	};
	$scope.SubmitFormFiltrosPumSum = function(event) 
	{      
	 	console.log(scope.fpuntosuministro);
	 	 	
	 	if(scope.fpuntosuministro.tipo_filtro==1)
	 	{
	 		if(!scope.fpuntosuministro.CodPro>0)
	 		{
	 			Swal.fire({title:"Seleccionar Una Provincia Para Aplicar el Filtro.",type:"error",confirmButtonColor:"#188ae2"});
	 			return false;
	 		}
	 		$scope.predicate2 = 'id';  
			$scope.reverse2 = true;						
			$scope.currentPage2 = 1;  
			$scope.order2 = function (predicate2) 
			{  
				$scope.reverse2 = ($scope.predicate2 === predicate2) ? !$scope.reverse : false;  
				$scope.predicate2 = predicate2;  
			};	
			scope.tPuntosSuminitros= $filter('filter')(scope.tPuntosSuminitrosBack, {DesPro: scope.fpuntosuministro.CodPro}, true);							
			$scope.totalItems2 = scope.tPuntosSuminitros.length; 
			$scope.numPerPage2 = 50;  
			$scope.paginate2 = function (value2) 
			{  
				var begin2, end2, index2;  
				begin2 = ($scope.currentPage2 - 1) * $scope.numPerPage2;  
				end2 = begin2 + $scope.numPerPage2;  
				index2 = scope.tPuntosSuminitros.indexOf(value2);  
				return (begin2 <= index2 && index2 < end2);  
			};
			//scope.tmodal_data.FecIniActFil=undefined;
			if(scope.tPuntosSuminitros.length==0)
			{
				
				scope.tPuntosSuminitros=[];	
			}
			//console.log(scope.tPuntosSuminitros.length);
			console.log(scope.tPuntosSuminitros);

	 	}
	 	if(scope.fpuntosuministro.tipo_filtro==2)
	 	{
	 		if(!scope.fpuntosuministro.CodPro>0)
	 		{
	 			Swal.fire({title:"Debe Seleccionar una Provincia.",type:"error",confirmButtonColor:"#188ae2"});
	 			return false;
	 		}
	 		if(!scope.fpuntosuministro.CodLocFil>0)
	 		{
	 			Swal.fire({title:"Debe Seleccionar una Localidad.",type:"error",confirmButtonColor:"#188ae2"});
	 			return false;
	 		}
	 		$scope.predicate2 = 'id';  
			$scope.reverse2 = true;						
			$scope.currentPage2 = 1;  
			$scope.order2 = function (predicate2) 
			{  
				$scope.reverse2 = ($scope.predicate2 === predicate2) ? !$scope.reverse : false;  
				$scope.predicate2 = predicate2;  
			};	
			scope.tPuntosSuminitros= $filter('filter')(scope.tPuntosSuminitrosBack, {DesPro: scope.fpuntosuministro.CodPro,DesLoc: scope.fpuntosuministro.CodLocFil}, true);							
			$scope.totalItems2 = scope.tPuntosSuminitros.length; 
			$scope.numPerPage2 = 50;  
			$scope.paginate2 = function (value2) 
			{  
				var begin2, end2, index2;  
				begin2 = ($scope.currentPage2 - 1) * $scope.numPerPage2;  
				end2 = begin2 + $scope.numPerPage2;  
				index2 = scope.tPuntosSuminitros.indexOf(value2);  
				return (begin2 <= index2 && index2 < end2);  
			};
			//scope.tmodal_data.FecIniActFil=undefined;
			if(scope.tPuntosSuminitros.length==0)
			{
				
				scope.tPuntosSuminitros=[];	
			}
			//console.log(scope.tPuntosSuminitros.length);
			console.log(scope.tPuntosSuminitros);
	 	}
	 	if(scope.fpuntosuministro.tipo_filtro==3)
	 	{
	 		if(!scope.fpuntosuministro.CodTipInm>0)
	 		{
	 			Swal.fire({title:"Debe Seleccionar una Tipo de Inmueble.",type:"error",confirmButtonColor:"#188ae2"});
	 			return false;
	 		}	 		
	 		$scope.predicate2 = 'id';  
			$scope.reverse2 = true;						
			$scope.currentPage2 = 1;  
			$scope.order2 = function (predicate2) 
			{  
				$scope.reverse2 = ($scope.predicate2 === predicate2) ? !$scope.reverse : false;  
				$scope.predicate2 = predicate2;  
			};	
			scope.tPuntosSuminitros= $filter('filter')(scope.tPuntosSuminitrosBack, {DesTipInm: scope.fpuntosuministro.CodTipInm}, true);							
			$scope.totalItems2 = scope.tPuntosSuminitros.length; 
			$scope.numPerPage2 = 50;  
			$scope.paginate2 = function (value2) 
			{  
				var begin2, end2, index2;  
				begin2 = ($scope.currentPage2 - 1) * $scope.numPerPage2;  
				end2 = begin2 + $scope.numPerPage2;  
				index2 = scope.tPuntosSuminitros.indexOf(value2);  
				return (begin2 <= index2 && index2 < end2);  
			};
			//scope.tmodal_data.FecIniActFil=undefined;
			if(scope.tPuntosSuminitros.length==0)
			{
				
				scope.tPuntosSuminitros=[];	
			}
			//console.log(scope.tPuntosSuminitros.length);
			console.log(scope.tPuntosSuminitros);
	 	}
	 	if(scope.fpuntosuministro.tipo_filtro==4)
	 	{
	 		if(!scope.fpuntosuministro.EstPunSum>0)
	 		{
	 			Swal.fire({title:"Debe Seleccionar un Estatus.",type:"error",confirmButtonColor:"#188ae2"});
	 			return false;
	 		}	 		
	 		$scope.predicate2 = 'id';  
			$scope.reverse2 = true;						
			$scope.currentPage2 = 1;  
			$scope.order2 = function (predicate2) 
			{  
				$scope.reverse2 = ($scope.predicate2 === predicate2) ? !$scope.reverse : false;  
				$scope.predicate2 = predicate2;  
			};	
			scope.tPuntosSuminitros= $filter('filter')(scope.tPuntosSuminitrosBack, {EstPunSum: scope.fpuntosuministro.EstPunSum}, true);							
			$scope.totalItems2 = scope.tPuntosSuminitros.length; 
			$scope.numPerPage2 = 50;  
			$scope.paginate2 = function (value2) 
			{  
				var begin2, end2, index2;  
				begin2 = ($scope.currentPage2 - 1) * $scope.numPerPage2;  
				end2 = begin2 + $scope.numPerPage2;  
				index2 = scope.tPuntosSuminitros.indexOf(value2);  
				return (begin2 <= index2 && index2 < end2);  
			};
			//scope.tmodal_data.FecIniActFil=undefined;
			if(scope.tPuntosSuminitros.length==0)
			{
				
				scope.tPuntosSuminitros=[];	
			}
			//console.log(scope.tPuntosSuminitros.length);
			console.log(scope.tPuntosSuminitros);
	 	}					
	};
	scope.regresar_filtroPumSum=function()
	{
		scope.fpuntosuministro={};
		scope.tPuntosSuminitros=scope.tPuntosSuminitrosBack;
		scope.fpuntosuministro.tipo_filtro=undefined;
		scope.fpuntosuministro.CodPro=undefined;
		scope.fpuntosuministro.CodLocFil=undefined;
		scope.fpuntosuministro.CodTipInm=undefined;
		scope.fpuntosuministro.EstPunSum=undefined;
		$("#modal_filtro_puntos_suministros").modal('hide');
	}
	scope.regresar_filtro=function()
	{
		scope.tmodal_data={};
		scope.Tclientes=scope.TclientesBack;
		scope.tmodal_data.tipo_filtro=undefined;
		scope.tmodal_data.CodPro=undefined;
		scope.tmodal_data.CodLocFil=undefined;
		scope.tmodal_data.CodTipCliFil=undefined;
		scope.tmodal_data.EstCliFil=undefined;
		$("#modal_filtros").modal('hide');
	}	
	scope.filtrotipocliente =  function()
	{		
		$scope.predicate = 'id';  
		$scope.reverse = true;						
		$scope.currentPage = 1;  
		$scope.order = function (predicate) 
		{  
			$scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;  
			$scope.predicate = predicate;  
		}; 						
		scope.Tclientes = $filter('filter')(scope.TclientesBack, {EstCli:scope.fdatos.EstCliFil,CodPro: scope.fdatos.CodPro,CodTipCli: scope.fdatos.CodTipCliFil,CodLoc: scope.fdatos.CodLocFil}, true);
		$scope.totalItems = scope.Tclientes.length; 
		$scope.numPerPage = 50;  
		$scope.paginate = function (value) 
		{  
			var begin, end, index;  
			begin = ($scope.currentPage - 1) * $scope.numPerPage;  
			end = begin + $scope.numPerPage;  
			index = scope.Tclientes.indexOf(value);  
			return (begin <= index && index < end);  
		};	
	}
	scope.filtrar_loca =  function()
	{		
		scope.TLocalidadesfiltrada = $filter('filter')(scope.tLocalidades, {DesPro:scope.tmodal_data.CodPro}, true);		
	}
	scope.filtrar_locaPumSum =  function()
	{		
		scope.TLocalidadesfiltradaPumSum = $filter('filter')(scope.tLocalidades, {DesPro:scope.fpuntosuministro.CodPro}, true);		
	}
	
	
	scope.filtrar_tabla=function(expresion)
	{///console.log(expresion);
		if (expresion.length>0)
		{
			scope.Tclientes = $filter('filter')(scope.TclientesBack, {NumCifCli: expresion});
		}		
	}
	scope.filtrar_actividad=function(metodo,expression)
	{
		//console.log(metodo);
		//console.log(expression);
		//console.log(scope.TActividades);
		if(metodo==1)
		{
			scope.pruebas = $filter('filter')(scope.tActividadesEconomicasBack, {DesSec: expression});	
			angular.forEach(scope.pruebas, function(data)
			{					
				scope.fdatos.CodGrup=data.DesGru;
				scope.fdatos.CodEpi=data.DesEpi;
				scope.fdatos.CodActEco=data.CodActEco;						
			});
			

			if(scope.TActividades!=undefined)
			{
				angular.forEach(scope.TActividades, function(data)
				{
					if(data.CodActEco==scope.fdatos.CodActEco)
					{
						scope.Activity_Found=true;
						scope.Habilita_Fecha=false;
					}
					else
					{
						scope.Activity_Found=false;
						scope.Habilita_Fecha=true;
					}
				});
				if(scope.Activity_Found==true)
				{
					Swal.fire({title:"Error.",text:"Ya este cliente tiene esta actividad asignada.",type:"error",confirmButtonColor:"#188ae2"});
					scope.fdatos.CodEpi=undefined;
					scope.fdatos.CodSec=undefined;
					scope.fdatos.CodGrup=undefined;
					scope.fdatos.CodActEco=undefined;
					scope.Activity_Found=true;
					return false;
				}	
			}
			else
			{
				scope.Habilita_Fecha=true;
			}
			
		}
		if(metodo==2)
		{
			scope.pruebas = $filter('filter')(scope.tActividadesEconomicasBack, {DesGru: expression});	
			angular.forEach(scope.pruebas, function(data)
			{					
				scope.fdatos.CodSec=data.DesSec;
				scope.fdatos.CodEpi=data.DesEpi;
				scope.fdatos.CodActEco=data.CodActEco;						
			});
			
			if(scope.TActividades!=undefined)
			{
				angular.forEach(scope.TActividades, function(data)
				{
					if(data.CodActEco==scope.fdatos.CodActEco)
					{
						scope.Activity_Found=true;
						scope.Habilita_Fecha=false;
					}
					else
					{
						scope.Activity_Found=false;
						scope.Habilita_Fecha=true;
					}
				});
				if(scope.Activity_Found==true)
				{
					Swal.fire({title:"Error.",text:"Ya este cliente tiene esta actividad asignada.",type:"error",confirmButtonColor:"#188ae2"});
					scope.fdatos.CodEpi=undefined;
					scope.fdatos.CodSec=undefined;
					scope.fdatos.CodGrup=undefined;
					scope.fdatos.CodActEco=undefined;
					scope.Activity_Found=true;
					return false;
				}	
			}
			else
			{
				scope.Habilita_Fecha=true;
			}
		}
		if(metodo==3)
		{
			scope.pruebas = $filter('filter')(scope.tActividadesEconomicasBack, {DesEpi: expression});	
			angular.forEach(scope.pruebas, function(data)
			{					
				scope.fdatos.CodSec=data.DesSec;
				scope.fdatos.CodGrup=data.DesGru;
				scope.fdatos.CodActEco=data.CodActEco;						
			});
			
			if(scope.TActividades!=undefined)
			{
				angular.forEach(scope.TActividades, function(data)
				{
					if(data.CodActEco==scope.fdatos.CodActEco)
					{
						scope.Activity_Found=true;
						scope.Habilita_Fecha=false;
					}
					else
					{
						scope.Activity_Found=false;
						scope.Habilita_Fecha=true;
					}
				});
				if(scope.Activity_Found==true)
				{
					Swal.fire({title:"Error.",text:"Ya este cliente tiene esta actividad asignada.",type:"error",confirmButtonColor:"#188ae2"});
					scope.fdatos.CodEpi=undefined;
					scope.fdatos.CodSec=undefined;
					scope.fdatos.CodGrup=undefined;
					scope.fdatos.CodActEco=undefined;
					scope.Activity_Found=true;
					return false;
				}	
			}
			else
			{
				scope.Habilita_Fecha=true;
			}
		}
	}
	$scope.SubmitAsignarActivadades = function(event) 
	{ 
		//console.log(scope.fdatos);
	 	Swal.fire({title:"Esta seguro de asignar estar actividad al cliente?",			
		type:"question",
		showCancelButton:!0,
		confirmButtonColor:"#31ce77",
		cancelButtonColor:"#f34943",
		confirmButtonText:"OK"}).then(function(t)
		{
	        if(t.value==true)
	        {
	          	$("#asignando_actividad").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
			    var url=base_urlHome()+"api/Clientes/asignar_actividad/";
				$http.post(url,scope.fdatos).then(function(result)
				{
					if(result.data!=false)
					{
						//scope.buscarXID();
						$("#asignando_actividad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						Swal.fire({title:"Exito.",text:"La activadidad a sido asignado correctamente.",type:"success",confirmButtonColor:"#188ae2"});
						$("#modal_asignar_actividades").modal('hide');
						scope.fdatos.CodSec=undefined;
						scope.fdatos.CodGrup=undefined;
						scope.fdatos.CodEpi=undefined;
						scope.mostrar_all_actividades();
					}
					else
					{
						$("#asignando_actividad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						Swal.fire({title:"Error.",text:"Hubo un error al intentar asignar esta actividad por favor intente nuevamente.",type:"success",confirmButtonColor:"#188ae2"});
					}
				},function(error)
				{
					if(error.status==404 && error.statusText=="Not Found")
					{
						$("#asignando_actividad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						Swal.fire({title:"Error.",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
					}
					if(error.status==401 && error.statusText=="Unauthorized")
					{
						$("#asignando_actividad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						Swal.fire({title:"Error en Permisos.",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"info",confirmButtonColor:"#188ae2"});
					}
					if(error.status==403 && error.statusText=="Forbidden")
					{
						$("#asignando_actividad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						Swal.fire({title:"Seguridad.",text:"Está intentando usar un APIKEY inválido.",type:"question",confirmButtonColor:"#188ae2"});
					}
					if(error.status==500 && error.statusText=="Internal Server Error")
					{
						$("#asignando_actividad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
						Swal.fire({title:"Error.",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
					}
				});	
	          }
	          else
	          {
	               console.log('Cancelando ando...');	                
	          }
	       });	
	 	/**/								
	}; 	

	scope.validar_actividad=function(index,opcion,datos)
	{	
		//console.log(index);
		//console.log(opcion);
		//console.log(datos);
		scope.update_status_activity={};
		scope.update_status_activity.opcion=opcion;
		scope.update_status_activity.CodTActCli=datos.CodTActCli;
		scope.update_status_activity.CodCli=datos.CodCli;
		//console.log(scope.update_status_activity);
		if(opcion==1)
		{
			if(datos.EstAct=="Activa")
			{
				Swal.fire({title:"Error.",text:"Esta actividad ya se encuentra activa.",type:"error",confirmButtonColor:"#188ae2"});
				scope.opciones_actividades[index]=undefined;
				return false;
			}
			Swal.fire({title:"¿Esta Seguro de Activar Esta Actividad?",
			type:"info",
			showCancelButton:!0,
			confirmButtonColor:"#31ce77",
			cancelButtonColor:"#f34943",
			confirmButtonText:"Activar"}).then(function(t)
			{
	            if(t.value==true)
	            {
			        $("#estatus_actividad").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
					var url=base_urlHome()+"api/Clientes/update_status_activity/";
					$http.post(url,scope.update_status_activity).then(function(result)
					{
						if(result.data!=false)
						{					
							if(result.data.opcion==1)
							{
								scope.buscarXID();					
								$("#estatus_actividad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
								Swal.fire({title:"Exito.",text:"La activiadad a sido activada correctametne.",type:"success",confirmButtonColor:"#188ae2"});
								scope.opciones_actividades[index]=undefined;
							}
						}
						else
						{
							$("#estatus_actividad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
							Swal.fire({title:"Error.",text:"Hubo un error al intentar asignar esta actividad por favor intente nuevamente.",type:"success",confirmButtonColor:"#188ae2"});
						}
					},function(error)
					{
						if(error.status==404 && error.statusText=="Not Found")
						{
							$("#estatus_actividad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
							Swal.fire({title:"Error.",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
						}
						if(error.status==401 && error.statusText=="Unauthorized")
						{
							$("#estatus_actividad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
							Swal.fire({title:"Error en Permisos.",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"info",confirmButtonColor:"#188ae2"});
						}
						if(error.status==403 && error.statusText=="Forbidden")
						{
							$("#estatus_actividad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
							Swal.fire({title:"Seguridad.",text:"Está intentando usar un APIKEY inválido.",type:"question",confirmButtonColor:"#188ae2"});
						}
						if(error.status==500 && error.statusText=="Internal Server Error")
						{
							$("#estatus_actividad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
							Swal.fire({title:"Error.",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
						}
					});  
	            }
	            else
	            {
	                console.log('Cancelando ando...');
	                scope.opciones_actividades[index]=undefined;
	            }
	        });
		}
		if(opcion==2)
		{
			if(datos.EstAct=="Bloqueada")
			{
				Swal.fire({title:"Error.",text:"Esta actividad ya se encuentra bloqueada.",type:"error",confirmButtonColor:"#188ae2"});
				scope.opciones_actividades[index]=undefined;
				return false;
			}
				//console.log(datos);
				scope.tmodal_data={};
				scope.tmodal_data.CodCli=scope.fdatos.CodCli;
				scope.tmodal_data.CodTActCli=datos.CodTActCli;
				scope.tmodal_data.NumCif=scope.fdatos.NumCifCli;
				scope.tmodal_data.opcion=opcion;
				scope.tmodal_data.CodActEco=datos.CodActEco;
				scope.tmodal_data.index=index;
				if(scope.tmodal_data.ObsBloAct==undefined)
				{
					scope.tmodal_data.ObsBloAct=null;
				}
				else
				{
					scope.tmodal_data.ObsBloAct=scope.tmodal_data.ObsBloAct;
				}
				var url = base_urlHome()+"api/Clientes/Consulta_Fecha/";
				$http.get(url).then(function(result)
				{
					scope.tmodal_data.FecBloAct=result.data;

				},function(error)
				{

				});
				scope.tmodal_data.RazSoc=scope.fdatos.RazSocCli;
				scope.tmodal_data.DesSec=datos.DesSec;
				scope.tmodal_data.DesGru=datos.DesGru;	
				scope.tmodal_data.DesEpi=datos.DesEpi		
		        scope.opciones_actividades[index]=undefined;
		        scope.cargar_lista_motivos_bloqueos_actividades();	            	
		        $("#modal_motivo_bloqueo_actividades").modal('show'); 
		        //console.log(scope.tmodal_data);
			/**/

		}

	}
	scope.asignar_actividad=function()
	{
		$("#modal_asignar_actividades").modal('show');
		$("#cargando_actividades").removeClass( "loader loader-default" ).addClass("loader loader-default  is-active");
		scope.tSeccion=scope.tActividadesEconomicas;
		scope.tGrupos=scope.tActividadesEconomicas;
		scope.tEpigrafe=scope.tActividadesEconomicas;
		$("#cargando_actividades").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
		

	}
	$scope.submitFormlockActividades = function(event) 
	{      
	 	//console.log(scope.tmodal_data);
	 	Swal.fire({title:"¿Esta Seguro de Bloquear Esta Actividad?",
			type:"question",
			showCancelButton:!0,
			confirmButtonColor:"#31ce77",
			cancelButtonColor:"#f34943",
			confirmButtonText:"Bloquear"}).then(function(t)
			{
	            if(t.value==true)
	            {
	             	$("#estatus_actividad").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
					var url=base_urlHome()+"api/Clientes/update_status_activity/";
					$http.post(url,scope.tmodal_data).then(function(result)
					{
						if(result.data!=false)
						{					
							if(result.data.opcion==2)
							{
								scope.mostrar_all_actividades();					
								$("#estatus_actividad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
								Swal.fire({title:"Exito.",text:"La activiadad a sido bloqueada correctametne.",type:"success",confirmButtonColor:"#188ae2"});
								scope.opciones_actividades[scope.tmodal_data.index]=undefined;
								  $("#modal_motivo_bloqueo_actividades").modal('hide');
							}
						}
						else
						{
							$("#estatus_actividad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
							Swal.fire({title:"Error.",text:"Hubo un error al intentar asignar esta actividad por favor intente nuevamente.",type:"success",confirmButtonColor:"#188ae2"});
							scope.opciones_actividades[scope.tmodal_data.index]=undefined;
						}
					},function(error)
					{
						if(error.status==404 && error.statusText=="Not Found")
						{
							$("#estatus_actividad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
							Swal.fire({title:"Error.",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
						}
						if(error.status==401 && error.statusText=="Unauthorized")
						{
							$("#estatus_actividad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
							Swal.fire({title:"Error en Permisos.",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"info",confirmButtonColor:"#188ae2"});
						}
						if(error.status==403 && error.statusText=="Forbidden")
						{
							$("#estatus_actividad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
							Swal.fire({title:"Seguridad.",text:"Está intentando usar un APIKEY inválido.",type:"question",confirmButtonColor:"#188ae2"});
						}
						if(error.status==500 && error.statusText=="Internal Server Error")
						{
							$("#estatus_actividad").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
							Swal.fire({title:"Error.",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
						}
					});	
			    }
			    else
			    {
			       //  console.log('Cancelando ando...');
			        event.preventDefault();
			                
			    }
			});
	 	
					
	};
	scope.validarsinuermo=function(object)
	{
		if(object!=undefined)
		{
			numero=object;		
			if(!/^([+0-9])*$/.test(numero))
			scope.fdatos.TelFijCli=numero.substring(0,numero.length-1);
		}
	}
	scope.validarsifecha=function(object)
	{
		console.log(object);
		if(object!=undefined)
		{
			numero=object;		
			if(!/^([-0-9])*$/.test(numero))
			scope.tmodal_data.FecIniActFil=numero.substring(0,numero.length-1);
		}
	}
	scope.asignar_tipo_via=function()
	{
		if(scope.fdatos.distinto_a_social==false)
		{
			scope.fdatos.CodTipViaFis=scope.fdatos.CodTipViaSoc;	
		}		
	}
	scope.asignar_domicilio=function()
	{
		if(scope.fdatos.distinto_a_social==false)
		{
			scope.fdatos.NomViaDomFis=scope.fdatos.NomViaDomSoc;	
		}		
	}
	scope.asignar_num_domicilio=function()
	{
		if(scope.fdatos.distinto_a_social==false)
		{
			scope.fdatos.NumViaDomFis=scope.fdatos.NumViaDomSoc;	
		}		
	}
	scope.asignar_bloq_domicilio=function()
	{
		if(scope.fdatos.distinto_a_social==false)
		{
			scope.fdatos.BloDomFis=scope.fdatos.BloDomSoc;	
		}		
	}
	scope.asignar_esc_domicilio=function()
	{
		if(scope.fdatos.distinto_a_social==false)
		{
			scope.fdatos.EscDomFis=scope.fdatos.EscDomSoc;	
		}		
	}
	scope.asignar_pla_domicilio=function()
	{
		if(scope.fdatos.distinto_a_social==false)
		{
			scope.fdatos.PlaDomFis=scope.fdatos.PlaDomSoc;	
		}		
	}
	scope.asignar_puer_domicilio=function()
	{
		if(scope.fdatos.distinto_a_social==false)
		{
			scope.fdatos.PueDomFis=scope.fdatos.PueDomSoc;	
		}		
	}
	scope.distinto_a_social=function()
	{
		if(scope.fdatos.distinto_a_social==true)
		{
			scope.fdatos.CodTipViaFis=undefined;
			scope.fdatos.NomViaDomFis=undefined;
			scope.fdatos.NumViaDomFis=undefined;
			scope.fdatos.BloDomFis=undefined;
			scope.fdatos.EscDomFis=undefined;
			scope.fdatos.PlaDomFis=undefined;
			scope.fdatos.PueDomFis=undefined;
			scope.fdatos.CodProFis=undefined;
			scope.fdatos.CodLocFis=undefined;
			scope.fdatos.ZonPosFis=undefined;
		}
		else
		{
			scope.fdatos.CodTipViaFis=scope.fdatos.CodTipViaSoc;
			scope.fdatos.NomViaDomFis=scope.fdatos.NomViaDomSoc;
			scope.fdatos.NumViaDomFis=scope.fdatos.NumViaDomSoc;
			scope.fdatos.BloDomFis=scope.fdatos.BloDomSoc;
			scope.fdatos.EscDomFis=scope.fdatos.EscDomSoc;
			scope.fdatos.PlaDomFis=scope.fdatos.PlaDomSoc;
			scope.fdatos.PueDomFis=scope.fdatos.PueDomSoc;
			scope.fdatos.CodProFis=scope.fdatos.CodProSoc;			
			scope.fdatos.CodLocFis=scope.fdatos.CodLocSoc;
			scope.fdatos.ZonPosFis=scope.fdatos.ZonPosSoc;
			scope.filtrarLocalidadFisc();

		}
	}
	scope.punto_suministro=function()
	{
		console.log(scope.fpuntosuministro.TipRegDir);
		if(scope.fpuntosuministro.TipRegDir==0)
		{
			scope.fpuntosuministro.CodTipVia=undefined;
			scope.fpuntosuministro.NomViaPunSum=undefined;
			scope.fpuntosuministro.NumViaPunSum=undefined;
			scope.fpuntosuministro.BloPunSum=undefined;
			scope.fpuntosuministro.EscPunSum=undefined;
			scope.fpuntosuministro.PlaPunSum=undefined;
			scope.fpuntosuministro.PuePunSum=undefined;
			scope.fpuntosuministro.Aclarador=undefined;
			scope.fpuntosuministro.CodProPunSum=undefined;
			scope.fpuntosuministro.CodLocPunSum=undefined;
			scope.ZonPosPunSum=undefined;
			scope.fpuntosuministro.TelPunSum=undefined;
			scope.fpuntosuministro.CodTipInm=undefined;
			scope.fpuntosuministro.RefCasPunSum=undefined;
			scope.fpuntosuministro.DimPunSum=undefined;
			scope.fpuntosuministro.ObsPunSum=undefined;
		}
		if(scope.fpuntosuministro.TipRegDir==1)
		{
			scope.fpuntosuministro.CodTipVia=scope.fdatos.CodTipViaSoc;
			scope.fpuntosuministro.NomViaPunSum=scope.fdatos.NomViaDomSoc;
			scope.fpuntosuministro.NumViaPunSum=scope.fdatos.NumViaDomSoc;
			scope.fpuntosuministro.BloPunSum=scope.fdatos.BloDomSoc;
			scope.fpuntosuministro.EscPunSum=scope.fdatos.EscDomSoc;
			scope.fpuntosuministro.PlaPunSum=scope.fdatos.PlaDomSoc;
			scope.fpuntosuministro.PuePunSum=scope.fdatos.PueDomSoc;
			scope.fpuntosuministro.CodProPunSum=scope.fdatos.CodProSoc;
			scope.filtrarLocalidadPunSum();
			scope.fpuntosuministro.CodLocPunSum=scope.fdatos.CodLocSoc;
			scope.ZonPosPunSum=scope.fdatos.ZonPosSoc;
			console.log(scope.fpuntosuministro);
		}
		if(scope.fpuntosuministro.TipRegDir==2)
		{
			scope.fpuntosuministro.CodTipVia=scope.fdatos.CodTipViaFis;
			scope.fpuntosuministro.NomViaPunSum=scope.fdatos.NomViaDomFis;
			scope.fpuntosuministro.NumViaPunSum=scope.fdatos.NumViaDomFis;
			scope.fpuntosuministro.BloPunSum=scope.fdatos.BloDomFis;
			scope.fpuntosuministro.EscPunSum=scope.fdatos.EscDomFis;
			scope.fpuntosuministro.PlaPunSum=scope.fdatos.PlaDomFis;
			scope.fpuntosuministro.PuePunSum=scope.fdatos.PueDomFis;
			scope.fpuntosuministro.CodProPunSum=scope.fdatos.CodProFis;
			scope.filtrarLocalidadPunSum();
			scope.fpuntosuministro.CodLocPunSum=scope.fdatos.CodLocFis;
			scope.ZonPosPunSum=scope.fdatos.ZonPosFis;
			console.log(scope.fpuntosuministro);
		}




	}

	if(scope.nID!=undefined)
	{
		scope.buscarXID();
		//scope.funcion_services();
	}	
	else
	{
		//scope.funcion_services();
		var url = base_urlHome()+"api/Clientes/Consulta_Fecha/";
		$http.get(url).then(function(result)
		{
			scope.fdatos.FecIniCli=result.data;

		},function(error)
		{

		});
	}

}			