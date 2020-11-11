<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
		$identificationNumber = $this->faker->randomNumber(9);

        return [
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'is_admin' => false,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),

			'identification_number' => $identificationNumber,
			'tax_identification_number' => 'CZ' . $identificationNumber,
			'company_name' => $this->faker->company,
			'street' => $this->faker->streetAddress,
			'city' => $this->faker->city,
			'postcode' => $this->faker->postcode,
			'country' => $this->faker->country,
			'contact_person_name' => $this->faker->name,
			'contact_person_phone' => $this->faker->phoneNumber,
			'contact_person_email' => $this->faker->safeEmail,
			'contact_person_website' => 'invois.cz'
        ];
    }
}
