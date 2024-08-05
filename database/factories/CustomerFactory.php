<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Customer;
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
// get the type of what the customer is going to be (Individual(I) or business(B))

$type = $this->faker->randomElement(['I', 'B']);
$name = $type == 'I' ? $this->faker->name() : $this->faker->company();

        return [
            'name' => $name,
            'type' => $type,
            'email' => $this->faker->email(),
            'address' => $this->faker->streetAddress(),
            'city'=> $this->faker->city(),
            'state' => $this->faker->state(),
            'postal_code' => $this->faker->postCode()
            
        ];
    }
}
