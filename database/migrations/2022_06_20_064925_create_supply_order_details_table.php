<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplyOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supply_order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supply_order_id');
            $table->unsignedBigInteger('supply_id');
            $table->string('qty')->default(0);
            $table->string('total_harga')->default(0);

            $table->foreign('supply_id')
                ->references('id')
                ->on('supplies');
            $table->foreign('supply_order_id')
                ->references('id')
                ->on('supply_orders');
                
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
        Schema::dropIfExists('supply_order_details');
    }
}
