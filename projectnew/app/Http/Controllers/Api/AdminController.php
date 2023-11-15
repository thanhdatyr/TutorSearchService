<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Tutor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        $login = [
            'email' => $email,
            'password' => $password
        ];
        if(Auth::attempt($login)){
            return response()->json([
                'success'=>'Đăng nhập thành công'
            ]
        );
        }else{
            return response()->json(['errors'=>'Đăng nhập thất bại']);
        }
    }

    public function getaccountTutor()
    {
        $tutors = Tutor::where('active',0)->get();
        foreach($tutors as $tutor){
            $new_tutor['id'] = $tutor->id;
            $new_tutor['email'] = $tutor->email;
            $new_tutor['phone'] = $tutor->phone;
            $new_tutor['name'] = $tutor->name;
            $new_tutor['country'] = $tutor->country->name;
            $new_tutor['district'] = $tutor->district->name;
            $new_tutor['role'] = $tutor->role;
            $new_tutor['avatar'] = $tutor->avatar;

            $result[] = $new_tutor;
        }
        if($tutor){
            return response()->json(['tutor'=>$result]);
        }
    }

    public function acceptTutor(string $id)
    {
        $tutor = Tutor::findOrFail($id);
        $tutor->active = 1;
        if($tutor->save()){
            $result = Tutor::where('active',0)->get();
            return response()->json(['tutor'=>$result]);
        }
    }

    public function getBlog()
    {
        $blogs = Blog::where('active',0)->get();
        foreach($blogs as $blog){
            $new['id'] = $blog->id;
            $new['name'] = $blog->member->name;
            $new['title'] = $blog->title;
            $new['subject'] = $blog->subject->name;
            $new['class'] = $blog->toClass->name;
            $new['price'] = $blog->price;
            $new['address'] = $blog->member->address;
            $new['country']= $blog->country->name;
            $new['district'] = $blog->district->name;
            $new['content'] = $blog->content;

            $old[] = $new;
        }
        if($old){
            return response()->json(['blog'=>$old]);
        }
    }

    public function acceptBlog(string $id)
    {
        $blog = Blog::findOrFail($id);
        $blog->active = 1;
        if($blog->save()){
            $result = Blog::where('active',0)->get();
            return response()->json(['blog'=>$result]);
        }
    }
}
