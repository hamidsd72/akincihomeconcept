<?php


namespace App\Http\Controllers\Front;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\ProvinceCity;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Mockery\Exception;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Ipecompany\Smsirlaravel\Smsirlaravel;

class AuthController extends Controller
{
    
    public function custom_login(Request $request)
    {
        $user   = \App\Models\User::where('email', $request->email)->orWhere('mobile', $request->email)->first();
        if ($user) {
            if ( password_verify( $request->password , $user->password) ) {
                auth()->loginUsingId($user->id, true);
                return redirect()->route('front.level_1');
            }
        }
        $err    = ['E-posta veya cep telefonu yanlış','şifre yanlış'];
        return view('front.auth.index',compact('err'));
    }

    public function auth()
    {
        $states=ProvinceCity::where('parent_id',null)->orderBy('id','asc')->get();
        return view('front.auth.index',compact('states'));
    }
    //verify code register
    public function verify_code()
    {
        if (!session()->has('user_id'))
        {
            abort(403,'شما دسترسی لازم به این صفحه را ندارید');
        }
        $user=User::find(session('user_id'));
        $start = Carbon::parse($user->updated_at);
        $end=Carbon::now();
        $second = $end->diffInSeconds($start);
        $second=120-$second;
        if($second<=0)
        {
            $second=0;
        }
        return view('front.auth.code',compact('second'));
    }
    public function verify_code_retry()
    {
        $user=User::find(session('user_id'));
        $rand=rand(1000,9999);
        $user->verify_code=$rand;
        $user->update();
        Smsirlaravel::ultraFastSend(['code' => $rand], 37878 , $user->mobile);
        return 'ok';
    }
    //register information
    public function register_1(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|max:191',
            'last_name' => 'required|max:191',
            'mobile' => 'required|regex:/(09)[0-9]{9}/|digits:11|numeric|unique:users',
            'email' => 'nullable|email|unique:users',
            'state_id' => 'required',
            'city_id' => 'required',
            'address' => 'required',
            'postcode' => 'nullable|regex:/[0-9]{10}/|digits:10|numeric',
            'password' => 'required|min:8|confirmed',
        ]);
        try {
            $rand=rand(1000,9999);
            $user=new User();
            $user->first_name=$request->first_name;
            $user->last_name=$request->last_name;
            $user->mobile=$request->mobile;
            $user->email=$request->email;
            $user->state=$request->state_id;
            $user->city=$request->city_id;
            $user->address=$request->address;
            $user->postcode=$request->postcode;
            $user->password=$request->password;
            $user->verify_code=$rand;
            $user->save();
            $user->assignRole('کاربر');
            session(['user_id' => $user->id]);
            Smsirlaravel::ultraFastSend(['code' => $rand], 37878 , $request->mobile);
            return redirect()->route('front.verify.code')->with('flash_message','جهت تکمیل ثبت نام مرحله فعالسازی را انجام دهید');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message','مشکلی در ثبت نام رخ داده، مجددا تلاش بفرمایید');
        }
    }
    public function register_2(Request $request)
    {
        if(is_null($request->code_1) || is_null($request->code_2) || is_null($request->code_3) || is_null($request->code_4))
        {
            return redirect()->back()->withInput()->with('err_message','لطفا کد فعالسازی را صحیح وارد کنید');
        }
        $code=$request->code_1.$request->code_2.$request->code_3.$request->code_4;
        try {
           if (session()->has('user_id'))
            {
                $user=User::find(session('user_id'));
            }
            else {
                $user=Auth::user();
            }

            if($code==$user->verify_code)
            {
                $user->mobile_status='active';
                $user->account_status='active';
                $user->registration='complete';
                $user->verified=1;
                $user->completed=1;
                $user->update();
                if (session()->has('user_id'))
                {
                    Auth::loginUsingId($user->id);
                    session()->forget('user_id');
                }
                return redirect()->route('front.index')->with('flash_message','حساب کاربری شما فعال شد');
            }
            else {
                return redirect()->back()->withInput()->with('err_message','کد فعالسازی اشتباه است');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message','مشکلی در فعالسازی رخ داده، مجددا تلاش بفرمایید');
        }
    }

    //password reset level 1
    public function password_get_1()
    {
        return view('front.auth.password.level_1');
    }
    public function password_post_1(Request $request)
    {
        $user=User::where('mobile',$request->mobile)->first();
        if(!$user)
        {
            return redirect()->back()->withInput()->with('err_message','شماره موبایل در لیست اعضا دیجی کلاه ثبت نشده');
        }
        if($user->account_status=='pending' || $user->account_status=='blocked')
        {
            return redirect()->back()->withInput()->with('err_message','اکانت شما فعال نمی باشد، با پشتیبانی تماس حاصل فرمایید ');
        }
        try {
            $rand=rand(1000,9999);
            $user->verify_code=$rand;
            $user->update();
            Smsirlaravel::ultraFastSend(['code' => $rand], 42306 , $user->mobile);
            session(['user_pass_id' => $user->id]);
            session(['user_pass_mobile' => $user->mobile]);
            return redirect()->route('front.password_2')->with('flash_message','کد تایید ارسال شده را وارد نمایید');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message','مشکلی در مرحله 1 فراموشی رمز عبور رخ داده، مجددا تلاش بفرمایید');
        }
    }
    //password reset level 2
    public function password_get_2()
    {
        if (!session()->has('user_pass_id'))
        {
            abort(403,'شما دسترسی لازم به این صفحه را ندارید');
        }
        $user=User::find(session('user_pass_id'));
        $start = Carbon::parse($user->updated_at);
        $end=Carbon::now();
        $second = $end->diffInSeconds($start);
        $second=120-$second;
        if($second<=0)
        {
            $second=0;
        }
        return view('front.auth.password.level_2',compact('second'));
    }

    public function password_post_retry()
    {
        $user=User::find(session('user_pass_id'));
        $rand=rand(1000,9999);
        $user->verify_code=$rand;
        $user->update();
        Smsirlaravel::ultraFastSend(['code' => $rand], 42306 , $user->mobile);
        return 'ok';
    }
    public function password_post_2(Request $request)
    {
        if(is_null($request->code_1) || is_null($request->code_2) || is_null($request->code_3) || is_null($request->code_4))
        {
            return redirect()->back()->withInput()->with('err_message','لطفا کد فعالسازی را صحیح وارد کنید');
        }
        $code=$request->code_1.$request->code_2.$request->code_3.$request->code_4;
        try {
            if (session()->has('user_pass_id'))
            {
                $user=User::find(session('user_pass_id'));
            }
            if($code==$user->verify_code)
            {
                $user->mobile_status='active';
                $user->registration='complete';
                $user->verified=1;
                $user->completed=1;
                $user->update();
                return redirect()->route('front.password_3')->with('flash_message','لطفا رمز عبور جدید خود را تعریف کنید');
            }
            else {
                return redirect()->back()->withInput()->with('err_message','کد تایید اشتباه است');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message','مشکلی در مرحله 2 فراموشی رمز عبور رخ داده، مجددا تلاش بفرمایید');
        }
    }
    //password reset level 3
    public function password_get_3()
    {
        if (!session()->has('user_pass_id'))
        {
            abort(403,'شما دسترسی لازم به این صفحه را ندارید');
        }
        return view('front.auth.password.level_3');
    }
    public function password_post_3(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:8|confirmed',
        ]);
        try {
            if (session()->has('user_pass_id'))
            {
                $user=User::find(session('user_pass_id'));
            }
            $user->password=$request->password;
            $user->update();

            if (session()->has('user_pass_id'))
            {
                session()->forget('user_pass_id');
                session()->forget('user_pass_mobile');
            }
            return redirect()->route('front.auth')->with('flash_message','رمز عبور جدید با موفقیت ایجاد شد');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message','مشکلی در مرحله 3 فراموشی رمز عبور رخ داده، مجددا تلاش بفرمایید');
        }
    }
}
