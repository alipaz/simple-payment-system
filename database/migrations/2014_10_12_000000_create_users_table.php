<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(User::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string(User::COLUMN_FIRST_NAME, 100);
            $table->string(User::COLUMN_LAST_NAME, 100);
            $table->string(User::COLUMN_EMAIL, 100)
                ->unique()
                ->index();
            $table->timestamp(User::COLUMN_EMAIL_VERIFIED_AT)->nullable();
            $table->string(User::COLUMN_PHONE_NUMBER, 11)
                ->nullable(true)
                ->index();
            $table->timestamp(User::COLUMN_MOBILE_VERIFIED_AT)
                ->nullable(true);
            $table->string(User::COLUMN_CARD_NUMBER, 16)
                ->unique()
                ->nullable(true);
            $table->string(User::COLUMN_PASSWORD);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
