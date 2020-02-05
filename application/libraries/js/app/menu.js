app.controller('CtrlMenuController', ['$http','$scope','$interval','ServiceMenu','$cookieStore','netTesting', Controlador]);
function Controlador ($http,$scope,$interval,ServiceMenu,$cookieStore,netTesting){
			//declaramos una variable llamada scope donde tendremos a vm
			var scope = this;
			scope.fMenu = []; // datos del formulario
			//Menu = $cookieStore.get('Menu');
			
			ServiceMenu.getAll().then(function(dato) 
			{
				scope.fMenu = dato;
					//$cookieStore.put("Menu", dato);
					//console.log(dato);
			}).catch(function(err) 
			{
				console.log(err); //Tratar el error
			});
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
			
			
			
};
