var image_width = 739;
var image_height = 415;
$(document).ready(function() {

    $.validator.addMethod('alpha', function(value, element) {
	    return this.optional(element) || value == value.match(/^[a-zA-Z\s]+$/);
	});
	$("#companyForm").validate({
		errorClass:'red',
		ignore:[],
		rules: {
			title: {
				required: true
			},
			code: {
				required: true
			},
			// email:{
			// 	required:true,
			// 	email:true
			// },
			website:{
				required:true,
			},
			// blood_group:{
			// 	required:true,
			// },
			image_input:{
				required:true,
			},
			// profile_pic:{
			// 	required:true,
			// },
		},
		messages: {
			title: {
				required: 'Please select title.'
			},
			image_input: {
				required: 'Please select image.',
			},
			website: {
				required: 'Please enter website.',
			}
		},
		errorPlacement: function(error, element)
        {   	
            if (element.is("#image_input"))
            {	
                $(".error_image").html(error);
            }             
            else
            { 
                error.insertAfter( element );
            }   
        },
		submitHandler: function(form) {
		}
	});

	
	$('#companyForm').submit(function(e){
		e.preventDefault();
  		$('#submit').button('loading');
		var methodType = $("#companyForm").attr('method_type');
		var actionUrl = $("#companyForm").attr('action');
		var result = $("#companyForm").validate();
		var title = 'Company';
	
		if(!result.valid()){
			$('#submit').button('reset');
			return false;
		}
		
		$.ajax({
			type: methodType,
			url: actionUrl,
			data: {
			    '_token' : $('#_token').val(),
			    'name' : $('#title').val(),
			    'email' : $('#email').val(),
				'website' : $('#website').val(),
				'logo' : $('#image_input').val(),
			},
			success: function(data){

			    $('#submit').button('reset');
			    
			    if(data.result == 'success'){
					$('.commonError').empty();
			        if(methodType == 'POST'){
			        	$("#companyForm").trigger("reset");
			    		$('#image').prop('disabled', false);
			        	uploader.splice();
			    	}else{
			    		$('#image').prop('disabled',true);
			    	}
					successNotification(title);	
			    }
			    else if(data.result == 'failure'){
			    	errorNotification(title);
			    }else if(data.result == 'validation-error'){
			            // $('#loader').hide();
			            // $('.error').empty();
			            let x = data.messages;
			            $('.commonError').empty();
			            for (key in x) {
			                $('.'+key).text(x[key]);
			            }
			        }
			},
			error: function(data){
				$('#submit').button('reset');
				errorNotification(title);
			}
		});
	});
	
});
