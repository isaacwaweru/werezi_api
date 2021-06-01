<?php

use Illuminate\Database\Seeder;
use App\Models\Publisher;
use Illuminate\Support\Facades\DB;

class PublisherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Publisher::truncate();

        DB::connection('old')->table('publishers')->get()->each(function($publisher) {
            Publisher::create([
                'id' => $publisher->id,
                'name' => $publisher->name
            ]);
        });
    }
}
