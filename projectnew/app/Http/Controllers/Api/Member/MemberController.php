<?php

namespace App\Http\Controllers\Api\Member;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\District;
use App\Models\Member;
use App\Models\Tutor;
use App\Models\WishlistMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{

    public function getCountry()
    {
        $country = Country::all();

        return response()->json(['country'=>$country]);
    }

    public function getDistrict(string $id)
    {
        $district = District::where('id_country',$id)->get();

        return response()->json(['district'=> $district]);
    }

    public function loginMember(Request $request)
    {
        $data = $request->json()->all();

        $email = $data['email'];
        $password = $data['password'];

        $member = Member::where('email',$email)->first();
        if($member && Hash::check($password,$member->password)){
            return response()->json([
                'status' => 'Đăng nhập thành công',
                'member' => $member
            ]);
        }else{
            return response()->json(['errors'=>'Đăng nhập thất bại']);
        }
    }
    
    public function registerMember(Request $request)
    {
        $data = $request->json()->all();

        $name = $data['name'];
        $password = Hash::make($data['password']);
        $id_country = $data['id_country'];
        $id_district = $data['id_district'];
        $email = $data['email'];
        $phone = $data['phone'];
        $address = $data['address'];
        $active = 0;
        $level = 0;

        $isEmail = Member::where('email',$email)->first();
        if($isEmail){
            return response()->json(['errors'=>'Email đã tồn tại']);
        }else{
            $member = Member::create([
                'name' => $name,
                'password' => $password,
                'id_country' => $id_country,
                'id_district' => $id_district,
                'email' => $email,
                'phone' => $phone,
                'address' => $address,
                'active' => $active,
                'level' => $level
            ]);
    
            if($member){
                return response()->json(['status'=>'Đăng kí tài khoản phụ huynh thành công']);
            }
        }
    }

    public function updateMember(Request $request)
    {
        $data = $request->json()->all();

        $id = $data['id'];

        $member = Member::findOrFail($id);

        if($data['password']){
            $data['password'] = bcrypt($data['password']);
        }else{
            $data['password'] = $member->password;
        }

        if($member->update($data)){
            return response()->json(['status'=>'Cập nhật tài khoản thành công']);
        }else{
            return response()->json(['errors'=>'Cập nhật tài khoản thất bại']);
        }
    }

    public function addToWishlist(Request $request)
    {
        $data = $request->json()->all();

        $id_member = $data['id_member'];
        $id_tutor = $data['id_tutor'];

        $wishlist = WishlistMember::create([
            'id_member' => $id_member,
            'id_tutor' => $id_tutor
        ]);

        if($wishlist){
            return response()->json(['status'=>'Đã thêm gia sư vào danh sách yêu thích thành công']);
        }
    }

    public function getListWish(string $id)
    {
        $listmember = [];

        $wishlists = WishlistMember::where('id_member',$id)->get();

        foreach($wishlists as $wishlist){
            $listmember[] = $wishlist->member;
        }

        return response()->json(['listmember'=>$listmember]);
    }

    public function searchTutor(Request $request)
    {
        $data = $request->json()->all();
        $word = $data['word'];

        $tutor = Tutor::where('name','like','%$word%')->get();

        return response()->json(['tutor'=>$tutor]);
    }
}
