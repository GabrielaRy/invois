<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function edit() {

        $id = auth()->user()->id;

        $user = User::findorFail($id);

        return view('app/user/edit', compact('user'));
        
    }

    public function update (Request $request) {

        $request->validate([
            'identificationNumber'  => 'required|min:8',
            'taxIdentificationNumber'  => 'nullable|string',
            'street'  => 'required|string',
            'city'  => 'required|string',
            'postcode'  => 'required|string',
            'country'  => 'required|string',
            'contactPersonName' => 'nullable|string',
            'contactPersonPhone' => 'nullable|string',
            'contactPersonEmail' => 'nullable|string',
            'contactPersonWebsite' => 'nullable|string',
            
        ]);
        $id = auth()->user()->id;
        
        $user = User::findOrFail($id);

        $user->identification_number = $request->input('identificationNumber');
        $user->tax_identification_number = $request->input('taxIdentificationNumber');
        $user->company_name = $request->input('companyName');
        $user->street = $request->input('street');
        $user->city = $request->input('city');
        $user->postcode = $request->input('postcode');
        $user->country = $request->input('country');
        $user->contact_person_name = $request->input('contactPersonName');
        $user->contact_person_phone = $request->input('contactPersonPhone');
        $user->contact_person_email = $request->input('contactPersonEmail');
        $user->contact_person_website = $request->input('contactPersonWebsite');

        $user->save();

        return redirect()->route('user.edit', $id)->with('success', 'Změny byly uloženy');
    }

}
