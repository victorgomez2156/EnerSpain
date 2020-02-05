app.controller('Controlador_Tarifas', ['$http', '$scope', '$filter','$route','$interval', '$controller','$cookies','$compile', Controlador]);
function Controlador($http,$scope,$filter,$route,$interval,$controller,$cookies,$compile)
{
	//declaramos una variable llamada scope donde tendremos a vm
	/*inyectamos un controlador para acceder a sus variables y metodos*/
	//$controller('Controlador_Clientes as vmAE',{$scope:$scope});
	//var testCtrl1ViewModel = $scope.$new(); //You need to supply a scope while instantiating.	
	//$controller('Controlador_Clientes',{$scope : testCtrl1ViewModel });		
	//var testCtrl1ViewModel = $controller('Controlador_Clientes');
   	//testCtrl1ViewModel.cargar_lista_clientes();
	var scope = this;
	scope.fdatos = {}; // datos del formulario
	scope.fdatos_tar_elec={};
	scope.fdatos_tar_gas={};
	//scope.nID = $route.current.params.ID;  //contiene el id del registro en caso de estarse consultando desde la grid
	scope.Nivel = $cookies.get('nivel');
	//testCtrl1ViewModel.cargar_lista_clientes();
	scope.TVistaTarEle=1;
	scope.T_TarifasEle=undefined;	
	scope.T_TarifasEleBack=undefined;	
	scope.ruta_reportes_pdf_tarifas_electrica="AMBAS";
	scope.ruta_reportes_excel_tarifas_electrica="AMBAS";
	scope.TipTen=true;
	scope.NomTarEle=true;
	scope.CanPerTar=true;
	scope.MinPotCon=true;
	scope.MaxPotCom=true;
	scope.AccTarElec=true;
	
	scope.TVistaTarGas=1;
	scope.T_TarifasGas=undefined;	
	scope.T_TarifasGasBack=undefined;
	scope.ruta_reportes_pdf_tarifas_gas=0;
	scope.ruta_reportes_excel_tarifas_gas=0;
	scope.NomTarGas=true;
	scope.MinConAnu=true;
	scope.MaxConAnu=true;
	scope.AccTarGas=true;
	scope.topciones = [{id: 1, nombre: 'VER'},{id: 2, nombre: 'EDITAR'}];
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

	//cargar_lista_clientes();

	///////////////////////TARIFAS ELECTRICAS START///////////////////////////
	scope.cargar_lista_Tarifa_Electrica=function()
	{
		$("#cargando").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
	    var url=base_urlHome()+"api/Tarifas/get_list_tarifa_electricas";
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
				scope.T_TarifasEle =result.data;
				scope.T_TarifasEleBack =result.data; 	 								
				$scope.totalItems = scope.T_TarifasEle.length; 
				$scope.numPerPage = 50;  
				$scope.paginate = function (value) 
				{  
					var begin, end, index;  
					begin = ($scope.currentPage - 1) * $scope.numPerPage;  
					end = begin + $scope.numPerPage;  
					index = scope.T_TarifasEle.indexOf(value);  
					return (begin <= index && index < end);  
				};
			}
			else
			{
				$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				Swal.fire({title:"Tarifas Electrica.",text:"No hemos encontrado Tarifas Electrica Registradas Actualmente.",type:"info",confirmButtonColor:"#188ae2"});
				scope.T_TarifasEle=undefined;
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
	scope.borrar_TarEle=function()
	{	
		if(scope.Nivel!=1)
		{
			Swal.fire({title:"Error",text:"Su Nivel no esta autorizado para realizar esta acción contacte un administrador del sistema.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
			
		}		
		Swal.fire({title:"Esta seguro de eliminar este registro.?",			
		type:"question",
		showCancelButton:!0,
		confirmButtonColor:"#31ce77",
		cancelButtonColor:"#f34943",
		confirmButtonText:"OK"}).then(function(t)
		{
	        if(t.value==true)
	    	{
	          	$("#borrando").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active" );
	          	var url = base_urlHome()+"api/Tarifas/borrar_tarifa_electrica/CodTarEle/"+scope.fdatos_tar_elec.CodTarEle;
	          	$http.delete(url).then(function(result)
	          	{
	          		if(result.data!=false)
	          		{
	          			$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						Swal.fire({title:"Exito!",text:"Registro Eliminado Correctamente.",type:"error",confirmButtonColor:"#188ae2"});
						scope.TVistaTarEle=1;
						scope.cargar_lista_Tarifa_Electrica();
	          		}
	          		else
	          		{
	          			$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						Swal.fire({title:"Error",text:"No se pudo eliminar el registro intente nuevamente.",type:"error",confirmButtonColor:"#188ae2"});
	          		}
	          	},function(error)
	          	{	          		
					$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );						
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
						Swal.fire({title:"Error 500.",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
					}
	          	});
	        }
	        else
	        {
	            console.log('Cancelando ando...');	                
	        }
	    });		
	}
	scope.borrar_row_electrica=function(index,id)
	{
		if(scope.Nivel!=1)
		{
			Swal.fire({title:"Error",text:"Su Nivel no esta autorizado para realizar esta acción contacte un administrador del sistema.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		Swal.fire({title:"Esta seguro de eliminar este registro.?",			
		type:"question",
		showCancelButton:!0,
		confirmButtonColor:"#31ce77",
		cancelButtonColor:"#f34943",
		confirmButtonText:"OK"}).then(function(t)
		{
	        if(t.value==true)
	    	{
	         	$("#borrando").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
				var url = base_urlHome()+"api/Tarifas/borrar_tarifa_electrica/CodTarEle/"+id;
				$http.delete(url).then(function(result)
				{
					if(result.data!=false)
					{
						$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						Swal.fire({title:"Error",text:"Registro Eliminado Correctamente.",type:"success",confirmButtonColor:"#188ae2"});
						scope.T_TarifasEle.splice(index,1);						
					}
					else
					{
						$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						Swal.fire({title:"Error",text:"No hemos podido borrar el registro intente nuevamente.",type:"error",confirmButtonColor:"#188ae2"});						
					}
				},function(error)
				{
					$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );						
					if(error.status==404 && error.statusText=="Not Found")
					{Swal.fire({title:"Error 404.",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
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
						Swal.fire({title:"Error 500.",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
					}
				}); 
	        }
	        else
	        {
	            console.log('Cancelando ando...');	                
	        }
	    });
	}
	scope.validar_opcion_TarEle=function(index,opciones_TarEle,dato)
	{
		console.log(index);
		console.log(opciones_TarEle);
		console.log(dato);
		if(opciones_TarEle==1)
		{
			
			scope.opciones_TarEle[index]=undefined;
			scope.fdatos_tar_elec=dato;
			scope.TVistaTarEle=2;
			scope.disabled_form_TarEle=1;
			if(dato.TipTen=="BAJA")
			{
				scope.fdatos_tar_elec.TipTen="0";
			}
			else
			{
				scope.fdatos_tar_elec.TipTen="1";
			}	
		}
		if(opciones_TarEle==2)
		{
			scope.opciones_TarEle[index]=undefined;
			scope.fdatos_tar_elec=dato;
			scope.TVistaTarEle=2;
			scope.disabled_form_TarEle=undefined;
			if(dato.TipTen=="BAJA")
			{
				scope.fdatos_tar_elec.TipTen="0";
			}
			else
			{
				scope.fdatos_tar_elec.TipTen="1";
			}
		}
	}
	scope.agregar_tarifa_electrica=function()
	{
		scope.TVistaTarEle=2;
		scope.fdatos_tar_elec={};
		scope.disabled_form_TarEle=undefined;
	}
	scope.validarsinumeroTarEle=function(metodo,object)
	{		
		if(metodo==1)
		{
			if(object!=undefined)
			{
				numero=object;		
				if(!/^([0-9])*$/.test(numero))
				scope.fdatos_tar_elec.CanPerTar=numero.substring(0,numero.length-1);
			}
		}
		if(metodo==2)
		{
			if(object!=undefined)
			{
				numero=object;		
				if(!/^([0-9])*$/.test(numero))
				scope.fdatos_tar_elec.MinPotCon=numero.substring(0,numero.length-1);
			}
		}
		if(metodo==3)
		{
			if(object!=undefined)
			{
				numero=object;		
				if(!/^([0-9])*$/.test(numero))
				scope.fdatos_tar_elec.MaxPotCon=numero.substring(0,numero.length-1);
			}
		}
	}
	scope.limpiar_TarEle=function()
	{
		scope.fdatos_tar_elec={};
	}
	scope.regresar_TarEle=function()
	{
		Swal.fire({title:"Estar Seguro de Regresar.?",			
		type:"question",
		showCancelButton:!0,
		confirmButtonColor:"#31ce77",
		cancelButtonColor:"#f34943",
		confirmButtonText:"OK"}).then(function(t)
		{
	        if(t.value==true)
	    	{
	    		scope.fdatos_tar_elec={};
	    		scope.TVistaTarEle=1;
	    		scope.cargar_lista_Tarifa_Electrica();
	        }
	        else
	        {
	            console.log('Cancelando ando...');	                
	        }
	    });
	}
	$scope.submitFormTarEle = function(event) 
	{
	 	if (!scope.validar_campos_tension())
		{
			return false;
		}
	 	if(scope.fdatos_tar_elec.CodTarEle==undefined)
	 	{
	 		var titulo='Guardando';
	 		var titulo2='Tarifa Eléctrica guardada satisfactoriamente.';
	 		var texto='¿Esta Seguro de Ingresar este nuevo registro.?';
	 	}
	 	else
	 	{
	 		var titulo='Actualizando';
	 		var titulo2='Tarifa Eléctrica modificada satisfactoriamente.';
	 		var texto='¿Esta Seguro de Actualizar este registro.?';
	 	}
	 	console.log(scope.fdatos_tar_elec);
	 	Swal.fire({title:titulo,
		text:texto,
		type:"question",
		showCancelButton:!0,
		confirmButtonColor:"#31ce77",
		cancelButtonColor:"#f34943",
		confirmButtonText:"OK"}).then(function(t)
		{
	        if(t.value==true)
	        {
	           	var url=base_urlHome()+"api/Tarifas/crear_tarifa_electrica/";
				$http.post(url,scope.fdatos_tar_elec).then(function(result)
				{
					scope.nID=result.data.CodTarEle;
					if(result.data!=false)
					{
						Swal.fire({title:titulo,text:titulo2,type:"success",confirmButtonColor:"#188ae2"});
						scope.buscarXIDTarEle();
					}
					else
					{
						Swal.fire({title:titulo,text:"No hemos podido "+titulo2+" este registro intente nuevamente",type:"error",confirmButtonColor:"#188ae2"});
						
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
	        else
	        {
	            event.preventDefault();
	            console.log('Cancelando ando...');
	        }
	    });		
	};
	scope.validar_campos_tension = function()
	{
		resultado = true;
		if (scope.fdatos_tar_elec.TipTen==null || scope.fdatos_tar_elec.TipTen==undefined || scope.fdatos_tar_elec.TipTen=='')
		{
			Swal.fire({title:"Debe Seleccionar el Tipo de Tensión.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (scope.fdatos_tar_elec.CanPerTar==null || scope.fdatos_tar_elec.CanPerTar==undefined || scope.fdatos_tar_elec.CanPerTar=='')
		{
			Swal.fire({title:"Debe Indicar la Cantidad de Periodos.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (scope.fdatos_tar_elec.MinPotCon==null || scope.fdatos_tar_elec.MinPotCon==undefined || scope.fdatos_tar_elec.MinPotCon=='')
		{
			Swal.fire({title:"Debe Indicar La Potencia Mínima.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (scope.fdatos_tar_elec.MaxPotCon==null || scope.fdatos_tar_elec.MaxPotCon==undefined || scope.fdatos_tar_elec.MaxPotCon=='')
		{
			Swal.fire({title:"Debe Indicar La Potencia Máxima.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (resultado == false)
		{
			return false;
		} 
			return true;
	} 
	scope.buscarXIDTarEle=function()
	{
		 $("#buscando").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active");
		 var url= base_urlHome()+"api/Tarifas/buscar_XID_TarEle/CodTarEle/"+scope.nID;
		 $http.get(url).then(function(result)
		 {
		 	if(result.data!=false)
		 	{
		 		$("#buscando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
		 		scope.fdatos_tar_elec=result.data;		 				
				console.log(scope.fdatos_tar_elec);
		 	}
		 	else
		 	{
		 		$("#buscando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				Swal.fire({title:"Error",text:"No hemos encontrado datos relacionados con este código.",type:"error",confirmButtonColor:"#188ae2"});
		 	}
		 },function(error)
		 {
		 	$("#buscando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
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
				Swal.fire({title:"Error 500.",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
			}
		});
	}
	scope.editar_TarEle=function(dato)
	{
		console.log(dato);
		scope.fdatos_tar_elec={};
		scope.TVistaTarEle=2;
		
		scope.fdatos_tar_elec=dato;
		if(dato.TipTen=="BAJA")
		{
			scope.fdatos_tar_elec.TipTen=0;
		}
		else
		{
			scope.fdatos_tar_elec.TipTen=1;
		}
	}
	$scope.SubmitFormFiltrosTarEle = function(event) 
	{
	 	if(scope.tmodal_TarEle.tipo_filtro==1)
	 	{
	 			 		
			$scope.predicate = 'id';  
			$scope.reverse = true;						
			$scope.currentPage = 1;  
			$scope.order = function (predicate) 
			{  
				$scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;  
				$scope.predicate = predicate;  
			}; 

			scope.T_TarifasEle = $filter('filter')(scope.T_TarifasEleBack, {TipTen: scope.tmodal_TarEle.TipTen}, true);	
			if(scope.tmodal_TarEle.TipTen=="AMBAS")
			{
				scope.T_TarifasEle=scope.T_TarifasEleBack;
			}				
			$scope.totalItems = scope.T_TarifasEle.length; 
			$scope.numPerPage = 50;  
			$scope.paginate = function (value) 
			{  
				var begin, end, index;  
				begin = ($scope.currentPage - 1) * $scope.numPerPage;  
				end = begin + $scope.numPerPage;  
				index = scope.T_TarifasEle.indexOf(value);  
				return (begin <= index && index < end);  
			};
			scope.ruta_reportes_pdf_tarifas_electrica=scope.tmodal_TarEle.TipTen;
			scope.ruta_reportes_excel_tarifas_electrica=scope.tmodal_TarEle.TipTen;
	 	}					
	};
	scope.regresar_filtro_TarEle=function()
	{
		$scope.predicate = 'id';  
		$scope.reverse = true;						
		$scope.currentPage = 1;  
		$scope.order = function (predicate) 
		{  
			$scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;  
			$scope.predicate = predicate;  
		};
		scope.T_TarifasEle =scope.T_TarifasEleBack
		$scope.totalItems = scope.T_TarifasEle.length; 
		$scope.numPerPage = 50;  
		$scope.paginate = function (value) 
		{  
			var begin, end, index;  
			begin = ($scope.currentPage - 1) * $scope.numPerPage;  
			end = begin + $scope.numPerPage;  
			index = scope.T_TarifasEle.indexOf(value);  
			return (begin <= index && index < end);  
		};
		scope.ruta_reportes_pdf_tarifas_electrica="AMBAS";
		scope.ruta_reportes_excel_tarifas_electrica="AMBAS";
	}
	/////////////////////////////////////////////////////////////////////////////////TARIFAS ELECTRIAS END///////////////////////////////////////////////////////////

	/////////////////////////////////////////////////////////////////////////////////TARIFAS GAS START///////////////////////////////////////////////////////////

	scope.cargar_lista_Tarifa_Gas=function()
	{
		 $("#cargando").removeClass( "loader loader-default" ).addClass( "loader loader-default  is-active");
	        var url=base_urlHome()+"api/Tarifas/get_list_tarifa_Gas";
			$http.get(url).then(function(result)
			{
				if(result.data!=false)
				{
					$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					$scope.predicate1 = 'id';  
					$scope.reverse1 = true;						
					$scope.currentPage1 = 1;  
					$scope.order1 = function (predicate1) 
					{  
						$scope.reverse1 = ($scope.predicate1 === predicate1) ? !$scope.reverse1 : false;  
						$scope.predicate1 = predicate1;  
					}; 						
					scope.T_TarifasGas =result.data;
					scope.T_TarifasGasBack =result.data; 	 								
					$scope.totalItems1 = scope.T_TarifasGas.length; 
					$scope.numPerPage1 = 50;  
					$scope.paginate1 = function (value1) 
					{  
						var begin1, end1, index1;  
						begin1 = ($scope.currentPage1 - 1) * $scope.numPerPage1;  
						end1 = begin1 + $scope.numPerPage1;  
						index1 = scope.T_TarifasGas.indexOf(value1);  
						return (begin1 <= index1 && index1 < end1);  
					};
				}
				else
				{
					$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					Swal.fire({title:"Tarifas Gas.",text:"No hemos encontrado Tarifas Gas Registradas Actualmente.",type:"info",confirmButtonColor:"#188ae2"});
					scope.T_TarifasGas=undefined;
				}
			},function(error)
			{
				if(error.status==404 && error.statusText=="Not Found")
				{
					$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					Swal.fire({title:"Error 404",text:"El método que esté intentando usar no puede ser localizado.",type:"error",confirmButtonColor:"#188ae2"});
				}
				if(error.status==401 && error.statusText=="Unauthorized")
				{
					$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					Swal.fire({title:"Error 401",text:"Disculpe, el usuario actual no tiene permisos para ingresar a este módulo.",type:"error",confirmButtonColor:"#188ae2"});
				}
				if(error.status==403 && error.statusText=="Forbidden")
				{
					$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
					Swal.fire({title:"Error 403",text:"Está intentando usar un APIKEY inválido.",type:"error",confirmButtonColor:"#188ae2"});
					
				}
				if(error.status==500 && error.statusText=="Internal Server Error")
				{
					$("#cargando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
					Swal.fire({title:"Error 500",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
				}
			});	
	}
	scope.validar_opcion_TarGas=function(index,opciones_TarGas,dato)
	{
		console.log(index);
		console.log(opciones_TarGas);
		console.log(dato);
		if(opciones_TarGas==1)
		{
			scope.opciones_TarGas[index]=undefined;
			scope.fdatos_tar_gas=dato;
			scope.TVistaTarGas=2;
			scope.disabled_form_TarGas=1;

		}
		if(opciones_TarGas==2)
		{
			scope.opciones_TarGas[index]=undefined;
			scope.fdatos_tar_gas=dato;
			scope.TVistaTarGas=2;
			scope.disabled_form_TarGas=undefined;
		}
	}
	scope.agg_TarGas=function()
	{
		scope.TVistaTarGas=2;
		scope.fdatos_tar_gas={};
		scope.disabled_form_TarGas=undefined;
	}
	scope.validarsinumeroTarGas=function(metodo,object)
	{		
		if(metodo==1)
		{
			if(object!=undefined)
			{
				numero=object;		
				if(!/^([0-9])*$/.test(numero))
				scope.fdatos_tar_gas.MinConAnu=numero.substring(0,numero.length-1);
			}
		}
		if(metodo==2)
		{
			if(object!=undefined)
			{
				numero=object;		
				if(!/^([0-9])*$/.test(numero))
				scope.fdatos_tar_gas.MaxConAnu=numero.substring(0,numero.length-1);
			}
		}
	}
	$scope.submitFormTarGas = function(event) 
	{
	 	if (!scope.validar_campos_TarGas())
		{
			return false;
		}
	 	if(scope.fdatos_tar_gas.CodTarGas==undefined)
	 	{
	 		var titulo='Guardando';
	 		var titulo2='Tarifa Gas guardada satisfactoriamente.';
	 		var texto='¿Esta Seguro de Ingresar este nuevo registro.?';
	 	}
	 	else
	 	{
	 		var titulo='Actualizando';
	 		var titulo2='Tarifa Gas modificada satisfactoriamente.';
	 		var texto='¿Esta Seguro de Actualizar este registro.?';
	 	}
	 	console.log(scope.fdatos_tar_gas);
	 	Swal.fire({title:titulo,
		text:texto,
		type:"question",
		showCancelButton:!0,
		confirmButtonColor:"#31ce77",
		cancelButtonColor:"#f34943",
		confirmButtonText:"OK"}).then(function(t)
		{
	        if(t.value==true)
	        {
	           	var url=base_urlHome()+"api/Tarifas/crear_tarifa_gas/";
				$http.post(url,scope.fdatos_tar_gas).then(function(result)
				{
					scope.nIDTarGas=result.data.CodTarGas;
					if(result.data!=false)
					{
						Swal.fire({title:titulo,text:titulo2,type:"success",confirmButtonColor:"#188ae2"});
						scope.buscarXIDTarGas();
					}
					else
					{
						Swal.fire({title:titulo,text:"Un error ha ocurrido durante el proceso, Por Favor intente nuevamente.",type:"error",confirmButtonColor:"#188ae2"});
						
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
	        else
	        {
	            event.preventDefault();
	            console.log('Cancelando ando...');
	        }
	    });		
	};
	scope.validar_campos_TarGas = function()
	{
		resultado = true;
		if (scope.fdatos_tar_gas.NomTarGas==null || scope.fdatos_tar_gas.NomTarGas==undefined || scope.fdatos_tar_gas.NomTarGas=='')
		{
			Swal.fire({title:"Debe Indicar el Nombre de La Tarifa.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (scope.fdatos_tar_gas.MinConAnu==null || scope.fdatos_tar_gas.MinConAnu==undefined || scope.fdatos_tar_gas.MinConAnu=='')
		{
			Swal.fire({title:"Debe Indicar El Consumo Mínimo.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		if (scope.fdatos_tar_gas.MaxConAnu==null || scope.fdatos_tar_gas.MaxConAnu==undefined || scope.fdatos_tar_gas.MaxConAnu=='')
		{
			Swal.fire({title:"Debe Indicar un Consumo Máximo.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
		}
		
		if (resultado == false)
		{
			return false;
		} 
			return true;
	}
	scope.buscarXIDTarGas=function()
	{
		 $("#buscando").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active");
		 var url= base_urlHome()+"api/Tarifas/buscar_XID_TarGas/CodTarGas/"+scope.nIDTarGas;
		 $http.get(url).then(function(result)
		 {
		 	if(result.data!=false)
		 	{
		 		$("#buscando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
		 		scope.fdatos_tar_gas=result.data;		 				
				console.log(scope.fdatos_tar_gas);
		 	}
		 	else
		 	{
		 		$("#buscando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
				Swal.fire({title:"Error",text:"No hemos encontrado datos relacionados con este código.",type:"error",confirmButtonColor:"#188ae2"});
		 	}
		 },function(error)
		 {
		 	$("#buscando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );				
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
				Swal.fire({title:"Error 500.",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
			}
		});
	}
	scope.borrar_TarGas=function()
	{	
		if(scope.Nivel!=1)
		{
			Swal.fire({title:"Error",text:"Su Nivel no esta autorizado para realizar esta acción contacte un administrador del sistema.",type:"error",confirmButtonColor:"#188ae2"});
			return false;
			
		}		
		Swal.fire({title:"Esta seguro de eliminar este registro.?",			
		type:"question",
		showCancelButton:!0,
		confirmButtonColor:"#31ce77",
		cancelButtonColor:"#f34943",
		confirmButtonText:"OK"}).then(function(t)
		{
	        if(t.value==true)
	    	{
	          	$("#borrando").removeClass( "loader loader-default" ).addClass( "loader loader-default is-active" );
	          	var url = base_urlHome()+"api/Tarifas/borrar_tarifa_gas/CodTarGas/"+scope.fdatos_tar_gas.CodTarGas;
	          	$http.delete(url).then(function(result)
	          	{
	          		if(result.data!=false)
	          		{
	          			$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						Swal.fire({title:"Exito!",text:"Registro Eliminado Correctamente.",type:"error",confirmButtonColor:"#188ae2"});
						scope.TVistaTarGas=1;
						scope.fdatos_tar_gas={};
						scope.cargar_lista_Tarifa_Gas();
	          		}
	          		else
	          		{
	          			$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );
						Swal.fire({title:"Error",text:"No se pudo eliminar el registro intente nuevamente.",type:"error",confirmButtonColor:"#188ae2"});
	          		}
	          	},function(error)
	          	{	          		
					$("#borrando").removeClass( "loader loader-default is-active" ).addClass( "loader loader-default" );						
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
						Swal.fire({title:"Error 500.",text:"Actualmente presentamos fallas en el servidor, por favor intente mas tarde.",type:"error",confirmButtonColor:"#188ae2"});
					}
	          	});
	        }
	        else
	        {
	            console.log('Cancelando ando...');	                
	        }
	    });		
	}
	scope.limpiar_TarGas=function()
	{
		scope.fdatos_tar_gas={};
	}
	scope.regresar_TarGas=function()
	{
		Swal.fire({title:"Estar Seguro de Regresar.?",			
		type:"question",
		showCancelButton:!0,
		confirmButtonColor:"#31ce77",
		cancelButtonColor:"#f34943",
		confirmButtonText:"OK"}).then(function(t)
		{
	        if(t.value==true)
	    	{
	    		scope.fdatos_tar_gas={};
	    		scope.TVistaTarGas=1;
	    		scope.cargar_lista_Tarifa_Gas();
	        }
	        else
	        {
	            console.log('Cancelando ando...');	                
	        }
	    });
	}




	/////////////////////////////////////////////////////////////////////////////////TARIFAS GAS END///////////////////////////////////////////////////////////

}			