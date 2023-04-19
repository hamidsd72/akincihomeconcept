<?php namespace App\Http\Controllers\Panel;

use App\Models\Activity;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ItemsHelper;
use App\Models\Basket;
use App\Models\Order;
use App\Models\User;
use App\Models\Register;
use App\Models\Factor;
use App\Models\Verify;
use Carbon\Carbon;
use App\Imports\OrderPostImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FactorsExport;
use App\Exports\FactorDateExport;

class BasketController extends Controller
{    // Construct Function
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $names = Factor::where('fname', '!=', null)->select(['fname', 'lname'])->get();
        $user = Auth::user();
        if ($user->hasRole('کاربر') || !count(auth()->user()->roles)) {
            return redirect()->route('order-list')->with(['title' => 'ttt']);
        }
        $factors = Factor::where('status', 1)->where('reserv','pending')->orderBy('created_at', 'DESC')->paginate(20);
        return view('panel.orders.index', compact('factors', 'names'), ['title' => 'سبد خرید کاربران']);
    }
    public function index_reserv()
    {
        $user = Auth::user();
        if ($user->hasRole('&#1705;&#1575;&#1585;&#1576;&#1585;') || !count(auth()->user()->roles)) {
            return redirect()->route('order-list')->with(['title' => '&#1587;&#1601;&#1575;&#1585;&#1588;&#1575;&#1578;']);
        }
        $factors = Factor::where('status', 1)->where('reserv','active')->orderBy('created_at', 'DESC')->paginate(20);
        return view('panel.orders.reserv', compact('factors'), ['title' => 'سبد خرید رزرو شده کاربران']);
    }

    public function draftWait()
    {
//        dd(Factor::all());
//        $names = Factor::groupBy('mobile')->where('fname', '!=', null)->select('fname', 'lname')->get();
//        dd($names);
        $factors = Factor::where('status', 2)->orderBy('created_at', 'DESC')->paginate(20);
        return view('panel.orders.draftWait', compact('factors'), ['title' => 'سبد خرید کاربران']);
    }

    public function sendFactor()
    {
//        $names = Factor::groupBy('mobile')->where('fname', '!=', null)->select(['fname', 'lname'])->get();
        $factors = Factor::where('status', 3)->orderBy('created_at', 'DESC')->paginate(20);
        return view('panel.orders.send', compact('factors'), ['title' => 'سبد خرید کاربران']);
    }

    public function giveFactor()
    {
//        $names = Factor::groupBy('mobile')->where('fname', '!=', null)->select(['fname', 'lname'])->get();
        $factors = Factor::where('status', 4)->orderBy('created_at', 'DESC')->paginate(20);
        return view('panel.orders.give', compact('factors'), ['title' => 'سبد خرید کاربران']);
    }

    public function cancelFactors()
    {
//        $names = Factor::groupBy('mobile')->where('fname', '!=', null)->select(['fname', 'lname'])->get();
        $factors = Factor::where('status', -1)->orderBy('created_at', 'DESC')->paginate(20);
        return view('panel.orders.cancel', compact('factors'), ['title' => 'سبد خرید کاربران']);
    }

    public function allFactor()
    {
//        $names = Factor::groupBy('mobile')->where('fname', '!=', null)->select(['fname', 'lname'])->get();
        $factors = Factor::orderBy('created_at', 'DESC')->paginate(20);
        return view('panel.orders.all', compact('factors'), ['title' => 'سبد خرید کاربران']);
    }

    public function backPay()
    {
//        $names = Factor::groupBy('mobile')->where('fname', '!=', null)->select(['fname', 'lname'])->get();
        $factors = Factor::where('pay_mode', 'melat')->where('pay_status', 0)->where('status', 0)->orderBy('created_at', 'DESC')->paginate(20);
        return view('panel.orders.backpay', compact('factors'), ['title' => 'سبد خرید کاربران']);
    }

    public function no_pay()
    {
//        $names = Factor::groupBy('mobile')->where('fname', '!=', null)->select(['fname', 'lname'])->get();
        $factors = Factor::where('pay_mode', 'melat')->where('pay_status', 0)->where('status', 1)->orderBy('created_at', 'DESC')->paginate(20);
        return view('panel.orders.no_pay', compact('factors'), ['title' => 'سبد خرید کاربران']);
    }


    public function factor_print($id)
    {
        $factor = Factor::where('id', $id)->first();
        return view('panel.orders.chap', compact('factor'), ['title' => 'چاپ فاکتور']);

    }
    public function factor_print_all(Request $request)
    {

        $facror_id=explode('-',$request->factor_id);
        $factors = Factor::whereIn('id', $facror_id)->get();
        return view('panel.orders.chaps', compact('factors'), ['title' => 'چاپ گروهی اطلاعات پستی']);

    }

    public function factor_show($id)
    {
        $factor = Factor::where('id', $id)->first();
        if($factor->status==1 && $factor->reserv=='active')
        {
            $start = Carbon::parse($factor->created_at);
            $end=Carbon::now();
            $hours = $end->diffInMinutes($start);
            $min=2880-$hours;
            $h=floor($min/60);
            $m=round($min%60);
        }
        $baskets = Basket::where('order_code', $factor->order_code)->get();
        return view('panel.orders.factor', compact('baskets', 'factor'), ['title' => 'نمایش فاکتور']);
    }
    public function factor_send_reserv($id)
    {
        $factor = Factor::where('id', $id)->first();
        $factor->reserv='pending';
        $factor->update();
        return redirect()->back()->with('flash_message','سفارش در حالت ارسال قرار گرفت');
    }

    public function all()
    {
        $baskets = Basket::where('status', 3)->get();
        return view('panel.orders.all', compact('baskets'), ['title' => 'سفارشات تحویل داده شده']);
    }

    public function confirm($id)
    {
        try {
            $item = Factor::find($id);

            $item->status = 2;

            $item->save();

            return redirect()->back()->with('flash_message', 'انتقال به حواله انبار با موفقیت انجام شد');

        } catch (\Exception $e) {


            return redirect()->back()->with('err_message', 'خطلایی رخ داده است، لطفا مجددا تلاش نمایید');

        }
    }

    public function confirm_all(Request $request)
    {
        if ($request->factor_id != null) {
            $factors_id = explode('-', $request->factor_id);
            $factors = Factor::whereIn('id', $factors_id)->get();
            $error = false;
            foreach ($factors as $factor) {
                try {
                    $factor->status = 2;

                    $factor->save();

                } catch (\Exception $e) {
                    $error = true;
                }
            }

            if ($error == false) {

                return redirect()->back()->with('flash_message', 'انتقال به حواله انبار با موفقیت انجام شد');

            }
            else {


                return redirect()->back()->with('err_message', 'خطلایی رخ داده است، لطفا مجددا تلاش نمایید');

            }
        }else{
            return redirect()->back()->with('err_message', 'خطائی رخ داد');

        }
    }

        public
        function okay($id)
        {
            try {
                $item = Factor::find($id);
                $item->status = 4;
                $item->save();
                return redirect()->back()->with('flash_message', 'سفارش مورد نظر در وضعیت تحویل به مشتری قرار داده شد');
            } catch (\Exception $e) {
                return redirect()->back()->with('err_message', 'خطلایی رخ داده است، لطفا مجددا تلاش نمایید');
            }
        }

        public
        function basket_return($id)
        {
            try {

                $item = Factor::find($id);
                if ($item->status==1){
                    $baskets = Basket::where('order_code', $item->order_code)->get();
                    foreach ($baskets as $basket) {
                        if ($basket->model!=null){
                            $basket->modale->inventory += $basket->num;
                            $basket->modale->update();
                        }else{
                            $basket->product->inventory_default +=$basket->num;
                            $basket->product->update();

                        }


                    }

                    $item->status = -1;
                    $item->save();
                }



                return redirect()->back()->with('flash_message', 'سفارش مورد نظر با موفقیت لغو شد');
            } catch (\Exception $e) {
                return redirect()->back()->with('err_message', 'خطلایی رخ داده است، لطفا مجددا تلاش نمایید');
            }
        }

        public
        function basket_re_run($id)
        {
            try {
                $item = Factor::find($id);
                $baskets = Basket::where('order_code', $item->order_code)->get();
                foreach ($baskets as $basket) {
                    if ($basket->modale->inventory < $basket->num) {
                        return redirect()->back()->with('err_message', 'موجودی برای تایید این فاکتور کافی نمی باشد');
                    }
                }
                foreach ($baskets as $basket) {
                    $basket->modale->inventory -= $basket->num;
                    $basket->modale->save();
                }
                foreach ($item->orders as $order) {
                    $order->status = 3;
                    $order->save();
                }
                $item->status = 3;
                $item->save();
                $order = Order::create(['factor_id' => $id, 'status' => 0,]);
                return redirect()->back()->with('flash_message', 'سفارش تایید شد');
            } catch (\Exception $e) {
                return redirect()->back()->with('err_message', 'خطلایی رخ داده است، لطفا مجددا تلاش نمایید');
            }
        }

        public
        function user_info($id)
        {
            $item = User::find($id);
            return view('panel.orders.user_info', compact('item'), ['title' => 'اطلاعات کاربر']);
        }

        public
        function destroy($id)
        {
            $category = Basket::findOrFail($id);
            try {
                $category->delete();
                return redirect()->route('basket-all')->with('flash_message', 'با موفقیت حذف شد.');
            } catch (\Exception $e) {
                return redirect()->back();
            }
        }

        public
        function excel()
        {
            return Excel::download(new FactorsExport, 'basketsFromFirst.xlsx');
        }

        public
        function postImport(Request $request)
        {
            $file = file_store($request->postExcel, 'includes/asset/uploads/product/excel/', 'excel-');
            Excel::import(new OrderPostImport, $file);
            return redirect()->back()->with('flash_message', 'با موفقیت ثبت شد.');
        }

        public
        function factor_delivery(Request $request, $id)
        {

            $factor = Factor::where('id', $id)->first();

            if (isset($request->delivery_id) && !is_null($request->delivery_id)) {
                $factor->delivery_id = $request->delivery_id;
                $factor->check_status_post = null;
                $factor->status = 2;
                $factor->update();

                return redirect()->back()->with('flash_message', 'اطلاعات با موفقیت ثبت و ارسال شد');

            }

            if (isset($request->check_status_post) && !is_null($request->check_status_post)) {
                $factor->check_status_post = $request->check_status_post;
                $factor->delivery_id = null;
                $factor->status = 2;
                $factor->update();

                return redirect()->back()->with('flash_message', 'اطلاعات با موفقیت ثبت و ارسال شد');

            }


            return redirect()->back()->with('err_message', 'لظفا یک مورد را انتخاب کنید');


        }

        public
        function search(Request $request)
        {
//            $names = Factor::groupBy('mobile')->where('fname', '!=', null)->select(['fname', 'lname'])->get();
            $name = explode(" ", $request->search1);
            $factor = $request->search2;
            $cod = $request->search3;
            $mobile = $request->mobile;

            $factors=Factor::orderBy('id','desc')->where('reserv','pending');
            if($request->search1!=null && $request->search1!='')
            {
                if(count($name)>1)
                {
                    $factors=$factors->where('fname', 'LIKE', '%' . $name[0] . '%')->where('lname', 'LIKE', '%' . $name[1] . '%');
                }
                else
                {
                    $factors=$factors->where('fname', 'LIKE', '%' . $name[0] . '%')->where('lname', 'LIKE', '%' . $name[0] . '%');
                }
            }
            if($factor!=null && $factor!='')
            {
                $factors=$factors->where('order_code', $factor);
            }
            if($cod!=null && $cod!='')
            {
                $verify = Verify::where('tracing_code', $cod)->first();
                if (!$verify) {
                    $verify = Verify::where('refid', $cod)->first();
                }
                if (!$verify) {
                    $verify = Verify::where('transaction_id', $cod)->first();
                }
                if ($verify)
                {
                    $factors=$factors->where('id', $verify->factor_id);
                }
            }
            if($mobile!=null && $mobile!='')
            {
                $factors=$factors->where('mobile', $mobile);
            }
//            if($from_d!=null)
//            {
//                $factors=$factors->whereDate('created_at','>=', $from_d);
//            }
//            if($to_d!=null)
//            {
//                $factors=$factors->whereDate('created_at','<=', $to_d);
//            }
            $factors=$factors->paginate(30);
//            if ($cod != null) {
//                $factors = [];
//                $verify = Verify::where('tracing_code', $cod)->first();
//                if (!$verify) {
//                    $verify = Verify::where('refid', $cod)->first();
//                }
//                if ($verify) {
//                    $factors = Factor::where('order_code', $verify->factor_id)->orderBy('created_at', 'DESC')->paginate(30);
//                    $factors = $factors->appends(Input::except('page'));
//                }
//                return view('panel.orders.index', compact('factors', 'names', 'mobile'), ['title' => 'سبد خرید کاربران']);
//            } elseif ($factor != null) {
//                $factors = Factor::where('order_code', $factor)->orderBy('created_at', 'DESC')->paginate(30);
//                $factors = $factors->appends(Input::except('page'));
//                return view('panel.orders.index', compact('factors', 'names', 'mobile'), ['title' => 'سبد خرید کاربران']);
//            } elseif ($mobile != null) {
//                $factors = Factor::where('mobile', $mobile)->orderBy('created_at', 'DESC')->paginate(30);
//                $factors = $factors->appends(Input::except('page'));
//                return view('panel.orders.index', compact('factors', 'names', 'mobile'), ['title' => 'سبد خرید کاربران']);
//            } else {
//                if (count($name) > 1) {
//                    $factors = Factor::where('fname', 'LIKE', '%' . $name[0] . '%')->where('lname', 'LIKE', '%' . $name[1] . '%')->orderBy('created_at', 'DESC')->paginate(30);
//                } else {
//                    $factors = Factor::where('fname', 'LIKE', '%' . $name[0] . '%')->orwhere('lname', 'LIKE', '%' . $name[0] . '%')->orderBy('created_at', 'DESC')->paginate(30);
//                }
//            }
//            $factors = $factors->appends(Input::except('page'));
            return view('panel.orders.search', compact('factors', 'mobile'), ['title' => 'سبد خرید کاربران']);
        }

    public function export_date(Request $request)
    {
            $from_d=null;
            $to_d=null;
            if(!is_null($request->from_date))
            {
                $date_from = explode('/',$request->from_date);
                $from_d=my_gdate($date_from[0],$date_from[1],$date_from[2]);
            }
            if(!is_null($request->to_date))
            {
                $date_to = explode('/',$request->to_date);
                $to_d=my_gdate($date_to[0],$date_to[1],$date_to[2]);
            }
        $factors=Factor::orderBy('id','desc')->where('status','>',0);
             if($from_d==null && $to_d==null)
             {
                 return redirect()->back()->with('err_message', 'لظفا یک تاریخ مشخص کنید');
             }
             if($from_d!=null)
            {
                $factors=$factors->whereDate('created_at','>=', $from_d);
            }
            if($to_d!=null)
            {
                $factors=$factors->whereDate('created_at','<=', $to_d);
            }
        $factors=$factors->get();
//        return Excel::download(new FactorsExport($factors), 'basketsFromFirst.xlsx');
//        return (new FactorDateExport($factors))->download('factorsDateBetween.xlsx');
        return Excel::download(new FactorDateExport($factors), 'factorsDateBetween.xlsx');
    }
}