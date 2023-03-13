<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Payment extends Model
{

    use HasFactory;

    const TABLE_NAME                  = 'payments';

    const COLUMN_ORDER_ID             = 'order_id';
    const COLUMN_USER_ID              = 'user_id';
    const COLUMN_AMOUNT               = 'amount';
    const COLUMN_PAYED_AT             = 'payed_at';
    const COLUMN_ONLINE_PAYMENT_TOKEN = 'online_payment_token';
    const COLUMN_REFERENCE_NUMBER     = 'reference_number';
    const COLUMN_STATUS               = 'status';
    const COLUMN_TRACKING_CODE        = 'tracking_code';
    const COLUMN_TRANSACTION_ID       = 'transaction_id';
    const COLUMN_CARD_NUMBER          = 'card_number';

    /**
     * payment statuses
     */
    const STATUS_WAITING = 'waiting';
    const STATUS_SUCCESS = 'success';
    const STATUS_FAILED  = 'failed';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::COLUMN_USER_ID,
        self::COLUMN_ORDER_ID,
        self::COLUMN_STATUS,
        self::COLUMN_AMOUNT,
        self::COLUMN_PAYED_AT,
        self::COLUMN_ONLINE_PAYMENT_TOKEN,
        self::COLUMN_REFERENCE_NUMBER,
        self::COLUMN_TRACKING_CODE,
        self::COLUMN_TRANSACTION_ID,
        self::COLUMN_CARD_NUMBER,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * @param $paymentReferenceNumber
     * @return $this|null
     */
    public function getPaymentByReferenceNumber($paymentReferenceNumber): ?self
    {
        $query = self::query();

        $query->where(self::COLUMN_REFERENCE_NUMBER, $paymentReferenceNumber);

        return $query->firstOrFail();
    }

    /**
     * @param array $paymentData
     * @return mixed
     */
    public function storeNewPayment(array $paymentData): mixed
    {
        return  DB::transaction(function () use ($paymentData){
            Payment::create([
                Payment::COLUMN_ORDER_ID                  => $paymentData['order_id'],
                Payment::COLUMN_AMOUNT                    => $paymentData['payment_amount'],
                Payment::COLUMN_ONLINE_PAYMENT_TOKEN      => $paymentData['token'],
                Payment::COLUMN_REFERENCE_NUMBER          => $paymentData['ref_num'],
                Payment::COLUMN_USER_ID                   => 1,
                Payment::COLUMN_STATUS                    => Payment::STATUS_WAITING
            ]);
        });

    }


    /**
     * @param $payment
     * @param object $newData
     * @return mixed
     */
    public function updatePaymentWhenSuccess($payment, object $newData): mixed
    {
         DB::transaction(function () use ($payment ,$newData) {
            $payment->updateOrFail([
                Payment::COLUMN_REFERENCE_NUMBER   => $newData->ref_num,
                Payment::COLUMN_TRANSACTION_ID     => $newData->transaction_id,
                Payment::COLUMN_TRACKING_CODE      => $newData->tracking_code,
                Payment::COLUMN_CARD_NUMBER        => $newData->card_number,
            ]);
        });
        return $payment;
    }

    /**
     * @param $payment
     * @return mixed
     */
    public function updatePaymentStatusWhenPaymentVerified($payment): mixed
    {
        DB::transaction(function () use ($payment) {
            $payment->updateOrFail([
                Payment::COLUMN_STATUS             => Payment::STATUS_SUCCESS,
                Payment::COLUMN_PAYED_AT           => Carbon::now(),
            ]);
        });
        return $payment;
    }


    /**
     * @param $paymentReferenceNumber
     * @return \Illuminate\Database\Eloquent\HigherOrderBuilderProxy|mixed|string
     */
    public function getUserCardNumberWithReferenceNumber($paymentReferenceNumber)
    {
        $query = self::query();

       $payment = $query->where(self::COLUMN_REFERENCE_NUMBER, $paymentReferenceNumber)->first();

        $userCardNumber = $payment?->user?->card_number;

        return $userCardNumber ?? '';
    }




}
