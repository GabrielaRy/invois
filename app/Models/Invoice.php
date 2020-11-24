<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = [];

	/**
	 * StoreInvoice belongs to user
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user()
	{
		return $this->belongsTo(User::class);
    }

	/**
	 * StoreInvoice has many (invoice) items
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function items()
	{
		return $this->hasMany(InvoiceItem::class);
    }

	public function canView()
	{
		return (int) $this->user_id === (int) auth()->user()->id;
    }
}
