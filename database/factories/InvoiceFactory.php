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
		$identificationNumber = $this->faker->randomNumber(9);
		$paymentTime = $this->faker->numberBetween(1, 30);

		return [
			'user_id' => 1,
			'file' => '/' . implode('/', $this->faker->words($this->faker->numberBetween(0, 4))) . '/' . $this->faker->word . '.' . $this->faker->lexify('???'),

			'invoice_number' => date('Y') . '-' . $this->faker->randomNumber(4),

			'contractor_name' => $this->faker->name,
			'contractor_identification_number' => $identificationNumber,
			'contractor_tax_identification_number' => 'CZ' . $identificationNumber,
			'contractor_street' => $this->faker->streetAddress,
			'contractor_city' => $this->faker->city,
			'contractor_postcode' => $this->faker->postcode,
			'contractor_country' => $this->faker->country,
			'customer_name' => $this->faker->name,
			'customer_identification_number' => $identificationNumber,
			'customer_tax_identification_number' => 'CZ' . $identificationNumber,
			'customer_street' => $this->faker->streetAddress,
			'customer_city' => $this->faker->city,
			'customer_postcode' => $this->faker->postcode,
			'customer_country' => $this->faker->country,

			'bank_account_number' => $this->faker->bankAccountNumber,
			'bank_account_iban' => $this->faker->iban(),
			'bank_account_swift' => $this->faker->swiftBicNumber,

			'variable_symbol' => $this->faker->randomNumber(9),
			'constant_symbol' => $this->faker->randomNumber(9),
			'specific_symbol' => $this->faker->randomNumber(9),
			'payment_type' => 'bankovní převod',

			'total_sum' => $this->faker->randomNumber(5),

			'issue_date' => now(),
			'due_date' => now()->addDays($paymentTime),

			'note' => $this->faker->paragraph
		];
	}
}
