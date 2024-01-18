<?php

namespace App\Http\Controllers\Api\Member;

use App\Http\Controllers\Controller;
use App\Models\ActiveClass;
use App\Models\Blog;
use App\Models\Subject;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function getClass()
    {
        $activeClass = ActiveClass::all();

        return response()->json(['class'=>$activeClass]);
    }

    public function getSubject(string $id)
    {
        $subject = Subject::where('id_class',$id)->get();

        return response()->json(['subject'=>$subject]);
    }

    public function postBlog(Request $request)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $data = $request->json()->all();

        $title = $data['title'];
        $id_member = $data['id_member'];
        $id_class = $data['id_class'];
        $id_subject = $data['id_subject'];
        $price = $data['price'];
        $content = $data['content'];
        $id_country = $data['id_country'];
        $id_district = $data['id_district'];

        $blog = Blog::create([
            'title' => $title,
            'id_member' => $id_member,
            'id_class' => $id_class,
            'id_subject' => $id_subject,
            'price' => $price,
            'content' => $content,
            'date' => date('d/m/Y'),
            'active' => 0,
            'id_country' => $id_country,
            'id_district' => $id_district
        ]);
        if($blog){
            return response()->json(['status'=>'Bài đăng của bạn đang đợi quản trị viên phê duyệt']);
        }
    }

    public function index(string $id)
    {
        $blogs = Blog::where('id_member',$id)->get();

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

        return response()->json(['blog'=>$old]);
    }

    public function edit(string $id)
    {
        $blog = Blog::findOrFail($id);

        return response()->json(['blog'=>$blog]);
    }

    public function update(string $id, Request $request)
    {
        $data = $request->json()->all();

        $blog = Blog::findOrFail($id);
        if($blog->update($data)){
            return response()->json(['status'=>'Cập nhật bài viết thành công']);
        }else{
            return response()->json(['errors'=>'Cập nhật bài viết thất bại']);
        }
    }

    public function destroy(string $id)
    {
        $result = Blog::where('id',$id)->delete();
        if($result){
            return response()->json(['status'=>'Xóa bài viết thành công']);
        }else{
            return response()->json(['errors'=>'Xóa bài viết thất bại']);
        }
    }

    public function getAllBlog()
    {
        $blogs = Blog::where('active',1)->get();

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
            $new['id_member'] = $blog->member->id;
            
            $old[] = $new; 
        }

        return response()->json(['blog'=>$old]);
    }
}
