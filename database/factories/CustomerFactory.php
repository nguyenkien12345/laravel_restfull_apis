<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement(['I', 'B']);
        $name = $type === 'I' ? $this->faker->name() : $this->faker->company();
        $age = $this->faker->numberBetween(18, 100);
        $gender = $this->faker->boolean();
        $email = $this->faker->email();
        $phone = $this->faker->phoneNumber();
        $address = $this->faker->address();

        return [
            'name' => $name,
            'age' => $age,
            'gender' => $gender,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'type' => $type
        ];
    }
}
