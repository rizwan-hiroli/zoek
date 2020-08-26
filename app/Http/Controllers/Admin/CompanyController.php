<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Validator;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class CompanyController extends Controller
{
    	/*
    Headers require for list view.
    */
    protected $listViewheaders = ['column_title'=>['Name','Email','Logo','Website','Status','Action'],
                                'database_column'=>['name','email','logo','website'],
                                'page_title'=>'Companies',
                                'model_name'=>'Company',
                                'url'=>'company'
                                ];
    
    protected $formHeaders = [
                                'page_title'=>'Companies',
                                'model_name'=>'Company',
                                'url'=>'company',
                            ];

    /*
    Form rules to validate.
    */
    protected $rules = ['name'=>'required',
                        'email'=>'required',
                        'website'=>'required|max:200',
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
        $data = Company::withTrashed()->paginate(self::PAGINAION_VALUE);   
        return view('admin.company.company-list',compact('listViewheaders','data'));      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formHeaders  =$this->formHeaders; 
        return view('admin.company.company',compact('formHeaders'));
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
        
        $dataInserted = Company::create($request->except('_token'));

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
        $company = Company::find($id);
        $formHeaders  =$this->formHeaders;
        return view('admin.company.company',compact('formHeaders','company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Company $company)
    {
        $rules = $this->rules;
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            $response['result'] = 'validation-error';
            $response['messages'] = $validator->errors()->toArray();
            return response()->json($response);
        }
        $company->update($request->except('_token'));   
        if($company)
            $response['result'] = 'success';
        else
            $response['result'] = 'failure';

        return response()->json($response);

    }

}
