app.controller('Controlador_SIP', ['$http','$scope','$interval','ServiceMenu','$cookieStore','netTesting','$cookies', Controlador]);
function Controlador ($http,$scope,$interval,ServiceMenu,$cookieStore,netTesting,$cookies){
			//declaramos una variable llamada scope donde tendremos a vm
	var scope = this;
	scope.fdatos = [];
	
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



	scope.Servidor_API_Dynargy=function()
    {
       var settings = {
          "url": "https://api.dynargy.com/ConsumosInfo/}",
          "method": "GET",
          "timeout": 0,
          "headers": {
            "Content-Type": "application/json",
            "x-api-key": "xx",
            "User": "1"
          },
      "body": JSON.stringify({"filtros":{"listaCups":"ES0022000005447972KH","fechaConsumo":{"desde":"2020-11-01","hasta":"2020-11-30"}},"limite":5,"offset":0}),
        };

        $.ajax(settings).done(function (response) {
          console.log(response);
        });
      
       /* var settings = {
  "url": "https://api.dynargy.com/ConsumosInfo/}",
  "method": "GET",
  "timeout": 0,
  "headers": {
    "Content-Type": "application/json",
    "x-api-key": "xx",
    "User": "1"
  },
  "data": JSON.stringify({"filtros":{"listaCups":"ES0022000005447972KH","fechaConsumo":{"desde":"2020-11-01","hasta":"2020-11-30"}},"limite":5,"offset":0}),
};

$.ajax(settings).done(function (response) {
  console.log(response);
});*/
       /* var url=base_urlHome()+"api/SIP/API_DynargyService/";
        $http.get(url).then(function(result)
        {
            console.log(result);
        },function(error)
        {
            console.log(error);
        });*/
       /*var req = {
 method: 'GET',
 url: 'https://api.dynargy.com/ConsumosInfo/}',
 headers: {
   'Content-Type': 'application/json',
   'x-api-key':'xx',
   'User':'1'
 },
 data: { body: {
  "filtros": {
    "listaCups": "ES0022000005447972KH",
    "fechaConsumo": {
      "desde": "2020-11-01",
      "hasta": "2021-01-30"
    }
    },
  "limite": 5,
  "offset": 0
} }
}

$http(req).then(function(result){console.log(result)}, function(error){console.log(error)});*/
    	/*$http.get("https://api.dynargy.com/ConsumosInfo/}", {
  "filtros": {
    "listaCups": "ES0022000005447972KH",
    "fechaConsumo": {
      "desde": "2020-11-01",
      "hasta": "2021-01-30"
    }
    },
  "limite": 5,
  "offset": 0
})
            .success(function(respuesta){
                console.log(respuesta);
            });*/

        /*var url=base_urlHome()+"api/SIP/API_DynargyService/";
    	$http.get(url).then(function(result)
    	{
    		console.log(result);
    	},function(error)
    	{
    		console.log(error);
    	});*/

       		/*var request = require('request');
var options = {
  'method': 'GET',
  'url': 'https://api.dynargy.com/ConsumosInfo/}',
  'headers': {
    'Content-Type': 'application/json',
    'x-api-key': 'xx',
    'User': '1'
  },
  body: JSON.stringify({"filtros":{"listaCups":"ES0781100000000233MN","fechaConsumo":{"desde":"2020-11-01","hasta":"2021-01-30"}},"limite":5,"offset":0})

};
request(options, function (error, response) {
  if (error) throw new Error(error);
  console.log(response.body);
});*/
       		//formData = new FormData();
            //formData.append('x-api-key', 'xx');
            //formData.append('User', '1');
            //formData.append('Content-Type', 'application/json');
            //formData.append('body', JSON.stringify({"filtros":{"listaCups":"ES0781100000000233MN","fechaConsumo":{"desde":"2020-11-01","hasta":"2021-01-30"}},"limite":5,"offset":0}));             
                /*$.ajax({
                url : 'https://api.dynargy.com/ConsumosInfo/}',
                type: "GET",
                headers: {
	        	'authorization':'',
	        	'Content-Type':'application/json',
	        	'x-api-key':'xx',
	        	'User':'1',
	        	},
                data:{
  "filtros": {
    "listaCups": "ES0022000005447972KH",
    "fechaConsumo": {
      "desde": "2020-11-01",
      "hasta": "2021-01-30"
    }
    },
  "limite": 5,
  "offset": 0
},
                processData: false,
                contentType: false,
                async:false,
                success:function(data,textStatus,jqXHR)
                { 
                    console.log(data);
                    console.log(textStatus);
                    console.log(jqXHR);
                },              
                error: function(jqXHR, textStatus, errorThrown){
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);
                    scope.toast('error',jqXHR.responseText,jqXHR.status);
                }
            });
       	/*$.ajax({
		type: "GET",
		beforeSend: function(request) {
			request.setRequestHeader("authorization", '');
		    request.setRequestHeader("Content-Type", 'application/json');
		    request.setRequestHeader("x-api-key", 'xx');
		    request.setRequestHeader("User", '1');
		    request.setRequestHeader("body", JSON.stringify({"filtros":{"listaCups":"ES0781100000000233MN","fechaConsumo":{"desde":"2020-11-01","hasta":"2021-01-30"}},"limite":5,"offset":0}));
		  },
		url: "api/SIP/API_DynargyService",
		body: JSON.stringify({"filtros":{"listaCups":"ES0781100000000233MN","fechaConsumo":{"desde":"2020-11-01","hasta":"2021-01-30"}},"limite":5,"offset":0}),
        processData: false,
		success: function(msg) {
		  console.log(msg);
		},error: function (e) {
			 console.log(e);
		}
		});*/



        

        //$("#enviandoaudax").removeClass("loader loader-default").addClass("loader loader-default is-active");
        /*var url = 'https://api.dynargy.com/ConsumosInfo/}';
        var body={"filtros":{"listaCups":CUPs,"fechaConsumo":{"desde":fechadesde,"hasta":fechahasta}},"limite":5,"offset":0};
	    $.ajax({
	        url: url,
	        headers: {
	        'authorization':'',
	        'Content-Type':'application/json',
	        'x-api-key':'xx',
	        'User':'1',
	        type: 'GET',
	        body:body,
	        accepts: "application/json",
	        crossDomain: true,
	        success: function (result) {
	            // process result
	            //$('#result').html(result.ip);
	            console.log(result);
	        },
	        error: function (e) {
	             // log error in browser
	            console.log(e.message);
	        }
	    });*/
	   /*

	 */

	   /* $.ajax({
        url: 'https://api.dynargy.com/ConsumosInfo/}',
        type: 'GET',
        headers: {'authorization':'',
	        'Content-Type':'application/json',
	        'x-api-key':'xx',
	        'User':'1'},
        accepts: "application/json",
        crossDomain: true,
        dataType: 'json',
        body:{"filtros":{"listaCups":"ES0781100000000233MN","fechaConsumo":{"desde":"2021-01-01","hasta":"2021-01-31"}},"limite":5,"offset":0},
        success: function (result) {
            // process result
            console.log(result);
        },
        error: function (e) {
             // log error in browser
            console.log(e);
        }
    });*/
        /*var CUPs=scope.CUPsName;
        var fechadesde='2021-01-01';
        var fechahasta='2021-01-31';        
        var req = {
        method: 'GET',
        url: 'https://api.dynargy.com/ConsumosInfo/}',
            headers: {
            'Content-Type': 'application/json',
		    'x-api-key': 'xx',
		    'User': '1'
        },
            body: {"filtros":{"listaCups":CUPs,"fechaConsumo":{"desde":fechadesde,"hasta":fechahasta}},"limite":5,"offset":0}            
        }
        $http(req).then(function(result)
        {
        	console.log(result);        	
        },function(error)
        {	
        	console.log(error)
        });*/    
    }
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
};