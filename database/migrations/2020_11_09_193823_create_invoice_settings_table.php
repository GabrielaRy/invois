<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
			$table->string('logo', 255)->nullable();
			$table->string('signature', 255)->nullable();
			$table->string('constant_symbol', 50)->nullable();
			$table->string('payment_type', 50)->nullable();
			$table->smallInteger('due_date')->nullable()->unsigned();
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
        Schema::dropIfExists('invoice_settings');
    }
}
