<?php

namespace Database\Factories;

use App\Models\InvoiceItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InvoiceItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'invoice_id' => 1,
			'name' => $this->faker->sentence(4),
			'amount' => $this->faker->numberBetween(1, 20),
			'unit' => 'ks',
            'price' => $this->faker->numberBetween(100, 20000),
			'vat' => $this->faker->numberBetween(0, 21),
            'sum' => $this->faker->randomNumber(3)
		];
    }
}
