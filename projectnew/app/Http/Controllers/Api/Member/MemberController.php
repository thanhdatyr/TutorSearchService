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
            return response()->json([
                'status'=>'Cập nhật tài khoản thành công',
                'member' => $member,
        ]);
        }else{
            return response()->json(['errors'=>'Cập nhật tài khoản thất bại']);
        }
    }

    public function addToWishlist(Request $request)
    {
        $data = $request->json()->all();

        $id_member = $data['id_member'];
        $id_tutor = $data['id_tutor'];

        $result = WishlistMember::where('id_tutor',$id_tutor)->where('id_member',$id_member)->first();
        if($result){
            return response()->json(['errors'=>'Gia sư đã có trong danh sách yêu thích']);
        }else{
            $wishlist = WishlistMember::create([
                'id_member' => $id_member,
                'id_tutor' => $id_tutor
            ]);
    
            if($wishlist){
                return response()->json(['status'=>'Đã thêm gia sư vào danh sách yêu thích thành công']);
            }
        }
    }

    public function getListWish(string $id)
    {
        $listutor = [];

        $wishlists = WishlistMember::where('id_member',$id)->get();

        $result = [];

        foreach($wishlists as $wishlist){
            $wishlist->class =  $wishlist->tutor->class->name;
            $wishlist->subject = $wishlist->tutor->subject->name;
            $wishlist->district =  $wishlist->tutor->district->name;
            $wishlist->country = $wishlist->tutor->country->name;
            $wishlist->name = $wishlist->tutor->name;
        }
        $listutor[] = $wishlist;

        return response()->json(['listutor'=>$listutor]);
    }

    public function searchTutor(Request $request)
    {
        $data = $request->json()->all();
        $word = $data['word'];
        $result = [];

        $tutors = Tutor::where('name','like',"%$word%")->get();

        foreach($tutors as $tutor){
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

            $result[] = $new_tutor;
        }

        return response()->json(['tutor'=>$result]);
    }

    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }

    public function paymentMomo(Request $request)
    {
        $total_momo = $request->total;

        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";


        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderInfo = "Thanh toán qua ATM MoMo";
        $amount = "500000";
        $orderId = time() ."";
        $redirectUrl = "123";
        $ipnUrl = "123";
        $extraData = "";

        $requestId = time() . "";
        $requestType = "payWithATM";
        // $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
        //before sign HMAC SHA256 signature
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);
        $data = array('partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature);
        $result = $this->execPostRequest($endpoint, json_encode($data));
        return $result;
        $jsonResult = json_decode($result, true);  // decode json

        //Just a example, please check more in there
        return redirect()->to($jsonResult['payUrl']);
        // header('Location: ' . $jsonResult['payUrl']);
    }
}
