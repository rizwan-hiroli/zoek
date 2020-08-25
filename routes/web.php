<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/', function(){return redirect('login');});
Route::get('/home', function(){return redirect('/admin/dashboard');});

Route::group(['prefix' => 'admin'], function () {
	Route::group(['namespace' => 'Admin', 'middleware' => ['auth']], function () {

		Route::get('/', function(){return redirect('login');});
		
		// Common routes.
		Route::get('/home', function(){return view('home');});
		Route::get('/dashboard','MasterController@dashboard');
		Route::get('status','MasterController@changeStatus')->name('status');
		Route::post('file/upload','MasterController@uploadImage');
		Route::post('file/remove','MasterController@removeImage');
		Route::post('change-password','MasterController@changePassword');
		
    	//Modules individual routes.
		Route::resource('employee', 'EmployeeController');
		Route::resource('company', 'CompanyController');
	});	
});