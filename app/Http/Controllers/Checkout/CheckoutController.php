<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CheckoutController extends Controller
{

    /**
     * @param Order $order
     * @return View
     */
    public function show(Order $order): View
    {
        return view('checkout.show', compact('order'));
    }
}
