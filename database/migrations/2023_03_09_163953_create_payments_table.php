<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Payment;
use App\Models\User;
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
        Schema::create(Payment::TABLE_NAME, function (Blueprint $table) {
            $table->id();

            $table->foreignId(Payment::COLUMN_USER_ID)
                  ->constrained(User::TABLE_NAME)
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreignId(Payment::COLUMN_ORDER_ID)
                  ->constrained(Order::TABLE_NAME)
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->timestamp(Payment::COLUMN_PAYED_AT)
                  ->nullable();

            $table->integer(Payment::COLUMN_AMOUNT, false);

            $table->string(Payment::COLUMN_STATUS)
                ->nullable();

            $table->string(Payment::COLUMN_REFERENCE_NUMBER)
                  ->nullable();

            $table->string(Payment::COLUMN_ONLINE_PAYMENT_TOKEN)
                 ->nullable();

            $table->string(Payment::COLUMN_TRACKING_CODE)
                 ->nullable();

            $table->string(Payment::COLUMN_TRANSACTION_ID)
                 ->nullable();

            $table->string(Payment::COLUMN_CARD_NUMBER)
                 ->nullable();


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
        Schema::dropIfExists('payments');
    }
};
