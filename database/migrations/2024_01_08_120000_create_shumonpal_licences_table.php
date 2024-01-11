<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShumonpalLicencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shumonpal_licences', function (Blueprint $table) {
            $table->id('id');
            $table->longText('code');
            $table->string('domain');
            $table->dateTime('created_at')->default(now());
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('shumonpal_licences');
    }
}
