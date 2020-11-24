<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

	/**
	 * StoreInvoice item belongs to invoice
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function invoice()
	{
		return $this->belongsTo(Invoice::class);
    }
}
