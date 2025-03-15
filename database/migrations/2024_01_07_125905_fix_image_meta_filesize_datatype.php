<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('image_meta', function (Blueprint $table) {
            $table->dropColumn('current_filesize');
        });
        Schema::table('image_meta', function (Blueprint $table) {
            $table->unsignedInteger('current_filesize');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('image_meta', function (Blueprint $table) {
            $table->dropColumn('current_filesize');
        });
        Schema::table('image_meta', function (Blueprint $table) {
            $table->string('current_filesize');
        });
    }
};
