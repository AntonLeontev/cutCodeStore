<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->boolean('on_home')->default(0);
        });
    }


    public function down()
    {
        if (!app()->isProduction()) {
            Schema::table('brands', function (Blueprint $table) {
                $table->dropColumn('on_home');
            });
        }
    }
};
