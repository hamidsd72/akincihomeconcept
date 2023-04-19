<?php

use App\Http\Controllers\Panel\PanelController;
use App\Http\Controllers\Panel\ProductController;
use App\Http\Controllers\Panel\SliderController;
use App\Http\Controllers\Panel\CategoryController;
use App\Http\Controllers\Panel\BrandController;
use App\Http\Controllers\Panel\InventoryController;
use App\Http\Controllers\Panel\BannerController;
use App\Http\Controllers\Panel\ArticleController;
use App\Http\Controllers\Panel\FooterController;
use App\Http\Controllers\Panel\AboutController;
use App\Http\Controllers\Panel\InfoContactController;
use App\Http\Controllers\Panel\CommentController;
use App\Http\Controllers\Panel\ContactController;
use App\Http\Controllers\Panel\MetaController;
use App\Http\Controllers\Panel\UploadController;
use App\Http\Controllers\Panel\VisitlogController;
use App\Http\Controllers\Panel\SettingController;
use App\Http\Controllers\Panel\BasketController;
use App\Http\Controllers\Panel\ModelController;
use App\Http\Controllers\Panel\ProjectsController;
use App\Http\Controllers\Panel\OrderController;
use App\Http\Controllers\Panel\ProfileController;
use App\Http\Controllers\Panel\AddressController;
use App\Http\Controllers\Panel\DraftController;
use App\Http\Controllers\Panel\ProductVipController;
use App\Http\Controllers\Panel\PageInfoController;
use App\Http\Controllers\Panel\Auth\RegisterController;

// index
Route::get('/', [PanelController::class, 'index'])->name('index');
Route::get('city_ajax', [PanelController::class, 'city_ajax'])->name('city_ajax');
Route::get('/del', [ProductController::class, 'deleteAll'])->name('asdasd');
Route::get('invent', 'PanelController@invent')->name('invent-listt');
Route::get('invent-destroy/{invent}', 'PanelController@destroy')->name('invent-destroy');


Route::get('status/{id}', 'PanelController@status')->name('status');


// Club Excels
Route::get('club-award-excel', function () {
    return Excel::download(new AwardsExport, 'factorsFromFirst.xlsx');
})->name('club-award-excel');
Route::get('club-users-excel', function () {
    return Excel::download(new ClubUsersExport, 'ClubUsersFromFirst.xlsx');
})->name('club-users-excel');
Route::get('club-ban-users-excel', function () {
    return Excel::download(new ClubBanUsersExport, 'ClubBanUsersFromFirst.xlsx');
})->name('club-ban-users-excel');
Route::get('club-codes-excel', function () {
    return Excel::download(new ClubCodesExport, 'ClubCodesFromFirst.xlsx');
})->name('club-codes-excel');
Route::get('club-baskets-excel', function () {
    return Excel::download(new BasketsExport, 'ClubBasketsFromFirst.xlsx');
})->name('club-baskets-excel');

//type
Route::get('type-user', 'Club\TypeController@index')->name('admin-type-list');
Route::post('type-user/update', 'Club\TypeController@update')->name('admin-type-update');


// user black

Route::get('club-black-user', 'Club\UserController@index')->name('admin-user-black');


// user ban

Route::get('club-ban-user', 'Club\UserController@ban')->name('admin-user-ban');

Route::get('club-ban-exit/{id}', 'Club\UserController@exitBan')->name('admin-club-ban-exit');


// basket club

Route::get('/basket/club', 'Club\basketClubController@index')->name('basket-club-page-list');

Route::get('/basket/club/one/{factor}', 'Club\basketClubController@successone')->name('basket-club-success-one');

Route::get('/basket/club/two/{factor}', 'Club\basketClubController@successtwo')->name('basket-club-success-two');

Route::get('/basket/club/three/{factor}', 'Club\basketClubController@successthree')->name('basket-club-success-three');

Route::get('/basket/club/four/{factor}', 'Club\basketClubController@successfour')->name('basket-club-success-four');

Route::get('/basket/club/delete/{factor}/{user_id}', 'Club\basketClubController@destroy')->name('basket-club-delete');
Route::post('export-excel-basket', [BasketController::class, 'excel'])->name('export-excel-basket');


// message

Route::get('club-message-list', 'Club\MessageController@index')->name('admin-user-message');

Route::get('club-message-create', 'Club\MessageController@create')->name('admin-club-message-create');

Route::post('club-message-store', 'Club\MessageController@store')->name('admin-club-message-store');

Route::post('club-message-edit', 'Club\MessageController@edit')->name('admin-club-message-edit');

Route::post('club-message-destroy/{id}', 'Club\MessageController@destroy')->name('admin-club-message-destroy');


// user wait

Route::get('club-wait-list', 'Club\WaitController@index')->name('admin-wait-message');

Route::get('club-wait-user/{id}', 'Club\WaitController@active')->name('admin-wait-active');

Route::post('club-wait-delete/{id}', 'Club\WaitController@active')->name('admin-wait-delete');


// seo

Route::get('meta-create', [MetaController::class, 'create'])->name('meta-create');
Route::put('meta-store', [MetaController::class, 'store'])->name('meta-store');
Route::get('meta-list', [MetaController::class, 'index'])->name('meta-list');
Route::get('meta-edit/{id}', [MetaController::class, 'edit'])->name('meta-edit');
Route::patch('meta-update/{id}', [MetaController::class, 'update'])->name('meta-update');
Route::delete('meta-destroy/{id}', [MetaController::class, 'destroy'])->name('meta-destroy');
Route::post('meta-sort', [MetaController::class, 'sort_item'])->name('meta-sort');


Route::get('excel/index', function () {
    $code = \App\ClubCode::orderBy('status', 'desc')->paginate(20);
    return view('panel.excel.index', compact('code'));
})->name('excel-index');

Route::post('excel/insert', 'HomeController@excel')->name('excel');
Route::get('code/search', 'HomeController@serachCode')->name('search-code');

// index club

Route::get('/index/club', 'Club\indexController@index')->name('index-club-page-list');

Route::post('/index/club/update', 'Club\indexController@update')->name('index-club-success-one');


//user

Route::get('club-black-user-exit/{id}', 'Club\UserController@exits')->name('admin-club-user-exit');

Route::get('club-black-user-delete/{id}', 'Club\UserController@delete')->name('admin-club-user-delete');


Route::get('site/language', 'LanguageController@index')->name('site.language');
Route::get('language-create', 'LanguageController@create')->name('language.create');
Route::post('language-store', 'LanguageController@store')->name('language.store');
Route::get('language-edit/{id}', 'LanguageController@edit')->name('language.edit');
Route::patch('language-update/{id}', 'LanguageController@update')->name('language.update');

Route::delete('language-delete/{id}', 'LanguageController@destroy')->name('language.destroy');
// off
Route::get('off-create', 'OffController@create')->name('off-create');
Route::put('off-store', 'OffController@store')->name('off-store');
Route::get('off-list', 'OffController@index')->name('off-list');
Route::delete('off-destroy/{id}', 'OffController@destroy')->name('off-destroy');

//product vip
Route::get('product-vip-list', [ProductVipController::class,'index'])->name('product-vip-list');
Route::get('product-vip-search', [ProductVipController::class,'search'])->name('product-vip-search');
Route::post('product-vip-update/{id}', [ProductVipController::class,'update'])->name('product-vip-update');
Route::post('slider-vip-update', [ProductVipController::class,'slider_update'])->name('slider-vip-update');

//inventory
Route::get('inventory-list', [InventoryController::class, 'index'])->name('inventory-list');
Route::get('inventory-archive/{id}/{type}', [InventoryController::class, 'archive'])->name('inventory-archive');
Route::get('inventory-archive-list', [InventoryController::class, 'archive_list'])->name('inventory-archive-list');
Route::get('inventory-create/{id}', [InventoryController::class, 'create'])->name('inventory-create');
Route::put('inventory-store/{id}', [InventoryController::class, 'store'])->name('inventory-store');
Route::get('inventory-search', [InventoryController::class, 'search'])->name('inventory-search');
Route::post('inventory-update/{id}', [InventoryController::class, 'update'])->name('inventory-update');
Route::post('model-inventory-update/{id}', [InventoryController::class, 'model_update'])->name('model-inventory-update');
Route::get('export-inventory-excel-panel', [InventoryController::class, 'excel_export'])->name('export-excel-inventory');


// draft
Route::get('draft-list', [DraftController::class,'index'])->name('draft-list');
Route::get('draft-show/{id}', [DraftController::class,'draft_show'])->name('draft-show');
Route::get('draft-confirm/{id}', [DraftController::class,'confirm'])->name('draft-confirm');
Route::post('draft-confirm-all', [DraftController::class,'confirm_all'])->name('draft-confirm-all');
Route::get('export-excel', [DraftController::class,'excel'])->name('export-excel');
Route::get('export-excel-byYear', [DraftController::class,'excelByYear'])->name('export-excel-byYear');
Route::get('export-excel-byMonth', [DraftController::class,'excelByMonth'])->name('export-excel-byMonth');
Route::get('export-excel-byDay', [DraftController::class,'excelByDay'])->name('export-excel-byDay');


// profile
Route::get('profile-show/{id}', [ProfileController::class, 'show'])->name('profile-show');
Route::get('profile-edit/{id}', [ProfileController::class, 'edit'])->name('profile-edit');
Route::get('profile-password-change/{id}', [ProfileController::class, 'password'])->name('profile-password');
Route::get('profile-info/{id}', [ProfileController::class, 'info'])->name('profile-info');
Route::patch('profile-update/{id}', [ProfileController::class, 'update'])->name('profile-update');
Route::patch('profile-password-update/{id}', [ProfileController::class, 'password_update'])->name('profile-password-update');
Route::patch('profile-info-update/{id}', [ProfileController::class, 'info_update'])->name('profile-info-update');


// work
Route::get('work-list', 'WorkController@index')->name('work-list');
Route::delete('work-destroy/{id}', 'WorkController@destroy')->name('work-destroy');
Route::get('work-show/{id}', 'WorkController@show')->name('work-show');


// Basket
Route::get('basket-list', [BasketController::class, 'index'])->name('basket-list');
Route::get('basket-reserv-list', [BasketController::class, 'index_reserv'])->name('basket-reserv-list');
Route::get('draftWait-list', [BasketController::class, 'draftWait'])->name('draftWait-list');
Route::get('send-list', [BasketController::class, 'sendFactor'])->name('send-list');
Route::get('give-list', [BasketController::class, 'giveFactor'])->name('give-factor');
Route::get('cancel-list', [BasketController::class, 'cancelFactors'])->name('factor-cancel');
Route::get('factor-list', [BasketController::class, 'allFactor'])->name('factor-all');
Route::get('backPay-list', [BasketController::class, 'backPay'])->name('factor-backPay');
Route::post('factor-post-import', [BasketController::class, 'postImport'])->name('postImport');
Route::post('factor-delivery/{id}', [BasketController::class, 'factor_delivery'])->name('factor-delivery');
Route::get('factor-search-list', [BasketController::class, 'search'])->name('factor-all-search');
Route::post('factor-export-list', [BasketController::class, 'export_date'])->name('factor-all-export');
//    Route::get('no_pay-list', 'BasketController@no_pay')->name('factor-no_pay');


// Basket
Route::get('basket-confirm/{id}', [BasketController::class, 'confirm'])->name('basket-confirm');
Route::post('basket-confirm-all', [BasketController::class, 'confirm_all'])->name('basket-confirm-all');
Route::get('basket-okay/{id}', [BasketController::class, 'okay'])->name('basket-okay');
Route::get('basket-all', [BasketController::class, 'all'])->name('basket-all');
Route::delete('basket-destroy/{id}', [BasketController::class, 'destroy'])->name('basket-destroy');
Route::get('factor-viwe/{order_code}', [BasketController::class, 'factor_show'])->name('factor-viwe');

Route::get('factor-print/{order_code}', [BasketController::class, 'factor_print'])->name('factor-print');
Route::post('factor-print-all', [BasketController::class, 'factor_print_all'])->name('factor-print-all');
Route::get('basket-return/{id}', [BasketController::class, 'basket_return'])->name('basket-return');
Route::get('basket-re_run/{id}', [BasketController::class, 'basket_re_run'])->name('basket-re_run');
Route::get('user-info/{id}', [BasketController::class, 'user_info'])->name('user-info');
Route::get('export-excel-basket', [BasketController::class, 'excel'])->name('export-excel-basket');


// users
Route::get('user-create', 'UserController@create')->name('user-create');
Route::put('user-store', 'UserController@store')->name('user-store');
Route::get('user-list', 'UserController@index')->name('user-list');
Route::get('user-show/{id}', 'UserController@show')->name('user-show');
Route::get('user-edit/{id}', 'UserController@edit')->name('user-edit');
Route::get('user-search', 'UserController@search')->name('user-search');
Route::patch('user-update/{id}', 'UserController@update')->name('user-update');
Route::get('export-excel-user', 'UserController@excel')->name('export-excel-user');

// address
Route::get('address-create', [AddressController::class, 'create'])->name('address-create');
Route::put('address-store', [AddressController::class, 'store'])->name('address-store');
Route::get('address-list', [AddressController::class, 'index'])->name('address-list');
Route::get('address-show/{id}', [AddressController::class, 'show'])->name('address-show');
Route::get('address-edit/{id}', [AddressController::class, 'edit'])->name('address-edit');
Route::get('address-defulte/{id}', [AddressController::class, 'defulte'])->name('address-defulte');
Route::get('address-search', [AddressController::class, 'search'])->name('address-search');
Route::patch('address-update/{id}', [AddressController::class, 'update'])->name('address-update');
Route::delete('address-destroy/{id}', [AddressController::class, 'destroy'])->name('address-destroy');

// provider
Route::get('provider-create', 'ProviderController@create')->name('provider-create');
Route::put('provider-store', 'ProviderController@store')->name('provider-store');
Route::get('provider-list', 'ProviderController@index')->name('provider-list');
Route::get('provider-show/{id}', 'ProviderController@show')->name('provider-show');
Route::get('provider-edit/{id}', 'ProviderController@edit')->name('provider-edit');
Route::patch('provider-update/{id}', 'ProviderController@update')->name('provider-update');

// upload
Route::get('upload-create', [UploadController::class, 'create'])->name('upload-create');
Route::put('upload-store', [UploadController::class, 'store'])->name('upload-store');
Route::get('upload-list', [UploadController::class, 'index'])->name('upload-list');
Route::delete('upload-destroy/{id}', [UploadController::class, 'destroy'])->name('upload-destroy');

// word
Route::get('word-create', 'WordController@create')->name('word-create');
Route::put('word-store', 'WordController@store')->name('word-store');
Route::get('word-list', 'WordController@index')->name('word-list');
Route::delete('word-destroy/{id}', 'WordController@destroy')->name('word-destroy');

// brand
Route::get('brand-create', [BrandController::class, 'create'])->name('brand-create');
Route::put('brand-store', [BrandController::class, 'store'])->name('brand-store');
Route::get('brand-list', [BrandController::class, 'index'])->name('brand-list');
Route::get('brand-edit/{id}', [BrandController::class, 'edit'])->name('brand-edit');
Route::patch('brand-update/{id}', [BrandController::class, 'update'])->name('brand-update');
Route::delete('brand-destroy/{id}', [BrandController::class, 'destroy'])->name('brand-destroy');
Route::post('brand-list', [BrandController::class, 'search'])->name('brand-search');
Route::post('price_edit_brand/{id}', [BrandController::class, 'price_edit_brand'])->name('price_edit_brand');


// banner
Route::get('banner-create', [BannerController::class, 'create'])->name('banner-create');
Route::put('banner-store', [BannerController::class, 'store'])->name('banner-store');
Route::get('banner-list', [BannerController::class, 'index'])->name('banner-list');
Route::get('banner-edit/{id}', [BannerController::class, 'edit'])->name('banner-edit');
Route::patch('banner-update/{id}', [BannerController::class, 'update'])->name('banner-update');
Route::delete('banner-destroy/{id}', [BannerController::class, 'destroy'])->name('banner-destroy');
Route::post('banner-list', [BannerController::class, 'search'])->name('banner-search');

// type
Route::get('type-create', 'TypeController@create')->name('type-create');
Route::put('type-store', 'TypeController@store')->name('type-store');
Route::get('type-list', 'TypeController@index')->name('type-list');
Route::get('type-edit/{id}', 'TypeController@edit')->name('type-edit');
Route::patch('type-update/{id}', 'TypeController@update')->name('type-update');
Route::delete('type-destroy/{id}', 'TypeController@destroy')->name('type-destroy');

Route::get('typeAjax/{id}', 'TypeController@typeAjax')->name('typeAjax');

// contact
Route::get('contact-list', [ContactController::class, 'index'])->name('contact-list');
Route::delete('contact-destroy/{id}', [ContactController::class, 'destroy'])->name('contact-destroy');

// slider
Route::get('slider-create', [SliderController::class, 'create'])->name('slider-create');
Route::put('slider-store', [SliderController::class, 'store'])->name('slider-store');
Route::get('slider-list', [SliderController::class, 'index'])->name('slider-list');
Route::get('slider-edit/{id}', [SliderController::class, 'edit'])->name('slider-edit');
Route::patch('slider-update/{id}', [SliderController::class, 'update'])->name('slider-update');
Route::delete('slider-destroy/{id}', [SliderController::class, 'destroy'])->name('slider-destroy');


// resalat
Route::get('resalat-create/{id}', 'ResalatController@create')->name('resalat-create');
Route::post('resalat-store/{id}', 'ResalatController@store')->name('resalat-store');
Route::get('resalat-list', 'ResalatController@index')->name('resalat-list');
Route::delete('resalat-destroy/{id}', 'ResalatController@destroy')->name('resalat-destroy');

// Ad
Route::get('ad-create', 'AdController@create')->name('ad-create');
Route::put('ad-store', 'AdController@store')->name('ad-store');
Route::get('ad-list', 'AdController@index')->name('ad-list');
Route::delete('ad-destroy/{id}', 'AdController@destroy')->name('ad-destroy');


// categories
Route::get('category-create', [CategoryController::class, 'create'])->name('category-create');
Route::put('category-store', [CategoryController::class, 'store'])->name('category-store');
Route::get('category-list', [CategoryController::class, 'index'])->name('category-list');
Route::get('category-edit/{id}', [CategoryController::class, 'edit'])->name('category-edit');
Route::patch('category-update/{id}', [CategoryController::class, 'update'])->name('category-update');
Route::delete('category-destroy/{id}', [CategoryController::class, 'destroy'])->name('category-destroy');
Route::post('category-sort', [CategoryController::class, 'sort_item'])->name('category-sort');


// city
Route::get('city-create', 'CityController@create')->name('city-create');
Route::put('city-store', 'CityController@store')->name('city-store');
Route::get('city-list', 'CityController@index')->name('city-list');
Route::get('city-edit/{id}', 'CityController@edit')->name('city-edit');
Route::patch('city-update/{id}', 'CityController@update')->name('city-update');
Route::delete('city-destroy/{id}', 'CityController@destroy')->name('city-destroy');
Route::post('city-sort', 'CityController@sort_item')->name('city-sort');
Route::post('city-search', 'CityController@search')->name('city-search');
Route::post('city-free/{id}', 'CityController@city_free')->name('city-free-update');


//Product
//Product
Route::post('brandAjax', [ProductController::class, 'brandAjax'])->name('create_ajax');
Route::post('catAjax', [ProductController::class, 'catAjax'])->name('create_cat_ajax');
Route::post('create_compar', [ProductController::class, 'create_compar'])->name('create_compar');
Route::get('product-create', [ProductController::class, 'create'])->name('product-create');
Route::put('product-store', [ProductController::class, 'store'])->name('product-store');
Route::get('product-list', [ProductController::class, 'index'])->name('product-list');
Route::get('product-edit/{id}', [ProductController::class, 'edit'])->name('product-edit');
Route::patch('product-update/{id}', [ProductController::class, 'update'])->name('product-update');
Route::get('product-gallery/{id}', [ProductController::class, 'gallery'])->name('p-product-gallery');
Route::get('product-gallery', [ProductController::class, 'gallery_sort'])->name('p-product-gallery-sort');
Route::get('product-model/{id}', [ProductController::class, 'modelProduct'])->name('product-model');
Route::patch('product-model-store/{id}', [ProductController::class, 'modelStore'])->name('model-store');
Route::post('product-active-show/{id}', [ProductController::class, 'product_show'])->name('product-active-show');
Route::post('product-active-vip/{id}', [ProductController::class, 'product_vip'])->name('product-active-vip');
Route::get('product-status/{id}/{type}', [ProductController::class, 'product_status'])->name('product.status');
Route::post('product-active-price_tel/{id}', [ProductController::class, 'product_price_tel'])->name('product-active-price_tel');
Route::post('product_update_order_point/{id}', [ProductController::class, 'update_order_point'])->name('product-update-order-point');
Route::post('product-update-invent/{id}', [ProductController::class, 'product_update_invent'])->name('product-update-invent');
Route::post('product-update-puser/{id}', [ProductController::class, 'product_update_puser'])->name('product-update-puser');
Route::post('product-update-pvip/{id}', [ProductController::class, 'product_update_pvip'])->name('product-update-pvip');
Route::post('product-update-time/{id}', [ProductController::class, 'product_update_time'])->name('product-update-time');
Route::get('product-del-article/{id}', [ProductController::class, 'del_article'])->name('product-del-article');
Route::get('product-del-video/{id}', [ProductController::class, 'del_video'])->name('product-del-video');
Route::get('photo-del/{id}', [ProductController::class, 'del_photo'])->name('product_del_photo');
Route::get('compar-del/{id}', [ProductController::class, 'del_compar'])->name('product-del_compar');
Route::post('update_all_model/{id}', [ProductController::class, 'update_all_model'])->name('update_all_model');
Route::get('product-search1', [ProductController::class, 'search1'])->name('product-search');
Route::delete('product-destroy/{id}', [ProductController::class, 'destroy'])->name('product-destroy');
Route::get('remove-gallery/{id}', [ProductController::class, 'remove_gallery'])->name('remove-gallery');
Route::get('product-type-del/{id}', [ProductController::class, 'type_del'])->name('product-type-del');
Route::get('product-attr-del/{id}', [ProductController::class, 'attr_del'])->name('product-attr-del');
Route::get('product-comp-del/{id}', [ProductController::class, 'comp_del'])->name('product-comp-del');
Route::get('export-excel-product', [ProductController::class, 'export_excel'])->name('export-excel-product');
Route::post('import-excel-product', [ProductController::class, 'import_excel'])->name('import-excel-product');
Route::post('add_comparss_to', [ProductController::class, 'add_comparss_to'])->name('add_comparss_to');
//model
Route::get('model-create/{id}', [ModelController::class, 'create'])->name('model-create');
Route::put('model-store/{id}', [ModelController::class, 'store'])->name('model-store');
Route::get('model-list/{id}', [ModelController::class, 'index'])->name('model-list');
Route::get('model-edit/{id}', [ModelController::class, 'edit'])->name('model-edit');
Route::patch('model-update/{id}', [ModelController::class, 'update'])->name('model-update');
Route::delete('model-destroy/{id}', [ModelController::class, 'destroy'])->name('model-destroy');

Route::post('model-active-default/{id}', [ModelController::class, 'model_default'])->name('model-active-default');
Route::post('model-update-pstore/{id}', [ModelController::class, 'model_update_pstore'])->name('model-update-pstore');
Route::post('model-update-invent/{id}', [ModelController::class, 'model_update_invent'])->name('model-update-invent');
Route::post('model-update-puser/{id}', [ModelController::class, 'model_update_puser'])->name('model-update-puser');
Route::post('model-update-pvip/{id}', [ModelController::class, 'model_update_pvip'])->name('model-update-pvip');
Route::post('update_price_tel/{id}', [ModelController::class, 'update_price_tel'])->name('update_price_tel');


//worked
Route::get('worked-create', 'WorkedController@create')->name('worked-create');
Route::put('worked-store', 'WorkedController@store')->name('worked-store');
Route::get('worked-list', 'WorkedController@index')->name('worked-list');
Route::get('worked-edit/{id}', 'WorkedController@edit')->name('worked-edit');
Route::patch('worked-update/{id}', 'WorkedController@update')->name('worked-update');
Route::delete('worked-destroy/{id}', 'WorkedController@destroy')->name('worked-destroy');

//about
Route::get('About', [AboutController::class, 'index'])->name('admin-about');
Route::get('About-create', [AboutController::class, 'create'])->name('about-create');
Route::post('About-create', [AboutController::class, 'store'])->name('about-store');
Route::get('About-edit/{id}', [AboutController::class, 'edit'])->name('about-edit');
Route::post('About-edit/{id}', [AboutController::class, 'edit1'])->name('about-edit1');
Route::delete('About-destroy/{id}', [AboutController::class, 'destroy'])->name('about-destroy');
//page info
Route::get('page_info', [PageInfoController::class, 'index'])->name('admin-page_info');
Route::get('page_info-create', [PageInfoController::class, 'create'])->name('page_info-create');
Route::post('page_info-create', [PageInfoController::class, 'store'])->name('page_info-store');
Route::get('page_info-edit/{id}', [PageInfoController::class, 'edit'])->name('page_info-edit');
Route::post('page_info-edit/{id}', [PageInfoController::class, 'edit1'])->name('page_info-edit1');
Route::delete('page_info-destroy/{id}', [AboutController::class, 'destroy'])->name('page_info-destroy');


//infocontact
Route::get('infocontact', [InfoContactController::class, 'index'])->name('admin-infocontact');
Route::get('infocontact-create', [InfoContactController::class, 'create'])->name('infocontact-create');
Route::post('infocontact-create', [InfoContactController::class, 'store'])->name('infocontact-store');
Route::get('infocontact-edit/{id}', [InfoContactController::class, 'edit'])->name('infocontact-edit');
Route::post('infocontact-edit/{id}', [InfoContactController::class, 'edit1'])->name('infocontact-edit1');
Route::delete('infocontact-destroy/{id}', [InfoContactController::class, 'destroy'])->name('infocontact-destroy');

// categories
Route::get('gallery-category-create', 'GalleryCategoryController@create')->name('gallery-category-create');
Route::put('gallery-category-store', 'GalleryCategoryController@store')->name('gallery-category-store');
Route::get('gallery-category-list', 'GalleryCategoryController@index')->name('gallery-category-list');
Route::get('gallery-category-edit/{id}', 'GalleryCategoryController@edit')->name('gallery-category-edit');
Route::patch('gallery-category-update/{id}', 'GalleryCategoryController@update')->name('gallery-category-update');
Route::delete('gallery-category-destroy/{id}', 'GalleryCategoryController@destroy')->name('gallery-category-destroy');
Route::post('gallery-category-sort', 'GalleryCategoryController@sort_item')->name('gallery-category-sort');

//Gallery
Route::get('gallery-create', 'GalleryController@create')->name('gallery-create');
Route::put('gallery-store', 'GalleryController@store')->name('gallery-store');
Route::get('gallery-list', 'GalleryController@index')->name('gallery-list');
Route::get('gallery-edit/{id}', 'GalleryController@edit')->name('gallery-edit');
Route::patch('gallery-update/{id}', 'GalleryController@update')->name('gallery-update');
Route::delete('gallery-destroy/{id}', 'GalleryController@destroy')->name('gallery-destroy');


// video_cat
Route::get('video-cat-create', 'VideocatController@create')->name('video-cat-create');
Route::put('video-cat-store', 'VideocatController@store')->name('video-cat-store');
Route::get('video-cat-list', 'VideocatController@index')->name('video-cat-list');
Route::get('video-cat-edit/{id}', 'VideocatController@edit')->name('video-cat-edit');
Route::patch('video-cat-update/{id}', 'VideocatController@update')->name('video-cat-update');
Route::delete('video-cat-destroy/{id}', 'VideocatController@destroy')->name('video-cat-destroy');
Route::post('video-cat-sort', 'VideocatController@sort_item')->name('video-cat-sort');

//video
Route::get('video-create', 'VideoController@create')->name('video-create');
Route::put('video-store', 'VideoController@store')->name('video-store');
Route::get('video-list', 'VideoController@index')->name('video-list');
Route::get('video-edit/{id}', 'VideoController@edit')->name('video-edit');
Route::patch('video-update/{id}', 'VideoController@update')->name('video-update');
Route::delete('video-destroy/{id}', 'VideoController@destroy')->name('video-destroy');


// attribute
Route::get('attribute-create', 'AttributeController@create')->name('attribute-create');
Route::put('attribute-store', 'AttributeController@store')->name('attribute-store');
Route::get('attribute-list', 'AttributeController@index')->name('attribute-list');
Route::get('attribute-edit/{id}', 'AttributeController@edit')->name('attribute-edit');
Route::patch('attribute-update/{id}', 'AttributeController@update')->name('attribute-update');
Route::delete('attribute-destroy/{id}', 'AttributeController@destroy')->name('attribute-destroy');

// comparison
Route::get('comparison-create', 'ComparisonController@create')->name('comparison-create');
Route::put('comparison-store', 'ComparisonController@store')->name('comparison-store');
Route::get('comparison-list', 'ComparisonController@index')->name('comparison-list');
Route::get('comparison-edit/{id}', 'ComparisonController@edit')->name('comparison-edit');
Route::patch('comparison-update/{id}', 'ComparisonController@update')->name('comparison-update');
Route::delete('comparison-destroy/{id}', 'ComparisonController@destroy')->name('comparison-destroy');

//article_category
Route::get('article-category-create', 'ArticleCategoryController@create')->name('article-category-create');
Route::put('article-category-store', 'ArticleCategoryController@store')->name('article-category-store');
Route::get('article-category-list', 'ArticleCategoryController@index')->name('article-category-list');
Route::get('article-category-edit/{id}', 'ArticleCategoryController@edit')->name('article-category-edit');
Route::patch('article-category-update/{id}', 'ArticleCategoryController@update')->name('article-category-update');
Route::delete('article-category-destroy/{id}', 'ArticleCategoryController@destroy')->name('article-category-destroy');
Route::post('article-category-sort', 'ArticleCategoryController@sort_item')->name('article-category-sort');
// News Route
Route::get('news-category-create', 'NewsCategoryController@create')->name('news-category-create');
Route::put('news-category-store', 'NewsCategoryController@store')->name('news-category-store');
Route::get('news-category-list', 'NewsCategoryController@index')->name('news-category-list');
Route::get('news-category-edit/{id}', 'NewsCategoryController@edit')->name('news-category-edit');
Route::patch('news-category-update/{id}', 'NewsCategoryController@update')->name('news-category-update');
Route::delete('news-category-destroy/{id}', 'NewsCategoryController@destroy')->name('news-category-destroy');
Route::post('news-category-sort', 'NewsCategoryController@sort_item')->name('news-category-sort');
// journal
Route::get('journal-create', 'JournalController@create')->name('journal-create');
Route::put('journal-store', 'JournalController@store')->name('journal-store');
Route::get('journal-list', 'JournalController@index')->name('journal-list');
Route::get('journal-edit/{id}', 'JournalController@edit')->name('journal-edit');
Route::patch('journal-update/{id}', 'JournalController@update')->name('journal-update');
Route::delete('journal-destroy/{id}', 'JournalController@destroy')->name('journal-destroy');

// news
Route::get('news-create', 'NewsController@create')->name('news-create');
Route::put('news-store', 'NewsController@store')->name('news-store');
Route::get('news-list', 'NewsController@index')->name('news-list');
Route::get('news-edit/{id}', 'NewsController@edit')->name('news-edit');
Route::patch('news-update/{id}', 'NewsController@update')->name('news-update');
Route::delete('news-destroy/{id}', 'NewsController@destroy')->name('news-destroy');


// footer
Route::get('footer-create', [FooterController::class, 'create'])->name('footer-create');
Route::put('footer-store', [FooterController::class, 'store'])->name('footer-store');
Route::get('footer-list', [FooterController::class, 'index'])->name('footer-list');
Route::get('footer-edit/{id}', [FooterController::class, 'edit'])->name('footer-edit');
Route::patch('footer-update/{id}', [FooterController::class, 'update'])->name('footer-update');
Route::delete('footer-destroy/{id}', [FooterController::class, 'destroy'])->name('footer-destroy');


// categories
Route::get('footer-category-create', 'FooterCategoryController@create')->name('footer-category-create');
Route::put('footer-category-store', 'FooterCategoryController@store')->name('footer-category-store');
Route::get('footer-category-list', 'FooterCategoryController@index')->name('footer-category-list');
Route::get('footer-category-edit/{id}', 'FooterCategoryController@edit')->name('footer-category-edit');
Route::patch('footer-category-update/{id}', 'FooterCategoryController@update')->name('footer-category-update');
Route::delete('footer-category-destroy/{id}', 'FooterCategoryController@destroy')->name('footer-category-destroy');
Route::post('footer-category-sort', 'FooterCategoryController@sort_item')->name('footer-category-sort');


// projects
Route::get('projects-create', [ProjectsController::class, 'create'])->name('projects-create');
Route::put('projects-store', [ProjectsController::class, 'store'])->name('projects-store');
Route::get('projects-list', [ProjectsController::class, 'index'])->name('projects-list');
Route::get('projects-edit/{id}', [ProjectsController::class, 'edit'])->name('projects-edit');
Route::patch('projects-update/{id}', [ProjectsController::class, 'update'])->name('projects-update');
Route::delete('projects-destroy/{id}', [ProjectsController::class, 'destroy'])->name('projects-destroy');
Route::get('projects-photo-delete/{id}', [ProjectsController::class, 'destroyPhoto'])->name('projects-photo-delete');


// prize
Route::get('prize-create', 'PrizeController@create')->name('prize-create');
Route::put('prize-store', 'PrizeController@store')->name('prize-store');
Route::get('prize-list', 'PrizeController@index')->name('prize-list');
Route::get('prize-edit/{id}', 'PrizeController@edit')->name('prize-edit');
Route::patch('prize-update/{id}', 'PrizeController@update')->name('prize-update');
Route::delete('prize-destroy/{id}', 'PrizeController@destroy')->name('prize-destroy');

//mk-ads
Route::get('ads-list', 'AdsController@index')->name('ads-list');
Route::get('ads-edit/{id}', 'AdsController@edit')->name('ads-edit');
Route::patch('ads-update/{id}', 'AdsController@update')->name('ads-update');


// comment
Route::get('comment-answer/{id}', [CommentController::class, 'create'])->name('comment-answer');
Route::put('comment-stores', [CommentController::class, 'store'])->name('comment-store');
Route::get('comment-list', [CommentController::class, 'index'])->name('comment-list');
Route::get('comment-edit/{id}', [CommentController::class, 'edit'])->name('comment-edit');
Route::put('comment-update/{id}', [CommentController::class, 'update'])->name('comment-update');
Route::delete('comment-destroy/{id}', [CommentController::class, 'destroy'])->name('comment-destroy');
Route::get('comment-confirm/{id}', [CommentController::class, 'confirm'])->name('comment-confirm');


// question
Route::get('question-list', 'QuestionController@index')->name('question-list');
Route::any('question-confirm/{id}', 'QuestionController@confirm')->name('question-confirm');
Route::get('question-destroy/{id}', 'QuestionController@destroy')->name('question-destroy');


// viewpoint
Route::get('viewpoint-create', 'ViewpointController@create')->name('viewpoint-create');
Route::put('viewpoint-store', 'ViewpointController@store')->name('viewpoint-store');
Route::get('viewpoint-list', 'ViewpointController@index')->name('viewpoint-list');
Route::get('viewpoint-edit/{id}', 'ViewpointController@edit')->name('viewpoint-edit');
Route::patch('viewpoint-update/{id}', 'ViewpointController@update')->name('viewpoint-update');
Route::delete('viewpoint-destroy/{id}', 'ViewpointController@destroy')->name('viewpoint-destroy');

// article
Route::get('article-create', [ArticleController::class, 'create'])->name('article-create');
Route::put('article-store', [ArticleController::class, 'store'])->name('article-store');
Route::get('article-list', [ArticleController::class, 'index'])->name('article-list');
Route::get('article-edit/{id}', [ArticleController::class, 'edit'])->name('article-edit');
Route::patch('article-update/{id}', [ArticleController::class, 'update'])->name('article-update');
Route::delete('article-destroy/{id}', [ArticleController::class, 'destroy'])->name('article-destroy');
// article comment
Route::get('article-comment-reply/{id}', 'ArticleCommentController@create')->name('article-comment-reply');
Route::put('article-comment-reply-store/{id}', 'ArticleCommentController@store')->name('article-comment-reply-store');
Route::get('article-comment-list/{id}', 'ArticleCommentController@index')->name('article-comment-list');
Route::get('article-comment-edit/{id}', 'ArticleCommentController@edit')->name('article-comment-edit');
Route::patch('article-comment-update/{id}', 'ArticleCommentController@update')->name('article-comment-update');
Route::delete('article-comment-destroy/{id}', 'ArticleCommentController@destroy')->name('article-comment-destroy');
Route::get('article-comment-status/{id}', 'ArticleCommentController@status')->name('article-comment-status');

//db_category
Route::get('db-category-list', 'DbCategoryController@index')->name('db-category-list');

// bank
Route::get('bank-create', 'BankController@create')->name('bank-create');
Route::put('bank-store', 'BankController@store')->name('bank-store');
Route::get('bank-list', 'BankController@index')->name('bank-list');
Route::get('bank-edit/{id}', 'BankController@edit')->name('bank-edit');
Route::patch('bank-update/{id}', 'BankController@update')->name('bank-update');
Route::delete('bank-destroy/{id}', 'BankController@destroy')->name('bank-destroy');

// articleattribute
Route::get('article-attribute-create', 'ArticleAttributeController@create')->name('article-attribute-create');
Route::put('article-attribute-store', 'ArticleAttributeController@store')->name('article-attribute-store');
Route::get('article-attribute-list', 'ArticleAttributeController@index')->name('article-attribute-list');
Route::get('article-attribute-edit/{id}', 'ArticleAttributeController@edit')->name('article-attribute-edit');
Route::patch('article-attribute-update/{id}', 'ArticleAttributeController@update')->name('article-attribute-update');
Route::delete('article-attribute-destroy/{id}', 'ArticleAttributeController@destroy')->name('article-attribute-destroy');

// visitlog
Route::get('visitlogs', [VisitlogController::class, 'index'])->name('visitlogs');

// Design
Route::get('design', 'DesignController@index')->name('design');

// settings
Route::get('/settings', [SettingController::class, 'index'])->name('settings-list');
Route::post('/settingsUpdates/{id}', [SettingController::class, 'update'])->name('settingsUpdate');


Route::resource('roles', 'RoleController');
Route::resource('permissions', 'PermissionController');
Route::resource('posts', 'PostController');


//    /dashbird
// index
Route::get('/', [PanelController::class, 'index'])->name('dashboard-index');

// profile

Route::get('order-list', [OrderController::class, 'index'])->name('order-list');

Route::get('factor-show/{order_code}', [BasketController::class, 'factor_show'])->name('dashboard-factor-show');
Route::get('factor-send-reserv/{order_code}', [BasketController::class, 'factor_send_reserv'])->name('dashboard-factor-send-reserv');



Route::get('factor/create', [\App\Http\Controllers\Panel\Basket\BasketController::class, 'create'])->name('dashboard-create-factor');
Route::post('factor/store', [\App\Http\Controllers\Panel\Basket\BasketController::class, 'store'])->name('dashboard-store-factor');


Route::get('dashboard-user-create', [RegisterController::class, 'create'])->name('dashboard-user-create');
Route::post('dashboard-user-store', [RegisterController::class, 'store'])->name('dashboard-user-store');

?>