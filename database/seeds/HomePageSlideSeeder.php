<?php

use App\Models\HomePageSlide;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HomePageSlideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HomePageSlide::truncate();

        HomePageSlide::create([
            'name' => '1', 
            'target' => 'fiction', 
            'published' => 1
        ]);

        HomePageSlide::create([
            'name' => '2', 
            'target' => 'non-fiction', 
            'published' => 1
        ]);
    }
}
