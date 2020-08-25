<?php

namespace App\Http\Controllers\Admin;

use View;
use Auth;
use Excel;
use Validator;
use DataTables;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        //Disallowing user to access students
        // if(auth()->user()->role == 'STUDENT'){
        //     abort(401);
        // }

        $listViewheaders = $this->listViewheaders;
        // $listViewheaders['standards'] = Standard::select('name','id')->get()->toArray();
        // $listViewheaders['divisions'] = Division::select('name','id')->get()->toArray();
        $data = Company::withTrashed()->paginate(self::PAGINAION_VALUE);
        // dd($data);
        if ($request->ajax()) {
            // $categoryId = $request->category;
            // $subCategoryId = $request->sub_category; 
            // $filters = ['school_id'=>auth()->user()->school_id,'role'=>'STUDENT',
            //             // 'std_id'=>$categoryId,'div_id'=>$subCategoryId];

            // if(auth()->user()->role == 'TEACHER'){
            //     $filters['std_id'] = auth()->user()->std_id;
            // }
            // dd('in');
            $data = Company::withTrashed()->get();
            $actionUrl = 'company';
            return Datatables::of($data)
                    ->addColumn('action', function($row) use($actionUrl){
                    return view('admin.partials.action',compact('row','actionUrl'));
                    })                 
                    ->addColumn('status', function($row){
                    return view('admin.partials.status',compact('row'));
                    })
                    ->setRowId('id')
                    ->rawColumns(['status','action'])
                    ->make(true);
        }   
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
        // $messages = $this->messages;
        // $rules = array_merge($rules,['code' => 'required|unique:users,code|max:30','email' => 'required|unique:users,email|email']);
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
        // $rules = array_merge($rules,['code' => 'required|unique:users,code,'.$company->id.'||max:30','email' => 'nullable|unique:users,email,'.$company->id.'|email']);
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            $response['result'] = 'validation-error';
            $response['messages'] = $validator->errors()->toArray();
            return response()->json($response);
        }
        // $date = \Carbon\Carbon::createFromFormat('M d, Y',$request->only('dob')['dob'])->format('Y-m-d');
        // $data = array_merge(['dob'=>$date],array_merge($request->except('dob')));
        $company->update($request->except('_token'));   
        if($company)
            $response['result'] = 'success';
        else
            $response['result'] = 'failure';

        return response()->json($response);

    }

    /**
     * Import students. 
    */
    public function import(Request $request)
    {
        ini_set('max_execution_time', '-1');
        ini_set('memory_limit', -1);
        $path1 = $request->file->store('temp');
        $path = storage_path('app').'/'.$path1;
        
        $import = new Students();
        $import->import($path);

        if(!empty($import->skippedRows)){
            $response = $this->exportFile($import);
        }else{
            $response['result'] = 'success';
        }
        return response()->json($response);
    }

    /**
     * export error sheet. 
     * @param  [type] $import [description]
     * @return [type]         [description]
     */
    public function exportFile($import)
    {
        $export = new \App\Exports\Students($import->skippedRows);
        $filename = 'Import-Errors-'.time().'.xlsx';
        $filePath = 'uploads/Student';
        Excel::store($export, $filePath.'/'.$filename,'public_uploads'); 
        $file =asset($filePath.'/'.$filename);
        $response['result'] = 'failure'; 
        $response ['link'] = $file;
        return $response; 
    }


}
