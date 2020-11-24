<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    public function createTag(Request $request){
        $this->validate($request, ['tagName' => 'required']);
        return Tag::create(['tagName' => $request->tagName]);
    }

    public function editTag(Request $request){
        $this->validate($request, ['tagName' => 'required']);
        return Tag::where('id' , $request->id)->update(['tagName' => $request->tagName]);
    }

    public function deleteTag(Request $request){
//        return $request->all();
        return Tag::where('id', $request->id)->delete();
//        if (!empty($tag)){
//            $tag->delete();
//            return response()->json([
//                'status' => 200,
//                'data' => $tag,
//                'message' => __('Deleted successfully'),
//            ]);
//        }else{
//            return response()->json([
//                'status' => 422,
//                'data' => null,
//                'message' => __('Something went wrong!'),
//            ]);
//        }

    }

    public function getTag(){
        return Tag::all();
    }
}
