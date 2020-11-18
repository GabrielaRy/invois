<?php

namespace App\Http\Controllers;

use App\Models\InvoiceSetting;
use Illuminate\Http\Request;

class InvoiceSettingsController extends Controller
{
    /**
     * Show edit form 
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $userId =  auth()->user()->id;

        $invoiceSetting = InvoiceSetting::where('user_id', $userId);

        return view('app.invoiceSetting.edit', compact('invoiceSetting')) ;

    }


    /**
     * Update invoice settings
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {    
        $userId =  auth()->user()->id;

        $request->validate([
            // 'logo' => 'image:jpeg,jpg,png,gif,svg,pdf',
            // 'signature' => 'image:jpeg,jpg,png,gif,svg,pdf',
            'constant_symbol' => 'required|min:4',
            'payment_type'  => 'required|in:Bankovní převod,Hotovost,Dobírka,Záloha',
            'due_date'  => 'required|max:365',

        ]);


        $invoiceSetting = new InvoiceSetting;

        $invoiceSetting->user_id = $userId;
        $invoiceSetting->logo = $request->input('logo');
        $invoiceSetting->signature = $request->input('signature');
        $invoiceSetting->constant_symbol = $request->input('constant_symbol');
        $invoiceSetting->payment_type = $request->input('payment_type');
        $invoiceSetting->due_date = $request->input('due_date');

        $invoiceSetting->save();

        return redirect()->route('app.invoiceSettings.edit')->with('success', 'Nastavení faktur bylo úspěšně změněno');
}

}
