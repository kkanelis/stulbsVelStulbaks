<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('assignment_files', function (Blueprint $table) {
            $table->string('path')->nullable()->change();
            $table->string('original_name')->nullable()->change();
            $table->string('mime')->nullable()->change();
            $table->bigInteger('size')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('assignment_files', function (Blueprint $table) {
            $table->string('path')->nullable(false)->change();
            $table->string('original_name')->nullable(false)->change();
            $table->string('mime')->nullable(false)->change();
            $table->bigInteger('size')->nullable(false)->change();
        });
    }
};
