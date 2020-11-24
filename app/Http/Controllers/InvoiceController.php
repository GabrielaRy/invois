<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Input;

class InvoiceController extends Controller
{
    public function index() {
        

        $userId = auth()->user()->id;

         $invoices = Invoice::where('user_id', $userId)->get();
         //$invoices = Invoice::get();

        return view('app/invoice/index', compact('invoices', 'userId'));
    }

    public function show($id) {

        $invoice = Invoice::with('items')->findOrFail($id);

        return view('app/invoice/show', compact('invoice'));
    }

    public function create() {

        $userId = auth()->user()->id;

        $user = User::findorFail($userId);
        
        $customers = Customer::where('user_id', $userId)->get();

        $record = Invoice::where('user_id', $userId)->latest()->first();
        
        if ($record === NULL) {
            $invoiceNumber = date('Y').'0001';
        } else { 

        $expNum = explode('-', $record->invoice_no);
        $year = date("Y");
        
        //check first day in a year
        if  ($year == date('l',strtotime(date('Y-01-01'))) ) {
        $invoiceNumber = date('Y').'0001';
        } else {
        //increase 1 with last invoice number
        $invoiceNumber = $expNum[0]+1;
        }
        }

        return view('app/invoice/create', compact('customers', 'user', 'invoiceNumber'));
    }

    public function store(Request $request) {

        $authUserId = auth()->user()->id;

        $userCustomers = User::find($authUserId);

        $customer = Customer::findOrFail($request->input('customerId'));

        //$savedItems = InvoiceItem:: where('invoice_id', $id)->get();
        //dd($customer->name);
        
        $request->validate([
            'invoiceNo' => 'required|string',
            'contractorName' => 'required|string',
            'contractorStreet' => 'required|string',
            'contractorCity' => 'required|string',
            'contractorPostcode' => 'required|string',
            'contractorCountry' => 'required|string',
            'contractorIdentificationNumber' => 'required|string',
            'contractorTaxIdentificationNumber' => 'nullable|string',
            'paymentType' => 'required|string',
            'bankAccountNumber' => 'nullable|string',
            'bankAccountIban' => 'nullable|string',
            'bankAccountSwift' => 'nullable|string',
            'variableSymbol' => 'required|string',
            'constantSymbol' => 'required|string',
            'specificSymbol' => 'required|string',
            'issueDate' => 'required',
            'dueDate' => 'required',
            'isPaid' => 'nullable',
            'note' => 'nullable|string',
            'name.*' => 'required|string',
            'amount.*' => 'required|string',
            'price.*' => 'required|string',
            'unit.*' => 'required|string',
 
        ]);
    

        $invoice = new Invoice;

        $invoice->user_id = $authUserId;
        $invoice->invoice_no = $request->input('invoiceNo');
        $invoice->contractor_name = $request->input('contractorName');
        $invoice->contractor_street = $request->input('contractorStreet');
        $invoice->contractor_city = $request->input('contractorCity');
        $invoice->contractor_postcode = $request->input('contractorPostcode');
        $invoice->contractor_identification_number = $request->input('contractorIdentificationNumber');
        $invoice->contractor_tax_identification_number = $request->input('contractorTaxIdentificationNumber');
        $invoice->contractor_country = $request->input('contractorCountry');
        $invoice->payment_type = $request->input('paymentType');
        $invoice->bank_account_number = $request->input('bankAccountNumber');
        $invoice->bank_account_iban = $request->input('bankAccountIban');
        $invoice->bank_account_swift = $request->input('bankAccountSwift');
        $invoice->variable_symbol = $request->input('variableSymbol');
        $invoice->constant_symbol = $request->input('constantSymbol');
        $invoice->specific_symbol = $request->input('specificSymbol');
        $invoice->issue_date = $request->input('issueDate');
        $invoice->due_date = $request->input('dueDate');
        $invoice->is_paid = $request->input('isPaid');
        $invoice->note = $request->input('note');

        $invoice->customer_name = $customer->name;
        $invoice->customer_identification_number = $customer->identification_number;
        $invoice->customer_tax_identification_number = $customer->tax_identification_number;
        $invoice->customer_street = $customer->street;
        $invoice->customer_city = $customer->city;
        $invoice->customer_postcode = $customer->postcode;
        $invoice->customer_country = $customer->country;

        $sum = 0;

        foreach ($request->input('items') as $item) {
        
            $sum += $item->price * $item->amount;
        }
        dd($sum);

        $invoice->save();
    

        $items = $request->get('items');
        
        foreach ($items as $item) {

            $itemSave = new InvoiceItem;

            $itemSave->invoice_id = $invoice->id;
            $itemSave->name = $item['name'];
            $itemSave->amount = $item['amount'];
            $itemSave->unit = $item['unit'];
            $itemSave->price = $item['price'];

            $sum = int('unit') * int('sum');

            $itemSave->sum = $sum;
            
            $itemSave->save();
        }

        return redirect()->route('invoice.index')->with('success', 'Faktura byla vytvořena');

    }

    public function edit($id) {

        $invoice = Invoice::with('items')->findOrFail($id);

        $authUserId = auth()->user()->id;

        $user = User::findOrFail($authUserId);

        $savedItems = InvoiceItem:: where('invoice_id', $id)->get();
        
        $customers = Customer::where('user_id', $authUserId)->get();

        return view('app/invoice/edit', compact('invoice', 'user', 'customers', 'savedItems'));
    }

    public function update(Request $request, $id) {
      
        $request->validate([
            'invoiceNo' => 'required|string',
            'paymentType' => 'required|string',
            'bankAccountNumber' => 'nullable|string',
            'bankAccountIban' => 'nullable|string',
            'bankAccountSwift' => 'nullable|string',
            'variableSymbol' => 'required|string',
            'constantSymbol' => 'required|string',
            'specificSymbol' => 'required|string',
            'issueDate' => 'required',
            'dueDate' => 'required',
            'isPaid' => 'nullable',
            'note' => 'nullable|string',
            'name.*' => 'required|string',
            'amount.*' => 'required|string',
            'price.*' => 'required|string',
            'unit.*' => 'required|string',

        ]);
            
        $authUserId = auth()->user()->id;

        $userCustomers = User::find($authUserId);
        
       // $customer = Customer::findOrFail($request->input('customerId'));
        
        $invoice = Invoice::findOrFail($id);
        
        $invoice->invoice_no = $request->input('invoiceNo');
        $invoice->payment_type = $request->input('paymentType');
        $invoice->bank_account_number = $request->input('bankAccountNumber');
        $invoice->bank_account_iban = $request->input('bankAccountIban');
        $invoice->bank_account_swift = $request->input('bankAccountSwift');
        $invoice->variable_symbol = $request->input('variableSymbol');
        $invoice->constant_symbol = $request->input('constantSymbol');
        $invoice->specific_symbol = $request->input('specificSymbol');
        $invoice->issue_date = $request->input('issueDate');
        $invoice->due_date = $request->input('dueDate');
        $invoice->is_paid = $request->input('isPaid');
        $invoice->note = $request->input('note');

        $invoice->save();

        $deleteItems = InvoiceItem:: where('invoice_id', $id)->delete();

        $items = $request->get('items');
        
        foreach ($items as $item) {
           
            $itemSave = new InvoiceItem;

            $itemSave->invoice_id = $invoice->id;
            $itemSave->name = $item['name'];
            $itemSave->amount = $item['amount'];
            $itemSave->unit = $item['unit'];
            $itemSave->price = $item['price'];
            $itemSave->sum = $sum;
            
            $itemSave->save();
        }
        return redirect()->route('invoice.show', $id)->with('success', 'Údaje byly změněny');
    }

    public function destroy($id) {

        $invoice = Invoice::destroy($id);
        
        return redirect()->route('invoice.index')->with('success', 'Faktura byla smazána');
    }
}
