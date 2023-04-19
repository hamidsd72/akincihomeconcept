<?php


namespace App\Http\Controllers\Front;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Hash;
use App\Models\Basket;
use App\Models\Factor;
use App\Models\Product;
use App\Models\Modale;
use App\Models\Address;
use App\Models\Setting;
use App\Models\ProvinceCity;
use App\Models\Off;
use App\Models\City;
use App\Models\Verify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use function Symfony\Component\VarDumper\Dumper\esc;
use Mockery\Exception;
use Illuminate\Support\Facades\Cookie;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use PhpParser\Node\Stmt\TraitUseAdaptation\Precedence;
use Ipecompany\Smsirlaravel\Smsirlaravel;

class BasketController extends Controller

{
    public function getBasket()
    {
        $basket_show = [];
        $model_id = [];
        $product_id = [];
        $total_price = 0;
        $all_price = 0;
        $order_code = 0;
        if (!Cookie::has('order_code')) {
            $order_code = time();
            Cookie::queue('order_code', $order_code, 60);
        } else {
            $order_code = Cookie::get('order_code');
        }
        if (Cookie::has('basket')) {
            $basket = json_decode(Cookie::get('basket'));

            foreach ($basket as $val) {

                if ($val->model != 0) {
//                    dd($val->product);
                    $product = Product::where('id', $val->product);
                    $model = Modale::where('id', $val->model)->where('status', 1)->first();
                    if ($model and $product) {
                        array_push($basket_show, ['product' => $product, 'model' => $model, 'number' => $val->number, 'order_code' => (int)$order_code]);
                    }

                } else {
                    $product = Product::where('id', $val->product)->first();
                    if ($product) {
                        array_push($basket_show, ['product' => $product, 'model' => 0, 'number' => $val->number, 'order_code' => (int)$order_code]);
                    }
                }
            }

            if (count($basket_show) > 0) {
                foreach ($basket_show as $value) {
//                dd(isset($value['model']->id));
                    if (isset($value['model']->id)) {
                        array_push($model_id, $value['model']->id);
                        if ($value['model']->price_vip > 0) {
                            $total_price += $value['model']->price_vip * (int)$value['number'];
                            $all_price += $value['model']->price * (int)$value['number'];
                        } else {
                            $total_price += $value['model']->price * (int)$value['number'];
                            $all_price += $value['model']->price * (int)$value['number'];
                        }
                    } else {
//                    dd($value['product']);
                        array_push($product_id, $value['product']->id);
                        if ($value['product']->vip_default > 0) {
                            $total_price += $value['product']->vip_default * (int)$value['number'];
                            $all_price += $value['product']->price_default * (int)$value['number'];
                        } else {
                            $total_price += $value['product']->price_default * (int)$value['number'];
                            $all_price += $value['product']->price_default * (int)$value['number'];
                        }
                    }


                }
            }
        }
        return [$basket_show, $total_price, $all_price, $model_id, $product_id];
    }

    public
    function level_1()
    {
        if (Auth::check()) {
            if (auth()->user()->mobile_status == 'pending') {
                return redirect()->back()->with('err_message', 'Lütfen kaydınızı tamamlayın');
            }
        }
        $getBasketArray = $this->getBasket();
//    dd($getBasketArray);

        $basket = $getBasketArray[0];
        $total_price = $getBasketArray[1];
        $all_price = $getBasketArray[2];
        $discount_price = $all_price - $total_price;
        $model_id = $getBasketArray[3];
        $product_id = $getBasketArray[4];
        $factor_id = Basket::whereIn('model_id', $model_id)->orderBy('id', 'desc')->select('factor_id')->get()->toArray();
//    dd($factor_id);
        $products = [];
        if (count($factor_id) > 0) {
            $models_id = Basket::whereIn('factor_id', $factor_id)->whereNotIn('model_id', $model_id)->select('model_id')->get()->toArray();
            if (count($models_id) > 0) {
                $products = Modale::whereIn('id', $models_id)->orderBy('id', 'desc')->take(20)->get();
            }
        }
//    dd($basket);
        return view('front.basket.level_1', compact('products', 'basket', 'total_price', 'discount_price', 'all_price'));
    }

    public
    function add_basket($p_id, $m_id, Request $request)
    {
        if ($m_id != 0) {
            $model = Modale::where('id', $m_id)->where('status', 1)->first();
            // not product
            if (!$model || !$model->product) {
                return redirect()->back()->with('err_message', 'Ürün bulunamadı');
            }
            // inventory <= 0
            if ($model->inventory <= 0) {
                return redirect()->back()->with('err_message', 'Bu ürün modeli mevcut değil');
            }
            if (isset($request->num) && intval($request->num) > 1) {
                if ($model->inventory < intval($request->num)) {
                    return redirect()->back()->with('err_message', 'Bu ürün modelinin stoğu, seçtiğiniz sayının altında');
                }
            }
        } else {
            $product = Product::where('id', $p_id)->first();
            // product have model
            if ($product->model_have == 'yes') {
                return redirect()->back()->with('err_message',
                    'Bu ürünün bir modeli var, modellerden birini seçin');
            }
            // not product
            if (!$product) {
                return redirect()->back()->with('err_message', 'Ürün bulunamadı');
            }
            // inventory <= 0
            if ($product->inventory_default <= 0) {
                return redirect()->back()->with('err_message', 'Bu ürün modeli mevcut değil');
            }
            if (isset($request->num) && intval($request->num) > 1) {
                if ($product->inventory < intval($request->num)) {
                    return redirect()->back()->with('err_message',
                        'Bu ürün modelinin stoğu, seçtiğiniz sayının altında');
                }
            }
        }

        $basket = Cookie::get('basket');
        $order_code = 0;
        try {
            if (!Cookie::has('order_code')) {
                $order_code = time();
                Cookie::queue('order_code', $order_code, 60);
            } else {
                $order_code = Cookie::get('order_code');
            }
            if (!Cookie::has('basket')) {
                $basket_show = [];
                $basket_num = 1;
                if (isset($request->num) && intval($request->num) > 1) {
                    $basket_num = intval($request->num);
                }
                array_push($basket_show, ['product' => $p_id, 'model' => $m_id, 'number' => $basket_num, 'order_code' => (int)$order_code]);
                Cookie::queue('order_code', $order_code, 60);
                Cookie::queue('basket', json_encode($basket_show), 60);
            } else {
                $basket = json_decode($basket);
                $exist = false;
                foreach ($basket as $value) {
                    if ($value->product == $p_id and $value->model == $m_id) {
                        $exist = true;
                    }
                }
                if (!$exist) {
                    $basket_num = 1;
                    if (isset($request->num) && intval($request->num) > 1) {
                        $basket_num = intval($request->num);
                    }
                    array_push($basket, ['product' => $p_id, 'model' => $m_id, 'number' => $basket_num, 'order_code' => (int)$order_code]);
                    Cookie::queue('basket', json_encode($basket), 60);
                    return redirect()->back()->with('flash_message',
                        'Ürün sepetinize eklenmiştir');
                } else {
                    return redirect()->back()->with('err_message',
                        ' Ürün zaten sepetinizde');
                }
            }
            return redirect()->back()->with('flash_message', 'Ürün sepetinize eklendi');
        } catch (Exception $e) {
            return redirect()->back()->with('err_message', 'Sepete eklenirken bir hata oluştu');
        }
    }

    public
    function del_basket($id, $p_id)
    {
        try {
            if (Cookie::has('basket')) {
//                dd(Cookie::get('basket'));
                $basket = json_decode(Cookie::get('basket'));
                $remove = false;
//                dd($basket);
                foreach ($basket as $key => $value) {
                    if ($value->model == $id and $value->product == $p_id) {
                        if (count($basket) <= 1) {
                            $basket = [];
                        } else {
                            unset($basket[$key]);
                        }
                        $remove = true;
                    }
                }
//                dd(json_decode(json_encode($basket)));
                if ($remove) {
                    $arry_basket = [];
                    foreach ($basket as $bask) {
                        array_push($arry_basket, ['product' => $bask->product, 'model' => $bask->model, 'number' => $bask->number, 'order_code' => $bask->order_code]);
                    }
//                    dd(json_decode(json_encode($arry_basket)));
                    Cookie::queue('basket', json_encode($arry_basket), 60);
                    return redirect()->back()->with('flash_message', 'Ürün alışveriş sepetinden kaldırıldı');
                } else {
                    return redirect()->back()->with('err_message', 'Ürün bulunamadı');
                }
            } else {
                return redirect()->back()->with('err_message', 'Sepetiniz boş');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('err_message', 'Ürün alışveriş sepetinden çıkarılırken bir hata oluştu');
        }
    }

    public
    function update_basket($product_id, $id, $num)
    {
        try {
            $basket = [];
            $baskets = json_decode(Cookie::get('basket'));
            $num_true = true;
            $order_code = 0;
            if (!Cookie::has('order_code')) {
                $order_code = time();
                Cookie::queue('order_code', $order_code, 60);
            } else {
                $order_code = Cookie::get('order_code');
            }
            foreach ($baskets as $key => $value) {
                if ($value->model != 0) {
                    $model = Modale::where('id', $value->model)->where('status', 1)->first();
                    if (!is_null($model)) {
                        if ($id == $model->id) {
                            if ($model->inventory >= $num) {
                                array_push($basket, ['product' => $product_id, 'model' => $model->id, 'number' => $num, 'order_code' => (int)$order_code]);
                            } else {
                                array_push($basket, ['product' => $product_id, 'model' => $model->id, 'number' => $value->number, 'order_code' => (int)$order_code]);
                                $num_true = false;
                            }
                        } else {
                            array_push($basket, ['product' => $product_id, 'model' => $model->id, 'number' => $value->number, 'order_code' => (int)$order_code]);
                        }
                    }

                } else {
                    $product = Product::where('id', $value->product)->first();
//                dd($product);
                    if (!is_null($product)) {
                        if ($product_id == $product->id) {
                            if ($product->inventory_default >= $num) {
                                array_push($basket, ['product' => $product_id, 'model' => $id, 'number' => $num, 'order_code' => (int)$order_code]);
                            } else {
                                array_push($basket, ['product' => $product_id, 'model' => $id, 'number' => $value->number, 'order_code' => (int)$order_code]);
                                $num_true = false;
                            }
                        } else {
                            array_push($basket, ['product' => $product_id, 'model' => $id, 'number' => $value->number, 'order_code' => (int)$order_code]);
                        }
                    }
                }

            }
            if (!$num_true) {
                return redirect()->back()->with('err_message',
                    'Ürün envanteri, seçtiğiniz sayıdan az');
            }
            Cookie::queue('basket', json_encode($basket), 60);
            return redirect()->back()->with('flash_message', 'Sepet başarıyla güncellendi');
        } catch (Exception $e) {
            return redirect()->back()->with('err_message',
                'Sepetinizi güncellerken bir hata oluştu. Lütfen tekrar deneyin');
        }
    }

    public
    function level_2()
    {
        if (!Auth::check()) {
            return redirect()->back()->with('err_message', 'Alışverişe devam etmek için lütfen giriş yap / kayıt ol');
//        return redirect()->back()->with('err_message', 'جهت ادامه خرید لطفا وارد شوید/ثبت نام کنید');
        }
        $getBasketArray = $this->getBasket();
        $basket = $getBasketArray[0];
        if (count($basket) <= 0) {
            return redirect()->route('front.level_1')->with('err_message', 'Sepetiniz boş');
//        return redirect()->route('front.level_1')->with('err_message', 'سبد خرید شما خالی می باشد');
        }
        $model_id = $getBasketArray[3];
        $factor_id = Basket::whereIn('model_id', $model_id)->orderBy('id', 'desc')->select('factor_id')->get()->toArray();
        $products = [];
        if (count($factor_id) > 0) {
            $models_id = Basket::whereIn('factor_id', $factor_id)->whereNotIn('model_id', $model_id)->select('model_id')->get()->toArray();
            if (count($models_id) > 0) {
                $products = Modale::whereIn('id', $models_id)->orderBy('id', 'desc')->take(20)->get();
            }
        }
        $setting = Setting::find(1);
        $total_price = $getBasketArray[1];
//    $states = ProvinceCity::where('parent_id', null)->orderBy('id', 'asc')->get();
        $factor = null;
        $factor = Factor::where('user_id', Auth::user()->id)->where('status', 1)->where('reserv', 'active')->first();
        $states = City::where('state_id', null)->orderBy('id', 'asc')->get();
        return view('front.basket.level_2', compact('products', 'setting', 'total_price', 'states', 'factor'));
    }

    function set_address(Request $request)
    {
        $address = auth()->user()->addresses->where('id', $request->address_val)->first();
        if ($address == null) {
            return redirect()->back()->with('err_message',
                'Adres seçilirken bir sorun oluştu. Lütfen tekrar deneyin');
        } else {

        }
    }

    public function address_set(Request $request)
    {
        $this->validate($request, [
            'f_name' => 'required|max:191',
            'l_name' => 'required|max:191',
            'address_name' => 'required|max:255',
            'state' => 'required',
            'city' => 'required',
            'loc' => 'required',
            'address' => 'required',
        ], [
            'f_name.required' => 'Gerekli adı girin',
            'f_name.max' => 'İsimdeki karakter sayısı uzun',
            'l_name.required' => 'Soyadı girin gerekli',
            'l_name.max' => 'Soyadındaki karakter sayısı uzun',
            'address_name.required' => 'Gerekli adresin adını girin',
            'address_name.max' => 'Adres adındaki karakter sayısı uzun',
            'state.required' => 'İl girmek zorunludur',
            'city.required' => 'Şehri girin gerekli',
            'loc.required' => 'Gerekli alanı girin',
            'address.required' => 'Gerekli adresi girin',

        ]);
        // insert address
        try {
            $address = new Address();
            $address->first_name = $request->f_name;
            $address->last_name = $request->l_name;
            $address->address_name = $request->address_name;
            $address->state_id = $request->state;
            $address->city_id = $request->city;
            $address->district_id = $request->loc;
            $address->address = $request->address;
            $address->tell = $request->tell;
            $address->user_id = auth()->user()->id;
            $address->save();
            return redirect()->back()->with('flash_message', 'Adresi kaydederken bir hata oluştu. Lütfen tekrar deneyin.');

        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('err_message', 'Adresi kaydederken bir hata oluştu. Lütfen tekrar deneyin.');
//            return redirect()->back()->with('err_message', 'در ثبت آدرس خطایی رخ داده، مجددا امتحان کنید');
        }

    }

    public function address_del($id)
    {
        $address = Address::find($id);
        try {
            $address->delete();
//            return redirect()->back()->with('flash_message', 'حذف آدرس انجام شد');
            return redirect()->back()->with('flash_message', 'Adres silme işlemi yapıldı');
        } catch (\Exception $e) {
            return redirect()->back()->with('err_message', 'Adres silinirken bir hata oluştuysa lütfen tekrar deneyin');
//            return redirect()->back()->with('err_message', 'در حذف خطایی رخ داده، مجددا امتحان کنید');
        }
    }

    public
    function type_send(Request $request)
    {
        $address = auth()->user()->addresses->where('id', $request->address_val)->first();
        if ($address == null) {
            return redirect()->back()->with('err_message',
                'Adres seçilirken bir sorun oluştu. Lütfen tekrar deneyin');
        }
//        $factor = Factor::where('user_id', Auth::user()->id)->where('status', 1)->where('reserv', 'active')->first();
//        if (isset($factor)) {
//            return redirect()->route('front.level_3', $factor->order_code)->with('flash_message', 'خرید خود را ثبت نهایی کنید');
//        }
//        $setting = Setting::find(1);
        $getBasketArray = $this->getBasket();
        $baskets = $getBasketArray[0];
        $user = Auth::user();
        $orderCode = time() . $user->id;
        $all_price = $getBasketArray[1];
//        if (Auth::user()->state == 14 && Auth::user()->city == 587) {
//            if ($all_price >= $setting->send1) {
//                $post_price = 0;
//            } else {
//                $send_type = $request->send_type;
//                $post_price = $setting->$send_type;
//            }
//        } else {
//            if ($all_price >= $setting->send2) {
//                $post_price = 0;
//            } else {
//                $send_type = $request->send_type;
//                $post_price = $setting->$send_type;
//            }
//        }

        $post_price = 0;

        $count = 0;
        if (count($baskets) <= 0) {
            return redirect()->route('front.level_1')->with('err_message',
                'Ürün sepetinizde yok');
        }
        $old_factor = Factor::where('user_id', $user->id)->where('status', 0)->get();
        if (count($old_factor) > 0) {
            foreach ($old_factor as $value) {
                $value->delete();
            }
        }
//        if ($request->address_set == 'yes') {
//            $this->validate($request, [
//                'first_name' => 'required|max:191',
//                'last_name' => 'required|max:191',
//                'mobile' => 'required|regex:/(09)[0-9]{9}/|digits:11|numeric',
//                'state_id' => 'required',
//                'city_id' => 'required',
//                'address' => 'required',
//                'postcode' => 'nullable|regex:/[0-9]{10}/|digits:10|numeric',
//            ]);
//        }
        // insert factor ddddddd
        try {
            $factor = new Factor();
            $factor->order_code = $orderCode;
            $factor->user_id = $user->id;
            $factor->address_id = $address->id;
            $factor->fname = $address->first_name;
            $factor->lname = $address->last_name;
            $factor->state = $address->state_id;
            $factor->city = $address->city_id;
            $factor->address = $address->address;
//            $factor->postcode = $user->postcode;
            $factor->mobile = $address->tell;
            $factor->email = $user->email;
            $factor->send_type = $request->send_type;
            $factor->total_price = Tl(intval($all_price) + intval($post_price));
            $factor->post_price = $post_price;
            $factor->save();
            return redirect()->route('front.level_3', $orderCode)->with('flash_message',
                'Satın alma işleminizi tamamlayın');
        } catch (\Exception $e) {
            return redirect()->back()->with('err_message',
                'Lütfen fatura kaydedildiğinde tekrar deneyin');
        }

    }

    public function level_3($order_code)
    {

        $getBasketArray = $this->getBasket();
        $user = Auth::user();
        $basket = $getBasketArray[0];
        $all_price = $getBasketArray[1];
        $reserv = 'pending';
        if (count($basket) <= 0) {
            return redirect()->route('front.level_1')->with('err_message', 'سبد خرید شما خالی می باشد');
        }
        $factor = Factor::where('order_code', $order_code)->where('user_id', $user->id)->first();
        if (!$factor) {
            return redirect()->route('front.level_2')->with('err_message', 'مشکلی رخ داده، مجددا تلاش بفرمایید');
        }
        if ($factor->reserv == 'active' && $factor->status == 1) {
            $reserv = 'active';
        }
        $setting = Setting::find(1);
        return view('front.basket.level_3', compact('factor', 'reserv', 'basket', 'all_price', 'setting'));
    }

    public
    function off_code_check($off_code, $total)
    {
        $off = Off::where('code', $off_code)->first();
        if ($off) {
            $factor = Factor::where('user_id', auth()->user()->id)->where('off_code', $off_code)->where('status', '>', 0)->get();
            if (count($factor) > 0) {
                return 'no';
            }
            $total = $total - $off->persent;
            return $total;
        }
        return 0;
    }

    public
    function end_basket($order_code, Request $request)
    {
        $old_baskets = Basket::where('order_code', $order_code)->where('user_id', Auth::user()->id)->where('status', 0)->get();
        foreach ($old_baskets as $old_basket) {
            $old_basket->delete();
        }
        $total = 0;
        $percent = null;
        $off_code = null;
        $getBasketArray = $this->getBasket();
        $baskets = $getBasketArray[0];
        $all_price = $getBasketArray[1];
        if (count($baskets) <= 0) {
            return redirect()->route('front.level_1')->with('err_message',
                'Sepetiniz boş');
        }
        $user = Auth::user();
        $factor = Factor::where('order_code', $order_code)->where('user_id', $user->id)->where('status', 0)->first();
        if (!$factor) {
            return redirect()->route('front.level_2')->with('err_message',
                'Bir sorun oldu, lütfen tekrar deneyin');
        }
//        //off code check
//        if (!$factor_reserv) {
//            $off = Off::where('code', $request->off_code)->first();
//            if ($off) {
//                $factors = Factor::where('user_id', auth()->user()->id)->where('off_code', $request->off_code)->where('status', '>', 0)->get();
//                if (count($factors) <= 0) {
//                    $total = $all_price - $off->persent;
//                    $total += $factor->post_price;
//                    $off_code = $off->code;
//                    $percent = $off->persent;
//                }
//            }
//        }
        //insert basket
        foreach ($baskets as $basket) {
            if (isset($basket['model']->id)){
                $model = Modale::find($basket['model']->id);
                if (is_null($model)) {
//                محصولی از سبد خرید شما یافت نشد لطفا سبد خرید خود را حذف و مجددا ثبت نمایید
                    return redirect()->back()->with('err_message',
                        'Sepetinizde ürün bulunamadı. Lütfen sepetinizi silin ve yeniden kayıt olun');
                }
                if ($model->inventory < $basket['number'] || $model->inventory == 0) {
                    return redirect()->back()->with('err_message',
                        $model->product->title . ' _ ' . $model->type . ':' . $model->type_val . 'ürün envanteri seçtiğiniz sayıdan az');
                }
                try {
                    if ($model->price_vip > 0) {
                        $price = $model->price_vip;
                    }
                    else {
                        $price = $model->price;
                    }

                    $row = new Basket();
                    $row->user_id = $user->id;
                    $row->product_id = $model->product_id;
                    $row->model_id = $model->id;
                    $row->price = TL($price);
                    $row->num = (int)$basket['number'];
                    $row->order_code =  $order_code;
                    $row->factor_id = $factor->id;
                    $row->save();

                }
                catch (\Exception $e) {
                    return redirect()->back()->with('err_message',
                        'Sepeti kaydederken bir hata oluştu, lütfen tekrar deneyin');
                }
            }
            else{
                $product = Product::find($basket['product']->id);
                if (is_null($product)) {
//                محصولی از سبد خرید شما یافت نشد لطفا سبد خرید خود را حذف و مجددا ثبت نمایید
                    return redirect()->back()->with('err_message',
                        'Sepetinizde ürün bulunamadı. Lütfen sepetinizi silin ve yeniden kayıt olun');
                }
                if ($product->inventory_default < $basket['number'] || $product->inventory_default == 0) {
                    return redirect()->back()->with('err_message',
                         $product->title  . 'ürün envanteri seçtiğiniz sayıdan az');
                }
                try {
                    if ($product->vip_default > 0) {
                        $price = $product->vip_default;
                    }
                    else {
                        $price = $product->price_default;
                    }

                    $row = new Basket();
                    $row->user_id = $user->id;
                    $row->product_id = $product->id;
                    $row->model_id = 0;
                    $row->price = TL($price);
                    $row->num = (int)$basket['number'];
                    $row->order_code = $order_code;
                    $row->factor_id = $factor->id;
                    $row->save();

                } catch (\Exception $e) {
                    return redirect()->back()->with('err_message',
                        'Sepeti kaydederken bir hata oluştu, lütfen tekrar deneyin');
                }
            }

        }
        //edame factor
            $factor->pay_mode = $request->pay_mode;
            $factor->off_code = $off_code;
            $factor->persent = $percent;
            if ($total > 0) {
                $factor->total_price = $total;
            }
            $factor->save();



            if ($factor->pay_mode == 'payent') {
                return redirect()->route('front.payent.pay', $factor->id);
            }

//        $reserv = false;
//        if ($factor->reserv == active) {
//            $reserv = true;
//            $factor->reserv = 'pending';
//        }
//        $factor->status = 1;
//        $factor->save();
//
//        foreach ($factor->orders as $value) {
//            $value->status = 1;
//            $value->save();
//
//            if ($value->modale) {
//                $value->modale->inventory = $value->modale->inventory - $value->num;
//                $value->modale->save();
//            }
//
//        }
//        if (Cookie::has('basket')) {
//            Cookie::queue(Cookie::forget('basket'));
//        }
//        if (Cookie::has('order_code')) {
//            Cookie::queue(Cookie::forget('order_code'));
//        }
//        $full_name = $factor->fname . ' ' . $factor->lname;
//        Smsirlaravel::ultraFastSend(['user' => $full_name, 'factor_code' => $factor->order_code], 37980, $factor->user->mobile);
//        if ($reserv == true) {
//            return redirect()->back()->with('flash_message', 'سفارش ثبت شد منتظر تماس همکاران ما باشید، رزرو سفارش فقط برای پرداخت های آنلاین امکان پذیر می باشد');
//        }
//        return redirect()->back()->with('flash_message', 'سفارش ثبت شد منتظر تماس همکاران ما باشید');
    }
}
