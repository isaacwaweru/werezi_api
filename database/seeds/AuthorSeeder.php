<?php

use Illuminate\Database\Seeder;
use App\Models\Author;
use Illuminate\Support\Facades\DB;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Author::truncate();

        DB::connection('old')->table('authors')->get()->each(function($author) {
            Author::create([
                'id' => $author->id,
                'name' => $author->name
            ]);
        });
    }
}
