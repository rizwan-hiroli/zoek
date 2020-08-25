<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'firstname','lastname','username','role','gender','dob', 'email', 'password',
    // ];

    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['profile_image_url'];

    public function getProfileImageUrlAttribute(){
        
        $filePath = 'uploads/User/';
        if(isset($this->attributes['profile_image'])){
            $imageName = $this->attributes['profile_image'];
            $directory = asset($filePath.'/'.$this->attributes['profile_image']);
            $imageUrl = view('admin.partials.image',compact('directory','imageName'))->render();
            return $imageUrl;
        }
        return null;
    }

    /**
     * Get the standard associated with the user.
     */
    public function standard()
    {
        return $this->belongsTo('App\Models\Standard','std_id');
    }

    /**
     * Get the division associated with the user.
     */
    public function division()
    {
        return $this->belongsTo('App\Models\Division','div_id');
    }

}
