<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class CustomerController extends Controller
{
    public function index() {

        $userId =  auth()->user()->id;

        $customers = Customer::where('user_id', $userId)->get();

        return view('app/customer/index', compact('customers'));

    }

    public function show($id) {

        $customer = Customer::findOrFail($id);

        return view('app/customer/show', compact('customer'));
    }

    public function edit($id) {
        $customer = Customer::findOrFail($id);

        return view('app/customer/edit', compact('customer'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required',
            'identification_number'  => 'nullable|min:8',
            'tax_identification_number'  => 'nullable|string',
            'street'  => 'required|string',
            'city'  => 'required|string',
            'postcode'  => 'required|string',
            'country'  => 'required|string',
            'contact_person_name' => 'nullable|string',
            'contact_person_number' => 'nullable|string',
            'contact_person_email' => 'nullable|string',
            'note' => 'nullable|string',
            'invoice_due_date' => 'nullable|string'
        ]);

        $customer = Customer::findOrFail($id);

        $customer->name = $request->input('name');
        $customer->identification_number = $request->input('identification_number');
        $customer->tax_identification_number = $request->input('tax_identification_number');
        $customer->street = $request->input('street');
        $customer->city = $request->input('city');
        $customer->postcode = $request->input('postcode');
        $customer->country = $request->input('country');
        $customer->contact_person_name = $request->input('contact_person_name');
        $customer->contact_person_phone = $request->input('contact_person_phone');
        $customer->contact_person_email = $request->input('contact_person_email');
        $customer->note = $request->input('note');
        $customer->due_date = $request->input('invoice_due_date');

        $customer->save();

        return redirect()->route('customers.show', $id)->with('success', 'Změny byly uloženy');
    }

    public function create() {

        return view ('app/customer/create');
    }

    public function store(Request $request) {

        $request->validate([
            'name' => 'required',
            'identification_number'  => 'nullable|min:8',
            'tax_identification_number'  => 'nullable|string',
            'street'  => 'required|string',
            'city'  => 'required|string',
            'postcode'  => 'required|string',
            'country'  => 'required|string',
            'contact_person_name' => 'nullable|string',
            'contact_person_number' => 'nullable|string',
            'contact_person_email' => 'nullable|string',
            'note' => 'nullable|string',
            'invoice_due_date' => 'nullable|string'
        ]);

        $userId =  auth()->user()->id;

        $customer = new Customer;

        $customer->id = $request->input('id');
        $customer->user_id = $userId;
        $customer->name = $request->input('name');
        $customer->identification_number = $request->input('identification_number');
        $customer->tax_identification_number = $request->input('tax_identification_number');
        $customer->street = $request->input('street');
        $customer->city = $request->input('city');
        $customer->postcode = $request->input('postcode');
        $customer->country = $request->input('country');
        $customer->contact_person_name = $request->input('contact_person_name');
        $customer->contact_person_phone = $request->input('contact_person_phone');
        $customer->contact_person_email = $request->input('contact_person_email');
        $customer->note = $request->input('note');
        $customer->due_date = $request->input('invoice_due_date');

        $customer->save();

        return redirect()->route('customers.index')->with('success', 'Nový zákazník byl vytvořen');
    }

    public function destroy($id) {

        $customer = Customer::destroy($id);

        return redirect()->route('customers.index')->with('success', 'Zákazník byl smazán');
    }

	/**
	 * Metoda pro načítání customera z AJAXU
	 *
	 * @param Request $request
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
	 */
	public function retrieveCustomer(Request $request, $id)
	{
		if (!$request->ajax()) {
			return redirect()->back()->with('error', 'Požadavek musí být typu AJAX');
		}

		$customer = Customer::find($id);

		if (Gate::denies('manage-own-customers', $customer)) {
			return response()->json([
				'message' => 'Pro tuto akci nemáte dostatečná oprávnění'
			], 401);
		}

		return response()->json([
			'payload' => $customer
		], 200);
    }
}
