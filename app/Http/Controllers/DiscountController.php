<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\Discount;

class DiscountController extends Controller
{
    /**
     * Calculate order discounts
     *
     * @param Order $order
     * @return \Illuminate\Http\Response
     */
    public function discounts(Order $order)
    {
        try {
            $order->loadMissing(['items', 'items.product']);

            $discounts = new Discount($order);
            $discounts->calculate();

            return get_object_vars($discounts);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
