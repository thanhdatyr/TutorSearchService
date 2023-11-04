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

    public function loginTuor(Request $request)
    {
        $data = $request->json()->all();

        $email = $data['email'];
        $password = $data['password'];

        $tutor = Tutor::where('email',$email)->first();
        if($tutor && Hash::check($password,$tutor->password)){
            return response()->json([
                'status' => 'Đăng nhập thành công',
                'tutor' => $tutor
            ]);
        }else{
            return response()->json(['errors'=>'Đăng nhập thất bại']);
        }
    }

    public function addTowishlistBlog(Request $request)
    {
        $data = $request->json()->all();

        $id_tutor = $data['id_tutor'];
        $id_blog = $data['id_blog'];

        $wishlist = WishlistBlog::create([
            'id_tutor' => $id_tutor,
            'id_blog' => $id_blog
        ]);

        if($wishlist){
            return response()->json(['status'=>'Đã thêm bài viết vào danh sách yêu thích thành công']);
        }
    }

    public function getListBlog(string $id)
    {
        $listBlog = [];

        $wishlists = WishlistBlog::where('id_member',$id)->get();

        foreach($wishlists as $wishlist){
            $listBlog[] = $wishlist->blog;
        }

        return response()->json(['listblog'=>$listBlog]);
    }

    public function searchBlog(Request $request)
    {
        $data = $request->json()->all();

        $word = $data['word'];

        $blog = Blog::where('title','like','%$word%')->get();

        return response()->json(['blog'=>$blog]);
    }
}
