<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use File;

class PageController extends Controller
{
    public function index(){
      $pages=Page::all();
      return view('back.pages.index',compact('pages'));
    }

    public function switch(Request $request) {
        $page=Page::findOrFail($request->id);
        $page->status=$request->statu=="true" ? 1 : 0;
        $page->save();
    }

    public function create() {
        return view('back.pages.create');
    }

    public function post(Request $request)
    {
        $request->validate([
          'image'=>'required|image|mimes:jpeg,png,jpg|'
        ]);

        $pages = Page::whereSlug(str_slug($request->title));

        if($pages->count()>0){
          toastr()->error('Başarısız','Böyle bir sayfa zaten mevcut.');

          $request->flash();
          return redirect()->back()->withInput();
        }

        $last=Page::orderBy('order','desc')->first();

        $page = new Page;
        $page->title=$request->title;
        $page->content=$request->content;
        if($last==NULL){
          $page->order=1;
        }
        else{
          $page->order=$last->order+1;
        }

        $page->slug=str_slug($request->title);

        if($request->hasFile('image')){
          $imageName=str_slug($request->title).'__page.'.$request->image->getClientOriginalExtension();
          $request->image->move(public_path('uploads'),$imageName);
          $page->image='uploads/'.$imageName;
        }

        $page->save();
        toastr()->success('Sayfa başarıyla oluşturuldu');
        return redirect()->route('admin.pages.index');
    }

    public function update($id) {
        $page=Page::findOrFail($id);
        return view('back.pages.update',compact('page'));
    }

    public function updatePost(Request $request, $id)
    {
        $request->validate([
          'image'=>'image|mimes:jpeg,png,jpg|'
        ]);

        $pages = Page::whereSlug(str_slug($request->title))->where('id','!=',$id);

        if($pages->count()>0){
          toastr()->error('Başarısız','Böyle bir sayfa zaten mevcut.');

          $request->flash();
          return redirect()->back()->withInput();
        }

        $page = Page::findOrFail($id);

        if($request->hasFile('image')){
          $imageName=str_slug($request->title).'__page.'.$request->image->getClientOriginalExtension();
          $request->image->move(public_path('uploads'),$imageName);
          $page->image='uploads/'.$imageName;
        }
        else{
          if($page->title != $request->title){
            $extension=explode('.',$page->image);
            $imageName=str_slug($request->title).'__page.'.$extension[1];
            if(rename($page->image,"uploads/$imageName")){
              $page->image='uploads/'.$imageName;
            }
            else{
              toastr()->error('Başarısız','Sayfa Güncellenemedi!!');
              return redirect()->route('admin.articles.index');
            }

          }
        }

        $page->title=$request->title;
        $page->content=$request->content;
        $page->slug=str_slug($request->title);




        $page->save();
        toastr()->success('Sayfa başarıyla güncellendi');
        return redirect()->route('admin.pages.index');
    }



    public function delete($id)
    {
      $page=Page::find($id);
      if(File::exists($page->image)){
        File::delete(public_path($page->image));
      }


      $page->forceDelete();
      toastr()->success('Sayfa başarıyla silindi');
      return redirect()->back();
    }

    public function orders(Request $request) {
        foreach($request->get('page') as $key=>$order){
            Page::where('id',$order)->update(['order'=>$key]);
        }
    }
}
