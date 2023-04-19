<?php

namespace App\Http\Controllers\Panel\Basket;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Factor;
use App\Models\Basket;
use App\Models\Modale;

class BasketController extends Controller
{
    public function controller_title($type)
    {
        if ($type == 'sum') {
            return 'فاکتور ها';
        } elseif ('single') {
            return 'فاکتور';
        }
    }

    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function create()
    {
        $users      = User::all(['id','first_name','last_name']);
        $products   = Product::all(['id','title','price_default','vip_default','vip_status']);
        foreach ($products as $product) {
            $product->price                                 = $product->price_default;
            if ($product->vip_default > 0) $product->price  = $product->vip_default;
        }
        return view('panel.basket.create' ,compact('users','products') , ['title' => $this->controller_title('sum')]);
    }

    public function store(Request $request) {

        // $this->validate($request, [
        //     'last_name'     => 'required|max:255',
        //     'first_name'    => 'required|max:255',
        //     'address'       => 'max:255',
        //     'email'         => 'required|max:255|unique:users',
        //     'mobile'        => 'numeric|unique:users',
        //     'password'      => 'required|string|min:8|confirmed',
        // ]);

        $user       = User::find($request->user_id);
        $address    = $user->addresses->first();
        if ($address===null) return redirect()->back()->with('err_message','müşteri adresi bulunamadı');

        try {

            $list   = [];
            $sum_rice   = 0;
            for ($i=1; $i <= intVal($request->total); $i++) {
                $p_id   = 'p_id'.$i;

                if ($request->$p_id) {
                    array_push($list, $request->$p_id);
                }
            }

            $products   = Product::whereIn('id', $list)->get();
            foreach ($products as $product) {
                $product->price                                 = $product->price_default;
                if ($product->vip_default > 0) $product->price  = $product->vip_default;
            }

            for ($i=1; $i <= intVal($request->total); $i++) {
                $p_id   = 'p_id'.$i;
                $c_id   = 'c_id'.$i;

                if ($request->$p_id) {
                    $first      = $products->where('id', $request->$p_id)->first();
                    $sum_rice   += $first->price * $request->$c_id;
                }
            }

            $factor = new Factor();
            $factor->pay_mode       = $request->pay_mode;
            $post_price             = $request->post_price;
            $all_price              = $sum_rice;

            $factor->address_id     = $address->id;
            $factor->fname          = $address->first_name;
            $factor->lname          = $address->last_name;
            $factor->state          = $address->state_id;
            $factor->city           = $address->city_id;
            $factor->address        = $address->address;
            $factor->mobile         = $address->tell;

            $factor->order_code     = time() . $user->id;
            $factor->user_id        = $user->id;
            $factor->postcode       = $user->postcode;
            $factor->email          = $user->email;
            $factor->send_type      = $request->send_type;
            $factor->total_price    = Tl(intval($all_price) + intval($post_price));
            $factor->post_price     = intVal($post_price);
            $factor->status         = 1;
            $factor->pay_status     = 1;
            $factor->save();

            $old_baskets = Basket::where('order_code', $factor->order_code)->where('user_id', $user->id)->where('status', 0)->get();
            foreach ($old_baskets as $old_basket) $old_basket->delete();

            for ($i=1; $i <= intVal($request->total); $i++) {
                $c_id   = 'c_id'.$i;
                $p_id   = 'p_id'.$i;
                if ($request->$p_id) {
                    $product            = $products->where('id', $request->$p_id)->first();
                    $row                = new Basket();
                    $row->user_id       = $user->id;
                    $row->product_id    = $product->id;
                    $row->model_id      = 0;
                    $row->price         = TL($product->price);
                    $row->num           = intVal($request->$c_id);
                    $row->order_code    = $factor->order_code;
                    $row->factor_id     = $factor->id;
                    $row->save();
                }
            }
            return redirect('/panel')->with('flash_message', 'Fatura kaydedildi');
        } catch (\Throwable $e) {
            return redirect()->back()->with('err_message','Fatura kaydedilirken sorun oluştu');
        }

    }
}