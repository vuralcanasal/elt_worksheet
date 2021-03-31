<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;


use App\Models\Article;
use App\Models\Category;
use App\Models\Page;
use App\Models\Config;
use App\Models\Sheet;

class Homepage extends Controller
{
    public function __construct(){
      if(Config::find(1)->active==0){
        return redirect()->to('bakım')->send();
      }
      view()->share('pages',Page::where('status',1)->orderBy('order','ASC')->get());
      view()->share('categories',Category::where('status',1)->orderBy('name','DESC')->get());
    }
    public function index(){
      $data['articles']=Article::with('getCategory')->where('status',1)->whereHas('getCategory',function($query){
        $query->where('status',1);
      })->orderBy('created_at','DESC')->paginate(3);
      return view('front.homepage',$data);
    }

    public function single($category,$slug){
      $category=Category::whereSlug($category)->first() ?? abort(403,'The category is not found..');
      $article=Article::whereSlug($slug)->whereCategory($category->id)->first() ?? abort(403,'The article is not found..');
      $sheets=Sheet::where('article',$article->id)->get();
      return view('front.single',compact('article','sheets'));
    }

    public function category($slug){
      $category=Category::whereSlug($slug)->first() ?? abort(403,'The category is not found..');
      $data['articles']=Article::where('category',$category->id)->where('status',1)->orderBy('created_at','DESC')->paginate(3);
      $data['category']=$category;
      return view('front.category',$data);
    }

    public function page($slug){
      $page=Page::whereSlug($slug)->first() ?? abort(403,'The page is not found..');
      $data['page']=$page;
      return view('front.page',$data);
    }

    public function contact(){
      return view('front.contact');
    }



    public function filedownload($id){
      $sheet=Sheet::find($id);
      return response()->download(public_path($sheet->path));
    }
}
