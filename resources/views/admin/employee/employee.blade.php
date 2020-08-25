@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{asset('admin/css/Datepicker/bootstrap-datepicker.css')}}">
@endpush
@section('form_container')
		            
			{{ Form::open([	
				'url' => isset($employees)?'admin/employee/'.$employees->id : 'admin/employee',
				'method_type' => isset($employees) ? 'PATCH':'POST','id' => 'employeeForm',
				'name' => 'employeeForm']) 
			}}

        	<input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
        	<input type="hidden" name="modelName" id="modelName" value="{{$formHeaders['model_name'] }}">
          
          <div class="item form-group mt30">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">First Name 
                  <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12" style="padding-left:0px">
                  {{ Form::text('firstname',  
                      isset($employees->first_name) ? $employees->first_name : '', 
                      ['class' => 'form-control boxed','placeholder'=>'Enter firstname ','id'=>'firstname'])}}
                </div>
                <div class="row">
                  <div class="col-md-8 col-md-offset-3">
                     <div class="id-file-error-div firstname commonError error"></div>
                  </div>
                </div>
          </div>

          <div class="item form-group mt30">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Last Name 
                  <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12" style="padding-left:0px">
                  {{ Form::text('lastname',  
                      isset($employees->last_name) ? $employees->last_name : '', 
                      ['class' => 'form-control boxed','placeholder'=>'Enter lastname ','id'=>'lastname'])}}
                </div>
                <div class="row">
                  <div class="col-md-8 col-md-offset-3">
                     <div class="id-file-error-div lastname commonError error"></div>
                  </div>
                </div>
          </div>

          <div class="item form-group mt30">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Email 
                  <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12" style="padding-left:0px">
                  {{ Form::text('email',  
                      isset($employees->email) ? $employees->email : '', 
                      ['class' => 'form-control boxed','placeholder'=>'Enter Email ','id'=>'email'])}}
                </div>
                <div class="row">
                  <div class="col-md-8 col-md-offset-3">
                     <div class="id-file-error-div email commonError error"></div>
                  </div>
                </div>
          </div>

          <div class="item form-group mt30">
             <label class="control-label col-md-3 col-sm-3 col-xs-12">Company
                <span class="required">*</span>
             </label>
             <div class="col-md-6 col-sm-6 col-xs-12 padding-left-0">
               {{Form::select('company',$formHeaders['companies'],$employees->company_id ?? '',['class' => 'form-control boxed','id'=>'company'])}}
             </div>
             <div class="row">
                 <div class="col-md-8 col-md-offset-3">
                     <div class="id-file-error-div commpany_id commonError error"></div>
                 </div>
             </div>
          </div>

          <div class="item form-group mt30">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Phone 
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12" style="padding-left:0px">
                  {{ Form::text('phone',  
                      isset($employees->phone) ? $employees->phone : '', 
                      ['class' => 'form-control boxed','placeholder'=>'Enter Contact No ','id'=>'phone'])}}
                </div>
                <div class="row">
                  <div class="col-md-8 col-md-offset-3">
                     <div class="id-file-error-div phone commonError error"></div>
                  </div>
                </div>
          </div>

          @include('admin.partials.form_button')
      
      {{ Form::close() }}

@endsection

@push('form_scripts')
    <script src="{{asset('admin/js/Employee/employee.js')}}"></script>
@endpush
