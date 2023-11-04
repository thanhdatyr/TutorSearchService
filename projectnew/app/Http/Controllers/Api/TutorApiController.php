<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tutor;
use Illuminate\Http\Request;

class TutorApiController extends Controller
{
    public function getAllTutor()
    {
        $tutor = Tutor::all();

        return response()->json(['tutor'=>$tutor]);
    }

    public function viewInfoTutor(string $id)
    {
        $tutor = Tutor::where('id',$id)->get();

        return response()->json(['tutor'=>$tutor]);
    }
}
