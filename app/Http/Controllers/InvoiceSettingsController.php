<?php

namespace App\Http\Controllers;

use App\Models\InvoiceSetting;
use Illuminate\Http\Request;

class InvoiceSettingsController extends Controller
{
	/**
	 * Show edit form
	 *
	 * @param Request $request
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
	 */
    public function edit(Request $request)
    {
        $userId =  auth()->user()->id;

        $invoiceSetting = InvoiceSetting::where('user_id', $userId)->first();

        return view('app.invoiceSetting.edit', compact('invoiceSetting')) ;
    }


    /**
     * Update invoice settings
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
	 */
    public function update(Request $request)
    {
        $userId =  auth()->user()->id;

        $request->validate([
        	'logo' => 'nullable|image:jpeg,jpg,png,gif,svg,pdf',
			'signature' => 'nullable|image:jpeg,jpg,png,gif,svg,pdf',
            'constant_symbol' => 'nullable|string|max:10',
            'payment_type'  => 'nullable|in:Bankovní převod,Hotovost,Dobírka',
            'due_date'  => 'nullable|numeric|between:1,365',
        ]);

        $invoiceSetting = InvoiceSetting::where('user_id', $userId)->first();

        $invoiceSetting->user_id = $userId;
        $invoiceSetting->logo = $request->input('logo');
        $invoiceSetting->signature = $request->input('signature');
        $invoiceSetting->constant_symbol = $request->input('constant_symbol');
        $invoiceSetting->payment_type = $request->input('payment_type');
        $invoiceSetting->due_date = $request->input('due_date');

        $invoiceSetting->save();

        return redirect()->route('invoiceSettings.edit')->with('success', 'Nastavení faktur bylo úspěšně změněno');
}

}
