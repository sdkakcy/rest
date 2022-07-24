<?php

namespace App\Http\Controllers;

use App\Exceptions\OutOfStockException;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with('items')->get();

        return $orders;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $grandTotal = 0;

            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);

                if ($item['quantity'] > $product->stock) {
                    throw new OutOfStockException(__(':product ürünü için stok yetersiz.', ['product' => $product->name]));
                }

                $total = $product->price * $item['quantity'];

                $orderProducts[] = new OrderProduct([
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'total' => $total
                ]);

                $grandTotal += $total;

                $product->decrement('stock', $item['quantity']);
            }

            $order = new Order([
                'user_id' => $request->user()->id,
                'total' => $grandTotal,
            ]);

            $order->save();
            $order->items()->saveMany($orderProducts);

            DB::commit();
        } catch (OutOfStockException $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Sipariş alındı',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $order->loadMissing('items');

        return $order;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        try {
            $order->loadMissing('items');

            foreach ($order->items as $item) {
                Product::find($item->product_id)->increment('stock', $item->quantity);
            }

            $order->delete();

            $result = [
                'success' => true,
                'message' => __('Sipariş silindi')
            ];
        } catch (\Exception $e) {
            $result = [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }

        return response()->json($result);
    }
}
