<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id')->nullable();
            $table->bigInteger('loan_amount')->nullable();
            $table->integer('state_incorporation_id')->nullable();
            $table->tinyInteger('is_business_operating')->comment('1 yes 0 no')->nullable();
            $table->integer('fed_tax_id')->nullable();
            $table->string('industry_type')->nullable();
            $table->tinyInteger('due_status')->comment('1 yes 0 no')->nullable();
            $table->decimal('due_amount', 30, 2)->nullable();
            $table->text('lender_names')->nullable();
            $table->tinyInteger('due_contract')->comment('1 yes 0 no')->nullable();
            $table->string('contract_file')->nullable();
            $table->string('billing_street_address')->nullable();
            $table->integer('billing_city_id')->nullable();
            $table->integer('billing_state_id')->nullable();
            $table->integer('billing_zipcode')->nullable();
            $table->string('billing_phone')->nullable();
            $table->string('mode')->nullable();
            $table->decimal('amount_per_year', 30, 2)->nullable();
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
        Schema::dropIfExists('applications');
    }
}
