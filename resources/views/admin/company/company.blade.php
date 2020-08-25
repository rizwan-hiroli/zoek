@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{asset('admin/css/Datepicker/bootstrap-datepicker.css')}}">
@endpush
@section('form_container')
		            
			{{ Form::open([	
				'url' => isset($company)?'admin/company/'.$company->id : 'admin/company',
				'method_type' => isset($company) ? 'PATCH':'POST','id' => 'companyForm',
				'name' => 'companyForm']) 
			}}

        	<input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
        	<input type="hidden" name="modelName" id="modelName" value="{{$formHeaders['model_name'] }}">
          

          @php $title = isset($company->name) ? $company->name : null; @endphp
          @include('admin.partials.title')

          <div class="item form-group mt30">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Email 
                  <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12" style="padding-left:0px">
                  {{ Form::text('email',  
                      isset($company->email) ? $company->email : '', 
                      ['class' => 'form-control boxed','placeholder'=>'Enter Email ','id'=>'email'])}}
                </div>
                <div class="row">
                  <div class="col-md-8 col-md-offset-3">
                     <div class="id-file-error-div email commonError error"></div>
                  </div>
                </div>
          </div>

          <div class="item form-group mt30">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Website 
                  <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12" style="padding-left:0px">
                  {{ Form::text('website',  
                      isset($company->website) ? $company->website : '', 
                      ['class' => 'form-control boxed','placeholder'=>'Enter website ','id'=>'website'])}}
                </div>
                <div class="row">
                  <div class="col-md-8 col-md-offset-3">
                     <div class="id-file-error-div website commonError error"></div>
                  </div>
                </div>
          </div>


          @php $name = $company->logo ?? null; 
                $title = 'Logo';
                $instruction_text = '(Max size: 5MB, Types Allowed: jpg, jpeg, png)';
          @endphp
          @include('admin.partials.image_upload')

          @include('admin.partials.form_button')
      
      {{ Form::close() }}

@endsection

@push('form_scripts')
    <script src="{{asset('admin/js/Company/company.js')}}"></script>
@endpush
