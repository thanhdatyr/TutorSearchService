<?php

namespace App\Http\Controllers\Api\Member;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Rate;
use Illuminate\Http\Request;

class MemberVipController extends Controller
{
    public function rateTutor(Request $request)
    {
        $data = $request->json()->all();

        $id_member = $data['id_member'];
        $id_tutor = $data['id_tutor'];
        $rate = $data['rate'];

        $result = Rate::create([
            'id_member' => $id_member,
            'id_tutor' => $id_tutor,
            'rate' => $rate
        ]);
        if($result){
            return response()->json(['status'=>'Đánh giá gia sư thành công']);
        }
    }

    public function commentTutor(Request $request)
    {
        $data = $request->json()->all();

        $id_member = $data['id_member'];
        $id_tutor = $data['id_tutor'];
        $content = $data['content'];

        $result = Comment::create([
            'id_member' => $id_member,
            'id_tutor' => $id_tutor,
            'content' => $content
        ]);
        if($result){
            return response()->json(['status'=>'Bình luận gia sư thành công']);
        }
    }

    public function getRateTutor(string $id)
    {
        $tutors = Rate::where('id_tutor',$id)->get();
        $sum = 0;
        $count = 0;

        foreach($tutors as $tutor){
            $sum += $tutor->rate;
            $count++;
        }
        $result = $sum/$count;
        return response()->json(['rate'=>$result]);
    }
}
