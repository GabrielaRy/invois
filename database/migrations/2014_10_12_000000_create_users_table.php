<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('is_admin')->default(false);
            $table->string('password');

			$table->string('identification_number', 50)->nullable();
			$table->string('tax_identification_number', 50)->nullable();
			$table->string('company_name', 255)->nullable();
			$table->string('street', 255)->nullable();
			$table->string('city', 255)->nullable();
			$table->string('postcode', 50)->nullable();
			$table->string('country', 255)->nullable();
			$table->string('contact_person_name', 255)->nullable();
			$table->string('contact_person_phone', 50)->nullable();
			$table->string('contact_person_email', 255)->nullable();
			$table->string('contact_person_website', 255)->nullable();

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
