<?php

namespace App\Http\Controllers\Panel;

use App\Bank;
use App\Dbcategorie;
use App\ArticleAttribute;
use App\AttributeArticleJoin;
use App\Photo;
use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
//use PHPUnit\Framework\Constraint\Attribute;

class BankController extends Controller
{
    public function controller_title($type)
    {
        if ($type == 'sum') {
            return 'بانک اطلاعاتی';
        } elseif ('single') {
            return 'بانک اطلاعاتی';
        }
    }

    public function controller_paginate()
    {
        $settings = Setting::select('paginate')->latest()->firstOrFail();
        return $settings->paginate;
    }

    public function __construct()
    {
        $this->middleware(['auth', 'isAdmin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banks = Bank::paginate($this->controller_paginate());
        return view('panel.bank.index', compact('banks'), ['title' => $this->controller_title('sum')]);
    }

    public function create()
    {
        $categories=Dbcategorie::all();
        return view('panel.bank.create',compact('categories'),['title' => $this->controller_title('sum')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:191',
            'slug' => 'required|unique:banks|max:191',
            'category_id' => 'required',
            'subtitle' => 'required',
            'text' => 'required',
        ]);

        try {

            $post = Bank::create($request->only('title', 'slug','category_id', 'text', 'subtitle','lat','lng'));

            if ($request->hasFile('photo')) {
                foreach ($request->photo as $item) {
                    $photo = new Photo();
                    $photo->path = file_store($item, 'source/assets/uploads/banks/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-');;
                    $post->photo()->save($photo);
                }
            }

            return redirect()->route('bank-list')->with('flash_message', 'بانک اطلاعاتی با موفقیت افزوده شد.');

        } catch (\Exception $e) {

            return redirect()->back()->withInput();

        }
    }

    public function edit($id)
    {
        $item=Bank::find($id);
        $categories=Dbcategorie::all();
        return view('panel.bank.edit',compact('item','categories'),['title' => $this->controller_title('sum')]);
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
        $this->validate($request, [
            'title' => 'required|max:191',
            'slug' => 'required|max:191',
            'category_id' => 'required',
            'subtitle' => 'required',
            'text' => 'required',
        ]);

        $bank = Bank::findOrFail($id);

        try {

            $bank->title = $request->title;
            $bank->slug = $request->slug;
            $bank->category_id = $request->category_id;
            $bank->text = $request->text;
            $bank->subtitle = $request->subtitle;

            $bank->save();


            if ($request->hasFile('photo')) {
                if ($bank->photo) {
                    foreach ($bank->photo as $photo) {
                        File::delete($photo->path);
                    }
                    $bank->photo->delete();

                    foreach ($request->photo as $item) {
                        $photo = new Photo();
                        $photo->path = file_store($item, 'source/assets/uploads/banks/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-');;
                        $bank->photo()->save($photo);
                    }
                } else {
                    foreach ($request->photo as $item) {
                        $photo = new Photo();
                        $photo->path = file_store($item, 'source/assets/uploads/banks/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-');;
                        $bank->photo()->save($photo);
                    }
                }
            }

            return redirect()->route('bank-list')->with('flash_message', 'بانک اطلاعاتی با موفقیت ویرایش شد.');

        } catch (\Exception $e) {

            return redirect()->back()->withInput();

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bank = Bank::findOrFail($id);

        try {

            $bank->delete();
            return redirect()->route('bank-list')->with('flash_message', 'بانک اطلاعاتی با موفقیت حذف شد.');

        } catch (\Exception $e) {

            return redirect()->back();

        }
    }
}