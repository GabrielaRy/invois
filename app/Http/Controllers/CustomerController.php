<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index() {

        $userId =  auth()->user()->id;

        $customers = Customer::where('user_id', $userId)->get();

        return view('customer/index', compact('customers'));
        
    }

    public function show($id) {

        $customer = Customer::findOrFail($id);

        return view('customer/show', compact('customer'));
    }

    public function edit($id) {
        $customer = Customer::findOrFail($id);

        return view('customer/edit', compact('customer'));
    }

    public function update(Request $request, $id) {

        $validator = Validator:: make($request->all(),[
            'name' => 'required',
            'identificationNumber'  => 'required|min:8',
            'taxIdentificationNumber'  => 'min:10',
            'street'  => 'required|string',
            'city'  => 'required|string',
            'postcode'  => 'required|string',
            'country'  => 'required|string',
            'contactPersonName' => 'nullable|string',
            'contactPersonNumber' => 'nullable|string',
            'contactPersonEmail' => 'nullable|string',
            'note' => 'nullable|string',
            'invoiceDueDate' => 'nullable|string'

        ]);

        if ($validator->fails()) {
            return redirect('app/customers/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $customer = Customer::findOrFail($id);

        $customer->name = $request->input('name');
        $customer->identification_number = $request->input('identificationNumber');
        $customer->tax_identification_number = $request->input('taxIdentificationNumber');
        $customer->street = $request->input('street');
        $customer->city = $request->input('city');
        $customer->postcode = $request->input('postcode');
        $customer->country = $request->input('country');
        $customer->contact_person_name = $request->input('contactPersonName');
        $customer->contact_person_phone = $request->input('contactPersonPhone');
        $customer->contact_person_email = $request->input('contactPersonEmail');
        $customer->note = $request->input('note');
        $customer->due_date = $request->input('invoiceDueDate');

        $customer->save();

        return redirect()->route('customers.show', $id)->with('success', 'Změny byly uloženy');
    }

    public function create() {
        
        return view ('customer/create');
    }

    public function store(Request $request) {

        $validator = Validator:: make($request->all(),[
            'name' => 'required',
            'identificationNumber'  => 'required|min:8',
            'taxIdentificationNumber'  => 'min:10',
            'street'  => 'required|string',
            'city'  => 'required|string',
            'postcode'  => 'required|string',
            'country'  => 'required|string',
            'contactPersonName' => 'nullable|string',
            'contactPersonNumber' => 'nullable|string',
            'contactPersonEmail' => 'nullable|string',
            'note' => 'nullable|string',
            'invoiceDueDate' => 'nullable|string'

        ]);
        
        if ($validator->fails()) {
            return redirect('app/customers/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $userId =  auth()->user()->id;

        $customer = new Customer;
        
        $customer->id = $request->input('id');
        $customer->user_id = $userId;
        $customer->name = $request->input('name');
        $customer->identification_number = $request->input('identificationNumber');
        $customer->tax_identification_number = $request->input('taxIdentificationNumber');
        $customer->street = $request->input('street');
        $customer->city = $request->input('city');
        $customer->postcode = $request->input('postcode');
        $customer->country = $request->input('country');
        $customer->contact_person_name = $request->input('contactPersonName');
        $customer->contact_person_phone = $request->input('contactPersonPhone');
        $customer->contact_person_email = $request->input('contactPersonEmail');
        $customer->note = $request->input('note');
        $customer->due_date = $request->input('invoiceDueDate');

        $customer->save();

        return redirect()->route('customers.index')->with('success', 'Nový zákazník byl uložen');
    }

    public function destroy($id) {

        $customer = Customer::destroy($id);
        
        return redirect()->route('customers.index')->with('success', 'Zákazník byl smazán');


    }
}
