<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('timestamp');
            $table->boolean('placed');
            $table->decimal('total_price', 8, 2);
            $table->integer('total_qty');
            $table->timestamps();
        });

        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained();
            $table->string('category');
            $table->string('brand');
            $table->string('name');
            $table->decimal('price', 8, 2);
            $table->integer('qty');
            $table->string('img_url');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_products');
        Schema::dropIfExists('orders');
    }
}

