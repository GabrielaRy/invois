<?php

namespace App\Http\Controllers;

use h4kuna\Ares\Exceptions\IdentificationNumberNotFoundException;
use Illuminate\Http\Request;
use h4kuna\Ares\Ares;

class AresController extends Controller
{
	/**
	 * Získá data o subjektu z ARESU dle zadaného identifikačního čísla
	 *
	 * @param Request $request
	 * @param $ico
	 */
	public function fetchData(Request $request, string $ico)
	{
		if (!$request->ajax()) {
			return redirect()->back()->with('error', 'Požadavek musí být typu AJAX');
		}

		$ares = new Ares();

		try {
			return response()->json([
				'payload' => $ares->loadData($ico)
			], 200);
		} catch (IdentificationNumberNotFoundException $e) {
			return response()->json([
				'message' => $e->getMessage()
			], 404);
		}
    }
}
