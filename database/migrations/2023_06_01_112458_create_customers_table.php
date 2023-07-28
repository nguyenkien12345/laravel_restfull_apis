<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->integer('age');
            $table->boolean('gender');
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->string('type'); // Chỉ có 2 loại: 1 là cá nhân 2 là doanh nghiệp
            $table->text('note')->default('')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
