<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Attribute;
use App\Order;
use App\City;
use http\Env\Request;
use Illuminate\Support\Facades\Auth;
use App\Invent;
use Ipecompany\Smsirlaravel\Smsirlaravel;

class PanelController extends Controller
{

    public function controller_title($type)
    {
        if ($type == 'sum') {
            return 'داشبورد';
        } elseif ('single') {
            return 'داشبورد';
        }
    }

    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->hasRole('مدیر')) {
            return view('panel.index', ['title' => $this->controller_title('sum')]);

        } else {
            return redirect()->route('front.level_1');

        }

        if (Auth::check()){
            if(auth()->user()->mobile_status=='pending')
            {
                $user=auth()->user();
                $rand=rand(1000,9999);
                $user->verify_code=$rand;
                $user->update();
                Auth::logout();
                session(['user_id' => $user->id]);
                Smsirlaravel::ultraFastSend(['code' => $rand], 37878 , $user->mobile);
                return redirect()->route('front.verify.code')->with('err_message','حساب کاربری شما فعال نشده است،جهت فعالسازی کد ارسال شده به شماره همراه خود را وارد و حساب خود را تایید کنید');
            }
        }
//        if (Auth::check()){
//            if (auth()->user()->completed==0){
//                return redirect()->route('login-complete');
//            }
//        }


    }

    public function status($id)
    {
        $cities = Attribute::where('id', $id)->get(['id', 'name']);

        $data = Attribute::where('name', $cities[0]->name)->get(['id', 'unit']);
        $options = array();
        foreach ($data as $city) {
            $options += array($city->id => $city->unit);
        }
        return $options;
    }

    public function invent()
    {
        $invents = Invent::latest()->paginate(20);
        return view('panel.invent.index', compact('invents'));
    }

    public function destroy($invent)
    {
        $item = Invent::findOrFail($invent);
        $item->delete();
        return redirect()->back();
    }

    public function city_ajax(Request $request)
    {
//        $id = $request->get('state_id');
//        $items=City::where('state_id',$id)->get();
        $items="sdfsd";
        return response()->json($items);
    }
}
