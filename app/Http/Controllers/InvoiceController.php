<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoice;
use App\Models\InvoiceItem;
use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Support\Facades\Gate;

class InvoiceController extends Controller
{
	public function index()
	{
		$userId = auth()->user()->id;
		$invoices = Invoice::where('user_id', $userId)->get();

		return view('app.invoice.index', compact('invoices'));
	}

	public function show(Invoice $invoice)
	{
		Gate::authorize('manage-own-invoices', $invoice);

		return view('app.invoice.show', compact('invoice'));
	}

	public function create()
	{
		$user = auth()->user();

		$customers = Customer::where('user_id', $user->id)->get();
		$nextInvoiceNumber = $this->generateInvoiceNumber(Invoice::where('user_id', $user->id)->latest()->first());

		return view('app.invoice.create', compact('customers', 'user', 'nextInvoiceNumber'));
	}

	public function store(StoreInvoice $request)
	{
		$request->validated();

		$user = auth()->user();

		if (!$customer = Customer::where('user_id', $user->id)->find($request->customerId)) {
			return redirect()->back()->with('error', 'Tento zákazník neexistuje');
		};

		$invoice = Invoice::create([
			'user_id' => $user->id,
			'invoice_number' => $request->invoiceNumber,
			'contractor_name' => $request->contractorName,
			'contractor_street' => $request->contractorStreet,
			'contractor_city' => $request->contractorCity,
			'contractor_postcode' => $request->contractorPostcode,
			'contractor_identification_number' => $request->contractorIdentificationNumber,
			'contractor_tax_identification_number' => $request->contractorTaxIdentificationNumber,
			'contractor_country' => $request->contractorCountry,
			'payment_type' => $request->paymentType,
			'bank_account_number' => $request->bankAccountNumber,
			'bank_account_iban' => $request->bankAccountIban,
			'bank_account_swift' => $request->bankAccountSwift,
			'variable_symbol' => $request->variableSymbol,
			'constant_symbol' => $request->constantSymbol,
			'specific_symbol' => $request->specificSymbol,
			'issue_date' => $request->issueDate,
			'due_date' => $request->dueDate,
			'note' => $request->note,

			'customer_name' => $customer->name,
			'customer_identification_number' => $customer->identification_number,
			'customer_tax_identification_number' => $customer->tax_identification_number,
			'customer_street' => $customer->street,
			'customer_city' => $customer->city,
			'customer_postcode' => $customer->postcode,
			'customer_country' => $customer->country,

			'total_sum' => $this->getItemsSum($request->items),
		]);


		foreach ($request->items as $item) {
			InvoiceItem::create([
				'invoice_id' => $request->id,
				'name' => $item['name'],
				'amount' => $item['amount'],
				'unit' => $item['unit'],
				'price' => $item['price'],
				'sum' => (int)$item['amount'] * (int)$item['price'],
			]);
		}

		return redirect()->route('invoice.show', $request->id)->with('success', 'Faktura byla úspěšně vytvořena');
	}

	public function edit(Invoice $invoice)
	{
		Gate::authorize('manage-own-invoices', $invoice);

		$savedItems = $invoice->getRelationValue('items');
		$user = auth()->user();
		$customers = Customer::where('user_id', $user->id)->get();

		return view('app/invoice/edit', compact('invoice', 'user', 'customers', 'savedItems'));
	}

	public function update(StoreInvoice $request, $id)
	{

		$request->validated();

		$invoice = Invoice::findOrFail($id);
		Gate::authorize('manage-own-invoices', $invoice);

		$invoice->update([
			'payment_type' => $request->paymentType,
			'bank_account_number' => $request->bankAccountNumber,
			'bank_account_iban' => $request->bankAccountIban,
			'bank_account_swift' => $request->bankAccountSwift,
			'variable_symbol' => $request->variableSymbol,
			'constant_symbol' => $request->constantSymbol,
			'specific_symbol' => $request->specificSymbol,
			'issue_date' => $request->issueDate,
			'due_date' => $request->dueDate,
			'is_paid' => $request->isPaid,
			'note' => $request->note,
		]);

		InvoiceItem::where('invoice_id', $invoice->id)->delete();

		foreach ($request->items as $item) {
			$itemSave = new InvoiceItem;

			$itemSave->invoice_id = $invoice->id;
			$itemSave->name = $item['name'];
			$itemSave->amount = $item['amount'];
			$itemSave->unit = $item['unit'];
			$itemSave->price = $item['price'];
			$itemSave->sum = (int)$item['amount'] * (int)$item['price'];

			$itemSave->save();
		}

		return redirect()->route('invoice.show', $id)->with('success', 'Faktura byla úspěšně změněna');
	}

	public function destroy(Invoice $invoice)
	{
		Gate::authorize('manage-own-invoices', $invoice);

		Invoice::destroy($invoice->id);

		return redirect()->route('invoice.index')->with('success', 'Faktura byla úspěšně smazána');
	}

	private function getItemsSum(array $items)
	{
		return array_reduce($items, function ($state, $item) {
			$state += ($item['price'] * $item['amount']);

			return $state;
		});
	}

	private function generateInvoiceNumber(?Invoice $invoice)
	{
		if (is_null($invoice)) {
			return date('Y') . '-0001';
		} else {
			$lastInsertedInvoiceNumber = explode('-', $invoice->invoice_number);

			if ($lastInsertedInvoiceNumber[0] !== date('Y')) {
				return date('Y') . '-0001';
			}

			$counter = (int)$lastInsertedInvoiceNumber[1];
			return date('Y') . '-' . ++$counter;
		}
	}
}
