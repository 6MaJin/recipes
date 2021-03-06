<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShoppinglistsTable extends Migration
{
    public function up()
    {
        Schema::create('shoppinglists', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('note')->nullable();
            $table->string('bild')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('shoppinglists');
    }
}
