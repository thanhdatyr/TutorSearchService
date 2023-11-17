<?php

namespace App\Http\Controllers\Api\Tutor;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Tutor;
use App\Models\WishlistBlog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TutorController extends Controller
{
    public function registerTutor(Request $request)
    {
        $data = $request->all();

        $username = $data['username'];
        $email = $data['email'];
        $password = Hash::make($data['password']);
        $name = $data['name'];
        $phone = $data['phone'];
        $sex = $data['sex'];
        $birth = $data['birth'];
        $id_country = $data['id_country'];
        $id_district = $data['id_district'];
        $address = $data['address'];
        $desc = $data['desc'];
        $role = $data['role'];
        $time = $data['time'];
        $level = $data['level'];
        $special = $data['special'];
        $id_class = $data['id_class'];
        $id_subject = $data['id_subject'];
        $type = $data['type'];
        $schedule = $data['schedule'];
        $active = 0;

        $avatar = $request->get('avatar');
        $certificate = $request->get('certificate');
        if($avatar){
            $avatarData = explode(',', $avatar)[1];
            $avatarBinary = base64_decode($avatarData);
            $avatar_new = time() . '_avatar.png';
        }
        if($certificate){
            $certificateData = explode(',', $certificate)[1];
            $certificateBinary = base64_decode($certificateData);
            $certificate_new =  time() . '_certificate.png';;
        }

        $isTutor = Tutor::where('email',$email)->first();
        if($isTutor){
            return response()->json(['errors'=>'Email đã tồn tại']);
        }else{
            $tutor = Tutor::create([
                'username' => $username,
                'email' => $email,
                'password' => $password,
                'name' => $name,
                'phone' => $phone,
                'sex' => $sex,
                'birth' => $birth,
                'id_country' => $id_country,
                'id_district' => $id_district,
                'address' => $address,
                'desc' => $desc,
                'role' => $role,
                'time' => $time,
                'level' => $level,
                'special' => $special,
                'id_class' => $id_class,
                'id_subject' => $id_subject,
                'type' => $type,
                'schedule' => $schedule,
                'avatar' => $avatar_new,
                'certificate' => $certificate_new,
                'active' => $active
            ]);
            if($tutor){
                $uploadPath = public_path('upload');
                if($avatar){
                    file_put_contents($uploadPath . '/' . $avatar_new, $avatarBinary);
                }
                if($certificate){
                    file_put_contents($uploadPath . '/' . $certificate_new, $certificateBinary);
                }
                return response()->json(['status'=>'Đăng kí tài khoản phụ huynh thành công']);
            }
        }
    }

    public function updateTutor(Request $request)
    {
        $data = $request->all();
        $id = $data['id'];
        $tutor = Tutor::findOrFail($id);

        $avatar = $request->get('avatar');
        $certificate = $request->get('certificate');
        if($avatar){
            $avatarData = explode(',', $avatar)[1];
            $avatarBinary = base64_decode($avatarData);
            $avatar_new = time() . '_avatar.png';
            $data['avatar'] = $avatar_new;
        }else{
            $data['avatar'] = $tutor->avatar;
        }
        if($certificate){
            $certificateData = explode(',', $certificate)[1];
            $certificateBinary = base64_decode($certificateData);
            $certificate_new =  time() . '_certificate.png';
            $data['certificate'] = $certificate_new;
        }else{
            $data['certificate'] = $tutor->certificate;
        }
        if($data['password']){
            $data['password'] = bcrypt($data['password']); 
        }else{
            $data['password'] = $tutor->password;
        }

        if($tutor->update($data)){
            $uploadPath = public_path('upload');
            if($avatar){
                file_put_contents($uploadPath . '/' . $avatar_new, $avatarBinary);
            }
            if($certificate){
                file_put_contents($uploadPath . '/' . $certificate_new, $certificateBinary);
            }
            return response()->json([
                'status'=>'Cập nhật tài khoản gia sư thành công',
                'tutor' => $tutor
        ]);
        }else{
            return response()->json(['errors'=>'Cập nhật tài khoản gia sư thất bại']);
        }

    }

    public function loginTuor(Request $request)
    {
        $data = $request->json()->all();

        $email = $data['email'];
        $password = $data['password'];
        // $email = $request->email;
        // $password = $request->password;

        $tutor = Tutor::where('email',$email)->first();
        $new_tutor['id'] = $tutor->id;
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
        if($tutor->active == 0){
            return response()->json(['danger'=>'Tài khoản của bạn đang chờ quản trị viên phê duyệt']);
        }else{
            if($tutor && Hash::check($password,$tutor->password)){
                return response()->json([
                    'status' => 'Đăng nhập thành công',
                    'tutor' => $new_tutor
                ]);
            }else{
                return response()->json(['errors'=>'Đăng nhập thất bại']);
            }
        }
    }

    public function addTowishlistBlog(Request $request)
    {
        $data = $request->json()->all();

        $id_tutor = $data['id_tutor'];
        $id_blog = $data['id_blog'];

        $result = WishlistBlog::where('id_blog',$id_blog)->where('id_tutor',$id_tutor)->first();
        if($result){
            return response()->json(['errors'=>'Bài viết đã có trong danh sách yêu thích']);
        }else{
            $wishlist = WishlistBlog::create([
                'id_tutor' => $id_tutor,
                'id_blog' => $id_blog
            ]);
            
            if($wishlist){
                return response()->json(['status'=>'Đã thêm bài viết vào danh sách yêu thích thành công']);
            }
        }
    }

    public function getListBlog(string $id)
    {
        $listBlog = [];

        $wishlists = WishlistBlog::where('id_tutor',$id)->get();

        foreach($wishlists as $wishlist){
            $result['class'] = $wishlist->blog->toClass->name;
            $result['subject'] = $wishlist->blog->subject->name;
            $result['country'] = $wishlist->blog->country->name;
            $result['district'] = $wishlist->blog->district->name;
            $result['id'] = $wishlist->blog->id;
            $result['content'] = $wishlist->blog->content;
            $result['name'] = $wishlist->blog->member->name;

            $listBlog[] = $result;
        }

        return response()->json(['listblog'=>$listBlog]);
    }

    public function searchBlog(Request $request)
    {
        $data = $request->json()->all();

        $word = $data['word'];
        $result = [];

        $blogs = Blog::where('title','like',"%$word%")->get();
        foreach($blogs as $blog){
            $new_blog['id'] = $blog->id;
            $new_blog['title'] = $blog->title;
            $new_blog['member'] = $blog->member->name;
            $new_blog['class'] = $blog->toClass->name;
            $new_blog['subject'] = $blog->subject->name;
            $new_blog['price'] = $blog->price;
            $new_blog['content'] = $blog->content;
            $new_blog['date'] = $blog->date;
            $new_blog['active'] = $blog->active;
            $new_blog['country'] = $blog->country->name;
            $new_blog['district'] = $blog->district->name;

            $result[] = $new_blog;
        }

        return response()->json(['blog'=>$result]);
    }
}
