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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('amount');
            $table->string('status');                   // Billed (Lập hóa đơn), Paid (Thanh toán), Void (Vô hiệu hóa)
            $table->dateTime('billed_date');
            $table->dateTime('paid_date')->nullable();
            $table->dateTime('void_date')->nullable();
            // Tham chiếu đến bảng customer
            $table->bigInteger('customer_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
