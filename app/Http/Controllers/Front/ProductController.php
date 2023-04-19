<?php


namespace App\Http\Controllers\Front;

use Couchbase\PrefixSearchQuery;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Models\Favorite;
use App\Models\Modale;
use App\Models\Brand;
use App\Models\Banner;
use App\Models\Product;
use App\Models\ProductVip;
use App\Models\Category;
use App\Models\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Mockery\Exception;
use Ipecompany\Smsirlaravel\Smsirlaravel;
use Illuminate\Routing\Controller as BaseController;


class ProductController extends BaseController

{
    public function set_order_cat()
    {
        $categorys = [];
        $cat_id = [];
        $category=Category::find(68);
        array_push($categorys, $category->id);
        array_push($cat_id, $category->id);
        if (count($category->children) > 0) {
            foreach ($category->children as $child) {
                array_push($categorys, $child->id);
                array_push($cat_id, $child->id);
                if (count($child->children) > 0) {
                    foreach ($child->children as $child1) {
                        array_push($cat_id, $child1->id);
                        if (count($child1->children) > 0) {
                            foreach ($child1->children as $child2) {
                                array_push($cat_id, $child2->id);
                            }
                            if (count($child2->children) > 0) {
                                foreach ($child2->children as $child3) {
                                    array_push($cat_id, $child3->id);
                                }
                            }
                        }
                    }
                }
            }
        }
        if ($category != null) {
            $category_name = '' . $category->name;
            $products = Product::whereIn('category_id', $cat_id)->orderByRaw('RAND()')->where('show', 1)->where('eco_status', 'no_active')->get();
        }
//        foreach ($products as $product) {
//            if ($product->other_category == 'null') {
//                $product->other_category = '["68"]';
//                $product->save();
//            } else {
//                dd("nooooo");
//            }
//        }
////            if (in_array($category->id, json_decode($item->other_category))) {
////                array_push($oder_cat,$item->id);
//
//        }
        dd($products);
    }

    public function category($slug)
    {

        $categorys = [];
        $cat_id = [];
        $category = Category::where('slug', $slug)->first();
        array_push($categorys, $category->id);
        array_push($cat_id, $category->id);
        if (count($category->children) > 0) {
            foreach ($category->children as $child) {
                array_push($categorys, $child->id);
                array_push($cat_id, $child->id);
                if (count($child->children) > 0) {
                    foreach ($child->children as $child1) {
                        array_push($cat_id, $child1->id);
                        if (count($child1->children) > 0) {
                            foreach ($child1->children as $child2) {
                                array_push($cat_id, $child2->id);
                            }
                            if (count($child2->children) > 0) {
                                foreach ($child2->children as $child3) {
                                    array_push($cat_id, $child3->id);
                                }
                            }
                        }
                    }
                }
            }
        }
        if ($category != null) {
            $category_name = '' . $category->name;
            $products = Product::whereIn('category_id', $cat_id)->orderByRaw('RAND()')->where('show', 1)->where('eco_status', 'no_active')->select('id')->get();
            $products_vip = Product::whereIn('category_id', $cat_id)->where('show', 1)->where('vip_status', 'active')->orderBy('created_at', 'desc')->get();
        } else {
            $products = Product::where('category_id', 'no_product')->where('show', 1)->orderBy('created_at', 'desc')->where('eco_status', 'no_active')->paginate(20);
            $category_name = '';
        }

        $allproduct = Product::where('show', 1)->where('other_category', '!=', 'null')->where('eco_status', 'no_active')->get();
//            dd($allproduct[0])

        $oder_cat=[];
                foreach ($allproduct as $item) {
                    if (in_array($category->id, json_decode($item->other_category))) {
                        array_push($oder_cat,$item->id);
                    }
//
                }
                foreach ($products as $product) {
                    array_push($oder_cat, $product->id);
                }

                $oder_cat=array_unique($oder_cat);
                    $products_price=Product::whereIn('id',$oder_cat)->orderBy('id','DESC')->get();
                    $products=Product::whereIn('id',$oder_cat)->orderBy('id','DESC')->paginate(20);
                    $min_price_d=$products_price->min('price_default');
                    $max_price_d=$products_price->max('price_default');
                    $sort_product='new';
                    $vip_product='no';
                    $min_price=TlFilter($min_price_d);
                    $max_price=TlFilter($max_price_d);
                return view('front.product.category', compact('products', 'products_vip', 'category_name', 'category','min_price_d','max_price_d','min_price','max_price','sort_product','vip_product'));
    }

    public function category_filter($slug,Request $request)
    {
        $price=explode('-',$request->ttr);
        $categorys = [];
        $cat_id = [];
        $category = Category::where('slug', $slug)->first();
        array_push($categorys, $category->id);
        array_push($cat_id, $category->id);
        if (count($category->children) > 0) {
            foreach ($category->children as $child) {
                array_push($categorys, $child->id);
                array_push($cat_id, $child->id);
                if (count($child->children) > 0) {
                    foreach ($child->children as $child1) {
                        array_push($cat_id, $child1->id);
                        if (count($child1->children) > 0) {
                            foreach ($child1->children as $child2) {
                                array_push($cat_id, $child2->id);
                            }
                            if (count($child2->children) > 0) {
                                foreach ($child2->children as $child3) {
                                    array_push($cat_id, $child3->id);
                                }
                            }
                        }
                    }
                }
            }
        }
        if ($category != null) {
            $category_name = '' . $category->name;
            $products = Product::whereIn('category_id', $cat_id)->orderByRaw('RAND()')->where('show', 1)->where('eco_status', 'no_active')->select('id')->get();
            $products_vip = Product::whereIn('category_id', $cat_id)->where('show', 1)->where('vip_status', 'active')->orderBy('created_at', 'desc')->get();
        } else {
            $products = Product::where('category_id', 'no_product')->where('show', 1)->orderBy('created_at', 'desc')->where('eco_status', 'no_active')->paginate(20);
            $category_name = '';
        }

        $allproduct = Product::where('show', 1)->where('other_category', '!=', 'null')->where('eco_status', 'no_active')->get();


        $oder_cat=[];
        foreach ($allproduct as $item) {
            if (in_array($category->id, json_decode($item->other_category))) {
                array_push($oder_cat,$item->id);
            }
//
        }
        foreach ($products as $product) {
            array_push($oder_cat, $product->id);
        }

        $oder_cat=array_unique($oder_cat);
        $products_price=Product::whereIn('id',$oder_cat)->orderBy('id','DESC')->get();
        $min_price_d=$products_price->min('price_default');
        $max_price_d=$products_price->max('price_default');
        $products=Product::whereIn('id',$oder_cat);
        $sort_product=$request->sort_product;
        //sort
        switch ($sort_product){
            case 'new':
                $products=$products->orderBy('created_at','desc');
                break;
            case 'price_up':
                $products=$products->orderBy('price_default','desc');
                break;
            case 'price_down':
                $products=$products->orderBy('price_default','asc');
                break;
            case 'vip':
                $products=$products->whereColumn('price_default','>','vip_default')->where('vip_default','>',0)->orderBy('vip_default','desc');
                break;
        }
        $vip_product=$request->vip_product;
        //sort
        switch ($vip_product){
            case 'no':
                break;
            case 'yes':
                $products=$products->whereColumn('price_default','>','vip_default')->where('vip_default','>',0);
                break;
        }

        $min_price=0;
        $max_price=0;
        // $min_price=$price[0];
        // $max_price=$price[1];
        // if($min_price>TlFilter($min_price_d))
        // {
        //     $min_price1=$min_price;
        //     if($vip_product=='yes')
        //     {
        //         $products=$products->where('vip_default','>=',intval($min_price1));
        //     }
        //     elseif($vip_product=='no')
        //     {
        //         $products=$products->where('price_default','>=',intval($min_price1));
        //     }
        // }
        // if($max_price<TlFilter($max_price_d))
        // {
        //     $max_price1=$max_price;
        //     if($vip_product=='yes')
        //     {
        //         $products=$products->where('vip_default','<=',intval($max_price1));
        //     }
        //     elseif($vip_product=='no')
        //     {
        //         $products=$products->where('price_default','<=',intval($max_price1));
        //     }
        // }
        $products=$products->where('price_default','>',0)->paginate(20);
        return view('front.product.category', compact('products', 'products_vip', 'category_name', 'category','min_price_d','max_price_d','min_price','max_price','sort_product','vip_product'));
    }


    public function products_type($type)
    {
        if ($type == 'vip') {
            $products = Product::orderBy('created_at', 'DESC')->where('show', 1)->where('vip_status', 'active')->paginate(20);
        } elseif ($type == 'eco') {
            $products = Product::orderBy('created_at', 'DESC')->where('show', 1)->where('eco_status', 'active')->paginate(20);
        } else {
            $products = '';
        }
        return view('front.product.vip_index', compact('products', 'type'));


    }

    public function products_vip($slug, Request $request)
    {
        if ($slug == 'vip') {
            $item = null;
            $title = 'پیشنهادهای ویژه';
            $items = Modale::where('vip', 1)->where('status', 1)->with(['product', 'product.brand', 'photo'])->orderBy('created_at', 'desc')->paginate(20);
            return view('front.product.vip', compact('item', 'items', 'title'));
        } else {
            $item = ProductVip::find(1);
            $title = $item->title;
            if ($item->status == 'active') {
                $items = Modale::where('vip_page', 'active')->where('status', 1)->orderBy('vip_sort', 'asc')->with(['product', 'product.brand', 'photo'])->paginate(20);
                return view('front.product.vip', compact('item', 'items', 'title'));
            } else {
                return redirect()->back()->with('err_message', 'فروش ویژه فعال نمی باشد');
            }
        }
    }


    public function products($slug)
    {
//        //start delete khahad shod
//        foreach (Product::all() as $g){
//            if($g->defaults)
//            {
//                if(!is_null($g->defaults->price_vip) && $g->defaults->price_vip<$g->defaults->price)
//                {
//                    $g->price_default=$g->defaults->price_vip;
//                    $g->vip_default=1;
//                }
//                else {
//                    $g->price_default=$g->defaults->price;
//                }
//                $g->inventory_default=$g->defaults->inventory;
//                $g->update();
//
//            }
//        }
        //end delete khahad shod

        if ($slug == 'all') {
            $category = Category::where('parent_id', null)->get();
            $category_name = 'همه محصولات';
            $products = Product::orderBy('created_at', 'desc')->where('show', 1)->paginate(20);
            $product_all = Product::where('price_default', '>', 0)->where('show', 1)->get();
            $price_start = $product_all->min('price_default');
            $price_end = $product_all->max('price_default');
        } else {
            $categorys = [];
            $cat_id = [];
            $category = Category::where('slug', $slug)->get();
            array_push($categorys, $category[0]->id);
            array_push($cat_id, $category[0]->id);
            if (count($category[0]->children) > 0) {
                foreach ($category[0]->children as $child) {
                    array_push($categorys, $child->id);
                    array_push($cat_id, $child->id);
                    if (count($child->children) > 0) {
                        foreach ($child->children as $child1) {
                            array_push($cat_id, $child1->id);
                            if (count($child1->children) > 0) {
                                foreach ($child1->children as $child2) {
                                    array_push($cat_id, $child2->id);
                                }
                                if (count($child2->children) > 0) {
                                    foreach ($child2->children as $child3) {
                                        array_push($cat_id, $child3->id);
                                    }
                                }
                            }
                        }
                    }
                }
            }
            if (count($category) > 0) {
                $category_name = 'محصولات ' . $category[0]->name;
                $products = Product::whereIn('category_id', $cat_id)->where('show', 1)->orderBy('created_at', 'desc')->paginate(20);
                $product_all = Product::whereIn('category_id', $cat_id)->where('show', 1)->where('price_default', '>', 0)->get();
                $price_start = $product_all->min('price_default');
                $price_end = $product_all->max('price_default');
            } else {
                $products = Product::where('category_id', 'no_product')->where('show', 1)->orderBy('created_at', 'desc')->paginate(20);
                $price_start = 0;
                $price_end = 0;
                $category_name = 'محصولات';
            }
        }
        $cats = [];
        $price_from = $price_start;
        $price_to = $price_end;
        $invent = 0;
        $sort = 'new';
        return view('front.product.index', compact('products', 'category', 'slug', 'cats', 'price_from', 'price_to', 'invent', 'sort', 'price_start', 'price_end', 'category_name'));
    }

    public function filter($slug, Request $request)
    {
        //start delete khahad shod
//        foreach (Product::all() as $g){
//            if($g->defaults)
//            {
//                if(!is_null($g->defaults->price_vip) && $g->defaults->price_vip<$g->defaults->price)
//                {
//                    $g->price_default=$g->defaults->price_vip;
//                    $g->vip_default=1;
//                }
//                else {
//                    $g->price_default=$g->defaults->price;
//                }
//                $g->inventory_default=$g->defaults->inventory;
//                $g->update();
//
//            }
//        }
        //end delete khahad shod
        $cats = [];
        if ($request->cats) {
            $cats = $request->cats;
            $cat_filter = Category::whereIn('id', $cats)->get();
            foreach ($cat_filter as $cat_f) {
                if (count($cat_f->children) > 0) {
                    foreach ($cat_f->children as $cat_child1) {
                        array_push($cats, $cat_child1->id);
                        if (count($cat_child1->children) > 0) {
                            foreach ($cat_child1->children as $cat_child2) {
                                array_push($cats, $cat_child2->id);
                                if (count($cat_child2->children) > 0) {
                                    foreach ($cat_child2->children as $cat_child3) {
                                        array_push($cats, $cat_child3->id);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $price_from = $request->price_1;
        $price_to = $request->price_2;
        $invent = $request->invent;
        $sort = $request->sort;
        if ($slug == 'all') {
            $category = Category::where('parent_id', null)->get();
            $product_all = Product::where('price_default', '>', 0)->where('show', 1)->get();
            $category_name = 'فیلتر همه محصولات';
            $price_start = $product_all->min('price_default');
            $price_end = $product_all->max('price_default');

            //filtering
            //invent
            if ($invent == 1) {
                $products = Product::where('inventory_default', '>', 0);
            } else {
                $products = Product::where('inventory_default', '>=', 0);
            }
            //price
            if ($price_from > $price_start) {
                $products = $products->where('price_default', '>=', $price_from);
            }
            if ($price_to < $price_end) {
                $products = $products->where('price_default', '<=', $price_to);
            }
            //cats
            if (count($cats) > 0) {
                $products = $products->whereIn('category_id', $cats);
            }
            //sort
            switch ($sort) {
                case 'new':
                    $products = $products->orderBy('created_at', 'desc');
                    break;
                case 'price_big':
                    $products = $products->orderBy('price_default', 'desc');
                    break;
                case 'price_small':
                    $products = $products->orderBy('price_default', 'asc');
                    break;
                case 'seen':
                    $products = $products->orderBy('view', 'desc');
                    break;
            }


            $products = $products->paginate(20);
        } else {
            $categorys = [];
            $cat_id = [];
            $category = Category::where('slug', $slug)->get();
            array_push($categorys, $category[0]->id);
            if (count($category[0]->children) > 0) {
                foreach ($category[0]->children as $child) {
                    array_push($categorys, $child->id);
                    array_push($cat_id, $child->id);
                    if (count($child->children) > 0) {
                        foreach ($child->children as $child1) {
                            array_push($cat_id, $child1->id);
                            if (count($child1->children) > 0) {
                                foreach ($child1->children as $child2) {
                                    array_push($cat_id, $child2->id);
                                }
                                if (count($child2->children) > 0) {
                                    foreach ($child2->children as $child3) {
                                        array_push($cat_id, $child3->id);
                                    }
                                }
                            }
                        }
                    }
                }
            }
            if (count($category) > 0) {
                $product_all = Product::whereIn('category_id', $cat_id)->where('show', 1)->where('price_default', '>', 0)->get();
                $category_name = 'فیلتر محصولات ' . $category[0]->name;
                $price_start = $product_all->min('price_default');
                $price_end = $product_all->max('price_default');

                //filtering

                $products = Product::whereIn('category_id', $cat_id);
                //price
                if ($price_from > $price_start) {
                    $products = $products->where('price_default', '>=', $price_from);
                }
                if ($price_to < $price_end) {
                    $products = $products->where('price_default', '<=', $price_to);
                }
                //cats
                if (count($cats) > 0) {
                    $products = $products->whereIn('category_id', $cats);
                }
                //invent
                if ($invent == 1) {
                    $products = $products->where('inventory_default', '>', 0);
                }
                //sort
                switch ($sort) {
                    case 'new':
                        $products = $products->orderBy('created_at', 'desc');
                        break;
                    case 'price_big':
                        $products = $products->orderBy('price_default', 'desc');
                        break;
                    case 'price_small':
                        $products = $products->orderBy('price_default', 'asc');
                        break;
                    case 'seen':
                        $products = $products->orderBy('view', 'desc');
                        break;
                }

                $products = $products->paginate(20);
            } else {
                $products = Product::where('category_id', 'no_product')->orderBy('created_at', 'desc')->where('show', 1)->paginate(20);
                $category_name = 'محصولات';
                $price_start = 0;
                $price_end = 0;
            }
        }
        return view('front.product.index', compact('products', 'category', 'slug', 'cats', 'price_from', 'price_to', 'invent', 'sort', 'price_start', 'price_end', 'category_name'));
    }
    public function show1($slug)
    {
        $item = Product::where('slug', $slug)->first();
        if (count($item->models) > 0) {
            if ($item->defaults) {
                $model_default = $item->defaults;
            } else {
                $model_default = $item->models[0];
            }
        } else {
            $model_default = null;
        }
        $total  = 0;
        // if ($item->thumbnail!=null) $total  += 1;
        if ($item->photoLarge!=null) {
            $photoLarge = $item->photoLarge;
            $total  += 1;
        }
        $total  += $item->models->count();
        $total  += $item->gallery->count();
        return view('front.product.show', compact('slug', 'item', 'model_default','total','photoLarge'));
    }

    public function product($slug, $model_id)
    {
        $item = Product::where('slug', $slug)->first();
        $model_default = Modale::find($model_id);
        if (!$item || count($item->models) <= 0 || !$model_default) {
            return redirect()->back()->with('err_message', 'محصول قابل نمایش نمی باشد');
        }
        $item->view += 1;
        $item->update();

        // product detail
        $items = Product::where('category_id', $item->category_id)->where('id', '!=', $item->id)->where('show', 1)->whereHas('models')->get();
        //comment product
//        $comments = Comment::where('status', 1)->where('product_id', $item->id)->where('reply_id', 0)->get();

        return view('front.product.show', compact('item', 'items', 'model_default'));

    }

    public function comment($id, Request $request)

    {
        $item = Product::findOrFail($id);
        $this->validate($request, [
            'text' => 'required',
        ]);
        try {
            if (!Auth::check()) {
                return redirect()->back()->withInput()->with('err_message', 'ابتدا وارد شوید');
            }
            $comment = new Comment();
            $comment->name = Auth::user()->first_name . ' ' . Auth::user()->last_name;
            $comment->email = Auth::user()->email;
            $comment->product_id = $id;
            $comment->text = $request->text;
            $comment->save();
            return redirect()->back()->with('flash_message', 'پیام شما با موفقیت ارسال شد');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ثبت دیدگاه محصول رخ داده، مجددا تلاش بفرمایید');
        }

        return view('search', compact('brand', 'products', 'price1', 'price2', 'id'));

    }

}
