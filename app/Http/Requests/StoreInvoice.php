<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoice extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
    	// Autorizaci zajišťuje middleware
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
			'invoice_number' => 'required|string',
			'payment_type' => 'required|string',
			'bank_account_number' => 'nullable|string',
			'bank_account_iban' => 'nullable|string',
			'bank_account_swift' => 'nullable|string',
			'variable_symbol' => 'string',
			'constant_symbol' => 'string',
			'specific_symbol' => 'string',
			'issue_date' => 'required',
			'due_date' => 'required',
			'note' => 'nullable|string',
			'items.*.name' => 'required|string',
			'items.*.amount' => 'required|integer',
			'items.*.price' => 'required|regex:/^\d*(\.\d{2})?$/',
			'items.*.unit' => 'required|string',
        ];
    }
}
