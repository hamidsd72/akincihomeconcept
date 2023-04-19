<?php
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\Front\BlogController;
use App\Http\Controllers\Front\FavoriteController;
use App\Http\Controllers\Front\BasketController;
use App\Http\Controllers\Front\CitColtroller;
use App\Http\Controllers\Front\IyzicoController;
use App\Http\Controllers\Front\PayentController;
Route::get('unzip', [HomeController::class,'unzip']);
Route::get('resize', [HomeController::class,'resize']);
Route::get('resize1', [HomeController::class,'resize1']);

Route::get('/dash',function (){
    return view('dashbord.index');
});
Route::get('/hakkımızda',function (){
    return view('front.page.page1');
})->name('hakkımızda');
Route::get('/iade_ve_değişim',function (){
    return view('front.page.page2');
})->name('iade_ve_değişim');
Route::get('/kişisel_veriler_politikası',function (){
    return view('front.page.page3');
})->name('kişisel_veriler_politikası');
Route::get('/satış_sözleşmesi',function (){
    return view('front.page.page4');
})->name('satış_sözleşmesi');
Route::get('/eee', [HomeController::class, 'eee'])->name('eee');

Route::get('/',[HomeController::class,'index'])->name('index');
Route::get('/city_ajax_js/{type}/{id}',[HomeController::class,'city_ajax_js']);
Route::get('/cit',[CitColtroller::class,'cit'])->name('cit');
//search
Route::get('search', [HomeController::class,'search'])->name('search');
//city ajax
Route::get('city-ajax-new/{id}', [HomeController::class,'city_ajax'])->name('city.ajax');
//auth
//Route::get('login', [AuthController::class,'auth'])->name('auth')->middleware('guest');
Route::post('custom-login', [App\Http\Controllers\Front\AuthController::class,'custom_login'])->name('custom-login')->middleware('guest');
//register post
Route::post('register_1', [AuthController::class,'register_1'])->name('register_1')->middleware('guest');
//active code
Route::get('verify-code', [AuthController::class,'verify_code'])->name('verify.code')->middleware('guest');
Route::get('verify-code-retry', [AuthController::class,'verify_code_retry'])->name('verify.code.retry')->middleware('guest');
//verify code post
Route::post('register_2', [AuthController::class,'register_2'])->name('register_2')->middleware('guest');
//password_resset
Route::get('password-reset-mobile', 'AuthController@password_get_1')->name('password_1')->middleware('guest');
Route::post('password-reset-mobile-post', 'AuthController@password_post_1')->name('password.post_1')->middleware('guest');
Route::get('password-reset-verify-code', 'AuthController@password_get_2')->name('password_2')->middleware('guest');
Route::post('password-reset-verify-code-post', 'AuthController@password_post_2')->name('password.post_2')->middleware('guest');
Route::get('password-reset-verify-code-post-retry', 'AuthController@password_post_retry')->name('password.post_retry')->middleware('guest');
Route::get('password-reset-new-password', 'AuthController@password_get_3')->name('password_3')->middleware('guest');
Route::post('password-reset-new-password-post', 'AuthController@password_post_3')->name('password.post_3')->middleware('guest');
//product
Route::get('products-vip/{slug}', [ProductController::class,'products_vip'])->name('products.vip');
Route::get('products-type/{type}', [ProductController::class,'products_type'])->name('products.type');
Route::get('category/{slug}', [ProductController::class,'category'])->name('category');
Route::get('product-filter-category/{slug?}', [ProductController::class,'category_filter'])->name('product.filter.category');
Route::get('set_order_cat', [ProductController::class,'set_order_cat'])->name('set_order_cat');
Route::get('products/{slug}', [ProductController::class,'products'])->name('products');
Route::get('product/{slug}', [ProductController::class,'show1'])->name('product.show');
Route::get('products-filter/{slug}', [ProductController::class,'filter'])->name('products.filter');
Route::get('product/{slug}/{model_id}', [ProductController::class,'product'])->name('product');
Route::post('product-comment/{id}', [ProductController::class,'comment'])->name('product.comment');

//favorite
Route::get('favorites', [FavoriteController::class,'favorites'])->name('favorites.list');
Route::get('favorite-store/{id}/{model}', [FavoriteController::class,'favorite_store'])->name('favorites.store');
Route::get('favorite-destroy/{id}', [FavoriteController::class,'favorite_destroy'])->name('favorites.destroy');
//blog
Route::get('blogs', [BlogController::class,'blogs'])->name('blogs');
Route::get('blog/{slug}', [BlogController::class,'blog'])->name('blog');
Route::post('blog-post/{id}', [BlogController::class,'comment'])->name('blog.comment');
//page default
Route::get('page/{slug}', [HomeController::class,'page'])->name('page');
//about us
Route::get('about-us', [HomeController::class,'about'])->name('about.us');
//contact us
Route::get('contact-us', [HomeController::class,'contact'])->name('contact.us');
Route::post('contact-us-post', [HomeController::class,'contact_post'])->name('contact.us.post');
//basket
Route::get('basket-level-1', [BasketController::class,'level_1'])->name('level_1');
Route::get('add-basket/{p_id}/{m_id}', [BasketController::class,'add_basket'])->name('add.basket');
Route::get('del-basket/{id}/{p_id}', [BasketController::class,'del_basket'])->name('del.basket');
Route::get('update-basket/{product_id}/{id}/{num}', [BasketController::class,'update_basket'])->name('update.basket');
Route::get('basket-level-2', [BasketController::class,'level_2'])->name('level_2');
Route::post('basket-level-2/address', [BasketController::class,'address_set'])->name('type.address.set');
Route::get('basket-level-2/address/delete/{id}', [BasketController::class,'address_del'])->name('type.address.del');
Route::post('type_send', [BasketController::class,'type_send'])->name('type.send.basket');
Route::get('basket-level-3/{order_code}', [BasketController::class,'level_3'])->name('level_3');
Route::post('set_address', [BasketController::class,'set_address'])->name('set_address');
Route::get('off_checked/{off_code}/{total}', [BasketController::class,'off_code_check'])->name('off.code.check.basket');
Route::post('end_basket/{order_code}', [BasketController::class,'end_basket'])->name('end.basket');

//iyzico
Route::get('iyzico-pay/{id}', [IyzicoController::class,'pay'])->name('iyzico.pay');
Route::post('iyzico-verify', [IyzicoController::class,'verify'])->name('iyzico.verify');
//payent
Route::get('payent-pay/{id}', [PayentController::class,'pay'])->name('payent.pay');
Route::post('payent-verify/{id}', [PayentController::class,'verify'])->name('payent.verify');
//mellat
Route::get('mellat-pay/{id}', 'MellatController@pay')->name('mellat.pay');
Route::any('mellat-verify', 'MellatController@verify')->name('mellat.verify');
//parsian
Route::get('parsian-pay/{id}', 'ParsianController@pay')->name('parsian.pay');
Route::any('parsian-verify', 'ParsianController@verify')->name('parsian.verify');
//zarin pal
Route::any('zarinpal-pay/{id}', 'ZarinpalController@pay')->name('zarinpal.pay');
Route::any('zarinpal-verify', 'ZarinpalController@verify')->name('zarinpal.verify');