<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name', 255);
            $table->string('identification_number', 50)->nullable();
            $table->string('tax_identification_number', 50)->nullable();
            $table->string('street', 255);
            $table->string('city', 255);
            $table->string('postcode', 50);
            $table->string('country', 255);
            $table->string('contact_person_name', 255)->nullable();
            $table->string('contact_person_phone', 50)->nullable();
            $table->string('contact_person_email', 255)->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
