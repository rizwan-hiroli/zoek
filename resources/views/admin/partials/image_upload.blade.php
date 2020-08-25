<div class="item form-group mt30 div-image">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{$title ?? ''}} 
    	<span class="required">*</span>
        <div class="instruction-div required"> {{$instruction_text ?? ''}}</div>
    </label>
    <div class="btnLeft" id="">
       <button type="button"  name="image" id="image" class="btn btn-primary" data-loading-text="<i class='fa fa-circle-o-notch fa-spin '></i> Loading...">Browse</button>
    </div>
    <div class="row">
        <div class="col-md-offset-3">
            <input type="hidden" name="image_input" id="image_input" value="{{$name ?? null}}">
            <div class="file-error-div image commonError error error_image"></div>
            <div class="browseFileList" ></div>
            <div class="logoName"></div> 
        </div>
     </div>
</div>


