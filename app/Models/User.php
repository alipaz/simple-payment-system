<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    const TABLE_NAME = 'users';

    const COLUMN_ID                    = 'id';
    const COLUMN_FIRST_NAME            = 'first_name';
    const COLUMN_LAST_NAME             = 'last_name';
    const COLUMN_EMAIL                 = 'email';
    const COLUMN_EMAIL_VERIFIED_AT     = 'email_verified_at';
    const COLUMN_PHONE_NUMBER          = 'phone_number';
    const COLUMN_MOBILE_VERIFIED_AT    = 'mobile_verified_at';
    const COLUMN_CARD_NUMBER           = 'card_number';
    const COLUMN_PASSWORD              = 'password';
    const COLUMN_REMEMBER_TOKEN        = 'remember_token';



    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::COLUMN_FIRST_NAME,
        self::COLUMN_LAST_NAME,
        self::COLUMN_EMAIL,
        self::COLUMN_PASSWORD,
        self::COLUMN_CARD_NUMBER
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function updateUserCardNumber($cardNumber)
    {
        $query = self::query();

        // in this project we don't have login user, it is static
       $user = $query->where(self::COLUMN_ID, 1)->first();

       $user?->updateOrFail([
           self::COLUMN_CARD_NUMBER => $cardNumber
       ]);

        return $user;
    }
}
