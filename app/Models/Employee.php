<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
	use SoftDeletes;
	
	protected $fillable = ['first_name','last_name','phone','email','company_id'];   

	public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }

}
