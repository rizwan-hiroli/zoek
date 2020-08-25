var image_width = 739;
var image_height = 415;
$(document).ready(function() {

    $.validator.addMethod('alpha', function(value, element) {
	    return this.optional(element) || value == value.match(/^[a-zA-Z\s]+$/);
	});
	$("#employeeForm").validate({
		errorClass:'red',
		ignore:[],
		rules: {
			firstname: {
				required: true
			},
			lastname: {
				required: true
			},
			// email:{
			// 	required:true,
			// 	email:true
			// },
			phone:{
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

	
	$('#employeeForm').submit(function(e){
		e.preventDefault();
  		$('#submit').button('loading');
		var methodType = $("#employeeForm").attr('method_type');
		var actionUrl = $("#employeeForm").attr('action');
		var result = $("#employeeForm").validate();
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
			    'first_name' : $('#firstname').val(),
			    'last_name' : $('#lastname').val(),
			    'email' : $('#email').val(),
			    'company_id' : $('#company_id').val(),
				'website' : $('#website').val(),
				'phone' : $('#phone').val(),
			},
			success: function(data){

			    $('#submit').button('reset');
			    
			    if(data.result == 'success'){
					$('.commonError').empty();
			        if(methodType == 'POST'){
			        	$("#employeeForm").trigger("reset");
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
