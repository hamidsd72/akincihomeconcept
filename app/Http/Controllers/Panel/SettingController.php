<?php

namespace App\Http\Controllers\Panel;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{

    public function controller_title($type)
    {
        if ($type == 'sum') {
            return 'تنظیمات';
        } elseif('single') {
            return 'تنظیم';
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
        $settings = Setting::latest()->first();
        return view('panel.settings.index', compact('settings'), ['title' => $this->controller_title('sum')]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($id == 2) {
            $settings = Setting::findOrFail(1);
            try {

                $settings->send_price = $request->send_price;

                $settings->save();

                return redirect()->back()->with('flash_message', 'تنظیمات ذخیره شد.');

            } catch (\Exception $e) {

                return redirect()->back()->withInput();

            }
        } else {
            $settings = Setting::findOrFail($id);
            $this->validate($request, [
                'title' => 'required|max:191',
                'keywords' => 'required|max:191',
                'description' => 'required|max:191',
                'paginate' => 'required|max:191',
                'card_number' => 'required|max:191',

            ]);

            try {

                $settings->title = $request->title;
                $settings->link1 = $request->link1;
                $settings->link2 = $request->link2;
                $settings->keywords = $request->keywords;
                $settings->description = $request->description;
                $settings->paginate = $request->paginate;
                $settings->card_number = $request->card_number;
                if(isset($request->mellat_pay)){ $settings->mellat_pay = 'active'; }
                else { $settings->mellat_pay = 'pending'; }
                if(isset($request->parsian_pay)){ $settings->parsian_pay = 'active'; }
                else { $settings->parsian_pay = 'pending'; }
                if(isset($request->zarinpal_pay)){ $settings->zarinpal_pay = 'active'; }
                else { $settings->zarinpal_pay = 'pending'; }
                if(isset($request->card_number_pay)){ $settings->card_number_pay = 'active'; }
                else { $settings->card_number_pay = 'pending'; }
//                $settings->offerGregorian = $request->offerPersian ? $request->offerGregorian : '';
                $settings->about = json_encode($request->about);

                if ($request->hasFile('photo')) {
                    if ($settings->about_pic){
                        File::delete($settings->about_pic);
                    }
                    $settings->about_pic = file_store($request->photo, 'source/assets/uploads/about/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-');;
                }

                $settings->save();

                return redirect()->route('settings-list')->with('flash_message', 'تنظیمات ذخیره شد.');

            } catch (\Exception $e) {

                return redirect()->back()->withInput();

            }
        }


    }

}
