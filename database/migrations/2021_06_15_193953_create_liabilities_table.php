<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiabilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liabilities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('application_id');
            $table->tinyInteger('type')->comment('1 credit 2 mortgage 3 student');
            $table->longText('account_name')->nullable();
            $table->longText('overdue')->nullable();
            $table->longText('last_payment')->nullable();
            $table->longText('last_payment_date')->nullable();
            $table->longText('last_statement')->nullable();
            $table->longText('last_statement_date')->nullable();
            $table->longText('principal_amount')->nullable();
            $table->longText('originate_date')->nullable();
            $table->longText('maturity_date')->nullable();
            $table->longText('ir')->nullable();
            $table->longText('guarantor')->nullable();
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
        Schema::dropIfExists('liabilities');
    }
}
