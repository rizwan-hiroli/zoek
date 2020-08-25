

var uploader;
//calling default image function.
$(document).ready(function() {
	
 	var id = $('#image').attr('id');
 	var hidden = 'image_input';
 	var image_container = 'browse_image';
 	var error ='error_image';
 	var list_image = "browseFileList";
 	var folder_name = $('#modelName').val();

 	uploader = uploadImage(id,hidden,uploader);

 	// setting image in case of edit.
 	if($('#'+hidden).val() != "" && typeof($('#'+hidden).val()) != "undefined"){

 		//$('#image').prop('disabled',true);
        displayImage(id,hidden);
    }
	
});

/**
 * function to upload image using plupload.
 * @param  String id              [id of the browse button]
 * @param  String hidden          [Field where image name stores]
 * @param  String image_container [div where image loads]
 * @param  String error           [Error to display]
 * @param  String iduploader      [uplaoder]
 * @return Json string            [output json]
*/


function uploadImage(id,hidden_id,iduploader,allow_extensions = "jpg,jpeg,png")
	{
		

		var dom = {
			uploads: $( "ul.uploads" )
		};
			
		iduploader = new plupload.Uploader({
	    runtimes : 'html5,flash,silverlight,html4',
	    multi_selection:false,
	    browse_button : id, 				// you can pass in id...
	    // container: document.getElementById('popupmessageupload'), // ... or DOM Element itself
	     
	    url : '/admin/file/upload',

	    filters : {
	        max_file_size : '5mb',
	        mime_types: [
	            {title : "Document files", extensions : allow_extensions},
	            // {title : "PDF files", extensions : "pdf"}
	        ]
	    },
	 	
	 	//compresssing image quality.
	    resize: {
			quality: 70,
		},

	    // Flash settings
	    flash_swf_url : '/public/client/js/plupload/Moxie.swf',
	 
	    // Silverlight settings
	    silverlight_xap_url : '/public/client/js/plupload/Moxie.xap',
	    
	    multipart_params : {
	        "_token" : $('input[name="_token"]').val(),
	        'model_name' : $('#modelName').val(),
	        // "type" : 'id_proof'
	    },
	 	
	    init: {
	        PostInit: function() {
	        	

	            // document.getElementById('filelist').innerHTML = '';
	            
	            // document.getElementById('filelist').innerHTML = '';
	        },
	 
	       FilesAdded: function(up, files) {
				// alert('inside');
				


	        	plupload.each(files, function(file) {
	        		//console.log(plupload.formatSize(file.size));
	        		
	              	var max_files = 1;

	                if (up.files.length > max_files) {
	                	
	                    //alert('You are allowed to add only ' + max_files + ' files.');
	                    //up.splice(); // reset the queue to zero);
	                    $('#'+id).closest('.div-image').find('.file-error-div').html('You are allowed to add only ' + max_files + ' files.').addClass('validation-error');
	                    up.removeFile(file);
	                    
	                }
	                else
	                {
	                	$('#'+id).prop("disabled", true);
	                	let image_div = $('#'+id).closest('.div-image');
	                	//var fileName = appendTimeStamp(file.name);
	                	var fileName = file.name;
	                	var hidden_input = image_div.find('#'+hidden_id);
	                	var timestamp = $.now();
	                	//fileName = fileName.replace(" ", "_");
	                	fileName = timestamp+"_"+fileName.split(/[ ,]+/).join('_');
	                	file.name = fileName;
	     
		                if(hidden_input.val() == ""){
		                	hidden_input.val(fileName);
		                }
		                else{
		                	hidden_input.val(hidden_input.val()+","+fileName);
		                }
			            
	              		var container = image_div.find('.browseFileList');
	              		var item = $('<div/>', {
						    id: file.id,
						}).addClass('margin10Px').append('<a href="" class="remove btn error"><i class="fa fa-times"></i></a>');
	              		//console.log(file);
	              		if(file.type == 'application/pdf')
	              		{
	              			var image = $( new Image() ).appendTo( item );
							image.prop( "src",$('#pdf_image_url').val());
							image.prop('style','width:50px;height:auto;margin-right: 20px;padding-top:10px;');
							
	              			$('<div>'+file.name+'</div>').appendTo(item);
	              			iduploader.start();
	              		}
	              		else
	              		{
							var image = $( new Image() ).appendTo( item );
							var preloader = new moxie.image.Image();
							preloader.onload = function() {
								//Adding image resolution validation.
								// if((image_width!=preloader.width) || (image_height!=preloader.height)){
								// 	$('#'+id).closest('.div-image').find('.file-error-div').html('Image resolution should be ' + image_width + ' X '+image_height+'.').addClass('validation-error');
	                   			// 	up.removeFile(file);
	                   			// 	$('#'+id).prop("disabled", false);

	                   			// 	//removeUploadedFile(file.name, 'image', container);
								// }else{
									preloader.downsize( 80, 80,false, false);
									image.prop( "src", preloader.getAsDataURL() );
									image.prop('style','width:50px;height:auto;margin-right: 20px;padding-top:10px;');
									iduploader.start();

								// }
							};
							preloader.load( file.getSource() );
						}
						
						image_div.find(".browseFileList").append(item);
	          			
	          			$('#' + file.id ).on('click', 'a.remove', function(e) {
	          				e.preventDefault();  
				            up.removeFile(file);
				            //var filepath=$("#"+image_container).val(); 
				           	var filepath=image_div.find("#"+hidden_id).val(); 
				            var filevalue=removeValue(filepath,fileName,",");
				            
				            $('#' + file.id).next("br").remove();
				            $('#' + file.id).remove();
				            image_div.find("#"+hidden_id).val(filevalue);
				            image_div.find('.file-error-div').html('');
				            $('#'+id).prop("disabled", false);
				            let container = image_div.find('.browseFileList');
				            removeUploadedFile(file.name, 'image', container);
				              
						});
						
	          			
	          			image_div.find('.file-error-div').html('');
	            	} 
	            	

	            });
	        	// let sal_div = $('#'+ id).closest('.div-salary');
	        	let image_div = $('#'+id).closest('.div-image');
	    		check_file_empty(hidden_id,image_div);
	        },
			FilesRemoved: function(up, files) 
			{            	
	        	plupload.each(files, function(file) {
	        		let type = "image";
	               let image_div = $('#'+id).closest('.div-image');
		            up.removeFile(file);
		            var filepath=image_div.find("#"+hidden_id).val(); 
		           
		            var filevalue=removeValue(filepath,file.name,",");
		            //let type = "salary_documents";
		            let container = image_div.find('.browseFileList');
		            $('#' + file.id).next("br").remove();
		            $('#' + file.id).remove();
		            image_div.find("#"+hidden_id).val(filevalue);

		            var filename=image_div.find("#"+hidden_id).val();

		            if(filename != "")
		            	removeUploadedFile(file.name, type, container);
		            if (up.files.length < 1)
		            {
		            	image_div.find("#"+hidden_id).rules("add","required");
		        	}
		            
	            });
	      	},
	            
	      	
	        UploadProgress: function(up, file) {
	        	
	        },
	 
	        Error: function(up, err) {
	        	let image_div = $('#'+id).closest('.div-image');
	        	var str= "\nError #" + err.code + ": " + err.message;
	        	//console.log(str);
	        	//sal_div.find('.error-salary_file').html("Max Size exceeded. Allowed only 5MB");
	        	if(err.code == "-600")
	               image_div.find('.file-error-div').html("Max Size exceeded. Allowed only 5MB");
	            else if(err.code == "-601"){
	                //image_div.find('.file-error-div').html("File Types Allowed are Jpeg, Jpg, Png and Pdf");
	                image_div.find('.file-error-div').html("File Types Allowed only "+allow_extensions.replace(/,/g,', '));
	            }
	        	//console.log(str);
	        	up.removeFile(err.file);
	        	
	        },

	        FileUploaded:function(up,file,info)
	        {
	            var data = $.parseJSON(info.response);
	            /*if(data.result == "failure"){
	                $('.error').html('File not uploaded properly.');
	                $('#error').empty();
	            }*/
	            //var data = $.parseJSON(info.response);

	            if(data.result.result == "success"){
					$('#'+id).button("reset");
					
	            }
	            else if(data.result == "failure"){
	            	
	            	
	            	let image_div = $('#'+id).closest('.div-image');
	            	var filepath=image_div.find("#"+hidden_id).val();
				    let fileName = file.name;    
				   
		            var filevalue=removeValue(filepath,fileName,",");
		            
		            $('#' + file.id).next("br").remove();
		            $('#' + file.id).remove();
		            image_div.find("#"+hidden_id).val(filevalue);
		            image_div.find('.file-error-div').html('File not uploaded successfully');
		            
		            up.removeFile(file);
		            $('#'+id).prop("disabled", false);
	            	$('#'+id).button("reset");
	            }
	            
	        },
	        BeforeUpload : function (up,file){
	        	//$.extend(up.settings.multipart_params, { dir_name : $('#aadhaar_fname').val()});
	        	//up.refresh();
	        	$.extend(up.settings.multipart_params, { Filename : file.name});  
	        	// $('#loader').show();
	        	$('#'+id).button("loading");

	        }
	    }

	});
	iduploader.init();
	return iduploader;
} 

/* check If file input empty then add required rule other wise remove require rule */
function check_file_empty(hiddenid,image_div)
{


	var hidd_id=image_div.find("#"+hiddenid).val();

	if(hidd_id!="")
	{

		image_div.find("#"+hiddenid).attr("class","valid");
		image_div.find("#"+hiddenid).attr("aria-invalid","false");
		image_div.find("#"+hiddenid+"-error").css("display","none");
		image_div.find("#"+hiddenid).rules("remove","required");
	}
	else
	{
		image_div.find("#"+hiddenid).attr("class","error");
		image_div.find("#"+hiddenid).rules("add","required");
	}
}
/* remove value from list */
var removeValue = function(list, value, separator) {
  separator = separator || ",";
  var values = list.split(separator);
  for(var i = 0 ; i < values.length ; i++) {
    if(values[i] == value) {
      values.splice(i, 1);
      return values.join(separator);
    }
  }
  return list;
}
 /* Function to remove uploaded files */
function removeUploadedFile(file_name, doc_type, container){
	// $('#loader').show();
	$.ajax({
		data: {
			file_name: file_name,
			type: doc_type,
			'_token' : $('#_token').val(),
			'model_name' : $('#modelName').val()
		},
		type: 'post',
		url: '/admin/file/remove',
		success: function(data){

			if(data.result == 'success'){
				//$(container).empty();
				// alert("removed");
			}
			$('#loader').hide();
		},
		error: function(data){
		}
	});
} 

/**
 * function to display image in case of edit.
 * @param  String data        [name if hidden field where image name exists.]
 * @param  String folder_name [Folder name of image]
 * @param  String list_image  [div where image loads]
 * @return Json string        [image]
*/
function displayImage(id,data,multiple_type=false){
	
	let folder_name = $('#modelName').val();
	var array = $('#'+data).val().split(",");
	let image_div = $('#'+id).closest('.div-image');
	var count =0;
	$.each(array,function(i){
	   if(array[i] != ""){
	   	
	   		count++;
	   		div_id = id+count;
	        //var item = image_div.find(".browseFileList").addClass('margin10Px').append('<a href="" class="remove error" style="padding-right: 6px"><i class="fa fa-times"></i></a>').css({'display': 'inline-flex','margin-top': '10px'});
	        var item = $('<div/>', {
			    id: div_id,
			}).addClass('margin10Px').addClass('margin10Px').append('<a href="" class="remove error" style="padding-right: 6px"><i class="fa fa-times"></i></a>');
	        var image = $( new Image() ).appendTo( item );
	        if(array[i].split('.').pop() == 'pdf'){
	            image.prop( "src",$('#pdf_image_url').val());
	            image.prop('style','width:50px;height:auto;');
	            $('<div class = "extendedText">'+array[i]+'</div>').appendTo(item);
	        }else{
	        	
	            // if($.UrlExists(window.location.origin+"/client/uploads/source/"+$('#data').val()+'_'+data+'_'+$('#'+data).val()))
	            image.prop( "src",window.location.origin+"/storage/"+folder_name+'/'+array[i]);
	        }
	        image.prop('style','width:50px;height:auto;margin-right: 20px;padding-top:10px;');
	        //$('.'+list_image).html($('#'+data).val());
	        image_div.find(".browseFileList").append(item);

	        $('#'+div_id).on('click', 'a.remove', function(e) {

	            e.preventDefault();  
	            let current_div_id = $(this).parent().attr('id');
	            
	            var filepath=image_div.find("#"+data).val(); 	           
	            var filevalue=removeValue(filepath,array[i],",");
	            $('#' + current_div_id).next("br").remove();
	            $('#' + current_div_id).remove();
	            
	            image_div.find("#"+data).val(filevalue);
	            let type = "image";
	        	let container = image_div.find('.browseFileList');
	        	removeUploadedFile(array[i], type, container);
	        	enableDisableBrowseButton(id,$('#'+data).val(),multiple_type);
	        });
	        enableDisableBrowseButton(id,$('#'+data).val(),multiple_type);
	    }
	}); 
}
function enableDisableBrowseButton(button_id,data,multiple_type=false)
{
	if(multiple_type)
	{
		let max_files = 10;
		var array = data.split(",");
		if(array.length >= max_files){
			$('#'+button_id).prop("disabled", true);
		}else{
			$('#'+button_id).prop("disabled", false);
		}
	}else{
		
		if(data!=''){
			$('#'+button_id).prop("disabled", true);
		}else{
			$('#'+button_id).prop("disabled", false);
		}
	}
}

