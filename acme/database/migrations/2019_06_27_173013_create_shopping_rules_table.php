<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShoppingRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopping_rules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('status');
            $table->string('rule_type'); // multibuy / second_half_price / basket total / etc... - since experimenting only, second_half_price will be only honored.
            $table->string('description');
            $table->string('condition'); // serialised or json condition
            $table->string('discount_type'); // fixed or percentage
            $table->float('discount_amount',8, 2);
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
        Schema::dropIfExists('shopping_rules');
    }
}
