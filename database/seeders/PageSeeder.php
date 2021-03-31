<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $pages = ['Hakkımızda','Kariyer','Vizyon','Misyon'];
      $count = 0;
      foreach($pages as $page){
        $count++;
        DB::table('pages')->insert([
          'title'=>$page,
          'slug'=>Str::slug($page),
          'image'=>'https://pashias.net/7083/business/img/bsn.jpg',
          'content'=>'Lorem ipsum dolor sit amet, consectetur
                      adipisicing elit, sed do eiusmod tempor
                      incididunt ut labore et dolore magna aliqua.
                      Ut enim ad minim veniam, quis nostrud
                      exercitation ullamco laboris nisi ut aliquip
                      ex ea commodo consequat. Duis aute irure
                      dolor in reprehenderit in voluptate velit
                      esse cillum dolore eu fugiat nulla pariatur.
                      Excepteur sint occaecat cupidatat non proident,
                      sunt in culpa qui officia deserunt mollit anim
                      id est laborum.',
          'order'=>$count,
          'created_at'=>now(),
          'updated_at'=>now()
        ]);
    }
  }
}
