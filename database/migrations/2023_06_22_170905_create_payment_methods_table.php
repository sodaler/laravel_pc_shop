<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->boolean('redirect_to_pay')
                ->default(false);

            $table->timestamps();
        });

        DB::table('payment_methods')->insert(['title' => 'Наличными']);
        DB::table('payment_methods')->insert([
            'title' => 'Онлайн',
            'redirect_to_pay' => true
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(!app()->isProduction()) {
            Schema::dropIfExists('payment_methods');
        }
    }
};
