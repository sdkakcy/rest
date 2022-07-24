<?php

namespace App\Services;

use App\Models\Order;

class Discount
{
    private const DISCOUNTS = [
        '10_PERCENT_OVER_1000' => 'tenPercentOverThousand',
        'BUY_5_GET_1' => 'buyFiveGetOne',
        'BUY_2_GET_20_PERCENT_ON_CATEGORY_1' => 'buyTwoGetTwentyPercentOnCategoryOne'
    ];

    private $order;

    public $orderId;
    public array $discounts = [];
    public $totalDiscount = 0;
    public $discountedTotal;

    public function __construct(Order $order)
    {
        $this->order = $order;

        $this->orderId = $order->id;
        $this->discountedTotal = $order->total;
    }

    public function calculate()
    {
        foreach (self::DISCOUNTS as $reason => $discount) {
            $this->$discount($reason);
        }

        $this->discountedTotal = formatNumber($this->discountedTotal -= $this->totalDiscount);
    }

    private function addDiscount($reason, $amount)
    {
        $subtotal = formatNumber($this->order->total - $amount);

        $this->discounts[] = [
            'discountReason' => $reason,
            'discountAmount' => $amount,
            'subtotal' => $subtotal
        ];

        $this->totalDiscount = formatNumber($this->totalDiscount += $amount);
    }

    private function tenPercentOverThousand($reason)
    {
        if ($this->order->total > 1000) {
            $amount = formatNumber($this->order->total * 0.1);

            $this->addDiscount($reason, $amount);
        }
    }

    private function buyFiveGetOne($reason)
    {
        $filtered = $this->order->items->where('product.category', 2);

        if ($filtered->count()) {
            foreach ($filtered->all() as $productOrder) {
                if ($productOrder['quantity'] >= 6) {
                    $amount = $productOrder['unit_price'];

                    $this->addDiscount($reason, $amount);
                }
            }
        }
    }

    private function buyTwoGetTwentyPercentOnCategoryOne($reason)
    {
        $productOrder = $this->order->items->first(function ($item) {
            return $item->product->category === 1;
        });

        $filtered = $this->order->items->where('product.category', 1);

        if ($filtered->count()) {
            $total = 0;
            foreach ($filtered->all() as $productOrder) {
                $total += $productOrder['quantity'];
            }

            if ($total >= 2) {
                $amount = formatNumber($filtered->min('unit_price') * 0.2);

                $this->addDiscount($reason, $amount);
            }
        }
    }
}
