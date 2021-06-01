<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\FeaturedItem;

class FeaturedItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FeaturedItem::truncate();

        DB::connection('old')->table('featureds')->get()->each(function($item) {
            FeaturedItem::create([
                'title' => $item->title,
                'target' => $item->target
            ]);
        });
    }
}
