<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Article;

class CategoryController extends Controller
{
    public function index(){
      $categories=Category::all();
      return view('back.categories.index',compact('categories'));
    }

    public function switch(Request $request) {
        $category=Category::findOrFail($request->id);
        $category->status=$request->statu=="true" ? 1 : 0;
        $category->save();
    }

    public function getdata(Request $request) {
        $category=Category::findOrFail($request->id);
        return response()->json($category);
    }

    public function create(Request $request) {
        $isExit=Category::whereSlug(str_slug($request->category))->first();
        if($isExit){
          toastr()->error($request->category.'adında bir kategori zaten mevcut!!');
          return redirect()->back();
        }
        $category=new Category;
        $category->name=$request->category;
        $category->slug=str_slug($request->category);
        $category->save();
        toastr()->success('Kategori başarıyla oluşturuldu');
        return redirect()->back();
    }

    public function update(Request $request) {
        $isSlug=Category::whereSlug(str_slug($request->slug))->whereNotIn('id',[$request->id])->first();
        $isName=Category::whereName($request->category)->whereNotIn('id',[$request->id])->first();
        if($isSlug or $isName){
          toastr()->error($request->category.' adında bir kategori zaten mevcut!!');
          return redirect()->back();
        }

        $category=Category::find($request->id);
        $category->name=$request->category;
        $category->slug=str_slug($request->slug);
        $category->save();
        toastr()->success('Kategori başarıyla güncellendi');
        return redirect()->back();
    }

    public function delete(Request $request) {
        $category=Category::findOrFail($request->id);
        if($category->id == 1){
          toastr()->error('Bu kategori silinemez!!');
          return redirect()->back();
        }
        $message='';
        $count=$category->articleCount();
        if($count > 0){
          Article::where('category',$category->id)->update(['category'=>1]);
          $defaultCat=Category::find(1);
          $message='Bu kategoriye ait '.$count.' içerik '.$defaultCat->name.' kategorisine aktarıldı.';
        }
        $category->delete();
        toastr()->success($message,'Kategori başarıyla silindi.',);
        return redirect()->back();
    }
}
