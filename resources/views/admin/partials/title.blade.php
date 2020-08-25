<div class="item form-group mt30">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name 
    	<span class="required">*</span>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12 padding-left-0">
    {{ Form::text('title',  
    			isset($title) ? $title : '', 
    			['class' => 'form-control boxed','placeholder'=>'Please enter name',
    			'id'=>'title'])}}
    </div>
    <div class="row">
     	<div class="col-md-8 col-md-offset-3">
     		<div class="title commonError error"></div>
     	</div>
    </div>
</div>