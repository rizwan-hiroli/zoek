<?php

namespace App\Http\Controllers\Admin;

use DB;
use Log;
use View;
use Plupload;
use Exception;
use Hash;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class MasterController extends Controller
{
	
	/**
	 * Inactive and active in listing. 
	 * @param  Request $request [description]
	 * @return [type]           [description]
	*/
	public function changeStatus(Request $request){
		$parameters = array(
		          'id' => $request->id,
		          'model_name' => $request->model_name,
		          'current_status' => $request->current_status,
		      );
		$rules = ['id'=>'required','model_name'=>'required',
                'current_status'=>'required'];
        $validation = Validator::make($parameters,$rules);
        if ($validation->fails()) {
            $response['result'] = "error";
            $response['errors'] = $validation->errors()->toArray();
            return response()->json($response);
        }
        $model = $request->model_name;
        $currentStatus = $request->current_status;
        $model = ($model != 'User') ? "\App\\Models\\" . $model : "\App\\" . $model ;
        $model = $model::withTrashed()->find($request->id);
        
        if($currentStatus){
            $model->delete();
        }else{
            $model->restore();
        }

        $response['status_text'] = ($currentStatus) ? 'Inactive' : 'Active';
        $response['status'] = $model->deleted_at == null ? 1 : 0;
        $response['result'] = "success";

		return response()->json($response);

	}
    
	/**
     * uploading images from pl upload.
     * @param  Request $request [description]
     * @return [type]           [description]
    */
    public function uploadImage(Request $request){

	    $folderName=$request->model_name;
	    $filename=$request->Filename;
    	try{
            $filePath = \Storage::disk('local')->path('public/'.$folderName);
			return Plupload::receive('file', function ($file) use ($filename,$filePath){        
				$file->move($filePath, $filename);
				return ['result'=>'success','message'=>'File uploaded successfully'];
			});	
			
    	}
    	catch(\Exception $exception){
    		return ['result'=>'failure','message'=>'File not uploaded.'];	
    	}
    }

    /**
     * Deleting image while removed by user.
     * @param  Request $request [description]
     * @return [type]           [description]
    */
    public function removeImage(Request $request){

    	try{
	        $folderName=$request->model_name;
	        $fileName = $request->file_name;
	        $file = \Storage::disk('local')->path('public/'.$fileName);
            if(is_file($file))
	            unlink($file);
	        
	        $response['result'] = 'success';
	        return response()->json($response);

    	}catch(\Exception $exception){
    		$response['result'] = 'failure';
	        return response()->json($response);	
    	}
    }

}
