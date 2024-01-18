<?php

namespace App\Http\Controllers\Api\Member;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Rate;
use App\Models\Tutor;
use App\Models\Member;
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

        // $tutor = Tutor::findOrFail($id_tutor);
        // $rate_old = $tutor->rate;
        // $tutor->rate = round(($rate_old + $rate) / 2);
        // $tutor->save();
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
        $count = $tutors->count(); 
        // $count = 0;
        
        
        foreach($tutors as $tutor){
            $sum += $tutor->rate;
                // $count++;
        }
        $result = $sum/$count;
        return response()->json([
            'rate'=>$result
        ]);
    }

    public function getComment(string $id)
    {
        $comments = Comment::where('id_tutor',$id)->get();

        if($comments){
            $result = [];

            foreach($comments as $comment){
                $data['name'] = $comment->member->name;
                $data['content'] = $comment->content;
                $data['time'] = $comment->created_at;

                $result[] = $data;
            }
            return response()->json(['comment'=>$result]);
        }else{
            return response()->json(['error','Hiện tại gia sư này chưa có bình luận']);
        }
    }

    public function search(Request $request)
    {
        $tutors = Tutor::query();
        
        if(!empty($request->name)){
            $tutors = $tutors->where('name','LIKE',"%{$request->name}%");
        }
        if (!empty($request->rate)) {
            // Nếu trường rate trong request không rỗng
            $minAverageRate = $request->rate;
            // Gán giá trị của trường rate từ request cho biến $minAverageRate
            $tutorIdsWithRate = Rate::select('id_tutor')
                ->groupBy('id_tutor')
                // Lựa chọn cột 'id_tutor' từ bảng 'rates', nhóm theo 'id_tutor'
                ->havingRaw('AVG(rate) >= ?', [$minAverageRate])
                // Lọc theo điều kiện số trung bình đánh giá lớn hơn hoặc bằng giá trị đã chọn
                ->pluck('id_tutor')
                // Lấy giá trị của cột 'id_tutor' thành một mảng
                ->toArray();
            $tutors = $tutors->whereIn('id', $tutorIdsWithRate);
            // Lọc danh sách giáo viên theo danh sách các id_tutor thỏa mãn điều kiện
            
        }
        if(!empty($request->id_country)){
            $tutors = $tutors->where('id_country',$request->id_country);
        }
        if(!empty($request->id_district)){
            $tutors = $tutors->where('id_district',$request->id_district);
        }
        if(!empty($request->id_class)){
            $tutors = $tutors->where('id_class',$request->id_class);
        }
        if(!empty($request->id_subject)){
            $tutors = $tutors->where('id_subject',$request->id_subject);
        }
        if($request->price != null){
            $arr = explode("-",$request->price);
            $price1 = $arr[0];
            if(count($arr)==2){
                $price2 = $arr[1];
                $tutors = $tutors->whereBetween('time',[$price1,$price2]);
            }else{
                $tutors = $tutors->where('time','>',$price1);
            }
        }
        $tutors = $tutors->get();

        $result = [];
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
            $averageRate = Rate::where('id_tutor',$tutor->id)->avg('rate');
            
            if (is_numeric($averageRate)) {
                // Chuyển đổi thành số và gán cho $new_tutor['average_rate']
                $new_tutor['average_rate'] = floatval($averageRate);
            } else {
                // Nếu không phải số, gán giá trị mặc định là 0
                $new_tutor['average_rate'] = 0;
            }
            if($tutor->active!=0){
                $result[] = $new_tutor;   
            }
            // $result[] = $new_tutor;
        }
        return response()->json(['tutor'=>$result]);
    }
}
