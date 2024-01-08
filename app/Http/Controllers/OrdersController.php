<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function createOrderWithProduct(Request $request)
    {
        $orderData = $request->validate([
            'placed' => 'required|boolean',
            'total_price' => 'required|numeric',
            'total_qty' => 'required|integer',
        ]);
        $orderData['timestamp'] = Carbon::now()->format('Y-m-d H:i:s');
        $order = Order::create($orderData);

        $productsData = $request->validate([
            'products.*.category' => 'required|string',
            'products.*.brand' => 'required|string',
            'products.*.name' => 'required|string',
            'products.*.price' => 'required|numeric',
            'products.*.qty' => 'required|integer',
            'products.*.img_url' => 'nullable|url',
        ]);

        foreach ($productsData['products'] as $productData) {
            $product = OrderProduct::where('name', $productData['name'])->first();

            if ($product) {
                $order->products()->create([
                    'category' => $productData['category'],
                    'brand' => $productData['brand'],
                    'name' => $productData['name'],
                    'price' => $productData['price'],
                    'qty' => $productData['qty'],
                    'img_url' => $productData['img_url'],
                ]);

                $order->update([
                    'total_price' => $order->total_price + ($productData['price'] * $productData['qty']),
                    'total_qty' => $order->total_qty + $productData['qty'],
                ]);
            } else {
                $newProduct = $order->products()->create([
                    'category' => $productData['category'],
                    'brand' => $productData['brand'],
                    'name' => $productData['name'],
                    'price' => $productData['price'],
                    'qty' => $productData['qty'],
                    'img_url' => $productData['img_url'],
                ]);

                $order->update([
                    'total_price' => $order->total_price + ($newProduct->price * $newProduct->qty),
                    'total_qty' => $order->total_qty + $newProduct->qty,
                ]);
            }
        }

        return response()->json(['order' => $order, 'products' => $order->products], 201);
    }

    public function getOrder($id)
    {
        $order = Order::with('products')->find($id);

        if (!$order) {
            return response()->json(['error' => 'Order not found.'], 404);
        }

        return response()->json($order);
    }
}
