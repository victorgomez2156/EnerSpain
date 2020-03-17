app.controller('CtrlMenuController', ['$http','$scope','$interval','ServiceMenu','$cookieStore','netTesting','$translate','$cookies', Controlador]);
function Controlador ($http,$scope,$interval,ServiceMenu,$cookieStore,netTesting,$translate,$cookies){
			//declaramos una variable llamada scope donde tendremos a vm
	var scope = this;
	scope.fMenu = []; // datos del formulario
	//Menu = $cookieStore.get('Menu');
	/*ServiceMenu.getAll().then(function(dato) 
	{
		scope.fMenu = dato;
		//$cookieStore.put("Menu", dato);
		//console.log(dato);
	}).catch(function(err) 
	{
		console.log(err); //Tratar el error
	});*/
	/*EL MENU ES EL ESPACIO IDEAL PARA HACER LA SOLICITUD DE DATOS REMOTOS PARA TRAER A LA BD LOCAL**/
	var fecha = new Date();
	var dd = fecha.getDate();
	var mm = fecha.getMonth()+1; //January is 0!
	var yyyy = fecha.getFullYear();
	if(dd<10){
	dd='0'+dd
	} 
	if(mm<10){
		mm='0'+mm
	} 
	var fecha = dd+'/'+mm+'/'+yyyy;
	scope.cerrar_sesion=function()
	{	
		Swal.fire({title:$translate('TITLE_CLOSE_SESSION'),text:$translate('Users')+$cookies.get('Username')+$translate('UsersConti'),		
		type:"question",
		showCancelButton:!0,
		confirmButtonColor:"#31ce77",
		cancelButtonColor:"#f34943",
		confirmButtonText:"OK"}).then(function(t)
		{
	        if(t.value==true)
	        {
	           document.location.href = 'Login/desconectar';
	        }
	        else
	        {
	            console.log('Cancelando ando...');
	        }
	    });/*bootbox.confirm({
	    title: $translate('TITLE_CLOSE_SESSION'),
	    message: "¿<b>"+scope.username+"</b> " +$translate('DISPOSICION_CIERRE_SESION')+"<b>&iquest;"+$translate('CONFIRMACION_CONTINUAR')+"</b>",
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
				location.href ="Login/desconectar";
					
			}
		}});*/
	}
			
			
};
