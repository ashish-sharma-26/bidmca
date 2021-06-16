<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('application_id');
            $table->longText('account_name')->nullable();
            $table->longText('account_name_alias')->nullable();
            $table->longText('account_type')->nullable();
            $table->longText('account_subtype')->nullable();
            $table->longText('account_available_balance')->nullable();
            $table->longText('account_current_balance')->nullable();
            $table->longText('account_limit')->nullable();
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
        Schema::dropIfExists('accounts');
    }
}
