<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::table('images', function (blueprint $table): void {
            Schema::disableForeignKeyConstraints();
            $table->dropColumn('document_id');
            Schema::enableForeignKeyConstraints();
        });
        Schema::table('documents', function (Blueprint $table) {
            $table->unsignedBigInteger('image_id');
            $table->foreign('image_id')->references('id')->on('images');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->dropColumn('image_id');
            Schema::enableForeignKeyConstraints();
        });

        Schema::table('images', function (Blueprint $table) {
            $table->unsignedBigInteger('document_id');
            $table->foreign('document_id')->references('id')->on('documents');
        });
    }
};
