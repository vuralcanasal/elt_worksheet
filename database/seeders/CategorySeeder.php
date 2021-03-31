<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['8.Sınıf','7.Sınıf','6.Sınıf','5.Sınıf'];
        foreach($categories as $category){
          DB::table('categories')->insert([
            'name'=>$category,
            'slug'=>Str::slug($category),
            'created_at'=>now(),
            'updated_at'=>now()
          ]);
        }
    }
}
