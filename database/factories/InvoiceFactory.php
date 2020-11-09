<?php

namespace Database\Factories;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Invoice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'path' => '/' . implode('/', $this->faker->words($this->faker->numberBetween(0, 4))) . '/' . $this->faker->word . '.' . $this->faker->lexify('???')
        ];
    }
}
