<?php
/*
|--------------------------------------------------------------------------
| back Routes
|--------------------------------------------------------------------------
*/
Route::get('bakım',function(){
  return view('front.offline');
});

Route::prefix('admin')->name('admin.')->middleware('isLogin')->group(function(){
  Route::get('login','App\Http\Controllers\Back\AuthController@login')->name('login');
  Route::post('login','App\Http\Controllers\Back\AuthController@loginPost')->name('login.post');

});

Route::prefix('admin')->name('admin.')->middleware('isAdmin')->group(function(){
  Route::get('panel','App\Http\Controllers\Back\Dashboard@index')->name('dashboard');
  Route::resource('articles','App\Http\Controllers\Back\ArticleController');

  Route::get('/switch','App\Http\Controllers\Back\ArticleController@switch')->name('switch');
  Route::get('/deleteArticle/{id}','App\Http\Controllers\Back\ArticleController@delete')->name('delete.article');
  Route::get('/harddeleteArticle/{id}','App\Http\Controllers\Back\ArticleController@hardDelete')->name('hdelete.article');
  Route::get('/recover/{id}','App\Http\Controllers\Back\ArticleController@recover')->name('recover.article');
  Route::get('/trashed','App\Http\Controllers\Back\ArticleController@trashed')->name('trashed.article');
  Route::get('/fileArticle/{id}','App\Http\Controllers\Back\ArticleController@file')->name('file.article');
  Route::post('/filedelete','App\Http\Controllers\Back\ArticleController@filedelete')->name('article.filedelete');
  Route::post('/filecreate','App\Http\Controllers\Back\ArticleController@filecreate')->name('article.filecreate');


  Route::get('/categories','App\Http\Controllers\Back\CategoryController@index')->name('category.index');
  Route::get('/category/statu','App\Http\Controllers\Back\CategoryController@switch')->name('category.switch');
  Route::post('/category/create','App\Http\Controllers\Back\CategoryController@create')->name('category.create');
  Route::get('/category/edit','App\Http\Controllers\Back\CategoryController@getdata')->name('category.getdata');
  Route::post('/category/update','App\Http\Controllers\Back\CategoryController@update')->name('category.update');
  Route::post('/category/delete','App\Http\Controllers\Back\CategoryController@delete')->name('category.delete');

  Route::get('/pages','App\Http\Controllers\Back\PageController@index')->name('pages.index');
  Route::get('/page/switch','App\Http\Controllers\Back\PageController@switch')->name('pages.switch');
  Route::get('/page/create','App\Http\Controllers\Back\PageController@create')->name('pages.create');
  Route::post('/page/create','App\Http\Controllers\Back\PageController@post')->name('pages.create.post');
  Route::get('/page/update/{id}','App\Http\Controllers\Back\PageController@update')->name('pages.edit');
  Route::post('/page/update/{id}','App\Http\Controllers\Back\PageController@updatePost')->name('pages.edit.post');
  Route::get('/page/delete/{id}','App\Http\Controllers\Back\PageController@delete')->name('pages.delete');
  Route::get('/page/order','App\Http\Controllers\Back\PageController@orders')->name('pages.orders');

  Route::get('/control','App\Http\Controllers\Back\ConfigController@index')->name('config.index');
  Route::post('/control/update','App\Http\Controllers\Back\ConfigController@update')->name('config.update');
  Route::get('/control/favicon','App\Http\Controllers\Back\ConfigController@favicon')->name('config.favicon');
  Route::get('/control/logo','App\Http\Controllers\Back\ConfigController@logo')->name('config.logo');

  Route::get('logout','App\Http\Controllers\Back\AuthController@logout')->name('login.logout');
});

/*
|--------------------------------------------------------------------------
| front Routes
|--------------------------------------------------------------------------
*/

Route::get('/','App\Http\Controllers\Front\Homepage@index')->name('homepage');

Route::get('/download/{id}','App\Http\Controllers\Front\Homepage@filedownload')->name('filedownload');
Route::get('/iletisim','App\Http\Controllers\Front\Homepage@contact')->name('contact');
Route::get('/kategori/{category}','App\Http\Controllers\Front\Homepage@category')->name('category');
Route::get('/{category}/{slug}','App\Http\Controllers\Front\Homepage@single')->name('single');
Route::get('/{page}','App\Http\Controllers\Front\Homepage@page')->name('page');
