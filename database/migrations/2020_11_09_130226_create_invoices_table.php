<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('file', 255)->nullable();

			$table->string('contractor_name', 255);
			$table->string('contractor_identification_number', 50);
			$table->string('contractor_tax_identification_number', 50);
			$table->string('contractor_street', 255);
			$table->string('contractor_city', 255);
			$table->string('contractor_postcode', 50);
			$table->string('contractor_country', 255);

			$table->string('customer_name', 255);
			$table->string('customer_identification_number', 50);
			$table->string('customer_tax_identification_number', 50);
			$table->string('customer_street', 255);
			$table->string('customer_city', 255);
			$table->string('customer_postcode', 50);
			$table->string('customer_country', 255);

			$table->string('bank_account_number', 255)->nullable();
			$table->string('bank_account_iban', 255)->nullable();
			$table->string('bank_account_swift', 255)->nullable();

			$table->string('variable_symbol', 50);
			$table->string('constant_symbol', 50);
			$table->string('specific_symbol', 50);
			$table->string('payment_type', 50);

			$table->date('issue_date');
            $table->date('due_date');

            $table->datetime('is_paid')->nullable();

			$table->text('note')->nullable();

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
