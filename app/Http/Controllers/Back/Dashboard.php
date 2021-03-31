<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use App\Models\Page;
use App\Models\Config;

class Dashboard extends Controller
{
    public function index(){
      $article=Article::all()->count();
      $category=Category::all()->count();
      $page=Page::all()->count();
      return view('back.dashboard',compact('article','category','page'));
    }
}
