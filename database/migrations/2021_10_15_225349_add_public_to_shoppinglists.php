<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPublicToShoppinglists extends Migration
{
    public function up()
    {
        Schema::table('shoppinglists', function (Blueprint $table) {
            $table->boolean('public')->default(0)->after('user_id');
        });
    }
    public function down()
    {
        Schema::table('shoppinglists', function (Blueprint $table) {
            $table->dropColumn('public');
        });
    }
}
