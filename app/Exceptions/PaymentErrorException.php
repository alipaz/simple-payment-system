<?php
namespace App\Exceptions;

use Exception;

class PaymentErrorException extends Exception
{
    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
        parent::__construct($message);
    }

    public function render()
    {
        return redirect()->route('payment.failed', ['errorMessage' => $this->message]);
    }
}

