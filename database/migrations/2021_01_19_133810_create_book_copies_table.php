<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookCopiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_copies', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('book_id');
            $table->string('type');
            $table->double('price', 10, 2);
            $table->bigInteger('seller_id');
            $table->string('condition');
            $table->integer('quantity')->default(1);
            $table->integer('sold')->default(0);
            $table->integer('remainder')->default(1);
            $table->string('status')->default('available');
            $table->string('image')->default('logo.png');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_copies');
    }
}
