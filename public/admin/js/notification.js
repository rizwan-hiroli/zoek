$(document).ready(function() {
	$.when(
	    $.getScript( "/admin/vendor/pnotify/dist/pnotify.js" ),
	    $.getScript( "/admin/vendor/pnotify/dist/pnotify.buttons.js" ),
	    $.Deferred(function( deferred ){
	        $( deferred.resolve );
	    })
	).done(function(){
	    
	});
});
function successNotification(title)
{
	var pathArray = window.location.pathname.split( '/' )[2];
	var text = title+' submitted successfully ! <br><br> <div class="col-md-3 col-md-offset-4" ></div>';
	new PNotify({
      	title: title,
      	text: text,
      	type: 'info',
      	styling: 'bootstrap3',
	    buttons: {
	      sticker: false
	    }
  	});
}

function errorNotification(title)
{
	new PNotify({
      	title: title,
      	text: 'Some error occured.Please try again later !',
      	type: 'error',
      	styling: 'bootstrap3',
      	buttons: {
	      sticker: false
	    }
  	});
}
function customErrorNotification(title,msg)
{
	new PNotify({
      	title: title,
      	text: msg,
      	type: 'error',
      	styling: 'bootstrap3',
      	buttons: {
	      sticker: false
	    }
  	});
}


