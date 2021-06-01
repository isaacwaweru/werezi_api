<?php

use Illuminate\Database\Seeder;
use App\Models\Category;
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
        Category::truncate();
        
        DB::connection('old')->table('categories')->get()->each(function($category) {
            Category::create([
                'id' => $category->id,
                'name' => $category->title,
                'parent' => $category->parent_id
            ]);
        });
    }
}
