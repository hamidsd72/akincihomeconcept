<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;

class Product extends Model
{

    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function photoLarge()
    {
        return $this->hasOne('App\Models\Image', 'model_id')->where('type', 'large');
    }

    public function photoSmall()
    {
        return $this->hasOne('App\Models\Image', 'model_id')->where('type', 'small');
    }


    public function models()
    {
        return $this->hasMany('App\Models\Modale', 'product_id', 'id')->where('status',1);
    }
    public function modelss()
    {
        return $this->hasMany('App\Models\Modale', 'product_id', 'id');
    }
    public function default1()
    {
        return $this->hasOne('App\Models\Modale', 'product_id', 'id')->where('default' , 1);
    }

  public function defaults()
  {
    return $this->hasOne('App\Models\Modale', 'product_id', 'id')->where('default' , 1);
  }

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    public static function defult_set ($id)
    {
        $product=Product::find($id);
        $models=Modale::where('product_id',$id)->where('status',1)->sum('inventory');
    }
    public function gallery()
    {
        return $this->hasMany('App\Models\Image', 'model_id')->where('collection','Products')->where('type', 'gallery');
    }
    public static function feature($item)
    {
        $array = [];
        if (count(array_chunk(json_decode($item), 2)) > 0) {
            foreach (array_chunk(json_decode($item), 2) as $val) {
                array_push($array, [$val[0], $val[1]]);
            }
        }

        return $array;
    }
     public static function price_product($item)
    {
      
        $price=$item->price_default;
        $price_vip=$item->vip_default;
        $model=Modale::where('product_id',$item->id)->first();
        if($model)
        {
            $price=$model->price;
            $price_vip=$model->price_vip;
        }

        return [$price,$price_vip];
    }

    public function brand()
    {
        return $this->belongsTo('App\Models\Brand', 'brand_id');
    }


    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($item) {
            $item->gallery()->get()->each(function ($photo) {
                $path = $photo->path;
                File::delete($path);
                $photo->delete();
            });
            if ($item->photoLarge){
                File::delete($item->photoLarge->path);
                $item->photoLarge->delete();
            }
            if ($item->thumbnail){
                File::delete($item->thumbnail);
            }
            if ($item->photoSmall){
                File::delete($item->photoSmall->path);
                $item->photoSmall->delete();
            }
            File::delete($item->flag);
            if ($item->modeles !=null and count($item->modeles)){
                foreach ($item->modeles as $modele){
                    if (count($modele->gallery)){
                        foreach ($modele as $gal){
                            File::delete($gal->path);
                            $gal->delete();
                        }
                    }
                    $modele->delete();

                    if ($modele->photo){
                        File::delete($modele->photo);
                    }


                }
            }

        });
    }

}
