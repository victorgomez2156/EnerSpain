 app.controller('Login', ['$scope', '$cookies','$translate', Controlador])
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
function Controlador($scope,$cookies,$translate)
{
	var idioma=$cookies.get('idioma');
	console.log(idioma);
	var scope = this;
	scope.fdatos = {};
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
	var index=0;
	scope.idioma=idioma;
	
	$translate.uses(idioma);
	//alert('aqui');
	scope.change_languaje=function(dato)
	{
		if(idioma!=dato)
		{
			$cookies.remove('idioma');
			$cookies.put("idioma", dato);
			location.href="";
		}
	}
}			