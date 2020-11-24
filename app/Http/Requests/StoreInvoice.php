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
			'invoiceNumber' => 'required|string',
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
			'note' => 'nullable|string',
			'name.*' => 'required|string',
			'amount.*' => 'required|integer',
			'price.*' => 'required|integer',
			'unit.*' => 'required|string',
        ];
    }
}
