<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Config;
use Str;
use Illuminate\Support\Facades\File;

class ConfigController extends Controller
{
    public function index(){
      $config=Config::find(1);
      return view('back.config.index',compact('config'));
    }

    public function update(Request $request){
      $config=Config::find(1);
      $config->title=$request->title;
      $config->active=$request->active;
      $config->facebook=$request->facebook;
      $config->instagram=$request->instagram;
      $config->twitter=$request->twitter;
      $config->linkedin=$request->linkedin;
      $config->email=$request->email;

      if($request->hasFile('logo')){
        $logo=str_slug($request->title).'-logo.'.$request->logo->getClientOriginalExtension();
        $request->logo->move(public_path('uploads'),$logo);
        $config->logo='uploads/'.$logo;
      }

      if($request->hasFile('favicon')){
        $favicon=str_slug($request->title).'-favicon.'.$request->favicon->getClientOriginalExtension();
        $request->favicon->move(public_path('uploads'),$favicon);
        $config->fovicon='uploads/'.$favicon;
      }

      $config->save();
      toastr()->success('Ayarlar başarıyla güncellendi.');
      return redirect()->back();
    }

    public function favicon(){
        $config=Config::find(1);
        if(File::exists($config->favicon)){
          File::delete(public_path($config->favicon));
          $config->favicon="";
          $config->save();
          toastr()->success('Favicon başarıyla silindi.');
        }
        else{
          toastr()->error('Kayıtlı bir favicon bulunmamaktadır.');
        }

        return redirect()->back();
    }
  

    public function logo(){
      $config=Config::find(1);
      if(File::exists($config->logo)){
        File::delete(public_path($config->logo));
        $config->logo="";
        $config->save();
        toastr()->success('Logo başarıyla silindi.');
      }
      else{
        toastr()->error('Kayıtlı bir logo bulunmamaktadır.');
      }

      return redirect()->back();
    }

}
