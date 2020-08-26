<?php

namespace App\Http\Controllers\Admin;

use View;
use Auth;
use Excel;
use Validator;
use DataTables;
use App\Models\Employee;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class EmployeeController extends Controller
{
    	/*
    Headers require for list view.
    */
    protected $listViewheaders = ['column_title'=>['First Name','Last Name','Company','Email','Phone',
                                'Status','Action'],
                                'database_column'=>['first_name','last_name','company','email','phone'],
                                'page_title'=>'Employees',
                                'model_name'=>'Employee',
                                'url'=>'employee'
                                ];
    
    protected $formHeaders = [
                                'page_title'=>'Employees',
                                'model_name'=>'Employee',
                                'url'=>'employee',
                            ];

    /*
    Form rules to validate.
    */
    protected $rules = ['first_name'=>'required',
                        'last_name'=>'required',
                        ];

    protected const PAGINAION_VALUE = 10; 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $listViewheaders = $this->listViewheaders;
        $data = Employee::withTrashed()->paginate(self::PAGINAION_VALUE);
        return view('admin.employee.employee-list',compact('listViewheaders','data'));      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formHeaders  =$this->formHeaders;
        $formHeaders['companies'] = Company::pluck('name','id')->toArray(); 
        return view('admin.employee.employee',compact('formHeaders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = $this->rules;
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            $response['result'] = 'validation-error';
            $response['messages'] = $validator->errors()->toArray();
            return response()->json($response);
        }
        $dataInserted = Employee::create($request->except('_token'));

        if($dataInserted)
            $response['result'] = 'success';
        else
            $response['result'] = 'failure';

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employees = Employee::find($id);
        $formHeaders  =$this->formHeaders;
        $formHeaders['companies'] = Company::pluck('name','id')->toArray();
        return view('admin.employee.employee',compact('formHeaders','employees'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Employee $student)
    {
        $rules = $this->rules;
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            $response['result'] = 'validation-error';
            $response['messages'] = $validator->errors()->toArray();
            return response()->json($response);
        }
        $student->update($request->except('_token'));   
        if($student)
            $response['result'] = 'success';
        else
            $response['result'] = 'failure';

        return response()->json($response);
    }

}
