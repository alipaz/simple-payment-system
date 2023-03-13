<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    use HasFactory;

    const TABLE_NAME = 'orders';

    const  COLUMN_ID                      = 'id';
    const  COLUMN_USER_ID                 = 'user_id';
    const  COLUMN_STATUS                  = 'status';
    const  COLUMN_PURCHASED_AT            = "purchased_at";
    const  COLUMN_TOTAL_COST              = "total_cost";
    const  COLUMN_PRODUCT_TITLE           = "product_title";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::COLUMN_USER_ID,
        self::COLUMN_STATUS,
        self::COLUMN_PURCHASED_AT,
        self::COLUMN_TOTAL_COST,
    ];
}
