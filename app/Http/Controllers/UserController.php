<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
	public function edit()
	{

		$id = auth()->user()->id;

		$user = User::findorFail($id);

		return view('app/user/edit', compact('user'));

	}

	public function update(Request $request)
	{
		$request->validate([
			'identification_number' => 'required|min:8',
			'tax_identification_number' => 'nullable|string',
			'street' => 'required|string',
			'city' => 'required|string',
			'postcode' => 'required|string',
			'country' => 'required|string',
			'contact_person_name' => 'required|string',
			'contact_person_phone' => 'nullable|string',
			'contact_person_email' => 'nullable|string',
			'contact_person_website' => 'nullable|string',
		]);

		$id = auth()->user()->id;

		$user = User::findOrFail($id);

		$user->identification_number = $request->input('identification_number');
		$user->tax_identification_number = $request->input('tax_identification_number');
		$user->company_name = $request->input('company_name');
		$user->street = $request->input('street');
		$user->city = $request->input('city');
		$user->postcode = $request->input('postcode');
		$user->country = $request->input('country');
		$user->contact_person_name = $request->input('contact_person_name');
		$user->contact_person_phone = $request->input('contact_person_phone');
		$user->contact_person_email = $request->input('contact_person_email');
		$user->contact_person_website = $request->input('contact_person_website');

		$user->save();

		return redirect()->route('user.edit')->with('success', 'Změny byly uloženy');
	}

}
