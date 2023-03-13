<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Order;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Order::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->foreignId(Order::COLUMN_USER_ID)
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string(Order::COLUMN_STATUS);
            $table->string(Order::COLUMN_PRODUCT_TITLE);
            $table->integer(Order::COLUMN_TOTAL_COST);
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
        Schema::dropIfExists(Order::TABLE_NAME);
    }
};
