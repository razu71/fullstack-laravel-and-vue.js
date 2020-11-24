<?php

namespace App\Http\Controllers;

use App\Category;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function getCategory()
    {
        return Category::all();
    }

    public function createCategory(Request $request)
    {
        $this->validate($request, [
            'categoryName' => 'required',
            'iconImage' => 'required'
        ]);
        $data = [
            'categoryName' => $request->categoryName,
            'iconImage' => $request->iconImage
        ];
        return Category::create($data);
    }

    public function editCategory(Request $request)
    {
        $this->validate($request, [
            'categoryName' => 'required',
            'iconImage' => 'required'
        ]);
        $data = [
            'categoryName' => $request->categoryName
        ];
        if ($request->has('iconImage')) {
            $category = Category::where('id', $request->id)->first();
            $this->deleteFileServer($category->iconImage);
            $data['iconImage'] = $request->iconImage;
        }
        return Category::where('id', $request->id)->update($data);
    }

    public function deleteCategory(Request $request)
    {
        $category = Category::where('id', $request->id)->first();
        if (!empty($category)){
            $this->deleteFileServer($category->iconImage);
        }
        return Category::where('id', $request->id)->delete();
    }

    public function upload(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'file' => 'required|mimes:jpg,png,jpeg|max:2048'
        ]);
        if ($validation->fails()) {
            return response($validation->messages()->toArray(), 400);
        }
        $pic_name = time() . '.' . $request->file->extension();
        $request->file->move(public_path('uploads'), $pic_name);
        return $pic_name;
    }

    public function deleteImage(Request $request)
    {
        $file_name = $request->imageName;
        $this->deleteFileServer($file_name);

        return true;
    }

    public function deleteFileServer($file_name)
    {
        $file_path = public_path() . '/uploads/' . $file_name;
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        return true;
    }
}
