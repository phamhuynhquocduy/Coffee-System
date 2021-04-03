<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->default('text'); // tên sản phẩm
            $table->text('description')->nullable(); // mô tả sản phẩm
            $table->string('image')->nullable()->default('text'); // hình ảnh sản phẩm
            $table->double('price'); //giá tiền
            $table->integer('id_category')->unsigned()->default(10); // danh mục sản phẩm
            $table->string('status'); // tình trạng sản phẩm
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
