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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('storage_id');
            $table->string('storage_path');
            $table->unsignedBigInteger('uploaded_by');
            $table->boolean('is_locked')->default(false);
            // TODO: figure out what this did in the original implementation
            $table->boolean('is_dirty')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('uploaded_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
