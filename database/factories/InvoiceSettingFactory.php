<?php

namespace Database\Factories;

use App\Models\InvoiceSetting;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceSettingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InvoiceSetting::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
		$identificationNumber = $this->faker->randomNumber(9);
		$paymentTime = $this->faker->numberBetween(1, 30);

        return [
            'user_id' => 1,
			'logo' => '/' . implode('/', $this->faker->words($this->faker->numberBetween(0, 4))) . '/' . $this->faker->word . '.' . $this->faker->lexify('???'),
			'signature' => '/' . implode('/', $this->faker->words($this->faker->numberBetween(0, 4))) . '/' . $this->faker->word . '.' . $this->faker->lexify('???'),
			'constant_symbol' => $this->faker->randomNumber(9),
			'payment_type' => 'bankovní převod',
			'due_date' => $paymentTime
        ];
    }
}
