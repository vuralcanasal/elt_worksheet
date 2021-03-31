<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use App\Models\Sheet;
use Illuminate\Support\Facades\File;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::orderBy('created_at','ASC')->get();
        return view('back.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=Category::all();
        return view('back.articles.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
          'image'=>'required|image|mimes:jpeg,png,jpg|'
        ]);

        $articles = Article::whereSlug(str_slug($request->title))->whereCategory($request->category)->get();

        if($articles->count()>0){
          toastr()->error('Başarısız','Aynı kategori ve aynı başlıklığa sahip içeriğiniz var.');

          $request->flash();
          return redirect()->route('admin.articles.create')->withInput();
        }

        $article = new Article;
        $article->title=$request->title;
        $article->category=$request->category;
        $article->content=$request->content;
        $article->slug=str_slug($request->title);

        if($request->hasFile('image')){
          $imageName=str_slug($request->title).'_'.$request->category.'.'.$request->image->getClientOriginalExtension();
          $request->image->move(public_path('uploads'),$imageName);
          $article->image='uploads/'.$imageName;
        }


        $article->save();
        toastr()->success('Başarılı','İçerik başarıyla oluşturuldu');
        return redirect()->route('admin.articles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article=Article::findOrFail($id);
        $categories=Category::all();
        return view('back.articles.update',compact('categories','article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
          'image'=>'image|mimes:jpeg,png,jpg|'
        ]);

        $articles = Article::whereSlug(str_slug($request->title))->whereCategory($request->category)->where('id','!=',$id);

        if($articles->count()>0){
          toastr()->error('Başarısız','Aynı kategori ve aynı başlıklığa sahip içeriğiniz var.');

          $request->flash();
          return redirect()->back()->withInput();
        }

        $article = Article::findOrFail($id);

        if($request->hasFile('image')){
          $imageName=str_slug($request->title).'_'.$request->category.'.'.$request->image->getClientOriginalExtension();
          $request->image->move(public_path('uploads'),$imageName);
          $article->image='uploads/'.$imageName;
        }
        else{
          if(($article->title != $request->title)or($article->category != $request->category)){
            $extension=explode('.',$article->image);
            $imageName=str_slug($request->title).'_'.$request->category.'.'.$extension[1];
            if(file_exists(public_path($article->image))){
              rename($article->image,"uploads/$imageName");
            }
            $article->image='uploads/'.$imageName;
          }
        }

        $article->title=$request->title;
        $article->category=$request->category;

        $article->content=$request->content;
        $article->slug=str_slug($request->title);




        $article->save();
        toastr()->success('Başarılı','İçerik başarıyla güncellendi');
        return redirect()->route('admin.articles.index');
    }

    public function switch(Request $request) {
        $article=Article::findOrFail($request->id);
        $article->status=$request->statu=="true" ? 1 : 0;
        $article->save();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function delete($id)
    {
        Article::find($id)->delete();
        toastr()->success('İçerik çöpe atıldı');
        return redirect()->route('admin.articles.index');
    }

    public function trashed()
    {
        $articles=Article::onlyTrashed()->orderBy('created_at','ASC')->get();
        return view('back.articles.trashed', compact('articles'));
    }

    public function recover($id)
    {
        $articles=Article::onlyTrashed()->find($id)->restore();
        toastr()->success('İçerik geri yüklendi');
        return redirect()->back();
    }

    public function hardDelete($id)
    {
      $article=Article::onlyTrashed()->find($id);
      if(File::exists($article->image)){
        File::delete(public_path($article->image));
      }

      $sheets=Sheet::where('article',$id)->get();
      foreach($sheets as $sheet){
        if(File::exists($sheet->path)){
          File::delete(public_path($sheet->path));
        }
        $sheet->forceDelete();
      }


      $article->forceDelete();
      toastr()->success('İçerik başarıyla silindi');
      return redirect()->back();
    }

    public function file($id)
    {
        $article=Article::find($id);
        $files=Sheet::where('article',$id)->get();
        return view('back.articles.file',compact('files','article'));
    }

    public function filedelete(Request $request) {
        $file=Sheet::findOrFail($request->id);

        if(File::exists($file->path)){
          File::delete(public_path($file->path));
        }

        $file->forceDelete();
        toastr()->success('Dosya başarıyla silindi.');
        return redirect()->back();
    }

    public function filecreate(Request $request) {

        $request->validate([
          'sheet.*'=>'mimes:doc,pdf,docx,jpeg,png,jpg|'
        ]);

        $file=new Sheet;
        $file->name=$request->name;
        $file->slug=str_slug($request->name);
        $file->article=$request->article;

        if($request->hasFile('sheet')){
          $article=Article::findOrFail($request->article);
          $fileName=str_slug($file->name).'_'.str_slug($article->title).'.'.$request->sheet->getClientOriginalExtension();
          $request->sheet->move(public_path('sheets'),$fileName);
          $file->path='sheets/'.$fileName;
        }

        $file->save();
        toastr()->success('Dosya başarıyla yüklendi.');
        return redirect()->back();
    }

}
