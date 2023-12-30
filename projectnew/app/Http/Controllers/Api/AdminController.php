<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\MailNotify;
use App\Models\Blog;
use App\Models\Member;
use App\Models\Tutor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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
            return response()->json(['success'=>'Đăng nhập thành công']);
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
        if($tutors){
            return response()->json(['tutor'=>$result]);
        }
    }

    public function detailTutor(string $id)
    {
        $tutor = Tutor::findOrFail($id);
        $new_tutor['username'] = $tutor->username;
        $new_tutor['email'] = $tutor->email;
        $new_tutor['phone'] = $tutor->phone;
        $new_tutor['name'] = $tutor->name;
        $new_tutor['sex'] = $tutor->sex;
        $new_tutor['birth'] = $tutor->birth;
        $new_tutor['country'] = $tutor->country->name;
        $new_tutor['district'] = $tutor->district->name;
        $new_tutor['address'] = $tutor->address;
        $new_tutor['desc'] = $tutor->desc;
        $new_tutor['role'] = $tutor->role;
        $new_tutor['time'] = $tutor->time;
        $new_tutor['level'] = $tutor->level;
        $new_tutor['special'] = $tutor->special;
        $new_tutor['class'] = $tutor->class->name;
        $new_tutor['subject'] = $tutor->subject->name;
        $new_tutor['type'] = $tutor->type;
        $new_tutor['schedule'] = $tutor->schedule;
        $new_tutor['avatar'] = $tutor->avatar;
        $new_tutor['certificate'] = $tutor->certificate;
        $new_tutor['active'] = $tutor->active;

        return response()->json(['tutor'=>$new_tutor]);
    }

    public function acceptTutor(string $id)
    {   

        $data = [
            'title' => 'Xác thực tài khoản đăng ký gia sư',
            'subject' => 'Xác thực tài khoản gia sư thành công',
            'body' => 'Tài khoản đăng kí gia sư của bạn đã được 
                        chúng tôi xem xét và phê duyệt thành công, 
                        chào mừng bạn đến với website tuyển dụng gia sư  của chúng tôi!',
            'link' => url("http://localhost:3000/memberTutor/LoginTutor")
        ];

        $tutor = Tutor::findOrFail($id);
        $tutor->active = 1;
        if($tutor->save()){
            $result = Tutor::where('active',0)->get();
            $email = $tutor->email;
            try{
                Mail::to($email)->send(new MailNotify($data));
                return response()->json(['tutor'=>$result]);
            }catch(Exception $th){
                return response()->json(['error'=>$th->getMessage()]);
            }
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

    public function statisticalPage()
    {
        $countMember = 0;
        $countTutor = 0;
        $countallBlog = 0;
        $countblogSuccess = 0;
        $countblogAbsent = 0;
        $members = Member::all();
        $tutors = Tutor::all();
        $blogs = Blog::all();
        $blogSuccess = Blog::where('active',1)->get();
        $blogAbsent = Blog::where('active',0)->get();
        if($members){
            foreach($members as $member){
                $countMember++;
            }
        }
        if($tutors){
            foreach($tutors as $tutor){
                $countTutor++;
            }
        }
        if($blogs){
            foreach($blogs as $blog){
                $countallBlog++;
            }
        }
        if($blogSuccess){
            foreach($blogSuccess as $blogSu){
                $countblogSuccess++;
            }
        }
        if($blogAbsent){
            foreach($blogAbsent as $blogWait){
                $countblogAbsent++;
            }
        }
        return response()->json([
                'member'=>$countMember,
                'tutor'=>$countTutor,
                'blog' => $countallBlog,
                'blogSuccess' => $countblogSuccess,
                'blogAbsent' => $countblogAbsent
            ]);
    }

    public function refuseTutor(string $id)
    {
        $tutor = Tutor::find($id);
        $result = $tutor->delete();
        if($result){
            return response()->json(['success',200]);
        }else{
            return response()->json(['errors',404]);
        }
    }

    public function refuseBlog(string $id)
    {
        $blog = Blog::find($id);
        $result = $blog->delete();
        if($result){
            return response()->json(['success',200]);
        }else{
            return response()->json(['errors',404]);
        }
    }

    public function forgotPassword(Request $request)
    {
        $code = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'),0,8);
        $email = $request->email;
        $role = $request->role;

        $data = [
            'title' => 'Mật khẩu đặt lại tài khoản',
            'subject' => 'Đặt lại mật khẩu',
            'body' => 'Bạn đã quên mật khẩu của tài khoản hiện tại,hãy đăng nhập vào 
                        mật khẩu mới và thay đổi mật khẩu, đây là mật khẩu mới của bạn: '.$code
        ];

        if($role==1){
            $member = Member::where('email',$email)->first();
            if($member){
                $member->password = Hash::make($code);
                $member->save();

                Mail::to($email)->send(new MailNotify($data));
                return response()->json(['success',200]);
            }else{
                return response()->json(['errors','Email không hợp lệ']);
            }
        }
        if($role==2){
            $tutor = Tutor::where('email',$email)->first();
            if($tutor){
                $tutor->password = Hash::make($code);
                $tutor->save();

                Mail::to($email)->send(new MailNotify($data));
                return response()->json(['success',200]);
            }else{
                return response()->json(['errors','Email không hợp lệ']);
            }
        }
    }

    public function newPassword(Request $request)
    {
        $role = $request->role;
        $id = $request->id;
        $old_password = $request->old_password;
        $new_password = $request->new_password;

        if($role==1){
            $member = Member::findOrFail($id);
            if($member && Hash::check($old_password,$member->password)){
                $member->password = Hash::make($new_password);
                $member->save();
                return response()->json(['success',200]);
            }else{
                return response()->json(['errors','Mật khẩu cũ không trùng với mật khẩu hiện tại']);
            }
        }
        if($role==2){
            $tutor = Tutor::findOrFail($id);
            if($tutor && Hash::check($old_password,$tutor->password)){
                $tutor->password = Hash::make($new_password);
                $tutor->save();
                return response()->json(['success',200]);
            }else{
                return response()->json(['errors','Mật khẩu cũ không trùng với mật khẩu hiện tại']);
            }
        }
    }
}
