<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoice;
use App\Models\InvoiceItem;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;

class InvoiceController extends Controller
{
	public function index()
	{
		$user = auth()->user();

		$canCreateInvoice =
			!$user->customers->isEmpty() &&
			($user->identification_number &&
			$user->contact_person_name &&
			$user->street &&
			$user->city &&
			$user->postcode);

		return view('app.invoice.index', compact('user', 'canCreateInvoice'));
	}

	public function show(Invoice $invoice)
	{
		Gate::authorize('manage-own-invoices', $invoice);

		return view('app.invoice.show', compact('invoice'));
	}

	public function create()
	{
		$user = auth()->user();

		if ($user->customers->isEmpty()) {
			return redirect()->back()->with('warning', 'Pro vytvoření faktury musíte vytvořit zákazníka');
		} elseif (
			!$user->identification_number &&
			!$user->contact_person_name &&
			!$user->street &&
			!$user->city &&
			!$user->postcode
		) {
			return redirect()->back()->with('warning', 'Pro vytvoření faktury musíte vyplnit své fakturační údaje');
		}

		$customers = Customer::where('user_id', $user->id)->get();
		$nextInvoiceNumber = $this->generateInvoiceNumber(Invoice::where('user_id', $user->id)->latest()->first());
		$invoiceSettings = InvoiceSetting::where('user_id', $user->id)->first();

		return view('app.invoice.create', compact('customers', 'user', 'nextInvoiceNumber', 'invoiceSettings'));
	}

	public function store(StoreInvoice $request)
	{
		$request->validated();
		$user = auth()->user();

		if (!$customer = Customer::where('user_id', $user->id)->find($request->customer_id)) {
			return redirect()->back()->with('error', 'Tento zákazník neexistuje');
		};
		//TODO: Předělat na transakci
		$invoice = Invoice::create([
			'user_id' => $user->id,
			'invoice_number' => $request->invoice_number,
			'contractor_name' => $user->contact_person_name,
			'contractor_street' => $user->street,
			'contractor_city' => $user->city,
			'contractor_postcode' => $user->postcode,
			'contractor_identification_number' => $user->identification_number,
			'contractor_tax_identification_number' => $user->tax_identification_number ?? '',
			'contractor_country' => $user->country,
			'payment_type' => $request->payment_type,
			'bank_account_number' => $request->payment_type == 'Bankovní převod' ? $request->bank_account_number : null,
			'bank_account_iban' => $request->bank_account_iban,
			'bank_account_swift' => $request->bank_account_swift,
			'variable_symbol' => $request->variable_symbol,
			'constant_symbol' => $request->constant_symbol,
			'specific_symbol' => $request->specific_symbol,
			'issue_date' => $request->issue_date,
			'due_date' => (new Carbon($request->issue_date))->addDays($request->due_date)->toDateString(),
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
				'invoice_id' => $invoice->id,
				'name' => $item['name'],
				'amount' => $item['amount'],
				'unit' => $item['unit'],
				'price' => $item['price'],
				'vat' => $item['vat'] ?? 0,
				'sum' => $this->calculateVat($item['amount'], $item['price'], $item['vat'] ?? null)
			]);
		}

		return redirect()->route('invoice.show', $invoice->id)->with('success', 'Faktura byla úspěšně vytvořena');
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
			'payment_type' => $request->payment_type,
			'bank_account_number' => $request->payment_type == 'Bankovní převod' ? $request->bank_account_number : null,
			'bank_account_iban' => $request->bank_account_iban,
			'bank_account_swift' => $request->bank_account_swift,
			'variable_symbol' => $request->variable_symbol,
			'constant_symbol' => $request->constant_symbol,
			'specific_symbol' => $request->specific_symbol,
			'issue_date' => $request->issue_date,
			'due_date' => (new Carbon($request->issue_date))->addDays($request->due_date)->toDateString(),
			'is_paid' => $request->is_paid,
			'total_sum' => $this->getItemsSum($request->items),
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
			$itemSave->sum = $this->calculateVat($item['amount'], $item['price'], $item['vat'] ?? null);

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

	public function markInvoiceAsPaid(Invoice $invoice)
	{
		Gate::authorize('manage-own-invoices', $invoice);

		$invoice->is_paid = \Carbon\Carbon::now();
		$invoice->save();

		return redirect()->back()->with('success', 'Faktura byla označena jako zaplacená');
	}

	public function markInvoiceAsUnpaid(Invoice $invoice)
	{
		Gate::authorize('manage-own-invoices', $invoice);

		$invoice->is_paid = null;
		$invoice->save();

		return redirect()->back()->with('success', 'Faktura byla označena jako nezaplacená');
	}

	private function getItemsSum(array $items)
	{
		if (!empty($item['vat'])) {
			return array_reduce($items, function ($state, $item) {
				$state += ($item['price'] * $item['amount']);

				return $state;
			});
		} else {
			$sum = 0;

			foreach ($items as $item) {
				$sum += $this->calculateVat($item['amount'], $item['price'], $item['vat']);
			}

			return $sum;
		}
	}

	private function generateInvoiceNumber(?Invoice $invoice)
	{
		if (is_null($invoice)) {
			return date('Y') . '-1';
		} else {
			$lastInsertedInvoiceNumber = explode('-', $invoice->invoice_number);

			if ($lastInsertedInvoiceNumber[0] !== date('Y')) {
				return date('Y') . '-0001';
			}

			$counter = (int)$lastInsertedInvoiceNumber[1];
			return date('Y') . '-' . ++$counter;
		}
	}

	private function calculateVat($amount, $price, $vat)
	{
		if (!$vat) {
			return round((int)$amount * (int)$price, 2);
		} else {
			return round(((int)$price * (int)$amount) * floatval(1 . '.' . $vat), 2);
		}
	}
}
