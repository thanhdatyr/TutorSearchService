<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Schedule;
use App\Models\Tutor;
use App\Models\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class TutorApiController extends Controller
{
    public function getAllTutor()
    {
        $tutors = Tutor::where('active',1)->get();
       
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

            $result[] = $new_tutor;
        }

        return response()->json(['tutor'=>$result]);
    }

    public function viewInfoTutor(string $id)
    {
        $tutors = Tutor::where('id',$id)->get();
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

            $result[] = $new_tutor;
        }

        return response()->json(['tutor'=>$result]);
    }

    public function makeAppoiment(Request $request)
    {
        $data = $request->json()->all();

        $id_tutor = $data['id_tutor'];
        $id_blog = $data['id_blog'];
        $id_member = $data['id_member'];
        $day = $data['day'];
        $hour = $data['hour'];
        $location = $data['location'];

        $schedule = Schedule::create([
            'id_tutor' => $id_tutor,
            'id_blog' => $id_blog,
            'id_member' => $id_member,
            'active' => 0,
            'day' => $day,
            'hour' => $hour,
            'location' => $location
        ]);
        if($schedule){
            $blogs = Blog::findOrFail($id_blog);
            $blogs->active = 2;
            $blogs->save();
            return response()->json([
                'status'=>'Đặt lịch hẹn thành công',
            ]);
        }
    }

    public function getlistAppoint(string $id)
    {   
        
        $appointments = Schedule::where('id_tutor', $id)->where('active', 2)->get();
        $result = [];

        foreach ($appointments as $appointment) {
            $data['id'] =$appointment->id;
            $data['id_member'] = $appointment->id_member;
            $data['name'] = $appointment->blog->member->name;
            $data['title'] = $appointment->blog->title;
            $data['subject'] =$appointment->blog->subject->name;
            $data['class'] = $appointment->blog->toClass->name;
            $data['price'] = $appointment->blog->price;
            $data['country'] = $appointment->blog->country->name;
            $data['district'] = $appointment->blog->district->name;
            $data['content'] = $appointment->blog->content;
            $data['active'] = $appointment->active;
            $data['day'] = $appointment->day;
            $data['hour'] = $appointment->hour;
            $data['location'] = $appointment->location;
            $result[] = $data;
        }

        return response()->json(['schedule'=>$result]);
    }

    public function getListAppointRefused(string $id)
    {
        // $appointments = Schedule::where('id_tutor', $id)->where('active', 1)->get();
        $appointments = Schedule::with('blog')->where('id_tutor', $id)->where('active', 1)->get();
        $result = [];

        foreach ($appointments as $appointment) {
            $data['name'] = $appointment->blog->member->name ?? null;
            $data['title'] = $appointment->blog->title ?? null;
            $data['subject'] = $appointment->blog->subject->name ?? null;
            $data['class'] = $appointment->blog->toClass->name ?? null;
            $data['price'] = $appointment->blog->price ?? null;
            $data['country'] = $appointment->blog->country->name ?? null;
            $data['district'] = $appointment->blog->district->name ?? null;
            $data['content'] = $appointment->blog->content ?? null;
            $data['day'] = $appointment->day;
            $data['hour'] = $appointment->hour;
            $data['location'] = $appointment->location;
            
            $result[] = $data;
        }

        return response()->json(['schedule'=>$result]);
    }
}
