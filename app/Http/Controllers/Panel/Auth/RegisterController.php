<?php

namespace App\Http\Controllers\Panel\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function controller_title($type)
    {
        if ($type == 'sum') {
            return 'مشتری ها';
        } elseif ('single') {
            return 'مشتری';
        }
    }

    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function create()
    {
        return view('panel.auth.create' , ['title' => $this->controller_title('sum')]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'last_name'     => 'required|max:255',
            'first_name'    => 'required|max:255',
            'address'       => 'max:255',
            'email'         => 'required|max:255|unique:users',
            'mobile'        => 'numeric|unique:users',
            'password'      => 'required|string|min:8|confirmed',

        ]);

        try {
    
            $user   = User::create([
                'last_name'     => $request->last_name,
                'first_name'    => $request->first_name,
                'address'       => $request->address,
                'email'         => $request->email,
                'mobile'        => $request->mobile,
                'password'      => Hash::make($request->password),
            ]);

            $user->assignRole('کاربر');

            return redirect()->route('index')->with('flash_message', 'مشتری ثبت شد');

        } catch (\Throwable $e) {
            return redirect()->back()->with('err_message','مشگل در ثبت مشتری');
        }

    }
}