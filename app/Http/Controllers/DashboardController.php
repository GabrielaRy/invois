<?php

namespace App\Http\Controllers;


class DashboardController extends Controller
{
	public function index()
	{
		$currentUser = auth()->user();

		$invoicesThisMonth = $currentUser->invoices->map(function ($item) {
			return $item->created_at->month == \Carbon\Carbon::now()->month ? $item : false;
		});

		$invoicesPriceThisMonth = $invoicesThisMonth->reduce(function ($carry, $item) {
			return $carry + $item->total_sum;
		});

		return view('app.dashboard', compact('currentUser', 'invoicesThisMonth', 'invoicesPriceThisMonth'));
    }
}
