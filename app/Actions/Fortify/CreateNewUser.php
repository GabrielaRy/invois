<?php

namespace App\Actions\Fortify;

use App\Models\InvoiceSetting;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

	/**
	 * Validate and create a newly registered user.
	 *
	 * @param array $input
	 * @return \App\Models\User
	 * @throws \Illuminate\Validation\ValidationException
	 */
    public function create(array $input)
    {
        Validator::make($input, [
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        $user = User::create([
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        InvoiceSetting::create([
        	'user_id' => $user->id
		]);

        return $user;
    }
}
