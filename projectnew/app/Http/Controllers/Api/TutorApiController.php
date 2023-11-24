<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Schedule;
use App\Models\Tutor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class TutorApiController extends Controller
{
    public function getAllTutor()
    {
        $tutors = Tutor::all();
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
            $blog = Blog::findOrFail($id_blog);
            $blog->active = 2;
            $blog->save();
            return response()->json(['status'=>'Đặt lịch hẹn thành công']);
        }
    }

    public function getlistAppoint(string $id)
    {
        $tutors = Schedule::where('id_tutor',$id)->get();
        $result = [];
        foreach($tutors as $tutor){
            $data['member'] = $tutor->member;
            $data['blog'] = $tutor->blog;
            $data['active'] = $tutor->active;
            $data['day'] = $tutor->day;
            $data['hour'] = $tutor->hour;
            $data['location'] = $tutor->location;

            $result[] = $data;
        }
        return response()->json(['schedule'=>$result]);
    }

    public function deleteAppoint(string $id)
    {
        $schedule = Schedule::find($id);
        $result = $schedule->delete();
        if($result){
            return response()->json(['status'=>200]);
        }else{
            return response()->json(['errors'=>404]);
        }
    }
}
