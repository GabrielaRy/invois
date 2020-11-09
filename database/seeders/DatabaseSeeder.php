<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create()->each(function ($user) {
            \App\Models\Customer::factory(10)->create(['user_id' => $user->id]);
            \App\Models\InvoiceSetting::factory(1)->create(['user_id' => $user->id]);
            \App\Models\Invoice::factory(10)->create([
            	'user_id' => $user->id,
				'contractor_name' => $user->contact_person_name,
				'contractor_identification_number' => $user->identification_number,
				'contractor_tax_identification_number' => $user->tax_identification_number,
				'contractor_street' => $user->street,
				'contractor_city' => $user->city,
				'contractor_postcode' => $user->postcode,
				'contractor_country' => $user->country
				])->each(function ($invoice) {
            	\App\Models\InvoiceItem::factory(5)->create(['invoice_id' => $invoice->id]);
			});
        });
    }
}
