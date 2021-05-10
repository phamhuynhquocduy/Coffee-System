<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributeValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_values', function (Blueprint $table) {
            $table->integer('id_attribute')->unsigned()->default(10);
            $table->integer('id_product')->unsigned()->default(10);
            $table->string('name_attr_value')->nullable()->default('text');
            $table->string('price_attr_value')->nullable()->default('text');
            $table->primary(['id_product', 'id_attribute']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attribute_values');
    }
}
