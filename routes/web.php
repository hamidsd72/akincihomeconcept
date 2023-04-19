<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\iyzipay\src\Iyzipay\Request\RetrieveInstallmentInfoRequest;
use App\iyzipay\IyzipayBootstrap;
use App\iyzipay\src\samples\config;
use App\Models\Photo;
use App\Models\Optimizer;
use App\Models\Product;
use App\Models\PageInfo;
use App\Models\Image;
//use Intervention\Image\ImageManagerStatic as Image;

Route::get('/fastLog', function ($id=1) {
    Auth::loginUsingId($id);
    return redirect('panel');
});

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
//
Route::get('/verify', [HomeController::class, 'verify'])->name('verify');
Route::any('/payment_callback', [HomeController::class, 'payment_callback'])->name('payment_callback');
Route::get('/test_code', function () {
    $items=Product::where('home_page',1)->get();
  
dd('ok');
});
Route::get('ggg',function (){

    $imgs=Image::all();
    foreach ($imgs as $item)
    {
        if(is_file($item->path))
        {

        }
        else
        {
            $item->delete();
        }
    }
    dd(1);
//    $img = Image::make('source/assets/img/y/1.png');
//    $img->resize(40, 60);

//dd("ok");
// ارتفاع اتومات
//    $img->resize(20, null, function ($constraint) {
//        $constraint->aspectRatio();
//    });
//    $img->save('source/assets/img/y/2.png');

// عرض اتومات
//    $img->resize(null, 200, function ($constraint) {
//        $constraint->aspectRatio();
//    });
//    $items=Product::all();
    $item=PageInfo::first();
    Optimizer::saveAs($item->pic1);
    Optimizer::saveAs($item->pic2);
    Optimizer::saveAs($item->pic3);
    Optimizer::saveAs($item->pic4);
//    foreach ($items as $item)
//    {
//        Optimizer::saveAs($item->thumbnail);
//        Optimizer::saveAs($item->pic_hover);
//        if($item->photoLarge)
//        {
//            Optimizer::saveAs($item->photoLarge->path);
//        }
//        if($item->photoSmall)
//        {
//            Optimizer::saveAs($item->photoSmall->path);
//        }
//    }
    dd('ok');
});


Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
});