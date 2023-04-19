<?php

namespace App\Http\Controllers\Panel;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\AttributeProductJoin;
use App\Models\Comparison;
use App\Models\ComparisonProductJoin;
use App\Models\Photo;
use App\Models\Image as ImageModel;
use App\Models\Image;
use App\Models\Price;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Modale;
use App\Models\Type;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductExport;
use App\Imports\ProductImport;

//use Intervention\Image\ImageManagerStatic as Image;

class ProductController extends Controller
{
    public function controller_title($type)
    {
        if ($type == 'sum') {
            return 'محصولات';
        } elseif ('single') {
            return 'محصول';
        }
    }

    public function controller_paginate()
    {
        $settings = Setting::select('paginate')->latest()->firstOrFail();
        return $settings->paginate;
    }

    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $products = Product::orderBy('id', 'DESC')->get();
//        foreach ($products as $p){
//         $p->show=0;
//         $p->timestamps=false;
//         $p->update();
//        }
//        dd($products[1]);
//        $products = Product::orderByDesc('id')->paginate($this->controller_paginate());
        return view('panel.product.index', compact('products'), ['title' => $this->controller_title('sum')]);
    }

    public function search(Request $request)
    {

        if ($request->brand) {
            $brands = Brand::where('brand', 'LIKE', '%' . $request->brand . '%')->get();
            $b = array();
            foreach ($brands as $brand) {
                array_push($b, $brand->id);
            }
            $this->f_brand = $b;
        }
        if ($request->category) {
            $categories = Category::where('name', 'LIKE', '%' . $request->category . '%')->get();
            $c = array();
            foreach ($categories as $category) {
                array_push($c, $category->id);
            }
            $this->f_cat = $c;
        }
        $products = Product::where('title', 'LIKE', '%' . $request->product . '%')
            ->where(function ($query) {
                if (count($this->f_brand) > 0) {

                    $query->whereIn('brand_id', $this->f_brand);
                }
                if (count($this->f_cat) > 0) {

                    $query->whereIn('category_id', $this->f_cat);
                }
            })->orderBy('id', 'DESC')->paginate($this->controller_paginate());


        return view('panel.product.search', compact('products'), ['title' => $this->controller_title('sum')]);
    }

    public function create()
    {
        $categories = Category::where('parent_id', null)->get();
        $brands = Brand::with('category')->get()->groupBy('category_id');

        $data = [];

        foreach ($brands as $key => $val) {
            $data[$val[0]->category->name] = [];
            foreach ($val as $value) {

                array_push($data[$value->category->name], [$value->id, $value->brand]);


            }
        }

        $brands = $data;


        return view('panel.product.create', compact('categories', 'brands'), ['title' => $this->controller_title('sum')]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'brand_id' => 'required',
            'category_id' => 'required',
            'title' => 'required|max:191',
            'slug' => 'required|unique:products|max:191',
            'photo_large' => 'required',
            'photo_small' => 'required',
        ]);

        if (!isset($request->model_have)) {
            $this->validate($request, [
                'price_default' => 'required',
                'inventory_default' => 'required',
            ]);
        }
        try {

            $item = Product::create([
                'title' => $request->title,
                'slug' => $request->slug,
                'brand_id' => $request->brand_id,
                'category_id' => $request->category_id,
                'short_text' => $request->short_text,
                'text' => $request->text,
                'home_page' => $request->home_page,
                'feature' => json_encode($request->feature),
                'code' => $request->code,
                'sort' => $request->sort,
                'show' => $request->show,
                'other_category' => json_encode($request->other_category)

            ]);

            if (isset($request->model_have) and $request->model_have == 'on') {

                $item->model_have = 'yes';
            } else {
                $item->model_have = 'no';
                $item->inventory_default = $request->inventory_default;
                $item->price_default = $request->price_default;
                $item->vip_default = $request->vip_default;
            }
            $item->save();

            if ($request->hasFile('photo_large')) {
                $photo = new ImageModel();
                $pic_pacth = 'source/assets/uploads/products/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/';
                $photo->path = file_store($request->photo_large, $pic_pacth, 'photo-');;
                $photo->type = 'large';
                $photo->collection = 'Product';
                $photo->model_id = $item->id;
                $photo->save();
            }

            if ($request->hasFile('photo_small')) {
                $photo = new ImageModel();

                $thumbnail = file_store($request->photo_small, 'source/assets/uploads/products/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-');
                $photo->path = $thumbnail;
                $photo->type = 'small';
                $photo->collection = 'Product';
                $photo->model_id = $item->id;
                $photo->save();
//                $img = Image::make($thumbnail);
//                $img = $img->resize(600, null, function ($constraint) {
//                    $constraint->aspectRatio();
//                });
//                $save_path = $pic_pacth.'resize-' . time() . '.jpg';
//                $img->save($save_path);
                $item->thumbnail = $thumbnail;
                $item->update();

            }
            if ($request->hasFile('pic_hover')) {
                $pic_hover = 'source/assets/uploads/products/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/hover/';
                $item->pic_hover = file_store($request->pic_hover, $pic_hover, 'photo-hover-');
                $item->update();
            }
            if ($request->hasFile('gallery')) {

                foreach ($request->gallery as $value) {
                    $photo = new Image();
                    $photo->path = file_store($value, 'source/assets/uploads/products/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-');;
                    $photo->type = 'gallery';
                    $photo->collection = 'Products';
                    $photo->model_id = $item->id;
                    $photo->save();
                }
            }
//            if (is_file($item->thumbnail)) {
//                $img = Image::make($item->thumbnail);
//                $img->resize(500, null, function ($constraint) {
//                    $constraint->aspectRatio();
//                });
//                $img->save($item->thumbnail);
//            }
//            if (is_file($item->pic_hover)) {
//                $img = Image::make($item->pic_hover);
//                $img->resize(300, null, function ($constraint) {
//                    $constraint->aspectRatio();
//                });
//                $img->save($item->pic_hover);
//            }

            return redirect()->route('product-list')->with('flash_message', 'محصول ثبت شد');

        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->withInput()->with('err_message', 'خطایی رخ داده.');

        }
    }

    public function edit($id)
    {
        $item = Product::find($id);
        $categories = Category::where('parent_id', null)->get();
        $brands = Brand::with('category')->get()->groupBy('category_id');

        $data = [];

        foreach ($brands as $key => $val) {
            if ($val[0]->category) {
                $data[$val[0]->category->name] = [];
                foreach ($val as $value) {
                    array_push($data[$value->category->name], [$value->id, $value->brand]);
                }
            }
        }

        $brands = $data;

        return view('panel.product.edit', compact('item', 'categories', 'brands'), ['title' => $this->controller_title('sum')]);
    }

    public function update(Request $request, $id)
    {

        $product = Product::findOrFail($id);
        if (!isset($request->model_have)) {
            $this->validate($request, [
                'price_default' => 'required',
                'inventory_default' => 'required',
            ]);
        }
        $this->validate($request, [
            'brand_id' => 'required',
            'category_id' => 'required',
            'title' => 'required|max:191',
            'slug' => 'required|max:191|unique:products,slug,' . $id,

        ]);


//        try {
        $product->title = $request->title;
        $product->slug = $request->slug;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->short_text = $request->short_text;
        $product->text = $request->text;
        $product->sort = $request->sort;
        $product->home_page = $request->home_page;
        $product->code = $request->code;
        $product->show = $request->show;
        $product->feature = json_encode($request->feature);
        $product->other_category = json_encode($request->other_category);

        if (isset($request->model_have) and $request->model_have == 'on') {
//            if ($product->model_have=='no'){
//                $product->inventory_default=0;
//                $product->price_default=0;
//                $product->vip_default=0;
//            }
            $product->model_have = 'yes';
        } else {
            $product->model_have = 'no';
            $product->inventory_default = $request->inventory_default;
            $product->price_default = $request->price_default;
            $product->vip_default = $request->vip_default;
        }


        if ($request->hasFile('pic_hover')) {
            $old_pic = $product->pic_hover;
            if (is_file($old_pic)) {
                File::delete($old_pic);
            }
            $pic_hover = 'source/assets/uploads/products/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/hover/';
            $product->pic_hover = file_store($request->pic_hover, $pic_hover, 'photo-hover-');
        }
        $product->update();


        if ($request->hasFile('photo_large')) {
            if($product->photoLarge)
            {
                $photo = $product->photoLarge;
                if (is_file($photo->path)) {
                    File::delete($photo->path);
                }
                $photo->delete();
            }else{
                $photo = new ImageModel();
                $photo->type = 'large';
                $photo->collection = 'Product';
                $photo->model_id = $product->id;
            }
            $photo->path = file_store($request->photo_large, 'source/assets/uploads/products/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-');;
            $photo->save();
        }

        if ($request->hasFile('photo_small')) {
            if($product->photoSmall)
            {
                $photo = $product->photoSmall;
                if (is_file($photo->path)) {
                    File::delete($photo->path);
                }
                $photo->delete();
            }else{
                $photo = new ImageModel();
                $photo->type = 'small';
                $photo->collection = 'Product';
                $photo->model_id = $product->id;
            }
            $photo->path = $thumbnail = file_store($request->photo_small, 'source/assets/uploads/products/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-');;
            $photo->save();

//            $img = Image::make($thumbnail);
//            $img = $img->resize(307, null, function ($constraint) {
//                $constraint->aspectRatio();
//            });
//            $save_path = 'source/assets/uploads/products/int-' . time() . '.jpg';
//            $img->save($save_path);
            $product->thumbnail = $thumbnail;
            $product->update();
        } else {
//            $img = Image::make($product->photoSmall->path);
//            $img = $img->resize(307, null, function ($constraint) {
//                $constraint->aspectRatio();
//            });
//            $save_path = 'source/assets/uploads/products/int-' . time() . '.jpg';
//            $img->save($save_path);
            if($product->photoSmall){
                $product->thumbnail = $product->photoSmall->path;
                $product->update();
            }


        }
        if ($request->hasFile('gallery')) {
           /* $photos = $product->gallery;
            foreach ($photos as $value) {
                if(is_file($value->path))
                {
                    File::delete($value->path);
                }
                $value->delete();
            }*/

            foreach ($request->gallery as $value) {
                $photo = new Image();
                $photo->path = file_store($value, 'source/assets/uploads/products/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-');;
                $photo->type = 'gallery';
                $photo->collection = 'Products';
                $photo->model_id = $product->id;
                $photo->save();
            }
        }
//        if (is_file($product->thumbnail)) {
//            $img = Image::make($product->thumbnail);
//            $img->resize(500, null, function ($constraint) {
//                $constraint->aspectRatio();
//            });
//            $img->save($product->thumbnail);
//        }
//        if (is_file($product->pic_hover)) {
//            $img = Image::make($product->pic_hover);
//            $img->resize(300, null, function ($constraint) {
//                $constraint->aspectRatio();
//            });
//            $img->save($product->pic_hover);
//        }
        $url = $request->only('redirects_to');
        return redirect()->to($url['redirects_to'])->with('flash_message', 'محصول با موفقیت ویرایش شد.');

//
//        } catch (\Exception $e) {
//            return redirect()->back()->with('err_message', 'خطایی رخ داده.');
//
//        }

    }

    public
    function remove_gallery($id)
    {
        $photo = Photo::find($id);
        try {
            File::delete($photo->path);
            $photo->delete();
            return redirect()->back()->with('flash_message', 'تصویر با موفقیت حذف شد.');
        } catch (\Exception $e) {

            return redirect()->back()->with('err_message', 'خطایی رخ داده است، لطفا مجددا تلاش نمایید');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($id, Request $request)
    {
        $product = Product::findOrFail($id);

//        try {
//            if ($product->type == 1) {
//                return redirect()->route('product-list')->with('err_message', 'محصول دارای مدل می باشد و قابل حذف نمی باشد.');
//            } else {
        $attrjoin = AttributeProductJoin::where('product_id', $product->id)->delete();
        $cmpjoin = ComparisonProductJoin::where('product_id', $product->id)->delete();
        $model = Modale::where('product_id', $product->id)->delete();
        $product->delete();
        \DB::table('product_tags')->where('product_id', $product->id)->delete();

        return redirect()->route('product-list')->with('flash_message', 'محصول با موفقیت حذف شد.');
//            }

//        } catch (\Exception $e) {
//
//            return redirect()->back();
//
//        }
    }

    public
    function type_del($id)
    {
        $price = Price::findOrfail($id);
        try {
            $price->delete();
            return redirect()->back()->with('flash_message', 'با موفقیت حذف شد');
        } catch (\Exception $e) {
            return redirect()->back()->with('err_message', 'خطایی رخ داده است، لطفا مجددا تلاش نمایید');
        }
    }

    public
    function attr_del($id)
    {
        $attr = AttributeProductJoin::findOrfail($id);
        try {
            $attr->delete();
            return redirect()->back()->with('flash_message', 'با موفقیت حذف شد');
        } catch (\Exception $e) {
            return redirect()->back()->with('err_message', 'خطایی رخ داده است، لطفا مجددا تلاش نمایید');
        }
    }

    public
    function comp_del($id)
    {
        $comp = ComparisonProductJoin::findOrfail($id);
        try {
            $comp->delete();
            return redirect()->back()->with('flash_message', 'با موفقیت حذف شد');
        } catch (\Exception $e) {
            return redirect()->back()->with('err_message', 'خطایی رخ داده است، لطفا مجددا تلاش نمایید');
        }
    }

    public
    function modelProduct($id)
    {
        $model = Price::where('product_id', $id)->get();
        return view('panel.product.model', compact('model', 'id'));
    }

    public
    function modelStore(Request $request, $id)
    {


        $price = Price::findOrfail($id);
        if ($request->hasFile('pic')) {


            $picModel = file_store($request->pic, 'source/assets/uploads/products/model/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-');
            $price->pic = $picModel;


        }

        $price->weigth = $request->weigth;


        $price->save();

        return redirect()->back()->with('flash_message', 'عملیات با موفقیت انجام شد');


    }

    public function product_show($id)
    {
        $pro = Product::findOrfail($id);

        try {
            if ($pro->status == 0) {
                $pro->status = 1;
                $pro->update();
                return redirect()->back()->with('flash_message', 'محصول ' . $pro->title . ' در حالت نمایش قرار گرفت');
            } else {
                $pro->status = 0;
                $pro->update();
                return redirect()->back()->with('flash_message', 'محصول ' . $pro->title . ' از حالت نمایش خارج شد');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('err_message', 'خطایی رخ داده است، لطفا مجددا تلاش نمایید');
        }
    }

    public function product_vip($id)
    {
        $pro = Product::findOrfail($id);

        try {
            if ($pro->vip == 0) {
                $pro->vip = 1;
                $pro->update();
                return redirect()->back()->with('flash_message', 'محصول ' . $pro->title . ' در حالت فروش ویژه قرار گرفت');
            } else {
                $pro->vip = 0;
                $pro->update();
                return redirect()->back()->with('flash_message', 'محصول ' . $pro->title . ' از حالت فروش ویژه خارج شد');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('err_message', 'خطایی رخ داده است، لطفا مجددا تلاش نمایید');
        }
    }

    public function product_status($id, $type)
    {
        $pro = Product::findOrfail($id);
        if ($type=='show'){
            if ($pro->show==1){
                $pro->show=0;
            }else{
                $pro->show=1;
            }
            $pro->save();
            return redirect()->back()->with('flash_message', 'Değişiklikler başarıyla yapıldı');

        }else{
            if ($pro->$type == 'active') {
                $pro->$type = 'no_active';
                $pro->update();
                return redirect()->back()->with('flash_message', 'Öğe başarıyla devre dışı bırakıldı');

            } else
            {
                $pro->$type = 'active';
                $pro->update();
                return redirect()->back()->with('flash_message', 'Öğe başarıyla etkinleştirildi');

            }
        }

        try {
            if ($pro->vip == 0) {
                $pro->vip = 1;
                $pro->update();
                return redirect()->back()->with('flash_message', 'محصول ' . $pro->title . ' در حالت فروش ویژه قرار گرفت');
            } else {
                $pro->vip = 0;
                $pro->update();
                return redirect()->back()->with('flash_message', 'محصول ' . $pro->title . ' از حالت فروش ویژه خارج شد');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('err_message', 'خطایی رخ داده است، لطفا مجددا تلاش نمایید');
        }
    }

    public function update_order_point(Request $request, $id)
    {
        $pro = Product::findOrfail($id);
        try {

            $pro->order_point = $request->order_point;
            $pro->update();
            return redirect()->back()->with('flash_message', 'محدودیت فروش محصول ' . $pro->title . ' به تعداد ' . $pro->order_point . ' عدد تغییر کرد');
        } catch (\Exception $e) {
            return redirect()->back()->with('err_message', 'خطایی رخ داده است، لطفا مجددا تلاش نمایید');
        }
    }

    public function product_update_time(Request $request, $id)
    {
        $pro = Product::findOrfail($id);
        try {
            $ts = time();
            $date = date("Y-m-d H:i:s", $ts);
            $pro->time = $request->time;
            $pro->created_at = $date;
            $pro->save();
            return redirect()->back()->with('flash_message', 'زمان شگفت انگیز محصول ' . $pro->title . ' بمدت ' . $pro->time . ' ساعت تعیین شد');
        } catch (\Exception $e) {
            return redirect()->back()->with('err_message', 'خطایی رخ داده است، لطفا مجددا تلاش نمایید');
        }
    }

    public function product_price_tel($id)
    {
        $pro = Product::findOrfail($id);

        try {
            if ($pro->vip1 == 0) {
                $pro->vip1 = 1;
                $pro->update();
                return redirect()->back()->with('flash_message', 'محصول ' . $pro->title . ' در حالت پیشنهادات شگفت انگیز قرار گرفت');
            } else {
                $pro->vip1 = 0;
                $pro->update();
                return redirect()->back()->with('flash_message', 'محصول ' . $pro->title . ' از حالت پیشنهادات شگفت انگیز خارج شد');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('err_message', 'خطایی رخ داده است، لطفا مجددا تلاش نمایید');
        }
    }

    public function product_update_invent($id, Request $request)
    {
        $pro = Product::findOrfail($id);
        try {

            $pro->inventory = $request->inventory;
            $pro->update();
            return redirect()->back()->with('flash_message', 'موجودی محصول ' . $pro->title . ' به تعداد ' . $pro->inventory . ' عدد تغییر کرد');
        } catch (\Exception $e) {
            return redirect()->back()->with('err_message', 'خطایی رخ داده است، لطفا مجددا تلاش نمایید');
        }
    }

    public function product_update_puser($id, Request $request)
    {
        $pro = Product::findOrfail($id);
        try {

            $pro->price_user = $request->price_user;
            $pro->update();
            return redirect()->back()->with('flash_message', 'قیمت محصول ' . $pro->title . ' به قیمت ' . $pro->price_user . ' تومان تغییر کرد');
        } catch (\Exception $e) {
            return redirect()->back()->with('err_message', 'خطایی رخ داده است، لطفا مجددا تلاش نمایید');
        }
    }

    public function product_update_pvip($id, Request $request)
    {
        $pro = Product::findOrfail($id);
        try {

            $pro->price_vip = $request->price_vip;
            $pro->update();
            return redirect()->back()->with('flash_message', 'قیمت ویژه محصول ' . $pro->title . ' به قیمت ' . $pro->price_vip . ' تومان تغییر کرد');
        } catch (\Exception $e) {
            return redirect()->back()->with('err_message', 'خطایی رخ داده است، لطفا مجددا تلاش نمایید');
        }
    }

    public function del_article($id)
    {
        $pro = Product::findOrfail($id);
        try {
            if ($pro->article != null) {
                File::delete($pro->article);
                $pro->article = null;
                $pro->save();
                return redirect()->back()->with('flash_message', 'مقاله محصول ' . $pro->title . ' باموفقیت حذف شد');
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('err_message', 'خطایی رخ داده است، لطفا مجددا تلاش نمایید');
        }
    }

    public function del_video($id)
    {
        $pro = Product::findOrfail($id);
        try {
            if ($pro->video != null) {
                File::delete($pro->video);
                $pro->video = null;
                $pro->save();
                return redirect()->back()->with('flash_message', 'ویدئو محصول ' . $pro->title . ' باموفقیت حذف شد');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('err_message', 'خطایی رخ داده است، لطفا مجددا تلاش نمایید');
        }
    }

    public function brandAjax(Request $request)
    {
        $name = $request->get('brand');

        $brand = new Brand();
        $brand->brand = $name;

        $brand->save();
        $brands = Brand::all()->sortByDesc('id');
        return response()->json($brands);
    }

    public function catAjax(Request $request)
    {
        $compar = Comparison::where('category_id', $request->get('cat_id'))->orwhere('category_id', 0)->get();
        return response()->json($compar);
    }

    public function create_compar(Request $request)
    {
        $compar_name = Comparison::where('category_id', $request->get('compar_name'))->get();
        $compar_val = Comparison::where('category_id', $request->get('compar_name'))->get();
    }

    public function del_photo($id)
    {
        $pic = Image::find($id);
        try {
            $pic->delete();
            return redirect()->back()->with('flash_message', 'The product image has been successfully removed');
        } catch (\Exception $e) {
            return redirect()->back()->with('err_message', 'خطایی رخ داده است، لطفا مجددا تلاش نمایید');
        }
    }

    public function del_compar($id)
    {
        $pic = ComparisonProductJoin::find($id);
        try {
            $pic->delete();
            return redirect()->back()->with('flash_message', 'ویژگی محصول باموفقیت حذف شد');
        } catch (\Exception $e) {
            return redirect()->back()->with('err_message', 'خطایی رخ داده است، لطفا مجددا تلاش نمایید');
        }
    }

    public function update_all_model($id, Request $request)
    {

        if ($request->price_s == null and $request->price_u == null and $request->price_v == null) {
            return redirect()->back()->with('err_message', 'هیچ مقداری ارسال نشد');
        } else {
            $model = Modale::where('product_id', $id)->get();
            foreach ($model as $m) {
                if ($request->price_s != null) {
                    $m->price_store = $request->price_s;
                }
                if ($request->price_u != null) {
                    $m->price_user = $request->price_u;
                }
                if ($request->price_v != null) {
                    $m->price_vip = $request->price_v;
                }
                $m->update();

            }
            return redirect()->back()->with('flash_message', 'با موفقیت ویرایش شد');

        }

    }

    public $f_brand = [];
    public $f_cat = [];

    public function search1(Request $request)
    {

        $products = Product::where('title', 'LIKE', '%' . $request->product . '%')->orderBy('id', 'DESC')->paginate(100);

        return view('panel.product.index', compact('products'), ['title' => $this->controller_title('sum')]);
    }

    public function export_excel ()
    {
        $time=date('Y-m-d H:i:s');
        return Excel::download(new ProductExport, 'Product_list( " '. $time .').xlsx');
//        return Excel::download(new ProductExport, 'ProducFromFirst.xlsx');
    }
    public function import_excel(Request $request)
    {
        if(\Session::has('err_bimari'))
        {
            return redirect()->route('bimari-list',session()->get('locale'))->with('err_message', 'لطفا طبق فایل نمونه فایل را آپلود کنید.');
        }
        $this->validate($request, [
            'file' => 'required||mimes:xls,xlsx',
        ],
            [
                'file.required' => 'لطفا  فایل اکسل را وارد کنید',
                'file.mimes' => 'لطفا فرمت صحیح اکسل را انتخاب کنید(xls,xlsx)',
            ]);
//
        Excel::import(new ProductImport,$request->file('file'));
        return redirect()->back()->with('flash_message','آپلود شد');
    }
    public function add_comparss_to(Request $request)
    {
        $com_n = $request->get('com_n');
        $com_v = $request->get('com_v');
        $compar = Comparison::where('name', $com_n)->first();
        if (isset($compar) and $compar) {
            return response()->json($compar);
        }
        $com = new Comparison();
        $com->name = $com_n;
        $com->category_id = 0;
        $com->save();
        return response()->json($com);
    }
}
