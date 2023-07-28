<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo ra 25 customer. Mỗi customer này sẽ có 10 hóa đơn tương ứng
        Customer::factory()->count(25)->hasInvoices(10)->create();

        // Tạo ra 10 customer. Mỗi customer này sẽ có 5 hóa đơn tương ứng
        Customer::factory()->count(10)->hasInvoices(5)->create();

        // Tạo ra 10 customer. Mỗi customer này sẽ có 3 hóa đơn tương ứng
        Customer::factory()->count(10)->hasInvoices(3)->create();

        // Tạo ra 5 customer. Mỗi customer này không có hóa đơn nào cả
        Customer::factory()->count(5)->create();

        // Tổng cộng ta sẽ có 50 customer và 330 invoice (250 + 50 + 30) được tạo
    }
}
