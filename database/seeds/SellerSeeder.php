<?php

use Illuminate\Database\Seeder;
use App\Models\Seller;

class SellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Seller::truncate();
        
        Seller::create([
            'name' => 'werezi Books'
        ]);
    }
}
