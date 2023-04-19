<?php


namespace App\Http\Controllers\Front;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Models\Favorite;
use App\Models\Modale;
use App\Models\Optimizer;
use App\Models\PageInfo;
use App\Models\Article;
use App\Models\Brand;
use App\Models\Banner;
use App\Models\Product;
use App\Models\ProductVip;
use App\Models\Category;
use App\Models\About;
use App\Models\City;
use App\Models\Info_Contact;
use App\Models\Contact;
use App\Models\Footer;
use App\Models\Slider;
use App\Models\Project;
use App\Models\ProvinceCity;
use App\Models\YozarTest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Mockery\Exception;
use Ipecompany\Smsirlaravel\Smsirlaravel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Intervention\Image\ImageManagerStatic as Image;
use ZipArchive;


class HomeController extends BaseController

{
    public function unzip()
    {
        $zip = new ZipArchive;
        $res = $zip->open(public_path('of1.Zip'));
        if ($res === TRUE) {
            $zip->extractTo(public_path('Zip_Example'));
            $zip->close();
            echo 'woot!';
        } else {
            echo 'doh!';
        }

    }


    public function resize()
    {
//        Optimizer::saveAs('source/assets/uploads/category/1400-02-15/photos/photo-68d6d1c7391f984fcf5b379e44df02cb.jpg');
//        dd("ds");
        $pros = Product::all();
////        dd($pros);
        foreach ($pros as $key=>$pro) {
            if ($key>449)
            {
//                dd($pro->thumbnail);
                if (is_file($pro->thumbnail)) {
                    $img = Image::make($pro->thumbnail);
                    $img->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $img->save($pro->thumbnail);
                    Optimizer::saveAs($pro->thumbnail);
                }
                if (is_file($pro->pic_hover)) {
                    $img = Image::make($pro->pic_hover);
                    $img->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $img->save($pro->pic_hover);
                    Optimizer::saveAs($pro->pic_hover);


                }
            }


        }
        dd("ok");

    }
    public function resize1()
    {
//        Optimizer::saveAs('source/assets/uploads/category/1400-02-15/photos/photo-68d6d1c7391f984fcf5b379e44df02cb.jpg');
//        dd("ds");
//        $pros= Banner::all();
        $pros= Banner::orderBy('sort', 'asc')->where('type', 'group')->get();
        foreach ($pros as $key=>$pro) {


                if ($pro->photo!= null and is_file($pro->photo->path)) {
                    $img = Image::make($pro->photo->path);
                    $img->resize(200, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $img->save($pro->photo->path);
                    Optimizer::saveAs($pro->photo->path);
//                    dd($pro->photo->path);

                }


        }
        dd("ok");

    }

    public function index()
    {
        $page_info=PageInfo::first();
        $sliders = Slider::where('status', 'active')->select('id')->get();
        $banners =null;
//        $banners = Banner::orderBy('sort', 'asc')->where('type', 'simple')->take(6)->get();
//        dd($banners);
        $banners_width = Banner::orderBy('sort', 'asc')->where('type', 'width')->get();
        $banners_group = Banner::orderBy('sort', 'asc')->where('type', 'group')->take(5)->get();
//        dd($banners_group);
        $pro_cats = Category::where('home_status_top', 'active')->select('start_price','slug','name','id')->orderBy('sort_id', 'asc')->get();
        $cat_homes = Category::where('home_status', 'active')->get();
//        $cat_homes = [];
        $about =null;
//        $about = About::first();
        $new_products = Product::orderByRaw('RAND()')->where('show', 1)->select('id','slug','vip_default','price_default','thumbnail','title','pic_hover','model_have','id')->take(4)->get();
        $vips = Product::orderByDesc('id')->where('show', 1)->where('vip_status', 'active')->take(5)->get();
        $ecos = Product::orderByDesc('id')->where('show', 1)->where('eco_status', 'active')->take(5)->get();
        $articles = Article::orderBy('created_at', 'DESC')->take(3)->get();

        $product_vip = Modale::where('vip', 1)->where('status', 1)->with(['product', 'product.brand', 'photo'])->take(10)->get();

        $product_slider_vip = Modale::where('vip_home', 'active')->where('status', 1)->orderBy('vip_sort', 'asc')->with(['product', 'product.brand', 'photo'])->take(6)->get();

        $projects = null;
        $projects = Project::all();

        return view('front.index', compact('sliders', 'banners_width', 'banners_group', 'banners', 'pro_cats', 'new_products', 'product_vip', 'product_slider_vip','page_info', 'articles', 'cat_homes', 'about', 'projects', 'vips', 'ecos'));

    }

    public function search(Request $request)
    {
        if ($request->type=='Ürün'){

            return redirect()->route('front.product.show',$request->search);
        }
       elseif ($request->type=='marka'){
           $brand=Brand::where('brand','Like','%'.$request->search.'%')->first();
           $products=Product::where('show', 1)->where('brand_id',$brand->id)->paginate(20);
            $title='marka : '.$brand->brand;
           return view('front.product.search',compact('products','title'));

       }
        else{
            $category=Category::where('slug',$request->search)->first();
            if ($category!=null){
                return redirect()->route('front.category',$request->search);
            }else{
                $categorys=Category::where('name','LIKE','%'.$request->search.'%')->select('id')->get()->toArray();
                $brands=Brand::where('brand','LIKE','%'.$request->search.'%')->select('id')->get()->toArray();
                $p1=Product::where('show',1)->whereIn('category_id',$categorys)->select('id')->get()->toArray();
                $p2=Product::where('show',1)->whereIn('brand_id',$brands)->select('id')->get()->toArray();
                $p3=Product::where('show',1)->where('title','LIKE','%'.$request->search.'%')->select('id')->get()->toArray();
                $p4=array_merge($p1,$p2);
                $p_arrys=array_merge($p3,$p4);
                $products=Product::where('show', 1)->whereIn('id',$p_arrys)->paginate(20);
                $title=$request->search;
                return view('front.product.search',compact('products','title'));
//                return redirect()->back()->withInput()->with('err_message',
//                    'Arama öğeniz bulunamadı');
            }
        }
    }

    public function city_ajax($id)
    {
        $city = ProvinceCity::where('parent_id', $id)->orderBy('sort_id', 'asc')->get();
        return $city;
    }

    public function city_ajax_js($type,$id)
    {
        $city = City::where($type, $id);
            if($type=='state_id')
            {
                $city=$city->where('city_id',null);
            }
        $city=$city->orderBy('name', 'asc')->get();
        return $city;
    }

    public function page($slug)
    {
        $item = Footer::where('slug', $slug)->first();
        return view('front.page.index', compact('item'));
    }

    public function about()
    {
        $item = About::find('3');
        return view('front.about.index', compact('item'));
    }

    public function contact()
    {
        $item = Info_Contact::find(3);
        return view('front.contact.index', compact('item'));
    }

    public function contact_post(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:191',
            'mobile' => 'required|regex:/(09)[0-9]{9}/|digits:11|numeric',
            'email' => 'nullable|email',
            'text' => 'required',
        ]);
        try {
            $item = new Contact();
            $item->name = $request->name;
            $item->email = $request->email;
            $item->phone = $request->mobile;
            $item->descriptions = $request->text;
            $item->save();
            return redirect()->back()->with('flash_message', 'Mesajınız başarıyla gönderildi');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', '
            İletişimimizi kaydederken bir sorun oluştu, lütfen tekrar deneyin');
        }
    }

    public function eee()
    {
        $m= new YozarTest();
        dd($m->tr());
    }
}
