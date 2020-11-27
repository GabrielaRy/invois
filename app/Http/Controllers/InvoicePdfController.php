<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Classes\Party;

class InvoicePdfController extends Controller
{
	public function getPdf(Request $request)
	{
		$invoice = Invoice::with('items')->findOrFail($request->id);
		Gate::authorize('manage-own-invoices', $invoice);

		$user = auth()->user();

		$contractor = new Party([
			'name' => $invoice->contractor_name,
			'custom_fields' => [
				'Ulice' => $invoice->contractor_street,
				'Město' => $invoice->contractor_postcode . ' ' . $invoice->contractor_city,
				'Země' => $invoice->contractor_country,
				'IČO' => $invoice->contractor_identification_number,
				"DIČ" => $invoice->contractor_tax_identification_number ?? '',
			]
		]);

		$customer = new Party([
			'name' => $invoice->customer_name,
			'custom_fields' => [
				'Ulice' => $invoice->customer_street,
				'Město' => $invoice->customer_postcode . ' ' . $invoice->customer_city,
				'Země' => $invoice->customer_country,
				'IČO' => $invoice->customer_identification_number,
				"DIČ" => $invoice->customer_tax_identification_number ?? '',
			]
		]);

		$items = [];

		foreach ($invoice->items as $item) {
			$items[] = (new InvoiceItem())->title($item->name)->pricePerUnit($item->price)->quantity($item->amount)->units($item->unit)->taxByPercent($item->vat);
		}

		$invoice = \LaravelDaily\Invoices\Invoice::make('FAKTURA')
			->seller($contractor)
			->buyer($customer)
			->currencySymbol('Kč')
			->currencyCode('CZK')
			->currencyFormat('{VALUE} {SYMBOL}')
			->currencyThousandsSeparator(',')
			->currencyDecimalPoint('.')
			->setCustomData($invoice->invoice_number)
			->filename($invoice->contractor_name . '_' . $invoice->invoice_number)
			->addItems($items)
			->notes($invoice->note ?? '');

		return $invoice->stream();
	}
}
