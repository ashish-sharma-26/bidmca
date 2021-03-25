<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateApplicationV1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('unique_id')->nullable();
            $table->string('business_name')->after('user_id')->nullable();
            $table->string('signature_file')->after('billing_phone2')->nullable();
            $table->string('account_email')->after('billing_phone2')->nullable();
            $table->integer('status')->after('billing_phone2')->nullable()->comment('1 draft 2 pending 3 approved 4 rejected');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn('signature_file');
            $table->dropColumn('business_name');
            $table->dropColumn('account_email');
        });
    }
}
