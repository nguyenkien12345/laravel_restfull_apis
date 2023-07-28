<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Customer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // random customer_id theo đối tượng Customer
        $customer_id = Customer::factory();
        $status = $this->faker->randomElement(['Billed', 'Paid', 'Void']);
        $amount = $this->faker->numberBetween(100, 100000);
        $billed_date = $this->faker->dateTimeThisDecade();
        $paid_date = $status === 'Billed' ? $this->faker->dateTimeThisDecade() : NULL;

        return [
            'customer_id' => $customer_id,
            'amount' => $amount,
            'status' => $status,
            'billed_date' => $billed_date,
            'paid_date' => $paid_date,
        ];
    }
}
