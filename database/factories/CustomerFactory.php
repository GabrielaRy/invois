<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $identificationNumber = $this->faker->randomNumber(9);

        return [
            'user_id' => 1,
            'name' => $this->faker->word,
            'identification_number' => $identificationNumber,
            'tax_identification_number' => 'CZ' . $identificationNumber,
            'street' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'postcode' => $this->faker->postcode,
            'country' => $this->faker->country,
            'contact_person_name' => $this->faker->name,
            'contact_person_phone' => $this->faker->phoneNumber,
            'contact_person_email' => $this->faker->email,
            'note' => $this->faker->sentence,
            'invoice_due_date' => 14
        ];
    }
}
