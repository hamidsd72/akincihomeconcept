<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Factor extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function orders()
    {
        return $this->hasMany('App\Models\Basket', 'factor_id','id');
    }
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id','user_id');
    }
    public function address_t()
    {
        return $this->hasOne('App\Models\Address', 'id','address_id');
    }
    public function states()
    {
        return $this->hasOne('App\Models\ProvinceCity', 'id','state');
    }

    public function citys()
    {
        return $this->hasOne('App\Models\ProvinceCity', 'id','city');
    }
    public function gateway()
    {
        return $this->hasMany('App\Models\Verify', 'factor_id','id')->where('status',1);
    }

    public static function sendType($type)
    {
        switch ($type){
            case 1:
                return "پیک تهران";
                break;
            default:
                return "ücretsiz teslimat";
                break;
        }
    }
}
