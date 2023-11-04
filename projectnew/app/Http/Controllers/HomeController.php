<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ActiveClass;
use App\Models\Country;
use App\Models\District;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    public function index()
    {
        return view('country');
    }

    public function postCountry(Request $request)
    {
        $data = $request->all();
        if(Country::create($data)){
            return redirect()->back()->with('success','Thêm thịnh chó điếm thành công');
        }else{
            return redirect()->back()->withErrors('Thịnh chó điếm đầu nòng nọc');
        }
    }

    public function district()
    {
        $countries = Country::all();
        return view('district',compact('countries'));
    }

    public function postDistrict(Request $request)
    {
        $data = $request->all();
        if(District::create($data)){
            return redirect()->back()->with('success','Thịnh sản xuất nòng nọc thành công');
        }else{
            return redirect()->back()->withErrors('Thịnh chó điếm đầu nòng nọc');
        }
    }

    public function subject()
    {
        $classes = ActiveClass::all();
        return view('subject',compact('classes'));
    }

    public function addSubject(Request $request)
    {
        $data = $request->all();
        if(Subject::create($data)){
            return redirect()->back()->with('success','Thịnh sản xuất nòng nọc thành công');
        }else{
            return redirect()->back()->withErrors('Thịnh chó điếm đầu nòng nọc');
        }
    }

    public function getClass()
    {
        return view('class');
    }

    public function postClass(Request $request)
    {
        $data = $request->all();
        if(ActiveClass::create($data)){
            return redirect()->back()->with('success','Thịnh sản xuất nòng nọc thành công');
        }else{
            return redirect()->back()->withErrors('Thịnh chó điếm đầu nòng nọc');
        }
    }
}
